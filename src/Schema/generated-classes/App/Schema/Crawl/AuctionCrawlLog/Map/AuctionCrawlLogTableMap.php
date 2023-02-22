<?php

namespace App\Schema\Crawl\AuctionCrawlLog\Map;

use App\Schema\Crawl\AuctionCrawlLog\AuctionCrawlLog;
use App\Schema\Crawl\AuctionCrawlLog\AuctionCrawlLogQuery;
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
 * This class defines the structure of the 'auction_crawl_log' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class AuctionCrawlLogTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'App.Schema.Crawl.AuctionCrawlLog.Map.AuctionCrawlLogTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'crawl';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'auction_crawl_log';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\App\\Schema\\Crawl\\AuctionCrawlLog\\AuctionCrawlLog';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'App.Schema.Crawl.AuctionCrawlLog.AuctionCrawlLog';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the item_def field
     */
    public const COL_ITEM_DEF = 'auction_crawl_log.item_def';

    /**
     * the column name for the character_name field
     */
    public const COL_CHARACTER_NAME = 'auction_crawl_log.character_name';

    /**
     * the column name for the account_name field
     */
    public const COL_ACCOUNT_NAME = 'auction_crawl_log.account_name';

    /**
     * the column name for the item_count field
     */
    public const COL_ITEM_COUNT = 'auction_crawl_log.item_count';

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
        self::TYPE_PHPNAME       => ['ItemDef', 'CharacterName', 'AccountName', 'ItemCount', ],
        self::TYPE_CAMELNAME     => ['itemDef', 'characterName', 'accountName', 'itemCount', ],
        self::TYPE_COLNAME       => [AuctionCrawlLogTableMap::COL_ITEM_DEF, AuctionCrawlLogTableMap::COL_CHARACTER_NAME, AuctionCrawlLogTableMap::COL_ACCOUNT_NAME, AuctionCrawlLogTableMap::COL_ITEM_COUNT, ],
        self::TYPE_FIELDNAME     => ['item_def', 'character_name', 'account_name', 'item_count', ],
        self::TYPE_NUM           => [0, 1, 2, 3, ]
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
        self::TYPE_PHPNAME       => ['ItemDef' => 0, 'CharacterName' => 1, 'AccountName' => 2, 'ItemCount' => 3, ],
        self::TYPE_CAMELNAME     => ['itemDef' => 0, 'characterName' => 1, 'accountName' => 2, 'itemCount' => 3, ],
        self::TYPE_COLNAME       => [AuctionCrawlLogTableMap::COL_ITEM_DEF => 0, AuctionCrawlLogTableMap::COL_CHARACTER_NAME => 1, AuctionCrawlLogTableMap::COL_ACCOUNT_NAME => 2, AuctionCrawlLogTableMap::COL_ITEM_COUNT => 3, ],
        self::TYPE_FIELDNAME     => ['item_def' => 0, 'character_name' => 1, 'account_name' => 2, 'item_count' => 3, ],
        self::TYPE_NUM           => [0, 1, 2, 3, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'ItemDef' => 'ITEM_DEF',
        'AuctionCrawlLog.ItemDef' => 'ITEM_DEF',
        'itemDef' => 'ITEM_DEF',
        'auctionCrawlLog.itemDef' => 'ITEM_DEF',
        'AuctionCrawlLogTableMap::COL_ITEM_DEF' => 'ITEM_DEF',
        'COL_ITEM_DEF' => 'ITEM_DEF',
        'item_def' => 'ITEM_DEF',
        'auction_crawl_log.item_def' => 'ITEM_DEF',
        'CharacterName' => 'CHARACTER_NAME',
        'AuctionCrawlLog.CharacterName' => 'CHARACTER_NAME',
        'characterName' => 'CHARACTER_NAME',
        'auctionCrawlLog.characterName' => 'CHARACTER_NAME',
        'AuctionCrawlLogTableMap::COL_CHARACTER_NAME' => 'CHARACTER_NAME',
        'COL_CHARACTER_NAME' => 'CHARACTER_NAME',
        'character_name' => 'CHARACTER_NAME',
        'auction_crawl_log.character_name' => 'CHARACTER_NAME',
        'AccountName' => 'ACCOUNT_NAME',
        'AuctionCrawlLog.AccountName' => 'ACCOUNT_NAME',
        'accountName' => 'ACCOUNT_NAME',
        'auctionCrawlLog.accountName' => 'ACCOUNT_NAME',
        'AuctionCrawlLogTableMap::COL_ACCOUNT_NAME' => 'ACCOUNT_NAME',
        'COL_ACCOUNT_NAME' => 'ACCOUNT_NAME',
        'account_name' => 'ACCOUNT_NAME',
        'auction_crawl_log.account_name' => 'ACCOUNT_NAME',
        'ItemCount' => 'ITEM_COUNT',
        'AuctionCrawlLog.ItemCount' => 'ITEM_COUNT',
        'itemCount' => 'ITEM_COUNT',
        'auctionCrawlLog.itemCount' => 'ITEM_COUNT',
        'AuctionCrawlLogTableMap::COL_ITEM_COUNT' => 'ITEM_COUNT',
        'COL_ITEM_COUNT' => 'ITEM_COUNT',
        'item_count' => 'ITEM_COUNT',
        'auction_crawl_log.item_count' => 'ITEM_COUNT',
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
        $this->setName('auction_crawl_log');
        $this->setPhpName('AuctionCrawlLog');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Schema\\Crawl\\AuctionCrawlLog\\AuctionCrawlLog');
        $this->setPackage('App.Schema.Crawl.AuctionCrawlLog');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('item_def', 'ItemDef', 'VARCHAR', true, 100, null);
        $this->addPrimaryKey('character_name', 'CharacterName', 'VARCHAR', true, 100, null);
        $this->addPrimaryKey('account_name', 'AccountName', 'VARCHAR', true, 100, null);
        $this->addColumn('item_count', 'ItemCount', 'INTEGER', true, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
    }

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \App\Schema\Crawl\AuctionCrawlLog\AuctionCrawlLog $obj A \App\Schema\Crawl\AuctionCrawlLog\AuctionCrawlLog object.
     * @param string|null $key Key (optional) to use for instance map (for performance boost if key was already calculated externally).
     *
     * @return void
     */
    public static function addInstanceToPool(AuctionCrawlLog $obj, ?string $key = null): void
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getItemDef() || is_scalar($obj->getItemDef()) || is_callable([$obj->getItemDef(), '__toString']) ? (string) $obj->getItemDef() : $obj->getItemDef()), (null === $obj->getCharacterName() || is_scalar($obj->getCharacterName()) || is_callable([$obj->getCharacterName(), '__toString']) ? (string) $obj->getCharacterName() : $obj->getCharacterName()), (null === $obj->getAccountName() || is_scalar($obj->getAccountName()) || is_callable([$obj->getAccountName(), '__toString']) ? (string) $obj->getAccountName() : $obj->getAccountName())]);
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
     * @param mixed $value A \App\Schema\Crawl\AuctionCrawlLog\AuctionCrawlLog object or a primary key value.
     *
     * @return void
     */
    public static function removeInstanceFromPool($value): void
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \App\Schema\Crawl\AuctionCrawlLog\AuctionCrawlLog) {
                $key = serialize([(null === $value->getItemDef() || is_scalar($value->getItemDef()) || is_callable([$value->getItemDef(), '__toString']) ? (string) $value->getItemDef() : $value->getItemDef()), (null === $value->getCharacterName() || is_scalar($value->getCharacterName()) || is_callable([$value->getCharacterName(), '__toString']) ? (string) $value->getCharacterName() : $value->getCharacterName()), (null === $value->getAccountName() || is_scalar($value->getAccountName()) || is_callable([$value->getAccountName(), '__toString']) ? (string) $value->getAccountName() : $value->getAccountName())]);

            } elseif (is_array($value) && count($value) === 3) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1]), (null === $value[2] || is_scalar($value[2]) || is_callable([$value[2], '__toString']) ? (string) $value[2] : $value[2])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \App\Schema\Crawl\AuctionCrawlLog\AuctionCrawlLog object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('CharacterName', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('AccountName', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('CharacterName', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('CharacterName', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('CharacterName', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('CharacterName', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('CharacterName', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('AccountName', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('AccountName', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('AccountName', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('AccountName', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('AccountName', TableMap::TYPE_PHPNAME, $indexType)])]);
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
                : self::translateFieldName('CharacterName', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 2 + $offset
                : self::translateFieldName('AccountName', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? AuctionCrawlLogTableMap::CLASS_DEFAULT : AuctionCrawlLogTableMap::OM_CLASS;
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
     * @return array (AuctionCrawlLog object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = AuctionCrawlLogTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AuctionCrawlLogTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AuctionCrawlLogTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AuctionCrawlLogTableMap::OM_CLASS;
            /** @var AuctionCrawlLog $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AuctionCrawlLogTableMap::addInstanceToPool($obj, $key);
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
            $key = AuctionCrawlLogTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AuctionCrawlLogTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var AuctionCrawlLog $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AuctionCrawlLogTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AuctionCrawlLogTableMap::COL_ITEM_DEF);
            $criteria->addSelectColumn(AuctionCrawlLogTableMap::COL_CHARACTER_NAME);
            $criteria->addSelectColumn(AuctionCrawlLogTableMap::COL_ACCOUNT_NAME);
            $criteria->addSelectColumn(AuctionCrawlLogTableMap::COL_ITEM_COUNT);
        } else {
            $criteria->addSelectColumn($alias . '.item_def');
            $criteria->addSelectColumn($alias . '.character_name');
            $criteria->addSelectColumn($alias . '.account_name');
            $criteria->addSelectColumn($alias . '.item_count');
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
            $criteria->removeSelectColumn(AuctionCrawlLogTableMap::COL_ITEM_DEF);
            $criteria->removeSelectColumn(AuctionCrawlLogTableMap::COL_CHARACTER_NAME);
            $criteria->removeSelectColumn(AuctionCrawlLogTableMap::COL_ACCOUNT_NAME);
            $criteria->removeSelectColumn(AuctionCrawlLogTableMap::COL_ITEM_COUNT);
        } else {
            $criteria->removeSelectColumn($alias . '.item_def');
            $criteria->removeSelectColumn($alias . '.character_name');
            $criteria->removeSelectColumn($alias . '.account_name');
            $criteria->removeSelectColumn($alias . '.item_count');
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
        return Propel::getServiceContainer()->getDatabaseMap(AuctionCrawlLogTableMap::DATABASE_NAME)->getTable(AuctionCrawlLogTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a AuctionCrawlLog or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or AuctionCrawlLog object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionCrawlLogTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Schema\Crawl\AuctionCrawlLog\AuctionCrawlLog) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AuctionCrawlLogTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = [$values];
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(AuctionCrawlLogTableMap::COL_ITEM_DEF, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(AuctionCrawlLogTableMap::COL_CHARACTER_NAME, $value[1]));
                $criterion->addAnd($criteria->getNewCriterion(AuctionCrawlLogTableMap::COL_ACCOUNT_NAME, $value[2]));
                $criteria->addOr($criterion);
            }
        }

        $query = AuctionCrawlLogQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AuctionCrawlLogTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AuctionCrawlLogTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the auction_crawl_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return AuctionCrawlLogQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AuctionCrawlLog or Criteria object.
     *
     * @param mixed $criteria Criteria or AuctionCrawlLog object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionCrawlLogTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AuctionCrawlLog object
        }


        // Set the correct dbName
        $query = AuctionCrawlLogQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
