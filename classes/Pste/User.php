<?php
class Pste_User
{
    protected $_conn;
    protected $_id;
    protected $_username;
    protected $_profile = null;
    
    public function __construct($id=null) {
        $this->_conn = Pste_Database::getInstance()->getConnection();
        if ($id) {
            $this->_id = $id;
            $this->_populate();
        }
    }
    
    public function find($username, $password) {
        $encPw = sha1($password);
        if ($this->_driver == 'pgsql') {
            $sql = 'SELECT id, username FROM "user" WHERE username = :username AND password = :password';
        } else {
            $sql = 'SELECT id, username FROM `user` WHERE username = :username AND password = :password';
        }
        $stmt = $this->_conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $encPw);
        $result = $stmt->execute();
        
        if ($result) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
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