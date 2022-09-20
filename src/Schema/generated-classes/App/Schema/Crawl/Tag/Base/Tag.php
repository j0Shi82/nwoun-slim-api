<?php

namespace App\Schema\Crawl\Tag\Base;

use \Exception;
use \PDO;
use App\Schema\Crawl\Article\Article;
use App\Schema\Crawl\Article\ArticleQuery;
use App\Schema\Crawl\ArticleContentTags\ArticleContentTags;
use App\Schema\Crawl\ArticleContentTags\ArticleContentTagsQuery;
use App\Schema\Crawl\ArticleContentTags\Base\ArticleContentTags as BaseArticleContentTags;
use App\Schema\Crawl\ArticleContentTags\Map\ArticleContentTagsTableMap;
use App\Schema\Crawl\ArticleTitleTags\ArticleTitleTags;
use App\Schema\Crawl\ArticleTitleTags\ArticleTitleTagsQuery;
use App\Schema\Crawl\ArticleTitleTags\Base\ArticleTitleTags as BaseArticleTitleTags;
use App\Schema\Crawl\ArticleTitleTags\Map\ArticleTitleTagsTableMap;
use App\Schema\Crawl\Tag\Tag as ChildTag;
use App\Schema\Crawl\Tag\TagQuery as ChildTagQuery;
use App\Schema\Crawl\Tag\Map\TagTableMap;
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
 * Base class that represents a row from the 'tag' table.
 *
 *
 *
 * @package    propel.generator.App.Schema.Crawl.Tag.Base
 */
