
@extends('admin.layouts.default')

        @section('head')
            @include('survey.builder')
            <meta name="csrf-token" content="{{ csrf_token() }}">
        @endsection

        @section('body')
            {{--<h2>编辑 {{ $word->name }} 问卷</h2>--}}
            <div id="surveyContainer">
                <div id="editorElement"></div>
            </div>
        @endsection

        @section('footer')
            <script type="text/javascript">
                //本土化语言
                SurveyEditor.editorLocalization.currentLocale = "zh-cn";

                //参数设定
                var editorOptions = {
                    //允许显示的默认工具箱部件
                    questionTypes: [
                        "text",             //文本框
                        "checkbox",         //多项选择
                        "radiogroup",       //单项选择
                        "dropdown",         //下拉框
                        "comment",          //多行文本框
                        "rating",           //评分
                        "imagepicker",      //图片选择器
                        "boolean",          //布尔选择
                        "html",             //Html代码
                        "expression",       //表达式
                        "file",             //文件上传
                        "matrix",           //矩阵(单选题)
                        "matrixdropdown",   //矩阵(多选题)
                        "matrixdynamic",    //矩阵(动态问题)
                        "multipletext",     //文本框组
                        "panel",            //面板
                        "paneldynamic",     //面板(动态)
                    ]
                };

                //生成编辑器
                var editor = new SurveyEditor.SurveyEditor("editorElement", editorOptions);

                //允许用户自定义工具箱的个数
                editor.toolbox.copiedItemMaxCount = 5;

                //工具箱分类
                editor.toolbox.changeCategories([
                    { name: "text",             category: "常用" },
                    { name: "checkbox",         category: "常用" },
                    { name: "radiogroup",       category: "常用" },
                    { name: "dropdown",         category: "常用" },
                    { name: "comment",          category: "常用" },
                    { name: "rating",           category: "常用" },
                    { name: "imagepicker",      category: "常用" },
                    { name: "boolean",          category: "常用" },
                    { name: "html",             category: "常用" },
                    { name: "expression",       category: "常用" },
                    { name: "file",             category: "常用" },
                    { name: "multipletext",     category: "常用" },
                    { name: "emotionsratings",  category: "常用" },

                    { name: "matrix",           category: "矩阵" },
                    { name: "matrixdropdown",   category: "矩阵" },
                    { name: "matrixdynamic",    category: "矩阵" },

                    { name: "panel",            category: "面板" },
                    { name: "paneldynamic",     category: "面板" },
                ]);

                //打印所有工具箱部件
                // console.log(editor.toolbox.items);

                //移除工具箱部件
                editor.toolbox.removeItem('microphone');
                editor.toolbox.removeItem('emotionsratings');

                //添加工具箱部件
                editor.toolbox.addItem({
                    "category" : "常用",
                    "name" : "emotionsratings",
                    "isCopied" : false,
                    "iconName" : "icon-emotionsratings",
                    "title" : "情绪评级",
                    "json" : {
                        "type" : "emotionsratings",
                        "choices": [1,2,3,4,5]
                    }
                });

                //接收后台题目内容
                var json = @json($word->content);

                //注入题目
                editor.text = json;

                //设置这个回调将使“保存”按钮可见
                editor.saveSurveyFunc = function () {
                    var answer = editor.text;
                    var msg = '';

                    //判断是否修改了问卷
                    if (json === answer){
                        msg = '确认保存吗？';
                    }else {
                        msg = '您已修改问卷，这将会清空统计数据，确认？';
                    }

                    //弹出消息框
                    layer.confirm(msg, function (index) {
                        //设置URL
                        var url = '{{ route('admin_word_saveEditor',$word->id) }}';

                        //发异步发送问卷数据
                        $.ajax({
                            // async       : false,
                            type        : "post",       //请求方式；POST
                            url         : url,          //请求链接地址
                            traditional : true,         //阻止深度序列化   默认为true
                            data        : {'content':editor.text},  //数据为题目的json格式
                            dataType    : "json",       //预期服务器返回的数据格式
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')    //发送csrf_token
                            },
                            success: function(data) {
                                layer.msg(data.msg, {icon: 1, time: 1000});
                                setTimeout(function () {
                                    // 获得frame索引
                                    var index = parent.layer.getFrameIndex(window.name);
                                    //关闭当前frame
                                    parent.layer.close(index);
                                }, 1000);
                            },
                            error:function (data) {
                                layer.msg('操作失败', {icon: 1, time: 1000});
                                setTimeout(function () {// 获得frame索引
                                    var index = parent.layer.getFrameIndex(window.name);
                                    //关闭当前frame
                                    parent.layer.close(index);
                                }, 1000);
                            }
                        });
                    });

                }
            </script>

        @endsection






