@extends('admin.layouts.default')

@section('head')
    <!-- 引入 echarts.js -->
    <script src="{{ URL::asset('/static/admin/ECharts/echarts.min.js') }}"></script>
@endsection

@section('body')
    <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
    <div id="main" style="width:auto;height:500px;margin : 10px;"></div>
@endsection

@section('footer')

    @php
        //此arr为最终放入echarts的数据
        $arr = [];
        //判断是否必填
        if (!isset($topic['isRequired'])){
            $arr['null'] = 0;
        }

        //获取所有选项的value,放入数组$arr中 初始化每个选项的选中次数为0
        $arr['true'] = 0;
        $arr['false'] = 0;

        //统计每个选项有多少次选中，循环赋值增加选中的次数
        foreach ($topic['answer'] as $answer){
            if ($answer === '0'){
                $arr['false']++;
            }elseif($answer === '1'){
                $arr['true']++;
            }else{
                $arr['null']++;
            }
        }

    @endphp

    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));

        // 指定图表的配置项和数据
        var weatherIcons = {
            'Sunny': './data/asset/img/weather/sunny_128.png',
            'Cloudy': './data/asset/img/weather/cloudy_128.png',
            'Showers': './data/asset/img/weather/showers_128.png'
        };

        option = {
            title: {
                text: '@if(isset($topic['title'])) {{ $topic['title'] }} @else {{ $topic['name'] }} @endif',   //题目名称
                subtext: '{{ getTopicTitleByName($topic['type'])}}',    //通过name获取题目标题
                left: 'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{b} : {c} ({d}%)"
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            legend: {
                // orient: 'vertical',
                // top: 'middle',
                bottom: 10,
                left: 'center',
                data: [
                    //题目选项
                    'true',
                    'false',
                    {{--其他项目--}}
                    @if(!isset($topic['isRequired']))
                        'null',
                    @endif
                ]
            },
            series : [
                {
                    type: 'pie',
                    radius : '65%',
                    center: ['50%', '50%'],
                    selectedMode: 'single',
                    data:[
                        //每个选项的数据
                        @foreach($arr as $k => $v)
                            {value:{{$v}}, name: '{{ $k }}'},
                        @endforeach
                    ],
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };


        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>
@endsection