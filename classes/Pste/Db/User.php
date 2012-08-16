<?php
/**
 * Description of User
 *
 * @author Nicolas Krueger <krueger@white-paper-media.de>
 */
namespace Pste\Db;

abstract class User
{
    protected $_tableName = 'user';
    
    /**
     * 
     * @param \PDO $dbConn
     * @return \Pste\Db\User
     * @throws Exception
     */
    public static function getBuilder(\PDO $dbConn) {
        $stmtBuilder = null;
        
        $driver_name = $dbConn->getAttribute(\PDO::ATTR_DRIVER_NAME);
        
        switch($driver_name) {
            case 'pgsql':
                include_once('Pste/Db/Pgsql/User.php');
                $stmtBuilder = new Pgsql\User();
                break;
            default:
            case 'mysql':
                include_once('Pste/Db/Mysql/User.php');
                $stmtBuilder = new Mysql\User();
                break;
        }
        
        if (null === $stmtBuilder) {
            throw new Exception(sprintf("No statement builder for driver '%s'", $driver_name));
        }
        
        return $stmtBuilder;
    }
    
    protected function _getTableName() {
        return $this->_tableName;
    }
    
    public function find() {
        $sql = 'SELECT id, username FROM "'.$this->_getTableName().'" WHERE username = :username AND password = :password';
        
        return $sql;
    }
}
