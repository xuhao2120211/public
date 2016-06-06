<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
/**
 * 文章内页
 */
namespace Portal\Controller;
use Common\Controller\HomebaseController;
class ArticleController extends HomebaseController {
	
	public function lists(){
		
// 		$list = M('TermRelationships')->alias('a')
// 									->join(C('DB_PREFIX').'posts b on a.object_id=b.id')
// 									->;
	}
	
    //文章内页
    public function index() {
    	// 微信访问时获得微信信息
    	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')){
    		$this->check_open_token();
    	}
    	
    	$id=intval($_GET['id']);
    	$article=sp_sql_post($id,'');
    	if(empty($article)){
    	    header('HTTP/1.1 404 Not Found');
    	    header('Status:404 Not Found');
    	    if(sp_template_file_exists(MODULE_NAME."/404")){
    	        $this->display(":404");
    	    }
    	    
    	    return ;
    	}
    	$termid=$article['term_id'];
    	$term_obj= M("Terms");
    	$term=$term_obj->where("term_id='$termid'")->find();
    	
    	$article_id=$article['object_id'];
    	
    	$posts_model=M("Posts");
    	$posts_model->save(array("id"=>$article_id,"post_hits"=>array("exp","post_hits+1")));
    	
    	$article_date=$article['post_modified'];
    	
    	$join = "".C('DB_PREFIX').'posts as b on a.object_id =b.id';
    	$join2= "".C('DB_PREFIX').'users as c on b.post_author = c.id';
    	$rs= M("TermRelationships");
    	
    	$next=$rs->alias("a")->join($join)->join($join2)->where(array("post_modified"=>array("egt",$article_date), "tid"=>array('neq',$id), "status"=>1,'term_id'=>$termid))->order("post_modified asc")->find();
    	$prev=$rs->alias("a")->join($join)->join($join2)->where(array("post_modified"=>array("elt",$article_date), "tid"=>array('neq',$id), "status"=>1,'term_id'=>$termid))->order("post_modified desc")->find();
    	
    	 
    	$this->assign("next",$next);
    	$this->assign("prev",$prev);
    	
    	$smeta=json_decode($article['smeta'],true);
    	$content_data=sp_content_page($article['post_content']);
    	$article['post_content']=$content_data['content'];
    	$this->assign("page",$content_data['page']);
    	$this->assign($article);
    	$this->assign("smeta",$smeta);
    	$this->assign("term",$term);
    	$this->assign("article_id",$article_id);
    	
    	$tplname=$term["one_tpl"];
    	$tplname=sp_get_apphome_tpl($tplname, "article");
    	

    	$signature = $this->get_js_token();
    	$this->assign("signature",$signature);
    	$this->assign("app_id",D('WxUser')->app_id);
    	
    	$show_type = I('get.show_type');
    	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') && empty($show_type))
    		$this->display(":m_article");
    	else
    		$this->display(":$tplname");
    }
    
    public function get_js_token(){
    	$ret['jsapi_ticket']	= D('WxUser')->get_ticket();
    	
    	$ret['noncestr']		= rand_string(16);
    	$ret['timestamp']		= strtotime('now');
    	
    	$ret['url']				= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    	
    	foreach($ret as $k => $v){
    		$signature .= '&' . $k . '=' . $v;
    	}
    	
    	$signature = substr($signature, 1);
    	$ret['signature'] = sha1($signature);
    	
    	return $ret;
    }
    
    public function do_like(){
    	$this->check_login();
    	
    	$id=intval($_GET['id']);//posts表中id
    	
    	$posts_model=M("Posts");
    	
    	$can_like=sp_check_user_action("posts$id",1);
    	
    	if($can_like){
    		$posts_model->save(array("id"=>$id,"post_like"=>array("exp","post_like+1")));
    		$this->success("赞好啦！");
    	}else{
    		$this->error("您已赞过啦！");
    	}
    }
    
    /**
     * 存储经纬度
     */
    public function save_position(){
    	$save = array();
    	$save['latitude'] = I('get.latitude');
    	$save['longitude'] = I('get.longitude');
    	
    	$openid	= session('WX_OPENID');
    	
    	$map = array('openid' => $openid);
    	
    	$id = M('wx_user')->where($map)->order('id desc')->getfield('id');
    	
    	if($id) D('WxUser')->where('id=' . $id)->save($save);
    }
}
