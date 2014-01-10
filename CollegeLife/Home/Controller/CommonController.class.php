<?php
namespace Home\Controller;

use Think\Controller;

/**
* CommonController
*/
class CommonController extends Controller {
    /**
    * utf-8编码
    * @return
    */
    public function _initialize() {
        header('Content-Type: text/html; charset=utf-8');
    }

    /**
    * 空操作处理
    * @return
    */
    public function _empty() {
        $this->redirect('Index/index');
    }

    /**
    * 检查用户是否已经登陆
    * @return boolean
    */
    protected function hasLogin() {
        $authVal = md5($_SESSION['username'] . C('COOKIE_NAME'));
        if (isset($_SESSION[C('SESSION_AUTH_KEY_NAME')])
            && ($_SESSION[C('SESSION_AUTH_KEY_NAME')] == $authVal)) {
            return true;
        } else {
            return false;
        }
    }

    /**
    * 登录访问过滤
    * @return
    */
    protected function accessFilter() {
        if (!$this->hasLogin()) {
            $this->error('请先进行登陆！');
        }
    }

    /**
    * 检查是否有效的站内表单请求
    * 否则重定向到首页
    * @return boolean
    */
    protected function unvalidFormReq() {
        if (empty($_POST)
            || !is_valid_token(C('TOKEN_NAME'), $_POST[C('TOKEN_NAME')])) {
            $this->redirect('Index/index');
        }
    }
}