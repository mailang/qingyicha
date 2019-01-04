<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/27
 * Time: 14:23
 */
Route::get("/weixin/tuiguang",['uses'=>"TuiguangController@tuiguang",'as'=>'weixin.tuiguang']);
