-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2020 at 03:40 PM
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
-- Database: `dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credits` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `cName`, `cid`, `credits`, `type`, `semester`, `created_at`, `updated_at`) VALUES
(2, 'Software Quality Assuarance', 'IS3102', '2', 'Compulsory', 'One', '2020-05-21 19:19:38', '2020-05-21 19:19:38'),
(3, 'Enterprise Resource Planning Systems', 'IS3101', '2', 'Compulsory', 'One', '2020-05-21 21:26:24', '2020-05-21 21:26:24'),
(4, 'Human Computer Interaction', 'IS3103', '3', 'Compulsory', 'One', '2020-05-22 02:47:22', '2020-05-22 02:47:22'),
(5, 'Strategic Management', 'IS3104', '2', 'Optional', 'One', '2020-05-22 03:31:11', '2020-05-22 03:31:11'),
(6, 'Professional Practice', 'IS3105', '2', 'Compulsory', 'One', '2020-05-22 03:34:43', '2020-05-22 03:34:43'),
(7, 'IT Procurement Management', 'IS3106', '2', 'Optional', 'One', '2020-05-22 03:35:31', '2020-05-22 03:35:31'),
(8, 'Contingency Planning and Risk Management', 'IS3107', '2', 'Optional', 'One', '2020-05-22 03:36:36', '2020-05-22 03:36:36'),
(9, 'Middleware Architecture', 'IS3108', '3', 'Optional', 'One', '2020-05-22 03:37:27', '2020-05-22 03:37:27'),
(10, 'Systems and Network Administration', 'IS3109', '3', 'Optional', 'One', '2020-05-22 03:37:50', '2020-05-22 03:37:50'),
(11, 'Research Methods', 'IS3110', '2', 'IS1X', 'One', '2020-05-22 03:38:28', '2020-05-22 03:38:28'),
(12, 'Operations Research', 'IS3111', '2', 'Optional', 'One', '2020-05-22 03:41:46', '2020-05-22 03:41:46'),
(13, 'Game Development', 'IS3112', '3', 'Optional', 'One', '2020-05-22 03:42:08', '2020-05-22 03:42:08'),
(14, 'Group Project II', 'IS3113', '3', 'Compulsory', 'One', '2020-05-22 03:42:39', '2020-05-22 03:42:39'),
(15, 'Enterprise Applications', 'IS3114', '2', 'Compulsory', 'One', '2020-05-22 03:43:45', '2020-05-22 03:43:45'),
(16, 'Mobile Application Development', 'IS3115', '3', 'Optional', 'One', '2020-05-22 03:44:07', '2020-05-22 03:44:07'),
(17, 'Database Management Systems II', 'IS3116', '2', 'Optional', 'One', '2020-05-22 03:44:36', '2020-05-22 03:44:36'),
(18, 'Machine Learning and Neural Computing', 'IS3117', '2', 'Optional', 'One', '2020-05-22 03:46:30', '2020-05-22 03:46:30'),
(19, 'E-Learning and Instructional Design', 'IS3118', '2', 'Optional', 'One', '2020-05-22 03:47:10', '2020-05-22 03:47:10'),
(20, 'Industrial Placement', 'EN3101', '8', 'Compulsory', 'Two', '2020-05-22 03:47:51', '2020-05-22 03:47:51'),
(21, 'Data Structures and Algorithms I', 'SCS1201', '3', 'Compulsory', 'One', '2020-05-22 05:33:21', '2020-05-22 05:33:21'),
(22, 'Programming Using C', 'SCS1202', '3', 'Compulsory', 'One', '2020-05-22 05:33:47', '2020-05-22 05:33:47'),
(23, 'Database I', 'SCS1203', '3', 'Compulsory', 'One', '2020-05-22 05:34:08', '2020-05-22 05:34:08'),
(24, 'Discrete Mathematics I', 'SCS1204', '2', 'Compulsory', 'One', '2020-05-22 05:34:48', '2020-05-22 05:34:48'),
(25, 'Computer Systems', 'SCS1205', '2', 'Compulsory', 'One', '2020-05-22 05:35:14', '2020-05-22 05:35:14'),
(26, 'Laboratory I', 'SCS1206', '2', 'Compulsory', 'One', '2020-05-22 05:35:58', '2020-05-22 05:35:58'),
(27, 'Software Engineering I', 'SCS1207', '2', 'Compulsory', 'One', '2020-05-22 05:37:08', '2020-05-22 05:37:08'),
(28, 'Enhancement I', 'ENH1201', '1', 'Compulsory', 'One', '2020-05-22 05:37:39', '2020-05-22 05:37:39'),
(29, 'Data Structures and Algorithms II', 'SCS1208', '3', 'Compulsory', 'Two', '2020-05-22 05:38:52', '2020-05-22 05:38:52'),
(30, 'Object Oriented Programming', 'SCS1209', '3', 'Compulsory', 'Two', '2020-05-22 05:39:42', '2020-05-22 05:39:42'),
(31, 'Software Engineering II', 'SCS1210', '2', 'Compulsory', 'Two', '2020-05-22 05:40:15', '2020-05-22 05:40:15'),
(32, 'Mathematical Methods I', 'SCS1211', '2', 'Compulsory', 'Two', '2020-05-22 05:40:49', '2020-05-22 05:40:49'),
(33, 'Foundation of Computer Science', 'SCS1212', '2', 'Compulsory', 'Two', '2020-05-22 05:41:24', '2020-05-22 05:41:24'),
(34, 'Probability and Statistics', 'SCS1213', '2', 'Compulsory', 'Two', '2020-05-22 05:42:04', '2020-05-22 05:42:04'),
(35, 'Operating Systems I', 'SCS1214', '3', 'Compulsory', 'Two', '2020-05-22 05:42:51', '2020-05-22 05:42:51'),
(36, 'Enhancement II', 'ENH1202', '1', 'Compulsory', 'Two', '2020-05-22 05:43:11', '2020-05-22 05:43:11'),
(37, 'Data Structures and Algorithms III', 'SCS2201', '3', 'Compulsory', 'One', '2020-05-22 05:44:05', '2020-05-22 05:44:05'),
(38, 'Group Project I', 'SCS2202', '4', 'Compulsory', 'Spanned', '2020-05-22 05:44:48', '2020-05-22 05:44:48'),
(39, 'Software Engineering III', 'SCS2203', '2', 'Compulsory', 'One', '2020-05-22 05:45:26', '2020-05-22 05:45:26'),
(40, 'Functional Programming', 'SCS2204', '3', 'Compulsory', 'One', '2020-05-22 05:45:54', '2020-05-22 05:45:54'),
(41, 'Computer Networks I', 'SCS2205', '3', 'Compulsory', 'One', '2020-05-22 05:46:23', '2020-05-22 05:46:23'),
(42, 'Mathematical Methods II', 'SCS2206', '2', 'Compulsory', 'One', '2020-05-22 05:47:12', '2020-05-22 05:47:12'),
(43, 'Programming Language Concepts', 'SCS2207', '2', 'Compulsory', 'One', '2020-05-22 05:48:10', '2020-05-22 05:48:10'),
(44, 'Rapid Application Development', 'SCS2208', '3', 'Compulsory', 'One', '2020-05-22 05:48:45', '2020-05-22 05:48:45'),
(45, 'Database II', 'SCS2209', '3', 'Compulsory', 'Two', '2020-05-22 05:49:50', '2020-05-22 05:49:50'),
(46, 'Discrete Mathematics II', 'SCS2210', '2', 'Compulsory', 'Two', '2020-05-22 05:50:37', '2020-05-22 05:50:37'),
(47, 'Laboratory II', 'SCS2211', '3', 'Compulsory', 'Two', '2020-05-22 05:52:38', '2020-05-22 05:52:38'),
(48, 'Automata Theory', 'SCS2212', '2', 'Compulsory', 'Two', '2020-05-22 05:53:25', '2020-05-22 05:53:25'),
(49, 'Electronics and Physical Computing', 'SCS2213', '3', 'Compulsory', 'Two', '2020-05-22 05:54:30', '2020-05-22 05:54:30'),
(50, 'Information Systems Security', 'SCS2214', '2', 'Compulsory', 'Two', '2020-05-22 05:55:01', '2020-05-22 05:55:01'),
(51, 'Enhancement III', 'ENH2201', '1', 'Compulsory', 'Two', '2020-05-22 05:55:21', '2020-05-22 05:55:21'),
(52, 'Programming and Problem Solving', 'IS1101', '3', 'Compulsory', 'One', '2020-05-22 05:57:13', '2020-05-22 05:57:13'),
(53, 'Computer Systems', 'IS1102', '2', 'Compulsory', 'One', '2020-05-22 05:57:36', '2020-05-22 05:57:36'),
(54, 'Information Systems Management', 'IS1103', '2', 'Compulsory', 'One', '2020-05-22 05:58:19', '2020-05-22 05:58:19'),
(55, 'Application Laboratory', 'IS1104', '2', 'Compulsory', 'One', '2020-05-22 05:58:41', '2020-05-22 05:58:41'),
(56, 'Introduction To Management', 'IS1105', '2', 'Compulsory', 'One', '2020-05-22 05:59:05', '2020-05-22 05:59:05'),
(57, 'Discrete Mathematics', 'IS1106', '2', 'Compulsory', 'One', '2020-05-22 05:59:58', '2020-05-22 05:59:58'),
(58, 'Interactive Media Design', 'IS1107', '3', 'Compulsory', 'One', '2020-05-22 06:00:16', '2020-05-22 06:00:16'),
(59, 'Enhancement I', 'EN1101', '1', 'Compulsory', 'One', '2020-05-22 06:00:44', '2020-05-22 06:00:44'),
(60, 'Financial Accounting', 'IS1108', '2', 'Compulsory', 'Two', '2020-05-22 06:01:13', '2020-05-22 06:01:13'),
(61, 'Programming for Web Application Development', 'IS1109', '3', 'Compulsory', 'Two', '2020-05-22 06:01:46', '2020-05-22 06:01:46'),
(62, 'Database Management', 'IS1110', '2', 'Compulsory', 'Two', '2020-05-22 06:03:14', '2020-05-22 06:03:14'),
(63, 'Software Engineering', 'IS1111', '3', 'Compulsory', 'Two', '2020-05-22 06:03:35', '2020-05-22 06:03:35'),
(64, 'Probability and Statistics', 'IS1112', '1', 'Compulsory', 'Two', '2020-05-22 06:03:59', '2020-05-22 06:03:59'),
(65, 'Organizational Behavior and Society', 'IS1113', '1', 'Compulsory', 'Two', '2020-05-22 06:04:25', '2020-05-22 06:04:25'),
(66, 'Data Structures and Algorithms I', 'IS1114', '3', 'Compulsory', 'Two', '2020-05-22 06:04:50', '2020-05-22 06:04:50'),
(67, 'Fundamentals of Economics', 'IS1115', '1', 'Compulsory', 'Two', '2020-05-22 06:05:12', '2020-05-22 06:05:12'),
(68, 'Enhancement II', 'EN1102', '1', 'Compulsory', 'Two', '2020-05-22 06:05:31', '2020-05-22 06:05:31'),
(69, 'System Analysis and Designing', 'IS2101', '2', 'Compulsory', 'One', '2020-05-22 06:06:29', '2020-05-22 06:06:29'),
(70, 'Group Project I', 'IS2102', '4', 'Compulsory', 'Spanned', '2020-05-22 06:06:43', '2020-05-22 06:06:43'),
(71, 'Digital Marketing', 'IS2103', '2', 'Compulsory', 'One', '2020-05-22 06:07:01', '2020-05-22 06:07:01'),
(72, 'Rapid Application Development', 'IS2104', '3', 'Compulsory', 'One', '2020-05-22 06:07:24', '2020-05-22 06:07:24'),
(73, 'Business Statistics', 'IS2105', '3', 'Compulsory', 'One', '2020-05-22 06:09:02', '2020-05-22 06:09:02'),
(74, 'Business Process Management', 'IS2106', '2', 'Compulsory', 'One', '2020-05-22 06:09:36', '2020-05-22 06:09:36'),
(75, 'Graphics and Visualization', 'IS2107', '2', 'Compulsory', 'One', '2020-05-22 06:10:00', '2020-05-22 06:10:00'),
(76, 'IT Project Management', 'IS2108', '2', 'Compulsory', 'Two', '2020-05-22 06:10:29', '2020-05-22 06:10:29'),
(77, 'Information Systems Security', 'IS2109', '3', 'Compulsory', 'Two', '2020-05-22 06:10:52', '2020-05-22 06:10:52'),
(78, 'Data Structures and Algorithms II', 'IS2110', '2', 'Compulsory', 'Two', '2020-05-22 06:11:12', '2020-05-22 06:11:12'),
(79, 'Computer Networks', 'IS2111', '3', 'Compulsory', 'Two', '2020-05-22 06:11:34', '2020-05-22 06:11:34'),
(80, 'E-Business Strategies', 'IS2112', '2', 'Compulsory', 'Two', '2020-05-22 06:12:43', '2020-05-22 06:12:43'),
(81, 'Community Informatics', 'IS2113', '2', 'Compulsory', 'Two', '2020-05-22 06:13:08', '2020-05-22 06:13:08'),
(82, 'Business Process Re-engineering', 'IS2114', '2', 'Compulsory', 'Two', '2020-05-22 06:13:39', '2020-05-22 06:13:39'),
(83, 'Enhancement III', 'EN2102', '1', 'Compulsory', 'Two', '2020-05-22 06:14:21', '2020-05-22 06:14:21'),
(84, 'Final Year Project in Information Systems', 'IS4101', '8', 'IS1X', 'One', '2020-05-22 06:45:39', '2020-05-22 06:45:39'),
(85, 'Advanced Software Quality Assurance', 'IS4102', '2', 'IS1X', 'One', '2020-05-22 06:49:23', '2020-05-22 06:49:23'),
(86, 'Data Analytics', 'IS4103', '3', 'IS0X', 'One', '2020-05-22 06:50:02', '2020-05-22 06:50:02'),
(87, 'Research Seminar', 'IS4104', '2', 'IS1X', 'One', '2020-05-22 06:50:57', '2020-05-22 06:50:57'),
(88, 'Advanced Concepts in Software Design and Development', 'IS4105', '3', 'IS0X', 'One', '2020-05-22 06:51:43', '2020-05-22 06:51:43'),
(89, 'Advanced Database Management', 'IS4106', '3', 'IS0X', 'One', '2020-05-22 06:52:14', '2020-05-22 06:52:14'),
(90, 'Ethical Issues and Legal Aspects of IT', 'IS4107', '1', 'IS0X', 'One', '2020-05-22 06:52:42', '2020-05-22 06:52:42'),
(91, 'Natural Language Processing', 'IS4108', '3', 'IS0X', 'One', '2020-05-22 06:53:25', '2020-05-22 06:53:25'),
(92, 'Cognitive Robotics', 'IS4109', '2', 'IS0X', 'One', '2020-05-22 06:53:54', '2020-05-22 06:53:54'),
(93, 'Parallel Computing', 'IS4110', '3', 'IS0X', 'One', '2020-05-22 06:54:28', '2020-05-22 06:54:28'),
(94, 'Computational Biology', 'IS4111', '3', 'IS0X', 'Two', '2020-05-22 06:55:01', '2020-05-22 06:55:01'),
(95, 'Geographical Information Systems', 'IS4112', '2', 'IS0X', 'Two', '2020-05-22 06:55:29', '2020-05-22 06:55:29'),
(96, 'Digital Forensics', 'IS4113', '2', 'IS0X', 'Two', '2020-05-22 06:55:53', '2020-05-22 06:55:53'),
(97, 'IS Innovation', 'IS4114', '2', 'IS1X', 'Two', '2020-05-22 07:01:42', '2020-05-22 07:01:42'),
(98, 'Enterprise Architecture', 'IS4115', '2', 'IS0X', 'Two', '2020-05-22 07:02:44', '2020-05-22 07:02:44'),
(99, 'Business Intelligence Systems', 'IS4116', '2', 'IS1X', 'Two', '2020-05-22 07:03:15', '2020-05-22 07:03:15'),
(100, 'Intelligent Systems', 'IS4117', '2', 'IS0X', 'Two', '2020-05-22 07:03:42', '2020-05-22 07:03:42'),
(101, 'Embedded Systems', 'IS4118', '3', 'IS0X', 'Two', '2020-05-22 07:04:17', '2020-05-22 07:04:17'),
(102, 'Philosophy of Science', 'IS4119', '1', 'IS1X', 'Two', '2020-05-22 07:04:35', '2020-05-22 07:04:35'),
(103, 'Machine Learning and Neural Computing', 'SCS3201', '2', 'CS100', 'One', '2020-05-22 07:07:07', '2020-05-22 07:07:07'),
(104, 'Advanced Computer Architecture', 'SCS3202', '1', 'Optional', 'One', '2020-05-22 07:07:35', '2020-05-22 07:07:35'),
(105, 'Middleware Architecture', 'SCS3203', '3', 'CS010', 'One', '2020-05-22 07:08:19', '2020-05-22 07:08:19'),
(106, 'Management', 'SCS3204', '2', 'CS001', 'One', '2020-05-22 07:09:12', '2020-05-22 07:09:12'),
(107, 'Computer Graphics I', 'SCS3205', '2', 'Optional', 'One', '2020-05-22 07:10:22', '2020-05-22 07:10:22'),
(108, 'Graph Theory', 'SCS3206', '1', 'CS100', 'One', '2020-05-22 07:10:58', '2020-05-22 07:10:58'),
(109, 'Software Quality Assurance', 'SCS3207', '2', 'CS011', 'One', '2020-05-22 07:11:32', '2020-05-22 07:11:32'),
(110, 'Software Project Management', 'SCS3208', '2', 'CS011', 'One', '2020-05-22 07:12:21', '2020-05-22 07:12:21'),
(111, 'Human Computer Interaction', 'SCS3209', '3', 'CS010', 'One', '2020-05-22 07:13:13', '2020-05-22 07:13:13'),
(112, 'Systems and Network Administration', 'SCS3210', '3', 'Optional', 'One', '2020-05-22 07:13:45', '2020-05-22 07:13:45'),
(113, 'Compiler Theory', 'SCS3211', '2', 'CS100', 'One', '2020-05-22 07:14:21', '2020-05-22 07:14:21'),
(114, 'Mobile Application Development', 'SCS3212', '3', 'Optional', 'One', '2020-05-22 07:15:04', '2020-05-22 07:15:04'),
(115, 'Game Development', 'SCS3213', '3', 'Optional', 'One', '2020-05-22 07:15:36', '2020-05-22 07:15:36'),
(116, 'Group Project II', 'SCS3214', '3', 'Compulsory', 'One', '2020-05-22 07:16:15', '2020-05-22 07:16:15'),
(117, 'Professional Practice', 'SCS3215', '2', 'Compulsory', 'One', '2020-05-22 07:16:43', '2020-05-22 07:16:43'),
(118, 'Research Methods', 'SCS3216', '2', 'CS10X', 'One', '2020-05-22 07:17:29', '2020-05-22 07:17:29'),
(119, 'Industry Placement', 'ENH3201', '1', 'Compulsory', 'Two', '2020-05-22 07:18:02', '2020-05-22 07:18:02'),
(120, 'Ethical Issues and Legal Aspects in IT', 'SCS4201', '1', 'Optional', 'One', '2020-05-22 07:19:21', '2020-05-22 07:19:21'),
(121, 'Cognitive Robotics', 'SCS4202', '2', 'Optional', 'One', '2020-05-22 07:20:03', '2020-05-22 07:20:03'),
(122, 'Database III', 'SCS4203', '3', 'CS01X', 'One', '2020-05-22 07:20:51', '2020-05-22 07:20:51'),
(123, 'Data Analytics', 'SCS4204', '3', 'Optional', 'One', '2020-05-22 07:21:35', '2020-05-22 07:21:35'),
(124, 'Computer Networks II', 'SCS4205', '2', 'Optional', 'One', '2020-05-22 07:22:08', '2020-05-22 07:22:08'),
(125, 'Computer Graphics II', 'SCS4206', '3', 'Optional', 'One', '2020-05-22 07:22:37', '2020-05-22 07:22:37'),
(126, 'Image Processing and Computer Vision', 'SCS4207', '2', 'Optional', 'One', '2020-05-22 07:22:58', '2020-05-22 07:22:58'),
(127, 'Theory of Computation', 'SCS4208', '2', 'CS10X', 'One', '2020-05-22 07:23:24', '2020-05-22 07:23:24'),
(128, 'Natural Language Processing', 'SCS4209', '3', 'Optional', 'One', '2020-05-22 07:24:05', '2020-05-22 07:24:05'),
(129, 'Parallel Computing', 'SCS4210', '3', 'Optional', 'One', '2020-05-22 07:24:21', '2020-05-22 07:24:21'),
(130, 'Research Seminar', 'SCS4211', '2', 'CS10X', 'One', '2020-05-22 07:24:46', '2020-05-22 07:24:46'),
(131, 'Formal methods and Software Verification', 'SCS4212', '2', 'Compulsory', 'One', '2020-05-22 07:25:24', '2020-05-22 07:25:24'),
(132, 'Digital Forensics', 'SCS4213', '2', 'Optional', 'Two', '2020-05-22 07:26:01', '2020-05-22 07:26:01'),
(133, 'Natural Algorithms', 'SCS4214', '2', 'Optional', 'Two', '2020-05-22 07:26:22', '2020-05-22 07:26:22'),
(134, 'Computational Biology', 'SCS4215', '3', 'Optional', 'Two', '2020-05-22 07:26:41', '2020-05-22 07:26:41'),
(135, 'Advanced Topics in Mathematics', 'SCS4216', '1', 'Optional', 'Two', '2020-05-22 07:26:58', '2020-05-22 07:26:58'),
(136, 'Embedded Systems', 'SCS4217', '3', 'Optional', 'Two', '2020-05-22 07:27:12', '2020-05-22 07:27:12'),
(137, 'Operating Systems II', 'SCS4218', '2', 'CS10X', 'Two', '2020-05-22 07:27:51', '2020-05-22 07:27:51'),
(138, 'Distributed Systems II', 'SCS4219', '2', 'Optional', 'Two', '2020-05-22 07:29:11', '2020-05-22 07:29:11'),
(139, 'Data Structures and Algorithms IV', 'SCS4220', '2', 'Optional', 'Two', '2020-05-22 07:30:32', '2020-05-22 07:30:32'),
(140, 'Software Engineering IV', 'SCS4221', '3', 'CS01X', 'Two', '2020-05-22 07:31:09', '2020-05-22 07:31:09'),
(141, 'Logic Programming', 'SCS4222', '2', 'Optional', 'Two', '2020-05-22 07:31:34', '2020-05-22 07:31:34'),
(142, 'Philosophy of Science', 'SCS4225', '1', 'Compulsory', 'Two', '2020-05-22 07:32:01', '2020-05-22 07:32:01'),
(143, 'Intelligent Systems', 'SCS4226', '2', 'Optional', 'Two', '2020-05-22 07:32:26', '2020-05-22 07:32:26'),
(144, 'Final Year Project in Software Engineering', 'SCS4223', '8', 'CSX1X', 'Spanned', '2020-05-22 07:33:02', '2020-05-22 07:33:02'),
(145, 'Final Year Project in Computer Science', 'SCS4224', '8', 'CS1XX', 'Spanned', '2020-05-22 07:33:28', '2020-05-22 07:33:28');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
