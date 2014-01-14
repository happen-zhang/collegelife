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
    	$this->display();
    }

    /**
     * 用户信息
     * @return
     */
    public function show() {
    	$this->display();
    }
}