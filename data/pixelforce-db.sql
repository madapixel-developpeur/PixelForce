-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: pixelforce_db_2
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `account_validation`
--

DROP TABLE IF EXISTS `account_validation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_validation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL,
  `verif_code` varchar(255) NOT NULL,
  `date_expiration` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_validation`
--

LOCK TABLES `account_validation` WRITE;
/*!40000 ALTER TABLE `account_validation` DISABLE KEYS */;
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
  1 AS `stripe_customer_id`,
  1 AS `numero_rue`,
  1 AS `ville` */;
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
  1 AS `stripe_customer_id`,
  1 AS `numero_rue`,
  1 AS `ville` */;
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
  1 AS `stripe_customer_id`,
  1 AS `numero_rue`,
  1 AS `ville` */;
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
  1 AS `stripe_customer_id`,
  1 AS `numero_rue`,
  1 AS `ville` */;
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
  `current_formation_rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_521647B53414710B` (`agent_id`),
  KEY `IDX_521647B59F7E4405` (`secteur_id`),
  CONSTRAINT `FK_521647B53414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_521647B59F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent_secteur`
--

LOCK TABLES `agent_secteur` WRITE;
/*!40000 ALTER TABLE `agent_secteur` DISABLE KEYS */;
INSERT INTO `agent_secteur` VALUES (1,5,1,'2024-04-30 05:54:34',1,NULL),(2,6,2,'2024-04-30 09:17:42',1,NULL),(3,9,NULL,'2024-05-02 12:17:58',1,NULL),(4,10,NULL,'2024-05-02 12:18:47',1,NULL),(5,12,NULL,'2024-05-02 12:23:45',1,NULL),(6,13,NULL,'2024-05-03 06:14:12',1,NULL),(7,14,NULL,'2024-05-03 07:00:48',1,NULL),(8,15,NULL,'2024-05-03 07:09:01',1,NULL),(9,15,9,'2024-04-30 05:54:34',1,NULL),(10,18,1,'2024-05-07 09:25:42',1,NULL),(11,18,9,'2024-05-07 09:25:48',1,NULL),(12,17,9,'2024-05-07 12:21:22',1,NULL),(13,22,9,'2024-05-07 16:56:22',1,NULL),(14,23,9,'2024-05-08 07:50:04',1,NULL),(15,24,9,'2024-05-08 10:03:25',1,NULL);
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
  1 AS `client_id` */;
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
  1 AS `type_secteur_id` */;
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
  1 AS `date_commande` */;
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
  1 AS `nbr` */;
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
  1 AS `nbr` */;
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
  1 AS `nbr` */;
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
  1 AS `annee` */;
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
  1 AS `nbr` */;
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
-- Table structure for table `basket_item_aroma`
--

DROP TABLE IF EXISTS `basket_item_aroma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `basket_item_aroma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `implantation_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `secteur_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_310BAE3FCE296AF7` (`implantation_id`),
  CONSTRAINT `FK_310BAE3FCE296AF7` FOREIGN KEY (`implantation_id`) REFERENCES `implantation_aroma` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `basket_item_aroma`
--

LOCK TABLES `basket_item_aroma` WRITE;
/*!40000 ALTER TABLE `basket_item_aroma` DISABLE KEYS */;
/*!40000 ALTER TABLE `basket_item_aroma` ENABLE KEYS */;
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
  `url` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `all_day` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `IDX_57FA09C9A76ED395` (`user_id`),
  KEY `IDX_57FA09C9C7D799B9` (`calendar_event_label_id`),
  CONSTRAINT `FK_57FA09C9A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_57FA09C9C7D799B9` FOREIGN KEY (`calendar_event_label_id`) REFERENCES `calendar_event_label` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_event`
--

LOCK TABLES `calendar_event` WRITE;
/*!40000 ALTER TABLE `calendar_event` DISABLE KEYS */;
INSERT INTO `calendar_event` VALUES (1,2,1,'/coach/contact/meeting/1/fiche','Presentation business','2024-04-30 07:16:00','2024-04-30 08:16:00',0),(2,4,1,'/coach/contact/meeting/2/fiche','Presentation business','2024-04-30 07:16:00','2024-04-30 08:16:00',0),(3,5,1,'/agent/contact/meeting/3/fiche','Presentation business','2024-04-30 07:16:00','2024-04-30 08:16:00',0),(4,2,1,'/coach/contact/meeting/4/fiche','Presentation business finance','2024-04-30 09:25:00','2024-04-30 10:25:00',0),(5,4,1,'/coach/contact/meeting/5/fiche','Presentation business finance','2024-04-30 09:25:00','2024-04-30 10:25:00',0),(6,5,1,'/agent/contact/meeting/6/fiche','Presentation business finance','2024-04-30 09:25:00','2024-04-30 10:25:00',0);
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
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_event_label`
--

LOCK TABLES `calendar_event_label` WRITE;
/*!40000 ALTER TABLE `calendar_event_label` DISABLE KEYS */;
INSERT INTO `calendar_event_label` VALUES (1,'Meeting','Meeting','blue');
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
  `code` varchar(255) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `is_group` tinyint(1) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `vus` longtext DEFAULT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `canal_message`
--

LOCK TABLES `canal_message` WRITE;
/*!40000 ALTER TABLE `canal_message` DISABLE KEYS */;
INSERT INTO `canal_message` VALUES (1,'TVE9PSYxMiNkNU1nPT0=','Nakany Andriamihaja Michel',0,NULL,'a:0:{}'),(2,'TVE9PSYxMiNkNU13PT0=','Nakany Andriamihaja Michel',0,NULL,'a:0:{}'),(3,'TVE9PSYxMiNkNU5BPT0=','Nakany Andriamihaja Michel',0,NULL,'a:0:{}'),(4,'TkE9PSYxMiNkNU5RPT0=',NULL,0,NULL,'a:0:{}'),(5,'TVE9PSYxMiNkNU5RPT0=','Nakany Andriamihaja Michel',0,NULL,'a:0:{}'),(6,'TVE9PSYxMiNkNU5nPT0=','Nakany Andriamihaja Michel',0,NULL,'a:0:{}'),(7,'TVE9PSYxMiNkNU9RPT0=','Nakany Michel',0,NULL,'a:0:{}'),(8,'TVE9PSYxMiNkNU1UQT0=','Nakany Andriamihaja Michel',0,NULL,'a:0:{}'),(9,'TVE9PSYxMiNkNU1UST0=','Nakany Andriamihaja Michel',0,NULL,'a:0:{}'),(10,'TVE9PSYxMiNkNU1UTT0=','Nakany Andriamihaja Michel',0,NULL,'a:0:{}'),(11,'TVE9PSYxMiNkNU1UUT0=','Nakany Andriamihaja Michel',0,NULL,'a:0:{}'),(12,'TVE9PSYxMiNkNU1UVT0=','Nakany Andriamihaja Michel',0,NULL,'a:0:{}'),(13,'TVE9PSYxMiNkNU1UWT0=','Nakany Michel',0,NULL,'a:0:{}'),(14,'TVE9PSYxMiNkNU1UYz0=','Nakany Andriamihaja Michel',0,NULL,'a:0:{}'),(15,'TVE9PSYxMiNkNU1UZz0=','Nakany Andriamihaja Michel',0,NULL,'a:0:{}'),(16,'TVE9PSYxMiNkNU1Uaz0=','Nakany Andriamihaja Michel',0,NULL,'a:0:{}'),(17,'TVE9PSYxMiNkNU1qQT0=',NULL,0,NULL,'a:0:{}'),(18,'TVRjPSYxMiNkNU1qQT0=',NULL,0,NULL,'a:0:{}'),(19,'TVE9PSYxMiNkNU1qRT0=',NULL,0,NULL,'a:0:{}'),(20,'TVE9PSYxMiNkNU1qST0=','Michel Nakany Andriamihaja',0,NULL,'a:0:{}'),(21,'TVE9PSYxMiNkNU1qTT0=',NULL,0,NULL,'a:0:{}');
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
INSERT INTO `canal_message_user` VALUES (1,1),(1,2),(2,1),(2,3),(3,1),(3,4),(4,4),(4,5),(5,1),(5,5),(6,1),(6,6),(7,1),(7,9),(8,1),(8,10),(9,1),(9,12),(10,1),(10,13),(11,1),(11,14),(12,1),(12,15),(13,1),(13,16),(14,1),(14,17),(15,1),(15,18),(16,1),(16,19),(17,1),(17,20),(18,17),(18,20),(19,1),(19,21),(20,1),(20,22),(21,1),(21,23);
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
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_497DD6349F7E4405` (`secteur_id`),
  CONSTRAINT `FK_497DD6349F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie`
--

LOCK TABLES `categorie` WRITE;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
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
  `nom` varchar(255) NOT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_95B99609F7E4405` (`secteur_id`),
  CONSTRAINT `FK_95B99609F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie_dd`
--

LOCK TABLES `categorie_dd` WRITE;
/*!40000 ALTER TABLE `categorie_dd` DISABLE KEYS */;
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
  `nom` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `ordre_cat_formation` int(11) DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  `fonctionnalites` longtext DEFAULT NULL COMMENT '(DC2Type:json)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie_formation`
--

LOCK TABLES `categorie_formation` WRITE;
/*!40000 ALTER TABLE `categorie_formation` DISABLE KEYS */;
INSERT INTO `categorie_formation` VALUES (1,'Presentation du secteur et outils','Presentation du secteur et outils',1,1,'[\"FORMATION\",  \"AGENDA\", \"COACH\"]'),(2,'Formation sur le produit','Formation sur le produit',2,1,'[\"PRODUIT\"]'),(3,'Formation Lead','Formation Lead',3,1,'[\"CONTACT\", \"RDV\"]'),(4,'Formation Audit','Formation Audit',4,1,'[\"AUDIT\"]'),(5,'Formation Vente','Formation Vente',5,1,'[\"VENTE\"]');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie_formation_agent`
--

LOCK TABLES `categorie_formation_agent` WRITE;
/*!40000 ALTER TABLE `categorie_formation_agent` DISABLE KEYS */;
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
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F44E3259F7E4405` (`secteur_id`),
  CONSTRAINT `FK_F44E3259F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie_secu`
--

