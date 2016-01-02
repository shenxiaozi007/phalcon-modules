<?php
namespace App\M;
class BaseMysqlDb extends \Illuminate\Database\Eloquent\Model{
	
	private static $_Dbinstance;
	
	public $timestamps = false; //created_at和 updated_at字段不希望给Eloquent维护

    protected $DbBaseConnection = null;   //当前连接
	
	protected $callback = array('status' => 0, 'msg' => '');//返回信息(0:错误，1：成功)
	
/* 	public function __construct($db = array()){
		//会被多次调用.....
		if(!self::$_Dbinstance){
			if(empty($db)){
				return Db::mysql('base');
			}
			parent::__construct($db);
			self::$_Dbinstance = $this;
		}
	} */
	
	public function _init($db){
		if(!self::$_Dbinstance){
			parent::_init($db);
			self::$_Dbinstance = $this;
            /* //启动监控队列
            $dispatcher = new Dispatcher;
			self::$_Dbinstance->setEventDispatcher($dispatcher);
            //$this->getConn()->setEventDispatcher($dispatcher);
            //启动观察者模式
			self::$_Dbinstance->observe($this); */
		}
	}

	/**
	 * 示例：Db::mysql('Region')->setWhere(array('niemi'=>121))
	 * 类似:where niemi = 121
	 * 
	 * 示例：Db::mysql('Region')->setWhere(array('nimei'=>array('>=',121)))
	 * 类似:where niemi >= 121
	 * 
	 * 示例：Db::mysql('Region')->setWhere(array('nimei'=>array('>=', 121),'__or__' => array('tamei'=>array('=','1'))))
	 * 类似:where nimei >= 121 or tamei = 1
	 * 
	 * 高级查询
	 * 示例：Db::mysql('Region')->setWhere(array('__()__'=>array('tamei'=>array('=',112),'111'=>array('=',112),'__or__'=>array('mobile'=>array('=','1'))),'username'=>array('>=','小女人'),'__or__'=>array('id'=>array('like','\'123\''))))->get()->toArray();
	 * 类似:where (`tamei` = 112 and `111` = 112 or `mobile` = 1) and `username` >= 小女人 or `mobile` like '%199999%'
	 * 
	 * 示例：Db::mysql('Region')->setWhere(array('addTime'=>array(array('>',2014),array('<',2015))))
	 * 类似:where addTime > 2014 and addTime < 2015
	 * 
	 * Db::mysql('Region')->where('id', 1)->get()->toArray();
	 * 
	 * 数组条件
	 * @param Object $query
	 * @param array $arr	条件数组
	 * @return Object
	 */
	public function scopesetWhere($query, $arr){
		//代码有待加强,未修改
		foreach ($arr as $k=>$v){
		    if(is_array($v)) {
		        if($k == '__or__') {
		            foreach ($v as $n => $m ) {
		                $query = $query->orWhere($n, $m[0], $m[1]);
		            }
		        } elseif($k == '__()__') {
                    $query = $query->where(function($nimei) use ($v) {
                        foreach ($v as $y => $x) {
                         if($y == '__or__') {
                             foreach ($x as $i => $o) {
                                 $nimei = $nimei->orWhere($i,$o[0],$o[1]);
                             }
                             
                         } else {
                            $nimei = $nimei->where($y,$x[0],$x[1]);
                         }
                        }
                    });
                    
		        } else {
		        	 if(is_array($v[0])){
		        	 	foreach ($v as $key => $val) {
		        	 		$query = $query->where($k, $val[0], $val[1]);
		        	 	}
		        	 }else{
		        	 	$query = $query->where($k, $v[0], $v[1]);
		        	 }
		        }
		    } else {
		        $query = $query->where($k,$v);
		    }
		    
           	
		}
		return $query;
	}

    /**
     * 排序
     *
     * @param $query        查询对象
     * @param array $arr    排序(1:正序,否则倒序)
     * @return mixed
     */
    public function scopesetOrderBy($query, $arr = array()){
        foreach ($arr as $k=>$v){
            if($v == 1){
                $orderBy = 'asc';
            }else{
                $orderBy = 'desc';
            }
            $query->orderBy($k, $orderBy);
        }
        return $query;
    }

