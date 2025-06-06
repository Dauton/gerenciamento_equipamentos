CREATE DATABASE  IF NOT EXISTS `gerenciamento_equipamentos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `gerenciamento_equipamentos`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: gerenciamento_equipamentos
-- ------------------------------------------------------
-- Server version	8.0.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `relatorios`
--

DROP TABLE IF EXISTS `relatorios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `relatorios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site` varchar(45) NOT NULL,
  `equipamento` varchar(100) NOT NULL,
  `colaborador` varchar(256) NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `turno` varchar(45) NOT NULL,
  `agente_entrega` varchar(256) NOT NULL,
  `data_entrega` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `agente_devolucao` varchar(256) DEFAULT NULL,
  `data_devolucao` datetime DEFAULT NULL,
  `avaria` varchar(256) DEFAULT NULL,
  `foto_avaria` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relatorios`
--

LOCK TABLES `relatorios` WRITE;
/*!40000 ALTER TABLE `relatorios` DISABLE KEYS */;
INSERT INTO `relatorios` VALUES (1,'CDARCEX','004090','153253 - ABNER HENRIQUE GOMES DE MIRANDA','INVENTÁRIO','T2','DAUTON PEREIRA FELIX','2025-04-28 19:35:35','DAUTON PEREIRA FELIX','2025-04-28 16:35:56','NÃO',NULL),(2,'CDARCEX','00185','141522 - ALEXANDRE BUENO DE LIMA','INVENTÁRIO','T2','DAUTON PEREIRA FELIX','2025-04-29 17:13:43','DAUTON PEREIRA FELIX','2025-04-29 14:14:14','TELA DANIFICADA - FÍSICO (HARDWARE)','assets/uploads/images/29-04-2025-681108e66cdb4.jpeg'),(3,'CDARCEX','00185','141522 - ALEXANDRE BUENO DE LIMA','EXPEDIÇÃO','T3','DAUTON PEREIRA FELIX','2025-04-29 17:14:32','DAUTON PEREIRA FELIX','2025-04-29 14:15:23','NÃO',NULL),(4,'CDARCEX','004089','165803 - CAMILA VITORINO DA SILVA','EXPEDIÇÃO','T2','DAUTON PEREIRA FELIX','2025-04-29 17:16:41',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `relatorios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-10 14:50:49
