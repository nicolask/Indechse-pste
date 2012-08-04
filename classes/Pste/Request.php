<?php
require_once('Pste/Request/Abstract.php');

class Pste_Request
{
    const REQUEST_HTTP = 'http';
    
    private static $_instance = array();
    
    /**
     * returns the request instance of the given type
     * 
     * @param string $type
     * @return Response_Abstract 
     */
    public static function getInstance($type=self::REQUEST_HTTP) {
        if (!(isset(self::$_instance[$type]) && self::$_instance[$type] instanceof Pste_Request_Abstract)) {
            self::_createInstance($type);
        }
        
        return self::$_instance[$type];
    }
    
    public static function setInstance(Pste_Request_Abstract $request, $type=self::REQUEST_HTTP) {
        self::$_instance[$type] = $request;
    }
    
    /**
     *
     * @param string $type
     * @return Request_Abstract
     * @throws Pste_RequestException 
     */
    private static function _createInstance($type) {
        if ($type==self::REQUEST_HTTP) {
            require_once('Pste/Request/Http.php');
            self::setInstance(new Pste_Request_Http());
        } else {
            throw new Pste_RequestException('unknown request type');
        }
    }
}

class Pste_RequestException extends LogicException {}