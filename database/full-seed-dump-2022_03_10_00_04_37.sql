-- MariaDB dump 10.19  Distrib 10.7.3-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: bank_test
-- ------------------------------------------------------
-- Server version	10.7.3-MariaDB

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
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0000_00_00_000000_create_websockets_statistics_entries_table',1),
(2,'2014_10_12_000000_create_users_table',1),
(3,'2014_10_12_100000_create_password_resets_table',1),
(4,'2018_08_08_100000_create_telescope_entries_table',1),
(5,'2019_05_14_001953_create_payment_methods_table',1),
(6,'2019_05_15_060208_create_providers_table',1),
(7,'2019_05_15_060209_create_transactions_table',1),
(8,'2019_06_25_143541_create_regulars_table',1),
(9,'2019_08_19_000000_create_failed_jobs_table',1),
(10,'2021_04_16_012114_create_tags_table',1),
(11,'2021_04_18_022617_create_tag_transaction_table',1),
(12,'2021_10_27_152800_create_jobs_table',1),
(13,'2022_02_05_003810_create_possible_regulars_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `abbreviation` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES
(1,'---','Unknown',NULL,NULL,NULL),
(2,'CHG','Bank Charge',NULL,NULL,NULL),
(3,'BP','Benefit Payment',NULL,NULL,NULL),
(4,'BGC','Bank Giro Credit',NULL,NULL,NULL),
(5,'CSH','CSH',NULL,NULL,NULL),
(6,'CPT','Cashpoint',NULL,NULL,NULL),
(7,'CHQ','Cheque',NULL,NULL,NULL),
(8,'DEB','Debit Card',NULL,NULL,NULL),
(9,'DEP','Deposit',NULL,NULL,NULL),
(10,'DD','Direct Debit',NULL,NULL,NULL),
(11,'FPI','Fast Payment In',NULL,NULL,NULL),
(12,'FPO','Fast Payment Out',NULL,NULL,NULL),
(13,'FEE','Exchange Fee',NULL,NULL,NULL),
(14,'PAY','Payment',NULL,NULL,NULL),
(15,'SO','Standing Order',NULL,NULL,NULL),
(16,'TFR','Transfer',NULL,NULL,NULL);
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `possible_regulars`
--

DROP TABLE IF EXISTS `possible_regulars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `possible_regulars` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `entry` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The text value of the entry searched for',
  `period_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The period the entry was declined for',
  `period_multiplier` int(11) NOT NULL,
  `last_action` enum('accepted','declined','postponed','created') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'created' COMMENT 'What did the user choose to do with this suggestion?',
  `last_action_happened` datetime NOT NULL DEFAULT '2022-03-09 23:52:13',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `possible_regulars`
--

LOCK TABLES `possible_regulars` WRITE;
/*!40000 ALTER TABLE `possible_regulars` DISABLE KEYS */;
/*!40000 ALTER TABLE `possible_regulars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `providers`
--

DROP TABLE IF EXISTS `providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `providers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL COMMENT 'The user who created the provider',
  `payment_method_id` bigint(20) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regular_expressions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `providers_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `providers`
--

LOCK TABLES `providers` WRITE;
/*!40000 ALTER TABLE `providers` DISABLE KEYS */;
INSERT INTO `providers` VALUES
(1,0,7,'N/A','/Dolore suscipit quod./i','https://lorempixel.com/640/480/?68852','Necessitatibus sunt nisi excepturi.','2022-03-09 23:52:14','2022-03-09 23:52:14'),
(2,0,5,'Bailey-Smith','/Qui repellat blanditiis./i','https://lorempixel.com/640/480/?29326','Maxime autem perferendis ab aut sed.','2022-03-09 23:52:14','2022-03-09 23:52:14'),
(3,0,3,'Hunter, Hunt and Stevens','/Voluptate optio./i','https://lorempixel.com/640/480/?64286','Recusandae amet nostrum tenetur facilis.','2022-03-09 23:52:14','2022-03-09 23:52:14'),
(4,0,3,'Davies, Hall and Green','/Aperiam dignissimos neque est./i','https://lorempixel.com/640/480/?22813','Dolorem saepe odio aut.','2022-03-09 23:52:14','2022-03-09 23:52:14'),
(5,0,4,'Rose-Kennedy','/Mollitia laborum distinctio ad./i','https://lorempixel.com/640/480/?67001','Necessitatibus quia temporibus debitis dolorem explicabo.','2022-03-09 23:52:14','2022-03-09 23:52:14'),
(6,0,16,'Clark PLC','/Voluptatem minima aut./i','https://lorempixel.com/640/480/?83927','Veniam sunt facere tempora occaecati.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(7,0,6,'Lee Group','/Quo numquam voluptatibus ducimus./i','https://lorempixel.com/640/480/?15219','Vel temporibus ab non.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(8,0,13,'Gray, Mitchell and Johnson','/Ut porro perspiciatis numquam./i','https://lorempixel.com/640/480/?17398','Quia eveniet cumque ut sequi.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(9,0,12,'Murray, Stevens and Graham','/Veritatis perspiciatis veniam./i','https://lorempixel.com/640/480/?63602','Ut rem eveniet quo ut.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(10,0,11,'Mason-Turner','/Provident natus sit corporis./i','https://lorempixel.com/640/480/?46180','Quia voluptatem temporibus consectetur ab.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(11,0,15,'Murray, Walsh and Powell','/Ad necessitatibus accusantium odit./i','https://lorempixel.com/640/480/?71226','Sunt modi itaque soluta nihil natus.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(12,0,8,'Richards, Carter and Rose','/Voluptate temporibus blanditiis./i','https://lorempixel.com/640/480/?64415','Mollitia ut magni vel ullam.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(13,0,2,'Ward Ltd','/Aut non ipsam./i','https://lorempixel.com/640/480/?59331','Ratione velit pariatur nam est consequatur.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(14,0,15,'Ward Inc','/Maxime eum totam./i','https://lorempixel.com/640/480/?60231','Fugit esse voluptatum.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(15,0,13,'Allen and Sons','/Dolorem consequatur./i','https://lorempixel.com/640/480/?50474','Non autem et error.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(16,0,11,'Kennedy PLC','/Neque omnis nulla./i','https://lorempixel.com/640/480/?48334','Ut voluptatem earum.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(17,0,10,'Griffiths, Jackson and Griffiths','/Dicta eos omnis delectus./i','https://lorempixel.com/640/480/?87827','Eveniet et doloremque est.','2022-03-09 23:52:32','2022-03-09 23:52:32');
/*!40000 ALTER TABLE `providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regulars`
--

DROP TABLE IF EXISTS `regulars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regulars` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `provider_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `payment_method_id` bigint(20) unsigned NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(6,2) DEFAULT NULL,
  `amount_varies` tinyint(1) NOT NULL DEFAULT 0,
  `period_name` enum('day','week','month','quarter','year') COLLATE utf8mb4_unicode_ci NOT NULL,
  `period_multiplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_due` date NOT NULL,
  `last_rotated` date DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `regulars_date` (`next_due`),
  FULLTEXT KEY `regulars_alias_fulltext` (`alias`),
  FULLTEXT KEY `regulars_entry_text_fulltext` (`entry_text`),
  FULLTEXT KEY `regulars_remarks_fulltext` (`remarks`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regulars`
--

LOCK TABLES `regulars` WRITE;
/*!40000 ALTER TABLE `regulars` DISABLE KEYS */;
/*!40000 ALTER TABLE `regulars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag_transaction`
--

DROP TABLE IF EXISTS `tag_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag_transaction` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` bigint(20) unsigned NOT NULL,
  `transaction_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=523 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_transaction`
--

LOCK TABLES `tag_transaction` WRITE;
/*!40000 ALTER TABLE `tag_transaction` DISABLE KEYS */;
INSERT INTO `tag_transaction` VALUES
(1,1,2,NULL,NULL),
(2,16,2,NULL,NULL),
(3,7,3,NULL,NULL),
(4,33,3,NULL,NULL),
(5,29,3,NULL,NULL),
(6,2,4,NULL,NULL),
(7,25,4,NULL,NULL),
(8,14,5,NULL,NULL),
(9,1,5,NULL,NULL),
(10,36,5,NULL,NULL),
(11,8,5,NULL,NULL),
(12,7,7,NULL,NULL),
(13,1,7,NULL,NULL),
(14,22,7,NULL,NULL),
(15,5,8,NULL,NULL),
(16,11,8,NULL,NULL),
(17,25,9,NULL,NULL),
(18,39,9,NULL,NULL),
(19,1,9,NULL,NULL),
(20,23,11,NULL,NULL),
(21,33,11,NULL,NULL),
(22,25,12,NULL,NULL),
(23,15,12,NULL,NULL),
(24,34,12,NULL,NULL),
(25,2,12,NULL,NULL),
(26,36,13,NULL,NULL),
(27,22,14,NULL,NULL),
(28,15,14,NULL,NULL),
(29,4,14,NULL,NULL),
(30,26,14,NULL,NULL),
(31,32,15,NULL,NULL),
(32,6,15,NULL,NULL),
(33,31,15,NULL,NULL),
(34,10,15,NULL,NULL),
(35,1,16,NULL,NULL),
(36,30,16,NULL,NULL),
(37,8,16,NULL,NULL),
(38,9,17,NULL,NULL),
(39,2,18,NULL,NULL),
(40,17,19,NULL,NULL),
(41,39,19,NULL,NULL),
(42,6,19,NULL,NULL),
(43,4,20,NULL,NULL),
(44,35,20,NULL,NULL),
(45,36,20,NULL,NULL),
(46,25,20,NULL,NULL),
(47,30,21,NULL,NULL),
(48,8,23,NULL,NULL),
(49,27,24,NULL,NULL),
(50,37,24,NULL,NULL),
(51,3,24,NULL,NULL),
(52,15,27,NULL,NULL),
(53,30,27,NULL,NULL),
(54,34,27,NULL,NULL),
(55,17,27,NULL,NULL),
(56,17,30,NULL,NULL),
(57,5,30,NULL,NULL),
(58,16,30,NULL,NULL),
(59,36,31,NULL,NULL),
(60,27,32,NULL,NULL),
(61,6,32,NULL,NULL),
(62,16,34,NULL,NULL),
(63,2,34,NULL,NULL),
(64,8,34,NULL,NULL),
(65,37,34,NULL,NULL),
(66,2,35,NULL,NULL),
(67,22,35,NULL,NULL),
(68,28,35,NULL,NULL),
(69,14,35,NULL,NULL),
(70,1,36,NULL,NULL),
(71,25,37,NULL,NULL),
(72,33,37,NULL,NULL),
(73,38,37,NULL,NULL),
(74,25,38,NULL,NULL),
(75,34,38,NULL,NULL),
(76,40,39,NULL,NULL),
(77,33,39,NULL,NULL),
(78,8,39,NULL,NULL),
(79,24,40,NULL,NULL),
(80,3,40,NULL,NULL),
(81,28,41,NULL,NULL),
(82,31,41,NULL,NULL),
(83,37,43,NULL,NULL),
(84,14,43,NULL,NULL),
(85,36,44,NULL,NULL),
(86,25,45,NULL,NULL),
(87,9,45,NULL,NULL),
(88,19,45,NULL,NULL),
(89,32,45,NULL,NULL),
(90,23,46,NULL,NULL),
(91,9,46,NULL,NULL),
(92,23,47,NULL,NULL),
(93,30,48,NULL,NULL),
(94,17,49,NULL,NULL),
(95,24,49,NULL,NULL),
(96,29,50,NULL,NULL),
(97,27,50,NULL,NULL),
(98,33,50,NULL,NULL),
(99,5,50,NULL,NULL),
(100,15,51,NULL,NULL),
(101,36,51,NULL,NULL),
(102,9,53,NULL,NULL),
(103,30,53,NULL,NULL),
(104,5,53,NULL,NULL),
(105,33,53,NULL,NULL),
(106,10,54,NULL,NULL),
(107,7,54,NULL,NULL),
(108,31,55,NULL,NULL),
(109,26,55,NULL,NULL),
(110,6,56,NULL,NULL),
(111,5,56,NULL,NULL),
(112,19,56,NULL,NULL),
(113,13,56,NULL,NULL),
(114,26,57,NULL,NULL),
(115,30,58,NULL,NULL),
(116,34,58,NULL,NULL),
(117,38,58,NULL,NULL),
(118,10,58,NULL,NULL),
(119,19,59,NULL,NULL),
(120,28,59,NULL,NULL),
(121,2,59,NULL,NULL),
(122,10,59,NULL,NULL),
(123,4,60,NULL,NULL),
(124,7,62,NULL,NULL),
(125,32,62,NULL,NULL),
(126,28,62,NULL,NULL),
(127,23,62,NULL,NULL),
(128,9,63,NULL,NULL),
(129,6,63,NULL,NULL),
(130,8,63,NULL,NULL),
(131,5,64,NULL,NULL),
(132,11,64,NULL,NULL),
(133,32,64,NULL,NULL),
(134,15,64,NULL,NULL),
(135,37,65,NULL,NULL),
(136,8,65,NULL,NULL),
(137,31,68,NULL,NULL),
(138,23,69,NULL,NULL),
(139,8,69,NULL,NULL),
(140,32,69,NULL,NULL),
(141,1,70,NULL,NULL),
(142,6,70,NULL,NULL),
(143,2,71,NULL,NULL),
(144,38,74,NULL,NULL),
(145,29,74,NULL,NULL),
(146,40,74,NULL,NULL),
(147,14,74,NULL,NULL),
(148,12,75,NULL,NULL),
(149,15,75,NULL,NULL),
(150,24,75,NULL,NULL),
(151,20,76,NULL,NULL),
(152,7,76,NULL,NULL),
(153,38,76,NULL,NULL),
(154,28,76,NULL,NULL),
(155,12,77,NULL,NULL),
(156,19,77,NULL,NULL),
(157,14,77,NULL,NULL),
(158,17,78,NULL,NULL),
(159,28,79,NULL,NULL),
(160,29,79,NULL,NULL),
(161,15,81,NULL,NULL),
(162,40,82,NULL,NULL),
(163,17,83,NULL,NULL),
(164,24,84,NULL,NULL),
(165,10,84,NULL,NULL),
(166,4,84,NULL,NULL),
(167,6,85,NULL,NULL),
(168,5,86,NULL,NULL),
(169,22,86,NULL,NULL),
(170,19,86,NULL,NULL),
(171,9,87,NULL,NULL),
(172,16,87,NULL,NULL),
(173,38,88,NULL,NULL),
(174,19,89,NULL,NULL),
(175,11,89,NULL,NULL),
(176,39,89,NULL,NULL),
(177,14,90,NULL,NULL),
(178,37,90,NULL,NULL),
(179,6,90,NULL,NULL),
(180,13,90,NULL,NULL),
(181,12,93,NULL,NULL),
(182,9,94,NULL,NULL),
(183,24,94,NULL,NULL),
(184,33,95,NULL,NULL),
(185,4,95,NULL,NULL),
(186,5,97,NULL,NULL),
(187,20,97,NULL,NULL),
(188,8,99,NULL,NULL),
(189,22,99,NULL,NULL),
(190,7,102,NULL,NULL),
(191,28,102,NULL,NULL),
(192,16,104,NULL,NULL),
(193,5,104,NULL,NULL),
(194,9,105,NULL,NULL),
(195,12,106,NULL,NULL),
(196,19,106,NULL,NULL),
(197,30,106,NULL,NULL),
(198,19,108,NULL,NULL),
(199,20,108,NULL,NULL),
(200,25,108,NULL,NULL),
(201,7,109,NULL,NULL),
(202,23,110,NULL,NULL),
(203,16,110,NULL,NULL),
(204,12,110,NULL,NULL),
(205,16,111,NULL,NULL),
(206,12,111,NULL,NULL),
(207,38,112,NULL,NULL),
(208,24,112,NULL,NULL),
(209,35,112,NULL,NULL),
(210,15,113,NULL,NULL),
(211,3,113,NULL,NULL),
(212,6,113,NULL,NULL),
(213,33,114,NULL,NULL),
(214,26,114,NULL,NULL),
(215,7,118,NULL,NULL),
(216,13,118,NULL,NULL),
(217,13,119,NULL,NULL),
(218,34,120,NULL,NULL),
(219,14,121,NULL,NULL),
(220,30,123,NULL,NULL),
(221,1,123,NULL,NULL),
(222,12,124,NULL,NULL),
(223,25,124,NULL,NULL),
(224,21,126,NULL,NULL),
(225,36,126,NULL,NULL),
(226,26,126,NULL,NULL),
(227,14,127,NULL,NULL),
(228,31,127,NULL,NULL),
(229,25,127,NULL,NULL),
(230,22,127,NULL,NULL),
(231,12,130,NULL,NULL),
(232,39,130,NULL,NULL),
(233,18,133,NULL,NULL),
(234,17,133,NULL,NULL),
(235,37,133,NULL,NULL),
(236,27,133,NULL,NULL),
(237,31,134,NULL,NULL),
(238,25,134,NULL,NULL),
(239,19,134,NULL,NULL),
(240,10,137,NULL,NULL),
(241,22,137,NULL,NULL),
(242,24,138,NULL,NULL),
(243,23,138,NULL,NULL),
(244,20,138,NULL,NULL),
(245,6,139,NULL,NULL),
(246,7,139,NULL,NULL),
(247,33,139,NULL,NULL),
(248,16,139,NULL,NULL),
(249,29,140,NULL,NULL),
(250,4,140,NULL,NULL),
(251,2,140,NULL,NULL),
(252,31,140,NULL,NULL),
(253,32,141,NULL,NULL),
(254,23,141,NULL,NULL),
(255,19,141,NULL,NULL),
(256,9,141,NULL,NULL),
(257,35,143,NULL,NULL),
(258,12,143,NULL,NULL),
(259,28,143,NULL,NULL),
(260,22,143,NULL,NULL),
(261,33,144,NULL,NULL),
(262,24,145,NULL,NULL),
(263,12,145,NULL,NULL),
(264,33,146,NULL,NULL),
(265,22,146,NULL,NULL),
(266,11,146,NULL,NULL),
(267,23,147,NULL,NULL),
(268,8,147,NULL,NULL),
(269,40,147,NULL,NULL),
(270,19,149,NULL,NULL),
(271,26,150,NULL,NULL),
(272,40,150,NULL,NULL),
(273,25,150,NULL,NULL),
(274,31,151,NULL,NULL),
(275,12,151,NULL,NULL),
(276,16,151,NULL,NULL),
(277,22,151,NULL,NULL),
(278,10,152,NULL,NULL),
(279,17,152,NULL,NULL),
(280,21,153,NULL,NULL),
(281,36,153,NULL,NULL),
(282,8,154,NULL,NULL),
(283,2,155,NULL,NULL),
(284,10,156,NULL,NULL),
(285,14,156,NULL,NULL),
(286,29,157,NULL,NULL),
(287,7,157,NULL,NULL),
(288,27,159,NULL,NULL),
(289,37,161,NULL,NULL),
(290,12,161,NULL,NULL),
(291,13,161,NULL,NULL),
(292,27,161,NULL,NULL),
(293,39,162,NULL,NULL),
(294,23,164,NULL,NULL),
(295,13,165,NULL,NULL),
(296,30,166,NULL,NULL),
(297,20,166,NULL,NULL),
(298,2,166,NULL,NULL),
(299,26,167,NULL,NULL),
(300,32,168,NULL,NULL),
(301,12,168,NULL,NULL),
(302,18,169,NULL,NULL),
(303,10,169,NULL,NULL),
(304,38,169,NULL,NULL),
(305,13,169,NULL,NULL),
(306,35,170,NULL,NULL),
(307,6,170,NULL,NULL),
(308,32,170,NULL,NULL),
(309,26,170,NULL,NULL),
(310,20,171,NULL,NULL),
(311,1,171,NULL,NULL),
(312,36,171,NULL,NULL),
(313,17,171,NULL,NULL),
(314,7,172,NULL,NULL),
(315,22,172,NULL,NULL),
(316,14,173,NULL,NULL),
(317,32,173,NULL,NULL),
(318,3,173,NULL,NULL),
(319,1,174,NULL,NULL),
(320,20,175,NULL,NULL),
(321,7,175,NULL,NULL),
(322,16,176,NULL,NULL),
(323,18,177,NULL,NULL),
(324,27,178,NULL,NULL),
(325,1,180,NULL,NULL),
(326,28,181,NULL,NULL),
(327,13,182,NULL,NULL),
(328,4,182,NULL,NULL),
(329,29,183,NULL,NULL),
(330,34,185,NULL,NULL),
(331,10,185,NULL,NULL),
(332,4,185,NULL,NULL),
(333,18,185,NULL,NULL),
(334,2,186,NULL,NULL),
(335,26,187,NULL,NULL),
(336,18,187,NULL,NULL),
(337,23,188,NULL,NULL),
(338,26,188,NULL,NULL),
(339,38,188,NULL,NULL),
(340,13,188,NULL,NULL),
(341,39,189,NULL,NULL),
(342,8,191,NULL,NULL),
(343,18,191,NULL,NULL),
(344,23,192,NULL,NULL),
(345,28,193,NULL,NULL),
(346,25,193,NULL,NULL),
(347,16,194,NULL,NULL),
(348,2,194,NULL,NULL),
(349,5,195,NULL,NULL),
(350,35,195,NULL,NULL),
(351,30,196,NULL,NULL),
(352,28,197,NULL,NULL),
(353,22,200,NULL,NULL),
(354,38,200,NULL,NULL),
(355,33,200,NULL,NULL),
(356,16,200,NULL,NULL),
(357,33,201,NULL,NULL),
(358,6,201,NULL,NULL),
(359,27,201,NULL,NULL),
(360,7,203,NULL,NULL),
(361,40,204,NULL,NULL),
(362,6,204,NULL,NULL),
(363,21,204,NULL,NULL),
(364,27,205,NULL,NULL),
(365,25,205,NULL,NULL),
(366,7,205,NULL,NULL),
(367,33,206,NULL,NULL),
(368,32,207,NULL,NULL),
(369,13,209,NULL,NULL),
(370,20,209,NULL,NULL),
(371,21,210,NULL,NULL),
(372,24,211,NULL,NULL),
(373,6,211,NULL,NULL),
(374,8,211,NULL,NULL),
(375,35,212,NULL,NULL),
(376,10,212,NULL,NULL),
(377,9,213,NULL,NULL),
(378,3,214,NULL,NULL),
(379,16,215,NULL,NULL),
(380,32,216,NULL,NULL),
(381,37,216,NULL,NULL),
(382,16,216,NULL,NULL),
(383,5,216,NULL,NULL),
(384,15,217,NULL,NULL),
(385,31,218,NULL,NULL),
(386,38,218,NULL,NULL),
(387,36,218,NULL,NULL),
(388,22,220,NULL,NULL),
(389,23,221,NULL,NULL),
(390,33,221,NULL,NULL),
(391,22,221,NULL,NULL),
(392,21,222,NULL,NULL),
(393,11,222,NULL,NULL),
(394,1,222,NULL,NULL),
(395,3,222,NULL,NULL),
(396,9,223,NULL,NULL),
(397,13,223,NULL,NULL),
(398,16,223,NULL,NULL),
(399,19,223,NULL,NULL),
(400,28,226,NULL,NULL),
(401,34,226,NULL,NULL),
(402,26,226,NULL,NULL),
(403,27,227,NULL,NULL),
(404,34,227,NULL,NULL),
(405,14,227,NULL,NULL),
(406,18,227,NULL,NULL),
(407,3,228,NULL,NULL),
(408,6,228,NULL,NULL),
(409,18,228,NULL,NULL),
(410,9,229,NULL,NULL),
(411,22,229,NULL,NULL),
(412,24,230,NULL,NULL),
(413,16,230,NULL,NULL),
(414,19,230,NULL,NULL),
(415,12,230,NULL,NULL),
(416,6,231,NULL,NULL),
(417,38,232,NULL,NULL),
(418,38,233,NULL,NULL),
(419,15,233,NULL,NULL),
(420,3,235,NULL,NULL),
(421,31,235,NULL,NULL),
(422,25,235,NULL,NULL),
(423,32,236,NULL,NULL),
(424,33,236,NULL,NULL),
(425,25,236,NULL,NULL),
(426,15,236,NULL,NULL),
(427,26,237,NULL,NULL),
(428,10,237,NULL,NULL),
(429,7,237,NULL,NULL),
(430,20,238,NULL,NULL),
(431,39,238,NULL,NULL),
(432,21,238,NULL,NULL),
(433,22,241,NULL,NULL),
(434,6,241,NULL,NULL),
(435,26,243,NULL,NULL),
(436,8,243,NULL,NULL),
(437,7,243,NULL,NULL),
(438,15,243,NULL,NULL),
(439,18,244,NULL,NULL),
(440,6,244,NULL,NULL),
(441,3,245,NULL,NULL),
(442,14,245,NULL,NULL),
(443,23,245,NULL,NULL),
(444,15,246,NULL,NULL),
(445,18,247,NULL,NULL),
(446,23,248,NULL,NULL),
(447,5,248,NULL,NULL),
(448,22,248,NULL,NULL),
(449,40,249,NULL,NULL),
(450,21,249,NULL,NULL),
(451,26,249,NULL,NULL),
(452,1,249,NULL,NULL),
(453,22,250,NULL,NULL),
(454,28,250,NULL,NULL),
(455,6,252,NULL,NULL),
(456,37,252,NULL,NULL),
(457,7,252,NULL,NULL),
(458,25,252,NULL,NULL),
(459,10,253,NULL,NULL),
(460,29,253,NULL,NULL),
(461,37,253,NULL,NULL),
(462,33,253,NULL,NULL),
(463,18,254,NULL,NULL),
(464,32,254,NULL,NULL),
(465,9,254,NULL,NULL),
(466,12,254,NULL,NULL),
(467,23,255,NULL,NULL),
(468,37,255,NULL,NULL),
(469,4,256,NULL,NULL),
(470,11,257,NULL,NULL),
(471,11,258,NULL,NULL),
(472,6,258,NULL,NULL),
(473,15,258,NULL,NULL),
(474,29,259,NULL,NULL),
(475,26,259,NULL,NULL),
(476,25,259,NULL,NULL),
(477,25,260,NULL,NULL),
(478,34,260,NULL,NULL),
(479,2,261,NULL,NULL),
(480,32,262,NULL,NULL),
(481,10,262,NULL,NULL),
(482,21,263,NULL,NULL),
(483,17,263,NULL,NULL),
(484,8,264,NULL,NULL),
(485,38,264,NULL,NULL),
(486,13,264,NULL,NULL),
(487,22,265,NULL,NULL),
(488,16,265,NULL,NULL),
(489,10,265,NULL,NULL),
(490,15,265,NULL,NULL),
(491,37,266,NULL,NULL),
(492,22,266,NULL,NULL),
(493,20,266,NULL,NULL),
(494,37,268,NULL,NULL),
(495,6,268,NULL,NULL),
(496,9,269,NULL,NULL),
(497,34,270,NULL,NULL),
(498,2,270,NULL,NULL),
(499,5,270,NULL,NULL),
(500,6,271,NULL,NULL),
(501,34,271,NULL,NULL),
(502,15,271,NULL,NULL),
(503,26,272,NULL,NULL),
(504,30,272,NULL,NULL),
(505,31,272,NULL,NULL),
(506,2,272,NULL,NULL),
(507,18,274,NULL,NULL),
(508,16,275,NULL,NULL),
(509,14,275,NULL,NULL),
(510,11,275,NULL,NULL),
(511,37,275,NULL,NULL),
(512,34,276,NULL,NULL),
(513,40,276,NULL,NULL),
(514,31,276,NULL,NULL),
(515,16,279,NULL,NULL),
(516,4,279,NULL,NULL),
(517,3,280,NULL,NULL),
(518,39,280,NULL,NULL),
(519,22,280,NULL,NULL),
(520,4,282,NULL,NULL),
(521,9,282,NULL,NULL),
(522,10,282,NULL,NULL);
/*!40000 ALTER TABLE `tag_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_by_user_id` bigint(20) unsigned NOT NULL,
  `tag` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contrasted_color` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tags_created_by_user_id_foreign` (`created_by_user_id`),
  CONSTRAINT `tags_created_by_user_id_foreign` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES
(1,1,'Shopping','#9842fa','white','fa-solid fa-trash-restore-alt','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(2,1,'Amazon','#a31242','white','fa-solid fa-trash-can-arrow-up','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(3,1,'Aldi','#34b269','black','fa-solid fa-users-gear','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(4,1,'Lidl','#319122','white','fa-solid fa-stairs','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(5,1,'B&M','#647b8f','white','fa-solid fa-cannabis','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(6,1,'Quality Save','#703ad4','white','fa-solid fa-arrow-up-short-wide','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(7,1,'Iceland','#1de737','black','fa-solid fa-unlink','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(8,1,'Subscribe & Save','#ab1293','white','fa-solid fa-flag','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(9,1,'Wilkos','#08a0b9','white','fa-solid fa-microphone-lines','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(10,1,'Catalogues','#d1c034','black','fa-solid fa-handshake-simple-slash','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(11,1,'Credit Card Payment','#fd3c87','white','fa-solid fa-hammer','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(12,1,'Loan Repayment','#2f0f3c','white','fa-solid fa-align-justify','2022-03-09 23:52:35','2022-03-09 23:52:35'),
(13,1,'Ann\'s Business Income','#5a35a1','white','fa-solid index','2022-03-09 23:52:35','2022-03-09 23:52:35'),
(14,1,'Ann\'s Business Expenditure','#977434','white','fa-solid fa-mortar-pestle','2022-03-09 23:52:35','2022-03-09 23:52:35'),
(15,1,'Ann\'s Private Tutorial Income','#619555','white','fa-solid fa-angles-left','2022-03-09 23:52:35','2022-03-09 23:52:35'),
(16,1,'Income','#b9a5f0','black','fa-solid fa-chevron-left','2022-03-09 23:52:35','2022-03-09 23:52:35'),
(17,1,'Ann\'s Wage','#4a2a5c','white','fa-solid fa-water-ladder','2022-03-09 23:52:35','2022-03-09 23:52:35'),
(18,1,'Rowan','#bc4770','white','fa-solid fa-font-awesome-flag','2022-03-09 23:52:35','2022-03-09 23:52:35'),
(19,1,'Rowan\'s Allowance','#403d4b','white','fa-solid fa-sort-alpha-asc','2022-03-09 23:52:35','2022-03-09 23:52:35'),
(20,1,'School Uniform','#bdb2af','black','fa-solid fa-money-bill-1-wave','2022-03-09 23:52:35','2022-03-09 23:52:35'),
(21,1,'School','#9c18c9','white','fa-solid fa-line-chart','2022-03-09 23:52:35','2022-03-09 23:52:35'),
(22,1,'Books','#b9620b','white','fa-solid fa-thermometer-quarter','2022-03-09 23:52:35','2022-03-09 23:52:35'),
(23,1,'Smart Home','#177f08','white','fa-solid fa-hand-back-fist','2022-03-09 23:52:35','2022-03-09 23:52:35'),
(24,1,'Electronics','#26f481','black','fa-solid fa-grip-lines-vertical','2022-03-09 23:52:35','2022-03-09 23:52:35'),
(25,1,'Security','#c68dee','black','fa-solid fa-poll-h','2022-03-09 23:52:35','2022-03-09 23:52:35'),
(26,1,'Household Furnishings','#faa8db','black','fa-solid fa-thermometer-empty','2022-03-09 23:52:36','2022-03-09 23:52:36'),
(27,1,'DIY','#802df7','white','fa-solid fa-lightbulb','2022-03-09 23:52:36','2022-03-09 23:52:36'),
(28,1,'Household Maintenance','#78b61f','black','fa-solid fa-tablet-android','2022-03-09 23:52:36','2022-03-09 23:52:36'),
(29,1,'Disability','#4650a2','white','fa-solid fa-thermometer','2022-03-09 23:52:36','2022-03-09 23:52:36'),
(30,1,'Presents','#5ea5d0','black','fa-solid fa-cent-sign','2022-03-09 23:52:36','2022-03-09 23:52:36'),
(31,1,'Food','#7a51c4','white','fa-solid fa-earth','2022-03-09 23:52:36','2022-03-09 23:52:36'),
(32,1,'Amazon General','#c5b42a','black','fa-solid fa-box','2022-03-09 23:52:36','2022-03-09 23:52:36'),
(33,1,'Media Subscriptions','#c47962','black','fa-solid fa-hand-point-up','2022-03-09 23:52:36','2022-03-09 23:52:36'),
(34,1,'Entertainment','#b797e9','black','fa-solid fa-joint','2022-03-09 23:52:36','2022-03-09 23:52:36'),
(35,1,'Clothing','#46c2b0','black','fa-solid fa-hand-paper','2022-03-09 23:52:36','2022-03-09 23:52:36'),
(36,1,'Rowan\'s Sport','#a7a0db','black','fa-solid fa-frown','2022-03-09 23:52:36','2022-03-09 23:52:36'),
(37,1,'Pets','#e1babd','black','fa-solid fa-file-arrow-up','2022-03-09 23:52:36','2022-03-09 23:52:36'),
(38,1,'Vets','#ac8fb0','black','fa-solid fa-share-from-square','2022-03-09 23:52:36','2022-03-09 23:52:36'),
(39,1,'Medication','#ee965a','black','fa-solid fa-try','2022-03-09 23:52:36','2022-03-09 23:52:36'),
(40,1,'Essential Maintenance','#22cd24','black','fa-solid fa-feather-pointed','2022-03-09 23:52:36','2022-03-09 23:52:36');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_entries`
--

DROP TABLE IF EXISTS `telescope_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_entries` (
  `sequence` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`sequence`),
  UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  KEY `telescope_entries_batch_id_index` (`batch_id`),
  KEY `telescope_entries_family_hash_index` (`family_hash`),
  KEY `telescope_entries_created_at_index` (`created_at`),
  KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_entries`
--

LOCK TABLES `telescope_entries` WRITE;
/*!40000 ALTER TABLE `telescope_entries` DISABLE KEYS */;
INSERT INTO `telescope_entries` VALUES
(1,'95c8308b-51ef-4921-88e2-f89282801a64','95c8308d-9b38-4068-87dc-0f57dc9ada1f',NULL,1,'query','{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `telescope_entries` where `created_at` < \'2022-03-09 00:00:01\' limit 1000\",\"time\":\"11.57\",\"slow\":false,\"file\":\"\\/home\\/john\\/Projects\\/bank\\/artisan\",\"line\":37,\"hash\":\"7a2bb27e7eee509dd05eaaccb1b357d7\",\"hostname\":\"main.home\"}','2022-03-10 00:00:05'),
(2,'95c8308d-9b0d-492a-9a5e-35d9ec769ca1','95c8308d-9b38-4068-87dc-0f57dc9ada1f',NULL,1,'command','{\"command\":\"telescope:prune\",\"exit_code\":0,\"arguments\":{\"command\":\"telescope:prune\"},\"options\":{\"hours\":\"24\",\"help\":false,\"quiet\":false,\"verbose\":false,\"version\":false,\"ansi\":null,\"no-interaction\":false,\"env\":null},\"hostname\":\"main.home\"}','2022-03-10 00:00:05'),
(3,'95c8308d-b5f9-484a-bcb5-f519b0237f25','95c8308d-c729-4701-b5bf-f9e6f41d8e35',NULL,1,'schedule','{\"command\":\"\'\\/usr\\/bin\\/php\' \'artisan\' telescope:prune\",\"description\":null,\"expression\":\"0 0 * * *\",\"timezone\":\"Europe\\/London\",\"user\":null,\"output\":\"\",\"hostname\":\"main.home\"}','2022-03-10 00:00:05');
/*!40000 ALTER TABLE `telescope_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_entries_tags`
--

DROP TABLE IF EXISTS `telescope_entries_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_entries_tags` (
  `entry_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `telescope_entries_tags_entry_uuid_tag_index` (`entry_uuid`,`tag`),
  KEY `telescope_entries_tags_tag_index` (`tag`),
  CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_entries_tags`
--

LOCK TABLES `telescope_entries_tags` WRITE;
/*!40000 ALTER TABLE `telescope_entries_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_entries_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_monitoring`
--

DROP TABLE IF EXISTS `telescope_monitoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_monitoring` (
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_monitoring`
--

LOCK TABLES `telescope_monitoring` WRITE;
/*!40000 ALTER TABLE `telescope_monitoring` DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_monitoring` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `provider_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `payment_method_id` bigint(20) unsigned NOT NULL,
  `isPartOfRegular` tinyint(1) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `entry` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `balance` decimal(8,2) DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_date` (`date`),
  KEY `transaction_entry` (`entry`),
  FULLTEXT KEY `transactions_remarks_fulltext` (`remarks`)
) ENGINE=InnoDB AUTO_INCREMENT=283 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES
(1,1,10,11,0,'2021-12-08','Petplan 2',1458.74,523.12,'Consequatur eum non vero iure rem eveniet.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(2,1,10,4,0,'2021-05-31','Tesco',18.70,2294.99,'Est quis vel est molestiae possimus et atque.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(3,1,1,3,0,'2021-11-07','Aldi',1007.61,2478.66,'Iusto id at non quia omnis.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(4,1,4,10,0,'2021-08-23','Halifax TMPP',-38.04,433.05,'Rerum numquam odit repellat illo.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(5,1,10,9,0,'2021-06-20','ALDI',1258.22,1362.25,'Ipsa reiciendis magnam consequatur aliquam.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(6,1,9,12,0,'2021-05-02','Denplan',-518.52,1541.89,'Fugiat excepturi ipsam tenetur aliquid.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(7,1,8,9,0,'2021-08-21','Halifax Mortgage',-1008.62,398.83,'Suscipit ex perferendis natus.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(8,1,8,6,0,'2021-05-19','Aldi',1522.53,3.22,'Blanditiis tenetur harum illo nam asperiores consequatur.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(9,1,8,4,0,'2021-04-30','Aldi',1213.35,2050.40,'Et nulla quia culpa voluptatem.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(10,1,6,1,0,'2021-05-02','Tesco',1731.04,2278.20,'Iure repellat atque impedit libero dolores non tenetur ad.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(11,1,4,7,0,'2022-01-09','Asda',-800.06,2676.88,'Facere qui molestiae saepe blanditiis ab.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(12,1,1,8,0,'2021-03-26','Petplan',-1929.29,1515.00,'Illum odio optio quia.','2022-03-09 23:52:15','2022-03-09 23:52:15'),
(13,1,10,2,0,'2022-02-17','Halifax Mortgage',1446.69,1064.48,'Dolorum doloremque et eum ratione et reiciendis.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(14,1,4,3,0,'2021-09-17','Aldi',579.78,692.37,'Sunt non minima tempora assumenda fuga animi.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(15,1,3,8,0,'2022-01-25','Tesco',1729.59,1169.97,'Est libero dolorem nesciunt.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(16,1,2,1,0,'2021-07-08','LIDL',1807.76,1418.10,'Iste nisi incidunt occaecati voluptatem illo eius rerum.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(17,1,10,6,0,'2021-07-07','Halifax Mortgage',-1276.64,2113.56,'Sunt accusamus perferendis aliquid at molestiae nostrum ratione.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(18,1,2,6,0,'2022-01-21','Petplan',241.78,2261.61,'Beatae earum reprehenderit repudiandae quo neque natus.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(19,1,4,9,0,'2021-12-18','ALDI',-262.53,-76.16,'Dolore quod natus eligendi voluptatem dolor repellendus ab.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(20,1,4,2,0,'2021-12-24','LIDL',505.13,900.63,'Accusamus est voluptate odit veniam doloremque.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(21,1,3,2,0,'2021-12-12','Petplan 2',-465.14,2950.26,'Ea aut nam explicabo vel vel.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(22,1,7,15,0,'2022-03-03','Aldi',-147.62,-33.48,'Aut esse quod ut aut eum sit aut.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(23,1,4,2,0,'2021-09-26','ALDI',-1368.57,398.87,'Accusamus earum voluptates consequatur quo dolor porro.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(24,1,9,2,0,'2021-03-16','Halifax Mortgage',1452.73,1207.87,'Et enim tenetur ea pariatur amet quo.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(25,1,7,6,0,'2021-03-23','Asda',-1178.33,635.71,'Qui autem consequatur et.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(26,1,6,3,0,'2021-07-14','Petplan 2',-749.99,2329.37,'Porro et voluptatem est consequatur similique quod iusto dolores.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(27,1,7,4,0,'2021-12-28','Denplan',-1519.73,1052.33,'Hic facilis sapiente suscipit ut quaerat iure quasi.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(28,1,8,6,0,'2022-01-19','Aldi',994.97,1339.09,'Repellendus et dolor maxime.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(29,1,3,14,0,'2021-11-19','Aldi',-1108.89,2654.14,'Et ullam error sit praesentium.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(30,1,4,3,0,'2021-06-11','Halifax Mortgage',-1024.68,1213.51,'Tempora autem assumenda qui pariatur nam commodi architecto.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(31,1,6,12,0,'2021-07-02','Aldi',-1474.99,115.07,'Delectus ut cum error fugiat eaque architecto excepturi.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(32,1,4,13,0,'2022-01-31','Aldi',953.76,175.93,'Nihil et perferendis incidunt.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(33,1,2,12,0,'2021-10-18','Aldi',1716.04,1087.86,'Veniam explicabo in rerum ut non.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(34,1,9,5,0,'2021-03-14','Petplan',-1197.29,625.83,'Quibusdam suscipit laudantium aperiam aut et ipsa voluptatem et.','2022-03-09 23:52:16','2022-03-09 23:52:16'),
(35,1,8,11,0,'2021-05-12','Halifax Mortgage',-791.35,1588.29,'Quasi ea ratione ullam est eum at culpa.','2022-03-09 23:52:17','2022-03-09 23:52:17'),
(36,1,3,9,0,'2021-08-06','PetPlan 1',-601.22,1500.59,'Ea eum laudantium velit dolor facilis dolores eius sed.','2022-03-09 23:52:17','2022-03-09 23:52:17'),
(37,1,6,15,0,'2022-03-08','ALDI',1106.86,951.24,'Ut minus vel repellat.','2022-03-09 23:52:17','2022-03-09 23:52:17'),
(38,1,9,2,0,'2021-05-21','Denplan',-1775.94,414.59,'Saepe facilis aut dolores molestiae eaque delectus.','2022-03-09 23:52:17','2022-03-09 23:52:17'),
(39,1,6,3,0,'2021-03-27','LIDL',-1640.59,703.02,'Aliquam facere animi cupiditate rem.','2022-03-09 23:52:17','2022-03-09 23:52:17'),
(40,1,6,9,0,'2021-03-12','PetPlan 1',535.73,2403.06,'Doloremque saepe tempora fuga facilis maiores ex similique consequatur.','2022-03-09 23:52:17','2022-03-09 23:52:17'),
(41,1,9,2,0,'2021-03-23','Halifax Mortgage',-1822.16,1027.64,'Voluptas facilis officiis aut quia eum.','2022-03-09 23:52:17','2022-03-09 23:52:17'),
(42,1,1,4,0,'2022-01-19','Halifax TMPP',1337.11,566.73,'Perferendis veniam et quam voluptatem rerum dolore maxime.','2022-03-09 23:52:17','2022-03-09 23:52:17'),
(43,1,10,7,0,'2021-12-01','Denplan',-1701.34,1167.39,'Et perferendis assumenda voluptas eligendi distinctio velit quia rerum.','2022-03-09 23:52:17','2022-03-09 23:52:17'),
(44,1,8,2,0,'2021-03-31','ALDI',1155.07,121.02,'Dolore quis ullam dolore repellendus a quidem.','2022-03-09 23:52:17','2022-03-09 23:52:17'),
(45,1,2,10,0,'2021-09-02','Halifax Mortgage',-233.12,2972.55,'Quam quis explicabo excepturi qui aliquam consequuntur iste eos.','2022-03-09 23:52:17','2022-03-09 23:52:17'),
(46,1,6,5,0,'2021-04-19','Denplan',-549.12,126.25,'Ut temporibus maxime modi rem laboriosam ea ut.','2022-03-09 23:52:17','2022-03-09 23:52:17'),
(47,1,10,15,0,'2021-10-31','Denplan',1994.71,2709.64,'Quibusdam ratione est reiciendis sapiente commodi.','2022-03-09 23:52:18','2022-03-09 23:52:18'),
(48,1,3,11,0,'2021-11-20','Denplan',46.62,2986.07,'Est qui est nam eligendi inventore blanditiis possimus.','2022-03-09 23:52:18','2022-03-09 23:52:18'),
(49,1,3,9,0,'2021-08-02','Aldi',-1679.53,2537.90,'Est eveniet molestiae fugit.','2022-03-09 23:52:18','2022-03-09 23:52:18'),
(50,1,2,15,0,'2021-12-10','Petplan',-997.71,951.74,'Culpa quis praesentium fugit numquam exercitationem et.','2022-03-09 23:52:18','2022-03-09 23:52:18'),
(51,1,10,15,0,'2021-08-09','PetPlan 1',-1820.29,1309.16,'Aut ex cum eveniet.','2022-03-09 23:52:18','2022-03-09 23:52:18'),
(52,1,10,13,0,'2021-09-10','Aldi',1725.91,1621.93,'Veniam magnam natus aut eius aspernatur.','2022-03-09 23:52:18','2022-03-09 23:52:18'),
(53,1,9,15,0,'2022-01-11','LIDL',-1768.61,430.58,'Quo perferendis aut eos aut.','2022-03-09 23:52:18','2022-03-09 23:52:18'),
(54,1,4,8,0,'2022-02-12','LIDL',-697.81,197.38,'Earum ad repellendus magnam sequi.','2022-03-09 23:52:18','2022-03-09 23:52:18'),
(55,1,4,5,0,'2022-02-25','Tesco',81.45,538.13,'Velit mollitia odit voluptatibus laudantium et.','2022-03-09 23:52:18','2022-03-09 23:52:18'),
(56,1,4,4,0,'2021-11-16','Denplan',-184.62,1810.39,'Modi ipsum voluptas dolorem ab harum.','2022-03-09 23:52:18','2022-03-09 23:52:18'),
(57,1,6,6,0,'2021-11-03','Aldi',653.33,314.41,'Consequatur autem expedita impedit sunt ipsam.','2022-03-09 23:52:18','2022-03-09 23:52:18'),
(58,1,1,3,0,'2021-03-13','PetPlan 1',-284.41,1232.10,'Dolore delectus dolor quia voluptatum deserunt delectus voluptatem.','2022-03-09 23:52:18','2022-03-09 23:52:18'),
(59,1,5,6,0,'2021-10-14','Denplan',-427.10,1348.30,'Ducimus consequatur nostrum sit dolores quia voluptatem vero est.','2022-03-09 23:52:18','2022-03-09 23:52:18'),
(60,1,10,8,0,'2021-07-15','Tesco',-909.89,1847.91,'Veritatis ut perferendis facere quasi et aliquam voluptates.','2022-03-09 23:52:18','2022-03-09 23:52:18'),
(61,1,5,4,0,'2021-06-02','Petplan 2',-1869.72,2999.53,'Qui nihil aliquid excepturi fuga et voluptatem qui.','2022-03-09 23:52:19','2022-03-09 23:52:19'),
(62,1,5,10,0,'2021-04-29','LIDL',911.59,1351.06,'Iusto excepturi nam ipsa aspernatur enim ratione dolores debitis.','2022-03-09 23:52:19','2022-03-09 23:52:19'),
(63,1,8,15,0,'2021-12-28','Petplan 2',1680.23,2357.96,'Inventore vel est quibusdam facilis id earum similique.','2022-03-09 23:52:19','2022-03-09 23:52:19'),
(64,1,6,11,0,'2021-04-07','Petplan',-140.95,2945.35,'Et qui dolor optio culpa numquam dolorem at.','2022-03-09 23:52:19','2022-03-09 23:52:19'),
(65,1,7,14,0,'2021-04-04','Petplan',624.94,1141.08,'Est natus aut ad autem dolorum totam.','2022-03-09 23:52:19','2022-03-09 23:52:19'),
(66,1,5,6,0,'2021-10-26','Halifax Mortgage',-1033.78,-10.45,'Ad expedita quod alias alias qui corrupti ratione.','2022-03-09 23:52:19','2022-03-09 23:52:19'),
(67,1,5,3,0,'2021-11-08','PetPlan 1',330.35,2817.63,'Atque commodi sed ut.','2022-03-09 23:52:19','2022-03-09 23:52:19'),
(68,1,10,8,0,'2021-10-30','Petplan 2',-1830.48,695.26,'Qui velit mollitia eos odit consequatur modi.','2022-03-09 23:52:19','2022-03-09 23:52:19'),
(69,1,4,10,0,'2021-11-01','Aldi',1260.58,1376.72,'Aut quas perferendis cumque voluptatem iusto adipisci.','2022-03-09 23:52:19','2022-03-09 23:52:19'),
(70,1,8,15,0,'2021-09-30','Petplan 2',-1871.68,260.07,'Placeat natus fugit eum aut officiis.','2022-03-09 23:52:19','2022-03-09 23:52:19'),
(71,1,10,7,0,'2021-05-20','LIDL',56.31,2312.99,'Non autem ea nisi praesentium et.','2022-03-09 23:52:19','2022-03-09 23:52:19'),
(72,1,4,1,0,'2021-11-13','Denplan',706.08,1121.01,'Non inventore rem laborum placeat facilis necessitatibus distinctio nulla.','2022-03-09 23:52:20','2022-03-09 23:52:20'),
(73,1,7,2,0,'2021-04-03','Asda',1060.20,1459.95,'Sint voluptates magni hic fugit cum.','2022-03-09 23:52:20','2022-03-09 23:52:20'),
(74,1,9,5,0,'2022-02-09','LIDL',-805.76,2698.42,'Blanditiis explicabo unde consequatur accusantium sequi voluptatem.','2022-03-09 23:52:20','2022-03-09 23:52:20'),
(75,1,7,10,0,'2021-04-18','Aldi',-313.26,859.34,'Quae eum et sint unde doloremque.','2022-03-09 23:52:20','2022-03-09 23:52:20'),
(76,1,10,3,0,'2021-07-27','Halifax Mortgage',-358.24,523.25,'Veritatis est natus ad a sed id sit culpa.','2022-03-09 23:52:20','2022-03-09 23:52:20'),
(77,1,10,5,0,'2021-12-31','PetPlan 1',1492.70,1315.97,'Sed suscipit fugiat fugit provident sit deserunt quia.','2022-03-09 23:52:20','2022-03-09 23:52:20'),
(78,1,2,15,0,'2021-12-28','Petplan',558.48,-2.84,'Sed quis sed accusantium ut.','2022-03-09 23:52:20','2022-03-09 23:52:20'),
(79,1,3,3,0,'2021-07-08','LIDL',-1187.58,1428.39,'Quas et architecto aspernatur eum.','2022-03-09 23:52:20','2022-03-09 23:52:20'),
(80,1,5,12,0,'2021-04-07','Petplan',1599.11,1681.32,'Error assumenda et voluptatum aliquid.','2022-03-09 23:52:20','2022-03-09 23:52:20'),
(81,1,2,6,0,'2022-01-21','Aldi',-1467.28,311.48,'Rerum qui dolorum molestiae earum qui.','2022-03-09 23:52:20','2022-03-09 23:52:20'),
(82,1,7,9,0,'2021-05-21','Denplan',1197.15,955.39,'Hic ullam sit est excepturi quam aliquam.','2022-03-09 23:52:20','2022-03-09 23:52:20'),
(83,1,9,10,0,'2021-06-20','PetPlan 1',-1230.70,2626.27,'Quidem ea corrupti in consequuntur iste temporibus.','2022-03-09 23:52:20','2022-03-09 23:52:20'),
(84,1,10,4,0,'2021-03-12','Tesco',-1539.33,1607.57,'Ut nihil sint dolor pariatur.','2022-03-09 23:52:20','2022-03-09 23:52:20'),
(85,1,1,4,0,'2021-04-14','PetPlan 1',1906.24,2000.88,'Unde odit rerum corporis voluptas.','2022-03-09 23:52:21','2022-03-09 23:52:21'),
(86,1,1,12,0,'2021-07-14','Petplan',168.94,1711.66,'Enim possimus illum ullam voluptatum est.','2022-03-09 23:52:21','2022-03-09 23:52:21'),
(87,1,10,9,0,'2021-07-21','Tesco',621.25,2168.90,'Natus dignissimos veniam culpa corporis nobis sint aperiam.','2022-03-09 23:52:21','2022-03-09 23:52:21'),
(88,1,9,3,0,'2021-07-08','ALDI',-532.82,2955.40,'Iusto quis et modi voluptate dolores consequatur corrupti.','2022-03-09 23:52:21','2022-03-09 23:52:21'),
(89,1,1,10,0,'2021-09-30','Halifax Mortgage',-568.50,1265.94,'Ea sapiente placeat velit pariatur voluptatem.','2022-03-09 23:52:21','2022-03-09 23:52:21'),
(90,1,1,2,0,'2021-04-19','ALDI',743.30,2356.20,'Deserunt voluptatum sint quidem ducimus.','2022-03-09 23:52:21','2022-03-09 23:52:21'),
(91,1,4,2,0,'2021-08-15','LIDL',-1703.77,1142.10,'Ex porro excepturi exercitationem rerum iste.','2022-03-09 23:52:21','2022-03-09 23:52:21'),
(92,1,8,11,0,'2022-01-24','PetPlan 1',1157.76,2575.71,'Eveniet maxime vitae quam quia eum et et.','2022-03-09 23:52:21','2022-03-09 23:52:21'),
(93,1,6,11,0,'2021-09-05','Denplan',951.14,1446.99,'Debitis enim accusamus eligendi maxime rerum inventore minus.','2022-03-09 23:52:21','2022-03-09 23:52:21'),
(94,1,2,10,0,'2021-07-02','Petplan',1238.84,2094.28,'Voluptas voluptatibus voluptate facilis fuga.','2022-03-09 23:52:21','2022-03-09 23:52:21'),
(95,1,10,14,0,'2021-10-26','Halifax TMPP',364.22,1592.60,'Recusandae ut ut quis neque dolore tempora.','2022-03-09 23:52:21','2022-03-09 23:52:21'),
(96,1,5,14,0,'2022-02-24','Tesco',-1441.29,2732.25,'Magnam provident omnis quia non.','2022-03-09 23:52:22','2022-03-09 23:52:22'),
(97,1,5,1,0,'2021-08-29','Aldi',429.77,2893.98,'Consequatur voluptate molestias placeat soluta et.','2022-03-09 23:52:22','2022-03-09 23:52:22'),
(98,1,2,11,0,'2022-01-01','Asda',1847.12,2489.44,'Mollitia quam maxime facere id.','2022-03-09 23:52:22','2022-03-09 23:52:22'),
(99,1,3,14,0,'2021-08-30','Asda',154.04,1328.30,'Mollitia sunt occaecati eos eos et aliquid nostrum.','2022-03-09 23:52:22','2022-03-09 23:52:22'),
(100,1,6,13,0,'2021-06-03','Petplan',84.27,1374.21,'Neque magnam consequuntur inventore natus.','2022-03-09 23:52:22','2022-03-09 23:52:22'),
(101,1,10,14,0,'2021-11-15','ALDI',1844.30,868.82,'Nihil consectetur voluptatem qui sunt.','2022-03-09 23:52:22','2022-03-09 23:52:22'),
(102,1,1,8,0,'2022-02-09','Petplan 2',1989.09,1970.57,'Ex nihil illo saepe in iste magnam alias.','2022-03-09 23:52:22','2022-03-09 23:52:22'),
(103,1,10,1,0,'2021-04-10','Aldi',1427.72,263.44,'Eos dolor nemo qui mollitia dicta alias voluptas.','2022-03-09 23:52:22','2022-03-09 23:52:22'),
(104,1,6,10,0,'2021-11-06','Halifax Mortgage',-92.92,2551.56,'Quasi perferendis est placeat.','2022-03-09 23:52:22','2022-03-09 23:52:22'),
(105,1,8,2,0,'2022-03-09','Petplan 2',573.44,1369.46,'Ab aspernatur animi quia omnis sed quam sint.','2022-03-09 23:52:22','2022-03-09 23:52:22'),
(106,1,8,3,0,'2021-12-18','Tesco',-905.14,2227.90,'Recusandae qui dolores delectus explicabo tempora deserunt voluptatem.','2022-03-09 23:52:22','2022-03-09 23:52:22'),
(107,1,3,11,0,'2021-12-16','Petplan 2',-268.84,2982.99,'Sint sint voluptatem eum ea harum est.','2022-03-09 23:52:22','2022-03-09 23:52:22'),
(108,1,3,11,0,'2021-10-14','Halifax Mortgage',393.00,387.78,'Eum voluptatibus voluptatem ipsa sit.','2022-03-09 23:52:22','2022-03-09 23:52:22'),
(109,1,8,8,0,'2021-10-25','Petplan',1695.02,2200.48,'Odio hic fugiat harum sint quos.','2022-03-09 23:52:22','2022-03-09 23:52:22'),
(110,1,5,7,0,'2021-06-09','Asda',-1586.92,1901.61,'Modi aut accusamus maxime occaecati est hic vel iusto.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(111,1,2,2,0,'2021-12-02','Asda',1263.13,97.27,'Deleniti saepe ut dolorem perspiciatis.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(112,1,8,13,0,'2021-11-21','Aldi',-526.11,1833.73,'Veritatis molestiae iure suscipit error voluptate iusto temporibus.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(113,1,3,7,0,'2021-10-16','Tesco',1236.46,981.73,'Numquam molestias ea quos quam minus.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(114,1,7,12,0,'2022-02-18','ALDI',-641.82,2727.02,'Vel autem illo quia porro magni similique.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(115,1,3,2,0,'2021-03-12','Aldi',1555.66,1800.27,'Maxime est provident est est est sint.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(116,1,10,2,0,'2022-01-19','PetPlan 1',1287.12,1196.77,'Neque placeat maiores molestiae vel a ut velit.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(117,1,8,10,0,'2022-01-03','Tesco',1347.69,2377.47,'Quas et voluptas laboriosam autem enim.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(118,1,8,14,0,'2022-03-06','PetPlan 1',1810.65,-14.96,'Optio quia esse et doloremque laborum illum adipisci optio.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(119,1,10,10,0,'2022-02-23','Aldi',-283.01,855.60,'Id et nam placeat qui pariatur rem non.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(120,1,10,14,0,'2021-09-27','LIDL',-1516.01,2175.49,'Ut deleniti aut eos expedita esse.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(121,1,8,12,0,'2021-07-23','Denplan',280.32,955.76,'Esse debitis quod molestiae vero veritatis suscipit.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(122,1,7,3,0,'2021-04-01','Asda',944.29,1798.94,'Sequi omnis magni doloribus quis non cupiditate.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(123,1,9,3,0,'2021-05-02','Petplan 2',-538.68,877.01,'Et repellat eos commodi unde vel voluptas quia.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(124,1,5,2,0,'2021-07-30','PetPlan 1',-551.94,1081.93,'Quo nostrum quo ad ut.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(125,1,9,10,0,'2022-02-13','ALDI',802.81,120.57,'Perspiciatis aut ratione ipsa ut voluptas et minima.','2022-03-09 23:52:23','2022-03-09 23:52:23'),
(126,1,10,1,0,'2021-07-06','Aldi',1208.70,2569.03,'Et provident nulla magnam animi et et.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(127,1,10,12,0,'2022-01-02','ALDI',-321.30,1843.36,'Dolor molestiae cum animi rerum.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(128,1,1,4,0,'2021-11-09','Halifax TMPP',-1856.53,2579.98,'Sapiente consequuntur occaecati accusantium.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(129,1,2,9,0,'2022-01-19','Halifax TMPP',-547.01,705.02,'Recusandae tempora qui laudantium beatae.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(130,1,5,14,0,'2021-08-08','Halifax Mortgage',-1559.79,358.89,'Voluptas quam quaerat id voluptas rerum fuga.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(131,1,7,12,0,'2021-09-12','Aldi',-903.47,1096.62,'Ad iusto reprehenderit optio ipsam quia magnam consequuntur.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(132,1,4,11,0,'2021-11-14','LIDL',874.16,2833.55,'Eaque consequatur impedit eos excepturi consequatur sed.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(133,1,7,9,0,'2021-05-11','Asda',171.64,961.07,'Aut et dignissimos blanditiis quis doloribus voluptatum.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(134,1,5,2,0,'2021-09-16','Aldi',1208.25,2999.38,'Ad ut voluptates et a.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(135,1,4,1,0,'2021-10-28','Aldi',-1494.86,633.64,'Vitae ut qui ex est.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(136,1,3,14,0,'2022-03-09','Aldi',-1449.29,1632.05,'Aperiam et expedita facilis harum.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(137,1,9,8,0,'2022-01-24','ALDI',88.68,2682.28,'Placeat ut quaerat reprehenderit adipisci est facere.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(138,1,5,4,0,'2021-11-27','Aldi',-1171.59,1988.76,'Quo ex iure corporis.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(139,1,10,4,0,'2022-02-03','Petplan',11.23,2206.86,'Sapiente animi ad omnis quas.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(140,1,1,5,0,'2021-10-29','Halifax Mortgage',236.04,2097.71,'Molestias ea laborum necessitatibus.','2022-03-09 23:52:24','2022-03-09 23:52:24'),
(141,1,7,10,0,'2021-03-10','Denplan',121.92,1003.17,'Voluptatum incidunt et aperiam animi molestias.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(142,1,5,11,0,'2022-01-19','Petplan 2',-194.80,2.85,'Nihil fugit voluptatibus labore est sit et.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(143,1,9,9,0,'2021-07-04','Aldi',1057.33,2687.86,'Dolorem voluptatum enim optio est labore quae et repellendus.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(144,1,3,11,0,'2021-05-29','LIDL',-562.69,1799.46,'Reprehenderit praesentium quia impedit quod aut labore occaecati.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(145,1,9,8,0,'2021-03-17','Petplan',-663.81,2564.08,'Quae non et consequatur distinctio.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(146,1,5,1,0,'2021-08-22','Petplan 2',-1406.91,2031.52,'Minus facere deleniti dolores cum et.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(147,1,1,5,0,'2022-02-02','Petplan 2',1920.66,2043.04,'Aut libero dolorem et.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(148,1,9,14,0,'2021-12-20','Petplan 2',31.55,1291.01,'Ad in rerum laborum quaerat dolore.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(149,1,3,9,0,'2021-04-16','ALDI',1792.96,554.34,'Omnis amet iure aut repellat odio aliquam dolorem omnis.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(150,1,8,10,0,'2021-11-12','Aldi',190.50,2208.36,'Iure sed dolore voluptatem adipisci.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(151,1,3,6,0,'2021-04-13','Aldi',-226.19,749.18,'Sapiente dignissimos rerum rerum ratione dolorem.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(152,1,10,12,0,'2021-06-13','Halifax Mortgage',-340.05,2099.75,'Asperiores adipisci voluptatibus et dignissimos.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(153,1,4,8,0,'2021-09-21','Petplan',-1499.09,399.82,'Ea officia vitae non dolorem sed dignissimos rem.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(154,1,9,13,0,'2021-09-17','Aldi',-717.57,1495.17,'Eaque est incidunt quasi ut ut rerum consequatur.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(155,1,2,11,0,'2021-07-26','Halifax Mortgage',1474.31,1631.48,'Praesentium dolore corrupti omnis laboriosam.','2022-03-09 23:52:25','2022-03-09 23:52:25'),
(156,1,10,9,0,'2021-10-20','Aldi',108.68,83.26,'Nobis debitis vel perspiciatis quia.','2022-03-09 23:52:26','2022-03-09 23:52:26'),
(157,1,2,5,0,'2022-01-25','Aldi',-1204.76,2461.14,'Quo quia provident ut consectetur aut.','2022-03-09 23:52:26','2022-03-09 23:52:26'),
(158,1,10,9,0,'2021-10-11','Halifax Mortgage',-226.14,2745.13,'Iusto doloribus omnis atque voluptates omnis quia.','2022-03-09 23:52:26','2022-03-09 23:52:26'),
(159,1,5,12,0,'2021-10-23','ALDI',1269.66,2172.85,'Expedita fuga qui vel ad dicta animi.','2022-03-09 23:52:26','2022-03-09 23:52:26'),
(160,1,1,1,0,'2022-01-11','Halifax TMPP',949.65,1578.72,'Consequatur aut labore sunt dolore enim quia accusantium.','2022-03-09 23:52:26','2022-03-09 23:52:26'),
(161,1,10,4,0,'2021-03-30','Asda',1711.10,2086.12,'Laboriosam sed voluptatem qui magni.','2022-03-09 23:52:26','2022-03-09 23:52:26'),
(162,1,10,8,0,'2021-06-23','PetPlan 1',-1874.10,909.23,'Ut quibusdam delectus temporibus nesciunt cupiditate.','2022-03-09 23:52:26','2022-03-09 23:52:26'),
(163,1,6,15,0,'2021-04-29','Halifax Mortgage',1266.87,2187.75,'Rem et ut quas et.','2022-03-09 23:52:26','2022-03-09 23:52:26'),
(164,1,6,10,0,'2021-12-28','Aldi',-12.33,341.43,'Doloribus quia repellendus eaque sit doloremque.','2022-03-09 23:52:26','2022-03-09 23:52:26'),
(165,1,3,6,0,'2021-08-02','Petplan',342.77,1594.98,'Ea aperiam voluptatem facilis.','2022-03-09 23:52:26','2022-03-09 23:52:26'),
(166,1,3,7,0,'2021-09-21','LIDL',1339.03,2610.61,'Repellat magnam et accusantium placeat nihil eos.','2022-03-09 23:52:26','2022-03-09 23:52:26'),
(167,1,2,3,0,'2021-12-23','Aldi',303.00,1709.21,'Quas qui nihil quo.','2022-03-09 23:52:26','2022-03-09 23:52:26'),
(168,1,1,9,0,'2021-08-08','Denplan',-622.60,303.41,'Aliquam voluptas excepturi ut labore aut.','2022-03-09 23:52:26','2022-03-09 23:52:26'),
(169,1,6,12,0,'2021-07-02','Petplan 2',1699.35,1575.12,'Incidunt fuga molestiae quas.','2022-03-09 23:52:27','2022-03-09 23:52:27'),
(170,1,6,8,0,'2021-06-11','Tesco',1365.44,2952.50,'Commodi ipsum rerum alias harum fugiat est asperiores.','2022-03-09 23:52:27','2022-03-09 23:52:27'),
(171,1,9,15,0,'2021-11-21','Denplan',683.02,598.91,'Repellat blanditiis necessitatibus inventore rerum.','2022-03-09 23:52:27','2022-03-09 23:52:27'),
(172,1,2,2,0,'2021-06-04','Halifax TMPP',-41.27,1593.53,'Necessitatibus voluptates voluptas quam illo.','2022-03-09 23:52:27','2022-03-09 23:52:27'),
(173,1,5,5,0,'2021-07-06','ALDI',1874.99,2210.80,'Et quibusdam est maxime eveniet aspernatur ut.','2022-03-09 23:52:27','2022-03-09 23:52:27'),
(174,1,9,4,0,'2021-08-22','Petplan 2',-358.51,978.76,'Exercitationem aut ipsam voluptas tenetur odio.','2022-03-09 23:52:27','2022-03-09 23:52:27'),
(175,1,6,8,0,'2021-12-25','PetPlan 1',-779.21,5.18,'Quis modi aut repudiandae autem unde perferendis.','2022-03-09 23:52:27','2022-03-09 23:52:27'),
(176,1,6,9,0,'2022-02-15','Petplan 2',1954.84,757.92,'Eos esse laboriosam eum.','2022-03-09 23:52:27','2022-03-09 23:52:27'),
(177,1,8,2,0,'2021-08-11','Aldi',-1063.17,2073.44,'Et suscipit inventore aut.','2022-03-09 23:52:27','2022-03-09 23:52:27'),
(178,1,6,12,0,'2021-04-13','Halifax TMPP',-771.82,2880.97,'In exercitationem ut omnis pariatur veritatis earum sint.','2022-03-09 23:52:27','2022-03-09 23:52:27'),
(179,1,1,7,0,'2021-12-13','Halifax Mortgage',979.57,1393.38,'Rerum officia dolores et.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(180,1,8,12,0,'2021-04-09','Asda',-1307.75,192.14,'Non beatae eius in est voluptas at.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(181,1,4,8,0,'2021-09-05','PetPlan 1',1655.30,2214.78,'Praesentium necessitatibus quas ex maiores commodi accusantium.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(182,1,4,3,0,'2022-01-21','Petplan',150.94,2877.56,'Eum sed ea itaque maiores.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(183,1,6,4,0,'2021-04-13','Tesco',715.19,2653.14,'Voluptatem est et alias ut nam culpa.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(184,1,8,7,0,'2022-01-20','Asda',-355.01,2707.00,'Consequatur quis sint molestias facilis doloribus et incidunt dolor.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(185,1,5,9,0,'2021-11-18','Halifax Mortgage',-837.35,2169.14,'Dignissimos eligendi voluptatibus aut et.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(186,1,2,7,0,'2021-11-07','Halifax TMPP',-1348.47,123.67,'Perferendis vero consequatur est.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(187,1,10,12,0,'2021-07-23','LIDL',-1607.73,1919.11,'Veritatis modi ut modi temporibus.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(188,1,2,14,0,'2021-09-08','PetPlan 1',687.91,2909.43,'Ullam in sit voluptate dolorem sapiente.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(189,1,1,2,0,'2022-02-24','PetPlan 1',-1876.43,-67.45,'Dolor libero qui labore enim rem rerum.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(190,1,7,4,0,'2021-11-30','Denplan',1070.21,97.70,'Totam inventore aut pariatur necessitatibus necessitatibus est et.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(191,1,5,8,0,'2021-07-05','Halifax Mortgage',-316.04,841.60,'Necessitatibus pariatur aut quibusdam adipisci temporibus facilis.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(192,1,5,5,0,'2021-11-22','ALDI',-1125.95,2537.89,'Sed et inventore magni eaque atque sapiente aut.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(193,1,7,12,0,'2021-08-25','Petplan',416.42,361.44,'Labore est ut ut aperiam eos aut expedita.','2022-03-09 23:52:28','2022-03-09 23:52:28'),
(194,1,9,1,0,'2021-10-17','Halifax Mortgage',-577.66,457.31,'Quasi libero ex doloremque laudantium voluptates.','2022-03-09 23:52:29','2022-03-09 23:52:29'),
(195,1,9,13,0,'2021-04-14','Asda',-143.68,1578.55,'Dolorum fugiat commodi cum consectetur fuga veritatis.','2022-03-09 23:52:29','2022-03-09 23:52:29'),
(196,1,5,6,0,'2021-09-20','Petplan',784.44,2625.91,'Qui nihil quis odio nesciunt id distinctio.','2022-03-09 23:52:29','2022-03-09 23:52:29'),
(197,1,4,12,0,'2021-09-20','Petplan',-1476.64,1581.39,'Suscipit ratione voluptas corrupti ipsum voluptates.','2022-03-09 23:52:29','2022-03-09 23:52:29'),
(198,1,3,5,0,'2021-05-12','Aldi',1625.04,1915.77,'Est exercitationem quo vitae porro.','2022-03-09 23:52:29','2022-03-09 23:52:29'),
(199,1,10,9,0,'2021-03-10','ALDI',1341.49,668.21,'Libero et ut ipsam eaque est ullam.','2022-03-09 23:52:29','2022-03-09 23:52:29'),
(200,1,10,14,0,'2021-05-06','Halifax TMPP',-956.97,2810.63,'Impedit repellendus doloremque temporibus rem.','2022-03-09 23:52:29','2022-03-09 23:52:29'),
(201,1,6,4,0,'2022-02-25','Asda',1843.21,1940.63,'Veniam illum repellendus ad est.','2022-03-09 23:52:29','2022-03-09 23:52:29'),
(202,1,5,15,0,'2021-08-07','Petplan',1501.69,-84.22,'Ut odit distinctio quas perferendis atque dolores.','2022-03-09 23:52:29','2022-03-09 23:52:29'),
(203,1,1,13,0,'2022-03-07','ALDI',-1165.83,2719.23,'Consequatur eius tempore corporis inventore aut.','2022-03-09 23:52:29','2022-03-09 23:52:29'),
(204,1,4,4,0,'2021-07-18','Petplan 2',-935.48,2584.42,'Enim ipsa quaerat ut.','2022-03-09 23:52:29','2022-03-09 23:52:29'),
(205,1,2,5,0,'2021-11-26','Petplan 2',-111.45,530.43,'Voluptatem nobis sit veritatis autem expedita temporibus aut voluptatibus.','2022-03-09 23:52:29','2022-03-09 23:52:29'),
(206,1,4,2,0,'2021-10-06','Aldi',1754.09,2651.35,'Tenetur eum exercitationem et cumque illum sed.','2022-03-09 23:52:29','2022-03-09 23:52:29'),
(207,1,4,4,0,'2021-04-29','Denplan',372.91,2741.38,'In eius sapiente et et optio asperiores.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(208,1,5,9,0,'2021-04-09','Halifax TMPP',-1512.24,782.03,'Incidunt qui ratione et quod in.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(209,1,1,8,0,'2021-10-05','Petplan',-406.53,1860.91,'Perspiciatis repellat tenetur et expedita sapiente ab nostrum.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(210,1,3,8,0,'2022-02-27','Asda',-84.85,989.82,'Saepe velit aspernatur harum animi.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(211,1,4,10,0,'2022-03-04','ALDI',-1231.99,659.73,'Sequi impedit velit reiciendis qui.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(212,1,2,1,0,'2021-05-28','Petplan',-508.10,1174.15,'Unde iste reiciendis aperiam temporibus.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(213,1,3,14,0,'2022-01-20','Halifax TMPP',871.91,246.76,'Amet nihil est aliquam qui.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(214,1,4,7,0,'2021-06-30','Tesco',-1368.60,2901.46,'Quo sed repudiandae facilis voluptas totam.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(215,1,4,5,0,'2021-09-09','Halifax TMPP',1417.54,2828.95,'Eveniet ut in porro.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(216,1,5,13,0,'2021-12-17','Asda',-1647.10,1896.11,'Amet iste ratione excepturi quae dolorem soluta quia.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(217,1,3,5,0,'2021-03-11','ALDI',-274.99,818.05,'Ut nemo et consequatur est excepturi aut voluptatibus.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(218,1,8,11,0,'2022-01-08','Aldi',233.73,1250.89,'Aliquam modi iure voluptatum.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(219,1,10,1,0,'2021-09-01','LIDL',761.83,534.99,'Dolore quas dolores a.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(220,1,1,3,0,'2021-11-14','Asda',1847.17,1493.63,'Et ut eaque et odio sed atque sed.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(221,1,1,15,0,'2021-10-13','Halifax TMPP',854.83,1338.44,'Sed et eos aut et labore inventore est dolorum.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(222,1,10,8,0,'2021-09-13','LIDL',1506.80,2074.28,'Nobis veniam et molestiae voluptatem sunt et.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(223,1,5,9,0,'2021-04-17','Petplan',-1776.95,2537.05,'Enim est et doloribus dicta expedita molestiae omnis corporis.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(224,1,5,10,0,'2021-11-22','Petplan 2',307.53,922.88,'Unde itaque aliquam inventore natus.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(225,1,5,1,0,'2021-10-04','Denplan',-1521.85,1541.19,'Porro mollitia nemo cupiditate minima velit perspiciatis minus.','2022-03-09 23:52:30','2022-03-09 23:52:30'),
(226,1,6,9,0,'2021-07-13','Petplan',625.34,2305.63,'Nihil omnis voluptas magnam.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(227,1,9,5,0,'2021-06-24','LIDL',-669.95,1377.79,'Atque quaerat vel expedita cumque neque.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(228,1,2,13,0,'2022-01-20','LIDL',1379.16,2360.87,'Aut consequatur laborum rerum.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(229,1,9,1,0,'2021-07-22','Aldi',1053.85,-26.80,'Non id nobis eum voluptate aut consequatur.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(230,1,8,6,0,'2021-03-14','Tesco',648.77,237.31,'Qui inventore sapiente eum debitis voluptas.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(231,1,9,15,0,'2021-03-25','PetPlan 1',-1472.82,2066.05,'Ex et optio voluptatem fuga ut.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(232,1,2,10,0,'2021-05-31','Halifax Mortgage',970.27,2066.93,'Magnam consequuntur delectus consequatur iste qui.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(233,1,5,10,0,'2021-07-17','LIDL',-31.90,2530.18,'Facilis sed adipisci dolores tempore ut suscipit.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(234,1,6,4,0,'2021-09-19','Denplan',-1275.51,8.67,'Veniam alias necessitatibus modi debitis ut aut.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(235,1,5,9,0,'2021-11-17','Aldi',-1046.93,2903.23,'Consequatur voluptatem sint ipsa illo error.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(236,1,10,2,0,'2021-10-31','Petplan 2',918.23,884.45,'Corporis dolorem corrupti ducimus et temporibus deleniti nobis minus.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(237,1,3,10,0,'2021-11-15','Petplan',1066.49,1115.30,'Esse asperiores voluptatem ipsa amet ut magnam assumenda.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(238,1,2,13,0,'2021-12-15','Denplan',1254.01,455.07,'Atque dolorem ut laboriosam et neque omnis.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(239,1,8,5,0,'2021-06-02','Tesco',1210.02,2987.76,'Cumque facilis reprehenderit omnis maiores suscipit consequatur eius.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(240,1,9,13,0,'2021-04-19','Aldi',-1664.99,447.44,'Corporis enim doloremque earum voluptas id ea numquam et.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(241,1,8,5,0,'2021-12-23','Aldi',-1457.46,544.59,'Facilis amet facilis praesentium beatae quos.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(242,1,3,4,0,'2021-10-21','Denplan',1355.05,1203.65,'Hic dolorem natus aliquam omnis enim.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(243,1,6,10,0,'2021-07-01','Halifax Mortgage',-846.74,1055.60,'Reiciendis accusamus repudiandae consequatur ad exercitationem dicta.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(244,1,4,8,0,'2022-01-26','Asda',-546.10,2070.70,'Autem deserunt quis veritatis ratione quisquam rem.','2022-03-09 23:52:31','2022-03-09 23:52:31'),
(245,1,9,12,0,'2021-12-27','Petplan 2',584.25,-32.77,'Culpa aut accusamus voluptas sed maxime cupiditate nihil.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(246,1,8,14,0,'2021-11-27','LIDL',-333.46,2893.51,'Ut incidunt quis at debitis dolorem et est aut.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(247,1,6,6,0,'2021-04-28','ALDI',483.51,1642.76,'Magni soluta quia quod doloribus dolor est.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(248,1,4,13,0,'2021-03-12','Halifax Mortgage',-1508.19,71.25,'Veritatis atque ab repellendus consequuntur distinctio aut.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(249,1,3,10,0,'2022-01-12','Asda',59.26,269.44,'Laudantium voluptatum ad dolorem eum ut et voluptatibus.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(250,1,5,15,0,'2021-08-15','PetPlan 1',-1225.56,-97.34,'Voluptatem ipsum rerum deleniti pariatur voluptatem est ad.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(251,1,11,6,0,'2022-03-05','Daily match',24.75,1281.77,'Ex placeat enim molestiae dolor qui ea fugiat non.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(252,1,11,4,0,'2022-03-06','Daily match',24.75,1892.73,'Veniam explicabo est quos dolorem et nihil.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(253,1,11,15,0,'2022-03-07','Daily match',24.75,2340.38,'Quis magni quidem praesentium omnis expedita voluptas.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(254,1,11,5,0,'2022-03-08','Daily match',24.75,1734.24,'Aut officia consequuntur velit magnam.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(255,1,12,11,0,'2022-02-09','Weekly match',45.00,2525.95,'Quis qui modi voluptatem accusantium.','2022-03-09 23:52:32','2022-03-09 23:52:32'),
(256,1,12,3,0,'2022-02-16','Weekly match',45.00,751.15,'Voluptatem id provident consequuntur voluptatum.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(257,1,12,13,0,'2022-02-23','Weekly match',45.00,479.18,'Iste amet suscipit veritatis atque.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(258,1,12,15,0,'2022-03-02','Weekly match',45.00,249.66,'Qui numquam aliquam unde fuga doloribus quidem voluptatem.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(259,1,12,14,0,'2021-11-10','Weekly match that shouldnt work',45.00,2532.12,'Quia molestiae vel ex quos.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(260,1,12,11,0,'2021-12-01','Weekly match that shouldnt work',45.00,110.27,'Nostrum maiores autem soluta officia.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(261,1,12,11,0,'2021-12-22','Weekly match that shouldnt work',45.00,2196.92,'Exercitationem ut ut laudantium dignissimos vel.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(262,1,12,14,0,'2022-01-12','Weekly match that shouldnt work',45.00,-4.54,'Eos sunt accusamus quia velit nesciunt consequatur.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(263,1,13,4,0,'2021-11-24','Four Weekly match',82.00,242.53,'Voluptatem iusto error veritatis placeat.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(264,1,13,2,0,'2021-12-22','Four Weekly match',82.00,904.94,'Quas repellat tenetur placeat aut magni deserunt.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(265,1,13,6,0,'2022-01-19','Four Weekly match',82.00,2258.97,'Provident molestiae ullam rerum et enim ut voluptatem voluptas.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(266,1,13,3,0,'2022-02-16','Four Weekly match',82.00,1071.55,'Et omnis quia perspiciatis doloremque saepe.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(267,1,14,15,0,'2021-11-09','Monthly match',156.42,2449.08,'Optio impedit voluptatem facere sit.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(268,1,14,13,0,'2021-12-09','Monthly match',156.42,2452.42,'Neque et commodi ut doloribus.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(269,1,14,3,0,'2022-01-09','Monthly match',156.42,2370.48,'Praesentium eos repellendus hic consequuntur rem assumenda eum vel.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(270,1,14,12,0,'2022-02-09','Monthly match',156.42,2927.12,'Dolor accusamus ut et ut.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(271,1,15,1,0,'2021-03-09','Quarterly match',72.86,2071.83,'Nostrum facilis magni vero voluptatem iste.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(272,1,15,2,0,'2021-06-09','Quarterly match',72.86,1614.56,'Quo tempora eum veniam suscipit quo fugiat.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(273,1,15,11,0,'2021-09-09','Quarterly match',72.86,1613.37,'Architecto vero ut asperiores porro.','2022-03-09 23:52:33','2022-03-09 23:52:33'),
(274,1,15,13,0,'2021-12-09','Quarterly match',72.86,2508.38,'Illum possimus porro blanditiis ea.','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(275,1,16,5,0,'2018-04-09','Annual match',52.00,203.82,'Esse provident rem rerum et.','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(276,1,16,14,0,'2019-04-09','Annual match',52.00,393.49,'Explicabo nihil placeat architecto sunt necessitatibus totam.','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(277,1,16,10,0,'2020-04-09','Annual match',52.00,1487.68,'Ullam eveniet iste vitae quisquam praesentium ea.','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(278,1,16,9,0,'2021-04-09','Annual match',52.00,1905.26,'Voluptatem dolore occaecati sunt enim eum alias numquam.','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(279,1,17,12,0,'2022-01-12','NO match',9.99,1129.91,'In sunt quibusdam sint beatae eos.','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(280,1,17,3,0,'2022-01-19','NO match',9.99,492.69,'Ut quisquam voluptatum eum omnis voluptas.','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(281,1,17,8,0,'2022-01-26','NO match',9.99,264.49,'Quae doloribus ut accusamus adipisci cupiditate.','2022-03-09 23:52:34','2022-03-09 23:52:34'),
(282,1,17,3,0,'2022-01-19','NO match',9.99,0.66,'Et voluptatem rerum voluptas et.','2022-03-09 23:52:34','2022-03-09 23:52:34');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `badges` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{}' COMMENT 'JSON object of routes with badges' CHECK (json_valid(`badges`)),
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'John Evans','john@grandadevans.com','{}','$2y$10$MlkmDy8pOXTE6sn5Ms.XFuJ0yTS/Mw9YMkt5CnSvqTTk.BvRwDOuu',NULL,NULL,'2022-03-09 23:52:13','2022-03-09 23:52:13'),
(2,'Elizabeth Richards','carlie.jackson@example.org','{}','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','2022-03-09 23:52:14','PRCdI7Chuz','2022-03-09 23:52:14','2022-03-09 23:52:14'),
(3,'Lily Allen','rogers.stephen@example.net','{}','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','2022-03-09 23:52:14','nZTBUSciV4','2022-03-09 23:52:14','2022-03-09 23:52:14'),
(4,'Candice Moore','smith.damien@example.org','{}','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','2022-03-09 23:52:14','SI5qNmgZkF','2022-03-09 23:52:14','2022-03-09 23:52:14'),
(5,'Bethany Davies','tgraham@example.com','{}','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','2022-03-09 23:52:14','o352gC9E7x','2022-03-09 23:52:14','2022-03-09 23:52:14'),
(6,'Peter Collins','wjames@example.com','{}','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','2022-03-09 23:52:14','PRMZ66qmEJ','2022-03-09 23:52:14','2022-03-09 23:52:14'),
(7,'John White','ruby.simpson@example.org','{}','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','2022-03-09 23:52:14','0hdGlSvttF','2022-03-09 23:52:14','2022-03-09 23:52:14'),
(8,'Daniel Khan','cook.mark@example.org','{}','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','2022-03-09 23:52:14','SPPyvvLfoE','2022-03-09 23:52:14','2022-03-09 23:52:14'),
(9,'Georgia Cooper','scott.connor@example.com','{}','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','2022-03-09 23:52:14','JKSTvQhcIu','2022-03-09 23:52:14','2022-03-09 23:52:14'),
(10,'Heather Saunders','mason.ellie@example.net','{}','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','2022-03-09 23:52:14','KelcQFEFGJ','2022-03-09 23:52:14','2022-03-09 23:52:14'),
(11,'Stacey Thomas','ellis.ryan@example.net','{}','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','2022-03-09 23:52:14','bKdFbsMXSL','2022-03-09 23:52:14','2022-03-09 23:52:14');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `websockets_statistics_entries`
--

DROP TABLE IF EXISTS `websockets_statistics_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `websockets_statistics_entries`
--

LOCK TABLES `websockets_statistics_entries` WRITE;
/*!40000 ALTER TABLE `websockets_statistics_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `websockets_statistics_entries` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-10  0:04:38
