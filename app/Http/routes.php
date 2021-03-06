<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function(){
    return redirect(url('/admin/'));
});

/**
 * 后台
 */
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    //登陆
    Route::get('/login', 'PublicController@login');
    //检测登陆
    Route::any('/check-login', 'PublicController@checkLogin');
    
    Route::group(['middleware' => ['permission']],function () {
        //后台首页
        Route::get('/','IndexController@index');
        Route::any('/ajax-get-permission-menu', 'IndexController@ajaxGetPermissionMenu');
        //后台欢迎页
        Route::get('/welcome', 'IndexController@welcome');
        //后台public模块
        Route::controller('/public', 'PublicController');
        //后台用户管理
        Route::any('/user/disable', 'UserController@disable');
        Route::any('/user/update-password-iframe/{id}', 'UserController@updatePasswordIframe');
        Route::any('/user/update-password', 'UserController@updatePassword');
        Route::resource('/user', 'UserController');
        //后台用户权限
        Route::any('/permissions/add-level-permissions-iframe/{id}', 'PermissionsController@addLevelPermissionsIframe');
        Route::any('/permissions/ajax-get-role-permissions-list', 'PermissionsController@ajaxGetPermissionsList');
        Route::any('/permissions/update-permissions-sort', 'PermissionsController@updatePermissionsSort');
        Route::resource('/permissions', 'PermissionsController');
        //后台用户角色
        Route::any('/role/role-permissions-iframe/{id}', 'RoleController@rolePermissionsIframe');
        Route::any('/role/ajax-get-role-permissions', 'RoleController@ajaxGetRolePermissions');
        Route::any('/role/ajax-save-role-permissions', 'RoleController@ajaxSaveRolePermissions');
        Route::resource('/role', 'RoleController');
    });
});

Route::group(['prefix' => 'log', 'namespace' => 'Log'], function(){
    Route::controller('/adminlog', 'AdminLogController');
});