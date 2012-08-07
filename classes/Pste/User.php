<?php
class Pste_User
{
    protected $_conn;
    
    /**
     *
     * @var Pste_Db_User 
     */
    protected $_stmtBuilder;
    protected $_id;
    protected $_username;
    protected $_profile = null;
    
    public function __construct($id=null) {
        $this->_conn = Pste_Database::getInstance()->getConnection();
        $this->_initStatementBuilder();
        if ($id) {
            $this->_id = $id;
            $this->_populate();
        }
    }
    
    protected function _initStatementBuilder() {
        switch($this->_conn->getAttribute(PDO::ATTR_DRIVER_NAME)) {
            case 'pgsql':
                include_once('Pste/Db/Pgsql/User.php');
                $this->_stmtBuilder = new Pste_Db_Pgsql_User();
                break;
            default:
            case 'mysql':
                include_once('Pste/Db/Mysql/User.php');
                $this->_stmtBuilder = new Pste_Db_Mysql_User();
                break;
        }
    }
    
    public function find($username, $password) {
        $encPw = sha1($password);
        $sql = $this->_stmtBuilder->find();
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