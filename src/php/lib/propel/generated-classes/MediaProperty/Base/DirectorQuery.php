<?php

namespace MediaProperty\Base;

use \Exception;
use \PDO;
use MediaItem\Movie;
use MediaProperty\Director as ChildDirector;
use MediaProperty\DirectorQuery as ChildDirectorQuery;
use MediaProperty\Map\DirectorTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'director' table.
 *
 *
 *
 * @method     ChildDirectorQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDirectorQuery orderByFirstName($order = Criteria::ASC) Order by the first_name column
 * @method     ChildDirectorQuery orderByLastName($order = Criteria::ASC) Order by the last_name column
 * @method     ChildDirectorQuery orderByDob($order = Criteria::ASC) Order by the dob column
 * @method     ChildDirectorQuery orderByDod($order = Criteria::ASC) Order by the dod column
 *
 * @method     ChildDirectorQuery groupById() Group by the id column
 * @method     ChildDirectorQuery groupByFirstName() Group by the first_name column
 * @method     ChildDirectorQuery groupByLastName() Group by the last_name column
 * @method     ChildDirectorQuery groupByDob() Group by the dob column
 * @method     ChildDirectorQuery groupByDod() Group by the dod column
 *
 * @method     ChildDirectorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDirectorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDirectorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDirectorQuery leftJoinMovie($relationAlias = null) Adds a LEFT JOIN clause to the query using the Movie relation
 * @method     ChildDirectorQuery rightJoinMovie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Movie relation
 * @method     ChildDirectorQuery innerJoinMovie($relationAlias = null) Adds a INNER JOIN clause to the query using the Movie relation
 *
 * @method     ChildDirector findOne(ConnectionInterface $con = null) Return the first ChildDirector matching the query
 * @method     ChildDirector findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDirector matching the query, or a new ChildDirector object populated from the query conditions when no match is found
 *
 * @method     ChildDirector findOneById(int $id) Return the first ChildDirector filtered by the id column
 * @method     ChildDirector findOneByFirstName(string $first_name) Return the first ChildDirector filtered by the first_name column
 * @method     ChildDirector findOneByLastName(string $last_name) Return the first ChildDirector filtered by the last_name column
 * @method     ChildDirector findOneByDob(string $dob) Return the first ChildDirector filtered by the dob column
 * @method     ChildDirector findOneByDod(string $dod) Return the first ChildDirector filtered by the dod column
 *
 * @method     array findById(int $id) Return ChildDirector objects filtered by the id column
 * @method     array findByFirstName(string $first_name) Return ChildDirector objects filtered by the first_name column
 * @method     array findByLastName(string $last_name) Return ChildDirector objects filtered by the last_name column
 * @method     array findByDob(string $dob) Return ChildDirector objects filtered by the dob column
 * @method     array findByDod(string $dod) Return ChildDirector objects filtered by the dod column
 *
 */
abstract class DirectorQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \MediaProperty\Base\DirectorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'fscatalog2', $modelName = '\\MediaProperty\\Director', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDirectorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDirectorQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MediaProperty\DirectorQuery) {
            return $criteria;
        }
        $query = new \MediaProperty\DirectorQuery();
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
     * @return ChildDirector|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DirectorTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DirectorTableMap::DATABASE_NAME);
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
     * @return   ChildDirector A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, FIRST_NAME, LAST_NAME, DOB, DOD FROM director WHERE ID = :p0';
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
            $obj = new ChildDirector();
            $obj->hydrate($row);
            DirectorTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildDirector|array|mixed the result, formatted by the current formatter
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
     * @return ChildDirectorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DirectorTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildDirectorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DirectorTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildDirectorQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DirectorTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DirectorTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DirectorTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the first_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstName('fooValue');   // WHERE first_name = 'fooValue'
     * $query->filterByFirstName('%fooValue%'); // WHERE first_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDirectorQuery The current query, for fluid interface
     */
    public function filterByFirstName($firstName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $firstName)) {
                $firstName = str_replace('*', '%', $firstName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DirectorTableMap::FIRST_NAME, $firstName, $comparison);
    }

    /**
     * Filter the query on the last_name column
     *
     * Example usage:
     * <code>
     * $query->filterByLastName('fooValue');   // WHERE last_name = 'fooValue'
     * $query->filterByLastName('%fooValue%'); // WHERE last_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDirectorQuery The current query, for fluid interface
     */
    public function filterByLastName($lastName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lastName)) {
                $lastName = str_replace('*', '%', $lastName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DirectorTableMap::LAST_NAME, $lastName, $comparison);
    }

    /**
     * Filter the query on the dob column
     *
     * Example usage:
     * <code>
     * $query->filterByDob('fooValue');   // WHERE dob = 'fooValue'
     * $query->filterByDob('%fooValue%'); // WHERE dob LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dob The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDirectorQuery The current query, for fluid interface
     */
    public function filterByDob($dob = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dob)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $dob)) {
                $dob = str_replace('*', '%', $dob);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DirectorTableMap::DOB, $dob, $comparison);
    }

    /**
     * Filter the query on the dod column
     *
     * Example usage:
     * <code>
     * $query->filterByDod('fooValue');   // WHERE dod = 'fooValue'
     * $query->filterByDod('%fooValue%'); // WHERE dod LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dod The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDirectorQuery The current query, for fluid interface
     */
    public function filterByDod($dod = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dod)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $dod)) {
                $dod = str_replace('*', '%', $dod);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DirectorTableMap::DOD, $dod, $comparison);
    }

    /**
     * Filter the query by a related \MediaItem\Movie object
     *
     * @param \MediaItem\Movie|ObjectCollection $movie  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDirectorQuery The current query, for fluid interface
     */
    public function filterByMovie($movie, $comparison = null)
    {
        if ($movie instanceof \MediaItem\Movie) {
            return $this
                ->addUsingAlias(DirectorTableMap::ID, $movie->getDirectorId(), $comparison);
        } elseif ($movie instanceof ObjectCollection) {
            return $this
                ->useMovieQuery()
                ->filterByPrimaryKeys($movie->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMovie() only accepts arguments of type \MediaItem\Movie or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Movie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildDirectorQuery The current query, for fluid interface
     */
    public function joinMovie($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Movie');

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
            $this->addJoinObject($join, 'Movie');
        }

        return $this;
    }

    /**
     * Use the Movie relation Movie object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MediaItem\MovieQuery A secondary query class using the current class as primary query
     */
    public function useMovieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMovie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Movie', '\MediaItem\MovieQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDirector $director Object to remove from the list of results
     *
     * @return ChildDirectorQuery The current query, for fluid interface
     */
    public function prune($director = null)
    {
        if ($director) {
            $this->addUsingAlias(DirectorTableMap::ID, $director->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the director table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DirectorTableMap::DATABASE_NAME);
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
            DirectorTableMap::clearInstancePool();
            DirectorTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildDirector or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildDirector object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DirectorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DirectorTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        DirectorTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DirectorTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // DirectorQuery
