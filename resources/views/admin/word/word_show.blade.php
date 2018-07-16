
@extends('admin.layouts.default')

        @section('head')
            @include('admin.layouts._editorShowMeta')
        @endsection

        @section('body')

            <div id="surveyElement"></div>
            <div id="surveyResult"></div>
        @endsection

        @section('footer')
            <script type="text/javascript" >
                var json = {!! $word->content !!};

                window.survey = new Survey.Model(json);

                //完成问卷
                survey.onComplete.add(function (result) {
                        document.querySelector('#surveyResult').innerHTML = "result: " + JSON.stringify(result.data);
                    });

                $("#surveyElement").Survey({model: survey});
            </script>
        @endsection