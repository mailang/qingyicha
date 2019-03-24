<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Return_fee extends Model
{
    protected  $table="return_fee";
    protected $fillable=[
        'pro_id','order_id','referee','openid','fee','price','state'
    ];
}
