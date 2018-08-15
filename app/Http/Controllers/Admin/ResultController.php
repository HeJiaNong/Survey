<?php

namespace App\Http\Controllers\Admin;

use App\Models\Result;
use App\Models\Word;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultController extends BaseController
{
    protected $model_name = 'Result';

    /*
     * 问卷结果列表页
     */
    public function resultsPage(Word $word){

        if ($word->category->formula_mode == 2){
            dump('分数');
        }

        //动态添加模型关联
        $word->load('grade','rule','result');

        //查询到当前问卷的结果列表并分页
        $data = $word->result()->where('word_id',$word->id)->where('status',1)->paginate(5);

        //用于存储各区的字段数量
        $colspan['topic'] = 0;
        $colspan['basic'] = 0;

        foreach ($data as $v){
            $colspan['topic'] = count($v->answer);

            //这里+1是＋的地区字段
            $colspan['basic'] = $v->word->rule->count() + 1;

            if ($v->word->grade->isNotEmpty()){
                $colspan['basic'] += 1;
            }
            break;
        }

        return view('admin.word.result.resultsPage',compact('word','data','colspan'));
    }

    /*
     * 作废答卷页
     */
    public function scrapResultsPage(Word $word){
        //动态添加模型关联
        $word->load('grade','rule','result');

        //查询到当前问卷的结果列表并分页
        $data = $word->result()->where('word_id',$word->id)->where('status',0)->paginate(5);

        //用于存储各区的字段数量
        $colspan['topic'] = 0;
        $colspan['basic'] = 0;

        foreach ($data as $v){
            $colspan['topic'] = count($v->answer);

            //这里+1是＋的地区字段
            $colspan['basic'] = $v->word->rule->count() + 1;

            if ($v->word->grade->isNotEmpty()){
                $colspan['basic'] += 1;
            }
            break;
        }

        return view('admin.word.result.scrapResultsPage',compact('word','data','colspan'));
    }


    /*
     * 答卷展示
     */
    public function resultShow(Result $result){
        return view('admin.word.result.resultShow',compact('result'));
    }

    /*
     * 题目分析页面
     */
    public function topic(Word $word){

        //题目列表
        $topics = [];
//        dd(json_decode($word->content));

        //前方高能警告 请准备好纸巾，尿不湿
        foreach (json_decode($word->content,true)['pages'] as $value){
            foreach ($value['elements'] as $v){
                $v['answers'] = [];
                $v['content'] = [];
                foreach ($word->result as $result){
                    if ($result->status == 1){  //只计算未作废的答卷
                        if (isset($v['valueName'])){
                            $v['answer'][$result->id] = $result->answer[$v['valueName']] ?? '';
                        }else{
                            $v['answer'][$result->id] = $result->answer[$v['name']] ?? '';
                        }
                    }
                }
                foreach (json_decode($word->content,true)['pages'] as $page){
                    foreach ($page['elements'] as $element){
                        if ($element['name'] == $v['name']){
                            $v['content'] = $element;
                        }

                    }
                }
                $topics[] = $v;
            }
        }




        return view('admin.word.result.topic',compact('word','topics'));
    }

    /*
     * 单个题目的数据整合/统计/展示
     */
    public function subjectDataStatistics(Request $request){
        $topic = $request->topic;

        if (!isset($topic['answer'])){
            return '暂无答卷';
        }

        dump($topic);

        return view('admin.word.result.subjectDataStatistics',compact('topic'));
    }

    /*
     * 单个题目数据统计，Echarts展示
     */
    public function subjectDataStatisticsEcharts(Request $request){
        $topic = $request->topic;

        if (!isset($topic['answer'])){
            return '暂无答卷';
        }

        return view('admin.word.count.topics.'.$topic['type'],compact('topic'));
    }

}
