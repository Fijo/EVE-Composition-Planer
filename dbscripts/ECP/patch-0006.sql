-- 2015-9-17_5-Fijo-Add-Ind3x-Indexes

START TRANSACTION;
ALTER TABLE  `fittingrulerow` ADD UNIQUE  `fittingRuleEntityId` (  `fittingRuleEntityId` ,  `ind3x` ) COMMENT  '';

ALTER TABLE `itemfilterrule` ADD UNIQUE  `fittingRuleRowId` (  `fittingRuleRowId` ,  `ind3x` ) COMMENT  '';
COMMIT;