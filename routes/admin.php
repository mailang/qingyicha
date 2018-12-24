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
Route::get('/admins/delete/{id}', ['uses'=>'AdminsController@destroy','as'=>'admins.delete']);
Route::get('/admins/forbid/{id}', ['uses'=>'AdminsController@forbid','as'=>'admins.forbid']);
Route::get('/admins/person/{id}', ['uses'=>'AdminsController@modify','as'=>'admin.person']);
Route::post('/admins/update/pwd', ['uses'=>'AdminsController@updatepwd','as'=>'person.pwd']);
/*角色管理*/
Route::get('/roles/list', ['uses'=>'RolesController@index','as'=>'roles.list']);
Route::get('/roles/add/{id?}', ['uses'=>'RolesController@create','as'=>'roles.add']);
Route::post('/roles/store', ['uses'=>'RolesController@store','as'=>'roles.store']);
Route::post('/roles/update', ['uses'=>'RolesController@update','as'=>'roles.update']);
Route::get('/roles/delete/{id}', ['uses'=>'RolesController@destroy','as'=>'roles.delete']);
/*栏目管理*/
Route::get('/permissions/list', ['uses'=>'PermissionsController@index','as'=>'permissions.list']);
Route::get('/permissions/add/{id?}', ['uses'=>'PermissionsController@create','as'=>'permissions.add']);
Route::post('/permissions/store', ['uses'=>'PermissionsController@store','as'=>'permissions.store']);
Route::post('/permissions/update', ['uses'=>'PermissionsController@update','as'=>'permissions.update']);
Route::get('/permissions/delete/{id}', ['uses'=>'PermissionsController@destroy','as'=>'permissions.delete']);
Route::get('/permissions/child/{id}', ['uses'=>'PermissionsController@child','as'=>'permissions.child']);
/*微信菜单增删改*/
Route::get('/menu/list', ['uses'=>'MenuController@edit','as'=>'menu.list']);
Route::post('/menu/update', ['uses'=>'MenuController@update_menu','as'=>'menu.update']);