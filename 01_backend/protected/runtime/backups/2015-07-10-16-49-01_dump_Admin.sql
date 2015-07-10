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
-- Structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE `administrator` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `login_id` varchar(45) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role` int(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `login_id_idx` (`login_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `administrator`;

--
-- Data for table `administrator`
--

INSERT INTO `administrator` (`id`, `login_id`, `password`, `role`, `created`, `modified`) VALUES
 ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1', '2015-07-02 17:30:38', '2015-07-10 16:36:18'),
 ('2', 'hieunc', 'e10adc3949ba59abbe56e057f20f883e', '1', '2015-07-02 17:30:38', '2015-07-10 16:06:04'),
 ('3', 'mrbadao', 'e10adc3949ba59abbe56e057f20f883e', '1', '2015-07-10 15:05:32', '2015-07-10 16:01:20'),
 ('4', 'dev_01', 'e10adc3949ba59abbe56e057f20f883e', '0', '2015-07-10 15:31:09', '2015-07-10 15:31:09'),
 ('5', 'dev_02', 'e10adc3949ba59abbe56e057f20f883e', '1', '2015-07-10 15:53:41', '2015-07-10 15:53:41');



--
-- Structure for table `administrator_custom_fileds`
--

DROP TABLE IF EXISTS `administrator_custom_fileds`;
CREATE TABLE `administrator_custom_fileds` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `administrator_id` int(10) NOT NULL,
  `filed_name` varchar(45) NOT NULL,
  `filed_value` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `administrator_id_idx` (`administrator_id`),
  KEY `filed_name_idx` (`filed_name`),
  CONSTRAINT `administrator_custom_fileds_fk_administrator_id` FOREIGN KEY (`administrator_id`) REFERENCES `administrator` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `administrator_custom_fileds`;

--
-- Data for table `administrator_custom_fileds`
--

INSERT INTO `administrator_custom_fileds` (`id`, `administrator_id`, `filed_name`, `filed_value`, `created`, `modified`) VALUES
 ('4', '3', 'full_name', 'Hiếu Nguyễn', '2015-07-10 15:05:32', '2015-07-10 15:05:32'),
 ('5', '3', 'phone', '0902852296', '2015-07-10 15:05:32', '2015-07-10 15:05:32'),
 ('6', '3', 'email', 'hieunc18@gmail.com', '2015-07-10 15:05:32', '2015-07-10 15:05:32'),
 ('7', '4', 'full_name', 'Hiếu Nguyễn', '2015-07-10 15:31:09', '2015-07-10 15:31:09'),
 ('8', '4', 'phone', '0902852296', '2015-07-10 15:31:09', '2015-07-10 15:31:09'),
 ('9', '4', 'email', 'hieunc18@gmail.com', '2015-07-10 15:31:09', '2015-07-10 15:31:09'),
 ('10', '5', 'full_name', 'Hiếu Nguyễn', '2015-07-10 15:53:41', '2015-07-10 15:53:41'),
 ('11', '5', 'phone', '0902852296', '2015-07-10 15:53:41', '2015-07-10 15:53:41'),
 ('12', '5', 'email', 'hieunc18@gmail.com', '2015-07-10 15:53:41', '2015-07-10 15:53:41'),
 ('13', '2', 'full_name', 'Hiếu Nguyễn', '2015-07-10 16:06:04', '2015-07-10 16:06:04'),
 ('14', '2', 'phone', '0902852296', '2015-07-10 16:06:04', '2015-07-10 16:06:04'),
 ('15', '2', 'email', 'hieunc18@gmail.com', '2015-07-10 16:06:04', '2015-07-10 16:06:04'),
 ('16', '1', 'full_name', 'Hiếu Nguyễn', '2015-07-10 16:19:52', '2015-07-10 16:36:18'),
 ('17', '1', 'phone', '0902852296', '2015-07-10 16:19:52', '2015-07-10 16:36:18'),
 ('18', '1', 'email', 'hieunc18@gmail.com', '2015-07-10 16:19:52', '2015-07-10 16:36:18'),
 ('19', '1', 'Height', '1m75', '2015-07-10 16:19:52', '2015-07-10 16:36:18');



--
-- Structure for table `administrator_module_access`
--

