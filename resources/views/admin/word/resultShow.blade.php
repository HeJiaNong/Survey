
@extends('admin.layouts.default')

@section('head')
    @include('survey.library')
@endsection

@section('body')
    <div class="x-nav">
      <span class="layui-breadcrumb">
          <a href="{{ route('admin_word_resultsPage',$result->word->id) }}">{{ $result->word->name }}</a>
        <a><cite>id:{{ $result->id }}</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div id="surveyElement"></div>
    <div id="surveyResult"></div>
@endsection

@section('footer')
    <script>
        //主题
        Survey.StylesManager.applyTheme("default");

        //题目列表
        var json = {!! \App\Models\Word::find($result->word->id)->content !!};

        window.survey = new Survey.Model(json);

        //提交按钮
        survey.onComplete.add(function (result) {
                document.querySelector('#surveyResult').innerHTML = "result: " + JSON.stringify(result.data);
            });

        //本土化
        survey.locale = 'zh-cn';

        //答案
        survey.data = {!! $result->answer !!};

        survey.mode = 'display';    //只读模式

        $("#surveyElement").Survey({model: survey});
    </script>
@endsection