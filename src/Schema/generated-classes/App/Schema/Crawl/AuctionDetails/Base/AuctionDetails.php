<?php

namespace App\Schema\Crawl\AuctionDetails\Base;

use \Exception;
use \PDO;
use App\Schema\Crawl\AuctionDetails\AuctionDetailsQuery as ChildAuctionDetailsQuery;
use App\Schema\Crawl\AuctionDetails\Map\AuctionDetailsTableMap;
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

/**
 * Base class that represents a row from the 'auction_details' table.
 *
 *
 *
 * @package    propel.generator.App.Schema.Crawl.AuctionDetails.Base
 */
abstract class AuctionDetails implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Schema\\Crawl\\AuctionDetails\\Map\\AuctionDetailsTableMap';


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
     * The value for the seller_name field.
     *
     * @var        string
     */
    protected $seller_name;

    /**
     * The value for the seller_handle field.
     *
     * @var        string
     */
    protected $seller_handle;

    /**
     * The value for the expire_time field.
     *
     * @var        string
     */
    protected $expire_time;

    /**
     * The value for the price field.
     *
     * @var        int
     */
    protected $price;

    /**
     * The value for the count field.
     *
     * @var        int
     */
    protected $count;

    /**
     * The value for the price_per field.
     *
     * @var        double
     */
    protected $price_per;

    /**
     * @var        AuctionItems
     */
    protected $aAuctionItems;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of App\Schema\Crawl\AuctionDetails\Base\AuctionDetails object.
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
            unset($this->modifiedColumns[$col]);
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>AuctionDetails</code> instance.  If
     * <code>obj</code> is an instance of <code>AuctionDetails</code>, delegates to
     * <code>equals(AuctionDetails)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this The current object, for fluid interface
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
     * @return void
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
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
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @param  string  $keyType                (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME, TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM. Defaults to TableMap::TYPE_PHPNAME.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
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
     * Get the [seller_name] column value.
     *
     * @return string
     */
    public function getSellerName()
    {
        return $this->seller_name;
    }

    /**
     * Get the [seller_handle] column value.
     *
     * @return string
     */
    public function getSellerHandle()
    {
        return $this->seller_handle;
    }

    /**
     * Get the [expire_time] column value.
     *
     * @return string
     */
    public function getExpireTime()
    {
        return $this->expire_time;
    }

    /**
     * Get the [price] column value.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
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
     * Get the [price_per] column value.
     *
     * @return double
     */
    public function getPricePer()
    {
        return $this->price_per;
    }

    /**
     * Set the value of [item_def] column.
     *
     * @param string $v New value
     * @return $this|\App\Schema\Crawl\AuctionDetails\AuctionDetails The current object (for fluent API support)
     */
    public function setItemDef($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_def !== $v) {
            $this->item_def = $v;
            $this->modifiedColumns[AuctionDetailsTableMap::COL_ITEM_DEF] = true;
        }

        if ($this->aAuctionItems !== null && $this->aAuctionItems->getItemDef() !== $v) {
            $this->aAuctionItems = null;
        }

        return $this;
    } // setItemDef()

    /**
     * Set the value of [server] column.
     *
     * @param string $v New value
     * @return $this|\App\Schema\Crawl\AuctionDetails\AuctionDetails The current object (for fluent API support)
     */
    public function setServer($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->server !== $v) {
            $this->server = $v;
            $this->modifiedColumns[AuctionDetailsTableMap::COL_SERVER] = true;
        }

        if ($this->aAuctionItems !== null && $this->aAuctionItems->getServer() !== $v) {
            $this->aAuctionItems = null;
        }

        return $this;
    } // setServer()

    /**
     * Set the value of [seller_name] column.
     *
     * @param string $v New value
     * @return $this|\App\Schema\Crawl\AuctionDetails\AuctionDetails The current object (for fluent API support)
     */
    public function setSellerName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->seller_name !== $v) {
            $this->seller_name = $v;
            $this->modifiedColumns[AuctionDetailsTableMap::COL_SELLER_NAME] = true;
        }

        return $this;
    } // setSellerName()

    /**
     * Set the value of [seller_handle] column.
     *
     * @param string $v New value
     * @return $this|\App\Schema\Crawl\AuctionDetails\AuctionDetails The current object (for fluent API support)
     */
    public function setSellerHandle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->seller_handle !== $v) {
            $this->seller_handle = $v;
            $this->modifiedColumns[AuctionDetailsTableMap::COL_SELLER_HANDLE] = true;
        }

        return $this;
    } // setSellerHandle()

    /**
     * Set the value of [expire_time] column.
     *
     * @param string $v New value
     * @return $this|\App\Schema\Crawl\AuctionDetails\AuctionDetails The current object (for fluent API support)
     */
    public function setExpireTime($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->expire_time !== $v) {
            $this->expire_time = $v;
            $this->modifiedColumns[AuctionDetailsTableMap::COL_EXPIRE_TIME] = true;
        }

        return $this;
    } // setExpireTime()

    /**
     * Set the value of [price] column.
     *
     * @param int $v New value
     * @return $this|\App\Schema\Crawl\AuctionDetails\AuctionDetails The current object (for fluent API support)
     */
    public function setPrice($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->price !== $v) {
            $this->price = $v;
            $this->modifiedColumns[AuctionDetailsTableMap::COL_PRICE] = true;
        }

        return $this;
    } // setPrice()

    /**
     * Set the value of [count] column.
     *
     * @param int $v New value
     * @return $this|\App\Schema\Crawl\AuctionDetails\AuctionDetails The current object (for fluent API support)
     */
    public function setCount($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->count !== $v) {
            $this->count = $v;
            $this->modifiedColumns[AuctionDetailsTableMap::COL_COUNT] = true;
        }

        return $this;
    } // setCount()

    /**
     * Set the value of [price_per] column.
     *
     * @param double $v New value
     * @return $this|\App\Schema\Crawl\AuctionDetails\AuctionDetails The current object (for fluent API support)
     */
    public function setPricePer($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->price_per !== $v) {
            $this->price_per = $v;
            $this->modifiedColumns[AuctionDetailsTableMap::COL_PRICE_PER] = true;
        }

        return $this;
    } // setPricePer()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AuctionDetailsTableMap::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_def = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AuctionDetailsTableMap::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)];
            $this->server = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AuctionDetailsTableMap::translateFieldName('SellerName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->seller_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AuctionDetailsTableMap::translateFieldName('SellerHandle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->seller_handle = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AuctionDetailsTableMap::translateFieldName('ExpireTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->expire_time = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AuctionDetailsTableMap::translateFieldName('Price', TableMap::TYPE_PHPNAME, $indexType)];
            $this->price = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AuctionDetailsTableMap::translateFieldName('Count', TableMap::TYPE_PHPNAME, $indexType)];
            $this->count = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AuctionDetailsTableMap::translateFieldName('PricePer', TableMap::TYPE_PHPNAME, $indexType)];
            $this->price_per = (null !== $col) ? (double) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = AuctionDetailsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Schema\\Crawl\\AuctionDetails\\AuctionDetails'), 0, $e);
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
        if ($this->aAuctionItems !== null && $this->item_def !== $this->aAuctionItems->getItemDef()) {
            $this->aAuctionItems = null;
        }
        if ($this->aAuctionItems !== null && $this->server !== $this->aAuctionItems->getServer()) {
            $this->aAuctionItems = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(AuctionDetailsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAuctionDetailsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
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
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see AuctionDetails::setDeleted()
     * @see AuctionDetails::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionDetailsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAuctionDetailsQuery::create()
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

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionDetailsTableMap::DATABASE_NAME);
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
                AuctionDetailsTableMap::addInstanceToPool($this);
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
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_ITEM_DEF)) {
            $modifiedColumns[':p' . $index++]  = 'item_def';
        }
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_SERVER)) {
            $modifiedColumns[':p' . $index++]  = 'server';
        }
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_SELLER_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'seller_name';
        }
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_SELLER_HANDLE)) {
            $modifiedColumns[':p' . $index++]  = 'seller_handle';
        }
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_EXPIRE_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'expire_time';
        }
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'price';
        }
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_COUNT)) {
            $modifiedColumns[':p' . $index++]  = 'count';
        }
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_PRICE_PER)) {
            $modifiedColumns[':p' . $index++]  = 'price_per';
        }

        $sql = sprintf(
            'INSERT INTO auction_details (%s) VALUES (%s)',
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
                    case 'seller_name':
                        $stmt->bindValue($identifier, $this->seller_name, PDO::PARAM_STR);
                        break;
                    case 'seller_handle':
                        $stmt->bindValue($identifier, $this->seller_handle, PDO::PARAM_STR);
                        break;
                    case 'expire_time':
                        $stmt->bindValue($identifier, $this->expire_time, PDO::PARAM_INT);
                        break;
                    case 'price':
                        $stmt->bindValue($identifier, $this->price, PDO::PARAM_INT);
                        break;
                    case 'count':
                        $stmt->bindValue($identifier, $this->count, PDO::PARAM_INT);
                        break;
                    case 'price_per':
                        $stmt->bindValue($identifier, $this->price_per, PDO::PARAM_STR);
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
        $pos = AuctionDetailsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getItemDef();
                break;
            case 1:
                return $this->getServer();
                break;
            case 2:
                return $this->getSellerName();
                break;
            case 3:
                return $this->getSellerHandle();
                break;
            case 4:
                return $this->getExpireTime();
                break;
            case 5:
                return $this->getPrice();
                break;
            case 6:
                return $this->getCount();
                break;
            case 7:
                return $this->getPricePer();
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

        if (isset($alreadyDumpedObjects['AuctionDetails'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AuctionDetails'][$this->hashCode()] = true;
        $keys = AuctionDetailsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getItemDef(),
            $keys[1] => $this->getServer(),
            $keys[2] => $this->getSellerName(),
            $keys[3] => $this->getSellerHandle(),
            $keys[4] => $this->getExpireTime(),
            $keys[5] => $this->getPrice(),
            $keys[6] => $this->getCount(),
            $keys[7] => $this->getPricePer(),
        );
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
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\App\Schema\Crawl\AuctionDetails\AuctionDetails
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AuctionDetailsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\App\Schema\Crawl\AuctionDetails\AuctionDetails
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setItemDef($value);
                break;
            case 1:
                $this->setServer($value);
                break;
            case 2:
                $this->setSellerName($value);
                break;
            case 3:
                $this->setSellerHandle($value);
                break;
            case 4:
                $this->setExpireTime($value);
                break;
            case 5:
                $this->setPrice($value);
                break;
            case 6:
                $this->setCount($value);
                break;
            case 7:
                $this->setPricePer($value);
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
     * @return     $this|\App\Schema\Crawl\AuctionDetails\AuctionDetails
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = AuctionDetailsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setItemDef($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setServer($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSellerName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setSellerHandle($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setExpireTime($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPrice($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setCount($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPricePer($arr[$keys[7]]);
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
     * @return $this|\App\Schema\Crawl\AuctionDetails\AuctionDetails The current object, for fluid interface
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
        $criteria = new Criteria(AuctionDetailsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AuctionDetailsTableMap::COL_ITEM_DEF)) {
            $criteria->add(AuctionDetailsTableMap::COL_ITEM_DEF, $this->item_def);
        }
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_SERVER)) {
            $criteria->add(AuctionDetailsTableMap::COL_SERVER, $this->server);
        }
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_SELLER_NAME)) {
            $criteria->add(AuctionDetailsTableMap::COL_SELLER_NAME, $this->seller_name);
        }
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_SELLER_HANDLE)) {
            $criteria->add(AuctionDetailsTableMap::COL_SELLER_HANDLE, $this->seller_handle);
        }
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_EXPIRE_TIME)) {
            $criteria->add(AuctionDetailsTableMap::COL_EXPIRE_TIME, $this->expire_time);
        }
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_PRICE)) {
            $criteria->add(AuctionDetailsTableMap::COL_PRICE, $this->price);
        }
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_COUNT)) {
            $criteria->add(AuctionDetailsTableMap::COL_COUNT, $this->count);
        }
        if ($this->isColumnModified(AuctionDetailsTableMap::COL_PRICE_PER)) {
            $criteria->add(AuctionDetailsTableMap::COL_PRICE_PER, $this->price_per);
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
        $criteria = ChildAuctionDetailsQuery::create();
        $criteria->add(AuctionDetailsTableMap::COL_ITEM_DEF, $this->item_def);
        $criteria->add(AuctionDetailsTableMap::COL_SERVER, $this->server);
        $criteria->add(AuctionDetailsTableMap::COL_SELLER_NAME, $this->seller_name);
        $criteria->add(AuctionDetailsTableMap::COL_SELLER_HANDLE, $this->seller_handle);
        $criteria->add(AuctionDetailsTableMap::COL_EXPIRE_TIME, $this->expire_time);

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
        $validPk = null !== $this->getItemDef() &&
            null !== $this->getServer() &&
            null !== $this->getSellerName() &&
            null !== $this->getSellerHandle() &&
            null !== $this->getExpireTime();

        $validPrimaryKeyFKs = 2;
        $primaryKeyFKs = [];

        //relation auction_details_fk_ff4eb9 to table auction_items
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
        $pks = array();
        $pks[0] = $this->getItemDef();
        $pks[1] = $this->getServer();
        $pks[2] = $this->getSellerName();
        $pks[3] = $this->getSellerHandle();
        $pks[4] = $this->getExpireTime();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setItemDef($keys[0]);
        $this->setServer($keys[1]);
        $this->setSellerName($keys[2]);
        $this->setSellerHandle($keys[3]);
        $this->setExpireTime($keys[4]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getItemDef()) && (null === $this->getServer()) && (null === $this->getSellerName()) && (null === $this->getSellerHandle()) && (null === $this->getExpireTime());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \App\Schema\Crawl\AuctionDetails\AuctionDetails (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setItemDef($this->getItemDef());
        $copyObj->setServer($this->getServer());
        $copyObj->setSellerName($this->getSellerName());
        $copyObj->setSellerHandle($this->getSellerHandle());
        $copyObj->setExpireTime($this->getExpireTime());
        $copyObj->setPrice($this->getPrice());
        $copyObj->setCount($this->getCount());
        $copyObj->setPricePer($this->getPricePer());
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
     * @return \App\Schema\Crawl\AuctionDetails\AuctionDetails Clone of current object.
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
     * Declares an association between this object and a AuctionItems object.
     *
     * @param  AuctionItems $v
     * @return $this|\App\Schema\Crawl\AuctionDetails\AuctionDetails The current object (for fluent API support)
     * @throws PropelException
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
            $v->addAuctionDetails($this);
        }


        return $this;
    }


    /**
     * Get the associated AuctionItems object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return AuctionItems The associated AuctionItems object.
     * @throws PropelException
     */
    public function getAuctionItems(ConnectionInterface $con = null)
    {
        if ($this->aAuctionItems === null && (($this->item_def !== "" && $this->item_def !== null) && ($this->server !== "" && $this->server !== null))) {
            $this->aAuctionItems = AuctionItemsQuery::create()->findPk(array($this->item_def, $this->server), $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAuctionItems->addAuctionDetailss($this);
             */
        }

        return $this->aAuctionItems;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aAuctionItems) {
            $this->aAuctionItems->removeAuctionDetails($this);
        }
        $this->item_def = null;
        $this->server = null;
        $this->seller_name = null;
        $this->seller_handle = null;
        $this->expire_time = null;
        $this->price = null;
        $this->count = null;
        $this->price_per = null;
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

        $this->aAuctionItems = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AuctionDetailsTableMap::DEFAULT_STRING_FORMAT);
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
