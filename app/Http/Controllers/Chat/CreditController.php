<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wxuser;
use App\Models\Order;
use App\Models\Authorization;
use App\Models\User_interface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Src\base;

class CreditController extends Controller
{
    /*征信查询*/
  function  apply()
  {
      /*查看用户是否认证，认证了进协议页面，没有认证进入认证页面*/
      $openid=$_SESSION['wechat_user']['id'];
      $user=Wxuser::where('openid',$openid)->first();
      if ($user["auth_id"]!=null&&$user["auth_id"]>0)
      {
            /*已认证*/
            $order=Order::where('auth_id',$user['auth_id'])->where('state','>','0')->orderByDesc('id')->limit(1)->get(['id','state']);
            if ($order->first())
            {
                $odata=$order->first();
                if ($odata['state']==1)
                {
                    /*已付款未查询接口*/
                    $oauth=Authorization::find($user['auth_id']);
                    return view('wechat.credit.apply',compact($oauth));
                }
                if ($odata['state']==2)
                {
                    /*查询是否有查询失败的接口，失败的接口可以重新查询*/
                    $fail=User_interface::where('state','0');
                    if (count($fail)>0)
                    {
                        $oauth=Authorization::find($user['auth_id']);
                        return view('wechat.credit.apply',compact($oauth));
                    }
                    else
                    {
                        /*不存在查询失败的接口，可以重新支付查询最新的接口*/
                        return view('wechat.credit.xieyi');
                    }
                }
            }
            else
            {
                /*不存在支付完成的订单，弹出协议让用户下单支付*/
                return view('wechat.credit.xieyi');
            }
      }
      else
      {
          /*未认证用户*/
          return view('wechat.credit.validate');
      }
  }

  /*获取短信认证的验证码*/
  function  validate_code()
  {
        $path='https://rip.linrico.com/userAuthorization/addSMS?';
        $name=urlencode($_GET["name"]);
        $idCard=urlencode($_GET["cardNo"]);
        $phone=urlencode($_GET["phone"]);
        $prams='username=shbd&accessToken=40db8b4b95ac91ed6e905c80d45ebac5'."&name=".$name.'&idCard='.$idCard."&phone=".$phone;
        $url=$path.$prams;
        $base=new base();
        $output=$base->get_curl($url);
         if ($output!=null&&$output!='')
         {
             $msg=\GuzzleHttp\json_decode($output);
             return $msg->message;
         }
         return "服务出错";
  }
  /*存储*/
  function validate_store()
  {
      $path='https://rip.linrico.com/userAuthorization/input?';
      $name=urlencode($_POST["name"]);
      $idCard=urlencode($_POST["cardNo"]);
      $phone=urlencode($_POST["phone"]);
      $telcode=urlencode($_POST["telcode"]);
      //用户验证成功
      $prams='username=shbd&accessToken=40db8b4b95ac91ed6e905c80d45ebac5'."&name=".$name.'&idCard='.$idCard."&phone=".$phone."&securityCode=".$telcode;
      $url=$path.$prams;
      $base=new base();
      $output=$base->get_curl($url);
      if ($output!=null&&$output!='')
      {
          $msg=\GuzzleHttp\json_decode($output);
          if ($msg->code=='1001'&&$msg->success)
          {
              //用户验证成功
              $openid=$_SESSION['wechat_user']['id'];
              $data["openid"]=$openid;
              $data["name"]=$name;
              $data["cardNo"]=$idCard;
              $data["phone"]=$phone;
              $id=DB::table('authorization')->insertGetId($data);
              if ($id)
              {
                  $user=Wxuser::where('openid',$openid)->first();
                  $user["auth_id"]=$id;
                  $user->save();
              }
              return "认证成功";
          }
          else
          return $msg->message;
      }
      return "服务出错";

  }
  /*生成订单*/
  function  order_create()
  {


  }

}
