@include('admin.layouts._meta')

<body class="layui-anim layui-anim-up">
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
            <input class="layui-input" placeholder="开始日" name="start" id="start">
            <input class="layui-input" placeholder="截止日" name="end" id="end">
            <input type="text" name="username" placeholder="请输入用户名" autocomplete="off" class="layui-input">
            <button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加用户','{{ route('users').'/add' }}',600,400)"><i
                    class="layui-icon"></i>添加
        </button>
        <span class="x-right" style="line-height:40px">共有数据：88 条</span>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>
                <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i
                            class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>用户名</th>
            <th>性别</th>
            <th>手机</th>
            <th>邮箱</th>
            <th>地址</th>
            <th>加入时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>
                        <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id={{ $user->id }}><i
                                    class="layui-icon">&#xe605;</i></div>
                    </td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->sex }}</td>
                    <td>{{ $user->number }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->addr }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td class="td-status">
                        @switch($user->status)
                            @case(1)
                                <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
                            @break
                            @case(0)
                                <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">已停用</span>
                            @break
                        @endswitch

                    </td>
                    <td class="td-manage">
                        @switch($user->status)
                            @case(1)
                        <a onclick="member_stop(this,{{ $user->id }})" href="javascript:;" title="停用">
                            <i class="layui-icon">&#xe601;</i>
                        </a>
                            @break
                            @case(0)
                            <a onclick="member_stop(this,{{ $user->id }})" href="javascript:;" title="启用">
                                <i class="layui-icon">&#xe62f;</i>
                            </a>
                            @break
                        @endswitch
                        <a title="编辑" onclick="x_admin_show('编辑','member-edit.html',600,400)" href="javascript:;">
                            <i class="layui-icon">&#xe642;</i>
                        </a>
                        <a onclick="x_admin_show('修改密码','member-password.html',600,400)" title="修改密码" href="javascript:;">
                            <i class="layui-icon">&#xe631;</i>
                        </a>
                        <a title="删除" onclick="member_del(this,{{ $user->id }})" href="javascript:;">
                            <i class="layui-icon">&#xe640;</i>
                        </a>
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>
    <div class="page">
        {{ $users->links() }}
        {{--<div>--}}
            {{--<a class="prev" href="">&lt;&lt;</a>--}}
            {{--<a class="num" href="">1</a>--}}
            {{--<span class="current">2</span>--}}
            {{--<a class="num" href="">3</a>--}}
            {{--<a class="num" href="">489</a>--}}
            {{--<a class="next" href="">&gt;&gt;</a>--}}
        {{--</div>--}}
    </div>

</div>
<script>
    layui.use('laydate', function () {
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#end' //指定元素
        });
    });

    /*用户-停用*/
    function member_stop(obj, id) {
        layer.confirm('确认要'+$(obj).attr('title')+'吗？', function (index) {
            if ($(obj).attr('title') === '启用') {
                //发异步把用户状态进行更改
                $.ajax({
                    async: true,    //异步
                    type: "get",
                    url: "http://www.survey.test/admin/users/status/"+id+'/1',
                    traditional: true,
                    // data:id,
                    dataType: "json",
                    cache: true,
                    //服务器返回执行操作的状态
                    success: function(status) {
                        if (status === 1){
                            $(obj).attr('title', '停用');
                            $(obj).find('i').html('&#xe601;');

                            $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                            layer.msg('已启用!', {icon: 6, time: 1000});
                        }else {
                            layer.msg('操作失败!', {icon:5, time: 1000});
                        }
                    },
                    error:function (data) {
                        layer.msg('操作失败!', {icon:5, time: 1000});
                    }
                });
            } else {
                $.ajax({
                    async: true,    //异步
                    type: "get",
                    url: "http://www.survey.test/admin/users/status/"+id+'/0',
                    traditional: true,
                    // data:id,
                    dataType: "json",
                    cache: true,
                    //服务器返回执行操作的状态
                    success: function(status) {
                        if (status === 1){
                            $(obj).attr('title', '启用');
                            $(obj).find('i').html('&#xe62f;');

                            $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                            layer.msg('已停用!', {icon: 6, time: 1000});
                        }else {
                            layer.msg('操作失败!', {icon:5, time: 1000});
                        }
                    },
                    error:function (data) {
                        layer.msg('操作失败!', {icon:5, time: 1000});
                    }
                });
            }

        });
    }

    /*用户-删除*/
    function member_del(obj, id) {
        layer.confirm('确认要删除吗？', function (index) {
            //发异步删除数据
            $.ajax({
                async: true,    //异步
                type: "get",
                url: "http://www.survey.test/admin/users/status/"+id+'/-1',
                traditional: true,
                // data:id,
                dataType: "json",
                cache: true,
                //服务器返回执行操作的状态
                success: function(status) {
                    if (status === 1){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!', {icon: 1, time: 1000});
                    }else {
                        layer.msg('删除失败!', {icon:2, time: 1000});
                    }
                },
                error:function (data) {
                    layer.msg('删除失败!', {icon:2, time: 1000});
                }
            });
            {{--$.get("{{ route('users_del_store',23) }}",function (status) {--}}

                {{--alert(id);--}}
                {{--if (status === 1){--}}
                    {{--$(obj).parents("tr").remove();--}}
                    {{--layer.msg('已删除!', {icon: 1, time: 1000});--}}
                {{--}else {--}}
                    {{--layer.msg('删除失败!', {icon:2, time: 1000});--}}
                {{--}--}}
            {{--},'json');--}}
        });
    }


    function delAll(argument) {
        //获取所有被选中的多选框
        var data = tableCheck.getData();
        layer.confirm('确认要删除' + data + '吗？', function (index) {
            //捉到所有被选中的发异步进行删除，
            $.ajax({
                async: true,    //异步
                type: "PUT",
                url: "http://www.survey.test/admin/users/status/"+data+',/-1',
                traditional: true,
                // data:id,
                dataType: "json",
                cache: true,
                //服务器返回执行操作的状态
                success: function(status) {
                    if (status === 1){
                        $(".layui-form-checked").not('.header').parents('tr').remove();
                        layer.msg('已删除!', {icon: 1, time: 1000});
                    }else {
                        layer.msg('删除失败!', {icon:2, time: 1000});
                    }
                },
                error:function (data) {
                    layer.msg('删除失败!', {icon:2, time: 1000});
                }
            });
        });
    }
</script>

</html>