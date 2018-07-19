
@extends('admin.layouts.default')

@section('body')
    <div class="x-body">
        <form action="" method="post" class="layui-form layui-form-pane">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label" style="width: auto">
                    <span class="x-red">*</span>问卷类型名:
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="name" name="name" required="" lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">
                    请选择必要信息(未选表示无条件)
                </label>
                <table  class="layui-table layui-input-block">
                    <tbody>
                    <tr>
                        <td>
                            <input type="checkbox" name="like1[write]" lay-skin="primary" title="用户信息">
                        </td>
                        <td>
                            <div class="layui-input-block">
                                <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="电子邮箱" >
                                <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户姓名">
                                <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="电话号码">
                                <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="QQ号码">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>

                            <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="班级信息">
                        </td>
                        <td>
                            <div class="layui-input-block">
                                <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="班级名称">
                                <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="老师名称">
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="layui-form-item layui-form-text">
                <label for="desc" class="layui-form-label">
                    描述
                </label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" id="desc" name="desc" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="add">增加</button>
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

            //自定义验证规则
            form.verify({
                nikename: function(value){
                    if(value.length < 5){
                        return '昵称至少得5个字符啊';
                    }
                }
                ,pass: [/(.+){6,12}$/, '密码必须6到12位']
                ,repass: function(value){
                    if($('#L_pass').val()!=$('#L_repass').val()){
                        return '两次密码不一致';
                    }
                }
            });

            //监听提交
            form.on('submit(add)', function(data){
                console.log(data);
                //发异步，把数据提交给php
                layer.alert("增加成功", {icon: 6},function () {
                    // 获得frame索引
                    var index = parent.layer.getFrameIndex(window.name);
                    //关闭当前frame
                    parent.layer.close(index);
                });
                return false;
            });


        });
    </script>
@endsection


