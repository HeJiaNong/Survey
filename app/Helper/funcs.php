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