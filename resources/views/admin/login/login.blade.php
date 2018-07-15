
@extends('admin.layouts.default')

@section('body')
    <body class="login-bg">

    <div class="login layui-anim layui-anim-up">
        <div class="message">Survey管理登录</div>
        <div id="darkbannerwrap"></div>

        @include('admin.shared._messages')

        @include('admin.shared._errors')

        <form method="post" class="layui-form" action="{{ route('admin_login_store') }}">
            {{ csrf_field() }}
            <input name="email" autocomplete="off" placeholder="邮箱"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" autocomplete="off" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input name="remember"  type="checkbox" class="layui-input"> 记住我
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
            <input type="submit">
        </form>
    </div>

    <script>
        $(function  () {
            layui.use('form', function(){
                var form = layui.form;
                layer.msg("...", function(){
                    //关闭后的操作
                });
                //监听提交
                form.on('submit(login)', function(data){
                    layer.msg(JSON.stringify(data.field),function(){
                        location.href='{{ route('admin_login_store') }}'
                    });
                    return false;
                });
            });
        })
    </script>


    <!-- 底部结束 -->

    </body>
@endsection


