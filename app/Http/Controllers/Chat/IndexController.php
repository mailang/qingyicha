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
        return view('wechat.product.index',compact('products'));
    }
    /*产品的相关介绍*/
    function  product($id)
    {

     if ($id)
     {
         $product=Product::find($id);
        return view('wechat.product.product',compact('product'));
     }
    }
}
