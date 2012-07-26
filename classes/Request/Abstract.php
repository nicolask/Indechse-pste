<?php
abstract class Request_Abstract
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
    
    public final function hasParam($param) {
        if (isset($this->_request[$param])) {
            return true;
        }
        
        return false;
    }
}