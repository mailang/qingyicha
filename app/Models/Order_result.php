<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_result extends Model
{
    protected $table='order_result';
    protected $fillable=['openid','order_id','out_trade_no','transaction_id'
    ,'return_code','result_code','result'];
}
