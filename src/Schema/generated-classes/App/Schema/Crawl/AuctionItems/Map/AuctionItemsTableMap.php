<?php

namespace App\Schema\Crawl\AuctionItems\Map;

use App\Schema\Crawl\AuctionItems\AuctionItems;
use App\Schema\Crawl\AuctionItems\AuctionItemsQuery;
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
 * This class defines the structure of the 'auction_items' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class AuctionItemsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'App.Schema.Crawl.AuctionItems.Map.AuctionItemsTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'crawl';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'auction_items';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'AuctionItems';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\App\\Schema\\Crawl\\AuctionItems\\AuctionItems';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'App.Schema.Crawl.AuctionItems.AuctionItems';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the item_def field
     */
    public const COL_ITEM_DEF = 'auction_items.item_def';

    /**
     * the column name for the item_name field
     */
    public const COL_ITEM_NAME = 'auction_items.item_name';

    /**
     * the column name for the search_term field
     */
    public const COL_SEARCH_TERM = 'auction_items.search_term';

    /**
     * the column name for the quality field
     */
    public const COL_QUALITY = 'auction_items.quality';

    /**
     * the column name for the categories field
     */
    public const COL_CATEGORIES = 'auction_items.categories';

    /**
     * the column name for the crawl_category field
     */
    public const COL_CRAWL_CATEGORY = 'auction_items.crawl_category';

    /**
     * the column name for the allow_auto field
     */
    public const COL_ALLOW_AUTO = 'auction_items.allow_auto';

    /**
     * the column name for the server field
     */
    public const COL_SERVER = 'auction_items.server';

    /**
     * the column name for the update_date field
     */
    public const COL_UPDATE_DATE = 'auction_items.update_date';

    /**
     * the column name for the locked_date field
     */
    public const COL_LOCKED_DATE = 'auction_items.locked_date';

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
        self::TYPE_PHPNAME       => ['ItemDef', 'ItemName', 'SearchTerm', 'Quality', 'Categories', 'CrawlCategory', 'AllowAuto', 'Server', 'UpdateDate', 'LockedDate', ],
        self::TYPE_CAMELNAME     => ['itemDef', 'itemName', 'searchTerm', 'quality', 'categories', 'crawlCategory', 'allowAuto', 'server', 'updateDate', 'lockedDate', ],
        self::TYPE_COLNAME       => [AuctionItemsTableMap::COL_ITEM_DEF, AuctionItemsTableMap::COL_ITEM_NAME, AuctionItemsTableMap::COL_SEARCH_TERM, AuctionItemsTableMap::COL_QUALITY, AuctionItemsTableMap::COL_CATEGORIES, AuctionItemsTableMap::COL_CRAWL_CATEGORY, AuctionItemsTableMap::COL_ALLOW_AUTO, AuctionItemsTableMap::COL_SERVER, AuctionItemsTableMap::COL_UPDATE_DATE, AuctionItemsTableMap::COL_LOCKED_DATE, ],
        self::TYPE_FIELDNAME     => ['item_def', 'item_name', 'search_term', 'quality', 'categories', 'crawl_category', 'allow_auto', 'server', 'update_date', 'locked_date', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, ]
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
        self::TYPE_PHPNAME       => ['ItemDef' => 0, 'ItemName' => 1, 'SearchTerm' => 2, 'Quality' => 3, 'Categories' => 4, 'CrawlCategory' => 5, 'AllowAuto' => 6, 'Server' => 7, 'UpdateDate' => 8, 'LockedDate' => 9, ],
        self::TYPE_CAMELNAME     => ['itemDef' => 0, 'itemName' => 1, 'searchTerm' => 2, 'quality' => 3, 'categories' => 4, 'crawlCategory' => 5, 'allowAuto' => 6, 'server' => 7, 'updateDate' => 8, 'lockedDate' => 9, ],
        self::TYPE_COLNAME       => [AuctionItemsTableMap::COL_ITEM_DEF => 0, AuctionItemsTableMap::COL_ITEM_NAME => 1, AuctionItemsTableMap::COL_SEARCH_TERM => 2, AuctionItemsTableMap::COL_QUALITY => 3, AuctionItemsTableMap::COL_CATEGORIES => 4, AuctionItemsTableMap::COL_CRAWL_CATEGORY => 5, AuctionItemsTableMap::COL_ALLOW_AUTO => 6, AuctionItemsTableMap::COL_SERVER => 7, AuctionItemsTableMap::COL_UPDATE_DATE => 8, AuctionItemsTableMap::COL_LOCKED_DATE => 9, ],
        self::TYPE_FIELDNAME     => ['item_def' => 0, 'item_name' => 1, 'search_term' => 2, 'quality' => 3, 'categories' => 4, 'crawl_category' => 5, 'allow_auto' => 6, 'server' => 7, 'update_date' => 8, 'locked_date' => 9, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'ItemDef' => 'ITEM_DEF',
        'AuctionItems.ItemDef' => 'ITEM_DEF',
        'itemDef' => 'ITEM_DEF',
        'auctionItems.itemDef' => 'ITEM_DEF',
        'AuctionItemsTableMap::COL_ITEM_DEF' => 'ITEM_DEF',
        'COL_ITEM_DEF' => 'ITEM_DEF',
        'item_def' => 'ITEM_DEF',
        'auction_items.item_def' => 'ITEM_DEF',
        'ItemName' => 'ITEM_NAME',
        'AuctionItems.ItemName' => 'ITEM_NAME',
        'itemName' => 'ITEM_NAME',
        'auctionItems.itemName' => 'ITEM_NAME',
        'AuctionItemsTableMap::COL_ITEM_NAME' => 'ITEM_NAME',
        'COL_ITEM_NAME' => 'ITEM_NAME',
        'item_name' => 'ITEM_NAME',
        'auction_items.item_name' => 'ITEM_NAME',
        'SearchTerm' => 'SEARCH_TERM',
        'AuctionItems.SearchTerm' => 'SEARCH_TERM',
        'searchTerm' => 'SEARCH_TERM',
        'auctionItems.searchTerm' => 'SEARCH_TERM',
        'AuctionItemsTableMap::COL_SEARCH_TERM' => 'SEARCH_TERM',
        'COL_SEARCH_TERM' => 'SEARCH_TERM',
        'search_term' => 'SEARCH_TERM',
        'auction_items.search_term' => 'SEARCH_TERM',
        'Quality' => 'QUALITY',
        'AuctionItems.Quality' => 'QUALITY',
        'quality' => 'QUALITY',
        'auctionItems.quality' => 'QUALITY',
        'AuctionItemsTableMap::COL_QUALITY' => 'QUALITY',
        'COL_QUALITY' => 'QUALITY',
        'auction_items.quality' => 'QUALITY',
        'Categories' => 'CATEGORIES',
        'AuctionItems.Categories' => 'CATEGORIES',
        'categories' => 'CATEGORIES',
        'auctionItems.categories' => 'CATEGORIES',
        'AuctionItemsTableMap::COL_CATEGORIES' => 'CATEGORIES',
        'COL_CATEGORIES' => 'CATEGORIES',
        'auction_items.categories' => 'CATEGORIES',
        'CrawlCategory' => 'CRAWL_CATEGORY',
        'AuctionItems.CrawlCategory' => 'CRAWL_CATEGORY',
        'crawlCategory' => 'CRAWL_CATEGORY',
        'auctionItems.crawlCategory' => 'CRAWL_CATEGORY',
        'AuctionItemsTableMap::COL_CRAWL_CATEGORY' => 'CRAWL_CATEGORY',
        'COL_CRAWL_CATEGORY' => 'CRAWL_CATEGORY',
        'crawl_category' => 'CRAWL_CATEGORY',
        'auction_items.crawl_category' => 'CRAWL_CATEGORY',
        'AllowAuto' => 'ALLOW_AUTO',
        'AuctionItems.AllowAuto' => 'ALLOW_AUTO',
        'allowAuto' => 'ALLOW_AUTO',
        'auctionItems.allowAuto' => 'ALLOW_AUTO',
        'AuctionItemsTableMap::COL_ALLOW_AUTO' => 'ALLOW_AUTO',
        'COL_ALLOW_AUTO' => 'ALLOW_AUTO',
        'allow_auto' => 'ALLOW_AUTO',
        'auction_items.allow_auto' => 'ALLOW_AUTO',
        'Server' => 'SERVER',
        'AuctionItems.Server' => 'SERVER',
        'server' => 'SERVER',
        'auctionItems.server' => 'SERVER',
        'AuctionItemsTableMap::COL_SERVER' => 'SERVER',
        'COL_SERVER' => 'SERVER',
        'auction_items.server' => 'SERVER',
        'UpdateDate' => 'UPDATE_DATE',
        'AuctionItems.UpdateDate' => 'UPDATE_DATE',
        'updateDate' => 'UPDATE_DATE',
        'auctionItems.updateDate' => 'UPDATE_DATE',
        'AuctionItemsTableMap::COL_UPDATE_DATE' => 'UPDATE_DATE',
        'COL_UPDATE_DATE' => 'UPDATE_DATE',
        'update_date' => 'UPDATE_DATE',
        'auction_items.update_date' => 'UPDATE_DATE',
        'LockedDate' => 'LOCKED_DATE',
        'AuctionItems.LockedDate' => 'LOCKED_DATE',
        'lockedDate' => 'LOCKED_DATE',
        'auctionItems.lockedDate' => 'LOCKED_DATE',
        'AuctionItemsTableMap::COL_LOCKED_DATE' => 'LOCKED_DATE',
        'COL_LOCKED_DATE' => 'LOCKED_DATE',
        'locked_date' => 'LOCKED_DATE',
        'auction_items.locked_date' => 'LOCKED_DATE',
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
        $this->setName('auction_items');
        $this->setPhpName('AuctionItems');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Schema\\Crawl\\AuctionItems\\AuctionItems');
        $this->setPackage('App.Schema.Crawl.AuctionItems');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('item_def', 'ItemDef', 'VARCHAR', true, 100, null);
        $this->addColumn('item_name', 'ItemName', 'VARCHAR', true, 100, null);
        $this->addColumn('search_term', 'SearchTerm', 'VARCHAR', true, 100, null);
        $this->addColumn('quality', 'Quality', 'VARCHAR', true, 20, null);
        $this->addColumn('categories', 'Categories', 'JSON', true, null, null);
        $this->addColumn('crawl_category', 'CrawlCategory', 'CHAR', false, null, null);
        $this->addColumn('allow_auto', 'AllowAuto', 'BOOLEAN', true, 1, true);
        $this->addPrimaryKey('server', 'Server', 'CHAR', true, null, 'GLOBAL');
        $this->addColumn('update_date', 'UpdateDate', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('locked_date', 'LockedDate', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('AuctionAggregates', '\\App\\Schema\\Crawl\\AuctionAggregates\\AuctionAggregates', RelationMap::ONE_TO_MANY, array (
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
), null, null, 'AuctionAggregatess', false);
        $this->addRelation('AuctionDetails', '\\App\\Schema\\Crawl\\AuctionDetails\\AuctionDetails', RelationMap::ONE_TO_MANY, array (
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
), null, null, 'AuctionDetailss', false);
    }

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \App\Schema\Crawl\AuctionItems\AuctionItems $obj A \App\Schema\Crawl\AuctionItems\AuctionItems object.
     * @param string|null $key Key (optional) to use for instance map (for performance boost if key was already calculated externally).
     *
     * @return void
     */
    public static function addInstanceToPool(AuctionItems $obj, ?string $key = null): void
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getItemDef() || is_scalar($obj->getItemDef()) || is_callable([$obj->getItemDef(), '__toString']) ? (string) $obj->getItemDef() : $obj->getItemDef()), (null === $obj->getServer() || is_scalar($obj->getServer()) || is_callable([$obj->getServer(), '__toString']) ? (string) $obj->getServer() : $obj->getServer())]);
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
     * @param mixed $value A \App\Schema\Crawl\AuctionItems\AuctionItems object or a primary key value.
     *
     * @return void
     */
    public static function removeInstanceFromPool($value): void
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \App\Schema\Crawl\AuctionItems\AuctionItems) {
                $key = serialize([(null === $value->getItemDef() || is_scalar($value->getItemDef()) || is_callable([$value->getItemDef(), '__toString']) ? (string) $value->getItemDef() : $value->getItemDef()), (null === $value->getServer() || is_scalar($value->getServer()) || is_callable([$value->getServer(), '__toString']) ? (string) $value->getServer() : $value->getServer())]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \App\Schema\Crawl\AuctionItems\AuctionItems object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)])]);
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
                ? 7 + $offset
                : self::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? AuctionItemsTableMap::CLASS_DEFAULT : AuctionItemsTableMap::OM_CLASS;
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
     * @return array (AuctionItems object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = AuctionItemsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AuctionItemsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AuctionItemsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AuctionItemsTableMap::OM_CLASS;
            /** @var AuctionItems $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AuctionItemsTableMap::addInstanceToPool($obj, $key);
        }

        return [$obj, $col];
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
            $key = AuctionItemsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AuctionItemsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var AuctionItems $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AuctionItemsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_ITEM_DEF);
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_ITEM_NAME);
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_SEARCH_TERM);
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_QUALITY);
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_CATEGORIES);
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_CRAWL_CATEGORY);
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_ALLOW_AUTO);
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_SERVER);
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_UPDATE_DATE);
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_LOCKED_DATE);
        } else {
            $criteria->addSelectColumn($alias . '.item_def');
            $criteria->addSelectColumn($alias . '.item_name');
            $criteria->addSelectColumn($alias . '.search_term');
            $criteria->addSelectColumn($alias . '.quality');
            $criteria->addSelectColumn($alias . '.categories');
            $criteria->addSelectColumn($alias . '.crawl_category');
            $criteria->addSelectColumn($alias . '.allow_auto');
            $criteria->addSelectColumn($alias . '.server');
            $criteria->addSelectColumn($alias . '.update_date');
            $criteria->addSelectColumn($alias . '.locked_date');
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
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_ITEM_DEF);
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_ITEM_NAME);
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_SEARCH_TERM);
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_QUALITY);
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_CATEGORIES);
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_CRAWL_CATEGORY);
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_ALLOW_AUTO);
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_SERVER);
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_UPDATE_DATE);
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_LOCKED_DATE);
        } else {
            $criteria->removeSelectColumn($alias . '.item_def');
            $criteria->removeSelectColumn($alias . '.item_name');
            $criteria->removeSelectColumn($alias . '.search_term');
            $criteria->removeSelectColumn($alias . '.quality');
            $criteria->removeSelectColumn($alias . '.categories');
            $criteria->removeSelectColumn($alias . '.crawl_category');
            $criteria->removeSelectColumn($alias . '.allow_auto');
            $criteria->removeSelectColumn($alias . '.server');
            $criteria->removeSelectColumn($alias . '.update_date');
            $criteria->removeSelectColumn($alias . '.locked_date');
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
        return Propel::getServiceContainer()->getDatabaseMap(AuctionItemsTableMap::DATABASE_NAME)->getTable(AuctionItemsTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a AuctionItems or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or AuctionItems object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionItemsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Schema\Crawl\AuctionItems\AuctionItems) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AuctionItemsTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = [$values];
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(AuctionItemsTableMap::COL_ITEM_DEF, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(AuctionItemsTableMap::COL_SERVER, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = AuctionItemsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AuctionItemsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AuctionItemsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the auction_items table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return AuctionItemsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AuctionItems or Criteria object.
     *
     * @param mixed $criteria Criteria or AuctionItems object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionItemsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AuctionItems object
        }


        // Set the correct dbName
        $query = AuctionItemsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
