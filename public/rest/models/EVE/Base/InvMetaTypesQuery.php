<?php

namespace EVE\Base;

use \Exception;
use \PDO;
use EVE\InvMetaTypes as ChildInvMetaTypes;
use EVE\InvMetaTypesQuery as ChildInvMetaTypesQuery;
use EVE\Map\InvMetaTypesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'invmetatypes' table.
 *
 * 
 *
 * @method     ChildInvMetaTypesQuery orderByTypeid($order = Criteria::ASC) Order by the typeID column
 * @method     ChildInvMetaTypesQuery orderByParenttypeid($order = Criteria::ASC) Order by the parentTypeID column
 * @method     ChildInvMetaTypesQuery orderByMetagroupid($order = Criteria::ASC) Order by the metaGroupID column
 *
 * @method     ChildInvMetaTypesQuery groupByTypeid() Group by the typeID column
 * @method     ChildInvMetaTypesQuery groupByParenttypeid() Group by the parentTypeID column
 * @method     ChildInvMetaTypesQuery groupByMetagroupid() Group by the metaGroupID column
 *
 * @method     ChildInvMetaTypesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInvMetaTypesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInvMetaTypesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInvMetaTypesQuery leftJoinInvTypes($relationAlias = null) Adds a LEFT JOIN clause to the query using the InvTypes relation
 * @method     ChildInvMetaTypesQuery rightJoinInvTypes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InvTypes relation
 * @method     ChildInvMetaTypesQuery innerJoinInvTypes($relationAlias = null) Adds a INNER JOIN clause to the query using the InvTypes relation
 *
 * @method     ChildInvMetaTypesQuery leftJoinInvMetaGroups($relationAlias = null) Adds a LEFT JOIN clause to the query using the InvMetaGroups relation
 * @method     ChildInvMetaTypesQuery rightJoinInvMetaGroups($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InvMetaGroups relation
 * @method     ChildInvMetaTypesQuery innerJoinInvMetaGroups($relationAlias = null) Adds a INNER JOIN clause to the query using the InvMetaGroups relation
 *
 * @method     \EVE\InvTypesQuery|\EVE\InvMetaGroupsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInvMetaTypes findOne(ConnectionInterface $con = null) Return the first ChildInvMetaTypes matching the query
 * @method     ChildInvMetaTypes findOneOrCreate(ConnectionInterface $con = null) Return the first ChildInvMetaTypes matching the query, or a new ChildInvMetaTypes object populated from the query conditions when no match is found
 *
 * @method     ChildInvMetaTypes findOneByTypeid(int $typeID) Return the first ChildInvMetaTypes filtered by the typeID column
 * @method     ChildInvMetaTypes findOneByParenttypeid(int $parentTypeID) Return the first ChildInvMetaTypes filtered by the parentTypeID column
 * @method     ChildInvMetaTypes findOneByMetagroupid(int $metaGroupID) Return the first ChildInvMetaTypes filtered by the metaGroupID column *

 * @method     ChildInvMetaTypes requirePk($key, ConnectionInterface $con = null) Return the ChildInvMetaTypes by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvMetaTypes requireOne(ConnectionInterface $con = null) Return the first ChildInvMetaTypes matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInvMetaTypes requireOneByTypeid(int $typeID) Return the first ChildInvMetaTypes filtered by the typeID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvMetaTypes requireOneByParenttypeid(int $parentTypeID) Return the first ChildInvMetaTypes filtered by the parentTypeID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvMetaTypes requireOneByMetagroupid(int $metaGroupID) Return the first ChildInvMetaTypes filtered by the metaGroupID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInvMetaTypes[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildInvMetaTypes objects based on current ModelCriteria
 * @method     ChildInvMetaTypes[]|ObjectCollection findByTypeid(int $typeID) Return ChildInvMetaTypes objects filtered by the typeID column
 * @method     ChildInvMetaTypes[]|ObjectCollection findByParenttypeid(int $parentTypeID) Return ChildInvMetaTypes objects filtered by the parentTypeID column
 * @method     ChildInvMetaTypes[]|ObjectCollection findByMetagroupid(int $metaGroupID) Return ChildInvMetaTypes objects filtered by the metaGroupID column
 * @method     ChildInvMetaTypes[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class InvMetaTypesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \EVE\Base\InvMetaTypesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'eve', $modelName = '\\EVE\\InvMetaTypes', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInvMetaTypesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInvMetaTypesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildInvMetaTypesQuery) {
            return $criteria;
        }
        $query = new ChildInvMetaTypesQuery();
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
     * @return ChildInvMetaTypes|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = InvMetaTypesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InvMetaTypesTableMap::DATABASE_NAME);
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
     * @return ChildInvMetaTypes A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT typeID, parentTypeID, metaGroupID FROM invmetatypes WHERE typeID = :p0';
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
            /** @var ChildInvMetaTypes $obj */
            $obj = new ChildInvMetaTypes();
            $obj->hydrate($row);
            InvMetaTypesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildInvMetaTypes|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildInvMetaTypesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(InvMetaTypesTableMap::COL_TYPEID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildInvMetaTypesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(InvMetaTypesTableMap::COL_TYPEID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the typeID column
     *
     * Example usage:
     * <code>
     * $query->filterByTypeid(1234); // WHERE typeID = 1234
     * $query->filterByTypeid(array(12, 34)); // WHERE typeID IN (12, 34)
     * $query->filterByTypeid(array('min' => 12)); // WHERE typeID > 12
     * </code>
     *
     * @see       filterByInvTypes()
     *
     * @param     mixed $typeid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvMetaTypesQuery The current query, for fluid interface
     */
    public function filterByTypeid($typeid = null, $comparison = null)
    {
        if (is_array($typeid)) {
            $useMinMax = false;
            if (isset($typeid['min'])) {
                $this->addUsingAlias(InvMetaTypesTableMap::COL_TYPEID, $typeid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeid['max'])) {
                $this->addUsingAlias(InvMetaTypesTableMap::COL_TYPEID, $typeid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InvMetaTypesTableMap::COL_TYPEID, $typeid, $comparison);
    }

    /**
     * Filter the query on the parentTypeID column
     *
     * Example usage:
     * <code>
     * $query->filterByParenttypeid(1234); // WHERE parentTypeID = 1234
     * $query->filterByParenttypeid(array(12, 34)); // WHERE parentTypeID IN (12, 34)
     * $query->filterByParenttypeid(array('min' => 12)); // WHERE parentTypeID > 12
     * </code>
     *
     * @param     mixed $parenttypeid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvMetaTypesQuery The current query, for fluid interface
     */
    public function filterByParenttypeid($parenttypeid = null, $comparison = null)
    {
        if (is_array($parenttypeid)) {
            $useMinMax = false;
            if (isset($parenttypeid['min'])) {
                $this->addUsingAlias(InvMetaTypesTableMap::COL_PARENTTYPEID, $parenttypeid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parenttypeid['max'])) {
                $this->addUsingAlias(InvMetaTypesTableMap::COL_PARENTTYPEID, $parenttypeid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InvMetaTypesTableMap::COL_PARENTTYPEID, $parenttypeid, $comparison);
    }

    /**
     * Filter the query on the metaGroupID column
     *
     * Example usage:
     * <code>
     * $query->filterByMetagroupid(1234); // WHERE metaGroupID = 1234
     * $query->filterByMetagroupid(array(12, 34)); // WHERE metaGroupID IN (12, 34)
     * $query->filterByMetagroupid(array('min' => 12)); // WHERE metaGroupID > 12
     * </code>
     *
     * @see       filterByInvMetaGroups()
     *
     * @param     mixed $metagroupid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvMetaTypesQuery The current query, for fluid interface
     */
    public function filterByMetagroupid($metagroupid = null, $comparison = null)
    {
        if (is_array($metagroupid)) {
            $useMinMax = false;
            if (isset($metagroupid['min'])) {
                $this->addUsingAlias(InvMetaTypesTableMap::COL_METAGROUPID, $metagroupid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($metagroupid['max'])) {
                $this->addUsingAlias(InvMetaTypesTableMap::COL_METAGROUPID, $metagroupid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InvMetaTypesTableMap::COL_METAGROUPID, $metagroupid, $comparison);
    }

    /**
     * Filter the query by a related \EVE\InvTypes object
     *
     * @param \EVE\InvTypes|ObjectCollection $invTypes The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInvMetaTypesQuery The current query, for fluid interface
     */
    public function filterByInvTypes($invTypes, $comparison = null)
    {
        if ($invTypes instanceof \EVE\InvTypes) {
            return $this
                ->addUsingAlias(InvMetaTypesTableMap::COL_TYPEID, $invTypes->getTypeid(), $comparison);
        } elseif ($invTypes instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InvMetaTypesTableMap::COL_TYPEID, $invTypes->toKeyValue('PrimaryKey', 'Typeid'), $comparison);
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
     * @return $this|ChildInvMetaTypesQuery The current query, for fluid interface
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
     * Filter the query by a related \EVE\InvMetaGroups object
     *
     * @param \EVE\InvMetaGroups|ObjectCollection $invMetaGroups The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInvMetaTypesQuery The current query, for fluid interface
     */
    public function filterByInvMetaGroups($invMetaGroups, $comparison = null)
    {
        if ($invMetaGroups instanceof \EVE\InvMetaGroups) {
            return $this
                ->addUsingAlias(InvMetaTypesTableMap::COL_METAGROUPID, $invMetaGroups->getMetagroupid(), $comparison);
        } elseif ($invMetaGroups instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InvMetaTypesTableMap::COL_METAGROUPID, $invMetaGroups->toKeyValue('PrimaryKey', 'Metagroupid'), $comparison);
        } else {
            throw new PropelException('filterByInvMetaGroups() only accepts arguments of type \EVE\InvMetaGroups or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the InvMetaGroups relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInvMetaTypesQuery The current query, for fluid interface
     */
    public function joinInvMetaGroups($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('InvMetaGroups');

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
            $this->addJoinObject($join, 'InvMetaGroups');
        }

        return $this;
    }

    /**
     * Use the InvMetaGroups relation InvMetaGroups object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EVE\InvMetaGroupsQuery A secondary query class using the current class as primary query
     */
    public function useInvMetaGroupsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInvMetaGroups($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'InvMetaGroups', '\EVE\InvMetaGroupsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildInvMetaTypes $invMetaTypes Object to remove from the list of results
     *
     * @return $this|ChildInvMetaTypesQuery The current query, for fluid interface
     */
    public function prune($invMetaTypes = null)
    {
        if ($invMetaTypes) {
            $this->addUsingAlias(InvMetaTypesTableMap::COL_TYPEID, $invMetaTypes->getTypeid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the invmetatypes table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InvMetaTypesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InvMetaTypesTableMap::clearInstancePool();
            InvMetaTypesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(InvMetaTypesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InvMetaTypesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            InvMetaTypesTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            InvMetaTypesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // InvMetaTypesQuery
