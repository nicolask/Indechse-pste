<?php
class Pste_View_Helper_HeadStyle 
{
    private static $_style = array();
    
    public function addStyle($style=null, $name=null) {
        if (isset(self::$_style[$name])) {
            self::$_style[$name] .= $style;
        } else {
            self::$_style[$name] = $style;
        }
    }
    
    public function headStyle($args) {
        $numArgs = count($args);
        if ($numArgs == 1) {
            $this->addStyle($args[0], 'default');
        } else if ($numArgs == 2) {
            $this->addStyle($args[0], $args[1]);
        }
        
        return $this;
    }
    
    public function __toString()
    {
        $styles = '';
        foreach (self::$_style as $name => $item) {
            $styles .= '<style  type="text/css" id="'.$name.'">'.$item.'</style>'."\n"; 
        }
        return $styles;
    }
}