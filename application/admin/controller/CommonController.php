<?php 
namespace App\Admin\Controller;
use Phalcon\Mvc\Controller;

class CommonController extends Controller {
    public $_userInfo;

    public function initialize() {
        //是否登陆

        $cName = $this->dispatcher->getControllerName();
        //登陆页面不用验证
        if(!in_array(strtolower($cName), array('login','register')) && !$this->isLogin()){
            $this->flash->error('请先登陆亲！');
            return $this->response->redirect('admin/login/index');//未登陆
        }
        $this->view->setTemplateAfter('main');
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
        $this->_userInfo = $userRes;
        $this->session->set("userInfo", $userRes);
    }

    //不重新加载的重定向
    protected function forward($uri)
    {
        $uriParts = explode('/', $uri);
        $params = array_slice($uriParts, 2);
        //var_dump($uriParts,$params);

        return $this->dispatcher->forward(
            array(
                'controller' => $uriParts[0],
                'action' => $uriParts[1],
                'params' => $params
            )
        );
    }

}