DROP TABLE IF EXISTS `administrator_module_access`;
CREATE TABLE `administrator_module_access` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `administrator_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL,
  `muodule_action_id` int(10) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `administrator_id_idx` (`administrator_id`),
  KEY `module_id_idx` (`module_id`),
  KEY `administrator_module_access_fk_module_action_id_idx` (`muodule_action_id`),
  CONSTRAINT `administrator_module_access_fk_administrator_id` FOREIGN KEY (`administrator_id`) REFERENCES `administrator` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `administrator_module_access_fk_module_action_id` FOREIGN KEY (`muodule_action_id`) REFERENCES `administrator_module_actions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `administrator_module_access_fk_module_id` FOREIGN KEY (`module_id`) REFERENCES `administrator_modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `administrator_module_access`;

--
-- Data for table `administrator_module_access`
--

INSERT INTO `administrator_module_access` (`id`, `administrator_id`, `module_id`, `muodule_action_id`, `created`, `modified`) VALUES
 ('1', '1', '1', '1', '2015-07-08 16:55:25', '2015-07-08 22:24:48'),
 ('2', '1', '1', '10', '2015-07-08 17:11:01', '2015-07-08 17:11:01'),
 ('3', '1', '1', '3', '2015-07-08 17:11:27', '2015-07-08 17:11:27'),
 ('4', '1', '1', '5', '2015-07-08 17:11:31', '2015-07-08 22:24:55'),
 ('5', '1', '2', '2', '2015-07-08 17:14:40', '2015-07-08 17:14:40'),
 ('6', '1', '2', '4', '2015-07-08 17:14:46', '2015-07-08 17:14:46'),
 ('7', '1', '2', '6', '2015-07-08 17:14:51', '2015-07-08 17:14:51'),
 ('8', '1', '3', '7', '2015-07-08 17:15:12', '2015-07-08 17:15:12'),
 ('9', '1', '3', '8', '2015-07-08 17:15:16', '2015-07-08 17:15:16'),
 ('10', '1', '3', '9', '2015-07-08 17:15:21', '2015-07-08 17:15:21'),
 ('11', '1', '4', '11', '2015-07-08 17:15:30', '2015-07-08 18:14:46'),
 ('12', '1', '4', '13', '2015-07-08 17:15:55', '2015-07-08 17:15:55'),
 ('13', '1', '4', '14', '2015-07-09 00:31:57', '2015-07-09 00:31:57'),
 ('14', '1', '4', '15', '2015-07-09 12:50:09', '2015-07-09 12:50:09'),
 ('15', '2', '4', '11', '2015-07-09 12:50:09', '2015-07-09 12:50:09'),
 ('16', '2', '4', '13', '2015-07-09 12:50:09', '2015-07-09 12:50:09'),
 ('17', '2', '4', '14', '2015-07-09 12:50:09', '2015-07-09 12:50:09'),
 ('18', '2', '4', '15', '2015-07-09 12:50:09', '2015-07-09 12:50:09'),
 ('19', '1', '5', '16', '2015-07-10 13:54:56', '2015-07-10 13:54:56'),
 ('20', '1', '5', '17', '2015-07-10 13:54:56', '2015-07-10 13:54:56'),
 ('21', '1', '5', '18', '2015-07-10 13:54:56', '2015-07-10 13:54:56'),
 ('22', '1', '5', '19', '2015-07-10 13:54:56', '2015-07-10 13:54:56');



--
-- Structure for table `administrator_module_actions`
--

DROP TABLE IF EXISTS `administrator_module_actions`;
CREATE TABLE `administrator_module_actions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_id` int(10) DEFAULT NULL,
  `controller` varchar(128) NOT NULL DEFAULT 'default',
  `action_name` varchar(128) NOT NULL,
  `action_abbr_cd` varchar(128) NOT NULL,
  `is_menu` int(10) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id_idx` (`module_id`),
  CONSTRAINT `administrator_module_actions_fk_module_id` FOREIGN KEY (`module_id`) REFERENCES `administrator_modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `administrator_module_actions`;

--
-- Data for table `administrator_module_actions`
--

INSERT INTO `administrator_module_actions` (`id`, `module_id`, `controller`, `action_name`, `action_abbr_cd`, `is_menu`, `created`, `modified`) VALUES
 ('1', '1', 'default', 'Manage', 'index', '1', '2015-07-08 17:14:09', '2015-07-08 22:24:48'),
 ('2', '2', 'default', 'Manage', 'index', '1', '2015-07-08 17:14:09', '2015-07-08 17:14:40'),
 ('3', '1', 'default', 'Add', 'edit', '1', '2015-07-08 17:14:09', '2015-07-08 17:14:09'),
 ('4', '2', 'default', 'Add', 'edit', '1', '2015-07-08 17:14:09', '2015-07-08 17:14:46'),
 ('5', '1', 'default', 'Delete', 'delete', '0', '2015-07-08 17:14:09', '2015-07-08 22:24:55'),
 ('6', '2', 'default', 'View detail', 'view', '0', '2015-07-08 17:14:09', '2015-07-08 17:14:51'),
 ('7', '3', 'default', 'Manage', 'index', '1', '2015-07-08 17:14:09', '2015-07-08 17:15:12'),
 ('8', '3', 'default', 'View detail', 'view', '0', '2015-07-08 17:14:09', '2015-07-08 17:15:16'),
 ('9', '3', 'default', 'Add', 'edit', '1', '2015-07-08 17:14:09', '2015-07-08 17:15:20'),
 ('10', '1', 'default', 'View detail', 'view', '0', '2015-07-08 17:14:09', '2015-07-08 17:14:09'),
 ('11', '4', 'default', 'CMS config', 'cmsmainconfig', '1', '2015-07-08 17:14:09', '2015-07-08 18:14:46'),
 ('13', '4', 'default', 'Backup database', 'backupdb', '1', '2015-07-08 17:15:55', '2015-07-08 17:15:55'),
 ('14', '4', 'default', 'Download database', 'downloaddatabase', '0', '2015-07-09 00:31:57', '2015-07-09 00:31:57'),
 ('15', '4', 'default', 'Restore database', 'restoredb', '1', '2015-07-09 12:50:09', '2015-07-09 12:50:09'),
 ('16', '5', 'default', 'Manage', 'index', '1', '2015-07-10 13:54:56', '2015-07-10 13:54:56'),
 ('17', '5', 'default', 'Add', 'edit', '1', '2015-07-10 13:54:56', '2015-07-10 13:54:56'),
 ('18', '5', 'default', 'View detail', 'view', '0', '2015-07-10 13:54:56', '2015-07-10 13:54:56'),
 ('19', '5', 'default', 'Delete', 'delete', '0', '2015-07-10 13:54:56', '2015-07-10 13:54:56');



--
-- Structure for table `administrator_module_widgets`
--

DROP TABLE IF EXISTS `administrator_module_widgets`;
CREATE TABLE `administrator_module_widgets` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_id` int(10) NOT NULL,
  `widget_name` varchar(128) NOT NULL,
  `widget_abbr_cd` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id_idx` (`module_id`),
  CONSTRAINT `administrator_module_widgets_fk_module_id` FOREIGN KEY (`module_id`) REFERENCES `administrator_modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `administrator_module_widgets`;

