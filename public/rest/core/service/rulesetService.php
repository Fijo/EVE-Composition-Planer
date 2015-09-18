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
use Propel\Runtime\ActiveQuery;

class RulesetService extends EntityService
{
  protected $fittingRuleService;

  public function __construct()
  {
    parent::__construct();
    $this->fittingRuleService = new \Core\Service\FittingRuleService();
  }

  protected function getEnityName() {
    return 'RulesetEntity';
  }
  
  protected function createQuery() {
    return ECP\RulesetEntityQuery::create();
  }

  protected function getEntity($id) {
    return $this->getSingleEntity($this->populateSubentities($this->addOrder($this->prefechSubentities($this->createQuery()
      ->filterById($id)))
      ->find()));
  }

  protected function getEntityForValidation($id) {
    return $this->getSingleEntity($this->populateSubentities($this->addOrder($this->prefechSubentities($this->createQuery()
      ->filterById($id)))
      ->find()));
  }

  private function populateSubentities($rows) {
    $rows->populateRelation('RulesetShip');
    $rows->populateRelation('User');
    return $rows;
  }

  private function prefechSubentities($query) {
    return $query->joinWith('RulesetEntity.RulesetRuleRow')
              ->joinWith('RulesetRuleRow.RulesetFilterRule')
              ->joinWith('RulesetFilterRule.FittingRuleEntity');
  }

  private function addOrder($query) {
    return $query->orderBy('RulesetRuleRow.ind3x')
                ->orderBy('RulesetFilterRule.ind3x');
  }

  
  public function getContextForValidation($entity) {
    $context = array();
    $context['fittingRuleEntityIds'] = $this->getFittingRuleEntityIds($entity);
    $context['fittingRuleEntities'] = $this->fittingRuleService->getFittingRuleEntitiesForValidation($context['fittingRuleEntityIds']);
    return $context;
  }

  private function getFittingRuleEntityIds($entity)  {
    $fittingRuleEntityIds = array();
    foreach ($entity->getRulesetRuleRows() as $ruleRow)
      foreach ($ruleRow->getRulesetFilterRules() as $filterRule)  {
        $fittingRuleEntityId = $filterRule->getFittingRuleEntityId();
        if(in_array($fittingRuleEntityId, $fittingRuleEntityIds)) continue;
        $fittingRuleEntityIds[] = $fittingRuleEntityId;
      }
    return $fittingRuleEntityIds;
  }

  public function getForValidation($id)  {
    $entity = $this->getEntityForValidation($id); // should be optimized maybe
    if($entity == null) return $this->getNotFound();

    $context = $this->getContextForValidation($entity);
    $data = $this->getMappedModel($entity);
    $this->cleanupDataForValidation($data);

    $data['fittingFiltersUptodate'] = $this->areFittingFilterTypesUptodate($context);
    $data['fittings'] = $this->mapFittingsToModel($context, $entity);
    return $data;
  }

  private function areFittingFilterTypesUptodate($context) {
    foreach ($context['fittingRuleEntities'] as $fittingRuleEntity)
      if(!$fittingRuleEntity->getIsFilterTypeUptodate()) return false;

    return true;
  }

  private function mapFittingsToModel($context, $entity) {
    $dataFittings = array();
    foreach ($context['fittingRuleEntities'] as $fittingRuleEntity)
      $dataFittings[] = $this->fittingRuleService->getForValidation($fittingRuleEntity);

    return $dataFittings;
  }

  public function get($id)  {
    $entity = $this->getEntity($id);
    if($entity == null) return $this->getNotFound();
    return $this->getMappedModel($entity);
  }

  private function getMappedModel($entity) {    
    $data = $this->getLocalyMappendModel($entity);
    $data['minPilots'] = $entity->getMinPilots();
    $data['maxPilots'] = $entity->getMaxPilots();
    $data['maxPoints'] = $entity->getMaxPoints();
    $data['ships'] = $this->mapShipsToModel($entity);
    $data['rules'] = $this->mapRuleRowsToModel($entity);
    return $data;
  }

