<?php

namespace App\Schema\Crawl\Article\Base;

use \Exception;
use \PDO;
use App\Schema\Crawl\Article\Article as ChildArticle;
use App\Schema\Crawl\Article\ArticleQuery as ChildArticleQuery;
use App\Schema\Crawl\Article\Map\ArticleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'article' table.
 *
 *
 *
 * @method     ChildArticleQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildArticleQuery orderByArticleId($order = Criteria::ASC) Order by the article_id column
 * @method     ChildArticleQuery orderByLink($order = Criteria::ASC) Order by the link column
 * @method     ChildArticleQuery orderBySite($order = Criteria::ASC) Order by the site column
 * @method     ChildArticleQuery orderByTs($order = Criteria::ASC) Order by the ts column
 * @method     ChildArticleQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildArticleQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildArticleQuery orderByCats($order = Criteria::ASC) Order by the cats column
 * @method     ChildArticleQuery orderByLastTagged($order = Criteria::ASC) Order by the last_tagged column
 * @method     ChildArticleQuery orderByType($order = Criteria::ASC) Order by the type column
 *
 * @method     ChildArticleQuery groupById() Group by the id column
 * @method     ChildArticleQuery groupByArticleId() Group by the article_id column
 * @method     ChildArticleQuery groupByLink() Group by the link column
 * @method     ChildArticleQuery groupBySite() Group by the site column
 * @method     ChildArticleQuery groupByTs() Group by the ts column
 * @method     ChildArticleQuery groupByTitle() Group by the title column
 * @method     ChildArticleQuery groupByContent() Group by the content column
 * @method     ChildArticleQuery groupByCats() Group by the cats column
 * @method     ChildArticleQuery groupByLastTagged() Group by the last_tagged column
 * @method     ChildArticleQuery groupByType() Group by the type column
 *
 * @method     ChildArticleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildArticleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildArticleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildArticleQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildArticleQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildArticleQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildArticle|null findOne(ConnectionInterface $con = null) Return the first ChildArticle matching the query
 * @method     ChildArticle findOneOrCreate(ConnectionInterface $con = null) Return the first ChildArticle matching the query, or a new ChildArticle object populated from the query conditions when no match is found
 *
 * @method     ChildArticle|null findOneById(int $id) Return the first ChildArticle filtered by the id column
 * @method     ChildArticle|null findOneByArticleId(string $article_id) Return the first ChildArticle filtered by the article_id column
 * @method     ChildArticle|null findOneByLink(string $link) Return the first ChildArticle filtered by the link column
 * @method     ChildArticle|null findOneBySite(string $site) Return the first ChildArticle filtered by the site column
 * @method     ChildArticle|null findOneByTs(int $ts) Return the first ChildArticle filtered by the ts column
 * @method     ChildArticle|null findOneByTitle(string $title) Return the first ChildArticle filtered by the title column
 * @method     ChildArticle|null findOneByContent(string $content) Return the first ChildArticle filtered by the content column
 * @method     ChildArticle|null findOneByCats(string $cats) Return the first ChildArticle filtered by the cats column
 * @method     ChildArticle|null findOneByLastTagged(int $last_tagged) Return the first ChildArticle filtered by the last_tagged column
 * @method     ChildArticle|null findOneByType(string $type) Return the first ChildArticle filtered by the type column *

 * @method     ChildArticle requirePk($key, ConnectionInterface $con = null) Return the ChildArticle by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOne(ConnectionInterface $con = null) Return the first ChildArticle matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildArticle requireOneById(int $id) Return the first ChildArticle filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByArticleId(string $article_id) Return the first ChildArticle filtered by the article_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByLink(string $link) Return the first ChildArticle filtered by the link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneBySite(string $site) Return the first ChildArticle filtered by the site column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByTs(int $ts) Return the first ChildArticle filtered by the ts column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByTitle(string $title) Return the first ChildArticle filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByContent(string $content) Return the first ChildArticle filtered by the content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByCats(string $cats) Return the first ChildArticle filtered by the cats column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByLastTagged(int $last_tagged) Return the first ChildArticle filtered by the last_tagged column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByType(string $type) Return the first ChildArticle filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildArticle[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildArticle objects based on current ModelCriteria
 * @psalm-method ObjectCollection&\Traversable<ChildArticle> find(ConnectionInterface $con = null) Return ChildArticle objects based on current ModelCriteria
 * @method     ChildArticle[]|ObjectCollection findById(int $id) Return ChildArticle objects filtered by the id column
 * @psalm-method ObjectCollection&\Traversable<ChildArticle> findById(int $id) Return ChildArticle objects filtered by the id column
 * @method     ChildArticle[]|ObjectCollection findByArticleId(string $article_id) Return ChildArticle objects filtered by the article_id column
 * @psalm-method ObjectCollection&\Traversable<ChildArticle> findByArticleId(string $article_id) Return ChildArticle objects filtered by the article_id column
 * @method     ChildArticle[]|ObjectCollection findByLink(string $link) Return ChildArticle objects filtered by the link column
 * @psalm-method ObjectCollection&\Traversable<ChildArticle> findByLink(string $link) Return ChildArticle objects filtered by the link column
 * @method     ChildArticle[]|ObjectCollection findBySite(string $site) Return ChildArticle objects filtered by the site column
 * @psalm-method ObjectCollection&\Traversable<ChildArticle> findBySite(string $site) Return ChildArticle objects filtered by the site column
 * @method     ChildArticle[]|ObjectCollection findByTs(int $ts) Return ChildArticle objects filtered by the ts column
 * @psalm-method ObjectCollection&\Traversable<ChildArticle> findByTs(int $ts) Return ChildArticle objects filtered by the ts column
 * @method     ChildArticle[]|ObjectCollection findByTitle(string $title) Return ChildArticle objects filtered by the title column
 * @psalm-method ObjectCollection&\Traversable<ChildArticle> findByTitle(string $title) Return ChildArticle objects filtered by the title column
 * @method     ChildArticle[]|ObjectCollection findByContent(string $content) Return ChildArticle objects filtered by the content column
 * @psalm-method ObjectCollection&\Traversable<ChildArticle> findByContent(string $content) Return ChildArticle objects filtered by the content column
 * @method     ChildArticle[]|ObjectCollection findByCats(string $cats) Return ChildArticle objects filtered by the cats column
 * @psalm-method ObjectCollection&\Traversable<ChildArticle> findByCats(string $cats) Return ChildArticle objects filtered by the cats column
 * @method     ChildArticle[]|ObjectCollection findByLastTagged(int $last_tagged) Return ChildArticle objects filtered by the last_tagged column
 * @psalm-method ObjectCollection&\Traversable<ChildArticle> findByLastTagged(int $last_tagged) Return ChildArticle objects filtered by the last_tagged column
 * @method     ChildArticle[]|ObjectCollection findByType(string $type) Return ChildArticle objects filtered by the type column
 * @psalm-method ObjectCollection&\Traversable<ChildArticle> findByType(string $type) Return ChildArticle objects filtered by the type column
 * @method     ChildArticle[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildArticle> paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ArticleQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Schema\Crawl\Article\Base\ArticleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'crawl', $modelName = '\\App\\Schema\\Crawl\\Article\\Article', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildArticleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildArticleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildArticleQuery) {
            return $criteria;
        }
        $query = new ChildArticleQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildArticle|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ArticleTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ArticleTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildArticle A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, article_id, link, site, ts, title, content, cats, last_tagged, type FROM article WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildArticle $obj */
            $obj = new ChildArticle();
            $obj->hydrate($row);
            ArticleTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildArticle|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ArticleTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ArticleTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ArticleTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ArticleTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the article_id column
     *
     * Example usage:
     * <code>
     * $query->filterByArticleId('fooValue');   // WHERE article_id = 'fooValue'
     * $query->filterByArticleId('%fooValue%', Criteria::LIKE); // WHERE article_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $articleId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByArticleId($articleId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($articleId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_ARTICLE_ID, $articleId, $comparison);
    }

    /**
     * Filter the query on the link column
     *
     * Example usage:
     * <code>
     * $query->filterByLink('fooValue');   // WHERE link = 'fooValue'
     * $query->filterByLink('%fooValue%', Criteria::LIKE); // WHERE link LIKE '%fooValue%'
     * </code>
     *
     * @param     string $link The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByLink($link = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($link)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_LINK, $link, $comparison);
    }

    /**
     * Filter the query on the site column
     *
     * Example usage:
     * <code>
     * $query->filterBySite('fooValue');   // WHERE site = 'fooValue'
     * $query->filterBySite('%fooValue%', Criteria::LIKE); // WHERE site LIKE '%fooValue%'
     * </code>
     *
     * @param     string $site The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterBySite($site = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($site)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_SITE, $site, $comparison);
    }

    /**
     * Filter the query on the ts column
     *
     * Example usage:
     * <code>
     * $query->filterByTs(1234); // WHERE ts = 1234
     * $query->filterByTs(array(12, 34)); // WHERE ts IN (12, 34)
     * $query->filterByTs(array('min' => 12)); // WHERE ts > 12
     * </code>
     *
     * @param     mixed $ts The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByTs($ts = null, $comparison = null)
    {
        if (is_array($ts)) {
            $useMinMax = false;
            if (isset($ts['min'])) {
                $this->addUsingAlias(ArticleTableMap::COL_TS, $ts['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ts['max'])) {
                $this->addUsingAlias(ArticleTableMap::COL_TS, $ts['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_TS, $ts, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%', Criteria::LIKE); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the content column
     *
     * Example usage:
     * <code>
     * $query->filterByContent('fooValue');   // WHERE content = 'fooValue'
     * $query->filterByContent('%fooValue%', Criteria::LIKE); // WHERE content LIKE '%fooValue%'
     * </code>
     *
     * @param     string $content The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_CONTENT, $content, $comparison);
    }

    /**
     * Filter the query on the cats column
     *
     * Example usage:
     * <code>
     * $query->filterByCats('fooValue');   // WHERE cats = 'fooValue'
     * $query->filterByCats('%fooValue%', Criteria::LIKE); // WHERE cats LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cats The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByCats($cats = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cats)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_CATS, $cats, $comparison);
    }

    /**
     * Filter the query on the last_tagged column
     *
     * Example usage:
     * <code>
     * $query->filterByLastTagged(1234); // WHERE last_tagged = 1234
     * $query->filterByLastTagged(array(12, 34)); // WHERE last_tagged IN (12, 34)
     * $query->filterByLastTagged(array('min' => 12)); // WHERE last_tagged > 12
     * </code>
     *
     * @param     mixed $lastTagged The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByLastTagged($lastTagged = null, $comparison = null)
    {
        if (is_array($lastTagged)) {
            $useMinMax = false;
            if (isset($lastTagged['min'])) {
                $this->addUsingAlias(ArticleTableMap::COL_LAST_TAGGED, $lastTagged['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastTagged['max'])) {
                $this->addUsingAlias(ArticleTableMap::COL_LAST_TAGGED, $lastTagged['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_LAST_TAGGED, $lastTagged, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildArticle $article Object to remove from the list of results
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function prune($article = null)
    {
        if ($article) {
            $this->addUsingAlias(ArticleTableMap::COL_ID, $article->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the article table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ArticleTableMap::clearInstancePool();
            ArticleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ArticleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ArticleTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ArticleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ArticleQuery
