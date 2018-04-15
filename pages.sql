-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `title` varchar(350) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `content` text NOT NULL,
  `tree_model` longtext NOT NULL,
  `uniq_id` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2018-04-15 20:29:13
