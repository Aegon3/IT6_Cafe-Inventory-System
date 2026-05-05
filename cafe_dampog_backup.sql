-- MySQL dump 10.13  Distrib 8.0.43, for macos15 (x86_64)
--
-- Host: 127.0.0.1    Database: cafe_dampog
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

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
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `employee_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_Fname` varchar(100) NOT NULL,
  `employee_Lname` varchar(100) NOT NULL,
  `e_role` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`employee_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'John','Bogart','Admin','2026-04-23 10:51:29','2026-04-23 10:51:29'),(2,'Abing','Iskalambo','Staff','2026-04-23 10:51:29','2026-04-23 12:14:09'),(3,'Ampon','Gomla','Cashier','2026-04-23 10:51:29','2026-04-23 10:51:29'),(4,'Abing','Morong','Admin','2026-04-26 19:41:31','2026-04-26 19:41:31');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025_01_01_000001_create_employees_table',1),(2,'2025_01_01_000002_create_products_table',1),(3,'2025_01_01_000003_create_stocks_table',1),(4,'2025_01_01_000004_create_stock_ins_table',1),(5,'2025_01_01_000005_create_stock_outs_table',1),(8,'2025_01_01_000006_add_min_stock_to_stocks_table',2),(9,'2026_04_27_022705_add_min_stock_to_stocks_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `product_ID` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `p_unit` varchar(50) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`product_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES ('P001','Coffee Bean','kg',480.00,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('P002','Heavy Cream','L',240.00,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('P003','Butter','pack',280.00,'2026-04-23 10:51:29','2026-04-23 18:00:36'),('P004','Onion','kg',135.00,'2026-04-23 10:51:29','2026-04-23 18:01:27'),('P005','Garlic','kg',140.00,'2026-04-23 10:51:29','2026-04-23 18:01:10'),('P006','Chicken','kg',180.00,'2026-04-23 10:51:29','2026-04-23 18:00:08'),('P007','Potato','kg',145.00,'2026-04-23 10:51:29','2026-04-23 18:00:49'),('P008','Bread Loaf','pack',140.00,'2026-04-23 10:51:29','2026-04-23 18:00:18'),('P009','Fries','pack',120.00,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('P010','Chips','pack',150.00,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('P011','Sugar','kg',50.00,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('P012','Oil','L',250.00,'2026-04-23 10:51:29','2026-04-23 17:59:48'),('P013','Rice','kg',65.00,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('P014','Flour','kg',48.00,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('P015','Oyster Sauce','pcs',150.00,'2026-04-26 19:02:24','2026-04-26 19:02:24'),('P016','Coffee Bean','pcs',120.00,'2026-04-26 19:47:23','2026-04-26 19:47:23');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_in_details`
--

DROP TABLE IF EXISTS `stock_in_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_in_details` (
  `stockin_details_ID` varchar(50) NOT NULL,
  `stockin_ID` varchar(50) NOT NULL,
  `product_ID` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost_per_unit` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`stockin_details_ID`),
  KEY `stock_in_details_stockin_id_foreign` (`stockin_ID`),
  KEY `stock_in_details_product_id_foreign` (`product_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_in_details`
--

LOCK TABLES `stock_in_details` WRITE;
/*!40000 ALTER TABLE `stock_in_details` DISABLE KEYS */;
INSERT INTO `stock_in_details` VALUES ('SID0002','SI0002','P010',20,150.00,'2026-04-23 12:12:26','2026-04-23 12:12:26'),('SID0003','SI0003','P003',20,280.00,'2026-04-26 18:39:21','2026-04-26 18:39:21'),('SID0004','SI0004','P010',20,150.00,'2026-04-26 19:43:16','2026-04-26 19:43:16'),('SID0005','SI0005','P003',20,280.00,'2026-04-26 19:44:19','2026-04-26 19:44:19'),('SID0006','SI0005','P001',20,480.00,'2026-04-26 19:44:19','2026-04-26 19:44:19'),('SID0007','SI0005','P006',20,180.00,'2026-04-26 19:44:19','2026-04-26 19:44:19');
/*!40000 ALTER TABLE `stock_in_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_ins`
--

DROP TABLE IF EXISTS `stock_ins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_ins` (
  `stockin_ID` varchar(50) NOT NULL,
  `date_added` date NOT NULL,
  `employee_ID` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`stockin_ID`),
  KEY `stock_ins_employee_id_foreign` (`employee_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_ins`
--

LOCK TABLES `stock_ins` WRITE;
/*!40000 ALTER TABLE `stock_ins` DISABLE KEYS */;
INSERT INTO `stock_ins` VALUES ('SI0002','2026-04-23','E001','2026-04-23 12:12:26','2026-04-23 12:12:26'),('SI0003','2026-04-27','E002','2026-04-26 18:39:21','2026-04-26 18:39:21'),('SI0004','2026-04-27','E002','2026-04-26 19:43:16','2026-04-26 19:43:16'),('SI0005','2026-04-27','E005','2026-04-26 19:44:19','2026-04-26 19:44:19');
/*!40000 ALTER TABLE `stock_ins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_out_details`
--

DROP TABLE IF EXISTS `stock_out_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_out_details` (
  `stockout_details_ID` varchar(50) NOT NULL,
  `stockout_ID` varchar(50) NOT NULL,
  `product_ID` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`stockout_details_ID`),
  KEY `stock_out_details_stockout_id_foreign` (`stockout_ID`),
  KEY `stock_out_details_product_id_foreign` (`product_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_out_details`
--

LOCK TABLES `stock_out_details` WRITE;
/*!40000 ALTER TABLE `stock_out_details` DISABLE KEYS */;
INSERT INTO `stock_out_details` VALUES ('SOD0001','SO0001','P001',20,'2026-04-23 10:59:17','2026-04-23 10:59:17'),('SOD0002','SO0002','P014',40,'2026-04-26 18:35:49','2026-04-26 18:35:49'),('SOD0003','SO0003','P014',20,'2026-04-26 18:39:38','2026-04-26 18:39:38');
/*!40000 ALTER TABLE `stock_out_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_outs`
--

DROP TABLE IF EXISTS `stock_outs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_outs` (
  `stockout_ID` varchar(50) NOT NULL,
  `date_issuance` date NOT NULL,
  `employee_ID` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`stockout_ID`),
  KEY `stock_outs_employee_id_foreign` (`employee_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_outs`
--

LOCK TABLES `stock_outs` WRITE;
/*!40000 ALTER TABLE `stock_outs` DISABLE KEYS */;
INSERT INTO `stock_outs` VALUES ('SO0001','2026-04-23','E003','2026-04-23 10:59:17','2026-04-23 10:59:17'),('SO0002','2026-04-27','E002','2026-04-26 18:35:49','2026-04-26 18:35:49'),('SO0003','2026-04-27','E002','2026-04-26 18:39:38','2026-04-26 18:39:38');
/*!40000 ALTER TABLE `stock_outs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stocks` (
  `stock_ID` varchar(50) NOT NULL,
  `product_ID` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `min_stock` int(11) NOT NULL DEFAULT 20,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`stock_ID`),
  KEY `stocks_product_id_foreign` (`product_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES ('ST001','P001',40,20,'2026-04-23 10:51:29','2026-04-26 19:44:19'),('ST002','P002',30,20,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('ST003','P003',80,20,'2026-04-23 10:51:29','2026-04-26 19:44:19'),('ST004','P004',100,20,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('ST005','P005',80,20,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('ST006','P006',80,20,'2026-04-23 10:51:29','2026-04-26 19:44:19'),('ST007','P007',120,20,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('ST008','P008',25,20,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('ST009','P009',45,20,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('ST010','P010',110,20,'2026-04-23 10:51:29','2026-04-26 19:43:16'),('ST011','P011',55,20,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('ST012','P012',35,20,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('ST013','P013',90,20,'2026-04-23 10:51:29','2026-04-23 10:51:29'),('ST014','P014',5,20,'2026-04-23 10:51:29','2026-04-26 18:39:38'),('ST015','P015',0,20,'2026-04-26 19:02:24','2026-04-26 19:02:24'),('ST016','P016',0,20,'2026-04-26 19:47:23','2026-04-26 19:47:23');
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-27 19:18:42
