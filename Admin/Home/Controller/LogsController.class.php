<?php
namespace Home\Controller;

/**
 * 
 */
class LogsController extends CommonController {
    /**
     * 日志管理
     * @return
     */
    public function index(){
        $this->display();
    }

    /**
     * 订单统计
     * @return [type] [description]
     */
    public function order() {
        $orderService = D('Order', 'Service');

        $processeds = $orderService->getProcessedOrders(0, 1000, array('id', 'uuid', 'payment', 'payment_at'));
        $nprocesseds = $orderService->getnProcessedOrders(0, 1000, array('id', 'uuid', 'confirm_status'));

        $processedsCnt = $orderService->processedOrdersCount();
        $nprocessedsCnt = $orderService->nprocessedOrdersCount();

        $this->assign('processeds', $processeds);
        $this->assign('nprocesseds', $nprocesseds);
        $this->assign('processedsCnt', $processedsCnt);
        $this->assign('nprocessedsCnt', $nprocessedsCnt);
        $this->display();
    }

    /**
     * 访问统计
     * @return
     */
    public function ip() {
        $result = $this->pagination('Visitor');

        $this->assign('page', $result['show']);
        $this->assign('visitors', $result['data']);
        $this->display();
    }
}
