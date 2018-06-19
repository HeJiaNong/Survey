<?php

namespace App\Http\Controllers\Admin;

use App\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QuestionnaireController extends Controller
{
    /*
     * 列表分页渲染
     */
    public function index(){
        $data = Questionnaire::all();
        return view('admin.questionnaire.index',compact('data'));
    }

    /*
     * 添加页面渲染
     */
    public function add(){
        return view('admin.questionnaire.add');
    }

    /*
     * 添加逻辑实现
     */
    public function add_post(Request $request){

//        return ['msg' => true];

        //验证
        $this->validate($request,[
            'name' => 'required|string|max:20',
//            'name' => [
//                'required',
//                Rule::unique('questionnaires'),
//                'max:20'
//            ],
            'describe' => 'string|max:100',
        ]);

        //逻辑
        $params = \request(['name','describe']);
        $result = Questionnaire::create($params);

        if($result){
            return response()->json([
                'msg' => '添加成功',
                'status' => 1,
            ]);
//            return ['status'=>1,'info'=>'添加成功'];
        }else{
            return response()->json([
                'msg' => '添加失败',
                'status' => 0,
            ]);
//            return ['status'=>0,'info'=>'添加失败'];
        }

        //渲染
        return redirect(route('admin'));
    }

    /**
     * 编辑页面
     */
    public function edit_page(){

    }

    /*
     * 编辑逻辑
     */
    public function edit_store(){

    }

    /*
     * 删除逻辑实现
     */
    public function del($id){
        //todo 用户权限验证

        $res = Questionnaire::where('id',$id)->delete();

        return ['status' => 1,'info' => '删除成功！'];

        redirect(route('questionnaire'));
    }

}
