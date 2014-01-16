<?php
namespace Home\Controller;

/**
 * 
 */
class UsersController extends CommonController {
    /**
     * 访问过滤
     * @return 
     */
    public function _initialize() {
        $this->accessFilter();
    }

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
