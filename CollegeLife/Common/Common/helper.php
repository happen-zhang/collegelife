<?php
/**
* 生成<a>标签
* @param  string $text
* @param  string $url
* @param  string $options
* @return string
*/
function link_to($text, $url, $options) {
    if (is_array($options)) {
        $optionsStr = '';
        foreach ($options as $key => $value) {
            $optionsStr .= "{$key}='{$value}' ";
        }
    }

    return "<a href='{$url}' {$optionsStr}>{$text}</a>";
}

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
function menu_style_link($text, $url, $options, $bind_name, $src_name) {
    $style = array('style' => 'background-color:#9cb80c;color:white');
    if (strpos($bind_name, 'Shops') !== false) {
        if (strpos($src_name, 'Shops') !== false) {
            $options = array_merge($options, $style);
        } elseif (strpos($src_name, 'shopCenter')) {
            $src_name .= '/Shops';
        }
    }

    if ($bind_name == $src_name 
        || (strpos($bind_name, 'Shops') !== false)
        && (strpos($src_name, 'Shops') !== false)) {
            $options = array_merge($options, $style);
    }

    return link_to($text, $url, $options);
}