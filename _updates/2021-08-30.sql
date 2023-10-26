UPDATE levels SET starAuto = '0' WHERE starAuto <> '1';
ALTER TABLE `levels` CHANGE `starAuto` `starAuto` TINYINT NOT NULL DEFAULT '0';
DROP TABLE `poll`;
