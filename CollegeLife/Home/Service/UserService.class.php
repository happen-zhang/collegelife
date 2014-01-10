<?php
namespace Home\Service;

use Think\Model;

/**
* UserService
*/
class UserService extends Model {
    /**
    * 用户登录
    * @param  array $data 用户登陆数据
    * @return boolean   
    */
    public function login($data) {
        // 防注入
        $user['username'] = sql_injection(htmlspecialchars($data['username']));
        $user['password'] = sql_injection(htmlspecialchars($data['password']));
        $user['password'] = md5($user['password']);
        // 状态为激活
        $user['is_active'] = 1;

        $User = M('User');
        $result = $User->where($user)
                       ->field(array('uuid', 'username'))->find();
        if (!empty($result)) {
            // session
            $_SESSION['username'] = $result['username'];
            $_SESSION[C('SESSION_AUTH_KEY_NAME')]
                     = md5($result['username'] . C('COOKIE_NAME'));
            $_SESSION['uid'] = $result['uuid'];
            
            return true;
        } else {
            // 密码错误
            return false;
        }
    }

    /**
    * 用户登出
    * @return
    */
    public function logout() {
        // 清除session
        unset($_SESSION['username']);
        unset($_SESSION[C('SESSION_AUTH_KEY_NAME')]);
        unset($_SESSION['uid']);
    }
}