<?php
namespace Home\Controller;

/**
 * UsersController
 */
class UsersController extends CommonController {
    public function _initialize() {
        parent::_initialize();

        if (ACTION_NAME != 'create') {
            // 注册用户不需访问过滤
            $this->accessFilter();
        }
    }

    /**
     * 用户登陆成功操作
     * @return
     */
    public function index() {
        $this->display();
    }

    /**
     * RESTful create
     * @return
     */
    public function create() {
        // 是否有效的请求表单
        $this->unvalidFormReq();

        // var_dump($_POST);
        $User = D('User');
        if ($user = $User->create($_POST['user'])) {
            if ($User->add($user)) {
                // 注册成功，用户登录
                D('User', 'Service')->login($user);
                // 提示注册成功，重定向到首页
                $this->success('注册成功，3秒后回到首页！', 'Index/index');
            } else {
                // 数据库错误
                $this->error($User->getDbError());
            }
            // var_dump($user);
        } else {
            // 数据正确
            $this->error(var_export($User->getError(), false));
        }
    }

    /**
     * RESTful edit
     * @return
     */
    public function edit() {
        $this->display();
    }

    public function update() {
        $u = D('User', 'Service');
        $u->login();
    }
}