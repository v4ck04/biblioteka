-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 28, 2026 at 11:58 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biblioteka`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `author` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `total_copies` int UNSIGNED NOT NULL,
  `available_copies` int UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `books_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category_id`, `total_copies`, `available_copies`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Na Drini ćuprija', 'Ivo Andrić', 1, 5, 3, 'books/wMSJccG5iEWpRiRlvtF4hJ51l4eWJBbLFAimMZ2h.webp', '2026-05-20 19:55:26', '2026-05-25 17:01:01'),
(2, 'Travnička hronika', 'Ivo Andrić', 1, 3, 1, 'books/18V3qsNErnysbLkMddpTkx9b5UNjpe3mVbg5ES2X.jpg', '2026-05-20 19:55:26', '2026-05-27 12:22:16'),
(3, '1984', 'George Orwell', 2, 4, 3, 'books/F7x4NWMAA5Divc6UwpZ42Wsb0Sd9aoFIQDhE8mfh.jpg', '2026-05-20 19:55:26', '2026-05-27 12:18:28'),
(4, 'Hrabri novi svet', 'Aldous Huxley', 2, 3, 3, 'books/147tRygztHZmh4daVV3G6P04G59lfvPgJO7oYjjK.webp', '2026-05-20 19:55:26', '2026-05-25 16:59:51'),
(5, 'Fondacija', 'Isaac Asimov', 2, 2, 1, 'books/bqsHkebARNAtE7JWrtzdblvQWGdbB0sJIHn8DcPm.jpg', '2026-05-20 19:55:26', '2026-05-27 12:06:06'),
(6, 'Kratka istorija vremena', 'Stephen Hawking', 3, 3, 3, 'books/vYa7yXWEgoEbYGIdWIS8lGBY6OYvQsIQIMUlqhSz.jpg', '2026-05-20 19:55:26', '2026-05-25 17:00:39'),
(7, 'Sapiens', 'Yuval Noah Harari', 3, 4, 0, 'books/xeEZdLRYcANMP4Sz7TrQnfdfbRgoligbu2bmgR83.jpg', '2026-05-20 19:55:26', '2026-05-28 08:27:07'),
(8, 'Kritika čistog uma', 'Immanuel Kant', 4, 2, 2, 'books/Uin7esSaoUaGIZ1YkI0gyUqxW6XseZONeHR1SSJ4.webp', '2026-05-20 19:55:26', '2026-05-25 17:00:51'),
(9, 'Ubistvo u Orijent ekspresu', 'Agatha Christie', 6, 5, 2, 'books/y4KLD7LbwVl0FHpPgaWC0rOYpSoTN1cT7PACIwUx.jpg', '2026-05-20 19:55:26', '2026-05-25 17:01:57'),
(10, 'Nije ostao nijedan', 'Agatha Christie', 6, 3, 2, 'books/dGojJ7mC8gWsrYfomkXJZkcrSoTyEt7fwfdpGtcI.jpg', '2026-05-20 19:55:26', '2026-05-25 17:02:10');

-- --------------------------------------------------------

--
-- Table structure for table `book_requests`
--

DROP TABLE IF EXISTS `book_requests`;
CREATE TABLE IF NOT EXISTS `book_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` bigint UNSIGNED NOT NULL,
  `reader_name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `contact` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb3_unicode_ci,
  `status` enum('na čekanju','odobreno','odbijeno') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'na čekanju',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_requests_book_id_foreign` (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `book_requests`
--

INSERT INTO `book_requests` (`id`, `book_id`, `reader_name`, `contact`, `notes`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 'Vladica Rizic', 'vladicarizic04@gmail.com', 'Do ponedeljka?', 'odobreno', '2026-05-27 13:47:30', '2026-05-27 13:47:58'),
(2, 2, 'Vladica Rizic', 'vladicarizic04@gmail.com', NULL, 'odbijeno', '2026-05-28 08:31:36', '2026-05-28 08:39:11'),
(3, 8, 'Vladica Rizic', 'vladicarizic04@gmail.com', NULL, 'na čekanju', '2026-05-28 09:01:08', '2026-05-28 09:01:08');

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

DROP TABLE IF EXISTS `borrowings`;
CREATE TABLE IF NOT EXISTS `borrowings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` bigint UNSIGNED NOT NULL,
  `borrower_name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `borrowed_at` date NOT NULL,
  `due_date` date NOT NULL,
  `returned_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `borrowings_book_id_foreign` (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`id`, `book_id`, `borrower_name`, `borrowed_at`, `due_date`, `returned_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Marko Petrović', '2026-04-20', '2026-05-04', '2026-05-02', '2026-05-20 19:55:26', '2026-05-20 19:55:26'),
