<?php
/**
 * 自定义公共方法文件
 */

/**
 * 淘宝提供的获取地区的API
 * @param $ip string   用户ip
 * @return mixed       地区数组
 */
function getAreaByIp(string $ip){
    return json_decode(file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip),true);
}