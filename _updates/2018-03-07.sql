ALTER TABLE `roles` ADD `commandSongOwn` int(11) NOT NULL DEFAULT '1' AFTER `commandSharecpAll`;
ALTER TABLE `roles` ADD `commandSongAll` int(11) NOT NULL DEFAULT '0' AFTER `commandSongAll`;
ALTER TABLE `songs` CHANGE `hash` `hash` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '';
