ALTER TABLE `users` ADD `dinfo` VARCHAR(100) NULL DEFAULT '' AFTER `accJetpack`, ADD `dinfow` INT NULL DEFAULT 0 AFTER `dinfo`, ADD `dinfog` INT NULL DEFAULT 0 AFTER `dinfow`;
ALTER TABLE `users` DROP `dinfow`, DROP `dinfog`; /* You know what? Fuck it! */
