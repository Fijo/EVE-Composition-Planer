-- 2015-10-17_2-Fijo-PhealNg-Cache

CREATE TABLE `phealng-cache` (
    `userId` INT(10) UNSIGNED NOT NULL,
    `scope` VARCHAR(50) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `args` VARCHAR(250) NOT NULL,
    `cachedUntil` TIMESTAMP NOT NULL,
    `xml` LONGTEXT NOT NULL,
    PRIMARY KEY (`userId`, `scope`, `name`, `args`)
)
COMMENT='Caching for PhealNG'
COLLATE='utf8_general_ci'
ENGINE=InnoDB;