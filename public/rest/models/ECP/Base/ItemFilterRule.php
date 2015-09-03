<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\Comparison as ChildComparison;
use ECP\ComparisonQuery as ChildComparisonQuery;
use ECP\FittingRuleRow as ChildFittingRuleRow;
use ECP\FittingRuleRowQuery as ChildFittingRuleRowQuery;
use ECP\ItemFilterDef as ChildItemFilterDef;
use ECP\ItemFilterDefQuery as ChildItemFilterDefQuery;
use ECP\ItemFilterRuleQuery as ChildItemFilterRuleQuery;
use ECP\Map\ItemFilterRuleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'itemfilterrule' table.
 *
 * 
 *
* @package    propel.generator.ECP.Base
*/
abstract class ItemFilterRule implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\ECP\\Map\\ItemFilterRuleTableMap';


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
     * The value for the fittingrulerowid field.
     * @var        int
     */
    protected $fittingrulerowid;

    /**
     * The value for the ind3x field.
     * @var        int
     */
    protected $ind3x;

    /**
     * The value for the concatenation field.
     * @var        int
     */
    protected $concatenation;

    /**
     * The value for the itemfilterdefid field.
     * @var        int
     */
    protected $itemfilterdefid;

    /**
     * The value for the comparison field.
     * @var        int
     */
    protected $comparison;

    /**
     * The value for the value field.
     * @var        string
     */
    protected $value;

    /**
     * The value for the content1 field.
     * @var        int
     */
    protected $content1;

    /**
     * The value for the content2 field.
     * @var        int
     */
    protected $content2;

    /**
     * @var        ChildFittingRuleRow
     */
    protected $aFittingRuleRow;

    /**
     * @var        ChildComparison
     */
    protected $aconcatenationObj;

    /**
     * @var        ChildItemFilterDef
     */
    protected $aItemFilterDef;

    /**
     * @var        ChildComparison
     */
    protected $acomparisonObj;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of ECP\Base\ItemFilterRule object.
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
     * Compares this with another <code>ItemFilterRule</code> instance.  If
     * <code>obj</code> is an instance of <code>ItemFilterRule</code>, delegates to
     * <code>equals(ItemFilterRule)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|ItemFilterRule The current object, for fluid interface
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
     * Get the [fittingrulerowid] column value.
     * 
     * @return int
     */
    public function getFittingrulerowid()
    {
        return $this->fittingrulerowid;
    }

    /**
     * Get the [ind3x] column value.
     * 
     * @return int
     */
    public function getInd3x()
    {
        return $this->ind3x;
    }

    /**
     * Get the [concatenation] column value.
     * 
     * @return int
     */
    public function getConcatenation()
    {
        return $this->concatenation;
    }

    /**
     * Get the [itemfilterdefid] column value.
     * 
     * @return int
     */
    public function getItemfilterdefid()
    {
        return $this->itemfilterdefid;
    }

    /**
     * Get the [comparison] column value.
     * 
     * @return int
     */
    public function getComparison()
    {
        return $this->comparison;
    }

    /**
     * Get the [value] column value.
     * 
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the [content1] column value.
     * 
     * @return int
     */
    public function getContent1()
    {
        return $this->content1;
    }

    /**
     * Get the [content2] column value.
     * 
     * @return int
     */
    public function getContent2()
    {
        return $this->content2;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\ItemFilterRule The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ItemFilterRuleTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [fittingrulerowid] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\ItemFilterRule The current object (for fluent API support)
     */
    public function setFittingrulerowid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->fittingrulerowid !== $v) {
            $this->fittingrulerowid = $v;
            $this->modifiedColumns[ItemFilterRuleTableMap::COL_FITTINGRULEROWID] = true;
        }

        if ($this->aFittingRuleRow !== null && $this->aFittingRuleRow->getId() !== $v) {
            $this->aFittingRuleRow = null;
        }

        return $this;
    } // setFittingrulerowid()

    /**
     * Set the value of [ind3x] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\ItemFilterRule The current object (for fluent API support)
     */
    public function setInd3x($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ind3x !== $v) {
            $this->ind3x = $v;
            $this->modifiedColumns[ItemFilterRuleTableMap::COL_IND3X] = true;
        }

        return $this;
    } // setInd3x()

    /**
     * Set the value of [concatenation] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\ItemFilterRule The current object (for fluent API support)
     */
    public function setConcatenation($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->concatenation !== $v) {
            $this->concatenation = $v;
            $this->modifiedColumns[ItemFilterRuleTableMap::COL_CONCATENATION] = true;
        }

        if ($this->aconcatenationObj !== null && $this->aconcatenationObj->getId() !== $v) {
            $this->aconcatenationObj = null;
        }

        return $this;
    } // setConcatenation()

    /**
     * Set the value of [itemfilterdefid] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\ItemFilterRule The current object (for fluent API support)
     */
    public function setItemfilterdefid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->itemfilterdefid !== $v) {
            $this->itemfilterdefid = $v;
            $this->modifiedColumns[ItemFilterRuleTableMap::COL_ITEMFILTERDEFID] = true;
        }

        if ($this->aItemFilterDef !== null && $this->aItemFilterDef->getId() !== $v) {
            $this->aItemFilterDef = null;
        }

        return $this;
    } // setItemfilterdefid()

    /**
     * Set the value of [comparison] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\ItemFilterRule The current object (for fluent API support)
     */
    public function setComparison($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->comparison !== $v) {
            $this->comparison = $v;
            $this->modifiedColumns[ItemFilterRuleTableMap::COL_COMPARISON] = true;
        }

        if ($this->acomparisonObj !== null && $this->acomparisonObj->getId() !== $v) {
            $this->acomparisonObj = null;
        }

        return $this;
    } // setComparison()

    /**
     * Set the value of [value] column.
     * 
     * @param string $v new value
     * @return $this|\ECP\ItemFilterRule The current object (for fluent API support)
     */
    public function setValue($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->value !== $v) {
            $this->value = $v;
            $this->modifiedColumns[ItemFilterRuleTableMap::COL_VALUE] = true;
        }

        return $this;
    } // setValue()

    /**
     * Set the value of [content1] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\ItemFilterRule The current object (for fluent API support)
     */
    public function setContent1($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->content1 !== $v) {
            $this->content1 = $v;
            $this->modifiedColumns[ItemFilterRuleTableMap::COL_CONTENT1] = true;
        }

        return $this;
    } // setContent1()

    /**
     * Set the value of [content2] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\ItemFilterRule The current object (for fluent API support)
     */
    public function setContent2($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->content2 !== $v) {
            $this->content2 = $v;
            $this->modifiedColumns[ItemFilterRuleTableMap::COL_CONTENT2] = true;
        }

        return $this;
    } // setContent2()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ItemFilterRuleTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ItemFilterRuleTableMap::translateFieldName('Fittingrulerowid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fittingrulerowid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ItemFilterRuleTableMap::translateFieldName('Ind3x', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ind3x = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ItemFilterRuleTableMap::translateFieldName('Concatenation', TableMap::TYPE_PHPNAME, $indexType)];
            $this->concatenation = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ItemFilterRuleTableMap::translateFieldName('Itemfilterdefid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->itemfilterdefid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ItemFilterRuleTableMap::translateFieldName('Comparison', TableMap::TYPE_PHPNAME, $indexType)];
            $this->comparison = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ItemFilterRuleTableMap::translateFieldName('Value', TableMap::TYPE_PHPNAME, $indexType)];
            $this->value = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ItemFilterRuleTableMap::translateFieldName('Content1', TableMap::TYPE_PHPNAME, $indexType)];
            $this->content1 = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ItemFilterRuleTableMap::translateFieldName('Content2', TableMap::TYPE_PHPNAME, $indexType)];
            $this->content2 = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = ItemFilterRuleTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ECP\\ItemFilterRule'), 0, $e);
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
        if ($this->aFittingRuleRow !== null && $this->fittingrulerowid !== $this->aFittingRuleRow->getId()) {
            $this->aFittingRuleRow = null;
        }
        if ($this->aconcatenationObj !== null && $this->concatenation !== $this->aconcatenationObj->getId()) {
            $this->aconcatenationObj = null;
        }
        if ($this->aItemFilterDef !== null && $this->itemfilterdefid !== $this->aItemFilterDef->getId()) {
            $this->aItemFilterDef = null;
        }
        if ($this->acomparisonObj !== null && $this->comparison !== $this->acomparisonObj->getId()) {
            $this->acomparisonObj = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(ItemFilterRuleTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildItemFilterRuleQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aFittingRuleRow = null;
            $this->aconcatenationObj = null;
            $this->aItemFilterDef = null;
            $this->acomparisonObj = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see ItemFilterRule::setDeleted()
     * @see ItemFilterRule::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemFilterRuleTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildItemFilterRuleQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemFilterRuleTableMap::DATABASE_NAME);
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
                ItemFilterRuleTableMap::addInstanceToPool($this);
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

            if ($this->aFittingRuleRow !== null) {
                if ($this->aFittingRuleRow->isModified() || $this->aFittingRuleRow->isNew()) {
                    $affectedRows += $this->aFittingRuleRow->save($con);
                }
                $this->setFittingRuleRow($this->aFittingRuleRow);
            }

            if ($this->aconcatenationObj !== null) {
                if ($this->aconcatenationObj->isModified() || $this->aconcatenationObj->isNew()) {
                    $affectedRows += $this->aconcatenationObj->save($con);
                }
                $this->setconcatenationObj($this->aconcatenationObj);
            }

            if ($this->aItemFilterDef !== null) {
                if ($this->aItemFilterDef->isModified() || $this->aItemFilterDef->isNew()) {
                    $affectedRows += $this->aItemFilterDef->save($con);
                }
                $this->setItemFilterDef($this->aItemFilterDef);
            }

            if ($this->acomparisonObj !== null) {
                if ($this->acomparisonObj->isModified() || $this->acomparisonObj->isNew()) {
                    $affectedRows += $this->acomparisonObj->save($con);
                }
                $this->setcomparisonObj($this->acomparisonObj);
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

        $this->modifiedColumns[ItemFilterRuleTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ItemFilterRuleTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_FITTINGRULEROWID)) {
            $modifiedColumns[':p' . $index++]  = 'fittingRuleRowId';
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_IND3X)) {
            $modifiedColumns[':p' . $index++]  = 'ind3x';
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_CONCATENATION)) {
            $modifiedColumns[':p' . $index++]  = 'concatenation';
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_ITEMFILTERDEFID)) {
            $modifiedColumns[':p' . $index++]  = 'itemFilterDefId';
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_COMPARISON)) {
            $modifiedColumns[':p' . $index++]  = 'comparison';
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_VALUE)) {
            $modifiedColumns[':p' . $index++]  = 'value';
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_CONTENT1)) {
            $modifiedColumns[':p' . $index++]  = 'content1';
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_CONTENT2)) {
            $modifiedColumns[':p' . $index++]  = 'content2';
        }

        $sql = sprintf(
            'INSERT INTO itemfilterrule (%s) VALUES (%s)',
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
                    case 'fittingRuleRowId':                        
                        $stmt->bindValue($identifier, $this->fittingrulerowid, PDO::PARAM_INT);
                        break;
                    case 'ind3x':                        
                        $stmt->bindValue($identifier, $this->ind3x, PDO::PARAM_INT);
                        break;
                    case 'concatenation':                        
                        $stmt->bindValue($identifier, $this->concatenation, PDO::PARAM_INT);
                        break;
                    case 'itemFilterDefId':                        
                        $stmt->bindValue($identifier, $this->itemfilterdefid, PDO::PARAM_INT);
                        break;
                    case 'comparison':                        
                        $stmt->bindValue($identifier, $this->comparison, PDO::PARAM_INT);
                        break;
                    case 'value':                        
                        $stmt->bindValue($identifier, $this->value, PDO::PARAM_STR);
                        break;
                    case 'content1':                        
                        $stmt->bindValue($identifier, $this->content1, PDO::PARAM_INT);
                        break;
                    case 'content2':                        
                        $stmt->bindValue($identifier, $this->content2, PDO::PARAM_INT);
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
        $pos = ItemFilterRuleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getFittingrulerowid();
                break;
            case 2:
                return $this->getInd3x();
                break;
            case 3:
                return $this->getConcatenation();
                break;
            case 4:
                return $this->getItemfilterdefid();
                break;
            case 5:
                return $this->getComparison();
                break;
            case 6:
                return $this->getValue();
                break;
            case 7:
                return $this->getContent1();
                break;
            case 8:
                return $this->getContent2();
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

        if (isset($alreadyDumpedObjects['ItemFilterRule'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ItemFilterRule'][$this->hashCode()] = true;
        $keys = ItemFilterRuleTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFittingrulerowid(),
            $keys[2] => $this->getInd3x(),
            $keys[3] => $this->getConcatenation(),
            $keys[4] => $this->getItemfilterdefid(),
            $keys[5] => $this->getComparison(),
            $keys[6] => $this->getValue(),
            $keys[7] => $this->getContent1(),
            $keys[8] => $this->getContent2(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aFittingRuleRow) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'fittingRuleRow';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fittingrulerow';
                        break;
                    default:
                        $key = 'FittingRuleRow';
                }
        
                $result[$key] = $this->aFittingRuleRow->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aconcatenationObj) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'comparison';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'comparison';
                        break;
                    default:
                        $key = 'Comparison';
                }
        
                $result[$key] = $this->aconcatenationObj->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aItemFilterDef) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'itemFilterDef';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'itemfilterdef';
                        break;
                    default:
                        $key = 'ItemFilterDef';
                }
        
                $result[$key] = $this->aItemFilterDef->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->acomparisonObj) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'comparison';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'comparison';
                        break;
                    default:
                        $key = 'Comparison';
                }
        
                $result[$key] = $this->acomparisonObj->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\ECP\ItemFilterRule
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ItemFilterRuleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ECP\ItemFilterRule
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setFittingrulerowid($value);
                break;
            case 2:
                $this->setInd3x($value);
                break;
            case 3:
                $this->setConcatenation($value);
                break;
            case 4:
                $this->setItemfilterdefid($value);
                break;
            case 5:
                $this->setComparison($value);
                break;
            case 6:
                $this->setValue($value);
                break;
            case 7:
                $this->setContent1($value);
                break;
            case 8:
                $this->setContent2($value);
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
        $keys = ItemFilterRuleTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setFittingrulerowid($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setInd3x($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setConcatenation($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setItemfilterdefid($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setComparison($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setValue($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setContent1($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setContent2($arr[$keys[8]]);
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
     * @return $this|\ECP\ItemFilterRule The current object, for fluid interface
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
        $criteria = new Criteria(ItemFilterRuleTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_ID)) {
            $criteria->add(ItemFilterRuleTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_FITTINGRULEROWID)) {
            $criteria->add(ItemFilterRuleTableMap::COL_FITTINGRULEROWID, $this->fittingrulerowid);
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_IND3X)) {
            $criteria->add(ItemFilterRuleTableMap::COL_IND3X, $this->ind3x);
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_CONCATENATION)) {
            $criteria->add(ItemFilterRuleTableMap::COL_CONCATENATION, $this->concatenation);
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_ITEMFILTERDEFID)) {
            $criteria->add(ItemFilterRuleTableMap::COL_ITEMFILTERDEFID, $this->itemfilterdefid);
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_COMPARISON)) {
            $criteria->add(ItemFilterRuleTableMap::COL_COMPARISON, $this->comparison);
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_VALUE)) {
            $criteria->add(ItemFilterRuleTableMap::COL_VALUE, $this->value);
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_CONTENT1)) {
            $criteria->add(ItemFilterRuleTableMap::COL_CONTENT1, $this->content1);
        }
        if ($this->isColumnModified(ItemFilterRuleTableMap::COL_CONTENT2)) {
            $criteria->add(ItemFilterRuleTableMap::COL_CONTENT2, $this->content2);
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
        $criteria = ChildItemFilterRuleQuery::create();
        $criteria->add(ItemFilterRuleTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \ECP\ItemFilterRule (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFittingrulerowid($this->getFittingrulerowid());
        $copyObj->setInd3x($this->getInd3x());
        $copyObj->setConcatenation($this->getConcatenation());
        $copyObj->setItemfilterdefid($this->getItemfilterdefid());
        $copyObj->setComparison($this->getComparison());
        $copyObj->setValue($this->getValue());
        $copyObj->setContent1($this->getContent1());
        $copyObj->setContent2($this->getContent2());
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
     * @return \ECP\ItemFilterRule Clone of current object.
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
     * Declares an association between this object and a ChildFittingRuleRow object.
     *
     * @param  ChildFittingRuleRow $v
     * @return $this|\ECP\ItemFilterRule The current object (for fluent API support)
     * @throws PropelException
     */
    public function setFittingRuleRow(ChildFittingRuleRow $v = null)
    {
        if ($v === null) {
            $this->setFittingrulerowid(NULL);
        } else {
            $this->setFittingrulerowid($v->getId());
        }

        $this->aFittingRuleRow = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildFittingRuleRow object, it will not be re-added.
        if ($v !== null) {
            $v->addItemFilterRule($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildFittingRuleRow object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildFittingRuleRow The associated ChildFittingRuleRow object.
     * @throws PropelException
     */
    public function getFittingRuleRow(ConnectionInterface $con = null)
    {
        if ($this->aFittingRuleRow === null && ($this->fittingrulerowid !== null)) {
            $this->aFittingRuleRow = ChildFittingRuleRowQuery::create()->findPk($this->fittingrulerowid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFittingRuleRow->addItemFilterRules($this);
             */
        }

        return $this->aFittingRuleRow;
    }

    /**
     * Declares an association between this object and a ChildComparison object.
     *
     * @param  ChildComparison $v
     * @return $this|\ECP\ItemFilterRule The current object (for fluent API support)
     * @throws PropelException
     */
    public function setconcatenationObj(ChildComparison $v = null)
    {
        if ($v === null) {
            $this->setConcatenation(NULL);
        } else {
            $this->setConcatenation($v->getId());
        }

        $this->aconcatenationObj = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildComparison object, it will not be re-added.
        if ($v !== null) {
            $v->addItemFilterRuleRelatedByConcatenation($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildComparison object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildComparison The associated ChildComparison object.
     * @throws PropelException
     */
    public function getconcatenationObj(ConnectionInterface $con = null)
    {
        if ($this->aconcatenationObj === null && ($this->concatenation !== null)) {
            $this->aconcatenationObj = ChildComparisonQuery::create()->findPk($this->concatenation, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aconcatenationObj->addItemFilterRulesRelatedByConcatenation($this);
             */
        }

        return $this->aconcatenationObj;
    }

    /**
     * Declares an association between this object and a ChildItemFilterDef object.
     *
     * @param  ChildItemFilterDef $v
     * @return $this|\ECP\ItemFilterRule The current object (for fluent API support)
     * @throws PropelException
     */
    public function setItemFilterDef(ChildItemFilterDef $v = null)
    {
        if ($v === null) {
            $this->setItemfilterdefid(NULL);
        } else {
            $this->setItemfilterdefid($v->getId());
        }

        $this->aItemFilterDef = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildItemFilterDef object, it will not be re-added.
        if ($v !== null) {
            $v->addItemFilterRule($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildItemFilterDef object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildItemFilterDef The associated ChildItemFilterDef object.
     * @throws PropelException
     */
    public function getItemFilterDef(ConnectionInterface $con = null)
    {
        if ($this->aItemFilterDef === null && ($this->itemfilterdefid !== null)) {
            $this->aItemFilterDef = ChildItemFilterDefQuery::create()->findPk($this->itemfilterdefid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aItemFilterDef->addItemFilterRules($this);
             */
        }

        return $this->aItemFilterDef;
    }

    /**
     * Declares an association between this object and a ChildComparison object.
     *
     * @param  ChildComparison $v
     * @return $this|\ECP\ItemFilterRule The current object (for fluent API support)
     * @throws PropelException
     */
    public function setcomparisonObj(ChildComparison $v = null)
    {
        if ($v === null) {
            $this->setComparison(NULL);
        } else {
            $this->setComparison($v->getId());
        }

        $this->acomparisonObj = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildComparison object, it will not be re-added.
        if ($v !== null) {
            $v->addItemFilterRuleRelatedByComparison($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildComparison object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildComparison The associated ChildComparison object.
     * @throws PropelException
     */
    public function getcomparisonObj(ConnectionInterface $con = null)
    {
        if ($this->acomparisonObj === null && ($this->comparison !== null)) {
            $this->acomparisonObj = ChildComparisonQuery::create()->findPk($this->comparison, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->acomparisonObj->addItemFilterRulesRelatedByComparison($this);
             */
        }

        return $this->acomparisonObj;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aFittingRuleRow) {
            $this->aFittingRuleRow->removeItemFilterRule($this);
        }
        if (null !== $this->aconcatenationObj) {
            $this->aconcatenationObj->removeItemFilterRuleRelatedByConcatenation($this);
        }
        if (null !== $this->aItemFilterDef) {
            $this->aItemFilterDef->removeItemFilterRule($this);
        }
        if (null !== $this->acomparisonObj) {
            $this->acomparisonObj->removeItemFilterRuleRelatedByComparison($this);
        }
        $this->id = null;
        $this->fittingrulerowid = null;
        $this->ind3x = null;
        $this->concatenation = null;
        $this->itemfilterdefid = null;
        $this->comparison = null;
        $this->value = null;
        $this->content1 = null;
        $this->content2 = null;
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
        } // if ($deep)

        $this->aFittingRuleRow = null;
        $this->aconcatenationObj = null;
        $this->aItemFilterDef = null;
        $this->acomparisonObj = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ItemFilterRuleTableMap::DEFAULT_STRING_FORMAT);
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
