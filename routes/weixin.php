<?php
/*我的*/
Route::get("/chat/my",['uses'=>"MyController@mine",'as'=>'weixin.my']);