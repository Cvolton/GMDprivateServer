ALTER TABLE `accounts` ADD `gjp2` VARCHAR(255) NULL AFTER `password`;
ALTER TABLE `users` ADD `moons` INT NOT NULL DEFAULT '0' AFTER `diamonds`; 
