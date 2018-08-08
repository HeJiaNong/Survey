
@extends('admin.layouts.default')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('body')
    <body class="login-bg">

    <div class="login layui-anim layui-anim-up">
        <div class="message">Survey管理登录</div>
        <div id="darkbannerwrap"></div>

        @include('admin.shared._messages')

        @include('admin.shared._errors')

        <form method="post" class="layui-form" action="{{ route('admin_login_store') }}">
            {{--{{ csrf_field() }}--}}
            <input name="email" autocomplete="off" placeholder="邮箱"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" autocomplete="off" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input name="remember"  type="checkbox" class="layui-input"> 记住我
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
            {{--<input type="submit">--}}
        </form>
    </div>

    <script>
        $(function  () {
            layui.use('form', function(){
                var form = layui.form;
                // layer.msg('玩命卖萌中', function(){
                //   //关闭后的操作
                //   });
                //监听提交
                form.on('submit(login)', function(data){
                    var url = '{{ route('admin_login_store') }}';
                    //异步判断登陆是否成功
                    $.ajax({
                        type : "post",
                        async : false,  //同步
                        url : url,
                        data : data.field,
                        dataType : "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')    //发送csrf_token
                        },
                        success : function (data) {
                            setTimeout(layer.msg(data.msg),1000);

                            location.href= data.url;
                        },
                        error : function (data) {
                            layer.msg(data.responseJSON.msg);
                        }
                    });
                    return false;
                });
            });
        })


    </script>


    <!-- 底部结束 -->

    </body>
@endsection


