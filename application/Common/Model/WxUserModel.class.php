<?php
namespace Common\Model;
use Common\Model\CommonModel;
class WxUserModel extends CommonModel{
	public $app_id,$secret,$redirect;
	
	function _initialize() {
		$this->app_id	= 'wx5a086d2b934b010d';
		$this->secret	= '54156caeee7dde7c5327ffbd5f518ce1';
		$this->redirect	= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}
	
	/**
	 * 获得微信token
	 */
	public function get_code(){
		$url	 = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=';
		$url	.= $this->app_id . '&redirect_uri=' . urlencode($this->redirect);
		$url	.= '&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
		
		redirect($url);
	}
	
	/**
	 * 获得当前访问微信用户信息
	 */
	public function get_date(){
		$code	 = I('get.code');
		$url	 = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=';
		$url	.= $this->app_id . '&secret=' . $this->secret . '&code=' . $code;
		$url	.= '&grant_type=authorization_code';
		$end = curl_get($url);

		if($end['errcode']) $this->get_code();
		
		$this->data($end)->add();
		
		return $end;
	}
	
	public function get_token(){
		if(S('ACCESS_TOKEN')) return S('ACCESS_TOKEN');
		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=';
		$url .= $this->app_id . '&secret=' . $this->secret;
		$end = curl_get($url);
		
		S('ACCESS_TOKEN', $end['access_token'], $end['expires_in']);
		
		return $end['access_token'];
	}
	
	public function get_ticket(){
		if(S('JSAPI_TICKET')) return S('JSAPI_TICKET');
		$token = $this->get_token();
		
		$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . $token . '&type=jsapi';
		$end = curl_get($url);
		
		S('JSAPI_TICKET', $end['ticket'], $end['expires_in']);
		
		return $end['ticket'];
	}
	
	public function get_datail_data(){
		$token = $this->get_token();
		
		$url  = 'https://api.weixin.qq.com/cgi-bin/user/info?';
		$url .= 'access_token=' . $token . '&openid=' . session('WX_OPENID') . '&lang=zh_CN';
		
		$end = curl_get($url);
		
		return $end;
	}
}

