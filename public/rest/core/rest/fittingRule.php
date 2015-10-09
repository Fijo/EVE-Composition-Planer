<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Rest;
use Core\Service;

class FittingRule
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;

        $app->group('/fitting-rule', function() use ($app)   {

            $restService = new \Core\Service\RestService($app);
            $fittingRuleService = new \Core\Service\FittingRuleService();

            $restService->get('/calculate', function () use ($fittingRuleService) {
                return $fittingRuleService->calculateNewItemFilterTypes();
            });

            $restService->get('/check', function () use ($fittingRuleService) {
                return $fittingRuleService->check($_GET['name'], isset($_GET['cid']) ? intval($_GET['cid']) : null);
            });

            $restService->get('/autocomplete', function () use ($fittingRuleService) {
              return $fittingRuleService->getAutocomplete($_GET['s']);
            });

            $restService->get('/list', function () use ($fittingRuleService) {
              return $fittingRuleService->getList($_GET['type'], intval($_GET['page']));
            });

            $restService->get('/:id', function ($id) use ($fittingRuleService) {
              return $fittingRuleService->get($id);
            });

            $restService->post('/', function () use ($fittingRuleService) {
                $data = getPost();
                return $fittingRuleService->save($data);
            });

            $restService->delete('/:id', function ($id) use ($fittingRuleService) {
                return $fittingRuleService->delete($id);
            });

            $restService->post('/fork', function () use ($fittingRuleService) {
                $data = getPost();
                return $fittingRuleService->fork($data);
            });
        });
    }
}

?>