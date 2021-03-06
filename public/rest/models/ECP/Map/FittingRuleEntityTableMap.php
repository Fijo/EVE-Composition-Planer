<?php

namespace ECP\Map;

use ECP\FittingRuleEntity;
use ECP\FittingRuleEntityQuery;
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
 * This class defines the structure of the 'fittingruleentity' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class FittingRuleEntityTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ECP.Map.FittingRuleEntityTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fittingruleentity';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ECP\\FittingRuleEntity';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ECP.FittingRuleEntity';

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
    const COL_ID = 'fittingruleentity.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'fittingruleentity.name';

    /**
     * the column name for the userId field
     */
    const COL_USERID = 'fittingruleentity.userId';

    /**
     * the column name for the isGlobal field
     */
    const COL_ISGLOBAL = 'fittingruleentity.isGlobal';

    /**
     * the column name for the isListed field
     */
    const COL_ISLISTED = 'fittingruleentity.isListed';

    /**
     * the column name for the forkedId field
     */
    const COL_FORKEDID = 'fittingruleentity.forkedId';

    /**
     * the column name for the isFilterTypeUptodate field
     */
    const COL_ISFILTERTYPEUPTODATE = 'fittingruleentity.isFilterTypeUptodate';

    /**
     * the column name for the lastModified field
     */
    const COL_LASTMODIFIED = 'fittingruleentity.lastModified';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Userid', 'Isglobal', 'Islisted', 'Forkedid', 'Isfiltertypeuptodate', 'Lastmodified', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'userid', 'isglobal', 'islisted', 'forkedid', 'isfiltertypeuptodate', 'lastmodified', ),
        self::TYPE_COLNAME       => array(FittingRuleEntityTableMap::COL_ID, FittingRuleEntityTableMap::COL_NAME, FittingRuleEntityTableMap::COL_USERID, FittingRuleEntityTableMap::COL_ISGLOBAL, FittingRuleEntityTableMap::COL_ISLISTED, FittingRuleEntityTableMap::COL_FORKEDID, FittingRuleEntityTableMap::COL_ISFILTERTYPEUPTODATE, FittingRuleEntityTableMap::COL_LASTMODIFIED, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'userId', 'isGlobal', 'isListed', 'forkedId', 'isFilterTypeUptodate', 'lastModified', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Userid' => 2, 'Isglobal' => 3, 'Islisted' => 4, 'Forkedid' => 5, 'Isfiltertypeuptodate' => 6, 'Lastmodified' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'userid' => 2, 'isglobal' => 3, 'islisted' => 4, 'forkedid' => 5, 'isfiltertypeuptodate' => 6, 'lastmodified' => 7, ),
        self::TYPE_COLNAME       => array(FittingRuleEntityTableMap::COL_ID => 0, FittingRuleEntityTableMap::COL_NAME => 1, FittingRuleEntityTableMap::COL_USERID => 2, FittingRuleEntityTableMap::COL_ISGLOBAL => 3, FittingRuleEntityTableMap::COL_ISLISTED => 4, FittingRuleEntityTableMap::COL_FORKEDID => 5, FittingRuleEntityTableMap::COL_ISFILTERTYPEUPTODATE => 6, FittingRuleEntityTableMap::COL_LASTMODIFIED => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'userId' => 2, 'isGlobal' => 3, 'isListed' => 4, 'forkedId' => 5, 'isFilterTypeUptodate' => 6, 'lastModified' => 7, ),
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
        $this->setName('fittingruleentity');
        $this->setPhpName('FittingRuleEntity');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ECP\\FittingRuleEntity');
        $this->setPackage('ECP');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 32, null);
        $this->addForeignKey('userId', 'Userid', 'INTEGER', 'user', 'id', true, null, null);
        $this->addColumn('isGlobal', 'Isglobal', 'INTEGER', true, null, null);
        $this->addColumn('isListed', 'Islisted', 'INTEGER', true, null, null);
        $this->addForeignKey('forkedId', 'Forkedid', 'INTEGER', 'fittingruleentity', 'id', false, null, null);
        $this->addColumn('isFilterTypeUptodate', 'Isfiltertypeuptodate', 'INTEGER', true, null, null);
        $this->addColumn('lastModified', 'Lastmodified', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', '\\ECP\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':userId',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('FittingRuleEntityRelatedByForkedid', '\\ECP\\FittingRuleEntity', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':forkedId',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('FittingRuleEntityRelatedById', '\\ECP\\FittingRuleEntity', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':forkedId',
    1 => ':id',
  ),
), null, null, 'FittingRuleEntitiesRelatedById', false);
        $this->addRelation('FittingRuleRow', '\\ECP\\FittingRuleRow', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':fittingRuleEntityId',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'FittingRuleRows', false);
        $this->addRelation('RulesetFilterRule', '\\ECP\\RulesetFilterRule', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':fittingRuleEntityId',
    1 => ':id',
  ),
), null, null, 'RulesetFilterRules', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to fittingruleentity     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        FittingRuleRowTableMap::clearInstancePool();
    }

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
        return $withPrefix ? FittingRuleEntityTableMap::CLASS_DEFAULT : FittingRuleEntityTableMap::OM_CLASS;
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
     * @return array           (FittingRuleEntity object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = FittingRuleEntityTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = FittingRuleEntityTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FittingRuleEntityTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FittingRuleEntityTableMap::OM_CLASS;
            /** @var FittingRuleEntity $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FittingRuleEntityTableMap::addInstanceToPool($obj, $key);
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
            $key = FittingRuleEntityTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = FittingRuleEntityTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var FittingRuleEntity $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                FittingRuleEntityTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(FittingRuleEntityTableMap::COL_ID);
            $criteria->addSelectColumn(FittingRuleEntityTableMap::COL_NAME);
            $criteria->addSelectColumn(FittingRuleEntityTableMap::COL_USERID);
            $criteria->addSelectColumn(FittingRuleEntityTableMap::COL_ISGLOBAL);
            $criteria->addSelectColumn(FittingRuleEntityTableMap::COL_ISLISTED);
            $criteria->addSelectColumn(FittingRuleEntityTableMap::COL_FORKEDID);
            $criteria->addSelectColumn(FittingRuleEntityTableMap::COL_ISFILTERTYPEUPTODATE);
            $criteria->addSelectColumn(FittingRuleEntityTableMap::COL_LASTMODIFIED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.userId');
            $criteria->addSelectColumn($alias . '.isGlobal');
            $criteria->addSelectColumn($alias . '.isListed');
            $criteria->addSelectColumn($alias . '.forkedId');
            $criteria->addSelectColumn($alias . '.isFilterTypeUptodate');
            $criteria->addSelectColumn($alias . '.lastModified');
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
        return Propel::getServiceContainer()->getDatabaseMap(FittingRuleEntityTableMap::DATABASE_NAME)->getTable(FittingRuleEntityTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(FittingRuleEntityTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(FittingRuleEntityTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new FittingRuleEntityTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a FittingRuleEntity or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or FittingRuleEntity object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FittingRuleEntityTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ECP\FittingRuleEntity) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FittingRuleEntityTableMap::DATABASE_NAME);
            $criteria->add(FittingRuleEntityTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = FittingRuleEntityQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            FittingRuleEntityTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                FittingRuleEntityTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fittingruleentity table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return FittingRuleEntityQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a FittingRuleEntity or Criteria object.
     *
     * @param mixed               $criteria Criteria or FittingRuleEntity object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FittingRuleEntityTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from FittingRuleEntity object
        }

        if ($criteria->containsKey(FittingRuleEntityTableMap::COL_ID) && $criteria->keyContainsValue(FittingRuleEntityTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.FittingRuleEntityTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = FittingRuleEntityQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // FittingRuleEntityTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
FittingRuleEntityTableMap::buildTableMap();
