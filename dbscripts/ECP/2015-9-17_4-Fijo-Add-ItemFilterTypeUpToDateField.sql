ALTER TABLE  `fittingruleentity` ADD  `isFilterTypeUptodate` TINYINT UNSIGNED NOT NULL AFTER  `forkedId` ,
ADD INDEX (  `isFilterTypeUptodate` ) ;