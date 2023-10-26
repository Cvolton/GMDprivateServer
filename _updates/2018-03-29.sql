CREATE TABLE `modipperms` (
  `categoryID` int(11) NOT NULL,
  `actionFreeCopy` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `modips` ADD `modipCategory` int(11) NOT NULL AFTER `accountID`;
ALTER TABLE `roles` ADD `modipCategory` int(11) NOT NULL DEFAULT '0' AFTER `accountID`;

ALTER TABLE `modipperms`
  ADD PRIMARY KEY (`categoryID`);

ALTER TABLE `modipperms`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT;