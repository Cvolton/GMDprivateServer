CREATE TABLE `actions_downloads` (
  `id` int(11) NOT NULL,
  `levelID` int(11) NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `uploadDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `actions_downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `levelID` (`levelID`,`ip`,`uploadDate`) USING BTREE;

ALTER TABLE `actions_downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

CREATE TABLE `actions_likes` (
  `id` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `isLike` tinyint(4) NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `uploadDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `actions_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `levelID` (`itemID`,`type`,`isLike`,`ip`,`uploadDate`) USING BTREE;

ALTER TABLE `actions_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;