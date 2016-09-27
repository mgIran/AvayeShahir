/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : shahir

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2016-09-28 00:25:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ym_faq
-- ----------------------------
DROP TABLE IF EXISTS `ym_faq`;
CREATE TABLE `ym_faq` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
  `body` text COLLATE utf8_persian_ci NOT NULL COMMENT 'متن',
  `order` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `ym_faq_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ym_faq_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Table structure for ym_faq_categories
-- ----------------------------
DROP TABLE IF EXISTS `ym_faq_categories`;
CREATE TABLE `ym_faq_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
  `order` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
