<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class WechatShare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $result = DB::table("wxuser")->where("openid",$_SESSION['wechat_user']['id'])->get(["code"])->first();
        $code = $result->code;
        view()->share('user',$code);
        return $next($request);
    }
}
