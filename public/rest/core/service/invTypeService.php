<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;
use EVE;
use ECP;

class InvTypeService
{
  public $slotEffectNames = array('loPower', 'medPower', 'hiPower', 'rigSlot');
  public $requiredDgmAttributes = array('cpu', 'power', 'metaLevel');

  public function getTypeContext() {
    return (object) array(
        'types' => $this->filterIssueGroups(EVE\InvTypesQuery::create()
                ->joinWith('InvTypes.InvGroups'))
                ->where('InvGroups.published = ?', 1)
                ->filterByPublished(1)
                ->find(),
        'metaTypes' => $this->getTypeIdDict(EVE\InvMetaTypesQuery::create()
                          ->join('InvMetaTypes.InvTypes')
                          ->where('InvTypes.published = ?', 1)
                          ->find()),
        'effects' => $this->getTypeIdDict($this->filterBySlotEffects(EVE\DgmTypeEffectsQuery::create()
                      ->join('DgmTypeEffects.InvTypes')
                      ->join('DgmTypeEffects.DgmEffects'))
                      ->where('InvTypes.published = ?', 1)
                      ->where('DgmEffects.published = ?', 1)
                      ->find()),
        'attributes' => $this->getTypeIdDict($this->filterRequiredDgmAttributes(EVE\DgmTypeAttributesQuery::create()
                          ->join('DgmTypeAttributes.InvTypes')
                          ->joinWith('DgmTypeAttributes.DgmAttributeTypes')) // possible candidate for optimization
                          ->where('InvTypes.published = ?', 1)
                          ->where('DgmAttributeTypes.published = ?', 1)
                          ->find()) 
    );
  }

  private function getTypeIdDict($rows)  {
    $dict = array();
    foreach ($rows as $row) {
      $typeId = $row->getTypeID();
      if(isset($dict[$typeId])) $dict[$typeId][] = $row;
      else $dict[$typeId] = array($row);
    }
    return $dict;
  }

  private function getEntriesById($typeDict, $type)  {
    $typeId = $type->getTypeID();
    if(!isset($typeDict[$typeId])) return array();
    return $typeDict[$typeId];
  }

  private function createInQueryFilter($query, $field, $values) {
    $condNames = array();
    foreach($values as $i => $value) {
      $condName = 'c_'.$i;
      $query = $query->condition($condName, $field.' = ?', $value);
      $condNames[] = $condName;
    }
    $query = $query->where($condNames, 'or');
    return $query;    
  }

  private function filterBySlotEffects($query)  {
    return $this->createInQueryFilter($query, 'DgmEffects.effectName', $this->slotEffectNames);
  }

  private function filterRequiredDgmAttributes($query)  {
    return $this->createInQueryFilter($query, 'DgmAttributeTypes.attributeName', $this->requiredDgmAttributes);
  }

  public function getItems()  {
    $types = EVE\InvTypesQuery::create()
        ->filterByPublished(1)
        ->find();

    $contentTypes = array();
    foreach($types as $type)
        $contentTypes[] = (object) array('id' => $type->getTypeID(),
                                        'name' => $type->getTypeName(),
                                        'volume' => $type->getVolume(),
                                        'capacity' => $type->getCapacity());
    return $contentTypes;
  }

  public function getCategories() {
    return $this->filterIssueGroups(EVE\InvCategoriesQuery::create()
                                      ->filterByPublished(1)
                                      ->leftJoinWith('InvCategories.InvGroups'))
                                      ->orderByCategoryName()
                                      ->orderBy('InvGroups.groupName')
                                      ->find();
  }

  private function filterIssueGroups($query)  {
    return $query->where('InvGroups.groupID != ?', 1395)
                ->where('InvGroups.groupID != ?', 1396);
  }

  //http://wiki.eve-id.net/CPU_and_Powergrid_requirements_for_modules
  public function getAttributeValue($typeContext, $type, $attributeName)  {
    $attributes = $this->getEntriesById($typeContext->attributes, $type);
    foreach ($attributes as $attribute) {
      $attributeType = $attribute->getDgmAttributeTypes();
      if($attributeType->getAttributeName() != $attributeName) continue;
      $valueFloat = $attribute->getValueFloat();
      if($valueFloat !== null) return $valueFloat;
      $valueInt = $attribute->getValueInt();
      if($valueInt !== null) return $valueInt;
      die('No value for (type id: ´'.$type->getTypeID().'´, attribute id: ´'.$attributeType->getAttributeID().'´)');
    }
    return false;
  }

  public function getSlotId($typeContext, $type)  {
    $effects = $this->getEntriesById($typeContext->effects, $type);
    foreach ($effects as $effect) {
      //if(!in_array($effect->DgmEffects()->getEffectName(), $this->slotEffectNames)) die('I thought we already had that checked within the query...');
      return $effect->getEffectID();
    }
    return false;
  }

  public function getSlotTypes()  {
    $slotTypes = EVE\DgmEffectsQuery::create()
        ->filterByEffectName($this->slotEffectNames)
        ->filterByPublished(1)
        ->find();

    $slotTypeContent = array();
    foreach($slotTypes as $slotType)
        $slotTypeContent[] = array('id' => $slotType->getEffectID(),
                                    'name' => $slotType->getDisplayName());
    return $slotTypeContent;
  }

  public function getMetaGroups() {
    return EVE\InvMetaGroupsQuery::create()
        ->useInvMetaTypesQuery()
        ->endUse()
        ->groupBy('InvMetaGroups.metaGroupID')
        ->orderByMetaGroupName()
        ->find();
  }

  public function getMetaGroupId($typeContext, $type) {
    $invMetaTypes = $this->getEntriesById($typeContext->metaTypes, $type);
    if(count($invMetaTypes) == 0) return false;
    return $invMetaTypes[0]->getMetaGroupId();
  }

  public function getShipGroups() {    
    $groups = EVE\InvGroupsQuery::create()
        ->useInvCategoriesQuery()
            ->filterByCategoryname('Ship')
            ->filterByPublished(1)
        ->endUse()
        ->filterByPublished(1)
        ->leftJoinWith('InvGroups.InvTypes')
        ->orderByGroupName()
        ->orderBy('InvTypes.typeName')
        ->find();


    $resultGroup = array();
    foreach($groups as $group)    {
        $types = $group->getInvTypess();

        $contentTypes = array();
        foreach($types as $type)    {
            if($type->getPublished() == 0) continue;
            $contentTypes[] = (object) array('id' => $type->getTypeID(),
                                    'name' => $type->getTypeName());
        }

        $resultGroup[] = (object) array('name' => $group->getGroupName(),
                        'content' => $contentTypes);
    }
    return $resultGroup;
  }
}

?>