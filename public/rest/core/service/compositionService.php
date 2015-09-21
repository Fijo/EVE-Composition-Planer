<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;
use ECP;

class CompositionService extends EntityService
{
  protected function getEnityName() {
    return 'CompositionEntity';
  }

  protected function createQuery() {
    return ECP\CompositionEntityQuery::create();
  }

  protected function getEntity($id) {
    return $this->getSingleEntity($this->createQuery()
      ->filterById($id)
      ->joinWith('CompositionEntity.RulesetEntity')
      ->leftJoinWith('CompositionEntity.CompositionRow')
      ->leftJoinWith('CompositionRow.FitEntry')
      ->leftJoinWith('FitEntry.FitEntryType')
      ->orderBy('FitEntry.ind3x')
      ->find());
  }

  public function get($id)  {
    $entity = $this->getEntity($id);
    if($entity == null) return $this->getNotFound();
    
    $data = $this->getLocalyMappendModel($entity);

    $data['ruleset'] = $this->getAutocompleteModel($entity->getRulesetEntity());
    $data['content'] = $this->mapContentRowsToModel($entity);
    return $data;
  }

  private function mapContentRowsToModel($entity)  {
    $dataRows = array();
    foreach ($entity->getCompositionRows() as $compositionRow)  {
      $shipId = $compositionRow->getShipId();
      $dataRows[] = array('id' => $compositionRow->getId(),
                          'shipId' => $shipId,
                          'notes' => $compositionRow->getNotes(),
                          'fit' => array('content' => array('header' => array('shipType' => $shipId, 'shipName' => $compositionRow->getFitName()),
                                                           'body' => $this->mapFittingBodyToModel($compositionRow))));
    }
    return $dataRows;
  }

  private function mapFittingBodyToModel($compositionRow)  {
      $dataFitBody = array();
      foreach ($compositionRow->getFitEntries() as $fitEntry)  {
        $entryType = $fitEntry->getFitEntryType();
        $dataFitEntry = array();
        if($entryType->getName() != 'none') $dataFitEntry['type'] = $entryType->getName();
        if($fitEntry->getItemId() != 0) $dataFitEntry['item'] = $fitEntry->getItemId();
        if($fitEntry->GetAmmoId() != 0) $dataFitEntry['ammo'] = $fitEntry->GetAmmoId();
        if($fitEntry->getAmount() != 0) $dataFitEntry['amount'] = $fitEntry->getAmount();
        $dataFitBody[] = $dataFitEntry;
      }
      return $dataFitBody;
  }

  protected function performSave($data, $fork)  {
    $fitEntryType = array();
    $fitEntryTypes1 = ECP\FitEntryTypeQuery::create()->find();
    foreach ($fitEntryTypes1 as $fitEntryType1)
      $fitEntryType[$fitEntryType1->getName()] = $fitEntryType1->getId();

    $entity = $this->getLocalyMappedEntityToSave($data, $fork);
    $entity->setRulesetEntityId($data->ruleset->id);

    foreach ($data->content as $dataRow) {
      $compositionRow = $this->getSubentity($entity, 'CompositionRow', $dataRow);

      $compositionRow->setShipId($dataRow->shipId);
      $compositionRow->setNotes(property_exists($dataRow, 'notes') ? $dataRow->notes : '');

      $dataFitContent = $dataRow->fit->content;
      $compositionRow->setFitName($dataFitContent->header->shipName);


      $fitEntries = $compositionRow->getFitEntries();
      $fitEntryIndex = 0;
      foreach ($dataFitContent->body as $dataFitEntry) {
        $fitEntryExists = count($fitEntries) > $fitEntryIndex;
        $fitEntry = null;
        if($fitEntryExists) $fitEntry = $fitEntries[$fitEntryIndex];
        else {
          $fitEntry = new ECP\FitEntry();
          $fitEntry->setInd3x($fitEntryIndex);
        }

        $fitEntry->setFitEntryTypeId($fitEntryType[ property_exists($dataFitEntry, 'type') ? $dataFitEntry->type : 'none' ]);
        $fitEntry->setItemId( property_exists($dataFitEntry, 'item') ? $dataFitEntry->item : 0 );
        $fitEntry->setAmmoId( property_exists($dataFitEntry, 'ammo') ? $dataFitEntry->ammo : 0 );
        $fitEntry->setAmount( property_exists($dataFitEntry, 'amount') ? $dataFitEntry->amount : 0 );

        $this->prepareSubentitySave2($compositionRow, 'FitEntry', $fitEntry, !$fitEntryExists);
        $fitEntryIndex++;
      }

      for(; $fitEntryIndex < count($fitEntries); $fitEntryIndex++)
        $compositionRow->removeFitEntry($fitEntries[$fitEntryIndex]);
      

      $this->prepareSubentitySave($entity, 'CompositionRow', $compositionRow, $dataRow);
    }

    $this->cleanupOldEnties($entity, 'CompositionRow', $data->content);
    $entity->save();

    return $this->createIdObj($entity->getId());
  }

  protected function removeRelatedEntityIds($data) {
    foreach ($data->content as $dataRow) {
      unset($dataRow->id);
    }
  }
}

?>