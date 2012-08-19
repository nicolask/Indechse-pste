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

class Pste_View_Helper_HeadTitle
{
    private static $_title = '';
    
    public function setTitle($title=null, $mode='append') {
        if ($mode == 'append') {
            self::$_title = self::$_title . " - " . $title;
        } else if ($mode == 'prepend') {
            self::$_title = $title  . " - " . self::$_title; 
        } else {
            self::$_title = $title;
        }
    }
    
    public function headTitle($args) {
        $numArgs = count($args);
        if ($numArgs == 1) {
            $this->setTitle($args[0], 'append');
        } else if ($numArgs == 2) {
            $this->setTitle($args[0], $args[1]);
        }
        
        return $this;
    }
    
    public function __toString()
    {
        return self::$_title;
    }
}
