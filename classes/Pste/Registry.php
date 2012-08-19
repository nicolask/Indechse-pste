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

class Registry {
    
    private $_items = array();
    
    private static $_instance;
    
    private function __construct() {
        
    }
    
    public static function getInstance() {
        if (!(self::$_instance instanceof Registry)) {
            self::$_instance = new Registry();
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