<?php
namespace Wx\Controller;
use Common\Controller\AppframeController;
class WxTokenController extends AppframeController {
	public $app_id,$secret;
	
	function _initialize() {
		$this->app_id	= 'wx5a086d2b934b010d';
		$this->secret	= '54156caeee7dde7c5327ffbd5f518ce1';
		$this->redirect	= U('Wx/WxToken/index', '', true, true);
	}
	
    /**
     * 后台框架首页
     */
    public function index() {
    	$data = $this->get_date();
    	
    	M('wx_user')->data($data)->add();
    }
    

    /**
     * 获得微信token
     */
	public function token_test(){
		$url	 = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=';
		$url	.= $this->app_id . '&redirect_uri=' . urlencode($this->redirect);
		$url	.= '&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
		redirect($url);
	}
	
	public function get_date(){
		$url	 = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=';
		$url	.= $this->app_id . '&secret=' . $this->secret . '&code=' . I('get.code');
		$url	.= '&grant_type=authorization_code';
		$end = curl_get($url);
		
		return $end;
		dump($end);
	}
}

