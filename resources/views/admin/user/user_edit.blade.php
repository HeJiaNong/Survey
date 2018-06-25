@include('admin.layouts._meta')

<body>
<div class="x-body">
    <form id="editFrom" class="layui-form" action="{{ route('admin_user_edit_put',$dataset->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>邮箱
            </label>
            <div class="layui-input-inline">
                <input type="text" id="L_email" name="email" required="" lay-verify="email"
                       autocomplete="off" class="layui-input" value="{{ $dataset->email }}">
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
                <input type="text" id="L_username" name="name" required="" lay-verify="nikename"
                       autocomplete="off" class="layui-input" value="{{ $dataset->name }}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="x-red">*</span>性别</label>
            <div class="layui-input-block">
                <input type="radio" name="sex" lay-skin="primary" title="男" value="男" @if($dataset->sex == '男') checked @endif >
                <input type="radio" name="sex" lay-skin="primary" title="女" value="女" @if($dataset->sex == '女') checked @endif>
                <input type="radio" name="sex" lay-skin="primary" title="保密" value="保密" @if($dataset->sex == '保密') checked @endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                <span class="x-red">*</span>手机号
            </label>
            <div class="layui-input-inline">
                <input type="text" id="L_number" name="number" required="" lay-verify="number"
                       autocomplete="off" class="layui-input" value="{{ $dataset->number }}">
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
                <input type="text" id="L_addr" name="addr" required=""
                       autocomplete="off" class="layui-input" value="{{ $dataset->addr }}">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button class="layui-btn" lay-filter="add" lay-submit="">
                修改
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
        });

        //监听提交
        form.on('submit(add)', function (data) {
            // console.log(data);
            //发异步，把数据提交给php
            var targetUrl = $("#editFrom").attr("action");
            var data = $("#editFrom").serialize();

            console.log(data);

            $.ajax({
                type: 'put',
                url: targetUrl,
                cache: false,
                data: data,
                dataType: 'json',
                success: function (status) {
                    //判断传参过来的code，对其参数进行操作
                    console.log(status);
                    if (status){
                        layer.alert('修改成功', {icon: 6}, function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                        });
                    }else{
                        layer.alert("修改失败", {icon: 5}, function () {
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        });
                    }
                },
                error: function () {
                    layer.alert("修改失败", {icon: 5}, function () {
                        // 获得frame索引
                        var index = parent.layer.getFrameIndex(window.name);
                        //关闭当前frame
                        parent.layer.close(index);
                    });
                }
            });
            return false;
            // layer.alert("增加成功", {icon: 6}, function () {
            //     // 获得frame索引
            //     var index = parent.layer.getFrameIndex(window.name);
            //     //关闭当前frame
            //     parent.layer.close(index);
            // });
        });
    });
</script>

</body>

</html>