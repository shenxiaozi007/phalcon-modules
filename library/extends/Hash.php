<?php 
namespace Library\Extend;
/**
 * 加密解密类
 * $string	传字符串(不能是中文)
 * @author liuxin
 *
 */
class Hash {
	public static function userPassword($string) {
		if(preg_match('@^[a-f0-9]{32}$@', $string)) {
			return $string;
		}
		//return md5(md5($string) . sha1($string) );
		return md5(sha1(substr(md5($string), 1, 28) ) );
	}
}
