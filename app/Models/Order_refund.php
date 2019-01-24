<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_refund extends Model
{
    protected $table='order_refund';
    protected $fillable=['order_id','openid','refundNumber',
        'transaction_id','out_trade_no','total_fee','refund_fee','refund_id'];
}