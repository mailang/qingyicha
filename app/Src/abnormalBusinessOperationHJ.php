<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019/3/5
 * Time: 17:17
 */

namespace App\Src;
use  Illuminate\Support\Facades\DB;


class abnormalBusinessOperationHJ
{
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
                //  "data": {"total": 2,"items": [{"createTime": "2017-04-09","putDate": "2015-07-14","removeDate": "2016-04-15","removeDepartment": "长沙市工商行政管理局天心分局","removeReason": "依法补报了未报年份的年度报告并公示","putReason": "未按照规定报送 2014 年度年度报告","putDepartment": "长沙市工商行政管理局天心分局"}]},
                    $data=$jsson->data;
                    $re["state"]=1;
                    $re["data"]=$data->items;
                    $re["total"]=2;
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