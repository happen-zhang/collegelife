<?php
namespace Home\Controller;

/**
 * 
 */
class OrdersController extends CommonController {
    /**
     * 访问过滤
     * @return 
     */
    public function _initialize() {
        $this->accessFilter();
    }

    /**
     * 订单管理页
     * @return
     */
    public function index(){
        $this->display();
    }
}
