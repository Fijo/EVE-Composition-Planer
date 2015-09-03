<?php

namespace EVE\Base;

use \Exception;
use \PDO;
use EVE\DgmAttributeTypes as ChildDgmAttributeTypes;
use EVE\DgmAttributeTypesQuery as ChildDgmAttributeTypesQuery;
use EVE\DgmTypeAttributes as ChildDgmTypeAttributes;
use EVE\DgmTypeAttributesQuery as ChildDgmTypeAttributesQuery;
use EVE\InvTypes as ChildInvTypes;
use EVE\InvTypesQuery as ChildInvTypesQuery;
use EVE\Map\DgmAttributeTypesTableMap;
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
 * Base class that represents a row from the 'dgmattributetypes' table.
 *
 * 
 *
* @package    propel.generator.EVE.Base
*/
abstract class DgmAttributeTypes implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\EVE\\Map\\DgmAttributeTypesTableMap';


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
     * The value for the attributeid field.
     * @var        int
     */
    protected $attributeid;

    /**
     * The value for the attributename field.
     * @var        string
     */
    protected $attributename;

    /**
     * The value for the published field.
     * @var        int
     */
    protected $published;

    /**
     * @var        ObjectCollection|ChildDgmTypeAttributes[] Collection to store aggregation of ChildDgmTypeAttributes objects.
     */
    protected $collDgmTypeAttributess;
    protected $collDgmTypeAttributessPartial;

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
     * @var ObjectCollection|ChildDgmTypeAttributes[]
     */
    protected $dgmTypeAttributessScheduledForDeletion = null;

    /**
     * Initializes internal state of EVE\Base\DgmAttributeTypes object.
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
     * Compares this with another <code>DgmAttributeTypes</code> instance.  If
     * <code>obj</code> is an instance of <code>DgmAttributeTypes</code>, delegates to
     * <code>equals(DgmAttributeTypes)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|DgmAttributeTypes The current object, for fluid interface
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
     * Get the [attributeid] column value.
     * 
     * @return int
     */
    public function getAttributeid()
    {
        return $this->attributeid;
    }

    /**
     * Get the [attributename] column value.
     * 
     * @return string
     */
    public function getAttributename()
    {
        return $this->attributename;
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
     * Set the value of [attributeid] column.
     * 
     * @param int $v new value
     * @return $this|\EVE\DgmAttributeTypes The current object (for fluent API support)
     */
    public function setAttributeid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->attributeid !== $v) {
            $this->attributeid = $v;
            $this->modifiedColumns[DgmAttributeTypesTableMap::COL_ATTRIBUTEID] = true;
        }

        return $this;
    } // setAttributeid()

    /**
     * Set the value of [attributename] column.
     * 
     * @param string $v new value
     * @return $this|\EVE\DgmAttributeTypes The current object (for fluent API support)
     */
    public function setAttributename($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->attributename !== $v) {
            $this->attributename = $v;
            $this->modifiedColumns[DgmAttributeTypesTableMap::COL_ATTRIBUTENAME] = true;
        }

        return $this;
    } // setAttributename()

    /**
     * Set the value of [published] column.
     * 
     * @param int $v new value
     * @return $this|\EVE\DgmAttributeTypes The current object (for fluent API support)
     */
    public function setPublished($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->published !== $v) {
            $this->published = $v;
            $this->modifiedColumns[DgmAttributeTypesTableMap::COL_PUBLISHED] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : DgmAttributeTypesTableMap::translateFieldName('Attributeid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->attributeid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : DgmAttributeTypesTableMap::translateFieldName('Attributename', TableMap::TYPE_PHPNAME, $indexType)];
            $this->attributename = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : DgmAttributeTypesTableMap::translateFieldName('Published', TableMap::TYPE_PHPNAME, $indexType)];
            $this->published = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = DgmAttributeTypesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\EVE\\DgmAttributeTypes'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(DgmAttributeTypesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildDgmAttributeTypesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collDgmTypeAttributess = null;

            $this->collInvTypess = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see DgmAttributeTypes::setDeleted()
     * @see DgmAttributeTypes::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(DgmAttributeTypesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildDgmAttributeTypesQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(DgmAttributeTypesTableMap::DATABASE_NAME);
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
                DgmAttributeTypesTableMap::addInstanceToPool($this);
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

                        $entryPk[1] = $this->getAttributeid();
                        $entryPk[0] = $entry->getTypeid();
                        $pks[] = $entryPk;
                    }

                    \EVE\DgmTypeAttributesQuery::create()
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(DgmAttributeTypesTableMap::COL_ATTRIBUTEID)) {
            $modifiedColumns[':p' . $index++]  = 'attributeID';
        }
        if ($this->isColumnModified(DgmAttributeTypesTableMap::COL_ATTRIBUTENAME)) {
            $modifiedColumns[':p' . $index++]  = 'attributeName';
        }
        if ($this->isColumnModified(DgmAttributeTypesTableMap::COL_PUBLISHED)) {
            $modifiedColumns[':p' . $index++]  = 'published';
        }

        $sql = sprintf(
            'INSERT INTO dgmattributetypes (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'attributeID':                        
                        $stmt->bindValue($identifier, $this->attributeid, PDO::PARAM_INT);
                        break;
                    case 'attributeName':                        
                        $stmt->bindValue($identifier, $this->attributename, PDO::PARAM_STR);
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
        $pos = DgmAttributeTypesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getAttributeid();
                break;
            case 1:
                return $this->getAttributename();
                break;
            case 2:
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

        if (isset($alreadyDumpedObjects['DgmAttributeTypes'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['DgmAttributeTypes'][$this->hashCode()] = true;
        $keys = DgmAttributeTypesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getAttributeid(),
            $keys[1] => $this->getAttributename(),
            $keys[2] => $this->getPublished(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
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
     * @return $this|\EVE\DgmAttributeTypes
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = DgmAttributeTypesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\EVE\DgmAttributeTypes
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setAttributeid($value);
                break;
            case 1:
                $this->setAttributename($value);
                break;
            case 2:
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
        $keys = DgmAttributeTypesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setAttributeid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setAttributename($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPublished($arr[$keys[2]]);
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
     * @return $this|\EVE\DgmAttributeTypes The current object, for fluid interface
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
        $criteria = new Criteria(DgmAttributeTypesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(DgmAttributeTypesTableMap::COL_ATTRIBUTEID)) {
            $criteria->add(DgmAttributeTypesTableMap::COL_ATTRIBUTEID, $this->attributeid);
        }
        if ($this->isColumnModified(DgmAttributeTypesTableMap::COL_ATTRIBUTENAME)) {
            $criteria->add(DgmAttributeTypesTableMap::COL_ATTRIBUTENAME, $this->attributename);
        }
        if ($this->isColumnModified(DgmAttributeTypesTableMap::COL_PUBLISHED)) {
            $criteria->add(DgmAttributeTypesTableMap::COL_PUBLISHED, $this->published);
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
        $criteria = ChildDgmAttributeTypesQuery::create();
        $criteria->add(DgmAttributeTypesTableMap::COL_ATTRIBUTEID, $this->attributeid);

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
        $validPk = null !== $this->getAttributeid();

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
        return $this->getAttributeid();
    }

    /**
     * Generic method to set the primary key (attributeid column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setAttributeid($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getAttributeid();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \EVE\DgmAttributeTypes (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAttributeid($this->getAttributeid());
        $copyObj->setAttributename($this->getAttributename());
        $copyObj->setPublished($this->getPublished());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getDgmTypeAttributess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDgmTypeAttributes($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \EVE\DgmAttributeTypes Clone of current object.
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
        if ('DgmTypeAttributes' == $relationName) {
            return $this->initDgmTypeAttributess();
        }
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
     * If this ChildDgmAttributeTypes is new, it will return
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
                    ->filterByDgmAttributeTypes($this)
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
     * @return $this|ChildDgmAttributeTypes The current object (for fluent API support)
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
            $dgmTypeAttributesRemoved->setDgmAttributeTypes(null);
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
                ->filterByDgmAttributeTypes($this)
                ->count($con);
        }

        return count($this->collDgmTypeAttributess);
    }

    /**
     * Method called to associate a ChildDgmTypeAttributes object to this object
     * through the ChildDgmTypeAttributes foreign key attribute.
     *
     * @param  ChildDgmTypeAttributes $l ChildDgmTypeAttributes
     * @return $this|\EVE\DgmAttributeTypes The current object (for fluent API support)
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
        $dgmTypeAttributes->setDgmAttributeTypes($this);
    }

    /**
     * @param  ChildDgmTypeAttributes $dgmTypeAttributes The ChildDgmTypeAttributes object to remove.
     * @return $this|ChildDgmAttributeTypes The current object (for fluent API support)
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
            $dgmTypeAttributes->setDgmAttributeTypes(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this DgmAttributeTypes is new, it will return
     * an empty collection; or if this DgmAttributeTypes has previously
     * been saved, it will retrieve related DgmTypeAttributess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in DgmAttributeTypes.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDgmTypeAttributes[] List of ChildDgmTypeAttributes objects
     */
    public function getDgmTypeAttributessJoinInvTypes(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDgmTypeAttributesQuery::create(null, $criteria);
        $query->joinWith('InvTypes', $joinBehavior);

        return $this->getDgmTypeAttributess($query, $con);
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
     * to the current object by way of the dgmtypeattributes cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDgmAttributeTypes is new, it will return
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
                    ->filterByDgmAttributeTypes($this);
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
     * to the current object by way of the dgmtypeattributes cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $invTypess A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildDgmAttributeTypes The current object (for fluent API support)
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
     * to the current object by way of the dgmtypeattributes cross-reference table.
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
                    ->filterByDgmAttributeTypes($this)
                    ->count($con);
            }
        } else {
            return count($this->collInvTypess);
        }
    }

    /**
     * Associate a ChildInvTypes to this object
     * through the dgmtypeattributes cross reference table.
     * 
     * @param ChildInvTypes $invTypes
     * @return ChildDgmAttributeTypes The current object (for fluent API support)
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
        $dgmTypeAttributes = new ChildDgmTypeAttributes();

        $dgmTypeAttributes->setInvTypes($invTypes);

        $dgmTypeAttributes->setDgmAttributeTypes($this);

        $this->addDgmTypeAttributes($dgmTypeAttributes);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$invTypes->isDgmAttributeTypessLoaded()) {
            $invTypes->initDgmAttributeTypess();
            $invTypes->getDgmAttributeTypess()->push($this);
        } elseif (!$invTypes->getDgmAttributeTypess()->contains($this)) {
            $invTypes->getDgmAttributeTypess()->push($this);
        }

    }

    /**
     * Remove invTypes of this object
     * through the dgmtypeattributes cross reference table.
     * 
     * @param ChildInvTypes $invTypes
     * @return ChildDgmAttributeTypes The current object (for fluent API support)
     */
    public function removeInvTypes(ChildInvTypes $invTypes)
    {
        if ($this->getInvTypess()->contains($invTypes)) { $dgmTypeAttributes = new ChildDgmTypeAttributes();

            $dgmTypeAttributes->setInvTypes($invTypes);
            if ($invTypes->isDgmAttributeTypessLoaded()) {
                //remove the back reference if available
                $invTypes->getDgmAttributeTypess()->removeObject($this);
            }

            $dgmTypeAttributes->setDgmAttributeTypes($this);
            $this->removeDgmTypeAttributes(clone $dgmTypeAttributes);
            $dgmTypeAttributes->clear();

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
        $this->attributeid = null;
        $this->attributename = null;
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
            if ($this->collDgmTypeAttributess) {
                foreach ($this->collDgmTypeAttributess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collInvTypess) {
                foreach ($this->collInvTypess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDgmTypeAttributess = null;
        $this->collInvTypess = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(DgmAttributeTypesTableMap::DEFAULT_STRING_FORMAT);
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
