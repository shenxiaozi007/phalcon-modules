<?php
/**
 * 管理后台的公用控制器
 * @author 邓彪20151214
 *
 */
namespace App\Com\Controller;

use App\Com\Controller\CommonController;
use Library\Extend\Acl;

class AdminController extends CommonController
{
	public function initialize() {
		//是否登陆
		$cName = $this->dispatcher->getControllerName();
		//登陆页面不用验证
		if($this->notcheckcname($cName) && !$this->isLogin()){
			$this->flash->error('请先登陆亲！');
			return $this->response->redirect('admin/login/index');//未登陆
		}
		//权限控制
		if ($this->notcheckcname($cName) && !Acl::check()) {
			if ($this->request->isAjax()) $this->responseError('你没权限访问');
			return $this->response->redirect('admin/error/error401');
		};
		//用户信息赋值给模板
		$this->view->_userInfo = $this->_userInfo  = $this->session->get('userInfo');
		
		//登陆页使用登陆模板
		 if($cName == 'login') {
		    $this->view->setTemplateAfter('layoutsLogin');
		} else {
		    $this->view->setTemplateAfter('main');
		}
		 
		parent::initialize();
	}  
	
	public function isLogin() {
		$this->_userInfo = $this->session->get('userInfo');
		if(empty($this->_userInfo)) {
			return false;
		}
		return true;
	}
	//设置userInfo
	public function setUserInfoSession($userRes) {
		unset($userRes['password']);
		
		$this->session->set("userInfo", $userRes);
	} 
	
	/**
	 * 跳过控制名称检查
	 * @author 邓彪 20151230
	 */
	protected function notcheckcname($cName){
		if (in_array(strtolower($cName), array('login','register','error','index','my') )) {
			return false;
		}
		return true;
	}
}