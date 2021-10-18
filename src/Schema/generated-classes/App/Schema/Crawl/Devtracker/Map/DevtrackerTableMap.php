<?php

namespace App\Schema\Crawl\Devtracker\Map;

use App\Schema\Crawl\Devtracker\Devtracker;
use App\Schema\Crawl\Devtracker\DevtrackerQuery;
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
 * This class defines the structure of the 'devtracker' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class DevtrackerTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'App.Schema.Crawl.Devtracker.Map.DevtrackerTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'crawl';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'devtracker';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Schema\\Crawl\\Devtracker\\Devtracker';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'App.Schema.Crawl.Devtracker.Devtracker';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 12;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 12;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'devtracker.ID';

    /**
     * the column name for the dev_name field
     */
    const COL_DEV_NAME = 'devtracker.dev_name';

    /**
     * the column name for the dev_id field
     */
    const COL_DEV_ID = 'devtracker.dev_id';

    /**
     * the column name for the category_id field
     */
    const COL_CATEGORY_ID = 'devtracker.category_id';

    /**
     * the column name for the discussion_id field
     */
    const COL_DISCUSSION_ID = 'devtracker.discussion_id';

    /**
     * the column name for the discussion_name field
     */
    const COL_DISCUSSION_NAME = 'devtracker.discussion_name';

    /**
     * the column name for the comment_id field
     */
    const COL_COMMENT_ID = 'devtracker.comment_id';

    /**
     * the column name for the body field
     */
    const COL_BODY = 'devtracker.body';

    /**
     * the column name for the date field
     */
    const COL_DATE = 'devtracker.date';

    /**
     * the column name for the is_poll field
     */
    const COL_IS_POLL = 'devtracker.is_poll';

    /**
     * the column name for the is_announce field
     */
    const COL_IS_ANNOUNCE = 'devtracker.is_announce';

    /**
     * the column name for the is_closed field
     */
    const COL_IS_CLOSED = 'devtracker.is_closed';

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
        self::TYPE_PHPNAME       => array('Id', 'DevName', 'DevId', 'CategoryId', 'DiscussionId', 'DiscussionName', 'CommentId', 'Body', 'Date', 'IsPoll', 'IsAnnounce', 'IsClosed', ),
        self::TYPE_CAMELNAME     => array('id', 'devName', 'devId', 'categoryId', 'discussionId', 'discussionName', 'commentId', 'body', 'date', 'isPoll', 'isAnnounce', 'isClosed', ),
        self::TYPE_COLNAME       => array(DevtrackerTableMap::COL_ID, DevtrackerTableMap::COL_DEV_NAME, DevtrackerTableMap::COL_DEV_ID, DevtrackerTableMap::COL_CATEGORY_ID, DevtrackerTableMap::COL_DISCUSSION_ID, DevtrackerTableMap::COL_DISCUSSION_NAME, DevtrackerTableMap::COL_COMMENT_ID, DevtrackerTableMap::COL_BODY, DevtrackerTableMap::COL_DATE, DevtrackerTableMap::COL_IS_POLL, DevtrackerTableMap::COL_IS_ANNOUNCE, DevtrackerTableMap::COL_IS_CLOSED, ),
        self::TYPE_FIELDNAME     => array('ID', 'dev_name', 'dev_id', 'category_id', 'discussion_id', 'discussion_name', 'comment_id', 'body', 'date', 'is_poll', 'is_announce', 'is_closed', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'DevName' => 1, 'DevId' => 2, 'CategoryId' => 3, 'DiscussionId' => 4, 'DiscussionName' => 5, 'CommentId' => 6, 'Body' => 7, 'Date' => 8, 'IsPoll' => 9, 'IsAnnounce' => 10, 'IsClosed' => 11, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'devName' => 1, 'devId' => 2, 'categoryId' => 3, 'discussionId' => 4, 'discussionName' => 5, 'commentId' => 6, 'body' => 7, 'date' => 8, 'isPoll' => 9, 'isAnnounce' => 10, 'isClosed' => 11, ),
        self::TYPE_COLNAME       => array(DevtrackerTableMap::COL_ID => 0, DevtrackerTableMap::COL_DEV_NAME => 1, DevtrackerTableMap::COL_DEV_ID => 2, DevtrackerTableMap::COL_CATEGORY_ID => 3, DevtrackerTableMap::COL_DISCUSSION_ID => 4, DevtrackerTableMap::COL_DISCUSSION_NAME => 5, DevtrackerTableMap::COL_COMMENT_ID => 6, DevtrackerTableMap::COL_BODY => 7, DevtrackerTableMap::COL_DATE => 8, DevtrackerTableMap::COL_IS_POLL => 9, DevtrackerTableMap::COL_IS_ANNOUNCE => 10, DevtrackerTableMap::COL_IS_CLOSED => 11, ),
        self::TYPE_FIELDNAME     => array('ID' => 0, 'dev_name' => 1, 'dev_id' => 2, 'category_id' => 3, 'discussion_id' => 4, 'discussion_name' => 5, 'comment_id' => 6, 'body' => 7, 'date' => 8, 'is_poll' => 9, 'is_announce' => 10, 'is_closed' => 11, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Devtracker.Id' => 'ID',
        'id' => 'ID',
        'devtracker.id' => 'ID',
        'DevtrackerTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'ID' => 'ID',
        'devtracker.ID' => 'ID',
        'DevName' => 'DEV_NAME',
        'Devtracker.DevName' => 'DEV_NAME',
        'devName' => 'DEV_NAME',
        'devtracker.devName' => 'DEV_NAME',
        'DevtrackerTableMap::COL_DEV_NAME' => 'DEV_NAME',
        'COL_DEV_NAME' => 'DEV_NAME',
        'dev_name' => 'DEV_NAME',
        'devtracker.dev_name' => 'DEV_NAME',
        'DevId' => 'DEV_ID',
        'Devtracker.DevId' => 'DEV_ID',
        'devId' => 'DEV_ID',
        'devtracker.devId' => 'DEV_ID',
        'DevtrackerTableMap::COL_DEV_ID' => 'DEV_ID',
        'COL_DEV_ID' => 'DEV_ID',
        'dev_id' => 'DEV_ID',
        'devtracker.dev_id' => 'DEV_ID',
        'CategoryId' => 'CATEGORY_ID',
        'Devtracker.CategoryId' => 'CATEGORY_ID',
        'categoryId' => 'CATEGORY_ID',
        'devtracker.categoryId' => 'CATEGORY_ID',
        'DevtrackerTableMap::COL_CATEGORY_ID' => 'CATEGORY_ID',
        'COL_CATEGORY_ID' => 'CATEGORY_ID',
        'category_id' => 'CATEGORY_ID',
        'devtracker.category_id' => 'CATEGORY_ID',
        'DiscussionId' => 'DISCUSSION_ID',
        'Devtracker.DiscussionId' => 'DISCUSSION_ID',
        'discussionId' => 'DISCUSSION_ID',
        'devtracker.discussionId' => 'DISCUSSION_ID',
        'DevtrackerTableMap::COL_DISCUSSION_ID' => 'DISCUSSION_ID',
        'COL_DISCUSSION_ID' => 'DISCUSSION_ID',
        'discussion_id' => 'DISCUSSION_ID',
        'devtracker.discussion_id' => 'DISCUSSION_ID',
        'DiscussionName' => 'DISCUSSION_NAME',
        'Devtracker.DiscussionName' => 'DISCUSSION_NAME',
        'discussionName' => 'DISCUSSION_NAME',
        'devtracker.discussionName' => 'DISCUSSION_NAME',
        'DevtrackerTableMap::COL_DISCUSSION_NAME' => 'DISCUSSION_NAME',
        'COL_DISCUSSION_NAME' => 'DISCUSSION_NAME',
        'discussion_name' => 'DISCUSSION_NAME',
        'devtracker.discussion_name' => 'DISCUSSION_NAME',
        'CommentId' => 'COMMENT_ID',
        'Devtracker.CommentId' => 'COMMENT_ID',
        'commentId' => 'COMMENT_ID',
        'devtracker.commentId' => 'COMMENT_ID',
        'DevtrackerTableMap::COL_COMMENT_ID' => 'COMMENT_ID',
        'COL_COMMENT_ID' => 'COMMENT_ID',
        'comment_id' => 'COMMENT_ID',
        'devtracker.comment_id' => 'COMMENT_ID',
        'Body' => 'BODY',
        'Devtracker.Body' => 'BODY',
        'body' => 'BODY',
        'devtracker.body' => 'BODY',
        'DevtrackerTableMap::COL_BODY' => 'BODY',
        'COL_BODY' => 'BODY',
        'Date' => 'DATE',
        'Devtracker.Date' => 'DATE',
        'date' => 'DATE',
        'devtracker.date' => 'DATE',
        'DevtrackerTableMap::COL_DATE' => 'DATE',
        'COL_DATE' => 'DATE',
        'IsPoll' => 'IS_POLL',
        'Devtracker.IsPoll' => 'IS_POLL',
        'isPoll' => 'IS_POLL',
        'devtracker.isPoll' => 'IS_POLL',
        'DevtrackerTableMap::COL_IS_POLL' => 'IS_POLL',
        'COL_IS_POLL' => 'IS_POLL',
        'is_poll' => 'IS_POLL',
        'devtracker.is_poll' => 'IS_POLL',
        'IsAnnounce' => 'IS_ANNOUNCE',
        'Devtracker.IsAnnounce' => 'IS_ANNOUNCE',
        'isAnnounce' => 'IS_ANNOUNCE',
        'devtracker.isAnnounce' => 'IS_ANNOUNCE',
        'DevtrackerTableMap::COL_IS_ANNOUNCE' => 'IS_ANNOUNCE',
        'COL_IS_ANNOUNCE' => 'IS_ANNOUNCE',
        'is_announce' => 'IS_ANNOUNCE',
        'devtracker.is_announce' => 'IS_ANNOUNCE',
        'IsClosed' => 'IS_CLOSED',
        'Devtracker.IsClosed' => 'IS_CLOSED',
        'isClosed' => 'IS_CLOSED',
        'devtracker.isClosed' => 'IS_CLOSED',
        'DevtrackerTableMap::COL_IS_CLOSED' => 'IS_CLOSED',
        'COL_IS_CLOSED' => 'IS_CLOSED',
        'is_closed' => 'IS_CLOSED',
        'devtracker.is_closed' => 'IS_CLOSED',
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
        $this->setName('devtracker');
        $this->setPhpName('Devtracker');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Schema\\Crawl\\Devtracker\\Devtracker');
        $this->setPackage('App.Schema.Crawl.Devtracker');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('dev_name', 'DevName', 'VARCHAR', true, 30, null);
        $this->addColumn('dev_id', 'DevId', 'INTEGER', true, null, null);
        $this->addColumn('category_id', 'CategoryId', 'INTEGER', true, null, null);
        $this->addColumn('discussion_id', 'DiscussionId', 'INTEGER', true, null, null);
        $this->addColumn('discussion_name', 'DiscussionName', 'LONGVARCHAR', true, null, null);
        $this->addColumn('comment_id', 'CommentId', 'INTEGER', true, null, 0);
        $this->addColumn('body', 'Body', 'LONGVARCHAR', true, null, null);
        $this->addColumn('date', 'Date', 'TIMESTAMP', true, null, null);
        $this->addColumn('is_poll', 'IsPoll', 'BOOLEAN', true, 1, null);
        $this->addColumn('is_announce', 'IsAnnounce', 'BOOLEAN', true, 1, null);
        $this->addColumn('is_closed', 'IsClosed', 'BOOLEAN', true, 1, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
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
        return $withPrefix ? DevtrackerTableMap::CLASS_DEFAULT : DevtrackerTableMap::OM_CLASS;
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
     * @return array           (Devtracker object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DevtrackerTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DevtrackerTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DevtrackerTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DevtrackerTableMap::OM_CLASS;
            /** @var Devtracker $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DevtrackerTableMap::addInstanceToPool($obj, $key);
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
            $key = DevtrackerTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DevtrackerTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Devtracker $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DevtrackerTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DevtrackerTableMap::COL_ID);
            $criteria->addSelectColumn(DevtrackerTableMap::COL_DEV_NAME);
            $criteria->addSelectColumn(DevtrackerTableMap::COL_DEV_ID);
            $criteria->addSelectColumn(DevtrackerTableMap::COL_CATEGORY_ID);
            $criteria->addSelectColumn(DevtrackerTableMap::COL_DISCUSSION_ID);
            $criteria->addSelectColumn(DevtrackerTableMap::COL_DISCUSSION_NAME);
            $criteria->addSelectColumn(DevtrackerTableMap::COL_COMMENT_ID);
            $criteria->addSelectColumn(DevtrackerTableMap::COL_BODY);
            $criteria->addSelectColumn(DevtrackerTableMap::COL_DATE);
            $criteria->addSelectColumn(DevtrackerTableMap::COL_IS_POLL);
            $criteria->addSelectColumn(DevtrackerTableMap::COL_IS_ANNOUNCE);
            $criteria->addSelectColumn(DevtrackerTableMap::COL_IS_CLOSED);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.dev_name');
            $criteria->addSelectColumn($alias . '.dev_id');
            $criteria->addSelectColumn($alias . '.category_id');
            $criteria->addSelectColumn($alias . '.discussion_id');
            $criteria->addSelectColumn($alias . '.discussion_name');
            $criteria->addSelectColumn($alias . '.comment_id');
            $criteria->addSelectColumn($alias . '.body');
            $criteria->addSelectColumn($alias . '.date');
            $criteria->addSelectColumn($alias . '.is_poll');
            $criteria->addSelectColumn($alias . '.is_announce');
            $criteria->addSelectColumn($alias . '.is_closed');
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
            $criteria->removeSelectColumn(DevtrackerTableMap::COL_ID);
            $criteria->removeSelectColumn(DevtrackerTableMap::COL_DEV_NAME);
            $criteria->removeSelectColumn(DevtrackerTableMap::COL_DEV_ID);
            $criteria->removeSelectColumn(DevtrackerTableMap::COL_CATEGORY_ID);
            $criteria->removeSelectColumn(DevtrackerTableMap::COL_DISCUSSION_ID);
            $criteria->removeSelectColumn(DevtrackerTableMap::COL_DISCUSSION_NAME);
            $criteria->removeSelectColumn(DevtrackerTableMap::COL_COMMENT_ID);
            $criteria->removeSelectColumn(DevtrackerTableMap::COL_BODY);
            $criteria->removeSelectColumn(DevtrackerTableMap::COL_DATE);
            $criteria->removeSelectColumn(DevtrackerTableMap::COL_IS_POLL);
            $criteria->removeSelectColumn(DevtrackerTableMap::COL_IS_ANNOUNCE);
            $criteria->removeSelectColumn(DevtrackerTableMap::COL_IS_CLOSED);
        } else {
            $criteria->removeSelectColumn($alias . '.ID');
            $criteria->removeSelectColumn($alias . '.dev_name');
            $criteria->removeSelectColumn($alias . '.dev_id');
            $criteria->removeSelectColumn($alias . '.category_id');
            $criteria->removeSelectColumn($alias . '.discussion_id');
            $criteria->removeSelectColumn($alias . '.discussion_name');
            $criteria->removeSelectColumn($alias . '.comment_id');
            $criteria->removeSelectColumn($alias . '.body');
            $criteria->removeSelectColumn($alias . '.date');
            $criteria->removeSelectColumn($alias . '.is_poll');
            $criteria->removeSelectColumn($alias . '.is_announce');
            $criteria->removeSelectColumn($alias . '.is_closed');
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
        return Propel::getServiceContainer()->getDatabaseMap(DevtrackerTableMap::DATABASE_NAME)->getTable(DevtrackerTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Devtracker or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Devtracker object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DevtrackerTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Schema\Crawl\Devtracker\Devtracker) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DevtrackerTableMap::DATABASE_NAME);
            $criteria->add(DevtrackerTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = DevtrackerQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DevtrackerTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DevtrackerTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the devtracker table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DevtrackerQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Devtracker or Criteria object.
     *
     * @param mixed               $criteria Criteria or Devtracker object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DevtrackerTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Devtracker object
        }

        if ($criteria->containsKey(DevtrackerTableMap::COL_ID) && $criteria->keyContainsValue(DevtrackerTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DevtrackerTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = DevtrackerQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DevtrackerTableMap
