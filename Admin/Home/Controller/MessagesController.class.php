<?php
namespace Home\Controller;

/**
 * MessagesController
 */
class MessagesController extends CommonController {
    /**
     * 通知管理
     * @return
     */
    public function index(){
        $result = $this->pagination('Message');

        $this->assign('page', $result['show']);
        $this->assign('messages', $result['data']);
        $this->display();
    }

    /**
     * 添加通知
     * @return
     */
    public function create() {
        if (!isset($_POST['message'])) {
            $this->error('无效的操作！');
        }

        $Message = D('Message');
        $message = $Message->create($_POST['message']);
        if (false === $Message->add($message)) {
            $this->error('系统错误了！');
        }

        $this->redirect('Messages/index');
    }

    /**
     * 删除通知
     * @return
     */
    public function destroy() {
        if (!isset($_GET['message_id'])) {
            $this->error('无效的操作！');
        }

        $Message = M('Message');
        $where['id'] = $_GET['message_id'];
        if (false === $Message->where($where)->delete()) {
            $this->error('系统出错了！');
        }

        $this->redirect('Messages/index', array('p' => $_GET['p']));
    }
}
