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

use Illuminate\Support\Facades\Route;


/*
 * 前台页面路由集合
 */
Route::group(['prefix' => '/'], function () {
    //Home页
    Route::get('/', 'Home\HomeController@index')->name('home');
});


/*
 * 后台页面路由集合
 */
Route::group(['prefix' => '/admin'], function () {
    //后台首页
    Route::get('/', 'Admin\AdminController@index')->name('admin');
    //后台欢迎页
    Route::view('/welcome', 'admin.welcome')->name('admin_welcome');
    //后台用户登陆
    Route::get('/login', 'Admin\SessionController@login_page')->name('admin_login_up');
    //后台登陆逻辑
    Route::post('/login','Admin\SessionController@login_store')->name('admin_login_store');

    //用户管理模块
    Route::group(['prefix' => '/users'], function () {
        //会员列表
        Route::get('/', 'Admin\UserController@index')->name('users');
        //会员列表-添加
        Route::get('/add', 'Admin\UserController@add_page')->name('users_add_page');
        //会员列表-添加
        Route::post('/add', 'Admin\UserController@add_store')->name('users_add_store');
        //修改用户状态逻辑
        Route::get('/status/{user}/{status}', 'Admin\UserController@status_store')->name('users_status_store');
        //批量修改用户状态逻辑
        Route::get('/status_bulk/{data}/{status}', 'Admin\UserController@status_store_bulk')->name('users_status_store');
        //用户编辑页面
        Route::get('/edit/{user}', 'Admin\UserController@edit_page')->name('users_edit_page');
        //用户编辑逻辑
        Route::put('/edit/{user}', 'Admin\UserController@edit_store')->name('users_edit_store');
        //修改用户密码页面
        Route::get('/edit_passwd/{user}', 'Admin\UserController@edit_passwd_page')->name('edit_passwd_page');
        //修改用户密码逻辑
        Route::put('/edit_passwd/{user}', 'Admin\UserController@edit_passwd_store')->name('edit_passwd_store');
        //搜索逻辑
        Route::post('/search', 'Admin\UserController@user_search_store')->name('user_search_store');
        //用户回收站页面
        Route::get('/del', 'Admin\UserController@user_del_page')->name('user_del_page');
        //用户回收站-删除
        Route::get('/del/{user}', 'Admin\UserController@user_del_delete_store')->name('user_del_delete_store');
        //用户回收站-搜索逻辑
        Route::post('/del/search', 'Admin\UserController@user_del_search_store')->name('user_del_search_store');

    });
});