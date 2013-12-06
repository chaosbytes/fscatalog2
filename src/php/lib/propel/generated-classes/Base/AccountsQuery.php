<?php

namespace Base;

use \Accounts as ChildAccounts;
use \AccountsQuery as ChildAccountsQuery;
use \Exception;
use \PDO;
use Map\AccountsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'accounts' table.
 *
 *
 *
 * @method     ChildAccountsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAccountsQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildAccountsQuery orderByAccountLevel($order = Criteria::ASC) Order by the account_level column
 * @method     ChildAccountsQuery orderByFirstName($order = Criteria::ASC) Order by the first_name column
 * @method     ChildAccountsQuery orderByLastName($order = Criteria::ASC) Order by the last_name column
 * @method     ChildAccountsQuery orderByGender($order = Criteria::ASC) Order by the gender column
 * @method     ChildAccountsQuery orderByDob($order = Criteria::ASC) Order by the dob column
 * @method     ChildAccountsQuery orderByMovieCollection($order = Criteria::ASC) Order by the movie_collection column
 * @method     ChildAccountsQuery orderByTvShowCollection($order = Criteria::ASC) Order by the tv_show_collection column
 * @method     ChildAccountsQuery orderByMusicCollection($order = Criteria::ASC) Order by the music_collection column
 * @method     ChildAccountsQuery orderByBookCollection($order = Criteria::ASC) Order by the book_collection column
 * @method     ChildAccountsQuery orderByGameCollection($order = Criteria::ASC) Order by the game_collection column
 *
 * @method     ChildAccountsQuery groupById() Group by the id column
 * @method     ChildAccountsQuery groupByEmail() Group by the email column
 * @method     ChildAccountsQuery groupByAccountLevel() Group by the account_level column
 * @method     ChildAccountsQuery groupByFirstName() Group by the first_name column
 * @method     ChildAccountsQuery groupByLastName() Group by the last_name column
 * @method     ChildAccountsQuery groupByGender() Group by the gender column
 * @method     ChildAccountsQuery groupByDob() Group by the dob column
 * @method     ChildAccountsQuery groupByMovieCollection() Group by the movie_collection column
 * @method     ChildAccountsQuery groupByTvShowCollection() Group by the tv_show_collection column
 * @method     ChildAccountsQuery groupByMusicCollection() Group by the music_collection column
 * @method     ChildAccountsQuery groupByBookCollection() Group by the book_collection column
 * @method     ChildAccountsQuery groupByGameCollection() Group by the game_collection column
 *
 * @method     ChildAccountsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAccountsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAccountsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAccounts findOne(ConnectionInterface $con = null) Return the first ChildAccounts matching the query
 * @method     ChildAccounts findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAccounts matching the query, or a new ChildAccounts object populated from the query conditions when no match is found
 *
 * @method     ChildAccounts findOneById(int $id) Return the first ChildAccounts filtered by the id column
 * @method     ChildAccounts findOneByEmail(string $email) Return the first ChildAccounts filtered by the email column
 * @method     ChildAccounts findOneByAccountLevel(int $account_level) Return the first ChildAccounts filtered by the account_level column
 * @method     ChildAccounts findOneByFirstName(string $first_name) Return the first ChildAccounts filtered by the first_name column
 * @method     ChildAccounts findOneByLastName(string $last_name) Return the first ChildAccounts filtered by the last_name column
 * @method     ChildAccounts findOneByGender(int $gender) Return the first ChildAccounts filtered by the gender column
 * @method     ChildAccounts findOneByDob(string $dob) Return the first ChildAccounts filtered by the dob column
 * @method     ChildAccounts findOneByMovieCollection(string $movie_collection) Return the first ChildAccounts filtered by the movie_collection column
 * @method     ChildAccounts findOneByTvShowCollection(string $tv_show_collection) Return the first ChildAccounts filtered by the tv_show_collection column
 * @method     ChildAccounts findOneByMusicCollection(string $music_collection) Return the first ChildAccounts filtered by the music_collection column
 * @method     ChildAccounts findOneByBookCollection(string $book_collection) Return the first ChildAccounts filtered by the book_collection column
 * @method     ChildAccounts findOneByGameCollection(string $game_collection) Return the first ChildAccounts filtered by the game_collection column
 *
 * @method     array findById(int $id) Return ChildAccounts objects filtered by the id column
 * @method     array findByEmail(string $email) Return ChildAccounts objects filtered by the email column
 * @method     array findByAccountLevel(int $account_level) Return ChildAccounts objects filtered by the account_level column
 * @method     array findByFirstName(string $first_name) Return ChildAccounts objects filtered by the first_name column
 * @method     array findByLastName(string $last_name) Return ChildAccounts objects filtered by the last_name column
 * @method     array findByGender(int $gender) Return ChildAccounts objects filtered by the gender column
 * @method     array findByDob(string $dob) Return ChildAccounts objects filtered by the dob column
 * @method     array findByMovieCollection(string $movie_collection) Return ChildAccounts objects filtered by the movie_collection column
 * @method     array findByTvShowCollection(string $tv_show_collection) Return ChildAccounts objects filtered by the tv_show_collection column
 * @method     array findByMusicCollection(string $music_collection) Return ChildAccounts objects filtered by the music_collection column
 * @method     array findByBookCollection(string $book_collection) Return ChildAccounts objects filtered by the book_collection column
 * @method     array findByGameCollection(string $game_collection) Return ChildAccounts objects filtered by the game_collection column
 *
 */
