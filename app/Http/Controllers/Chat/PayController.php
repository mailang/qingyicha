<?php

namespace App\Http\Controllers\Chat;

use App\Models\Authorization;
use App\Models\Order;
use App\Models\Order_refund;
use App\Models\Order_result;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Src\base;
use  App\Models\Wxuser;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Qcloud\Sms\SmsSingleSender;
use App\Models\Return_fee;
use  App\Models\Person_attach;

class PayController extends Controller
{
    function  configSignature()
    {
        $app = app('wechat.official_account');
        return $app->jssdk->buildConfig(array('chooseWXPay'), true);//$app->configSignature();
    }
    /*获取短信认证的验证码*/
    function  ytx_code($name,$idCard,$phone)
    {
        $path='https://rip.linrico.com/userAuthorization/addSMS?';
        $prams='username=shbd&accessToken=40db8b4b95ac91ed6e905c80d45ebac5'."&name=".$name.'&idCard='.$idCard."&phone=".$phone;
        $url=$path.$prams;
        $base=new base();
        $output=$base->get_curl($url);
        if ($output!=null&&$output!='')
        {
            //{"success": true,"message": "该用户已经授权","code": 0,"timestamp": 1551942308648 }
            $msg=json_decode($output);
            return $msg->message;
        }
        return "服务出错";
    }
    /*存储验证码验证存储*/
    function ytx_store($name,$idCard,$phone,$telcode)
    {
        $path='https://rip.linrico.com/userAuthorization/input?';
        //用户验证成功
        $prams='username=shbd&accessToken=40db8b4b95ac91ed6e905c80d45ebac5'."&name=".urlencode($name).'&idCard='.urlencode($idCard)."&phone=".urlencode($phone)."&securityCode=".urlencode($telcode);
        $url=$path.$prams;
        $base=new base();
        $output=$base->get_curl($url);
        //$output ="{\"success\":true,\"message\":\"短信认证通过，已完成授权\",\"code\":0,\"timestamp\":1550640489731}";
        if ($output!=null&&$output!='')
        {
            //用户验证成功
            $re=array();
            $openid=$_SESSION['wechat_user']['id'];
            $time=date('Y-m-d h:i:s');
            $expired = date('Y-m-d H:i:s',strtotime('+ 1 hour'));
            DB::insert('insert into user_validate(result_code,openid,url,code,phone,expired,created_at) values(?,?,?,?,?,?,?)', [$output, $openid, $url, "",$phone,$expired,$time]);
            $msg=json_decode($output);
            if ($msg->code=='0'&&$msg->success)
            {
                $data["openid"]=$openid;
                $data["name"]=$name;
                $data["cardNo"]=$idCard;
                $data["phone"]=$phone;
                $data["phone"]=$phone;
                $data["created_at"]=$time;
                $data["updated_at"]=$time;
                $id=DB::table('authorization')->insertGetId($data);
                $re["state"]=1;$re["msg"]="";
            }
            else
            {  $re["state"]=-1;$re["msg"]=$msg->message;}
        } else {$re["state"]=-2;$re["msg"]="上游接口返回数据不正确";}
        return $re;
    }
    /*发送验证码*/
    function Sendsms()
    {   $type='ytx';
        $name=urlencode($_GET["name"]);
        $idCard=urlencode($_GET["cardNo"]);
        $phone=urlencode($_GET["phone"]);
        $re=$this->ytx_code($name,$idCard,$phone);
        if ($re=="该用户已经授权")
        {
            /*已授权用户判断是否和实名库里存储一致*/
            $auth = Authorization::where("name",$name)
                ->where("cardNo",$idCard)
                ->where("phone",$phone)
                ->get();
            if (count($auth)>0){
                /*与实名库中一致调用腾讯云发送短信*/
                $qcode=config('qsms');
                try {
                    $ssender = new SmsSingleSender($qcode["appid"], $qcode["appkey"]);
                    //数组具体的元素个数和模板中变量个数必须一致，例如事例中 templateId:5678对应一个变量，参数数组中元素个数也必须是一个
                    $params= mt_rand(100001,999999);
                    $result = $ssender->sendWithParam("86", $phone,$qcode["templateId"],
                        [$params], $qcode["smsSign"], "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
                    $rsp = json_decode($result);
                    //{"result":0,"errmsg":"OK","ext":"","sid":"8:OSHaXqBpq57E3b5Fokz20190313","fee":1}
                    if ($rsp->result==0&&$rsp->errmsg=="OK") {
                        $openid = $_SESSION['wechat_user']['id'];
                        $time = Date('Y-m-d H:i:s');
                        $expired = date('Y-m-d H:i:s',strtotime('+ 1 hour'));
                        DB::insert('insert into user_validate(result_code,openid,url,code,phone,expired,created_at) values(?,?,?,?,?,?,?)', [$result, $openid, "Qcode", $params,$phone,$expired,$time]);
                        $re="短信发送成功";
                        $type='qsms';
                    }
                } catch(\Exception $e) {
                    echo var_dump($e);
                }

            }
            else {
                $re = "短信鉴权，需本人实名手机号！";
            }

        }
        return json_encode(array("msg"=>$re,"type"=>$type));
    }
    /*生成订单前验证码验证
     return -1：验证码不正确，-2：验证码已过期；1：验证通过
    */
    function validate_code($phone,$code)
    {
        $re=array();
       $list=DB::table('user_validate')
           ->where('phone',$phone)
           ->where('code',$code)
           ->orderByDesc('created_at')->get(["code",'expired']);
        if (count($list)>0)
        {
            $first=$list->first();
          if (strtotime($first->expired)>time()){  $re["state"]=1;$re["msg"]="";}
          else {  $re["state"]=-2;$re["msg"]="验证码不正确";}
        }
        else {  $re["state"]=-1;$re["msg"]="验证码已过期";}

        return $re;
    }
    /*基础查询生成订单,并发起支付*/
    function  order_create($id)
    {
       //return '{"appId":"wxaffee917b46f14d8","nonceStr":"5c46d829ee4c6","package":"prepay_id=wx221645424410449e96a87f0b2066641826","signType":"MD5","paySign":"6C4600732B204DA08AEC02283C997BE3","timestamp":"1548146729"}';
        $name=$_POST["name"];
        $idCard=$_POST["cardNo"];
        $phone=$_POST["phone"];
        $telcode=$_POST["telcode"];
        $smstype=$_POST["type"];
        if ($smstype=="qsms")
        $re=$this->validate_code($phone,$telcode);
        else {if ($smstype=="ytx") $re=$this->ytx_store($name,$idCard,$phone,$telcode);}
        if(isset($re["state"])&&$re["state"]>0)
        {
            $app = app('wechat.payment');
        $jssdk = $app->jssdk;
        $openid=$_SESSION['wechat_user']['id'];//'offTY1fb81WxhV84LWciHzn4qwqU';
        $user=Wxuser::where('openid',$openid)->first();
        $base=new base();
        $order_No=$base->No_create($user["id"]);//获取订单号
        $product=Product::find($id);
        $result = $app->order->unify([
            'body' => '普信天下'.$product->pro_name,
            'out_trade_no' => $order_No,
            'total_fee' => $product->price*100,
            'spbill_create_ip' =>'123.206.254.31', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
            'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
            'openid' => $openid,
        ]);
        if (strtolower($result["return_code"])=='success')
        {
             $config = $jssdk->sdkConfig($result["prepay_id"]); // 返回数组
             $data["openid"]=$openid;
             $data["wxuser_id"]=$user["id"];
             //$data["auth_id"]=$user["auth_id"];
             $data["out_trade_no"]=$order_No;
             $data["body"]='普信天下'.$product->pro_name;
             $data["total_fee"]=$product->price;
             $data["time_start"]=date('Y-m-d H:i:s');
             $data["time_expire"]=date('Y-m-d H:i:s',strtotime('+ 1 hour'));
             $data["pro_id"]=$id;
             $data["created_at"]=date('Y-m-d H:i:s');
             $data["updated_at"]=date('Y-m-d H:i:s');
             $order_id=DB::table('order')->insertGetId($data);
             $config["order_id"]=$order_id;
             $attach["openid"]=$openid;
             $attach["order_id"]=$order_id;
             $attach["name"]=$name;
             $attach["phone"]=$phone;
             $attach["cardNo"]=$idCard;
             Person_attach::create($attach);
             $config["state"]=1;
            return json_encode($config);
        }
        else return json_encode(array("state"=>0,"msg"=>"下单失败"));
    }
    else
    {
     //   -1：验证码不正确，-2：验证码已过期；
    return json_encode($re);
    }
    }
    /*未付款订单重新支付*/
    function re_create($order_id)
    {
        $app = app('wechat.payment');
        $jssdk = $app->jssdk;
        $order=Order::find($order_id);
        $product=Product::find($order["pro_id"]);
        $result = $app->order->unify([
            'body' => '普信天下'.$product->pro_name,
            'out_trade_no' => $order["out_trade_no"],
            'total_fee' => $product->price*100,
            'spbill_create_ip' =>'123.206.254.31', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
            'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
            'openid' => $order["openid"],
        ]);
        if (strtolower($result["return_code"])=='success') {
            $config = $jssdk->sdkConfig($result["prepay_id"]); // 返回数组
            $config["order_id"] = $order_id;
            return \GuzzleHttp\json_encode($config);
        }
        else return '{result_code:success}';
    }
    /* 支付回调 */
    function pay_notify()
    {
        $app = app('wechat.payment');
        $response = $app->handlePaidNotify(function($message, $fail){
            $data["result"]=file_get_contents("php://input");
            $data["openid"]=$message["openid"];
            $data["out_trade_no"]=$message["out_trade_no"];
            $data["transaction_id"]=$message["transaction_id"];
            $data["return_code"]=$message["return_code"];
            $data["result_code"]=$message["result_code"];
            if(strtolower($message['return_code']) === 'success') { // return_code 表示通信状态，不代表支付状态
                $order = Order::where('out_trade_no',$message['out_trade_no'])->first();
                if ($order)
                {
                    // 用户是否支付成功
                     $data["order_id"]=$order["id"];
                    if (array_get($message, 'result_code') === 'SUCCESS') {
                        $order["state"]=1;
                        $order["time_pay"]=$message["time_end"];
                        $order["transaction_id"]=$message["transaction_id"];
                        $order["cash_fee"]=$message["cash_fee"];

                        // 用户支付失败
                    } elseif (array_get($message, 'result_code') === 'FAIL') {
                        $order["state"]=-2;
                    }
                    $order->save();
                }
                else
                    return $fail('订单号不存在');

            } else {
                return $fail('通信失败，请稍后再通知我');
            }
            Order_result::create($data);
              return true;
    });
    $response->send(); // return $response;

    }

    /*   "return_code" => "SUCCESS"
  "return_msg" => "OK"
  "appid" => "wxaffee917b46f14d8"
  "mch_id" => "1524529661"
  "nonce_str" => "F5mK5YUPjViw7pvc"
  "sign" => "D9D9F65F40A35BC28B85EEB9E886F517"
  "result_code" => "SUCCESS"
  "openid" => "offTY1fb81WxhV84LWciHzn4qwqU"
  "is_subscribe" => "Y"
  "trade_type" => "JSAPI"
  "bank_type" => "CFT"
  "total_fee" => "1"
  "fee_type" => "CNY"
  "transaction_id" => "4200000264201901235160686715"
  "out_trade_no" => "201901230741392675"
  "attach" => null
  "time_end" => "20190123154144"
  "trade_state" => "SUCCESS"
  "cash_fee" => "1"
  "trade_state_desc" => "支付成功"
         */

    /*微信退款*/
    function  refund($order_id)
    {
        $app = app('wechat.payment');
        $order=Order::find($order_id);
        if ($order['state']!=-3)
        {
            $out_trade_no=$order["out_trade_no"];
            $result= $app->order->queryByOutTradeNumber($out_trade_no);
            if ($result["return_code"]=="SUCCESS") {
                if ($result["result_code"] == 'SUCCESS') {
                  if (isset($result["transaction_id"]))
                    $data["transaction_id"] = $result["transaction_id"];
                  else
                  {
                      if (isset($result["trade_state"])&&$result["trade_state"]=='NOTPAY')return $result["trade_state_desc"];
                  }
                    $base = new base();
                    $data["refundNumber"] = $base->No_create($order_id);//获取订单号
                    $data["totalFee"] = $order["total_fee"] * 100;//单位转化
                    $data["refundFee"] = $order["total_fee"] * 100;
                    $refund = $app->refund->byTransactionId($data["transaction_id"], $data["refundNumber"], $data["totalFee"], $data["totalFee"], ['refund_desc' => 'test',]);
                    // 可在此处传入其他参数，详细参数见微信支付文档
                    if ($refund["return_code"] == 'SUCCESS') {
                        if ($refund["result_code"] == 'SUCCESS')
                        {
                            $data["order_id"]=$order_id;
                            $data["openid"]=$order["openid"];
                            $data["out_trade_no"]=$order["out_trade_no"];
                            $data["total_fee"]=$order["total_fee"];
                            $data["refund_fee"]=$order["refund_fee"]/100;
                            $data["refund_id"]=$order["refund_id"];
                            Order_refund::create($data);
                            $order["state"]=-3;//修改订单状态
                            $order->save();
                            return "退款申请成功";
                        }
                        else
                            return $refund["err_code_des"];
                    } else
                        return $refund["return_msg"];

                } else
                {
                    return "订单未付款";
                }
            }
            else return $result["return_msg"];

        }
        else
            return "订单不存在";

    }
    /*自定义支付完成跳转页面
    如果有推荐人，则往返现表填满数据
    */
    function order_payback($order_id){
        $openid = $_SESSION['wechat_user']['id'];;
        $wxuser=Wxuser::where('openid',$openid)->get();
        if(count($wxuser)>0)
        {
            $user=$wxuser->first();
            if ($user["referee"]!=null&&$user["referee"]!='')
            {
              $list=DB::table('product')->leftJoin('order','product.id','=','order.pro_id')
               ->get(['product.return_fee','order.id','order.pro_id','order.total_fee'])->first();
               $fee["pro_id"]=$list->pro_id;
               $fee["order_id"]=$list->id;
                $fee["referee"]=$user->referee;
                $fee["openid"]=$openid;
               $fee["fee"]=$list->return_fee;
               $fee["price"]=$list->total_fee;
               $fee["state"]=0;
                Return_fee::create($fee);
            }
        }
        return view("wechat.credit.payback",compact("order_id"));
    }
    /*
     *  [▼
  "return_code" => "SUCCESS"
  "return_msg" => "OK"
  "appid" => "wxaffee917b46f14d8"
  "mch_id" => "1524529661"
  "nonce_str" => "eDqROSUf2uVy1ke6"
  "sign" => "244B1167F9D0D5442D43ABD8BC0C2B25"
  "result_code" => "SUCCESS"
  "transaction_id" => "4200000264201901235160686715"
  "out_trade_no" => "201901230741392675"
  "out_refund_no" => "201901240802211554"
  "refund_id" => "50000309592019012408142124453"
  "refund_channel" => null
  "refund_fee" => "1"
  "coupon_refund_fee" => "0"
  "total_fee" => "1"
  "cash_fee" => "1"
  "coupon_refund_count" => "0"
  "cash_refund_fee" => "1"
]
     */

}
