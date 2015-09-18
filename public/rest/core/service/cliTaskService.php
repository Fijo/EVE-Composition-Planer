<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;

class CliTaskService extends VarService
{
	public function __construct()
	{
		$this->basedir = './var/task/';
		$this->fileEnding = '';
		parent::__construct();
	}

	public function ensureOneInstance($name)	{
		$lastPid = $this->getPid($name);
		if($lastPid != -1) kill_pid($lastPid);
		$this->setPid($name, getmypid());
	}

    private function getPid($name)  {
    	$path = $this->getPath($name);
    	return is_file($path) ? file_get_contents($path) : -1;
    }

    private function setPid($name, $pid)  {
    	return file_put_contents($this->getPath($name), $pid);
    }
}

?>