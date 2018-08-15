@extends('admin.layouts.default')

@section('head')
    <!-- 引入 echarts.js -->
    <script src="{{ URL::asset('/static/admin/ECharts/echarts.min.js') }}"></script>
@endsection

@section('body')
    <div class="x-nav">
          <span class="layui-breadcrumb">
              <a><cite>{{ $word->name }}</cite></a>
          </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <xblock>
            &nbsp;&nbsp;<span><a class="layui-btn layui-btn-primary" href="{{ route('admin_word_wordCount',$word->id) }}">XX统计</a></span>
            &nbsp;&nbsp;<span><a href="{{ route('admin_word_wordCount',$word->id) }}">GG统计</a></span>
            <span class="x-right" style="line-height:40px">共有数据：23 条</span>
        </xblock>

        <div style="border:1px red solid;width: auto;height: 500px;">
            <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
            <div id="main" style="width: 600px;height:400px;margin : 10px;border: #0C0C0C 1px solid"></div>
        </div>

    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));

        // 指定图表的配置项和数据
        var option = {
            title: {
                text: '题目分数'
            },
            tooltip: {},
            legend: {
                data:['销量']
            },
            xAxis: {
                data: ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"]
            },
            yAxis: {},
            series: [{
                name: '销量',
                type: 'bar',
                data: [5, 20, 36, 10, 10, 20]
            }]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>
@endsection