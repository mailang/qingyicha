<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TuiguangController extends Controller
{
    function tuiguang()
    {
         $reffer=$_GET["openid"];
         $code=$_GET["qyc_code"];

    }
}
