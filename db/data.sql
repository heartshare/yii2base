# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.73)
# Database: gxcapp
# Generation Time: 2014-12-03 10:38:44 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table base_address
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_address`;

CREATE TABLE `base_address` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `country_code` varchar(64) DEFAULT NULL,
  `state_code` varchar(64) DEFAULT NULL,
  `city_code` varchar(64) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `alias` varchar(64) DEFAULT NULL,
  `first_name` varchar(128) NOT NULL DEFAULT '',
  `last_name` varchar(128) NOT NULL DEFAULT '',
  `address1` varchar(128) NOT NULL DEFAULT '',
  `address2` varchar(128) DEFAULT NULL,
  `postcode` varchar(64) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `phone_mobile` varchar(64) DEFAULT NULL,
  `registered_as` varchar(128) DEFAULT NULL,
  `note` varchar(500) DEFAULT '',
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `city_state_country` (`city_code`,`state_code`,`country_code`),
  KEY `user_registered_store` (`user_id`,`registered_as`,`store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table base_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_log`;

CREATE TABLE `base_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `action` varchar(64) NOT NULL DEFAULT '',
  `object` varchar(128) DEFAULT NULL COMMENT 'Merge Object Type and Object Key',
  `user_id` bigint(20) unsigned NOT NULL,
  `user_agent` text,
  `ip_address` int(10) unsigned DEFAULT NULL,
  `url` text NOT NULL,
  `data` longtext,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `store_action` (`store`,`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table base_meta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_meta`;

CREATE TABLE `base_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `object` varchar(128) NOT NULL DEFAULT '',
  `key` varchar(64) NOT NULL DEFAULT '',
  `value` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `object_key_store_unique` (`store`,`object`,`key`),
  KEY `object_key_store` (`object`,`key`,`store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table base_relationship
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_relationship`;

CREATE TABLE `base_relationship` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `original_object` varchar(128) NOT NULL DEFAULT '0',
  `related_object` varchar(128) NOT NULL DEFAULT '',
  `type` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `original_related_type_store` (`original_object`,`related_object`,`type`,`store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table base_resource
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_resource`;

CREATE TABLE `base_resource` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `mime_type` varchar(64) DEFAULT '',
  `storage` varchar(128) NOT NULL DEFAULT '',
  `path` varchar(255) DEFAULT '',
  `version` varchar(64) DEFAULT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type_store` (`mime_type`,`store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table base_setting
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_setting`;

CREATE TABLE `base_setting` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `group` varchar(64) NOT NULL DEFAULT '',
  `key` varchar(128) NOT NULL DEFAULT '',
  `value` longtext,
  PRIMARY KEY (`id`),
  KEY `store_group_key` (`store`,`group`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table base_tenant
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_tenant`;

CREATE TABLE `base_tenant` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `app_store` varchar(64) NOT NULL DEFAULT '',
  `content_store` varchar(64) NOT NULL DEFAULT '',
  `resource_store` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(128) NOT NULL DEFAULT '',
  `domain` varchar(128) NOT NULL DEFAULT '',
  `system_domain` varchar(128) NOT NULL DEFAULT '',
  `logo` varchar(128) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `app_store` (`app_store`),
  UNIQUE KEY `domain` (`domain`),
  UNIQUE KEY `system_domain` (`system_domain`),
  KEY `domain_status` (`domain`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `base_tenant` WRITE;
/*!40000 ALTER TABLE `base_tenant` DISABLE KEYS */;

INSERT INTO `base_tenant` (`id`, `app_store`, `content_store`, `resource_store`, `name`, `domain`, `system_domain`, `logo`, `status`)
VALUES
  (1,'a.6f9.r27','c.e68.f79','r.6d9.299','GXC','gxcsoft.com','www.gxcsoft.com',NULL,1);

/*!40000 ALTER TABLE `base_tenant` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table base_tenant_access
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_tenant_access`;

CREATE TABLE `base_tenant_access` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `user_id` bigint(20) unsigned NOT NULL,
  `level` tinyint(2) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_level_store_unique` (`user_id`,`level`,`store`),
  KEY `user_level_status_store` (`user_id`,`level`,`status`,`store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table base_tenant_module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_tenant_module`;

CREATE TABLE `base_tenant_module` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `module` varchar(64) NOT NULL DEFAULT '',
  `plan` varchar(64) NOT NULL DEFAULT 'basic',
  `permissions` longtext,
  `expired_mode` tinyint(1) NOT NULL DEFAULT '0',
  `expired_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_module_unique` (`store`,`module`),
  KEY `module_store` (`module`,`store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table base_tenant_profile
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_tenant_profile`;

CREATE TABLE `base_tenant_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `user_registered_id` bigint(20) unsigned NOT NULL,
  `address_registered_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `registered_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_store` (`user_registered_id`,`store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table base_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_user`;

CREATE TABLE `base_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_email_unique` (`store`,`email`),
  KEY `store_email` (`store`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `base_user` WRITE;
/*!40000 ALTER TABLE `base_user` DISABLE KEYS */;

INSERT INTO `base_user` (`id`, `store`, `email`)
VALUES
  (4,'c.e68.f79','nganhtuan63@gmail.com');

/*!40000 ALTER TABLE `base_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table base_user_confirmation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_user_confirmation`;

CREATE TABLE `base_user_confirmation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `zone` varchar(64) DEFAULT 'site',
  `user_id` bigint(20) unsigned NOT NULL,
  `type` varchar(128) NOT NULL DEFAULT '',
  `token` varchar(255) DEFAULT '',
  `generated_at` datetime NOT NULL,
  `recorded_at` datetime NOT NULL,
  `expired_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_token_unique` (`store`,`token`),
  KEY `store_user_zone_token` (`store`,`user_id`,`zone`,`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table base_user_display
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_user_display`;

CREATE TABLE `base_user_display` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `zone` varchar(64) NOT NULL DEFAULT 'site',
  `user_id` bigint(20) unsigned NOT NULL,
  `screen_name` varchar(128) DEFAULT NULL,
  `display_name` varchar(128) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_user_zone_unique` (`store`,`user_id`,`zone`),
  KEY `user_zone_store` (`user_id`,`zone`,`store`),
  KEY `store_zone_screen_name_unique` (`store`,`zone`,`screen_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `base_user_display` WRITE;
/*!40000 ALTER TABLE `base_user_display` DISABLE KEYS */;

INSERT INTO `base_user_display` (`id`, `store`, `zone`, `user_id`, `screen_name`, `display_name`, `tagline`, `avatar`)
VALUES
  (1,'c.e68.f79','staff',4,'mr80','Tuan Nguyen',NULL,NULL);

/*!40000 ALTER TABLE `base_user_display` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table base_user_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_user_group`;

CREATE TABLE `base_user_group` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `zone` varchar(64) NOT NULL DEFAULT 'site',
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `icon` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `zone_name_store_unique` (`zone`,`name`,`store`),
  KEY `zone_name_status_store` (`zone`,`name`,`status`,`store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table base_user_group_assign
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_user_group_assign`;

CREATE TABLE `base_user_group_assign` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `group_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_group_store` (`user_id`,`group_id`,`store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table base_user_identity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_user_identity`;

CREATE TABLE `base_user_identity` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `user_id` bigint(20) unsigned NOT NULL,
  `zone` varchar(64) NOT NULL DEFAULT 'site',
  `auth_provider` varchar(255) NOT NULL DEFAULT 'app',
  `auth_provider_uid` varchar(255) DEFAULT NULL,
  `auth_params` longtext,
  `auth_key` varchar(255) NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `recent_password_change` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_user_zone_unique` (`store`,`user_id`,`zone`),
  KEY `auth_provider` (`auth_provider`,`auth_provider_uid`),
  KEY `user_zone_status_store` (`user_id`,`zone`,`status`,`store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `base_user_identity` WRITE;
/*!40000 ALTER TABLE `base_user_identity` DISABLE KEYS */;

INSERT INTO `base_user_identity` (`id`, `store`, `user_id`, `zone`, `auth_provider`, `auth_provider_uid`, `auth_params`, `auth_key`, `password_hash`, `recent_password_change`, `status`)
VALUES
  (4,'c.e68.f79',4,'staff','app',NULL,NULL,'pEK3z9A3kj9QixQp0856SXOGodpCXzu1',X'243279243133246A647A4366334A313069704D6646483143735271457549554A476B7956734D30444C587076725A2E624E30524630625A427335614F','0000-00-00 00:00:00',15);

/*!40000 ALTER TABLE `base_user_identity` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table base_user_login
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_user_login`;

CREATE TABLE `base_user_login` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `user_id` bigint(20) unsigned NOT NULL,
  `zone` varchar(64) NOT NULL DEFAULT 'site',
  `login_at` datetime NOT NULL,
  `login_status` tinyint(1) NOT NULL DEFAULT '1',
  `login_provider` varchar(255) DEFAULT 'app',
  `ip_address` int(32) unsigned NOT NULL,
  `user_agent` text,
  PRIMARY KEY (`id`),
  KEY `store_user_zone` (`store`,`user_id`,`zone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table base_user_profile
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_user_profile`;

CREATE TABLE `base_user_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `user_id` bigint(20) unsigned NOT NULL,
  `zone` varchar(64) NOT NULL DEFAULT 'site',
  `gender` tinyint(1) DEFAULT '0',
  `first_name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `location` varchar(64) DEFAULT NULL,
  `company` varchar(64) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `bio` text,
  `registered_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_user_zone_unique` (`store`,`user_id`,`zone`),
  KEY `user_zone_store` (`user_id`,`zone`,`store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `base_user_profile` WRITE;
/*!40000 ALTER TABLE `base_user_profile` DISABLE KEYS */;

INSERT INTO `base_user_profile` (`id`, `store`, `user_id`, `zone`, `gender`, `first_name`, `last_name`, `location`, `company`, `birthday`, `bio`, `registered_at`)
VALUES
  (1,'c.e68.f79',4,'staff',1,'Tuan','Nguyen',NULL,NULL,NULL,NULL,'0000-00-00 00:00:00');

/*!40000 ALTER TABLE `base_user_profile` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
