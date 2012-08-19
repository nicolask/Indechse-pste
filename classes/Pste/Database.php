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

namespace Pste;

class Database 
{
    private static $_instance;
    
    private $_conn;
    
    private function __construct() {
        
    }
    
    /**
     *
     * @return Pste\Database 
     */
    public static function getInstance() {
        if (!(self::$_instance instanceof \Pste\Database)) {
            self::$_instance = new \Pste\Database();
        }
        
        return self::$_instance;
    }
    
    /**
     *
     * @param \PDO $connection
     * @param string $name 
     */
    public function setConnection(\PDO $connection, $name='default') {
        $this->_conn[$name] = $connection;
    }
    
    /**
     *
     * @param string $name
     * @return \PDO
     */
    public function getConnection($name='default') {
        if ($this->_conn[$name] instanceof \PDO) {
            return $this->_conn[$name];
        }
        
        return null;
    }
    
    public function createConnection($driver, $host, $dbname, $username, $password, $name='default') {
        switch ($driver) {
            case 'pgsql':
            case 'postgres':
            case 'postgresql':
                $this->_conn[$name] = new \PDO("pgsql:host={$host};dbname={$dbname};user={$username};password={$password}");
                break;
            case 'mysql':
                $this->_conn[$name] = new \PDO("mysql:host={$host};dbname={$dbname}",$username, $password);
                break;
            default:
                throw new Exception(sprintf("unsupported database driver '%s'", $driver));
        }
        $this->_conn[$name]->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        
    }
}