<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\CompositionRow as ChildCompositionRow;
use ECP\CompositionRowQuery as ChildCompositionRowQuery;
use ECP\Map\CompositionRowTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'compositionrow' table.
 *
 * 
 *
 * @method     ChildCompositionRowQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCompositionRowQuery orderByCompositionentityid($order = Criteria::ASC) Order by the compositionEntityId column
 * @method     ChildCompositionRowQuery orderByShipid($order = Criteria::ASC) Order by the shipId column
 * @method     ChildCompositionRowQuery orderByFitname($order = Criteria::ASC) Order by the fitName column
 * @method     ChildCompositionRowQuery orderByNotes($order = Criteria::ASC) Order by the notes column
 *
 * @method     ChildCompositionRowQuery groupById() Group by the id column
 * @method     ChildCompositionRowQuery groupByCompositionentityid() Group by the compositionEntityId column
 * @method     ChildCompositionRowQuery groupByShipid() Group by the shipId column
 * @method     ChildCompositionRowQuery groupByFitname() Group by the fitName column
 * @method     ChildCompositionRowQuery groupByNotes() Group by the notes column
 *
 * @method     ChildCompositionRowQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCompositionRowQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCompositionRowQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCompositionRowQuery leftJoinCompositionEntity($relationAlias = null) Adds a LEFT JOIN clause to the query using the CompositionEntity relation
 * @method     ChildCompositionRowQuery rightJoinCompositionEntity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CompositionEntity relation
 * @method     ChildCompositionRowQuery innerJoinCompositionEntity($relationAlias = null) Adds a INNER JOIN clause to the query using the CompositionEntity relation
 *
 * @method     ChildCompositionRowQuery leftJoinFitEntry($relationAlias = null) Adds a LEFT JOIN clause to the query using the FitEntry relation
 * @method     ChildCompositionRowQuery rightJoinFitEntry($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FitEntry relation
 * @method     ChildCompositionRowQuery innerJoinFitEntry($relationAlias = null) Adds a INNER JOIN clause to the query using the FitEntry relation
 *
 * @method     \ECP\CompositionEntityQuery|\ECP\FitEntryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCompositionRow findOne(ConnectionInterface $con = null) Return the first ChildCompositionRow matching the query
 * @method     ChildCompositionRow findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCompositionRow matching the query, or a new ChildCompositionRow object populated from the query conditions when no match is found
 *
 * @method     ChildCompositionRow findOneById(int $id) Return the first ChildCompositionRow filtered by the id column
 * @method     ChildCompositionRow findOneByCompositionentityid(int $compositionEntityId) Return the first ChildCompositionRow filtered by the compositionEntityId column
 * @method     ChildCompositionRow findOneByShipid(int $shipId) Return the first ChildCompositionRow filtered by the shipId column
 * @method     ChildCompositionRow findOneByFitname(string $fitName) Return the first ChildCompositionRow filtered by the fitName column
 * @method     ChildCompositionRow findOneByNotes(string $notes) Return the first ChildCompositionRow filtered by the notes column *

 * @method     ChildCompositionRow requirePk($key, ConnectionInterface $con = null) Return the ChildCompositionRow by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompositionRow requireOne(ConnectionInterface $con = null) Return the first ChildCompositionRow matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCompositionRow requireOneById(int $id) Return the first ChildCompositionRow filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompositionRow requireOneByCompositionentityid(int $compositionEntityId) Return the first ChildCompositionRow filtered by the compositionEntityId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompositionRow requireOneByShipid(int $shipId) Return the first ChildCompositionRow filtered by the shipId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompositionRow requireOneByFitname(string $fitName) Return the first ChildCompositionRow filtered by the fitName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompositionRow requireOneByNotes(string $notes) Return the first ChildCompositionRow filtered by the notes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCompositionRow[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCompositionRow objects based on current ModelCriteria
 * @method     ChildCompositionRow[]|ObjectCollection findById(int $id) Return ChildCompositionRow objects filtered by the id column
 * @method     ChildCompositionRow[]|ObjectCollection findByCompositionentityid(int $compositionEntityId) Return ChildCompositionRow objects filtered by the compositionEntityId column
 * @method     ChildCompositionRow[]|ObjectCollection findByShipid(int $shipId) Return ChildCompositionRow objects filtered by the shipId column
 * @method     ChildCompositionRow[]|ObjectCollection findByFitname(string $fitName) Return ChildCompositionRow objects filtered by the fitName column
 * @method     ChildCompositionRow[]|ObjectCollection findByNotes(string $notes) Return ChildCompositionRow objects filtered by the notes column
 * @method     ChildCompositionRow[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CompositionRowQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\CompositionRowQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\CompositionRow', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCompositionRowQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCompositionRowQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCompositionRowQuery) {
            return $criteria;
        }
        $query = new ChildCompositionRowQuery();
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
     * @return ChildCompositionRow|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CompositionRowTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CompositionRowTableMap::DATABASE_NAME);
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
     * @return ChildCompositionRow A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, compositionEntityId, shipId, fitName, notes FROM compositionrow WHERE id = :p0';
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
            /** @var ChildCompositionRow $obj */
            $obj = new ChildCompositionRow();
            $obj->hydrate($row);
            CompositionRowTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCompositionRow|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCompositionRowQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CompositionRowTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCompositionRowQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CompositionRowTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCompositionRowQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CompositionRowTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CompositionRowTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompositionRowTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the compositionEntityId column
     *
     * Example usage:
     * <code>
     * $query->filterByCompositionentityid(1234); // WHERE compositionEntityId = 1234
     * $query->filterByCompositionentityid(array(12, 34)); // WHERE compositionEntityId IN (12, 34)
     * $query->filterByCompositionentityid(array('min' => 12)); // WHERE compositionEntityId > 12
     * </code>
     *
     * @see       filterByCompositionEntity()
     *
     * @param     mixed $compositionentityid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompositionRowQuery The current query, for fluid interface
     */
    public function filterByCompositionentityid($compositionentityid = null, $comparison = null)
    {
        if (is_array($compositionentityid)) {
            $useMinMax = false;
            if (isset($compositionentityid['min'])) {
                $this->addUsingAlias(CompositionRowTableMap::COL_COMPOSITIONENTITYID, $compositionentityid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($compositionentityid['max'])) {
                $this->addUsingAlias(CompositionRowTableMap::COL_COMPOSITIONENTITYID, $compositionentityid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompositionRowTableMap::COL_COMPOSITIONENTITYID, $compositionentityid, $comparison);
    }

    /**
     * Filter the query on the shipId column
     *
     * Example usage:
     * <code>
     * $query->filterByShipid(1234); // WHERE shipId = 1234
     * $query->filterByShipid(array(12, 34)); // WHERE shipId IN (12, 34)
     * $query->filterByShipid(array('min' => 12)); // WHERE shipId > 12
     * </code>
     *
     * @param     mixed $shipid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompositionRowQuery The current query, for fluid interface
     */
    public function filterByShipid($shipid = null, $comparison = null)
    {
        if (is_array($shipid)) {
            $useMinMax = false;
            if (isset($shipid['min'])) {
                $this->addUsingAlias(CompositionRowTableMap::COL_SHIPID, $shipid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shipid['max'])) {
                $this->addUsingAlias(CompositionRowTableMap::COL_SHIPID, $shipid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompositionRowTableMap::COL_SHIPID, $shipid, $comparison);
    }

    /**
     * Filter the query on the fitName column
     *
     * Example usage:
     * <code>
     * $query->filterByFitname('fooValue');   // WHERE fitName = 'fooValue'
     * $query->filterByFitname('%fooValue%'); // WHERE fitName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fitname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompositionRowQuery The current query, for fluid interface
     */
    public function filterByFitname($fitname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fitname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fitname)) {
                $fitname = str_replace('*', '%', $fitname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompositionRowTableMap::COL_FITNAME, $fitname, $comparison);
    }

    /**
     * Filter the query on the notes column
     *
     * Example usage:
     * <code>
     * $query->filterByNotes('fooValue');   // WHERE notes = 'fooValue'
     * $query->filterByNotes('%fooValue%'); // WHERE notes LIKE '%fooValue%'
     * </code>
     *
     * @param     string $notes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompositionRowQuery The current query, for fluid interface
     */
    public function filterByNotes($notes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($notes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $notes)) {
                $notes = str_replace('*', '%', $notes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompositionRowTableMap::COL_NOTES, $notes, $comparison);
    }

    /**
     * Filter the query by a related \ECP\CompositionEntity object
     *
     * @param \ECP\CompositionEntity|ObjectCollection $compositionEntity The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCompositionRowQuery The current query, for fluid interface
     */
    public function filterByCompositionEntity($compositionEntity, $comparison = null)
    {
        if ($compositionEntity instanceof \ECP\CompositionEntity) {
            return $this
                ->addUsingAlias(CompositionRowTableMap::COL_COMPOSITIONENTITYID, $compositionEntity->getId(), $comparison);
        } elseif ($compositionEntity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CompositionRowTableMap::COL_COMPOSITIONENTITYID, $compositionEntity->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildCompositionRowQuery The current query, for fluid interface
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
     * Filter the query by a related \ECP\FitEntry object
     *
     * @param \ECP\FitEntry|ObjectCollection $fitEntry the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompositionRowQuery The current query, for fluid interface
     */
    public function filterByFitEntry($fitEntry, $comparison = null)
    {
        if ($fitEntry instanceof \ECP\FitEntry) {
            return $this
                ->addUsingAlias(CompositionRowTableMap::COL_ID, $fitEntry->getCompositionrowid(), $comparison);
        } elseif ($fitEntry instanceof ObjectCollection) {
            return $this
                ->useFitEntryQuery()
                ->filterByPrimaryKeys($fitEntry->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFitEntry() only accepts arguments of type \ECP\FitEntry or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FitEntry relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCompositionRowQuery The current query, for fluid interface
     */
    public function joinFitEntry($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FitEntry');

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
            $this->addJoinObject($join, 'FitEntry');
        }

        return $this;
    }

    /**
     * Use the FitEntry relation FitEntry object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\FitEntryQuery A secondary query class using the current class as primary query
     */
    public function useFitEntryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFitEntry($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FitEntry', '\ECP\FitEntryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCompositionRow $compositionRow Object to remove from the list of results
     *
     * @return $this|ChildCompositionRowQuery The current query, for fluid interface
     */
    public function prune($compositionRow = null)
    {
        if ($compositionRow) {
            $this->addUsingAlias(CompositionRowTableMap::COL_ID, $compositionRow->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the compositionrow table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompositionRowTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CompositionRowTableMap::clearInstancePool();
            CompositionRowTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CompositionRowTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CompositionRowTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            CompositionRowTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CompositionRowTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CompositionRowQuery
