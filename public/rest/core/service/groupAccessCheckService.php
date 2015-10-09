<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;
use ECP;

class GroupAccessCheckService extends AccessCheckServiceBase
{
	protected $groupPersonTypeService;

	public function __construct($entityType) {
	parent::__construct($entityType);

		$this->groupPersonTypeService = new GroupPersonTypeService();
	}

	protected function filterAccessableIdQuery($writePermissions, $query)	{
		if(!$writePermissions) return $query;

		return $query->where('GroupPerson.groupPersonTypeId = ?', $this->groupPersonTypeService->getIdByName('admin'));
	}

	public function saveGroupAccess($connection, $entity, $groupIds)	{
		//todo verify relations

		$entityTypeObj = ECP\EntityTypeQuery::create()->filterByName($this->entityType)->findOne();
		$entityId = $entity->getId();

		$groupAccess = ECP\GroupAccessQuery::create()
			->filterByEntityTypeId($entityTypeObj->getId())
			->filterByEntityId($entityId)
			->filterByGroupId($entityId)
			->findOneOrCreate();

		if($groupAccess->isNew()) $groupAccess->save($connection);
	}
}

?>