
@extends('admin.layouts.default')

@section('body')
    <div class="x-body layui-anim layui-anim-up">
        @include('admin.shared._errors')
        <form id="addForm" class="layui-form layui-form-pane">
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">
                    参与条件
                </label>

                <table  class="layui-table layui-input-block">
                    <tbody>
                    <tr style="">
                        <td style="width: 150px" >
                            <span onclick="allTouch(this,'info')">
                                答卷者信息
                            </span>
                        </td>
                        <td>
                            <div id="info" class="layui-input-block">
                                @foreach(\App\Models\Rule::select(['id','name'])->get() as $v)
                                    <input name="rule[]" @if($word->rule->contains($v->id)) checked @endif disabled lay-skin="primary" type="checkbox" value="{{ $v->id }}" title="{{ $v->name }}">
                                @endforeach
                            </div>
                        </td>
                    </tr>


                    <tr id="gradeTr" >
                        <td>
                            <span onclick="allTouch(this,'grade')">
                                答卷者班级
                            </span>
                        </td>
                        <td>
                            <div id="grade" class="layui-input-block" >
                                @foreach(\App\Models\Grade::select(['id','name'])->get() as $v)
                                    <input @if($word->grade->contains($v->id)) checked @endif disabled name="grade[]" lay-skin="primary" type="checkbox" value="{{ $v->id }}" title="{{ $v->name }}">
                                @endforeach
                            </div>
                        </td>
                    </tr>

                    </tbody>
                </table>

            </div>
        </form>
    </div>
    <script>

        //来自一个后台拍黄片程序猿的鬼画桃符 全选
        function allTouch(obj,id) {
            var div = $('#'+id).find('div');      //获取所有div元素
            var input = $('#'+id).find('input');    //获取所有input元素
            var isAllCheck = $(obj).find('div').attr('class');     //获取全选按钮是否选中

            if (isAllCheck === 'layui-unselect layui-form-checkbox layui-form-checked'){
                div.each(function(){
                    $(this).attr('class','layui-unselect layui-form-checkbox layui-form-checked');  //添加选中特效
                });
                input.each(function(){
                    $(this).prop('checked',true);   //添加选中实际的作用
                });
            }else if (isAllCheck === 'layui-unselect layui-form-checkbox'){
                div.each(function(){
                    $(this).attr('class','layui-unselect layui-form-checkbox'); //移除选中特效
                });
                input.each(function(){
                    $(this).prop('checked',false);  //移除选中实际的作用
                });
            }
        }

        //点击显示班级tr

    </script>
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

