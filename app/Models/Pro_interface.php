<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pro_interface extends Model
{
    protected  $table="pro_interface";
    protected $fillable=[
        'interface_id','pro_id','isenable'
    ];
}
