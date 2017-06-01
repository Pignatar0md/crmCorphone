CREATE DATABASE  IF NOT EXISTS `infoBases` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `infoBases`;
-- MySQL dump 10.13  Distrib 5.5.43, for debian-linux-gnu (x86_64)
--
-- Host: 172.16.20.238    Database: infoBases
-- ------------------------------------------------------
-- Server version	5.0.95

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
-- Not dumping tablespaces as no INFORMATION_SCHEMA.FILES table on this server
--

--
-- Table structure for table `Bases`
--

DROP TABLE IF EXISTS `Bases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Bases` (
  `id` int(11) NOT NULL auto_increment,
  `fecha` datetime NOT NULL,
  `nombre` varchar(45) default NULL,
  `cdadregistros` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Bases`
--

LOCK TABLES `Bases` WRITE;
/*!40000 ALTER TABLE `Bases` DISABLE KEYS */;
/*!40000 ALTER TABLE `Bases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Registro_Listas`
--

DROP TABLE IF EXISTS `Registro_Listas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Registro_Listas` (
  `id` int(11) NOT NULL auto_increment,
  `id_reg_lista` int(11) NOT NULL,
  `id_lista` int(11) NOT NULL,
  `comentario` varchar(100) default NULL,
  `venta` tinyint(4) default NULL,
  `contacto` tinyint(4) default NULL,
  `resul_contacto` varchar(45) default NULL,
  `fecha` date default NULL,
  `hora` time default NULL,
  `camp` varchar(45) default NULL,
  `grabac` varchar(100) default NULL,
  `agente` varchar(45) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Registro_Listas`
--

LOCK TABLES `Registro_Listas` WRITE;
/*!40000 ALTER TABLE `Registro_Listas` DISABLE KEYS */;
/*!40000 ALTER TABLE `Registro_Listas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lista_llam_manuales`
--

DROP TABLE IF EXISTS `lista_llam_manuales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lista_llam_manuales` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(45) default NULL,
  `apellido` varchar(45) default NULL,
  `dni` varchar(45) default NULL,
  `tel` varchar(45) default NULL,
  `tel_alt` varchar(45) default NULL,
  `direccion` varchar(45) default NULL,
  `email` varchar(45) default NULL,
  `codpostal` varchar(45) default NULL,
  `fechanacim` varchar(45) default NULL,
  `contacto` int(11) default NULL,
  `resulContacto` varchar(45) default NULL,
  `venta` int(11) default NULL,
  `fecha` date default NULL,
  `hora` time default NULL,
  `coment` varchar(100) default NULL,
  `agente` varchar(45) default NULL,
  `grabac` varchar(45) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lista_llam_manuales`
--

LOCK TABLES `lista_llam_manuales` WRITE;
/*!40000 ALTER TABLE `lista_llam_manuales` DISABLE KEYS */;
/*!40000 ALTER TABLE `lista_llam_manuales` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-15  9:57:48
