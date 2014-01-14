<?php
namespace Mobile\Controller;

/**
 * IndexController
 */
class IndexController extends \Home\Controller\IndexController {
    /**
     * 移动版首页
     * @return
     */
    public function index() {
        $this->display();
    }

    /**
     * 移动登陆页面
     * @return
     */
    public function login() {
        $this->display();
    }
}