<?php

namespace MediaItem\Base;

use \Exception;
use \PDO;
use MediaItem\Game as ChildGame;
use MediaItem\GameQuery as ChildGameQuery;
use MediaItem\Map\GameTableMap;
use MediaProperty\Developer;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'game' table.
 *
 *
 *
 * @method     ChildGameQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGameQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildGameQuery orderByRating($order = Criteria::ASC) Order by the rating column
 * @method     ChildGameQuery orderByScore($order = Criteria::ASC) Order by the score column
 * @method     ChildGameQuery orderByReleaseDate($order = Criteria::ASC) Order by the release_date column
 * @method     ChildGameQuery orderBySystems($order = Criteria::ASC) Order by the systems column
 * @method     ChildGameQuery orderByCover($order = Criteria::ASC) Order by the cover column
 * @method     ChildGameQuery orderByGameDeveloperId($order = Criteria::ASC) Order by the game_developer_id column
 *
 * @method     ChildGameQuery groupById() Group by the id column
 * @method     ChildGameQuery groupByTitle() Group by the title column
 * @method     ChildGameQuery groupByRating() Group by the rating column
 * @method     ChildGameQuery groupByScore() Group by the score column
 * @method     ChildGameQuery groupByReleaseDate() Group by the release_date column
 * @method     ChildGameQuery groupBySystems() Group by the systems column
 * @method     ChildGameQuery groupByCover() Group by the cover column
 * @method     ChildGameQuery groupByGameDeveloperId() Group by the game_developer_id column
 *
 * @method     ChildGameQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGameQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGameQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGameQuery leftJoinDeveloper($relationAlias = null) Adds a LEFT JOIN clause to the query using the Developer relation
 * @method     ChildGameQuery rightJoinDeveloper($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Developer relation
 * @method     ChildGameQuery innerJoinDeveloper($relationAlias = null) Adds a INNER JOIN clause to the query using the Developer relation
 *
 * @method     ChildGame findOne(ConnectionInterface $con = null) Return the first ChildGame matching the query
 * @method     ChildGame findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGame matching the query, or a new ChildGame object populated from the query conditions when no match is found
 *
 * @method     ChildGame findOneById(int $id) Return the first ChildGame filtered by the id column
 * @method     ChildGame findOneByTitle(string $title) Return the first ChildGame filtered by the title column
 * @method     ChildGame findOneByRating(string $rating) Return the first ChildGame filtered by the rating column
 * @method     ChildGame findOneByScore(double $score) Return the first ChildGame filtered by the score column
 * @method     ChildGame findOneByReleaseDate(string $release_date) Return the first ChildGame filtered by the release_date column
 * @method     ChildGame findOneBySystems(string $systems) Return the first ChildGame filtered by the systems column
 * @method     ChildGame findOneByCover(string $cover) Return the first ChildGame filtered by the cover column
 * @method     ChildGame findOneByGameDeveloperId(int $game_developer_id) Return the first ChildGame filtered by the game_developer_id column
 *
 * @method     array findById(int $id) Return ChildGame objects filtered by the id column
 * @method     array findByTitle(string $title) Return ChildGame objects filtered by the title column
 * @method     array findByRating(string $rating) Return ChildGame objects filtered by the rating column
 * @method     array findByScore(double $score) Return ChildGame objects filtered by the score column
 * @method     array findByReleaseDate(string $release_date) Return ChildGame objects filtered by the release_date column
 * @method     array findBySystems(string $systems) Return ChildGame objects filtered by the systems column
 * @method     array findByCover(string $cover) Return ChildGame objects filtered by the cover column
 * @method     array findByGameDeveloperId(int $game_developer_id) Return ChildGame objects filtered by the game_developer_id column
 *
 */
abstract class GameQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \MediaItem\Base\GameQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'fscatalog2', $modelName = '\\MediaItem\\Game', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGameQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGameQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MediaItem\GameQuery) {
            return $criteria;
        }
        $query = new \MediaItem\GameQuery();
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
     * @return ChildGame|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GameTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GameTableMap::DATABASE_NAME);
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
     * @return   ChildGame A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, TITLE, RATING, SCORE, RELEASE_DATE, SYSTEMS, COVER, GAME_DEVELOPER_ID FROM game WHERE ID = :p0';
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
            $obj = new ChildGame();
            $obj->hydrate($row);
            GameTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildGame|array|mixed the result, formatted by the current formatter
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
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GameTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GameTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GameTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GameTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::ID, $id, $comparison);
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
     * @return ChildGameQuery The current query, for fluid interface
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

        return $this->addUsingAlias(GameTableMap::TITLE, $title, $comparison);
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
     * @return ChildGameQuery The current query, for fluid interface
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

        return $this->addUsingAlias(GameTableMap::RATING, $rating, $comparison);
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
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByScore($score = null, $comparison = null)
    {
        if (is_array($score)) {
            $useMinMax = false;
            if (isset($score['min'])) {
                $this->addUsingAlias(GameTableMap::SCORE, $score['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($score['max'])) {
                $this->addUsingAlias(GameTableMap::SCORE, $score['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::SCORE, $score, $comparison);
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
     * @return ChildGameQuery The current query, for fluid interface
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

        return $this->addUsingAlias(GameTableMap::RELEASE_DATE, $releaseDate, $comparison);
    }

    /**
     * Filter the query on the systems column
     *
     * Example usage:
     * <code>
     * $query->filterBySystems('fooValue');   // WHERE systems = 'fooValue'
     * $query->filterBySystems('%fooValue%'); // WHERE systems LIKE '%fooValue%'
     * </code>
     *
     * @param     string $systems The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterBySystems($systems = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($systems)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $systems)) {
                $systems = str_replace('*', '%', $systems);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(GameTableMap::SYSTEMS, $systems, $comparison);
    }

    /**
     * Filter the query on the cover column
     *
     * Example usage:
     * <code>
     * $query->filterByCover('fooValue');   // WHERE cover = 'fooValue'
     * $query->filterByCover('%fooValue%'); // WHERE cover LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cover The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByCover($cover = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cover)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cover)) {
                $cover = str_replace('*', '%', $cover);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(GameTableMap::COVER, $cover, $comparison);
    }

    /**
     * Filter the query on the game_developer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByGameDeveloperId(1234); // WHERE game_developer_id = 1234
     * $query->filterByGameDeveloperId(array(12, 34)); // WHERE game_developer_id IN (12, 34)
     * $query->filterByGameDeveloperId(array('min' => 12)); // WHERE game_developer_id > 12
     * </code>
     *
     * @see       filterByDeveloper()
     *
     * @param     mixed $gameDeveloperId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByGameDeveloperId($gameDeveloperId = null, $comparison = null)
    {
        if (is_array($gameDeveloperId)) {
            $useMinMax = false;
            if (isset($gameDeveloperId['min'])) {
                $this->addUsingAlias(GameTableMap::GAME_DEVELOPER_ID, $gameDeveloperId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gameDeveloperId['max'])) {
                $this->addUsingAlias(GameTableMap::GAME_DEVELOPER_ID, $gameDeveloperId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::GAME_DEVELOPER_ID, $gameDeveloperId, $comparison);
    }

    /**
     * Filter the query by a related \MediaProperty\Developer object
     *
     * @param \MediaProperty\Developer|ObjectCollection $developer The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByDeveloper($developer, $comparison = null)
    {
        if ($developer instanceof \MediaProperty\Developer) {
            return $this
                ->addUsingAlias(GameTableMap::GAME_DEVELOPER_ID, $developer->getId(), $comparison);
        } elseif ($developer instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GameTableMap::GAME_DEVELOPER_ID, $developer->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByDeveloper() only accepts arguments of type \MediaProperty\Developer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Developer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function joinDeveloper($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Developer');

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
            $this->addJoinObject($join, 'Developer');
        }

        return $this;
    }

    /**
     * Use the Developer relation Developer object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MediaProperty\DeveloperQuery A secondary query class using the current class as primary query
     */
    public function useDeveloperQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDeveloper($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Developer', '\MediaProperty\DeveloperQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGame $game Object to remove from the list of results
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function prune($game = null)
    {
        if ($game) {
            $this->addUsingAlias(GameTableMap::ID, $game->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the game table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
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
            GameTableMap::clearInstancePool();
            GameTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildGame or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildGame object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GameTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        GameTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GameTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // GameQuery
