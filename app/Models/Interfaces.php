<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interfaces extends Model
{
    protected  $table='interfaces';
    protected  $fillable=['interface','api_name','description','isenable','type','price','sort'];
}
