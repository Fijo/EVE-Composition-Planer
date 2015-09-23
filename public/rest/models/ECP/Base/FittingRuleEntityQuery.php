<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\FittingRuleEntity as ChildFittingRuleEntity;
use ECP\FittingRuleEntityQuery as ChildFittingRuleEntityQuery;
use ECP\Map\FittingRuleEntityTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'fittingruleentity' table.
 *
 * 
 *
 * @method     ChildFittingRuleEntityQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFittingRuleEntityQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildFittingRuleEntityQuery orderByUserid($order = Criteria::ASC) Order by the userId column
 * @method     ChildFittingRuleEntityQuery orderByIsglobal($order = Criteria::ASC) Order by the isGlobal column
 * @method     ChildFittingRuleEntityQuery orderByIslisted($order = Criteria::ASC) Order by the isListed column
 * @method     ChildFittingRuleEntityQuery orderByForkedid($order = Criteria::ASC) Order by the forkedId column
 * @method     ChildFittingRuleEntityQuery orderByIsfiltertypeuptodate($order = Criteria::ASC) Order by the isFilterTypeUptodate column
 * @method     ChildFittingRuleEntityQuery orderByLastmodified($order = Criteria::ASC) Order by the lastModified column
 *
 * @method     ChildFittingRuleEntityQuery groupById() Group by the id column
 * @method     ChildFittingRuleEntityQuery groupByName() Group by the name column
 * @method     ChildFittingRuleEntityQuery groupByUserid() Group by the userId column
 * @method     ChildFittingRuleEntityQuery groupByIsglobal() Group by the isGlobal column
 * @method     ChildFittingRuleEntityQuery groupByIslisted() Group by the isListed column
 * @method     ChildFittingRuleEntityQuery groupByForkedid() Group by the forkedId column
 * @method     ChildFittingRuleEntityQuery groupByIsfiltertypeuptodate() Group by the isFilterTypeUptodate column
 * @method     ChildFittingRuleEntityQuery groupByLastmodified() Group by the lastModified column
 *
 * @method     ChildFittingRuleEntityQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFittingRuleEntityQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFittingRuleEntityQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFittingRuleEntityQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildFittingRuleEntityQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildFittingRuleEntityQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildFittingRuleEntityQuery leftJoinFittingRuleEntityRelatedByForkedid($relationAlias = null) Adds a LEFT JOIN clause to the query using the FittingRuleEntityRelatedByForkedid relation
 * @method     ChildFittingRuleEntityQuery rightJoinFittingRuleEntityRelatedByForkedid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FittingRuleEntityRelatedByForkedid relation
 * @method     ChildFittingRuleEntityQuery innerJoinFittingRuleEntityRelatedByForkedid($relationAlias = null) Adds a INNER JOIN clause to the query using the FittingRuleEntityRelatedByForkedid relation
 *
 * @method     ChildFittingRuleEntityQuery leftJoinFittingRuleEntityRelatedById($relationAlias = null) Adds a LEFT JOIN clause to the query using the FittingRuleEntityRelatedById relation
 * @method     ChildFittingRuleEntityQuery rightJoinFittingRuleEntityRelatedById($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FittingRuleEntityRelatedById relation
 * @method     ChildFittingRuleEntityQuery innerJoinFittingRuleEntityRelatedById($relationAlias = null) Adds a INNER JOIN clause to the query using the FittingRuleEntityRelatedById relation
 *
 * @method     ChildFittingRuleEntityQuery leftJoinFittingRuleRow($relationAlias = null) Adds a LEFT JOIN clause to the query using the FittingRuleRow relation
 * @method     ChildFittingRuleEntityQuery rightJoinFittingRuleRow($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FittingRuleRow relation
 * @method     ChildFittingRuleEntityQuery innerJoinFittingRuleRow($relationAlias = null) Adds a INNER JOIN clause to the query using the FittingRuleRow relation
 *
 * @method     ChildFittingRuleEntityQuery leftJoinRulesetFilterRule($relationAlias = null) Adds a LEFT JOIN clause to the query using the RulesetFilterRule relation
 * @method     ChildFittingRuleEntityQuery rightJoinRulesetFilterRule($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RulesetFilterRule relation
 * @method     ChildFittingRuleEntityQuery innerJoinRulesetFilterRule($relationAlias = null) Adds a INNER JOIN clause to the query using the RulesetFilterRule relation
 *
 * @method     \ECP\UserQuery|\ECP\FittingRuleEntityQuery|\ECP\FittingRuleRowQuery|\ECP\RulesetFilterRuleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildFittingRuleEntity findOne(ConnectionInterface $con = null) Return the first ChildFittingRuleEntity matching the query
 * @method     ChildFittingRuleEntity findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFittingRuleEntity matching the query, or a new ChildFittingRuleEntity object populated from the query conditions when no match is found
 *
 * @method     ChildFittingRuleEntity findOneById(int $id) Return the first ChildFittingRuleEntity filtered by the id column
 * @method     ChildFittingRuleEntity findOneByName(string $name) Return the first ChildFittingRuleEntity filtered by the name column
 * @method     ChildFittingRuleEntity findOneByUserid(int $userId) Return the first ChildFittingRuleEntity filtered by the userId column
 * @method     ChildFittingRuleEntity findOneByIsglobal(int $isGlobal) Return the first ChildFittingRuleEntity filtered by the isGlobal column
 * @method     ChildFittingRuleEntity findOneByIslisted(int $isListed) Return the first ChildFittingRuleEntity filtered by the isListed column
 * @method     ChildFittingRuleEntity findOneByForkedid(int $forkedId) Return the first ChildFittingRuleEntity filtered by the forkedId column
 * @method     ChildFittingRuleEntity findOneByIsfiltertypeuptodate(int $isFilterTypeUptodate) Return the first ChildFittingRuleEntity filtered by the isFilterTypeUptodate column
 * @method     ChildFittingRuleEntity findOneByLastmodified(string $lastModified) Return the first ChildFittingRuleEntity filtered by the lastModified column *

 * @method     ChildFittingRuleEntity requirePk($key, ConnectionInterface $con = null) Return the ChildFittingRuleEntity by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFittingRuleEntity requireOne(ConnectionInterface $con = null) Return the first ChildFittingRuleEntity matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFittingRuleEntity requireOneById(int $id) Return the first ChildFittingRuleEntity filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFittingRuleEntity requireOneByName(string $name) Return the first ChildFittingRuleEntity filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFittingRuleEntity requireOneByUserid(int $userId) Return the first ChildFittingRuleEntity filtered by the userId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFittingRuleEntity requireOneByIsglobal(int $isGlobal) Return the first ChildFittingRuleEntity filtered by the isGlobal column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFittingRuleEntity requireOneByIslisted(int $isListed) Return the first ChildFittingRuleEntity filtered by the isListed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFittingRuleEntity requireOneByForkedid(int $forkedId) Return the first ChildFittingRuleEntity filtered by the forkedId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFittingRuleEntity requireOneByIsfiltertypeuptodate(int $isFilterTypeUptodate) Return the first ChildFittingRuleEntity filtered by the isFilterTypeUptodate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFittingRuleEntity requireOneByLastmodified(string $lastModified) Return the first ChildFittingRuleEntity filtered by the lastModified column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFittingRuleEntity[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFittingRuleEntity objects based on current ModelCriteria
 * @method     ChildFittingRuleEntity[]|ObjectCollection findById(int $id) Return ChildFittingRuleEntity objects filtered by the id column
 * @method     ChildFittingRuleEntity[]|ObjectCollection findByName(string $name) Return ChildFittingRuleEntity objects filtered by the name column
 * @method     ChildFittingRuleEntity[]|ObjectCollection findByUserid(int $userId) Return ChildFittingRuleEntity objects filtered by the userId column
 * @method     ChildFittingRuleEntity[]|ObjectCollection findByIsglobal(int $isGlobal) Return ChildFittingRuleEntity objects filtered by the isGlobal column
 * @method     ChildFittingRuleEntity[]|ObjectCollection findByIslisted(int $isListed) Return ChildFittingRuleEntity objects filtered by the isListed column
 * @method     ChildFittingRuleEntity[]|ObjectCollection findByForkedid(int $forkedId) Return ChildFittingRuleEntity objects filtered by the forkedId column
 * @method     ChildFittingRuleEntity[]|ObjectCollection findByIsfiltertypeuptodate(int $isFilterTypeUptodate) Return ChildFittingRuleEntity objects filtered by the isFilterTypeUptodate column
 * @method     ChildFittingRuleEntity[]|ObjectCollection findByLastmodified(string $lastModified) Return ChildFittingRuleEntity objects filtered by the lastModified column
 * @method     ChildFittingRuleEntity[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FittingRuleEntityQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\FittingRuleEntityQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\FittingRuleEntity', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFittingRuleEntityQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFittingRuleEntityQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFittingRuleEntityQuery) {
            return $criteria;
        }
        $query = new ChildFittingRuleEntityQuery();
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
     * @return ChildFittingRuleEntity|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FittingRuleEntityTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FittingRuleEntityTableMap::DATABASE_NAME);
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
     * @return ChildFittingRuleEntity A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, userId, isGlobal, isListed, forkedId, isFilterTypeUptodate, lastModified FROM fittingruleentity WHERE id = :p0';
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
            /** @var ChildFittingRuleEntity $obj */
            $obj = new ChildFittingRuleEntity();
            $obj->hydrate($row);
            FittingRuleEntityTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildFittingRuleEntity|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FittingRuleEntityTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FittingRuleEntityTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FittingRuleEntityTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FittingRuleEntityTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FittingRuleEntityTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
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

        return $this->addUsingAlias(FittingRuleEntityTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(FittingRuleEntityTableMap::COL_USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(FittingRuleEntityTableMap::COL_USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FittingRuleEntityTableMap::COL_USERID, $userid, $comparison);
    }

    /**
     * Filter the query on the isGlobal column
     *
     * Example usage:
     * <code>
     * $query->filterByIsglobal(1234); // WHERE isGlobal = 1234
     * $query->filterByIsglobal(array(12, 34)); // WHERE isGlobal IN (12, 34)
     * $query->filterByIsglobal(array('min' => 12)); // WHERE isGlobal > 12
     * </code>
     *
     * @param     mixed $isglobal The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function filterByIsglobal($isglobal = null, $comparison = null)
    {
        if (is_array($isglobal)) {
            $useMinMax = false;
            if (isset($isglobal['min'])) {
                $this->addUsingAlias(FittingRuleEntityTableMap::COL_ISGLOBAL, $isglobal['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isglobal['max'])) {
                $this->addUsingAlias(FittingRuleEntityTableMap::COL_ISGLOBAL, $isglobal['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FittingRuleEntityTableMap::COL_ISGLOBAL, $isglobal, $comparison);
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
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function filterByIslisted($islisted = null, $comparison = null)
    {
        if (is_array($islisted)) {
            $useMinMax = false;
            if (isset($islisted['min'])) {
                $this->addUsingAlias(FittingRuleEntityTableMap::COL_ISLISTED, $islisted['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($islisted['max'])) {
                $this->addUsingAlias(FittingRuleEntityTableMap::COL_ISLISTED, $islisted['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FittingRuleEntityTableMap::COL_ISLISTED, $islisted, $comparison);
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
     * @see       filterByFittingRuleEntityRelatedByForkedid()
     *
     * @param     mixed $forkedid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function filterByForkedid($forkedid = null, $comparison = null)
    {
        if (is_array($forkedid)) {
            $useMinMax = false;
            if (isset($forkedid['min'])) {
                $this->addUsingAlias(FittingRuleEntityTableMap::COL_FORKEDID, $forkedid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($forkedid['max'])) {
                $this->addUsingAlias(FittingRuleEntityTableMap::COL_FORKEDID, $forkedid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FittingRuleEntityTableMap::COL_FORKEDID, $forkedid, $comparison);
    }

    /**
     * Filter the query on the isFilterTypeUptodate column
     *
     * Example usage:
     * <code>
     * $query->filterByIsfiltertypeuptodate(1234); // WHERE isFilterTypeUptodate = 1234
     * $query->filterByIsfiltertypeuptodate(array(12, 34)); // WHERE isFilterTypeUptodate IN (12, 34)
     * $query->filterByIsfiltertypeuptodate(array('min' => 12)); // WHERE isFilterTypeUptodate > 12
     * </code>
     *
     * @param     mixed $isfiltertypeuptodate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function filterByIsfiltertypeuptodate($isfiltertypeuptodate = null, $comparison = null)
    {
        if (is_array($isfiltertypeuptodate)) {
            $useMinMax = false;
            if (isset($isfiltertypeuptodate['min'])) {
                $this->addUsingAlias(FittingRuleEntityTableMap::COL_ISFILTERTYPEUPTODATE, $isfiltertypeuptodate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isfiltertypeuptodate['max'])) {
                $this->addUsingAlias(FittingRuleEntityTableMap::COL_ISFILTERTYPEUPTODATE, $isfiltertypeuptodate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FittingRuleEntityTableMap::COL_ISFILTERTYPEUPTODATE, $isfiltertypeuptodate, $comparison);
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
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function filterByLastmodified($lastmodified = null, $comparison = null)
    {
        if (is_array($lastmodified)) {
            $useMinMax = false;
            if (isset($lastmodified['min'])) {
                $this->addUsingAlias(FittingRuleEntityTableMap::COL_LASTMODIFIED, $lastmodified['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastmodified['max'])) {
                $this->addUsingAlias(FittingRuleEntityTableMap::COL_LASTMODIFIED, $lastmodified['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FittingRuleEntityTableMap::COL_LASTMODIFIED, $lastmodified, $comparison);
    }

    /**
     * Filter the query by a related \ECP\User object
     *
     * @param \ECP\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \ECP\User) {
            return $this
                ->addUsingAlias(FittingRuleEntityTableMap::COL_USERID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FittingRuleEntityTableMap::COL_USERID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
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
     * Filter the query by a related \ECP\FittingRuleEntity object
     *
     * @param \ECP\FittingRuleEntity|ObjectCollection $fittingRuleEntity The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function filterByFittingRuleEntityRelatedByForkedid($fittingRuleEntity, $comparison = null)
    {
        if ($fittingRuleEntity instanceof \ECP\FittingRuleEntity) {
            return $this
                ->addUsingAlias(FittingRuleEntityTableMap::COL_FORKEDID, $fittingRuleEntity->getId(), $comparison);
        } elseif ($fittingRuleEntity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FittingRuleEntityTableMap::COL_FORKEDID, $fittingRuleEntity->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFittingRuleEntityRelatedByForkedid() only accepts arguments of type \ECP\FittingRuleEntity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FittingRuleEntityRelatedByForkedid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function joinFittingRuleEntityRelatedByForkedid($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FittingRuleEntityRelatedByForkedid');

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
            $this->addJoinObject($join, 'FittingRuleEntityRelatedByForkedid');
        }

        return $this;
    }

    /**
     * Use the FittingRuleEntityRelatedByForkedid relation FittingRuleEntity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\FittingRuleEntityQuery A secondary query class using the current class as primary query
     */
    public function useFittingRuleEntityRelatedByForkedidQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFittingRuleEntityRelatedByForkedid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FittingRuleEntityRelatedByForkedid', '\ECP\FittingRuleEntityQuery');
    }

    /**
     * Filter the query by a related \ECP\FittingRuleEntity object
     *
     * @param \ECP\FittingRuleEntity|ObjectCollection $fittingRuleEntity the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function filterByFittingRuleEntityRelatedById($fittingRuleEntity, $comparison = null)
    {
        if ($fittingRuleEntity instanceof \ECP\FittingRuleEntity) {
            return $this
                ->addUsingAlias(FittingRuleEntityTableMap::COL_ID, $fittingRuleEntity->getForkedid(), $comparison);
        } elseif ($fittingRuleEntity instanceof ObjectCollection) {
            return $this
                ->useFittingRuleEntityRelatedByIdQuery()
                ->filterByPrimaryKeys($fittingRuleEntity->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFittingRuleEntityRelatedById() only accepts arguments of type \ECP\FittingRuleEntity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FittingRuleEntityRelatedById relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function joinFittingRuleEntityRelatedById($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FittingRuleEntityRelatedById');

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
            $this->addJoinObject($join, 'FittingRuleEntityRelatedById');
        }

        return $this;
    }

    /**
     * Use the FittingRuleEntityRelatedById relation FittingRuleEntity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\FittingRuleEntityQuery A secondary query class using the current class as primary query
     */
    public function useFittingRuleEntityRelatedByIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFittingRuleEntityRelatedById($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FittingRuleEntityRelatedById', '\ECP\FittingRuleEntityQuery');
    }

    /**
     * Filter the query by a related \ECP\FittingRuleRow object
     *
     * @param \ECP\FittingRuleRow|ObjectCollection $fittingRuleRow the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function filterByFittingRuleRow($fittingRuleRow, $comparison = null)
    {
        if ($fittingRuleRow instanceof \ECP\FittingRuleRow) {
            return $this
                ->addUsingAlias(FittingRuleEntityTableMap::COL_ID, $fittingRuleRow->getFittingruleentityid(), $comparison);
        } elseif ($fittingRuleRow instanceof ObjectCollection) {
            return $this
                ->useFittingRuleRowQuery()
                ->filterByPrimaryKeys($fittingRuleRow->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
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
     * Filter the query by a related \ECP\RulesetFilterRule object
     *
     * @param \ECP\RulesetFilterRule|ObjectCollection $rulesetFilterRule the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function filterByRulesetFilterRule($rulesetFilterRule, $comparison = null)
    {
        if ($rulesetFilterRule instanceof \ECP\RulesetFilterRule) {
            return $this
                ->addUsingAlias(FittingRuleEntityTableMap::COL_ID, $rulesetFilterRule->getFittingruleentityid(), $comparison);
        } elseif ($rulesetFilterRule instanceof ObjectCollection) {
            return $this
                ->useRulesetFilterRuleQuery()
                ->filterByPrimaryKeys($rulesetFilterRule->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRulesetFilterRule() only accepts arguments of type \ECP\RulesetFilterRule or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RulesetFilterRule relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function joinRulesetFilterRule($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RulesetFilterRule');

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
            $this->addJoinObject($join, 'RulesetFilterRule');
        }

        return $this;
    }

    /**
     * Use the RulesetFilterRule relation RulesetFilterRule object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\RulesetFilterRuleQuery A secondary query class using the current class as primary query
     */
    public function useRulesetFilterRuleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRulesetFilterRule($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RulesetFilterRule', '\ECP\RulesetFilterRuleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFittingRuleEntity $fittingRuleEntity Object to remove from the list of results
     *
     * @return $this|ChildFittingRuleEntityQuery The current query, for fluid interface
     */
    public function prune($fittingRuleEntity = null)
    {
        if ($fittingRuleEntity) {
            $this->addUsingAlias(FittingRuleEntityTableMap::COL_ID, $fittingRuleEntity->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fittingruleentity table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FittingRuleEntityTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FittingRuleEntityTableMap::clearInstancePool();
            FittingRuleEntityTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(FittingRuleEntityTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FittingRuleEntityTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            FittingRuleEntityTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            FittingRuleEntityTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FittingRuleEntityQuery
