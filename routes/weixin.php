<?php
/*我的*/
Route::get("/chat/my",['uses'=>"MyController@mine",'as'=>'weixin.my']);
/*首页*/
Route::get("/chat/index",['uses'=>"IndexController@index",'as'=>'weixin.index']);
Route::get("/product/info/{id}",['uses'=>"IndexController@product",'as'=>'weixin.product']);
/*基础查询接口*/
Route::get("/credit/apply/{id}",['uses'=>"CreditController@apply",'as'=>'credit.apply']);
Route::get("/credit/code",['uses'=>"CreditController@validate_code",'as'=>'validate.code']);//获取验证码
Route::post("/credit/authorization",['uses'=>"CreditController@validate_store",'as'=>'authorization.store']);//认证保存
Route::post("/apply/store",['uses'=>"CreditController@apply_store",'as'=>'apply.store']);//基础查询接口调用
/*协议*/
Route::get("/credit/xieyi",function(){return view('wechat.credit.xieyi');});
Route::get("/test/apply",['uses'=>"CreditController@testapply",'as'=>'test.apply']);

/*订单支付配置*/
Route::get("/get/pay/{id}",['uses'=>"PayController@order_create",'as'=>'order.create']);//统一下单
Route::get("/credit/report",['uses'=>"ReportController@report",'as'=>'credit.report']);//信用报告