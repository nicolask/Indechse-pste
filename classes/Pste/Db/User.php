<?php
/**
 * Description of User
 *
 * @author Nicolas Krueger <krueger@white-paper-media.de>
 */
abstract class Pste_Db_User
{
    protected $_tableName = 'user';
    
    protected function _getTableName() {
        return $this->_tableName;
    }
    
    public function find() {
        $sql = 'SELECT id, username FROM "'.$this->_getTableName().'" WHERE username = :username AND password = :password';
        
        return $sql;
    }
}
