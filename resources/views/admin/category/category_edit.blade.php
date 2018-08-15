
@extends('admin.layouts.default')

@section('body')
    <div class="x-body layui-anim layui-anim-up">
        <form id="addForm"  class="layui-form" action="{{ route('admin_category_editStore',$category->id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>昵称
                </label>
                <div class="layui-input-inline">
                    <input value="{{ $category->name }}" type="text" id="L_username" name="name" required="required" lay-verify="nikename" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span class="x-red">*</span>统计方式</label>
                <div class="layui-input-inline">
                    <select name="formula_mode" disabled="disabled">
                        <option value="1" @if($category->formula_mode == 1) selected="selected" @endif >普通统计</option>
                        <option value="2" @if($category->formula_mode == 2) selected="selected" @endif>分数统计</option>
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux"><a title="普通统计:无任何限制。&nbsp;&nbsp;分数统计:单问卷总分100，每道题5分! 统计数据将只会统计分数,其他题型不会纳入统计!" onclick="alert('普通统计:无任何限制。&nbsp;&nbsp;分数统计:单问卷总分100，每道题5分! 统计数据将只会统计分数,其他题型不会纳入统计!');" href="javascript:;" ><i class="iconfont">&#xe6f2;</i></a></div>
            </div>

            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    描述
                </label>
                <div class="layui-input-inline">
                    <input value="{{ $category->describe }}" type="text" id="L_username" name="describe" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  class="layui-btn" lay-filter="add" lay-submit="">
                    编辑
                </button>
                <input type="submit">
            </div>
        </form>
    </div>
@endsection

@section('footer')
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
            var form = layui.form
                ,layer = layui.layer;

            //监听提交
            form.on('submit(add)', function(data){
                console.log(data);

                var targetUrl = $("#addForm").attr("action");
                var data = $("#addForm").serialize();
                //发异步，把数据提交给php
                $.ajax({
                    type: 'put',
                    url: targetUrl,
                    cache: false,
                    data: data,
                    dataType: 'json',
                    success: function (data) {
                        layer.alert(data.msg, {icon: 6},function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                        });
                    },
                    error: function (data) {
                        console.log(data);
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


