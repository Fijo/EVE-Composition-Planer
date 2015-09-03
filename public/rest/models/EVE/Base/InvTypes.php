<?php

namespace EVE\Base;

use \Exception;
use \PDO;
use EVE\DgmAttributeTypes as ChildDgmAttributeTypes;
use EVE\DgmAttributeTypesQuery as ChildDgmAttributeTypesQuery;
use EVE\DgmEffects as ChildDgmEffects;
use EVE\DgmEffectsQuery as ChildDgmEffectsQuery;
use EVE\DgmTypeAttributes as ChildDgmTypeAttributes;
use EVE\DgmTypeAttributesQuery as ChildDgmTypeAttributesQuery;
use EVE\DgmTypeEffects as ChildDgmTypeEffects;
use EVE\DgmTypeEffectsQuery as ChildDgmTypeEffectsQuery;
use EVE\InvGroups as ChildInvGroups;
use EVE\InvGroupsQuery as ChildInvGroupsQuery;
use EVE\InvMetaTypes as ChildInvMetaTypes;
use EVE\InvMetaTypesQuery as ChildInvMetaTypesQuery;
use EVE\InvTypes as ChildInvTypes;
use EVE\InvTypesQuery as ChildInvTypesQuery;
use EVE\Map\InvTypesTableMap;
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

