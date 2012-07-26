<?php
class Request_Http extends Request_Abstract
{
    protected function _init() {
       $this->_post = $_POST;
       $this->_get = $_GET;
       $this->_request = $_REQUEST;
       $this->_cookie = $_COOKIE;
    }
}