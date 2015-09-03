<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Rest;
use Core\Service;
use ECP;
use Propel\Runtime\ActiveQuery;

class RuleDef
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;

        $app->group('/rule-def', function() use ($app)   {

            $app->get('/comparison', function () {
                $cacheService = new \Core\Service\CacheService();
                if($cacheService->has('rule-def-comparsion'))  {
                    echo $cacheService->get('rule-def-comparsion');
                    return;
                }

                $typeService = new \Core\Service\TypeService();
                $content = json_encode($typeService->getTypeComparisons());
                $cacheService->set('rule-def-comparsion', $content);
                echo $content;
            });

            $app->get('/item-filter', function () {
                $cacheService = new \Core\Service\CacheService();
                if($cacheService->has('rule-item-filter'))  {
                    echo $cacheService->get('rule-item-filter');
                    return;
                }

                $itemFilterDefService = new \Core\Service\ItemFilterDefService();
                $content = json_encode($itemFilterDefService->getItemFilterDefs());
                $cacheService->set('rule-item-filter', $content);
                echo $content;
            });

        });
    }
}

?>