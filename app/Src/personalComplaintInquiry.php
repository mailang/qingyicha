<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019/2/19
 * Time: 15:18
 */

namespace App\Src;
use Illuminate\Support\Facades\DB;


class personalComplaintInquiry
{
    /**
     * 个人涉诉查询
     */
    public function  handle_data($id,$order_id,$result)
    {
        $re=array();
        if ($result!="")
        {
            $jsson=json_decode($result);
            if (isset($jsson->success)&&$jsson->success==false&&$jsson->code=='100000002')
            {
                DB::table('user_interface')->where('id', $id)->update(["state" => 0]);
                DB::table('order')->where('id', $order_id)->update(["state" => 3]);
            }
            else {
                if (isset($jsson->success)&&$jsson->success==true)   {
                    //{"success":true,"requestOrder":"cb73d87c76cb4bd1bf76bee6774747d3",
                    //"data":{"identityCard":"340825198908154735","name":"张承林",
                    //"pagination":{"pageIndex":1,"totalPage":1,"resultSize":0,"pageSize":20,"officialAccountAmount":0,"testAccountAmount":0,"totalAccountAmount":0}
                    //,"pageData":[],
                    //"statistic":{"ktggResultSize":0,"cpwsResultSize":0,"zxggResultSize":0,"sxggResultSize":0,"fyggResultSize":0,"wdhmdResultSize":0,"ajlcResultSize":0,"bgtResultSize":0},"checkStatus":"NO_DATA"}}
                    $data=$jsson->data;
                    $re["state"]=1;
                    $re["pagination"]=$data->pagination;
                    $re["statistic"]=$data->statistic;
                    }
                    else {$re["state"]=0;$re["msg"]="接口请求失败";}
                }
        }
        else { //返回数据为空，请求出现异常
            DB::table('user_interface')->where('id', $id)->update(["state" => 0]);
            DB::table('order')->where('id', $order_id)->update(["state" => 3]);
        }
        return $re;
    }
    /*
     *获取个人涉诉详情
     * $id user_interface表id
     * $result user_interface表result_code
     */
    function inquiry_info($id,$result)
    {
        $re=array();
        if ($result!="")
        {
            $jsson=json_decode($result);
            if (isset($jsson->success)&&$jsson->success==false&&$jsson->code=='100000002')
            {
                DB::table('user_interface')->where('id', $id)->update(["state" => 0]);
            }
            else {
                if (isset($jsson->success)&&$jsson->success==true)   {
                    //{"success":true,"requestOrder":"cb73d87c76cb4bd1bf76bee6774747d3",
                    //"data":{"identityCard":"340825198908154735","name":"张承林",
                    //"pagination":{"pageIndex":1,"totalPage":1,"resultSize":0,"pageSize":20,"officialAccountAmount":0,"testAccountAmount":0,"totalAccountAmount":0}
                    //,"pageData":[],
                    //"statistic":{"ktggResultSize":0,"cpwsResultSize":0,"zxggResultSize":0,"sxggResultSize":0,"fyggResultSize":0,"wdhmdResultSize":0,"ajlcResultSize":0,"bgtResultSize":0},"checkStatus":"NO_DATA"}}
                    $data=$jsson->data;
                    $re["state"]=1;
                    $re["name"]=$data->name;
                    $re["pagination"]=$data->pagination;
                    $re["pageData"]=$data->pageData;
                }
                else {$re["state"]=0;$re["msg"]="接口请求失败";}
            }
        }
        else { //返回数据为空，请求出现异常
            DB::table('user_interface')->where('id', $id)->update(["state" => 0]);
        }
        return $re;

    }
}