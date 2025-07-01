-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 01, 2025 at 09:37 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `osem`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `timestamp` int UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  `flexi_auth_data` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `user_agent` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `uacc_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `far_log`
--

CREATE TABLE `far_log` (
  `log_id` int NOT NULL,
  `uacc_id` int DEFAULT NULL,
  `log_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'activity',
  `log_data_json` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `create_dttm` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `far_log`
--

INSERT INTO `far_log` (`log_id`, `uacc_id`, `log_type`, `log_data_json`, `create_dttm`) VALUES
(1, 1, 'logged_in', NULL, '2025-02-11 02:51:05'),
(2, 1, 'logged_in', NULL, '2025-02-11 04:08:57'),
(3, 1, 'user_logout', NULL, '2025-02-11 04:13:30'),
(4, 2215, 'user_logout', NULL, '2025-02-12 01:23:38'),
(5, 2249, 'user_logout', NULL, '2025-03-12 20:36:43'),
(6, 2193, 'logged_in', NULL, '2025-03-12 20:58:37'),
(7, 2193, 'user_logout', NULL, '2025-03-12 20:58:53'),
(8, 2222, 'logged_in', NULL, '2025-03-12 21:00:16'),
(9, 2222, 'user_logout', NULL, '2025-03-12 21:00:22'),
(10, 2249, 'logged_in', NULL, '2025-03-12 21:00:39'),
(11, 2249, 'user_logout', NULL, '2025-03-12 21:01:09'),
(12, 2241, 'logged_in', NULL, '2025-03-12 21:01:25'),
(13, 2241, 'user_logout', NULL, '2025-03-12 21:13:14'),
(14, 2227, 'logged_in', NULL, '2025-03-12 21:13:59'),
(15, 2227, 'user_logout', NULL, '2025-03-12 23:48:15'),
(16, 2241, 'logged_in', NULL, '2025-03-12 23:48:44'),
(17, 2241, 'user_logout', NULL, '2025-03-13 10:34:37'),
(18, 2258, 'user_logout', NULL, '2025-03-13 21:32:48'),
(19, 2260, 'user_logout', NULL, '2025-03-13 21:34:44'),
(20, 2261, 'user_logout', NULL, '2025-03-14 12:20:16'),
(21, 0, 'user_logout', NULL, '2025-03-14 13:51:17'),
(22, 2264, 'user_logout', NULL, '2025-03-14 13:52:55'),
(23, 2265, 'user_logout', NULL, '2025-03-14 13:53:52'),
(24, 2266, 'user_logout', NULL, '2025-03-14 18:36:53'),
(25, 2250, 'logged_in', NULL, '2025-03-14 20:14:01'),
(26, 2250, 'user_logout', NULL, '2025-03-14 20:15:17'),
(27, 2250, 'logged_in', NULL, '2025-03-14 20:29:09'),
(28, 2250, 'user_logout', NULL, '2025-03-14 21:10:57'),
(29, 2250, 'logged_in', NULL, '2025-03-14 21:18:16'),
(30, 2250, 'user_logout', NULL, '2025-03-15 23:14:01'),
(31, 2250, 'logged_in', NULL, '2025-03-16 12:37:41'),
(32, 2250, 'user_logout', NULL, '2025-03-16 12:40:23'),
(33, 2250, 'logged_in', NULL, '2025-03-16 15:01:41'),
(34, 2250, 'user_logout', NULL, '2025-03-16 15:15:34'),
(35, 2261, 'logged_in', NULL, '2025-03-16 15:19:45'),
(36, 2261, 'user_logout', NULL, '2025-03-17 16:44:41'),
(37, 2267, 'user_logout', NULL, '2025-03-17 19:16:21'),
(38, 2261, 'logged_in', NULL, '2025-03-17 19:16:31'),
(39, 2261, 'user_logout', NULL, '2025-03-17 19:39:19'),
(40, 2267, 'logged_in', NULL, '2025-03-17 19:39:29'),
(41, 2267, 'user_logout', NULL, '2025-03-17 20:35:07'),
(42, 2261, 'logged_in', NULL, '2025-03-17 20:35:18'),
(43, 2261, 'user_logout', NULL, '2025-03-17 20:50:06'),
(44, 2268, 'user_logout', NULL, '2025-03-18 00:04:46'),
(45, 2261, 'logged_in', NULL, '2025-03-18 00:07:49'),
(46, 2261, 'user_logout', NULL, '2025-03-18 00:12:42'),
(47, 2269, 'user_logout', NULL, '2025-03-18 00:23:03'),
(48, 2261, 'logged_in', NULL, '2025-03-18 00:23:21'),
(49, 2261, 'user_logout', NULL, '2025-03-18 00:28:13'),
(50, 2269, 'logged_in', NULL, '2025-03-18 00:28:27'),
(51, 2269, 'user_logout', NULL, '2025-03-18 00:29:20'),
(52, 2261, 'logged_in', NULL, '2025-03-18 00:43:46'),
(53, 2261, 'user_logout', NULL, '2025-03-19 00:54:16'),
(54, 2270, 'user_logout', NULL, '2025-03-19 00:56:26'),
(55, 2271, 'user_logout', NULL, '2025-03-19 01:02:08'),
(56, 2271, 'logged_in', NULL, '2025-03-19 01:06:49'),
(57, 2271, 'user_logout', NULL, '2025-03-19 01:33:57'),
(58, 2267, 'logged_in', NULL, '2025-03-19 01:34:11'),
(59, 2267, 'user_logout', NULL, '2025-03-19 19:03:05'),
(60, 2178, 'logged_in', NULL, '2025-03-19 19:03:52'),
(61, 2178, 'user_logout', NULL, '2025-03-20 01:24:30'),
(62, 2178, 'logged_in', NULL, '2025-03-20 01:29:57'),
(63, 2261, 'logged_in', NULL, '2025-03-20 02:09:22'),
(64, 2178, 'logged_in', NULL, '2025-03-20 18:13:06'),
(65, 2178, 'user_logout', NULL, '2025-03-21 16:05:21'),
(66, 2178, 'logged_in', NULL, '2025-03-21 16:09:43'),
(67, 2178, 'user_logout', NULL, '2025-04-04 14:31:11'),
(68, 2178, 'logged_in', NULL, '2025-04-04 14:33:59'),
(69, 2178, 'user_logout', NULL, '2025-04-04 15:16:40'),
(70, 1, 'logged_in', NULL, '2025-04-04 15:17:13'),
(71, 1, 'user_logout', NULL, '2025-04-04 15:58:44'),
(72, 2178, 'logged_in', NULL, '2025-04-04 15:58:50'),
(73, 2178, 'user_logout', NULL, '2025-04-04 16:10:51'),
(74, 1, 'logged_in', NULL, '2025-04-04 16:10:58'),
(75, 1, 'user_logout', NULL, '2025-04-04 16:11:22'),
(76, 2178, 'logged_in', NULL, '2025-04-04 16:11:26'),
(77, 2178, 'user_logout', NULL, '2025-04-11 12:35:22'),
(78, 1, 'logged_in', NULL, '2025-04-11 12:39:11'),
(79, 1, 'cms_admin_create_new_user', '{\"new_user_uacc_id\":2272,\"user_detail\":{\"fullname\":\"asdsadsad\"}}', '2025-04-11 13:22:45'),
(80, 1, 'cms_admin_create_new_user', '{\"new_user_uacc_id\":2273,\"user_detail\":{\"fullname\":\"sdfsdf\"}}', '2025-04-11 13:24:20'),
(81, 1, 'cms_admin_create_new_user', '{\"new_user_uacc_id\":2274,\"user_detail\":{\"fullname\":\"sdfasdfsdaf\"}}', '2025-04-11 13:24:56'),
(82, 1, 'cms_admin_create_new_user', '{\"new_user_uacc_id\":2275,\"user_detail\":{\"fullname\":\"asdasdsadasdsad\"}}', '2025-04-11 13:25:19'),
(83, 1, 'cms_admin_create_new_user', '{\"new_user_uacc_id\":2276,\"user_detail\":{\"fullname\":\"werwerewrewrwer\"}}', '2025-04-11 13:25:56'),
(84, 1, 'cms_admin_create_new_user', '{\"new_user_uacc_id\":2277,\"user_detail\":{\"fullname\":\"werwerwerewr\"}}', '2025-04-11 13:26:39'),
(85, 1, 'user_logout', NULL, '2025-04-11 13:28:50'),
(86, 2274, 'logged_in', NULL, '2025-04-11 13:51:55'),
(87, 2274, 'user_logout', NULL, '2025-04-11 16:07:24'),
(88, 1, 'logged_in', NULL, '2025-04-11 16:07:31'),
(89, 1, 'cms_admin_create_new_user', '{\"new_user_uacc_id\":2278,\"user_detail\":{\"fullname\":\"sdfsdfsdfsdf\"}}', '2025-04-11 16:07:42'),
(90, 1, 'user_logout', NULL, '2025-04-11 16:07:55'),
(91, 2274, 'logged_in', NULL, '2025-04-11 16:08:07'),
(92, 2274, 'user_logout', NULL, '2025-04-11 16:08:16'),
(93, 2178, 'logged_in', NULL, '2025-04-11 16:09:05'),
(94, 2178, 'user_logout', NULL, '2025-04-21 19:36:31'),
(95, 2178, 'logged_in', NULL, '2025-04-22 13:50:44'),
(96, 2178, 'user_logout', NULL, '2025-04-24 20:06:36'),
(97, 2275, 'logged_in', NULL, '2025-04-24 20:07:36'),
(98, 2275, 'user_logout', NULL, '2025-05-06 14:06:38'),
(99, 1, 'logged_in', NULL, '2025-05-06 14:06:46'),
(100, 1, 'cms_admin_create_new_user', '{\"new_user_uacc_id\":2279,\"user_detail\":{\"fullname\":\"asdsadsadsad\"}}', '2025-05-06 14:08:26'),
(101, 2279, 'logged_in', NULL, '2025-05-06 14:09:38'),
(102, 1, 'user_logout', NULL, '2025-05-07 16:00:16'),
(103, 2178, 'logged_in', NULL, '2025-05-07 16:00:23'),
(104, 2178, 'user_logout', NULL, '2025-05-08 16:27:26'),
(105, 1, 'logged_in', NULL, '2025-05-08 16:27:37'),
(106, 1, 'user_logout', NULL, '2025-05-13 18:08:43'),
(107, 2178, 'logged_in', NULL, '2025-05-13 18:09:10'),
(108, 2178, 'user_logout', NULL, '2025-05-13 19:17:42'),
(109, 1, 'logged_in', NULL, '2025-05-13 19:17:53'),
(110, 1, 'cms_admin_create_new_user', '{\"new_user_uacc_id\":2280,\"user_detail\":{\"fullname\":\"asdasd\"}}', '2025-05-13 19:26:43'),
(111, 1, 'cms_admin_create_new_user', '{\"new_user_uacc_id\":2281,\"user_detail\":{\"fullname\":\"asdasdasd\"}}', '2025-05-13 19:30:23'),
(112, 1, 'cms_admin_create_new_user', '{\"new_user_uacc_id\":2282,\"user_detail\":{\"fullname\":\"asdsad\"}}', '2025-05-13 19:30:56'),
(113, 1, 'cms_edit_user_profile', '{\"uacc_id\":null}', '2025-05-14 12:55:14'),
(114, 1, 'cms_edit_user_profile', '{\"uacc_id\":\"1\"}', '2025-05-14 12:55:32'),
(115, 1, 'cms_package_edit', '{\"uacc_id\":\"1\"}', '2025-05-14 12:56:05'),
(116, 1, 'cms_package_edit', '{\"uacc_id\":\"1\"}', '2025-05-14 12:58:16'),
(117, 1, 'cms_package_edit', '{\"uacc_id\":\"1\"}', '2025-05-14 12:58:41'),
(118, 1, 'cms_package_edit', '{\"uacc_id\":\"1\",\"package_name\":{\"then\":\"SDFSDFSDF\",\"now\":\"SDFSDFSDFasdasd\"}}', '2025-05-14 12:59:04'),
(119, 1, 'cms_package_edit', '{\"uacc_id\":\"1\",\"package_name\":{\"then\":\"SDFSDFSDFasdasd\",\"now\":\"Package 1\"}}', '2025-05-14 12:59:14'),
(120, 1, 'cms_package_edit', '{\"uacc_id\":\"1\"}', '2025-05-14 12:59:42'),
(121, 1, 'cms_package_edit', '{\"uacc_id\":\"1\",\"price_normal\":{\"then\":\"0.00\",\"now\":\"40\"}}', '2025-05-14 13:00:13'),
(122, 1, 'cms_package_edit', '{\"uacc_id\":\"1\",\"price_member\":{\"then\":\"0.00\",\"now\":\"30\"}}', '2025-05-14 13:00:52'),
(123, 1, 'cms_package_edit', '{\"uacc_id\":\"1\",\"price_normal\":{\"then\":\"0.00\",\"now\":\"20\"},\"price_member\":{\"then\":\"0.00\",\"now\":\"15\"}}', '2025-05-14 14:20:46'),
(124, 1, 'user_logout', NULL, '2025-05-15 17:19:35'),
(125, 2178, 'logged_in', NULL, '2025-05-15 17:20:18'),
(126, 2178, 'user_logout', NULL, '2025-05-17 12:28:23'),
(127, 1, 'logged_in', NULL, '2025-05-17 12:28:29'),
(128, 1, 'user_logout', NULL, '2025-05-17 12:37:39'),
(129, 2178, 'logged_in', NULL, '2025-05-17 12:37:47'),
(130, 1, 'logged_in', NULL, '2025-05-26 14:44:23'),
(131, 2178, 'user_logout', NULL, '2025-05-27 21:45:28'),
(132, 1, 'logged_in', NULL, '2025-05-27 21:45:35'),
(133, 1, 'user_logout', NULL, '2025-05-27 22:16:50'),
(134, 2178, 'logged_in', NULL, '2025-05-27 22:16:58'),
(135, 2178, 'user_logout', NULL, '2025-05-27 22:33:15'),
(136, 1, 'logged_in', NULL, '2025-05-27 22:33:23'),
(137, 1, 'user_logout', NULL, '2025-05-27 22:54:17'),
(138, 2178, 'logged_in', NULL, '2025-05-27 22:54:27'),
(139, 2178, 'user_logout', NULL, '2025-05-28 18:16:43'),
(140, 1, 'logged_in', NULL, '2025-05-28 18:16:50'),
(141, 1, 'user_logout', NULL, '2025-05-31 13:36:51'),
(142, 2178, 'logged_in', NULL, '2025-05-31 13:37:04'),
(143, 2178, 'user_logout', NULL, '2025-05-31 13:38:19'),
(144, 1, 'logged_in', NULL, '2025-05-31 13:38:25'),
(145, 1, 'user_logout', NULL, '2025-05-31 15:32:56'),
(146, 2178, 'logged_in', NULL, '2025-05-31 15:33:05'),
(147, 1, 'user_logout', NULL, '2025-05-31 16:15:06'),
(148, 2178, 'logged_in', NULL, '2025-05-31 16:15:16'),
(149, 2178, 'user_logout', NULL, '2025-05-31 17:00:03'),
(150, 1, 'logged_in', NULL, '2025-05-31 17:00:19'),
(151, 1, 'cms_edit_user_profile', '{\"uacc_id\":\"1\"}', '2025-05-31 18:44:02'),
(152, 1, 'cms_edit_user_profile', '{\"uacc_id\":\"1\"}', '2025-05-31 18:44:09'),
(153, 1, 'cms_edit_user_profile', '{\"uacc_id\":\"1\",\"price_normal\":{\"then\":\"0.00\",\"now\":\"12\"},\"price_member\":{\"then\":\"0.00\",\"now\":\"13\"}}', '2025-05-31 20:11:35'),
(154, 1, 'user_logout', NULL, '2025-06-01 16:31:36'),
(155, 1, 'logged_in', NULL, '2025-06-01 16:59:53'),
(156, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\",\"is_member\":{\"then\":\"no\",\"now\":\"no\"}}', '2025-06-02 00:10:36'),
(157, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\",\"fullname\":{\"then\":\"WEREWREWREWR23\",\"now\":\"WEREWREWREWR23\"},\"is_member\":{\"then\":\"yes\",\"now\":\"yes\"}}', '2025-06-02 01:03:43'),
(158, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\",\"mobile_number\":{\"then\":\"604324324324\",\"now\":\"604324324324\"}}', '2025-06-02 01:03:54'),
(159, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\"}', '2025-06-02 01:04:04'),
(160, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\"}', '2025-06-02 01:05:04'),
(161, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\"}', '2025-06-02 01:05:13'),
(162, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\"}', '2025-06-02 01:05:38'),
(163, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\"}', '2025-06-02 01:06:19'),
(164, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\",\"is_member\":{\"then\":\"no\",\"now\":\"no\"}}', '2025-06-02 01:07:45'),
(165, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\",\"is_member\":{\"then\":\"yes\",\"now\":\"yes\"}}', '2025-06-02 01:07:52'),
(166, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\",\"is_member\":{\"then\":\"no\",\"now\":\"no\"}}', '2025-06-02 01:08:17'),
(167, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\",\"is_member\":{\"then\":\"yes\",\"now\":\"yes\"}}', '2025-06-02 01:08:56'),
(168, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\",\"fullname\":{\"then\":\"WEREWREWREWR2388888\",\"now\":\"WEREWREWREWR2388888\"}}', '2025-06-02 01:12:04'),
(169, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\",\"fullname\":{\"then\":\"TEST\",\"now\":\"TEST\"}}', '2025-06-02 01:12:37'),
(170, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\",\"fullname\":{\"then\":\"TESTUUUUU\",\"now\":\"TESTUUUUU\"}}', '2025-06-02 01:13:03'),
(171, 1, 'cms_customer_edit', '{\"uacc_id\":\"1\",\"is_member\":{\"then\":\"no\",\"now\":\"no\"}}', '2025-06-02 01:13:17'),
(172, 1, 'user_logout', NULL, '2025-06-02 17:45:54'),
(173, 2178, 'logged_in', NULL, '2025-06-02 18:09:12'),
(174, 2178, 'user_logout', NULL, '2025-06-03 00:11:25'),
(175, 1, 'logged_in', NULL, '2025-06-03 00:11:31'),
(176, 1, 'user_logout', NULL, '2025-06-03 00:13:50'),
(177, 1, 'logged_in', NULL, '2025-06-03 00:13:53'),
(178, 1, 'user_logout', NULL, '2025-06-03 00:14:00'),
(179, 1, 'logged_in', NULL, '2025-06-03 00:15:00'),
(180, 1, 'user_logout', NULL, '2025-06-03 00:15:04'),
(181, 4, 'logged_in', NULL, '2025-06-03 00:15:33'),
(182, 4, 'user_logout', NULL, '2025-06-03 00:28:26'),
(183, 2178, 'logged_in', NULL, '2025-06-03 00:28:33'),
(184, 2178, 'user_logout', NULL, '2025-06-03 00:39:49'),
(185, 4, 'logged_in', NULL, '2025-06-03 00:42:48'),
(186, 4, 'cms_edit_user_profile', '{\"uacc_id\":\"4\"}', '2025-06-03 21:28:09'),
(187, 4, 'cms_customer_edit', '{\"uacc_id\":\"4\",\"is_member\":{\"then\":\"yes\",\"now\":\"yes\"}}', '2025-06-04 17:07:28'),
(188, 4, 'cms_customer_edit', '{\"uacc_id\":\"4\",\"is_member\":{\"then\":\"no\",\"now\":\"no\"}}', '2025-06-04 17:07:32'),
(189, 2283, 'user_logout', NULL, '2025-06-05 17:23:38'),
(190, 2283, 'user_logout', NULL, '2025-06-05 20:06:37'),
(191, 2283, 'user_logout', NULL, '2025-06-14 13:39:21'),
(192, 2284, 'user_logout', NULL, '2025-06-19 15:24:11'),
(193, 2284, 'user_logout', NULL, '2025-06-23 14:28:15'),
(194, 2284, 'logged_in', NULL, '2025-06-24 16:28:34'),
(195, 2284, 'user_logout', NULL, '2025-06-25 12:04:23'),
(196, 2284, 'logged_in', NULL, '2025-06-25 12:21:24'),
(197, 2284, 'user_logout', NULL, '2025-06-25 12:22:01'),
(198, 2284, 'logged_in', NULL, '2025-06-25 12:22:51'),
(199, 2284, 'user_logout', NULL, '2025-06-25 12:23:42'),
(200, 2284, 'logged_in', NULL, '2025-06-25 12:59:57');

-- --------------------------------------------------------

--
-- Table structure for table `far_menu`
--

CREATE TABLE `far_menu` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `parent_id` int DEFAULT NULL,
  `sort` int DEFAULT NULL,
  `group_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `controller` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `visible` int DEFAULT '1' COMMENT 'true or false',
  `page_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `page_title_small` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `icon-class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `flags` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `far_menu`
--

INSERT INTO `far_menu` (`id`, `name`, `parent_id`, `sort`, `group_id`, `link`, `controller`, `method`, `visible`, `page_title`, `page_title_small`, `icon-class`, `flags`) VALUES
(128, 'Dashboard', 0, 0, '3,4,5,9', 'ci_controller', 'auth_admin', 'dashboard', 1, 'DASHBOARD', NULL, 'fa fa-home', NULL),
(129, 'Settings', 0, 300, '3', 'javascript: void();', '', '', 0, 'TETAPAN', NULL, 'fa fa-gear', NULL),
(150, 'Users', 0, 200, '3', 'javascript: void();', NULL, NULL, 1, 'USERS', NULL, 'fa fa-users', NULL),
(154, 'List all Staff', 150, 200, '3', 'ci_controller', 'admin_users', 'admin_list_all_staff', 1, 'LIST ALL Staff', NULL, 'fa fa-users', NULL),
(175, 'Products', 0, 200, '3', 'javascript: void();', NULL, NULL, 1, 'Products', NULL, 'fa-solid fa-cookie-bite', NULL),
(176, 'List all Product', 175, 200, '3', 'ci_controller', 'admin_product', 'datatable_admin_list_all_product', 1, 'List all Product', NULL, 'fa fa-users', NULL),
(177, 'Attendances', 0, 200, '3', 'javascript: void();', NULL, NULL, 1, 'Attendances', NULL, 'fa-solid fa-user-clock', NULL),
(178, 'List all Attendance', 177, 200, '3', 'ci_controller', 'admin_attendance', 'datatable_admin_list_all_attendance', 1, 'List all Attendance', NULL, 'fa fa-users', NULL),
(179, 'Packages', 0, 200, '3', 'javascript: void();', NULL, NULL, 1, 'Packages', NULL, 'fa-solid fa-box-open', NULL),
(180, 'List all Package', 179, 200, '3', 'ci_controller', 'admin_package', 'package_listing', 1, 'List all Package', NULL, 'fa fa-users', NULL),
(181, 'Membership', 0, 200, '3', 'javascript: void();', NULL, NULL, 1, 'Membership', NULL, 'fa-solid fa-users-gear', NULL),
(182, 'Membership Report', 181, 200, '3', 'ci_controller', 'admin_customer', 'datatable_admin_list_all_customer', 1, 'List all Customer', NULL, 'fa fa-users', NULL),
(183, 'Monthly Report', 177, 200, '3', 'ci_controller', 'admin_attendance', 'monthly_report', 1, 'Monthly Report', NULL, 'fa fa-users', NULL),
(184, 'Product Transaction', 175, 200, '3', 'ci_controller', 'admin_product', 'product_transaction', 1, 'Product Transaction', NULL, 'fa fa-users', NULL),
(185, 'Reserve Balance Listing', 181, 200, '3', 'ci_controller', 'admin_customer', 'reserve_balance_listing', 1, 'Reserve Balance Listing', NULL, 'fa fa-users', NULL),
(186, 'Sales', 0, 200, '3', 'javascript: void();', NULL, NULL, 1, 'Sales', NULL, 'fa-solid fa-cash-register', NULL),
(187, 'Sales Report', 186, 200, '3', 'ci_controller', 'admin_sales', 'sales_report', 1, 'Sales Report', NULL, 'fa fa-users', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `far_meta`
--

CREATE TABLE `far_meta` (
  `meta_id` int NOT NULL,
  `meta` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `create_dttm` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `far_meta`
--

INSERT INTO `far_meta` (`meta_id`, `meta`, `value`, `create_dttm`) VALUES
(1, 'title', 'Osem', '0000-00-00 00:00:00'),
(2, 'footer_text', 'Osem', '0000-00-00 00:00:00'),
(35, 'login_logo_url', 'https://inovar.appsdesign.asia/assets/login_logo_page.png', NULL),
(36, 'nex_accounts_uacc_id', '2178', NULL),
(53, 'banned_username_keyword', 'admin,fuck,dick,office,back,about,access,account,accounts,add,address,adm,admin,administration,adult,advertising,affiliate,affiliates,ajax,analytics,android,anon,anonymous,api,app,apps,archive,atom,auth,authentication,avatar,backup,banner,banners,bin,billing,blog,blogs,board,bot,bots,business,chat,cache,cadastro,calendar,campaign,careers,cgi,client,cliente,code,comercial,commercial,compare,config,connect,contact,contest,create,code,compras,css,dashboard,data,db,design,delete,demo,design,designer,dev,devel,dir,directory,doc,docs,domain,download,downloads,edit,editor,email,ecommerce,forum,forums,faq,favorite,feed,feedback,flog,follow,file,files,free,ftp,gadget,gadgets,games,guest,group,groups,help,home,homepage,host,hosting,hostname,html,http,httpd,https,hpg,info,information,image,img,images,imap,index,invite,intranet,indice,ipad,iphone,irc,java,javascript,job,jobs,js,knowledgebase,log,login,logs,logout,list,lists,mail,mail1,mail2,mail3,mail4,mail5,mailer,mailing,mx,manager,marketing,master,media,message,microblog,microblogs,mine,mp3,msg,msn,mysql,messenger,mob,mobile,movie,movies,music,musicas,name,named,net,network,new,news,newsletter,nick,nickname,notes,noticias,ns,ns1,ns2,ns3,ns4,old,online,operator,order,orders,page,pager,pages,panel,password,perl,pic,pics,photo,photos,photoalbum,php,plugin,plugins,pop,pop3,post,postmaster,postfix,posts,profile,project,projects,promo,pub,public,python,random,register,registration,root,ruby,rss,sale,sales,sample,samples,script,scripts,secure,send,service,shop,sql,signup,signin,search,security,settings,setting,setup,site,sites,sitemap,smtp,soporte,ssh,stage,staging,start,subscribe,subdomain,suporte,support,stat,static,stats,status,store,stores,system,tablet,tablets,tech,telnet,test,test1,test2,test3,teste,tests,theme,themes,tmp,todo,task,tasks,tools,tv,talk,update,upload,url,user,username,usuario,usage,vendas,video,videos,visitor,win,ww,www,www1,www2,www3,www4,www5,www6,www7,wwww,wws,wwws,web,webmail,website,websites,webmaster,workshop,xxx,xpg,you,yourname,yourusername,yoursite,yourdomain', NULL),
(54, 'tac_expired_in_minutes', '3', NULL),
(58, 'default_profile_picture', 'https://inovar.appsdesign.asia/assets/login_logo_page.png', NULL),
(74, 'last_crawl_dttm', '2025-07-01 17:04:00', NULL),
(75, 'last_crawl_data', '[{\\\"id\\\":\\\"0001\\\",\\\"type\\\":\\\"donut\\\",\\\"name\\\":\\\"Cake\\\",\\\"ppu\\\":0.55,\\\"batters\\\":{\\\"batter\\\":[{\\\"id\\\":\\\"1001\\\",\\\"type\\\":\\\"Regular\\\"},{\\\"id\\\":\\\"1002\\\",\\\"type\\\":\\\"Chocolate\\\"},{\\\"id\\\":\\\"1003\\\",\\\"type\\\":\\\"Blueberry\\\"},{\\\"id\\\":\\\"1004\\\",\\\"type\\\":\\\"Devil\\\'s Food\\\"}]},\\\"topping\\\":[{\\\"id\\\":\\\"5002\\\",\\\"type\\\":\\\"Glazed\\\"},{\\\"id\\\":\\\"5005\\\",\\\"type\\\":\\\"Sugar\\\"},{\\\"id\\\":\\\"5007\\\",\\\"type\\\":\\\"Powdered Sugar\\\"},{\\\"id\\\":\\\"5006\\\",\\\"type\\\":\\\"Chocolate with Sprinkles\\\"},{\\\"id\\\":\\\"5003\\\",\\\"type\\\":\\\"Chocolate\\\"},{\\\"id\\\":\\\"5004\\\",\\\"type\\\":\\\"Maple\\\"}]},{\\\"id\\\":\\\"0002\\\",\\\"type\\\":\\\"donut\\\",\\\"name\\\":\\\"Raised\\\",\\\"ppu\\\":0.55,\\\"batters\\\":{\\\"batter\\\":[{\\\"id\\\":\\\"1001\\\",\\\"type\\\":\\\"Regular\\\"}]},\\\"topping\\\":[{\\\"id\\\":\\\"5002\\\",\\\"type\\\":\\\"Glazed\\\"},{\\\"id\\\":\\\"5005\\\",\\\"type\\\":\\\"Sugar\\\"},{\\\"id\\\":\\\"5003\\\",\\\"type\\\":\\\"Chocolate\\\"},{\\\"id\\\":\\\"5004\\\",\\\"type\\\":\\\"Maple\\\"}]},{\\\"id\\\":\\\"0003\\\",\\\"type\\\":\\\"donut\\\",\\\"name\\\":\\\"Old Fashioned\\\",\\\"ppu\\\":0.55,\\\"batters\\\":{\\\"batter\\\":[{\\\"id\\\":\\\"1001\\\",\\\"type\\\":\\\"Regular\\\"},{\\\"id\\\":\\\"1002\\\",\\\"type\\\":\\\"Chocolate\\\"}]},\\\"topping\\\":[{\\\"id\\\":\\\"5002\\\",\\\"type\\\":\\\"Glazed\\\"},{\\\"id\\\":\\\"5003\\\",\\\"type\\\":\\\"Chocolate\\\"},{\\\"id\\\":\\\"5004\\\",\\\"type\\\":\\\"Maple\\\"}]}]', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `far_smsout`
--

CREATE TABLE `far_smsout` (
  `fs_id` int NOT NULL,
  `agent_uacc_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `uacc_id` int DEFAULT NULL,
  `msisdn` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `message` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `sent_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'queue',
  `sms_type` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'sms_invitation',
  `sent_dttm` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0000-00-00 00:00:00',
  `onewaysms_mtid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `onewaysms_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `additional_data` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'verification code'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `far_tac`
--

CREATE TABLE `far_tac` (
  `tac_id` int NOT NULL,
  `page_identifier` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `uacc_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tac_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tac_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'signup,signin',
  `tac_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'unused,used',
  `create_dttm` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `expired_dttm` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `mobile_number` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nric_number` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `item_detail`
--

CREATE TABLE `item_detail` (
  `item_id` int NOT NULL,
  `product_api_id` varchar(200) DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `id` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `ids` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `item_detail`
--

INSERT INTO `item_detail` (`item_id`, `product_api_id`, `category`, `id`, `type`, `ids`) VALUES
(26, '0001', 'topping', '5002', 'Glazed', NULL),
(27, '0001', 'topping', '5005', 'Sugar', NULL),
(28, '0001', 'topping', '5007', 'Powdered Sugar', NULL),
(29, '0001', 'topping', '5006', 'Chocolate with Sprinkles', NULL),
(30, '0001', 'topping', '5003', 'Chocolate', NULL),
(31, '0001', 'topping', '5004', 'Maple', NULL),
(32, '0001', 'batter', '1001', 'Regular', NULL),
(33, '0001', 'batter', '1002', 'Chocolate', NULL),
(34, '0001', 'batter', '1003', 'Blueberry', NULL),
(35, '0001', 'batter', '1004', 'Devil\'s Food', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification_detail`
--

CREATE TABLE `notification_detail` (
  `notification_id` int NOT NULL,
  `receiver_uacc_id` int DEFAULT NULL,
  `module_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `notification_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `notification_title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `notification_message` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `primary_id_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `primary_id_value` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `msg_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `notification_status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sender_uacc_id` int DEFAULT NULL,
  `read_dttm` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `create_dttm` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `web_url` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `launchURL` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `onesignal_notification_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `product_detail`
--

CREATE TABLE `product_detail` (
  `product_id` int NOT NULL,
  `id` varchar(100) NOT NULL DEFAULT '0',
  `type` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `ppu` decimal(12,2) NOT NULL,
  `batter_list` text,
  `topping_list` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_detail`
--

INSERT INTO `product_detail` (`product_id`, `id`, `type`, `name`, `ppu`, `batter_list`, `topping_list`) VALUES
(1, '0001', 'donut', 'Cake', '0.55', '1001,1002,1003,1004', '5002,5005,5007,5006,5003,5004'),
(2, '0002', 'donut', 'Raised', '0.55', '1001', '5002,5005,5003,5004'),
(3, '0003', 'donut', 'Old Fashioned', '0.55', '1001,1002', '5002,5003,5004');

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `uacc_id` int UNSIGNED NOT NULL,
  `uacc_upline_id` int NOT NULL,
  `uacc_group_fk` smallint UNSIGNED NOT NULL DEFAULT '0',
  `uacc_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `uacc_username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `uacc_password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `uacc_raw_password` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `uacc_ip_address` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `uacc_salt` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `uacc_activation_token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `uacc_forgotten_password_token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `uacc_forgotten_password_expire` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '0000-00-00 00:00:00',
  `uacc_update_email_token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `uacc_update_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `uacc_active` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `uacc_suspend` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `uacc_fail_login_attempts` smallint NOT NULL DEFAULT '0',
  `uacc_fail_login_ip_address` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `uacc_date_fail_login_ban` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '0000-00-00 00:00:00' COMMENT 'Time user is banned until due to repeated failed logins',
  `uacc_date_last_login` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '0000-00-00 00:00:00',
  `uacc_date_added` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '0000-00-00 00:00:00',
  `upline_level_1` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `upline_level_2` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `upline_level_3` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `upline_level_4` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `upline_level_5` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `upline_level_6` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `upline_level_7` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `upline_level_8` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `upline_level_9` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `upline_level_10` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `list_network_upline` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `list_group_upline` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `list_downline` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `device_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `firebase_return_create_user` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `alias_url_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `affiliate_activated_by_uacc_id` int NOT NULL DEFAULT '0',
  `affiliate_activated_dttm` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `package_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '1',
  `subscription_id` int DEFAULT NULL,
  `random_upline_group` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'no',
  `force_change_password` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'yes',
  `onesignal_player_id` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `device_platform` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ruko_user_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bank_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bank_account_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bank_account_number` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `is_admin` varchar(50) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`uacc_id`, `uacc_upline_id`, `uacc_group_fk`, `uacc_email`, `uacc_username`, `uacc_password`, `uacc_raw_password`, `uacc_ip_address`, `uacc_salt`, `uacc_activation_token`, `uacc_forgotten_password_token`, `uacc_forgotten_password_expire`, `uacc_update_email_token`, `uacc_update_email`, `uacc_active`, `uacc_suspend`, `uacc_fail_login_attempts`, `uacc_fail_login_ip_address`, `uacc_date_fail_login_ban`, `uacc_date_last_login`, `uacc_date_added`, `upline_level_1`, `upline_level_2`, `upline_level_3`, `upline_level_4`, `upline_level_5`, `upline_level_6`, `upline_level_7`, `upline_level_8`, `upline_level_9`, `upline_level_10`, `list_network_upline`, `list_group_upline`, `list_downline`, `device_type`, `firebase_return_create_user`, `alias_url_name`, `affiliate_activated_by_uacc_id`, `affiliate_activated_dttm`, `package_id`, `subscription_id`, `random_upline_group`, `force_change_password`, `onesignal_player_id`, `device_platform`, `ruko_user_id`, `bank_name`, `bank_account_name`, `bank_account_number`, `is_admin`) VALUES
(1, 0, 3, 'asdasdada@asdad.com', 'admin', '$2y$10$H2tVAlpcpnDu0yk5Kdssne9FjPaSYoajluAF8mimky0SrM4U9RIJS', 'Skk_88888', '127.0.0.1', 'rRQ8xysdfW', '', '', '0000-00-00 00:00:00', '', '', 1, 0, 0, '', '0', '2025-06-03 00:15:00', '2011-01-01 00:00:00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '2271,2270,2269,2268,2267,2266,2265,2264,2263,2262,2261,2178', NULL, NULL, 'admin', 0, NULL, '1', NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, 'no');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `ugrp_id` smallint NOT NULL,
  `ugrp_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `ugrp_desc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `ugrp_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`ugrp_id`, `ugrp_name`, `ugrp_desc`, `ugrp_admin`) VALUES
(1, 'Public', 'Public User : has no admin access rights.', 0),
(2, 'Admin', 'Admin : has partial admin access rights.', 1),
(3, 'Administrator', 'Master Admin : has full admin access rights.', 1),
(4, 'Staff', 'Staff', 1),
(5, 'Supervisor', 'Supervisor', 1),
(6, 'User', 'User', 1),
(8, 'Marketing', 'Marketing', 1),
(9, 'Fulfillment', 'Fulfillment', 1),
(99, 'Deleted User', 'Deleted User', 1),
(100, 'Deleted Staff', 'Deleted Staff', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_login_sessions`
--

CREATE TABLE `user_login_sessions` (
  `usess_uacc_fk` int NOT NULL DEFAULT '0',
  `usess_series` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `usess_token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `usess_login_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `onesignal_subscription_id` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `onesignal_player_id` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_login_sessions`
--

INSERT INTO `user_login_sessions` (`usess_uacc_fk`, `usess_series`, `usess_token`, `usess_login_date`, `onesignal_subscription_id`, `onesignal_player_id`) VALUES
(2284, 'a559ea46185bc44e304b60410a46b4b1aa800eb7', '390773df88d15fb5456ce330d63f0c76d090a042', '2025-06-25 12:59:57', NULL, NULL),
(2279, 'efa2ef189edb3f8111ae2f829272d6992194bba4', '66d6276c5f39ab027ec180be345e14f17a5ef240', '2025-05-06 14:09:38', NULL, NULL),
(4, '8eff23521d5737491c5ddef632eb1edddbf4ed22', 'cea979b3a2acd43406e46848a6f67eb5986750a2', '2025-06-03 00:42:48', NULL, NULL),
(2261, '416218922a80ddf5eda9a32787dcdce39122a473', 'e25d439980db85de01b8b37e1a8c3ecccb1ae3e9', '2025-03-20 02:09:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_privileges`
--

CREATE TABLE `user_privileges` (
  `upriv_id` smallint NOT NULL,
  `upriv_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `upriv_desc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_privileges`
--

INSERT INTO `user_privileges` (`upriv_id`, `upriv_name`, `upriv_desc`) VALUES
(1, 'View Users', 'User can view user account details.'),
(2, 'View User Groups', 'User can view user groups.'),
(3, 'View Privileges', 'User can view privileges.'),
(4, 'Insert User Groups', 'User can insert new user groups.'),
(5, 'Insert Privileges', 'User can insert privileges.'),
(6, 'Update Users', 'User can update user account details.'),
(7, 'Update User Groups', 'User can update user groups.'),
(8, 'Update Privileges', 'User can update user privileges.'),
(9, 'Delete Users', 'User can delete user accounts.'),
(10, 'Delete User Groups', 'User can delete user groups.'),
(11, 'Delete Privileges', 'User can delete user privileges.');

-- --------------------------------------------------------

--
-- Table structure for table `user_privilege_groups`
--

CREATE TABLE `user_privilege_groups` (
  `upriv_groups_id` smallint UNSIGNED NOT NULL,
  `upriv_groups_ugrp_fk` smallint UNSIGNED NOT NULL DEFAULT '0',
  `upriv_groups_upriv_fk` smallint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_privilege_groups`
--

INSERT INTO `user_privilege_groups` (`upriv_groups_id`, `upriv_groups_ugrp_fk`, `upriv_groups_upriv_fk`) VALUES
(1, 3, 1),
(3, 3, 3),
(4, 3, 4),
(5, 3, 5),
(6, 3, 6),
(7, 3, 7),
(8, 3, 8),
(9, 3, 9),
(10, 3, 10),
(11, 3, 11),
(12, 2, 2),
(13, 2, 4),
(14, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_privilege_users`
--

CREATE TABLE `user_privilege_users` (
  `upriv_users_id` smallint NOT NULL,
  `upriv_users_uacc_fk` int NOT NULL DEFAULT '0',
  `upriv_users_upriv_fk` smallint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_privilege_users`
--

INSERT INTO `user_privilege_users` (`upriv_users_id`, `upriv_users_uacc_fk`, `upriv_users_upriv_fk`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 2, 1),
(13, 2, 2),
(14, 2, 3),
(15, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `upro_id` int NOT NULL,
  `uacc_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fullname` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `fullname_as_per_mykad` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nric_number` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `mobile_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `profile_picture_url` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `push_notification_on` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '1',
  `email_notification_on` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '1',
  `private_profile_on` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `language` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'en' COMMENT 'en/cn/bm',
  `user_department_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_designation_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_role_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nric_front_url` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `nric_front_mykad_attachment_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nric_back_url` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `nric_back_mykad_attachment_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `signature_url` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `signature_create_dttm` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `signature_verification_status` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'pending_user_signature',
  `mykad_dob` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `mykad_state` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `mykad_gender` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_notification_list`
-- (See below for the actual view)
--
CREATE TABLE `view_notification_list` (
`notification_id` int
,`receiver_uacc_id` int
,`module_name` varchar(200)
,`notification_type` varchar(50)
,`notification_title` varchar(200)
,`notification_message` varchar(200)
,`primary_id_name` varchar(200)
,`primary_id_value` varchar(100)
,`msg_id` varchar(200)
,`notification_status` varchar(100)
,`sender_uacc_id` int
,`read_dttm` varchar(50)
,`create_dttm` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_user_list`
-- (See below for the actual view)
--
CREATE TABLE `view_user_list` (
`uacc_id` int unsigned
,`uacc_upline_id` int
,`uacc_username` varchar(100)
,`uacc_email` varchar(100)
,`uacc_raw_password` mediumtext
,`uacc_group_fk` smallint unsigned
,`ugrp_name` varchar(20)
,`fullname` varchar(200)
,`mobile_number` varchar(50)
,`email` varchar(100)
,`gender` varchar(10)
,`uacc_date_added` varchar(50)
,`force_change_password` varchar(10)
,`profile_picture_url` mediumtext
,`alias_url_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Structure for view `view_notification_list`
--
DROP TABLE IF EXISTS `view_notification_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `view_notification_list`  AS SELECT `n`.`notification_id` AS `notification_id`, `n`.`receiver_uacc_id` AS `receiver_uacc_id`, `n`.`module_name` AS `module_name`, `n`.`notification_type` AS `notification_type`, `n`.`notification_title` AS `notification_title`, `n`.`notification_message` AS `notification_message`, `n`.`primary_id_name` AS `primary_id_name`, `n`.`primary_id_value` AS `primary_id_value`, `n`.`msg_id` AS `msg_id`, `n`.`notification_status` AS `notification_status`, `n`.`sender_uacc_id` AS `sender_uacc_id`, `n`.`read_dttm` AS `read_dttm`, `n`.`create_dttm` AS `create_dttm` FROM `notification_detail` AS `n` ;

-- --------------------------------------------------------

--
-- Structure for view `view_user_list`
--
DROP TABLE IF EXISTS `view_user_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `view_user_list`  AS SELECT `u`.`uacc_id` AS `uacc_id`, `u`.`uacc_upline_id` AS `uacc_upline_id`, `u`.`uacc_username` AS `uacc_username`, `u`.`uacc_email` AS `uacc_email`, `u`.`uacc_raw_password` AS `uacc_raw_password`, `u`.`uacc_group_fk` AS `uacc_group_fk`, `g`.`ugrp_name` AS `ugrp_name`, `p`.`fullname` AS `fullname`, `p`.`mobile_number` AS `mobile_number`, `p`.`email` AS `email`, `p`.`gender` AS `gender`, `u`.`uacc_date_added` AS `uacc_date_added`, `u`.`force_change_password` AS `force_change_password`, `p`.`profile_picture_url` AS `profile_picture_url`, `u`.`alias_url_name` AS `alias_url_name` FROM ((`user_accounts` `u` left join `user_profiles` `p` on((`u`.`uacc_id` = `p`.`uacc_id`))) left join `user_groups` `g` on((`u`.`uacc_group_fk` = `g`.`ugrp_id`))) WHERE (`u`.`uacc_group_fk` <> '99') ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `far_log`
--
ALTER TABLE `far_log`
  ADD UNIQUE KEY `log_id` (`log_id`);

--
-- Indexes for table `far_menu`
--
ALTER TABLE `far_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `far_meta`
--
ALTER TABLE `far_meta`
  ADD PRIMARY KEY (`meta_id`),
  ADD UNIQUE KEY `meta_id` (`meta_id`);

--
-- Indexes for table `far_smsout`
--
ALTER TABLE `far_smsout`
  ADD UNIQUE KEY `fs_id` (`fs_id`);

--
-- Indexes for table `far_tac`
--
ALTER TABLE `far_tac`
  ADD UNIQUE KEY `tac_id` (`tac_id`);

--
-- Indexes for table `item_detail`
--
ALTER TABLE `item_detail`
  ADD UNIQUE KEY `item_id` (`item_id`);

--
-- Indexes for table `notification_detail`
--
ALTER TABLE `notification_detail`
  ADD UNIQUE KEY `notification_id` (`notification_id`);

--
-- Indexes for table `product_detail`
--
ALTER TABLE `product_detail`
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`uacc_id`),
  ADD UNIQUE KEY `uacc_id` (`uacc_id`),
  ADD KEY `uacc_group_fk` (`uacc_group_fk`),
  ADD KEY `uacc_email` (`uacc_email`),
  ADD KEY `uacc_username` (`uacc_username`),
  ADD KEY `uacc_fail_login_ip_address` (`uacc_fail_login_ip_address`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`ugrp_id`),
  ADD UNIQUE KEY `ugrp_id` (`ugrp_id`) USING BTREE;

--
-- Indexes for table `user_login_sessions`
--
ALTER TABLE `user_login_sessions`
  ADD PRIMARY KEY (`usess_token`),
  ADD UNIQUE KEY `usess_token` (`usess_token`);

--
-- Indexes for table `user_privileges`
--
ALTER TABLE `user_privileges`
  ADD PRIMARY KEY (`upriv_id`),
  ADD UNIQUE KEY `upriv_id` (`upriv_id`) USING BTREE;

--
-- Indexes for table `user_privilege_groups`
--
ALTER TABLE `user_privilege_groups`
  ADD PRIMARY KEY (`upriv_groups_id`),
  ADD UNIQUE KEY `upriv_groups_id` (`upriv_groups_id`) USING BTREE,
  ADD KEY `upriv_groups_ugrp_fk` (`upriv_groups_ugrp_fk`),
  ADD KEY `upriv_groups_upriv_fk` (`upriv_groups_upriv_fk`);

--
-- Indexes for table `user_privilege_users`
--
ALTER TABLE `user_privilege_users`
  ADD PRIMARY KEY (`upriv_users_id`),
  ADD UNIQUE KEY `upriv_users_id` (`upriv_users_id`) USING BTREE,
  ADD KEY `upriv_users_uacc_fk` (`upriv_users_uacc_fk`),
  ADD KEY `upriv_users_upriv_fk` (`upriv_users_upriv_fk`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`upro_id`),
  ADD UNIQUE KEY `upro_id` (`upro_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `far_log`
--
ALTER TABLE `far_log`
  MODIFY `log_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `far_menu`
--
ALTER TABLE `far_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `far_meta`
--
ALTER TABLE `far_meta`
  MODIFY `meta_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `far_smsout`
--
ALTER TABLE `far_smsout`
  MODIFY `fs_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `far_tac`
--
ALTER TABLE `far_tac`
  MODIFY `tac_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_detail`
--
ALTER TABLE `item_detail`
  MODIFY `item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `notification_detail`
--
ALTER TABLE `notification_detail`
  MODIFY `notification_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_detail`
--
ALTER TABLE `product_detail`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `uacc_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2285;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `ugrp_id` smallint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `user_privileges`
--
ALTER TABLE `user_privileges`
  MODIFY `upriv_id` smallint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_privilege_groups`
--
ALTER TABLE `user_privilege_groups`
  MODIFY `upriv_groups_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_privilege_users`
--
ALTER TABLE `user_privilege_users`
  MODIFY `upriv_users_id` smallint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `upro_id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
