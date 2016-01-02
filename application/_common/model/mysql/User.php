<?php 
namespace App\M;
use App\M\BaseMysqlDb;
class User extends BaseMysqlDb {
    protected $table = 'user';
    protected $primaryKey = 'userId';
    protected $fillable = array('userId','username','password','nickname','mobile','mobileprefixId','userAvatar','addTime','isDel');
    
}