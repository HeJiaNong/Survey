<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GradeController extends BaseController
{
    protected $model_name = 'Grade';

    protected $interaction = 'Teacher';

    protected $relations = ['teacher','word'];


    /*
     * 公共列表展示页
     */
    public function index()
    {

        $dataset = Grade::with('teacher')->paginate(10);  //分页

        return view("admin.grade.grade_list", compact('dataset'));
    }



    /**
     * 添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addPage(){

        $rows = Teacher::where('status',1)->select('id','name')->get();   //获取老师列表


        return view("admin.grade.grade_add",compact('rows'));   //返回视图
    }

    /**
     * 添加逻辑
     * @param Request $request  请求数据
     * @param Teacher $teacher  模型
     * @return int
     */
    public function addStore(Request $request,Grade $grade){

        //数据验证
        $this->validate($request,[
            'name' => 'required|unique:grades',
            'count' => 'required|integer',
            'teacher_id' => 'required',
        ]);

        $field = array_intersect($grade->getFillable(), array_keys($request->toArray()));   //得到最终将要加入数据库的字段

        foreach ($field as $v) {
            $grade->$v = \request()->$v;        //循环赋值给数组
        }

        $grade->save();     //将数组入库

        $grade->teacher()->attach($request->teacher_id);   //添加关联关系

        $msg = ['msg' => '添加成功'];

        return json_encode($msg);            //返回结果
    }

    /**
     * 编辑页面
     * @param Teacher $teacher  模型绑定
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPage(Grade $grade){

        $rows = Teacher::where('status',1)->select('id','name')->get();



        return view("admin.grade.grade_edit",compact('grade','rows'));   //返回视图
    }

    /**
     * 编辑逻辑
     * @param Teacher $teacher
     * @param Request $request
     * @return int
     */
    public function editStore(Grade $grade,Request $request){

        //数据验证
        $this->validate($request,[
            'name' => [
                'required',
                Rule::unique('grades')->ignore($grade->id), //进行字段唯一性验证时忽略指定 ID
            ],
            'count' => 'required|integer',
            'teacher_id' => 'required',
        ]);

        $field = array_intersect($grade->getFillable(), array_keys(\request()->toArray()));   //得到可修改的字段

        foreach ($field as $k => $v) {
            $grade->$v = \request()->$v;    //循环赋值
        }


        $grade->save();    //保存至数据库

        $grade->teacher()->attach($request->teacher_id);   //添加关联关系

        $msg = ['msg' => '编辑成功'];

        return json_encode($msg);            //返回结果
    }

}
