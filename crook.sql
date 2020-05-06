-- MySQL dump 10.13  Distrib 8.0.19, for osx10.15 (x86_64)
--
-- Host: localhost    Database: crook
-- ------------------------------------------------------
-- Server version	8.0.19

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
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `sheet_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `sheet_id` (`sheet_id`),
  CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`sheet_id`) REFERENCES `sheet` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `language`
--

DROP TABLE IF EXISTS `language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `language` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `color` varchar(10) DEFAULT NULL,
  `image` text,
  `is_valid` tinyint NOT NULL,
  `create_at` date NOT NULL,
  `update_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `language`
--

LOCK TABLES `language` WRITE;
/*!40000 ALTER TABLE `language` DISABLE KEYS */;
INSERT INTO `language` VALUES (1,'JavaScript','#8892bf','https://upload-icon.s3.us-east-2.amazonaws.com/uploads/icons/png/13691885491579517854-512.png',1,'2020-05-05',NULL),(2,'PHP','#8892bf','https://upload-icon.s3.us-east-2.amazonaws.com/uploads/icons/png/8717325371579517868-512.png',1,'2020-05-05',NULL),(3,'Java','#8892bf','https://upload-icon.s3.us-east-2.amazonaws.com/uploads/icons/png/378554371540553613-512.png',1,'2020-05-05',NULL),(4,'Angular','#8892bf','https://upload-icon.s3.us-east-2.amazonaws.com/uploads/icons/png/18594121091536125453-512.png',1,'2020-05-05',NULL);
/*!40000 ALTER TABLE `language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `popularity`
--

