-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: lapazvacationhomes.com    Database: cirio_panel
-- ------------------------------------------------------
-- Server version	5.6.39-cll-lve

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
-- Table structure for table `commissions`
--

DROP TABLE IF EXISTS `commissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `percent` double DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commissions`
--

LOCK TABLES `commissions` WRITE;
/*!40000 ALTER TABLE `commissions` DISABLE KEYS */;
INSERT INTO `commissions` VALUES (1,'Web',2.5,NULL),(2,'Airbnb',2.5,NULL),(3,'VRBO',2.5,NULL),(4,'Agentes',2.5,NULL);
/*!40000 ALTER TABLE `commissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commissions_reservations`
--

DROP TABLE IF EXISTS `commissions_reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commissions_reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commission` int(11) DEFAULT NULL,
  `reservation` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commissions_reservations`
--

LOCK TABLES `commissions_reservations` WRITE;
/*!40000 ALTER TABLE `commissions_reservations` DISABLE KEYS */;
INSERT INTO `commissions_reservations` VALUES (1,1,1,'2018-06-21 00:00:00','true'),(2,2,1,'2018-06-21 00:00:00','false'),(3,3,1,'2018-06-21 00:00:00','false'),(4,4,1,'2018-06-21 00:00:00','false'),(5,1,2,'2018-07-25 00:00:00','false'),(6,2,2,'2018-07-25 00:00:00','false'),(7,3,2,'2018-07-25 00:00:00','false'),(8,4,2,'2018-07-25 00:00:00','false');
/*!40000 ALTER TABLE `commissions_reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses_properties`
--

DROP TABLE IF EXISTS `expenses_properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expenses_properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_property` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses_properties`
--

LOCK TABLES `expenses_properties` WRITE;
/*!40000 ALTER TABLE `expenses_properties` DISABLE KEYS */;
/*!40000 ALTER TABLE `expenses_properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses_type`
--

DROP TABLE IF EXISTS `expenses_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expenses_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses_type`
--

LOCK TABLES `expenses_type` WRITE;
/*!40000 ALTER TABLE `expenses_type` DISABLE KEYS */;
INSERT INTO `expenses_type` VALUES (1,'Agua','2018-04-26 00:00:00'),(2,'Luz','2018-04-26 00:00:00');
/*!40000 ALTER TABLE `expenses_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses_type_properties`
--

DROP TABLE IF EXISTS `expenses_type_properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expenses_type_properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expense` int(11) DEFAULT NULL,
  `property` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses_type_properties`
--

LOCK TABLES `expenses_type_properties` WRITE;
/*!40000 ALTER TABLE `expenses_type_properties` DISABLE KEYS */;
INSERT INTO `expenses_type_properties` VALUES (1,1,1,'2018-06-21 00:00:00'),(2,2,1,'2018-06-21 00:00:00');
/*!40000 ALTER TABLE `expenses_type_properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `quantity` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` VALUES (1,'Mesas',2,'2018-05-26 00:00:00');
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `properties`
--

DROP TABLE IF EXISTS `properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `rate` double DEFAULT '0',
  `rate_weekly` double DEFAULT '0',
  `rate_monthly` double DEFAULT '0',
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `properties`
--

LOCK TABLES `properties` WRITE;
/*!40000 ALTER TABLE `properties` DISABLE KEYS */;
INSERT INTO `properties` VALUES (1,'Casa Abuelita',210,180,180,'2018-07-25 00:00:00'),(2,'Casa Hidalgo',210,180,180,'2018-07-25 00:00:00'),(3,'Casa Antigua',150,136,136,'2018-07-25 00:00:00'),(4,'Casa de los Geckos',200,171,171,'2018-07-25 00:00:00');
/*!40000 ALTER TABLE `properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_inventory`
--

DROP TABLE IF EXISTS `property_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `quantity` int(11) DEFAULT NULL,
  `property` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_inventory`
--

LOCK TABLES `property_inventory` WRITE;
/*!40000 ALTER TABLE `property_inventory` DISABLE KEYS */;
INSERT INTO `property_inventory` VALUES (2,'Mesa',1,1,'2018-05-26 00:00:00');
/*!40000 ALTER TABLE `property_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rates`
--

DROP TABLE IF EXISTS `rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property` int(11) DEFAULT NULL,
  `rate` double DEFAULT '0',
  `rate_weekly` double DEFAULT '0',
  `rate_monthly` double DEFAULT '0',
  `init_date` date DEFAULT NULL,
  `finish_date` date DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rates`
--

LOCK TABLES `rates` WRITE;
/*!40000 ALTER TABLE `rates` DISABLE KEYS */;
/*!40000 ALTER TABLE `rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rates_type`
--

DROP TABLE IF EXISTS `rates_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rates_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rates_type`
--

LOCK TABLES `rates_type` WRITE;
/*!40000 ALTER TABLE `rates_type` DISABLE KEYS */;
INSERT INTO `rates_type` VALUES (1,'rate','Tarifa Base',NULL),(2,'rate_weekly','Tarifa Semanal',NULL),(3,'rate_monthly','Tarifa Mensual',NULL);
/*!40000 ALTER TABLE `rates_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_days`
--

DROP TABLE IF EXISTS `reservation_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation_days` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation` int(11) DEFAULT NULL,
  `rate` double DEFAULT '0',
  `disccount` double DEFAULT '0',
  `total` double DEFAULT '0',
  `date_reservation` date DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_days`
--

LOCK TABLES `reservation_days` WRITE;
/*!40000 ALTER TABLE `reservation_days` DISABLE KEYS */;
INSERT INTO `reservation_days` VALUES (1,1,201,0,201,'2018-06-21','2018-06-21 00:00:00'),(2,1,201,0,201,'2018-06-22','2018-06-21 00:00:00'),(3,1,201,0,201,'2018-06-23','2018-06-21 00:00:00'),(4,1,201,0,201,'2018-06-24','2018-06-21 00:00:00'),(5,1,201,0,201,'2018-06-25','2018-06-21 00:00:00'),(6,1,201,0,201,'2018-06-26','2018-06-21 00:00:00'),(7,1,201,0,201,'2018-06-27','2018-06-21 00:00:00'),(8,1,201,0,201,'2018-06-28','2018-06-21 00:00:00'),(9,2,150,0,150,'2018-11-14','2018-07-25 00:00:00'),(10,2,150,0,150,'2018-11-15','2018-07-25 00:00:00'),(11,2,150,0,150,'2018-11-16','2018-07-25 00:00:00'),(12,2,150,0,150,'2018-11-17','2018-07-25 00:00:00'),(13,2,150,0,150,'2018-11-18','2018-07-25 00:00:00');
/*!40000 ALTER TABLE `reservation_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property` int(11) DEFAULT NULL,
  `customer` text,
  `init_date` date DEFAULT NULL,
  `finish_date` date DEFAULT NULL,
  `deposit_entry` double DEFAULT NULL,
  `deposit_exit` double DEFAULT NULL,
  `total` double DEFAULT '0',
  `disccount` double DEFAULT '0',
  `rate` int(11) DEFAULT NULL,
  `rate_amount` double DEFAULT '0',
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (2,3,'mdavi','2018-11-14','2018-11-19',500,0,750,0,1,750,'2018-07-25 00:00:00');
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `user` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'cirio_panel'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-07-26  9:11:44
