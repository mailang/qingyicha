<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wxuser extends Model
{
    protected $table = "wxuser";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'openid', 'nickname','sex','province', 'city','country','mobile','headimgurl','subscribe','referee','code'
    ];
}
