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

abstract class Indechse_Maintain_Update_Abstract
{
    const DRIVER_PGSQL = 'pgsql';
    const DRIVER_MYSQL = 'mysql';
    
    /**
     *
     * @var PDO 
     */
    private $_conn;
    private $_revision;
    
    public final function __construct(PDO $db, $revision) {
        $this->_conn = $db;
        $this->_revision = $revision;
    }
    
    abstract function update();
    
    /**
     * returns the drivername for the current PDO-Instance 
     * 
     * @return string PDO driver
     */
    public final function _getDriver() {
        $drivername = $this->_conn->getAttribute(PDO::ATTR_DRIVER_NAME);
        $driver = null;
        switch($drivername) {
            case 'pgsql':
                $driver = self::DRIVER_PGSQL;
                break;
            case 'mysql':
                $driver = self::DRIVER_MYSQL;
                break;
            default:
                throw Exception("unsupported PDO driver '{$drivername}'");
        }
        return $driver;
    }
    
    public final function isPgSQL() {
        if ($this->_getDriver()==self::DRIVER_PGSQL) {
            return true;
        }
        return false;
    }
    
    public final function isMySQL() {
        if ($this->_getDriver()==self::DRIVER_MYSQL) {
            return true;
        }
        return false;
    }
    
    /**
     * @return PDO 
     */
    protected final function _getDbCOnn() {
        return $this->_conn;
    }
    
    public final function getRevision() {
        return $this->_revision;
    }
}
