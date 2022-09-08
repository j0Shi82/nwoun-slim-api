<?php

namespace App\Schema\Crawl\AuctionDetails\Base;

use \Exception;
use \PDO;
use App\Schema\Crawl\AuctionDetails\AuctionDetails as ChildAuctionDetails;
use App\Schema\Crawl\AuctionDetails\AuctionDetailsQuery as ChildAuctionDetailsQuery;
use App\Schema\Crawl\AuctionDetails\Map\AuctionDetailsTableMap;
use App\Schema\Crawl\AuctionItems\AuctionItems;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'auction_details' table.
 *
 *
 *
 * @method     ChildAuctionDetailsQuery orderByItemDef($order = Criteria::ASC) Order by the item_def column
 * @method     ChildAuctionDetailsQuery orderByServer($order = Criteria::ASC) Order by the server column
 * @method     ChildAuctionDetailsQuery orderBySellerName($order = Criteria::ASC) Order by the seller_name column
 * @method     ChildAuctionDetailsQuery orderBySellerHandle($order = Criteria::ASC) Order by the seller_handle column
 * @method     ChildAuctionDetailsQuery orderByExpireTime($order = Criteria::ASC) Order by the expire_time column
 * @method     ChildAuctionDetailsQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildAuctionDetailsQuery orderByCount($order = Criteria::ASC) Order by the count column
 * @method     ChildAuctionDetailsQuery orderByPricePer($order = Criteria::ASC) Order by the price_per column
 *
 * @method     ChildAuctionDetailsQuery groupByItemDef() Group by the item_def column
 * @method     ChildAuctionDetailsQuery groupByServer() Group by the server column
 * @method     ChildAuctionDetailsQuery groupBySellerName() Group by the seller_name column
 * @method     ChildAuctionDetailsQuery groupBySellerHandle() Group by the seller_handle column
 * @method     ChildAuctionDetailsQuery groupByExpireTime() Group by the expire_time column
 * @method     ChildAuctionDetailsQuery groupByPrice() Group by the price column
 * @method     ChildAuctionDetailsQuery groupByCount() Group by the count column
 * @method     ChildAuctionDetailsQuery groupByPricePer() Group by the price_per column
 *
 * @method     ChildAuctionDetailsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAuctionDetailsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAuctionDetailsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAuctionDetailsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAuctionDetailsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAuctionDetailsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAuctionDetailsQuery leftJoinAuctionItems($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuctionItems relation
 * @method     ChildAuctionDetailsQuery rightJoinAuctionItems($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuctionItems relation
 * @method     ChildAuctionDetailsQuery innerJoinAuctionItems($relationAlias = null) Adds a INNER JOIN clause to the query using the AuctionItems relation
 *
 * @method     ChildAuctionDetailsQuery joinWithAuctionItems($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AuctionItems relation
 *
 * @method     ChildAuctionDetailsQuery leftJoinWithAuctionItems() Adds a LEFT JOIN clause and with to the query using the AuctionItems relation
 * @method     ChildAuctionDetailsQuery rightJoinWithAuctionItems() Adds a RIGHT JOIN clause and with to the query using the AuctionItems relation
 * @method     ChildAuctionDetailsQuery innerJoinWithAuctionItems() Adds a INNER JOIN clause and with to the query using the AuctionItems relation
 *
 * @method     \App\Schema\Crawl\AuctionItems\AuctionItemsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAuctionDetails|null findOne(?ConnectionInterface $con = null) Return the first ChildAuctionDetails matching the query
 * @method     ChildAuctionDetails findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildAuctionDetails matching the query, or a new ChildAuctionDetails object populated from the query conditions when no match is found
 *
 * @method     ChildAuctionDetails|null findOneByItemDef(string $item_def) Return the first ChildAuctionDetails filtered by the item_def column
 * @method     ChildAuctionDetails|null findOneByServer(string $server) Return the first ChildAuctionDetails filtered by the server column
 * @method     ChildAuctionDetails|null findOneBySellerName(string $seller_name) Return the first ChildAuctionDetails filtered by the seller_name column
 * @method     ChildAuctionDetails|null findOneBySellerHandle(string $seller_handle) Return the first ChildAuctionDetails filtered by the seller_handle column
 * @method     ChildAuctionDetails|null findOneByExpireTime(string $expire_time) Return the first ChildAuctionDetails filtered by the expire_time column
 * @method     ChildAuctionDetails|null findOneByPrice(int $price) Return the first ChildAuctionDetails filtered by the price column
 * @method     ChildAuctionDetails|null findOneByCount(int $count) Return the first ChildAuctionDetails filtered by the count column
 * @method     ChildAuctionDetails|null findOneByPricePer(double $price_per) Return the first ChildAuctionDetails filtered by the price_per column *

 * @method     ChildAuctionDetails requirePk($key, ?ConnectionInterface $con = null) Return the ChildAuctionDetails by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionDetails requireOne(?ConnectionInterface $con = null) Return the first ChildAuctionDetails matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAuctionDetails requireOneByItemDef(string $item_def) Return the first ChildAuctionDetails filtered by the item_def column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionDetails requireOneByServer(string $server) Return the first ChildAuctionDetails filtered by the server column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionDetails requireOneBySellerName(string $seller_name) Return the first ChildAuctionDetails filtered by the seller_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionDetails requireOneBySellerHandle(string $seller_handle) Return the first ChildAuctionDetails filtered by the seller_handle column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionDetails requireOneByExpireTime(string $expire_time) Return the first ChildAuctionDetails filtered by the expire_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionDetails requireOneByPrice(int $price) Return the first ChildAuctionDetails filtered by the price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionDetails requireOneByCount(int $count) Return the first ChildAuctionDetails filtered by the count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionDetails requireOneByPricePer(double $price_per) Return the first ChildAuctionDetails filtered by the price_per column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAuctionDetails[]|Collection find(?ConnectionInterface $con = null) Return ChildAuctionDetails objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildAuctionDetails> find(?ConnectionInterface $con = null) Return ChildAuctionDetails objects based on current ModelCriteria
 * @method     ChildAuctionDetails[]|Collection findByItemDef(string $item_def) Return ChildAuctionDetails objects filtered by the item_def column
 * @psalm-method Collection&\Traversable<ChildAuctionDetails> findByItemDef(string $item_def) Return ChildAuctionDetails objects filtered by the item_def column
 * @method     ChildAuctionDetails[]|Collection findByServer(string $server) Return ChildAuctionDetails objects filtered by the server column
 * @psalm-method Collection&\Traversable<ChildAuctionDetails> findByServer(string $server) Return ChildAuctionDetails objects filtered by the server column
 * @method     ChildAuctionDetails[]|Collection findBySellerName(string $seller_name) Return ChildAuctionDetails objects filtered by the seller_name column
 * @psalm-method Collection&\Traversable<ChildAuctionDetails> findBySellerName(string $seller_name) Return ChildAuctionDetails objects filtered by the seller_name column
 * @method     ChildAuctionDetails[]|Collection findBySellerHandle(string $seller_handle) Return ChildAuctionDetails objects filtered by the seller_handle column
 * @psalm-method Collection&\Traversable<ChildAuctionDetails> findBySellerHandle(string $seller_handle) Return ChildAuctionDetails objects filtered by the seller_handle column
 * @method     ChildAuctionDetails[]|Collection findByExpireTime(string $expire_time) Return ChildAuctionDetails objects filtered by the expire_time column
 * @psalm-method Collection&\Traversable<ChildAuctionDetails> findByExpireTime(string $expire_time) Return ChildAuctionDetails objects filtered by the expire_time column
 * @method     ChildAuctionDetails[]|Collection findByPrice(int $price) Return ChildAuctionDetails objects filtered by the price column
 * @psalm-method Collection&\Traversable<ChildAuctionDetails> findByPrice(int $price) Return ChildAuctionDetails objects filtered by the price column
 * @method     ChildAuctionDetails[]|Collection findByCount(int $count) Return ChildAuctionDetails objects filtered by the count column
 * @psalm-method Collection&\Traversable<ChildAuctionDetails> findByCount(int $count) Return ChildAuctionDetails objects filtered by the count column
 * @method     ChildAuctionDetails[]|Collection findByPricePer(double $price_per) Return ChildAuctionDetails objects filtered by the price_per column
 * @psalm-method Collection&\Traversable<ChildAuctionDetails> findByPricePer(double $price_per) Return ChildAuctionDetails objects filtered by the price_per column
 * @method     ChildAuctionDetails[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildAuctionDetails> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AuctionDetailsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Schema\Crawl\AuctionDetails\Base\AuctionDetailsQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'crawl', $modelName = '\\App\\Schema\\Crawl\\AuctionDetails\\AuctionDetails', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAuctionDetailsQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAuctionDetailsQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildAuctionDetailsQuery) {
            return $criteria;
        }
        $query = new ChildAuctionDetailsQuery();
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
     * $obj = $c->findPk(array(12, 34, 56, 78, 91), $con);
     * </code>
     *
     * @param array[$item_def, $server, $seller_name, $seller_handle, $expire_time] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAuctionDetails|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AuctionDetailsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AuctionDetailsTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2]), (null === $key[3] || is_scalar($key[3]) || is_callable([$key[3], '__toString']) ? (string) $key[3] : $key[3]), (null === $key[4] || is_scalar($key[4]) || is_callable([$key[4], '__toString']) ? (string) $key[4] : $key[4])]))))) {
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
     * @return ChildAuctionDetails A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT item_def, server, seller_name, seller_handle, expire_time, price, count, price_per FROM auction_details WHERE item_def = :p0 AND server = :p1 AND seller_name = :p2 AND seller_handle = :p3 AND expire_time = :p4';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_STR);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_STR);
            $stmt->bindValue(':p3', $key[3], PDO::PARAM_STR);
            $stmt->bindValue(':p4', $key[4], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAuctionDetails $obj */
            $obj = new ChildAuctionDetails();
            $obj->hydrate($row);
            AuctionDetailsTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2]), (null === $key[3] || is_scalar($key[3]) || is_callable([$key[3], '__toString']) ? (string) $key[3] : $key[3]), (null === $key[4] || is_scalar($key[4]) || is_callable([$key[4], '__toString']) ? (string) $key[4] : $key[4])]));
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
     * @return ChildAuctionDetails|array|mixed the result, formatted by the current formatter
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
        $this->addUsingAlias(AuctionDetailsTableMap::COL_ITEM_DEF, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AuctionDetailsTableMap::COL_SERVER, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(AuctionDetailsTableMap::COL_SELLER_NAME, $key[2], Criteria::EQUAL);
        $this->addUsingAlias(AuctionDetailsTableMap::COL_SELLER_HANDLE, $key[3], Criteria::EQUAL);
        $this->addUsingAlias(AuctionDetailsTableMap::COL_EXPIRE_TIME, $key[4], Criteria::EQUAL);

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
            $cton0 = $this->getNewCriterion(AuctionDetailsTableMap::COL_ITEM_DEF, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AuctionDetailsTableMap::COL_SERVER, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(AuctionDetailsTableMap::COL_SELLER_NAME, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $cton3 = $this->getNewCriterion(AuctionDetailsTableMap::COL_SELLER_HANDLE, $key[3], Criteria::EQUAL);
            $cton0->addAnd($cton3);
            $cton4 = $this->getNewCriterion(AuctionDetailsTableMap::COL_EXPIRE_TIME, $key[4], Criteria::EQUAL);
            $cton0->addAnd($cton4);
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
     * $query->filterByItemDef(['foo', 'bar']); // WHERE item_def IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $itemDef The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByItemDef($itemDef = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemDef)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionDetailsTableMap::COL_ITEM_DEF, $itemDef, $comparison);

        return $this;
    }

    /**
     * Filter the query on the server column
     *
     * Example usage:
     * <code>
     * $query->filterByServer('fooValue');   // WHERE server = 'fooValue'
     * $query->filterByServer('%fooValue%', Criteria::LIKE); // WHERE server LIKE '%fooValue%'
     * $query->filterByServer(['foo', 'bar']); // WHERE server IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $server The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByServer($server = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($server)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionDetailsTableMap::COL_SERVER, $server, $comparison);

        return $this;
    }

    /**
     * Filter the query on the seller_name column
     *
     * Example usage:
     * <code>
     * $query->filterBySellerName('fooValue');   // WHERE seller_name = 'fooValue'
     * $query->filterBySellerName('%fooValue%', Criteria::LIKE); // WHERE seller_name LIKE '%fooValue%'
     * $query->filterBySellerName(['foo', 'bar']); // WHERE seller_name IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $sellerName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterBySellerName($sellerName = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sellerName)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionDetailsTableMap::COL_SELLER_NAME, $sellerName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the seller_handle column
     *
     * Example usage:
     * <code>
     * $query->filterBySellerHandle('fooValue');   // WHERE seller_handle = 'fooValue'
     * $query->filterBySellerHandle('%fooValue%', Criteria::LIKE); // WHERE seller_handle LIKE '%fooValue%'
     * $query->filterBySellerHandle(['foo', 'bar']); // WHERE seller_handle IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $sellerHandle The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterBySellerHandle($sellerHandle = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sellerHandle)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionDetailsTableMap::COL_SELLER_HANDLE, $sellerHandle, $comparison);

        return $this;
    }

    /**
     * Filter the query on the expire_time column
     *
     * Example usage:
     * <code>
     * $query->filterByExpireTime(1234); // WHERE expire_time = 1234
     * $query->filterByExpireTime(array(12, 34)); // WHERE expire_time IN (12, 34)
     * $query->filterByExpireTime(array('min' => 12)); // WHERE expire_time > 12
     * </code>
     *
     * @param mixed $expireTime The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByExpireTime($expireTime = null, ?string $comparison = null)
    {
        if (is_array($expireTime)) {
            $useMinMax = false;
            if (isset($expireTime['min'])) {
                $this->addUsingAlias(AuctionDetailsTableMap::COL_EXPIRE_TIME, $expireTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expireTime['max'])) {
                $this->addUsingAlias(AuctionDetailsTableMap::COL_EXPIRE_TIME, $expireTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionDetailsTableMap::COL_EXPIRE_TIME, $expireTime, $comparison);

        return $this;
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price > 12
     * </code>
     *
     * @param mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrice($price = null, ?string $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(AuctionDetailsTableMap::COL_PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(AuctionDetailsTableMap::COL_PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionDetailsTableMap::COL_PRICE, $price, $comparison);

        return $this;
    }

    /**
     * Filter the query on the count column
     *
     * Example usage:
     * <code>
     * $query->filterByCount(1234); // WHERE count = 1234
     * $query->filterByCount(array(12, 34)); // WHERE count IN (12, 34)
     * $query->filterByCount(array('min' => 12)); // WHERE count > 12
     * </code>
     *
     * @param mixed $count The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCount($count = null, ?string $comparison = null)
    {
        if (is_array($count)) {
            $useMinMax = false;
            if (isset($count['min'])) {
                $this->addUsingAlias(AuctionDetailsTableMap::COL_COUNT, $count['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($count['max'])) {
                $this->addUsingAlias(AuctionDetailsTableMap::COL_COUNT, $count['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionDetailsTableMap::COL_COUNT, $count, $comparison);

        return $this;
    }

    /**
     * Filter the query on the price_per column
     *
     * Example usage:
     * <code>
     * $query->filterByPricePer(1234); // WHERE price_per = 1234
     * $query->filterByPricePer(array(12, 34)); // WHERE price_per IN (12, 34)
     * $query->filterByPricePer(array('min' => 12)); // WHERE price_per > 12
     * </code>
     *
     * @param mixed $pricePer The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPricePer($pricePer = null, ?string $comparison = null)
    {
        if (is_array($pricePer)) {
            $useMinMax = false;
            if (isset($pricePer['min'])) {
                $this->addUsingAlias(AuctionDetailsTableMap::COL_PRICE_PER, $pricePer['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pricePer['max'])) {
                $this->addUsingAlias(AuctionDetailsTableMap::COL_PRICE_PER, $pricePer['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionDetailsTableMap::COL_PRICE_PER, $pricePer, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \App\Schema\Crawl\AuctionItems\AuctionItems object
     *
     * @param \App\Schema\Crawl\AuctionItems\AuctionItems $auctionItems The related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByAuctionItems($auctionItems, ?string $comparison = null)
    {
        if ($auctionItems instanceof \App\Schema\Crawl\AuctionItems\AuctionItems) {
            return $this
                ->addUsingAlias(AuctionDetailsTableMap::COL_ITEM_DEF, $auctionItems->getItemDef(), $comparison)
                ->addUsingAlias(AuctionDetailsTableMap::COL_SERVER, $auctionItems->getServer(), $comparison);
        } else {
            throw new PropelException('filterByAuctionItems() only accepts arguments of type \App\Schema\Crawl\AuctionItems\AuctionItems');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuctionItems relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinAuctionItems(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuctionItems');

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
            $this->addJoinObject($join, 'AuctionItems');
        }

        return $this;
    }

    /**
     * Use the AuctionItems relation AuctionItems object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Schema\Crawl\AuctionItems\AuctionItemsQuery A secondary query class using the current class as primary query
     */
    public function useAuctionItemsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAuctionItems($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuctionItems', '\App\Schema\Crawl\AuctionItems\AuctionItemsQuery');
    }

    /**
     * Use the AuctionItems relation AuctionItems object
     *
     * @param callable(\App\Schema\Crawl\AuctionItems\AuctionItemsQuery):\App\Schema\Crawl\AuctionItems\AuctionItemsQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withAuctionItemsQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useAuctionItemsQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to AuctionItems table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \App\Schema\Crawl\AuctionItems\AuctionItemsQuery The inner query object of the EXISTS statement
     */
    public function useAuctionItemsExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('AuctionItems', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to AuctionItems table for a NOT EXISTS query.
     *
     * @see useAuctionItemsExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \App\Schema\Crawl\AuctionItems\AuctionItemsQuery The inner query object of the NOT EXISTS statement
     */
    public function useAuctionItemsNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('AuctionItems', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param ChildAuctionDetails $auctionDetails Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($auctionDetails = null)
    {
        if ($auctionDetails) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AuctionDetailsTableMap::COL_ITEM_DEF), $auctionDetails->getItemDef(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AuctionDetailsTableMap::COL_SERVER), $auctionDetails->getServer(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(AuctionDetailsTableMap::COL_SELLER_NAME), $auctionDetails->getSellerName(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond3', $this->getAliasedColName(AuctionDetailsTableMap::COL_SELLER_HANDLE), $auctionDetails->getSellerHandle(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond4', $this->getAliasedColName(AuctionDetailsTableMap::COL_EXPIRE_TIME), $auctionDetails->getExpireTime(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2', 'pruneCond3', 'pruneCond4'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the auction_details table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionDetailsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AuctionDetailsTableMap::clearInstancePool();
            AuctionDetailsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionDetailsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AuctionDetailsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AuctionDetailsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AuctionDetailsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
