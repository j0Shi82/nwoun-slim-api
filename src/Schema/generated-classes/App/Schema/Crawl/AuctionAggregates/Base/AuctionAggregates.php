<?php

namespace App\Schema\Crawl\AuctionAggregates\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery as ChildAuctionAggregatesQuery;
use App\Schema\Crawl\AuctionAggregates\Map\AuctionAggregatesTableMap;
use App\Schema\Crawl\AuctionItems\AuctionItems;
use App\Schema\Crawl\AuctionItems\AuctionItemsQuery;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'auction_aggregates' table.
 *
 *
 *
 * @package    propel.generator.App.Schema.Crawl.AuctionAggregates.Base
 */
abstract class AuctionAggregates implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\App\\Schema\\Crawl\\AuctionAggregates\\Map\\AuctionAggregatesTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var bool
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var bool
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = [];

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = [];

    /**
     * The value for the item_def field.
     *
     * @var        string
     */
    protected $item_def;

    /**
     * The value for the server field.
     *
     * @var        string
     */
    protected $server;

    /**
     * The value for the low field.
     *
     * @var        int
     */
    protected $low;

    /**
     * The value for the mean field.
     *
     * @var        double
     */
    protected $mean;

    /**
     * The value for the median field.
     *
     * @var        double
     */
    protected $median;

    /**
     * The value for the count field.
     *
     * @var        int
     */
    protected $count;

    /**
     * The value for the inserted field.
     *
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        DateTime
     */
    protected $inserted;

    /**
     * @var        AuctionItems
     */
    protected $aAuctionItems;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues(): void
    {
    }

    /**
     * Initializes internal state of App\Schema\Crawl\AuctionAggregates\Base\AuctionAggregates object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return bool True if the object has been modified.
     */
    public function isModified(): bool
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param string $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return bool True if $col has been modified.
     */
    public function isColumnModified(string $col): bool
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns(): array
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return bool True, if the object has never been persisted.
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param bool $b the state of the object.
     */
    public function setNew(bool $b): void
    {
        $this->new = $b;
    }

    /**
     * Whether this object has been deleted.
     * @return bool The deleted state of this object.
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param bool $b The deleted state of this object.
     * @return void
     */
    public function setDeleted(bool $b): void
    {
        $this->deleted = $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified(?string $col = null): void
    {
        if (null !== $col) {
            unset($this->modifiedColumns[$col]);
        } else {
            $this->modifiedColumns = [];
        }
    }

    /**
     * Compares this with another <code>AuctionAggregates</code> instance.  If
     * <code>obj</code> is an instance of <code>AuctionAggregates</code>, delegates to
     * <code>equals(AuctionAggregates)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param mixed $obj The object to compare to.
     * @return bool Whether equal to the object specified.
     */
    public function equals($obj): bool
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
    public function getVirtualColumns(): array
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return bool
     */
    public function hasVirtualColumn(string $name): bool
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return mixed
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getVirtualColumn(string $name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of nonexistent virtual column `%s`.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @param mixed $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn(string $name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param string $msg
     * @param int $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log(string $msg, int $priority = Propel::LOG_INFO): void
    {
        Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param \Propel\Runtime\Parser\AbstractParser|string $parser An AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME, TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM. Defaults to TableMap::TYPE_PHPNAME.
     * @return string The exported data
     */
    public function exportTo($parser, bool $includeLazyLoadColumns = true, string $keyType = TableMap::TYPE_PHPNAME): string
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     *
     * @return array<string>
     */
    public function __sleep(): array
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [item_def] column value.
     *
     * @return string
     */
    public function getItemDef()
    {
        return $this->item_def;
    }

    /**
     * Get the [server] column value.
     *
     * @return string
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Get the [low] column value.
     *
     * @return int
     */
    public function getLow()
    {
        return $this->low;
    }

    /**
     * Get the [mean] column value.
     *
     * @return double
     */
    public function getMean()
    {
        return $this->mean;
    }

    /**
     * Get the [median] column value.
     *
     * @return double
     */
    public function getMedian()
    {
        return $this->median;
    }

    /**
     * Get the [count] column value.
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Get the [optionally formatted] temporal [inserted] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), and 0 if column value is 0000-00-00 00:00:00.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime : string)
     */
    public function getInserted($format = null)
    {
        if ($format === null) {
            return $this->inserted;
        } else {
            return $this->inserted instanceof \DateTimeInterface ? $this->inserted->format($format) : null;
        }
    }

    /**
     * Set the value of [item_def] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setItemDef($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_def !== $v) {
            $this->item_def = $v;
            $this->modifiedColumns[AuctionAggregatesTableMap::COL_ITEM_DEF] = true;
        }

        if ($this->aAuctionItems !== null && $this->aAuctionItems->getItemDef() !== $v) {
            $this->aAuctionItems = null;
        }

        return $this;
    }

    /**
     * Set the value of [server] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setServer($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->server !== $v) {
            $this->server = $v;
            $this->modifiedColumns[AuctionAggregatesTableMap::COL_SERVER] = true;
        }

        if ($this->aAuctionItems !== null && $this->aAuctionItems->getServer() !== $v) {
            $this->aAuctionItems = null;
        }

        return $this;
    }

    /**
     * Set the value of [low] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setLow($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->low !== $v) {
            $this->low = $v;
            $this->modifiedColumns[AuctionAggregatesTableMap::COL_LOW] = true;
        }

        return $this;
    }

    /**
     * Set the value of [mean] column.
     *
     * @param double $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setMean($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->mean !== $v) {
            $this->mean = $v;
            $this->modifiedColumns[AuctionAggregatesTableMap::COL_MEAN] = true;
        }

        return $this;
    }

    /**
     * Set the value of [median] column.
     *
     * @param double $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setMedian($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->median !== $v) {
            $this->median = $v;
            $this->modifiedColumns[AuctionAggregatesTableMap::COL_MEDIAN] = true;
        }

        return $this;
    }

    /**
     * Set the value of [count] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setCount($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->count !== $v) {
            $this->count = $v;
            $this->modifiedColumns[AuctionAggregatesTableMap::COL_COUNT] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [inserted] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setInserted($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->inserted !== null || $dt !== null) {
            if ($this->inserted === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->inserted->format("Y-m-d H:i:s.u")) {
                $this->inserted = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AuctionAggregatesTableMap::COL_INSERTED] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return bool Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues(): bool
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    }

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by DataFetcher->fetch().
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param bool $rehydrate Whether this object is being re-hydrated from the database.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int next starting column
     * @throws \Propel\Runtime\Exception\PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate(array $row, int $startcol = 0, bool $rehydrate = false, string $indexType = TableMap::TYPE_NUM): int
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AuctionAggregatesTableMap::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_def = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AuctionAggregatesTableMap::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)];
            $this->server = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AuctionAggregatesTableMap::translateFieldName('Low', TableMap::TYPE_PHPNAME, $indexType)];
            $this->low = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AuctionAggregatesTableMap::translateFieldName('Mean', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mean = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AuctionAggregatesTableMap::translateFieldName('Median', TableMap::TYPE_PHPNAME, $indexType)];
            $this->median = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AuctionAggregatesTableMap::translateFieldName('Count', TableMap::TYPE_PHPNAME, $indexType)];
            $this->count = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AuctionAggregatesTableMap::translateFieldName('Inserted', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->inserted = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = AuctionAggregatesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Schema\\Crawl\\AuctionAggregates\\AuctionAggregates'), 0, $e);
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
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function ensureConsistency(): void
    {
        if ($this->aAuctionItems !== null && $this->item_def !== $this->aAuctionItems->getItemDef()) {
            $this->aAuctionItems = null;
        }
        if ($this->aAuctionItems !== null && $this->server !== $this->aAuctionItems->getServer()) {
            $this->aAuctionItems = null;
        }
    }

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param bool $deep (optional) Whether to also de-associated any related objects.
     * @param ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload(bool $deep = false, ?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AuctionAggregatesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAuctionAggregatesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAuctionItems = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see AuctionAggregates::setDeleted()
     * @see AuctionAggregates::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionAggregatesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAuctionAggregatesQuery::create()
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
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    public function save(?ConnectionInterface $con = null): int
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionAggregatesTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
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
                AuctionAggregatesTableMap::addInstanceToPool($this);
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
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con): int
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aAuctionItems !== null) {
                if ($this->aAuctionItems->isModified() || $this->aAuctionItems->isNew()) {
                    $affectedRows += $this->aAuctionItems->save($con);
                }
                $this->setAuctionItems($this->aAuctionItems);
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
    }

    /**
     * Insert the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con): void
    {
        $modifiedColumns = [];
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AuctionAggregatesTableMap::COL_ITEM_DEF)) {
            $modifiedColumns[':p' . $index++]  = 'item_def';
        }
        if ($this->isColumnModified(AuctionAggregatesTableMap::COL_SERVER)) {
            $modifiedColumns[':p' . $index++]  = 'server';
        }
        if ($this->isColumnModified(AuctionAggregatesTableMap::COL_LOW)) {
            $modifiedColumns[':p' . $index++]  = 'low';
        }
        if ($this->isColumnModified(AuctionAggregatesTableMap::COL_MEAN)) {
            $modifiedColumns[':p' . $index++]  = 'mean';
        }
        if ($this->isColumnModified(AuctionAggregatesTableMap::COL_MEDIAN)) {
            $modifiedColumns[':p' . $index++]  = 'median';
        }
        if ($this->isColumnModified(AuctionAggregatesTableMap::COL_COUNT)) {
            $modifiedColumns[':p' . $index++]  = 'count';
        }
        if ($this->isColumnModified(AuctionAggregatesTableMap::COL_INSERTED)) {
            $modifiedColumns[':p' . $index++]  = 'inserted';
        }

        $sql = sprintf(
            'INSERT INTO auction_aggregates (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'item_def':
                        $stmt->bindValue($identifier, $this->item_def, PDO::PARAM_STR);

                        break;
                    case 'server':
                        $stmt->bindValue($identifier, $this->server, PDO::PARAM_STR);

                        break;
                    case 'low':
                        $stmt->bindValue($identifier, $this->low, PDO::PARAM_INT);

                        break;
                    case 'mean':
                        $stmt->bindValue($identifier, $this->mean, PDO::PARAM_STR);

                        break;
                    case 'median':
                        $stmt->bindValue($identifier, $this->median, PDO::PARAM_STR);

                        break;
                    case 'count':
                        $stmt->bindValue($identifier, $this->count, PDO::PARAM_INT);

                        break;
                    case 'inserted':
                        $stmt->bindValue($identifier, $this->inserted ? $this->inserted->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);

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
     * @param ConnectionInterface $con
     *
     * @return int Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con): int
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName(string $name, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AuctionAggregatesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos Position in XML schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition(int $pos)
    {
        switch ($pos) {
            case 0:
                return $this->getItemDef();

            case 1:
                return $this->getServer();

            case 2:
                return $this->getLow();

            case 3:
                return $this->getMean();

            case 4:
                return $this->getMedian();

            case 5:
                return $this->getCount();

            case 6:
                return $this->getInserted();

            default:
                return null;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param bool $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array An associative array containing the field names (as keys) and field values
     */
    public function toArray(string $keyType = TableMap::TYPE_PHPNAME, bool $includeLazyLoadColumns = true, array $alreadyDumpedObjects = [], bool $includeForeignObjects = false): array
    {
        if (isset($alreadyDumpedObjects['AuctionAggregates'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['AuctionAggregates'][$this->hashCode()] = true;
        $keys = AuctionAggregatesTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getItemDef(),
            $keys[1] => $this->getServer(),
            $keys[2] => $this->getLow(),
            $keys[3] => $this->getMean(),
            $keys[4] => $this->getMedian(),
            $keys[5] => $this->getCount(),
            $keys[6] => $this->getInserted(),
        ];
        if ($result[$keys[6]] instanceof \DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('Y-m-d H:i:s.u');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAuctionItems) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'auctionItems';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'auction_items';
                        break;
                    default:
                        $key = 'AuctionItems';
                }

                $result[$key] = $this->aAuctionItems->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this
     */
    public function setByName(string $name, $value, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AuctionAggregatesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        $this->setByPosition($pos, $value);

        return $this;
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return $this
     */
    public function setByPosition(int $pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setItemDef($value);
                break;
            case 1:
                $this->setServer($value);
                break;
            case 2:
                $this->setLow($value);
                break;
            case 3:
                $this->setMean($value);
                break;
            case 4:
                $this->setMedian($value);
                break;
            case 5:
                $this->setCount($value);
                break;
            case 6:
                $this->setInserted($value);
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
     * @param array $arr An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return $this
     */
    public function fromArray(array $arr, string $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = AuctionAggregatesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setItemDef($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setServer($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLow($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setMean($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setMedian($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCount($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setInserted($arr[$keys[6]]);
        }

        return $this;
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
     * @return $this The current object, for fluid interface
     */
    public function importFrom($parser, string $data, string $keyType = TableMap::TYPE_PHPNAME)
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
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria(): Criteria
    {
        $criteria = new Criteria(AuctionAggregatesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AuctionAggregatesTableMap::COL_ITEM_DEF)) {
            $criteria->add(AuctionAggregatesTableMap::COL_ITEM_DEF, $this->item_def);
        }
        if ($this->isColumnModified(AuctionAggregatesTableMap::COL_SERVER)) {
            $criteria->add(AuctionAggregatesTableMap::COL_SERVER, $this->server);
        }
        if ($this->isColumnModified(AuctionAggregatesTableMap::COL_LOW)) {
            $criteria->add(AuctionAggregatesTableMap::COL_LOW, $this->low);
        }
        if ($this->isColumnModified(AuctionAggregatesTableMap::COL_MEAN)) {
            $criteria->add(AuctionAggregatesTableMap::COL_MEAN, $this->mean);
        }
        if ($this->isColumnModified(AuctionAggregatesTableMap::COL_MEDIAN)) {
            $criteria->add(AuctionAggregatesTableMap::COL_MEDIAN, $this->median);
        }
        if ($this->isColumnModified(AuctionAggregatesTableMap::COL_COUNT)) {
            $criteria->add(AuctionAggregatesTableMap::COL_COUNT, $this->count);
        }
        if ($this->isColumnModified(AuctionAggregatesTableMap::COL_INSERTED)) {
            $criteria->add(AuctionAggregatesTableMap::COL_INSERTED, $this->inserted);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria(): Criteria
    {
        $criteria = ChildAuctionAggregatesQuery::create();
        $criteria->add(AuctionAggregatesTableMap::COL_ITEM_DEF, $this->item_def);
        $criteria->add(AuctionAggregatesTableMap::COL_SERVER, $this->server);
        $criteria->add(AuctionAggregatesTableMap::COL_INSERTED, $this->inserted);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int|string Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getItemDef() &&
            null !== $this->getServer() &&
            null !== $this->getInserted();

        $validPrimaryKeyFKs = 2;
        $primaryKeyFKs = [];

        //relation auction_aggregates_fk_ff4eb9 to table auction_items
        if ($this->aAuctionItems && $hash = spl_object_hash($this->aAuctionItems)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = [];
        $pks[0] = $this->getItemDef();
        $pks[1] = $this->getServer();
        $pks[2] = $this->getInserted();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey(array $keys): void
    {
        $this->setItemDef($keys[0]);
        $this->setServer($keys[1]);
        $this->setInserted($keys[2]);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return (null === $this->getItemDef()) && (null === $this->getServer()) && (null === $this->getInserted());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \App\Schema\Crawl\AuctionAggregates\AuctionAggregates (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setItemDef($this->getItemDef());
        $copyObj->setServer($this->getServer());
        $copyObj->setLow($this->getLow());
        $copyObj->setMean($this->getMean());
        $copyObj->setMedian($this->getMedian());
        $copyObj->setCount($this->getCount());
        $copyObj->setInserted($this->getInserted());
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
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \App\Schema\Crawl\AuctionAggregates\AuctionAggregates Clone of current object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function copy(bool $deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a AuctionItems object.
     *
     * @param AuctionItems $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setAuctionItems(AuctionItems $v = null)
    {
        if ($v === null) {
            $this->setItemDef(NULL);
        } else {
            $this->setItemDef($v->getItemDef());
        }

        if ($v === null) {
            $this->setServer(NULL);
        } else {
            $this->setServer($v->getServer());
        }

        $this->aAuctionItems = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the AuctionItems object, it will not be re-added.
        if ($v !== null) {
            $v->addAuctionAggregates($this);
        }


        return $this;
    }


    /**
     * Get the associated AuctionItems object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return AuctionItems The associated AuctionItems object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getAuctionItems(?ConnectionInterface $con = null)
    {
        if ($this->aAuctionItems === null && (($this->item_def !== "" && $this->item_def !== null) && ($this->server !== "" && $this->server !== null))) {
            $this->aAuctionItems = AuctionItemsQuery::create()->findPk(array($this->item_def, $this->server), $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAuctionItems->addAuctionAggregatess($this);
             */
        }

        return $this->aAuctionItems;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     *
     * @return $this
     */
    public function clear()
    {
        if (null !== $this->aAuctionItems) {
            $this->aAuctionItems->removeAuctionAggregates($this);
        }
        $this->item_def = null;
        $this->server = null;
        $this->low = null;
        $this->mean = null;
        $this->median = null;
        $this->count = null;
        $this->inserted = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);

        return $this;
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param bool $deep Whether to also clear the references on all referrer objects.
     * @return $this
     */
    public function clearAllReferences(bool $deep = false)
    {
        if ($deep) {
        } // if ($deep)

        $this->aAuctionItems = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AuctionAggregatesTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preSave(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postSave(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before inserting to database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preInsert(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postInsert(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preUpdate(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postUpdate(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preDelete(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postDelete(?ConnectionInterface $con = null): void
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed $params
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
            $inputData = $params[0];
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->importFrom($format, $inputData, $keyType);
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = $params[0] ?? true;
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->exportTo($format, $includeLazyLoadColumns, $keyType);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
