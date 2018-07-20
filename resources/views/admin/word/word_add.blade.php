
@extends('admin.layouts.default')

@section('body')
    <div class="x-body layui-anim layui-anim-up">
        <form id="addForm" class="layui-form layui-form-pane" action="{{ route('admin_word_addStore') }}" method="post">
            {{ csrf_field() }}
            {{--<div class="layui-form-item">--}}
                {{--<label for="L_username" class="layui-form-label">--}}
                    {{--<span class="x-red">*</span>问卷昵称--}}
                {{--</label>--}}
                {{--<div class="layui-input-inline">--}}
                    {{--<input type="text" id="L_username" name="name" required="" lay-verify="nikename"--}}
                           {{--autocomplete="off" class="layui-input">--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="layui-form-item">--}}
                {{--<label for="L_username" class="layui-form-label">--}}
                    {{--<span class="x-red">*</span>问卷类型--}}
                {{--</label>--}}
                {{--<div class="layui-input-inline">--}}
                    {{--<select name="category_id" >--}}
                        {{--@foreach($rows as $row)--}}
                            {{--@foreach($row->category->select(['id','name'])->get() as $value)--}}
                                {{--<option value="{{ $value->id }}" >{{$value->name }}</option>--}}
                            {{--@endforeach--}}
                            {{--@break--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="layui-form-item">
                <label for="name" class="layui-form-label" style="width: auto">
                    <span class="x-red">*</span>新建模板名称:
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="name" name="name" required="" lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">
                    参与条件
                </label>

                <table  class="layui-table layui-input-block">
                    <tbody>
                    <tr>
                        <td style="width: 150px" >
                            <span onclick="allTouch(this,'info')">
                                <input lay-skin="primary" type="checkbox" title="答卷者信息">
                            </span>
                        </td>
                        <td>
                            <div id="info" class="layui-input-block">
                                <input name="rule[info][]" lay-skin="primary" type="checkbox" value="1" title="性别" >
                                <input name="rule[info][]" lay-skin="primary" type="checkbox" value="2" title="姓名">
                                <input name="rule[info][]" lay-skin="primary" type="checkbox" value="3" title="电子邮箱" >
                                <input name="rule[info][]" lay-skin="primary" type="checkbox" value="4" title="电话号码">
                                <input name="rule[info][]" lay-skin="primary" type="checkbox" value="5" title="QQ号码">
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            是否限制班级
                            {{--<label class="layui-form-label">是否限制班级</label>--}}
                        </td>
                        <td>
                            {{--<div class="layui-form-item">--}}

                            <div class="layui-input-block">
                                <span onclick="viewGrade('gradeTr')">
                                    <input id="onOff" type="checkbox" value="1" name="close" lay-skin="switch" lay-text="限制|公开">
                                </span>

                            </div>
                            {{--</div>--}}
                        </td>

                    </tr>


                    <tr id="gradeTr" style="display: none">
                        <td>
                            <span onclick="allTouch(this,'grade')">
                                <input  lay-skin="primary" type="checkbox" title="全部允许参加">
                            </span>
                        </td>
                        <td>
                            <div id="grade" class="layui-input-block" >
                                @foreach($dataset as $data)
                                    @foreach($data->grade()->get() as $value)
                                        @foreach($value->select(['id','name'])->get() as $v)
                                                <input name="rule[teacher][]" lay-skin="primary" type="checkbox" value="{{ $v->id }}" title="{{ $v->name }}">
                                        @endforeach
                                        @break
                                    @endforeach
                                    @break
                                @endforeach
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



            {{--<div class="layui-form-item">--}}
                {{--<label for="L_username" class="layui-form-label">--}}
                    {{--<span class="x-red">*</span>选择班级--}}
                {{--</label>--}}
                {{--<div class="layui-input-inline">--}}
                    {{--<select name="grade_id" >--}}
                        {{--@foreach($rows as $row)--}}
                            {{--@foreach($row->grade()->get() as $value)--}}
                                {{--@foreach($value->select(['id','name'])->get() as $v)--}}
                                    {{--<option value="{{ $v->id }}" >{{$v->name }}</option>--}}
                                {{--@endforeach--}}
                                {{--@break--}}
                            {{--@endforeach--}}
                            {{--@break--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                {{--</div>--}}
            {{--</div>--}}



            <div class="layui-form-item">
                {{--<label for="L_repass" class="layui-form-label">--}}
                {{--</label>--}}
                <button id="submitAdd" class="layui-btn" lay-filter="add" lay-submit="">
                    添加
                </button>
                <input type="submit">
            </div>
        </form>
    </div>
    <script>
        //来自一个后台拍黄片程序猿的鬼画桃符
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
        function viewGrade(id) {
            var style = $('#'+id);
            if (style.css('display') === 'none'){
                style.css('display','') //显示tr
            }else {
                style.css('display','none'); //隐藏tr
                var input = $('#grade').find('input');    //获取所有input元素
                var div = $('#grade').find('div');      //获取所有div元素
                $('#gradeTr').find('td').find('div').attr('class','layui-unselect layui-form-checkbox');    //让班级全选按钮变成未选中
                if($('#onOff').parents('span').find('div').attr('class') === 'layui-unselect layui-form-switch'){
                    div.each(function(){
                        $(this).attr('class','layui-unselect layui-form-checkbox'); //移除选中特效
                    });
                    $('#grade').attr('class','layui-input-block');
                    input.each(function(){
                        $(this).prop('checked',false);  //移除选中实际的作用
                    });
                }
            }
        }

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

