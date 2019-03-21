<?php

namespace App\Http\Controllers\Chat;

use App\Models\Person_attach;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\User_interface;
use Illuminate\Support\Facades\DB;
use App\Src;
use App\Models\Wxuser;
use App\Src\base;

class InquiryController extends Controller
{
    /*企业涉诉首页
     * $id order表中pid=-1的订单id举例
     */
    function enterprise($id, $name, $page = 1)
    {
        $order=DB::table('order')
            ->where('pid',$id)
            ->where('pro_id',2)
            ->where('state',1)
            ->where('name',$name)
            ->get();
        if (count($order)>0)
        {
            $list = DB::table('user_interface')->leftJoin('interfaces', 'interfaces.id', '=', 'user_interface.interface_id')
                ->where('order_id', $id)
                ->where('user_interface.pagesize', $page)
                ->where('name', $name)
                ->where('interfaces.api_name', 'enterpriseLitigationInquiry')
                ->get(['user_interface.id', "interface_id", "order_id", "auth_id", "openid", "result_code", "url", 'state', 'pagesize']);
            $interface = $list->first();
            $enterpriseLitigationInquiry = new Src\enterpriseLitigationInquiry();
            $report = $enterpriseLitigationInquiry->inquiry_info($interface->id, $interface->result_code);
            if ($report != null)
                return view('wechat.inquiry.cominquiry', compact('report'));
            else
              return '服务商请求数据异常,请联系服务商';
        }
        else {
            //没有购买，购买下一页的查询数据
             $user_interface=DB::table('user_interface')->leftJoin('interfaces', 'interfaces.id', '=', 'user_interface.interface_id')
                ->where('order_id', $id)
                ->where('user_interface.pagesize', 1)
                ->where('name', $name)
                ->where('interfaces.api_name', 'enterpriseLitigationInquiry')
                ->get(['user_interface.id'])->first();
             return redirect()->route('inquiry.apply',$user_interface->id);
            /*
        $api["api_name"] = "enterpriseLitigationInquiry";
        $api["name"] = $name;
        $api["pid"] = $id;
        return view('wechat.inquiry.apply', compact('api'));*/
        }
    }
    /*个人涉诉详情查询*/
    function person($id, $name, $page = 1)
    {
        $order=DB::table('order')
            ->where('pid',$id)
            ->where('pro_id',2)
            ->where('name',$name)
            ->where('state',1)
            ->get();
        if (count($order)>0) {
            $list = DB::table('user_interface')->leftJoin('interfaces', 'interfaces.id', '=', 'user_interface.interface_id')
                ->where('order_id', $id)
                ->where('user_interface.pagesize', $page)
                ->where('interfaces.api_name', 'personalComplaintInquiry')
                ->get(['user_interface.id', "interface_id", "order_id", "auth_id", "openid", "result_code", "url", 'state', 'pagesize']);
                $interface = $list->first();
                $personalComplaintInquiry = new Src\personalComplaintInquiry();
                $report = $personalComplaintInquiry->inquiry_info($interface->id, $interface->result_code);
                if ($report != null)
                    return view('wechat.inquiry.persoinquiry', compact('report'));
                else
                   return '服务商请求数据异常,请联系服务商';
        }
        else {
            //没有购买，购买下一页的查询数据
            $user_interface = DB::table('user_interface')->leftJoin('interfaces', 'interfaces.id', '=', 'user_interface.interface_id')
                ->where('order_id', $id)
                ->where('user_interface.pagesize', 1)
                ->where('name', $name)
                ->where('interfaces.api_name', 'personalComplaintInquiry')
                ->get(['user_interface.id'])->first();
            return redirect()->route('inquiry.apply', $user_interface->id);
            /*
            $api["api_name"] = "personalComplaintInquiry";
            $api["name"] = $name;
            $api["page"] = $page;
            $api["pid"] = $id;
            return view('wechat.inquiry.apply', compact('api'));
          */
        }
    }

