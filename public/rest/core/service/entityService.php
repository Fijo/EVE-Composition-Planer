<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;
use ECP;
use Propel\Runtime;
use Propel\Runtime\ActiveQuery;

abstract class ECPException extends \Exception
{
    protected $data;

    public function __construct($message, $data = null, $code = 0)
    {
        $this->data = $data;
        parent::__construct($message, $code);
    }

    public function toObj()  {
      $obj = array('status' => 'error',
                  'errorType' => get_real_class($this),
                  'message' => $this->message);
      if($this->data != null) $obj['data'] = $this->data;
      return $obj;
    }
}

class AccessViolationException extends ECPException {
  public function __construct($type, $data) {
    parent::__construct($type, $data, 0);
  }
}

class ValidationException extends ECPException {
  public function __construct($message)
  {
      parent::__construct($message, null, 0);
  }
}

abstract class EntityService {
  protected $userService;
  protected $accessCheckService;
  protected $maxPerPage = 10;
  public $hasUserField = true;
  public $hasNameField = true;
  public $hasIsListedField = true;
  protected $hasGroupAccessInModel = true;
  protected $relatedEntityServices = array();
  protected $groupCheck = true;
  protected $isSingleEntity = false;

  public function __construct()
  {
      $this->userService = new \Core\Service\UserService();
      $this->accessCheckService = new AccessCheckService($this->getEntityName());
  }

  protected function isUserEntity() {
    return $this->getEntityName() == 'User';
  }

  protected function addRelatedEntityService($service)  {
    $this->relatedEntityServices[$service->getEntityName()] = $service;
  }

  abstract public function getEntityName();
  abstract protected function createQuery();
  abstract protected function getSingleEntityId();
  abstract protected function getEntity($id, $writePermissions = false);
  abstract protected function performSave($data, $fork);
  abstract protected function removeRelatedEntityIds($data);
  abstract protected function extendAutocompleteModel(&$model, $entity);
  // actual entities that have their own service
  abstract protected function getEntitySubEntities($entity);

  protected function getNewEntity() {
    return $this->getNewEntityByName($this->getEntityName());
  }

  public function getAccessableEntityIds()  {
    return $this->accessCheckService->getAccessableIds();
  }

  public function getGroupAccesss($entityIds) {
    return $this->accessCheckService->getGroupAccesss($entityIds);
  }

  protected function addPermissionCheckForSingle($id, $query, $writePermissions = false) {
    if($this->accessCheckService->hasAccess($id, $writePermissions)) return $query;
    $this->addConditionFilter($query, $this->getPermissionCheckConditions($query));
    return $query;
  }

  protected function addPermissionCheck($query, $writePermissions = false) {
    $conditions = $this->getPermissionCheckConditions($query);
    if($this->groupCheck) {
      $accessableIds = $this->accessCheckService->getAccessableIds($writePermissions);
      $query = $query->condition('c_accessable', $this->getEntityName().'.id IN ?', $accessableIds);
      $conditions[] = 'c_accessable';
    }

    $this->addConditionFilter($query, $conditions);
    return $query;
  }

  protected function getUserIdField()  {
    return $this->getEntityName().'.'.($this->isUserEntity() ? 'id' : 'userId');
  }

  protected function getUserId($entity)  {
    return $this->isUserEntity() ? $entity->getId() : $entity->getUserId();
  }

  protected function filterByUserId($query, $id) {
    return $this->isUserEntity() ? $query->filterById($id) : $query->filterByUserId($id);
  }

  private function getPermissionCheckConditions($query) {
    $user = $this->userService->tryGetLoggedInUser();

    $conditions = array();
    if($this->hasUserField && $user != null)  {
      $query = $query->condition('c_user', $this->getUserIdField().' = ?', $user->id);
      $conditions[] = 'c_user';
    }

    if($this->hasIsListedField) {
      $query = $query->condition('c_public', $this->getEntityName().'.isListed = ?', 1);
      $conditions[] = 'c_public';
    }
    return $conditions;
  }

