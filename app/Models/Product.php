<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected  $table='product';
    protected  $fillable=['pro_name','module','description','icon','url','price','return_fee','isindex','isenable'];
}
