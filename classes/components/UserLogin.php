<?php
class UserLogin extends Pste_View {
    public function _init() {
        $this->setTemplate('components/login.php');
        $this->getUserdata();
    }
    
    protected function getUserdata() {
        $user = Pste_Registry::getInstance()->user;
        
        $this->authenticated = false;
        if (Pste_Registry::getInstance()->authenticated) {
            $this->authenticated = true;
            $this->user = $user;
        }
    }
}
