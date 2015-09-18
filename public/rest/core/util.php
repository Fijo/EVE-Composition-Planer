<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

function kill_pid($pid){ 
	if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') exec('taskkill /pid '.$pid.' /f');
    else exec('kill -15 '.$pid);
} 

function get_err($message) {
    return (object) array('status' => 'error', 'message' => $message);
};

function die_err($message) {
    die(json_encode((object) array('status' => 'error', 'message' => $message)));
};


function getPost() {
    return (object) json_decode(file_get_contents("php://input"));
};


function generateCode()    {
    return md5(rand());
}


function include_dir($folder)   {
    foreach (glob($folder.'/*.php') as $filename)
        include $filename;
}

?>