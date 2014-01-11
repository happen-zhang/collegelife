<?php
$routesConfig = include('routes.php');
$dbConfig = include('db.php');
$secureConfig = include('secure.php');

$appConfig =  array(
    // 调试页
    'SHOW_PAGE_TRACE' =>true,

    // 默认模块和Action
    'MODULE_ALLOW_LIST' => array('Home', 'Mobile'),
    'DEFAULT_MODULE' => 'Home',

    // 开启路由
    'URL_ROUTER_ON' => true,

    // 开启布局
    'LAYOUT_ON' => true,
    'LAYOUT_NAME' => 'Public/layout',
);

return array_merge($appConfig, $routesConfig, $dbConfig, $secureConfig);