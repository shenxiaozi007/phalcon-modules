<?php
namespace App\Admin\Controller;
use App\Com\Controller\BaseController;

class ErrorController extends BaseController {
    public function initialize() {
        $this->tag->setTitle('错误页面');
        parent::initialize();
    }
    /**
     * 控制器或者动作不存在时的页面
     */
    public function error404Action() {
        
    }
    
    /**
     * 权限不足
     */
    public function error401Action() {
        
    }
    
    /**
     * 页面异常
     */
    public function error500Action() {
        
    }
}