<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;

class RestService
{
	protected $app;

	public function __construct($app)
	{
		$this->app = $app;
	}

    public function __call($func,$arguments){
    	$actualFunc = $arguments[1];
    	
    	$arguments[1] = function() use ($actualFunc)	{
    		try	{
    			echo json_encode(call_user_func_array($actualFunc, func_get_args()));
			}
			catch(ECPException $ex)	{
				echo json_encode($ex->toObj());
			}
    	};

        call_user_func_array(array($this->app, $func), $arguments);
    }
}

?>