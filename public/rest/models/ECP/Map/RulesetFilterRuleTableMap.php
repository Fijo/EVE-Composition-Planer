<?php

namespace ECP\Map;

use ECP\RulesetFilterRule;
use ECP\RulesetFilterRuleQuery;
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
 * This class defines the structure of the 'rulesetfilterrule' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class RulesetFilterRuleTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ECP.Map.RulesetFilterRuleTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'rulesetfilterrule';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ECP\\RulesetFilterRule';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ECP.RulesetFilterRule';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    const COL_ID = 'rulesetfilterrule.id';

    /**
     * the column name for the rulesetRuleRowId field
     */
    const COL_RULESETRULEROWID = 'rulesetfilterrule.rulesetRuleRowId';

    /**
     * the column name for the ind3x field
     */
    const COL_IND3X = 'rulesetfilterrule.ind3x';

    /**
     * the column name for the concatenation field
     */
    const COL_CONCATENATION = 'rulesetfilterrule.concatenation';

    /**
     * the column name for the fittingRuleEntityId field
     */
    const COL_FITTINGRULEENTITYID = 'rulesetfilterrule.fittingRuleEntityId';

    /**
     * the column name for the comparison field
     */
    const COL_COMPARISON = 'rulesetfilterrule.comparison';

    /**
     * the column name for the value field
     */
    const COL_VALUE = 'rulesetfilterrule.value';

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
        self::TYPE_PHPNAME       => array('Id', 'Rulesetrulerowid', 'Ind3x', 'Concatenation', 'Fittingruleentityid', 'Comparison', 'Value', ),
        self::TYPE_CAMELNAME     => array('id', 'rulesetrulerowid', 'ind3x', 'concatenation', 'fittingruleentityid', 'comparison', 'value', ),
        self::TYPE_COLNAME       => array(RulesetFilterRuleTableMap::COL_ID, RulesetFilterRuleTableMap::COL_RULESETRULEROWID, RulesetFilterRuleTableMap::COL_IND3X, RulesetFilterRuleTableMap::COL_CONCATENATION, RulesetFilterRuleTableMap::COL_FITTINGRULEENTITYID, RulesetFilterRuleTableMap::COL_COMPARISON, RulesetFilterRuleTableMap::COL_VALUE, ),
        self::TYPE_FIELDNAME     => array('id', 'rulesetRuleRowId', 'ind3x', 'concatenation', 'fittingRuleEntityId', 'comparison', 'value', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Rulesetrulerowid' => 1, 'Ind3x' => 2, 'Concatenation' => 3, 'Fittingruleentityid' => 4, 'Comparison' => 5, 'Value' => 6, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'rulesetrulerowid' => 1, 'ind3x' => 2, 'concatenation' => 3, 'fittingruleentityid' => 4, 'comparison' => 5, 'value' => 6, ),
        self::TYPE_COLNAME       => array(RulesetFilterRuleTableMap::COL_ID => 0, RulesetFilterRuleTableMap::COL_RULESETRULEROWID => 1, RulesetFilterRuleTableMap::COL_IND3X => 2, RulesetFilterRuleTableMap::COL_CONCATENATION => 3, RulesetFilterRuleTableMap::COL_FITTINGRULEENTITYID => 4, RulesetFilterRuleTableMap::COL_COMPARISON => 5, RulesetFilterRuleTableMap::COL_VALUE => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'rulesetRuleRowId' => 1, 'ind3x' => 2, 'concatenation' => 3, 'fittingRuleEntityId' => 4, 'comparison' => 5, 'value' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('rulesetfilterrule');
        $this->setPhpName('RulesetFilterRule');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ECP\\RulesetFilterRule');
        $this->setPackage('ECP');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('rulesetRuleRowId', 'Rulesetrulerowid', 'INTEGER', 'rulesetrulerow', 'id', true, null, null);
        $this->addColumn('ind3x', 'Ind3x', 'INTEGER', true, null, null);
        $this->addForeignKey('concatenation', 'Concatenation', 'INTEGER', 'comparison', 'id', false, null, null);
        $this->addForeignKey('fittingRuleEntityId', 'Fittingruleentityid', 'INTEGER', 'fittingruleentity', 'id', true, null, null);
        $this->addForeignKey('comparison', 'Comparison', 'INTEGER', 'comparison', 'id', true, null, null);
        $this->addColumn('value', 'Value', 'INTEGER', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('RulesetRuleRow', '\\ECP\\RulesetRuleRow', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':rulesetRuleRowId',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('concatenationObj', '\\ECP\\Comparison', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':concatenation',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('FittingRuleEntity', '\\ECP\\FittingRuleEntity', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':fittingRuleEntityId',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('comparisonObj', '\\ECP\\Comparison', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':comparison',
    1 => ':id',
  ),
), null, null, null, false);
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
        return $withPrefix ? RulesetFilterRuleTableMap::CLASS_DEFAULT : RulesetFilterRuleTableMap::OM_CLASS;
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
     * @return array           (RulesetFilterRule object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = RulesetFilterRuleTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = RulesetFilterRuleTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + RulesetFilterRuleTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RulesetFilterRuleTableMap::OM_CLASS;
            /** @var RulesetFilterRule $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            RulesetFilterRuleTableMap::addInstanceToPool($obj, $key);
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
            $key = RulesetFilterRuleTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = RulesetFilterRuleTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var RulesetFilterRule $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RulesetFilterRuleTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(RulesetFilterRuleTableMap::COL_ID);
            $criteria->addSelectColumn(RulesetFilterRuleTableMap::COL_RULESETRULEROWID);
            $criteria->addSelectColumn(RulesetFilterRuleTableMap::COL_IND3X);
            $criteria->addSelectColumn(RulesetFilterRuleTableMap::COL_CONCATENATION);
            $criteria->addSelectColumn(RulesetFilterRuleTableMap::COL_FITTINGRULEENTITYID);
            $criteria->addSelectColumn(RulesetFilterRuleTableMap::COL_COMPARISON);
            $criteria->addSelectColumn(RulesetFilterRuleTableMap::COL_VALUE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.rulesetRuleRowId');
            $criteria->addSelectColumn($alias . '.ind3x');
            $criteria->addSelectColumn($alias . '.concatenation');
            $criteria->addSelectColumn($alias . '.fittingRuleEntityId');
            $criteria->addSelectColumn($alias . '.comparison');
            $criteria->addSelectColumn($alias . '.value');
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
        return Propel::getServiceContainer()->getDatabaseMap(RulesetFilterRuleTableMap::DATABASE_NAME)->getTable(RulesetFilterRuleTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(RulesetFilterRuleTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(RulesetFilterRuleTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new RulesetFilterRuleTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a RulesetFilterRule or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or RulesetFilterRule object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(RulesetFilterRuleTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ECP\RulesetFilterRule) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RulesetFilterRuleTableMap::DATABASE_NAME);
            $criteria->add(RulesetFilterRuleTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = RulesetFilterRuleQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            RulesetFilterRuleTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                RulesetFilterRuleTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the rulesetfilterrule table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return RulesetFilterRuleQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a RulesetFilterRule or Criteria object.
     *
     * @param mixed               $criteria Criteria or RulesetFilterRule object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RulesetFilterRuleTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from RulesetFilterRule object
        }

        if ($criteria->containsKey(RulesetFilterRuleTableMap::COL_ID) && $criteria->keyContainsValue(RulesetFilterRuleTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.RulesetFilterRuleTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = RulesetFilterRuleQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // RulesetFilterRuleTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
RulesetFilterRuleTableMap::buildTableMap();
