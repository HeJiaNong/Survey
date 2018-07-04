<?php

namespace App\Http\Controllers\Admin;

use App\Models\Questionnaire;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WordController extends BaseController
{
    protected $model_name = 'Word';

    protected $interaction = 'Grade';

    /*
      * 公共列表展示页
      */
    public function index()
    {

        $dataset = Word::with('grade')->paginate(10);  //分页



//        dd($dataset);

        $count = 0;
//
//        foreach ($all->grade as $v){
//            dump($v->name);
//            ++$count;
//        }

        return view("admin." . $this->model_name . "." . $this->model_name . "_list", compact('dataset','count'));
    }
//
//    /*
//     * 添加页面渲染
//     */
//    public function add(){
//        return view('admin.word.add');
//    }
//
//    /*
//     * 添加逻辑实现
//     */
//    public function add_post(Request $request){
//
////        return ['msg' => true];
//
//        //验证
//        $this->validate($request,[
//            'name' => 'required|string|max:20',
////            'name' => [
////                'required',
////                Rule::unique('questionnaires'),
////                'max:20'
////            ],
//            'describe' => 'string|max:100',
//        ]);
//
//        //逻辑
//        $params = \request(['name','describe']);
//        $result = Questionnaire::create($params);
//
//        if($result){
//            return response()->json([
//                'msg' => '添加成功',
//                'status' => 1,
//            ]);
////            return ['status'=>1,'info'=>'添加成功'];
//        }else{
//            return response()->json([
//                'msg' => '添加失败',
//                'status' => 0,
//            ]);
////            return ['status'=>0,'info'=>'添加失败'];
//        }
//
//        //渲染
//        return redirect(route('admin'));
//    }
//
//    /**
//     * 编辑页面
//     */
//    public function edit_page(){
//
//    }
//
//    /*
//     * 编辑逻辑
//     */
//    public function edit_store(){
//
//    }
//
//    /*
//     * 删除逻辑实现
//     */
//    public function del($id){
//        //todo 用户权限验证
//
//        $res = Questionnaire::where('id',$id)->delete();
//
//        return ['status' => 1,'info' => '删除成功！'];
//
//        redirect(route('word'));
//    }

}
