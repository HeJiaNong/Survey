
@extends('admin.layouts.default')

@section('body')
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
            <form class="layui-form layui-col-md12 x-so" action="{{ route('admin_word_search_post') }}" method="post">
                {{ csrf_field() }}
                <input @if(isset($start)) value="{{ $start }}" @endif class="layui-input" autocomplete="off"
                       placeholder="开始日" name="start" id="start">
                <input @if(isset($end)) value="{{ $end }}" @endif class="layui-input" autocomplete="off" placeholder="截止日"
                       name="end" id="end">
                <input @if(isset($dataname)) value="{{ $dataname }}" @endif type="text" name="username" placeholder="请输入用户名"
                       autocomplete="off" class="layui-input">
                <button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </form>
        </div>
        <xblock>
            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量下架</button>
            <button class="layui-btn" onclick="x_admin_show('添加问卷','{{ route('admin_word_addPage') }}',600,400)"><i
                        class="layui-icon"></i>添加
            </button>
            <span class="x-right" style="line-height:40px">共有数据：{{ $dataset->total() }} 条</span>
        </xblock>
        <table class="layui-table layui-form">
            <thead>
            <tr>
                <th>
                    <div class="layui-unselect header layui-form-checkbox" lay-skin="primary">
                        <i class="layui-icon">&#xe605;</i>
                    </div>
                </th>
                <th>ID</th>
                <th>模板名称</th>
                <th>类型</th>
                <th>描述</th>
                <th>允许班级</th>
                <th>更新时间</th>
                <th>内容详情</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($dataset as $data)
                <tr>
                    <td>
                        <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id={{ $data->id }}>
                            <i class="layui-icon">&#xe605;</i>
                        </div>
                    </td>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->category->name }}</td>
                    <td>{{ $data->describe }}</td>
                    <td>
                    {{-- 返回值不重复 --}}
                    @foreach($data->grade->unique() as $value)
                        {{ $value->name }}<br>
                    @endforeach
                    </td>

                    {{--<td>{{ $data->grade()->count() }}</td> --}}{{-- 参与人数 --}}

                    <td>{{ $data->updated_at }}</td>
                    <td class="td-edit">
                        @if(!empty($data->content))
                            <button class="layui-btn layui-btn layui-btn-xs" onclick="x_admin_show('问卷详情/测试','{{ route('admin_word_show',$data->id) }}')">
                                <i class="iconfont">&#xe6e6;&nbsp;</i>点击查看详情
                            </button>
                        @endif
                            <button id="edit" class="layui-btn layui-btn-warm layui-btn-xs @if($data->status == 1) layui-btn-disabled @endif " @if($data->status == 0) onclick="x_admin_show('编辑问卷','{{ route('admin_word_editor',$data->id) }}')" @endif >
                                <i class="iconfont">&#xe69e;&nbsp;</i>编辑
                            </button>
                            &nbsp;
                            <a href="javascript:;" title="复制链接" onclick="copyURL('{{ route('home_wordShow',$data->id) }}')">
                                <i class="iconfont">&#xe6c0;</i>
                            </a>
                            &nbsp;
                            <a href="javascript:;" title="查看二维码" onclick="qrcode('{{ $data->qrcode }}')">
                                <i class="iconfont"  >&#xe6ec;</i>
                            </a>

                    </td>
                    <td class="td-status ">
                        <input type="checkbox" lay-filter="switchStatus" name="switch" lay-skin="switch" lay-text="发布|下架" value="{{ $data->id }}" @if($data->status == 1) checked @endif  >
                    </td>
                    <td class="td-manage">
                        <a id="edit2" href="javascript:;" title="编辑" @if($data->status == 0) onclick="x_admin_show('编辑','{{ route('admin_word_save',$data->id) }}',600,400)" @endif>
                            <i class="layui-icon">&#xe642;</i>
                        </a>
                        <a id="del" href="javascript:;" title="删除" @if($data->status == 0) onclick="member_del(this,'{{ route('admin_word_del',$data->id) }}')" @endif>
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

@endsection

