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
        
    }
}