<?php 
namespace App\M;
use App\M\BaseMysqlDb;
class User extends BaseMysqlDb {
    protected $table = 'user';
    protected $primaryKey = 'userId';
    protected $fillable = array('username','password','mobile','addTime','isDel','modifyTime');
    /**
     * 获取用户信息
     * @param array $where
     */
    public function getUserMsg($where) {
        $userRes = self::setWhere($where)
                        ->get(array('userId','username','mobile','isDel'))
                        ->toArray();
        $user = $userRes ? $userRes[0] : array();
        return $user;
    }
}