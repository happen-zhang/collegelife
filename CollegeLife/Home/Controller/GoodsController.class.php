<?php
namespace Home\Controller;

/**
* GoodsController
*/
class GoodsController extends CommonController {
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

        $this->assign('ctrl_name', 'Goods');
    }

    /**
    * 用户订单列表
    * @return
    */
    public function index() {
        $this->display();
    }

    /**
    * 用户单个订单信息
    * @return
    */
    public function show() {
        $this->display();
    }

    /**
    * 商品购买
    * @return
    */
    public function build() {
        $this->display();
    }

    public function create() {

    }

    public function edit() {

    }

    public function destory() {

    }
}