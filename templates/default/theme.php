<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=iso-8859-1" />
        <title><?= new Pste_View_Helper_HeadTitle(); ?></title>
        <script type="text/javascript" src="<?php echo $CONF['url'] . 'templates/' . $CONF['template'] ?>/tab.js"></script>
        <link rel="shortcut icon" href="<?php echo $CONF['url'] . 'templates/' . $CONF['template'] ?>/images/favicon.ico" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $CONF['url'] . 'templates/' . $CONF['template'] ?>/style.css" />
        <?php
        if (isset($page['post']['codecss'])) {
            echo '<style type="text/css">' . "\n";
            echo $page['post']['codecss'];
            echo '</style>' . "\n";
        }
        ?>
    </head>
    <body>
        <div class="header">
            <a href="<?php echo $CONF['url'] ?>">
                <img src="<?php echo $CONF['url'] . 'templates/' . $CONF['template'] ?>/images/logo.png" alt="<?php echo $CONF['title'] ?>" title="<?php echo $CONF['title'] ?>" class="logo" />
            </a>
            <ul class="tabs">
                <li><a href="<?php echo $CONF['url'] ?>" title="Submit a new paste">Submit</a></li>
                <li><a href="<?php echo $CONF['url'] ?>?archive" title="List all public pastes">Archive</a></li>
            </ul>
        </div>
        <div id="menu">
            <?= Pste_Component::add(new RecentItems()); ?>
            
        </div>
        

        <div id="content"><br />
            <h1>Welcome! Here you can paste sources and general debugging text, 
                You can even set yourself a password if you want to keep it just for yourself.</h1>
                <?php
// Show errors.
                if (count($pastebin->errors)) {
                    echo "<h1>ERROR</h1><div id=\"errors\"><ul>";
                    foreach ($pastebin->errors as $err) {
                        echo "<li>$err</li>";
                    }
                    echo "</ul></div>";
                    $page['post']['editcode'] = $_POST['code2'];
                    $page['current_format'] = $_POST['format'];
                    $page['expiry'] = $_POST['expiry'];

                    if ($_POST['password'] != 'EMPTY') {
                        $page['post']['password'] = $_POST['password'];
                    }
                    $page['poster'] = $_POST['poster'];
                }

                ?>
                <?= $content ?>
                <br />
                
                <h1>&copy; <?php echo date("Y"); ?> - Powered by <a href="https://github.com/nicolask/indechse-paste">Indechse Paste</a> 0.1</h1>
                <?= Pste_Component::add(new StaticPage(array('template' => 'components/credits.php'))); ?> 
            
        </div>
    </body>
</html>
