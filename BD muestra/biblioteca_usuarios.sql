-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: biblioteca
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','lector') DEFAULT 'lector',
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'José','Ramírez','admin@hotmail.com','$2y$10$J4J/L/NUoY89ISQ6Tkt/FeSfaJEAdQO0ODTYrm8SN9jLu2nt3Mp6K','admin'),(2,'José','Ramírez','admin@gotmail.com','$2y$10$e.B6KOS6P2zdPPhHnvajtuEF9WPkvOJO9AveQoPs/GTreyexLS9IO','lector'),(3,'José','Ramírez','admin@gmail.com','$2y$10$p0fgGDYPa1HkQj2xIPYDWuYrP5m9yu.V6TWFy/8Dppc56Z7XX40vG','lector'),(4,'a','b','a@hotmail.com','$2y$10$KabzCq3f3emoaBf1TaHS7eUoxHeZkwNr2/TuNLAr3jCO4JUsv7d66','lector'),(5,'c','b','c@hotmail.com','$2y$10$I2V2PUPVQ6YX/cRvYREXA.oaXNAtjI0529iYhF.qCtvesRbkst.1C','lector'),(6,'d','g','g@hotmail.com','$2y$10$yjNK7lbR5eqrz3UY0WQj6.boqpVzPNmBNZCvITYHruFxhsSFYufQe','lector'),(7,'pablo','Perez','pablo@gmail.com','$2y$10$QJ5YUvNJ7t/XDg75hz2P0ejF/cWgGTjEfu80SeO8ythaoZ7YDMU9i','lector'),(8,'Karla','Lopez','karla@gmail.com','$2y$10$lJ498YBMRc8ed2fNTD3jAuMQl86ltttjFTodbsWYNs48bD7xQgqlC','lector'),(9,'Gerardo','Perez','perez@gmail.com','$2y$10$onQH.KaovIlht2wmpcSpre/NPDNGJMv7Wq6SZFz4HPWbGRqJWLnrS','lector');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-10  2:17:01
