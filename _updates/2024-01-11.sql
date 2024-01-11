ALTER TABLE `users` ADD `dinfo` VARCHAR(2048) NULL DEFAULT '' AFTER `accJetpack`, ADD `dinfow` INT NULL DEFAULT 0 AFTER `dinfo`, ADD `dinfog` INT NULL DEFAULT 0 AFTER `dinfow`;
