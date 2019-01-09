<?php
/*分享二维码的地址链接*/
Route::get("/weixin/tuiguang",['uses'=>"TuiguangController@tuiguang",'as'=>'weixin.tuiguang']);
/*我的*/
Route::get("/chat/my",['uses'=>"MyController@mine",'as'=>'weixin.my']);