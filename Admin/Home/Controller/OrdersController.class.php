<?php
namespace Home\Controller;

/**
 * 
 */
class OrdersController extends CommonController {
    /**
     * 订单管理页
     * @return
     */
    public function index(){
        $result = $this->pagination('Order');

        $this->assign('page', $result['show']);
        $this->assign('orders', $result['data']);
        $this->display();
    }

    /**
     * 订单详情
     * @return
     */
    public function show() {
        if (!isset($_GET['order_id'])) {
            $this->error('您查看的订单不存在！');
        }

        $orderService = D('Order', 'Service');
        $order = $orderService->getOrderDetail($_GET['order_id']);
        if (empty($order)) {
            $this->error('您查看的订单不存在！');
        }

        $this->assign('order', $order);
        $this->assign('goods', $order['goods']);
        $this->display();
    }

    /**
     * 订单更新
     * @return
     */
    public function update() {
        if (!isset($_GET['order_id'])
            || !isset($_GET['operation'])) {
            $this->error('无效的操作！');
        }

        $uuid = $_GET['order_id'];
        $orderService = D('Order', 'Service');
        if ($_GET['operation'] == 'consignment') {
            if (false == $orderService->consignOrder($uuid)) {
                $this->error('系统出错了！');
            }
        } else if ($_GET['operation'] == 'collect') {
            if (false == $orderService->payOrder($uuid)) {
              $this->error('系统出错了！');
            }
        } else {
            $this->error('无效的操作！');
        }

        $this->redirect('Orders/index', array('p' => $_GET['p']));
    }

    /**
     * 取消订单
     * @return
     */
    public function destroy() {
        if (!isset($_GET['order_id'])) {
            $this->error('无效的操作！');
        }

        $Order = M('Order');
        $where['uuid'] = $_GET['order_id'];
        if (false === $Order->where($where)->delete()) {
            $this->error('系统出错了！');
        }

        $this->redirect('Orders/index', array('p' => $_GET['p']));
    }
}
