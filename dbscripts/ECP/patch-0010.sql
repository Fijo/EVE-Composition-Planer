-- 2015-10-7_1-Fijo-Rename-Username-to-Name

ALTER TABLE  `user` CHANGE  `username`  `name` VARCHAR( 32 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;