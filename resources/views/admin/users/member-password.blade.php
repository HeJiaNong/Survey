@include('admin.layouts._meta')

<body>
<div class="x-body">
    <form id="passwdFrom" class="layui-form" action="{{ route('edit_passwd_store',$user->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
      <div class="layui-form-item">
          <label for="L_username" class="layui-form-label">
              昵称
          </label>
          <div class="layui-input-inline">
              <input type="text" id="L_username" name="username" disabled="" value="{{ $user->name }}" class="layui-input" >
          </div>
      </div>
      <div class="layui-form-item">
          <label for="L_repass" class="layui-form-label">
              <span class="x-red">*</span>旧密码
          </label>
          <div class="layui-input-inline">
              <input type="password" id="L_oldpass" name="oldpass" required="" lay-verify="required"
              autocomplete="off" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item">
          <label for="L_pass" class="layui-form-label">
              <span class="x-red">*</span>新密码
          </label>
          <div class="layui-input-inline">
              <input type="password" id="L_pass" name="password" required="" lay-verify="required"
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
              <input type="password" id="L_repass" name="password_confirmation" required="" lay-verify="required"
              autocomplete="off" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item">
          <label for="L_repass" class="layui-form-label">
          </label>
          <button  class="layui-btn" lay-filter="save" lay-submit="">
              增加
          </button>
            {{--<input type="submit" value="提交">--}}
      </div>



  </form>
</div>
<script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;


          //监听提交
          form.on('submit(save)', function(data){
            //发异步，把数据提交给php
              var targetUrl = $("#passwdFrom").attr("action");
              var data = $("#passwdFrom").serialize();
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
            // layer.alert("修改成功", {icon: 6},function () {
            //     // 获得frame索引
            //     var index = parent.layer.getFrameIndex(window.name);
            //     //关闭当前frame
            //     parent.layer.close(index);
            // });
            return false;
          });


        });
    </script>

</body>
</html>