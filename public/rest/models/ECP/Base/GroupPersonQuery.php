<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\GroupPerson as ChildGroupPerson;
use ECP\GroupPersonQuery as ChildGroupPersonQuery;
use ECP\Map\GroupPersonTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'groupperson' table.
 *
 * 
 *
 * @method     ChildGroupPersonQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGroupPersonQuery orderByGroupid($order = Criteria::ASC) Order by the groupId column
 * @method     ChildGroupPersonQuery orderByGrouppersontypeid($order = Criteria::ASC) Order by the groupPersonTypeId column
 * @method     ChildGroupPersonQuery orderByGroupevepersonid($order = Criteria::ASC) Order by the groupEvePersonId column
 * @method     ChildGroupPersonQuery orderByUserid($order = Criteria::ASC) Order by the userId column
 *
 * @method     ChildGroupPersonQuery groupById() Group by the id column
 * @method     ChildGroupPersonQuery groupByGroupid() Group by the groupId column
 * @method     ChildGroupPersonQuery groupByGrouppersontypeid() Group by the groupPersonTypeId column
 * @method     ChildGroupPersonQuery groupByGroupevepersonid() Group by the groupEvePersonId column
 * @method     ChildGroupPersonQuery groupByUserid() Group by the userId column
 *
 * @method     ChildGroupPersonQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGroupPersonQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGroupPersonQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGroupPersonQuery leftJoinGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the Group relation
 * @method     ChildGroupPersonQuery rightJoinGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Group relation
 * @method     ChildGroupPersonQuery innerJoinGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the Group relation
 *
 * @method     ChildGroupPersonQuery leftJoinGroupPersonType($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupPersonType relation
 * @method     ChildGroupPersonQuery rightJoinGroupPersonType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupPersonType relation
 * @method     ChildGroupPersonQuery innerJoinGroupPersonType($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupPersonType relation
 *
 * @method     ChildGroupPersonQuery leftJoinGroupEvePerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupEvePerson relation
 * @method     ChildGroupPersonQuery rightJoinGroupEvePerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupEvePerson relation
 * @method     ChildGroupPersonQuery innerJoinGroupEvePerson($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupEvePerson relation
 *
 * @method     ChildGroupPersonQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildGroupPersonQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildGroupPersonQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     \ECP\GroupQuery|\ECP\GroupPersonTypeQuery|\ECP\GroupEvePersonQuery|\ECP\UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGroupPerson findOne(ConnectionInterface $con = null) Return the first ChildGroupPerson matching the query
 * @method     ChildGroupPerson findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGroupPerson matching the query, or a new ChildGroupPerson object populated from the query conditions when no match is found
 *
 * @method     ChildGroupPerson findOneById(int $id) Return the first ChildGroupPerson filtered by the id column
 * @method     ChildGroupPerson findOneByGroupid(int $groupId) Return the first ChildGroupPerson filtered by the groupId column
 * @method     ChildGroupPerson findOneByGrouppersontypeid(int $groupPersonTypeId) Return the first ChildGroupPerson filtered by the groupPersonTypeId column
 * @method     ChildGroupPerson findOneByGroupevepersonid(int $groupEvePersonId) Return the first ChildGroupPerson filtered by the groupEvePersonId column
 * @method     ChildGroupPerson findOneByUserid(int $userId) Return the first ChildGroupPerson filtered by the userId column *

 * @method     ChildGroupPerson requirePk($key, ConnectionInterface $con = null) Return the ChildGroupPerson by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroupPerson requireOne(ConnectionInterface $con = null) Return the first ChildGroupPerson matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGroupPerson requireOneById(int $id) Return the first ChildGroupPerson filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroupPerson requireOneByGroupid(int $groupId) Return the first ChildGroupPerson filtered by the groupId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroupPerson requireOneByGrouppersontypeid(int $groupPersonTypeId) Return the first ChildGroupPerson filtered by the groupPersonTypeId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroupPerson requireOneByGroupevepersonid(int $groupEvePersonId) Return the first ChildGroupPerson filtered by the groupEvePersonId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroupPerson requireOneByUserid(int $userId) Return the first ChildGroupPerson filtered by the userId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGroupPerson[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGroupPerson objects based on current ModelCriteria
 * @method     ChildGroupPerson[]|ObjectCollection findById(int $id) Return ChildGroupPerson objects filtered by the id column
 * @method     ChildGroupPerson[]|ObjectCollection findByGroupid(int $groupId) Return ChildGroupPerson objects filtered by the groupId column
 * @method     ChildGroupPerson[]|ObjectCollection findByGrouppersontypeid(int $groupPersonTypeId) Return ChildGroupPerson objects filtered by the groupPersonTypeId column
 * @method     ChildGroupPerson[]|ObjectCollection findByGroupevepersonid(int $groupEvePersonId) Return ChildGroupPerson objects filtered by the groupEvePersonId column
 * @method     ChildGroupPerson[]|ObjectCollection findByUserid(int $userId) Return ChildGroupPerson objects filtered by the userId column
 * @method     ChildGroupPerson[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GroupPersonQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\GroupPersonQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\GroupPerson', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGroupPersonQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGroupPersonQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGroupPersonQuery) {
            return $criteria;
        }
        $query = new ChildGroupPersonQuery();
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
     * @return ChildGroupPerson|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GroupPersonTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GroupPersonTableMap::DATABASE_NAME);
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
     * @return ChildGroupPerson A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, groupId, groupPersonTypeId, groupEvePersonId, userId FROM groupperson WHERE id = :p0';
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
            /** @var ChildGroupPerson $obj */
            $obj = new ChildGroupPerson();
            $obj->hydrate($row);
            GroupPersonTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildGroupPerson|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGroupPersonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GroupPersonTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGroupPersonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GroupPersonTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildGroupPersonQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GroupPersonTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GroupPersonTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupPersonTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the groupId column
     *
     * Example usage:
     * <code>
     * $query->filterByGroupid(1234); // WHERE groupId = 1234
     * $query->filterByGroupid(array(12, 34)); // WHERE groupId IN (12, 34)
     * $query->filterByGroupid(array('min' => 12)); // WHERE groupId > 12
     * </code>
     *
     * @see       filterByGroup()
     *
     * @param     mixed $groupid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGroupPersonQuery The current query, for fluid interface
     */
    public function filterByGroupid($groupid = null, $comparison = null)
    {
        if (is_array($groupid)) {
            $useMinMax = false;
            if (isset($groupid['min'])) {
                $this->addUsingAlias(GroupPersonTableMap::COL_GROUPID, $groupid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($groupid['max'])) {
                $this->addUsingAlias(GroupPersonTableMap::COL_GROUPID, $groupid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupPersonTableMap::COL_GROUPID, $groupid, $comparison);
    }

    /**
     * Filter the query on the groupPersonTypeId column
     *
     * Example usage:
     * <code>
     * $query->filterByGrouppersontypeid(1234); // WHERE groupPersonTypeId = 1234
     * $query->filterByGrouppersontypeid(array(12, 34)); // WHERE groupPersonTypeId IN (12, 34)
     * $query->filterByGrouppersontypeid(array('min' => 12)); // WHERE groupPersonTypeId > 12
     * </code>
     *
     * @see       filterByGroupPersonType()
     *
     * @param     mixed $grouppersontypeid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGroupPersonQuery The current query, for fluid interface
     */
    public function filterByGrouppersontypeid($grouppersontypeid = null, $comparison = null)
    {
        if (is_array($grouppersontypeid)) {
            $useMinMax = false;
            if (isset($grouppersontypeid['min'])) {
                $this->addUsingAlias(GroupPersonTableMap::COL_GROUPPERSONTYPEID, $grouppersontypeid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($grouppersontypeid['max'])) {
                $this->addUsingAlias(GroupPersonTableMap::COL_GROUPPERSONTYPEID, $grouppersontypeid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupPersonTableMap::COL_GROUPPERSONTYPEID, $grouppersontypeid, $comparison);
    }

    /**
     * Filter the query on the groupEvePersonId column
     *
     * Example usage:
     * <code>
     * $query->filterByGroupevepersonid(1234); // WHERE groupEvePersonId = 1234
     * $query->filterByGroupevepersonid(array(12, 34)); // WHERE groupEvePersonId IN (12, 34)
     * $query->filterByGroupevepersonid(array('min' => 12)); // WHERE groupEvePersonId > 12
     * </code>
     *
     * @see       filterByGroupEvePerson()
     *
     * @param     mixed $groupevepersonid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGroupPersonQuery The current query, for fluid interface
     */
    public function filterByGroupevepersonid($groupevepersonid = null, $comparison = null)
    {
        if (is_array($groupevepersonid)) {
            $useMinMax = false;
            if (isset($groupevepersonid['min'])) {
                $this->addUsingAlias(GroupPersonTableMap::COL_GROUPEVEPERSONID, $groupevepersonid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($groupevepersonid['max'])) {
                $this->addUsingAlias(GroupPersonTableMap::COL_GROUPEVEPERSONID, $groupevepersonid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupPersonTableMap::COL_GROUPEVEPERSONID, $groupevepersonid, $comparison);
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
     * @return $this|ChildGroupPersonQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(GroupPersonTableMap::COL_USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(GroupPersonTableMap::COL_USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupPersonTableMap::COL_USERID, $userid, $comparison);
    }

    /**
     * Filter the query by a related \ECP\Group object
     *
     * @param \ECP\Group|ObjectCollection $group The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGroupPersonQuery The current query, for fluid interface
     */
    public function filterByGroup($group, $comparison = null)
    {
        if ($group instanceof \ECP\Group) {
            return $this
                ->addUsingAlias(GroupPersonTableMap::COL_GROUPID, $group->getId(), $comparison);
        } elseif ($group instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GroupPersonTableMap::COL_GROUPID, $group->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGroup() only accepts arguments of type \ECP\Group or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Group relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupPersonQuery The current query, for fluid interface
     */
    public function joinGroup($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Group');

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
            $this->addJoinObject($join, 'Group');
        }

        return $this;
    }

    /**
     * Use the Group relation Group object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\GroupQuery A secondary query class using the current class as primary query
     */
    public function useGroupQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Group', '\ECP\GroupQuery');
    }

    /**
     * Filter the query by a related \ECP\GroupPersonType object
     *
     * @param \ECP\GroupPersonType|ObjectCollection $groupPersonType The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGroupPersonQuery The current query, for fluid interface
     */
    public function filterByGroupPersonType($groupPersonType, $comparison = null)
    {
        if ($groupPersonType instanceof \ECP\GroupPersonType) {
            return $this
                ->addUsingAlias(GroupPersonTableMap::COL_GROUPPERSONTYPEID, $groupPersonType->getId(), $comparison);
        } elseif ($groupPersonType instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GroupPersonTableMap::COL_GROUPPERSONTYPEID, $groupPersonType->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGroupPersonType() only accepts arguments of type \ECP\GroupPersonType or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupPersonType relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupPersonQuery The current query, for fluid interface
     */
    public function joinGroupPersonType($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupPersonType');

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
            $this->addJoinObject($join, 'GroupPersonType');
        }

        return $this;
    }

    /**
     * Use the GroupPersonType relation GroupPersonType object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\GroupPersonTypeQuery A secondary query class using the current class as primary query
     */
    public function useGroupPersonTypeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroupPersonType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupPersonType', '\ECP\GroupPersonTypeQuery');
    }

    /**
     * Filter the query by a related \ECP\GroupEvePerson object
     *
     * @param \ECP\GroupEvePerson|ObjectCollection $groupEvePerson The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGroupPersonQuery The current query, for fluid interface
     */
    public function filterByGroupEvePerson($groupEvePerson, $comparison = null)
    {
        if ($groupEvePerson instanceof \ECP\GroupEvePerson) {
            return $this
                ->addUsingAlias(GroupPersonTableMap::COL_GROUPEVEPERSONID, $groupEvePerson->getId(), $comparison);
        } elseif ($groupEvePerson instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GroupPersonTableMap::COL_GROUPEVEPERSONID, $groupEvePerson->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGroupEvePerson() only accepts arguments of type \ECP\GroupEvePerson or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupEvePerson relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupPersonQuery The current query, for fluid interface
     */
    public function joinGroupEvePerson($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupEvePerson');

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
            $this->addJoinObject($join, 'GroupEvePerson');
        }

        return $this;
    }

    /**
     * Use the GroupEvePerson relation GroupEvePerson object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\GroupEvePersonQuery A secondary query class using the current class as primary query
     */
    public function useGroupEvePersonQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroupEvePerson($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupEvePerson', '\ECP\GroupEvePersonQuery');
    }

    /**
     * Filter the query by a related \ECP\User object
     *
     * @param \ECP\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGroupPersonQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \ECP\User) {
            return $this
                ->addUsingAlias(GroupPersonTableMap::COL_USERID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GroupPersonTableMap::COL_USERID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildGroupPersonQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildGroupPerson $groupPerson Object to remove from the list of results
     *
     * @return $this|ChildGroupPersonQuery The current query, for fluid interface
     */
    public function prune($groupPerson = null)
    {
        if ($groupPerson) {
            $this->addUsingAlias(GroupPersonTableMap::COL_ID, $groupPerson->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the groupperson table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GroupPersonTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GroupPersonTableMap::clearInstancePool();
            GroupPersonTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GroupPersonTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GroupPersonTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            GroupPersonTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            GroupPersonTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GroupPersonQuery
