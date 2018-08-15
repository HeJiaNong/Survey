@extends('admin.layouts.default')

@section('head')
    @include('survey.library')
@endsection

@section('body')

    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a><cite>{{ $word->name }}</cite></a>
        <a href="{{ route('admin_word_result_topic_get',$word->id) }}"><cite>题目分析</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
           href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <xblock>
            &nbsp;&nbsp;<span><a href="{{ route('admin_word_result_resultsPage',$word->id) }}">答卷列表</a></span>
            &nbsp;&nbsp;<span><a class="layui-btn layui-btn-primary"
                                 href="{{ route('admin_word_result_topic_get',$word->id) }}">题目分析</a></span>
            &nbsp;&nbsp;<span><a href="{{ route('admin_word_result_scrapResultsPage',$word->id) }}">作废答卷</a></span>

            <span class="x-right" style="line-height:40px">题目数量：{{ count($topics) }}
                题&nbsp;|&nbsp;有效答卷：{{ count($word->result()->where('status','1')->get()) }} 份</span>
        </xblock>

        @foreach($topics as $topic)
            <table align="center" style="width:100%;margin: 30px 0px 30px 0px;"  class="layui-table"  lay-size="sm"  >
                <thead>
                    <tr>
                        <th width="40%">

                            @if(isset($topic['content']['isRequired']))
                                [<span class="x-red">必填</span>]
                            @endif

                            @if(isset($topic['content']['hasOther']))
                                [<span class="x-a">其他</span>]
                            @endif

                            &nbsp;[ {{ getTopicTitleByName($topic['type'])}} ]

                            @if(!in_array($topic['type'],['html','expression']))
                                &nbsp;[<span onclick="x_admin_show('{{ getTopicTitleByName($topic['type'])}}','{{ route('admin_word_result_subjectDataStatistics',compact('topic')) }}',1000,600)" ><a href="javascript:;"  >表格数据</a></span>]
                            @endif

                            @if(!in_array($topic['type'],['text','comment','multipletext','html','expression']))
                                &nbsp;[<span onclick="x_admin_show('{{ getTopicTitleByName($topic['type'])}}','{{ route('admin_word_result_subjectDataStatisticsEcharts',compact('topic')) }}',1000,600)" ><a href="javascript:;"  >图形统计</a></span>]
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <iframe src="{{ route('showIndividualTopics',['content' => $topic['content']]) }}" scrolling="no" width="100%" height="100%" frameborder="0" onload="this.height=0;var fdh=(this.Document?this.Document.body.scrollHeight:this.contentDocument.body.offsetHeight);this.height=(fdh>100?fdh:100)-120"></iframe>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach


        {{--<div id="surveyElement" style="width: 50%"></div>--}}

    </div>

@endsection

@section('footer')
    <script>
        {{--//主题--}}
        {{--Survey.StylesManager.applyTheme("default");--}}

        {{--//题目列表--}}
        {{--var json = @json($word->content);--}}

        {{--window.survey = new Survey.Model(json);--}}

        {{--//提交按钮--}}
        {{--survey.onComplete.add(function (result) {--}}
            {{--document.querySelector('#surveyResult').innerHTML = "result: " + JSON.stringify(result.data);--}}
        {{--});--}}

        {{--//本土化--}}
        {{--survey.locale = 'zh-cn';--}}

        {{--//答案--}}
        {{--survey.data = {!! json_encode($result->answer) !!};--}}

        {{--survey.mode = 'display';    //只读模式--}}

        {{--$("#surveyElement").Survey({model: survey});--}}
    </script>
@endsection