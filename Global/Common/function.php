<?php
/**
* 防sql注入
* @param  string $content
* @return string
*/
function sql_injection($content) {
    if (is_array($content)) {
        foreach ($content as $key => $value) {
            $content[$key] = trim($value);
        }

        if (false == get_magic_quotes_gpc()) {
            foreach ($content as $key => $value) {
                // 添加反斜杠
                $content[$key] = addslashes($value);
            }
        }

        foreach ($content as $key => $value) {
            // 转义%
            $content[$key] = str_replace('%', '\%', $value);
            // 转义_
            $content[$key] = str_replace('_', '\_', $value);
        }
    } else {
        // 去除空格
        $content = trim($content);
        if (false == get_magic_quotes_gpc()) {
            // 添加反斜杠
            $content = addslashes($content);
        }
        // 转义%
        $content = str_replace('%', '\%', $content);
        // 转义_
        $content = str_replace('_', '\_', $content);
    }

    return $content;
}

/**
* 转义sql注入字符
* @param  string $content
* @return string
*/
function strip_sql_injection($content) {
    if (is_array($content)) {
        foreach ($content as $key => $value) {
            $content[$key] = str_replace('&quot;', "'", $value);
            $content[$key] = stripslashes($value);
            $content[$key] = str_replace('\%', '%', $value); // 转义%
            $content[$key] = str_replace('\_', '_', $value); // 转义_
            $content[$key] = stripslashes($value);
        }
    } else {
        $content = str_replace('&quot;', "'", $content);
        $content = stripslashes($content);
        $content = str_replace('\%', '%', $content); // 转义%
        $content = str_replace('\_', '_', $content); // 转义_
        $content = stripslashes($content);
    }

    return $content;
}

/**
* 过滤特殊字符
* @param  string $src
* @return string
*/
function filterSpecialChars($src) {
    return sql_injection(htmlspecialchars($src));
}

/**
* 生成令牌
* @return [type] [description]
*/
function generate_token() {
    $hash = md5(uniqid(rand(), true));
    $n = rand(1, 26);
    $token = substr($hash, $n, 16);
    return $token;
}

/**
* 得到令牌
* @param  string $key_name
* @return string
*/
function get_token($key_name) {
    $_SESSION[$key_name] = generate_token();
    return $_SESSION[$key_name];
}

/**
* 验证token是否正确
* @param  string  $key_name 
* @param  string  $token    
* @return boolean           
*/
function is_valid_token($key_name, $token) {
    if (isset($_SESSION[$key_name]) && $_SESSION[$key_name] == $token) {
        return true;
    }

    return false;
}

/**
* 生成uuid
* @param  string $prefix
* @return string
*/
function uuid($prefix = '') {
    $str = md5(uniqid(mt_rand(), true));   
    $uuid  = substr($str,0,8) . '-';   
    $uuid .= substr($str,8,4) . '-';   
    $uuid .= substr($str,12,4) . '-';   
    $uuid .= substr($str,16,4) . '-';   
    $uuid .= substr($str,20,12);

    return $prefix . $uuid;
}

/**
* 生成datetime
* @return string
*/
function datetime() {
    return date('Y-m-d H:i:s');
}

/**
 * 格式化数组成字符串
 * @param  array $array
 * @return string
 */
function formatArrToStr($array) {
    foreach ($array as $value) {
        $str .= "[{$value}] ";
    }

    return $str;
}

/**
 * 获得ip地址和定位信息
 * @return string
 */
function getIpLocation() {
    $ip = get_client_ip();
    $ipLocation = new \Org\Net\IpLocation('UTFWry.dat');
    $area = $ipLocation->getlocation($ip);

    return $ip . ' ' . $area['country'] . ' ' .$area['area'];
}