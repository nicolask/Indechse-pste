<?php

class StaticPage extends Pste_View
{
    public function _init() {
        $this->setTemplate($this->template);
    }
}