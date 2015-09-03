<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\ItemFilterRule as ChildItemFilterRule;
use ECP\ItemFilterRuleQuery as ChildItemFilterRuleQuery;
use ECP\Map\ItemFilterRuleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'itemfilterrule' table.
 *
 * 
 *
 * @method     ChildItemFilterRuleQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildItemFilterRuleQuery orderByFittingrulerowid($order = Criteria::ASC) Order by the fittingRuleRowId column
 * @method     ChildItemFilterRuleQuery orderByInd3x($order = Criteria::ASC) Order by the ind3x column
 * @method     ChildItemFilterRuleQuery orderByConcatenation($order = Criteria::ASC) Order by the concatenation column
 * @method     ChildItemFilterRuleQuery orderByItemfilterdefid($order = Criteria::ASC) Order by the itemFilterDefId column
 * @method     ChildItemFilterRuleQuery orderByComparison($order = Criteria::ASC) Order by the comparison column
 * @method     ChildItemFilterRuleQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildItemFilterRuleQuery orderByContent1($order = Criteria::ASC) Order by the content1 column
 * @method     ChildItemFilterRuleQuery orderByContent2($order = Criteria::ASC) Order by the content2 column
 *
 * @method     ChildItemFilterRuleQuery groupById() Group by the id column
 * @method     ChildItemFilterRuleQuery groupByFittingrulerowid() Group by the fittingRuleRowId column
 * @method     ChildItemFilterRuleQuery groupByInd3x() Group by the ind3x column
 * @method     ChildItemFilterRuleQuery groupByConcatenation() Group by the concatenation column
 * @method     ChildItemFilterRuleQuery groupByItemfilterdefid() Group by the itemFilterDefId column
 * @method     ChildItemFilterRuleQuery groupByComparison() Group by the comparison column
 * @method     ChildItemFilterRuleQuery groupByValue() Group by the value column
 * @method     ChildItemFilterRuleQuery groupByContent1() Group by the content1 column
 * @method     ChildItemFilterRuleQuery groupByContent2() Group by the content2 column
 *
 * @method     ChildItemFilterRuleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemFilterRuleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemFilterRuleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemFilterRuleQuery leftJoinFittingRuleRow($relationAlias = null) Adds a LEFT JOIN clause to the query using the FittingRuleRow relation
 * @method     ChildItemFilterRuleQuery rightJoinFittingRuleRow($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FittingRuleRow relation
 * @method     ChildItemFilterRuleQuery innerJoinFittingRuleRow($relationAlias = null) Adds a INNER JOIN clause to the query using the FittingRuleRow relation
 *
 * @method     ChildItemFilterRuleQuery leftJoinconcatenationObj($relationAlias = null) Adds a LEFT JOIN clause to the query using the concatenationObj relation
 * @method     ChildItemFilterRuleQuery rightJoinconcatenationObj($relationAlias = null) Adds a RIGHT JOIN clause to the query using the concatenationObj relation
 * @method     ChildItemFilterRuleQuery innerJoinconcatenationObj($relationAlias = null) Adds a INNER JOIN clause to the query using the concatenationObj relation
 *
 * @method     ChildItemFilterRuleQuery leftJoinItemFilterDef($relationAlias = null) Adds a LEFT JOIN clause to the query using the ItemFilterDef relation
 * @method     ChildItemFilterRuleQuery rightJoinItemFilterDef($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ItemFilterDef relation
 * @method     ChildItemFilterRuleQuery innerJoinItemFilterDef($relationAlias = null) Adds a INNER JOIN clause to the query using the ItemFilterDef relation
 *
 * @method     ChildItemFilterRuleQuery leftJoincomparisonObj($relationAlias = null) Adds a LEFT JOIN clause to the query using the comparisonObj relation
 * @method     ChildItemFilterRuleQuery rightJoincomparisonObj($relationAlias = null) Adds a RIGHT JOIN clause to the query using the comparisonObj relation
 * @method     ChildItemFilterRuleQuery innerJoincomparisonObj($relationAlias = null) Adds a INNER JOIN clause to the query using the comparisonObj relation
 *
 * @method     \ECP\FittingRuleRowQuery|\ECP\ComparisonQuery|\ECP\ItemFilterDefQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildItemFilterRule findOne(ConnectionInterface $con = null) Return the first ChildItemFilterRule matching the query
 * @method     ChildItemFilterRule findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItemFilterRule matching the query, or a new ChildItemFilterRule object populated from the query conditions when no match is found
 *
 * @method     ChildItemFilterRule findOneById(int $id) Return the first ChildItemFilterRule filtered by the id column
 * @method     ChildItemFilterRule findOneByFittingrulerowid(int $fittingRuleRowId) Return the first ChildItemFilterRule filtered by the fittingRuleRowId column
 * @method     ChildItemFilterRule findOneByInd3x(int $ind3x) Return the first ChildItemFilterRule filtered by the ind3x column
 * @method     ChildItemFilterRule findOneByConcatenation(int $concatenation) Return the first ChildItemFilterRule filtered by the concatenation column
 * @method     ChildItemFilterRule findOneByItemfilterdefid(int $itemFilterDefId) Return the first ChildItemFilterRule filtered by the itemFilterDefId column
 * @method     ChildItemFilterRule findOneByComparison(int $comparison) Return the first ChildItemFilterRule filtered by the comparison column
 * @method     ChildItemFilterRule findOneByValue(string $value) Return the first ChildItemFilterRule filtered by the value column
 * @method     ChildItemFilterRule findOneByContent1(int $content1) Return the first ChildItemFilterRule filtered by the content1 column
 * @method     ChildItemFilterRule findOneByContent2(int $content2) Return the first ChildItemFilterRule filtered by the content2 column *

 * @method     ChildItemFilterRule requirePk($key, ConnectionInterface $con = null) Return the ChildItemFilterRule by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterRule requireOne(ConnectionInterface $con = null) Return the first ChildItemFilterRule matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemFilterRule requireOneById(int $id) Return the first ChildItemFilterRule filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterRule requireOneByFittingrulerowid(int $fittingRuleRowId) Return the first ChildItemFilterRule filtered by the fittingRuleRowId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterRule requireOneByInd3x(int $ind3x) Return the first ChildItemFilterRule filtered by the ind3x column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterRule requireOneByConcatenation(int $concatenation) Return the first ChildItemFilterRule filtered by the concatenation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterRule requireOneByItemfilterdefid(int $itemFilterDefId) Return the first ChildItemFilterRule filtered by the itemFilterDefId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterRule requireOneByComparison(int $comparison) Return the first ChildItemFilterRule filtered by the comparison column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterRule requireOneByValue(string $value) Return the first ChildItemFilterRule filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterRule requireOneByContent1(int $content1) Return the first ChildItemFilterRule filtered by the content1 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterRule requireOneByContent2(int $content2) Return the first ChildItemFilterRule filtered by the content2 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemFilterRule[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItemFilterRule objects based on current ModelCriteria
 * @method     ChildItemFilterRule[]|ObjectCollection findById(int $id) Return ChildItemFilterRule objects filtered by the id column
 * @method     ChildItemFilterRule[]|ObjectCollection findByFittingrulerowid(int $fittingRuleRowId) Return ChildItemFilterRule objects filtered by the fittingRuleRowId column
 * @method     ChildItemFilterRule[]|ObjectCollection findByInd3x(int $ind3x) Return ChildItemFilterRule objects filtered by the ind3x column
 * @method     ChildItemFilterRule[]|ObjectCollection findByConcatenation(int $concatenation) Return ChildItemFilterRule objects filtered by the concatenation column
 * @method     ChildItemFilterRule[]|ObjectCollection findByItemfilterdefid(int $itemFilterDefId) Return ChildItemFilterRule objects filtered by the itemFilterDefId column
 * @method     ChildItemFilterRule[]|ObjectCollection findByComparison(int $comparison) Return ChildItemFilterRule objects filtered by the comparison column
 * @method     ChildItemFilterRule[]|ObjectCollection findByValue(string $value) Return ChildItemFilterRule objects filtered by the value column
 * @method     ChildItemFilterRule[]|ObjectCollection findByContent1(int $content1) Return ChildItemFilterRule objects filtered by the content1 column
 * @method     ChildItemFilterRule[]|ObjectCollection findByContent2(int $content2) Return ChildItemFilterRule objects filtered by the content2 column
 * @method     ChildItemFilterRule[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemFilterRuleQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\ItemFilterRuleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\ItemFilterRule', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildItemFilterRuleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildItemFilterRuleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildItemFilterRuleQuery) {
            return $criteria;
        }
        $query = new ChildItemFilterRuleQuery();
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
     * @return ChildItemFilterRule|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ItemFilterRuleTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemFilterRuleTableMap::DATABASE_NAME);
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
     * @return ChildItemFilterRule A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, fittingRuleRowId, ind3x, concatenation, itemFilterDefId, comparison, value, content1, content2 FROM itemfilterrule WHERE id = :p0';
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
            /** @var ChildItemFilterRule $obj */
            $obj = new ChildItemFilterRule();
            $obj->hydrate($row);
            ItemFilterRuleTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildItemFilterRule|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ItemFilterRuleTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ItemFilterRuleTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterRuleTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the fittingRuleRowId column
     *
     * Example usage:
     * <code>
     * $query->filterByFittingrulerowid(1234); // WHERE fittingRuleRowId = 1234
     * $query->filterByFittingrulerowid(array(12, 34)); // WHERE fittingRuleRowId IN (12, 34)
     * $query->filterByFittingrulerowid(array('min' => 12)); // WHERE fittingRuleRowId > 12
     * </code>
     *
     * @see       filterByFittingRuleRow()
     *
     * @param     mixed $fittingrulerowid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterByFittingrulerowid($fittingrulerowid = null, $comparison = null)
    {
        if (is_array($fittingrulerowid)) {
            $useMinMax = false;
            if (isset($fittingrulerowid['min'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_FITTINGRULEROWID, $fittingrulerowid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fittingrulerowid['max'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_FITTINGRULEROWID, $fittingrulerowid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterRuleTableMap::COL_FITTINGRULEROWID, $fittingrulerowid, $comparison);
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
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterByInd3x($ind3x = null, $comparison = null)
    {
        if (is_array($ind3x)) {
            $useMinMax = false;
            if (isset($ind3x['min'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_IND3X, $ind3x['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ind3x['max'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_IND3X, $ind3x['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterRuleTableMap::COL_IND3X, $ind3x, $comparison);
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
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterByConcatenation($concatenation = null, $comparison = null)
    {
        if (is_array($concatenation)) {
            $useMinMax = false;
            if (isset($concatenation['min'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_CONCATENATION, $concatenation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($concatenation['max'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_CONCATENATION, $concatenation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterRuleTableMap::COL_CONCATENATION, $concatenation, $comparison);
    }

    /**
     * Filter the query on the itemFilterDefId column
     *
     * Example usage:
     * <code>
     * $query->filterByItemfilterdefid(1234); // WHERE itemFilterDefId = 1234
     * $query->filterByItemfilterdefid(array(12, 34)); // WHERE itemFilterDefId IN (12, 34)
     * $query->filterByItemfilterdefid(array('min' => 12)); // WHERE itemFilterDefId > 12
     * </code>
     *
     * @see       filterByItemFilterDef()
     *
     * @param     mixed $itemfilterdefid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterByItemfilterdefid($itemfilterdefid = null, $comparison = null)
    {
        if (is_array($itemfilterdefid)) {
            $useMinMax = false;
            if (isset($itemfilterdefid['min'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_ITEMFILTERDEFID, $itemfilterdefid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemfilterdefid['max'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_ITEMFILTERDEFID, $itemfilterdefid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterRuleTableMap::COL_ITEMFILTERDEFID, $itemfilterdefid, $comparison);
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
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterByComparison($comparison = null, $comparison = null)
    {
        if (is_array($comparison)) {
            $useMinMax = false;
            if (isset($comparison['min'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_COMPARISON, $comparison['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($comparison['max'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_COMPARISON, $comparison['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterRuleTableMap::COL_COMPARISON, $comparison, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue');   // WHERE value = 'fooValue'
     * $query->filterByValue('%fooValue%'); // WHERE value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $value The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($value)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $value)) {
                $value = str_replace('*', '%', $value);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemFilterRuleTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the content1 column
     *
     * Example usage:
     * <code>
     * $query->filterByContent1(1234); // WHERE content1 = 1234
     * $query->filterByContent1(array(12, 34)); // WHERE content1 IN (12, 34)
     * $query->filterByContent1(array('min' => 12)); // WHERE content1 > 12
     * </code>
     *
     * @param     mixed $content1 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterByContent1($content1 = null, $comparison = null)
    {
        if (is_array($content1)) {
            $useMinMax = false;
            if (isset($content1['min'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_CONTENT1, $content1['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($content1['max'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_CONTENT1, $content1['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterRuleTableMap::COL_CONTENT1, $content1, $comparison);
    }

    /**
     * Filter the query on the content2 column
     *
     * Example usage:
     * <code>
     * $query->filterByContent2(1234); // WHERE content2 = 1234
     * $query->filterByContent2(array(12, 34)); // WHERE content2 IN (12, 34)
     * $query->filterByContent2(array('min' => 12)); // WHERE content2 > 12
     * </code>
     *
     * @param     mixed $content2 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterByContent2($content2 = null, $comparison = null)
    {
        if (is_array($content2)) {
            $useMinMax = false;
            if (isset($content2['min'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_CONTENT2, $content2['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($content2['max'])) {
                $this->addUsingAlias(ItemFilterRuleTableMap::COL_CONTENT2, $content2['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterRuleTableMap::COL_CONTENT2, $content2, $comparison);
    }

    /**
     * Filter the query by a related \ECP\FittingRuleRow object
     *
     * @param \ECP\FittingRuleRow|ObjectCollection $fittingRuleRow The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterByFittingRuleRow($fittingRuleRow, $comparison = null)
    {
        if ($fittingRuleRow instanceof \ECP\FittingRuleRow) {
            return $this
                ->addUsingAlias(ItemFilterRuleTableMap::COL_FITTINGRULEROWID, $fittingRuleRow->getId(), $comparison);
        } elseif ($fittingRuleRow instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemFilterRuleTableMap::COL_FITTINGRULEROWID, $fittingRuleRow->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFittingRuleRow() only accepts arguments of type \ECP\FittingRuleRow or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FittingRuleRow relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function joinFittingRuleRow($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FittingRuleRow');

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
            $this->addJoinObject($join, 'FittingRuleRow');
        }

        return $this;
    }

    /**
     * Use the FittingRuleRow relation FittingRuleRow object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\FittingRuleRowQuery A secondary query class using the current class as primary query
     */
    public function useFittingRuleRowQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFittingRuleRow($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FittingRuleRow', '\ECP\FittingRuleRowQuery');
    }

    /**
     * Filter the query by a related \ECP\Comparison object
     *
     * @param \ECP\Comparison|ObjectCollection $comparison The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterByconcatenationObj($comparison, $comparison = null)
    {
        if ($comparison instanceof \ECP\Comparison) {
            return $this
                ->addUsingAlias(ItemFilterRuleTableMap::COL_CONCATENATION, $comparison->getId(), $comparison);
        } elseif ($comparison instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemFilterRuleTableMap::COL_CONCATENATION, $comparison->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
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
     * Filter the query by a related \ECP\ItemFilterDef object
     *
     * @param \ECP\ItemFilterDef|ObjectCollection $itemFilterDef The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterByItemFilterDef($itemFilterDef, $comparison = null)
    {
        if ($itemFilterDef instanceof \ECP\ItemFilterDef) {
            return $this
                ->addUsingAlias(ItemFilterRuleTableMap::COL_ITEMFILTERDEFID, $itemFilterDef->getId(), $comparison);
        } elseif ($itemFilterDef instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemFilterRuleTableMap::COL_ITEMFILTERDEFID, $itemFilterDef->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
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
     * Filter the query by a related \ECP\Comparison object
     *
     * @param \ECP\Comparison|ObjectCollection $comparison The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function filterBycomparisonObj($comparison, $comparison = null)
    {
        if ($comparison instanceof \ECP\Comparison) {
            return $this
                ->addUsingAlias(ItemFilterRuleTableMap::COL_COMPARISON, $comparison->getId(), $comparison);
        } elseif ($comparison instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemFilterRuleTableMap::COL_COMPARISON, $comparison->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
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
     * @param   ChildItemFilterRule $itemFilterRule Object to remove from the list of results
     *
     * @return $this|ChildItemFilterRuleQuery The current query, for fluid interface
     */
    public function prune($itemFilterRule = null)
    {
        if ($itemFilterRule) {
            $this->addUsingAlias(ItemFilterRuleTableMap::COL_ID, $itemFilterRule->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the itemfilterrule table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemFilterRuleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ItemFilterRuleTableMap::clearInstancePool();
            ItemFilterRuleTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemFilterRuleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ItemFilterRuleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ItemFilterRuleTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ItemFilterRuleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ItemFilterRuleQuery
