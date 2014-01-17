<?php
$dbConfig = include('Global/Conf/db_config.php');
$secureConfig = include('Global/Conf/secure_config.php');

$appConfig =  array(
    // 调试页
    'SHOW_PAGE_TRACE' =>true,

    // 默认模块和Action
    'MODULE_ALLOW_LIST' => array('Home'),
    'DEFAULT_MODULE' => 'Home',

    // 开启布局
    'LAYOUT_ON' => true,
    'LAYOUT_NAME' => 'Public/layout',

    // error和success重定向
    // 'TMPL_ACTION_ERROR' => 'Public:error',
    // 'TMPL_ACTION_SUCCESS' => 'Public:success',
    
    // 分页列表数
    'PAGINATION_NUM' => 5,
);

return array_merge($appConfig, $dbConfig, $secureConfig);