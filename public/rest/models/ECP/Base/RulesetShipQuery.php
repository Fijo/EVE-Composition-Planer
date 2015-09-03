<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\RulesetShip as ChildRulesetShip;
use ECP\RulesetShipQuery as ChildRulesetShipQuery;
use ECP\Map\RulesetShipTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'rulesetship' table.
 *
 * 
 *
 * @method     ChildRulesetShipQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRulesetShipQuery orderByRulesetentityid($order = Criteria::ASC) Order by the rulesetEntityId column
 * @method     ChildRulesetShipQuery orderByShipid($order = Criteria::ASC) Order by the shipId column
 * @method     ChildRulesetShipQuery orderByPoints($order = Criteria::ASC) Order by the points column
 *
 * @method     ChildRulesetShipQuery groupById() Group by the id column
 * @method     ChildRulesetShipQuery groupByRulesetentityid() Group by the rulesetEntityId column
 * @method     ChildRulesetShipQuery groupByShipid() Group by the shipId column
 * @method     ChildRulesetShipQuery groupByPoints() Group by the points column
 *
 * @method     ChildRulesetShipQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRulesetShipQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRulesetShipQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRulesetShipQuery leftJoinRulesetEntity($relationAlias = null) Adds a LEFT JOIN clause to the query using the RulesetEntity relation
 * @method     ChildRulesetShipQuery rightJoinRulesetEntity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RulesetEntity relation
 * @method     ChildRulesetShipQuery innerJoinRulesetEntity($relationAlias = null) Adds a INNER JOIN clause to the query using the RulesetEntity relation
 *
 * @method     \ECP\RulesetEntityQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRulesetShip findOne(ConnectionInterface $con = null) Return the first ChildRulesetShip matching the query
 * @method     ChildRulesetShip findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRulesetShip matching the query, or a new ChildRulesetShip object populated from the query conditions when no match is found
 *
 * @method     ChildRulesetShip findOneById(int $id) Return the first ChildRulesetShip filtered by the id column
 * @method     ChildRulesetShip findOneByRulesetentityid(int $rulesetEntityId) Return the first ChildRulesetShip filtered by the rulesetEntityId column
 * @method     ChildRulesetShip findOneByShipid(int $shipId) Return the first ChildRulesetShip filtered by the shipId column
 * @method     ChildRulesetShip findOneByPoints(int $points) Return the first ChildRulesetShip filtered by the points column *

 * @method     ChildRulesetShip requirePk($key, ConnectionInterface $con = null) Return the ChildRulesetShip by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetShip requireOne(ConnectionInterface $con = null) Return the first ChildRulesetShip matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRulesetShip requireOneById(int $id) Return the first ChildRulesetShip filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetShip requireOneByRulesetentityid(int $rulesetEntityId) Return the first ChildRulesetShip filtered by the rulesetEntityId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetShip requireOneByShipid(int $shipId) Return the first ChildRulesetShip filtered by the shipId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetShip requireOneByPoints(int $points) Return the first ChildRulesetShip filtered by the points column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRulesetShip[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRulesetShip objects based on current ModelCriteria
 * @method     ChildRulesetShip[]|ObjectCollection findById(int $id) Return ChildRulesetShip objects filtered by the id column
 * @method     ChildRulesetShip[]|ObjectCollection findByRulesetentityid(int $rulesetEntityId) Return ChildRulesetShip objects filtered by the rulesetEntityId column
 * @method     ChildRulesetShip[]|ObjectCollection findByShipid(int $shipId) Return ChildRulesetShip objects filtered by the shipId column
 * @method     ChildRulesetShip[]|ObjectCollection findByPoints(int $points) Return ChildRulesetShip objects filtered by the points column
 * @method     ChildRulesetShip[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RulesetShipQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\RulesetShipQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\RulesetShip', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRulesetShipQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRulesetShipQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRulesetShipQuery) {
            return $criteria;
        }
        $query = new ChildRulesetShipQuery();
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
     * @return ChildRulesetShip|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RulesetShipTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RulesetShipTableMap::DATABASE_NAME);
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
     * @return ChildRulesetShip A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, rulesetEntityId, shipId, points FROM rulesetship WHERE id = :p0';
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
            /** @var ChildRulesetShip $obj */
            $obj = new ChildRulesetShip();
            $obj->hydrate($row);
            RulesetShipTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRulesetShip|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRulesetShipQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RulesetShipTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRulesetShipQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RulesetShipTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildRulesetShipQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RulesetShipTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RulesetShipTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetShipTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildRulesetShipQuery The current query, for fluid interface
     */
    public function filterByRulesetentityid($rulesetentityid = null, $comparison = null)
    {
        if (is_array($rulesetentityid)) {
            $useMinMax = false;
            if (isset($rulesetentityid['min'])) {
                $this->addUsingAlias(RulesetShipTableMap::COL_RULESETENTITYID, $rulesetentityid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rulesetentityid['max'])) {
                $this->addUsingAlias(RulesetShipTableMap::COL_RULESETENTITYID, $rulesetentityid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetShipTableMap::COL_RULESETENTITYID, $rulesetentityid, $comparison);
    }

    /**
     * Filter the query on the shipId column
     *
     * Example usage:
     * <code>
     * $query->filterByShipid(1234); // WHERE shipId = 1234
     * $query->filterByShipid(array(12, 34)); // WHERE shipId IN (12, 34)
     * $query->filterByShipid(array('min' => 12)); // WHERE shipId > 12
     * </code>
     *
     * @param     mixed $shipid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetShipQuery The current query, for fluid interface
     */
    public function filterByShipid($shipid = null, $comparison = null)
    {
        if (is_array($shipid)) {
            $useMinMax = false;
            if (isset($shipid['min'])) {
                $this->addUsingAlias(RulesetShipTableMap::COL_SHIPID, $shipid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shipid['max'])) {
                $this->addUsingAlias(RulesetShipTableMap::COL_SHIPID, $shipid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetShipTableMap::COL_SHIPID, $shipid, $comparison);
    }

    /**
     * Filter the query on the points column
     *
     * Example usage:
     * <code>
     * $query->filterByPoints(1234); // WHERE points = 1234
     * $query->filterByPoints(array(12, 34)); // WHERE points IN (12, 34)
     * $query->filterByPoints(array('min' => 12)); // WHERE points > 12
     * </code>
     *
     * @param     mixed $points The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetShipQuery The current query, for fluid interface
     */
    public function filterByPoints($points = null, $comparison = null)
    {
        if (is_array($points)) {
            $useMinMax = false;
            if (isset($points['min'])) {
                $this->addUsingAlias(RulesetShipTableMap::COL_POINTS, $points['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($points['max'])) {
                $this->addUsingAlias(RulesetShipTableMap::COL_POINTS, $points['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetShipTableMap::COL_POINTS, $points, $comparison);
    }

    /**
     * Filter the query by a related \ECP\RulesetEntity object
     *
     * @param \ECP\RulesetEntity|ObjectCollection $rulesetEntity The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRulesetShipQuery The current query, for fluid interface
     */
    public function filterByRulesetEntity($rulesetEntity, $comparison = null)
    {
        if ($rulesetEntity instanceof \ECP\RulesetEntity) {
            return $this
                ->addUsingAlias(RulesetShipTableMap::COL_RULESETENTITYID, $rulesetEntity->getId(), $comparison);
        } elseif ($rulesetEntity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RulesetShipTableMap::COL_RULESETENTITYID, $rulesetEntity->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildRulesetShipQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildRulesetShip $rulesetShip Object to remove from the list of results
     *
     * @return $this|ChildRulesetShipQuery The current query, for fluid interface
     */
    public function prune($rulesetShip = null)
    {
        if ($rulesetShip) {
            $this->addUsingAlias(RulesetShipTableMap::COL_ID, $rulesetShip->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the rulesetship table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RulesetShipTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RulesetShipTableMap::clearInstancePool();
            RulesetShipTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RulesetShipTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RulesetShipTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            RulesetShipTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            RulesetShipTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RulesetShipQuery
