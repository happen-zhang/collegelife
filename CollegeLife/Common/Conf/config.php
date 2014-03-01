<?php
$routesConfig = include('routes.php');
$dbConfig = include('Global/Conf/db_config.php');
$secureConfig = include('Global/Conf/secure_config.php');
$coustomConfig = include('Global/Conf/coustom_config.php');

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

    // error和success重定向
    'TMPL_ACTION_ERROR' => 'Public:error',
    'TMPL_ACTION_SUCCESS' => 'Public:success',
);

return array_merge($appConfig,
                   $routesConfig,
                   $dbConfig,
                   $secureConfig,
                   $coustomConfig);
