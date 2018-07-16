
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

        @endsection

        @section('footer')
            <script type="text/javascript">

                //本土化语言
                SurveyEditor.editorLocalization.currentLocale = "zh-cn";
                //编辑器主题 defaule bootstrap orange darkblue darkrose  stone winter winterstone
                SurveyEditor.StylesManager.applyTheme("defaule");

                var editorOptions = {};

                //生成编辑器
                var editor = new SurveyEditor.SurveyEditor("editorElement", editorOptions);

                var json = @json($word->content);

                editor.text = json;

                //设置这个回调将使“保存”按钮可见
                editor.saveSurveyFunc = function () {

                    //弹出消息框
                    layer.confirm('确认要保存修改吗？', function (index) {

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

            {{--<script>--}}
                {{--var surveyName = "";--}}
                {{--function setSurveyName(name) {--}}
                    {{--var $titleTitle = jQuery("#sjs_editor_title_show");--}}
                    {{--$titleTitle.find("span:first-child").text(name);--}}
                {{--}--}}
                {{--function startEdit() {--}}
                    {{--var $titleEditor = jQuery("#sjs_editor_title_edit");--}}
                    {{--var $titleTitle = jQuery("#sjs_editor_title_show");--}}
                    {{--$titleTitle.hide();--}}
                    {{--$titleEditor.show();--}}
                    {{--$titleEditor.find("input")[0].value = surveyName;--}}
                    {{--$titleEditor.find("input").focus();--}}
                {{--}--}}
                {{--function cancelEdit() {--}}
                    {{--var $titleEditor = jQuery("#sjs_editor_title_edit");--}}
                    {{--var $titleTitle = jQuery("#sjs_editor_title_show");--}}
                    {{--$titleEditor.hide();--}}
                    {{--$titleTitle.show();--}}
                {{--}--}}
                {{--function postEdit() {--}}
                    {{--cancelEdit();--}}
                    {{--var oldName = surveyName;--}}
                    {{--var $titleEditor = jQuery("#sjs_editor_title_edit");--}}
                    {{--surveyName = $titleEditor.find("input")[0].value;--}}
                    {{--setSurveyName(surveyName);--}}
                    {{--jQuery--}}
                        {{--.get("/changeName?id=" + surveyId + "&name=" + surveyName, function(data) {--}}
                            {{--surveyId = data.Id;--}}
                        {{--})--}}
                        {{--.fail(function(error) {--}}
                            {{--surveyName = oldName;--}}
                            {{--setSurveyName(surveyName);--}}
                            {{--alert(JSON.stringify(error));--}}
                        {{--});--}}
                {{--}--}}

                {{--function getParams() {--}}
                    {{--var url = window.location.href--}}
                        {{--.slice(window.location.href.indexOf("?") + 1)--}}
                        {{--.split("&");--}}
                    {{--var result = {};--}}
                    {{--url.forEach(function(item) {--}}
                        {{--var param = item.split("=");--}}
                        {{--result[param[0]] = param[1];--}}
                    {{--});--}}
                    {{--return result;--}}
                {{--}--}}

                {{--Survey.dxSurveyService.serviceUrl = "";--}}
                {{--var accessKey = "";--}}
                {{--var editor = new SurveyEditor.SurveyEditor("editorElement");--}}
                {{--var surveyId = decodeURI(getParams()["id"]);--}}
                {{--editor.loadSurvey(surveyId);--}}
                {{--editor.saveSurveyFunc = function(saveNo, callback) {--}}
                    {{--var xhr = new XMLHttpRequest();--}}
                    {{--xhr.open(--}}
                        {{--"POST",--}}
                        {{--Survey.dxSurveyService.serviceUrl + "/changeJson?accessKey=" + accessKey--}}
                    {{--);--}}
                    {{--xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");--}}
                    {{--xhr.onload = function() {--}}
                        {{--var result = xhr.response ? JSON.parse(xhr.response) : null;--}}
                        {{--if (xhr.status === 200) {--}}
                            {{--callback(saveNo, true);--}}
                        {{--}--}}
                    {{--};--}}
                    {{--xhr.send(--}}
                        {{--JSON.stringify({ Id: surveyId, Json: editor.text, Text: editor.text })--}}
                    {{--);--}}
                {{--};--}}
                {{--editor.isAutoSave = true;--}}
                {{--editor.showState = true;--}}
                {{--editor.showOptions = true;--}}

                {{--surveyName = surveyId;--}}
                {{--setSurveyName(surveyName);--}}
            {{--</script>--}}
        @endsection