  private function mapShipsToModel($entity)  {
    $dataShips = array();
    foreach ($entity->getRulesetShips() as $ship)
      $dataShips[$ship->getShipId()] = $ship->getPoints();
    return $dataShips;
  }

  private function mapRuleRowsToModel($entity)  {
    $dataRuleRows = array();
    foreach ($entity->getRulesetRuleRows() as $ruleRow)
      $dataRuleRows[] = array('id' => $ruleRow->getId(),
                              'message' => $ruleRow->getMessage(),
                              'fittingRules' => $this->mapFilterRulesToModel($ruleRow));
    return $dataRuleRows;
  }

  private function mapFilterRulesToModel($ruleRow)  {
      $dataFilterRules = array();
      foreach ($ruleRow->getRulesetFilterRules() as $filterRule)  {
        $dataFilterRules[] = array('id' => $filterRule->getId(),
                                'concatenation' => $this->createIdObj($filterRule->getConcatenation()),
                                'tag' => $this->getAutocompleteModel($filterRule->getFittingRuleEntity()),
                                'comparison' => $this->createIdObj($filterRule->getComparison()),
                                'value' => $filterRule->getValue());
      }
      return $dataFilterRules;
  }

  protected function performSave($data, $fork)  {
    $entity = $this->getLocalyMappedEntityToSave($data, $fork);
    $entity->setMinPilots($data->minPilots);
    $entity->setMaxPilots($data->maxPilots);
    $entity->setMaxPoints($data->maxPoints);


    $shipDict = array();
    foreach ($entity->getRulesetShips() as $ship)
      $shipDict[$ship->getShipId()] = $ship;

    $shipDict = (object) $shipDict;
    foreach ($data->ships as $dataShipId => $dataShipPoints) {
      $iShipId = intval($dataShipId);

      $shipExists = property_exists($shipDict, $iShipId);
      $ship = null;
      if($shipExists) $ship = $shipDict[$iShipId];
      else {
        $ship = new ECP\RulesetShip();
        $ship->setShipId($iShipId);
      }

      $ship->setPoints($dataShipPoints);
      $this->prepareSubentitySave2($entity, 'RulesetShip', $ship, !$shipExists);
    }


    $ruleRowIndex = 0;
    foreach ($data->rules as $dataRuleRow) {
      $ruleRow = $this->getSubentity($entity, 'RulesetRuleRow', $dataRuleRow);

      $ruleRow->setInd3x($ruleRowIndex++);
      $ruleRow->setMessage($dataRuleRow->message);

      $filterRuleIndex = 0;
      foreach ($dataRuleRow->fittingRules as $dataFilterRule) {
        $filterRule = $this->getSubentity($ruleRow, 'RulesetFilterRule', $dataFilterRule);

        $filterRule->setInd3x($filterRuleIndex);
        if($filterRuleIndex == 0) $filterRule->setConcatenation(0);
        else if(property_exists($dataFilterRule, 'concatenation'))
          $filterRule->setConcatenation($dataFilterRule->concatenation->id);
        $filterRule->setFittingRuleEntityId($dataFilterRule->tag->id);
        $filterRule->setComparison($dataFilterRule->comparison->id);
        $filterRule->setValue($dataFilterRule->value);

        $this->prepareSubentitySave($ruleRow, 'RulesetFilterRule', $filterRule, $dataFilterRule);
        $filterRuleIndex++;
      }

      $this->cleanupOldEnties($ruleRow, 'RulesetFilterRule', $dataRuleRow->fittingRules);
      $this->prepareSubentitySave($entity, 'RulesetRuleRow', $ruleRow, $dataRuleRow);
    }

    $this->cleanupOldEnties($entity, 'RulesetRuleRow', $data->rules);
    $entity->save();

    return $this->createIdObj($entity->getId());
  }

  protected function removeRelatedEntityIds($data) {
    foreach ($data->rules as $dataRuleRow) {
      unset($dataRuleRow->id);
      foreach ($dataRuleRow->fittingRules as $dataFilterRule) {
        unset($dataFilterRule->id);
      }
    }
  }
}

?>