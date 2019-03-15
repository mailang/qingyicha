<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Person_attach;
use App\Src;

class InquiryController extends Controller
{
    /*企业涉诉首页
     * $id order表中pid=-1的订单id举例
     */
    function  enterprise($id,$name,$page=0)
    {
             $list=DB::table('user_interface')->leftJoin('interfaces','interfaces.id','=','user_interface.interface_id')
                 ->where('order_id',$id)
                 ->where('user_interface.pagesize',$page)
                 ->where('name',$name)
                 ->where('interfaces.api_name','enterpriseLitigationInquiry')
                 ->get(['user_interface.id',"interface_id","order_id","auth_id","openid","result_code","url",'state','pagesize']);
             if (count($list))
             {
                 $interface=$list->first();
                 $enterpriseLitigationInquiry = new Src\enterpriseLitigationInquiry();
                 $report = $enterpriseLitigationInquiry->inquiry_info($interface->id,$interface->result_code);
                 if ($report!=null)
                 return view('wechat.inquiry.cominquiry',compact('report'));
                 else
                     dd('服务商请求数据异常,请联系服务商');
             }
             else
             {
                 //没有购买，购买下一页的查询数据
                 $api["api_name"]="enterpriseLitigationInquiry";
                 $api["name"]=$name;
                 $api["page"]=$page;
                 $api["pid"]=$id;
                 return view('wechat.inquiry.apply',compact('api'));
             }
    }
  /*个人涉诉详情查询*/
    function person($id,$name,$page=0)
    {
        $list=DB::table('user_interface')->leftJoin('interfaces','interfaces.id','=','user_interface.interface_id')
            ->where('order_id',$id)
            ->where('user_interface.pagesize',$page)
            ->where('interfaces.api_name','personalComplaintInquiry')
            ->get(['user_interface.id',"interface_id","order_id","auth_id","openid","result_code","url",'state','pagesize']);
        if (count($list))
        {
            $interface=$list->first();
            $personalComplaintInquiry = new Src\personalComplaintInquiry();
            $report = $personalComplaintInquiry->inquiry_info($interface->id,$interface->result_code);
            if ($report!=null)
                return view('wechat.inquiry.persoinquiry',compact('report'));
            else
                dd('服务商请求数据异常,请联系服务商');
        }
        else
        {
            //没有购买，购买下一页的查询数据
            $api["api_name"]="personalComplaintInquiry";
            $api["name"]=$name;
            $api["page"]=$page;
            $api["pid"]=$id;
            return view('wechat.inquiry.apply',compact('api'));
        }
    }
}
