<?php

namespace EVE\Base;

use \Exception;
use \PDO;
use EVE\DgmEffects as ChildDgmEffects;
use EVE\DgmEffectsQuery as ChildDgmEffectsQuery;
use EVE\DgmTypeEffects as ChildDgmTypeEffects;
use EVE\DgmTypeEffectsQuery as ChildDgmTypeEffectsQuery;
use EVE\InvTypes as ChildInvTypes;
use EVE\InvTypesQuery as ChildInvTypesQuery;
use EVE\Map\DgmEffectsTableMap;
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
 * Base class that represents a row from the 'dgmeffects' table.
 *
 * 
 *
* @package    propel.generator.EVE.Base
*/
abstract class DgmEffects implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\EVE\\Map\\DgmEffectsTableMap';


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
     * The value for the effectid field.
     * @var        int
     */
    protected $effectid;

    /**
     * The value for the effectname field.
     * @var        string
     */
    protected $effectname;

    /**
     * The value for the displayname field.
     * @var        string
     */
    protected $displayname;

    /**
     * The value for the published field.
     * @var        int
     */
    protected $published;

    /**
     * @var        ObjectCollection|ChildDgmTypeEffects[] Collection to store aggregation of ChildDgmTypeEffects objects.
     */
    protected $collDgmTypeEffectss;
    protected $collDgmTypeEffectssPartial;

    /**
     * @var        ObjectCollection|ChildInvTypes[] Cross Collection to store aggregation of ChildInvTypes objects.
     */
    protected $collInvTypess;

    /**
     * @var bool
     */
    protected $collInvTypessPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildInvTypes[]
     */
    protected $invTypessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDgmTypeEffects[]
     */
    protected $dgmTypeEffectssScheduledForDeletion = null;

    /**
     * Initializes internal state of EVE\Base\DgmEffects object.
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
     * Compares this with another <code>DgmEffects</code> instance.  If
     * <code>obj</code> is an instance of <code>DgmEffects</code>, delegates to
     * <code>equals(DgmEffects)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|DgmEffects The current object, for fluid interface
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
     * Get the [effectid] column value.
     * 
     * @return int
     */
    public function getEffectid()
    {
        return $this->effectid;
    }

    /**
     * Get the [effectname] column value.
     * 
     * @return string
     */
    public function getEffectname()
    {
        return $this->effectname;
    }

    /**
     * Get the [displayname] column value.
     * 
     * @return string
     */
    public function getDisplayname()
    {
        return $this->displayname;
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
     * Set the value of [effectid] column.
     * 
     * @param int $v new value
     * @return $this|\EVE\DgmEffects The current object (for fluent API support)
     */
    public function setEffectid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->effectid !== $v) {
            $this->effectid = $v;
            $this->modifiedColumns[DgmEffectsTableMap::COL_EFFECTID] = true;
        }

        return $this;
    } // setEffectid()

    /**
     * Set the value of [effectname] column.
     * 
     * @param string $v new value
     * @return $this|\EVE\DgmEffects The current object (for fluent API support)
     */
    public function setEffectname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->effectname !== $v) {
            $this->effectname = $v;
            $this->modifiedColumns[DgmEffectsTableMap::COL_EFFECTNAME] = true;
        }

        return $this;
    } // setEffectname()

    /**
     * Set the value of [displayname] column.
     * 
     * @param string $v new value
     * @return $this|\EVE\DgmEffects The current object (for fluent API support)
     */
    public function setDisplayname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->displayname !== $v) {
            $this->displayname = $v;
            $this->modifiedColumns[DgmEffectsTableMap::COL_DISPLAYNAME] = true;
        }

        return $this;
    } // setDisplayname()

    /**
     * Set the value of [published] column.
     * 
     * @param int $v new value
     * @return $this|\EVE\DgmEffects The current object (for fluent API support)
     */
    public function setPublished($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->published !== $v) {
            $this->published = $v;
            $this->modifiedColumns[DgmEffectsTableMap::COL_PUBLISHED] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : DgmEffectsTableMap::translateFieldName('Effectid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->effectid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : DgmEffectsTableMap::translateFieldName('Effectname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->effectname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : DgmEffectsTableMap::translateFieldName('Displayname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->displayname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : DgmEffectsTableMap::translateFieldName('Published', TableMap::TYPE_PHPNAME, $indexType)];
            $this->published = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = DgmEffectsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\EVE\\DgmEffects'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(DgmEffectsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildDgmEffectsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collDgmTypeEffectss = null;

            $this->collInvTypess = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see DgmEffects::setDeleted()
     * @see DgmEffects::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(DgmEffectsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildDgmEffectsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(DgmEffectsTableMap::DATABASE_NAME);
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
                DgmEffectsTableMap::addInstanceToPool($this);
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

            if ($this->invTypessScheduledForDeletion !== null) {
                if (!$this->invTypessScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->invTypessScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getEffectid();
                        $entryPk[0] = $entry->getTypeid();
                        $pks[] = $entryPk;
                    }

                    \EVE\DgmTypeEffectsQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->invTypessScheduledForDeletion = null;
                }

            }

            if ($this->collInvTypess) {
                foreach ($this->collInvTypess as $invTypes) {
                    if (!$invTypes->isDeleted() && ($invTypes->isNew() || $invTypes->isModified())) {
                        $invTypes->save($con);
                    }
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

        $this->modifiedColumns[DgmEffectsTableMap::COL_EFFECTID] = true;
        if (null !== $this->effectid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . DgmEffectsTableMap::COL_EFFECTID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(DgmEffectsTableMap::COL_EFFECTID)) {
            $modifiedColumns[':p' . $index++]  = 'effectID';
        }
        if ($this->isColumnModified(DgmEffectsTableMap::COL_EFFECTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'effectName';
        }
        if ($this->isColumnModified(DgmEffectsTableMap::COL_DISPLAYNAME)) {
            $modifiedColumns[':p' . $index++]  = 'displayName';
        }
        if ($this->isColumnModified(DgmEffectsTableMap::COL_PUBLISHED)) {
            $modifiedColumns[':p' . $index++]  = 'published';
        }

        $sql = sprintf(
            'INSERT INTO dgmeffects (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'effectID':                        
                        $stmt->bindValue($identifier, $this->effectid, PDO::PARAM_INT);
                        break;
                    case 'effectName':                        
                        $stmt->bindValue($identifier, $this->effectname, PDO::PARAM_STR);
                        break;
                    case 'displayName':                        
                        $stmt->bindValue($identifier, $this->displayname, PDO::PARAM_STR);
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
        $this->setEffectid($pk);

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
        $pos = DgmEffectsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getEffectid();
                break;
            case 1:
                return $this->getEffectname();
                break;
            case 2:
                return $this->getDisplayname();
                break;
            case 3:
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

        if (isset($alreadyDumpedObjects['DgmEffects'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['DgmEffects'][$this->hashCode()] = true;
        $keys = DgmEffectsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getEffectid(),
            $keys[1] => $this->getEffectname(),
            $keys[2] => $this->getDisplayname(),
            $keys[3] => $this->getPublished(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
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
     * @return $this|\EVE\DgmEffects
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = DgmEffectsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\EVE\DgmEffects
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setEffectid($value);
                break;
            case 1:
                $this->setEffectname($value);
                break;
            case 2:
                $this->setDisplayname($value);
                break;
            case 3:
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
        $keys = DgmEffectsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setEffectid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setEffectname($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDisplayname($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPublished($arr[$keys[3]]);
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
     * @return $this|\EVE\DgmEffects The current object, for fluid interface
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
        $criteria = new Criteria(DgmEffectsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(DgmEffectsTableMap::COL_EFFECTID)) {
            $criteria->add(DgmEffectsTableMap::COL_EFFECTID, $this->effectid);
        }
        if ($this->isColumnModified(DgmEffectsTableMap::COL_EFFECTNAME)) {
            $criteria->add(DgmEffectsTableMap::COL_EFFECTNAME, $this->effectname);
        }
        if ($this->isColumnModified(DgmEffectsTableMap::COL_DISPLAYNAME)) {
            $criteria->add(DgmEffectsTableMap::COL_DISPLAYNAME, $this->displayname);
        }
        if ($this->isColumnModified(DgmEffectsTableMap::COL_PUBLISHED)) {
            $criteria->add(DgmEffectsTableMap::COL_PUBLISHED, $this->published);
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
        $criteria = ChildDgmEffectsQuery::create();
        $criteria->add(DgmEffectsTableMap::COL_EFFECTID, $this->effectid);

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
        $validPk = null !== $this->getEffectid();

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
        return $this->getEffectid();
    }

    /**
     * Generic method to set the primary key (effectid column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setEffectid($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getEffectid();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \EVE\DgmEffects (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setEffectname($this->getEffectname());
        $copyObj->setDisplayname($this->getDisplayname());
        $copyObj->setPublished($this->getPublished());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getDgmTypeEffectss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDgmTypeEffects($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setEffectid(NULL); // this is a auto-increment column, so set to default value
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
     * @return \EVE\DgmEffects Clone of current object.
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
        if ('DgmTypeEffects' == $relationName) {
            return $this->initDgmTypeEffectss();
        }
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
     * If this ChildDgmEffects is new, it will return
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
                    ->filterByDgmEffects($this)
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
     * @return $this|ChildDgmEffects The current object (for fluent API support)
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
            $dgmTypeEffectsRemoved->setDgmEffects(null);
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
                ->filterByDgmEffects($this)
                ->count($con);
        }

        return count($this->collDgmTypeEffectss);
    }

    /**
     * Method called to associate a ChildDgmTypeEffects object to this object
     * through the ChildDgmTypeEffects foreign key attribute.
     *
     * @param  ChildDgmTypeEffects $l ChildDgmTypeEffects
     * @return $this|\EVE\DgmEffects The current object (for fluent API support)
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
        $dgmTypeEffects->setDgmEffects($this);
    }

    /**
     * @param  ChildDgmTypeEffects $dgmTypeEffects The ChildDgmTypeEffects object to remove.
     * @return $this|ChildDgmEffects The current object (for fluent API support)
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
            $dgmTypeEffects->setDgmEffects(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this DgmEffects is new, it will return
     * an empty collection; or if this DgmEffects has previously
     * been saved, it will retrieve related DgmTypeEffectss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in DgmEffects.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDgmTypeEffects[] List of ChildDgmTypeEffects objects
     */
    public function getDgmTypeEffectssJoinInvTypes(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDgmTypeEffectsQuery::create(null, $criteria);
        $query->joinWith('InvTypes', $joinBehavior);

        return $this->getDgmTypeEffectss($query, $con);
    }

    /**
     * Clears out the collInvTypess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addInvTypess()
     */
    public function clearInvTypess()
    {
        $this->collInvTypess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collInvTypess crossRef collection.
     *
     * By default this just sets the collInvTypess collection to an empty collection (like clearInvTypess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initInvTypess()
    {
        $this->collInvTypess = new ObjectCollection();
        $this->collInvTypessPartial = true;

        $this->collInvTypess->setModel('\EVE\InvTypes');
    }

    /**
     * Checks if the collInvTypess collection is loaded.
     *
     * @return bool
     */
    public function isInvTypessLoaded()
    {
        return null !== $this->collInvTypess;
    }

    /**
     * Gets a collection of ChildInvTypes objects related by a many-to-many relationship
     * to the current object by way of the dgmtypeeffects cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDgmEffects is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildInvTypes[] List of ChildInvTypes objects
     */
    public function getInvTypess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collInvTypessPartial && !$this->isNew();
        if (null === $this->collInvTypess || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collInvTypess) {
                    $this->initInvTypess();
                }
            } else {

                $query = ChildInvTypesQuery::create(null, $criteria)
                    ->filterByDgmEffects($this);
                $collInvTypess = $query->find($con);
                if (null !== $criteria) {
                    return $collInvTypess;
                }

                if ($partial && $this->collInvTypess) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collInvTypess as $obj) {
                        if (!$collInvTypess->contains($obj)) {
                            $collInvTypess[] = $obj;
                        }
                    }
                }

                $this->collInvTypess = $collInvTypess;
                $this->collInvTypessPartial = false;
            }
        }

        return $this->collInvTypess;
    }

    /**
     * Sets a collection of InvTypes objects related by a many-to-many relationship
     * to the current object by way of the dgmtypeeffects cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $invTypess A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildDgmEffects The current object (for fluent API support)
     */
    public function setInvTypess(Collection $invTypess, ConnectionInterface $con = null)
    {
        $this->clearInvTypess();
        $currentInvTypess = $this->getInvTypess();

        $invTypessScheduledForDeletion = $currentInvTypess->diff($invTypess);

        foreach ($invTypessScheduledForDeletion as $toDelete) {
            $this->removeInvTypes($toDelete);
        }

        foreach ($invTypess as $invTypes) {
            if (!$currentInvTypess->contains($invTypes)) {
                $this->doAddInvTypes($invTypes);
            }
        }

        $this->collInvTypessPartial = false;
        $this->collInvTypess = $invTypess;

        return $this;
    }

    /**
     * Gets the number of InvTypes objects related by a many-to-many relationship
     * to the current object by way of the dgmtypeeffects cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related InvTypes objects
     */
    public function countInvTypess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collInvTypessPartial && !$this->isNew();
        if (null === $this->collInvTypess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collInvTypess) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getInvTypess());
                }

                $query = ChildInvTypesQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByDgmEffects($this)
                    ->count($con);
            }
        } else {
            return count($this->collInvTypess);
        }
    }

    /**
     * Associate a ChildInvTypes to this object
     * through the dgmtypeeffects cross reference table.
     * 
     * @param ChildInvTypes $invTypes
     * @return ChildDgmEffects The current object (for fluent API support)
     */
    public function addInvTypes(ChildInvTypes $invTypes)
    {
        if ($this->collInvTypess === null) {
            $this->initInvTypess();
        }

        if (!$this->getInvTypess()->contains($invTypes)) {
            // only add it if the **same** object is not already associated
            $this->collInvTypess->push($invTypes);
            $this->doAddInvTypes($invTypes);
        }

        return $this;
    }

    /**
     * 
     * @param ChildInvTypes $invTypes
     */
    protected function doAddInvTypes(ChildInvTypes $invTypes)
    {
        $dgmTypeEffects = new ChildDgmTypeEffects();

        $dgmTypeEffects->setInvTypes($invTypes);

        $dgmTypeEffects->setDgmEffects($this);

        $this->addDgmTypeEffects($dgmTypeEffects);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$invTypes->isDgmEffectssLoaded()) {
            $invTypes->initDgmEffectss();
            $invTypes->getDgmEffectss()->push($this);
        } elseif (!$invTypes->getDgmEffectss()->contains($this)) {
            $invTypes->getDgmEffectss()->push($this);
        }

    }

    /**
     * Remove invTypes of this object
     * through the dgmtypeeffects cross reference table.
     * 
     * @param ChildInvTypes $invTypes
     * @return ChildDgmEffects The current object (for fluent API support)
     */
    public function removeInvTypes(ChildInvTypes $invTypes)
    {
        if ($this->getInvTypess()->contains($invTypes)) { $dgmTypeEffects = new ChildDgmTypeEffects();

            $dgmTypeEffects->setInvTypes($invTypes);
            if ($invTypes->isDgmEffectssLoaded()) {
                //remove the back reference if available
                $invTypes->getDgmEffectss()->removeObject($this);
            }

            $dgmTypeEffects->setDgmEffects($this);
            $this->removeDgmTypeEffects(clone $dgmTypeEffects);
            $dgmTypeEffects->clear();

            $this->collInvTypess->remove($this->collInvTypess->search($invTypes));
            
            if (null === $this->invTypessScheduledForDeletion) {
                $this->invTypessScheduledForDeletion = clone $this->collInvTypess;
                $this->invTypessScheduledForDeletion->clear();
            }

            $this->invTypessScheduledForDeletion->push($invTypes);
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
        $this->effectid = null;
        $this->effectname = null;
        $this->displayname = null;
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
            if ($this->collDgmTypeEffectss) {
                foreach ($this->collDgmTypeEffectss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collInvTypess) {
                foreach ($this->collInvTypess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDgmTypeEffectss = null;
        $this->collInvTypess = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(DgmEffectsTableMap::DEFAULT_STRING_FORMAT);
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
