<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_result extends Model
{
    protected $table='order_result';
    protected $fillable=['wxuser_id','auth_id','open_id','out_trade_no','transaction_id'
    ,'return_code','return_msg','nonce_str','sign','result_code','err_code','trade_type','prepay_id'];
}
