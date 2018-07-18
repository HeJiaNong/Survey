<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Grade;
use App\Models\Teacher;
use App\Models\Topic;
use App\Models\Word;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 返回视图
     */
    public function index(){
        return view('home.index',compact('word'));
    }

    /*
     * 问卷基础信息填写页面
     */
    public function wordInfo(){

        $word = Word::with('grade')->get();

        foreach ($word as $value){
            foreach ($value->grade as $value){
                dump($value->name);
            }
            break;
        }

        return view('home.word.word_info',compact('word'));
    }

    /*
     * 问卷展示页面
     */
    public function wordShow(Word $word){
        if ($word->status == 0){    //判断问卷状态是否发布
            abort(404,'此问卷已下架');  //抛出HTTP异常
        }
        //todo 更具不同的规则来返回是否需要填写问卷信息
        return view('home.word.word_show',compact('word'));

    }

    /**
     * 通过班级获取对应老师
     * @param $classId integer 班级id
     * @return array 返回json数据
     */
    public function getGrade($classId){

        $word = Word::with('grade')->find($classId);

        $arr = [];

        foreach ($word->grade as $value){
            $arr[$value->id] = $value->name;
        }

        return json_encode($arr);

    }

    /**
     * 通过班级获取对应老师
     * @param $classId integer 班级id
     * @return array 返回json数据
     */
    public function getTeacher($classId){

        $teacher = Grade::with('teacher')->find($classId);

        $arr = [];

        foreach ($teacher->teacher as $value){
            $arr[$value->id] = $value->name;
        }

        return json_encode($arr);

    }

    /**
     * 问卷页面
     * @param string $wordId    问卷id
     * @param string $classId   班级id
     * @param string $teacherId 老师id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function word($wordId = '',$classId = '',$teacherId = ''){

        Word::find($wordId)->grade()->attach($classId); //添加访问记录

        $topics = Word::find($wordId)->topic;   //获取题目列表

        $teacherName = Teacher::find($teacherId)->name; //获取老师名字

        $className = Grade::find($classId)->name;   //获取班级名称

        $info = compact('teacherName','className'); //将班级/老师名称放入同一数组中

        return view('home.word.index',compact('topics','info'));    //模板渲染

    }

    /*
     * 问卷提交
     */
    public function wordStroe(Request $request){
        dump($request->toArray());
    }

}
