@extends('admin.layouts.default')

@section('head')
    {{--<meta charset="utf-8">--}}
    {{--<title>layui</title>--}}
    {{--<meta name="renderer" content="webkit">--}}
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">--}}
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
@endsection

@section('body')

    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a><cite>{{ $word->name }}</cite></a>
        <a href="{{ route('admin_word_result_resultsPage',$word->id) }}"><cite>答卷列表</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <xblock>
            &nbsp;&nbsp;<span><a class="layui-btn layui-btn-primary" href="{{ route('admin_word_result_resultsPage',$word->id) }}">答卷列表</a></span>
            &nbsp;&nbsp;<span><a href="{{ route('admin_word_result_topic_get',$word->id) }}">题目分析</a></span>
            &nbsp;&nbsp;<span><a href="{{ route('admin_word_result_scrapResultsPage',$word->id) }}">作废答卷</a></span>

            <span class="x-right" style="line-height:40px">共有数据：{{ $data->total() }} 条</span>
        </xblock>

        @if($data->total() >= 1)
            <div  style="width:auto; height:auto; overflow:scroll;margin: 20px">
            <table  align="center" style="width:3000px;"  class="layui-table"  lay-size="sm"  >
            <thead>
            <tr>
                <th style="text-align:center;" colspan="3">
                    操作区
                </th>
                <th style="text-align:center;" colspan="{{ $colspan['basic'] }}">
                    基本信息区
                </th>
                <th style="text-align:center;" colspan="{{ $colspan['topic'] }}">
                    题目答案区
                </th>
            </tr>
            </thead>
            <thead>
            <tr>
                {{--<th><div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div></th>--}}
                <th style="width: 40px;">ID</th>
                <th>操作</th>
                <th>答卷时间</th>

                @foreach($word->rule as $rule)
                    <th>{{ $rule->title }}</th>
                @endforeach
                <th>ip地区</th>
                @if($word->grade->isNotEmpty())
                    <th>班级</th>
                @endif

                @foreach($data as $value)
                    @foreach($value->answer as $key => $item)
                        <th title="{{ $key }}">{{ str_limit($key,20) }}</th>
                    @endforeach
                    @break
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($data as $result)
                <tr>
                    <td>{{ $result->id }}</td>
                    <td class="td-manage">
                        <a title="点击查看答卷详情" href="{{ route('admin_word_result_resultShow',$result->id) }}">
                            <i class="iconfont">&#xe705;</i>
                        </a>
                        &nbsp;&nbsp;
                        <a title="作废" onclick="member_del(this,'{{ route('admin_word_result_status_get',$result->id) }}')" href="javascript:;"><i class="layui-icon">&#xe640;</i></a>
                    </td>
                    <td>{{ $result->created_at }}</td>

                    @foreach($word->rule as $rule)
                        <td>{{ $result[$rule->name] }}</td>
                    @endforeach
                    <td>{{ $result->city }}</td>
                    @if($word->grade->isNotEmpty())
                        <td>{{ $result->grade->name }}</td>
                    @endif

                    @foreach($data as $value)
                        @foreach($value->answer as $key => $item)
                            @if(is_array($item))
                                <td>
                                    @foreach($item as $i)
                                        {{ $i }} |
                                    @endforeach
                                </td>
                            @else
                                <td>{{ $item }}</td>
                            @endif

                        @endforeach
                        @break
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
            </div>
        @else
            <h1>暂无答卷。。。</h1>
        @endif


        <div class="page">
            {{ $data->links() }}
        </div>

    </div>
@endsection

@section('footer')
    <script>
        /*用户-删除*/
        function member_del(obj,url){
            layer.confirm('确认要作废此答卷吗？',function(index){

                //发异步把用户状态进行更改
                $.ajax({
                    async: true,    //异步
                    type: "GET",
                    url: url,
                    traditional: true,
                    // data:id,
                    dataType: "json",
                    cache: true,
                    //服务器返回执行操作的状态
                    success: function(status) {
                        $(obj).parents("tr").remove();
                        layer.msg('已作废!', {icon: 1, time: 1000});

                        setTimeout(function () {
                            location.replace(location.href);
                        },1000);

                    },
                    error:function (data) {
                        layer.msg('操作失败!', {icon:5, time: 1000});
                    }
                });
            });
        }
    </script>
@endsection