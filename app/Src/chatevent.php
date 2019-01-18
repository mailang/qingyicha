<?php
namespace App\Src;
use App\Models\Wxuser;
use EasyWeChat\Kernel\Messages\Image;
use Illuminate\Support\Facades\Log;

class  chatevent
{
    public static  function  handle_event($message)
    {
        $result="";
        switch (strtolower($message["Event"])) {
            case "subscribe":$result = chatevent::subscribe($message["FromUserName"]); break;
            case "unsubscribe":chatevent::unsubscribe($message["FromUserName"]); break;
            case "click":if($message["EventKey"]=="qyctuiguang")  $result=chatevent::generate_tuiguang($message["FromUserName"]);break;
            default : break;
        }
        return $result;
    }
    /*公众号关注
     *判断用户之前是否已经关注
     * 推荐码扫码访问或者后期添加
     */
    static function  subscribe($openid)
    {
        $user=Wxuser::where('openid',$openid);
        if ($user->first()){
            $data=$user->first();
            $data["subscribe"]="subscribe";
            $data["openid"]=$openid;
            $data->save();}
        else
        {
            $data["subscribe"]="subscribe";
            $data["openid"]=$openid;
            $base=new base();
            $data["code"]=$base->code();
            Wxuser::create($data);
        }
        $path=resource_path('json/chat.json');
        $content=file_get_contents($path);
        $data=\GuzzleHttp\json_decode($content);
        return  $data[0]->subscribe;
    }

    /*
     * 取消关注
     *更新subscribe值
     */
    static function  unsubscribe($openid)
    {
        $user=Wxuser::where('openid',$openid);
        if ($user->first())
        {
            $data=$user->first();
            $data["subscribe"]="unsubscribe";
            $data["openid"]=$openid;
            $data->save();
        }
    }

    /**
     * @return
     *  {
     *   "media_id":MEDIA_ID,
     *    "url":URL
     *}
     */
    static function generate_tuiguang($openid)
    {
        $app = app('wechat.official_account');
        $base=new base();
        $user=Wxuser::where('openid',$openid)->first();
        $pgurl=$base->erweima(route('weixin.tuiguang')."?openid=".$openid."&qyc_code=".$user["code"]);
        $result = $app->material->uploadImage($pgurl);
        if (isset($result["errmsg"]))
            return $result["errmsg"];
        else
        return new Image($result["media_id"]);
    }

}