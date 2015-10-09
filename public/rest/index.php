<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

session_cache_limiter(false);
session_start();

require 'vendor/autoload.php';

require 'config/database/config.php';
require 'config/main.php';


\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(array(
    'mode' => 'development',
    'debug' => true
    ));


new \Core\Rest\Index($app);
new \Core\Rest\User($app);
new \Core\Rest\ShipGroup($app);
new \Core\Rest\RuleDef($app);
new \Core\Rest\Item($app);
new \Core\Rest\Def($app);
new \Core\Rest\FittingRule($app);
new \Core\Rest\Ruleset($app);
new \Core\Rest\Composition($app);
new \Core\Rest\Group($app);

$app->run();




/*
function print_sql_result($sql) {
    $query = mysql_query($sql);
    if($rows = mysql_fetch_array($query))
        echo json_encode($rows);
    mysql_free_result($query);
};

function print_single_sql_result($sql)  {
    $query = mysql_query($sql);
    if($row = mysql_fetch_object($query))
        echo json_encode($row);
    mysql_free_result($query);  
};
 

function swtich_db($config, $mysql, $databaseKey)    {
    $databaseName = $config->mysql->databases[$databaseKey];
    if(!mysqli_select_db($mysql, $databaseName))
        die_err('Could not swtich to databse with dbKey ´'.$databaseKey.'´');
}

$myServer = $config->mysql->server;
if(!$mysql = new mysqli($myServer->address, $myServer->user, $myServer->password))
    die_err('Could not connect to database server');
$mysql->close();

*/
