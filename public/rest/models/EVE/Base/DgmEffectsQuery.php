<?php

namespace EVE\Base;

use \Exception;
use \PDO;
use EVE\DgmEffects as ChildDgmEffects;
use EVE\DgmEffectsQuery as ChildDgmEffectsQuery;
use EVE\Map\DgmEffectsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'dgmeffects' table.
 *
 * 
 *
 * @method     ChildDgmEffectsQuery orderByEffectid($order = Criteria::ASC) Order by the effectID column
 * @method     ChildDgmEffectsQuery orderByEffectname($order = Criteria::ASC) Order by the effectName column
 * @method     ChildDgmEffectsQuery orderByDisplayname($order = Criteria::ASC) Order by the displayName column
 * @method     ChildDgmEffectsQuery orderByPublished($order = Criteria::ASC) Order by the published column
 *
 * @method     ChildDgmEffectsQuery groupByEffectid() Group by the effectID column
 * @method     ChildDgmEffectsQuery groupByEffectname() Group by the effectName column
 * @method     ChildDgmEffectsQuery groupByDisplayname() Group by the displayName column
 * @method     ChildDgmEffectsQuery groupByPublished() Group by the published column
 *
 * @method     ChildDgmEffectsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDgmEffectsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDgmEffectsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDgmEffectsQuery leftJoinDgmTypeEffects($relationAlias = null) Adds a LEFT JOIN clause to the query using the DgmTypeEffects relation
 * @method     ChildDgmEffectsQuery rightJoinDgmTypeEffects($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DgmTypeEffects relation
 * @method     ChildDgmEffectsQuery innerJoinDgmTypeEffects($relationAlias = null) Adds a INNER JOIN clause to the query using the DgmTypeEffects relation
 *
 * @method     \EVE\DgmTypeEffectsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDgmEffects findOne(ConnectionInterface $con = null) Return the first ChildDgmEffects matching the query
 * @method     ChildDgmEffects findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDgmEffects matching the query, or a new ChildDgmEffects object populated from the query conditions when no match is found
 *
 * @method     ChildDgmEffects findOneByEffectid(int $effectID) Return the first ChildDgmEffects filtered by the effectID column
 * @method     ChildDgmEffects findOneByEffectname(string $effectName) Return the first ChildDgmEffects filtered by the effectName column
 * @method     ChildDgmEffects findOneByDisplayname(string $displayName) Return the first ChildDgmEffects filtered by the displayName column
 * @method     ChildDgmEffects findOneByPublished(int $published) Return the first ChildDgmEffects filtered by the published column *

 * @method     ChildDgmEffects requirePk($key, ConnectionInterface $con = null) Return the ChildDgmEffects by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDgmEffects requireOne(ConnectionInterface $con = null) Return the first ChildDgmEffects matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDgmEffects requireOneByEffectid(int $effectID) Return the first ChildDgmEffects filtered by the effectID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDgmEffects requireOneByEffectname(string $effectName) Return the first ChildDgmEffects filtered by the effectName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDgmEffects requireOneByDisplayname(string $displayName) Return the first ChildDgmEffects filtered by the displayName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDgmEffects requireOneByPublished(int $published) Return the first ChildDgmEffects filtered by the published column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDgmEffects[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDgmEffects objects based on current ModelCriteria
 * @method     ChildDgmEffects[]|ObjectCollection findByEffectid(int $effectID) Return ChildDgmEffects objects filtered by the effectID column
 * @method     ChildDgmEffects[]|ObjectCollection findByEffectname(string $effectName) Return ChildDgmEffects objects filtered by the effectName column
 * @method     ChildDgmEffects[]|ObjectCollection findByDisplayname(string $displayName) Return ChildDgmEffects objects filtered by the displayName column
 * @method     ChildDgmEffects[]|ObjectCollection findByPublished(int $published) Return ChildDgmEffects objects filtered by the published column
 * @method     ChildDgmEffects[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DgmEffectsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \EVE\Base\DgmEffectsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'eve', $modelName = '\\EVE\\DgmEffects', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDgmEffectsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDgmEffectsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDgmEffectsQuery) {
            return $criteria;
        }
        $query = new ChildDgmEffectsQuery();
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
     * @return ChildDgmEffects|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DgmEffectsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DgmEffectsTableMap::DATABASE_NAME);
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
     * @return ChildDgmEffects A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT effectID, effectName, displayName, published FROM dgmeffects WHERE effectID = :p0';
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
            /** @var ChildDgmEffects $obj */
            $obj = new ChildDgmEffects();
            $obj->hydrate($row);
            DgmEffectsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildDgmEffects|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDgmEffectsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DgmEffectsTableMap::COL_EFFECTID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDgmEffectsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DgmEffectsTableMap::COL_EFFECTID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the effectID column
     *
     * Example usage:
     * <code>
     * $query->filterByEffectid(1234); // WHERE effectID = 1234
     * $query->filterByEffectid(array(12, 34)); // WHERE effectID IN (12, 34)
     * $query->filterByEffectid(array('min' => 12)); // WHERE effectID > 12
     * </code>
     *
     * @param     mixed $effectid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDgmEffectsQuery The current query, for fluid interface
     */
    public function filterByEffectid($effectid = null, $comparison = null)
    {
        if (is_array($effectid)) {
            $useMinMax = false;
            if (isset($effectid['min'])) {
                $this->addUsingAlias(DgmEffectsTableMap::COL_EFFECTID, $effectid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($effectid['max'])) {
                $this->addUsingAlias(DgmEffectsTableMap::COL_EFFECTID, $effectid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DgmEffectsTableMap::COL_EFFECTID, $effectid, $comparison);
    }

    /**
     * Filter the query on the effectName column
     *
     * Example usage:
     * <code>
     * $query->filterByEffectname('fooValue');   // WHERE effectName = 'fooValue'
     * $query->filterByEffectname('%fooValue%'); // WHERE effectName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $effectname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDgmEffectsQuery The current query, for fluid interface
     */
    public function filterByEffectname($effectname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($effectname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $effectname)) {
                $effectname = str_replace('*', '%', $effectname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DgmEffectsTableMap::COL_EFFECTNAME, $effectname, $comparison);
    }

    /**
     * Filter the query on the displayName column
     *
     * Example usage:
     * <code>
     * $query->filterByDisplayname('fooValue');   // WHERE displayName = 'fooValue'
     * $query->filterByDisplayname('%fooValue%'); // WHERE displayName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $displayname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDgmEffectsQuery The current query, for fluid interface
     */
    public function filterByDisplayname($displayname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($displayname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $displayname)) {
                $displayname = str_replace('*', '%', $displayname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DgmEffectsTableMap::COL_DISPLAYNAME, $displayname, $comparison);
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
     * @return $this|ChildDgmEffectsQuery The current query, for fluid interface
     */
    public function filterByPublished($published = null, $comparison = null)
    {
        if (is_array($published)) {
            $useMinMax = false;
            if (isset($published['min'])) {
                $this->addUsingAlias(DgmEffectsTableMap::COL_PUBLISHED, $published['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($published['max'])) {
                $this->addUsingAlias(DgmEffectsTableMap::COL_PUBLISHED, $published['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DgmEffectsTableMap::COL_PUBLISHED, $published, $comparison);
    }

    /**
     * Filter the query by a related \EVE\DgmTypeEffects object
     *
     * @param \EVE\DgmTypeEffects|ObjectCollection $dgmTypeEffects the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDgmEffectsQuery The current query, for fluid interface
     */
    public function filterByDgmTypeEffects($dgmTypeEffects, $comparison = null)
    {
        if ($dgmTypeEffects instanceof \EVE\DgmTypeEffects) {
            return $this
                ->addUsingAlias(DgmEffectsTableMap::COL_EFFECTID, $dgmTypeEffects->getEffectid(), $comparison);
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
     * @return $this|ChildDgmEffectsQuery The current query, for fluid interface
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
     * Filter the query by a related InvTypes object
     * using the dgmtypeeffects table as cross reference
     *
     * @param InvTypes $invTypes the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDgmEffectsQuery The current query, for fluid interface
     */
    public function filterByInvTypes($invTypes, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useDgmTypeEffectsQuery()
            ->filterByInvTypes($invTypes, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDgmEffects $dgmEffects Object to remove from the list of results
     *
     * @return $this|ChildDgmEffectsQuery The current query, for fluid interface
     */
    public function prune($dgmEffects = null)
    {
        if ($dgmEffects) {
            $this->addUsingAlias(DgmEffectsTableMap::COL_EFFECTID, $dgmEffects->getEffectid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the dgmeffects table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DgmEffectsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DgmEffectsTableMap::clearInstancePool();
            DgmEffectsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DgmEffectsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DgmEffectsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            DgmEffectsTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            DgmEffectsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DgmEffectsQuery
