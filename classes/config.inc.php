<?php
/*
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
 
$CONF=array();

// Include the configration file
require_once('config.php');

//Set the database to use: postgresql, mysql
$CONF['database']='postgresql';

//path for the pastebin => for http:/domain/pastebin/
$CONF['pastebin']='/pastebin';

// Pull in the required database class.
switch($CONF['database']){
    case "postgresql":
        require_once('classes/postgresql.php');
        break;
    case "mysql":
        require_once('classes/mysql.php');
        break;
}
?>
