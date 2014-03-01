<?php
namespace Home\Controller;

class SuggestionsController extends CommonController {
    /**
     * RESTful create
     * @return
     */
    public function create() {
        $this->unvalidFormReq();

        if (!isset($_POST['suggestion'])) {
            $this->error('无效的操作！');
        }

        $Suggestion = D('Suggestion');
        $suggestion = $Suggestion->create($_POST['suggestion']);
        if (!$Suggestion->add($suggestion)) {
            $this->error('对不起，系统出错！');
        }

        $this->destroyToken();
        $this->success('谢谢您的建议，我们将尽快处理！', 'Index/index', 5);
    }
}
