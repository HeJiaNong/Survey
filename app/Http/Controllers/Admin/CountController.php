<?php

namespace App\Http\Controllers\Admin;

use App\Models\Result;
use App\Models\Word;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountController extends Controller
{
    //

    /*
     * 用户信息统计
     */
    public function user(){
        return view('admin.word.count.user');
    }

    /*
     * 各问卷交卷数量周报
     */
    public function results(){
        return view('admin.word.count.results');
    }

    /*
     * 各问卷交卷数量周报数据接口
     */
    public function resultsJson(){
        //获取上周Carbon对象
        $subWeek = Carbon::now()->subWeek();

        //一周-区间
        $week = [$subWeek->startOfWeek()->toDateTimeString(),$subWeek->endOfWeek()->toDateTimeString()];

        //周一-区间
        $weeks['周一']     = [$subWeek->startOfWeek()->startOfDay()->toDateTimeString(),$subWeek->startOfWeek()->endOfDay()->toDateTimeString()];
        //周二-区间
        $weeks['周二']   = [$subWeek->startOfWeek()->addDays(1)->startOfDay()->toDateTimeString(),$subWeek->startOfWeek()->addDays(1)->endOfDay()->toDateTimeString()];
        //周三-区间
        $weeks['周三'] = [$subWeek->startOfWeek()->addDays(2)->startOfDay()->toDateTimeString(),$subWeek->startOfWeek()->addDays(2)->endOfDay()->toDateTimeString()];
        //周四-区间
        $weeks['周四']   = [$subWeek->startOfWeek()->addDays(3)->startOfDay()->toDateTimeString(),$subWeek->startOfWeek()->addDays(3)->endOfDay()->toDateTimeString()];
        //周五-区间
        $weeks['周五']    = [$subWeek->startOfWeek()->addDays(4)->startOfDay()->toDateTimeString(),$subWeek->startOfWeek()->addDays(4)->endOfDay()->toDateTimeString()];
        //周六-区间
        $weeks['周六']  = [$subWeek->startOfWeek()->addDays(5)->startOfDay()->toDateTimeString(),$subWeek->startOfWeek()->addDays(5)->endOfDay()->toDateTimeString()];
        //周日-区间
        $weeks['周日']    = [$subWeek->endOfWeek()->startOfDay()->toDateTimeString(),$subWeek->endOfWeek()->endOfDay()->toDateTimeString()];

        //数据模型
        $words = Word::with('result')->get();

        //总结果集
        $data = [];

        //循环赋值
        foreach ($words as $word){
            foreach ($weeks as $k => $v){
                $data[$word->name][$k] = $word->result()->whereBetween('created_at',$v)->count();
            }
        }

        $keys = array_keys($data);

        $series = [];
        $len = 0;
        foreach ($data as $key => $value){
            $series[$len]['name'] = $key;
            $series[$len]['type'] = 'line';
            $series[$len]['stack'] = '总量';
            $series[$len]['data'] = array_values($value);
            $len ++;
        }

        return ['data' => $keys,'series' => $series];
    }

    /*
     * 单个问卷答案统计页面
     */
    public function answerPage(Word $word){
        //动态添加模型关联
        $word->load('result');

        //题目列表
        $item = [];

        //结果集
        $data = [];

        //可计算分数的题目
        $topics = [];

        $type = [
            'radiogroup',       //单项选择
            'rating',           //评分
            'emotionsratings'   //情绪评级
        ];

        //赋值可计算的题目
        foreach (json_decode($word->content,true)['pages'] as $value){
            foreach ($value['elements'] as $v){
                if (in_array($v['type'],$type)){
                    $topics[] = $v['name'];
                }
            }
        }

        //题目列表赋值
        foreach (json_decode($word->content,true)['pages'][0]['elements'] as $v){
            $item[] = $v['name'];
        }

        //结果集赋值
        $data = $word->result()->where('word_id',$word->id)->paginate(10);

        //添加总分属性
        foreach ($data as $result){
            $result->score = array_sum(array_values(array_intersect_key($result->answer,array_flip($topics))));
        }

        return view('admin.word.count.answer',compact('word','item','data'));
    }

    /*
     * 单问卷平均分统计
     */
    public function answerAvgPage(Word $word){

        //结果集赋值
        $data = $word->result()->where('word_id',$word->id)->get();

        //todo 算出每道题的平均分
        //平均分
        $avg = [];

        //题目列表
        $topics = [];

        //可计算的题目
        $topics2 = [];

        //类型
        $type = [
            'radiogroup',       //单项选择
            'rating',           //评分
            'emotionsratings'   //情绪评级
        ];

        //题目列表赋值
        foreach (json_decode($word->content,true)['pages'][0]['elements'] as $v){
            $topics[] = $v['name'];
        }



        //赋值可计算的题目
        foreach (json_decode($word->content,true)['pages'] as $value){
            foreach ($value['elements'] as $v){
                if (in_array($v['type'],$type)){
                    $topics2[] = $v['name'];
                }
            }
        }

        $score = [];

        foreach ($topics2 as $value){
            $score[$value] = 0;
            foreach ($word->result as $result){
                $score[$value] += $result->answer[$value];
            }
        }


        return view('admin.word.count.avg',compact('word','data','score'));
    }


}
