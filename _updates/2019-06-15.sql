CREATE TABLE `suggest` (
  `suggestBy` int(11) NOT NULL DEFAULT '0',
  `suggestLevelId` int(11) NOT NULL DEFAULT '0',
  `suggestDifficulty` int(11) NOT NULL DEFAULT '0' COMMENT '0 - NA 10 - Easy 20 - Normal 30 - Hard 40 - Harder 50 - Insane/Demon/Auto',
  `suggestStars` int(11) NOT NULL DEFAULT '0',
  `suggestFeatured` int(11) NOT NULL DEFAULT '0',
  `suggestAuto` int(11) NOT NULL DEFAULT '0',
  `suggestDemon` int(11) NOT NULL DEFAULT '0',
  `timestamp` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;