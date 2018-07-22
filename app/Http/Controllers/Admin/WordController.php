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

        $dataset = Word::with(['category','grade'])->get();

        return view('admin.word.word_add',compact('dataset'));
    }

    /*
     * 问卷模板添加逻辑
     */
    public function addStore(Request $request,Word $word){



        $this->validate($request,[
            'name' => 'required|unique:words',
            'describe' => 'nullable',
            'category_id' => 'required|integer',
            'rule' => 'nullable|array',
            'grade' => 'nullable|array'
        ]);

        //todo 添加规则功能，暂时为：用户信息输入，班级选择
//        dump($request);

        $field = array_intersect($word->getFillable(), array_keys($request->toArray()));   //得到最终将要加入数据库的字段

        foreach ($field as $v) {
            $word->$v = \request()->$v;        //循环赋值给数组
        }

//        dd($word);

        $word->save();     //将数组入库,这时候$word就有id,可以执行以下通过id生成二维码操作

        //通过id生成二维码
        QrCode::format('png')->size(200)->generate(route('home_wordShow',$word->id),public_path('static/qrcodes/'.$word->id.'.png'));

        $word->qrcode = URL::asset('static/qrcodes/'.$word->id.'.png'); //设置字段的值为二维码的url

        $word->save();     //将数组入库

        if ($request->rule !== null){
            $word->rule()->toggle($request->rule);   //规则关联关系增加
        }

        if ($request->grade !== null){
            $word->grade()->toggle($request->grade);   //班级关联关系增加
        }


        return ['msg' => '添加成功'];            //返回结果
    }

    /*
     * 查看问卷规则
     */
    public function showRule(Word $word){
        return view('admin.word.word_showRule',compact('word'));
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
     * 编辑问卷基本信息页面
     */
    public function editPage(Word $word){
        return view('admin.word.word_edit',compact('word'));
    }

    /*
     * 编辑问卷基本信息逻辑
     */
    public function editStore(Word $word,Request $request){

        $this->validate($request,[
            'name' => [
                'required',
                Rule::unique('words')->ignore($word->id), //进行字段唯一性验证时忽略指定 ID
            ],
            'describe' => 'nullable',
            'category_id' => 'required|integer',
            'rule' => 'nullable|array',
            'grade' => 'nullable|array'
        ]);

        //todo 添加规则功能，暂时为：用户信息输入，班级选择
//        dump($request);

        $field = array_intersect($word->getFillable(), array_keys($request->toArray()));   //得到最终将要加入数据库的字段

        foreach ($field as $v) {
            $word->$v = \request()->$v;        //循环赋值给数组
        }

//        dd($word);

        $word->save();     //将数组入库,这时候$word就有id,可以执行以下通过id生成二维码操作

        //通过id生成二维码
        QrCode::format('png')->size(200)->generate(route('home_wordShow',$word->id),public_path('static/qrcodes/'.$word->id.'.png'));

        $word->qrcode = URL::asset('static/qrcodes/'.$word->id.'.png'); //设置字段的值为二维码的url

        $word->save();     //将数组入库

        //如果用户未选择任何，就删除之前添加的记录，这里无论怎样都要进行删除
        $word->rule()->detach();   //删除对应所有数据
        $word->grade()->detach();   //删除对应所有数据
        //如果用户输入了规则，就会添加，否则为空
        $word->rule()->attach($request->rule);   //规则关联关系增加
        $word->grade()->attach($request->grade);   //班级关联关系增加


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
