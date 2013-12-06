<?php

namespace MediaItem\Base;

use \Exception;
use \PDO;
use MediaItem\Movie as ChildMovie;
use MediaItem\MovieQuery as ChildMovieQuery;
use MediaItem\Map\MovieTableMap;
use MediaProperty\Director;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'movie' table.
 *
 *
 *
 * @method     ChildMovieQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMovieQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildMovieQuery orderByRating($order = Criteria::ASC) Order by the rating column
 * @method     ChildMovieQuery orderByScore($order = Criteria::ASC) Order by the score column
 * @method     ChildMovieQuery orderBySummary($order = Criteria::ASC) Order by the summary column
 * @method     ChildMovieQuery orderByReleaseDate($order = Criteria::ASC) Order by the release_date column
 * @method     ChildMovieQuery orderByDirectorId($order = Criteria::ASC) Order by the director_id column
 * @method     ChildMovieQuery orderByActorIds($order = Criteria::ASC) Order by the actor_ids column
 * @method     ChildMovieQuery orderByPoster($order = Criteria::ASC) Order by the poster column
 *
 * @method     ChildMovieQuery groupById() Group by the id column
 * @method     ChildMovieQuery groupByTitle() Group by the title column
 * @method     ChildMovieQuery groupByRating() Group by the rating column
 * @method     ChildMovieQuery groupByScore() Group by the score column
 * @method     ChildMovieQuery groupBySummary() Group by the summary column
 * @method     ChildMovieQuery groupByReleaseDate() Group by the release_date column
 * @method     ChildMovieQuery groupByDirectorId() Group by the director_id column
 * @method     ChildMovieQuery groupByActorIds() Group by the actor_ids column
 * @method     ChildMovieQuery groupByPoster() Group by the poster column
 *
 * @method     ChildMovieQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMovieQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMovieQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMovieQuery leftJoinDirector($relationAlias = null) Adds a LEFT JOIN clause to the query using the Director relation
 * @method     ChildMovieQuery rightJoinDirector($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Director relation
 * @method     ChildMovieQuery innerJoinDirector($relationAlias = null) Adds a INNER JOIN clause to the query using the Director relation
 *
 * @method     ChildMovie findOne(ConnectionInterface $con = null) Return the first ChildMovie matching the query
 * @method     ChildMovie findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMovie matching the query, or a new ChildMovie object populated from the query conditions when no match is found
 *
 * @method     ChildMovie findOneById(int $id) Return the first ChildMovie filtered by the id column
 * @method     ChildMovie findOneByTitle(string $title) Return the first ChildMovie filtered by the title column
 * @method     ChildMovie findOneByRating(string $rating) Return the first ChildMovie filtered by the rating column
 * @method     ChildMovie findOneByScore(double $score) Return the first ChildMovie filtered by the score column
 * @method     ChildMovie findOneBySummary(string $summary) Return the first ChildMovie filtered by the summary column
 * @method     ChildMovie findOneByReleaseDate(string $release_date) Return the first ChildMovie filtered by the release_date column
 * @method     ChildMovie findOneByDirectorId(int $director_id) Return the first ChildMovie filtered by the director_id column
 * @method     ChildMovie findOneByActorIds(string $actor_ids) Return the first ChildMovie filtered by the actor_ids column
 * @method     ChildMovie findOneByPoster(string $poster) Return the first ChildMovie filtered by the poster column
 *
 * @method     array findById(int $id) Return ChildMovie objects filtered by the id column
 * @method     array findByTitle(string $title) Return ChildMovie objects filtered by the title column
 * @method     array findByRating(string $rating) Return ChildMovie objects filtered by the rating column
 * @method     array findByScore(double $score) Return ChildMovie objects filtered by the score column
 * @method     array findBySummary(string $summary) Return ChildMovie objects filtered by the summary column
 * @method     array findByReleaseDate(string $release_date) Return ChildMovie objects filtered by the release_date column
 * @method     array findByDirectorId(int $director_id) Return ChildMovie objects filtered by the director_id column
 * @method     array findByActorIds(string $actor_ids) Return ChildMovie objects filtered by the actor_ids column
 * @method     array findByPoster(string $poster) Return ChildMovie objects filtered by the poster column
 *
 */
abstract class MovieQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \MediaItem\Base\MovieQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'fscatalog2', $modelName = '\\MediaItem\\Movie', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMovieQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMovieQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MediaItem\MovieQuery) {
            return $criteria;
        }
        $query = new \MediaItem\MovieQuery();
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
     * @return ChildMovie|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MovieTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MovieTableMap::DATABASE_NAME);
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
     * @return   ChildMovie A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, TITLE, RATING, SCORE, SUMMARY, RELEASE_DATE, DIRECTOR_ID, ACTOR_IDS, POSTER FROM movie WHERE ID = :p0';
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
            $obj = new ChildMovie();
            $obj->hydrate($row);
            MovieTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildMovie|array|mixed the result, formatted by the current formatter
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
     * @return ChildMovieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MovieTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildMovieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MovieTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildMovieQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MovieTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MovieTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovieTableMap::ID, $id, $comparison);
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
     * @return ChildMovieQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MovieTableMap::TITLE, $title, $comparison);
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
     * @return ChildMovieQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MovieTableMap::RATING, $rating, $comparison);
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
     * @return ChildMovieQuery The current query, for fluid interface
     */
    public function filterByScore($score = null, $comparison = null)
    {
        if (is_array($score)) {
            $useMinMax = false;
            if (isset($score['min'])) {
                $this->addUsingAlias(MovieTableMap::SCORE, $score['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($score['max'])) {
                $this->addUsingAlias(MovieTableMap::SCORE, $score['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovieTableMap::SCORE, $score, $comparison);
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
     * @return ChildMovieQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MovieTableMap::SUMMARY, $summary, $comparison);
    }

    /**
     * Filter the query on the release_date column
     *
     * Example usage:
     * <code>
     * $query->filterByReleaseDate('fooValue');   // WHERE release_date = 'fooValue'
     * $query->filterByReleaseDate('%fooValue%'); // WHERE release_date LIKE '%fooValue%'
     * </code>
     *
     * @param     string $releaseDate The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMovieQuery The current query, for fluid interface
     */
    public function filterByReleaseDate($releaseDate = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($releaseDate)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $releaseDate)) {
                $releaseDate = str_replace('*', '%', $releaseDate);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MovieTableMap::RELEASE_DATE, $releaseDate, $comparison);
    }

    /**
     * Filter the query on the director_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDirectorId(1234); // WHERE director_id = 1234
     * $query->filterByDirectorId(array(12, 34)); // WHERE director_id IN (12, 34)
     * $query->filterByDirectorId(array('min' => 12)); // WHERE director_id > 12
     * </code>
     *
     * @see       filterByDirector()
     *
     * @param     mixed $directorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMovieQuery The current query, for fluid interface
     */
    public function filterByDirectorId($directorId = null, $comparison = null)
    {
        if (is_array($directorId)) {
            $useMinMax = false;
            if (isset($directorId['min'])) {
                $this->addUsingAlias(MovieTableMap::DIRECTOR_ID, $directorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($directorId['max'])) {
                $this->addUsingAlias(MovieTableMap::DIRECTOR_ID, $directorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovieTableMap::DIRECTOR_ID, $directorId, $comparison);
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
     * @return ChildMovieQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MovieTableMap::ACTOR_IDS, $actorIds, $comparison);
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
     * @return ChildMovieQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MovieTableMap::POSTER, $poster, $comparison);
    }

    /**
     * Filter the query by a related \MediaProperty\Director object
     *
     * @param \MediaProperty\Director|ObjectCollection $director The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMovieQuery The current query, for fluid interface
     */
    public function filterByDirector($director, $comparison = null)
    {
        if ($director instanceof \MediaProperty\Director) {
            return $this
                ->addUsingAlias(MovieTableMap::DIRECTOR_ID, $director->getId(), $comparison);
        } elseif ($director instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MovieTableMap::DIRECTOR_ID, $director->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByDirector() only accepts arguments of type \MediaProperty\Director or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Director relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildMovieQuery The current query, for fluid interface
     */
    public function joinDirector($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Director');

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
            $this->addJoinObject($join, 'Director');
        }

        return $this;
    }

    /**
     * Use the Director relation Director object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MediaProperty\DirectorQuery A secondary query class using the current class as primary query
     */
    public function useDirectorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDirector($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Director', '\MediaProperty\DirectorQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMovie $movie Object to remove from the list of results
     *
     * @return ChildMovieQuery The current query, for fluid interface
     */
    public function prune($movie = null)
    {
        if ($movie) {
            $this->addUsingAlias(MovieTableMap::ID, $movie->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the movie table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MovieTableMap::DATABASE_NAME);
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
            MovieTableMap::clearInstancePool();
            MovieTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildMovie or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildMovie object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MovieTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MovieTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        MovieTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MovieTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // MovieQuery
