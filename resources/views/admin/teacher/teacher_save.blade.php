
@extends('admin.layouts.default')

@section('content')
    <div class="x-body layui-anim layui-anim-up">
        <form id="addForm" class="layui-form" action="@if(isset($dataset)) {{ route('admin_teacher_save',$dataset->id) }} @else {{ route('admin_teacher_save') }} @endif" method="post">
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
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>所属部门
                </label>
                <div class="layui-input-inline">
                    <select name="branch_id" >
                        @foreach($rows as $row)
                            <option value="{{ $row->id }}" @if(isset($dataset)) @if($dataset->branch->id == $row->id) selected @endif @endif  >{{$row->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span class="x-red">*</span>性别</label>
                <div class="layui-input-block">
                    <input type="radio" name="sex" lay-skin="primary" title="男" value="男" @if(isset($dataset)) @if($dataset->sex == '男') checked @endif @endif >
                    <input type="radio" name="sex" lay-skin="primary" title="女" value="女" @if(isset($dataset)) @if($dataset->sex == '女') checked @endif @endif >
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
                console.log(data);
                $.ajax({
                    type: 'post',
                    url: targetUrl,
                    cache: false,
                    data: data,
                    dataType: 'json',
                    success: function (stauts) {
                        console.log(status);
                        //判断传参过来的code，对其参数进行操作
                        switch (stauts) {
                            case 1:
                                layer.alert('添加成功', {icon: 6}, function () {
                                    // 获得frame索引
                                    var index = parent.layer.getFrameIndex(window.name);
                                    //关闭当前frame
                                    parent.layer.close(index);
                                });
                                break;
                            case 0:
                                layer.alert("增加失败", {icon: 5}, function () {
                                    var index = parent.layer.getFrameIndex(window.name);
                                    parent.layer.close(index);
                                });
                                break;
                            default:
                                layer.alert("未知错误", {icon: 5}, function () {
                                    var index = parent.layer.getFrameIndex(window.name);
                                    parent.layer.close(index);
                                });
                                break;
                        }
                    },
                    error: function () {
                        layer.alert("增加失败", {icon: 5}, function () {
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

