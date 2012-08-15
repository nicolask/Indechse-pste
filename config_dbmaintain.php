<?php
/**
 * copy this file to config.php
 * customize this config file to your projects needs 
 * 
 * just be aware that you initialize Indechse_Database with your 
 * database credentials at the end
 */

include APP_PATH.'/config.php';

$toolConfig['database'] = array(
    'driver' => $CONF['driver'],
    'user' => $CONF['dbuser'],
    'password' => $CONF['dbpass'],
    'host' => $CONF['dbhost'],
    'database' => $CONF['dbname']
);

Indechse_Database::getInstance()->createConnection(
        $toolConfig['database']['driver'], 
        $toolConfig['database']['host'], 
        $toolConfig['database']['database'], 
        $toolConfig['database']['user'], 
        $toolConfig['database']['password']
    );  