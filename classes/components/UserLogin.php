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

namespace Pste\Component;

class UserLogin extends \Pste\View {
    public function _init() {
        $this->setTemplate('components/login.php');
        $this->getUserdata();
    }
    
    protected function getUserdata() {
        $user = \Pste_Registry::getInstance()->user;
        
        $this->authenticated = false;
        if (\Pste_Registry::getInstance()->authenticated) {
            $this->authenticated = true;
            $this->user = $user;
        }
    }
}
