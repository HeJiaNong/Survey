
@extends('admin.layouts.default')

@section('body')
    <div class="x-body layui-anim layui-anim-up">
        @include('admin.shared._errors')
        <form id="addForm" class="layui-form layui-form-pane" action="{{ route('admin_word_editStore',$word->id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('put') }}

            <div class="layui-form-item">
                <label for="name" class="layui-form-label" style="width: auto">
                    <span class="x-red">*</span>模板名称:
                </label>
                <div class="layui-input-inline">
                    <input value="{{ $word->name }}" type="text" id="name" name="name" required="" lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>问卷类型
                </label>
                <div class="layui-input-inline">
                    <select name="category_id" >
                        @foreach($word->category->select(['id','name'])->get() as $value)
                            <option value="{{ $value->id }}" @if($word->category->id == $value->id) selected @endif >{{$value->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">
                    参与条件
                </label>

                <table  class="layui-table layui-input-block">
                    <tbody>
                    <tr style="">
                        <td style="width: 150px" >
                            <span onclick="allTouch(this,'info')">
                                <input lay-skin="primary" type="checkbox" title="参与者信息">
                            </span>
                        </td>
                        <td>
                            <div id="info" class="layui-input-block">
                                @foreach(\App\Models\Rule::select(['id','name'])->get() as $v)
                                    <input name="rule[]" @if($word->rule->contains($v->id)) checked @endif lay-skin="primary" type="checkbox" value="{{ $v->id }}" title="{{ $v->name }}">
                                @endforeach
                            </div>
                        </td>
                    </tr>

                    <tr >
                        <td style="width: 150px" >
                            参与限制
                        </td>
                        <td>
                            <div class="layui-input-block">
                                <span onclick="viewTr('gradeTr')">
                                    <input id="onOff" type="checkbox" value="1" @if($word->grade->isNotEmpty()) checked @endif lay-skin="switch" lay-text="限制|公开">
                                </span>

                            </div>
                        </td>

                    </tr>



                    <tr id="gradeTr" style="display: @if($word->grade->isNotEmpty()) @else none @endif">
                        <td>
                            <span onclick="allTouch(this,'grade')">
                                <input  lay-skin="primary" type="checkbox" title="参与者班级">
                            </span>
                        </td>
                        <td>
                            <div id="grade" class="layui-input-block" >
                                @foreach(\App\Models\Grade::select(['id','name'])->get() as $v)
                                    <input @if($word->grade->contains($v->id)) checked @endif  name="grade[]" lay-skin="primary" type="checkbox" value="{{ $v->id }}" title="{{ $v->name }}">
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
                    <textarea  id="desc" name="describe" class="layui-textarea">{{ $word->describe }}</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <button id="submitAdd" class="layui-btn" lay-filter="add" lay-submit="">
                    编辑
                </button>
                <input type="submit">
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
        function viewTr(id) {

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
                        console.log(1);
                        $(this).attr('class','layui-unselect layui-form-checkbox'); //移除选中特效
                    });
                    $('#grade').attr('class','layui-input-block');
                    input.each(function(){
                        console.log(2);
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
                    type: 'put',
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

