<?php
namespace Library\Plugins;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

/**
 * 权限验证
 */
class AclPlugin extends Plugin
{
	/**
	 * 自动将控制器名称保存到资源表
	 * @author hxc
	 *
	 */
	public function beforeDispatch(Event $event, Dispatcher $dispatcher)
	{
	    $module =  $dispatcher->getModuleName();
	    $controller = $dispatcher->getControllerName();
	    $action = $dispatcher->getActionName();
	
	    $objResource= new \App\M\Resource();
	
	    //自动将控制器名称保存到资源表
	    $config = DI::getDefault()->getShared('config');
	
	    if ($config['is_dev']) {
	        $userData=$this->session->get("userInfo");
	        $companyId = (int)$userData['companyId'];
	        	
	        $actionName=$module.'_'.$controller.'_'.$action;
	        $controllerName=$module.'_'.$controller;
	        $objResource->addResource($companyId,$module,$controllerName,$actionName);
	    }
	}	
}
