<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Grade;
use App\Models\Teacher;
use App\Models\Topic;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 返回视图
     */
    public function index()
    {

        return view('home.index', compact('word'));
    }

    /*
     * 问卷基础信息填写页面
     */
    public function wordInfo()
    {

        $word = Word::with('grade')->get();

        foreach ($word as $value) {
            foreach ($value->grade as $value) {
                dump($value->name);
            }
            break;
        }

        return view('home.word.word_info', compact('word'));
    }

    /*
     * 问卷展示页面
     */
    public function wordShow(Word $word, $rules = '')
    {
        if ($word->status == 0) {    //判断问卷状态是否发布
            abort(404, '此问卷已下架');  //抛出HTTP异常
        }

        //需要填写规则
        if ($word->rule->isNotEmpty() || $word->grade->isNotEmpty()) {
            if (!empty($rules)) {
                if (session('status') == 'ACTION' || session('status') == 'OVER' || session('status') == null) {   //如果用户在问卷中或者问卷完成后刷新页面或返回页面跳转到信息页
                    session(['status' => 'RULE']);
                    return redirect()->route('home_wordShow', $word->id);
                }
                $rule = [];
                $grade = '';
                //判定规则的输入是否完整
                if ($word->rule->isNotEmpty()) {
                    foreach ($word->rule->toArray() as $value) {
                        if (!in_array($value['name'], array_keys(json_decode($rules, true)))) {
                            return abort(404);
                        } else {
                            $rule[$value['name']] = json_decode($rules, true)[$value['name']];
                        }
                    }
                }

                //判定班级的输入是否完整
                if ($word->grade->isNotEmpty()) {
                    foreach ($word->grade->toArray() as $value) {
                        if ($value['name'] == json_decode($rules, true)['grade']) {
                            $grade = $value['name'];
                        }
                    }
                }

                session(['status' => 'ACTION']);
                return view('home.word.word_show', compact('word'));
            }

            session()->pull('status');  //删除session
            session(['status' => 'RULE']);
            return view('home.word.word_rule', compact('word'));
        }

        session(['status' => 'ACTION']);
        //todo 更具不同的规则来返回是否需要填写问卷信息
        return view('home.word.word_show', compact('word'));

    }

    /*
     * 提交问卷
     */
    public function wordSend(Word $word, Request $request)
    {
        //记录用户问卷状态
        session(['status' => 'OVER']);

        //问卷状态判断
        if ($word->status == 0) {
            return '还没上架呢';
        }

        //获取rule，json转为php数组
        $rule = json_decode($request->rule, true, 512, JSON_BIGINT_AS_STRING); //JSON_BIGINT_AS_STRING用于将大整数转为字符串而非默认的float类型

        //接收班级
        $grade = $rule['grade'] ?? null;

        //接收答案
        $answer = $request->answer ?? null;

        //结果容器
        $result = [];

        $result['answer'] = $answer;

        //判断是否需要验证规则或者班级信息
        if ($word->rule->isNotEmpty() || $word->grade->isNotEmpty()) {
            //规则验证
            if ($word->rule->isNotEmpty()) {
                foreach ($word->rule->toArray() as $value) {
                    if (!in_array($value['name'], array_flip($rule))) {
                        return '参数不对';
                    }
                    $result[$value['name']] = $rule[$value['name']];
                }

                //字段验证
                $v = Validator::make($result, [
                    'answer' => 'required|json',
                ]);
                //复杂条件验证
                $v->sometimes('name', 'required', function ($data) use ($word) {
                    foreach ($word->rule->toArray() as $value){
                        if ('name' == $value['name']) return true;
                    }
                });

                $v->sometimes('email', 'required|email', function ($data) use ($word) {
                    foreach ($word->rule->toArray() as $value){
                        if ('email' == $value['name']) return true;
                    }
                });

                $v->sometimes('number', 'required|digits_between:0,11', function ($data) use ($word) {
                    foreach ($word->rule->toArray() as $value){
                        if ('number' == $value['name']) return true;
                    }
                });

                $v->sometimes('sex', ['required',Rule::in(['男','女']),], function ($data) use ($word) {
                    foreach ($word->rule->toArray() as $value){
                        if ('sex' == $value['name']) return true;
                    }
                });

                $v->sometimes('qq_number','required|digits_between:0,10', function ($data) use ($word) {
                    foreach ($word->rule->toArray() as $value){
                        if ('qq_number' == $value['name']) return true;
                    }
                });

                $v->validate();

            }

            //班级验证
            if ($word->grade->isNotEmpty()) {
                foreach ($word->grade->toArray() as $value){
                    if ($grade == $value['name']){
                        $result['grade_id'] = $value['id'];
                    }
                }
                //验证
                Validator::make($result,[
                    'grade_id' => 'required|integer'
                ])->validate();
            }
        }

        //通过ip获取地区信息
        $ipArea = getAreaByIp($request->getClientIp());

        //获得ip信息并纳入结果集
        $result['ip_address']   = $ipArea['data']['ip']         ?? null;    //ip地址
        $result['country']      = $ipArea['data']['country']    ?? null;    //国家
        $result['region']       = $ipArea['data']['region']     ?? null;    //地区
        $result['city']         = $ipArea['data']['city']       ?? null;    //城市
        $result['isp']          = $ipArea['data']['isp']        ?? null;    //运营商

        //事务提交，失败回滚
        DB::transaction(function () use ($word, $result) {
            $word->result()->create($result); //添加记录
        });

        return ['msg' => 'ok'];
    }


    /**
     * 通过班级获取对应老师
     * @param $classId integer 班级id
     * @return array 返回json数据
     */
    public function getGrade($classId)
    {

        $word = Word::with('grade')->find($classId);

        $arr = [];

        foreach ($word->grade as $value) {
            $arr[$value->id] = $value->name;
        }

        return json_encode($arr);

    }

    /**
     * 通过班级获取对应老师
     * @param $classId integer 班级id
     * @return array 返回json数据
     */
    public function getTeacher($classId)
    {

        $teacher = Grade::with('teacher')->find($classId);

        $arr = [];

        foreach ($teacher->teacher as $value) {
            $arr[$value->id] = $value->name;
        }

        return json_encode($arr);

    }

    /**
     * 问卷页面
     * @param string $wordId 问卷id
     * @param string $classId 班级id
     * @param string $teacherId 老师id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function word($wordId = '', $classId = '', $teacherId = '')
    {

        Word::find($wordId)->grade()->attach($classId); //添加访问记录

        $topics = Word::find($wordId)->topic;   //获取题目列表

        $teacherName = Teacher::find($teacherId)->name; //获取老师名字

        $className = Grade::find($classId)->name;   //获取班级名称

        $info = compact('teacherName', 'className'); //将班级/老师名称放入同一数组中

        return view('home.word.index', compact('topics', 'info'));    //模板渲染

    }

}
