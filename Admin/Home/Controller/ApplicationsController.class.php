<?php
namespace Home\Controller;

/**
 * ApplicationsController
 */
class ApplicationsController extends CommonController {
    /**
     * 权限过滤
     * @return
     */
    public function _initialize() {
        parent::_initialize();

        if ($_SESSION['rank'] == 3) {
            $this->error('您不可以访问该页面！');
        }
    }
        
    /**
     * 申请货款
     * @return
     */
    public function index(){
        $result = $this->pagination('Apply');
        $adminService = D('Admin', 'Service');

        $goods = M('Goods')->field(array('id', 'name'))->select();
        $applies = $adminService->getApplies($_SESSION['id']);

        $this->assign('goods', $goods);
        $this->assign('applies', $result['data']);
        $this->assign('page', $result['show']);
        $this->display();
    }

    /**
     * 申请货款
     * @return
     */
    public function create() {
        if (!isset($_POST['apply'])) {
            $this->error('无效的操作！');
        }

        $Apply = D('Apply');
        $apply = $Apply->create($_POST['apply']);
        if (false === $Apply->add($apply)) {
            $this->error('系统出错了！');
        }

        $this->redirect('Applications/index');
    }

    /**
     * 处理货款
     * @return
     */
    public function edit() {
        if ($_SESSION['rank'] != 2) {
            $this->error('您不可以访问该页面！');
        }

        $adminService = D('Admin', 'Service');
        $applyService = D('Apply', 'Service');

        $fields = array('id');
        $building = $adminService->getAdminBuildings($_SESSION['id']);
        $admins = $adminService->getAdminsByBuilding($building[0], $fields);
        foreach ($admins as $admin) {
            $adminIds .= $admin['id'] . ',';
        }
        
        $applies = $applyService->getAppliesByAdminIds($adminIds);

        $this->assign('applies', $applies);
        $this->display();
    }

    /**
     * 处理货款
     * @return
     */
    public function update() {
        if (!isset($_GET['apply_id'])) {
            $this->error('无效的操作！');
        }

        $Apply = M('Apply');
        $where['id'] = $_GET['apply_id'];
        $apply['is_delivey'] = 1;

        $flag = $Apply->where($where)->save($apply);
        if ($flag === false) {
            $this->error('系统出错了！');
        }

        $this->redirect('Applications/edit', array('p' => $_GET['p']));        
    }
}
