<?php

use Phalcon\Mvc\Application;
use Illuminate\Database\Capsule\Manager as Capsule;

header("Content-type:text/html;charset=utf-8");
date_default_timezone_set('Asia/Shanghai');

define('INDEX_ROOT', dirname(dirname(__FILE__)) . '/');	#定义根目录
define('CONFIG_ROOT', INDEX_ROOT . 'config/');	#定义配置目录

define('RUNTIME_ROOT',INDEX_ROOT.'runtime/');
define('CACHE_ROOT', RUNTIME_ROOT.'cache/');	#定义编译缓存目录
define('APP_ROOT', INDEX_ROOT . 'application/');#定义项目目录
define('VIEW_ROOT', INDEX_ROOT . 'resource/template/');#定义html目录
define('BASE_ROOT', '/'); #主目录
define('CACHEVIEW_ROOT',RUNTIME_ROOT.'viewcache/'); //视图缓存目录
define('PUBBLIC_ROOT',INDEX_ROOT.'public/'); //前端文件目录

include  INDEX_ROOT.'config/config.php';

#如果是生产环境，则覆盖
if(is_file(INDEX_ROOT.'application/config/config_pro.php')) {
    $config = array_merge($config, include(INDEX_ROOT.'application/config/config_pro.php') );
}


return $config;
require INDEX_ROOT.'config/sevices.php';
//composer加载
require INDEX_ROOT.'Vendor/autoload.php';

#不同的错误输出等级
if($config['is_dev']) {
    
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('display_errors', true);
	//很帅的错误插件
	$whoops = new Whoops\Run;
	$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
	$whoops->register();
	define('DEBUG',1);
} else {
	error_reporting(E_ERROR | E_WARNING | E_PARSE);		#输出错误的等级
	ini_set('display_errors', false);
	define('DEBUG',0);
}

try {
    //主程序
    $application = new Application($di);
    $modules = array();
    //多模块注册
    foreach ($config['modules'] as $k=>$v) {
        $modules[$v] =
        array(
            'className' => 'App\Com\BaseModule',
            'path' => INDEX_ROOT.'application/_common/BaseModule.php'
        );
    }
    $application->registerModules($modules);
    
    //laravel ORM
    $capsule = new Capsule;
    $capsule->addConnection(array(
        'driver'    => $config['mysqlDb']['driver'],
        "host"     => $config['mysqlDb']['host'],
        "username" => $config['mysqlDb']['username'],
        "password" => $config['mysqlDb']['password'],
        "database"   => $config['mysqlDb']['database'],
        "charset"   => $config['mysqlDb']['charset'],
        'prefix'    => $config['mysqlDb']['prefix'],
    ));
    
    $capsule->bootEloquent();
    
    echo $application->handle()->getContent();
   
}catch (\Phalcon\Exception $e) {
    
    echo $e->getMessage();
}