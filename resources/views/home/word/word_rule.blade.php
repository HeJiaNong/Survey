
@extends('home.layouts.default')

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
                <h2>开始前，请填写必要信息</h2>

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
        Survey.StylesManager.applyTheme("stone");   //主题色

        // var json = {
        //     "locale": "zh-cn",
        //     "completedHtml": {
        //         "default": "<h4>You have answered correctly <b>{correctedAnswers}</b> questions from <b>{questionCount}</b>.</h4>",
        //         "zh-cn": "<h4>You have answered correctly <b>0</b> questions from <b>5</b>.</h4>"
        //     },
        //     "pages": [
        //         {
        //             "name": "用户名",
        //             "elements": [
        //                 {
        //                     "type": "text",
        //                     "name": "name",
        //                     "title": {
        //                         "zh-cn": "用户名"
        //                     },
        //                     "isRequired": true,
        //                     "placeHolder": {
        //                         "zh-cn": "your name"
        //                     }
        //                 }
        //             ]
        //         },
        //         {
        //             "name": "性别",
        //             "elements": [
        //                 {
        //                     "type": "radiogroup",
        //                     "name": "sex",
        //                     "title": {
        //                         "zh-cn": "性别"
        //                     },
        //                     "isRequired": true,
        //                     "choices": [
        //                         "男",
        //                         "女"
        //                     ]
        //                 }
        //             ]
        //         },
        //         {
        //             "name": "邮箱",
        //             "elements": [
        //                 {
        //                     "type": "text",
        //                     "name": "email",
        //                     "title": {
        //                         "zh-cn": "邮箱"
        //                     },
        //                     "isRequired": true,
        //                     "inputType": "email",
        //                     "placeHolder": {
        //                         "zh-cn": "your@email.com"
        //                     }
        //                 }
        //             ]
        //         },
        //         {
        //             "name": "电话号码",
        //             "elements": [
        //                 {
        //                     "type": "text",
        //                     "name": "number",
        //                     "title": {
        //                         "zh-cn": "电话号码"
        //                     },
        //                     "isRequired": true,
        //                     "inputType": "number",
        //                     "placeHolder": {
        //                         "zh-cn": "your number"
        //                     }
        //                 }
        //             ],
        //             "maxTimeToFinish": 15
        //         },
        //         {
        //             "name": "QQ号码",
        //             "elements": [
        //                 {
        //                     "type": "text",
        //                     "name": "qq_number",
        //                     "title": {
        //                         "zh-cn": "QQ号码"
        //                     },
        //                     "isRequired": true,
        //                     "inputType": "number",
        //                     "placeHolder": {
        //                         "zh-cn": "马化腾给的"
        //                     }
        //                 }
        //             ]
        //         },
        //         {
        //             "name": "选择班级",
        //             "elements": [
        //                 {
        //                     "type": "dropdown",
        //                     "name": "grade",
        //                     "title": {
        //                         "zh-cn": "选择班级"
        //                     },
        //                     "isRequired": true,
        //                     "choices": [
        //                         "xxx班",
        //                         "xxx班",
        //                         "xxx班"
        //                     ],
        //                     "optionsCaption": {
        //                         "zh-cn": "选择您的班级"
        //                     }
        //                 }
        //             ]
        //         },
        //         {
        //             "name": "最后一页",
        //             "elements": [
        //                 {
        //                     "type": "html",
        //                     "name": "start",
        //                     "html": {
        //                         "default": "你要开始做历史测验了。你每一页有10秒的时间和25秒的时间来做三个问题的调查。当你准备好时，请点击“开始测试”按钮。",
        //                         "zh-cn": "您已完成基本信息填写，点击开始即可进入问卷调查，谢谢!"
        //                     }
        //                 }
        //             ]
        //         }
        //     ],
        //     "sendResultOnPageNext": true,
        //     "showPageNumbers": true,
        //     "showProgressBar": "top",
        //     "goNextPageAutomatic": true,
        //     "startSurveyText": "开始",
        //     "pagePrevText": "上一页",
        //     "pageNextText": "下一页",
        //     "completeText": {
        //         "default": "完成",
        //         "zh-cn": "开始！"
        //     }
        // };

        //问卷内容
        var json = {
            "locale": "zh-cn",
            "completedHtml": {
                "default": "<h4>You have answered correctly <b>{correctedAnswers}</b> questions from <b>{questionCount}</b>.</h4>",
                "zh-cn": "<h4>You have answered correctly <b>0</b> questions from <b>5</b>.</h4>"
            },
            "pages": [
                @if($word->rule->isNotEmpty())
                    @foreach($word->rule as $value)
                        {!! $value->topic_json !!},
                    @endforeach
                @endif

                @if($word->grade->isNotEmpty())
                {
                    "name": "选择班级",
                    "elements": [
                        {
                            "type": "dropdown",
                            "name": "grade",
                            "title": {
                                "zh-cn": "选择班级"
                            },
                            "isRequired": true,
                            "choices": [
                                @foreach($word->grade as $value)
                                    "{{$value->name}}",
                                @endforeach

                            ],
                            "optionsCaption": {
                                "zh-cn": "选择您的班级"
                            }
                        }
                    ]
                },
                @endif

                {
                    "name": "最后一页",
                    "elements": [
                        {
                            "type": "html",
                            "name": "start",
                            "html": {
                                "default": "你要开始做历史测验了。你每一页有10秒的时间和25秒的时间来做三个问题的调查。当你准备好时，请点击“开始测试”按钮。",
                                "zh-cn": "您已完成基本信息填写，点击开始即可进入问卷调查，谢谢!"
                            }
                        }
                    ]
                }
            ],
            "sendResultOnPageNext": true,
            "showPageNumbers": true,
            "showProgressBar": "top",
            "goNextPageAutomatic": true,
            "startSurveyText": "开始",
            "pagePrevText": "上一页",
            "pageNextText": "下一页",
            "completeText": {
                "default": "完成",
                "zh-cn": "开始！"
            }
        };

        window.survey = new Survey.Model(json);

        survey.onComplete.add(function (result) {
            //跳转链接
            window.location.href="{{ route('home_wordShow',$word->id) }}"+"/"+JSON.stringify(result.data);
            {{--location.href({{ route('home_wordShow',$word->id) }});--}}
            // console.log(JSON.stringify(result.data));
            // alert(JSON.stringify(result.data));
            //     document.querySelector('#surveyResult').innerHTML = "result: " + JSON.stringify(result.data);
            });

        $("#surveyElement").Survey({model: survey});
    </script>
@endsection