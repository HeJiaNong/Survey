
@extends('admin.layouts.default')

@section('head')
    @include('admin.layouts._editorShowMeta')
@endsection

@section('body')
    <div id="surveyElement"></div>
    <div id="surveyResult"></div>
@endsection

@section('footer')
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
            .applyTheme("default");

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