<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\EveApi as ChildEveApi;
use ECP\EveApiQuery as ChildEveApiQuery;
use ECP\Map\EveApiTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'eveapi' table.
 *
 * 
 *
 * @method     ChildEveApiQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildEveApiQuery orderByUserid($order = Criteria::ASC) Order by the userId column
 * @method     ChildEveApiQuery orderByKeyid($order = Criteria::ASC) Order by the keyId column
 * @method     ChildEveApiQuery orderByVcode($order = Criteria::ASC) Order by the vCode column
 * @method     ChildEveApiQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildEveApiQuery orderByLastcomputed($order = Criteria::ASC) Order by the lastComputed column
 *
 * @method     ChildEveApiQuery groupById() Group by the id column
 * @method     ChildEveApiQuery groupByUserid() Group by the userId column
 * @method     ChildEveApiQuery groupByKeyid() Group by the keyId column
 * @method     ChildEveApiQuery groupByVcode() Group by the vCode column
 * @method     ChildEveApiQuery groupByStatus() Group by the status column
 * @method     ChildEveApiQuery groupByLastcomputed() Group by the lastComputed column
 *
 * @method     ChildEveApiQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEveApiQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEveApiQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEveApiQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildEveApiQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildEveApiQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildEveApiQuery leftJoinEveCharacter($relationAlias = null) Adds a LEFT JOIN clause to the query using the EveCharacter relation
 * @method     ChildEveApiQuery rightJoinEveCharacter($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EveCharacter relation
 * @method     ChildEveApiQuery innerJoinEveCharacter($relationAlias = null) Adds a INNER JOIN clause to the query using the EveCharacter relation
 *
 * @method     \ECP\UserQuery|\ECP\EveCharacterQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEveApi findOne(ConnectionInterface $con = null) Return the first ChildEveApi matching the query
 * @method     ChildEveApi findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEveApi matching the query, or a new ChildEveApi object populated from the query conditions when no match is found
 *
 * @method     ChildEveApi findOneById(int $id) Return the first ChildEveApi filtered by the id column
 * @method     ChildEveApi findOneByUserid(int $userId) Return the first ChildEveApi filtered by the userId column
 * @method     ChildEveApi findOneByKeyid(int $keyId) Return the first ChildEveApi filtered by the keyId column
 * @method     ChildEveApi findOneByVcode(string $vCode) Return the first ChildEveApi filtered by the vCode column
 * @method     ChildEveApi findOneByStatus(string $status) Return the first ChildEveApi filtered by the status column
 * @method     ChildEveApi findOneByLastcomputed(string $lastComputed) Return the first ChildEveApi filtered by the lastComputed column *

 * @method     ChildEveApi requirePk($key, ConnectionInterface $con = null) Return the ChildEveApi by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEveApi requireOne(ConnectionInterface $con = null) Return the first ChildEveApi matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEveApi requireOneById(int $id) Return the first ChildEveApi filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEveApi requireOneByUserid(int $userId) Return the first ChildEveApi filtered by the userId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEveApi requireOneByKeyid(int $keyId) Return the first ChildEveApi filtered by the keyId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEveApi requireOneByVcode(string $vCode) Return the first ChildEveApi filtered by the vCode column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEveApi requireOneByStatus(string $status) Return the first ChildEveApi filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEveApi requireOneByLastcomputed(string $lastComputed) Return the first ChildEveApi filtered by the lastComputed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEveApi[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEveApi objects based on current ModelCriteria
 * @method     ChildEveApi[]|ObjectCollection findById(int $id) Return ChildEveApi objects filtered by the id column
 * @method     ChildEveApi[]|ObjectCollection findByUserid(int $userId) Return ChildEveApi objects filtered by the userId column
 * @method     ChildEveApi[]|ObjectCollection findByKeyid(int $keyId) Return ChildEveApi objects filtered by the keyId column
 * @method     ChildEveApi[]|ObjectCollection findByVcode(string $vCode) Return ChildEveApi objects filtered by the vCode column
 * @method     ChildEveApi[]|ObjectCollection findByStatus(string $status) Return ChildEveApi objects filtered by the status column
 * @method     ChildEveApi[]|ObjectCollection findByLastcomputed(string $lastComputed) Return ChildEveApi objects filtered by the lastComputed column
 * @method     ChildEveApi[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EveApiQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\EveApiQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\EveApi', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEveApiQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEveApiQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEveApiQuery) {
            return $criteria;
        }
        $query = new ChildEveApiQuery();
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
     * @return ChildEveApi|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = EveApiTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EveApiTableMap::DATABASE_NAME);
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
     * @return ChildEveApi A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, userId, keyId, vCode, status, lastComputed FROM eveapi WHERE id = :p0';
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
            /** @var ChildEveApi $obj */
            $obj = new ChildEveApi();
            $obj->hydrate($row);
            EveApiTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildEveApi|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildEveApiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(EveApiTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEveApiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(EveApiTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildEveApiQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(EveApiTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(EveApiTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EveApiTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildEveApiQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(EveApiTableMap::COL_USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(EveApiTableMap::COL_USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EveApiTableMap::COL_USERID, $userid, $comparison);
    }

    /**
     * Filter the query on the keyId column
     *
     * Example usage:
     * <code>
     * $query->filterByKeyid(1234); // WHERE keyId = 1234
     * $query->filterByKeyid(array(12, 34)); // WHERE keyId IN (12, 34)
     * $query->filterByKeyid(array('min' => 12)); // WHERE keyId > 12
     * </code>
     *
     * @param     mixed $keyid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEveApiQuery The current query, for fluid interface
     */
    public function filterByKeyid($keyid = null, $comparison = null)
    {
        if (is_array($keyid)) {
            $useMinMax = false;
            if (isset($keyid['min'])) {
                $this->addUsingAlias(EveApiTableMap::COL_KEYID, $keyid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($keyid['max'])) {
                $this->addUsingAlias(EveApiTableMap::COL_KEYID, $keyid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EveApiTableMap::COL_KEYID, $keyid, $comparison);
    }

    /**
     * Filter the query on the vCode column
     *
     * Example usage:
     * <code>
     * $query->filterByVcode('fooValue');   // WHERE vCode = 'fooValue'
     * $query->filterByVcode('%fooValue%'); // WHERE vCode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $vcode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEveApiQuery The current query, for fluid interface
     */
    public function filterByVcode($vcode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($vcode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $vcode)) {
                $vcode = str_replace('*', '%', $vcode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EveApiTableMap::COL_VCODE, $vcode, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%'); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEveApiQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $status)) {
                $status = str_replace('*', '%', $status);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EveApiTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the lastComputed column
     *
     * Example usage:
     * <code>
     * $query->filterByLastcomputed('2011-03-14'); // WHERE lastComputed = '2011-03-14'
     * $query->filterByLastcomputed('now'); // WHERE lastComputed = '2011-03-14'
     * $query->filterByLastcomputed(array('max' => 'yesterday')); // WHERE lastComputed > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastcomputed The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEveApiQuery The current query, for fluid interface
     */
    public function filterByLastcomputed($lastcomputed = null, $comparison = null)
    {
        if (is_array($lastcomputed)) {
            $useMinMax = false;
            if (isset($lastcomputed['min'])) {
                $this->addUsingAlias(EveApiTableMap::COL_LASTCOMPUTED, $lastcomputed['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastcomputed['max'])) {
                $this->addUsingAlias(EveApiTableMap::COL_LASTCOMPUTED, $lastcomputed['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EveApiTableMap::COL_LASTCOMPUTED, $lastcomputed, $comparison);
    }

    /**
     * Filter the query by a related \ECP\User object
     *
     * @param \ECP\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEveApiQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \ECP\User) {
            return $this
                ->addUsingAlias(EveApiTableMap::COL_USERID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EveApiTableMap::COL_USERID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildEveApiQuery The current query, for fluid interface
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
     * Filter the query by a related \ECP\EveCharacter object
     *
     * @param \ECP\EveCharacter|ObjectCollection $eveCharacter the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEveApiQuery The current query, for fluid interface
     */
    public function filterByEveCharacter($eveCharacter, $comparison = null)
    {
        if ($eveCharacter instanceof \ECP\EveCharacter) {
            return $this
                ->addUsingAlias(EveApiTableMap::COL_ID, $eveCharacter->getEveapiid(), $comparison);
        } elseif ($eveCharacter instanceof ObjectCollection) {
            return $this
                ->useEveCharacterQuery()
                ->filterByPrimaryKeys($eveCharacter->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEveCharacter() only accepts arguments of type \ECP\EveCharacter or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EveCharacter relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEveApiQuery The current query, for fluid interface
     */
    public function joinEveCharacter($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EveCharacter');

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
            $this->addJoinObject($join, 'EveCharacter');
        }

        return $this;
    }

    /**
     * Use the EveCharacter relation EveCharacter object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\EveCharacterQuery A secondary query class using the current class as primary query
     */
    public function useEveCharacterQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEveCharacter($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EveCharacter', '\ECP\EveCharacterQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildEveApi $eveApi Object to remove from the list of results
     *
     * @return $this|ChildEveApiQuery The current query, for fluid interface
     */
    public function prune($eveApi = null)
    {
        if ($eveApi) {
            $this->addUsingAlias(EveApiTableMap::COL_ID, $eveApi->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the eveapi table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EveApiTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EveApiTableMap::clearInstancePool();
            EveApiTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EveApiTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EveApiTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            EveApiTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            EveApiTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // EveApiQuery
