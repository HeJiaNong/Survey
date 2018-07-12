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
    //返回老师列表
    Route::get('/teacher/{id}','HomeController@getTeacher')->name('get_teacher');
    //问卷页
    Route::get('/word/{wordId?}/{classId?}/{teacherId?}','HomeController@word')->name('word');
    //提交文件
    Route::post('/word','HomeController@wordStroe')->name('word_store');
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
        //列表
        Route::get('/', 'UserController@index')->name('admin_user_list_get');
        //添加/编辑
        Route::match(['GET','POST','PUT'],'/save/{id?}', 'UserController@save')->name('admin_user_save');
        //修改用户状态逻辑
        Route::get('/status/{id}', 'UserController@status')->name('admin_user_status_get');
        //批量修改用户状态逻辑
        Route::get('/status_bulk/{ids}', 'UserController@allStatus')->name('admin_users_status_get');
        //修改用户密码页面
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
        //添加/修改
        Route::match(['GET','POST','PUT'],'/save/{id?}', 'TeacherController@save')->name('admin_teacher_save');

        Route::get('add','TeacherController@addPage')->name('admin_teacher_addPage_get');      //添加页
        Route::post('add','TeacherController@addStore')->name('admin_teacher_addStore_post');    //添加逻辑
        Route::get('edit/{teacher}','TeacherController@editPage')->name('admin_teacher_editPage_get');    //编辑页
        Route::put('edit/{teacher}','TeacherController@editStore')->name('admin_teacher_editStore_put');   //编辑逻辑

        //修改状态
        Route::get('/status/{id}', 'TeacherController@status')->name('admin_teacher_status_get');
        //批量修改状态
        Route::get('/status_bulk/{ids}', 'TeacherController@allStatus')->name('admin_teachers_status_get');
        //删除逻辑
        Route::get('/del/{id}','TeacherController@del')->name('admin_teacher_del');
        //搜索逻辑
        Route::match(['GET','POST'],'/search', 'TeacherController@searchStore')->name('admin_teacher_search_post');
    });

    //部门管理
    Route::middleware(['auth'])->prefix('branch')->group(function (){
        //部门列表
        Route::get('/','BranchController@index')->name('admin_branch_list_get');

        //添加/修改
        Route::match(['GET','POST','PUT'],'/save/{id?}', 'BranchController@save')->name('admin_branch_save');

        //添加部门
        Route::post('/add','BranchController@add')->name('admin_branch_add');
        //删除部门
        Route::get('/del/{branch}','BranchController@del')->name('admin_branch_del');

        //修改状态
        Route::get('/status/{id}', 'BranchController@status')->name('admin_branch_status_get');
        //批量修改状态
        Route::get('/status_bulk/{ids}', 'BranchController@allStatus')->name('admin_branches_status_get');
        //删除逻辑
        Route::get('/del/{id}','BranchController@del')->name('admin_branch_del');
        //搜索逻辑
        Route::match(['GET','POST'],'/search', 'BranchController@searchStore')->name('admin_branch_search_post');
    });

    //班级管理
    Route::middleware(['auth'])->prefix('grade')->group(function (){
        //部门列表
        Route::get('/','GradeController@index')->name('admin_grade_list_get');
        //添加/修改
        Route::match(['GET','POST','PUT'],'/save/{id?}', 'GradeController@save')->name('admin_grade_save');

        Route::get('add','GradeController@addPage')->name('admin_grade_addPage_get');      //添加页
        Route::post('add','GradeController@addStore')->name('admin_grade_addStore_post');    //添加逻辑
        Route::get('edit/{grade}','GradeController@editPage')->name('admin_grade_editPage_get');    //编辑页
        Route::put('edit/{grade}','GradeController@editStore')->name('admin_grade_editStore_put');   //编辑逻辑

        //修改状态
        Route::get('/status/{id}', 'GradeController@status')->name('admin_grade_status_get');
        //批量修改状态
        Route::get('/status_bulk/{ids}', 'GradeController@allStatus')->name('admin_grades_status_get');
        //删除逻辑
        Route::get('/del/{id}','GradeController@del')->name('admin_grade_del');
        //搜索逻辑
        Route::match(['GET','POST'],'/search', 'GradeController@searchStore')->name('admin_grade_search_post');
    });

    //问卷管理
    Route::middleware(['auth'])->prefix('word')->group(function (){
        //部门列表
        Route::get('/','WordController@index')->name('admin_word_list_get');
        //添加/修改
        Route::match(['GET','POST','PUT'],'/save/{id?}', 'WordController@save')->name('admin_word_save');
        //修改状态
        Route::get('/status/{id}', 'WordController@status')->name('admin_word_status_get');
        //批量修改状态
        Route::get('/status_bulk/{ids}', 'WordController@allStatus')->name('admin_words_status_get');
        //删除逻辑
        Route::get('/del/{id}','WordController@del')->name('admin_word_del');
        //搜索逻辑
        Route::match(['GET','POST'],'/search', 'WordController@searchStore')->name('admin_word_search_post');

        //发布问卷
        Route::get('add','WordController@addPage')->name('admin_word_addPage');

    });

    //问卷管理
    Route::middleware(['auth'])->prefix('category')->group(function (){
        //部门列表
        Route::get('/','CategoryController@index')->name('admin_category_list_get');
        //添加/修改
        Route::match(['GET','POST','PUT'],'/save/{id?}', 'CategoryController@save')->name('admin_category_save');
        //修改状态
        Route::get('/status/{id}', 'CategoryController@status')->name('admin_category_status_get');
        //批量修改状态
        Route::get('/status_bulk/{ids}', 'CategoryController@allStatus')->name('admin_categorys_status_get');
        //删除逻辑
        Route::get('/del/{id}','CategoryController@del')->name('admin_category_del');
            //搜索逻辑
        Route::match(['GET','POST'],'/search', 'CategoryController@searchStore')->name('admin_category_search_post');
    });

    //题目列表
    Route::middleware(['auth'])->prefix('topic')->group(function (){
        //部门列表
        Route::get('/','TopicController@index')->name('admin_topic_list_get');
        //添加/修改
        Route::match(['GET','POST','PUT'],'/save/{id?}', 'TopicController@save')->name('admin_topic_save');
        //修改状态
        Route::get('/status/{id}', 'TopicController@status')->name('admin_topic_status_get');
        //批量修改状态
        Route::get('/status_bulk/{ids}', 'TopicController@allStatus')->name('admin_topics_status_get');
        //删除逻辑
        Route::get('/del/{id}','TopicController@del')->name('admin_topic_del');
        //搜索逻辑
        Route::match(['GET','POST'],'/search', 'TopicController@searchStore')->name('admin_topic_search_post');
    });

});