-- Create syntax for TABLE 'base_department'
CREATE TABLE `base_department` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(128) NOT NULL DEFAULT '',
  `description` text,
  `office_id` bigint(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `store_name` (`store`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'base_office'
CREATE TABLE `base_office` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(128) NOT NULL DEFAULT '',
  `description` text,
  `address_id` bigint(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `store_name` (`store`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;