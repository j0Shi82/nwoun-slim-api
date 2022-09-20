<?php

namespace App\Schema\Crawl\Article\Map;

use App\Schema\Crawl\Article\Article;
use App\Schema\Crawl\Article\ArticleQuery;
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
 * This class defines the structure of the 'article' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class ArticleTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'App.Schema.Crawl.Article.Map.ArticleTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'crawl';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'article';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\App\\Schema\\Crawl\\Article\\Article';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'App.Schema.Crawl.Article.Article';

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
     * the column name for the id field
     */
    public const COL_ID = 'article.id';

    /**
     * the column name for the article_id field
     */
    public const COL_ARTICLE_ID = 'article.article_id';

    /**
     * the column name for the link field
     */
    public const COL_LINK = 'article.link';

    /**
     * the column name for the site field
     */
    public const COL_SITE = 'article.site';

    /**
     * the column name for the ts field
     */
    public const COL_TS = 'article.ts';

    /**
     * the column name for the title field
     */
    public const COL_TITLE = 'article.title';

    /**
     * the column name for the content field
     */
    public const COL_CONTENT = 'article.content';

    /**
     * the column name for the cats field
     */
    public const COL_CATS = 'article.cats';

    /**
     * the column name for the last_tagged field
     */
    public const COL_LAST_TAGGED = 'article.last_tagged';

    /**
     * the column name for the type field
     */
    public const COL_TYPE = 'article.type';

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
        self::TYPE_PHPNAME       => ['Id', 'ArticleId', 'Link', 'Site', 'Ts', 'Title', 'Content', 'Cats', 'LastTagged', 'Type', ],
        self::TYPE_CAMELNAME     => ['id', 'articleId', 'link', 'site', 'ts', 'title', 'content', 'cats', 'lastTagged', 'type', ],
        self::TYPE_COLNAME       => [ArticleTableMap::COL_ID, ArticleTableMap::COL_ARTICLE_ID, ArticleTableMap::COL_LINK, ArticleTableMap::COL_SITE, ArticleTableMap::COL_TS, ArticleTableMap::COL_TITLE, ArticleTableMap::COL_CONTENT, ArticleTableMap::COL_CATS, ArticleTableMap::COL_LAST_TAGGED, ArticleTableMap::COL_TYPE, ],
        self::TYPE_FIELDNAME     => ['id', 'article_id', 'link', 'site', 'ts', 'title', 'content', 'cats', 'last_tagged', 'type', ],
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'ArticleId' => 1, 'Link' => 2, 'Site' => 3, 'Ts' => 4, 'Title' => 5, 'Content' => 6, 'Cats' => 7, 'LastTagged' => 8, 'Type' => 9, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'articleId' => 1, 'link' => 2, 'site' => 3, 'ts' => 4, 'title' => 5, 'content' => 6, 'cats' => 7, 'lastTagged' => 8, 'type' => 9, ],
        self::TYPE_COLNAME       => [ArticleTableMap::COL_ID => 0, ArticleTableMap::COL_ARTICLE_ID => 1, ArticleTableMap::COL_LINK => 2, ArticleTableMap::COL_SITE => 3, ArticleTableMap::COL_TS => 4, ArticleTableMap::COL_TITLE => 5, ArticleTableMap::COL_CONTENT => 6, ArticleTableMap::COL_CATS => 7, ArticleTableMap::COL_LAST_TAGGED => 8, ArticleTableMap::COL_TYPE => 9, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'article_id' => 1, 'link' => 2, 'site' => 3, 'ts' => 4, 'title' => 5, 'content' => 6, 'cats' => 7, 'last_tagged' => 8, 'type' => 9, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Article.Id' => 'ID',
        'id' => 'ID',
        'article.id' => 'ID',
        'ArticleTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'ArticleId' => 'ARTICLE_ID',
        'Article.ArticleId' => 'ARTICLE_ID',
        'articleId' => 'ARTICLE_ID',
        'article.articleId' => 'ARTICLE_ID',
        'ArticleTableMap::COL_ARTICLE_ID' => 'ARTICLE_ID',
        'COL_ARTICLE_ID' => 'ARTICLE_ID',
        'article_id' => 'ARTICLE_ID',
        'article.article_id' => 'ARTICLE_ID',
        'Link' => 'LINK',
        'Article.Link' => 'LINK',
        'link' => 'LINK',
        'article.link' => 'LINK',
        'ArticleTableMap::COL_LINK' => 'LINK',
        'COL_LINK' => 'LINK',
        'Site' => 'SITE',
        'Article.Site' => 'SITE',
        'site' => 'SITE',
        'article.site' => 'SITE',
        'ArticleTableMap::COL_SITE' => 'SITE',
        'COL_SITE' => 'SITE',
        'Ts' => 'TS',
        'Article.Ts' => 'TS',
        'ts' => 'TS',
        'article.ts' => 'TS',
        'ArticleTableMap::COL_TS' => 'TS',
        'COL_TS' => 'TS',
        'Title' => 'TITLE',
        'Article.Title' => 'TITLE',
        'title' => 'TITLE',
        'article.title' => 'TITLE',
        'ArticleTableMap::COL_TITLE' => 'TITLE',
        'COL_TITLE' => 'TITLE',
        'Content' => 'CONTENT',
        'Article.Content' => 'CONTENT',
        'content' => 'CONTENT',
        'article.content' => 'CONTENT',
        'ArticleTableMap::COL_CONTENT' => 'CONTENT',
        'COL_CONTENT' => 'CONTENT',
        'Cats' => 'CATS',
        'Article.Cats' => 'CATS',
        'cats' => 'CATS',
        'article.cats' => 'CATS',
        'ArticleTableMap::COL_CATS' => 'CATS',
        'COL_CATS' => 'CATS',
        'LastTagged' => 'LAST_TAGGED',
        'Article.LastTagged' => 'LAST_TAGGED',
        'lastTagged' => 'LAST_TAGGED',
        'article.lastTagged' => 'LAST_TAGGED',
        'ArticleTableMap::COL_LAST_TAGGED' => 'LAST_TAGGED',
        'COL_LAST_TAGGED' => 'LAST_TAGGED',
        'last_tagged' => 'LAST_TAGGED',
        'article.last_tagged' => 'LAST_TAGGED',
        'Type' => 'TYPE',
        'Article.Type' => 'TYPE',
        'type' => 'TYPE',
        'article.type' => 'TYPE',
        'ArticleTableMap::COL_TYPE' => 'TYPE',
        'COL_TYPE' => 'TYPE',
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
        $this->setName('article');
        $this->setPhpName('Article');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Schema\\Crawl\\Article\\Article');
        $this->setPackage('App.Schema.Crawl.Article');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('article_id', 'ArticleId', 'VARCHAR', true, 200, null);
        $this->addColumn('link', 'Link', 'LONGVARCHAR', true, null, null);
        $this->addColumn('site', 'Site', 'VARCHAR', true, 50, null);
        $this->addColumn('ts', 'Ts', 'INTEGER', true, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', true, 100, null);
        $this->addColumn('content', 'Content', 'LONGVARCHAR', true, null, null);
        $this->addColumn('cats', 'Cats', 'VARCHAR', true, null, null);
        $this->addColumn('last_tagged', 'LastTagged', 'INTEGER', true, null, null);
        $this->addColumn('type', 'Type', 'CHAR', true, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('ContentArticle', '\\App\\Schema\\Crawl\\ArticleContentTags\\ArticleContentTags', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':article_id',
    1 => ':id',
  ),
), null, null, 'ContentArticles', false);
        $this->addRelation('TitleArticle', '\\App\\Schema\\Crawl\\ArticleTitleTags\\ArticleTitleTags', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':article_id',
    1 => ':id',
  ),
), null, null, 'TitleArticles', false);
        $this->addRelation('ContentTag', '\\App\\Schema\\Crawl\\Tag\\Tag', RelationMap::MANY_TO_MANY, array(), null, null, 'ContentTags');
        $this->addRelation('TitleTag', '\\App\\Schema\\Crawl\\Tag\\Tag', RelationMap::MANY_TO_MANY, array(), null, null, 'TitleTags');
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
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM)
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
     * @param bool $withPrefix Whether to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass(bool $withPrefix = true): string
    {
        return $withPrefix ? ArticleTableMap::CLASS_DEFAULT : ArticleTableMap::OM_CLASS;
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
     * @return array (Article object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = ArticleTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ArticleTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ArticleTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ArticleTableMap::OM_CLASS;
            /** @var Article $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ArticleTableMap::addInstanceToPool($obj, $key);
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
            $key = ArticleTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ArticleTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Article $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ArticleTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ArticleTableMap::COL_ID);
            $criteria->addSelectColumn(ArticleTableMap::COL_ARTICLE_ID);
            $criteria->addSelectColumn(ArticleTableMap::COL_LINK);
            $criteria->addSelectColumn(ArticleTableMap::COL_SITE);
            $criteria->addSelectColumn(ArticleTableMap::COL_TS);
            $criteria->addSelectColumn(ArticleTableMap::COL_TITLE);
            $criteria->addSelectColumn(ArticleTableMap::COL_CONTENT);
            $criteria->addSelectColumn(ArticleTableMap::COL_CATS);
            $criteria->addSelectColumn(ArticleTableMap::COL_LAST_TAGGED);
            $criteria->addSelectColumn(ArticleTableMap::COL_TYPE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.article_id');
            $criteria->addSelectColumn($alias . '.link');
            $criteria->addSelectColumn($alias . '.site');
            $criteria->addSelectColumn($alias . '.ts');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.content');
            $criteria->addSelectColumn($alias . '.cats');
            $criteria->addSelectColumn($alias . '.last_tagged');
            $criteria->addSelectColumn($alias . '.type');
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
            $criteria->removeSelectColumn(ArticleTableMap::COL_ID);
            $criteria->removeSelectColumn(ArticleTableMap::COL_ARTICLE_ID);
            $criteria->removeSelectColumn(ArticleTableMap::COL_LINK);
            $criteria->removeSelectColumn(ArticleTableMap::COL_SITE);
            $criteria->removeSelectColumn(ArticleTableMap::COL_TS);
            $criteria->removeSelectColumn(ArticleTableMap::COL_TITLE);
            $criteria->removeSelectColumn(ArticleTableMap::COL_CONTENT);
            $criteria->removeSelectColumn(ArticleTableMap::COL_CATS);
            $criteria->removeSelectColumn(ArticleTableMap::COL_LAST_TAGGED);
            $criteria->removeSelectColumn(ArticleTableMap::COL_TYPE);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.article_id');
            $criteria->removeSelectColumn($alias . '.link');
            $criteria->removeSelectColumn($alias . '.site');
            $criteria->removeSelectColumn($alias . '.ts');
            $criteria->removeSelectColumn($alias . '.title');
            $criteria->removeSelectColumn($alias . '.content');
            $criteria->removeSelectColumn($alias . '.cats');
            $criteria->removeSelectColumn($alias . '.last_tagged');
            $criteria->removeSelectColumn($alias . '.type');
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
        return Propel::getServiceContainer()->getDatabaseMap(ArticleTableMap::DATABASE_NAME)->getTable(ArticleTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Article or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Article object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Schema\Crawl\Article\Article) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ArticleTableMap::DATABASE_NAME);
            $criteria->add(ArticleTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ArticleQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ArticleTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ArticleTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the article table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return ArticleQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Article or Criteria object.
     *
     * @param mixed $criteria Criteria or Article object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Article object
        }

        if ($criteria->containsKey(ArticleTableMap::COL_ID) && $criteria->keyContainsValue(ArticleTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ArticleTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ArticleQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
