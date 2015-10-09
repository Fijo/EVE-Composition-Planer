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

class User
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;

        $app->group('/user', function() use ($app)   {

            $app->get('/autocomplete', function () {
                $userService = new \Core\Service\UserService();
                echo json_encode($userService->getAutocomplete($_GET['s']));
            });

            $app->get('/check', function () {
                $userAvailible = ECP\UserQuery::create()
                    ->filterByName($_GET['name'])
                    ->count() == 0;

                echo json_encode((object) array('isAvailible' => $userAvailible));
            });

            $app->get('/status', function () {
                $userService = new \Core\Service\UserService();

                $isLoggedIn = $userService->isLoggedIn();
                if(!$isLoggedIn)
                    die(json_encode((object) array('isLoggedIn' => false)));

                $user = $userService->getLoggedInUser();

                echo json_encode((object) array('isLoggedIn' => true, 'id' => $user->id, 'username' => $user->username));
            });

            $app->post('/login', function () {
                $p = getPost();
                $user = ECP\UserQuery::create()
                    ->filterByName($p->username)
                    ->filterByPassword(sha1($p->password))
                    ->filterByConfirmationCode('')
                    ->findOne();

                if(!$user)
                    die(json_encode((object) array('status' => 'incorrect credentials')));

                $_SESSION['ecp'] = (object) array('id' => $user->getId(), 'username' => $user->getName());

                echo $this->getBoolStatus(true);
            });

            $app->post('/register', function () {
                $userService = new \Core\Service\UserService();
                $p = getPost();
                if(strpos($p->username, '/') !== false) die_err('Slashes are not allowed in names!');

                $code = generateCode();

                $user = new ECP\User();
                $user->setName($p->username);
                $user->setPassword(sha1($p->password));
                $user->setEmail($p->email);
                $user->setCreated(time());
                $user->setConfirmationCode($code);
                $user->save();
                
                $userService->sendRegistrationMail($user);

                echo $this->getBoolStatus(true);
            });

            $app->post('/logout', function () {
                unset($_SESSION['ecp']);
                echo '{}';
            });

            $app->post('/recover-password', function () {
                $userService = new \Core\Service\UserService();
                $p = getPost();
                $users = ECP\UserQuery::create()
                    ->filterByEmail($p->email)
                    ->filterByConfirmationCode('')
                    ->find();

                foreach($users as $user)    {
                    $code = generateCode();
                    $user->setRecoverPasswordCode($code);
                    $user->save();
                    $userService->sendRecoverPassword($user);
                }

                echo $this->getBoolStatus(true);
            });

            $app->get('/reset-password-check', function () {
                $userCount = ECP\UserQuery::create()
                    ->filterByRecoverPasswordCode($_GET['code'])
                    ->count();

                echo $this->getBoolStatus($userCount != 0);
            });

            $app->post('/reset-password', function () {
                $p = getPost();
                $users = ECP\UserQuery::create()
                    ->filterByRecoverPasswordCode($p->code)
                    ->find();

                $found = false;
                foreach($users as $user)    {
                    $user->setRecoverPasswordCode('');
                    $user->setPassword(sha1($p->password));
                    $user->save();
                    $found = true;
                }

                echo $this->getBoolStatus($found);
            });

            $app->post('/confirm-registration', function () {
                $p = getPost();
                $users = ECP\UserQuery::create()
                    ->filterByConfirmationCode($p->code)
                    ->find();

                $found = false;
                foreach($users as $user)    {
                    $user->setConfirmationCode('');
                    $user->save();
                    $found = true;
                }

                echo $this->getBoolStatus($found);
            });
        });
    }

    private function getBoolStatus($found)  {
        return json_encode((object) array('status' => $found ? 'success' : 'failure'));
    }
}

?>