<?php
namespace App\Install\Controller;
use Phalcon\Mvc\Controller;

class CommonController extends Controller{
    public function initialize() {
        $this->view->setTemplateAfter('main');
    }
    /* public function initialize(){
        $this->view->setTemplateAfter('main');
    }
     */
}