    function apply($user_interface)
    {
           //没有购买，购买下一页的查询数据
           $interface=DB::table('user_interface')->leftJoin('interfaces', 'interfaces.id', '=', 'user_interface.interface_id')
            ->where('user_interface.id', $user_interface)
            ->get(['user_interface.id','user_interface.name', "interface_id", "order_id", "api_name", "result_code", 'state', 'pagesize'])->first();
        if ($interface){
            if ($interface->api_name=="personalComplaintInquiry")
                $product=Product::find(3);
            else $product=Product::find(2);
            return view('wechat.inquiry.apply', compact('interface','product'));
        }
        else return "找不到相关数据";

    }
      /*涉诉订单支付*/
    function order_create()
    {
            //return '{"appId":"wxaffee917b46f14d8","nonceStr":"5c46d829ee4c6","package":"prepay_id=wx221645424410449e96a87f0b2066641826","signType":"MD5","paySign":"6C4600732B204DA08AEC02283C997BE3","timestamp":"1548146729"}';
            $name=$_GET["name"];
            $pro_id=$_GET["pro_id"];
            $pid=$_GET["pid"];

            $app = app('wechat.payment');
            $jssdk = $app->jssdk;
            $openid=$_SESSION['wechat_user']['id'];//'offTY1fb81WxhV84LWciHzn4qwqU';
            $user=Wxuser::where('openid',$openid)->first();
            $base=new base();
            $order_No=$base->No_create($user["id"]);//获取订单号
            $product=Product::find($pro_id);
            $result = $app->order->unify([
                'body' => '普信天下'.$product->pro_name,
                'out_trade_no' => $order_No,
                'total_fee' => $product->price*100,
                'spbill_create_ip' =>'123.206.254.31', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
                'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
                'openid' => $openid,
            ]);
            if (strtolower($result["return_code"])=='success')
            {
                $config = $jssdk->sdkConfig($result["prepay_id"]); // 返回数组
                $data["openid"]=$openid;
                $data["wxuser_id"]=$user["id"];
                //$data["auth_id"]=$user["auth_id"];
                $data["out_trade_no"]=$order_No;
                $data["body"]='普信天下'.$product->pro_name;
                $data["total_fee"]=$product->price;
                $data["time_start"]=date('Y-m-d H:i:s');
                $data["time_expire"]=date('Y-m-d H:i:s',strtotime('+ 1 hour'));
                $data["pro_id"]=$pro_id;
                $data["created_at"]=date('Y-m-d H:i:s');
                $data["updated_at"]=date('Y-m-d H:i:s');
                $data["pid"]=$pid;
                $data["name"]=$name;
                $order_id=DB::table('order')->insertGetId($data);
                $config["order_id"]=$order_id;
                $config["state"]=1;
                return json_encode($config);
            }
            else return json_encode(array("state"=>0,"msg"=>"下单失败"));

    }
    function payback($user_interid)
    {
        $user_interface=User_interface::find($user_interid);
        return view('wechat.inquiry.payback',compact('user_interface'));
    }
    /*抓取所有页数的涉诉情况*/
    function check_inquiry($user_interid)
    {
        //没有购买，购买下一页的查询数据
        $interface=DB::table('user_interface')->leftJoin('interfaces', 'interfaces.id', '=', 'user_interface.interface_id')
            ->where('user_interface.id', $user_interid)
            ->get(['user_interface.id','user_interface.name', "interface_id", "order_id", "api_name","url", "result_code", 'state', 'pagesize'])->first();
       if ($interface->api_name=="personalComplaintInquiry")
       {
           $order=DB::table('order')
               ->where('pid',$interface->order_id)
               ->where('pro_id',3)
               ->where('name',$interface->name)
               ->where('state',1)
               ->get()->first();
           if ($order) {
               $personalComplaintInquiry = new Src\personalComplaintInquiry();
               $report = $personalComplaintInquiry->inquiry_info($interface->id, $interface->result_code);
           }
       }
       else
       {
           $order=DB::table('order')
               ->where('pid',$interface->order_id)
               ->where('pro_id',2)
               ->where('name',$interface->name)
               ->where('state',1)
               ->get()->first();
           if ($order)
           {
               $enterpriseLitigationInquiry = new Src\enterpriseLitigationInquiry();
               $report = $enterpriseLitigationInquiry->inquiry_info($interface->id, $interface->result_code);
           }
       }
       if (isset($report))
       {
           $total=$report["pagination"]->totalPage;
           $pram="?username=shbd&accessToken=40db8b4b95ac91ed6e905c80d45ebac5";
           $baseurl="https://rip.linrico.com/enterpriseLitigationInquiry/result".$pram."&name=".urlencode($interface->name);
           if ($interface->api_name=="personalComplaintInquiry")
           {
               $attach=Person_attach::where('order_id',$interface->order_id)->first();
               $baseurl="https://rip.linrico.com/personalComplaintInquiry/result".$pram."&name=".urlencode($interface->name)."&idCard=".$attach->cardNo;
           }
           if ($total>1) {
               $j = 0;
               for ($i = 2; $i < $total; $i++) {
                   $curl_url = $baseurl . '&pageIndex=' . $i;
                   $chArr[$j] = curl_init();
                   curl_setopt($chArr[$j], CURLOPT_URL, $curl_url);
                   curl_setopt($chArr[$j], CURLOPT_RETURNTRANSFER, 1);
                   //curl_setopt($chArr[$i], CURLOPT_HEADER, 1);
                   curl_setopt($chArr[$j], CURLOPT_HTTPHEADER, array("Content-type: application/json;charset='utf-8'"));
                   curl_setopt($chArr[$j], CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
                   curl_setopt($chArr[$j], CURLOPT_SSL_VERIFYHOST, FALSE);
                   curl_setopt($chArr[$j], CURLOPT_TIMEOUT, 5);
                   $j++;
               }
               $mh = curl_multi_init(); //1 创建批处理cURL句柄
               foreach ($chArr as $k => $ch) {
                   curl_multi_add_handle($mh, $ch); //2 增加句柄
               }
               $active = null;
               $order->state = 2;
               do {
                   while (($mrc = curl_multi_exec($mh, $active)) == CURLM_CALL_MULTI_PERFORM) ;
                   if ($mrc != CURLM_OK) {
                       break;
                   }
                   // a request was just completed -- find out which one
                   while ($done = curl_multi_info_read($mh)) {
                       //get the info and content returned on the request
                       $info = curl_getinfo($done['handle']);
                       $error = curl_error($done['handle']);
                       $result = curl_multi_getcontent($done['handle']);//链接返回值；
                       $parse = parse_url($info['url']);
                       $base = new Src\base();
                       $params = $base->convertUrlQuery($parse["query"]);
                       $inter["name"] = isset($params["name"]) ? urldecode($params["name"]) : urldecode($params["key"]);
                       $inter["pagesize"] = isset($params["pageNum"]) ? $params["pageNum"] : isset($params["pageIndex"]) ? $params["pageIndex"] : 0;
                       $inter["interface_id"] = $interface->interface_id;
                       $inter["order_id"] = $interface->order_id;
                       //$inter["auth_id"]=$auth['id'];
                       $inter["openid"] = $_SESSION['wechat_user']['id'];;
                       $inter["result_code"] = $result;
                       $inter["url"] = $info['url'];
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
           }
           $order->save();//订单状态值改变
            return true;
       }
       else
       {
           return "不存在已付款的订单";
       }

    }
}
