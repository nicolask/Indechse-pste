<?php

class Pste_View {
    
    private $_params = array();
    private $_template = '';
    private $_config;
    
    
    /**
     *
     * @var Pste_View $_forward 
     */
    private $_forward = null;
    
    private $_followUp = array();
    
    public function __construct($params=array())
    {
        $this->_initParams($params);
        $this->_config = Pste_Registry::getInstance()->config;
        $this->_init();
    }
    
    protected function _init() {}
    
    public function getTemplate() 
    {
        return $this->_template;
    }
    
    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    protected function _initParams($params) 
    {
        foreach($params as $key => $v) {
            $this->assign($key, $v);
        }
    }
    
    public function render($template=null) 
    {
        if (null === $this->_forward) {
        
            if (null !== $template) {
                $this->setTemplate($template);
            }

            ob_start();

            include('templates/' . $this->_config->template .'/'.$this->getTemplate());
            $content = ob_get_clean();
            foreach($this->_followUp as $comp) {
                $content.=$comp->render();
            }
            
        } else {
            $content = $this->_forward->render();
        }
        
        return $content;
    }
    
    public function forward(Pste_View $view) {
        $this->_forward = $view;
    }
    
    public function followUp(Pste_View $view) {
        $this->_followUp[] = $view;
    }
    
    public function assign($name, $value) 
    {
        if (preg_match('/^_/', $name)) return;
        $this->_params[$name] = $value;
    }
    
    public function __set($name, $value)
    {
        $this->assign($name, $value);
    }
    
    public function __get($name) 
    {
        if (isset($this->_params[$name])) {
            return $this->_params[$name];
        }
        
        return null;
    }
    
    public function __call($name, $arguments)
    {
        $classname = 'Pste_View_Helper_'.ucfirst($name);
        $helper = new $classname();
        $helper->$name($arguments);
        return $helper;
    }
}