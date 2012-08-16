<?php
namespace Pste;

class Auth
{
    /**
     *
     * @var Pste-Request_Abstract $_request 
     */
    private $_request;
    
    private $_user;
    
    private $_authenticated;
    
    /**
     *
     * @param \Pste_Request_Abstract $request 
     */
    public function __construct(\Pste_Request_Abstract $request) {
        $this->_request = $request;
    }
    
    public function isAuthenticated() {
        if ($this->_request->hasParam('logout')) {
            $this->_logout();
            return false;
        }
        
        if ($this->_request->hasParam('auth')) {
            $this->_authenticated = $this->_checkLogin();
        } else {
            $this->_authenticated = $this->_checkSession();
        }
        if ($this->_authenticated) {
            return true;
        }
        
        return false;
    }
    
    protected function _checkLogin() {
        if (!($this->_request->hasParam('username') && $this->_request->hasParam('password'))) {
            return false;
        }
        
        $username = $this->_request->getParam('username', '');
        $password = $this->_request->getParam('password', '');
        
        $user = new \Pste\Models\User();
        $this->_user = $user;
        $ok = $user->find($username, $password);
        if ($ok) {
            session_start();
            $_SESSION['user'] = $user->toArray();
            return true;
        }
        return false;
    }
    
    protected function _checkSession() {
        session_start();
        if (!isset($_SESSION['user'])) {
            return false;
        }
        
        $user = new \Pste\Models\User();
        $user->setFromArray($_SESSION['user']);
        $this->_user = $user;
        return true;
    }
    
    protected function _logout() {
        session_start();
        session_unset();
        session_destroy();
    }
    
    public function getUser() {
        return $this->_user;
    }
}