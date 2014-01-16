<?php
namespace Home\Service;

use Think\Model;

/**
* AdminService
*/
class AdminService extends Model {
    /**
    * 管理员登录
    * @param  array $data 管理员登陆数据
    * @return boolean   
    */
    public function login($data) {
        // 防注入
        $admin_name = sql_injection(htmlspecialchars($data['admin_name']));
        $password = sql_injection(htmlspecialchars($data['password']));
        $admin['admin_name'] = $admin_name;
        $admin['password'] = md5($password);
        // 状态为激活
        $admin['is_active'] = 1;

        $Admin = M('Admin');
        $result = $Admin->where($admin)
                        ->field(array('uuid', 'admin_name'))->find();
        if (!empty($result)) {
            // session
            $_SESSION['admin_name'] = $result['admin_name'];
            $_SESSION[C('SESSION_AUTH_KEY_ADMIN')]
                     = md5($result['admin_name'] . C('COOKIE_NAME'));
            $_SESSION['aid'] = $result['uuid'];
            
            return true;
        } else {
            // 密码错误
            return false;
        }
    }

    /**
    * 管理员登出
    * @return
    */
    public function logout() {
        // 清除session
        unset($_SESSION['admin_name']);
        unset($_SESSION[C('SESSION_AUTH_KEY_ADMIN')]);
        unset($_SESSION['aid']);
    }
}
