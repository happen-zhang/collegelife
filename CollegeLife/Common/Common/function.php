<?php
include 'helper.php';

/**
 * header.html
 * 生成menu中当前位置的链接 
 * @param  string $text
 * @param  string $url
 * @param  array $options
 * @param  string $bind_name
 * @param  string $target_name
 * @return string
 */
function menu_style_link($text, $url, $options, $bind_name, $target_name) {
    if ($bind_name == $target_name) {
        $style = array('style' => 'background-color:#9cb80c;color:white');
        $options = array_merge($options, $style);
    }

    return link_to($text, $url, $options);
}