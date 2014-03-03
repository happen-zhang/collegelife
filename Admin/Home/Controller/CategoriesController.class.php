<?php
namespace Home\Controller;

/**
 * CategoriesController
 */
class CategoriesController extends CommonController {
    /**
     * 权限过滤
     * @return
     */
    public function _initialize() {
        parent::_initialize();
        $this->adminPowerFilter();
    }

    /**
     * 分类管理
     * @return
     */
    public function index() {
        $Goods = M('Goods');
        $result = $this->pagination('Category');

        $categories = $result['data'];
        unset($result['data']);
        foreach ($categories as $key => $category) {
            $categories[$key]['goods_cnt'] = count($category['goods']);
        }

        $this->assign('categories', $categories);
        $this->assign('page', $result['show']);
        $this->display();
    }

    /**
     * 分类添加
     * @return
     */
    public function create() {
        if (!isset($_POST['category'])) {
            $this->error('无效的操作！');
        }

        $Category = D('Category');
        $category = $Category->create($_POST['category']);
        if (false === $Category->add($category)) {
            $this->error('系统错误了！');
        }

        $this->redirect('Categories/index');
    }

    /**
     * 分类编辑
     * @return
     */
    public function edit() {
        if (!isset($_GET['category_id'])) {
            $this->error('您需要编辑的分类不存在！');
        }

        $category = M('Category')->getByUuid($_GET['category_id']);

        $this->assign('category', $category);
        $this->display();
    }

    /**
     * 分类更新
     * @return
     */
    public function update() {
        if (!isset($_POST['category'])
            || !isset($_POST['category_id'])) {
            $this->error('无效的操作！');
        }

        $where = array('uuid' => $_POST['category_id']);
        if (false === M('Category')->where($where)
                                   ->save($_POST['category'])) {

            $this->error('系统出错了！');
        }

        $this->redirect('Categories/index');
    }

    /**
     * 分类删除
     * @return
     */
    public function destroy() {
        if (!isset($_GET['category_id'])) {
            $this->error('无效的操作！');
        }

        $flag = D('Category')->where(array('uuid' => $_GET['category_id']))
                             ->delete();

        if (false === $flag) {
            $this->error('系统出错了！');
        }

        $this->redirect('Categories/index', array('p' => $_GET['p']));
    }
}
