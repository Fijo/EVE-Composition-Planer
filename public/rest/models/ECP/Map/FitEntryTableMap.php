<?php

namespace ECP\Map;

use ECP\FitEntry;
use ECP\FitEntryQuery;
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
 * This class defines the structure of the 'fitentry' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class FitEntryTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ECP.Map.FitEntryTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fitentry';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ECP\\FitEntry';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ECP.FitEntry';

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
    const COL_ID = 'fitentry.id';

    /**
     * the column name for the compositionRowId field
     */
    const COL_COMPOSITIONROWID = 'fitentry.compositionRowId';

    /**
     * the column name for the ind3x field
     */
    const COL_IND3X = 'fitentry.ind3x';

    /**
     * the column name for the fitEntryTypeId field
     */
    const COL_FITENTRYTYPEID = 'fitentry.fitEntryTypeId';

    /**
     * the column name for the itemId field
     */
    const COL_ITEMID = 'fitentry.itemId';

    /**
     * the column name for the ammoId field
     */
    const COL_AMMOID = 'fitentry.ammoId';

    /**
     * the column name for the amount field
     */
    const COL_AMOUNT = 'fitentry.amount';

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
        self::TYPE_PHPNAME       => array('Id', 'Compositionrowid', 'Ind3x', 'Fitentrytypeid', 'Itemid', 'Ammoid', 'Amount', ),
        self::TYPE_CAMELNAME     => array('id', 'compositionrowid', 'ind3x', 'fitentrytypeid', 'itemid', 'ammoid', 'amount', ),
        self::TYPE_COLNAME       => array(FitEntryTableMap::COL_ID, FitEntryTableMap::COL_COMPOSITIONROWID, FitEntryTableMap::COL_IND3X, FitEntryTableMap::COL_FITENTRYTYPEID, FitEntryTableMap::COL_ITEMID, FitEntryTableMap::COL_AMMOID, FitEntryTableMap::COL_AMOUNT, ),
        self::TYPE_FIELDNAME     => array('id', 'compositionRowId', 'ind3x', 'fitEntryTypeId', 'itemId', 'ammoId', 'amount', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Compositionrowid' => 1, 'Ind3x' => 2, 'Fitentrytypeid' => 3, 'Itemid' => 4, 'Ammoid' => 5, 'Amount' => 6, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'compositionrowid' => 1, 'ind3x' => 2, 'fitentrytypeid' => 3, 'itemid' => 4, 'ammoid' => 5, 'amount' => 6, ),
        self::TYPE_COLNAME       => array(FitEntryTableMap::COL_ID => 0, FitEntryTableMap::COL_COMPOSITIONROWID => 1, FitEntryTableMap::COL_IND3X => 2, FitEntryTableMap::COL_FITENTRYTYPEID => 3, FitEntryTableMap::COL_ITEMID => 4, FitEntryTableMap::COL_AMMOID => 5, FitEntryTableMap::COL_AMOUNT => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'compositionRowId' => 1, 'ind3x' => 2, 'fitEntryTypeId' => 3, 'itemId' => 4, 'ammoId' => 5, 'amount' => 6, ),
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
        $this->setName('fitentry');
        $this->setPhpName('FitEntry');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ECP\\FitEntry');
        $this->setPackage('ECP');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('compositionRowId', 'Compositionrowid', 'INTEGER', 'compositionrow', 'id', true, null, null);
        $this->addColumn('ind3x', 'Ind3x', 'INTEGER', true, null, null);
        $this->addForeignKey('fitEntryTypeId', 'Fitentrytypeid', 'INTEGER', 'fitentrytype', 'id', true, null, null);
        $this->addColumn('itemId', 'Itemid', 'INTEGER', false, null, null);
        $this->addColumn('ammoId', 'Ammoid', 'INTEGER', false, null, null);
        $this->addColumn('amount', 'Amount', 'INTEGER', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('CompositionRow', '\\ECP\\CompositionRow', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':compositionRowId',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('FitEntryType', '\\ECP\\FitEntryType', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':fitEntryTypeId',
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
        return $withPrefix ? FitEntryTableMap::CLASS_DEFAULT : FitEntryTableMap::OM_CLASS;
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
     * @return array           (FitEntry object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = FitEntryTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = FitEntryTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FitEntryTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FitEntryTableMap::OM_CLASS;
            /** @var FitEntry $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FitEntryTableMap::addInstanceToPool($obj, $key);
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
            $key = FitEntryTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = FitEntryTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var FitEntry $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                FitEntryTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(FitEntryTableMap::COL_ID);
            $criteria->addSelectColumn(FitEntryTableMap::COL_COMPOSITIONROWID);
            $criteria->addSelectColumn(FitEntryTableMap::COL_IND3X);
            $criteria->addSelectColumn(FitEntryTableMap::COL_FITENTRYTYPEID);
            $criteria->addSelectColumn(FitEntryTableMap::COL_ITEMID);
            $criteria->addSelectColumn(FitEntryTableMap::COL_AMMOID);
            $criteria->addSelectColumn(FitEntryTableMap::COL_AMOUNT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.compositionRowId');
            $criteria->addSelectColumn($alias . '.ind3x');
            $criteria->addSelectColumn($alias . '.fitEntryTypeId');
            $criteria->addSelectColumn($alias . '.itemId');
            $criteria->addSelectColumn($alias . '.ammoId');
            $criteria->addSelectColumn($alias . '.amount');
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
        return Propel::getServiceContainer()->getDatabaseMap(FitEntryTableMap::DATABASE_NAME)->getTable(FitEntryTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(FitEntryTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(FitEntryTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new FitEntryTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a FitEntry or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or FitEntry object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FitEntryTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ECP\FitEntry) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FitEntryTableMap::DATABASE_NAME);
            $criteria->add(FitEntryTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = FitEntryQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            FitEntryTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                FitEntryTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fitentry table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return FitEntryQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a FitEntry or Criteria object.
     *
     * @param mixed               $criteria Criteria or FitEntry object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FitEntryTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from FitEntry object
        }

        if ($criteria->containsKey(FitEntryTableMap::COL_ID) && $criteria->keyContainsValue(FitEntryTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.FitEntryTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = FitEntryQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // FitEntryTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
FitEntryTableMap::buildTableMap();
