<?php
namespace Home\Controller;

/**
 * AdminsController
 */
class AdminsController extends CommonController {
    /**
     * 权限过滤
     * @return
     */
    public function _initialize() {
        parent::_initialize();

        $disfilter = array('edit', 'updatePassword');
        if ($_SESSION['rank'] == 1 && !in_array(ACTION_NAME, $disfilter)) {
            $this->adminPowerFilter();
        }
    }

    /**
     * 管理员
     * @return 
     */
    public function index(){
        $result = $this->pagination('Admin');

        // 取出被选过的楼房
        // $buildings = '';
        // foreach ($result['data'] as $item) {
        //     $buildings .= ',' . $item['buildings'];
        // }
        // $buildings = array_unique(explode(',', $buildings));

        // if ($_SESSION['rank'] == 2) {
        //     $buildings = D('Admin', 'Service')
        //                  ->getAdminBuildings($_SESSION['id']);
        //     $this->assign('building', $buildings[0]);
        // }

        // $this->assign('buildings', $buildings);
        $this->assign('page', $result['show']);
        $this->assign('admins', $result['data']);
        $this->display();
    }

    /**
     * 管理员信息
     * @return
     */
    public function show() {
        if (!isset($_GET['admin_id'])) {
            $this->error('您查看的管理员不存在！');
        }

        $adminService = D('Admin', 'Service');
        $admin = $adminService->getAdminDetail($_GET['admin_id']);
        if (empty($admin)) {
            $this->error('您查看的管理员不存在！');
        }

        $doOrders = $adminService->getAdminDoOrder($admin['id']);

        $this->assign('admin', $admin);
        $this->assign('orders', $admin['orders']);
        $this->assign('transactions', $admin['transactions']);
        $this->assign('doOrders', $doOrders);
        $this->display();
    }

    /**
     * 添加管理员
     * @return
     */
    public function create() {
        if (!isset($_POST['admin'])) {
            $this->error('无效的操作！');
        }

        $Admin = D('Admin');
        $admin = $_POST['admin'];
        $admin['buildings'] = implode(',', $admin['buildings']);
        // if ($admin['rank'] != 1) {
        //     // 不是分管理员则不能拥有楼房管理权限
        //     unset($admin['buildings']);
        // }

        if ($admin = $Admin->create($admin)) {
            if (false === $Admin->add($admin)) {
                $this->error('系统出错了！');
            } else {
                $this->redirect('Admins/index');
            }
        } else {
            $this->error(formatArrToStr($Admin->getError()));
        }
    }

    /**
     * 管理员更新
     * @return
     */
    public function update() {
        if (!isset($_GET['admin_id'])
            || !isset($_GET['operation'])) {
            $this->error('无效的操作！');
        }

        $adminService = D('Admin', 'Service');
        if ($_GET['operation'] == 'deactive') {
            if (false == $adminService->deactive($_GET['admin_id'])) {
                $this->error('系统出错了！');
            }
        } else if ($_GET['operation'] == 'active') {
            if (false == $adminService->active($_GET['admin_id'])) {
                $this->error('系统出错了！');
            }
        } else {
            $this->error('系统出错了！');
        }

        $this->redirect('Admins/index', array('p' => $_GET['p']));
    }

    /**
     * 修改密码
     * @return
     */
    public function edit() {
        $this->display();
    }

    /**
     * 修改密码
     * @return
     */
    public function updatePassword() {
        if (!isset($_POST['new_password'])
            || !isset($_POST['origin_password'])) {
            $this->error('无效的操作！');
        }

        $adminService = D('Admin', 'Service');
        $flag = $adminService->updatePassword($_POST['origin_password'],
                                              $_POST['new_password']);
        if ($flag == 0) {
            $this->error('原密码错误，请输入正确的原密码！');
        } else if (flag == -1) {
            $this->error('修改密码失败！');
        }

        $this->success('密码修改成功！');
    }

    /**
     * 转账
     * @return
     */
    public function transaction() {
        if (!isset($_GET['transaction_id'])) {
            $this->error('无效的操作！');
        }

        $Transaction = M('Transaction');
        $where['id'] = $_GET['transaction_id'];
        $transaction['is_transaction'] = 1;

        $flag = $Transaction->where($where)->save($transaction);
        if ($flag === false) {
            $this->error('系统出错了！');
        }

        $this->redirect('Admins/show', array('admin_id' => $_GET['admin_id']));
    }
}
