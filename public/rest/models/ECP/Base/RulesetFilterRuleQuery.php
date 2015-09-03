<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\RulesetFilterRule as ChildRulesetFilterRule;
use ECP\RulesetFilterRuleQuery as ChildRulesetFilterRuleQuery;
use ECP\Map\RulesetFilterRuleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'rulesetfilterrule' table.
 *
 * 
 *
 * @method     ChildRulesetFilterRuleQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRulesetFilterRuleQuery orderByRulesetrulerowid($order = Criteria::ASC) Order by the rulesetRuleRowId column
 * @method     ChildRulesetFilterRuleQuery orderByInd3x($order = Criteria::ASC) Order by the ind3x column
 * @method     ChildRulesetFilterRuleQuery orderByConcatenation($order = Criteria::ASC) Order by the concatenation column
 * @method     ChildRulesetFilterRuleQuery orderByFittingruleentityid($order = Criteria::ASC) Order by the fittingRuleEntityId column
 * @method     ChildRulesetFilterRuleQuery orderByComparison($order = Criteria::ASC) Order by the comparison column
 * @method     ChildRulesetFilterRuleQuery orderByValue($order = Criteria::ASC) Order by the value column
 *
 * @method     ChildRulesetFilterRuleQuery groupById() Group by the id column
 * @method     ChildRulesetFilterRuleQuery groupByRulesetrulerowid() Group by the rulesetRuleRowId column
 * @method     ChildRulesetFilterRuleQuery groupByInd3x() Group by the ind3x column
 * @method     ChildRulesetFilterRuleQuery groupByConcatenation() Group by the concatenation column
 * @method     ChildRulesetFilterRuleQuery groupByFittingruleentityid() Group by the fittingRuleEntityId column
 * @method     ChildRulesetFilterRuleQuery groupByComparison() Group by the comparison column
 * @method     ChildRulesetFilterRuleQuery groupByValue() Group by the value column
 *
 * @method     ChildRulesetFilterRuleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRulesetFilterRuleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRulesetFilterRuleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRulesetFilterRuleQuery leftJoinRulesetRuleRow($relationAlias = null) Adds a LEFT JOIN clause to the query using the RulesetRuleRow relation
 * @method     ChildRulesetFilterRuleQuery rightJoinRulesetRuleRow($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RulesetRuleRow relation
 * @method     ChildRulesetFilterRuleQuery innerJoinRulesetRuleRow($relationAlias = null) Adds a INNER JOIN clause to the query using the RulesetRuleRow relation
 *
 * @method     ChildRulesetFilterRuleQuery leftJoinconcatenationObj($relationAlias = null) Adds a LEFT JOIN clause to the query using the concatenationObj relation
 * @method     ChildRulesetFilterRuleQuery rightJoinconcatenationObj($relationAlias = null) Adds a RIGHT JOIN clause to the query using the concatenationObj relation
 * @method     ChildRulesetFilterRuleQuery innerJoinconcatenationObj($relationAlias = null) Adds a INNER JOIN clause to the query using the concatenationObj relation
 *
 * @method     ChildRulesetFilterRuleQuery leftJoinFittingRuleEntity($relationAlias = null) Adds a LEFT JOIN clause to the query using the FittingRuleEntity relation
 * @method     ChildRulesetFilterRuleQuery rightJoinFittingRuleEntity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FittingRuleEntity relation
 * @method     ChildRulesetFilterRuleQuery innerJoinFittingRuleEntity($relationAlias = null) Adds a INNER JOIN clause to the query using the FittingRuleEntity relation
 *
 * @method     ChildRulesetFilterRuleQuery leftJoincomparisonObj($relationAlias = null) Adds a LEFT JOIN clause to the query using the comparisonObj relation
 * @method     ChildRulesetFilterRuleQuery rightJoincomparisonObj($relationAlias = null) Adds a RIGHT JOIN clause to the query using the comparisonObj relation
 * @method     ChildRulesetFilterRuleQuery innerJoincomparisonObj($relationAlias = null) Adds a INNER JOIN clause to the query using the comparisonObj relation
 *
 * @method     \ECP\RulesetRuleRowQuery|\ECP\ComparisonQuery|\ECP\FittingRuleEntityQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRulesetFilterRule findOne(ConnectionInterface $con = null) Return the first ChildRulesetFilterRule matching the query
 * @method     ChildRulesetFilterRule findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRulesetFilterRule matching the query, or a new ChildRulesetFilterRule object populated from the query conditions when no match is found
 *
 * @method     ChildRulesetFilterRule findOneById(int $id) Return the first ChildRulesetFilterRule filtered by the id column
 * @method     ChildRulesetFilterRule findOneByRulesetrulerowid(int $rulesetRuleRowId) Return the first ChildRulesetFilterRule filtered by the rulesetRuleRowId column
 * @method     ChildRulesetFilterRule findOneByInd3x(int $ind3x) Return the first ChildRulesetFilterRule filtered by the ind3x column
 * @method     ChildRulesetFilterRule findOneByConcatenation(int $concatenation) Return the first ChildRulesetFilterRule filtered by the concatenation column
 * @method     ChildRulesetFilterRule findOneByFittingruleentityid(int $fittingRuleEntityId) Return the first ChildRulesetFilterRule filtered by the fittingRuleEntityId column
 * @method     ChildRulesetFilterRule findOneByComparison(int $comparison) Return the first ChildRulesetFilterRule filtered by the comparison column
 * @method     ChildRulesetFilterRule findOneByValue(int $value) Return the first ChildRulesetFilterRule filtered by the value column *

 * @method     ChildRulesetFilterRule requirePk($key, ConnectionInterface $con = null) Return the ChildRulesetFilterRule by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetFilterRule requireOne(ConnectionInterface $con = null) Return the first ChildRulesetFilterRule matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRulesetFilterRule requireOneById(int $id) Return the first ChildRulesetFilterRule filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetFilterRule requireOneByRulesetrulerowid(int $rulesetRuleRowId) Return the first ChildRulesetFilterRule filtered by the rulesetRuleRowId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetFilterRule requireOneByInd3x(int $ind3x) Return the first ChildRulesetFilterRule filtered by the ind3x column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetFilterRule requireOneByConcatenation(int $concatenation) Return the first ChildRulesetFilterRule filtered by the concatenation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetFilterRule requireOneByFittingruleentityid(int $fittingRuleEntityId) Return the first ChildRulesetFilterRule filtered by the fittingRuleEntityId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetFilterRule requireOneByComparison(int $comparison) Return the first ChildRulesetFilterRule filtered by the comparison column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetFilterRule requireOneByValue(int $value) Return the first ChildRulesetFilterRule filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRulesetFilterRule[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRulesetFilterRule objects based on current ModelCriteria
 * @method     ChildRulesetFilterRule[]|ObjectCollection findById(int $id) Return ChildRulesetFilterRule objects filtered by the id column
 * @method     ChildRulesetFilterRule[]|ObjectCollection findByRulesetrulerowid(int $rulesetRuleRowId) Return ChildRulesetFilterRule objects filtered by the rulesetRuleRowId column
 * @method     ChildRulesetFilterRule[]|ObjectCollection findByInd3x(int $ind3x) Return ChildRulesetFilterRule objects filtered by the ind3x column
 * @method     ChildRulesetFilterRule[]|ObjectCollection findByConcatenation(int $concatenation) Return ChildRulesetFilterRule objects filtered by the concatenation column
 * @method     ChildRulesetFilterRule[]|ObjectCollection findByFittingruleentityid(int $fittingRuleEntityId) Return ChildRulesetFilterRule objects filtered by the fittingRuleEntityId column
 * @method     ChildRulesetFilterRule[]|ObjectCollection findByComparison(int $comparison) Return ChildRulesetFilterRule objects filtered by the comparison column
 * @method     ChildRulesetFilterRule[]|ObjectCollection findByValue(int $value) Return ChildRulesetFilterRule objects filtered by the value column
 * @method     ChildRulesetFilterRule[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RulesetFilterRuleQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\RulesetFilterRuleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\RulesetFilterRule', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRulesetFilterRuleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRulesetFilterRuleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRulesetFilterRuleQuery) {
            return $criteria;
        }
        $query = new ChildRulesetFilterRuleQuery();
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
     * @return ChildRulesetFilterRule|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RulesetFilterRuleTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RulesetFilterRuleTableMap::DATABASE_NAME);
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
     * @return ChildRulesetFilterRule A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, rulesetRuleRowId, ind3x, concatenation, fittingRuleEntityId, comparison, value FROM rulesetfilterrule WHERE id = :p0';
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
            /** @var ChildRulesetFilterRule $obj */
            $obj = new ChildRulesetFilterRule();
            $obj->hydrate($row);
            RulesetFilterRuleTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRulesetFilterRule|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RulesetFilterRuleTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RulesetFilterRuleTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RulesetFilterRuleTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RulesetFilterRuleTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetFilterRuleTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the rulesetRuleRowId column
     *
     * Example usage:
     * <code>
     * $query->filterByRulesetrulerowid(1234); // WHERE rulesetRuleRowId = 1234
     * $query->filterByRulesetrulerowid(array(12, 34)); // WHERE rulesetRuleRowId IN (12, 34)
     * $query->filterByRulesetrulerowid(array('min' => 12)); // WHERE rulesetRuleRowId > 12
     * </code>
     *
     * @see       filterByRulesetRuleRow()
     *
     * @param     mixed $rulesetrulerowid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function filterByRulesetrulerowid($rulesetrulerowid = null, $comparison = null)
    {
        if (is_array($rulesetrulerowid)) {
            $useMinMax = false;
            if (isset($rulesetrulerowid['min'])) {
                $this->addUsingAlias(RulesetFilterRuleTableMap::COL_RULESETRULEROWID, $rulesetrulerowid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rulesetrulerowid['max'])) {
                $this->addUsingAlias(RulesetFilterRuleTableMap::COL_RULESETRULEROWID, $rulesetrulerowid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetFilterRuleTableMap::COL_RULESETRULEROWID, $rulesetrulerowid, $comparison);
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
     * @return $this|ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function filterByInd3x($ind3x = null, $comparison = null)
    {
        if (is_array($ind3x)) {
            $useMinMax = false;
            if (isset($ind3x['min'])) {
                $this->addUsingAlias(RulesetFilterRuleTableMap::COL_IND3X, $ind3x['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ind3x['max'])) {
                $this->addUsingAlias(RulesetFilterRuleTableMap::COL_IND3X, $ind3x['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetFilterRuleTableMap::COL_IND3X, $ind3x, $comparison);
    }

    /**
     * Filter the query on the concatenation column
     *
     * Example usage:
     * <code>
     * $query->filterByConcatenation(1234); // WHERE concatenation = 1234
     * $query->filterByConcatenation(array(12, 34)); // WHERE concatenation IN (12, 34)
     * $query->filterByConcatenation(array('min' => 12)); // WHERE concatenation > 12
     * </code>
     *
     * @see       filterByconcatenationObj()
     *
     * @param     mixed $concatenation The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function filterByConcatenation($concatenation = null, $comparison = null)
    {
        if (is_array($concatenation)) {
            $useMinMax = false;
            if (isset($concatenation['min'])) {
                $this->addUsingAlias(RulesetFilterRuleTableMap::COL_CONCATENATION, $concatenation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($concatenation['max'])) {
                $this->addUsingAlias(RulesetFilterRuleTableMap::COL_CONCATENATION, $concatenation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetFilterRuleTableMap::COL_CONCATENATION, $concatenation, $comparison);
    }

    /**
     * Filter the query on the fittingRuleEntityId column
     *
     * Example usage:
     * <code>
     * $query->filterByFittingruleentityid(1234); // WHERE fittingRuleEntityId = 1234
     * $query->filterByFittingruleentityid(array(12, 34)); // WHERE fittingRuleEntityId IN (12, 34)
     * $query->filterByFittingruleentityid(array('min' => 12)); // WHERE fittingRuleEntityId > 12
     * </code>
     *
     * @see       filterByFittingRuleEntity()
     *
     * @param     mixed $fittingruleentityid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function filterByFittingruleentityid($fittingruleentityid = null, $comparison = null)
    {
        if (is_array($fittingruleentityid)) {
            $useMinMax = false;
            if (isset($fittingruleentityid['min'])) {
                $this->addUsingAlias(RulesetFilterRuleTableMap::COL_FITTINGRULEENTITYID, $fittingruleentityid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fittingruleentityid['max'])) {
                $this->addUsingAlias(RulesetFilterRuleTableMap::COL_FITTINGRULEENTITYID, $fittingruleentityid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetFilterRuleTableMap::COL_FITTINGRULEENTITYID, $fittingruleentityid, $comparison);
    }

    /**
     * Filter the query on the comparison column
     *
     * Example usage:
     * <code>
     * $query->filterByComparison(1234); // WHERE comparison = 1234
     * $query->filterByComparison(array(12, 34)); // WHERE comparison IN (12, 34)
     * $query->filterByComparison(array('min' => 12)); // WHERE comparison > 12
     * </code>
     *
     * @see       filterBycomparisonObj()
     *
     * @param     mixed $comparison The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function filterByComparison($comparison = null, $comparison = null)
    {
        if (is_array($comparison)) {
            $useMinMax = false;
            if (isset($comparison['min'])) {
                $this->addUsingAlias(RulesetFilterRuleTableMap::COL_COMPARISON, $comparison['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($comparison['max'])) {
                $this->addUsingAlias(RulesetFilterRuleTableMap::COL_COMPARISON, $comparison['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetFilterRuleTableMap::COL_COMPARISON, $comparison, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue(1234); // WHERE value = 1234
     * $query->filterByValue(array(12, 34)); // WHERE value IN (12, 34)
     * $query->filterByValue(array('min' => 12)); // WHERE value > 12
     * </code>
     *
     * @param     mixed $value The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(RulesetFilterRuleTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(RulesetFilterRuleTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetFilterRuleTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query by a related \ECP\RulesetRuleRow object
     *
     * @param \ECP\RulesetRuleRow|ObjectCollection $rulesetRuleRow The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function filterByRulesetRuleRow($rulesetRuleRow, $comparison = null)
    {
        if ($rulesetRuleRow instanceof \ECP\RulesetRuleRow) {
            return $this
                ->addUsingAlias(RulesetFilterRuleTableMap::COL_RULESETRULEROWID, $rulesetRuleRow->getId(), $comparison);
        } elseif ($rulesetRuleRow instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RulesetFilterRuleTableMap::COL_RULESETRULEROWID, $rulesetRuleRow->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRulesetRuleRow() only accepts arguments of type \ECP\RulesetRuleRow or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RulesetRuleRow relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function joinRulesetRuleRow($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RulesetRuleRow');

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
            $this->addJoinObject($join, 'RulesetRuleRow');
        }

        return $this;
    }

    /**
     * Use the RulesetRuleRow relation RulesetRuleRow object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\RulesetRuleRowQuery A secondary query class using the current class as primary query
     */
    public function useRulesetRuleRowQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRulesetRuleRow($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RulesetRuleRow', '\ECP\RulesetRuleRowQuery');
    }

    /**
     * Filter the query by a related \ECP\Comparison object
     *
     * @param \ECP\Comparison|ObjectCollection $comparison The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function filterByconcatenationObj($comparison, $comparison = null)
    {
        if ($comparison instanceof \ECP\Comparison) {
            return $this
                ->addUsingAlias(RulesetFilterRuleTableMap::COL_CONCATENATION, $comparison->getId(), $comparison);
        } elseif ($comparison instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RulesetFilterRuleTableMap::COL_CONCATENATION, $comparison->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByconcatenationObj() only accepts arguments of type \ECP\Comparison or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the concatenationObj relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function joinconcatenationObj($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('concatenationObj');

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
            $this->addJoinObject($join, 'concatenationObj');
        }

        return $this;
    }

    /**
     * Use the concatenationObj relation Comparison object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\ComparisonQuery A secondary query class using the current class as primary query
     */
    public function useconcatenationObjQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinconcatenationObj($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'concatenationObj', '\ECP\ComparisonQuery');
    }

    /**
     * Filter the query by a related \ECP\FittingRuleEntity object
     *
     * @param \ECP\FittingRuleEntity|ObjectCollection $fittingRuleEntity The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function filterByFittingRuleEntity($fittingRuleEntity, $comparison = null)
    {
        if ($fittingRuleEntity instanceof \ECP\FittingRuleEntity) {
            return $this
                ->addUsingAlias(RulesetFilterRuleTableMap::COL_FITTINGRULEENTITYID, $fittingRuleEntity->getId(), $comparison);
        } elseif ($fittingRuleEntity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RulesetFilterRuleTableMap::COL_FITTINGRULEENTITYID, $fittingRuleEntity->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFittingRuleEntity() only accepts arguments of type \ECP\FittingRuleEntity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FittingRuleEntity relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function joinFittingRuleEntity($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FittingRuleEntity');

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
            $this->addJoinObject($join, 'FittingRuleEntity');
        }

        return $this;
    }

    /**
     * Use the FittingRuleEntity relation FittingRuleEntity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\FittingRuleEntityQuery A secondary query class using the current class as primary query
     */
    public function useFittingRuleEntityQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFittingRuleEntity($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FittingRuleEntity', '\ECP\FittingRuleEntityQuery');
    }

    /**
     * Filter the query by a related \ECP\Comparison object
     *
     * @param \ECP\Comparison|ObjectCollection $comparison The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function filterBycomparisonObj($comparison, $comparison = null)
    {
        if ($comparison instanceof \ECP\Comparison) {
            return $this
                ->addUsingAlias(RulesetFilterRuleTableMap::COL_COMPARISON, $comparison->getId(), $comparison);
        } elseif ($comparison instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RulesetFilterRuleTableMap::COL_COMPARISON, $comparison->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBycomparisonObj() only accepts arguments of type \ECP\Comparison or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the comparisonObj relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function joincomparisonObj($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('comparisonObj');

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
            $this->addJoinObject($join, 'comparisonObj');
        }

        return $this;
    }

    /**
     * Use the comparisonObj relation Comparison object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\ComparisonQuery A secondary query class using the current class as primary query
     */
    public function usecomparisonObjQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joincomparisonObj($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'comparisonObj', '\ECP\ComparisonQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRulesetFilterRule $rulesetFilterRule Object to remove from the list of results
     *
     * @return $this|ChildRulesetFilterRuleQuery The current query, for fluid interface
     */
    public function prune($rulesetFilterRule = null)
    {
        if ($rulesetFilterRule) {
            $this->addUsingAlias(RulesetFilterRuleTableMap::COL_ID, $rulesetFilterRule->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the rulesetfilterrule table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RulesetFilterRuleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RulesetFilterRuleTableMap::clearInstancePool();
            RulesetFilterRuleTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RulesetFilterRuleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RulesetFilterRuleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            RulesetFilterRuleTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            RulesetFilterRuleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RulesetFilterRuleQuery
