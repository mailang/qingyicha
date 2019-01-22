<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Src\base;
use  App\Models\Wxuser;

class PayController extends Controller
{
    //
    /*生成订单,并发起支付*/
    function  order_create()
    {
        $openid='o3MeN5knIrECm5dZys4nrOVRc5Ow';//$_SESSION['wechat_user']['id'];
        $user=Wxuser::where('openid',$openid)->first();
        $base=new base();
        $order_No=$base->No_create($user["id"]);//获取订单号
        $app = app('wechat.official_account');
        $result = $app->order->unify([
            'body' => '腾讯充值中心-QQ会员充值',
            'out_trade_no' => $order_No,
            'total_fee' => 88,
            'spbill_create_ip' => '123.12.12.123', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
            'notify_url' => 'https://pay.weixin.qq.com/wxpay/pay.action', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
            'openid' => 'oUpF8uMuAJO_M2pxb1Q9zNjWeS6o',
        ]);
         dd($order_No);

    }


    /* 支付回调 */
    function pay_notify()
    {
     return 1;

    }
}
