<?php

class PasteArchive extends Pste_View
{

    public function _init()
    {
        $this->setTemplate('components/paste_archive.php');
        $this->getPosts();
    }

    protected function getPosts()
    {
        $db = new DB();
        $config = Pste_Registry::getInstance()->config;
        
        $pastes = $db->getAllPastes($this->request->getParam('page', 1), $config->itemsPerPage);
        
        $this->count = $db->getPasteCount();
        $this->page = $this->request->getParam('page', 1);
        $this->itemsPerPage = $config->itemsPerPage;
        $this->pastes = $pastes;
        $this->url = $config->url;
    }

}
