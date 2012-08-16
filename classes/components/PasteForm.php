<?php
class PasteForm extends Pste_View
{
    public function _init() {
        $this->setTemplate('components/paste_form.php');
        $this->_initData();
    }
    
    protected function _initData() {
        $db = new DB();
        $conf = Pste_Registry::getInstance()->config;
        
        
        $emptyPost = array(
            'pid' => null,
            'poster' => null,
            'posted' => null,
            'code' => '',
            'parent_pid' => null,
            'format' => $conf->default_highlighter,
            'codefmt' => '',
            'expiry_flag' => 'f',
            'codecss' => null,
            'expires' => null,
            'password' => null
        );
        
        if (!$this->request->hasParam('show')) {
            $post = $emptyPost;
        } else {

            $pid = $this->request->getParam('show');

            $post = $db->getPaste($pid);
            if (!$post) {
                return $this->forward(new StaticPage(array('template' => 'components/paste_invalid.php')));
            }

            $postPass = $this->request->hasParam('thePassword') ? $this->request->getParam('thePassword') : null;
            $pass = $post['password'];

            $restrictedPost = (null !== $pass && $pass !== sha1("EMPTY")) ? true : false;
            $accessAllowed = (!$restrictedPost || (sha1($postPass) == $pass)) ? true : false;
            $passwordFail = ($restrictedPost && null !== $postPass && $postPass !== $pass) ? true : false;

            if (!$accessAllowed) {
                require_once 'components/StaticPage.php';
                return $this->forward(new StaticPage(array('template' => 'components/paste_password.php', 'fail' => $passwordFail)));
            }
            $post['password'] = $this->request->getParam('thePassword', '');
        }
        
        $this->post = $post;
        $this->geshiformats = $conf->get('geshiformats');
        $this->popular_syntax = $conf->get('popular_syntax');
        $this->highlight_prefix = $conf->get('highlight_prefix');
    }
}