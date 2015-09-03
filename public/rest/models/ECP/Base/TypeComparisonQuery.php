<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\TypeComparison as ChildTypeComparison;
use ECP\TypeComparisonQuery as ChildTypeComparisonQuery;
use ECP\Map\TypeComparisonTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'typecomparison' table.
 *
 * 
 *
 * @method     ChildTypeComparisonQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTypeComparisonQuery orderByTypeid($order = Criteria::ASC) Order by the typeId column
 * @method     ChildTypeComparisonQuery orderByComparisonid($order = Criteria::ASC) Order by the comparisonId column
 *
 * @method     ChildTypeComparisonQuery groupById() Group by the id column
 * @method     ChildTypeComparisonQuery groupByTypeid() Group by the typeId column
 * @method     ChildTypeComparisonQuery groupByComparisonid() Group by the comparisonId column
 *
 * @method     ChildTypeComparisonQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTypeComparisonQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTypeComparisonQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTypeComparisonQuery leftJoinType($relationAlias = null) Adds a LEFT JOIN clause to the query using the Type relation
 * @method     ChildTypeComparisonQuery rightJoinType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Type relation
 * @method     ChildTypeComparisonQuery innerJoinType($relationAlias = null) Adds a INNER JOIN clause to the query using the Type relation
 *
 * @method     ChildTypeComparisonQuery leftJoinComparison($relationAlias = null) Adds a LEFT JOIN clause to the query using the Comparison relation
 * @method     ChildTypeComparisonQuery rightJoinComparison($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Comparison relation
 * @method     ChildTypeComparisonQuery innerJoinComparison($relationAlias = null) Adds a INNER JOIN clause to the query using the Comparison relation
 *
 * @method     \ECP\TypeQuery|\ECP\ComparisonQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTypeComparison findOne(ConnectionInterface $con = null) Return the first ChildTypeComparison matching the query
 * @method     ChildTypeComparison findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTypeComparison matching the query, or a new ChildTypeComparison object populated from the query conditions when no match is found
 *
 * @method     ChildTypeComparison findOneById(int $id) Return the first ChildTypeComparison filtered by the id column
 * @method     ChildTypeComparison findOneByTypeid(int $typeId) Return the first ChildTypeComparison filtered by the typeId column
 * @method     ChildTypeComparison findOneByComparisonid(int $comparisonId) Return the first ChildTypeComparison filtered by the comparisonId column *

 * @method     ChildTypeComparison requirePk($key, ConnectionInterface $con = null) Return the ChildTypeComparison by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTypeComparison requireOne(ConnectionInterface $con = null) Return the first ChildTypeComparison matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTypeComparison requireOneById(int $id) Return the first ChildTypeComparison filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTypeComparison requireOneByTypeid(int $typeId) Return the first ChildTypeComparison filtered by the typeId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTypeComparison requireOneByComparisonid(int $comparisonId) Return the first ChildTypeComparison filtered by the comparisonId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTypeComparison[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTypeComparison objects based on current ModelCriteria
 * @method     ChildTypeComparison[]|ObjectCollection findById(int $id) Return ChildTypeComparison objects filtered by the id column
 * @method     ChildTypeComparison[]|ObjectCollection findByTypeid(int $typeId) Return ChildTypeComparison objects filtered by the typeId column
 * @method     ChildTypeComparison[]|ObjectCollection findByComparisonid(int $comparisonId) Return ChildTypeComparison objects filtered by the comparisonId column
 * @method     ChildTypeComparison[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TypeComparisonQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\TypeComparisonQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\TypeComparison', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTypeComparisonQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTypeComparisonQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTypeComparisonQuery) {
            return $criteria;
        }
        $query = new ChildTypeComparisonQuery();
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
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array[$id, $typeId, $comparisonId] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildTypeComparison|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TypeComparisonTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1], (string) $key[2]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TypeComparisonTableMap::DATABASE_NAME);
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
     * @return ChildTypeComparison A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, typeId, comparisonId FROM typecomparison WHERE id = :p0 AND typeId = :p1 AND comparisonId = :p2';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);            
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildTypeComparison $obj */
            $obj = new ChildTypeComparison();
            $obj->hydrate($row);
            TypeComparisonTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1], (string) $key[2])));
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
     * @return ChildTypeComparison|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTypeComparisonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(TypeComparisonTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(TypeComparisonTableMap::COL_TYPEID, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(TypeComparisonTableMap::COL_COMPARISONID, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTypeComparisonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(TypeComparisonTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(TypeComparisonTableMap::COL_TYPEID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(TypeComparisonTableMap::COL_COMPARISONID, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildTypeComparisonQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TypeComparisonTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TypeComparisonTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeComparisonTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the typeId column
     *
     * Example usage:
     * <code>
     * $query->filterByTypeid(1234); // WHERE typeId = 1234
     * $query->filterByTypeid(array(12, 34)); // WHERE typeId IN (12, 34)
     * $query->filterByTypeid(array('min' => 12)); // WHERE typeId > 12
     * </code>
     *
     * @see       filterByType()
     *
     * @param     mixed $typeid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTypeComparisonQuery The current query, for fluid interface
     */
    public function filterByTypeid($typeid = null, $comparison = null)
    {
        if (is_array($typeid)) {
            $useMinMax = false;
            if (isset($typeid['min'])) {
                $this->addUsingAlias(TypeComparisonTableMap::COL_TYPEID, $typeid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeid['max'])) {
                $this->addUsingAlias(TypeComparisonTableMap::COL_TYPEID, $typeid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeComparisonTableMap::COL_TYPEID, $typeid, $comparison);
    }

    /**
     * Filter the query on the comparisonId column
     *
     * Example usage:
     * <code>
     * $query->filterByComparisonid(1234); // WHERE comparisonId = 1234
     * $query->filterByComparisonid(array(12, 34)); // WHERE comparisonId IN (12, 34)
     * $query->filterByComparisonid(array('min' => 12)); // WHERE comparisonId > 12
     * </code>
     *
     * @see       filterByComparison()
     *
     * @param     mixed $comparisonid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTypeComparisonQuery The current query, for fluid interface
     */
    public function filterByComparisonid($comparisonid = null, $comparison = null)
    {
        if (is_array($comparisonid)) {
            $useMinMax = false;
            if (isset($comparisonid['min'])) {
                $this->addUsingAlias(TypeComparisonTableMap::COL_COMPARISONID, $comparisonid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($comparisonid['max'])) {
                $this->addUsingAlias(TypeComparisonTableMap::COL_COMPARISONID, $comparisonid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeComparisonTableMap::COL_COMPARISONID, $comparisonid, $comparison);
    }

    /**
     * Filter the query by a related \ECP\Type object
     *
     * @param \ECP\Type|ObjectCollection $type The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTypeComparisonQuery The current query, for fluid interface
     */
    public function filterByType($type, $comparison = null)
    {
        if ($type instanceof \ECP\Type) {
            return $this
                ->addUsingAlias(TypeComparisonTableMap::COL_TYPEID, $type->getId(), $comparison);
        } elseif ($type instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TypeComparisonTableMap::COL_TYPEID, $type->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByType() only accepts arguments of type \ECP\Type or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Type relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTypeComparisonQuery The current query, for fluid interface
     */
    public function joinType($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Type');

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
            $this->addJoinObject($join, 'Type');
        }

        return $this;
    }

    /**
     * Use the Type relation Type object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\TypeQuery A secondary query class using the current class as primary query
     */
    public function useTypeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Type', '\ECP\TypeQuery');
    }

    /**
     * Filter the query by a related \ECP\Comparison object
     *
     * @param \ECP\Comparison|ObjectCollection $comparison The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTypeComparisonQuery The current query, for fluid interface
     */
    public function filterByComparison($comparison, $comparison = null)
    {
        if ($comparison instanceof \ECP\Comparison) {
            return $this
                ->addUsingAlias(TypeComparisonTableMap::COL_COMPARISONID, $comparison->getId(), $comparison);
        } elseif ($comparison instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TypeComparisonTableMap::COL_COMPARISONID, $comparison->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByComparison() only accepts arguments of type \ECP\Comparison or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Comparison relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTypeComparisonQuery The current query, for fluid interface
     */
    public function joinComparison($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Comparison');

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
            $this->addJoinObject($join, 'Comparison');
        }

        return $this;
    }

    /**
     * Use the Comparison relation Comparison object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\ComparisonQuery A secondary query class using the current class as primary query
     */
    public function useComparisonQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinComparison($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Comparison', '\ECP\ComparisonQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTypeComparison $typeComparison Object to remove from the list of results
     *
     * @return $this|ChildTypeComparisonQuery The current query, for fluid interface
     */
    public function prune($typeComparison = null)
    {
        if ($typeComparison) {
            $this->addCond('pruneCond0', $this->getAliasedColName(TypeComparisonTableMap::COL_ID), $typeComparison->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(TypeComparisonTableMap::COL_TYPEID), $typeComparison->getTypeid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(TypeComparisonTableMap::COL_COMPARISONID), $typeComparison->getComparisonid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the typecomparison table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TypeComparisonTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TypeComparisonTableMap::clearInstancePool();
            TypeComparisonTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TypeComparisonTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TypeComparisonTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            TypeComparisonTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            TypeComparisonTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TypeComparisonQuery