/**
 * Base class that represents a row from the 'invtypes' table.
 *
 * 
 *
* @package    propel.generator.EVE.Base
*/
abstract class InvTypes implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\EVE\\Map\\InvTypesTableMap';


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
     * The value for the typeid field.
     * @var        int
     */
    protected $typeid;

    /**
     * The value for the groupid field.
     * @var        int
     */
    protected $groupid;

    /**
     * The value for the typename field.
     * @var        string
     */
    protected $typename;

    /**
     * The value for the volume field.
     * @var        double
     */
    protected $volume;

    /**
     * The value for the capacity field.
     * @var        double
     */
    protected $capacity;

    /**
     * The value for the published field.
     * @var        int
     */
    protected $published;

    /**
     * @var        ChildInvGroups
     */
    protected $aInvGroups;

    /**
     * @var        ChildInvMetaTypes one-to-one related ChildInvMetaTypes object
     */
    protected $singleInvMetaTypes;

    /**
     * @var        ObjectCollection|ChildDgmTypeEffects[] Collection to store aggregation of ChildDgmTypeEffects objects.
     */
    protected $collDgmTypeEffectss;
    protected $collDgmTypeEffectssPartial;

    /**
     * @var        ObjectCollection|ChildDgmTypeAttributes[] Collection to store aggregation of ChildDgmTypeAttributes objects.
     */
    protected $collDgmTypeAttributess;
    protected $collDgmTypeAttributessPartial;

    /**
     * @var        ObjectCollection|ChildDgmEffects[] Cross Collection to store aggregation of ChildDgmEffects objects.
     */
    protected $collDgmEffectss;

    /**
     * @var bool
     */
    protected $collDgmEffectssPartial;

    /**
     * @var        ObjectCollection|ChildDgmAttributeTypes[] Cross Collection to store aggregation of ChildDgmAttributeTypes objects.
     */
    protected $collDgmAttributeTypess;

    /**
     * @var bool
     */
    protected $collDgmAttributeTypessPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDgmEffects[]
     */
    protected $dgmEffectssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDgmAttributeTypes[]
     */
    protected $dgmAttributeTypessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDgmTypeEffects[]
     */
    protected $dgmTypeEffectssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDgmTypeAttributes[]
     */
    protected $dgmTypeAttributessScheduledForDeletion = null;

    /**
     * Initializes internal state of EVE\Base\InvTypes object.
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
     * Compares this with another <code>InvTypes</code> instance.  If
     * <code>obj</code> is an instance of <code>InvTypes</code>, delegates to
     * <code>equals(InvTypes)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|InvTypes The current object, for fluid interface
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
     * Get the [typeid] column value.
     * 
     * @return int
     */
    public function getTypeid()
    {
        return $this->typeid;
    }

    /**
     * Get the [groupid] column value.
     * 
     * @return int
     */
    public function getGroupid()
    {
        return $this->groupid;
    }

    /**
     * Get the [typename] column value.
     * 
     * @return string
     */
    public function getTypename()
    {
        return $this->typename;
    }

    /**
     * Get the [volume] column value.
     * 
     * @return double
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Get the [capacity] column value.
     * 
     * @return double
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Get the [published] column value.
     * 
     * @return int
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set the value of [typeid] column.
     * 
     * @param int $v new value
     * @return $this|\EVE\InvTypes The current object (for fluent API support)
     */
    public function setTypeid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->typeid !== $v) {
            $this->typeid = $v;
            $this->modifiedColumns[InvTypesTableMap::COL_TYPEID] = true;
        }

        return $this;
    } // setTypeid()

    /**
     * Set the value of [groupid] column.
     * 
     * @param int $v new value
     * @return $this|\EVE\InvTypes The current object (for fluent API support)
     */
    public function setGroupid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->groupid !== $v) {
            $this->groupid = $v;
            $this->modifiedColumns[InvTypesTableMap::COL_GROUPID] = true;
        }

        if ($this->aInvGroups !== null && $this->aInvGroups->getGroupid() !== $v) {
            $this->aInvGroups = null;
        }

        return $this;
    } // setGroupid()

    /**
     * Set the value of [typename] column.
     * 
     * @param string $v new value
     * @return $this|\EVE\InvTypes The current object (for fluent API support)
     */
    public function setTypename($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->typename !== $v) {
            $this->typename = $v;
            $this->modifiedColumns[InvTypesTableMap::COL_TYPENAME] = true;
        }

        return $this;
    } // setTypename()

    /**
     * Set the value of [volume] column.
     * 
     * @param double $v new value
     * @return $this|\EVE\InvTypes The current object (for fluent API support)
     */
    public function setVolume($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->volume !== $v) {
            $this->volume = $v;
            $this->modifiedColumns[InvTypesTableMap::COL_VOLUME] = true;
        }

        return $this;
    } // setVolume()

    /**
     * Set the value of [capacity] column.
     * 
     * @param double $v new value
     * @return $this|\EVE\InvTypes The current object (for fluent API support)
     */
    public function setCapacity($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->capacity !== $v) {
            $this->capacity = $v;
            $this->modifiedColumns[InvTypesTableMap::COL_CAPACITY] = true;
        }

        return $this;
    } // setCapacity()

    /**
     * Set the value of [published] column.
     * 
     * @param int $v new value
     * @return $this|\EVE\InvTypes The current object (for fluent API support)
     */
    public function setPublished($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->published !== $v) {
            $this->published = $v;
            $this->modifiedColumns[InvTypesTableMap::COL_PUBLISHED] = true;
        }

        return $this;
    } // setPublished()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : InvTypesTableMap::translateFieldName('Typeid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->typeid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : InvTypesTableMap::translateFieldName('Groupid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->groupid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : InvTypesTableMap::translateFieldName('Typename', TableMap::TYPE_PHPNAME, $indexType)];
            $this->typename = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : InvTypesTableMap::translateFieldName('Volume', TableMap::TYPE_PHPNAME, $indexType)];
            $this->volume = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : InvTypesTableMap::translateFieldName('Capacity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->capacity = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : InvTypesTableMap::translateFieldName('Published', TableMap::TYPE_PHPNAME, $indexType)];
            $this->published = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = InvTypesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\EVE\\InvTypes'), 0, $e);
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
        if ($this->aInvGroups !== null && $this->groupid !== $this->aInvGroups->getGroupid()) {
            $this->aInvGroups = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(InvTypesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildInvTypesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aInvGroups = null;
            $this->singleInvMetaTypes = null;

            $this->collDgmTypeEffectss = null;

            $this->collDgmTypeAttributess = null;

            $this->collDgmEffectss = null;
            $this->collDgmAttributeTypess = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see InvTypes::setDeleted()
     * @see InvTypes::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(InvTypesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildInvTypesQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(InvTypesTableMap::DATABASE_NAME);
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
                InvTypesTableMap::addInstanceToPool($this);
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

            if ($this->aInvGroups !== null) {
                if ($this->aInvGroups->isModified() || $this->aInvGroups->isNew()) {
                    $affectedRows += $this->aInvGroups->save($con);
                }
                $this->setInvGroups($this->aInvGroups);
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

            if ($this->dgmEffectssScheduledForDeletion !== null) {
                if (!$this->dgmEffectssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->dgmEffectssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getTypeid();
                        $entryPk[1] = $entry->getEffectid();
                        $pks[] = $entryPk;
                    }

                    \EVE\DgmTypeEffectsQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->dgmEffectssScheduledForDeletion = null;
                }

            }

            if ($this->collDgmEffectss) {
                foreach ($this->collDgmEffectss as $dgmEffects) {
                    if (!$dgmEffects->isDeleted() && ($dgmEffects->isNew() || $dgmEffects->isModified())) {
                        $dgmEffects->save($con);
                    }
                }
            }


            if ($this->dgmAttributeTypessScheduledForDeletion !== null) {
                if (!$this->dgmAttributeTypessScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->dgmAttributeTypessScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getTypeid();
                        $entryPk[1] = $entry->getAttributeid();
                        $pks[] = $entryPk;
                    }

                    \EVE\DgmTypeAttributesQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->dgmAttributeTypessScheduledForDeletion = null;
                }

            }

            if ($this->collDgmAttributeTypess) {
                foreach ($this->collDgmAttributeTypess as $dgmAttributeTypes) {
                    if (!$dgmAttributeTypes->isDeleted() && ($dgmAttributeTypes->isNew() || $dgmAttributeTypes->isModified())) {
                        $dgmAttributeTypes->save($con);
                    }
                }
            }


            if ($this->singleInvMetaTypes !== null) {
                if (!$this->singleInvMetaTypes->isDeleted() && ($this->singleInvMetaTypes->isNew() || $this->singleInvMetaTypes->isModified())) {
                    $affectedRows += $this->singleInvMetaTypes->save($con);
                }
            }

            if ($this->dgmTypeEffectssScheduledForDeletion !== null) {
                if (!$this->dgmTypeEffectssScheduledForDeletion->isEmpty()) {
                    \EVE\DgmTypeEffectsQuery::create()
                        ->filterByPrimaryKeys($this->dgmTypeEffectssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dgmTypeEffectssScheduledForDeletion = null;
                }
            }

            if ($this->collDgmTypeEffectss !== null) {
                foreach ($this->collDgmTypeEffectss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->dgmTypeAttributessScheduledForDeletion !== null) {
                if (!$this->dgmTypeAttributessScheduledForDeletion->isEmpty()) {
                    \EVE\DgmTypeAttributesQuery::create()
                        ->filterByPrimaryKeys($this->dgmTypeAttributessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dgmTypeAttributessScheduledForDeletion = null;
                }
            }

            if ($this->collDgmTypeAttributess !== null) {
                foreach ($this->collDgmTypeAttributess as $referrerFK) {
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

        $this->modifiedColumns[InvTypesTableMap::COL_TYPEID] = true;
        if (null !== $this->typeid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . InvTypesTableMap::COL_TYPEID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(InvTypesTableMap::COL_TYPEID)) {
            $modifiedColumns[':p' . $index++]  = 'typeID';
        }
        if ($this->isColumnModified(InvTypesTableMap::COL_GROUPID)) {
            $modifiedColumns[':p' . $index++]  = 'groupID';
        }
        if ($this->isColumnModified(InvTypesTableMap::COL_TYPENAME)) {
            $modifiedColumns[':p' . $index++]  = 'typeName';
        }
        if ($this->isColumnModified(InvTypesTableMap::COL_VOLUME)) {
            $modifiedColumns[':p' . $index++]  = 'volume';
        }
        if ($this->isColumnModified(InvTypesTableMap::COL_CAPACITY)) {
            $modifiedColumns[':p' . $index++]  = 'capacity';
        }
        if ($this->isColumnModified(InvTypesTableMap::COL_PUBLISHED)) {
            $modifiedColumns[':p' . $index++]  = 'published';
        }

        $sql = sprintf(
            'INSERT INTO invtypes (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'typeID':                        
                        $stmt->bindValue($identifier, $this->typeid, PDO::PARAM_INT);
                        break;
                    case 'groupID':                        
                        $stmt->bindValue($identifier, $this->groupid, PDO::PARAM_INT);
                        break;
                    case 'typeName':                        
                        $stmt->bindValue($identifier, $this->typename, PDO::PARAM_STR);
                        break;
                    case 'volume':                        
                        $stmt->bindValue($identifier, $this->volume, PDO::PARAM_STR);
                        break;
                    case 'capacity':                        
                        $stmt->bindValue($identifier, $this->capacity, PDO::PARAM_STR);
                        break;
                    case 'published':                        
                        $stmt->bindValue($identifier, $this->published, PDO::PARAM_INT);
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
        $this->setTypeid($pk);

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
        $pos = InvTypesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getTypeid();
                break;
            case 1:
                return $this->getGroupid();
                break;
            case 2:
                return $this->getTypename();
                break;
            case 3:
                return $this->getVolume();
                break;
            case 4:
                return $this->getCapacity();
                break;
            case 5:
                return $this->getPublished();
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

        if (isset($alreadyDumpedObjects['InvTypes'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['InvTypes'][$this->hashCode()] = true;
        $keys = InvTypesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getTypeid(),
            $keys[1] => $this->getGroupid(),
            $keys[2] => $this->getTypename(),
            $keys[3] => $this->getVolume(),
            $keys[4] => $this->getCapacity(),
            $keys[5] => $this->getPublished(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aInvGroups) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'invGroups';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'invgroups';
                        break;
                    default:
                        $key = 'InvGroups';
                }
        
                $result[$key] = $this->aInvGroups->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->singleInvMetaTypes) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'invMetaTypes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'invmetatypes';
                        break;
                    default:
                        $key = 'InvMetaTypes';
                }
        
                $result[$key] = $this->singleInvMetaTypes->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if (null !== $this->collDgmTypeEffectss) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'dgmTypeEffectss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'dgmtypeeffectss';
                        break;
                    default:
                        $key = 'DgmTypeEffectss';
                }
        
                $result[$key] = $this->collDgmTypeEffectss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDgmTypeAttributess) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'dgmTypeAttributess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'dgmtypeattributess';
                        break;
                    default:
                        $key = 'DgmTypeAttributess';
                }
        
                $result[$key] = $this->collDgmTypeAttributess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\EVE\InvTypes
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = InvTypesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\EVE\InvTypes
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setTypeid($value);
                break;
            case 1:
                $this->setGroupid($value);
                break;
            case 2:
                $this->setTypename($value);
                break;
            case 3:
                $this->setVolume($value);
                break;
            case 4:
                $this->setCapacity($value);
                break;
            case 5:
                $this->setPublished($value);
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
        $keys = InvTypesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setTypeid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setGroupid($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTypename($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setVolume($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCapacity($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPublished($arr[$keys[5]]);
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
     * @return $this|\EVE\InvTypes The current object, for fluid interface
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
        $criteria = new Criteria(InvTypesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(InvTypesTableMap::COL_TYPEID)) {
            $criteria->add(InvTypesTableMap::COL_TYPEID, $this->typeid);
        }
        if ($this->isColumnModified(InvTypesTableMap::COL_GROUPID)) {
            $criteria->add(InvTypesTableMap::COL_GROUPID, $this->groupid);
        }
        if ($this->isColumnModified(InvTypesTableMap::COL_TYPENAME)) {
            $criteria->add(InvTypesTableMap::COL_TYPENAME, $this->typename);
        }
        if ($this->isColumnModified(InvTypesTableMap::COL_VOLUME)) {
            $criteria->add(InvTypesTableMap::COL_VOLUME, $this->volume);
        }
        if ($this->isColumnModified(InvTypesTableMap::COL_CAPACITY)) {
            $criteria->add(InvTypesTableMap::COL_CAPACITY, $this->capacity);
        }
        if ($this->isColumnModified(InvTypesTableMap::COL_PUBLISHED)) {
            $criteria->add(InvTypesTableMap::COL_PUBLISHED, $this->published);
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
        $criteria = ChildInvTypesQuery::create();
        $criteria->add(InvTypesTableMap::COL_TYPEID, $this->typeid);

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
        $validPk = null !== $this->getTypeid();

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
        return $this->getTypeid();
    }

    /**
     * Generic method to set the primary key (typeid column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setTypeid($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getTypeid();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \EVE\InvTypes (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setGroupid($this->getGroupid());
        $copyObj->setTypename($this->getTypename());
        $copyObj->setVolume($this->getVolume());
        $copyObj->setCapacity($this->getCapacity());
        $copyObj->setPublished($this->getPublished());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            $relObj = $this->getInvMetaTypes();
            if ($relObj) {
                $copyObj->setInvMetaTypes($relObj->copy($deepCopy));
            }

            foreach ($this->getDgmTypeEffectss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDgmTypeEffects($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDgmTypeAttributess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDgmTypeAttributes($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setTypeid(NULL); // this is a auto-increment column, so set to default value
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
     * @return \EVE\InvTypes Clone of current object.
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
     * Declares an association between this object and a ChildInvGroups object.
     *
     * @param  ChildInvGroups $v
     * @return $this|\EVE\InvTypes The current object (for fluent API support)
     * @throws PropelException
     */
    public function setInvGroups(ChildInvGroups $v = null)
    {
        if ($v === null) {
            $this->setGroupid(NULL);
        } else {
            $this->setGroupid($v->getGroupid());
        }

        $this->aInvGroups = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildInvGroups object, it will not be re-added.
        if ($v !== null) {
            $v->addInvTypes($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildInvGroups object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildInvGroups The associated ChildInvGroups object.
     * @throws PropelException
     */
    public function getInvGroups(ConnectionInterface $con = null)
    {
        if ($this->aInvGroups === null && ($this->groupid !== null)) {
            $this->aInvGroups = ChildInvGroupsQuery::create()->findPk($this->groupid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aInvGroups->addInvTypess($this);
             */
        }

        return $this->aInvGroups;
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
        if ('DgmTypeEffects' == $relationName) {
            return $this->initDgmTypeEffectss();
        }
        if ('DgmTypeAttributes' == $relationName) {
            return $this->initDgmTypeAttributess();
        }
    }

    /**
     * Gets a single ChildInvMetaTypes object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildInvMetaTypes
     * @throws PropelException
     */
    public function getInvMetaTypes(ConnectionInterface $con = null)
    {

        if ($this->singleInvMetaTypes === null && !$this->isNew()) {
            $this->singleInvMetaTypes = ChildInvMetaTypesQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleInvMetaTypes;
    }

    /**
     * Sets a single ChildInvMetaTypes object as related to this object by a one-to-one relationship.
     *
     * @param  ChildInvMetaTypes $v ChildInvMetaTypes
     * @return $this|\EVE\InvTypes The current object (for fluent API support)
     * @throws PropelException
     */
    public function setInvMetaTypes(ChildInvMetaTypes $v = null)
    {
        $this->singleInvMetaTypes = $v;

        // Make sure that that the passed-in ChildInvMetaTypes isn't already associated with this object
        if ($v !== null && $v->getInvTypes(null, false) === null) {
            $v->setInvTypes($this);
        }

        return $this;
    }

    /**
     * Clears out the collDgmTypeEffectss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDgmTypeEffectss()
     */
    public function clearDgmTypeEffectss()
    {
        $this->collDgmTypeEffectss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDgmTypeEffectss collection loaded partially.
     */
    public function resetPartialDgmTypeEffectss($v = true)
    {
        $this->collDgmTypeEffectssPartial = $v;
    }

    /**
     * Initializes the collDgmTypeEffectss collection.
     *
     * By default this just sets the collDgmTypeEffectss collection to an empty array (like clearcollDgmTypeEffectss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDgmTypeEffectss($overrideExisting = true)
    {
        if (null !== $this->collDgmTypeEffectss && !$overrideExisting) {
            return;
        }
        $this->collDgmTypeEffectss = new ObjectCollection();
        $this->collDgmTypeEffectss->setModel('\EVE\DgmTypeEffects');
    }

    /**
     * Gets an array of ChildDgmTypeEffects objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildInvTypes is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDgmTypeEffects[] List of ChildDgmTypeEffects objects
     * @throws PropelException
     */
    public function getDgmTypeEffectss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDgmTypeEffectssPartial && !$this->isNew();
        if (null === $this->collDgmTypeEffectss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDgmTypeEffectss) {
                // return empty collection
                $this->initDgmTypeEffectss();
            } else {
                $collDgmTypeEffectss = ChildDgmTypeEffectsQuery::create(null, $criteria)
                    ->filterByInvTypes($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDgmTypeEffectssPartial && count($collDgmTypeEffectss)) {
                        $this->initDgmTypeEffectss(false);

                        foreach ($collDgmTypeEffectss as $obj) {
                            if (false == $this->collDgmTypeEffectss->contains($obj)) {
                                $this->collDgmTypeEffectss->append($obj);
                            }
                        }

                        $this->collDgmTypeEffectssPartial = true;
                    }

                    return $collDgmTypeEffectss;
                }

                if ($partial && $this->collDgmTypeEffectss) {
                    foreach ($this->collDgmTypeEffectss as $obj) {
                        if ($obj->isNew()) {
                            $collDgmTypeEffectss[] = $obj;
                        }
                    }
                }

                $this->collDgmTypeEffectss = $collDgmTypeEffectss;
                $this->collDgmTypeEffectssPartial = false;
            }
        }

        return $this->collDgmTypeEffectss;
    }

    /**
     * Sets a collection of ChildDgmTypeEffects objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $dgmTypeEffectss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildInvTypes The current object (for fluent API support)
     */
    public function setDgmTypeEffectss(Collection $dgmTypeEffectss, ConnectionInterface $con = null)
    {
        /** @var ChildDgmTypeEffects[] $dgmTypeEffectssToDelete */
        $dgmTypeEffectssToDelete = $this->getDgmTypeEffectss(new Criteria(), $con)->diff($dgmTypeEffectss);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->dgmTypeEffectssScheduledForDeletion = clone $dgmTypeEffectssToDelete;

        foreach ($dgmTypeEffectssToDelete as $dgmTypeEffectsRemoved) {
            $dgmTypeEffectsRemoved->setInvTypes(null);
        }

        $this->collDgmTypeEffectss = null;
        foreach ($dgmTypeEffectss as $dgmTypeEffects) {
            $this->addDgmTypeEffects($dgmTypeEffects);
        }

        $this->collDgmTypeEffectss = $dgmTypeEffectss;
        $this->collDgmTypeEffectssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DgmTypeEffects objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DgmTypeEffects objects.
     * @throws PropelException
     */
    public function countDgmTypeEffectss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDgmTypeEffectssPartial && !$this->isNew();
        if (null === $this->collDgmTypeEffectss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDgmTypeEffectss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDgmTypeEffectss());
            }

            $query = ChildDgmTypeEffectsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByInvTypes($this)
                ->count($con);
        }

        return count($this->collDgmTypeEffectss);
    }

    /**
     * Method called to associate a ChildDgmTypeEffects object to this object
     * through the ChildDgmTypeEffects foreign key attribute.
     *
     * @param  ChildDgmTypeEffects $l ChildDgmTypeEffects
     * @return $this|\EVE\InvTypes The current object (for fluent API support)
     */
    public function addDgmTypeEffects(ChildDgmTypeEffects $l)
    {
        if ($this->collDgmTypeEffectss === null) {
            $this->initDgmTypeEffectss();
            $this->collDgmTypeEffectssPartial = true;
        }

        if (!$this->collDgmTypeEffectss->contains($l)) {
            $this->doAddDgmTypeEffects($l);
        }

        return $this;
    }

    /**
     * @param ChildDgmTypeEffects $dgmTypeEffects The ChildDgmTypeEffects object to add.
     */
    protected function doAddDgmTypeEffects(ChildDgmTypeEffects $dgmTypeEffects)
    {
        $this->collDgmTypeEffectss[]= $dgmTypeEffects;
        $dgmTypeEffects->setInvTypes($this);
    }

    /**
     * @param  ChildDgmTypeEffects $dgmTypeEffects The ChildDgmTypeEffects object to remove.
     * @return $this|ChildInvTypes The current object (for fluent API support)
     */
    public function removeDgmTypeEffects(ChildDgmTypeEffects $dgmTypeEffects)
    {
        if ($this->getDgmTypeEffectss()->contains($dgmTypeEffects)) {
            $pos = $this->collDgmTypeEffectss->search($dgmTypeEffects);
            $this->collDgmTypeEffectss->remove($pos);
            if (null === $this->dgmTypeEffectssScheduledForDeletion) {
                $this->dgmTypeEffectssScheduledForDeletion = clone $this->collDgmTypeEffectss;
                $this->dgmTypeEffectssScheduledForDeletion->clear();
            }
            $this->dgmTypeEffectssScheduledForDeletion[]= clone $dgmTypeEffects;
            $dgmTypeEffects->setInvTypes(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this InvTypes is new, it will return
     * an empty collection; or if this InvTypes has previously
     * been saved, it will retrieve related DgmTypeEffectss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in InvTypes.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDgmTypeEffects[] List of ChildDgmTypeEffects objects
     */
    public function getDgmTypeEffectssJoinDgmEffects(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDgmTypeEffectsQuery::create(null, $criteria);
        $query->joinWith('DgmEffects', $joinBehavior);

        return $this->getDgmTypeEffectss($query, $con);
    }

    /**
     * Clears out the collDgmTypeAttributess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDgmTypeAttributess()
     */
    public function clearDgmTypeAttributess()
    {
        $this->collDgmTypeAttributess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDgmTypeAttributess collection loaded partially.
     */
    public function resetPartialDgmTypeAttributess($v = true)
    {
        $this->collDgmTypeAttributessPartial = $v;
    }

    /**
     * Initializes the collDgmTypeAttributess collection.
     *
     * By default this just sets the collDgmTypeAttributess collection to an empty array (like clearcollDgmTypeAttributess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDgmTypeAttributess($overrideExisting = true)
    {
        if (null !== $this->collDgmTypeAttributess && !$overrideExisting) {
            return;
        }
        $this->collDgmTypeAttributess = new ObjectCollection();
        $this->collDgmTypeAttributess->setModel('\EVE\DgmTypeAttributes');
    }

    /**
     * Gets an array of ChildDgmTypeAttributes objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildInvTypes is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDgmTypeAttributes[] List of ChildDgmTypeAttributes objects
     * @throws PropelException
     */
    public function getDgmTypeAttributess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDgmTypeAttributessPartial && !$this->isNew();
        if (null === $this->collDgmTypeAttributess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDgmTypeAttributess) {
                // return empty collection
                $this->initDgmTypeAttributess();
            } else {
                $collDgmTypeAttributess = ChildDgmTypeAttributesQuery::create(null, $criteria)
                    ->filterByInvTypes($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDgmTypeAttributessPartial && count($collDgmTypeAttributess)) {
                        $this->initDgmTypeAttributess(false);

                        foreach ($collDgmTypeAttributess as $obj) {
                            if (false == $this->collDgmTypeAttributess->contains($obj)) {
                                $this->collDgmTypeAttributess->append($obj);
                            }
                        }

                        $this->collDgmTypeAttributessPartial = true;
                    }

                    return $collDgmTypeAttributess;
                }

                if ($partial && $this->collDgmTypeAttributess) {
                    foreach ($this->collDgmTypeAttributess as $obj) {
                        if ($obj->isNew()) {
                            $collDgmTypeAttributess[] = $obj;
                        }
                    }
                }

                $this->collDgmTypeAttributess = $collDgmTypeAttributess;
                $this->collDgmTypeAttributessPartial = false;
            }
        }

        return $this->collDgmTypeAttributess;
    }

    /**
     * Sets a collection of ChildDgmTypeAttributes objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $dgmTypeAttributess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildInvTypes The current object (for fluent API support)
     */
    public function setDgmTypeAttributess(Collection $dgmTypeAttributess, ConnectionInterface $con = null)
    {
        /** @var ChildDgmTypeAttributes[] $dgmTypeAttributessToDelete */
        $dgmTypeAttributessToDelete = $this->getDgmTypeAttributess(new Criteria(), $con)->diff($dgmTypeAttributess);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->dgmTypeAttributessScheduledForDeletion = clone $dgmTypeAttributessToDelete;

        foreach ($dgmTypeAttributessToDelete as $dgmTypeAttributesRemoved) {
            $dgmTypeAttributesRemoved->setInvTypes(null);
        }

        $this->collDgmTypeAttributess = null;
        foreach ($dgmTypeAttributess as $dgmTypeAttributes) {
            $this->addDgmTypeAttributes($dgmTypeAttributes);
        }

        $this->collDgmTypeAttributess = $dgmTypeAttributess;
        $this->collDgmTypeAttributessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DgmTypeAttributes objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DgmTypeAttributes objects.
     * @throws PropelException
     */
    public function countDgmTypeAttributess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDgmTypeAttributessPartial && !$this->isNew();
        if (null === $this->collDgmTypeAttributess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDgmTypeAttributess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDgmTypeAttributess());
            }

            $query = ChildDgmTypeAttributesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByInvTypes($this)
                ->count($con);
        }

        return count($this->collDgmTypeAttributess);
    }

    /**
     * Method called to associate a ChildDgmTypeAttributes object to this object
     * through the ChildDgmTypeAttributes foreign key attribute.
     *
     * @param  ChildDgmTypeAttributes $l ChildDgmTypeAttributes
     * @return $this|\EVE\InvTypes The current object (for fluent API support)
     */
    public function addDgmTypeAttributes(ChildDgmTypeAttributes $l)
    {
        if ($this->collDgmTypeAttributess === null) {
            $this->initDgmTypeAttributess();
            $this->collDgmTypeAttributessPartial = true;
        }

        if (!$this->collDgmTypeAttributess->contains($l)) {
            $this->doAddDgmTypeAttributes($l);
        }

        return $this;
    }

    /**
     * @param ChildDgmTypeAttributes $dgmTypeAttributes The ChildDgmTypeAttributes object to add.
     */
    protected function doAddDgmTypeAttributes(ChildDgmTypeAttributes $dgmTypeAttributes)
    {
        $this->collDgmTypeAttributess[]= $dgmTypeAttributes;
        $dgmTypeAttributes->setInvTypes($this);
    }

    /**
     * @param  ChildDgmTypeAttributes $dgmTypeAttributes The ChildDgmTypeAttributes object to remove.
     * @return $this|ChildInvTypes The current object (for fluent API support)
     */
    public function removeDgmTypeAttributes(ChildDgmTypeAttributes $dgmTypeAttributes)
    {
        if ($this->getDgmTypeAttributess()->contains($dgmTypeAttributes)) {
            $pos = $this->collDgmTypeAttributess->search($dgmTypeAttributes);
            $this->collDgmTypeAttributess->remove($pos);
            if (null === $this->dgmTypeAttributessScheduledForDeletion) {
                $this->dgmTypeAttributessScheduledForDeletion = clone $this->collDgmTypeAttributess;
                $this->dgmTypeAttributessScheduledForDeletion->clear();
            }
            $this->dgmTypeAttributessScheduledForDeletion[]= clone $dgmTypeAttributes;
            $dgmTypeAttributes->setInvTypes(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this InvTypes is new, it will return
     * an empty collection; or if this InvTypes has previously
     * been saved, it will retrieve related DgmTypeAttributess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in InvTypes.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDgmTypeAttributes[] List of ChildDgmTypeAttributes objects
     */
    public function getDgmTypeAttributessJoinDgmAttributeTypes(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDgmTypeAttributesQuery::create(null, $criteria);
        $query->joinWith('DgmAttributeTypes', $joinBehavior);

        return $this->getDgmTypeAttributess($query, $con);
    }

    /**
     * Clears out the collDgmEffectss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDgmEffectss()
     */
    public function clearDgmEffectss()
    {
        $this->collDgmEffectss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collDgmEffectss crossRef collection.
     *
     * By default this just sets the collDgmEffectss collection to an empty collection (like clearDgmEffectss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initDgmEffectss()
    {
        $this->collDgmEffectss = new ObjectCollection();
        $this->collDgmEffectssPartial = true;

        $this->collDgmEffectss->setModel('\EVE\DgmEffects');
    }

    /**
     * Checks if the collDgmEffectss collection is loaded.
     *
     * @return bool
     */
    public function isDgmEffectssLoaded()
    {
        return null !== $this->collDgmEffectss;
    }

    /**
     * Gets a collection of ChildDgmEffects objects related by a many-to-many relationship
     * to the current object by way of the dgmtypeeffects cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildInvTypes is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildDgmEffects[] List of ChildDgmEffects objects
     */
    public function getDgmEffectss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDgmEffectssPartial && !$this->isNew();
        if (null === $this->collDgmEffectss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collDgmEffectss) {
                    $this->initDgmEffectss();
                }
            } else {

                $query = ChildDgmEffectsQuery::create(null, $criteria)
                    ->filterByInvTypes($this);
                $collDgmEffectss = $query->find($con);
                if (null !== $criteria) {
                    return $collDgmEffectss;
                }

                if ($partial && $this->collDgmEffectss) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collDgmEffectss as $obj) {
                        if (!$collDgmEffectss->contains($obj)) {
                            $collDgmEffectss[] = $obj;
                        }
                    }
                }

                $this->collDgmEffectss = $collDgmEffectss;
                $this->collDgmEffectssPartial = false;
            }
        }

        return $this->collDgmEffectss;
    }

    /**
     * Sets a collection of DgmEffects objects related by a many-to-many relationship
     * to the current object by way of the dgmtypeeffects cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $dgmEffectss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildInvTypes The current object (for fluent API support)
     */
    public function setDgmEffectss(Collection $dgmEffectss, ConnectionInterface $con = null)
    {
        $this->clearDgmEffectss();
        $currentDgmEffectss = $this->getDgmEffectss();

        $dgmEffectssScheduledForDeletion = $currentDgmEffectss->diff($dgmEffectss);

        foreach ($dgmEffectssScheduledForDeletion as $toDelete) {
            $this->removeDgmEffects($toDelete);
        }

        foreach ($dgmEffectss as $dgmEffects) {
            if (!$currentDgmEffectss->contains($dgmEffects)) {
                $this->doAddDgmEffects($dgmEffects);
            }
        }

        $this->collDgmEffectssPartial = false;
        $this->collDgmEffectss = $dgmEffectss;

        return $this;
    }

    /**
     * Gets the number of DgmEffects objects related by a many-to-many relationship
     * to the current object by way of the dgmtypeeffects cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related DgmEffects objects
     */
    public function countDgmEffectss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDgmEffectssPartial && !$this->isNew();
        if (null === $this->collDgmEffectss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDgmEffectss) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getDgmEffectss());
                }

                $query = ChildDgmEffectsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByInvTypes($this)
                    ->count($con);
            }
        } else {
            return count($this->collDgmEffectss);
        }
    }

    /**
     * Associate a ChildDgmEffects to this object
     * through the dgmtypeeffects cross reference table.
     * 
     * @param ChildDgmEffects $dgmEffects
     * @return ChildInvTypes The current object (for fluent API support)
     */
    public function addDgmEffects(ChildDgmEffects $dgmEffects)
    {
        if ($this->collDgmEffectss === null) {
            $this->initDgmEffectss();
        }

        if (!$this->getDgmEffectss()->contains($dgmEffects)) {
            // only add it if the **same** object is not already associated
            $this->collDgmEffectss->push($dgmEffects);
            $this->doAddDgmEffects($dgmEffects);
        }

        return $this;
    }

    /**
     * 
     * @param ChildDgmEffects $dgmEffects
     */
    protected function doAddDgmEffects(ChildDgmEffects $dgmEffects)
    {
        $dgmTypeEffects = new ChildDgmTypeEffects();

        $dgmTypeEffects->setDgmEffects($dgmEffects);

        $dgmTypeEffects->setInvTypes($this);

        $this->addDgmTypeEffects($dgmTypeEffects);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$dgmEffects->isInvTypessLoaded()) {
            $dgmEffects->initInvTypess();
            $dgmEffects->getInvTypess()->push($this);
        } elseif (!$dgmEffects->getInvTypess()->contains($this)) {
            $dgmEffects->getInvTypess()->push($this);
        }

    }

    /**
     * Remove dgmEffects of this object
     * through the dgmtypeeffects cross reference table.
     * 
     * @param ChildDgmEffects $dgmEffects
     * @return ChildInvTypes The current object (for fluent API support)
     */
    public function removeDgmEffects(ChildDgmEffects $dgmEffects)
    {
        if ($this->getDgmEffectss()->contains($dgmEffects)) { $dgmTypeEffects = new ChildDgmTypeEffects();

            $dgmTypeEffects->setDgmEffects($dgmEffects);
            if ($dgmEffects->isInvTypessLoaded()) {
                //remove the back reference if available
                $dgmEffects->getInvTypess()->removeObject($this);
            }

            $dgmTypeEffects->setInvTypes($this);
            $this->removeDgmTypeEffects(clone $dgmTypeEffects);
            $dgmTypeEffects->clear();

            $this->collDgmEffectss->remove($this->collDgmEffectss->search($dgmEffects));
            
            if (null === $this->dgmEffectssScheduledForDeletion) {
                $this->dgmEffectssScheduledForDeletion = clone $this->collDgmEffectss;
                $this->dgmEffectssScheduledForDeletion->clear();
            }

            $this->dgmEffectssScheduledForDeletion->push($dgmEffects);
        }


        return $this;
    }

    /**
     * Clears out the collDgmAttributeTypess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDgmAttributeTypess()
     */
    public function clearDgmAttributeTypess()
    {
        $this->collDgmAttributeTypess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collDgmAttributeTypess crossRef collection.
     *
     * By default this just sets the collDgmAttributeTypess collection to an empty collection (like clearDgmAttributeTypess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initDgmAttributeTypess()
    {
        $this->collDgmAttributeTypess = new ObjectCollection();
        $this->collDgmAttributeTypessPartial = true;

        $this->collDgmAttributeTypess->setModel('\EVE\DgmAttributeTypes');
    }

    /**
     * Checks if the collDgmAttributeTypess collection is loaded.
     *
     * @return bool
     */
    public function isDgmAttributeTypessLoaded()
    {
        return null !== $this->collDgmAttributeTypess;
    }

    /**
     * Gets a collection of ChildDgmAttributeTypes objects related by a many-to-many relationship
     * to the current object by way of the dgmtypeattributes cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildInvTypes is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildDgmAttributeTypes[] List of ChildDgmAttributeTypes objects
     */
    public function getDgmAttributeTypess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDgmAttributeTypessPartial && !$this->isNew();
        if (null === $this->collDgmAttributeTypess || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collDgmAttributeTypess) {
                    $this->initDgmAttributeTypess();
                }
            } else {

                $query = ChildDgmAttributeTypesQuery::create(null, $criteria)
                    ->filterByInvTypes($this);
                $collDgmAttributeTypess = $query->find($con);
                if (null !== $criteria) {
                    return $collDgmAttributeTypess;
                }

                if ($partial && $this->collDgmAttributeTypess) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collDgmAttributeTypess as $obj) {
                        if (!$collDgmAttributeTypess->contains($obj)) {
                            $collDgmAttributeTypess[] = $obj;
                        }
                    }
                }

                $this->collDgmAttributeTypess = $collDgmAttributeTypess;
                $this->collDgmAttributeTypessPartial = false;
            }
        }

        return $this->collDgmAttributeTypess;
    }

    /**
     * Sets a collection of DgmAttributeTypes objects related by a many-to-many relationship
     * to the current object by way of the dgmtypeattributes cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $dgmAttributeTypess A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildInvTypes The current object (for fluent API support)
     */
    public function setDgmAttributeTypess(Collection $dgmAttributeTypess, ConnectionInterface $con = null)
    {
        $this->clearDgmAttributeTypess();
        $currentDgmAttributeTypess = $this->getDgmAttributeTypess();

        $dgmAttributeTypessScheduledForDeletion = $currentDgmAttributeTypess->diff($dgmAttributeTypess);

        foreach ($dgmAttributeTypessScheduledForDeletion as $toDelete) {
            $this->removeDgmAttributeTypes($toDelete);
        }

        foreach ($dgmAttributeTypess as $dgmAttributeTypes) {
            if (!$currentDgmAttributeTypess->contains($dgmAttributeTypes)) {
                $this->doAddDgmAttributeTypes($dgmAttributeTypes);
            }
        }

        $this->collDgmAttributeTypessPartial = false;
        $this->collDgmAttributeTypess = $dgmAttributeTypess;

        return $this;
    }

    /**
     * Gets the number of DgmAttributeTypes objects related by a many-to-many relationship
     * to the current object by way of the dgmtypeattributes cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related DgmAttributeTypes objects
     */
    public function countDgmAttributeTypess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDgmAttributeTypessPartial && !$this->isNew();
        if (null === $this->collDgmAttributeTypess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDgmAttributeTypess) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getDgmAttributeTypess());
                }

                $query = ChildDgmAttributeTypesQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByInvTypes($this)
                    ->count($con);
            }
        } else {
            return count($this->collDgmAttributeTypess);
        }
    }

    /**
     * Associate a ChildDgmAttributeTypes to this object
     * through the dgmtypeattributes cross reference table.
     * 
     * @param ChildDgmAttributeTypes $dgmAttributeTypes
     * @return ChildInvTypes The current object (for fluent API support)
     */
    public function addDgmAttributeTypes(ChildDgmAttributeTypes $dgmAttributeTypes)
    {
        if ($this->collDgmAttributeTypess === null) {
            $this->initDgmAttributeTypess();
        }

        if (!$this->getDgmAttributeTypess()->contains($dgmAttributeTypes)) {
            // only add it if the **same** object is not already associated
            $this->collDgmAttributeTypess->push($dgmAttributeTypes);
            $this->doAddDgmAttributeTypes($dgmAttributeTypes);
        }

        return $this;
    }

    /**
     * 
     * @param ChildDgmAttributeTypes $dgmAttributeTypes
     */
    protected function doAddDgmAttributeTypes(ChildDgmAttributeTypes $dgmAttributeTypes)
    {
        $dgmTypeAttributes = new ChildDgmTypeAttributes();

        $dgmTypeAttributes->setDgmAttributeTypes($dgmAttributeTypes);

        $dgmTypeAttributes->setInvTypes($this);

        $this->addDgmTypeAttributes($dgmTypeAttributes);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$dgmAttributeTypes->isInvTypessLoaded()) {
            $dgmAttributeTypes->initInvTypess();
            $dgmAttributeTypes->getInvTypess()->push($this);
        } elseif (!$dgmAttributeTypes->getInvTypess()->contains($this)) {
            $dgmAttributeTypes->getInvTypess()->push($this);
        }

    }

    /**
     * Remove dgmAttributeTypes of this object
     * through the dgmtypeattributes cross reference table.
     * 
     * @param ChildDgmAttributeTypes $dgmAttributeTypes
     * @return ChildInvTypes The current object (for fluent API support)
     */
    public function removeDgmAttributeTypes(ChildDgmAttributeTypes $dgmAttributeTypes)
    {
        if ($this->getDgmAttributeTypess()->contains($dgmAttributeTypes)) { $dgmTypeAttributes = new ChildDgmTypeAttributes();

            $dgmTypeAttributes->setDgmAttributeTypes($dgmAttributeTypes);
            if ($dgmAttributeTypes->isInvTypessLoaded()) {
                //remove the back reference if available
                $dgmAttributeTypes->getInvTypess()->removeObject($this);
            }

            $dgmTypeAttributes->setInvTypes($this);
            $this->removeDgmTypeAttributes(clone $dgmTypeAttributes);
            $dgmTypeAttributes->clear();

            $this->collDgmAttributeTypess->remove($this->collDgmAttributeTypess->search($dgmAttributeTypes));
            
            if (null === $this->dgmAttributeTypessScheduledForDeletion) {
                $this->dgmAttributeTypessScheduledForDeletion = clone $this->collDgmAttributeTypess;
                $this->dgmAttributeTypessScheduledForDeletion->clear();
            }

            $this->dgmAttributeTypessScheduledForDeletion->push($dgmAttributeTypes);
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
        if (null !== $this->aInvGroups) {
            $this->aInvGroups->removeInvTypes($this);
        }
        $this->typeid = null;
        $this->groupid = null;
        $this->typename = null;
        $this->volume = null;
        $this->capacity = null;
        $this->published = null;
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
            if ($this->singleInvMetaTypes) {
                $this->singleInvMetaTypes->clearAllReferences($deep);
            }
            if ($this->collDgmTypeEffectss) {
                foreach ($this->collDgmTypeEffectss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDgmTypeAttributess) {
                foreach ($this->collDgmTypeAttributess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDgmEffectss) {
                foreach ($this->collDgmEffectss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDgmAttributeTypess) {
                foreach ($this->collDgmAttributeTypess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->singleInvMetaTypes = null;
        $this->collDgmTypeEffectss = null;
        $this->collDgmTypeAttributess = null;
        $this->collDgmEffectss = null;
        $this->collDgmAttributeTypess = null;
        $this->aInvGroups = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(InvTypesTableMap::DEFAULT_STRING_FORMAT);
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
