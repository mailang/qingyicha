<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Models\Product;

class IndexController extends Controller
{
    function index()
    {
        //取出可查询的项目
        $products=Product::where('isenable',1)->get();
        return view('wechat.index.index',compact('products'));
    }
}
