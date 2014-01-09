<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 静态页面控制器
 */
class IndexController extends Controller {
    public function index(){
        // 只有在首页时才显示“登陆”和“注册”
        $this->assign('home', 'home');
        $this->display();
    }

    public function about() {
        $this->display();
    }

    public function contact() {
        $this->display();
    }

}