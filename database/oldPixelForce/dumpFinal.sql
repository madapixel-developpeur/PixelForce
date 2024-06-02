-- MySQL dump 10.13  Distrib 5.7.34, for osx10.12 (x86_64)
--
-- Host: mysql-pixelfocedev.alwaysdata.net    Database: pixelfocedev_bdd
-- ------------------------------------------------------
-- Server version	5.5.5-10.6.7-MariaDB

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
-- Table structure for table `account_validation`
--

DROP TABLE IF EXISTS `account_validation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_validation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verif_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_expiration` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_validation`
--

LOCK TABLES `account_validation` WRITE;
/*!40000 ALTER TABLE `account_validation` DISABLE KEYS */;
INSERT INTO `account_validation` VALUES (1,'mnakanyandriamihaja@gmail.com','07d8fcde8305039c5a0fefecf5aca66db95bff83','2022-07-20 07:29:05',0),(2,'mnakanyandriamihaja@gmail.com','6298f67c02e7255e8166cc6150b434e5e25e5d9c','2022-07-20 08:00:35',0),(3,'clientdigital@gmail.com','71ddc1c1a9d91b0f3fe267f2e0fd3b99244fbce2','2022-08-02 18:06:43',1),(4,'mnakanyandriamihaja@gmail.com','401a4f42bea113d9cd964703b1659dee70c4b229','2022-08-02 18:08:44',0);
/*!40000 ALTER TABLE `account_validation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `active_agent`
--

