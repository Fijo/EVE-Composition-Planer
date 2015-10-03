-- 2015-9-17_1-Fijo-Add-List-Indexes

START TRANSACTION;
ALTER TABLE fittingruleentity ADD INDEX (lastModified);
ALTER TABLE fittingruleentity ADD INDEX (userId, lastModified);

ALTER TABLE compositionentity ADD INDEX (lastModified);
ALTER TABLE compositionentity ADD INDEX (userId, lastModified);

ALTER TABLE rulesetentity ADD INDEX (lastModified);
ALTER TABLE rulesetentity ADD INDEX (userId, lastModified);
COMMIT;