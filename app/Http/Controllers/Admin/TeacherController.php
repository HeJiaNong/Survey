<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Validation\Rule;

class TeacherController extends BaseController
{

    protected $model_name = 'Teacher';

    protected $interaction = 'Branch';

    protected $relations = ['branch','grade'];

    /*
     * 钩子方法，主要用于子类继承之后修改参数
     */
    protected function __search(&$where){
        $where .= " and name=zhangsan";
    }

    /**
     * 添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addPage(){

        $rows = Branch::orderBy('order','asc')->select('id','name')->get();   //获取部门表中所有状态正常的记录

        return view("admin.teacher.teacher_add",compact('rows'));   //返回视图
    }

    /**
     * 添加逻辑
     * @param Request $request  请求数据
     * @param Teacher $teacher  模型
     * @return int
     */
    public function addStore(Request $request,Teacher $teacher){

        //数据验证
        $this->validate($request,[
            'email' => 'required|email|unique:teachers',
            'name' => 'required',
            'branch_id' => 'required',
            'sex' => 'required',
            'number' => 'required|size:11',
            'addr' => 'required',
        ]);

        $field = array_intersect($teacher->getFillable(), array_keys($request->toArray()));   //得到最终将要加入数据库的字段

        foreach ($field as $v) {
            $teacher->$v = \request()->$v;        //循环赋值给数组
        }

        $teacher->save();     //将数组入库

        $msg = ['msg' => '添加成功'];

        return json_encode($msg);            //返回结果
    }

    /**
     * 编辑页面
     * @param Teacher $teacher  模型绑定
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPage(Teacher $teacher){

        $rows = Teacher::first()->branch->select('id','name')->orderBy('order','asc')->get();    //获取部门的所有记录

        $rows = Branch::orderBy('order','asc')->select('id','name')->get();    //获取部门的所有记录

        return view("admin.teacher.teacher_edit", compact('teacher','rows'));
    }

    /**
     * 编辑逻辑
     * @param Teacher $teacher
     * @param Request $request
     * @return int
     */
    public function editStore(Teacher $teacher,Request $request){
        //数据验证
        $this->validate($request,[
            'email' => [
                'required',
                'email',
                Rule::unique('teachers')->ignore($teacher->id), //进行字段唯一性验证时忽略指定 ID
            ],
            'name' => 'required',
            'branch_id' => 'required',
            'sex' => 'required',
            'number' => 'required|size:11',
            'addr' => 'required',
        ]);

        $field = array_intersect($teacher->getFillable(), array_keys(\request()->toArray()));   //得到可修改的字段

        foreach ($field as $k => $v) {
            $teacher->$v = \request()->$v;    //循环赋值
        }

        $teacher->save();    //保存至数据库

        $msg = ['msg' => '编辑成功'];

        return json_encode($msg);            //返回结果
    }

}
