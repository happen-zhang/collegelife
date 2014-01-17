<?php
namespace Home\Controller;

/**
 * 
 */
class GoodsController extends CommonController {
    /**
     * 商品管理
     * @return
     */
    public function index(){
        $this->display();
    }

    /**
     * 商品详情
     * @return
     */
    public function show() {
        $this->display();
    }
}
