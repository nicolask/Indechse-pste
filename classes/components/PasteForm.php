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

namespace Pste\Component;

class PasteForm extends \Pste_View
{
    public function _init() {
        $this->setTemplate('components/paste_form.php');
        $this->_initData();
    }
    
    protected function _initData() {
        $conf = \Pste_Registry::getInstance()->config;
        
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
            $paste = new \Pste\Model\Paste($pid);
            
            $post = $paste->getContent();
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