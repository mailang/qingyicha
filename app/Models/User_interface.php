<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_interface extends Model
{
    protected $table='user_interface';
    protected $fillable=['interface_id','order_id','auth_id','openid','result_code','url','state','pagesize','name'];
}
