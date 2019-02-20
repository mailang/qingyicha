<?php

namespace App\Http\Controllers\Chat;

use App\Models\Interfaces;
use App\Models\Person_attach;
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
      $openid=$_SESSION['wechat_user']['id'];//'offTY1fb81WxhV84LWciHzn4qwqU';
      $user=Wxuser::where('openid',$openid)->first();
      if ($user["auth_id"]!=null&&$user["auth_id"]>0)
          {
              $order=Order::where('pro_id',$id)->where('openid',$openid)->where('state','>','0')->where('state','!=','2')->orderByDesc('id')->limit(1)->get(['id','state']);
              if ($order->first())
              {
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
                      $product=Product::find($id);   return view('wechat.credit.xieyi',compact('product')); break;
              }
              }
              else
              {
                  /*不存在支付完成的订单，弹出协议让用户下单支付,将产品id传过去*/
                  $product=Product::find($id);
                  return view('wechat.credit.xieyi',compact('product'));
              }
          }
          else
          {
              /*未认证用户*/
              return view('wechat.credit.validate');
          }
  }
  /*征信接口查询并生成征信报告，一次性查询多个接口
   从订单中取出state=1的订单type,确定用户购买的产品类型，根据
  */
  function apply_store(Request $request)
  {
      $req=$request->all();
      $openid=$_SESSION['wechat_user']['id'];//'offTY1fb81WxhV84LWciHzn4qwqU';
      $user['bankcard']=$req["bankcard"]==null?"":$req["bankcard"];
      $user['entname']=$req["entname"]==null?"":$req["entname"];
      $user['creditCode']=$req["creditCode"]==null?"":$req["creditCode"];
     /*$user['licensePlate']=$req["licensePlate"]==null?"":$req["licensePlate"];
      $user['carType']=$req["carType"]==null?"":$req["carType"];
      $use['vin']=$req["vin"]==null?"":$req["vin"];
      $user['engineNo']=$req["engineNo"]==null?"":$req["engineNo"];*/
      $order=Order::find($req["order_id"]);//获取用户购买的订单
      $auth=Authorization::find($req["auth_id"]);//取出实名认证
      //订单状态 0:未支付1：已付款，2：征信接口已成功查询；3.接口已查询存在异常接口-1：超时未支付的无效订单
      if (!in_array($order["state"],array(1,3))) return "暂无有效接口";
      $attach["openid"]=$openid;
      $attach["order_id"]=$req["order_id"];
      $attach["name"]=$auth["name"];
      $attach["phone"]=$auth["phone"];
      $attach["cardNo"]=$auth["cardNo"];
      $attach["entname"]= $user['entname'];
      $attach["creditCode"]= $user['creditCode'];
      /*$attach["licensePlate"]=$user['licensePlate'];
      $attach["carType"]=$user['carType'];
      $attach["vin"]=$use['vin'];
      $attach["engineNo"]=$user['engineNo'];*/
      $attach["bankcard"]=$user['bankcard'];
      Person_attach::create($attach);
      if ($order["state"]==1)
      {
          //已付款未查询状态，获取查询的接口
          $interfaces=Interfaces::where('pro_id',$order["pro_id"])->where('isenable',1)->get();
      }
      else
          $interfaces=DB::table('interfaces')->leftJoin('user_interface','interfaces.id','=','user_interface.interface_id')
              ->where('order_id',$req["order_id"])->where('user_interface.state',0)
              ->get(['interfaces.id','interfaces.api_name','user_interface.state']);//异常接口
          $num=count($interfaces);
        if($order["pro_id"]==1&&$num>0) {
            $chArr = [];//创建多个cURL资源
            for ($i = 0; $i < $num; $i++)
            {
                $url =  $this->init_url($user,$auth,$interfaces[$i]->api_name);
                if ($url != '') {
                $chArr[$i] = curl_init();
                curl_setopt($chArr[$i], CURLOPT_URL, $url);
                curl_setopt($chArr[$i], CURLOPT_RETURNTRANSFER, 1);
               //curl_setopt($chArr[$i], CURLOPT_HEADER, 1);
                curl_setopt($chArr[$i], CURLOPT_HTTPHEADER, array("Content-type: application/json;charset='utf-8'"));
                curl_setopt($chArr[$i], CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
                curl_setopt($chArr[$i], CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($chArr[$i], CURLOPT_TIMEOUT, 5);
                //curl_setopt($chArr[$i], CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
                }
            }
            $mh = curl_multi_init(); //1 创建批处理cURL句柄
            foreach($chArr as $k => $ch){
                curl_multi_add_handle($mh, $ch); //2 增加句柄
            }
            $active = null;
            $order["state"]=2;
            do {
                while (($mrc = curl_multi_exec($mh, $active)) == CURLM_CALL_MULTI_PERFORM) ;
                if ($mrc != CURLM_OK) { break; }
                // a request was just completed -- find out which one
                while ($done = curl_multi_info_read($mh)) {
                    // get the info and content returned on the request
                    $info = curl_getinfo($done['handle']);
                    $error = curl_error($done['handle']);
                    $result= curl_multi_getcontent($done['handle']);//链接返回值；
                    $arrurl=explode('/',$info['url']);
                    $api_name=$arrurl[3];
                    $api=$interfaces->where('api_name',$api_name)->first();
                    if ($api)$inter["interface_id"]=$api->id;
                    $inter["order_id"]=$order['id'];
                    $inter["auth_id"]=$auth['id'];
                    $inter["openid"]=$openid;
                    $inter["result_code"]=$result;
                    $inter["url"]=$info['url'];
                    User_interface::create($inter);
                    //remove the curl handle that just completed
                    curl_multi_remove_handle($mh, $done['handle']);
                    curl_close($done['handle']);
                }
                if ($active > 0) {
                    curl_multi_select($mh);
                }
            } while ($active);
            curl_multi_close($mh); //7 关闭全部句柄
            $order->save();//订单状态值改变
        }
        return "1";
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
      $name=$_POST["name"];
      $idCard=$_POST["cardNo"];
      $phone=$_POST["phone"];
      $telcode=$_POST["telcode"];
      //用户验证成功
      $prams='username=shbd&accessToken=40db8b4b95ac91ed6e905c80d45ebac5'."&name=".urlencode($name).'&idCard='.urlencode($idCard)."&phone=".urlencode($phone)."&securityCode=".urlencode($telcode);
      $url=$path.$prams;
      $base=new base();
      $output=$base->get_curl($url);
      if ($output!=null&&$output!='')
      {
          //用户验证成功
          $openid=$_SESSION['wechat_user']['id'];
          $time=date('Y-m-d h:i:s');
          DB::insert('insert into user_validate(result_code,openid,url,created_at) values(?,?,?,?)',[$output, $openid,$url,$time]);
          $msg=json_decode($output);
          if ($msg->code=='0'&&$msg->success)
          {
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
  /*
   * 初始化基础查询的接口链接
   */
   function  init_url($user,$auth,$api_name)
   {
       $url="";
       $pram="?username=shbd&accessToken=40db8b4b95ac91ed6e905c80d45ebac5";
       $name=urlencode($auth["name"]);
       $idCard=urlencode($auth["cardNo"]);
       $phone=urlencode($auth["phone"]);
      switch ($api_name)
      {
         case "multipleLoanQuery";$url="https://rip.linrico.com/multipleLoanQuery/result".$pram."&mobile=".$phone;break;
          case "personalComplaintInquiry";$url="https://rip.linrico.com/personalComplaintInquiry/result".$pram."&name=".$name."&idCard=".$idCard.'&pageIndex=1'; break;
          case "personalEnterprise";$url="https://rip.linrico.com/personalEnterprise/result".$pram."&key=".$idCard; break;
          case "businessData";if ($user['creditCode']!="")$url="https://rip.linrico.com/businessData/result".$pram."&key=".urlencode($user['creditCode'])."&keyType=2";else {if ($user['entname']!="")$url="https://rip.linrico.com/businessData/result".$pram."&key=".urlencode($user['entname'])."&keyType=1";} break;
          case "enterpriseLitigationInquiry";if ($user['entname']!="") $url="https://rip.linrico.com/enterpriseLitigationInquiry/result".$pram."&name=".urlencode($user['entname']).'&pageIndex=1';break;
          case "thePhoneIsOnTheInternet"; $url="https://rip.linrico.com/thePhoneIsOnTheInternet/result".$pram."&phone=".$phone;break;
          case "mobileConsumptionLevel";$url="https://rip.linrico.com/mobileConsumptionLevel/result".$pram."&phone=".$phone;break;
          case "bankCardFourElements";if ($user['bankcard']!="")$url="https://rip.linrico.com/bankCardFourElements/result".$pram."&name=".$name."&idNumber=".$idCard."&bankCard=".urlencode($user['bankcard'])."&mobile=".$phone; break;
          case  "personSubjectToEnforcementHJ":if($user['entname']!="")$url="https://rip.linrico.com/personSubjectToEnforcementHJ/result".$pram."&name=".urlencode($user['entname'])."&pageNum=1";break;
          case  "administrativePenaltyInformationHJ":if($user['entname']!="")$url="https://rip.linrico.com/administrativePenaltyInformationHJ/result".$pram."&name=".urlencode($user['entname'])."&pageNum=1";break;
          case  "abnormalBusinessOperationHJ":if($user['entname']!="")$url="https://rip.linrico.com/abnormalBusinessOperationHJ/result".$pram."&name=".urlencode($user['entname'])."&pageNum=1";break;
          case  "businessBrokenPromisesHJ":$url="https://rip.linrico.com/businessBrokenPromisesHJ/result".$pram."&name=".urlencode($user['entname'])."&pageNum=1";break;
          case  "corporateLawHJ":$url="https://rip.linrico.com/corporateLawHJ/result".$pram."&name=".urlencode($user['entname'])."&pageNum=1";break;
          default :break;
      }
    return $url;
   }
    /*
     * 接口查询成功跳转页
     */
   function success($id)
   {
      return view('wechat.credit.success',compact('id'));
   }

}
