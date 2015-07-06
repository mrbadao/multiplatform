-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: localhost    Database: sup_archive
-- ------------------------------------------------------
-- Server version	5.5.8-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `sup_archive`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `sup_archive` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `sup_archive`;

--
-- Table structure for table `archive_action`
--

DROP TABLE IF EXISTS `archive_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_action`
--

LOCK TABLES `archive_action` WRITE;
/*!40000 ALTER TABLE `archive_action` DISABLE KEYS */;
/*!40000 ALTER TABLE `archive_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archive_categories`
--

DROP TABLE IF EXISTS `archive_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_categories`
--

LOCK TABLES `archive_categories` WRITE;
/*!40000 ALTER TABLE `archive_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `archive_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archive_controller`
--

DROP TABLE IF EXISTS `archive_controller`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_controller`
--

LOCK TABLES `archive_controller` WRITE;
/*!40000 ALTER TABLE `archive_controller` DISABLE KEYS */;
/*!40000 ALTER TABLE `archive_controller` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archive_entries`
--

DROP TABLE IF EXISTS `archive_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_entries`
--

LOCK TABLES `archive_entries` WRITE;
/*!40000 ALTER TABLE `archive_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `archive_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archive_entry_content_article`
--

DROP TABLE IF EXISTS `archive_entry_content_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archive_entry_content_article` (
  `id` int(10) NOT NULL,
  `content` longtext NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_entry_content_article`
--

LOCK TABLES `archive_entry_content_article` WRITE;
/*!40000 ALTER TABLE `archive_entry_content_article` DISABLE KEYS */;
/*!40000 ALTER TABLE `archive_entry_content_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archive_menu`
--

DROP TABLE IF EXISTS `archive_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_menu`
--

LOCK TABLES `archive_menu` WRITE;
/*!40000 ALTER TABLE `archive_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `archive_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archive_modules`
--

DROP TABLE IF EXISTS `archive_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archive_modules` (
  `id` int(10) NOT NULL,
  `name` varchar(128) NOT NULL,
  `module_abbr_cd` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_modules`
--

LOCK TABLES `archive_modules` WRITE;
/*!40000 ALTER TABLE `archive_modules` DISABLE KEYS */;
/*!40000 ALTER TABLE `archive_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archive_page_type`
--

DROP TABLE IF EXISTS `archive_page_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  CONSTRAINT `archive_page_type_fk_module_id` FOREIGN KEY (`module_id`) REFERENCES `archive_modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `archive_page_type_fk_controller_id` FOREIGN KEY (`controller_id`) REFERENCES `archive_controller` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `archive_page_type_fk_action_id` FOREIGN KEY (`action_id`) REFERENCES `archive_action` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_page_type`
--

LOCK TABLES `archive_page_type` WRITE;
/*!40000 ALTER TABLE `archive_page_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `archive_page_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archive_pages`
--

DROP TABLE IF EXISTS `archive_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  CONSTRAINT `archive_pages_fk_site_id` FOREIGN KEY (`site_id`) REFERENCES `archive_site` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `archive_pages_fk_page_type` FOREIGN KEY (`page_type`) REFERENCES `archive_page_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_pages`
--

LOCK TABLES `archive_pages` WRITE;
/*!40000 ALTER TABLE `archive_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `archive_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archive_site`
--

DROP TABLE IF EXISTS `archive_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archive_site` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(128) NOT NULL,
  `staff_id` int(10) NOT NULL,
  `site_abbr_cd` varchar(128) NOT NULL,
  `use_single_domain` tinyint(1) NOT NULL DEFAULT '0',
  `site_domain` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `archive_site_fk_staff_id_idx` (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_site`
--

LOCK TABLES `archive_site` WRITE;
/*!40000 ALTER TABLE `archive_site` DISABLE KEYS */;
INSERT INTO `archive_site` VALUES (2,'Songoku',1,'songoku',0,'123','2015-07-06 15:10:13','2015-07-06 15:11:29');
/*!40000 ALTER TABLE `archive_site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Current Database: `sup_admin`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `sup_admin` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `sup_admin`;

--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrator` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `login_id` varchar(45) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role` int(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `login_id_idx` (`login_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrator`
--

LOCK TABLES `administrator` WRITE;
/*!40000 ALTER TABLE `administrator` DISABLE KEYS */;
INSERT INTO `administrator` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e',1,NULL,'2015-07-02 17:30:38');
/*!40000 ALTER TABLE `administrator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrator_custom_fileds`
--

DROP TABLE IF EXISTS `administrator_custom_fileds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrator_custom_fileds`
--

LOCK TABLES `administrator_custom_fileds` WRITE;
/*!40000 ALTER TABLE `administrator_custom_fileds` DISABLE KEYS */;
INSERT INTO `administrator_custom_fileds` VALUES (2,1,'name','HieuNC',NULL,NULL);
/*!40000 ALTER TABLE `administrator_custom_fileds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrator_module_access`
--

DROP TABLE IF EXISTS `administrator_module_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrator_module_access`
--

LOCK TABLES `administrator_module_access` WRITE;
/*!40000 ALTER TABLE `administrator_module_access` DISABLE KEYS */;
INSERT INTO `administrator_module_access` VALUES (1,1,1,1,NULL,NULL),(2,1,1,3,NULL,NULL),(3,1,2,1,NULL,NULL),(4,1,2,4,NULL,NULL);
/*!40000 ALTER TABLE `administrator_module_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrator_module_actions`
--

DROP TABLE IF EXISTS `administrator_module_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrator_module_actions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_id` int(10) NOT NULL,
  `controller` varchar(128) NOT NULL DEFAULT 'default',
  `action_name` varchar(128) NOT NULL,
  `action_abbr_cd` varchar(128) NOT NULL,
  `is_menu` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`is_menu`),
  KEY `module_id_idx` (`module_id`),
  CONSTRAINT `administrator_module_actions_fk_module_id` FOREIGN KEY (`module_id`) REFERENCES `administrator_modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrator_module_actions`
--

LOCK TABLES `administrator_module_actions` WRITE;
/*!40000 ALTER TABLE `administrator_module_actions` DISABLE KEYS */;
INSERT INTO `administrator_module_actions` VALUES (1,1,'default','Manage','index',1,NULL,NULL),(2,2,'default','Manage','index',1,NULL,NULL),(3,1,'default','Add','edit',1,NULL,NULL),(4,2,'default','Add','edit',1,NULL,NULL),(5,1,'default','Delete','delete',1,NULL,NULL);
/*!40000 ALTER TABLE `administrator_module_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrator_module_widgets`
--

DROP TABLE IF EXISTS `administrator_module_widgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrator_module_widgets`
--

LOCK TABLES `administrator_module_widgets` WRITE;
/*!40000 ALTER TABLE `administrator_module_widgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `administrator_module_widgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrator_modules`
--

DROP TABLE IF EXISTS `administrator_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrator_modules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(128) NOT NULL,
  `module_abbr_cd` varchar(128) NOT NULL,
  `module_info` longtext NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `abbr_cd_unique` (`module_abbr_cd`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrator_modules`
--

LOCK TABLES `administrator_modules` WRITE;
/*!40000 ALTER TABLE `administrator_modules` DISABLE KEYS */;
INSERT INTO `administrator_modules` VALUES (1,'Staff manager','staffmanger','staffmanger',NULL,NULL),(2,'Site manager','archivesite','sitemanager',NULL,NULL);
/*!40000 ALTER TABLE `administrator_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Current Database: `sup_staff`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `sup_staff` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `sup_staff`;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `login_id` varchar(45) NOT NULL,
  `password` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,'staff_01','123456',NULL,NULL);
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_action`
--

DROP TABLE IF EXISTS `staff_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_action`
--

LOCK TABLES `staff_action` WRITE;
/*!40000 ALTER TABLE `staff_action` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_controller`
--

DROP TABLE IF EXISTS `staff_controller`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_controller`
--

LOCK TABLES `staff_controller` WRITE;
/*!40000 ALTER TABLE `staff_controller` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_controller` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_custom_field`
--

DROP TABLE IF EXISTS `staff_custom_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_custom_field`
--

LOCK TABLES `staff_custom_field` WRITE;
/*!40000 ALTER TABLE `staff_custom_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_custom_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_menu`
--

DROP TABLE IF EXISTS `staff_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `menu_abbr_cd` varchar(128) NOT NULL,
  `parent_menu_id` int(10) NOT NULL DEFAULT '-1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_menu`
--

LOCK TABLES `staff_menu` WRITE;
/*!40000 ALTER TABLE `staff_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_modules`
--

DROP TABLE IF EXISTS `staff_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_modules` (
  `id` int(10) NOT NULL,
  `name` varchar(128) NOT NULL,
  `module_abbr_cd` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_modules`
--

LOCK TABLES `staff_modules` WRITE;
/*!40000 ALTER TABLE `staff_modules` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_modules` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-07-06 15:33:39
