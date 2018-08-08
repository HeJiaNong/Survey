@extends('admin.layouts.default')

@section('head')

@endsection

@section('body')
    <div class="x-nav">
          <span class="layui-breadcrumb">
              <a><cite>{{ $word->name }}</cite></a>
          </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
                <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <xblock>
            <span class="layui-btn layui-btn-primary" >选择统计方式：</span>
            &nbsp;&nbsp;<span><a href="{{ route('admin_word_count_answerPage',$word->id) }}">答案列表</a></span>
            &nbsp;&nbsp;<span><a href="{{ route('admin_word_count_answerAvgPage',$word->id) }}">整体概况</a></span>

            <span class="x-right" style="line-height:40px">共有数据：23 条</span>
        </xblock>

        <div style="width:auto; height:auto; overflow:scroll;margin: 20px">
            <table align="center" style="width:auto;"  class="layui-table"  lay-size="sm"  >
                <thead>
                    <tr>
                        <th style="text-align:center;" colspan="@foreach($data as $result) {{ count($result->answer) }} @endforeach">
                            题目平均分
                        </th>
                    </tr>

                </thead>
                <thead>
                    <tr>
                        @foreach($data as $result)
                            @foreach($result->answer as $k=>$v)
                                <th style="width: 50px">{{ $k }}</th>
                            @endforeach
                            @break
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $value)
                    <tr>
                        @foreach($result->answer as $k=>$v)
                            <td style="width: 50px">{{ $score[$k]??'...' }}</td>
                        @endforeach
                        @break
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection

@section('footer')

@endsection