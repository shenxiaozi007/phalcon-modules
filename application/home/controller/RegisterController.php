<?php
namespace App\Admin\Controller;
use App\Com\Controller\BaseController;
use App\M\User;
use Library\Extend\Hash;
class RegisterController extends BaseController {
    
    public function initialize() {
        $this->tag->setTitle('添加用户');
        parent::initialize();
    }
    
    
    public function indexAction() {
       
        if($this->request->isPost()) {
            //保存
            $userObj = new User();
            $data = array();
            $data['username'] = $this->request->getPost('username');
            $data['mobile'] = $this->request->getPost('mobile');
            $password = $this->request->getPost('password');
            $morepassword = $this->request->getPost('morepassword');
        
            if(empty($data['username'])) {
                return $this->flash->error('请填写用户名');
            }
            if(!preg_match('/^(13|14|15|17|18)\d{9}$/', $data['mobile'])) {
                return $this->flash->error('电话号码格式不正确');
            }
            if(empty($password)) {
                return $this->flash->error('请填写密码');
            }
            if($password != $morepassword) {
                return $this->flash->error('密码不一致');
                
            }
            $data['password'] = Hash::userPassword($password);
            $data['addTime'] = time();
            
            $where = array(
                'password'=>array('=', $data['password']),
                '__()__'=>array(
                    'mobile'=>array('=', $data['mobile']),
                    '__or__'=>array('username'=>array('=',$data['username'])),
                ),
            );
            $res = $userObj->getUserMsg($where);
            if($res) {
                return $this->flash->error('用户名或电话已经被注册了亲');
            }       
            //保存信息
            $resUser = $userObj->insert($data);
            
            //保存
            if (!$resUser) {
                $this->flash->error('注册失败');
            } else {
                $this->flash->success('注册成功');
                return $this->response->redirect('admin/login/index');
                
            }
            
        }    
    }
    
}