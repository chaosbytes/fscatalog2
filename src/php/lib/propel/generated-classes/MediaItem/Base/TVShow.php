<?php

namespace MediaItem\Base;

use \Exception;
use \PDO;
use MediaItem\TVShowQuery as ChildTVShowQuery;
use MediaItem\Map\TVShowTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

abstract class TVShow implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MediaItem\\Map\\TVShowTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the rating field.
     * @var        string
     */
    protected $rating;

    /**
     * The value for the score field.
     * @var        double
     */
    protected $score;

    /**
     * The value for the summary field.
     * @var        string
     */
    protected $summary;

    /**
     * The value for the first_aired field.
     * @var        string
     */
    protected $first_aired;

    /**
     * The value for the network field.
     * @var        string
     */
    protected $network;

    /**
     * The value for the time_slot field.
     * @var        string
     */
    protected $time_slot;

    /**
     * The value for the actor_ids field.
     * @var        string
     */
    protected $actor_ids;

    /**
     * The value for the poster field.
     * @var        string
     */
    protected $poster;

    /**
     * The value for the seasons field.
     * @var        string
     */
    protected $seasons;

    /**
     * The value for the episodes field.
     * @var        string
     */
    protected $episodes;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of MediaItem\Base\TVShow object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (Boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (Boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>TVShow</code> instance.  If
     * <code>obj</code> is an instance of <code>TVShow</code>, delegates to
     * <code>equals(TVShow)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        $thisclazz = get_class($this);
        if (!is_object($obj) || !($obj instanceof $thisclazz)) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey()
            || null === $obj->getPrimaryKey())  {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        if (null !== $this->getPrimaryKey()) {
            return crc32(serialize($this->getPrimaryKey()));
        }

        return crc32(serialize(clone $this));
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return TVShow The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return TVShow The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return   int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [title] column value.
     *
     * @return   string
     */
    public function getTitle()
    {

        return $this->title;
    }

    /**
     * Get the [rating] column value.
     *
     * @return   string
     */
    public function getRating()
    {

        return $this->rating;
    }

    /**
     * Get the [score] column value.
     *
     * @return   double
     */
    public function getScore()
    {

        return $this->score;
    }

    /**
     * Get the [summary] column value.
     *
     * @return   string
     */
    public function getSummary()
    {

        return $this->summary;
    }

    /**
     * Get the [first_aired] column value.
     *
     * @return   string
     */
    public function getFirstAired()
    {

        return $this->first_aired;
    }

    /**
     * Get the [network] column value.
     *
     * @return   string
     */
    public function getNetwork()
    {

        return $this->network;
    }

    /**
     * Get the [time_slot] column value.
     *
     * @return   string
     */
    public function getTimeSlot()
    {

        return $this->time_slot;
    }

    /**
     * Get the [actor_ids] column value.
     *
     * @return   string
     */
    public function getActorIds()
    {

        return $this->actor_ids;
    }

    /**
     * Get the [poster] column value.
     *
     * @return   string
     */
    public function getPoster()
    {

        return $this->poster;
    }

    /**
     * Get the [seasons] column value.
     *
     * @return   string
     */
    public function getSeasons()
    {

        return $this->seasons;
    }

    /**
     * Get the [episodes] column value.
     *
     * @return   string
     */
    public function getEpisodes()
    {

        return $this->episodes;
    }

    /**
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \MediaItem\TVShow The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[TVShowTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [title] column.
     *
     * @param      string $v new value
     * @return   \MediaItem\TVShow The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[TVShowTableMap::TITLE] = true;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [rating] column.
     *
     * @param      string $v new value
     * @return   \MediaItem\TVShow The current object (for fluent API support)
     */
    public function setRating($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->rating !== $v) {
            $this->rating = $v;
            $this->modifiedColumns[TVShowTableMap::RATING] = true;
        }


        return $this;
    } // setRating()

    /**
     * Set the value of [score] column.
     *
     * @param      double $v new value
     * @return   \MediaItem\TVShow The current object (for fluent API support)
     */
    public function setScore($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->score !== $v) {
            $this->score = $v;
            $this->modifiedColumns[TVShowTableMap::SCORE] = true;
        }


        return $this;
    } // setScore()

    /**
     * Set the value of [summary] column.
     *
     * @param      string $v new value
     * @return   \MediaItem\TVShow The current object (for fluent API support)
     */
    public function setSummary($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->summary !== $v) {
            $this->summary = $v;
            $this->modifiedColumns[TVShowTableMap::SUMMARY] = true;
        }


        return $this;
    } // setSummary()

    /**
     * Set the value of [first_aired] column.
     *
     * @param      string $v new value
     * @return   \MediaItem\TVShow The current object (for fluent API support)
     */
    public function setFirstAired($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->first_aired !== $v) {
            $this->first_aired = $v;
            $this->modifiedColumns[TVShowTableMap::FIRST_AIRED] = true;
        }


        return $this;
    } // setFirstAired()

    /**
     * Set the value of [network] column.
     *
     * @param      string $v new value
     * @return   \MediaItem\TVShow The current object (for fluent API support)
     */
    public function setNetwork($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->network !== $v) {
            $this->network = $v;
            $this->modifiedColumns[TVShowTableMap::NETWORK] = true;
        }


        return $this;
    } // setNetwork()

    /**
     * Set the value of [time_slot] column.
     *
     * @param      string $v new value
     * @return   \MediaItem\TVShow The current object (for fluent API support)
     */
    public function setTimeSlot($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->time_slot !== $v) {
            $this->time_slot = $v;
            $this->modifiedColumns[TVShowTableMap::TIME_SLOT] = true;
        }


        return $this;
    } // setTimeSlot()

    /**
     * Set the value of [actor_ids] column.
     *
     * @param      string $v new value
     * @return   \MediaItem\TVShow The current object (for fluent API support)
     */
    public function setActorIds($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->actor_ids !== $v) {
            $this->actor_ids = $v;
            $this->modifiedColumns[TVShowTableMap::ACTOR_IDS] = true;
        }


        return $this;
    } // setActorIds()

    /**
     * Set the value of [poster] column.
     *
     * @param      string $v new value
     * @return   \MediaItem\TVShow The current object (for fluent API support)
     */
    public function setPoster($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->poster !== $v) {
            $this->poster = $v;
            $this->modifiedColumns[TVShowTableMap::POSTER] = true;
        }


        return $this;
    } // setPoster()

    /**
     * Set the value of [seasons] column.
     *
     * @param      string $v new value
     * @return   \MediaItem\TVShow The current object (for fluent API support)
     */
    public function setSeasons($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->seasons !== $v) {
            $this->seasons = $v;
            $this->modifiedColumns[TVShowTableMap::SEASONS] = true;
        }


        return $this;
    } // setSeasons()

    /**
     * Set the value of [episodes] column.
     *
     * @param      string $v new value
     * @return   \MediaItem\TVShow The current object (for fluent API support)
     */
    public function setEpisodes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->episodes !== $v) {
            $this->episodes = $v;
            $this->modifiedColumns[TVShowTableMap::EPISODES] = true;
        }


        return $this;
    } // setEpisodes()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TVShowTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TVShowTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TVShowTableMap::translateFieldName('Rating', TableMap::TYPE_PHPNAME, $indexType)];
            $this->rating = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TVShowTableMap::translateFieldName('Score', TableMap::TYPE_PHPNAME, $indexType)];
            $this->score = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TVShowTableMap::translateFieldName('Summary', TableMap::TYPE_PHPNAME, $indexType)];
            $this->summary = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TVShowTableMap::translateFieldName('FirstAired', TableMap::TYPE_PHPNAME, $indexType)];
            $this->first_aired = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : TVShowTableMap::translateFieldName('Network', TableMap::TYPE_PHPNAME, $indexType)];
            $this->network = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : TVShowTableMap::translateFieldName('TimeSlot', TableMap::TYPE_PHPNAME, $indexType)];
            $this->time_slot = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : TVShowTableMap::translateFieldName('ActorIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->actor_ids = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : TVShowTableMap::translateFieldName('Poster', TableMap::TYPE_PHPNAME, $indexType)];
            $this->poster = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : TVShowTableMap::translateFieldName('Seasons', TableMap::TYPE_PHPNAME, $indexType)];
            $this->seasons = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : TVShowTableMap::translateFieldName('Episodes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->episodes = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 12; // 12 = TVShowTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \MediaItem\TVShow object", 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TVShowTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTVShowQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see TVShow::setDeleted()
     * @see TVShow::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TVShowTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildTVShowQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TVShowTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                TVShowTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[TVShowTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TVShowTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TVShowTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(TVShowTableMap::TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'TITLE';
        }
        if ($this->isColumnModified(TVShowTableMap::RATING)) {
            $modifiedColumns[':p' . $index++]  = 'RATING';
        }
        if ($this->isColumnModified(TVShowTableMap::SCORE)) {
            $modifiedColumns[':p' . $index++]  = 'SCORE';
        }
        if ($this->isColumnModified(TVShowTableMap::SUMMARY)) {
            $modifiedColumns[':p' . $index++]  = 'SUMMARY';
        }
        if ($this->isColumnModified(TVShowTableMap::FIRST_AIRED)) {
            $modifiedColumns[':p' . $index++]  = 'FIRST_AIRED';
        }
        if ($this->isColumnModified(TVShowTableMap::NETWORK)) {
            $modifiedColumns[':p' . $index++]  = 'NETWORK';
        }
        if ($this->isColumnModified(TVShowTableMap::TIME_SLOT)) {
            $modifiedColumns[':p' . $index++]  = 'TIME_SLOT';
        }
        if ($this->isColumnModified(TVShowTableMap::ACTOR_IDS)) {
            $modifiedColumns[':p' . $index++]  = 'ACTOR_IDS';
        }
        if ($this->isColumnModified(TVShowTableMap::POSTER)) {
            $modifiedColumns[':p' . $index++]  = 'POSTER';
        }
        if ($this->isColumnModified(TVShowTableMap::SEASONS)) {
            $modifiedColumns[':p' . $index++]  = 'SEASONS';
        }
        if ($this->isColumnModified(TVShowTableMap::EPISODES)) {
            $modifiedColumns[':p' . $index++]  = 'EPISODES';
        }

        $sql = sprintf(
            'INSERT INTO tv_show (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'TITLE':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case 'RATING':
                        $stmt->bindValue($identifier, $this->rating, PDO::PARAM_STR);
                        break;
                    case 'SCORE':
                        $stmt->bindValue($identifier, $this->score, PDO::PARAM_STR);
                        break;
                    case 'SUMMARY':
                        $stmt->bindValue($identifier, $this->summary, PDO::PARAM_STR);
                        break;
                    case 'FIRST_AIRED':
                        $stmt->bindValue($identifier, $this->first_aired, PDO::PARAM_STR);
                        break;
                    case 'NETWORK':
                        $stmt->bindValue($identifier, $this->network, PDO::PARAM_STR);
                        break;
                    case 'TIME_SLOT':
                        $stmt->bindValue($identifier, $this->time_slot, PDO::PARAM_STR);
                        break;
                    case 'ACTOR_IDS':
                        $stmt->bindValue($identifier, $this->actor_ids, PDO::PARAM_STR);
                        break;
                    case 'POSTER':
                        $stmt->bindValue($identifier, $this->poster, PDO::PARAM_STR);
                        break;
                    case 'SEASONS':
                        $stmt->bindValue($identifier, $this->seasons, PDO::PARAM_STR);
                        break;
                    case 'EPISODES':
                        $stmt->bindValue($identifier, $this->episodes, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TVShowTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getTitle();
                break;
            case 2:
                return $this->getRating();
                break;
            case 3:
                return $this->getScore();
                break;
            case 4:
                return $this->getSummary();
                break;
            case 5:
                return $this->getFirstAired();
                break;
            case 6:
                return $this->getNetwork();
                break;
            case 7:
                return $this->getTimeSlot();
                break;
            case 8:
                return $this->getActorIds();
                break;
            case 9:
                return $this->getPoster();
                break;
            case 10:
                return $this->getSeasons();
                break;
            case 11:
                return $this->getEpisodes();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {
        if (isset($alreadyDumpedObjects['TVShow'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['TVShow'][$this->getPrimaryKey()] = true;
        $keys = TVShowTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getRating(),
            $keys[3] => $this->getScore(),
            $keys[4] => $this->getSummary(),
            $keys[5] => $this->getFirstAired(),
            $keys[6] => $this->getNetwork(),
            $keys[7] => $this->getTimeSlot(),
            $keys[8] => $this->getActorIds(),
            $keys[9] => $this->getPoster(),
            $keys[10] => $this->getSeasons(),
            $keys[11] => $this->getEpisodes(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }


        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return void
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TVShowTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setTitle($value);
                break;
            case 2:
                $this->setRating($value);
                break;
            case 3:
                $this->setScore($value);
                break;
            case 4:
                $this->setSummary($value);
                break;
            case 5:
                $this->setFirstAired($value);
                break;
            case 6:
                $this->setNetwork($value);
                break;
            case 7:
                $this->setTimeSlot($value);
                break;
            case 8:
                $this->setActorIds($value);
                break;
            case 9:
                $this->setPoster($value);
                break;
            case 10:
                $this->setSeasons($value);
                break;
            case 11:
                $this->setEpisodes($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = TVShowTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setRating($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setScore($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setSummary($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setFirstAired($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setNetwork($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setTimeSlot($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setActorIds($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setPoster($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setSeasons($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setEpisodes($arr[$keys[11]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TVShowTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TVShowTableMap::ID)) $criteria->add(TVShowTableMap::ID, $this->id);
        if ($this->isColumnModified(TVShowTableMap::TITLE)) $criteria->add(TVShowTableMap::TITLE, $this->title);
        if ($this->isColumnModified(TVShowTableMap::RATING)) $criteria->add(TVShowTableMap::RATING, $this->rating);
        if ($this->isColumnModified(TVShowTableMap::SCORE)) $criteria->add(TVShowTableMap::SCORE, $this->score);
        if ($this->isColumnModified(TVShowTableMap::SUMMARY)) $criteria->add(TVShowTableMap::SUMMARY, $this->summary);
        if ($this->isColumnModified(TVShowTableMap::FIRST_AIRED)) $criteria->add(TVShowTableMap::FIRST_AIRED, $this->first_aired);
        if ($this->isColumnModified(TVShowTableMap::NETWORK)) $criteria->add(TVShowTableMap::NETWORK, $this->network);
        if ($this->isColumnModified(TVShowTableMap::TIME_SLOT)) $criteria->add(TVShowTableMap::TIME_SLOT, $this->time_slot);
        if ($this->isColumnModified(TVShowTableMap::ACTOR_IDS)) $criteria->add(TVShowTableMap::ACTOR_IDS, $this->actor_ids);
        if ($this->isColumnModified(TVShowTableMap::POSTER)) $criteria->add(TVShowTableMap::POSTER, $this->poster);
        if ($this->isColumnModified(TVShowTableMap::SEASONS)) $criteria->add(TVShowTableMap::SEASONS, $this->seasons);
        if ($this->isColumnModified(TVShowTableMap::EPISODES)) $criteria->add(TVShowTableMap::EPISODES, $this->episodes);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(TVShowTableMap::DATABASE_NAME);
        $criteria->add(TVShowTableMap::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \MediaItem\TVShow (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTitle($this->getTitle());
        $copyObj->setRating($this->getRating());
        $copyObj->setScore($this->getScore());
        $copyObj->setSummary($this->getSummary());
        $copyObj->setFirstAired($this->getFirstAired());
        $copyObj->setNetwork($this->getNetwork());
        $copyObj->setTimeSlot($this->getTimeSlot());
        $copyObj->setActorIds($this->getActorIds());
        $copyObj->setPoster($this->getPoster());
        $copyObj->setSeasons($this->getSeasons());
        $copyObj->setEpisodes($this->getEpisodes());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \MediaItem\TVShow Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->title = null;
        $this->rating = null;
        $this->score = null;
        $this->summary = null;
        $this->first_aired = null;
        $this->network = null;
        $this->time_slot = null;
        $this->actor_ids = null;
        $this->poster = null;
        $this->seasons = null;
        $this->episodes = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TVShowTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
