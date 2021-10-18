<?php

namespace App\Schema\Crawl\AuctionAggregates\Base;

use \Exception;
use App\Schema\Crawl\AuctionAggregates\AuctionAggregates as ChildAuctionAggregates;
use App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery as ChildAuctionAggregatesQuery;
use App\Schema\Crawl\AuctionAggregates\Map\AuctionAggregatesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'auction_aggregates' table.
 *
 *
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
 * @method     ChildAuctionAggregates|null findOne(ConnectionInterface $con = null) Return the first ChildAuctionAggregates matching the query
 * @method     ChildAuctionAggregates findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAuctionAggregates matching the query, or a new ChildAuctionAggregates object populated from the query conditions when no match is found
 *
 * @method     ChildAuctionAggregates|null findOneByItemDef(string $item_def) Return the first ChildAuctionAggregates filtered by the item_def column
 * @method     ChildAuctionAggregates|null findOneByServer(string $server) Return the first ChildAuctionAggregates filtered by the server column
 * @method     ChildAuctionAggregates|null findOneByLow(int $low) Return the first ChildAuctionAggregates filtered by the low column
 * @method     ChildAuctionAggregates|null findOneByMean(double $mean) Return the first ChildAuctionAggregates filtered by the mean column
 * @method     ChildAuctionAggregates|null findOneByMedian(double $median) Return the first ChildAuctionAggregates filtered by the median column
 * @method     ChildAuctionAggregates|null findOneByCount(int $count) Return the first ChildAuctionAggregates filtered by the count column
 * @method     ChildAuctionAggregates|null findOneByInserted(string $inserted) Return the first ChildAuctionAggregates filtered by the inserted column *

 * @method     ChildAuctionAggregates requirePk($key, ConnectionInterface $con = null) Return the ChildAuctionAggregates by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionAggregates requireOne(ConnectionInterface $con = null) Return the first ChildAuctionAggregates matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAuctionAggregates requireOneByItemDef(string $item_def) Return the first ChildAuctionAggregates filtered by the item_def column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionAggregates requireOneByServer(string $server) Return the first ChildAuctionAggregates filtered by the server column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionAggregates requireOneByLow(int $low) Return the first ChildAuctionAggregates filtered by the low column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionAggregates requireOneByMean(double $mean) Return the first ChildAuctionAggregates filtered by the mean column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionAggregates requireOneByMedian(double $median) Return the first ChildAuctionAggregates filtered by the median column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionAggregates requireOneByCount(int $count) Return the first ChildAuctionAggregates filtered by the count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionAggregates requireOneByInserted(string $inserted) Return the first ChildAuctionAggregates filtered by the inserted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAuctionAggregates[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAuctionAggregates objects based on current ModelCriteria
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionAggregates> find(ConnectionInterface $con = null) Return ChildAuctionAggregates objects based on current ModelCriteria
 * @method     ChildAuctionAggregates[]|ObjectCollection findByItemDef(string $item_def) Return ChildAuctionAggregates objects filtered by the item_def column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionAggregates> findByItemDef(string $item_def) Return ChildAuctionAggregates objects filtered by the item_def column
 * @method     ChildAuctionAggregates[]|ObjectCollection findByServer(string $server) Return ChildAuctionAggregates objects filtered by the server column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionAggregates> findByServer(string $server) Return ChildAuctionAggregates objects filtered by the server column
 * @method     ChildAuctionAggregates[]|ObjectCollection findByLow(int $low) Return ChildAuctionAggregates objects filtered by the low column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionAggregates> findByLow(int $low) Return ChildAuctionAggregates objects filtered by the low column
 * @method     ChildAuctionAggregates[]|ObjectCollection findByMean(double $mean) Return ChildAuctionAggregates objects filtered by the mean column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionAggregates> findByMean(double $mean) Return ChildAuctionAggregates objects filtered by the mean column
 * @method     ChildAuctionAggregates[]|ObjectCollection findByMedian(double $median) Return ChildAuctionAggregates objects filtered by the median column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionAggregates> findByMedian(double $median) Return ChildAuctionAggregates objects filtered by the median column
 * @method     ChildAuctionAggregates[]|ObjectCollection findByCount(int $count) Return ChildAuctionAggregates objects filtered by the count column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionAggregates> findByCount(int $count) Return ChildAuctionAggregates objects filtered by the count column
 * @method     ChildAuctionAggregates[]|ObjectCollection findByInserted(string $inserted) Return ChildAuctionAggregates objects filtered by the inserted column
 * @psalm-method ObjectCollection&\Traversable<ChildAuctionAggregates> findByInserted(string $inserted) Return ChildAuctionAggregates objects filtered by the inserted column
 * @method     ChildAuctionAggregates[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildAuctionAggregates> paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AuctionAggregatesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Schema\Crawl\AuctionAggregates\Base\AuctionAggregatesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'crawl', $modelName = '\\App\\Schema\\Crawl\\AuctionAggregates\\AuctionAggregates', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAuctionAggregatesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAuctionAggregatesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAuctionAggregates|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        throw new LogicException('The AuctionAggregates object has no primary key');
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
        throw new LogicException('The AuctionAggregates object has no primary key');
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildAuctionAggregatesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        throw new LogicException('The AuctionAggregates object has no primary key');
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAuctionAggregatesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        throw new LogicException('The AuctionAggregates object has no primary key');
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
     * @return $this|ChildAuctionAggregatesQuery The current query, for fluid interface
     */
    public function filterByItemDef($itemDef = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemDef)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuctionAggregatesTableMap::COL_ITEM_DEF, $itemDef, $comparison);
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
     * @return $this|ChildAuctionAggregatesQuery The current query, for fluid interface
     */
    public function filterByServer($server = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($server)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuctionAggregatesTableMap::COL_SERVER, $server, $comparison);
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
     * @param     mixed $low The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuctionAggregatesQuery The current query, for fluid interface
     */
    public function filterByLow($low = null, $comparison = null)
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

        return $this->addUsingAlias(AuctionAggregatesTableMap::COL_LOW, $low, $comparison);
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
     * @param     mixed $mean The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuctionAggregatesQuery The current query, for fluid interface
     */
    public function filterByMean($mean = null, $comparison = null)
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

        return $this->addUsingAlias(AuctionAggregatesTableMap::COL_MEAN, $mean, $comparison);
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
     * @param     mixed $median The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuctionAggregatesQuery The current query, for fluid interface
     */
    public function filterByMedian($median = null, $comparison = null)
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

        return $this->addUsingAlias(AuctionAggregatesTableMap::COL_MEDIAN, $median, $comparison);
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
     * @param     mixed $count The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuctionAggregatesQuery The current query, for fluid interface
     */
    public function filterByCount($count = null, $comparison = null)
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

        return $this->addUsingAlias(AuctionAggregatesTableMap::COL_COUNT, $count, $comparison);
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
     * @param     mixed $inserted The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuctionAggregatesQuery The current query, for fluid interface
     */
    public function filterByInserted($inserted = null, $comparison = null)
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

        return $this->addUsingAlias(AuctionAggregatesTableMap::COL_INSERTED, $inserted, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAuctionAggregates $auctionAggregates Object to remove from the list of results
     *
     * @return $this|ChildAuctionAggregatesQuery The current query, for fluid interface
     */
    public function prune($auctionAggregates = null)
    {
        if ($auctionAggregates) {
            throw new LogicException('AuctionAggregates object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the auction_aggregates table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
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
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
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

} // AuctionAggregatesQuery
