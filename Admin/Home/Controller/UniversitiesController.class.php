<?php
namespace Home\Controller;

/**
 * UniversitiesController
 */
class UniversitiesController extends CommonController {
    /**
     * 权限过滤
     * @return
     */
    public function _initialize() {
        parent::_initialize();
        $this->adminPowerFilter();
    }

    /**
     * 管理学校信息
     * @return
     */
    public function index() {
        $result = $this->pagination('University');

        $universities = $result['data'];
        unset($result['data']);
        // foreach ($categories as $key => $category) {
        //     $categories[$key]['goods_cnt'] = count($category['goods']);
        // }

        $this->assign('universities', $universities);
        $this->assign('page', $result['show']);
        $this->display();
    }

    /**
     * 添加学校信息
     * @return
     */
    public function create() {
        if (!isset($_POST['university'])) {
            $this->error('无效的操作！');
        }

        $University = D('University');
        $university = $University->create($_POST['university']);
        if (false === $University->add($university)) {
            $this->error('系统错误了！');
        }

        $this->redirect('Universities/index');
    }

    /**
     * 编辑学校信息
     * @return
     */
    public function edit() {
        if (!isset($_GET['university_id'])) {
            $this->error('您需要编辑的学校不存在！');
        }

        $university = M('University')->getById($_GET['university_id']);

        $this->assign('university', $university);
        $this->display();
    }

    /**
     * 更新学校信息
     * @return
     */
    public function update() {
        if (!isset($_POST['university'])
            || !isset($_POST['university_id'])) {
            $this->error('无效的操作！');
        }

        $where = array('id' => $_POST['university_id']);
        if (false === M('University')->where($where)
                                     ->save($_POST['university'])) {

            $this->error('系统出错了！');
        }

        $this->redirect('Universities/index');
    }

    /**
     * 学校删除
     * @return
     */
    public function destroy() {
        if (!isset($_GET['university_id'])) {
            $this->error('无效的操作！');
        }

        $flag = D('University')->where(array('id' => $_GET['university_id']))
                               ->delete();

        if (false === $flag) {
            $this->error('系统出错了！');
        }

        $this->redirect('Universities/index', array('p' => $_GET['p']));
    }
}
