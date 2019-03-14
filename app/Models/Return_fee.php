<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Return_fee extends Model
{
    protected  $table="pro_interface";
    protected $fillable=[
        'referee','openid','fee','price','state'
    ];
}
