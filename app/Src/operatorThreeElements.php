<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019/3/13
 * Time: 13:48
 */

namespace App\Src;
use  Illuminate\Support\Facades\DB;
class operatorThreeElements
{
    /*手机在网状态*/
    public function handle_data($id, $order_id, $result)
    {
        $re = array();
        if ($result != "") {
            $jsson = json_decode($result);
            if (isset($jsson->success) && $jsson->success == false) {
                //'100000002'余额不足；100000003 接口已关闭
                DB::table('user_interface')->where('id', $id)->update(["state" => 0]);
                DB::table('order')->where('id', $order_id)->update(["state" => 3]);
                $re["state"]=0; $re["msg"]="服务商余额不足";
            } else {
                if (isset($jsson->code) && $jsson->code == "200") {
                      $re["data"]=$jsson->data;
                      $re["state"]=1;
                }
            }
        }
        else
        {
            //'100000002'余额不足；100000003 接口已关闭
            DB::table('user_interface')->where('id', $id)->update(["state" => 0]);
            DB::table('order')->where('id', $order_id)->update(["state" => 3]);
            $re["state"]=0; $re["msg"]="未查到相关消息";
        }
        return $re;
    }
}