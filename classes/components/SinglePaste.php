<?php

class SinglePaste extends Pste_View
{

    public function _init()
    {
        $this->setTemplate('components/single_paste.php');
        $this->getPaste();
    }

    /**
     * get the data for the paste-poste
     * 
     * @todo modify title of page
     * 
     * @return type 
     */
    public function getPaste()
    {
        $db = new DB();
        $conf = Pste_Registry::getInstance()->config;

        $pid = $this->pid;

        $post = $db->getPaste($pid);
        if (!$post) {
            return $this->forward(new StaticPage(array('template' => 'components/paste_invalid.php')));
        }
        
        $this->followUp(new PasteForm(array('request' => $this->request)));

        $postPass = $this->request->hasParam('thePassword') ? $this->request->getParam('thePassword') : null;
        $pass = $post['password'];

        $restrictedPost = (null !== $pass && $pass !== sha1("EMPTY")) ? true : false;
        $accessAllowed = (!$restrictedPost || (sha1($postPass) == $pass)) ? true : false;
        $passwordFail = ($restrictedPost && null !== $postPass && $postPass !== $pass) ? true : false;

        if (!$accessAllowed) {
            require_once 'components/StaticPage.php';
            return $this->forward(new StaticPage(array('template' => 'components/paste_password.php', 'fail' => $passwordFail)));
        }

        $paste = $post;

        // Show a quick reference url, poster and parents .        
        $expires = ((is_null($post['expires'])) ? "Never Expires" : ("Expires on " . date("F D jS g:i A", strtotime($post['expires']))));
        $paste['posttitle'] = "Posted as {$post['poster']} on {$post['postdate']} - {$expires}";




        // Preprocess
        $highlight = array();
        $prefix_size = strlen($this->conf['highlight_prefix']);
        if ($prefix_size) {
            $lines = explode("\n", $post['code']);
            $paste['editcode'] = "";
            foreach ($lines as $idx => $line) {
                if (substr($line, 0, $prefix_size) == $conf['highlight_prefix']) {
                    $highlight[] = $idx + 1;
                    $line = substr($line, $prefix_size);
                }
                $paste['editcode'].=$line . "\n";
            }
            $paste['editcode'] = rtrim($post['editcode']);
        }
        // Get formatted version of code
        if (strlen($post['codefmt']) > 0) {
            $paste['codefmt'] = $post['codefmt'];
        } else {
            $geshi = new GeSHi($paste['editcode'], $post['format']);

            $geshi->enable_classes();
            $geshi->set_header_type(GESHI_HEADER_DIV);
            $geshi->set_line_style('background: #ffffff;', 'background: #f4f4f4;');
            if (count($highlight)) {
                $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
                $geshi->highlight_lines_extra($highlight);
                $geshi->set_highlight_lines_extra_style('color:black;background:#FFFF88;');
            } else {
                $geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS, 2);
            }

            $paste['codefmt'] = $geshi->parse_code();
            $paste['codecss'] = $geshi->get_stylesheet();

            // Save it!
            //$db->saveFormatting($pid, $post['codefmt'], $post['codecss']);
        }
        $paste['pid'] = $pid;
        $paste['downloadurl'] = $conf->url.$post['pid'];

        $this->post = $paste;
    }

}