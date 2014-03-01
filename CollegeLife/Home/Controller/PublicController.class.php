<?php
namespace Home\Controller;

/**
* PublicController
*/
class PublicController extends CommonController {
    /**
    * 用户登录
    * @return
    */
    public function login() {
        $this->unvalidFormReq();

        $userService = D('User', 'Service');
        if (true == $userService->login($_POST['user'])) {
            $this->redirect('Users/index');
        } else {
            $this->error('登录失败，用户名或者密码错误！', 'Index/index');
        }
    }

    /**
    * 用户登出
    * @return
    */
    public function logout() {
        $this->accessFilter();

        // 用户登出
        D('User', 'Service')->logout();
        $this->success('登出成功！', U('Index/index'));
    }

    public function test() {
        
    }
}
