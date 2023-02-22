<?php

namespace App\Schema\Crawl\AuctionCrawlLog\Base;

use \Exception;
use \PDO;
use App\Schema\Crawl\AuctionCrawlLog\AuctionCrawlLog as ChildAuctionCrawlLog;
use App\Schema\Crawl\AuctionCrawlLog\AuctionCrawlLogQuery as ChildAuctionCrawlLogQuery;
use App\Schema\Crawl\AuctionCrawlLog\Map\AuctionCrawlLogTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'auction_crawl_log' table.
 *
 *
 *
 * @method     ChildAuctionCrawlLogQuery orderByItemDef($order = Criteria::ASC) Order by the item_def column
 * @method     ChildAuctionCrawlLogQuery orderByCharacterName($order = Criteria::ASC) Order by the character_name column
 * @method     ChildAuctionCrawlLogQuery orderByAccountName($order = Criteria::ASC) Order by the account_name column
 * @method     ChildAuctionCrawlLogQuery orderByItemCount($order = Criteria::ASC) Order by the item_count column
 *
 * @method     ChildAuctionCrawlLogQuery groupByItemDef() Group by the item_def column
 * @method     ChildAuctionCrawlLogQuery groupByCharacterName() Group by the character_name column
 * @method     ChildAuctionCrawlLogQuery groupByAccountName() Group by the account_name column
 * @method     ChildAuctionCrawlLogQuery groupByItemCount() Group by the item_count column
 *
 * @method     ChildAuctionCrawlLogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAuctionCrawlLogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAuctionCrawlLogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAuctionCrawlLogQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAuctionCrawlLogQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAuctionCrawlLogQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAuctionCrawlLog|null findOne(?ConnectionInterface $con = null) Return the first ChildAuctionCrawlLog matching the query
 * @method     ChildAuctionCrawlLog findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildAuctionCrawlLog matching the query, or a new ChildAuctionCrawlLog object populated from the query conditions when no match is found
 *
 * @method     ChildAuctionCrawlLog|null findOneByItemDef(string $item_def) Return the first ChildAuctionCrawlLog filtered by the item_def column
 * @method     ChildAuctionCrawlLog|null findOneByCharacterName(string $character_name) Return the first ChildAuctionCrawlLog filtered by the character_name column
 * @method     ChildAuctionCrawlLog|null findOneByAccountName(string $account_name) Return the first ChildAuctionCrawlLog filtered by the account_name column
 * @method     ChildAuctionCrawlLog|null findOneByItemCount(int $item_count) Return the first ChildAuctionCrawlLog filtered by the item_count column *

 * @method     ChildAuctionCrawlLog requirePk($key, ?ConnectionInterface $con = null) Return the ChildAuctionCrawlLog by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionCrawlLog requireOne(?ConnectionInterface $con = null) Return the first ChildAuctionCrawlLog matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAuctionCrawlLog requireOneByItemDef(string $item_def) Return the first ChildAuctionCrawlLog filtered by the item_def column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionCrawlLog requireOneByCharacterName(string $character_name) Return the first ChildAuctionCrawlLog filtered by the character_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionCrawlLog requireOneByAccountName(string $account_name) Return the first ChildAuctionCrawlLog filtered by the account_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuctionCrawlLog requireOneByItemCount(int $item_count) Return the first ChildAuctionCrawlLog filtered by the item_count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAuctionCrawlLog[]|Collection find(?ConnectionInterface $con = null) Return ChildAuctionCrawlLog objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildAuctionCrawlLog> find(?ConnectionInterface $con = null) Return ChildAuctionCrawlLog objects based on current ModelCriteria
 * @method     ChildAuctionCrawlLog[]|Collection findByItemDef(string $item_def) Return ChildAuctionCrawlLog objects filtered by the item_def column
 * @psalm-method Collection&\Traversable<ChildAuctionCrawlLog> findByItemDef(string $item_def) Return ChildAuctionCrawlLog objects filtered by the item_def column
 * @method     ChildAuctionCrawlLog[]|Collection findByCharacterName(string $character_name) Return ChildAuctionCrawlLog objects filtered by the character_name column
 * @psalm-method Collection&\Traversable<ChildAuctionCrawlLog> findByCharacterName(string $character_name) Return ChildAuctionCrawlLog objects filtered by the character_name column
 * @method     ChildAuctionCrawlLog[]|Collection findByAccountName(string $account_name) Return ChildAuctionCrawlLog objects filtered by the account_name column
 * @psalm-method Collection&\Traversable<ChildAuctionCrawlLog> findByAccountName(string $account_name) Return ChildAuctionCrawlLog objects filtered by the account_name column
 * @method     ChildAuctionCrawlLog[]|Collection findByItemCount(int $item_count) Return ChildAuctionCrawlLog objects filtered by the item_count column
 * @psalm-method Collection&\Traversable<ChildAuctionCrawlLog> findByItemCount(int $item_count) Return ChildAuctionCrawlLog objects filtered by the item_count column
 * @method     ChildAuctionCrawlLog[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildAuctionCrawlLog> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AuctionCrawlLogQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Schema\Crawl\AuctionCrawlLog\Base\AuctionCrawlLogQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'crawl', $modelName = '\\App\\Schema\\Crawl\\AuctionCrawlLog\\AuctionCrawlLog', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAuctionCrawlLogQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAuctionCrawlLogQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildAuctionCrawlLogQuery) {
            return $criteria;
        }
        $query = new ChildAuctionCrawlLogQuery();
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
     * @param array[$item_def, $character_name, $account_name] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAuctionCrawlLog|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AuctionCrawlLogTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AuctionCrawlLogTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]))))) {
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
     * @return ChildAuctionCrawlLog A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT item_def, character_name, account_name, item_count FROM auction_crawl_log WHERE item_def = :p0 AND character_name = :p1 AND account_name = :p2';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_STR);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAuctionCrawlLog $obj */
            $obj = new ChildAuctionCrawlLog();
            $obj->hydrate($row);
            AuctionCrawlLogTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
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
     * @return ChildAuctionCrawlLog|array|mixed the result, formatted by the current formatter
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
        $this->addUsingAlias(AuctionCrawlLogTableMap::COL_ITEM_DEF, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AuctionCrawlLogTableMap::COL_CHARACTER_NAME, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(AuctionCrawlLogTableMap::COL_ACCOUNT_NAME, $key[2], Criteria::EQUAL);

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
            $cton0 = $this->getNewCriterion(AuctionCrawlLogTableMap::COL_ITEM_DEF, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AuctionCrawlLogTableMap::COL_CHARACTER_NAME, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(AuctionCrawlLogTableMap::COL_ACCOUNT_NAME, $key[2], Criteria::EQUAL);
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

        $this->addUsingAlias(AuctionCrawlLogTableMap::COL_ITEM_DEF, $itemDef, $comparison);

        return $this;
    }

    /**
     * Filter the query on the character_name column
     *
     * Example usage:
     * <code>
     * $query->filterByCharacterName('fooValue');   // WHERE character_name = 'fooValue'
     * $query->filterByCharacterName('%fooValue%', Criteria::LIKE); // WHERE character_name LIKE '%fooValue%'
     * $query->filterByCharacterName(['foo', 'bar']); // WHERE character_name IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $characterName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCharacterName($characterName = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($characterName)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionCrawlLogTableMap::COL_CHARACTER_NAME, $characterName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the account_name column
     *
     * Example usage:
     * <code>
     * $query->filterByAccountName('fooValue');   // WHERE account_name = 'fooValue'
     * $query->filterByAccountName('%fooValue%', Criteria::LIKE); // WHERE account_name LIKE '%fooValue%'
     * $query->filterByAccountName(['foo', 'bar']); // WHERE account_name IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $accountName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByAccountName($accountName = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($accountName)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionCrawlLogTableMap::COL_ACCOUNT_NAME, $accountName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the item_count column
     *
     * Example usage:
     * <code>
     * $query->filterByItemCount(1234); // WHERE item_count = 1234
     * $query->filterByItemCount(array(12, 34)); // WHERE item_count IN (12, 34)
     * $query->filterByItemCount(array('min' => 12)); // WHERE item_count > 12
     * </code>
     *
     * @param mixed $itemCount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByItemCount($itemCount = null, ?string $comparison = null)
    {
        if (is_array($itemCount)) {
            $useMinMax = false;
            if (isset($itemCount['min'])) {
                $this->addUsingAlias(AuctionCrawlLogTableMap::COL_ITEM_COUNT, $itemCount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemCount['max'])) {
                $this->addUsingAlias(AuctionCrawlLogTableMap::COL_ITEM_COUNT, $itemCount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AuctionCrawlLogTableMap::COL_ITEM_COUNT, $itemCount, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param ChildAuctionCrawlLog $auctionCrawlLog Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($auctionCrawlLog = null)
    {
        if ($auctionCrawlLog) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AuctionCrawlLogTableMap::COL_ITEM_DEF), $auctionCrawlLog->getItemDef(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AuctionCrawlLogTableMap::COL_CHARACTER_NAME), $auctionCrawlLog->getCharacterName(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(AuctionCrawlLogTableMap::COL_ACCOUNT_NAME), $auctionCrawlLog->getAccountName(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the auction_crawl_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionCrawlLogTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AuctionCrawlLogTableMap::clearInstancePool();
            AuctionCrawlLogTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AuctionCrawlLogTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AuctionCrawlLogTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AuctionCrawlLogTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AuctionCrawlLogTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
