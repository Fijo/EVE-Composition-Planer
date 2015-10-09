<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\GroupAccess as ChildGroupAccess;
use ECP\GroupAccessQuery as ChildGroupAccessQuery;
use ECP\Map\GroupAccessTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'groupaccess' table.
 *
 * 
 *
 * @method     ChildGroupAccessQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGroupAccessQuery orderByEntitytypeid($order = Criteria::ASC) Order by the entityTypeId column
 * @method     ChildGroupAccessQuery orderByEntityid($order = Criteria::ASC) Order by the entityId column
 * @method     ChildGroupAccessQuery orderByGroupid($order = Criteria::ASC) Order by the groupId column
 *
 * @method     ChildGroupAccessQuery groupById() Group by the id column
 * @method     ChildGroupAccessQuery groupByEntitytypeid() Group by the entityTypeId column
 * @method     ChildGroupAccessQuery groupByEntityid() Group by the entityId column
 * @method     ChildGroupAccessQuery groupByGroupid() Group by the groupId column
 *
 * @method     ChildGroupAccessQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGroupAccessQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGroupAccessQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGroupAccessQuery leftJoinEntityType($relationAlias = null) Adds a LEFT JOIN clause to the query using the EntityType relation
 * @method     ChildGroupAccessQuery rightJoinEntityType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EntityType relation
 * @method     ChildGroupAccessQuery innerJoinEntityType($relationAlias = null) Adds a INNER JOIN clause to the query using the EntityType relation
 *
 * @method     ChildGroupAccessQuery leftJoinGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the Group relation
 * @method     ChildGroupAccessQuery rightJoinGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Group relation
 * @method     ChildGroupAccessQuery innerJoinGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the Group relation
 *
 * @method     \ECP\EntityTypeQuery|\ECP\GroupQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGroupAccess findOne(ConnectionInterface $con = null) Return the first ChildGroupAccess matching the query
 * @method     ChildGroupAccess findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGroupAccess matching the query, or a new ChildGroupAccess object populated from the query conditions when no match is found
 *
 * @method     ChildGroupAccess findOneById(int $id) Return the first ChildGroupAccess filtered by the id column
 * @method     ChildGroupAccess findOneByEntitytypeid(int $entityTypeId) Return the first ChildGroupAccess filtered by the entityTypeId column
 * @method     ChildGroupAccess findOneByEntityid(int $entityId) Return the first ChildGroupAccess filtered by the entityId column
 * @method     ChildGroupAccess findOneByGroupid(int $groupId) Return the first ChildGroupAccess filtered by the groupId column *

 * @method     ChildGroupAccess requirePk($key, ConnectionInterface $con = null) Return the ChildGroupAccess by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroupAccess requireOne(ConnectionInterface $con = null) Return the first ChildGroupAccess matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGroupAccess requireOneById(int $id) Return the first ChildGroupAccess filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroupAccess requireOneByEntitytypeid(int $entityTypeId) Return the first ChildGroupAccess filtered by the entityTypeId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroupAccess requireOneByEntityid(int $entityId) Return the first ChildGroupAccess filtered by the entityId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroupAccess requireOneByGroupid(int $groupId) Return the first ChildGroupAccess filtered by the groupId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGroupAccess[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGroupAccess objects based on current ModelCriteria
 * @method     ChildGroupAccess[]|ObjectCollection findById(int $id) Return ChildGroupAccess objects filtered by the id column
 * @method     ChildGroupAccess[]|ObjectCollection findByEntitytypeid(int $entityTypeId) Return ChildGroupAccess objects filtered by the entityTypeId column
 * @method     ChildGroupAccess[]|ObjectCollection findByEntityid(int $entityId) Return ChildGroupAccess objects filtered by the entityId column
 * @method     ChildGroupAccess[]|ObjectCollection findByGroupid(int $groupId) Return ChildGroupAccess objects filtered by the groupId column
 * @method     ChildGroupAccess[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GroupAccessQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\GroupAccessQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\GroupAccess', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGroupAccessQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGroupAccessQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGroupAccessQuery) {
            return $criteria;
        }
        $query = new ChildGroupAccessQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildGroupAccess|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GroupAccessTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GroupAccessTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGroupAccess A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, entityTypeId, entityId, groupId FROM groupaccess WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildGroupAccess $obj */
            $obj = new ChildGroupAccess();
            $obj->hydrate($row);
            GroupAccessTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildGroupAccess|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildGroupAccessQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GroupAccessTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGroupAccessQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GroupAccessTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGroupAccessQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GroupAccessTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GroupAccessTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupAccessTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the entityTypeId column
     *
     * Example usage:
     * <code>
     * $query->filterByEntitytypeid(1234); // WHERE entityTypeId = 1234
     * $query->filterByEntitytypeid(array(12, 34)); // WHERE entityTypeId IN (12, 34)
     * $query->filterByEntitytypeid(array('min' => 12)); // WHERE entityTypeId > 12
     * </code>
     *
     * @see       filterByEntityType()
     *
     * @param     mixed $entitytypeid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGroupAccessQuery The current query, for fluid interface
     */
    public function filterByEntitytypeid($entitytypeid = null, $comparison = null)
    {
        if (is_array($entitytypeid)) {
            $useMinMax = false;
            if (isset($entitytypeid['min'])) {
                $this->addUsingAlias(GroupAccessTableMap::COL_ENTITYTYPEID, $entitytypeid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($entitytypeid['max'])) {
                $this->addUsingAlias(GroupAccessTableMap::COL_ENTITYTYPEID, $entitytypeid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupAccessTableMap::COL_ENTITYTYPEID, $entitytypeid, $comparison);
    }

    /**
     * Filter the query on the entityId column
     *
     * Example usage:
     * <code>
     * $query->filterByEntityid(1234); // WHERE entityId = 1234
     * $query->filterByEntityid(array(12, 34)); // WHERE entityId IN (12, 34)
     * $query->filterByEntityid(array('min' => 12)); // WHERE entityId > 12
     * </code>
     *
     * @param     mixed $entityid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGroupAccessQuery The current query, for fluid interface
     */
    public function filterByEntityid($entityid = null, $comparison = null)
    {
        if (is_array($entityid)) {
            $useMinMax = false;
            if (isset($entityid['min'])) {
                $this->addUsingAlias(GroupAccessTableMap::COL_ENTITYID, $entityid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($entityid['max'])) {
                $this->addUsingAlias(GroupAccessTableMap::COL_ENTITYID, $entityid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupAccessTableMap::COL_ENTITYID, $entityid, $comparison);
    }

    /**
     * Filter the query on the groupId column
     *
     * Example usage:
     * <code>
     * $query->filterByGroupid(1234); // WHERE groupId = 1234
     * $query->filterByGroupid(array(12, 34)); // WHERE groupId IN (12, 34)
     * $query->filterByGroupid(array('min' => 12)); // WHERE groupId > 12
     * </code>
     *
     * @see       filterByGroup()
     *
     * @param     mixed $groupid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGroupAccessQuery The current query, for fluid interface
     */
    public function filterByGroupid($groupid = null, $comparison = null)
    {
        if (is_array($groupid)) {
            $useMinMax = false;
            if (isset($groupid['min'])) {
                $this->addUsingAlias(GroupAccessTableMap::COL_GROUPID, $groupid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($groupid['max'])) {
                $this->addUsingAlias(GroupAccessTableMap::COL_GROUPID, $groupid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupAccessTableMap::COL_GROUPID, $groupid, $comparison);
    }

    /**
     * Filter the query by a related \ECP\EntityType object
     *
     * @param \ECP\EntityType|ObjectCollection $entityType The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGroupAccessQuery The current query, for fluid interface
     */
    public function filterByEntityType($entityType, $comparison = null)
    {
        if ($entityType instanceof \ECP\EntityType) {
            return $this
                ->addUsingAlias(GroupAccessTableMap::COL_ENTITYTYPEID, $entityType->getId(), $comparison);
        } elseif ($entityType instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GroupAccessTableMap::COL_ENTITYTYPEID, $entityType->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByEntityType() only accepts arguments of type \ECP\EntityType or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EntityType relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupAccessQuery The current query, for fluid interface
     */
    public function joinEntityType($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EntityType');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'EntityType');
        }

        return $this;
    }

    /**
     * Use the EntityType relation EntityType object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\EntityTypeQuery A secondary query class using the current class as primary query
     */
    public function useEntityTypeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEntityType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EntityType', '\ECP\EntityTypeQuery');
    }

    /**
     * Filter the query by a related \ECP\Group object
     *
     * @param \ECP\Group|ObjectCollection $group The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGroupAccessQuery The current query, for fluid interface
     */
    public function filterByGroup($group, $comparison = null)
    {
        if ($group instanceof \ECP\Group) {
            return $this
                ->addUsingAlias(GroupAccessTableMap::COL_GROUPID, $group->getId(), $comparison);
        } elseif ($group instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GroupAccessTableMap::COL_GROUPID, $group->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGroup() only accepts arguments of type \ECP\Group or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Group relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupAccessQuery The current query, for fluid interface
     */
    public function joinGroup($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Group');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Group');
        }

        return $this;
    }

    /**
     * Use the Group relation Group object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\GroupQuery A secondary query class using the current class as primary query
     */
    public function useGroupQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Group', '\ECP\GroupQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGroupAccess $groupAccess Object to remove from the list of results
     *
     * @return $this|ChildGroupAccessQuery The current query, for fluid interface
     */
    public function prune($groupAccess = null)
    {
        if ($groupAccess) {
            $this->addUsingAlias(GroupAccessTableMap::COL_ID, $groupAccess->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the groupaccess table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GroupAccessTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GroupAccessTableMap::clearInstancePool();
            GroupAccessTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GroupAccessTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GroupAccessTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            GroupAccessTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            GroupAccessTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GroupAccessQuery
