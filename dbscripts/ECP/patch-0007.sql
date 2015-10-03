-- 2015-9-18_1-Fijo-Add-ItemFilterType-UniqueKey
ALTER TABLE  `itemfiltertype` ADD UNIQUE (`fittingRuleRowId`, `itemId`);