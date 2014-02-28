<?php
namespace Home\Controller;

/**
 * UsersController
 */
class UsersController extends CommonController {
    /**
     * 用户管理页
     * @return
     */
    public function index(){
        $result = $this->pagination('User');

        $this->assign('page', $result['show']);
        $this->assign('users', $result['data']);
        $this->display();
    }

    /**
     * 用户详情页
     * @return
     */
    public function show() {
        if (!isset($_GET['user_id'])) {
            $this->error('您查看的用户不存在！');
        }

        $user = D('User', 'Service')->getUserDetail($_GET['user_id']);
        if (empty($user)) {
            $this->error('您查看的用户不存在！');
        }
        
        $this->assign('user', $user);
        $this->assign('orders', $user['orders']);
        $this->display();
    }

    /**
     * 用户更新
     * @return
     */
    public function update() {
        if (!isset($_GET['user_id'])
            || !isset($_GET['operation'])) {
            $this->error('无效的操作！');
        }

        $userService = D('User', 'Service');
        if ($_GET['operation'] == 'deactive') {
            if (false == $userService->deactive($_GET['user_id'])) {
                $this->error('系统出错了！');
            }
        } else if ($_GET['operation'] == 'active') {
            if (false == $userService->active($_GET['user_id'])) {
                $this->error('系统出错了！');
            }
        } else {
            $this->error('系统出错了！');
        }

        $this->redirect('Users/index', array('p' => $_GET['p']));
    }

    /**
     * 修改密码
     * @return
     */
    public function editPassword() {
        if (!isset($_GET['user_id'])) {
            $this->error('您需要操作的用户不存在！');
        }

        $user = M('User')->getByUuid($_GET['user_id']);

        $this->assign('user', $user);
        $this->display('edit_password');
    }

    /**
     * 更新密码
     * @return
     */
    public function updatePassword() {
        if (!isset($_POST['user_id'])
            || !isset($_POST['new_password'])) {
            $this->error('无效的操作！');
        }

        $userService = D('User', 'Service');
        $flag = $userService->updatePassword($_POST['user_id'],
                                             $_POST['new_password']);
        if (false === $flag) {
            $this->error('系统出错了！');
        }

        $this->success('密码修改成功！');
    }
}
