<?php

namespace App\Schema\Crawl\AuctionAggregates\Base;

use \Exception;
use \PDO;
use App\Schema\Crawl\AuctionAggregates\AuctionAggregates as ChildAuctionAggregates;
use App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery as ChildAuctionAggregatesQuery;
use App\Schema\Crawl\AuctionAggregates\Map\AuctionAggregatesTableMap;
use App\Schema\Crawl\AuctionItems\AuctionItems;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `auction_aggregates` table.
 *
 * @method     ChildAuctionAggregatesQuery orderByItemDef($order = Criteria::ASC) Order by the item_def column
 * @method     ChildAuctionAggregatesQuery orderByServer($order = Criteria::ASC) Order by the server column
 * @method     ChildAuctionAggregatesQuery orderByLow($order = Criteria::ASC) Order by the low column
 * @method     ChildAuctionAggregatesQuery orderByMean($order = Criteria::ASC) Order by the mean column
 * @method     ChildAuctionAggregatesQuery orderByMedian($order = Criteria::ASC) Order by the median column
 * @method     ChildAuctionAggregatesQuery orderByCount($order = Criteria::ASC) Order by the count column
 * @method     ChildAuctionAggregatesQuery orderByInserted($order = Criteria::ASC) Order by the inserted column
 *
 * @method     ChildAuctionAggregatesQuery groupByItemDef() Group by the item_def column
 * @method     ChildAuctionAggregatesQuery groupByServer() Group by the server column
 * @method     ChildAuctionAggregatesQuery groupByLow() Group by the low column
 * @method     ChildAuctionAggregatesQuery groupByMean() Group by the mean column
 * @method     ChildAuctionAggregatesQuery groupByMedian() Group by the median column
 * @method     ChildAuctionAggregatesQuery groupByCount() Group by the count column
 * @method     ChildAuctionAggregatesQuery groupByInserted() Group by the inserted column
 *
 * @method     ChildAuctionAggregatesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAuctionAggregatesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAuctionAggregatesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAuctionAggregatesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAuctionAggregatesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAuctionAggregatesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAuctionAggregatesQuery leftJoinAuctionItems($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuctionItems relation
 * @method     ChildAuctionAggregatesQuery rightJoinAuctionItems($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuctionItems relation
 * @method     ChildAuctionAggregatesQuery innerJoinAuctionItems($relationAlias = null) Adds a INNER JOIN clause to the query using the AuctionItems relation
 *
 * @method     ChildAuctionAggregatesQuery joinWithAuctionItems($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AuctionItems relation
 *
 * @method     ChildAuctionAggregatesQuery leftJoinWithAuctionItems() Adds a LEFT JOIN clause and with to the query using the AuctionItems relation
 * @method     ChildAuctionAggregatesQuery rightJoinWithAuctionItems() Adds a RIGHT JOIN clause and with to the query using the AuctionItems relation
 * @method     ChildAuctionAggregatesQuery innerJoinWithAuctionItems() Adds a INNER JOIN clause and with to the query using the AuctionItems relation
 *
 * @method     \App\Schema\Crawl\AuctionItems\AuctionItemsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAuctionAggregates|null findOne(?ConnectionInterface $con = null) Return the first ChildAuctionAggregates matching the query
 * @method     ChildAuctionAggregates findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildAuctionAggregates matching the query, or a new ChildAuctionAggregates object populated from the query conditions when no match is found
 *
 * @method     ChildAuctionAggregates|null findOneByItemDef(string $item_def) Return the first ChildAuctionAggregates filtered by the item_def column
 * @method     ChildAuctionAggregates|null findOneByServer(string $server) Return the first ChildAuctionAggregates filtered by the server column
 * @method     ChildAuctionAggregates|null findOneByLow(int $low) Return the first ChildAuctionAggregates filtered by the low column
 * @method     ChildAuctionAggregates|null findOneByMean(double $mean) Return the first ChildAuctionAggregates filtered by the mean column
 * @method     ChildAuctionAggregates|null findOneByMedian(double $median) Return the first ChildAuctionAggregates filtered by the median column
 * @method     ChildAuctionAggregates|null findOneByCount(int $count) Return the first ChildAuctionAggregates filtered by the count column
 * @method     ChildAuctionAggregates|null findOneByInserted(string $inserted) Return the first ChildAuctionAggregates filtered by the inserted column
 *
 * @method     ChildAuctionAggregates requirePk($key, ?ConnectionInterface $con = null) Return the ChildAuctionAggregates by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionAggregates requireOne(?ConnectionInterface $con = null) Return the first ChildAuctionAggregates matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAuctionAggregates requireOneByItemDef(string $item_def) Return the first ChildAuctionAggregates filtered by the item_def column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionAggregates requireOneByServer(string $server) Return the first ChildAuctionAggregates filtered by the server column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionAggregates requireOneByLow(int $low) Return the first ChildAuctionAggregates filtered by the low column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionAggregates requireOneByMean(double $mean) Return the first ChildAuctionAggregates filtered by the mean column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionAggregates requireOneByMedian(double $median) Return the first ChildAuctionAggregates filtered by the median column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionAggregates requireOneByCount(int $count) Return the first ChildAuctionAggregates filtered by the count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionAggregates requireOneByInserted(string $inserted) Return the first ChildAuctionAggregates filtered by the inserted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAuctionAggregates[]|Collection find(?ConnectionInterface $con = null) Return ChildAuctionAggregates objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildAuctionAggregates> find(?ConnectionInterface $con = null) Return ChildAuctionAggregates objects based on current ModelCriteria
 *
 * @method     ChildAuctionAggregates[]|Collection findByItemDef(string|array<string> $item_def) Return ChildAuctionAggregates objects filtered by the item_def column
 * @psalm-method Collection&\Traversable<ChildAuctionAggregates> findByItemDef(string|array<string> $item_def) Return ChildAuctionAggregates objects filtered by the item_def column
 * @method     ChildAuctionAggregates[]|Collection findByServer(string|array<string> $server) Return ChildAuctionAggregates objects filtered by the server column
 * @psalm-method Collection&\Traversable<ChildAuctionAggregates> findByServer(string|array<string> $server) Return ChildAuctionAggregates objects filtered by the server column
 * @method     ChildAuctionAggregates[]|Collection findByLow(int|array<int> $low) Return ChildAuctionAggregates objects filtered by the low column
 * @psalm-method Collection&\Traversable<ChildAuctionAggregates> findByLow(int|array<int> $low) Return ChildAuctionAggregates objects filtered by the low column
 * @method     ChildAuctionAggregates[]|Collection findByMean(double|array<double> $mean) Return ChildAuctionAggregates objects filtered by the mean column
 * @psalm-method Collection&\Traversable<ChildAuctionAggregates> findByMean(double|array<double> $mean) Return ChildAuctionAggregates objects filtered by the mean column
 * @method     ChildAuctionAggregates[]|Collection findByMedian(double|array<double> $median) Return ChildAuctionAggregates objects filtered by the median column
 * @psalm-method Collection&\Traversable<ChildAuctionAggregates> findByMedian(double|array<double> $median) Return ChildAuctionAggregates objects filtered by the median column
 * @method     ChildAuctionAggregates[]|Collection findByCount(int|array<int> $count) Return ChildAuctionAggregates objects filtered by the count column
 * @psalm-method Collection&\Traversable<ChildAuctionAggregates> findByCount(int|array<int> $count) Return ChildAuctionAggregates objects filtered by the count column
 * @method     ChildAuctionAggregates[]|Collection findByInserted(string|array<string> $inserted) Return ChildAuctionAggregates objects filtered by the inserted column
 * @psalm-method Collection&\Traversable<ChildAuctionAggregates> findByInserted(string|array<string> $inserted) Return ChildAuctionAggregates objects filtered by the inserted column
 *
 * @method     ChildAuctionAggregates[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildAuctionAggregates> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class AuctionAggregatesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Schema\Crawl\AuctionAggregates\Base\AuctionAggregatesQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'crawl', $modelName = '\\App\\Schema\\Crawl\\AuctionAggregates\\AuctionAggregates', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAuctionAggregatesQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAuctionAggregatesQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildAuctionAggregatesQuery) {
            return $criteria;
        }
        $query = new ChildAuctionAggregatesQuery();
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
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array[$item_def, $server, $inserted] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAuctionAggregates|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AuctionAggregatesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AuctionAggregatesTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]))))) {
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
     * @return ChildAuctionAggregates A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT item_def, server, low, mean, median, count, inserted FROM auction_aggregates WHERE item_def = :p0 AND server = :p1 AND inserted = :p2';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_STR);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->bindValue(':p2', $key[2] ? $key[2]->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAuctionAggregates $obj */
            $obj = new ChildAuctionAggregates();
            $obj->hydrate($row);
            AuctionAggregatesTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
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
     * @return ChildAuctionAggregates|array|mixed the result, formatted by the current formatter
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
        $this->addUsingAlias(AuctionAggregatesTableMap::COL_ITEM_DEF, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AuctionAggregatesTableMap::COL_SERVER, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(AuctionAggregatesTableMap::COL_INSERTED, $key[2], Criteria::EQUAL);

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
            $cton0 = $this->getNewCriterion(AuctionAggregatesTableMap::COL_ITEM_DEF, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AuctionAggregatesTableMap::COL_SERVER, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(AuctionAggregatesTableMap::COL_INSERTED, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
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

        $this->addUsingAlias(AuctionAggregatesTableMap::COL_ITEM_DEF, $itemDef, $comparison);

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

        $this->addUsingAlias(AuctionAggregatesTableMap::COL_SERVER, $server, $comparison);

        return $this;
    }

    /**
     * Filter the query on the low column
     *
     * Example usage:
     * <code>
     * $query->filterByLow(1234); // WHERE low = 1234
     * $query->filterByLow(array(12, 34)); // WHERE low IN (12, 34)
     * $query->filterByLow(array('min' => 12)); // WHERE low > 12
     * </code>
     *
     * @param mixed $low The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByLow($low = null, ?string $comparison = null)
    {
        if (is_array($low)) {
            $useMinMax = false;
            if (isset($low['min'])) {
                $this->addUsingAlias(AuctionAggregatesTableMap::COL_LOW, $low['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($low['max'])) {
                $this->addUsingAlias(AuctionAggregatesTableMap::COL_LOW, $low['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionAggregatesTableMap::COL_LOW, $low, $comparison);

        return $this;
    }

    /**
     * Filter the query on the mean column
     *
     * Example usage:
     * <code>
     * $query->filterByMean(1234); // WHERE mean = 1234
     * $query->filterByMean(array(12, 34)); // WHERE mean IN (12, 34)
     * $query->filterByMean(array('min' => 12)); // WHERE mean > 12
     * </code>
     *
     * @param mixed $mean The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByMean($mean = null, ?string $comparison = null)
    {
        if (is_array($mean)) {
            $useMinMax = false;
            if (isset($mean['min'])) {
                $this->addUsingAlias(AuctionAggregatesTableMap::COL_MEAN, $mean['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mean['max'])) {
                $this->addUsingAlias(AuctionAggregatesTableMap::COL_MEAN, $mean['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionAggregatesTableMap::COL_MEAN, $mean, $comparison);

        return $this;
    }

    /**
     * Filter the query on the median column
     *
     * Example usage:
     * <code>
     * $query->filterByMedian(1234); // WHERE median = 1234
     * $query->filterByMedian(array(12, 34)); // WHERE median IN (12, 34)
     * $query->filterByMedian(array('min' => 12)); // WHERE median > 12
     * </code>
     *
     * @param mixed $median The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByMedian($median = null, ?string $comparison = null)
    {
        if (is_array($median)) {
            $useMinMax = false;
            if (isset($median['min'])) {
                $this->addUsingAlias(AuctionAggregatesTableMap::COL_MEDIAN, $median['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($median['max'])) {
                $this->addUsingAlias(AuctionAggregatesTableMap::COL_MEDIAN, $median['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionAggregatesTableMap::COL_MEDIAN, $median, $comparison);

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
                $this->addUsingAlias(AuctionAggregatesTableMap::COL_COUNT, $count['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($count['max'])) {
                $this->addUsingAlias(AuctionAggregatesTableMap::COL_COUNT, $count['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionAggregatesTableMap::COL_COUNT, $count, $comparison);

        return $this;
    }

    /**
     * Filter the query on the inserted column
     *
     * Example usage:
     * <code>
     * $query->filterByInserted('2011-03-14'); // WHERE inserted = '2011-03-14'
     * $query->filterByInserted('now'); // WHERE inserted = '2011-03-14'
     * $query->filterByInserted(array('max' => 'yesterday')); // WHERE inserted > '2011-03-13'
     * </code>
     *
     * @param mixed $inserted The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByInserted($inserted = null, ?string $comparison = null)
    {
        if (is_array($inserted)) {
            $useMinMax = false;
            if (isset($inserted['min'])) {
                $this->addUsingAlias(AuctionAggregatesTableMap::COL_INSERTED, $inserted['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($inserted['max'])) {
                $this->addUsingAlias(AuctionAggregatesTableMap::COL_INSERTED, $inserted['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionAggregatesTableMap::COL_INSERTED, $inserted, $comparison);

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
                ->addUsingAlias(AuctionAggregatesTableMap::COL_ITEM_DEF, $auctionItems->getItemDef(), $comparison)
                ->addUsingAlias(AuctionAggregatesTableMap::COL_SERVER, $auctionItems->getServer(), $comparison);
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
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \App\Schema\Crawl\AuctionItems\AuctionItemsQuery The inner query object of the EXISTS statement
     */
    public function useAuctionItemsExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \App\Schema\Crawl\AuctionItems\AuctionItemsQuery */
        $q = $this->useExistsQuery('AuctionItems', $modelAlias, $queryClass, $typeOfExists);
        return $q;
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
        /** @var $q \App\Schema\Crawl\AuctionItems\AuctionItemsQuery */
        $q = $this->useExistsQuery('AuctionItems', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to AuctionItems table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \App\Schema\Crawl\AuctionItems\AuctionItemsQuery The inner query object of the IN statement
     */
    public function useInAuctionItemsQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \App\Schema\Crawl\AuctionItems\AuctionItemsQuery */
        $q = $this->useInQuery('AuctionItems', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to AuctionItems table for a NOT IN query.
     *
     * @see useAuctionItemsInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \App\Schema\Crawl\AuctionItems\AuctionItemsQuery The inner query object of the NOT IN statement
     */
    public function useNotInAuctionItemsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \App\Schema\Crawl\AuctionItems\AuctionItemsQuery */
        $q = $this->useInQuery('AuctionItems', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildAuctionAggregates $auctionAggregates Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($auctionAggregates = null)
    {
        if ($auctionAggregates) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AuctionAggregatesTableMap::COL_ITEM_DEF), $auctionAggregates->getItemDef(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AuctionAggregatesTableMap::COL_SERVER), $auctionAggregates->getServer(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(AuctionAggregatesTableMap::COL_INSERTED), $auctionAggregates->getInserted(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the auction_aggregates table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionAggregatesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AuctionAggregatesTableMap::clearInstancePool();
            AuctionAggregatesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionAggregatesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AuctionAggregatesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AuctionAggregatesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AuctionAggregatesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