abstract class AccountsQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\AccountsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'fscatalog2', $modelName = '\\Accounts', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAccountsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAccountsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \AccountsQuery) {
            return $criteria;
        }
        $query = new \AccountsQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $email] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAccounts|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AccountsTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AccountsTableMap::DATABASE_NAME);
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
     * @return   ChildAccounts A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, EMAIL, ACCOUNT_LEVEL, FIRST_NAME, LAST_NAME, GENDER, DOB, MOVIE_COLLECTION, TV_SHOW_COLLECTION, MUSIC_COLLECTION, BOOK_COLLECTION, GAME_COLLECTION FROM accounts WHERE ID = :p0 AND EMAIL = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildAccounts();
            $obj->hydrate($row);
            AccountsTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildAccounts|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return ChildAccountsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(AccountsTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AccountsTableMap::EMAIL, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildAccountsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(AccountsTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AccountsTableMap::EMAIL, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return ChildAccountsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AccountsTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AccountsTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountsTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccountsQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountsTableMap::EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the account_level column
     *
     * Example usage:
     * <code>
     * $query->filterByAccountLevel(1234); // WHERE account_level = 1234
     * $query->filterByAccountLevel(array(12, 34)); // WHERE account_level IN (12, 34)
     * $query->filterByAccountLevel(array('min' => 12)); // WHERE account_level > 12
     * </code>
     *
     * @param     mixed $accountLevel The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccountsQuery The current query, for fluid interface
     */
    public function filterByAccountLevel($accountLevel = null, $comparison = null)
    {
        if (is_array($accountLevel)) {
            $useMinMax = false;
            if (isset($accountLevel['min'])) {
                $this->addUsingAlias(AccountsTableMap::ACCOUNT_LEVEL, $accountLevel['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($accountLevel['max'])) {
                $this->addUsingAlias(AccountsTableMap::ACCOUNT_LEVEL, $accountLevel['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountsTableMap::ACCOUNT_LEVEL, $accountLevel, $comparison);
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
     * @return ChildAccountsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AccountsTableMap::FIRST_NAME, $firstName, $comparison);
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
     * @return ChildAccountsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AccountsTableMap::LAST_NAME, $lastName, $comparison);
    }

    /**
     * Filter the query on the gender column
     *
     * Example usage:
     * <code>
     * $query->filterByGender(1234); // WHERE gender = 1234
     * $query->filterByGender(array(12, 34)); // WHERE gender IN (12, 34)
     * $query->filterByGender(array('min' => 12)); // WHERE gender > 12
     * </code>
     *
     * @param     mixed $gender The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccountsQuery The current query, for fluid interface
     */
    public function filterByGender($gender = null, $comparison = null)
    {
        if (is_array($gender)) {
            $useMinMax = false;
            if (isset($gender['min'])) {
                $this->addUsingAlias(AccountsTableMap::GENDER, $gender['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gender['max'])) {
                $this->addUsingAlias(AccountsTableMap::GENDER, $gender['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountsTableMap::GENDER, $gender, $comparison);
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
     * @return ChildAccountsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AccountsTableMap::DOB, $dob, $comparison);
    }

    /**
     * Filter the query on the movie_collection column
     *
     * Example usage:
     * <code>
     * $query->filterByMovieCollection('fooValue');   // WHERE movie_collection = 'fooValue'
     * $query->filterByMovieCollection('%fooValue%'); // WHERE movie_collection LIKE '%fooValue%'
     * </code>
     *
     * @param     string $movieCollection The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccountsQuery The current query, for fluid interface
     */
    public function filterByMovieCollection($movieCollection = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($movieCollection)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $movieCollection)) {
                $movieCollection = str_replace('*', '%', $movieCollection);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountsTableMap::MOVIE_COLLECTION, $movieCollection, $comparison);
    }

    /**
     * Filter the query on the tv_show_collection column
     *
     * Example usage:
     * <code>
     * $query->filterByTvShowCollection('fooValue');   // WHERE tv_show_collection = 'fooValue'
     * $query->filterByTvShowCollection('%fooValue%'); // WHERE tv_show_collection LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tvShowCollection The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccountsQuery The current query, for fluid interface
     */
    public function filterByTvShowCollection($tvShowCollection = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tvShowCollection)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tvShowCollection)) {
                $tvShowCollection = str_replace('*', '%', $tvShowCollection);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountsTableMap::TV_SHOW_COLLECTION, $tvShowCollection, $comparison);
    }

    /**
     * Filter the query on the music_collection column
     *
     * Example usage:
     * <code>
     * $query->filterByMusicCollection('fooValue');   // WHERE music_collection = 'fooValue'
     * $query->filterByMusicCollection('%fooValue%'); // WHERE music_collection LIKE '%fooValue%'
     * </code>
     *
     * @param     string $musicCollection The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccountsQuery The current query, for fluid interface
     */
    public function filterByMusicCollection($musicCollection = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($musicCollection)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $musicCollection)) {
                $musicCollection = str_replace('*', '%', $musicCollection);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountsTableMap::MUSIC_COLLECTION, $musicCollection, $comparison);
    }

    /**
     * Filter the query on the book_collection column
     *
     * Example usage:
     * <code>
     * $query->filterByBookCollection('fooValue');   // WHERE book_collection = 'fooValue'
     * $query->filterByBookCollection('%fooValue%'); // WHERE book_collection LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bookCollection The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccountsQuery The current query, for fluid interface
     */
    public function filterByBookCollection($bookCollection = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bookCollection)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bookCollection)) {
                $bookCollection = str_replace('*', '%', $bookCollection);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountsTableMap::BOOK_COLLECTION, $bookCollection, $comparison);
    }

    /**
     * Filter the query on the game_collection column
     *
     * Example usage:
     * <code>
     * $query->filterByGameCollection('fooValue');   // WHERE game_collection = 'fooValue'
     * $query->filterByGameCollection('%fooValue%'); // WHERE game_collection LIKE '%fooValue%'
     * </code>
     *
     * @param     string $gameCollection The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccountsQuery The current query, for fluid interface
     */
    public function filterByGameCollection($gameCollection = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gameCollection)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $gameCollection)) {
                $gameCollection = str_replace('*', '%', $gameCollection);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AccountsTableMap::GAME_COLLECTION, $gameCollection, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAccounts $accounts Object to remove from the list of results
     *
     * @return ChildAccountsQuery The current query, for fluid interface
     */
    public function prune($accounts = null)
    {
        if ($accounts) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AccountsTableMap::ID), $accounts->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AccountsTableMap::EMAIL), $accounts->getEmail(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the accounts table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccountsTableMap::DATABASE_NAME);
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
            AccountsTableMap::clearInstancePool();
            AccountsTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildAccounts or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildAccounts object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AccountsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AccountsTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        AccountsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AccountsTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // AccountsQuery
