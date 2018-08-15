@extends('admin.layouts.default')

@section('head')
    @include('survey.library')
@endsection

@section('body')
    <div id="surveyElement"></div>

@endsection

@section('footer')
    <script>
        {{--对一些特定的编辑器需要的类型进行转化--}}
        @php
            if (isset($content['hasOther'])){
                $content['hasOther'] = true;
            }

            if (isset($content['isRequired'])){
                $content['isRequired'] = true;
            }
        @endphp

        {{--//主题--}}
        Survey.StylesManager.applyTheme("default");


        {{--{{ dd($content) }}--}}

        //题目列表
        var json = {
            elements : [@json($content)]
        };


        window.survey = new Survey.Model(json);

        //提交按钮
        survey.onComplete.add(function (result) {
            document.querySelector('#surveyResult').innerHTML = "result: " + JSON.stringify(result.data);
        });

        //本土化
        survey.locale = 'zh-cn';

        //只允许下拉框可以操作    其他都是只读模式
        @if($content['type'] !== 'dropdown')
            survey.mode = 'display';    //只读模式
        @endif
        //关闭题目排序显示
        survey.showQuestionNumbers = 'off';
        survey.render();

        $("#surveyElement").Survey({model: survey});
    </script>
@endsection