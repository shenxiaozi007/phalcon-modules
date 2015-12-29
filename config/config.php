<?php
$config = array(
    'modules' => array('admin','home','install'),
    'mysqlDb'=>	array(
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'hxc_cms',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_general_ci',
        'prefix'    => 'hxc_',
        'port'      => 3306
    ),
    //------------多模块配置
    //上面配置的位置请不要更改
    //-----------

    'is_dev' => 1,	//开发模式
    'tpl_suffix' => '.html',	//模板文件后缀
    'default_module' => 'install',	//默认模块pc页面
    'default_controller' => 'index',
);

