<?php

namespace App\Schema\Crawl\Article\Base;

use \Exception;
use \PDO;
use App\Schema\Crawl\Article\Article as ChildArticle;
use App\Schema\Crawl\Article\ArticleQuery as ChildArticleQuery;
use App\Schema\Crawl\ArticleContentTags\ArticleContentTags;
use App\Schema\Crawl\ArticleContentTags\ArticleContentTagsQuery;
use App\Schema\Crawl\ArticleContentTags\Base\ArticleContentTags as BaseArticleContentTags;
use App\Schema\Crawl\ArticleContentTags\Map\ArticleContentTagsTableMap;
use App\Schema\Crawl\ArticleTitleTags\ArticleTitleTags;
use App\Schema\Crawl\ArticleTitleTags\ArticleTitleTagsQuery;
use App\Schema\Crawl\ArticleTitleTags\Base\ArticleTitleTags as BaseArticleTitleTags;
use App\Schema\Crawl\ArticleTitleTags\Map\ArticleTitleTagsTableMap;
use App\Schema\Crawl\Article\Map\ArticleTableMap;
use App\Schema\Crawl\Tag\Tag;
use App\Schema\Crawl\Tag\TagQuery;
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

/**
 * Base class that represents a row from the 'article' table.
 *
 *
 *
 * @package    propel.generator.App.Schema.Crawl.Article.Base
 */
