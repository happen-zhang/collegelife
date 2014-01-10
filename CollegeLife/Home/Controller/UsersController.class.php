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

        $uuid = sql_injection($_POST['uid']);
        $data = $_POST['user'];
        $User = D('User');
        // 表单信息
        if ($_POST['info'] == 'metadata') {
            // 修改基础信息
            if ($user = $User->create($data, 2)) {
                // 清除password字段
                unset($user['password']);
                $flag = $User->where(array('uuid' => $uuid))->save($user);
                if (false === $flag) {
                    // 数据库错误
                    // $this->error(var_export($User->getDbError(), false));
                    $this->afterUpdateRect(array('uid' => $uuid, 
                                                 'status' => 2));
                } else {
                    // 修改成功，重定向到用户编辑页
                    $this->afterUpdateRect(array('uid' => $uuid, 
                                                 'status' => 1));
                }
            } else {
                // 数据验证错误
                // $this->error(var_export($User->getError(), false));
                $errors = $this->formatUnvalidData($User->getError());
                $this->afterUpdateRect(array('uid' => $uuid, 
                                             'status' => 3, 
                                             'errors' => $errors));
            }
        } else if ($_POST['info'] == 'password'){
            // 修改密码信息
            // 判断原密码是否正确
            $orginPassword = $_POST['user']['origin_password'];
            $orginPassword = sql_injection($orginPassword);
            $where['uuid'] = array('eq', $uuid);
            $where['password'] = array('eq', md5($orginPassword));
            if (!$User->where($where)->find()) {
                $errors = $this->formatUnvalidData(array('原密码错误！'));
                $this->afterUpdateRect(array('uid' => $uuid, 
                                              'status' => 3, 
                                              'errors' => $errors));
            }
            
            // 更新密码
            if ($user = $User->create($_POST['user'], 2)) {
                // 清除email、real_name字段，自动验证和完成产生
                unset($user['email'], $user['real_name']);
                $flag = $User->where(array('uuid' => $uuid))->save($user);
                if (false === $flag) {
                    // 数据库错误
                    $this->afterUpdateRect(array('uid' => $uuid, 
                                                 'status' => 2));                   
                } else {
                     // 修改成功，重定向到用户编辑页
                    $this->afterUpdateRect(array('uid' => $uuid, 
                                                  'status' => 1));                   
                }
            } else {
                // 数据验证错误
                $errors = $this->formatUnvalidData($User->getError());
                $this->afterUpdateRect(array('uid' => $uuid, 
                                             'status' => 3, 
                                             'errors' => $errors));               
            }
        }

        // 请求的表单无效
        $this->afterUpdateRect(array('uid' => $uuid));
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

    /**
     * 更新状态跳转
     * @return
     */
    private function afterUpdateRect(array $params) {
        return $this->redirect('Users/edit', $params);
    }
}