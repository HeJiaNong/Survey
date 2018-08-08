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

    //问卷基础信息填写页面
//    Route::get('/word_rule/{word}','HomeController@wordRule')->name('home_wordRule');

    Route::get('/getGrade/{id}', 'HomeController@getGrade')->name('getGrade');

    //返回老师列表
    Route::get('/teacher/{id}','HomeController@getTeacher')->name('get_teacher');

    //问卷页
    Route::get('/word/{wordId?}/{classId?}/{teacherId?}','HomeController@word')->name('word');

    //问卷详情页
    Route::get('/word_show/{word}/{rules?}','HomeController@wordShow')->name('home_wordShow');

    //提交问卷
    Route::post('/wordSend/{word}','HomeController@wordSend')->name('home_wordSend');
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

        //添加页面
        Route::get('/add','BranchController@addPage')->name('admin_branch_addPage');
        //添加逻辑
        Route::post('/add','BranchController@addStore')->name('admin_branch_addStore');
        //编辑页面
        Route::get('/edit/{branch}','BranchController@editPage')->name('admin_branch_editPage');
        //编辑逻辑
        Route::put('/edit/{branch}','BranchController@editStore')->name('admin_branch_editStore');

        //删除部门
        Route::get('/del/{branch}','BranchController@del')->name('admin_branch_del');

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

    //问卷模板管理
    Route::middleware(['auth'])->prefix('word')->group(function (){
        //列表
        Route::get('/','WordController@index')->name('admin_word_list_get');
        //添加/修改
        Route::match(['GET','POST','PUT'],'/save/{id?}', 'WordController@save')->name('admin_word_save');
        //修改状态
        Route::get('/status/{id?}', 'WordController@status')->name('admin_word_status_get');
        //批量修改状态
        Route::get('/status_bulk/{ids}', 'WordController@allStatus')->name('admin_words_status_get');
        //删除逻辑
        Route::get('/del/{id}','WordController@del')->name('admin_word_del');
        //搜索逻辑
        Route::match(['GET','POST'],'/search', 'WordController@searchStore')->name('admin_word_search_post');

        //发布问卷
        Route::get('/add','WordController@addPage')->name('admin_word_addPage');
        //发布逻辑
        Route::post('/add','WordController@addStore')->name('admin_word_addStore');

        //问卷测试页
        Route::get('/show/{word}','WordController@show')->name('admin_word_show');

        //问卷编辑器页
        Route::get('/editor/{word}','WordController@editor')->name('admin_word_editor');

        //保存问卷
        Route::post('/save_editor/{word}','WordController@saveEditor')->name('admin_word_saveEditor');

        //获取试题
        Route::get('/get_survey/{word}','WordController@getSurvey')->name('admin_word_getSurvey');

        //显示问卷规则
        Route::get('/show_rule/{word}','WordController@showRule')->name('admin_word_showRule');

        //编辑问卷基本信息页面
        Route::get('/editpage/{word}','WordController@editPage')->name('admin_word_editPage');

        //编辑问卷基本信息逻辑
        Route::put('/editStore/{word}','WordController@editStore')->name('admin_word_editStore');

        //结果详情页
        Route::get('/resultShow/{result}','WordController@resultShow')->name('admin_word_resultShow');

        //结果列表页
        Route::get('/resultsPage/{word}','WordController@resultsPage')->name('admin_word_resultsPage');



        //数据统计模块
        Route::prefix('count')->group(function (){
            //单问卷结果统计页面
            Route::get('/answerPage/{word}','CountController@answerPage')->name('admin_word_count_answerPage');

            //单问卷平均分统计
            Route::get('/answerAvgPage/{word}','CountController@answerAvgPage')->name('admin_word_count_answerAvgPage');

            //用户统计
            Route::get('/user','CountController@user')->name('admin_word_count_user');

            //单问卷答案列表
            Route::get('/results','CountController@results')->name('admin_word_count_results');

            //单问卷答案列表json数据接口
            Route::get('/resultsJson','CountController@resultsJson')->name('admin_word_count_resultsJson');


        });


    });

    //问卷分类
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

        //添加页面
        Route::get('/add','CategoryController@addPage')->name('admin_category_addPage');
        //添加逻辑
        Route::post('/add','CategoryController@addStore')->name('admin_category_addStore');

        //编辑页面
        Route::get('/edit/{category}','CategoryController@editPage')->name('admin_category_editPage');
        //编辑逻辑
        Route::put('/edit/{category}','CategoryController@editStore')->name('admin_category_editStore');
    });

    //题目列表
//    Route::middleware(['auth'])->prefix('topic')->group(function (){
//        //部门列表
//        Route::get('/','TopicController@index')->name('admin_topic_list_get');
//        //添加/修改
//        Route::match(['GET','POST','PUT'],'/save/{id?}', 'TopicController@save')->name('admin_topic_save');
//        //修改状态
//        Route::get('/status/{id}', 'TopicController@status')->name('admin_topic_status_get');
//        //批量修改状态
//        Route::get('/status_bulk/{ids}', 'TopicController@allStatus')->name('admin_topics_status_get');
//        //删除逻辑
//        Route::get('/del/{id}','TopicController@del')->name('admin_topic_del');
//        //搜索逻辑
//        Route::match(['GET','POST'],'/search', 'TopicController@searchStore')->name('admin_topic_search_post');
//    });

});