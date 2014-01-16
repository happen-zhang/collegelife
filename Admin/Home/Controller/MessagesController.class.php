<?php
namespace Home\Controller;

/**
 * 
 */
class MessagesController extends CommonController {
    /**
     * 访问过滤
     * @return 
     */
    public function _initialize() {
        $this->accessFilter();
    }

    /**
     * 通知管理
     * @return
     */
    public function index(){
        $this->display();
    }
}
