<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscribeController extends Controller
{

    function init()
    {
            $content=file_get_contents(app_path('Src/chat.json'));
            $data=\GuzzleHttp\json_decode($content);
            $subscribe=$data[0]->subscribe;
       return view('admin.wechat.subscribe',compact('subscribe'));
    }
    /*修改配置文件内容*/
    function store(Request $request)
    {
            $req=$request->all();
            $path=app_path('Src/chat.json');
            $content=file_get_contents($path);
            $data=\GuzzleHttp\json_decode($content);
            $data[0]->subscribe=$req["description"];
            $jsonstr=\GuzzleHttp\json_encode($data);
            file_put_contents($path,$jsonstr);
            return redirect()->back();
    }
}
