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

class Pste_View_Helper_HeadStyle 
{
    private static $_style = array();
    
    public function addStyle($style=null, $name=null) {
        if (isset(self::$_style[$name])) {
            self::$_style[$name] .= $style;
        } else {
            self::$_style[$name] = $style;
        }
    }
    
    public function headStyle($args) {
        $numArgs = count($args);
        if ($numArgs == 1) {
            $this->addStyle($args[0], 'default');
        } else if ($numArgs == 2) {
            $this->addStyle($args[0], $args[1]);
        }
        
        return $this;
    }
    
    public function __toString()
    {
        $styles = '';
        foreach (self::$_style as $name => $item) {
            $styles .= '<style  type="text/css" id="'.$name.'">'.$item.'</style>'."\n"; 
        }
        return $styles;
    }
}