<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019/2/19
 * Time: 9:39
 */
namespace App\Src;
use  Illuminate\Support\Facades\DB;

class personalEnterprise
{
    /*名下企业查询
    *"state" => 1
    *"punished" => []
    *"corporates" => array:1
    *"corporateManagers" => array:1
    "corporateShareholders" => array:2
    */
    public function  handle_data($id,$order_id,$result)
     {
               $re=array();
               if ($result!="")
                {
                    $jsson=json_decode($result);
                    if (isset($jsson->success)&&$jsson->success==false)
                    {
                        //$jsson->code=='100000002'余额不足；100000003 接口已关闭
                        DB::table('user_interface')->where('id', $id)->update(["state" => 0]);
                        DB::table('order')->where('id', $order_id)->update(["state" => 3]);
                    }
                    else
                    if (isset($jsson->success)&&$jsson->success==true)   {
                        //{"success":true,"requestOrder":"6416a694d2634fdfa5a5832197183794","data":{"key":"340825198908154735","status":"NO_DATA"}}
                         $data=$jsson->data;
                         if($data->status=="NO_DATA"){
                            $re["state"]=0;//无企业
                         }
                         else{if ($data->status=="EXIST"){
                             /*有企业*/
                             $re["state"]=1;
                             $re["punished"]=$data->punished;
                             $re["corporates"]=$data->corporates;
                             $re["corporateManagers"]=$data->corporateManagers;
                             $re["corporateShareholders"]=$data->corporateShareholders;
                             $re["caseInfos"]=$data->caseInfos;

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