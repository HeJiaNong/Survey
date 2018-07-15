
@extends('admin.layouts.default')

@section('body')
    <div class="x-body layui-anim layui-anim-up">
        <form id="addForm" class="layui-form" action="{{ route('admin_word_addStore') }}" method="post">
            {{ csrf_field() }}
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>问卷昵称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="name" required="" lay-verify="nikename"
                           autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>问卷类型
                </label>
                <div class="layui-input-inline">
                    <select name="category_id" >
                        @foreach($rows as $row)
                            @foreach($row->category->select(['id','name'])->get() as $value)
                                <option value="{{ $value->id }}" >{{$value->name }}</option>
                            @endforeach
                            @break
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>描述
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="describe" required="" lay-verify="nikename"
                           autocomplete="off" class="layui-input">
                </div>
            </div>



            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>选择班级
                </label>
                <div class="layui-input-inline">
                    <select name="grade_id" >
                        @foreach($rows as $row)
                            @foreach($row->grade()->get() as $value)
                                @foreach($value->select(['id','name'])->get() as $v)
                                    <option value="{{ $v->id }}" >{{$v->name }}</option>
                                @endforeach
                                @break
                            @endforeach
                            @break
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button id="submitAdd" class="layui-btn" lay-filter="add" lay-submit="">
                    添加
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
                    success: function (data) {
                        layer.alert(data.msg, {icon: 6}, function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                        });
                    },
                    error: function (data) {
                        var msg = '';

                        //将错误信息遍历出来,并且赋值到 msg
                        for (var p in data.responseJSON.errors) { //遍历json对象的每个key/value对,p为key
                            msg += p + " " + data.responseJSON.errors[p] + '<br />';
                        }
                        //弹出消息框
                        layer.msg(msg, {icon: 5, time: 2000});
                    }
                });
                return false;
            });
        });
    </script>
@endsection

