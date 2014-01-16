<?php
namespace Home\Controller;

use Think\Controller;

/**
 * 
 */
class IndexController extends Controller {
    /**
     * 后台登陆页
     * @return
     */
    public function index(){
    	layout(false);
        $this->display();
    }
}