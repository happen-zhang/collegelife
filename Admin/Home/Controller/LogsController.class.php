<?php
namespace Home\Controller;

/**
 * 
 */
class LogsController extends CommonController {
    /**
     * 访问过滤
     * @return 
     */
    public function _initialize() {
        $this->accessFilter();
    }

    /**
     * 日志管理
     * @return
     */
    public function index(){
        $this->display();
    }
}
