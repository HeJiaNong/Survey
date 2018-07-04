<!DOCTYPE html>
<!-- saved from url=(0022)http://www.inves.test/ -->
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>满意度调查</title>

    <meta name="viewport" content="width=device-width,  initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="renderer" content="webkit">
    <style>
        /* cyrillic */
        @font-face {
            font-family: 'Exo 2';
            font-style: normal;
            font-weight: 400;
            src: local('Exo 2'), local('Exo2-Regular'), url(https://fonts.gstatic.com/s/exo2/v4/7cHmv4okm5zmbtYsK-4E4Q.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        /* latin-ext */
        @font-face {
            font-family: 'Exo 2';
            font-style: normal;
            font-weight: 400;
            src: local('Exo 2'), local('Exo2-Regular'), url(https://fonts.gstatic.com/s/exo2/v4/7cHmv4okm5zmbtYmK-4E4Q.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        /* latin */
        @font-face {
            font-family: 'Exo 2';
            font-style: normal;
            font-weight: 400;
            src: local('Exo 2'), local('Exo2-Regular'), url(https://fonts.gstatic.com/s/exo2/v4/7cHmv4okm5zmbtYoK-4.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        html, body {
            margin: 0;
            background-color: #ccc;
            width: 100%;
            height: 100%;
            font: 16px 'Exo 2', '-apple-system', 'Open Sans', 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', 'Hiragino Sans GB', 'Microsoft YaHei', Helvetica, Arial, sans-serif;
            background:#e5f5ff url(./static/home/image/bg.jpg) no-repeat; background-size: 100%;
        }

        main {
            max-width: 620px;
            margin: 20px auto 0 auto;
            position: relative;
            padding: 30px;
            -webkit-hyphens: auto;
            -moz-hyphens: auto;
            -ms-hyphens: auto;
            hyphens: auto;
            text-align: justify;
            background: linear-gradient(-150deg, transparent 1.5em, #fff 0);
            border-radius: .5em;
            text-align: center;
        }

        main:before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            background: 100% 0 no-repeat;
            width: 1.73em;
            height: 3em;
            transform: translateX(-0.6em) translateY(-0.6em) rotate(-30deg);
            border-bottom-left-radius: inherit;
            -webkit-box-shadow: -.2em .2em .3em -.1em rgba(0, 0, 0, .15);
            -moz-box-shadow: -.2em .2em .3em -.1em rgba(0, 0, 0, .15);
            box-shadow: -.2em .2em .3em -.1em rgba(0, 0, 0, .15);
        }

        main img {

        }

        main h1 {
            text-align: center;
        }

        .warning {
            border: 1px solid red !important;
        }
        .submit {
            text-align: center;
            margin: 20px 0;
        }

        .submit button[type="submit"] {
            width: 80px;
            height: 30px;
            border: 1px solid #3b71cc;
            color: #fff;
            background-color: #3b71cc;
            transition: width .3s;
            cursor: pointer;
        }

        .submit button[type="submit"]:hover {
            width: 100px;
        }

        p {
            margin: 40px 0
        }

        .select-election {
            display: block;
            margin: 20px;
        }
        .hidden{
            display: none;
        }

        .select-election select {
            border: 1px solid #ccc;
            width: 126px;
            padding: 4px 10px;
            outline: none;
        }

        .select-election select:focus {
            border: 1px solid #3b71cc;
        }


        @media screen and (max-width: 1080px) {
            html,body{background:#e5f5ff url(./static/home//image/bg.jpg) no-repeat bottom; background-size: 100%;}
            main {
                width: 80%;
            }
        }
        footer{ width: 100%; line-height: 30px; text-align: center; position: absolute; bottom: 0px;}
    </style>
</head>
<body>
<main>
    <div class="describe">
        <img src="./static/home/image/logo.png" width="300">
        <h1>问卷调查</h1>
    </div>
    <form data-student-src="/index/student/index.html" data-teacher-src="/index/teacher/index.html" data-staff-src="/index/staff/index.html" data-comp-src="/index/comp/index.html">
        <div class="select-list">
            <label class="select-election" data-level="1">
                查询方式：
                <!--这个name被我使用js控制,请不要修改-->
                <select id="select-type" name="type" class="per">
                    <option value="0">请选择</option>
                    @foreach($word as $k)
                        <option value="{{ $k->id }}">{{ $k->name }}</option>
                    @endforeach
                </select>
            </label>
            <label class="select-election select-class hidden" data-level="2">
                选择班级：
                <!--这个name被我使用js控制,请不要修改-->
                <select name="class" class="class_selected">
                    <option value="0" disabled="" selected="">--请选择班级--</option>
                    @foreach($grade as $v)
                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                    @endforeach
                </select>
            </label>
            <label class="select-election select-teacher hidden" data-level="3">
                选择老师：
                <!--这个name被我使用js控制,请不要修改-->
                <select name="teacher" class="select teacher_name">
                    <option value="0" disabled="" selected="">--请选择老师--</option>
                </select>
            </label>
        </div>
        <div class="submit">
            <button type="submit">进入</button>
        </div>
        <input type="submit" value="进入">
    </form>
</main>
<footer>
    <div>版权所有©四川新华电脑学院满意度调查系统 </div>
    <div>技术支持：陈雪冬 卿舒心 学生:程锟,王金火</div>
</footer>
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">




    var form = document.forms[0];
    //选择方式时触发
    document.querySelector("#select-type").addEventListener("change",function () {
        var list =document.querySelectorAll(".select-teacher,.select-class");
        //判断选择的id
        console.log(this.value);
        if(this.value != 0){
            list.forEach(function (e) {
                e.classList.remove('hidden');
            })
        }else{
            list.forEach(function (e) {
                e.classList.add('hidden');
            })
        }
    });

    /**
     * 提交之后检查是否已经选择
     */
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var selectElection = this.querySelectorAll('select');
        if(selectElection.length<1)return;
        var v = 1;
        /*
        判断不同的选择方式
        */
        if(selectElection[0].value==="1" || selectElection[0].value==="2" || selectElection[0].value==="3"){
            for (var i=0;i<selectElection.length;i++){
                var d = selectElection[i];
                if(Number(d['value'])===0){
                    v = 0;
                }
            }
        }else if(selectElection[0].value!=="2"){
            v = 0;
        }
        if(v===0){alert('请检查是否填写完整');return;}
        var formdata = new FormData(this);
        var data = {};
        formdata.forEach(function (value,key) {
            data[key]=value;
        });

        location = '{{ route('word') }}'+'/'+data['type']+'/'+data['class']+'/'+data['teacher'];
        /*
             根据请求的方式,跳转到不同的页面
         */
        // if(data['type']==="1"){
        //     location = form.getAttribute('data-student-src')+'?type='+data['type']+'&class='+data['class']+'&teacher='+data['teacher'];
        // }else  if(data['type']==="2"){
        //     location = form.getAttribute('data-teacher-src')+'?type='+data['type']+'&class='+data['class']+'&teacher='+data['teacher'];
        // }else  if(data['type']==="3"){
        //     location = form.getAttribute('data-comp-src')+'?type='+data['type']+'&class='+data['class']+'&teacher='+data['teacher'];
        // }else{
        //     location = form.getAttribute('data-staff-src')+'?type='+data['type'];
        // }

    })

</script>
<script>
    /*用于班级异步上传返回老师的值*/
    $(".class_selected").change(function(){
        var id = $(".class_selected").val();
        var per = $(".per").val();
        var url = '{{ route('home') }}'+'/teacher/'+id;
        // $(".teacher_name").text("数据请求中，请稍后...");
        // $.post('/index/index/teacher_local_select.html',{id:id,per_id:per},function (data,status) {
        //     $('.teacher_name').empty();
        //     $.each(data, function(key, val) {
        //         $('.teacher_name').append('<option value="'+val.id+'">'+val.name+'</option>');
        //     });
        // });

        console.log(url);
        $.ajax({
            async: true,    //异步
            type: "GET",
            url: url,
            traditional: true,
            // data:id,
            dataType: "json",
            cache: true,
            //服务器返回执行操作的状态
            success: function(data) {
                $('.teacher_name').empty();
                $.each(data, function(key, val) {
                    $('.teacher_name').append('<option value="'+key+'">'+val+'</option>');
                });
            },
            error:function (data) {
                console.log('操作失败!');
            }
        });


    });
    /*   $(".class_selected").change(function(){
           var id = $(".class_selected").val();
           $.post('/index/index/teacher_local_select.html',{id:id},function (data,status) {
               $('.teacher_name').empty();
               //$(".teacher_name").text("数据请求中，请稍后...");
               $.each(data, function(key, val) {
                   $('.teacher_name').append('<option value="'+val.id+'">'+val.name+'</option>');
               });
           });
       });*/
</script>

</body></html>