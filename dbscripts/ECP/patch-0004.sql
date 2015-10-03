-- 2015-9-17_4-Fijo-Add-ItemFilterTypeUpToDateField
ALTER TABLE  `fittingruleentity` ADD  `isFilterTypeUptodate` TINYINT UNSIGNED NOT NULL AFTER  `forkedId` ,
ADD INDEX (  `isFilterTypeUptodate` ) ;