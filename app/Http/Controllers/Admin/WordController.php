<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Result;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WordController extends BaseController
{
    protected $model_name = 'Word';

    protected $interaction = 'Grade';

    /*
     * 问卷添加页面
     */
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

        $content = <<<EOF
{
 "pages": [
  {
   "name": "页面1"
  }
 ]
}
EOF;
        //添加时给问卷一个默认页面
        $word->content = $content;


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
     * 编辑问卷基本信息页面
     */
    public function editPage(Word $word){
        return view('admin.word.word_edit',compact('word'));
    }

    /*
     * 编辑问卷基本信息逻辑
     */
    public function editStore(Word $word,Request $request){
        /* 表单验证 */
        $request->validate([
            'name' => [
                'required',
                Rule::unique('words')->ignore($word->id), //进行字段唯一性验证时忽略指定 ID
            ],
            'describe' => 'nullable',
            'category_id' => 'required|integer',
            'rule' => 'nullable|array',
            'grade' => 'nullable|array'
        ]);

        /* 入库字段赋值 */
        $field = array_intersect($word->getFillable(), array_keys($request->toArray()));   //得到最终将要加入数据库的字段

        foreach ($field as $v) {
            $word->$v = $request->$v;        //循环赋值给数组
        }

        /* 判断如果修改了规则，或者班级,将清空结果列表 */
        $oldRule    = [];                   //之前的规则
        $newRule    = $request->rule??[];   //提交的规则
        $oldGrade   = [];                   //之前的班级
        $newGrade   = $request->grade??[];  //提交的班级
        //循环赋值
        foreach ($word->rule as $value){$oldRule[] = $value->id;}
        //循环赋值
        foreach ($word->grade as $value){$oldGrade[] = $value->id;}

        //if规则或者班级已修改
        if (!array_is_eq($oldRule,$newRule) || !array_is_eq($oldGrade,$newGrade)){
            //删除当前问卷下的所有答卷
            $word->result()->delete();
        }

        /* 重新添加关联关系 */
        $word->rule()->detach();   //删除对应所有数据
        $word->grade()->detach();   //删除对应所有数据
        //如果用户输入了规则，就会添加，否则为空
        $word->rule()->attach($request->rule);   //规则关联关系增加
        $word->grade()->attach($request->grade);   //班级关联关系增加

        /* 生成二维码 */
        QrCode::format('png')->size(200)->generate(route('home_wordShow',$word->id),public_path('static/qrcodes/'.$word->id.'.png'));

        $word->qrcode = URL::asset('static/qrcodes/'.$word->id.'.png'); //设置字段的值为二维码的url

        /* 入库 */
        $word->save();

        /* 返回结果 */
        return ['msg' => '编辑成功'];
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
//        return view('survey.builder.builder',compact('word'));
        return view('admin.word.editor',compact('word'));
    }

    /*
     * 保存编辑器编辑问卷
     */
    public function saveEditor(Word $word,Request $request){

        //判断是否修改问卷，如果修改，则需要清空统计数据
        if ($word->content !== $request->answer){
            //删除当前问卷下的所有答卷
            $word->result()->delete();
        }

        $field = array_intersect($word->getFillable(), array_keys($request->toArray()));   //得到可修改的字段

        foreach ($field as $k => $v) {
            $word->$v = $request->$v;    //循环赋值
        }

        $word->save();    //保存至数据库

        return ['msg' => '编辑成功'];            //响应结果

    }


    /*
     * 问卷结果列表页
     */
    public function resultsPage(Word $word){
        //动态添加模型关联
        $word->load('grade','rule','result');

        //查询到当前问卷的结果列表并分页
        $paginate = Result::where('word_id','=',$word->id)->paginate(10);

        return view('admin.word.resultsPage',compact('word','paginate'));
    }

    /*
     * 单问卷平均分概况
     */
    public function resultShow(Result $result){
        return view('admin.word.resultShow',compact('result'));
    }



}
