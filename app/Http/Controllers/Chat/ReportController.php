<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use  App\Models\Authorization;
use App\Src;
use Monolog\Handler\IFTTTHandler;


class ReportController extends Controller
{
    function report($id)
    {
        $openid = $_SESSION['wechat_user']['id'];

        $list=DB::table('user_interface')->leftJoin('interfaces','user_interface.interface_id','=','interfaces.id')
            ->where('user_interface.state',1)
            ->where('openid',$openid)
            ->where('order_id',$id)
           // ->whereIn('user_interface.id',[35,37])//test
            ->get(['interfaces.api_name','user_interface.id','user_interface.state','interface_id','order_id','auth_id','result_code','user_interface.created_at']);
            if(count($list)>0){
            $auth_id=$list[0]->auth_id;
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
        //dd($report['enterpriseInquiry']);
        $auth=Authorization::find($auth_id);
        $auth["time"]=Date('Y-m-d',strtotime($list[0]->created_at));
        return view('wechat.report.report',compact('auth','report'));
    }

}
