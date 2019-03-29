<?php

namespace App\Http\Controllers\Chat;

use App\Models\Interfaces;
use App\Models\Person_attach;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wxuser;
use App\Models\Order;
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
            $oauth=Person_attach::where('order_id',$order_id)->first();
            return view('wechat.credit.reapply',compact('oauth','order_id'));
        }
        else
             return "非法查询";
    }
    /*进入短信验证界面*/
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
  function  apply($id)
  {
      $product=Product::find($id);
      return view('wechat.credit.apply',compact('product'));
  }
  /*征信接口查询并生成征信报告，一次性查询多个接口
   从订单中取出state=1的订单type,确定用户购买的产品类型，根据
  */
  function apply_store(Request $request)
  {
      $req=$request->all();
      $openid=$_SESSION['wechat_user']['id'];
      $order=Order::find($req["order_id"]);//获取用户购买的订单
      $attach=Person_attach::where('order_id',$req["order_id"])->first();
      //已经查询的接口取出
      $interfaces_list=DB::table('user_interface')->leftJoin('interfaces','user_interface.interface_id','=','interfaces.id')
          ->where('order_id',$req["order_id"])->where('state',1)
          ->get(['user_interface.interface_id','result_code']);
      //订单状态 0:未支付1：已付款，2：征信接口已成功查询；3.接口已查询存在异常接口-1：超时未支付的无效订单
      if (!in_array($order["state"],array(1,3))) return "暂无有效接口";
      $interfaces_count=count($interfaces_list);
      /*查询个人名下企业接口是否有权限，将名下参股企业记录下来*/
      $enterprise=Interfaces::where('api_name','personalEnterprise')->where('isenable',1)->first();
      if($enterprise){
          $bool=false;
          if($interfaces_count>0) {$isenterprise=$interfaces_list->where('interface_id',$enterprise->id)->first();if($isenterprise)$bool=true;}
          if ($bool){
              //存在已经查询的企业接口
              if (isset($isenterprise))
                  $attach["entname"]=json_encode($this->getentname($isenterprise->result_code),JSON_UNESCAPED_UNICODE);//数组形式
          }
          else
          {  //不存在已经查询的企业接口
              $base=new base();
              $url=$this->init_url(null,$attach,'personalEnterprise');
              $output=$base->get_curl($url);
              $inter["interface_id"]=$enterprise->id;
              $inter["order_id"]=$order['id'];
              $inter["openid"]=$openid;
              $inter["result_code"]=$output;
              $inter["url"]=$url;
              User_interface::create($inter);
              $attach["entname"]=json_encode($this->getentname($output),JSON_UNESCAPED_UNICODE);//数组形式
          }
      }
       else $attach["entname"]=null;
       if ($attach["entname"]!=null&&$attach["entname"]!='')$attach->save();
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
              $interfaces=DB::table('interfaces')
                  ->leftJoin('pro_interface','interfaces.id','=','pro_interface.interface_id')
                  ->where('pro_id',$order["pro_id"])
                  ->where('pro_interface.isenable',1)
                  ->whereNotIn("interfaces.id",$arrids)->get(['interfaces.id','interfaces.api_name']);
           else
               $interfaces=DB::table('interfaces')
                   ->leftJoin('pro_interface','interfaces.id','=','pro_interface.interface_id')
                   ->where('pro_id',$order["pro_id"])
                   ->where('pro_interface.isenable',1)
                   ->get(['interfaces.id','interfaces.api_name']);
          $num=count($interfaces);
          if($order["pro_id"]==1&&$num>0) {
              $i = 0;
              $chArr = [];//创建多个cURL资源
              $apis=array('enterpriseLitigationInquiry','abnormalBusinessOperationHJ','businessData');
            foreach ($interfaces as $interface)
            {
                if (in_array($interface->api_name,$apis))//企业涉诉
                {
                    if ($attach["entname"]!=null&&$attach["entname"]!='') {
                        $ent = json_decode($attach["entname"]);
                        foreach ($ent as $company) {
                            $user["entname"]=$company->entname;
                            $url = $this->init_url($user,$attach,$interface->api_name);
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
                    $url =  $this->init_url(null,$attach,$interface->api_name);
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
                    //get the info and content returned on the request
                    $info = curl_getinfo($done['handle']);
                    $error = curl_error($done['handle']);
                    $result= curl_multi_getcontent($done['handle']);//链接返回值；
                    $parse=parse_url($info['url']);
                    $api_name=explode('/',$parse["path"])[1];
                    $params=$this->convertUrlQuery($parse["query"]);
                    if (in_array($api_name,$apis))
                    {$inter["name"]=isset($params["name"])?urldecode($params["name"]):urldecode($params["key"]);}
                    if (isset($params["pageNum"])||isset($params["pageIndex"]))
                    {$inter["pagesize"]=isset($params["pageNum"])?$params["pageNum"]:(isset($params["pageIndex"])?$params["pageIndex"]:0);}
                    $api=$interfaces->where('api_name',$api_name)->first();
                    if ($api)$inter["interface_id"]=$api->id;
                    $inter["order_id"]=$order['id'];
                    //$inter["auth_id"]=$auth['id'];
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
             //{"success": true,"message": "该用户已经授权","code": 0,"timestamp": 1551942308648 }
             $msg=json_decode($output);
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

      //$output ="{\"success\":true,\"message\":\"短信认证通过，已完成授权\",\"code\":0,\"timestamp\":1550640489731}";
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
          case "businessData";if ($user['entname']!="")$url="https://rip.linrico.com/businessData/result".$pram."&key=".urlencode($user['entname'])."&keyType=1";else {if ($user['creditCode']!="")$url="https://rip.linrico.com/businessData/result".$pram."&key=".urlencode($user['creditCode'])."&keyType=2";} break;
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
          case "basicInformationOfTheEnterpriseHJ": if($user['entname']!="")$url="https://rip.linrico.com/basicInformationOfTheEnterpriseHJ/result".$pram."&name=".urlencode($user['entname']);break;
          case  "operatorThreeElements": $url="https://rip.linrico.com/operatorThreeElements/result".$pram."&name=".$name."&mobile=".$phone."&idNumber=".$idCard;break;
          default :break;
      }
    return $url;
   }
    /*
     * 接口查询成功跳转页
     */
   function success($id)
   {
       //直接跳转至报告页面
      //return view('wechat.credit.success',compact('id'));
      return redirect()->route('order.report',[$id]);
   }
   /*解析获取名下企业*/
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

   /*url解析参数并将参数放到数组里面*/
    function convertUrlQuery($query)
    {
        $queryParts = explode('&', $query);

        $params = array();
        foreach ($queryParts as $param)
        {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }

        return $params;
    }
}