(2, 3, 'Ana Jovanović', '2026-04-25', '2026-05-09', '2026-05-08', '2026-05-20 19:55:26', '2026-05-20 19:55:26'),
(3, 1, 'Stefan Nikolić', '2026-05-15', '2026-05-29', NULL, '2026-05-20 19:55:26', '2026-05-20 19:55:26'),
(4, 2, 'Milica Đorđević', '2026-05-17', '2026-05-31', NULL, '2026-05-20 19:55:26', '2026-05-20 19:55:26'),
(5, 7, 'Nikola Stojanović', '2026-05-13', '2026-05-27', NULL, '2026-05-20 19:55:26', '2026-05-20 19:55:26'),
(6, 3, 'Jovana Lazić', '2026-04-20', '2026-05-15', '2026-05-27', '2026-05-20 19:55:26', '2026-05-27 12:18:28'),
(7, 5, 'Dragan Kovačević', '2026-04-05', '2026-05-10', '2026-05-27', '2026-05-20 19:55:26', '2026-05-27 12:06:06'),
(8, 6, 'Maja Pešić', '2026-04-10', '2026-04-30', '2026-05-20', '2026-05-20 19:55:26', '2026-05-20 20:19:02'),
(9, 9, 'Aleksandar Simić', '2026-04-15', '2026-05-17', NULL, '2026-05-20 19:55:26', '2026-05-20 19:55:26'),
(10, 9, 'Mirko Ivkovic', '2026-05-25', '2026-06-08', NULL, '2026-05-25 09:08:14', '2026-05-25 09:08:14'),
(11, 2, 'Mirko Ivanovic', '2026-05-27', '2026-06-10', NULL, '2026-05-27 12:22:16', '2026-05-27 12:22:16'),
(12, 7, 'Milos Peric', '2026-05-28', '2026-06-11', NULL, '2026-05-28 08:27:07', '2026-05-28 08:27:07');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Roman', '2026-05-20 19:55:26', '2026-05-20 19:55:26'),
(2, 'Naučna fantastika', '2026-05-20 19:55:26', '2026-05-20 19:55:26'),
(3, 'Istorija', '2026-05-20 19:55:26', '2026-05-20 19:55:26'),
(4, 'Filozofija', '2026-05-20 19:55:26', '2026-05-20 19:55:26'),
(5, 'Tehnika i tehnologija', '2026-05-20 19:55:26', '2026-05-20 19:55:26'),
(6, 'Detektivski roman', '2026-05-20 19:55:26', '2026-05-20 19:55:26'),
(7, 'Poezija', '2026-05-20 19:55:26', '2026-05-20 19:55:26'),
(8, 'Biografija', '2026-05-20 19:55:26', '2026-05-20 19:55:26');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `connection` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `queue` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb3_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `membership_number` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `notes` text COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `members_membership_number_unique` (`membership_number`),
  UNIQUE KEY `members_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_01_000010_create_categories_table', 1),
(5, '2026_01_01_000011_create_books_table', 1),
(6, '2026_01_01_000012_create_borrowings_table', 1),
(7, '2026_01_02_000001_add_image_to_books_table', 2),
(8, '2026_01_03_000001_create_members_table', 3),
(9, '2026_05_27_151855_create_book_requests_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb3_unicode_ci,
  `payload` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Lf3Az70ypaXWTNjvgnZluSGe4Q8cHTUb1PA2mN4O', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJrR1J4eWpjMGlUcnI1MEFXUk5QdGVZeFlXQlMyWVNzcFlmbnpnZ1NIIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6ImhvbWUifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9', 1779968871);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Bibliotekar', 'admin@biblioteka.rs', NULL, '$2y$12$37zi5KZbrXM/Y3aFmJ84R.pljWNmkpl/gm3nfDRwFJOOpc1Ku1CVG', NULL, '2026-05-20 19:55:26', '2026-05-20 19:55:26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
