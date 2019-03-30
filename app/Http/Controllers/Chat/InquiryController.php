<?php

namespace App\Http\Controllers\Chat;

use App\Models\Interfaces;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\User_interface;
use Illuminate\Support\Facades\DB;
use App\Src;
use App\Models\Wxuser;
use App\Src\base;
use App\Models\Person_attach;

class InquiryController extends Controller
{
    /*企业涉诉首页
     * $id order表中pid=-1的订单id举例
     */
    function enterprise($id, $name, $page = 1)
    {
        //pro_id为2是企业涉诉
        $order=DB::table('order')
            ->where('pid',$id)
            ->where('pro_id',2)
            ->where('name',$name)
            ->where('state','>',0)
            ->get();
        $data=array("order_id"=>$id,"current"=>$page);
        if (count($order)>0)
        {
            //存在已付款的该企业的涉诉详情，并取出要查询的页数
            $list = DB::table('user_interface')->leftJoin('interfaces', 'interfaces.id', '=', 'user_interface.interface_id')
                ->where('order_id', $id)
                ->where('user_interface.pagesize', $page)
                ->where('name', $name)
                ->where('interfaces.api_name', 'enterpriseLitigationInquiry')
                ->get(['user_interface.id', "interface_id", "order_id", "auth_id", "openid", "result_code", "url", 'state', 'pagesize']);
            if (count($list)>0)
            { $interface = $list->first();
                $enterpriseLitigationInquiry = new Src\enterpriseLitigationInquiry();
                $report = $enterpriseLitigationInquiry->inquiry_info($interface->id, $interface->result_code);
                if ($report != null)
                    return view('wechat.inquiry.cominquiry', compact('report','data'));
                else
                    return '服务商请求数据异常,请联系服务商';
            }
            else
            {   //查询的页数还未抓取，调用易天下接口去抓取该页数据
                $pram="?username=shbd&accessToken=40db8b4b95ac91ed6e905c80d45ebac5";
                $baseurl="https://rip.linrico.com/enterpriseLitigationInquiry/result".$pram."&name=".urlencode($name);
                $curl_url =  $baseurl . '&pageIndex=' . $page;
                $base=new base();
                $result_code=$base->get_curl($curl_url);
                if ($result_code!="")
                {
                    $interfaces=Interfaces::where("api_name","enterpriseLitigationInquiry")->first();
                    $data["interface_id"]=$interfaces->id;
                    $data["order_id"]=$id;
                    $data["openid"]=$_SESSION['wechat_user']['id'];
                    $data["result_code"]=$result_code;
                    $data["url"]=$curl_url;
                    $data["state"]=1;
                    $data["pagesize"]=$page;
                    $data["name"]=$name;
                    User_interface::create($data);
                    $enterpriseLitigationInquiry = new Src\enterpriseLitigationInquiry();
                    $report = $enterpriseLitigationInquiry->inquiry_info($interfaces->id, $result_code);
                    if ($report != null)
                        return view('wechat.inquiry.cominquiry', compact('report','data'));
                    else
                        return '服务商请求数据异常,请联系服务商';
                }
                else
                    return '服务商请求链接异常,请联系服务商';

            }
        }
        else {
            //没有购买，购买详情的查询数据
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
            ->where('pro_id',3)
            ->where('name',$name)
            ->where('state','>',0)
            ->get();
        $data=array("order_id"=>$id,"current"=>$page);
        if (count($order)>0) {
            $list = DB::table('user_interface')->leftJoin('interfaces', 'interfaces.id', '=', 'user_interface.interface_id')
                ->where('order_id', $id)
                ->where('user_interface.pagesize', $page)
                ->where('interfaces.api_name', 'personalComplaintInquiry')
                ->get(['user_interface.id', "interface_id", "order_id", "auth_id", "openid", "result_code", "url", 'state', 'pagesize']);
               if (count($list)>0)
               {
                   $interface = $list->first();
                   $personalComplaintInquiry = new Src\personalComplaintInquiry();
                   $report = $personalComplaintInquiry->inquiry_info($interface->id, $interface->result_code);
                   if ($report != null)
                       return view('wechat.inquiry.persoinquiry', compact('report','data'));
                   else
                       return '服务商请求数据异常,请联系服务商';
               }
               else
               {
                   //查询的页数还未抓取，调用易天下接口去抓取该页数据
                   $pram="?username=shbd&accessToken=40db8b4b95ac91ed6e905c80d45ebac5";
                   $attach=Person_attach::where('order_id',$id)->first();
                   $baseurl="https://rip.linrico.com/personalComplaintInquiry/result".$pram."&name=".urlencode($name)."&idCard=".$attach->cardNo;
                   $curl_url =  $baseurl . '&pageIndex=' . $page;
                   $base=new base();
                   $result_code=$base->get_curl($curl_url);
                   if ($result_code!="")
                   {
                       $interfaces=Interfaces::where("api_name","enterpriseLitigationInquiry")->first();
                       $data["interface_id"]=$interfaces->id;
                       $data["order_id"]=$id;
                       $data["openid"]=$_SESSION['wechat_user']['id'];
                       $data["result_code"]=$result_code;
                       $data["url"]=$curl_url;
                       $data["state"]=1;
                       $data["pagesize"]=$page;
                       $data["name"]=$name;
                       User_interface::create($data);
                       $personalComplaintInquiry = new Src\personalComplaintInquiry();
                       $report = $personalComplaintInquiry->inquiry_info($interfaces->id, $result_code);
                       if ($report != null)
                           return view('wechat.inquiry.cominquiry', compact('report','data'));
                       else
                           return '服务商请求数据异常,请联系服务商';
                   }
                   else
                       return '服务商请求链接异常,请联系服务商';
               }
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
            $name=$_POST["name"];
            $pro_id=$_POST["pro_id"];
            $pid=$_POST["pid"];
            $app = app('wechat.payment');
            $jssdk = $app->jssdk;
            $openid=$_SESSION['wechat_user']['id'];
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
                return json_encode($config);
            }
            else return json_encode(array("state"=>0,"msg"=>"下单失败"));
    }
    function payback($user_interid)
    {
        $user_interface=User_interface::find($user_interid);
        return view('wechat.inquiry.payback',compact('user_interface'));
    }
    /*用户购买查看详情页数，付款成功后默认给查看第一页，
    *存在其他页用户点击后才抓取查看其他页
    */
    function check_inquiry($user_interid)
    {
        $re="";
        //没有购买，购买下一页的查询数据
        $interface=DB::table('user_interface')->leftJoin('interfaces', 'interfaces.id', '=', 'user_interface.interface_id')
            ->where('user_interface.id', $user_interid)
            ->get(['user_interface.id','user_interface.name', "interface_id", "order_id", "api_name","url", "result_code", 'state', 'pagesize'])->first();
        if ($interface)
       {
           $order=DB::table('order')
               ->where('pid',$interface->order_id)
               ->where('pro_id',3)
               ->where('name',$interface->name)
               ->where('state',1)
               ->get()->first();
           if (!$order) {
              $re="不存在已付款的订单";
           }
       }
       return $re;
    }
}
