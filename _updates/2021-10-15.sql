ALTER TABLE `roles` ADD `actionDeleteComment` INT NOT NULL DEFAULT '0' AFTER `actionSuggestRating`;

ALTER TABLE `accounts` DROP `friends`;
ALTER TABLE `accounts` DROP `blockedBy`;
ALTER TABLE `accounts` DROP `blocked`;
ALTER TABLE `accounts` DROP `saveKey`;
ALTER TABLE `accounts` DROP `saveData`;
ALTER TABLE `accounts` DROP `userID`;
ALTER TABLE `accounts` DROP `secret`;

ALTER TABLE `accounts` ADD `isActive` BOOLEAN NOT NULL DEFAULT FALSE AFTER `discordLinkReq`;
ALTER TABLE `accounts` ADD INDEX(`isActive`);
