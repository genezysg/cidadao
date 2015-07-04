-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: localhost    Database: casacidadao
-- ------------------------------------------------------
-- Server version	5.6.17

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
-- Table structure for table `andamento`
--

DROP TABLE IF EXISTS `andamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `andamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) DEFAULT NULL,
  `localAudiencia` varchar(45) DEFAULT NULL,
  `dataHora` datetime DEFAULT NULL,
  `idCausa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_causa_andamento_idx` (`idCausa`),
  CONSTRAINT `fk_causa_andamento` FOREIGN KEY (`idCausa`) REFERENCES `causa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `andamento`
--

LOCK TABLES `andamento` WRITE;
/*!40000 ALTER TABLE `andamento` DISABLE KEYS */;
INSERT INTO `andamento` VALUES (1,'abcx','a','0000-00-00 00:00:00',1),(2,'cdef','b','0000-00-00 00:00:00',1),(3,'cdef','b','0000-00-00 00:00:00',1),(4,'cdef','b','0000-00-00 00:00:00',1),(5,'cdef','b','0000-00-00 00:00:00',1),(6,'cdef','b','0000-00-00 00:00:00',1),(7,'cdef','b','0000-00-00 00:00:00',1),(8,'cdef','b','0000-00-00 00:00:00',1),(9,'cdef','b','0000-00-00 00:00:00',1);
/*!40000 ALTER TABLE `andamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `areaatendimento`
--

DROP TABLE IF EXISTS `areaatendimento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areaatendimento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areaatendimento`
--

LOCK TABLES `areaatendimento` WRITE;
/*!40000 ALTER TABLE `areaatendimento` DISABLE KEYS */;
INSERT INTO `areaatendimento` VALUES (1,'a');
/*!40000 ALTER TABLE `areaatendimento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assistido`
--

DROP TABLE IF EXISTS `assistido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assistido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `nacionalidade` varchar(45) DEFAULT NULL,
  `estadoCivil` varchar(45) DEFAULT NULL,
  `profissao` varchar(45) DEFAULT NULL,
  `identidade` varchar(45) DEFAULT NULL,
  `cpf` varchar(45) DEFAULT NULL,
  `dataNascimento` varchar(45) DEFAULT NULL,
  `nomePai` varchar(45) DEFAULT NULL,
  `nomeMae` varchar(45) DEFAULT NULL,
  `endereco` varchar(45) DEFAULT NULL,
  `rendimentoPessoal` double DEFAULT NULL,
  `rendimentoFamiliar` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assistido`
--

LOCK TABLES `assistido` WRITE;
/*!40000 ALTER TABLE `assistido` DISABLE KEYS */;
INSERT INTO `assistido` VALUES (1,'a','a','a','a','a','a','1995-07-13','a','a','a',1,1);
/*!40000 ALTER TABLE `assistido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `causa`
--

DROP TABLE IF EXISTS `causa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `causa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(45) DEFAULT NULL,
  `relato` varchar(200) DEFAULT NULL,
  `prazoDecadencial` varchar(45) DEFAULT NULL,
  `prazoPrescricional` varchar(45) DEFAULT NULL,
  `dataAtendimento` datetime DEFAULT NULL,
  `localAtendimento` varchar(45) DEFAULT NULL,
  `tipoAcao` varchar(45) DEFAULT NULL,
  `idAreaAtendimento` int(11) DEFAULT NULL,
  `idAssistido` int(11) DEFAULT NULL,
  `aquivado` tinyint(4) DEFAULT NULL,
  `idPartecontraria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_causa_area_atendimento_idx` (`idAreaAtendimento`),
  KEY `fk_assistido_causa_idx` (`idAssistido`),
  KEY `fk_causa_partecontraria_idx` (`idPartecontraria`),
  CONSTRAINT `fk_assistido_causa` FOREIGN KEY (`idAssistido`) REFERENCES `assistido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_causa_area_atendimento` FOREIGN KEY (`idAreaAtendimento`) REFERENCES `areaatendimento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_causa_partecontraria` FOREIGN KEY (`idPartecontraria`) REFERENCES `partecontraria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `causa`
--

LOCK TABLES `causa` WRITE;
/*!40000 ALTER TABLE `causa` DISABLE KEYS */;
INSERT INTO `causa` VALUES (1,'Em processo','a','a','a','0000-00-00 00:00:00',NULL,'a',1,1,0,1),(2,'Em processo','a','a','a','0000-00-00 00:00:00',NULL,'a',1,1,0,1);
/*!40000 ALTER TABLE `causa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partecontraria`
--

DROP TABLE IF EXISTS `partecontraria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partecontraria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `enderecoResidencial` varchar(45) DEFAULT NULL,
  `enderecoComercial` varchar(45) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partecontraria`
--

LOCK TABLES `partecontraria` WRITE;
/*!40000 ALTER TABLE `partecontraria` DISABLE KEYS */;
INSERT INTO `partecontraria` VALUES (1,'a','a','a','a','a');
/*!40000 ALTER TABLE `partecontraria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testemunha`
--

DROP TABLE IF EXISTS `testemunha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testemunha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `endereco` varchar(45) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `idCausa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_causa_testemunha_idx` (`idCausa`),
  CONSTRAINT `fk_causa_testemunha` FOREIGN KEY (`idCausa`) REFERENCES `causa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testemunha`
--

LOCK TABLES `testemunha` WRITE;
/*!40000 ALTER TABLE `testemunha` DISABLE KEYS */;
INSERT INTO `testemunha` VALUES (1,'a','a','a',1);
/*!40000 ALTER TABLE `testemunha` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-07-03 20:55:45
