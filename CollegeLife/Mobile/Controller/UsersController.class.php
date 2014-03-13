<?php
namespace Mobile\Controller;

/**
 * UsersController
 */
class UsersController extends \Home\Controller\UsersController {
    /**
     * 用户注册
     * @return
     */
    public function build() {
        $universities = M('University')->select();

        $this->assignToken();
        $this->assign('universities', $universities);
        $this->display();
    }

    /**
     * RESTful create
     * @return
     */
    public function create() {
        // 是否有效的请求表单
        $this->unvalidFormReq();

        $User = D('User');
        if ($user = $User->create($_POST['user'])) {
            if ($User->add($user)) {
                // 注册成功，用户登录
                D('User', 'Service')->login($_POST['user']);
                // 无效token
                $this->destroyToken();
                $this->redirect('Index/index');
            } else {
                // 数据库错误
                $this->redirect('Users/build', array('status' => 2));
            }
        } else {
            // 数据验证错误
            $this->redirect('Users/build', array('status' => 1));
        }
    }

    /**
     * 用户信息
     * @return
     */
    public function show() {
        $user = D('User', 'Service')->getUserByUuid($_SESSION['uid']);
        $this->assign('user', $user);
        $this->display();
    }
}
