<?php

namespace ECP\Base;

use \DateTime;
use \Exception;
use \PDO;
use ECP\CompositionEntity as ChildCompositionEntity;
use ECP\CompositionEntityQuery as ChildCompositionEntityQuery;
use ECP\FittingRuleEntity as ChildFittingRuleEntity;
use ECP\FittingRuleEntityQuery as ChildFittingRuleEntityQuery;
use ECP\RulesetEntity as ChildRulesetEntity;
use ECP\RulesetEntityQuery as ChildRulesetEntityQuery;
use ECP\User as ChildUser;
use ECP\UserQuery as ChildUserQuery;
use ECP\Map\UserTableMap;
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
 * Base class that represents a row from the 'user' table.
 *
 * 
 *
* @package    propel.generator.ECP.Base
*/
abstract class User implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\ECP\\Map\\UserTableMap';


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
     * The value for the username field.
     * @var        string
     */
    protected $username;

    /**
     * The value for the password field.
     * @var        string
     */
    protected $password;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the created field.
     * @var        \DateTime
     */
    protected $created;

    /**
     * The value for the confirmation_code field.
     * @var        string
     */
    protected $confirmation_code;

    /**
     * The value for the recover_password_code field.
     * @var        string
     */
    protected $recover_password_code;

    /**
     * @var        ObjectCollection|ChildFittingRuleEntity[] Collection to store aggregation of ChildFittingRuleEntity objects.
     */
    protected $collFittingRuleEntities;
    protected $collFittingRuleEntitiesPartial;

    /**
     * @var        ObjectCollection|ChildRulesetEntity[] Collection to store aggregation of ChildRulesetEntity objects.
     */
    protected $collRulesetEntities;
    protected $collRulesetEntitiesPartial;

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
     * @var ObjectCollection|ChildFittingRuleEntity[]
     */
    protected $fittingRuleEntitiesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRulesetEntity[]
     */
    protected $rulesetEntitiesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCompositionEntity[]
     */
    protected $compositionEntitiesScheduledForDeletion = null;

    /**
     * Initializes internal state of ECP\Base\User object.
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
     * Compares this with another <code>User</code> instance.  If
     * <code>obj</code> is an instance of <code>User</code>, delegates to
     * <code>equals(User)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|User The current object, for fluid interface
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
     * Get the [username] column value.
     * 
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [password] column value.
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [email] column value.
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [optionally formatted] temporal [created] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreated($format = NULL)
    {
        if ($format === null) {
            return $this->created;
        } else {
            return $this->created instanceof \DateTime ? $this->created->format($format) : null;
        }
    }

    /**
     * Get the [confirmation_code] column value.
     * 
     * @return string
     */
    public function getConfirmationCode()
    {
        return $this->confirmation_code;
    }

    /**
     * Get the [recover_password_code] column value.
     * 
     * @return string
     */
    public function getRecoverPasswordCode()
    {
        return $this->recover_password_code;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\User The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UserTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [username] column.
     * 
     * @param string $v new value
     * @return $this|\ECP\User The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[UserTableMap::COL_USERNAME] = true;
        }

        return $this;
    } // setUsername()

    /**
     * Set the value of [password] column.
     * 
     * @param string $v new value
     * @return $this|\ECP\User The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[UserTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

    /**
     * Set the value of [email] column.
     * 
     * @param string $v new value
     * @return $this|\ECP\User The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UserTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Sets the value of [created] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\ECP\User The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created !== null || $dt !== null) {
            if ($this->created === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created->format("Y-m-d H:i:s")) {
                $this->created = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_CREATED] = true;
            }
        } // if either are not null

        return $this;
    } // setCreated()

    /**
     * Set the value of [confirmation_code] column.
     * 
     * @param string $v new value
     * @return $this|\ECP\User The current object (for fluent API support)
     */
    public function setConfirmationCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->confirmation_code !== $v) {
            $this->confirmation_code = $v;
            $this->modifiedColumns[UserTableMap::COL_CONFIRMATION_CODE] = true;
        }

        return $this;
    } // setConfirmationCode()

    /**
     * Set the value of [recover_password_code] column.
     * 
     * @param string $v new value
     * @return $this|\ECP\User The current object (for fluent API support)
     */
    public function setRecoverPasswordCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->recover_password_code !== $v) {
            $this->recover_password_code = $v;
            $this->modifiedColumns[UserTableMap::COL_RECOVER_PASSWORD_CODE] = true;
        }

        return $this;
    } // setRecoverPasswordCode()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UserTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UserTableMap::translateFieldName('ConfirmationCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->confirmation_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UserTableMap::translateFieldName('RecoverPasswordCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->recover_password_code = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = UserTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ECP\\User'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collFittingRuleEntities = null;

            $this->collRulesetEntities = null;

            $this->collCompositionEntities = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see User::setDeleted()
     * @see User::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
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
                UserTableMap::addInstanceToPool($this);
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

            if ($this->fittingRuleEntitiesScheduledForDeletion !== null) {
                if (!$this->fittingRuleEntitiesScheduledForDeletion->isEmpty()) {
                    \ECP\FittingRuleEntityQuery::create()
                        ->filterByPrimaryKeys($this->fittingRuleEntitiesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->fittingRuleEntitiesScheduledForDeletion = null;
                }
            }

            if ($this->collFittingRuleEntities !== null) {
                foreach ($this->collFittingRuleEntities as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rulesetEntitiesScheduledForDeletion !== null) {
                if (!$this->rulesetEntitiesScheduledForDeletion->isEmpty()) {
                    \ECP\RulesetEntityQuery::create()
                        ->filterByPrimaryKeys($this->rulesetEntitiesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rulesetEntitiesScheduledForDeletion = null;
                }
            }

            if ($this->collRulesetEntities !== null) {
                foreach ($this->collRulesetEntities as $referrerFK) {
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

        $this->modifiedColumns[UserTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(UserTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'username';
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(UserTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'created';
        }
        if ($this->isColumnModified(UserTableMap::COL_CONFIRMATION_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'confirmation_code';
        }
        if ($this->isColumnModified(UserTableMap::COL_RECOVER_PASSWORD_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'recover_password_code';
        }

        $sql = sprintf(
            'INSERT INTO user (%s) VALUES (%s)',
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
                    case 'username':                        
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case 'password':                        
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case 'email':                        
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'created':                        
                        $stmt->bindValue($identifier, $this->created ? $this->created->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'confirmation_code':                        
                        $stmt->bindValue($identifier, $this->confirmation_code, PDO::PARAM_STR);
                        break;
                    case 'recover_password_code':                        
                        $stmt->bindValue($identifier, $this->recover_password_code, PDO::PARAM_STR);
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
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getUsername();
                break;
            case 2:
                return $this->getPassword();
                break;
            case 3:
                return $this->getEmail();
                break;
            case 4:
                return $this->getCreated();
                break;
            case 5:
                return $this->getConfirmationCode();
                break;
            case 6:
                return $this->getRecoverPasswordCode();
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

        if (isset($alreadyDumpedObjects['User'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->hashCode()] = true;
        $keys = UserTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUsername(),
            $keys[2] => $this->getPassword(),
            $keys[3] => $this->getEmail(),
            $keys[4] => $this->getCreated(),
            $keys[5] => $this->getConfirmationCode(),
            $keys[6] => $this->getRecoverPasswordCode(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[4]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[4]];
            $result[$keys[4]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->collFittingRuleEntities) {
                
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
        
                $result[$key] = $this->collFittingRuleEntities->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRulesetEntities) {
                
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
        
                $result[$key] = $this->collRulesetEntities->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\ECP\User
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ECP\User
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUsername($value);
                break;
            case 2:
                $this->setPassword($value);
                break;
            case 3:
                $this->setEmail($value);
                break;
            case 4:
                $this->setCreated($value);
                break;
            case 5:
                $this->setConfirmationCode($value);
                break;
            case 6:
                $this->setRecoverPasswordCode($value);
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
        $keys = UserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUsername($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPassword($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEmail($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCreated($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setConfirmationCode($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setRecoverPasswordCode($arr[$keys[6]]);
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
     * @return $this|\ECP\User The current object, for fluid interface
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
        $criteria = new Criteria(UserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $criteria->add(UserTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(UserTableMap::COL_USERNAME)) {
            $criteria->add(UserTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $criteria->add(UserTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL)) {
            $criteria->add(UserTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UserTableMap::COL_CREATED)) {
            $criteria->add(UserTableMap::COL_CREATED, $this->created);
        }
        if ($this->isColumnModified(UserTableMap::COL_CONFIRMATION_CODE)) {
            $criteria->add(UserTableMap::COL_CONFIRMATION_CODE, $this->confirmation_code);
        }
        if ($this->isColumnModified(UserTableMap::COL_RECOVER_PASSWORD_CODE)) {
            $criteria->add(UserTableMap::COL_RECOVER_PASSWORD_CODE, $this->recover_password_code);
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
        $criteria = ChildUserQuery::create();
        $criteria->add(UserTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \ECP\User (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUsername($this->getUsername());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setCreated($this->getCreated());
        $copyObj->setConfirmationCode($this->getConfirmationCode());
        $copyObj->setRecoverPasswordCode($this->getRecoverPasswordCode());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getFittingRuleEntities() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFittingRuleEntity($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRulesetEntities() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRulesetEntity($relObj->copy($deepCopy));
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
     * @return \ECP\User Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('FittingRuleEntity' == $relationName) {
            return $this->initFittingRuleEntities();
        }
        if ('RulesetEntity' == $relationName) {
            return $this->initRulesetEntities();
        }
        if ('CompositionEntity' == $relationName) {
            return $this->initCompositionEntities();
        }
    }

    /**
     * Clears out the collFittingRuleEntities collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFittingRuleEntities()
     */
    public function clearFittingRuleEntities()
    {
        $this->collFittingRuleEntities = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFittingRuleEntities collection loaded partially.
     */
    public function resetPartialFittingRuleEntities($v = true)
    {
        $this->collFittingRuleEntitiesPartial = $v;
    }

    /**
     * Initializes the collFittingRuleEntities collection.
     *
     * By default this just sets the collFittingRuleEntities collection to an empty array (like clearcollFittingRuleEntities());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFittingRuleEntities($overrideExisting = true)
    {
        if (null !== $this->collFittingRuleEntities && !$overrideExisting) {
            return;
        }
        $this->collFittingRuleEntities = new ObjectCollection();
        $this->collFittingRuleEntities->setModel('\ECP\FittingRuleEntity');
    }

    /**
     * Gets an array of ChildFittingRuleEntity objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFittingRuleEntity[] List of ChildFittingRuleEntity objects
     * @throws PropelException
     */
    public function getFittingRuleEntities(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFittingRuleEntitiesPartial && !$this->isNew();
        if (null === $this->collFittingRuleEntities || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFittingRuleEntities) {
                // return empty collection
                $this->initFittingRuleEntities();
            } else {
                $collFittingRuleEntities = ChildFittingRuleEntityQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFittingRuleEntitiesPartial && count($collFittingRuleEntities)) {
                        $this->initFittingRuleEntities(false);

                        foreach ($collFittingRuleEntities as $obj) {
                            if (false == $this->collFittingRuleEntities->contains($obj)) {
                                $this->collFittingRuleEntities->append($obj);
                            }
                        }

                        $this->collFittingRuleEntitiesPartial = true;
                    }

                    return $collFittingRuleEntities;
                }

                if ($partial && $this->collFittingRuleEntities) {
                    foreach ($this->collFittingRuleEntities as $obj) {
                        if ($obj->isNew()) {
                            $collFittingRuleEntities[] = $obj;
                        }
                    }
                }

                $this->collFittingRuleEntities = $collFittingRuleEntities;
                $this->collFittingRuleEntitiesPartial = false;
            }
        }

        return $this->collFittingRuleEntities;
    }

    /**
     * Sets a collection of ChildFittingRuleEntity objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $fittingRuleEntities A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setFittingRuleEntities(Collection $fittingRuleEntities, ConnectionInterface $con = null)
    {
        /** @var ChildFittingRuleEntity[] $fittingRuleEntitiesToDelete */
        $fittingRuleEntitiesToDelete = $this->getFittingRuleEntities(new Criteria(), $con)->diff($fittingRuleEntities);

        
        $this->fittingRuleEntitiesScheduledForDeletion = $fittingRuleEntitiesToDelete;

        foreach ($fittingRuleEntitiesToDelete as $fittingRuleEntityRemoved) {
            $fittingRuleEntityRemoved->setUser(null);
        }

        $this->collFittingRuleEntities = null;
        foreach ($fittingRuleEntities as $fittingRuleEntity) {
            $this->addFittingRuleEntity($fittingRuleEntity);
        }

        $this->collFittingRuleEntities = $fittingRuleEntities;
        $this->collFittingRuleEntitiesPartial = false;

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
    public function countFittingRuleEntities(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFittingRuleEntitiesPartial && !$this->isNew();
        if (null === $this->collFittingRuleEntities || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFittingRuleEntities) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFittingRuleEntities());
            }

            $query = ChildFittingRuleEntityQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collFittingRuleEntities);
    }

    /**
     * Method called to associate a ChildFittingRuleEntity object to this object
     * through the ChildFittingRuleEntity foreign key attribute.
     *
     * @param  ChildFittingRuleEntity $l ChildFittingRuleEntity
     * @return $this|\ECP\User The current object (for fluent API support)
     */
    public function addFittingRuleEntity(ChildFittingRuleEntity $l)
    {
        if ($this->collFittingRuleEntities === null) {
            $this->initFittingRuleEntities();
            $this->collFittingRuleEntitiesPartial = true;
        }

        if (!$this->collFittingRuleEntities->contains($l)) {
            $this->doAddFittingRuleEntity($l);
        }

        return $this;
    }

    /**
     * @param ChildFittingRuleEntity $fittingRuleEntity The ChildFittingRuleEntity object to add.
     */
    protected function doAddFittingRuleEntity(ChildFittingRuleEntity $fittingRuleEntity)
    {
        $this->collFittingRuleEntities[]= $fittingRuleEntity;
        $fittingRuleEntity->setUser($this);
    }

    /**
     * @param  ChildFittingRuleEntity $fittingRuleEntity The ChildFittingRuleEntity object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeFittingRuleEntity(ChildFittingRuleEntity $fittingRuleEntity)
    {
        if ($this->getFittingRuleEntities()->contains($fittingRuleEntity)) {
            $pos = $this->collFittingRuleEntities->search($fittingRuleEntity);
            $this->collFittingRuleEntities->remove($pos);
            if (null === $this->fittingRuleEntitiesScheduledForDeletion) {
                $this->fittingRuleEntitiesScheduledForDeletion = clone $this->collFittingRuleEntities;
                $this->fittingRuleEntitiesScheduledForDeletion->clear();
            }
            $this->fittingRuleEntitiesScheduledForDeletion[]= clone $fittingRuleEntity;
            $fittingRuleEntity->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related FittingRuleEntities from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFittingRuleEntity[] List of ChildFittingRuleEntity objects
     */
    public function getFittingRuleEntitiesJoinFittingRuleEntityRelatedByForkedid(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFittingRuleEntityQuery::create(null, $criteria);
        $query->joinWith('FittingRuleEntityRelatedByForkedid', $joinBehavior);

        return $this->getFittingRuleEntities($query, $con);
    }

    /**
     * Clears out the collRulesetEntities collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRulesetEntities()
     */
    public function clearRulesetEntities()
    {
        $this->collRulesetEntities = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRulesetEntities collection loaded partially.
     */
    public function resetPartialRulesetEntities($v = true)
    {
        $this->collRulesetEntitiesPartial = $v;
    }

    /**
     * Initializes the collRulesetEntities collection.
     *
     * By default this just sets the collRulesetEntities collection to an empty array (like clearcollRulesetEntities());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRulesetEntities($overrideExisting = true)
    {
        if (null !== $this->collRulesetEntities && !$overrideExisting) {
            return;
        }
        $this->collRulesetEntities = new ObjectCollection();
        $this->collRulesetEntities->setModel('\ECP\RulesetEntity');
    }

    /**
     * Gets an array of ChildRulesetEntity objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRulesetEntity[] List of ChildRulesetEntity objects
     * @throws PropelException
     */
    public function getRulesetEntities(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRulesetEntitiesPartial && !$this->isNew();
        if (null === $this->collRulesetEntities || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRulesetEntities) {
                // return empty collection
                $this->initRulesetEntities();
            } else {
                $collRulesetEntities = ChildRulesetEntityQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRulesetEntitiesPartial && count($collRulesetEntities)) {
                        $this->initRulesetEntities(false);

                        foreach ($collRulesetEntities as $obj) {
                            if (false == $this->collRulesetEntities->contains($obj)) {
                                $this->collRulesetEntities->append($obj);
                            }
                        }

                        $this->collRulesetEntitiesPartial = true;
                    }

                    return $collRulesetEntities;
                }

                if ($partial && $this->collRulesetEntities) {
                    foreach ($this->collRulesetEntities as $obj) {
                        if ($obj->isNew()) {
                            $collRulesetEntities[] = $obj;
                        }
                    }
                }

                $this->collRulesetEntities = $collRulesetEntities;
                $this->collRulesetEntitiesPartial = false;
            }
        }

        return $this->collRulesetEntities;
    }

    /**
     * Sets a collection of ChildRulesetEntity objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rulesetEntities A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setRulesetEntities(Collection $rulesetEntities, ConnectionInterface $con = null)
    {
        /** @var ChildRulesetEntity[] $rulesetEntitiesToDelete */
        $rulesetEntitiesToDelete = $this->getRulesetEntities(new Criteria(), $con)->diff($rulesetEntities);

        
        $this->rulesetEntitiesScheduledForDeletion = $rulesetEntitiesToDelete;

        foreach ($rulesetEntitiesToDelete as $rulesetEntityRemoved) {
            $rulesetEntityRemoved->setUser(null);
        }

        $this->collRulesetEntities = null;
        foreach ($rulesetEntities as $rulesetEntity) {
            $this->addRulesetEntity($rulesetEntity);
        }

        $this->collRulesetEntities = $rulesetEntities;
        $this->collRulesetEntitiesPartial = false;

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
    public function countRulesetEntities(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRulesetEntitiesPartial && !$this->isNew();
        if (null === $this->collRulesetEntities || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRulesetEntities) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRulesetEntities());
            }

            $query = ChildRulesetEntityQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collRulesetEntities);
    }

    /**
     * Method called to associate a ChildRulesetEntity object to this object
     * through the ChildRulesetEntity foreign key attribute.
     *
     * @param  ChildRulesetEntity $l ChildRulesetEntity
     * @return $this|\ECP\User The current object (for fluent API support)
     */
    public function addRulesetEntity(ChildRulesetEntity $l)
    {
        if ($this->collRulesetEntities === null) {
            $this->initRulesetEntities();
            $this->collRulesetEntitiesPartial = true;
        }

        if (!$this->collRulesetEntities->contains($l)) {
            $this->doAddRulesetEntity($l);
        }

        return $this;
    }

    /**
     * @param ChildRulesetEntity $rulesetEntity The ChildRulesetEntity object to add.
     */
    protected function doAddRulesetEntity(ChildRulesetEntity $rulesetEntity)
    {
        $this->collRulesetEntities[]= $rulesetEntity;
        $rulesetEntity->setUser($this);
    }

    /**
     * @param  ChildRulesetEntity $rulesetEntity The ChildRulesetEntity object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeRulesetEntity(ChildRulesetEntity $rulesetEntity)
    {
        if ($this->getRulesetEntities()->contains($rulesetEntity)) {
            $pos = $this->collRulesetEntities->search($rulesetEntity);
            $this->collRulesetEntities->remove($pos);
            if (null === $this->rulesetEntitiesScheduledForDeletion) {
                $this->rulesetEntitiesScheduledForDeletion = clone $this->collRulesetEntities;
                $this->rulesetEntitiesScheduledForDeletion->clear();
            }
            $this->rulesetEntitiesScheduledForDeletion[]= clone $rulesetEntity;
            $rulesetEntity->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related RulesetEntities from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRulesetEntity[] List of ChildRulesetEntity objects
     */
    public function getRulesetEntitiesJoinRulesetEntityRelatedByForkedid(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRulesetEntityQuery::create(null, $criteria);
        $query->joinWith('RulesetEntityRelatedByForkedid', $joinBehavior);

        return $this->getRulesetEntities($query, $con);
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
     * If this ChildUser is new, it will return
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
                    ->filterByUser($this)
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
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setCompositionEntities(Collection $compositionEntities, ConnectionInterface $con = null)
    {
        /** @var ChildCompositionEntity[] $compositionEntitiesToDelete */
        $compositionEntitiesToDelete = $this->getCompositionEntities(new Criteria(), $con)->diff($compositionEntities);

        
        $this->compositionEntitiesScheduledForDeletion = $compositionEntitiesToDelete;

        foreach ($compositionEntitiesToDelete as $compositionEntityRemoved) {
            $compositionEntityRemoved->setUser(null);
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
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collCompositionEntities);
    }

    /**
     * Method called to associate a ChildCompositionEntity object to this object
     * through the ChildCompositionEntity foreign key attribute.
     *
     * @param  ChildCompositionEntity $l ChildCompositionEntity
     * @return $this|\ECP\User The current object (for fluent API support)
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
        $compositionEntity->setUser($this);
    }

    /**
     * @param  ChildCompositionEntity $compositionEntity The ChildCompositionEntity object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
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
            $compositionEntity->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related CompositionEntities from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
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
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related CompositionEntities from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCompositionEntity[] List of ChildCompositionEntity objects
     */
    public function getCompositionEntitiesJoinRulesetEntity(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCompositionEntityQuery::create(null, $criteria);
        $query->joinWith('RulesetEntity', $joinBehavior);

        return $this->getCompositionEntities($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->username = null;
        $this->password = null;
        $this->email = null;
        $this->created = null;
        $this->confirmation_code = null;
        $this->recover_password_code = null;
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
            if ($this->collFittingRuleEntities) {
                foreach ($this->collFittingRuleEntities as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRulesetEntities) {
                foreach ($this->collRulesetEntities as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCompositionEntities) {
                foreach ($this->collCompositionEntities as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collFittingRuleEntities = null;
        $this->collRulesetEntities = null;
        $this->collCompositionEntities = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserTableMap::DEFAULT_STRING_FORMAT);
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
