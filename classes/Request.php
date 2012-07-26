<?php
require_once(dirname(__FILE__).'/Request/Abstract.php');

class Request
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
        if (!(isset(self::$_instance[$type]) && self::$_instance[$type] instanceof Request_Abstract)) {
            self::_createInstance($type);
        }
        
        return self::$_instance[$type];
    }
    
    public static function setInstance(Request_Abstract $request, $type=self::REQUEST_HTTP) {
        self::$_instance[$type] = $request;
    }
    
    /**
     *
     * @param string $type
     * @return Request_Abstract
     * @throws RequestException 
     */
    private static function _createInstance($type) {
        if ($type==self::REQUEST_HTTP) {
            require_once(dirname(__FILE__).'/Request/Http.php');
            self::setInstance(new Request_Http());
        } else {
            throw new RequestException('unknown request type');
        }
    }
}

class RequestException extends LogicException {}