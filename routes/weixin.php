<?php
/*我的*/
Route::get("/chat/my",['uses'=>"MyController@mine",'as'=>'weixin.my']);
/*征信查询*/
Route::get("/credit/apply",['uses'=>"CreditController@apply",'as'=>'credit.apply']);