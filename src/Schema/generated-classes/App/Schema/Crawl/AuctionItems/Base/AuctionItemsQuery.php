<?php

namespace App\Schema\Crawl\AuctionItems\Base;

use \Exception;
use \PDO;
use App\Schema\Crawl\AuctionAggregates\AuctionAggregates;
use App\Schema\Crawl\AuctionDetails\AuctionDetails;
use App\Schema\Crawl\AuctionItems\AuctionItems as ChildAuctionItems;
use App\Schema\Crawl\AuctionItems\AuctionItemsQuery as ChildAuctionItemsQuery;
use App\Schema\Crawl\AuctionItems\Map\AuctionItemsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'auction_items' table.
 *
 *
 *
 * @method     ChildAuctionItemsQuery orderByItemDef($order = Criteria::ASC) Order by the item_def column
 * @method     ChildAuctionItemsQuery orderByItemName($order = Criteria::ASC) Order by the item_name column
 * @method     ChildAuctionItemsQuery orderByQuality($order = Criteria::ASC) Order by the quality column
 * @method     ChildAuctionItemsQuery orderByCategories($order = Criteria::ASC) Order by the categories column
 * @method     ChildAuctionItemsQuery orderByCrawlCategory($order = Criteria::ASC) Order by the crawl_category column
 * @method     ChildAuctionItemsQuery orderByAllowAuto($order = Criteria::ASC) Order by the allow_auto column
 * @method     ChildAuctionItemsQuery orderByServer($order = Criteria::ASC) Order by the server column
 * @method     ChildAuctionItemsQuery orderByUpdateDate($order = Criteria::ASC) Order by the update_date column
 *
 * @method     ChildAuctionItemsQuery groupByItemDef() Group by the item_def column
 * @method     ChildAuctionItemsQuery groupByItemName() Group by the item_name column
 * @method     ChildAuctionItemsQuery groupByQuality() Group by the quality column
 * @method     ChildAuctionItemsQuery groupByCategories() Group by the categories column
 * @method     ChildAuctionItemsQuery groupByCrawlCategory() Group by the crawl_category column
 * @method     ChildAuctionItemsQuery groupByAllowAuto() Group by the allow_auto column
 * @method     ChildAuctionItemsQuery groupByServer() Group by the server column
 * @method     ChildAuctionItemsQuery groupByUpdateDate() Group by the update_date column
 *
 * @method     ChildAuctionItemsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAuctionItemsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAuctionItemsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAuctionItemsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAuctionItemsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAuctionItemsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAuctionItemsQuery leftJoinAuctionAggregates($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuctionAggregates relation
 * @method     ChildAuctionItemsQuery rightJoinAuctionAggregates($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuctionAggregates relation
 * @method     ChildAuctionItemsQuery innerJoinAuctionAggregates($relationAlias = null) Adds a INNER JOIN clause to the query using the AuctionAggregates relation
 *
 * @method     ChildAuctionItemsQuery joinWithAuctionAggregates($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AuctionAggregates relation
 *
 * @method     ChildAuctionItemsQuery leftJoinWithAuctionAggregates() Adds a LEFT JOIN clause and with to the query using the AuctionAggregates relation
 * @method     ChildAuctionItemsQuery rightJoinWithAuctionAggregates() Adds a RIGHT JOIN clause and with to the query using the AuctionAggregates relation
 * @method     ChildAuctionItemsQuery innerJoinWithAuctionAggregates() Adds a INNER JOIN clause and with to the query using the AuctionAggregates relation
 *
 * @method     ChildAuctionItemsQuery leftJoinAuctionDetails($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuctionDetails relation
 * @method     ChildAuctionItemsQuery rightJoinAuctionDetails($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuctionDetails relation
 * @method     ChildAuctionItemsQuery innerJoinAuctionDetails($relationAlias = null) Adds a INNER JOIN clause to the query using the AuctionDetails relation
 *
 * @method     ChildAuctionItemsQuery joinWithAuctionDetails($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AuctionDetails relation
 *
 * @method     ChildAuctionItemsQuery leftJoinWithAuctionDetails() Adds a LEFT JOIN clause and with to the query using the AuctionDetails relation
 * @method     ChildAuctionItemsQuery rightJoinWithAuctionDetails() Adds a RIGHT JOIN clause and with to the query using the AuctionDetails relation
 * @method     ChildAuctionItemsQuery innerJoinWithAuctionDetails() Adds a INNER JOIN clause and with to the query using the AuctionDetails relation
 *
 * @method     \App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery|\App\Schema\Crawl\AuctionDetails\AuctionDetailsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAuctionItems|null findOne(ConnectionInterface $con = null) Return the first ChildAuctionItems matching the query
 * @method     ChildAuctionItems findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAuctionItems matching the query, or a new ChildAuctionItems object populated from the query conditions when no match is found
 *
 * @method     ChildAuctionItems|null findOneByItemDef(string $item_def) Return the first ChildAuctionItems filtered by the item_def column
 * @method     ChildAuctionItems|null findOneByItemName(string $item_name) Return the first ChildAuctionItems filtered by the item_name column
 * @method     ChildAuctionItems|null findOneByQuality(string $quality) Return the first ChildAuctionItems filtered by the quality column
 * @method     ChildAuctionItems|null findOneByCategories(string $categories) Return the first ChildAuctionItems filtered by the categories column
 * @method     ChildAuctionItems|null findOneByCrawlCategory(string $crawl_category) Return the first ChildAuctionItems filtered by the crawl_category column
 * @method     ChildAuctionItems|null findOneByAllowAuto(boolean $allow_auto) Return the first ChildAuctionItems filtered by the allow_auto column
 * @method     ChildAuctionItems|null findOneByServer(string $server) Return the first ChildAuctionItems filtered by the server column
 * @method     ChildAuctionItems|null findOneByUpdateDate(string $update_date) Return the first ChildAuctionItems filtered by the update_date column *

 * @method     ChildAuctionItems requirePk($key, ConnectionInterface $con = null) Return the ChildAuctionItems by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionItems requireOne(ConnectionInterface $con = null) Return the first ChildAuctionItems matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAuctionItems requireOneByItemDef(string $item_def) Return the first ChildAuctionItems filtered by the item_def column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionItems requireOneByItemName(string $item_name) Return the first ChildAuctionItems filtered by the item_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionItems requireOneByQuality(string $quality) Return the first ChildAuctionItems filtered by the quality column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionItems requireOneByCategories(string $categories) Return the first ChildAuctionItems filtered by the categories column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionItems requireOneByCrawlCategory(string $crawl_category) Return the first ChildAuctionItems filtered by the crawl_category column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionItems requireOneByAllowAuto(boolean $allow_auto) Return the first ChildAuctionItems filtered by the allow_auto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionItems requireOneByServer(string $server) Return the first ChildAuctionItems filtered by the server column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionItems requireOneByUpdateDate(string $update_date) Return the first ChildAuctionItems filtered by the update_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAuctionItems[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAuctionItems objects based on current ModelCriteria
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionItems> find(ConnectionInterface $con = null) Return ChildAuctionItems objects based on current ModelCriteria
 * @method     ChildAuctionItems[]|ObjectCollection findByItemDef(string $item_def) Return ChildAuctionItems objects filtered by the item_def column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionItems> findByItemDef(string $item_def) Return ChildAuctionItems objects filtered by the item_def column
 * @method     ChildAuctionItems[]|ObjectCollection findByItemName(string $item_name) Return ChildAuctionItems objects filtered by the item_name column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionItems> findByItemName(string $item_name) Return ChildAuctionItems objects filtered by the item_name column
 * @method     ChildAuctionItems[]|ObjectCollection findByQuality(string $quality) Return ChildAuctionItems objects filtered by the quality column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionItems> findByQuality(string $quality) Return ChildAuctionItems objects filtered by the quality column
 * @method     ChildAuctionItems[]|ObjectCollection findByCategories(string $categories) Return ChildAuctionItems objects filtered by the categories column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionItems> findByCategories(string $categories) Return ChildAuctionItems objects filtered by the categories column
 * @method     ChildAuctionItems[]|ObjectCollection findByCrawlCategory(string $crawl_category) Return ChildAuctionItems objects filtered by the crawl_category column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionItems> findByCrawlCategory(string $crawl_category) Return ChildAuctionItems objects filtered by the crawl_category column
 * @method     ChildAuctionItems[]|ObjectCollection findByAllowAuto(boolean $allow_auto) Return ChildAuctionItems objects filtered by the allow_auto column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionItems> findByAllowAuto(boolean $allow_auto) Return ChildAuctionItems objects filtered by the allow_auto column
 * @method     ChildAuctionItems[]|ObjectCollection findByServer(string $server) Return ChildAuctionItems objects filtered by the server column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionItems> findByServer(string $server) Return ChildAuctionItems objects filtered by the server column
 * @method     ChildAuctionItems[]|ObjectCollection findByUpdateDate(string $update_date) Return ChildAuctionItems objects filtered by the update_date column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionItems> findByUpdateDate(string $update_date) Return ChildAuctionItems objects filtered by the update_date column
 * @method     ChildAuctionItems[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildAuctionItems> paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AuctionItemsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Schema\Crawl\AuctionItems\Base\AuctionItemsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'crawl', $modelName = '\\App\\Schema\\Crawl\\AuctionItems\\AuctionItems', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAuctionItemsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAuctionItemsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAuctionItemsQuery) {
            return $criteria;
        }
        $query = new ChildAuctionItemsQuery();
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
     * @param array[$item_def, $server] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAuctionItems|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AuctionItemsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AuctionItemsTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildAuctionItems A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT item_def, item_name, quality, categories, crawl_category, allow_auto, server, update_date FROM auction_items WHERE item_def = :p0 AND server = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_STR);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAuctionItems $obj */
            $obj = new ChildAuctionItems();
            $obj->hydrate($row);
            AuctionItemsTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildAuctionItems|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(AuctionItemsTableMap::COL_ITEM_DEF, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AuctionItemsTableMap::COL_SERVER, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(AuctionItemsTableMap::COL_ITEM_DEF, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AuctionItemsTableMap::COL_SERVER, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the item_def column
     *
     * Example usage:
     * <code>
     * $query->filterByItemDef('fooValue');   // WHERE item_def = 'fooValue'
     * $query->filterByItemDef('%fooValue%', Criteria::LIKE); // WHERE item_def LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemDef The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function filterByItemDef($itemDef = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemDef)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuctionItemsTableMap::COL_ITEM_DEF, $itemDef, $comparison);
    }

    /**
     * Filter the query on the item_name column
     *
     * Example usage:
     * <code>
     * $query->filterByItemName('fooValue');   // WHERE item_name = 'fooValue'
     * $query->filterByItemName('%fooValue%', Criteria::LIKE); // WHERE item_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function filterByItemName($itemName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuctionItemsTableMap::COL_ITEM_NAME, $itemName, $comparison);
    }

    /**
     * Filter the query on the quality column
     *
     * Example usage:
     * <code>
     * $query->filterByQuality('fooValue');   // WHERE quality = 'fooValue'
     * $query->filterByQuality('%fooValue%', Criteria::LIKE); // WHERE quality LIKE '%fooValue%'
     * </code>
     *
     * @param     string $quality The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function filterByQuality($quality = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($quality)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuctionItemsTableMap::COL_QUALITY, $quality, $comparison);
    }

    /**
     * Filter the query on the categories column
     *
     * Example usage:
     * <code>
     * $query->filterByCategories('fooValue');   // WHERE categories = 'fooValue'
     * $query->filterByCategories('%fooValue%', Criteria::LIKE); // WHERE categories LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categories The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function filterByCategories($categories = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($categories)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuctionItemsTableMap::COL_CATEGORIES, $categories, $comparison);
    }

    /**
     * Filter the query on the crawl_category column
     *
     * Example usage:
     * <code>
     * $query->filterByCrawlCategory('fooValue');   // WHERE crawl_category = 'fooValue'
     * $query->filterByCrawlCategory('%fooValue%', Criteria::LIKE); // WHERE crawl_category LIKE '%fooValue%'
     * </code>
     *
     * @param     string $crawlCategory The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function filterByCrawlCategory($crawlCategory = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($crawlCategory)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuctionItemsTableMap::COL_CRAWL_CATEGORY, $crawlCategory, $comparison);
    }

    /**
     * Filter the query on the allow_auto column
     *
     * Example usage:
     * <code>
     * $query->filterByAllowAuto(true); // WHERE allow_auto = true
     * $query->filterByAllowAuto('yes'); // WHERE allow_auto = true
     * </code>
     *
     * @param     boolean|string $allowAuto The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function filterByAllowAuto($allowAuto = null, $comparison = null)
    {
        if (is_string($allowAuto)) {
            $allowAuto = in_array(strtolower($allowAuto), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AuctionItemsTableMap::COL_ALLOW_AUTO, $allowAuto, $comparison);
    }

    /**
     * Filter the query on the server column
     *
     * Example usage:
     * <code>
     * $query->filterByServer('fooValue');   // WHERE server = 'fooValue'
     * $query->filterByServer('%fooValue%', Criteria::LIKE); // WHERE server LIKE '%fooValue%'
     * </code>
     *
     * @param     string $server The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function filterByServer($server = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($server)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuctionItemsTableMap::COL_SERVER, $server, $comparison);
    }

    /**
     * Filter the query on the update_date column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateDate('2011-03-14'); // WHERE update_date = '2011-03-14'
     * $query->filterByUpdateDate('now'); // WHERE update_date = '2011-03-14'
     * $query->filterByUpdateDate(array('max' => 'yesterday')); // WHERE update_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $updateDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function filterByUpdateDate($updateDate = null, $comparison = null)
    {
        if (is_array($updateDate)) {
            $useMinMax = false;
            if (isset($updateDate['min'])) {
                $this->addUsingAlias(AuctionItemsTableMap::COL_UPDATE_DATE, $updateDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updateDate['max'])) {
                $this->addUsingAlias(AuctionItemsTableMap::COL_UPDATE_DATE, $updateDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuctionItemsTableMap::COL_UPDATE_DATE, $updateDate, $comparison);
    }

    /**
     * Filter the query by a related \App\Schema\Crawl\AuctionAggregates\AuctionAggregates object
     *
     * @param \App\Schema\Crawl\AuctionAggregates\AuctionAggregates|ObjectCollection $auctionAggregates the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function filterByAuctionAggregates($auctionAggregates, $comparison = null)
    {
        if ($auctionAggregates instanceof \App\Schema\Crawl\AuctionAggregates\AuctionAggregates) {
            return $this
                ->addUsingAlias(AuctionItemsTableMap::COL_ITEM_DEF, $auctionAggregates->getItemDef(), $comparison)
                ->addUsingAlias(AuctionItemsTableMap::COL_SERVER, $auctionAggregates->getServer(), $comparison);
        } else {
            throw new PropelException('filterByAuctionAggregates() only accepts arguments of type \App\Schema\Crawl\AuctionAggregates\AuctionAggregates');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuctionAggregates relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function joinAuctionAggregates($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuctionAggregates');

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
            $this->addJoinObject($join, 'AuctionAggregates');
        }

        return $this;
    }

    /**
     * Use the AuctionAggregates relation AuctionAggregates object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery A secondary query class using the current class as primary query
     */
    public function useAuctionAggregatesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAuctionAggregates($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuctionAggregates', '\App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery');
    }

    /**
     * Use the AuctionAggregates relation AuctionAggregates object
     *
     * @param callable(\App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery):\App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withAuctionAggregatesQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useAuctionAggregatesQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to AuctionAggregates table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery The inner query object of the EXISTS statement
     */
    public function useAuctionAggregatesExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('AuctionAggregates', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to AuctionAggregates table for a NOT EXISTS query.
     *
     * @see useAuctionAggregatesExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery The inner query object of the NOT EXISTS statement
     */
    public function useAuctionAggregatesNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('AuctionAggregates', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \App\Schema\Crawl\AuctionDetails\AuctionDetails object
     *
     * @param \App\Schema\Crawl\AuctionDetails\AuctionDetails|ObjectCollection $auctionDetails the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function filterByAuctionDetails($auctionDetails, $comparison = null)
    {
        if ($auctionDetails instanceof \App\Schema\Crawl\AuctionDetails\AuctionDetails) {
            return $this
                ->addUsingAlias(AuctionItemsTableMap::COL_ITEM_DEF, $auctionDetails->getItemDef(), $comparison)
                ->addUsingAlias(AuctionItemsTableMap::COL_SERVER, $auctionDetails->getServer(), $comparison);
        } else {
            throw new PropelException('filterByAuctionDetails() only accepts arguments of type \App\Schema\Crawl\AuctionDetails\AuctionDetails');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuctionDetails relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function joinAuctionDetails($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuctionDetails');

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
            $this->addJoinObject($join, 'AuctionDetails');
        }

        return $this;
    }

    /**
     * Use the AuctionDetails relation AuctionDetails object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Schema\Crawl\AuctionDetails\AuctionDetailsQuery A secondary query class using the current class as primary query
     */
    public function useAuctionDetailsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAuctionDetails($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuctionDetails', '\App\Schema\Crawl\AuctionDetails\AuctionDetailsQuery');
    }

    /**
     * Use the AuctionDetails relation AuctionDetails object
     *
     * @param callable(\App\Schema\Crawl\AuctionDetails\AuctionDetailsQuery):\App\Schema\Crawl\AuctionDetails\AuctionDetailsQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withAuctionDetailsQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useAuctionDetailsQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to AuctionDetails table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \App\Schema\Crawl\AuctionDetails\AuctionDetailsQuery The inner query object of the EXISTS statement
     */
    public function useAuctionDetailsExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('AuctionDetails', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to AuctionDetails table for a NOT EXISTS query.
     *
     * @see useAuctionDetailsExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \App\Schema\Crawl\AuctionDetails\AuctionDetailsQuery The inner query object of the NOT EXISTS statement
     */
    public function useAuctionDetailsNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('AuctionDetails', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param   ChildAuctionItems $auctionItems Object to remove from the list of results
     *
     * @return $this|ChildAuctionItemsQuery The current query, for fluid interface
     */
    public function prune($auctionItems = null)
    {
        if ($auctionItems) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AuctionItemsTableMap::COL_ITEM_DEF), $auctionItems->getItemDef(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AuctionItemsTableMap::COL_SERVER), $auctionItems->getServer(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the auction_items table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionItemsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AuctionItemsTableMap::clearInstancePool();
            AuctionItemsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionItemsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AuctionItemsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AuctionItemsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AuctionItemsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AuctionItemsQuery
