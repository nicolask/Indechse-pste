<?php

/**
 * copy this file to config.php
 * then modify to match your needs
 * 
 * you can override all the options available in classes/default_config.php
 * 
 * you must at least set your database connection and url here
 * 
 */

$CONF['dbhost']='localhost';
$CONF['dbname']='database';
$CONF['dbuser']='user';
$CONF['dbpass']='password';

// set the driver for your database (pgsql|mysql)
$CONF['driver'] = 'driver';

// This should be the URL to your pastebin. eg: http://paste.info.tm/ or http://paste.info.tm/subdir/
$CONF['url']='http://local.paste:8080/';// Make sure you end it with a forward slash! (/)

// the name of the template you want to use (the folder as displayed in /templates/)
$CONF['template']='default';

// Site title (Appears in the <title></title> tags)
$CONF['title']='PASTE - The name says it all.';

// Timezone
$CONF['timezone']='Europe/Berlin';

// very basic auth config
// set to true, if only logged in users shall see the pastes
$CONF['restrict_show'] = false;