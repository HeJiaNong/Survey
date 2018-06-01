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
                    <option value="0" disabled="" selected="">--请选择入口--</option>
                    <option value="3">学生综合满意度调查</option>
                    <option value="2">教师授课满意度调查</option>
                </select>
            </label>
            <label class="select-election select-class hidden" data-level="2">
                选择班级：
                <!--这个name被我使用js控制,请不要修改-->
                <select name="class" class="class_selected">
                    <option value="0" disabled="" selected="">--请选择班级--</option>
                    <option value="46">17三年艺术1</option>
                    <option value="45">17三年动漫2</option>
                    <option value="44">184D动漫游戏设计师1</option>
                    <option value="43">16三年游戏动漫2</option>
                    <option value="42">17UI设计1</option>
                    <option value="41">18艺术设计师1</option>
                    <option value="40">17互联网1</option>
                    <option value="39">16三年艺术3</option>
                    <option value="38">17艺术4</option>
                    <option value="37">18VR1</option>
                    <option value="36">17三年动漫1</option>
                    <option value="35">17网络技术1</option>
                    <option value="34">17中专互联网应用2</option>
                    <option value="33">18大数据1</option>
                    <option value="32">16三年艺术1</option>
                    <option value="31">17云计算软件1</option>
                    <option value="30">17DT2</option>
                    <option value="29">17艺术1,2</option>
                    <option value="28">17DT1</option>
                    <option value="27">18跨境电商1</option>
                    <option value="26">17云电商2</option>
                    <option value="25">17软件1</option>
                    <option value="24">16三年软件2</option>
                    <option value="23">18云开发1</option>
                    <option value="22">17VR2</option>
                    <option value="21">17VR1</option>
                    <option value="20">17三年软件4</option>
                    <option value="19">17三年软件3</option>
                    <option value="18">17三年软件1</option>
                    <option value="17">17三年软件2</option>
                    <option value="16">16三年动漫1</option>
                    <option value="15">18人工智能1</option>
                    <option value="14">18移动APP1</option>
                    <option value="13">17艺术3</option>
                    <option value="12">17软件3</option>
                    <option value="11">17软件2</option>
                    <option value="10">17创客1</option>
                    <option value="9">17三年DT1,2</option>
                    <option value="8">16三年软件3</option>
                    <option value="7">16三年DT1</option>
                    <option value="6">17智能家居设计1</option>
                    <option value="5">18计算机应用1</option>
                    <option value="4">17三年艺术2</option>
                    <option value="3">16三年艺术2</option>
                    <option value="2">18UI1</option>
                    <option value="1">16三年软件1</option>
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
    </form>
</main>
<footer>
    <div>版权所有©四川新华电脑学院满意度调查系统 </div>
    <div>技术支持：陈雪冬 卿舒心 学生:程锟,王金火</div>
</footer>
<script src="./满意度调查_files/jquery.min.js.下载"></script>
<script type="text/javascript">




    var form = document.forms[0];
    document.querySelector("#select-type").addEventListener("change",function () {
        var list =document.querySelectorAll(".select-teacher,.select-class");
        if(this.value==="1" || this.value==="2" || this.value==="3"){
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
        /*
             根据请求的方式,跳转到不同的页面
         */
        if(data['type']==="1"){
            location = form.getAttribute('data-student-src')+'?type='+data['type']+'&class='+data['class']+'&teacher='+data['teacher'];
        }else  if(data['type']==="2"){
            location = form.getAttribute('data-teacher-src')+'?type='+data['type']+'&class='+data['class']+'&teacher='+data['teacher'];
        }else  if(data['type']==="3"){
            location = form.getAttribute('data-comp-src')+'?type='+data['type']+'&class='+data['class']+'&teacher='+data['teacher'];
        }else{
            location = form.getAttribute('data-staff-src')+'?type='+data['type'];
        }
    })

</script>
<script>
    /*用于班级异步上传返回老师的值*/
    $(".class_selected").change(function(){
        var id = $(".class_selected").val();
        var per = $(".per").val();
        //$(".teacher_name").text("数据请求中，请稍后...");
        $.post('/index/index/teacher_local_select.html',{id:id,per_id:per},function (data,status) {
            $('.teacher_name').empty();
            $.each(data, function(key, val) {
                $('.teacher_name').append('<option value="'+val.id+'">'+val.name+'</option>');
            });
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