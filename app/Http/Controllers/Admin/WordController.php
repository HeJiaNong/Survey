<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WordController extends BaseController
{
    protected $model_name = 'Word';

    protected $interaction = 'Grade';

    public function addPage(Word $word){

        $rows = Word::with(['category','grade'])->get();

        return view('admin.word.word_add',compact('rows'));
    }

    /*
     * 问卷模板添加逻辑
     */
    public function addStore(Request $request,Word $word){
        $this->validate($request,[
            'name' => 'required|unique:words',
            'describe' => 'required',
            'grade_id' => 'required|integer',
            'category_id' => 'required|integer',
        ]);

        $field = array_intersect($word->getFillable(), array_keys($request->toArray()));   //得到最终将要加入数据库的字段

        foreach ($field as $v) {
            $word->$v = \request()->$v;        //循环赋值给数组
        }

        $word->save();     //将数组入库,这时候$word就有id,可以执行以下通过id生成二维码操作

        //通过id生成二维码
        QrCode::format('png')->size(200)->generate(route('home_wordShow',$word->id),public_path('static/qrcodes/'.$word->id.'.png'));

        $word->qrcode = URL::asset('static/qrcodes/'.$word->id.'.png'); //赋值二维码地址

        $word->save();     //将数组入库

        $word->grade()->attach($request->grade_id);   //添加关联关系

        return ['msg' => '添加成功'];            //返回结果
    }


    /*
     * 问卷测试页
     */
    public function show(Word $word,Request $request){
        return view('admin.word.word_show',compact('word'));
    }

    /*
     * 编辑器
     */
    public function editor(Word $word){
        return view('admin.word.editor',compact('word'));
    }

    /*
     * 保存编辑问卷
     */
    public function saveEditor(Word $word,Request $request){

        $field = array_intersect($word->getFillable(), array_keys(\request()->toArray()));   //得到可修改的字段

        foreach ($field as $k => $v) {
            $word->$v = \request()->$v;    //循环赋值
        }

        $word->save();    //保存至数据库

        return ['msg' => '编辑成功'];            //返回结果

    }

    /*
      * 公共列表展示页
      */
//    public function index()
//    {
//
//        $rows = Word::with('grade')->paginate(10);  //分页
//
//        return view("admin." . $this->model_name . "." . $this->model_name . "_list", compact('dataset'));
//    }
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
