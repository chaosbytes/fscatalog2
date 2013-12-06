<?php

namespace MediaProperty\Map;

use MediaProperty\Artist;
use MediaProperty\ArtistQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'artist' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ArtistTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MediaProperty.Map.ArtistTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'fscatalog2';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'artist';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MediaProperty\\Artist';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MediaProperty.Artist';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the ID field
     */
    const ID = 'artist.ID';

    /**
     * the column name for the NAME field
     */
    const NAME = 'artist.NAME';

    /**
     * the column name for the DOB field
     */
    const DOB = 'artist.DOB';

    /**
     * the column name for the DOD field
     */
    const DOD = 'artist.DOD';

    /**
     * the column name for the ISBAND field
     */
    const ISBAND = 'artist.ISBAND';

    /**
     * the column name for the DATE_FORMED field
     */
    const DATE_FORMED = 'artist.DATE_FORMED';

    /**
     * the column name for the DATE_ENDED field
     */
    const DATE_ENDED = 'artist.DATE_ENDED';

    /**
     * the column name for the MEMBERS field
     */
    const MEMBERS = 'artist.MEMBERS';

    /**
     * the column name for the ALBUMS field
     */
    const ALBUMS = 'artist.ALBUMS';

    /**
     * the column name for the LABEL_ID field
     */
    const LABEL_ID = 'artist.LABEL_ID';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Dob', 'Dod', 'Isband', 'DateFormed', 'DateEnded', 'Members', 'Albums', 'LabelId', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'name', 'dob', 'dod', 'isband', 'dateFormed', 'dateEnded', 'members', 'albums', 'labelId', ),
        self::TYPE_COLNAME       => array(ArtistTableMap::ID, ArtistTableMap::NAME, ArtistTableMap::DOB, ArtistTableMap::DOD, ArtistTableMap::ISBAND, ArtistTableMap::DATE_FORMED, ArtistTableMap::DATE_ENDED, ArtistTableMap::MEMBERS, ArtistTableMap::ALBUMS, ArtistTableMap::LABEL_ID, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'NAME', 'DOB', 'DOD', 'ISBAND', 'DATE_FORMED', 'DATE_ENDED', 'MEMBERS', 'ALBUMS', 'LABEL_ID', ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'dob', 'dod', 'isBand', 'date_formed', 'date_ended', 'members', 'albums', 'label_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Dob' => 2, 'Dod' => 3, 'Isband' => 4, 'DateFormed' => 5, 'DateEnded' => 6, 'Members' => 7, 'Albums' => 8, 'LabelId' => 9, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'name' => 1, 'dob' => 2, 'dod' => 3, 'isband' => 4, 'dateFormed' => 5, 'dateEnded' => 6, 'members' => 7, 'albums' => 8, 'labelId' => 9, ),
        self::TYPE_COLNAME       => array(ArtistTableMap::ID => 0, ArtistTableMap::NAME => 1, ArtistTableMap::DOB => 2, ArtistTableMap::DOD => 3, ArtistTableMap::ISBAND => 4, ArtistTableMap::DATE_FORMED => 5, ArtistTableMap::DATE_ENDED => 6, ArtistTableMap::MEMBERS => 7, ArtistTableMap::ALBUMS => 8, ArtistTableMap::LABEL_ID => 9, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'NAME' => 1, 'DOB' => 2, 'DOD' => 3, 'ISBAND' => 4, 'DATE_FORMED' => 5, 'DATE_ENDED' => 6, 'MEMBERS' => 7, 'ALBUMS' => 8, 'LABEL_ID' => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'dob' => 2, 'dod' => 3, 'isBand' => 4, 'date_formed' => 5, 'date_ended' => 6, 'members' => 7, 'albums' => 8, 'label_id' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('artist');
        $this->setPhpName('Artist');
        $this->setClassName('\\MediaProperty\\Artist');
        $this->setPackage('MediaProperty');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('NAME', 'Name', 'VARCHAR', true, 128, null);
        $this->addColumn('DOB', 'Dob', 'VARCHAR', true, 10, null);
        $this->addColumn('DOD', 'Dod', 'VARCHAR', true, 10, null);
        $this->addColumn('ISBAND', 'Isband', 'BOOLEAN', false, 1, null);
        $this->addColumn('DATE_FORMED', 'DateFormed', 'VARCHAR', false, 10, null);
        $this->addColumn('DATE_ENDED', 'DateEnded', 'VARCHAR', false, 10, null);
        $this->addColumn('MEMBERS', 'Members', 'VARCHAR', true, 255, null);
        $this->addColumn('ALBUMS', 'Albums', 'VARCHAR', true, 255, null);
        $this->addForeignKey('LABEL_ID', 'LabelId', 'INTEGER', 'label', 'ID', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Label', '\\MediaProperty\\Label', RelationMap::MANY_TO_ONE, array('label_id' => 'id', ), null, null);
        $this->addRelation('Album', '\\MediaItem\\Album', RelationMap::ONE_TO_MANY, array('id' => 'artist_id', ), null, null, 'Albums');
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
        return $withPrefix ? ArtistTableMap::CLASS_DEFAULT : ArtistTableMap::OM_CLASS;
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
     * @return array (Artist object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ArtistTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ArtistTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ArtistTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ArtistTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ArtistTableMap::addInstanceToPool($obj, $key);
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
            $key = ArtistTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ArtistTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ArtistTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ArtistTableMap::ID);
            $criteria->addSelectColumn(ArtistTableMap::NAME);
            $criteria->addSelectColumn(ArtistTableMap::DOB);
            $criteria->addSelectColumn(ArtistTableMap::DOD);
            $criteria->addSelectColumn(ArtistTableMap::ISBAND);
            $criteria->addSelectColumn(ArtistTableMap::DATE_FORMED);
            $criteria->addSelectColumn(ArtistTableMap::DATE_ENDED);
            $criteria->addSelectColumn(ArtistTableMap::MEMBERS);
            $criteria->addSelectColumn(ArtistTableMap::ALBUMS);
            $criteria->addSelectColumn(ArtistTableMap::LABEL_ID);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.NAME');
            $criteria->addSelectColumn($alias . '.DOB');
            $criteria->addSelectColumn($alias . '.DOD');
            $criteria->addSelectColumn($alias . '.ISBAND');
            $criteria->addSelectColumn($alias . '.DATE_FORMED');
            $criteria->addSelectColumn($alias . '.DATE_ENDED');
            $criteria->addSelectColumn($alias . '.MEMBERS');
            $criteria->addSelectColumn($alias . '.ALBUMS');
            $criteria->addSelectColumn($alias . '.LABEL_ID');
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
        return Propel::getServiceContainer()->getDatabaseMap(ArtistTableMap::DATABASE_NAME)->getTable(ArtistTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(ArtistTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(ArtistTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new ArtistTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Artist or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Artist object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ArtistTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MediaProperty\Artist) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ArtistTableMap::DATABASE_NAME);
            $criteria->add(ArtistTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = ArtistQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { ArtistTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { ArtistTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the artist table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ArtistQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Artist or Criteria object.
     *
     * @param mixed               $criteria Criteria or Artist object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArtistTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Artist object
        }

        if ($criteria->containsKey(ArtistTableMap::ID) && $criteria->keyContainsValue(ArtistTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ArtistTableMap::ID.')');
        }


        // Set the correct dbName
        $query = ArtistQuery::create()->mergeWith($criteria);

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

} // ArtistTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ArtistTableMap::buildTableMap();
