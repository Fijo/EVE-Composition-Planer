<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;
use ECP;

class FittingRuleService extends EntityService
{
  protected $comparsionService;
  protected $itemFilterDefService;
  protected $invTypeService;

  public function __construct()
  {
    parent::__construct();
    $this->comparsionService = new \Core\Service\ComparsionService();
    $this->itemFilterDefService = new \Core\Service\ItemFilterDefService();
    $this->invTypeService = new \Core\Service\InvTypeService();
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

  private function prefechSubentities($query) {
    return $this->prefechFittingRuleRowSubentities($query->joinWith('FittingRuleEntity.FittingRuleRow'));
  }

  private function prefechFittingRuleRowSubentities($query) {
    return $query->joinWith('FittingRuleRow.ItemFilterRule')
                ->joinWith('ItemFilterRule.ItemFilterDef')
                ->joinWith('ItemFilterDef.Type');
  }

  private function addOrder($query) {
    return $query->orderBy('FittingRuleRow.ind3x')
                ->orderBy('ItemFilterRule.ind3x');
  }

  public function getFittingRuleEntityContextForValidation($fittingRuleEntityIds) {
    $entities = ECP\FittingRuleEntityQuery::create()
                ->joinWith('FittingRuleEntity.FittingRuleRow')
                ->filterById($fittingRuleEntityIds)
                ->orderBy('FittingRuleRow.ind3x')
                ->find();

    $entities->populateRelation('User');
    return array('entities' => $entities, 'itemFilterTypeDict' => $this->getItemFilterTypeDict($entities));
  }

  private function getFittingRuleRowIds($entities)  {
    $fittingRuleRowIds = array();
    foreach ($entities as $entity)
      foreach ($entity->getFittingRuleRows() as $fittingRuleRow)
        $fittingRuleRowIds[] = $fittingRuleRow->getId();
    return $fittingRuleRowIds;
  }

  private function getItemFilterTypeDict($entities)  {
    $itemFilterTypes = ECP\ItemFilterTypeQuery::create()->filterByFittingRuleRowId($this->getFittingRuleRowIds($entities))->find();

    $itemFilterTypeDict = array();
    foreach ($itemFilterTypes as $itemFilterType) {
      $fittingRuleRowId = $itemFilterType->getFittingRuleRowId();
      if(array_key_exists($fittingRuleRowId, $itemFilterTypeDict)) $itemFilterTypeDict[$fittingRuleRowId][] = $itemFilterType;
      else $itemFilterTypeDict[$fittingRuleRowId] = array($itemFilterType);
    }
    return $itemFilterTypeDict;
  }

  public function getForValidation($entity, $fittingRuleEntityContext)  {
    $data = $this->getLocalyMappendModel($entity);

    $data['name'] = $this->getUniqueName($entity);
    $this->cleanupDataForValidation($data);
    $data['rules'] = $this->mapFittingRuleRowsToModelForValidation($entity, $fittingRuleEntityContext);
    return $data;
  }

  private function mapFittingRuleRowsToModelForValidation($entity, $fittingRuleEntityContext)  {
    $dataRuleRows = array();
    foreach ($entity->getFittingRuleRows() as $fittingRuleRow)  {
      $dataRuleRow = $this->mapFittingRuleRowToModel($fittingRuleRow);
      $dataRuleRow['itemFilterRules'] = $this->mapItemFilterRulesToModelForValidation($fittingRuleRow, $fittingRuleEntityContext);
      $dataRuleRows[] = $dataRuleRow;
    }
    return $dataRuleRows;
  }

  private function mapItemFilterRulesToModelForValidation($fittingRuleRow, $fittingRuleEntityContext)  {
    $typeArray = array();
    foreach ($this->getArrayById($fittingRuleEntityContext['itemFilterTypeDict'], $fittingRuleRow) as $itemFilterType)
      $typeArray[] = $itemFilterType->getItemId();

    return $typeArray;
  }

  private function getFittingRuleEntityContextForItemFilterTypeCalculations() {
    $entities = $this->prefechFittingRuleRowSubentities(ECP\FittingRuleEntityQuery::create()
                ->joinWith('FittingRuleEntity.FittingRuleRow'))
                ->filterByIsFilterTypeUptodate(0)
                ->orderBy('ItemFilterRule.ind3x')
                ->find();
                return array('entities' => $entities, 'fittingRuleRowsWithTypes' => $this->getFittingRuleRowsWithTypes($entities));
    return $this->getWrappedEntityContextForValidation($entities);
  }

  private function getFittingRuleRowsWithTypes($entities)  {
    $fittingRuleRows = ECP\FittingRuleRowQuery::create()->filterById($this->getFittingRuleRowIds($entities))->find();
    $fittingRuleRows->populateRelation('ItemFilterType');
    return $this->getDictById($fittingRuleRows);
  }

  public function calculateNewItemFilterTypes()  {
    $comparisonDict = $this->getDictById(ECP\ComparisonQuery::create()->find());
    $typeContext = $this->invTypeService->getTypeContext();

    while(true) {
      $entityContext = $this->getFittingRuleEntityContextForItemFilterTypeCalculations();
      $fittingRuleRowsWithTypeDict = $entityContext['fittingRuleRowsWithTypes'];

      $connection = $this->getPropelConnection();

      foreach($entityContext['entities'] as $entity)
        try {
          $connection->beginTransaction();

          foreach ($entity->getFittingRuleRows() as $fittingRuleRow) {
            $typeArray = $this->calculateItemFilterTypesFrom($comparisonDict, $typeContext, $fittingRuleRow);

            $fittingRuleRowId = $fittingRuleRow->getId();
            if(!array_key_exists($fittingRuleRowId, $fittingRuleRowsWithTypeDict))  {
              echo '... so this row has already been deleted between those two fetches ... interesting ... skiping it ...\n';
              continue;
            }

            $this->updateItemFilterTypes($connection, $typeArray, $fittingRuleRowsWithTypeDict[$fittingRuleRowId]);
          }

          $this->setFittingRuleEntityUpToDate($connection, $entity);
          $connection->commit();
        } catch (Exception $e) {
          $connection->rollBack();
          throw $e;
        }
      
      sleep(30);
    }
  }

  private function setFittingRuleEntityUpToDate($connection, $entity) {
    $currentEntity = ECP\FittingRuleEntityQuery::create()->filterById($entity->getId())->findOne();
    if($currentEntity->getLastModified() == $entity->getLastModified()) {
      $currentEntity->setIsFilterTypeUptodate(1);
      $currentEntity->save($connection);
    }
  }

  private function updateItemFilterTypes($connection, $typeArray, $fittingRuleRow) {
    $itemFilterTypeDict = array();
    foreach ($fittingRuleRow->getItemFilterTypes() as $itemFilterType)
      $itemFilterTypeDict[$itemFilterType->getItemId()] = $itemFilterType;

    foreach ($typeArray as $dataTypeId) {
      $itemFilterTypeExists = array_key_exists($dataTypeId, $itemFilterTypeDict);
      $itemFilterType = null;
      if($itemFilterTypeExists) $itemFilterType = $itemFilterTypeDict[$dataTypeId];
      else {
        $itemFilterType = new ECP\ItemFilterType();
        $itemFilterType->setItemId($dataTypeId);
      }

      $this->prepareSubentitySave2($connection, $fittingRuleRow, 'ItemFilterType', $itemFilterType, !$itemFilterTypeExists);
    }

    foreach ($itemFilterTypeDict as $itemId => $itemFilterType)
      if(!in_array($itemId, $typeArray)) $fittingRuleRow->removeItemFilterType($itemFilterType);

    $fittingRuleRow->save($connection);
  }

  private function calculateItemFilterTypesFrom($comparisonDict, $typeContext, $fittingRuleRow)  {
    $types = $typeContext->types;
    $typeStateDict = array();
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

    $connection = $this->getPropelConnection();
    try {
      $connection->beginTransaction();

      $entity->setIsFilterTypeUptodate(0);

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

          $this->prepareSubentitySave($connection, $fittingRuleRow, 'ItemFilterRule', $itemFilterRule, $dataFilterRule);
          $filterRuleIndex++;
        }

        $this->cleanupOldEnties($fittingRuleRow, 'ItemFilterRule', $dataRuleRow->itemFilterRules);
        $this->prepareSubentitySave($connection, $entity, 'FittingRuleRow', $fittingRuleRow, $dataRuleRow);
        $ruleRowIndex++;
      }

      $this->cleanupOldEnties($entity, 'FittingRuleRow', $data->rules);
      $entity->save($connection);

      $connection->commit();

      return $this->createIdObj($entity->getId());
    } catch (Exception $e) {
      $connection->rollBack();
      throw $e;
    }
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