<?php
/**
 * Copyright (C) 2012 Nicolas Krueger <nicolas.krueger@gmail.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

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
