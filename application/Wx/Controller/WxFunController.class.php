<?php
namespace Wx\Controller;
use Common\Controller\AdminbaseController;
class WxFunController extends AdminbaseController {
	public $grant_type	= 'client_credential';
	public $token_url 	= 'https://api.weixin.qq.com/cgi-bin/token?';
	
	function _initialize() {
		
	}
	
    /**
     * 后台框架首页
     */
    public function index() {
        $this->assign("assign", '123');
       	$this->display();
        
    }
    

    /**
     * 获得微信token
     */
	public function get_token(){
		if(S('WX_TOKEN_STR')) return S('WX_TOKEN_STR');
		
		$url = $this->token_url;
		$url .= '&appid=' . C('WX_APPID');
		$url .= '&secret=' . C('WX_SECRET');
		
		$token_arr = curl_get($url);
		
		S('WX_TOKEN_STR', $token_arr['access_token'], 7200);
		
		return S('WX_TOKEN_STR');
	}
}

