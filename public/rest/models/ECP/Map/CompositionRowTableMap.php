<?php

namespace ECP\Map;

use ECP\CompositionRow;
use ECP\CompositionRowQuery;
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
 * This class defines the structure of the 'compositionrow' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CompositionRowTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ECP.Map.CompositionRowTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'compositionrow';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ECP\\CompositionRow';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ECP.CompositionRow';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id field
     */
    const COL_ID = 'compositionrow.id';

    /**
     * the column name for the compositionEntityId field
     */
    const COL_COMPOSITIONENTITYID = 'compositionrow.compositionEntityId';

    /**
     * the column name for the shipId field
     */
    const COL_SHIPID = 'compositionrow.shipId';

    /**
     * the column name for the fitName field
     */
    const COL_FITNAME = 'compositionrow.fitName';

    /**
     * the column name for the notes field
     */
    const COL_NOTES = 'compositionrow.notes';

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
        self::TYPE_PHPNAME       => array('Id', 'Compositionentityid', 'Shipid', 'Fitname', 'Notes', ),
        self::TYPE_CAMELNAME     => array('id', 'compositionentityid', 'shipid', 'fitname', 'notes', ),
        self::TYPE_COLNAME       => array(CompositionRowTableMap::COL_ID, CompositionRowTableMap::COL_COMPOSITIONENTITYID, CompositionRowTableMap::COL_SHIPID, CompositionRowTableMap::COL_FITNAME, CompositionRowTableMap::COL_NOTES, ),
        self::TYPE_FIELDNAME     => array('id', 'compositionEntityId', 'shipId', 'fitName', 'notes', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Compositionentityid' => 1, 'Shipid' => 2, 'Fitname' => 3, 'Notes' => 4, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'compositionentityid' => 1, 'shipid' => 2, 'fitname' => 3, 'notes' => 4, ),
        self::TYPE_COLNAME       => array(CompositionRowTableMap::COL_ID => 0, CompositionRowTableMap::COL_COMPOSITIONENTITYID => 1, CompositionRowTableMap::COL_SHIPID => 2, CompositionRowTableMap::COL_FITNAME => 3, CompositionRowTableMap::COL_NOTES => 4, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'compositionEntityId' => 1, 'shipId' => 2, 'fitName' => 3, 'notes' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
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
        $this->setName('compositionrow');
        $this->setPhpName('CompositionRow');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ECP\\CompositionRow');
        $this->setPackage('ECP');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('compositionEntityId', 'Compositionentityid', 'INTEGER', 'compositionentity', 'id', true, null, null);
        $this->addColumn('shipId', 'Shipid', 'INTEGER', true, null, null);
        $this->addColumn('fitName', 'Fitname', 'VARCHAR', true, 128, null);
        $this->addColumn('notes', 'Notes', 'VARCHAR', false, 4096, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('CompositionEntity', '\\ECP\\CompositionEntity', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':compositionEntityId',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('FitEntry', '\\ECP\\FitEntry', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':compositionRowId',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'FitEntries', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to compositionrow     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        FitEntryTableMap::clearInstancePool();
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
        return $withPrefix ? CompositionRowTableMap::CLASS_DEFAULT : CompositionRowTableMap::OM_CLASS;
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
     * @return array           (CompositionRow object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CompositionRowTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CompositionRowTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CompositionRowTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CompositionRowTableMap::OM_CLASS;
            /** @var CompositionRow $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CompositionRowTableMap::addInstanceToPool($obj, $key);
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
            $key = CompositionRowTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CompositionRowTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var CompositionRow $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CompositionRowTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CompositionRowTableMap::COL_ID);
            $criteria->addSelectColumn(CompositionRowTableMap::COL_COMPOSITIONENTITYID);
            $criteria->addSelectColumn(CompositionRowTableMap::COL_SHIPID);
            $criteria->addSelectColumn(CompositionRowTableMap::COL_FITNAME);
            $criteria->addSelectColumn(CompositionRowTableMap::COL_NOTES);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.compositionEntityId');
            $criteria->addSelectColumn($alias . '.shipId');
            $criteria->addSelectColumn($alias . '.fitName');
            $criteria->addSelectColumn($alias . '.notes');
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
        return Propel::getServiceContainer()->getDatabaseMap(CompositionRowTableMap::DATABASE_NAME)->getTable(CompositionRowTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CompositionRowTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CompositionRowTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CompositionRowTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a CompositionRow or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CompositionRow object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CompositionRowTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ECP\CompositionRow) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CompositionRowTableMap::DATABASE_NAME);
            $criteria->add(CompositionRowTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = CompositionRowQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CompositionRowTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CompositionRowTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the compositionrow table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CompositionRowQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CompositionRow or Criteria object.
     *
     * @param mixed               $criteria Criteria or CompositionRow object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompositionRowTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CompositionRow object
        }

        if ($criteria->containsKey(CompositionRowTableMap::COL_ID) && $criteria->keyContainsValue(CompositionRowTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CompositionRowTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = CompositionRowQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CompositionRowTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CompositionRowTableMap::buildTableMap();
