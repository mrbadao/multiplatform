SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";

--
-- Database: `sup_admin`
--
CREATE DATABASE IF NOT EXISTS `sup_admin` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sup_admin`;

--
-- Structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `login_id` varchar(45) NOT NULL,
  `password` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `staff`;

--
-- Data for table `staff`
--

INSERT INTO `staff` (`id`, `login_id`, `password`, `created`, `modified`) VALUES
 ('1', 'staff_01', '123456', NULL, NULL);



--
-- Structure for table `staff_action`
--

DROP TABLE IF EXISTS `staff_action`;
CREATE TABLE `staff_action` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `controller_id` int(10) NOT NULL,
  `action_abbr_cd` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_action_fk_controller_idx` (`controller_id`),
  CONSTRAINT `staff_action_fk_controller` FOREIGN KEY (`controller_id`) REFERENCES `staff_controller` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `staff_action`;

--
-- Structure for table `staff_controller`
--

DROP TABLE IF EXISTS `staff_controller`;
CREATE TABLE `staff_controller` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_id` int(10) NOT NULL,
  `name` varchar(128) NOT NULL,
  `controller_abbr_cd` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_controller_fk_module_id_idx` (`module_id`),
  CONSTRAINT `staff_controller_fk_module_id` FOREIGN KEY (`module_id`) REFERENCES `staff_modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `staff_controller`;

--
-- Structure for table `staff_custom_field`
--

DROP TABLE IF EXISTS `staff_custom_field`;
CREATE TABLE `staff_custom_field` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) NOT NULL,
  `filed_name` varchar(128) NOT NULL,
  `filed_value` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_custom_field_fk_staff_id_idx` (`staff_id`),
  CONSTRAINT `staff_custom_field_fk_staff_id` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `staff_custom_field`;

--
-- Structure for table `staff_menu`
--

DROP TABLE IF EXISTS `staff_menu`;
CREATE TABLE `staff_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `menu_abbr_cd` varchar(128) NOT NULL,
  `parent_menu_id` int(10) NOT NULL DEFAULT '-1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `staff_menu`;

--
-- Structure for table `staff_modules`
--

DROP TABLE IF EXISTS `staff_modules`;
CREATE TABLE `staff_modules` (
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
TRUNCATE TABLE `staff_modules`;
SET FOREIGN_KEY_CHECKS = 1;
