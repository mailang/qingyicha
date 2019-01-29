<?php

namespace App\Http\Controllers\Chat;

use App\Models\Interfaces;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wxuser;
use App\Models\Order;
use App\Models\Authorization;
use App\Models\User_interface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Src\base;
use App\Models\Product;

class CreditController extends Controller
{
    function testapply()
    {
        $oauth=Authorization::find(4);
        $order_id=1;
        return view('wechat.credit.apply',compact('oauth','order_id'));
    }
    /*征信查询*/
  function  apply()
  {
      /*查看用户是否已经购买，购买后看是否已认证*/
      $id=$_GET["proid"];
      $openid='offTY1fb81WxhV84LWciHzn4qwqU';//$_SESSION['wechat_user']['id'];
      $order=Order::where('pro_id',$id)->where('state','>','0')->orderByDesc('id')->limit(1)->get(['id','state']);
      if ($order->first())
      {
          $user=Wxuser::where('openid',$openid)->first();
          if ($user["auth_id"]!=null&&$user["auth_id"]>0)
          {
              /*已认证*/
              $odata=$order->first();
              //订单状态 0:未支付1：已付款，2：征信接口已成功查询；3.接口已查询存在异常接口-1：超时未支付的无效订单
              switch ($odata['state'])
              {
                  case 1:  /*已付款未查询接口*/
                      $oauth=Authorization::find($user['auth_id']);
                      $order_id=$odata['id'];
                      return view('wechat.credit.apply',compact('oauth','order_id')); break;
                  case 3: $oauth=Authorization::find($user['auth_id']);
                      $order_id=$odata['id'];
                      return view('wechat.credit.apply',compact('oauth','order_id')); break;
                  default:/*不存在查询失败的接口，可以重新支付查询最新的接口*/
                      return view('wechat.credit.xieyi'); break;
              }
          }
          else
          {
              /*未认证用户*/
              return view('wechat.credit.validate');
          }
      }
      else
      {
          /*不存在支付完成的订单，弹出协议让用户下单支付,将产品id传过去*/
            $product=Product::find($id);
          return view('wechat.credit.xieyi',compact('product'));
      }
  }
  /*征信接口查询并生成征信报告，一次性查询多个接口
   从订单中取出state=1的订单type,确定用户购买的产品类型，根据
  */
  function apply_store(Request $request)
  {
      $req=$request->all();
      $bankcard=$req["bankcard"]==null?"":$req["bankcard"];
      $entname=$req["entname"]==null?"":$req["entname"];
      $creditCode=$req["creditCode"]==null?"":$req["creditCode"];
      $licensePlate=$req["licensePlate"]==null?"":$req["licensePlate"];
      $carType=$req["carType"]==null?"":$req["carType"];
      $vin=$req["vin"]==null?"":$req["vin"];
      $engineNo=$req["engineNo"]==null?"":$req["engineNo"];
      $order=Order::find($req["order_id"]);//获取用户购买的订单
      $auth=Authorization::find($order["auth_id"]);
      //订单状态 0:未支付1：已付款，2：征信接口已成功查询；3.接口已查询存在异常接口-1：超时未支付的无效订单
      if (!in_array($order["state"],array(1,3))) return "暂无有效接口";
      if ($order["state"]==1)
      {
          //已付款未查询状态，获取查询的接口
          $interfaces=Interfaces::where('pro_id',$order["pro_id"])->where('isenable',1)->get();
      }
      else
          $interfaces=User_interface::where('order_id',$req["order_id"])->where('state',2)->get();


      $chArr=[];
      //创建多个cURL资源
      for($i=0; $i<1; $i++){
          $chArr[$i]=curl_init();
          curl_setopt($chArr[$i], CURLOPT_URL, "https://rip.linrico.com/personSubjectToEnforcementHJ/result?username=shbd&accessToken=40db8b4b95ac91ed6e905c80d45ebac5&name=".urlencode('北京百度网讯科技有限公司')."&pageNum=1");
          curl_setopt($chArr[$i], CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($chArr[$i], CURLOPT_HTTPHEADER, array("Content-type: application/json;charset='utf-8'"));
          curl_setopt($chArr[$i], CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
          curl_setopt($chArr[$i], CURLOPT_SSL_VERIFYHOST, FALSE);
          curl_setopt($chArr[$i], CURLOPT_TIMEOUT, 1);
      }
      $mh = curl_multi_init(); //1 创建批处理cURL句柄
      foreach($chArr as $k => $ch){
          curl_multi_add_handle($mh, $ch); //2 增加句柄
      }
      $active = null;
      do {
          while (($mrc = curl_multi_exec($mh, $active)) == CURLM_CALL_MULTI_PERFORM) ;

          if ($mrc != CURLM_OK) { break; }

          // a request was just completed -- find out which one
          while ($done = curl_multi_info_read($mh)) {

              // get the info and content returned on the request
              $info = curl_getinfo($done['handle']);
              $error = curl_error($done['handle']);
              $result= curl_multi_getcontent($done['handle']);//链接返回值；

             // {"result":"","total":"","code":"200","data":{"total":2,"items":[{"caseCode":"(2019)冀02执224号","partyCardNum":"91110000802****433B","pname":"北京百度网讯科技有限公司","caseCreateTime":1546531200000,"execCourtName":"唐山市中级人民法院","id":19397334,"execMoney":"6755","cid":22822},{"caseCode":"(2018)京0108执11361号","partyCardNum":"80210043-3","pname":"北京百度网讯科技有限公司","caseCreateTime":1530633600000,"execCourtName":"北京市海淀区人民法院","id":7169664,"execMoney":"17300","cid":22822}]},"tradeNo":"1547779358538WQAO","param":"","start":"","pageSize":"","end":"","message":"请求成功","pageNum":""}
                  dd($result);


              // remove the curl handle that just completed
              curl_multi_remove_handle($mh, $done['handle']);
              curl_close($done['handle']);
          }
          // Block for data in / output; error handling is done by curl_multi_exec
          if ($active > 0) {
              curl_multi_select($mh);
          }
      } while ($active);
      curl_multi_close($mh); //7 关闭全部句柄

      //$end_time = microtime(TRUE);
     // echo sprintf("use time:%.3f s", $end_time - $srart_time);
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
              DB::table('record')->insert([$openid,$output]);
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
                  return "认证成功";
              }
              else return "服务出错";
          }
          else
          return $msg->message;
      }
      return "服务出错";
  }


}
