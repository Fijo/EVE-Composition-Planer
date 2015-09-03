<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;
use ECP;

class ItemFilterDefService
{
  protected $invTypeService;

  public function __construct()
  {
      $this->invTypeService = new \Core\Service\InvTypeService();
  }

  public function getItemFilterDefs()  {
    $itemFilterDefs = ECP\ItemFilterDefQuery::create()
        ->leftJoinWith('ItemFilterDef.Type')
        ->find();

    $defDict = array();
    foreach($itemFilterDefs as $itemFilterDef)
        $defDict[$itemFilterDef->getName()] = array('id' => $itemFilterDef->getId(),
                                                    'name' => $itemFilterDef->getName(),
                                                    'type' => $itemFilterDef->getType()->getName(),
                                                    'min' => $itemFilterDef->getMin(),
                                                    'max' => $itemFilterDef->getMax(),
                                                    'minlength' => $itemFilterDef->getMinlength(),
                                                    'maxlength' => $itemFilterDef->getMaxlength(),
                                                    'depth' => $itemFilterDef->getDepth());


    $categories = $this->invTypeService->getCategories();

    $groupDefContent = array();
    foreach($categories as $category)   {
        $groups = $category->getInvGroupss();
        $categoryContent = array(array('id' => 0, 'name' => 'All'));
        foreach($groups as $group)  {
            if($group->getPublished() == 0) continue;
            $categoryContent[] = array('id' => $group->getGroupID(),
                                       'name' => $group->getGroupName());
        }

        $groupDefContent[] = array('id' => $category->getCategoryID(),
                                'name' => $category->getCategoryName(),
                                'content' => $categoryContent);
    }

    $defDict['Group']['content'] = $groupDefContent;




    $metaGroups = $this->invTypeService->getMetaGroups();

    $metaGroupDefContent = array();
    foreach($metaGroups as $metaGroup)
        $metaGroupDefContent[] = array('id' => $metaGroup->getMetaGroupID(),
                                    'name' => $metaGroup->getMetaGroupName());

    $defDict['Meta group']['content'] = $metaGroupDefContent;


 

    $defDict['Slot type']['content'] = $this->invTypeService->getSlotTypes();



    $defs = array();
    foreach($defDict as $defEntry)
        $defs[] = $defEntry;

    return $defs;
  }

  public function getGroupValue($itemFilterDef, $invType, $typeContext)  {
    $itemFilterGroupName = $itemFilterDef->getName();
    switch ($itemFilterGroupName) {
      case 'CPU usage':
        return $this->invTypeService->getAttributeValue($typeContext, $invType, 'cpu');
        break;
      
      case 'Group':
        $invGroup = $invType->getInvGroups();
        return array($invGroup->getCategoryID(), $invGroup->getGroupID());
        break;
      
      case 'Meta group':
        return array($this->invTypeService->getMetaGroupId($typeContext, $invType));
        break;
      
      case 'Meta level':
        return $this->invTypeService->getAttributeValue($typeContext, $invType, 'metaLevel');
        break;
      
      case 'Name':
        return $invType->getTypeName();
        break;
      
      case 'Power usage':
        return $this->invTypeService->getAttributeValue($typeContext, $invType, 'power');
        break;
      
      case 'Slot type':
        return array($this->invTypeService->getSlotId($typeContext, $invType));
        break;
      
      case 'Volume':
        return $invType->getVolume();
        break;
      
      default:
        die('Unknown itemFilterDef.name (group name) ´'.$itemFilterGroupName.'´.');
        break;
    }
  }
}

?>