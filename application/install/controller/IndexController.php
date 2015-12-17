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
        //缓存目录权限
        $cache = array(RUNTIME_ROOT,PUBBLIC_ROOT);
        
        $error = [];
        //是否有写读权限
        foreach($cache as $v) {
            if(!file_exists($v)) {
                $error[] = $v.'不存在';
            }
            if(!is_writable($v)) {
                $error[] = $v.'不可写';
            }            
        }
        
        //检测对应扩展
        if(! function_exists('curl_getinfo')) {
            $error[] = '请开启curl扩展';
        }
        if(! function_exists('mb_strlen')) {
            $error[] = '请开启mb_strlen扩展';
        }
        if(! function_exists('gd_info')) {
            $error[] = '请开启gd扩展';
        }
        if(!empty($error)) {
            foreach ($error as $v) {
                $this->flash->error($v);
            }
        } else {
            return $this->response->redirect('install/index/start');
        }
        
                
    }
    
    /**
     * 开始填写配置
     */
    public function startAction() {
        $this->view->setVars(
            array(
                'style'   => 'start',
                'host' => '127.0.0.1',
                'port' => '3306',
                'username' => 'root',
                'dbPassword' => '123456',
                'dbName' => 'hxc_cms',
                'dbPrefix' => 'hxc',
                'adminName' => 'admin',
            )
        );
        if($this->request->isPost()) {
            
        }
    }
    /**
     * 同意
     */
    public function acceptAction() {
       
    }
    
    
}