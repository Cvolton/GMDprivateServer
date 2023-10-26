ALTER TABLE `levels` CHANGE `levelString` `levelString` longtext COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `roles` ADD `actionSuggestRating` int(11) NOT NULL DEFAULT 0 AFTER `actionRequestMod`;
ALTER TABLE `roles` ADD `toolSuggestlist` int(11) NOT NULL DEFAULT 0 AFTER `toolModactions`;
ALTER TABLE `roles` CHANGE `modBadgeLevel` `modBadgeLevel` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `suggest` `ID` int(11) NOT NULL, FIRST;
ALTER TABLE `actions` ADD KEY `type` (`type`);
ALTER TABLE `suggest` ADD PRIMARY KEY (`ID`);
ALTER TABLE `suggest` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
