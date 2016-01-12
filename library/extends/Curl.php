<?php
namespace Library\Extend;
/**
 * Curl
 * @author邓彪20140528
 * 监控网页是否访问正常或页面样式是否错位
 */
class Curl
{
	protected $cookieFile;
	/**
	 * 设置cookie路径
	 */
	public function cookiePath($path=NULL){
		if ($path) {
			$this->cookieFile=$path;
		}else{
			$this->cookieFile=CACHE_ROOT. '/cookie.txt';
		}
	} 
	
    /**
     * 初始化
     */
    public static function init() {
    		$object = new Curl();
    		$object->cookiePath();//初始cookie路径
    		return $object;
    }
    
	/**
     * 使用shell命令中的curl来代替file_get_contents，尽量避免nginx的502错误
     */
	public static function shGet($url, $timeOut = 30) {
		if(! function_exists('shell_exec') ) {
			return file_get_contents($url);
		} else {
			return shell_exec('curl --connect-timeout '.$timeOut.' --location "'.$url.'"');
		}
	}
    
	/** 
	* get 方式获取访问指定地址
	* @param  string url 要访问的地址
	* @param  string cookie cookie的存放地址,没有则不发送cookie
	* @return string curl_exec()获取的信息
	**/
	public function get($url,$timeOut=30){
		$curl =curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_TIMEOUT, $timeOut);//超时时间
		curl_setopt($curl, CURLOPT_HEADER, 0);// 不显示header信息
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1);// 自动设置Referer 支持301|302跳转
		curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookieFile);//读取cookie
		$tmp = curl_exec($curl);
		curl_close($curl);
		return $tmp;
	}
	
	/**
	*  post 方式模拟请求指定地址
	* @param  string url 请求的指定地址
	* @param  array  params 请求所带的
	* @param  array  from 来源
	* @patam  string cookie cookie存放地址
	* @return string curl_exec()获取的信息
	**/
	public function post($url,$params,$from=array(),$bool=false,$cookieFile=null)
	{
		$ch=curl_init();
		if($cookieFile) $this->cookieFile=$cookieFile;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		if ($from['ip']) {
		//构造IP 210.21.95.148
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$from['ip'], 'CLIENT-IP:'.$from['ip']));
		}
		if ($from['url']) {
		//构造来路 http://www.buyigang.com
		curl_setopt($ch, CURLOPT_REFERER, $from['url']);     
		}
		curl_setopt($ch, CURLOPT_HEADER, 0); //是否输出tcp/ip头信息 0 不输出 ， 1 输出
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //返回的内容是否直接输出    0=>输出，1不输出
		if($bool){
			curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);//读取cookie
		}else{
			curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);//保存cookie
		}
		$out = curl_exec($ch);
		curl_close($ch);
		return $out;
	}
	
	/**
	 *  post 方式模拟请求指定地址
	 * @param  string url 请求的指定地址
	 * @param  array  params 请求所带的
	 * @param  array  from 来源
	 * @patam  string cookie cookie存放地址
	 * @return string curl_exec()获取的信息
	 **/
	public function getuiPost($url,$params,$from=array(),$bool=false,$cookieFile=null)
	{
	    $ch=curl_init();
	    //if($cookieFile) $this->cookieFile=$cookieFile;
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));
	    curl_setopt($ch, CURLOPT_HEADER, 0); //是否输出tcp/ip头信息 0 不输出 ， 1 输出
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //返回的内容是否直接输出    0=>输出，1不输出
	    $out = curl_exec($ch);
	    curl_close($ch);
	    return $out;
	}
	
	
	/**
	 * 模拟登录
	 */
	public function loginGet($url,$userInfo=array()){
		$rs=$this->post($url, $userInfo);
		if (strstr($rs, '登录成功')) {
			return true;
		}
		return false;
	}
	
	/**
	 * 页面错误类型
	 * webMonitorAction
	 * @param string $webcode
	 * @param string $url
	 */
	public function webCodeRrr($webcode='',$url=NULL){
		$msg=NULL;
		if (strstr($webcode, 'Connection: close')) {
			$msg='服务器未响应/';
		}elseif (empty($webcode)&&!strstr($url, 'getImg')) {
			$msg='获取超时/';
		}elseif (strstr($webcode, '502 Bad Gateway')) {
			$msg='502BadGateway/';
		}elseif (strstr($webcode, '500 Internal Server Error')) {
			$msg='500Error/';
		}elseif (strstr($webcode, 'connect to database')) {
			$msg='连接数据库失败/';
		}elseif (strstr($webcode, 'require')) {
			$msg='缺少包含文件/';//require_once
		}elseif (strstr($webcode, 'foreach')) {
			$msg='变量未定义的foreach/';//Warning: Invalid argument supplied for foreach
		}elseif (strstr($webcode, 'unexpected $end')) {
			$msg='if缺少结束符/';//Parse error: syntax error, unexpected $end
		}elseif (strstr($webcode, 'Undefined variable')) {
			$msg='变量未定义/';//Notice: Undefined variable
		}elseif (!strstr($webcode, 'body')&&!strstr($webcode, 'div')&&!strstr($url, 'getImg')) {
			$msg='未获取到body标签/';
		}
		return $msg;
	}
	//异步发送
	public static function triggerRequest($URL, $post_data = array(), $cookie = array()){
	    $referrer="";
	    // parsing the given URL
	    $URL_Info=parse_url($URL);
	    // Building referrer
	    if($referrer=="") // if not given use this script as referrer
	        $referrer=$_SERVER["SCRIPT_URI"];
	     
	    // making string from $data
	    $data_string = self::dataEncode($post_data);
	    //$data_string=implode("&",$values);
	    // Find out which port is needed - if not given use standard (=80)
	    if(!isset($URL_Info["port"]))
	        $URL_Info["port"]=80;
	    // building POST-request:
	    $request.="POST ".$URL_Info["path"]." HTTP/1.1\n";
	    $request.="Host: ".$URL_Info["host"]."\n";
	    $request.="Referer: $referrer\n";
	    $request.="Content-type: application/x-www-form-urlencoded\n";
	    $request.="Content-length: ".strlen($data_string)."\n";
	    $request.="Connection: close\n";
	    $request.="\n";
	    $request.=$data_string."\n";
	    $fp = fsockopen($URL_Info["host"],$URL_Info["port"],$errno, $errstr, 30);
	    var_dump(111);
	    fwrite($fp, $request);
	    //$res = fread($fp, 1024); //我们不关心服务器返回
	    fclose($fp);
	    var_dump(222);
	    return true;
	}
	
    
	/**
	 * POST数据组合，url传递多维数组，格式化
	 *
	 * @internal
	 * @param 数组 $data
	 * @param 字符串 $keyprefix
	 * @param 字符串 $keypostfix
	 * @return 字符串
	 */
	public static function dataEncode($data, $keyprefix = '', $keypostfix = '')
	{
	    assert(is_array($data));
	    $vars = '';
	    foreach ($data as $key => $value)
	    {
	        if (TRUE == is_array($value)) $vars .= self::dataEncode($value, $keyprefix . $key . $keypostfix . urlencode('['), urlencode(']'));
	        else $vars .= $keyprefix . $key . $keypostfix . '='.urlencode($value) . '&';
	    }
	    return $vars;
	}
}

