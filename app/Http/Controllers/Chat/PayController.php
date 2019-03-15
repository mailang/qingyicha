<?php

namespace App\Http\Controllers\Chat;

use App\Models\Order;
use App\Models\Order_refund;
use App\Models\Order_result;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Src\base;
use  App\Models\Wxuser;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Monolog\Handler\ElasticSearchHandler;
use Illuminate\Support\Facades\DB;
use Qcloud\Sms\SmsSingleSender;
use App\Models\Authorization;

class PayController extends Controller
{
    function  configSignature()
    {
        $app = app('wechat.official_account');
        return $app->jssdk->buildConfig(array('chooseWXPay'), true);//$app->configSignature();
    }
    /*发送验证码*/
    function Sendsms($phone)
    {
        $bool="验证码发送失败";
        $qcode=config('qsms');
        try {
            $ssender = new SmsSingleSender($qcode["appid"], $qcode["appkey"]);
            //$params = ["952700"];//数组具体的元素个数和模板中变量个数必须一致，例如事例中 templateId:5678对应一个变量，参数数组中元素个数也必须是一个
              $params= mt_rand(100001,999999);
            $result = $ssender->sendWithParam("86", $phone,$qcode["templateId"],
                [$params], $qcode["smsSign"], "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
            $rsp = json_decode($result);
            //{"result":0,"errmsg":"OK","ext":"","sid":"8:OSHaXqBpq57E3b5Fokz20190313","fee":1}
              if ($rsp->result==0&&$rsp->errmsg=="OK") {
                  $openid = $_SESSION['wechat_user']['id'];
                  $time = Date('Y-m-d H:i:s');
                  $expired = date('Y-m-d H:i:s',strtotime('+ 1 hour'));
                  DB::insert('insert into user_validate(result_code,openid,url,code,phone,expired,created_at) values(?,?,?,?,?,?.?)', [$result, $openid, "Qcode", $params,$expired,$phone,$time]);
               $bool="验证码已发送";
              }
        } catch(\Exception $e) {
            echo var_dump($e);
        }
        return $bool;
    }
    /*生成订单前验证码验证
     return -1：验证码不正确，-2：验证码已过期；1：验证通过
    */
    function validate_code($phone,$code)
    {
       $list=DB::table('user_validate')
           ->where('phone',$phone)
           ->where('code',$code)
           ->orderByDesc('created_at')->get(["code",'expired']);
        if (count($list)>0)
        {
            $first=$list->first();
          if (strtotime($first->expired)>time()) return 1;
          else return -2;
        }
        else return -1;
    }
    /*基础查询生成订单,并发起支付*/
    function  order_create($id)
    {
       //return '{"appId":"wxaffee917b46f14d8","nonceStr":"5c46d829ee4c6","package":"prepay_id=wx221645424410449e96a87f0b2066641826","signType":"MD5","paySign":"6C4600732B204DA08AEC02283C997BE3","timestamp":"1548146729"}';
        $name=$_POST["name"];
        $idCard=$_POST["cardNo"];
        $phone=$_POST["phone"];
        $telcode=$_POST["telcode"];
        $bool=$this->validate_code($phone,$telcode);//$this->validate_code($name,$idCard,$phone,$telcode);
        if($bool>0)
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
             $data["auth_id"]=$user["auth_id"];
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
             DB::table('person_attach')->insert($attach);
            return json_encode($config);
        }
        else return -3;
    }
    else
    {
     //   -1：验证码不正确，-2：验证码已过期；
    return $bool;
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

    function order_payback($order_id){
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
