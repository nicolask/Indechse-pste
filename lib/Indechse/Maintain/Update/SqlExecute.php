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

class Indechse_Maintain_Update_SqlExecute extends Indechse_Maintain_Update_Abstract {
    
    private $statements;
    
    public function setSql($sql) {
        $this->statements = $sql;
    }
    
    public function update()
    {
        if (null === $this->statements) {
            throw new Exception('You must provide an sql statement before calling update()!');
        }
        
        $this->_getDbCOnn()->exec($this->statements);
    }
}
