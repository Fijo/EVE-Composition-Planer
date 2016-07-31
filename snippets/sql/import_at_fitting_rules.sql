-- these are the public fitting rules from the user Julian Aldurald on the evecomp.tk
-- version from 24th July 2016

-- this script will insert those rules into your local installed version of ECP for you.

-- to be changed in the insert statement of fittingruleentity
-- user id 31 (3rd column) to whatever user you'd like to have the fitting rules.
-- you can lookup the userid you wana use in the User table.

-- this script is ment to be ran on a empty ish database (pray you wount get id conflicts)

-- this is a temporary solution. I'm gona write a tool that does the date import for you which propobly wount be based on sql.

START TRANSACTION;

INSERT INTO `fittingruleentity`
(`id`, `name`, `userId`, `isGlobal`, `isListed`, `forkedId`, `isFilterTypeUptodate`, `lastModified`)
VALUES
(38,'Faction',31,0,1,0,0,'2016-07-24 14:31:57'),
(41,'Unallowed Remote Reps (AT XIII)',31,0,1,0,0,'2016-07-09 14:28:56'),
(42,'Too much Remote Cap Transfer',31,0,1,0,0,'2015-09-20 20:45:21'),
(43,'Too many ASBs',31,0,1,0,0,'2016-07-09 15:55:34'),
(44,'Not allowed modules (AT XIII)',31,0,1,0,0,'2016-07-07 21:58:29'),
(46,'Flagship (AT XIII)',31,0,1,45,0,'2016-07-09 17:09:53'),
(49,'Shiny modules (AT XIII)',31,0,1,0,0,'2016-07-09 16:49:48'),
(50,'Logi Cruiser (AT XIII)',31,0,1,0,0,'2016-07-09 15:40:50'),
(51,'Logi Frigate (AT XIII)',31,0,1,0,0,'2016-07-09 15:44:55'),
(52,'no more than 2 ships per type',31,1,1,0,0,'2016-07-10 14:51:26'),
(56,'Unallowed Remote Reps (AT XIV)',31,0,1,55,0,'2016-07-09 15:01:37'),
(58,'Not allowed items (AT XIV)',31,0,1,57,0,'2016-07-09 17:04:10'),
(61,'Logi Cruiser (AT XIV)',31,0,1,59,0,'2016-07-09 16:01:00'),
(62,'Logi Frigate (AT XIV)',31,0,1,60,0,'2016-07-09 15:45:44'),
(63,'too many of that item (AT XIV)',31,0,1,0,0,'2016-07-09 15:53:17'),
(66,'Flagship (AT XIV)',31,0,1,65,0,'2016-07-10 13:21:14'),
(67,'Shiny modules (AT XIV)',31,0,1,64,0,'2016-07-09 17:10:26');

