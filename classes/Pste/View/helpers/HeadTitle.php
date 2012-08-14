<?php
class Pste_View_Helper_HeadTitle
{
    private static $_title = '';
    
    public function setTitle($title=null, $mode='append') {
        if ($mode == 'append') {
            self::$_title = self::$_title . " - " . $title;
        } else if ($mode == 'prepend') {
            self::$_title = $title  . " - " . self::$_title; 
        } else {
            self::$_title = $title;
        }
    }
    
    public function headTitle($args) {
        $numArgs = count($args);
        if ($numArgs == 1) {
            $this->setTitle($args[0], 'append');
        } else if ($numArgs == 2) {
            $this->setTitle($args[0], $args[1]);
        }
    }
    
    public function __toString()
    {
        return self::$_title;
    }
}
