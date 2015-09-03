<?php

namespace EVE\Base;

use \Exception;
use \PDO;
use EVE\InvCategories as ChildInvCategories;
use EVE\InvCategoriesQuery as ChildInvCategoriesQuery;
use EVE\Map\InvCategoriesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'invcategories' table.
 *
 * 
 *
 * @method     ChildInvCategoriesQuery orderByCategoryid($order = Criteria::ASC) Order by the categoryID column
 * @method     ChildInvCategoriesQuery orderByCategoryname($order = Criteria::ASC) Order by the categoryName column
 * @method     ChildInvCategoriesQuery orderByPublished($order = Criteria::ASC) Order by the published column
 *
 * @method     ChildInvCategoriesQuery groupByCategoryid() Group by the categoryID column
 * @method     ChildInvCategoriesQuery groupByCategoryname() Group by the categoryName column
 * @method     ChildInvCategoriesQuery groupByPublished() Group by the published column
 *
 * @method     ChildInvCategoriesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInvCategoriesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInvCategoriesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInvCategoriesQuery leftJoinInvGroups($relationAlias = null) Adds a LEFT JOIN clause to the query using the InvGroups relation
 * @method     ChildInvCategoriesQuery rightJoinInvGroups($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InvGroups relation
 * @method     ChildInvCategoriesQuery innerJoinInvGroups($relationAlias = null) Adds a INNER JOIN clause to the query using the InvGroups relation
 *
 * @method     \EVE\InvGroupsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInvCategories findOne(ConnectionInterface $con = null) Return the first ChildInvCategories matching the query
 * @method     ChildInvCategories findOneOrCreate(ConnectionInterface $con = null) Return the first ChildInvCategories matching the query, or a new ChildInvCategories object populated from the query conditions when no match is found
 *
 * @method     ChildInvCategories findOneByCategoryid(int $categoryID) Return the first ChildInvCategories filtered by the categoryID column
 * @method     ChildInvCategories findOneByCategoryname(string $categoryName) Return the first ChildInvCategories filtered by the categoryName column
 * @method     ChildInvCategories findOneByPublished(int $published) Return the first ChildInvCategories filtered by the published column *

 * @method     ChildInvCategories requirePk($key, ConnectionInterface $con = null) Return the ChildInvCategories by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvCategories requireOne(ConnectionInterface $con = null) Return the first ChildInvCategories matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInvCategories requireOneByCategoryid(int $categoryID) Return the first ChildInvCategories filtered by the categoryID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvCategories requireOneByCategoryname(string $categoryName) Return the first ChildInvCategories filtered by the categoryName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvCategories requireOneByPublished(int $published) Return the first ChildInvCategories filtered by the published column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInvCategories[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildInvCategories objects based on current ModelCriteria
 * @method     ChildInvCategories[]|ObjectCollection findByCategoryid(int $categoryID) Return ChildInvCategories objects filtered by the categoryID column
 * @method     ChildInvCategories[]|ObjectCollection findByCategoryname(string $categoryName) Return ChildInvCategories objects filtered by the categoryName column
 * @method     ChildInvCategories[]|ObjectCollection findByPublished(int $published) Return ChildInvCategories objects filtered by the published column
 * @method     ChildInvCategories[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class InvCategoriesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \EVE\Base\InvCategoriesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'eve', $modelName = '\\EVE\\InvCategories', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInvCategoriesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInvCategoriesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildInvCategoriesQuery) {
            return $criteria;
        }
        $query = new ChildInvCategoriesQuery();
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
     * @return ChildInvCategories|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = InvCategoriesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InvCategoriesTableMap::DATABASE_NAME);
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
     * @return ChildInvCategories A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT categoryID, categoryName, published FROM invcategories WHERE categoryID = :p0';
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
            /** @var ChildInvCategories $obj */
            $obj = new ChildInvCategories();
            $obj->hydrate($row);
            InvCategoriesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildInvCategories|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildInvCategoriesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(InvCategoriesTableMap::COL_CATEGORYID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildInvCategoriesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(InvCategoriesTableMap::COL_CATEGORYID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the categoryID column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryid(1234); // WHERE categoryID = 1234
     * $query->filterByCategoryid(array(12, 34)); // WHERE categoryID IN (12, 34)
     * $query->filterByCategoryid(array('min' => 12)); // WHERE categoryID > 12
     * </code>
     *
     * @param     mixed $categoryid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvCategoriesQuery The current query, for fluid interface
     */
    public function filterByCategoryid($categoryid = null, $comparison = null)
    {
        if (is_array($categoryid)) {
            $useMinMax = false;
            if (isset($categoryid['min'])) {
                $this->addUsingAlias(InvCategoriesTableMap::COL_CATEGORYID, $categoryid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryid['max'])) {
                $this->addUsingAlias(InvCategoriesTableMap::COL_CATEGORYID, $categoryid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InvCategoriesTableMap::COL_CATEGORYID, $categoryid, $comparison);
    }

    /**
     * Filter the query on the categoryName column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryname('fooValue');   // WHERE categoryName = 'fooValue'
     * $query->filterByCategoryname('%fooValue%'); // WHERE categoryName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categoryname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInvCategoriesQuery The current query, for fluid interface
     */
    public function filterByCategoryname($categoryname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($categoryname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $categoryname)) {
                $categoryname = str_replace('*', '%', $categoryname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(InvCategoriesTableMap::COL_CATEGORYNAME, $categoryname, $comparison);
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
     * @return $this|ChildInvCategoriesQuery The current query, for fluid interface
     */
    public function filterByPublished($published = null, $comparison = null)
    {
        if (is_array($published)) {
            $useMinMax = false;
            if (isset($published['min'])) {
                $this->addUsingAlias(InvCategoriesTableMap::COL_PUBLISHED, $published['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($published['max'])) {
                $this->addUsingAlias(InvCategoriesTableMap::COL_PUBLISHED, $published['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InvCategoriesTableMap::COL_PUBLISHED, $published, $comparison);
    }

    /**
     * Filter the query by a related \EVE\InvGroups object
     *
     * @param \EVE\InvGroups|ObjectCollection $invGroups the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInvCategoriesQuery The current query, for fluid interface
     */
    public function filterByInvGroups($invGroups, $comparison = null)
    {
        if ($invGroups instanceof \EVE\InvGroups) {
            return $this
                ->addUsingAlias(InvCategoriesTableMap::COL_CATEGORYID, $invGroups->getCategoryid(), $comparison);
        } elseif ($invGroups instanceof ObjectCollection) {
            return $this
                ->useInvGroupsQuery()
                ->filterByPrimaryKeys($invGroups->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildInvCategoriesQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildInvCategories $invCategories Object to remove from the list of results
     *
     * @return $this|ChildInvCategoriesQuery The current query, for fluid interface
     */
    public function prune($invCategories = null)
    {
        if ($invCategories) {
            $this->addUsingAlias(InvCategoriesTableMap::COL_CATEGORYID, $invCategories->getCategoryid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the invcategories table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InvCategoriesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InvCategoriesTableMap::clearInstancePool();
            InvCategoriesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(InvCategoriesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InvCategoriesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            InvCategoriesTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            InvCategoriesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // InvCategoriesQuery
