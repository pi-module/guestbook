CREATE TABLE `{text}` (
  `id`               INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `title`            VARCHAR(255)        NOT NULL DEFAULT '',
  `text_description` MEDIUMTEXT,
  `status`           TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `time_create`      INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `uid`              INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `email`            VARCHAR(64)         NOT NULL DEFAULT '',
  `name`             VARCHAR(64)         NOT NULL DEFAULT '',
  `phone`            VARCHAR(50)         NOT NULL DEFAULT '',
  `ip`               CHAR(15)            NOT NULL DEFAULT '',
  `hits`             INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `time_create` (`time_create`),
  KEY `status` (`status`),
  KEY `uid` (`uid`),
  KEY `story_order` (`time_create`, `id`)
);