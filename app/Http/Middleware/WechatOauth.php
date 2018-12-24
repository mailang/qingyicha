<?php

namespace App\Http\Middleware;

use Closure;

class WechatOauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * 微信授权认证
     */
    public function handle($request, Closure $next)
    {
        if (empty(session("id"))){
            $user = session('wechat.oauth_user');
            $openid = $user['id'];
            //检测数据库中用户账号和微信号是否绑定
        $result="200";// = WxStudent::check_boundwechat($openid);
        if ($result=='200'){
            return $next($request);
        }else{
            return response("请登录", 403)->header("X-CSRF-TOKEN", csrf_token());
        }
    } else if(!empty(session("id"))) {
            return $next($request);
        }
        return $next($request);
    }
}