INSERT INTO `fittingrulerow`
(`id`, `fittingRuleEntityId`, `ind3x`, `concatenation`, `comparison`, `value`)
VALUES
(104,38,0,0,3,0),
(107,41,0,0,3,0),
(108,42,0,0,3,1),
(109,43,0,0,3,1),
(110,44,0,0,3,0),
(140,46,2,10,3,0),
(149,49,0,0,3,0),
(150,50,0,0,3,0),
(152,51,0,0,3,0),
(158,41,1,10,2,0),
(159,44,1,11,3,0),
(160,44,2,11,3,0),
(161,44,3,11,3,0),
(162,44,4,11,3,0),
(163,46,3,10,2,1),
(164,46,0,0,2,0),
(165,46,1,11,2,0),
(168,46,4,10,1,2),
(169,46,5,10,1,3),
(170,52,0,0,1,3),
(171,52,1,10,1,3),
(172,52,2,10,1,3),
(173,52,3,10,1,3),
(174,52,4,10,1,3),
(175,52,5,10,1,3),
(176,52,6,10,1,3),
(177,52,7,10,1,3),
(178,52,8,10,1,3),
(179,52,9,10,1,3),
(180,52,10,10,1,3),
(181,52,11,10,1,3),
(182,52,12,10,1,3),
(183,52,13,10,1,3),
(184,52,14,10,1,3),
(185,52,15,10,1,3),
(186,52,16,10,1,3),
(187,52,17,10,1,3),
(188,52,18,10,1,3),
(189,52,19,10,1,3),
(190,52,20,10,1,3),
(191,52,21,10,1,3),
(192,52,22,10,1,3),
(193,52,23,10,1,3),
(194,52,24,10,1,3),
(195,52,25,10,1,3),
(196,52,26,10,1,3),
(197,52,27,10,1,3),
(198,52,28,10,1,3),
(199,52,29,10,1,3),
(200,52,30,10,1,3),
(201,52,31,10,1,3),
(202,52,32,10,1,3),
(203,52,33,10,1,3),
(204,52,34,10,1,3),
(205,52,35,10,1,3),
(324,52,36,10,1,3),
(325,52,37,10,1,3),
(326,52,38,10,1,3),
(327,52,39,10,1,3),
(328,52,40,10,1,3),
(329,52,41,10,1,3),
(330,52,42,10,1,3),
(331,52,43,10,1,3),
(332,52,44,10,1,3),
(333,52,45,10,1,3),
(334,52,46,10,1,3),
(335,52,47,10,1,3),
(336,52,48,10,1,3),
(337,52,49,10,1,3),
(338,52,50,10,1,3),
(339,52,51,10,1,3),
(340,52,52,10,1,3),
(341,52,53,10,1,3),
(342,52,54,10,1,3),
(343,52,55,10,1,3),
(344,52,56,10,1,3),
(345,52,57,10,1,3),
(346,52,58,10,1,3),
(347,52,59,10,1,3),
(348,52,60,10,1,3),
(349,52,61,10,1,3),
(350,52,62,10,1,3),
(351,52,63,10,1,3),
(352,52,64,10,1,3),
(353,52,65,10,1,3),
(354,52,66,10,1,3),
(355,52,67,10,1,3),
(356,52,68,10,1,3),
(357,52,69,10,1,3),
(358,52,70,10,1,3),
(359,52,71,10,1,3),
(360,52,72,10,1,3),
(361,52,73,10,1,3),
(362,52,74,10,1,3),
(363,52,75,10,1,3),
(364,52,76,10,1,3),
(365,52,77,10,1,3),
(366,52,78,10,1,3),
(367,52,79,10,1,3),
(368,52,80,10,1,3),
(369,52,81,10,1,3),
(370,52,82,10,1,3),
(371,52,83,10,1,3),
(372,52,84,10,1,3),
(373,52,85,10,1,3),
(374,52,86,10,1,3),
(375,52,87,10,1,3),
(376,52,88,10,1,3),
(377,52,89,10,1,3),
(378,52,90,10,1,3),
(379,52,91,10,1,3),
(380,52,92,10,1,3),
(381,52,93,10,1,3),
(382,52,94,10,1,3),
(383,52,95,10,1,3),
(384,52,96,10,1,3),
(385,52,97,10,1,3),
(386,52,98,10,1,3),
(387,52,99,10,1,3),
(388,52,100,10,1,3),
(389,52,101,10,1,3),
(390,52,102,10,1,3),
(391,52,103,10,1,3),
(392,52,104,10,1,3),
(393,52,105,10,1,3),
(394,52,106,10,1,3),
(395,52,107,10,1,3),
(396,52,108,10,1,3),
(397,52,109,10,1,3),
(398,52,110,10,1,3),
(399,52,111,10,1,3),
(400,52,112,10,1,3),
(401,52,113,10,1,3),
(402,52,114,10,1,3),
(403,52,115,10,1,3),
(404,52,116,10,1,3),
(405,52,117,10,1,3),
(406,52,118,10,1,3),
(407,52,119,10,1,3),
(408,52,120,10,1,3),
(409,52,121,10,1,3),
(1206,52,122,10,1,3),
(1207,52,123,10,1,3),
(1208,52,124,10,1,3),
(1209,52,125,10,1,3),
(1210,52,126,10,1,3),
(1211,52,127,10,1,3),
(1212,52,128,10,1,3),
(1213,52,129,10,1,3),
(1214,52,130,10,1,3),
(1215,52,131,10,1,3),
(1216,52,132,10,1,3),
(1217,52,133,10,1,3),
(1218,52,134,10,1,3),
(1219,52,135,10,1,3),
(1220,52,136,10,1,3),
(1221,52,137,10,1,3),
(1222,52,138,10,1,3),
(1223,52,139,10,1,3),
(1224,52,140,10,1,3),
(1225,52,141,10,1,3),
(1226,52,142,10,1,3),
(1227,52,143,10,1,3),
(1228,52,144,10,1,3),
(1229,52,145,10,1,3),
(1230,52,146,10,1,3),
(1231,52,147,10,1,3),
(1232,52,148,10,1,3),
(1233,52,149,10,1,3),
(1234,52,150,10,1,3),
(1235,52,151,10,1,3),
(1236,52,152,10,1,3),
(1237,52,153,10,1,3),
(1238,52,154,10,1,3),
(1239,52,155,10,1,3),
(1240,52,156,10,1,3),
(1241,52,157,10,1,3),
(1242,52,158,10,1,3),
(1243,52,159,10,1,3),
(1244,52,160,10,1,3),
(1245,52,161,10,1,3),
(1246,52,162,10,1,3),
(1247,52,163,10,1,3),
(1248,52,164,10,1,3),
(1249,52,165,10,1,3),
(1250,52,166,10,1,3),
(1251,52,167,10,1,3),
(1252,52,168,10,1,3),
(1253,52,169,10,1,3),
(1254,52,170,10,1,3),
(1255,52,171,10,1,3),
(1256,52,172,10,1,3),
(1257,52,173,10,1,3),
(1258,52,174,10,1,3),
(1259,52,175,10,1,3),
(1260,52,176,10,1,3),
(1261,52,177,10,1,3),
(1262,52,178,10,1,3),
(1263,52,179,10,1,3),
(1264,52,180,10,1,3),
(1265,52,181,10,1,3),
(1266,52,182,10,1,3),
(1267,52,183,10,1,3),
(1268,52,184,10,1,3),
(1269,52,185,10,1,3),
(1270,52,186,10,1,3),
(1271,52,187,10,1,3),
(1272,52,188,10,1,3),
(1273,52,189,10,1,3),
(1274,52,190,10,1,3),
(1275,52,191,10,1,3),
(1276,52,192,10,1,3),
(1277,52,193,10,1,3),
(1278,52,194,10,1,3),
(1279,52,195,10,1,3),
(1280,52,196,10,1,3),
(1281,52,197,10,1,3),
(1282,52,198,10,1,3),
(1283,52,199,10,1,3),
(1284,52,200,10,1,3),
(1285,52,201,10,1,3),
(1286,52,202,10,1,3),
(1287,52,203,10,1,3),
(1288,52,204,10,1,3),
(1289,52,205,10,1,3),
(1290,52,206,10,1,3),
(1291,52,207,10,1,3),
(1292,52,208,10,1,3),
(1293,52,209,10,1,3),
(1294,52,210,10,1,3),
(1295,52,211,10,1,3),
(1296,52,212,10,1,3),
(1297,52,213,10,1,3),
(1298,52,214,10,1,3),
(1299,52,215,10,1,3),
(1300,52,216,10,1,3),
(1301,52,217,10,1,3),
(1302,52,218,10,1,3),
(1303,52,219,10,1,3),
(1304,52,220,10,1,3),
(1305,52,221,10,1,3),
(1306,52,222,10,1,3),
(1307,52,223,10,1,3),
(1308,52,224,10,1,3),
(1309,52,225,10,1,3),
(1310,52,226,10,1,3),
(1311,52,227,10,1,3),
(1312,52,228,10,1,3),
(1313,52,229,10,1,3),
(1314,52,230,10,1,3),
(1315,52,231,10,1,3),
(1316,52,232,10,1,3),
(1317,52,233,10,1,3),
(1322,56,0,0,3,0),
(1323,56,1,10,2,0),
(1329,58,0,0,3,0),
(1330,58,1,11,3,0),
(1331,58,2,11,3,0),
(1332,58,3,11,3,0),
(1333,58,4,11,3,0),
(1336,61,0,0,3,0),
(1337,61,1,11,3,0),
(1338,61,2,10,3,0),
(1339,62,0,0,3,0),
(1340,63,0,0,3,1),
(1342,63,1,11,3,1),
(1343,58,5,11,3,0),
(1351,66,0,0,2,0),
(1352,66,1,11,2,0),
(1353,66,2,10,3,0),
(1354,66,3,10,2,1),
(1355,66,4,10,1,2),
(1356,66,5,10,1,3),
(1357,67,0,0,3,0),
(1358,52,234,10,1,3),
(1359,52,235,10,1,3),
(1360,52,236,10,1,3),
(1361,52,237,10,1,3),
(1362,52,238,10,1,3),
(1363,52,239,10,1,3),
(1364,52,240,10,1,3),
(1365,52,241,10,1,3),
(1366,52,242,10,1,3),
(1367,52,243,10,1,3),
(1368,52,244,10,1,3),
(1369,52,245,10,1,3),
(1370,52,246,10,1,3),
(1371,52,247,10,1,3);

