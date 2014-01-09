<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 
 */
class PublicController extends Controller {
    public function index() {
    	$this->show('asdad');
    }

	public function header() {
		$this->display();
	}

	public function layout() {
		$this->display();
	}
}