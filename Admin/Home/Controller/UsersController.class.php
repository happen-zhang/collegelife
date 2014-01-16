<?php
namespace Home\Controller;

use Think\Controller;

/**
 * 
 */
class UsersController extends Controller {
    /**
     * 用户管理页
     * @return
     */
    public function index(){
        $this->display();
    }

    /**
     * 用户详情页
     * @return
     */
    public function show() {
        $this->display();
    }
}