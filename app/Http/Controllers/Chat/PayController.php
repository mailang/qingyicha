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
         dd($order_No);

    }


    /* 支付回调 */
    function pay_notify()
    {
     return 1;

    }
}
