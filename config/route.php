<?php 
//默认路由
$router->add("/", array(
    'module' => 'install',
    'controller' => 'index',
    'action' => 'index'
    
));
/* 
//404
$router->notFound(array(
    'module' => 'admin',
    'controller' => 'index',
    'action' => 'notFount'
    )
); */
//后台通用路由
$router->add('/:module/:controller/:action/:params', array(
    'module' => 1,
    'controller' => 2,
    'action' => 3,
    'params' => 4
));


$router->add(
    "/admin/index/:action",
    array(
        'module'     => 'admin',
        'controller' => 'index',
        'action'     => 1
    )
);
