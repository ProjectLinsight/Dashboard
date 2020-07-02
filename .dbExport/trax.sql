-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2020 at 07:25 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trax`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2018_01_01_000001_trax_datastore_create_data_table', 1),
(2, '2018_01_01_001001_trax_account_create_entities_table', 1),
(3, '2018_01_01_001002_trax_account_create_roles_table', 1),
(4, '2018_01_01_001003_trax_account_create_users_table', 1),
(5, '2018_01_01_001004_trax_account_create_password_resets_table', 1),
(6, '2018_01_01_001005_trax_account_create_sessions_table', 1),
(7, '2018_01_01_001006_trax_account_create_groups_table', 1),
(8, '2018_01_01_001007_trax_account_create_group_user_table', 1),
(9, '2018_01_01_001008_trax_account_create_basic_clients_table', 1),
(10, '2018_01_01_001009_trax_account_create_agreements_table', 1),
(11, '2018_01_01_001010_trax_account_create_agreement_user_table', 1),
(12, '2018_01_01_002001_trax_notification_create_notification_table', 1),
(13, '2018_01_01_002001_trax_xapiserver_create_statements_table', 1),
(14, '2018_01_01_002002_trax_notification_create_notification_user_table', 1),
(15, '2018_01_01_002002_trax_xapiserver_create_attachments_table', 1),
(16, '2018_01_01_002003_trax_xapiserver_create_states_table', 1),
(17, '2018_01_01_002004_trax_xapiserver_create_activity_profiles_table', 1),
(18, '2018_01_01_002005_trax_xapiserver_create_agent_profiles_table', 1),
(19, '2018_01_01_002006_trax_xapiserver_create_activities_table', 1),
(20, '2018_01_01_002007_trax_xapiserver_create_agents_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `trax_account_agreements`
--

CREATE TABLE `trax_account_agreements` (
  `id` int(10) UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trax_account_agreement_user`
--

