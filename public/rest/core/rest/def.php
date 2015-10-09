<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Rest;
use Core\Service;

class Def
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;

        $app->group('/def', function() use ($app)   {
            $app->get('/group-person-type', function () {
                $cacheService = new \Core\Service\CacheService();
                if($cacheService->has('group-person-type'))  {
                    echo $cacheService->get('group-person-type');
                    return;
                }

                $groupPersonTypeService = new \Core\Service\GroupPersonTypeService();
                $content = json_encode($groupPersonTypeService->get());
                $cacheService->set('group-person-type', $content);
                echo $content;
            });
        });
    }
}

?>