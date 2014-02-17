<?php
namespace Home\Controller;

/**
 * EmptyController
 */
class EmptyController extends CommonController {
    public function index() {
        $this->redirect('Index/index');
    }
}
