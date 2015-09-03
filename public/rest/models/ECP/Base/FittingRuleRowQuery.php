<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\FittingRuleRow as ChildFittingRuleRow;
use ECP\FittingRuleRowQuery as ChildFittingRuleRowQuery;
use ECP\Map\FittingRuleRowTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'fittingrulerow' table.
 *
 * 
 *
 * @method     ChildFittingRuleRowQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFittingRuleRowQuery orderByFittingruleentityid($order = Criteria::ASC) Order by the fittingRuleEntityId column
 * @method     ChildFittingRuleRowQuery orderByInd3x($order = Criteria::ASC) Order by the ind3x column
 * @method     ChildFittingRuleRowQuery orderByConcatenation($order = Criteria::ASC) Order by the concatenation column
 * @method     ChildFittingRuleRowQuery orderByComparison($order = Criteria::ASC) Order by the comparison column
 * @method     ChildFittingRuleRowQuery orderByValue($order = Criteria::ASC) Order by the value column
 *
 * @method     ChildFittingRuleRowQuery groupById() Group by the id column
 * @method     ChildFittingRuleRowQuery groupByFittingruleentityid() Group by the fittingRuleEntityId column
 * @method     ChildFittingRuleRowQuery groupByInd3x() Group by the ind3x column
 * @method     ChildFittingRuleRowQuery groupByConcatenation() Group by the concatenation column
 * @method     ChildFittingRuleRowQuery groupByComparison() Group by the comparison column
 * @method     ChildFittingRuleRowQuery groupByValue() Group by the value column
 *
 * @method     ChildFittingRuleRowQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFittingRuleRowQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFittingRuleRowQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFittingRuleRowQuery leftJoinFittingRuleEntity($relationAlias = null) Adds a LEFT JOIN clause to the query using the FittingRuleEntity relation
 * @method     ChildFittingRuleRowQuery rightJoinFittingRuleEntity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FittingRuleEntity relation
 * @method     ChildFittingRuleRowQuery innerJoinFittingRuleEntity($relationAlias = null) Adds a INNER JOIN clause to the query using the FittingRuleEntity relation
 *
 * @method     ChildFittingRuleRowQuery leftJoinconcatenationObj($relationAlias = null) Adds a LEFT JOIN clause to the query using the concatenationObj relation
 * @method     ChildFittingRuleRowQuery rightJoinconcatenationObj($relationAlias = null) Adds a RIGHT JOIN clause to the query using the concatenationObj relation
 * @method     ChildFittingRuleRowQuery innerJoinconcatenationObj($relationAlias = null) Adds a INNER JOIN clause to the query using the concatenationObj relation
 *
 * @method     ChildFittingRuleRowQuery leftJoincomparisonObj($relationAlias = null) Adds a LEFT JOIN clause to the query using the comparisonObj relation
 * @method     ChildFittingRuleRowQuery rightJoincomparisonObj($relationAlias = null) Adds a RIGHT JOIN clause to the query using the comparisonObj relation
 * @method     ChildFittingRuleRowQuery innerJoincomparisonObj($relationAlias = null) Adds a INNER JOIN clause to the query using the comparisonObj relation
 *
 * @method     ChildFittingRuleRowQuery leftJoinItemFilterRule($relationAlias = null) Adds a LEFT JOIN clause to the query using the ItemFilterRule relation
 * @method     ChildFittingRuleRowQuery rightJoinItemFilterRule($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ItemFilterRule relation
 * @method     ChildFittingRuleRowQuery innerJoinItemFilterRule($relationAlias = null) Adds a INNER JOIN clause to the query using the ItemFilterRule relation
 *
 * @method     \ECP\FittingRuleEntityQuery|\ECP\ComparisonQuery|\ECP\ItemFilterRuleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildFittingRuleRow findOne(ConnectionInterface $con = null) Return the first ChildFittingRuleRow matching the query
 * @method     ChildFittingRuleRow findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFittingRuleRow matching the query, or a new ChildFittingRuleRow object populated from the query conditions when no match is found
 *
 * @method     ChildFittingRuleRow findOneById(int $id) Return the first ChildFittingRuleRow filtered by the id column
 * @method     ChildFittingRuleRow findOneByFittingruleentityid(int $fittingRuleEntityId) Return the first ChildFittingRuleRow filtered by the fittingRuleEntityId column
 * @method     ChildFittingRuleRow findOneByInd3x(int $ind3x) Return the first ChildFittingRuleRow filtered by the ind3x column
 * @method     ChildFittingRuleRow findOneByConcatenation(int $concatenation) Return the first ChildFittingRuleRow filtered by the concatenation column
 * @method     ChildFittingRuleRow findOneByComparison(int $comparison) Return the first ChildFittingRuleRow filtered by the comparison column
 * @method     ChildFittingRuleRow findOneByValue(int $value) Return the first ChildFittingRuleRow filtered by the value column *

 * @method     ChildFittingRuleRow requirePk($key, ConnectionInterface $con = null) Return the ChildFittingRuleRow by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFittingRuleRow requireOne(ConnectionInterface $con = null) Return the first ChildFittingRuleRow matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFittingRuleRow requireOneById(int $id) Return the first ChildFittingRuleRow filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFittingRuleRow requireOneByFittingruleentityid(int $fittingRuleEntityId) Return the first ChildFittingRuleRow filtered by the fittingRuleEntityId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFittingRuleRow requireOneByInd3x(int $ind3x) Return the first ChildFittingRuleRow filtered by the ind3x column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFittingRuleRow requireOneByConcatenation(int $concatenation) Return the first ChildFittingRuleRow filtered by the concatenation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFittingRuleRow requireOneByComparison(int $comparison) Return the first ChildFittingRuleRow filtered by the comparison column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFittingRuleRow requireOneByValue(int $value) Return the first ChildFittingRuleRow filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFittingRuleRow[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFittingRuleRow objects based on current ModelCriteria
 * @method     ChildFittingRuleRow[]|ObjectCollection findById(int $id) Return ChildFittingRuleRow objects filtered by the id column
 * @method     ChildFittingRuleRow[]|ObjectCollection findByFittingruleentityid(int $fittingRuleEntityId) Return ChildFittingRuleRow objects filtered by the fittingRuleEntityId column
 * @method     ChildFittingRuleRow[]|ObjectCollection findByInd3x(int $ind3x) Return ChildFittingRuleRow objects filtered by the ind3x column
 * @method     ChildFittingRuleRow[]|ObjectCollection findByConcatenation(int $concatenation) Return ChildFittingRuleRow objects filtered by the concatenation column
 * @method     ChildFittingRuleRow[]|ObjectCollection findByComparison(int $comparison) Return ChildFittingRuleRow objects filtered by the comparison column
 * @method     ChildFittingRuleRow[]|ObjectCollection findByValue(int $value) Return ChildFittingRuleRow objects filtered by the value column
 * @method     ChildFittingRuleRow[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FittingRuleRowQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\FittingRuleRowQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\FittingRuleRow', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFittingRuleRowQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFittingRuleRowQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFittingRuleRowQuery) {
            return $criteria;
        }
        $query = new ChildFittingRuleRowQuery();
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
     * @return ChildFittingRuleRow|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FittingRuleRowTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FittingRuleRowTableMap::DATABASE_NAME);
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
     * @return ChildFittingRuleRow A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, fittingRuleEntityId, ind3x, concatenation, comparison, value FROM fittingrulerow WHERE id = :p0';
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
            /** @var ChildFittingRuleRow $obj */
            $obj = new ChildFittingRuleRow();
            $obj->hydrate($row);
            FittingRuleRowTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildFittingRuleRow|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildFittingRuleRowQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FittingRuleRowTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFittingRuleRowQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FittingRuleRowTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildFittingRuleRowQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FittingRuleRowTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FittingRuleRowTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FittingRuleRowTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildFittingRuleRowQuery The current query, for fluid interface
     */
    public function filterByFittingruleentityid($fittingruleentityid = null, $comparison = null)
    {
        if (is_array($fittingruleentityid)) {
            $useMinMax = false;
            if (isset($fittingruleentityid['min'])) {
                $this->addUsingAlias(FittingRuleRowTableMap::COL_FITTINGRULEENTITYID, $fittingruleentityid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fittingruleentityid['max'])) {
                $this->addUsingAlias(FittingRuleRowTableMap::COL_FITTINGRULEENTITYID, $fittingruleentityid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FittingRuleRowTableMap::COL_FITTINGRULEENTITYID, $fittingruleentityid, $comparison);
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
     * @return $this|ChildFittingRuleRowQuery The current query, for fluid interface
     */
    public function filterByInd3x($ind3x = null, $comparison = null)
    {
        if (is_array($ind3x)) {
            $useMinMax = false;
            if (isset($ind3x['min'])) {
                $this->addUsingAlias(FittingRuleRowTableMap::COL_IND3X, $ind3x['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ind3x['max'])) {
                $this->addUsingAlias(FittingRuleRowTableMap::COL_IND3X, $ind3x['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FittingRuleRowTableMap::COL_IND3X, $ind3x, $comparison);
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
     * @return $this|ChildFittingRuleRowQuery The current query, for fluid interface
     */
    public function filterByConcatenation($concatenation = null, $comparison = null)
    {
        if (is_array($concatenation)) {
            $useMinMax = false;
            if (isset($concatenation['min'])) {
                $this->addUsingAlias(FittingRuleRowTableMap::COL_CONCATENATION, $concatenation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($concatenation['max'])) {
                $this->addUsingAlias(FittingRuleRowTableMap::COL_CONCATENATION, $concatenation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FittingRuleRowTableMap::COL_CONCATENATION, $concatenation, $comparison);
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
     * @return $this|ChildFittingRuleRowQuery The current query, for fluid interface
     */
    public function filterByComparison($comparison = null, $comparison = null)
    {
        if (is_array($comparison)) {
            $useMinMax = false;
            if (isset($comparison['min'])) {
                $this->addUsingAlias(FittingRuleRowTableMap::COL_COMPARISON, $comparison['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($comparison['max'])) {
                $this->addUsingAlias(FittingRuleRowTableMap::COL_COMPARISON, $comparison['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FittingRuleRowTableMap::COL_COMPARISON, $comparison, $comparison);
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
     * @return $this|ChildFittingRuleRowQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(FittingRuleRowTableMap::COL_VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(FittingRuleRowTableMap::COL_VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FittingRuleRowTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query by a related \ECP\FittingRuleEntity object
     *
     * @param \ECP\FittingRuleEntity|ObjectCollection $fittingRuleEntity The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFittingRuleRowQuery The current query, for fluid interface
     */
    public function filterByFittingRuleEntity($fittingRuleEntity, $comparison = null)
    {
        if ($fittingRuleEntity instanceof \ECP\FittingRuleEntity) {
            return $this
                ->addUsingAlias(FittingRuleRowTableMap::COL_FITTINGRULEENTITYID, $fittingRuleEntity->getId(), $comparison);
        } elseif ($fittingRuleEntity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FittingRuleRowTableMap::COL_FITTINGRULEENTITYID, $fittingRuleEntity->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildFittingRuleRowQuery The current query, for fluid interface
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
     * @return ChildFittingRuleRowQuery The current query, for fluid interface
     */
    public function filterByconcatenationObj($comparison, $comparison = null)
    {
        if ($comparison instanceof \ECP\Comparison) {
            return $this
                ->addUsingAlias(FittingRuleRowTableMap::COL_CONCATENATION, $comparison->getId(), $comparison);
        } elseif ($comparison instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FittingRuleRowTableMap::COL_CONCATENATION, $comparison->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildFittingRuleRowQuery The current query, for fluid interface
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
     * Filter the query by a related \ECP\Comparison object
     *
     * @param \ECP\Comparison|ObjectCollection $comparison The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFittingRuleRowQuery The current query, for fluid interface
     */
    public function filterBycomparisonObj($comparison, $comparison = null)
    {
        if ($comparison instanceof \ECP\Comparison) {
            return $this
                ->addUsingAlias(FittingRuleRowTableMap::COL_COMPARISON, $comparison->getId(), $comparison);
        } elseif ($comparison instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FittingRuleRowTableMap::COL_COMPARISON, $comparison->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildFittingRuleRowQuery The current query, for fluid interface
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
     * Filter the query by a related \ECP\ItemFilterRule object
     *
     * @param \ECP\ItemFilterRule|ObjectCollection $itemFilterRule the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFittingRuleRowQuery The current query, for fluid interface
     */
    public function filterByItemFilterRule($itemFilterRule, $comparison = null)
    {
        if ($itemFilterRule instanceof \ECP\ItemFilterRule) {
            return $this
                ->addUsingAlias(FittingRuleRowTableMap::COL_ID, $itemFilterRule->getFittingrulerowid(), $comparison);
        } elseif ($itemFilterRule instanceof ObjectCollection) {
            return $this
                ->useItemFilterRuleQuery()
                ->filterByPrimaryKeys($itemFilterRule->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByItemFilterRule() only accepts arguments of type \ECP\ItemFilterRule or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ItemFilterRule relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFittingRuleRowQuery The current query, for fluid interface
     */
    public function joinItemFilterRule($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ItemFilterRule');

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
            $this->addJoinObject($join, 'ItemFilterRule');
        }

        return $this;
    }

    /**
     * Use the ItemFilterRule relation ItemFilterRule object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\ItemFilterRuleQuery A secondary query class using the current class as primary query
     */
    public function useItemFilterRuleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItemFilterRule($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ItemFilterRule', '\ECP\ItemFilterRuleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFittingRuleRow $fittingRuleRow Object to remove from the list of results
     *
     * @return $this|ChildFittingRuleRowQuery The current query, for fluid interface
     */
    public function prune($fittingRuleRow = null)
    {
        if ($fittingRuleRow) {
            $this->addUsingAlias(FittingRuleRowTableMap::COL_ID, $fittingRuleRow->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fittingrulerow table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FittingRuleRowTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FittingRuleRowTableMap::clearInstancePool();
            FittingRuleRowTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(FittingRuleRowTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FittingRuleRowTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            FittingRuleRowTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            FittingRuleRowTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FittingRuleRowQuery
