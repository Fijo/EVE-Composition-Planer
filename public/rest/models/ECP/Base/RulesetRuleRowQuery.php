<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\RulesetRuleRow as ChildRulesetRuleRow;
use ECP\RulesetRuleRowQuery as ChildRulesetRuleRowQuery;
use ECP\Map\RulesetRuleRowTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'rulesetrulerow' table.
 *
 * 
 *
 * @method     ChildRulesetRuleRowQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRulesetRuleRowQuery orderByRulesetentityid($order = Criteria::ASC) Order by the rulesetEntityId column
 * @method     ChildRulesetRuleRowQuery orderByInd3x($order = Criteria::ASC) Order by the ind3x column
 * @method     ChildRulesetRuleRowQuery orderByMessage($order = Criteria::ASC) Order by the message column
 *
 * @method     ChildRulesetRuleRowQuery groupById() Group by the id column
 * @method     ChildRulesetRuleRowQuery groupByRulesetentityid() Group by the rulesetEntityId column
 * @method     ChildRulesetRuleRowQuery groupByInd3x() Group by the ind3x column
 * @method     ChildRulesetRuleRowQuery groupByMessage() Group by the message column
 *
 * @method     ChildRulesetRuleRowQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRulesetRuleRowQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRulesetRuleRowQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRulesetRuleRowQuery leftJoinRulesetEntity($relationAlias = null) Adds a LEFT JOIN clause to the query using the RulesetEntity relation
 * @method     ChildRulesetRuleRowQuery rightJoinRulesetEntity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RulesetEntity relation
 * @method     ChildRulesetRuleRowQuery innerJoinRulesetEntity($relationAlias = null) Adds a INNER JOIN clause to the query using the RulesetEntity relation
 *
 * @method     ChildRulesetRuleRowQuery leftJoinRulesetFilterRule($relationAlias = null) Adds a LEFT JOIN clause to the query using the RulesetFilterRule relation
 * @method     ChildRulesetRuleRowQuery rightJoinRulesetFilterRule($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RulesetFilterRule relation
 * @method     ChildRulesetRuleRowQuery innerJoinRulesetFilterRule($relationAlias = null) Adds a INNER JOIN clause to the query using the RulesetFilterRule relation
 *
 * @method     \ECP\RulesetEntityQuery|\ECP\RulesetFilterRuleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRulesetRuleRow findOne(ConnectionInterface $con = null) Return the first ChildRulesetRuleRow matching the query
 * @method     ChildRulesetRuleRow findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRulesetRuleRow matching the query, or a new ChildRulesetRuleRow object populated from the query conditions when no match is found
 *
 * @method     ChildRulesetRuleRow findOneById(int $id) Return the first ChildRulesetRuleRow filtered by the id column
 * @method     ChildRulesetRuleRow findOneByRulesetentityid(int $rulesetEntityId) Return the first ChildRulesetRuleRow filtered by the rulesetEntityId column
 * @method     ChildRulesetRuleRow findOneByInd3x(int $ind3x) Return the first ChildRulesetRuleRow filtered by the ind3x column
 * @method     ChildRulesetRuleRow findOneByMessage(string $message) Return the first ChildRulesetRuleRow filtered by the message column *

 * @method     ChildRulesetRuleRow requirePk($key, ConnectionInterface $con = null) Return the ChildRulesetRuleRow by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetRuleRow requireOne(ConnectionInterface $con = null) Return the first ChildRulesetRuleRow matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRulesetRuleRow requireOneById(int $id) Return the first ChildRulesetRuleRow filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetRuleRow requireOneByRulesetentityid(int $rulesetEntityId) Return the first ChildRulesetRuleRow filtered by the rulesetEntityId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetRuleRow requireOneByInd3x(int $ind3x) Return the first ChildRulesetRuleRow filtered by the ind3x column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetRuleRow requireOneByMessage(string $message) Return the first ChildRulesetRuleRow filtered by the message column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRulesetRuleRow[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRulesetRuleRow objects based on current ModelCriteria
 * @method     ChildRulesetRuleRow[]|ObjectCollection findById(int $id) Return ChildRulesetRuleRow objects filtered by the id column
 * @method     ChildRulesetRuleRow[]|ObjectCollection findByRulesetentityid(int $rulesetEntityId) Return ChildRulesetRuleRow objects filtered by the rulesetEntityId column
 * @method     ChildRulesetRuleRow[]|ObjectCollection findByInd3x(int $ind3x) Return ChildRulesetRuleRow objects filtered by the ind3x column
 * @method     ChildRulesetRuleRow[]|ObjectCollection findByMessage(string $message) Return ChildRulesetRuleRow objects filtered by the message column
 * @method     ChildRulesetRuleRow[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RulesetRuleRowQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\RulesetRuleRowQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\RulesetRuleRow', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRulesetRuleRowQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRulesetRuleRowQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRulesetRuleRowQuery) {
            return $criteria;
        }
        $query = new ChildRulesetRuleRowQuery();
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
     * @return ChildRulesetRuleRow|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RulesetRuleRowTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RulesetRuleRowTableMap::DATABASE_NAME);
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
     * @return ChildRulesetRuleRow A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, rulesetEntityId, ind3x, message FROM rulesetrulerow WHERE id = :p0';
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
            /** @var ChildRulesetRuleRow $obj */
            $obj = new ChildRulesetRuleRow();
            $obj->hydrate($row);
            RulesetRuleRowTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRulesetRuleRow|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRulesetRuleRowQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RulesetRuleRowTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRulesetRuleRowQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RulesetRuleRowTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildRulesetRuleRowQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RulesetRuleRowTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RulesetRuleRowTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetRuleRowTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the rulesetEntityId column
     *
     * Example usage:
     * <code>
     * $query->filterByRulesetentityid(1234); // WHERE rulesetEntityId = 1234
     * $query->filterByRulesetentityid(array(12, 34)); // WHERE rulesetEntityId IN (12, 34)
     * $query->filterByRulesetentityid(array('min' => 12)); // WHERE rulesetEntityId > 12
     * </code>
     *
     * @see       filterByRulesetEntity()
     *
     * @param     mixed $rulesetentityid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetRuleRowQuery The current query, for fluid interface
     */
    public function filterByRulesetentityid($rulesetentityid = null, $comparison = null)
    {
        if (is_array($rulesetentityid)) {
            $useMinMax = false;
            if (isset($rulesetentityid['min'])) {
                $this->addUsingAlias(RulesetRuleRowTableMap::COL_RULESETENTITYID, $rulesetentityid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rulesetentityid['max'])) {
                $this->addUsingAlias(RulesetRuleRowTableMap::COL_RULESETENTITYID, $rulesetentityid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetRuleRowTableMap::COL_RULESETENTITYID, $rulesetentityid, $comparison);
    }

    /**
     * Filter the query on the ind3x column
     *
     * Example usage:
     * <code>
     * $query->filterByInd3x(1234); // WHERE ind3x = 1234
     * $query->filterByInd3x(array(12, 34)); // WHERE ind3x IN (12, 34)
     * $query->filterByInd3x(array('min' => 12)); // WHERE ind3x > 12
     * </code>
     *
     * @param     mixed $ind3x The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetRuleRowQuery The current query, for fluid interface
     */
    public function filterByInd3x($ind3x = null, $comparison = null)
    {
        if (is_array($ind3x)) {
            $useMinMax = false;
            if (isset($ind3x['min'])) {
                $this->addUsingAlias(RulesetRuleRowTableMap::COL_IND3X, $ind3x['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ind3x['max'])) {
                $this->addUsingAlias(RulesetRuleRowTableMap::COL_IND3X, $ind3x['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetRuleRowTableMap::COL_IND3X, $ind3x, $comparison);
    }

    /**
     * Filter the query on the message column
     *
     * Example usage:
     * <code>
     * $query->filterByMessage('fooValue');   // WHERE message = 'fooValue'
     * $query->filterByMessage('%fooValue%'); // WHERE message LIKE '%fooValue%'
     * </code>
     *
     * @param     string $message The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetRuleRowQuery The current query, for fluid interface
     */
    public function filterByMessage($message = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($message)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $message)) {
                $message = str_replace('*', '%', $message);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RulesetRuleRowTableMap::COL_MESSAGE, $message, $comparison);
    }

    /**
     * Filter the query by a related \ECP\RulesetEntity object
     *
     * @param \ECP\RulesetEntity|ObjectCollection $rulesetEntity The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRulesetRuleRowQuery The current query, for fluid interface
     */
    public function filterByRulesetEntity($rulesetEntity, $comparison = null)
    {
        if ($rulesetEntity instanceof \ECP\RulesetEntity) {
            return $this
                ->addUsingAlias(RulesetRuleRowTableMap::COL_RULESETENTITYID, $rulesetEntity->getId(), $comparison);
        } elseif ($rulesetEntity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RulesetRuleRowTableMap::COL_RULESETENTITYID, $rulesetEntity->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRulesetEntity() only accepts arguments of type \ECP\RulesetEntity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RulesetEntity relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRulesetRuleRowQuery The current query, for fluid interface
     */
    public function joinRulesetEntity($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RulesetEntity');

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
            $this->addJoinObject($join, 'RulesetEntity');
        }

        return $this;
    }

    /**
     * Use the RulesetEntity relation RulesetEntity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\RulesetEntityQuery A secondary query class using the current class as primary query
     */
    public function useRulesetEntityQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRulesetEntity($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RulesetEntity', '\ECP\RulesetEntityQuery');
    }

    /**
     * Filter the query by a related \ECP\RulesetFilterRule object
     *
     * @param \ECP\RulesetFilterRule|ObjectCollection $rulesetFilterRule the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRulesetRuleRowQuery The current query, for fluid interface
     */
    public function filterByRulesetFilterRule($rulesetFilterRule, $comparison = null)
    {
        if ($rulesetFilterRule instanceof \ECP\RulesetFilterRule) {
            return $this
                ->addUsingAlias(RulesetRuleRowTableMap::COL_ID, $rulesetFilterRule->getRulesetrulerowid(), $comparison);
        } elseif ($rulesetFilterRule instanceof ObjectCollection) {
            return $this
                ->useRulesetFilterRuleQuery()
                ->filterByPrimaryKeys($rulesetFilterRule->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRulesetFilterRule() only accepts arguments of type \ECP\RulesetFilterRule or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RulesetFilterRule relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRulesetRuleRowQuery The current query, for fluid interface
     */
    public function joinRulesetFilterRule($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RulesetFilterRule');

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
            $this->addJoinObject($join, 'RulesetFilterRule');
        }

        return $this;
    }

    /**
     * Use the RulesetFilterRule relation RulesetFilterRule object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\RulesetFilterRuleQuery A secondary query class using the current class as primary query
     */
    public function useRulesetFilterRuleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRulesetFilterRule($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RulesetFilterRule', '\ECP\RulesetFilterRuleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRulesetRuleRow $rulesetRuleRow Object to remove from the list of results
     *
     * @return $this|ChildRulesetRuleRowQuery The current query, for fluid interface
     */
    public function prune($rulesetRuleRow = null)
    {
        if ($rulesetRuleRow) {
            $this->addUsingAlias(RulesetRuleRowTableMap::COL_ID, $rulesetRuleRow->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the rulesetrulerow table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RulesetRuleRowTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RulesetRuleRowTableMap::clearInstancePool();
            RulesetRuleRowTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RulesetRuleRowTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RulesetRuleRowTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            RulesetRuleRowTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            RulesetRuleRowTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RulesetRuleRowQuery
