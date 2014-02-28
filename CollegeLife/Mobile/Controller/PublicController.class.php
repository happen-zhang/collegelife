<?php
namespace Mobile\Controller;

/**
* PublicController
*/
class PublicController extends \Home\Controller\PublicController {
    // 继承Home\Controller\PublicController
    
    public function login() {
        $this->unvalidFormReq();

        $userService = D('User', 'Service');
        if (true == $userService->login($_POST['user'])) {
            $this->redirect('Index/index');
        }

        $this->redirect('Index/index', array('status' => 1));
    }
}
