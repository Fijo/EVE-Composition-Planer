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

class FittingRuleService extends EntityService
{
  protected $comparsionService;
  protected $itemFilterDefService;

  public function __construct()
  {
    parent::__construct();
    $this->comparsionService = new \Core\Service\ComparsionService();
    $this->itemFilterDefService = new \Core\Service\ItemFilterDefService();
  }


  protected function getEnityName() {
    return 'FittingRuleEntity';
  }

  protected function createQuery() {
    return ECP\FittingRuleEntityQuery::create();
  }

  protected function getEntity($id) {
    return $this->getSingleEntity($this->addOrder($this->prefechSubentities($this->createQuery()
      ->filterById($id)))
      ->find());
  }

  public function populateContextForValidation(&$context) {
    $context['comparisons'] = $this->getDictById(ECP\ComparisonQuery::create()->find());
  }

  private function prefechSubentities($query) {
    return $query->joinWith('FittingRuleEntity.FittingRuleRow')
                ->joinWith('FittingRuleRow.ItemFilterRule')
                ->joinWith('ItemFilterRule.ItemFilterDef')
                ->joinWith('ItemFilterDef.Type');
  }

  private function addOrder($query) {
    return $query->orderBy('FittingRuleRow.ind3x')
                ->orderBy('ItemFilterRule.ind3x');
  }

  public function getFittingRuleEntitiesForValidation($fittingRuleEntityIds) {
    $entities = $this->addOrder($this->prefechSubentities(ECP\FittingRuleEntityQuery::create())
                ->filterById($fittingRuleEntityIds))
                ->find();
    $entities->populateRelation('User');
    return $entities;
  }

  public function getForValidation($context, $typeContext, $entity)  {
    $data = $this->getLocalyMappendModel($entity);

    $data['name'] = $this->getUniqueName($entity);
    $this->cleanupDataForValidation($data);
    $data['rules'] = $this->mapFittingRuleRowsToModelForValidation($context, $typeContext, $entity);
    return $data;
  }

  private function mapFittingRuleRowsToModelForValidation($context, $typeContext, $entity)  {
    $dataRuleRows = array();
    foreach ($entity->getFittingRuleRows() as $fittingRuleRow)  {
      $dataRuleRow = $this->mapFittingRuleRowToModel($fittingRuleRow);
      $dataRuleRow['itemFilterRules'] = $this->mapItemFilterRulesToModelForValidation($context, $typeContext, $fittingRuleRow);
      $dataRuleRows[] = $dataRuleRow;
    }
    return $dataRuleRows;
  }

  private function mapItemFilterRulesToModelForValidation($context, $typeContext, $fittingRuleRow)  {
    $types = $typeContext->types;
    $typeStateDict = array();
    $comparisonDict = $context['comparisons'];
    foreach ($types as $type) $typeStateDict[$type->getTypeID()] = true;

    foreach ($fittingRuleRow->getItemFilterRules() as $filterRule)  {
      $itemFilterDef = $filterRule->getItemFilterDef();

      $b = $this->getItemFilterRuleValue($filterRule, $itemFilterDef);

      $comparison = $comparisonDict[$filterRule->getComparison()];
      $concatenationId = $filterRule->getConcatenation();
      $concatenation = $concatenationId != 0 ? $comparisonDict[$concatenationId] : null;

      foreach($types as $type)  {
        $a = $this->itemFilterDefService->getGroupValue($itemFilterDef, $type, $typeContext);
        $newValue = $this->comparsionService->executeComparsion($comparison, $a, $b);
        if($concatenation != null) $newValue = $this->comparsionService->executeComparsion($concatenation, $typeStateDict[$type->getTypeID()], $newValue);
        $typeStateDict[$type->getTypeID()] = $newValue;
      }
    }

    $typeArray = array();
    foreach ($typeStateDict as $typeId => $isIncluded)
      if($isIncluded) $typeArray[] = $typeId;

    return $typeArray;
  }

  private function getItemFilterRuleValue($filterRule, $itemFilterDef) {
    $itemFilterTypeName = $itemFilterDef->getType()->getName();

    if($itemFilterTypeName == 'select') {
      $deepth = $itemFilterDef->getDepth();
      $values = array();
      if($deepth >= 1) $values[] = $filterRule->getContent1();
      if($deepth >= 2) $values[] = $filterRule->getContent2();
      return $values;
    }

    return $this->getSimpleItemFilterRuleValue($itemFilterTypeName, $filterRule);
  }


  private function getSimpleItemFilterRuleValue($itemFilterTypeName, $filterRule) {
    return $itemFilterTypeName == 'float'
      ? floatval($filterRule->getValue())
      : $itemFilterTypeName == 'int'
        ? intval($filterRule->getValue())
        : $filterRule->getValue();
  }