    /**
     * 普通查询
     * $list = Db::mysql('order')->getDataPage($query, $fields, $sort);
     *
     * 不使用默认分页查询
     * $page = 1;
     * $pageSize = 1;
     * $fields = array();
     * $sort = array();
     * $list = Db::mysql('order')->getDataPage($query, $fields, $sort, '', array(), $page, $pageSize);
     *
     * 关联查询
     * $files = array('ad.adId', 'adList.title', 'adList.adType', 'adList.linkTo', 'adList.imgId');
     * $join = array('leftJoin', 'adList', 'ad.adTag', '=', 'adList.adTag');
     * $join = array(array('leftJoin', 'adList', 'ad.adTag', '=', 'adList.adTag'),array('leftJoin', 'adList', 'ad.adTag', '=', 'adList.adTag'));
     * $list =  Db::mysql('ad')->getDataPage($query, $files, array('adList.sortOrder'=>1), 'post', $join);
     *
     * @param array $query      查询条件
     * @param array $files      查询字段
     * @param array $sort       查询排序
     * @param string $method    获取分页信息方法,默认POST,否则GET 参数:(page:当前页码,pageSize:获取每页个数)
     * @param array $join       关联查询
     * @param int $page         当前页码
     * @param int $pageSize     每页个数
     * @return array            返回结果
     */
    public function getDataPage($query = array(), $files = array(), $sort = array(), $method = '', $join = array(), $page = -1, $pageSize = -1){
        $method = empty($method) ? 'post' : $method;
        if($method == 'post'){
            $page = $page < 0 ? (empty($_POST['page']) ? 1 : intval($_POST['page'])) : $page;
            $pageSize = $pageSize < 0 ? ( empty($_POST['pageSize']) ? 5 : intval($_POST['pageSize'])) : $pageSize;
        }else{
            $page = $page < 0 ? ( empty($_GET['page']) ? 1 : intval($_GET['page'])) : $page;
            $pageSize = $pageSize < 0 ? ( empty($_GET['pageSize']) ? 5 : intval($_GET['pageSize'])) : $pageSize;
        }
       
        $db = $this;
        if(!empty($join) && is_array($join)){
            if(!is_array($join[0])){
                $tempjoin = $join;
                $join = array();
                $join[0] = $tempjoin;
            }
            foreach($join as $k=>$v){
                $db = $db->$v[0]($v[1], $v[2], $v[3], $v[4]);
            }
        }
        $dbCount = clone $db;//复制一个对象进行统计查询

        $files = empty($files) ? $this->fillable : $files;

        $data = $db->setWhere($query)->setOrderBy($sort)->skip(($page-1)*$pageSize)->take($pageSize)->get($files);
        $list = array();
        if(count($data) > 0){
            $list = $data->toArray();
        }
        $total = $dbCount->setWhere($query)->count();

        return array('page'=>array('page' => $page, 'pageSize' => $pageSize, 'total' => $total, 'totalPage' => ceil($total/$pageSize)),'list' => $list);
    }

    /**
	 * 设置成功信息
	 * @param string $msg
	 * @return bool
	 */
	protected function setSuccess($msg = 'success'){
		$this->callback = array('status'=>1, 'msg'=> $msg);
		return true;
	}
	/**
	 * 设置错误信息
	 * @param string $msg
	 * @return bool
	 */
	protected function setError($msg = 'failure'){
		$this->callback = array('status'=>0, 'msg'=> $msg);
		return false;
	}
	
	/**
	 * 返回信息
	 * @return string
	 */
	public function getMsg(){
		return $this->callback['msg'];
	}

    /**
     * 获取当前连接
     * @return \Illuminate\Database\Connection|null
     */
    public function getConn(){
        if(empty($this->DbBaseConnection)){
            $this->DbBaseConnection = $this->getConnection();
        }
        return $this->DbBaseConnection;
    }

    /**
     * 开始事务
     */
    public function transaction(){
        $this->getConn()->beginTransaction();
    }

    /**
     * 事务提交
     */
    public function commit(){
        $transactionLevel = $this->getConn()->transactionLevel();
        if($transactionLevel > 0){
            $this->getConn()->commit();
        }
    }

    /**
     * 事务回退
     */
    public function rollBack(){
        $transactionLevel = $this->getConn()->transactionLevel();
        if($transactionLevel > 0){
            $this->getConn()->rollBack();
        }
    }
}