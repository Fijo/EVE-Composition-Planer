<?php

namespace EVE\Base;

use \Exception;
use \PDO;
use EVE\DgmTypeAttributes as ChildDgmTypeAttributes;
use EVE\DgmTypeAttributesQuery as ChildDgmTypeAttributesQuery;
use EVE\Map\DgmTypeAttributesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'dgmtypeattributes' table.
 *
 * 
 *
 * @method     ChildDgmTypeAttributesQuery orderByTypeid($order = Criteria::ASC) Order by the typeID column
 * @method     ChildDgmTypeAttributesQuery orderByAttributeid($order = Criteria::ASC) Order by the attributeID column
 * @method     ChildDgmTypeAttributesQuery orderByValueint($order = Criteria::ASC) Order by the valueInt column
 * @method     ChildDgmTypeAttributesQuery orderByValuefloat($order = Criteria::ASC) Order by the valueFloat column
 *
 * @method     ChildDgmTypeAttributesQuery groupByTypeid() Group by the typeID column
 * @method     ChildDgmTypeAttributesQuery groupByAttributeid() Group by the attributeID column
 * @method     ChildDgmTypeAttributesQuery groupByValueint() Group by the valueInt column
 * @method     ChildDgmTypeAttributesQuery groupByValuefloat() Group by the valueFloat column
 *
 * @method     ChildDgmTypeAttributesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDgmTypeAttributesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDgmTypeAttributesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDgmTypeAttributesQuery leftJoinInvTypes($relationAlias = null) Adds a LEFT JOIN clause to the query using the InvTypes relation
 * @method     ChildDgmTypeAttributesQuery rightJoinInvTypes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InvTypes relation
 * @method     ChildDgmTypeAttributesQuery innerJoinInvTypes($relationAlias = null) Adds a INNER JOIN clause to the query using the InvTypes relation
 *
 * @method     ChildDgmTypeAttributesQuery leftJoinDgmAttributeTypes($relationAlias = null) Adds a LEFT JOIN clause to the query using the DgmAttributeTypes relation
 * @method     ChildDgmTypeAttributesQuery rightJoinDgmAttributeTypes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DgmAttributeTypes relation
 * @method     ChildDgmTypeAttributesQuery innerJoinDgmAttributeTypes($relationAlias = null) Adds a INNER JOIN clause to the query using the DgmAttributeTypes relation
 *
 * @method     \EVE\InvTypesQuery|\EVE\DgmAttributeTypesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDgmTypeAttributes findOne(ConnectionInterface $con = null) Return the first ChildDgmTypeAttributes matching the query
 * @method     ChildDgmTypeAttributes findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDgmTypeAttributes matching the query, or a new ChildDgmTypeAttributes object populated from the query conditions when no match is found
 *
 * @method     ChildDgmTypeAttributes findOneByTypeid(int $typeID) Return the first ChildDgmTypeAttributes filtered by the typeID column
 * @method     ChildDgmTypeAttributes findOneByAttributeid(int $attributeID) Return the first ChildDgmTypeAttributes filtered by the attributeID column
 * @method     ChildDgmTypeAttributes findOneByValueint(int $valueInt) Return the first ChildDgmTypeAttributes filtered by the valueInt column
 * @method     ChildDgmTypeAttributes findOneByValuefloat(double $valueFloat) Return the first ChildDgmTypeAttributes filtered by the valueFloat column *

 * @method     ChildDgmTypeAttributes requirePk($key, ConnectionInterface $con = null) Return the ChildDgmTypeAttributes by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDgmTypeAttributes requireOne(ConnectionInterface $con = null) Return the first ChildDgmTypeAttributes matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDgmTypeAttributes requireOneByTypeid(int $typeID) Return the first ChildDgmTypeAttributes filtered by the typeID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDgmTypeAttributes requireOneByAttributeid(int $attributeID) Return the first ChildDgmTypeAttributes filtered by the attributeID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDgmTypeAttributes requireOneByValueint(int $valueInt) Return the first ChildDgmTypeAttributes filtered by the valueInt column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDgmTypeAttributes requireOneByValuefloat(double $valueFloat) Return the first ChildDgmTypeAttributes filtered by the valueFloat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDgmTypeAttributes[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDgmTypeAttributes objects based on current ModelCriteria
 * @method     ChildDgmTypeAttributes[]|ObjectCollection findByTypeid(int $typeID) Return ChildDgmTypeAttributes objects filtered by the typeID column
 * @method     ChildDgmTypeAttributes[]|ObjectCollection findByAttributeid(int $attributeID) Return ChildDgmTypeAttributes objects filtered by the attributeID column
 * @method     ChildDgmTypeAttributes[]|ObjectCollection findByValueint(int $valueInt) Return ChildDgmTypeAttributes objects filtered by the valueInt column
 * @method     ChildDgmTypeAttributes[]|ObjectCollection findByValuefloat(double $valueFloat) Return ChildDgmTypeAttributes objects filtered by the valueFloat column
 * @method     ChildDgmTypeAttributes[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DgmTypeAttributesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \EVE\Base\DgmTypeAttributesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'eve', $modelName = '\\EVE\\DgmTypeAttributes', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDgmTypeAttributesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDgmTypeAttributesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDgmTypeAttributesQuery) {
            return $criteria;
        }
        $query = new ChildDgmTypeAttributesQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$typeID, $attributeID] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildDgmTypeAttributes|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DgmTypeAttributesTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DgmTypeAttributesTableMap::DATABASE_NAME);
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
     * @return ChildDgmTypeAttributes A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT typeID, attributeID, valueInt, valueFloat FROM dgmtypeattributes WHERE typeID = :p0 AND attributeID = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildDgmTypeAttributes $obj */
            $obj = new ChildDgmTypeAttributes();
            $obj->hydrate($row);
            DgmTypeAttributesTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildDgmTypeAttributes|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildDgmTypeAttributesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(DgmTypeAttributesTableMap::COL_TYPEID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(DgmTypeAttributesTableMap::COL_ATTRIBUTEID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDgmTypeAttributesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(DgmTypeAttributesTableMap::COL_TYPEID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(DgmTypeAttributesTableMap::COL_ATTRIBUTEID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByInvTypes()
     *
     * @param     mixed $typeid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDgmTypeAttributesQuery The current query, for fluid interface
     */
    public function filterByTypeid($typeid = null, $comparison = null)
    {
        if (is_array($typeid)) {
            $useMinMax = false;
            if (isset($typeid['min'])) {
                $this->addUsingAlias(DgmTypeAttributesTableMap::COL_TYPEID, $typeid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeid['max'])) {
                $this->addUsingAlias(DgmTypeAttributesTableMap::COL_TYPEID, $typeid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DgmTypeAttributesTableMap::COL_TYPEID, $typeid, $comparison);
    }

    /**
     * Filter the query on the attributeID column
     *
     * Example usage:
     * <code>
     * $query->filterByAttributeid(1234); // WHERE attributeID = 1234
     * $query->filterByAttributeid(array(12, 34)); // WHERE attributeID IN (12, 34)
     * $query->filterByAttributeid(array('min' => 12)); // WHERE attributeID > 12
     * </code>
     *
     * @see       filterByDgmAttributeTypes()
     *
     * @param     mixed $attributeid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDgmTypeAttributesQuery The current query, for fluid interface
     */
    public function filterByAttributeid($attributeid = null, $comparison = null)
    {
        if (is_array($attributeid)) {
            $useMinMax = false;
            if (isset($attributeid['min'])) {
                $this->addUsingAlias(DgmTypeAttributesTableMap::COL_ATTRIBUTEID, $attributeid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($attributeid['max'])) {
                $this->addUsingAlias(DgmTypeAttributesTableMap::COL_ATTRIBUTEID, $attributeid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DgmTypeAttributesTableMap::COL_ATTRIBUTEID, $attributeid, $comparison);
    }

    /**
     * Filter the query on the valueInt column
     *
     * Example usage:
     * <code>
     * $query->filterByValueint(1234); // WHERE valueInt = 1234
     * $query->filterByValueint(array(12, 34)); // WHERE valueInt IN (12, 34)
     * $query->filterByValueint(array('min' => 12)); // WHERE valueInt > 12
     * </code>
     *
     * @param     mixed $valueint The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDgmTypeAttributesQuery The current query, for fluid interface
     */
    public function filterByValueint($valueint = null, $comparison = null)
    {
        if (is_array($valueint)) {
            $useMinMax = false;
            if (isset($valueint['min'])) {
                $this->addUsingAlias(DgmTypeAttributesTableMap::COL_VALUEINT, $valueint['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($valueint['max'])) {
                $this->addUsingAlias(DgmTypeAttributesTableMap::COL_VALUEINT, $valueint['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DgmTypeAttributesTableMap::COL_VALUEINT, $valueint, $comparison);
    }

    /**
     * Filter the query on the valueFloat column
     *
     * Example usage:
     * <code>
     * $query->filterByValuefloat(1234); // WHERE valueFloat = 1234
     * $query->filterByValuefloat(array(12, 34)); // WHERE valueFloat IN (12, 34)
     * $query->filterByValuefloat(array('min' => 12)); // WHERE valueFloat > 12
     * </code>
     *
     * @param     mixed $valuefloat The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDgmTypeAttributesQuery The current query, for fluid interface
     */
    public function filterByValuefloat($valuefloat = null, $comparison = null)
    {
        if (is_array($valuefloat)) {
            $useMinMax = false;
            if (isset($valuefloat['min'])) {
                $this->addUsingAlias(DgmTypeAttributesTableMap::COL_VALUEFLOAT, $valuefloat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($valuefloat['max'])) {
                $this->addUsingAlias(DgmTypeAttributesTableMap::COL_VALUEFLOAT, $valuefloat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DgmTypeAttributesTableMap::COL_VALUEFLOAT, $valuefloat, $comparison);
    }

    /**
     * Filter the query by a related \EVE\InvTypes object
     *
     * @param \EVE\InvTypes|ObjectCollection $invTypes The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDgmTypeAttributesQuery The current query, for fluid interface
     */
    public function filterByInvTypes($invTypes, $comparison = null)
    {
        if ($invTypes instanceof \EVE\InvTypes) {
            return $this
                ->addUsingAlias(DgmTypeAttributesTableMap::COL_TYPEID, $invTypes->getTypeid(), $comparison);
        } elseif ($invTypes instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DgmTypeAttributesTableMap::COL_TYPEID, $invTypes->toKeyValue('PrimaryKey', 'Typeid'), $comparison);
        } else {
            throw new PropelException('filterByInvTypes() only accepts arguments of type \EVE\InvTypes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the InvTypes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDgmTypeAttributesQuery The current query, for fluid interface
     */
    public function joinInvTypes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('InvTypes');

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
            $this->addJoinObject($join, 'InvTypes');
        }

        return $this;
    }

    /**
     * Use the InvTypes relation InvTypes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EVE\InvTypesQuery A secondary query class using the current class as primary query
     */
    public function useInvTypesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInvTypes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'InvTypes', '\EVE\InvTypesQuery');
    }

    /**
     * Filter the query by a related \EVE\DgmAttributeTypes object
     *
     * @param \EVE\DgmAttributeTypes|ObjectCollection $dgmAttributeTypes The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDgmTypeAttributesQuery The current query, for fluid interface
     */
    public function filterByDgmAttributeTypes($dgmAttributeTypes, $comparison = null)
    {
        if ($dgmAttributeTypes instanceof \EVE\DgmAttributeTypes) {
            return $this
                ->addUsingAlias(DgmTypeAttributesTableMap::COL_ATTRIBUTEID, $dgmAttributeTypes->getAttributeid(), $comparison);
        } elseif ($dgmAttributeTypes instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DgmTypeAttributesTableMap::COL_ATTRIBUTEID, $dgmAttributeTypes->toKeyValue('PrimaryKey', 'Attributeid'), $comparison);
        } else {
            throw new PropelException('filterByDgmAttributeTypes() only accepts arguments of type \EVE\DgmAttributeTypes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DgmAttributeTypes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDgmTypeAttributesQuery The current query, for fluid interface
     */
    public function joinDgmAttributeTypes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DgmAttributeTypes');

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
            $this->addJoinObject($join, 'DgmAttributeTypes');
        }

        return $this;
    }

    /**
     * Use the DgmAttributeTypes relation DgmAttributeTypes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EVE\DgmAttributeTypesQuery A secondary query class using the current class as primary query
     */
    public function useDgmAttributeTypesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDgmAttributeTypes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DgmAttributeTypes', '\EVE\DgmAttributeTypesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDgmTypeAttributes $dgmTypeAttributes Object to remove from the list of results
     *
     * @return $this|ChildDgmTypeAttributesQuery The current query, for fluid interface
     */
    public function prune($dgmTypeAttributes = null)
    {
        if ($dgmTypeAttributes) {
            $this->addCond('pruneCond0', $this->getAliasedColName(DgmTypeAttributesTableMap::COL_TYPEID), $dgmTypeAttributes->getTypeid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(DgmTypeAttributesTableMap::COL_ATTRIBUTEID), $dgmTypeAttributes->getAttributeid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the dgmtypeattributes table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DgmTypeAttributesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DgmTypeAttributesTableMap::clearInstancePool();
            DgmTypeAttributesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DgmTypeAttributesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DgmTypeAttributesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            DgmTypeAttributesTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            DgmTypeAttributesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DgmTypeAttributesQuery
