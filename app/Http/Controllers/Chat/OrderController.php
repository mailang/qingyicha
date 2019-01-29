<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
     function list()
     {
         $openid='offTY1fb81WxhV84LWciHzn4qwqU';//$_SESSION['wechat_user']['id'];
         $orderlist=DB::table('product')->leftJoin('order','product.id','=','order.pro_id')
             ->where('order.openid',$openid)
             ->get(['order.id','order.state','order.out_trade_no','order.total_fee','cash_fee','time_start','product.pro_name','product.icon']);
         return view('wechat.order.list',compact('orderlist'));
     }
     function  order_info($id)
     {
         if ($id)
         {
             $orderlist=DB::table('product')->leftJoin('order','product.id','=','order.pro_id')
                 ->where('order.id',$id)
                 ->get(['order.id','order.state','order.out_trade_no','order.total_fee','cash_fee','time_start','product.pro_name','product.icon']);
             $order=$orderlist->first();
             return view('wechat.order.info',compact('order'));
         }
     }

}
