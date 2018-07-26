
@extends('home.layouts.default')

@section('title','Survey 问卷调查页')

@section('head')
    @include('admin.layouts._editorShowMeta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('body')
    <div id="test" class="sv_main sv_frame sv_default_css">
        <div class="sv_custom_header"></div>
        <div class="sv_container">
            <div class="sv_header">
                <h3>欢迎参与 "{{ $word->name }}" 问卷调查</h3>
                <p>{{ $word->describe }}</p>
            </div>
        </div>
        <div class="sv_body">
            <div id="surveyElement"></div>
            <div id="surveyResult"></div>
        </div>
    </div>


@endsection

@section('footer')
    <script>
        //页面自适应全屏高度
        autodivheight();
        function autodivheight(){ //函数：获取尺寸
            //获取浏览器窗口高度
            var winHeight=0;
            if (window.innerHeight)
                winHeight = window.innerHeight;
            else if ((document.body) && (document.body.clientHeight))
                winHeight = document.body.clientHeight;
            //通过深入Document内部对body进行检测，获取浏览器窗口高度
            if (document.documentElement && document.documentElement.clientHeight)
                winHeight = document.documentElement.clientHeight;
            //DIV高度为浏览器窗口的高度
            document.getElementById("test").style.height= winHeight +"px";

        }
        window.onresize=autodivheight; //浏览器窗口发生变化时同时变化DIV高度
    </script>
    <script>
        //Example of adding new locale into the library.
        var mycustomSurveyStrings = {
            pagePrevText: "My Page Prev",
            pageNextText: "My Page Next",
            completeText: "OK - Press to Complete"
        };

        Survey.surveyLocalization.locales["my"] = mycustomSurveyStrings;

        //主题
        Survey.StylesManager.applyTheme("stone");

        var json = {!! $word->content !!};

        //生成问卷
        window.survey = new Survey.Model(json);

        //提交问卷
        survey.onComplete.add(function (result) {
            // console.log(JSON.stringify(result.data));
            //设置URL
            var url = '{{ route('home_wordSend',$word->id) }}';
            var rules = '{!! request()->route('rules') !!}';


            //发异步发送问卷数据 request()->route('rules')
            $.ajax({
                // async       : false,
                type        : "post",       //请求方式；POST
                url         : url,          //请求链接地址
                traditional : true,         //阻止深度序列化   默认为true
                data        : {
                    'rule' : rules,
                    'answer':JSON.stringify(result.data),
                },  //数据为题目的json格式
                dataType    : "json",       //预期服务器返回的数据格式
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')    //发送csrf_token
                },
                success: function(data) {
                    console.log(data);
                    alert('ok');
                    // console.log(data.msg);
                },
                error:function (data) {
                    alert('error');
                    console.log(data);
                    layer.msg('操作失败', {icon: 1, time: 1000});
                }
            });

            {{--window.location.href="{{ route('wordSend',$word->id) }}"+"/"+JSON.stringify(result.data);--}}
                // document.querySelector('#surveyResult').innerHTML = "result: " + JSON.stringify(result.data);
            });
        //本土化
        survey.locale = 'zh-cn';

        $("#surveyElement").Survey({model: survey});
    </script>
@endsection