
@extends('admin.layouts.default')

@section('title','Survey 问卷调查页')

@section('head')
    @include('admin.layouts._editorShowMeta')
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
        Survey
            .surveyLocalization
            .locales["my"] = mycustomSurveyStrings;

        //主题
        Survey
            .StylesManager
            .applyTheme("stone");

        var json = {!! $word->content !!};



        window.survey = new Survey.Model(json);

        survey
            .onComplete
            .add(function (result) {
                document
                    .querySelector('#surveyResult')
                    .innerHTML = "result: " + JSON.stringify(result.data);
            });
        //本土化
        survey.locale = 'zh-cn';

        $("#surveyElement").Survey({model: survey});
    </script>
@endsection