LOCK TABLES `categorie_secu` WRITE;
/*!40000 ALTER TABLE `categorie_secu` DISABLE KEYS */;
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
  1 AS `username` */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coach_agent`
--

LOCK TABLES `coach_agent` WRITE;
/*!40000 ALTER TABLE `coach_agent` DISABLE KEYS */;
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
INSERT INTO `coach_secteur` VALUES (1,NULL,2),(2,2,1),(3,3,2),(4,4,1),(6,NULL,10),(7,NULL,11),(8,NULL,12),(10,20,9),(11,21,9);
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
  `secteur_id` int(11) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `prix` double NOT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1A5A3A929F7E4405` (`secteur_id`),
  CONSTRAINT `FK_1A5A3A929F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `code_promo_secu`
--

LOCK TABLES `code_promo_secu` WRITE;
/*!40000 ALTER TABLE `code_promo_secu` DISABLE KEYS */;
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
  `textes` longtext NOT NULL,
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
-- Table structure for table `config_secteur`
--

DROP TABLE IF EXISTS `config_secteur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_secteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secteur_id` int(11) DEFAULT NULL,
  `type_secteur_id` int(11) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `val` double DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F559E7EF9F7E4405` (`secteur_id`),
  KEY `IDX_F559E7EF827D9220` (`type_secteur_id`),
  CONSTRAINT `FK_F559E7EF827D9220` FOREIGN KEY (`type_secteur_id`) REFERENCES `type_secteur` (`id`),
  CONSTRAINT `FK_F559E7EF9F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_secteur`
--

LOCK TABLES `config_secteur` WRITE;
/*!40000 ALTER TABLE `config_secteur` DISABLE KEYS */;
/*!40000 ALTER TABLE `config_secteur` ENABLE KEYS */;
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
  `note` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4C62E6382EF03101` (`information_id`),
  KEY `IDX_4C62E6383414710B` (`agent_id`),
  KEY `IDX_4C62E6389F7E4405` (`secteur_id`),
  CONSTRAINT `FK_4C62E6382EF03101` FOREIGN KEY (`information_id`) REFERENCES `contact_information` (`id`),
  CONSTRAINT `FK_4C62E6383414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_4C62E6389F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES (1,5,1,1,0,'2024-04-30 07:13:54','');
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
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `rue` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `code_postal` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `composition_foyer` varchar(255) DEFAULT NULL,
  `nbr_personne` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_47D5A73D13B22EC4` (`type_logement_id`),
  CONSTRAINT `FK_47D5A73D13B22EC4` FOREIGN KEY (`type_logement_id`) REFERENCES `type_logement` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_information`
--

LOCK TABLES `contact_information` WRITE;
/*!40000 ALTER TABLE `contact_information` DISABLE KEYS */;
INSERT INTO `contact_information` VALUES (1,NULL,'Michel','Nakany Andriamihaja','mnakanyandriamihaja+test@gmail.com','0349331431','Antananarivo',NULL,NULL,'00101','Antananarivo',NULL,NULL);
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
  `nom` varchar(255) DEFAULT NULL,
  `fichier` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3539C16C9F7E4405` (`secteur_id`),
  CONSTRAINT `FK_3539C16C9F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrat_secu`
--

LOCK TABLES `contrat_secu` WRITE;
/*!40000 ALTER TABLE `contrat_secu` DISABLE KEYS */;
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
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `description` varchar(600) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `date_demande` datetime NOT NULL,
  `files` longtext DEFAULT NULL COMMENT '(DC2Type:json)',
  `whatsapp` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7DF9460219EB6921` (`client_id`),
  KEY `IDX_7DF946023414710B` (`agent_id`),
  KEY `IDX_7DF946029F7E4405` (`secteur_id`),
  KEY `IDX_7DF94602F347EFB` (`produit_id`),
  CONSTRAINT `FK_7DF9460219EB6921` FOREIGN KEY (`client_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_7DF946023414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_7DF946029F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`),
  CONSTRAINT `FK_7DF94602F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit_dd` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demande_devis`
--

LOCK TABLES `demande_devis` WRITE;
/*!40000 ALTER TABLE `demande_devis` DISABLE KEYS */;
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
  1 AS `contrat_file_name` */;
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
  1 AS `dernier_date` */;
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
  1 AS `date_inventaire` */;
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
  `title` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `price` double NOT NULL,
  `files` longtext DEFAULT NULL COMMENT '(DC2Type:json)',
  `created_at` datetime NOT NULL,
  `status` varchar(100) NOT NULL,
  `contrat_file_name` varchar(255) DEFAULT NULL,
  `status_int` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8B27C52B787B318` (`demande_devis_id`),
  CONSTRAINT `FK_8B27C52B787B318` FOREIGN KEY (`demande_devis_id`) REFERENCES `demande_devis` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devis`
--

LOCK TABLES `devis` WRITE;
/*!40000 ALTER TABLE `devis` DISABLE KEYS */;
/*!40000 ALTER TABLE `devis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devis_company`
--

DROP TABLE IF EXISTS `devis_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devis_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) DEFAULT NULL,
  `secteur_id` int(11) DEFAULT NULL,
  `company_info` longtext NOT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `client_mail` varchar(255) NOT NULL,
  `client_info` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `pj_filename` varchar(255) NOT NULL,
  `devis_ref_seq` varchar(255) NOT NULL,
  `payment_condition` int(11) NOT NULL,
  `devis_total_ht` double NOT NULL,
  `devis_total_ttc` double NOT NULL,
  `client_lastname` varchar(255) NOT NULL,
  `client_rdv` datetime NOT NULL,
  `status` varchar(100) NOT NULL,
  `date_signature` datetime DEFAULT NULL,
  `anonymous_client_name` varchar(255) DEFAULT NULL,
  `anonymous_client_mail` varchar(255) DEFAULT NULL,
  `anonymous_client_phone` varchar(255) DEFAULT NULL,
  `iteration_payment` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DD5192133414710B` (`agent_id`),
  KEY `IDX_DD5192139F7E4405` (`secteur_id`),
  CONSTRAINT `FK_DD5192133414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_DD5192139F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devis_company`
--

LOCK TABLES `devis_company` WRITE;
/*!40000 ALTER TABLE `devis_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `devis_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devis_company_detail`
--

DROP TABLE IF EXISTS `devis_company_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devis_company_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `devis_company_id` int(11) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `designation` longtext NOT NULL,
  `quantite` double NOT NULL,
  `pu_vente` double NOT NULL,
  `tva` double NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `montant_ht` double NOT NULL,
  `total_ttc` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E02E34273A513E` (`devis_company_id`),
  CONSTRAINT `FK_E02E34273A513E` FOREIGN KEY (`devis_company_id`) REFERENCES `devis_company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devis_company_detail`
--

