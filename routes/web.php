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
Route::prefix('admin')->namespace('Admin')->group( function () {

    //后台用户登陆
    Route::get('/login', 'SessionController@login_page')->name('admin_login_up');
    //后台登陆逻辑
    Route::post('/login','SessionController@login_store')->name('admin_login_store');
    //退出登陆
    Route::get('/logout','SessionController@logout')->name('admin_logout');
    //后台首页
    Route::middleware(['auth'])->get('/', 'AdminController@index')->name('admin');
    //后台桌面页
    Route::middleware(['auth'])->get('/desktop', 'AdminController@desktop')->name('admin_desktop');
    //用户管理模块
    Route::middleware(['auth'])->prefix('user')->group(function () {
        //会员列表
        Route::get('/', 'UserController@index')->name('admin_user_list_get');
        //会员列表-添加/修改
        Route::match(['GET','POST','PUT'],'/save/{id?}', 'UserController@save')->name('admin_user_save');
        //修改用户状态逻辑
        Route::get('/status/{id}', 'UserController@status')->name('admin_user_status_get');
        //批量修改用户状态逻辑
        Route::get('/status_bulk/{ids}', 'UserController@allStatus')->name('admin_users_status_get');
//        //用户编辑页面
//        Route::get('/edit/{id}', 'UserController@edit')->name('admin_user_edit_get');
//        //用户编辑逻辑
//        Route::put('/edit/{id}', 'UserController@edit')->name('admin_user_edit_put');
        //用户密码修改页面
        Route::get('/edit_passwd/{user}', 'UserController@edit_passwd_page')->name('admin_user_edit_passwd_get');
        //修改用户密码逻辑
        Route::put('/edit_passwd/{user}', 'UserController@edit_passwd_store')->name('admin_user_edit_passwd_put');
        //删除逻辑
        Route::get('/del/{id}','UserController@del')->name('admin_user_del');
        //搜索逻辑
        Route::match(['GET','POST'],'/search', 'UserController@searchStore')->name('admin_user_search_post');
    });

    //老师管理
    Route::middleware(['auth'])->prefix('teacher')->group(function (){
        //列表页面
        Route::get('/','TeacherController@index')->name('admin_teacher_list_get');
        //编辑
        Route::match(['GET','PUT'],'/edit/{id}', 'TeacherController@edit')->name('admin_teacher_edit');
        //修改状态
        Route::get('/status/{id}', 'TeacherController@status')->name('admin_teacher_status_get');
        //批量修改状态
        Route::get('/status_bulk/{ids}', 'TeacherController@allStatus')->name('admin_teachers_status_get');
        //删除逻辑
        Route::get('/del/{id}','TeacherController@del')->name('admin_teacher_del');
        //添加
        Route::match(['GET','POST'],'/save', 'TeacherController@save')->name('admin_teacher_save');
        //搜索逻辑
        Route::match(['GET','POST'],'/search', 'TeacherController@searchStore')->name('admin_teacher_search_post');
    });

    //部门管理
    Route::middleware(['auth'])->prefix('branch')->group(function (){
        //部门列表
        Route::get('/','BranchController@index')->name('admin_branch_list_get');
        //修改状态
        Route::get('/status/{id}', 'BranchController@status')->name('admin_branch_status_get');
        //批量修改状态
        Route::get('/status_bulk/{ids}', 'BranchController@allStatus')->name('admin_branches_status_get');
        //编辑页面/逻辑
        Route::match(['GET','PUT'],'/edit/{id}', 'BranchController@edit')->name('admin_branch_edit');
        //删除逻辑
        Route::get('/del/{id}','BranchController@del')->name('admin_branch_del');
        //添加页面/逻辑
        Route::match(['GET','POST'],'/save', 'BranchController@save')->name('admin_branch_save');
        //搜索逻辑
        Route::match(['GET','POST'],'/search', 'BranchController@searchStore')->name('admin_branch_search_post');
    });

    //班级管理
    Route::middleware(['auth'])->prefix('grade')->group(function (){
        //部门列表
        Route::get('/','GradeController@index')->name('admin_grade_list_get');
        //修改状态
        Route::get('/status/{id}', 'GradeController@status')->name('admin_grade_status_get');
        //批量修改状态
        Route::get('/status_bulk/{ids}', 'GradeController@allStatus')->name('admin_grades_status_get');
        //编辑页面/逻辑
        Route::match(['GET','PUT'],'/edit/{id}', 'GradeController@edit')->name('admin_grade_edit');
        //删除逻辑
        Route::get('/del/{id}','GradeController@del')->name('admin_grade_del');
        //添加页面/逻辑
        Route::match(['GET','POST'],'/save', 'GradeController@save')->name('admin_grade_save');
        //搜索逻辑
        Route::match(['GET','POST'],'/search', 'GradeController@searchStore')->name('admin_grade_search_post');
    });

});