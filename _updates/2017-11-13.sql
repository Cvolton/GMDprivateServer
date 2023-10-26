ALTER TABLE `dailyfeatures` ADD `type` int(11) NOT NULL DEFAULT '0' AFTER `timestamp`;
ALTER TABLE `modactions` CHANGE `value4` `value4` varchar(255) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `roles` ADD `commentColor` varchar(11) NOT NULL DEFAULT '000,000,000' AFTER `isDefault`;