DROP TABLE IF EXISTS `popularity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `popularity` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `sheet_id` int NOT NULL,
  `vote` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sheet_id` (`sheet_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `popularity_ibfk_1` FOREIGN KEY (`sheet_id`) REFERENCES `sheet` (`id`),
  CONSTRAINT `popularity_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `popularity`
--

LOCK TABLES `popularity` WRITE;
/*!40000 ALTER TABLE `popularity` DISABLE KEYS */;
/*!40000 ALTER TABLE `popularity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sheet`
--

DROP TABLE IF EXISTS `sheet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sheet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  `language_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `language_id` (`language_id`),
  CONSTRAINT `sheet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `sheet_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sheet`
--

LOCK TABLES `sheet` WRITE;
/*!40000 ALTER TABLE `sheet` DISABLE KEYS */;
INSERT INTO `sheet` VALUES (1,'in_array()','Indique si une valeur appartient à un tableau','Recherche needle dans haystack en utilisant une comparaison souple à moins que strict ne soit utilisé.  :  in_array ( mixed $needle , array $haystack [, bool $strict = FALSE ] ) : bool','2020-05-05 13:02:09',NULL,4,2),(2,'count','Compte tous les éléments d\'un tableau ou quelque chose d\'un objet','Pour les objets, count() retourne le nombre de propriétés non-statiques, sans tenir compte de la visibilité. Si SPL est disponible, vous pouvez utiliser la fonction count() en implémentant l\'interface Countable. Cette interface a exactement une méthode, Countable::count(), qui retourne la valeur retournée par la fonction count().','2020-05-05 13:02:09',NULL,3,2),(3,'trim',' Supprime les espaces (ou d\'autres caractères) en début et fin de chaîne','trim() retourne la chaîne str, après avoir supprimé les caractères invisibles en début et fin de chaîne. trim ( string $str [, string $character_mask = \" \\t\\n\\r\\0\\x0B\" ] ) : string','2020-05-05 13:02:09',NULL,3,2),(4,'preg_match()','Effectue une recherche de correspondance avec une expression rationnelle standard','Analyse subject pour trouver l\'expression qui correspond à pattern. : preg_match ( string $pattern , string $subject [, array &$matches [, int $flags = 0 [, int $offset = 0 ]]] ) : int','2020-05-05 13:02:09',NULL,1,2),(5,'strtolower','Renvoie une chaîne en minuscules','Retourne string, après avoir converti tous les caractères alphabétiques en minuscules. : strtolower ( string $string ) : string\n ','2020-05-05 13:02:09',NULL,4,2),(6,'lenght','La propriété arguments.length contient le nombre d\'arguments passés à la fonction.','La propriété arguments.length fournit le nombre d\'arguments qui ont été passés à la fonction. ','2020-05-05 13:02:09',NULL,1,1),(7,'array','L\'objet global Array est utilisé pour créer des tableaux.','Les tableaux sont des objets de haut-niveau (en termes de complexité homme-machine) semblables à des listes. : const fruits = [\'Apple\', \'Banana\'];','2020-05-05 13:02:32',NULL,2,1),(8,'array','En Java, un tableau (tableau) est une structure de données contenant un groupe d\'éléments tous du même type','un tableau (tableau) est une structure de données contenant un groupe d\'éléments tous du même type, avec des adresses consécutives sur la mémoire (memory). Le tableau a le nombre fixé d\'éléments et vous ne pouvez pas changer sa taille.Les éléments d\'un tableau sont marqués par un index (index) commençant à l\'index 0. Vous pouvez accéder à ses éléments par son index.','2020-05-05 13:02:32',NULL,1,3),(9,'array','test array angular','excellent j\'adore l\'abstrait ','2020-05-05 13:02:32',NULL,1,4),(10,'preg_match()','Effectue une recherche de correspondance avec une expression rationnelle standard','Analyse subject pour trouver l\'expression qui correspond à pattern. : preg_match ( string $pattern , string $subject [, array &$matches [, int $flags = 0 [, int $offset = 0 ]]] ) : int','2020-05-05 13:02:32',NULL,5,2),(11,'strtolower','Renvoie une chaîne en minuscules','Retourne string, après avoir converti tous les caractères alphabétiques en minuscules. : strtolower ( string $string ) : string  ','2020-05-05 13:02:32',NULL,5,2);
/*!40000 ALTER TABLE `sheet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_user` varchar(100) NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Covid19','covid19@hotmail.fr','$2y$10$QK2QgQp8SUuy4nBw3Td07.KJ8o27xj2rdWhgHgZjdS/EKhmkiS7Qa','','2020-05-05 13:00:38',NULL),(2,'toto19','covid19@hotmail.fr','$2y$10$QK2QgQp8SUuy4nBw3Td07.KJ8o27xj2rdWhgHgZjdS/EKhmkiS7Qa','','2020-05-05 13:00:38',NULL),(3,'SupremeLeader','SupremeLeader@hotmail.fr','$2y$10$QK2QgQp8SUuy4nBw3Td07.KJ8o27xj2rdWhgHgZjdS/EKhmkiS7Qa','','2020-05-05 13:00:38',NULL),(4,'toto43','toto43@hotmail.fr','$2y$10$QK2QgQp8SUuy4nBw3Td07.KJ8o27xj2rdWhgHgZjdS/EKhmkiS7Qa','','2020-05-05 13:00:38',NULL),(5,'LordKing','king@hotmail.fr','$2y$10$QK2QgQp8SUuy4nBw3Td07.KJ8o27xj2rdWhgHgZjdS/EKhmkiS7Qa','','2020-05-05 13:00:38',NULL),(6,'Covid19','covid19@hotmail.fr','$2y$10$sEm3hAa0.6YsGYz6tr9wwOhxcyi4XgY9D/SdJax5tX/pqzkkZ7Uim','','2020-05-05 13:01:12',NULL),(7,'toto19','covid19@hotmail.fr','$2y$10$sEm3hAa0.6YsGYz6tr9wwOhxcyi4XgY9D/SdJax5tX/pqzkkZ7Uim','','2020-05-05 13:01:12',NULL),(8,'SupremeLeader','SupremeLeader@hotmail.fr','$2y$10$sEm3hAa0.6YsGYz6tr9wwOhxcyi4XgY9D/SdJax5tX/pqzkkZ7Uim','','2020-05-05 13:01:12',NULL),(9,'toto43','toto43@hotmail.fr','$2y$10$sEm3hAa0.6YsGYz6tr9wwOhxcyi4XgY9D/SdJax5tX/pqzkkZ7Uim','','2020-05-05 13:01:12',NULL),(10,'LordKing','king@hotmail.fr','$2y$10$sEm3hAa0.6YsGYz6tr9wwOhxcyi4XgY9D/SdJax5tX/pqzkkZ7Uim','','2020-05-05 13:01:12',NULL),(11,'Covid19','covid19@hotmail.fr','$2y$10$bLJ36KTLFaQEz5SZXYxdRO5lnqAWGGIWcjPV5IAdqaj2NYuoL2am2','','2020-05-05 13:02:09',NULL),(12,'toto19','covid19@hotmail.fr','$2y$10$bLJ36KTLFaQEz5SZXYxdRO5lnqAWGGIWcjPV5IAdqaj2NYuoL2am2','','2020-05-05 13:02:09',NULL),(13,'SupremeLeader','SupremeLeader@hotmail.fr','$2y$10$bLJ36KTLFaQEz5SZXYxdRO5lnqAWGGIWcjPV5IAdqaj2NYuoL2am2','','2020-05-05 13:02:09',NULL),(14,'toto43','toto43@hotmail.fr','$2y$10$bLJ36KTLFaQEz5SZXYxdRO5lnqAWGGIWcjPV5IAdqaj2NYuoL2am2','','2020-05-05 13:02:09',NULL),(15,'LordKing','king@hotmail.fr','$2y$10$bLJ36KTLFaQEz5SZXYxdRO5lnqAWGGIWcjPV5IAdqaj2NYuoL2am2','','2020-05-05 13:02:09',NULL),(16,'Covid19','covid19@hotmail.fr','$2y$10$kaWRwm/IWc6wR4WQDp6L7eR8HtNFglSnWiY58AuRcXSsvKRx3J9mi','ROLE_USER','2020-05-05 13:02:32',NULL),(17,'toto19','covid19@hotmail.fr','$2y$10$kaWRwm/IWc6wR4WQDp6L7eR8HtNFglSnWiY58AuRcXSsvKRx3J9mi','ROLE_USER','2020-05-05 13:02:32',NULL),(18,'SupremeLeader','SupremeLeader@hotmail.fr','$2y$10$kaWRwm/IWc6wR4WQDp6L7eR8HtNFglSnWiY58AuRcXSsvKRx3J9mi','ROLE_USER','2020-05-05 13:02:32',NULL),(19,'toto43','toto43@hotmail.fr','$2y$10$kaWRwm/IWc6wR4WQDp6L7eR8HtNFglSnWiY58AuRcXSsvKRx3J9mi','ROLE_ADMIN','2020-05-05 13:02:32',NULL),(20,'LordKing','king@hotmail.fr','$2y$10$kaWRwm/IWc6wR4WQDp6L7eR8HtNFglSnWiY58AuRcXSsvKRx3J9mi','ROLE_USER','2020-05-05 13:02:32',NULL),(21,'froufrou','francislapyere@froufrou.fr','$2y$10$xHnpvBrap2zyMtIe5ujQburxIBzlgo9YbSWT5Bf6toTIAqSgUVJr.','ROLE_USER','2020-05-05 15:48:52',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-06 10:19:06
