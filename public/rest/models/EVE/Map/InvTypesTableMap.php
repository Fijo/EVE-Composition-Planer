<?php

namespace EVE\Map;

use EVE\InvTypes;
use EVE\InvTypesQuery;
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
 * This class defines the structure of the 'invtypes' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class InvTypesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'EVE.Map.InvTypesTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'eve';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'invtypes';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\EVE\\InvTypes';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'EVE.InvTypes';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the typeID field
     */
    const COL_TYPEID = 'invtypes.typeID';

    /**
     * the column name for the groupID field
     */
    const COL_GROUPID = 'invtypes.groupID';

    /**
     * the column name for the typeName field
     */
    const COL_TYPENAME = 'invtypes.typeName';

    /**
     * the column name for the volume field
     */
    const COL_VOLUME = 'invtypes.volume';

    /**
     * the column name for the capacity field
     */
    const COL_CAPACITY = 'invtypes.capacity';

    /**
     * the column name for the published field
     */
    const COL_PUBLISHED = 'invtypes.published';

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
        self::TYPE_PHPNAME       => array('Typeid', 'Groupid', 'Typename', 'Volume', 'Capacity', 'Published', ),
        self::TYPE_CAMELNAME     => array('typeid', 'groupid', 'typename', 'volume', 'capacity', 'published', ),
        self::TYPE_COLNAME       => array(InvTypesTableMap::COL_TYPEID, InvTypesTableMap::COL_GROUPID, InvTypesTableMap::COL_TYPENAME, InvTypesTableMap::COL_VOLUME, InvTypesTableMap::COL_CAPACITY, InvTypesTableMap::COL_PUBLISHED, ),
        self::TYPE_FIELDNAME     => array('typeID', 'groupID', 'typeName', 'volume', 'capacity', 'published', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Typeid' => 0, 'Groupid' => 1, 'Typename' => 2, 'Volume' => 3, 'Capacity' => 4, 'Published' => 5, ),
        self::TYPE_CAMELNAME     => array('typeid' => 0, 'groupid' => 1, 'typename' => 2, 'volume' => 3, 'capacity' => 4, 'published' => 5, ),
        self::TYPE_COLNAME       => array(InvTypesTableMap::COL_TYPEID => 0, InvTypesTableMap::COL_GROUPID => 1, InvTypesTableMap::COL_TYPENAME => 2, InvTypesTableMap::COL_VOLUME => 3, InvTypesTableMap::COL_CAPACITY => 4, InvTypesTableMap::COL_PUBLISHED => 5, ),
        self::TYPE_FIELDNAME     => array('typeID' => 0, 'groupID' => 1, 'typeName' => 2, 'volume' => 3, 'capacity' => 4, 'published' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('invtypes');
        $this->setPhpName('InvTypes');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\EVE\\InvTypes');
        $this->setPackage('EVE');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('typeID', 'Typeid', 'INTEGER', true, null, null);
        $this->addForeignKey('groupID', 'Groupid', 'INTEGER', 'invgroups', 'groupID', true, null, null);
        $this->addColumn('typeName', 'Typename', 'VARCHAR', true, 100, null);
        $this->addColumn('volume', 'Volume', 'DOUBLE', true, null, null);
        $this->addColumn('capacity', 'Capacity', 'DOUBLE', true, null, null);
        $this->addColumn('published', 'Published', 'INTEGER', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('InvGroups', '\\EVE\\InvGroups', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':groupID',
    1 => ':groupID',
  ),
), null, null, null, false);
        $this->addRelation('InvMetaTypes', '\\EVE\\InvMetaTypes', RelationMap::ONE_TO_ONE, array (
  0 =>
  array (
    0 => ':typeID',
    1 => ':typeID',
  ),
), null, null, null, false);
        $this->addRelation('DgmTypeEffects', '\\EVE\\DgmTypeEffects', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':typeID',
    1 => ':typeID',
  ),
), null, null, 'DgmTypeEffectss', false);
        $this->addRelation('DgmTypeAttributes', '\\EVE\\DgmTypeAttributes', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':typeID',
    1 => ':typeID',
  ),
), null, null, 'DgmTypeAttributess', false);
        $this->addRelation('DgmEffects', '\\EVE\\DgmEffects', RelationMap::MANY_TO_MANY, array(), null, null, 'DgmEffectss');
        $this->addRelation('DgmAttributeTypes', '\\EVE\\DgmAttributeTypes', RelationMap::MANY_TO_MANY, array(), null, null, 'DgmAttributeTypess');
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Typeid', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Typeid', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('Typeid', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? InvTypesTableMap::CLASS_DEFAULT : InvTypesTableMap::OM_CLASS;
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
     * @return array           (InvTypes object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = InvTypesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = InvTypesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + InvTypesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = InvTypesTableMap::OM_CLASS;
            /** @var InvTypes $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            InvTypesTableMap::addInstanceToPool($obj, $key);
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
            $key = InvTypesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = InvTypesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var InvTypes $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                InvTypesTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(InvTypesTableMap::COL_TYPEID);
            $criteria->addSelectColumn(InvTypesTableMap::COL_GROUPID);
            $criteria->addSelectColumn(InvTypesTableMap::COL_TYPENAME);
            $criteria->addSelectColumn(InvTypesTableMap::COL_VOLUME);
            $criteria->addSelectColumn(InvTypesTableMap::COL_CAPACITY);
            $criteria->addSelectColumn(InvTypesTableMap::COL_PUBLISHED);
        } else {
            $criteria->addSelectColumn($alias . '.typeID');
            $criteria->addSelectColumn($alias . '.groupID');
            $criteria->addSelectColumn($alias . '.typeName');
            $criteria->addSelectColumn($alias . '.volume');
            $criteria->addSelectColumn($alias . '.capacity');
            $criteria->addSelectColumn($alias . '.published');
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
        return Propel::getServiceContainer()->getDatabaseMap(InvTypesTableMap::DATABASE_NAME)->getTable(InvTypesTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(InvTypesTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(InvTypesTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new InvTypesTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a InvTypes or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or InvTypes object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(InvTypesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \EVE\InvTypes) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(InvTypesTableMap::DATABASE_NAME);
            $criteria->add(InvTypesTableMap::COL_TYPEID, (array) $values, Criteria::IN);
        }

        $query = InvTypesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            InvTypesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                InvTypesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the invtypes table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return InvTypesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a InvTypes or Criteria object.
     *
     * @param mixed               $criteria Criteria or InvTypes object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InvTypesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from InvTypes object
        }

        if ($criteria->containsKey(InvTypesTableMap::COL_TYPEID) && $criteria->keyContainsValue(InvTypesTableMap::COL_TYPEID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.InvTypesTableMap::COL_TYPEID.')');
        }


        // Set the correct dbName
        $query = InvTypesQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // InvTypesTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
InvTypesTableMap::buildTableMap();
