<?php
abstract class Maintain_Update_Abstract
{
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
