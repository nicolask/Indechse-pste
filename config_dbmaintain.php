<?php
/**
 * customized configuration for DbMaintain
 * 
 * no need to change this
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

Indechse_Database::getInstance()->getConnection()->exec("SET NAMES 'utf8'");