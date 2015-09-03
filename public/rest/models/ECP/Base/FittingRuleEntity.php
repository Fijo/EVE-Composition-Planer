<?php

namespace ECP\Base;

use \DateTime;
use \Exception;
use \PDO;
use ECP\FittingRuleEntity as ChildFittingRuleEntity;
use ECP\FittingRuleEntityQuery as ChildFittingRuleEntityQuery;
use ECP\FittingRuleRow as ChildFittingRuleRow;
use ECP\FittingRuleRowQuery as ChildFittingRuleRowQuery;
use ECP\RulesetFilterRule as ChildRulesetFilterRule;
use ECP\RulesetFilterRuleQuery as ChildRulesetFilterRuleQuery;
use ECP\User as ChildUser;
use ECP\UserQuery as ChildUserQuery;
use ECP\Map\FittingRuleEntityTableMap;
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
 * Base class that represents a row from the 'fittingruleentity' table.
 *
 * 
 *
* @package    propel.generator.ECP.Base
*/
abstract class FittingRuleEntity implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\ECP\\Map\\FittingRuleEntityTableMap';


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
     * The value for the lastmodified field.
     * @var        \DateTime
     */
    protected $lastmodified;

    /**
     * @var        ChildUser
     */
    protected $aUser;

    /**
     * @var        ChildFittingRuleEntity
     */
    protected $aFittingRuleEntityRelatedByForkedid;

    /**
     * @var        ObjectCollection|ChildFittingRuleEntity[] Collection to store aggregation of ChildFittingRuleEntity objects.
     */
    protected $collFittingRuleEntitiesRelatedById;
    protected $collFittingRuleEntitiesRelatedByIdPartial;

    /**
     * @var        ObjectCollection|ChildFittingRuleRow[] Collection to store aggregation of ChildFittingRuleRow objects.
     */
    protected $collFittingRuleRows;
    protected $collFittingRuleRowsPartial;

    /**
     * @var        ObjectCollection|ChildRulesetFilterRule[] Collection to store aggregation of ChildRulesetFilterRule objects.
     */
    protected $collRulesetFilterRules;
    protected $collRulesetFilterRulesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFittingRuleEntity[]
     */
    protected $fittingRuleEntitiesRelatedByIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFittingRuleRow[]
     */
    protected $fittingRuleRowsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRulesetFilterRule[]
     */
    protected $rulesetFilterRulesScheduledForDeletion = null;

    /**
     * Initializes internal state of ECP\Base\FittingRuleEntity object.
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
     * Compares this with another <code>FittingRuleEntity</code> instance.  If
     * <code>obj</code> is an instance of <code>FittingRuleEntity</code>, delegates to
     * <code>equals(FittingRuleEntity)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|FittingRuleEntity The current object, for fluid interface
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
     * @return $this|\ECP\FittingRuleEntity The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[FittingRuleEntityTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     * 
     * @param string $v new value
     * @return $this|\ECP\FittingRuleEntity The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[FittingRuleEntityTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [userid] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\FittingRuleEntity The current object (for fluent API support)
     */
    public function setUserid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->userid !== $v) {
            $this->userid = $v;
            $this->modifiedColumns[FittingRuleEntityTableMap::COL_USERID] = true;
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
     * @return $this|\ECP\FittingRuleEntity The current object (for fluent API support)
     */
    public function setIslisted($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->islisted !== $v) {
            $this->islisted = $v;
            $this->modifiedColumns[FittingRuleEntityTableMap::COL_ISLISTED] = true;
        }

        return $this;
    } // setIslisted()

    /**
     * Set the value of [forkedid] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\FittingRuleEntity The current object (for fluent API support)
     */
    public function setForkedid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->forkedid !== $v) {
            $this->forkedid = $v;
            $this->modifiedColumns[FittingRuleEntityTableMap::COL_FORKEDID] = true;
        }

        if ($this->aFittingRuleEntityRelatedByForkedid !== null && $this->aFittingRuleEntityRelatedByForkedid->getId() !== $v) {
            $this->aFittingRuleEntityRelatedByForkedid = null;
        }

        return $this;
    } // setForkedid()

    /**
     * Sets the value of [lastmodified] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\ECP\FittingRuleEntity The current object (for fluent API support)
     */
    public function setLastmodified($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->lastmodified !== null || $dt !== null) {
            if ($this->lastmodified === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->lastmodified->format("Y-m-d H:i:s")) {
                $this->lastmodified = $dt === null ? null : clone $dt;
                $this->modifiedColumns[FittingRuleEntityTableMap::COL_LASTMODIFIED] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : FittingRuleEntityTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : FittingRuleEntityTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : FittingRuleEntityTableMap::translateFieldName('Userid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->userid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : FittingRuleEntityTableMap::translateFieldName('Islisted', TableMap::TYPE_PHPNAME, $indexType)];
            $this->islisted = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : FittingRuleEntityTableMap::translateFieldName('Forkedid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->forkedid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : FittingRuleEntityTableMap::translateFieldName('Lastmodified', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->lastmodified = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = FittingRuleEntityTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ECP\\FittingRuleEntity'), 0, $e);
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
        if ($this->aFittingRuleEntityRelatedByForkedid !== null && $this->forkedid !== $this->aFittingRuleEntityRelatedByForkedid->getId()) {
            $this->aFittingRuleEntityRelatedByForkedid = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(FittingRuleEntityTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildFittingRuleEntityQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUser = null;
            $this->aFittingRuleEntityRelatedByForkedid = null;
            $this->collFittingRuleEntitiesRelatedById = null;

            $this->collFittingRuleRows = null;

            $this->collRulesetFilterRules = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see FittingRuleEntity::setDeleted()
     * @see FittingRuleEntity::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(FittingRuleEntityTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildFittingRuleEntityQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(FittingRuleEntityTableMap::DATABASE_NAME);
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
                FittingRuleEntityTableMap::addInstanceToPool($this);
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

            if ($this->aFittingRuleEntityRelatedByForkedid !== null) {
                if ($this->aFittingRuleEntityRelatedByForkedid->isModified() || $this->aFittingRuleEntityRelatedByForkedid->isNew()) {
                    $affectedRows += $this->aFittingRuleEntityRelatedByForkedid->save($con);
                }
                $this->setFittingRuleEntityRelatedByForkedid($this->aFittingRuleEntityRelatedByForkedid);
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

            if ($this->fittingRuleEntitiesRelatedByIdScheduledForDeletion !== null) {
                if (!$this->fittingRuleEntitiesRelatedByIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->fittingRuleEntitiesRelatedByIdScheduledForDeletion as $fittingRuleEntityRelatedById) {
                        // need to save related object because we set the relation to null
                        $fittingRuleEntityRelatedById->save($con);
                    }
                    $this->fittingRuleEntitiesRelatedByIdScheduledForDeletion = null;
                }
            }

            if ($this->collFittingRuleEntitiesRelatedById !== null) {
                foreach ($this->collFittingRuleEntitiesRelatedById as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->fittingRuleRowsScheduledForDeletion !== null) {
                if (!$this->fittingRuleRowsScheduledForDeletion->isEmpty()) {
                    \ECP\FittingRuleRowQuery::create()
                        ->filterByPrimaryKeys($this->fittingRuleRowsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->fittingRuleRowsScheduledForDeletion = null;
                }
            }

            if ($this->collFittingRuleRows !== null) {
                foreach ($this->collFittingRuleRows as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rulesetFilterRulesScheduledForDeletion !== null) {
                if (!$this->rulesetFilterRulesScheduledForDeletion->isEmpty()) {
                    \ECP\RulesetFilterRuleQuery::create()
                        ->filterByPrimaryKeys($this->rulesetFilterRulesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rulesetFilterRulesScheduledForDeletion = null;
                }
            }

            if ($this->collRulesetFilterRules !== null) {
                foreach ($this->collRulesetFilterRules as $referrerFK) {
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

        $this->modifiedColumns[FittingRuleEntityTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FittingRuleEntityTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FittingRuleEntityTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(FittingRuleEntityTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(FittingRuleEntityTableMap::COL_USERID)) {
            $modifiedColumns[':p' . $index++]  = 'userId';
        }
        if ($this->isColumnModified(FittingRuleEntityTableMap::COL_ISLISTED)) {
            $modifiedColumns[':p' . $index++]  = 'isListed';
        }
        if ($this->isColumnModified(FittingRuleEntityTableMap::COL_FORKEDID)) {
            $modifiedColumns[':p' . $index++]  = 'forkedId';
        }
        if ($this->isColumnModified(FittingRuleEntityTableMap::COL_LASTMODIFIED)) {
            $modifiedColumns[':p' . $index++]  = 'lastModified';
        }

        $sql = sprintf(
            'INSERT INTO fittingruleentity (%s) VALUES (%s)',
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
        $pos = FittingRuleEntityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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

        if (isset($alreadyDumpedObjects['FittingRuleEntity'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['FittingRuleEntity'][$this->hashCode()] = true;
        $keys = FittingRuleEntityTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getUserid(),
            $keys[3] => $this->getIslisted(),
            $keys[4] => $this->getForkedid(),
            $keys[5] => $this->getLastmodified(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[5]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[5]];
            $result[$keys[5]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
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
            if (null !== $this->aFittingRuleEntityRelatedByForkedid) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'fittingRuleEntity';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fittingruleentity';
                        break;
                    default:
                        $key = 'FittingRuleEntity';
                }
        
                $result[$key] = $this->aFittingRuleEntityRelatedByForkedid->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collFittingRuleEntitiesRelatedById) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'fittingRuleEntities';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fittingruleentities';
                        break;
                    default:
                        $key = 'FittingRuleEntities';
                }
        
                $result[$key] = $this->collFittingRuleEntitiesRelatedById->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFittingRuleRows) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'fittingRuleRows';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fittingrulerows';
                        break;
                    default:
                        $key = 'FittingRuleRows';
                }
        
                $result[$key] = $this->collFittingRuleRows->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRulesetFilterRules) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rulesetFilterRules';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'rulesetfilterrules';
                        break;
                    default:
                        $key = 'RulesetFilterRules';
                }
        
                $result[$key] = $this->collRulesetFilterRules->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\ECP\FittingRuleEntity
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = FittingRuleEntityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ECP\FittingRuleEntity
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
        $keys = FittingRuleEntityTableMap::getFieldNames($keyType);

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
            $this->setLastmodified($arr[$keys[5]]);
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
     * @return $this|\ECP\FittingRuleEntity The current object, for fluid interface
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
        $criteria = new Criteria(FittingRuleEntityTableMap::DATABASE_NAME);

        if ($this->isColumnModified(FittingRuleEntityTableMap::COL_ID)) {
            $criteria->add(FittingRuleEntityTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(FittingRuleEntityTableMap::COL_NAME)) {
            $criteria->add(FittingRuleEntityTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(FittingRuleEntityTableMap::COL_USERID)) {
            $criteria->add(FittingRuleEntityTableMap::COL_USERID, $this->userid);
        }
        if ($this->isColumnModified(FittingRuleEntityTableMap::COL_ISLISTED)) {
            $criteria->add(FittingRuleEntityTableMap::COL_ISLISTED, $this->islisted);
        }
        if ($this->isColumnModified(FittingRuleEntityTableMap::COL_FORKEDID)) {
            $criteria->add(FittingRuleEntityTableMap::COL_FORKEDID, $this->forkedid);
        }
        if ($this->isColumnModified(FittingRuleEntityTableMap::COL_LASTMODIFIED)) {
            $criteria->add(FittingRuleEntityTableMap::COL_LASTMODIFIED, $this->lastmodified);
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
        $criteria = ChildFittingRuleEntityQuery::create();
        $criteria->add(FittingRuleEntityTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \ECP\FittingRuleEntity (or compatible) type.
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
        $copyObj->setLastmodified($this->getLastmodified());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getFittingRuleEntitiesRelatedById() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFittingRuleEntityRelatedById($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFittingRuleRows() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFittingRuleRow($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRulesetFilterRules() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRulesetFilterRule($relObj->copy($deepCopy));
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
     * @return \ECP\FittingRuleEntity Clone of current object.
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
     * @return $this|\ECP\FittingRuleEntity The current object (for fluent API support)
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
            $v->addFittingRuleEntity($this);
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
                $this->aUser->addFittingRuleEntities($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a ChildFittingRuleEntity object.
     *
     * @param  ChildFittingRuleEntity $v
     * @return $this|\ECP\FittingRuleEntity The current object (for fluent API support)
     * @throws PropelException
     */
    public function setFittingRuleEntityRelatedByForkedid(ChildFittingRuleEntity $v = null)
    {
        if ($v === null) {
            $this->setForkedid(NULL);
        } else {
            $this->setForkedid($v->getId());
        }

        $this->aFittingRuleEntityRelatedByForkedid = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildFittingRuleEntity object, it will not be re-added.
        if ($v !== null) {
            $v->addFittingRuleEntityRelatedById($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildFittingRuleEntity object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildFittingRuleEntity The associated ChildFittingRuleEntity object.
     * @throws PropelException
     */
    public function getFittingRuleEntityRelatedByForkedid(ConnectionInterface $con = null)
    {
        if ($this->aFittingRuleEntityRelatedByForkedid === null && ($this->forkedid !== null)) {
            $this->aFittingRuleEntityRelatedByForkedid = ChildFittingRuleEntityQuery::create()->findPk($this->forkedid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFittingRuleEntityRelatedByForkedid->addFittingRuleEntitiesRelatedById($this);
             */
        }

        return $this->aFittingRuleEntityRelatedByForkedid;
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
        if ('FittingRuleEntityRelatedById' == $relationName) {
            return $this->initFittingRuleEntitiesRelatedById();
        }
        if ('FittingRuleRow' == $relationName) {
            return $this->initFittingRuleRows();
        }
        if ('RulesetFilterRule' == $relationName) {
            return $this->initRulesetFilterRules();
        }
    }

    /**
     * Clears out the collFittingRuleEntitiesRelatedById collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFittingRuleEntitiesRelatedById()
     */
    public function clearFittingRuleEntitiesRelatedById()
    {
        $this->collFittingRuleEntitiesRelatedById = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFittingRuleEntitiesRelatedById collection loaded partially.
     */
    public function resetPartialFittingRuleEntitiesRelatedById($v = true)
    {
        $this->collFittingRuleEntitiesRelatedByIdPartial = $v;
    }

    /**
     * Initializes the collFittingRuleEntitiesRelatedById collection.
     *
     * By default this just sets the collFittingRuleEntitiesRelatedById collection to an empty array (like clearcollFittingRuleEntitiesRelatedById());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFittingRuleEntitiesRelatedById($overrideExisting = true)
    {
        if (null !== $this->collFittingRuleEntitiesRelatedById && !$overrideExisting) {
            return;
        }
        $this->collFittingRuleEntitiesRelatedById = new ObjectCollection();
        $this->collFittingRuleEntitiesRelatedById->setModel('\ECP\FittingRuleEntity');
    }

    /**
     * Gets an array of ChildFittingRuleEntity objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildFittingRuleEntity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFittingRuleEntity[] List of ChildFittingRuleEntity objects
     * @throws PropelException
     */
    public function getFittingRuleEntitiesRelatedById(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFittingRuleEntitiesRelatedByIdPartial && !$this->isNew();
        if (null === $this->collFittingRuleEntitiesRelatedById || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFittingRuleEntitiesRelatedById) {
                // return empty collection
                $this->initFittingRuleEntitiesRelatedById();
            } else {
                $collFittingRuleEntitiesRelatedById = ChildFittingRuleEntityQuery::create(null, $criteria)
                    ->filterByFittingRuleEntityRelatedByForkedid($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFittingRuleEntitiesRelatedByIdPartial && count($collFittingRuleEntitiesRelatedById)) {
                        $this->initFittingRuleEntitiesRelatedById(false);

                        foreach ($collFittingRuleEntitiesRelatedById as $obj) {
                            if (false == $this->collFittingRuleEntitiesRelatedById->contains($obj)) {
                                $this->collFittingRuleEntitiesRelatedById->append($obj);
                            }
                        }

                        $this->collFittingRuleEntitiesRelatedByIdPartial = true;
                    }

                    return $collFittingRuleEntitiesRelatedById;
                }

                if ($partial && $this->collFittingRuleEntitiesRelatedById) {
                    foreach ($this->collFittingRuleEntitiesRelatedById as $obj) {
                        if ($obj->isNew()) {
                            $collFittingRuleEntitiesRelatedById[] = $obj;
                        }
                    }
                }

                $this->collFittingRuleEntitiesRelatedById = $collFittingRuleEntitiesRelatedById;
                $this->collFittingRuleEntitiesRelatedByIdPartial = false;
            }
        }

        return $this->collFittingRuleEntitiesRelatedById;
    }

    /**
     * Sets a collection of ChildFittingRuleEntity objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $fittingRuleEntitiesRelatedById A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildFittingRuleEntity The current object (for fluent API support)
     */
    public function setFittingRuleEntitiesRelatedById(Collection $fittingRuleEntitiesRelatedById, ConnectionInterface $con = null)
    {
        /** @var ChildFittingRuleEntity[] $fittingRuleEntitiesRelatedByIdToDelete */
        $fittingRuleEntitiesRelatedByIdToDelete = $this->getFittingRuleEntitiesRelatedById(new Criteria(), $con)->diff($fittingRuleEntitiesRelatedById);

        
        $this->fittingRuleEntitiesRelatedByIdScheduledForDeletion = $fittingRuleEntitiesRelatedByIdToDelete;

        foreach ($fittingRuleEntitiesRelatedByIdToDelete as $fittingRuleEntityRelatedByIdRemoved) {
            $fittingRuleEntityRelatedByIdRemoved->setFittingRuleEntityRelatedByForkedid(null);
        }

        $this->collFittingRuleEntitiesRelatedById = null;
        foreach ($fittingRuleEntitiesRelatedById as $fittingRuleEntityRelatedById) {
            $this->addFittingRuleEntityRelatedById($fittingRuleEntityRelatedById);
        }

        $this->collFittingRuleEntitiesRelatedById = $fittingRuleEntitiesRelatedById;
        $this->collFittingRuleEntitiesRelatedByIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FittingRuleEntity objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related FittingRuleEntity objects.
     * @throws PropelException
     */
    public function countFittingRuleEntitiesRelatedById(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFittingRuleEntitiesRelatedByIdPartial && !$this->isNew();
        if (null === $this->collFittingRuleEntitiesRelatedById || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFittingRuleEntitiesRelatedById) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFittingRuleEntitiesRelatedById());
            }

            $query = ChildFittingRuleEntityQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFittingRuleEntityRelatedByForkedid($this)
                ->count($con);
        }

        return count($this->collFittingRuleEntitiesRelatedById);
    }

    /**
     * Method called to associate a ChildFittingRuleEntity object to this object
     * through the ChildFittingRuleEntity foreign key attribute.
     *
     * @param  ChildFittingRuleEntity $l ChildFittingRuleEntity
     * @return $this|\ECP\FittingRuleEntity The current object (for fluent API support)
     */
    public function addFittingRuleEntityRelatedById(ChildFittingRuleEntity $l)
    {
        if ($this->collFittingRuleEntitiesRelatedById === null) {
            $this->initFittingRuleEntitiesRelatedById();
            $this->collFittingRuleEntitiesRelatedByIdPartial = true;
        }

        if (!$this->collFittingRuleEntitiesRelatedById->contains($l)) {
            $this->doAddFittingRuleEntityRelatedById($l);
        }

        return $this;
    }

    /**
     * @param ChildFittingRuleEntity $fittingRuleEntityRelatedById The ChildFittingRuleEntity object to add.
     */
    protected function doAddFittingRuleEntityRelatedById(ChildFittingRuleEntity $fittingRuleEntityRelatedById)
    {
        $this->collFittingRuleEntitiesRelatedById[]= $fittingRuleEntityRelatedById;
        $fittingRuleEntityRelatedById->setFittingRuleEntityRelatedByForkedid($this);
    }

    /**
     * @param  ChildFittingRuleEntity $fittingRuleEntityRelatedById The ChildFittingRuleEntity object to remove.
     * @return $this|ChildFittingRuleEntity The current object (for fluent API support)
     */
    public function removeFittingRuleEntityRelatedById(ChildFittingRuleEntity $fittingRuleEntityRelatedById)
    {
        if ($this->getFittingRuleEntitiesRelatedById()->contains($fittingRuleEntityRelatedById)) {
            $pos = $this->collFittingRuleEntitiesRelatedById->search($fittingRuleEntityRelatedById);
            $this->collFittingRuleEntitiesRelatedById->remove($pos);
            if (null === $this->fittingRuleEntitiesRelatedByIdScheduledForDeletion) {
                $this->fittingRuleEntitiesRelatedByIdScheduledForDeletion = clone $this->collFittingRuleEntitiesRelatedById;
                $this->fittingRuleEntitiesRelatedByIdScheduledForDeletion->clear();
            }
            $this->fittingRuleEntitiesRelatedByIdScheduledForDeletion[]= $fittingRuleEntityRelatedById;
            $fittingRuleEntityRelatedById->setFittingRuleEntityRelatedByForkedid(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FittingRuleEntity is new, it will return
     * an empty collection; or if this FittingRuleEntity has previously
     * been saved, it will retrieve related FittingRuleEntitiesRelatedById from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FittingRuleEntity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFittingRuleEntity[] List of ChildFittingRuleEntity objects
     */
    public function getFittingRuleEntitiesRelatedByIdJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFittingRuleEntityQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getFittingRuleEntitiesRelatedById($query, $con);
    }

    /**
     * Clears out the collFittingRuleRows collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFittingRuleRows()
     */
    public function clearFittingRuleRows()
    {
        $this->collFittingRuleRows = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFittingRuleRows collection loaded partially.
     */
    public function resetPartialFittingRuleRows($v = true)
    {
        $this->collFittingRuleRowsPartial = $v;
    }

    /**
     * Initializes the collFittingRuleRows collection.
     *
     * By default this just sets the collFittingRuleRows collection to an empty array (like clearcollFittingRuleRows());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFittingRuleRows($overrideExisting = true)
    {
        if (null !== $this->collFittingRuleRows && !$overrideExisting) {
            return;
        }
        $this->collFittingRuleRows = new ObjectCollection();
        $this->collFittingRuleRows->setModel('\ECP\FittingRuleRow');
    }

    /**
     * Gets an array of ChildFittingRuleRow objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildFittingRuleEntity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFittingRuleRow[] List of ChildFittingRuleRow objects
     * @throws PropelException
     */
    public function getFittingRuleRows(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFittingRuleRowsPartial && !$this->isNew();
        if (null === $this->collFittingRuleRows || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFittingRuleRows) {
                // return empty collection
                $this->initFittingRuleRows();
            } else {
                $collFittingRuleRows = ChildFittingRuleRowQuery::create(null, $criteria)
                    ->filterByFittingRuleEntity($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFittingRuleRowsPartial && count($collFittingRuleRows)) {
                        $this->initFittingRuleRows(false);

                        foreach ($collFittingRuleRows as $obj) {
                            if (false == $this->collFittingRuleRows->contains($obj)) {
                                $this->collFittingRuleRows->append($obj);
                            }
                        }

                        $this->collFittingRuleRowsPartial = true;
                    }

                    return $collFittingRuleRows;
                }

                if ($partial && $this->collFittingRuleRows) {
                    foreach ($this->collFittingRuleRows as $obj) {
                        if ($obj->isNew()) {
                            $collFittingRuleRows[] = $obj;
                        }
                    }
                }

                $this->collFittingRuleRows = $collFittingRuleRows;
                $this->collFittingRuleRowsPartial = false;
            }
        }

        return $this->collFittingRuleRows;
    }

    /**
     * Sets a collection of ChildFittingRuleRow objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $fittingRuleRows A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildFittingRuleEntity The current object (for fluent API support)
     */
    public function setFittingRuleRows(Collection $fittingRuleRows, ConnectionInterface $con = null)
    {
        /** @var ChildFittingRuleRow[] $fittingRuleRowsToDelete */
        $fittingRuleRowsToDelete = $this->getFittingRuleRows(new Criteria(), $con)->diff($fittingRuleRows);

        
        $this->fittingRuleRowsScheduledForDeletion = $fittingRuleRowsToDelete;

        foreach ($fittingRuleRowsToDelete as $fittingRuleRowRemoved) {
            $fittingRuleRowRemoved->setFittingRuleEntity(null);
        }

        $this->collFittingRuleRows = null;
        foreach ($fittingRuleRows as $fittingRuleRow) {
            $this->addFittingRuleRow($fittingRuleRow);
        }

        $this->collFittingRuleRows = $fittingRuleRows;
        $this->collFittingRuleRowsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FittingRuleRow objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related FittingRuleRow objects.
     * @throws PropelException
     */
    public function countFittingRuleRows(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFittingRuleRowsPartial && !$this->isNew();
        if (null === $this->collFittingRuleRows || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFittingRuleRows) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFittingRuleRows());
            }

            $query = ChildFittingRuleRowQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFittingRuleEntity($this)
                ->count($con);
        }

        return count($this->collFittingRuleRows);
    }

    /**
     * Method called to associate a ChildFittingRuleRow object to this object
     * through the ChildFittingRuleRow foreign key attribute.
     *
     * @param  ChildFittingRuleRow $l ChildFittingRuleRow
     * @return $this|\ECP\FittingRuleEntity The current object (for fluent API support)
     */
    public function addFittingRuleRow(ChildFittingRuleRow $l)
    {
        if ($this->collFittingRuleRows === null) {
            $this->initFittingRuleRows();
            $this->collFittingRuleRowsPartial = true;
        }

        if (!$this->collFittingRuleRows->contains($l)) {
            $this->doAddFittingRuleRow($l);
        }

        return $this;
    }

    /**
     * @param ChildFittingRuleRow $fittingRuleRow The ChildFittingRuleRow object to add.
     */
    protected function doAddFittingRuleRow(ChildFittingRuleRow $fittingRuleRow)
    {
        $this->collFittingRuleRows[]= $fittingRuleRow;
        $fittingRuleRow->setFittingRuleEntity($this);
    }

    /**
     * @param  ChildFittingRuleRow $fittingRuleRow The ChildFittingRuleRow object to remove.
     * @return $this|ChildFittingRuleEntity The current object (for fluent API support)
     */
    public function removeFittingRuleRow(ChildFittingRuleRow $fittingRuleRow)
    {
        if ($this->getFittingRuleRows()->contains($fittingRuleRow)) {
            $pos = $this->collFittingRuleRows->search($fittingRuleRow);
            $this->collFittingRuleRows->remove($pos);
            if (null === $this->fittingRuleRowsScheduledForDeletion) {
                $this->fittingRuleRowsScheduledForDeletion = clone $this->collFittingRuleRows;
                $this->fittingRuleRowsScheduledForDeletion->clear();
            }
            $this->fittingRuleRowsScheduledForDeletion[]= clone $fittingRuleRow;
            $fittingRuleRow->setFittingRuleEntity(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FittingRuleEntity is new, it will return
     * an empty collection; or if this FittingRuleEntity has previously
     * been saved, it will retrieve related FittingRuleRows from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FittingRuleEntity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFittingRuleRow[] List of ChildFittingRuleRow objects
     */
    public function getFittingRuleRowsJoinconcatenationObj(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFittingRuleRowQuery::create(null, $criteria);
        $query->joinWith('concatenationObj', $joinBehavior);

        return $this->getFittingRuleRows($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FittingRuleEntity is new, it will return
     * an empty collection; or if this FittingRuleEntity has previously
     * been saved, it will retrieve related FittingRuleRows from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FittingRuleEntity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFittingRuleRow[] List of ChildFittingRuleRow objects
     */
    public function getFittingRuleRowsJoincomparisonObj(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFittingRuleRowQuery::create(null, $criteria);
        $query->joinWith('comparisonObj', $joinBehavior);

        return $this->getFittingRuleRows($query, $con);
    }

    /**
     * Clears out the collRulesetFilterRules collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRulesetFilterRules()
     */
    public function clearRulesetFilterRules()
    {
        $this->collRulesetFilterRules = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRulesetFilterRules collection loaded partially.
     */
    public function resetPartialRulesetFilterRules($v = true)
    {
        $this->collRulesetFilterRulesPartial = $v;
    }

    /**
     * Initializes the collRulesetFilterRules collection.
     *
     * By default this just sets the collRulesetFilterRules collection to an empty array (like clearcollRulesetFilterRules());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRulesetFilterRules($overrideExisting = true)
    {
        if (null !== $this->collRulesetFilterRules && !$overrideExisting) {
            return;
        }
        $this->collRulesetFilterRules = new ObjectCollection();
        $this->collRulesetFilterRules->setModel('\ECP\RulesetFilterRule');
    }

    /**
     * Gets an array of ChildRulesetFilterRule objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildFittingRuleEntity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRulesetFilterRule[] List of ChildRulesetFilterRule objects
     * @throws PropelException
     */
    public function getRulesetFilterRules(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRulesetFilterRulesPartial && !$this->isNew();
        if (null === $this->collRulesetFilterRules || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRulesetFilterRules) {
                // return empty collection
                $this->initRulesetFilterRules();
            } else {
                $collRulesetFilterRules = ChildRulesetFilterRuleQuery::create(null, $criteria)
                    ->filterByFittingRuleEntity($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRulesetFilterRulesPartial && count($collRulesetFilterRules)) {
                        $this->initRulesetFilterRules(false);

                        foreach ($collRulesetFilterRules as $obj) {
                            if (false == $this->collRulesetFilterRules->contains($obj)) {
                                $this->collRulesetFilterRules->append($obj);
                            }
                        }

                        $this->collRulesetFilterRulesPartial = true;
                    }

                    return $collRulesetFilterRules;
                }

                if ($partial && $this->collRulesetFilterRules) {
                    foreach ($this->collRulesetFilterRules as $obj) {
                        if ($obj->isNew()) {
                            $collRulesetFilterRules[] = $obj;
                        }
                    }
                }

                $this->collRulesetFilterRules = $collRulesetFilterRules;
                $this->collRulesetFilterRulesPartial = false;
            }
        }

        return $this->collRulesetFilterRules;
    }

    /**
     * Sets a collection of ChildRulesetFilterRule objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rulesetFilterRules A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildFittingRuleEntity The current object (for fluent API support)
     */
    public function setRulesetFilterRules(Collection $rulesetFilterRules, ConnectionInterface $con = null)
    {
        /** @var ChildRulesetFilterRule[] $rulesetFilterRulesToDelete */
        $rulesetFilterRulesToDelete = $this->getRulesetFilterRules(new Criteria(), $con)->diff($rulesetFilterRules);

        
        $this->rulesetFilterRulesScheduledForDeletion = $rulesetFilterRulesToDelete;

        foreach ($rulesetFilterRulesToDelete as $rulesetFilterRuleRemoved) {
            $rulesetFilterRuleRemoved->setFittingRuleEntity(null);
        }

        $this->collRulesetFilterRules = null;
        foreach ($rulesetFilterRules as $rulesetFilterRule) {
            $this->addRulesetFilterRule($rulesetFilterRule);
        }

        $this->collRulesetFilterRules = $rulesetFilterRules;
        $this->collRulesetFilterRulesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RulesetFilterRule objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RulesetFilterRule objects.
     * @throws PropelException
     */
    public function countRulesetFilterRules(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRulesetFilterRulesPartial && !$this->isNew();
        if (null === $this->collRulesetFilterRules || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRulesetFilterRules) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRulesetFilterRules());
            }

            $query = ChildRulesetFilterRuleQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFittingRuleEntity($this)
                ->count($con);
        }

        return count($this->collRulesetFilterRules);
    }

    /**
     * Method called to associate a ChildRulesetFilterRule object to this object
     * through the ChildRulesetFilterRule foreign key attribute.
     *
     * @param  ChildRulesetFilterRule $l ChildRulesetFilterRule
     * @return $this|\ECP\FittingRuleEntity The current object (for fluent API support)
     */
    public function addRulesetFilterRule(ChildRulesetFilterRule $l)
    {
        if ($this->collRulesetFilterRules === null) {
            $this->initRulesetFilterRules();
            $this->collRulesetFilterRulesPartial = true;
        }

        if (!$this->collRulesetFilterRules->contains($l)) {
            $this->doAddRulesetFilterRule($l);
        }

        return $this;
    }

    /**
     * @param ChildRulesetFilterRule $rulesetFilterRule The ChildRulesetFilterRule object to add.
     */
    protected function doAddRulesetFilterRule(ChildRulesetFilterRule $rulesetFilterRule)
    {
        $this->collRulesetFilterRules[]= $rulesetFilterRule;
        $rulesetFilterRule->setFittingRuleEntity($this);
    }

    /**
     * @param  ChildRulesetFilterRule $rulesetFilterRule The ChildRulesetFilterRule object to remove.
     * @return $this|ChildFittingRuleEntity The current object (for fluent API support)
     */
    public function removeRulesetFilterRule(ChildRulesetFilterRule $rulesetFilterRule)
    {
        if ($this->getRulesetFilterRules()->contains($rulesetFilterRule)) {
            $pos = $this->collRulesetFilterRules->search($rulesetFilterRule);
            $this->collRulesetFilterRules->remove($pos);
            if (null === $this->rulesetFilterRulesScheduledForDeletion) {
                $this->rulesetFilterRulesScheduledForDeletion = clone $this->collRulesetFilterRules;
                $this->rulesetFilterRulesScheduledForDeletion->clear();
            }
            $this->rulesetFilterRulesScheduledForDeletion[]= clone $rulesetFilterRule;
            $rulesetFilterRule->setFittingRuleEntity(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FittingRuleEntity is new, it will return
     * an empty collection; or if this FittingRuleEntity has previously
     * been saved, it will retrieve related RulesetFilterRules from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FittingRuleEntity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRulesetFilterRule[] List of ChildRulesetFilterRule objects
     */
    public function getRulesetFilterRulesJoinRulesetRuleRow(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRulesetFilterRuleQuery::create(null, $criteria);
        $query->joinWith('RulesetRuleRow', $joinBehavior);

        return $this->getRulesetFilterRules($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FittingRuleEntity is new, it will return
     * an empty collection; or if this FittingRuleEntity has previously
     * been saved, it will retrieve related RulesetFilterRules from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FittingRuleEntity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRulesetFilterRule[] List of ChildRulesetFilterRule objects
     */
    public function getRulesetFilterRulesJoinconcatenationObj(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRulesetFilterRuleQuery::create(null, $criteria);
        $query->joinWith('concatenationObj', $joinBehavior);

        return $this->getRulesetFilterRules($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FittingRuleEntity is new, it will return
     * an empty collection; or if this FittingRuleEntity has previously
     * been saved, it will retrieve related RulesetFilterRules from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FittingRuleEntity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRulesetFilterRule[] List of ChildRulesetFilterRule objects
     */
    public function getRulesetFilterRulesJoincomparisonObj(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRulesetFilterRuleQuery::create(null, $criteria);
        $query->joinWith('comparisonObj', $joinBehavior);

        return $this->getRulesetFilterRules($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUser) {
            $this->aUser->removeFittingRuleEntity($this);
        }
        if (null !== $this->aFittingRuleEntityRelatedByForkedid) {
            $this->aFittingRuleEntityRelatedByForkedid->removeFittingRuleEntityRelatedById($this);
        }
        $this->id = null;
        $this->name = null;
        $this->userid = null;
        $this->islisted = null;
        $this->forkedid = null;
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
            if ($this->collFittingRuleEntitiesRelatedById) {
                foreach ($this->collFittingRuleEntitiesRelatedById as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFittingRuleRows) {
                foreach ($this->collFittingRuleRows as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRulesetFilterRules) {
                foreach ($this->collRulesetFilterRules as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collFittingRuleEntitiesRelatedById = null;
        $this->collFittingRuleRows = null;
        $this->collRulesetFilterRules = null;
        $this->aUser = null;
        $this->aFittingRuleEntityRelatedByForkedid = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FittingRuleEntityTableMap::DEFAULT_STRING_FORMAT);
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
