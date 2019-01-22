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
        $openid='o3MeN5knIrECm5dZys4nrOVRc5Ow';
        $data["openid"]=$openid;
        $data["name"]='张承林';
        $data["cardNo"]="340825198902194728";
        $data["phone"]='15675515689';
        $id=DB::table('authorization')->insertGetId($data);
        if ($id)
        {
            $user=Wxuser::where('openid',$openid)->first();
            $user["auth_id"]=$id;
            $user->save();
        }
        return "认证成功";
    }
}
