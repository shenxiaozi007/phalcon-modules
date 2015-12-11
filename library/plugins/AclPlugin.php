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
	 * 分发后验证
	 *
	 */
	public function beforeDispatch(Event $event, Dispatcher $dispatcher)
	{
	   
        $module =  $dispatcher->getModuleName();
		$controller = $dispatcher->getControllerName();
		$action = $dispatcher->getActionName();
	}	
}
