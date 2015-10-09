<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;
use ECP;

class AccessCheckService extends AccessCheckServiceBase
{
	protected function filterAccessableIdQuery($writePermissions, $query)	{
		return $query;
	}

	public function getGroupAccess($entity)	{
		$entityId = $entity->getId();
		$groupAccessDict = $this->getGroupAccesss(array($entityId));
		return array_key_exists($entityId, $groupAccessDict) ? $groupAccessDict[$entityId] : array();
	}

	public function getGroupAccesss($entityIds)	{
		$groupAccessEntries = ECP\GroupAccessQuery::create()
			->leftJoin('GroupAccess.EntityType')
			->leftJoinWith('GroupAccess.Group')
			->where('EntityType.name = ?', $this->entityType)
			->filterByEntityId($entityIds)
			->find();

		$groupAccessDict = array();
		foreach ($groupAccessEntries as $groupAccessEntry)	{
			$entityId = $groupAccessEntry->getEntityId();
			if(!array_key_exists($entityId, $groupAccessDict)) $groupAccessDict[$entityId] = array($groupAccessEntry->getGroup());
			else $groupAccessDict[$entityId][] = $groupAccessEntry->getGroup();
		}
		return $groupAccessDict;
	}

	public function saveGroupAccess($connection, $entity, $groupIds)	{
		//todo verify relations

		$groupIds = array_values(array_unique($groupIds, SORT_REGULAR));

		$entityTypeObj = ECP\EntityTypeQuery::create()->filterByName($this->entityType)->findOne();
		$entityId = $entity->getId();

		$groupAccessEntities = ECP\GroupAccessQuery::create()
			->filterByEntityId($entityId)
			->filterByEntityType($entityTypeObj)
			->find();

		$existingGroups = array();
		foreach ($groupAccessEntities as $groupAccessEntity) {
			$groupId = $groupAccessEntity->getGroupId();
			if(in_array($groupId, $groupIds)) $existingGroups[] = $groupId;
			else $groupAccessEntity->delete($connection);	
		}

		foreach ($groupIds as $groupId)
			if(!in_array($groupId, $existingGroups))	{
				$groupAccessEntity = new ECP\GroupAccess();
				$groupAccessEntity->setEntityType($entityTypeObj);
				$groupAccessEntity->setEntityId($entityId);
				$groupAccessEntity->setGroupId($groupId);
				$groupAccessEntity->save($connection);
			}
	}
}

?>