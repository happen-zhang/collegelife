<?php
namespace Home\Controller;

use Think\Controller;

/**
 * 
 */
class IndexController extends CommonController {
    /**
     * 后台登陆页
     * @return
     */
    public function index(){
        if (isset($_SESSION['aid'])) {
            $this->redirect('Orders/index');
        }

        layout(false);
        $this->assignToken();
        $this->display();
    }
}