CREATE TABLE `trax_account_agreement_user` (
  `agreement_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trax_account_basic_clients`
--

CREATE TABLE `trax_account_basic_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trax_account_basic_clients`
--

INSERT INTO `trax_account_basic_clients` (`id`, `username`, `password`, `data`, `created_at`, `updated_at`) VALUES
(1, '56b853c4-24f3-40aa-938f-37076e12e073', 'dca59ca6-473f-4b0b-9250-174d02c64e00', '{\"name\": \"Linsight\"}', '2020-05-15 07:38:03', '2020-05-15 07:38:03');

-- --------------------------------------------------------

--
-- Table structure for table `trax_account_entities`
--

CREATE TABLE `trax_account_entities` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `index_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trax_account_group_user`
--

CREATE TABLE `trax_account_group_user` (
  `group_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trax_account_password_resets`
--

CREATE TABLE `trax_account_password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trax_account_sessions`
--

CREATE TABLE `trax_account_sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trax_account_sessions`
--

INSERT INTO `trax_account_sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7xiUbNXL9P3MYPsgHesyBs8DDIystCk6veeDM6He', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidHpDaUN0T1JvRnd5eEZiV3V2M2lRSFhHajNwaXZFWHVUaGZ1VkxVTSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjYyOiJodHRwOi8vbG9jYWxob3N0L3RyYXhscnMvcHVibGljL3RyYXgvdWkveGFwaS1zZXJ2ZXIvc3RhdGVtZW50cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1592635007),
('7xiUbNXL9P3MYPsgHesyBs8DDIystCk6veeDM6He', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidHpDaUN0T1JvRnd5eEZiV3V2M2lRSFhHajNwaXZFWHVUaGZ1VkxVTSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjYyOiJodHRwOi8vbG9jYWxob3N0L3RyYXhscnMvcHVibGljL3RyYXgvdWkveGFwaS1zZXJ2ZXIvc3RhdGVtZW50cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1592635007);

-- --------------------------------------------------------

--
-- Table structure for table `trax_datastore_data`
--

CREATE TABLE `trax_datastore_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trax_notification`
--

CREATE TABLE `trax_notification` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trax_notification_user`
--

CREATE TABLE `trax_notification_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `notification_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trax_xapiserver_activities`
--

CREATE TABLE `trax_xapiserver_activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trax_xapiserver_activities`
--

INSERT INTO `trax_xapiserver_activities` (`id`, `data`, `created_at`, `updated_at`) VALUES
(1, '{\"id\": \"http://localhost/moodle/xapi/activities/course/e938a5c3-3c81-45ec-8eeb-a115afcf9a1b\", \"definition\": {\"name\": {\"en\": \"vle \"}, \"type\": \"http://vocab.xapi.fr/activities/course\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-concept\": \"course\"}, \"description\": {\"en\": \"Moodle powered by Bitnami\"}}, \"objectType\": \"Activity\"}', '2020-05-15 07:42:34', '2020-06-18 06:17:33'),
(2, '{\"id\": \"http://localhost/moodle\", \"definition\": {\"name\": {\"en\": \"vle \"}, \"type\": \"http://vocab.xapi.fr/activities/system\", \"description\": {\"en\": \"Moodle powered by Bitnami\"}}, \"objectType\": \"Activity\"}', '2020-05-15 07:51:33', '2020-06-18 23:54:34'),
(3, '{\"id\": \"http://localhost/moodle/xapi/activities/course/10294ff1-edf5-4037-89f2-1ffe246f8c65\", \"definition\": {\"name\": {\"en\": \"SCS1001\"}, \"type\": \"http://vocab.xapi.fr/activities/course\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-concept\": \"course\"}, \"description\": {\"en\": \"Test course 1\\r\\nLorem ipsum dolor sit amet, consectetuer adipiscing elit. Nulla non arcu lacinia neque faucibus fringilla. Vivamus porttitor turpis ac leo. Integer in sapien. Nullam eget nisl. Aliquam erat volutpat. Cras elementum. Mauris suscipit, ligula sit amet pharetra semper, nibh ante cursus purus, vel sagittis velit mauris vel metus. Integer malesuada. Nullam lectus justo, vulputate eget mollis sed, tempor sed magna. Mauris elementum mauris vitae tortor. Aliquam erat volutpat.\\r\\n\"}}, \"objectType\": \"Activity\"}', '2020-05-15 07:57:30', '2020-06-18 06:16:21'),
(4, '{\"id\": \"http://localhost/moodle/xapi/activities/assign/cab9d8ea-b464-4c49-93c4-2b079fbf770d\", \"definition\": {\"name\": {\"en\": \"Assignment 5\"}, \"type\": \"http://vocab.xapi.fr/activities/assignment\", \"extensions\": {\"http://vocab.xapi.fr/extensions/concept-family\": \"production\", \"http://vocab.xapi.fr/extensions/platform-concept\": \"assign\"}, \"description\": {\"en\": \"Test assign 5\"}}, \"objectType\": \"Activity\"}', '2020-05-18 05:27:04', '2020-05-18 05:27:04'),
(5, '{\"id\": \"http://example.com/button_example\", \"definition\": {\"name\": {\"en-US\": \"Course: SCS3201 / IS3117 / CS3120 Machine Learning and Neural Computing\"}, \"description\": {\"en-US\": \"Course: SCS3201 / IS3117 / CS3120 Machine Learning and Neural Computing\"}}, \"objectType\": \"Activity\"}', '2020-05-19 04:31:27', '2020-06-20 01:06:32'),
(6, '{\"id\": \"http://localhost/moodle/xapi/activities/assign/ac36db65-2949-4fec-8f38-39e1c5ed2bf5\", \"definition\": {\"name\": {\"en\": \"Assignment 1\"}, \"type\": \"http://vocab.xapi.fr/activities/assignment\", \"extensions\": {\"http://vocab.xapi.fr/extensions/concept-family\": \"production\", \"http://vocab.xapi.fr/extensions/platform-concept\": \"assign\"}, \"description\": {\"en\": \"Test assign 1\"}}, \"objectType\": \"Activity\"}', '2020-06-18 05:16:50', '2020-06-18 05:16:50'),
(7, '{\"id\": \"http://localhost/moodle/xapi/activities/resource/ff863cca-36cb-4195-b313-0d995611cf99\", \"definition\": {\"name\": {\"en\": \"Big file 1\"}, \"type\": \"http://adlnet.gov/expapi/activities/file\", \"extensions\": {\"http://vocab.xapi.fr/extensions/concept-family\": \"resource\", \"http://vocab.xapi.fr/extensions/platform-concept\": \"resource\"}, \"description\": {\"en\": \"Test resource 3\"}}, \"objectType\": \"Activity\"}', '2020-06-18 05:17:01', '2020-06-18 05:17:01'),
(1, '{\"id\": \"http://localhost/moodle/xapi/activities/course/e938a5c3-3c81-45ec-8eeb-a115afcf9a1b\", \"definition\": {\"name\": {\"en\": \"vle \"}, \"type\": \"http://vocab.xapi.fr/activities/course\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-concept\": \"course\"}, \"description\": {\"en\": \"Moodle powered by Bitnami\"}}, \"objectType\": \"Activity\"}', '2020-05-15 07:42:34', '2020-06-18 06:17:33'),
(2, '{\"id\": \"http://localhost/moodle\", \"definition\": {\"name\": {\"en\": \"vle \"}, \"type\": \"http://vocab.xapi.fr/activities/system\", \"description\": {\"en\": \"Moodle powered by Bitnami\"}}, \"objectType\": \"Activity\"}', '2020-05-15 07:51:33', '2020-06-18 23:54:34'),
(3, '{\"id\": \"http://localhost/moodle/xapi/activities/course/10294ff1-edf5-4037-89f2-1ffe246f8c65\", \"definition\": {\"name\": {\"en\": \"SCS1001\"}, \"type\": \"http://vocab.xapi.fr/activities/course\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-concept\": \"course\"}, \"description\": {\"en\": \"Test course 1\\r\\nLorem ipsum dolor sit amet, consectetuer adipiscing elit. Nulla non arcu lacinia neque faucibus fringilla. Vivamus porttitor turpis ac leo. Integer in sapien. Nullam eget nisl. Aliquam erat volutpat. Cras elementum. Mauris suscipit, ligula sit amet pharetra semper, nibh ante cursus purus, vel sagittis velit mauris vel metus. Integer malesuada. Nullam lectus justo, vulputate eget mollis sed, tempor sed magna. Mauris elementum mauris vitae tortor. Aliquam erat volutpat.\\r\\n\"}}, \"objectType\": \"Activity\"}', '2020-05-15 07:57:30', '2020-06-18 06:16:21'),
(4, '{\"id\": \"http://localhost/moodle/xapi/activities/assign/cab9d8ea-b464-4c49-93c4-2b079fbf770d\", \"definition\": {\"name\": {\"en\": \"Assignment 5\"}, \"type\": \"http://vocab.xapi.fr/activities/assignment\", \"extensions\": {\"http://vocab.xapi.fr/extensions/concept-family\": \"production\", \"http://vocab.xapi.fr/extensions/platform-concept\": \"assign\"}, \"description\": {\"en\": \"Test assign 5\"}}, \"objectType\": \"Activity\"}', '2020-05-18 05:27:04', '2020-05-18 05:27:04'),
(5, '{\"id\": \"http://example.com/button_example\", \"definition\": {\"name\": {\"en-US\": \"Course: SCS3201 / IS3117 / CS3120 Machine Learning and Neural Computing\"}, \"description\": {\"en-US\": \"Course: SCS3201 / IS3117 / CS3120 Machine Learning and Neural Computing\"}}, \"objectType\": \"Activity\"}', '2020-05-19 04:31:27', '2020-06-20 01:06:32'),
(6, '{\"id\": \"http://localhost/moodle/xapi/activities/assign/ac36db65-2949-4fec-8f38-39e1c5ed2bf5\", \"definition\": {\"name\": {\"en\": \"Assignment 1\"}, \"type\": \"http://vocab.xapi.fr/activities/assignment\", \"extensions\": {\"http://vocab.xapi.fr/extensions/concept-family\": \"production\", \"http://vocab.xapi.fr/extensions/platform-concept\": \"assign\"}, \"description\": {\"en\": \"Test assign 1\"}}, \"objectType\": \"Activity\"}', '2020-06-18 05:16:50', '2020-06-18 05:16:50'),
(7, '{\"id\": \"http://localhost/moodle/xapi/activities/resource/ff863cca-36cb-4195-b313-0d995611cf99\", \"definition\": {\"name\": {\"en\": \"Big file 1\"}, \"type\": \"http://adlnet.gov/expapi/activities/file\", \"extensions\": {\"http://vocab.xapi.fr/extensions/concept-family\": \"resource\", \"http://vocab.xapi.fr/extensions/platform-concept\": \"resource\"}, \"description\": {\"en\": \"Test resource 3\"}}, \"objectType\": \"Activity\"}', '2020-06-18 05:17:01', '2020-06-18 05:17:01');

-- --------------------------------------------------------

--
-- Table structure for table `trax_xapiserver_activity_profiles`
--

CREATE TABLE `trax_xapiserver_activity_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trax_xapiserver_agents`
--

CREATE TABLE `trax_xapiserver_agents` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trax_xapiserver_agents`
--

INSERT INTO `trax_xapiserver_agents` (`id`, `data`, `created_at`, `updated_at`) VALUES
(1, '{\"name\": \"Admin User\", \"account\": {\"name\": \"gaganaw06\", \"homePage\": \"http://localhost/moodle\"}, \"objectType\": \"Agent\"}', '2020-05-15 07:42:34', '2020-06-18 23:54:34'),
(2, '{\"name\": \"Amaya Herath\", \"account\": {\"name\": \"amaya\", \"homePage\": \"http://localhost/moodle\"}, \"objectType\": \"Agent\"}', '2020-05-15 07:57:24', '2020-06-18 05:45:34'),
(3, '{\"mbox\": \"mailto:Tester@example.com\", \"name\": \"2017cs192\\n        \", \"objectType\": \"Agent\"}', '2020-05-19 04:31:27', '2020-05-29 01:10:44'),
(4, '{\"name\": \"2017cs192\\n        \", \"account\": {\"name\": \"2017cs192\\n        \", \"homePage\": \"https://dev.to/chintukarthi/how-to-save-values-in-chrome-local-storage-kmc\"}, \"objectType\": \"Agent\"}', '2020-05-29 00:08:38', '2020-05-29 00:08:38'),
(5, '{\"name\": \"2017cs192\\n        \", \"account\": {\"name\": \"2017cs192\\n        \", \"homePage\": \"http://localhost/traxlrs/public/trax/ui/xapi-server/statements\"}, \"objectType\": \"Agent\"}', '2020-05-29 00:09:03', '2020-05-29 00:09:57'),
(6, '{\"name\": \"2017cs192\\n        \", \"account\": {\"name\": \"2017cs192\\n        \", \"homePage\": \"https://xapi.com/statements-101/?utm_source=google&utm_medium=natural_search\"}, \"objectType\": \"Agent\"}', '2020-05-29 00:09:52', '2020-05-29 00:09:52'),
(7, '{\"name\": \"2017cs192\\n        \", \"account\": {\"name\": \"2017cs192\\n        \", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}', '2020-05-29 00:12:37', '2020-05-29 00:42:05'),
(8, '{\"name\": \"\\n        2017cs192\", \"account\": {\"name\": \"\\n        2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}', '2020-05-29 00:42:38', '2020-05-29 00:42:38'),
(9, '{\"name\": \"2017cs192\", \"account\": {\"name\": \"2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}', '2020-05-29 00:43:09', '2020-06-20 01:06:32'),
(10, '{\"mbox\": \"mailto:gaganaw06@gmail.com\", \"name\": \"Admin User\", \"objectType\": \"Agent\"}', '2020-06-18 06:16:12', '2020-06-18 06:16:21'),
(1, '{\"name\": \"Admin User\", \"account\": {\"name\": \"gaganaw06\", \"homePage\": \"http://localhost/moodle\"}, \"objectType\": \"Agent\"}', '2020-05-15 07:42:34', '2020-06-18 23:54:34'),
(2, '{\"name\": \"Amaya Herath\", \"account\": {\"name\": \"amaya\", \"homePage\": \"http://localhost/moodle\"}, \"objectType\": \"Agent\"}', '2020-05-15 07:57:24', '2020-06-18 05:45:34'),
(3, '{\"mbox\": \"mailto:Tester@example.com\", \"name\": \"2017cs192\\n        \", \"objectType\": \"Agent\"}', '2020-05-19 04:31:27', '2020-05-29 01:10:44'),
(4, '{\"name\": \"2017cs192\\n        \", \"account\": {\"name\": \"2017cs192\\n        \", \"homePage\": \"https://dev.to/chintukarthi/how-to-save-values-in-chrome-local-storage-kmc\"}, \"objectType\": \"Agent\"}', '2020-05-29 00:08:38', '2020-05-29 00:08:38'),
(5, '{\"name\": \"2017cs192\\n        \", \"account\": {\"name\": \"2017cs192\\n        \", \"homePage\": \"http://localhost/traxlrs/public/trax/ui/xapi-server/statements\"}, \"objectType\": \"Agent\"}', '2020-05-29 00:09:03', '2020-05-29 00:09:57'),
(6, '{\"name\": \"2017cs192\\n        \", \"account\": {\"name\": \"2017cs192\\n        \", \"homePage\": \"https://xapi.com/statements-101/?utm_source=google&utm_medium=natural_search\"}, \"objectType\": \"Agent\"}', '2020-05-29 00:09:52', '2020-05-29 00:09:52'),
(7, '{\"name\": \"2017cs192\\n        \", \"account\": {\"name\": \"2017cs192\\n        \", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}', '2020-05-29 00:12:37', '2020-05-29 00:42:05'),
(8, '{\"name\": \"\\n        2017cs192\", \"account\": {\"name\": \"\\n        2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}', '2020-05-29 00:42:38', '2020-05-29 00:42:38'),
(9, '{\"name\": \"2017cs192\", \"account\": {\"name\": \"2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}', '2020-05-29 00:43:09', '2020-06-20 01:06:32'),
(10, '{\"mbox\": \"mailto:gaganaw06@gmail.com\", \"name\": \"Admin User\", \"objectType\": \"Agent\"}', '2020-06-18 06:16:12', '2020-06-18 06:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `trax_xapiserver_agent_profiles`
--

CREATE TABLE `trax_xapiserver_agent_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trax_xapiserver_attachments`
--

CREATE TABLE `trax_xapiserver_attachments` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trax_xapiserver_statements`
--

CREATE TABLE `trax_xapiserver_statements` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `voided` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trax_xapiserver_statements`
--

INSERT INTO `trax_xapiserver_statements` (`id`, `data`, `voided`, `created_at`, `updated_at`) VALUES
(1, '{\"id\": \"72b4c5f6-cb8f-3a87-bc36-9e76df42dddc\", \"verb\": {\"id\": \"http://vocab.xapi.fr/verbs/navigated-in\"}, \"actor\": {\"name\": \"Admin User\", \"account\": {\"name\": \"gaganaw06\", \"homePage\": \"http://localhost/moodle\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://localhost/moodle/xapi/activities/course/e938a5c3-3c81-45ec-8eeb-a115afcf9a1b\", \"definition\": {\"name\": {\"en\": \"vle \"}, \"type\": \"http://vocab.xapi.fr/activities/course\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-concept\": \"course\"}, \"description\": {\"en\": \"Moodle powered by Bitnami\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-05-15T13:12:34.9201Z\", \"context\": {\"platform\": \"Moodle\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-event\": \"\\\\core\\\\event\\\\course_viewed\"}, \"contextActivities\": {\"category\": [{\"id\": \"http://vocab.xapi.fr/categories/vle-profile\", \"definition\": {\"type\": \"http://adlnet.gov/expapi/activities/profile\"}}], \"grouping\": [{\"id\": \"http://localhost/moodle\", \"definition\": {\"type\": \"http://vocab.xapi.fr/activities/system\"}}]}}, \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-05-15T14:12:34+01:00\"}', 0, '2020-05-15 07:42:34', '2020-05-15 07:42:34'),
(2, '{\"id\": \"745c7a6f-f6cb-3773-b07f-8b78f3048d16\", \"verb\": {\"id\": \"https://w3id.org/xapi/adl/verbs/logged-in\"}, \"actor\": {\"name\": \"Admin User\", \"account\": {\"name\": \"gaganaw06\", \"homePage\": \"http://localhost/moodle\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://localhost/moodle\", \"definition\": {\"name\": {\"en\": \"vle \"}, \"type\": \"http://vocab.xapi.fr/activities/system\", \"description\": {\"en\": \"Moodle powered by Bitnami\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-05-15T13:21:33.1453Z\", \"context\": {\"platform\": \"Moodle\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-event\": \"\\\\core\\\\event\\\\user_loggedin\"}, \"contextActivities\": {\"category\": [{\"id\": \"http://vocab.xapi.fr/categories/vle-profile\", \"definition\": {\"type\": \"http://adlnet.gov/expapi/activities/profile\"}}]}}, \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-05-15T14:21:33+01:00\"}', 0, '2020-05-15 07:51:33', '2020-05-15 07:51:33'),
(3, '{\"id\": \"1382794a-d4d8-3dc3-b936-b47261ca7e8d\", \"verb\": {\"id\": \"https://w3id.org/xapi/adl/verbs/logged-in\"}, \"actor\": {\"name\": \"Amaya Herath\", \"account\": {\"name\": \"amaya\", \"homePage\": \"http://localhost/moodle\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://localhost/moodle\", \"definition\": {\"name\": {\"en\": \"vle \"}, \"type\": \"http://vocab.xapi.fr/activities/system\", \"description\": {\"en\": \"Moodle powered by Bitnami\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-05-15T13:27:24.1489Z\", \"context\": {\"platform\": \"Moodle\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-event\": \"\\\\core\\\\event\\\\user_loggedin\"}, \"contextActivities\": {\"category\": [{\"id\": \"http://vocab.xapi.fr/categories/vle-profile\", \"definition\": {\"type\": \"http://adlnet.gov/expapi/activities/profile\"}}]}}, \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-05-15T14:27:24+01:00\"}', 0, '2020-05-15 07:57:24', '2020-05-15 07:57:24'),
(4, '{\"id\": \"27f12c52-1e8c-374f-b2d6-99eb44e4792f\", \"verb\": {\"id\": \"http://vocab.xapi.fr/verbs/navigated-in\"}, \"actor\": {\"name\": \"Amaya Herath\", \"account\": {\"name\": \"amaya\", \"homePage\": \"http://localhost/moodle\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://localhost/moodle/xapi/activities/course/10294ff1-edf5-4037-89f2-1ffe246f8c65\", \"definition\": {\"name\": {\"en\": \"SCS1001\"}, \"type\": \"http://vocab.xapi.fr/activities/course\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-concept\": \"course\"}, \"description\": {\"en\": \"Test course 1\\r\\nLorem ipsum dolor sit amet, consectetuer adipiscing elit. Nulla non arcu lacinia neque faucibus fringilla. Vivamus porttitor turpis ac leo. Integer in sapien. Nullam eget nisl. Aliquam erat volutpat. Cras elementum. Mauris suscipit, ligula sit amet pharetra semper, nibh ante cursus purus, vel sagittis velit mauris vel metus. Integer malesuada. Nullam lectus justo, vulputate eget mollis sed, tempor sed magna. Mauris elementum mauris vitae tortor. Aliquam erat volutpat.\\r\\n\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-05-15T13:27:29.9988Z\", \"context\": {\"platform\": \"Moodle\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-event\": \"\\\\core\\\\event\\\\course_viewed\"}, \"contextActivities\": {\"category\": [{\"id\": \"http://vocab.xapi.fr/categories/vle-profile\", \"definition\": {\"type\": \"http://adlnet.gov/expapi/activities/profile\"}}], \"grouping\": [{\"id\": \"http://localhost/moodle\", \"definition\": {\"type\": \"http://vocab.xapi.fr/activities/system\"}}]}}, \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-05-15T14:27:29+01:00\"}', 0, '2020-05-15 07:57:29', '2020-05-15 07:57:29'),
(5, '{\"id\": \"a9ff191e-f0ad-3e6f-b86d-b9a9bcf545cf\", \"verb\": {\"id\": \"https://w3id.org/xapi/adl/verbs/logged-in\"}, \"actor\": {\"name\": \"Admin User\", \"account\": {\"name\": \"gaganaw06\", \"homePage\": \"http://localhost/moodle\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://localhost/moodle\", \"definition\": {\"name\": {\"en\": \"vle \"}, \"type\": \"http://vocab.xapi.fr/activities/system\", \"description\": {\"en\": \"Moodle powered by Bitnami\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-05-15T13:32:04.6362Z\", \"context\": {\"platform\": \"Moodle\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-event\": \"\\\\core\\\\event\\\\user_loggedin\"}, \"contextActivities\": {\"category\": [{\"id\": \"http://vocab.xapi.fr/categories/vle-profile\", \"definition\": {\"type\": \"http://adlnet.gov/expapi/activities/profile\"}}]}}, \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-05-15T14:32:04+01:00\"}', 0, '2020-05-15 08:02:04', '2020-05-15 08:02:04'),
(6, '{\"id\": \"10827260-3b87-3dc9-a99c-c9a40982635a\", \"verb\": {\"id\": \"https://w3id.org/xapi/adl/verbs/logged-in\"}, \"actor\": {\"name\": \"Admin User\", \"account\": {\"name\": \"gaganaw06\", \"homePage\": \"http://localhost/moodle\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://localhost/moodle\", \"definition\": {\"name\": {\"en\": \"vle \"}, \"type\": \"http://vocab.xapi.fr/activities/system\", \"description\": {\"en\": \"Moodle powered by Bitnami\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-05-18T04:00:03.2272Z\", \"context\": {\"platform\": \"Moodle\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-event\": \"\\\\core\\\\event\\\\user_loggedin\"}, \"contextActivities\": {\"category\": [{\"id\": \"http://vocab.xapi.fr/categories/vle-profile\", \"definition\": {\"type\": \"http://adlnet.gov/expapi/activities/profile\"}}]}}, \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-05-18T05:00:02+01:00\"}', 0, '2020-05-17 22:30:03', '2020-05-17 22:30:03'),
(7, '{\"id\": \"eb268b5c-538b-33d9-ac23-ba810132f0da\", \"verb\": {\"id\": \"https://w3id.org/xapi/adl/verbs/logged-in\"}, \"actor\": {\"name\": \"Admin User\", \"account\": {\"name\": \"gaganaw06\", \"homePage\": \"http://localhost/moodle\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://localhost/moodle\", \"definition\": {\"name\": {\"en\": \"vle \"}, \"type\": \"http://vocab.xapi.fr/activities/system\", \"description\": {\"en\": \"Moodle powered by Bitnami\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-05-18T10:56:25.0543Z\", \"context\": {\"platform\": \"Moodle\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-event\": \"\\\\core\\\\event\\\\user_loggedin\"}, \"contextActivities\": {\"category\": [{\"id\": \"http://vocab.xapi.fr/categories/vle-profile\", \"definition\": {\"type\": \"http://adlnet.gov/expapi/activities/profile\"}}]}}, \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-05-18T11:56:24+01:00\"}', 0, '2020-05-18 05:26:25', '2020-05-18 05:26:25'),
(8, '{\"id\": \"8aa8b4e5-6a0a-3028-81cd-2769ea0f2499\", \"verb\": {\"id\": \"http://vocab.xapi.fr/verbs/navigated-in\"}, \"actor\": {\"name\": \"Admin User\", \"account\": {\"name\": \"gaganaw06\", \"homePage\": \"http://localhost/moodle\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://localhost/moodle/xapi/activities/course/e938a5c3-3c81-45ec-8eeb-a115afcf9a1b\", \"definition\": {\"name\": {\"en\": \"vle \"}, \"type\": \"http://vocab.xapi.fr/activities/course\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-concept\": \"course\"}, \"description\": {\"en\": \"Moodle powered by Bitnami\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-05-18T10:56:44.2788Z\", \"context\": {\"platform\": \"Moodle\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-event\": \"\\\\core\\\\event\\\\course_viewed\"}, \"contextActivities\": {\"category\": [{\"id\": \"http://vocab.xapi.fr/categories/vle-profile\", \"definition\": {\"type\": \"http://adlnet.gov/expapi/activities/profile\"}}], \"grouping\": [{\"id\": \"http://localhost/moodle\", \"definition\": {\"type\": \"http://vocab.xapi.fr/activities/system\"}}]}}, \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-05-18T11:56:43+01:00\"}', 0, '2020-05-18 05:26:44', '2020-05-18 05:26:44'),
(9, '{\"id\": \"6ada8945-4d40-313b-9938-fc3381c19686\", \"verb\": {\"id\": \"http://vocab.xapi.fr/verbs/navigated-in\"}, \"actor\": {\"name\": \"Admin User\", \"account\": {\"name\": \"gaganaw06\", \"homePage\": \"http://localhost/moodle\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://localhost/moodle/xapi/activities/course/10294ff1-edf5-4037-89f2-1ffe246f8c65\", \"definition\": {\"name\": {\"en\": \"SCS1001\"}, \"type\": \"http://vocab.xapi.fr/activities/course\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-concept\": \"course\"}, \"description\": {\"en\": \"Test course 1\\r\\nLorem ipsum dolor sit amet, consectetuer adipiscing elit. Nulla non arcu lacinia neque faucibus fringilla. Vivamus porttitor turpis ac leo. Integer in sapien. Nullam eget nisl. Aliquam erat volutpat. Cras elementum. Mauris suscipit, ligula sit amet pharetra semper, nibh ante cursus purus, vel sagittis velit mauris vel metus. Integer malesuada. Nullam lectus justo, vulputate eget mollis sed, tempor sed magna. Mauris elementum mauris vitae tortor. Aliquam erat volutpat.\\r\\n\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-05-18T10:56:46.1273Z\", \"context\": {\"platform\": \"Moodle\", \"extensions\": {\"http://vocab.xapi.fr/extensions/platform-event\": \"\\\\core\\\\event\\\\course_viewed\"}, \"contextActivities\": {\"category\": [{\"id\": \"http://vocab.xapi.fr/categories/vle-profile\", \"definition\": {\"type\": \"http://adlnet.gov/expapi/activities/profile\"}}], \"grouping\": [{\"id\": \"http://localhost/moodle\", \"definition\": {\"type\": \"http://vocab.xapi.fr/activities/system\"}}]}}, \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-05-18T11:56:46+01:00\"}', 0, '2020-05-18 05:26:46', '2020-05-18 05:26:46'),
(486, '{\"id\": \"026ee241-84e3-45b5-9ceb-74aea00b8b17\", \"verb\": {\"id\": \"http://example.com/xapi/visited\", \"display\": {\"en\": \"Visited\"}}, \"actor\": {\"name\": \"2017cs192\", \"account\": {\"name\": \"2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://example.com/button_example\", \"definition\": {\"name\": {\"en\": \"Course: SCS3216 / IS3110 Research Methods\"}, \"description\": {\"en\": \"https://ugvle.ucsc.cmb.ac.lk/course/view.php?id=362\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-06-24T09:44:55.5874Z\", \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-06-24T09:44:55.5874Z\"}', 0, '2020-06-24 04:14:55', '2020-06-24 04:14:55'),
(487, '{\"id\": \"e0fb42d8-f845-4939-bcfe-b91fb06046f1\", \"verb\": {\"id\": \"http://example.com/xapi/visited\", \"display\": {\"en\": \"Visited\"}}, \"actor\": {\"name\": \"2017cs192\", \"account\": {\"name\": \"2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://example.com/button_example\", \"definition\": {\"name\": {\"en\": \"TRAX LRS / Statements\"}, \"description\": {\"en\": \"http://localhost/traxlrs/public/trax/ui/xapi-server/statements\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-06-24T09:45:02.1193Z\", \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-06-24T09:45:02.1193Z\"}', 0, '2020-06-24 04:15:02', '2020-06-24 04:15:02'),
(488, '{\"id\": \"80281e6c-80a1-448a-94a5-bede248bd29a\", \"verb\": {\"id\": \"http://example.com/xapi/visited\", \"display\": {\"en\": \"Visited\"}}, \"actor\": {\"name\": \"2017cs192\", \"account\": {\"name\": \"2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://example.com/button_example\", \"definition\": {\"name\": {\"en\": \"Cognito Forms\"}, \"description\": {\"en\": \"https://www.cognitoforms.com/MrOCVTennakoon/SurveyForTheFacilitateAudioAndVideoTeachingAndLearningSupportMaterialsForUndergraduateOfUCSC\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-06-24T09:45:10.9733Z\", \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-06-24T09:45:10.9733Z\"}', 0, '2020-06-24 04:15:10', '2020-06-24 04:15:10'),
(489, '{\"id\": \"4f10d020-b88b-4e17-822c-3ec6622d89ee\", \"verb\": {\"id\": \"http://example.com/xapi/visited\", \"display\": {\"en\": \"Visited\"}}, \"actor\": {\"name\": \"2017cs192\", \"account\": {\"name\": \"2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://example.com/button_example\", \"definition\": {\"name\": {\"en\": \"php - Why all queries written in controller file instead of model in laravel - Stack Overflow\"}, \"description\": {\"en\": \"https://stackoverflow.com/questions/49641222/why-all-queries-written-in-controller-file-instead-of-model-in-laravel\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-06-24T09:45:19.5765Z\", \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-06-24T09:45:19.5765Z\"}', 0, '2020-06-24 04:15:19', '2020-06-24 04:15:19'),
(490, '{\"id\": \"492ec023-b2ec-4e0b-8396-ec0670e9ff26\", \"verb\": {\"id\": \"http://example.com/xapi/visited\", \"display\": {\"en\": \"Visited\"}}, \"actor\": {\"name\": \"2017cs192\", \"account\": {\"name\": \"2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://example.com/button_example\", \"definition\": {\"name\": {\"en\": \"Laravel create migration file in specific folder - Stack Overflow\"}, \"description\": {\"en\": \"https://stackoverflow.com/questions/57230525/laravel-create-migration-file-in-specific-folder\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-06-24T09:45:27.2713Z\", \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-06-24T09:45:27.2713Z\"}', 0, '2020-06-24 04:15:27', '2020-06-24 04:15:27'),
(491, '{\"id\": \"863584e2-803b-42ae-8bf1-7cefbc8e0ce4\", \"verb\": {\"id\": \"http://example.com/xapi/visited\", \"display\": {\"en\": \"Visited\"}}, \"actor\": {\"name\": \"2017cs192\", \"account\": {\"name\": \"2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://example.com/button_example\", \"definition\": {\"name\": {\"en\": \"How to change tables structures with migration without losing your data in Laravel - DEV\"}, \"description\": {\"en\": \"https://dev.to/nromero125/how-to-change-tables-structures-with-migration-without-losing-your-data-in-laravel-26fc\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-06-24T09:45:35.2615Z\", \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-06-24T09:45:35.2615Z\"}', 0, '2020-06-24 04:15:35', '2020-06-24 04:15:35'),
(492, '{\"id\": \"2fadb9f7-be7f-404d-8b75-c1417c808712\", \"verb\": {\"id\": \"http://example.com/xapi/visited\", \"display\": {\"en\": \"Visited\"}}, \"actor\": {\"name\": \"2017cs192\", \"account\": {\"name\": \"2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://example.com/button_example\", \"definition\": {\"name\": {\"en\": \"Gmail\"}, \"description\": {\"en\": \"https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-06-24T09:46:01.5734Z\", \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-06-24T09:46:01.5734Z\"}', 0, '2020-06-24 04:16:01', '2020-06-24 04:16:01'),
(493, '{\"id\": \"bf66fa4b-5647-4150-ba81-86c96e87cf3b\", \"verb\": {\"id\": \"http://example.com/xapi/visited\", \"display\": {\"en\": \"Visited\"}}, \"actor\": {\"name\": \"2017cs192\", \"account\": {\"name\": \"2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://example.com/button_example\", \"definition\": {\"name\": {\"en\": \"Machine Learning - Home | Coursera\"}, \"description\": {\"en\": \"https://www.coursera.org/learn/machine-learning/lecture/wlPeP/classification\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-06-24T09:46:15.2034Z\", \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-06-24T09:46:15.2034Z\"}', 0, '2020-06-24 04:16:15', '2020-06-24 04:16:15'),
(494, '{\"id\": \"11fa9d5c-86e6-41e5-be57-ffaebd1458ef\", \"verb\": {\"id\": \"http://example.com/xapi/visited\", \"display\": {\"en\": \"Visited\"}}, \"actor\": {\"name\": \"2017cs192\", \"account\": {\"name\": \"2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://example.com/button_example\", \"definition\": {\"name\": {\"en\": \"Machine Learning - Home | Coursera\"}, \"description\": {\"en\": \"https://www.coursera.org/learn/machine-learning/home/welcome\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-06-24T09:46:34.1491Z\", \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-06-24T09:46:34.1491Z\"}', 0, '2020-06-24 04:16:34', '2020-06-24 04:16:34'),
(495, '{\"id\": \"b8a5c97b-25c9-4756-ae54-9e8c21962151\", \"verb\": {\"id\": \"http://example.com/xapi/visited\", \"display\": {\"en\": \"Visited\"}}, \"actor\": {\"name\": \"2017cs192\", \"account\": {\"name\": \"2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://example.com/button_example\", \"definition\": {\"name\": {\"en\": \"ProjectLinsight/Dashboard\"}, \"description\": {\"en\": \"https://github.com/ProjectLinsight/Dashboard\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-06-24T09:46:47.0919Z\", \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-06-24T09:46:47.0919Z\"}', 0, '2020-06-24 04:16:47', '2020-06-24 04:16:47'),
(496, '{\"id\": \"5dd2fec0-0867-4e52-918a-a6eb7d0b66bf\", \"verb\": {\"id\": \"http://example.com/xapi/visited\", \"display\": {\"en\": \"Visited\"}}, \"actor\": {\"name\": \"2017cs192\", \"account\": {\"name\": \"2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://example.com/button_example\", \"definition\": {\"name\": {\"en\": \"php - cloning laravel project from github - Stack Overflow\"}, \"description\": {\"en\": \"https://stackoverflow.com/questions/38602321/cloning-laravel-project-from-github\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-06-24T09:46:56.1437Z\", \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-06-24T09:46:56.1437Z\"}', 0, '2020-06-24 04:16:56', '2020-06-24 04:16:56'),
(497, '{\"id\": \"2d1da1fa-1e1d-4002-ac19-d41ad9380037\", \"verb\": {\"id\": \"http://example.com/xapi/visited\", \"display\": {\"en\": \"Visited\"}}, \"actor\": {\"name\": \"2017cs192\", \"account\": {\"name\": \"2017cs192\", \"homePage\": \"http://localhost\"}, \"objectType\": \"Agent\"}, \"object\": {\"id\": \"http://example.com/button_example\", \"definition\": {\"name\": {\"en\": \"TRAX LRS / Statements\"}, \"description\": {\"en\": \"http://localhost/traxlrs/public/trax/ui/xapi-server/statements\"}}, \"objectType\": \"Activity\"}, \"stored\": \"2020-06-24T09:47:01.8879Z\", \"version\": \"1.0.0\", \"authority\": {\"account\": {\"name\": \"traxlrs\", \"homePage\": \"http://trax.test\"}, \"objectType\": \"Agent\"}, \"timestamp\": \"2020-06-24T09:47:01.8879Z\"}', 0, '2020-06-24 04:17:01', '2020-06-24 04:17:01');

-- --------------------------------------------------------

--
-- Table structure for table `trax_xapiserver_states`
--

CREATE TABLE `trax_xapiserver_states` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trax_account_agreements`
--
ALTER TABLE `trax_account_agreements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trax_account_agreement_user`
--
ALTER TABLE `trax_account_agreement_user`
  ADD PRIMARY KEY (`agreement_id`,`user_id`),
  ADD KEY `trax_account_agreement_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `trax_account_basic_clients`
--
ALTER TABLE `trax_account_basic_clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trax_account_basic_clients_username_unique` (`username`);

--
-- Indexes for table `trax_account_entities`
--
ALTER TABLE `trax_account_entities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trax_account_entities_uuid_unique` (`uuid`),
  ADD KEY `trax_account_entities_parent_id_foreign` (`parent_id`),
  ADD KEY `trax_account_entities_type_code_index` (`type_code`);

--
-- Indexes for table `trax_account_group_user`
--
ALTER TABLE `trax_account_group_user`
  ADD PRIMARY KEY (`group_id`,`user_id`),
  ADD KEY `trax_account_group_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `trax_account_password_resets`
--
ALTER TABLE `trax_account_password_resets`
  ADD KEY `trax_account_password_resets_email_index` (`email`);

--
-- Indexes for table `trax_xapiserver_statements`
--
ALTER TABLE `trax_xapiserver_statements`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `trax_xapiserver_statements`
--
ALTER TABLE `trax_xapiserver_statements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=498;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
