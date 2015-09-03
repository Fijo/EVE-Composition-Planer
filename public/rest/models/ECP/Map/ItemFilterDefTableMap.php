<?php

namespace ECP\Map;

use ECP\ItemFilterDef;
use ECP\ItemFilterDefQuery;
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
 * This class defines the structure of the 'itemfilterdef' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ItemFilterDefTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ECP.Map.ItemFilterDefTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'itemfilterdef';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ECP\\ItemFilterDef';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ECP.ItemFilterDef';

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
    const COL_ID = 'itemfilterdef.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'itemfilterdef.name';

    /**
     * the column name for the typeId field
     */
    const COL_TYPEID = 'itemfilterdef.typeId';

    /**
     * the column name for the min field
     */
    const COL_MIN = 'itemfilterdef.min';

    /**
     * the column name for the max field
     */
    const COL_MAX = 'itemfilterdef.max';

    /**
     * the column name for the minlength field
     */
    const COL_MINLENGTH = 'itemfilterdef.minlength';

    /**
     * the column name for the maxlength field
     */
    const COL_MAXLENGTH = 'itemfilterdef.maxlength';

    /**
     * the column name for the depth field
     */
    const COL_DEPTH = 'itemfilterdef.depth';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Typeid', 'Min', 'Max', 'Minlength', 'Maxlength', 'Depth', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'typeid', 'min', 'max', 'minlength', 'maxlength', 'depth', ),
        self::TYPE_COLNAME       => array(ItemFilterDefTableMap::COL_ID, ItemFilterDefTableMap::COL_NAME, ItemFilterDefTableMap::COL_TYPEID, ItemFilterDefTableMap::COL_MIN, ItemFilterDefTableMap::COL_MAX, ItemFilterDefTableMap::COL_MINLENGTH, ItemFilterDefTableMap::COL_MAXLENGTH, ItemFilterDefTableMap::COL_DEPTH, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'typeId', 'min', 'max', 'minlength', 'maxlength', 'depth', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Typeid' => 2, 'Min' => 3, 'Max' => 4, 'Minlength' => 5, 'Maxlength' => 6, 'Depth' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'typeid' => 2, 'min' => 3, 'max' => 4, 'minlength' => 5, 'maxlength' => 6, 'depth' => 7, ),
        self::TYPE_COLNAME       => array(ItemFilterDefTableMap::COL_ID => 0, ItemFilterDefTableMap::COL_NAME => 1, ItemFilterDefTableMap::COL_TYPEID => 2, ItemFilterDefTableMap::COL_MIN => 3, ItemFilterDefTableMap::COL_MAX => 4, ItemFilterDefTableMap::COL_MINLENGTH => 5, ItemFilterDefTableMap::COL_MAXLENGTH => 6, ItemFilterDefTableMap::COL_DEPTH => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'typeId' => 2, 'min' => 3, 'max' => 4, 'minlength' => 5, 'maxlength' => 6, 'depth' => 7, ),
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
        $this->setName('itemfilterdef');
        $this->setPhpName('ItemFilterDef');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ECP\\ItemFilterDef');
        $this->setPackage('ECP');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 32, null);
        $this->addForeignKey('typeId', 'Typeid', 'INTEGER', 'type', 'id', true, null, null);
        $this->addColumn('min', 'Min', 'INTEGER', true, null, null);
        $this->addColumn('max', 'Max', 'INTEGER', true, null, null);
        $this->addColumn('minlength', 'Minlength', 'INTEGER', true, null, null);
        $this->addColumn('maxlength', 'Maxlength', 'INTEGER', true, null, null);
        $this->addColumn('depth', 'Depth', 'INTEGER', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Type', '\\ECP\\Type', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':typeId',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('ItemFilterRule', '\\ECP\\ItemFilterRule', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':itemFilterDefId',
    1 => ':id',
  ),
), null, null, 'ItemFilterRules', false);
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
        return $withPrefix ? ItemFilterDefTableMap::CLASS_DEFAULT : ItemFilterDefTableMap::OM_CLASS;
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
     * @return array           (ItemFilterDef object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ItemFilterDefTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ItemFilterDefTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ItemFilterDefTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ItemFilterDefTableMap::OM_CLASS;
            /** @var ItemFilterDef $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ItemFilterDefTableMap::addInstanceToPool($obj, $key);
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
            $key = ItemFilterDefTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ItemFilterDefTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ItemFilterDef $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ItemFilterDefTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ItemFilterDefTableMap::COL_ID);
            $criteria->addSelectColumn(ItemFilterDefTableMap::COL_NAME);
            $criteria->addSelectColumn(ItemFilterDefTableMap::COL_TYPEID);
            $criteria->addSelectColumn(ItemFilterDefTableMap::COL_MIN);
            $criteria->addSelectColumn(ItemFilterDefTableMap::COL_MAX);
            $criteria->addSelectColumn(ItemFilterDefTableMap::COL_MINLENGTH);
            $criteria->addSelectColumn(ItemFilterDefTableMap::COL_MAXLENGTH);
            $criteria->addSelectColumn(ItemFilterDefTableMap::COL_DEPTH);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.typeId');
            $criteria->addSelectColumn($alias . '.min');
            $criteria->addSelectColumn($alias . '.max');
            $criteria->addSelectColumn($alias . '.minlength');
            $criteria->addSelectColumn($alias . '.maxlength');
            $criteria->addSelectColumn($alias . '.depth');
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
        return Propel::getServiceContainer()->getDatabaseMap(ItemFilterDefTableMap::DATABASE_NAME)->getTable(ItemFilterDefTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ItemFilterDefTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ItemFilterDefTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ItemFilterDefTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ItemFilterDef or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ItemFilterDef object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemFilterDefTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ECP\ItemFilterDef) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ItemFilterDefTableMap::DATABASE_NAME);
            $criteria->add(ItemFilterDefTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ItemFilterDefQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ItemFilterDefTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ItemFilterDefTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the itemfilterdef table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ItemFilterDefQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ItemFilterDef or Criteria object.
     *
     * @param mixed               $criteria Criteria or ItemFilterDef object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemFilterDefTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ItemFilterDef object
        }

        if ($criteria->containsKey(ItemFilterDefTableMap::COL_ID) && $criteria->keyContainsValue(ItemFilterDefTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ItemFilterDefTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ItemFilterDefQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ItemFilterDefTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ItemFilterDefTableMap::buildTableMap();
