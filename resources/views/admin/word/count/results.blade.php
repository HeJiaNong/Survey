@extends('admin.layouts.default')

@section('head')
    {{-- 引入 echarts.js --}}
    <script src="{{ URL::asset('/static/admin/ECharts/echarts.min.js') }}"></script>
@endsection

@section('body')

    {{-- 生成统计图 --}}
    <div id="main" style="width: auto;height:600px;margin: 50px "></div>

@endsection

@section('footer')
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));
        var url = '{{ route('admin_word_count_resultsJson') }}';
        //开启加载动画
        myChart.showLoading();

        $.ajax({
            type: "get",
            url: url,
            dataType: "json",
            //服务器返回执行操作的状态
            success: function (data) {
                console.log(data);

                //隐藏加载动画
                myChart.hideLoading();

                var option = {
                    title: {
                        text: '各问卷交卷数量周报'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: data.data
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    toolbox: {
                        feature: {
                            saveAsImage: {}
                        }
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: ['周一','周二','周三','周四','周五','周六','周日']
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: data.series
                };

                console.log(option);

                myChart.setOption(option);
            },
            error: function (data) {
                alert('错误');
            }
        });

        //请求数据接口

        // 指定图表的配置项和数据
        // var option = {
        //     title: {
        //         text: '各问卷交卷数量周报'
        //     },
        //     tooltip: {
        //         trigger: 'axis'
        //     },
        //     legend: {
        //         data:['邮件营销','联盟广告','视频广告','直接访问','搜索引擎']
        //     },
        //     grid: {
        //         left: '3%',
        //         right: '4%',
        //         bottom: '3%',
        //         containLabel: true
        //     },
        //     toolbox: {
        //         feature: {
        //             saveAsImage: {}
        //         }
        //     },
        //     xAxis: {
        //         type: 'category',
        //         boundaryGap: false,
        //         data: ['周一','周二','周三','周四','周五','周六','周日']
        //     },
        //     yAxis: {
        //         type: 'value'
        //     },
        //     series: [
        //         {
        //             name:'邮件营销',
        //             type:'line',
        //             stack: '总量',
        //             data:[120, 132, 101, 134, 90, 230, 210]
        //         },
        //         {
        //             name:'联盟广告',
        //             type:'line',
        //             stack: '总量',
        //             data:[220, 182, 191, 234, 290, 330, 310]
        //         },
        //         {
        //             name:'视频广告',
        //             type:'line',
        //             stack: '总量',
        //             data:[150, 232, 201, 154, 190, 330, 410]
        //         },
        //         {
        //             name:'直接访问',
        //             type:'line',
        //             stack: '总量',
        //             data:[320, 332, 301, 334, 390, 330, 320]
        //         },
        //         {
        //             name:'搜索引擎',
        //             type:'line',
        //             stack: '总量',
        //             data:[820, 932, 901, 934, 1290, 1330, 1320]
        //         }
        //     ]
        // };



        // 使用刚指定的配置项和数据显示图表。
        // myChart.setOption(option);
    </script>
@endsection
