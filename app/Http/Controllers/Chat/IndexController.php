<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Models\Product;
use App\Models\Wxuser;
use Illuminate\Support\Facades\URL;

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
        $openid=$_SESSION['wechat_user']['id'];//'offTY1fb81WxhV84LWciHzn4qwqU';
        $user=Wxuser::where('openid',$openid)->first();
        if ($user["auth_id"]!=null&&$user["auth_id"]>0) {
            if ($id) {
                $product = Product::find($id);
                return view('wechat.product.product', compact('product'));
            }
        }
        else
        {
            return redirect(route("validate.auth"))->with('reurl',URL::current());
        }
    }
}
