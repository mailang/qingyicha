<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    protected $table="authorization";
    protected $fillable=['openid','name','phone','cardNo','authorizePhoto','entname','creditCode','licensePlate'
     ,'carType','vin','engineNo','bankcard'];
}
