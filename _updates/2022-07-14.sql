ALTER TABLE `accounts` ADD `gjp2` VARCHAR(255) NULL AFTER `password`;
ALTER TABLE `users` ADD `moons` INT NOT NULL DEFAULT '0' AFTER `diamonds`; 
ALTER TABLE `levels` ADD `settingsString` MEDIUMTEXT NOT NULL DEFAULT '' AFTER `wt2`; 
ALTER TABLE `levelscores` ADD `clicks` INT NOT NULL DEFAULT '0' AFTER `coins`, ADD `time` INT NOT NULL DEFAULT '0' AFTER `clicks`, ADD `progresses` TEXT NOT NULL DEFAULT '' AFTER `time`, ADD `dailyID` INT NOT NULL DEFAULT '0' AFTER `progresses`; 
