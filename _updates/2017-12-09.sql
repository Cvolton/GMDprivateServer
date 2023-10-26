ALTER TABLE `accounts` CHANGE `cS` `cS` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `levels` CHANGE `levelString` `levelString` longtext COLLATE utf8_unicode_ci;
ALTER TABLE `levels` CHANGE `rateDate` `rateDate` bigint(20) NOT NULL DEFAULT '0';
