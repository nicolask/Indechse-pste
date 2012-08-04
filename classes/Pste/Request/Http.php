<?php
class Pste_Request_Http extends Pste_Request_Abstract
{
    protected function _init() {
       $this->_post = $_POST;
       $this->_get = $_GET;
       $this->_request = $_REQUEST;
       $this->_cookie = $_COOKIE;
    }
}