<?php
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
