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

abstract class EntityService {
  protected $userService;
  protected $maxPerPage = 10;

  public function __construct()
  {
      $this->userService = new \Core\Service\UserService();
  }

  abstract protected function getEnityName();
  abstract protected function createQuery();
  abstract protected function getEntity($id);
  abstract protected function performSave($data, $fork);
  abstract protected function removeRelatedEntityIds($data);

  protected function getNewEntity() {
    return $this->getNewEntityByName($this->getEnityName());
  }

  protected function getEntityOnly($id) {
    return $this->createQuery()
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

      case 'my':
        $user = $this->userService->getLoggedInUser();
        $query = $query->filterByUserId($user->id);
        break;
      
      default:
        // ints for other user ids in the future maybe
        die('type not supported yet!');
        break;
    }

    $entries = $query->orderByLastModified()
      ->paginate($page, $this->maxPerPage);

    $entries->populateRelation('User');
    return $entries;
  }

  protected function getEntityAutocompleteList($needle) {
    $parts = explode('/', $needle);
    
    $username = count($parts) > 1 ? $parts[0] : '';
    $name = count($parts) > 1 ? $parts[1] : $parts[0];

    $user = $this->userService->getLoggedInUser();

    $query = $this->createQuery()
      ->joinWith($this->getEnityName().'.User')
      ->filterByName($name.'%');

    if($username == '') $query = $query->filterByUserId($user->id);
    else $query = $query->where(' User.username = ?', $username);
    return $query->find();
  }

  protected function getLocalyMappendModel($entity)  {
    $user = $this->userService->getLoggedInUser();
    return $data = array('id' => $entity->getId(),
                  'name' => $entity->getName(),
                  'isYours' => $entity->getUserId() == $user->id,
                  'isListed' => $entity->getIsListed() == 1);
  }

  protected function getLocalyMappedEntityToSave($data, $fork)  {
    $user = $this->userService->getLoggedInUser();

    $entity = null;
    if($data->id != 'new')  {
      $entity = $this->getEntity($data->id);
      if($entity->getUserId() != $user->id)
        return $this->getAccessDenied();
    }
    else {
      $entity = $this->getNewEntity();
      $entity->setUserId($user->id);
    }
    if(strpos($data->name, '/') !== false) die_err('Slashes are not allowed in names!');

    $entity->setName($data->name);
    $entity->setIsListed($data->isListed);
    if($fork != false)
      $entity->setForkedId($fork);
    return $entity;
  }


  protected function getNewEntityByName($entityName)  {
      return (new \ReflectionClass('ECP\\'.$entityName))->newInstanceArgs();
  }

  protected function getSubentity($dbParent, $entityName, $dataCurrent)  {
      return property_exists($dataCurrent, 'id')
          ? $this->getEntryById($dbParent, $entityName, $dataCurrent->id)
          : $this->getNewEntityByName($entityName);
  }

  protected function prepareSubentitySave($dbParent, $relationName, $dbCurrent, $dataCurrent)  {
    $this->prepareSubentitySave2($dbParent, $relationName, $dbCurrent, !property_exists($dataCurrent, 'id'));
  }

  protected function prepareSubentitySave2($dbParent, $relationName, $dbCurrent, $isNew)  {
    if($isNew) call_user_func_array(array($dbParent, 'add'.$relationName), array($dbCurrent));
    else $dbCurrent->save();
  }

  protected function getDictById($rows) {
    $dict = array();
    foreach ($rows as $row)
      $dict[$row->getId()] = $row;
    return $dict;
  }

  protected function getSuccess() {
    return array('status' => 'success');
  }

  protected function getAccessDenied()  {
    return get_err('Access denied. This entity isn\'t owned by you. You can only save your own entities.');
  }

  protected function getNotFound()  {
    return get_err('The Entity you where looking for could not be found.');
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

  protected function getEntryById($dbParent, $relationName, $id) {
    $dbEntries = call_user_func_array(array($dbParent, 'get'.$relationName.'s'), array());
    foreach($dbEntries as $dbEntry)
      if($dbEntry->getId() == $id)
        return $dbEntry;
  }

  protected function cleanupOldEnties($dbParent, $relationName, $dataEnties) {
    $dataIds = array();
    foreach($dataEnties as $dataEntry)
      if(property_exists($dataEntry, 'id'))
        $dataIds[] = $dataEntry->id;

    $dbEntries = call_user_func_array(array($dbParent, 'get'.$relationName.'s'), array());
    foreach($dbEntries as $dbEntry)
      if(!is_null($dbEntry->getId()) && !in_array($dbEntry->getId(), $dataIds)) 
        call_user_func_array(array($dbParent, 'remove'.$relationName), array($dbEntry));
  }

  protected function cleanupDataForValidation($data) {
    unset($data['isYours']);
    unset($data['isListed']);
  }

  protected function mapListContent($list)  {
    $content = array();
    foreach ($list as $entity)  {
        $user = $entity->getUser();
        $lastModified = $entity->getLastModified();
        $content[] = array('id' => $entity->getId(),
                          'name' => $entity->getName(),
                          'lastModified' => $lastModified != null ? $lastModified->format(\DateTime::COOKIE) : null,
                          'user' => array('id' => $user->getId(),
                                          'name' => $user->getUsername()));
    }
    return $content;
  }

  protected function getUniqueName($entity)  {
    return $entity->getUser()->getUsername().'/'.$entity->getName();
  }

  protected function getAutocompleteModel($entity)  {
    return $this->createIdNameObj($entity->getId(), $this->getUniqueName($entity));
  }


  public function getAutocomplete($needle)  {
    $list = $this->getEntityAutocompleteList($needle);
    $content = array();
    foreach ($list as $entity)
      $content[] = $this->getAutocompleteModel($entity);
    return $content;
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
    $entity = $this->getEntityOnly($id);
    if($entity == null) return $this->getNotFound();

    $user = $this->userService->getLoggedInUser();
    if($entity->getUserId() != $user->id)
      return $this->getAccessDenied();
    $entity->delete();
    return $this->getSuccess();
  }
  
  public function fork($data)  {
    $forkId = $data->id;
    $data->id = 'new';
    $this->removeRelatedEntityIds($data);
    return $this->performSave($data, $forkId);
  }

  public function check($name, $id)  {
    $user = $this->userService->getLoggedInUser();
    $query = $this->createQuery()
      ->filterByUserId($user->id)
      ->filterByName($name);

    if($id != null) $query = $query->filterById($id, \Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL);
    $isAvailable = $query->count() == 0;

    return $this->getAvailability($isAvailable);
  }

}

?>