<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_interface extends Model
{
    protected $table='user_interface';
    protected $fillable=['interface_id','auth_id','open_id','result_code','state'];
}
