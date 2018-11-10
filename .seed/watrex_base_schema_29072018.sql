# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
# Generation Time: 2018-07-29 10:02:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table order_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order_history`;

CREATE TABLE `order_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `dataTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `ord_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'WATREX System Order Id',
  `po_number` varchar(255) NOT NULL DEFAULT '',
  `order_number` varchar(255) NOT NULL DEFAULT '',
  `style` varchar(255) NOT NULL DEFAULT '',
  `color_pattern` varchar(255) NOT NULL DEFAULT '',
  `arrive_date` date DEFAULT NULL,
  `lot_number` varchar(255) DEFAULT NULL,
  `items_in_lot` int(11) DEFAULT NULL,
  `items_in_order` int(11) DEFAULT NULL,
  `exit_date` date DEFAULT NULL,
  `factory_id` int(11) DEFAULT NULL,
  `unit_price` varchar(255) DEFAULT NULL,
  `extended_cost` varchar(255) DEFAULT NULL,
  `comment_fld` longtext,
  `ord_status` enum('SHIPPED','PARTIAL_SHIPPED','COMPLETE','PENDING','DELAYED','CANCELLED','ON_HOLD','SPLIT') NOT NULL DEFAULT 'PENDING',
  `dataTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ord_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table raw_dump
# ------------------------------------------------------------

DROP TABLE IF EXISTS `raw_dump`;

CREATE TABLE `raw_dump` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `data` longtext NOT NULL COMMENT 'JSON Dump of All Records fetched',
  `records_count` varchar(255) NOT NULL DEFAULT '0' COMMENT 'Count of Rows fetched',
  `dataTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
