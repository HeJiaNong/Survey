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
     * 所有问卷数量周报数据接口
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
     * 问卷模板下所有答卷统计
     */
    public function wordCount(Word $word){

        //todo 图形统计 周计，月计，年计

        //统计单个问卷下参与人数的展示
        //

        return view('admin.word.count.word',compact('word'));
    }




}
