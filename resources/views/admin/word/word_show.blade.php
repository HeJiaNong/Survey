
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

                var json = {
                    "title": "Tell us, what technologies do you use?",
                    "pages": [
                        {
                            "name": "page1",
                            "elements": [
                                {
                                    "type": "radiogroup",
                                    "name": "frameworkUsing",
                                    "title": "Do you use any front-end framework like Bootstrap?",
                                    "isRequired": true,
                                    "choices": [
                                        "Yes",
                                        "No"
                                    ]
                                },
                                {
                                    "type": "checkbox",
                                    "name": "framework",
                                    "visibleIf": "{frameworkUsing} = 'Yes'",
                                    "title": "What front-end framework do you use?",
                                    "isRequired": true,
                                    "hasOther": true,
                                    "choices": [
                                        "Bootstrap",
                                        "Foundation"
                                    ]
                                },
                                {
                                    "type": "imagepicker",
                                    "name": "question1",
                                    "choices": [
                                        {
                                            "value": "lion",
                                            "imageLink": "https://surveyjs.io/Content/Images/examples/image-picker/lion.jpg"
                                        },
                                        {
                                            "value": "giraffe",
                                            "imageLink": "https://surveyjs.io/Content/Images/examples/image-picker/giraffe.jpg"
                                        },
                                        {
                                            "value": "panda",
                                            "imageLink": "https://surveyjs.io/Content/Images/examples/image-picker/panda.jpg"
                                        },
                                        {
                                            "value": "camel",
                                            "imageLink": "https://surveyjs.io/Content/Images/examples/image-picker/camel.jpg"
                                        }
                                    ]
                                }
                            ]
                        },
                        {
                            "name": "page2",
                            "elements": [
                                {
                                    "type": "radiogroup",
                                    "name": "mvvmUsing",
                                    "title": "Do you use any MVVM framework?",
                                    "isRequired": true,
                                    "choices": [
                                        "Yes",
                                        "No"
                                    ]
                                },
                                {
                                    "type": "checkbox",
                                    "name": "mvvm",
                                    "visibleIf": "{mvvmUsing} = 'Yes'",
                                    "title": "What MVVM framework do you use?",
                                    "isRequired": true,
                                    "hasOther": true,
                                    "choices": [
                                        "AngularJS",
                                        "KnockoutJS",
                                        "React"
                                    ]
                                }
                            ]
                        },
                        {
                            "name": "page3",
                            "elements": [
                                {
                                    "type": "comment",
                                    "name": "about",
                                    "title": "Please tell us about your main requirements for Survey library"
                                }
                            ]
                        }
                    ]
                };

                window.survey = new Survey.Model(json);

                //完成问卷
                survey.onComplete.add(function (result) {
                        document.querySelector('#surveyResult').innerHTML = "result: " + JSON.stringify(result.data);
                    });

                $("#surveyElement").Survey({model: survey});
            </script>
        @endsection