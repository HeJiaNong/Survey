<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ URL::asset('/static/admin/lib/layui/layui.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ URL::asset('/static/admin/js/xadmin.js') }}"></script>
    @include('survey.builder')
    <meta name="csrf-token" content="{{ csrf_token() }}">
<body>

    {{--<h2>编辑 {{ $word->name }} 问卷</h2>--}}
    <div id="surveyContainer">
        <div id="editorElement"></div>
    </div>
</body>
    <script type="text/javascript">
    /* 本土化语言 */
    SurveyEditor.editorLocalization.currentLocale = "zh-cn";

    // 获取当前语言环境字符串对象
    var curStrings = SurveyEditor.editorLocalization.getLocale();
    //如果要更改任何Survey Editor元素的文本，则可以使用以下代码：
    curStrings.ed.jsonEditor            = "Json编辑器";
    curStrings.qt.imagepicker           = "图片选择器";
    curStrings.qt.emotionsratings       = "情绪评级";
    curStrings.ed.surveySettings        = "情绪评级";
    curStrings.p.visible                = "是否可见?";
    curStrings.p.requiredErrorText      = "需要错误文本";
    curStrings.p.otherErrorText         = "需要错误文本";
    curStrings.p.cookieName             = "Cookie名称（在本地禁用运行调查两次）";
    curStrings.p.sendResultOnPageNext   = "在接下来的页面上发送调查结果";
    curStrings.p.storeOthersAsComment   = "在不同的字段中存储“其他人”的值";
    curStrings.p.requiredText           = "这个问题需要符号(s)";
    curStrings.p.choicesVisibleIf       = "选择可见条件";
    curStrings.p.defaultValue           = "默认值";
    curStrings.p.hasComment             = "有评论";
    curStrings.p.titleLocation          = "标题位置";
    curStrings.p.validators             = "验证器";
    curStrings.p.valueName              = "值";
    curStrings.p.visibleIf              = "可见条件";
    curStrings.p.width                  = "宽度";
    curStrings.p.checkErrorsMode        = "检查错误模式";
    curStrings.p.completedBeforeHtml    = "完成后HTML";
    curStrings.p.completedHtml          = "完成后HTML";
    curStrings.p.loadingHtml            = "加载中HTML";
    curStrings.p.maxOthersLength        = "最大其他长度";
    curStrings.p.maxTextLength          = "最大文本长度";
    curStrings.p.triggers               = "触发器";
    curStrings.pe.visible               = "是否可见?";
    curStrings.pe.url                   = "URL";
    curStrings.pe.path                  =  "路径";
    curStrings.pe.valueName             = "值";
    curStrings.pe.titleName             = "显示名称";
    curStrings.pe.cookieName            = "Cookie名称（在本地禁用运行调查两次）";
    curStrings.pe.sendResultOnPageNext  = "在接下来的页面上发送调查结果";
    curStrings.pe.storeOthersAsComment  = "在不同的字段中存储“其他人”的值";
    curStrings.pe.questionsOrder        = "页面上的元素顺序";
    curStrings.pe.tabs = {
        general                         : "通用项",
        navigation                      : "导航",
        question                        : "问题",
        completedHtml                   : "完成后的Html",
        loadingHtml                     : "加载中的Html",
        timer                           : "问卷计时器",
        trigger                         : "触发器",
        fileOptions                     : "选项",
        html                            : "HTML 编辑器",
        columns                         : "设置列",
        rows                            : "设置行",
        choices                         : "设置选项",
        visibleIf                       : "设置可见条件",
        enableIf                        : "设置有效条件",
        rateValues                      : "设置评分值",
        choicesByUrl                    : "通过 URL 导入选项",
        matrixChoices                   : "默认选项",
        multipleTextItems               : "文本输入",
        validators                      : "校验规则"
    };

    //参数设定
    var editorOptions = {
        //使用此选项可定义要在工具箱上查看的问题类型。
        questionTypes: [
            "radiogroup",       //单项选择
            "rating",           //评分
            "text",             //文本框
            "dropdown",         //下拉框
            "comment",          //多行文本框
            "checkbox",         //多项选择
            "imagepicker",      //图片选择器
            "boolean",          //布尔选择
            "html",             //Html代码
            "expression",       //表达式
            // "file",             //文件上传
            "multipletext",     //文本框组

            // "matrix",           //矩阵(单选题)
            // "matrixdropdown",   //矩阵(多选题)
            // "matrixdynamic",    //矩阵(动态问题)
            //
            // "panel",            //面板
            // "paneldynamic",     //面板(动态)

        ],
        //将此选项设置为true以显示Survey Embedded选项卡。默认情况下隐藏此选项卡。它显示了如何将调查集成到另一个网页。
        showEmbededSurveyTabValue       : false,
        //将此选项设置为false可隐藏JSON选项卡。
        showJSONEditorTabValue          : false,
        //将此选项设置为false可隐藏“测量测试”选项卡。
        showTestSurveyTabValue          : false,
        //将此选项设置为false可隐藏右侧的属性网格。它默认显示。
        showPropertyGrid                : false,
        //将其设置为true以显示工具栏中的状态（保存/保存）。
        showState                       : true,
        //如果要在元素弹出编辑器中使用制表符而不是accordion，则将此属性设置为true。它会将手风琴改变为标签控制。
        useTabsInElementEditor          : true,
        //如果您要允许用户仅创建一个页面调查，请将此属性设置为false。它将隐藏页面工具箱。
        showPagesToolbox                : true,
    };

    //生成编辑器
    var editor = new SurveyEditor.SurveyEditor("editorElement", editorOptions);

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
    console.log(editor.toolbox.items);

    //移除工具箱部件
    editor.toolbox.removeItem('microphone');    //移除录音

    //单选框
    editor.toolbox.getItemByName('radiogroup').json = {
        'type' : 'radiogroup',
        choices: [1,2,3,4,5],
    };
    //评级
    editor.toolbox.getItemByName('rating').json = {
        'type' : 'rating',
        rateValues : [1,2,3,4,5]
    };
    //下拉框
    editor.toolbox.getItemByName('dropdown').json = {
        'type' : 'dropdown',
        choices : [1,2,3,4,5]
    };

    //接收后台题目内容
    var json = @json($word->content);

    //注入题目
    editor.text = json;

    //保存按钮与保存逻辑
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
                    layer.msg('操作失败', {icon: 2, time: 1000});
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
</html>