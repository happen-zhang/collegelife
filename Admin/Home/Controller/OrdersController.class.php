<?php
namespace Home\Controller;

use Think\Controller;

/**
 * 
 */
class OrdersController extends Controller {
    /**
     * 订单管理页
     * @return
     */
    public function index(){
        $this->display();
    }
}