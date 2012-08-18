<?php
/**
 * Project: Indechse Pste
 * 
 * Copyright (C) 2012 Nicolas Krueger <nicolas.krueger@gmail.com>
 * Copyright (C) 2010 EcKstasy <eckstasy@escriptirc.com> 
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
 */

// Includes
require_once('classes/bootstrap.php');

date_default_timezone_set($CONF['timezone']);
error_reporting(-1);
ini_set('display_errors', '1');

$request = Pste_Request::getInstance();
$config = Pste_Registry::getInstance()->config;

try {
    // authentication
    $auth = new \Pste\Auth($request);
    if (!$auth->isAuthenticated()) {
        Pste_Registry::getInstance()->authenticated = false;
    } else {
        Pste_Registry::getInstance()->authenticated = true;
        Pste_Registry::getInstance()->user = $auth->getUser();
    }
    
    /// Clean up older posts 
    //    $pastebin->doGarbageCollection();

    // Process new posting
    $errors = array();
    if ($request->hasParam('paste')) { /* Process posting and redirect */
        $id = $pastebin->doPost($_POST);
        if ($id) {
            $pastebin->redirectToPost($id);
            exit;
        }
    }
    
    if ($request->hasParam('show') && (($config->restrict_show && Pste_Registry::getInstance()->authenticated) || !$config->restrict_show)) {
        require_once('components/SinglePaste.php');
        $content = Pste_Component::add(new SinglePaste(array('pid' => $request->getParam('show'), 'request' => $request)));
    } else if ($request->hasParam('archive')) {
        require_once('components/PasteArchive.php');
        $content = Pste_Component::add(new PasteArchive(array('page' => $request->getParam('page'), 'request' => $request)));
    } else if ($request->hasParam('submit', 'GET')) {
        $content = Pste_Component::add(new PasteForm(array('request' => $request)));
    } else if ($request->hasParam('info', 'GET') && Pste_Registry::getInstance()->authenticated) {
        phpinfo();die();
    } else {
        $content = Pste_Component::add(new StaticPage(array('template' => 'components/frontpage.php', 'request' => $request)));
    }
    
    $layout = new Pste_Layout(array('request' => $request));
    $layout->setContent($content);
    $layout->setTemplate('theme.php');
    
    ob_start();
    echo $layout->render();
    ob_end_flush();
} catch (Exception $ex) {
    header('Content-type: text/plain');
    echo "An error occured\n";
    echo $ex->getMessage() . "\n";
    echo $ex->getTraceAsString();
}