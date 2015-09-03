<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Rest;
use Core\Service;
use EVE;
use ECP;

class FittingRule
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;

        $app->group('/fitting-rule', function() use ($app)   {

            $app->get('/check', function () {
                $fittingRuleService = new \Core\Service\FittingRuleService();
                echo json_encode($fittingRuleService->check($_GET['name'], isset($_GET['cid']) ? intval($_GET['cid']) : null));
            });

            $app->get('/autocomplete', function () {
              $fittingRuleService = new \Core\Service\FittingRuleService();
              echo json_encode($fittingRuleService->getAutocomplete($_GET['s']));
            });

            $app->get('/list', function () {
              $fittingRuleService = new \Core\Service\FittingRuleService();
              echo json_encode($fittingRuleService->getList($_GET['type'], intval($_GET['page'])));
            });

            $app->get('/:id', function ($id) {
              $fittingRuleService = new \Core\Service\FittingRuleService();
              echo json_encode($fittingRuleService->get($id));
            });

            $app->post('/', function () {
                $data = getPost();
                $fittingRuleService = new \Core\Service\FittingRuleService();
                echo json_encode($fittingRuleService->save($data));
            });

            $app->delete('/:id', function ($id) {
                $fittingRuleService = new \Core\Service\FittingRuleService();
                echo json_encode($fittingRuleService->delete($id));
            });

            $app->post('/fork', function () {
                $data = getPost();
                $fittingRuleService = new \Core\Service\FittingRuleService();
                echo json_encode($fittingRuleService->fork($data));
            });
        });
    }
}

?>