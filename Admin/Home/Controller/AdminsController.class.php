<?php
namespace Home\Controller;

/**
 * 
 */
class AdminsController extends CommonController {
    /**
     * 访问过滤
     * @return 
     */
    public function _initialize() {
        $this->accessFilter();
    }

    /**
     * 管理员
     * @return 
     */
    public function index(){
        $this->display();
    }

    /**
     * 管理员信息
     * @return
     */
    public function show() {
        $this->display();
    }
}
