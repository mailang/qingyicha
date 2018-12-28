<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wemenu extends Model
{
    protected $table = "wemenu";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'pid', 'type','name','key', 'url','media_id','appid','pagepath','sub','enable'
    ];
}
