<?php
/*我的*/
Route::get("/chat/my",['uses'=>"MyController@mine",'as'=>'weixin.my']);
/*征信查询*/
Route::get("/credit/apply",['uses'=>"CreditController@apply",'as'=>'credit.apply']);
Route::get("/credit/code",['uses'=>"CreditController@validate_code",'as'=>'validate.code']);//获取验证码
Route::post("/credit/authorization",['uses'=>"CreditController@validate_store",'as'=>'authorization.store']);