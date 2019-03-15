<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use  App\Models\Person_attach;
use App\Src;



class ReportController extends Controller
{
    /*生成信用报告*/
    function report($id)
    {
       // $openid = $_SESSION['wechat_user']['id'];

        $list=DB::table('user_interface')->leftJoin('interfaces','user_interface.interface_id','=','interfaces.id')
            ->where('user_interface.state',1)
            ->where('order_id',$id)
            ->where('pagesize','<=',1)
           // ->whereIn('user_interface.id',[35,37])//test
            ->get(['interfaces.api_name','user_interface.id','user_interface.state','interface_id','order_id','auth_id','result_code','user_interface.created_at']);
            if(count($list)>0){
            $report=array();
            $report['enterpriseInquiry']=array();
            foreach ($list as $key=>$item) {
            $result = $item->result_code;
            $api_name = $item->api_name;
            switch ($api_name) {
                /*个人名下企业*/
                case "personalEnterprise":$personalEnterprise = new Src\personalEnterprise();$data = $personalEnterprise->handle_data($item->id,$item->order_id,$result);$report['company']=$data;break;
                /*个人涉诉查询*/
                case "personalComplaintInquiry":$personalComplaintInquiry = new Src\personalComplaintInquiry();$data = $personalComplaintInquiry->handle_data($item->id,$item->order_id,$result);$report['personInquiry']=$data;break;
                /*企业涉诉*/
                case "enterpriseLitigationInquiry":$enterpriseLitigationInquiry = new Src\enterpriseLitigationInquiry();$data = $enterpriseLitigationInquiry->handle_data($item->id,$item->order_id,$result);array_push($report['enterpriseInquiry'],$data);break;
                /*手机在网状态*/
                case "thePhoneIsOnTheInternet":$thePhoneIsOnTheInternet= new Src\thePhoneIsOnTheInternet();$data = $thePhoneIsOnTheInternet->handle_data($item->id,$item->order_id,$result);$report['phone']=$data;break;
               /*多重借贷*/
                case "multipleLoanQuery":$multipleLoanQuery= new Src\multipleLoanQuery();$data = $multipleLoanQuery->handle_data($item->id,$item->order_id,$result);$report['multipleLoan']=$data;break;
                /*在网时长*/
                case "inTheNetworkTime":$inTheNetworkTime= new Src\inTheNetworkTime();$data = $inTheNetworkTime->handle_data($item->id,$item->order_id,$result);$report['inTheNetworkTime']=$data;break;
                /*企业基本信息*/
                case "basicInformationOfTheEnterpriseHJ":$basicInformationOfTheEnterpriseHJ= new Src\basicInformationOfTheEnterpriseHJ();$data = $basicInformationOfTheEnterpriseHJ->handle_data($item->id,$item->order_id,$result);$report['basicInformationOfTheEnterpriseHJ']=$data;break;
                /*企业异常*/
                case "abnormalBusinessOperationHJ":$abnormalBusinessOperationHJ= new Src\abnormalBusinessOperationHJ();$data = $abnormalBusinessOperationHJ->handle_data($item->id,$item->order_id,$result);$report['abnormalBusinessOperationHJ']=$data;break;
                /*运营商三要素*/
                case "operatorThreeElements":$operatorThreeElements= new Src\operatorThreeElements();$data = $operatorThreeElements->handle_data($item->id,$item->order_id,$result);$report['operatorThreeElements']=$data;break;

                /*
                case "businessData";if ($user['creditCode']!="")$url="https://rip.linrico.com/businessData/result".$pram."&key=".urlencode($user['creditCode'])."&keyType=2";else {if ($user['entname']!="")$url="https://rip.linrico.com/businessData/result".$pram."&key=".urlencode($user['entname'])."&keyType=1";} break;
                case "mobileConsumptionLevel";$url="https://rip.linrico.com/mobileConsumptionLevel/result".$pram."&phone=".$phone;break;
                case "bankCardFourElements";if ($user['bankcard']!="")$url="https://rip.linrico.com/bankCardFourElements/result".$pram."&name=".$name."&idNumber=".$idCard."&bankCard=".urlencode($user['bankcard'])."&mobile=".$phone; break;
                case  "personSubjectToEnforcementHJ":if($user['entname']!="")$url="https://rip.linrico.com/personSubjectToEnforcementHJ/result".$pram."&name=".urlencode($user['entname'])."&pageNum=1";break;
                case  "administrativePenaltyInformationHJ":if($user['entname']!="")$url="https://rip.linrico.com/administrativePenaltyInformationHJ/result".$pram."&name=".urlencode($user['entname'])."&pageNum=1";break;
                case  "abnormalBusinessOperationHJ":if($user['entname']!="")$url="https://rip.linrico.com/abnormalBusinessOperationHJ/result".$pram."&name=".urlencode($user['entname'])."&pageNum=1";break;
                case  "businessBrokenPromisesHJ":$url="https://rip.linrico.com/businessBrokenPromisesHJ/result".$pram."&name=".urlencode($user['entname'])."&pageNum=1";break;
                case  "corporateLawHJ":$url="https://rip.linrico.com/corporateLawHJ/result".$pram."&name=".urlencode($user['entname'])."&pageNum=1";break;
                */
                default :
                    break;

            }
         }
        }
        $person=Person_attach::where('order_id',$id)->first();
        $person["time"]=Date('Y-m-d',strtotime($person->created_at));
        $report["order_id"]=$id;
        return view('wechat.report.report',compact('person','report'));
    }

    /*取出企业的详细信息
     * $id 表user_interface order_id
     * $name 要查询的企业名
     */
    function enterprise($id,$name)
    {
        $openid=$_SESSION['wechat_user']['id'];
        $list=DB::table('user_interface')->leftJoin('interfaces','interfaces.id','=','user_interface.interface_id')
            ->where('order_id',$id)
            ->where('openid',$openid)
            ->where('name',$name)
            ->where('interfaces.api_name','basicInformationOfTheEnterpriseHJ')
            ->get(['user_interface.id',"interface_id","order_id","auth_id","openid","result_code","url",'state','pagesize']);
        $enterprise=array();
        if (count($list)>0)
        {
            $interface=$list->first();
            $basicInformationOfTheEnterpriseHJ= new Src\basicInformationOfTheEnterpriseHJ();
            $enterprise['enterpriseHJ'] = $basicInformationOfTheEnterpriseHJ->handle_data($interface->id,$interface->order_id,$interface->result_code);
        }
        else
        {
            $enterprise["msg"]="未查询到详细的企业信息";
        }
        return view('wechat.report.enterprise',compact('enterprise'));
    }
    /*
     * 显示企业的工商数据信息
     *  $id 表user_interface order_id
     * $name 要查询的企业名
     * */
    function  businessData($id,$name)
    {

        $openid=$_SESSION['wechat_user']['id'];
        $list=DB::table('user_interface')->leftJoin('interfaces','interfaces.id','=','user_interface.interface_id')
            ->where('order_id',$id)
            ->where('openid',$openid)
            ->where('name',$name)
            ->where('interfaces.api_name','businessData')
            ->get(['user_interface.id',"interface_id","order_id","auth_id","openid","result_code","url",'state','pagesize']);
        $enterprise=array();
        if (count($list)>0)
        {
            $interface=$list->first();
            $businessData= new Src\businessData();
            $enterprise['businessData'] = $businessData->get_data($interface->id,$interface->result_code);
        }
        else
        {
            $enterprise["msg"]="未查询到详细的企业信息";
        }
        return view('wechat.report.businessdata',compact('enterprise'));
    }
}
