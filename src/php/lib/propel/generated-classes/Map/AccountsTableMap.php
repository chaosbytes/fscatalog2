<?php

namespace Map;

use \Accounts;
use \AccountsQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'accounts' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AccountsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.AccountsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'fscatalog2';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'accounts';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Accounts';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Accounts';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 12;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 12;

    /**
     * the column name for the ID field
     */
    const ID = 'accounts.ID';

    /**
     * the column name for the EMAIL field
     */
    const EMAIL = 'accounts.EMAIL';

    /**
     * the column name for the ACCOUNT_LEVEL field
     */
    const ACCOUNT_LEVEL = 'accounts.ACCOUNT_LEVEL';

    /**
     * the column name for the FIRST_NAME field
     */
    const FIRST_NAME = 'accounts.FIRST_NAME';

    /**
     * the column name for the LAST_NAME field
     */
    const LAST_NAME = 'accounts.LAST_NAME';

    /**
     * the column name for the GENDER field
     */
    const GENDER = 'accounts.GENDER';

    /**
     * the column name for the DOB field
     */
    const DOB = 'accounts.DOB';

    /**
     * the column name for the MOVIE_COLLECTION field
     */
    const MOVIE_COLLECTION = 'accounts.MOVIE_COLLECTION';

    /**
     * the column name for the TV_SHOW_COLLECTION field
     */
    const TV_SHOW_COLLECTION = 'accounts.TV_SHOW_COLLECTION';

    /**
     * the column name for the MUSIC_COLLECTION field
     */
    const MUSIC_COLLECTION = 'accounts.MUSIC_COLLECTION';

    /**
     * the column name for the BOOK_COLLECTION field
     */
    const BOOK_COLLECTION = 'accounts.BOOK_COLLECTION';

    /**
     * the column name for the GAME_COLLECTION field
     */
    const GAME_COLLECTION = 'accounts.GAME_COLLECTION';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Email', 'AccountLevel', 'FirstName', 'LastName', 'Gender', 'Dob', 'MovieCollection', 'TvShowCollection', 'MusicCollection', 'BookCollection', 'GameCollection', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'email', 'accountLevel', 'firstName', 'lastName', 'gender', 'dob', 'movieCollection', 'tvShowCollection', 'musicCollection', 'bookCollection', 'gameCollection', ),
        self::TYPE_COLNAME       => array(AccountsTableMap::ID, AccountsTableMap::EMAIL, AccountsTableMap::ACCOUNT_LEVEL, AccountsTableMap::FIRST_NAME, AccountsTableMap::LAST_NAME, AccountsTableMap::GENDER, AccountsTableMap::DOB, AccountsTableMap::MOVIE_COLLECTION, AccountsTableMap::TV_SHOW_COLLECTION, AccountsTableMap::MUSIC_COLLECTION, AccountsTableMap::BOOK_COLLECTION, AccountsTableMap::GAME_COLLECTION, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'EMAIL', 'ACCOUNT_LEVEL', 'FIRST_NAME', 'LAST_NAME', 'GENDER', 'DOB', 'MOVIE_COLLECTION', 'TV_SHOW_COLLECTION', 'MUSIC_COLLECTION', 'BOOK_COLLECTION', 'GAME_COLLECTION', ),
        self::TYPE_FIELDNAME     => array('id', 'email', 'account_level', 'first_name', 'last_name', 'gender', 'dob', 'movie_collection', 'tv_show_collection', 'music_collection', 'book_collection', 'game_collection', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Email' => 1, 'AccountLevel' => 2, 'FirstName' => 3, 'LastName' => 4, 'Gender' => 5, 'Dob' => 6, 'MovieCollection' => 7, 'TvShowCollection' => 8, 'MusicCollection' => 9, 'BookCollection' => 10, 'GameCollection' => 11, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'email' => 1, 'accountLevel' => 2, 'firstName' => 3, 'lastName' => 4, 'gender' => 5, 'dob' => 6, 'movieCollection' => 7, 'tvShowCollection' => 8, 'musicCollection' => 9, 'bookCollection' => 10, 'gameCollection' => 11, ),
        self::TYPE_COLNAME       => array(AccountsTableMap::ID => 0, AccountsTableMap::EMAIL => 1, AccountsTableMap::ACCOUNT_LEVEL => 2, AccountsTableMap::FIRST_NAME => 3, AccountsTableMap::LAST_NAME => 4, AccountsTableMap::GENDER => 5, AccountsTableMap::DOB => 6, AccountsTableMap::MOVIE_COLLECTION => 7, AccountsTableMap::TV_SHOW_COLLECTION => 8, AccountsTableMap::MUSIC_COLLECTION => 9, AccountsTableMap::BOOK_COLLECTION => 10, AccountsTableMap::GAME_COLLECTION => 11, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'EMAIL' => 1, 'ACCOUNT_LEVEL' => 2, 'FIRST_NAME' => 3, 'LAST_NAME' => 4, 'GENDER' => 5, 'DOB' => 6, 'MOVIE_COLLECTION' => 7, 'TV_SHOW_COLLECTION' => 8, 'MUSIC_COLLECTION' => 9, 'BOOK_COLLECTION' => 10, 'GAME_COLLECTION' => 11, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'email' => 1, 'account_level' => 2, 'first_name' => 3, 'last_name' => 4, 'gender' => 5, 'dob' => 6, 'movie_collection' => 7, 'tv_show_collection' => 8, 'music_collection' => 9, 'book_collection' => 10, 'game_collection' => 11, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('accounts');
        $this->setPhpName('Accounts');
        $this->setClassName('\\Accounts');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addPrimaryKey('EMAIL', 'Email', 'VARCHAR', true, 128, null);
        $this->addColumn('ACCOUNT_LEVEL', 'AccountLevel', 'TINYINT', true, 1, 0);
        $this->addColumn('FIRST_NAME', 'FirstName', 'VARCHAR', true, 128, null);
        $this->addColumn('LAST_NAME', 'LastName', 'VARCHAR', true, 128, null);
        $this->addColumn('GENDER', 'Gender', 'TINYINT', true, 1, null);
        $this->addColumn('DOB', 'Dob', 'VARCHAR', true, 10, null);
        $this->addColumn('MOVIE_COLLECTION', 'MovieCollection', 'VARCHAR', true, 255, null);
        $this->addColumn('TV_SHOW_COLLECTION', 'TvShowCollection', 'VARCHAR', true, 255, null);
        $this->addColumn('MUSIC_COLLECTION', 'MusicCollection', 'VARCHAR', true, 255, null);
        $this->addColumn('BOOK_COLLECTION', 'BookCollection', 'VARCHAR', true, 255, null);
        $this->addColumn('GAME_COLLECTION', 'GameCollection', 'VARCHAR', true, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \Accounts $obj A \Accounts object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize(array((string) $obj->getId(), (string) $obj->getEmail()));
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \Accounts object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \Accounts) {
                $key = serialize(array((string) $value->getId(), (string) $value->getEmail()));

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \Accounts object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)]));
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return $pks;
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? AccountsTableMap::CLASS_DEFAULT : AccountsTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (Accounts object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AccountsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AccountsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AccountsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AccountsTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AccountsTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = AccountsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AccountsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AccountsTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(AccountsTableMap::ID);
            $criteria->addSelectColumn(AccountsTableMap::EMAIL);
            $criteria->addSelectColumn(AccountsTableMap::ACCOUNT_LEVEL);
            $criteria->addSelectColumn(AccountsTableMap::FIRST_NAME);
            $criteria->addSelectColumn(AccountsTableMap::LAST_NAME);
            $criteria->addSelectColumn(AccountsTableMap::GENDER);
            $criteria->addSelectColumn(AccountsTableMap::DOB);
            $criteria->addSelectColumn(AccountsTableMap::MOVIE_COLLECTION);
            $criteria->addSelectColumn(AccountsTableMap::TV_SHOW_COLLECTION);
            $criteria->addSelectColumn(AccountsTableMap::MUSIC_COLLECTION);
            $criteria->addSelectColumn(AccountsTableMap::BOOK_COLLECTION);
            $criteria->addSelectColumn(AccountsTableMap::GAME_COLLECTION);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.EMAIL');
            $criteria->addSelectColumn($alias . '.ACCOUNT_LEVEL');
            $criteria->addSelectColumn($alias . '.FIRST_NAME');
            $criteria->addSelectColumn($alias . '.LAST_NAME');
            $criteria->addSelectColumn($alias . '.GENDER');
            $criteria->addSelectColumn($alias . '.DOB');
            $criteria->addSelectColumn($alias . '.MOVIE_COLLECTION');
            $criteria->addSelectColumn($alias . '.TV_SHOW_COLLECTION');
            $criteria->addSelectColumn($alias . '.MUSIC_COLLECTION');
            $criteria->addSelectColumn($alias . '.BOOK_COLLECTION');
            $criteria->addSelectColumn($alias . '.GAME_COLLECTION');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(AccountsTableMap::DATABASE_NAME)->getTable(AccountsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(AccountsTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(AccountsTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new AccountsTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Accounts or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Accounts object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccountsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Accounts) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AccountsTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(AccountsTableMap::ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(AccountsTableMap::EMAIL, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = AccountsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { AccountsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { AccountsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the accounts table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AccountsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Accounts or Criteria object.
     *
     * @param mixed               $criteria Criteria or Accounts object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccountsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Accounts object
        }

        if ($criteria->containsKey(AccountsTableMap::ID) && $criteria->keyContainsValue(AccountsTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AccountsTableMap::ID.')');
        }


        // Set the correct dbName
        $query = AccountsQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // AccountsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AccountsTableMap::buildTableMap();
