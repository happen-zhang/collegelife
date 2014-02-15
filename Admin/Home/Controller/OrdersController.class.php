<?php
namespace Home\Controller;

/**
 * OrdersController
 */
class OrdersController extends CommonController {
    /**
     * 订单管理页
     * @return
     */
    public function index(){
        $orderService = D('Order', 'Service');
        $adminService = D('Admin', 'Service');

        $result = $orderService->getCount();
        $result = $this->pagination('Order');

        $orders = $result['data'];

        foreach ($orders as $key => $order) {
            $building = $order['user']['building_no'];
            if ($order['confirm_status'] == 2) {
                // if ($_SESSION['rank'] == 3) {
                //     // 总管理员确认信息
                //     $senior = $adminService->getSeniorByBuilding($building);
                //     $orders[$key]['senior'] = $senior;
                // }

                if ($_SESSION['rank'] == 2) {
                    // 总管理员选择分管理员
                    // $admins = $adminService
                    //            ->getOneAdminsByBuilding($building, 1);
                    $admins = $adminService->findByRank(1);

                    foreach ($admins as $admin) {
                        $orders[$key]['admin_names'][] = $admin['admin_name'];
                        $orders[$key]['admin_uuids'][] = $admin['uuid'];
                    }
                }
            }

            // 分管理确认信息
            if ($order['confirm_status'] == 1) {
                $orders[$key]['assigner'] = $adminService
                                             ->findById($order['assign_to']);
            }
        }

        $this->assign('page', $result['show']);
        $this->assign('orders', $orders);
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

        // 订单日志
        $doOrders = $orderService->getAdminDoOrder($_GET['order_id']);

        $this->assign('order', $order);
        $this->assign('goods', $order['goods']);
        $this->assign('doOrders', $doOrders);
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

        $doStatus = '取消订单';
        D('Order', 'Service')->orderLog($_GET['order_id'], $doStatus);

        $Order = M('Order');
        $where['uuid'] = $_GET['order_id'];
        if (false === $Order->where($where)->delete()) {
            $this->error('系统出错了！');
        }

        $this->redirect('Orders/index', array('p' => $_GET['p']));
    }

    /**
     * 总部确认订单
     * @return
     */
    public function confirmOrder() {
        if (!isset($_GET['order_id'])) {
            $this->error('无效的操作！');
        }

        $orderService = D('Order', 'Service');
        if (false === $orderService->confirm($_GET['order_id'], 2)) {
            $this->error('系统出错了！');
        }

        $this->redirect('Orders/index', array('p' => $_GET['p']));
    }

    /**
     * 总管理员分配订单给分管理员
     * @return
     */
    public function assignOrder() {
        if (!isset($_GET['order_id'])
            || !isset($_GET['assign_to'])) {
            $this->error('无效的操作！');
        }

        $orderService = D('Order', 'Service');
        if ($orderService->assignTo($_GET['order_id'], $_GET['assign_to'])
            === false) {
            $this->error('系统出错了！');
        }

        if (false === $orderService->confirm($_GET['order_id'], 1)) {
            $this->error('系统出错了！');
        }

        $this->redirect('Orders/index', array('p' => $_GET['p']));
    }
}
