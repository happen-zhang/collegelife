<?php
namespace Home\Controller;

use Think\Controller;

/**
* PublicController
*/
class PublicController extends CommonController {
    /**
    * 管理员登录
    * @return
    */
    public function login() {
        $this->unvalidFormReq();

        $adminService = D('Admin', 'Service');
        if (true == $adminService->login($_POST['admin'])) {
            $this->redirect('Orders/index');
        } else {
            $this->error('登录失败，管理员账号或者密码错误！');
        }
    }

    /**
    * 用户登出
    * @return
    */
    public function logout() {
        $this->accessFilter();

        // 用户登出
        D('Admin', 'Service')->logout();
        $this->success('登出成功！', U('Index/index'));
    }
}
