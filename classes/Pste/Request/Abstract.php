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

abstract class Pste_Request_Abstract
{
    
    protected $_post;
    protected $_get;
    protected $_request;
    protected $_cookie;
    protected $_session;
    
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
            case 'SESSION':
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