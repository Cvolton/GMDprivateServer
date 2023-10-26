ALTER TABLE `songs` ADD `reuploadTime` int(11) NOT NULL DEFAULT '0' AFTER `levelsCount`;
ALTER TABLE `accounts` ADD `cS` int(11) NOT NULL AFTER `frS`;
