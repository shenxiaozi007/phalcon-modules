<?php
use Phalcon\Loader;
use Phalcon\Tag;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Router;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Config;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Flash\Direct as FlashDirect;
use Library\Plugins\NotFoundPlugin;

//use Phalcon\Mvc\Model\Manager as ModelsManager;
$di = new FactoryDefault();
$loader = new Loader();


//注册配置文件
$di->setShared('config',function() use($config){
    return new Config($config);
});

//设置url
$di->set('url', function () {
    $url = new Url();
    $url->setBaseUri(BASE_ROOT);
    return $url;
});
//注册命名空间
$loader->registerNamespaces(
    array(
        'Library\Extend' => INDEX_ROOT.'library/extends',
        'Library\Plugins' => INDEX_ROOT.'library/plugins',
        'App\Admin' => INDEX_ROOT.'/application/admin/',
        'App\Admin\Controller' => INDEX_ROOT.'/application/admin/controller',
        'App\Home' => INDEX_ROOT.'/application/home/',
        'App\Home\Controller' => INDEX_ROOT.'/application/home/controller',
        'App\Com' => INDEX_ROOT.'/application/_common/',
        'App\Com\Controller' => INDEX_ROOT.'/application/_common/controller',
        'App\M' => INDEX_ROOT.'/application/_common/model',

    )
)->register();

//路由服务
$di->setShared('router', function() {

    $router = new Router();
    //加载路由文件
    include INDEX_ROOT.'config/route.php';
    return $router;

});

//注册session
$di->setShared('session', function() {
    $session = new Session();
    $session->start();
    return $session;
});

/**
 * 闪现万岁
*/
$di->set('flash', function(){
    return new FlashSession(array(
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
    ));
});