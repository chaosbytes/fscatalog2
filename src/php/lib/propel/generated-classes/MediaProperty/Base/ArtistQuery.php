<?php

namespace MediaProperty\Base;

use \Exception;
use \PDO;
use MediaItem\Album;
use MediaProperty\Artist as ChildArtist;
use MediaProperty\ArtistQuery as ChildArtistQuery;
use MediaProperty\Map\ArtistTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'artist' table.
 *
 *
 *
 * @method     ChildArtistQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildArtistQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildArtistQuery orderByDob($order = Criteria::ASC) Order by the dob column
 * @method     ChildArtistQuery orderByDod($order = Criteria::ASC) Order by the dod column
 * @method     ChildArtistQuery orderByIsband($order = Criteria::ASC) Order by the isBand column
 * @method     ChildArtistQuery orderByDateFormed($order = Criteria::ASC) Order by the date_formed column
 * @method     ChildArtistQuery orderByDateEnded($order = Criteria::ASC) Order by the date_ended column
 * @method     ChildArtistQuery orderByMembers($order = Criteria::ASC) Order by the members column
 * @method     ChildArtistQuery orderByAlbums($order = Criteria::ASC) Order by the albums column
 * @method     ChildArtistQuery orderByLabelId($order = Criteria::ASC) Order by the label_id column
 *
 * @method     ChildArtistQuery groupById() Group by the id column
 * @method     ChildArtistQuery groupByName() Group by the name column
 * @method     ChildArtistQuery groupByDob() Group by the dob column
 * @method     ChildArtistQuery groupByDod() Group by the dod column
 * @method     ChildArtistQuery groupByIsband() Group by the isBand column
 * @method     ChildArtistQuery groupByDateFormed() Group by the date_formed column
 * @method     ChildArtistQuery groupByDateEnded() Group by the date_ended column
 * @method     ChildArtistQuery groupByMembers() Group by the members column
 * @method     ChildArtistQuery groupByAlbums() Group by the albums column
 * @method     ChildArtistQuery groupByLabelId() Group by the label_id column
 *
 * @method     ChildArtistQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildArtistQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildArtistQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildArtistQuery leftJoinLabel($relationAlias = null) Adds a LEFT JOIN clause to the query using the Label relation
 * @method     ChildArtistQuery rightJoinLabel($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Label relation
 * @method     ChildArtistQuery innerJoinLabel($relationAlias = null) Adds a INNER JOIN clause to the query using the Label relation
 *
 * @method     ChildArtistQuery leftJoinAlbum($relationAlias = null) Adds a LEFT JOIN clause to the query using the Album relation
 * @method     ChildArtistQuery rightJoinAlbum($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Album relation
 * @method     ChildArtistQuery innerJoinAlbum($relationAlias = null) Adds a INNER JOIN clause to the query using the Album relation
 *
 * @method     ChildArtist findOne(ConnectionInterface $con = null) Return the first ChildArtist matching the query
 * @method     ChildArtist findOneOrCreate(ConnectionInterface $con = null) Return the first ChildArtist matching the query, or a new ChildArtist object populated from the query conditions when no match is found
 *
 * @method     ChildArtist findOneById(int $id) Return the first ChildArtist filtered by the id column
 * @method     ChildArtist findOneByName(string $name) Return the first ChildArtist filtered by the name column
 * @method     ChildArtist findOneByDob(string $dob) Return the first ChildArtist filtered by the dob column
 * @method     ChildArtist findOneByDod(string $dod) Return the first ChildArtist filtered by the dod column
 * @method     ChildArtist findOneByIsband(boolean $isBand) Return the first ChildArtist filtered by the isBand column
 * @method     ChildArtist findOneByDateFormed(string $date_formed) Return the first ChildArtist filtered by the date_formed column
 * @method     ChildArtist findOneByDateEnded(string $date_ended) Return the first ChildArtist filtered by the date_ended column
 * @method     ChildArtist findOneByMembers(string $members) Return the first ChildArtist filtered by the members column
 * @method     ChildArtist findOneByAlbums(string $albums) Return the first ChildArtist filtered by the albums column
 * @method     ChildArtist findOneByLabelId(int $label_id) Return the first ChildArtist filtered by the label_id column
 *
 * @method     array findById(int $id) Return ChildArtist objects filtered by the id column
 * @method     array findByName(string $name) Return ChildArtist objects filtered by the name column
 * @method     array findByDob(string $dob) Return ChildArtist objects filtered by the dob column
 * @method     array findByDod(string $dod) Return ChildArtist objects filtered by the dod column
 * @method     array findByIsband(boolean $isBand) Return ChildArtist objects filtered by the isBand column
 * @method     array findByDateFormed(string $date_formed) Return ChildArtist objects filtered by the date_formed column
 * @method     array findByDateEnded(string $date_ended) Return ChildArtist objects filtered by the date_ended column
 * @method     array findByMembers(string $members) Return ChildArtist objects filtered by the members column
 * @method     array findByAlbums(string $albums) Return ChildArtist objects filtered by the albums column
 * @method     array findByLabelId(int $label_id) Return ChildArtist objects filtered by the label_id column
 *
 */
abstract class ArtistQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \MediaProperty\Base\ArtistQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'fscatalog2', $modelName = '\\MediaProperty\\Artist', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildArtistQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildArtistQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MediaProperty\ArtistQuery) {
            return $criteria;
        }
        $query = new \MediaProperty\ArtistQuery();
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
     * @return ChildArtist|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ArtistTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ArtistTableMap::DATABASE_NAME);
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
     * @return   ChildArtist A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, NAME, DOB, DOD, ISBAND, DATE_FORMED, DATE_ENDED, MEMBERS, ALBUMS, LABEL_ID FROM artist WHERE ID = :p0';
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
            $obj = new ChildArtist();
            $obj->hydrate($row);
            ArtistTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildArtist|array|mixed the result, formatted by the current formatter
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
     * @return ChildArtistQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ArtistTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildArtistQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ArtistTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildArtistQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ArtistTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ArtistTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArtistTableMap::ID, $id, $comparison);
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
     * @return ChildArtistQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ArtistTableMap::NAME, $name, $comparison);
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
     * @return ChildArtistQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ArtistTableMap::DOB, $dob, $comparison);
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
     * @return ChildArtistQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ArtistTableMap::DOD, $dod, $comparison);
    }

    /**
     * Filter the query on the isBand column
     *
     * Example usage:
     * <code>
     * $query->filterByIsband(true); // WHERE isBand = true
     * $query->filterByIsband('yes'); // WHERE isBand = true
     * </code>
     *
     * @param     boolean|string $isband The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildArtistQuery The current query, for fluid interface
     */
    public function filterByIsband($isband = null, $comparison = null)
    {
        if (is_string($isband)) {
            $isBand = in_array(strtolower($isband), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ArtistTableMap::ISBAND, $isband, $comparison);
    }

    /**
     * Filter the query on the date_formed column
     *
     * Example usage:
     * <code>
     * $query->filterByDateFormed('fooValue');   // WHERE date_formed = 'fooValue'
     * $query->filterByDateFormed('%fooValue%'); // WHERE date_formed LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dateFormed The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildArtistQuery The current query, for fluid interface
     */
    public function filterByDateFormed($dateFormed = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dateFormed)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $dateFormed)) {
                $dateFormed = str_replace('*', '%', $dateFormed);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArtistTableMap::DATE_FORMED, $dateFormed, $comparison);
    }

    /**
     * Filter the query on the date_ended column
     *
     * Example usage:
     * <code>
     * $query->filterByDateEnded('fooValue');   // WHERE date_ended = 'fooValue'
     * $query->filterByDateEnded('%fooValue%'); // WHERE date_ended LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dateEnded The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildArtistQuery The current query, for fluid interface
     */
    public function filterByDateEnded($dateEnded = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dateEnded)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $dateEnded)) {
                $dateEnded = str_replace('*', '%', $dateEnded);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArtistTableMap::DATE_ENDED, $dateEnded, $comparison);
    }

    /**
     * Filter the query on the members column
     *
     * Example usage:
     * <code>
     * $query->filterByMembers('fooValue');   // WHERE members = 'fooValue'
     * $query->filterByMembers('%fooValue%'); // WHERE members LIKE '%fooValue%'
     * </code>
     *
     * @param     string $members The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildArtistQuery The current query, for fluid interface
     */
    public function filterByMembers($members = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($members)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $members)) {
                $members = str_replace('*', '%', $members);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArtistTableMap::MEMBERS, $members, $comparison);
    }

    /**
     * Filter the query on the albums column
     *
     * Example usage:
     * <code>
     * $query->filterByAlbums('fooValue');   // WHERE albums = 'fooValue'
     * $query->filterByAlbums('%fooValue%'); // WHERE albums LIKE '%fooValue%'
     * </code>
     *
     * @param     string $albums The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildArtistQuery The current query, for fluid interface
     */
    public function filterByAlbums($albums = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($albums)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $albums)) {
                $albums = str_replace('*', '%', $albums);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArtistTableMap::ALBUMS, $albums, $comparison);
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
     * @return ChildArtistQuery The current query, for fluid interface
     */
    public function filterByLabelId($labelId = null, $comparison = null)
    {
        if (is_array($labelId)) {
            $useMinMax = false;
            if (isset($labelId['min'])) {
                $this->addUsingAlias(ArtistTableMap::LABEL_ID, $labelId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($labelId['max'])) {
                $this->addUsingAlias(ArtistTableMap::LABEL_ID, $labelId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArtistTableMap::LABEL_ID, $labelId, $comparison);
    }

    /**
     * Filter the query by a related \MediaProperty\Label object
     *
     * @param \MediaProperty\Label|ObjectCollection $label The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildArtistQuery The current query, for fluid interface
     */
    public function filterByLabel($label, $comparison = null)
    {
        if ($label instanceof \MediaProperty\Label) {
            return $this
                ->addUsingAlias(ArtistTableMap::LABEL_ID, $label->getId(), $comparison);
        } elseif ($label instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ArtistTableMap::LABEL_ID, $label->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildArtistQuery The current query, for fluid interface
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
     * Filter the query by a related \MediaItem\Album object
     *
     * @param \MediaItem\Album|ObjectCollection $album  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildArtistQuery The current query, for fluid interface
     */
    public function filterByAlbum($album, $comparison = null)
    {
        if ($album instanceof \MediaItem\Album) {
            return $this
                ->addUsingAlias(ArtistTableMap::ID, $album->getArtistId(), $comparison);
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
     * @return ChildArtistQuery The current query, for fluid interface
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
     * @param   ChildArtist $artist Object to remove from the list of results
     *
     * @return ChildArtistQuery The current query, for fluid interface
     */
    public function prune($artist = null)
    {
        if ($artist) {
            $this->addUsingAlias(ArtistTableMap::ID, $artist->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the artist table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArtistTableMap::DATABASE_NAME);
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
            ArtistTableMap::clearInstancePool();
            ArtistTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildArtist or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildArtist object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ArtistTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ArtistTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        ArtistTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ArtistTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ArtistQuery
