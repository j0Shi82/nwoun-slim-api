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
    const CLASS_NAME = 'App.Schema.Crawl.AuctionItems.Map.AuctionItemsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'crawl';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'auction_items';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Schema\\Crawl\\AuctionItems\\AuctionItems';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'App.Schema.Crawl.AuctionItems.AuctionItems';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the item_def field
     */
    const COL_ITEM_DEF = 'auction_items.item_def';

    /**
     * the column name for the item_name field
     */
    const COL_ITEM_NAME = 'auction_items.item_name';

    /**
     * the column name for the category field
     */
    const COL_CATEGORY = 'auction_items.category';

    /**
     * the column name for the allow_auto field
     */
    const COL_ALLOW_AUTO = 'auction_items.allow_auto';

    /**
     * the column name for the server field
     */
    const COL_SERVER = 'auction_items.server';

    /**
     * the column name for the update_date field
     */
    const COL_UPDATE_DATE = 'auction_items.update_date';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('ItemDef', 'ItemName', 'Category', 'AllowAuto', 'Server', 'UpdateDate', ),
        self::TYPE_CAMELNAME     => array('itemDef', 'itemName', 'category', 'allowAuto', 'server', 'updateDate', ),
        self::TYPE_COLNAME       => array(AuctionItemsTableMap::COL_ITEM_DEF, AuctionItemsTableMap::COL_ITEM_NAME, AuctionItemsTableMap::COL_CATEGORY, AuctionItemsTableMap::COL_ALLOW_AUTO, AuctionItemsTableMap::COL_SERVER, AuctionItemsTableMap::COL_UPDATE_DATE, ),
        self::TYPE_FIELDNAME     => array('item_def', 'item_name', 'category', 'allow_auto', 'server', 'update_date', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ItemDef' => 0, 'ItemName' => 1, 'Category' => 2, 'AllowAuto' => 3, 'Server' => 4, 'UpdateDate' => 5, ),
        self::TYPE_CAMELNAME     => array('itemDef' => 0, 'itemName' => 1, 'category' => 2, 'allowAuto' => 3, 'server' => 4, 'updateDate' => 5, ),
        self::TYPE_COLNAME       => array(AuctionItemsTableMap::COL_ITEM_DEF => 0, AuctionItemsTableMap::COL_ITEM_NAME => 1, AuctionItemsTableMap::COL_CATEGORY => 2, AuctionItemsTableMap::COL_ALLOW_AUTO => 3, AuctionItemsTableMap::COL_SERVER => 4, AuctionItemsTableMap::COL_UPDATE_DATE => 5, ),
        self::TYPE_FIELDNAME     => array('item_def' => 0, 'item_name' => 1, 'category' => 2, 'allow_auto' => 3, 'server' => 4, 'update_date' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
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
        'Category' => 'CATEGORY',
        'AuctionItems.Category' => 'CATEGORY',
        'category' => 'CATEGORY',
        'auctionItems.category' => 'CATEGORY',
        'AuctionItemsTableMap::COL_CATEGORY' => 'CATEGORY',
        'COL_CATEGORY' => 'CATEGORY',
        'auction_items.category' => 'CATEGORY',
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
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
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
        $this->addColumn('category', 'Category', 'CHAR', false, null, null);
        $this->addColumn('allow_auto', 'AllowAuto', 'BOOLEAN', true, 1, true);
        $this->addPrimaryKey('server', 'Server', 'CHAR', true, null, 'GLOBAL');
        $this->addColumn('update_date', 'UpdateDate', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \App\Schema\Crawl\AuctionItems\AuctionItems $obj A \App\Schema\Crawl\AuctionItems\AuctionItems object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
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
     */
    public static function removeInstanceFromPool($value)
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
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('Server', TableMap::TYPE_PHPNAME, $indexType)])]);
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
            $pks = [];

        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('ItemDef', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 4 + $offset
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
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? AuctionItemsTableMap::CLASS_DEFAULT : AuctionItemsTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (AuctionItems object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
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

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

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
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_ITEM_DEF);
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_ITEM_NAME);
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_CATEGORY);
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_ALLOW_AUTO);
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_SERVER);
            $criteria->addSelectColumn(AuctionItemsTableMap::COL_UPDATE_DATE);
        } else {
            $criteria->addSelectColumn($alias . '.item_def');
            $criteria->addSelectColumn($alias . '.item_name');
            $criteria->addSelectColumn($alias . '.category');
            $criteria->addSelectColumn($alias . '.allow_auto');
            $criteria->addSelectColumn($alias . '.server');
            $criteria->addSelectColumn($alias . '.update_date');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria object containing the columns to remove.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function removeSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_ITEM_DEF);
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_ITEM_NAME);
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_CATEGORY);
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_ALLOW_AUTO);
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_SERVER);
            $criteria->removeSelectColumn(AuctionItemsTableMap::COL_UPDATE_DATE);
        } else {
            $criteria->removeSelectColumn($alias . '.item_def');
            $criteria->removeSelectColumn($alias . '.item_name');
            $criteria->removeSelectColumn($alias . '.category');
            $criteria->removeSelectColumn($alias . '.allow_auto');
            $criteria->removeSelectColumn($alias . '.server');
            $criteria->removeSelectColumn($alias . '.update_date');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(AuctionItemsTableMap::DATABASE_NAME)->getTable(AuctionItemsTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a AuctionItems or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or AuctionItems object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
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
                $values = array($values);
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
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AuctionItemsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AuctionItems or Criteria object.
     *
     * @param mixed               $criteria Criteria or AuctionItems object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
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

} // AuctionItemsTableMap
