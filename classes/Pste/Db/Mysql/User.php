<?php
/**
 * Description of User
 *
 * @author Nicolas Krueger <krueger@white-paper-media.de>
 */
include_once('Pste/Db/User.php');
class Pste_Db_Mysql_User extends Pste_Db_User
{
    public function find() {
        $sql = 'SELECT id, username FROM `'.$this->_getTableName().'` WHERE username = :username AND password = :password';
        
        return $sql;
    }
}
