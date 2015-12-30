<?php
$config = array(
    'modules' => array('admin','home','install'),
    'mysqlDb'=>	array(
        'driver'    => 'mysql',
        'host'      => '',
        'database'  => '',
        'username'  => '',
        'password'  => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_general_ci',
        'prefix'    => '',
        'port'      => 0,
    ),
    //------------多模块配置
    //上面配置的位置请不要更改
    //-----------

    'is_dev' => 1,	//开发模式
    'tpl_suffix' => '.html',	//模板文件后缀
    'default_module' => 'install',	//默认模块pc页面
    'default_controller' => 'index',
);

return $config;