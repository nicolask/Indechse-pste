<?php
/*
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
namespace Pste\Model;

class Paste {
    
    private $_id;
    
    public function __construct($id) {
        $this->_id = $id;
    }
    
    public function getContent() {
        if (null === $this->_id) {
            return null;
        }
        
        $db = new \DB();
        
        $post = $db->getPaste($this->_id);
        
        if (!$post) {
            return null;
        }
        
        if (empty($post['format']) ) {
            $post['format'] = 'text';
        }
        
        return $post;
    }
}