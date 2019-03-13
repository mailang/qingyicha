<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019/3/11
 * Time: 10:06
 */

namespace App\Src;
use Illuminate\Support\Facades\DB;


class businessData
{
     /*企业工商数据
     * 显示企业的工商数据信息
     *  $id 表user_interface order_id
     * $name 要查询的企业名
     * */
 function  get_data($id,$result)
 {
     $re=array();
     if ($result!="")
     {
         $jsson=json_decode($result);
         if (isset($jsson->success)&&$jsson->success==false)
         { //'100000002'余额不足；100000003 接口已关闭
             DB::table('user_interface')->where('id', $id)->update(["state" => 0]);
         }
         else
         {
                 $data=$jsson->data;
                 if($data->status=='EXIST'){
                     $re["state"]=1;
                     $re["basic"]=$data->basic;//企业基本信息
                     $re["shareholder"]=$data->shareholder;//股东信息
                     $re["shareholderPersons"]=$data->shareholderPersons;//高管信息
                     $re["legalPersonInvests"]=$data->legalPersonInvests;//法人对外投资信息
                     $re["legalPersonPostions"]=$data->legalPersonPostions;//法人其他任职信息
                     $re["enterpriseInvests"]=$data->enterpriseInvests;//企业对外投资信息
                     $re["alterInfos"]=$data->alterInfos;//变更信息
                     $re["filiations"]=$data->filiations;//分支机构信息
                     $re["punishBreaks"]=$data->punishBreaks;//失信被执行人信息
                     $re["punished"]=$data->punished;//被执行人信息
                     $re["sharesFrosts"]=$data->sharesFrosts;//股权冻结历史信息
                     $re["liquidations"]=$data->liquidations;//清算信息
                     $re["caseInfos"]=$data->caseInfos;//行政处罚历史信息
                     $re["morguaInfos"]=$data->morguaInfos;//动产抵押物信息
                     $re["mortgageAlter"]=$data->mortgageAlter;//动产抵押-变更信息
                     $re["mortgageCancels"]=$data->mortgageCancels;//动产抵押-注销信息
                     $re["mortgageDebtors"]=$data->mortgageDebtors;//动产抵押-被担保主债权信息
                     $re["mortgagePersons"]=$data->mortgagePersons;//动产抵押-抵押人信息
                     $re["mortgageRegisters"]=$data->mortgageRegisters;//动产抵押-登记信息
                     $re["breakLaw"]=$data->breakLaw;//严重违法信息
                     $re["exceptionLists"]=$data->exceptionLists;//企业异常名录
                     $re["orgBasics"]=$data->orgBasics;//组织机构代码
                     $re["orgDetails"]=$data->orgDetails;//股权出质信息详情
                     $re["equityInfos"]=$data->equityInfos;//股权出质信息
                     $re["equityChangeInfos"]=$data->equityChangeInfos;//股权出质信息-变更信息
                     $re["cancellationOfInfos"]=$data->cancellationOfInfos;//股权出质信息-注销信息
                     $re["tradeMarks"]=$data->tradeMarks;//注册商标
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
     }
     return $re;
 }
}