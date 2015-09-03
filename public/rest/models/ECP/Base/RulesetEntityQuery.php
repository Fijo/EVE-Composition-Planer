<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\RulesetEntity as ChildRulesetEntity;
use ECP\RulesetEntityQuery as ChildRulesetEntityQuery;
use ECP\Map\RulesetEntityTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'rulesetentity' table.
 *
 * 
 *
 * @method     ChildRulesetEntityQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRulesetEntityQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildRulesetEntityQuery orderByUserid($order = Criteria::ASC) Order by the userId column
 * @method     ChildRulesetEntityQuery orderByIslisted($order = Criteria::ASC) Order by the isListed column
 * @method     ChildRulesetEntityQuery orderByForkedid($order = Criteria::ASC) Order by the forkedId column
 * @method     ChildRulesetEntityQuery orderByMinpilots($order = Criteria::ASC) Order by the minPilots column
 * @method     ChildRulesetEntityQuery orderByMaxpilots($order = Criteria::ASC) Order by the maxPilots column
 * @method     ChildRulesetEntityQuery orderByMaxpoints($order = Criteria::ASC) Order by the maxPoints column
 * @method     ChildRulesetEntityQuery orderByLastmodified($order = Criteria::ASC) Order by the lastModified column
 *
 * @method     ChildRulesetEntityQuery groupById() Group by the id column
 * @method     ChildRulesetEntityQuery groupByName() Group by the name column
 * @method     ChildRulesetEntityQuery groupByUserid() Group by the userId column
 * @method     ChildRulesetEntityQuery groupByIslisted() Group by the isListed column
 * @method     ChildRulesetEntityQuery groupByForkedid() Group by the forkedId column
 * @method     ChildRulesetEntityQuery groupByMinpilots() Group by the minPilots column
 * @method     ChildRulesetEntityQuery groupByMaxpilots() Group by the maxPilots column
 * @method     ChildRulesetEntityQuery groupByMaxpoints() Group by the maxPoints column
 * @method     ChildRulesetEntityQuery groupByLastmodified() Group by the lastModified column
 *
 * @method     ChildRulesetEntityQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRulesetEntityQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRulesetEntityQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRulesetEntityQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildRulesetEntityQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildRulesetEntityQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildRulesetEntityQuery leftJoinRulesetEntityRelatedByForkedid($relationAlias = null) Adds a LEFT JOIN clause to the query using the RulesetEntityRelatedByForkedid relation
 * @method     ChildRulesetEntityQuery rightJoinRulesetEntityRelatedByForkedid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RulesetEntityRelatedByForkedid relation
 * @method     ChildRulesetEntityQuery innerJoinRulesetEntityRelatedByForkedid($relationAlias = null) Adds a INNER JOIN clause to the query using the RulesetEntityRelatedByForkedid relation
 *
 * @method     ChildRulesetEntityQuery leftJoinRulesetEntityRelatedById($relationAlias = null) Adds a LEFT JOIN clause to the query using the RulesetEntityRelatedById relation
 * @method     ChildRulesetEntityQuery rightJoinRulesetEntityRelatedById($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RulesetEntityRelatedById relation
 * @method     ChildRulesetEntityQuery innerJoinRulesetEntityRelatedById($relationAlias = null) Adds a INNER JOIN clause to the query using the RulesetEntityRelatedById relation
 *
 * @method     ChildRulesetEntityQuery leftJoinRulesetShip($relationAlias = null) Adds a LEFT JOIN clause to the query using the RulesetShip relation
 * @method     ChildRulesetEntityQuery rightJoinRulesetShip($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RulesetShip relation
 * @method     ChildRulesetEntityQuery innerJoinRulesetShip($relationAlias = null) Adds a INNER JOIN clause to the query using the RulesetShip relation
 *
 * @method     ChildRulesetEntityQuery leftJoinRulesetRuleRow($relationAlias = null) Adds a LEFT JOIN clause to the query using the RulesetRuleRow relation
 * @method     ChildRulesetEntityQuery rightJoinRulesetRuleRow($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RulesetRuleRow relation
 * @method     ChildRulesetEntityQuery innerJoinRulesetRuleRow($relationAlias = null) Adds a INNER JOIN clause to the query using the RulesetRuleRow relation
 *
 * @method     ChildRulesetEntityQuery leftJoinCompositionEntity($relationAlias = null) Adds a LEFT JOIN clause to the query using the CompositionEntity relation
 * @method     ChildRulesetEntityQuery rightJoinCompositionEntity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CompositionEntity relation
 * @method     ChildRulesetEntityQuery innerJoinCompositionEntity($relationAlias = null) Adds a INNER JOIN clause to the query using the CompositionEntity relation
 *
 * @method     \ECP\UserQuery|\ECP\RulesetEntityQuery|\ECP\RulesetShipQuery|\ECP\RulesetRuleRowQuery|\ECP\CompositionEntityQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRulesetEntity findOne(ConnectionInterface $con = null) Return the first ChildRulesetEntity matching the query
 * @method     ChildRulesetEntity findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRulesetEntity matching the query, or a new ChildRulesetEntity object populated from the query conditions when no match is found
 *
 * @method     ChildRulesetEntity findOneById(int $id) Return the first ChildRulesetEntity filtered by the id column
 * @method     ChildRulesetEntity findOneByName(string $name) Return the first ChildRulesetEntity filtered by the name column
 * @method     ChildRulesetEntity findOneByUserid(int $userId) Return the first ChildRulesetEntity filtered by the userId column
 * @method     ChildRulesetEntity findOneByIslisted(int $isListed) Return the first ChildRulesetEntity filtered by the isListed column
 * @method     ChildRulesetEntity findOneByForkedid(int $forkedId) Return the first ChildRulesetEntity filtered by the forkedId column
 * @method     ChildRulesetEntity findOneByMinpilots(int $minPilots) Return the first ChildRulesetEntity filtered by the minPilots column
 * @method     ChildRulesetEntity findOneByMaxpilots(int $maxPilots) Return the first ChildRulesetEntity filtered by the maxPilots column
 * @method     ChildRulesetEntity findOneByMaxpoints(int $maxPoints) Return the first ChildRulesetEntity filtered by the maxPoints column
 * @method     ChildRulesetEntity findOneByLastmodified(string $lastModified) Return the first ChildRulesetEntity filtered by the lastModified column *

 * @method     ChildRulesetEntity requirePk($key, ConnectionInterface $con = null) Return the ChildRulesetEntity by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetEntity requireOne(ConnectionInterface $con = null) Return the first ChildRulesetEntity matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRulesetEntity requireOneById(int $id) Return the first ChildRulesetEntity filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetEntity requireOneByName(string $name) Return the first ChildRulesetEntity filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetEntity requireOneByUserid(int $userId) Return the first ChildRulesetEntity filtered by the userId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetEntity requireOneByIslisted(int $isListed) Return the first ChildRulesetEntity filtered by the isListed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetEntity requireOneByForkedid(int $forkedId) Return the first ChildRulesetEntity filtered by the forkedId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetEntity requireOneByMinpilots(int $minPilots) Return the first ChildRulesetEntity filtered by the minPilots column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetEntity requireOneByMaxpilots(int $maxPilots) Return the first ChildRulesetEntity filtered by the maxPilots column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetEntity requireOneByMaxpoints(int $maxPoints) Return the first ChildRulesetEntity filtered by the maxPoints column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetEntity requireOneByLastmodified(string $lastModified) Return the first ChildRulesetEntity filtered by the lastModified column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRulesetEntity[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRulesetEntity objects based on current ModelCriteria
 * @method     ChildRulesetEntity[]|ObjectCollection findById(int $id) Return ChildRulesetEntity objects filtered by the id column
 * @method     ChildRulesetEntity[]|ObjectCollection findByName(string $name) Return ChildRulesetEntity objects filtered by the name column
 * @method     ChildRulesetEntity[]|ObjectCollection findByUserid(int $userId) Return ChildRulesetEntity objects filtered by the userId column
 * @method     ChildRulesetEntity[]|ObjectCollection findByIslisted(int $isListed) Return ChildRulesetEntity objects filtered by the isListed column
 * @method     ChildRulesetEntity[]|ObjectCollection findByForkedid(int $forkedId) Return ChildRulesetEntity objects filtered by the forkedId column
 * @method     ChildRulesetEntity[]|ObjectCollection findByMinpilots(int $minPilots) Return ChildRulesetEntity objects filtered by the minPilots column
 * @method     ChildRulesetEntity[]|ObjectCollection findByMaxpilots(int $maxPilots) Return ChildRulesetEntity objects filtered by the maxPilots column
 * @method     ChildRulesetEntity[]|ObjectCollection findByMaxpoints(int $maxPoints) Return ChildRulesetEntity objects filtered by the maxPoints column
 * @method     ChildRulesetEntity[]|ObjectCollection findByLastmodified(string $lastModified) Return ChildRulesetEntity objects filtered by the lastModified column
 * @method     ChildRulesetEntity[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RulesetEntityQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\RulesetEntityQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\RulesetEntity', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRulesetEntityQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRulesetEntityQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRulesetEntityQuery) {
            return $criteria;
        }
        $query = new ChildRulesetEntityQuery();
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
     * @return ChildRulesetEntity|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RulesetEntityTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RulesetEntityTableMap::DATABASE_NAME);
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
     * @return ChildRulesetEntity A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, userId, isListed, forkedId, minPilots, maxPilots, maxPoints, lastModified FROM rulesetentity WHERE id = :p0';
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
            /** @var ChildRulesetEntity $obj */
            $obj = new ChildRulesetEntity();
            $obj->hydrate($row);
            RulesetEntityTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRulesetEntity|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RulesetEntityTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RulesetEntityTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetEntityTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
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

        return $this->addUsingAlias(RulesetEntityTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the userId column
     *
     * Example usage:
     * <code>
     * $query->filterByUserid(1234); // WHERE userId = 1234
     * $query->filterByUserid(array(12, 34)); // WHERE userId IN (12, 34)
     * $query->filterByUserid(array('min' => 12)); // WHERE userId > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetEntityTableMap::COL_USERID, $userid, $comparison);
    }

    /**
     * Filter the query on the isListed column
     *
     * Example usage:
     * <code>
     * $query->filterByIslisted(1234); // WHERE isListed = 1234
     * $query->filterByIslisted(array(12, 34)); // WHERE isListed IN (12, 34)
     * $query->filterByIslisted(array('min' => 12)); // WHERE isListed > 12
     * </code>
     *
     * @param     mixed $islisted The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByIslisted($islisted = null, $comparison = null)
    {
        if (is_array($islisted)) {
            $useMinMax = false;
            if (isset($islisted['min'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_ISLISTED, $islisted['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($islisted['max'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_ISLISTED, $islisted['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetEntityTableMap::COL_ISLISTED, $islisted, $comparison);
    }

    /**
     * Filter the query on the forkedId column
     *
     * Example usage:
     * <code>
     * $query->filterByForkedid(1234); // WHERE forkedId = 1234
     * $query->filterByForkedid(array(12, 34)); // WHERE forkedId IN (12, 34)
     * $query->filterByForkedid(array('min' => 12)); // WHERE forkedId > 12
     * </code>
     *
     * @see       filterByRulesetEntityRelatedByForkedid()
     *
     * @param     mixed $forkedid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByForkedid($forkedid = null, $comparison = null)
    {
        if (is_array($forkedid)) {
            $useMinMax = false;
            if (isset($forkedid['min'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_FORKEDID, $forkedid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($forkedid['max'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_FORKEDID, $forkedid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetEntityTableMap::COL_FORKEDID, $forkedid, $comparison);
    }

    /**
     * Filter the query on the minPilots column
     *
     * Example usage:
     * <code>
     * $query->filterByMinpilots(1234); // WHERE minPilots = 1234
     * $query->filterByMinpilots(array(12, 34)); // WHERE minPilots IN (12, 34)
     * $query->filterByMinpilots(array('min' => 12)); // WHERE minPilots > 12
     * </code>
     *
     * @param     mixed $minpilots The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByMinpilots($minpilots = null, $comparison = null)
    {
        if (is_array($minpilots)) {
            $useMinMax = false;
            if (isset($minpilots['min'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_MINPILOTS, $minpilots['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($minpilots['max'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_MINPILOTS, $minpilots['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetEntityTableMap::COL_MINPILOTS, $minpilots, $comparison);
    }

    /**
     * Filter the query on the maxPilots column
     *
     * Example usage:
     * <code>
     * $query->filterByMaxpilots(1234); // WHERE maxPilots = 1234
     * $query->filterByMaxpilots(array(12, 34)); // WHERE maxPilots IN (12, 34)
     * $query->filterByMaxpilots(array('min' => 12)); // WHERE maxPilots > 12
     * </code>
     *
     * @param     mixed $maxpilots The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByMaxpilots($maxpilots = null, $comparison = null)
    {
        if (is_array($maxpilots)) {
            $useMinMax = false;
            if (isset($maxpilots['min'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_MAXPILOTS, $maxpilots['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($maxpilots['max'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_MAXPILOTS, $maxpilots['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetEntityTableMap::COL_MAXPILOTS, $maxpilots, $comparison);
    }

    /**
     * Filter the query on the maxPoints column
     *
     * Example usage:
     * <code>
     * $query->filterByMaxpoints(1234); // WHERE maxPoints = 1234
     * $query->filterByMaxpoints(array(12, 34)); // WHERE maxPoints IN (12, 34)
     * $query->filterByMaxpoints(array('min' => 12)); // WHERE maxPoints > 12
     * </code>
     *
     * @param     mixed $maxpoints The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByMaxpoints($maxpoints = null, $comparison = null)
    {
        if (is_array($maxpoints)) {
            $useMinMax = false;
            if (isset($maxpoints['min'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_MAXPOINTS, $maxpoints['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($maxpoints['max'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_MAXPOINTS, $maxpoints['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetEntityTableMap::COL_MAXPOINTS, $maxpoints, $comparison);
    }

    /**
     * Filter the query on the lastModified column
     *
     * Example usage:
     * <code>
     * $query->filterByLastmodified('2011-03-14'); // WHERE lastModified = '2011-03-14'
     * $query->filterByLastmodified('now'); // WHERE lastModified = '2011-03-14'
     * $query->filterByLastmodified(array('max' => 'yesterday')); // WHERE lastModified > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastmodified The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByLastmodified($lastmodified = null, $comparison = null)
    {
        if (is_array($lastmodified)) {
            $useMinMax = false;
            if (isset($lastmodified['min'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_LASTMODIFIED, $lastmodified['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastmodified['max'])) {
                $this->addUsingAlias(RulesetEntityTableMap::COL_LASTMODIFIED, $lastmodified['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetEntityTableMap::COL_LASTMODIFIED, $lastmodified, $comparison);
    }

    /**
     * Filter the query by a related \ECP\User object
     *
     * @param \ECP\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \ECP\User) {
            return $this
                ->addUsingAlias(RulesetEntityTableMap::COL_USERID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RulesetEntityTableMap::COL_USERID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \ECP\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\ECP\UserQuery');
    }

    /**
     * Filter the query by a related \ECP\RulesetEntity object
     *
     * @param \ECP\RulesetEntity|ObjectCollection $rulesetEntity The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByRulesetEntityRelatedByForkedid($rulesetEntity, $comparison = null)
    {
        if ($rulesetEntity instanceof \ECP\RulesetEntity) {
            return $this
                ->addUsingAlias(RulesetEntityTableMap::COL_FORKEDID, $rulesetEntity->getId(), $comparison);
        } elseif ($rulesetEntity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RulesetEntityTableMap::COL_FORKEDID, $rulesetEntity->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRulesetEntityRelatedByForkedid() only accepts arguments of type \ECP\RulesetEntity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RulesetEntityRelatedByForkedid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function joinRulesetEntityRelatedByForkedid($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RulesetEntityRelatedByForkedid');

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
            $this->addJoinObject($join, 'RulesetEntityRelatedByForkedid');
        }

        return $this;
    }

    /**
     * Use the RulesetEntityRelatedByForkedid relation RulesetEntity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\RulesetEntityQuery A secondary query class using the current class as primary query
     */
    public function useRulesetEntityRelatedByForkedidQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRulesetEntityRelatedByForkedid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RulesetEntityRelatedByForkedid', '\ECP\RulesetEntityQuery');
    }

    /**
     * Filter the query by a related \ECP\RulesetEntity object
     *
     * @param \ECP\RulesetEntity|ObjectCollection $rulesetEntity the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByRulesetEntityRelatedById($rulesetEntity, $comparison = null)
    {
        if ($rulesetEntity instanceof \ECP\RulesetEntity) {
            return $this
                ->addUsingAlias(RulesetEntityTableMap::COL_ID, $rulesetEntity->getForkedid(), $comparison);
        } elseif ($rulesetEntity instanceof ObjectCollection) {
            return $this
                ->useRulesetEntityRelatedByIdQuery()
                ->filterByPrimaryKeys($rulesetEntity->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRulesetEntityRelatedById() only accepts arguments of type \ECP\RulesetEntity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RulesetEntityRelatedById relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function joinRulesetEntityRelatedById($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RulesetEntityRelatedById');

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
            $this->addJoinObject($join, 'RulesetEntityRelatedById');
        }

        return $this;
    }

    /**
     * Use the RulesetEntityRelatedById relation RulesetEntity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\RulesetEntityQuery A secondary query class using the current class as primary query
     */
    public function useRulesetEntityRelatedByIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRulesetEntityRelatedById($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RulesetEntityRelatedById', '\ECP\RulesetEntityQuery');
    }

    /**
     * Filter the query by a related \ECP\RulesetShip object
     *
     * @param \ECP\RulesetShip|ObjectCollection $rulesetShip the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByRulesetShip($rulesetShip, $comparison = null)
    {
        if ($rulesetShip instanceof \ECP\RulesetShip) {
            return $this
                ->addUsingAlias(RulesetEntityTableMap::COL_ID, $rulesetShip->getRulesetentityid(), $comparison);
        } elseif ($rulesetShip instanceof ObjectCollection) {
            return $this
                ->useRulesetShipQuery()
                ->filterByPrimaryKeys($rulesetShip->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRulesetShip() only accepts arguments of type \ECP\RulesetShip or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RulesetShip relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function joinRulesetShip($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RulesetShip');

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
            $this->addJoinObject($join, 'RulesetShip');
        }

        return $this;
    }

    /**
     * Use the RulesetShip relation RulesetShip object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\RulesetShipQuery A secondary query class using the current class as primary query
     */
    public function useRulesetShipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRulesetShip($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RulesetShip', '\ECP\RulesetShipQuery');
    }

    /**
     * Filter the query by a related \ECP\RulesetRuleRow object
     *
     * @param \ECP\RulesetRuleRow|ObjectCollection $rulesetRuleRow the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByRulesetRuleRow($rulesetRuleRow, $comparison = null)
    {
        if ($rulesetRuleRow instanceof \ECP\RulesetRuleRow) {
            return $this
                ->addUsingAlias(RulesetEntityTableMap::COL_ID, $rulesetRuleRow->getRulesetentityid(), $comparison);
        } elseif ($rulesetRuleRow instanceof ObjectCollection) {
            return $this
                ->useRulesetRuleRowQuery()
                ->filterByPrimaryKeys($rulesetRuleRow->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
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
     * Filter the query by a related \ECP\CompositionEntity object
     *
     * @param \ECP\CompositionEntity|ObjectCollection $compositionEntity the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function filterByCompositionEntity($compositionEntity, $comparison = null)
    {
        if ($compositionEntity instanceof \ECP\CompositionEntity) {
            return $this
                ->addUsingAlias(RulesetEntityTableMap::COL_ID, $compositionEntity->getRulesetentityid(), $comparison);
        } elseif ($compositionEntity instanceof ObjectCollection) {
            return $this
                ->useCompositionEntityQuery()
                ->filterByPrimaryKeys($compositionEntity->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCompositionEntity() only accepts arguments of type \ECP\CompositionEntity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CompositionEntity relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function joinCompositionEntity($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CompositionEntity');

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
            $this->addJoinObject($join, 'CompositionEntity');
        }

        return $this;
    }

    /**
     * Use the CompositionEntity relation CompositionEntity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\CompositionEntityQuery A secondary query class using the current class as primary query
     */
    public function useCompositionEntityQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCompositionEntity($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CompositionEntity', '\ECP\CompositionEntityQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRulesetEntity $rulesetEntity Object to remove from the list of results
     *
     * @return $this|ChildRulesetEntityQuery The current query, for fluid interface
     */
    public function prune($rulesetEntity = null)
    {
        if ($rulesetEntity) {
            $this->addUsingAlias(RulesetEntityTableMap::COL_ID, $rulesetEntity->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the rulesetentity table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RulesetEntityTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RulesetEntityTableMap::clearInstancePool();
            RulesetEntityTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RulesetEntityTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RulesetEntityTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            RulesetEntityTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            RulesetEntityTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RulesetEntityQuery