DROP TABLE IF EXISTS `active_agent`;
/*!50001 DROP VIEW IF EXISTS `active_agent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `active_agent` AS SELECT 
 1 AS `id`,
 1 AS `contact_client_id`,
 1 AS `client_agent_id`,
 1 AS `email`,
 1 AS `username`,
 1 AS `roles`,
 1 AS `password`,
 1 AS `nom`,
 1 AS `prenom`,
 1 AS `date_naissance`,
 1 AS `adresse`,
 1 AS `numero_securite`,
 1 AS `rib`,
 1 AS `photo`,
 1 AS `six_digit_code`,
 1 AS `forgotten_pass_token`,
 1 AS `active`,
 1 AS `api_token`,
 1 AS `telephone`,
 1 AS `created_at`,
 1 AS `code_postal`,
 1 AS `lien_calendly`,
 1 AS `stripe_data`,
 1 AS `account_status`,
 1 AS `account_start_date`,
 1 AS `stripe_customer_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `active_clients`
--

DROP TABLE IF EXISTS `active_clients`;
/*!50001 DROP VIEW IF EXISTS `active_clients`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `active_clients` AS SELECT 
 1 AS `id`,
 1 AS `contact_client_id`,
 1 AS `client_agent_id`,
 1 AS `email`,
 1 AS `username`,
 1 AS `roles`,
 1 AS `password`,
 1 AS `nom`,
 1 AS `prenom`,
 1 AS `date_naissance`,
 1 AS `adresse`,
 1 AS `numero_securite`,
 1 AS `rib`,
 1 AS `photo`,
 1 AS `six_digit_code`,
 1 AS `forgotten_pass_token`,
 1 AS `active`,
 1 AS `api_token`,
 1 AS `telephone`,
 1 AS `created_at`,
 1 AS `code_postal`,
 1 AS `lien_calendly`,
 1 AS `stripe_data`,
 1 AS `account_status`,
 1 AS `account_start_date`,
 1 AS `stripe_customer_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `active_coach`
--

DROP TABLE IF EXISTS `active_coach`;
/*!50001 DROP VIEW IF EXISTS `active_coach`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `active_coach` AS SELECT 
 1 AS `id`,
 1 AS `contact_client_id`,
 1 AS `client_agent_id`,
 1 AS `email`,
 1 AS `username`,
 1 AS `roles`,
 1 AS `password`,
 1 AS `nom`,
 1 AS `prenom`,
 1 AS `date_naissance`,
 1 AS `adresse`,
 1 AS `numero_securite`,
 1 AS `rib`,
 1 AS `photo`,
 1 AS `six_digit_code`,
 1 AS `forgotten_pass_token`,
 1 AS `active`,
 1 AS `api_token`,
 1 AS `telephone`,
 1 AS `created_at`,
 1 AS `code_postal`,
 1 AS `lien_calendly`,
 1 AS `stripe_data`,
 1 AS `account_status`,
 1 AS `account_start_date`,
 1 AS `stripe_customer_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `active_user`
--

DROP TABLE IF EXISTS `active_user`;
/*!50001 DROP VIEW IF EXISTS `active_user`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `active_user` AS SELECT 
 1 AS `id`,
 1 AS `contact_client_id`,
 1 AS `client_agent_id`,
 1 AS `email`,
 1 AS `username`,
 1 AS `roles`,
 1 AS `password`,
 1 AS `nom`,
 1 AS `prenom`,
 1 AS `date_naissance`,
 1 AS `adresse`,
 1 AS `numero_securite`,
 1 AS `rib`,
 1 AS `photo`,
 1 AS `six_digit_code`,
 1 AS `forgotten_pass_token`,
 1 AS `active`,
 1 AS `api_token`,
 1 AS `telephone`,
 1 AS `created_at`,
 1 AS `code_postal`,
 1 AS `lien_calendly`,
 1 AS `stripe_data`,
 1 AS `account_status`,
 1 AS `account_start_date`,
 1 AS `stripe_customer_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `agent_secteur`
--

DROP TABLE IF EXISTS `agent_secteur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agent_secteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) DEFAULT NULL,
  `secteur_id` int(11) DEFAULT NULL,
  `date_validation` datetime DEFAULT NULL,
  `statut` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_521647B53414710B` (`agent_id`),
  KEY `IDX_521647B59F7E4405` (`secteur_id`),
  CONSTRAINT `FK_521647B53414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_521647B59F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent_secteur`
--

LOCK TABLES `agent_secteur` WRITE;
/*!40000 ALTER TABLE `agent_secteur` DISABLE KEYS */;
INSERT INTO `agent_secteur` VALUES (1,5,1,'2022-08-03 19:22:25',1),(2,6,2,NULL,1),(3,7,7,NULL,1),(4,12,4,NULL,1),(5,13,1,'2022-08-02 12:16:40',1),(6,14,3,'2022-08-02 06:38:57',1),(7,14,5,'2022-08-02 06:38:57',1),(8,14,7,'2022-08-02 06:38:57',1),(9,15,3,'2022-08-02 09:17:15',1),(10,15,4,'2022-08-02 09:17:15',1),(11,16,1,'2022-08-02 11:05:51',1),(12,16,2,'2022-08-02 11:05:51',1),(13,16,5,'2022-08-02 11:05:51',1),(14,18,1,'2022-08-03 07:24:47',1),(15,19,1,'2022-08-03 19:02:05',1),(16,19,5,'2022-08-03 19:02:05',1),(17,19,7,'2022-08-03 19:02:05',1),(19,21,1,'2022-08-03 19:35:17',1),(20,21,4,'2022-08-03 19:35:17',1),(21,21,5,'2022-08-03 19:35:17',1),(22,22,6,'2022-08-31 08:28:37',1),(23,25,3,'2022-09-07 09:12:01',1);
/*!40000 ALTER TABLE `agent_secteur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `agent_secteur_client_valide`
--

DROP TABLE IF EXISTS `agent_secteur_client_valide`;
/*!50001 DROP VIEW IF EXISTS `agent_secteur_client_valide`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `agent_secteur_client_valide` AS SELECT 
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `client_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `agent_secteur_valide`
--

DROP TABLE IF EXISTS `agent_secteur_valide`;
/*!50001 DROP VIEW IF EXISTS `agent_secteur_valide`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `agent_secteur_valide` AS SELECT 
 1 AS `id`,
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `date_validation`,
 1 AS `statut`,
 1 AS `type_secteur_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `all_type_order_valide`
--

DROP TABLE IF EXISTS `all_type_order_valide`;
/*!50001 DROP VIEW IF EXISTS `all_type_order_valide`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `all_type_order_valide` AS SELECT 
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `client_id`,
 1 AS `montant`,
 1 AS `date_commande`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `all_type_order_valide_all_client`
--

DROP TABLE IF EXISTS `all_type_order_valide_all_client`;
/*!50001 DROP VIEW IF EXISTS `all_type_order_valide_all_client`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `all_type_order_valide_all_client` AS SELECT 
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `client_id`,
 1 AS `montant`,
 1 AS `nbr`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `all_type_order_valide_gp_mois_annee`
--

DROP TABLE IF EXISTS `all_type_order_valide_gp_mois_annee`;
/*!50001 DROP VIEW IF EXISTS `all_type_order_valide_gp_mois_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `all_type_order_valide_gp_mois_annee` AS SELECT 
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `mois`,
 1 AS `annee`,
 1 AS `montant`,
 1 AS `nbr`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `all_type_order_valide_gp_mois_annee_secteur`
--

DROP TABLE IF EXISTS `all_type_order_valide_gp_mois_annee_secteur`;
/*!50001 DROP VIEW IF EXISTS `all_type_order_valide_gp_mois_annee_secteur`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `all_type_order_valide_gp_mois_annee_secteur` AS SELECT 
 1 AS `secteur_id`,
 1 AS `mois`,
 1 AS `annee`,
 1 AS `montant`,
 1 AS `nbr`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `all_type_order_valide_mois_annee`
--

DROP TABLE IF EXISTS `all_type_order_valide_mois_annee`;
/*!50001 DROP VIEW IF EXISTS `all_type_order_valide_mois_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `all_type_order_valide_mois_annee` AS SELECT 
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `client_id`,
 1 AS `montant`,
 1 AS `date_commande`,
 1 AS `mois`,
 1 AS `annee`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `all_type_order_valide_per_client`
--

DROP TABLE IF EXISTS `all_type_order_valide_per_client`;
/*!50001 DROP VIEW IF EXISTS `all_type_order_valide_per_client`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `all_type_order_valide_per_client` AS SELECT 
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `client_id`,
 1 AS `montant`,
 1 AS `nbr`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `basket_item`
--

DROP TABLE IF EXISTS `basket_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `basket_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `secteur_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D4943C2BF7384557` (`id_produit`),
  CONSTRAINT `FK_D4943C2BF7384557` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `basket_item`
--

LOCK TABLES `basket_item` WRITE;
/*!40000 ALTER TABLE `basket_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `basket_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar_event`
--

DROP TABLE IF EXISTS `calendar_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `calendar_event_label_id` int(11) DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `all_day` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `IDX_57FA09C9A76ED395` (`user_id`),
  KEY `IDX_57FA09C9C7D799B9` (`calendar_event_label_id`),
  CONSTRAINT `FK_57FA09C9A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_57FA09C9C7D799B9` FOREIGN KEY (`calendar_event_label_id`) REFERENCES `calendar_event_label` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_event`
--

LOCK TABLES `calendar_event` WRITE;
/*!40000 ALTER TABLE `calendar_event` DISABLE KEYS */;
INSERT INTO `calendar_event` VALUES (1,4,1,'','Rendez-vous avec le client','2022-08-03 08:06:11','2022-08-03 08:06:11',0),(2,5,2,'','Formation','2022-08-02 12:00:00','2022-08-04 12:00:00',0),(3,5,2,'','Formation','2022-08-12 00:00:00','2022-08-12 00:00:00',0),(4,2,2,'','Formation zoom','2022-08-16 17:00:00','2022-08-16 19:00:00',0),(6,6,2,'https://www.digitalocean.com/community/tutorials/how-to-secure-apache-with-let-s-encrypt-on-ubuntu-20-04-fr','test digital','2022-08-16 12:00:00','2022-08-17 12:00:00',1),(7,2,2,'https://ourcodeworld.com/articles/read/291/how-to-solve-the-client-side-access-control-allow-origin-request-error-with-your-own-symfony-3-api','Formation','2022-08-16 12:00:00','2022-08-17 12:00:00',1),(8,6,2,'','Formation','2022-08-17 00:00:00','2022-08-16 13:00:00',0),(9,3,1,'/meeting/fiche/1','Vente','2022-08-16 11:51:00','2022-08-16 12:05:00',0),(10,6,1,'/meeting/fiche/2','Vente','2022-08-16 11:51:00','2022-08-16 12:05:00',0),(12,2,2,'','Formation','2022-08-16 00:00:00','2022-08-17 12:00:00',0),(13,3,2,'','Formation','2022-08-17 00:00:00','2022-08-17 00:00:00',0),(16,3,1,'','Rendez-vous','2022-08-17 00:00:00','2022-08-16 13:00:00',0),(17,5,3,'','Zoom','2022-08-22 12:00:00','2022-08-22 13:00:00',0),(18,20,1,'/meeting/fiche/3','test rendez vous','2022-08-31 03:06:00','2022-08-31 04:06:00',0),(19,22,1,'/meeting/fiche/4','test rendez vous','2022-08-31 03:06:00','2022-08-31 04:06:00',0),(20,20,1,'/meeting/fiche/5','test rendez vous 2','2022-09-01 11:08:00','2022-09-01 12:08:00',0),(21,22,1,'/meeting/fiche/6','test rendez vous 2','2022-09-01 11:08:00','2022-09-01 12:08:00',0),(22,23,1,'/meeting/fiche/7','Vente','2022-09-02 07:06:00','2022-09-02 08:06:00',0),(23,15,1,'/meeting/fiche/8','Vente','2022-09-02 07:06:00','2022-09-02 08:06:00',0),(24,24,2,'','Préparation réunion pour la formation des nouveaux','2022-09-06 12:00:00','2022-09-06 13:00:00',0);
/*!40000 ALTER TABLE `calendar_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar_event_label`
--

DROP TABLE IF EXISTS `calendar_event_label`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_event_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_event_label`
--

LOCK TABLES `calendar_event_label` WRITE;
/*!40000 ALTER TABLE `calendar_event_label` DISABLE KEYS */;
INSERT INTO `calendar_event_label` VALUES (1,'Rendez-vous','meeting','rgba(255, 0, 0, 0.3)'),(2,'Formation','formation','rgba(0, 255, 0, 0.3)'),(3,'Autre','etc','rgba(0, 0, 0, 0.3)');
/*!40000 ALTER TABLE `calendar_event_label` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `canal_message`
--

DROP TABLE IF EXISTS `canal_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `canal_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_group` tinyint(1) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `vus` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `canal_message`
--

LOCK TABLES `canal_message` WRITE;
/*!40000 ALTER TABLE `canal_message` DISABLE KEYS */;
INSERT INTO `canal_message` VALUES (1,'TVE9PSYxMiNkNU1nPT0=','Coach Sécurité',0,'2022-08-02 11:36:11','a:1:{i:0;i:1;}'),(2,'TVE9PSYxMiNkNU13PT0=','Coach Digital',0,NULL,'a:0:{}'),(3,'TVE9PSYxMiNkNU5BPT0=','Coach Produit',0,NULL,'a:0:{}'),(4,'TkE9PSYxMiNkNU53PT0=',NULL,0,NULL,'a:0:{}'),(5,'TWc9PSYxMiNkNU5RPT0=',NULL,0,'2022-08-22 06:36:53','a:2:{i:0;i:2;i:1;i:5;}'),(6,'TVE9PSYxMiNkNU5RPT0=','Agent sécurité',0,NULL,'a:1:{i:0;i:5;}'),(7,'TVE9PSYxMiNkNU5nPT0=','Agent digital',0,NULL,'a:0:{}'),(8,'TVE9PSYxMiNkNU53PT0=','Agent produit',0,NULL,'a:0:{}'),(9,'TVE9PSYxMiNkNU1URT0=','Coach Immobilier',0,NULL,'a:0:{}'),(10,'TVRFPSYxMiNkNU1UST0=',NULL,0,NULL,'a:0:{}'),(11,'TVE9PSYxMiNkNU1UST0=','Agent Immobilier',0,NULL,'a:0:{}'),(12,'TVE9PSYxMiNkNU1UTT0=','Nouveau agent securite',0,NULL,'a:0:{}'),(13,'TVE9PSYxMiNkNU1UUT0=','multisecteur agent',0,NULL,'a:0:{}'),(14,'TVE9PSYxMiNkNU1UVT0=','Nouveau agent securite',0,NULL,'a:0:{}'),(15,'TVE9PSYxMiNkNU1UWT0=','Nouveau agent',0,NULL,'a:0:{}'),(16,'TWc9PSYxMiNkNU1UWT0=','Nouveau agent',0,NULL,'a:0:{}'),(17,'TWc9PSYxMiNkNU1UTT0=',NULL,0,NULL,'a:0:{}'),(18,'TXc9PSYxMiNkNU1UWT0=','Nouveau agent',0,NULL,'a:0:{}'),(19,'TXc9PSYxMiNkNU5nPT0=',NULL,0,NULL,'a:0:{}'),(20,'TkE9PSYxMiNkNU1UUT0=',NULL,0,NULL,'a:0:{}'),(21,'TWc9PSYxMiNkNU1UZz0=',NULL,0,NULL,'a:0:{}'),(22,'TVE9PSYxMiNkNU1qQT0=','Nouveau coach ',0,NULL,'a:0:{}'),(23,'TVE9PSYxMiNkNU1UZz0=','Agent créé secu',0,NULL,'a:0:{}'),(24,'TVE9PSYxMiNkNU1Uaz0=','Agent multi 2 nouveau',0,NULL,'a:0:{}'),(25,'TWc9PSYxMiNkNU1qRT0=','agent abonnement',0,NULL,'a:0:{}'),(26,'TWc9PSYxMiNkNU1Uaz0=',NULL,0,NULL,'a:0:{}'),(27,'TVE9PSYxMiNkNU1qRT0=','agent abonnement',0,NULL,'a:0:{}'),(28,'TkE9PSYxMiNkNU1Uaz0=',NULL,0,NULL,'a:0:{}'),(29,'TVE9PSYxMiNkNU1qST0=',NULL,0,NULL,'a:0:{}'),(30,'TVE9PSYxMiNkNU1qTT0=','Assurance Coach',0,NULL,'a:0:{}'),(31,'TVRVPSYxMiNkNU1qTT0=','Nouveau agent securite',0,'2022-09-02 06:56:55','a:2:{i:0;i:23;i:1;i:15;}'),(32,'TVRRPSYxMiNkNU1qTT0=',NULL,0,NULL,'a:1:{i:0;i:23;}'),(33,'TVE9PSYxMiNkNU1qUT0=',NULL,0,NULL,'a:0:{}'),(34,'TVRVPSYxMiNkNU1qUT0=','Nouveau agent securite',0,NULL,'a:0:{}'),(35,'TVRRPSYxMiNkNU1qUT0=',NULL,0,NULL,'a:0:{}'),(36,'TWpNPSYxMiNkNU1qVT0=',NULL,0,'2022-09-07 10:57:55','a:1:{i:0;i:25;}');
/*!40000 ALTER TABLE `canal_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `canal_message_user`
--

DROP TABLE IF EXISTS `canal_message_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `canal_message_user` (
  `canal_message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`canal_message_id`,`user_id`),
  KEY `IDX_AB12D4AAE53A466D` (`canal_message_id`),
  KEY `IDX_AB12D4AAA76ED395` (`user_id`),
  CONSTRAINT `FK_AB12D4AAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_AB12D4AAE53A466D` FOREIGN KEY (`canal_message_id`) REFERENCES `canal_message` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `canal_message_user`
--

LOCK TABLES `canal_message_user` WRITE;
/*!40000 ALTER TABLE `canal_message_user` DISABLE KEYS */;
INSERT INTO `canal_message_user` VALUES (1,1),(1,2),(2,1),(2,3),(3,1),(3,4),(4,4),(4,7),(5,2),(5,5),(6,1),(6,5),(7,1),(7,6),(8,1),(8,7),(9,1),(9,11),(10,11),(10,12),(11,1),(11,12),(12,1),(12,13),(13,1),(13,14),(14,1),(14,15),(15,1),(15,16),(16,2),(16,16),(17,2),(17,13),(18,3),(18,16),(19,3),(19,6),(20,4),(20,14),(21,2),(21,18),(22,1),(22,20),(23,1),(23,18),(24,1),(24,19),(25,2),(25,21),(26,2),(26,19),(27,1),(27,21),(28,4),(28,19),(29,1),(29,22),(30,1),(30,23),(31,15),(31,23),(32,14),(32,23),(33,1),(33,24),(34,15),(34,24),(35,14),(35,24),(36,23),(36,25);
/*!40000 ALTER TABLE `canal_message_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secteur_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_497DD6349F7E4405` (`secteur_id`),
  CONSTRAINT `FK_497DD6349F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie`
--

LOCK TABLES `categorie` WRITE;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` VALUES (1,7,'Huiles Essentielles Pure',NULL,1),(2,7,'Gamme & Sens',NULL,1);
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorie_dd`
--

DROP TABLE IF EXISTS `categorie_dd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorie_dd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secteur_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_95B99609F7E4405` (`secteur_id`),
  CONSTRAINT `FK_95B99609F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie_dd`
--

LOCK TABLES `categorie_dd` WRITE;
/*!40000 ALTER TABLE `categorie_dd` DISABLE KEYS */;
INSERT INTO `categorie_dd` VALUES (1,2,'Site internet','Bien plus qu’une simple plateforme digitale, un site internet reflète votre image, vos valeurs et votre identité. Pixelsior vous aide à concevoir le site internet qui vous ressemble !',1),(2,2,'Imprimables (Print)','Même si nous entrons dans l’air du digital, rien ne peut encore remplacer le bon vieux support papier ! Pixelsior conçoit toutes sortes d’imprimables pour réussir votre communication. Du classique carte de visite aux Roll-ups, en passant par les menus : notre agence se charge de tout !',1),(3,2,'Création graphique',NULL,1),(4,2,'Call center',NULL,1),(5,2,'Médias sociaux','Difficile de survivre dans le milieu du digital sans une présence renforcée sur les réseaux sociaux. En ce sens, Pixelsior prend en main la gestion de vos communautés et les soigne aux petits oignons. Choisissez la formule qui vous convient selon vos besoins et vos moyens !',1),(6,2,'Application mobile','Pratiques et faciles à utiliser, les applications mobiles permettent de communiquer plus efficacement avec les clients. Pixelsior prend soin de concevoir une application sur-mesure, fidèle à vos valeurs et votre identité visuelle. Vos clients risquent de l’adorer !',1),(7,2,'Tunnel marketing','Pixelsior vous accompagne dans la création de votre tunnel marketing. Grâce à cet entonnoir de vente sur-mesure, vous convertirez aisément les visiteurs de votre site internet en prospects, puis en clients fidèles.',1),(8,2,'Vidéos','S’il y a une chose que youtube nous a appris, c’est que le public raffole de vidéos. A la fois ludiques et hautement informatifs, ils laissent les internautes rarement indifférents. Notre boîte à pixels renferme tout ce qu’il faut pour créer de sublimes vidéos qui reflètent parfaitement votre vision, vos ambitions … et bien entendu votre message !',1);
/*!40000 ALTER TABLE `categorie_dd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorie_formation`
--

DROP TABLE IF EXISTS `categorie_formation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorie_formation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordre_cat_formation` int(11) DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie_formation`
--

LOCK TABLES `categorie_formation` WRITE;
/*!40000 ALTER TABLE `categorie_formation` DISABLE KEYS */;
INSERT INTO `categorie_formation` VALUES (1,'Bienvenue sur pixelforce','<p>Bienvenue aux nouveaux adh&eacute;rents de pixelforce. Vous trouverez ici les introductions pour votre formation.</p>',1,1),(2,'Les outils pixelforce','<p>Decouvrez les outils propos&eacute;s par pixelforce pour g&eacute;n&eacute;rer plus de revenu.</p>',2,1),(3,'Faites votre prospection','<p>Ces formations vont vous apprendre &agrave; etablir votre liste de contact, faire votre rendez-vous et r&eacute;aliser votre premi&egrave;re vente.</p>',3,1);
/*!40000 ALTER TABLE `categorie_formation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorie_formation_agent`
--

DROP TABLE IF EXISTS `categorie_formation_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorie_formation_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `categorie_formation_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8D9B74463414710B` (`agent_id`),
  KEY `IDX_8D9B74462B036EAC` (`categorie_formation_id`),
  CONSTRAINT `FK_8D9B74462B036EAC` FOREIGN KEY (`categorie_formation_id`) REFERENCES `categorie_formation` (`id`),
  CONSTRAINT `FK_8D9B74463414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie_formation_agent`
--

LOCK TABLES `categorie_formation_agent` WRITE;
/*!40000 ALTER TABLE `categorie_formation_agent` DISABLE KEYS */;
INSERT INTO `categorie_formation_agent` VALUES (1,22,1),(2,22,2);
/*!40000 ALTER TABLE `categorie_formation_agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorie_secu`
--

DROP TABLE IF EXISTS `categorie_secu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorie_secu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secteur_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F44E3259F7E4405` (`secteur_id`),
  CONSTRAINT `FK_F44E3259F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie_secu`
--

LOCK TABLES `categorie_secu` WRITE;
/*!40000 ALTER TABLE `categorie_secu` DISABLE KEYS */;
INSERT INTO `categorie_secu` VALUES (1,1,'Unités centrales',NULL,1),(2,1,'Prolongateur de portée',NULL,1),(3,1,'Unité d’alimentation',NULL,1),(4,1,'Protection intrusion intérieure',NULL,1),(5,1,'Protection intrusion extérieure',NULL,1),(6,1,'Commandes',NULL,1),(7,1,'Prévention des incendies & des inondations',NULL,1),(8,1,'Sirènes',NULL,1),(9,1,'Domotique',NULL,1),(10,1,'Application',NULL,1);
/*!40000 ALTER TABLE `categorie_secu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `client_secteur_agent`
--

DROP TABLE IF EXISTS `client_secteur_agent`;
/*!50001 DROP VIEW IF EXISTS `client_secteur_agent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `client_secteur_agent` AS SELECT 
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `client_id`,
 1 AS `montant`,
 1 AS `nbr`,
 1 AS `nom`,
 1 AS `prenom`,
 1 AS `email`,
 1 AS `username`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `coach_agent`
--

DROP TABLE IF EXISTS `coach_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coach_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3209FFB73C105691` (`coach_id`),
  KEY `IDX_3209FFB73414710B` (`agent_id`),
  CONSTRAINT `FK_3209FFB73414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_3209FFB73C105691` FOREIGN KEY (`coach_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coach_agent`
--

LOCK TABLES `coach_agent` WRITE;
/*!40000 ALTER TABLE `coach_agent` DISABLE KEYS */;
INSERT INTO `coach_agent` VALUES (1,11,12),(2,2,18);
/*!40000 ALTER TABLE `coach_agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coach_secteur`
--

DROP TABLE IF EXISTS `coach_secteur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coach_secteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) DEFAULT NULL,
  `secteur_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3B95CD573C105691` (`coach_id`),
  KEY `IDX_3B95CD579F7E4405` (`secteur_id`),
  CONSTRAINT `FK_3B95CD573C105691` FOREIGN KEY (`coach_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_3B95CD579F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coach_secteur`
--

LOCK TABLES `coach_secteur` WRITE;
/*!40000 ALTER TABLE `coach_secteur` DISABLE KEYS */;
INSERT INTO `coach_secteur` VALUES (1,NULL,1),(2,NULL,2),(3,2,1),(5,4,7),(6,11,4),(8,3,2),(9,20,6),(10,23,3),(11,24,3);
/*!40000 ALTER TABLE `coach_secteur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `code_promo_secu`
--

DROP TABLE IF EXISTS `code_promo_secu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `code_promo_secu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prix` double NOT NULL,
  `statut` int(11) NOT NULL,
  `secteur_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1A5A3A929F7E4405` (`secteur_id`),
  CONSTRAINT `FK_1A5A3A929F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `code_promo_secu`
--

LOCK TABLES `code_promo_secu` WRITE;
/*!40000 ALTER TABLE `code_promo_secu` DISABLE KEYS */;
INSERT INTO `code_promo_secu` VALUES (1,'CODE1',NULL,499,1,1),(2,'CODE2',NULL,299,1,1);
/*!40000 ALTER TABLE `code_promo_secu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `tree_root` int(11) DEFAULT NULL,
  `video_formation_id` int(11) DEFAULT NULL,
  `textes` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `lvl` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_67F068BCA76ED395` (`user_id`),
  KEY `IDX_67F068BC3D8E604F` (`parent`),
  KEY `IDX_67F068BCA977936C` (`tree_root`),
  KEY `IDX_67F068BCF3F339E1` (`video_formation_id`),
  CONSTRAINT `FK_67F068BC3D8E604F` FOREIGN KEY (`parent`) REFERENCES `commentaire` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_67F068BCA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_67F068BCA977936C` FOREIGN KEY (`tree_root`) REFERENCES `commentaire` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_67F068BCF3F339E1` FOREIGN KEY (`video_formation_id`) REFERENCES `video_formation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commentaire`
--

LOCK TABLES `commentaire` WRITE;
/*!40000 ALTER TABLE `commentaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `commentaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `information_id` int(11) DEFAULT NULL,
  `secteur_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4C62E6382EF03101` (`information_id`),
  KEY `IDX_4C62E6383414710B` (`agent_id`),
  KEY `IDX_4C62E6389F7E4405` (`secteur_id`),
  CONSTRAINT `FK_4C62E6382EF03101` FOREIGN KEY (`information_id`) REFERENCES `contact_information` (`id`),
  CONSTRAINT `FK_4C62E6383414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_4C62E6389F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES (1,5,1,1,0,'2022-08-03 07:39:10',''),(2,6,2,2,0,'2022-08-16 11:51:43',''),(16,22,16,6,0,'2022-08-16 11:51:56',''),(17,22,17,6,0,'2022-08-16 11:51:57',''),(18,22,18,6,0,'2022-08-16 11:51:58',''),(19,22,19,6,0,'2022-08-16 11:51:59',''),(20,22,20,6,0,'2022-08-16 11:51:43',''),(21,22,21,6,0,'2022-08-16 11:51:43',''),(22,22,22,6,0,'2022-08-16 11:51:43',''),(23,22,23,6,0,'2022-08-16 11:51:43',''),(24,22,24,6,0,'2022-08-16 11:51:43',''),(25,22,25,6,0,'2022-08-16 11:51:43',''),(26,22,26,6,0,'2022-08-16 11:51:43',''),(27,22,27,6,0,'2022-08-16 11:51:43',''),(28,22,28,6,0,'2022-08-16 11:51:43',''),(29,22,29,6,0,'2022-08-16 11:51:43',''),(30,22,30,6,0,'2022-08-16 11:51:43',''),(31,22,31,6,0,'2022-08-16 11:51:43',''),(32,22,32,6,0,'2022-08-16 11:51:43',''),(33,22,33,6,0,'2022-08-16 11:51:43',''),(34,22,34,6,0,'2022-08-16 11:51:43',''),(35,22,35,6,0,'2022-08-16 11:51:43',''),(36,22,36,6,0,'2022-08-16 11:51:43',''),(37,22,37,6,0,'2022-08-16 11:51:43',''),(38,22,38,6,0,'2022-08-16 11:51:43',''),(39,22,39,6,0,'2022-08-16 11:51:43',''),(40,22,40,6,0,'2022-08-16 11:51:43',''),(41,22,41,6,0,'2022-08-16 11:51:43',''),(42,22,42,6,0,'2022-08-16 11:51:43',''),(43,22,43,6,0,'2022-08-16 11:51:43',''),(44,22,44,6,0,'2022-08-16 11:51:43',''),(45,22,45,6,0,'2022-08-16 11:51:43',''),(46,22,46,6,0,'2022-08-16 11:51:43',''),(47,22,47,6,0,'2022-08-16 11:51:43',''),(48,22,48,6,0,'2022-08-16 11:51:43',''),(49,22,49,6,0,'2022-08-16 11:51:43',''),(50,22,50,6,0,'2022-08-16 11:51:43',''),(51,22,51,6,0,'2022-08-16 11:51:43',''),(52,22,52,6,0,'2022-08-16 11:51:43',''),(53,22,53,6,0,'2022-08-16 11:51:43',''),(54,22,54,6,0,'2022-08-16 11:51:43',''),(55,22,55,6,0,'2022-08-16 11:51:43',''),(56,22,56,6,0,'2022-08-16 11:51:43',''),(57,22,57,6,0,'2022-08-16 11:51:43',''),(58,22,58,6,0,'2022-08-16 11:51:43',''),(59,22,59,6,0,'2022-08-16 11:51:43',''),(60,22,60,6,0,'2022-08-16 11:51:43',''),(61,22,61,6,0,'2022-08-16 11:51:43',''),(62,22,62,6,0,'2022-08-16 11:51:43',''),(63,22,63,6,0,'2022-08-16 11:51:43',''),(64,22,64,6,0,'2022-08-16 11:51:43',''),(65,22,65,6,0,'2022-08-16 11:51:43',''),(66,22,66,6,0,'2022-08-16 11:51:43',''),(67,22,67,6,0,'2022-08-16 11:51:43',''),(68,22,68,6,0,'2022-08-16 11:51:43',''),(69,22,69,6,0,'2022-08-16 11:51:43',''),(70,22,70,6,0,'2022-08-16 11:51:43',''),(71,22,71,6,0,'2022-08-16 11:51:43',''),(72,22,72,6,0,'2022-08-16 11:51:43',''),(73,22,73,6,0,'2022-08-16 11:51:43',''),(74,22,74,6,0,'2022-08-16 11:51:43',''),(75,22,75,6,0,'2022-08-16 11:51:43',''),(76,22,76,6,0,'2022-08-16 11:51:43',''),(77,22,77,6,0,'2022-08-16 11:51:43',''),(78,22,78,6,0,'2022-08-16 11:51:43',''),(79,22,79,6,0,'2022-08-16 11:51:43',''),(80,22,80,6,0,'2022-08-16 11:51:43',''),(81,22,81,6,0,'2022-08-16 11:51:43',''),(82,22,82,6,0,'2022-08-16 11:51:43',''),(83,22,83,6,0,'2022-08-16 11:51:43',''),(84,22,84,6,0,'2022-08-16 11:51:43',''),(85,22,85,6,0,'2022-08-16 11:51:43',''),(86,22,86,6,0,'2022-08-16 11:51:43',''),(87,22,87,6,0,'2022-08-16 11:51:43',''),(88,22,88,6,0,'2022-08-16 11:51:43',''),(89,22,89,6,0,'2022-08-16 11:51:43',''),(90,22,90,6,0,'2022-08-16 11:51:43',''),(91,22,91,6,0,'2022-08-16 11:51:43',''),(92,22,92,6,0,'2022-08-16 11:51:43',''),(93,22,93,6,0,'2022-08-16 11:51:43',''),(94,22,94,6,0,'2022-08-16 11:51:43',''),(95,22,95,6,0,'2022-08-16 11:51:43',''),(96,22,96,6,0,'2022-08-16 11:51:43',''),(97,22,97,6,0,'2022-08-16 11:51:43',''),(98,22,98,6,0,'2022-08-16 11:51:43',''),(99,22,99,6,0,'2022-08-16 11:51:43',''),(100,22,100,6,0,'2022-08-16 11:51:43',''),(101,22,101,6,0,'2022-08-16 11:51:43',''),(102,22,102,6,0,'2022-08-16 11:51:43',''),(103,22,103,6,0,'2022-08-16 11:51:43',''),(104,22,104,6,0,'2022-08-16 11:51:43',''),(105,22,105,6,0,'2022-08-16 11:51:43',''),(106,15,106,3,0,'2022-09-02 07:06:27',''),(107,5,107,1,NULL,'2022-09-13 09:03:07',NULL);
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_information`
--

DROP TABLE IF EXISTS `contact_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_logement_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_postal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `composition_foyer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nbr_personne` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_47D5A73D13B22EC4` (`type_logement_id`),
  CONSTRAINT `FK_47D5A73D13B22EC4` FOREIGN KEY (`type_logement_id`) REFERENCES `type_logement` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_information`
--

LOCK TABLES `contact_information` WRITE;
/*!40000 ALTER TABLE `contact_information` DISABLE KEYS */;
INSERT INTO `contact_information` VALUES (1,NULL,'Paul','Jean','jeanpaul@gmail.com','+261342333312','Tana',NULL,NULL,'00101','Antananarivo',NULL,NULL),(2,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','0349331431','Antananarivo',NULL,NULL,'00101','Antananarivo',NULL,NULL),(3,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','0349331431','Antananarivo',NULL,NULL,'00101','Antananarivo',NULL,NULL),(4,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331431','Antananarivo',NULL,NULL,'101','Antananarivo',NULL,NULL),(5,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331431','Antananarivo',NULL,NULL,'101','Antananarivo',NULL,NULL),(6,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331432','Antananarivo',NULL,NULL,'102','Antananarivo',NULL,NULL),(7,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331433','Antananarivo',NULL,NULL,'103','Antananarivo',NULL,NULL),(8,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331434','Antananarivo',NULL,NULL,'104','Antananarivo',NULL,NULL),(9,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331435','Antananarivo',NULL,NULL,'105','Antananarivo',NULL,NULL),(10,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331436','Antananarivo',NULL,NULL,'106','Antananarivo',NULL,NULL),(11,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331437','Antananarivo',NULL,NULL,'107','Antananarivo',NULL,NULL),(12,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331438','Antananarivo',NULL,NULL,'108','Antananarivo',NULL,NULL),(13,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331439','Antananarivo',NULL,NULL,'109','Antananarivo',NULL,NULL),(14,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331440','Antananarivo',NULL,NULL,'110','Antananarivo',NULL,NULL),(15,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331441','Antananarivo',NULL,NULL,'111','Antananarivo',NULL,NULL),(16,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331442','Antananarivo',NULL,NULL,'112','Antananarivo',NULL,NULL),(17,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331443','Antananarivo',NULL,NULL,'113','Antananarivo',NULL,NULL),(18,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331444','Antananarivo',NULL,NULL,'114','Antananarivo',NULL,NULL),(19,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331445','Antananarivo',NULL,NULL,'115','Antananarivo',NULL,NULL),(20,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331446','Antananarivo',NULL,NULL,'116','Antananarivo',NULL,NULL),(21,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331447','Antananarivo',NULL,NULL,'117','Antananarivo',NULL,NULL),(22,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331448','Antananarivo',NULL,NULL,'118','Antananarivo',NULL,NULL),(23,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331449','Antananarivo',NULL,NULL,'119','Antananarivo',NULL,NULL),(24,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331450','Antananarivo',NULL,NULL,'120','Antananarivo',NULL,NULL),(25,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331451','Antananarivo',NULL,NULL,'121','Antananarivo',NULL,NULL),(26,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331452','Antananarivo',NULL,NULL,'122','Antananarivo',NULL,NULL),(27,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331453','Antananarivo',NULL,NULL,'123','Antananarivo',NULL,NULL),(28,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331454','Antananarivo',NULL,NULL,'124','Antananarivo',NULL,NULL),(29,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331455','Antananarivo',NULL,NULL,'125','Antananarivo',NULL,NULL),(30,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331456','Antananarivo',NULL,NULL,'126','Antananarivo',NULL,NULL),(31,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331457','Antananarivo',NULL,NULL,'127','Antananarivo',NULL,NULL),(32,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331458','Antananarivo',NULL,NULL,'128','Antananarivo',NULL,NULL),(33,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331459','Antananarivo',NULL,NULL,'129','Antananarivo',NULL,NULL),(34,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331460','Antananarivo',NULL,NULL,'130','Antananarivo',NULL,NULL),(35,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331461','Antananarivo',NULL,NULL,'131','Antananarivo',NULL,NULL),(36,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331462','Antananarivo',NULL,NULL,'132','Antananarivo',NULL,NULL),(37,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331463','Antananarivo',NULL,NULL,'133','Antananarivo',NULL,NULL),(38,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331464','Antananarivo',NULL,NULL,'134','Antananarivo',NULL,NULL),(39,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331465','Antananarivo',NULL,NULL,'135','Antananarivo',NULL,NULL),(40,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331466','Antananarivo',NULL,NULL,'136','Antananarivo',NULL,NULL),(41,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331467','Antananarivo',NULL,NULL,'137','Antananarivo',NULL,NULL),(42,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331468','Antananarivo',NULL,NULL,'138','Antananarivo',NULL,NULL),(43,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331469','Antananarivo',NULL,NULL,'139','Antananarivo',NULL,NULL),(44,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331470','Antananarivo',NULL,NULL,'140','Antananarivo',NULL,NULL),(45,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331471','Antananarivo',NULL,NULL,'141','Antananarivo',NULL,NULL),(46,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331472','Antananarivo',NULL,NULL,'142','Antananarivo',NULL,NULL),(47,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331473','Antananarivo',NULL,NULL,'143','Antananarivo',NULL,NULL),(48,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331474','Antananarivo',NULL,NULL,'144','Antananarivo',NULL,NULL),(49,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331475','Antananarivo',NULL,NULL,'145','Antananarivo',NULL,NULL),(50,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331476','Antananarivo',NULL,NULL,'146','Antananarivo',NULL,NULL),(51,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331477','Antananarivo',NULL,NULL,'147','Antananarivo',NULL,NULL),(52,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331478','Antananarivo',NULL,NULL,'148','Antananarivo',NULL,NULL),(53,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331479','Antananarivo',NULL,NULL,'149','Antananarivo',NULL,NULL),(54,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331480','Antananarivo',NULL,NULL,'150','Antananarivo',NULL,NULL),(55,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331481','Antananarivo',NULL,NULL,'151','Antananarivo',NULL,NULL),(56,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331482','Antananarivo',NULL,NULL,'152','Antananarivo',NULL,NULL),(57,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331483','Antananarivo',NULL,NULL,'153','Antananarivo',NULL,NULL),(58,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331484','Antananarivo',NULL,NULL,'154','Antananarivo',NULL,NULL),(59,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331485','Antananarivo',NULL,NULL,'155','Antananarivo',NULL,NULL),(60,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331486','Antananarivo',NULL,NULL,'156','Antananarivo',NULL,NULL),(61,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331487','Antananarivo',NULL,NULL,'157','Antananarivo',NULL,NULL),(62,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331488','Antananarivo',NULL,NULL,'158','Antananarivo',NULL,NULL),(63,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331489','Antananarivo',NULL,NULL,'159','Antananarivo',NULL,NULL),(64,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331490','Antananarivo',NULL,NULL,'160','Antananarivo',NULL,NULL),(65,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331491','Antananarivo',NULL,NULL,'161','Antananarivo',NULL,NULL),(66,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331492','Antananarivo',NULL,NULL,'162','Antananarivo',NULL,NULL),(67,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331493','Antananarivo',NULL,NULL,'163','Antananarivo',NULL,NULL),(68,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331494','Antananarivo',NULL,NULL,'164','Antananarivo',NULL,NULL),(69,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331495','Antananarivo',NULL,NULL,'165','Antananarivo',NULL,NULL),(70,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331496','Antananarivo',NULL,NULL,'166','Antananarivo',NULL,NULL),(71,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331497','Antananarivo',NULL,NULL,'167','Antananarivo',NULL,NULL),(72,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331498','Antananarivo',NULL,NULL,'168','Antananarivo',NULL,NULL),(73,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331499','Antananarivo',NULL,NULL,'169','Antananarivo',NULL,NULL),(74,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331500','Antananarivo',NULL,NULL,'170','Antananarivo',NULL,NULL),(75,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331501','Antananarivo',NULL,NULL,'171','Antananarivo',NULL,NULL),(76,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331502','Antananarivo',NULL,NULL,'172','Antananarivo',NULL,NULL),(77,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331503','Antananarivo',NULL,NULL,'173','Antananarivo',NULL,NULL),(78,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331504','Antananarivo',NULL,NULL,'174','Antananarivo',NULL,NULL),(79,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331505','Antananarivo',NULL,NULL,'175','Antananarivo',NULL,NULL),(80,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331506','Antananarivo',NULL,NULL,'176','Antananarivo',NULL,NULL),(81,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331507','Antananarivo',NULL,NULL,'177','Antananarivo',NULL,NULL),(82,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331508','Antananarivo',NULL,NULL,'178','Antananarivo',NULL,NULL),(83,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331509','Antananarivo',NULL,NULL,'179','Antananarivo',NULL,NULL),(84,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331510','Antananarivo',NULL,NULL,'180','Antananarivo',NULL,NULL),(85,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331511','Antananarivo',NULL,NULL,'181','Antananarivo',NULL,NULL),(86,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331512','Antananarivo',NULL,NULL,'182','Antananarivo',NULL,NULL),(87,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331513','Antananarivo',NULL,NULL,'183','Antananarivo',NULL,NULL),(88,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331514','Antananarivo',NULL,NULL,'184','Antananarivo',NULL,NULL),(89,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331515','Antananarivo',NULL,NULL,'185','Antananarivo',NULL,NULL),(90,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331516','Antananarivo',NULL,NULL,'186','Antananarivo',NULL,NULL),(91,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331517','Antananarivo',NULL,NULL,'187','Antananarivo',NULL,NULL),(92,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331518','Antananarivo',NULL,NULL,'188','Antananarivo',NULL,NULL),(93,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331519','Antananarivo',NULL,NULL,'189','Antananarivo',NULL,NULL),(94,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331520','Antananarivo',NULL,NULL,'190','Antananarivo',NULL,NULL),(95,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331521','Antananarivo',NULL,NULL,'191','Antananarivo',NULL,NULL),(96,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331522','Antananarivo',NULL,NULL,'192','Antananarivo',NULL,NULL),(97,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331523','Antananarivo',NULL,NULL,'193','Antananarivo',NULL,NULL),(98,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331524','Antananarivo',NULL,NULL,'194','Antananarivo',NULL,NULL),(99,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331525','Antananarivo',NULL,NULL,'195','Antananarivo',NULL,NULL),(100,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331526','Antananarivo',NULL,NULL,'196','Antananarivo',NULL,NULL),(101,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331527','Antananarivo',NULL,NULL,'197','Antananarivo',NULL,NULL),(102,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331528','Antananarivo',NULL,NULL,'198','Antananarivo',NULL,NULL),(103,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331529','Antananarivo',NULL,NULL,'199','Antananarivo',NULL,NULL),(104,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331530','Antananarivo',NULL,NULL,'200','Antananarivo',NULL,NULL),(105,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','349331531','Antananarivo',NULL,NULL,'201','Antananarivo',NULL,NULL),(106,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja@gmail.com','0349331431','Antananarivo',NULL,NULL,'00101','Antananarivo',NULL,NULL),(107,NULL,'Hasitiana','Madapix',NULL,'+261 32 02 012 90',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `contact_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrat_secu`
--

DROP TABLE IF EXISTS `contrat_secu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrat_secu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secteur_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fichier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3539C16C9F7E4405` (`secteur_id`),
  CONSTRAINT `FK_3539C16C9F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrat_secu`
--

LOCK TABLES `contrat_secu` WRITE;
/*!40000 ALTER TABLE `contrat_secu` DISABLE KEYS */;
INSERT INTO `contrat_secu` VALUES (1,1,'Contrat Home','secu/contrat/Contrat-Home.pdf');
/*!40000 ALTER TABLE `contrat_secu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demande_devis`
--

DROP TABLE IF EXISTS `demande_devis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demande_devis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `secteur_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(600) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` int(11) NOT NULL,
  `date_demande` datetime NOT NULL,
  `files` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '(DC2Type:json)',
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7DF9460219EB6921` (`client_id`),
  KEY `IDX_7DF946023414710B` (`agent_id`),
  KEY `IDX_7DF946029F7E4405` (`secteur_id`),
  KEY `IDX_7DF94602F347EFB` (`produit_id`),
  CONSTRAINT `FK_7DF9460219EB6921` FOREIGN KEY (`client_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_7DF946023414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_7DF946029F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`),
  CONSTRAINT `FK_7DF94602F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit_dd` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demande_devis`
--

LOCK TABLES `demande_devis` WRITE;
/*!40000 ALTER TABLE `demande_devis` DISABLE KEYS */;
INSERT INTO `demande_devis` VALUES (1,17,6,2,1,'Client','Digital','0343444434','mnakanyandriamihaja@gmail.com','<p>J&#39;aimerais avoir un devis par rapport &agrave; mon projet.</p>',1,'2022-08-22 13:29:11','[\"dd\\/2022-08-22-13-29-11\\/ajax-alarme-badge-ouverture-tag-blanc (1).jpeg\",\"dd\\/2022-08-22-13-29-11\\/contrat (2).pdf\",\"dd\\/2022-08-22-13-29-11\\/contrat-4.pdf\"]',NULL),(2,17,6,2,1,'Client','Digital','0343444434','mnakanyandriamihaja@gmail.com','<p>Description du projet</p>',1,'2022-08-23 12:53:42','[\"dd\\/2022-08-23-12-53-42\\/contrat (1).pdf\",\"dd\\/2022-08-23-12-53-42\\/contrat-4.pdf\"]',NULL),(3,17,6,2,1,'Client','Digital','0343444434','mnakanyandriamihaja@gmail.com','<p>Mon projet</p>',1,'2022-08-30 08:56:32','[]',NULL),(4,17,6,2,31,'Client','Digital','0343444434','mnakanyandriamihaja@gmail.com','<p>Application</p>',1,'2022-08-30 08:57:04','[]',NULL),(5,17,6,2,5,'Client','Digital','0343444434','mnakanyandriamihaja@gmail.com','<p>Demande devis Set paper</p>',1,'2022-08-30 11:14:47','[\"dd\\/2022-08-30-11-14-47\\/contrat-1.pdf\"]',NULL),(6,17,6,2,4,'Client','Digital','0343444434','mnakanyandriamihaja@gmail.com','<p>Devis</p>',1,'2022-08-30 11:56:25','[]',NULL),(7,17,6,2,2,'Client','Digital','0343444434','mnakanyandriamihaja@gmail.com','<p>Description de mon projet</p>',1,'2022-09-02 07:35:44','[]',NULL),(8,17,6,2,4,'Client','Digital','0343444434','mnakanyandriamihaja@gmail.com','<p><strong>LA CARTE DE VISITE AU FORMAT CLASSIQUE, C&rsquo;EST LA BONNE IMPRESSION ASSUR&Eacute;E</strong></p>',1,'2022-09-02 08:15:24','[]',NULL);
/*!40000 ALTER TABLE `demande_devis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `demande_devis_valide`
--

DROP TABLE IF EXISTS `demande_devis_valide`;
/*!50001 DROP VIEW IF EXISTS `demande_devis_valide`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `demande_devis_valide` AS SELECT 
 1 AS `id`,
 1 AS `client_id`,
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `produit_id`,
 1 AS `nom`,
 1 AS `prenom`,
 1 AS `telephone`,
 1 AS `email`,
 1 AS `description`,
 1 AS `statut`,
 1 AS `date_demande`,
 1 AS `files`,
 1 AS `whatsapp`,
 1 AS `price`,
 1 AS `devis_id`,
 1 AS `contrat_file_name`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `dernier_date_inventaire`
--

DROP TABLE IF EXISTS `dernier_date_inventaire`;
/*!50001 DROP VIEW IF EXISTS `dernier_date_inventaire`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `dernier_date_inventaire` AS SELECT 
 1 AS `produit_id`,
 1 AS `dernier_date`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `dernier_inventaire`
--

DROP TABLE IF EXISTS `dernier_inventaire`;
/*!50001 DROP VIEW IF EXISTS `dernier_inventaire`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `dernier_inventaire` AS SELECT 
 1 AS `id`,
 1 AS `mere_id`,
 1 AS `produit_id`,
 1 AS `qte`,
 1 AS `statut`,
 1 AS `date_inventaire`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `devis`
--

DROP TABLE IF EXISTS `devis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `demande_devis_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double NOT NULL,
  `files` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '(DC2Type:json)',
  `created_at` datetime NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contrat_file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_int` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8B27C52B787B318` (`demande_devis_id`),
  CONSTRAINT `FK_8B27C52B787B318` FOREIGN KEY (`demande_devis_id`) REFERENCES `demande_devis` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devis`
--

LOCK TABLES `devis` WRITE;
/*!40000 ALTER TABLE `devis` DISABLE KEYS */;
INSERT INTO `devis` VALUES (1,5,'Devis set paper','<p>Devis set paperDevis set paperDevis set paperDevis set paper</p>',454,'[\"devis\\/digital\\/2022-08-30-11-23-54\\/Z170-A_DRAM_QVL_20160316.pdf\"]','2022-08-30 11:23:53','Rejeté',NULL,NULL),(2,5,'Devis set paper 02','<p>Devis set paper 02Devis set paper 02Devis set paper 02</p>',789,'[]','2022-08-30 11:25:29','Créé',NULL,NULL),(3,6,'Devis','<p>Devis</p>',4000,'[]','2022-08-30 12:00:11','Créé',NULL,NULL),(4,8,'LA CARTE DE VISITE AU FORMAT CLASSIQUE, C’EST LA BONNE IMPRESSION ASSURÉE','<h2>&nbsp;</h2>\r\n\r\n<p><strong>LA CARTE DE VISITE AU FORMAT CLASSIQUE, C&rsquo;EST LA BONNE IMPRESSION ASSUR&Eacute;E</strong></p>\r\n\r\n<p>Avec notre tr&egrave;s large gamme de carte de visite, vous aurez tout le loisir de red&eacute;couvrir ce grand classique de la communication dans tous ses &eacute;tats. Sur des supports papiers vari&eacute;s comme les papiers cr&eacute;ation, textur&eacute; ou &eacute;cologique, avec des finitions uniques telles que la dorure &agrave; chaud, le vernis, le sans impression, la d&eacute;coupe laser que ou dans des formats plus extravagants comme la carte adh&eacute;sive ou le QR contact, vous avez encore beaucoup &agrave; apprendre sur la carte de visite.</p>',50,'[]','2022-09-02 08:26:06','Payé','digital/contrat/17_2022-09-02-08-42-48.pdf',1);
/*!40000 ALTER TABLE `devis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20220720053408','2022-07-20 06:04:53',113),('DoctrineMigrations\\Version20220720061646','2022-07-20 06:17:07',80),('DoctrineMigrations\\Version20220728060520','2022-08-01 08:28:59',63),('DoctrineMigrations\\Version20220802055010','2022-08-02 05:51:26',604),('DoctrineMigrations\\Version20220802103516','2022-08-02 10:35:50',159),('DoctrineMigrations\\Version20220803070813','2022-08-03 07:08:50',105),('DoctrineMigrations\\Version20220803184402','2022-08-03 18:44:54',293),('DoctrineMigrations\\Version20220809140028','2022-08-09 14:01:00',830),('DoctrineMigrations\\Version20220809142534','2022-08-09 14:26:02',148),('DoctrineMigrations\\Version20220810064136','2022-08-10 06:42:08',1005),('DoctrineMigrations\\Version20220810064527','2022-08-10 06:45:54',554),('DoctrineMigrations\\Version20220810064715','2022-08-10 06:48:12',139),('DoctrineMigrations\\Version20220810111319','2022-08-10 11:13:49',780),('DoctrineMigrations\\Version20220810123921','2022-08-10 12:39:43',160),('DoctrineMigrations\\Version20220810125115','2022-08-10 12:51:42',165),('DoctrineMigrations\\Version20220902080909','2022-09-02 08:10:35',298),('DoctrineMigrations\\Version20220905063804','2022-09-05 06:39:20',63);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` int(11) NOT NULL,
  `message` varchar(600) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `amount` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D8698A767E3C61F9` (`owner_id`),
  CONSTRAINT `FK_D8698A767E3C61F9` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

LOCK TABLES `document` WRITE;
/*!40000 ALTER TABLE `document` DISABLE KEYS */;
INSERT INTO `document` VALUES (1,8,'Contrat Home','docs/Contrat Home .pdf',1,'<p>Contrat &agrave; signer</p>','2022-08-02 06:18:10',13);
/*!40000 ALTER TABLE `document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_recipient`
--

DROP TABLE IF EXISTS `document_recipient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document_recipient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signed_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid` tinyint(1) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `date_send` datetime NOT NULL,
  `date_signed` datetime DEFAULT NULL,
  `conseiller` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7A3CD3E8C33F7837` (`document_id`),
  CONSTRAINT `FK_7A3CD3E8C33F7837` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_recipient`
--

LOCK TABLES `document_recipient` WRITE;
/*!40000 ALTER TABLE `document_recipient` DISABLE KEYS */;
INSERT INTO `document_recipient` VALUES (1,1,'Nakany Andriamihaja','Michel','contracts/356a192b7913b04c54574d18c28d46e6395428ab_1659421253.pdf','mnakanyandriamihaja@gmail.com',0,1,'2022-08-02 06:18:40',NULL,'Yanisse');
/*!40000 ALTER TABLE `document_recipient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formation`
--

DROP TABLE IF EXISTS `formation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) DEFAULT NULL,
  `secteur_id` int(11) DEFAULT NULL,
  `categorie_formation_id` int(11) DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_deblocage` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debloque_agent` tinyint(1) DEFAULT NULL,
  `brouillon` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_404021BF3C105691` (`coach_id`),
  KEY `IDX_404021BF9F7E4405` (`secteur_id`),
  KEY `IDX_404021BF2B036EAC` (`categorie_formation_id`),
  CONSTRAINT `FK_404021BF2B036EAC` FOREIGN KEY (`categorie_formation_id`) REFERENCES `categorie_formation` (`id`),
  CONSTRAINT `FK_404021BF3C105691` FOREIGN KEY (`coach_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_404021BF9F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formation`
--

LOCK TABLES `formation` WRITE;
/*!40000 ALTER TABLE `formation` DISABLE KEYS */;
INSERT INTO `formation` VALUES (1,2,1,1,'Bienvenue sur Pixelforce','Votre avenir commence ici\r\nApprenez à apprendre, découvrez les compétences de demain, et prenez votre carrière en main.\r\nDes formations innovantes\r\nDevenez qui vous voulez être avec OpenClassrooms. Choisissez votre carrière. Suivez une formation constituée de projets professionnalisants et de séances individuelles avec un mentor dédié chaque semaine. Obtenez un diplôme reconnu par l\'État. Enrichissez votre CV avec les programmes en alternance proposés par OpenClassrooms et gagnez un salaire tout en suivant votre formation.',NULL,'<h3>Tirez un maximum de ce cours</h3>\r\n\r\n<p>Ce cours est compos&eacute; de plusieurs contenus (vid&eacute;os, textes et images). Les vid&eacute;os mettent en sc&egrave;ne un coach agile (moi/vous) avec une &eacute;quipe de 4&nbsp;personnes en charge de la conception d&rsquo;une application mobile. Les textes et les images compl&egrave;tent celles-ci afin de vous pr&eacute;parer aux &eacute;valuations que vous trouverez en fin de chaque partie.</p>\r\n\r\n<p>Dans ce premier chapitre, vous allez apprendre pourquoi&nbsp;<strong>la constitution de l&#39;&eacute;quipe</strong>&nbsp;est une des &eacute;tapes les plus importantes de la vie d&#39;un projet.&nbsp;</p>\r\n\r\n<h3>Ne sous-estimez pas l&#39;importance du facteur humain</h3>\r\n\r\n<p>Un&nbsp;<strong>bon croquis</strong>&nbsp;vaut mieux qu&#39;un long discours&hellip;&nbsp;?&nbsp;&nbsp;</p>\r\n\r\n<p>Je vous propose une caricature qui illustre bien l&rsquo;importance du&nbsp;<strong>facteur humain</strong>&nbsp;dans toutes les familles de gestion de projet. Laissez-moi interpr&eacute;ter avec vous cet exemple fictif d&#39;un projet de balan&ccedil;oire. Dans cette vulgarisation, notez que la balan&ccedil;oire n&#39;est qu&#39;une image simplifi&eacute;e d&#39;un produit ou d&#39;un service quel qu&#39;il soit. La m&ecirc;me logique peut donc s&#39;appliquer &agrave; un projet de site Internet, d&#39;application mobile ou autre.&nbsp;</p>\r\n\r\n<p>En gestion de projet, les besoins initiaux de votre client et les interpr&eacute;tations qu&#39;en feront les membres de votre &eacute;quipe ne co&iuml;ncideront pas toujours... ce qui pose &eacute;videmment de&nbsp;<strong>nombreuses questions</strong>.</p>\r\n\r\n<p>Imaginez la situation suivante :</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p><strong>Le client</strong>&nbsp;souhaite une balan&ccedil;oire &ldquo;innovante&rdquo;. Il propose la conception ci-dessous. Avec ce produit, il veut se d&eacute;marquer de la concurrence&nbsp;; mais les utilisateurs de la balan&ccedil;oire seront-ils vraiment satisfaits par une superposition de trois planches&nbsp;? L&#39;&eacute;quipe parviendra-t-elle &agrave; traduire l&#39;id&eacute;e du client en balan&ccedil;oire fonctionnelle&nbsp;?</p>\r\n	</li>\r\n</ul>\r\n\r\n<p>Vision du besoin par le client</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p><strong>Le chef de projet</strong>, quant &agrave; lui, tend &agrave; rapprocher le besoin du client d&rsquo;un produit qu&#39;il conna&icirc;t et dont il ma&icirc;trise d&eacute;j&agrave; la conception. Deux cordes et une planche forment une balan&ccedil;oire standard&nbsp;! Cette solution sera-t-elle assez &ldquo;innovante&rdquo;, et donc satisfaisante pour le client&nbsp;?</p>\r\n	</li>\r\n</ul>\r\n\r\n<p>Vision du besoin par le chef de projet</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p><strong>L&rsquo;&eacute;quipe</strong>&nbsp;tend donc vers un compromis entre les besoins exprim&eacute;s par le client, les instructions du chef de projet et sa propre vision du produit. Le projet devra-t-il &ecirc;tre aussi complexe&nbsp;?</p>\r\n	</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Vision du besoin par l&#39;&eacute;quipe</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>&nbsp;<strong>Le livrable</strong>&nbsp;est pr&eacute;sent&eacute; au client &agrave; la fin du projet. Une maquette incompl&egrave;te ou un prototype approximatif permettent une avanc&eacute;e tr&egrave;s rapide&nbsp;! Le client et l&#39;utilisateur auront-ils toujours la m&ecirc;me vision du produit au cours de son d&eacute;veloppement&nbsp;?</p>\r\n	</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Vision du projet pour le client</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p><strong>La promesse commerciale</strong>&nbsp;et la strat&eacute;gie marketing sont &agrave; la hauteur de ce que le client va payer. La balan&ccedil;oire est luxueuse et son &quot;innovation&quot; r&eacute;side surtout dans son confort&nbsp;! La gestion de projet devra-t-elle se limiter &agrave; valoriser les avantages concurrentiels du produit&nbsp;?</p>\r\n	</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Vision du projet pour l&#39;&eacute;quipe</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p><strong>L&#39;utilisateur</strong>&nbsp;voulait une balan&ccedil;oire sans pr&eacute;tention. Il souhaitait quelque chose de simple, amusant et &eacute;conomique&nbsp;! Les facteurs de r&eacute;ussite d&rsquo;un projet seront-ils seulement observ&eacute;s apr&egrave;s le d&eacute;ploiement du produit&nbsp;?</p>\r\n	</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Vision du projet pour l&#39;utilisateur</p>\r\n\r\n<p>Sans blague, les r&eacute;ponses aux&nbsp;<strong>7 questions rh&eacute;toriques</strong>&nbsp;pos&eacute;es ci-dessous sont&nbsp;: NON, NON, NON, NON, NON, NON et NON&nbsp;!&nbsp;? Vous allez voir ci-dessous qu&#39;il existe aussi des mod&egrave;les qui impliquent votre client, et permettent d&#39;&ecirc;tre plus r&eacute;actif &agrave; ses demandes.&nbsp;</p>\r\n\r\n<p>Dans une gestion de projet dite &ldquo;s&eacute;quentielle&rdquo;, telle que la m&eacute;thode en cascade, les diff&eacute;rentes phases de d&eacute;veloppement sont effectu&eacute;es les unes apr&egrave;s les autres dans un ordre pr&eacute;cis. H&eacute;rit&eacute;e de l&#39;industrie du BTP, cette m&eacute;thodologie r&eacute;pond parfaitement aux attentes du client lorsque son besoin est d&eacute;j&agrave; bien d&eacute;fini et d&eacute;limit&eacute;. &Agrave; l&rsquo;inverse, plus le projet est impr&eacute;visible, plus votre &eacute;quipe est susceptible de rencontrer des &eacute;checs successifs pendant sa gestion. Vous aurez alors tout int&eacute;r&ecirc;t &agrave; choisir une approche dite &ldquo;agile&rdquo;, incr&eacute;mentale (ajouts successifs) et it&eacute;rative (cycles r&eacute;p&eacute;titifs), afin de vous adapter au changement.</p>\r\n\r\n<p>Quelle est cette&nbsp;<strong>nouvelle mani&egrave;re de voir les choses</strong>&nbsp;propos&eacute;e par l&#39;agilit&eacute;&nbsp;? Je vous donne une r&eacute;ponse &agrave; cette question dans la section ci-dessous.</p>\r\n\r\n<h3>D&eacute;couvrez l&#39;agilit&eacute; comme alternative</h3>\r\n\r\n<p>Un peu d&#39;histoire pour vous pr&eacute;senter le contexte... En f&eacute;vrier 2001, aux &Eacute;tats-Unis, 17&nbsp;sp&eacute;cialistes du d&eacute;veloppement de logiciels proposent un changement d&rsquo;approche pragmatique dans la conduite de projet. Plus empirique, moins pr&eacute;dictive, cette alternative agile montre que les cycles de d&eacute;veloppement classiques ne correspondent pas toujours aux contraintes et aux exigences d&rsquo;<strong>organisations en constante &eacute;volution</strong>. Le&nbsp;<a href=\"http://agilemanifesto.org/iso/fr/manifesto.html\" rel=\"noopener noreferrer nofollow\" target=\"_blank\">Manifeste agile</a>&nbsp;est n&eacute;&nbsp;! Vous pouvez le lire et m&ecirc;me l&rsquo;apprendre par c&oelig;ur (moins de 500&nbsp;caract&egrave;res), avant de consulter ses 12&nbsp;principes sous-jacents. ?&nbsp;</p>\r\n\r\n<p>Les principaux mots-cl&eacute;s qui gravitent autour du Manifeste agile sont&nbsp;<em>flexibilit&eacute;</em>,&nbsp;<em>r&eacute;activit&eacute;</em>,&nbsp;<em>transparence</em>&nbsp;et&nbsp;<em>anticipation</em>. Face aux incertitudes que vous pouvez rencontrer dans votre gestion de projet, ne cherchez plus ici de th&eacute;orie globale ou structurante, et d&eacute;couvrez plut&ocirc;t quelques r&eacute;alit&eacute;s pratiques sur lesquelles s&rsquo;appuient&nbsp;<strong>les 4&nbsp;valeurs</strong>&nbsp;du Manifeste agile&nbsp;:</p>\r\n\r\n<h4>1. Les individus et leurs interactions</h4>\r\n\r\n<ul>\r\n	<li>\r\n	<p>&Eacute;checs ou r&eacute;ussites, ce sont bien vos &eacute;quipes qui sont&nbsp;<strong>responsables des projets</strong>. Votre prise en compte du facteur humain est donc essentielle.</p>\r\n	</li>\r\n	<li>\r\n	<p>C&rsquo;est incontournable, vous devez&nbsp;<strong>int&eacute;grer les forces et surtout les faiblesses</strong>&nbsp;des interactions humaines dans votre gestion de projet.</p>\r\n	</li>\r\n	<li>\r\n	<p>L&rsquo;agilit&eacute; propose de&nbsp;<strong>souder, dynamiser et responsabiliser vos &eacute;quipes</strong>&nbsp;au lieu de les mettre en concurrence.</p>\r\n	</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Vous pr&eacute;f&eacute;rez les processus et les outils aux interactions&nbsp;!</p>\r\n	</li>\r\n	<li>\r\n	<p>Vous ne formalisez pas suffisamment le cadre de travail&nbsp;!</p>\r\n	</li>\r\n</ul>\r\n\r\n<h4>2. Logiciels (produits, services, etc.) op&eacute;rationnels</h4>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Les mod&egrave;les agiles se veulent avant tout&nbsp;<strong>pragmatiques</strong>, c&rsquo;est donc l&rsquo;op&eacute;rationnel qui prime toujours. Votre &eacute;quipe est autog&eacute;r&eacute;e&nbsp;: l&rsquo;&eacute;quipe choisit avec qui, comment et sur quoi travailler.</p>\r\n	</li>\r\n	<li>\r\n	<p>Les livraisons interm&eacute;diaires,&nbsp;<strong>r&eacute;guli&egrave;rement propos&eacute;es &agrave; votre client</strong>, sont toujours une part cons&eacute;quente et utilisable de votre solution compl&egrave;te.</p>\r\n	</li>\r\n	<li>\r\n	<p>La qualit&eacute; est toujours&nbsp;<strong>&eacute;valu&eacute;e en continu</strong>&nbsp;pendant votre gestion du projet.</p>\r\n	</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Votre documentation fait plus de 100 pages&nbsp;!</p>\r\n	</li>\r\n	<li>\r\n	<p>Vos livrables passent &agrave; c&ocirc;t&eacute; de l&rsquo;essentiel : satisfaire votre client&nbsp;!<strong>&nbsp;</strong></p>\r\n	</li>\r\n</ul>\r\n\r\n<h4>3. La collaboration avec les clients</h4>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Le contrat doit soutenir votre&nbsp;<strong>r&eacute;ussite du projet</strong>&nbsp;et non fixer son ex&eacute;cution.</p>\r\n	</li>\r\n	<li>\r\n	<p>Les interactions&nbsp;<strong>fortes et permanentes</strong>&nbsp;avec votre client facilitent la n&eacute;gociation.&nbsp;</p>\r\n	</li>\r\n	<li>\r\n	<p>Les enjeux de l&rsquo;agilit&eacute; et ses principes sont&nbsp;<strong>bien compris et int&eacute;gr&eacute;s</strong>&nbsp;par votre client.</p>\r\n	</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Vous r&eacute;digez un contrat trop contraignant pour l&rsquo;&eacute;volution de votre projet&nbsp;!</p>\r\n	</li>\r\n	<li>\r\n	<p>Vous oubliez d&rsquo;int&eacute;grer le client ou l&rsquo;utilisateur dans votre gestion du projet&nbsp;!<strong>&nbsp;</strong></p>\r\n	</li>\r\n</ul>\r\n\r\n<h4>4. L&rsquo;adaptation au changement</h4>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Les entreprises doivent constamment&nbsp;<strong>faire preuve de r&eacute;activit&eacute;</strong>&nbsp;face &agrave; la concurrence et aux attentes du march&eacute;.</p>\r\n	</li>\r\n	<li>\r\n	<p>L&rsquo;acc&eacute;l&eacute;ration permanente du&nbsp;<strong>progr&egrave;s technologique</strong>&nbsp;augmente l&rsquo;obsolescence des applications, qui sont contraintes de s&rsquo;adapter en continu.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong>L&rsquo;usage des r&eacute;seaux sociaux</strong>&nbsp;a d&eacute;finitivement r&eacute;volutionn&eacute; l&rsquo;approche des utilisateurs, qui deviennent de plus en plus exigeants.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong>Le contexte &eacute;conomique</strong>&nbsp;oblige les &eacute;quipes &agrave; &ecirc;tre capables de produire efficacement le plus de valeur possible pour leurs utilisateurs finaux.</p>\r\n	</li>\r\n</ul>\r\n\r\n<p>Vous d&eacute;testez cette citation de Charles Darwin :</p>\r\n\r\n<blockquote>\r\n<p>&laquo; Ce n&#39;est pas le plus fort de l&#39;esp&egrave;ce qui survit, ni le plus intelligent. C&#39;est celui qui sait le mieux s&#39;adapter au changement&nbsp;&raquo;&nbsp;!&nbsp;?</p>\r\n</blockquote>\r\n\r\n<p>Initialement r&eacute;dig&eacute; par des sp&eacute;cialistes de l&#39;informatique, le Manifeste agile s&#39;applique d&eacute;sormais avec succ&egrave;s dans&nbsp;<strong>diff&eacute;rentes situations et entreprises</strong>.</p>\r\n\r\n<h3>D&eacute;couvrez les apports de l&#39;intelligence collective</h3>\r\n\r\n<p>Comment former votre &eacute;quipe et l&rsquo;amener &agrave; maturit&eacute;&nbsp;? La premi&egrave;re phrase de l&rsquo;article&nbsp;<em>Wikip&eacute;dia</em>&nbsp;consacr&eacute; &agrave; l&rsquo;<a href=\"https://fr.wikipedia.org/wiki/Intelligence_collective\" rel=\"noopener noreferrer nofollow\" target=\"_blank\"><strong>intelligence collective</strong></a>&nbsp;est un bon d&eacute;but de r&eacute;ponse&nbsp;:</p>\r\n\r\n<blockquote>\r\n<p>L&#39;intelligence collective d&eacute;signe les capacit&eacute;s cognitives d&#39;une communaut&eacute; r&eacute;sultant des interactions multiples entre ses membres.</p>\r\n</blockquote>\r\n\r\n<p>Ce ph&eacute;nom&egrave;ne social est un acc&eacute;l&eacute;rateur de performance pour toutes les organisations apprenantes, comme les fourmis, les abeilles, les poissons et nous (les humains).&nbsp;? Elle va donc vous &ecirc;tre tr&egrave;s utile pour&nbsp;<strong>former votre &eacute;quipe</strong>, sans contraindre, sans brider et sans faire preuve d&#39;autoritarisme.&nbsp;✌</p>\r\n\r\n<p>Appuyons-nous sur les recherches de&nbsp;<strong>Bruce Wayne Tuckman</strong>&nbsp;pour aller ensemble plus loin et plus vite.&nbsp;? Ce psychosociologue am&eacute;ricain a en effet d&eacute;fini un mod&egrave;le de &quot;team-building&quot; qui r&eacute;pond parfaitement aux exigences d&#39;une &eacute;quipe agile. Avec les apports d&rsquo;une communaut&eacute; d&rsquo;int&eacute;r&ecirc;ts et d&rsquo;un espace collaboratif, les&nbsp;<strong>4&nbsp;premi&egrave;res &eacute;tapes</strong>&nbsp;du mod&egrave;le de Tuckman exploitent toutes les forces de l&#39;intelligence collective&nbsp;:</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p><strong>Forming</strong>/<strong>Formation</strong>, les membres de votre &eacute;quipe apprendront &agrave; se conna&icirc;tre et &agrave; se faire accepter. Les conflits latents ne seront pas ou peu abord&eacute;s.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong>Storming</strong>/<strong>Tension</strong>, les membres de votre &eacute;quipe se placeront les uns par rapport aux autres, se confronteront et pourront parfois entrer en conflit.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong>Norming</strong>/<strong>R&eacute;gularisation</strong>, votre &eacute;quipe commencera &agrave; privil&eacute;gier un cadre coop&eacute;ratif et collaboratif plus fluide. Les membres partageront des valeurs et des objectifs communs. La confiance s&rsquo;installera dans votre &eacute;quipe qui s&rsquo;autog&eacute;rera progressivement.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong>Performing</strong>/<strong>Ex&eacute;cution</strong>, chaque membre de votre &eacute;quipe sera interd&eacute;pendant, autonome et comp&eacute;tent. La confiance sera bien install&eacute;e&nbsp;; but &agrave; atteindre pour g&eacute;rer un projet efficacement.</p>\r\n	</li>\r\n</ol>\r\n\r\n<h3>En r&eacute;sum&eacute;</h3>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Initiez-vous &agrave; la gestion empirique de projet afin de d&eacute;velopper des produits ou des services&nbsp;<strong>tr&egrave;s difficiles &agrave; pr&eacute;voir ou &agrave; anticiper</strong>.</p>\r\n	</li>\r\n	<li>\r\n	<p>En qualit&eacute; de coach agile, adoptez les&nbsp;<strong>4&nbsp;valeurs du Manifeste agile</strong>&nbsp;en favorisant&nbsp;: les individus et leurs interactions, les produits ou les services op&eacute;rationnels, la collaboration avec le client, l&#39;adaptation au changement.</p>\r\n	</li>\r\n	<li>\r\n	<p>Formez votre &eacute;quipe agile &agrave; partir des principes de l&rsquo;intelligence collective, gr&acirc;ce au mod&egrave;le en&nbsp;<strong>4&nbsp;&eacute;tapes de Bruce Tuckman&nbsp;</strong>: Forming, Storming, Norming et Performing.&nbsp;&nbsp;</p>\r\n	</li>\r\n</ul>\r\n\r\n<p><em>Vous ne verrez pas dans cette partie la toute derni&egrave;re &eacute;tape (</em><strong><em>Adjourning/Dissolution</em></strong><em>) qui correspond au d&eacute;sengagement du personnel, en particulier pour des &eacute;quipes qui travaillent en r&eacute;gie. Nous restons donc motiv&eacute;s et plus soud&eacute;s que jamais dans le prochain chapitre&nbsp;!&nbsp;</em>?</p>','740267724',1,0),(2,20,6,1,'bienvenue','bienvenue','bienvenue','<p>bienvenue</p>','744924176',1,0),(3,20,6,1,'bienvenue 2','bienvenue 2','bienvenue 2','<p>bienvenue 2</p>','744939124',1,0),(4,20,6,2,'outils 1','outils 1','outils 1','<p>outils 1</p>','744939458',1,0),(5,20,6,3,'prospection 1','prospection 1','prospection 1','<p>prospection 1</p>','744939458',1,0),(6,23,3,1,'Bienvenue sur pixelforce','Nos formations Banque-Assurance\r\n\r\nLa crise sanitaire a accéléré la tendance croissante à la digitalisation questionnant jusqu\'à la raison d\'être. Dorénavant, banques et assurances doivent repenser leurs orientations et replacer le client au coeur de chaque processus, pour rester compétitives. Nos formations vous offriront un panorama complet du secteur, de ses acteurs et de ses enjeux.',NULL,'<h2><strong>Pourquoi faire une formation en assurance en alternance ?</strong></h2>\r\n\r\n<p><strong>La formation en alternance permet de se former &agrave; un m&eacute;tier sur le terrain tout en continuant de suivre des enseignements th&eacute;oriques g&eacute;n&eacute;raux.&nbsp;</strong>Au cours de l&rsquo;ann&eacute;e, l&rsquo;&eacute;tudiant alterne donc des p&eacute;riodes en entreprise avec des p&eacute;riodes dans son &eacute;cole ou son universit&eacute;.<strong><strong>&nbsp;</strong></strong>L&rsquo;int&eacute;r&ecirc;t de l&rsquo;alternance est d&rsquo;avoir une exp&eacute;rience concr&egrave;te en entreprise tr&egrave;s t&ocirc;t. L&rsquo;alternant peut se rendre compte de la r&eacute;alit&eacute; du m&eacute;tier, et ainsi confirmer son choix, affiner ses aspirations professionnelles ou se r&eacute;orienter si le quotidien de la profession ne lui convenait pas.<br />\r\n<br />\r\n<strong>Par ailleurs, c&rsquo;est une v&eacute;ritable passerelle vers l&rsquo;<a href=\"https://reassurez-moi.fr/guide/assurance/emploi\">emploi dans l&rsquo;assurance</a>, que les recruteurs valorisent beaucoup.&nbsp;</strong>L&rsquo;&eacute;tudiant est en effet familier du fonctionnement d&rsquo;une entreprise, exerce concr&egrave;tement le m&eacute;tier pour lequel il &eacute;tudie, adh&egrave;re &agrave; la vie et &agrave; la culture d&rsquo;entreprise. L&rsquo;embauche &agrave; la fin des &eacute;tudes est plus facile et plus fr&eacute;quente : l&rsquo;entreprise ayant form&eacute; l&rsquo;alternant pendant un ou deux ans a investi pour ce futur collaborateur. Il est tr&egrave;s courant de voir plus de&nbsp;<a href=\"https://reassurez-moi.fr/guide/assurance/recrutement\">recrutements en assurance</a>&nbsp;de candidats ayant eu une formation d&rsquo;assurance en alternance plut&ocirc;t que d&rsquo;&eacute;tudiants issus de formation initiale classique.</p>\r\n\r\n<blockquote>\r\n<p>D&rsquo;un point de vue financier, l&rsquo;alternance est int&eacute;ressante &eacute;galement : l&rsquo;entreprise d&rsquo;accueil doit prendre en charge les frais de formation de l&rsquo;alternant, qui peuvent monter &agrave; pr&egrave;s de 10 000 &euro; pour les &eacute;coles priv&eacute;es les plus ch&egrave;res. En parall&egrave;le, il est r&eacute;mun&eacute;r&eacute; mensuellement pour son travail dans l&rsquo;entreprise.</p>\r\n</blockquote>\r\n\r\n<p><strong>Deux types de contrats existent :</strong>&nbsp;l&rsquo;apprentissage (de 16 &agrave; 30 ans maximum) et la professionnalisation (d&egrave;s 16 ans, pour toute personne &eacute;tudiante ou en recherche d&rsquo;emploi). Voici quelques exemples de formation en alternance :</p>\r\n\r\n<ul>\r\n	<li>Licence pro Assurance, banque, finance (IAE Nantes) ;</li>\r\n	<li>Bachelor Assurance et banque en alternance : charg&eacute; de client&egrave;le (&agrave; l&rsquo;ESA) ;</li>\r\n	<li>Master pro Manager de l&rsquo;assurance (&agrave; l&rsquo;ESA) ;</li>\r\n	<li>Master pro Banque et assurance (IAE Gustave Eiffel) ;</li>\r\n	<li>Master pro Management de l&rsquo;assurance (ENASS).</li>\r\n</ul>\r\n\r\n<h2><strong>Que propose P&ocirc;le Emploi comme formation en banque et assurance ?</strong></h2>\r\n\r\n<p><strong>P&ocirc;le Emploi a d&eacute;velopp&eacute; une plateforme gratuite recensant de nombreuses formations professionnelles &agrave; travers toute la France,&nbsp;</strong>quel que soit le m&eacute;tier ou le secteur recherch&eacute; : il s&rsquo;agit du site &laquo;&nbsp;la bonne formation&nbsp;&raquo; de P&ocirc;le Emploi. Que vous soyez demandeur d&rsquo;emploi ou salari&eacute;, vous pouvez trouver une formation adapt&eacute;e &agrave; votre besoin : en organisme ou &agrave; distance, du niveau bac au niveau bac +4, &eacute;ligible &agrave; financement total, dans une r&eacute;gion pr&eacute;cise, etc.<br />\r\n<br />\r\n<strong>Les formations propos&eacute;es comportent toutes les m&ecirc;mes informations</strong><strong>&nbsp;pour vous aider &agrave; faire le meilleur choix possible.&nbsp;</strong>Ainsi, vous saurez o&ugrave; elle se d&eacute;roule, sur combien d&rsquo;heures ou de mois, quel est son objectif pr&eacute;cis, ses conditions d&rsquo;acc&egrave;s, quelles sont les d&eacute;bouch&eacute;s, entre autres. L&rsquo;int&eacute;r&ecirc;t de ce site r&eacute;side aussi en ce que les formations pr&eacute;sent&eacute;es soient tri&eacute;es par efficacit&eacute; sur le march&eacute; du travail, pr&eacute;cis&eacute;e par une jauge &laquo;&nbsp;taux de retour &agrave; l&rsquo;emploi&nbsp;&raquo;.</p>\r\n\r\n<p>Si vous ne trouvez pas votre bonheur ou avez des questions, vous pouvez contacter un conseiller P&ocirc;le Emploi &agrave; tout moment.</p>\r\n\r\n<p><strong><strong>Voici quelques exemples de formations propos&eacute;es :</strong></strong></p>\r\n\r\n<ul>\r\n	<li>Conseiller &ndash; Conseill&egrave;re Client&egrave;le en Assurance (IAS Niv III).</li>\r\n	<li>Licence pro droit, &eacute;conomie, gestion mention assurance, banque, finance (Universit&eacute; Paris Descartes).</li>\r\n	<li>Assurance et gestion des risques (Keyjob Paris).</li>\r\n	<li>Capacit&eacute; professionnelle des salari&eacute;s&nbsp;<a href=\"https://reassurez-moi.fr/guide/assurance/commercial\">commerciaux dans les soci&eacute;t&eacute;s d&rsquo;assurance</a>&nbsp;(Ax&eacute;l&eacute;rance Formation &agrave; Caen).</li>\r\n	<li>Pr&eacute;venir les risques de la transformation digitale en assurance (ESA Paris).</li>\r\n	<li>Expert(e) en assurance maritime (Certification nationale HSCE &agrave; Bandol).</li>\r\n</ul>\r\n\r\n<p><strong>Vous trouverez ci-dessous le guide de P&ocirc;le Emploi pour trouver une formation adapt&eacute;e &agrave; vos envies et &agrave; vos besoins :</strong></p>\r\n\r\n<p><a href=\"https://reassurez-moi.fr/guide/wp-content/uploads/2018/12/guide-formation-pole-emploi.pdf\"><strong>Guide de formation par P&ocirc;le Emploi :</strong></a></p>\r\n\r\n<p><img alt=\"guide-formation-pole-emploi\" src=\"https://reassurez-moi.fr/guide/wp-content/uploads/elementor/thumbs/guide-formation-pole-emploi-o0ggq1pvh8ukk2s20uhp0603emtvt6u9mayzmh6q4w.jpg\" /></p>\r\n\r\n<p><strong>Pensez &agrave; v&eacute;rifier s&rsquo;il s&rsquo;agit d&rsquo;une formation certifiante avant de vous y inscrire, si cela est d&eacute;cisif pour vous.</strong></p>\r\n\r\n<h2><strong>Quelles formations banque et assurance pour adulte ?</strong></h2>\r\n\r\n<p><strong>Le nombre de r&eacute;orientations et de reconversions professionnelles est croissant en France depuis quelques ann&eacute;es</strong>, amenant les centres de formation (organismes priv&eacute;s, &eacute;coles, universit&eacute;s) &agrave; en d&eacute;velopper de nouvelles ou &agrave; adapter celles d&eacute;j&agrave; existantes, pour les adultes.<br />\r\n<br />\r\n<strong>Le secteur de la banque assurance est particuli&egrave;rement friand des adultes en reconversion</strong><strong>, notamment parce que l&rsquo;exp&eacute;rience est tr&egrave;s valoris&eacute;e dans cette profession.</strong>&nbsp;Que vous soyez salari&eacute; ou demandeur d&rsquo;emploi, une multitude de formations est donc &agrave; votre port&eacute;e : du BTS en un an comme le BTS Assurance de l&rsquo;ESA, aux formations de sp&eacute;cialisation en 7 jours comme &laquo;&nbsp;&Ecirc;tre Gestionnaire d&rsquo;assurance pour son entreprise&nbsp;&raquo; de Elegia Formation.<br />\r\n<br />\r\n<strong>Vous pouvez m&ecirc;me suivre un Master en deux ans gr&acirc;ce &agrave; un contrat de professionnalisation, vous permettant d&rsquo;alterner formation et entreprise.</strong></p>\r\n\r\n<ul>\r\n	<li>De nombreux sites proposent des listes de formations en fonction de votre objectif, en fonction de si vous &ecirc;tes actuellement en poste ou non, du co&ucirc;t et de la localisation&hellip; Nous vous conseillons de jeter un oeil au site &laquo;&nbsp;la Bonne Formation&nbsp;&raquo; de P&ocirc;le Emploi, ou encore au site Maformation.fr.</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>Par ailleurs, il est commun dans les grandes entreprises que les formations soient propos&eacute;es en interne, n&rsquo;h&eacute;sitez pas &agrave; vous renseigner aupr&egrave;s de votre service des ressources humaines ou de gestion du personnel.</li>\r\n</ul>\r\n\r\n<p><strong>Vous trouverez dans le tableau ci-dessous quelques exemples de formation en assurance pour adultes :</strong></p>\r\n\r\n<table>\r\n	<thead>\r\n		<tr>\r\n			<th>&nbsp;</th>\r\n			<th>Pour qui ?</th>\r\n			<th>Dur&eacute;e</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td><strong>Bachelor banque finance assurance</strong></td>\r\n			<td>Etudiant, demandeur d&#39;emploi, salari&eacute; en poste</td>\r\n			<td>1 an</td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong>L&rsquo;assurance Responsabilit&eacute; civile</strong></td>\r\n			<td>Salari&eacute; en poste</td>\r\n			<td>7 heures</td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong>Conseiller client&egrave;le et gestionnaire en assurances de personnes</strong></td>\r\n			<td>Demandeur d&#39;emploi</td>\r\n			<td>371 heure (environ 1 mois)</td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong>BTS Assurance</strong></td>\r\n			<td>Etudiant, demandeur d&#39;emploi, salari&eacute; en poste</td>\r\n			<td>11 &agrave; 23 mois</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Vous cherchez un emploi dans les assurances ? Chez R&eacute;assurez-moi, nous recrutons toute l&rsquo;ann&eacute;e ! Retrouvez nos diff&eacute;rentes offres d&#39;emploi ci-dessous :</p>\r\n\r\n<ul>\r\n	<li><a href=\"https://reassurez-moi.fr/guide/assistant-commercial\">assistant commercial</a></li>\r\n	<li><a href=\"https://reassurez-moi.fr/guide/stagiaire-full-stack-symfony-3\">stagiaire full stack</a></li>\r\n</ul>','745677492',1,0),(7,24,3,2,'Outil pixelforce','L’apparition de l’assurance est un phénomène récent. En France, elle ne date que de la fin de l’Ancien régime, avec la fondation de la Compagnie générale des assurances et grosses aventures en 1686, même si dès le XIVe siècle les marchands italiens avaient trouvé le moyen de protéger leurs navires contre les pertes subies lors d’un naufrage ou suite aux méfaits des pirates. Ils créaient des associations afin de constituer des fonds susceptibles de les dédommager (code d’Amalfi).\r\nLe développement de l’assurance est lié aux transformations économiques et sociales : le passage d’une économie agricole à une économie diversifiée a multiplié les causes de dommage (industrie, commerce), et la concentration des populations dans les villes avec l’apparition de nouvelles habitations et de nouveaux modes de vie a engendré de nouveaux fléaux',NULL,'<h1>Pourquoi a-t-on besoin d&#39;une assurance ?</h1>\r\n\r\n<p>L&#39;assurance, le sommaire</p>\r\n\r\n<h4><strong><a href=\"https://www.economie.gouv.fr/facileco/assurance-besoin-types-dommages-personnes\">1. Pourquoi a-t-on besoin d&#39;une assurance ?</a></strong></h4>\r\n\r\n<h4><a href=\"https://www.economie.gouv.fr/facileco/assurances-indispensables-habitation-automobile\">2. Quelles sont les assurances indispensables ?</a></h4>\r\n\r\n<h4><a href=\"https://www.economie.gouv.fr/facileco/comprendre-assurance-risques\">3. Comprendre le m&eacute;canisme de l&#39;assurance</a></h4>\r\n\r\n<h4><a href=\"https://www.economie.gouv.fr/facileco/assurance-assureurs-mediation\">4. Quels sont les acteurs du secteur de l&#39;assurance ?</a></h4>\r\n\r\n<p><strong>Le principe de l&rsquo;assurance est fond&eacute; sur la notion de risque, c&#39;est-&agrave;-dire l&rsquo;exposition &agrave; un danger potentiel, inh&eacute;rent &agrave; une situation ou une activit&eacute; et dont on ne pourrait affronter les cons&eacute;quences financi&egrave;res, qu&rsquo;elles soient li&eacute;es aux biens ou aux personnes.</strong></p>\r\n\r\n<h2>Du danger &agrave; l&#39;accident</h2>\r\n\r\n<p>Le danger est le pr&eacute;lude au risque qui est lui-m&ecirc;me le pr&eacute;lude &agrave; l&rsquo;accident. Ainsi le danger ayant &eacute;t&eacute; identifi&eacute;,&nbsp;<strong>le risque devient parfaitement descriptible</strong>, il est susceptible de se produire mais on ne sait pas s&rsquo;il se r&eacute;alisera et quand il se r&eacute;alisera.</p>\r\n\r\n<p><strong>L&rsquo;assurance est un contrat</strong>&nbsp;: en contrepartie du versement d&rsquo;une cotisation, aussi appel&eacute;e prime, l&rsquo;assureur garantit des prestations pr&eacute;cises &agrave; un individu, une association ou une entreprise en cas de r&eacute;alisation d&rsquo;un risque clairement identifi&eacute; dans le contrat.</p>\r\n\r\n<p>La notion de risque est une notion cl&eacute; en mati&egrave;re d&rsquo;assurance, il s&rsquo;agit d&rsquo;un &eacute;v&eacute;nement al&eacute;atoire redout&eacute; par un assur&eacute; pour ses cons&eacute;quences financi&egrave;res. L&rsquo;al&eacute;a repose sur trois crit&egrave;res :</p>\r\n\r\n<ul>\r\n	<li><strong>le futur</strong>&nbsp;: on ne peut assurer un accident de voiture qui s&rsquo;est d&eacute;j&agrave; produit ;</li>\r\n	<li><strong>l&rsquo;incertain</strong>&nbsp;: on ne peut assurer un risque certain qui se r&eacute;alisera &agrave; une date connue&nbsp;;</li>\r\n	<li><strong>l&rsquo;involontaire</strong>&nbsp;: on ne peut assurer les dommages que l&rsquo;assur&eacute; cause ou se cause de fa&ccedil;on volontaire.<br />\r\n	&nbsp;</li>\r\n</ul>\r\n\r\n<h2>Diff&eacute;rents types d&#39;assurances</h2>\r\n\r\n<h3>Les assurances de dommages</h3>\r\n\r\n<p>Les assurances de dommages regroupent &agrave; la fois des&nbsp;<strong>assurances de responsabilit&eacute;</strong>&nbsp;(responsabilit&eacute; civile familiale, responsabilit&eacute; civile du conducteur, responsabilit&eacute; professionnelle&hellip;) et&nbsp;<strong>des assurances de biens&nbsp;</strong>(assurance des biens meubles et immeubles, des dommages caus&eacute;s au v&eacute;hicule&hellip;).</p>\r\n\r\n<p>La vocation traditionnelle de l&rsquo;assurance est de permettre le&nbsp;<strong>remplacement de biens d&eacute;truits ou subtilis&eacute;s</strong>. De plus, aujourd&rsquo;hui l&rsquo;assurance de la responsabilit&eacute; dans le domaine de la vie domestique, de l&rsquo;activit&eacute; professionnelle, de la circulation automobile et des loisirs s&rsquo;est consid&eacute;rablement d&eacute;velopp&eacute;e. Dans ce cas, on s&rsquo;assure&nbsp;<strong>contre les dommages et les pr&eacute;judices&nbsp;</strong>&eacute;ventuels caus&eacute;s involontairement &agrave; des tiers.</p>\r\n\r\n<p>Les assurances de biens et les assurances de responsabilit&eacute; ont pour but de prot&eacute;ger le patrimoine de l&rsquo;assur&eacute;. Elles sont, pour certaines regroup&eacute;es dans des contrats &laquo; multirisques&nbsp;&raquo; (multirisques habitation, multirisques entreprise&hellip;).</p>\r\n\r\n<p>Les assurances de biens les plus courantes sont l&rsquo;assurance incendie, l&rsquo;assurance vol, les d&eacute;g&acirc;ts des eaux ou le bris de glace mais d&rsquo;autres types d&rsquo;&eacute;v&eacute;nements sont automatiquement int&eacute;gr&eacute;s (catastrophes naturelles, attentats&hellip;) ou propos&eacute;s en option.</p>\r\n\r\n<h3>Les assurances de la personne</h3>\r\n\r\n<p>Les assurances de la personne couvrent les<strong>&nbsp;risques inh&eacute;rents &agrave; la vie humaine</strong>&nbsp;et proposent un ensemble complet de solutions adapt&eacute;es &agrave; chaque situation. Certains contrats pr&eacute;voient des prestations en cas d&rsquo;atteinte &agrave; l&rsquo;int&eacute;grit&eacute; physique : d&eacute;c&egrave;s, invalidit&eacute; (assurances en cas de d&eacute;c&egrave;s), d&rsquo;autres permettent la constitution d&rsquo;une &eacute;pargne et le versement de celle-ci sous forme de rente ou de capital si la personne assur&eacute;e est en vie au terme du contrat (assurances en cas de vie).<br />\r\n&nbsp;</p>\r\n\r\n<h3>Un peu d&#39;histoire</h3>\r\n\r\n<p>L&rsquo;apparition de l&rsquo;assurance est un&nbsp;<strong>ph&eacute;nom&egrave;ne r&eacute;cent</strong>. En France, elle ne date que de la fin de l&rsquo;Ancien r&eacute;gime, avec la fondation de la Compagnie g&eacute;n&eacute;rale des assurances et grosses aventures en 1686, m&ecirc;me si d&egrave;s le XIVe&nbsp;si&egrave;cle les marchands italiens avaient trouv&eacute; le moyen de prot&eacute;ger leurs navires contre les pertes subies lors d&rsquo;un naufrage ou suite aux m&eacute;faits des pirates. Ils cr&eacute;aient des associations afin de constituer des fonds susceptibles de les d&eacute;dommager (code d&rsquo;Amalfi).<br />\r\nLe d&eacute;veloppement de l&rsquo;assurance est<strong>&nbsp;li&eacute; aux transformations &eacute;conomiques et sociales</strong>&nbsp;: le passage d&rsquo;une &eacute;conomie agricole &agrave; une &eacute;conomie diversifi&eacute;e a multipli&eacute; les causes de dommage (industrie, commerce), et la concentration des populations dans les villes avec l&rsquo;apparition de nouvelles habitations et de nouveaux modes de vie a engendr&eacute; de nouveaux fl&eacute;aux</p>','746774779',1,0);
/*!40000 ALTER TABLE `formation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formation_agent`
--

DROP TABLE IF EXISTS `formation_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formation_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formation_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_500002E85200282E` (`formation_id`),
  KEY `IDX_500002E83414710B` (`agent_id`),
  CONSTRAINT `FK_500002E83414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_500002E85200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formation_agent`
--

LOCK TABLES `formation_agent` WRITE;
/*!40000 ALTER TABLE `formation_agent` DISABLE KEYS */;
INSERT INTO `formation_agent` VALUES (1,1,5,'disponible'),(2,1,13,'disponible'),(3,1,16,'disponible'),(4,1,18,'disponible'),(5,1,19,'disponible'),(6,1,21,'disponible'),(7,2,22,'terminer'),(8,3,22,'terminer'),(9,4,22,'terminer'),(10,5,22,'disponible'),(11,6,14,'disponible'),(12,6,15,'disponible'),(13,6,25,'terminer');
/*!40000 ALTER TABLE `formation_agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventaire_fille`
--

DROP TABLE IF EXISTS `inventaire_fille`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventaire_fille` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mere_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `qte` double NOT NULL,
  `statut` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C8E2342339DEC40E` (`mere_id`),
  KEY `IDX_C8E23423F347EFB` (`produit_id`),
  CONSTRAINT `FK_C8E2342339DEC40E` FOREIGN KEY (`mere_id`) REFERENCES `inventaire_mere` (`id`),
  CONSTRAINT `FK_C8E23423F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventaire_fille`
--

LOCK TABLES `inventaire_fille` WRITE;
/*!40000 ALTER TABLE `inventaire_fille` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventaire_fille` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `inventaire_fille_details`
--

DROP TABLE IF EXISTS `inventaire_fille_details`;
/*!50001 DROP VIEW IF EXISTS `inventaire_fille_details`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inventaire_fille_details` AS SELECT 
 1 AS `id`,
 1 AS `mere_id`,
 1 AS `produit_id`,
 1 AS `qte`,
 1 AS `statut`,
 1 AS `date_inventaire`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inventaire_fille_details_valid`
--

DROP TABLE IF EXISTS `inventaire_fille_details_valid`;
/*!50001 DROP VIEW IF EXISTS `inventaire_fille_details_valid`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inventaire_fille_details_valid` AS SELECT 
 1 AS `id`,
 1 AS `mere_id`,
 1 AS `produit_id`,
 1 AS `qte`,
 1 AS `statut`,
 1 AS `date_inventaire`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `inventaire_mere`
--

DROP TABLE IF EXISTS `inventaire_mere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventaire_mere` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secteur_id` int(11) NOT NULL,
  `date_inventaire` datetime NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_49892A6F9F7E4405` (`secteur_id`),
  CONSTRAINT `FK_49892A6F9F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventaire_mere`
--

LOCK TABLES `inventaire_mere` WRITE;
/*!40000 ALTER TABLE `inventaire_mere` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventaire_mere` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kit_base_elmt_secu`
--

DROP TABLE IF EXISTS `kit_base_elmt_secu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kit_base_elmt_secu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kit_base_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_328473ECE0C2FCA6` (`kit_base_id`),
  KEY `IDX_328473ECF347EFB` (`produit_id`),
  CONSTRAINT `FK_328473ECE0C2FCA6` FOREIGN KEY (`kit_base_id`) REFERENCES `kit_base_secu` (`id`),
  CONSTRAINT `FK_328473ECF347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit_secu_accomp` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kit_base_elmt_secu`
--

LOCK TABLES `kit_base_elmt_secu` WRITE;
/*!40000 ALTER TABLE `kit_base_elmt_secu` DISABLE KEYS */;
INSERT INTO `kit_base_elmt_secu` VALUES (1,1,10,0,3),(2,1,11,0,5),(3,2,7,0,9),(4,2,1,0,2),(5,2,11,0,3),(6,2,2,0,10),(7,3,9,0,1),(8,3,10,0,2),(9,3,2,1,1),(10,3,12,1,1),(11,3,1,1,1),(12,3,13,1,1),(13,3,3,1,2);
/*!40000 ALTER TABLE `kit_base_elmt_secu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kit_base_secu`
--

DROP TABLE IF EXISTS `kit_base_secu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kit_base_secu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secteur_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5D56377E9F7E4405` (`secteur_id`),
  CONSTRAINT `FK_5D56377E9F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kit_base_secu`
--

LOCK TABLES `kit_base_secu` WRITE;
/*!40000 ALTER TABLE `kit_base_secu` DISABLE KEYS */;
INSERT INTO `kit_base_secu` VALUES (1,'<p>description kit de base 1</p>',0,1900.00,'kit de base 1',1,NULL),(2,'<p>description&nbsp;<strong>kit de base 2 plus</strong></p>',0,5600.00,'kit de base 2 plus',1,'images/kitbase/1/ylang-ylang.jpg'),(3,'<p>Notre kit de base est compos&eacute; de :</p>\r\n\r\n<p>1 centrale&nbsp;<br />\r\n2 images&nbsp;<br />\r\n1 contact ouverture<br />\r\n1 sir&egrave;ne<br />\r\n1 clavier</p>',1,699.00,'Kit de base',1,NULL);
/*!40000 ALTER TABLE `kit_base_secu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `les_mois`
--

DROP TABLE IF EXISTS `les_mois`;
/*!50001 DROP VIEW IF EXISTS `les_mois`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `les_mois` AS SELECT 
 1 AS `mois`,
 1 AS `mois_str`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `live_chat_video`
--

DROP TABLE IF EXISTS `live_chat_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `live_chat_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_a_id` int(11) DEFAULT NULL,
  `user_b_id` int(11) DEFAULT NULL,
  `secteur_id` int(11) DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_speed_live` tinyint(1) DEFAULT NULL,
  `date_debut_live` datetime DEFAULT NULL,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_in_process` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2D0551EB415F1F91` (`user_a_id`),
  KEY `IDX_2D0551EB53EAB07F` (`user_b_id`),
  KEY `IDX_2D0551EB9F7E4405` (`secteur_id`),
  CONSTRAINT `FK_2D0551EB415F1F91` FOREIGN KEY (`user_a_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_2D0551EB53EAB07F` FOREIGN KEY (`user_b_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_2D0551EB9F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `live_chat_video`
--

LOCK TABLES `live_chat_video` WRITE;
/*!40000 ALTER TABLE `live_chat_video` DISABLE KEYS */;
INSERT INTO `live_chat_video` VALUES (63,24,14,3,'D9apwV9XlARC407YumifJdnBPsiTB853-mrZYL7uqlQ',NULL,'2022-09-06 12:00:00','Formation des nouveaux','Bonjour, bien former les nouveaux agents.',NULL),(64,24,15,3,'D9apwV9XlARC407YumifJdnBPsiTB853-mrZYL7uqlQ',NULL,'2022-09-06 12:00:00','Formation des nouveaux','Bonjour, bien former les nouveaux agents.',NULL);
/*!40000 ALTER TABLE `live_chat_video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formation_id` int(11) DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6A2CA10C5200282E` (`formation_id`),
  CONSTRAINT `FK_6A2CA10C5200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,2,'17_2022-08-30-13-57-26.pdf','document',NULL,'application/pdf'),(2,2,'BLACKPINK - ‘Pink Venom’ MV.mp3','audio',NULL,'audio/mpeg'),(4,1,'axel_ollivier_cv.doc','document','axel-ollivier-cv-6310e10ce71bf.rtf','application/msword'),(5,6,'contrat (3).pdf','document','contrat-3-6311a810874c8.pdf','application/pdf'),(6,6,'signature-devis-2022-08-30 08_16.pdf','document','signature-devis-2022-08-30-08-16-6311a810880a4.pdf','application/pdf'),(7,7,'Référencement-Pixelsior (1).docx','document','re-fe-rencement-pixelsior-1-6316f20a4834b.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document'),(8,7,'Site-suite.docx','document','site-suite-6316f20a4be04.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document');
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting`
--

DROP TABLE IF EXISTS `meeting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meeting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `meeting_state_id` int(11) DEFAULT NULL,
  `user_to_meet_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F515E139A76ED395` (`user_id`),
  KEY `IDX_F515E13996491114` (`meeting_state_id`),
  KEY `IDX_F515E1392A44447F` (`user_to_meet_id`),
  CONSTRAINT `FK_F515E1392A44447F` FOREIGN KEY (`user_to_meet_id`) REFERENCES `contact` (`id`),
  CONSTRAINT `FK_F515E13996491114` FOREIGN KEY (`meeting_state_id`) REFERENCES `meeting_state` (`id`),
  CONSTRAINT `FK_F515E139A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting`
--

LOCK TABLES `meeting` WRITE;
/*!40000 ALTER TABLE `meeting` DISABLE KEYS */;
INSERT INTO `meeting` VALUES (1,3,1,2,'Vente',NULL,'2022-08-16 11:51:00','2022-08-16 12:05:00'),(2,6,1,2,'Vente',NULL,'2022-08-16 11:51:00','2022-08-16 12:05:00'),(3,20,1,16,'test rendez vous','pas de note','2022-08-31 03:06:00','2022-08-31 04:06:00'),(4,22,1,16,'test rendez vous','pas de note','2022-08-31 03:06:00','2022-08-31 04:06:00'),(5,20,1,17,'test rendez vous 2','pas de note','2022-09-01 11:08:00','2022-09-01 12:08:00'),(6,22,1,17,'test rendez vous 2','pas de note','2022-09-01 11:08:00','2022-09-01 12:08:00'),(7,23,1,106,'Vente','Note','2022-09-02 07:06:00','2022-09-02 08:06:00'),(8,15,1,106,'Vente','Note','2022-09-02 07:06:00','2022-09-02 08:06:00');
/*!40000 ALTER TABLE `meeting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting_event`
--

DROP TABLE IF EXISTS `meeting_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meeting_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meeting_id` int(11) DEFAULT NULL,
  `calendar_event_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_539F48A767433D9C` (`meeting_id`),
  KEY `IDX_539F48A77495C8E3` (`calendar_event_id`),
  CONSTRAINT `FK_539F48A767433D9C` FOREIGN KEY (`meeting_id`) REFERENCES `meeting` (`id`),
  CONSTRAINT `FK_539F48A77495C8E3` FOREIGN KEY (`calendar_event_id`) REFERENCES `calendar_event` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_event`
--

LOCK TABLES `meeting_event` WRITE;
/*!40000 ALTER TABLE `meeting_event` DISABLE KEYS */;
INSERT INTO `meeting_event` VALUES (1,1,9),(2,2,10),(3,3,18),(4,4,19),(5,5,20),(6,6,21),(7,7,22),(8,8,23);
/*!40000 ALTER TABLE `meeting_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting_state`
--

DROP TABLE IF EXISTS `meeting_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meeting_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_state`
--

LOCK TABLES `meeting_state` WRITE;
/*!40000 ALTER TABLE `meeting_state` DISABLE KEYS */;
INSERT INTO `meeting_state` VALUES (1,'En attente'),(2,'Terminé'),(3,'Annulé');
/*!40000 ALTER TABLE `meeting_state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `canal_message_id` int(11) DEFAULT NULL,
  `textes` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `files` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '(DC2Type:array)',
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FA76ED395` (`user_id`),
  KEY `IDX_B6BD307FE53A466D` (`canal_message_id`),
  CONSTRAINT `FK_B6BD307FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_B6BD307FE53A466D` FOREIGN KEY (`canal_message_id`) REFERENCES `canal_message` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` VALUES (1,1,1,'MUIFAMKjeDyvAY5QxXqJd50PrzadmkQY02LfXEwka5DDLEI_M7FGQpu7QfxY15rDxne1bpH8XDpNrcu_HtMsy0Z-Z_MPKfhNzFvh7G-v-zRERBC_Q830WTyVUZLA1sGa3-P9qdS8oiTk3RCx-O4Mp08gFIIy_JenqfpOMObKGOvH','2022-08-02 11:36:11','a:0:{}',NULL),(2,2,5,'MUIFAG3l8MNB1msI30L41BxOQMiYoRh4uaUKPMQW9aKsPoP6hqlLf1Sx7v6s4UqHGvwpjxxvHKVpjlCZHOR_HDAaxbKjIpF1hMC0cT8cwEZXv1a64ScsUzEIOt9R7S-dNXcGWjFyMlrC_PK8d8w7C-cf6Gp3EG6FtB8KeDaAM6jSFocSs9nD6V71Diuh','2022-08-11 18:08:07','a:0:{}',NULL),(3,2,5,'MUIFAIXHtrya_L1ALtqK5D3nUCz7yOneMU_K3QESQiRn98A7FYea470ku2I7m2hrCf5UgfdtnMrRAzDiEMFXXA7T1LXRkZnmKULkTGKhIEWPVhRhnXH0saeAnr02IEbIbcSvK_2dKXIXp713E0HDsGiO-z3R7ZdnVF9DPyjNcPakDBBObBKRfhX5m1E=','2022-08-11 18:15:04','a:0:{}',NULL),(4,5,5,'MUIFAMFnYfEkYz1rAV1ot-QISYMbyhtYLzpYPsO2ID72fVaBiz8ncicpzsoo_g_ubWuSXZd0XsWmyLbo2oPVfY5bsnW0ujjT0Y76oSPYK6dk5c614GEGtlAU8g0TECypXXybBizpA-EbIacYd8IhvPkZAsf-QNuKB0ZgMHhaQzkKexnPokG4ZKk=','2022-08-11 18:16:08','a:0:{}',NULL),(5,2,5,'MUIFAPNcnWV9vXznTt2IVcDpCjpdJFq7dOxlbu1XmdTGRdbLxGm4EJ0KG3dDX_g4Kw8kKpBnABGPWtcbKM3zA712dZ-9n2_zzTp21sRw_YIeilHr54Q-b-I2grjsrqvKsSSHxA1-bFXGezYaGFqEKRVpCN1YlxyqQ5_qS1KefjSuiV4=','2022-08-12 12:08:10','a:0:{}',NULL),(6,5,5,'MUIFADtDBEzh76qu60k-Hor2mpzvKnJTkCHfHjEC35qUqPkvKFcWP98p6QmM4U-79pYTUw3FoxPGZ30xhCq2UrjcFh48MLvO_21iZAxeMOE5IRmSEsaWiwo298TbNi113qq5GRNVKCgl_ghyteeKXv7Ai4V39Iar0OtZTkbTBPVg9QM=','2022-08-12 12:09:20','a:0:{}',NULL),(7,2,5,'MUIFAGbflui3xtWOiyX5aplVwVKagjcVAJ1FfURLsbzuEgxd94Z2PurXOsp3rURXAUIskqTj3VRZSTndd2Pam1B-N8T3vBAdwtEH2Y1GjXMYaiv5wdNIzEINFNY3OKJ402GgQhByl965nrwKZ_e2yJY7uOyR0sBRdEP28ztryv2Nqmg=','2022-08-12 18:41:18','a:0:{}',NULL),(8,2,5,'MUIFAM9uDcQ4z8hwEEiotSzauc_01scqhZnWBK5jSeFxO8t0t4AYhDq2yJAisQ7ivF3KxGP7clnu4456Os8fFsaW7PgBpvR0azgDsCAm4Ne91oBZCefYhxEP5HOR7oqis-du9GvSVuqFy9AdWaGF89oSFjUuY73uU4i2y7zcU7R7KPU=','2022-08-12 21:02:33','a:0:{}',NULL),(9,5,5,'MUIFAFGFfa85PLCbTaVp1KCVqOm49kRNGJcTKgABBxOj2WMwTt2f8G5XH8INUz_xY83buKAWJzvS5yjgXslBuWgoUQDLq77Ml62Btn9xXO-6ImJ9DAlA52q4oOCeVNmlxICoZmUkUFktWoPB9dd0PTMD0EP9KA4XrRVC7oc3KMxNFnk=','2022-08-12 21:03:08','a:0:{}',NULL),(10,5,5,'MUIFAMt4nFrZGxCm4QTWEn9Mg6k5ljJ39eJKekTx27tUsq_q0-ToWDqdt_l10jTmDB-aygKn3quxUeUiIDKqCJ11My6FErS8dL94-97g3I-FzYvMvyYxIylfaYY1gBoog16tAxPADPDWfn-k5Xvhxg9aXyFEtWvkE5ayh7C_YADtigc=','2022-08-19 15:53:54','a:0:{}',NULL),(11,2,5,'MUIFADIrbwKbQKmPou5j8GI6rgnAqZyXfdXOKkD6nFJk4bQuDVFLIlSvYLpt1tITZLOCjiKm4h4TERUl3Sq5f-K7jSJpmzqHy_p7ZZvZZAJEsXpgwZk7h3hwChHuniIRXZZQYpww0VUxcaMyTnPyVcFIzt8b748E2YJnAS4pCRNdq6s=','2022-08-19 15:54:40','a:0:{}',NULL),(12,2,5,'MUIFAIyfE5vCK7p6M1sMFgG2aYcp8fRM33cvDjZesK8zCTfsZ84TpPhZFZEZybCuENF3nwU5enTDG59ODRVYv1wbQO2RjKlwksKlmOPFvXWY4B1be08d9_AZhdH-4m85BeHh8Sjd9jv3JblwB5Y3uAje7rmZSAf0nzesgusGLN9HqgAfhRAB-m5USrwfzs8C00ph54eH-o2W3tnxjj8XWsGrqZYkAKPl','2022-08-20 14:49:32','a:0:{}',NULL),(13,2,5,'MUIFAKrJD-ahV-Ry1rkIhx-FlxCksZnSvkzabb77dE6fOPkLUF28nmH9vSzkZn6nniOr-2U1DeHNWDR7tWN0n9RyHDAREG2gKWerXaZZx7ZLl6zQqKSv6Hfsw5C08SjESnYU-Y6WG4wUYIUJf3gxRsMaAbxHh5MN7lm3TT-m5tZ1','2022-08-22 06:36:53','a:0:{}',NULL),(14,15,31,'MUIFAL456TpxZeHQlja4TtcxNIPtHFbNf5LrzatMiGmA9_PHjFT64Oq9JIhJ5y5EjRLkgIPhrzAWcafYncjTcEIr81swL6UkIQ3e9vj2vncaub-vwHDeuokURqt-wmqzPfelVPNBN-KiUNTD_LMDk-4R9fe4ZqXoEkgiNf-kY5Yu3a7rzBnvnQE=','2022-09-02 06:54:24','a:0:{}',NULL),(15,23,31,'MUIFANee1kC84rSe7jSrqqq9VcCpa5onWPa58GKPX02Kle2jNkJaJOu5wBbl00kFMqZuF_Cn7_h6NCY1DnnoSn9rZHZm9iI2FvBHYn5BOsFoNI-vOH5lYdvTITS7faqncrmJUKZYbAHAFZeJkUT3FmE88Nd0r211JXJZxjVBq2Kkv_g=','2022-09-02 06:56:55','a:0:{}',NULL),(16,25,36,'MUIFAEbRAabFNPwjA5FXrZMAmYza-fpPCS_F0cL1TerqHSnF79AM9E-DD28BKeM7LPSCY-MUurXQEa5yungtVwh01ydeV2fUQl5m-xNqGikaWddbRnqOxgb6IqlW-VuVnHnAxcgYdCxjjLe-WAK9P3jJRkJAgaFEC2wqFjRqNVycR44=','2022-09-07 10:57:55','a:0:{}',NULL);
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mouvement`
--

DROP TABLE IF EXISTS `mouvement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mouvement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produit_id` int(11) NOT NULL,
  `date_mouvement` datetime NOT NULL,
  `entree` double DEFAULT NULL,
  `sortie` double DEFAULT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5B51FC3EF347EFB` (`produit_id`),
  CONSTRAINT `FK_5B51FC3EF347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mouvement`
--

LOCK TABLES `mouvement` WRITE;
/*!40000 ALTER TABLE `mouvement` DISABLE KEYS */;
INSERT INTO `mouvement` VALUES (1,6,'2022-07-20 06:57:25',10,0,1),(2,9,'2022-07-20 06:57:25',10,0,1),(3,1,'2022-07-20 06:57:25',10,0,1),(4,4,'2022-07-20 06:57:25',10,0,1),(5,1,'2022-07-20 07:19:57',0,2,1),(6,4,'2022-07-20 07:19:57',0,1,1);
/*!40000 ALTER TABLE `mouvement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `mouvement_valid`
--

DROP TABLE IF EXISTS `mouvement_valid`;
/*!50001 DROP VIEW IF EXISTS `mouvement_valid`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mouvement_valid` AS SELECT 
 1 AS `id`,
 1 AS `produit_id`,
 1 AS `date_mouvement`,
 1 AS `entree`,
 1 AS `sortie`,
 1 AS `statut`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) DEFAULT NULL,
  `agent_id` int(11) NOT NULL,
  `secteur_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `amount` decimal(10,3) NOT NULL,
  `status` int(11) NOT NULL,
  `charge_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F5299398F5B7AF75` (`address_id`),
  KEY `IDX_F5299398A76ED395` (`user_id`),
  KEY `IDX_F52993983414710B` (`agent_id`),
  KEY `IDX_F52993989F7E4405` (`secteur_id`),
  CONSTRAINT `FK_F52993983414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_F52993989F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`),
  CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_F5299398F5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `order_address` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,10,1,7,7,'2022-07-20 07:19:57',60.300,2,'ch_3LNXCMIXp7HGskyi12c4oQJK');
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_address`
--

DROP TABLE IF EXISTS `order_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FB34C6CAA76ED395` (`user_id`),
  CONSTRAINT `FK_FB34C6CAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_address`
--

LOCK TABLES `order_address` WRITE;
/*!40000 ALTER TABLE `order_address` DISABLE KEYS */;
INSERT INTO `order_address` VALUES (1,10,'Tana','Antananarivo','00101','0','0');
/*!40000 ALTER TABLE `order_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_digital`
--

DROP TABLE IF EXISTS `order_digital`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_digital` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `devis_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `created_at` datetime NOT NULL,
  `stripe_data` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `agent_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_charge_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3D32E49C41DEFADA` (`devis_id`),
  KEY `IDX_3D32E49C3414710B` (`agent_id`),
  KEY `IDX_3D32E49C19EB6921` (`client_id`),
  CONSTRAINT `FK_3D32E49C19EB6921` FOREIGN KEY (`client_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_3D32E49C3414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_3D32E49C41DEFADA` FOREIGN KEY (`devis_id`) REFERENCES `devis` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_digital`
--

LOCK TABLES `order_digital` WRITE;
/*!40000 ALTER TABLE `order_digital` DISABLE KEYS */;
INSERT INTO `order_digital` VALUES (1,6,17,4,50,'2022-09-02 08:43:06','a:0:{}','agentdigital@gmail.com','mnakanyandriamihaja@gmail.com','ch_3LdVSxIXp7HGskyi1axlogVR');
/*!40000 ALTER TABLE `order_digital` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `order_parent_id` int(11) NOT NULL,
  `price` decimal(10,3) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2530ADE64584665A` (`product_id`),
  KEY `IDX_2530ADE6CEFDB188` (`order_parent_id`),
  CONSTRAINT `FK_2530ADE64584665A` FOREIGN KEY (`product_id`) REFERENCES `produit` (`id`),
  CONSTRAINT `FK_2530ADE6CEFDB188` FOREIGN KEY (`order_parent_id`) REFERENCES `order` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_product`
--

LOCK TABLES `order_product` WRITE;
/*!40000 ALTER TABLE `order_product` DISABLE KEYS */;
INSERT INTO `order_product` VALUES (1,1,1,23.900,2),(2,4,1,12.500,1);
/*!40000 ALTER TABLE `order_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_secu`
--

DROP TABLE IF EXISTS `order_secu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_secu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produit_id` int(11) DEFAULT NULL,
  `type_abonnement_id` int(11) DEFAULT NULL,
  `agent_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `code_promo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prix_produit` double NOT NULL,
  `statut` int(11) NOT NULL,
  `type_installation_id` int(11) DEFAULT NULL,
  `secteur_id` int(11) NOT NULL,
  `date_commande` datetime NOT NULL,
  `installation_frais` double DEFAULT NULL,
  `accomp_montant` double NOT NULL,
  `charge_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contrat_rempli` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contrat_signed` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sepa` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '(DC2Type:json)',
  `kitbase_id` int(11) DEFAULT NULL,
  `tva_id` int(11) DEFAULT NULL,
  `tva_pourcentage` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_359C5E65F347EFB` (`produit_id`),
  KEY `IDX_359C5E65813AF326` (`type_abonnement_id`),
  KEY `IDX_359C5E653414710B` (`agent_id`),
  KEY `IDX_359C5E6519EB6921` (`client_id`),
  KEY `IDX_359C5E65E14F1CC0` (`type_installation_id`),
  KEY `IDX_359C5E659F7E4405` (`secteur_id`),
  KEY `IDX_359C5E65E65C3F5B` (`kitbase_id`),
  KEY `IDX_359C5E654D79775F` (`tva_id`),
  CONSTRAINT `FK_359C5E6519EB6921` FOREIGN KEY (`client_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_359C5E653414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_359C5E654D79775F` FOREIGN KEY (`tva_id`) REFERENCES `tva_secu` (`id`),
  CONSTRAINT `FK_359C5E65813AF326` FOREIGN KEY (`type_abonnement_id`) REFERENCES `type_abonnement_secu` (`id`),
  CONSTRAINT `FK_359C5E659F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`),
  CONSTRAINT `FK_359C5E65E14F1CC0` FOREIGN KEY (`type_installation_id`) REFERENCES `type_installation_secu` (`id`),
  CONSTRAINT `FK_359C5E65E65C3F5B` FOREIGN KEY (`kitbase_id`) REFERENCES `kit_base_secu` (`id`),
  CONSTRAINT `FK_359C5E65F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit_secu` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_secu`
--

LOCK TABLES `order_secu` WRITE;
/*!40000 ALTER TABLE `order_secu` DISABLE KEYS */;
INSERT INTO `order_secu` VALUES (1,NULL,NULL,5,9,'CODE2',299,2,NULL,1,'2022-08-10 12:52:28',NULL,855,'ch_3LVEOiIXp7HGskyi11UdoJem','secu/contrat/rempli/9/2022-08-10-12-43-04/contrat.pdf','secu/contrat/signed/9_2022-08-10-12-43-23.pdf','{\"pays\": \"\", \"ville\": \"\", \"code_bic\": \"\", \"paiement\": \"\", \"code_postal\": \"\", \"date_signature\": \"\", \"lieu_signature\": \"\", \"adresse_nom_rue\": \"\", \"coordonnees_compte\": \"\", \"creancier_code_rum\": \"\", \"creancier_n_client\": \"\", \"nom_prenom_raison_sociale\": \"Princie Rakotoarivony\"}',2,1,10.00),(2,NULL,NULL,5,9,'CODE1',499,2,NULL,1,'2022-08-11 07:38:44',NULL,398,'ch_3LVVybIXp7HGskyi2jAjPd6G','secu/contrat/rempli/9/2022-08-11-07-38-05/contrat.pdf','secu/contrat/signed/9_2022-08-11-07-38-19.pdf','{\"pays\": \"\", \"ville\": \"\", \"code_bic\": \"\", \"paiement\": \"\", \"code_postal\": \"\", \"date_signature\": \"\", \"lieu_signature\": \"\", \"adresse_nom_rue\": \"\", \"coordonnees_compte\": \"\", \"creancier_code_rum\": \"\", \"creancier_n_client\": \"\", \"nom_prenom_raison_sociale\": \"Princie Rakotoarivony\"}',2,1,10.00),(3,NULL,NULL,5,9,'CODE2',299,1,NULL,1,'2022-08-11 09:28:32',NULL,1596,'ch_3LVXgqIXp7HGskyi0eUhoQeB','secu/contrat/rempli/9/2022-08-11-09-28-03/contrat.pdf','secu/contrat/signed/9_2022-08-11-09-28-12.pdf','{\"nom_prenom_raison_sociale\":\"Princie Rakotoarivony\",\"adresse_nom_rue\":\"\",\"ville\":\"\",\"pays\":\"\",\"code_postal\":\"\",\"lieu_signature\":\"\",\"date_signature\":\"\",\"creancier_n_client\":\"\",\"creancier_code_rum\":\"\",\"coordonnees_compte\":\"\",\"code_bic\":\"\",\"paiement\":\"\"}',2,3,20.00),(4,NULL,NULL,5,9,NULL,699,2,NULL,1,'2022-08-16 14:39:44',NULL,1395,'ch_3LXQvlIXp7HGskyi19e9nuke','secu/contrat/rempli/9/2022-08-16-14-39-04/contrat (1).pdf','secu/contrat/signed/9_2022-08-16-14-39-22.pdf','{\"nom_prenom_raison_sociale\":\"\",\"adresse_nom_rue\":\"\",\"ville\":\"\",\"pays\":\"\",\"code_postal\":\"\",\"lieu_signature\":\"\",\"date_signature\":\"\",\"creancier_n_client\":\"\",\"creancier_code_rum\":\"\",\"coordonnees_compte\":\"\",\"code_bic\":\"\",\"paiement\":\"\"}',3,3,20.00),(5,NULL,NULL,5,9,NULL,699,2,NULL,1,'2022-08-17 16:17:44',NULL,797,'ch_3LXow9IXp7HGskyi28VlCJi9','secu/contrat/rempli/9/2022-08-17-16-16-44/contrat (2).pdf','secu/contrat/signed/9_2022-08-17-16-17-12.pdf','{\"nom_prenom_raison_sociale\":\"Nakany Michel\",\"adresse_nom_rue\":\"\",\"ville\":\"\",\"pays\":\"\",\"code_postal\":\"\",\"lieu_signature\":\"\",\"date_signature\":\"\",\"creancier_n_client\":\"\",\"creancier_code_rum\":\"\",\"coordonnees_compte\":\"\",\"code_bic\":\"\",\"paiement\":\"\"}',3,1,10.00);
/*!40000 ALTER TABLE `order_secu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_secu_accomp`
--

DROP TABLE IF EXISTS `order_secu_accomp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_secu_accomp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produit_id` int(11) NOT NULL,
  `order_secu_id` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_838CEF23F347EFB` (`produit_id`),
  KEY `IDX_838CEF23F5DC637B` (`order_secu_id`),
  CONSTRAINT `FK_838CEF23F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit_secu_accomp` (`id`),
  CONSTRAINT `FK_838CEF23F5DC637B` FOREIGN KEY (`order_secu_id`) REFERENCES `order_secu` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_secu_accomp`
--

LOCK TABLES `order_secu_accomp` WRITE;
/*!40000 ALTER TABLE `order_secu_accomp` DISABLE KEYS */;
INSERT INTO `order_secu_accomp` VALUES (1,2,1,2,129),(2,4,1,3,199),(3,4,2,2,199),(4,6,3,4,399),(5,1,4,3,199),(6,6,4,2,399),(7,1,5,2,199),(8,6,5,1,399);
/*!40000 ALTER TABLE `order_secu_accomp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `order_secu_valide`
--

DROP TABLE IF EXISTS `order_secu_valide`;
/*!50001 DROP VIEW IF EXISTS `order_secu_valide`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `order_secu_valide` AS SELECT 
 1 AS `id`,
 1 AS `produit_id`,
 1 AS `type_abonnement_id`,
 1 AS `agent_id`,
 1 AS `client_id`,
 1 AS `code_promo`,
 1 AS `prix_produit`,
 1 AS `statut`,
 1 AS `type_installation_id`,
 1 AS `secteur_id`,
 1 AS `date_commande`,
 1 AS `installation_frais`,
 1 AS `accomp_montant`,
 1 AS `charge_id`,
 1 AS `contrat_rempli`,
 1 AS `contrat_signed`,
 1 AS `sepa`,
 1 AS `kitbase_id`,
 1 AS `tva_id`,
 1 AS `tva_pourcentage`,
 1 AS `montant_ttc`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status`
--

LOCK TABLES `order_status` WRITE;
/*!40000 ALTER TABLE `order_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `order_valide`
--

DROP TABLE IF EXISTS `order_valide`;
/*!50001 DROP VIEW IF EXISTS `order_valide`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `order_valide` AS SELECT 
 1 AS `id`,
 1 AS `user_id`,
 1 AS `address_id`,
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `order_date`,
 1 AS `amount`,
 1 AS `status`,
 1 AS `charge_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `plan_agent_account`
--

DROP TABLE IF EXISTS `plan_agent_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plan_agent_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stipe_product_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_price_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_price_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `price_interval_unit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan_agent_account`
--

LOCK TABLES `plan_agent_account` WRITE;
/*!40000 ALTER TABLE `plan_agent_account` DISABLE KEYS */;
INSERT INTO `plan_agent_account` VALUES (1,'prod_planCompteAgent','price_1LSn7hIXp7HGskyipckPdnYO','Un secteur','Le prix d\'abonnement pour un seul secteur',97,'Mois','active'),(2,'prod_planCompteAgent','price_1LSn8eIXp7HGskyiWkdq0nRe','Plusieurs secteurs','Le prix d\'abonnement pour accéder à plusieurs secteurs à la fois',297,'Mois','active');
/*!40000 ALTER TABLE `plan_agent_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secteur_id` int(11) NOT NULL,
  `id_categorie` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prix` decimal(10,3) NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_29A5EC279F7E4405` (`secteur_id`),
  KEY `IDX_29A5EC27C9486A13` (`id_categorie`),
  CONSTRAINT `FK_29A5EC279F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`),
  CONSTRAINT `FK_29A5EC27C9486A13` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit`
--

LOCK TABLES `produit` WRITE;
/*!40000 ALTER TABLE `produit` DISABLE KEYS */;
INSERT INTO `produit` VALUES (1,7,1,'Gingembre Frais',NULL,23.900,'images/products/gingembre-frais.jpg',1),(2,7,1,'Niaouli',NULL,8.000,'images/products/niaouli.jpg',1),(3,7,1,'Ravintsara',NULL,10.800,'images/products/ravintsara.png',1),(4,7,1,'Saro',NULL,12.500,'images/products/saro.jpg',1),(5,7,1,'Ylang Ylang',NULL,14.200,'images/products/ylang-ylang.jpg',1),(6,7,2,'Dynamin & Sens',NULL,13.000,'images/products/dynamin-sens.jpg',1),(7,7,2,'Zen & Sens',NULL,13.000,'images/products/zen-sens.jpg',1),(8,7,2,'Immun & Sens',NULL,13.000,'images/products/immun-sens.jpg',1),(9,7,2,'Fragran’Delices',NULL,13.000,'images/products/fragran-delices.jpg',1);
/*!40000 ALTER TABLE `produit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit_dd`
--

DROP TABLE IF EXISTS `produit_dd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit_dd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secteur_id` int(11) NOT NULL,
  `id_categorie` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BA9A00B69F7E4405` (`secteur_id`),
  KEY `IDX_BA9A00B6C9486A13` (`id_categorie`),
  CONSTRAINT `FK_BA9A00B69F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`),
  CONSTRAINT `FK_BA9A00B6C9486A13` FOREIGN KEY (`id_categorie`) REFERENCES `categorie_dd` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_dd`
--

LOCK TABLES `produit_dd` WRITE;
/*!40000 ALTER TABLE `produit_dd` DISABLE KEYS */;
INSERT INTO `produit_dd` VALUES (1,2,1,'Choix 1','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>Site vitrine:</strong>&nbsp;prix &agrave; partir de&nbsp;999 &euro;</span></span></span></p>\r\n\r\n<p><strong><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Site e-commerce:&nbsp;</span></span></span></strong><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">prix &agrave; partir de&nbsp;1 399 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(2,2,1,'Choix 2 : PACK d’une durée de 24 mois','<p><strong><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Site vitrine:</span></span></span></strong><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">&nbsp;prix &agrave; partir de&nbsp;55 &euro;/mois</span></span></span></p>\r\n\r\n<p><strong><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Site e-commerce:&nbsp;</span></span></span></strong><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">prix &agrave; partir de&nbsp;65 &euro;/mois</span></span></span></p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(3,2,1,'Choix 3','<p><strong>Site sp&eacute;cialis&eacute;s:</strong>&nbsp;sur devis</p>','images/products/site_internet.png',1),(4,2,2,'Cartes de visite//carte commerce','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>LA CARTE DE VISITE AU FORMAT CLASSIQUE, C&rsquo;EST LA BONNE IMPRESSION ASSUR&Eacute;E</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Avec notre tr&egrave;s large gamme de carte de visite, vous aurez tout le loisir de red&eacute;couvrir ce grand classique de la communication dans tous ses &eacute;tats. Sur des supports papiers vari&eacute;s comme les papiers cr&eacute;ation, textur&eacute; ou &eacute;cologique, avec des finitions uniques telles que la dorure &agrave; chaud, le vernis, le sans impression, la d&eacute;coupe laser que ou dans des formats plus extravagants comme la carte adh&eacute;sive ou le QR contact, vous avez encore beaucoup &agrave; apprendre sur la carte de visite.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">44 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(5,2,2,'Set papier corporate (papier en tête...)','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>UNE GAMME COMPL&Egrave;TE DE SUPPORTS IMPRIM&Eacute;S POUR BUREAUTIQUE</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>POUR UN ENVIRONNEMENT DE TRAVAIL PRATIQUE ET PERSONNALIS&Eacute;</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Pour faciliter votre travail de bureau et optimiser votre productivit&eacute;, nous avons mis au point une gamme qui regroupe tous les produits imprim&eacute;s d&eacute;di&eacute;s &agrave; une activit&eacute; bureautique. Pr&eacute;parez vos courriers avec des enveloppes marqu&eacute;es de votre logo, estampillez vos contrats avec un tampon personnalis&eacute;, prenez des notes sur un notebook aux couleurs de votre entreprise, classez vos dossiers dans un classeur en polypropyl&egrave;ne...</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">50 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(6,2,2,'Calendriers','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>CALENDRIER ET AGENDA</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>NE RATEZ PLUS AUCUN &Eacute;V&Eacute;NEMENT !</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Vous &ecirc;tes &agrave; la recherche d&rsquo;un cadeau pour vos collaborateurs et clients ? L&rsquo;agenda ou le calendrier personnalis&eacute; est le choix id&eacute;al. Restez tout au long de l&rsquo;ann&eacute;e &agrave; l&rsquo;esprit de votre client gr&acirc;ce &agrave; un agenda publicitaire. Rembord&eacute; ou &agrave; spirale, chaque reliure poss&egrave;de ses avantages. D&eacute;couvrez sans plus attendre, quel agenda ou calendrier &agrave; imprimer correspond &agrave; vos attentes !</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">70 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(7,2,2,'Carte de vœux','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>D&Eacute;COUVREZ TOUS NOS FORMATS, SUPPORTS ET FINITIONS POUR CARTE DE VISITE, POSTALE, CORRESPONDANCE... !</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Meilleure alli&eacute;e de votre vie professionnelle, la carte est le support de communication par excellence. Transmettre une carte de visite &agrave; des clients potentiels, envoyer une carte de v&oelig;ux &agrave; vos partenaires pour le nouvel an, faire parvenir votre courrier imprim&eacute; sur une belle carte de correspondance... Testez de nombreux formats, associ&eacute;s &agrave; un large choix de supports et finitions pour une carte unique !</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">50 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(8,2,2,'Flyer simple','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>FLYERS ET TRACTS D&Eacute;PASSEZ VOS ID&Eacute;ES PAS VOTRE BUDGET !</strong></span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"> </span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Confiez-nous l&rsquo;impression de vos flyers en choisissant la plus large gamme de supports, de formats et de finitions du march&eacute; de l&rsquo;imprimerie en ligne. Nous mettons en valeur vos cr&eacute;ations de flyers, tracts ou prospectus publicitaires en vous apportant un rendu unique et une qualit&eacute; d&rsquo;impression haute d&eacute;finition &agrave; bas prix. Combinez la cr&eacute;ation graphique &agrave; un travail sur la mati&egrave;re : couleurs, textures, effets de brillance, illusions d&#39;optique... pour un maximum d&rsquo;impact en vous appuyant sur notre savoir-faire.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">40 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(9,2,2,'Dépliants/Brochures','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>D&Eacute;PLIANT ET PLAQUETTE PUBLICITAIRE N&rsquo;ATTENDEZ PLUS FAITES VOTRE CHOIX ET IMPRIMEZ !</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Mettez en valeur vos cr&eacute;ations avec la gamme de d&eacute;pliants publicitaires la plus diversifi&eacute;e du march&eacute;. Nous vous offrons une multitude de combinaisons possibles pour l&#39;impression de vos plaquettes commerciales. Toutes les options de formats, types de pli, supports, fa&ccedil;onnages et finitions sont disponibles pour sublimer vos imprim&eacute;s gr&acirc;ce &agrave; un rendu unique haute qualit&eacute;. Imaginez et cr&eacute;ez votre impression d&eacute;pliant en toute simplicit&eacute; gr&acirc;ce aux nombreux param&egrave;tres de personnalisation que nous vous offrons. Quel que soit, le format, la texture du support ou les finitions que vous souhaiterez y apposer, Exaprint donne vie &agrave; votre d&eacute;pliant comme vous l&#39;avez imagin&eacute;.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">70 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(10,2,2,'Affiches','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>AFFICHES PUBLICITAIRES &Agrave; IMPRIMER POUR MAXIMISER VOTRE VISIBILIT&Eacute; !</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Avec l&rsquo;&eacute;tendue de notre gamme d&rsquo;affiches publicitaires grand format ou petit format &agrave; imprimer, faites le choix d&rsquo;un support de communication haute qualit&eacute; pour diffuser vos messages efficacement &agrave; moindre co&ucirc;t.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">50 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(11,2,2,'Encart publicitaires','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>&nbsp;CONFIEZ-NOUS LA CONCEPTION DE VOS ENCARTS PUBLICITAIRES !</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">En format simple ou version anim&eacute;e, pour magazines ou pour les sites internet, notre agence r&eacute;alise les designs de toutes vos publicit&eacute;s. Vos produits ne passeront plus inaper&ccedil;us!</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">110 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(12,2,2,'Étiquettes','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>Cr&eacute;ez VOS STICKERS SUR-MESURE !</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Vos &eacute;tiquettes adh&eacute;sives &agrave; personnaliser en quelques clics Gr&acirc;ce &agrave; notre gamme d&#39;&eacute;tiquettes personnalis&eacute;es, vous pouvez cr&eacute;er des stickers avec la forme et les finitions de vos choix. Les &eacute;tiquettes adh&eacute;sives sont des supports de communication id&eacute;als pour vos emballages, cadeaux et autres op&eacute;rations de marketing. Laissez parler votre imagination et communiquez de mani&egrave;re cr&eacute;ative avec des autocollants personnalis&eacute;s !</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">10 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(13,2,2,'Menu/Carte de consommation','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>VOTRE IMPRESSION DE MENU RESTAURANT SE FAIT &Agrave; LA CARTE !</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">La communication ne passe plus seulement par l&rsquo;assiette ! Offrez &agrave; votre &eacute;tablissement ce qui se fait de mieux en termes d&rsquo;impression restauration et proposez les plats de votre carte sur des menus d&rsquo;un grand prestige. Utilis&eacute; &agrave; l&rsquo;origine comme support pour vos cr&eacute;ations culinaires, le menu s&rsquo;emploie &eacute;galement aujourd&rsquo;hui comme outil de communication et vous invite &agrave; faire votre publicit&eacute; directement &agrave; la table de vos clients. Des impressions menus adapt&eacute;es &agrave; des services int&eacute;rieurs comme ext&eacute;rieurs et con&ccedil;ues pour durer dans le temps, red&eacute;couvrez tout le potentiel d&rsquo;une carte restaurant personnalis&eacute;e et de qualit&eacute;. Sortez du lot en proposant des menus restaurant qui vous ressemblent. La robustesse du menu ind&eacute;chirable, l&#39;&eacute;l&eacute;gance du menu encapsul&eacute;, la commodit&eacute; du menu d&eacute;pliant, il y en a pour tous les go&ucirc;ts. Gr&acirc;ce aux cartes menu Exaprint, vos plats du jour mettront l&#39;eau &agrave; la bouche de vos convives.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">90 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(14,2,2,'Faire-part (mariage/naissance/décès...)','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>PACKAGING ET COFFRETS D&#39;INVITATION &Agrave; PERSONNALISER PERSONNALISEZ VOS &Eacute;V&Eacute;NEMENTS JUSQU&#39;&Agrave; L&#39;ENVOI DU FAIRE-PART</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Chacun de nous aime recevoir une invitation &agrave; un bel &eacute;v&eacute;nement tel qu&#39;un mariage ou un bapt&ecirc;me. Cette joie est accentu&eacute;e lorsque le faire-part re&ccedil;u est esth&eacute;tique et bien con&ccedil;u. Afin de vous accompagner dans la r&eacute;alisation de votre packaging d&#39;invitation, nous vous proposons des mod&egrave;les de packaging vari&eacute;s &agrave; personnaliser. Vous choisissez les motifs en lien avec la charte de l&#39;&eacute;v&eacute;nement f&ecirc;t&eacute; ; nous l&#39;imprimons sur la bo&icirc;te ou le coffret que vous aurez s&eacute;lectionn&eacute;.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">90 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(15,2,2,'Signalétique','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>SIGNAL&Eacute;TIQUES INT&Eacute;RIEURES ET EXT&Eacute;RIEURES PERSONNALIS&Eacute;S SELONS VOS ENVIES</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">D&eacute;couvrez nos gammes de signal&eacute;tiques sur-mesure pour d&eacute;corer vos int&eacute;rieurs ou habiller vos vitrines et devantures. En lettres d&eacute;coup&eacute;es, en plaques grav&eacute;es, en PVC ou encore en Plexiglass, ils offrent &agrave; vos messages un r&eacute;el impact. Vous serez d&rsquo;ailleurs en mesure de choisir parmi un large assortiment de supports et de formats, allant du plus simple au plus travaill&eacute;.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">40 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">&nbsp;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(16,2,2,'Vitrine (lettrage adhésif/vitrophanie)','<p><strong><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">VINYLE ADH&Eacute;SIF PERSONNALIS&Eacute; POUR VOS VITRINES&nbsp;</span></span></span></strong></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">D&eacute;couvrez nos adh&eacute;sifs vitrine sur mesure. Habillez les vitrines de vos commerces avec des impressions d&#39;adh&eacute;sif vitrophanie sur-mesure. Augmenter la visibilit&eacute; et l&#39;impact de vos messages pour une communication plus efficace. Optez pour le support de votre choix, en fond blanc, transparent ou d&eacute;poli translucide.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">50 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(17,2,2,'Roll-up','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>LE ROLL&rsquo;UP PUBLICITAIRE ID&Eacute;AL POUR MARQUER VOTRE PR&Eacute;SENCE LORS DE SALONS PROFESSIONNELS</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Adoptez le roll&rsquo;up publicitaire pour tous vos &eacute;v&egrave;nements et salons. Nous vous proposons le plus large choix de roll&#39;up &agrave; imprimer au meilleur prix. Vous trouverez toutes les tailles et les supports selon vos besoins sur notre catalogue : impression de roll&#39;up en aluminium, mini roll&#39;up, roll&#39;up t&eacute;lescopique, roll&#39;up haut de gamme.... Simple &agrave; monter, peu encombrant, avec un fort impact visuel, l&rsquo;enrouleur en aluminium est un incontournable en mati&egrave;re de communication. Personnalisez le support avec votre cr&eacute;ation, choisissez la taille adapt&eacute;e &agrave; vos besoins, s&eacute;lectionnez la mati&egrave;re qui vous convient&hellip; Pour sortir des sentiers battus pensez au roll&rsquo;up haut de gamme ou multim&eacute;dia.&nbsp; Peu importe votre projet, vous trouverez forc&eacute;ment le roll up qu&rsquo;il vous faut dans notre gamme PLV !</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">70 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(18,2,2,'Kakémono','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>KAK&Eacute;MONOS PUBLICITAIRES TISSU OU PAPIER POUR QUE VOTRE MESSAGE SURPLOMBE TOUS LES AUTRES</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">En tissu ou en papier, choisissez l&rsquo;impression de kakemono publicitaire suspendu par Exaprint. Donnez de l&rsquo;ampleur aux projets de vos clients en leur apportant une visibilit&eacute; maximale au meilleur prix. Confiez-lui sans h&eacute;sitations vos t&acirc;ches les plus ardues en termes de publicit&eacute; pendant un &eacute;v&eacute;nement et le kak&eacute;mono suspendu rel&egrave;vera le d&eacute;fi haut la main. En int&eacute;rieur comme en ext&eacute;rieur, le kak&eacute;mono publicitaire est parfait pour &ecirc;tre vu de loin et la haute qualit&eacute; de ses supports satin&eacute;s ou maill&eacute;s sera un r&eacute;el avantage pour gagner en cr&eacute;dibilit&eacute;.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">70 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(19,2,3,'Logo','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Ne vous fiez pas &agrave; sa taille : le logo rev&ecirc;t une portance capitale pour votre entreprise ! En effet, il v&eacute;hicule &agrave; lui seul votre image, votre identit&eacute; et vos valeurs. Confiez-nous la conception de votre logo ; vos clients vous reconna&icirc;tront d&rsquo;un seul coup d&rsquo;&oelig;il !</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">200 &euro;</span></span></span></p>\r\n\r\n<p>&nbsp;</p>','images/products/site_internet.png',1),(20,2,3,'Illustration','<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>&laquo; Une image vaut mille mots &raquo;</strong></span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">.</span></span></span></p>\r\n\r\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Cela se v&eacute;rifie bien souvent, surtout sur internet. Nous prenons en charge la conception d&rsquo;illustrations personnalis&eacute;es pour toutes vos communications. Nos infographistes talentueux d&eacute;passeront vos attentes en concr&eacute;tisant votre vision. Croquis, portraits, caricatures, &hellip; de style enfantin, BD ou encore r&eacute;tro, &hellip; Nous acceptons toutes vos demandes</span></span></span></p>\r\n\r\n<p>Sur devis</p>','images/products/site_internet.png',1),(21,2,4,'Call center','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Besoin des services d&rsquo;un call center performant pour vos appels entrants et sortants ? Laissez-nous faire ! Nos t&eacute;l&eacute;op&eacute;rateurs exp&eacute;riment&eacute;s traiteront vos demandes avec soin et professionnalisme.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">8 &euro;/heure</span></span></span></p>','images/products/call_center.png',1),(22,2,5,'Etude #1','<p><span style=\"color:#000000\"><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><strong>Package de lancement</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">(veille + charte graphique + ligne &eacute;ditoriale)</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de 499&nbsp;&euro;</span></span></span></p>','images/products/site_internet.png',1),(23,2,5,'Etude #2','<p><span style=\"color:#000000\"><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><strong>Package de lancement</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">(</span></span></span><strong><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">identit&eacute; + </span></span></span></strong><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">veille + charte graphique + ligne &eacute;ditoriale)</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;699 &euro;</span></span></span></p>','images/products/site_internet.png',1),(24,2,5,'Etude #3','<p><span style=\"color:#000000\"><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><strong>Package de lancement</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">(</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>personnage illustr&eacute;</strong></span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"> + </span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>identit&eacute; + </strong></span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">veille + charte graphique + ligne &eacute;ditoriale)</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de<strong>&nbsp;</strong>1 099 &euro;</span></span></span></p>','images/products/site_internet.png',1),(25,2,5,'Etude #4','<p><span style=\"color:#000000\"><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><strong>Package de lancement</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">(</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"><strong>site internet vitrine +</strong></span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\"> personnage illustr&eacute; + identit&eacute; + veille + charte graphique + ligne &eacute;ditoriale)</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de&nbsp;1 999 &euro;</span></span></span></p>','images/products/site_internet.png',1),(26,2,5,'Facebook ou Instagram ou LinkedIn ou Pinterest','<p><span style=\"color:#000000\"><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><strong>Mensualit&eacute;s 2 &agrave; 3 publications /semaine (visuel + texte) + 1 vid&eacute;o/mois</strong></span></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-size:11pt\"><span style=\"font-family:Arial\">A partir de&nbsp;</span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">250 &euro;/par Mois</span></span></span></p>','images/products/site_internet.png',1),(27,2,5,'Facebook + Instagram','<p><strong>Mensualit&eacute;s 2 &agrave; 3 publications /semaine (visuel + texte) + 1 vid&eacute;o/mois</strong></p>\r\n\r\n<p>A partir de 400 &euro;/par Mois</p>','images/products/site_internet.png',1),(28,2,5,'Facebook + Instagram + LinkedIn','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><strong>Mensualit&eacute;s 2 &agrave; 3 publications /semaine (visuel + texte) + 1 vid&eacute;o/mois</strong></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\">A partir de&nbsp;<span style=\"color:#000000\">650 &euro;/par Mois</span></span></span></p>','images/products/site_internet.png',1),(29,2,5,'Facebook + Instagram + LinkedIn + Pinterest','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><strong>Mensualit&eacute;s 2 &agrave; 3 publications /semaine (visuel + texte) + 1 vid&eacute;o/mois</strong></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\">A partir de&nbsp;<span style=\"color:#000000\">850 &euro;/par Mois</span></span></span></p>','images/products/site_internet.png',1),(30,2,6,'Application mobile iOS','<p>&nbsp;</p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de 5 000 &euro;</span></span></span></p>','images/products/application_mobile.png',1),(31,2,6,'Application mobile Androïd','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">A partir de 5 000 &euro;</span></span></span></p>','images/products/application_mobile.png',1),(32,2,7,'Collecte de mails','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">&Agrave; partir&nbsp; de&nbsp;1 400 &euro;</span></span></span></p>','images/products/site_internet.png',1),(33,2,7,'Vente de 1 ou + de produits','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">&Agrave; partir&nbsp; de&nbsp;2 400 &euro;</span></span></span></p>','images/products/site_internet.png',1),(34,2,7,'Création Communauté (Webinar ou Masterclass)','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">&Agrave; partir&nbsp; de&nbsp;3 500 &euro;</span></span></span></p>','images/products/site_internet.png',1),(35,2,7,'Tunnel Personnalisé','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">Sur Devis</span></span></span></p>','images/products/site_internet.png',1),(36,2,8,'Vidéo Marketing ( en motion design)','<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">S&rsquo;il y a une chose que youtube nous a appris, c&rsquo;est que le public raffole de vid&eacute;os. A la fois ludiques et hautement informatifs, ils laissent les internautes rarement indiff&eacute;rents. Notre bo&icirc;te &agrave; pixels renferme tout ce qu&rsquo;il faut pour cr&eacute;er de sublimes vid&eacute;os qui refl&egrave;tent parfaitement votre vision, vos ambitions &hellip; et bien entendu votre message !</span></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Arial\"><span style=\"color:#000000\">&Agrave; partir 290&euro;</span></span></span></p>','images/products/videos.png',1);
/*!40000 ALTER TABLE `produit_dd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `produit_et_dernier_inventaire`
--

DROP TABLE IF EXISTS `produit_et_dernier_inventaire`;
/*!50001 DROP VIEW IF EXISTS `produit_et_dernier_inventaire`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `produit_et_dernier_inventaire` AS SELECT 
 1 AS `id`,
 1 AS `date_inventaire`,
 1 AS `qte`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `produit_favori`
--

DROP TABLE IF EXISTS `produit_favori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit_favori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produit_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date_favori` datetime NOT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_18D769F6F347EFB` (`produit_id`),
  KEY `IDX_18D769F619EB6921` (`client_id`),
  CONSTRAINT `FK_18D769F619EB6921` FOREIGN KEY (`client_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_18D769F6F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_favori`
--

LOCK TABLES `produit_favori` WRITE;
/*!40000 ALTER TABLE `produit_favori` DISABLE KEYS */;
INSERT INTO `produit_favori` VALUES (1,1,10,'2022-07-28 06:09:32',1),(2,5,10,'2022-07-28 06:09:47',1);
/*!40000 ALTER TABLE `produit_favori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `produit_qte_stock`
--

DROP TABLE IF EXISTS `produit_qte_stock`;
/*!50001 DROP VIEW IF EXISTS `produit_qte_stock`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `produit_qte_stock` AS SELECT 
 1 AS `id`,
 1 AS `produit_id`,
 1 AS `qte_stock`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `produit_secu`
--

DROP TABLE IF EXISTS `produit_secu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit_secu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secteur_id` int(11) NOT NULL,
  `id_categorie` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_51F5199D9F7E4405` (`secteur_id`),
  KEY `IDX_51F5199DC9486A13` (`id_categorie`),
  CONSTRAINT `FK_51F5199D9F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`),
  CONSTRAINT `FK_51F5199DC9486A13` FOREIGN KEY (`id_categorie`) REFERENCES `categorie_secu` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_secu`
--

LOCK TABLES `produit_secu` WRITE;
/*!40000 ALTER TABLE `produit_secu` DISABLE KEYS */;
INSERT INTO `produit_secu` VALUES (1,1,1,'Hub 2','<p><strong>Unit&eacute;s centrales</strong></p>\r\n\r\n<p>Panneau de contr&ocirc;le avec int&eacute;gration de d&eacute;tecteur avec lev&eacute;e de doute</p>\r\n\r\n<ul>\r\n	<li><strong>Ethernet</strong></li>\r\n	<li><strong>2G</strong></li>\r\n</ul>','images/products/hub-2.PNG',1),(2,1,1,'Hub 2 Plus','<p><strong>Unit&eacute;s centrales</strong></p>\r\n\r\n<p>Panneau de contr&ocirc;le avanc&eacute; avec int&eacute;gration de d&eacute;tecteur avec lev&eacute;e de doute</p>\r\n\r\n<ul>\r\n	<li><strong>Ethernet</strong></li>\r\n	<li><strong>Wi-Fi</strong></li>\r\n	<li><strong>2G/3G/4G</strong></li>\r\n</ul>','images/products/hub-2.PNG',1),(3,1,2,'ReX','<p><strong>Prolongateur de port&eacute;e</strong></p>\r\n\r\n<p>Prolongateur de port&eacute;e de signal radio</p>\r\n\r\n<p><span style=\"font-size:11px\">Jusqu&rsquo;&agrave; 5 ReX peuvent &ecirc;tre connect&eacute;s au syst&egrave;me</span></p>','images/products/rex.PNG',1),(4,1,3,'12V PSU','<p><strong>Unit&eacute; d&rsquo;alimentation</strong></p>\r\n\r\n<p>Bloc d&rsquo;alimentation 12V</p>\r\n\r\n<p><span style=\"font-size:11px\">Optimal pour un fonctionnement basse tension</span></p>','images/products/12v-psu.PNG',1),(5,1,4,'MotionCam','<p><strong>Protection intrusion int&eacute;rieure</strong></p>\r\n\r\n<p>D&eacute;tecteur de mouvement sans fil avec prise de photos en cas d&rsquo;alarmes et immunit&eacute; aux animaux domestiques</p>','images/products/motioncam.PNG',1),(6,1,4,'MotionProtect','<p><strong>Protection intrusion int&eacute;rieure</strong></p>\r\n\r\n<p>D&eacute;tecteur de mouvement sans fil avec immunit&eacute; aux animaux domestiques</p>','images/products/motionprotect.PNG',1),(7,1,4,'MotionProtect Plus','<p><strong>Protection intrusion int&eacute;rieure</strong></p>\r\n\r\n<p>D&eacute;tecteur de mouvement sans fil, double technologie avec immunit&eacute; aux animaux domestiques</p>','images/products/motionprotect.PNG',1),(8,1,4,'CombiProtect','<p><strong>Protection intrusion int&eacute;rieure</strong></p>\r\n\r\n<p>D&eacute;tecteur de mouvement sans fil avec immunit&eacute; aux animaux domestiques, associ&eacute; &agrave; un d&eacute;tecteur bris de vitre</p>','images/products/motionprotect.PNG',1),(9,1,4,'DoorProtect','<p><strong>Protection intrusion int&eacute;rieure</strong></p>\r\n\r\n<p>D&eacute;tecteur d&rsquo;ouverture magn&eacute;tique sans fil</p>','images/products/doorprotect.PNG',1),(10,1,4,'DoorProtect Plus','<p><strong>Protection intrusion int&eacute;rieure</strong></p>\r\n\r\n<p>D&eacute;tecteur d&rsquo;ouverture magn&eacute;tique sans fil avec capteur de vibration et d&rsquo;inclinaison</p>','images/products/doorprotect.PNG',1),(11,1,4,'GlassProtect','<p><strong>Protection intrusion int&eacute;rieure</strong></p>\r\n\r\n<p>D&eacute;tecteur de bris de vitre</p>','images/products/glassprotect.PNG',1),(12,1,5,'MotionCam Outdoor','<p><strong>Protection intrusion ext&eacute;rieure</strong></p>\r\n\r\n<p>D&eacute;tecteur de mouvement d&#39;ext&eacute;rieur sans fil dot&eacute; d&#39;un appareil photo qui permet de v&eacute;rifier les alarmes,</p>','images/products/motioncam-outdoor-removebg-preview.png',1),(13,1,5,'MotionProtect Outdoor','<p><strong>Protection intrusion ext&eacute;rieure</strong></p>\r\n\r\n<p>D&eacute;tecteur de mouvement sans fil ext&eacute;rieur avec anti-masquage et immunit&eacute; aux animaux domestiques</p>','images/products/motionprotect-outdoor-removebg-preview.png',1),(14,1,5,'DualCurtain Outdoor','<p><strong>Protection intrusion ext&eacute;rieure</strong></p>\r\n\r\n<p>Surveille le p&eacute;rim&egrave;tre du local &agrave; prot&eacute;ger, sans g&ecirc;ner les personnes se trouvant &agrave; l&#39;int&eacute;rieur. Deux syst&egrave;mes optiques ind&eacute;pendants avec des champs de d&eacute;tection &eacute;troits et des param&egrave;tres modulables vous permettent de d&eacute;finir avec pr&eacute;cision une zone de d&eacute;tection sur une distance de 30 m, tout en &eacute;vitant les fausses alarmes. Le programme unique ELSA r&eacute;agit en cas d&#39;intrusion, et filtre les d&eacute;clencheurs tels que les interf&eacute;rences environnementales et les animaux domestiques.</p>','images/products/dualcurtain-outdoor-removebg-preview.png',1),(15,1,6,'SpaceControl','<p><strong>Commandes</strong></p>\r\n\r\n<p>T&eacute;l&eacute;commande bidirectionnelle sans fil avec bouton panique</p>','images/products/spacecontrol.PNG',1),(16,1,6,'Button','<p><strong>Commandes</strong></p>\r\n\r\n<p>Bouton de panique sans fil / t&eacute;l&eacute;commande pour le contr&ocirc;le des sc&eacute;narios</p>','images/products/button.PNG',1),(17,1,6,'DoubleButton','<p><strong>Commandes</strong></p>\r\n\r\n<p>T&eacute;l&eacute;commande panique</p>','images/products/doublebutton.PNG',1),(18,1,6,'KeyPad','<p><strong>Commandes</strong></p>\r\n\r\n<p>Clavier tactile Bidirectionnel sans fil</p>','images/products/keypad.PNG',1),(19,1,6,'KeyPad Plus','<p><strong>Commandes</strong></p>\r\n\r\n<p>Clavier tactile avec lecteur de badges Bidirectionnel sans fil</p>','images/products/keypad-plus.PNG',1),(20,1,7,'FireProtect','<p><strong>Pr&eacute;vention des incendies &amp; des inondations</strong></p>\r\n\r\n<p>D&eacute;tecteur de fum&eacute;e et de chaleur sans fil</p>','images/products/fireprotect.PNG',1),(21,1,7,'FireProtect Plus','<p><strong>Pr&eacute;vention des incendies &amp; des inondations</strong></p>\r\n\r\n<p>D&eacute;tecteur de fum&eacute;e, de chaleur et de monoxyde de carbone sans fil</p>','images/products/fireprotect.PNG',1),(22,1,7,'LeaksProtect','<p><strong>Pr&eacute;vention des incendies &amp; des inondations</strong></p>\r\n\r\n<p>D&eacute;tecteur d&rsquo;inondation sans fil</p>','images/products/leaksprotect.PNG',1),(23,1,8,'HomeSiren','<p><strong>Sir&egrave;nes</strong></p>\r\n\r\n<p>Sir&egrave;ne int&eacute;rieure sans fil</p>','images/products/homesiren.PNG',1),(24,1,8,'StreetSiren','<p><strong>Sir&egrave;nes</strong></p>\r\n\r\n<p>Sir&egrave;ne ext&eacute;rieure avec flash sans fil</p>\r\n\r\n<p>&nbsp;</p>','images/products/streetsiren.PNG',1),(25,1,8,'StreetSiren DoubleDeck','<p><strong>Sir&egrave;nes</strong></p>\r\n\r\n<p>Sir&egrave;ne ext&eacute;rieure avec flash sans fil &amp; logo</p>','images/products/streetsiren-doublechek.PNG',1),(26,1,9,'Socket','<p><strong>Domotique</strong></p>\r\n\r\n<p>Prise intelligente sans fil avec contr&ocirc;le d&rsquo;&eacute;nergie</p>','images/products/socket.PNG',1),(27,1,10,'Applications gratuites intuitives','<p><strong>Application</strong></p>\r\n\r\n<p>Alarmes envoy&eacute;es par notifications push, SMS</p>','images/products/application.PNG',1);
/*!40000 ALTER TABLE `produit_secu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit_secu_accomp`
--

DROP TABLE IF EXISTS `produit_secu_accomp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit_secu_accomp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secteur_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E626D4219F7E4405` (`secteur_id`),
  CONSTRAINT `FK_E626D4219F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_secu_accomp`
--

LOCK TABLES `produit_secu_accomp` WRITE;
/*!40000 ALTER TABLE `produit_secu_accomp` DISABLE KEYS */;
INSERT INTO `produit_secu_accomp` VALUES (1,1,'Clavier',NULL,'images/products/1-keypad.jpeg',1,199),(2,1,'Contact ouverture',NULL,'images/products/2-contact-protect.png',1,129),(3,1,'Détecteur de mouvement image blanc',NULL,'images/products/3-motion-cam.png',1,129),(4,1,'Scream',NULL,'images/products/4-scream.png',1,199),(5,1,'Smoke Protect',NULL,'images/products/5-smoke-protect.jpg',1,129),(6,1,'Motion Outdoor',NULL,'images/products/6-motion-outdoor.png',1,399),(7,1,'Flood Protect',NULL,'images/products/7-flood-protect.jpg',1,129),(8,1,'Tags X3',NULL,'images/products/8-tags-x3.jpg',1,49),(9,1,'Space Control',NULL,'images/products/9-space-control.jpg',1,69),(10,1,'Easy Life',NULL,'images/products/10-easy-life.png',1,99),(11,1,'Button Panic',NULL,'images/products/11-button-panic.jpg',1,129),(12,1,'Centrale',NULL,'images/products/12-repeater.jpeg',1,199),(13,1,'Sirène',NULL,'images/products/13-sirene.jpeg',1,129);
/*!40000 ALTER TABLE `produit_secu_accomp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit_secu_favori`
--

DROP TABLE IF EXISTS `produit_secu_favori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit_secu_favori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produit_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date_favori` datetime NOT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4F15B60AF347EFB` (`produit_id`),
  KEY `IDX_4F15B60A19EB6921` (`client_id`),
  CONSTRAINT `FK_4F15B60A19EB6921` FOREIGN KEY (`client_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_4F15B60AF347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit_secu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_secu_favori`
--

LOCK TABLES `produit_secu_favori` WRITE;
/*!40000 ALTER TABLE `produit_secu_favori` DISABLE KEYS */;
/*!40000 ALTER TABLE `produit_secu_favori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `qte_mouvement_apres_dernier_inventaire`
--

DROP TABLE IF EXISTS `qte_mouvement_apres_dernier_inventaire`;
/*!50001 DROP VIEW IF EXISTS `qte_mouvement_apres_dernier_inventaire`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `qte_mouvement_apres_dernier_inventaire` AS SELECT 
 1 AS `id`,
 1 AS `qte_mouvement`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rformation_categorie`
--

DROP TABLE IF EXISTS `rformation_categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rformation_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formation_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_53D1F9BF5200282E` (`formation_id`),
  KEY `IDX_53D1F9BFBCF5E72D` (`categorie_id`),
  CONSTRAINT `FK_53D1F9BF5200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`),
  CONSTRAINT `FK_53D1F9BFBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie_formation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rformation_categorie`
--

LOCK TABLES `rformation_categorie` WRITE;
/*!40000 ALTER TABLE `rformation_categorie` DISABLE KEYS */;
INSERT INTO `rformation_categorie` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,2),(5,6,1),(6,7,2);
/*!40000 ALTER TABLE `rformation_categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secteur`
--

DROP TABLE IF EXISTS `secteur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `secteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `IDX_8045251FC54C8C93` (`type_id`),
  CONSTRAINT `FK_8045251FC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type_secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secteur`
--

LOCK TABLES `secteur` WRITE;
/*!40000 ALTER TABLE `secteur` DISABLE KEYS */;
INSERT INTO `secteur` VALUES (1,3,'Sécurité',NULL,1),(2,2,'Digital',NULL,1),(3,1,'Assurance',NULL,1),(4,1,'Immobilier',NULL,1),(5,1,'Energie',NULL,1),(6,1,'MLM',NULL,1),(7,1,'Produits',NULL,1);
/*!40000 ALTER TABLE `secteur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `secteur_active`
--

DROP TABLE IF EXISTS `secteur_active`;
/*!50001 DROP VIEW IF EXISTS `secteur_active`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `secteur_active` AS SELECT 
 1 AS `id`,
 1 AS `type_id`,
 1 AS `nom`,
 1 AS `description`,
 1 AS `active`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stat_vente_admin`
--

DROP TABLE IF EXISTS `stat_vente_admin`;
/*!50001 DROP VIEW IF EXISTS `stat_vente_admin`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stat_vente_admin` AS SELECT 
 1 AS `nbr_ventes`,
 1 AS `ca`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stat_vente_agent`
--

DROP TABLE IF EXISTS `stat_vente_agent`;
/*!50001 DROP VIEW IF EXISTS `stat_vente_agent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stat_vente_agent` AS SELECT 
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `nbr_ventes`,
 1 AS `ca`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stat_vente_dd_agent`
--

DROP TABLE IF EXISTS `stat_vente_dd_agent`;
/*!50001 DROP VIEW IF EXISTS `stat_vente_dd_agent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stat_vente_dd_agent` AS SELECT 
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `nbr_ventes`,
 1 AS `ca`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stat_vente_dd_tout_agent`
--

DROP TABLE IF EXISTS `stat_vente_dd_tout_agent`;
/*!50001 DROP VIEW IF EXISTS `stat_vente_dd_tout_agent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stat_vente_dd_tout_agent` AS SELECT 
 1 AS `id`,
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `nbr_ventes`,
 1 AS `ca`,
 1 AS `type_secteur_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stat_vente_ecommerce_agent`
--

DROP TABLE IF EXISTS `stat_vente_ecommerce_agent`;
/*!50001 DROP VIEW IF EXISTS `stat_vente_ecommerce_agent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stat_vente_ecommerce_agent` AS SELECT 
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `nbr_ventes`,
 1 AS `ca`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stat_vente_ecommerce_tout_agent`
--

DROP TABLE IF EXISTS `stat_vente_ecommerce_tout_agent`;
/*!50001 DROP VIEW IF EXISTS `stat_vente_ecommerce_tout_agent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stat_vente_ecommerce_tout_agent` AS SELECT 
 1 AS `id`,
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `nbr_ventes`,
 1 AS `ca`,
 1 AS `type_secteur_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stat_vente_secteur`
--

DROP TABLE IF EXISTS `stat_vente_secteur`;
/*!50001 DROP VIEW IF EXISTS `stat_vente_secteur`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stat_vente_secteur` AS SELECT 
 1 AS `secteur_id`,
 1 AS `nbr_ventes`,
 1 AS `ca`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stat_vente_secu_agent`
--

DROP TABLE IF EXISTS `stat_vente_secu_agent`;
/*!50001 DROP VIEW IF EXISTS `stat_vente_secu_agent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stat_vente_secu_agent` AS SELECT 
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `nbr_ventes`,
 1 AS `ca`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stat_vente_secu_tout_agent`
--

DROP TABLE IF EXISTS `stat_vente_secu_tout_agent`;
/*!50001 DROP VIEW IF EXISTS `stat_vente_secu_tout_agent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stat_vente_secu_tout_agent` AS SELECT 
 1 AS `id`,
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `nbr_ventes`,
 1 AS `ca`,
 1 AS `type_secteur_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stat_vente_tout_agent`
--

DROP TABLE IF EXISTS `stat_vente_tout_agent`;
/*!50001 DROP VIEW IF EXISTS `stat_vente_tout_agent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stat_vente_tout_agent` AS SELECT 
 1 AS `id`,
 1 AS `agent_id`,
 1 AS `secteur_id`,
 1 AS `nbr_ventes`,
 1 AS `ca`,
 1 AS `type_secteur_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `subscription_plan_agent_account`
--

DROP TABLE IF EXISTS `subscription_plan_agent_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscription_plan_agent_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `plan_agent_account_id` int(11) DEFAULT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_subscription_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_custumer_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_price_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_product_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `stripe_subscription_interval` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_subscription_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_price_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_data` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  KEY `IDX_A838C211A76ED395` (`user_id`),
  KEY `IDX_A838C2115D70B8B9` (`plan_agent_account_id`),
  CONSTRAINT `FK_A838C2115D70B8B9` FOREIGN KEY (`plan_agent_account_id`) REFERENCES `plan_agent_account` (`id`),
  CONSTRAINT `FK_A838C211A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription_plan_agent_account`
--

LOCK TABLES `subscription_plan_agent_account` WRITE;
/*!40000 ALTER TABLE `subscription_plan_agent_account` DISABLE KEYS */;
INSERT INTO `subscription_plan_agent_account` VALUES (1,21,2,'agentabonnement@gmail.com','sub_1LSnMPIXp7HGskyiVjYUlJzZ','cus_MB9fydnVZ0rq4p','price_1LSn8eIXp7HGskyiWkdq0nRe','prod_planCompteAgent',29700,'month','active','2022-08-03 19:36:09',NULL,'62eace2929308','Plusieurs secteurs','a:7:{s:22:\"stripe_subscription_id\";s:28:\"sub_1LSnMPIXp7HGskyiVjYUlJzZ\";s:18:\"stripe_customer_id\";s:18:\"cus_MB9fydnVZ0rq4p\";s:15:\"stripe_price_id\";s:30:\"price_1LSn8eIXp7HGskyiWkdq0nRe\";s:17:\"stripe_product_id\";s:20:\"prod_planCompteAgent\";s:13:\"stripe_amount\";i:29700;s:28:\"stripe_subscription_interval\";s:5:\"month\";s:26:\"stripe_subscription_status\";s:6:\"active\";}'),(2,22,1,'princierakotoarivony4@gmail.com','sub_1LcmLNIXp7HGskyiv46H9FGa','cus_MLTHdpHnnshEoU','price_1LSn7hIXp7HGskyipckPdnYO','prod_planCompteAgent',97,'month','active','2022-08-31 08:32:20',NULL,'630f1c9466d4a','Un secteur','a:7:{s:22:\"stripe_subscription_id\";s:28:\"sub_1LcmLNIXp7HGskyiv46H9FGa\";s:18:\"stripe_customer_id\";s:18:\"cus_MLTHdpHnnshEoU\";s:15:\"stripe_price_id\";s:30:\"price_1LSn7hIXp7HGskyipckPdnYO\";s:17:\"stripe_product_id\";s:20:\"prod_planCompteAgent\";s:13:\"stripe_amount\";i:9700;s:28:\"stripe_subscription_interval\";s:5:\"month\";s:26:\"stripe_subscription_status\";s:6:\"active\";}'),(3,25,1,'agentassurance2@gmail.com','sub_1LfKJ8IXp7HGskyipXDvd7r4','cus_MO6Wi98G6gNWDI','price_1LSn7hIXp7HGskyipckPdnYO','prod_planCompteAgent',97,'month','active','2022-09-07 09:12:34',NULL,'631860820aa25','Un secteur','a:7:{s:22:\"stripe_subscription_id\";s:28:\"sub_1LfKJ8IXp7HGskyipXDvd7r4\";s:18:\"stripe_customer_id\";s:18:\"cus_MO6Wi98G6gNWDI\";s:15:\"stripe_price_id\";s:30:\"price_1LSn7hIXp7HGskyipckPdnYO\";s:17:\"stripe_product_id\";s:20:\"prod_planCompteAgent\";s:13:\"stripe_amount\";i:9700;s:28:\"stripe_subscription_interval\";s:5:\"month\";s:26:\"stripe_subscription_status\";s:6:\"active\";}');
/*!40000 ALTER TABLE `subscription_plan_agent_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `couleur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'Chaud',NULL,'warning'),(2,'Intéréssé',NULL,'success'),(3,'Froid',NULL,'info'),(4,'Non intéressé',NULL,'danger');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag_contact`
--

DROP TABLE IF EXISTS `tag_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag_contact` (
  `tag_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`,`contact_id`),
  KEY `IDX_7E53CB92BAD26311` (`tag_id`),
  KEY `IDX_7E53CB92E7A1254A` (`contact_id`),
  CONSTRAINT `FK_7E53CB92BAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_7E53CB92E7A1254A` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_contact`
--

LOCK TABLES `tag_contact` WRITE;
/*!40000 ALTER TABLE `tag_contact` DISABLE KEYS */;
INSERT INTO `tag_contact` VALUES (1,2),(2,1);
/*!40000 ALTER TABLE `tag_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tva_secu`
--

DROP TABLE IF EXISTS `tva_secu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tva_secu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valeur` decimal(5,2) NOT NULL,
  `secteur_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E2429A999F7E4405` (`secteur_id`),
  CONSTRAINT `FK_E2429A999F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tva_secu`
--

LOCK TABLES `tva_secu` WRITE;
/*!40000 ALTER TABLE `tva_secu` DISABLE KEYS */;
INSERT INTO `tva_secu` VALUES (1,'particulier avec maison plus de 2 ans',10.00,1,3),(2,'particulier avec maison moins de 2 ans',20.00,1,2),(3,'professionnel',20.00,1,1);
/*!40000 ALTER TABLE `tva_secu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_abonnement_secu`
--

DROP TABLE IF EXISTS `type_abonnement_secu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_abonnement_secu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_abonnement_secu`
--

LOCK TABLES `type_abonnement_secu` WRITE;
/*!40000 ALTER TABLE `type_abonnement_secu` DISABLE KEYS */;
INSERT INTO `type_abonnement_secu` VALUES (1,'Sans abonnement',NULL,1299),(2,'Avec abonnement',NULL,699);
/*!40000 ALTER TABLE `type_abonnement_secu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_installation_secu`
--

DROP TABLE IF EXISTS `type_installation_secu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_installation_secu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_installation_secu`
--

LOCK TABLES `type_installation_secu` WRITE;
/*!40000 ALTER TABLE `type_installation_secu` DISABLE KEYS */;
INSERT INTO `type_installation_secu` VALUES (1,'Je veux faire l’installation moi-même',0),(2,'Un installateur se déplace chez moi',150);
/*!40000 ALTER TABLE `type_installation_secu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_logement`
--

DROP TABLE IF EXISTS `type_logement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_logement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_logement`
--

LOCK TABLES `type_logement` WRITE;
/*!40000 ALTER TABLE `type_logement` DISABLE KEYS */;
/*!40000 ALTER TABLE `type_logement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_secteur`
--

DROP TABLE IF EXISTS `type_secteur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_secteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_secteur`
--

LOCK TABLES `type_secteur` WRITE;
/*!40000 ALTER TABLE `type_secteur` DISABLE KEYS */;
INSERT INTO `type_secteur` VALUES (1,'E-commerce'),(2,'Demande de devis'),(3,'Sécurité');
/*!40000 ALTER TABLE `type_secteur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_client_id` int(11) DEFAULT NULL,
  `client_agent_id` int(11) DEFAULT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_naissance` datetime DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_securite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rib` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `six_digit_code` int(11) DEFAULT NULL,
  `forgotten_pass_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `code_postal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lien_calendly` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_data` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '(DC2Type:array)',
  `account_status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_start_date` datetime DEFAULT NULL,
  `stripe_customer_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  KEY `IDX_8D93D649771A4A5A` (`contact_client_id`),
  KEY `IDX_8D93D6491AF241CE` (`client_agent_id`),
  CONSTRAINT `FK_8D93D6491AF241CE` FOREIGN KEY (`client_agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_8D93D649771A4A5A` FOREIGN KEY (`contact_client_id`) REFERENCES `contact` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,NULL,NULL,'admin@gmail.com','admin','[\"ROLE_ADMINISTRATEUR\"]','$2y$13$YKwVY3JqHg0qwClKPcBVqOlJjnEO4GvtVGunu1c5nAkUqy.Fy5SCi','Administrateur',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,NULL,NULL,'coachsecurite@gmail.com',NULL,'[\"ROLE_COACH\"]','$2y$13$YKwVY3JqHg0qwClKPcBVqOlJjnEO4GvtVGunu1c5nAkUqy.Fy5SCi','Coach','Sécurité','1992-12-31 00:00:00','Paris','123465','4242424242424242',NULL,NULL,NULL,1,NULL,NULL,'2022-07-19 07:47:17',NULL,'https://calendly.com/mnakanyandriamihaja','a:0:{}',NULL,NULL,NULL),(3,NULL,NULL,'coachdigital@gmail.com',NULL,'[\"ROLE_COACH\"]','$2y$13$YKwVY3JqHg0qwClKPcBVqOlJjnEO4GvtVGunu1c5nAkUqy.Fy5SCi','Coach','Digital','1991-12-30 00:00:00','Paris','123465','4242424242424242',NULL,NULL,NULL,1,NULL,NULL,'2022-07-19 07:49:29',NULL,'https://calendly.com/mnakanyandriamihaja','a:0:{}',NULL,NULL,NULL),(4,NULL,NULL,'coachproduit@gmail.com',NULL,'[\"ROLE_COACH\"]','$2y$13$YKwVY3JqHg0qwClKPcBVqOlJjnEO4GvtVGunu1c5nAkUqy.Fy5SCi','Coach','Produit','1981-10-30 00:00:00','Paris','123465','4242424242424242',NULL,NULL,NULL,1,NULL,NULL,'2022-07-19 07:52:30',NULL,NULL,'a:0:{}',NULL,NULL,NULL),(5,NULL,NULL,'agentsecurite@gmail.com','agentsecurite@gmail.com','[\"ROLE_AGENT\"]','$2y$13$YKwVY3JqHg0qwClKPcBVqOlJjnEO4GvtVGunu1c5nAkUqy.Fy5SCi','Agent','sécurité',NULL,'Antananarivo',NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2022-07-19 07:58:37','00101','https://calendly.com/xxx-xxx','a:5:{s:12:\"stripe_brand\";s:4:\"visa\";s:12:\"stripe_last4\";s:4:\"4242\";s:17:\"stripe_charges_id\";s:27:\"ch_3LNBNjIXp7HGskyi057mlJLy\";s:13:\"stripe_status\";s:9:\"succeeded\";s:20:\"stripe_client_secret\";s:60:\"pi_3LNBNjIXp7HGskyi0R2v1qUz_secret_mJZ3aTXOp61ygTgzCLKqRLPAc\";}','Actif','2022-07-20 06:24:17',NULL),(6,NULL,NULL,'agentdigital@gmail.com','agentdigital@gmail.com','[\"ROLE_AGENT\"]','$2y$13$YKwVY3JqHg0qwClKPcBVqOlJjnEO4GvtVGunu1c5nAkUqy.Fy5SCi','Agent','digital',NULL,'Antananarivo',NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2022-07-19 07:58:37','00101',NULL,'a:5:{s:12:\"stripe_brand\";s:4:\"visa\";s:12:\"stripe_last4\";s:4:\"4242\";s:17:\"stripe_charges_id\";s:27:\"ch_3LNBNjIXp7HGskyi057mlJLy\";s:13:\"stripe_status\";s:9:\"succeeded\";s:20:\"stripe_client_secret\";s:60:\"pi_3LNBNjIXp7HGskyi0R2v1qUz_secret_mJZ3aTXOp61ygTgzCLKqRLPAc\";}','Actif','2022-08-02 17:04:37',NULL),(7,NULL,NULL,'agentproduit@gmail.com','agentproduit@gmail.com','[\"ROLE_AGENT\"]','$2y$13$YKwVY3JqHg0qwClKPcBVqOlJjnEO4GvtVGunu1c5nAkUqy.Fy5SCi','Agent','produit',NULL,'Antananarivo',NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2022-07-19 07:58:37','00101',NULL,'a:5:{s:12:\"stripe_brand\";s:4:\"visa\";s:12:\"stripe_last4\";s:4:\"4242\";s:17:\"stripe_charges_id\";s:27:\"ch_3LNBNjIXp7HGskyi057mlJLy\";s:13:\"stripe_status\";s:9:\"succeeded\";s:20:\"stripe_client_secret\";s:60:\"pi_3LNBNjIXp7HGskyi0R2v1qUz_secret_mJZ3aTXOp61ygTgzCLKqRLPAc\";}','Actif','2022-07-20 06:10:48',NULL),(8,NULL,NULL,'document@gmail.com','document','[\"ROLE_DOCUMENT_OWNER\"]','$2y$13$YKwVY3JqHg0qwClKPcBVqOlJjnEO4GvtVGunu1c5nAkUqy.Fy5SCi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,NULL,5,'clientsecurite@gmail.com','clientsecurite','[\"ROLE_CLIENT\"]','$2y$13$YKwVY3JqHg0qwClKPcBVqOlJjnEO4GvtVGunu1c5nAkUqy.Fy5SCi','Client','sécurité',NULL,'Tana',NULL,NULL,NULL,NULL,NULL,1,NULL,'03444121212','2022-07-20 06:29:05','00101',NULL,'a:0:{}',NULL,NULL,NULL),(10,NULL,7,'clientproduit@gmail.com','clientproduit','[\"ROLE_CLIENT\"]','$2y$13$YKwVY3JqHg0qwClKPcBVqOlJjnEO4GvtVGunu1c5nAkUqy.Fy5SCi','Client','produit',NULL,'Tana',NULL,NULL,NULL,NULL,NULL,1,NULL,'0343434434','2022-07-20 07:00:35','00101',NULL,'a:0:{}',NULL,NULL,NULL),(11,NULL,NULL,'coachimmobilier@gmail.com',NULL,'[\"ROLE_COACH\"]','$2y$13$YKwVY3JqHg0qwClKPcBVqOlJjnEO4GvtVGunu1c5nAkUqy.Fy5SCi','Coach','Immobilier','2000-05-07 00:00:00','Tana','24242','4242424242424242',NULL,NULL,NULL,1,NULL,NULL,'2022-07-28 06:26:07',NULL,NULL,'a:0:{}',NULL,NULL,NULL),(12,NULL,NULL,'agentimmobilier@gmail.com','agentimmobilier','[\"ROLE_AGENT\"]','$2y$13$YKwVY3JqHg0qwClKPcBVqOlJjnEO4GvtVGunu1c5nAkUqy.Fy5SCi','Agent','Immobilier',NULL,'Tana',NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331331','2022-07-28 06:35:53','00101',NULL,'a:0:{}','Actif',NULL,NULL),(13,NULL,NULL,'nouveauagentsecurite@gmail.com','nouveauagentsecurite','[\"ROLE_AGENT\"]','$2y$13$/REm6jhIhRkuhf6rnCI9IuNR1NSCG4ktrd3p7k2E.Fi60r3jDC4y2','Nouveau agent','securite',NULL,'France',NULL,NULL,NULL,NULL,NULL,1,NULL,'0341212112','2022-08-01 09:39:00','00101',NULL,'a:0:{}','Actif',NULL,NULL),(14,NULL,NULL,'agentmultisecteur@gmail.com','agentmultisecteur','[\"ROLE_AGENT\"]','$2y$13$i0/sQ1FPn42qdBmAo2rw/OfOpkQjSloVRsPLzaaqxW8jXnc5Dl0n.','multisecteur','agent',NULL,'Tana',NULL,NULL,NULL,NULL,NULL,1,NULL,'0343434434','2022-08-02 06:38:57','00101',NULL,'a:5:{s:12:\"stripe_brand\";s:4:\"visa\";s:12:\"stripe_last4\";s:4:\"4242\";s:17:\"stripe_charges_id\";s:27:\"ch_3LSEkpIXp7HGskyi1gh0qnCg\";s:13:\"stripe_status\";s:9:\"succeeded\";s:20:\"stripe_client_secret\";s:60:\"pi_3LSEkpIXp7HGskyi1LTakNbp_secret_RPMj9WHWQG0Aw7ujbxs8Uz8Ok\";}','Actif','2022-08-02 06:39:54',NULL),(15,NULL,NULL,'nouveauagent@gmail.com','nouveauagent','[\"ROLE_AGENT\"]','$2y$13$Z94zUXyEiLX3jhMfXfGyXumEg9gSG39ZAQqxeABra9JY6uVg.reXG','Nouveau agent','securite',NULL,'France',NULL,NULL,NULL,NULL,NULL,1,NULL,'+2618922389','2022-08-02 09:17:14','97000',NULL,'a:0:{}','Actif','2022-09-02 06:53:09',NULL),(16,NULL,NULL,'nouveauagent2@gmail.com','nouveauagent2','[\"ROLE_AGENT\"]','$2y$13$Qh2Vtm74V7dQHT0on2tEfOROQjdhrfWo2.bhqmxKnwFvzeFsju6Ua','Nouveau','agent',NULL,'Paris',NULL,NULL,NULL,998163,'95DVcCEz8j00B04J7Ek4dc9PEKlDy-_-qK0oUn881jY',1,NULL,'98','2022-08-02 11:05:51','97000',NULL,'a:0:{}','Actif',NULL,NULL),(17,NULL,6,'mnakanyandriamihaja@gmail.com','clientdigital','[\"ROLE_CLIENT\"]','$2y$13$/83qsc3EaQcSmcnrISxpKu1Y.udbDQRLXg9/5O6qHpkyIsfNxevoO','Client','Digital',NULL,'Paris',NULL,NULL,NULL,NULL,NULL,1,NULL,'0343444434','2022-08-02 17:08:44','97000',NULL,'a:0:{}',NULL,NULL,NULL),(18,NULL,NULL,'agentcreesecu@gmail.com','agentcreesecu','[\"ROLE_AGENT\"]','$2y$13$otUInnDwVOGcNkVaPgzPTeEZjC9k9DwsCsqjAzx.wlCRhMEwOKKru','Agent créé','secu',NULL,'Paris',NULL,NULL,NULL,NULL,NULL,1,NULL,'0343444423','2022-08-03 07:21:53','97000',NULL,'a:0:{}','Actif',NULL,NULL),(19,NULL,NULL,'agentmulti2@gmail.com','agentmulti2','[\"ROLE_AGENT\"]','$2y$13$0BbndqUE3GMTHhgnZ3lj5OsK3v1X0.qenArxGyve24a4VjwCM1A9y','Agent multi 2','nouveau',NULL,'Paris',NULL,NULL,NULL,NULL,NULL,1,NULL,'0343422242','2022-08-03 19:02:04','97000',NULL,'a:0:{}','Impaye',NULL,NULL),(20,NULL,NULL,'nouveaucoachtsisyanarana@gmail.com','tsisyanarana@gmail.com','[\"ROLE_COACH\"]','$2y$13$ooN/ZbKSi.nXA3V5RuKbzu1UCNvi2f.QIkWe/pZFnTu7c4hUaJSUO','Nouveau coach',NULL,'2000-05-27 00:00:00','Paris 70 arrondissement','1000','4242424242424242',NULL,NULL,NULL,1,NULL,NULL,'2022-08-03 19:16:07',NULL,'https://calendly.com/mnakanyandriamihaja','a:0:{}',NULL,NULL,NULL),(21,NULL,NULL,'agentabonnement@gmail.com','agentabonnement','[\"ROLE_AGENT\"]','$2y$13$01IQa2dIoGHpvrdYaJnVBuYJrKZ9q/EESniuzxVHA12XcSF4g2M2O','agent','abonnement',NULL,'Paris',NULL,NULL,NULL,NULL,NULL,1,NULL,'0341345590','2022-08-03 19:35:17','97000',NULL,'a:0:{}','Actif','2022-08-03 19:40:36','cus_MB9fydnVZ0rq4p'),(22,NULL,NULL,'princierakotoarivony4@gmail.com','agentmlm','[\"ROLE_AGENT\"]','$2y$13$sIxPCYcFdx4AiS0/r8oU4uohbe9aq4bA31/jgyOP5xQPzplr40gjm','Rakotoarivony','Princie',NULL,'IJ6 Anjomakely',NULL,NULL,NULL,NULL,NULL,1,NULL,'0344088245','2022-08-31 08:28:37','BP612','https://calendly.com/mnakanyandriamihaja','a:0:{}','Actif','2022-08-31 08:33:14','cus_MLTHdpHnnshEoU'),(23,NULL,NULL,'coachassurance@gmail.com','coachassurance','[\"ROLE_COACH\"]','$2y$13$nT6SK6aoWvSRXVYePgEVFev8QlCF/dD/WKDFbgcFCXV/zOTVkTZlW','Assurance','Coach','1992-06-11 00:00:00','Antananarivo','123465','22323232319',NULL,NULL,NULL,1,NULL,NULL,'2022-09-02 06:12:17',NULL,NULL,'a:0:{}',NULL,NULL,NULL),(24,NULL,NULL,'coachassurance2@gmail.com','coachassurance2@gmail','[\"ROLE_COACH\"]','$2y$13$jeA.5eBrLPubKtrnbtKtl.w9y5stcNyiODK5EzmfHVFWZKQwDASfK','Assurance2','coach','1986-12-12 00:00:00','Paris','123','424242424242',NULL,NULL,NULL,1,NULL,NULL,'2022-09-06 06:07:33',NULL,'https://calendly.com/mnakanyandriamihaja','a:0:{}',NULL,'2022-09-06 07:35:15',NULL),(25,NULL,NULL,'agentassurance2@gmail.com','agentassurance2','[\"ROLE_AGENT\"]','$2y$13$f.9F8P/Bh6HcdsBmtyMyj.G0DQJR2ZvVw1dMBUaaPv/4Se6Z2K8cu','assurance2','agent',NULL,'Antananarivo',NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2022-09-07 09:12:00','00101',NULL,'a:0:{}','Actif','2022-09-07 09:13:57','cus_MO6Wi98G6gNWDI');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_formation`
--

DROP TABLE IF EXISTS `video_formation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_formation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `uri` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_823F5C2AA76ED395` (`user_id`),
  CONSTRAINT `FK_823F5C2AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_formation`
--

LOCK TABLES `video_formation` WRITE;
/*!40000 ALTER TABLE `video_formation` DISABLE KEYS */;
/*!40000 ALTER TABLE `video_formation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `active_agent`
--

/*!50001 DROP VIEW IF EXISTS `active_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `active_agent` AS select `active_user`.`id` AS `id`,`active_user`.`contact_client_id` AS `contact_client_id`,`active_user`.`client_agent_id` AS `client_agent_id`,`active_user`.`email` AS `email`,`active_user`.`username` AS `username`,`active_user`.`roles` AS `roles`,`active_user`.`password` AS `password`,`active_user`.`nom` AS `nom`,`active_user`.`prenom` AS `prenom`,`active_user`.`date_naissance` AS `date_naissance`,`active_user`.`adresse` AS `adresse`,`active_user`.`numero_securite` AS `numero_securite`,`active_user`.`rib` AS `rib`,`active_user`.`photo` AS `photo`,`active_user`.`six_digit_code` AS `six_digit_code`,`active_user`.`forgotten_pass_token` AS `forgotten_pass_token`,`active_user`.`active` AS `active`,`active_user`.`api_token` AS `api_token`,`active_user`.`telephone` AS `telephone`,`active_user`.`created_at` AS `created_at`,`active_user`.`code_postal` AS `code_postal`,`active_user`.`lien_calendly` AS `lien_calendly`,`active_user`.`stripe_data` AS `stripe_data`,`active_user`.`account_status` AS `account_status`,`active_user`.`account_start_date` AS `account_start_date`,`active_user`.`stripe_customer_id` AS `stripe_customer_id` from `active_user` where json_contains(`active_user`.`roles`,'"ROLE_AGENT"','$') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `active_clients`
--

/*!50001 DROP VIEW IF EXISTS `active_clients`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `active_clients` AS select `active_user`.`id` AS `id`,`active_user`.`contact_client_id` AS `contact_client_id`,`active_user`.`client_agent_id` AS `client_agent_id`,`active_user`.`email` AS `email`,`active_user`.`username` AS `username`,`active_user`.`roles` AS `roles`,`active_user`.`password` AS `password`,`active_user`.`nom` AS `nom`,`active_user`.`prenom` AS `prenom`,`active_user`.`date_naissance` AS `date_naissance`,`active_user`.`adresse` AS `adresse`,`active_user`.`numero_securite` AS `numero_securite`,`active_user`.`rib` AS `rib`,`active_user`.`photo` AS `photo`,`active_user`.`six_digit_code` AS `six_digit_code`,`active_user`.`forgotten_pass_token` AS `forgotten_pass_token`,`active_user`.`active` AS `active`,`active_user`.`api_token` AS `api_token`,`active_user`.`telephone` AS `telephone`,`active_user`.`created_at` AS `created_at`,`active_user`.`code_postal` AS `code_postal`,`active_user`.`lien_calendly` AS `lien_calendly`,`active_user`.`stripe_data` AS `stripe_data`,`active_user`.`account_status` AS `account_status`,`active_user`.`account_start_date` AS `account_start_date`,`active_user`.`stripe_customer_id` AS `stripe_customer_id` from `active_user` where json_contains(`active_user`.`roles`,'"ROLE_CLIENT"','$') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `active_coach`
--

/*!50001 DROP VIEW IF EXISTS `active_coach`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `active_coach` AS select `active_user`.`id` AS `id`,`active_user`.`contact_client_id` AS `contact_client_id`,`active_user`.`client_agent_id` AS `client_agent_id`,`active_user`.`email` AS `email`,`active_user`.`username` AS `username`,`active_user`.`roles` AS `roles`,`active_user`.`password` AS `password`,`active_user`.`nom` AS `nom`,`active_user`.`prenom` AS `prenom`,`active_user`.`date_naissance` AS `date_naissance`,`active_user`.`adresse` AS `adresse`,`active_user`.`numero_securite` AS `numero_securite`,`active_user`.`rib` AS `rib`,`active_user`.`photo` AS `photo`,`active_user`.`six_digit_code` AS `six_digit_code`,`active_user`.`forgotten_pass_token` AS `forgotten_pass_token`,`active_user`.`active` AS `active`,`active_user`.`api_token` AS `api_token`,`active_user`.`telephone` AS `telephone`,`active_user`.`created_at` AS `created_at`,`active_user`.`code_postal` AS `code_postal`,`active_user`.`lien_calendly` AS `lien_calendly`,`active_user`.`stripe_data` AS `stripe_data`,`active_user`.`account_status` AS `account_status`,`active_user`.`account_start_date` AS `account_start_date`,`active_user`.`stripe_customer_id` AS `stripe_customer_id` from `active_user` where json_contains(`active_user`.`roles`,'"ROLE_COACH"','$') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `active_user`
--

/*!50001 DROP VIEW IF EXISTS `active_user`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `active_user` AS select `user`.`id` AS `id`,`user`.`contact_client_id` AS `contact_client_id`,`user`.`client_agent_id` AS `client_agent_id`,`user`.`email` AS `email`,`user`.`username` AS `username`,`user`.`roles` AS `roles`,`user`.`password` AS `password`,`user`.`nom` AS `nom`,`user`.`prenom` AS `prenom`,`user`.`date_naissance` AS `date_naissance`,`user`.`adresse` AS `adresse`,`user`.`numero_securite` AS `numero_securite`,`user`.`rib` AS `rib`,`user`.`photo` AS `photo`,`user`.`six_digit_code` AS `six_digit_code`,`user`.`forgotten_pass_token` AS `forgotten_pass_token`,`user`.`active` AS `active`,`user`.`api_token` AS `api_token`,`user`.`telephone` AS `telephone`,`user`.`created_at` AS `created_at`,`user`.`code_postal` AS `code_postal`,`user`.`lien_calendly` AS `lien_calendly`,`user`.`stripe_data` AS `stripe_data`,`user`.`account_status` AS `account_status`,`user`.`account_start_date` AS `account_start_date`,`user`.`stripe_customer_id` AS `stripe_customer_id` from `user` where `user`.`active` <> 0 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `agent_secteur_client_valide`
--

/*!50001 DROP VIEW IF EXISTS `agent_secteur_client_valide`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `agent_secteur_client_valide` AS select `a`.`agent_id` AS `agent_id`,`a`.`secteur_id` AS `secteur_id`,`ac`.`id` AS `client_id` from (`agent_secteur_valide` `a` join `active_clients` `ac` on(`a`.`agent_id` = `ac`.`client_agent_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `agent_secteur_valide`
--

/*!50001 DROP VIEW IF EXISTS `agent_secteur_valide`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `agent_secteur_valide` AS select `ase`.`id` AS `id`,`ase`.`agent_id` AS `agent_id`,`ase`.`secteur_id` AS `secteur_id`,`ase`.`date_validation` AS `date_validation`,`ase`.`statut` AS `statut`,`s`.`type_id` AS `type_secteur_id` from ((`agent_secteur` `ase` join `secteur_active` `s` on(`ase`.`secteur_id` = `s`.`id`)) join `active_agent` `a` on(`ase`.`agent_id` = `a`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `all_type_order_valide`
--

/*!50001 DROP VIEW IF EXISTS `all_type_order_valide`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `all_type_order_valide` AS select `order_secu_valide`.`agent_id` AS `agent_id`,`order_secu_valide`.`secteur_id` AS `secteur_id`,`order_secu_valide`.`client_id` AS `client_id`,`order_secu_valide`.`montant_ttc` AS `montant`,`order_secu_valide`.`date_commande` AS `date_commande` from `order_secu_valide` union all select `order_valide`.`agent_id` AS `agent_id`,`order_valide`.`secteur_id` AS `secteur_id`,`order_valide`.`user_id` AS `user_id`,`order_valide`.`amount` AS `amount`,`order_valide`.`order_date` AS `order_date` from `order_valide` union all select `demande_devis_valide`.`agent_id` AS `agent_id`,`demande_devis_valide`.`secteur_id` AS `secteur_id`,`demande_devis_valide`.`client_id` AS `client_id`,`demande_devis_valide`.`price` AS `price`,`demande_devis_valide`.`date_demande` AS `date_demande` from `demande_devis_valide` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `all_type_order_valide_all_client`
--

/*!50001 DROP VIEW IF EXISTS `all_type_order_valide_all_client`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `all_type_order_valide_all_client` AS select `a`.`agent_id` AS `agent_id`,`a`.`secteur_id` AS `secteur_id`,`a`.`client_id` AS `client_id`,coalesce(`o`.`montant`,0) AS `montant`,coalesce(`o`.`nbr`,0) AS `nbr` from (`agent_secteur_client_valide` `a` left join `all_type_order_valide_per_client` `o` on((`a`.`agent_id`,`a`.`secteur_id`,`a`.`client_id`) = (`o`.`agent_id`,`o`.`secteur_id`,`o`.`client_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `all_type_order_valide_gp_mois_annee`
--

/*!50001 DROP VIEW IF EXISTS `all_type_order_valide_gp_mois_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `all_type_order_valide_gp_mois_annee` AS select `all_type_order_valide_mois_annee`.`agent_id` AS `agent_id`,`all_type_order_valide_mois_annee`.`secteur_id` AS `secteur_id`,`all_type_order_valide_mois_annee`.`mois` AS `mois`,`all_type_order_valide_mois_annee`.`annee` AS `annee`,sum(`all_type_order_valide_mois_annee`.`montant`) AS `montant`,count(`all_type_order_valide_mois_annee`.`agent_id`) AS `nbr` from `all_type_order_valide_mois_annee` group by `all_type_order_valide_mois_annee`.`agent_id`,`all_type_order_valide_mois_annee`.`secteur_id`,`all_type_order_valide_mois_annee`.`mois`,`all_type_order_valide_mois_annee`.`annee` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `all_type_order_valide_gp_mois_annee_secteur`
--

/*!50001 DROP VIEW IF EXISTS `all_type_order_valide_gp_mois_annee_secteur`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `all_type_order_valide_gp_mois_annee_secteur` AS select `all_type_order_valide_mois_annee`.`secteur_id` AS `secteur_id`,`all_type_order_valide_mois_annee`.`mois` AS `mois`,`all_type_order_valide_mois_annee`.`annee` AS `annee`,sum(`all_type_order_valide_mois_annee`.`montant`) AS `montant`,count(`all_type_order_valide_mois_annee`.`agent_id`) AS `nbr` from `all_type_order_valide_mois_annee` group by `all_type_order_valide_mois_annee`.`secteur_id`,`all_type_order_valide_mois_annee`.`mois`,`all_type_order_valide_mois_annee`.`annee` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `all_type_order_valide_mois_annee`
--

/*!50001 DROP VIEW IF EXISTS `all_type_order_valide_mois_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `all_type_order_valide_mois_annee` AS select `a`.`agent_id` AS `agent_id`,`a`.`secteur_id` AS `secteur_id`,`a`.`client_id` AS `client_id`,`a`.`montant` AS `montant`,`a`.`date_commande` AS `date_commande`,month(`a`.`date_commande`) AS `mois`,year(`a`.`date_commande`) AS `annee` from `all_type_order_valide` `a` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `all_type_order_valide_per_client`
--

/*!50001 DROP VIEW IF EXISTS `all_type_order_valide_per_client`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `all_type_order_valide_per_client` AS select `all_type_order_valide`.`agent_id` AS `agent_id`,`all_type_order_valide`.`secteur_id` AS `secteur_id`,`all_type_order_valide`.`client_id` AS `client_id`,sum(`all_type_order_valide`.`montant`) AS `montant`,count(`all_type_order_valide`.`client_id`) AS `nbr` from `all_type_order_valide` group by `all_type_order_valide`.`agent_id`,`all_type_order_valide`.`secteur_id`,`all_type_order_valide`.`client_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `client_secteur_agent`
--

/*!50001 DROP VIEW IF EXISTS `client_secteur_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `client_secteur_agent` AS select `a`.`agent_id` AS `agent_id`,`a`.`secteur_id` AS `secteur_id`,`a`.`client_id` AS `client_id`,`a`.`montant` AS `montant`,`a`.`nbr` AS `nbr`,`ac`.`nom` AS `nom`,`ac`.`prenom` AS `prenom`,`ac`.`email` AS `email`,`ac`.`username` AS `username` from (`all_type_order_valide_all_client` `a` join `active_clients` `ac` on(`a`.`client_id` = `ac`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `demande_devis_valide`
--

/*!50001 DROP VIEW IF EXISTS `demande_devis_valide`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `demande_devis_valide` AS select `dd`.`id` AS `id`,`dd`.`client_id` AS `client_id`,`dd`.`agent_id` AS `agent_id`,`dd`.`secteur_id` AS `secteur_id`,`dd`.`produit_id` AS `produit_id`,`dd`.`nom` AS `nom`,`dd`.`prenom` AS `prenom`,`dd`.`telephone` AS `telephone`,`dd`.`email` AS `email`,`dd`.`description` AS `description`,`dd`.`statut` AS `statut`,`dd`.`date_demande` AS `date_demande`,`dd`.`files` AS `files`,`dd`.`whatsapp` AS `whatsapp`,`d`.`price` AS `price`,`d`.`id` AS `devis_id`,`d`.`contrat_file_name` AS `contrat_file_name` from (`demande_devis` `dd` join `devis` `d` on(`dd`.`id` = `d`.`demande_devis_id` and `d`.`status_int` = 1)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `dernier_date_inventaire`
--

/*!50001 DROP VIEW IF EXISTS `dernier_date_inventaire`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `dernier_date_inventaire` AS select `inventaire_fille_details_valid`.`produit_id` AS `produit_id`,max(`inventaire_fille_details_valid`.`date_inventaire`) AS `dernier_date` from `inventaire_fille_details_valid` group by `inventaire_fille_details_valid`.`produit_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `dernier_inventaire`
--

/*!50001 DROP VIEW IF EXISTS `dernier_inventaire`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `dernier_inventaire` AS select `i`.`id` AS `id`,`i`.`mere_id` AS `mere_id`,`i`.`produit_id` AS `produit_id`,`i`.`qte` AS `qte`,`i`.`statut` AS `statut`,`i`.`date_inventaire` AS `date_inventaire` from (`dernier_date_inventaire` `d` join `inventaire_fille_details_valid` `i` on(`d`.`produit_id` = `i`.`produit_id` and `d`.`dernier_date` = `i`.`date_inventaire`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inventaire_fille_details`
--

/*!50001 DROP VIEW IF EXISTS `inventaire_fille_details`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inventaire_fille_details` AS select `f`.`id` AS `id`,`f`.`mere_id` AS `mere_id`,`f`.`produit_id` AS `produit_id`,`f`.`qte` AS `qte`,`f`.`statut` AS `statut`,`i`.`date_inventaire` AS `date_inventaire` from (`inventaire_fille` `f` join `inventaire_mere` `i` on(`f`.`mere_id` = `i`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inventaire_fille_details_valid`
--

/*!50001 DROP VIEW IF EXISTS `inventaire_fille_details_valid`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inventaire_fille_details_valid` AS select `inventaire_fille_details`.`id` AS `id`,`inventaire_fille_details`.`mere_id` AS `mere_id`,`inventaire_fille_details`.`produit_id` AS `produit_id`,`inventaire_fille_details`.`qte` AS `qte`,`inventaire_fille_details`.`statut` AS `statut`,`inventaire_fille_details`.`date_inventaire` AS `date_inventaire` from `inventaire_fille_details` where `inventaire_fille_details`.`statut` is null or `inventaire_fille_details`.`statut` <> 0 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `les_mois`
--

/*!50001 DROP VIEW IF EXISTS `les_mois`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `les_mois` AS select 1 AS `mois`,'Janvier' AS `mois_str` union all select 2 AS `mois`,'F�vrier' AS `mois_str` union all select 3 AS `mois`,'Mars' AS `mois_str` union all select 4 AS `mois`,'Avril' AS `mois_str` union all select 5 AS `mois`,'Mai' AS `mois_str` union all select 6 AS `mois`,'Juin' AS `mois_str` union all select 7 AS `mois`,'Juillet' AS `mois_str` union all select 8 AS `mois`,'Ao�t' AS `mois_str` union all select 9 AS `mois`,'Septembre' AS `mois_str` union all select 10 AS `mois`,'Octobre' AS `mois_str` union all select 11 AS `mois`,'Novembre' AS `mois_str` union all select 12 AS `mois`,'D�cembre' AS `mois_str` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mouvement_valid`
--

/*!50001 DROP VIEW IF EXISTS `mouvement_valid`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mouvement_valid` AS select `mouvement`.`id` AS `id`,`mouvement`.`produit_id` AS `produit_id`,`mouvement`.`date_mouvement` AS `date_mouvement`,`mouvement`.`entree` AS `entree`,`mouvement`.`sortie` AS `sortie`,`mouvement`.`statut` AS `statut` from `mouvement` where `mouvement`.`statut` is null or `mouvement`.`statut` <> 0 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `order_secu_valide`
--

/*!50001 DROP VIEW IF EXISTS `order_secu_valide`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `order_secu_valide` AS select `os`.`id` AS `id`,`os`.`produit_id` AS `produit_id`,`os`.`type_abonnement_id` AS `type_abonnement_id`,`os`.`agent_id` AS `agent_id`,`os`.`client_id` AS `client_id`,`os`.`code_promo` AS `code_promo`,`os`.`prix_produit` AS `prix_produit`,`os`.`statut` AS `statut`,`os`.`type_installation_id` AS `type_installation_id`,`os`.`secteur_id` AS `secteur_id`,`os`.`date_commande` AS `date_commande`,`os`.`installation_frais` AS `installation_frais`,`os`.`accomp_montant` AS `accomp_montant`,`os`.`charge_id` AS `charge_id`,`os`.`contrat_rempli` AS `contrat_rempli`,`os`.`contrat_signed` AS `contrat_signed`,`os`.`sepa` AS `sepa`,`os`.`kitbase_id` AS `kitbase_id`,`os`.`tva_id` AS `tva_id`,`os`.`tva_pourcentage` AS `tva_pourcentage`,(`os`.`accomp_montant` + `os`.`prix_produit`) * (1 + `os`.`tva_pourcentage` / 100) AS `montant_ttc` from `order_secu` `os` where `os`.`statut` = 2 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `order_valide`
--

/*!50001 DROP VIEW IF EXISTS `order_valide`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `order_valide` AS select `order`.`id` AS `id`,`order`.`user_id` AS `user_id`,`order`.`address_id` AS `address_id`,`order`.`agent_id` AS `agent_id`,`order`.`secteur_id` AS `secteur_id`,`order`.`order_date` AS `order_date`,`order`.`amount` AS `amount`,`order`.`status` AS `status`,`order`.`charge_id` AS `charge_id` from `order` where `order`.`status` = 2 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `produit_et_dernier_inventaire`
--

/*!50001 DROP VIEW IF EXISTS `produit_et_dernier_inventaire`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `produit_et_dernier_inventaire` AS select `p`.`id` AS `id`,`d`.`date_inventaire` AS `date_inventaire`,coalesce(`d`.`qte`,0) AS `qte` from (`produit` `p` left join `dernier_inventaire` `d` on(`p`.`id` = `d`.`produit_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `produit_qte_stock`
--

/*!50001 DROP VIEW IF EXISTS `produit_qte_stock`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `produit_qte_stock` AS select `p`.`id` AS `id`,`p`.`id` AS `produit_id`,`p`.`qte` + coalesce(`qm`.`qte_mouvement`,0) AS `qte_stock` from (`produit_et_dernier_inventaire` `p` left join `qte_mouvement_apres_dernier_inventaire` `qm` on(`p`.`id` = `qm`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `qte_mouvement_apres_dernier_inventaire`
--

/*!50001 DROP VIEW IF EXISTS `qte_mouvement_apres_dernier_inventaire`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `qte_mouvement_apres_dernier_inventaire` AS select `p`.`id` AS `id`,sum(coalesce(`m`.`entree`,0) - coalesce(`m`.`sortie`,0)) AS `qte_mouvement` from (`produit_et_dernier_inventaire` `p` join `mouvement_valid` `m` on(`p`.`id` = `m`.`produit_id` and (`p`.`date_inventaire` is null or `m`.`date_mouvement` > `p`.`date_inventaire`))) group by `p`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `secteur_active`
--

/*!50001 DROP VIEW IF EXISTS `secteur_active`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `secteur_active` AS select `secteur`.`id` AS `id`,`secteur`.`type_id` AS `type_id`,`secteur`.`nom` AS `nom`,`secteur`.`description` AS `description`,`secteur`.`active` AS `active` from `secteur` where `secteur`.`active` <> 0 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stat_vente_admin`
--

/*!50001 DROP VIEW IF EXISTS `stat_vente_admin`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_admin` AS select sum(`stat_vente_agent`.`nbr_ventes`) AS `nbr_ventes`,sum(`stat_vente_agent`.`ca`) AS `ca` from `stat_vente_agent` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stat_vente_agent`
--

/*!50001 DROP VIEW IF EXISTS `stat_vente_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_agent` AS select `stat_vente_secu_agent`.`agent_id` AS `agent_id`,`stat_vente_secu_agent`.`secteur_id` AS `secteur_id`,`stat_vente_secu_agent`.`nbr_ventes` AS `nbr_ventes`,`stat_vente_secu_agent`.`ca` AS `ca` from `stat_vente_secu_agent` union all select `stat_vente_ecommerce_agent`.`agent_id` AS `agent_id`,`stat_vente_ecommerce_agent`.`secteur_id` AS `secteur_id`,`stat_vente_ecommerce_agent`.`nbr_ventes` AS `nbr_ventes`,`stat_vente_ecommerce_agent`.`ca` AS `ca` from `stat_vente_ecommerce_agent` union all select `stat_vente_dd_agent`.`agent_id` AS `agent_id`,`stat_vente_dd_agent`.`secteur_id` AS `secteur_id`,`stat_vente_dd_agent`.`nbr_ventes` AS `nbr_ventes`,`stat_vente_dd_agent`.`ca` AS `ca` from `stat_vente_dd_agent` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stat_vente_dd_agent`
--

/*!50001 DROP VIEW IF EXISTS `stat_vente_dd_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_dd_agent` AS select `demande_devis_valide`.`agent_id` AS `agent_id`,`demande_devis_valide`.`secteur_id` AS `secteur_id`,count(`demande_devis_valide`.`id`) AS `nbr_ventes`,sum(`demande_devis_valide`.`price`) AS `ca` from `demande_devis_valide` group by `demande_devis_valide`.`agent_id`,`demande_devis_valide`.`secteur_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stat_vente_dd_tout_agent`
--

/*!50001 DROP VIEW IF EXISTS `stat_vente_dd_tout_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_dd_tout_agent` AS select `ase`.`id` AS `id`,`ase`.`agent_id` AS `agent_id`,`ase`.`secteur_id` AS `secteur_id`,coalesce(`sv`.`nbr_ventes`,0) AS `nbr_ventes`,coalesce(`sv`.`ca`,0) AS `ca`,`ase`.`type_secteur_id` AS `type_secteur_id` from ((select `agent_secteur_valide`.`id` AS `id`,`agent_secteur_valide`.`agent_id` AS `agent_id`,`agent_secteur_valide`.`secteur_id` AS `secteur_id`,`agent_secteur_valide`.`date_validation` AS `date_validation`,`agent_secteur_valide`.`statut` AS `statut`,`agent_secteur_valide`.`type_secteur_id` AS `type_secteur_id` from `pixelfocedev_bdd`.`agent_secteur_valide` where `agent_secteur_valide`.`type_secteur_id` = 2) `ase` left join `pixelfocedev_bdd`.`stat_vente_dd_agent` `sv` on((`ase`.`agent_id`,`ase`.`secteur_id`) = (`sv`.`agent_id`,`sv`.`secteur_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stat_vente_ecommerce_agent`
--

/*!50001 DROP VIEW IF EXISTS `stat_vente_ecommerce_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_ecommerce_agent` AS select `order_valide`.`agent_id` AS `agent_id`,`order_valide`.`secteur_id` AS `secteur_id`,count(`order_valide`.`id`) AS `nbr_ventes`,sum(`order_valide`.`amount`) AS `ca` from `order_valide` group by `order_valide`.`agent_id`,`order_valide`.`secteur_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stat_vente_ecommerce_tout_agent`
--

/*!50001 DROP VIEW IF EXISTS `stat_vente_ecommerce_tout_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_ecommerce_tout_agent` AS select `ase`.`id` AS `id`,`ase`.`agent_id` AS `agent_id`,`ase`.`secteur_id` AS `secteur_id`,coalesce(`sv`.`nbr_ventes`,0) AS `nbr_ventes`,coalesce(`sv`.`ca`,0) AS `ca`,`ase`.`type_secteur_id` AS `type_secteur_id` from ((select `agent_secteur_valide`.`id` AS `id`,`agent_secteur_valide`.`agent_id` AS `agent_id`,`agent_secteur_valide`.`secteur_id` AS `secteur_id`,`agent_secteur_valide`.`date_validation` AS `date_validation`,`agent_secteur_valide`.`statut` AS `statut`,`agent_secteur_valide`.`type_secteur_id` AS `type_secteur_id` from `pixelfocedev_bdd`.`agent_secteur_valide` where `agent_secteur_valide`.`type_secteur_id` = 1) `ase` left join `pixelfocedev_bdd`.`stat_vente_ecommerce_agent` `sv` on((`ase`.`agent_id`,`ase`.`secteur_id`) = (`sv`.`agent_id`,`sv`.`secteur_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stat_vente_secteur`
--

/*!50001 DROP VIEW IF EXISTS `stat_vente_secteur`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_secteur` AS select `s`.`id` AS `secteur_id`,coalesce(`t`.`nbr_ventes`,0) AS `nbr_ventes`,coalesce(`t`.`ca`,0) AS `ca` from (`pixelfocedev_bdd`.`secteur_active` `s` left join (select `stat_vente_agent`.`secteur_id` AS `secteur_id`,sum(`stat_vente_agent`.`nbr_ventes`) AS `nbr_ventes`,sum(`stat_vente_agent`.`ca`) AS `ca` from `pixelfocedev_bdd`.`stat_vente_agent` group by `stat_vente_agent`.`secteur_id`) `t` on(`s`.`id` = `t`.`secteur_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stat_vente_secu_agent`
--

/*!50001 DROP VIEW IF EXISTS `stat_vente_secu_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_secu_agent` AS select `order_secu_valide`.`agent_id` AS `agent_id`,`order_secu_valide`.`secteur_id` AS `secteur_id`,count(`order_secu_valide`.`id`) AS `nbr_ventes`,sum(`order_secu_valide`.`montant_ttc`) AS `ca` from `order_secu_valide` group by `order_secu_valide`.`agent_id`,`order_secu_valide`.`secteur_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stat_vente_secu_tout_agent`
--

/*!50001 DROP VIEW IF EXISTS `stat_vente_secu_tout_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_secu_tout_agent` AS select `ase`.`id` AS `id`,`ase`.`agent_id` AS `agent_id`,`ase`.`secteur_id` AS `secteur_id`,coalesce(`sv`.`nbr_ventes`,0) AS `nbr_ventes`,coalesce(`sv`.`ca`,0) AS `ca`,`ase`.`type_secteur_id` AS `type_secteur_id` from ((select `agent_secteur_valide`.`id` AS `id`,`agent_secteur_valide`.`agent_id` AS `agent_id`,`agent_secteur_valide`.`secteur_id` AS `secteur_id`,`agent_secteur_valide`.`date_validation` AS `date_validation`,`agent_secteur_valide`.`statut` AS `statut`,`agent_secteur_valide`.`type_secteur_id` AS `type_secteur_id` from `pixelfocedev_bdd`.`agent_secteur_valide` where `agent_secteur_valide`.`type_secteur_id` = 3) `ase` left join `pixelfocedev_bdd`.`stat_vente_secu_agent` `sv` on((`ase`.`agent_id`,`ase`.`secteur_id`) = (`sv`.`agent_id`,`sv`.`secteur_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stat_vente_tout_agent`
--

/*!50001 DROP VIEW IF EXISTS `stat_vente_tout_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`278144`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_tout_agent` AS select `stat_vente_secu_tout_agent`.`id` AS `id`,`stat_vente_secu_tout_agent`.`agent_id` AS `agent_id`,`stat_vente_secu_tout_agent`.`secteur_id` AS `secteur_id`,`stat_vente_secu_tout_agent`.`nbr_ventes` AS `nbr_ventes`,`stat_vente_secu_tout_agent`.`ca` AS `ca`,`stat_vente_secu_tout_agent`.`type_secteur_id` AS `type_secteur_id` from `pixelfocedev_bdd`.`stat_vente_secu_tout_agent` union all select `stat_vente_ecommerce_tout_agent`.`id` AS `id`,`stat_vente_ecommerce_tout_agent`.`agent_id` AS `agent_id`,`stat_vente_ecommerce_tout_agent`.`secteur_id` AS `secteur_id`,`stat_vente_ecommerce_tout_agent`.`nbr_ventes` AS `nbr_ventes`,`stat_vente_ecommerce_tout_agent`.`ca` AS `ca`,`stat_vente_ecommerce_tout_agent`.`type_secteur_id` AS `type_secteur_id` from `pixelfocedev_bdd`.`stat_vente_ecommerce_tout_agent` union all select `stat_vente_dd_tout_agent`.`id` AS `id`,`stat_vente_dd_tout_agent`.`agent_id` AS `agent_id`,`stat_vente_dd_tout_agent`.`secteur_id` AS `secteur_id`,`stat_vente_dd_tout_agent`.`nbr_ventes` AS `nbr_ventes`,`stat_vente_dd_tout_agent`.`ca` AS `ca`,`stat_vente_dd_tout_agent`.`type_secteur_id` AS `type_secteur_id` from `pixelfocedev_bdd`.`stat_vente_dd_tout_agent` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-22 14:34:53
