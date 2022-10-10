-- MariaDB dump 10.19  Distrib 10.5.15-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: gatones
-- ------------------------------------------------------
-- Server version	10.5.15-MariaDB-0+deb11u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `gatos`
--

DROP TABLE IF EXISTS `gatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `dueno` varchar(100) NOT NULL,
  `comida` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gato_id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gatos`
--

LOCK TABLES `gatos` WRITE;
/*!40000 ALTER TABLE `gatos` DISABLE KEYS */;
INSERT INTO `gatos` VALUES (1,'Reyes','Ana','merluza'),(2,'Rayas','Juanillo','buey'),(3,'Pardo','Juanillo','pollo'),(4,'Tigretón','María','marisco'),(5,'Miaoii','Ana','filete'),(10,'No Me Puedes Borrar!','Dani','aves'),(11,'Luisa','Pepa','tiburón'),(12,'Cacerolina','Rowualdo','peces vivos'),(14,'Gato Borrable','Marta','Borrados'),(15,'Otro Gato Borrable','Juan','Brrrrrrrrrrrss'),(16,'Borrar Tambien','Raul','filete');
/*!40000 ALTER TABLE `gatos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maullidos`
--

DROP TABLE IF EXISTS `maullidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maullidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maullido` varchar(100) NOT NULL,
  `sonido` varchar(100) NOT NULL,
  `gato_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gato_id_foreign` (`gato_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maullidos`
--

LOCK TABLES `maullidos` WRITE;
/*!40000 ALTER TABLE `maullidos` DISABLE KEYS */;
INSERT INTO `maullidos` VALUES (1,'Grrrruño!','ggggrrrrrrrrrrr',1),(2,'Qué felicidad','mmmmmmhhhhhrrrr',2),(3,'cazar','oooowwwww',1),(4,'Qué confort','Mmmmmrrrrrr',4),(5,'Tengo frío','bbrrrrrrrr',2),(7,'Una araña','miaouuu',4),(9,'Borrable','Brrrrr',2),(10,'Otro borrable','Br',5),(11,'Más borrables','Brr',6);
/*!40000 ALTER TABLE `maullidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `status` enum('pronunciado','silenciado') NOT NULL DEFAULT 'pronunciado',
  `content` varchar(100) NOT NULL,
  `gato_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gato_id_foreign` (`gato_id`),
  CONSTRAINT `gato_id_foreign` FOREIGN KEY (`gato_id`) REFERENCES `gatos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Grrrrrrr!','pronunciado','grrrrrrrrrrrrr',2),(2,'Qué placer es POLLO!','pronunciado','mmmmhhhhrrrrr',1),(3,'Huy eso no me lo esperaba!','pronunciado','oooowwwww',1),(4,'Qué hago cuando veo un ratón','pronunciado','aaaaaaaarrrgghh',1),(5,'Me gustan las caricias','silenciado','mmmmmmhhhhhhh',3),(7,'Hala!','pronunciado','Hala!',4),(12,'Borrable 2','silenciado','Que no que no me puedes borrar',5),(15,'Borrable','pronunciado','Brrrrr',2),(16,'Borrable 3','silenciado','Brrrr',5);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-06 19:53:29
