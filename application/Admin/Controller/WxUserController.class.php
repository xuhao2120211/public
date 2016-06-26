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
		$pid = I('get.post_id');
		$where = array();
		if($pid) $where['post_id'] = $pid;
		
		$count	= $this->users_model->where($where)->count();
		$page	= $this->page($count, 20);
		
		$users	= $this->users_model
						->where($where)
						->order("id DESC")
						->limit($page->firstRow . ',' . $page->listRows)
						->select();
		
		$this->assign("page", $page->show('Admin'));
		$this->assign("users",$users);
		$this->assign("sex",array('','男','女'));
		$this->display();
	}
	
	public function show_add(){
		$this->assign("longitude",I('get.longitude'));
		$this->assign("latitude",I('get.latitude'));
		$this->assign("users",$users);
		$this->display();
	}
	
}