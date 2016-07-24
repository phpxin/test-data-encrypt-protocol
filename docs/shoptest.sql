-- MySQL dump 10.13  Distrib 5.6.25, for Linux (x86_64)
--
-- Host: localhost    Database: shoptest
-- ------------------------------------------------------
-- Server version	5.6.25-debug-log

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
-- Table structure for table `client_order`
--

DROP TABLE IF EXISTS `client_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` float DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `key` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_order`
--

LOCK TABLES `client_order` WRITE;
/*!40000 ALTER TABLE `client_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_client`
--

DROP TABLE IF EXISTS `server_client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keypath` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_client`
--

LOCK TABLES `server_client` WRITE;
/*!40000 ALTER TABLE `server_client` DISABLE KEYS */;
INSERT INTO `server_client` VALUES (1,'178281177839392.pem');
/*!40000 ALTER TABLE `server_client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_keystore`
--

DROP TABLE IF EXISTS `server_keystore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_keystore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `losetime` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='保存一次性加密key';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_keystore`
--

LOCK TABLES `server_keystore` WRITE;
/*!40000 ALTER TABLE `server_keystore` DISABLE KEYS */;
INSERT INTO `server_keystore` VALUES (1,'336e4fcc43',3360000,3360000,1),(2,'c06b57c153593ad97339f96585f6692a',0,0,1),(3,'3b6bd018360bb5464e081274b7e9467b',3,3,1),(4,'3891b14b5d8cce2fdd8dcdb4ded28f6d',3891,3891,1),(5,'4a64d913220fca4c33c140c6952688a8',4,4,1),(6,'0563cad67522fc198dee8690630e475a',563,563,1),(7,'4057aa8a48c7e64a18523c8c26a38ea3',4057,4057,1),(8,'8708cc4b4fd657032eddc86555279921',8708,8708,1),(9,'894a9b94bcc5969b60bd18e8ea9c0ddc',894,894,1),(10,'0107acb41ef20db2289d261d4e34fd38',107,107,1),(11,'857cd81e6a7d216eeaf1946a803a7d5e',857,857,1),(12,'81448138f5f163ccdba4acc69819f280',81448138,81448138,1),(13,'186fb23a33995d91ce3c2212189178c8',186,186,1),(14,'93189dd27c5c3221f5687b74bcba0ab6',93189,93189,1),(15,'581a6e50827b30666330b83d8d0e3f59',581,581,1),(16,'172fd0d638b3282151bd8f3d652cb640',172,172,1),(17,'338c070809f38739e58e2a12a2684633',338,338,1),(18,'197375e98eac65e65da5ff18ec512978',2147483647,2147483647,1),(19,'608b78a38cd26383321b54a3b02f68db',608,608,1),(20,'2d13dd919b0ec4519c4a0967c4c7cd47',2,2,1),(21,'1f9f9d8ff75205aa73ec83e543d8b571',1,1,1),(22,'cb5f437833b580d047e697e150c45c57',0,0,1),(23,'872d5654103496154db06b95c14d6735',1469336724,1469337024,1),(24,'909c71100210781d37a568c5fc14e627',1469337860,1469338160,1),(25,'0a03d5e4473c0629cfb20c5c31543b06',1469340476,1469340776,1),(26,'218a6beba67ce30416235c45f0357c20',1469340832,1469341132,2),(27,'231182acb75cdce3350df92d900c7f91',1469340892,1469341192,2),(28,'9b8c60725a0193e78368bf8b84c37fb2',1469341134,1469341434,2);
/*!40000 ALTER TABLE `server_keystore` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_order`
--

DROP TABLE IF EXISTS `server_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` float DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `keyid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `oid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_order`
--

LOCK TABLES `server_order` WRITE;
/*!40000 ALTER TABLE `server_order` DISABLE KEYS */;
INSERT INTO `server_order` VALUES (3,100,1469340842,26,1,1),(4,100,1469340902,27,1,1),(5,100,1469341144,28,1,1);
/*!40000 ALTER TABLE `server_order` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-23 14:09:45
