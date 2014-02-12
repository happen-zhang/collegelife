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
     * @return
     */
    public function order() {
        $orderService = D('Order', 'Service');
        $adminService = D('Admin', 'Service');

        $fields = array('id', 'uuid', 'user_id',
                        'payment','payment_at',
                        'assign_to', 'confirm_status');

        $presult = $orderService->processedOrdersPage($fields);
        $npresult = $orderService->nprocessedOrdersPage($fields);

        $processeds = $presult['data'];
        $nprocesseds = $npresult['data'];
        $processedsCnt = $orderService->processedOrdersCount();
        $nprocessedsCnt = $orderService->nprocessedOrdersCount();

        // 待处理等待订单
        foreach ($nprocesseds as $key => $nprocessed) {
            if ($nprocessed['confirm_status'] == 2) {
                $nprocesseds[$key]['senior'] = $adminService
                 ->getSeniorByBuilding($nprocessed['user']['building_no']);
            } else if ($nprocessed['confirm_status'] == 1) {
                $nprocesseds[$key]['assigner'] = $adminService
                 ->findById($nprocessed['assign_to']);
            }
        }

        $this->assign('processeds', $processeds);
        $this->assign('nprocesseds', $nprocesseds);
        $this->assign('processedsCnt', $processedsCnt);
        $this->assign('nprocessedsCnt', $nprocessedsCnt);
        $this->assign('p_page', $presult['show']);
        $this->assign('np_page', $npresult['show']);
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
