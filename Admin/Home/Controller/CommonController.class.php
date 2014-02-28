<?php
namespace Home\Controller;

use Think\Controller;

/**
* CommonController
*/
class CommonController extends Controller {
    /**
    * 全局初始化
    * @return
    */
    public function _initialize() {
        // utf-8编码
        header('Content-Type: text/html; charset=utf-8');

        // 访问过滤
        $filter = array('Index', 'Public');
        if (!in_array(CONTROLLER_NAME, $filter)) {
            $this->accessFilter();
        }
    }

    /**
    * 空操作处理
    * @return
    */
    public function _empty() {
        $this->error('您访问的页面不存在！');
    }

    /**
    * 检查用户是否已经登陆
    * @return boolean
    */
    protected function hasLogin() {
        $authVal = md5($_SESSION['admin_name'] . C('COOKIE_NAME'));
        if (isset($_SESSION[C('SESSION_AUTH_KEY_ADMIN')])
            && ($_SESSION[C('SESSION_AUTH_KEY_ADMIN')] == $authVal)) {
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
            $this->error('请先进行登陆！', __MODULE__ . '/Index/index');
        }
    }

    /**
     * 管理员权限过滤
     * @return
     */
    protected function adminPowerFilter() {
        if (!isset($_SESSION['rank']) || $_SESSION['rank'] != 3) {
            $this->error('您没有权限查看该页！');
        }
    }

    /**
     * 设置token
     * @return
     */
    protected function assignToken() {
        $this->assign(C('TOKEN_NAME'), get_token(C('TOKEN_NAME')));
    }

    /**
     * 销毁token
     * @return
     */
    protected function destroyToken() {
        unset($_SESSION[C('TOKEN_NAME')]);
    }

    /**
     * 分页数据
     * @param  string $model
     * @return array
     */
    protected function pagination($model) {
        $service = D($model, 'Service');

        $totalCount = $service->getCount();
        $page = new \Org\Util\Page($totalCount, C('PAGINATION_NUM'));
        $result['show'] = $page->show();

        $data = $service->getPagination($page->firstRow, 
                                        $page->listRows);
        $result['data'] = $data;

        return $result;
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