  public function get($id)  {
    $entity = $this->getEntity($id);
    if($entity == null) return $this->getNotFound();
    
    $data = $this->getLocalyMappendModel($entity);
    $data['rules'] = $this->mapFittingRuleRowsToModel($entity);
    return $data;
  }

  private function mapFittingRuleRowsToModel($entity)  {
    $dataRuleRows = array();
    foreach ($entity->getFittingRuleRows() as $fittingRuleRow)  {
      $dataRuleRow = $this->mapFittingRuleRowToModel($fittingRuleRow);
      $dataRuleRow['itemFilterRules'] = $this->mapItemFilterRulesToModel($fittingRuleRow);
      $dataRuleRows[] = $dataRuleRow;
    }
    return $dataRuleRows;
  }

  private function mapFittingRuleRowToModel($fittingRuleRow)  {
    return array('id' => $fittingRuleRow->getId(),
                'concatenation' => $this->createIdObj($fittingRuleRow->getConcatenation()),
                'value' => intval($fittingRuleRow->getValue()),
                'comparison' => $this->createIdObj($fittingRuleRow->getComparison()));
  }

  private function mapItemFilterRulesToModel($fittingRuleRow)  {
    $dataFilterRules = array();
    foreach ($fittingRuleRow->getItemFilterRules() as $filterRule)  {
      $value = $this->getSimpleItemFilterRuleValue($filterRule->getItemFilterDef()->getType()->getName(), $filterRule);

      $dataFilterRules[] = array('id' => $filterRule->getId(),
                              'concatenation' => $this->createIdObj($filterRule->getConcatenation()),
                              'group' => $this->createIdObj($filterRule->getItemFilterDefId()),
                              'comparison' => $this->createIdObj($filterRule->getComparison()),
                              'value' => $value,
                              'content' => array($this->createIdObj($filterRule->getContent1()), $this->createIdObj($filterRule->getContent2())));
    }
    return $dataFilterRules;
  }

  protected function performSave($data, $fork)  {
    $entity = $this->getLocalyMappedEntityToSave($data, $fork);

    $ruleRowIndex = 0;
    foreach ($data->rules as $dataRuleRow) {
      $fittingRuleRow = $this->getSubentity($entity, 'FittingRuleRow', $dataRuleRow);

      $fittingRuleRow->setInd3x($ruleRowIndex);
      if($ruleRowIndex == 0) $fittingRuleRow->setConcatenation(0);
      else if(property_exists($dataRuleRow, 'concatenation')) $fittingRuleRow->setConcatenation($dataRuleRow->concatenation->id);

      $fittingRuleRow->setComparison($dataRuleRow->comparison->id);
      $fittingRuleRow->setValue($dataRuleRow->value);

      $filterRuleIndex = 0;
      foreach ($dataRuleRow->itemFilterRules as $dataFilterRule) {
        $itemFilterRule = $this->getSubentity($fittingRuleRow, 'ItemFilterRule', $dataFilterRule);

        $itemFilterRule->setInd3x($filterRuleIndex);
        if($filterRuleIndex == 0) $itemFilterRule->setConcatenation(0);
        else if(property_exists($dataFilterRule, 'concatenation')) $itemFilterRule->setConcatenation($dataFilterRule->concatenation->id);

        $itemFilterRule->setItemFilterDefId($dataFilterRule->group->id);
        $itemFilterRule->setComparison($dataFilterRule->comparison->id);

        if(property_exists($dataFilterRule, 'value'))
          $itemFilterRule->setValue($dataFilterRule->value);

        if(property_exists($dataFilterRule, 'content')) {
          $dataFilterRuleContent = $dataFilterRule->content;
          if(count($dataFilterRuleContent) >= 1)
            $itemFilterRule->setContent1($dataFilterRuleContent[0]->id);
          if(count($dataFilterRuleContent) >= 2)
            $itemFilterRule->setContent2($dataFilterRuleContent[1]->id);
        }

        $this->prepareSubentitySave($fittingRuleRow, 'ItemFilterRule', $itemFilterRule, $dataFilterRule);
        $filterRuleIndex++;
      }

      $this->cleanupOldEnties($fittingRuleRow, 'ItemFilterRule', $dataRuleRow->itemFilterRules);
      $this->prepareSubentitySave($entity, 'FittingRuleRow', $fittingRuleRow, $dataRuleRow);
      $ruleRowIndex++;
    }

    $this->cleanupOldEnties($entity, 'FittingRuleRow', $data->rules);
    $entity->save();

    return $this->createIdObj($entity->getId());
  }

  protected function removeRelatedEntityIds($data) {
    foreach ($data->rules as $dataRuleRow) {
      unset($dataRuleRow->id);
      foreach ($dataRuleRow->itemFilterRules as $dataFilterRule) {
        unset($dataFilterRule->id);
      }
    }
  }
}

?>