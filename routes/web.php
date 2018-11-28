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
    return view('welcome');
});
Route::get('/admin', ['uses'=>'Admin\LoginController@showLoginForm']);
Route::get('/admin/login', ['uses'=>'Admin\LoginController@showLoginForm','as'=>'admin.login']);
Route::post('/admin/login',['uses'=>'Admin\LoginController@login']);
Route::get('/admin/logout', ['uses'=>'Admin\LoginController@logout','as'=>'admin.logout']);

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin','middleware'=>['admin:admin','menu']], function () {
    include base_path('routes/admin.php');
});
Route::group(['prefix' => 'weixin', 'namespace' => 'weixin'], function () {
    include base_path('routes/weixin.php');
});