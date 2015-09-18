<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Rest;

class ShipGroup
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;

        $app->get('/ship-group', function () {
            $cacheService = new \Core\Service\CacheService();
            if($cacheService->has('ship-group'))  {
                echo $cacheService->get('ship-group');
                return;
            }

            $invTypeService = new \Core\Service\InvTypeService();
            $content = json_encode($invTypeService->getShipGroups());
            $cacheService->set('ship-group', $content);
            echo $content;           
        });
    }
}

?>