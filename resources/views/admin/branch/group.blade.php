@extends('admin.layouts.default')
@section('body')
    <style>
        *{box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;}
        .contact-ul{margin-top:10px;font-size:14px;}
        .contact-ul>.contact-li{
            text-align: left;
            border-bottom: 1px solid #E0E0E0;
            padding:10px;
        }
        .contact-ul>.contact-li:hover{
            cursor:pointer;
        }
        .contact-ul>.contact-li:last-child{border-bottom:0px;width:100%;}
        .contact-ul>.contact-li>.contact-content{
            display: none;
        }
        .fa-box{width:100%;overflow-y:auto;position:absolute;bottom:60px;top:50px;}
        .fa-box-item{
            width:100%;
            padding-left:10px;
            padding-top:5px;
            padding-bottom:5px;
            background:white;
            border-bottom:1px solid rgba(160,160,160,.3);
            overflow:hidden;white-space:nowrap;text-overflow:ellipsis;
        }
        .fa-box-item:hover{
            cursor:pointer;
        }
        .fa-box-item:last-child{border-bottom:0px;}
        .fa-box-item-left{width:40px;height:40px;float:left;background:pink;border-radius:50%;position:relative;}
        .fa-box-item-right{height:40px;max-width:65%;float:left;padding-left:3px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;}
        .fa-color-red{color:rgba(200,0,0,.8);}
    </style>
    <div class="contact-ul" id="contact-ul">
        <div class="contact-li">
            <div class="contact-group"> <i class="fa fa-angle-down"></i>  好友</div>
            <div class="contact-content">
                <div class="fa-box-item">
                    <div class="fa-box-item-left"></div>
                    <div class="fa-box-item-right">王三 <span class="fa-size-xxs">在线</span><br><i class="fa fa-heart fa-color-red  fa-size-xxs" ></i>世界之大世界之大世界之大世界之大世界之大世界之大世界之大世界之大</div>
                </div>
                <div class="fa-box-item">
                    <div class="fa-box-item-left"></div>
                    <div class="fa-box-item-right">王三 <span class="fa-size-xxs">在线</span><br><i class="fa fa-heart fa-color-red  fa-size-xxs" ></i>世界之大世界之大世界之大世界之大世界之大世界之大世界之大世界之大</div>
                </div>
                <div class="fa-box-item">
                    <div class="fa-box-item-left"></div>
                    <div class="fa-box-item-right">王三 <span class="fa-size-xxs">在线</span><br><i class="fa fa-heart fa-color-red  fa-size-xxs" ></i>世界之大世界之大世界之大世界之大世界之大世界之大世界之大世界之大</div>
                </div>
            </div>
        </div>
        <div class="contact-li">
            <div class="contact-group"> <i class="fa fa-angle-down"></i>  好友2</div>
            <div class="contact-content">
                <div class="fa-box-item">
                    <div class="fa-box-item-left"></div>
                    <div class="fa-box-item-right">王三 <span class="fa-size-xxs">在线</span><br><i class="fa fa-heart fa-color-red  fa-size-xxs" ></i>世界之大世界之大世界之大世界之大世界之大世界之大世界之大世界之大</div>
                </div>
                <div class="fa-box-item">
                    <div class="fa-box-item-left"></div>
                    <div class="fa-box-item-right">王三 <span class="fa-size-xxs">在线</span><br><i class="fa fa-heart fa-color-red  fa-size-xxs" ></i>世界之大世界之大世界之大世界之大世界之大世界之大世界之大世界之大</div>
                </div>
                <div class="fa-box-item">
                    <div class="fa-box-item-left"></div>
                    <div class="fa-box-item-right">王三 <span class="fa-size-xxs">在线</span><br><i class="fa fa-heart fa-color-red  fa-size-xxs" ></i>世界之大世界之大世界之大世界之大世界之大世界之大世界之大世界之大</div>
                </div>
            </div>
        </div>
        <div class="contact-li">
            <div class="contact-group"> <i class="fa fa-angle-down"></i>  好友3</div>
            <div class="contact-content">
                <div class="fa-box-item">
                    <div class="fa-box-item-left"></div>
                    <div class="fa-box-item-right">王三 <span class="fa-size-xxs">在线</span><br><i class="fa fa-heart fa-color-red  fa-size-xxs" ></i>世界之大世界之大世界之大世界之大世界之大世界之大世界之大世界之大</div>
                </div>
                <div class="fa-box-item">
                    <div class="fa-box-item-left"></div>
                    <div class="fa-box-item-right">王三 <span class="fa-size-xxs">在线</span><br><i class="fa fa-heart fa-color-red  fa-size-xxs" ></i>世界之大世界之大世界之大世界之大世界之大世界之大世界之大世界之大</div>
                </div>
                <div class="fa-box-item">
                    <div class="fa-box-item-left"></div>
                    <div class="fa-box-item-right">王三 <span class="fa-size-xxs">在线</span><br><i class="fa fa-heart fa-color-red  fa-size-xxs" ></i>世界之大世界之大世界之大世界之大世界之大世界之大世界之大世界之大</div>
                </div>
            </div>
        </div>
        <div class="contact-li">
            <div class="contact-group"> <i class="fa fa-angle-down"></i>  好友4</div>
            <div class="contact-content">
                <div class="fa-box-item">
                    <div class="fa-box-item-left"></div>
                    <div class="fa-box-item-right">王三 <span class="fa-size-xxs">在线</span><br><i class="fa fa-heart fa-color-red  fa-size-xxs" ></i>世界之大世界之大世界之大世界之大世界之大世界之大世界之大世界之大</div>
                </div>
                <div class="fa-box-item">
                    <div class="fa-box-item-left"></div>
                    <div class="fa-box-item-right">王三 <span class="fa-size-xxs">在线</span><br><i class="fa fa-heart fa-color-red  fa-size-xxs" ></i>世界之大世界之大世界之大世界之大世界之大世界之大世界之大世界之大</div>
                </div>
                <div class="fa-box-item">
                    <div class="fa-box-item-left"></div>
                    <div class="fa-box-item-right">王三 <span class="fa-size-xxs">在线</span><br><i class="fa fa-heart fa-color-red  fa-size-xxs" ></i>世界之大世界之大世界之大世界之大世界之大世界之大世界之大世界之大</div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function(){
            $("#contact-ul>.contact-li>.contact-group").click(function(){
                if($(this).find("i").hasClass("fa-angle-down")){
                    /**设置当前选中图标**/
                    $(this).find("i").removeClass("fa-angle-down");
                    $(this).find("i").addClass("fa-angle-up");
                    /**样式1：只关注当前项**/
                    $(this).nextAll().slideDown();
                    /**样式2：设置显示当前内容，其他组内容隐藏，未选中图标**/
                    //$(this).nextAll().slideDown().end().parent().siblings().children(".contact-content").hide();
                    //$(this).parent().siblings().children("div").children("i").removeClass("fa-angle-up").addClass("fa-angle-down");
                }else{
                    /**设置当前取消选中图标**/
                    $(this).find("i").removeClass("fa-angle-up");
                    $(this).find("i").addClass("fa-angle-down");
                    /**样式1：只关注当前项**/
                    $(this).nextAll().slideUp();
                    /**样式2：设置所有内容隐藏，未选中图标**/
                    //$(this).nextAll().slideUp().end().parent().siblings().children(".contact-content").hide();
                    //$(this).parent().siblings().children("div").children("i").removeClass("fa-angle-up").addClass("fa-angle-down");;
                }
            });
        });

    </script>
@endsection