abstract class Tag implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\App\\Schema\\Crawl\\Tag\\Map\\TagTableMap';


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
     * The value for the term field.
     *
     * @var        string
     */
    protected $term;

    /**
     * @var        ObjectCollection|ArticleContentTags[] Collection to store aggregation of ArticleContentTags objects.
     * @phpstan-var ObjectCollection&\Traversable<ArticleContentTags> Collection to store aggregation of ArticleContentTags objects.
     */
    protected $collContentTags;
    protected $collContentTagsPartial;

    /**
     * @var        ObjectCollection|ArticleTitleTags[] Collection to store aggregation of ArticleTitleTags objects.
     * @phpstan-var ObjectCollection&\Traversable<ArticleTitleTags> Collection to store aggregation of ArticleTitleTags objects.
     */
    protected $collTitleTags;
    protected $collTitleTagsPartial;

    /**
     * @var        ObjectCollection|Article[] Cross Collection to store aggregation of Article objects.
     * @phpstan-var ObjectCollection&\Traversable<Article> Cross Collection to store aggregation of Article objects.
     */
    protected $collContentArticles;

    /**
     * @var bool
     */
    protected $collContentArticlesPartial;

    /**
     * @var        ObjectCollection|Article[] Cross Collection to store aggregation of Article objects.
     * @phpstan-var ObjectCollection&\Traversable<Article> Cross Collection to store aggregation of Article objects.
     */
    protected $collTitleArticles;

    /**
     * @var bool
     */
    protected $collTitleArticlesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|Article[]
     * @phpstan-var ObjectCollection&\Traversable<Article>
     */
    protected $contentArticlesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|Article[]
     * @phpstan-var ObjectCollection&\Traversable<Article>
     */
    protected $titleArticlesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ArticleContentTags[]
     * @phpstan-var ObjectCollection&\Traversable<ArticleContentTags>
     */
    protected $contentTagsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ArticleTitleTags[]
     * @phpstan-var ObjectCollection&\Traversable<ArticleTitleTags>
     */
    protected $titleTagsScheduledForDeletion = null;

    /**
     * Initializes internal state of App\Schema\Crawl\Tag\Base\Tag object.
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
     * Compares this with another <code>Tag</code> instance.  If
     * <code>obj</code> is an instance of <code>Tag</code>, delegates to
     * <code>equals(Tag)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [term] column value.
     *
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
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
            $this->modifiedColumns[TagTableMap::COL_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [term] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setTerm($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->term !== $v) {
            $this->term = $v;
            $this->modifiedColumns[TagTableMap::COL_TERM] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TagTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TagTableMap::translateFieldName('Term', TableMap::TYPE_PHPNAME, $indexType)];
            $this->term = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = TagTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Schema\\Crawl\\Tag\\Tag'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(TagTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTagQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collContentTags = null;

            $this->collTitleTags = null;

            $this->collContentArticles = null;
            $this->collTitleArticles = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see Tag::setDeleted()
     * @see Tag::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TagTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTagQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(TagTableMap::DATABASE_NAME);
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
                TagTableMap::addInstanceToPool($this);
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

            if ($this->contentArticlesScheduledForDeletion !== null) {
                if (!$this->contentArticlesScheduledForDeletion->isEmpty()) {
                    $pks = [];
                    foreach ($this->contentArticlesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \App\Schema\Crawl\ArticleContentTags\ArticleContentTagsQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->contentArticlesScheduledForDeletion = null;
                }

            }

            if ($this->collContentArticles) {
                foreach ($this->collContentArticles as $contentArticle) {
                    if (!$contentArticle->isDeleted() && ($contentArticle->isNew() || $contentArticle->isModified())) {
                        $contentArticle->save($con);
                    }
                }
            }


            if ($this->titleArticlesScheduledForDeletion !== null) {
                if (!$this->titleArticlesScheduledForDeletion->isEmpty()) {
                    $pks = [];
                    foreach ($this->titleArticlesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \App\Schema\Crawl\ArticleTitleTags\ArticleTitleTagsQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->titleArticlesScheduledForDeletion = null;
                }

            }

            if ($this->collTitleArticles) {
                foreach ($this->collTitleArticles as $titleArticle) {
                    if (!$titleArticle->isDeleted() && ($titleArticle->isNew() || $titleArticle->isModified())) {
                        $titleArticle->save($con);
                    }
                }
            }


            if ($this->contentTagsScheduledForDeletion !== null) {
                if (!$this->contentTagsScheduledForDeletion->isEmpty()) {
                    \App\Schema\Crawl\ArticleContentTags\ArticleContentTagsQuery::create()
                        ->filterByPrimaryKeys($this->contentTagsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentTagsScheduledForDeletion = null;
                }
            }

            if ($this->collContentTags !== null) {
                foreach ($this->collContentTags as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->titleTagsScheduledForDeletion !== null) {
                if (!$this->titleTagsScheduledForDeletion->isEmpty()) {
                    \App\Schema\Crawl\ArticleTitleTags\ArticleTitleTagsQuery::create()
                        ->filterByPrimaryKeys($this->titleTagsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->titleTagsScheduledForDeletion = null;
                }
            }

            if ($this->collTitleTags !== null) {
                foreach ($this->collTitleTags as $referrerFK) {
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

        $this->modifiedColumns[TagTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TagTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TagTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(TagTableMap::COL_TERM)) {
            $modifiedColumns[':p' . $index++]  = 'term';
        }

        $sql = sprintf(
            'INSERT INTO tag (%s) VALUES (%s)',
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
                    case 'term':
                        $stmt->bindValue($identifier, $this->term, PDO::PARAM_STR);
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
        $pos = TagTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getTerm();

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
        if (isset($alreadyDumpedObjects['Tag'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Tag'][$this->hashCode()] = true;
        $keys = TagTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTerm(),
        ];
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collContentTags) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'articleContentTagss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'article_tagss';
                        break;
                    default:
                        $key = 'ContentTags';
                }

                $result[$key] = $this->collContentTags->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTitleTags) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'articleTitleTagss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'article_title_tagss';
                        break;
                    default:
                        $key = 'TitleTags';
                }

                $result[$key] = $this->collTitleTags->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = TagTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setTerm($value);
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
        $keys = TagTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTerm($arr[$keys[1]]);
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
        $criteria = new Criteria(TagTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TagTableMap::COL_ID)) {
            $criteria->add(TagTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(TagTableMap::COL_TERM)) {
            $criteria->add(TagTableMap::COL_TERM, $this->term);
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
        $criteria = ChildTagQuery::create();
        $criteria->add(TagTableMap::COL_ID, $this->id);

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
     * @param object $copyObj An object of \App\Schema\Crawl\Tag\Tag (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setTerm($this->getTerm());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getContentTags() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContentTag($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTitleTags() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTitleTag($relObj->copy($deepCopy));
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
     * @return \App\Schema\Crawl\Tag\Tag Clone of current object.
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
        if ('ContentTag' === $relationName) {
            $this->initContentTags();
            return;
        }
        if ('TitleTag' === $relationName) {
            $this->initTitleTags();
            return;
        }
    }

    /**
     * Clears out the collContentTags collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addContentTags()
     */
    public function clearContentTags()
    {
        $this->collContentTags = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collContentTags collection loaded partially.
     *
     * @return void
     */
    public function resetPartialContentTags($v = true): void
    {
        $this->collContentTagsPartial = $v;
    }

    /**
     * Initializes the collContentTags collection.
     *
     * By default this just sets the collContentTags collection to an empty array (like clearcollContentTags());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContentTags(bool $overrideExisting = true): void
    {
        if (null !== $this->collContentTags && !$overrideExisting) {
            return;
        }

        $collectionClassName = ArticleContentTagsTableMap::getTableMap()->getCollectionClassName();

        $this->collContentTags = new $collectionClassName;
        $this->collContentTags->setModel('\App\Schema\Crawl\ArticleContentTags\ArticleContentTags');
    }

    /**
     * Gets an array of ArticleContentTags objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTag is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ArticleContentTags[] List of ArticleContentTags objects
     * @phpstan-return ObjectCollection&\Traversable<ArticleContentTags> List of ArticleContentTags objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getContentTags(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collContentTagsPartial && !$this->isNew();
        if (null === $this->collContentTags || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collContentTags) {
                    $this->initContentTags();
                } else {
                    $collectionClassName = ArticleContentTagsTableMap::getTableMap()->getCollectionClassName();

                    $collContentTags = new $collectionClassName;
                    $collContentTags->setModel('\App\Schema\Crawl\ArticleContentTags\ArticleContentTags');

                    return $collContentTags;
                }
            } else {
                $collContentTags = ArticleContentTagsQuery::create(null, $criteria)
                    ->filterByContentTag($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collContentTagsPartial && count($collContentTags)) {
                        $this->initContentTags(false);

                        foreach ($collContentTags as $obj) {
                            if (false == $this->collContentTags->contains($obj)) {
                                $this->collContentTags->append($obj);
                            }
                        }

                        $this->collContentTagsPartial = true;
                    }

                    return $collContentTags;
                }

                if ($partial && $this->collContentTags) {
                    foreach ($this->collContentTags as $obj) {
                        if ($obj->isNew()) {
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
     * Sets a collection of ArticleContentTags objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $contentTags A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setContentTags(Collection $contentTags, ?ConnectionInterface $con = null)
    {
        /** @var ArticleContentTags[] $contentTagsToDelete */
        $contentTagsToDelete = $this->getContentTags(new Criteria(), $con)->diff($contentTags);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->contentTagsScheduledForDeletion = clone $contentTagsToDelete;

        foreach ($contentTagsToDelete as $contentTagRemoved) {
            $contentTagRemoved->setContentTag(null);
        }

        $this->collContentTags = null;
        foreach ($contentTags as $contentTag) {
            $this->addContentTag($contentTag);
        }

        $this->collContentTags = $contentTags;
        $this->collContentTagsPartial = false;

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
    public function countContentTags(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collContentTagsPartial && !$this->isNew();
        if (null === $this->collContentTags || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentTags) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getContentTags());
            }

            $query = ArticleContentTagsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContentTag($this)
                ->count($con);
        }

        return count($this->collContentTags);
    }

    /**
     * Method called to associate a ArticleContentTags object to this object
     * through the ArticleContentTags foreign key attribute.
     *
     * @param ArticleContentTags $l ArticleContentTags
     * @return $this The current object (for fluent API support)
     */
    public function addContentTag(ArticleContentTags $l)
    {
        if ($this->collContentTags === null) {
            $this->initContentTags();
            $this->collContentTagsPartial = true;
        }

        if (!$this->collContentTags->contains($l)) {
            $this->doAddContentTag($l);

            if ($this->contentTagsScheduledForDeletion and $this->contentTagsScheduledForDeletion->contains($l)) {
                $this->contentTagsScheduledForDeletion->remove($this->contentTagsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ArticleContentTags $contentTag The ArticleContentTags object to add.
     */
    protected function doAddContentTag(ArticleContentTags $contentTag): void
    {
        $this->collContentTags[]= $contentTag;
        $contentTag->setContentTag($this);
    }

    /**
     * @param ArticleContentTags $contentTag The ArticleContentTags object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeContentTag(ArticleContentTags $contentTag)
    {
        if ($this->getContentTags()->contains($contentTag)) {
            $pos = $this->collContentTags->search($contentTag);
            $this->collContentTags->remove($pos);
            if (null === $this->contentTagsScheduledForDeletion) {
                $this->contentTagsScheduledForDeletion = clone $this->collContentTags;
                $this->contentTagsScheduledForDeletion->clear();
            }
            $this->contentTagsScheduledForDeletion[]= clone $contentTag;
            $contentTag->setContentTag(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Tag is new, it will return
     * an empty collection; or if this Tag has previously
     * been saved, it will retrieve related ContentTags from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Tag.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ArticleContentTags[] List of ArticleContentTags objects
     * @phpstan-return ObjectCollection&\Traversable<ArticleContentTags}> List of ArticleContentTags objects
     */
    public function getContentTagsJoinContentArticle(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ArticleContentTagsQuery::create(null, $criteria);
        $query->joinWith('ContentArticle', $joinBehavior);

        return $this->getContentTags($query, $con);
    }

    /**
     * Clears out the collTitleTags collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addTitleTags()
     */
    public function clearTitleTags()
    {
        $this->collTitleTags = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collTitleTags collection loaded partially.
     *
     * @return void
     */
    public function resetPartialTitleTags($v = true): void
    {
        $this->collTitleTagsPartial = $v;
    }

    /**
     * Initializes the collTitleTags collection.
     *
     * By default this just sets the collTitleTags collection to an empty array (like clearcollTitleTags());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTitleTags(bool $overrideExisting = true): void
    {
        if (null !== $this->collTitleTags && !$overrideExisting) {
            return;
        }

        $collectionClassName = ArticleTitleTagsTableMap::getTableMap()->getCollectionClassName();

        $this->collTitleTags = new $collectionClassName;
        $this->collTitleTags->setModel('\App\Schema\Crawl\ArticleTitleTags\ArticleTitleTags');
    }

    /**
     * Gets an array of ArticleTitleTags objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTag is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ArticleTitleTags[] List of ArticleTitleTags objects
     * @phpstan-return ObjectCollection&\Traversable<ArticleTitleTags> List of ArticleTitleTags objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getTitleTags(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collTitleTagsPartial && !$this->isNew();
        if (null === $this->collTitleTags || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collTitleTags) {
                    $this->initTitleTags();
                } else {
                    $collectionClassName = ArticleTitleTagsTableMap::getTableMap()->getCollectionClassName();

                    $collTitleTags = new $collectionClassName;
                    $collTitleTags->setModel('\App\Schema\Crawl\ArticleTitleTags\ArticleTitleTags');

                    return $collTitleTags;
                }
            } else {
                $collTitleTags = ArticleTitleTagsQuery::create(null, $criteria)
                    ->filterByTitleTag($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTitleTagsPartial && count($collTitleTags)) {
                        $this->initTitleTags(false);

                        foreach ($collTitleTags as $obj) {
                            if (false == $this->collTitleTags->contains($obj)) {
                                $this->collTitleTags->append($obj);
                            }
                        }

                        $this->collTitleTagsPartial = true;
                    }

                    return $collTitleTags;
                }

                if ($partial && $this->collTitleTags) {
                    foreach ($this->collTitleTags as $obj) {
                        if ($obj->isNew()) {
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
     * Sets a collection of ArticleTitleTags objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $titleTags A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setTitleTags(Collection $titleTags, ?ConnectionInterface $con = null)
    {
        /** @var ArticleTitleTags[] $titleTagsToDelete */
        $titleTagsToDelete = $this->getTitleTags(new Criteria(), $con)->diff($titleTags);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->titleTagsScheduledForDeletion = clone $titleTagsToDelete;

        foreach ($titleTagsToDelete as $titleTagRemoved) {
            $titleTagRemoved->setTitleTag(null);
        }

        $this->collTitleTags = null;
        foreach ($titleTags as $titleTag) {
            $this->addTitleTag($titleTag);
        }

        $this->collTitleTags = $titleTags;
        $this->collTitleTagsPartial = false;

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
    public function countTitleTags(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collTitleTagsPartial && !$this->isNew();
        if (null === $this->collTitleTags || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTitleTags) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTitleTags());
            }

            $query = ArticleTitleTagsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTitleTag($this)
                ->count($con);
        }

        return count($this->collTitleTags);
    }

    /**
     * Method called to associate a ArticleTitleTags object to this object
     * through the ArticleTitleTags foreign key attribute.
     *
     * @param ArticleTitleTags $l ArticleTitleTags
     * @return $this The current object (for fluent API support)
     */
    public function addTitleTag(ArticleTitleTags $l)
    {
        if ($this->collTitleTags === null) {
            $this->initTitleTags();
            $this->collTitleTagsPartial = true;
        }

        if (!$this->collTitleTags->contains($l)) {
            $this->doAddTitleTag($l);

            if ($this->titleTagsScheduledForDeletion and $this->titleTagsScheduledForDeletion->contains($l)) {
                $this->titleTagsScheduledForDeletion->remove($this->titleTagsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ArticleTitleTags $titleTag The ArticleTitleTags object to add.
     */
    protected function doAddTitleTag(ArticleTitleTags $titleTag): void
    {
        $this->collTitleTags[]= $titleTag;
        $titleTag->setTitleTag($this);
    }

    /**
     * @param ArticleTitleTags $titleTag The ArticleTitleTags object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeTitleTag(ArticleTitleTags $titleTag)
    {
        if ($this->getTitleTags()->contains($titleTag)) {
            $pos = $this->collTitleTags->search($titleTag);
            $this->collTitleTags->remove($pos);
            if (null === $this->titleTagsScheduledForDeletion) {
                $this->titleTagsScheduledForDeletion = clone $this->collTitleTags;
                $this->titleTagsScheduledForDeletion->clear();
            }
            $this->titleTagsScheduledForDeletion[]= clone $titleTag;
            $titleTag->setTitleTag(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Tag is new, it will return
     * an empty collection; or if this Tag has previously
     * been saved, it will retrieve related TitleTags from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Tag.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ArticleTitleTags[] List of ArticleTitleTags objects
     * @phpstan-return ObjectCollection&\Traversable<ArticleTitleTags}> List of ArticleTitleTags objects
     */
    public function getTitleTagsJoinTitleArticle(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ArticleTitleTagsQuery::create(null, $criteria);
        $query->joinWith('TitleArticle', $joinBehavior);

        return $this->getTitleTags($query, $con);
    }

    /**
     * Clears out the collContentArticles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addContentArticles()
     */
    public function clearContentArticles()
    {
        $this->collContentArticles = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collContentArticles crossRef collection.
     *
     * By default this just sets the collContentArticles collection to an empty collection (like clearContentArticles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initContentArticles()
    {
        $collectionClassName = ArticleContentTagsTableMap::getTableMap()->getCollectionClassName();

        $this->collContentArticles = new $collectionClassName;
        $this->collContentArticlesPartial = true;
        $this->collContentArticles->setModel('\App\Schema\Crawl\Article\Article');
    }

    /**
     * Checks if the collContentArticles collection is loaded.
     *
     * @return bool
     */
    public function isContentArticlesLoaded(): bool
    {
        return null !== $this->collContentArticles;
    }

    /**
     * Gets a collection of Article objects related by a many-to-many relationship
     * to the current object by way of the article_tags cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTag is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|Article[] List of Article objects
     * @phpstan-return ObjectCollection&\Traversable<Article> List of Article objects
     */
    public function getContentArticles(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collContentArticlesPartial && !$this->isNew();
        if (null === $this->collContentArticles || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collContentArticles) {
                    $this->initContentArticles();
                }
            } else {

                $query = ArticleQuery::create(null, $criteria)
                    ->filterByContentTag($this);
                $collContentArticles = $query->find($con);
                if (null !== $criteria) {
                    return $collContentArticles;
                }

                if ($partial && $this->collContentArticles) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collContentArticles as $obj) {
                        if (!$collContentArticles->contains($obj)) {
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
     * Sets a collection of Article objects related by a many-to-many relationship
     * to the current object by way of the article_tags cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $contentArticles A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setContentArticles(Collection $contentArticles, ?ConnectionInterface $con = null)
    {
        $this->clearContentArticles();
        $currentContentArticles = $this->getContentArticles();

        $contentArticlesScheduledForDeletion = $currentContentArticles->diff($contentArticles);

        foreach ($contentArticlesScheduledForDeletion as $toDelete) {
            $this->removeContentArticle($toDelete);
        }

        foreach ($contentArticles as $contentArticle) {
            if (!$currentContentArticles->contains($contentArticle)) {
                $this->doAddContentArticle($contentArticle);
            }
        }

        $this->collContentArticlesPartial = false;
        $this->collContentArticles = $contentArticles;

        return $this;
    }

    /**
     * Gets the number of Article objects related by a many-to-many relationship
     * to the current object by way of the article_tags cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param bool $distinct Set to true to force count distinct
     * @param ConnectionInterface $con Optional connection object
     *
     * @return int The number of related Article objects
     */
    public function countContentArticles(?Criteria $criteria = null, $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collContentArticlesPartial && !$this->isNew();
        if (null === $this->collContentArticles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentArticles) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getContentArticles());
                }

                $query = ArticleQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByContentTag($this)
                    ->count($con);
            }
        } else {
            return count($this->collContentArticles);
        }
    }

    /**
     * Associate a Article to this object
     * through the article_tags cross reference table.
     *
     * @param Article $contentArticle
     * @return ChildTag The current object (for fluent API support)
     */
    public function addContentArticle(Article $contentArticle)
    {
        if ($this->collContentArticles === null) {
            $this->initContentArticles();
        }

        if (!$this->getContentArticles()->contains($contentArticle)) {
            // only add it if the **same** object is not already associated
            $this->collContentArticles->push($contentArticle);
            $this->doAddContentArticle($contentArticle);
        }

        return $this;
    }

    /**
     *
     * @param Article $contentArticle
     */
    protected function doAddContentArticle(Article $contentArticle)
    {
        $articleContentTags = new ArticleContentTags();

        $articleContentTags->setContentArticle($contentArticle);

        $articleContentTags->setContentTag($this);

        $this->addContentTag($articleContentTags);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$contentArticle->isContentTagsLoaded()) {
            $contentArticle->initContentTags();
            $contentArticle->getContentTags()->push($this);
        } elseif (!$contentArticle->getContentTags()->contains($this)) {
            $contentArticle->getContentTags()->push($this);
        }

    }

    /**
     * Remove contentArticle of this object
     * through the article_tags cross reference table.
     *
     * @param Article $contentArticle
     * @return ChildTag The current object (for fluent API support)
     */
    public function removeContentArticle(Article $contentArticle)
    {
        if ($this->getContentArticles()->contains($contentArticle)) {
            $articleContentTags = new ArticleContentTags();
            $articleContentTags->setContentArticle($contentArticle);
            if ($contentArticle->isContentTagsLoaded()) {
                //remove the back reference if available
                $contentArticle->getContentTags()->removeObject($this);
            }

            $articleContentTags->setContentTag($this);
            $this->removeContentTag(clone $articleContentTags);
            $articleContentTags->clear();

            $this->collContentArticles->remove($this->collContentArticles->search($contentArticle));

            if (null === $this->contentArticlesScheduledForDeletion) {
                $this->contentArticlesScheduledForDeletion = clone $this->collContentArticles;
                $this->contentArticlesScheduledForDeletion->clear();
            }

            $this->contentArticlesScheduledForDeletion->push($contentArticle);
        }


        return $this;
    }

    /**
     * Clears out the collTitleArticles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTitleArticles()
     */
    public function clearTitleArticles()
    {
        $this->collTitleArticles = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collTitleArticles crossRef collection.
     *
     * By default this just sets the collTitleArticles collection to an empty collection (like clearTitleArticles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initTitleArticles()
    {
        $collectionClassName = ArticleTitleTagsTableMap::getTableMap()->getCollectionClassName();

        $this->collTitleArticles = new $collectionClassName;
        $this->collTitleArticlesPartial = true;
        $this->collTitleArticles->setModel('\App\Schema\Crawl\Article\Article');
    }

    /**
     * Checks if the collTitleArticles collection is loaded.
     *
     * @return bool
     */
    public function isTitleArticlesLoaded(): bool
    {
        return null !== $this->collTitleArticles;
    }

    /**
     * Gets a collection of Article objects related by a many-to-many relationship
     * to the current object by way of the article_title_tags cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTag is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|Article[] List of Article objects
     * @phpstan-return ObjectCollection&\Traversable<Article> List of Article objects
     */
    public function getTitleArticles(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collTitleArticlesPartial && !$this->isNew();
        if (null === $this->collTitleArticles || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collTitleArticles) {
                    $this->initTitleArticles();
                }
            } else {

                $query = ArticleQuery::create(null, $criteria)
                    ->filterByTitleTag($this);
                $collTitleArticles = $query->find($con);
                if (null !== $criteria) {
                    return $collTitleArticles;
                }

                if ($partial && $this->collTitleArticles) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collTitleArticles as $obj) {
                        if (!$collTitleArticles->contains($obj)) {
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
     * Sets a collection of Article objects related by a many-to-many relationship
     * to the current object by way of the article_title_tags cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $titleArticles A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setTitleArticles(Collection $titleArticles, ?ConnectionInterface $con = null)
    {
        $this->clearTitleArticles();
        $currentTitleArticles = $this->getTitleArticles();

        $titleArticlesScheduledForDeletion = $currentTitleArticles->diff($titleArticles);

        foreach ($titleArticlesScheduledForDeletion as $toDelete) {
            $this->removeTitleArticle($toDelete);
        }

        foreach ($titleArticles as $titleArticle) {
            if (!$currentTitleArticles->contains($titleArticle)) {
                $this->doAddTitleArticle($titleArticle);
            }
        }

        $this->collTitleArticlesPartial = false;
        $this->collTitleArticles = $titleArticles;

        return $this;
    }

    /**
     * Gets the number of Article objects related by a many-to-many relationship
     * to the current object by way of the article_title_tags cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param bool $distinct Set to true to force count distinct
     * @param ConnectionInterface $con Optional connection object
     *
     * @return int The number of related Article objects
     */
    public function countTitleArticles(?Criteria $criteria = null, $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collTitleArticlesPartial && !$this->isNew();
        if (null === $this->collTitleArticles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTitleArticles) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getTitleArticles());
                }

                $query = ArticleQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByTitleTag($this)
                    ->count($con);
            }
        } else {
            return count($this->collTitleArticles);
        }
    }

    /**
     * Associate a Article to this object
     * through the article_title_tags cross reference table.
     *
     * @param Article $titleArticle
     * @return ChildTag The current object (for fluent API support)
     */
    public function addTitleArticle(Article $titleArticle)
    {
        if ($this->collTitleArticles === null) {
            $this->initTitleArticles();
        }

        if (!$this->getTitleArticles()->contains($titleArticle)) {
            // only add it if the **same** object is not already associated
            $this->collTitleArticles->push($titleArticle);
            $this->doAddTitleArticle($titleArticle);
        }

        return $this;
    }

    /**
     *
     * @param Article $titleArticle
     */
    protected function doAddTitleArticle(Article $titleArticle)
    {
        $articleTitleTags = new ArticleTitleTags();

        $articleTitleTags->setTitleArticle($titleArticle);

        $articleTitleTags->setTitleTag($this);

        $this->addTitleTag($articleTitleTags);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$titleArticle->isTitleTagsLoaded()) {
            $titleArticle->initTitleTags();
            $titleArticle->getTitleTags()->push($this);
        } elseif (!$titleArticle->getTitleTags()->contains($this)) {
            $titleArticle->getTitleTags()->push($this);
        }

    }

    /**
     * Remove titleArticle of this object
     * through the article_title_tags cross reference table.
     *
     * @param Article $titleArticle
     * @return ChildTag The current object (for fluent API support)
     */
    public function removeTitleArticle(Article $titleArticle)
    {
        if ($this->getTitleArticles()->contains($titleArticle)) {
            $articleTitleTags = new ArticleTitleTags();
            $articleTitleTags->setTitleArticle($titleArticle);
            if ($titleArticle->isTitleTagsLoaded()) {
                //remove the back reference if available
                $titleArticle->getTitleTags()->removeObject($this);
            }

            $articleTitleTags->setTitleTag($this);
            $this->removeTitleTag(clone $articleTitleTags);
            $articleTitleTags->clear();

            $this->collTitleArticles->remove($this->collTitleArticles->search($titleArticle));

            if (null === $this->titleArticlesScheduledForDeletion) {
                $this->titleArticlesScheduledForDeletion = clone $this->collTitleArticles;
                $this->titleArticlesScheduledForDeletion->clear();
            }

            $this->titleArticlesScheduledForDeletion->push($titleArticle);
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
        $this->term = null;
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
        } // if ($deep)

        $this->collContentTags = null;
        $this->collTitleTags = null;
        $this->collContentArticles = null;
        $this->collTitleArticles = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TagTableMap::DEFAULT_STRING_FORMAT);
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
