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
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <div class="layui-row">
            <form class="layui-form layui-col-md12 x-so">
                <input class="layui-input" placeholder="开始日" name="start" id="start">
                <input class="layui-input" placeholder="截止日" name="end" id="end">
                <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                <span class="x-right" style="line-height:40px">共有数据：{{ $paginate->total() }} 条</span>
            </form>
        </div>
        {{--<xblock>--}}
            {{--<button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>--}}
            {{--<button class="layui-btn" onclick="x_admin_show('添加用户','./admin-add.html')"><i class="layui-icon"></i>添加</button>--}}
            {{----}}
        {{--</xblock>--}}
        <table class="layui-table">
            <thead>
            <tr>
                {{--<th><div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div></th>--}}
                <th>ID</th>
                @foreach($word->rule as $rule)
                    <th>{{ $rule->title }}</th>
                @endforeach
                @if($word->grade->isNotEmpty())
                    <th>班级</th>
                @endif
                <th>ip地区</th>
                <th>答卷时间</th>
                <th>答卷详情</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($paginate as $result)
            <tr>
                {{--<td><div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='2'><i class="layui-icon">&#xe605;</i></div></td>--}}
                <td>{{ $result->id }}</td>
                @foreach($word->rule as $rule)
                    <td>{{ $result[$rule->name] }}</td>
                @endforeach
                @if($word->grade->isNotEmpty())
                    <td>{{ $result->grade->name }}</td>
                @endif
                <td>{{ $result->city }}</td>
                <td>{{ $result->created_at }}</td>
                <td>
                    <a title="点击查看答卷详情" href="{{ route('admin_word_resultShow',$result->id) }}">
                        <i class="iconfont">&#xe705;</i>
                    </a>
                </td>
                <td class="td-manage">
                    <a title="删除" onclick="member_del(this,'要删除的id')" href="javascript:;"><i class="layui-icon">&#xe640;</i></a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        <div class="page">
            {{ $paginate->links() }}
        </div>

    </div>


@endsection

@section('footer')
    <script>
        // layui.use('laydate', function(){
        //     var laydate = layui.laydate;
        //
        //     //执行一个laydate实例
        //     laydate.render({
        //         elem: '#start' //指定元素
        //     });
        //
        //     //执行一个laydate实例
        //     laydate.render({
        //         elem: '#end' //指定元素
        //     });
        // });

        /*用户-停用*/
        // function member_stop(obj,id){
        //     layer.confirm('确认要停用吗？',function(index){
        //
        //         if($(obj).attr('title')=='启用'){
        //
        //             //发异步把用户状态进行更改
        //             $(obj).attr('title','停用')
        //             $(obj).find('i').html('&#xe62f;');
        //
        //             $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
        //             layer.msg('已停用!',{icon: 5,time:1000});
        //
        //         }else{
        //             $(obj).attr('title','启用')
        //             $(obj).find('i').html('&#xe601;');
        //
        //             $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
        //             layer.msg('已启用!',{icon: 5,time:1000});
        //         }
        //
        //     });
        // }

        /*用户-删除*/
        function member_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                //发异步删除数据
                $(obj).parents("tr").remove();
                layer.msg('已删除!',{icon:1,time:1000});
            });
        }


        /*用户-批量删除*/
        // function delAll (argument) {
        //
        //     var data = tableCheck.getData();
        //
        //     layer.confirm('确认要删除吗？'+data,function(index){
        //         //捉到所有被选中的，发异步进行删除
        //         layer.msg('删除成功', {icon: 1});
        //         $(".layui-form-checked").not('.header').parents('tr').remove();
        //     });
        // }
    </script>
@endsection