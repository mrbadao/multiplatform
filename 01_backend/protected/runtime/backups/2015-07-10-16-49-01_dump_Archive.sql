SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";

--
-- Database: `sup_admin`
--
DROP DATABASE IF EXISTS `sup_admin`;
CREATE DATABASE IF NOT EXISTS `sup_admin` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sup_admin`;

--
-- Structure for table `archive_action`
--

DROP TABLE IF EXISTS `archive_action`;
CREATE TABLE `archive_action` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `controller_id` int(10) NOT NULL,
  `action_abbr_cd` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `archive_action_fk_controller_idx` (`controller_id`),
  CONSTRAINT `archive_action_fk_controller` FOREIGN KEY (`controller_id`) REFERENCES `archive_controller` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `archive_action`;

--
-- Structure for table `archive_categories`
--

DROP TABLE IF EXISTS `archive_categories`;
CREATE TABLE `archive_categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `page_id` int(10) NOT NULL,
  `category_name` varchar(128) NOT NULL,
  `category_abbr_cd` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `archive_categories_fk_page_id_idx` (`page_id`),
  CONSTRAINT `archive_categories_fk_page_id` FOREIGN KEY (`page_id`) REFERENCES `archive_pages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `archive_categories`;

--
-- Structure for table `archive_controller`
--

DROP TABLE IF EXISTS `archive_controller`;
CREATE TABLE `archive_controller` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_id` int(10) NOT NULL,
  `name` varchar(128) NOT NULL,
  `controller_abbr_cd` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `archive_controller_fk_module_id_idx` (`module_id`),
  CONSTRAINT `archive_controller_fk_module_id` FOREIGN KEY (`module_id`) REFERENCES `archive_modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `archive_controller`;

--
-- Structure for table `archive_entries`
--

DROP TABLE IF EXISTS `archive_entries`;
CREATE TABLE `archive_entries` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `site_id` int(10) NOT NULL,
  `entry_type` int(1) NOT NULL,
  `category_id` int(10) NOT NULL,
  `entry_title` text NOT NULL,
  `content_id` int(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `archive_entry_fk_category_id_idx` (`category_id`),
  CONSTRAINT `archive_entry_fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `archive_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `archive_entries`;

--
-- Structure for table `archive_entry_content_article`
--

DROP TABLE IF EXISTS `archive_entry_content_article`;
CREATE TABLE `archive_entry_content_article` (
  `id` int(10) NOT NULL,
  `content` longtext NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `archive_entry_content_article`;

--
-- Structure for table `archive_menu`
--

DROP TABLE IF EXISTS `archive_menu`;
CREATE TABLE `archive_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `site_id` int(10) NOT NULL,
  `menu_name` varchar(128) NOT NULL,
  `menu_abbr_cd` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `archive_menu_fk_site_id_idx` (`site_id`),
  CONSTRAINT `archive_menu_fk_site_id` FOREIGN KEY (`site_id`) REFERENCES `archive_site` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `archive_menu`;

--
-- Structure for table `archive_modules`
--

DROP TABLE IF EXISTS `archive_modules`;
CREATE TABLE `archive_modules` (
  `id` int(10) NOT NULL,
  `name` varchar(128) NOT NULL,
  `module_abbr_cd` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `archive_modules`;

--
-- Structure for table `archive_page_type`
--

DROP TABLE IF EXISTS `archive_page_type`;
CREATE TABLE `archive_page_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `module_id` int(10) NOT NULL,
  `controller_id` int(10) NOT NULL,
  `action_id` int(10) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `archive_page_type_fk_module_id_idx` (`module_id`),
  KEY `archive_page_type_fk__controller_id_idx` (`controller_id`),
  KEY `archive_page_type_fk_action_id_idx` (`action_id`),
  CONSTRAINT `archive_page_type_fk_action_id` FOREIGN KEY (`action_id`) REFERENCES `archive_action` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `archive_page_type_fk_controller_id` FOREIGN KEY (`controller_id`) REFERENCES `archive_controller` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `archive_page_type_fk_module_id` FOREIGN KEY (`module_id`) REFERENCES `archive_modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `archive_page_type`;

--
-- Structure for table `archive_pages`
--

DROP TABLE IF EXISTS `archive_pages`;
CREATE TABLE `archive_pages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `site_id` int(10) DEFAULT NULL,
  `page_title` varchar(128) NOT NULL,
  `page_abbr_cd` varchar(128) NOT NULL,
  `page_type` int(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `archive_pages_fk_site_id_idx` (`site_id`),
  KEY `archive_pages_fk_page_type_idx` (`page_type`),
  CONSTRAINT `archive_pages_fk_page_type` FOREIGN KEY (`page_type`) REFERENCES `archive_page_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `archive_pages_fk_site_id` FOREIGN KEY (`site_id`) REFERENCES `archive_site` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `archive_pages`;

--
-- Structure for table `archive_site`
--

DROP TABLE IF EXISTS `archive_site`;
CREATE TABLE `archive_site` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(128) NOT NULL,
  `staff_id` int(10) NOT NULL,
  `site_abbr_cd` varchar(128) NOT NULL,
  `use_single_domain` tinyint(1) DEFAULT '0',
  `site_domain` varchar(128) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `archive_site_fk_staff_id_idx` (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `archive_site`;

--
-- Data for table `archive_site`
--

INSERT INTO `archive_site` (`id`, `site_name`, `staff_id`, `site_abbr_cd`, `use_single_domain`, `site_domain`, `created`, `modified`) VALUES
 ('2', 'Songoku', '1', 'songoku', '1', 'http://songoku.fragonball.dev', '2015-07-06 15:10:13', '2015-07-07 12:09:29'),
 ('3', 'Songohan', '1', 'songohan', '0', '', '2015-07-07 14:36:53', '2015-07-07 14:36:53'),
 ('4', 'Songoten', '1', 'songoten', '0', '', '2015-07-07 14:37:33', '2015-07-10 15:16:11');


SET FOREIGN_KEY_CHECKS = 1;
