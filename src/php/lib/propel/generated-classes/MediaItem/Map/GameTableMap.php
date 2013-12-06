<?php

namespace MediaItem\Map;

use MediaItem\Game;
use MediaItem\GameQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'game' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class GameTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MediaItem.Map.GameTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'fscatalog2';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'game';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MediaItem\\Game';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MediaItem.Game';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the ID field
     */
    const ID = 'game.ID';

    /**
     * the column name for the TITLE field
     */
    const TITLE = 'game.TITLE';

    /**
     * the column name for the RATING field
     */
    const RATING = 'game.RATING';

    /**
     * the column name for the SCORE field
     */
    const SCORE = 'game.SCORE';

    /**
     * the column name for the RELEASE_DATE field
     */
    const RELEASE_DATE = 'game.RELEASE_DATE';

    /**
     * the column name for the SYSTEMS field
     */
    const SYSTEMS = 'game.SYSTEMS';

    /**
     * the column name for the COVER field
     */
    const COVER = 'game.COVER';

    /**
     * the column name for the GAME_DEVELOPER_ID field
     */
    const GAME_DEVELOPER_ID = 'game.GAME_DEVELOPER_ID';

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
        self::TYPE_PHPNAME       => array('Id', 'Title', 'Rating', 'Score', 'ReleaseDate', 'Systems', 'Cover', 'GameDeveloperId', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'title', 'rating', 'score', 'releaseDate', 'systems', 'cover', 'gameDeveloperId', ),
        self::TYPE_COLNAME       => array(GameTableMap::ID, GameTableMap::TITLE, GameTableMap::RATING, GameTableMap::SCORE, GameTableMap::RELEASE_DATE, GameTableMap::SYSTEMS, GameTableMap::COVER, GameTableMap::GAME_DEVELOPER_ID, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'TITLE', 'RATING', 'SCORE', 'RELEASE_DATE', 'SYSTEMS', 'COVER', 'GAME_DEVELOPER_ID', ),
        self::TYPE_FIELDNAME     => array('id', 'title', 'rating', 'score', 'release_date', 'systems', 'cover', 'game_developer_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Title' => 1, 'Rating' => 2, 'Score' => 3, 'ReleaseDate' => 4, 'Systems' => 5, 'Cover' => 6, 'GameDeveloperId' => 7, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'title' => 1, 'rating' => 2, 'score' => 3, 'releaseDate' => 4, 'systems' => 5, 'cover' => 6, 'gameDeveloperId' => 7, ),
        self::TYPE_COLNAME       => array(GameTableMap::ID => 0, GameTableMap::TITLE => 1, GameTableMap::RATING => 2, GameTableMap::SCORE => 3, GameTableMap::RELEASE_DATE => 4, GameTableMap::SYSTEMS => 5, GameTableMap::COVER => 6, GameTableMap::GAME_DEVELOPER_ID => 7, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'TITLE' => 1, 'RATING' => 2, 'SCORE' => 3, 'RELEASE_DATE' => 4, 'SYSTEMS' => 5, 'COVER' => 6, 'GAME_DEVELOPER_ID' => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'title' => 1, 'rating' => 2, 'score' => 3, 'release_date' => 4, 'systems' => 5, 'cover' => 6, 'game_developer_id' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('game');
        $this->setPhpName('Game');
        $this->setClassName('\\MediaItem\\Game');
        $this->setPackage('MediaItem');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('TITLE', 'Title', 'VARCHAR', true, 128, null);
        $this->addColumn('RATING', 'Rating', 'VARCHAR', true, 24, null);
        $this->addColumn('SCORE', 'Score', 'FLOAT', true, 3, null);
        $this->addColumn('RELEASE_DATE', 'ReleaseDate', 'VARCHAR', true, 10, null);
        $this->addColumn('SYSTEMS', 'Systems', 'VARCHAR', true, 128, null);
        $this->addColumn('COVER', 'Cover', 'VARCHAR', true, 255, null);
        $this->addForeignKey('GAME_DEVELOPER_ID', 'GameDeveloperId', 'INTEGER', 'developer', 'ID', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Developer', '\\MediaProperty\\Developer', RelationMap::MANY_TO_ONE, array('game_developer_id' => 'id', ), null, null);
    } // buildRelations()

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
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
        return $withPrefix ? GameTableMap::CLASS_DEFAULT : GameTableMap::OM_CLASS;
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
     * @return array (Game object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = GameTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = GameTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + GameTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GameTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            GameTableMap::addInstanceToPool($obj, $key);
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
            $key = GameTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = GameTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                GameTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(GameTableMap::ID);
            $criteria->addSelectColumn(GameTableMap::TITLE);
            $criteria->addSelectColumn(GameTableMap::RATING);
            $criteria->addSelectColumn(GameTableMap::SCORE);
            $criteria->addSelectColumn(GameTableMap::RELEASE_DATE);
            $criteria->addSelectColumn(GameTableMap::SYSTEMS);
            $criteria->addSelectColumn(GameTableMap::COVER);
            $criteria->addSelectColumn(GameTableMap::GAME_DEVELOPER_ID);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.TITLE');
            $criteria->addSelectColumn($alias . '.RATING');
            $criteria->addSelectColumn($alias . '.SCORE');
            $criteria->addSelectColumn($alias . '.RELEASE_DATE');
            $criteria->addSelectColumn($alias . '.SYSTEMS');
            $criteria->addSelectColumn($alias . '.COVER');
            $criteria->addSelectColumn($alias . '.GAME_DEVELOPER_ID');
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
        return Propel::getServiceContainer()->getDatabaseMap(GameTableMap::DATABASE_NAME)->getTable(GameTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(GameTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(GameTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new GameTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Game or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Game object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MediaItem\Game) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GameTableMap::DATABASE_NAME);
            $criteria->add(GameTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = GameQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { GameTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { GameTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the game table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return GameQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Game or Criteria object.
     *
     * @param mixed               $criteria Criteria or Game object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Game object
        }

        if ($criteria->containsKey(GameTableMap::ID) && $criteria->keyContainsValue(GameTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.GameTableMap::ID.')');
        }


        // Set the correct dbName
        $query = GameQuery::create()->mergeWith($criteria);

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

} // GameTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
GameTableMap::buildTableMap();
