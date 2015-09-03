<?php

namespace ECP\Base;

use \DateTime;
use \Exception;
use \PDO;
use ECP\CompositionEntity as ChildCompositionEntity;
use ECP\CompositionEntityQuery as ChildCompositionEntityQuery;
use ECP\CompositionRow as ChildCompositionRow;
use ECP\CompositionRowQuery as ChildCompositionRowQuery;
use ECP\RulesetEntity as ChildRulesetEntity;
use ECP\RulesetEntityQuery as ChildRulesetEntityQuery;
use ECP\User as ChildUser;
use ECP\UserQuery as ChildUserQuery;
use ECP\Map\CompositionEntityTableMap;
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
 * Base class that represents a row from the 'compositionentity' table.
 *
 * 
 *
* @package    propel.generator.ECP.Base
*/
abstract class CompositionEntity implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\ECP\\Map\\CompositionEntityTableMap';


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
     * The value for the rulesetentityid field.
     * @var        int
     */
    protected $rulesetentityid;

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
     * @var        ChildCompositionEntity
     */
    protected $aCompositionEntityRelatedByForkedid;

    /**
     * @var        ChildRulesetEntity
     */
    protected $aRulesetEntity;

    /**
     * @var        ObjectCollection|ChildCompositionEntity[] Collection to store aggregation of ChildCompositionEntity objects.
     */
    protected $collCompositionEntitiesRelatedById;
    protected $collCompositionEntitiesRelatedByIdPartial;

    /**
     * @var        ObjectCollection|ChildCompositionRow[] Collection to store aggregation of ChildCompositionRow objects.
     */
    protected $collCompositionRows;
    protected $collCompositionRowsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCompositionEntity[]
     */
    protected $compositionEntitiesRelatedByIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCompositionRow[]
     */
    protected $compositionRowsScheduledForDeletion = null;

    /**
     * Initializes internal state of ECP\Base\CompositionEntity object.
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
     * Compares this with another <code>CompositionEntity</code> instance.  If
     * <code>obj</code> is an instance of <code>CompositionEntity</code>, delegates to
     * <code>equals(CompositionEntity)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|CompositionEntity The current object, for fluid interface
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
     * Get the [rulesetentityid] column value.
     * 
     * @return int
     */
    public function getRulesetentityid()
    {
        return $this->rulesetentityid;
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
     * @return $this|\ECP\CompositionEntity The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CompositionEntityTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     * 
     * @param string $v new value
     * @return $this|\ECP\CompositionEntity The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[CompositionEntityTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [userid] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\CompositionEntity The current object (for fluent API support)
     */
    public function setUserid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->userid !== $v) {
            $this->userid = $v;
            $this->modifiedColumns[CompositionEntityTableMap::COL_USERID] = true;
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
     * @return $this|\ECP\CompositionEntity The current object (for fluent API support)
     */
    public function setIslisted($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->islisted !== $v) {
            $this->islisted = $v;
            $this->modifiedColumns[CompositionEntityTableMap::COL_ISLISTED] = true;
        }

        return $this;
    } // setIslisted()

    /**
     * Set the value of [forkedid] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\CompositionEntity The current object (for fluent API support)
     */
    public function setForkedid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->forkedid !== $v) {
            $this->forkedid = $v;
            $this->modifiedColumns[CompositionEntityTableMap::COL_FORKEDID] = true;
        }

        if ($this->aCompositionEntityRelatedByForkedid !== null && $this->aCompositionEntityRelatedByForkedid->getId() !== $v) {
            $this->aCompositionEntityRelatedByForkedid = null;
        }

        return $this;
    } // setForkedid()

    /**
     * Set the value of [rulesetentityid] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\CompositionEntity The current object (for fluent API support)
     */
    public function setRulesetentityid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->rulesetentityid !== $v) {
            $this->rulesetentityid = $v;
            $this->modifiedColumns[CompositionEntityTableMap::COL_RULESETENTITYID] = true;
        }

        if ($this->aRulesetEntity !== null && $this->aRulesetEntity->getId() !== $v) {
            $this->aRulesetEntity = null;
        }

        return $this;
    } // setRulesetentityid()

    /**
     * Sets the value of [lastmodified] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\ECP\CompositionEntity The current object (for fluent API support)
     */
    public function setLastmodified($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->lastmodified !== null || $dt !== null) {
            if ($this->lastmodified === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->lastmodified->format("Y-m-d H:i:s")) {
                $this->lastmodified = $dt === null ? null : clone $dt;
                $this->modifiedColumns[CompositionEntityTableMap::COL_LASTMODIFIED] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CompositionEntityTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CompositionEntityTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CompositionEntityTableMap::translateFieldName('Userid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->userid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CompositionEntityTableMap::translateFieldName('Islisted', TableMap::TYPE_PHPNAME, $indexType)];
            $this->islisted = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CompositionEntityTableMap::translateFieldName('Forkedid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->forkedid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CompositionEntityTableMap::translateFieldName('Rulesetentityid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->rulesetentityid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : CompositionEntityTableMap::translateFieldName('Lastmodified', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->lastmodified = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = CompositionEntityTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ECP\\CompositionEntity'), 0, $e);
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
        if ($this->aCompositionEntityRelatedByForkedid !== null && $this->forkedid !== $this->aCompositionEntityRelatedByForkedid->getId()) {
            $this->aCompositionEntityRelatedByForkedid = null;
        }
        if ($this->aRulesetEntity !== null && $this->rulesetentityid !== $this->aRulesetEntity->getId()) {
            $this->aRulesetEntity = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(CompositionEntityTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCompositionEntityQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUser = null;
            $this->aCompositionEntityRelatedByForkedid = null;
            $this->aRulesetEntity = null;
            $this->collCompositionEntitiesRelatedById = null;

            $this->collCompositionRows = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see CompositionEntity::setDeleted()
     * @see CompositionEntity::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompositionEntityTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCompositionEntityQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CompositionEntityTableMap::DATABASE_NAME);
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
                CompositionEntityTableMap::addInstanceToPool($this);
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

            if ($this->aCompositionEntityRelatedByForkedid !== null) {
                if ($this->aCompositionEntityRelatedByForkedid->isModified() || $this->aCompositionEntityRelatedByForkedid->isNew()) {
                    $affectedRows += $this->aCompositionEntityRelatedByForkedid->save($con);
                }
                $this->setCompositionEntityRelatedByForkedid($this->aCompositionEntityRelatedByForkedid);
            }

            if ($this->aRulesetEntity !== null) {
                if ($this->aRulesetEntity->isModified() || $this->aRulesetEntity->isNew()) {
                    $affectedRows += $this->aRulesetEntity->save($con);
                }
                $this->setRulesetEntity($this->aRulesetEntity);
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

            if ($this->compositionEntitiesRelatedByIdScheduledForDeletion !== null) {
                if (!$this->compositionEntitiesRelatedByIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->compositionEntitiesRelatedByIdScheduledForDeletion as $compositionEntityRelatedById) {
                        // need to save related object because we set the relation to null
                        $compositionEntityRelatedById->save($con);
                    }
                    $this->compositionEntitiesRelatedByIdScheduledForDeletion = null;
                }
            }

            if ($this->collCompositionEntitiesRelatedById !== null) {
                foreach ($this->collCompositionEntitiesRelatedById as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->compositionRowsScheduledForDeletion !== null) {
                if (!$this->compositionRowsScheduledForDeletion->isEmpty()) {
                    \ECP\CompositionRowQuery::create()
                        ->filterByPrimaryKeys($this->compositionRowsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->compositionRowsScheduledForDeletion = null;
                }
            }

            if ($this->collCompositionRows !== null) {
                foreach ($this->collCompositionRows as $referrerFK) {
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

        $this->modifiedColumns[CompositionEntityTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CompositionEntityTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CompositionEntityTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(CompositionEntityTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(CompositionEntityTableMap::COL_USERID)) {
            $modifiedColumns[':p' . $index++]  = 'userId';
        }
        if ($this->isColumnModified(CompositionEntityTableMap::COL_ISLISTED)) {
            $modifiedColumns[':p' . $index++]  = 'isListed';
        }
        if ($this->isColumnModified(CompositionEntityTableMap::COL_FORKEDID)) {
            $modifiedColumns[':p' . $index++]  = 'forkedId';
        }
        if ($this->isColumnModified(CompositionEntityTableMap::COL_RULESETENTITYID)) {
            $modifiedColumns[':p' . $index++]  = 'rulesetEntityId';
        }
        if ($this->isColumnModified(CompositionEntityTableMap::COL_LASTMODIFIED)) {
            $modifiedColumns[':p' . $index++]  = 'lastModified';
        }

        $sql = sprintf(
            'INSERT INTO compositionentity (%s) VALUES (%s)',
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
                    case 'rulesetEntityId':                        
                        $stmt->bindValue($identifier, $this->rulesetentityid, PDO::PARAM_INT);
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
        $pos = CompositionEntityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getRulesetentityid();
                break;
            case 6:
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

        if (isset($alreadyDumpedObjects['CompositionEntity'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['CompositionEntity'][$this->hashCode()] = true;
        $keys = CompositionEntityTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getUserid(),
            $keys[3] => $this->getIslisted(),
            $keys[4] => $this->getForkedid(),
            $keys[5] => $this->getRulesetentityid(),
            $keys[6] => $this->getLastmodified(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[6]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[6]];
            $result[$keys[6]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
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
            if (null !== $this->aCompositionEntityRelatedByForkedid) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'compositionEntity';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'compositionentity';
                        break;
                    default:
                        $key = 'CompositionEntity';
                }
        
                $result[$key] = $this->aCompositionEntityRelatedByForkedid->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aRulesetEntity) {
                
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
        
                $result[$key] = $this->aRulesetEntity->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCompositionEntitiesRelatedById) {
                
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
        
                $result[$key] = $this->collCompositionEntitiesRelatedById->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCompositionRows) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'compositionRows';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'compositionrows';
                        break;
                    default:
                        $key = 'CompositionRows';
                }
        
                $result[$key] = $this->collCompositionRows->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\ECP\CompositionEntity
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CompositionEntityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ECP\CompositionEntity
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
                $this->setRulesetentityid($value);
                break;
            case 6:
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
        $keys = CompositionEntityTableMap::getFieldNames($keyType);

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
            $this->setRulesetentityid($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setLastmodified($arr[$keys[6]]);
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
     * @return $this|\ECP\CompositionEntity The current object, for fluid interface
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
        $criteria = new Criteria(CompositionEntityTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CompositionEntityTableMap::COL_ID)) {
            $criteria->add(CompositionEntityTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(CompositionEntityTableMap::COL_NAME)) {
            $criteria->add(CompositionEntityTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(CompositionEntityTableMap::COL_USERID)) {
            $criteria->add(CompositionEntityTableMap::COL_USERID, $this->userid);
        }
        if ($this->isColumnModified(CompositionEntityTableMap::COL_ISLISTED)) {
            $criteria->add(CompositionEntityTableMap::COL_ISLISTED, $this->islisted);
        }
        if ($this->isColumnModified(CompositionEntityTableMap::COL_FORKEDID)) {
            $criteria->add(CompositionEntityTableMap::COL_FORKEDID, $this->forkedid);
        }
        if ($this->isColumnModified(CompositionEntityTableMap::COL_RULESETENTITYID)) {
            $criteria->add(CompositionEntityTableMap::COL_RULESETENTITYID, $this->rulesetentityid);
        }
        if ($this->isColumnModified(CompositionEntityTableMap::COL_LASTMODIFIED)) {
            $criteria->add(CompositionEntityTableMap::COL_LASTMODIFIED, $this->lastmodified);
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
        $criteria = ChildCompositionEntityQuery::create();
        $criteria->add(CompositionEntityTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \ECP\CompositionEntity (or compatible) type.
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
        $copyObj->setRulesetentityid($this->getRulesetentityid());
        $copyObj->setLastmodified($this->getLastmodified());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCompositionEntitiesRelatedById() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCompositionEntityRelatedById($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCompositionRows() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCompositionRow($relObj->copy($deepCopy));
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
     * @return \ECP\CompositionEntity Clone of current object.
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
     * @return $this|\ECP\CompositionEntity The current object (for fluent API support)
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
            $v->addCompositionEntity($this);
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
                $this->aUser->addCompositionEntities($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a ChildCompositionEntity object.
     *
     * @param  ChildCompositionEntity $v
     * @return $this|\ECP\CompositionEntity The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCompositionEntityRelatedByForkedid(ChildCompositionEntity $v = null)
    {
        if ($v === null) {
            $this->setForkedid(NULL);
        } else {
            $this->setForkedid($v->getId());
        }

        $this->aCompositionEntityRelatedByForkedid = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCompositionEntity object, it will not be re-added.
        if ($v !== null) {
            $v->addCompositionEntityRelatedById($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCompositionEntity object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCompositionEntity The associated ChildCompositionEntity object.
     * @throws PropelException
     */
    public function getCompositionEntityRelatedByForkedid(ConnectionInterface $con = null)
    {
        if ($this->aCompositionEntityRelatedByForkedid === null && ($this->forkedid !== null)) {
            $this->aCompositionEntityRelatedByForkedid = ChildCompositionEntityQuery::create()->findPk($this->forkedid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCompositionEntityRelatedByForkedid->addCompositionEntitiesRelatedById($this);
             */
        }

        return $this->aCompositionEntityRelatedByForkedid;
    }

    /**
     * Declares an association between this object and a ChildRulesetEntity object.
     *
     * @param  ChildRulesetEntity $v
     * @return $this|\ECP\CompositionEntity The current object (for fluent API support)
     * @throws PropelException
     */
    public function setRulesetEntity(ChildRulesetEntity $v = null)
    {
        if ($v === null) {
            $this->setRulesetentityid(NULL);
        } else {
            $this->setRulesetentityid($v->getId());
        }

        $this->aRulesetEntity = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildRulesetEntity object, it will not be re-added.
        if ($v !== null) {
            $v->addCompositionEntity($this);
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
    public function getRulesetEntity(ConnectionInterface $con = null)
    {
        if ($this->aRulesetEntity === null && ($this->rulesetentityid !== null)) {
            $this->aRulesetEntity = ChildRulesetEntityQuery::create()->findPk($this->rulesetentityid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aRulesetEntity->addCompositionEntities($this);
             */
        }

        return $this->aRulesetEntity;
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
        if ('CompositionEntityRelatedById' == $relationName) {
            return $this->initCompositionEntitiesRelatedById();
        }
        if ('CompositionRow' == $relationName) {
            return $this->initCompositionRows();
        }
    }

    /**
     * Clears out the collCompositionEntitiesRelatedById collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCompositionEntitiesRelatedById()
     */
    public function clearCompositionEntitiesRelatedById()
    {
        $this->collCompositionEntitiesRelatedById = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCompositionEntitiesRelatedById collection loaded partially.
     */
    public function resetPartialCompositionEntitiesRelatedById($v = true)
    {
        $this->collCompositionEntitiesRelatedByIdPartial = $v;
    }

    /**
     * Initializes the collCompositionEntitiesRelatedById collection.
     *
     * By default this just sets the collCompositionEntitiesRelatedById collection to an empty array (like clearcollCompositionEntitiesRelatedById());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCompositionEntitiesRelatedById($overrideExisting = true)
    {
        if (null !== $this->collCompositionEntitiesRelatedById && !$overrideExisting) {
            return;
        }
        $this->collCompositionEntitiesRelatedById = new ObjectCollection();
        $this->collCompositionEntitiesRelatedById->setModel('\ECP\CompositionEntity');
    }

    /**
     * Gets an array of ChildCompositionEntity objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCompositionEntity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCompositionEntity[] List of ChildCompositionEntity objects
     * @throws PropelException
     */
    public function getCompositionEntitiesRelatedById(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCompositionEntitiesRelatedByIdPartial && !$this->isNew();
        if (null === $this->collCompositionEntitiesRelatedById || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCompositionEntitiesRelatedById) {
                // return empty collection
                $this->initCompositionEntitiesRelatedById();
            } else {
                $collCompositionEntitiesRelatedById = ChildCompositionEntityQuery::create(null, $criteria)
                    ->filterByCompositionEntityRelatedByForkedid($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCompositionEntitiesRelatedByIdPartial && count($collCompositionEntitiesRelatedById)) {
                        $this->initCompositionEntitiesRelatedById(false);

                        foreach ($collCompositionEntitiesRelatedById as $obj) {
                            if (false == $this->collCompositionEntitiesRelatedById->contains($obj)) {
                                $this->collCompositionEntitiesRelatedById->append($obj);
                            }
                        }

                        $this->collCompositionEntitiesRelatedByIdPartial = true;
                    }

                    return $collCompositionEntitiesRelatedById;
                }

                if ($partial && $this->collCompositionEntitiesRelatedById) {
                    foreach ($this->collCompositionEntitiesRelatedById as $obj) {
                        if ($obj->isNew()) {
                            $collCompositionEntitiesRelatedById[] = $obj;
                        }
                    }
                }

                $this->collCompositionEntitiesRelatedById = $collCompositionEntitiesRelatedById;
                $this->collCompositionEntitiesRelatedByIdPartial = false;
            }
        }

        return $this->collCompositionEntitiesRelatedById;
    }

    /**
     * Sets a collection of ChildCompositionEntity objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $compositionEntitiesRelatedById A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCompositionEntity The current object (for fluent API support)
     */
    public function setCompositionEntitiesRelatedById(Collection $compositionEntitiesRelatedById, ConnectionInterface $con = null)
    {
        /** @var ChildCompositionEntity[] $compositionEntitiesRelatedByIdToDelete */
        $compositionEntitiesRelatedByIdToDelete = $this->getCompositionEntitiesRelatedById(new Criteria(), $con)->diff($compositionEntitiesRelatedById);

        
        $this->compositionEntitiesRelatedByIdScheduledForDeletion = $compositionEntitiesRelatedByIdToDelete;

        foreach ($compositionEntitiesRelatedByIdToDelete as $compositionEntityRelatedByIdRemoved) {
            $compositionEntityRelatedByIdRemoved->setCompositionEntityRelatedByForkedid(null);
        }

        $this->collCompositionEntitiesRelatedById = null;
        foreach ($compositionEntitiesRelatedById as $compositionEntityRelatedById) {
            $this->addCompositionEntityRelatedById($compositionEntityRelatedById);
        }

        $this->collCompositionEntitiesRelatedById = $compositionEntitiesRelatedById;
        $this->collCompositionEntitiesRelatedByIdPartial = false;

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
    public function countCompositionEntitiesRelatedById(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCompositionEntitiesRelatedByIdPartial && !$this->isNew();
        if (null === $this->collCompositionEntitiesRelatedById || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCompositionEntitiesRelatedById) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCompositionEntitiesRelatedById());
            }

            $query = ChildCompositionEntityQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCompositionEntityRelatedByForkedid($this)
                ->count($con);
        }

        return count($this->collCompositionEntitiesRelatedById);
    }

    /**
     * Method called to associate a ChildCompositionEntity object to this object
     * through the ChildCompositionEntity foreign key attribute.
     *
     * @param  ChildCompositionEntity $l ChildCompositionEntity
     * @return $this|\ECP\CompositionEntity The current object (for fluent API support)
     */
    public function addCompositionEntityRelatedById(ChildCompositionEntity $l)
    {
        if ($this->collCompositionEntitiesRelatedById === null) {
            $this->initCompositionEntitiesRelatedById();
            $this->collCompositionEntitiesRelatedByIdPartial = true;
        }

        if (!$this->collCompositionEntitiesRelatedById->contains($l)) {
            $this->doAddCompositionEntityRelatedById($l);
        }

        return $this;
    }

    /**
     * @param ChildCompositionEntity $compositionEntityRelatedById The ChildCompositionEntity object to add.
     */
    protected function doAddCompositionEntityRelatedById(ChildCompositionEntity $compositionEntityRelatedById)
    {
        $this->collCompositionEntitiesRelatedById[]= $compositionEntityRelatedById;
        $compositionEntityRelatedById->setCompositionEntityRelatedByForkedid($this);
    }

    /**
     * @param  ChildCompositionEntity $compositionEntityRelatedById The ChildCompositionEntity object to remove.
     * @return $this|ChildCompositionEntity The current object (for fluent API support)
     */
    public function removeCompositionEntityRelatedById(ChildCompositionEntity $compositionEntityRelatedById)
    {
        if ($this->getCompositionEntitiesRelatedById()->contains($compositionEntityRelatedById)) {
            $pos = $this->collCompositionEntitiesRelatedById->search($compositionEntityRelatedById);
            $this->collCompositionEntitiesRelatedById->remove($pos);
            if (null === $this->compositionEntitiesRelatedByIdScheduledForDeletion) {
                $this->compositionEntitiesRelatedByIdScheduledForDeletion = clone $this->collCompositionEntitiesRelatedById;
                $this->compositionEntitiesRelatedByIdScheduledForDeletion->clear();
            }
            $this->compositionEntitiesRelatedByIdScheduledForDeletion[]= $compositionEntityRelatedById;
            $compositionEntityRelatedById->setCompositionEntityRelatedByForkedid(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this CompositionEntity is new, it will return
     * an empty collection; or if this CompositionEntity has previously
     * been saved, it will retrieve related CompositionEntitiesRelatedById from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in CompositionEntity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCompositionEntity[] List of ChildCompositionEntity objects
     */
    public function getCompositionEntitiesRelatedByIdJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCompositionEntityQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getCompositionEntitiesRelatedById($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this CompositionEntity is new, it will return
     * an empty collection; or if this CompositionEntity has previously
     * been saved, it will retrieve related CompositionEntitiesRelatedById from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in CompositionEntity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCompositionEntity[] List of ChildCompositionEntity objects
     */
    public function getCompositionEntitiesRelatedByIdJoinRulesetEntity(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCompositionEntityQuery::create(null, $criteria);
        $query->joinWith('RulesetEntity', $joinBehavior);

        return $this->getCompositionEntitiesRelatedById($query, $con);
    }

    /**
     * Clears out the collCompositionRows collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCompositionRows()
     */
    public function clearCompositionRows()
    {
        $this->collCompositionRows = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCompositionRows collection loaded partially.
     */
    public function resetPartialCompositionRows($v = true)
    {
        $this->collCompositionRowsPartial = $v;
    }

    /**
     * Initializes the collCompositionRows collection.
     *
     * By default this just sets the collCompositionRows collection to an empty array (like clearcollCompositionRows());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCompositionRows($overrideExisting = true)
    {
        if (null !== $this->collCompositionRows && !$overrideExisting) {
            return;
        }
        $this->collCompositionRows = new ObjectCollection();
        $this->collCompositionRows->setModel('\ECP\CompositionRow');
    }

    /**
     * Gets an array of ChildCompositionRow objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCompositionEntity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCompositionRow[] List of ChildCompositionRow objects
     * @throws PropelException
     */
    public function getCompositionRows(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCompositionRowsPartial && !$this->isNew();
        if (null === $this->collCompositionRows || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCompositionRows) {
                // return empty collection
                $this->initCompositionRows();
            } else {
                $collCompositionRows = ChildCompositionRowQuery::create(null, $criteria)
                    ->filterByCompositionEntity($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCompositionRowsPartial && count($collCompositionRows)) {
                        $this->initCompositionRows(false);

                        foreach ($collCompositionRows as $obj) {
                            if (false == $this->collCompositionRows->contains($obj)) {
                                $this->collCompositionRows->append($obj);
                            }
                        }

                        $this->collCompositionRowsPartial = true;
                    }

                    return $collCompositionRows;
                }

                if ($partial && $this->collCompositionRows) {
                    foreach ($this->collCompositionRows as $obj) {
                        if ($obj->isNew()) {
                            $collCompositionRows[] = $obj;
                        }
                    }
                }

                $this->collCompositionRows = $collCompositionRows;
                $this->collCompositionRowsPartial = false;
            }
        }

        return $this->collCompositionRows;
    }

    /**
     * Sets a collection of ChildCompositionRow objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $compositionRows A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCompositionEntity The current object (for fluent API support)
     */
    public function setCompositionRows(Collection $compositionRows, ConnectionInterface $con = null)
    {
        /** @var ChildCompositionRow[] $compositionRowsToDelete */
        $compositionRowsToDelete = $this->getCompositionRows(new Criteria(), $con)->diff($compositionRows);

        
        $this->compositionRowsScheduledForDeletion = $compositionRowsToDelete;

        foreach ($compositionRowsToDelete as $compositionRowRemoved) {
            $compositionRowRemoved->setCompositionEntity(null);
        }

        $this->collCompositionRows = null;
        foreach ($compositionRows as $compositionRow) {
            $this->addCompositionRow($compositionRow);
        }

        $this->collCompositionRows = $compositionRows;
        $this->collCompositionRowsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CompositionRow objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CompositionRow objects.
     * @throws PropelException
     */
    public function countCompositionRows(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCompositionRowsPartial && !$this->isNew();
        if (null === $this->collCompositionRows || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCompositionRows) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCompositionRows());
            }

            $query = ChildCompositionRowQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCompositionEntity($this)
                ->count($con);
        }

        return count($this->collCompositionRows);
    }

    /**
     * Method called to associate a ChildCompositionRow object to this object
     * through the ChildCompositionRow foreign key attribute.
     *
     * @param  ChildCompositionRow $l ChildCompositionRow
     * @return $this|\ECP\CompositionEntity The current object (for fluent API support)
     */
    public function addCompositionRow(ChildCompositionRow $l)
    {
        if ($this->collCompositionRows === null) {
            $this->initCompositionRows();
            $this->collCompositionRowsPartial = true;
        }

        if (!$this->collCompositionRows->contains($l)) {
            $this->doAddCompositionRow($l);
        }

        return $this;
    }

    /**
     * @param ChildCompositionRow $compositionRow The ChildCompositionRow object to add.
     */
    protected function doAddCompositionRow(ChildCompositionRow $compositionRow)
    {
        $this->collCompositionRows[]= $compositionRow;
        $compositionRow->setCompositionEntity($this);
    }

    /**
     * @param  ChildCompositionRow $compositionRow The ChildCompositionRow object to remove.
     * @return $this|ChildCompositionEntity The current object (for fluent API support)
     */
    public function removeCompositionRow(ChildCompositionRow $compositionRow)
    {
        if ($this->getCompositionRows()->contains($compositionRow)) {
            $pos = $this->collCompositionRows->search($compositionRow);
            $this->collCompositionRows->remove($pos);
            if (null === $this->compositionRowsScheduledForDeletion) {
                $this->compositionRowsScheduledForDeletion = clone $this->collCompositionRows;
                $this->compositionRowsScheduledForDeletion->clear();
            }
            $this->compositionRowsScheduledForDeletion[]= clone $compositionRow;
            $compositionRow->setCompositionEntity(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUser) {
            $this->aUser->removeCompositionEntity($this);
        }
        if (null !== $this->aCompositionEntityRelatedByForkedid) {
            $this->aCompositionEntityRelatedByForkedid->removeCompositionEntityRelatedById($this);
        }
        if (null !== $this->aRulesetEntity) {
            $this->aRulesetEntity->removeCompositionEntity($this);
        }
        $this->id = null;
        $this->name = null;
        $this->userid = null;
        $this->islisted = null;
        $this->forkedid = null;
        $this->rulesetentityid = null;
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
            if ($this->collCompositionEntitiesRelatedById) {
                foreach ($this->collCompositionEntitiesRelatedById as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCompositionRows) {
                foreach ($this->collCompositionRows as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCompositionEntitiesRelatedById = null;
        $this->collCompositionRows = null;
        $this->aUser = null;
        $this->aCompositionEntityRelatedByForkedid = null;
        $this->aRulesetEntity = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CompositionEntityTableMap::DEFAULT_STRING_FORMAT);
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