@section('footer')
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

        /*复制链接*/
        function copyURL(url) {
            var oInput = document.createElement('input');
            oInput.value = url;
            document.body.appendChild(oInput);
            oInput.select(); // 选择对象
            document.execCommand("Copy"); // 执行浏览器复制命令
            oInput.className = 'oInput';
            oInput.style.display='none';
            layer.msg('复制URL成功!', {icon: 1, time: 1000});
        }

        /*查看二维码*/
        function qrcode(url) {

            var json = {
                "title": "二维码", //相册标题
                "id": url, //相册id
                "start": 0, //初始显示的图片序号，默认0
                "data": [   //相册包含的图片，数组格式
                    {
                        "alt": "二维码",
                        "pid": url, //图片id
                        "src": url, //原图地址
                        "thumb": url //缩略图地址
                    }
                ]
            };
            //弹出层，弹出二维码图片
            layer.photos({
                photos: json
                ,anim: 0 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
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
                    success: function (status) {
                        if (status === 1) {
                            $(obj).parents("tr").remove();
                            layer.msg('已删除!', {icon: 1, time: 1000});
                        } else {
                            layer.msg('删除失败!', {icon: 2, time: 1000});
                        }
                    },
                    error: function (data) {
                        layer.msg('删除失败!', {icon: 2, time: 1000});
                    }
                });
            });
        }

        /*批量操作*/
        function delAll(argument) {
            //获取所有被选中的多选框
            var data = tableCheck.getData();
            if (data.length == 0) {
                // alert('666');
                layer.msg('未选择用户!', {icon: 3, time: 1000});
            } else {
                layer.confirm('确认要停用' + data + '吗？', function (index) {
                    //捉到所有被选中的发异步进行删除，
                    $.ajax({
                        async: true,    //异步
                        type: "get",
                        url: "http://www.survey.test/admin/word/status_bulk/" + data,
                        traditional: true,
                        // data:id,
                        dataType: "json",
                        cache: true,
                        //服务器返回执行操作的状态
                        success: function (status) {
                            $(".layui-form-checked").not('.header').parents('tr').find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                            layer.msg('已停用!', {icon: 1, time: 1000});
                        },
                        error: function (data) {
                            layer.msg('停用失败!', {icon: 2, time: 1000});
                        }
                    });
                });
            }

        }

        /*修改问卷模板状态*/
        $(function () {
            layui.use('form',function () {
                var form = layui.form;
                form.on('switch(switchStatus)',function (obj) {
                    var id = obj.value;    //获取id
                    var url = '{{ route('admin_word_status_get') }}'+'/'+id;
                    var checked = obj.elem.checked;

                    $.ajax({
                        async: true,    //异步
                        type: "get",
                        url: url,
                        traditional: true,
                        // data:id,
                        dataType: "json",
                        cache: true,
                        //服务器返回执行操作的状态
                        success: function (data) {
                            if (checked === true){  //当发布时
                                $(obj.othis[0]).parents("tr").find(".td-manage").find('#edit2').attr('onclick',"");    //修改编辑按钮的点击事件
                                $(obj.othis[0]).parents("tr").find(".td-manage").find('#del').attr('onclick',"");    //修改编辑按钮的点击事件
                                $(obj.othis[0]).parents("tr").find(".td-edit").find('#edit').addClass('layui-btn-disabled');    //修改编辑按钮的样式
                                $(obj.othis[0]).parents("tr").find(".td-edit").find('#edit').attr('onclick','');    //修改编辑按钮的点击事件
                            }else { //当下架时
                                $(obj.othis[0]).parents("tr").find(".td-manage").find('#edit2').attr('onclick',"x_admin_show('编辑','{{ route('admin_word_save',$data->id) }}',600,400)");    //修改编辑按钮的点击事件
                                $(obj.othis[0]).parents("tr").find(".td-manage").find('#del').attr('onclick',"member_del(this,'{{ route('admin_word_del',$data->id) }}')");    //修改编辑按钮的点击事件
                                $(obj.othis[0]).parents("tr").find(".td-edit").find('#edit').removeClass('layui-btn-disabled');    //修改编辑按钮的样式
                                $(obj.othis[0]).parents("tr").find(".td-edit").find('#edit').attr('onclick',"x_admin_show('编辑问卷','{{ route('admin_word_editor',$data->id) }}')"); //修改编辑按钮的点击事件
                            }
                            layer.msg(data.msg, {icon: 1, time: 1000});
                        },
                        error: function (data) {
                            layer.msg('操作失败!', {icon: 2, time: 1000});
                        }
                    });
                });
            })
        })


    </script>
@endsection





























