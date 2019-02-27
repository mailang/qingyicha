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
use Illuminate\Support\Facades\URL;

class CreditController extends Controller
{
    function reapply($order_id)
    {
        $order=Order::find($order_id);//获取用户购买的订单
        if ($order["state"]==1||$order["state"]==3)
        {
            $list=DB::table("wxuser")->leftJoin('authorization','wxuser.auth_id','=','authorization.id')
                ->where('wxuser.id',$order["wxuser_id"])->get(['authorization.id','authorization.name','authorization.phone','authorization.cardNo']);
            $oauth=$list->first();
            return view('wechat.credit.reapply',compact('oauth','order_id'));
        }
        else
             return "非法查询";
    }

    function validate_auth()
    {
        $reurl = route("weixin.index");
        if (session("reurl"))
        {
            $reurl = session("reurl");
        }
        $openid=$_SESSION['wechat_user']['id'];//'offTY1fb81WxhV84LWciHzn4qwqU';
        $user=Wxuser::where('openid',$openid)->first();
        if ($user["auth_id"]!=null&&$user["auth_id"]>0)
        {
            return redirect(route("weixin.index"));
        }
        else
        {
            return view("wechat.credit.validate")->with('reurl',$reurl);
        }
    }

    /*征信查询*/
  function  apply()
  {
      $id=$_GET["proid"];
      $product=Product::find($id);
      $openid=$_SESSION['wechat_user']['id'];//'offTY1fb81WxhV84LWciHzn4qwqU';
      $user=Wxuser::where('openid',$openid)->first();
      $oauth=Authorization::find($user['auth_id']);
      return view('wechat.credit.apply',compact('oauth','product'));
//      /*查看用户是否已经购买，购买后看是否已认证*/
//      $id=$_GET["proid"];
//      $openid=$_SESSION['wechat_user']['id'];//'offTY1fb81WxhV84LWciHzn4qwqU';
//      $user=Wxuser::where('openid',$openid)->first();
//      if ($user["auth_id"]!=null&&$user["auth_id"]>0)
//          {
//              $order=Order::where('pro_id',$id)->where('openid',$openid)->where('state','>','0')->where('state','!=','2')->orderByDesc('id')->limit(1)->get(['id','state']);
//              if ($order->first())
//              {
//              $odata=$order->first();
//              //订单状态 0:未支付1：已付款，2：征信接口已成功查询；3.接口已查询存在异常接口-1：超时未支付的无效订单
//              switch ($odata['state'])
//              {
//                  case 1:  /*已付款未查询接口*/
//                      $oauth=Authorization::find($user['auth_id']);
//                      $order_id=$odata['id'];
//                      return view('wechat.credit.apply',compact('oauth','order_id')); break;
//                  case 3: $oauth=Authorization::find($user['auth_id']);$order_id=$odata['id'];
//                      return view('wechat.credit.apply',compact('oauth','order_id')); break;
//                  default:/*不存在查询失败的接口，可以重新支付查询最新的接口*/
//                      $product=Product::find($id);   return view('wechat.credit.xieyi',compact('product')); break;
//              }
//              }
//              else
//              {
//                  /*不存在支付完成的订单，弹出协议让用户下单支付,将产品id传过去*/
//                  $product=Product::find($id);
//                  return view('wechat.credit.xieyi',compact('product'));
//              }
//          }
//          else
//          {
//              /*未认证用户*/
//              return view('wechat.credit.validate');
//          }
  }
  /*征信接口查询并生成征信报告，一次性查询多个接口
   从订单中取出state=1的订单type,确定用户购买的产品类型，根据
  */
  function apply_store(Request $request)
  {
      $req=$request->all();
      $openid=$_SESSION['wechat_user']['id'];
      $order=Order::find($req["order_id"]);//获取用户购买的订单
      if (isset($order["auth_id"])&&$order["auth_id"]!=null) $auth_id=$order["auth_id"];
      else {$wxuser = Wxuser::find($order["wxuser_id"]);$auth_id=$wxuser["auth_id"];}
      $auth=Authorization::find($auth_id);//取出实名认证
      $interfaces_list=DB::table('user_interface')->leftJoin('interfaces','user_interface.interface_id','=','interfaces.id')
          ->where('order_id',$req["order_id"])->where('state',1)
          ->get(['user_interface.interface_id','result_code']);//已经查询的接口取出
      //订单状态 0:未支付1：已付款，2：征信接口已成功查询；3.接口已查询存在异常接口-1：超时未支付的无效订单
      if (!in_array($order["state"],array(1,3))) return "暂无有效接口";
      $interfaces_count=count($interfaces_list);
      $attach["openid"]=$openid;
      $attach["order_id"]=$req["order_id"];
      $attach["name"]=$auth["name"];
      $attach["phone"]=$auth["phone"];
      $attach["cardNo"]=$auth["cardNo"];
      $person_attach=Person_attach::where('order_id',$req["order_id"])->get();
      /*查询个人名下企业接口是否有权限，将名下参股企业记录下来*/
      $enterprise=Interfaces::where('api_name','personalEnterprise')->where('isenable',1)->first();
      if($enterprise){
          $bool=false;
          if($interfaces_count>0) {$isenterprise=$interfaces_list->where('interface_id',$enterprise->id)->first();if($isenterprise)$bool=true;}
          if ($bool){
              //存在已经查询的企业接口
              if (count($person_attach)==0&&isset($isenterprise))
                  $attach["entname"]=json_encode($this->getentname($isenterprise->result_code),JSON_UNESCAPED_UNICODE);//数组形式
          }
          else
          {  //不存在已经查询的企业接口
              $base=new base();
              $url=$this->init_url(null,$auth,'personalEnterprise');
              $output=$base->get_curl($url);
              $inter["interface_id"]=$enterprise->id;
              $inter["order_id"]=$order['id'];
              $inter["auth_id"]=$auth['id'];
              $inter["openid"]=$openid;
              $inter["result_code"]=$output;
              $inter["url"]=$url;
              User_interface::create($inter);
              $attach["entname"]=json_encode($this->getentname($output),JSON_UNESCAPED_UNICODE);//数组形式
          }
      }
       else $attach["entname"]=null;
       if (count($person_attach)==0)Person_attach::create($attach);
        $arrids=array();
          if ($enterprise)
          {   //取出已经成功查询的接口
             $array1=array($enterprise->id);
              if($interfaces_count>0){
                  $array2=array_column($interfaces_list->toArray(),"interface_id");
                  $arrids=array_merge($array1,$array2);
              }else $arrids=$array1;}
          else if($interfaces_count>0) $arrids=array_column($interfaces_list->toArray(),"interface_id");
          if ($arrids!=null)
              $interfaces=Interfaces::where('pro_id',$order["pro_id"])->where('isenable',1)->whereNotIn("id",$arrids)->get();
           else
               $interfaces=Interfaces::where('pro_id',$order["pro_id"])->where('isenable',1)->whereNotIn("id",$arrids)->get();
          $num=count($interfaces);
          if($order["pro_id"]==1&&$num>0) {
              $i = 0;
            $chArr = [];//创建多个cURL资源
            foreach ($interfaces as $interface)
            {
                if ($interface->api_name=='enterpriseLitigationInquiry')//企业涉诉
                {
                    if ($attach["entname"]!=null&&$attach["entname"]!='') {
                        $ent = json_decode($attach["entname"]);
                        foreach ($ent as $company) {
                            $user["entname"]=$company->entname;
                            $url = $this->init_url($user, $auth, $interface->api_name);
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
                                $i++;
                            }

                        }
                    }
                }
                else
                {
                    $url =  $this->init_url(null,$auth,$interface->api_name);
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
                        $i++;
                    }
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
      //$output=$base->get_curl($url);

      $output ="{\"success\":true,\"message\":\"短信认证通过，已完成授权\",\"code\":0,\"timestamp\":1550640489731}";
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
          case  "inTheNetworkTime":$url="https://rip.linrico.com/inTheNetworkTime/result".$pram."&mobile=".$phone; break;
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
   function getentname($output)
   {
       $result=array();
       $jsson=json_decode($output);
       if (isset($jsson->success)&&$jsson->success==true)   {
           //{"success":true,"requestOrder":"6416a694d2634fdfa5a5832197183794","data":{"key":"340825198908154735","status":"NO_DATA"}}
           $data=$jsson->data;
           if ($data->status=="EXIST"){
               /*有企业*/
               //{"success":true,"requestOrder":"f365d39e61b04e3397ca15ceed31c3f6","data":
               //{"key":"342626198711040811","status":"EXIST","punishBreaks":[],"punished":[],"caseInfos":[],
               //"corporates":[{"ryName":"洪守志","entName":"安徽麦浪信息技术有限公司","regNo":"340200000179811","entType":"有限责任公司(自然人投资或控股)","regCap":"100.000000","regCapCur":"人民币元","entStatus":"在营（开业）","creditNo":"913402070803213725"}],
               //"corporateManagers":[{"ryName":"洪守志","entName":"芜湖市志昊财务咨询有限公司","regNo":"340200000159329","entType":"有限责任公司(自然人投资或控股)","regCap":"3.000000","regCapCur":"人民币元","entStatus":"在营（开业）","position":"监事","creditNo":"913402070597143152"},{"ryName":"洪守志","entName":"安徽麦浪信息技术有限公司","regNo":"340200000179811","entType":"有限责任公司(自然人投资或控股)","regCap":"100.000000","regCapCur":"人民币元","entStatus":"在营（开业）","position":"执行董事兼总经理","creditNo":"913402070803213725"}],
               //"corporateShareholders":[{"ryName":"洪守志","entName":"芜湖市志昊财务咨询有限公司","regNo":"340200000159329","entType":"有限责任公司(自然人投资或控股)","regCap":"3.000000","regCapCur":"人民币元","entStatus":"在营（开业）","subConam":"1.500000","currency":"人民币元","fundedRatio":"50.00%","creditNo":"913402070597143152"},{"ryName":"洪守志","entName":"安徽麦浪信息技术有限公司","regNo":"340200000179811","entType":"有限责任公司(自然人投资或控股)","regCap":"100.000000","regCapCur":"人民币元","entStatus":"在营（开业）","subConam":"60.000000","currency":"人民币元","fundedRatio":"60.00%","creditNo":"913402070803213725"}]}}
               $entname=array();
               $re["corporates"]=$data->corporates;
               if (count($re["corporates"])>0)
               {
                 foreach ($re["corporates"] as $corporate)
                 {
                     $company["entname"]=$corporate->entName;
                     $company["creditNo"]=$corporate->creditNo;
                     if (!in_array( $company["entname"],$entname))
                     {
                         array_push($entname, $company["entname"]);
                         array_push($result,$company);
                     }
                 }
               }

               $re["corporateManagers"]=$data->corporateManagers;
               if (count($re["corporateManagers"])>0)
               {
                   foreach ($re["corporateManagers"] as $manager)
                   {
                       $company["entname"]=$manager->entName;
                       $company["creditNo"]=$manager->creditNo;
                       if (!in_array( $company["entname"],$entname))
                       {
                           array_push($entname, $company["entname"]);
                           array_push($result,$company);
                       }
                   }
               }
               $re["corporateShareholders"]=$data->corporateShareholders;
               if (count($re["corporateShareholders"])>0)
               {
                   foreach ($re["corporateShareholders"] as $holder)
                   {
                       $company["entname"]=$holder->entName;
                       $company["creditNo"]=$holder->creditNo;
                       if (!in_array( $company["entname"],$entname))
                       {
                           array_push($entname, $company["entname"]);
                           array_push($result,$company);
                       }
                   }
               }

            }
       }
       return $result;
   }
}
