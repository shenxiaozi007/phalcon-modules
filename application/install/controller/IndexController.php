<?php
namespace App\Install\Controller;
class IndexController extends CommonController {
    public function initialize() {
        $this->tag->setTitle('安装页面');
        parent::initialize();
    }
    
    /**
     * 安装首页
     */
    public function indexAction() {
        //特定样式
        $this->view->style = 'index';
        if($this->request->isPost()) {
            $accept = $this->request->getPost('accept');
            
            if(empty($accept)) {
                return $this->flash->error('请先同意亲');
            }
            return $this->response->redirect('install/index/check');
        }
        
        
    }
    
    /**
     * 环境检测
     */
    public function checkAction() {
        $this->view->style = 'check';
                
    }
    
    /**
     * 同意
     */
    public function acceptAction() {
       
    }
    
    
}