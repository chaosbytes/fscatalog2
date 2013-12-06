<?php

namespace MediaProperty\Base;

use \Exception;
use \PDO;
use MediaItem\Album;
use MediaProperty\Label as ChildLabel;
use MediaProperty\LabelQuery as ChildLabelQuery;
use MediaProperty\Map\LabelTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'label' table.
 *
 *
 *
 * @method     ChildLabelQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildLabelQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildLabelQuery groupById() Group by the id column
 * @method     ChildLabelQuery groupByName() Group by the name column
 *
 * @method     ChildLabelQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildLabelQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildLabelQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildLabelQuery leftJoinArtist($relationAlias = null) Adds a LEFT JOIN clause to the query using the Artist relation
 * @method     ChildLabelQuery rightJoinArtist($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Artist relation
 * @method     ChildLabelQuery innerJoinArtist($relationAlias = null) Adds a INNER JOIN clause to the query using the Artist relation
 *
 * @method     ChildLabelQuery leftJoinAlbum($relationAlias = null) Adds a LEFT JOIN clause to the query using the Album relation
 * @method     ChildLabelQuery rightJoinAlbum($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Album relation
 * @method     ChildLabelQuery innerJoinAlbum($relationAlias = null) Adds a INNER JOIN clause to the query using the Album relation
 *
 * @method     ChildLabel findOne(ConnectionInterface $con = null) Return the first ChildLabel matching the query
 * @method     ChildLabel findOneOrCreate(ConnectionInterface $con = null) Return the first ChildLabel matching the query, or a new ChildLabel object populated from the query conditions when no match is found
 *
 * @method     ChildLabel findOneById(int $id) Return the first ChildLabel filtered by the id column
 * @method     ChildLabel findOneByName(string $name) Return the first ChildLabel filtered by the name column
 *
 * @method     array findById(int $id) Return ChildLabel objects filtered by the id column
 * @method     array findByName(string $name) Return ChildLabel objects filtered by the name column
 *
 */
abstract class LabelQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \MediaProperty\Base\LabelQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'fscatalog2', $modelName = '\\MediaProperty\\Label', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLabelQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildLabelQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MediaProperty\LabelQuery) {
            return $criteria;
        }
        $query = new \MediaProperty\LabelQuery();
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
     * @return ChildLabel|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = LabelTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LabelTableMap::DATABASE_NAME);
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
     * @return   ChildLabel A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, NAME FROM label WHERE ID = :p0';
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
            $obj = new ChildLabel();
            $obj->hydrate($row);
            LabelTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildLabel|array|mixed the result, formatted by the current formatter
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
     * @return ChildLabelQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LabelTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildLabelQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LabelTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildLabelQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(LabelTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(LabelTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LabelTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLabelQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LabelTableMap::NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related \MediaProperty\Artist object
     *
     * @param \MediaProperty\Artist|ObjectCollection $artist  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLabelQuery The current query, for fluid interface
     */
    public function filterByArtist($artist, $comparison = null)
    {
        if ($artist instanceof \MediaProperty\Artist) {
            return $this
                ->addUsingAlias(LabelTableMap::ID, $artist->getLabelId(), $comparison);
        } elseif ($artist instanceof ObjectCollection) {
            return $this
                ->useArtistQuery()
                ->filterByPrimaryKeys($artist->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByArtist() only accepts arguments of type \MediaProperty\Artist or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Artist relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildLabelQuery The current query, for fluid interface
     */
    public function joinArtist($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Artist');

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
            $this->addJoinObject($join, 'Artist');
        }

        return $this;
    }

    /**
     * Use the Artist relation Artist object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MediaProperty\ArtistQuery A secondary query class using the current class as primary query
     */
    public function useArtistQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinArtist($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Artist', '\MediaProperty\ArtistQuery');
    }

    /**
     * Filter the query by a related \MediaItem\Album object
     *
     * @param \MediaItem\Album|ObjectCollection $album  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLabelQuery The current query, for fluid interface
     */
    public function filterByAlbum($album, $comparison = null)
    {
        if ($album instanceof \MediaItem\Album) {
            return $this
                ->addUsingAlias(LabelTableMap::ID, $album->getLabelId(), $comparison);
        } elseif ($album instanceof ObjectCollection) {
            return $this
                ->useAlbumQuery()
                ->filterByPrimaryKeys($album->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAlbum() only accepts arguments of type \MediaItem\Album or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Album relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildLabelQuery The current query, for fluid interface
     */
    public function joinAlbum($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Album');

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
            $this->addJoinObject($join, 'Album');
        }

        return $this;
    }

    /**
     * Use the Album relation Album object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MediaItem\AlbumQuery A secondary query class using the current class as primary query
     */
    public function useAlbumQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAlbum($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Album', '\MediaItem\AlbumQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildLabel $label Object to remove from the list of results
     *
     * @return ChildLabelQuery The current query, for fluid interface
     */
    public function prune($label = null)
    {
        if ($label) {
            $this->addUsingAlias(LabelTableMap::ID, $label->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the label table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LabelTableMap::DATABASE_NAME);
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
            LabelTableMap::clearInstancePool();
            LabelTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildLabel or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildLabel object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(LabelTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LabelTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        LabelTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            LabelTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // LabelQuery
