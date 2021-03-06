

@extends('admin.layouts.default')

@section('body')
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo"><a href="{{ route('admin') }}">Survey 后台管理</a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>
        <ul class="layui-nav left fast-add" lay-filter="">
            <li class="layui-nav-item">
                <a href="javascript:;">+新增</a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                    <dd><a onclick="x_admin_show('资讯','http://www.baidu.com')"><i class="iconfont">&#xe6a2;</i>资讯</a></dd>
                    <dd><a onclick="x_admin_show('图片','http://www.baidu.com')"><i class="iconfont">&#xe6a8;</i>图片</a></dd>
                    <dd><a onclick="x_admin_show('用户','http://www.baidu.com')"><i class="iconfont">&#xe6b8;</i>用户</a></dd>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav right" lay-filter="">
            <li class="layui-nav-item">
                <a href="javascript:;">@if(\Illuminate\Support\Facades\Auth::check()){{ \Illuminate\Support\Facades\Auth::user()->name }}@else 未登陆 @endif</a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                    <dd><a onclick="x_admin_show('个人信息','http://www.baidu.com')">个人信息</a></dd>
                    <dd><a onclick="x_admin_show('切换帐号','http://www.baidu.com')">切换帐号</a></dd>
                    <dd><a href="{{ route('admin_logout') }}">退出</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item to-index"><a target="target" href="/">前台首页</a></li>
        </ul>

    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
    <!-- 左侧菜单开始 -->
    <div class="left-nav">
        <div id="side-nav">

            <ul id="nav">
                <li>
                    <a href="javascript:;">
                        <i class="iconfont">&#xe723;</i>
                        <cite>问卷管理</cite>
                        <i class="iconfont nav_right">&#xe697;</i>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a _href="{{ route('admin_category_list_get') }}">
                                <i class="iconfont">&#xe6a7;</i>
                                <cite>问卷分组</cite>
                            </a>
                        </li >
                        <li>
                            <a _href="{{ route('admin_word_list_get') }}">
                                <i class="iconfont">&#xe6a7;</i>
                                <cite>问卷列表</cite>
                            </a>
                        </li >
                        {{--<li class="open">--}}
                            {{--<a href="javascript:;">--}}
                                {{--<i class="iconfont">&#xe757;</i>--}}
                                {{--<cite>数据统计</cite>--}}
                                {{--<i class="iconfont nav_right"></i>--}}
                            {{--</a>--}}
                            {{--<ul class="sub-menu" style="display: block;">--}}
                                {{--<li>--}}
                                    {{--<a _href="{{ route('admin_word_count_user') }}">--}}
                                        {{--<i class="iconfont"></i>--}}
                                        {{--<cite>用户统计</cite>--}}

                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a _href="{{ route('admin_word_count_results') }}">--}}
                                        {{--<i class="iconfont"></i>--}}
                                        {{--<cite>答卷统计</cite>--}}

                                    {{--</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                    </ul>
                </li>

                <li>
                    <a href="javascript:;">
                        <i class="iconfont">&#xe6b8;</i>
                        <cite>老师管理</cite>
                        <i class="iconfont nav_right">&#xe697;</i>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a _href="{{ route('admin_branch_list_get') }}">
                                <i class="iconfont">&#xe6a7;</i>
                                <cite>部门列表</cite>
                            </a>
                        </li >
                        <li>
                            <a _href="{{ route('admin_teacher_list_get') }}">
                                <i class="iconfont">&#xe6a7;</i>
                                <cite>老师列表</cite>
                            </a>
                        </li >
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="iconfont">&#xe723;</i>
                        <cite>班级管理</cite>
                        <i class="iconfont nav_right">&#xe697;</i>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a _href="{{ route('admin_grade_list_get') }}">
                                <i class="iconfont">&#xe6a7;</i>
                                <cite>班级列表</cite>

                            </a>
                        </li >
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="iconfont">&#xe726;</i>
                        <cite>管理员管理</cite>
                        <i class="iconfont nav_right">&#xe697;</i>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a _href="{{ route('admin_user_list_get') }}">
                                <i class="iconfont">&#xe6a7;</i>
                                <cite>管理员列表</cite>

                            </a>
                        </li >

                    </ul>
                </li>
                {{--<li>--}}
                    {{--<a href="javascript:;">--}}
                        {{--<i class="iconfont">&#xe723;</i>--}}
                        {{--<cite>城市联动</cite>--}}
                        {{--<i class="iconfont nav_right">&#xe697;</i>--}}
                    {{--</a>--}}
                    {{--<ul class="sub-menu">--}}
                        {{--<li>--}}
                            {{--<a _href="city.html">--}}
                                {{--<i class="iconfont">&#xe6a7;</i>--}}
                                {{--<cite>三级地区联动</cite>--}}
                            {{--</a>--}}
                        {{--</li >--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="javascript:;">--}}
                        {{--<i class="iconfont">&#xe726;</i>--}}
                        {{--<cite>管理员管理</cite>--}}
                        {{--<i class="iconfont nav_right">&#xe697;</i>--}}
                    {{--</a>--}}
                    {{--<ul class="sub-menu">--}}
                        {{--<li>--}}
                            {{--<a _href="admin-list.html">--}}
                                {{--<i class="iconfont">&#xe6a7;</i>--}}
                                {{--<cite>管理员列表</cite>--}}
                            {{--</a>--}}
                        {{--</li >--}}
                        {{--<li>--}}
                            {{--<a _href="admin-role.html">--}}
                                {{--<i class="iconfont">&#xe6a7;</i>--}}
                                {{--<cite>角色管理</cite>--}}
                            {{--</a>--}}
                        {{--</li >--}}
                        {{--<li>--}}
                            {{--<a _href="admin-cate.html">--}}
                                {{--<i class="iconfont">&#xe6a7;</i>--}}
                                {{--<cite>权限分类</cite>--}}
                            {{--</a>--}}
                        {{--</li >--}}
                        {{--<li>--}}
                            {{--<a _href="admin-rule.html">--}}
                                {{--<i class="iconfont">&#xe6a7;</i>--}}
                                {{--<cite>权限管理</cite>--}}
                            {{--</a>--}}
                        {{--</li >--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="javascript:;">--}}
                        {{--<i class="iconfont">&#xe6ce;</i>--}}
                        {{--<cite>系统统计</cite>--}}
                        {{--<i class="iconfont nav_right">&#xe697;</i>--}}
                    {{--</a>--}}
                    {{--<ul class="sub-menu">--}}
                        {{--<li>--}}
                            {{--<a _href="echarts1.html">--}}
                                {{--<i class="iconfont">&#xe6a7;</i>--}}
                                {{--<cite>拆线图</cite>--}}
                            {{--</a>--}}
                        {{--</li >--}}
                        {{--<li>--}}
                            {{--<a _href="echarts2.html">--}}
                                {{--<i class="iconfont">&#xe6a7;</i>--}}
                                {{--<cite>柱状图</cite>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a _href="echarts3.html">--}}
                                {{--<i class="iconfont">&#xe6a7;</i>--}}
                                {{--<cite>地图</cite>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a _href="echarts4.html">--}}
                                {{--<i class="iconfont">&#xe6a7;</i>--}}
                                {{--<cite>饼图</cite>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a _href="echarts5.html">--}}
                                {{--<i class="iconfont">&#xe6a7;</i>--}}
                                {{--<cite>雷达图</cite>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a _href="echarts6.html">--}}
                                {{--<i class="iconfont">&#xe6a7;</i>--}}
                                {{--<cite>k线图</cite>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a _href="echarts7.html">--}}
                                {{--<i class="iconfont">&#xe6a7;</i>--}}
                                {{--<cite>热力图</cite>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a _href="echarts8.html">--}}
                                {{--<i class="iconfont">&#xe6a7;</i>--}}
                                {{--<cite>仪表图</cite>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="javascript:;">--}}
                        {{--<i class="iconfont">&#xe6b4;</i>--}}
                        {{--<cite>图标字体</cite>--}}
                        {{--<i class="iconfont nav_right">&#xe697;</i>--}}
                    {{--</a>--}}
                    {{--<ul class="sub-menu">--}}
                        {{--<li>--}}
                            {{--<a _href="unicode.html">--}}
                                {{--<i class="iconfont">&#xe6a7;</i>--}}
                                {{--<cite>图标对应字体</cite>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
            </ul>
        </div>
    </div>
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
            <ul class="layui-tab-title">
                <li class="home"><i class="layui-icon">&#xe68e;</i>问卷概况</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <iframe src="{{ route('admin_desktop') }}" frameborder="0" scrolling="yes" class="x-iframe"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
    <!-- 底部开始 -->
    <div class="footer">
        <div class="copyright">Copyright ©2018-HeJiaNong All Rights Reserved</div>
    </div>
    <!-- 底部结束 -->


@endsection