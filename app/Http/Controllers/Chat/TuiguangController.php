<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wxuser;

class TuiguangController extends Controller
{
    function tuiguang()
    {
        $openid=$_SESSION['wechat_user']['id'];
        $user=Wxuser::where('openid',$openid)->first();
        $code=$user->code;
        $app = app('wechat.official_account');
        $result = $app->qrcode->temporary($code, 6 * 24 * 3600);
        $url=$result["url"];
        return view('wechat.my.erweima',compact('url'));
    }
}
