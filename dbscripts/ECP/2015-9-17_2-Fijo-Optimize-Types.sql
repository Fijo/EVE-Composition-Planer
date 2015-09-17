ALTER TABLE  `comparison` CHANGE  `name`  `name` VARCHAR( 24 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;
ALTER TABLE  `type` CHANGE  `name`  `name` VARCHAR( 8 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;
ALTER TABLE  `fitentrytype` CHANGE  `name`  `name` VARCHAR( 12 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;
ALTER TABLE  `itemfilterdef` CHANGE  `name`  `name` VARCHAR( 12 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;
ALTER TABLE  `itemfilterdef` CHANGE  `depth`  `depth` TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `itemfilterdef` CHANGE  `minlength`  `minlength` TINYINT( 4 ) NOT NULL ;
ALTER TABLE  `itemfilterdef` CHANGE  `maxlength`  `maxlength` TINYINT( 11 ) NOT NULL ;


ALTER TABLE  `fitentry` CHANGE  `ind3x`  `ind3x` TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `fittingrulerow` CHANGE  `ind3x`  `ind3x` TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `itemfilterrule` CHANGE  `ind3x`  `ind3x` TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `rulesetfilterrule` CHANGE  `ind3x`  `ind3x` TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `rulesetrulerow` CHANGE  `ind3x`  `ind3x` TINYINT( 4 ) UNSIGNED NOT NULL ;


ALTER TABLE `fitentry` DROP FOREIGN KEY `fitentry_fk_61f8f2`;

ALTER TABLE  `fitentrytype` CHANGE id id TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `fitentry` CHANGE fitEntryTypeId fitEntryTypeId TINYINT( 4 ) UNSIGNED NOT NULL ;

ALTER TABLE `fitentry` ADD CONSTRAINT `fitentry_fk_61f8f2` FOREIGN KEY (`fitEntryTypeId`) REFERENCES `fitentrytype` (`id`);


ALTER TABLE `fittingrulerow` DROP FOREIGN KEY `fittingrulerow_fk_2c7fa1`;
ALTER TABLE `itemfilterrule` DROP FOREIGN KEY `itemfilterrule_fk_2c7fa1`;
ALTER TABLE `rulesetfilterrule` DROP FOREIGN KEY `rulesetfilterrule_fk_2c7fa1`;
ALTER TABLE `typecomparison` DROP FOREIGN KEY `typecomparison_fk_0338d3`;

ALTER TABLE  `comparison` CHANGE id id TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `fittingrulerow` CHANGE comparison comparison TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `fittingrulerow` CHANGE concatenation concatenation TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `itemfilterrule` CHANGE comparison comparison TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `itemfilterrule` CHANGE concatenation concatenation TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `rulesetfilterrule` CHANGE comparison comparison TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `rulesetfilterrule` CHANGE concatenation concatenation TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `typecomparison` CHANGE comparisonId comparisonId TINYINT( 4 ) UNSIGNED NOT NULL ;

ALTER TABLE `fittingrulerow` ADD CONSTRAINT `fittingrulerow_fk_2c7fa1` FOREIGN KEY (`comparison`) REFERENCES `comparison` (`id`);
ALTER TABLE `itemfilterrule` ADD CONSTRAINT `itemfilterrule_fk_2c7fa1` FOREIGN KEY (`comparison`) REFERENCES `comparison` (`id`);
ALTER TABLE `rulesetfilterrule` ADD CONSTRAINT `rulesetfilterrule_fk_2c7fa1` FOREIGN KEY (`comparison`) REFERENCES `comparison` (`id`);
ALTER TABLE `typecomparison` ADD CONSTRAINT `typecomparison_fk_0338dhttp://fijo-dev01/phpmyadmin/sql.php?server=1&db=ecp&table=itemfilterrule&pos=0&token=d4c5bd40acd6a57e9401d3b02ef839b23` FOREIGN KEY (`comparisonId`) REFERENCES `comparison` (`id`);


ALTER TABLE `itemfilterrule` DROP FOREIGN KEY `itemfilterrule_fk_c56a57`;

ALTER TABLE  `itemfilterdef` CHANGE id id TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `itemfilterrule` CHANGE itemFilterDefId itemFilterDefId TINYINT( 4 ) UNSIGNED NOT NULL ;

ALTER TABLE `itemfilterrule` ADD CONSTRAINT `itemfilterrule_fk_c56a57` FOREIGN KEY (`itemFilterDefId`) REFERENCES `itemfilterdef` (`id`);


ALTER TABLE `itemfilterdef` DROP FOREIGN KEY `itemfilterdef_fk_af1a2f`;
ALTER TABLE `typecomparison` DROP FOREIGN KEY `typecomparison_fk_af1a2f`;

ALTER TABLE  `type` CHANGE id id TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `itemfilterdef` CHANGE typeId typeId TINYINT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `typecomparison` CHANGE typeId typeId TINYINT( 4 ) UNSIGNED NOT NULL ;

ALTER TABLE `itemfilterdef` ADD CONSTRAINT `itemfilterdef_fk_af1a2f` FOREIGN KEY (`typeId`) REFERENCES `type` (`id`);
ALTER TABLE `typecomparison` ADD CONSTRAINT `typecomparison_fk_af1a2f` FOREIGN KEY (`typeId`) REFERENCES `type` (`id`);


ALTER TABLE  `typecomparison` CHANGE  `id`  `id` TINYINT( 4 ) UNSIGNED NOT NULL AUTO_INCREMENT ;