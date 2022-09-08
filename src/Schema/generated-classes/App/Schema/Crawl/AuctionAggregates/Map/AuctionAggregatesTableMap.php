<?php

namespace App\Schema\Crawl\AuctionAggregates\Map;

use App\Schema\Crawl\AuctionAggregates\AuctionAggregates;
use App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'auction_aggregates' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class AuctionAggregatesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'App.Schema.Crawl.AuctionAggregates.Map.AuctionAggregatesTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'crawl';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'auction_aggregates';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\App\\Schema\\Crawl\\AuctionAggregates\\AuctionAggregates';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'App.Schema.Crawl.AuctionAggregates.AuctionAggregates';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the item_def field
     */
    public const COL_ITEM_DEF = 'auction_aggregates.item_def';

    /**
     * the column name for the server field
     */
    public const COL_SERVER = 'auction_aggregates.server';

    /**
     * the column name for the low field
     */
    public const COL_LOW = 'auction_aggregates.low';

    /**
     * the column name for the mean field
     */
    public const COL_MEAN = 'auction_aggregates.mean';

    /**
     * the column name for the median field
     */
    public const COL_MEDIAN = 'auction_aggregates.median';

    /**
     * the column name for the count field
     */
    public const COL_COUNT = 'auction_aggregates.count';

    /**
     * the column name for the inserted field
     */
    public const COL_INSERTED = 'auction_aggregates.inserted';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['ItemDef', 'Server', 'Low', 'Mean', 'Median', 'Count', 'Inserted', ],
        self::TYPE_CAMELNAME     => ['itemDef', 'server', 'low', 'mean', 'median', 'count', 'inserted', ],
        self::TYPE_COLNAME       => [AuctionAggregatesTableMap::COL_ITEM_DEF, AuctionAggregatesTableMap::COL_SERVER, AuctionAggregatesTableMap::COL_LOW, AuctionAggregatesTableMap::COL_MEAN, AuctionAggregatesTableMap::COL_MEDIAN, AuctionAggregatesTableMap::COL_COUNT, AuctionAggregatesTableMap::COL_INSERTED, ],
        self::TYPE_FIELDNAME     => ['item_def', 'server', 'low', 'mean', 'median', 'count', 'inserted', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
    ];

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     *
     * @var array<string, mixed>
     */
    protected static $fieldKeys = [
        self::TYPE_PHPNAME       => ['ItemDef' => 0, 'Server' => 1, 'Low' => 2, 'Mean' => 3, 'Median' => 4, 'Count' => 5, 'Inserted' => 6, ],
        self::TYPE_CAMELNAME     => ['itemDef' => 0, 'server' => 1, 'low' => 2, 'mean' => 3, 'median' => 4, 'count' => 5, 'inserted' => 6, ],
        self::TYPE_COLNAME       => [AuctionAggregatesTableMap::COL_ITEM_DEF => 0, AuctionAggregatesTableMap::COL_SERVER => 1, AuctionAggregatesTableMap::COL_LOW => 2, AuctionAggregatesTableMap::COL_MEAN => 3, AuctionAggregatesTableMap::COL_MEDIAN => 4, AuctionAggregatesTableMap::COL_COUNT => 5, AuctionAggregatesTableMap::COL_INSERTED => 6, ],
        self::TYPE_FIELDNAME     => ['item_def' => 0, 'server' => 1, 'low' => 2, 'mean' => 3, 'median' => 4, 'count' => 5, 'inserted' => 6, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'ItemDef' => 'ITEM_DEF',
        'AuctionAggregates.ItemDef' => 'ITEM_DEF',
        'itemDef' => 'ITEM_DEF',
        'auctionAggregates.itemDef' => 'ITEM_DEF',
        'AuctionAggregatesTableMap::COL_ITEM_DEF' => 'ITEM_DEF',
        'COL_ITEM_DEF' => 'ITEM_DEF',
        'item_def' => 'ITEM_DEF',
        'auction_aggregates.item_def' => 'ITEM_DEF',
        'Server' => 'SERVER',
        'AuctionAggregates.Server' => 'SERVER',
        'server' => 'SERVER',
        'auctionAggregates.server' => 'SERVER',
        'AuctionAggregatesTableMap::COL_SERVER' => 'SERVER',
        'COL_SERVER' => 'SERVER',
        'auction_aggregates.server' => 'SERVER',
        'Low' => 'LOW',
        'AuctionAggregates.Low' => 'LOW',
        'low' => 'LOW',
        'auctionAggregates.low' => 'LOW',
        'AuctionAggregatesTableMap::COL_LOW' => 'LOW',
        'COL_LOW' => 'LOW',
        'auction_aggregates.low' => 'LOW',
        'Mean' => 'MEAN',
        'AuctionAggregates.Mean' => 'MEAN',
        'mean' => 'MEAN',
        'auctionAggregates.mean' => 'MEAN',
        'AuctionAggregatesTableMap::COL_MEAN' => 'MEAN',
        'COL_MEAN' => 'MEAN',
        'auction_aggregates.mean' => 'MEAN',
        'Median' => 'MEDIAN',
        'AuctionAggregates.Median' => 'MEDIAN',
        'median' => 'MEDIAN',
        'auctionAggregates.median' => 'MEDIAN',
        'AuctionAggregatesTableMap::COL_MEDIAN' => 'MEDIAN',
        'COL_MEDIAN' => 'MEDIAN',
        'auction_aggregates.median' => 'MEDIAN',
        'Count' => 'COUNT',
        'AuctionAggregates.Count' => 'COUNT',
        'count' => 'COUNT',
        'auctionAggregates.count' => 'COUNT',
        'AuctionAggregatesTableMap::COL_COUNT' => 'COUNT',
        'COL_COUNT' => 'COUNT',
        'auction_aggregates.count' => 'COUNT',
        'Inserted' => 'INSERTED',
        'AuctionAggregates.Inserted' => 'INSERTED',
        'inserted' => 'INSERTED',
        'auctionAggregates.inserted' => 'INSERTED',
        'AuctionAggregatesTableMap::COL_INSERTED' => 'INSERTED',
        'COL_INSERTED' => 'INSERTED',
        'auction_aggregates.inserted' => 'INSERTED',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function initialize(): void
    {
        // attributes
        $this->setName('auction_aggregates');
        $this->setPhpName('AuctionAggregates');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Schema\\Crawl\\AuctionAggregates\\AuctionAggregates');
        $this->setPackage('App.Schema.Crawl.AuctionAggregates');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('item_def', 'ItemDef', 'VARCHAR' , 'auction_items', 'item_def', true, 100, null);
        $this->addForeignPrimaryKey('server', 'Server', 'CHAR' , 'auction_items', 'server', true, null, null);
        $this->addColumn('low', 'Low', 'INTEGER', true, 10, null);
        $this->addColumn('mean', 'Mean', 'DOUBLE', true, null, null);
        $this->addColumn('median', 'Median', 'DOUBLE', true, null, null);
        $this->addColumn('count', 'Count', 'INTEGER', true, 10, null);
        $this->addPrimaryKey('inserted', 'Inserted', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('AuctionItems', '\\App\\Schema\\Crawl\\AuctionItems\\AuctionItems', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':item_def',
    1 => ':item_def',
  ),
  1 =>
  array (
    0 => ':server',
    1 => ':server',
  ),
), null, null, null, false);
    }

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \App\Schema\Crawl\AuctionAggregates\AuctionAggregates $obj A \App\Schema\Crawl\AuctionAggregates\AuctionAggregates object.
     * @param string|null $key Key (optional) to use for instance map (for performance boost if key was already calculated externally).
     *
     * @return void
     */
    public static function addInstanceToPool(AuctionAggregates $obj, ?string $key = null): void
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getItemDef() || is_scalar($obj->getItemDef()) || is_callable([$obj->getItemDef(), '__toString']) ? (string) $obj->getItemDef() : $obj->getItemDef()), (null === $obj->getServer() || is_scalar($obj->getServer()) || is_callable([$obj->getServer(), '__toString']) ? (string) $obj->getServer() : $obj->getServer()), (null === $obj->getInserted() || is_scalar($obj->getInserted()) || is_callable([$obj->getInserted(), '__toString']) ? (string) $obj->getInserted() : $obj->getInserted())]);
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \App\Schema\Crawl\AuctionAggregates\AuctionAggregates object or a primary key value.
     *
     * @return void
     */
    public static function removeInstanceFromPool($value): void
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \App\Schema\Crawl\AuctionAggregates\AuctionAggregates) {
                $key = serialize([(null === $value->getItemDef() || is_scalar($value->getItemDef()) || is_callable([$value->getItemDef(), '__toString']) ? (string) $value->getItemDef() : $value->getItemDef()), (null === $value->getServer() || is_scalar($value->getServer()) || is_callable([$value->getServer(), '__toString']) ? (string) $value->getServer() : $value->getServer()), (null === $value->getInserted() || is_scalar($value->getInserted()) || is_callable([$value->getInserted(), '__toString']) ? (string) $value->getInserted() : $value->getInserted())]);

            } elseif (is_array($value) && count($value) === 3) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1]), (null === $value[2] || is_scalar($value[2]) || is_callable([$value[2], '__toString']) ? (string) $value[2] : $value[2])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \App\Schema\Crawl\AuctionAggregates\AuctionAggregates object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string|null The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): ?string
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 6 + $offset : static::translateFieldName('Inserted', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 6 + $offset : static::translateFieldName('Inserted', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 6 + $offset : static::translateFieldName('Inserted', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 6 + $offset : static::translateFieldName('Inserted', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 6 + $offset : static::translateFieldName('Inserted', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 6 + $offset : static::translateFieldName('Inserted', TableMap::TYPE_PHPNAME, $indexType)])]);
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM)
    {
            $pks = [];

        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 6 + $offset
                : self::translateFieldName('Inserted', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param bool $withPrefix Whether to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass(bool $withPrefix = true): string
    {
        return $withPrefix ? AuctionAggregatesTableMap::CLASS_DEFAULT : AuctionAggregatesTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array $row Row returned by DataFetcher->fetch().
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array (AuctionAggregates object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = AuctionAggregatesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AuctionAggregatesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AuctionAggregatesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AuctionAggregatesTableMap::OM_CLASS;
            /** @var AuctionAggregates $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AuctionAggregatesTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array<object>
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher): array
    {
        $results = [];

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = AuctionAggregatesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AuctionAggregatesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var AuctionAggregates $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AuctionAggregatesTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria Object containing the columns to add.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function addSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->addSelectColumn(AuctionAggregatesTableMap::COL_ITEM_DEF);
            $criteria->addSelectColumn(AuctionAggregatesTableMap::COL_SERVER);
            $criteria->addSelectColumn(AuctionAggregatesTableMap::COL_LOW);
            $criteria->addSelectColumn(AuctionAggregatesTableMap::COL_MEAN);
            $criteria->addSelectColumn(AuctionAggregatesTableMap::COL_MEDIAN);
            $criteria->addSelectColumn(AuctionAggregatesTableMap::COL_COUNT);
            $criteria->addSelectColumn(AuctionAggregatesTableMap::COL_INSERTED);
        } else {
            $criteria->addSelectColumn($alias . '.item_def');
            $criteria->addSelectColumn($alias . '.server');
            $criteria->addSelectColumn($alias . '.low');
            $criteria->addSelectColumn($alias . '.mean');
            $criteria->addSelectColumn($alias . '.median');
            $criteria->addSelectColumn($alias . '.count');
            $criteria->addSelectColumn($alias . '.inserted');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria Object containing the columns to remove.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function removeSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(AuctionAggregatesTableMap::COL_ITEM_DEF);
            $criteria->removeSelectColumn(AuctionAggregatesTableMap::COL_SERVER);
            $criteria->removeSelectColumn(AuctionAggregatesTableMap::COL_LOW);
            $criteria->removeSelectColumn(AuctionAggregatesTableMap::COL_MEAN);
            $criteria->removeSelectColumn(AuctionAggregatesTableMap::COL_MEDIAN);
            $criteria->removeSelectColumn(AuctionAggregatesTableMap::COL_COUNT);
            $criteria->removeSelectColumn(AuctionAggregatesTableMap::COL_INSERTED);
        } else {
            $criteria->removeSelectColumn($alias . '.item_def');
            $criteria->removeSelectColumn($alias . '.server');
            $criteria->removeSelectColumn($alias . '.low');
            $criteria->removeSelectColumn($alias . '.mean');
            $criteria->removeSelectColumn($alias . '.median');
            $criteria->removeSelectColumn($alias . '.count');
            $criteria->removeSelectColumn($alias . '.inserted');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap(): TableMap
    {
        return Propel::getServiceContainer()->getDatabaseMap(AuctionAggregatesTableMap::DATABASE_NAME)->getTable(AuctionAggregatesTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a AuctionAggregates or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or AuctionAggregates object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ?ConnectionInterface $con = null): int
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionAggregatesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Schema\Crawl\AuctionAggregates\AuctionAggregates) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AuctionAggregatesTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = [$values];
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(AuctionAggregatesTableMap::COL_ITEM_DEF, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(AuctionAggregatesTableMap::COL_SERVER, $value[1]));
                $criterion->addAnd($criteria->getNewCriterion(AuctionAggregatesTableMap::COL_INSERTED, $value[2]));
                $criteria->addOr($criterion);
            }
        }

        $query = AuctionAggregatesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AuctionAggregatesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AuctionAggregatesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the auction_aggregates table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return AuctionAggregatesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AuctionAggregates or Criteria object.
     *
     * @param mixed $criteria Criteria or AuctionAggregates object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionAggregatesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AuctionAggregates object
        }


        // Set the correct dbName
        $query = AuctionAggregatesQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
