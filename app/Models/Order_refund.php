<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_refund extends Model
{
    protected $table='order_refund';
    protected $fillable=['wxuser_id','openid','refundNumber',
        'transaction_id','total_fee','refund_fee'];
}
