<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person_attach extends Model
{
    protected $table="authorization";
    protected $fillable=['openid','order_id','name','phone','cardNo','authorizePhoto','entname','creditCode','licensePlate'
        ,'carType','vin','engineNo','bankcard'];
}