LOCK TABLES `devis_company_detail` WRITE;
/*!40000 ALTER TABLE `devis_company_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `devis_company_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20240429194950','2024-04-29 19:49:58',1053),('DoctrineMigrations\\Version20240507071602','2024-05-07 07:16:06',95),('DoctrineMigrations\\Version20240507165146','2024-05-07 16:51:53',204),('DoctrineMigrations\\Version20240508075644','2024-05-08 07:56:49',93),('DoctrineMigrations\\Version20240508083329','2024-05-08 08:33:33',89),('DoctrineMigrations\\Version20240511153332','2024-05-11 17:33:39',41),('DoctrineMigrations\\Version20240511160858','2024-05-11 18:09:07',69),('DoctrineMigrations\\Version20240511183851','2024-05-11 20:39:16',57);
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
  `nom` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `statut` int(11) NOT NULL,
  `message` varchar(600) DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `amount` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D8698A767E3C61F9` (`owner_id`),
  CONSTRAINT `FK_D8698A767E3C61F9` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

LOCK TABLES `document` WRITE;
/*!40000 ALTER TABLE `document` DISABLE KEYS */;
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
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `signed_file` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `paid` tinyint(1) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `date_send` datetime NOT NULL,
  `date_signed` datetime DEFAULT NULL,
  `conseiller` varchar(255) DEFAULT NULL,
  `payment_intent_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7A3CD3E8C33F7837` (`document_id`),
  CONSTRAINT `FK_7A3CD3E8C33F7837` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_recipient`
--

LOCK TABLES `document_recipient` WRITE;
/*!40000 ALTER TABLE `document_recipient` DISABLE KEYS */;
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
  `titre` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `description_deblocage` longtext DEFAULT NULL,
  `contenu` longtext DEFAULT NULL,
  `video_id` varchar(255) DEFAULT NULL,
  `debloque_agent` tinyint(1) DEFAULT NULL,
  `brouillon` tinyint(1) DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_404021BF3C105691` (`coach_id`),
  KEY `IDX_404021BF9F7E4405` (`secteur_id`),
  KEY `IDX_404021BF2B036EAC` (`categorie_formation_id`),
  CONSTRAINT `FK_404021BF2B036EAC` FOREIGN KEY (`categorie_formation_id`) REFERENCES `categorie_formation` (`id`),
  CONSTRAINT `FK_404021BF3C105691` FOREIGN KEY (`coach_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_404021BF9F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formation`
--

LOCK TABLES `formation` WRITE;
/*!40000 ALTER TABLE `formation` DISABLE KEYS */;
INSERT INTO `formation` VALUES (1,NULL,9,1,'Presentation du secteur et outils','Presentation du secteur et outils',NULL,NULL,'727500583',NULL,0,0),(2,NULL,9,2,'Formation sur le produit - Part 1','Formation sur le produit - Part 1',NULL,NULL,'727500217',NULL,0,0),(3,NULL,9,2,'Formation sur le produit - Part 2','Formation sur le produit - Part 2',NULL,NULL,'727500583',NULL,0,0),(4,NULL,9,3,'Formation Lead','Formation Lead',NULL,NULL,'727500217',NULL,0,0),(5,NULL,9,4,'Formation Audit','Formation Audit',NULL,NULL,'727500583',NULL,0,0),(6,NULL,9,5,'Formation Vente','Formation Vente',NULL,NULL,'727500217',NULL,0,0);
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
  `statut` varchar(255) DEFAULT NULL,
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
/*!40000 ALTER TABLE `formation_agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `implantation_aroma`
--

DROP TABLE IF EXISTS `implantation_aroma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `implantation_aroma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mere_id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `qte_elmt` int(11) NOT NULL,
  `remise` decimal(5,2) DEFAULT NULL,
  `reassort` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7E052C7339DEC40E` (`mere_id`),
  CONSTRAINT `FK_7E052C7339DEC40E` FOREIGN KEY (`mere_id`) REFERENCES `implantation_mere_aroma` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `implantation_aroma`
--

LOCK TABLES `implantation_aroma` WRITE;
/*!40000 ALTER TABLE `implantation_aroma` DISABLE KEYS */;
/*!40000 ALTER TABLE `implantation_aroma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `implantation_elmt_aroma`
--

DROP TABLE IF EXISTS `implantation_elmt_aroma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `implantation_elmt_aroma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mere_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `statut` int(11) NOT NULL,
  `qte_gratuit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A3094E039DEC40E` (`mere_id`),
  KEY `IDX_A3094E0F347EFB` (`produit_id`),
  CONSTRAINT `FK_A3094E039DEC40E` FOREIGN KEY (`mere_id`) REFERENCES `implantation_aroma` (`id`),
  CONSTRAINT `FK_A3094E0F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit_aroma` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `implantation_elmt_aroma`
--

LOCK TABLES `implantation_elmt_aroma` WRITE;
/*!40000 ALTER TABLE `implantation_elmt_aroma` DISABLE KEYS */;
/*!40000 ALTER TABLE `implantation_elmt_aroma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `implantation_mere_aroma`
--

DROP TABLE IF EXISTS `implantation_mere_aroma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `implantation_mere_aroma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `implantation_mere_aroma`
--

LOCK TABLES `implantation_mere_aroma` WRITE;
/*!40000 ALTER TABLE `implantation_mere_aroma` DISABLE KEYS */;
/*!40000 ALTER TABLE `implantation_mere_aroma` ENABLE KEYS */;
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
  1 AS `date_inventaire` */;
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
  1 AS `date_inventaire` */;
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
  `description` varchar(255) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kit_base_elmt_secu`
--

LOCK TABLES `kit_base_elmt_secu` WRITE;
/*!40000 ALTER TABLE `kit_base_elmt_secu` DISABLE KEYS */;
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
  `secteur_id` int(11) NOT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5D56377E9F7E4405` (`secteur_id`),
  CONSTRAINT `FK_5D56377E9F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kit_base_secu`
--

LOCK TABLES `kit_base_secu` WRITE;
/*!40000 ALTER TABLE `kit_base_secu` DISABLE KEYS */;
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
  1 AS `mois_str` */;
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
  `code` varchar(255) DEFAULT NULL,
  `is_speed_live` tinyint(1) DEFAULT NULL,
  `date_debut_live` datetime DEFAULT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `is_in_process` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2D0551EB415F1F91` (`user_a_id`),
  KEY `IDX_2D0551EB53EAB07F` (`user_b_id`),
  KEY `IDX_2D0551EB9F7E4405` (`secteur_id`),
  CONSTRAINT `FK_2D0551EB415F1F91` FOREIGN KEY (`user_a_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_2D0551EB53EAB07F` FOREIGN KEY (`user_b_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_2D0551EB9F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `live_chat_video`
--

LOCK TABLES `live_chat_video` WRITE;
/*!40000 ALTER TABLE `live_chat_video` DISABLE KEYS */;
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
  `titre` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6A2CA10C5200282E` (`formation_id`),
  CONSTRAINT `FK_6A2CA10C5200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
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
  `title` varchar(255) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F515E139A76ED395` (`user_id`),
  KEY `IDX_F515E13996491114` (`meeting_state_id`),
  KEY `IDX_F515E1392A44447F` (`user_to_meet_id`),
  CONSTRAINT `FK_F515E1392A44447F` FOREIGN KEY (`user_to_meet_id`) REFERENCES `contact` (`id`),
  CONSTRAINT `FK_F515E13996491114` FOREIGN KEY (`meeting_state_id`) REFERENCES `meeting_state` (`id`),
  CONSTRAINT `FK_F515E139A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting`
--

LOCK TABLES `meeting` WRITE;
/*!40000 ALTER TABLE `meeting` DISABLE KEYS */;
INSERT INTO `meeting` VALUES (1,2,1,1,'Presentation business',NULL,'2024-04-30 07:16:00','2024-04-30 08:16:00'),(2,4,1,1,'Presentation business',NULL,'2024-04-30 07:16:00','2024-04-30 08:16:00'),(3,5,1,1,'Presentation business',NULL,'2024-04-30 07:16:00','2024-04-30 08:16:00'),(4,2,1,1,'Presentation business finance',NULL,'2024-04-30 09:25:00','2024-04-30 10:25:00'),(5,4,1,1,'Presentation business finance',NULL,'2024-04-30 09:25:00','2024-04-30 10:25:00'),(6,5,1,1,'Presentation business finance',NULL,'2024-04-30 09:25:00','2024-04-30 10:25:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_event`
--

LOCK TABLES `meeting_event` WRITE;
/*!40000 ALTER TABLE `meeting_event` DISABLE KEYS */;
INSERT INTO `meeting_event` VALUES (1,1,1),(2,2,2),(3,3,3),(4,4,4),(5,5,5),(6,6,6);
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
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_state`
--

LOCK TABLES `meeting_state` WRITE;
/*!40000 ALTER TABLE `meeting_state` DISABLE KEYS */;
INSERT INTO `meeting_state` VALUES (1,'Cree'),(2,'Respecte'),(3,'Annulé');
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
  `textes` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `files` longtext DEFAULT NULL COMMENT '(DC2Type:array)',
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FA76ED395` (`user_id`),
  KEY `IDX_B6BD307FE53A466D` (`canal_message_id`),
  CONSTRAINT `FK_B6BD307FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_B6BD307FE53A466D` FOREIGN KEY (`canal_message_id`) REFERENCES `canal_message` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
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
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mouvement`
--

LOCK TABLES `mouvement` WRITE;
/*!40000 ALTER TABLE `mouvement` DISABLE KEYS */;
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
  1 AS `statut` */;
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
  `charge_id` varchar(255) DEFAULT NULL,
  `tva` decimal(5,2) DEFAULT NULL,
  `invoice_path` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F5299398F5B7AF75` (`address_id`),
  KEY `IDX_F5299398A76ED395` (`user_id`),
  KEY `IDX_F52993983414710B` (`agent_id`),
  KEY `IDX_F52993989F7E4405` (`secteur_id`),
  CONSTRAINT `FK_F52993983414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_F52993989F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`),
  CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_F5299398F5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `order_address` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
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
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `province_departement` varchar(255) DEFAULT NULL,
  `rue` varchar(255) DEFAULT NULL,
  `notes` longtext DEFAULT NULL,
  `pays_region` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FB34C6CAA76ED395` (`user_id`),
  CONSTRAINT `FK_FB34C6CAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_address`
--

LOCK TABLES `order_address` WRITE;
/*!40000 ALTER TABLE `order_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_address_aroma`
--

DROP TABLE IF EXISTS `order_address_aroma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_address_aroma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  `billing_address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `billing_postal_code` varchar(255) DEFAULT NULL,
  `billing_city` varchar(255) DEFAULT NULL,
  `notes` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_90ED363CA76ED395` (`user_id`),
  CONSTRAINT `FK_90ED363CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_address_aroma`
--

LOCK TABLES `order_address_aroma` WRITE;
/*!40000 ALTER TABLE `order_address_aroma` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_address_aroma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_aroma`
--

DROP TABLE IF EXISTS `order_aroma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_aroma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `secteur_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `amount` decimal(16,6) NOT NULL,
  `note` longtext DEFAULT NULL,
  `charge_id` varchar(255) DEFAULT NULL,
  `tva` decimal(5,2) DEFAULT NULL,
  `invoice_path` varchar(255) DEFAULT NULL,
  `frais_livraison` decimal(12,2) DEFAULT NULL,
  `montant_sans_frais_livraison` decimal(12,2) DEFAULT NULL,
  `delivery_order_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_89B57D33A76ED395` (`user_id`),
  KEY `IDX_89B57D333414710B` (`agent_id`),
  KEY `IDX_89B57D339F7E4405` (`secteur_id`),
  KEY `IDX_89B57D33F5B7AF75` (`address_id`),
  CONSTRAINT `FK_89B57D333414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_89B57D339F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`),
  CONSTRAINT `FK_89B57D33A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_89B57D33F5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `order_address_aroma` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_aroma`
--

LOCK TABLES `order_aroma` WRITE;
/*!40000 ALTER TABLE `order_aroma` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_aroma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `order_aroma_valide`
--

DROP TABLE IF EXISTS `order_aroma_valide`;
/*!50001 DROP VIEW IF EXISTS `order_aroma_valide`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `order_aroma_valide` AS SELECT
 1 AS `id`,
  1 AS `user_id`,
  1 AS `agent_id`,
  1 AS `secteur_id`,
  1 AS `address_id`,
  1 AS `status`,
  1 AS `order_date`,
  1 AS `amount`,
  1 AS `note`,
  1 AS `charge_id`,
  1 AS `tva`,
  1 AS `invoice_path`,
  1 AS `frais_livraison`,
  1 AS `montant_sans_frais_livraison`,
  1 AS `delivery_order_path` */;
