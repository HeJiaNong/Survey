
@extends('admin.layouts.default')

@section('body')
    <div class="x-body layui-anim layui-anim-up">
        <form id="addForm" class="layui-form" action="@if(isset($dataset)) {{ route('admin_user_save',$dataset->id) }} @else {{ route('admin_user_save') }} @endif" method="post">
            {{ csrf_field() }}
            @if(isset($dataset))
                {{ method_field('PUT') }}
            @endif
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>邮箱
                </label>
                <div class="layui-input-inline">
                    <input @if(isset($dataset)) value="{{ $dataset->email }}" @endif type="text" id="L_email" name="email" required="" lay-verify="email"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>将会成为您唯一的登入名
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>昵称
                </label>
                <div class="layui-input-inline">
                    <input @if(isset($dataset)) value="{{ $dataset->name }}" @endif type="text" id="L_username" name="name" required="" lay-verify="nikename"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span class="x-red">*</span>性别</label>
                <div class="layui-input-block">
                    <input type="radio" name="sex" lay-skin="primary" title="男" value="男" @if(isset($dataset)) @if($dataset->sex == '男') checked @endif @endif>
                    <input type="radio" name="sex" lay-skin="primary" title="女" value="女" @if(isset($dataset)) @if($dataset->sex == '女') checked @endif @endif>
                    <input type="radio" name="sex" lay-skin="primary" title="保密" value="保密" @if(isset($dataset)) @if($dataset->sex == '保密') checked @endif @endif >
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>手机号
                </label>
                <div class="layui-input-inline">
                    <input @if(isset($dataset)) value="{{ $dataset->number }}" @endif type="text" id="L_number" name="number" required="" lay-verify="number"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    11位数字
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    地址
                </label>
                <div class="layui-input-inline">
                    <input @if(isset($dataset)) value="{{ $dataset->addr }}" @endif type="text" id="L_username" name="addr" required="" lay-verify="nikename"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            @if(!isset($dataset))
                <div class="layui-form-item">
                    <label for="L_pass" class="layui-form-label">
                        <span class="x-red">*</span>密码
                    </label>
                    <div class="layui-input-inline">
                        <input type="password" id="L_pass" name="password" required="" lay-verify="pass"
                               autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        6到16个字符
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">
                        <span class="x-red">*</span>确认密码
                    </label>
                    <div class="layui-input-inline">
                        <input type="password" id="L_repass" name="password_confirmation" required="" lay-verify="repass"
                               autocomplete="off" class="layui-input">
                    </div>
                </div>
            @endif
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button id="submitAdd" class="layui-btn" lay-filter="add" lay-submit="">
                    增加
                </button>
                <input type="submit">
            </div>
        </form>
    </div>
    <script>
        layui.use(['form', 'layer'], function () {
            $ = layui.jquery;
            var form = layui.form
                , layer = layui.layer;

            //自定义验证规则
            form.verify({
                nikename: function (value) {
                    if (value.length > 20) {
                        return '昵称最大为20字符';
                    }
                }
                , number: function (value) {
                    if (value.length != 11) {
                        return '手机号格式错误';
                    }
                }
                , pass: [/(.+){6,12}$/, '密码必须6到12位']
                , repass: function (value) {
                    if ($('#L_pass').val() != $('#L_repass').val()) {
                        return '两次密码不一致';
                    }
                }
            });

            //监听提交
            form.on('submit(add)', function (data) {
                //发异步，把数据提交给php
                var targetUrl = $("#addForm").attr("action");
                var data = $("#addForm").serialize();
                var save = '';
                /*判断请求方式*/
                @if(isset($dataset)) save = '编辑'; @else save = '添加'; @endif
                $.ajax({
                    type: 'post',
                    url: targetUrl,
                    cache: false,
                    data: data,
                    dataType: 'json',
                    success: function (stauts) {
                        console.log(status);
                        //判断传参过来的code，对其参数进行操作
                        layer.alert(save+'成功', {icon: 6}, function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                        });
                    },
                    error: function () {
                        layer.alert(save+"失败", {icon: 5}, function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                        });
                    }
                });
                return false;
            });
        });
    </script>
@endsection
