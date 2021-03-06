<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;
use ECP;

class InternalUserService extends EntityService
{
    public function __construct()
    {
        parent::__construct();

        $this->accessCheckService = new UserAccessCheckService();
        $this->hasUserField = false;
        $this->hasIsListedField = false;
        $this->hasGroupAccessInModel = false;
        $this->groupCheck = false;
    }

    public function getEntityName() {
        return 'User';
    }

    protected function createQuery() {
        return ECP\UserQuery::create();
    }
    
    protected function getEntity($id, $writePermissions = false)  {
        die('not implemented');
    }

    protected function getEntitySubEntities($entity) {
        die('not implemented');
    }

    protected function performSave($data, $fork)    {
        die('not implemented');
    }

    protected function removeRelatedEntityIds($data)   {
        die('not implemented');
    }

      protected function getSingleEntityId()  {
        die('not supported');
      }

    protected function extendAutocompleteModel(&$model, $entity) {}
}

class UserService
{
    public function isLoggedIn()  {
        return isset($_SESSION['ecp']);
    }

    public function getLoggedInUser()  {
        if(!$this->isLoggedIn())
            die('Acess denied! Authentication required. Please log in first!');

        return $_SESSION['ecp'];
    }

    public function tryGetLoggedInUser()  {
        if(!$this->isLoggedIn())
            return null;

        return $_SESSION['ecp'];
    }

    private function getCurrentHttpRoot()	{
    	return 'http://'.$_SERVER['SERVER_ADDR'].'/';
    }

    private function getIndexLink()	{
    	return $this->getCurrentHttpRoot();
    }

    private function getRegisterConfirmationLink($code)	{
    	return $this->getCurrentHttpRoot().'#/confirm-registration/'.$code;
    }

    private function getResetPasswordLink($code)	{
    	return $this->getCurrentHttpRoot().'#/reset-password/'.$code;
    }

    private function mail($entity, $subject, $content)	{
    	mail($entity->getEmail(), $subject, 'Dear '.$entity->getName().',

                    '.$content.'

                    Kind regards,
                    your EVE Composition Planer team');
    }

    public function sendRegistrationMail($entity)	{
    	$this->mail($entity, 'Your registration at EVE Composition Planer', 'you or someone else have attempted to create an account for you on the EVE Composition Planer Website available at '.$this->getIndexLink().'.
                    If you were indeed the person that tried to create an account you can confirm this by clicking the following link.
                    '.$this->getRegisterConfirmationLink($entity->getConfirmationCode()));
    }

    public function sendRecoverPassword($entity)	{
    	$this->mail($entity, 'Your password recovery request at EVE Composition Planer', 'you told us you have forgotten your password.
    				Well you may set a new one at
    				'.$this->getResetPasswordLink($entity->getRecoverPasswordCode()));
    }

    public function getAutocomplete($needle)  {
        $internal = new InternalUserService();
        return $internal->getAutocomplete($needle);
    }
}

?>