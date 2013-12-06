<?php

namespace MediaItem\Base;

use \Exception;
use \PDO;
use MediaItem\TVShow as ChildTVShow;
use MediaItem\TVShowQuery as ChildTVShowQuery;
use MediaItem\Map\TVShowTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'tv_show' table.
 *
 *
 *
 * @method     ChildTVShowQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTVShowQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildTVShowQuery orderByRating($order = Criteria::ASC) Order by the rating column
 * @method     ChildTVShowQuery orderByScore($order = Criteria::ASC) Order by the score column
 * @method     ChildTVShowQuery orderBySummary($order = Criteria::ASC) Order by the summary column
 * @method     ChildTVShowQuery orderByFirstAired($order = Criteria::ASC) Order by the first_aired column
 * @method     ChildTVShowQuery orderByNetwork($order = Criteria::ASC) Order by the network column
 * @method     ChildTVShowQuery orderByTimeSlot($order = Criteria::ASC) Order by the time_slot column
 * @method     ChildTVShowQuery orderByActorIds($order = Criteria::ASC) Order by the actor_ids column
 * @method     ChildTVShowQuery orderByPoster($order = Criteria::ASC) Order by the poster column
 * @method     ChildTVShowQuery orderBySeasons($order = Criteria::ASC) Order by the seasons column
 * @method     ChildTVShowQuery orderByEpisodes($order = Criteria::ASC) Order by the episodes column
 *
 * @method     ChildTVShowQuery groupById() Group by the id column
 * @method     ChildTVShowQuery groupByTitle() Group by the title column
 * @method     ChildTVShowQuery groupByRating() Group by the rating column
 * @method     ChildTVShowQuery groupByScore() Group by the score column
 * @method     ChildTVShowQuery groupBySummary() Group by the summary column
 * @method     ChildTVShowQuery groupByFirstAired() Group by the first_aired column
 * @method     ChildTVShowQuery groupByNetwork() Group by the network column
 * @method     ChildTVShowQuery groupByTimeSlot() Group by the time_slot column
 * @method     ChildTVShowQuery groupByActorIds() Group by the actor_ids column
 * @method     ChildTVShowQuery groupByPoster() Group by the poster column
 * @method     ChildTVShowQuery groupBySeasons() Group by the seasons column
 * @method     ChildTVShowQuery groupByEpisodes() Group by the episodes column
 *
 * @method     ChildTVShowQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTVShowQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTVShowQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTVShow findOne(ConnectionInterface $con = null) Return the first ChildTVShow matching the query
 * @method     ChildTVShow findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTVShow matching the query, or a new ChildTVShow object populated from the query conditions when no match is found
 *
 * @method     ChildTVShow findOneById(int $id) Return the first ChildTVShow filtered by the id column
 * @method     ChildTVShow findOneByTitle(string $title) Return the first ChildTVShow filtered by the title column
 * @method     ChildTVShow findOneByRating(string $rating) Return the first ChildTVShow filtered by the rating column
 * @method     ChildTVShow findOneByScore(double $score) Return the first ChildTVShow filtered by the score column
 * @method     ChildTVShow findOneBySummary(string $summary) Return the first ChildTVShow filtered by the summary column
 * @method     ChildTVShow findOneByFirstAired(string $first_aired) Return the first ChildTVShow filtered by the first_aired column
 * @method     ChildTVShow findOneByNetwork(string $network) Return the first ChildTVShow filtered by the network column
 * @method     ChildTVShow findOneByTimeSlot(string $time_slot) Return the first ChildTVShow filtered by the time_slot column
 * @method     ChildTVShow findOneByActorIds(string $actor_ids) Return the first ChildTVShow filtered by the actor_ids column
 * @method     ChildTVShow findOneByPoster(string $poster) Return the first ChildTVShow filtered by the poster column
 * @method     ChildTVShow findOneBySeasons(string $seasons) Return the first ChildTVShow filtered by the seasons column
 * @method     ChildTVShow findOneByEpisodes(string $episodes) Return the first ChildTVShow filtered by the episodes column
 *
 * @method     array findById(int $id) Return ChildTVShow objects filtered by the id column
 * @method     array findByTitle(string $title) Return ChildTVShow objects filtered by the title column
 * @method     array findByRating(string $rating) Return ChildTVShow objects filtered by the rating column
 * @method     array findByScore(double $score) Return ChildTVShow objects filtered by the score column
 * @method     array findBySummary(string $summary) Return ChildTVShow objects filtered by the summary column
 * @method     array findByFirstAired(string $first_aired) Return ChildTVShow objects filtered by the first_aired column
 * @method     array findByNetwork(string $network) Return ChildTVShow objects filtered by the network column
 * @method     array findByTimeSlot(string $time_slot) Return ChildTVShow objects filtered by the time_slot column
 * @method     array findByActorIds(string $actor_ids) Return ChildTVShow objects filtered by the actor_ids column
 * @method     array findByPoster(string $poster) Return ChildTVShow objects filtered by the poster column
 * @method     array findBySeasons(string $seasons) Return ChildTVShow objects filtered by the seasons column
 * @method     array findByEpisodes(string $episodes) Return ChildTVShow objects filtered by the episodes column
 *
 */
