<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\EveCharacter as ChildEveCharacter;
use ECP\EveCharacterQuery as ChildEveCharacterQuery;
use ECP\Map\EveCharacterTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'evecharacter' table.
 *
 * 
 *
 * @method     ChildEveCharacterQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildEveCharacterQuery orderByEveapiid($order = Criteria::ASC) Order by the eveApiId column
 * @method     ChildEveCharacterQuery orderByCharname($order = Criteria::ASC) Order by the charName column
 * @method     ChildEveCharacterQuery orderByCharid($order = Criteria::ASC) Order by the charId column
 * @method     ChildEveCharacterQuery orderByCorpname($order = Criteria::ASC) Order by the corpName column
 * @method     ChildEveCharacterQuery orderByCorpid($order = Criteria::ASC) Order by the corpId column
 * @method     ChildEveCharacterQuery orderByAllyname($order = Criteria::ASC) Order by the allyName column
 * @method     ChildEveCharacterQuery orderByAllyid($order = Criteria::ASC) Order by the allyId column
 *
 * @method     ChildEveCharacterQuery groupById() Group by the id column
 * @method     ChildEveCharacterQuery groupByEveapiid() Group by the eveApiId column
 * @method     ChildEveCharacterQuery groupByCharname() Group by the charName column
 * @method     ChildEveCharacterQuery groupByCharid() Group by the charId column
 * @method     ChildEveCharacterQuery groupByCorpname() Group by the corpName column
 * @method     ChildEveCharacterQuery groupByCorpid() Group by the corpId column
 * @method     ChildEveCharacterQuery groupByAllyname() Group by the allyName column
 * @method     ChildEveCharacterQuery groupByAllyid() Group by the allyId column
 *
 * @method     ChildEveCharacterQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEveCharacterQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEveCharacterQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEveCharacterQuery leftJoinEveApi($relationAlias = null) Adds a LEFT JOIN clause to the query using the EveApi relation
 * @method     ChildEveCharacterQuery rightJoinEveApi($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EveApi relation
 * @method     ChildEveCharacterQuery innerJoinEveApi($relationAlias = null) Adds a INNER JOIN clause to the query using the EveApi relation
 *
 * @method     \ECP\EveApiQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEveCharacter findOne(ConnectionInterface $con = null) Return the first ChildEveCharacter matching the query
 * @method     ChildEveCharacter findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEveCharacter matching the query, or a new ChildEveCharacter object populated from the query conditions when no match is found
 *
 * @method     ChildEveCharacter findOneById(int $id) Return the first ChildEveCharacter filtered by the id column
 * @method     ChildEveCharacter findOneByEveapiid(int $eveApiId) Return the first ChildEveCharacter filtered by the eveApiId column
 * @method     ChildEveCharacter findOneByCharname(string $charName) Return the first ChildEveCharacter filtered by the charName column
 * @method     ChildEveCharacter findOneByCharid(int $charId) Return the first ChildEveCharacter filtered by the charId column
 * @method     ChildEveCharacter findOneByCorpname(string $corpName) Return the first ChildEveCharacter filtered by the corpName column
 * @method     ChildEveCharacter findOneByCorpid(int $corpId) Return the first ChildEveCharacter filtered by the corpId column
 * @method     ChildEveCharacter findOneByAllyname(string $allyName) Return the first ChildEveCharacter filtered by the allyName column
 * @method     ChildEveCharacter findOneByAllyid(int $allyId) Return the first ChildEveCharacter filtered by the allyId column *

 * @method     ChildEveCharacter requirePk($key, ConnectionInterface $con = null) Return the ChildEveCharacter by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEveCharacter requireOne(ConnectionInterface $con = null) Return the first ChildEveCharacter matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEveCharacter requireOneById(int $id) Return the first ChildEveCharacter filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEveCharacter requireOneByEveapiid(int $eveApiId) Return the first ChildEveCharacter filtered by the eveApiId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEveCharacter requireOneByCharname(string $charName) Return the first ChildEveCharacter filtered by the charName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEveCharacter requireOneByCharid(int $charId) Return the first ChildEveCharacter filtered by the charId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEveCharacter requireOneByCorpname(string $corpName) Return the first ChildEveCharacter filtered by the corpName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEveCharacter requireOneByCorpid(int $corpId) Return the first ChildEveCharacter filtered by the corpId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEveCharacter requireOneByAllyname(string $allyName) Return the first ChildEveCharacter filtered by the allyName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEveCharacter requireOneByAllyid(int $allyId) Return the first ChildEveCharacter filtered by the allyId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEveCharacter[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEveCharacter objects based on current ModelCriteria
 * @method     ChildEveCharacter[]|ObjectCollection findById(int $id) Return ChildEveCharacter objects filtered by the id column
 * @method     ChildEveCharacter[]|ObjectCollection findByEveapiid(int $eveApiId) Return ChildEveCharacter objects filtered by the eveApiId column
 * @method     ChildEveCharacter[]|ObjectCollection findByCharname(string $charName) Return ChildEveCharacter objects filtered by the charName column
 * @method     ChildEveCharacter[]|ObjectCollection findByCharid(int $charId) Return ChildEveCharacter objects filtered by the charId column
 * @method     ChildEveCharacter[]|ObjectCollection findByCorpname(string $corpName) Return ChildEveCharacter objects filtered by the corpName column
 * @method     ChildEveCharacter[]|ObjectCollection findByCorpid(int $corpId) Return ChildEveCharacter objects filtered by the corpId column
 * @method     ChildEveCharacter[]|ObjectCollection findByAllyname(string $allyName) Return ChildEveCharacter objects filtered by the allyName column
 * @method     ChildEveCharacter[]|ObjectCollection findByAllyid(int $allyId) Return ChildEveCharacter objects filtered by the allyId column
 * @method     ChildEveCharacter[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EveCharacterQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ECP\Base\EveCharacterQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ECP\\EveCharacter', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEveCharacterQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEveCharacterQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEveCharacterQuery) {
            return $criteria;
        }
        $query = new ChildEveCharacterQuery();
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
     * @return ChildEveCharacter|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = EveCharacterTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EveCharacterTableMap::DATABASE_NAME);
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
     * @return ChildEveCharacter A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, eveApiId, charName, charId, corpName, corpId, allyName, allyId FROM evecharacter WHERE id = :p0';
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
            /** @var ChildEveCharacter $obj */
            $obj = new ChildEveCharacter();
            $obj->hydrate($row);
            EveCharacterTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildEveCharacter|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildEveCharacterQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(EveCharacterTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEveCharacterQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(EveCharacterTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildEveCharacterQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(EveCharacterTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(EveCharacterTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EveCharacterTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the eveApiId column
     *
     * Example usage:
     * <code>
     * $query->filterByEveapiid(1234); // WHERE eveApiId = 1234
     * $query->filterByEveapiid(array(12, 34)); // WHERE eveApiId IN (12, 34)
     * $query->filterByEveapiid(array('min' => 12)); // WHERE eveApiId > 12
     * </code>
     *
     * @see       filterByEveApi()
     *
     * @param     mixed $eveapiid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEveCharacterQuery The current query, for fluid interface
     */
    public function filterByEveapiid($eveapiid = null, $comparison = null)
    {
        if (is_array($eveapiid)) {
            $useMinMax = false;
            if (isset($eveapiid['min'])) {
                $this->addUsingAlias(EveCharacterTableMap::COL_EVEAPIID, $eveapiid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eveapiid['max'])) {
                $this->addUsingAlias(EveCharacterTableMap::COL_EVEAPIID, $eveapiid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EveCharacterTableMap::COL_EVEAPIID, $eveapiid, $comparison);
    }

    /**
     * Filter the query on the charName column
     *
     * Example usage:
     * <code>
     * $query->filterByCharname('fooValue');   // WHERE charName = 'fooValue'
     * $query->filterByCharname('%fooValue%'); // WHERE charName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $charname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEveCharacterQuery The current query, for fluid interface
     */
    public function filterByCharname($charname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($charname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $charname)) {
                $charname = str_replace('*', '%', $charname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EveCharacterTableMap::COL_CHARNAME, $charname, $comparison);
    }

    /**
     * Filter the query on the charId column
     *
     * Example usage:
     * <code>
     * $query->filterByCharid(1234); // WHERE charId = 1234
     * $query->filterByCharid(array(12, 34)); // WHERE charId IN (12, 34)
     * $query->filterByCharid(array('min' => 12)); // WHERE charId > 12
     * </code>
     *
     * @param     mixed $charid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEveCharacterQuery The current query, for fluid interface
     */
    public function filterByCharid($charid = null, $comparison = null)
    {
        if (is_array($charid)) {
            $useMinMax = false;
            if (isset($charid['min'])) {
                $this->addUsingAlias(EveCharacterTableMap::COL_CHARID, $charid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($charid['max'])) {
                $this->addUsingAlias(EveCharacterTableMap::COL_CHARID, $charid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EveCharacterTableMap::COL_CHARID, $charid, $comparison);
    }

    /**
     * Filter the query on the corpName column
     *
     * Example usage:
     * <code>
     * $query->filterByCorpname('fooValue');   // WHERE corpName = 'fooValue'
     * $query->filterByCorpname('%fooValue%'); // WHERE corpName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $corpname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEveCharacterQuery The current query, for fluid interface
     */
    public function filterByCorpname($corpname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($corpname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $corpname)) {
                $corpname = str_replace('*', '%', $corpname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EveCharacterTableMap::COL_CORPNAME, $corpname, $comparison);
    }

    /**
     * Filter the query on the corpId column
     *
     * Example usage:
     * <code>
     * $query->filterByCorpid(1234); // WHERE corpId = 1234
     * $query->filterByCorpid(array(12, 34)); // WHERE corpId IN (12, 34)
     * $query->filterByCorpid(array('min' => 12)); // WHERE corpId > 12
     * </code>
     *
     * @param     mixed $corpid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEveCharacterQuery The current query, for fluid interface
     */
    public function filterByCorpid($corpid = null, $comparison = null)
    {
        if (is_array($corpid)) {
            $useMinMax = false;
            if (isset($corpid['min'])) {
                $this->addUsingAlias(EveCharacterTableMap::COL_CORPID, $corpid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($corpid['max'])) {
                $this->addUsingAlias(EveCharacterTableMap::COL_CORPID, $corpid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EveCharacterTableMap::COL_CORPID, $corpid, $comparison);
    }

    /**
     * Filter the query on the allyName column
     *
     * Example usage:
     * <code>
     * $query->filterByAllyname('fooValue');   // WHERE allyName = 'fooValue'
     * $query->filterByAllyname('%fooValue%'); // WHERE allyName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $allyname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEveCharacterQuery The current query, for fluid interface
     */
    public function filterByAllyname($allyname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($allyname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $allyname)) {
                $allyname = str_replace('*', '%', $allyname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EveCharacterTableMap::COL_ALLYNAME, $allyname, $comparison);
    }

    /**
     * Filter the query on the allyId column
     *
     * Example usage:
     * <code>
     * $query->filterByAllyid(1234); // WHERE allyId = 1234
     * $query->filterByAllyid(array(12, 34)); // WHERE allyId IN (12, 34)
     * $query->filterByAllyid(array('min' => 12)); // WHERE allyId > 12
     * </code>
     *
     * @param     mixed $allyid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEveCharacterQuery The current query, for fluid interface
     */
    public function filterByAllyid($allyid = null, $comparison = null)
    {
        if (is_array($allyid)) {
            $useMinMax = false;
            if (isset($allyid['min'])) {
                $this->addUsingAlias(EveCharacterTableMap::COL_ALLYID, $allyid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($allyid['max'])) {
                $this->addUsingAlias(EveCharacterTableMap::COL_ALLYID, $allyid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EveCharacterTableMap::COL_ALLYID, $allyid, $comparison);
    }

    /**
     * Filter the query by a related \ECP\EveApi object
     *
     * @param \ECP\EveApi|ObjectCollection $eveApi The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEveCharacterQuery The current query, for fluid interface
     */
    public function filterByEveApi($eveApi, $comparison = null)
    {
        if ($eveApi instanceof \ECP\EveApi) {
            return $this
                ->addUsingAlias(EveCharacterTableMap::COL_EVEAPIID, $eveApi->getId(), $comparison);
        } elseif ($eveApi instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EveCharacterTableMap::COL_EVEAPIID, $eveApi->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByEveApi() only accepts arguments of type \ECP\EveApi or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EveApi relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEveCharacterQuery The current query, for fluid interface
     */
    public function joinEveApi($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EveApi');

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
            $this->addJoinObject($join, 'EveApi');
        }

        return $this;
    }

    /**
     * Use the EveApi relation EveApi object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ECP\EveApiQuery A secondary query class using the current class as primary query
     */
    public function useEveApiQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEveApi($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EveApi', '\ECP\EveApiQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildEveCharacter $eveCharacter Object to remove from the list of results
     *
     * @return $this|ChildEveCharacterQuery The current query, for fluid interface
     */
    public function prune($eveCharacter = null)
    {
        if ($eveCharacter) {
            $this->addUsingAlias(EveCharacterTableMap::COL_ID, $eveCharacter->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the evecharacter table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EveCharacterTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EveCharacterTableMap::clearInstancePool();
            EveCharacterTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EveCharacterTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EveCharacterTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            EveCharacterTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            EveCharacterTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // EveCharacterQuery
