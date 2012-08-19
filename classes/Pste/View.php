<?php
/**
 * Copyright (C) 2012 Nicolas Krueger <nicolas.krueger@gmail.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

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
        require_once('Pste/View/helpers/'.ucfirst($name).'.php');
        $helper = new $classname();
        return $helper->$name($arguments);
    }
}