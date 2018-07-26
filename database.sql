-- MySQL dump 10.16  Distrib 10.2.14-MariaDB, for osx10.13 (x86_64)
--
-- Host: localhost    Database: cirio_panel
-- ------------------------------------------------------
-- Server version	10.2.14-MariaDB

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
  `name` text DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commissions_reservations`
--

LOCK TABLES `commissions_reservations` WRITE;
/*!40000 ALTER TABLE `commissions_reservations` DISABLE KEYS */;
INSERT INTO `commissions_reservations` VALUES (11,1,5,'2018-05-03 00:00:00','false'),(12,2,5,'2018-05-03 00:00:00','true'),(13,3,5,'2018-05-03 00:00:00','true'),(14,4,5,'2018-05-03 00:00:00','false'),(19,1,1,'2018-05-03 00:00:00','true'),(20,2,1,'2018-05-03 00:00:00','false'),(21,3,1,'2018-05-03 00:00:00','false'),(22,4,1,'2018-05-03 00:00:00','true'),(63,1,6,'2018-05-07 00:00:00','true'),(64,2,6,'2018-05-07 00:00:00','false'),(65,3,6,'2018-05-07 00:00:00','false'),(66,4,6,'2018-05-07 00:00:00','true'),(83,1,3,'2018-05-08 00:00:00','false'),(84,2,3,'2018-05-08 00:00:00','false'),(85,3,3,'2018-05-08 00:00:00','true'),(86,4,3,'2018-05-08 00:00:00','false'),(103,1,12,'2018-05-08 00:00:00','true'),(104,2,12,'2018-05-08 00:00:00','true'),(105,3,12,'2018-05-08 00:00:00','true'),(106,4,12,'2018-05-08 00:00:00','true'),(107,1,11,'2018-05-08 00:00:00','false'),(108,2,11,'2018-05-08 00:00:00','false'),(109,3,11,'2018-05-08 00:00:00','true'),(110,4,11,'2018-05-08 00:00:00','false'),(111,1,2,'2018-05-08 00:00:00','true'),(112,2,2,'2018-05-08 00:00:00','false'),(113,3,2,'2018-05-08 00:00:00','false'),(114,4,2,'2018-05-08 00:00:00','true'),(115,1,4,'2018-05-08 00:00:00','false'),(116,2,4,'2018-05-08 00:00:00','true'),(117,3,4,'2018-05-08 00:00:00','false'),(118,4,4,'2018-05-08 00:00:00','false'),(119,1,7,'2018-05-08 00:00:00','false'),(120,2,7,'2018-05-08 00:00:00','false'),(121,3,7,'2018-05-08 00:00:00','false'),(122,4,7,'2018-05-08 00:00:00','true'),(123,1,8,'2018-05-08 00:00:00','true'),(124,2,8,'2018-05-08 00:00:00','false'),(125,3,8,'2018-05-08 00:00:00','false'),(126,4,8,'2018-05-08 00:00:00','false');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses_properties`
--

LOCK TABLES `expenses_properties` WRITE;
/*!40000 ALTER TABLE `expenses_properties` DISABLE KEYS */;
INSERT INTO `expenses_properties` VALUES (1,1,20,'2018-04-26'),(2,1,10,'2018-04-25'),(3,3,40,'2018-04-23');
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
  `name` text DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses_type_properties`
--

LOCK TABLES `expenses_type_properties` WRITE;
/*!40000 ALTER TABLE `expenses_type_properties` DISABLE KEYS */;
INSERT INTO `expenses_type_properties` VALUES (1,1,1,'2018-04-26 00:00:00'),(2,2,1,'2018-04-26 00:00:00'),(3,1,2,'2018-04-26 00:00:00');
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
  `name` text DEFAULT NULL,
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
INSERT INTO `inventory` VALUES (1,'Sillas',20,'2018-04-26 00:00:00');
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
  `name` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `rate` double DEFAULT 0,
  `rate_weekly` double DEFAULT 0,
  `rate_monthly` double DEFAULT 0,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `properties`
--

LOCK TABLES `properties` WRITE;
/*!40000 ALTER TABLE `properties` DISABLE KEYS */;
INSERT INTO `properties` VALUES (1,'Casa Abuelita',201,180,140,'2018-04-26 00:00:00'),(2,'Casa Hidalgo',232,200,180,'2018-04-26 00:00:00'),(3,'Casa AntigÃ¼a',175,150,130,'2018-04-26 00:00:00'),(4,'Casa de los Geckos',144,120,100,'2018-04-26 00:00:00');
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
  `name` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `property` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_inventory`
--

