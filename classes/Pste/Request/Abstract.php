<?php
abstract class Pste_Request_Abstract
{
    
    protected $_post;
    protected $_get;
    protected $_request;
    protected $_cookie;
    
    public final function __construct() {
        $this->_init();
    }
    
    protected abstract function _init();
    
    public final function getParam($param, $default=null) {
        if ($this->hasParam($param)) {
            return $this->_request[$param];
        }
        
        return $default;
    }
    
    public final function getParams() {
        return $this->_request;
    }
    
    public final function getPostParam($param, $default=null) {
        if ($this->hasParam($param)) {
            return $this->_post[$param];
        }
        
        return $default;
    }
    
    public final function getGetParam($param, $default=null) {
        if ($this->hasParam($param)) {
            return $this->_get[$param];
        }
        
        return $default;
    }
    
    public final function hasParam($param, $type='REQUEST') {
        $data = null;
        switch ($type) {
            case 'POST':
                $data = $this->_post;
                break;
            case 'GET':
                $data = $this->_get;
                break;
            case 'COOKIE':
                $data = $this->_cookie;
                break;
            case 'REQUEST':
            default:
                $data = $this->_request;
                break;
        }
        if (isset($data[$param])) {
            return true;
        }
        
        return false;
    }
}