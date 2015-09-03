<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\ItemFilterDef as ChildItemFilterDef;
use ECP\ItemFilterDefQuery as ChildItemFilterDefQuery;
use ECP\Map\ItemFilterDefTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'itemfilterdef' table.
 *
 * 
 *
 * @method     ChildItemFilterDefQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildItemFilterDefQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildItemFilterDefQuery orderByTypeid($order = Criteria::ASC) Order by the typeId column
 * @method     ChildItemFilterDefQuery orderByMin($order = Criteria::ASC) Order by the min column
 * @method     ChildItemFilterDefQuery orderByMax($order = Criteria::ASC) Order by the max column
 * @method     ChildItemFilterDefQuery orderByMinlength($order = Criteria::ASC) Order by the minlength column
 * @method     ChildItemFilterDefQuery orderByMaxlength($order = Criteria::ASC) Order by the maxlength column
 * @method     ChildItemFilterDefQuery orderByDepth($order = Criteria::ASC) Order by the depth column
 *
 * @method     ChildItemFilterDefQuery groupById() Group by the id column
 * @method     ChildItemFilterDefQuery groupByName() Group by the name column
 * @method     ChildItemFilterDefQuery groupByTypeid() Group by the typeId column
 * @method     ChildItemFilterDefQuery groupByMin() Group by the min column
 * @method     ChildItemFilterDefQuery groupByMax() Group by the max column
 * @method     ChildItemFilterDefQuery groupByMinlength() Group by the minlength column
 * @method     ChildItemFilterDefQuery groupByMaxlength() Group by the maxlength column
 * @method     ChildItemFilterDefQuery groupByDepth() Group by the depth column
 *
 * @method     ChildItemFilterDefQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemFilterDefQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemFilterDefQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemFilterDefQuery leftJoinType($relationAlias = null) Adds a LEFT JOIN clause to the query using the Type relation
 * @method     ChildItemFilterDefQuery rightJoinType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Type relation
 * @method     ChildItemFilterDefQuery innerJoinType($relationAlias = null) Adds a INNER JOIN clause to the query using the Type relation
 *
 * @method     ChildItemFilterDefQuery leftJoinItemFilterRule($relationAlias = null) Adds a LEFT JOIN clause to the query using the ItemFilterRule relation
 * @method     ChildItemFilterDefQuery rightJoinItemFilterRule($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ItemFilterRule relation
 * @method     ChildItemFilterDefQuery innerJoinItemFilterRule($relationAlias = null) Adds a INNER JOIN clause to the query using the ItemFilterRule relation
 *
 * @method     \ECP\TypeQuery|\ECP\ItemFilterRuleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildItemFilterDef findOne(ConnectionInterface $con = null) Return the first ChildItemFilterDef matching the query
 * @method     ChildItemFilterDef findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItemFilterDef matching the query, or a new ChildItemFilterDef object populated from the query conditions when no match is found
 *
 * @method     ChildItemFilterDef findOneById(int $id) Return the first ChildItemFilterDef filtered by the id column
 * @method     ChildItemFilterDef findOneByName(string $name) Return the first ChildItemFilterDef filtered by the name column
 * @method     ChildItemFilterDef findOneByTypeid(int $typeId) Return the first ChildItemFilterDef filtered by the typeId column
 * @method     ChildItemFilterDef findOneByMin(int $min) Return the first ChildItemFilterDef filtered by the min column
 * @method     ChildItemFilterDef findOneByMax(int $max) Return the first ChildItemFilterDef filtered by the max column
 * @method     ChildItemFilterDef findOneByMinlength(int $minlength) Return the first ChildItemFilterDef filtered by the minlength column
 * @method     ChildItemFilterDef findOneByMaxlength(int $maxlength) Return the first ChildItemFilterDef filtered by the maxlength column
 * @method     ChildItemFilterDef findOneByDepth(int $depth) Return the first ChildItemFilterDef filtered by the depth column *

 * @method     ChildItemFilterDef requirePk($key, ConnectionInterface $con = null) Return the ChildItemFilterDef by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterDef requireOne(ConnectionInterface $con = null) Return the first ChildItemFilterDef matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemFilterDef requireOneById(int $id) Return the first ChildItemFilterDef filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterDef requireOneByName(string $name) Return the first ChildItemFilterDef filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterDef requireOneByTypeid(int $typeId) Return the first ChildItemFilterDef filtered by the typeId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterDef requireOneByMin(int $min) Return the first ChildItemFilterDef filtered by the min column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterDef requireOneByMax(int $max) Return the first ChildItemFilterDef filtered by the max column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterDef requireOneByMinlength(int $minlength) Return the first ChildItemFilterDef filtered by the minlength column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterDef requireOneByMaxlength(int $maxlength) Return the first ChildItemFilterDef filtered by the maxlength column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemFilterDef requireOneByDepth(int $depth) Return the first ChildItemFilterDef filtered by the depth column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemFilterDef[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItemFilterDef objects based on current ModelCriteria
 * @method     ChildItemFilterDef[]|ObjectCollection findById(int $id) Return ChildItemFilterDef objects filtered by the id column
 * @method     ChildItemFilterDef[]|ObjectCollection findByName(string $name) Return ChildItemFilterDef objects filtered by the name column
 * @method     ChildItemFilterDef[]|ObjectCollection findByTypeid(int $typeId) Return ChildItemFilterDef objects filtered by the typeId column
 * @method     ChildItemFilterDef[]|ObjectCollection findByMin(int $min) Return ChildItemFilterDef objects filtered by the min column
 * @method     ChildItemFilterDef[]|ObjectCollection findByMax(int $max) Return ChildItemFilterDef objects filtered by the max column
 * @method     ChildItemFilterDef[]|ObjectCollection findByMinlength(int $minlength) Return ChildItemFilterDef objects filtered by the minlength column
 * @method     ChildItemFilterDef[]|ObjectCollection findByMaxlength(int $maxlength) Return ChildItemFilterDef objects filtered by the maxlength column
 * @method     ChildItemFilterDef[]|ObjectCollection findByDepth(int $depth) Return ChildItemFilterDef objects filtered by the depth column
 * @method     ChildItemFilterDef[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemFilterDefQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\ItemFilterDefQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\ItemFilterDef', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildItemFilterDefQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildItemFilterDefQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildItemFilterDefQuery) {
            return $criteria;
        }
        $query = new ChildItemFilterDefQuery();
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
     * @return ChildItemFilterDef|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ItemFilterDefTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemFilterDefTableMap::DATABASE_NAME);
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
     * @return ChildItemFilterDef A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, typeId, min, max, minlength, maxlength, depth FROM itemfilterdef WHERE id = :p0';
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
            /** @var ChildItemFilterDef $obj */
            $obj = new ChildItemFilterDef();
            $obj->hydrate($row);
            ItemFilterDefTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildItemFilterDef|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildItemFilterDefQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ItemFilterDefTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildItemFilterDefQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ItemFilterDefTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildItemFilterDefQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ItemFilterDefTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ItemFilterDefTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterDefTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildItemFilterDefQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ItemFilterDefTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildItemFilterDefQuery The current query, for fluid interface
     */
    public function filterByTypeid($typeid = null, $comparison = null)
    {
        if (is_array($typeid)) {
            $useMinMax = false;
            if (isset($typeid['min'])) {
                $this->addUsingAlias(ItemFilterDefTableMap::COL_TYPEID, $typeid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeid['max'])) {
                $this->addUsingAlias(ItemFilterDefTableMap::COL_TYPEID, $typeid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterDefTableMap::COL_TYPEID, $typeid, $comparison);
    }

    /**
     * Filter the query on the min column
     *
     * Example usage:
     * <code>
     * $query->filterByMin(1234); // WHERE min = 1234
     * $query->filterByMin(array(12, 34)); // WHERE min IN (12, 34)
     * $query->filterByMin(array('min' => 12)); // WHERE min > 12
     * </code>
     *
     * @param     mixed $min The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemFilterDefQuery The current query, for fluid interface
     */
    public function filterByMin($min = null, $comparison = null)
    {
        if (is_array($min)) {
            $useMinMax = false;
            if (isset($min['min'])) {
                $this->addUsingAlias(ItemFilterDefTableMap::COL_MIN, $min['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($min['max'])) {
                $this->addUsingAlias(ItemFilterDefTableMap::COL_MIN, $min['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterDefTableMap::COL_MIN, $min, $comparison);
    }

    /**
     * Filter the query on the max column
     *
     * Example usage:
     * <code>
     * $query->filterByMax(1234); // WHERE max = 1234
     * $query->filterByMax(array(12, 34)); // WHERE max IN (12, 34)
     * $query->filterByMax(array('min' => 12)); // WHERE max > 12
     * </code>
     *
     * @param     mixed $max The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemFilterDefQuery The current query, for fluid interface
     */
    public function filterByMax($max = null, $comparison = null)
    {
        if (is_array($max)) {
            $useMinMax = false;
            if (isset($max['min'])) {
                $this->addUsingAlias(ItemFilterDefTableMap::COL_MAX, $max['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($max['max'])) {
                $this->addUsingAlias(ItemFilterDefTableMap::COL_MAX, $max['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterDefTableMap::COL_MAX, $max, $comparison);
    }

    /**
     * Filter the query on the minlength column
     *
     * Example usage:
     * <code>
     * $query->filterByMinlength(1234); // WHERE minlength = 1234
     * $query->filterByMinlength(array(12, 34)); // WHERE minlength IN (12, 34)
     * $query->filterByMinlength(array('min' => 12)); // WHERE minlength > 12
     * </code>
     *
     * @param     mixed $minlength The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemFilterDefQuery The current query, for fluid interface
     */
    public function filterByMinlength($minlength = null, $comparison = null)
    {
        if (is_array($minlength)) {
            $useMinMax = false;
            if (isset($minlength['min'])) {
                $this->addUsingAlias(ItemFilterDefTableMap::COL_MINLENGTH, $minlength['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($minlength['max'])) {
                $this->addUsingAlias(ItemFilterDefTableMap::COL_MINLENGTH, $minlength['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterDefTableMap::COL_MINLENGTH, $minlength, $comparison);
    }

    /**
     * Filter the query on the maxlength column
     *
     * Example usage:
     * <code>
     * $query->filterByMaxlength(1234); // WHERE maxlength = 1234
     * $query->filterByMaxlength(array(12, 34)); // WHERE maxlength IN (12, 34)
     * $query->filterByMaxlength(array('min' => 12)); // WHERE maxlength > 12
     * </code>
     *
     * @param     mixed $maxlength The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemFilterDefQuery The current query, for fluid interface
     */
    public function filterByMaxlength($maxlength = null, $comparison = null)
    {
        if (is_array($maxlength)) {
            $useMinMax = false;
            if (isset($maxlength['min'])) {
                $this->addUsingAlias(ItemFilterDefTableMap::COL_MAXLENGTH, $maxlength['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($maxlength['max'])) {
                $this->addUsingAlias(ItemFilterDefTableMap::COL_MAXLENGTH, $maxlength['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterDefTableMap::COL_MAXLENGTH, $maxlength, $comparison);
    }

    /**
     * Filter the query on the depth column
     *
     * Example usage:
     * <code>
     * $query->filterByDepth(1234); // WHERE depth = 1234
     * $query->filterByDepth(array(12, 34)); // WHERE depth IN (12, 34)
     * $query->filterByDepth(array('min' => 12)); // WHERE depth > 12
     * </code>
     *
     * @param     mixed $depth The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemFilterDefQuery The current query, for fluid interface
     */
    public function filterByDepth($depth = null, $comparison = null)
    {
        if (is_array($depth)) {
            $useMinMax = false;
            if (isset($depth['min'])) {
                $this->addUsingAlias(ItemFilterDefTableMap::COL_DEPTH, $depth['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($depth['max'])) {
                $this->addUsingAlias(ItemFilterDefTableMap::COL_DEPTH, $depth['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemFilterDefTableMap::COL_DEPTH, $depth, $comparison);
    }

    /**
     * Filter the query by a related \ECP\Type object
     *
     * @param \ECP\Type|ObjectCollection $type The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemFilterDefQuery The current query, for fluid interface
     */
    public function filterByType($type, $comparison = null)
    {
        if ($type instanceof \ECP\Type) {
            return $this
                ->addUsingAlias(ItemFilterDefTableMap::COL_TYPEID, $type->getId(), $comparison);
        } elseif ($type instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemFilterDefTableMap::COL_TYPEID, $type->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildItemFilterDefQuery The current query, for fluid interface
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
     * Filter the query by a related \ECP\ItemFilterRule object
     *
     * @param \ECP\ItemFilterRule|ObjectCollection $itemFilterRule the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemFilterDefQuery The current query, for fluid interface
     */
    public function filterByItemFilterRule($itemFilterRule, $comparison = null)
    {
        if ($itemFilterRule instanceof \ECP\ItemFilterRule) {
            return $this
                ->addUsingAlias(ItemFilterDefTableMap::COL_ID, $itemFilterRule->getItemfilterdefid(), $comparison);
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
     * @return $this|ChildItemFilterDefQuery The current query, for fluid interface
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
     * @param   ChildItemFilterDef $itemFilterDef Object to remove from the list of results
     *
     * @return $this|ChildItemFilterDefQuery The current query, for fluid interface
     */
    public function prune($itemFilterDef = null)
    {
        if ($itemFilterDef) {
            $this->addUsingAlias(ItemFilterDefTableMap::COL_ID, $itemFilterDef->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the itemfilterdef table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemFilterDefTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ItemFilterDefTableMap::clearInstancePool();
            ItemFilterDefTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemFilterDefTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ItemFilterDefTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ItemFilterDefTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ItemFilterDefTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ItemFilterDefQuery
