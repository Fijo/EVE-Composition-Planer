<?php

namespace ECP\Base;

use \DateTime;
use \Exception;
use \PDO;
use ECP\CompositionEntity as ChildCompositionEntity;
use ECP\CompositionEntityQuery as ChildCompositionEntityQuery;
use ECP\RulesetEntity as ChildRulesetEntity;
use ECP\RulesetEntityQuery as ChildRulesetEntityQuery;
use ECP\RulesetRuleRow as ChildRulesetRuleRow;
use ECP\RulesetRuleRowQuery as ChildRulesetRuleRowQuery;
use ECP\RulesetShip as ChildRulesetShip;
use ECP\RulesetShipQuery as ChildRulesetShipQuery;
use ECP\User as ChildUser;
use ECP\UserQuery as ChildUserQuery;
use ECP\Map\RulesetEntityTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'rulesetentity' table.
 *
 * 
 *
* @package    propel.generator.ECP.Base
*/
abstract class RulesetEntity implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\ECP\\Map\\RulesetEntityTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the userid field.
     * @var        int
     */
    protected $userid;

    /**
     * The value for the islisted field.
     * @var        int
     */
    protected $islisted;

    /**
     * The value for the forkedid field.
     * @var        int
     */
    protected $forkedid;

    /**
     * The value for the minpilots field.
     * @var        int
     */
    protected $minpilots;

    /**
     * The value for the maxpilots field.
     * @var        int
     */
    protected $maxpilots;

    /**
     * The value for the maxpoints field.
     * @var        int
     */
    protected $maxpoints;

    /**
     * The value for the lastmodified field.
     * @var        \DateTime
     */
    protected $lastmodified;

    /**
     * @var        ChildUser
     */
    protected $aUser;

    /**
     * @var        ChildRulesetEntity
     */
    protected $aRulesetEntityRelatedByForkedid;

    /**
     * @var        ObjectCollection|ChildRulesetEntity[] Collection to store aggregation of ChildRulesetEntity objects.
     */
    protected $collRulesetEntitiesRelatedById;
    protected $collRulesetEntitiesRelatedByIdPartial;

    /**
     * @var        ObjectCollection|ChildRulesetShip[] Collection to store aggregation of ChildRulesetShip objects.
     */
    protected $collRulesetShips;
    protected $collRulesetShipsPartial;

    /**
     * @var        ObjectCollection|ChildRulesetRuleRow[] Collection to store aggregation of ChildRulesetRuleRow objects.
     */
    protected $collRulesetRuleRows;
    protected $collRulesetRuleRowsPartial;

    /**
     * @var        ObjectCollection|ChildCompositionEntity[] Collection to store aggregation of ChildCompositionEntity objects.
     */
    protected $collCompositionEntities;
    protected $collCompositionEntitiesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRulesetEntity[]
     */
    protected $rulesetEntitiesRelatedByIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRulesetShip[]
     */
    protected $rulesetShipsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRulesetRuleRow[]
     */
    protected $rulesetRuleRowsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCompositionEntity[]
     */
    protected $compositionEntitiesScheduledForDeletion = null;

    /**
     * Initializes internal state of ECP\Base\RulesetEntity object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>RulesetEntity</code> instance.  If
     * <code>obj</code> is an instance of <code>RulesetEntity</code>, delegates to
     * <code>equals(RulesetEntity)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|RulesetEntity The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [userid] column value.
     * 
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Get the [islisted] column value.
     * 
     * @return int
     */
    public function getIslisted()
    {
        return $this->islisted;
    }

    /**
     * Get the [forkedid] column value.
     * 
     * @return int
     */
    public function getForkedid()
    {
        return $this->forkedid;
    }

    /**
     * Get the [minpilots] column value.
     * 
     * @return int
     */
    public function getMinpilots()
    {
        return $this->minpilots;
    }

    /**
     * Get the [maxpilots] column value.
     * 
     * @return int
     */
    public function getMaxpilots()
    {
        return $this->maxpilots;
    }

    /**
     * Get the [maxpoints] column value.
     * 
     * @return int
     */
    public function getMaxpoints()
    {
        return $this->maxpoints;
    }

    /**
     * Get the [optionally formatted] temporal [lastmodified] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLastmodified($format = NULL)
    {
        if ($format === null) {
            return $this->lastmodified;
        } else {
            return $this->lastmodified instanceof \DateTime ? $this->lastmodified->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[RulesetEntityTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     * 
     * @param string $v new value
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[RulesetEntityTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [userid] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     */
    public function setUserid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->userid !== $v) {
            $this->userid = $v;
            $this->modifiedColumns[RulesetEntityTableMap::COL_USERID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getId() !== $v) {
            $this->aUser = null;
        }

        return $this;
    } // setUserid()

    /**
     * Set the value of [islisted] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     */
    public function setIslisted($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->islisted !== $v) {
            $this->islisted = $v;
            $this->modifiedColumns[RulesetEntityTableMap::COL_ISLISTED] = true;
        }

        return $this;
    } // setIslisted()

    /**
     * Set the value of [forkedid] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     */
    public function setForkedid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->forkedid !== $v) {
            $this->forkedid = $v;
            $this->modifiedColumns[RulesetEntityTableMap::COL_FORKEDID] = true;
        }

        if ($this->aRulesetEntityRelatedByForkedid !== null && $this->aRulesetEntityRelatedByForkedid->getId() !== $v) {
            $this->aRulesetEntityRelatedByForkedid = null;
        }

        return $this;
    } // setForkedid()

    /**
     * Set the value of [minpilots] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     */
    public function setMinpilots($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->minpilots !== $v) {
            $this->minpilots = $v;
            $this->modifiedColumns[RulesetEntityTableMap::COL_MINPILOTS] = true;
        }

        return $this;
    } // setMinpilots()

    /**
     * Set the value of [maxpilots] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     */
    public function setMaxpilots($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->maxpilots !== $v) {
            $this->maxpilots = $v;
            $this->modifiedColumns[RulesetEntityTableMap::COL_MAXPILOTS] = true;
        }

        return $this;
    } // setMaxpilots()

    /**
     * Set the value of [maxpoints] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     */
    public function setMaxpoints($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->maxpoints !== $v) {
            $this->maxpoints = $v;
            $this->modifiedColumns[RulesetEntityTableMap::COL_MAXPOINTS] = true;
        }

        return $this;
    } // setMaxpoints()

    /**
     * Sets the value of [lastmodified] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     */
    public function setLastmodified($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->lastmodified !== null || $dt !== null) {
            if ($this->lastmodified === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->lastmodified->format("Y-m-d H:i:s")) {
                $this->lastmodified = $dt === null ? null : clone $dt;
                $this->modifiedColumns[RulesetEntityTableMap::COL_LASTMODIFIED] = true;
            }
        } // if either are not null

        return $this;
    } // setLastmodified()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : RulesetEntityTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : RulesetEntityTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : RulesetEntityTableMap::translateFieldName('Userid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->userid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : RulesetEntityTableMap::translateFieldName('Islisted', TableMap::TYPE_PHPNAME, $indexType)];
            $this->islisted = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : RulesetEntityTableMap::translateFieldName('Forkedid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->forkedid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : RulesetEntityTableMap::translateFieldName('Minpilots', TableMap::TYPE_PHPNAME, $indexType)];
            $this->minpilots = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : RulesetEntityTableMap::translateFieldName('Maxpilots', TableMap::TYPE_PHPNAME, $indexType)];
            $this->maxpilots = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : RulesetEntityTableMap::translateFieldName('Maxpoints', TableMap::TYPE_PHPNAME, $indexType)];
            $this->maxpoints = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : RulesetEntityTableMap::translateFieldName('Lastmodified', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->lastmodified = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = RulesetEntityTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ECP\\RulesetEntity'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aUser !== null && $this->userid !== $this->aUser->getId()) {
            $this->aUser = null;
        }
        if ($this->aRulesetEntityRelatedByForkedid !== null && $this->forkedid !== $this->aRulesetEntityRelatedByForkedid->getId()) {
            $this->aRulesetEntityRelatedByForkedid = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RulesetEntityTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildRulesetEntityQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUser = null;
            $this->aRulesetEntityRelatedByForkedid = null;
            $this->collRulesetEntitiesRelatedById = null;

            $this->collRulesetShips = null;

            $this->collRulesetRuleRows = null;

            $this->collCompositionEntities = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see RulesetEntity::setDeleted()
     * @see RulesetEntity::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RulesetEntityTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildRulesetEntityQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RulesetEntityTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                RulesetEntityTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->aRulesetEntityRelatedByForkedid !== null) {
                if ($this->aRulesetEntityRelatedByForkedid->isModified() || $this->aRulesetEntityRelatedByForkedid->isNew()) {
                    $affectedRows += $this->aRulesetEntityRelatedByForkedid->save($con);
                }
                $this->setRulesetEntityRelatedByForkedid($this->aRulesetEntityRelatedByForkedid);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->rulesetEntitiesRelatedByIdScheduledForDeletion !== null) {
                if (!$this->rulesetEntitiesRelatedByIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->rulesetEntitiesRelatedByIdScheduledForDeletion as $rulesetEntityRelatedById) {
                        // need to save related object because we set the relation to null
                        $rulesetEntityRelatedById->save($con);
                    }
                    $this->rulesetEntitiesRelatedByIdScheduledForDeletion = null;
                }
            }

            if ($this->collRulesetEntitiesRelatedById !== null) {
                foreach ($this->collRulesetEntitiesRelatedById as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rulesetShipsScheduledForDeletion !== null) {
                if (!$this->rulesetShipsScheduledForDeletion->isEmpty()) {
                    \ECP\RulesetShipQuery::create()
                        ->filterByPrimaryKeys($this->rulesetShipsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rulesetShipsScheduledForDeletion = null;
                }
            }

            if ($this->collRulesetShips !== null) {
                foreach ($this->collRulesetShips as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rulesetRuleRowsScheduledForDeletion !== null) {
                if (!$this->rulesetRuleRowsScheduledForDeletion->isEmpty()) {
                    \ECP\RulesetRuleRowQuery::create()
                        ->filterByPrimaryKeys($this->rulesetRuleRowsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rulesetRuleRowsScheduledForDeletion = null;
                }
            }

            if ($this->collRulesetRuleRows !== null) {
                foreach ($this->collRulesetRuleRows as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->compositionEntitiesScheduledForDeletion !== null) {
                if (!$this->compositionEntitiesScheduledForDeletion->isEmpty()) {
                    \ECP\CompositionEntityQuery::create()
                        ->filterByPrimaryKeys($this->compositionEntitiesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->compositionEntitiesScheduledForDeletion = null;
                }
            }

            if ($this->collCompositionEntities !== null) {
                foreach ($this->collCompositionEntities as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[RulesetEntityTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . RulesetEntityTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RulesetEntityTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_USERID)) {
            $modifiedColumns[':p' . $index++]  = 'userId';
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_ISLISTED)) {
            $modifiedColumns[':p' . $index++]  = 'isListed';
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_FORKEDID)) {
            $modifiedColumns[':p' . $index++]  = 'forkedId';
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_MINPILOTS)) {
            $modifiedColumns[':p' . $index++]  = 'minPilots';
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_MAXPILOTS)) {
            $modifiedColumns[':p' . $index++]  = 'maxPilots';
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_MAXPOINTS)) {
            $modifiedColumns[':p' . $index++]  = 'maxPoints';
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_LASTMODIFIED)) {
            $modifiedColumns[':p' . $index++]  = 'lastModified';
        }

        $sql = sprintf(
            'INSERT INTO rulesetentity (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':                        
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'name':                        
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'userId':                        
                        $stmt->bindValue($identifier, $this->userid, PDO::PARAM_INT);
                        break;
                    case 'isListed':                        
                        $stmt->bindValue($identifier, $this->islisted, PDO::PARAM_INT);
                        break;
                    case 'forkedId':                        
                        $stmt->bindValue($identifier, $this->forkedid, PDO::PARAM_INT);
                        break;
                    case 'minPilots':                        
                        $stmt->bindValue($identifier, $this->minpilots, PDO::PARAM_INT);
                        break;
                    case 'maxPilots':                        
                        $stmt->bindValue($identifier, $this->maxpilots, PDO::PARAM_INT);
                        break;
                    case 'maxPoints':                        
                        $stmt->bindValue($identifier, $this->maxpoints, PDO::PARAM_INT);
                        break;
                    case 'lastModified':                        
                        $stmt->bindValue($identifier, $this->lastmodified ? $this->lastmodified->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RulesetEntityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getUserid();
                break;
            case 3:
                return $this->getIslisted();
                break;
            case 4:
                return $this->getForkedid();
                break;
            case 5:
                return $this->getMinpilots();
                break;
            case 6:
                return $this->getMaxpilots();
                break;
            case 7:
                return $this->getMaxpoints();
                break;
            case 8:
                return $this->getLastmodified();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['RulesetEntity'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['RulesetEntity'][$this->hashCode()] = true;
        $keys = RulesetEntityTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getUserid(),
            $keys[3] => $this->getIslisted(),
            $keys[4] => $this->getForkedid(),
            $keys[5] => $this->getMinpilots(),
            $keys[6] => $this->getMaxpilots(),
            $keys[7] => $this->getMaxpoints(),
            $keys[8] => $this->getLastmodified(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[8]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[8]];
            $result[$keys[8]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aUser) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user';
                        break;
                    default:
                        $key = 'User';
                }
        
                $result[$key] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aRulesetEntityRelatedByForkedid) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rulesetEntity';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'rulesetentity';
                        break;
                    default:
                        $key = 'RulesetEntity';
                }
        
                $result[$key] = $this->aRulesetEntityRelatedByForkedid->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collRulesetEntitiesRelatedById) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rulesetEntities';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'rulesetentities';
                        break;
                    default:
                        $key = 'RulesetEntities';
                }
        
                $result[$key] = $this->collRulesetEntitiesRelatedById->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRulesetShips) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rulesetShips';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'rulesetships';
                        break;
                    default:
                        $key = 'RulesetShips';
                }
        
                $result[$key] = $this->collRulesetShips->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRulesetRuleRows) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rulesetRuleRows';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'rulesetrulerows';
                        break;
                    default:
                        $key = 'RulesetRuleRows';
                }
        
                $result[$key] = $this->collRulesetRuleRows->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCompositionEntities) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'compositionEntities';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'compositionentities';
                        break;
                    default:
                        $key = 'CompositionEntities';
                }
        
                $result[$key] = $this->collCompositionEntities->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\ECP\RulesetEntity
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RulesetEntityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ECP\RulesetEntity
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setUserid($value);
                break;
            case 3:
                $this->setIslisted($value);
                break;
            case 4:
                $this->setForkedid($value);
                break;
            case 5:
                $this->setMinpilots($value);
                break;
            case 6:
                $this->setMaxpilots($value);
                break;
            case 7:
                $this->setMaxpoints($value);
                break;
            case 8:
                $this->setLastmodified($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = RulesetEntityTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUserid($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setIslisted($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setForkedid($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setMinpilots($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setMaxpilots($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setMaxpoints($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setLastmodified($arr[$keys[8]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\ECP\RulesetEntity The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(RulesetEntityTableMap::DATABASE_NAME);

        if ($this->isColumnModified(RulesetEntityTableMap::COL_ID)) {
            $criteria->add(RulesetEntityTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_NAME)) {
            $criteria->add(RulesetEntityTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_USERID)) {
            $criteria->add(RulesetEntityTableMap::COL_USERID, $this->userid);
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_ISLISTED)) {
            $criteria->add(RulesetEntityTableMap::COL_ISLISTED, $this->islisted);
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_FORKEDID)) {
            $criteria->add(RulesetEntityTableMap::COL_FORKEDID, $this->forkedid);
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_MINPILOTS)) {
            $criteria->add(RulesetEntityTableMap::COL_MINPILOTS, $this->minpilots);
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_MAXPILOTS)) {
            $criteria->add(RulesetEntityTableMap::COL_MAXPILOTS, $this->maxpilots);
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_MAXPOINTS)) {
            $criteria->add(RulesetEntityTableMap::COL_MAXPOINTS, $this->maxpoints);
        }
        if ($this->isColumnModified(RulesetEntityTableMap::COL_LASTMODIFIED)) {
            $criteria->add(RulesetEntityTableMap::COL_LASTMODIFIED, $this->lastmodified);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildRulesetEntityQuery::create();
        $criteria->add(RulesetEntityTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }
        
    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \ECP\RulesetEntity (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setUserid($this->getUserid());
        $copyObj->setIslisted($this->getIslisted());
        $copyObj->setForkedid($this->getForkedid());
        $copyObj->setMinpilots($this->getMinpilots());
        $copyObj->setMaxpilots($this->getMaxpilots());
        $copyObj->setMaxpoints($this->getMaxpoints());
        $copyObj->setLastmodified($this->getLastmodified());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRulesetEntitiesRelatedById() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRulesetEntityRelatedById($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRulesetShips() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRulesetShip($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRulesetRuleRows() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRulesetRuleRow($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCompositionEntities() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCompositionEntity($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \ECP\RulesetEntity Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setUserid(NULL);
        } else {
            $this->setUserid($v->getId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addRulesetEntity($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->userid !== null)) {
            $this->aUser = ChildUserQuery::create()->findPk($this->userid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addRulesetEntities($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a ChildRulesetEntity object.
     *
     * @param  ChildRulesetEntity $v
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     * @throws PropelException
     */
    public function setRulesetEntityRelatedByForkedid(ChildRulesetEntity $v = null)
    {
        if ($v === null) {
            $this->setForkedid(NULL);
        } else {
            $this->setForkedid($v->getId());
        }

        $this->aRulesetEntityRelatedByForkedid = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildRulesetEntity object, it will not be re-added.
        if ($v !== null) {
            $v->addRulesetEntityRelatedById($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildRulesetEntity object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildRulesetEntity The associated ChildRulesetEntity object.
     * @throws PropelException
     */
    public function getRulesetEntityRelatedByForkedid(ConnectionInterface $con = null)
    {
        if ($this->aRulesetEntityRelatedByForkedid === null && ($this->forkedid !== null)) {
            $this->aRulesetEntityRelatedByForkedid = ChildRulesetEntityQuery::create()->findPk($this->forkedid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aRulesetEntityRelatedByForkedid->addRulesetEntitiesRelatedById($this);
             */
        }

        return $this->aRulesetEntityRelatedByForkedid;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('RulesetEntityRelatedById' == $relationName) {
            return $this->initRulesetEntitiesRelatedById();
        }
        if ('RulesetShip' == $relationName) {
            return $this->initRulesetShips();
        }
        if ('RulesetRuleRow' == $relationName) {
            return $this->initRulesetRuleRows();
        }
        if ('CompositionEntity' == $relationName) {
            return $this->initCompositionEntities();
        }
    }

    /**
     * Clears out the collRulesetEntitiesRelatedById collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRulesetEntitiesRelatedById()
     */
    public function clearRulesetEntitiesRelatedById()
    {
        $this->collRulesetEntitiesRelatedById = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRulesetEntitiesRelatedById collection loaded partially.
     */
    public function resetPartialRulesetEntitiesRelatedById($v = true)
    {
        $this->collRulesetEntitiesRelatedByIdPartial = $v;
    }

    /**
     * Initializes the collRulesetEntitiesRelatedById collection.
     *
     * By default this just sets the collRulesetEntitiesRelatedById collection to an empty array (like clearcollRulesetEntitiesRelatedById());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRulesetEntitiesRelatedById($overrideExisting = true)
    {
        if (null !== $this->collRulesetEntitiesRelatedById && !$overrideExisting) {
            return;
        }
        $this->collRulesetEntitiesRelatedById = new ObjectCollection();
        $this->collRulesetEntitiesRelatedById->setModel('\ECP\RulesetEntity');
    }

    /**
     * Gets an array of ChildRulesetEntity objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRulesetEntity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRulesetEntity[] List of ChildRulesetEntity objects
     * @throws PropelException
     */
    public function getRulesetEntitiesRelatedById(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRulesetEntitiesRelatedByIdPartial && !$this->isNew();
        if (null === $this->collRulesetEntitiesRelatedById || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRulesetEntitiesRelatedById) {
                // return empty collection
                $this->initRulesetEntitiesRelatedById();
            } else {
                $collRulesetEntitiesRelatedById = ChildRulesetEntityQuery::create(null, $criteria)
                    ->filterByRulesetEntityRelatedByForkedid($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRulesetEntitiesRelatedByIdPartial && count($collRulesetEntitiesRelatedById)) {
                        $this->initRulesetEntitiesRelatedById(false);

                        foreach ($collRulesetEntitiesRelatedById as $obj) {
                            if (false == $this->collRulesetEntitiesRelatedById->contains($obj)) {
                                $this->collRulesetEntitiesRelatedById->append($obj);
                            }
                        }

                        $this->collRulesetEntitiesRelatedByIdPartial = true;
                    }

                    return $collRulesetEntitiesRelatedById;
                }

                if ($partial && $this->collRulesetEntitiesRelatedById) {
                    foreach ($this->collRulesetEntitiesRelatedById as $obj) {
                        if ($obj->isNew()) {
                            $collRulesetEntitiesRelatedById[] = $obj;
                        }
                    }
                }

                $this->collRulesetEntitiesRelatedById = $collRulesetEntitiesRelatedById;
                $this->collRulesetEntitiesRelatedByIdPartial = false;
            }
        }

        return $this->collRulesetEntitiesRelatedById;
    }

    /**
     * Sets a collection of ChildRulesetEntity objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rulesetEntitiesRelatedById A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRulesetEntity The current object (for fluent API support)
     */
    public function setRulesetEntitiesRelatedById(Collection $rulesetEntitiesRelatedById, ConnectionInterface $con = null)
    {
        /** @var ChildRulesetEntity[] $rulesetEntitiesRelatedByIdToDelete */
        $rulesetEntitiesRelatedByIdToDelete = $this->getRulesetEntitiesRelatedById(new Criteria(), $con)->diff($rulesetEntitiesRelatedById);

        
        $this->rulesetEntitiesRelatedByIdScheduledForDeletion = $rulesetEntitiesRelatedByIdToDelete;

        foreach ($rulesetEntitiesRelatedByIdToDelete as $rulesetEntityRelatedByIdRemoved) {
            $rulesetEntityRelatedByIdRemoved->setRulesetEntityRelatedByForkedid(null);
        }

        $this->collRulesetEntitiesRelatedById = null;
        foreach ($rulesetEntitiesRelatedById as $rulesetEntityRelatedById) {
            $this->addRulesetEntityRelatedById($rulesetEntityRelatedById);
        }

        $this->collRulesetEntitiesRelatedById = $rulesetEntitiesRelatedById;
        $this->collRulesetEntitiesRelatedByIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RulesetEntity objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RulesetEntity objects.
     * @throws PropelException
     */
    public function countRulesetEntitiesRelatedById(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRulesetEntitiesRelatedByIdPartial && !$this->isNew();
        if (null === $this->collRulesetEntitiesRelatedById || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRulesetEntitiesRelatedById) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRulesetEntitiesRelatedById());
            }

            $query = ChildRulesetEntityQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRulesetEntityRelatedByForkedid($this)
                ->count($con);
        }

        return count($this->collRulesetEntitiesRelatedById);
    }

    /**
     * Method called to associate a ChildRulesetEntity object to this object
     * through the ChildRulesetEntity foreign key attribute.
     *
     * @param  ChildRulesetEntity $l ChildRulesetEntity
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     */
    public function addRulesetEntityRelatedById(ChildRulesetEntity $l)
    {
        if ($this->collRulesetEntitiesRelatedById === null) {
            $this->initRulesetEntitiesRelatedById();
            $this->collRulesetEntitiesRelatedByIdPartial = true;
        }

        if (!$this->collRulesetEntitiesRelatedById->contains($l)) {
            $this->doAddRulesetEntityRelatedById($l);
        }

        return $this;
    }

    /**
     * @param ChildRulesetEntity $rulesetEntityRelatedById The ChildRulesetEntity object to add.
     */
    protected function doAddRulesetEntityRelatedById(ChildRulesetEntity $rulesetEntityRelatedById)
    {
        $this->collRulesetEntitiesRelatedById[]= $rulesetEntityRelatedById;
        $rulesetEntityRelatedById->setRulesetEntityRelatedByForkedid($this);
    }

    /**
     * @param  ChildRulesetEntity $rulesetEntityRelatedById The ChildRulesetEntity object to remove.
     * @return $this|ChildRulesetEntity The current object (for fluent API support)
     */
    public function removeRulesetEntityRelatedById(ChildRulesetEntity $rulesetEntityRelatedById)
    {
        if ($this->getRulesetEntitiesRelatedById()->contains($rulesetEntityRelatedById)) {
            $pos = $this->collRulesetEntitiesRelatedById->search($rulesetEntityRelatedById);
            $this->collRulesetEntitiesRelatedById->remove($pos);
            if (null === $this->rulesetEntitiesRelatedByIdScheduledForDeletion) {
                $this->rulesetEntitiesRelatedByIdScheduledForDeletion = clone $this->collRulesetEntitiesRelatedById;
                $this->rulesetEntitiesRelatedByIdScheduledForDeletion->clear();
            }
            $this->rulesetEntitiesRelatedByIdScheduledForDeletion[]= $rulesetEntityRelatedById;
            $rulesetEntityRelatedById->setRulesetEntityRelatedByForkedid(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this RulesetEntity is new, it will return
     * an empty collection; or if this RulesetEntity has previously
     * been saved, it will retrieve related RulesetEntitiesRelatedById from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in RulesetEntity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRulesetEntity[] List of ChildRulesetEntity objects
     */
    public function getRulesetEntitiesRelatedByIdJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRulesetEntityQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getRulesetEntitiesRelatedById($query, $con);
    }

    /**
     * Clears out the collRulesetShips collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRulesetShips()
     */
    public function clearRulesetShips()
    {
        $this->collRulesetShips = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRulesetShips collection loaded partially.
     */
    public function resetPartialRulesetShips($v = true)
    {
        $this->collRulesetShipsPartial = $v;
    }

    /**
     * Initializes the collRulesetShips collection.
     *
     * By default this just sets the collRulesetShips collection to an empty array (like clearcollRulesetShips());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRulesetShips($overrideExisting = true)
    {
        if (null !== $this->collRulesetShips && !$overrideExisting) {
            return;
        }
        $this->collRulesetShips = new ObjectCollection();
        $this->collRulesetShips->setModel('\ECP\RulesetShip');
    }

    /**
     * Gets an array of ChildRulesetShip objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRulesetEntity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRulesetShip[] List of ChildRulesetShip objects
     * @throws PropelException
     */
    public function getRulesetShips(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRulesetShipsPartial && !$this->isNew();
        if (null === $this->collRulesetShips || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRulesetShips) {
                // return empty collection
                $this->initRulesetShips();
            } else {
                $collRulesetShips = ChildRulesetShipQuery::create(null, $criteria)
                    ->filterByRulesetEntity($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRulesetShipsPartial && count($collRulesetShips)) {
                        $this->initRulesetShips(false);

                        foreach ($collRulesetShips as $obj) {
                            if (false == $this->collRulesetShips->contains($obj)) {
                                $this->collRulesetShips->append($obj);
                            }
                        }

                        $this->collRulesetShipsPartial = true;
                    }

                    return $collRulesetShips;
                }

                if ($partial && $this->collRulesetShips) {
                    foreach ($this->collRulesetShips as $obj) {
                        if ($obj->isNew()) {
                            $collRulesetShips[] = $obj;
                        }
                    }
                }

                $this->collRulesetShips = $collRulesetShips;
                $this->collRulesetShipsPartial = false;
            }
        }

        return $this->collRulesetShips;
    }

    /**
     * Sets a collection of ChildRulesetShip objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rulesetShips A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRulesetEntity The current object (for fluent API support)
     */
    public function setRulesetShips(Collection $rulesetShips, ConnectionInterface $con = null)
    {
        /** @var ChildRulesetShip[] $rulesetShipsToDelete */
        $rulesetShipsToDelete = $this->getRulesetShips(new Criteria(), $con)->diff($rulesetShips);

        
        $this->rulesetShipsScheduledForDeletion = $rulesetShipsToDelete;

        foreach ($rulesetShipsToDelete as $rulesetShipRemoved) {
            $rulesetShipRemoved->setRulesetEntity(null);
        }

        $this->collRulesetShips = null;
        foreach ($rulesetShips as $rulesetShip) {
            $this->addRulesetShip($rulesetShip);
        }

        $this->collRulesetShips = $rulesetShips;
        $this->collRulesetShipsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RulesetShip objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RulesetShip objects.
     * @throws PropelException
     */
    public function countRulesetShips(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRulesetShipsPartial && !$this->isNew();
        if (null === $this->collRulesetShips || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRulesetShips) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRulesetShips());
            }

            $query = ChildRulesetShipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRulesetEntity($this)
                ->count($con);
        }

        return count($this->collRulesetShips);
    }

    /**
     * Method called to associate a ChildRulesetShip object to this object
     * through the ChildRulesetShip foreign key attribute.
     *
     * @param  ChildRulesetShip $l ChildRulesetShip
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     */
    public function addRulesetShip(ChildRulesetShip $l)
    {
        if ($this->collRulesetShips === null) {
            $this->initRulesetShips();
            $this->collRulesetShipsPartial = true;
        }

        if (!$this->collRulesetShips->contains($l)) {
            $this->doAddRulesetShip($l);
        }

        return $this;
    }

    /**
     * @param ChildRulesetShip $rulesetShip The ChildRulesetShip object to add.
     */
    protected function doAddRulesetShip(ChildRulesetShip $rulesetShip)
    {
        $this->collRulesetShips[]= $rulesetShip;
        $rulesetShip->setRulesetEntity($this);
    }

    /**
     * @param  ChildRulesetShip $rulesetShip The ChildRulesetShip object to remove.
     * @return $this|ChildRulesetEntity The current object (for fluent API support)
     */
    public function removeRulesetShip(ChildRulesetShip $rulesetShip)
    {
        if ($this->getRulesetShips()->contains($rulesetShip)) {
            $pos = $this->collRulesetShips->search($rulesetShip);
            $this->collRulesetShips->remove($pos);
            if (null === $this->rulesetShipsScheduledForDeletion) {
                $this->rulesetShipsScheduledForDeletion = clone $this->collRulesetShips;
                $this->rulesetShipsScheduledForDeletion->clear();
            }
            $this->rulesetShipsScheduledForDeletion[]= clone $rulesetShip;
            $rulesetShip->setRulesetEntity(null);
        }

        return $this;
    }

    /**
     * Clears out the collRulesetRuleRows collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRulesetRuleRows()
     */
    public function clearRulesetRuleRows()
    {
        $this->collRulesetRuleRows = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRulesetRuleRows collection loaded partially.
     */
    public function resetPartialRulesetRuleRows($v = true)
    {
        $this->collRulesetRuleRowsPartial = $v;
    }

    /**
     * Initializes the collRulesetRuleRows collection.
     *
     * By default this just sets the collRulesetRuleRows collection to an empty array (like clearcollRulesetRuleRows());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRulesetRuleRows($overrideExisting = true)
    {
        if (null !== $this->collRulesetRuleRows && !$overrideExisting) {
            return;
        }
        $this->collRulesetRuleRows = new ObjectCollection();
        $this->collRulesetRuleRows->setModel('\ECP\RulesetRuleRow');
    }

    /**
     * Gets an array of ChildRulesetRuleRow objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRulesetEntity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRulesetRuleRow[] List of ChildRulesetRuleRow objects
     * @throws PropelException
     */
    public function getRulesetRuleRows(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRulesetRuleRowsPartial && !$this->isNew();
        if (null === $this->collRulesetRuleRows || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRulesetRuleRows) {
                // return empty collection
                $this->initRulesetRuleRows();
            } else {
                $collRulesetRuleRows = ChildRulesetRuleRowQuery::create(null, $criteria)
                    ->filterByRulesetEntity($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRulesetRuleRowsPartial && count($collRulesetRuleRows)) {
                        $this->initRulesetRuleRows(false);

                        foreach ($collRulesetRuleRows as $obj) {
                            if (false == $this->collRulesetRuleRows->contains($obj)) {
                                $this->collRulesetRuleRows->append($obj);
                            }
                        }

                        $this->collRulesetRuleRowsPartial = true;
                    }

                    return $collRulesetRuleRows;
                }

                if ($partial && $this->collRulesetRuleRows) {
                    foreach ($this->collRulesetRuleRows as $obj) {
                        if ($obj->isNew()) {
                            $collRulesetRuleRows[] = $obj;
                        }
                    }
                }

                $this->collRulesetRuleRows = $collRulesetRuleRows;
                $this->collRulesetRuleRowsPartial = false;
            }
        }

        return $this->collRulesetRuleRows;
    }

    /**
     * Sets a collection of ChildRulesetRuleRow objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rulesetRuleRows A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRulesetEntity The current object (for fluent API support)
     */
    public function setRulesetRuleRows(Collection $rulesetRuleRows, ConnectionInterface $con = null)
    {
        /** @var ChildRulesetRuleRow[] $rulesetRuleRowsToDelete */
        $rulesetRuleRowsToDelete = $this->getRulesetRuleRows(new Criteria(), $con)->diff($rulesetRuleRows);

        
        $this->rulesetRuleRowsScheduledForDeletion = $rulesetRuleRowsToDelete;

        foreach ($rulesetRuleRowsToDelete as $rulesetRuleRowRemoved) {
            $rulesetRuleRowRemoved->setRulesetEntity(null);
        }

        $this->collRulesetRuleRows = null;
        foreach ($rulesetRuleRows as $rulesetRuleRow) {
            $this->addRulesetRuleRow($rulesetRuleRow);
        }

        $this->collRulesetRuleRows = $rulesetRuleRows;
        $this->collRulesetRuleRowsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RulesetRuleRow objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RulesetRuleRow objects.
     * @throws PropelException
     */
    public function countRulesetRuleRows(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRulesetRuleRowsPartial && !$this->isNew();
        if (null === $this->collRulesetRuleRows || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRulesetRuleRows) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRulesetRuleRows());
            }

            $query = ChildRulesetRuleRowQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRulesetEntity($this)
                ->count($con);
        }

        return count($this->collRulesetRuleRows);
    }

    /**
     * Method called to associate a ChildRulesetRuleRow object to this object
     * through the ChildRulesetRuleRow foreign key attribute.
     *
     * @param  ChildRulesetRuleRow $l ChildRulesetRuleRow
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     */
    public function addRulesetRuleRow(ChildRulesetRuleRow $l)
    {
        if ($this->collRulesetRuleRows === null) {
            $this->initRulesetRuleRows();
            $this->collRulesetRuleRowsPartial = true;
        }

        if (!$this->collRulesetRuleRows->contains($l)) {
            $this->doAddRulesetRuleRow($l);
        }

        return $this;
    }

    /**
     * @param ChildRulesetRuleRow $rulesetRuleRow The ChildRulesetRuleRow object to add.
     */
    protected function doAddRulesetRuleRow(ChildRulesetRuleRow $rulesetRuleRow)
    {
        $this->collRulesetRuleRows[]= $rulesetRuleRow;
        $rulesetRuleRow->setRulesetEntity($this);
    }

    /**
     * @param  ChildRulesetRuleRow $rulesetRuleRow The ChildRulesetRuleRow object to remove.
     * @return $this|ChildRulesetEntity The current object (for fluent API support)
     */
    public function removeRulesetRuleRow(ChildRulesetRuleRow $rulesetRuleRow)
    {
        if ($this->getRulesetRuleRows()->contains($rulesetRuleRow)) {
            $pos = $this->collRulesetRuleRows->search($rulesetRuleRow);
            $this->collRulesetRuleRows->remove($pos);
            if (null === $this->rulesetRuleRowsScheduledForDeletion) {
                $this->rulesetRuleRowsScheduledForDeletion = clone $this->collRulesetRuleRows;
                $this->rulesetRuleRowsScheduledForDeletion->clear();
            }
            $this->rulesetRuleRowsScheduledForDeletion[]= clone $rulesetRuleRow;
            $rulesetRuleRow->setRulesetEntity(null);
        }

        return $this;
    }

    /**
     * Clears out the collCompositionEntities collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCompositionEntities()
     */
    public function clearCompositionEntities()
    {
        $this->collCompositionEntities = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCompositionEntities collection loaded partially.
     */
    public function resetPartialCompositionEntities($v = true)
    {
        $this->collCompositionEntitiesPartial = $v;
    }

    /**
     * Initializes the collCompositionEntities collection.
     *
     * By default this just sets the collCompositionEntities collection to an empty array (like clearcollCompositionEntities());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCompositionEntities($overrideExisting = true)
    {
        if (null !== $this->collCompositionEntities && !$overrideExisting) {
            return;
        }
        $this->collCompositionEntities = new ObjectCollection();
        $this->collCompositionEntities->setModel('\ECP\CompositionEntity');
    }

    /**
     * Gets an array of ChildCompositionEntity objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRulesetEntity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCompositionEntity[] List of ChildCompositionEntity objects
     * @throws PropelException
     */
    public function getCompositionEntities(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCompositionEntitiesPartial && !$this->isNew();
        if (null === $this->collCompositionEntities || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCompositionEntities) {
                // return empty collection
                $this->initCompositionEntities();
            } else {
                $collCompositionEntities = ChildCompositionEntityQuery::create(null, $criteria)
                    ->filterByRulesetEntity($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCompositionEntitiesPartial && count($collCompositionEntities)) {
                        $this->initCompositionEntities(false);

                        foreach ($collCompositionEntities as $obj) {
                            if (false == $this->collCompositionEntities->contains($obj)) {
                                $this->collCompositionEntities->append($obj);
                            }
                        }

                        $this->collCompositionEntitiesPartial = true;
                    }

                    return $collCompositionEntities;
                }

                if ($partial && $this->collCompositionEntities) {
                    foreach ($this->collCompositionEntities as $obj) {
                        if ($obj->isNew()) {
                            $collCompositionEntities[] = $obj;
                        }
                    }
                }

                $this->collCompositionEntities = $collCompositionEntities;
                $this->collCompositionEntitiesPartial = false;
            }
        }

        return $this->collCompositionEntities;
    }

    /**
     * Sets a collection of ChildCompositionEntity objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $compositionEntities A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRulesetEntity The current object (for fluent API support)
     */
    public function setCompositionEntities(Collection $compositionEntities, ConnectionInterface $con = null)
    {
        /** @var ChildCompositionEntity[] $compositionEntitiesToDelete */
        $compositionEntitiesToDelete = $this->getCompositionEntities(new Criteria(), $con)->diff($compositionEntities);

        
        $this->compositionEntitiesScheduledForDeletion = $compositionEntitiesToDelete;

        foreach ($compositionEntitiesToDelete as $compositionEntityRemoved) {
            $compositionEntityRemoved->setRulesetEntity(null);
        }

        $this->collCompositionEntities = null;
        foreach ($compositionEntities as $compositionEntity) {
            $this->addCompositionEntity($compositionEntity);
        }

        $this->collCompositionEntities = $compositionEntities;
        $this->collCompositionEntitiesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CompositionEntity objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CompositionEntity objects.
     * @throws PropelException
     */
    public function countCompositionEntities(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCompositionEntitiesPartial && !$this->isNew();
        if (null === $this->collCompositionEntities || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCompositionEntities) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCompositionEntities());
            }

            $query = ChildCompositionEntityQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRulesetEntity($this)
                ->count($con);
        }

        return count($this->collCompositionEntities);
    }

    /**
     * Method called to associate a ChildCompositionEntity object to this object
     * through the ChildCompositionEntity foreign key attribute.
     *
     * @param  ChildCompositionEntity $l ChildCompositionEntity
     * @return $this|\ECP\RulesetEntity The current object (for fluent API support)
     */
    public function addCompositionEntity(ChildCompositionEntity $l)
    {
        if ($this->collCompositionEntities === null) {
            $this->initCompositionEntities();
            $this->collCompositionEntitiesPartial = true;
        }

        if (!$this->collCompositionEntities->contains($l)) {
            $this->doAddCompositionEntity($l);
        }

        return $this;
    }

    /**
     * @param ChildCompositionEntity $compositionEntity The ChildCompositionEntity object to add.
     */
    protected function doAddCompositionEntity(ChildCompositionEntity $compositionEntity)
    {
        $this->collCompositionEntities[]= $compositionEntity;
        $compositionEntity->setRulesetEntity($this);
    }

    /**
     * @param  ChildCompositionEntity $compositionEntity The ChildCompositionEntity object to remove.
     * @return $this|ChildRulesetEntity The current object (for fluent API support)
     */
    public function removeCompositionEntity(ChildCompositionEntity $compositionEntity)
    {
        if ($this->getCompositionEntities()->contains($compositionEntity)) {
            $pos = $this->collCompositionEntities->search($compositionEntity);
            $this->collCompositionEntities->remove($pos);
            if (null === $this->compositionEntitiesScheduledForDeletion) {
                $this->compositionEntitiesScheduledForDeletion = clone $this->collCompositionEntities;
                $this->compositionEntitiesScheduledForDeletion->clear();
            }
            $this->compositionEntitiesScheduledForDeletion[]= clone $compositionEntity;
            $compositionEntity->setRulesetEntity(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this RulesetEntity is new, it will return
     * an empty collection; or if this RulesetEntity has previously
     * been saved, it will retrieve related CompositionEntities from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in RulesetEntity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCompositionEntity[] List of ChildCompositionEntity objects
     */
    public function getCompositionEntitiesJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCompositionEntityQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getCompositionEntities($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this RulesetEntity is new, it will return
     * an empty collection; or if this RulesetEntity has previously
     * been saved, it will retrieve related CompositionEntities from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in RulesetEntity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCompositionEntity[] List of ChildCompositionEntity objects
     */
    public function getCompositionEntitiesJoinCompositionEntityRelatedByForkedid(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCompositionEntityQuery::create(null, $criteria);
        $query->joinWith('CompositionEntityRelatedByForkedid', $joinBehavior);

        return $this->getCompositionEntities($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUser) {
            $this->aUser->removeRulesetEntity($this);
        }
        if (null !== $this->aRulesetEntityRelatedByForkedid) {
            $this->aRulesetEntityRelatedByForkedid->removeRulesetEntityRelatedById($this);
        }
        $this->id = null;
        $this->name = null;
        $this->userid = null;
        $this->islisted = null;
        $this->forkedid = null;
        $this->minpilots = null;
        $this->maxpilots = null;
        $this->maxpoints = null;
        $this->lastmodified = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collRulesetEntitiesRelatedById) {
                foreach ($this->collRulesetEntitiesRelatedById as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRulesetShips) {
                foreach ($this->collRulesetShips as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRulesetRuleRows) {
                foreach ($this->collRulesetRuleRows as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCompositionEntities) {
                foreach ($this->collCompositionEntities as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRulesetEntitiesRelatedById = null;
        $this->collRulesetShips = null;
        $this->collRulesetRuleRows = null;
        $this->collCompositionEntities = null;
        $this->aUser = null;
        $this->aRulesetEntityRelatedByForkedid = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(RulesetEntityTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
