
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
                <input @if(isset($dataname)) value="{{ $dataname }}" @endif type="text" name="username" placeholder="请输入问卷名"
                       autocomplete="off" class="layui-input">
                <button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </form>
        </div>
        {{--<blockquote class="layui-elem-quote"><h3>注意!&nbsp;修改问卷内容将会清空之前统计数据！</h3></blockquote>--}}
        <xblock>
            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量下架</button>
            <button class="layui-btn" onclick="x_admin_show('发布问卷','{{ route('admin_word_addPage') }}',1000,600)"><i
                        class="layui-icon"></i>发布问卷
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
                <th>问卷名称</th>
                <th>分组</th>
                <th style="width: 120px">描述</th>
                <th style="width: 60px">参与规则</th>
                <th>更新时间</th>
                <th style="width: 240px;">内容详情</th>
                <th style="width: 75px;">数据统计</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>

            <tbody>
            @foreach($dataset as $data)
                <tr style="height: 50px;">
                    <td>
                        <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id={{ $data->id }}>
                            <i class="layui-icon">&#xe605;</i>
                        </div>
                    </td>
                    <td>{{ $data->id }}</td>
                    <td><a target="_blank" href="{{ route('home_wordShow',$data->id) }}">{{ $data->name }}</a></td>
                    <td>{{ $data->category->name }}</td>
                    <td><span title="{{ $data->describe }}">@if(mb_strlen($data->describe) > 7) {{ mb_substr($data->describe,0,7) }} … @else {{$data->describe}} @endif</span></td>
                    <td>
                    {{--如果没有规则--}}
                    @if($data->grade->isEmpty() && $data->rule->isEmpty())
                        公开
                    @else
                        <a id="edit2"  href="javascript:;" title="编辑" onclick="x_admin_show('查看规则','{{ route('admin_word_showRule',$data->id) }}',1000,600)" >
                            <i class="iconfont">&#xe6e6;&nbsp;</i>
                        </a>
                    @endif
                    </td>
                    <td>{{ $data->updated_at }}</td>
                    <td class="td-edit">
                        {{--@if(!empty($data->content))--}}
                            <button class="layui-btn layui-btn layui-btn-xs" onclick="x_admin_show('问卷详情/测试','{{ route('admin_word_show',$data->id) }}')">
                                <i class="iconfont">&#xe6e6;&nbsp;</i>点击查看详情
                            </button>
                        {{--@endif--}}
                            <button id="edit" url="x_admin_show('编辑 {{ $data->name }} 问卷','{{ route('admin_word_editor',$data->id) }}')" class="layui-btn layui-btn-warm layui-btn-xs @if($data->status == 1) layui-btn-disabled @endif " @if($data->status == 0) onclick="x_admin_show('编辑 {{ $data->name }} 问卷','{{ route('admin_word_editor',$data->id) }}')" @endif >
                                <i class="iconfont">&#xe69e;&nbsp;</i>编辑
                            </button>
                            &nbsp;
                            <a href="javascript:;" title="复制链接" onclick="copyURL('{{ route('home_wordShow',$data->id) }}')">
                                <i class="iconfont">&#xe6c0;</i>
                            </a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="javascript:;" title="查看二维码" onclick="qrcode('{{ $data->qrcode }}')">
                                <i class="iconfont">&#xe6a9;</i>
                            </a>

                    </td>
                    <td>
                        {{--<a href="javascript:;" title="数据统计" onclick="x_admin_show('{{ $data->name }}','{{ route('admin_word_wordCount',$data->id) }}')">--}}
                            {{--<i class="iconfont"  >&#xe757;</i>--}}
                        {{--</a>--}}
                        &nbsp;&nbsp;&nbsp;
                        <a href="javascript:;" title="答卷列表" onclick="x_admin_show('{{ $data->name }}','{{ route('admin_word_result_resultsPage',$data->id) }}')">
                            <i class="iconfont"  >&#xe757;</i><sup>&nbsp;{{$data->result()->count()}}</sup>
                        </a>

                        <!-- <button onclick="x_admin_show('{{ $data->name }}','{{ route('admin_word_result_resultsPage',$data->id) }}')" class="layui-btn  layui-btn-sm layui-btn-radius layui-btn-normal" >
                                参与:{{$data->result()->count()}}人
                        </button> -->
                    </td>
                    <td class="td-status ">
                        <input type="checkbox" lay-filter="switchStatus" name="switch" lay-skin="switch" lay-text="发布|下架" value="{{ $data->id }}" @if($data->status == 1) checked @endif  >
                    </td>
                    <td class="td-manage">
                        <a id="edit2" url="x_admin_show('编辑问卷','{{ route('admin_word_editPage',$data->id) }}',1000,600)" href="javascript:;" title="编辑问卷" @if($data->status == 0) onclick="x_admin_show('编辑问卷','{{ route('admin_word_editPage',$data->id) }}',1000,600)" @endif>
                            <i class="layui-icon">&#xe642;</i>
                        </a>
                        <a id="del" url="member_del(this,'{{ route('admin_word_del',$data->id) }}')" href="javascript:;" title="删除" @if($data->status == 0) onclick="member_del(this,'{{ route('admin_word_del',$data->id) }}')" @endif>
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
        /*修改问卷模板状态*/
        $(function () {
            layui.use('form',function () {
                var form = layui.form;
                form.on('switch(switchStatus)',function (obj) {
                    var id = obj.value;    //获取id
                    var url = '{{ url('/admin/word/status') }}'+'/'+id;
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
                            var onclick = $(obj.othis[0]).parents("tr").find(".td-edit").find('#edit').attr('url');
                            var onclick2 = $(obj.othis[0]).parents("tr").find(".td-manage").find('#edit2').attr('url');
                            var del = $(obj.othis[0]).parents("tr").find(".td-manage").find('#del').attr('url');
                            if (checked === true){  //当发布时
                                $(obj.othis[0]).parents("tr").find(".td-manage").find('#edit2').attr('onclick',"");    //修改编辑按钮的点击事件
                                $(obj.othis[0]).parents("tr").find(".td-manage").find('#del').attr('onclick',"");    //修改编辑按钮的点击事件
                                $(obj.othis[0]).parents("tr").find(".td-edit").find('#edit').addClass('layui-btn-disabled');    //修改编辑按钮的样式
                                $(obj.othis[0]).parents("tr").find(".td-edit").find('#edit').attr('onclick','');    //修改编辑按钮的点击事件
                            }else { //当下架时

                                $(obj.othis[0]).parents("tr").find(".td-manage").find('#edit2').attr('onclick',onclick2);    //修改编辑按钮的点击事件
                                $(obj.othis[0]).parents("tr").find(".td-manage").find('#del').attr('onclick',del);    //修改编辑按钮的点击事件
                                $(obj.othis[0]).parents("tr").find(".td-edit").find('#edit').removeClass('layui-btn-disabled');    //修改编辑按钮的样式
                                $(obj.othis[0]).parents("tr").find(".td-edit").find('#edit').attr('onclick',onclick); //修改编辑按钮的点击事件
                            }
                            layer.msg(data.msg, {icon: 1, time: 1000});
                        },
                        error: function (data) {
                            layer.msg('操作失败!', {icon: 2, time: 1000});
                        }
                    });
                });
            })
        });

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
            layer.confirm('确认要删除吗？<br /><span class="x-red">该问卷下的所有答卷将会清空!</span>', function (index) {
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
                    success: function (data) {
                        $(obj).parents("tr").remove();
                        layer.msg(data.msg, {icon: 1, time: 1000});
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




    </script>
@endsection





























