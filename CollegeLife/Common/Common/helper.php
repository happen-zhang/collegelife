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