<?php
/**
 * Copyright (C) 2012 Nicolas Krueger <nicolas.krueger@gmail.com>
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