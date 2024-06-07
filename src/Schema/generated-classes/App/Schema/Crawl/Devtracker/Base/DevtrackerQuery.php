<?php

namespace App\Schema\Crawl\Devtracker\Base;

use \Exception;
use \PDO;
use App\Schema\Crawl\Devtracker\Devtracker as ChildDevtracker;
use App\Schema\Crawl\Devtracker\DevtrackerQuery as ChildDevtrackerQuery;
use App\Schema\Crawl\Devtracker\Map\DevtrackerTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `devtracker` table.
 *
 * @method     ChildDevtrackerQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildDevtrackerQuery orderByDevName($order = Criteria::ASC) Order by the dev_name column
 * @method     ChildDevtrackerQuery orderByDevId($order = Criteria::ASC) Order by the dev_id column
 * @method     ChildDevtrackerQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method     ChildDevtrackerQuery orderByDiscussionId($order = Criteria::ASC) Order by the discussion_id column
 * @method     ChildDevtrackerQuery orderByDiscussionName($order = Criteria::ASC) Order by the discussion_name column
 * @method     ChildDevtrackerQuery orderByCommentId($order = Criteria::ASC) Order by the comment_id column
 * @method     ChildDevtrackerQuery orderByBody($order = Criteria::ASC) Order by the body column
 * @method     ChildDevtrackerQuery orderByDate($order = Criteria::ASC) Order by the date column
 * @method     ChildDevtrackerQuery orderByIsPoll($order = Criteria::ASC) Order by the is_poll column
 * @method     ChildDevtrackerQuery orderByIsAnnounce($order = Criteria::ASC) Order by the is_announce column
 * @method     ChildDevtrackerQuery orderByIsClosed($order = Criteria::ASC) Order by the is_closed column
 *
 * @method     ChildDevtrackerQuery groupById() Group by the ID column
 * @method     ChildDevtrackerQuery groupByDevName() Group by the dev_name column
 * @method     ChildDevtrackerQuery groupByDevId() Group by the dev_id column
 * @method     ChildDevtrackerQuery groupByCategoryId() Group by the category_id column
 * @method     ChildDevtrackerQuery groupByDiscussionId() Group by the discussion_id column
 * @method     ChildDevtrackerQuery groupByDiscussionName() Group by the discussion_name column
 * @method     ChildDevtrackerQuery groupByCommentId() Group by the comment_id column
 * @method     ChildDevtrackerQuery groupByBody() Group by the body column
 * @method     ChildDevtrackerQuery groupByDate() Group by the date column
 * @method     ChildDevtrackerQuery groupByIsPoll() Group by the is_poll column
 * @method     ChildDevtrackerQuery groupByIsAnnounce() Group by the is_announce column
 * @method     ChildDevtrackerQuery groupByIsClosed() Group by the is_closed column
 *
 * @method     ChildDevtrackerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDevtrackerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDevtrackerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDevtrackerQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDevtrackerQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDevtrackerQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDevtracker|null findOne(?ConnectionInterface $con = null) Return the first ChildDevtracker matching the query
 * @method     ChildDevtracker findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildDevtracker matching the query, or a new ChildDevtracker object populated from the query conditions when no match is found
 *
 * @method     ChildDevtracker|null findOneById(int $ID) Return the first ChildDevtracker filtered by the ID column
 * @method     ChildDevtracker|null findOneByDevName(string $dev_name) Return the first ChildDevtracker filtered by the dev_name column
 * @method     ChildDevtracker|null findOneByDevId(int $dev_id) Return the first ChildDevtracker filtered by the dev_id column
 * @method     ChildDevtracker|null findOneByCategoryId(int $category_id) Return the first ChildDevtracker filtered by the category_id column
 * @method     ChildDevtracker|null findOneByDiscussionId(string $discussion_id) Return the first ChildDevtracker filtered by the discussion_id column
 * @method     ChildDevtracker|null findOneByDiscussionName(string $discussion_name) Return the first ChildDevtracker filtered by the discussion_name column
 * @method     ChildDevtracker|null findOneByCommentId(string $comment_id) Return the first ChildDevtracker filtered by the comment_id column
 * @method     ChildDevtracker|null findOneByBody(string $body) Return the first ChildDevtracker filtered by the body column
 * @method     ChildDevtracker|null findOneByDate(string $date) Return the first ChildDevtracker filtered by the date column
 * @method     ChildDevtracker|null findOneByIsPoll(boolean $is_poll) Return the first ChildDevtracker filtered by the is_poll column
 * @method     ChildDevtracker|null findOneByIsAnnounce(boolean $is_announce) Return the first ChildDevtracker filtered by the is_announce column
 * @method     ChildDevtracker|null findOneByIsClosed(boolean $is_closed) Return the first ChildDevtracker filtered by the is_closed column
 *
 * @method     ChildDevtracker requirePk($key, ?ConnectionInterface $con = null) Return the ChildDevtracker by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevtracker requireOne(?ConnectionInterface $con = null) Return the first ChildDevtracker matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDevtracker requireOneById(int $ID) Return the first ChildDevtracker filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevtracker requireOneByDevName(string $dev_name) Return the first ChildDevtracker filtered by the dev_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevtracker requireOneByDevId(int $dev_id) Return the first ChildDevtracker filtered by the dev_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevtracker requireOneByCategoryId(int $category_id) Return the first ChildDevtracker filtered by the category_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevtracker requireOneByDiscussionId(string $discussion_id) Return the first ChildDevtracker filtered by the discussion_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevtracker requireOneByDiscussionName(string $discussion_name) Return the first ChildDevtracker filtered by the discussion_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevtracker requireOneByCommentId(string $comment_id) Return the first ChildDevtracker filtered by the comment_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevtracker requireOneByBody(string $body) Return the first ChildDevtracker filtered by the body column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevtracker requireOneByDate(string $date) Return the first ChildDevtracker filtered by the date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevtracker requireOneByIsPoll(boolean $is_poll) Return the first ChildDevtracker filtered by the is_poll column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevtracker requireOneByIsAnnounce(boolean $is_announce) Return the first ChildDevtracker filtered by the is_announce column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDevtracker requireOneByIsClosed(boolean $is_closed) Return the first ChildDevtracker filtered by the is_closed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDevtracker[]|Collection find(?ConnectionInterface $con = null) Return ChildDevtracker objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildDevtracker> find(?ConnectionInterface $con = null) Return ChildDevtracker objects based on current ModelCriteria
 *
 * @method     ChildDevtracker[]|Collection findById(int|array<int> $ID) Return ChildDevtracker objects filtered by the ID column
 * @psalm-method Collection&\Traversable<ChildDevtracker> findById(int|array<int> $ID) Return ChildDevtracker objects filtered by the ID column
 * @method     ChildDevtracker[]|Collection findByDevName(string|array<string> $dev_name) Return ChildDevtracker objects filtered by the dev_name column
 * @psalm-method Collection&\Traversable<ChildDevtracker> findByDevName(string|array<string> $dev_name) Return ChildDevtracker objects filtered by the dev_name column
 * @method     ChildDevtracker[]|Collection findByDevId(int|array<int> $dev_id) Return ChildDevtracker objects filtered by the dev_id column
 * @psalm-method Collection&\Traversable<ChildDevtracker> findByDevId(int|array<int> $dev_id) Return ChildDevtracker objects filtered by the dev_id column
 * @method     ChildDevtracker[]|Collection findByCategoryId(int|array<int> $category_id) Return ChildDevtracker objects filtered by the category_id column
 * @psalm-method Collection&\Traversable<ChildDevtracker> findByCategoryId(int|array<int> $category_id) Return ChildDevtracker objects filtered by the category_id column
 * @method     ChildDevtracker[]|Collection findByDiscussionId(string|array<string> $discussion_id) Return ChildDevtracker objects filtered by the discussion_id column
 * @psalm-method Collection&\Traversable<ChildDevtracker> findByDiscussionId(string|array<string> $discussion_id) Return ChildDevtracker objects filtered by the discussion_id column
 * @method     ChildDevtracker[]|Collection findByDiscussionName(string|array<string> $discussion_name) Return ChildDevtracker objects filtered by the discussion_name column
 * @psalm-method Collection&\Traversable<ChildDevtracker> findByDiscussionName(string|array<string> $discussion_name) Return ChildDevtracker objects filtered by the discussion_name column
 * @method     ChildDevtracker[]|Collection findByCommentId(string|array<string> $comment_id) Return ChildDevtracker objects filtered by the comment_id column
 * @psalm-method Collection&\Traversable<ChildDevtracker> findByCommentId(string|array<string> $comment_id) Return ChildDevtracker objects filtered by the comment_id column
 * @method     ChildDevtracker[]|Collection findByBody(string|array<string> $body) Return ChildDevtracker objects filtered by the body column
 * @psalm-method Collection&\Traversable<ChildDevtracker> findByBody(string|array<string> $body) Return ChildDevtracker objects filtered by the body column
 * @method     ChildDevtracker[]|Collection findByDate(string|array<string> $date) Return ChildDevtracker objects filtered by the date column
 * @psalm-method Collection&\Traversable<ChildDevtracker> findByDate(string|array<string> $date) Return ChildDevtracker objects filtered by the date column
 * @method     ChildDevtracker[]|Collection findByIsPoll(boolean|array<boolean> $is_poll) Return ChildDevtracker objects filtered by the is_poll column
 * @psalm-method Collection&\Traversable<ChildDevtracker> findByIsPoll(boolean|array<boolean> $is_poll) Return ChildDevtracker objects filtered by the is_poll column
 * @method     ChildDevtracker[]|Collection findByIsAnnounce(boolean|array<boolean> $is_announce) Return ChildDevtracker objects filtered by the is_announce column
 * @psalm-method Collection&\Traversable<ChildDevtracker> findByIsAnnounce(boolean|array<boolean> $is_announce) Return ChildDevtracker objects filtered by the is_announce column
 * @method     ChildDevtracker[]|Collection findByIsClosed(boolean|array<boolean> $is_closed) Return ChildDevtracker objects filtered by the is_closed column
 * @psalm-method Collection&\Traversable<ChildDevtracker> findByIsClosed(boolean|array<boolean> $is_closed) Return ChildDevtracker objects filtered by the is_closed column
 *
 * @method     ChildDevtracker[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildDevtracker> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class DevtrackerQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Schema\Crawl\Devtracker\Base\DevtrackerQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'crawl', $modelName = '\\App\\Schema\\Crawl\\Devtracker\\Devtracker', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDevtrackerQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDevtrackerQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildDevtrackerQuery) {
            return $criteria;
        }
        $query = new ChildDevtrackerQuery();
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
     * @return ChildDevtracker|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DevtrackerTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DevtrackerTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDevtracker A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, dev_name, dev_id, category_id, discussion_id, discussion_name, comment_id, body, date, is_poll, is_announce, is_closed FROM devtracker WHERE ID = :p0';
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
            /** @var ChildDevtracker $obj */
            $obj = new ChildDevtracker();
            $obj->hydrate($row);
            DevtrackerTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDevtracker|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(DevtrackerTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(DevtrackerTableMap::COL_ID, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE ID = 1234
     * $query->filterById(array(12, 34)); // WHERE ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE ID > 12
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
                $this->addUsingAlias(DevtrackerTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DevtrackerTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DevtrackerTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the dev_name column
     *
     * Example usage:
     * <code>
     * $query->filterByDevName('fooValue');   // WHERE dev_name = 'fooValue'
     * $query->filterByDevName('%fooValue%', Criteria::LIKE); // WHERE dev_name LIKE '%fooValue%'
     * $query->filterByDevName(['foo', 'bar']); // WHERE dev_name IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $devName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByDevName($devName = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($devName)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DevtrackerTableMap::COL_DEV_NAME, $devName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the dev_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDevId(1234); // WHERE dev_id = 1234
     * $query->filterByDevId(array(12, 34)); // WHERE dev_id IN (12, 34)
     * $query->filterByDevId(array('min' => 12)); // WHERE dev_id > 12
     * </code>
     *
     * @param mixed $devId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByDevId($devId = null, ?string $comparison = null)
    {
        if (is_array($devId)) {
            $useMinMax = false;
            if (isset($devId['min'])) {
                $this->addUsingAlias(DevtrackerTableMap::COL_DEV_ID, $devId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($devId['max'])) {
                $this->addUsingAlias(DevtrackerTableMap::COL_DEV_ID, $devId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DevtrackerTableMap::COL_DEV_ID, $devId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId(1234); // WHERE category_id = 1234
     * $query->filterByCategoryId(array(12, 34)); // WHERE category_id IN (12, 34)
     * $query->filterByCategoryId(array('min' => 12)); // WHERE category_id > 12
     * </code>
     *
     * @param mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, ?string $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(DevtrackerTableMap::COL_CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(DevtrackerTableMap::COL_CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DevtrackerTableMap::COL_CATEGORY_ID, $categoryId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the discussion_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscussionId('fooValue');   // WHERE discussion_id = 'fooValue'
     * $query->filterByDiscussionId('%fooValue%', Criteria::LIKE); // WHERE discussion_id LIKE '%fooValue%'
     * $query->filterByDiscussionId(['foo', 'bar']); // WHERE discussion_id IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $discussionId The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByDiscussionId($discussionId = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($discussionId)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DevtrackerTableMap::COL_DISCUSSION_ID, $discussionId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the discussion_name column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscussionName('fooValue');   // WHERE discussion_name = 'fooValue'
     * $query->filterByDiscussionName('%fooValue%', Criteria::LIKE); // WHERE discussion_name LIKE '%fooValue%'
     * $query->filterByDiscussionName(['foo', 'bar']); // WHERE discussion_name IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $discussionName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByDiscussionName($discussionName = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($discussionName)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DevtrackerTableMap::COL_DISCUSSION_NAME, $discussionName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the comment_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCommentId('fooValue');   // WHERE comment_id = 'fooValue'
     * $query->filterByCommentId('%fooValue%', Criteria::LIKE); // WHERE comment_id LIKE '%fooValue%'
     * $query->filterByCommentId(['foo', 'bar']); // WHERE comment_id IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $commentId The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCommentId($commentId = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($commentId)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DevtrackerTableMap::COL_COMMENT_ID, $commentId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the body column
     *
     * Example usage:
     * <code>
     * $query->filterByBody('fooValue');   // WHERE body = 'fooValue'
     * $query->filterByBody('%fooValue%', Criteria::LIKE); // WHERE body LIKE '%fooValue%'
     * $query->filterByBody(['foo', 'bar']); // WHERE body IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $body The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByBody($body = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($body)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DevtrackerTableMap::COL_BODY, $body, $comparison);

        return $this;
    }

    /**
     * Filter the query on the date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate('2011-03-14'); // WHERE date = '2011-03-14'
     * $query->filterByDate('now'); // WHERE date = '2011-03-14'
     * $query->filterByDate(array('max' => 'yesterday')); // WHERE date > '2011-03-13'
     * </code>
     *
     * @param mixed $date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByDate($date = null, ?string $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(DevtrackerTableMap::COL_DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(DevtrackerTableMap::COL_DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(DevtrackerTableMap::COL_DATE, $date, $comparison);

        return $this;
    }

    /**
     * Filter the query on the is_poll column
     *
     * Example usage:
     * <code>
     * $query->filterByIsPoll(true); // WHERE is_poll = true
     * $query->filterByIsPoll('yes'); // WHERE is_poll = true
     * </code>
     *
     * @param bool|string $isPoll The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByIsPoll($isPoll = null, ?string $comparison = null)
    {
        if (is_string($isPoll)) {
            $isPoll = in_array(strtolower($isPoll), array('false', 'off', '-', 'no', 'n', '0', ''), true) ? false : true;
        }

        $this->addUsingAlias(DevtrackerTableMap::COL_IS_POLL, $isPoll, $comparison);

        return $this;
    }

    /**
     * Filter the query on the is_announce column
     *
     * Example usage:
     * <code>
     * $query->filterByIsAnnounce(true); // WHERE is_announce = true
     * $query->filterByIsAnnounce('yes'); // WHERE is_announce = true
     * </code>
     *
     * @param bool|string $isAnnounce The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByIsAnnounce($isAnnounce = null, ?string $comparison = null)
    {
        if (is_string($isAnnounce)) {
            $isAnnounce = in_array(strtolower($isAnnounce), array('false', 'off', '-', 'no', 'n', '0', ''), true) ? false : true;
        }

        $this->addUsingAlias(DevtrackerTableMap::COL_IS_ANNOUNCE, $isAnnounce, $comparison);

        return $this;
    }

    /**
     * Filter the query on the is_closed column
     *
     * Example usage:
     * <code>
     * $query->filterByIsClosed(true); // WHERE is_closed = true
     * $query->filterByIsClosed('yes'); // WHERE is_closed = true
     * </code>
     *
     * @param bool|string $isClosed The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByIsClosed($isClosed = null, ?string $comparison = null)
    {
        if (is_string($isClosed)) {
            $isClosed = in_array(strtolower($isClosed), array('false', 'off', '-', 'no', 'n', '0', ''), true) ? false : true;
        }

        $this->addUsingAlias(DevtrackerTableMap::COL_IS_CLOSED, $isClosed, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param ChildDevtracker $devtracker Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($devtracker = null)
    {
        if ($devtracker) {
            $this->addUsingAlias(DevtrackerTableMap::COL_ID, $devtracker->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the devtracker table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DevtrackerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DevtrackerTableMap::clearInstancePool();
            DevtrackerTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DevtrackerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DevtrackerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DevtrackerTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DevtrackerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
