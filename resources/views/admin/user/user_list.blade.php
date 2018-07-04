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
        <form class="layui-form layui-col-md12 x-so" action="{{ route('admin_user_search_post') }}" method="post">
            {{ csrf_field() }}
            <input @if(isset($start)) value="{{ $start }}"  @endif class="layui-input" autocomplete="off" placeholder="开始日" name="start" id="start">
            <input @if(isset($end)) value="{{ $end }}"  @endif class="layui-input" autocomplete="off" placeholder="截止日" name="end" id="end">
            <input @if(isset($dataname)) value="{{ $dataname }}"  @endif type="text" name="username" placeholder="请输入用户名" autocomplete="off" class="layui-input">
            <button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量停用</button>
        <button class="layui-btn" onclick="x_admin_show('添加用户','{{ route('admin_user_save') }}',600,400)"><i
                    class="layui-icon"></i>添加
        </button>
        <span class="x-right" style="line-height:40px">共有数据：{{ $dataset->total() }} 条</span>
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
            @foreach($dataset as $data)
                <tr>
                    <td>
                        <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id={{ $data->id }}><i
                                    class="layui-icon">&#xe605;</i></div>
                    </td>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->sex }}</td>
                    <td>{{ $data->number }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->addr }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td class="td-status">
                        @if($data->status === 1)
                            <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
                        @else
                            <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">已停用</span>
                        @endif
                    </td>
                    <td class="td-manage">
                        @if($data->status == 1)
                            <a onclick="member_stop(this,'{{ route('admin_user_status_get',$data->id) }}')" href="javascript:;" title="停用">
                                <i class="layui-icon">&#xe601;</i>
                            </a>
                        @else
                            <a onclick="member_stop(this,'{{ route('admin_user_status_get',$data->id) }}')" href="javascript:;" title="启用">
                                <i class="layui-icon">&#xe62f;</i>
                            </a>
                        @endif
                        <a title="编辑" onclick="x_admin_show('编辑','{{ route('admin_user_save',$data->id) }}',600,400)" href="javascript:;">
                            <i class="layui-icon">&#xe642;</i>
                        </a>
                        <a onclick="x_admin_show('修改密码','{{ route('admin_user_edit_passwd_get',$data->id) }}',600,400)" title="修改密码" href="javascript:;">
                            <i class="layui-icon">&#xe631;</i>
                        </a>
                        <a title="删除" onclick="member_del(this,'{{ route('admin_user_del',$data->id) }}')" href="javascript:;">
                            <i class="layui-icon"></i>
                        </a>
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>
    <div class="page">
        {{ $dataset->appends(['start' => isset($start)?$start:'','end' => isset($end)?$end:'','dataname' => isset($dataname)?$dataname:''])->links() }}
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

    /*修改用户状态*/
    function member_stop(obj, url) {
        layer.confirm('确认要'+$(obj).attr('title')+'吗？', function (index) {
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
                    if ($(obj).attr('title') === '启用') {
                        $(obj).attr('title', '停用');
                        $(obj).find('i').html('&#xe601;');

                        $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                        layer.msg('已启用!', {icon: 6, time: 1000});
                    }else {
                        $(obj).attr('title', '启用');
                        $(obj).find('i').html('&#xe62f;');

                        $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                        layer.msg('已停用!', {icon: 6, time: 1000});
                    }
                },
                error:function (data) {
                    layer.msg('操作失败!', {icon:5, time: 1000});
                }
            });
        });
    }


    /*用户-删除*/
    function member_del(obj, url) {
        layer.confirm('确认要删除吗？', function (index) {
            //发异步删除数据
            $.ajax({
                async: true,    //异步
                type: "get",
                url: url,
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
        });
    }


    function delAll(argument) {
        //获取所有被选中的多选框
        var data = tableCheck.getData();
        console.log(data);
        if (data.length == 0){
            // alert('666');
            layer.msg('未选择用户!', {icon:3, time: 1000});
        }else {
            layer.confirm('确认要停用' + data + '吗？', function (index) {
                //捉到所有被选中的发异步进行删除，
                $.ajax({
                    async: true,    //异步
                    type: "get",
                    url: "http://www.survey.test/admin/user/status_bulk/"+data,
                    traditional: true,
                    // data:id,
                    dataType: "json",
                    cache: true,
                    //服务器返回执行操作的状态
                    success: function(status) {
                        $(".layui-form-checked").not('.header').parents('tr').find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');;
                        layer.msg('已停用!', {icon: 1, time: 1000});
                    },
                    error:function (data) {
                        layer.msg('停用失败!', {icon:2, time: 1000});
                    }
                });
            });
        }

    }
</script>

</html>