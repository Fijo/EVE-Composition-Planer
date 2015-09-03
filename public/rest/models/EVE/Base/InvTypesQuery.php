<?php

namespace EVE\Base;

use \Exception;
use \PDO;
use EVE\InvTypes as ChildInvTypes;
use EVE\InvTypesQuery as ChildInvTypesQuery;
use EVE\Map\InvTypesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'invtypes' table.
 *
 * 
 *
 * @method     ChildInvTypesQuery orderByTypeid($order = Criteria::ASC) Order by the typeID column
 * @method     ChildInvTypesQuery orderByGroupid($order = Criteria::ASC) Order by the groupID column
 * @method     ChildInvTypesQuery orderByTypename($order = Criteria::ASC) Order by the typeName column
 * @method     ChildInvTypesQuery orderByVolume($order = Criteria::ASC) Order by the volume column
 * @method     ChildInvTypesQuery orderByCapacity($order = Criteria::ASC) Order by the capacity column
 * @method     ChildInvTypesQuery orderByPublished($order = Criteria::ASC) Order by the published column
 *
 * @method     ChildInvTypesQuery groupByTypeid() Group by the typeID column
 * @method     ChildInvTypesQuery groupByGroupid() Group by the groupID column
 * @method     ChildInvTypesQuery groupByTypename() Group by the typeName column
 * @method     ChildInvTypesQuery groupByVolume() Group by the volume column
 * @method     ChildInvTypesQuery groupByCapacity() Group by the capacity column
 * @method     ChildInvTypesQuery groupByPublished() Group by the published column
 *
 * @method     ChildInvTypesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInvTypesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInvTypesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInvTypesQuery leftJoinInvGroups($relationAlias = null) Adds a LEFT JOIN clause to the query using the InvGroups relation
 * @method     ChildInvTypesQuery rightJoinInvGroups($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InvGroups relation
 * @method     ChildInvTypesQuery innerJoinInvGroups($relationAlias = null) Adds a INNER JOIN clause to the query using the InvGroups relation
 *
 * @method     ChildInvTypesQuery leftJoinInvMetaTypes($relationAlias = null) Adds a LEFT JOIN clause to the query using the InvMetaTypes relation
 * @method     ChildInvTypesQuery rightJoinInvMetaTypes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InvMetaTypes relation
 * @method     ChildInvTypesQuery innerJoinInvMetaTypes($relationAlias = null) Adds a INNER JOIN clause to the query using the InvMetaTypes relation
 *
 * @method     ChildInvTypesQuery leftJoinDgmTypeEffects($relationAlias = null) Adds a LEFT JOIN clause to the query using the DgmTypeEffects relation
 * @method     ChildInvTypesQuery rightJoinDgmTypeEffects($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DgmTypeEffects relation
 * @method     ChildInvTypesQuery innerJoinDgmTypeEffects($relationAlias = null) Adds a INNER JOIN clause to the query using the DgmTypeEffects relation
 *
 * @method     ChildInvTypesQuery leftJoinDgmTypeAttributes($relationAlias = null) Adds a LEFT JOIN clause to the query using the DgmTypeAttributes relation
 * @method     ChildInvTypesQuery rightJoinDgmTypeAttributes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DgmTypeAttributes relation
 * @method     ChildInvTypesQuery innerJoinDgmTypeAttributes($relationAlias = null) Adds a INNER JOIN clause to the query using the DgmTypeAttributes relation
 *
 * @method     \EVE\InvGroupsQuery|\EVE\InvMetaTypesQuery|\EVE\DgmTypeEffectsQuery|\EVE\DgmTypeAttributesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInvTypes findOne(ConnectionInterface $con = null) Return the first ChildInvTypes matching the query
 * @method     ChildInvTypes findOneOrCreate(ConnectionInterface $con = null) Return the first ChildInvTypes matching the query, or a new ChildInvTypes object populated from the query conditions when no match is found
 *
 * @method     ChildInvTypes findOneByTypeid(int $typeID) Return the first ChildInvTypes filtered by the typeID column
 * @method     ChildInvTypes findOneByGroupid(int $groupID) Return the first ChildInvTypes filtered by the groupID column
 * @method     ChildInvTypes findOneByTypename(string $typeName) Return the first ChildInvTypes filtered by the typeName column
 * @method     ChildInvTypes findOneByVolume(double $volume) Return the first ChildInvTypes filtered by the volume column
 * @method     ChildInvTypes findOneByCapacity(double $capacity) Return the first ChildInvTypes filtered by the capacity column
 * @method     ChildInvTypes findOneByPublished(int $published) Return the first ChildInvTypes filtered by the published column *

 * @method     ChildInvTypes requirePk($key, ConnectionInterface $con = null) Return the ChildInvTypes by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvTypes requireOne(ConnectionInterface $con = null) Return the first ChildInvTypes matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInvTypes requireOneByTypeid(int $typeID) Return the first ChildInvTypes filtered by the typeID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvTypes requireOneByGroupid(int $groupID) Return the first ChildInvTypes filtered by the groupID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvTypes requireOneByTypename(string $typeName) Return the first ChildInvTypes filtered by the typeName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvTypes requireOneByVolume(double $volume) Return the first ChildInvTypes filtered by the volume column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvTypes requireOneByCapacity(double $capacity) Return the first ChildInvTypes filtered by the capacity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvTypes requireOneByPublished(int $published) Return the first ChildInvTypes filtered by the published column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInvTypes[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildInvTypes objects based on current ModelCriteria
 * @method     ChildInvTypes[]|ObjectCollection findByTypeid(int $typeID) Return ChildInvTypes objects filtered by the typeID column
 * @method     ChildInvTypes[]|ObjectCollection findByGroupid(int $groupID) Return ChildInvTypes objects filtered by the groupID column
 * @method     ChildInvTypes[]|ObjectCollection findByTypename(string $typeName) Return ChildInvTypes objects filtered by the typeName column
 * @method     ChildInvTypes[]|ObjectCollection findByVolume(double $volume) Return ChildInvTypes objects filtered by the volume column
 * @method     ChildInvTypes[]|ObjectCollection findByCapacity(double $capacity) Return ChildInvTypes objects filtered by the capacity column
 * @method     ChildInvTypes[]|ObjectCollection findByPublished(int $published) Return ChildInvTypes objects filtered by the published column
 * @method     ChildInvTypes[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class InvTypesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \EVE\Base\InvTypesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'eve', $modelName = '\\EVE\\InvTypes', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInvTypesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInvTypesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildInvTypesQuery) {
            return $criteria;
        }
        $query = new ChildInvTypesQuery();
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
     * @return ChildInvTypes|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = InvTypesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InvTypesTableMap::DATABASE_NAME);
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
     * @return ChildInvTypes A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT typeID, groupID, typeName, volume, capacity, published FROM invtypes WHERE typeID = :p0';
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
            /** @var ChildInvTypes $obj */
            $obj = new ChildInvTypes();
            $obj->hydrate($row);
            InvTypesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildInvTypes|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildInvTypesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(InvTypesTableMap::COL_TYPEID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildInvTypesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(InvTypesTableMap::COL_TYPEID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the typeID column
     *
     * Example usage:
     * <code>
     * $query->filterByTypeid(1234); // WHERE typeID = 1234
     * $query->filterByTypeid(array(12, 34)); // WHERE typeID IN (12, 34)
     * $query->filterByTypeid(array('min' => 12)); // WHERE typeID > 12
     * </code>
     *
     * @param     mixed $typeid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvTypesQuery The current query, for fluid interface
     */
    public function filterByTypeid($typeid = null, $comparison = null)
    {
        if (is_array($typeid)) {
            $useMinMax = false;
            if (isset($typeid['min'])) {
                $this->addUsingAlias(InvTypesTableMap::COL_TYPEID, $typeid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeid['max'])) {
                $this->addUsingAlias(InvTypesTableMap::COL_TYPEID, $typeid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InvTypesTableMap::COL_TYPEID, $typeid, $comparison);
    }

    /**
     * Filter the query on the groupID column
     *
     * Example usage:
     * <code>
     * $query->filterByGroupid(1234); // WHERE groupID = 1234
     * $query->filterByGroupid(array(12, 34)); // WHERE groupID IN (12, 34)
     * $query->filterByGroupid(array('min' => 12)); // WHERE groupID > 12
     * </code>
     *
     * @see       filterByInvGroups()
     *
     * @param     mixed $groupid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvTypesQuery The current query, for fluid interface
     */
    public function filterByGroupid($groupid = null, $comparison = null)
    {
        if (is_array($groupid)) {
            $useMinMax = false;
            if (isset($groupid['min'])) {
                $this->addUsingAlias(InvTypesTableMap::COL_GROUPID, $groupid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($groupid['max'])) {
                $this->addUsingAlias(InvTypesTableMap::COL_GROUPID, $groupid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InvTypesTableMap::COL_GROUPID, $groupid, $comparison);
    }

    /**
     * Filter the query on the typeName column
     *
     * Example usage:
     * <code>
     * $query->filterByTypename('fooValue');   // WHERE typeName = 'fooValue'
     * $query->filterByTypename('%fooValue%'); // WHERE typeName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $typename The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvTypesQuery The current query, for fluid interface
     */
    public function filterByTypename($typename = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($typename)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $typename)) {
                $typename = str_replace('*', '%', $typename);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(InvTypesTableMap::COL_TYPENAME, $typename, $comparison);
    }

    /**
     * Filter the query on the volume column
     *
     * Example usage:
     * <code>
     * $query->filterByVolume(1234); // WHERE volume = 1234
     * $query->filterByVolume(array(12, 34)); // WHERE volume IN (12, 34)
     * $query->filterByVolume(array('min' => 12)); // WHERE volume > 12
     * </code>
     *
     * @param     mixed $volume The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvTypesQuery The current query, for fluid interface
     */
    public function filterByVolume($volume = null, $comparison = null)
    {
        if (is_array($volume)) {
            $useMinMax = false;
            if (isset($volume['min'])) {
                $this->addUsingAlias(InvTypesTableMap::COL_VOLUME, $volume['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($volume['max'])) {
                $this->addUsingAlias(InvTypesTableMap::COL_VOLUME, $volume['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InvTypesTableMap::COL_VOLUME, $volume, $comparison);
    }

    /**
     * Filter the query on the capacity column
     *
     * Example usage:
     * <code>
     * $query->filterByCapacity(1234); // WHERE capacity = 1234
     * $query->filterByCapacity(array(12, 34)); // WHERE capacity IN (12, 34)
     * $query->filterByCapacity(array('min' => 12)); // WHERE capacity > 12
     * </code>
     *
     * @param     mixed $capacity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvTypesQuery The current query, for fluid interface
     */
    public function filterByCapacity($capacity = null, $comparison = null)
    {
        if (is_array($capacity)) {
            $useMinMax = false;
            if (isset($capacity['min'])) {
                $this->addUsingAlias(InvTypesTableMap::COL_CAPACITY, $capacity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($capacity['max'])) {
                $this->addUsingAlias(InvTypesTableMap::COL_CAPACITY, $capacity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InvTypesTableMap::COL_CAPACITY, $capacity, $comparison);
    }

    /**
     * Filter the query on the published column
     *
     * Example usage:
     * <code>
     * $query->filterByPublished(1234); // WHERE published = 1234
     * $query->filterByPublished(array(12, 34)); // WHERE published IN (12, 34)
     * $query->filterByPublished(array('min' => 12)); // WHERE published > 12
     * </code>
     *
     * @param     mixed $published The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvTypesQuery The current query, for fluid interface
     */
    public function filterByPublished($published = null, $comparison = null)
    {
        if (is_array($published)) {
            $useMinMax = false;
            if (isset($published['min'])) {
                $this->addUsingAlias(InvTypesTableMap::COL_PUBLISHED, $published['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($published['max'])) {
                $this->addUsingAlias(InvTypesTableMap::COL_PUBLISHED, $published['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InvTypesTableMap::COL_PUBLISHED, $published, $comparison);
    }

    /**
     * Filter the query by a related \EVE\InvGroups object
     *
     * @param \EVE\InvGroups|ObjectCollection $invGroups The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInvTypesQuery The current query, for fluid interface
     */
    public function filterByInvGroups($invGroups, $comparison = null)
    {
        if ($invGroups instanceof \EVE\InvGroups) {
            return $this
                ->addUsingAlias(InvTypesTableMap::COL_GROUPID, $invGroups->getGroupid(), $comparison);
        } elseif ($invGroups instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InvTypesTableMap::COL_GROUPID, $invGroups->toKeyValue('PrimaryKey', 'Groupid'), $comparison);
        } else {
            throw new PropelException('filterByInvGroups() only accepts arguments of type \EVE\InvGroups or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the InvGroups relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInvTypesQuery The current query, for fluid interface
     */
    public function joinInvGroups($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('InvGroups');

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
            $this->addJoinObject($join, 'InvGroups');
        }

        return $this;
    }

    /**
     * Use the InvGroups relation InvGroups object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EVE\InvGroupsQuery A secondary query class using the current class as primary query
     */
    public function useInvGroupsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInvGroups($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'InvGroups', '\EVE\InvGroupsQuery');
    }

    /**
     * Filter the query by a related \EVE\InvMetaTypes object
     *
     * @param \EVE\InvMetaTypes|ObjectCollection $invMetaTypes the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInvTypesQuery The current query, for fluid interface
     */
    public function filterByInvMetaTypes($invMetaTypes, $comparison = null)
    {
        if ($invMetaTypes instanceof \EVE\InvMetaTypes) {
            return $this
                ->addUsingAlias(InvTypesTableMap::COL_TYPEID, $invMetaTypes->getTypeid(), $comparison);
        } elseif ($invMetaTypes instanceof ObjectCollection) {
            return $this
                ->useInvMetaTypesQuery()
                ->filterByPrimaryKeys($invMetaTypes->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByInvMetaTypes() only accepts arguments of type \EVE\InvMetaTypes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the InvMetaTypes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInvTypesQuery The current query, for fluid interface
     */
    public function joinInvMetaTypes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('InvMetaTypes');

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
            $this->addJoinObject($join, 'InvMetaTypes');
        }

        return $this;
    }

    /**
     * Use the InvMetaTypes relation InvMetaTypes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EVE\InvMetaTypesQuery A secondary query class using the current class as primary query
     */
    public function useInvMetaTypesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInvMetaTypes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'InvMetaTypes', '\EVE\InvMetaTypesQuery');
    }

    /**
     * Filter the query by a related \EVE\DgmTypeEffects object
     *
     * @param \EVE\DgmTypeEffects|ObjectCollection $dgmTypeEffects the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInvTypesQuery The current query, for fluid interface
     */
    public function filterByDgmTypeEffects($dgmTypeEffects, $comparison = null)
    {
        if ($dgmTypeEffects instanceof \EVE\DgmTypeEffects) {
            return $this
                ->addUsingAlias(InvTypesTableMap::COL_TYPEID, $dgmTypeEffects->getTypeid(), $comparison);
        } elseif ($dgmTypeEffects instanceof ObjectCollection) {
            return $this
                ->useDgmTypeEffectsQuery()
                ->filterByPrimaryKeys($dgmTypeEffects->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDgmTypeEffects() only accepts arguments of type \EVE\DgmTypeEffects or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DgmTypeEffects relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInvTypesQuery The current query, for fluid interface
     */
    public function joinDgmTypeEffects($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DgmTypeEffects');

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
            $this->addJoinObject($join, 'DgmTypeEffects');
        }

        return $this;
    }

    /**
     * Use the DgmTypeEffects relation DgmTypeEffects object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EVE\DgmTypeEffectsQuery A secondary query class using the current class as primary query
     */
    public function useDgmTypeEffectsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDgmTypeEffects($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DgmTypeEffects', '\EVE\DgmTypeEffectsQuery');
    }

    /**
     * Filter the query by a related \EVE\DgmTypeAttributes object
     *
     * @param \EVE\DgmTypeAttributes|ObjectCollection $dgmTypeAttributes the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInvTypesQuery The current query, for fluid interface
     */
    public function filterByDgmTypeAttributes($dgmTypeAttributes, $comparison = null)
    {
        if ($dgmTypeAttributes instanceof \EVE\DgmTypeAttributes) {
            return $this
                ->addUsingAlias(InvTypesTableMap::COL_TYPEID, $dgmTypeAttributes->getTypeid(), $comparison);
        } elseif ($dgmTypeAttributes instanceof ObjectCollection) {
            return $this
                ->useDgmTypeAttributesQuery()
                ->filterByPrimaryKeys($dgmTypeAttributes->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDgmTypeAttributes() only accepts arguments of type \EVE\DgmTypeAttributes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DgmTypeAttributes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInvTypesQuery The current query, for fluid interface
     */
    public function joinDgmTypeAttributes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DgmTypeAttributes');

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
            $this->addJoinObject($join, 'DgmTypeAttributes');
        }

        return $this;
    }

    /**
     * Use the DgmTypeAttributes relation DgmTypeAttributes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EVE\DgmTypeAttributesQuery A secondary query class using the current class as primary query
     */
    public function useDgmTypeAttributesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDgmTypeAttributes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DgmTypeAttributes', '\EVE\DgmTypeAttributesQuery');
    }

    /**
     * Filter the query by a related DgmEffects object
     * using the dgmtypeeffects table as cross reference
     *
     * @param DgmEffects $dgmEffects the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInvTypesQuery The current query, for fluid interface
     */
    public function filterByDgmEffects($dgmEffects, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useDgmTypeEffectsQuery()
            ->filterByDgmEffects($dgmEffects, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related DgmAttributeTypes object
     * using the dgmtypeattributes table as cross reference
     *
     * @param DgmAttributeTypes $dgmAttributeTypes the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInvTypesQuery The current query, for fluid interface
     */
    public function filterByDgmAttributeTypes($dgmAttributeTypes, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useDgmTypeAttributesQuery()
            ->filterByDgmAttributeTypes($dgmAttributeTypes, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildInvTypes $invTypes Object to remove from the list of results
     *
     * @return $this|ChildInvTypesQuery The current query, for fluid interface
     */
    public function prune($invTypes = null)
    {
        if ($invTypes) {
            $this->addUsingAlias(InvTypesTableMap::COL_TYPEID, $invTypes->getTypeid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the invtypes table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InvTypesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InvTypesTableMap::clearInstancePool();
            InvTypesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(InvTypesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InvTypesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            InvTypesTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            InvTypesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // InvTypesQuery
