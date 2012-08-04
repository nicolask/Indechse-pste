<?php
class Pste_Registry {
    
    private $_items = array();
    
    private static $_instance;
    
    private function __construct() {
        
    }
    
    public static function getInstance() {
        if (!(self::$_instance instanceof Pste_Registry)) {
            self::$_instance = new Pste_Registry();
        }
        
        return self::$_instance;
    }
    
    public function __set($name, $value)
    {
        $this->_items[$name] = $value;
    }
    
    public function __get($name)
    {
        if (array_key_exists($name, $this->_items)) {
            return $this->_items[$name];
        }
        
        return null;
    }
}