<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Grade;
use App\Models\Teacher;
use App\Models\Topic;
use App\Models\Word;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 返回视图
     */
    public function index(){
        $word = Word::all('id','name');
        $grade = Grade::all('id','name');

        return view('home.index',compact('word','grade'));
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

        return $arr;

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

        $topics = Word::find($wordId)->topic;

        $teacherName = Teacher::find($teacherId)->name;

        $className = Grade::find($classId)->name;

        $info = compact('teacherName','className');

        return view('home.word.index',compact('topics','info'));

    }

    /*
     * 问卷提交
     */
    public function wordStroe(Request $request){
        dump($request->toArray());
    }

}
