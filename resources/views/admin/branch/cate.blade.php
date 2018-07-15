
@extends('admin.layouts.default')

@section('body')
    <style>
            *{box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;}
            .contact-ul{margin-top:10px;font-size:14px;}
            .contact-ul>.contact-li{
                text-align: left;
                border-bottom: 1px solid #E0E0E0;
                padding:10px;
            }
            .contact-ul>.contact-li:hover{
                cursor:pointer;
            }
            .contact-ul>.contact-li:last-child{border-bottom:0px;width:100%;}
            .contact-ul>.contact-li>.contact-content{
                display: none;
            }
            .fa-box{width:100%;overflow-y:auto;position:absolute;bottom:60px;top:50px;}
            .fa-box-item{
                width:100%;
                padding-left:10px;
                padding-top:5px;
                padding-bottom:5px;
                background:white;
                border-bottom:1px solid rgba(160,160,160,.3);
                overflow:hidden;white-space:nowrap;text-overflow:ellipsis;
            }
            .fa-box-item:hover{
                cursor:pointer;
            }
            .fa-box-item:last-child{border-bottom:0px;}
            .fa-box-item-left{width:40px;height:40px;float:left;background:pink;border-radius:50%;position:relative;}
            .fa-box-item-right{height:40px;max-width:65%;float:left;padding-left:3px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;}
            .fa-color-red{color:rgba(200,0,0,.8);}
        </style>
    <div class="x-nav">
        <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">演示</a>
            <a>
            <cite>导航元素</cite></a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <div class="layui-row">
            <form action="{{ route('admin_branch_add') }}" method="post" class="layui-form layui-col-md12 x-so layui-form-pane">
                {{ csrf_field() }}
                <input class="layui-input" placeholder="部门名称" name="name">
                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon"></i>增加</button>
            </form>
        </div>

        <blockquote class="layui-elem-quote">部门列表<i class="layui-icon x-show" status='true'>&#xe623;</i></blockquote>

        <div class="contact-ul" id="contact-ul">
            @foreach($dataset as $data)
                <div class="contact-li">
                    <div class="contact-group"> <i class="fa fa-angle-down "></i>{{ $data->name }}&nbsp;<i class="layui-icon x-show" status='true'>&#xe623;</i>
                        ({{ $data->teacher->count() }}人)
                        @if(1 !== $data->id)
                            <a onclick="member_del(this,'{{ route('admin_branch_del',$data->id) }}')" href="javascript:;" title="删除">
                                <i class="icon iconfont">&#xe69a;</i>
                            </a>
                        @endif

                    </div>

                    <div class="contact-content">
                        @foreach($data->teacher as $teacher)
                        <div class="fa-box-item">
                            <div class="fa-box-item-left"></div>
                            <div class="fa-box-item-right">{{ $teacher->name }}<br><i class="fa fa-heart fa-color-red  fa-size-xxs" ></i>{{ $teacher->email }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        layui.use(['form'], function(){
            form = layui.form;

        });



        /*删除部门*/
        function member_del(obj,url){
            layer.confirm("<h2>删除分组</h2>选定的部门将被删除，部门中的老师将会移至系统默认部门"+"\"@foreach($dataset as $data) @if(1 == $data->id) {{ $data->name }} @endif @endforeach\""+"</br>您确认要删除该部门吗?",function(index){
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



        //监听提交
        {{--form.on('submit(add)', function (data) {--}}
            {{--//发异步，把数据提交给php--}}
            {{--var targetUrl = $("#addForm").attr("action");--}}
            {{--var data = $("#addForm").serialize();--}}
            {{--var save = '';--}}
            {{--/*判断请求方式*/--}}
            {{--@if(isset($dataset)) save = '编辑'; @else save = '添加'; @endif--}}
            {{--$.ajax({--}}
                {{--type: 'post',--}}
                {{--url: targetUrl,--}}
                {{--cache: false,--}}
                {{--data: data,--}}
                {{--dataType: 'json',--}}
                {{--success: function (stauts) {--}}
                    {{--console.log(status);--}}
                    {{--//判断传参过来的code，对其参数进行操作--}}
                    {{--layer.alert(save+'成功', {icon: 6}, function () {--}}
                        {{--// 获得frame索引--}}
                        {{--var index = parent.layer.getFrameIndex(window.name);--}}
                        {{--//关闭当前frame--}}
                        {{--parent.layer.close(index);--}}
                    {{--});--}}
                {{--},--}}
                {{--error: function () {--}}
                    {{--layer.alert(save+"失败", {icon: 5}, function () {--}}
                        {{--// 获得frame索引--}}
                        {{--var index = parent.layer.getFrameIndex(window.name);--}}
                        {{--//关闭当前frame--}}
                        {{--parent.layer.close(index);--}}
                    {{--});--}}
                {{--}--}}
            {{--});--}}
            {{--return false;--}}
        {{--});--}}

    </script>
    <script type="text/javascript">
        /*这是qq下拉分组js*/
            $(function(){
                $("#contact-ul>.contact-li>.contact-group").click(function(){
                    if($(this).find("i").hasClass("fa-angle-down")){
                        /**设置当前选中图标**/
                        $(this).find("i").removeClass("fa-angle-down");
                        $(this).find("i").addClass("fa-angle-up");
                        /**样式1：只关注当前项**/
                        $(this).nextAll().slideDown();
                        /**样式2：设置显示当前内容，其他组内容隐藏，未选中图标**/
                        //$(this).nextAll().slideDown().end().parent().siblings().children(".contact-content").hide();
                        //$(this).parent().siblings().children("div").children("i").removeClass("fa-angle-up").addClass("fa-angle-down");
                    }else{
                        /**设置当前取消选中图标**/
                        $(this).find("i").removeClass("fa-angle-up");
                        $(this).find("i").addClass("fa-angle-down");
                        /**样式1：只关注当前项**/
                        $(this).nextAll().slideUp();
                        /**样式2：设置所有内容隐藏，未选中图标**/
                        //$(this).nextAll().slideUp().end().parent().siblings().children(".contact-content").hide();
                        //$(this).parent().siblings().children("div").children("i").removeClass("fa-angle-up").addClass("fa-angle-down");;
                    }
                });
            });

        </script>
@endsection

