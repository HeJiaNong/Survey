<?php
/**
 * 自定义公共方法文件
 */

/**
 * 淘宝提供的获取地区的API
 * @param string $ip ip地址
 * @return array
 */
function getAreaByIp(string $ip) : array {
    //防止内网ip测试时接口报错 手动返回数据
    if ($ip == '127.0.0.1'){
        $ipArea['data']['ip']       = '127.0.0.1';
        $ipArea['data']['country']  = 'XX'; //国家
        $ipArea['data']['region']   = 'XX';   //地区
        $ipArea['data']['city']     = '内网IP';       //城市
        $ipArea['data']['isp']      = '内网IP';         //运营商
        return $ipArea;
    }
    return json_decode(file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip),true);
}

/**
 * 判断2个数组的键值是否相等 宽松比较
 * @param array $oneArr
 * @param array $twoArr
 * @return bool
 */
function array_is_eq(array $oneArr,array $twoArr) : bool {
    //sort排序，删除键名对键值排序
    sort($oneArr);
    sort($twoArr);

    //如果2个数组不等 则返回false
    if (!($oneArr == $twoArr)){
        return false;
    }

    return true;
}

/**
 * 通过name获取title
 * @param $name string    name
 * @return string   返回title
 */
function getTopicTitleByName(string $name){
    $title = '未知';
    switch ($name){
        case 'radiogroup'       : $title = '单项选择';break;
        case 'rating'           : $title = '评分';break;
        case 'text'             : $title = '文本框';break;
        case 'dropdown'         : $title = '下拉框';break;
        case 'comment'          : $title = '多行文本框';break;
        case 'checkbox'         : $title = '多项选择';break;
        case 'imagepicker'      : $title = '图片选择器';break;
        case 'boolean'          : $title = '布尔选择';break;
        case 'html'             : $title = 'Html代码';break;
        case 'expression'       : $title = '表达式';break;
        case 'file'             : $title = '文件上传';break;
        case 'matrix'           : $title = '矩阵(单选题)';break;
        case 'matrixdropdown'   : $title = '矩阵(多选题)';break;
        case 'matrixdynamic'    : $title = '矩阵(动态问题)';break;
        case 'multipletext'     : $title = '文本框组';break;
        case 'panel'            : $title = '面板';break;
        case 'paneldynamic'     : $title = '面板(动态)';break;
        case 'emotionsratings'  : $title = '情绪评级';break;
    }

    return $title;
}

