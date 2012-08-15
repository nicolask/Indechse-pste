<?php
/**
 * Description of Route
 *
 * @author Nicolas Krueger <krueger@white-paper-media.de>
 */
class Pste_Route
{
    private $base_path = '';
    private $template_path = '';
    
    public function __construct()
    {
        $this->_init();
    }
    
    public function templateRessourceUrl($file) {
        return $this->base_path.'/templates/'.$this->template_path.'/'.$file;
    }
    
    public function setTemplatePath($path) {
        $this->template_path = $path;
    }
    
    public function url($target='') {
        return $this->base_path.'/'.$target;
    }
    
    private function _init() {
        $server_name = $_SERVER['SERVER_NAME'];
        $server_port = $_SERVER['SERVER_PORT'];
        $document_root = $_SERVER['DOCUMENT_ROOT'];
        $script_filename = $_SERVER['SCRIPT_FILENAME'];
        
        $dr = split(DIRECTORY_SEPARATOR, $document_root);
        $sf = split(DIRECTORY_SEPARATOR, $script_filename);
        
        array_pop($sf);
        $path = array_diff($sf, $dr);
        if (count($path) > 0) {
            $this->base_path = "/".implode('/',$path);
        } else {
            $this->base_path = "";
        }
        
    }
}
