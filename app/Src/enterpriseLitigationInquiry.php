<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019/2/20
 * Time: 11:38
 */

namespace App\Src;
use Illuminate\Support\Facades\DB;


class enterpriseLitigationInquiry
{
    /**
     * 企业涉诉查询
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
                   // {"success":true,"requestOrder":"43cbc4ab61274ee9aab4a4891dbc2ea1",
                    //"data":{"name":"安徽迈杰客信息技术有限公司",
                    //"pagination":{"pageIndex":1,"totalPage":1,"resultSize":2,"pageSize":20,"officialAccountAmount":0,"testAccountAmount":0,"totalAccountAmount":0},
                    //"pageData":[{"title":"安徽迈杰客信息技术有限公司","name":"安徽迈杰客信息技术有限公司","caseStatus":"0","identificationNO":"55924010-1","executionTarget":38931.0,"id":"c2018340103zhi1134_t20180408_pahmjkxxjsyxgs@cG5hbWU65a6J5b696L%2BI5p2w5a6i5L%2Bh5oGv5oqA5pyv5pyJ6ZmQ5YWs5Y%2B4","recordTime":1523116800000,"content":"安徽迈杰客信息技术有限公司 执 5592401...","caseNO":"（2018）皖0103执1134号","court":"合肥市庐阳区人民法院","dataType":"ZXGG","time":"2018年04月08日"},{"title":"安徽迈杰客信息技术有限公司","name":"安徽迈杰客信息技术有限公司","caseStatus":"0","identificationNO":"91340100559****1015","executionTarget":27350.0,"id":"c2018340103zhi941_t20180316_pahmjkxxjsyxgs@cG5hbWU65a6J5b696L%2BI5p2w5a6i5L%2Bh5oGv5oqA5pyv5pyJ6ZmQ5YWs5Y%2B4","recordTime":1521129600000,"content":"安徽迈杰客信息技术有限公司 执 9134010...","caseNO":"（2018）皖0103执941号","court":"合肥市庐阳区人民法院","dataType":"ZXGG","time":"2018年03月16日"}],
                    //"statistic":{"ktggResultSize":0,"cpwsResultSize":0,"zxggResultSize":2,"sxggResultSize":0,"fyggResultSize":0,"wdhmdResultSize":0,"ajlcResultSize":0,"bgtResultSize":0},"checkStatus":"EXIST"}}
                    $data=$jsson->data;
                    $re["state"]=1;
                    $re["name"]=$data->name;
                    $re["pagination"]=$data->pagination;
                    $re["statistic"]=$data->statistic;
                }
                else {
                    //{"success":false,"code":80001001,"error":"LAW_ENTERPRISE_LAWSUIT_EXCEPTION","errorDesc":"企业风控数据源信息异常"}
                    $re["state"]=0; if (isset($jsson->errorDesc)) $re["msg"]=$jsson->errorDesc; else $re["msg"]="数据存在异常";}
            }
        }
        else { //返回数据为空，请求出现异常
            DB::table('user_interface')->where('id', $id)->update(["state" => 0]);
            DB::table('order')->where('id', $order_id)->update(["state" => 3]);
        }
        return $re;
    }
    /*
     *获取涉诉详情
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
                //余额不足
                DB::table('user_interface')->where('id', $id)->update(["state" => 0]);
            }
            else {
                if (isset($jsson->success)&&$jsson->success==true)   {
                    // {"success":true,"requestOrder":"43cbc4ab61274ee9aab4a4891dbc2ea1",
                    //"data":{"name":"安徽迈杰客信息技术有限公司",
                    //"pagination":{"pageIndex":1,"totalPage":1,"resultSize":2,"pageSize":20,"officialAccountAmount":0,"testAccountAmount":0,"totalAccountAmount":0},
                    //"pageData":[{"title":"安徽迈杰客信息技术有限公司","name":"安徽迈杰客信息技术有限公司","caseStatus":"0","identificationNO":"55924010-1","executionTarget":38931.0,"id":"c2018340103zhi1134_t20180408_pahmjkxxjsyxgs@cG5hbWU65a6J5b696L%2BI5p2w5a6i5L%2Bh5oGv5oqA5pyv5pyJ6ZmQ5YWs5Y%2B4","recordTime":1523116800000,"content":"安徽迈杰客信息技术有限公司 执 5592401...","caseNO":"（2018）皖0103执1134号","court":"合肥市庐阳区人民法院","dataType":"ZXGG","time":"2018年04月08日"},{"title":"安徽迈杰客信息技术有限公司","name":"安徽迈杰客信息技术有限公司","caseStatus":"0","identificationNO":"91340100559****1015","executionTarget":27350.0,"id":"c2018340103zhi941_t20180316_pahmjkxxjsyxgs@cG5hbWU65a6J5b696L%2BI5p2w5a6i5L%2Bh5oGv5oqA5pyv5pyJ6ZmQ5YWs5Y%2B4","recordTime":1521129600000,"content":"安徽迈杰客信息技术有限公司 执 9134010...","caseNO":"（2018）皖0103执941号","court":"合肥市庐阳区人民法院","dataType":"ZXGG","time":"2018年03月16日"}],
                    //"statistic":{"ktggResultSize":0,"cpwsResultSize":0,"zxggResultSize":2,"sxggResultSize":0,"fyggResultSize":0,"wdhmdResultSize":0,"ajlcResultSize":0,"bgtResultSize":0},"checkStatus":"EXIST"}}
                    $data=$jsson->data;
                    $re["state"]=1;
                    $re["name"]=$data->name;
                    $re["pageData"]=$data->pageData;
                    $re["pagination"]=$data->pagination;
                    //$re["statistic"]=$data->statistic;
                }
                else {
                    //{"success":false,"code":80001001,"error":"LAW_ENTERPRISE_LAWSUIT_EXCEPTION","errorDesc":"企业风控数据源信息异常"}
                    $re["state"]=0; if (isset($jsson->errorDesc)) $re["msg"]=$jsson->errorDesc; else $re["msg"]="数据存在异常";}
            }
        }
        else { //返回数据为空，请求出现异常
            DB::table('user_interface')->where('id', $id)->update(["state" => 0]);
        }
        return $re;
    }

}