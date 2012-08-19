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

class User
{
    protected $_conn;
    
    /**
     *
     * @var \Pste\Db\User 
     */
    protected $_stmtBuilder;
    protected $_id;
    protected $_username;
    protected $_profile = null;
    
    public function __construct($id=null) {
        $this->_conn = \Pste\Database::getInstance()->getConnection();
        $this->_initStatementBuilder();
        if ($id) {
            $this->_id = $id;
            $this->_populate();
        }
    }
    
    protected function _initStatementBuilder() {
        $this->_stmtBuilder = \Pste\Db\User::getBuilder($this->_conn);
    }
    
    public function find($username, $password) {
        $encPw = sha1($password);
        $sql = $this->_stmtBuilder->find();
        $stmt = $this->_conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $encPw);
        $result = $stmt->execute();
        
        if ($result) {
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$data) return false;
            
            $this->_populate($data);
            return true;
        }
        
        return false;
        
    }
    
    protected function _populate($data=null) {
        if (is_array($data)) {
            $this->_id = $data['id'];
            $this->_username = $data['username'];
        }
        
        /**
         *  @todo implement user profile
         */
    }
    
    public function toArray() {
        return array('id' => $this->_id, 'username' => $this->_username);
    }
    
    public function setFromArray($data) {
        $this->_id = $data['id'];
        $this->_username = $data['username'];
    }
    
    public function getUsername() {
        return $this->_username;
    }
    
    public function getId()
    {
        return $this->_id;
    }

}