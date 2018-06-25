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
Route::prefix('/')->namespace('Home')->group( function () {
    //Home页
    Route::get('/', 'HomeController@index')->name('home');
});


/*
 * 后台页面路由集合
 */
Route::prefix('admin')->group( function () {

    //后台用户登陆
    Route::get('/login', 'Admin\SessionController@login_page')->name('admin_login_up');
    //后台登陆逻辑
    Route::post('/login','Admin\SessionController@login_store')->name('admin_login_store');
    //退出登陆
    Route::get('/logout','Admin\SessionController@logout')->name('admin_logout');

    //后台首页
    Route::middleware(['auth'])->get('/', 'Admin\AdminController@index')->name('admin');
    //后台桌面页
    Route::middleware(['auth'])->get('/desktop', 'Admin\AdminController@desktop')->name('admin_desktop');

    //用户管理模块
    Route::middleware(['auth'])->prefix('user')->namespace('Admin')->group(function () {
        //会员列表
        Route::get('/', 'UserController@index')->name('admin_user_list_get');
        //会员列表-添加
        Route::get('/add', 'UserController@add')->name('admin_user_add_get');
        //会员列表-添加
        Route::post('/add', 'UserController@add')->name('admin_user_add_post');
        //修改用户状态逻辑
        Route::get('/status/{id}', 'UserController@status')->name('admin_user_status_get');
        //批量修改用户状态逻辑
        Route::get('/status_bulk/{ids}', 'UserController@allStatus')->name('admin_users_status_get');
        //用户编辑页面
        Route::get('/edit/{id}', 'UserController@edit')->name('admin_user_edit_get');
        //用户编辑逻辑
        Route::put('/edit/{id}', 'UserController@edit')->name('admin_user_edit_put');
        //用户密码修改页面
        Route::get('/edit_passwd/{user}', 'UserController@edit_passwd_page')->name('admin_user_edit_passwd_get');
        //修改用户密码逻辑
        Route::put('/edit_passwd/{user}', 'UserController@edit_passwd_store')->name('admin_user_edit_passwd_put');
        //删除逻辑
        Route::get('/del/{id}','UserController@del')->name('admin_user_del');
        //搜索逻辑
        Route::match(['get','post'],'/search', 'UserController@searchStore')->name('admin_user_search_post');
    });

    //老师管理模块
    Route::middleware(['auth'])->prefix('teacher')->namespace('Admin')->group(function (){
        //老师列表页面
        Route::get('/','TeacherController@index')->name('admin_teacher_list_get');
        //老师信息编辑页面
        Route::get('/edit/{id}', 'TeacherController@edit')->name('admin_teacher_edit_get');
        //老师信息编辑逻辑
        Route::put('/edit/{id}', 'TeacherController@edit')->name('admin_teacher_edit_put');
        //修改状态
        Route::get('/status/{id}', 'TeacherController@status')->name('admin_teacher_status_get');
        //批量修改状态
        Route::get('/status_bulk/{ids}', 'TeacherController@allStatus')->name('admin_teachers_status_get');
        //删除逻辑
        Route::get('/del/{id}','TeacherController@del')->name('admin_teacher_del');
        //添加
        Route::get('/add', 'TeacherController@add')->name('admin_teacher_add_get');
        //添加
        Route::post('/add', 'TeacherController@add')->name('admin_teacher_add_post');
        //搜索逻辑
        Route::match(['get','post'],'/search', 'TeacherController@searchStore')->name('admin_teacher_search_post');
    });

    //部门管理
    Route::middleware(['auth'])->prefix('branch')->namespace('Admin')->group(function (){
        Route::get('/','BranchController@index')->name('admin_branch_list_get');
    });
});