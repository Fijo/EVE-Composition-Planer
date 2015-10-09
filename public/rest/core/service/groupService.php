<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;
use ECP;

class GroupService extends EntityService
{
  protected $groupPersonTypeService;

  public function __construct()
  {
    parent::__construct();
    $this->groupPersonTypeService = new \Core\Service\GroupPersonTypeService();
    $this->accessCheckService = new GroupAccessCheckService($this->getEntityName());

    $this->hasUserField = false;
    $this->hasIsListedField = false;
    $this->hasGroupAccessInModel = false;
  }

  public function getEntityName() {
    return 'Group';
  }
  
  protected function createQuery() {
    return ECP\GroupQuery::create();
  }

  protected function getEntity($id, $writePermissions = false) {
    $query = $this->addPermissionCheckForSingle($id, $this->createQuery(), $writePermissions)
      ->joinWith('Group.GroupPerson')
      ->joinWith('GroupPerson.User')
      ->filterById($id)
      ->find();

    $query->populateRelation('GroupEvePerson');

    return $this->getSingleEntity($query);
  }

  protected function extendAutocompleteModel(&$model, $entity) {}

  public function get($id)  {
    $entity = $this->getEntity($id);
    if($entity == null) return $this->getNotFound();
    return $this->getMappedModel($entity);
  }

  private function getMappedModel($entity) {    
    $data = $this->getLocalyMappendModel($entity);
    $data['lastComputed'] = $entity->getLastComputed()->diff(new \DateTime('today'))->format('%R%a days');
    $data['canEdit'] = $this->isCurrentUserStillAdminInGroup($entity);

    $groupPersonTypesDict = $this->groupPersonTypeService->get();
    foreach ($groupPersonTypesDict as $groupPersonTypeId => $groupPersonType) {
      $data[ $groupPersonType['name'] ] = $this->mapSectionToModel($entity, $groupPersonTypeId);
    }

    return $data;
  }

  private function mapSectionToModel($entity, $groupPersonTypeId) {
    $persons = array();
    $generatedPersonDict = array();
    foreach ($entity->getGrouppeople() as $groupPersonEntity) {
      if($groupPersonEntity->getGroupPersonTypeId() != $groupPersonTypeId) continue;
      $personModel = $this->mapPersonToModel($groupPersonEntity);

      $groupEvePersonId = $groupPersonEntity->getGroupEvePersonId();
      if(!(is_null($groupEvePersonId) || $groupEvePersonId == 0))  {
        if(!array_key_exists($groupEvePersonId, $generatedPersonDict)) $generatedPersonDict[$groupEvePersonId] = array($personModel);
        else $generatedPersonDict[$groupEvePersonId][] = $personModel;
      }
      else $persons[] = $personModel;
    }

    $evePersons = array();
    foreach ($entity->getGroupEvepeople() as $groupEvePerson) {
      if($groupEvePerson->getGroupPersonTypeId() != $groupPersonTypeId) continue;
      
      $groupEvePersonId = $groupPersonEntity->getId();
      $evePersons[] = array('id' => $groupEvePersonId,
                            'name' => $groupEvePerson->getName(),
                            'generatedPersons' => array_key_exists($groupEvePersonId, $generatedPersonDict) ? $generatedPersonDict[$groupEvePersonId] : array());
    }

    return array('persons' => $persons, 'evePersons' => $evePersons);
  }

  private function mapPersonToModel($groupPersonEntity)  {
    return array('id' => $groupPersonEntity->getId(),
                'user' => $this->getAutocompleteModel($groupPersonEntity->getUser()));
  }

  protected function getEntitySubEntities($entity) {
      die('not implemented');
  }

  protected function performSave($data, $fork)  {
    $entity = $this->getLocalyMappedEntityToSave($data, $fork);

    $connection = $this->getPropelConnection();

    try {
      $connection->beginTransaction();
      $entity->setLastComputed(0);

      $personDict = array();
      foreach ($entity->getGrouppeople() as $groupPerson)
        $personDict[$groupPerson->getId()] = $groupPerson;

      $evePersonDict = array();
      foreach ($entity->getGroupEvepeople() as $groupEvePerson)
        $evePersonDict[$groupEvePerson->getId()] = $groupEvePerson;


      $groupPersonTypesDict = $this->groupPersonTypeService->get();

      $allDataPersons = array();
      $allDataEvePersons = array();
      foreach ($groupPersonTypesDict as $groupPersonType) {
        $dataByType = $data->{ $groupPersonType['name'] };
        $allDataPersons = array_concat($allDataPersons, $dataByType->persons);
        $allDataEvePersons = array_concat($allDataEvePersons, $dataByType->evePersons);
      }

      $this->cleanupOldEnties($entity, 'GroupPerson', $allDataPersons);
      $this->cleanupOldEnties($entity, 'GroupEvePerson', $allDataEvePersons);

      foreach ($groupPersonTypesDict as $groupPersonTypeId => $groupPersonType) {
        $dataByType = $data->{ $groupPersonType['name'] };
        foreach ($dataByType->persons as $dataPerson) {
          $personExists = property_exists($dataPerson, 'id');
          $personEntity = $personExists ? $personDict[$dataPerson->id] : new ECP\GroupPerson();
          $personEntity->setGroupPersonTypeId($groupPersonTypeId);
          $personEntity->setUserId($dataPerson->user->id);
          $this->prepareSubentitySave2($connection, $entity, 'GroupPerson', $personEntity, !$personExists);
          $allDataPersons[] = $dataPerson;
        }

        foreach ($dataByType->evePersons as $dataEvePerson) {
          $evePersonExists = property_exists($dataEvePerson, 'id');
          $evePersonEntity = $evePersonExists ? $evePersonDict[$dataEvePerson->id] : new ECP\GroupEvePerson();
          $evePersonEntity->setGroupPersonTypeId($groupPersonTypeId);
          $evePersonEntity->setName($dataEvePerson->name);
          $this->prepareSubentitySave2($connection, $entity, 'GroupEvePerson', $evePersonEntity, !$evePersonExists);
          $allDataEvePersons[] = $dataEvePerson;
        }
      }

      if(!$this->isCurrentUserStillAdminInGroup($entity)) throw new ValidationException('You cannot remove yourself from the admin list of a group. Please make sure you are always on the admin list before you try to save a group.');


      $entity->save($connection);

      $this->saveGroupAccess($connection, $entity, null);

      $connection->commit();

      return $this->createIdObj($entity->getId());
    } catch (Exception $e) {
      $connection->rollBack();
      throw $e;
    }
  }

  protected function isCurrentUserStillAdminInGroup($entity) {
    $adminId = $this->groupPersonTypeService->getIdByName('admin');
    $userId = $this->userService->getLoggedInUser()->id;
    foreach ($entity->getGrouppeople() as $groupPerson) if($groupPerson->getGroupPersonTypeId() == $adminId && $groupPerson->getUserId() == $userId) return true;

    // todo add eve user checks
    return false;
  }

  protected function removeRelatedEntityIds($data) {
    die('not implemented');
  }
}

?>