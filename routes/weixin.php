<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/27
 * Time: 14:23
 */
Route::any('/wechat', ['uses'=>'WechatController@serve','as'=>'weixin.rrr']);//微信接入