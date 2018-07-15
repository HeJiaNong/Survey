
@extends('admin.layouts.default')

        @section('head')
            @include('admin.layouts._editorMeta')
            <meta name="csrf-token" content="{{ csrf_token() }}">
        @endsection

        @section('body')
            <h2>编辑 {{ $word->name }} 问卷</h2>
            <div id="surveyContainer">
                <div id="editorElement"></div>
            </div>
            <script type="text/javascript">

                //本土化语言
                SurveyEditor.editorLocalization.currentLocale = "zh-cn";
                //编辑器主题 defaule bootstrap orange darkblue darkrose  stone winter winterstone
                SurveyEditor.StylesManager.applyTheme("defaule");

                var editorOptions = {};

                //生成编辑器
                var editor = new SurveyEditor.SurveyEditor("editorElement", editorOptions);

                //设置这个回调将使“保存”按钮可见
                editor.saveSurveyFunc = function () {

                    //弹出消息框
                    layer.confirm('确认要保存修改吗？', function (index) {

                        //设置URL
                        var url = '{{ route('admin_word_addStore') }}';

                        //发异步发送问卷数据
                        $.ajax({
                            // async       : false,
                            type        : "post",       //请求方式；POST
                            url         : url,          //请求链接地址
                            traditional : true,         //阻止深度序列化   默认为true
                            data        : editor.text,  //数据为题目的json格式
                            dataType    : "json",       //预期服务器返回的数据格式
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')    //发送csrf_token
                            },
                            success: function(data) {
                                console.log(data);
                                alert('控制台已输出');
                            },
                            error:function (data) {
                                alert('失败');
                            }
                        });
                    });

                }

            </script>
        @endsection






