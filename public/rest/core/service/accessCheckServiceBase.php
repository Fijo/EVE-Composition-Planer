<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;
use ECP;

abstract class AccessCheckServiceBase
{
	protected $entityType;
	protected $userService;

	public function __construct($entityType)
	{
		$this->entityType = $entityType;
		$this->userService = new \Core\Service\UserService();
	}

	abstract protected function filterAccessableIdQuery($writePermissions, $query);

	protected function getAccessableIdQuery($user, $writePermissions)	{
		return $this->filterAccessableIdQuery($writePermissions, ECP\GroupAccessQuery::create()
        	->leftJoin('GroupAccess.EntityType')
        	->leftJoin('GroupAccess.Group')
        	->leftJoin('Group.GroupPerson'))
			->where('EntityType.name = ?', $this->entityType)
			->where('GroupPerson.userId = ?', $user->id);
	}

	public function hasAccess($entityId, $writePermissions = false)	{
        $user = $this->userService->tryGetLoggedInUser();
        if($user == null) return false;

        return $this->getAccessableIdQuery($user, $writePermissions)
        	->filterByEntityId($entityId)
        	->count() > 0;
	}

	public function getAccessableIds($writePermissions = false)	{
        $user = $this->userService->tryGetLoggedInUser();
        if($user == null) return array();
		$groupAccessEntries = $this->getAccessableIdQuery($user, $writePermissions)
			->select(array('GroupAccess.entityId'))
			->find();

		$result = array();
		foreach ($groupAccessEntries as $groupAccessEntry) $result[] = intval($groupAccessEntry);

		return $result;
	}

	public function deleteGroupAccess($connection, $entity)	{
		ECP\GroupAccessQuery::create()
			->leftJoin('GroupAccess.EntityType')
			->where('EntityType.name = ?', $this->entityType)
			->filterByEntityId($entity->getId())
			->delete($connection);
	}
}

?>