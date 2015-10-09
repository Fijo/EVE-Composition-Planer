<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;
use ECP;

class GroupPersonTypeService
{
  public function get() {
    $groupPersonTypeEntities = ECP\GroupPersonTypeQuery::create()->find();
    $result = array();

    foreach ($groupPersonTypeEntities as $entity)
      $result[$entity->getId()] = array(
        'name' => $entity->getName(),
        'title' => $entity->getTitle()
        );
    return $result;
  }

  public function getIdByName($name) {
    $groupPersonTypeDict = $this->get();
    foreach ($groupPersonTypeDict as $id => $entity)
      if($entity['name'] == $name) return $id;
    die('invalid name');
  }
}

?>