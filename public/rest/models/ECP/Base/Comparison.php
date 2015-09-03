<?php

namespace ECP\Base;

use \Exception;
use \PDO;
use ECP\Comparison as ChildComparison;
use ECP\ComparisonQuery as ChildComparisonQuery;
use ECP\FittingRuleRow as ChildFittingRuleRow;
use ECP\FittingRuleRowQuery as ChildFittingRuleRowQuery;
use ECP\ItemFilterRule as ChildItemFilterRule;
use ECP\ItemFilterRuleQuery as ChildItemFilterRuleQuery;
use ECP\RulesetFilterRule as ChildRulesetFilterRule;
use ECP\RulesetFilterRuleQuery as ChildRulesetFilterRuleQuery;
use ECP\Type as ChildType;
use ECP\TypeComparison as ChildTypeComparison;
use ECP\TypeComparisonQuery as ChildTypeComparisonQuery;
use ECP\TypeQuery as ChildTypeQuery;
use ECP\Map\ComparisonTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Collection\ObjectCombinationCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'comparison' table.
 *
 * 
 *
* @package    propel.generator.ECP.Base
*/
abstract class Comparison implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\ECP\\Map\\ComparisonTableMap';


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
     * @var        ObjectCollection|ChildTypeComparison[] Collection to store aggregation of ChildTypeComparison objects.
     */
    protected $collTypeComparisons;
    protected $collTypeComparisonsPartial;

    /**
     * @var        ObjectCollection|ChildFittingRuleRow[] Collection to store aggregation of ChildFittingRuleRow objects.
     */
    protected $collFittingRuleRowsRelatedByConcatenation;
    protected $collFittingRuleRowsRelatedByConcatenationPartial;

    /**
     * @var        ObjectCollection|ChildFittingRuleRow[] Collection to store aggregation of ChildFittingRuleRow objects.
     */
    protected $collFittingRuleRowsRelatedByComparison;
    protected $collFittingRuleRowsRelatedByComparisonPartial;

    /**
     * @var        ObjectCollection|ChildItemFilterRule[] Collection to store aggregation of ChildItemFilterRule objects.
     */
    protected $collItemFilterRulesRelatedByConcatenation;
    protected $collItemFilterRulesRelatedByConcatenationPartial;

    /**
     * @var        ObjectCollection|ChildItemFilterRule[] Collection to store aggregation of ChildItemFilterRule objects.
     */
    protected $collItemFilterRulesRelatedByComparison;
    protected $collItemFilterRulesRelatedByComparisonPartial;

    /**
     * @var        ObjectCollection|ChildRulesetFilterRule[] Collection to store aggregation of ChildRulesetFilterRule objects.
     */
    protected $collRulesetFilterRulesRelatedByConcatenation;
    protected $collRulesetFilterRulesRelatedByConcatenationPartial;

    /**
     * @var        ObjectCollection|ChildRulesetFilterRule[] Collection to store aggregation of ChildRulesetFilterRule objects.
     */
    protected $collRulesetFilterRulesRelatedByComparison;
    protected $collRulesetFilterRulesRelatedByComparisonPartial;

    /**
     * @var ObjectCombinationCollection Cross CombinationCollection to store aggregation of ChildType combinations.
     */
    protected $combinationCollTypeIds;

    /**
     * @var bool
     */
    protected $combinationCollTypeIdsPartial;

    /**
     * @var        ObjectCollection|ChildType[] Cross Collection to store aggregation of ChildType objects.
     */
    protected $collTypes;

    /**
     * @var bool
     */
    protected $collTypesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * @var ObjectCombinationCollection Cross CombinationCollection to store aggregation of ChildType combinations.
     */
    protected $combinationCollTypeIdsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTypeComparison[]
     */
    protected $typeComparisonsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFittingRuleRow[]
     */
    protected $fittingRuleRowsRelatedByConcatenationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFittingRuleRow[]
     */
    protected $fittingRuleRowsRelatedByComparisonScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildItemFilterRule[]
     */
    protected $itemFilterRulesRelatedByConcatenationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildItemFilterRule[]
     */
    protected $itemFilterRulesRelatedByComparisonScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRulesetFilterRule[]
     */
    protected $rulesetFilterRulesRelatedByConcatenationScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRulesetFilterRule[]
     */
    protected $rulesetFilterRulesRelatedByComparisonScheduledForDeletion = null;

    /**
     * Initializes internal state of ECP\Base\Comparison object.
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
     * Compares this with another <code>Comparison</code> instance.  If
     * <code>obj</code> is an instance of <code>Comparison</code>, delegates to
     * <code>equals(Comparison)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Comparison The current object, for fluid interface
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
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\ECP\Comparison The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ComparisonTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     * 
     * @param string $v new value
     * @return $this|\ECP\Comparison The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ComparisonTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ComparisonTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ComparisonTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = ComparisonTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ECP\\Comparison'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ComparisonTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildComparisonQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collTypeComparisons = null;

            $this->collFittingRuleRowsRelatedByConcatenation = null;

            $this->collFittingRuleRowsRelatedByComparison = null;

            $this->collItemFilterRulesRelatedByConcatenation = null;

            $this->collItemFilterRulesRelatedByComparison = null;

            $this->collRulesetFilterRulesRelatedByConcatenation = null;

            $this->collRulesetFilterRulesRelatedByComparison = null;

            $this->collTypeIds = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Comparison::setDeleted()
     * @see Comparison::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ComparisonTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildComparisonQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ComparisonTableMap::DATABASE_NAME);
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
                ComparisonTableMap::addInstanceToPool($this);
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

            if ($this->combinationCollTypeIdsScheduledForDeletion !== null) {
                if (!$this->combinationCollTypeIdsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->combinationCollTypeIdsScheduledForDeletion as $combination) {
                        $entryPk = [];

                        $entryPk[2] = $this->getId();
                        $entryPk[1] = $combination[0]->getId();
                        //$combination[1] = Id;
                        $entryPk[0] = $combination[1];

                        $pks[] = $entryPk;
                    }

                    \ECP\TypeComparisonQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->combinationCollTypeIdsScheduledForDeletion = null;
                }

            }

            if (null !== $this->combinationCollTypeIds) {
                foreach ($this->combinationCollTypeIds as $combination) {

                    //$combination[0] = Type (typecomparison_fk_af1a2f)
                    if (!$combination[0]->isDeleted() && ($combination[0]->isNew() || $combination[0]->isModified())) {
                        $combination[0]->save($con);
                    }
                
                    //$combination[1] = Id; Nothing to save.
                }
            }


            if ($this->typeComparisonsScheduledForDeletion !== null) {
                if (!$this->typeComparisonsScheduledForDeletion->isEmpty()) {
                    \ECP\TypeComparisonQuery::create()
                        ->filterByPrimaryKeys($this->typeComparisonsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->typeComparisonsScheduledForDeletion = null;
                }
            }

            if ($this->collTypeComparisons !== null) {
                foreach ($this->collTypeComparisons as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->fittingRuleRowsRelatedByConcatenationScheduledForDeletion !== null) {
                if (!$this->fittingRuleRowsRelatedByConcatenationScheduledForDeletion->isEmpty()) {
                    foreach ($this->fittingRuleRowsRelatedByConcatenationScheduledForDeletion as $fittingRuleRowRelatedByConcatenation) {
                        // need to save related object because we set the relation to null
                        $fittingRuleRowRelatedByConcatenation->save($con);
                    }
                    $this->fittingRuleRowsRelatedByConcatenationScheduledForDeletion = null;
                }
            }

            if ($this->collFittingRuleRowsRelatedByConcatenation !== null) {
                foreach ($this->collFittingRuleRowsRelatedByConcatenation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->fittingRuleRowsRelatedByComparisonScheduledForDeletion !== null) {
                if (!$this->fittingRuleRowsRelatedByComparisonScheduledForDeletion->isEmpty()) {
                    \ECP\FittingRuleRowQuery::create()
                        ->filterByPrimaryKeys($this->fittingRuleRowsRelatedByComparisonScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->fittingRuleRowsRelatedByComparisonScheduledForDeletion = null;
                }
            }

            if ($this->collFittingRuleRowsRelatedByComparison !== null) {
                foreach ($this->collFittingRuleRowsRelatedByComparison as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->itemFilterRulesRelatedByConcatenationScheduledForDeletion !== null) {
                if (!$this->itemFilterRulesRelatedByConcatenationScheduledForDeletion->isEmpty()) {
                    foreach ($this->itemFilterRulesRelatedByConcatenationScheduledForDeletion as $itemFilterRuleRelatedByConcatenation) {
                        // need to save related object because we set the relation to null
                        $itemFilterRuleRelatedByConcatenation->save($con);
                    }
                    $this->itemFilterRulesRelatedByConcatenationScheduledForDeletion = null;
                }
            }

            if ($this->collItemFilterRulesRelatedByConcatenation !== null) {
                foreach ($this->collItemFilterRulesRelatedByConcatenation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->itemFilterRulesRelatedByComparisonScheduledForDeletion !== null) {
                if (!$this->itemFilterRulesRelatedByComparisonScheduledForDeletion->isEmpty()) {
                    \ECP\ItemFilterRuleQuery::create()
                        ->filterByPrimaryKeys($this->itemFilterRulesRelatedByComparisonScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->itemFilterRulesRelatedByComparisonScheduledForDeletion = null;
                }
            }

            if ($this->collItemFilterRulesRelatedByComparison !== null) {
                foreach ($this->collItemFilterRulesRelatedByComparison as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rulesetFilterRulesRelatedByConcatenationScheduledForDeletion !== null) {
                if (!$this->rulesetFilterRulesRelatedByConcatenationScheduledForDeletion->isEmpty()) {
                    foreach ($this->rulesetFilterRulesRelatedByConcatenationScheduledForDeletion as $rulesetFilterRuleRelatedByConcatenation) {
                        // need to save related object because we set the relation to null
                        $rulesetFilterRuleRelatedByConcatenation->save($con);
                    }
                    $this->rulesetFilterRulesRelatedByConcatenationScheduledForDeletion = null;
                }
            }

            if ($this->collRulesetFilterRulesRelatedByConcatenation !== null) {
                foreach ($this->collRulesetFilterRulesRelatedByConcatenation as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rulesetFilterRulesRelatedByComparisonScheduledForDeletion !== null) {
                if (!$this->rulesetFilterRulesRelatedByComparisonScheduledForDeletion->isEmpty()) {
                    \ECP\RulesetFilterRuleQuery::create()
                        ->filterByPrimaryKeys($this->rulesetFilterRulesRelatedByComparisonScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rulesetFilterRulesRelatedByComparisonScheduledForDeletion = null;
                }
            }

            if ($this->collRulesetFilterRulesRelatedByComparison !== null) {
                foreach ($this->collRulesetFilterRulesRelatedByComparison as $referrerFK) {
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

        $this->modifiedColumns[ComparisonTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ComparisonTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ComparisonTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ComparisonTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }

        $sql = sprintf(
            'INSERT INTO comparison (%s) VALUES (%s)',
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
        $pos = ComparisonTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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

        if (isset($alreadyDumpedObjects['Comparison'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Comparison'][$this->hashCode()] = true;
        $keys = ComparisonTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->collTypeComparisons) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'typeComparisons';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'typecomparisons';
                        break;
                    default:
                        $key = 'TypeComparisons';
                }
        
                $result[$key] = $this->collTypeComparisons->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFittingRuleRowsRelatedByConcatenation) {
                
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
        
                $result[$key] = $this->collFittingRuleRowsRelatedByConcatenation->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFittingRuleRowsRelatedByComparison) {
                
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
        
                $result[$key] = $this->collFittingRuleRowsRelatedByComparison->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collItemFilterRulesRelatedByConcatenation) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'itemFilterRules';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'itemfilterrules';
                        break;
                    default:
                        $key = 'ItemFilterRules';
                }
        
                $result[$key] = $this->collItemFilterRulesRelatedByConcatenation->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collItemFilterRulesRelatedByComparison) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'itemFilterRules';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'itemfilterrules';
                        break;
                    default:
                        $key = 'ItemFilterRules';
                }
        
                $result[$key] = $this->collItemFilterRulesRelatedByComparison->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRulesetFilterRulesRelatedByConcatenation) {
                
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
        
                $result[$key] = $this->collRulesetFilterRulesRelatedByConcatenation->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRulesetFilterRulesRelatedByComparison) {
                
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
        
                $result[$key] = $this->collRulesetFilterRulesRelatedByComparison->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\ECP\Comparison
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ComparisonTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ECP\Comparison
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
        $keys = ComparisonTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
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
     * @return $this|\ECP\Comparison The current object, for fluid interface
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
        $criteria = new Criteria(ComparisonTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ComparisonTableMap::COL_ID)) {
            $criteria->add(ComparisonTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ComparisonTableMap::COL_NAME)) {
            $criteria->add(ComparisonTableMap::COL_NAME, $this->name);
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
        $criteria = ChildComparisonQuery::create();
        $criteria->add(ComparisonTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \ECP\Comparison (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTypeComparisons() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTypeComparison($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFittingRuleRowsRelatedByConcatenation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFittingRuleRowRelatedByConcatenation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFittingRuleRowsRelatedByComparison() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFittingRuleRowRelatedByComparison($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getItemFilterRulesRelatedByConcatenation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addItemFilterRuleRelatedByConcatenation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getItemFilterRulesRelatedByComparison() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addItemFilterRuleRelatedByComparison($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRulesetFilterRulesRelatedByConcatenation() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRulesetFilterRuleRelatedByConcatenation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRulesetFilterRulesRelatedByComparison() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRulesetFilterRuleRelatedByComparison($relObj->copy($deepCopy));
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
     * @return \ECP\Comparison Clone of current object.
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
        if ('TypeComparison' == $relationName) {
            return $this->initTypeComparisons();
        }
        if ('FittingRuleRowRelatedByConcatenation' == $relationName) {
            return $this->initFittingRuleRowsRelatedByConcatenation();
        }
        if ('FittingRuleRowRelatedByComparison' == $relationName) {
            return $this->initFittingRuleRowsRelatedByComparison();
        }
        if ('ItemFilterRuleRelatedByConcatenation' == $relationName) {
            return $this->initItemFilterRulesRelatedByConcatenation();
        }
        if ('ItemFilterRuleRelatedByComparison' == $relationName) {
            return $this->initItemFilterRulesRelatedByComparison();
        }
        if ('RulesetFilterRuleRelatedByConcatenation' == $relationName) {
            return $this->initRulesetFilterRulesRelatedByConcatenation();
        }
        if ('RulesetFilterRuleRelatedByComparison' == $relationName) {
            return $this->initRulesetFilterRulesRelatedByComparison();
        }
    }

    /**
     * Clears out the collTypeComparisons collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTypeComparisons()
     */
    public function clearTypeComparisons()
    {
        $this->collTypeComparisons = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTypeComparisons collection loaded partially.
     */
    public function resetPartialTypeComparisons($v = true)
    {
        $this->collTypeComparisonsPartial = $v;
    }

    /**
     * Initializes the collTypeComparisons collection.
     *
     * By default this just sets the collTypeComparisons collection to an empty array (like clearcollTypeComparisons());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTypeComparisons($overrideExisting = true)
    {
        if (null !== $this->collTypeComparisons && !$overrideExisting) {
            return;
        }
        $this->collTypeComparisons = new ObjectCollection();
        $this->collTypeComparisons->setModel('\ECP\TypeComparison');
    }

    /**
     * Gets an array of ChildTypeComparison objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildComparison is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTypeComparison[] List of ChildTypeComparison objects
     * @throws PropelException
     */
    public function getTypeComparisons(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTypeComparisonsPartial && !$this->isNew();
        if (null === $this->collTypeComparisons || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTypeComparisons) {
                // return empty collection
                $this->initTypeComparisons();
            } else {
                $collTypeComparisons = ChildTypeComparisonQuery::create(null, $criteria)
                    ->filterByComparison($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTypeComparisonsPartial && count($collTypeComparisons)) {
                        $this->initTypeComparisons(false);

                        foreach ($collTypeComparisons as $obj) {
                            if (false == $this->collTypeComparisons->contains($obj)) {
                                $this->collTypeComparisons->append($obj);
                            }
                        }

                        $this->collTypeComparisonsPartial = true;
                    }

                    return $collTypeComparisons;
                }

                if ($partial && $this->collTypeComparisons) {
                    foreach ($this->collTypeComparisons as $obj) {
                        if ($obj->isNew()) {
                            $collTypeComparisons[] = $obj;
                        }
                    }
                }

                $this->collTypeComparisons = $collTypeComparisons;
                $this->collTypeComparisonsPartial = false;
            }
        }

        return $this->collTypeComparisons;
    }

    /**
     * Sets a collection of ChildTypeComparison objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $typeComparisons A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function setTypeComparisons(Collection $typeComparisons, ConnectionInterface $con = null)
    {
        /** @var ChildTypeComparison[] $typeComparisonsToDelete */
        $typeComparisonsToDelete = $this->getTypeComparisons(new Criteria(), $con)->diff($typeComparisons);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->typeComparisonsScheduledForDeletion = clone $typeComparisonsToDelete;

        foreach ($typeComparisonsToDelete as $typeComparisonRemoved) {
            $typeComparisonRemoved->setComparison(null);
        }

        $this->collTypeComparisons = null;
        foreach ($typeComparisons as $typeComparison) {
            $this->addTypeComparison($typeComparison);
        }

        $this->collTypeComparisons = $typeComparisons;
        $this->collTypeComparisonsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TypeComparison objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related TypeComparison objects.
     * @throws PropelException
     */
    public function countTypeComparisons(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTypeComparisonsPartial && !$this->isNew();
        if (null === $this->collTypeComparisons || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTypeComparisons) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTypeComparisons());
            }

            $query = ChildTypeComparisonQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByComparison($this)
                ->count($con);
        }

        return count($this->collTypeComparisons);
    }

    /**
     * Method called to associate a ChildTypeComparison object to this object
     * through the ChildTypeComparison foreign key attribute.
     *
     * @param  ChildTypeComparison $l ChildTypeComparison
     * @return $this|\ECP\Comparison The current object (for fluent API support)
     */
    public function addTypeComparison(ChildTypeComparison $l)
    {
        if ($this->collTypeComparisons === null) {
            $this->initTypeComparisons();
            $this->collTypeComparisonsPartial = true;
        }

        if (!$this->collTypeComparisons->contains($l)) {
            $this->doAddTypeComparison($l);
        }

        return $this;
    }

    /**
     * @param ChildTypeComparison $typeComparison The ChildTypeComparison object to add.
     */
    protected function doAddTypeComparison(ChildTypeComparison $typeComparison)
    {
        $this->collTypeComparisons[]= $typeComparison;
        $typeComparison->setComparison($this);
    }

    /**
     * @param  ChildTypeComparison $typeComparison The ChildTypeComparison object to remove.
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function removeTypeComparison(ChildTypeComparison $typeComparison)
    {
        if ($this->getTypeComparisons()->contains($typeComparison)) {
            $pos = $this->collTypeComparisons->search($typeComparison);
            $this->collTypeComparisons->remove($pos);
            if (null === $this->typeComparisonsScheduledForDeletion) {
                $this->typeComparisonsScheduledForDeletion = clone $this->collTypeComparisons;
                $this->typeComparisonsScheduledForDeletion->clear();
            }
            $this->typeComparisonsScheduledForDeletion[]= clone $typeComparison;
            $typeComparison->setComparison(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comparison is new, it will return
     * an empty collection; or if this Comparison has previously
     * been saved, it will retrieve related TypeComparisons from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comparison.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTypeComparison[] List of ChildTypeComparison objects
     */
    public function getTypeComparisonsJoinType(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTypeComparisonQuery::create(null, $criteria);
        $query->joinWith('Type', $joinBehavior);

        return $this->getTypeComparisons($query, $con);
    }

    /**
     * Clears out the collFittingRuleRowsRelatedByConcatenation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFittingRuleRowsRelatedByConcatenation()
     */
    public function clearFittingRuleRowsRelatedByConcatenation()
    {
        $this->collFittingRuleRowsRelatedByConcatenation = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFittingRuleRowsRelatedByConcatenation collection loaded partially.
     */
    public function resetPartialFittingRuleRowsRelatedByConcatenation($v = true)
    {
        $this->collFittingRuleRowsRelatedByConcatenationPartial = $v;
    }

    /**
     * Initializes the collFittingRuleRowsRelatedByConcatenation collection.
     *
     * By default this just sets the collFittingRuleRowsRelatedByConcatenation collection to an empty array (like clearcollFittingRuleRowsRelatedByConcatenation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFittingRuleRowsRelatedByConcatenation($overrideExisting = true)
    {
        if (null !== $this->collFittingRuleRowsRelatedByConcatenation && !$overrideExisting) {
            return;
        }
        $this->collFittingRuleRowsRelatedByConcatenation = new ObjectCollection();
        $this->collFittingRuleRowsRelatedByConcatenation->setModel('\ECP\FittingRuleRow');
    }

    /**
     * Gets an array of ChildFittingRuleRow objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildComparison is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFittingRuleRow[] List of ChildFittingRuleRow objects
     * @throws PropelException
     */
    public function getFittingRuleRowsRelatedByConcatenation(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFittingRuleRowsRelatedByConcatenationPartial && !$this->isNew();
        if (null === $this->collFittingRuleRowsRelatedByConcatenation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFittingRuleRowsRelatedByConcatenation) {
                // return empty collection
                $this->initFittingRuleRowsRelatedByConcatenation();
            } else {
                $collFittingRuleRowsRelatedByConcatenation = ChildFittingRuleRowQuery::create(null, $criteria)
                    ->filterByconcatenationObj($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFittingRuleRowsRelatedByConcatenationPartial && count($collFittingRuleRowsRelatedByConcatenation)) {
                        $this->initFittingRuleRowsRelatedByConcatenation(false);

                        foreach ($collFittingRuleRowsRelatedByConcatenation as $obj) {
                            if (false == $this->collFittingRuleRowsRelatedByConcatenation->contains($obj)) {
                                $this->collFittingRuleRowsRelatedByConcatenation->append($obj);
                            }
                        }

                        $this->collFittingRuleRowsRelatedByConcatenationPartial = true;
                    }

                    return $collFittingRuleRowsRelatedByConcatenation;
                }

                if ($partial && $this->collFittingRuleRowsRelatedByConcatenation) {
                    foreach ($this->collFittingRuleRowsRelatedByConcatenation as $obj) {
                        if ($obj->isNew()) {
                            $collFittingRuleRowsRelatedByConcatenation[] = $obj;
                        }
                    }
                }

                $this->collFittingRuleRowsRelatedByConcatenation = $collFittingRuleRowsRelatedByConcatenation;
                $this->collFittingRuleRowsRelatedByConcatenationPartial = false;
            }
        }

        return $this->collFittingRuleRowsRelatedByConcatenation;
    }

    /**
     * Sets a collection of ChildFittingRuleRow objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $fittingRuleRowsRelatedByConcatenation A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function setFittingRuleRowsRelatedByConcatenation(Collection $fittingRuleRowsRelatedByConcatenation, ConnectionInterface $con = null)
    {
        /** @var ChildFittingRuleRow[] $fittingRuleRowsRelatedByConcatenationToDelete */
        $fittingRuleRowsRelatedByConcatenationToDelete = $this->getFittingRuleRowsRelatedByConcatenation(new Criteria(), $con)->diff($fittingRuleRowsRelatedByConcatenation);

        
        $this->fittingRuleRowsRelatedByConcatenationScheduledForDeletion = $fittingRuleRowsRelatedByConcatenationToDelete;

        foreach ($fittingRuleRowsRelatedByConcatenationToDelete as $fittingRuleRowRelatedByConcatenationRemoved) {
            $fittingRuleRowRelatedByConcatenationRemoved->setconcatenationObj(null);
        }

        $this->collFittingRuleRowsRelatedByConcatenation = null;
        foreach ($fittingRuleRowsRelatedByConcatenation as $fittingRuleRowRelatedByConcatenation) {
            $this->addFittingRuleRowRelatedByConcatenation($fittingRuleRowRelatedByConcatenation);
        }

        $this->collFittingRuleRowsRelatedByConcatenation = $fittingRuleRowsRelatedByConcatenation;
        $this->collFittingRuleRowsRelatedByConcatenationPartial = false;

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
    public function countFittingRuleRowsRelatedByConcatenation(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFittingRuleRowsRelatedByConcatenationPartial && !$this->isNew();
        if (null === $this->collFittingRuleRowsRelatedByConcatenation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFittingRuleRowsRelatedByConcatenation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFittingRuleRowsRelatedByConcatenation());
            }

            $query = ChildFittingRuleRowQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByconcatenationObj($this)
                ->count($con);
        }

        return count($this->collFittingRuleRowsRelatedByConcatenation);
    }

    /**
     * Method called to associate a ChildFittingRuleRow object to this object
     * through the ChildFittingRuleRow foreign key attribute.
     *
     * @param  ChildFittingRuleRow $l ChildFittingRuleRow
     * @return $this|\ECP\Comparison The current object (for fluent API support)
     */
    public function addFittingRuleRowRelatedByConcatenation(ChildFittingRuleRow $l)
    {
        if ($this->collFittingRuleRowsRelatedByConcatenation === null) {
            $this->initFittingRuleRowsRelatedByConcatenation();
            $this->collFittingRuleRowsRelatedByConcatenationPartial = true;
        }

        if (!$this->collFittingRuleRowsRelatedByConcatenation->contains($l)) {
            $this->doAddFittingRuleRowRelatedByConcatenation($l);
        }

        return $this;
    }

    /**
     * @param ChildFittingRuleRow $fittingRuleRowRelatedByConcatenation The ChildFittingRuleRow object to add.
     */
    protected function doAddFittingRuleRowRelatedByConcatenation(ChildFittingRuleRow $fittingRuleRowRelatedByConcatenation)
    {
        $this->collFittingRuleRowsRelatedByConcatenation[]= $fittingRuleRowRelatedByConcatenation;
        $fittingRuleRowRelatedByConcatenation->setconcatenationObj($this);
    }

    /**
     * @param  ChildFittingRuleRow $fittingRuleRowRelatedByConcatenation The ChildFittingRuleRow object to remove.
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function removeFittingRuleRowRelatedByConcatenation(ChildFittingRuleRow $fittingRuleRowRelatedByConcatenation)
    {
        if ($this->getFittingRuleRowsRelatedByConcatenation()->contains($fittingRuleRowRelatedByConcatenation)) {
            $pos = $this->collFittingRuleRowsRelatedByConcatenation->search($fittingRuleRowRelatedByConcatenation);
            $this->collFittingRuleRowsRelatedByConcatenation->remove($pos);
            if (null === $this->fittingRuleRowsRelatedByConcatenationScheduledForDeletion) {
                $this->fittingRuleRowsRelatedByConcatenationScheduledForDeletion = clone $this->collFittingRuleRowsRelatedByConcatenation;
                $this->fittingRuleRowsRelatedByConcatenationScheduledForDeletion->clear();
            }
            $this->fittingRuleRowsRelatedByConcatenationScheduledForDeletion[]= $fittingRuleRowRelatedByConcatenation;
            $fittingRuleRowRelatedByConcatenation->setconcatenationObj(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comparison is new, it will return
     * an empty collection; or if this Comparison has previously
     * been saved, it will retrieve related FittingRuleRowsRelatedByConcatenation from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comparison.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFittingRuleRow[] List of ChildFittingRuleRow objects
     */
    public function getFittingRuleRowsRelatedByConcatenationJoinFittingRuleEntity(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFittingRuleRowQuery::create(null, $criteria);
        $query->joinWith('FittingRuleEntity', $joinBehavior);

        return $this->getFittingRuleRowsRelatedByConcatenation($query, $con);
    }

    /**
     * Clears out the collFittingRuleRowsRelatedByComparison collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFittingRuleRowsRelatedByComparison()
     */
    public function clearFittingRuleRowsRelatedByComparison()
    {
        $this->collFittingRuleRowsRelatedByComparison = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFittingRuleRowsRelatedByComparison collection loaded partially.
     */
    public function resetPartialFittingRuleRowsRelatedByComparison($v = true)
    {
        $this->collFittingRuleRowsRelatedByComparisonPartial = $v;
    }

    /**
     * Initializes the collFittingRuleRowsRelatedByComparison collection.
     *
     * By default this just sets the collFittingRuleRowsRelatedByComparison collection to an empty array (like clearcollFittingRuleRowsRelatedByComparison());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFittingRuleRowsRelatedByComparison($overrideExisting = true)
    {
        if (null !== $this->collFittingRuleRowsRelatedByComparison && !$overrideExisting) {
            return;
        }
        $this->collFittingRuleRowsRelatedByComparison = new ObjectCollection();
        $this->collFittingRuleRowsRelatedByComparison->setModel('\ECP\FittingRuleRow');
    }

    /**
     * Gets an array of ChildFittingRuleRow objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildComparison is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFittingRuleRow[] List of ChildFittingRuleRow objects
     * @throws PropelException
     */
    public function getFittingRuleRowsRelatedByComparison(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFittingRuleRowsRelatedByComparisonPartial && !$this->isNew();
        if (null === $this->collFittingRuleRowsRelatedByComparison || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFittingRuleRowsRelatedByComparison) {
                // return empty collection
                $this->initFittingRuleRowsRelatedByComparison();
            } else {
                $collFittingRuleRowsRelatedByComparison = ChildFittingRuleRowQuery::create(null, $criteria)
                    ->filterBycomparisonObj($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFittingRuleRowsRelatedByComparisonPartial && count($collFittingRuleRowsRelatedByComparison)) {
                        $this->initFittingRuleRowsRelatedByComparison(false);

                        foreach ($collFittingRuleRowsRelatedByComparison as $obj) {
                            if (false == $this->collFittingRuleRowsRelatedByComparison->contains($obj)) {
                                $this->collFittingRuleRowsRelatedByComparison->append($obj);
                            }
                        }

                        $this->collFittingRuleRowsRelatedByComparisonPartial = true;
                    }

                    return $collFittingRuleRowsRelatedByComparison;
                }

                if ($partial && $this->collFittingRuleRowsRelatedByComparison) {
                    foreach ($this->collFittingRuleRowsRelatedByComparison as $obj) {
                        if ($obj->isNew()) {
                            $collFittingRuleRowsRelatedByComparison[] = $obj;
                        }
                    }
                }

                $this->collFittingRuleRowsRelatedByComparison = $collFittingRuleRowsRelatedByComparison;
                $this->collFittingRuleRowsRelatedByComparisonPartial = false;
            }
        }

        return $this->collFittingRuleRowsRelatedByComparison;
    }

    /**
     * Sets a collection of ChildFittingRuleRow objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $fittingRuleRowsRelatedByComparison A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function setFittingRuleRowsRelatedByComparison(Collection $fittingRuleRowsRelatedByComparison, ConnectionInterface $con = null)
    {
        /** @var ChildFittingRuleRow[] $fittingRuleRowsRelatedByComparisonToDelete */
        $fittingRuleRowsRelatedByComparisonToDelete = $this->getFittingRuleRowsRelatedByComparison(new Criteria(), $con)->diff($fittingRuleRowsRelatedByComparison);

        
        $this->fittingRuleRowsRelatedByComparisonScheduledForDeletion = $fittingRuleRowsRelatedByComparisonToDelete;

        foreach ($fittingRuleRowsRelatedByComparisonToDelete as $fittingRuleRowRelatedByComparisonRemoved) {
            $fittingRuleRowRelatedByComparisonRemoved->setcomparisonObj(null);
        }

        $this->collFittingRuleRowsRelatedByComparison = null;
        foreach ($fittingRuleRowsRelatedByComparison as $fittingRuleRowRelatedByComparison) {
            $this->addFittingRuleRowRelatedByComparison($fittingRuleRowRelatedByComparison);
        }

        $this->collFittingRuleRowsRelatedByComparison = $fittingRuleRowsRelatedByComparison;
        $this->collFittingRuleRowsRelatedByComparisonPartial = false;

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
    public function countFittingRuleRowsRelatedByComparison(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFittingRuleRowsRelatedByComparisonPartial && !$this->isNew();
        if (null === $this->collFittingRuleRowsRelatedByComparison || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFittingRuleRowsRelatedByComparison) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFittingRuleRowsRelatedByComparison());
            }

            $query = ChildFittingRuleRowQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBycomparisonObj($this)
                ->count($con);
        }

        return count($this->collFittingRuleRowsRelatedByComparison);
    }

    /**
     * Method called to associate a ChildFittingRuleRow object to this object
     * through the ChildFittingRuleRow foreign key attribute.
     *
     * @param  ChildFittingRuleRow $l ChildFittingRuleRow
     * @return $this|\ECP\Comparison The current object (for fluent API support)
     */
    public function addFittingRuleRowRelatedByComparison(ChildFittingRuleRow $l)
    {
        if ($this->collFittingRuleRowsRelatedByComparison === null) {
            $this->initFittingRuleRowsRelatedByComparison();
            $this->collFittingRuleRowsRelatedByComparisonPartial = true;
        }

        if (!$this->collFittingRuleRowsRelatedByComparison->contains($l)) {
            $this->doAddFittingRuleRowRelatedByComparison($l);
        }

        return $this;
    }

    /**
     * @param ChildFittingRuleRow $fittingRuleRowRelatedByComparison The ChildFittingRuleRow object to add.
     */
    protected function doAddFittingRuleRowRelatedByComparison(ChildFittingRuleRow $fittingRuleRowRelatedByComparison)
    {
        $this->collFittingRuleRowsRelatedByComparison[]= $fittingRuleRowRelatedByComparison;
        $fittingRuleRowRelatedByComparison->setcomparisonObj($this);
    }

    /**
     * @param  ChildFittingRuleRow $fittingRuleRowRelatedByComparison The ChildFittingRuleRow object to remove.
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function removeFittingRuleRowRelatedByComparison(ChildFittingRuleRow $fittingRuleRowRelatedByComparison)
    {
        if ($this->getFittingRuleRowsRelatedByComparison()->contains($fittingRuleRowRelatedByComparison)) {
            $pos = $this->collFittingRuleRowsRelatedByComparison->search($fittingRuleRowRelatedByComparison);
            $this->collFittingRuleRowsRelatedByComparison->remove($pos);
            if (null === $this->fittingRuleRowsRelatedByComparisonScheduledForDeletion) {
                $this->fittingRuleRowsRelatedByComparisonScheduledForDeletion = clone $this->collFittingRuleRowsRelatedByComparison;
                $this->fittingRuleRowsRelatedByComparisonScheduledForDeletion->clear();
            }
            $this->fittingRuleRowsRelatedByComparisonScheduledForDeletion[]= clone $fittingRuleRowRelatedByComparison;
            $fittingRuleRowRelatedByComparison->setcomparisonObj(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comparison is new, it will return
     * an empty collection; or if this Comparison has previously
     * been saved, it will retrieve related FittingRuleRowsRelatedByComparison from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comparison.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFittingRuleRow[] List of ChildFittingRuleRow objects
     */
    public function getFittingRuleRowsRelatedByComparisonJoinFittingRuleEntity(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFittingRuleRowQuery::create(null, $criteria);
        $query->joinWith('FittingRuleEntity', $joinBehavior);

        return $this->getFittingRuleRowsRelatedByComparison($query, $con);
    }

    /**
     * Clears out the collItemFilterRulesRelatedByConcatenation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addItemFilterRulesRelatedByConcatenation()
     */
    public function clearItemFilterRulesRelatedByConcatenation()
    {
        $this->collItemFilterRulesRelatedByConcatenation = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collItemFilterRulesRelatedByConcatenation collection loaded partially.
     */
    public function resetPartialItemFilterRulesRelatedByConcatenation($v = true)
    {
        $this->collItemFilterRulesRelatedByConcatenationPartial = $v;
    }

    /**
     * Initializes the collItemFilterRulesRelatedByConcatenation collection.
     *
     * By default this just sets the collItemFilterRulesRelatedByConcatenation collection to an empty array (like clearcollItemFilterRulesRelatedByConcatenation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initItemFilterRulesRelatedByConcatenation($overrideExisting = true)
    {
        if (null !== $this->collItemFilterRulesRelatedByConcatenation && !$overrideExisting) {
            return;
        }
        $this->collItemFilterRulesRelatedByConcatenation = new ObjectCollection();
        $this->collItemFilterRulesRelatedByConcatenation->setModel('\ECP\ItemFilterRule');
    }

    /**
     * Gets an array of ChildItemFilterRule objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildComparison is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildItemFilterRule[] List of ChildItemFilterRule objects
     * @throws PropelException
     */
    public function getItemFilterRulesRelatedByConcatenation(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collItemFilterRulesRelatedByConcatenationPartial && !$this->isNew();
        if (null === $this->collItemFilterRulesRelatedByConcatenation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collItemFilterRulesRelatedByConcatenation) {
                // return empty collection
                $this->initItemFilterRulesRelatedByConcatenation();
            } else {
                $collItemFilterRulesRelatedByConcatenation = ChildItemFilterRuleQuery::create(null, $criteria)
                    ->filterByconcatenationObj($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collItemFilterRulesRelatedByConcatenationPartial && count($collItemFilterRulesRelatedByConcatenation)) {
                        $this->initItemFilterRulesRelatedByConcatenation(false);

                        foreach ($collItemFilterRulesRelatedByConcatenation as $obj) {
                            if (false == $this->collItemFilterRulesRelatedByConcatenation->contains($obj)) {
                                $this->collItemFilterRulesRelatedByConcatenation->append($obj);
                            }
                        }

                        $this->collItemFilterRulesRelatedByConcatenationPartial = true;
                    }

                    return $collItemFilterRulesRelatedByConcatenation;
                }

                if ($partial && $this->collItemFilterRulesRelatedByConcatenation) {
                    foreach ($this->collItemFilterRulesRelatedByConcatenation as $obj) {
                        if ($obj->isNew()) {
                            $collItemFilterRulesRelatedByConcatenation[] = $obj;
                        }
                    }
                }

                $this->collItemFilterRulesRelatedByConcatenation = $collItemFilterRulesRelatedByConcatenation;
                $this->collItemFilterRulesRelatedByConcatenationPartial = false;
            }
        }

        return $this->collItemFilterRulesRelatedByConcatenation;
    }

    /**
     * Sets a collection of ChildItemFilterRule objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $itemFilterRulesRelatedByConcatenation A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function setItemFilterRulesRelatedByConcatenation(Collection $itemFilterRulesRelatedByConcatenation, ConnectionInterface $con = null)
    {
        /** @var ChildItemFilterRule[] $itemFilterRulesRelatedByConcatenationToDelete */
        $itemFilterRulesRelatedByConcatenationToDelete = $this->getItemFilterRulesRelatedByConcatenation(new Criteria(), $con)->diff($itemFilterRulesRelatedByConcatenation);

        
        $this->itemFilterRulesRelatedByConcatenationScheduledForDeletion = $itemFilterRulesRelatedByConcatenationToDelete;

        foreach ($itemFilterRulesRelatedByConcatenationToDelete as $itemFilterRuleRelatedByConcatenationRemoved) {
            $itemFilterRuleRelatedByConcatenationRemoved->setconcatenationObj(null);
        }

        $this->collItemFilterRulesRelatedByConcatenation = null;
        foreach ($itemFilterRulesRelatedByConcatenation as $itemFilterRuleRelatedByConcatenation) {
            $this->addItemFilterRuleRelatedByConcatenation($itemFilterRuleRelatedByConcatenation);
        }

        $this->collItemFilterRulesRelatedByConcatenation = $itemFilterRulesRelatedByConcatenation;
        $this->collItemFilterRulesRelatedByConcatenationPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ItemFilterRule objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ItemFilterRule objects.
     * @throws PropelException
     */
    public function countItemFilterRulesRelatedByConcatenation(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collItemFilterRulesRelatedByConcatenationPartial && !$this->isNew();
        if (null === $this->collItemFilterRulesRelatedByConcatenation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collItemFilterRulesRelatedByConcatenation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getItemFilterRulesRelatedByConcatenation());
            }

            $query = ChildItemFilterRuleQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByconcatenationObj($this)
                ->count($con);
        }

        return count($this->collItemFilterRulesRelatedByConcatenation);
    }

    /**
     * Method called to associate a ChildItemFilterRule object to this object
     * through the ChildItemFilterRule foreign key attribute.
     *
     * @param  ChildItemFilterRule $l ChildItemFilterRule
     * @return $this|\ECP\Comparison The current object (for fluent API support)
     */
    public function addItemFilterRuleRelatedByConcatenation(ChildItemFilterRule $l)
    {
        if ($this->collItemFilterRulesRelatedByConcatenation === null) {
            $this->initItemFilterRulesRelatedByConcatenation();
            $this->collItemFilterRulesRelatedByConcatenationPartial = true;
        }

        if (!$this->collItemFilterRulesRelatedByConcatenation->contains($l)) {
            $this->doAddItemFilterRuleRelatedByConcatenation($l);
        }

        return $this;
    }

    /**
     * @param ChildItemFilterRule $itemFilterRuleRelatedByConcatenation The ChildItemFilterRule object to add.
     */
    protected function doAddItemFilterRuleRelatedByConcatenation(ChildItemFilterRule $itemFilterRuleRelatedByConcatenation)
    {
        $this->collItemFilterRulesRelatedByConcatenation[]= $itemFilterRuleRelatedByConcatenation;
        $itemFilterRuleRelatedByConcatenation->setconcatenationObj($this);
    }

    /**
     * @param  ChildItemFilterRule $itemFilterRuleRelatedByConcatenation The ChildItemFilterRule object to remove.
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function removeItemFilterRuleRelatedByConcatenation(ChildItemFilterRule $itemFilterRuleRelatedByConcatenation)
    {
        if ($this->getItemFilterRulesRelatedByConcatenation()->contains($itemFilterRuleRelatedByConcatenation)) {
            $pos = $this->collItemFilterRulesRelatedByConcatenation->search($itemFilterRuleRelatedByConcatenation);
            $this->collItemFilterRulesRelatedByConcatenation->remove($pos);
            if (null === $this->itemFilterRulesRelatedByConcatenationScheduledForDeletion) {
                $this->itemFilterRulesRelatedByConcatenationScheduledForDeletion = clone $this->collItemFilterRulesRelatedByConcatenation;
                $this->itemFilterRulesRelatedByConcatenationScheduledForDeletion->clear();
            }
            $this->itemFilterRulesRelatedByConcatenationScheduledForDeletion[]= $itemFilterRuleRelatedByConcatenation;
            $itemFilterRuleRelatedByConcatenation->setconcatenationObj(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comparison is new, it will return
     * an empty collection; or if this Comparison has previously
     * been saved, it will retrieve related ItemFilterRulesRelatedByConcatenation from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comparison.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildItemFilterRule[] List of ChildItemFilterRule objects
     */
    public function getItemFilterRulesRelatedByConcatenationJoinFittingRuleRow(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildItemFilterRuleQuery::create(null, $criteria);
        $query->joinWith('FittingRuleRow', $joinBehavior);

        return $this->getItemFilterRulesRelatedByConcatenation($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comparison is new, it will return
     * an empty collection; or if this Comparison has previously
     * been saved, it will retrieve related ItemFilterRulesRelatedByConcatenation from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comparison.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildItemFilterRule[] List of ChildItemFilterRule objects
     */
    public function getItemFilterRulesRelatedByConcatenationJoinItemFilterDef(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildItemFilterRuleQuery::create(null, $criteria);
        $query->joinWith('ItemFilterDef', $joinBehavior);

        return $this->getItemFilterRulesRelatedByConcatenation($query, $con);
    }

    /**
     * Clears out the collItemFilterRulesRelatedByComparison collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addItemFilterRulesRelatedByComparison()
     */
    public function clearItemFilterRulesRelatedByComparison()
    {
        $this->collItemFilterRulesRelatedByComparison = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collItemFilterRulesRelatedByComparison collection loaded partially.
     */
    public function resetPartialItemFilterRulesRelatedByComparison($v = true)
    {
        $this->collItemFilterRulesRelatedByComparisonPartial = $v;
    }

    /**
     * Initializes the collItemFilterRulesRelatedByComparison collection.
     *
     * By default this just sets the collItemFilterRulesRelatedByComparison collection to an empty array (like clearcollItemFilterRulesRelatedByComparison());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initItemFilterRulesRelatedByComparison($overrideExisting = true)
    {
        if (null !== $this->collItemFilterRulesRelatedByComparison && !$overrideExisting) {
            return;
        }
        $this->collItemFilterRulesRelatedByComparison = new ObjectCollection();
        $this->collItemFilterRulesRelatedByComparison->setModel('\ECP\ItemFilterRule');
    }

    /**
     * Gets an array of ChildItemFilterRule objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildComparison is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildItemFilterRule[] List of ChildItemFilterRule objects
     * @throws PropelException
     */
    public function getItemFilterRulesRelatedByComparison(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collItemFilterRulesRelatedByComparisonPartial && !$this->isNew();
        if (null === $this->collItemFilterRulesRelatedByComparison || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collItemFilterRulesRelatedByComparison) {
                // return empty collection
                $this->initItemFilterRulesRelatedByComparison();
            } else {
                $collItemFilterRulesRelatedByComparison = ChildItemFilterRuleQuery::create(null, $criteria)
                    ->filterBycomparisonObj($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collItemFilterRulesRelatedByComparisonPartial && count($collItemFilterRulesRelatedByComparison)) {
                        $this->initItemFilterRulesRelatedByComparison(false);

                        foreach ($collItemFilterRulesRelatedByComparison as $obj) {
                            if (false == $this->collItemFilterRulesRelatedByComparison->contains($obj)) {
                                $this->collItemFilterRulesRelatedByComparison->append($obj);
                            }
                        }

                        $this->collItemFilterRulesRelatedByComparisonPartial = true;
                    }

                    return $collItemFilterRulesRelatedByComparison;
                }

                if ($partial && $this->collItemFilterRulesRelatedByComparison) {
                    foreach ($this->collItemFilterRulesRelatedByComparison as $obj) {
                        if ($obj->isNew()) {
                            $collItemFilterRulesRelatedByComparison[] = $obj;
                        }
                    }
                }

                $this->collItemFilterRulesRelatedByComparison = $collItemFilterRulesRelatedByComparison;
                $this->collItemFilterRulesRelatedByComparisonPartial = false;
            }
        }

        return $this->collItemFilterRulesRelatedByComparison;
    }

    /**
     * Sets a collection of ChildItemFilterRule objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $itemFilterRulesRelatedByComparison A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function setItemFilterRulesRelatedByComparison(Collection $itemFilterRulesRelatedByComparison, ConnectionInterface $con = null)
    {
        /** @var ChildItemFilterRule[] $itemFilterRulesRelatedByComparisonToDelete */
        $itemFilterRulesRelatedByComparisonToDelete = $this->getItemFilterRulesRelatedByComparison(new Criteria(), $con)->diff($itemFilterRulesRelatedByComparison);

        
        $this->itemFilterRulesRelatedByComparisonScheduledForDeletion = $itemFilterRulesRelatedByComparisonToDelete;

        foreach ($itemFilterRulesRelatedByComparisonToDelete as $itemFilterRuleRelatedByComparisonRemoved) {
            $itemFilterRuleRelatedByComparisonRemoved->setcomparisonObj(null);
        }

        $this->collItemFilterRulesRelatedByComparison = null;
        foreach ($itemFilterRulesRelatedByComparison as $itemFilterRuleRelatedByComparison) {
            $this->addItemFilterRuleRelatedByComparison($itemFilterRuleRelatedByComparison);
        }

        $this->collItemFilterRulesRelatedByComparison = $itemFilterRulesRelatedByComparison;
        $this->collItemFilterRulesRelatedByComparisonPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ItemFilterRule objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ItemFilterRule objects.
     * @throws PropelException
     */
    public function countItemFilterRulesRelatedByComparison(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collItemFilterRulesRelatedByComparisonPartial && !$this->isNew();
        if (null === $this->collItemFilterRulesRelatedByComparison || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collItemFilterRulesRelatedByComparison) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getItemFilterRulesRelatedByComparison());
            }

            $query = ChildItemFilterRuleQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBycomparisonObj($this)
                ->count($con);
        }

        return count($this->collItemFilterRulesRelatedByComparison);
    }

    /**
     * Method called to associate a ChildItemFilterRule object to this object
     * through the ChildItemFilterRule foreign key attribute.
     *
     * @param  ChildItemFilterRule $l ChildItemFilterRule
     * @return $this|\ECP\Comparison The current object (for fluent API support)
     */
    public function addItemFilterRuleRelatedByComparison(ChildItemFilterRule $l)
    {
        if ($this->collItemFilterRulesRelatedByComparison === null) {
            $this->initItemFilterRulesRelatedByComparison();
            $this->collItemFilterRulesRelatedByComparisonPartial = true;
        }

        if (!$this->collItemFilterRulesRelatedByComparison->contains($l)) {
            $this->doAddItemFilterRuleRelatedByComparison($l);
        }

        return $this;
    }

    /**
     * @param ChildItemFilterRule $itemFilterRuleRelatedByComparison The ChildItemFilterRule object to add.
     */
    protected function doAddItemFilterRuleRelatedByComparison(ChildItemFilterRule $itemFilterRuleRelatedByComparison)
    {
        $this->collItemFilterRulesRelatedByComparison[]= $itemFilterRuleRelatedByComparison;
        $itemFilterRuleRelatedByComparison->setcomparisonObj($this);
    }

    /**
     * @param  ChildItemFilterRule $itemFilterRuleRelatedByComparison The ChildItemFilterRule object to remove.
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function removeItemFilterRuleRelatedByComparison(ChildItemFilterRule $itemFilterRuleRelatedByComparison)
    {
        if ($this->getItemFilterRulesRelatedByComparison()->contains($itemFilterRuleRelatedByComparison)) {
            $pos = $this->collItemFilterRulesRelatedByComparison->search($itemFilterRuleRelatedByComparison);
            $this->collItemFilterRulesRelatedByComparison->remove($pos);
            if (null === $this->itemFilterRulesRelatedByComparisonScheduledForDeletion) {
                $this->itemFilterRulesRelatedByComparisonScheduledForDeletion = clone $this->collItemFilterRulesRelatedByComparison;
                $this->itemFilterRulesRelatedByComparisonScheduledForDeletion->clear();
            }
            $this->itemFilterRulesRelatedByComparisonScheduledForDeletion[]= clone $itemFilterRuleRelatedByComparison;
            $itemFilterRuleRelatedByComparison->setcomparisonObj(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comparison is new, it will return
     * an empty collection; or if this Comparison has previously
     * been saved, it will retrieve related ItemFilterRulesRelatedByComparison from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comparison.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildItemFilterRule[] List of ChildItemFilterRule objects
     */
    public function getItemFilterRulesRelatedByComparisonJoinFittingRuleRow(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildItemFilterRuleQuery::create(null, $criteria);
        $query->joinWith('FittingRuleRow', $joinBehavior);

        return $this->getItemFilterRulesRelatedByComparison($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comparison is new, it will return
     * an empty collection; or if this Comparison has previously
     * been saved, it will retrieve related ItemFilterRulesRelatedByComparison from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comparison.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildItemFilterRule[] List of ChildItemFilterRule objects
     */
    public function getItemFilterRulesRelatedByComparisonJoinItemFilterDef(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildItemFilterRuleQuery::create(null, $criteria);
        $query->joinWith('ItemFilterDef', $joinBehavior);

        return $this->getItemFilterRulesRelatedByComparison($query, $con);
    }

    /**
     * Clears out the collRulesetFilterRulesRelatedByConcatenation collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRulesetFilterRulesRelatedByConcatenation()
     */
    public function clearRulesetFilterRulesRelatedByConcatenation()
    {
        $this->collRulesetFilterRulesRelatedByConcatenation = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRulesetFilterRulesRelatedByConcatenation collection loaded partially.
     */
    public function resetPartialRulesetFilterRulesRelatedByConcatenation($v = true)
    {
        $this->collRulesetFilterRulesRelatedByConcatenationPartial = $v;
    }

    /**
     * Initializes the collRulesetFilterRulesRelatedByConcatenation collection.
     *
     * By default this just sets the collRulesetFilterRulesRelatedByConcatenation collection to an empty array (like clearcollRulesetFilterRulesRelatedByConcatenation());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRulesetFilterRulesRelatedByConcatenation($overrideExisting = true)
    {
        if (null !== $this->collRulesetFilterRulesRelatedByConcatenation && !$overrideExisting) {
            return;
        }
        $this->collRulesetFilterRulesRelatedByConcatenation = new ObjectCollection();
        $this->collRulesetFilterRulesRelatedByConcatenation->setModel('\ECP\RulesetFilterRule');
    }

    /**
     * Gets an array of ChildRulesetFilterRule objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildComparison is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRulesetFilterRule[] List of ChildRulesetFilterRule objects
     * @throws PropelException
     */
    public function getRulesetFilterRulesRelatedByConcatenation(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRulesetFilterRulesRelatedByConcatenationPartial && !$this->isNew();
        if (null === $this->collRulesetFilterRulesRelatedByConcatenation || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRulesetFilterRulesRelatedByConcatenation) {
                // return empty collection
                $this->initRulesetFilterRulesRelatedByConcatenation();
            } else {
                $collRulesetFilterRulesRelatedByConcatenation = ChildRulesetFilterRuleQuery::create(null, $criteria)
                    ->filterByconcatenationObj($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRulesetFilterRulesRelatedByConcatenationPartial && count($collRulesetFilterRulesRelatedByConcatenation)) {
                        $this->initRulesetFilterRulesRelatedByConcatenation(false);

                        foreach ($collRulesetFilterRulesRelatedByConcatenation as $obj) {
                            if (false == $this->collRulesetFilterRulesRelatedByConcatenation->contains($obj)) {
                                $this->collRulesetFilterRulesRelatedByConcatenation->append($obj);
                            }
                        }

                        $this->collRulesetFilterRulesRelatedByConcatenationPartial = true;
                    }

                    return $collRulesetFilterRulesRelatedByConcatenation;
                }

                if ($partial && $this->collRulesetFilterRulesRelatedByConcatenation) {
                    foreach ($this->collRulesetFilterRulesRelatedByConcatenation as $obj) {
                        if ($obj->isNew()) {
                            $collRulesetFilterRulesRelatedByConcatenation[] = $obj;
                        }
                    }
                }

                $this->collRulesetFilterRulesRelatedByConcatenation = $collRulesetFilterRulesRelatedByConcatenation;
                $this->collRulesetFilterRulesRelatedByConcatenationPartial = false;
            }
        }

        return $this->collRulesetFilterRulesRelatedByConcatenation;
    }

    /**
     * Sets a collection of ChildRulesetFilterRule objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rulesetFilterRulesRelatedByConcatenation A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function setRulesetFilterRulesRelatedByConcatenation(Collection $rulesetFilterRulesRelatedByConcatenation, ConnectionInterface $con = null)
    {
        /** @var ChildRulesetFilterRule[] $rulesetFilterRulesRelatedByConcatenationToDelete */
        $rulesetFilterRulesRelatedByConcatenationToDelete = $this->getRulesetFilterRulesRelatedByConcatenation(new Criteria(), $con)->diff($rulesetFilterRulesRelatedByConcatenation);

        
        $this->rulesetFilterRulesRelatedByConcatenationScheduledForDeletion = $rulesetFilterRulesRelatedByConcatenationToDelete;

        foreach ($rulesetFilterRulesRelatedByConcatenationToDelete as $rulesetFilterRuleRelatedByConcatenationRemoved) {
            $rulesetFilterRuleRelatedByConcatenationRemoved->setconcatenationObj(null);
        }

        $this->collRulesetFilterRulesRelatedByConcatenation = null;
        foreach ($rulesetFilterRulesRelatedByConcatenation as $rulesetFilterRuleRelatedByConcatenation) {
            $this->addRulesetFilterRuleRelatedByConcatenation($rulesetFilterRuleRelatedByConcatenation);
        }

        $this->collRulesetFilterRulesRelatedByConcatenation = $rulesetFilterRulesRelatedByConcatenation;
        $this->collRulesetFilterRulesRelatedByConcatenationPartial = false;

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
    public function countRulesetFilterRulesRelatedByConcatenation(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRulesetFilterRulesRelatedByConcatenationPartial && !$this->isNew();
        if (null === $this->collRulesetFilterRulesRelatedByConcatenation || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRulesetFilterRulesRelatedByConcatenation) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRulesetFilterRulesRelatedByConcatenation());
            }

            $query = ChildRulesetFilterRuleQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByconcatenationObj($this)
                ->count($con);
        }

        return count($this->collRulesetFilterRulesRelatedByConcatenation);
    }

    /**
     * Method called to associate a ChildRulesetFilterRule object to this object
     * through the ChildRulesetFilterRule foreign key attribute.
     *
     * @param  ChildRulesetFilterRule $l ChildRulesetFilterRule
     * @return $this|\ECP\Comparison The current object (for fluent API support)
     */
    public function addRulesetFilterRuleRelatedByConcatenation(ChildRulesetFilterRule $l)
    {
        if ($this->collRulesetFilterRulesRelatedByConcatenation === null) {
            $this->initRulesetFilterRulesRelatedByConcatenation();
            $this->collRulesetFilterRulesRelatedByConcatenationPartial = true;
        }

        if (!$this->collRulesetFilterRulesRelatedByConcatenation->contains($l)) {
            $this->doAddRulesetFilterRuleRelatedByConcatenation($l);
        }

        return $this;
    }

    /**
     * @param ChildRulesetFilterRule $rulesetFilterRuleRelatedByConcatenation The ChildRulesetFilterRule object to add.
     */
    protected function doAddRulesetFilterRuleRelatedByConcatenation(ChildRulesetFilterRule $rulesetFilterRuleRelatedByConcatenation)
    {
        $this->collRulesetFilterRulesRelatedByConcatenation[]= $rulesetFilterRuleRelatedByConcatenation;
        $rulesetFilterRuleRelatedByConcatenation->setconcatenationObj($this);
    }

    /**
     * @param  ChildRulesetFilterRule $rulesetFilterRuleRelatedByConcatenation The ChildRulesetFilterRule object to remove.
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function removeRulesetFilterRuleRelatedByConcatenation(ChildRulesetFilterRule $rulesetFilterRuleRelatedByConcatenation)
    {
        if ($this->getRulesetFilterRulesRelatedByConcatenation()->contains($rulesetFilterRuleRelatedByConcatenation)) {
            $pos = $this->collRulesetFilterRulesRelatedByConcatenation->search($rulesetFilterRuleRelatedByConcatenation);
            $this->collRulesetFilterRulesRelatedByConcatenation->remove($pos);
            if (null === $this->rulesetFilterRulesRelatedByConcatenationScheduledForDeletion) {
                $this->rulesetFilterRulesRelatedByConcatenationScheduledForDeletion = clone $this->collRulesetFilterRulesRelatedByConcatenation;
                $this->rulesetFilterRulesRelatedByConcatenationScheduledForDeletion->clear();
            }
            $this->rulesetFilterRulesRelatedByConcatenationScheduledForDeletion[]= $rulesetFilterRuleRelatedByConcatenation;
            $rulesetFilterRuleRelatedByConcatenation->setconcatenationObj(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comparison is new, it will return
     * an empty collection; or if this Comparison has previously
     * been saved, it will retrieve related RulesetFilterRulesRelatedByConcatenation from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comparison.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRulesetFilterRule[] List of ChildRulesetFilterRule objects
     */
    public function getRulesetFilterRulesRelatedByConcatenationJoinRulesetRuleRow(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRulesetFilterRuleQuery::create(null, $criteria);
        $query->joinWith('RulesetRuleRow', $joinBehavior);

        return $this->getRulesetFilterRulesRelatedByConcatenation($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comparison is new, it will return
     * an empty collection; or if this Comparison has previously
     * been saved, it will retrieve related RulesetFilterRulesRelatedByConcatenation from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comparison.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRulesetFilterRule[] List of ChildRulesetFilterRule objects
     */
    public function getRulesetFilterRulesRelatedByConcatenationJoinFittingRuleEntity(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRulesetFilterRuleQuery::create(null, $criteria);
        $query->joinWith('FittingRuleEntity', $joinBehavior);

        return $this->getRulesetFilterRulesRelatedByConcatenation($query, $con);
    }

    /**
     * Clears out the collRulesetFilterRulesRelatedByComparison collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRulesetFilterRulesRelatedByComparison()
     */
    public function clearRulesetFilterRulesRelatedByComparison()
    {
        $this->collRulesetFilterRulesRelatedByComparison = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRulesetFilterRulesRelatedByComparison collection loaded partially.
     */
    public function resetPartialRulesetFilterRulesRelatedByComparison($v = true)
    {
        $this->collRulesetFilterRulesRelatedByComparisonPartial = $v;
    }

    /**
     * Initializes the collRulesetFilterRulesRelatedByComparison collection.
     *
     * By default this just sets the collRulesetFilterRulesRelatedByComparison collection to an empty array (like clearcollRulesetFilterRulesRelatedByComparison());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRulesetFilterRulesRelatedByComparison($overrideExisting = true)
    {
        if (null !== $this->collRulesetFilterRulesRelatedByComparison && !$overrideExisting) {
            return;
        }
        $this->collRulesetFilterRulesRelatedByComparison = new ObjectCollection();
        $this->collRulesetFilterRulesRelatedByComparison->setModel('\ECP\RulesetFilterRule');
    }

    /**
     * Gets an array of ChildRulesetFilterRule objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildComparison is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRulesetFilterRule[] List of ChildRulesetFilterRule objects
     * @throws PropelException
     */
    public function getRulesetFilterRulesRelatedByComparison(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRulesetFilterRulesRelatedByComparisonPartial && !$this->isNew();
        if (null === $this->collRulesetFilterRulesRelatedByComparison || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRulesetFilterRulesRelatedByComparison) {
                // return empty collection
                $this->initRulesetFilterRulesRelatedByComparison();
            } else {
                $collRulesetFilterRulesRelatedByComparison = ChildRulesetFilterRuleQuery::create(null, $criteria)
                    ->filterBycomparisonObj($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRulesetFilterRulesRelatedByComparisonPartial && count($collRulesetFilterRulesRelatedByComparison)) {
                        $this->initRulesetFilterRulesRelatedByComparison(false);

                        foreach ($collRulesetFilterRulesRelatedByComparison as $obj) {
                            if (false == $this->collRulesetFilterRulesRelatedByComparison->contains($obj)) {
                                $this->collRulesetFilterRulesRelatedByComparison->append($obj);
                            }
                        }

                        $this->collRulesetFilterRulesRelatedByComparisonPartial = true;
                    }

                    return $collRulesetFilterRulesRelatedByComparison;
                }

                if ($partial && $this->collRulesetFilterRulesRelatedByComparison) {
                    foreach ($this->collRulesetFilterRulesRelatedByComparison as $obj) {
                        if ($obj->isNew()) {
                            $collRulesetFilterRulesRelatedByComparison[] = $obj;
                        }
                    }
                }

                $this->collRulesetFilterRulesRelatedByComparison = $collRulesetFilterRulesRelatedByComparison;
                $this->collRulesetFilterRulesRelatedByComparisonPartial = false;
            }
        }

        return $this->collRulesetFilterRulesRelatedByComparison;
    }

    /**
     * Sets a collection of ChildRulesetFilterRule objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rulesetFilterRulesRelatedByComparison A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function setRulesetFilterRulesRelatedByComparison(Collection $rulesetFilterRulesRelatedByComparison, ConnectionInterface $con = null)
    {
        /** @var ChildRulesetFilterRule[] $rulesetFilterRulesRelatedByComparisonToDelete */
        $rulesetFilterRulesRelatedByComparisonToDelete = $this->getRulesetFilterRulesRelatedByComparison(new Criteria(), $con)->diff($rulesetFilterRulesRelatedByComparison);

        
        $this->rulesetFilterRulesRelatedByComparisonScheduledForDeletion = $rulesetFilterRulesRelatedByComparisonToDelete;

        foreach ($rulesetFilterRulesRelatedByComparisonToDelete as $rulesetFilterRuleRelatedByComparisonRemoved) {
            $rulesetFilterRuleRelatedByComparisonRemoved->setcomparisonObj(null);
        }

        $this->collRulesetFilterRulesRelatedByComparison = null;
        foreach ($rulesetFilterRulesRelatedByComparison as $rulesetFilterRuleRelatedByComparison) {
            $this->addRulesetFilterRuleRelatedByComparison($rulesetFilterRuleRelatedByComparison);
        }

        $this->collRulesetFilterRulesRelatedByComparison = $rulesetFilterRulesRelatedByComparison;
        $this->collRulesetFilterRulesRelatedByComparisonPartial = false;

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
    public function countRulesetFilterRulesRelatedByComparison(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRulesetFilterRulesRelatedByComparisonPartial && !$this->isNew();
        if (null === $this->collRulesetFilterRulesRelatedByComparison || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRulesetFilterRulesRelatedByComparison) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRulesetFilterRulesRelatedByComparison());
            }

            $query = ChildRulesetFilterRuleQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBycomparisonObj($this)
                ->count($con);
        }

        return count($this->collRulesetFilterRulesRelatedByComparison);
    }

    /**
     * Method called to associate a ChildRulesetFilterRule object to this object
     * through the ChildRulesetFilterRule foreign key attribute.
     *
     * @param  ChildRulesetFilterRule $l ChildRulesetFilterRule
     * @return $this|\ECP\Comparison The current object (for fluent API support)
     */
    public function addRulesetFilterRuleRelatedByComparison(ChildRulesetFilterRule $l)
    {
        if ($this->collRulesetFilterRulesRelatedByComparison === null) {
            $this->initRulesetFilterRulesRelatedByComparison();
            $this->collRulesetFilterRulesRelatedByComparisonPartial = true;
        }

        if (!$this->collRulesetFilterRulesRelatedByComparison->contains($l)) {
            $this->doAddRulesetFilterRuleRelatedByComparison($l);
        }

        return $this;
    }

    /**
     * @param ChildRulesetFilterRule $rulesetFilterRuleRelatedByComparison The ChildRulesetFilterRule object to add.
     */
    protected function doAddRulesetFilterRuleRelatedByComparison(ChildRulesetFilterRule $rulesetFilterRuleRelatedByComparison)
    {
        $this->collRulesetFilterRulesRelatedByComparison[]= $rulesetFilterRuleRelatedByComparison;
        $rulesetFilterRuleRelatedByComparison->setcomparisonObj($this);
    }

    /**
     * @param  ChildRulesetFilterRule $rulesetFilterRuleRelatedByComparison The ChildRulesetFilterRule object to remove.
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function removeRulesetFilterRuleRelatedByComparison(ChildRulesetFilterRule $rulesetFilterRuleRelatedByComparison)
    {
        if ($this->getRulesetFilterRulesRelatedByComparison()->contains($rulesetFilterRuleRelatedByComparison)) {
            $pos = $this->collRulesetFilterRulesRelatedByComparison->search($rulesetFilterRuleRelatedByComparison);
            $this->collRulesetFilterRulesRelatedByComparison->remove($pos);
            if (null === $this->rulesetFilterRulesRelatedByComparisonScheduledForDeletion) {
                $this->rulesetFilterRulesRelatedByComparisonScheduledForDeletion = clone $this->collRulesetFilterRulesRelatedByComparison;
                $this->rulesetFilterRulesRelatedByComparisonScheduledForDeletion->clear();
            }
            $this->rulesetFilterRulesRelatedByComparisonScheduledForDeletion[]= clone $rulesetFilterRuleRelatedByComparison;
            $rulesetFilterRuleRelatedByComparison->setcomparisonObj(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comparison is new, it will return
     * an empty collection; or if this Comparison has previously
     * been saved, it will retrieve related RulesetFilterRulesRelatedByComparison from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comparison.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRulesetFilterRule[] List of ChildRulesetFilterRule objects
     */
    public function getRulesetFilterRulesRelatedByComparisonJoinRulesetRuleRow(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRulesetFilterRuleQuery::create(null, $criteria);
        $query->joinWith('RulesetRuleRow', $joinBehavior);

        return $this->getRulesetFilterRulesRelatedByComparison($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comparison is new, it will return
     * an empty collection; or if this Comparison has previously
     * been saved, it will retrieve related RulesetFilterRulesRelatedByComparison from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comparison.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRulesetFilterRule[] List of ChildRulesetFilterRule objects
     */
    public function getRulesetFilterRulesRelatedByComparisonJoinFittingRuleEntity(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRulesetFilterRuleQuery::create(null, $criteria);
        $query->joinWith('FittingRuleEntity', $joinBehavior);

        return $this->getRulesetFilterRulesRelatedByComparison($query, $con);
    }

    /**
     * Clears out the collTypeIds collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTypeIds()
     */
    public function clearTypeIds()
    {
        $this->collTypeIds = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the combinationCollTypeIds crossRef collection.
     *
     * By default this just sets the combinationCollTypeIds collection to an empty collection (like clearTypeIds());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initTypeIds()
    {
        $this->combinationCollTypeIds = new ObjectCombinationCollection();
        $this->combinationCollTypeIdsPartial = true;

    }

    /**
     * Checks if the combinationCollTypeIds collection is loaded.
     *
     * @return bool
     */
    public function isTypeIdsLoaded()
    {
        return null !== $this->combinationCollTypeIds;
    }

    /**
     * Returns a new query object pre configured with filters from current object and given arguments to query the database.
     * 
     * @param int $id
     * @param Criteria $criteria
     *
     * @return ChildTypeQuery
     */
    public function createTypesQuery($id = null, Criteria $criteria = null)
    {
        $criteria = ChildTypeQuery::create($criteria)
            ->filterByComparison($this);

        $typeComparisonQuery = $criteria->useTypeComparisonQuery();

        if (null !== $id) {
            $typeComparisonQuery->filterById($id);
        }
            
        $typeComparisonQuery->endUse();

        return $criteria;
    }

    /**
     * Gets a combined collection of ChildType objects related by a many-to-many relationship
     * to the current object by way of the typecomparison cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildComparison is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCombinationCollection Combination list of ChildType objects
     */
    public function getTypeIds($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->combinationCollTypeIdsPartial && !$this->isNew();
        if (null === $this->combinationCollTypeIds || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->combinationCollTypeIds) {
                    $this->initTypeIds();
                }
            } else {

                $query = ChildTypeComparisonQuery::create(null, $criteria)
                    ->filterByComparison($this)
                    ->joinType()
                ;

                $items = $query->find($con);
                $combinationCollTypeIds = new ObjectCombinationCollection();
                foreach ($items as $item) {
                    $combination = [];

                    $combination[] = $item->getType();
                    $combination[] = $item->getId();
                    $combinationCollTypeIds[] = $combination;
                }

                if (null !== $criteria) {
                    return $combinationCollTypeIds;
                }

                if ($partial && $this->combinationCollTypeIds) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->combinationCollTypeIds as $obj) {
                        if (!call_user_func_array([$combinationCollTypeIds, 'contains'], $obj)) {
                            $combinationCollTypeIds[] = $obj;
                        }
                    }
                }

                $this->combinationCollTypeIds = $combinationCollTypeIds;
                $this->combinationCollTypeIdsPartial = false;
            }
        }

        return $this->combinationCollTypeIds;
    }

    /**
     * Returns a not cached ObjectCollection of ChildType objects. This will hit always the databases.
     * If you have attached new ChildType object to this object you need to call `save` first to get
     * the correct return value. Use getTypeIds() to get the current internal state.
     * 
     * @param int $id
     * @param Criteria $criteria
     * @param ConnectionInterface $con
     *
     * @return ChildType[]|ObjectCollection
     */
    public function getTypes($id = null, Criteria $criteria = null, ConnectionInterface $con = null)
    {
        return $this->createTypesQuery($id, $criteria)->find($con);
    }

    /**
     * Sets a collection of ChildType objects related by a many-to-many relationship
     * to the current object by way of the typecomparison cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $typeIds A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildComparison The current object (for fluent API support)
     */
    public function setTypeIds(Collection $typeIds, ConnectionInterface $con = null)
    {
        $this->clearTypeIds();
        $currentTypeIds = $this->getTypeIds();

        $combinationCollTypeIdsScheduledForDeletion = $currentTypeIds->diff($typeIds);

        foreach ($combinationCollTypeIdsScheduledForDeletion as $toDelete) {
            call_user_func_array([$this, 'removeTypeId'], $toDelete);
        }

        foreach ($typeIds as $typeId) {
            if (!call_user_func_array([$currentTypeIds, 'contains'], $typeId)) {
                call_user_func_array([$this, 'doAddTypeId'], $typeId);
            }
        }

        $this->combinationCollTypeIdsPartial = false;
        $this->combinationCollTypeIds = $typeIds;

        return $this;
    }

    /**
     * Gets the number of ChildType objects related by a many-to-many relationship
     * to the current object by way of the typecomparison cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related ChildType objects
     */
    public function countTypeIds(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->combinationCollTypeIdsPartial && !$this->isNew();
        if (null === $this->combinationCollTypeIds || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->combinationCollTypeIds) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getTypeIds());
                }

                $query = ChildTypeComparisonQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByComparison($this)
                    ->count($con);
            }
        } else {
            return count($this->combinationCollTypeIds);
        }
    }

    /**
     * Returns the not cached count of ChildType objects. This will hit always the databases.
     * If you have attached new ChildType object to this object you need to call `save` first to get
     * the correct return value. Use getTypeIds() to get the current internal state.
     * 
     * @param int $id
     * @param Criteria $criteria
     * @param ConnectionInterface $con
     *
     * @return integer
     */
    public function countTypes($id = null, Criteria $criteria = null, ConnectionInterface $con = null)
    {
        return $this->createTypesQuery($id, $criteria)->count($con);
    }

    /**
     * Associate a ChildType to this object
     * through the typecomparison cross reference table.
     * 
     * @param ChildType $type, 
     * @param int $id
     * @return ChildComparison The current object (for fluent API support)
     */
    public function addType(ChildType $type, $id)
    {
        if ($this->combinationCollTypeIds === null) {
            $this->initTypeIds();
        }

        if (!$this->getTypeIds()->contains($type, $id)) {
            // only add it if the **same** object is not already associated
            $this->combinationCollTypeIds->push($type, $id);
            $this->doAddTypeId($type, $id);
        }

        return $this;
    }

    /**
     * 
     * @param ChildType $type, 
     * @param int $id
     */
    protected function doAddTypeId(ChildType $type, $id)
    {
        $typeComparison = new ChildTypeComparison();

        $typeComparison->setType($type);
        $typeComparison->setId($id);


        $typeComparison->setComparison($this);

        $this->addTypeComparison($typeComparison);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if ($type->isComparisonIdsLoaded()) {
            $type->initComparisonIds();
            $type->getComparisonIds()->push($this, $id);
        } elseif (!$type->getComparisonIds()->contains($this, $id)) {
            $type->getComparisonIds()->push($this, $id);
        }

    }

    /**
     * Remove type, id of this object
     * through the typecomparison cross reference table.
     * 
     * @param ChildType $type, 
     * @param int $id
     * @return ChildComparison The current object (for fluent API support)
     */
    public function removeTypeId(ChildType $type, $id)
    {
        if ($this->getTypeIds()->contains($type, $id)) { $typeComparison = new ChildTypeComparison();

            $typeComparison->setType($type);
            if ($type->isComparisonIdsLoaded()) {
                //remove the back reference if available
                $type->getComparisonIds()->removeObject($this, $id);
            }

            $typeComparison->setId($id);
            $typeComparison->setComparison($this);
            $this->removeTypeComparison(clone $typeComparison);
            $typeComparison->clear();

            $this->combinationCollTypeIds->remove($this->combinationCollTypeIds->search($type, $id));
            
            if (null === $this->combinationCollTypeIdsScheduledForDeletion) {
                $this->combinationCollTypeIdsScheduledForDeletion = clone $this->combinationCollTypeIds;
                $this->combinationCollTypeIdsScheduledForDeletion->clear();
            }

            $this->combinationCollTypeIdsScheduledForDeletion->push($type, $id);
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
        $this->id = null;
        $this->name = null;
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
            if ($this->collTypeComparisons) {
                foreach ($this->collTypeComparisons as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFittingRuleRowsRelatedByConcatenation) {
                foreach ($this->collFittingRuleRowsRelatedByConcatenation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFittingRuleRowsRelatedByComparison) {
                foreach ($this->collFittingRuleRowsRelatedByComparison as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collItemFilterRulesRelatedByConcatenation) {
                foreach ($this->collItemFilterRulesRelatedByConcatenation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collItemFilterRulesRelatedByComparison) {
                foreach ($this->collItemFilterRulesRelatedByComparison as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRulesetFilterRulesRelatedByConcatenation) {
                foreach ($this->collRulesetFilterRulesRelatedByConcatenation as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRulesetFilterRulesRelatedByComparison) {
                foreach ($this->collRulesetFilterRulesRelatedByComparison as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->combinationCollTypeIds) {
                foreach ($this->combinationCollTypeIds as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collTypeComparisons = null;
        $this->collFittingRuleRowsRelatedByConcatenation = null;
        $this->collFittingRuleRowsRelatedByComparison = null;
        $this->collItemFilterRulesRelatedByConcatenation = null;
        $this->collItemFilterRulesRelatedByComparison = null;
        $this->collRulesetFilterRulesRelatedByConcatenation = null;
        $this->collRulesetFilterRulesRelatedByComparison = null;
        $this->combinationCollTypeIds = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ComparisonTableMap::DEFAULT_STRING_FORMAT);
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
