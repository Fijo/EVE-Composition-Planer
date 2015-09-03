<?php

namespace EVE\Base;

use \Exception;
use \PDO;
use EVE\DgmAttributeTypes as ChildDgmAttributeTypes;
use EVE\DgmAttributeTypesQuery as ChildDgmAttributeTypesQuery;
use EVE\Map\DgmAttributeTypesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'dgmattributetypes' table.
 *
 * 
 *
 * @method     ChildDgmAttributeTypesQuery orderByAttributeid($order = Criteria::ASC) Order by the attributeID column
 * @method     ChildDgmAttributeTypesQuery orderByAttributename($order = Criteria::ASC) Order by the attributeName column
 * @method     ChildDgmAttributeTypesQuery orderByPublished($order = Criteria::ASC) Order by the published column
 *
 * @method     ChildDgmAttributeTypesQuery groupByAttributeid() Group by the attributeID column
 * @method     ChildDgmAttributeTypesQuery groupByAttributename() Group by the attributeName column
 * @method     ChildDgmAttributeTypesQuery groupByPublished() Group by the published column
 *
 * @method     ChildDgmAttributeTypesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDgmAttributeTypesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDgmAttributeTypesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDgmAttributeTypesQuery leftJoinDgmTypeAttributes($relationAlias = null) Adds a LEFT JOIN clause to the query using the DgmTypeAttributes relation
 * @method     ChildDgmAttributeTypesQuery rightJoinDgmTypeAttributes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DgmTypeAttributes relation
 * @method     ChildDgmAttributeTypesQuery innerJoinDgmTypeAttributes($relationAlias = null) Adds a INNER JOIN clause to the query using the DgmTypeAttributes relation
 *
 * @method     \EVE\DgmTypeAttributesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDgmAttributeTypes findOne(ConnectionInterface $con = null) Return the first ChildDgmAttributeTypes matching the query
 * @method     ChildDgmAttributeTypes findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDgmAttributeTypes matching the query, or a new ChildDgmAttributeTypes object populated from the query conditions when no match is found
 *
 * @method     ChildDgmAttributeTypes findOneByAttributeid(int $attributeID) Return the first ChildDgmAttributeTypes filtered by the attributeID column
 * @method     ChildDgmAttributeTypes findOneByAttributename(string $attributeName) Return the first ChildDgmAttributeTypes filtered by the attributeName column
 * @method     ChildDgmAttributeTypes findOneByPublished(int $published) Return the first ChildDgmAttributeTypes filtered by the published column *

 * @method     ChildDgmAttributeTypes requirePk($key, ConnectionInterface $con = null) Return the ChildDgmAttributeTypes by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDgmAttributeTypes requireOne(ConnectionInterface $con = null) Return the first ChildDgmAttributeTypes matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDgmAttributeTypes requireOneByAttributeid(int $attributeID) Return the first ChildDgmAttributeTypes filtered by the attributeID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDgmAttributeTypes requireOneByAttributename(string $attributeName) Return the first ChildDgmAttributeTypes filtered by the attributeName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDgmAttributeTypes requireOneByPublished(int $published) Return the first ChildDgmAttributeTypes filtered by the published column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDgmAttributeTypes[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDgmAttributeTypes objects based on current ModelCriteria
 * @method     ChildDgmAttributeTypes[]|ObjectCollection findByAttributeid(int $attributeID) Return ChildDgmAttributeTypes objects filtered by the attributeID column
 * @method     ChildDgmAttributeTypes[]|ObjectCollection findByAttributename(string $attributeName) Return ChildDgmAttributeTypes objects filtered by the attributeName column
 * @method     ChildDgmAttributeTypes[]|ObjectCollection findByPublished(int $published) Return ChildDgmAttributeTypes objects filtered by the published column
 * @method     ChildDgmAttributeTypes[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DgmAttributeTypesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \EVE\Base\DgmAttributeTypesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'eve', $modelName = '\\EVE\\DgmAttributeTypes', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDgmAttributeTypesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDgmAttributeTypesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDgmAttributeTypesQuery) {
            return $criteria;
        }
        $query = new ChildDgmAttributeTypesQuery();
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
     * @return ChildDgmAttributeTypes|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DgmAttributeTypesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DgmAttributeTypesTableMap::DATABASE_NAME);
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
     * @return ChildDgmAttributeTypes A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT attributeID, attributeName, published FROM dgmattributetypes WHERE attributeID = :p0';
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
            /** @var ChildDgmAttributeTypes $obj */
            $obj = new ChildDgmAttributeTypes();
            $obj->hydrate($row);
            DgmAttributeTypesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildDgmAttributeTypes|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDgmAttributeTypesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DgmAttributeTypesTableMap::COL_ATTRIBUTEID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDgmAttributeTypesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DgmAttributeTypesTableMap::COL_ATTRIBUTEID, $keys, Criteria::IN);
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
     * @param     mixed $attributeid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDgmAttributeTypesQuery The current query, for fluid interface
     */
    public function filterByAttributeid($attributeid = null, $comparison = null)
    {
        if (is_array($attributeid)) {
            $useMinMax = false;
            if (isset($attributeid['min'])) {
                $this->addUsingAlias(DgmAttributeTypesTableMap::COL_ATTRIBUTEID, $attributeid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($attributeid['max'])) {
                $this->addUsingAlias(DgmAttributeTypesTableMap::COL_ATTRIBUTEID, $attributeid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DgmAttributeTypesTableMap::COL_ATTRIBUTEID, $attributeid, $comparison);
    }

    /**
     * Filter the query on the attributeName column
     *
     * Example usage:
     * <code>
     * $query->filterByAttributename('fooValue');   // WHERE attributeName = 'fooValue'
     * $query->filterByAttributename('%fooValue%'); // WHERE attributeName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $attributename The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDgmAttributeTypesQuery The current query, for fluid interface
     */
    public function filterByAttributename($attributename = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($attributename)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $attributename)) {
                $attributename = str_replace('*', '%', $attributename);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DgmAttributeTypesTableMap::COL_ATTRIBUTENAME, $attributename, $comparison);
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
     * @return $this|ChildDgmAttributeTypesQuery The current query, for fluid interface
     */
    public function filterByPublished($published = null, $comparison = null)
    {
        if (is_array($published)) {
            $useMinMax = false;
            if (isset($published['min'])) {
                $this->addUsingAlias(DgmAttributeTypesTableMap::COL_PUBLISHED, $published['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($published['max'])) {
                $this->addUsingAlias(DgmAttributeTypesTableMap::COL_PUBLISHED, $published['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DgmAttributeTypesTableMap::COL_PUBLISHED, $published, $comparison);
    }

    /**
     * Filter the query by a related \EVE\DgmTypeAttributes object
     *
     * @param \EVE\DgmTypeAttributes|ObjectCollection $dgmTypeAttributes the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDgmAttributeTypesQuery The current query, for fluid interface
     */
    public function filterByDgmTypeAttributes($dgmTypeAttributes, $comparison = null)
    {
        if ($dgmTypeAttributes instanceof \EVE\DgmTypeAttributes) {
            return $this
                ->addUsingAlias(DgmAttributeTypesTableMap::COL_ATTRIBUTEID, $dgmTypeAttributes->getAttributeid(), $comparison);
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
     * @return $this|ChildDgmAttributeTypesQuery The current query, for fluid interface
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
     * Filter the query by a related InvTypes object
     * using the dgmtypeattributes table as cross reference
     *
     * @param InvTypes $invTypes the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDgmAttributeTypesQuery The current query, for fluid interface
     */
    public function filterByInvTypes($invTypes, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useDgmTypeAttributesQuery()
            ->filterByInvTypes($invTypes, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDgmAttributeTypes $dgmAttributeTypes Object to remove from the list of results
     *
     * @return $this|ChildDgmAttributeTypesQuery The current query, for fluid interface
     */
    public function prune($dgmAttributeTypes = null)
    {
        if ($dgmAttributeTypes) {
            $this->addUsingAlias(DgmAttributeTypesTableMap::COL_ATTRIBUTEID, $dgmAttributeTypes->getAttributeid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the dgmattributetypes table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DgmAttributeTypesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DgmAttributeTypesTableMap::clearInstancePool();
            DgmAttributeTypesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DgmAttributeTypesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DgmAttributeTypesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            DgmAttributeTypesTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            DgmAttributeTypesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DgmAttributeTypesQuery