INSERT INTO `itemfilterrule`
(`fittingRuleRowId`, `ind3x`, `concatenation`, `itemFilterDefId`, `comparison`, `value`, `content1`, `content2`)
VALUES
(104,0,0,3,6,'',4,0),
(107,0,0,2,6,'',7,325),
(107,1,11,2,6,'',7,41),
(108,0,0,2,6,'',7,67),
(109,0,0,2,6,'',7,40),
(109,1,10,5,8,'Ancillary',0,0),
(110,0,0,2,6,'',7,515),
(140,0,0,2,6,'',7,202),
(140,1,11,2,6,'',7,201),
(140,2,11,2,6,'',7,203),
(140,3,11,2,6,'',7,80),
(140,4,11,2,6,'',7,589),
(140,5,11,2,6,'',7,289),
(140,6,11,2,6,'',7,208),
(140,7,11,2,6,'',7,65),
(140,8,11,2,6,'',7,1154),
(140,9,11,2,6,'',7,379),
(140,10,11,2,6,'',7,899),
(140,11,11,2,6,'',7,52),
(149,0,0,2,6,'',7,0),
(149,1,10,4,3,'5',0,0),
(150,0,0,5,6,'Scythe',6,832),
(150,1,11,5,6,'Exequror',0,0),
(150,2,11,5,6,'Osprey',0,0),
(150,3,11,5,6,'Augoror',0,0),
(150,4,10,2,6,'',6,26),
(150,5,11,2,6,'',6,832),
(152,0,0,5,6,'Navitas',0,0),
(152,1,11,5,6,'Inquisitor',0,0),
(152,2,11,5,6,'Bantam',0,0),
(152,3,11,5,6,'Burst',0,0),
(152,4,10,2,6,'',6,25),
(158,0,0,5,6,'Scythe',0,0),
(158,1,11,5,6,'Augoror',0,0),
(158,2,11,5,6,'Osprey',0,0),
(158,3,11,5,6,'Exequror',0,0),
(158,4,10,2,6,'',6,26),
(158,5,11,5,6,'Navitas',0,0),
(158,6,11,5,6,'Bantam',0,0),
(158,7,11,5,6,'Inquisitor',0,0),
(158,8,11,5,6,'Burst',0,0),
(158,9,10,2,6,'',6,25),
(158,10,11,2,6,'',6,832),
(110,1,11,2,6,'',7,330),
(110,2,11,2,6,'',7,1154),
(159,0,0,2,6,'',7,1308),
(159,1,11,2,6,'',7,773),
(159,2,11,2,6,'',7,781),
(159,3,11,2,6,'',7,786),
(159,4,11,2,6,'',7,775),
(159,5,11,2,6,'',7,776),
(159,6,11,2,6,'',7,779),
(159,7,11,2,6,'',7,782),
(159,8,11,2,6,'',7,777),
(159,9,11,2,6,'',7,1232),
(159,10,11,2,6,'',7,1233),
(159,11,11,2,6,'',7,774),
(159,12,11,2,6,'',7,1234),
(159,13,10,3,6,'',2,0),
(160,0,0,2,6,'',8,909),
(160,1,11,2,6,'',8,911),
(161,0,0,2,6,'',18,100),
(161,1,10,4,3,'4',0,0),
(162,0,0,5,9,'01',0,0),
(162,1,10,5,9,'02',0,0),
(162,2,10,5,9,'03',0,0),
(162,3,10,2,7,'',20,744),
(162,4,10,2,7,'',20,745),
(162,5,10,2,6,'',20,0),
(140,12,11,2,6,'',7,367),
(140,13,11,2,6,'',7,59),
(140,14,11,2,6,'',7,205),
(140,15,11,2,6,'',7,302),
(140,16,11,2,6,'',7,209),
(140,17,11,2,6,'',7,213),
(140,18,11,2,6,'',7,211),
(140,19,11,2,6,'5',7,1396),
(140,20,11,2,6,'5',7,1395),
(140,21,11,7,6,'',12,62),
(163,0,0,2,6,'',6,27),
(164,0,0,2,6,'',7,40),
(165,0,0,2,6,'',7,62),
(168,0,0,2,6,'',7,40),
(169,0,0,2,6,'',7,62),
(149,2,10,5,5,'Polarized',0,0),
(170,0,0,5,6,'Cambion',0,0),
(171,0,0,5,6,'Enyo',0,0),
(172,0,0,5,6,'Freki',0,0),
(173,0,0,5,6,'Harpy',0,0),
(174,0,0,5,6,'Hawk',0,0),
(175,0,0,5,6,'Ishkur',0,0),
(176,0,0,5,6,'Jaguar',0,0),
(177,0,0,5,6,'Malice',0,0),
(178,0,0,5,6,'Retribution',0,0),
(179,0,0,5,6,'Wolf',0,0),
(180,0,0,5,6,'Abaddon',0,0),
(181,0,0,5,6,'Apocalypse',0,0),
(182,0,0,5,6,'Apocalypse Navy Issue',0,0),
(183,0,0,5,6,'Armageddon',0,0),
(184,0,0,5,6,'Armageddon Navy Issue',0,0),
(185,0,0,5,6,'Barghest',0,0),
(186,0,0,5,6,'Bhaalgorn',0,0),
(187,0,0,5,6,'Dominix',0,0),
(188,0,0,5,6,'Dominix Navy Issue',0,0),
(189,0,0,5,6,'Hyperion',0,0),
(190,0,0,5,6,'Machariel',0,0),
(191,0,0,5,6,'Maelstrom',0,0),
(192,0,0,5,6,'Megathron',0,0),
(193,0,0,5,6,'Megathron Navy Issue',0,0),
(194,0,0,5,6,'Nightmare',0,0),
(195,0,0,5,6,'Rattlesnake',0,0),
(196,0,0,5,6,'Raven',0,0),
(197,0,0,5,6,'Raven Navy Issue',0,0),
(198,0,0,5,6,'Rokh',0,0),
(199,0,0,5,6,'Scorpion',0,0),
(200,0,0,5,6,'Scorpion Navy Issue',0,0),
(201,0,0,5,6,'Tempest',0,0),
(202,0,0,5,6,'Tempest Fleet Issue',0,0),
(203,0,0,5,6,'Typhoon',0,0),
(204,0,0,5,6,'Typhoon Fleet Issue',0,0),
(205,0,0,5,6,'Vindicator',0,0),
(324,0,0,5,6,'Panther',0,0),
(325,0,0,5,6,'Redeemer',0,0),
(326,0,0,5,6,'Sin',0,0),
(327,0,0,5,6,'Widow',0,0),
(328,0,0,5,6,'Brutix',0,0),
(329,0,0,5,6,'Brutix Navy Issue',0,0),
(330,0,0,5,6,'Cyclone',0,0),
(331,0,0,5,6,'Drake',0,0),
(332,0,0,5,6,'Drake Navy Issue',0,0),
(333,0,0,5,6,'Ferox',0,0),
(334,0,0,5,6,'Gnosis',0,0),
(335,0,0,5,6,'Harbinger',0,0),
(336,0,0,5,6,'Harbinger Navy Issue',0,0),
(337,0,0,5,6,'Hurricane',0,0),
(338,0,0,5,6,'Hurricane Fleet Issue',0,0),
(339,0,0,5,6,'Myrmidon',0,0),
(340,0,0,5,6,'Prophecy',0,0),
(341,0,0,5,6,'Curse',0,0),
(342,0,0,5,6,'Huginn',0,0),
(343,0,0,5,6,'Lachesis',0,0),
(344,0,0,5,6,'Rook',0,0),
(345,0,0,5,6,'Absolution',0,0),
(346,0,0,5,6,'Astarte',0,0),
(347,0,0,5,6,'Claymore',0,0),
(348,0,0,5,6,'Damnation',0,0),
(349,0,0,5,6,'Eos',0,0),
(350,0,0,5,6,'Nighthawk',0,0),
(351,0,0,5,6,'Sleipnir',0,0),
(352,0,0,5,6,'Vulture',0,0),
(353,0,0,5,6,'Anathema',0,0),
(354,0,0,5,6,'Buzzard',0,0),
(355,0,0,5,6,'Cheetah',0,0),
(356,0,0,5,6,'Chremoas',0,0),
(357,0,0,5,6,'Helios',0,0),
(358,0,0,5,6,'Arbitrator',0,0),
(359,0,0,5,6,'Ashimmu',0,0),
(360,0,0,5,6,'Augoror',0,0),
(361,0,0,5,6,'Augoror Navy Issue',0,0),
(362,0,0,5,6,'Bellicose',0,0),
(363,0,0,5,6,'Blackbird',0,0),
(364,0,0,5,6,'Caracal',0,0),
(365,0,0,5,6,'Caracal Navy Issue',0,0),
(366,0,0,5,6,'Celestis',0,0),
(367,0,0,5,6,'Cynabal',0,0),
(368,0,0,5,6,'Exequror',0,0),
(369,0,0,5,6,'Exequror Navy Issue',0,0),
(370,0,0,5,6,'Gila',0,0),
(371,0,0,5,6,'Guardian-Vexor',0,0),
(372,0,0,5,6,'Maller',0,0),
(373,0,0,5,6,'Moa',0,0),
(374,0,0,5,6,'Omen',0,0),
(375,0,0,5,6,'Omen Navy Issue',0,0),
(376,0,0,5,6,'Orthrus',0,0),
(377,0,0,5,6,'Osprey',0,0),
(378,0,0,5,6,'Osprey Navy Issue',0,0),
(379,0,0,5,6,'Phantasm',0,0),
(380,0,0,5,6,'Rupture',0,0),
(381,0,0,5,6,'Scythe',0,0),
(382,0,0,5,6,'Scythe Fleet Issue',0,0),
(383,0,0,5,6,'Stabber',0,0),
(384,0,0,5,6,'Stabber Fleet Issue',0,0),
(385,0,0,5,6,'Stratios',0,0),
(386,0,0,5,6,'Thorax',0,0),
(387,0,0,5,6,'Vexor',0,0),
(388,0,0,5,6,'Vexor Navy Issue',0,0),
(389,0,0,5,6,'Victorieux Luxury Yacht',0,0),
(390,0,0,5,6,'Vigilant',0,0),
(391,0,0,5,6,'Algos',0,0),
(392,0,0,5,6,'Catalyst',0,0),
(393,0,0,5,6,'Coercer',0,0),
(394,0,0,5,6,'Corax',0,0),
(395,0,0,5,6,'Corax',0,0),
(396,0,0,5,6,'Cormorant',0,0),
(397,0,0,5,6,'Dragoon',0,0),
(398,0,0,5,6,'Talwar',0,0),
(399,0,0,5,6,'Thrasher',0,0),
(400,0,0,5,6,'Hyena',0,0),
(401,0,0,5,6,'Keres',0,0),
(402,0,0,5,6,'Kitsune',0,0),
(403,0,0,5,6,'Sentinel',0,0),
(404,0,0,5,6,'Arazu',0,0),
(405,0,0,5,6,'Chameleon',0,0),
(406,0,0,5,6,'Falcon',0,0),
(407,0,0,5,6,'Moracha',0,0),
(408,0,0,5,6,'Pilgrim',0,0),
(409,0,0,5,6,'Rapier',0,0),
(1206,0,0,5,6,'Astero',0,0),
(1207,0,0,5,6,'Atron',0,0),
(1208,0,0,5,6,'Bantam',0,0),
(1209,0,0,5,6,'Breacher',0,0),
(1210,0,0,5,6,'Burst',0,0),
(1211,0,0,5,6,'Caldari Navy Hookbill',0,0),
(1212,0,0,5,6,'Condor',0,0),
(1213,0,0,5,6,'Crucifier',0,0),
(1214,0,0,5,6,'Cruor',0,0),
(1215,0,0,5,6,'Daredevil',0,0),
(1216,0,0,5,6,'Dramiel',0,0),
(1217,0,0,5,6,'Echelon',0,0),
(1218,0,0,5,6,'Executioner',0,0),
(1219,0,0,5,6,'Federation Navy Comet',0,0),
(1220,0,0,5,6,'Garmur',0,0),
(1221,0,0,5,6,'Griffin',0,0),
(1222,0,0,5,6,'Heron',0,0),
(1223,0,0,5,6,'Imicus',0,0),
(1224,0,0,5,6,'Imperial Navy Slicer',0,0),
(1225,0,0,5,6,'Incursus',0,0),
(1226,0,0,5,6,'Inquisitor',0,0),
(1227,0,0,5,6,'Kestrel',0,0),
(1228,0,0,5,6,'Magnate',0,0),
(1229,0,0,5,6,'Maulus',0,0),
(1230,0,0,5,6,'Merlin',0,0),
(1231,0,0,5,6,'Navitas',0,0),
(1232,0,0,5,6,'Probe',0,0),
(1233,0,0,5,6,'Punisher',0,0),
(1234,0,0,5,6,'Republic Fleet Firetail',0,0),
(1235,0,0,5,6,'Rifter',0,0),
(1236,0,0,5,6,'Slasher',0,0),
(1237,0,0,5,6,'Succubus',0,0),
(1238,0,0,5,6,'Tormentor',0,0),
(1239,0,0,5,6,'Tristan',0,0),
(1240,0,0,5,6,'Venture',0,0),
(1241,0,0,5,6,'Vigil',0,0),
(1242,0,0,5,6,'Worm',0,0),
(1243,0,0,5,6,'Adrestia',0,0),
(1244,0,0,5,6,'Cerberus',0,0),
(1245,0,0,5,6,'Deimos',0,0),
(1246,0,0,5,6,'Eagle',0,0),
(1247,0,0,5,6,'Ishtar',0,0),
(1248,0,0,5,6,'Mimir',0,0),
(1249,0,0,5,6,'Muninn',0,0),
(1250,0,0,5,6,'Sacrilege',0,0),
(1251,0,0,5,6,'Vagabond',0,0),
(1252,0,0,5,6,'Vangel',0,0),
(1253,0,0,5,6,'Zealot',0,0),
(1254,0,0,5,6,'Broadsword',0,0),
(1255,0,0,5,6,'Devoter',0,0),
(1256,0,0,5,6,'Fiend',0,0),
(1257,0,0,5,6,'Onyx',0,0),
(1258,0,0,5,6,'Phobos',0,0),
(1259,0,0,5,6,'Badger',0,0),
(1260,0,0,5,6,'Bestower',0,0),
(1261,0,0,5,6,'Epithal',0,0),
(1262,0,0,5,6,'Hoarder',0,0),
(1263,0,0,5,6,'Iteron Mark V',0,0),
(1264,0,0,5,6,'Kryos',0,0),
(1265,0,0,5,6,'Mammoth',0,0),
(1266,0,0,5,6,'Miasmos',0,0),
(1267,0,0,5,6,'Nereus',0,0),
(1268,0,0,5,6,'Noctis',0,0),
(1269,0,0,5,6,'Primae',0,0),
(1270,0,0,5,6,'Sigil',0,0),
(1271,0,0,5,6,'Tayra',0,0),
(1272,0,0,5,6,'Wreathe',0,0),
(1273,0,0,5,6,'Ares',0,0),
(1274,0,0,5,6,'Claw',0,0),
(1275,0,0,5,6,'Crow',0,0),
(1276,0,0,5,6,'Crusader',0,0),
(1277,0,0,5,6,'Imp',0,0),
(1278,0,0,5,6,'Malediction',0,0),
(1279,0,0,5,6,'Raptor',0,0),
(1280,0,0,5,6,'Stiletto',0,0),
(1281,0,0,5,6,'Taranis',0,0),
(1282,0,0,5,6,'Whiptail',0,0),
(1283,0,0,5,6,'Eris',0,0),
(1284,0,0,5,6,'Flycatcher',0,0),
(1285,0,0,5,6,'Heretic',0,0),
(1286,0,0,5,6,'Sabre',0,0),
(1287,0,0,5,6,'Basilisk',0,0),
(1288,0,0,5,6,'Etana',0,0),
(1289,0,0,5,6,'Guardian',0,0),
(1290,0,0,5,6,'Oneiros',0,0),
(1291,0,0,5,6,'Scimitar',0,0),
(1292,0,0,5,6,'Golem',0,0),
(1293,0,0,5,6,'Kronos',0,0),
(1294,0,0,5,6,'Paladin',0,0),
(1295,0,0,5,6,'Vargur',0,0),
(1296,0,0,5,6,'Echo',0,0),
(1297,0,0,5,6,'Hematos',0,0),
(1298,0,0,5,6,'Ibis',0,0),
(1299,0,0,5,6,'Immolator',0,0),
(1300,0,0,5,6,'Impairor',0,0),
(1301,0,0,5,6,'Reaper',0,0),
(1302,0,0,5,6,'Taipan',0,0),
(1303,0,0,5,6,'Velator',0,0),
(1304,0,0,5,6,'Violator',0,0),
(1305,0,0,5,6,'Hound',0,0),
(1306,0,0,5,6,'Manticore',0,0),
(1307,0,0,5,6,'Nemesis',0,0),
(1308,0,0,5,6,'Nemesis',0,0),
(1309,0,0,5,6,'Purifier',0,0),
(1310,0,0,5,6,'Legion',0,0),
(1311,0,0,5,6,'Loki',0,0),
(1312,0,0,5,6,'Proteus',0,0),
(1313,0,0,5,6,'Tengu',0,0),
(1314,0,0,5,6,'Confessor',0,0),
(1315,0,0,5,6,'Hecate',0,0),
(1316,0,0,5,6,'Jackdaw',0,0),
(1317,0,0,5,6,'Svipul',0,0),
(140,22,11,2,6,'',7,40),
(140,23,11,2,6,'',7,62),
(140,24,10,4,3,'5',0,0),
(1322,0,0,2,6,'',7,41),
(1323,0,0,5,6,'Scythe',0,0),
(1323,1,11,5,6,'Augoror',0,0),
(1323,2,11,5,6,'Osprey',0,0),
(1323,3,11,5,6,'Exequror',0,0),
(1323,4,10,2,6,'',6,26),
(1323,5,11,5,6,'Navitas',0,0),
(1323,6,11,5,6,'Bantam',0,0),
(1323,7,11,5,6,'Inquisitor',0,0),
(1323,8,11,5,6,'Burst',0,0),
(1323,9,10,2,6,'',6,25),
(1323,10,11,2,6,'',6,832),
(1322,1,11,2,6,'',7,325),
(1323,11,11,2,6,'',6,1527),
(1323,12,11,2,6,'',6,963),
(1329,0,0,2,6,'',7,515),
(1329,1,11,2,6,'',7,330),
(1329,2,11,2,6,'',7,1154),
(1330,0,0,2,6,'',7,1308),
(1330,1,11,2,6,'',7,773),
(1330,2,11,2,6,'',7,781),
(1330,3,11,2,6,'',7,786),
(1330,4,11,2,6,'',7,775),
(1330,5,11,2,6,'',7,776),
(1330,6,11,2,6,'',7,779),
(1330,7,11,2,6,'',7,782),
(1330,8,11,2,6,'',7,777),
(1330,9,11,2,6,'',7,1232),
(1330,10,11,2,6,'',7,1233),
(1330,11,11,2,6,'',7,774),
(1330,12,11,2,6,'',7,1234),
(1330,13,10,3,6,'',2,0),
(1331,0,0,2,6,'',8,909),
(1331,1,11,2,6,'',8,911),
(1332,0,0,2,6,'',18,100),
(1332,1,11,2,6,'4',18,640),
(1333,0,0,5,9,'01',0,0),
(1333,1,10,5,9,'02',0,0),
(1333,2,10,5,9,'03',0,0),
(1333,3,10,2,7,'',20,744),
(1333,4,10,2,7,'',20,745),
(1333,5,10,2,6,'',20,0),
(1329,3,11,2,6,'',7,1533),
(1329,4,11,2,6,'',7,67),
(1336,0,0,5,6,'Scythe',6,832),
(1336,1,11,5,6,'Exequror',0,0),
(1336,2,11,5,6,'Osprey',0,0),
(1336,3,11,5,6,'Augoror',0,0),
(1336,4,10,2,6,'',6,26),
(1336,5,11,2,6,'',6,832),
(1337,0,0,2,6,'',6,963),
(1338,0,0,2,6,'',7,325),
(1338,1,11,2,6,'',7,41),
(1339,0,0,5,6,'Navitas',0,0),
(1339,1,11,5,6,'Inquisitor',0,0),
(1339,2,11,5,6,'Bantam',0,0),
(1339,3,11,5,6,'Burst',0,0),
(1339,4,10,2,6,'',6,25),
(1339,5,11,2,6,'',6,1527),
(1340,0,0,2,6,'',7,40),
(1340,1,10,5,8,'Ancillary',0,0),
(1342,0,0,2,6,'',7,899),
(1332,2,10,4,3,'4',0,0),
(1343,0,0,2,6,'',8,0),
(1343,1,10,3,6,'',4,0),
(1343,2,10,5,4,'Dark Blood',0,0),
(1343,3,11,5,4,'True Sansha',0,0),
(1343,4,11,5,4,'Dread Gurista',0,0),
(1343,5,11,5,4,'Guardian',0,0),
(1343,6,11,5,4,'Dread Gurista',0,0),
(1343,7,11,5,4,'Domination',0,0),
(1351,0,0,2,6,'',7,40),
(1352,0,0,2,6,'',7,62),
(1353,0,0,2,6,'',7,202),
(1353,1,11,2,6,'',7,201),
(1353,2,11,2,6,'',7,203),
(1353,3,11,2,6,'',7,80),
(1353,4,11,2,6,'',7,589),
(1353,5,11,2,6,'',7,289),
(1353,6,11,2,6,'',7,208),
(1353,7,11,2,6,'',7,65),
(1353,8,11,2,6,'',7,1154),
(1353,9,11,2,6,'',7,379),
(1353,10,11,2,6,'',7,899),
(1353,11,11,2,6,'',7,52),
(1353,12,11,2,6,'',7,367),
(1353,13,11,2,6,'',7,59),
(1353,14,11,2,6,'',7,205),
(1353,15,11,2,6,'',7,302),
(1353,16,11,2,6,'',7,209),
(1353,17,11,2,6,'',7,213),
(1353,18,11,2,6,'',7,211),
(1353,19,11,2,6,'5',7,1396),
(1353,20,11,2,6,'5',7,1395),
(1353,21,11,2,6,'',7,1672),
(1353,22,11,7,6,'',12,40),
(1353,23,11,2,6,'',7,40),
(1353,24,11,2,6,'5',7,62),
(1354,0,0,2,6,'',6,27),
(1355,0,0,2,6,'',7,40),
(1356,0,0,2,6,'',7,62),
(1357,0,0,2,6,'',7,0),
(1357,1,10,4,3,'5',0,0),
(1357,2,10,5,5,'Polarized',0,0),
(1353,25,10,4,3,'5',0,0),
(1358,0,0,5,6,'Endurance',0,0),
(1359,0,0,5,6,'Prospect',0,0),
(1360,0,0,5,6,'Deacon',0,0),
(1361,0,0,5,6,'Kirin',0,0),
(1362,0,0,5,6,'Thalia',0,0),
(1363,0,0,5,6,'Scalpel',0,0),
(1364,0,0,5,6,'Vigil Fleet Issue',0,0),
(1365,0,0,5,6,'Maulus Navy Issue',0,0),
(1366,0,0,5,6,'Griffin Navy Issue',0,0),
(1367,0,0,5,6,'Crucifier Navy Issue',0,0),
(1368,0,0,5,6,'Pontifex',0,0),
(1369,0,0,5,6,'Stork',0,0),
(1370,0,0,5,6,'Magus',0,0),
(1371,0,0,5,6,'Bifrost',0,0);

COMMIT;