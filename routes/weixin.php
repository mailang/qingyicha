<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/27
 * Time: 14:23
 */
Route::any('/wechat', ['use'=>'weixin/WechatinitController@serve']);//微信接入