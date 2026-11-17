-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2026 at 08:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pembeli` varchar(255) DEFAULT NULL,
  `nomor_meja` varchar(255) DEFAULT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `nama_pembeli`, `nomor_meja`, `menu_id`, `jumlah`, `total_harga`, `created_at`, `updated_at`, `session_id`) VALUES
(19, NULL, NULL, 1, 2, 36000, '2026-06-19 03:30:15', '2026-06-19 03:30:52', 'xMvtXRLF99ErSBPPRecoGsAtAararMVaEnkndnHO');

-- --------------------------------------------------------

--
-- Table structure for table `coffee_consultations`
--

CREATE TABLE `coffee_consultations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `answers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`answers`)),
  `result_summary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`result_summary`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coffee_consultations`
--

INSERT INTO `coffee_consultations` (`id`, `user_id`, `session_id`, `answers`, `result_summary`, `created_at`, `updated_at`) VALUES
(1, NULL, 'vURGTdLZY3vQny8Jk5ajK3ADMHQpKFeKGfszRiNj', '{\"P01\":\"rendah\",\"P02\":\"sedang\",\"P03\":\"ya\",\"P04\":\"ya\",\"P05\":\"ya\",\"P06\":\"dingin\"}', '{\"total_fired\":1,\"has_matches\":true,\"fired_rules\":[{\"id\":2,\"code\":\"R02\",\"name\":\"R02 \\u2014 Caffe Latte\",\"description\":\"Rekomendasi kopi bersusu lembut dengan rasa kopi ringan dan manis sedang.\",\"target_menu_id\":2,\"target_menu_name\":\"Latte\",\"recommended_reason\":\"Perpaduan espresso ringan dengan steamed milk lembut menghasilkan rasa creamy yang pas dan nyaman untuk selera manis sedang.\"}],\"recommended_menus\":[{\"menu_id\":2,\"menu_nama\":\"Latte\",\"reasons\":[\"Perpaduan espresso ringan dengan steamed milk lembut menghasilkan rasa creamy yang pas dan nyaman untuk selera manis sedang.\"],\"matched_rules\":[\"R02 (R02 \\u2014 Caffe Latte)\"]}]}', '2026-10-14 01:00:53', '2026-10-14 01:00:53'),
(2, NULL, 'vURGTdLZY3vQny8Jk5ajK3ADMHQpKFeKGfszRiNj', '{\"P01\":\"sedang\",\"P02\":\"sedang\",\"P03\":\"tidak\",\"P04\":\"tidak\",\"P05\":\"tidak\",\"P06\":\"dingin\"}', '{\"total_fired\":1,\"has_matches\":true,\"fired_rules\":[{\"id\":5,\"code\":\"R05\",\"name\":\"R05 \\u2014 Americano\",\"description\":\"Rekomendasi kopi hitam tanpa susu dengan kekuatan sedang yang bersih dan menyegarkan.\",\"target_menu_id\":1,\"target_menu_name\":\"Americano\",\"recommended_reason\":\"Americano dibuat dari espresso yang diencerkan dengan air, memberikan kopi hitam segar dengan karakter mantap tanpa rasa espresso yang terlalu pekat.\"}],\"recommended_menus\":[{\"menu_id\":1,\"menu_nama\":\"Americano\",\"reasons\":[\"Americano dibuat dari espresso yang diencerkan dengan air, memberikan kopi hitam segar dengan karakter mantap tanpa rasa espresso yang terlalu pekat.\"],\"matched_rules\":[\"R05 (R05 \\u2014 Americano)\"]}]}', '2026-10-14 01:02:07', '2026-10-14 01:02:07');

-- --------------------------------------------------------

--
-- Table structure for table `coffee_questions`
--

CREATE TABLE `coffee_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `question` text NOT NULL,
  `input_type` varchar(50) NOT NULL DEFAULT 'radio',
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`options`)),
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coffee_questions`
--

INSERT INTO `coffee_questions` (`id`, `code`, `question`, `input_type`, `options`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'P01', 'Seberapa kuat rasa kopi yang kamu sukai?', 'radio', '[{\"value\":\"rendah\",\"label\":\"Rendah (Ringan & Lembut)\"},{\"value\":\"sedang\",\"label\":\"Sedang (Pas & Seimbang)\"},{\"value\":\"tinggi\",\"label\":\"Tinggi (Kuat & Pekat)\"}]', 1, 1, '2026-10-14 00:44:58', '2026-10-14 00:44:58'),
(2, 'P02', 'Seberapa manis minuman yang kamu sukai?', 'radio', '[{\"value\":\"rendah\",\"label\":\"Rendah (Sedikit \\/ Pahit Alami)\"},{\"value\":\"sedang\",\"label\":\"Sedang (Manis Pas)\"},{\"value\":\"tinggi\",\"label\":\"Tinggi (Manis Legit)\"}]', 2, 1, '2026-10-14 00:44:58', '2026-10-14 00:44:58'),
(3, 'P03', 'Apakah kamu menyukai susu atau tekstur creamy?', 'radio', '[{\"value\":\"ya\",\"label\":\"Ya (Suka Susu \\/ Creamy)\"},{\"value\":\"tidak\",\"label\":\"Tidak (Kopi Hitam \\/ Murni)\"}]', 3, 1, '2026-10-14 00:44:58', '2026-10-14 00:44:58'),
(4, 'P04', 'Apakah kamu menyukai rasa kopi yang pahit?', 'radio', '[{\"value\":\"ya\",\"label\":\"Ya (Suka Pahit Alami Kopi)\"},{\"value\":\"tidak\",\"label\":\"Tidak (Lebih Suka Ramah di Lidah)\"}]', 4, 1, '2026-10-14 00:44:58', '2026-10-14 00:44:58'),
(5, 'P05', 'Apakah kamu menyukai rasa espresso yang kuat dan dominan?', 'radio', '[{\"value\":\"ya\",\"label\":\"Ya (Espresso Dominan)\"},{\"value\":\"tidak\",\"label\":\"Tidak (Espresso Halus \\/ Ringan)\"}]', 5, 1, '2026-10-14 00:44:58', '2026-10-14 00:44:58'),
(6, 'P06', 'Kamu lebih suka minuman yang disajikan bagaimana?', 'radio', '[{\"value\":\"panas\",\"label\":\"Panas (Hot)\"},{\"value\":\"dingin\",\"label\":\"Dingin (Iced)\"},{\"value\":\"tidak_masalah\",\"label\":\"Tidak Masalah (Bebas)\"}]', 6, 1, '2026-10-14 00:44:58', '2026-10-14 00:44:58');

-- --------------------------------------------------------

--
-- Table structure for table `coffee_rules`
--

CREATE TABLE `coffee_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `target_menu_id` bigint(20) UNSIGNED NOT NULL,
  `recommended_reason` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `priority` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coffee_rules`
--

INSERT INTO `coffee_rules` (`id`, `code`, `name`, `description`, `target_menu_id`, `recommended_reason`, `is_active`, `priority`, `created_at`, `updated_at`) VALUES
(1, 'R01', 'R01 — Espresso Murni', 'Rekomendasi untuk pelanggan pencinta rasa kopi pekat, pahit, tanpa susu, dengan espresso dominan.', 35, 'Espresso murni menyajikan ekstraksi kopi yang sangat kuat, pekat, intens, dan pahit mantap tanpa campuran susu. Sangat ideal bagi penikmat rasa kopi otentik.', 1, 10, '2026-10-14 00:44:58', '2026-10-14 00:44:58'),
(2, 'R02', 'R02 — Caffe Latte', 'Rekomendasi kopi bersusu lembut dengan rasa kopi ringan dan manis sedang.', 2, 'Perpaduan espresso ringan dengan steamed milk lembut menghasilkan rasa creamy yang pas dan nyaman untuk selera manis sedang.', 1, 8, '2026-10-14 00:44:58', '2026-10-14 00:44:58'),
(3, 'R03', 'R03 — Vanilla Latte Manis', 'Rekomendasi varian latte manis beraroma harum vanila untuk penyuka tekstur creamy lembut.', 22, 'Varian latte dengan sentuhan manis sirup vanila lembut, sangat cocok untuk penikmat kopi yang menyukai rasa manis dan tekstur creamy.', 1, 8, '2026-10-14 00:44:58', '2026-10-14 00:44:58'),
(4, 'R04', 'R04 — Cappuccino', 'Rekomendasi perpaduan espresso mantap dengan foam susu tebal dan tekstur kaya.', 8, 'Komposisi seimbang antara espresso yang berkarakter kuat sedang, susu hangat, dan lapisan foam tebal memberikan cita rasa kopi dominan bertekstur kaya.', 1, 9, '2026-10-14 00:44:58', '2026-10-14 00:44:58'),
(5, 'R05', 'R05 — Americano', 'Rekomendasi kopi hitam tanpa susu dengan kekuatan sedang yang bersih dan menyegarkan.', 1, 'Americano dibuat dari espresso yang diencerkan dengan air, memberikan kopi hitam segar dengan karakter mantap tanpa rasa espresso yang terlalu pekat.', 1, 7, '2026-10-14 00:44:59', '2026-10-14 00:44:59'),
(6, 'R06', 'R06 — Kopi Gula Aren Dingin', 'Rekomendasi es kopi susu khas dengan manis legit gula aren disajikan dingin.', 12, 'Pilihan es kopi susu gula aren yang sangat segar disajikan dingin dengan perpaduan manis gurih khas Indonesia.', 1, 6, '2026-10-14 00:44:59', '2026-10-14 00:44:59'),
(7, 'R07', 'R07 — Caffe Mocha Hangat', 'Rekomendasi kopi hangat dengan paduan cokelat pekat dan susu lembut.', 11, 'Minuman perpaduan espresso, susu, dan cokelat pekat yang memberikan rasa hangat dan kenyamanan ekstra saat dinikmati panas.', 1, 6, '2026-10-14 00:44:59', '2026-10-14 00:44:59');

-- --------------------------------------------------------

--
-- Table structure for table `coffee_rule_conditions`
--

CREATE TABLE `coffee_rule_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rule_id` bigint(20) UNSIGNED NOT NULL,
  `question_code` varchar(50) NOT NULL,
  `operator` varchar(20) NOT NULL DEFAULT '=',
  `expected_value` varchar(255) NOT NULL,
  `condition_group` varchar(20) NOT NULL DEFAULT 'AND',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coffee_rule_conditions`
