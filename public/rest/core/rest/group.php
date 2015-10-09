<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Rest;
use Core\Service;

class Group
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;

        $app->group('/group', function() use ($app)   {

            $restService = new \Core\Service\RestService($app);
            $groupService = new \Core\Service\GroupService();

            $restService->get('/check', function () use ($groupService) {
                return $groupService->check($_GET['name'], isset($_GET['cid']) ? intval($_GET['cid']) : null);
            });

            $restService->get('/validation', function () use ($groupService) {
                return $groupService->getForValidation($_GET['cid']);
            });

            $restService->get('/autocomplete', function () use ($groupService) {              
              return $groupService->getAutocomplete($_GET['s']);
            });

            $restService->get('/list', function () use ($groupService) {
                return $groupService->getList($_GET['type'], intval($_GET['page']));
            });

            $restService->get('/:id', function ($id) use ($groupService) {
              return $groupService->get($id);
            });

            $restService->post('/', function () use ($groupService) {
                $data = getPost();
                return $groupService->save($data);
            });

            $restService->delete('/:id', function ($id) use ($groupService) {
                return $groupService->delete($id);
            });
        });
    }
}

?>