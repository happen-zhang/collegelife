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
        foreach ($universities as $key => $university) {
            $where['university_id'] = $university['id'];
            $where['rank'] = 1;
            $subAdminCnt = M('Admin')->where($where)->count();

            $where['rank'] = 2;
            $seniorAdminCnt = M('Admin')->where($where)->count();

            $universities[$key]['sub_cnt'] = $subAdminCnt;
            $universities[$key]['sen_cnt'] = $seniorAdminCnt;
        }

        $this->assign('universities', $universities);
        $this->assign('page', $result['show']);
        $this->display();
    }

    /**
     * 院校管理员信息
     * @return
     */
    public function show() {
        if (!isset($_GET['rank']) || !isset($_GET['university_id'])) {
            $this->error('您查看的院校不存在！');
        }

        $where['university_id'] = $_GET['university_id'];
        $university = M('University')->where($where)->find();

        $Admin = M('Admin');
        $where['rank'] = $_GET['rank'];
        $totalCount = $Admin->where($where)->count();
        $page = new \Org\Util\Page($totalCount, C('PAGINATION_NUM'));
        $result['show'] = $page->show();
        $data = $Admin->where($where)
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
        $result['data'] = $data;

        if (empty($data)) {
            $this->error('您查看的院校暂无信息！');
        }

        $this->assign('university', $university);
        $this->assign('admins', $result['data']);
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
