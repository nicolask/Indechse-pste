<?php
class Pste_Config {
    
    private $_config = array();
    
    public function __construct($config) {
        $this->_config = $config;
    }
    
    public function __get($name) {
        if (array_key_exists($name, $this->_config) && is_array($this->_config[$name])) {
            return new Pste_Config($name);
        }
        
        return $this->_config[$name];
    }
    
    public function toArray() {
        return $this->_config;
    }
    
    public function get($name) {
        if (!array_key_exists($name, $this->_config)) {
            return null;
        }
        return $this->_config[$name];
    }
}
