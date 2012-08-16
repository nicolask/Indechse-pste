<?php
/**
 * Description of User
 *
 * @author Nicolas Krueger <krueger@white-paper-media.de>
 */
namespace Pste\Db\Mysql;

include_once('Pste/Db/User.php');
class User extends \Pste\Db\User
{
    public function find() {
        $sql = 'SELECT id, username FROM `'.$this->_getTableName().'` WHERE username = :username AND password = :password';
        
        return $sql;
    }
}
