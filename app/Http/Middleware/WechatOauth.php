<?php

namespace App\Http\Middleware;

use Closure;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;

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
        $app = app('wechat.official_account');
        $oauth = $app->oauth;
        //dd($oauth);
        // 未登录
        if (empty($_SESSION['wechat_user']))
        {
            $_SESSION['target_url'] = $request->url();
            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            //// $oauth->redirect()->send();
        }
        Log::info($_SESSION['wechat_user']);
           // 已经登录过
           $user = $_SESSION['wechat_user'];
        return $next($request);
    }
}
