<?php

namespace App\Schema\Crawl\ArticleContentTags\Base;

use \Exception;
use \PDO;
use App\Schema\Crawl\Article\Article;
use App\Schema\Crawl\ArticleContentTags\ArticleContentTags as ChildArticleContentTags;
use App\Schema\Crawl\ArticleContentTags\ArticleContentTagsQuery as ChildArticleContentTagsQuery;
use App\Schema\Crawl\ArticleContentTags\Map\ArticleContentTagsTableMap;
use App\Schema\Crawl\Tag\Tag;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `article_tags` table.
 *
 * @method     ChildArticleContentTagsQuery orderByArticleId($order = Criteria::ASC) Order by the article_id column
 * @method     ChildArticleContentTagsQuery orderByTagId($order = Criteria::ASC) Order by the tag_id column
 *
 * @method     ChildArticleContentTagsQuery groupByArticleId() Group by the article_id column
 * @method     ChildArticleContentTagsQuery groupByTagId() Group by the tag_id column
 *
 * @method     ChildArticleContentTagsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildArticleContentTagsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildArticleContentTagsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildArticleContentTagsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildArticleContentTagsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildArticleContentTagsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildArticleContentTagsQuery leftJoinContentArticle($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentArticle relation
 * @method     ChildArticleContentTagsQuery rightJoinContentArticle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentArticle relation
 * @method     ChildArticleContentTagsQuery innerJoinContentArticle($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentArticle relation
 *
 * @method     ChildArticleContentTagsQuery joinWithContentArticle($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ContentArticle relation
 *
 * @method     ChildArticleContentTagsQuery leftJoinWithContentArticle() Adds a LEFT JOIN clause and with to the query using the ContentArticle relation
 * @method     ChildArticleContentTagsQuery rightJoinWithContentArticle() Adds a RIGHT JOIN clause and with to the query using the ContentArticle relation
 * @method     ChildArticleContentTagsQuery innerJoinWithContentArticle() Adds a INNER JOIN clause and with to the query using the ContentArticle relation
 *
 * @method     ChildArticleContentTagsQuery leftJoinContentTag($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentTag relation
 * @method     ChildArticleContentTagsQuery rightJoinContentTag($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentTag relation
 * @method     ChildArticleContentTagsQuery innerJoinContentTag($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentTag relation
 *
 * @method     ChildArticleContentTagsQuery joinWithContentTag($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ContentTag relation
 *
 * @method     ChildArticleContentTagsQuery leftJoinWithContentTag() Adds a LEFT JOIN clause and with to the query using the ContentTag relation
 * @method     ChildArticleContentTagsQuery rightJoinWithContentTag() Adds a RIGHT JOIN clause and with to the query using the ContentTag relation
 * @method     ChildArticleContentTagsQuery innerJoinWithContentTag() Adds a INNER JOIN clause and with to the query using the ContentTag relation
 *
 * @method     \App\Schema\Crawl\Article\ArticleQuery|\App\Schema\Crawl\Tag\TagQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildArticleContentTags|null findOne(?ConnectionInterface $con = null) Return the first ChildArticleContentTags matching the query
 * @method     ChildArticleContentTags findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildArticleContentTags matching the query, or a new ChildArticleContentTags object populated from the query conditions when no match is found
 *
 * @method     ChildArticleContentTags|null findOneByArticleId(int $article_id) Return the first ChildArticleContentTags filtered by the article_id column
 * @method     ChildArticleContentTags|null findOneByTagId(int $tag_id) Return the first ChildArticleContentTags filtered by the tag_id column
 *
 * @method     ChildArticleContentTags requirePk($key, ?ConnectionInterface $con = null) Return the ChildArticleContentTags by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticleContentTags requireOne(?ConnectionInterface $con = null) Return the first ChildArticleContentTags matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildArticleContentTags requireOneByArticleId(int $article_id) Return the first ChildArticleContentTags filtered by the article_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticleContentTags requireOneByTagId(int $tag_id) Return the first ChildArticleContentTags filtered by the tag_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildArticleContentTags[]|Collection find(?ConnectionInterface $con = null) Return ChildArticleContentTags objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildArticleContentTags> find(?ConnectionInterface $con = null) Return ChildArticleContentTags objects based on current ModelCriteria
 *
 * @method     ChildArticleContentTags[]|Collection findByArticleId(int|array<int> $article_id) Return ChildArticleContentTags objects filtered by the article_id column
 * @psalm-method Collection&\Traversable<ChildArticleContentTags> findByArticleId(int|array<int> $article_id) Return ChildArticleContentTags objects filtered by the article_id column
 * @method     ChildArticleContentTags[]|Collection findByTagId(int|array<int> $tag_id) Return ChildArticleContentTags objects filtered by the tag_id column
 * @psalm-method Collection&\Traversable<ChildArticleContentTags> findByTagId(int|array<int> $tag_id) Return ChildArticleContentTags objects filtered by the tag_id column
 *
 * @method     ChildArticleContentTags[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildArticleContentTags> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class ArticleContentTagsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Schema\Crawl\ArticleContentTags\Base\ArticleContentTagsQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'crawl', $modelName = '\\App\\Schema\\Crawl\\ArticleContentTags\\ArticleContentTags', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildArticleContentTagsQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildArticleContentTagsQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildArticleContentTagsQuery) {
            return $criteria;
        }
        $query = new ChildArticleContentTagsQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$article_id, $tag_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildArticleContentTags|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ArticleContentTagsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ArticleContentTagsTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildArticleContentTags A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT article_id, tag_id FROM article_tags WHERE article_id = :p0 AND tag_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildArticleContentTags $obj */
            $obj = new ChildArticleContentTags();
            $obj->hydrate($row);
            ArticleContentTagsTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @return ChildArticleContentTags|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param array $keys Primary keys to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return Collection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ?ConnectionInterface $con = null)
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
     * @param mixed $key Primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ArticleContentTagsTableMap::COL_ARTICLE_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ArticleContentTagsTableMap::COL_TAG_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array|int $keys The list of primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            $this->add(null, '1<>1', Criteria::CUSTOM);

            return $this;
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ArticleContentTagsTableMap::COL_ARTICLE_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ArticleContentTagsTableMap::COL_TAG_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the article_id column
     *
     * Example usage:
     * <code>
     * $query->filterByArticleId(1234); // WHERE article_id = 1234
     * $query->filterByArticleId(array(12, 34)); // WHERE article_id IN (12, 34)
     * $query->filterByArticleId(array('min' => 12)); // WHERE article_id > 12
     * </code>
     *
     * @see       filterByContentArticle()
     *
     * @param mixed $articleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByArticleId($articleId = null, ?string $comparison = null)
    {
        if (is_array($articleId)) {
            $useMinMax = false;
            if (isset($articleId['min'])) {
                $this->addUsingAlias(ArticleContentTagsTableMap::COL_ARTICLE_ID, $articleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($articleId['max'])) {
                $this->addUsingAlias(ArticleContentTagsTableMap::COL_ARTICLE_ID, $articleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ArticleContentTagsTableMap::COL_ARTICLE_ID, $articleId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the tag_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTagId(1234); // WHERE tag_id = 1234
     * $query->filterByTagId(array(12, 34)); // WHERE tag_id IN (12, 34)
     * $query->filterByTagId(array('min' => 12)); // WHERE tag_id > 12
     * </code>
     *
     * @see       filterByContentTag()
     *
     * @param mixed $tagId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTagId($tagId = null, ?string $comparison = null)
    {
        if (is_array($tagId)) {
            $useMinMax = false;
            if (isset($tagId['min'])) {
                $this->addUsingAlias(ArticleContentTagsTableMap::COL_TAG_ID, $tagId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tagId['max'])) {
                $this->addUsingAlias(ArticleContentTagsTableMap::COL_TAG_ID, $tagId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ArticleContentTagsTableMap::COL_TAG_ID, $tagId, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \App\Schema\Crawl\Article\Article object
     *
     * @param \App\Schema\Crawl\Article\Article|ObjectCollection $article The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByContentArticle($article, ?string $comparison = null)
    {
        if ($article instanceof \App\Schema\Crawl\Article\Article) {
            return $this
                ->addUsingAlias(ArticleContentTagsTableMap::COL_ARTICLE_ID, $article->getId(), $comparison);
        } elseif ($article instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(ArticleContentTagsTableMap::COL_ARTICLE_ID, $article->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByContentArticle() only accepts arguments of type \App\Schema\Crawl\Article\Article or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContentArticle relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinContentArticle(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContentArticle');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ContentArticle');
        }

        return $this;
    }

    /**
     * Use the ContentArticle relation Article object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Schema\Crawl\Article\ArticleQuery A secondary query class using the current class as primary query
     */
    public function useContentArticleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContentArticle($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentArticle', '\App\Schema\Crawl\Article\ArticleQuery');
    }

    /**
     * Use the ContentArticle relation Article object
     *
     * @param callable(\App\Schema\Crawl\Article\ArticleQuery):\App\Schema\Crawl\Article\ArticleQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withContentArticleQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useContentArticleQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the ContentArticle relation to the Article table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \App\Schema\Crawl\Article\ArticleQuery The inner query object of the EXISTS statement
     */
    public function useContentArticleExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \App\Schema\Crawl\Article\ArticleQuery */
        $q = $this->useExistsQuery('ContentArticle', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the ContentArticle relation to the Article table for a NOT EXISTS query.
     *
     * @see useContentArticleExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \App\Schema\Crawl\Article\ArticleQuery The inner query object of the NOT EXISTS statement
     */
    public function useContentArticleNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \App\Schema\Crawl\Article\ArticleQuery */
        $q = $this->useExistsQuery('ContentArticle', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the ContentArticle relation to the Article table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \App\Schema\Crawl\Article\ArticleQuery The inner query object of the IN statement
     */
    public function useInContentArticleQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \App\Schema\Crawl\Article\ArticleQuery */
        $q = $this->useInQuery('ContentArticle', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the ContentArticle relation to the Article table for a NOT IN query.
     *
     * @see useContentArticleInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \App\Schema\Crawl\Article\ArticleQuery The inner query object of the NOT IN statement
     */
    public function useNotInContentArticleQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \App\Schema\Crawl\Article\ArticleQuery */
        $q = $this->useInQuery('ContentArticle', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \App\Schema\Crawl\Tag\Tag object
     *
     * @param \App\Schema\Crawl\Tag\Tag|ObjectCollection $tag The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByContentTag($tag, ?string $comparison = null)
    {
        if ($tag instanceof \App\Schema\Crawl\Tag\Tag) {
            return $this
                ->addUsingAlias(ArticleContentTagsTableMap::COL_TAG_ID, $tag->getId(), $comparison);
        } elseif ($tag instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(ArticleContentTagsTableMap::COL_TAG_ID, $tag->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByContentTag() only accepts arguments of type \App\Schema\Crawl\Tag\Tag or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContentTag relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinContentTag(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContentTag');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ContentTag');
        }

        return $this;
    }

    /**
     * Use the ContentTag relation Tag object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Schema\Crawl\Tag\TagQuery A secondary query class using the current class as primary query
     */
    public function useContentTagQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContentTag($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentTag', '\App\Schema\Crawl\Tag\TagQuery');
    }

    /**
     * Use the ContentTag relation Tag object
     *
     * @param callable(\App\Schema\Crawl\Tag\TagQuery):\App\Schema\Crawl\Tag\TagQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withContentTagQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useContentTagQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the ContentTag relation to the Tag table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \App\Schema\Crawl\Tag\TagQuery The inner query object of the EXISTS statement
     */
    public function useContentTagExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \App\Schema\Crawl\Tag\TagQuery */
        $q = $this->useExistsQuery('ContentTag', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the ContentTag relation to the Tag table for a NOT EXISTS query.
     *
     * @see useContentTagExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \App\Schema\Crawl\Tag\TagQuery The inner query object of the NOT EXISTS statement
     */
    public function useContentTagNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \App\Schema\Crawl\Tag\TagQuery */
        $q = $this->useExistsQuery('ContentTag', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the ContentTag relation to the Tag table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \App\Schema\Crawl\Tag\TagQuery The inner query object of the IN statement
     */
    public function useInContentTagQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \App\Schema\Crawl\Tag\TagQuery */
        $q = $this->useInQuery('ContentTag', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the ContentTag relation to the Tag table for a NOT IN query.
     *
     * @see useContentTagInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \App\Schema\Crawl\Tag\TagQuery The inner query object of the NOT IN statement
     */
    public function useNotInContentTagQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \App\Schema\Crawl\Tag\TagQuery */
        $q = $this->useInQuery('ContentTag', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildArticleContentTags $articleContentTags Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($articleContentTags = null)
    {
        if ($articleContentTags) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ArticleContentTagsTableMap::COL_ARTICLE_ID), $articleContentTags->getArticleId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ArticleContentTagsTableMap::COL_TAG_ID), $articleContentTags->getTagId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the article_tags table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleContentTagsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ArticleContentTagsTableMap::clearInstancePool();
            ArticleContentTagsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleContentTagsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ArticleContentTagsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ArticleContentTagsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ArticleContentTagsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
