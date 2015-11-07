<?php

namespace ECP\Map;

use ECP\EveCharacter;
use ECP\EveCharacterQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'evecharacter' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class EveCharacterTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ECP.Map.EveCharacterTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'evecharacter';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ECP\\EveCharacter';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ECP.EveCharacter';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = 'evecharacter.id';

    /**
     * the column name for the eveApiId field
     */
    const COL_EVEAPIID = 'evecharacter.eveApiId';

    /**
     * the column name for the charName field
     */
    const COL_CHARNAME = 'evecharacter.charName';

    /**
     * the column name for the charId field
     */
    const COL_CHARID = 'evecharacter.charId';

    /**
     * the column name for the corpName field
     */
    const COL_CORPNAME = 'evecharacter.corpName';

    /**
     * the column name for the corpId field
     */
    const COL_CORPID = 'evecharacter.corpId';

    /**
     * the column name for the allyName field
     */
    const COL_ALLYNAME = 'evecharacter.allyName';

    /**
     * the column name for the allyId field
     */
    const COL_ALLYID = 'evecharacter.allyId';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Eveapiid', 'Charname', 'Charid', 'Corpname', 'Corpid', 'Allyname', 'Allyid', ),
        self::TYPE_CAMELNAME     => array('id', 'eveapiid', 'charname', 'charid', 'corpname', 'corpid', 'allyname', 'allyid', ),
        self::TYPE_COLNAME       => array(EveCharacterTableMap::COL_ID, EveCharacterTableMap::COL_EVEAPIID, EveCharacterTableMap::COL_CHARNAME, EveCharacterTableMap::COL_CHARID, EveCharacterTableMap::COL_CORPNAME, EveCharacterTableMap::COL_CORPID, EveCharacterTableMap::COL_ALLYNAME, EveCharacterTableMap::COL_ALLYID, ),
        self::TYPE_FIELDNAME     => array('id', 'eveApiId', 'charName', 'charId', 'corpName', 'corpId', 'allyName', 'allyId', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Eveapiid' => 1, 'Charname' => 2, 'Charid' => 3, 'Corpname' => 4, 'Corpid' => 5, 'Allyname' => 6, 'Allyid' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'eveapiid' => 1, 'charname' => 2, 'charid' => 3, 'corpname' => 4, 'corpid' => 5, 'allyname' => 6, 'allyid' => 7, ),
        self::TYPE_COLNAME       => array(EveCharacterTableMap::COL_ID => 0, EveCharacterTableMap::COL_EVEAPIID => 1, EveCharacterTableMap::COL_CHARNAME => 2, EveCharacterTableMap::COL_CHARID => 3, EveCharacterTableMap::COL_CORPNAME => 4, EveCharacterTableMap::COL_CORPID => 5, EveCharacterTableMap::COL_ALLYNAME => 6, EveCharacterTableMap::COL_ALLYID => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'eveApiId' => 1, 'charName' => 2, 'charId' => 3, 'corpName' => 4, 'corpId' => 5, 'allyName' => 6, 'allyId' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('evecharacter');
        $this->setPhpName('EveCharacter');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ECP\\EveCharacter');
        $this->setPackage('ECP');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('eveApiId', 'Eveapiid', 'INTEGER', 'eveapi', 'id', true, null, null);
        $this->addColumn('charName', 'Charname', 'VARCHAR', true, 32, null);
        $this->addColumn('charId', 'Charid', 'INTEGER', true, null, null);
        $this->addColumn('corpName', 'Corpname', 'VARCHAR', true, 32, null);
        $this->addColumn('corpId', 'Corpid', 'INTEGER', true, null, null);
        $this->addColumn('allyName', 'Allyname', 'VARCHAR', true, 32, null);
        $this->addColumn('allyId', 'Allyid', 'INTEGER', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('EveApi', '\\ECP\\EveApi', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':eveApiId',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? EveCharacterTableMap::CLASS_DEFAULT : EveCharacterTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (EveCharacter object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = EveCharacterTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = EveCharacterTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + EveCharacterTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = EveCharacterTableMap::OM_CLASS;
            /** @var EveCharacter $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            EveCharacterTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = EveCharacterTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = EveCharacterTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var EveCharacter $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                EveCharacterTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(EveCharacterTableMap::COL_ID);
            $criteria->addSelectColumn(EveCharacterTableMap::COL_EVEAPIID);
            $criteria->addSelectColumn(EveCharacterTableMap::COL_CHARNAME);
            $criteria->addSelectColumn(EveCharacterTableMap::COL_CHARID);
            $criteria->addSelectColumn(EveCharacterTableMap::COL_CORPNAME);
            $criteria->addSelectColumn(EveCharacterTableMap::COL_CORPID);
            $criteria->addSelectColumn(EveCharacterTableMap::COL_ALLYNAME);
            $criteria->addSelectColumn(EveCharacterTableMap::COL_ALLYID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.eveApiId');
            $criteria->addSelectColumn($alias . '.charName');
            $criteria->addSelectColumn($alias . '.charId');
            $criteria->addSelectColumn($alias . '.corpName');
            $criteria->addSelectColumn($alias . '.corpId');
            $criteria->addSelectColumn($alias . '.allyName');
            $criteria->addSelectColumn($alias . '.allyId');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(EveCharacterTableMap::DATABASE_NAME)->getTable(EveCharacterTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(EveCharacterTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(EveCharacterTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new EveCharacterTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a EveCharacter or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or EveCharacter object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EveCharacterTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ECP\EveCharacter) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(EveCharacterTableMap::DATABASE_NAME);
            $criteria->add(EveCharacterTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = EveCharacterQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            EveCharacterTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                EveCharacterTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the evecharacter table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return EveCharacterQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a EveCharacter or Criteria object.
     *
     * @param mixed               $criteria Criteria or EveCharacter object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EveCharacterTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from EveCharacter object
        }

        if ($criteria->containsKey(EveCharacterTableMap::COL_ID) && $criteria->keyContainsValue(EveCharacterTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.EveCharacterTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = EveCharacterQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // EveCharacterTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
EveCharacterTableMap::buildTableMap();
