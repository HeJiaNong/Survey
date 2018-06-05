@include('admin.layouts._meta')
  
  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="{{ route('user_del_search_store') }}" method="post">
          {{ csrf_field() }}
          <input @if(isset($start)) value="{{ $start }}"  @endif class="layui-input" autocomplete="off" placeholder="开始日" name="start" id="start">
          <input @if(isset($end)) value="{{ $end }}"  @endif class="layui-input" autocomplete="off" placeholder="截止日" name="end" id="end">
          <input @if(isset($username)) value="{{ $username }}"  @endif type="text" name="username" placeholder="请输入用户名" autocomplete="off" class="layui-input">
          <button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量恢复</button>
        <span class="x-right" style="line-height:40px">共有数据：{{ $users->total() }} 条</span>
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>用户名</th>
            <th>性别</th>
            <th>手机</th>
            <th>邮箱</th>
            <th>地址</th>
            <th>加入时间</th>
            <th>状态</th>
            <th>操作</th></tr>
        </thead>

        <tbody>
        @foreach($users as $user)
          <tr>
            <td>
              <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{ $user->id }}'><i class="layui-icon">&#xe605;</i></div>
            </td>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->sex }}</td>
            <td>{{ $user->number }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->addr }}</td>
            <td>{{ $user->created_at }}</td>
            <td class="td-status">
              <span class="layui-btn layui-btn-danger layui-btn-mini">
                                已删除
                            </span>
            <td class="td-manage">
              <a title="恢复" onclick="member_recover(this,{{ $user->id }})" href="javascript:;">
                <i class="layui-icon">&#xe618;</i>
              </a>
              <a title="删除" onclick="member_del(this,{{ $user->id }})" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>

      </table>

      <div class="page">
        {{-- 分页 --}}
        {{ $users->links() }}
      </div>

    </div>
    <script>
      layui.use('laydate', function(){
        var laydate = layui.laydate;
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });
      });


      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要永久删除吗？(不可逆操作)',function(index){

              //发异步删除数据
              $.ajax({
                  async: true,    //异步
                  type: "get",
                  url: "http://www.survey.test/admin/users/del/"+id,
                  traditional: true,
                  data:id,
                  dataType: "json",
                  cache: true,
                  //服务器返回执行操作的状态
                  success: function(status) {
                      if (status === 1){
                          $(obj).parents("tr").remove();
                          layer.msg('已删除!',{icon:1,time:1000});
                      }else {
                          layer.msg('删除失败!', {icon:2, time: 1000});
                      }
                  },
                  error:function (data) {
                      layer.msg('删除失败!', {icon:2, time: 1000});
                  }
              });


              // $(obj).parents("tr").remove();
              // layer.msg('已删除!',{icon:1,time:1000});
          });
      }

      /*
      用户恢复
       */
      function member_recover(obj,id) {
          layer.confirm('确认要恢复吗？',function(index){
              //发异步恢复数据

              $.ajax({
                  async: true,    //异步
                  type: "GET",
                  url: "http://www.survey.test/admin/users/status/"+id+'/1',
                  traditional: true,
                  // data:id,
                  dataType: "json",
                  cache: true,
                  //服务器返回执行操作的状态
                  success: function(status) {
                      if (status === 1){
                          $(obj).parents("tr").remove();
                          layer.msg('已恢复!',{icon:1,time:1000});
                      }else {
                          layer.msg('操作失败!', {icon:2, time: 1000});
                      }
                  },
                  error:function (data) {
                      layer.msg('操作失败!', {icon:2, time: 1000});
                  }
              });

          });
      }

      /*
      批量恢复
       */
      function delAll (argument) {

        var data = tableCheck.getData();

        if (data.length == 0){
            // alert('666');
            layer.msg('未选择用户!', {icon:3, time: 1000});
        }else {
            layer.confirm('确认要恢复'+ data+'吗？' , function (index) {
                //捉到所有被选中的，发异步进行删除

                $.ajax({
                    async: true,    //异步
                    type: "get",
                    url: "http://www.survey.test/admin/users/status_bulk/"+data+"/1",
                    traditional: true,
                    // data:id,
                    dataType: "json",
                    cache: true,
                    //服务器返回执行操作的状态
                    success: function(status) {
                        if (status === 1){
                            layer.msg('恢复成功', {icon: 1});
                            $(".layui-form-checked").not('.header').parents('tr').remove();
                        }else {
                            layer.msg('操作失败!', {icon:2, time: 1000});
                        }
                    },
                    error:function (data) {
                        layer.msg('操作失败!', {icon:2, time: 1000});
                    }
                });
            });
        }
      }
    </script>

  </body>

</html>