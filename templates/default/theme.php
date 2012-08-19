<?php
require_once('Pste/View/helpers/HeadStyle.php');
$config = \Pste\Registry::getInstance()->config;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf8" />
        <title><?= new Pste_View_Helper_HeadTitle(); ?></title>
        <script type="text/javascript" src="<?= $this->route()->templateRessourceUrl('tab.js') ?>"></script>
        <link rel="shortcut icon" href="<?= $this->route()->templateRessourceUrl('/images/favicon.ico') ?>" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?= $this->route()->templateRessourceUrl('style.css') ?>" />
        <?php echo new Pste_View_Helper_HeadStyle() ?>
    </head>
    <body>
        <div class="header">
            <a href="<?= $this->route()->url() ?>">
                <img src="<?= $this->route()->templateRessourceUrl('/images/logo.png') ?>" alt="<?php echo $config->title ?>" title="<?php echo $config->title ?>" class="logo" />
            </a>
            <ul class="tabs">
                <li><?= \Pste\Component::add(new \Pste\Component\UserLogin(array('request' => $this->request))) ?></li>
                <li><a href="<?= $this->route()->url('?submit') ?>" title="Submit a new paste">Submit</a></li>
                <li><a href="<?= $this->route()->url('?archive') ?>" title="List all public pastes">Archive</a></li>
            </ul>
        </div>
        <div id="menu">
            <?= \Pste\Component::add(new \Pste\Component\RecentItems()); ?>
        </div>
        
        <div id="content"><br />
            <h1>Welcome! Here you can paste sources and general debugging text, 
                You can even set yourself a password if you want to keep it just for yourself.</h1>
                <?= $this->content ?>
                <br />
                
                <h1>&copy; <?php echo date("Y"); ?> - Powered by <a href="https://github.com/nicolask/indechse-pste">Indechse Pste</a> 0.1 
                    - rendered in <?= round(microtime(true) - \Pste\Registry::getInstance()->starttime, 4)  ?></h1>
                <?= \Pste\Component::add(new \Pste\Component\StaticPage(array('template' => 'components/credits.php'))); ?> 
            
        </div>
    </body>
</html>