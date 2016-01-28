<?php
namespace App\Admin\Controller;
use App\Admin\Controller\CommonController;
use App\M\User;
use Library\Extend\Hash;
class LoginController extends CommonController {
    public function initialize() {
        $this->tag->setTitle('登陆页面');
        parent::initialize();
    }
    
    /**
     * 登陆
     */
    public function indexAction() {
       if($this->session->get('userInfo')) {
           $this->response->redirect('admin/index/index');
       }
    }
    
    public function loginAction () {
        
        if($this->request->isPost()) {
            $userObj = new User();
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            if(empty($username) || empty($password)) {
                return $this->flash->error('用户名或密码不能为空');
            }
            $password = Hash::userPassword($password);
            //用户名或电话
            
            $where = array(
                'password'=>array('=', $password),
                '__()__'=>array(
                    'mobile'=>array('=', $username),
                    '__or__'=>array('username'=>array('=',$username)),
                ),
            );
            $res = $userObj->getUserMsg($where);
        
            if($res) {
                $this->flash->success('登陆成功');
                //设置session
                 
                $this->setUserInfoSession($res);
        
                return $this->response->redirect('admin/index/index');
            }
            return $this->flash->error('用户名或密码错误');
        }
        $this->view->setVars(
            array(
                'title' => 'fuck11'
        
            )
        );
    }
    /**
     * 退出登录
     */
    public function outAction() {
        $this->session->remove("userInfo");
        $this->flash->success('退出成功');
        return $this->response->redirect('admin/login/index');
    }
}