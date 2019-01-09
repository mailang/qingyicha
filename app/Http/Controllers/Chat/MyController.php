<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyController extends Controller
{

    function  mine()
    {
        return view('wechat.my.my');

    }

}