  private function addConditionFilter($query, $conditions)  {
    if(count($conditions) != 0) $query = $query->where($conditions, 'or');
  }

  protected function getEntityOnly($id, $writePermissions = false) {
    return $this->addPermissionCheckForSingle($id, $this->createQuery(), $writePermissions)
      ->findPk($id);
  }

  protected function getSingleEntity($entities) {
    if(count($entities) == 0)
      return null;
    return $entities[0];
  }

  protected function getEntityListPager($type, $page) {
    $query = $this->createQuery();

    switch ($type) {
      case 'public':
        $query = $query->filterByIsListed(1);
        break;

      case 'friends':
        $ids = $this->accessCheckService->getAccessableIds();
        $query = $query->filterById($ids);
        break;

      case 'my':
        if(!$this->hasUserField) die('type doesn´t have a user field');
        $user = $this->userService->getLoggedInUser();
        $query = $this->filterByUserId($query, $user->id);
        break;
      
      default:
        // ints for other user ids in the future maybe
        die('type not supported yet!');
        break;
    }

    $entries = $query->orderByLastModified()
      ->paginate($page, $this->maxPerPage);

    if($this->hasUserField) $entries->populateRelation('User');
    return $entries;
  }

  protected function getEntityAutocompleteList($needle) {
    $parts = explode('/', $needle);
    
    $username = count($parts) > 1 ? $parts[0] : '';
    $name = count($parts) > 1 ? $parts[1] : $parts[0];

    $query = $this->addPermissionCheck($this->createQuery());
    if($this->hasUserField && !$this->isUserEntity()) $query = $query->joinWith($this->getEntityName().'.User');

    $query = $query->filterByName($name.'%');

    if($this->hasUserField)  {
      if($username == '') {
        $user = $this->userService->getLoggedInUser();
        $query = $this->filterByUserId($query, $user->id);
      }
      else $query = $query->where(' User.name = ?', $username);
    }
    return $query->find();
  }

  protected function getLocalyMappendModel($entity)  {
    $data = array();

    if(!$this->isSingleEntity) $data['id'] = $entity->getId();
    if($this->hasNameField) $data['name'] = $entity->getName();
    if($this->hasIsListedField) $data['isListed'] = $entity->getIsListed() == 1;
    if($this->hasUserField)  {
      $user = $this->userService->tryGetLoggedInUser();
      $data['isYours'] = $user != null && $this->getUserId($entity) == $user->id;
    }

    if($this->hasGroupAccessInModel) $this->mapGroupAccessToModel($data, $entity);

    return $data;
  }

  protected function getLocalyMappedEntityToSave($data, $fork)  {
    $user = $this->userService->getLoggedInUser();

    if($this->isSingleEntity) $data->id = $this->getSingleEntityId();

    $entity = null;
    if($data->id != 'new')  {
      $entity = $this->getEntity($data->id, true);
      if($this->hasUserField && $this->getUserId($entity) != $user->id)
        $this->dieAccessDenied();
    }
    else {
      $entity = $this->getNewEntity();
      if($this->hasUserField) {
        if($this->isUserEntity()) throw new Exception('not supported for the user entity');
        $entity->setUserId($user->id);
      }
    }

    if($this->hasNameField) {
      if(strpos($data->name, '/') !== false) die_err('Slashes are not allowed in names!');
      $entity->setName($data->name);
    }

    if($this->hasIsListedField) $entity->setIsListed($data->isListed);

    if($fork != false)
      $entity->setForkedId($fork);
    return $entity;
  }

  protected function mapGroupAccessToModel(&$data, $entity) {
    $groups = array();
    $groupEntities = $this->accessCheckService->getGroupAccess($entity);
    foreach ($groupEntities as $groupEntity) $groups[] = array('p' => $this->createIdNameObj($groupEntity->getId(), $groupEntity->getName()));
    $data['groups'] = $groups;
  }

