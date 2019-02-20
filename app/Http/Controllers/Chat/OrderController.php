<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
     function orderlist($time)
     {
         $openid=$_SESSION['wechat_user']['id'];//$_SESSION['wechat_user']['id'];
         if ($time=="all")
         {
             $orderlist=DB::table('product')->leftJoin('order','product.id','=','order.pro_id')
                 ->where('order.openid',$openid)
                 ->get(['order.id','order.state','order.out_trade_no','order.total_fee','cash_fee','time_start','product.pro_name','product.icon']);
         }else
             $orderlist=DB::table('product')->leftJoin('order','product.id','=','order.pro_id')
                 ->where('order.openid',$openid)
                 ->whereDate('order.created_at','>',date('Y-m-d h:i:s',strtotime('-1 month')))
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
