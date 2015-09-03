<?php

namespace EVE\Base;

use \Exception;
use \PDO;
use EVE\DgmTypeEffects as ChildDgmTypeEffects;
use EVE\DgmTypeEffectsQuery as ChildDgmTypeEffectsQuery;
use EVE\Map\DgmTypeEffectsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'dgmtypeeffects' table.
 *
 * 
 *
 * @method     ChildDgmTypeEffectsQuery orderByTypeid($order = Criteria::ASC) Order by the typeID column
 * @method     ChildDgmTypeEffectsQuery orderByEffectid($order = Criteria::ASC) Order by the effectID column
 *
 * @method     ChildDgmTypeEffectsQuery groupByTypeid() Group by the typeID column
 * @method     ChildDgmTypeEffectsQuery groupByEffectid() Group by the effectID column
 *
 * @method     ChildDgmTypeEffectsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDgmTypeEffectsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDgmTypeEffectsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDgmTypeEffectsQuery leftJoinInvTypes($relationAlias = null) Adds a LEFT JOIN clause to the query using the InvTypes relation
 * @method     ChildDgmTypeEffectsQuery rightJoinInvTypes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InvTypes relation
 * @method     ChildDgmTypeEffectsQuery innerJoinInvTypes($relationAlias = null) Adds a INNER JOIN clause to the query using the InvTypes relation
 *
 * @method     ChildDgmTypeEffectsQuery leftJoinDgmEffects($relationAlias = null) Adds a LEFT JOIN clause to the query using the DgmEffects relation
 * @method     ChildDgmTypeEffectsQuery rightJoinDgmEffects($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DgmEffects relation
 * @method     ChildDgmTypeEffectsQuery innerJoinDgmEffects($relationAlias = null) Adds a INNER JOIN clause to the query using the DgmEffects relation
 *
 * @method     \EVE\InvTypesQuery|\EVE\DgmEffectsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDgmTypeEffects findOne(ConnectionInterface $con = null) Return the first ChildDgmTypeEffects matching the query
 * @method     ChildDgmTypeEffects findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDgmTypeEffects matching the query, or a new ChildDgmTypeEffects object populated from the query conditions when no match is found
 *
 * @method     ChildDgmTypeEffects findOneByTypeid(int $typeID) Return the first ChildDgmTypeEffects filtered by the typeID column
 * @method     ChildDgmTypeEffects findOneByEffectid(int $effectID) Return the first ChildDgmTypeEffects filtered by the effectID column *

 * @method     ChildDgmTypeEffects requirePk($key, ConnectionInterface $con = null) Return the ChildDgmTypeEffects by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDgmTypeEffects requireOne(ConnectionInterface $con = null) Return the first ChildDgmTypeEffects matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDgmTypeEffects requireOneByTypeid(int $typeID) Return the first ChildDgmTypeEffects filtered by the typeID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDgmTypeEffects requireOneByEffectid(int $effectID) Return the first ChildDgmTypeEffects filtered by the effectID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDgmTypeEffects[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDgmTypeEffects objects based on current ModelCriteria
 * @method     ChildDgmTypeEffects[]|ObjectCollection findByTypeid(int $typeID) Return ChildDgmTypeEffects objects filtered by the typeID column
 * @method     ChildDgmTypeEffects[]|ObjectCollection findByEffectid(int $effectID) Return ChildDgmTypeEffects objects filtered by the effectID column
 * @method     ChildDgmTypeEffects[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DgmTypeEffectsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \EVE\Base\DgmTypeEffectsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'eve', $modelName = '\\EVE\\DgmTypeEffects', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDgmTypeEffectsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDgmTypeEffectsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDgmTypeEffectsQuery) {
            return $criteria;
        }
        $query = new ChildDgmTypeEffectsQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$typeID, $effectID] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildDgmTypeEffects|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DgmTypeEffectsTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DgmTypeEffectsTableMap::DATABASE_NAME);
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
     * @return ChildDgmTypeEffects A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT typeID, effectID FROM dgmtypeeffects WHERE typeID = :p0 AND effectID = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildDgmTypeEffects $obj */
            $obj = new ChildDgmTypeEffects();
            $obj->hydrate($row);
            DgmTypeEffectsTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildDgmTypeEffects|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildDgmTypeEffectsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(DgmTypeEffectsTableMap::COL_TYPEID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(DgmTypeEffectsTableMap::COL_EFFECTID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDgmTypeEffectsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(DgmTypeEffectsTableMap::COL_TYPEID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(DgmTypeEffectsTableMap::COL_EFFECTID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildDgmTypeEffectsQuery The current query, for fluid interface
     */
    public function filterByTypeid($typeid = null, $comparison = null)
    {
        if (is_array($typeid)) {
            $useMinMax = false;
            if (isset($typeid['min'])) {
                $this->addUsingAlias(DgmTypeEffectsTableMap::COL_TYPEID, $typeid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeid['max'])) {
                $this->addUsingAlias(DgmTypeEffectsTableMap::COL_TYPEID, $typeid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DgmTypeEffectsTableMap::COL_TYPEID, $typeid, $comparison);
    }

    /**
     * Filter the query on the effectID column
     *
     * Example usage:
     * <code>
     * $query->filterByEffectid(1234); // WHERE effectID = 1234
     * $query->filterByEffectid(array(12, 34)); // WHERE effectID IN (12, 34)
     * $query->filterByEffectid(array('min' => 12)); // WHERE effectID > 12
     * </code>
     *
     * @see       filterByDgmEffects()
     *
     * @param     mixed $effectid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDgmTypeEffectsQuery The current query, for fluid interface
     */
    public function filterByEffectid($effectid = null, $comparison = null)
    {
        if (is_array($effectid)) {
            $useMinMax = false;
            if (isset($effectid['min'])) {
                $this->addUsingAlias(DgmTypeEffectsTableMap::COL_EFFECTID, $effectid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($effectid['max'])) {
                $this->addUsingAlias(DgmTypeEffectsTableMap::COL_EFFECTID, $effectid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DgmTypeEffectsTableMap::COL_EFFECTID, $effectid, $comparison);
    }

    /**
     * Filter the query by a related \EVE\InvTypes object
     *
     * @param \EVE\InvTypes|ObjectCollection $invTypes The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDgmTypeEffectsQuery The current query, for fluid interface
     */
    public function filterByInvTypes($invTypes, $comparison = null)
    {
        if ($invTypes instanceof \EVE\InvTypes) {
            return $this
                ->addUsingAlias(DgmTypeEffectsTableMap::COL_TYPEID, $invTypes->getTypeid(), $comparison);
        } elseif ($invTypes instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DgmTypeEffectsTableMap::COL_TYPEID, $invTypes->toKeyValue('PrimaryKey', 'Typeid'), $comparison);
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
     * @return $this|ChildDgmTypeEffectsQuery The current query, for fluid interface
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
     * Filter the query by a related \EVE\DgmEffects object
     *
     * @param \EVE\DgmEffects|ObjectCollection $dgmEffects The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDgmTypeEffectsQuery The current query, for fluid interface
     */
    public function filterByDgmEffects($dgmEffects, $comparison = null)
    {
        if ($dgmEffects instanceof \EVE\DgmEffects) {
            return $this
                ->addUsingAlias(DgmTypeEffectsTableMap::COL_EFFECTID, $dgmEffects->getEffectid(), $comparison);
        } elseif ($dgmEffects instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DgmTypeEffectsTableMap::COL_EFFECTID, $dgmEffects->toKeyValue('PrimaryKey', 'Effectid'), $comparison);
        } else {
            throw new PropelException('filterByDgmEffects() only accepts arguments of type \EVE\DgmEffects or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DgmEffects relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDgmTypeEffectsQuery The current query, for fluid interface
     */
    public function joinDgmEffects($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DgmEffects');

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
            $this->addJoinObject($join, 'DgmEffects');
        }

        return $this;
    }

    /**
     * Use the DgmEffects relation DgmEffects object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EVE\DgmEffectsQuery A secondary query class using the current class as primary query
     */
    public function useDgmEffectsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDgmEffects($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DgmEffects', '\EVE\DgmEffectsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDgmTypeEffects $dgmTypeEffects Object to remove from the list of results
     *
     * @return $this|ChildDgmTypeEffectsQuery The current query, for fluid interface
     */
    public function prune($dgmTypeEffects = null)
    {
        if ($dgmTypeEffects) {
            $this->addCond('pruneCond0', $this->getAliasedColName(DgmTypeEffectsTableMap::COL_TYPEID), $dgmTypeEffects->getTypeid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(DgmTypeEffectsTableMap::COL_EFFECTID), $dgmTypeEffects->getEffectid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the dgmtypeeffects table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DgmTypeEffectsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DgmTypeEffectsTableMap::clearInstancePool();
            DgmTypeEffectsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DgmTypeEffectsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DgmTypeEffectsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            DgmTypeEffectsTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            DgmTypeEffectsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DgmTypeEffectsQuery
