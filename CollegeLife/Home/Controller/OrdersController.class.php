<?php
namespace Home\Controller;

/**
* OrdersController
*/
class OrdersController extends CommonController {
    /**
     * _initialize
     * @return
     */
    public function _initialize() {
        parent::_initialize();

        // 购买产品页不需过滤
        if (ACTION_NAME != 'build') {
            $this->accessFilter();
        }

        $this->assign('ctrl_name', 'Order');
    }

    /**
    * 用户订单列表
    * @return
    */
    public function index() {
        if (!isset($_SESSION['uid'])) {
            $this->error('无效的操作！');
        }

        $orders = D('Order', 'Service')->getUserOrders($_SESSION['uid']);
        $this->assignToken();
        $this->assign('orders', $orders);
        $this->display();
    }

    /**
     * 显示单个订单信息
     * @return
     */
    public function show() {
        if (!isset($_GET['order_id'])) {
            $this->error("您指定的订单号不存在！");
        }

        $order = D('Order', 'Service')->getOrderDetail($_GET['order_id']);
        if (is_null($order)) {
            $this->error("您指定的订单号不存在！");
        }

        $this->assign('order', $order);
        $this->assign('goods', $order['goods']);
        $this->display();
    }

    /**
    * 商品下订单
    * @return
    */
    public function build() {
        $this->display();
    }

    public function create() {
        
    }

    public function edit() {

    }

    /**
     * RESTful destroy
     * @return
     */
    public function destory() {
        if (!isset($_GET['order_id']) || !isset($_GET['hash'])
            || !isset($_SESSION['uid'])
            || $_SESSION[C('TOKEN_NAME')] != $_GET['hash']) {
            $this->error('无效的操作！');
        }

        $uuid = sql_injection($_GET['order_id']);
        $flag = M('Order')->where(array('uuid' => $uuid))->delete();
        if (false === $flag) {
            // 操作失败
            $this->redirect('Orders/index', array('status' => 2));
        }

        // 操作成功
        $this->redirect('Orders/index', array('status' => 1));
    }
}