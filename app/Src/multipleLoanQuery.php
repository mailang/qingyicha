<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019/2/20
 * Time: 14:08
 */

namespace App\Src;
use Illuminate\Support\Facades\DB;


class multipleLoanQuery
{

    /**
     * 多重借贷
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
                   // {"success":true,"requestOrder":"29216df9ba804c219f56b154dbb171ef",
                    //"data":{"phone":"15675515689","creditPlatformRegistrationDetails":[],"loanApplicationDetails":[],"loanDetails":[],"loanRejectDetails":[],"overduePlatformDetails":[],"arrearsInquiry":[],"status":"SUCCESS","statusDesc":"查询成功"}}
                    $data=$jsson->data;
                    $re["state"]=1;
                    $re["creditPlatformRegistrationDetails"]=$data->creditPlatformRegistrationDetails;
                    $re["loanApplicationDetails"]=$data->loanApplicationDetails;
                    $re["loanDetails"]=$data->loanDetails;
                    $re["loanRejectDetails"]=$data->loanRejectDetails;
                    $re["overduePlatformDetails"]=$data->overduePlatformDetails;
                    $re["arrearsInquiry"]=$data->arrearsInquiry;
                }
                else {$re["state"]=0;$re["msg"]="接口请求出错";}
            }
        }
        else { //返回数据为空，请求出现异常
            DB::table('user_interface')->where('id', $id)->update(["state" => 0]);
            DB::table('order')->where('id', $order_id)->update(["state" => 3]);
        }
        return $re;
    }
}