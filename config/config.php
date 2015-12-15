<?php
return $config =  array(
    'is_dev' => 1,	//开发模式
	'tpl_suffix' => '.html',	//模板文件后缀
	
	'default_module' => 'install',	//默认模块pc页面
	'default_controller' => 'index',
    //多模块配置
    'modules' => array('admin','home','install'),
    
    'mysqlDb'=>	array(
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'dev_ajb_com',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_general_ci',
        'prefix'    => 'ajb_'
    ),
);
#如果是生产环境，则覆盖
if(is_file(INDEX_ROOT.'application/config/config_pro.php')) {
    $config = array_merge($config, include(INDEX_ROOT.'application/config/config_pro.php') );
}


return $config;