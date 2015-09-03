<?php

namespace EVE\Base;

use \Exception;
use \PDO;
use EVE\InvGroups as ChildInvGroups;
use EVE\InvGroupsQuery as ChildInvGroupsQuery;
use EVE\Map\InvGroupsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'invgroups' table.
 *
 * 
 *
 * @method     ChildInvGroupsQuery orderByGroupid($order = Criteria::ASC) Order by the groupID column
 * @method     ChildInvGroupsQuery orderByCategoryid($order = Criteria::ASC) Order by the categoryID column
 * @method     ChildInvGroupsQuery orderByGroupname($order = Criteria::ASC) Order by the groupName column
 * @method     ChildInvGroupsQuery orderByPublished($order = Criteria::ASC) Order by the published column
 *
 * @method     ChildInvGroupsQuery groupByGroupid() Group by the groupID column
 * @method     ChildInvGroupsQuery groupByCategoryid() Group by the categoryID column
 * @method     ChildInvGroupsQuery groupByGroupname() Group by the groupName column
 * @method     ChildInvGroupsQuery groupByPublished() Group by the published column
 *
 * @method     ChildInvGroupsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInvGroupsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInvGroupsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInvGroupsQuery leftJoinInvCategories($relationAlias = null) Adds a LEFT JOIN clause to the query using the InvCategories relation
 * @method     ChildInvGroupsQuery rightJoinInvCategories($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InvCategories relation
 * @method     ChildInvGroupsQuery innerJoinInvCategories($relationAlias = null) Adds a INNER JOIN clause to the query using the InvCategories relation
 *
 * @method     ChildInvGroupsQuery leftJoinInvTypes($relationAlias = null) Adds a LEFT JOIN clause to the query using the InvTypes relation
 * @method     ChildInvGroupsQuery rightJoinInvTypes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InvTypes relation
 * @method     ChildInvGroupsQuery innerJoinInvTypes($relationAlias = null) Adds a INNER JOIN clause to the query using the InvTypes relation
 *
 * @method     \EVE\InvCategoriesQuery|\EVE\InvTypesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInvGroups findOne(ConnectionInterface $con = null) Return the first ChildInvGroups matching the query
 * @method     ChildInvGroups findOneOrCreate(ConnectionInterface $con = null) Return the first ChildInvGroups matching the query, or a new ChildInvGroups object populated from the query conditions when no match is found
 *
 * @method     ChildInvGroups findOneByGroupid(int $groupID) Return the first ChildInvGroups filtered by the groupID column
 * @method     ChildInvGroups findOneByCategoryid(int $categoryID) Return the first ChildInvGroups filtered by the categoryID column
 * @method     ChildInvGroups findOneByGroupname(string $groupName) Return the first ChildInvGroups filtered by the groupName column
 * @method     ChildInvGroups findOneByPublished(int $published) Return the first ChildInvGroups filtered by the published column *

 * @method     ChildInvGroups requirePk($key, ConnectionInterface $con = null) Return the ChildInvGroups by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvGroups requireOne(ConnectionInterface $con = null) Return the first ChildInvGroups matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInvGroups requireOneByGroupid(int $groupID) Return the first ChildInvGroups filtered by the groupID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvGroups requireOneByCategoryid(int $categoryID) Return the first ChildInvGroups filtered by the categoryID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvGroups requireOneByGroupname(string $groupName) Return the first ChildInvGroups filtered by the groupName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvGroups requireOneByPublished(int $published) Return the first ChildInvGroups filtered by the published column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInvGroups[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildInvGroups objects based on current ModelCriteria
 * @method     ChildInvGroups[]|ObjectCollection findByGroupid(int $groupID) Return ChildInvGroups objects filtered by the groupID column
 * @method     ChildInvGroups[]|ObjectCollection findByCategoryid(int $categoryID) Return ChildInvGroups objects filtered by the categoryID column
 * @method     ChildInvGroups[]|ObjectCollection findByGroupname(string $groupName) Return ChildInvGroups objects filtered by the groupName column
 * @method     ChildInvGroups[]|ObjectCollection findByPublished(int $published) Return ChildInvGroups objects filtered by the published column
 * @method     ChildInvGroups[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class InvGroupsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \EVE\Base\InvGroupsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'eve', $modelName = '\\EVE\\InvGroups', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInvGroupsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInvGroupsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildInvGroupsQuery) {
            return $criteria;
        }
        $query = new ChildInvGroupsQuery();
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
     * @return ChildInvGroups|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = InvGroupsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InvGroupsTableMap::DATABASE_NAME);
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
     * @return ChildInvGroups A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT groupID, categoryID, groupName, published FROM invgroups WHERE groupID = :p0';
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
            /** @var ChildInvGroups $obj */
            $obj = new ChildInvGroups();
            $obj->hydrate($row);
            InvGroupsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildInvGroups|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildInvGroupsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(InvGroupsTableMap::COL_GROUPID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildInvGroupsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(InvGroupsTableMap::COL_GROUPID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the groupID column
     *
     * Example usage:
     * <code>
     * $query->filterByGroupid(1234); // WHERE groupID = 1234
     * $query->filterByGroupid(array(12, 34)); // WHERE groupID IN (12, 34)
     * $query->filterByGroupid(array('min' => 12)); // WHERE groupID > 12
     * </code>
     *
     * @param     mixed $groupid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvGroupsQuery The current query, for fluid interface
     */
    public function filterByGroupid($groupid = null, $comparison = null)
    {
        if (is_array($groupid)) {
            $useMinMax = false;
            if (isset($groupid['min'])) {
                $this->addUsingAlias(InvGroupsTableMap::COL_GROUPID, $groupid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($groupid['max'])) {
                $this->addUsingAlias(InvGroupsTableMap::COL_GROUPID, $groupid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InvGroupsTableMap::COL_GROUPID, $groupid, $comparison);
    }

    /**
     * Filter the query on the categoryID column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryid(1234); // WHERE categoryID = 1234
     * $query->filterByCategoryid(array(12, 34)); // WHERE categoryID IN (12, 34)
     * $query->filterByCategoryid(array('min' => 12)); // WHERE categoryID > 12
     * </code>
     *
     * @see       filterByInvCategories()
     *
     * @param     mixed $categoryid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvGroupsQuery The current query, for fluid interface
     */
    public function filterByCategoryid($categoryid = null, $comparison = null)
    {
        if (is_array($categoryid)) {
            $useMinMax = false;
            if (isset($categoryid['min'])) {
                $this->addUsingAlias(InvGroupsTableMap::COL_CATEGORYID, $categoryid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryid['max'])) {
                $this->addUsingAlias(InvGroupsTableMap::COL_CATEGORYID, $categoryid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InvGroupsTableMap::COL_CATEGORYID, $categoryid, $comparison);
    }

    /**
     * Filter the query on the groupName column
     *
     * Example usage:
     * <code>
     * $query->filterByGroupname('fooValue');   // WHERE groupName = 'fooValue'
     * $query->filterByGroupname('%fooValue%'); // WHERE groupName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $groupname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvGroupsQuery The current query, for fluid interface
     */
    public function filterByGroupname($groupname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($groupname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $groupname)) {
                $groupname = str_replace('*', '%', $groupname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(InvGroupsTableMap::COL_GROUPNAME, $groupname, $comparison);
    }

    /**
     * Filter the query on the published column
     *
     * Example usage:
     * <code>
     * $query->filterByPublished(1234); // WHERE published = 1234
     * $query->filterByPublished(array(12, 34)); // WHERE published IN (12, 34)
     * $query->filterByPublished(array('min' => 12)); // WHERE published > 12
     * </code>
     *
     * @param     mixed $published The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvGroupsQuery The current query, for fluid interface
     */
    public function filterByPublished($published = null, $comparison = null)
    {
        if (is_array($published)) {
            $useMinMax = false;
            if (isset($published['min'])) {
                $this->addUsingAlias(InvGroupsTableMap::COL_PUBLISHED, $published['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($published['max'])) {
                $this->addUsingAlias(InvGroupsTableMap::COL_PUBLISHED, $published['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InvGroupsTableMap::COL_PUBLISHED, $published, $comparison);
    }

    /**
     * Filter the query by a related \EVE\InvCategories object
     *
     * @param \EVE\InvCategories|ObjectCollection $invCategories The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInvGroupsQuery The current query, for fluid interface
     */
    public function filterByInvCategories($invCategories, $comparison = null)
    {
        if ($invCategories instanceof \EVE\InvCategories) {
            return $this
                ->addUsingAlias(InvGroupsTableMap::COL_CATEGORYID, $invCategories->getCategoryid(), $comparison);
        } elseif ($invCategories instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InvGroupsTableMap::COL_CATEGORYID, $invCategories->toKeyValue('PrimaryKey', 'Categoryid'), $comparison);
        } else {
            throw new PropelException('filterByInvCategories() only accepts arguments of type \EVE\InvCategories or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the InvCategories relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInvGroupsQuery The current query, for fluid interface
     */
    public function joinInvCategories($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('InvCategories');

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
            $this->addJoinObject($join, 'InvCategories');
        }

        return $this;
    }

    /**
     * Use the InvCategories relation InvCategories object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EVE\InvCategoriesQuery A secondary query class using the current class as primary query
     */
    public function useInvCategoriesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInvCategories($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'InvCategories', '\EVE\InvCategoriesQuery');
    }

    /**
     * Filter the query by a related \EVE\InvTypes object
     *
     * @param \EVE\InvTypes|ObjectCollection $invTypes the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInvGroupsQuery The current query, for fluid interface
     */
    public function filterByInvTypes($invTypes, $comparison = null)
    {
        if ($invTypes instanceof \EVE\InvTypes) {
            return $this
                ->addUsingAlias(InvGroupsTableMap::COL_GROUPID, $invTypes->getGroupid(), $comparison);
        } elseif ($invTypes instanceof ObjectCollection) {
            return $this
                ->useInvTypesQuery()
                ->filterByPrimaryKeys($invTypes->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByInvTypes() only accepts arguments of type \EVE\InvTypes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the InvTypes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInvGroupsQuery The current query, for fluid interface
     */
    public function joinInvTypes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('InvTypes');

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
            $this->addJoinObject($join, 'InvTypes');
        }

        return $this;
    }

    /**
     * Use the InvTypes relation InvTypes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EVE\InvTypesQuery A secondary query class using the current class as primary query
     */
    public function useInvTypesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInvTypes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'InvTypes', '\EVE\InvTypesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildInvGroups $invGroups Object to remove from the list of results
     *
     * @return $this|ChildInvGroupsQuery The current query, for fluid interface
     */
    public function prune($invGroups = null)
    {
        if ($invGroups) {
            $this->addUsingAlias(InvGroupsTableMap::COL_GROUPID, $invGroups->getGroupid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the invgroups table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InvGroupsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InvGroupsTableMap::clearInstancePool();
            InvGroupsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(InvGroupsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InvGroupsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            InvGroupsTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            InvGroupsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // InvGroupsQuery
