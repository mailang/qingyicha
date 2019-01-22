<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use  Illuminate\Support\Facades\DB;
use  App\Models\Wxuser;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function test()
    {

        //用户验证成功
        $msg=\GuzzleHttp\json_decode('{"success": false,"message": "授权成功","code": 1001,"timestamp": 1544535771604}');
        $openid='o3MeN5knIrECm5dZys4nrOVRc5Ow';
        if ($msg->code=='1001'&&$msg->success)
        {
            dd($msg->success);
            //用户验证成功
            $openid='lll';
            $data["openid"]=$openid;
            $data["name"]='test';
            $data["cardNo"]='2333';
            $data["phone"]='15675515689';
            $id=DB::table('authorization')->insertGetId($data);
            if ($id)
            {
                $user=Wxuser::where('openid',$openid)->first();
                $user["auth_id"]=$id;
                $user->save();
                return "认证成功";
            }
            else return "服务出错";
        }
    }
}
