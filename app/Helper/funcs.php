<?php
/**
 * 自定义公共方法文件
 */

/**淘宝提供的获取地区的API
 * @param string $ip ip地址
 * @return array
 */
function getAreaByIp(string $ip) : array {
    return json_decode(file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip),true);
}