--

INSERT INTO `coffee_rule_conditions` (`id`, `rule_id`, `question_code`, `operator`, `expected_value`, `condition_group`, `created_at`, `updated_at`) VALUES
(45, 1, 'P01', '=', 'tinggi', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(46, 1, 'P04', '=', 'ya', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(47, 1, 'P05', '=', 'ya', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(48, 1, 'P03', '=', 'tidak', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(49, 2, 'P03', '=', 'ya', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(50, 2, 'P01', '=', 'rendah', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(51, 2, 'P02', '=', 'sedang', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(52, 3, 'P03', '=', 'ya', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(53, 3, 'P01', '=', 'rendah', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(54, 3, 'P02', '=', 'tinggi', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(55, 4, 'P03', '=', 'ya', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(56, 4, 'P01', '=', 'sedang', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(57, 4, 'P05', '=', 'ya', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(58, 5, 'P03', '=', 'tidak', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(59, 5, 'P01', '=', 'sedang', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(60, 5, 'P05', '=', 'tidak', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(61, 6, 'P06', '=', 'dingin', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(62, 6, 'P03', '=', 'ya', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(63, 6, 'P02', '=', 'tinggi', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(64, 7, 'P06', '=', 'panas', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(65, 7, 'P03', '=', 'ya', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49'),
(66, 7, 'P01', '=', 'sedang', 'AND', '2026-10-14 00:55:49', '2026-10-14 00:55:49');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"a90e28e6-95c6-4036-82de-92a64c5ab980\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:16;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781614585,\"delay\":null}', 0, NULL, 1781614585, 1781614585),
(2, 'default', '{\"uuid\":\"9c285e77-4024-4765-a764-23e99a4696b0\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:16;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781614601,\"delay\":null}', 0, NULL, 1781614601, 1781614601),
(3, 'default', '{\"uuid\":\"d5153f43-64b6-4f2c-9559-aafb7df33c25\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781614701,\"delay\":null}', 0, NULL, 1781614701, 1781614701),
(4, 'default', '{\"uuid\":\"6d1c4016-8368-4f43-8f9a-1c885704b75b\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:19;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781614973,\"delay\":null}', 0, NULL, 1781614973, 1781614973),
(5, 'default', '{\"uuid\":\"d42e7211-5186-4fa8-a65f-d31ba0997da0\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:20;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781614974,\"delay\":null}', 0, NULL, 1781614974, 1781614974),
(6, 'default', '{\"uuid\":\"24e534c9-8bea-4f76-af65-a5065a1e9cdb\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781614976,\"delay\":null}', 0, NULL, 1781614976, 1781614976),
(7, 'default', '{\"uuid\":\"b297c421-9805-4f8d-9a9b-f55a45261e3f\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:43;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781771821,\"delay\":null}', 0, NULL, 1781771821, 1781771821),
(8, 'default', '{\"uuid\":\"a73ad51f-dd1f-4066-ac31-39b0b73bfedd\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:42;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781771831,\"delay\":null}', 0, NULL, 1781771831, 1781771831),
(9, 'default', '{\"uuid\":\"3000c9ee-a07d-40ee-b15d-ec44bceccb7b\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:41;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781771833,\"delay\":null}', 0, NULL, 1781771833, 1781771833),
(10, 'default', '{\"uuid\":\"e4cb6b81-92d1-4e7b-a630-9d8cd460f0dc\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:41;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781772396,\"delay\":null}', 0, NULL, 1781772396, 1781772396),
(11, 'default', '{\"uuid\":\"a2e115ca-4c4e-4b21-95db-14d54528c4c8\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:44;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781774978,\"delay\":null}', 0, NULL, 1781774978, 1781774978),
(12, 'default', '{\"uuid\":\"2ce485e6-80a0-40d6-9fa4-b3ba779c2278\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:44;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781774983,\"delay\":null}', 0, NULL, 1781774983, 1781774983),
(13, 'default', '{\"uuid\":\"12744851-6163-4b64-89d1-8ebeb4e7d9e1\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:52;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781837495,\"delay\":null}', 0, NULL, 1781837495, 1781837495),
(14, 'default', '{\"uuid\":\"8509be10-1401-4943-a92b-f33a6c6dd321\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:50;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781837498,\"delay\":null}', 0, NULL, 1781837498, 1781837498),
(15, 'default', '{\"uuid\":\"50390ab6-dd37-4757-b0b4-d420e90cd41f\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:50;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781837502,\"delay\":null}', 0, NULL, 1781837502, 1781837502),
(16, 'default', '{\"uuid\":\"f1a8c579-a84a-4b9d-8f2a-81fdf56cd02d\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:55;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1781848575,\"delay\":null}', 0, NULL, 1781848576, 1781848576),
(17, 'default', '{\"uuid\":\"7f40816a-edd1-4de7-a59d-9b124d6540ae\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:56;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1782017870,\"delay\":null}', 0, NULL, 1782017870, 1782017870),
(18, 'default', '{\"uuid\":\"df8d6274-3814-4331-9666-9d0fcedfd8d5\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:56;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1782017871,\"delay\":null}', 0, NULL, 1782017871, 1782017871),
(19, 'default', '{\"uuid\":\"1435608a-6998-433f-a940-e0fd4da4f14b\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:61;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1783326413,\"delay\":null}', 0, NULL, 1783326413, 1783326413),
(20, 'default', '{\"uuid\":\"2249c122-f200-4cd8-b4b8-bb7cab678fcc\",\"displayName\":\"App\\\\Events\\\\StatusPesananUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:31:\\\"App\\\\Events\\\\StatusPesananUpdated\\\":1:{s:7:\\\"pesanan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Pesanan\\\";s:2:\\\"id\\\";i:61;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1783326416,\"delay\":null}', 0, NULL, 1783326416, 1783326416);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kopi` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `jenis_menu` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `nama_kopi`, `harga`, `deskripsi`, `gambar`, `created_at`, `updated_at`, `kategori`, `jenis_menu`, `is_active`) VALUES
(1, 'Americano', 18000, 'Espresso yang dicampur air panas sehingga lebih ringan.', '1781423808.jpg', '2026-06-04 10:50:16', '2026-06-14 00:56:48', 'Espresso', 'Coffee', 1),
(2, 'Latte', 24000, 'Espresso dengan susu lebih banyak dan foam tipis.', '1780897260.jpg', '2026-06-04 10:50:47', '2026-06-13 23:48:37', 'Latte', 'Coffee', 1),
(3, 'Matcha Latte', 25000, 'Perpaduan matcha dan latte dengan rasa unik.', '1781424500.jpg', '2026-06-04 10:51:16', '2026-06-14 01:08:20', 'Matcha', 'Non Coffee', 1),
(5, 'Lemon Tea', 18000, 'Teh segar dengan campuran lemon.', '1780897796.jpg', '2026-06-05 21:47:48', '2026-07-05 10:24:08', 'Tea', 'Non Coffee', 1),
(6, 'Caramel Macchiato', 24000, 'Latte dengan tambahan sirup karamel dan foam susu.', '1781424559.jpg', '2026-06-07 22:51:18', '2026-06-14 01:09:19', 'Latte', 'Coffee', 1),
(8, 'Capuccino', 22000, 'Perpaduan espresso, susu steamed, dan foam susu tebal.', '1781246696.jpg', '2026-06-11 23:44:56', '2026-06-14 00:38:26', 'Capucchino', 'Coffee', 1),
(9, 'Taro Milk', 20000, 'Susu dengan rasa taro yang creamy dan manis.', '1781417697.jpg', '2026-06-13 23:14:58', '2026-06-14 00:07:50', 'Milk Based', 'Non Coffee', 1),
(11, 'Mocha', 24000, 'Campuran espresso, susu, dan cokelat manis.', '1781422786.jpg', '2026-06-14 00:39:46', '2026-06-14 00:39:46', 'Chocolate Coffee', 'Coffee', 1),
(12, 'Kopi Gula Aren', 19000, 'Espresso dengan susu dan gula aren khas Indonesia.', '1781422928.jpg', '2026-06-14 00:42:08', '2026-06-14 00:42:08', 'Signature Coffee', 'Coffee', 1),
(13, 'Affogato', 26000, 'Espresso yang disiram di atas es krim vanilla.', '1781423133.jpg', '2026-06-14 00:45:33', '2026-06-14 00:45:33', 'Dessert Coffee', 'Coffee', 1),
(14, 'Matcha Espresso Fusion', 26000, 'Perpaduan matcha dan espresso dengan rasa unik.', '1781424440.jpg', '2026-06-14 00:47:56', '2026-06-14 01:07:20', 'Signature Coffee', 'Coffee', 1),
(15, 'Chocolate Latte', 20000, 'Cokelat dengan rasa manis dan lembut.', '1781423454.jpg', '2026-06-14 00:50:54', '2026-06-14 00:50:54', 'Chocolate', 'Non Coffee', 1),
(16, 'Lychee Tea', 21000, 'Teh manis dengan rasa buah leci yang segar.', '1781423565.jpg', '2026-06-14 00:52:45', '2026-06-14 00:52:55', 'Fruit Tea', 'Non Coffee', 1),
(17, 'Peach Tea', 21000, 'Teh buah peach dengan rasa ringan dan manis.', '1781423650.jpg', '2026-06-14 00:54:10', '2026-06-14 00:54:10', 'Fruit Tea', 'Non Coffee', 1),
(18, 'Strawberry Milk', 20000, 'Susu stroberi creamy dengan rasa segar.', '1781423748.jpg', '2026-06-14 00:55:48', '2026-06-14 00:55:48', 'Milk Based', 'Non Coffee', 1),
(19, 'Blue Ocean', 27000, 'Soda biru segar dengan lemon dan mint.', '1781423909.jpg', '2026-06-14 00:58:29', '2026-06-14 00:58:29', 'Mocktail', 'Non Coffee', 1),
(20, 'Mojito Mint', 27000, 'Minuman soda mint dan lemon tanpa alkohol.', '1781424001.jpg', '2026-06-14 01:00:01', '2026-06-14 01:00:01', 'Mocktail', 'Non Coffee', 1),
(21, 'Red Velvet Latte', 20000, 'Minuman susu dengan rasa red velvet khas.', '1781424112.jpg', '2026-06-14 01:01:52', '2026-06-14 01:01:52', 'Milk Based', 'Non Coffee', 1),
(22, 'Vanilla Latte', 25000, 'Latte creamy dengan aroma vanilla yang lembut', '1781424215.jpg', '2026-06-14 01:03:35', '2026-06-14 01:03:35', 'Latte', 'Coffee', 1),
(23, 'Hazelnut Coffee', 24000, 'Kopi susu dengan rasa kacang hazelnut yang manis.', '1781424328.jpg', '2026-06-14 01:05:28', '2026-06-14 01:05:28', 'Flavored Coffee', 'Coffee', 1),
(24, 'French Fries', 15000, 'Kentang goreng crispy dengan saus sambal dan mayo.', '1781494538.jpg', '2026-06-14 20:35:38', '2026-06-14 21:33:18', 'Snack', 'Makanan', 1),
(25, 'Chicken Wings', 22000, 'Sayap ayam pedas manis dengan bumbu khas.', '1781497421.jpg', '2026-06-14 21:23:41', '2026-06-14 21:23:41', 'Snack', 'Makanan', 1),
(26, 'Chicken Katsu', 24000, 'Ayam crispy dengan nasi dan saus katsu.', '1781497557.jpg', '2026-06-14 21:25:57', '2026-06-14 21:25:57', 'Main Course', 'Makanan', 1),
(27, 'Beef Teriyaki Bowl', 25000, 'Nasi dengan irisan daging dan saus teriyaki.', '1781497666.jpg', '2026-06-14 21:27:46', '2026-06-14 21:27:46', 'Rice Bowl', 'Makanan', 1),
(28, 'Rice Bowl Sambal Matah', 24000, 'Nasi dengan ayam crispy dan sambal matah segar.', '1781497761.jpg', '2026-06-14 21:29:21', '2026-06-14 21:29:53', 'Rice Bowl', 'Makanan', 1),
(29, 'Pisang Cokelat', 15000, 'Pisang goreng dengan topping cokelat dan keju.', '1781497872.jpg', '2026-06-14 21:31:12', '2026-06-14 21:31:12', 'Dessert', 'Makanan', 1),
(30, 'Brownies Ice Cream', 20000, 'Brownies cokelat hangat dengan es krim vanilla', '1781497976.jpg', '2026-06-14 21:32:56', '2026-06-14 21:32:56', 'Dessert', 'Makanan', 1),
(31, 'Chicken Steak', 26000, 'Steak ayam dengan kentang dan saus mushroom.', '1781498108.jpg', '2026-06-14 21:34:26', '2026-06-14 21:35:08', 'Main Course', 'Makanan', 1),
(32, 'Burger Beef', 23000, 'Burger daging sapi dengan sayur dan keju.', '1781498198.jpg', '2026-06-14 21:36:38', '2026-06-14 21:36:38', 'Fast Food', 'Makanan', 1),
(33, 'Chicken Burger', 22000, 'Burger ayam crispy dengan saus spesial.', '1781498270.jpg', '2026-06-14 21:37:50', '2026-06-14 21:37:50', 'Fast Food', 'Makanan', 1),
(35, 'Espresso', 18000, 'Ekstrak kopi murni yang pekat, tebal, dengan crema keemasan dan rasa yang intens.', '1781423808.jpg', '2026-10-14 00:44:58', '2026-10-14 00:44:58', 'Espresso', 'Coffee', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_04_101236_create_menus_table', 1),
(5, '2026_06_04_164725_add_kategori_to_menus_table', 1),
(6, '2026_06_04_171822_create_penjualans_table', 1),
(7, '2026_06_14_060735_add_jenis_menu_to_menus_table', 2),
(8, '2026_06_14_081534_create_carts_table', 3),
(9, '2026_06_14_103825_create_pesanans_table', 4),
(10, '2026_06_14_112051_add_status_to_pesanans_table', 5),
(11, '2026_06_14_112630_add_nomor_meja_to_carts_table', 6),
(12, '2026_06_15_045722_create_reservasis_table', 7),
(13, '2026_06_15_071743_add_payment_to_pesanans_table', 8),
(14, '2026_06_18_070156_add_kode_pesanan_to_pesanans_table', 9),
(15, '2026_06_18_072420_add_session_id_to_carts_table', 10),
(16, '2026_06_19_061515_add_role_to_users_table', 11),
(17, '2026_10_14_000001_add_is_active_to_menus_table', 12),
(18, '2026_10_14_000002_create_coffee_expert_system_tables', 12);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjualans`
--

CREATE TABLE `penjualans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pembeli` varchar(255) NOT NULL,
  `nama_kopi` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penjualans`
--

INSERT INTO `penjualans` (`id`, `nama_pembeli`, `nama_kopi`, `jumlah`, `harga`, `total`, `created_at`, `updated_at`) VALUES
(16, 'fahmi', 'Americano', 1, 18000, 18000, '2026-10-14 01:02:22', '2026-10-14 01:02:22');

-- --------------------------------------------------------

--
-- Table structure for table `pesanans`
--

CREATE TABLE `pesanans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Menunggu',
  `nama_pembeli` varchar(255) NOT NULL,
  `nomor_meja` varchar(255) NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `total_harga` bigint(255) NOT NULL,
  `metode_pembayaran` varchar(255) DEFAULT NULL,
  `status_pembayaran` varchar(255) NOT NULL DEFAULT 'Belum Dibayar',
  `kode_pesanan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesanans`
--

INSERT INTO `pesanans` (`id`, `jumlah`, `created_at`, `updated_at`, `status`, `nama_pembeli`, `nomor_meja`, `menu_id`, `total_harga`, `metode_pembayaran`, `status_pembayaran`, `kode_pesanan`) VALUES
(50, 2, '2026-06-18 19:50:51', '2026-06-18 19:51:42', 'Selesai', 'fahmi', '1', 1, 36000, NULL, 'Sudah Dibayar', 'INV1781837451'),
(51, 1, '2026-06-18 19:50:51', '2026-06-18 19:50:51', 'Menunggu', 'fahmi', '1', 18, 20000, NULL, 'Belum Dibayar', 'INV1781837451'),
(52, 1, '2026-06-18 19:51:19', '2026-06-18 19:51:40', 'Diproses', 'budi', '2', 23, 24000, NULL, 'Sudah Dibayar', 'INV1781837479'),
(53, 1, '2026-06-18 19:51:19', '2026-06-18 19:51:19', 'Menunggu', 'budi', '2', 27, 25000, NULL, 'Belum Dibayar', 'INV1781837479'),
(54, 1, '2026-06-18 19:51:19', '2026-06-18 19:51:19', 'Menunggu', 'budi', '2', 29, 15000, NULL, 'Belum Dibayar', 'INV1781837479'),
(55, 1, '2026-06-18 22:56:00', '2026-06-18 22:56:14', 'Diproses', 'mutaqin', '3', 1, 18000, NULL, 'Sudah Dibayar', 'INV1781848560'),
(56, 3, '2026-06-20 21:57:42', '2026-06-20 21:57:51', 'Selesai', 'fahmi', '1', 6, 72000, NULL, 'Sudah Dibayar', 'INV1782017862'),
(57, 1, '2026-07-02 00:36:12', '2026-07-02 00:36:12', 'Menunggu', 'fahmi', '1', 13, 26000, NULL, 'Belum Dibayar', 'INV1782977772'),
(58, 2, '2026-07-02 00:36:12', '2026-07-02 00:36:12', 'Menunggu', 'fahmi', '1', 12, 38000, NULL, 'Belum Dibayar', 'INV1782977772'),
(59, 1, '2026-07-05 10:01:13', '2026-07-05 10:01:13', 'Menunggu', 'fahmi', '1', 1, 18000, NULL, 'Belum Dibayar', 'INV1783270873'),
(60, 1, '2026-07-05 10:56:31', '2026-07-05 10:56:31', 'Menunggu', 'fahmi', '1', 17, 21000, NULL, 'Belum Dibayar', 'INV1783274191'),
(61, 2, '2026-07-06 01:25:13', '2026-07-06 01:26:56', 'Selesai', 'fahmi', '1', 2, 48000, NULL, 'Sudah Dibayar', 'INV1783326313');

-- --------------------------------------------------------

--
-- Table structure for table `reservasis`
--

CREATE TABLE `reservasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `nomor_meja` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `jumlah_orang` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservasis`
--

INSERT INTO `reservasis` (`id`, `nama`, `telepon`, `nomor_meja`, `tanggal`, `jam`, `jumlah_orang`, `catatan`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Fahmi Mutaqin', '0895344289935', 1, '2026-06-19', '09:52:00', 4, 'halo', 'Disetujui', '2026-06-18 19:52:16', '2026-06-18 19:53:00'),
(7, 'bahlul', '0895344289935', 2, '2026-06-20', '15:58:00', 2, 'note', 'Disetujui', '2026-06-18 19:52:46', '2026-07-02 01:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('uf196HI9StDG1OooVCrJAQh9Qk0vhmRuvV0TEfjZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMEVxTjlxT21CSmJFbWpYZHlwZVExdHdDd1RTSzJ5SGdCcHVBc2lhMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWtvbWVuZGFzaS9rb25zdWx0YXNpIjtzOjU6InJvdXRlIjtzOjIyOiJyZWtvbWVuZGFzaS5rb25zdWx0YXNpIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1794898999),
('vURGTdLZY3vQny8Jk5ajK3ADMHQpKFeKGfszRiNj', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMmVSVm51OFBoWGV6aVluSEluTlpEOVRVQ0FidTJQZFhQUTJoeXZFSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZW51LXBlbGFuZ2dhbiI7czo1OiJyb3V0ZSI7czoxNDoicGVsYW5nZ2FuLm1lbnUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjI4OiJjb2ZmZWVfcmVjb21tZW5kYXRpb25fcmVzdWx0IjthOjY6e3M6NToiZmFjdHMiO2E6MTQ6e3M6MzoicDAxIjtzOjY6InNlZGFuZyI7czoxMzoia2VrdWF0YW5fa29waSI7czo2OiJzZWRhbmciO3M6MzoicDAyIjtzOjY6InNlZGFuZyI7czo5OiJrZW1hbmlzYW4iO3M6Njoic2VkYW5nIjtzOjM6InAwMyI7czo1OiJ0aWRhayI7czo5OiJzdWthX3N1c3UiO3M6NToidGlkYWsiO3M6MzoicDA0IjtzOjU6InRpZGFrIjtzOjk6ImtlcGFoaXRhbiI7czo1OiJ0aWRhayI7czozOiJwMDUiO3M6NToidGlkYWsiO3M6MTM6InN1a2FfZXNwcmVzc28iO3M6NToidGlkYWsiO3M6MzoicDA2IjtzOjY6ImRpbmdpbiI7czo0OiJzdWh1IjtzOjY6ImRpbmdpbiI7czoxNDoicnVsZV9maXJlZF9yMDUiO2I6MTtzOjE4OiJyZWNvbW1lbmRlZF9tZW51XzEiO2I6MTt9czoxMjoidXNlcl9hbnN3ZXJzIjthOjY6e3M6MzoiUDAxIjtzOjY6InNlZGFuZyI7czozOiJQMDIiO3M6Njoic2VkYW5nIjtzOjM6IlAwMyI7czo1OiJ0aWRhayI7czozOiJQMDQiO3M6NToidGlkYWsiO3M6MzoiUDA1IjtzOjU6InRpZGFrIjtzOjM6IlAwNiI7czo2OiJkaW5naW4iO31zOjExOiJmaXJlZF9ydWxlcyI7YToxOntpOjA7YTo3OntzOjI6ImlkIjtpOjU7czo0OiJjb2RlIjtzOjM6IlIwNSI7czo0OiJuYW1lIjtzOjE3OiJSMDUg4oCUIEFtZXJpY2FubyI7czoxMToiZGVzY3JpcHRpb24iO3M6ODU6IlJla29tZW5kYXNpIGtvcGkgaGl0YW0gdGFucGEgc3VzdSBkZW5nYW4ga2VrdWF0YW4gc2VkYW5nIHlhbmcgYmVyc2loIGRhbiBtZW55ZWdhcmthbi4iO3M6MTQ6InRhcmdldF9tZW51X2lkIjtpOjE7czoxNjoidGFyZ2V0X21lbnVfbmFtZSI7czo5OiJBbWVyaWNhbm8iO3M6MTg6InJlY29tbWVuZGVkX3JlYXNvbiI7czoxNDk6IkFtZXJpY2FubyBkaWJ1YXQgZGFyaSBlc3ByZXNzbyB5YW5nIGRpZW5jZXJrYW4gZGVuZ2FuIGFpciwgbWVtYmVyaWthbiBrb3BpIGhpdGFtIHNlZ2FyIGRlbmdhbiBrYXJha3RlciBtYW50YXAgdGFucGEgcmFzYSBlc3ByZXNzbyB5YW5nIHRlcmxhbHUgcGVrYXQuIjt9fXM6MTU6InJlY29tbWVuZGF0aW9ucyI7YToxOntpOjA7YTo0OntzOjQ6Im1lbnUiO086MTU6IkFwcFxNb2RlbHNcTWVudSI6MzM6e3M6MTM6IgAqAGNvbm5lY3Rpb24iO3M6NToibXlzcWwiO3M6ODoiACoAdGFibGUiO3M6NToibWVudXMiO3M6MTM6IgAqAHByaW1hcnlLZXkiO3M6MjoiaWQiO3M6MTA6IgAqAGtleVR5cGUiO3M6MzoiaW50IjtzOjEyOiJpbmNyZW1lbnRpbmciO2I6MTtzOjc6IgAqAHdpdGgiO2E6MDp7fXM6MTI6IgAqAHdpdGhDb3VudCI7YTowOnt9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YToxMDp7czoyOiJpZCI7aToxO3M6OToibmFtYV9rb3BpIjtzOjk6IkFtZXJpY2FubyI7czo1OiJoYXJnYSI7aToxODAwMDtzOjk6ImRlc2tyaXBzaSI7czo1NToiRXNwcmVzc28geWFuZyBkaWNhbXB1ciBhaXIgcGFuYXMgc2VoaW5nZ2EgbGViaWggcmluZ2FuLiI7czo2OiJnYW1iYXIiO3M6MTQ6IjE3ODE0MjM4MDguanBnIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI2LTA2LTA0IDE3OjUwOjE2IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI2LTA2LTE0IDA3OjU2OjQ4IjtzOjg6ImthdGVnb3JpIjtzOjg6IkVzcHJlc3NvIjtzOjEwOiJqZW5pc19tZW51IjtzOjY6IkNvZmZlZSI7czo5OiJpc19hY3RpdmUiO2k6MTt9czoxMToiACoAb3JpZ2luYWwiO2E6MTA6e3M6MjoiaWQiO2k6MTtzOjk6Im5hbWFfa29waSI7czo5OiJBbWVyaWNhbm8iO3M6NToiaGFyZ2EiO2k6MTgwMDA7czo5OiJkZXNrcmlwc2kiO3M6NTU6IkVzcHJlc3NvIHlhbmcgZGljYW1wdXIgYWlyIHBhbmFzIHNlaGluZ2dhIGxlYmloIHJpbmdhbi4iO3M6NjoiZ2FtYmFyIjtzOjE0OiIxNzgxNDIzODA4LmpwZyI7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyNi0wNi0wNCAxNzo1MDoxNiI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyNi0wNi0xNCAwNzo1Njo0OCI7czo4OiJrYXRlZ29yaSI7czo4OiJFc3ByZXNzbyI7czoxMDoiamVuaXNfbWVudSI7czo2OiJDb2ZmZWUiO3M6OToiaXNfYWN0aXZlIjtpOjE7fXM6MTA6IgAqAGNoYW5nZXMiO2E6MDp7fXM6MTE6IgAqAHByZXZpb3VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjE6e3M6OToiaXNfYWN0aXZlIjtzOjc6ImJvb2xlYW4iO31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czoyMToiACoAYXR0cmlidXRlQ2FzdENhY2hlIjthOjA6e31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6MDp7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6MDp7fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6Mjc6IgAqAHJlbGF0aW9uQXV0b2xvYWRDYWxsYmFjayI7TjtzOjI2OiIAKgByZWxhdGlvbkF1dG9sb2FkQ29udGV4dCI7TjtzOjEwOiJ0aW1lc3RhbXBzIjtiOjE7czoxMzoidXNlc1VuaXF1ZUlkcyI7YjowO3M6OToiACoAaGlkZGVuIjthOjA6e31zOjEwOiIAKgB2aXNpYmxlIjthOjA6e31zOjExOiIAKgBmaWxsYWJsZSI7YTo3OntpOjA7czo5OiJuYW1hX2tvcGkiO2k6MTtzOjU6ImhhcmdhIjtpOjI7czo5OiJkZXNrcmlwc2kiO2k6MztzOjY6ImdhbWJhciI7aTo0O3M6ODoia2F0ZWdvcmkiO2k6NTtzOjEwOiJqZW5pc19tZW51IjtpOjY7czo5OiJpc19hY3RpdmUiO31zOjEwOiIAKgBndWFyZGVkIjthOjE6e2k6MDtzOjE6IioiO319czo3OiJyZWFzb25zIjthOjE6e2k6MDtzOjE0OToiQW1lcmljYW5vIGRpYnVhdCBkYXJpIGVzcHJlc3NvIHlhbmcgZGllbmNlcmthbiBkZW5nYW4gYWlyLCBtZW1iZXJpa2FuIGtvcGkgaGl0YW0gc2VnYXIgZGVuZ2FuIGthcmFrdGVyIG1hbnRhcCB0YW5wYSByYXNhIGVzcHJlc3NvIHlhbmcgdGVybGFsdSBwZWthdC4iO31zOjEzOiJtYXRjaGVkX3J1bGVzIjthOjE6e2k6MDtzOjIzOiJSMDUgKFIwNSDigJQgQW1lcmljYW5vKSI7fXM6MTg6InNlcnZpbmdfc3VnZ2VzdGlvbiI7czoyMToiRGlzYWppa2FuIERpbmdpbiAoRXMpIjt9fXM6MTE6InRvdGFsX2ZpcmVkIjtpOjE7czoxMToiaGFzX21hdGNoZXMiO2I6MTt9czoyNDoiY29mZmVlX3JlY29tbWVuZGF0aW9uX2lkIjtpOjI7fQ==', 1791964945),
('YzFPJ2nKO9gXSemoSgV5vHIGxcoeqATd1deX49b6', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidW9nQTgxc1pJYTFLVXpwVXp4NnZvWWVUbHRDSWZNcnlySEIwUzBUdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZW51LXBlbGFuZ2dhbiI7czo1OiJyb3V0ZSI7czoxNDoicGVsYW5nZ2FuLm1lbnUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1790837758);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'pelanggan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'fahmi', 'fahmi@gmail.com', NULL, '$2y$12$gvaH7w0TQXedSY6iXRdvBeM2hGKhfG2O5HqDI0cUB7vNZCwQgdkzm', NULL, '2026-06-04 10:48:49', '2026-06-04 10:48:49', 'pelanggan'),
(2, 'Atmin', 'atmin@gmail.com', NULL, '$2y$12$1nxH8KCYR7byvJ5.v/E/6uXpzPjxXpVEUMtq5U/I2WJ6Bs7BIl5wO', NULL, '2026-06-05 00:54:24', '2026-06-05 00:54:24', 'pelanggan'),
(3, 'admin', 'admin@gmail.com', NULL, '$2y$12$6He7YkpsLYmRoD2omCLjyOVNdyrHQfhH/8kellASTqo6H0tc0akvK', NULL, '2026-09-30 23:14:13', '2026-10-14 00:44:58', 'admin'),
(4, 'Test User', 'test@example.com', NULL, '$2y$12$jmZhRU3GqM4AAjZ/vYa85udmWTD9fc6iBY8uQuc4vH6ZuSGPfpzey', NULL, '2026-10-14 00:55:49', '2026-10-14 00:55:49', 'pelanggan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `coffee_consultations`
--
ALTER TABLE `coffee_consultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coffee_consultations_user_id_foreign` (`user_id`),
  ADD KEY `coffee_consultations_session_id_index` (`session_id`);

--
-- Indexes for table `coffee_questions`
--
ALTER TABLE `coffee_questions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coffee_questions_code_unique` (`code`);

--
-- Indexes for table `coffee_rules`
--
ALTER TABLE `coffee_rules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coffee_rules_code_unique` (`code`),
  ADD KEY `coffee_rules_target_menu_id_foreign` (`target_menu_id`);

--
-- Indexes for table `coffee_rule_conditions`
--
ALTER TABLE `coffee_rule_conditions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coffee_rule_conditions_rule_id_foreign` (`rule_id`),
  ADD KEY `coffee_rule_conditions_question_code_index` (`question_code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penjualans`
--
ALTER TABLE `penjualans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanans`
--
ALTER TABLE `pesanans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservasis`
--
ALTER TABLE `reservasis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `coffee_consultations`
--
ALTER TABLE `coffee_consultations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coffee_questions`
--
ALTER TABLE `coffee_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `coffee_rules`
--
ALTER TABLE `coffee_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `coffee_rule_conditions`
--
ALTER TABLE `coffee_rule_conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `penjualans`
--
ALTER TABLE `penjualans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pesanans`
--
ALTER TABLE `pesanans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `reservasis`
--
ALTER TABLE `reservasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coffee_consultations`
--
ALTER TABLE `coffee_consultations`
  ADD CONSTRAINT `coffee_consultations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `coffee_rules`
--
ALTER TABLE `coffee_rules`
  ADD CONSTRAINT `coffee_rules_target_menu_id_foreign` FOREIGN KEY (`target_menu_id`) REFERENCES `menus` (`id`);

--
-- Constraints for table `coffee_rule_conditions`
--
ALTER TABLE `coffee_rule_conditions`
  ADD CONSTRAINT `coffee_rule_conditions_rule_id_foreign` FOREIGN KEY (`rule_id`) REFERENCES `coffee_rules` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
