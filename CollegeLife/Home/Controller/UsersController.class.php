<?php
namespace Home\Controller;

/**
* UsersController
*/
class UsersController extends CommonController {
    /**
     * _initialize
     * @return 
     */
    public function _initialize() {
        parent::_initialize();

        // 需要登陆才能操作的ACTION_NAME
        $filterActions = array('index', 'edit', 'update');
        if (true == in_array(ACTION_NAME, $filterActions)) {
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

        $User = D('User');
        if ($user = $User->create($_POST['user'])) {
            if ($User->add($user)) {
                // 注册成功，用户登录
                D('User', 'Service')->login($_POST['user']);
                // 提示注册成功，重定向到登陆页
                // $this->success('注册成功，3秒后回到首页！', 'index/status/', 3);
                $this->redirect('Users/index', array('status' => 'regist'));
            } else {
                // 数据库错误
                $this->error($User->getDbError());
            }
        } else {
            // 数据验证错误
            $this->error(var_export($User->getError(), false));
        }
    }

    /**
    * RESTful edit
    * @return
    */
    public function edit() {
        if (!isset($_GET['uid'])) {
            $this->error('您指定的用户不存在！');
        }
        
        $uuid = sql_injection($_GET['uid']);
        $User = M('User');
        $user = $User->where(array('uuid' => $uuid))->find();

        if ($user) {
            // 生成用户信息和token
            $this->assign(C('TOKEN_NAME'), get_token(C('TOKEN_NAME')));
            $this->assign('user', $user);
            $this->display();
        } else {
            $this->error('您指定的用户不存在！');
        }
    }

    /**
     * RESTful update
     * @return
     */
    public function update() {
        // 无效的表单请求
        $this->unvalidFormReq();
        if (!isset($_POST['uid']) || !isset($_POST['info'])) {
            $this->redirect('Index/index');
        }

        $data = $_POST['user'];
        $data['uuid'] = sql_injection($_POST['uid']);
        $userService = D('User', 'Service');

        // 表单信息
        if ($_POST['info'] == 'metadata') {
            $this->afterUpdateRect($userService->updateMetaData($data));
        } else if ($_POST['info'] == 'password'){
            $this->afterUpdateRect($userService->updatePassword($data));
        }

        // 请求的表单无效
        $this->afterUpdateRect(array('uid' => $data['uuid']));
    }

    /**
     * 更新状态跳转
     * @return
     */
    private function afterUpdateRect(array $params) {
        return $this->redirect('Users/edit', $params);
    }
}