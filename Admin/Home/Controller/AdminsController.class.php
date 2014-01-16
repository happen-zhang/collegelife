<?php
namespace Home\Controller;

use Think\Controller;

/**
 * 
 */
class AdminsController extends Controller {
	/**
	 * 
	 * @return
	 */
    public function index(){
        $this->display();
    }

    /**
     * 
     * @return
     */
    public function show() {
    	$this->display();
    }
}