<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Result;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WordController extends Controller
{
    protected $model_name = 'Word';

    protected $interaction = 'Grade';

    /*
     * 公共列表展示页
     */
    public function index()
    {

        $dataset = Word::paginate(10);  //分页

        return view("admin.Word.Word_list", compact('dataset'));
    }


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


        $field = array_intersect($word->getFillable(), array_keys($request->toArray()));   //得到最终将要加入数据库的字段

        foreach ($field as $v) {
            $word->$v = \request()->$v;        //循环赋值给数组
        }

        //问卷初始内容
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

        //获取题目列表
        $topics = [];
        foreach (json_decode($word->content,true)['pages'] as $value){
            foreach ($value['elements'] as $v){
                $topics[] = $v;
            }
        }

        $word->save();    //保存至数据库

        return ['msg' => '编辑成功'];            //响应结果

    }

    /*
     *  单个题目页
     */
    public function showIndividualTopics(Request $request){
        $content = $request->toArray()['content'];

        return view('admin.word.showIndividualTopics',compact('content'));
    }


    /*
     * 问卷删除逻辑
     */
    public function del(Word $word)
    {
        $word->result()->delete();

        $word->delete();

        return ['msg' => '已删除!'];
    }

    /*
     * 问卷上下架
     */
    /*
     * 修改状态   1启用  0停用
     */
    public function status(Word $word)
    {
        //Laravel 会自动解析定义在路由或控制器行为中与类型提示的变量名匹配的路由段名称的 Eloquent 模型
        //如果在数据库中找不到对应的模型实例，将会自动生成 404 异常。
        //所以，如果数据库没有这条记录，将会直接返回error，触发前端错误提醒
        //只需要执行删除程序即可
        //修改用户的状态    1启用/0停用


        if ($word->status === 1) {
            $word->status = 0;
        } else {
            $word->status = 1;
        }

        //保存状态
        $word->save();

        return ['msg' => '操作成功!'];
    }

    /*
     * 搜索
     */
    public function searchStore(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $username = $request->username;

        $start = empty($start) ? date('Y-m-d H:i:s', 0) : $start . ' 00:00:00';     //如果开始时间为空，则为初始时间

        $end = empty($end) ? date('Y-m-d H:i:s', time()) : $end . ' ' . explode(' ', date('Y-m-d H:i:s', time()))[1];   //如果结束时间为空，则为当前时间

        if (empty($username)) {
            $dataset = Word::whereBetween('created_at', [$start, $end])->paginate(10);    //如果用户名为空，则不添加用户名条件
        } else {
            $dataset = Word::where('name', 'like', '%' . $username . '%')->whereBetween('created_at', [$start, $end])->paginate(10);  //如果都有值，则添加所有条件
        }

        $start = explode(' ', $start)[0];
        $end = explode(' ', $end)[0];

        return view("admin.word.word_list",compact('dataset', 'start', 'end', 'username'));
    }

}
