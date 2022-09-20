<?php

namespace App\Schema\Crawl\Tag\Base;

use \Exception;
use \PDO;
use App\Schema\Crawl\ArticleContentTags\ArticleContentTags;
use App\Schema\Crawl\ArticleTitleTags\ArticleTitleTags;
use App\Schema\Crawl\Tag\Tag as ChildTag;
use App\Schema\Crawl\Tag\TagQuery as ChildTagQuery;
use App\Schema\Crawl\Tag\Map\TagTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'tag' table.
 *
 *
 *
 * @method     ChildTagQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTagQuery orderByTerm($order = Criteria::ASC) Order by the term column
 *
 * @method     ChildTagQuery groupById() Group by the id column
 * @method     ChildTagQuery groupByTerm() Group by the term column
 *
 * @method     ChildTagQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTagQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTagQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTagQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTagQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTagQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTagQuery leftJoinContentTag($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentTag relation
 * @method     ChildTagQuery rightJoinContentTag($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentTag relation
 * @method     ChildTagQuery innerJoinContentTag($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentTag relation
 *
 * @method     ChildTagQuery joinWithContentTag($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ContentTag relation
 *
 * @method     ChildTagQuery leftJoinWithContentTag() Adds a LEFT JOIN clause and with to the query using the ContentTag relation
 * @method     ChildTagQuery rightJoinWithContentTag() Adds a RIGHT JOIN clause and with to the query using the ContentTag relation
 * @method     ChildTagQuery innerJoinWithContentTag() Adds a INNER JOIN clause and with to the query using the ContentTag relation
 *
 * @method     ChildTagQuery leftJoinTitleTag($relationAlias = null) Adds a LEFT JOIN clause to the query using the TitleTag relation
 * @method     ChildTagQuery rightJoinTitleTag($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TitleTag relation
 * @method     ChildTagQuery innerJoinTitleTag($relationAlias = null) Adds a INNER JOIN clause to the query using the TitleTag relation
 *
 * @method     ChildTagQuery joinWithTitleTag($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TitleTag relation
 *
 * @method     ChildTagQuery leftJoinWithTitleTag() Adds a LEFT JOIN clause and with to the query using the TitleTag relation
 * @method     ChildTagQuery rightJoinWithTitleTag() Adds a RIGHT JOIN clause and with to the query using the TitleTag relation
 * @method     ChildTagQuery innerJoinWithTitleTag() Adds a INNER JOIN clause and with to the query using the TitleTag relation
 *
 * @method     \App\Schema\Crawl\ArticleContentTags\ArticleContentTagsQuery|\App\Schema\Crawl\ArticleTitleTags\ArticleTitleTagsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTag|null findOne(?ConnectionInterface $con = null) Return the first ChildTag matching the query
 * @method     ChildTag findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildTag matching the query, or a new ChildTag object populated from the query conditions when no match is found
 *
 * @method     ChildTag|null findOneById(int $id) Return the first ChildTag filtered by the id column
 * @method     ChildTag|null findOneByTerm(string $term) Return the first ChildTag filtered by the term column *

 * @method     ChildTag requirePk($key, ?ConnectionInterface $con = null) Return the ChildTag by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTag requireOne(?ConnectionInterface $con = null) Return the first ChildTag matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTag requireOneById(int $id) Return the first ChildTag filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTag requireOneByTerm(string $term) Return the first ChildTag filtered by the term column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTag[]|Collection find(?ConnectionInterface $con = null) Return ChildTag objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildTag> find(?ConnectionInterface $con = null) Return ChildTag objects based on current ModelCriteria
 * @method     ChildTag[]|Collection findById(int $id) Return ChildTag objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildTag> findById(int $id) Return ChildTag objects filtered by the id column
 * @method     ChildTag[]|Collection findByTerm(string $term) Return ChildTag objects filtered by the term column
 * @psalm-method Collection&\Traversable<ChildTag> findByTerm(string $term) Return ChildTag objects filtered by the term column
 * @method     ChildTag[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildTag> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TagQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Schema\Crawl\Tag\Base\TagQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'crawl', $modelName = '\\App\\Schema\\Crawl\\Tag\\Tag', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTagQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTagQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildTagQuery) {
            return $criteria;
        }
        $query = new ChildTagQuery();
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
     * @return ChildTag|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TagTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TagTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTag A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, term FROM tag WHERE id = :p0';
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
            /** @var ChildTag $obj */
            $obj = new ChildTag();
            $obj->hydrate($row);
            TagTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTag|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(TagTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(TagTableMap::COL_ID, $keys, Criteria::IN);

        return $this;
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
     * @param mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterById($id = null, ?string $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TagTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TagTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(TagTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the term column
     *
     * Example usage:
     * <code>
     * $query->filterByTerm('fooValue');   // WHERE term = 'fooValue'
     * $query->filterByTerm('%fooValue%', Criteria::LIKE); // WHERE term LIKE '%fooValue%'
     * $query->filterByTerm(['foo', 'bar']); // WHERE term IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $term The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTerm($term = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($term)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(TagTableMap::COL_TERM, $term, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \App\Schema\Crawl\ArticleContentTags\ArticleContentTags object
     *
     * @param \App\Schema\Crawl\ArticleContentTags\ArticleContentTags|ObjectCollection $articleContentTags the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByContentTag($articleContentTags, ?string $comparison = null)
    {
        if ($articleContentTags instanceof \App\Schema\Crawl\ArticleContentTags\ArticleContentTags) {
            $this
                ->addUsingAlias(TagTableMap::COL_ID, $articleContentTags->getTagId(), $comparison);

            return $this;
        } elseif ($articleContentTags instanceof ObjectCollection) {
            $this
                ->useContentTagQuery()
                ->filterByPrimaryKeys($articleContentTags->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByContentTag() only accepts arguments of type \App\Schema\Crawl\ArticleContentTags\ArticleContentTags or Collection');
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
     * Use the ContentTag relation ArticleContentTags object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Schema\Crawl\ArticleContentTags\ArticleContentTagsQuery A secondary query class using the current class as primary query
     */
    public function useContentTagQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContentTag($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentTag', '\App\Schema\Crawl\ArticleContentTags\ArticleContentTagsQuery');
    }

    /**
     * Use the ContentTag relation ArticleContentTags object
     *
     * @param callable(\App\Schema\Crawl\ArticleContentTags\ArticleContentTagsQuery):\App\Schema\Crawl\ArticleContentTags\ArticleContentTagsQuery $callable A function working on the related query
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
     * Use the ContentTag relation to the ArticleContentTags table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \App\Schema\Crawl\ArticleContentTags\ArticleContentTagsQuery The inner query object of the EXISTS statement
     */
    public function useContentTagExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('ContentTag', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the ContentTag relation to the ArticleContentTags table for a NOT EXISTS query.
     *
     * @see useContentTagExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \App\Schema\Crawl\ArticleContentTags\ArticleContentTagsQuery The inner query object of the NOT EXISTS statement
     */
    public function useContentTagNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('ContentTag', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \App\Schema\Crawl\ArticleTitleTags\ArticleTitleTags object
     *
     * @param \App\Schema\Crawl\ArticleTitleTags\ArticleTitleTags|ObjectCollection $articleTitleTags the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTitleTag($articleTitleTags, ?string $comparison = null)
    {
        if ($articleTitleTags instanceof \App\Schema\Crawl\ArticleTitleTags\ArticleTitleTags) {
            $this
                ->addUsingAlias(TagTableMap::COL_ID, $articleTitleTags->getTagId(), $comparison);

            return $this;
        } elseif ($articleTitleTags instanceof ObjectCollection) {
            $this
                ->useTitleTagQuery()
                ->filterByPrimaryKeys($articleTitleTags->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByTitleTag() only accepts arguments of type \App\Schema\Crawl\ArticleTitleTags\ArticleTitleTags or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TitleTag relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinTitleTag(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TitleTag');

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
            $this->addJoinObject($join, 'TitleTag');
        }

        return $this;
    }

    /**
     * Use the TitleTag relation ArticleTitleTags object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Schema\Crawl\ArticleTitleTags\ArticleTitleTagsQuery A secondary query class using the current class as primary query
     */
    public function useTitleTagQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTitleTag($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TitleTag', '\App\Schema\Crawl\ArticleTitleTags\ArticleTitleTagsQuery');
    }

    /**
     * Use the TitleTag relation ArticleTitleTags object
     *
     * @param callable(\App\Schema\Crawl\ArticleTitleTags\ArticleTitleTagsQuery):\App\Schema\Crawl\ArticleTitleTags\ArticleTitleTagsQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withTitleTagQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useTitleTagQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the TitleTag relation to the ArticleTitleTags table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \App\Schema\Crawl\ArticleTitleTags\ArticleTitleTagsQuery The inner query object of the EXISTS statement
     */
    public function useTitleTagExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('TitleTag', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the TitleTag relation to the ArticleTitleTags table for a NOT EXISTS query.
     *
     * @see useTitleTagExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \App\Schema\Crawl\ArticleTitleTags\ArticleTitleTagsQuery The inner query object of the NOT EXISTS statement
     */
    public function useTitleTagNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('TitleTag', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related Article object
     * using the article_tags table as cross reference
     *
     * @param Article $article the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByContentArticle($article, string $comparison = Criteria::EQUAL)
    {
        $this
            ->useContentTagQuery()
            ->filterByContentArticle($article, $comparison)
            ->endUse();

        return $this;
    }

    /**
     * Filter the query by a related Article object
     * using the article_title_tags table as cross reference
     *
     * @param Article $article the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTitleArticle($article, string $comparison = Criteria::EQUAL)
    {
        $this
            ->useTitleTagQuery()
            ->filterByTitleArticle($article, $comparison)
            ->endUse();

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param ChildTag $tag Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($tag = null)
    {
        if ($tag) {
            $this->addUsingAlias(TagTableMap::COL_ID, $tag->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the tag table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TagTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TagTableMap::clearInstancePool();
            TagTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TagTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TagTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TagTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TagTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