SET character_set_client = @saved_cs_client;

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
  `stripe_data` longtext NOT NULL COMMENT '(DC2Type:array)',
  `agent_email` varchar(255) NOT NULL,
  `client_email` varchar(255) NOT NULL,
  `stripe_charge_id` varchar(255) NOT NULL,
  `statut` int(11) DEFAULT NULL,
  `invoice_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3D32E49C41DEFADA` (`devis_id`),
  KEY `IDX_3D32E49C3414710B` (`agent_id`),
  KEY `IDX_3D32E49C19EB6921` (`client_id`),
  CONSTRAINT `FK_3D32E49C19EB6921` FOREIGN KEY (`client_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_3D32E49C3414710B` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_3D32E49C41DEFADA` FOREIGN KEY (`devis_id`) REFERENCES `devis` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_digital`
--

LOCK TABLES `order_digital` WRITE;
/*!40000 ALTER TABLE `order_digital` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_digital` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_digital_devis_company`
--

DROP TABLE IF EXISTS `order_digital_devis_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_digital_devis_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `devis_company_id` int(11) NOT NULL,
  `total_amount_ht` double NOT NULL,
  `total_amount_ttc` double NOT NULL,
  `payment_condition` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_mail` varchar(255) NOT NULL,
  `client_phone` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `stripe_data` longtext DEFAULT NULL COMMENT '(DC2Type:array)',
  `stripe_charge_id` varchar(255) DEFAULT NULL,
  `iteration_payment` int(11) DEFAULT NULL,
  `amount_with_condition_payment` double DEFAULT NULL,
  `stripe_customer_id` varchar(255) DEFAULT NULL,
  `stripe_sub_sched_id` varchar(255) DEFAULT NULL,
  `stripe_price_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C8F9ABC1273A513E` (`devis_company_id`),
  CONSTRAINT `FK_C8F9ABC1273A513E` FOREIGN KEY (`devis_company_id`) REFERENCES `devis_company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_digital_devis_company`
--

LOCK TABLES `order_digital_devis_company` WRITE;
/*!40000 ALTER TABLE `order_digital_devis_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_digital_devis_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `order_digital_valide`
--

DROP TABLE IF EXISTS `order_digital_valide`;
/*!50001 DROP VIEW IF EXISTS `order_digital_valide`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `order_digital_valide` AS SELECT
 1 AS `agent_id`,
  1 AS `secteur_id`,
  1 AS `client_id`,
  1 AS `date_order`,
  1 AS `amount`,
  1 AS `order_id` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `order_implantation_aroma`
--

DROP TABLE IF EXISTS `order_implantation_aroma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_implantation_aroma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_parent_id` int(11) NOT NULL,
  `implantation_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `remise_implantation` decimal(5,2) DEFAULT NULL,
  `qte_elmt_implantation` int(11) DEFAULT NULL,
  `reassort_implantation` tinyint(1) DEFAULT NULL,
  `prix_implantation` decimal(16,6) NOT NULL,
  `ug_implantation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_82A8C745CEFDB188` (`order_parent_id`),
  KEY `IDX_82A8C745CE296AF7` (`implantation_id`),
  CONSTRAINT `FK_82A8C745CE296AF7` FOREIGN KEY (`implantation_id`) REFERENCES `implantation_aroma` (`id`),
  CONSTRAINT `FK_82A8C745CEFDB188` FOREIGN KEY (`order_parent_id`) REFERENCES `order_aroma` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_implantation_aroma`
--

LOCK TABLES `order_implantation_aroma` WRITE;
/*!40000 ALTER TABLE `order_implantation_aroma` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_implantation_aroma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_implantation_elmt_aroma`
--

DROP TABLE IF EXISTS `order_implantation_elmt_aroma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_implantation_elmt_aroma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `implantation_elmt_id` int(11) NOT NULL,
  `order_implantation_parent_id` int(11) NOT NULL,
  `qte_gratuit_implantation_elmt` int(11) DEFAULT NULL,
  `prix_produit_implantation_elmt` decimal(16,6) NOT NULL,
  `prix_conseille_produit_implantation_elmt` decimal(16,6) DEFAULT NULL,
  `prix_produit_apres_reduction_implantation_elmt` decimal(16,6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4C867F7D3D449B94` (`implantation_elmt_id`),
  KEY `IDX_4C867F7D20DE809A` (`order_implantation_parent_id`),
  CONSTRAINT `FK_4C867F7D20DE809A` FOREIGN KEY (`order_implantation_parent_id`) REFERENCES `order_implantation_aroma` (`id`),
  CONSTRAINT `FK_4C867F7D3D449B94` FOREIGN KEY (`implantation_elmt_id`) REFERENCES `implantation_elmt_aroma` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_implantation_elmt_aroma`
--

LOCK TABLES `order_implantation_elmt_aroma` WRITE;
/*!40000 ALTER TABLE `order_implantation_elmt_aroma` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_implantation_elmt_aroma` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_product`
--

LOCK TABLES `order_product` WRITE;
/*!40000 ALTER TABLE `order_product` DISABLE KEYS */;
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
  `type_installation_id` int(11) DEFAULT NULL,
  `secteur_id` int(11) NOT NULL,
  `kitbase_id` int(11) DEFAULT NULL,
  `tva_id` int(11) DEFAULT NULL,
  `code_promo` varchar(255) DEFAULT NULL,
  `prix_produit` double NOT NULL,
  `statut` int(11) NOT NULL,
  `date_commande` datetime NOT NULL,
  `installation_frais` double DEFAULT NULL,
  `accomp_montant` double NOT NULL,
  `charge_id` varchar(255) NOT NULL,
  `contrat_rempli` varchar(500) DEFAULT NULL,
  `contrat_signed` varchar(500) DEFAULT NULL,
  `sepa` longtext DEFAULT NULL COMMENT '(DC2Type:json)',
  `tva_pourcentage` decimal(5,2) DEFAULT NULL,
  `invoice_path` varchar(255) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_secu`
--

LOCK TABLES `order_secu` WRITE;
/*!40000 ALTER TABLE `order_secu` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_secu_accomp`
--

LOCK TABLES `order_secu_accomp` WRITE;
/*!40000 ALTER TABLE `order_secu_accomp` DISABLE KEYS */;
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
  1 AS `type_installation_id`,
  1 AS `secteur_id`,
  1 AS `kitbase_id`,
  1 AS `tva_id`,
  1 AS `code_promo`,
  1 AS `prix_produit`,
  1 AS `statut`,
  1 AS `date_commande`,
  1 AS `installation_frais`,
  1 AS `accomp_montant`,
  1 AS `charge_id`,
  1 AS `contrat_rempli`,
  1 AS `contrat_signed`,
  1 AS `sepa`,
  1 AS `tva_pourcentage`,
  1 AS `invoice_path`,
  1 AS `montant_ttc` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
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
  1 AS `charge_id`,
  1 AS `tva`,
  1 AS `invoice_path` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `plan_agent_account`
--

DROP TABLE IF EXISTS `plan_agent_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plan_agent_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stipe_product_id` varchar(50) NOT NULL,
  `stripe_price_id` varchar(50) NOT NULL,
  `stripe_price_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `price_interval_unit` varchar(50) NOT NULL,
  `status` varchar(255) NOT NULL,
  `status_change` varchar(100) DEFAULT NULL,
  `price_metadata` longtext DEFAULT NULL COMMENT '(DC2Type:array)',
  `old_stripe_price_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan_agent_account`
--

LOCK TABLES `plan_agent_account` WRITE;
/*!40000 ALTER TABLE `plan_agent_account` DISABLE KEYS */;
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
  `nom` varchar(255) NOT NULL,
  `description` varchar(800) DEFAULT NULL,
  `prix` decimal(10,3) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_29A5EC279F7E4405` (`secteur_id`),
  KEY `IDX_29A5EC27C9486A13` (`id_categorie`),
  CONSTRAINT `FK_29A5EC279F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`),
  CONSTRAINT `FK_29A5EC27C9486A13` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit`
--

LOCK TABLES `produit` WRITE;
/*!40000 ALTER TABLE `produit` DISABLE KEYS */;
/*!40000 ALTER TABLE `produit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit_aroma`
--

DROP TABLE IF EXISTS `produit_aroma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit_aroma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `prix` decimal(16,6) NOT NULL,
  `statut` int(11) NOT NULL,
  `prix_conseille` decimal(16,6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_aroma`
--

LOCK TABLES `produit_aroma` WRITE;
/*!40000 ALTER TABLE `produit_aroma` DISABLE KEYS */;
/*!40000 ALTER TABLE `produit_aroma` ENABLE KEYS */;
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
  `nom` varchar(255) NOT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BA9A00B69F7E4405` (`secteur_id`),
  KEY `IDX_BA9A00B6C9486A13` (`id_categorie`),
  CONSTRAINT `FK_BA9A00B69F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`),
  CONSTRAINT `FK_BA9A00B6C9486A13` FOREIGN KEY (`id_categorie`) REFERENCES `categorie_dd` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_dd`
--

LOCK TABLES `produit_dd` WRITE;
/*!40000 ALTER TABLE `produit_dd` DISABLE KEYS */;
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
  1 AS `qte` */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_favori`
--

LOCK TABLES `produit_favori` WRITE;
/*!40000 ALTER TABLE `produit_favori` DISABLE KEYS */;
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
  1 AS `qte_stock` */;
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
  `nom` varchar(255) NOT NULL,
  `description` varchar(800) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_51F5199D9F7E4405` (`secteur_id`),
  KEY `IDX_51F5199DC9486A13` (`id_categorie`),
  CONSTRAINT `FK_51F5199D9F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`),
  CONSTRAINT `FK_51F5199DC9486A13` FOREIGN KEY (`id_categorie`) REFERENCES `categorie_secu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_secu`
--

LOCK TABLES `produit_secu` WRITE;
/*!40000 ALTER TABLE `produit_secu` DISABLE KEYS */;
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
  `nom` varchar(255) NOT NULL,
  `description` varchar(800) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E626D4219F7E4405` (`secteur_id`),
  CONSTRAINT `FK_E626D4219F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_secu_accomp`
--

LOCK TABLES `produit_secu_accomp` WRITE;
/*!40000 ALTER TABLE `produit_secu_accomp` DISABLE KEYS */;
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
  1 AS `qte_mouvement` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ref_client`
--

DROP TABLE IF EXISTS `ref_client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secteur_id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B25D6CAC9F7E4405` (`secteur_id`),
  CONSTRAINT `FK_B25D6CAC9F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_client`
--

LOCK TABLES `ref_client` WRITE;
/*!40000 ALTER TABLE `ref_client` DISABLE KEYS */;
/*!40000 ALTER TABLE `ref_client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_service`
--

DROP TABLE IF EXISTS `ref_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secteur_id` int(11) NOT NULL,
  `ref` varchar(255) DEFAULT NULL,
  `designation` longtext DEFAULT NULL,
  `prix` decimal(12,2) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2589C9029F7E4405` (`secteur_id`),
  CONSTRAINT `FK_2589C9029F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_service`
--

LOCK TABLES `ref_service` WRITE;
/*!40000 ALTER TABLE `ref_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `ref_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_societe`
--

DROP TABLE IF EXISTS `ref_societe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_societe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secteur_id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DD716E6D9F7E4405` (`secteur_id`),
  CONSTRAINT `FK_DD716E6D9F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_societe`
--

LOCK TABLES `ref_societe` WRITE;
/*!40000 ALTER TABLE `ref_societe` DISABLE KEYS */;
/*!40000 ALTER TABLE `ref_societe` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rformation_categorie`
--

LOCK TABLES `rformation_categorie` WRITE;
/*!40000 ALTER TABLE `rformation_categorie` DISABLE KEYS */;
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
  `nom` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `active` int(11) DEFAULT 1,
  `couverture` varchar(255) DEFAULT NULL,
  `liens` varchar(255) DEFAULT NULL,
  `long_description` longtext DEFAULT NULL,
  `title` longtext DEFAULT NULL,
  `affiche` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8045251FC54C8C93` (`type_id`),
  CONSTRAINT `FK_8045251FC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type_secteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secteur`
--

LOCK TABLES `secteur` WRITE;
/*!40000 ALTER TABLE `secteur` DISABLE KEYS */;
INSERT INTO `secteur` VALUES (1,1,'Finance','Finance',0,NULL,NULL,NULL,NULL,NULL),(2,2,'Devis','Monde du digital et des services',-1,NULL,NULL,NULL,NULL,NULL),(9,1,'Digital','Plateforme avec des services digitales',1,'images/secteur/couverture/Capture d’écran 2024-05-08 à 11.41.04.png','https://pixelsiorbuzzboosters.fr/','<p>Chez Pixelsior Buzz Boosters, nous sommes les pionniers d&#39;une pr&eacute;sence en ligne sans limites. Notre &eacute;quipe de super-h&eacute;ros du num&eacute;rique d&eacute;ploie des strat&eacute;gies audacieuses et utilise les derni&egrave;res tendances technologiques pour propulser nos clients vers le succ&egrave;s mondial.</p>\r\n\r\n<p>Avec notre approche centr&eacute;e sur vous, nous formons une &eacute;quipe redoutable, comprenant vos besoins uniques afin de cr&eacute;er des solutions digitales sur-mesure qui dynamisent votre marque, g&eacute;n&egrave;rent des prospects et convertissent &agrave; la vitesse de l&#39;&eacute;clair. Pr&eacute;parez-vous &agrave; conqu&eacute;rir le royaume num&eacute;rique avec Pixelsior Buzz Boosters, le fleuron britannique de l&#39;excellence digitale !</p>\r\n\r\n<p>Avec plus de 12 ans d&#39;exp&eacute;rience, nous transformons votre pr&eacute;sence en ligne en un levier de chiffre d&#39;affaires.</p>\r\n\r\n<p>Nous unissons cr&eacute;ativit&eacute; et innovation pour mat&eacute;rialiser vos visions, faisant de chaque id&eacute;e une r&eacute;alit&eacute; digitale captivante. Pixelsior Buzz Boosters, le moteur de votre succ&egrave;s.&quot;</p>\r\n\r\n<p>Veuillez cliquer ici pour voir les catalogues :&nbsp;<a href=\"https://pixelsiorbuzzboosters.fr/\" target=\"_blank\">Catalogues pour le digital</a></p>\r\n\r\n<p>Et pour acc&eacute;der &agrave; la plateforme pour la suivie des projets, veuillez vous rendre sur :&nbsp;<a href=\"http://localhost:4200/users/login\" target=\"_blank\">Plateforme de gestion des projets</a></p>','Votre catalyseur de croissance numérique : pixelsior buzz boosters',NULL),(10,1,'MLM',NULL,0,NULL,NULL,NULL,NULL,NULL),(11,1,'Gaming',NULL,0,NULL,NULL,NULL,NULL,NULL),(12,1,'RWA',NULL,0,NULL,NULL,NULL,NULL,NULL);
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
  1 AS `active` */;
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
  1 AS `ca` */;
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
  1 AS `ca` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stat_vente_aroma_agent`
