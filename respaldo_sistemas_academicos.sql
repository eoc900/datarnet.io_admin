-- MySQL dump 10.13  Distrib 8.3.0, for macos14 (arm64)
--
-- Host: localhost    Database: dashboards
-- ------------------------------------------------------
-- Server version	8.3.0

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
-- Table structure for table `sistemas_academicos`
--

DROP TABLE IF EXISTS `sistemas_academicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sistemas_academicos` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_escuela` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_sistema` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creada_por` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sistemas_academicos_codigo_sistema_unique` (`codigo_sistema`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sistemas_academicos`
--

LOCK TABLES `sistemas_academicos` WRITE;
/*!40000 ALTER TABLE `sistemas_academicos` DISABLE KEYS */;
INSERT INTO `sistemas_academicos` VALUES ('5597f0e4-f902-42f6-b28b-db8cb55028e1','aa693fff-1014-4b2e-87a6-a14a121de26a','CECe-LicConta','Licenciatura','Licenciatura En Contaduría','f915b7b3-4940-499a-9c88-7426588eb7a2',1,'2024-08-28 00:08:42','2024-08-30 05:59:40'),('902fb34d-30b1-4a33-9d99-bf84fdac568c','aa693fff-1014-4b2e-87a6-a14a121de26a','CECe-LII','Ingeniería','Licenciatura en Ingeniería Industrial','f915b7b3-4940-499a-9c88-7426588eb7a2',1,'2024-08-30 06:04:11','2024-08-30 06:04:11');
/*!40000 ALTER TABLE `sistemas_academicos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-29 18:17:17
