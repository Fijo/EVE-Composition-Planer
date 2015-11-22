<?php
//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

namespace Core\Service;
use ECP;
use Pheal\Pheal;
use Pheal\Exceptions\PhealException;

class AccountSettingsService extends EntityService
{
  public function __construct()
  {
    parent::__construct();
    $this->accessCheckService = new UserAccessCheckService();

    $this->hasUserField = true;
    $this->hasIsListedField = false;
    $this->hasGroupAccessInModel = false;
    $this->hasNameField = false;
    $this->groupCheck = false;
    $this->isSingleEntity = true;
  }

  public function getEntityName() {
    return 'User';
  }
  
  protected function createQuery() {
    return ECP\UserQuery::create();
  }

  protected function getSingleEntityId()  {
    $user = $this->userService->getLoggedInUser();
    return $user->id;
  }

  protected function getEntity($id, $writePermissions = false) {
    $query = $this->addPermissionCheckForSingle($id, $this->createQuery(), $writePermissions)
      ->filterById($id)
      ->find();

    $query->populateRelation('EveApi');

    return $this->getSingleEntity($query);
  }

  protected function extendAutocompleteModel(&$model, $entity) {}

  public function get($id)  {
    $entity = $this->getEntity($this->getSingleEntityId());
    if($entity == null) return $this->getNotFound();
    return $this->getMappedModel($entity);
  }
  
  private function getUsedEveCharacters($apiIds) {
    $chars = ECP\EveCharacterQuery::create()
      ->filterByEveApiId($apiIds)
      ->find();

    $charDict = array();
    foreach($chars as $char) {
      $key = $char->getEveApiId();
      if(!array_key_exists($key, $charDict)) $charDict[$key] = array($char);
      else $charDict[$key][] = $char;
    }
    return $charDict;
  }

  private function getUsedApiIds($entity)  {
    return $this->getArrayOfIds($entity->getEveApis());
  }

  private function getMappedModel($entity) {
    $data = $this->getLocalyMappendModel($entity);
    $usedEveCharacters = $this->getUsedEveCharacters($this->getUsedApiIds($entity));

    $data['apiKeys'] = $this->mapApiKeysToModel($entity, $usedEveCharacters);
    return $data;
  }

  private function mapApiKeysToModel($entity, $usedEveCharacters)  {
    $dataRows = array();
    foreach ($entity->getEveApis() as $apiKey)
      $dataRows[] = array('id' => $apiKey->getId(),
                          'keyId' => $apiKey->getKeyId(),
                          'vCode' => $apiKey->getVCode(),
                          'status' => $apiKey->getStatus(),
                          'lastComputed' => $this->getLastComputed($apiKey),
                          'characters' => $this->mapCharactersToModel($this->getArrayById($usedEveCharacters, $apiKey)));
    return $dataRows;
  }

  private function mapCharactersToModel($eveCharacters)  {
    $dataRows = array();
    foreach ($eveCharacters as $character)
      $dataRows[] = array('char' => array('id' => $character->getCharId(), 'name' => $character->getCharName()),
                          'corp' => array('id' => $character->getCorpId(), 'name' => $character->getCorpName()),
                          'ally' => array('id' => $character->getAllyId(), 'name' => $character->getAllyName()));
    return $dataRows;
  }

  public function processApiKeys() {
    while(true) {
      $eveApis = ECP\EveApiQuery::create()
                  ->filterByStatus('not processed yet')
                  ->_or()
                  ->condition('c1', 'EveApi.lastComputed < ?', time() - 24 * 60 * 60)
                  ->condition('c2', 'EveApi.status = ?', 'success')
                  ->where(array('c1', 'c2'), 'and')
                  ->find();

      $eveApis->populateRelation('EveCharacter');
      foreach ($eveApis as $eveApi) {
        $characters = array();
        $eveApi->setStatus('');
        try {
          $characters = $this->getCharacters($eveApi);
          $eveApi->setStatus('success');
        } catch (\Pheal\Exceptions\PhealException $e) {
          $eveApi->setStatus('An exception occured. '.get_real_class($e).': '.$e->getMessage());
        }
        $eveApi->setLastComputed(time());

        $connection = $this->getPropelConnection();
        try {
          $connection->beginTransaction();

          foreach ($characters as $character) {
            $eveCharacter = $this->getSubentity2($eveApi, 'EveCharacter', $character, 'characterID', 'CharId');

            $eveCharacter->setCharName($character->name);
            $eveCharacter->setCharId($character->characterID);
            $eveCharacter->setCorpName($this->tryGetProperty($character, 'corporationName'));
            $eveCharacter->setCorpId($this->tryGetProperty($character, 'corporationID'));
            $eveCharacter->setAllyName($this->tryGetProperty($character, 'allianceName'));
            $eveCharacter->setAllyId($this->tryGetProperty($character, 'allianceID'));

            $this->prepareSubentitySave3($connection, $eveApi, 'EveCharacter', $eveCharacter);
          }

          $this->cleanupOldEnties($eveApi, 'EveCharacter', $characters, 'characterID', 'CharId');

          $eveApi->save($connection);

          $connection->commit();
        } catch (Exception $e) {
          $connection->rollBack();
          throw $e;
        }
      }

      sleep(30);
    }
  }

  private function tryGetProperty($obj, $propertyName)  {
    return isset($obj->{$propertyName}) ? $obj->{$propertyName} : '';
  }

  private function getCharacters($eveApi)  {
    $pheal = new \Pheal\Pheal($eveApi->getKeyId(), $eveApi->getVCode());
    $characters = $pheal->Characters();
    return $characters->_value->characters;
  }


  protected function getEntitySubEntities($entity) {
      die('not implemented');
  }

  protected function performSave($data, $fork)  {
    $entity = $this->getLocalyMappedEntityToSave($data, $fork);

    $connection = $this->getPropelConnection();

    try {
      $connection->beginTransaction();

      foreach ($data->apiKeys as $dataApiKey) {
        $apiKey = $this->getSubentity($entity, 'EveApi', $dataApiKey);

        $apiKey->setKeyId($dataApiKey->keyId);
        $apiKey->setVCode($dataApiKey->vCode);
        $apiKey->setStatus('not processed yet');
        $apiKey->setLastComputed(0);

        $this->prepareSubentitySave($connection, $entity, 'EveApi', $apiKey, $dataApiKey);
      }

      $this->cleanupOldEnties($entity, 'EveApi', $data->apiKeys);

      $entity->save($connection);

      $connection->commit();

      return $this->createIdObj($entity->getId());
    } catch (Exception $e) {
      $connection->rollBack();
      throw $e;
    }
  }

  protected function removeRelatedEntityIds($data) {
    die('not implemented');
  }
}

?>