<?php
namespace Home\Controller;

/**
 * 
 */
class SuggestionsController extends CommonController {
    /**
     * 访问过滤
     * @return 
     */
    public function _initialize() {
        $this->accessFilter();
    }

    /**
     * 建议管理
     * @return [type] [description]
     */
    public function index(){
        $this->display();
    }
}
