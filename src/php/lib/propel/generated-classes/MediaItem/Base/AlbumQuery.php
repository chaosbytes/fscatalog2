<?php

namespace MediaItem\Base;

use \Exception;
use \PDO;
use MediaItem\Album as ChildAlbum;
use MediaItem\AlbumQuery as ChildAlbumQuery;
use MediaItem\Map\AlbumTableMap;
use MediaProperty\Artist;
use MediaProperty\Label;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'album' table.
 *
 *
 *
 * @method     ChildAlbumQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAlbumQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildAlbumQuery orderByScore($order = Criteria::ASC) Order by the score column
 * @method     ChildAlbumQuery orderByReleaseDate($order = Criteria::ASC) Order by the release_date column
 * @method     ChildAlbumQuery orderBySongs($order = Criteria::ASC) Order by the songs column
 * @method     ChildAlbumQuery orderByArtistId($order = Criteria::ASC) Order by the artist_id column
 * @method     ChildAlbumQuery orderByLabelId($order = Criteria::ASC) Order by the label_id column
 * @method     ChildAlbumQuery orderByExplicit($order = Criteria::ASC) Order by the explicit column
 * @method     ChildAlbumQuery orderByCover($order = Criteria::ASC) Order by the cover column
 *
 * @method     ChildAlbumQuery groupById() Group by the id column
 * @method     ChildAlbumQuery groupByTitle() Group by the title column
 * @method     ChildAlbumQuery groupByScore() Group by the score column
 * @method     ChildAlbumQuery groupByReleaseDate() Group by the release_date column
 * @method     ChildAlbumQuery groupBySongs() Group by the songs column
 * @method     ChildAlbumQuery groupByArtistId() Group by the artist_id column
 * @method     ChildAlbumQuery groupByLabelId() Group by the label_id column
 * @method     ChildAlbumQuery groupByExplicit() Group by the explicit column
 * @method     ChildAlbumQuery groupByCover() Group by the cover column
 *
 * @method     ChildAlbumQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAlbumQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAlbumQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAlbumQuery leftJoinArtist($relationAlias = null) Adds a LEFT JOIN clause to the query using the Artist relation
 * @method     ChildAlbumQuery rightJoinArtist($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Artist relation
 * @method     ChildAlbumQuery innerJoinArtist($relationAlias = null) Adds a INNER JOIN clause to the query using the Artist relation
 *
 * @method     ChildAlbumQuery leftJoinLabel($relationAlias = null) Adds a LEFT JOIN clause to the query using the Label relation
 * @method     ChildAlbumQuery rightJoinLabel($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Label relation
 * @method     ChildAlbumQuery innerJoinLabel($relationAlias = null) Adds a INNER JOIN clause to the query using the Label relation
 *
 * @method     ChildAlbum findOne(ConnectionInterface $con = null) Return the first ChildAlbum matching the query
 * @method     ChildAlbum findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAlbum matching the query, or a new ChildAlbum object populated from the query conditions when no match is found
 *
 * @method     ChildAlbum findOneById(int $id) Return the first ChildAlbum filtered by the id column
 * @method     ChildAlbum findOneByTitle(string $title) Return the first ChildAlbum filtered by the title column
 * @method     ChildAlbum findOneByScore(double $score) Return the first ChildAlbum filtered by the score column
 * @method     ChildAlbum findOneByReleaseDate(string $release_date) Return the first ChildAlbum filtered by the release_date column
 * @method     ChildAlbum findOneBySongs(string $songs) Return the first ChildAlbum filtered by the songs column
 * @method     ChildAlbum findOneByArtistId(int $artist_id) Return the first ChildAlbum filtered by the artist_id column
 * @method     ChildAlbum findOneByLabelId(int $label_id) Return the first ChildAlbum filtered by the label_id column
 * @method     ChildAlbum findOneByExplicit(boolean $explicit) Return the first ChildAlbum filtered by the explicit column
 * @method     ChildAlbum findOneByCover(string $cover) Return the first ChildAlbum filtered by the cover column
 *
 * @method     array findById(int $id) Return ChildAlbum objects filtered by the id column
 * @method     array findByTitle(string $title) Return ChildAlbum objects filtered by the title column
 * @method     array findByScore(double $score) Return ChildAlbum objects filtered by the score column
 * @method     array findByReleaseDate(string $release_date) Return ChildAlbum objects filtered by the release_date column
 * @method     array findBySongs(string $songs) Return ChildAlbum objects filtered by the songs column
 * @method     array findByArtistId(int $artist_id) Return ChildAlbum objects filtered by the artist_id column
 * @method     array findByLabelId(int $label_id) Return ChildAlbum objects filtered by the label_id column
 * @method     array findByExplicit(boolean $explicit) Return ChildAlbum objects filtered by the explicit column
 * @method     array findByCover(string $cover) Return ChildAlbum objects filtered by the cover column
 *
 */
abstract class AlbumQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \MediaItem\Base\AlbumQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'fscatalog2', $modelName = '\\MediaItem\\Album', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAlbumQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAlbumQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MediaItem\AlbumQuery) {
            return $criteria;
        }
        $query = new \MediaItem\AlbumQuery();
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
     * @return ChildAlbum|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AlbumTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AlbumTableMap::DATABASE_NAME);
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
     * @return   ChildAlbum A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, TITLE, SCORE, RELEASE_DATE, SONGS, ARTIST_ID, LABEL_ID, EXPLICIT, COVER FROM album WHERE ID = :p0';
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
            $obj = new ChildAlbum();
            $obj->hydrate($row);
            AlbumTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAlbum|array|mixed the result, formatted by the current formatter
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
     * @return ChildAlbumQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AlbumTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildAlbumQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AlbumTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildAlbumQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AlbumTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AlbumTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbumTableMap::ID, $id, $comparison);
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
     * @return ChildAlbumQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AlbumTableMap::TITLE, $title, $comparison);
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
     * @return ChildAlbumQuery The current query, for fluid interface
     */
    public function filterByScore($score = null, $comparison = null)
    {
        if (is_array($score)) {
            $useMinMax = false;
            if (isset($score['min'])) {
                $this->addUsingAlias(AlbumTableMap::SCORE, $score['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($score['max'])) {
                $this->addUsingAlias(AlbumTableMap::SCORE, $score['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbumTableMap::SCORE, $score, $comparison);
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
     * @return ChildAlbumQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AlbumTableMap::RELEASE_DATE, $releaseDate, $comparison);
    }

    /**
     * Filter the query on the songs column
     *
     * Example usage:
     * <code>
     * $query->filterBySongs('fooValue');   // WHERE songs = 'fooValue'
     * $query->filterBySongs('%fooValue%'); // WHERE songs LIKE '%fooValue%'
     * </code>
     *
     * @param     string $songs The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAlbumQuery The current query, for fluid interface
     */
    public function filterBySongs($songs = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($songs)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $songs)) {
                $songs = str_replace('*', '%', $songs);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AlbumTableMap::SONGS, $songs, $comparison);
    }

    /**
     * Filter the query on the artist_id column
     *
     * Example usage:
     * <code>
     * $query->filterByArtistId(1234); // WHERE artist_id = 1234
     * $query->filterByArtistId(array(12, 34)); // WHERE artist_id IN (12, 34)
     * $query->filterByArtistId(array('min' => 12)); // WHERE artist_id > 12
     * </code>
     *
     * @see       filterByArtist()
     *
     * @param     mixed $artistId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAlbumQuery The current query, for fluid interface
     */
    public function filterByArtistId($artistId = null, $comparison = null)
    {
        if (is_array($artistId)) {
            $useMinMax = false;
            if (isset($artistId['min'])) {
                $this->addUsingAlias(AlbumTableMap::ARTIST_ID, $artistId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($artistId['max'])) {
                $this->addUsingAlias(AlbumTableMap::ARTIST_ID, $artistId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbumTableMap::ARTIST_ID, $artistId, $comparison);
    }

    /**
     * Filter the query on the label_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLabelId(1234); // WHERE label_id = 1234
     * $query->filterByLabelId(array(12, 34)); // WHERE label_id IN (12, 34)
     * $query->filterByLabelId(array('min' => 12)); // WHERE label_id > 12
     * </code>
     *
     * @see       filterByLabel()
     *
     * @param     mixed $labelId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAlbumQuery The current query, for fluid interface
     */
    public function filterByLabelId($labelId = null, $comparison = null)
    {
        if (is_array($labelId)) {
            $useMinMax = false;
            if (isset($labelId['min'])) {
                $this->addUsingAlias(AlbumTableMap::LABEL_ID, $labelId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($labelId['max'])) {
                $this->addUsingAlias(AlbumTableMap::LABEL_ID, $labelId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbumTableMap::LABEL_ID, $labelId, $comparison);
    }

    /**
     * Filter the query on the explicit column
     *
     * Example usage:
     * <code>
     * $query->filterByExplicit(true); // WHERE explicit = true
     * $query->filterByExplicit('yes'); // WHERE explicit = true
     * </code>
     *
     * @param     boolean|string $explicit The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAlbumQuery The current query, for fluid interface
     */
    public function filterByExplicit($explicit = null, $comparison = null)
    {
        if (is_string($explicit)) {
            $explicit = in_array(strtolower($explicit), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AlbumTableMap::EXPLICIT, $explicit, $comparison);
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
     * @return ChildAlbumQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AlbumTableMap::COVER, $cover, $comparison);
    }

    /**
     * Filter the query by a related \MediaProperty\Artist object
     *
     * @param \MediaProperty\Artist|ObjectCollection $artist The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAlbumQuery The current query, for fluid interface
     */
    public function filterByArtist($artist, $comparison = null)
    {
        if ($artist instanceof \MediaProperty\Artist) {
            return $this
                ->addUsingAlias(AlbumTableMap::ARTIST_ID, $artist->getId(), $comparison);
        } elseif ($artist instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AlbumTableMap::ARTIST_ID, $artist->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildAlbumQuery The current query, for fluid interface
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
     * Filter the query by a related \MediaProperty\Label object
     *
     * @param \MediaProperty\Label|ObjectCollection $label The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAlbumQuery The current query, for fluid interface
     */
    public function filterByLabel($label, $comparison = null)
    {
        if ($label instanceof \MediaProperty\Label) {
            return $this
                ->addUsingAlias(AlbumTableMap::LABEL_ID, $label->getId(), $comparison);
        } elseif ($label instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AlbumTableMap::LABEL_ID, $label->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByLabel() only accepts arguments of type \MediaProperty\Label or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Label relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildAlbumQuery The current query, for fluid interface
     */
    public function joinLabel($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Label');

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
            $this->addJoinObject($join, 'Label');
        }

        return $this;
    }

    /**
     * Use the Label relation Label object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MediaProperty\LabelQuery A secondary query class using the current class as primary query
     */
    public function useLabelQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLabel($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Label', '\MediaProperty\LabelQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAlbum $album Object to remove from the list of results
     *
     * @return ChildAlbumQuery The current query, for fluid interface
     */
    public function prune($album = null)
    {
        if ($album) {
            $this->addUsingAlias(AlbumTableMap::ID, $album->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the album table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AlbumTableMap::DATABASE_NAME);
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
            AlbumTableMap::clearInstancePool();
            AlbumTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildAlbum or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildAlbum object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AlbumTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AlbumTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        AlbumTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AlbumTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // AlbumQuery
