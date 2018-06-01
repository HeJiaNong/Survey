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

//Home页
Route::get('/','HomeController@index')->name('home');

//后台首页
Route::get('/admin','AdminController@index')->name('admin');

//后台欢迎页
Route::get('/admin/welcome','WelcomeController@index');

//用户管理
Route::group(['prefix' => '/admin/users'],function (){
    //会员列表
    Route::get('/','UserController@index')->name('users');
    //会员列表-添加
    Route::get('/add','UserController@add_page')->name('users_add_page');
    //会员列表-添加
    Route::post('/add','UserController@add_store')->name('users_add_store');
    //修改用户状态逻辑
    Route::get('/status/{user}/{status}','UserController@status_store')->name('users_status_store');
    //批量修改用户状态逻辑
    Route::put('/status/{data}/{status}','UserController@status_store_bulk')->name('users_status_store');
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