  protected function saveGroupAccess($connection, $entity, $data)  {
    if($data != null) {
      $groupIds = array();
      foreach ($data->groups as $group) $groupIds[] = $group->p->id;
      $this->checkSubEntityPermissions($entity, $groupIds);
    }
    else $groupIds = null;
    $this->accessCheckService->saveGroupAccess($connection, $entity, $groupIds);
  }

  protected function checkSubEntityPermissions($entity, $groupIds) {
    $subEntitiesByType = $this->getEntitySubEntities($entity);

    $this->verifyGroupsAreAccessable($groupIds);
    $user = $this->userService->tryGetLoggedInUser();

    foreach ($subEntitiesByType as $subEntityType => $typeSubEntities) {
      $relatedEntityService = $this->relatedEntityServices[$subEntityType];
      $accessableEntityIds = $relatedEntityService->getAccessableEntityIds();
      $groupAccessDict = $relatedEntityService->getGroupAccesss($this->getArrayOfIds($typeSubEntities));

      $notAccessableSubEntities = array();
      $notListedSubEntities = array();
      $subEntitiesNeedsRequiredGroup = array();
      foreach ($typeSubEntities as $subEntity) {
        $isSubEntityPublic = $relatedEntityService->hasIsListedField && $subEntity->getIsListed();

        if(!(in_array($subEntity->getId(), $accessableEntityIds) || $isSubEntityPublic || ($user != null && $relatedEntityService->hasUserField && $subEntity->getUserId() == $user->id))) $notAccessableSubEntities[] = $subEntity;

        if(!(!$this->hasIsListedField || !$entity->getIsListed() || $isSubEntityPublic)) $notListedSubEntities[] = $subEntity;
        if(!$this->areGroupsOkWithSubEntity($isSubEntityPublic, $this->getArrayById($groupAccessDict, $subEntity), $groupIds)) $subEntitiesNeedsRequiredGroup[] = $subEntity;
      }

      $this->verifySubEntityPermission($notAccessableSubEntities, 'You have to be able to view all entities you are linking to in your entity.', $subEntityType);
      $this->verifySubEntityPermission($notListedSubEntities, 'Your entity may only be listed for the public if all entities you are linking to within it are listed for the public as well. Make sure your linked entities are listed for the public.', $subEntityType);
      $this->verifySubEntityPermission($subEntitiesNeedsRequiredGroup, 'Your entity may only be shared with a group if all entities your are linking to within it are shared with that particular group as well.', $subEntityType);
    }
  }

  private function verifySubEntityPermission($failingEntities, $errorType, $entityType) {
    if(count($failingEntities) == 0) return;
    throw new AccessViolationException($errorType, array($entityType => $this->relatedEntityServices[$entityType]->getAutocompleteModels($failingEntities)));
  }

  private function areGroupsOkWithSubEntity($isSubEntityPublic, $groupAccess, $groupIds) {
    $areGroupsOkWithSubEntity = true;
    if(!$isSubEntityPublic) {
      $subEntityGroupIds = $this->getArrayOfIds($groupAccess);
      foreach ($groupIds as $groupId) $areGroupsOkWithSubEntity = $areGroupsOkWithSubEntity && in_array($groupId, $subEntityGroupIds);
    }
    return $areGroupsOkWithSubEntity;
  }

  private function verifyGroupsAreAccessable($groupIds)  {
    $groupEntityService = $this->relatedEntityServices['Group'];
    $accessableGroupIds = $groupEntityService->getAccessableEntityIds();

    $notAccessable = array();
    foreach ($groupIds as $groupId) if(!in_array($groupId, $accessableGroupIds)) $notAccessable[] = $groupId;    
    if(count($notAccessable) == 0) return;

    $groups = $groupEntityService->getAutocompleteModels(ECP\GroupQuery::create()->filterById($notAccessable)->find());
    throw new AccessViolationException('You have to be at least a member of all the groups you are sharing this entity with. This is to prevent random spam.', array('Group' => $groups));
  }

