ALTER TABLE `users` ADD `dinfo` VARCHAR(2048) NULL DEFAULT '' AFTER `accJetpack`, ADD `dinfow` VARCHAR(2048) NULL DEFAULT '' AFTER `dinfo`, ADD `dinfog` VARCHAR(2048) NULL DEFAULT '' AFTER `dinfow`;
/* IDK if dinfow and dinfog needs varchar instead of int */
