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

namespace Pste;

class Config {
    
    private $_config = array();
    
    public function __construct($config) {
        $this->_config = $config;
    }
    
    public function __get($name) {
        if (array_key_exists($name, $this->_config) && is_array($this->_config[$name])) {
            return new Config($name);
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
