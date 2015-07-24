# This script is for MySQL 5.6.5 and higher, as those versions
# are not subject to an age old MySQL bug.
# See http://stackoverflow.com/a/17498167

CREATE DATABASE ModelWorlds;
USE ModelWorlds;

CREATE TABLE `users` (
  `_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` CHAR(50) NOT NULL,
  `username` CHAR(25) NOT NULL,
  `password` CHAR(255) NOT NULL,
  `date_joined` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activated` ENUM('Y','N') NOT NULL DEFAULT 'N',
  `last_active` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`_id`),
  UNIQUE INDEX `name` (`username`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