LOCK TABLES `property_inventory` WRITE;
/*!40000 ALTER TABLE `property_inventory` DISABLE KEYS */;
INSERT INTO `property_inventory` VALUES (1,'Mesa',1,1,'2018-04-26 00:00:00');
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
  `rate` double DEFAULT 0,
  `rate_weekly` double DEFAULT 0,
  `rate_monthly` double DEFAULT 0,
  `init_date` date DEFAULT NULL,
  `finish_date` date DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rates`
--

LOCK TABLES `rates` WRITE;
/*!40000 ALTER TABLE `rates` DISABLE KEYS */;
INSERT INTO `rates` VALUES (1,1,100,70,50,'2018-05-05','2018-05-10','2018-05-06 00:00:00'),(2,1,200,170,150,'2018-05-11','2018-05-15','2018-05-06 00:00:00');
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
  `description` text DEFAULT NULL,
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
  `rate` double DEFAULT 0,
  `disccount` double DEFAULT 0,
  `total` double DEFAULT 0,
  `date_reservation` date DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_days`
--

LOCK TABLES `reservation_days` WRITE;
/*!40000 ALTER TABLE `reservation_days` DISABLE KEYS */;
INSERT INTO `reservation_days` VALUES (52,6,232,17.571428571429,214.42857142857,'2018-05-03','2018-05-07 00:00:00'),(53,6,232,17.571428571429,214.42857142857,'2018-05-04','2018-05-07 00:00:00'),(54,6,232,17.571428571429,214.42857142857,'2018-05-05','2018-05-07 00:00:00'),(55,6,232,17.571428571429,214.42857142857,'2018-05-06','2018-05-07 00:00:00'),(56,6,232,17.571428571429,214.42857142857,'2018-05-07','2018-05-07 00:00:00'),(57,6,232,17.571428571429,214.42857142857,'2018-05-08','2018-05-07 00:00:00'),(58,6,232,17.571428571429,214.42857142857,'2018-05-09','2018-05-07 00:00:00'),(82,3,232,0,232,'2018-05-09','2018-05-08 00:00:00'),(83,3,232,0,232,'2018-05-10','2018-05-08 00:00:00'),(84,3,232,0,232,'2018-05-11','2018-05-08 00:00:00'),(85,3,232,0,232,'2018-05-12','2018-05-08 00:00:00'),(86,3,232,0,232,'2018-05-13','2018-05-08 00:00:00'),(87,3,232,0,232,'2018-05-14','2018-05-08 00:00:00'),(88,3,232,0,232,'2018-05-15','2018-05-08 00:00:00'),(89,3,232,0,232,'2018-05-16','2018-05-08 00:00:00'),(90,3,232,0,232,'2018-05-17','2018-05-08 00:00:00'),(91,3,232,0,232,'2018-05-18','2018-05-08 00:00:00'),(92,3,232,0,232,'2018-05-19','2018-05-08 00:00:00'),(93,3,232,0,232,'2018-05-20','2018-05-08 00:00:00'),(94,3,232,0,232,'2018-05-21','2018-05-08 00:00:00'),(95,3,232,0,232,'2018-05-22','2018-05-08 00:00:00'),(96,3,232,0,232,'2018-05-23','2018-05-08 00:00:00'),(97,3,232,0,232,'2018-05-24','2018-05-08 00:00:00'),(98,3,232,0,232,'2018-05-25','2018-05-08 00:00:00'),(123,12,140,50,90,'2018-05-01','2018-05-08 00:00:00'),(124,12,140,50,90,'2018-05-02','2018-05-08 00:00:00'),(125,11,100,23.4,76.6,'2018-05-05','2018-05-08 00:00:00'),(126,11,100,23.4,76.6,'2018-05-06','2018-05-08 00:00:00'),(127,11,100,23.4,76.6,'2018-05-07','2018-05-08 00:00:00'),(128,11,100,23.4,76.6,'2018-05-08','2018-05-08 00:00:00'),(129,11,100,23.4,76.6,'2018-05-09','2018-05-08 00:00:00'),(130,11,100,23.4,76.6,'2018-05-10','2018-05-08 00:00:00'),(131,11,201,23.4,177.6,'2018-05-01','2018-05-08 00:00:00'),(132,11,201,23.4,177.6,'2018-05-02','2018-05-08 00:00:00'),(133,11,201,23.4,177.6,'2018-05-03','2018-05-08 00:00:00'),(134,11,201,23.4,177.6,'2018-05-04','2018-05-08 00:00:00'),(135,2,130,51,79,'2018-04-04','2018-05-08 00:00:00'),(136,4,120,20.5,99.5,'2018-05-04','2018-05-08 00:00:00'),(137,4,120,20.5,99.5,'2018-05-05','2018-05-08 00:00:00'),(138,4,120,20.5,99.5,'2018-05-06','2018-05-08 00:00:00'),(139,4,120,20.5,99.5,'2018-05-07','2018-05-08 00:00:00'),(140,4,120,20.5,99.5,'2018-05-08','2018-05-08 00:00:00'),(141,4,120,20.5,99.5,'2018-05-09','2018-05-08 00:00:00'),(142,7,100,23.4,76.6,'2018-05-05','2018-05-08 00:00:00'),(143,7,100,23.4,76.6,'2018-05-06','2018-05-08 00:00:00'),(144,7,100,23.4,76.6,'2018-05-07','2018-05-08 00:00:00'),(145,7,100,23.4,76.6,'2018-05-08','2018-05-08 00:00:00'),(146,7,100,23.4,76.6,'2018-05-09','2018-05-08 00:00:00'),(147,7,100,23.4,76.6,'2018-05-10','2018-05-08 00:00:00'),(148,7,201,23.4,177.6,'2018-05-01','2018-05-08 00:00:00'),(149,7,201,23.4,177.6,'2018-05-02','2018-05-08 00:00:00'),(150,7,201,23.4,177.6,'2018-05-03','2018-05-08 00:00:00'),(151,7,201,23.4,177.6,'2018-05-04','2018-05-08 00:00:00'),(152,8,100,23.4,76.6,'2018-05-05','2018-05-08 00:00:00'),(153,8,100,23.4,76.6,'2018-05-06','2018-05-08 00:00:00'),(154,8,100,23.4,76.6,'2018-05-07','2018-05-08 00:00:00'),(155,8,100,23.4,76.6,'2018-05-08','2018-05-08 00:00:00'),(156,8,100,23.4,76.6,'2018-05-09','2018-05-08 00:00:00'),(157,8,100,23.4,76.6,'2018-05-10','2018-05-08 00:00:00'),(158,8,201,23.4,177.6,'2018-05-01','2018-05-08 00:00:00'),(159,8,201,23.4,177.6,'2018-05-02','2018-05-08 00:00:00'),(160,8,201,23.4,177.6,'2018-05-03','2018-05-08 00:00:00'),(161,8,201,23.4,177.6,'2018-05-04','2018-05-08 00:00:00');
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
  `customer` text DEFAULT NULL,
  `init_date` date DEFAULT NULL,
  `finish_date` date DEFAULT NULL,
  `deposit_entry` double DEFAULT NULL,
  `deposit_exit` double DEFAULT NULL,
  `total` double DEFAULT 0,
  `disccount` double DEFAULT 0,
  `rate` int(11) DEFAULT NULL,
  `rate_amount` double DEFAULT 0,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (1,1,'Juan Manuel Mazariegos MuÃ±oz','2018-04-02','2018-04-05',500,600,600,3,1,603,'2018-05-03 00:00:00'),(2,3,'Ernesto CardeÃ±a','2018-04-04','2018-04-05',100,100,79,51,3,130,'2018-05-08 00:00:00'),(3,2,'Pedro Hernandez','2018-05-09','2018-05-26',100,100,3944,0,1,3944,'2018-05-08 00:00:00'),(4,4,'Erika Manriquez','2018-05-04','2018-05-10',100,100,597,123,2,720,'2018-05-08 00:00:00'),(5,1,'Enrique','2018-05-04','2018-05-12',100,100,1584,24,1,1608,'2018-05-03 00:00:00'),(6,2,'er','2018-05-03','2018-05-10',100,100,1501,123,1,1624,'2018-05-07 00:00:00'),(7,1,'fd34','2018-05-01','2018-05-11',400,400,1170,234,1,1404,'2018-05-08 00:00:00'),(8,1,'fd34','2018-05-01','2018-05-11',400,400,1170,234,1,1404,'2018-05-08 00:00:00'),(9,1,'fd34','2018-05-01','2018-05-11',400,400,1170,234,1,1404,'2018-05-06 00:00:00'),(10,1,'fd34','2018-05-01','2018-05-11',400,400,1170,234,1,1404,'2018-05-06 00:00:00'),(11,1,'fd34','2018-05-01','2018-05-11',400,400,1170,234,1,1404,'2018-05-08 00:00:00'),(12,1,'fd34','2018-05-01','2018-05-03',400,400,180,100,3,280,'2018-05-08 00:00:00');
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
  `name` text DEFAULT NULL,
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

-- Dump completed on 2018-05-17 20:49:53
