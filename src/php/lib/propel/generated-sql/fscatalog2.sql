
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- accounts
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(128) NOT NULL,
    `account_level` TINYINT(1) DEFAULT 0 NOT NULL,
    `first_name` VARCHAR(128) NOT NULL,
    `last_name` VARCHAR(128) NOT NULL,
    `gender` TINYINT(1) NOT NULL,
    `dob` VARCHAR(10) NOT NULL,
    `movie_collection` VARCHAR(255) NOT NULL,
    `tv_show_collection` VARCHAR(255) NOT NULL,
    `music_collection` VARCHAR(255) NOT NULL,
    `book_collection` VARCHAR(255) NOT NULL,
    `game_collection` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`,`email`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- book
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `book`;

CREATE TABLE `book`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `year` INTEGER(4) NOT NULL,
    `isbn` VARCHAR(24) NOT NULL,
    `cover` VARCHAR(255) NOT NULL,
    `publisher_id` INTEGER NOT NULL,
    `author_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `book_FI_1` (`publisher_id`),
    INDEX `book_FI_2` (`author_id`),
    CONSTRAINT `book_FK_1`
        FOREIGN KEY (`publisher_id`)
        REFERENCES `publisher` (`id`),
    CONSTRAINT `book_FK_2`
        FOREIGN KEY (`author_id`)
        REFERENCES `author` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- author
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `author`;

CREATE TABLE `author`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(128) NOT NULL,
    `last_name` VARCHAR(128) NOT NULL,
    `dob` VARCHAR(10) NOT NULL,
    `dod` VARCHAR(10) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- publisher
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `publisher`;

CREATE TABLE `publisher`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(128) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- movie
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `movie`;

CREATE TABLE `movie`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(128) NOT NULL,
    `rating` VARCHAR(24) NOT NULL,
    `score` FLOAT(3) NOT NULL,
    `summary` VARCHAR(2500) NOT NULL,
    `release_date` VARCHAR(10) NOT NULL,
    `director_id` INTEGER NOT NULL,
    `actor_ids` VARCHAR(255) NOT NULL,
    `poster` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `movie_FI_1` (`director_id`),
    CONSTRAINT `movie_FK_1`
        FOREIGN KEY (`director_id`)
        REFERENCES `director` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- tv_show
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tv_show`;

CREATE TABLE `tv_show`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(128) NOT NULL,
    `rating` VARCHAR(24) NOT NULL,
    `score` FLOAT(3) NOT NULL,
    `summary` VARCHAR(2500) NOT NULL,
    `first_aired` VARCHAR(10) NOT NULL,
    `network` VARCHAR(25) NOT NULL,
    `time_slot` VARCHAR(10) NOT NULL,
    `actor_ids` VARCHAR(255) NOT NULL,
    `poster` VARCHAR(255) NOT NULL,
    `seasons` VARCHAR(255) NOT NULL,
    `episodes` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- actor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `actor`;

CREATE TABLE `actor`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(128) NOT NULL,
    `last_name` VARCHAR(128) NOT NULL,
    `dob` VARCHAR(10) NOT NULL,
    `dod` VARCHAR(10) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- director
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `director`;

CREATE TABLE `director`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(128) NOT NULL,
    `last_name` VARCHAR(128) NOT NULL,
    `dob` VARCHAR(10) NOT NULL,
    `dod` VARCHAR(10) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- artist
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `artist`;

CREATE TABLE `artist`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(128) NOT NULL,
    `dob` VARCHAR(10) NOT NULL,
    `dod` VARCHAR(10) NOT NULL,
    `isBand` TINYINT(1),
    `date_formed` VARCHAR(10),
    `date_ended` VARCHAR(10),
    `members` VARCHAR(255) NOT NULL,
    `albums` VARCHAR(255) NOT NULL,
    `label_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `artist_FI_1` (`label_id`),
    CONSTRAINT `artist_FK_1`
        FOREIGN KEY (`label_id`)
        REFERENCES `label` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- album
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `album`;

CREATE TABLE `album`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(128) NOT NULL,
    `score` FLOAT(3) NOT NULL,
    `release_date` VARCHAR(10),
    `songs` VARCHAR(255) NOT NULL,
    `artist_id` INTEGER NOT NULL,
    `label_id` INTEGER NOT NULL,
    `explicit` TINYINT(1) NOT NULL,
    `cover` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `album_FI_1` (`artist_id`),
    INDEX `album_FI_2` (`label_id`),
    CONSTRAINT `album_FK_1`
        FOREIGN KEY (`artist_id`)
        REFERENCES `artist` (`id`),
    CONSTRAINT `album_FK_2`
        FOREIGN KEY (`label_id`)
        REFERENCES `label` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- label
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `label`;

CREATE TABLE `label`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(128) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- game
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `game`;

CREATE TABLE `game`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(128) NOT NULL,
    `rating` VARCHAR(24) NOT NULL,
    `score` FLOAT(3) NOT NULL,
    `release_date` VARCHAR(10) NOT NULL,
    `systems` VARCHAR(128) NOT NULL,
    `cover` VARCHAR(255) NOT NULL,
    `game_developer_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `game_FI_1` (`game_developer_id`),
    CONSTRAINT `game_FK_1`
        FOREIGN KEY (`game_developer_id`)
        REFERENCES `developer` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- developer
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `developer`;

CREATE TABLE `developer`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(128) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
