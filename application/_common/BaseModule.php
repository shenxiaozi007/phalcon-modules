<?php 
namespace App\Com;

use Phalcon\DI;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;

use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Cache\Frontend\Output;
use Phalcon\Cache\Backend\File;
//与调度有关
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;
use Library\Plugins\AclPlugin;

class BaseModule implements ModuleDefinitionInterface {
    protected $_module;
    protected $_controller;
    protected $_config;
    public function __construct() {
        $module = DI::getDefault()->getShared('router')->getModuleName();
        $controller = DI::getDefault()->getShared('router')->getControllerName();
        //获取配置
        $this->_config = DI::getDefault()->getShared('config');
        
        $this->_module = !empty($module) ?  strtolower($module) : $this->_config->default_module ; 
        $this->_controller =  !empty($controller) ?  strtolower($controller) : $this->_config->default_controlle ;
    }
    /**
     * 注册对应文件到命名空间
     */
    public function registerAutoloaders(DiInterface $dependencyInjector = NULL) {
    
        $loader = new Loader();
        //get_class_methods($loader);
        //注册对应模块
        $loader->registerNamespaces(
            array(
                'App\\'.ucfirst($this->_module).'\\Controller' => INDEX_ROOT.'application/'.$this->_module.'/controller',
                'App\M' => INDEX_ROOT.'application/_common/model/mysql',
    
            )
        );
        $loader->register();
    }
    /**
     * 分发对应的控制器跟静态文件
     */
    public function registerServices(DiInterface $di) {
       
        //注册分发控制器
        $di->set('dispatcher', function() {
            // 创建一个事件管理
            $eventsManager = new EventsManager();
            
            // 侦听错误信息
            $eventsManager->attach("dispatch:beforeException", function ($event, $dispatcher, $exception) {
                if(!$this->_config) {
                    //代替控制器或者动作不存在时的路径
                    if ($exception instanceof DispatchException) {
                        switch ($exception->getCode()) {
                            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                                $dispatcher->forward(
                                array(
                                'controller' => 'error',
                                'action'     => 'error404'
                                    )
                                );
                                return false;
                        }
                    
                    }
                    $dispatcher->forward(
                        array(
                            'controller' => 'error',
                            'action'     => 'error500'
                        )
                    );
                    return false;
                }
                
               
                
            });
            
            //监听ACL
            $eventsManager->attach('dispatch:beforeDispatch', new AclPlugin);
            
            
            $dispatcher = new MvcDispatcher();
            
            // 将EventsManager绑定到调度器
            $dispatcher->setEventsManager($eventsManager);
            
            $dispatcher->setDefaultNamespace('App\\'.ucfirst($this->_module).'\\Controller');
            
            return $dispatcher;
        }, true);
        //注册视图
        $di->set('view', function() {
            $view = new View();
    
            $view->setViewsDir(VIEW_ROOT.$this->_module.'/views');
            
            $view->registerEngines(array(
                //".html" => 'Phalcon\Mvc\View\Engine\Php',
                '.html' => function($view, $di) {
                    $volt = new Volt($view, $di);
                    $cacheDir = CACHE_ROOT.$this->_module.'/'.$this->_controller.'/';
                    /* var_dump($cacheDir);
                    exit; */
                    //模板编译目录
                    if(!is_dir($cacheDir)) {
                        mkdir($cacheDir, 0777, true);
                    }
                    $volt->setOptions(array(
                        'compiledPath' => $cacheDir
    
                    ));
                    $compiler = $volt->getCompiler();
                    $compiler->addFunction('is_a', 'is_a');
                    return $volt;
                }
            ));
            return $view;
        });
        //文件缓存
        $di->set('viewCache', function() {
            //缓存时间 ,默认一天
            $frontCache = new Output(array(
                "lifetime" => 86400
            ));
            //缓存目录
            $viewCacheDir = CACHEVIEW_ROOT.$this->_module.'/'.$this->_controller.'/';
            
            //创建目录
            if(!is_dir($viewCacheDir)) {
                mkdir($viewCacheDir, 0777, true);
            }
            $cache = new File($frontCache, array(
                "cacheDir" => $viewCacheDir,
                "prefix" => "cache_"
            ));
            return $cache;
        });
        
    }
}