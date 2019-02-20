<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019/2/19
 * Time: 16:00
 */

namespace App\Src;
use Illuminate\Support\Facades\DB;


class thePhoneIsOnTheInternet
{
      /*手机在网状态*/
    public function  handle_data($id,$order_id,$result)
    {
        $re=array();
        if ($result!="")
        {
            $jsson=json_decode($result);
            if (isset($jsson->success)&&$jsson->success==false)
            {
                //'100000002'余额不足；100000003 接口已关闭
                DB::table('user_interface')->where('id', $id)->update(["state" => 0]);
                DB::table('order')->where('id', $order_id)->update(["state" => 3]);
            }
            else
            {
                if (isset($jsson->code)&&$jsson->code=="200")   {
                    //{"result":"","total":"","code":"200","data":{"operators":"联通","status":"1"},"tradeNo":"HUOJU1550474219344","param":"","start":"","pageSize":"","end":"","message":"请求成功","pageNum":""}
                    $data=$jsson->data;
                    $re["state"]=1;
                    $re["operators"]=$data->operators;
                    switch ($data->status)
                    { // 手机状态（1：在网，2：停机，3：销号，4：在网但不可用，5：空号，6：不在网，7：未启用，8：无法查询）
                        case "1":$re["status"]="在网";break;
                        case "2":$re["status"]="停机";break;
                        case "3":$re["status"]="销号";break;
                        case "4":$re["status"]="在网但不可用";break;
                        case "5":$re["status"]="空号";break;
                        case "6":$re["status"]="不在网";break;
                        case "7":$re["status"]="未启用";break;
                        case "8":$re["status"]="无法查询";break;
                        default:break;
                    }
                    }
                    else
                    {
                        $re["state"]=0;
                        switch ($jsson->code)
                        {
                            case "500":$re["msg"]="请求失败";break;
                            case "503":$re["msg"]="接口 serviceCode 非法";break;
                            case "504":$re["msg"]="key 非法";break;
                            case "505":$re["msg"]="余额不足";break;
                            case "506":$re["msg"]="接口次数不足";break;
                            case "507":$re["msg"]="接口未开通";break;
                            case "1002":$re["msg"]="查询失败";break;
                            case "555":$re["msg"]="IP不在白名单";break;
                            default:break;
                        }
                    }
            }
        }
        else { //返回数据为空，请求出现异常
            DB::table('user_interface')->where('id', $id)->update(["state" => 0]);
            DB::table('order')->where('id', $order_id)->update(["state" => 3]);
        }
        return $re;
    }
}