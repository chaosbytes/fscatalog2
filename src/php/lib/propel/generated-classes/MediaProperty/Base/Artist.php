<?php

namespace MediaProperty\Base;

use \Exception;
use \PDO;
use MediaItem\AlbumQuery;
use MediaItem\Album as ChildAlbum;
use MediaItem\Base\Album;
use MediaProperty\Artist as ChildArtist;
use MediaProperty\ArtistQuery as ChildArtistQuery;
use MediaProperty\Label as ChildLabel;
use MediaProperty\LabelQuery as ChildLabelQuery;
use MediaProperty\Map\ArtistTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

abstract class Artist implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MediaProperty\\Map\\ArtistTableMap';


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
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the dob field.
     * @var        string
     */
    protected $dob;

    /**
     * The value for the dod field.
     * @var        string
     */
    protected $dod;

    /**
     * The value for the isband field.
     * @var        boolean
     */
    protected $isband;

    /**
     * The value for the date_formed field.
     * @var        string
     */
    protected $date_formed;

    /**
     * The value for the date_ended field.
     * @var        string
     */
    protected $date_ended;

    /**
     * The value for the members field.
     * @var        string
     */
    protected $members;

    /**
     * The value for the albums field.
     * @var        string
     */
    protected $albums;

    /**
     * The value for the label_id field.
     * @var        int
     */
    protected $label_id;

    /**
     * @var        Label
     */
    protected $aLabel;

    /**
     * @var        ObjectCollection|ChildAlbum[] Collection to store aggregation of ChildAlbum objects.
     */
    protected $collAlbums;
    protected $collAlbumsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $albumsScheduledForDeletion = null;

    /**
     * Initializes internal state of MediaProperty\Base\Artist object.
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
     * Compares this with another <code>Artist</code> instance.  If
     * <code>obj</code> is an instance of <code>Artist</code>, delegates to
     * <code>equals(Artist)</code>.  Otherwise, returns <code>false</code>.
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
     * @return Artist The current object, for fluid interface
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
     * @return Artist The current object, for fluid interface
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
     * Get the [name] column value.
     *
     * @return   string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * Get the [dob] column value.
     *
     * @return   string
     */
    public function getDob()
    {

        return $this->dob;
    }

    /**
     * Get the [dod] column value.
     *
     * @return   string
     */
    public function getDod()
    {

        return $this->dod;
    }

    /**
     * Get the [isband] column value.
     *
     * @return   boolean
     */
    public function getIsband()
    {

        return $this->isband;
    }

    /**
     * Get the [date_formed] column value.
     *
     * @return   string
     */
    public function getDateFormed()
    {

        return $this->date_formed;
    }

    /**
     * Get the [date_ended] column value.
     *
     * @return   string
     */
    public function getDateEnded()
    {

        return $this->date_ended;
    }

    /**
     * Get the [members] column value.
     *
     * @return   string
     */
    public function getMembers()
    {

        return $this->members;
    }

    /**
     * Get the [albums] column value.
     *
     * @return   string
     */
    public function getAlbums()
    {

        return $this->albums;
    }

    /**
     * Get the [label_id] column value.
     *
     * @return   int
     */
    public function getLabelId()
    {

        return $this->label_id;
    }

    /**
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \MediaProperty\Artist The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ArtistTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param      string $v new value
     * @return   \MediaProperty\Artist The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ArtistTableMap::NAME] = true;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [dob] column.
     *
     * @param      string $v new value
     * @return   \MediaProperty\Artist The current object (for fluent API support)
     */
    public function setDob($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->dob !== $v) {
            $this->dob = $v;
            $this->modifiedColumns[ArtistTableMap::DOB] = true;
        }


        return $this;
    } // setDob()

    /**
     * Set the value of [dod] column.
     *
     * @param      string $v new value
     * @return   \MediaProperty\Artist The current object (for fluent API support)
     */
    public function setDod($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->dod !== $v) {
            $this->dod = $v;
            $this->modifiedColumns[ArtistTableMap::DOD] = true;
        }


        return $this;
    } // setDod()

    /**
     * Sets the value of the [isband] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \MediaProperty\Artist The current object (for fluent API support)
     */
    public function setIsband($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->isband !== $v) {
            $this->isband = $v;
            $this->modifiedColumns[ArtistTableMap::ISBAND] = true;
        }


        return $this;
    } // setIsband()

    /**
     * Set the value of [date_formed] column.
     *
     * @param      string $v new value
     * @return   \MediaProperty\Artist The current object (for fluent API support)
     */
    public function setDateFormed($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->date_formed !== $v) {
            $this->date_formed = $v;
            $this->modifiedColumns[ArtistTableMap::DATE_FORMED] = true;
        }


        return $this;
    } // setDateFormed()

    /**
     * Set the value of [date_ended] column.
     *
     * @param      string $v new value
     * @return   \MediaProperty\Artist The current object (for fluent API support)
     */
    public function setDateEnded($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->date_ended !== $v) {
            $this->date_ended = $v;
            $this->modifiedColumns[ArtistTableMap::DATE_ENDED] = true;
        }


        return $this;
    } // setDateEnded()

    /**
     * Set the value of [members] column.
     *
     * @param      string $v new value
     * @return   \MediaProperty\Artist The current object (for fluent API support)
     */
    public function setMembers($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->members !== $v) {
            $this->members = $v;
            $this->modifiedColumns[ArtistTableMap::MEMBERS] = true;
        }


        return $this;
    } // setMembers()

    /**
     * Set the value of [albums] column.
     *
     * @param      string $v new value
     * @return   \MediaProperty\Artist The current object (for fluent API support)
     */
    public function setAlbums($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->albums !== $v) {
            $this->albums = $v;
            $this->modifiedColumns[ArtistTableMap::ALBUMS] = true;
        }


        return $this;
    } // setAlbums()

    /**
     * Set the value of [label_id] column.
     *
     * @param      int $v new value
     * @return   \MediaProperty\Artist The current object (for fluent API support)
     */
    public function setLabelId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->label_id !== $v) {
            $this->label_id = $v;
            $this->modifiedColumns[ArtistTableMap::LABEL_ID] = true;
        }

        if ($this->aLabel !== null && $this->aLabel->getId() !== $v) {
            $this->aLabel = null;
        }


        return $this;
    } // setLabelId()

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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ArtistTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ArtistTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ArtistTableMap::translateFieldName('Dob', TableMap::TYPE_PHPNAME, $indexType)];
            $this->dob = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ArtistTableMap::translateFieldName('Dod', TableMap::TYPE_PHPNAME, $indexType)];
            $this->dod = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ArtistTableMap::translateFieldName('Isband', TableMap::TYPE_PHPNAME, $indexType)];
            $this->isband = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ArtistTableMap::translateFieldName('DateFormed', TableMap::TYPE_PHPNAME, $indexType)];
            $this->date_formed = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ArtistTableMap::translateFieldName('DateEnded', TableMap::TYPE_PHPNAME, $indexType)];
            $this->date_ended = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ArtistTableMap::translateFieldName('Members', TableMap::TYPE_PHPNAME, $indexType)];
            $this->members = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ArtistTableMap::translateFieldName('Albums', TableMap::TYPE_PHPNAME, $indexType)];
            $this->albums = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ArtistTableMap::translateFieldName('LabelId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->label_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = ArtistTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \MediaProperty\Artist object", 0, $e);
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
        if ($this->aLabel !== null && $this->label_id !== $this->aLabel->getId()) {
            $this->aLabel = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(ArtistTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildArtistQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aLabel = null;
            $this->collAlbums = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Artist::setDeleted()
     * @see Artist::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArtistTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildArtistQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ArtistTableMap::DATABASE_NAME);
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
                ArtistTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aLabel !== null) {
                if ($this->aLabel->isModified() || $this->aLabel->isNew()) {
                    $affectedRows += $this->aLabel->save($con);
                }
                $this->setLabel($this->aLabel);
            }

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

            if ($this->albumsScheduledForDeletion !== null) {
                if (!$this->albumsScheduledForDeletion->isEmpty()) {
                    \MediaItem\AlbumQuery::create()
                        ->filterByPrimaryKeys($this->albumsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->albumsScheduledForDeletion = null;
                }
            }

                if ($this->collAlbums !== null) {
            foreach ($this->collAlbums as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

        $this->modifiedColumns[ArtistTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ArtistTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ArtistTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(ArtistTableMap::NAME)) {
            $modifiedColumns[':p' . $index++]  = 'NAME';
        }
        if ($this->isColumnModified(ArtistTableMap::DOB)) {
            $modifiedColumns[':p' . $index++]  = 'DOB';
        }
        if ($this->isColumnModified(ArtistTableMap::DOD)) {
            $modifiedColumns[':p' . $index++]  = 'DOD';
        }
        if ($this->isColumnModified(ArtistTableMap::ISBAND)) {
            $modifiedColumns[':p' . $index++]  = 'ISBAND';
        }
        if ($this->isColumnModified(ArtistTableMap::DATE_FORMED)) {
            $modifiedColumns[':p' . $index++]  = 'DATE_FORMED';
        }
        if ($this->isColumnModified(ArtistTableMap::DATE_ENDED)) {
            $modifiedColumns[':p' . $index++]  = 'DATE_ENDED';
        }
        if ($this->isColumnModified(ArtistTableMap::MEMBERS)) {
            $modifiedColumns[':p' . $index++]  = 'MEMBERS';
        }
        if ($this->isColumnModified(ArtistTableMap::ALBUMS)) {
            $modifiedColumns[':p' . $index++]  = 'ALBUMS';
        }
        if ($this->isColumnModified(ArtistTableMap::LABEL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'LABEL_ID';
        }

        $sql = sprintf(
            'INSERT INTO artist (%s) VALUES (%s)',
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
                    case 'NAME':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'DOB':
                        $stmt->bindValue($identifier, $this->dob, PDO::PARAM_STR);
                        break;
                    case 'DOD':
                        $stmt->bindValue($identifier, $this->dod, PDO::PARAM_STR);
                        break;
                    case 'ISBAND':
                        $stmt->bindValue($identifier, (int) $this->isband, PDO::PARAM_INT);
                        break;
                    case 'DATE_FORMED':
                        $stmt->bindValue($identifier, $this->date_formed, PDO::PARAM_STR);
                        break;
                    case 'DATE_ENDED':
                        $stmt->bindValue($identifier, $this->date_ended, PDO::PARAM_STR);
                        break;
                    case 'MEMBERS':
                        $stmt->bindValue($identifier, $this->members, PDO::PARAM_STR);
                        break;
                    case 'ALBUMS':
                        $stmt->bindValue($identifier, $this->albums, PDO::PARAM_STR);
                        break;
                    case 'LABEL_ID':
                        $stmt->bindValue($identifier, $this->label_id, PDO::PARAM_INT);
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
        $pos = ArtistTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getDob();
                break;
            case 3:
                return $this->getDod();
                break;
            case 4:
                return $this->getIsband();
                break;
            case 5:
                return $this->getDateFormed();
                break;
            case 6:
                return $this->getDateEnded();
                break;
            case 7:
                return $this->getMembers();
                break;
            case 8:
                return $this->getAlbums();
                break;
            case 9:
                return $this->getLabelId();
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
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Artist'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Artist'][$this->getPrimaryKey()] = true;
        $keys = ArtistTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getDob(),
            $keys[3] => $this->getDod(),
            $keys[4] => $this->getIsband(),
            $keys[5] => $this->getDateFormed(),
            $keys[6] => $this->getDateEnded(),
            $keys[7] => $this->getMembers(),
            $keys[8] => $this->getAlbums(),
            $keys[9] => $this->getLabelId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aLabel) {
                $result['Label'] = $this->aLabel->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAlbums) {
                $result['Albums'] = $this->collAlbums->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
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
        $pos = ArtistTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setName($value);
                break;
            case 2:
                $this->setDob($value);
                break;
            case 3:
                $this->setDod($value);
                break;
            case 4:
                $this->setIsband($value);
                break;
            case 5:
                $this->setDateFormed($value);
                break;
            case 6:
                $this->setDateEnded($value);
                break;
            case 7:
                $this->setMembers($value);
                break;
            case 8:
                $this->setAlbums($value);
                break;
            case 9:
                $this->setLabelId($value);
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
        $keys = ArtistTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDob($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDod($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setIsband($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setDateFormed($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setDateEnded($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setMembers($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setAlbums($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setLabelId($arr[$keys[9]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ArtistTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ArtistTableMap::ID)) $criteria->add(ArtistTableMap::ID, $this->id);
        if ($this->isColumnModified(ArtistTableMap::NAME)) $criteria->add(ArtistTableMap::NAME, $this->name);
        if ($this->isColumnModified(ArtistTableMap::DOB)) $criteria->add(ArtistTableMap::DOB, $this->dob);
        if ($this->isColumnModified(ArtistTableMap::DOD)) $criteria->add(ArtistTableMap::DOD, $this->dod);
        if ($this->isColumnModified(ArtistTableMap::ISBAND)) $criteria->add(ArtistTableMap::ISBAND, $this->isband);
        if ($this->isColumnModified(ArtistTableMap::DATE_FORMED)) $criteria->add(ArtistTableMap::DATE_FORMED, $this->date_formed);
        if ($this->isColumnModified(ArtistTableMap::DATE_ENDED)) $criteria->add(ArtistTableMap::DATE_ENDED, $this->date_ended);
        if ($this->isColumnModified(ArtistTableMap::MEMBERS)) $criteria->add(ArtistTableMap::MEMBERS, $this->members);
        if ($this->isColumnModified(ArtistTableMap::ALBUMS)) $criteria->add(ArtistTableMap::ALBUMS, $this->albums);
        if ($this->isColumnModified(ArtistTableMap::LABEL_ID)) $criteria->add(ArtistTableMap::LABEL_ID, $this->label_id);

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
        $criteria = new Criteria(ArtistTableMap::DATABASE_NAME);
        $criteria->add(ArtistTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \MediaProperty\Artist (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setDob($this->getDob());
        $copyObj->setDod($this->getDod());
        $copyObj->setIsband($this->getIsband());
        $copyObj->setDateFormed($this->getDateFormed());
        $copyObj->setDateEnded($this->getDateEnded());
        $copyObj->setMembers($this->getMembers());
        $copyObj->setAlbums($this->getAlbums());
        $copyObj->setLabelId($this->getLabelId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAlbums() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAlbum($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

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
     * @return                 \MediaProperty\Artist Clone of current object.
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
     * Declares an association between this object and a ChildLabel object.
     *
     * @param                  ChildLabel $v
     * @return                 \MediaProperty\Artist The current object (for fluent API support)
     * @throws PropelException
     */
    public function setLabel(ChildLabel $v = null)
    {
        if ($v === null) {
            $this->setLabelId(NULL);
        } else {
            $this->setLabelId($v->getId());
        }

        $this->aLabel = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildLabel object, it will not be re-added.
        if ($v !== null) {
            $v->addArtist($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildLabel object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildLabel The associated ChildLabel object.
     * @throws PropelException
     */
    public function getLabel(ConnectionInterface $con = null)
    {
        if ($this->aLabel === null && ($this->label_id !== null)) {
            $this->aLabel = ChildLabelQuery::create()->findPk($this->label_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aLabel->addArtists($this);
             */
        }

        return $this->aLabel;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Album' == $relationName) {
            return $this->initAlbums();
        }
    }

    /**
     * Clears out the collAlbums collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAlbums()
     */
    public function clearAlbums()
    {
        $this->collAlbums = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAlbums collection loaded partially.
     */
    public function resetPartialAlbums($v = true)
    {
        $this->collAlbumsPartial = $v;
    }

    /**
     * Initializes the collAlbums collection.
     *
     * By default this just sets the collAlbums collection to an empty array (like clearcollAlbums());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAlbums($overrideExisting = true)
    {
        if (null !== $this->collAlbums && !$overrideExisting) {
            return;
        }
        $this->collAlbums = new ObjectCollection();
        $this->collAlbums->setModel('\MediaItem\Album');
    }

    /**
     * Gets an array of ChildAlbum objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildArtist is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildAlbum[] List of ChildAlbum objects
     * @throws PropelException
     */
    public function getAlbums($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAlbumsPartial && !$this->isNew();
        if (null === $this->collAlbums || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAlbums) {
                // return empty collection
                $this->initAlbums();
            } else {
                $collAlbums = AlbumQuery::create(null, $criteria)
                    ->filterByArtist($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAlbumsPartial && count($collAlbums)) {
                        $this->initAlbums(false);

                        foreach ($collAlbums as $obj) {
                            if (false == $this->collAlbums->contains($obj)) {
                                $this->collAlbums->append($obj);
                            }
                        }

                        $this->collAlbumsPartial = true;
                    }

                    reset($collAlbums);

                    return $collAlbums;
                }

                if ($partial && $this->collAlbums) {
                    foreach ($this->collAlbums as $obj) {
                        if ($obj->isNew()) {
                            $collAlbums[] = $obj;
                        }
                    }
                }

                $this->collAlbums = $collAlbums;
                $this->collAlbumsPartial = false;
            }
        }

        return $this->collAlbums;
    }

    /**
     * Sets a collection of Album objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $albums A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildArtist The current object (for fluent API support)
     */
    public function setAlbums(Collection $albums, ConnectionInterface $con = null)
    {
        $albumsToDelete = $this->getAlbums(new Criteria(), $con)->diff($albums);


        $this->albumsScheduledForDeletion = $albumsToDelete;

        foreach ($albumsToDelete as $albumRemoved) {
            $albumRemoved->setArtist(null);
        }

        $this->collAlbums = null;
        foreach ($albums as $album) {
            $this->addAlbum($album);
        }

        $this->collAlbums = $albums;
        $this->collAlbumsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Album objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Album objects.
     * @throws PropelException
     */
    public function countAlbums(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAlbumsPartial && !$this->isNew();
        if (null === $this->collAlbums || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAlbums) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAlbums());
            }

            $query = AlbumQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByArtist($this)
                ->count($con);
        }

        return count($this->collAlbums);
    }

    /**
     * Method called to associate a ChildAlbum object to this object
     * through the ChildAlbum foreign key attribute.
     *
     * @param    ChildAlbum $l ChildAlbum
     * @return   \MediaProperty\Artist The current object (for fluent API support)
     */
    public function addAlbum(ChildAlbum $l)
    {
        if ($this->collAlbums === null) {
            $this->initAlbums();
            $this->collAlbumsPartial = true;
        }

        if (!in_array($l, $this->collAlbums->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAlbum($l);
        }

        return $this;
    }

    /**
     * @param Album $album The album object to add.
     */
    protected function doAddAlbum($album)
    {
        $this->collAlbums[]= $album;
        $album->setArtist($this);
    }

    /**
     * @param  Album $album The album object to remove.
     * @return ChildArtist The current object (for fluent API support)
     */
    public function removeAlbum($album)
    {
        if ($this->getAlbums()->contains($album)) {
            $this->collAlbums->remove($this->collAlbums->search($album));
            if (null === $this->albumsScheduledForDeletion) {
                $this->albumsScheduledForDeletion = clone $this->collAlbums;
                $this->albumsScheduledForDeletion->clear();
            }
            $this->albumsScheduledForDeletion[]= clone $album;
            $album->setArtist(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Artist is new, it will return
     * an empty collection; or if this Artist has previously
     * been saved, it will retrieve related Albums from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Artist.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildAlbum[] List of ChildAlbum objects
     */
    public function getAlbumsJoinLabel($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = AlbumQuery::create(null, $criteria);
        $query->joinWith('Label', $joinBehavior);

        return $this->getAlbums($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->dob = null;
        $this->dod = null;
        $this->isband = null;
        $this->date_formed = null;
        $this->date_ended = null;
        $this->members = null;
        $this->albums = null;
        $this->label_id = null;
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
            if ($this->collAlbums) {
                foreach ($this->collAlbums as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAlbums = null;
        $this->aLabel = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ArtistTableMap::DEFAULT_STRING_FORMAT);
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
