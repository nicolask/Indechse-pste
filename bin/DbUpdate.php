<?php
error_reporting(-1);
ini_set('display_errors', '1');

define('APP_PATH', realpath(dirname(__FILE__).'/..'));
define('LIB_PATH', APP_PATH.'/lib');

set_include_path(LIB_PATH .PATH_SEPARATOR.  get_include_path());

require_once 'Indechse/Database.php';

require_once APP_PATH.'/config_dbmaintain.php';
require_once 'Indechse/Maintain/UpdateTool.php';
require_once 'Indechse/Maintain/Update/Abstract.php';

$mt = new Indechse_Maintain_UpdateTool(APP_PATH.'/database/updates', Indechse_Database::getInstance()->getConnection());
$mt->run();