  protected function getArrayOfIds($entities) {
    $ids = array();
    foreach ($entities as $entity) $ids[] = $entity->getId();
    return $ids;
  }


  protected function getPropelConnection()  {
    // I only need this for save and deletes and I only make those on the default database
    return \Propel\Runtime\Propel::getServiceContainer()->getReadConnection('default');
  }

  protected function getNewEntityByName($entityName)  {
      return (new \ReflectionClass('ECP\\'.$entityName))->newInstanceArgs();
  }

  protected function getSubentity($dbParent, $entityName, $dataCurrent, $dataProperty = 'id', $entityField = 'Id')  {
      return property_exists($dataCurrent, $dataProperty)
          ? $this->getEntryBy($dbParent, $entityName, $dataCurrent->{$dataProperty}, $dataProperty, $entityField)
          : $this->getNewEntityByName($entityName);
  }

  protected function getSubentity2($dbParent, $entityName, $dataCurrent, $dataProperty = 'id', $entityField = 'Id')  {
      $subEntity = $this->getEntryBy($dbParent, $entityName, $dataCurrent->{$dataProperty}, $dataProperty, $entityField);
      if($subEntity == null) $subEntity = $this->getNewEntityByName($entityName);
      return $subEntity;
  }

  protected function prepareSubentitySave($connection, $dbParent, $relationName, $dbCurrent, $dataCurrent)  {
    $this->prepareSubentitySave2($connection, $dbParent, $relationName, $dbCurrent, !property_exists($dataCurrent, 'id'));
  }

  protected function prepareSubentitySave2($connection, $dbParent, $relationName, $dbCurrent, $isNew)  {
    if($isNew) call_user_func_array(array($dbParent, 'add'.$relationName), array($dbCurrent));
    else $dbCurrent->save($connection);
  }

  protected function prepareSubentitySave3($connection, $dbParent, $relationName, $dbCurrent)  {
    $this->prepareSubentitySave2($connection, $dbParent, $relationName, $dbCurrent, $dbCurrent->isNew());
  }

  protected function getDictById($rows) {
    $dict = array();
    foreach ($rows as $row)
      $dict[$row->getId()] = $row;
    return $dict;
  }

  protected function getArrayById($dict, $entity)  {
    $id = $entity->getId();
    return array_key_exists($id, $dict) ? $dict[$id] : array();
  }

  protected function getLastComputed($entity)  {
    $lastComputed = $entity->getLastComputed();
    if($lastComputed == null) return null;
    return $lastComputed->diff(new \DateTime('now'))->format('%a days, %h hours, %i minutes ago');
  }

  protected function getSuccess() {
    return array('status' => 'success');
  }

  protected function getAccessDenied()  {
    return get_err('Access denied. You don´t have the required permissions to access this entity.');
  }

  protected function getNotFound()  {
    return get_err('The Entity you where looking for could either not be found or you don´t have the required permissions to view it.');
  }

  protected function dieAccessDenied()  {
    return die(json_encode($this->getAccessDenied()));
  }  

  protected function createIdObj($id) {
    return array('id' => $id);
  }

  protected function createIdNameObj($id, $name) {
    return array('id' => $id, 'name' => $name);
  }

  protected function getAvailability($isAvailable) {
    return array('isAvailible' => $isAvailable);
  }

  protected function getSubentities($dbParent, $relationName) {
    return call_user_func_array(array($dbParent, 'get'.$this->getPropalPlural($relationName)), array());
  }

  protected function getPropalPlural($relationName) {
    return str_replace('Persons', 'people', $relationName.'s');
  }

