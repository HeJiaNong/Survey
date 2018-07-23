<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="{{ URL::asset('/static/errors/404/js/bodymovin.js') }}"></script>
    <script src="{{ URL::asset('/static/errors/404/js/data.js') }}"></script>
    <title>404页面</title>
    <style>
        html {
            margin: 0;
            padding: 0;
            background-color: white;
        }

        body,
        html {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        #svgContainer {
            width: 640px;
            height: 512px;
            background-color: white;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
        }
    </style>
</head>
<body>
{{--输出错误信息--}}
{{--<h2>{{ $exception->getMessage() }}</h2>--}}
    <div id="svgContainer"></div>
</body>
<script>
    var svgContainer = document.getElementById("svgContainer");
    var animItem = bodymovin.loadAnimation({
        wrapper: svgContainer,
        animType: "svg",
        loop: true,
        animationData: JSON.parse(animationData)
    });
</script>
</html>