<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\Type as ChildType;
use ECP\TypeQuery as ChildTypeQuery;
use ECP\Map\TypeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'type' table.
 *
 * 
 *
 * @method     ChildTypeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTypeQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildTypeQuery groupById() Group by the id column
 * @method     ChildTypeQuery groupByName() Group by the name column
 *
 * @method     ChildTypeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTypeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTypeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTypeQuery leftJoinTypeComparison($relationAlias = null) Adds a LEFT JOIN clause to the query using the TypeComparison relation
 * @method     ChildTypeQuery rightJoinTypeComparison($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TypeComparison relation
 * @method     ChildTypeQuery innerJoinTypeComparison($relationAlias = null) Adds a INNER JOIN clause to the query using the TypeComparison relation
 *
 * @method     ChildTypeQuery leftJoinItemFilterDef($relationAlias = null) Adds a LEFT JOIN clause to the query using the ItemFilterDef relation
 * @method     ChildTypeQuery rightJoinItemFilterDef($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ItemFilterDef relation
 * @method     ChildTypeQuery innerJoinItemFilterDef($relationAlias = null) Adds a INNER JOIN clause to the query using the ItemFilterDef relation
 *
 * @method     \ECP\TypeComparisonQuery|\ECP\ItemFilterDefQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildType findOne(ConnectionInterface $con = null) Return the first ChildType matching the query
 * @method     ChildType findOneOrCreate(ConnectionInterface $con = null) Return the first ChildType matching the query, or a new ChildType object populated from the query conditions when no match is found
 *
 * @method     ChildType findOneById(int $id) Return the first ChildType filtered by the id column
 * @method     ChildType findOneByName(string $name) Return the first ChildType filtered by the name column *

 * @method     ChildType requirePk($key, ConnectionInterface $con = null) Return the ChildType by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildType requireOne(ConnectionInterface $con = null) Return the first ChildType matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildType requireOneById(int $id) Return the first ChildType filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildType requireOneByName(string $name) Return the first ChildType filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildType[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildType objects based on current ModelCriteria
 * @method     ChildType[]|ObjectCollection findById(int $id) Return ChildType objects filtered by the id column
 * @method     ChildType[]|ObjectCollection findByName(string $name) Return ChildType objects filtered by the name column
 * @method     ChildType[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TypeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\TypeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\Type', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTypeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTypeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTypeQuery) {
            return $criteria;
        }
        $query = new ChildTypeQuery();
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
     * @return ChildType|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TypeTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TypeTableMap::DATABASE_NAME);
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
     * @return ChildType A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name FROM type WHERE id = :p0';
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
            /** @var ChildType $obj */
            $obj = new ChildType();
            $obj->hydrate($row);
            TypeTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildType|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TypeTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TypeTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TypeTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TypeTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TypeTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related \ECP\TypeComparison object
     *
     * @param \ECP\TypeComparison|ObjectCollection $typeComparison the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTypeQuery The current query, for fluid interface
     */
    public function filterByTypeComparison($typeComparison, $comparison = null)
    {
        if ($typeComparison instanceof \ECP\TypeComparison) {
            return $this
                ->addUsingAlias(TypeTableMap::COL_ID, $typeComparison->getTypeid(), $comparison);
        } elseif ($typeComparison instanceof ObjectCollection) {
            return $this
                ->useTypeComparisonQuery()
                ->filterByPrimaryKeys($typeComparison->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTypeComparison() only accepts arguments of type \ECP\TypeComparison or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TypeComparison relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function joinTypeComparison($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TypeComparison');

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
            $this->addJoinObject($join, 'TypeComparison');
        }

        return $this;
    }

    /**
     * Use the TypeComparison relation TypeComparison object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\TypeComparisonQuery A secondary query class using the current class as primary query
     */
    public function useTypeComparisonQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTypeComparison($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TypeComparison', '\ECP\TypeComparisonQuery');
    }

    /**
     * Filter the query by a related \ECP\ItemFilterDef object
     *
     * @param \ECP\ItemFilterDef|ObjectCollection $itemFilterDef the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTypeQuery The current query, for fluid interface
     */
    public function filterByItemFilterDef($itemFilterDef, $comparison = null)
    {
        if ($itemFilterDef instanceof \ECP\ItemFilterDef) {
            return $this
                ->addUsingAlias(TypeTableMap::COL_ID, $itemFilterDef->getTypeid(), $comparison);
        } elseif ($itemFilterDef instanceof ObjectCollection) {
            return $this
                ->useItemFilterDefQuery()
                ->filterByPrimaryKeys($itemFilterDef->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByItemFilterDef() only accepts arguments of type \ECP\ItemFilterDef or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ItemFilterDef relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function joinItemFilterDef($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ItemFilterDef');

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
            $this->addJoinObject($join, 'ItemFilterDef');
        }

        return $this;
    }

    /**
     * Use the ItemFilterDef relation ItemFilterDef object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\ItemFilterDefQuery A secondary query class using the current class as primary query
     */
    public function useItemFilterDefQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItemFilterDef($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ItemFilterDef', '\ECP\ItemFilterDefQuery');
    }

    /**
     * Filter the query by a related Comparison object
     * using the typecomparison table as cross reference
     *
     * @param Comparison $comparison the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTypeQuery The current query, for fluid interface
     */
    public function filterByComparison($comparison, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useTypeComparisonQuery()
            ->filterByComparison($comparison, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildType $type Object to remove from the list of results
     *
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function prune($type = null)
    {
        if ($type) {
            $this->addUsingAlias(TypeTableMap::COL_ID, $type->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the type table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TypeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TypeTableMap::clearInstancePool();
            TypeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TypeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TypeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            TypeTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            TypeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TypeQuery
