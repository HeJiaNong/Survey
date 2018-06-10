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


//前台页面路由集合
Route::group(['prefix' => '/'],function (){
    //Home页
    Route::get('/','HomeController@index')->name('home');
});

//后台页面路由集合
Route::group(['prefix' => '/admin'],function (){
    //后台首页
    Route::get('/','AdminController@index')->name('admin');
    //后台欢迎页
    Route::view('/welcome','admin.welcome')->name('admin_welcome');
    //后台用户登陆
    Route::get('/login','AdminController@login_up')->name('admin_login_up');

    //用户管理模块
    Route::group(['prefix' => '/users'],function (){
        //会员列表
        Route::get('/','UserController@index')->name('users');
        //会员列表-添加
        Route::get('/add','UserController@add_page')->name('users_add_page');
        //会员列表-添加
        Route::post('/add','UserController@add_store')->name('users_add_store');
        //修改用户状态逻辑
        Route::get('/status/{user}/{status}','UserController@status_store')->name('users_status_store');
        //批量修改用户状态逻辑
        Route::get('/status_bulk/{data}/{status}','UserController@status_store_bulk')->name('users_status_store');
        //用户编辑页面
        Route::get('/edit/{user}','UserController@edit_page')->name('users_edit_page');
        //用户编辑逻辑
        Route::put('/edit/{user}','UserController@edit_store')->name('users_edit_store');
        //修改用户密码页面
        Route::get('/edit_passwd/{user}','UserController@edit_passwd_page')->name('edit_passwd_page');
        //修改用户密码逻辑
        Route::put('/edit_passwd/{user}','UserController@edit_passwd_store')->name('edit_passwd_store');
        //搜索逻辑
        Route::post('/search','UserController@user_search_store')->name('user_search_store');
        //用户回收站页面
        Route::get('/del','UserController@user_del_page')->name('user_del_page');
        //用户回收站-删除
        Route::get('/del/{user}','UserController@user_del_delete_store')->name('user_del_delete_store');
        //用户回收站-搜索逻辑
        Route::post('/del/search','UserController@user_del_search_store')->name('user_del_search_store');

    });
});







////后台问卷
//Route::group(['prefix' => '/admin/questionnaire'],function (){
//    //列表展示页
//    Route::get('/','QuestionnaireController@index')->name('questionnaire');
//    //添加模板页
//    Route::get('/add','QuestionnaireController@add_page');
//    //添加逻辑页
//    Route::post('/add','QuestionnaireController@add_post');
//    //删除逻辑
//    Route::get('/del','QuestionnaireController@del');
//});



