
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- article
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `article_id` VARCHAR(200) NOT NULL,
    `link` TEXT NOT NULL,
    `site` VARCHAR(50) NOT NULL,
    `ts` INTEGER NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `content` TEXT NOT NULL,
    `cats` json NOT NULL,
    `last_tagged` INTEGER NOT NULL,
    `type` enum('official','news','discussion','guides','media') NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `article_id` (`article_id`, `site`),
    INDEX `ts` (`ts`),
    INDEX `last_tagged` (`last_tagged`),
    INDEX `type` (`type`),
    INDEX `site` (`site`, `ts`, `title`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- article_tags
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `article_tags`;

CREATE TABLE `article_tags`
(
    `article_id` INTEGER NOT NULL,
    `tag_id` INTEGER NOT NULL,
    PRIMARY KEY (`article_id`,`tag_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- article_title_tags
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `article_title_tags`;

CREATE TABLE `article_title_tags`
(
    `article_id` INTEGER NOT NULL,
    `tag_id` INTEGER NOT NULL,
    PRIMARY KEY (`article_id`,`tag_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- auction_aggregates
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `auction_aggregates`;

CREATE TABLE `auction_aggregates`
(
    `item_def` VARCHAR(100) NOT NULL,
    `server` enum('GLOBAL','RU') NOT NULL,
    `low` int(10) unsigned NOT NULL,
    `mean` double unsigned NOT NULL,
    `median` double unsigned NOT NULL,
    `count` int(10) unsigned NOT NULL,
    `inserted` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE INDEX `item_def_2` (`item_def`, `server`, `inserted`),
    INDEX `item_def` (`item_def`, `server`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- auction_details
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `auction_details`;

CREATE TABLE `auction_details`
(
    `item_def` VARCHAR(100) NOT NULL,
    `server` enum('GLOBAL','RU') NOT NULL,
    `seller_name` VARCHAR(50) NOT NULL,
    `seller_handle` VARCHAR(50) NOT NULL,
    `expire_time` BIGINT NOT NULL,
    `price` int(10) unsigned NOT NULL,
    `count` int(10) unsigned NOT NULL,
    `price_per` float unsigned NOT NULL,
    PRIMARY KEY (`item_def`,`server`,`seller_name`,`seller_handle`,`expire_time`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- auction_items
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `auction_items`;

CREATE TABLE `auction_items`
(
    `item_def` VARCHAR(100) NOT NULL,
    `item_name` VARCHAR(100) NOT NULL,
    `quality` VARCHAR(20) NOT NULL,
    `categories` JSON NOT NULL,
    `crawl_category` enum('Miscellaneous','Bags','Companions','Consumables','Equipment','Fashion','Mounts','Professions','Refinement','Stronghold'),
    `allow_auto` TINYINT(1) DEFAULT 1 NOT NULL,
    `server` enum('GLOBAL','RU') DEFAULT 'GLOBAL' NOT NULL,
    `update_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`item_def`,`server`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- devtracker
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `devtracker`;

CREATE TABLE `devtracker`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `dev_name` VARCHAR(30) NOT NULL,
    `dev_id` INTEGER NOT NULL,
    `category_id` INTEGER NOT NULL,
    `discussion_id` INTEGER NOT NULL,
    `discussion_name` TEXT NOT NULL,
    `comment_id` INTEGER DEFAULT 0 NOT NULL,
    `body` TEXT NOT NULL,
    `date` DATETIME NOT NULL,
    `is_poll` TINYINT(1) NOT NULL,
    `is_announce` TINYINT(1) NOT NULL,
    `is_closed` TINYINT(1) NOT NULL,
    PRIMARY KEY (`ID`),
    UNIQUE INDEX `discussionID` (`discussion_id`, `comment_id`),
    INDEX `date` (`date`, `dev_id`, `category_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- settings
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings`
(
    `name` VARCHAR(20) NOT NULL,
    `value` json NOT NULL,
    PRIMARY KEY (`name`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- tag
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tag`;

CREATE TABLE `tag`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `term` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `id` (`id`, `term`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
