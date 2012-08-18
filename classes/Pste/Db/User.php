<?php
/**
 * Copyright (C) 2012 Nicolas Krueger <nicolas.krueger@gmail.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

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
