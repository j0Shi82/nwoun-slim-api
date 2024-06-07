<?php

namespace App\Schema\Crawl\AuctionDetails\Map;

use App\Schema\Crawl\AuctionDetails\AuctionDetails;
use App\Schema\Crawl\AuctionDetails\AuctionDetailsQuery;
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
 * This class defines the structure of the 'auction_details' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class AuctionDetailsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'App.Schema.Crawl.AuctionDetails.Map.AuctionDetailsTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'crawl';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'auction_details';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'AuctionDetails';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\App\\Schema\\Crawl\\AuctionDetails\\AuctionDetails';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'App.Schema.Crawl.AuctionDetails.AuctionDetails';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the item_def field
     */
    public const COL_ITEM_DEF = 'auction_details.item_def';

    /**
     * the column name for the server field
     */
    public const COL_SERVER = 'auction_details.server';

    /**
     * the column name for the seller_name field
     */
    public const COL_SELLER_NAME = 'auction_details.seller_name';

    /**
     * the column name for the seller_handle field
     */
    public const COL_SELLER_HANDLE = 'auction_details.seller_handle';

    /**
     * the column name for the expire_time field
     */
    public const COL_EXPIRE_TIME = 'auction_details.expire_time';

    /**
     * the column name for the price field
     */
    public const COL_PRICE = 'auction_details.price';

    /**
     * the column name for the count field
     */
    public const COL_COUNT = 'auction_details.count';

    /**
     * the column name for the price_per field
     */
    public const COL_PRICE_PER = 'auction_details.price_per';

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
        self::TYPE_PHPNAME       => ['ItemDef', 'Server', 'SellerName', 'SellerHandle', 'ExpireTime', 'Price', 'Count', 'PricePer', ],
        self::TYPE_CAMELNAME     => ['itemDef', 'server', 'sellerName', 'sellerHandle', 'expireTime', 'price', 'count', 'pricePer', ],
        self::TYPE_COLNAME       => [AuctionDetailsTableMap::COL_ITEM_DEF, AuctionDetailsTableMap::COL_SERVER, AuctionDetailsTableMap::COL_SELLER_NAME, AuctionDetailsTableMap::COL_SELLER_HANDLE, AuctionDetailsTableMap::COL_EXPIRE_TIME, AuctionDetailsTableMap::COL_PRICE, AuctionDetailsTableMap::COL_COUNT, AuctionDetailsTableMap::COL_PRICE_PER, ],
        self::TYPE_FIELDNAME     => ['item_def', 'server', 'seller_name', 'seller_handle', 'expire_time', 'price', 'count', 'price_per', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, ]
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
        self::TYPE_PHPNAME       => ['ItemDef' => 0, 'Server' => 1, 'SellerName' => 2, 'SellerHandle' => 3, 'ExpireTime' => 4, 'Price' => 5, 'Count' => 6, 'PricePer' => 7, ],
        self::TYPE_CAMELNAME     => ['itemDef' => 0, 'server' => 1, 'sellerName' => 2, 'sellerHandle' => 3, 'expireTime' => 4, 'price' => 5, 'count' => 6, 'pricePer' => 7, ],
        self::TYPE_COLNAME       => [AuctionDetailsTableMap::COL_ITEM_DEF => 0, AuctionDetailsTableMap::COL_SERVER => 1, AuctionDetailsTableMap::COL_SELLER_NAME => 2, AuctionDetailsTableMap::COL_SELLER_HANDLE => 3, AuctionDetailsTableMap::COL_EXPIRE_TIME => 4, AuctionDetailsTableMap::COL_PRICE => 5, AuctionDetailsTableMap::COL_COUNT => 6, AuctionDetailsTableMap::COL_PRICE_PER => 7, ],
        self::TYPE_FIELDNAME     => ['item_def' => 0, 'server' => 1, 'seller_name' => 2, 'seller_handle' => 3, 'expire_time' => 4, 'price' => 5, 'count' => 6, 'price_per' => 7, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'ItemDef' => 'ITEM_DEF',
        'AuctionDetails.ItemDef' => 'ITEM_DEF',
        'itemDef' => 'ITEM_DEF',
        'auctionDetails.itemDef' => 'ITEM_DEF',
        'AuctionDetailsTableMap::COL_ITEM_DEF' => 'ITEM_DEF',
        'COL_ITEM_DEF' => 'ITEM_DEF',
        'item_def' => 'ITEM_DEF',
        'auction_details.item_def' => 'ITEM_DEF',
        'Server' => 'SERVER',
        'AuctionDetails.Server' => 'SERVER',
        'server' => 'SERVER',
        'auctionDetails.server' => 'SERVER',
        'AuctionDetailsTableMap::COL_SERVER' => 'SERVER',
        'COL_SERVER' => 'SERVER',
        'auction_details.server' => 'SERVER',
        'SellerName' => 'SELLER_NAME',
        'AuctionDetails.SellerName' => 'SELLER_NAME',
        'sellerName' => 'SELLER_NAME',
        'auctionDetails.sellerName' => 'SELLER_NAME',
        'AuctionDetailsTableMap::COL_SELLER_NAME' => 'SELLER_NAME',
        'COL_SELLER_NAME' => 'SELLER_NAME',
        'seller_name' => 'SELLER_NAME',
        'auction_details.seller_name' => 'SELLER_NAME',
        'SellerHandle' => 'SELLER_HANDLE',
        'AuctionDetails.SellerHandle' => 'SELLER_HANDLE',
        'sellerHandle' => 'SELLER_HANDLE',
        'auctionDetails.sellerHandle' => 'SELLER_HANDLE',
        'AuctionDetailsTableMap::COL_SELLER_HANDLE' => 'SELLER_HANDLE',
        'COL_SELLER_HANDLE' => 'SELLER_HANDLE',
        'seller_handle' => 'SELLER_HANDLE',
        'auction_details.seller_handle' => 'SELLER_HANDLE',
        'ExpireTime' => 'EXPIRE_TIME',
        'AuctionDetails.ExpireTime' => 'EXPIRE_TIME',
        'expireTime' => 'EXPIRE_TIME',
        'auctionDetails.expireTime' => 'EXPIRE_TIME',
        'AuctionDetailsTableMap::COL_EXPIRE_TIME' => 'EXPIRE_TIME',
        'COL_EXPIRE_TIME' => 'EXPIRE_TIME',
        'expire_time' => 'EXPIRE_TIME',
        'auction_details.expire_time' => 'EXPIRE_TIME',
        'Price' => 'PRICE',
        'AuctionDetails.Price' => 'PRICE',
        'price' => 'PRICE',
        'auctionDetails.price' => 'PRICE',
        'AuctionDetailsTableMap::COL_PRICE' => 'PRICE',
        'COL_PRICE' => 'PRICE',
        'auction_details.price' => 'PRICE',
        'Count' => 'COUNT',
        'AuctionDetails.Count' => 'COUNT',
        'count' => 'COUNT',
        'auctionDetails.count' => 'COUNT',
        'AuctionDetailsTableMap::COL_COUNT' => 'COUNT',
        'COL_COUNT' => 'COUNT',
        'auction_details.count' => 'COUNT',
        'PricePer' => 'PRICE_PER',
        'AuctionDetails.PricePer' => 'PRICE_PER',
        'pricePer' => 'PRICE_PER',
        'auctionDetails.pricePer' => 'PRICE_PER',
        'AuctionDetailsTableMap::COL_PRICE_PER' => 'PRICE_PER',
        'COL_PRICE_PER' => 'PRICE_PER',
        'price_per' => 'PRICE_PER',
        'auction_details.price_per' => 'PRICE_PER',
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
        $this->setName('auction_details');
        $this->setPhpName('AuctionDetails');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Schema\\Crawl\\AuctionDetails\\AuctionDetails');
        $this->setPackage('App.Schema.Crawl.AuctionDetails');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('item_def', 'ItemDef', 'VARCHAR' , 'auction_items', 'item_def', true, 100, null);
        $this->addForeignPrimaryKey('server', 'Server', 'CHAR' , 'auction_items', 'server', true, null, null);
        $this->addPrimaryKey('seller_name', 'SellerName', 'VARCHAR', true, 50, null);
        $this->addPrimaryKey('seller_handle', 'SellerHandle', 'VARCHAR', true, 50, null);
        $this->addPrimaryKey('expire_time', 'ExpireTime', 'BIGINT', true, null, null);
        $this->addColumn('price', 'Price', 'INTEGER', true, 10, null);
        $this->addColumn('count', 'Count', 'INTEGER', true, 10, null);
        $this->addColumn('price_per', 'PricePer', 'FLOAT', true, null, null);
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
     * @param \App\Schema\Crawl\AuctionDetails\AuctionDetails $obj A \App\Schema\Crawl\AuctionDetails\AuctionDetails object.
     * @param string|null $key Key (optional) to use for instance map (for performance boost if key was already calculated externally).
     *
     * @return void
     */
    public static function addInstanceToPool(AuctionDetails $obj, ?string $key = null): void
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getItemDef() || is_scalar($obj->getItemDef()) || is_callable([$obj->getItemDef(), '__toString']) ? (string) $obj->getItemDef() : $obj->getItemDef()), (null === $obj->getServer() || is_scalar($obj->getServer()) || is_callable([$obj->getServer(), '__toString']) ? (string) $obj->getServer() : $obj->getServer()), (null === $obj->getSellerName() || is_scalar($obj->getSellerName()) || is_callable([$obj->getSellerName(), '__toString']) ? (string) $obj->getSellerName() : $obj->getSellerName()), (null === $obj->getSellerHandle() || is_scalar($obj->getSellerHandle()) || is_callable([$obj->getSellerHandle(), '__toString']) ? (string) $obj->getSellerHandle() : $obj->getSellerHandle()), (null === $obj->getExpireTime() || is_scalar($obj->getExpireTime()) || is_callable([$obj->getExpireTime(), '__toString']) ? (string) $obj->getExpireTime() : $obj->getExpireTime())]);
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
     * @param mixed $value A \App\Schema\Crawl\AuctionDetails\AuctionDetails object or a primary key value.
     *
     * @return void
     */
    public static function removeInstanceFromPool($value): void
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \App\Schema\Crawl\AuctionDetails\AuctionDetails) {
                $key = serialize([(null === $value->getItemDef() || is_scalar($value->getItemDef()) || is_callable([$value->getItemDef(), '__toString']) ? (string) $value->getItemDef() : $value->getItemDef()), (null === $value->getServer() || is_scalar($value->getServer()) || is_callable([$value->getServer(), '__toString']) ? (string) $value->getServer() : $value->getServer()), (null === $value->getSellerName() || is_scalar($value->getSellerName()) || is_callable([$value->getSellerName(), '__toString']) ? (string) $value->getSellerName() : $value->getSellerName()), (null === $value->getSellerHandle() || is_scalar($value->getSellerHandle()) || is_callable([$value->getSellerHandle(), '__toString']) ? (string) $value->getSellerHandle() : $value->getSellerHandle()), (null === $value->getExpireTime() || is_scalar($value->getExpireTime()) || is_callable([$value->getExpireTime(), '__toString']) ? (string) $value->getExpireTime() : $value->getExpireTime())]);

            } elseif (is_array($value) && count($value) === 5) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1]), (null === $value[2] || is_scalar($value[2]) || is_callable([$value[2], '__toString']) ? (string) $value[2] : $value[2]), (null === $value[3] || is_scalar($value[3]) || is_callable([$value[3], '__toString']) ? (string) $value[3] : $value[3]), (null === $value[4] || is_scalar($value[4]) || is_callable([$value[4], '__toString']) ? (string) $value[4] : $value[4])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \App\Schema\Crawl\AuctionDetails\AuctionDetails object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('SellerName', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('SellerHandle', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('ExpireTime', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('SellerName', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('SellerName', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('SellerName', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('SellerName', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('SellerName', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('SellerHandle', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('SellerHandle', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('SellerHandle', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('SellerHandle', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('SellerHandle', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('ExpireTime', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('ExpireTime', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('ExpireTime', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('ExpireTime', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('ExpireTime', TableMap::TYPE_PHPNAME, $indexType)])]);
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
                ? 2 + $offset
                : self::translateFieldName('SellerName', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 3 + $offset
                : self::translateFieldName('SellerHandle', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 4 + $offset
                : self::translateFieldName('ExpireTime', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? AuctionDetailsTableMap::CLASS_DEFAULT : AuctionDetailsTableMap::OM_CLASS;
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
     * @return array (AuctionDetails object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = AuctionDetailsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AuctionDetailsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AuctionDetailsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AuctionDetailsTableMap::OM_CLASS;
            /** @var AuctionDetails $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AuctionDetailsTableMap::addInstanceToPool($obj, $key);
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
            $key = AuctionDetailsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AuctionDetailsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var AuctionDetails $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AuctionDetailsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AuctionDetailsTableMap::COL_ITEM_DEF);
            $criteria->addSelectColumn(AuctionDetailsTableMap::COL_SERVER);
            $criteria->addSelectColumn(AuctionDetailsTableMap::COL_SELLER_NAME);
            $criteria->addSelectColumn(AuctionDetailsTableMap::COL_SELLER_HANDLE);
            $criteria->addSelectColumn(AuctionDetailsTableMap::COL_EXPIRE_TIME);
            $criteria->addSelectColumn(AuctionDetailsTableMap::COL_PRICE);
            $criteria->addSelectColumn(AuctionDetailsTableMap::COL_COUNT);
            $criteria->addSelectColumn(AuctionDetailsTableMap::COL_PRICE_PER);
        } else {
            $criteria->addSelectColumn($alias . '.item_def');
            $criteria->addSelectColumn($alias . '.server');
            $criteria->addSelectColumn($alias . '.seller_name');
            $criteria->addSelectColumn($alias . '.seller_handle');
            $criteria->addSelectColumn($alias . '.expire_time');
            $criteria->addSelectColumn($alias . '.price');
            $criteria->addSelectColumn($alias . '.count');
            $criteria->addSelectColumn($alias . '.price_per');
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
            $criteria->removeSelectColumn(AuctionDetailsTableMap::COL_ITEM_DEF);
            $criteria->removeSelectColumn(AuctionDetailsTableMap::COL_SERVER);
            $criteria->removeSelectColumn(AuctionDetailsTableMap::COL_SELLER_NAME);
            $criteria->removeSelectColumn(AuctionDetailsTableMap::COL_SELLER_HANDLE);
            $criteria->removeSelectColumn(AuctionDetailsTableMap::COL_EXPIRE_TIME);
            $criteria->removeSelectColumn(AuctionDetailsTableMap::COL_PRICE);
            $criteria->removeSelectColumn(AuctionDetailsTableMap::COL_COUNT);
            $criteria->removeSelectColumn(AuctionDetailsTableMap::COL_PRICE_PER);
        } else {
            $criteria->removeSelectColumn($alias . '.item_def');
            $criteria->removeSelectColumn($alias . '.server');
            $criteria->removeSelectColumn($alias . '.seller_name');
            $criteria->removeSelectColumn($alias . '.seller_handle');
            $criteria->removeSelectColumn($alias . '.expire_time');
            $criteria->removeSelectColumn($alias . '.price');
            $criteria->removeSelectColumn($alias . '.count');
            $criteria->removeSelectColumn($alias . '.price_per');
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
        return Propel::getServiceContainer()->getDatabaseMap(AuctionDetailsTableMap::DATABASE_NAME)->getTable(AuctionDetailsTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a AuctionDetails or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or AuctionDetails object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionDetailsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Schema\Crawl\AuctionDetails\AuctionDetails) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AuctionDetailsTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = [$values];
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(AuctionDetailsTableMap::COL_ITEM_DEF, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(AuctionDetailsTableMap::COL_SERVER, $value[1]));
                $criterion->addAnd($criteria->getNewCriterion(AuctionDetailsTableMap::COL_SELLER_NAME, $value[2]));
                $criterion->addAnd($criteria->getNewCriterion(AuctionDetailsTableMap::COL_SELLER_HANDLE, $value[3]));
                $criterion->addAnd($criteria->getNewCriterion(AuctionDetailsTableMap::COL_EXPIRE_TIME, $value[4]));
                $criteria->addOr($criterion);
            }
        }

        $query = AuctionDetailsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AuctionDetailsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AuctionDetailsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the auction_details table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return AuctionDetailsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AuctionDetails or Criteria object.
     *
     * @param mixed $criteria Criteria or AuctionDetails object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionDetailsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AuctionDetails object
        }


        // Set the correct dbName
        $query = AuctionDetailsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
