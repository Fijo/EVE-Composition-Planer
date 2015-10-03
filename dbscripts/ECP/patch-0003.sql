-- 2015-9-17_3-Fijo-Add-ItemFilterType

START TRANSACTION;

CREATE TABLE IF NOT EXISTS `itemfiltertype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fittingRuleRowId` int(10) unsigned NOT NULL,
  `itemId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE itemfiltertype
	ADD CONSTRAINT `itemfiltertype_fk_ba234f` FOREIGN KEY (`fittingRuleRowId`) REFERENCES `fittingrulerow` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

COMMIT;