  protected function getEntryBy($dbParent, $relationName, $key, $dataProperty = 'id', $entityField = 'Id') {
    $dbEntries = $this->getSubentities($dbParent, $relationName);
    foreach($dbEntries as $dbEntry)
      if($this->getEntityField($dbEntry, $entityField) == $key)
        return $dbEntry;
  }

  protected function cleanupOldEnties($dbParent, $relationName, $dataEnties, $dataProperty = 'id', $entityField = 'Id') {
    $dataIds = array();
    foreach($dataEnties as $dataEntry)
      if(property_exists($dataEntry, $dataProperty) || isset($dataEntry->{$dataProperty}))
        $dataIds[] = $dataEntry->{$dataProperty};

    $dbEntries = $this->getSubentities($dbParent, $relationName);
    foreach($dbEntries as $dbEntry) {
      $key = $this->getEntityField($dbEntry, $entityField);
      if(!is_null($key) && !in_array($key, $dataIds))
        call_user_func_array(array($dbParent, 'remove'.$relationName), array($dbEntry));
    }
  }

  protected function getEntityField($entity, $entityField = 'Id') {
    return call_user_func_array(array($entity, 'get'.$entityField), array());
  }

  protected function cleanupDataForValidation(&$data) {
    if($this->hasUserField) unset($data['isYours']);
    if($this->hasIsListedField) unset($data['isListed']);
  }

  protected function mapListContent($list)  {
    $content = array();
    foreach ($list as $entity)  {
        $lastModified = $entity->getLastModified();
        $dataEntry = array('id' => $entity->getId(),
                          'name' => $entity->getName(),
                          'lastModified' => $lastModified != null ? $lastModified->format(\DateTime::COOKIE) : null);
        if($this->hasUserField)  {
          $user = $entity->getUser();
          $dataEntry['user'] = array('id' => $user->getId(), 'name' => $user->getName());
        }
        $content[] = $dataEntry;
    }
    return $content;
  }

  protected function getUniqueName($entity)  {
    $name = $entity->getName();
    if($this->hasUserField) return $entity->getUser()->getName().'/'.$name;
    return $name;
  }

  public function getAutocompleteModel($entity)  {
    $model = $this->createIdNameObj($entity->getId(), $this->getUniqueName($entity));
    $this->extendAutocompleteModel($model, $entity);
    return $model;
  }

  public function getAutocompleteModels($list)  {
    $content = array();
    foreach ($list as $entity)
      $content[] = $this->getAutocompleteModel($entity);
    return $content;
  }

  public function getAutocomplete($needle)  {
    return $this->getAutocompleteModels($this->getEntityAutocompleteList($needle));
  }

  public function getList($type, $page)  {
    $pager = $this->getEntityListPager($type, $page);
    $pageCount = ceil($pager->getNbResults() / $this->maxPerPage);

    return array('pageCount' => $pageCount,
                'content' => $this->mapListContent($pager));
  }

  public function save($data)  {
    return $this->performSave($data, false);
  }

  public function delete($id)  {
    $entity = $this->getEntityOnly($id, true);
    if($entity == null) return $this->getNotFound();

    $connection = $this->getPropelConnection();
    try {
      $connection->beginTransaction();

      $this->accessCheckService->deleteGroupAccess($connection, $entity);
      $entity->delete($connection);

      $connection->commit();
    }
    catch (Exception $e) {
      $connection->rollBack();
      throw $e;
    }
    return $this->getSuccess();
  }
  
  public function fork($data)  {
    $forkId = $data->id;
    $data->id = 'new';
    $this->removeRelatedEntityIds($data);
    return $this->performSave($data, $forkId);
  }

  public function check($name, $id)  {
    $query = $this->createQuery();
    if($this->hasUserField) {
      $user = $this->userService->getLoggedInUser();
      $query = $query->filterByUserId($user->id);
    }
    $query = $query->filterByName($name);

    if($id != null) $query = $query->filterById($id, \Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL);
    $isAvailable = $query->count() == 0;

    return $this->getAvailability($isAvailable);
  }

}

?>