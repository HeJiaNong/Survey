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

        <table class="layui-table"  lay-size="sm">
            <thead>
            <tr>
                <th>题目</th>
                @foreach($data as $result)
                    <th>ID:{{ $result->id }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($item as $value)
                <tr>
                    <td>{{ $value }}</td>
                    @foreach($data as $result)
                        <td>
                            @php
                                echo $result->answer[$value];
                            @endphp
                        </td>
                    @endforeach

                </tr>
            @endforeach
            </tbody>
            <thead>
            <tr>
                <th>总分</th>
                @foreach($data as $result)
                    <th>
                        {{ $result->score }}
                    </th>
                @endforeach
            </tr>
            </thead>

        </table>

        <div class="page">
            {{ $data->links() }}
        </div>

    </div>
@endsection

@section('footer')

@endsection