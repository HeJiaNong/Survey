@include('admin.layouts._meta')

<body>
<div class="x-body">
    <form id="editFrom" class="layui-form" action="{{ route('admin_branch_edit',$dataset->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

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

            $.ajax({
                type: 'put',
                url: targetUrl,
                cache: false,
                data: data,
                dataType: 'json',
                success: function (status) {
                    //判断传参过来的code，对其参数进行操作
                    switch (status) {
                        case 1:
                            layer.alert('修改成功', {icon: 6}, function () {

                                // 获得frame索引
                                var index = parent.layer.getFrameIndex(window.name);
                                //关闭当前frame
                                parent.layer.close(index);
                            });
                            break;
                        case 0:
                            layer.alert("修改失败", {icon: 5}, function () {
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