DROP TABLE IF EXISTS `#__poster_calendar_events`;

CREATE TABLE `#__poster_calendar_events` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `published` tinyint(4) NOT NULL DEFAULT '1',
    `title` VARCHAR(255) NOT NULL,
    `date` DATE NOT NULL,
    `image` VARCHAR(255) NOT NULL,
    `thumb` VARCHAR(255) NOT NULL,
    primary key (id)
)   ENGINE = InnoDB
	AUTO_INCREMENT = 0
	DEFAULT CHARSET = utf8mb4
    DEFAULT COLLATE = utf8mb4_unicode_ci;