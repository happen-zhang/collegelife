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
    
    /**
     * 更新用户基本信息
     * @param  array  $data
     * @return array
     */
    public function updateMetaData(array $data) {
        $User = D('User');

        // 修改基础信息
        if ($user = $User->create($data, 2)) {
            // 清除password字段
            unset($user['password']);
            $flag = $User->where(array('uuid' => $data['uuid']))->save($user);
            if (false === $flag) {
                // 数据库错误
                return array('uid' => $data['uuid'], 'status' => 2);
            } else {
                // 修改成功
                return array('uid' => $data['uuid'], 'status' => 1);
            }
        } else {
            // 数据验证错误
            $errors = $this->formatUnvalidData($User->getError());
            return array('uid' => $data['uuid'], 
                         'status' => 3, 
                         'errors' => $errors);
        }
    }

    /**
     * 更新用户密码
     * @param  array $data 
     * @return array
     */
    public function updatePassword(array $data) {
        $User = D('User');

        // 判断原密码是否正确
        $orginPassword = sql_injection($data['origin_password']);
        $where['uuid'] = array('eq', $data['uuid']);
        $where['password'] = array('eq', md5($orginPassword));
        if (!$User->where($where)->find()) {
            $errors = $this->formatUnvalidData(array('原密码错误！'));
            return array('uid' => $data['uuid'], 
                         'status' => 3, 
                         'errors' => $errors);
        }
        
        // 更新密码
        if ($user = $User->create($data, 2)) {
            // 清除email、real_name字段，自动验证和完成产生
            unset($user['email'], $user['real_name']);
            $flag = $User->where(array('uuid' => $data['uuid']))->save($user);
            if (false === $flag) {
                // 数据库错误
                return array('uid' => $data['uuid'], 'status' => 2);
            } else {
                 // 修改成功
                return array('uid' => $data['uuid'], 'status' => 1);
            }
        } else {
            // 数据验证错误
            $errors = $this->formatUnvalidData($User->getError());
            return array('uid' => $data['uuid'], 
                         'status' => 3, 
                         'errors' => $errors);
        }
    }

    /**
     * Model::getError格式化为字符串
     * @param array $errors
     * @return string 
     */
    private function formatUnvalidData(array $errors) {
        $errorsStr =  implode(' ， ', $errors);
        return '[' . $errorsStr . ']';
    }    
}