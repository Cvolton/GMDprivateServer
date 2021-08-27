ALTER TABLE `roles` ADD `modBadgeLevel` int(11) NOT NULL AFTER `commentColor`;
ALTER TABLE `levelscores` ADD `attempts` int(11) NOT NULL DEFAULT '0' AFTER `uploadDate`;
ALTER TABLE `levelscores` ADD `coins` int(11) NOT NULL DEFAULT '0' AFTER `attempts`;
