<?php

namespace EVE\Map;

use EVE\InvGroups;
use EVE\InvGroupsQuery;
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
 * This class defines the structure of the 'invgroups' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class InvGroupsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'EVE.Map.InvGroupsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'eve';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'invgroups';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\EVE\\InvGroups';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'EVE.InvGroups';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the groupID field
     */
    const COL_GROUPID = 'invgroups.groupID';

    /**
     * the column name for the categoryID field
     */
    const COL_CATEGORYID = 'invgroups.categoryID';

    /**
     * the column name for the groupName field
     */
    const COL_GROUPNAME = 'invgroups.groupName';

    /**
     * the column name for the published field
     */
    const COL_PUBLISHED = 'invgroups.published';

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
        self::TYPE_PHPNAME       => array('Groupid', 'Categoryid', 'Groupname', 'Published', ),
        self::TYPE_CAMELNAME     => array('groupid', 'categoryid', 'groupname', 'published', ),
        self::TYPE_COLNAME       => array(InvGroupsTableMap::COL_GROUPID, InvGroupsTableMap::COL_CATEGORYID, InvGroupsTableMap::COL_GROUPNAME, InvGroupsTableMap::COL_PUBLISHED, ),
        self::TYPE_FIELDNAME     => array('groupID', 'categoryID', 'groupName', 'published', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Groupid' => 0, 'Categoryid' => 1, 'Groupname' => 2, 'Published' => 3, ),
        self::TYPE_CAMELNAME     => array('groupid' => 0, 'categoryid' => 1, 'groupname' => 2, 'published' => 3, ),
        self::TYPE_COLNAME       => array(InvGroupsTableMap::COL_GROUPID => 0, InvGroupsTableMap::COL_CATEGORYID => 1, InvGroupsTableMap::COL_GROUPNAME => 2, InvGroupsTableMap::COL_PUBLISHED => 3, ),
        self::TYPE_FIELDNAME     => array('groupID' => 0, 'categoryID' => 1, 'groupName' => 2, 'published' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
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
        $this->setName('invgroups');
        $this->setPhpName('InvGroups');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\EVE\\InvGroups');
        $this->setPackage('EVE');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('groupID', 'Groupid', 'INTEGER', true, null, null);
        $this->addForeignKey('categoryID', 'Categoryid', 'INTEGER', 'invcategories', 'categoryID', true, null, null);
        $this->addColumn('groupName', 'Groupname', 'VARCHAR', true, 100, null);
        $this->addColumn('published', 'Published', 'INTEGER', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('InvCategories', '\\EVE\\InvCategories', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':categoryID',
    1 => ':categoryID',
  ),
), null, null, null, false);
        $this->addRelation('InvTypes', '\\EVE\\InvTypes', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':groupID',
    1 => ':groupID',
  ),
), null, null, 'InvTypess', false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Groupid', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Groupid', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('Groupid', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? InvGroupsTableMap::CLASS_DEFAULT : InvGroupsTableMap::OM_CLASS;
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
     * @return array           (InvGroups object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = InvGroupsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = InvGroupsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + InvGroupsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = InvGroupsTableMap::OM_CLASS;
            /** @var InvGroups $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            InvGroupsTableMap::addInstanceToPool($obj, $key);
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
            $key = InvGroupsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = InvGroupsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var InvGroups $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                InvGroupsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(InvGroupsTableMap::COL_GROUPID);
            $criteria->addSelectColumn(InvGroupsTableMap::COL_CATEGORYID);
            $criteria->addSelectColumn(InvGroupsTableMap::COL_GROUPNAME);
            $criteria->addSelectColumn(InvGroupsTableMap::COL_PUBLISHED);
        } else {
            $criteria->addSelectColumn($alias . '.groupID');
            $criteria->addSelectColumn($alias . '.categoryID');
            $criteria->addSelectColumn($alias . '.groupName');
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
        return Propel::getServiceContainer()->getDatabaseMap(InvGroupsTableMap::DATABASE_NAME)->getTable(InvGroupsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(InvGroupsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(InvGroupsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new InvGroupsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a InvGroups or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or InvGroups object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(InvGroupsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \EVE\InvGroups) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(InvGroupsTableMap::DATABASE_NAME);
            $criteria->add(InvGroupsTableMap::COL_GROUPID, (array) $values, Criteria::IN);
        }

        $query = InvGroupsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            InvGroupsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                InvGroupsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the invgroups table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return InvGroupsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a InvGroups or Criteria object.
     *
     * @param mixed               $criteria Criteria or InvGroups object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InvGroupsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from InvGroups object
        }

        if ($criteria->containsKey(InvGroupsTableMap::COL_GROUPID) && $criteria->keyContainsValue(InvGroupsTableMap::COL_GROUPID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.InvGroupsTableMap::COL_GROUPID.')');
        }


        // Set the correct dbName
        $query = InvGroupsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // InvGroupsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
InvGroupsTableMap::buildTableMap();
