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
        $adminService = D('Admin', 'Service');

        $goods = M('Goods')->field(array('id', 'name'))->select();
        $applies = $adminService->getApplies($_SESSION['id']);

        $this->assign('goods', $goods);
        $this->assign('applies', $applies);
        $this->display();
    }

    /**
     * 商品详情
     * @return
     */
    public function show() {

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
}
