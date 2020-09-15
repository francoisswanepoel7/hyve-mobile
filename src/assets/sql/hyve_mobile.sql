-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: hyve_mobile
-- ------------------------------------------------------
-- Server version	8.0.21-0ubuntu0.20.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact` (
  `title` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(250) COLLATE utf8mb4_general_ci UNIQUE NOT NULL,
  `note` mediumtext COLLATE utf8mb4_general_ci,
  `card` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `id` bigint unsigned NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_timezone`
--

DROP TABLE IF EXISTS `contact_timezone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_timezone` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tstamp_local` datetime NOT NULL,
  `tstamp_utc` datetime NOT NULL,
  `contact_id` bigint unsigned NOT NULL,
  `timezone_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_FK` (`contact_id`),
  CONSTRAINT `contact_FK` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`),
  KEY `timezone_FK` (`timezone_id`),
  CONSTRAINT `timezone_FK` FOREIGN KEY (`timezone_id`) REFERENCES `timezone` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_timezone`
--

LOCK TABLES `contact_timezone` WRITE;
/*!40000 ALTER TABLE `contact_timezone` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_timezone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `processed`
--

DROP TABLE IF EXISTS `processed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `processed` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `complete` tinyint(1) NOT NULL DEFAULT '0',
  `exported` tinyint(1) NOT NULL DEFAULT '0',
  `contact_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `processed_FK` (`contact_id`),
  CONSTRAINT `processed_FK` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `processed`
--

LOCK TABLES `processed` WRITE;
/*!40000 ALTER TABLE `processed` DISABLE KEYS */;
/*!40000 ALTER TABLE `processed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timezone`
--

DROP TABLE IF EXISTS `timezone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `timezone` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `region` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `tz` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timezone`
--

LOCK TABLES `timezone` WRITE;
/*!40000 ALTER TABLE `timezone` DISABLE KEYS */;
/*!40000 ALTER TABLE `timezone` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-09-14 18:10:19
