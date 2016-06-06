<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class WxUserController extends AdminbaseController{
	protected $users_model;
	
	function _initialize() {
		parent::_initialize();
		$this->users_model = D("Common/WxUser");
	}
	function index(){
		$count=$this->users_model->count();
		$page = $this->page($count, 20);
		$users = $this->users_model
		->order("id DESC")
		->limit($page->firstRow . ',' . $page->listRows)
		->select();
		
		$this->assign("page", $page->show('Admin'));
		$this->assign("users",$users);
		$this->display();
	}
	
}