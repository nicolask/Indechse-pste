<?php
class Config {
    
    private $_config = array();
    
    public function __construct($config) {
        $this->_config = $config;
    }
    
    public function __get($name) {
        if (array_key_exists($name, $this->config) && is_array($this->_config[$name])) {
            return new Config($name);
        }
        
        return $this->_config[$name];
    }
}
