<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<style type="text/css">
			.selectBox{
				width: 400px;
				height: 36px;
				line-height: 36px;
				border: 1px solid #ccc;
			}
			.inputCase{
				position: relative;
				width: 100%;
				height: 100%;
				box-sizing: border-box;
			}
			.inputCase input.imitationSelect{
				width: 100%;
				height: 100%;
				box-sizing: border-box;
				border: 1px solid #ccc;
				display: block;
				text-indent: 20px;
				cursor: default;
			}
			.inputCase i.fa{
				position: absolute;
				right: 10px;
				top: 10px;
				color: #007AFF;
			}
			.fa{
				cursor: pointer;
			}
			.selectUl{
				display: none;
				padding: 0;
				margin: 0;
				border-left: 1px solid #cccccc;
				border-right: 1px solid #cccccc;
				border-bottom: 1px solid #cccccc;
				width: 100%;
				margin-left: -1px;
			}
			.selectUl li{
				height: 36px;
				line-height: 36px;
				list-style: none;
				text-indent: 20px;
				border-bottom: 1px solid #ccc;
			}
			.selectUl li:last-child{
				border-bottom: 0 none;
			}
			.selectUl li:hover{
				background: #ddd;
			}
			.selectUl li:last-child{
				border-bottom: 0 none;
			}
			.person_root {
			    width: auto;
			    margin-top: 4px;
			    margin-left: 5px;
			    border: 1px solid #0095e7;
			    color: #0095e7;
			    border-radius: 3px;
			    display: block;
			    float: left;
			}
			.person_root span:nth-child(1) {
			    line-height: 26px;
			    display: block;
			    float: left;
			    width: auto;
			    height: 26px;
			    float: left;
			    margin-left: 5px;
			    margin-right: 0px;
			    border: 0 none;
			    padding-right: 5px;
			    color: #0095e7;
			}
			.person_root i {
			    width: 20px;
			    height: 20px;
			    display: block;
			    padding: 0;
			    margin: 3px 8px 0px 0px;
			    float: left;
			    line-height: 20px;
			    text-align: center;
			    font-style: normal;
			    text-indent: 0px;
			    cursor: pointer;
			}
			#role_select{
				font-size: 12px;
				height: 100%;
			}
			.select-menu-div i {
			    color: #0095e7;
			    cursor: pointer;
			}
			.actived_li{
				color: #0095e7;
			}
		</style>
		<link rel="stylesheet" type="text/css" href="http://www.jq22.com/jquery/font-awesome.4.6.0.css">
	</head>
	<body>
		<!--
        	作者：1327910276@qq.com
        	时间：2018-06-01
        	描述：自定义select
        -->
        <h3>可选择多个标签</h3>
        <div class="selectBox">
        	<div class="inputCase">
        		<div id="role_select" class="select-menu-input imitationSelect"></div>
				<i class="fa fa-caret-down"></i>
			</div>
			<ul class="selectUl">
				<li oliName="橘子" oliId="1">橘子</li>
				<li oliName="苹果" oliId="2">苹果</li>
				<li oliName="桃子" oliId="3">桃子</li>
			</ul>
        </div>
		<script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
		<script type="text/javascript">
            $(function(){

                //点击输入框时候
                $(".selectBox .imitationSelect").on("click",function(event){
                    $(this).parent().next().toggle();//ul弹窗展开
                    $(this).next().toggleClass("fa-caret-up")//点击input选择适合，小图标动态切换
                    if($(this).next().hasClass("fa-caret-down")){
                        $(this).next().removeClass("fa-caret-down").addClass("fa-caret-up")//点击input选择适合，小图标动态切换
                    }else{
                        $(this).next().addClass("fa-caret-down").removeClass("fa-caret-up")//点击input选择适合，小图标动态切换
                    }
                    if (event.stopPropagation) {
                        // 针对 Mozilla 和 Opera
                        event.stopPropagation();
                    }else if (window.event) {
                        // 针对 IE
                        window.event.cancelBubble = true;
                    }
                });

                //点击右边箭头icon时候
                $(".selectBox .fa").on("click",function(event){
                    $(this).parent().next().toggle();//ul弹窗展开
                    if($(this).hasClass("fa-caret-down")){
                        $(this).removeClass("fa-caret-down").addClass("fa-caret-up")//点击input选择适合，小图标动态切换
                    }else{
                        $(this).addClass("fa-caret-down").removeClass("fa-caret-up")//点击input选择适合，小图标动态切换
                    }
                    if (event.stopPropagation) {
                        // 针对 Mozilla 和 Opera
                        event.stopPropagation();
                    }else if (window.event) {
                        // 针对 IE
                        window.event.cancelBubble = true;
                    }
                });

                //定义一个存储数据的数组，用于下面重复选择判断，删除标签
                var oliIdArray = [];
                var indexArray = [];//这个数组，用于存储，后面删除时候，下拉选项颜色取消取值的数组；
                $(".selectUl li").click(function(event){
                    event=event||window.event;
                    $(this).addClass("actived_li");//点击当前的添加   actived_li这个类；
                    var oliId = $(this).attr("oliId");

                    //先是判断
                    if(oliIdArray.indexOf(oliId)>-1){
                        ///返回字符中indexof（string）中字串string在父串中首次出现的位置
                        //如果要检索的字符串值没有出现，则该方法返回 -1。
                    }else{
                        oliIdArray.push(oliId);
                        $(this).parent().prev().children().attr("oliId",oliIdArray);//把当前点击的oliId赋值到显示的input的oliId里面
                        $("#role_select").append("<span class='person_root'><span>"+$(this).text()+"</span><i class='close' oliId='" + oliId + "' >x</i></span>");
                    }
                    //给进行绑定事件，每个删除事件得以进行
                    var role_select = document.getElementById("role_select");
                    var role_span= role_select.getElementsByTagName('i');
                    var id;
                    //console.log("span的选择个数"+role_span.length)l
                    for(var i=0;i<role_span.length;i++){
                        role_span[i].onclick = function(){
                            $(".selectUl").hide();
                            var oliId = $(this).attr("oliId");
                            console.log(oliId)
                            for (var i = 0; i < oliIdArray.length; i++){
                                if (oliIdArray[i] === oliId){ //表示数组里面有这个元素
                                    id = i;//元素位置
                                    oliIdArray.splice(id,1);//删除元素后，重新返回数组
                                    $(".selectUl li").eq(oliId-1).removeClass("actived_li");
                                }
                            }
                            $(this).parent().remove();
                        }
                    }


                });

                //点击任意地方隐藏下拉
                $(document).click(function(event){
                    event=event||window.event;
                    $(".inputCase .fa").removeClass("fa-caret-up").addClass("fa-caret-down")//当点隐藏ul弹窗时候，把小图标恢复原状
                    $(".selectUl").hide();//当点击空白处，隐藏ul弹窗
                });

            })

		</script>

	</body>
</html>