--

DROP TABLE IF EXISTS `stat_vente_aroma_agent`;
/*!50001 DROP VIEW IF EXISTS `stat_vente_aroma_agent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stat_vente_aroma_agent` AS SELECT
 1 AS `agent_id`,
  1 AS `secteur_id`,
  1 AS `nbr_ventes`,
  1 AS `ca` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stat_vente_aroma_tout_agent`
--

DROP TABLE IF EXISTS `stat_vente_aroma_tout_agent`;
/*!50001 DROP VIEW IF EXISTS `stat_vente_aroma_tout_agent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stat_vente_aroma_tout_agent` AS SELECT
 1 AS `id`,
  1 AS `agent_id`,
  1 AS `secteur_id`,
  1 AS `nbr_ventes`,
  1 AS `ca`,
  1 AS `type_secteur_id` */;
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
  1 AS `ca` */;
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
  1 AS `type_secteur_id` */;
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
  1 AS `ca` */;
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
  1 AS `type_secteur_id` */;
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
  1 AS `ca` */;
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
  1 AS `ca` */;
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
  1 AS `type_secteur_id` */;
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
  1 AS `type_secteur_id` */;
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
  `user_email` varchar(255) NOT NULL,
  `stripe_subscription_id` varchar(255) NOT NULL,
  `stripe_custumer_id` varchar(255) DEFAULT NULL,
  `stripe_price_id` varchar(255) NOT NULL,
  `stripe_product_id` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `stripe_subscription_interval` varchar(50) NOT NULL,
  `stripe_subscription_status` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `stripe_price_name` varchar(100) NOT NULL,
  `stripe_data` longtext NOT NULL COMMENT '(DC2Type:array)',
  `old_price_amount` double DEFAULT NULL,
  `type_change` varchar(100) DEFAULT NULL,
  `old_stripe_price_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A838C211A76ED395` (`user_id`),
  KEY `IDX_A838C2115D70B8B9` (`plan_agent_account_id`),
  CONSTRAINT `FK_A838C2115D70B8B9` FOREIGN KEY (`plan_agent_account_id`) REFERENCES `plan_agent_account` (`id`),
  CONSTRAINT `FK_A838C211A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription_plan_agent_account`
--

LOCK TABLES `subscription_plan_agent_account` WRITE;
/*!40000 ALTER TABLE `subscription_plan_agent_account` DISABLE KEYS */;
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
  `libelle` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `couleur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'Intéressé','La personne est intéressée à devenir un client','success'),(2,'Froid','La personne n\'est pas trop intéressée','info');
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
INSERT INTO `tag_contact` VALUES (1,1);
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
  `secteur_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `valeur` decimal(5,2) NOT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E2429A999F7E4405` (`secteur_id`),
  CONSTRAINT `FK_E2429A999F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tva_secu`
--

LOCK TABLES `tva_secu` WRITE;
/*!40000 ALTER TABLE `tva_secu` DISABLE KEYS */;
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
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_abonnement_secu`
--

LOCK TABLES `type_abonnement_secu` WRITE;
/*!40000 ALTER TABLE `type_abonnement_secu` DISABLE KEYS */;
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
  `description` varchar(255) NOT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_installation_secu`
--

LOCK TABLES `type_installation_secu` WRITE;
/*!40000 ALTER TABLE `type_installation_secu` DISABLE KEYS */;
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
  `nom` varchar(255) NOT NULL,
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
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_secteur`
--

