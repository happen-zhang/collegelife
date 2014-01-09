<?php
/**
 * 生成<a>标签
 * @params 
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