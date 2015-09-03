<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\Comparison as ChildComparison;
use ECP\ComparisonQuery as ChildComparisonQuery;
use ECP\Map\ComparisonTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'comparison' table.
 *
 * 
 *
 * @method     ChildComparisonQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildComparisonQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildComparisonQuery groupById() Group by the id column
 * @method     ChildComparisonQuery groupByName() Group by the name column
 *
 * @method     ChildComparisonQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildComparisonQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildComparisonQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildComparisonQuery leftJoinTypeComparison($relationAlias = null) Adds a LEFT JOIN clause to the query using the TypeComparison relation
 * @method     ChildComparisonQuery rightJoinTypeComparison($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TypeComparison relation
 * @method     ChildComparisonQuery innerJoinTypeComparison($relationAlias = null) Adds a INNER JOIN clause to the query using the TypeComparison relation
 *
 * @method     ChildComparisonQuery leftJoinFittingRuleRowRelatedByConcatenation($relationAlias = null) Adds a LEFT JOIN clause to the query using the FittingRuleRowRelatedByConcatenation relation
 * @method     ChildComparisonQuery rightJoinFittingRuleRowRelatedByConcatenation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FittingRuleRowRelatedByConcatenation relation
 * @method     ChildComparisonQuery innerJoinFittingRuleRowRelatedByConcatenation($relationAlias = null) Adds a INNER JOIN clause to the query using the FittingRuleRowRelatedByConcatenation relation
 *
 * @method     ChildComparisonQuery leftJoinFittingRuleRowRelatedByComparison($relationAlias = null) Adds a LEFT JOIN clause to the query using the FittingRuleRowRelatedByComparison relation
 * @method     ChildComparisonQuery rightJoinFittingRuleRowRelatedByComparison($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FittingRuleRowRelatedByComparison relation
 * @method     ChildComparisonQuery innerJoinFittingRuleRowRelatedByComparison($relationAlias = null) Adds a INNER JOIN clause to the query using the FittingRuleRowRelatedByComparison relation
 *
 * @method     ChildComparisonQuery leftJoinItemFilterRuleRelatedByConcatenation($relationAlias = null) Adds a LEFT JOIN clause to the query using the ItemFilterRuleRelatedByConcatenation relation
 * @method     ChildComparisonQuery rightJoinItemFilterRuleRelatedByConcatenation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ItemFilterRuleRelatedByConcatenation relation
 * @method     ChildComparisonQuery innerJoinItemFilterRuleRelatedByConcatenation($relationAlias = null) Adds a INNER JOIN clause to the query using the ItemFilterRuleRelatedByConcatenation relation
 *
 * @method     ChildComparisonQuery leftJoinItemFilterRuleRelatedByComparison($relationAlias = null) Adds a LEFT JOIN clause to the query using the ItemFilterRuleRelatedByComparison relation
 * @method     ChildComparisonQuery rightJoinItemFilterRuleRelatedByComparison($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ItemFilterRuleRelatedByComparison relation
 * @method     ChildComparisonQuery innerJoinItemFilterRuleRelatedByComparison($relationAlias = null) Adds a INNER JOIN clause to the query using the ItemFilterRuleRelatedByComparison relation
 *
 * @method     ChildComparisonQuery leftJoinRulesetFilterRuleRelatedByConcatenation($relationAlias = null) Adds a LEFT JOIN clause to the query using the RulesetFilterRuleRelatedByConcatenation relation
 * @method     ChildComparisonQuery rightJoinRulesetFilterRuleRelatedByConcatenation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RulesetFilterRuleRelatedByConcatenation relation
 * @method     ChildComparisonQuery innerJoinRulesetFilterRuleRelatedByConcatenation($relationAlias = null) Adds a INNER JOIN clause to the query using the RulesetFilterRuleRelatedByConcatenation relation
 *
 * @method     ChildComparisonQuery leftJoinRulesetFilterRuleRelatedByComparison($relationAlias = null) Adds a LEFT JOIN clause to the query using the RulesetFilterRuleRelatedByComparison relation
 * @method     ChildComparisonQuery rightJoinRulesetFilterRuleRelatedByComparison($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RulesetFilterRuleRelatedByComparison relation
 * @method     ChildComparisonQuery innerJoinRulesetFilterRuleRelatedByComparison($relationAlias = null) Adds a INNER JOIN clause to the query using the RulesetFilterRuleRelatedByComparison relation
 *
 * @method     \ECP\TypeComparisonQuery|\ECP\FittingRuleRowQuery|\ECP\ItemFilterRuleQuery|\ECP\RulesetFilterRuleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildComparison findOne(ConnectionInterface $con = null) Return the first ChildComparison matching the query
 * @method     ChildComparison findOneOrCreate(ConnectionInterface $con = null) Return the first ChildComparison matching the query, or a new ChildComparison object populated from the query conditions when no match is found
 *
 * @method     ChildComparison findOneById(int $id) Return the first ChildComparison filtered by the id column
 * @method     ChildComparison findOneByName(string $name) Return the first ChildComparison filtered by the name column *

 * @method     ChildComparison requirePk($key, ConnectionInterface $con = null) Return the ChildComparison by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComparison requireOne(ConnectionInterface $con = null) Return the first ChildComparison matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildComparison requireOneById(int $id) Return the first ChildComparison filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComparison requireOneByName(string $name) Return the first ChildComparison filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildComparison[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildComparison objects based on current ModelCriteria
 * @method     ChildComparison[]|ObjectCollection findById(int $id) Return ChildComparison objects filtered by the id column
 * @method     ChildComparison[]|ObjectCollection findByName(string $name) Return ChildComparison objects filtered by the name column
 * @method     ChildComparison[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ComparisonQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\ComparisonQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\Comparison', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildComparisonQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildComparisonQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildComparisonQuery) {
            return $criteria;
        }
        $query = new ChildComparisonQuery();
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
     * @return ChildComparison|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ComparisonTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ComparisonTableMap::DATABASE_NAME);
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
     * @return ChildComparison A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name FROM comparison WHERE id = :p0';
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
            /** @var ChildComparison $obj */
            $obj = new ChildComparison();
            $obj->hydrate($row);
            ComparisonTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildComparison|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildComparisonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ComparisonTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildComparisonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ComparisonTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildComparisonQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ComparisonTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ComparisonTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComparisonTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildComparisonQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ComparisonTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related \ECP\TypeComparison object
     *
     * @param \ECP\TypeComparison|ObjectCollection $typeComparison the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildComparisonQuery The current query, for fluid interface
     */
    public function filterByTypeComparison($typeComparison, $comparison = null)
    {
        if ($typeComparison instanceof \ECP\TypeComparison) {
            return $this
                ->addUsingAlias(ComparisonTableMap::COL_ID, $typeComparison->getComparisonid(), $comparison);
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
     * @return $this|ChildComparisonQuery The current query, for fluid interface
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
     * Filter the query by a related \ECP\FittingRuleRow object
     *
     * @param \ECP\FittingRuleRow|ObjectCollection $fittingRuleRow the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildComparisonQuery The current query, for fluid interface
     */
    public function filterByFittingRuleRowRelatedByConcatenation($fittingRuleRow, $comparison = null)
    {
        if ($fittingRuleRow instanceof \ECP\FittingRuleRow) {
            return $this
                ->addUsingAlias(ComparisonTableMap::COL_ID, $fittingRuleRow->getConcatenation(), $comparison);
        } elseif ($fittingRuleRow instanceof ObjectCollection) {
            return $this
                ->useFittingRuleRowRelatedByConcatenationQuery()
                ->filterByPrimaryKeys($fittingRuleRow->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFittingRuleRowRelatedByConcatenation() only accepts arguments of type \ECP\FittingRuleRow or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FittingRuleRowRelatedByConcatenation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildComparisonQuery The current query, for fluid interface
     */
    public function joinFittingRuleRowRelatedByConcatenation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FittingRuleRowRelatedByConcatenation');

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
            $this->addJoinObject($join, 'FittingRuleRowRelatedByConcatenation');
        }

        return $this;
    }

    /**
     * Use the FittingRuleRowRelatedByConcatenation relation FittingRuleRow object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\FittingRuleRowQuery A secondary query class using the current class as primary query
     */
    public function useFittingRuleRowRelatedByConcatenationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFittingRuleRowRelatedByConcatenation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FittingRuleRowRelatedByConcatenation', '\ECP\FittingRuleRowQuery');
    }

    /**
     * Filter the query by a related \ECP\FittingRuleRow object
     *
     * @param \ECP\FittingRuleRow|ObjectCollection $fittingRuleRow the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildComparisonQuery The current query, for fluid interface
     */
    public function filterByFittingRuleRowRelatedByComparison($fittingRuleRow, $comparison = null)
    {
        if ($fittingRuleRow instanceof \ECP\FittingRuleRow) {
            return $this
                ->addUsingAlias(ComparisonTableMap::COL_ID, $fittingRuleRow->getComparison(), $comparison);
        } elseif ($fittingRuleRow instanceof ObjectCollection) {
            return $this
                ->useFittingRuleRowRelatedByComparisonQuery()
                ->filterByPrimaryKeys($fittingRuleRow->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFittingRuleRowRelatedByComparison() only accepts arguments of type \ECP\FittingRuleRow or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FittingRuleRowRelatedByComparison relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildComparisonQuery The current query, for fluid interface
     */
    public function joinFittingRuleRowRelatedByComparison($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FittingRuleRowRelatedByComparison');

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
            $this->addJoinObject($join, 'FittingRuleRowRelatedByComparison');
        }

        return $this;
    }

    /**
     * Use the FittingRuleRowRelatedByComparison relation FittingRuleRow object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\FittingRuleRowQuery A secondary query class using the current class as primary query
     */
    public function useFittingRuleRowRelatedByComparisonQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFittingRuleRowRelatedByComparison($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FittingRuleRowRelatedByComparison', '\ECP\FittingRuleRowQuery');
    }

    /**
     * Filter the query by a related \ECP\ItemFilterRule object
     *
     * @param \ECP\ItemFilterRule|ObjectCollection $itemFilterRule the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildComparisonQuery The current query, for fluid interface
     */
    public function filterByItemFilterRuleRelatedByConcatenation($itemFilterRule, $comparison = null)
    {
        if ($itemFilterRule instanceof \ECP\ItemFilterRule) {
            return $this
                ->addUsingAlias(ComparisonTableMap::COL_ID, $itemFilterRule->getConcatenation(), $comparison);
        } elseif ($itemFilterRule instanceof ObjectCollection) {
            return $this
                ->useItemFilterRuleRelatedByConcatenationQuery()
                ->filterByPrimaryKeys($itemFilterRule->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByItemFilterRuleRelatedByConcatenation() only accepts arguments of type \ECP\ItemFilterRule or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ItemFilterRuleRelatedByConcatenation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildComparisonQuery The current query, for fluid interface
     */
    public function joinItemFilterRuleRelatedByConcatenation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ItemFilterRuleRelatedByConcatenation');

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
            $this->addJoinObject($join, 'ItemFilterRuleRelatedByConcatenation');
        }

        return $this;
    }

    /**
     * Use the ItemFilterRuleRelatedByConcatenation relation ItemFilterRule object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\ItemFilterRuleQuery A secondary query class using the current class as primary query
     */
    public function useItemFilterRuleRelatedByConcatenationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinItemFilterRuleRelatedByConcatenation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ItemFilterRuleRelatedByConcatenation', '\ECP\ItemFilterRuleQuery');
    }

    /**
     * Filter the query by a related \ECP\ItemFilterRule object
     *
     * @param \ECP\ItemFilterRule|ObjectCollection $itemFilterRule the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildComparisonQuery The current query, for fluid interface
     */
    public function filterByItemFilterRuleRelatedByComparison($itemFilterRule, $comparison = null)
    {
        if ($itemFilterRule instanceof \ECP\ItemFilterRule) {
            return $this
                ->addUsingAlias(ComparisonTableMap::COL_ID, $itemFilterRule->getComparison(), $comparison);
        } elseif ($itemFilterRule instanceof ObjectCollection) {
            return $this
                ->useItemFilterRuleRelatedByComparisonQuery()
                ->filterByPrimaryKeys($itemFilterRule->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByItemFilterRuleRelatedByComparison() only accepts arguments of type \ECP\ItemFilterRule or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ItemFilterRuleRelatedByComparison relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildComparisonQuery The current query, for fluid interface
     */
    public function joinItemFilterRuleRelatedByComparison($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ItemFilterRuleRelatedByComparison');

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
            $this->addJoinObject($join, 'ItemFilterRuleRelatedByComparison');
        }

        return $this;
    }

    /**
     * Use the ItemFilterRuleRelatedByComparison relation ItemFilterRule object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\ItemFilterRuleQuery A secondary query class using the current class as primary query
     */
    public function useItemFilterRuleRelatedByComparisonQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItemFilterRuleRelatedByComparison($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ItemFilterRuleRelatedByComparison', '\ECP\ItemFilterRuleQuery');
    }

    /**
     * Filter the query by a related \ECP\RulesetFilterRule object
     *
     * @param \ECP\RulesetFilterRule|ObjectCollection $rulesetFilterRule the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildComparisonQuery The current query, for fluid interface
     */
    public function filterByRulesetFilterRuleRelatedByConcatenation($rulesetFilterRule, $comparison = null)
    {
        if ($rulesetFilterRule instanceof \ECP\RulesetFilterRule) {
            return $this
                ->addUsingAlias(ComparisonTableMap::COL_ID, $rulesetFilterRule->getConcatenation(), $comparison);
        } elseif ($rulesetFilterRule instanceof ObjectCollection) {
            return $this
                ->useRulesetFilterRuleRelatedByConcatenationQuery()
                ->filterByPrimaryKeys($rulesetFilterRule->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRulesetFilterRuleRelatedByConcatenation() only accepts arguments of type \ECP\RulesetFilterRule or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RulesetFilterRuleRelatedByConcatenation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildComparisonQuery The current query, for fluid interface
     */
    public function joinRulesetFilterRuleRelatedByConcatenation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RulesetFilterRuleRelatedByConcatenation');

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
            $this->addJoinObject($join, 'RulesetFilterRuleRelatedByConcatenation');
        }

        return $this;
    }

    /**
     * Use the RulesetFilterRuleRelatedByConcatenation relation RulesetFilterRule object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\RulesetFilterRuleQuery A secondary query class using the current class as primary query
     */
    public function useRulesetFilterRuleRelatedByConcatenationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRulesetFilterRuleRelatedByConcatenation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RulesetFilterRuleRelatedByConcatenation', '\ECP\RulesetFilterRuleQuery');
    }

    /**
     * Filter the query by a related \ECP\RulesetFilterRule object
     *
     * @param \ECP\RulesetFilterRule|ObjectCollection $rulesetFilterRule the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildComparisonQuery The current query, for fluid interface
     */
    public function filterByRulesetFilterRuleRelatedByComparison($rulesetFilterRule, $comparison = null)
    {
        if ($rulesetFilterRule instanceof \ECP\RulesetFilterRule) {
            return $this
                ->addUsingAlias(ComparisonTableMap::COL_ID, $rulesetFilterRule->getComparison(), $comparison);
        } elseif ($rulesetFilterRule instanceof ObjectCollection) {
            return $this
                ->useRulesetFilterRuleRelatedByComparisonQuery()
                ->filterByPrimaryKeys($rulesetFilterRule->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRulesetFilterRuleRelatedByComparison() only accepts arguments of type \ECP\RulesetFilterRule or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RulesetFilterRuleRelatedByComparison relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildComparisonQuery The current query, for fluid interface
     */
    public function joinRulesetFilterRuleRelatedByComparison($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RulesetFilterRuleRelatedByComparison');

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
            $this->addJoinObject($join, 'RulesetFilterRuleRelatedByComparison');
        }

        return $this;
    }

    /**
     * Use the RulesetFilterRuleRelatedByComparison relation RulesetFilterRule object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\RulesetFilterRuleQuery A secondary query class using the current class as primary query
     */
    public function useRulesetFilterRuleRelatedByComparisonQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRulesetFilterRuleRelatedByComparison($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RulesetFilterRuleRelatedByComparison', '\ECP\RulesetFilterRuleQuery');
    }

    /**
     * Filter the query by a related Type object
     * using the typecomparison table as cross reference
     *
     * @param Type $type the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildComparisonQuery The current query, for fluid interface
     */
    public function filterByType($type, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useTypeComparisonQuery()
            ->filterByType($type, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildComparison $comparison Object to remove from the list of results
     *
     * @return $this|ChildComparisonQuery The current query, for fluid interface
     */
    public function prune($comparison = null)
    {
        if ($comparison) {
            $this->addUsingAlias(ComparisonTableMap::COL_ID, $comparison->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the comparison table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ComparisonTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ComparisonTableMap::clearInstancePool();
            ComparisonTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ComparisonTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ComparisonTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ComparisonTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ComparisonTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ComparisonQuery
