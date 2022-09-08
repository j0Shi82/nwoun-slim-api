<?php

namespace App\Schema\Crawl\AuctionItems\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Schema\Crawl\AuctionAggregates\AuctionAggregates;
use App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery;
use App\Schema\Crawl\AuctionAggregates\Base\AuctionAggregates as BaseAuctionAggregates;
use App\Schema\Crawl\AuctionAggregates\Map\AuctionAggregatesTableMap;
use App\Schema\Crawl\AuctionDetails\AuctionDetails;
use App\Schema\Crawl\AuctionDetails\AuctionDetailsQuery;
use App\Schema\Crawl\AuctionDetails\Base\AuctionDetails as BaseAuctionDetails;
use App\Schema\Crawl\AuctionDetails\Map\AuctionDetailsTableMap;
use App\Schema\Crawl\AuctionItems\AuctionItems as ChildAuctionItems;
use App\Schema\Crawl\AuctionItems\AuctionItemsQuery as ChildAuctionItemsQuery;
use App\Schema\Crawl\AuctionItems\Map\AuctionItemsTableMap;
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
 * Base class that represents a row from the 'auction_items' table.
 *
 *
 *
 * @package    propel.generator.App.Schema.Crawl.AuctionItems.Base
 */
abstract class AuctionItems implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\App\\Schema\\Crawl\\AuctionItems\\Map\\AuctionItemsTableMap';


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
     * The value for the item_name field.
     *
     * @var        string
     */
    protected $item_name;

    /**
     * The value for the search_term field.
     *
     * @var        string
     */
    protected $search_term;

    /**
     * The value for the quality field.
     *
     * @var        string
     */
    protected $quality;

    /**
     * The value for the categories field.
     *
     * @var        string
     */
    protected $categories;

    /**
     * The value for the crawl_category field.
     *
     * @var        string|null
     */
    protected $crawl_category;

    /**
     * The value for the allow_auto field.
     *
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $allow_auto;

    /**
     * The value for the server field.
     *
     * Note: this column has a database default value of: 'GLOBAL'
     * @var        string
     */
    protected $server;

    /**
     * The value for the update_date field.
     *
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        DateTime
     */
    protected $update_date;

    /**
     * The value for the locked_date field.
     *
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        DateTime
     */
    protected $locked_date;

    /**
     * @var        ObjectCollection|AuctionAggregates[] Collection to store aggregation of AuctionAggregates objects.
     * @phpstan-var ObjectCollection&\Traversable<AuctionAggregates> Collection to store aggregation of AuctionAggregates objects.
     */
    protected $collAuctionAggregatess;
    protected $collAuctionAggregatessPartial;

    /**
     * @var        ObjectCollection|AuctionDetails[] Collection to store aggregation of AuctionDetails objects.
     * @phpstan-var ObjectCollection&\Traversable<AuctionDetails> Collection to store aggregation of AuctionDetails objects.
     */
    protected $collAuctionDetailss;
    protected $collAuctionDetailssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|AuctionAggregates[]
     * @phpstan-var ObjectCollection&\Traversable<AuctionAggregates>
     */
    protected $auctionAggregatessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|AuctionDetails[]
     * @phpstan-var ObjectCollection&\Traversable<AuctionDetails>
     */
    protected $auctionDetailssScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues(): void
    {
        $this->allow_auto = true;
        $this->server = 'GLOBAL';
    }

    /**
     * Initializes internal state of App\Schema\Crawl\AuctionItems\Base\AuctionItems object.
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
     * Compares this with another <code>AuctionItems</code> instance.  If
     * <code>obj</code> is an instance of <code>AuctionItems</code>, delegates to
     * <code>equals(AuctionItems)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [item_name] column value.
     *
     * @return string
     */
    public function getItemName()
    {
        return $this->item_name;
    }

    /**
     * Get the [search_term] column value.
     *
     * @return string
     */
    public function getSearchTerm()
    {
        return $this->search_term;
    }

    /**
     * Get the [quality] column value.
     *
     * @return string
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * Get the [categories] column value.
     *
     * @param bool $asArray Returns the JSON data as array instead of object

     * @return object|array
     */
    public function getCategories($asArray = true)
    {
        return json_decode($this->categories, $asArray);
    }

    /**
     * Get the [crawl_category] column value.
     *
     * @return string|null
     */
    public function getCrawlCategory()
    {
        return $this->crawl_category;
    }

    /**
     * Get the [allow_auto] column value.
     *
     * @return boolean
     */
    public function getAllowAuto()
    {
        return $this->allow_auto;
    }

    /**
     * Get the [allow_auto] column value.
     *
     * @return boolean
     */
    public function isAllowAuto()
    {
        return $this->getAllowAuto();
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
     * Get the [optionally formatted] temporal [update_date] column value.
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
    public function getUpdateDate($format = null)
    {
        if ($format === null) {
            return $this->update_date;
        } else {
            return $this->update_date instanceof \DateTimeInterface ? $this->update_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [locked_date] column value.
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
    public function getLockedDate($format = null)
    {
        if ($format === null) {
            return $this->locked_date;
        } else {
            return $this->locked_date instanceof \DateTimeInterface ? $this->locked_date->format($format) : null;
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
            $this->modifiedColumns[AuctionItemsTableMap::COL_ITEM_DEF] = true;
        }

        return $this;
    }

    /**
     * Set the value of [item_name] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setItemName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_name !== $v) {
            $this->item_name = $v;
            $this->modifiedColumns[AuctionItemsTableMap::COL_ITEM_NAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [search_term] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setSearchTerm($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->search_term !== $v) {
            $this->search_term = $v;
            $this->modifiedColumns[AuctionItemsTableMap::COL_SEARCH_TERM] = true;
        }

        return $this;
    }

    /**
     * Set the value of [quality] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setQuality($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->quality !== $v) {
            $this->quality = $v;
            $this->modifiedColumns[AuctionItemsTableMap::COL_QUALITY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [categories] column.
     *
     * @param string|array|object $v new value
     * @return $this The current object (for fluent API support)
     */
    public function setCategories($v)
    {
        if (is_string($v)) {
            // JSON as string needs to be decoded/encoded to get a reliable comparison (spaces, ...)
            $v = json_decode($v);
        }
        $encodedValue = json_encode($v);
        if ($encodedValue !== $this->categories) {
            $this->categories = $encodedValue;
            $this->modifiedColumns[AuctionItemsTableMap::COL_CATEGORIES] = true;
        }

        return $this;
    }

    /**
     * Set the value of [crawl_category] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setCrawlCategory($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->crawl_category !== $v) {
            $this->crawl_category = $v;
            $this->modifiedColumns[AuctionItemsTableMap::COL_CRAWL_CATEGORY] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [allow_auto] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param bool|integer|string $v The new value
     * @return $this The current object (for fluent API support)
     */
    public function setAllowAuto($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->allow_auto !== $v) {
            $this->allow_auto = $v;
            $this->modifiedColumns[AuctionItemsTableMap::COL_ALLOW_AUTO] = true;
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
            $this->modifiedColumns[AuctionItemsTableMap::COL_SERVER] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [update_date] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setUpdateDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->update_date !== null || $dt !== null) {
            if ($this->update_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->update_date->format("Y-m-d H:i:s.u")) {
                $this->update_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AuctionItemsTableMap::COL_UPDATE_DATE] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [locked_date] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setLockedDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->locked_date !== null || $dt !== null) {
            if ($this->locked_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->locked_date->format("Y-m-d H:i:s.u")) {
                $this->locked_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AuctionItemsTableMap::COL_LOCKED_DATE] = true;
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
            if ($this->allow_auto !== true) {
                return false;
            }

            if ($this->server !== 'GLOBAL') {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AuctionItemsTableMap::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_def = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AuctionItemsTableMap::translateFieldName('ItemName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AuctionItemsTableMap::translateFieldName('SearchTerm', TableMap::TYPE_PHPNAME, $indexType)];
            $this->search_term = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AuctionItemsTableMap::translateFieldName('Quality', TableMap::TYPE_PHPNAME, $indexType)];
            $this->quality = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AuctionItemsTableMap::translateFieldName('Categories', TableMap::TYPE_PHPNAME, $indexType)];
            $this->categories = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AuctionItemsTableMap::translateFieldName('CrawlCategory', TableMap::TYPE_PHPNAME, $indexType)];
            $this->crawl_category = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AuctionItemsTableMap::translateFieldName('AllowAuto', TableMap::TYPE_PHPNAME, $indexType)];
            $this->allow_auto = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AuctionItemsTableMap::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)];
            $this->server = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : AuctionItemsTableMap::translateFieldName('UpdateDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->update_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : AuctionItemsTableMap::translateFieldName('LockedDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->locked_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = AuctionItemsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Schema\\Crawl\\AuctionItems\\AuctionItems'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(AuctionItemsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAuctionItemsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAuctionAggregatess = null;

            $this->collAuctionDetailss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see AuctionItems::setDeleted()
     * @see AuctionItems::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionItemsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAuctionItemsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionItemsTableMap::DATABASE_NAME);
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
                AuctionItemsTableMap::addInstanceToPool($this);
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

            if ($this->auctionAggregatessScheduledForDeletion !== null) {
                if (!$this->auctionAggregatessScheduledForDeletion->isEmpty()) {
                    \App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery::create()
                        ->filterByPrimaryKeys($this->auctionAggregatessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->auctionAggregatessScheduledForDeletion = null;
                }
            }

            if ($this->collAuctionAggregatess !== null) {
                foreach ($this->collAuctionAggregatess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->auctionDetailssScheduledForDeletion !== null) {
                if (!$this->auctionDetailssScheduledForDeletion->isEmpty()) {
                    \App\Schema\Crawl\AuctionDetails\AuctionDetailsQuery::create()
                        ->filterByPrimaryKeys($this->auctionDetailssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->auctionDetailssScheduledForDeletion = null;
                }
            }

            if ($this->collAuctionDetailss !== null) {
                foreach ($this->collAuctionDetailss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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
        if ($this->isColumnModified(AuctionItemsTableMap::COL_ITEM_DEF)) {
            $modifiedColumns[':p' . $index++]  = 'item_def';
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_ITEM_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'item_name';
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_SEARCH_TERM)) {
            $modifiedColumns[':p' . $index++]  = 'search_term';
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_QUALITY)) {
            $modifiedColumns[':p' . $index++]  = 'quality';
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_CATEGORIES)) {
            $modifiedColumns[':p' . $index++]  = 'categories';
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_CRAWL_CATEGORY)) {
            $modifiedColumns[':p' . $index++]  = 'crawl_category';
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_ALLOW_AUTO)) {
            $modifiedColumns[':p' . $index++]  = 'allow_auto';
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_SERVER)) {
            $modifiedColumns[':p' . $index++]  = 'server';
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_UPDATE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'update_date';
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_LOCKED_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'locked_date';
        }

        $sql = sprintf(
            'INSERT INTO auction_items (%s) VALUES (%s)',
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
                    case 'item_name':
                        $stmt->bindValue($identifier, $this->item_name, PDO::PARAM_STR);
                        break;
                    case 'search_term':
                        $stmt->bindValue($identifier, $this->search_term, PDO::PARAM_STR);
                        break;
                    case 'quality':
                        $stmt->bindValue($identifier, $this->quality, PDO::PARAM_STR);
                        break;
                    case 'categories':
                        $stmt->bindValue($identifier, $this->categories, PDO::PARAM_STR);
                        break;
                    case 'crawl_category':
                        $stmt->bindValue($identifier, $this->crawl_category, PDO::PARAM_STR);
                        break;
                    case 'allow_auto':
                        $stmt->bindValue($identifier, (int) $this->allow_auto, PDO::PARAM_INT);
                        break;
                    case 'server':
                        $stmt->bindValue($identifier, $this->server, PDO::PARAM_STR);
                        break;
                    case 'update_date':
                        $stmt->bindValue($identifier, $this->update_date ? $this->update_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'locked_date':
                        $stmt->bindValue($identifier, $this->locked_date ? $this->locked_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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
        $pos = AuctionItemsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getItemName();

            case 2:
                return $this->getSearchTerm();

            case 3:
                return $this->getQuality();

            case 4:
                return $this->getCategories();

            case 5:
                return $this->getCrawlCategory();

            case 6:
                return $this->getAllowAuto();

            case 7:
                return $this->getServer();

            case 8:
                return $this->getUpdateDate();

            case 9:
                return $this->getLockedDate();

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
        if (isset($alreadyDumpedObjects['AuctionItems'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['AuctionItems'][$this->hashCode()] = true;
        $keys = AuctionItemsTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getItemDef(),
            $keys[1] => $this->getItemName(),
            $keys[2] => $this->getSearchTerm(),
            $keys[3] => $this->getQuality(),
            $keys[4] => $this->getCategories(),
            $keys[5] => $this->getCrawlCategory(),
            $keys[6] => $this->getAllowAuto(),
            $keys[7] => $this->getServer(),
            $keys[8] => $this->getUpdateDate(),
            $keys[9] => $this->getLockedDate(),
        ];
        if ($result[$keys[8]] instanceof \DateTimeInterface) {
            $result[$keys[8]] = $result[$keys[8]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[9]] instanceof \DateTimeInterface) {
            $result[$keys[9]] = $result[$keys[9]]->format('Y-m-d H:i:s.u');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collAuctionAggregatess) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'auctionAggregatess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'auction_aggregatess';
                        break;
                    default:
                        $key = 'AuctionAggregatess';
                }

                $result[$key] = $this->collAuctionAggregatess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAuctionDetailss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'auctionDetailss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'auction_detailss';
                        break;
                    default:
                        $key = 'AuctionDetailss';
                }

                $result[$key] = $this->collAuctionDetailss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = AuctionItemsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setItemName($value);
                break;
            case 2:
                $this->setSearchTerm($value);
                break;
            case 3:
                $this->setQuality($value);
                break;
            case 4:
                $this->setCategories($value);
                break;
            case 5:
                $this->setCrawlCategory($value);
                break;
            case 6:
                $this->setAllowAuto($value);
                break;
            case 7:
                $this->setServer($value);
                break;
            case 8:
                $this->setUpdateDate($value);
                break;
            case 9:
                $this->setLockedDate($value);
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
        $keys = AuctionItemsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setItemDef($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setItemName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSearchTerm($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setQuality($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCategories($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCrawlCategory($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setAllowAuto($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setServer($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setUpdateDate($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setLockedDate($arr[$keys[9]]);
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
        $criteria = new Criteria(AuctionItemsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AuctionItemsTableMap::COL_ITEM_DEF)) {
            $criteria->add(AuctionItemsTableMap::COL_ITEM_DEF, $this->item_def);
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_ITEM_NAME)) {
            $criteria->add(AuctionItemsTableMap::COL_ITEM_NAME, $this->item_name);
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_SEARCH_TERM)) {
            $criteria->add(AuctionItemsTableMap::COL_SEARCH_TERM, $this->search_term);
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_QUALITY)) {
            $criteria->add(AuctionItemsTableMap::COL_QUALITY, $this->quality);
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_CATEGORIES)) {
            $criteria->add(AuctionItemsTableMap::COL_CATEGORIES, $this->categories);
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_CRAWL_CATEGORY)) {
            $criteria->add(AuctionItemsTableMap::COL_CRAWL_CATEGORY, $this->crawl_category);
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_ALLOW_AUTO)) {
            $criteria->add(AuctionItemsTableMap::COL_ALLOW_AUTO, $this->allow_auto);
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_SERVER)) {
            $criteria->add(AuctionItemsTableMap::COL_SERVER, $this->server);
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_UPDATE_DATE)) {
            $criteria->add(AuctionItemsTableMap::COL_UPDATE_DATE, $this->update_date);
        }
        if ($this->isColumnModified(AuctionItemsTableMap::COL_LOCKED_DATE)) {
            $criteria->add(AuctionItemsTableMap::COL_LOCKED_DATE, $this->locked_date);
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
        $criteria = ChildAuctionItemsQuery::create();
        $criteria->add(AuctionItemsTableMap::COL_ITEM_DEF, $this->item_def);
        $criteria->add(AuctionItemsTableMap::COL_SERVER, $this->server);

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
            null !== $this->getServer();

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
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = [];
        $pks[0] = $this->getItemDef();
        $pks[1] = $this->getServer();

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
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return (null === $this->getItemDef()) && (null === $this->getServer());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \App\Schema\Crawl\AuctionItems\AuctionItems (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setItemDef($this->getItemDef());
        $copyObj->setItemName($this->getItemName());
        $copyObj->setSearchTerm($this->getSearchTerm());
        $copyObj->setQuality($this->getQuality());
        $copyObj->setCategories($this->getCategories());
        $copyObj->setCrawlCategory($this->getCrawlCategory());
        $copyObj->setAllowAuto($this->getAllowAuto());
        $copyObj->setServer($this->getServer());
        $copyObj->setUpdateDate($this->getUpdateDate());
        $copyObj->setLockedDate($this->getLockedDate());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAuctionAggregatess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAuctionAggregates($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAuctionDetailss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAuctionDetails($relObj->copy($deepCopy));
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
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \App\Schema\Crawl\AuctionItems\AuctionItems Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName): void
    {
        if ('AuctionAggregates' === $relationName) {
            $this->initAuctionAggregatess();
            return;
        }
        if ('AuctionDetails' === $relationName) {
            $this->initAuctionDetailss();
            return;
        }
    }

    /**
     * Clears out the collAuctionAggregatess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addAuctionAggregatess()
     */
    public function clearAuctionAggregatess()
    {
        $this->collAuctionAggregatess = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collAuctionAggregatess collection loaded partially.
     *
     * @return void
     */
    public function resetPartialAuctionAggregatess($v = true): void
    {
        $this->collAuctionAggregatessPartial = $v;
    }

    /**
     * Initializes the collAuctionAggregatess collection.
     *
     * By default this just sets the collAuctionAggregatess collection to an empty array (like clearcollAuctionAggregatess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAuctionAggregatess(bool $overrideExisting = true): void
    {
        if (null !== $this->collAuctionAggregatess && !$overrideExisting) {
            return;
        }

        $collectionClassName = AuctionAggregatesTableMap::getTableMap()->getCollectionClassName();

        $this->collAuctionAggregatess = new $collectionClassName;
        $this->collAuctionAggregatess->setModel('\App\Schema\Crawl\AuctionAggregates\AuctionAggregates');
    }

    /**
     * Gets an array of AuctionAggregates objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAuctionItems is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|AuctionAggregates[] List of AuctionAggregates objects
     * @phpstan-return ObjectCollection&\Traversable<AuctionAggregates> List of AuctionAggregates objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getAuctionAggregatess(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collAuctionAggregatessPartial && !$this->isNew();
        if (null === $this->collAuctionAggregatess || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collAuctionAggregatess) {
                    $this->initAuctionAggregatess();
                } else {
                    $collectionClassName = AuctionAggregatesTableMap::getTableMap()->getCollectionClassName();

                    $collAuctionAggregatess = new $collectionClassName;
                    $collAuctionAggregatess->setModel('\App\Schema\Crawl\AuctionAggregates\AuctionAggregates');

                    return $collAuctionAggregatess;
                }
            } else {
                $collAuctionAggregatess = AuctionAggregatesQuery::create(null, $criteria)
                    ->filterByAuctionItems($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAuctionAggregatessPartial && count($collAuctionAggregatess)) {
                        $this->initAuctionAggregatess(false);

                        foreach ($collAuctionAggregatess as $obj) {
                            if (false == $this->collAuctionAggregatess->contains($obj)) {
                                $this->collAuctionAggregatess->append($obj);
                            }
                        }

                        $this->collAuctionAggregatessPartial = true;
                    }

                    return $collAuctionAggregatess;
                }

                if ($partial && $this->collAuctionAggregatess) {
                    foreach ($this->collAuctionAggregatess as $obj) {
                        if ($obj->isNew()) {
                            $collAuctionAggregatess[] = $obj;
                        }
                    }
                }

                $this->collAuctionAggregatess = $collAuctionAggregatess;
                $this->collAuctionAggregatessPartial = false;
            }
        }

        return $this->collAuctionAggregatess;
    }

    /**
     * Sets a collection of AuctionAggregates objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $auctionAggregatess A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setAuctionAggregatess(Collection $auctionAggregatess, ?ConnectionInterface $con = null)
    {
        /** @var AuctionAggregates[] $auctionAggregatessToDelete */
        $auctionAggregatessToDelete = $this->getAuctionAggregatess(new Criteria(), $con)->diff($auctionAggregatess);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->auctionAggregatessScheduledForDeletion = clone $auctionAggregatessToDelete;

        foreach ($auctionAggregatessToDelete as $auctionAggregatesRemoved) {
            $auctionAggregatesRemoved->setAuctionItems(null);
        }

        $this->collAuctionAggregatess = null;
        foreach ($auctionAggregatess as $auctionAggregates) {
            $this->addAuctionAggregates($auctionAggregates);
        }

        $this->collAuctionAggregatess = $auctionAggregatess;
        $this->collAuctionAggregatessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseAuctionAggregates objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related BaseAuctionAggregates objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countAuctionAggregatess(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collAuctionAggregatessPartial && !$this->isNew();
        if (null === $this->collAuctionAggregatess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAuctionAggregatess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAuctionAggregatess());
            }

            $query = AuctionAggregatesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuctionItems($this)
                ->count($con);
        }

        return count($this->collAuctionAggregatess);
    }

    /**
     * Method called to associate a AuctionAggregates object to this object
     * through the AuctionAggregates foreign key attribute.
     *
     * @param AuctionAggregates $l AuctionAggregates
     * @return $this The current object (for fluent API support)
     */
    public function addAuctionAggregates(AuctionAggregates $l)
    {
        if ($this->collAuctionAggregatess === null) {
            $this->initAuctionAggregatess();
            $this->collAuctionAggregatessPartial = true;
        }

        if (!$this->collAuctionAggregatess->contains($l)) {
            $this->doAddAuctionAggregates($l);

            if ($this->auctionAggregatessScheduledForDeletion and $this->auctionAggregatessScheduledForDeletion->contains($l)) {
                $this->auctionAggregatessScheduledForDeletion->remove($this->auctionAggregatessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param AuctionAggregates $auctionAggregates The AuctionAggregates object to add.
     */
    protected function doAddAuctionAggregates(AuctionAggregates $auctionAggregates): void
    {
        $this->collAuctionAggregatess[]= $auctionAggregates;
        $auctionAggregates->setAuctionItems($this);
    }

    /**
     * @param AuctionAggregates $auctionAggregates The AuctionAggregates object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeAuctionAggregates(AuctionAggregates $auctionAggregates)
    {
        if ($this->getAuctionAggregatess()->contains($auctionAggregates)) {
            $pos = $this->collAuctionAggregatess->search($auctionAggregates);
            $this->collAuctionAggregatess->remove($pos);
            if (null === $this->auctionAggregatessScheduledForDeletion) {
                $this->auctionAggregatessScheduledForDeletion = clone $this->collAuctionAggregatess;
                $this->auctionAggregatessScheduledForDeletion->clear();
            }
            $this->auctionAggregatessScheduledForDeletion[]= clone $auctionAggregates;
            $auctionAggregates->setAuctionItems(null);
        }

        return $this;
    }

    /**
     * Clears out the collAuctionDetailss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addAuctionDetailss()
     */
    public function clearAuctionDetailss()
    {
        $this->collAuctionDetailss = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collAuctionDetailss collection loaded partially.
     *
     * @return void
     */
    public function resetPartialAuctionDetailss($v = true): void
    {
        $this->collAuctionDetailssPartial = $v;
    }

    /**
     * Initializes the collAuctionDetailss collection.
     *
     * By default this just sets the collAuctionDetailss collection to an empty array (like clearcollAuctionDetailss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAuctionDetailss(bool $overrideExisting = true): void
    {
        if (null !== $this->collAuctionDetailss && !$overrideExisting) {
            return;
        }

        $collectionClassName = AuctionDetailsTableMap::getTableMap()->getCollectionClassName();

        $this->collAuctionDetailss = new $collectionClassName;
        $this->collAuctionDetailss->setModel('\App\Schema\Crawl\AuctionDetails\AuctionDetails');
    }

    /**
     * Gets an array of AuctionDetails objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAuctionItems is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|AuctionDetails[] List of AuctionDetails objects
     * @phpstan-return ObjectCollection&\Traversable<AuctionDetails> List of AuctionDetails objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getAuctionDetailss(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collAuctionDetailssPartial && !$this->isNew();
        if (null === $this->collAuctionDetailss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collAuctionDetailss) {
                    $this->initAuctionDetailss();
                } else {
                    $collectionClassName = AuctionDetailsTableMap::getTableMap()->getCollectionClassName();

                    $collAuctionDetailss = new $collectionClassName;
                    $collAuctionDetailss->setModel('\App\Schema\Crawl\AuctionDetails\AuctionDetails');

                    return $collAuctionDetailss;
                }
            } else {
                $collAuctionDetailss = AuctionDetailsQuery::create(null, $criteria)
                    ->filterByAuctionItems($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAuctionDetailssPartial && count($collAuctionDetailss)) {
                        $this->initAuctionDetailss(false);

                        foreach ($collAuctionDetailss as $obj) {
                            if (false == $this->collAuctionDetailss->contains($obj)) {
                                $this->collAuctionDetailss->append($obj);
                            }
                        }

                        $this->collAuctionDetailssPartial = true;
                    }

                    return $collAuctionDetailss;
                }

                if ($partial && $this->collAuctionDetailss) {
                    foreach ($this->collAuctionDetailss as $obj) {
                        if ($obj->isNew()) {
                            $collAuctionDetailss[] = $obj;
                        }
                    }
                }

                $this->collAuctionDetailss = $collAuctionDetailss;
                $this->collAuctionDetailssPartial = false;
            }
        }

        return $this->collAuctionDetailss;
    }

    /**
     * Sets a collection of AuctionDetails objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $auctionDetailss A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setAuctionDetailss(Collection $auctionDetailss, ?ConnectionInterface $con = null)
    {
        /** @var AuctionDetails[] $auctionDetailssToDelete */
        $auctionDetailssToDelete = $this->getAuctionDetailss(new Criteria(), $con)->diff($auctionDetailss);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->auctionDetailssScheduledForDeletion = clone $auctionDetailssToDelete;

        foreach ($auctionDetailssToDelete as $auctionDetailsRemoved) {
            $auctionDetailsRemoved->setAuctionItems(null);
        }

        $this->collAuctionDetailss = null;
        foreach ($auctionDetailss as $auctionDetails) {
            $this->addAuctionDetails($auctionDetails);
        }

        $this->collAuctionDetailss = $auctionDetailss;
        $this->collAuctionDetailssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseAuctionDetails objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related BaseAuctionDetails objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countAuctionDetailss(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collAuctionDetailssPartial && !$this->isNew();
        if (null === $this->collAuctionDetailss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAuctionDetailss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAuctionDetailss());
            }

            $query = AuctionDetailsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuctionItems($this)
                ->count($con);
        }

        return count($this->collAuctionDetailss);
    }

    /**
     * Method called to associate a AuctionDetails object to this object
     * through the AuctionDetails foreign key attribute.
     *
     * @param AuctionDetails $l AuctionDetails
     * @return $this The current object (for fluent API support)
     */
    public function addAuctionDetails(AuctionDetails $l)
    {
        if ($this->collAuctionDetailss === null) {
            $this->initAuctionDetailss();
            $this->collAuctionDetailssPartial = true;
        }

        if (!$this->collAuctionDetailss->contains($l)) {
            $this->doAddAuctionDetails($l);

            if ($this->auctionDetailssScheduledForDeletion and $this->auctionDetailssScheduledForDeletion->contains($l)) {
                $this->auctionDetailssScheduledForDeletion->remove($this->auctionDetailssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param AuctionDetails $auctionDetails The AuctionDetails object to add.
     */
    protected function doAddAuctionDetails(AuctionDetails $auctionDetails): void
    {
        $this->collAuctionDetailss[]= $auctionDetails;
        $auctionDetails->setAuctionItems($this);
    }

    /**
     * @param AuctionDetails $auctionDetails The AuctionDetails object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeAuctionDetails(AuctionDetails $auctionDetails)
    {
        if ($this->getAuctionDetailss()->contains($auctionDetails)) {
            $pos = $this->collAuctionDetailss->search($auctionDetails);
            $this->collAuctionDetailss->remove($pos);
            if (null === $this->auctionDetailssScheduledForDeletion) {
                $this->auctionDetailssScheduledForDeletion = clone $this->collAuctionDetailss;
                $this->auctionDetailssScheduledForDeletion->clear();
            }
            $this->auctionDetailssScheduledForDeletion[]= clone $auctionDetails;
            $auctionDetails->setAuctionItems(null);
        }

        return $this;
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
        $this->item_def = null;
        $this->item_name = null;
        $this->search_term = null;
        $this->quality = null;
        $this->categories = null;
        $this->crawl_category = null;
        $this->allow_auto = null;
        $this->server = null;
        $this->update_date = null;
        $this->locked_date = null;
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
            if ($this->collAuctionAggregatess) {
                foreach ($this->collAuctionAggregatess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAuctionDetailss) {
                foreach ($this->collAuctionDetailss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAuctionAggregatess = null;
        $this->collAuctionDetailss = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AuctionItemsTableMap::DEFAULT_STRING_FORMAT);
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