--
-- Structure for table `administrator_modules`
--

DROP TABLE IF EXISTS `administrator_modules`;
CREATE TABLE `administrator_modules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(128) NOT NULL,
  `module_abbr_cd` varchar(128) NOT NULL,
  `module_info` longtext NOT NULL,
  `version` varchar(10) DEFAULT '1.0',
  `idx` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `abbr_cd_unique` (`module_abbr_cd`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


--
-- Truncate table before insert `administrator`
--
TRUNCATE TABLE `administrator_modules`;

--
-- Data for table `administrator_modules`
--

INSERT INTO `administrator_modules` (`id`, `module_name`, `module_abbr_cd`, `module_info`, `version`, `idx`, `created`, `modified`) VALUES
 ('1', 'Staff manager', 'staffmanage', 'staffmanage', '1.0.1', '1', '2015-07-07 15:26:37', '2015-07-08 15:03:43'),
 ('2', 'Site manager', 'archivesite', 'sitemanager', '1.0', '2', '2015-07-07 15:26:37', '2015-07-08 10:45:01'),
 ('3', 'Modules manager', 'modulemanage', 'modulemanage', '1.0', '3', '2015-07-07 15:26:37', '2015-07-08 14:40:30'),
 ('4', 'System setting', 'systemsetting', 'systemsetting', '0.0.3', '4', '2015-07-08 09:01:20', '2015-07-08 18:14:46'),
 ('5', 'User manager', 'systemusers', 'systemusers', '1.0.1', '1', '2015-07-10 13:54:56', '2015-07-10 13:54:56');


SET FOREIGN_KEY_CHECKS = 1;
