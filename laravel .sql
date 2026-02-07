-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20250715.4ccd84bc02
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 07, 2026 at 08:08 AM
-- Server version: 5.7.39
-- PHP Version: 8.3.29

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
-- Table structure for table `arguments`
--

CREATE TABLE `arguments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `debate_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `side` enum('pro','con') COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reply_type` enum('agree','disagree','neutral') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'neutral',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `arguments`
--

INSERT INTO `arguments` (`id`, `debate_id`, `user_id`, `side`, `body`, `parent_id`, `reply_type`, `created_at`, `updated_at`) VALUES
(3, 2, 1, 'pro', 'yes', NULL, 'neutral', '2026-02-02 06:02:58', '2026-02-02 06:02:58'),
(4, 2, 1, 'con', 'no', NULL, 'neutral', '2026-02-02 06:03:06', '2026-02-02 06:03:06'),
(5, 2, 1, 'pro', 'dfd', NULL, 'neutral', '2026-02-02 06:03:23', '2026-02-02 06:03:23'),
(6, 2, 1, 'pro', 'sfdgd', NULL, 'neutral', '2026-02-02 06:03:26', '2026-02-02 06:03:26'),
(7, 2, 1, 'pro', 'fdgdhf', NULL, 'neutral', '2026-02-05 01:00:05', '2026-02-05 01:00:05'),
(8, 2, 1, 'con', 'fghnfg', NULL, 'neutral', '2026-02-05 01:00:10', '2026-02-05 01:00:10'),
(9, 2, 1, 'pro', 'dfsdfd', NULL, 'agree', '2026-02-05 04:46:45', '2026-02-05 04:46:45'),
(10, 2, 1, 'pro', 'dsdfd', NULL, 'agree', '2026-02-05 04:50:59', '2026-02-05 04:50:59'),
(11, 2, 1, 'pro', 'naa', 10, 'neutral', '2026-02-07 00:34:11', '2026-02-07 00:34:11'),
(12, 2, 1, 'pro', 'dsdfsf', 11, 'neutral', '2026-02-07 00:35:18', '2026-02-07 00:35:18'),
(13, 2, 1, 'pro', 'ASDADFSF', 9, 'neutral', '2026-02-07 00:35:41', '2026-02-07 00:35:41'),
(14, 2, 1, 'pro', 'SDAFDFGDG', NULL, 'neutral', '2026-02-07 00:36:03', '2026-02-07 00:36:03'),
(15, 2, 1, 'pro', 'fdgfdhfgh', NULL, 'neutral', '2026-02-07 00:54:54', '2026-02-07 00:54:54'),
(16, 2, 1, 'pro', 'fdghf', 8, 'neutral', '2026-02-07 00:55:27', '2026-02-07 00:55:27'),
(17, 2, 1, 'pro', 'ghfhfgy', 12, 'neutral', '2026-02-07 01:19:15', '2026-02-07 01:19:15'),
(18, 2, 1, 'pro', 'hkjojkjhuh', 4, 'neutral', '2026-02-07 02:06:43', '2026-02-07 02:06:43');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-logicallydebate@gmail.com|127.0.0.1', 'i:1;', 1770025917),
('laravel-cache-logicallydebate@gmail.com|127.0.0.1:timer', 'i:1770025917;', 1770025917);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `debates`
--

CREATE TABLE `debates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_participants` int(11) DEFAULT NULL,
  `status` enum('active','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `winner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `debates`
--

INSERT INTO `debates` (`id`, `title`, `description`, `max_participants`, `status`, `winner_id`, `created_at`, `updated_at`) VALUES
(2, 'Is the Quran the latest, unchanged and true holy book?', 'Is the Quran the latest, unchanged and true holy book?', 2, 'active', NULL, '2026-02-02 02:07:19', '2026-02-02 05:56:41');

-- --------------------------------------------------------

--
-- Table structure for table `debate_participants`
--

CREATE TABLE `debate_participants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `debate_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `side` enum('pro','con') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `debate_participants`
--

INSERT INTO `debate_participants` (`id`, `debate_id`, `user_id`, `side`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'pro', '2026-02-07 00:54:42', '2026-02-07 00:54:42');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_02_055623_create_debates_table', 1),
(5, '2026_02_02_055635_create_arguments_table', 1),
(6, '2026_02_02_055641_create_votes_table', 1),
(7, '2026_02_02_110200_create_debate_participants_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CG7qrxfeTM2eXofC6NtGkvpoQUsk65HBy9ykeOLE', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidkhDNlpVRUNOSTFGNWdKSld1dkdCSm5XcjhGenlnVXltZnNEUWV5dyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9sb2dpYy1kZWJhdGUudGVzdCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1770451603);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `avatar`) VALUES
(1, 'Logically Debate Admin', 'admin@gmail.com', '2026-02-02 00:06:17', '$2y$12$FEoB0/q7h.DWK3Et6q1mc.GtZ/CpXaNnc.IdbFmTw8PJFySzfn3rG', 'admin', '3fig9BfdMM9mGjkroDspgb3tb0saCz0oAjAwxOKFGYDNTTAWDhCVKUyaxrab', '2026-02-02 00:06:18', '2026-02-02 00:06:18', NULL),
(2, 'Romana Idress Ekfa', 'logicallydebate@gmail.com', NULL, '$2y$12$.YXnYTHRKvuB.zUX5EIrXuesAf88vuKIc.SU6P3UwiTuRFIXhWyB2', 'user', NULL, '2026-02-02 00:07:58', '2026-02-02 00:07:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `argument_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('agree','disagree') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `argument_id`, `type`, `created_at`, `updated_at`) VALUES
(2, 1, 3, 'disagree', '2026-02-02 06:03:12', '2026-02-05 00:50:30'),
(3, 1, 4, 'agree', '2026-02-02 06:03:18', '2026-02-05 00:47:38'),
(4, 1, 5, 'disagree', '2026-02-05 00:50:33', '2026-02-05 00:50:37'),
(5, 1, 10, 'agree', '2026-02-05 05:10:18', '2026-02-05 05:10:18'),
(6, 1, 9, 'agree', '2026-02-07 00:17:16', '2026-02-07 00:17:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arguments`
--
ALTER TABLE `arguments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arguments_debate_id_foreign` (`debate_id`),
  ADD KEY `arguments_user_id_foreign` (`user_id`),
  ADD KEY `arguments_parent_id_foreign` (`parent_id`);

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
-- Indexes for table `debates`
--
ALTER TABLE `debates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `debate_participants`
--
ALTER TABLE `debate_participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `debate_participants_debate_id_user_id_unique` (`debate_id`,`user_id`),
  ADD KEY `debate_participants_user_id_foreign` (`user_id`);

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
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `votes_user_id_argument_id_unique` (`user_id`,`argument_id`),
  ADD KEY `votes_argument_id_foreign` (`argument_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arguments`
--
ALTER TABLE `arguments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `debates`
--
ALTER TABLE `debates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `debate_participants`
--
ALTER TABLE `debate_participants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `arguments`
--
ALTER TABLE `arguments`
  ADD CONSTRAINT `arguments_debate_id_foreign` FOREIGN KEY (`debate_id`) REFERENCES `debates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `arguments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `arguments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `arguments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `debate_participants`
--
ALTER TABLE `debate_participants`
  ADD CONSTRAINT `debate_participants_debate_id_foreign` FOREIGN KEY (`debate_id`) REFERENCES `debates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `debate_participants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_argument_id_foreign` FOREIGN KEY (`argument_id`) REFERENCES `arguments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
