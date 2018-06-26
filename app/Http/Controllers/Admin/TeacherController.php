<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;
use App\Models\Teacher;
use App\Http\Controllers\Admin\BaseController;

class TeacherController extends BaseController
{

    protected $model_name = 'Teacher';

    protected $interaction = 'Grade';
    /*
     * 钩子方法，主要用于子类继承之后修改参数
     */
    protected function __search(&$where){
        $where .= " and name=zhangsan";
    }
    /*
     * 老师列表页
     */
//    public function index(){
//        $teachers = Teacher::paginate(20);
//        return view('admin.teacher.teacher-list',compact('teachers'));
//    }

    /*
     * 编辑老师信息页
     */
//    public function edit_page(Teacher $teacher){
//        return view('admin.teacher.teacher_edit',compact('teacher'));
//    }

//    /*
//     * 编辑老师信息逻辑
//     */
//    public function edit_store(Teacher $teacher){
//        $teacher->name = \request()->name;
//        $teacher->sex = \request()->sex;
//        $teacher->save();
//
//        return 1;
//    }
//
//    /*
//     * 老师永久删除逻辑
//     */
//    public function user_del_delete_store(User $user)
//    {
//        //删除
//        $user->delete();
//        return 1;
//    }

}
