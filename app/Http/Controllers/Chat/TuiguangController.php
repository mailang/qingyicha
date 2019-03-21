<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wxuser;

class TuiguangController extends Controller
{
    function tuiguang()
    {
        $openid='offTY1fb81WxhV84LWciHzn4qwqU';//$_SESSION['wechat_user']['id'];
        $user=Wxuser::where('openid',$openid)->first();
        $code=$user->code;
        $app = app('wechat.official_account');
        $result = $app->qrcode->temporary($code, 6 * 24 * 3600);
        $ticket=$result["ticket"];
        $url = $app->qrcode->url($ticket);
        return view('wechat.my.erweima',compact('url'));
    }
}
