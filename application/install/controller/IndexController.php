<?php
namespace App\Install\Controller;
class IndexController extends CommonController {
    
    private $dbConfig = array(); //配置
    
    public function initialize() {
        $this->tag->setTitle('安装页面');
        parent::initialize();
    }
    
    /**
     * 安装首页
     */
    public function indexAction() {
        //特定样式
        $this->view->style = 'index';
        if($this->request->isPost()) {
            $accept = $this->request->getPost('accept');
            
            if(empty($accept)) {
                return $this->flash->error('请先同意亲');
            }
            return $this->response->redirect('install/index/check');
        }
        
        
    }
    
    /**
     * 环境检测
     */
    public function checkAction() {
        $this->view->style = 'check';
        //缓存目录权限
        $cache = array(RUNTIME_ROOT,PUBBLIC_ROOT);
        
        $error = [];
        //是否有写读权限
        foreach($cache as $v) {
            if(!file_exists($v)) {
                $error[] = $v.'不存在';
            }
            if(!is_writable($v)) {
                $error[] = $v.'不可写';
            }            
        }
        
        //检测对应扩展
        if(! function_exists('curl_getinfo')) {
            $error[] = '请开启curl扩展';
        }
        if(! function_exists('mb_strlen')) {
            $error[] = '请开启mb_strlen扩展';
        }
        if(! function_exists('gd_info')) {
            $error[] = '请开启gd扩展';
        }
        if(!empty($error)) {
            foreach ($error as $v) {
                $this->flash->error($v);
            }
        } else {
            return $this->response->redirect('install/index/start');
        }
        
                
    }
    
    /**
     * 开始填写配置
     */
    public function startAction() {
        $sqlFile = INDEX_ROOT.'/application/install/sqldata/dev_ajb_com.sql';
        $content = $this->turnMysql($sqlFile);
       
        $this->view->setVars(
            [
                'style'   => 'start',
                'host' => '127.0.0.1',
                'port' => '3306',
                'username' => 'root',
                'dbPassword' => '',
                'dbName' => 'dev_ajb_test',
                'dbPrefix' => 'ajb',
                'adminName' => 'admin',
            ]
        );
        if($this->request->isPost()) {
             
            global $config;
            //var_dump($this->request->getPost());
            //设置给前端的值
            foreach ($this->request->getPost() as $k=>$v) {
                $this->view->$k = $v; 
                
            }
            if(empty($this->request->getPost('host')) || empty($this->request->getPost('username'))) {
                return $this->flash->error('数据库地址或用户名不能为空');
                
            }
            if(empty($this->request->getPost('dbName'))) {
                return $this->flash->error('数据库名不能为空');
            }
            if(empty($this->request->getPost('adminName')) || empty($this->request->getPost('password'))) {
                return $this->flash->error('管理员账号或密码不能为空');
            }
            
            //转换下数据
            extract($_POST);
            //开始链接数据库
            $mysqlObj = new \mysqli($host.':'.$port, $username, $dbPassword);
            
            if($mysqli->connect_errno){
                return $this->flash->error('数据库连接失败');
            }
           
            $selectDb = $mysqlObj->select_db($dbName);
            //var_dump($selectDb);
            if($selectDb) {
                $isSet = false; 
                //存在则覆盖
                $query = $mysqlObj->query("show tables like '{$dbPrefix}%'");
              
                /* var_dump($isSet);
                var_dump($query); */
                
                while ($row = $query->fetch_assoc()) {
                    $isSet = true;
                    break;
                }
               
                if($isSet) {
                    $this->flash->error('表存在执行覆盖');
                    return $this->response->redirect('install/index/start');
                }
            } else {
                //不存在则创建
                if($mysqlObj->server_info > '4.1') {
                    
                    $mysql = "create database if not exists {$dbName} DEFAULT CHARACTER SET ".$config['mysqlDb']['charset']."";
                } else {
                    $mysql = "create database if not exists {$dbName}";
                }
              
                if(!$mysqlObj->query($mysql)) {
                    return $this->flash->error('数据库创建失败失败');
                }
            }
            
            return $this->response->redirect('install/index/setMysql');
        }
        
    }
    /**
     * 开始安装
     */
    public function setMysqlAction() {
        $this->view->setVars(
            [
                'style' => 'install'
            ]
        );
        global $config;
        extract($config['mysqlDb']);
        
        //链接数据库$host.':'.$port, $username, $dbPassword
        $mysqliObj = new \mysqli($host.':'.$port, $username, $password);
        //选择数据库
        $selectDb = $mysqliObj->select_db($database);
        
        $version = $mysqliObj->server_info;
        $sqlFile = INDEX_ROOT.'/application/install/sqldata/dev_ajb_com.sql';
        $content = $this->turnMysql($sqlFile);
        
        //$mysqliObj->query("show tables like '{$dbPrefix}%'");
      
        //执行数据库插入操作
        foreach($content as $line) {
            //替换掉前缀
            $line = str_replace('`ajb_', "`$prefix", $line);
            preg_match('/^CREATE TABLE/', $line, $lines);
            
            if($lines){
                preg_match('/`(.+)`/', $line, $res);
                $this->flash->success($res[1].'插入成功');
            }
            if(!empty($line)) {
                $mysqliObj->query($line);
            }
        }
    }
    
    /**
     * 转换数据库数据
     */
    public function turnMysql($sqlFile) {
        
        $content = file_get_contents($sqlFile);
        $content = str_replace("\r\n", "\n", $content);
        $content = trim(str_replace("\r", "\n", $content)); 
        
        $items = explode(";\n", $content);
        $resItems = array();
        
        foreach ($items as $v) {
           
            $v = trim($v);
            //var_dump($v);
            $lines = explode("\n",$v);
            //重新组合数据
            if(!empty($lines) && is_array($lines)) {
                foreach($lines as $line) {
                    if(isset($lines[1]) && mb_substr($line,0,2,'utf-8') == '--') {
                        $resItems[] = $lines[3];
                        continue;
                    }
                    $resItems[] = $v;
                    break;
                    
                }
            }
            
        }
        return $resItems;
        
    }
}