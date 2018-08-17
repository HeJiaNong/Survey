<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use App\Models\Result;
use App\Models\Word;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ResultController extends BaseController
{
    protected $model_name = 'Result';

    /*
     * 问卷结果列表页
     */
    public function resultsPage(Word $word){

        //动态添加模型关联
        $word->load('grade','rule','result');

        //查询到当前问卷的结果列表并分页
        $data = $word->result()->where('word_id',$word->id)->where('status',1)->paginate(5);

        //用于存储各区的字段数量
        $colspan['topic'] = 0;
        $colspan['basic'] = 0;

        foreach ($data as $v){
            $colspan['topic'] = count($v->answer);

            //这里+1是＋的地区字段 和时间
            $colspan['basic'] = $v->word->rule->count() + 1 +1;

            if ($v->word->grade->isNotEmpty()){
                $colspan['basic'] += 1;
            }
            break;
        }

        //问卷题目列表
        $topics = [];

        foreach (json_decode($word->content,true)['pages'] as $value){
            foreach ($value['elements'] as $v){
                $topics[] = $v;
            }
        }

        return view('admin.word.result.resultsPage',compact('word','data','colspan','topics'));
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

//        dump($topics);

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

//        dump($topic);

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

    /**
     * 导出问卷下所有答卷的excel
     */
    public function exportExcel(Word $word){
        //动态加载模型关联
        $word->load('rule','grade','result');

        //第一行的题目与基本信息数据
        $prependRowInfo = [];   //基本信息
        $prependRowRule = [];   //规则信息
        $prependRowTopic = [];  //题目信息

        //固定的3各字段
        $prependRowInfo[] = '答卷ID';
        $prependRowInfo[] = '答卷时间';
        $prependRowInfo[] = '地区';

        //是否需要添加规则字段
        if ($word->rule->isNotEmpty()){
            foreach ($word->rule as $rule){
                $prependRowRule[] = $rule['title'];
            }
        }
        //是否需要添加班级字段
        if ($word->grade->isNotEmpty()){
            $prependRowRule[] = '班级';
        }

        foreach (json_decode($word->content,true)['pages'] as $value){
            //问题列表
            foreach ($value['elements'] as $v){
                $prependRowTopic[] = $v;
            }
        }


        //行数据
        $rowsInfo = [];
        $rowsRule = [];
        $rowsTopic = [];
        $i = 0; //记录条数
        foreach ($word->result as $result){
            $rowsInfo[$i][] = $result->id;  //答卷id
            $rowsInfo[$i][] = $result->created_at->toDateTimeString();  //答卷时间
            $rowsInfo[$i][] = $result->city;    //地区

            //规则字段
            if ($word->rule->isNotEmpty()){
                foreach ($word->rule as $rule){
                    $rowsRule[$i][] = $result[$rule['name']];
                }
            }
            //班级字段
            if ($word->grade->isNotEmpty()){
                $rowsRule[$i][] = Grade::find($result->grade_id)['name'];
            }
            //赋值题目列表
            foreach ($prependRowTopic as $item){
                $name = isset($item['valueName'])?$item['valueName']:$item['name'];
                $rowsTopic[$i][$name] = [];
                if (isset($result->answer[$name])){
                    if (is_array($result->answer[$name])){
                        $str = '';
                        foreach ($result->answer[$name] as $value){
                            $str .= '['.$value.']';
                        }
                        $rowsTopic[$i][$name] = $str;
                    }else{
                        $rowsTopic[$i][$name] = $result->answer[$name];
                    }
                }else{
                    $rowsTopic[$i][$name] = null;
                }
            }
            $i++;
        }

        $prependRow = [];
        $rows = [];

        foreach ($prependRowTopic as $k => $v){
            $prependRowTopic[$k] = isset($v['title'])?$v['title']:$v['name'];
        }

        //合并首行
        $prependRow = array_merge(array_values($prependRowInfo),array_values($prependRowRule),array_values($prependRowTopic));

        //合并多行
        foreach ($rowsTopic as $k => $v){
            if ($rowsRule == null){ //如果没有规则信息
                $rows[] = array_merge(array_values($rowsInfo[$k]),array_values($rowsTopic[$k]));
            }else{
                $rows[] = array_merge(array_values($rowsInfo[$k]),array_values($rowsRule[$k]),array_values($rowsTopic[$k]));
            }

        }

        //下载excel
        Excel::create($word->name, function($excel) use($word,$prependRow,$rows) {
            //创建一个sheet
            $excel->sheet($word->name, function($sheet) use($prependRow,$rows) {
                //首行
                $sheet->prependRow($prependRow);
                //增加多行
                $sheet->rows($rows);
                //冻结第一行
                $sheet->freezeFirstRow();
            });

        })->export('xls');  //导出到Excel5（xls）
    }

}
