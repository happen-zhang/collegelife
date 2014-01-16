<?php
namespace Home\Controller;

/**
 * 
 */
class GoodsController extends CommonController {
    /**
     * 访问过滤
     * @return 
     */
    public function _initialize() {
        $this->accessFilter();
    }
    
    /**
     * 商品管理
     * @return
     */
    public function index(){
        $this->display();
    }
}
