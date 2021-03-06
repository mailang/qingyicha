<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019/2/26
 * Time: 13:10
 */

namespace App\Src;
use Illuminate\Support\Facades\DB;


class inTheNetworkTime
{
    /*手机在网时长*/
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
//                    {"result":"","total":"","code":"200","data":{"OUTPUT1":"(24,+)"},"tradeNo":"HUOJU1551158730004","param":"","start":"","pageSize":"","end":"","message":"请求成功","pageNum":""}
                    $data=$jsson->data;
                    $re["state"]=1;
                    if ($data->OUTPUT1=="(24,+)") $re["OUTPUT1"]="24个月以上";
                     else if ($data->OUTPUT1=="(0,6)")  $re["OUTPUT1"]="0 到 6 个月";
                }
                else
                {
                    $re["state"]=0;
                    $re["msg"]="未查询到相关数据";
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