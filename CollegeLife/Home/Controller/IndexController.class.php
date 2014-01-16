<?php
namespace Home\Controller;

/**
* 静态页面控制器
*/
class IndexController extends CommonController {
    /**
     * 首页
     * @return
     */
    public function index(){
        // 只有在首页时才显示“登陆”和“注册”
        $this->assign('home', 'home');
        $this->assignToken();
        $this->display('index');
    }

    /**
    * 商城
    * @return
    */
    public function shopCenter() {
        // 关键字
        if (isset($_GET['keyword'])
            && ($keyword = sql_injection($_GET['keyword'])) != '商品名称') {
            $goods = D('Goods', 'Service')->getGoodsByKeyword($keyword);
        }

        // 进行分类
        if (!isset($goods) && isset($_GET['category_id'])) {
            // 需要分类
            $currentCategory = D('Category', 'Service')
                                ->getCategory($_GET['category_id']);
        }

        // 不进行分类或者是分类不存在的情况
        if (!isset($goods)
            && (!isset($currentCategory) || empty($currentCategory))) {
            $currentCategory = D('Category')->find();
        }

        // 如果不是关键字查询，则进行获取分类商品
        if (!isset($goods)) {
            $goods = D('Goods', 'Service')
                      ->getGoodsByCategoryId($currentCategory['id']);   
        }

        // 获取所有分类
        $categories = M('Category')->field(array('uuid', 'name'))->select();

        $this->assign('categories', $categories);
        $this->assign('current_category', $currentCategory);
        $this->assign('goods', $goods);
        $this->display('shop_center');
    }

    /**
    * 关于大学时光
    * @return
    */
    public function about() {
        $this->display();
    }

    /**
    * 联系我们
    * @return
    */
    public function contact() {
        $this->assignToken();
        $this->display();
    }
}