abstract class TVShowQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \MediaItem\Base\TVShowQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'fscatalog2', $modelName = '\\MediaItem\\TVShow', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTVShowQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTVShowQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MediaItem\TVShowQuery) {
            return $criteria;
        }
        $query = new \MediaItem\TVShowQuery();
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
     * @return ChildTVShow|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TVShowTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TVShowTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildTVShow A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, TITLE, RATING, SCORE, SUMMARY, FIRST_AIRED, NETWORK, TIME_SLOT, ACTOR_IDS, POSTER, SEASONS, EPISODES FROM tv_show WHERE ID = :p0';
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
            $obj = new ChildTVShow();
            $obj->hydrate($row);
            TVShowTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTVShow|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
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
    public function findPks($keys, $con = null)
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
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TVShowTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TVShowTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TVShowTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TVShowTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TVShowTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TVShowTableMap::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the rating column
     *
     * Example usage:
     * <code>
     * $query->filterByRating('fooValue');   // WHERE rating = 'fooValue'
     * $query->filterByRating('%fooValue%'); // WHERE rating LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rating The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function filterByRating($rating = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rating)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rating)) {
                $rating = str_replace('*', '%', $rating);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TVShowTableMap::RATING, $rating, $comparison);
    }

    /**
     * Filter the query on the score column
     *
     * Example usage:
     * <code>
     * $query->filterByScore(1234); // WHERE score = 1234
     * $query->filterByScore(array(12, 34)); // WHERE score IN (12, 34)
     * $query->filterByScore(array('min' => 12)); // WHERE score > 12
     * </code>
     *
     * @param     mixed $score The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function filterByScore($score = null, $comparison = null)
    {
        if (is_array($score)) {
            $useMinMax = false;
            if (isset($score['min'])) {
                $this->addUsingAlias(TVShowTableMap::SCORE, $score['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($score['max'])) {
                $this->addUsingAlias(TVShowTableMap::SCORE, $score['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TVShowTableMap::SCORE, $score, $comparison);
    }

    /**
     * Filter the query on the summary column
     *
     * Example usage:
     * <code>
     * $query->filterBySummary('fooValue');   // WHERE summary = 'fooValue'
     * $query->filterBySummary('%fooValue%'); // WHERE summary LIKE '%fooValue%'
     * </code>
     *
     * @param     string $summary The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function filterBySummary($summary = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($summary)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $summary)) {
                $summary = str_replace('*', '%', $summary);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TVShowTableMap::SUMMARY, $summary, $comparison);
    }

    /**
     * Filter the query on the first_aired column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstAired('fooValue');   // WHERE first_aired = 'fooValue'
     * $query->filterByFirstAired('%fooValue%'); // WHERE first_aired LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstAired The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function filterByFirstAired($firstAired = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstAired)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $firstAired)) {
                $firstAired = str_replace('*', '%', $firstAired);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TVShowTableMap::FIRST_AIRED, $firstAired, $comparison);
    }

    /**
     * Filter the query on the network column
     *
     * Example usage:
     * <code>
     * $query->filterByNetwork('fooValue');   // WHERE network = 'fooValue'
     * $query->filterByNetwork('%fooValue%'); // WHERE network LIKE '%fooValue%'
     * </code>
     *
     * @param     string $network The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function filterByNetwork($network = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($network)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $network)) {
                $network = str_replace('*', '%', $network);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TVShowTableMap::NETWORK, $network, $comparison);
    }

    /**
     * Filter the query on the time_slot column
     *
     * Example usage:
     * <code>
     * $query->filterByTimeSlot('fooValue');   // WHERE time_slot = 'fooValue'
     * $query->filterByTimeSlot('%fooValue%'); // WHERE time_slot LIKE '%fooValue%'
     * </code>
     *
     * @param     string $timeSlot The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function filterByTimeSlot($timeSlot = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($timeSlot)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $timeSlot)) {
                $timeSlot = str_replace('*', '%', $timeSlot);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TVShowTableMap::TIME_SLOT, $timeSlot, $comparison);
    }

    /**
     * Filter the query on the actor_ids column
     *
     * Example usage:
     * <code>
     * $query->filterByActorIds('fooValue');   // WHERE actor_ids = 'fooValue'
     * $query->filterByActorIds('%fooValue%'); // WHERE actor_ids LIKE '%fooValue%'
     * </code>
     *
     * @param     string $actorIds The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function filterByActorIds($actorIds = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($actorIds)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $actorIds)) {
                $actorIds = str_replace('*', '%', $actorIds);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TVShowTableMap::ACTOR_IDS, $actorIds, $comparison);
    }

    /**
     * Filter the query on the poster column
     *
     * Example usage:
     * <code>
     * $query->filterByPoster('fooValue');   // WHERE poster = 'fooValue'
     * $query->filterByPoster('%fooValue%'); // WHERE poster LIKE '%fooValue%'
     * </code>
     *
     * @param     string $poster The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function filterByPoster($poster = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($poster)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $poster)) {
                $poster = str_replace('*', '%', $poster);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TVShowTableMap::POSTER, $poster, $comparison);
    }

    /**
     * Filter the query on the seasons column
     *
     * Example usage:
     * <code>
     * $query->filterBySeasons('fooValue');   // WHERE seasons = 'fooValue'
     * $query->filterBySeasons('%fooValue%'); // WHERE seasons LIKE '%fooValue%'
     * </code>
     *
     * @param     string $seasons The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function filterBySeasons($seasons = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($seasons)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $seasons)) {
                $seasons = str_replace('*', '%', $seasons);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TVShowTableMap::SEASONS, $seasons, $comparison);
    }

    /**
     * Filter the query on the episodes column
     *
     * Example usage:
     * <code>
     * $query->filterByEpisodes('fooValue');   // WHERE episodes = 'fooValue'
     * $query->filterByEpisodes('%fooValue%'); // WHERE episodes LIKE '%fooValue%'
     * </code>
     *
     * @param     string $episodes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function filterByEpisodes($episodes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($episodes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $episodes)) {
                $episodes = str_replace('*', '%', $episodes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TVShowTableMap::EPISODES, $episodes, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTVShow $tVShow Object to remove from the list of results
     *
     * @return ChildTVShowQuery The current query, for fluid interface
     */
    public function prune($tVShow = null)
    {
        if ($tVShow) {
            $this->addUsingAlias(TVShowTableMap::ID, $tVShow->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the tv_show table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TVShowTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TVShowTableMap::clearInstancePool();
            TVShowTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildTVShow or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildTVShow object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TVShowTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TVShowTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        TVShowTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TVShowTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // TVShowQuery
