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
        Route::resource('/permissions', 'PermissionsController');
        //后台用户角色
        Route::any('/role/role-permissions-iframe/{id}', 'RoleController@rolePermissionsIframe');
        Route::any('/role/role-permissions', 'RoleController@rolePermissions');
        Route::resource('/role', 'RoleController');
    });

});