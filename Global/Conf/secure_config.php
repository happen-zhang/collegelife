<?php
$secureConfig = array(
    // cookie_name
    'COOKIE_NAME' => 'studio21_',
    // cookie前缀
    'COOKIE_PREFIX' => 'cl_',

    // session用户验证键值
    'SESSION_AUTH_KEY_NAME' => 'cl_user',
    // session管理员验证键值
    'SESSION_AUTH_KEY_ADMIN' => 'cl_admin',

    // 令牌验证
    'TOKEN_NAME' => '__hash__',
);

return $secureConfig;