abstract class Article implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\App\\Schema\\Crawl\\Article\\Map\\ArticleTableMap';


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
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the article_id field.
     *
     * @var        string
     */
    protected $article_id;

    /**
     * The value for the link field.
     *
     * @var        string
     */
    protected $link;

    /**
     * The value for the site field.
     *
     * @var        string
     */
    protected $site;

    /**
     * The value for the ts field.
     *
     * @var        int
     */
    protected $ts;

    /**
     * The value for the title field.
     *
     * @var        string
     */
    protected $title;

    /**
     * The value for the content field.
     *
     * @var        string
     */
    protected $content;

    /**
     * The value for the cats field.
     *
     * @var        string
     */
    protected $cats;

    /**
     * The value for the last_tagged field.
     *
     * @var        int
     */
    protected $last_tagged;

    /**
     * The value for the type field.
     *
     * @var        string
     */
    protected $type;

    /**
     * @var        ObjectCollection|ArticleContentTags[] Collection to store aggregation of ArticleContentTags objects.
     * @phpstan-var ObjectCollection&\Traversable<ArticleContentTags> Collection to store aggregation of ArticleContentTags objects.
     */
    protected $collContentArticles;
    protected $collContentArticlesPartial;

    /**
     * @var        ObjectCollection|ArticleTitleTags[] Collection to store aggregation of ArticleTitleTags objects.
     * @phpstan-var ObjectCollection&\Traversable<ArticleTitleTags> Collection to store aggregation of ArticleTitleTags objects.
     */
    protected $collTitleArticles;
    protected $collTitleArticlesPartial;

    /**
     * @var        ObjectCollection|Tag[] Cross Collection to store aggregation of Tag objects.
     * @phpstan-var ObjectCollection&\Traversable<Tag> Cross Collection to store aggregation of Tag objects.
     */
    protected $collContentTags;

    /**
     * @var bool
     */
    protected $collContentTagsPartial;

    /**
     * @var        ObjectCollection|Tag[] Cross Collection to store aggregation of Tag objects.
     * @phpstan-var ObjectCollection&\Traversable<Tag> Cross Collection to store aggregation of Tag objects.
     */
    protected $collTitleTags;

    /**
     * @var bool
     */
    protected $collTitleTagsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|Tag[]
     * @phpstan-var ObjectCollection&\Traversable<Tag>
     */
    protected $contentTagsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|Tag[]
     * @phpstan-var ObjectCollection&\Traversable<Tag>
     */
    protected $titleTagsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ArticleContentTags[]
     * @phpstan-var ObjectCollection&\Traversable<ArticleContentTags>
     */
    protected $contentArticlesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ArticleTitleTags[]
     * @phpstan-var ObjectCollection&\Traversable<ArticleTitleTags>
     */
    protected $titleArticlesScheduledForDeletion = null;

    /**
     * Initializes internal state of App\Schema\Crawl\Article\Base\Article object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>Article</code> instance.  If
     * <code>obj</code> is an instance of <code>Article</code>, delegates to
     * <code>equals(Article)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [article_id] column value.
     *
     * @return string
     */
    public function getArticleId()
    {
        return $this->article_id;
    }

    /**
     * Get the [link] column value.
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Get the [site] column value.
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Get the [ts] column value.
     *
     * @return int
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [content] column value.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the [cats] column value.
     *
     * @return string
     */
    public function getCats()
    {
        return $this->cats;
    }

    /**
     * Get the [last_tagged] column value.
     *
     * @return int
     */
    public function getLastTagged()
    {
        return $this->last_tagged;
    }

    /**
     * Get the [type] column value.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ArticleTableMap::COL_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [article_id] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setArticleId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->article_id !== $v) {
            $this->article_id = $v;
            $this->modifiedColumns[ArticleTableMap::COL_ARTICLE_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [link] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setLink($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->link !== $v) {
            $this->link = $v;
            $this->modifiedColumns[ArticleTableMap::COL_LINK] = true;
        }

        return $this;
    }

    /**
     * Set the value of [site] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setSite($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->site !== $v) {
            $this->site = $v;
            $this->modifiedColumns[ArticleTableMap::COL_SITE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [ts] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setTs($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ts !== $v) {
            $this->ts = $v;
            $this->modifiedColumns[ArticleTableMap::COL_TS] = true;
        }

        return $this;
    }

    /**
     * Set the value of [title] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[ArticleTableMap::COL_TITLE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [content] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setContent($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->content !== $v) {
            $this->content = $v;
            $this->modifiedColumns[ArticleTableMap::COL_CONTENT] = true;
        }

        return $this;
    }

    /**
     * Set the value of [cats] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setCats($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cats !== $v) {
            $this->cats = $v;
            $this->modifiedColumns[ArticleTableMap::COL_CATS] = true;
        }

        return $this;
    }

    /**
     * Set the value of [last_tagged] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setLastTagged($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->last_tagged !== $v) {
            $this->last_tagged = $v;
            $this->modifiedColumns[ArticleTableMap::COL_LAST_TAGGED] = true;
        }

        return $this;
    }

    /**
     * Set the value of [type] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[ArticleTableMap::COL_TYPE] = true;
        }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ArticleTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ArticleTableMap::translateFieldName('ArticleId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->article_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ArticleTableMap::translateFieldName('Link', TableMap::TYPE_PHPNAME, $indexType)];
            $this->link = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ArticleTableMap::translateFieldName('Site', TableMap::TYPE_PHPNAME, $indexType)];
            $this->site = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ArticleTableMap::translateFieldName('Ts', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ts = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ArticleTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ArticleTableMap::translateFieldName('Content', TableMap::TYPE_PHPNAME, $indexType)];
            $this->content = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ArticleTableMap::translateFieldName('Cats', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cats = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ArticleTableMap::translateFieldName('LastTagged', TableMap::TYPE_PHPNAME, $indexType)];
            $this->last_tagged = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ArticleTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (string) $col : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = ArticleTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Schema\\Crawl\\Article\\Article'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ArticleTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildArticleQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collContentArticles = null;

            $this->collTitleArticles = null;

            $this->collContentTags = null;
            $this->collTitleTags = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see Article::setDeleted()
     * @see Article::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildArticleQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleTableMap::DATABASE_NAME);
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
                ArticleTableMap::addInstanceToPool($this);
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

            if ($this->contentTagsScheduledForDeletion !== null) {
                if (!$this->contentTagsScheduledForDeletion->isEmpty()) {
                    $pks = [];
                    foreach ($this->contentTagsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \App\Schema\Crawl\ArticleContentTags\ArticleContentTagsQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->contentTagsScheduledForDeletion = null;
                }

            }

            if ($this->collContentTags) {
                foreach ($this->collContentTags as $contentTag) {
                    if (!$contentTag->isDeleted() && ($contentTag->isNew() || $contentTag->isModified())) {
                        $contentTag->save($con);
                    }
                }
            }


            if ($this->titleTagsScheduledForDeletion !== null) {
                if (!$this->titleTagsScheduledForDeletion->isEmpty()) {
                    $pks = [];
                    foreach ($this->titleTagsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \App\Schema\Crawl\ArticleTitleTags\ArticleTitleTagsQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->titleTagsScheduledForDeletion = null;
                }

            }

            if ($this->collTitleTags) {
                foreach ($this->collTitleTags as $titleTag) {
                    if (!$titleTag->isDeleted() && ($titleTag->isNew() || $titleTag->isModified())) {
                        $titleTag->save($con);
                    }
                }
            }


            if ($this->contentArticlesScheduledForDeletion !== null) {
                if (!$this->contentArticlesScheduledForDeletion->isEmpty()) {
                    \App\Schema\Crawl\ArticleContentTags\ArticleContentTagsQuery::create()
                        ->filterByPrimaryKeys($this->contentArticlesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentArticlesScheduledForDeletion = null;
                }
            }

            if ($this->collContentArticles !== null) {
                foreach ($this->collContentArticles as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->titleArticlesScheduledForDeletion !== null) {
                if (!$this->titleArticlesScheduledForDeletion->isEmpty()) {
                    \App\Schema\Crawl\ArticleTitleTags\ArticleTitleTagsQuery::create()
                        ->filterByPrimaryKeys($this->titleArticlesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->titleArticlesScheduledForDeletion = null;
                }
            }

            if ($this->collTitleArticles !== null) {
                foreach ($this->collTitleArticles as $referrerFK) {
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

        $this->modifiedColumns[ArticleTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ArticleTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ArticleTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_ARTICLE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'article_id';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_LINK)) {
            $modifiedColumns[':p' . $index++]  = 'link';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_SITE)) {
            $modifiedColumns[':p' . $index++]  = 'site';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_TS)) {
            $modifiedColumns[':p' . $index++]  = 'ts';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'title';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_CONTENT)) {
            $modifiedColumns[':p' . $index++]  = 'content';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_CATS)) {
            $modifiedColumns[':p' . $index++]  = 'cats';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_LAST_TAGGED)) {
            $modifiedColumns[':p' . $index++]  = 'last_tagged';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'type';
        }

        $sql = sprintf(
            'INSERT INTO article (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);

                        break;
                    case 'article_id':
                        $stmt->bindValue($identifier, $this->article_id, PDO::PARAM_STR);

                        break;
                    case 'link':
                        $stmt->bindValue($identifier, $this->link, PDO::PARAM_STR);

                        break;
                    case 'site':
                        $stmt->bindValue($identifier, $this->site, PDO::PARAM_STR);

                        break;
                    case 'ts':
                        $stmt->bindValue($identifier, $this->ts, PDO::PARAM_INT);

                        break;
                    case 'title':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);

                        break;
                    case 'content':
                        $stmt->bindValue($identifier, $this->content, PDO::PARAM_STR);

                        break;
                    case 'cats':
                        $stmt->bindValue($identifier, $this->cats, PDO::PARAM_STR);

                        break;
                    case 'last_tagged':
                        $stmt->bindValue($identifier, $this->last_tagged, PDO::PARAM_INT);

                        break;
                    case 'type':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);

                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

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
        $pos = ArticleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getId();

            case 1:
                return $this->getArticleId();

            case 2:
                return $this->getLink();

            case 3:
                return $this->getSite();

            case 4:
                return $this->getTs();

            case 5:
                return $this->getTitle();

            case 6:
                return $this->getContent();

            case 7:
                return $this->getCats();

            case 8:
                return $this->getLastTagged();

            case 9:
                return $this->getType();

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
        if (isset($alreadyDumpedObjects['Article'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Article'][$this->hashCode()] = true;
        $keys = ArticleTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getArticleId(),
            $keys[2] => $this->getLink(),
            $keys[3] => $this->getSite(),
            $keys[4] => $this->getTs(),
            $keys[5] => $this->getTitle(),
            $keys[6] => $this->getContent(),
            $keys[7] => $this->getCats(),
            $keys[8] => $this->getLastTagged(),
            $keys[9] => $this->getType(),
        ];
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collContentArticles) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'articleContentTagss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'article_tagss';
                        break;
                    default:
                        $key = 'ContentArticles';
                }

                $result[$key] = $this->collContentArticles->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTitleArticles) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'articleTitleTagss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'article_title_tagss';
                        break;
                    default:
                        $key = 'TitleArticles';
                }

                $result[$key] = $this->collTitleArticles->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ArticleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setId($value);
                break;
            case 1:
                $this->setArticleId($value);
                break;
            case 2:
                $this->setLink($value);
                break;
            case 3:
                $this->setSite($value);
                break;
            case 4:
                $this->setTs($value);
                break;
            case 5:
                $this->setTitle($value);
                break;
            case 6:
                $this->setContent($value);
                break;
            case 7:
                $this->setCats($value);
                break;
            case 8:
                $this->setLastTagged($value);
                break;
            case 9:
                $this->setType($value);
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
        $keys = ArticleTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setArticleId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLink($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setSite($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTs($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setTitle($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setContent($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setCats($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setLastTagged($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setType($arr[$keys[9]]);
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
        $criteria = new Criteria(ArticleTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ArticleTableMap::COL_ID)) {
            $criteria->add(ArticleTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_ARTICLE_ID)) {
            $criteria->add(ArticleTableMap::COL_ARTICLE_ID, $this->article_id);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_LINK)) {
            $criteria->add(ArticleTableMap::COL_LINK, $this->link);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_SITE)) {
            $criteria->add(ArticleTableMap::COL_SITE, $this->site);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_TS)) {
            $criteria->add(ArticleTableMap::COL_TS, $this->ts);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_TITLE)) {
            $criteria->add(ArticleTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_CONTENT)) {
            $criteria->add(ArticleTableMap::COL_CONTENT, $this->content);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_CATS)) {
            $criteria->add(ArticleTableMap::COL_CATS, $this->cats);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_LAST_TAGGED)) {
            $criteria->add(ArticleTableMap::COL_LAST_TAGGED, $this->last_tagged);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_TYPE)) {
            $criteria->add(ArticleTableMap::COL_TYPE, $this->type);
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
        $criteria = ChildArticleQuery::create();
        $criteria->add(ArticleTableMap::COL_ID, $this->id);

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
        $validPk = null !== $this->getId();

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
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param int|null $key Primary key.
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \App\Schema\Crawl\Article\Article (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setArticleId($this->getArticleId());
        $copyObj->setLink($this->getLink());
        $copyObj->setSite($this->getSite());
        $copyObj->setTs($this->getTs());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setContent($this->getContent());
        $copyObj->setCats($this->getCats());
        $copyObj->setLastTagged($this->getLastTagged());
        $copyObj->setType($this->getType());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getContentArticles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContentArticle($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTitleArticles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTitleArticle($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \App\Schema\Crawl\Article\Article Clone of current object.
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
        if ('ContentArticle' === $relationName) {
            $this->initContentArticles();
            return;
        }
        if ('TitleArticle' === $relationName) {
            $this->initTitleArticles();
            return;
        }
    }

    /**
     * Clears out the collContentArticles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addContentArticles()
     */
    public function clearContentArticles()
    {
        $this->collContentArticles = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collContentArticles collection loaded partially.
     *
     * @return void
     */
    public function resetPartialContentArticles($v = true): void
    {
        $this->collContentArticlesPartial = $v;
    }

    /**
     * Initializes the collContentArticles collection.
     *
     * By default this just sets the collContentArticles collection to an empty array (like clearcollContentArticles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContentArticles(bool $overrideExisting = true): void
    {
        if (null !== $this->collContentArticles && !$overrideExisting) {
            return;
        }

        $collectionClassName = ArticleContentTagsTableMap::getTableMap()->getCollectionClassName();

        $this->collContentArticles = new $collectionClassName;
        $this->collContentArticles->setModel('\App\Schema\Crawl\ArticleContentTags\ArticleContentTags');
    }

    /**
     * Gets an array of ArticleContentTags objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildArticle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ArticleContentTags[] List of ArticleContentTags objects
     * @phpstan-return ObjectCollection&\Traversable<ArticleContentTags> List of ArticleContentTags objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getContentArticles(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collContentArticlesPartial && !$this->isNew();
        if (null === $this->collContentArticles || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collContentArticles) {
                    $this->initContentArticles();
                } else {
                    $collectionClassName = ArticleContentTagsTableMap::getTableMap()->getCollectionClassName();

                    $collContentArticles = new $collectionClassName;
                    $collContentArticles->setModel('\App\Schema\Crawl\ArticleContentTags\ArticleContentTags');

                    return $collContentArticles;
                }
            } else {
                $collContentArticles = ArticleContentTagsQuery::create(null, $criteria)
                    ->filterByContentArticle($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collContentArticlesPartial && count($collContentArticles)) {
                        $this->initContentArticles(false);

                        foreach ($collContentArticles as $obj) {
                            if (false == $this->collContentArticles->contains($obj)) {
                                $this->collContentArticles->append($obj);
                            }
                        }

                        $this->collContentArticlesPartial = true;
                    }

                    return $collContentArticles;
                }

                if ($partial && $this->collContentArticles) {
                    foreach ($this->collContentArticles as $obj) {
                        if ($obj->isNew()) {
                            $collContentArticles[] = $obj;
                        }
                    }
                }

                $this->collContentArticles = $collContentArticles;
                $this->collContentArticlesPartial = false;
            }
        }

        return $this->collContentArticles;
    }

    /**
     * Sets a collection of ArticleContentTags objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $contentArticles A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setContentArticles(Collection $contentArticles, ?ConnectionInterface $con = null)
    {
        /** @var ArticleContentTags[] $contentArticlesToDelete */
        $contentArticlesToDelete = $this->getContentArticles(new Criteria(), $con)->diff($contentArticles);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->contentArticlesScheduledForDeletion = clone $contentArticlesToDelete;

        foreach ($contentArticlesToDelete as $contentArticleRemoved) {
            $contentArticleRemoved->setContentArticle(null);
        }

        $this->collContentArticles = null;
        foreach ($contentArticles as $contentArticle) {
            $this->addContentArticle($contentArticle);
        }

        $this->collContentArticles = $contentArticles;
        $this->collContentArticlesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseArticleContentTags objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related BaseArticleContentTags objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countContentArticles(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collContentArticlesPartial && !$this->isNew();
        if (null === $this->collContentArticles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentArticles) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getContentArticles());
            }

            $query = ArticleContentTagsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContentArticle($this)
                ->count($con);
        }

        return count($this->collContentArticles);
    }

    /**
     * Method called to associate a ArticleContentTags object to this object
     * through the ArticleContentTags foreign key attribute.
     *
     * @param ArticleContentTags $l ArticleContentTags
     * @return $this The current object (for fluent API support)
     */
    public function addContentArticle(ArticleContentTags $l)
    {
        if ($this->collContentArticles === null) {
            $this->initContentArticles();
            $this->collContentArticlesPartial = true;
        }

        if (!$this->collContentArticles->contains($l)) {
            $this->doAddContentArticle($l);

            if ($this->contentArticlesScheduledForDeletion and $this->contentArticlesScheduledForDeletion->contains($l)) {
                $this->contentArticlesScheduledForDeletion->remove($this->contentArticlesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ArticleContentTags $contentArticle The ArticleContentTags object to add.
     */
    protected function doAddContentArticle(ArticleContentTags $contentArticle): void
    {
        $this->collContentArticles[]= $contentArticle;
        $contentArticle->setContentArticle($this);
    }

    /**
     * @param ArticleContentTags $contentArticle The ArticleContentTags object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeContentArticle(ArticleContentTags $contentArticle)
    {
        if ($this->getContentArticles()->contains($contentArticle)) {
            $pos = $this->collContentArticles->search($contentArticle);
            $this->collContentArticles->remove($pos);
            if (null === $this->contentArticlesScheduledForDeletion) {
                $this->contentArticlesScheduledForDeletion = clone $this->collContentArticles;
                $this->contentArticlesScheduledForDeletion->clear();
            }
            $this->contentArticlesScheduledForDeletion[]= clone $contentArticle;
            $contentArticle->setContentArticle(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Article is new, it will return
     * an empty collection; or if this Article has previously
     * been saved, it will retrieve related ContentArticles from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Article.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ArticleContentTags[] List of ArticleContentTags objects
     * @phpstan-return ObjectCollection&\Traversable<ArticleContentTags}> List of ArticleContentTags objects
     */
    public function getContentArticlesJoinContentTag(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ArticleContentTagsQuery::create(null, $criteria);
        $query->joinWith('ContentTag', $joinBehavior);

        return $this->getContentArticles($query, $con);
    }

    /**
     * Clears out the collTitleArticles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addTitleArticles()
     */
    public function clearTitleArticles()
    {
        $this->collTitleArticles = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collTitleArticles collection loaded partially.
     *
     * @return void
     */
    public function resetPartialTitleArticles($v = true): void
    {
        $this->collTitleArticlesPartial = $v;
    }

    /**
     * Initializes the collTitleArticles collection.
     *
     * By default this just sets the collTitleArticles collection to an empty array (like clearcollTitleArticles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTitleArticles(bool $overrideExisting = true): void
    {
        if (null !== $this->collTitleArticles && !$overrideExisting) {
            return;
        }

        $collectionClassName = ArticleTitleTagsTableMap::getTableMap()->getCollectionClassName();

        $this->collTitleArticles = new $collectionClassName;
        $this->collTitleArticles->setModel('\App\Schema\Crawl\ArticleTitleTags\ArticleTitleTags');
    }

    /**
     * Gets an array of ArticleTitleTags objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildArticle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ArticleTitleTags[] List of ArticleTitleTags objects
     * @phpstan-return ObjectCollection&\Traversable<ArticleTitleTags> List of ArticleTitleTags objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getTitleArticles(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collTitleArticlesPartial && !$this->isNew();
        if (null === $this->collTitleArticles || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collTitleArticles) {
                    $this->initTitleArticles();
                } else {
                    $collectionClassName = ArticleTitleTagsTableMap::getTableMap()->getCollectionClassName();

                    $collTitleArticles = new $collectionClassName;
                    $collTitleArticles->setModel('\App\Schema\Crawl\ArticleTitleTags\ArticleTitleTags');

                    return $collTitleArticles;
                }
            } else {
                $collTitleArticles = ArticleTitleTagsQuery::create(null, $criteria)
                    ->filterByTitleArticle($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTitleArticlesPartial && count($collTitleArticles)) {
                        $this->initTitleArticles(false);

                        foreach ($collTitleArticles as $obj) {
                            if (false == $this->collTitleArticles->contains($obj)) {
                                $this->collTitleArticles->append($obj);
                            }
                        }

                        $this->collTitleArticlesPartial = true;
                    }

                    return $collTitleArticles;
                }

                if ($partial && $this->collTitleArticles) {
                    foreach ($this->collTitleArticles as $obj) {
                        if ($obj->isNew()) {
                            $collTitleArticles[] = $obj;
                        }
                    }
                }

                $this->collTitleArticles = $collTitleArticles;
                $this->collTitleArticlesPartial = false;
            }
        }

        return $this->collTitleArticles;
    }

    /**
     * Sets a collection of ArticleTitleTags objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $titleArticles A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setTitleArticles(Collection $titleArticles, ?ConnectionInterface $con = null)
    {
        /** @var ArticleTitleTags[] $titleArticlesToDelete */
        $titleArticlesToDelete = $this->getTitleArticles(new Criteria(), $con)->diff($titleArticles);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->titleArticlesScheduledForDeletion = clone $titleArticlesToDelete;

        foreach ($titleArticlesToDelete as $titleArticleRemoved) {
            $titleArticleRemoved->setTitleArticle(null);
        }

        $this->collTitleArticles = null;
        foreach ($titleArticles as $titleArticle) {
            $this->addTitleArticle($titleArticle);
        }

        $this->collTitleArticles = $titleArticles;
        $this->collTitleArticlesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseArticleTitleTags objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related BaseArticleTitleTags objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countTitleArticles(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collTitleArticlesPartial && !$this->isNew();
        if (null === $this->collTitleArticles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTitleArticles) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTitleArticles());
            }

            $query = ArticleTitleTagsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTitleArticle($this)
                ->count($con);
        }

        return count($this->collTitleArticles);
    }

    /**
     * Method called to associate a ArticleTitleTags object to this object
     * through the ArticleTitleTags foreign key attribute.
     *
     * @param ArticleTitleTags $l ArticleTitleTags
     * @return $this The current object (for fluent API support)
     */
    public function addTitleArticle(ArticleTitleTags $l)
    {
        if ($this->collTitleArticles === null) {
            $this->initTitleArticles();
            $this->collTitleArticlesPartial = true;
        }

        if (!$this->collTitleArticles->contains($l)) {
            $this->doAddTitleArticle($l);

            if ($this->titleArticlesScheduledForDeletion and $this->titleArticlesScheduledForDeletion->contains($l)) {
                $this->titleArticlesScheduledForDeletion->remove($this->titleArticlesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ArticleTitleTags $titleArticle The ArticleTitleTags object to add.
     */
    protected function doAddTitleArticle(ArticleTitleTags $titleArticle): void
    {
        $this->collTitleArticles[]= $titleArticle;
        $titleArticle->setTitleArticle($this);
    }

    /**
     * @param ArticleTitleTags $titleArticle The ArticleTitleTags object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeTitleArticle(ArticleTitleTags $titleArticle)
    {
        if ($this->getTitleArticles()->contains($titleArticle)) {
            $pos = $this->collTitleArticles->search($titleArticle);
            $this->collTitleArticles->remove($pos);
            if (null === $this->titleArticlesScheduledForDeletion) {
                $this->titleArticlesScheduledForDeletion = clone $this->collTitleArticles;
                $this->titleArticlesScheduledForDeletion->clear();
            }
            $this->titleArticlesScheduledForDeletion[]= clone $titleArticle;
            $titleArticle->setTitleArticle(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Article is new, it will return
     * an empty collection; or if this Article has previously
     * been saved, it will retrieve related TitleArticles from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Article.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ArticleTitleTags[] List of ArticleTitleTags objects
     * @phpstan-return ObjectCollection&\Traversable<ArticleTitleTags}> List of ArticleTitleTags objects
     */
    public function getTitleArticlesJoinTitleTag(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ArticleTitleTagsQuery::create(null, $criteria);
        $query->joinWith('TitleTag', $joinBehavior);

        return $this->getTitleArticles($query, $con);
    }

    /**
     * Clears out the collContentTags collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addContentTags()
     */
    public function clearContentTags()
    {
        $this->collContentTags = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collContentTags crossRef collection.
     *
     * By default this just sets the collContentTags collection to an empty collection (like clearContentTags());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initContentTags()
    {
        $collectionClassName = ArticleContentTagsTableMap::getTableMap()->getCollectionClassName();

        $this->collContentTags = new $collectionClassName;
        $this->collContentTagsPartial = true;
        $this->collContentTags->setModel('\App\Schema\Crawl\Tag\Tag');
    }

    /**
     * Checks if the collContentTags collection is loaded.
     *
     * @return bool
     */
    public function isContentTagsLoaded(): bool
    {
        return null !== $this->collContentTags;
    }

    /**
     * Gets a collection of Tag objects related by a many-to-many relationship
     * to the current object by way of the article_tags cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildArticle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|Tag[] List of Tag objects
     * @phpstan-return ObjectCollection&\Traversable<Tag> List of Tag objects
     */
    public function getContentTags(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collContentTagsPartial && !$this->isNew();
        if (null === $this->collContentTags || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collContentTags) {
                    $this->initContentTags();
                }
            } else {

                $query = TagQuery::create(null, $criteria)
                    ->filterByContentArticle($this);
                $collContentTags = $query->find($con);
                if (null !== $criteria) {
                    return $collContentTags;
                }

                if ($partial && $this->collContentTags) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collContentTags as $obj) {
                        if (!$collContentTags->contains($obj)) {
                            $collContentTags[] = $obj;
                        }
                    }
                }

                $this->collContentTags = $collContentTags;
                $this->collContentTagsPartial = false;
            }
        }

        return $this->collContentTags;
    }

    /**
     * Sets a collection of Tag objects related by a many-to-many relationship
     * to the current object by way of the article_tags cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $contentTags A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setContentTags(Collection $contentTags, ?ConnectionInterface $con = null)
    {
        $this->clearContentTags();
        $currentContentTags = $this->getContentTags();

        $contentTagsScheduledForDeletion = $currentContentTags->diff($contentTags);

        foreach ($contentTagsScheduledForDeletion as $toDelete) {
            $this->removeContentTag($toDelete);
        }

        foreach ($contentTags as $contentTag) {
            if (!$currentContentTags->contains($contentTag)) {
                $this->doAddContentTag($contentTag);
            }
        }

        $this->collContentTagsPartial = false;
        $this->collContentTags = $contentTags;

        return $this;
    }

    /**
     * Gets the number of Tag objects related by a many-to-many relationship
     * to the current object by way of the article_tags cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param bool $distinct Set to true to force count distinct
     * @param ConnectionInterface $con Optional connection object
     *
     * @return int The number of related Tag objects
     */
    public function countContentTags(?Criteria $criteria = null, $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collContentTagsPartial && !$this->isNew();
        if (null === $this->collContentTags || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentTags) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getContentTags());
                }

                $query = TagQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByContentArticle($this)
                    ->count($con);
            }
        } else {
            return count($this->collContentTags);
        }
    }

    /**
     * Associate a Tag to this object
     * through the article_tags cross reference table.
     *
     * @param Tag $contentTag
     * @return ChildArticle The current object (for fluent API support)
     */
    public function addContentTag(Tag $contentTag)
    {
        if ($this->collContentTags === null) {
            $this->initContentTags();
        }

        if (!$this->getContentTags()->contains($contentTag)) {
            // only add it if the **same** object is not already associated
            $this->collContentTags->push($contentTag);
            $this->doAddContentTag($contentTag);
        }

        return $this;
    }

    /**
     *
     * @param Tag $contentTag
     */
    protected function doAddContentTag(Tag $contentTag)
    {
        $articleContentTags = new ArticleContentTags();

        $articleContentTags->setContentTag($contentTag);

        $articleContentTags->setContentArticle($this);

        $this->addContentArticle($articleContentTags);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$contentTag->isContentArticlesLoaded()) {
            $contentTag->initContentArticles();
            $contentTag->getContentArticles()->push($this);
        } elseif (!$contentTag->getContentArticles()->contains($this)) {
            $contentTag->getContentArticles()->push($this);
        }

    }

    /**
     * Remove contentTag of this object
     * through the article_tags cross reference table.
     *
     * @param Tag $contentTag
     * @return ChildArticle The current object (for fluent API support)
     */
    public function removeContentTag(Tag $contentTag)
    {
        if ($this->getContentTags()->contains($contentTag)) {
            $articleContentTags = new ArticleContentTags();
            $articleContentTags->setContentTag($contentTag);
            if ($contentTag->isContentArticlesLoaded()) {
                //remove the back reference if available
                $contentTag->getContentArticles()->removeObject($this);
            }

            $articleContentTags->setContentArticle($this);
            $this->removeContentArticle(clone $articleContentTags);
            $articleContentTags->clear();

            $this->collContentTags->remove($this->collContentTags->search($contentTag));

            if (null === $this->contentTagsScheduledForDeletion) {
                $this->contentTagsScheduledForDeletion = clone $this->collContentTags;
                $this->contentTagsScheduledForDeletion->clear();
            }

            $this->contentTagsScheduledForDeletion->push($contentTag);
        }


        return $this;
    }

    /**
     * Clears out the collTitleTags collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTitleTags()
     */
    public function clearTitleTags()
    {
        $this->collTitleTags = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collTitleTags crossRef collection.
     *
     * By default this just sets the collTitleTags collection to an empty collection (like clearTitleTags());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initTitleTags()
    {
        $collectionClassName = ArticleTitleTagsTableMap::getTableMap()->getCollectionClassName();

        $this->collTitleTags = new $collectionClassName;
        $this->collTitleTagsPartial = true;
        $this->collTitleTags->setModel('\App\Schema\Crawl\Tag\Tag');
    }

    /**
     * Checks if the collTitleTags collection is loaded.
     *
     * @return bool
     */
    public function isTitleTagsLoaded(): bool
    {
        return null !== $this->collTitleTags;
    }

    /**
     * Gets a collection of Tag objects related by a many-to-many relationship
     * to the current object by way of the article_title_tags cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildArticle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|Tag[] List of Tag objects
     * @phpstan-return ObjectCollection&\Traversable<Tag> List of Tag objects
     */
    public function getTitleTags(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collTitleTagsPartial && !$this->isNew();
        if (null === $this->collTitleTags || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collTitleTags) {
                    $this->initTitleTags();
                }
            } else {

                $query = TagQuery::create(null, $criteria)
                    ->filterByTitleArticle($this);
                $collTitleTags = $query->find($con);
                if (null !== $criteria) {
                    return $collTitleTags;
                }

                if ($partial && $this->collTitleTags) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collTitleTags as $obj) {
                        if (!$collTitleTags->contains($obj)) {
                            $collTitleTags[] = $obj;
                        }
                    }
                }

                $this->collTitleTags = $collTitleTags;
                $this->collTitleTagsPartial = false;
            }
        }

        return $this->collTitleTags;
    }

    /**
     * Sets a collection of Tag objects related by a many-to-many relationship
     * to the current object by way of the article_title_tags cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $titleTags A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setTitleTags(Collection $titleTags, ?ConnectionInterface $con = null)
    {
        $this->clearTitleTags();
        $currentTitleTags = $this->getTitleTags();

        $titleTagsScheduledForDeletion = $currentTitleTags->diff($titleTags);

        foreach ($titleTagsScheduledForDeletion as $toDelete) {
            $this->removeTitleTag($toDelete);
        }

        foreach ($titleTags as $titleTag) {
            if (!$currentTitleTags->contains($titleTag)) {
                $this->doAddTitleTag($titleTag);
            }
        }

        $this->collTitleTagsPartial = false;
        $this->collTitleTags = $titleTags;

        return $this;
    }

    /**
     * Gets the number of Tag objects related by a many-to-many relationship
     * to the current object by way of the article_title_tags cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param bool $distinct Set to true to force count distinct
     * @param ConnectionInterface $con Optional connection object
     *
     * @return int The number of related Tag objects
     */
    public function countTitleTags(?Criteria $criteria = null, $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collTitleTagsPartial && !$this->isNew();
        if (null === $this->collTitleTags || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTitleTags) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getTitleTags());
                }

                $query = TagQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByTitleArticle($this)
                    ->count($con);
            }
        } else {
            return count($this->collTitleTags);
        }
    }

    /**
     * Associate a Tag to this object
     * through the article_title_tags cross reference table.
     *
     * @param Tag $titleTag
     * @return ChildArticle The current object (for fluent API support)
     */
    public function addTitleTag(Tag $titleTag)
    {
        if ($this->collTitleTags === null) {
            $this->initTitleTags();
        }

        if (!$this->getTitleTags()->contains($titleTag)) {
            // only add it if the **same** object is not already associated
            $this->collTitleTags->push($titleTag);
            $this->doAddTitleTag($titleTag);
        }

        return $this;
    }

    /**
     *
     * @param Tag $titleTag
     */
    protected function doAddTitleTag(Tag $titleTag)
    {
        $articleTitleTags = new ArticleTitleTags();

        $articleTitleTags->setTitleTag($titleTag);

        $articleTitleTags->setTitleArticle($this);

        $this->addTitleArticle($articleTitleTags);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$titleTag->isTitleArticlesLoaded()) {
            $titleTag->initTitleArticles();
            $titleTag->getTitleArticles()->push($this);
        } elseif (!$titleTag->getTitleArticles()->contains($this)) {
            $titleTag->getTitleArticles()->push($this);
        }

    }

    /**
     * Remove titleTag of this object
     * through the article_title_tags cross reference table.
     *
     * @param Tag $titleTag
     * @return ChildArticle The current object (for fluent API support)
     */
    public function removeTitleTag(Tag $titleTag)
    {
        if ($this->getTitleTags()->contains($titleTag)) {
            $articleTitleTags = new ArticleTitleTags();
            $articleTitleTags->setTitleTag($titleTag);
            if ($titleTag->isTitleArticlesLoaded()) {
                //remove the back reference if available
                $titleTag->getTitleArticles()->removeObject($this);
            }

            $articleTitleTags->setTitleArticle($this);
            $this->removeTitleArticle(clone $articleTitleTags);
            $articleTitleTags->clear();

            $this->collTitleTags->remove($this->collTitleTags->search($titleTag));

            if (null === $this->titleTagsScheduledForDeletion) {
                $this->titleTagsScheduledForDeletion = clone $this->collTitleTags;
                $this->titleTagsScheduledForDeletion->clear();
            }

            $this->titleTagsScheduledForDeletion->push($titleTag);
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
        $this->id = null;
        $this->article_id = null;
        $this->link = null;
        $this->site = null;
        $this->ts = null;
        $this->title = null;
        $this->content = null;
        $this->cats = null;
        $this->last_tagged = null;
        $this->type = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
            if ($this->collContentArticles) {
                foreach ($this->collContentArticles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTitleArticles) {
                foreach ($this->collTitleArticles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentTags) {
                foreach ($this->collContentTags as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTitleTags) {
                foreach ($this->collTitleTags as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collContentArticles = null;
        $this->collTitleArticles = null;
        $this->collContentTags = null;
        $this->collTitleTags = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ArticleTableMap::DEFAULT_STRING_FORMAT);
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