LOCK TABLES `type_secteur` WRITE;
/*!40000 ALTER TABLE `type_secteur` DISABLE KEYS */;
INSERT INTO `type_secteur` VALUES (1,'Standard'),(2,'Demande de devis');
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
  `email` varchar(180) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `date_naissance` datetime DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `numero_securite` varchar(255) DEFAULT NULL,
  `rib` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `six_digit_code` int(11) DEFAULT NULL,
  `forgotten_pass_token` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `api_token` varchar(255) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `code_postal` varchar(255) DEFAULT NULL,
  `lien_calendly` varchar(255) DEFAULT NULL,
  `stripe_data` longtext DEFAULT NULL COMMENT '(DC2Type:array)',
  `account_status` varchar(50) DEFAULT NULL,
  `account_start_date` datetime DEFAULT NULL,
  `stripe_customer_id` varchar(50) DEFAULT NULL,
  `numero_rue` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `ambassador_username` varchar(255) DEFAULT NULL,
  `parrain_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  KEY `IDX_8D93D649771A4A5A` (`contact_client_id`),
  KEY `IDX_8D93D6491AF241CE` (`client_agent_id`),
  KEY `IDX_8D93D649DE2A7A37` (`parrain_id`),
  CONSTRAINT `FK_8D93D6491AF241CE` FOREIGN KEY (`client_agent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_8D93D649771A4A5A` FOREIGN KEY (`contact_client_id`) REFERENCES `contact` (`id`),
  CONSTRAINT `FK_8D93D649DE2A7A37` FOREIGN KEY (`parrain_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,NULL,NULL,'mnakanyandriamihaja@gmail.com','admin','[\"ROLE_ADMINISTRATEUR\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel',NULL,'Antananarivo',NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2024-04-29 19:56:07','00101',NULL,'a:0:{}','Actif',NULL,NULL,'12','Antananarivo',NULL,NULL),(2,NULL,NULL,'mnakanyandriamihaja+testcoach@gmail.com',NULL,'[\"ROLE_COACH\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel','1999-01-01 00:00:00','Antananarivo','111','111',NULL,NULL,NULL,-1,NULL,NULL,'2024-04-30 05:35:42',NULL,NULL,'a:0:{}',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,NULL,NULL,'mnakanyandriamihaja+testcoachdigital@gmail.com','coachdigital','[\"ROLE_COACH\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel','1999-01-01 00:00:00','Antananarivo','111','111',NULL,NULL,NULL,1,NULL,NULL,'2024-04-30 05:36:41',NULL,NULL,'a:0:{}',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,NULL,NULL,'mnakanyandriamihaja+testcoachfinance@gmail.com','coachfinance','[\"ROLE_COACH\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel','1999-01-01 00:00:00','Antananarivo','111','111',NULL,NULL,NULL,1,NULL,NULL,'2024-04-30 05:37:30',NULL,NULL,'a:0:{}',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,NULL,NULL,'mnakanyandriamihaja+testagent@gmail.com','agentfinance','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel',NULL,'Antananarivo',NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2024-04-30 05:54:34','00101','https://calendly.com/mnakanyandriamihaja','a:0:{}','Actif','2024-04-30 05:54:49',NULL,'12','Antananarivo',NULL,NULL),(6,NULL,NULL,'mnakanyandriamihaja+testpresentation@gmail.com','testpresentation','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel',NULL,'Antananarivo',NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2024-04-30 09:17:42','00101',NULL,'a:0:{}','Actif','2024-04-30 09:22:00',NULL,'12','Antananarivo',NULL,NULL),(9,NULL,NULL,'mnakanyandriamihaja+test2mai@gmail.com','michel','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany','Michel',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2024-05-02 12:17:58','101',NULL,'a:0:{}','Actif',NULL,NULL,NULL,'Tana',NULL,NULL),(10,NULL,NULL,'mnakanyandriamihaja+test2mai1@gmail.com','michel1','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2024-05-02 12:18:47','00101',NULL,'a:0:{}','Actif',NULL,NULL,NULL,'Antananarivo',NULL,NULL),(12,NULL,NULL,'mnakanyandriamihaja+test2mai2@gmail.com','michel2','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2024-05-02 12:23:45','00101',NULL,'a:0:{}','Actif',NULL,NULL,NULL,'Antananarivo',NULL,NULL),(13,NULL,NULL,'mnakanyandriamihaja+test3mai@gmail.com','michel3mai','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2024-05-03 06:14:12','00101',NULL,'a:0:{}','Actif',NULL,NULL,NULL,'Antananarivo',NULL,NULL),(14,NULL,NULL,'mnakanyandriamihaja+test3mai1@gmail.com','test3mai1','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2024-05-03 07:00:48','00101',NULL,'a:0:{}','Actif',NULL,NULL,NULL,'Antananarivo',NULL,NULL),(15,NULL,NULL,'mnakanyandriamihaja+test3mai3@gmail.com','test3mai3','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2024-05-03 07:09:01','00101',NULL,'a:0:{}','Actif','2024-05-03 07:38:02',NULL,NULL,'Antananarivo',NULL,NULL),(16,NULL,NULL,'michel@gmail.com','test6mai10','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany','Michel',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,'0343434434','2024-05-06 18:47:53',NULL,NULL,'a:0:{}','Actif',NULL,NULL,NULL,NULL,NULL,NULL),(17,NULL,NULL,'mnakanyandriamihaja+test7mai@gmail.com','test7mai','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2024-05-07 07:21:10',NULL,NULL,'a:0:{}','Actif','2024-05-07 12:21:37',NULL,NULL,NULL,'michel',NULL),(18,NULL,NULL,'mnakanyandriamihaja+test7mai1@gmail.com','test7mai1','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel',NULL,'Antananarivo',NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2024-05-07 07:22:40','00101',NULL,'a:0:{}','Actif','2024-05-07 09:26:00',NULL,NULL,'Antananarivo',NULL,NULL),(19,NULL,NULL,'mnakanyandriamihaja+test7mai2@gmail.com','test7mai2','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel',NULL,'Antananarivo',NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2024-05-07 07:25:03','00101',NULL,'a:0:{}','Actif',NULL,NULL,NULL,'Antananarivo','jean',NULL),(20,NULL,NULL,'mnakanyandriamihaja+coachpbb2@gmail.com','coachpbb2','[\"ROLE_COACH\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel','2000-01-01 00:00:00','Antananarivo','111','111',NULL,NULL,NULL,1,NULL,'0349331431','2024-05-07 12:44:33','101','https://calendly.com/mnakanyandriamihaja','a:0:{}',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(21,NULL,NULL,'mnakanyandriamihaja+ambassador@gmail.com','ambassador','[\"ROLE_AMBASSADEUR\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Nakany Andriamihaja','Michel','1999-01-01 00:00:00','Antananarivo','121','12',NULL,NULL,NULL,1,NULL,NULL,'2024-05-07 16:53:58',NULL,NULL,'a:0:{}',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,NULL,NULL,'mnakanyandriamihaja+test7mai10@gmail.com','test7mai10','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Michel','Nakany Andriamihaja',NULL,'AK 37 Ankadikely Ilafy',NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2024-05-07 16:55:18','00101',NULL,'a:0:{}','Actif','2024-05-07 16:56:27',NULL,NULL,'Antananarivo','ambassador',21),(23,NULL,NULL,'jeanchris@gmail.com','jeanchris','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Jean','Chris',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,'242442422','2024-05-08 07:45:09',NULL,'https://calendly.com/mnakanyandriamihaja','a:0:{}','Actif','2024-05-08 07:50:08',NULL,NULL,NULL,'ambassador',21),(24,NULL,NULL,'sarah@gmail.com','sarah','[\"ROLE_AGENT\"]','$2y$13$k6lcHjNjs2j8xHG3tG4Z3.G522RMUP/kOD2dPxbzYBCosnZcovLN.','Borger','Sarah',NULL,'Antananarivo',NULL,NULL,NULL,NULL,NULL,1,NULL,'0349331431','2024-05-08 10:01:28','00101','https://calendly.com/mnakanyandriamihaja','a:0:{}','Actif','2024-05-08 10:03:40',NULL,NULL,'Antananarivo','ambassador',21);
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
  `uri` varchar(255) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `video_id` varchar(255) DEFAULT NULL,
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
-- Temporary table structure for view `view_implantation_aroma`
--

DROP TABLE IF EXISTS `view_implantation_aroma`;
/*!50001 DROP VIEW IF EXISTS `view_implantation_aroma`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_implantation_aroma` AS SELECT
 1 AS `id`,
  1 AS `nom`,
  1 AS `description`,
  1 AS `image`,
  1 AS `statut`,
  1 AS `reassort`,
  1 AS `qte_elmt`,
  1 AS `remise`,
  1 AS `mere_id` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_implantation_aroma_total`
--

DROP TABLE IF EXISTS `view_implantation_aroma_total`;
/*!50001 DROP VIEW IF EXISTS `view_implantation_aroma_total`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_implantation_aroma_total` AS SELECT
 1 AS `id`,
  1 AS `total`,
  1 AS `ug` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_implantation_aroma_total_full`
--

DROP TABLE IF EXISTS `view_implantation_aroma_total_full`;
/*!50001 DROP VIEW IF EXISTS `view_implantation_aroma_total_full`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_implantation_aroma_total_full` AS SELECT
 1 AS `id`,
  1 AS `total`,
  1 AS `ug`,
  1 AS `implantation_id` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_implantation_aroma_valid`
--

DROP TABLE IF EXISTS `view_implantation_aroma_valid`;
/*!50001 DROP VIEW IF EXISTS `view_implantation_aroma_valid`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_implantation_aroma_valid` AS SELECT
 1 AS `id`,
  1 AS `nom`,
  1 AS `description`,
  1 AS `image`,
  1 AS `statut`,
  1 AS `reassort`,
  1 AS `qte_elmt`,
  1 AS `remise`,
  1 AS `mere_id` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_implantation_elmt_aroma_valid`
--

DROP TABLE IF EXISTS `view_implantation_elmt_aroma_valid`;
/*!50001 DROP VIEW IF EXISTS `view_implantation_elmt_aroma_valid`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_implantation_elmt_aroma_valid` AS SELECT
 1 AS `id`,
  1 AS `mere_id`,
  1 AS `produit_id`,
  1 AS `statut`,
  1 AS `qte_gratuit`,
  1 AS `prix_produit`,
  1 AS `prix_conseille_produit` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_implantation_mere_aroma_total`
--

DROP TABLE IF EXISTS `view_implantation_mere_aroma_total`;
/*!50001 DROP VIEW IF EXISTS `view_implantation_mere_aroma_total`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_implantation_mere_aroma_total` AS SELECT
 1 AS `id`,
  1 AS `nbr_reassort`,
  1 AS `nbr_normal`,
  1 AS `nbr` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_implantation_mere_aroma_total_full`
--

DROP TABLE IF EXISTS `view_implantation_mere_aroma_total_full`;
/*!50001 DROP VIEW IF EXISTS `view_implantation_mere_aroma_total_full`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_implantation_mere_aroma_total_full` AS SELECT
 1 AS `id`,
  1 AS `implantation_mere_id`,
  1 AS `nbr_reassort`,
  1 AS `nbr_normal`,
  1 AS `nbr` */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `active_agent`
--

/*!50001 DROP VIEW IF EXISTS `active_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `active_agent` AS select `active_user`.`id` AS `id`,`active_user`.`contact_client_id` AS `contact_client_id`,`active_user`.`client_agent_id` AS `client_agent_id`,`active_user`.`email` AS `email`,`active_user`.`username` AS `username`,`active_user`.`roles` AS `roles`,`active_user`.`password` AS `password`,`active_user`.`nom` AS `nom`,`active_user`.`prenom` AS `prenom`,`active_user`.`date_naissance` AS `date_naissance`,`active_user`.`adresse` AS `adresse`,`active_user`.`numero_securite` AS `numero_securite`,`active_user`.`rib` AS `rib`,`active_user`.`photo` AS `photo`,`active_user`.`six_digit_code` AS `six_digit_code`,`active_user`.`forgotten_pass_token` AS `forgotten_pass_token`,`active_user`.`active` AS `active`,`active_user`.`api_token` AS `api_token`,`active_user`.`telephone` AS `telephone`,`active_user`.`created_at` AS `created_at`,`active_user`.`code_postal` AS `code_postal`,`active_user`.`lien_calendly` AS `lien_calendly`,`active_user`.`stripe_data` AS `stripe_data`,`active_user`.`account_status` AS `account_status`,`active_user`.`account_start_date` AS `account_start_date`,`active_user`.`stripe_customer_id` AS `stripe_customer_id`,`active_user`.`numero_rue` AS `numero_rue`,`active_user`.`ville` AS `ville` from `active_user` where json_contains(`active_user`.`roles`,'"ROLE_AGENT"','$') */;
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `active_clients` AS select `active_user`.`id` AS `id`,`active_user`.`contact_client_id` AS `contact_client_id`,`active_user`.`client_agent_id` AS `client_agent_id`,`active_user`.`email` AS `email`,`active_user`.`username` AS `username`,`active_user`.`roles` AS `roles`,`active_user`.`password` AS `password`,`active_user`.`nom` AS `nom`,`active_user`.`prenom` AS `prenom`,`active_user`.`date_naissance` AS `date_naissance`,`active_user`.`adresse` AS `adresse`,`active_user`.`numero_securite` AS `numero_securite`,`active_user`.`rib` AS `rib`,`active_user`.`photo` AS `photo`,`active_user`.`six_digit_code` AS `six_digit_code`,`active_user`.`forgotten_pass_token` AS `forgotten_pass_token`,`active_user`.`active` AS `active`,`active_user`.`api_token` AS `api_token`,`active_user`.`telephone` AS `telephone`,`active_user`.`created_at` AS `created_at`,`active_user`.`code_postal` AS `code_postal`,`active_user`.`lien_calendly` AS `lien_calendly`,`active_user`.`stripe_data` AS `stripe_data`,`active_user`.`account_status` AS `account_status`,`active_user`.`account_start_date` AS `account_start_date`,`active_user`.`stripe_customer_id` AS `stripe_customer_id`,`active_user`.`numero_rue` AS `numero_rue`,`active_user`.`ville` AS `ville` from `active_user` where json_contains(`active_user`.`roles`,'"ROLE_CLIENT"','$') */;
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `active_coach` AS select `active_user`.`id` AS `id`,`active_user`.`contact_client_id` AS `contact_client_id`,`active_user`.`client_agent_id` AS `client_agent_id`,`active_user`.`email` AS `email`,`active_user`.`username` AS `username`,`active_user`.`roles` AS `roles`,`active_user`.`password` AS `password`,`active_user`.`nom` AS `nom`,`active_user`.`prenom` AS `prenom`,`active_user`.`date_naissance` AS `date_naissance`,`active_user`.`adresse` AS `adresse`,`active_user`.`numero_securite` AS `numero_securite`,`active_user`.`rib` AS `rib`,`active_user`.`photo` AS `photo`,`active_user`.`six_digit_code` AS `six_digit_code`,`active_user`.`forgotten_pass_token` AS `forgotten_pass_token`,`active_user`.`active` AS `active`,`active_user`.`api_token` AS `api_token`,`active_user`.`telephone` AS `telephone`,`active_user`.`created_at` AS `created_at`,`active_user`.`code_postal` AS `code_postal`,`active_user`.`lien_calendly` AS `lien_calendly`,`active_user`.`stripe_data` AS `stripe_data`,`active_user`.`account_status` AS `account_status`,`active_user`.`account_start_date` AS `account_start_date`,`active_user`.`stripe_customer_id` AS `stripe_customer_id`,`active_user`.`numero_rue` AS `numero_rue`,`active_user`.`ville` AS `ville` from `active_user` where json_contains(`active_user`.`roles`,'"ROLE_COACH"','$') */;
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `active_user` AS select `user`.`id` AS `id`,`user`.`contact_client_id` AS `contact_client_id`,`user`.`client_agent_id` AS `client_agent_id`,`user`.`email` AS `email`,`user`.`username` AS `username`,`user`.`roles` AS `roles`,`user`.`password` AS `password`,`user`.`nom` AS `nom`,`user`.`prenom` AS `prenom`,`user`.`date_naissance` AS `date_naissance`,`user`.`adresse` AS `adresse`,`user`.`numero_securite` AS `numero_securite`,`user`.`rib` AS `rib`,`user`.`photo` AS `photo`,`user`.`six_digit_code` AS `six_digit_code`,`user`.`forgotten_pass_token` AS `forgotten_pass_token`,`user`.`active` AS `active`,`user`.`api_token` AS `api_token`,`user`.`telephone` AS `telephone`,`user`.`created_at` AS `created_at`,`user`.`code_postal` AS `code_postal`,`user`.`lien_calendly` AS `lien_calendly`,`user`.`stripe_data` AS `stripe_data`,`user`.`account_status` AS `account_status`,`user`.`account_start_date` AS `account_start_date`,`user`.`stripe_customer_id` AS `stripe_customer_id`,`user`.`numero_rue` AS `numero_rue`,`user`.`ville` AS `ville` from `user` where 0 <> `user`.`active` */;
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `all_type_order_valide` AS select `order_secu_valide`.`agent_id` AS `agent_id`,`order_secu_valide`.`secteur_id` AS `secteur_id`,`order_secu_valide`.`client_id` AS `client_id`,`order_secu_valide`.`montant_ttc` AS `montant`,`order_secu_valide`.`date_commande` AS `date_commande` from `order_secu_valide` union all select `order_valide`.`agent_id` AS `agent_id`,`order_valide`.`secteur_id` AS `secteur_id`,`order_valide`.`user_id` AS `user_id`,`order_valide`.`amount` AS `amount`,`order_valide`.`order_date` AS `order_date` from `order_valide` union all select `order_digital_valide`.`agent_id` AS `agent_id`,`order_digital_valide`.`secteur_id` AS `secteur_id`,`order_digital_valide`.`client_id` AS `client_id`,`order_digital_valide`.`amount` AS `amount`,`order_digital_valide`.`date_order` AS `date_order` from `order_digital_valide` union all select `order_aroma_valide`.`agent_id` AS `agent_id`,`order_aroma_valide`.`secteur_id` AS `secteur_id`,`order_aroma_valide`.`user_id` AS `user_id`,`order_aroma_valide`.`amount` AS `amount`,`order_aroma_valide`.`order_date` AS `order_date` from `order_aroma_valide` */;
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `all_type_order_valide_all_client` AS select `a`.`agent_id` AS `agent_id`,`a`.`secteur_id` AS `secteur_id`,`a`.`client_id` AS `client_id`,coalesce(`o`.`montant`,0) AS `montant`,coalesce(`o`.`nbr`,0) AS `nbr` from (`agent_secteur_client_valide` `a` left join `all_type_order_valide_per_client` `o` on(`a`.`agent_id` = `o`.`agent_id` and `a`.`secteur_id` = `o`.`secteur_id` and `a`.`client_id` = `o`.`client_id`)) */;
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `les_mois` AS select 1 AS `mois`,'Janvier' AS `mois_str` union all select 2 AS `mois`,'Février' AS `mois_str` union all select 3 AS `mois`,'Mars' AS `mois_str` union all select 4 AS `mois`,'Avril' AS `mois_str` union all select 5 AS `mois`,'Mai' AS `mois_str` union all select 6 AS `mois`,'Juin' AS `mois_str` union all select 7 AS `mois`,'Juillet' AS `mois_str` union all select 8 AS `mois`,'Août' AS `mois_str` union all select 9 AS `mois`,'Septembre' AS `mois_str` union all select 10 AS `mois`,'Octobre' AS `mois_str` union all select 11 AS `mois`,'Novembre' AS `mois_str` union all select 12 AS `mois`,'Décembre' AS `mois_str` */;
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
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `mouvement_valid` AS select `mouvement`.`id` AS `id`,`mouvement`.`produit_id` AS `produit_id`,`mouvement`.`date_mouvement` AS `date_mouvement`,`mouvement`.`entree` AS `entree`,`mouvement`.`sortie` AS `sortie`,`mouvement`.`statut` AS `statut` from `mouvement` where `mouvement`.`statut` is null or `mouvement`.`statut` <> 0 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `order_aroma_valide`
--

/*!50001 DROP VIEW IF EXISTS `order_aroma_valide`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `order_aroma_valide` AS select `order_aroma`.`id` AS `id`,`order_aroma`.`user_id` AS `user_id`,`order_aroma`.`agent_id` AS `agent_id`,`order_aroma`.`secteur_id` AS `secteur_id`,`order_aroma`.`address_id` AS `address_id`,`order_aroma`.`status` AS `status`,`order_aroma`.`order_date` AS `order_date`,`order_aroma`.`amount` AS `amount`,`order_aroma`.`note` AS `note`,`order_aroma`.`charge_id` AS `charge_id`,`order_aroma`.`tva` AS `tva`,`order_aroma`.`invoice_path` AS `invoice_path`,`order_aroma`.`frais_livraison` AS `frais_livraison`,`order_aroma`.`montant_sans_frais_livraison` AS `montant_sans_frais_livraison`,`order_aroma`.`delivery_order_path` AS `delivery_order_path` from `order_aroma` where `order_aroma`.`status` between 1 and 99 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `order_digital_valide`
--

/*!50001 DROP VIEW IF EXISTS `order_digital_valide`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `order_digital_valide` AS select `dd`.`agent_id` AS `agent_id`,`dd`.`secteur_id` AS `secteur_id`,`dd`.`client_id` AS `client_id`,`od`.`created_at` AS `date_order`,`od`.`amount` AS `amount`,`od`.`id` AS `order_id` from ((`order_digital` `od` join `devis` `d` on(`od`.`devis_id` = `d`.`id`)) join `demande_devis` `dd` on(`d`.`demande_devis_id` = `dd`.`id`)) where `od`.`statut` = 1 union all select `dc`.`agent_id` AS `agent_id`,`dc`.`secteur_id` AS `secteur_id`,NULL AS `NULL`,`oddc`.`created_at` AS `created_at`,`oddc`.`total_amount_ttc` AS `total_amount_ttc`,`oddc`.`id` AS `id` from (`order_digital_devis_company` `oddc` join `devis_company` `dc` on(`oddc`.`devis_company_id` = `dc`.`id`)) */;
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `order_secu_valide` AS select `os`.`id` AS `id`,`os`.`produit_id` AS `produit_id`,`os`.`type_abonnement_id` AS `type_abonnement_id`,`os`.`agent_id` AS `agent_id`,`os`.`client_id` AS `client_id`,`os`.`type_installation_id` AS `type_installation_id`,`os`.`secteur_id` AS `secteur_id`,`os`.`kitbase_id` AS `kitbase_id`,`os`.`tva_id` AS `tva_id`,`os`.`code_promo` AS `code_promo`,`os`.`prix_produit` AS `prix_produit`,`os`.`statut` AS `statut`,`os`.`date_commande` AS `date_commande`,`os`.`installation_frais` AS `installation_frais`,`os`.`accomp_montant` AS `accomp_montant`,`os`.`charge_id` AS `charge_id`,`os`.`contrat_rempli` AS `contrat_rempli`,`os`.`contrat_signed` AS `contrat_signed`,`os`.`sepa` AS `sepa`,`os`.`tva_pourcentage` AS `tva_pourcentage`,`os`.`invoice_path` AS `invoice_path`,(`os`.`accomp_montant` + `os`.`prix_produit`) * (1 + `os`.`tva_pourcentage` / 100) AS `montant_ttc` from `order_secu` `os` where `os`.`statut` between 1 and 99 */;
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `order_valide` AS select `order`.`id` AS `id`,`order`.`user_id` AS `user_id`,`order`.`address_id` AS `address_id`,`order`.`agent_id` AS `agent_id`,`order`.`secteur_id` AS `secteur_id`,`order`.`order_date` AS `order_date`,`order`.`amount` AS `amount`,`order`.`status` AS `status`,`order`.`charge_id` AS `charge_id`,`order`.`tva` AS `tva`,`order`.`invoice_path` AS `invoice_path` from `order` where `order`.`status` between 1 and 99 */;
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
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `secteur_active` AS select `secteur`.`id` AS `id`,`secteur`.`type_id` AS `type_id`,`secteur`.`nom` AS `nom`,`secteur`.`description` AS `description`,`secteur`.`active` AS `active` from `secteur` where 0 <> `secteur`.`active` */;
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_agent` AS select `stat_vente_secu_agent`.`agent_id` AS `agent_id`,`stat_vente_secu_agent`.`secteur_id` AS `secteur_id`,`stat_vente_secu_agent`.`nbr_ventes` AS `nbr_ventes`,`stat_vente_secu_agent`.`ca` AS `ca` from `stat_vente_secu_agent` union all select `stat_vente_ecommerce_agent`.`agent_id` AS `agent_id`,`stat_vente_ecommerce_agent`.`secteur_id` AS `secteur_id`,`stat_vente_ecommerce_agent`.`nbr_ventes` AS `nbr_ventes`,`stat_vente_ecommerce_agent`.`ca` AS `ca` from `stat_vente_ecommerce_agent` union all select `stat_vente_dd_agent`.`agent_id` AS `agent_id`,`stat_vente_dd_agent`.`secteur_id` AS `secteur_id`,`stat_vente_dd_agent`.`nbr_ventes` AS `nbr_ventes`,`stat_vente_dd_agent`.`ca` AS `ca` from `stat_vente_dd_agent` union all select `stat_vente_aroma_agent`.`agent_id` AS `agent_id`,`stat_vente_aroma_agent`.`secteur_id` AS `secteur_id`,`stat_vente_aroma_agent`.`nbr_ventes` AS `nbr_ventes`,`stat_vente_aroma_agent`.`ca` AS `ca` from `stat_vente_aroma_agent` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stat_vente_aroma_agent`
--

/*!50001 DROP VIEW IF EXISTS `stat_vente_aroma_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_aroma_agent` AS select `order_aroma_valide`.`agent_id` AS `agent_id`,`order_aroma_valide`.`secteur_id` AS `secteur_id`,count(`order_aroma_valide`.`id`) AS `nbr_ventes`,sum(`order_aroma_valide`.`amount`) AS `ca` from `order_aroma_valide` group by `order_aroma_valide`.`agent_id`,`order_aroma_valide`.`secteur_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stat_vente_aroma_tout_agent`
--

/*!50001 DROP VIEW IF EXISTS `stat_vente_aroma_tout_agent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_aroma_tout_agent` AS select `ase`.`id` AS `id`,`ase`.`agent_id` AS `agent_id`,`ase`.`secteur_id` AS `secteur_id`,coalesce(`sv`.`nbr_ventes`,0) AS `nbr_ventes`,coalesce(`sv`.`ca`,0) AS `ca`,`ase`.`type_secteur_id` AS `type_secteur_id` from ((select `agent_secteur_valide`.`id` AS `id`,`agent_secteur_valide`.`agent_id` AS `agent_id`,`agent_secteur_valide`.`secteur_id` AS `secteur_id`,`agent_secteur_valide`.`date_validation` AS `date_validation`,`agent_secteur_valide`.`statut` AS `statut`,`agent_secteur_valide`.`type_secteur_id` AS `type_secteur_id` from `agent_secteur_valide` where `agent_secteur_valide`.`type_secteur_id` = 4) `ase` left join `stat_vente_aroma_agent` `sv` on(`ase`.`agent_id` = `sv`.`agent_id` and `ase`.`secteur_id` = `sv`.`secteur_id`)) */;
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
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_dd_agent` AS select `order_digital_valide`.`agent_id` AS `agent_id`,`order_digital_valide`.`secteur_id` AS `secteur_id`,count(`order_digital_valide`.`order_id`) AS `nbr_ventes`,sum(`order_digital_valide`.`amount`) AS `ca` from `order_digital_valide` group by `order_digital_valide`.`agent_id`,`order_digital_valide`.`secteur_id` */;
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_dd_tout_agent` AS select `ase`.`id` AS `id`,`ase`.`agent_id` AS `agent_id`,`ase`.`secteur_id` AS `secteur_id`,coalesce(`sv`.`nbr_ventes`,0) AS `nbr_ventes`,coalesce(`sv`.`ca`,0) AS `ca`,`ase`.`type_secteur_id` AS `type_secteur_id` from ((select `agent_secteur_valide`.`id` AS `id`,`agent_secteur_valide`.`agent_id` AS `agent_id`,`agent_secteur_valide`.`secteur_id` AS `secteur_id`,`agent_secteur_valide`.`date_validation` AS `date_validation`,`agent_secteur_valide`.`statut` AS `statut`,`agent_secteur_valide`.`type_secteur_id` AS `type_secteur_id` from `agent_secteur_valide` where `agent_secteur_valide`.`type_secteur_id` = 2) `ase` left join `stat_vente_dd_agent` `sv` on(`ase`.`agent_id` = `sv`.`agent_id` and `ase`.`secteur_id` = `sv`.`secteur_id`)) */;
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_ecommerce_tout_agent` AS select `ase`.`id` AS `id`,`ase`.`agent_id` AS `agent_id`,`ase`.`secteur_id` AS `secteur_id`,coalesce(`sv`.`nbr_ventes`,0) AS `nbr_ventes`,coalesce(`sv`.`ca`,0) AS `ca`,`ase`.`type_secteur_id` AS `type_secteur_id` from ((select `agent_secteur_valide`.`id` AS `id`,`agent_secteur_valide`.`agent_id` AS `agent_id`,`agent_secteur_valide`.`secteur_id` AS `secteur_id`,`agent_secteur_valide`.`date_validation` AS `date_validation`,`agent_secteur_valide`.`statut` AS `statut`,`agent_secteur_valide`.`type_secteur_id` AS `type_secteur_id` from `agent_secteur_valide` where `agent_secteur_valide`.`type_secteur_id` = 1) `ase` left join `stat_vente_ecommerce_agent` `sv` on(`ase`.`agent_id` = `sv`.`agent_id` and `ase`.`secteur_id` = `sv`.`secteur_id`)) */;
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_secteur` AS select `s`.`id` AS `secteur_id`,coalesce(`t`.`nbr_ventes`,0) AS `nbr_ventes`,coalesce(`t`.`ca`,0) AS `ca` from (`secteur_active` `s` left join (select `stat_vente_agent`.`secteur_id` AS `secteur_id`,sum(`stat_vente_agent`.`nbr_ventes`) AS `nbr_ventes`,sum(`stat_vente_agent`.`ca`) AS `ca` from `stat_vente_agent` group by `stat_vente_agent`.`secteur_id`) `t` on(`s`.`id` = `t`.`secteur_id`)) */;
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_secu_tout_agent` AS select `ase`.`id` AS `id`,`ase`.`agent_id` AS `agent_id`,`ase`.`secteur_id` AS `secteur_id`,coalesce(`sv`.`nbr_ventes`,0) AS `nbr_ventes`,coalesce(`sv`.`ca`,0) AS `ca`,`ase`.`type_secteur_id` AS `type_secteur_id` from ((select `agent_secteur_valide`.`id` AS `id`,`agent_secteur_valide`.`agent_id` AS `agent_id`,`agent_secteur_valide`.`secteur_id` AS `secteur_id`,`agent_secteur_valide`.`date_validation` AS `date_validation`,`agent_secteur_valide`.`statut` AS `statut`,`agent_secteur_valide`.`type_secteur_id` AS `type_secteur_id` from `agent_secteur_valide` where `agent_secteur_valide`.`type_secteur_id` = 3) `ase` left join `stat_vente_secu_agent` `sv` on(`ase`.`agent_id` = `sv`.`agent_id` and `ase`.`secteur_id` = `sv`.`secteur_id`)) */;
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
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `stat_vente_tout_agent` AS select `stat_vente_secu_tout_agent`.`id` AS `id`,`stat_vente_secu_tout_agent`.`agent_id` AS `agent_id`,`stat_vente_secu_tout_agent`.`secteur_id` AS `secteur_id`,`stat_vente_secu_tout_agent`.`nbr_ventes` AS `nbr_ventes`,`stat_vente_secu_tout_agent`.`ca` AS `ca`,`stat_vente_secu_tout_agent`.`type_secteur_id` AS `type_secteur_id` from `stat_vente_secu_tout_agent` union all select `stat_vente_ecommerce_tout_agent`.`id` AS `id`,`stat_vente_ecommerce_tout_agent`.`agent_id` AS `agent_id`,`stat_vente_ecommerce_tout_agent`.`secteur_id` AS `secteur_id`,`stat_vente_ecommerce_tout_agent`.`nbr_ventes` AS `nbr_ventes`,`stat_vente_ecommerce_tout_agent`.`ca` AS `ca`,`stat_vente_ecommerce_tout_agent`.`type_secteur_id` AS `type_secteur_id` from `stat_vente_ecommerce_tout_agent` union all select `stat_vente_dd_tout_agent`.`id` AS `id`,`stat_vente_dd_tout_agent`.`agent_id` AS `agent_id`,`stat_vente_dd_tout_agent`.`secteur_id` AS `secteur_id`,`stat_vente_dd_tout_agent`.`nbr_ventes` AS `nbr_ventes`,`stat_vente_dd_tout_agent`.`ca` AS `ca`,`stat_vente_dd_tout_agent`.`type_secteur_id` AS `type_secteur_id` from `stat_vente_dd_tout_agent` union all select `stat_vente_aroma_tout_agent`.`id` AS `id`,`stat_vente_aroma_tout_agent`.`agent_id` AS `agent_id`,`stat_vente_aroma_tout_agent`.`secteur_id` AS `secteur_id`,`stat_vente_aroma_tout_agent`.`nbr_ventes` AS `nbr_ventes`,`stat_vente_aroma_tout_agent`.`ca` AS `ca`,`stat_vente_aroma_tout_agent`.`type_secteur_id` AS `type_secteur_id` from `stat_vente_aroma_tout_agent` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_implantation_aroma`
--

/*!50001 DROP VIEW IF EXISTS `view_implantation_aroma`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_implantation_aroma` AS select `implantation_aroma`.`id` AS `id`,`implantation_aroma`.`nom` AS `nom`,`implantation_aroma`.`description` AS `description`,`implantation_aroma`.`image` AS `image`,`implantation_aroma`.`statut` AS `statut`,`implantation_aroma`.`reassort` AS `reassort`,coalesce(`implantation_aroma`.`qte_elmt`,0) AS `qte_elmt`,coalesce(`implantation_aroma`.`remise`,0) AS `remise`,`implantation_aroma`.`mere_id` AS `mere_id` from `implantation_aroma` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_implantation_aroma_total`
--

/*!50001 DROP VIEW IF EXISTS `view_implantation_aroma_total`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_implantation_aroma_total` AS select `i`.`id` AS `id`,sum(`ie`.`prix_produit` * (1 - `i`.`remise` / 100) * `i`.`qte_elmt`) AS `total`,sum(`ie`.`qte_gratuit`) AS `ug` from (`view_implantation_aroma` `i` join `view_implantation_elmt_aroma_valid` `ie` on(`i`.`id` = `ie`.`mere_id`)) group by `i`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_implantation_aroma_total_full`
--

/*!50001 DROP VIEW IF EXISTS `view_implantation_aroma_total_full`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_implantation_aroma_total_full` AS select `i`.`id` AS `id`,coalesce(`it`.`total`,0) AS `total`,coalesce(`it`.`ug`,0) AS `ug`,`i`.`id` AS `implantation_id` from (`implantation_aroma` `i` left join `view_implantation_aroma_total` `it` on(`i`.`id` = `it`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_implantation_aroma_valid`
--

/*!50001 DROP VIEW IF EXISTS `view_implantation_aroma_valid`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_implantation_aroma_valid` AS select `view_implantation_aroma`.`id` AS `id`,`view_implantation_aroma`.`nom` AS `nom`,`view_implantation_aroma`.`description` AS `description`,`view_implantation_aroma`.`image` AS `image`,`view_implantation_aroma`.`statut` AS `statut`,`view_implantation_aroma`.`reassort` AS `reassort`,`view_implantation_aroma`.`qte_elmt` AS `qte_elmt`,`view_implantation_aroma`.`remise` AS `remise`,`view_implantation_aroma`.`mere_id` AS `mere_id` from `view_implantation_aroma` where `view_implantation_aroma`.`statut` is null or `view_implantation_aroma`.`statut` <> 0 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_implantation_elmt_aroma_valid`
--

/*!50001 DROP VIEW IF EXISTS `view_implantation_elmt_aroma_valid`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_implantation_elmt_aroma_valid` AS select `ie`.`id` AS `id`,`ie`.`mere_id` AS `mere_id`,`ie`.`produit_id` AS `produit_id`,`ie`.`statut` AS `statut`,coalesce(`ie`.`qte_gratuit`,0) AS `qte_gratuit`,coalesce(`p`.`prix`,0) AS `prix_produit`,coalesce(`p`.`prix_conseille`,0) AS `prix_conseille_produit` from (`implantation_elmt_aroma` `ie` join `produit_aroma` `p` on(`ie`.`produit_id` = `p`.`id`)) where `ie`.`statut` is null or `ie`.`statut` <> 0 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_implantation_mere_aroma_total`
--

/*!50001 DROP VIEW IF EXISTS `view_implantation_mere_aroma_total`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_implantation_mere_aroma_total` AS select `im`.`id` AS `id`,sum(`i`.`reassort`) AS `nbr_reassort`,sum(0 = `i`.`reassort`) AS `nbr_normal`,count(`i`.`id`) AS `nbr` from (`implantation_mere_aroma` `im` join `view_implantation_aroma_valid` `i` on(`im`.`id` = `i`.`mere_id`)) group by `im`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_implantation_mere_aroma_total_full`
--

/*!50001 DROP VIEW IF EXISTS `view_implantation_mere_aroma_total_full`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_implantation_mere_aroma_total_full` AS select `im`.`id` AS `id`,`im`.`id` AS `implantation_mere_id`,coalesce(`i`.`nbr_reassort`) AS `nbr_reassort`,coalesce(`i`.`nbr_normal`) AS `nbr_normal`,coalesce(`i`.`nbr`) AS `nbr` from (`implantation_mere_aroma` `im` left join `view_implantation_mere_aroma_total` `i` on(`im`.`id` = `i`.`id`)) */;
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

-- Dump completed on 2024-05-12 15:57:56
