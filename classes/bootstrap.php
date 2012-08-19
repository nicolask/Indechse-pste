<?php
/*
 * Copyright (C) 2012 Nicolas Krueger <nicolas.krueger@gmail.com>
 * Copyright (C) 2010 EcKstasy <eckstasy@escriptirc.com>
 *               2011 Roberto Rodríguez Pino <rodpin@gmail.com>
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
 
$starttime = microtime(true);

$CONF=array();

define('APP_PATH', realpath(dirname(__FILE__)."/.."));
define('CLASS_PATH', APP_PATH."/classes");
define('LIB_PATH', APP_PATH."/lib");

set_include_path(LIB_PATH.PATH_SEPARATOR
                .CLASS_PATH.PATH_SEPARATOR
                .APP_PATH.PATH_SEPARATOR
                .get_include_path());

// Include the configration file

require_once('default_config.php');
require_once(APP_PATH.'/config.php');

require_once('classes/geshi/geshi.php');
require_once('classes/diff.php');
require_once('classes/paste.php');

require_once('Pste/View/helpers/HeadTitle.php');
require_once('Pste/View/helpers/Route.php');

\Pste\Registry::getInstance()->starttime = $starttime;

//path for the pastebin => for http:/domain/pastebin/
$CONF['pastebin']='';

// Pull in the required database class.
switch($CONF['driver']){
    case "postgresql":
    case "pgsql":
    case "postgres":
        \Pste\Database::getInstance()->createConnection('pgsql', 
                $CONF["dbhost"], $CONF['dbname'], $CONF["dbuser"], $CONF["dbpass"]);
        require_once('classes/db.php');
        break;
    case "mysql":
        \Pste\Database::getInstance()->createConnection('mysql', 
                $CONF["dbhost"], $CONF['dbname'], $CONF["dbuser"], $CONF["dbpass"]);
        require_once('classes/db.php');
        break;
}

\Pste\Database::getInstance()->getConnection()->exec("SET NAMES 'utf8'");

$ht = new Pste_View_Helper_HeadTitle();
$ht->setTitle('Pste', 'replace');

/**
 * wrapper for config instance creation so the instance does not live in global
 * scope 
 */
function bootstrap($configuration_array) {
    $config = new \Pste\Config($configuration_array);
    \Pste\Registry::getInstance()->config = $config;
    $route = new \Pste\Route();
    $route->setTemplatePath($config->template);
    \Pste\Registry::getInstance()->route = $route;
}

function __autoload($class) {
    $nsSplit = explode('\\', $class);
    if (count($nsSplit) >= 2 && $nsSplit[0] == 'Pste') {
        if (count($nsSplit) == 3) {
            // some special rules for components and models
            if ($nsSplit[1] == 'Component') {
                require_once('components/'.$nsSplit[2].'.php');
            } else if ($nsSplit[1] == 'Model') {
                require_once('models/'.$nsSplit[2].'.php');
            } else {
                require_once(implode('/',$nsSplit).'.php');
            }
        } else {
            require_once(implode('/',$nsSplit).'.php');
        }
    }
}

bootstrap($CONF);

