ALTER TABLE `users` ADD `color3` INT NOT NULL DEFAULT '0' AFTER `color2`;
ALTER TABLE `users` ADD `accSwing` INT NOT NULL DEFAULT '0' AFTER `accGlow`, ADD `accJetpack` INT NOT NULL DEFAULT '0' AFTER `accSwing`;
