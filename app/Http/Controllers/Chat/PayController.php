<?php

namespace App\Http\Controllers\Chat;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Src\base;
use  App\Models\Wxuser;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class PayController extends Controller
{
    function  configSignature()
    {
        $app = app('wechat.official_account');
        return $app->jssdk->buildConfig(array('chooseWXPay'), true);//$app->configSignature();
    }
    //
    /*生成订单,并发起支付*/
    function  order_create($id)
    {
    //return '{"appId":"wxaffee917b46f14d8","nonceStr":"5c46d829ee4c6","package":"prepay_id=wx221645424410449e96a87f0b2066641826","signType":"MD5","paySign":"6C4600732B204DA08AEC02283C997BE3","timestamp":"1548146729"}';
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
             $data["out_trade_no"]=$order_No;
             $data["body"]='普信天下'.$product->pro_name;
             $data["total_fee"]=$product->price;
             $data["time_start"]=date('Y-m-d H:i:s');
             $data["time_expire"]=date('Y-m-d H:i:s',strtotime('+ 1 h'));
             $data["pro_id"]=$id;
             Order::create($data);
            return  \GuzzleHttp\json_encode($config);
        }
        else return '{result_code:success}';
    }

    /* 支付回调 */
    function pay_notify()
    {
        $data1['openid']="offTY1fb81WxhV84LWciHzn4qwqU";
        $data1["result"]="进入到了回调地址里";
        $data1["created_at"]=date('Y-m-d H:i:s');
        \DB::table('record')->insert($data1);
        $app = app('wechat.payment');
        $response = $app->handlePaidNotify(function($message, $fail){
            $data2['openid']="notify";
            $data2["result"]="进入到了PaidNotify";
            \DB::table('record')->insert($data2);
            Log::info(var_export($message));
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $data['openid']="offTY1fb81WxhV84LWciHzn4qwqU";
            $data["result"]=var_export($message);
            \DB::table('record')->insert($data);
            //<- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////
            if(strtolower($message['return_code']) === 'success') { // return_code 表示通信状态，不代表支付状态
                $order = Order::where('out_trade_no',$message['out_trade_no'])->first();
                if ($order )
                {
                    // 用户是否支付成功
                    if (array_get($message, 'result_code') === 'SUCCESS') {
                        //$order->paid_at = time(); // 更新支付时间为当前时间
                        $order["state"]=1;
                        // 用户支付失败
                    } elseif (array_get($message, 'result_code') === 'FAIL') {
                        $order["state"]=-2;
                    }
                }
                else
                    return $fail('订单号不存在');
            } else {
                return $fail('通信失败，请稍后再通知我');
            }
              return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
    });
    $response->send(); // return $response;
    }

    /*微信退款*/
    function  refund($order_id)
    {
        $app = app('wechat.official_account');
        $order=Order::find($order_id);
        $data["transaction_id"]=$order["transaction_id"];
        $base=new base();
        $data["refundNumber"]=$base->No_create($order_id);//获取订单号
        $data["totalFee"]=$data["refundFee"]=$order["actual_fee"];
        $app->refund->byTransactionId(  $data["transactionId"],  $data["refundNumber"],  $data["totalFee"],  $data["totalFee"],[ 'refund_desc' => 'test',]);
       // 可在此处传入其他参数，详细参数见微信支付文档


    }
}
