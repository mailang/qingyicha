<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/27
 * Time: 14:23
 */
Route::get('/index', function () {
    return view('admin.index');
});
/*后台用户管理*/
Route::get('/admins/list', ['uses'=>'AdminsController@index','as'=>'admins.list']);
Route::get('/admins/add/{id?}', ['uses'=>'AdminsController@create','as'=>'admins.add']);
Route::post('/admins/store', ['uses'=>'AdminsController@store','as'=>'admins.store']);
Route::post('/admins/update', ['uses'=>'AdminsController@update','as'=>'admins.update']);
/*角色管理*/
Route::get('/roles/list', ['uses'=>'RolesController@index','as'=>'roles.list']);
Route::get('/roles/add/{id?}', ['uses'=>'RolesController@create','as'=>'roles.add']);