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
        if (!(isset(self::$_instance[$type]) && self::$_instance[$type] instanceof \Pste\Request\RequestAbstract)) {
            self::_createInstance($type);
        }
        
        return self::$_instance[$type];
    }
    
    public static function setInstance(\Pste\Request\RequestAbstract $request, $type=self::REQUEST_HTTP) {
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
            require_once('Pste/Request/Http.php');
            self::setInstance(new \Pste\Request\Http());
        } else {
            throw new RequestException('unknown request type');
        }
    }
}

class RequestException extends \LogicException {}