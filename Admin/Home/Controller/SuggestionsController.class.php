<?php
namespace Home\Controller;

/**
 * SuggestionsController
 */
class SuggestionsController extends CommonController {
    /**
     * 建议管理
     * @return
     */
    public function index(){
        $result = $this->pagination('Suggestion');

        $this->assign('page', $result['show']);
        $this->assign('suggestions', $result['data']);
        $this->display();
    }

    /**
     * 删除建议
     * @return
     */
    public function destroy() {
        if (!isset($_GET['suggestion_id'])) {
            $this->error('无效的操作！');
        }

        $Suggestion = M('Suggestion');
        $where['id'] = $_GET['suggestion_id'];
        if (false === $Suggestion->where($where)->delete()) {
            $this->error('系统出错了！');
        }

        $this->redirect('Suggestions/index', array('p' => $_GET['p']));        
    }
}
