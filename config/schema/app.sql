#App sql generated on: 2010-05-19 10:52:16 : 1274262736

DROP TABLE IF EXISTS `tags`;
DROP TABLE IF EXISTS `tags_objects`;


CREATE TABLE `tags` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(100) DEFAULT NULL,
	`slug` varchar(100) DEFAULT NULL,
	`used` int(11) DEFAULT NULL,
	`tag_object_count` int(11) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime NOT NULL,
	`created_by` int(11) DEFAULT NULL,
	`modified_by` int(11) DEFAULT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `name` (`name`))	DEFAULT CHARSET=utf8,
COLLATE=utf8_general_ci,
ENGINE=InnoDB;

CREATE TABLE `tags_objects` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`tag_id` int(11) DEFAULT 0 NOT NULL,
	`object` varchar(100) NOT NULL,
	`object_id` int(11) DEFAULT 0 NOT NULL,
	`sorting` int(11) DEFAULT 0 NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
COLLATE=utf8_general_ci,
ENGINE=InnoDB;

