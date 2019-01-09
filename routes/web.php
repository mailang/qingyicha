<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('admin.login');
});
Route::get('/admin', ['uses'=>'Admin\LoginController@showLoginForm','as'=>'admin.login']);
Route::get('/admin/login', function () {
    return redirect()->route('admin.login');
});
Route::post('/admin/login',['uses'=>'Admin\LoginController@login']);
Route::get('/admin/logout', ['uses'=>'Admin\LoginController@logout','as'=>'admin.logout']);

//Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin','middleware'=>['admin:admin','menu']], function () {
    include base_path('routes/admin.php');
});
/*微信接入*/
Route::any('/chat/wechat', ['uses'=>'Chat\WechatController@serve','as'=>'weixin.init']);
/*授权回调*/
Route::get("/url/callback",['uses'=>"Chat\WechatController@callback",'as'=>'weixin.callback']);

Route::group(['prefix' => 'weixin', 'namespace' => 'Chat','middleware'=>['web','oauth']], function () {
    include base_path('routes/weixin.php');
});