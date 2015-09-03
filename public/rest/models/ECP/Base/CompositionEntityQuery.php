<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\CompositionEntity as ChildCompositionEntity;
use ECP\CompositionEntityQuery as ChildCompositionEntityQuery;
use ECP\Map\CompositionEntityTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'compositionentity' table.
 *
 * 
 *
 * @method     ChildCompositionEntityQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCompositionEntityQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildCompositionEntityQuery orderByUserid($order = Criteria::ASC) Order by the userId column
 * @method     ChildCompositionEntityQuery orderByIslisted($order = Criteria::ASC) Order by the isListed column
 * @method     ChildCompositionEntityQuery orderByForkedid($order = Criteria::ASC) Order by the forkedId column
 * @method     ChildCompositionEntityQuery orderByRulesetentityid($order = Criteria::ASC) Order by the rulesetEntityId column
 * @method     ChildCompositionEntityQuery orderByLastmodified($order = Criteria::ASC) Order by the lastModified column
 *
 * @method     ChildCompositionEntityQuery groupById() Group by the id column
 * @method     ChildCompositionEntityQuery groupByName() Group by the name column
 * @method     ChildCompositionEntityQuery groupByUserid() Group by the userId column
 * @method     ChildCompositionEntityQuery groupByIslisted() Group by the isListed column
 * @method     ChildCompositionEntityQuery groupByForkedid() Group by the forkedId column
 * @method     ChildCompositionEntityQuery groupByRulesetentityid() Group by the rulesetEntityId column
 * @method     ChildCompositionEntityQuery groupByLastmodified() Group by the lastModified column
 *
 * @method     ChildCompositionEntityQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCompositionEntityQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCompositionEntityQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCompositionEntityQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildCompositionEntityQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildCompositionEntityQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildCompositionEntityQuery leftJoinCompositionEntityRelatedByForkedid($relationAlias = null) Adds a LEFT JOIN clause to the query using the CompositionEntityRelatedByForkedid relation
 * @method     ChildCompositionEntityQuery rightJoinCompositionEntityRelatedByForkedid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CompositionEntityRelatedByForkedid relation
 * @method     ChildCompositionEntityQuery innerJoinCompositionEntityRelatedByForkedid($relationAlias = null) Adds a INNER JOIN clause to the query using the CompositionEntityRelatedByForkedid relation
 *
 * @method     ChildCompositionEntityQuery leftJoinRulesetEntity($relationAlias = null) Adds a LEFT JOIN clause to the query using the RulesetEntity relation
 * @method     ChildCompositionEntityQuery rightJoinRulesetEntity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RulesetEntity relation
 * @method     ChildCompositionEntityQuery innerJoinRulesetEntity($relationAlias = null) Adds a INNER JOIN clause to the query using the RulesetEntity relation
 *
 * @method     ChildCompositionEntityQuery leftJoinCompositionEntityRelatedById($relationAlias = null) Adds a LEFT JOIN clause to the query using the CompositionEntityRelatedById relation
 * @method     ChildCompositionEntityQuery rightJoinCompositionEntityRelatedById($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CompositionEntityRelatedById relation
 * @method     ChildCompositionEntityQuery innerJoinCompositionEntityRelatedById($relationAlias = null) Adds a INNER JOIN clause to the query using the CompositionEntityRelatedById relation
 *
 * @method     ChildCompositionEntityQuery leftJoinCompositionRow($relationAlias = null) Adds a LEFT JOIN clause to the query using the CompositionRow relation
 * @method     ChildCompositionEntityQuery rightJoinCompositionRow($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CompositionRow relation
 * @method     ChildCompositionEntityQuery innerJoinCompositionRow($relationAlias = null) Adds a INNER JOIN clause to the query using the CompositionRow relation
 *
 * @method     \ECP\UserQuery|\ECP\CompositionEntityQuery|\ECP\RulesetEntityQuery|\ECP\CompositionRowQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCompositionEntity findOne(ConnectionInterface $con = null) Return the first ChildCompositionEntity matching the query
 * @method     ChildCompositionEntity findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCompositionEntity matching the query, or a new ChildCompositionEntity object populated from the query conditions when no match is found
 *
 * @method     ChildCompositionEntity findOneById(int $id) Return the first ChildCompositionEntity filtered by the id column
 * @method     ChildCompositionEntity findOneByName(string $name) Return the first ChildCompositionEntity filtered by the name column
 * @method     ChildCompositionEntity findOneByUserid(int $userId) Return the first ChildCompositionEntity filtered by the userId column
 * @method     ChildCompositionEntity findOneByIslisted(int $isListed) Return the first ChildCompositionEntity filtered by the isListed column
 * @method     ChildCompositionEntity findOneByForkedid(int $forkedId) Return the first ChildCompositionEntity filtered by the forkedId column
 * @method     ChildCompositionEntity findOneByRulesetentityid(int $rulesetEntityId) Return the first ChildCompositionEntity filtered by the rulesetEntityId column
 * @method     ChildCompositionEntity findOneByLastmodified(string $lastModified) Return the first ChildCompositionEntity filtered by the lastModified column *

 * @method     ChildCompositionEntity requirePk($key, ConnectionInterface $con = null) Return the ChildCompositionEntity by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompositionEntity requireOne(ConnectionInterface $con = null) Return the first ChildCompositionEntity matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCompositionEntity requireOneById(int $id) Return the first ChildCompositionEntity filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompositionEntity requireOneByName(string $name) Return the first ChildCompositionEntity filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompositionEntity requireOneByUserid(int $userId) Return the first ChildCompositionEntity filtered by the userId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompositionEntity requireOneByIslisted(int $isListed) Return the first ChildCompositionEntity filtered by the isListed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompositionEntity requireOneByForkedid(int $forkedId) Return the first ChildCompositionEntity filtered by the forkedId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompositionEntity requireOneByRulesetentityid(int $rulesetEntityId) Return the first ChildCompositionEntity filtered by the rulesetEntityId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompositionEntity requireOneByLastmodified(string $lastModified) Return the first ChildCompositionEntity filtered by the lastModified column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCompositionEntity[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCompositionEntity objects based on current ModelCriteria
 * @method     ChildCompositionEntity[]|ObjectCollection findById(int $id) Return ChildCompositionEntity objects filtered by the id column
 * @method     ChildCompositionEntity[]|ObjectCollection findByName(string $name) Return ChildCompositionEntity objects filtered by the name column
 * @method     ChildCompositionEntity[]|ObjectCollection findByUserid(int $userId) Return ChildCompositionEntity objects filtered by the userId column
 * @method     ChildCompositionEntity[]|ObjectCollection findByIslisted(int $isListed) Return ChildCompositionEntity objects filtered by the isListed column
 * @method     ChildCompositionEntity[]|ObjectCollection findByForkedid(int $forkedId) Return ChildCompositionEntity objects filtered by the forkedId column
 * @method     ChildCompositionEntity[]|ObjectCollection findByRulesetentityid(int $rulesetEntityId) Return ChildCompositionEntity objects filtered by the rulesetEntityId column
 * @method     ChildCompositionEntity[]|ObjectCollection findByLastmodified(string $lastModified) Return ChildCompositionEntity objects filtered by the lastModified column
 * @method     ChildCompositionEntity[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CompositionEntityQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\CompositionEntityQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\CompositionEntity', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCompositionEntityQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCompositionEntityQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCompositionEntityQuery) {
            return $criteria;
        }
        $query = new ChildCompositionEntityQuery();
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
     * @return ChildCompositionEntity|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CompositionEntityTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CompositionEntityTableMap::DATABASE_NAME);
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
     * @return ChildCompositionEntity A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, userId, isListed, forkedId, rulesetEntityId, lastModified FROM compositionentity WHERE id = :p0';
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
            /** @var ChildCompositionEntity $obj */
            $obj = new ChildCompositionEntity();
            $obj->hydrate($row);
            CompositionEntityTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCompositionEntity|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CompositionEntityTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CompositionEntityTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CompositionEntityTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CompositionEntityTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompositionEntityTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CompositionEntityTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(CompositionEntityTableMap::COL_USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(CompositionEntityTableMap::COL_USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompositionEntityTableMap::COL_USERID, $userid, $comparison);
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
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function filterByIslisted($islisted = null, $comparison = null)
    {
        if (is_array($islisted)) {
            $useMinMax = false;
            if (isset($islisted['min'])) {
                $this->addUsingAlias(CompositionEntityTableMap::COL_ISLISTED, $islisted['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($islisted['max'])) {
                $this->addUsingAlias(CompositionEntityTableMap::COL_ISLISTED, $islisted['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompositionEntityTableMap::COL_ISLISTED, $islisted, $comparison);
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
     * @see       filterByCompositionEntityRelatedByForkedid()
     *
     * @param     mixed $forkedid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function filterByForkedid($forkedid = null, $comparison = null)
    {
        if (is_array($forkedid)) {
            $useMinMax = false;
            if (isset($forkedid['min'])) {
                $this->addUsingAlias(CompositionEntityTableMap::COL_FORKEDID, $forkedid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($forkedid['max'])) {
                $this->addUsingAlias(CompositionEntityTableMap::COL_FORKEDID, $forkedid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompositionEntityTableMap::COL_FORKEDID, $forkedid, $comparison);
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
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function filterByRulesetentityid($rulesetentityid = null, $comparison = null)
    {
        if (is_array($rulesetentityid)) {
            $useMinMax = false;
            if (isset($rulesetentityid['min'])) {
                $this->addUsingAlias(CompositionEntityTableMap::COL_RULESETENTITYID, $rulesetentityid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rulesetentityid['max'])) {
                $this->addUsingAlias(CompositionEntityTableMap::COL_RULESETENTITYID, $rulesetentityid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompositionEntityTableMap::COL_RULESETENTITYID, $rulesetentityid, $comparison);
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
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function filterByLastmodified($lastmodified = null, $comparison = null)
    {
        if (is_array($lastmodified)) {
            $useMinMax = false;
            if (isset($lastmodified['min'])) {
                $this->addUsingAlias(CompositionEntityTableMap::COL_LASTMODIFIED, $lastmodified['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastmodified['max'])) {
                $this->addUsingAlias(CompositionEntityTableMap::COL_LASTMODIFIED, $lastmodified['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompositionEntityTableMap::COL_LASTMODIFIED, $lastmodified, $comparison);
    }

    /**
     * Filter the query by a related \ECP\User object
     *
     * @param \ECP\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \ECP\User) {
            return $this
                ->addUsingAlias(CompositionEntityTableMap::COL_USERID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CompositionEntityTableMap::COL_USERID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
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
     * Filter the query by a related \ECP\CompositionEntity object
     *
     * @param \ECP\CompositionEntity|ObjectCollection $compositionEntity The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function filterByCompositionEntityRelatedByForkedid($compositionEntity, $comparison = null)
    {
        if ($compositionEntity instanceof \ECP\CompositionEntity) {
            return $this
                ->addUsingAlias(CompositionEntityTableMap::COL_FORKEDID, $compositionEntity->getId(), $comparison);
        } elseif ($compositionEntity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CompositionEntityTableMap::COL_FORKEDID, $compositionEntity->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCompositionEntityRelatedByForkedid() only accepts arguments of type \ECP\CompositionEntity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CompositionEntityRelatedByForkedid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function joinCompositionEntityRelatedByForkedid($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CompositionEntityRelatedByForkedid');

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
            $this->addJoinObject($join, 'CompositionEntityRelatedByForkedid');
        }

        return $this;
    }

    /**
     * Use the CompositionEntityRelatedByForkedid relation CompositionEntity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\CompositionEntityQuery A secondary query class using the current class as primary query
     */
    public function useCompositionEntityRelatedByForkedidQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCompositionEntityRelatedByForkedid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CompositionEntityRelatedByForkedid', '\ECP\CompositionEntityQuery');
    }

    /**
     * Filter the query by a related \ECP\RulesetEntity object
     *
     * @param \ECP\RulesetEntity|ObjectCollection $rulesetEntity The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function filterByRulesetEntity($rulesetEntity, $comparison = null)
    {
        if ($rulesetEntity instanceof \ECP\RulesetEntity) {
            return $this
                ->addUsingAlias(CompositionEntityTableMap::COL_RULESETENTITYID, $rulesetEntity->getId(), $comparison);
        } elseif ($rulesetEntity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CompositionEntityTableMap::COL_RULESETENTITYID, $rulesetEntity->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
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
     * Filter the query by a related \ECP\CompositionEntity object
     *
     * @param \ECP\CompositionEntity|ObjectCollection $compositionEntity the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function filterByCompositionEntityRelatedById($compositionEntity, $comparison = null)
    {
        if ($compositionEntity instanceof \ECP\CompositionEntity) {
            return $this
                ->addUsingAlias(CompositionEntityTableMap::COL_ID, $compositionEntity->getForkedid(), $comparison);
        } elseif ($compositionEntity instanceof ObjectCollection) {
            return $this
                ->useCompositionEntityRelatedByIdQuery()
                ->filterByPrimaryKeys($compositionEntity->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCompositionEntityRelatedById() only accepts arguments of type \ECP\CompositionEntity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CompositionEntityRelatedById relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function joinCompositionEntityRelatedById($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CompositionEntityRelatedById');

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
            $this->addJoinObject($join, 'CompositionEntityRelatedById');
        }

        return $this;
    }

    /**
     * Use the CompositionEntityRelatedById relation CompositionEntity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\CompositionEntityQuery A secondary query class using the current class as primary query
     */
    public function useCompositionEntityRelatedByIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCompositionEntityRelatedById($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CompositionEntityRelatedById', '\ECP\CompositionEntityQuery');
    }

    /**
     * Filter the query by a related \ECP\CompositionRow object
     *
     * @param \ECP\CompositionRow|ObjectCollection $compositionRow the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function filterByCompositionRow($compositionRow, $comparison = null)
    {
        if ($compositionRow instanceof \ECP\CompositionRow) {
            return $this
                ->addUsingAlias(CompositionEntityTableMap::COL_ID, $compositionRow->getCompositionentityid(), $comparison);
        } elseif ($compositionRow instanceof ObjectCollection) {
            return $this
                ->useCompositionRowQuery()
                ->filterByPrimaryKeys($compositionRow->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCompositionRow() only accepts arguments of type \ECP\CompositionRow or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CompositionRow relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function joinCompositionRow($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CompositionRow');

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
            $this->addJoinObject($join, 'CompositionRow');
        }

        return $this;
    }

    /**
     * Use the CompositionRow relation CompositionRow object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\CompositionRowQuery A secondary query class using the current class as primary query
     */
    public function useCompositionRowQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCompositionRow($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CompositionRow', '\ECP\CompositionRowQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCompositionEntity $compositionEntity Object to remove from the list of results
     *
     * @return $this|ChildCompositionEntityQuery The current query, for fluid interface
     */
    public function prune($compositionEntity = null)
    {
        if ($compositionEntity) {
            $this->addUsingAlias(CompositionEntityTableMap::COL_ID, $compositionEntity->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the compositionentity table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompositionEntityTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CompositionEntityTableMap::clearInstancePool();
            CompositionEntityTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CompositionEntityTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CompositionEntityTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            CompositionEntityTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CompositionEntityTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CompositionEntityQuery
