-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2025 at 07:20 AM
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
-- Database: `db_portal_iais`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2025_02_02_170716_create_projects_table', 1),
(5, '2025_02_02_170814_create_phases_table', 1),
(6, '2025_02_02_170846_create_project_roles_table', 1),
(39, '2014_10_12_000000_create_users_table', 2),
(40, '2014_10_12_100000_create_password_resets_table', 2),
(41, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(42, '2025_02_02_171452_create_tbl_projects_table', 2),
(45, '2025_02_02_171551_create_tbl_phases_table', 3),
(46, '2025_02_02_171709_create_tbl_role_projects_table', 3),
(47, '2025_02_09_133058_tbl_team_members', 3),
(48, '2025_02_09_133132_tbl_tasks', 3),
(49, '2025_02_09_133149_tbl_task_assigments', 3),
(50, '2025_02_13_220651_create_tbl_activities', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activities`
--

CREATE TABLE `tbl_activities` (
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `phase_id` bigint(20) UNSIGNED NOT NULL,
  `activity_name` varchar(255) NOT NULL,
  `activity_desc` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `complexity` varchar(255) NOT NULL,
  `actual_start_date` date DEFAULT NULL,
  `actual_end_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `duration` time NOT NULL,
  `completion` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_activities`
--

INSERT INTO `tbl_activities` (`activity_id`, `phase_id`, `activity_name`, `activity_desc`, `start_date`, `end_date`, `complexity`, `actual_start_date`, `actual_end_date`, `status`, `duration`, `completion`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Updated Database Design', 'Updated database schema design', '2024-02-13', '2024-02-20', 'Hard', '2025-03-01', '2025-03-02', 'Done', '03:30:00', '100%', 2, '2025-02-13 16:45:23', '2025-03-10 21:40:28'),
(3, 6, 'repo init oioi', 'repo init in github and add collaborators', '2025-02-16', '2025-02-17', 'Easy', NULL, NULL, 'Review', '00:00:00', '100%', 3, '2025-02-16 07:17:21', '2025-02-16 10:06:17'),
(8, 10, 'persiapan', 'persiapan', '2025-02-10', '2025-02-11', 'Low', '2025-03-01', '2025-03-02', 'Done', '01:00:00', '100%', 3, '2025-02-18 13:07:43', '2025-03-08 07:23:41'),
(9, 12, 'menunggu', 'menunggu antrian app kai access', '2025-02-19', '2025-02-19', 'Easy', '2025-02-20', '2025-02-20', 'In Progress', '01:00:00', '10%', 3, '2025-02-18 18:07:32', '2025-02-18 20:18:12'),
(10, 11, 'activity 1', 'activity description', '2025-03-01', '2025-03-03', 'Low', '2025-03-01', '2025-03-03', 'Review', '03:00:00', '100%', 2, '2025-03-01 11:15:25', '2025-03-01 13:48:53'),
(11, 1, 'activity 1', 'activity1 desc', '2025-03-01', '2025-03-11', 'Low', '2025-03-01', '2025-03-01', 'Done', '02:00:00', '100%', 2, '2025-03-01 13:53:51', '2025-03-01 13:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_profile`
--

CREATE TABLE `tbl_detail_profile` (
  `detail_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `jenjang_pendidikan` varchar(100) DEFAULT NULL,
  `nama_institusi` varchar(255) DEFAULT NULL,
  `tahun_masuk` year(4) DEFAULT NULL,
  `tahun_lulus` year(4) DEFAULT NULL,
  `gelar` varchar(255) DEFAULT NULL,
  `bidang_studi` varchar(255) DEFAULT NULL,
  `nama_perusahaan` varchar(255) DEFAULT NULL,
  `posisi` varchar(255) DEFAULT NULL,
  `periode_mulai` varchar(200) DEFAULT NULL,
  `periode_selesai` varchar(200) DEFAULT NULL,
  `tanggung_jawab` text DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `github` varchar(255) DEFAULT NULL,
  `nama_keahlian` varchar(255) DEFAULT NULL,
  `sumber_keahlian` varchar(255) DEFAULT NULL,
  `sertifikasi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_detail_profile`
--

INSERT INTO `tbl_detail_profile` (`detail_id`, `user_id`, `jenjang_pendidikan`, `nama_institusi`, `tahun_masuk`, `tahun_lulus`, `gelar`, `bidang_studi`, `nama_perusahaan`, `posisi`, `periode_mulai`, `periode_selesai`, `tanggung_jawab`, `linkedin`, `twitter`, `instagram`, `facebook`, `github`, `nama_keahlian`, `sumber_keahlian`, `sertifikasi`) VALUES
(1, 2, 'S1', 'Binus University', '2019', '2021', 'S.Kom.', 'Sistem Informasi', 'Binus', 'Trainer', '2024-01-01', '2025-01-01', 'Memberikan Pelatihan', NULL, NULL, NULL, NULL, NULL, 'Programmer', 'BNSP', 'Programmer'),
(2, 1, 's1', 'binus', '2021', '2029', 'skom', 'yes', 's', 's', '0000-00-00', '0000-00-00', 'wew', NULL, NULL, NULL, NULL, NULL, 'a', 'b', 'c'),
(3, 1, 'S1', 'Binus', '2021', '2029', 'S.Kom.', 'Infomation System', 'Binus', 'IT', '2025', 'Now', 'Yes', 'linkedin', 'twitter', 'ig', 'fb', NULL, 'Programmer', 'BNSP', 'Programmer'),
(4, 1, 'S1', 'Binus', '2021', '2029', 'S.Kom.', 'Infomation System', 'Binus', 'IT', '2025', 'Now', 'Yes', 'linkedin', 'twitter', 'ig', 'fb', NULL, 'Programmer', 'BNSP', 'Programmer'),
(5, 4, 'S1', 'Binus University', '2019', '2021', 'S.Kom.', 'Infomation System', 'IAIS', 'IT', '2021', 'Now', 'Developer', NULL, NULL, NULL, NULL, NULL, 'Programmer', 'BNSP', 'Programmer');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedback`
--

CREATE TABLE `tbl_feedback` (
  `feedback_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `subtopic_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `feedback` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_feedback`
--

INSERT INTO `tbl_feedback` (`feedback_id`, `course_id`, `subtopic_id`, `user_id`, `feedback`, `rating`, `created_at`, `modified_at`) VALUES
(1, 1, 17, 2, 'couse bagus', 4, '2025-01-30 20:23:11', '2025-01-30 20:23:11'),
(3, 2, 17, 2, 'biasa aja sih', 4, '2025-02-19 00:20:30', '2025-02-19 00:20:30'),
(4, 2, 17, 2, 'nice', 5, '2025-02-19 00:22:55', '2025-02-19 00:22:55'),
(5, 2, 17, 2, 'oke', 3, '2025-02-19 00:24:07', '2025-02-19 00:24:07'),
(7, 1, 18, 2, 'kau ni ape ?', 2, '2025-02-24 21:28:14', '2025-02-24 21:28:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group`
--

CREATE TABLE `tbl_group` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(200) NOT NULL,
  `group_logo` varchar(100) NOT NULL,
  `group_email` varchar(200) DEFAULT NULL,
  `group_phone` varchar(20) DEFAULT NULL,
  `group_alamat` varchar(500) NOT NULL,
  `group_creaby` varchar(200) NOT NULL,
  `group_modiby` varchar(200) NOT NULL,
  `group_creadate` datetime NOT NULL,
  `group_modidate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hasil_test`
--

CREATE TABLE `tbl_hasil_test` (
  `hasil_id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `subtopic_id` int(11) NOT NULL,
  `waktu_respon` datetime NOT NULL,
  `waktu_submit` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_hasil_test`
--

INSERT INTO `tbl_hasil_test` (`hasil_id`, `peserta_id`, `subtopic_id`, `waktu_respon`, `waktu_submit`) VALUES
(1, 4, 24, '2025-03-17 05:31:18', NULL),
(2, 4, 25, '2025-03-17 05:44:27', NULL),
(3, 4, 25, '2025-03-17 05:47:08', NULL),
(4, 14, 24, '2025-03-17 08:26:44', NULL),
(5, 16, 24, '2025-03-17 08:26:47', NULL),
(6, 11, 24, '2025-03-17 08:26:47', NULL),
(7, 12, 24, '2025-03-17 08:27:16', NULL),
(8, 17, 24, '2025-03-17 08:27:23', NULL),
(9, 13, 24, '2025-03-17 08:27:28', NULL),
(10, 15, 24, '2025-03-17 08:27:36', NULL),
(11, 18, 24, '2025-03-17 08:29:18', NULL),
(12, 19, 24, '2025-03-17 09:22:41', NULL),
(13, 20, 24, '2025-03-17 09:22:43', NULL),
(14, 6, 24, '2025-03-17 09:30:35', NULL),
(15, 8, 24, '2025-03-17 09:30:30', NULL),
(16, 23, 24, '2025-03-17 09:35:27', NULL),
(17, 27, 24, '2025-03-17 09:35:30', NULL),
(18, 25, 24, '2025-03-17 09:36:24', NULL),
(19, 7, 24, '2025-03-17 09:37:13', NULL),
(20, 24, 24, '2025-03-17 09:37:26', NULL),
(21, 26, 24, '2025-03-17 09:37:39', NULL),
(22, 33, 24, '2025-03-17 10:41:30', NULL),
(23, 17, 25, '2025-03-17 10:57:22', NULL),
(24, 11, 25, '2025-03-17 10:57:47', NULL),
(25, 11, 25, '2025-03-17 10:57:48', NULL),
(26, 15, 25, '2025-03-17 10:58:25', NULL),
(27, 12, 25, '2025-03-17 11:00:34', NULL),
(28, 23, 26, '2025-03-17 11:00:56', NULL),
(29, 16, 25, '2025-03-17 11:01:17', NULL),
(30, 18, 25, '2025-03-17 11:01:35', NULL),
(31, 7, 26, '2025-03-17 11:02:01', NULL),
(32, 26, 26, '2025-03-17 11:02:57', NULL),
(33, 13, 25, '2025-03-17 11:04:12', NULL),
(34, 8, 26, '2025-03-17 11:06:37', NULL),
(35, 25, 26, '2025-03-17 11:07:35', NULL),
(36, 14, 25, '2025-03-17 11:07:43', NULL),
(37, 15, 26, '2025-03-17 11:08:17', NULL),
(38, 28, 24, '2025-03-17 11:09:01', NULL),
(39, 18, 26, '2025-03-17 11:09:09', NULL),
(40, 15, 26, '2025-03-17 11:09:23', NULL),
(41, 17, 26, '2025-03-17 11:09:23', NULL),
(42, 6, 26, '2025-03-17 11:10:29', NULL),
(43, 33, 26, '2025-03-17 11:10:29', NULL),
(44, 27, 26, '2025-03-17 11:11:11', NULL),
(45, 12, 25, '2025-03-17 11:11:17', NULL),
(46, 24, 26, '2025-03-17 11:12:15', NULL),
(47, 13, 25, '2025-03-17 11:13:59', NULL),
(48, 19, 26, '2025-03-17 11:14:07', NULL),
(49, 29, 24, '2025-03-17 11:17:10', NULL),
(50, 20, 25, '2025-03-17 11:16:07', NULL),
(51, 12, 25, '2025-03-17 11:17:02', NULL),
(52, 35, 24, '2025-03-17 11:17:21', NULL),
(53, 35, 24, '2025-03-17 11:17:21', NULL),
(54, 13, 26, '2025-03-17 11:18:51', NULL),
(55, 11, 26, '2025-03-17 11:19:01', NULL),
(56, 16, 26, '2025-03-17 11:23:26', NULL),
(57, 12, 26, '2025-03-17 11:23:25', NULL),
(58, 17, 28, '2025-03-17 11:24:36', NULL),
(59, 15, 28, '2025-03-17 11:25:13', NULL),
(60, 20, 25, '2025-03-17 11:25:11', NULL),
(61, 29, 26, '2025-03-17 11:28:34', NULL),
(62, 39, 24, '2025-03-17 11:26:31', NULL),
(63, 35, 26, '2025-03-17 11:27:27', NULL),
(64, 19, 25, '2025-03-17 11:27:25', NULL),
(65, 35, 26, '2025-03-17 11:32:54', NULL),
(66, 20, 25, '2025-03-17 11:35:14', NULL),
(67, 20, 26, '2025-03-17 11:41:03', NULL),
(68, 19, 25, '2025-03-17 11:41:23', NULL),
(69, 20, 27, '2025-03-17 11:49:42', NULL),
(70, 19, 25, '2025-03-17 11:50:03', NULL),
(71, 19, 27, '2025-03-17 13:03:16', NULL),
(72, 23, 28, '2025-03-17 13:17:15', NULL),
(73, 28, 28, '2025-03-17 13:17:17', NULL),
(74, 20, 27, '2025-03-17 13:17:48', NULL),
(75, 8, 28, '2025-03-17 13:18:11', NULL),
(76, 6, 28, '2025-03-17 13:18:22', NULL),
(77, 25, 28, '2025-03-17 13:18:44', NULL),
(78, 27, 28, '2025-03-17 13:19:17', NULL),
(79, 7, 28, '2025-03-17 13:20:00', NULL),
(80, 24, 28, '2025-03-17 13:20:29', NULL),
(81, 24, 28, '2025-03-17 13:20:53', NULL),
(82, 26, 28, '2025-03-17 13:20:53', NULL),
(83, 35, 28, '2025-03-17 13:21:42', NULL),
(84, 28, 26, '2025-03-17 13:22:59', NULL),
(85, 16, 28, '2025-03-17 13:23:01', NULL),
(86, 27, 25, '2025-03-17 13:23:05', NULL),
(87, 13, 28, '2025-03-17 13:23:16', NULL),
(88, 14, 26, '2025-03-17 13:24:26', NULL),
(89, 27, 27, '2025-03-17 13:26:02', NULL),
(90, 11, 28, '2025-03-17 13:27:02', NULL),
(91, 12, 28, '2025-03-17 13:27:03', NULL),
(92, 39, 28, '2025-03-17 13:27:46', NULL),
(93, 27, 29, '2025-03-17 13:28:08', NULL),
(94, 18, 28, '2025-03-17 13:28:56', NULL),
(95, 23, 25, '2025-03-17 13:30:23', NULL),
(96, 27, 29, '2025-03-17 13:30:30', NULL),
(97, 39, 26, '2025-03-17 13:30:42', NULL),
(98, 19, 28, '2025-03-17 13:30:54', NULL),
(99, 27, 29, '2025-03-17 13:32:07', NULL),
(100, 14, 27, '2025-03-17 13:32:43', NULL),
(101, 12, 27, '2025-03-17 13:37:06', NULL),
(102, 20, 28, '2025-03-17 13:37:31', NULL),
(103, 17, 30, '2025-03-17 13:37:55', NULL),
(104, 14, 27, '2025-03-17 13:38:30', NULL),
(105, 12, 27, '2025-03-17 13:40:13', NULL),
(106, 12, 27, '2025-03-17 13:40:16', NULL),
(107, 16, 27, '2025-03-17 13:41:39', NULL),
(108, 15, 27, '2025-03-17 13:44:31', NULL),
(109, 11, 27, '2025-03-17 13:45:03', NULL),
(110, 17, 27, '2025-03-17 13:45:51', NULL),
(111, 13, 27, '2025-03-17 13:47:05', NULL),
(112, 11, 29, '2025-03-17 13:47:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hasil_test_detail`
--

CREATE TABLE `tbl_hasil_test_detail` (
  `hasil_id_detail` int(11) NOT NULL,
  `hasil_id` int(11) DEFAULT NULL,
  `pertanyaan_id` int(11) DEFAULT NULL,
  `jawaban_id` int(11) DEFAULT NULL,
  `jawaban_isian` text DEFAULT NULL,
  `nilai_jawaban_isian` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_hasil_test_detail`
--

INSERT INTO `tbl_hasil_test_detail` (`hasil_id_detail`, `hasil_id`, `pertanyaan_id`, `jawaban_id`, `jawaban_isian`, `nilai_jawaban_isian`) VALUES
(1, 1, 4, 3, NULL, NULL),
(2, 1, 5, 9, NULL, NULL),
(3, 1, 6, 11, NULL, NULL),
(4, 1, 7, 18, NULL, NULL),
(5, 1, 8, 21, NULL, NULL),
(6, 1, 9, 26, NULL, NULL),
(7, 1, 10, 28, NULL, NULL),
(8, 1, 11, 33, NULL, NULL),
(9, 1, 12, 35, NULL, NULL),
(10, 1, 13, 41, NULL, NULL),
(11, 2, 9, 26, NULL, NULL),
(12, 2, 10, 28, NULL, NULL),
(13, 2, 11, 33, NULL, NULL),
(14, 2, 12, 35, NULL, NULL),
(15, 2, 13, 41, NULL, NULL),
(16, 2, 14, 46, NULL, NULL),
(17, 2, 15, 50, NULL, NULL),
(18, 2, 16, 53, NULL, NULL),
(19, 2, 17, 55, NULL, NULL),
(20, 2, 18, 59, NULL, NULL),
(21, 3, 9, 26, NULL, NULL),
(22, 3, 10, 28, NULL, NULL),
(23, 3, 11, 33, NULL, NULL),
(24, 3, 12, 35, NULL, NULL),
(25, 3, 13, 41, NULL, NULL),
(26, 3, 14, 46, NULL, NULL),
(27, 3, 15, 50, NULL, NULL),
(28, 3, 16, 53, NULL, NULL),
(29, 3, 17, 55, NULL, NULL),
(30, 3, 18, 60, NULL, NULL),
(31, 6, 4, 3, NULL, NULL),
(32, 5, 4, 6, NULL, NULL),
(33, 4, 4, 3, NULL, NULL),
(34, 4, 5, 7, NULL, NULL),
(35, 5, 5, 9, NULL, NULL),
(36, 6, 5, 9, NULL, NULL),
(37, 5, 6, 13, NULL, NULL),
(38, 4, 6, 11, NULL, NULL),
(39, 4, 7, 18, NULL, NULL),
(40, 5, 7, 18, NULL, NULL),
(41, 7, 4, 3, NULL, NULL),
(42, 6, 6, 13, NULL, NULL),
(43, 6, 7, 18, NULL, NULL),
(44, 8, 4, 3, NULL, NULL),
(45, 7, 5, 9, NULL, NULL),
(46, 9, 4, 3, NULL, NULL),
(47, 5, 8, 21, NULL, NULL),
(48, 10, 4, 3, NULL, NULL),
(49, 7, 6, 11, NULL, NULL),
(50, 4, 8, 20, NULL, NULL),
(51, 8, 5, 9, NULL, NULL),
(52, 9, 5, 9, NULL, NULL),
(53, 9, 6, 13, NULL, NULL),
(54, 7, 7, 18, NULL, NULL),
(55, 8, 6, 13, NULL, NULL),
(56, 5, 9, 23, NULL, NULL),
(57, 6, 8, 20, NULL, NULL),
(58, 5, 10, 28, NULL, NULL),
(59, 6, 9, 26, NULL, NULL),
(60, 9, 7, 18, NULL, NULL),
(61, 4, 9, 26, NULL, NULL),
(62, 10, 5, 7, NULL, NULL),
(63, 5, 11, 33, NULL, NULL),
(64, 7, 8, 21, NULL, NULL),
(65, 6, 10, 28, NULL, NULL),
(66, 6, 11, 33, NULL, NULL),
(67, 4, 10, 30, NULL, NULL),
(68, 10, 6, 13, NULL, NULL),
(69, 4, 11, 32, NULL, NULL),
(70, 5, 12, 38, NULL, NULL),
(71, 8, 7, 18, NULL, NULL),
(72, 4, 12, 35, NULL, NULL),
(73, 10, 7, 18, NULL, NULL),
(74, 9, 8, 19, NULL, NULL),
(75, 4, 13, 39, NULL, NULL),
(76, 5, 13, 39, NULL, NULL),
(77, 6, 12, 35, NULL, NULL),
(78, 6, 13, 39, NULL, NULL),
(79, 11, 4, 3, NULL, NULL),
(80, 7, 9, 26, NULL, NULL),
(81, 9, 9, 26, NULL, NULL),
(82, 11, 5, 9, NULL, NULL),
(83, 11, 6, 14, NULL, NULL),
(84, 11, 7, 18, NULL, NULL),
(85, 9, 10, 28, NULL, NULL),
(86, 7, 10, 28, NULL, NULL),
(87, 9, 11, 33, NULL, NULL),
(88, 11, 8, 21, NULL, NULL),
(89, 7, 11, 31, NULL, NULL),
(90, 8, 8, 20, NULL, NULL),
(91, 11, 9, 26, NULL, NULL),
(92, 8, 9, 23, NULL, NULL),
(93, 9, 12, 38, NULL, NULL),
(94, 9, 13, 39, NULL, NULL),
(95, 10, 8, 20, NULL, NULL),
(96, 11, 10, 27, NULL, NULL),
(97, 7, 12, 38, NULL, NULL),
(98, 8, 10, 30, NULL, NULL),
(99, 8, 11, 34, NULL, NULL),
(100, 10, 9, 26, NULL, NULL),
(101, 11, 11, 33, NULL, NULL),
(102, 10, 10, 30, NULL, NULL),
(103, 11, 12, 36, NULL, NULL),
(104, 7, 13, 41, NULL, NULL),
(105, 11, 13, 39, NULL, NULL),
(106, 10, 11, 33, NULL, NULL),
(107, 8, 12, 36, NULL, NULL),
(108, 8, 13, 41, NULL, NULL),
(109, 10, 12, 37, NULL, NULL),
(110, 10, 13, 41, NULL, NULL),
(111, 12, 4, 3, NULL, NULL),
(112, 13, 4, 3, NULL, NULL),
(113, 12, 5, 9, NULL, NULL),
(114, 13, 5, 9, NULL, NULL),
(115, 12, 6, 14, NULL, NULL),
(116, 13, 6, 13, NULL, NULL),
(117, 13, 7, 18, NULL, NULL),
(118, 12, 7, 18, NULL, NULL),
(119, 12, 8, 22, NULL, NULL),
(120, 12, 9, 26, NULL, NULL),
(121, 13, 8, 21, NULL, NULL),
(122, 12, 10, 28, NULL, NULL),
(123, 12, 11, 33, NULL, NULL),
(124, 13, 9, 26, NULL, NULL),
(125, 13, 10, 28, NULL, NULL),
(126, 12, 12, 35, NULL, NULL),
(127, 13, 11, 33, NULL, NULL),
(128, 13, 12, 37, NULL, NULL),
(129, 15, 4, 3, NULL, NULL),
(130, 14, 4, 3, NULL, NULL),
(131, 15, 5, 9, NULL, NULL),
(132, 14, 5, 9, NULL, NULL),
(133, 15, 6, 13, NULL, NULL),
(134, 13, 13, 40, NULL, NULL),
(135, 14, 6, 13, NULL, NULL),
(136, 15, 7, 18, NULL, NULL),
(137, 14, 7, 18, NULL, NULL),
(138, 15, 8, 21, NULL, NULL),
(139, 14, 8, 21, NULL, NULL),
(140, 16, 4, 3, NULL, NULL),
(141, 15, 10, 28, NULL, NULL),
(142, 17, 6, 13, NULL, NULL),
(143, 14, 10, 28, NULL, NULL),
(144, 15, 11, 33, NULL, NULL),
(145, 16, 6, 13, NULL, NULL),
(146, 18, 4, 3, NULL, NULL),
(147, 14, 11, 33, NULL, NULL),
(148, 18, 6, 13, NULL, NULL),
(149, 18, 7, 18, NULL, NULL),
(150, 16, 8, 21, NULL, NULL),
(151, 17, 8, 19, NULL, NULL),
(152, 19, 4, 3, NULL, NULL),
(153, 16, 9, 25, NULL, NULL),
(154, 21, 6, 13, NULL, NULL),
(155, 19, 6, 13, NULL, NULL),
(156, 20, 6, 13, NULL, NULL),
(157, 16, 10, 28, NULL, NULL),
(158, 21, 7, 18, NULL, NULL),
(159, 18, 9, 24, NULL, NULL),
(160, 19, 7, 16, NULL, NULL),
(161, 16, 5, 9, NULL, NULL),
(162, 20, 7, 18, NULL, NULL),
(163, 17, 7, 16, NULL, NULL),
(164, 18, 10, 28, NULL, NULL),
(165, 16, 7, 18, NULL, NULL),
(166, 19, 8, 21, NULL, NULL),
(167, 17, 9, 24, NULL, NULL),
(168, 17, 10, 28, NULL, NULL),
(169, 18, 11, 34, NULL, NULL),
(170, 20, 8, 20, NULL, NULL),
(171, 17, 11, 33, NULL, NULL),
(172, 21, 8, 21, NULL, NULL),
(173, 18, 12, 37, NULL, NULL),
(174, 18, 13, 41, NULL, NULL),
(175, 21, 9, 26, NULL, NULL),
(176, 20, 9, 26, NULL, NULL),
(177, 21, 10, 28, NULL, NULL),
(178, 16, 11, 34, NULL, NULL),
(179, 17, 12, 38, NULL, NULL),
(180, 19, 9, 26, NULL, NULL),
(181, 17, 13, 42, NULL, NULL),
(182, 21, 11, 33, NULL, NULL),
(183, 16, 12, 38, NULL, NULL),
(184, 19, 10, 28, NULL, NULL),
(185, 16, 13, 41, NULL, NULL),
(186, 15, 13, 39, NULL, NULL),
(187, 14, 13, 39, NULL, NULL),
(188, 19, 11, 33, NULL, NULL),
(189, 20, 10, 30, NULL, NULL),
(190, 20, 11, 34, NULL, NULL),
(191, 19, 13, 41, NULL, NULL),
(192, 21, 12, 38, NULL, NULL),
(193, 20, 12, 36, NULL, NULL),
(194, 20, 13, 39, NULL, NULL),
(195, 22, 4, 3, NULL, NULL),
(196, 22, 5, 7, NULL, NULL),
(197, 22, 6, 12, NULL, NULL),
(198, 22, 7, 18, NULL, NULL),
(199, 22, 8, 21, NULL, NULL),
(200, 22, 9, 26, NULL, NULL),
(201, 22, 10, 28, NULL, NULL),
(202, 22, 11, 33, NULL, NULL),
(203, 22, 12, 36, NULL, NULL),
(204, 22, 13, 41, NULL, NULL),
(205, 23, 9, 26, NULL, NULL),
(206, 25, 9, 26, NULL, NULL),
(207, 25, 10, 28, NULL, NULL),
(208, 25, 11, 33, NULL, NULL),
(209, 26, 9, 26, NULL, NULL),
(210, 26, 10, 30, NULL, NULL),
(211, 23, 10, 30, NULL, NULL),
(212, 26, 11, 33, NULL, NULL),
(213, 23, 11, 33, NULL, NULL),
(214, 23, 12, 38, NULL, NULL),
(215, 26, 12, 38, NULL, NULL),
(216, 25, 12, 38, NULL, NULL),
(217, 25, 13, 39, NULL, NULL),
(218, 25, 14, 44, NULL, NULL),
(219, 26, 13, 41, NULL, NULL),
(220, 23, 13, 41, NULL, NULL),
(221, 26, 14, 46, NULL, NULL),
(222, 23, 14, 46, NULL, NULL),
(223, 27, 9, 26, NULL, NULL),
(224, 27, 10, 28, NULL, NULL),
(225, 28, 19, 64, NULL, NULL),
(226, 25, 15, 50, NULL, NULL),
(227, 28, 20, 69, NULL, NULL),
(228, 25, 16, 53, NULL, NULL),
(229, 25, 17, 58, NULL, NULL),
(230, 25, 18, 60, NULL, NULL),
(231, 29, 12, 35, NULL, NULL),
(232, 28, 24, 83, NULL, NULL),
(233, 27, 14, 43, NULL, NULL),
(234, 29, 15, 50, NULL, NULL),
(235, 27, 16, 53, NULL, NULL),
(236, 32, 19, 64, NULL, NULL),
(237, 30, 9, 26, NULL, NULL),
(238, 30, 10, 30, NULL, NULL),
(239, 30, 11, 33, NULL, NULL),
(240, 27, 18, 59, NULL, NULL),
(241, 29, 18, 62, NULL, NULL),
(242, 30, 12, 38, NULL, NULL),
(243, 33, 9, 26, NULL, NULL),
(244, 30, 13, 41, NULL, NULL),
(245, 33, 10, 28, NULL, NULL),
(246, 30, 14, 46, NULL, NULL),
(247, 33, 11, 33, NULL, NULL),
(248, 30, 15, 50, NULL, NULL),
(249, 33, 12, 38, NULL, NULL),
(250, 30, 16, 53, NULL, NULL),
(251, 33, 13, 39, NULL, NULL),
(252, 30, 17, 55, NULL, NULL),
(253, 30, 18, 61, NULL, NULL),
(254, 33, 14, 46, NULL, NULL),
(255, 33, 15, 49, NULL, NULL),
(256, 33, 16, 53, NULL, NULL),
(257, 33, 17, 58, NULL, NULL),
(258, 31, 25, 90, NULL, NULL),
(259, 33, 18, 59, NULL, NULL),
(260, 32, 25, 90, NULL, NULL),
(261, 34, 19, 64, NULL, NULL),
(262, 35, 19, 64, NULL, NULL),
(263, 35, 20, 68, NULL, NULL),
(264, 34, 20, 68, NULL, NULL),
(265, 35, 21, 71, NULL, NULL),
(266, 35, 22, 77, NULL, NULL),
(267, 34, 21, 71, NULL, NULL),
(268, 35, 23, 80, NULL, NULL),
(269, 35, 24, 83, NULL, NULL),
(270, 35, 25, 90, NULL, NULL),
(271, 32, 26, 91, NULL, NULL),
(272, 38, 4, 3, NULL, NULL),
(273, 39, 19, 64, NULL, NULL),
(274, 35, 26, 94, NULL, NULL),
(275, 34, 22, 77, NULL, NULL),
(276, 35, 27, 98, NULL, NULL),
(277, 35, 28, 100, NULL, NULL),
(278, 39, 20, 67, NULL, NULL),
(279, 40, 20, 67, NULL, NULL),
(280, 34, 23, 81, NULL, NULL),
(281, 39, 21, 71, NULL, NULL),
(282, 39, 22, 77, NULL, NULL),
(283, 43, 19, 64, NULL, NULL),
(284, 43, 20, 67, NULL, NULL),
(285, 42, 21, 71, NULL, NULL),
(286, 41, 22, 77, NULL, NULL),
(287, 40, 22, 77, NULL, NULL),
(288, 43, 21, 71, NULL, NULL),
(289, 43, 22, 77, NULL, NULL),
(290, 42, 22, 77, NULL, NULL),
(291, 36, 9, 26, NULL, NULL),
(292, 42, 23, 81, NULL, NULL),
(293, 43, 23, 81, NULL, NULL),
(294, 45, 9, 26, NULL, NULL),
(295, 45, 10, 28, NULL, NULL),
(296, 36, 10, 28, NULL, NULL),
(297, 43, 24, 85, NULL, NULL),
(298, 39, 23, 81, NULL, NULL),
(299, 34, 24, 83, NULL, NULL),
(300, 36, 11, 33, NULL, NULL),
(301, 44, 21, 71, NULL, NULL),
(302, 38, 7, 18, NULL, NULL),
(303, 43, 25, 90, NULL, NULL),
(304, 43, 26, 91, NULL, NULL),
(305, 39, 24, 83, NULL, NULL),
(306, 34, 25, 90, NULL, NULL),
(307, 39, 25, 89, NULL, NULL),
(308, 42, 26, 94, NULL, NULL),
(309, 34, 26, 94, NULL, NULL),
(310, 46, 20, 69, NULL, NULL),
(311, 36, 12, 35, NULL, NULL),
(312, 43, 27, 98, NULL, NULL),
(313, 46, 21, 71, NULL, NULL),
(314, 45, 12, 35, NULL, NULL),
(315, 38, 8, 21, NULL, NULL),
(316, 42, 27, 95, NULL, NULL),
(317, 34, 27, 95, NULL, NULL),
(318, 46, 22, 77, NULL, NULL),
(319, 43, 28, 100, NULL, NULL),
(320, 36, 13, 41, NULL, NULL),
(321, 34, 28, 100, NULL, NULL),
(322, 36, 14, 46, NULL, NULL),
(323, 39, 26, 94, NULL, NULL),
(324, 40, 26, 94, NULL, NULL),
(325, 36, 15, 50, NULL, NULL),
(326, 45, 15, 50, NULL, NULL),
(327, 39, 27, 95, NULL, NULL),
(328, 36, 16, 53, NULL, NULL),
(329, 39, 28, 100, NULL, NULL),
(330, 36, 17, 55, NULL, NULL),
(331, 47, 9, 26, NULL, NULL),
(332, 36, 18, 60, NULL, NULL),
(333, 47, 10, 28, NULL, NULL),
(334, 47, 11, 33, NULL, NULL),
(335, 49, 6, 11, NULL, NULL),
(336, 47, 12, 38, NULL, NULL),
(337, 47, 13, 42, NULL, NULL),
(338, 48, 24, 83, NULL, NULL),
(339, 47, 14, 46, NULL, NULL),
(340, 51, 9, 25, NULL, NULL),
(341, 51, 10, 28, NULL, NULL),
(342, 47, 15, 50, NULL, NULL),
(343, 47, 16, 53, NULL, NULL),
(344, 49, 11, 33, NULL, NULL),
(345, 48, 26, 94, NULL, NULL),
(346, 47, 17, 55, NULL, NULL),
(347, 47, 18, 59, NULL, NULL),
(348, 54, 19, 64, NULL, NULL),
(349, 54, 20, 67, NULL, NULL),
(350, 54, 21, 71, NULL, NULL),
(351, 54, 22, 77, NULL, NULL),
(352, 50, 9, 26, NULL, NULL),
(353, 55, 19, 64, NULL, NULL),
(354, 55, 21, 71, NULL, NULL),
(355, 55, 22, 77, NULL, NULL),
(356, 54, 23, 80, NULL, NULL),
(357, 55, 23, 81, NULL, NULL),
(358, 50, 10, 28, NULL, NULL),
(359, 54, 24, 84, NULL, NULL),
(360, 48, 19, 64, NULL, NULL),
(361, 54, 26, 93, NULL, NULL),
(362, 54, 25, 87, NULL, NULL),
(363, 53, 5, 9, NULL, NULL),
(364, 50, 11, 33, NULL, NULL),
(365, 54, 27, 98, NULL, NULL),
(366, 54, 28, 99, NULL, NULL),
(367, 55, 24, 83, NULL, NULL),
(368, 50, 12, 36, NULL, NULL),
(369, 48, 23, 81, NULL, NULL),
(370, 55, 25, 87, NULL, NULL),
(371, 55, 26, 93, NULL, NULL),
(372, 48, 25, 87, NULL, NULL),
(373, 53, 6, 13, NULL, NULL),
(374, 53, 7, 18, NULL, NULL),
(375, 55, 27, 95, NULL, NULL),
(376, 48, 27, 95, NULL, NULL),
(377, 48, 28, 100, NULL, NULL),
(378, 55, 28, 100, NULL, NULL),
(379, 50, 13, 39, NULL, NULL),
(380, 50, 14, 46, NULL, NULL),
(381, 50, 15, 50, NULL, NULL),
(382, 50, 16, 53, NULL, NULL),
(383, 56, 21, 71, NULL, NULL),
(384, 56, 22, 77, NULL, NULL),
(385, 56, 23, 81, NULL, NULL),
(386, 56, 24, 83, NULL, NULL),
(387, 56, 26, 93, NULL, NULL),
(388, 56, 27, 95, NULL, NULL),
(389, 56, 28, 100, NULL, NULL),
(390, 50, 17, 55, NULL, NULL),
(391, 53, 12, 36, NULL, NULL),
(392, 58, 34, 124, NULL, NULL),
(393, 58, 35, 129, NULL, NULL),
(394, 59, 34, 124, NULL, NULL),
(395, 60, 9, 23, NULL, NULL),
(396, 60, 10, 27, NULL, NULL),
(397, 58, 36, 134, NULL, NULL),
(398, 60, 11, 33, NULL, NULL),
(399, 62, 4, 3, NULL, NULL),
(400, 59, 35, 129, NULL, NULL),
(401, 62, 5, 9, NULL, NULL),
(402, 63, 19, 64, NULL, NULL),
(403, 62, 6, 11, NULL, NULL),
(404, 58, 37, 138, NULL, NULL),
(405, 61, 19, 64, NULL, NULL),
(406, 62, 7, 18, NULL, NULL),
(407, 58, 38, 139, NULL, NULL),
(408, 59, 37, 138, NULL, NULL),
(409, 63, 21, 71, NULL, NULL),
(410, 64, 9, 23, NULL, NULL),
(411, 61, 20, 70, NULL, NULL),
(412, 64, 10, 28, NULL, NULL),
(413, 62, 8, 19, NULL, NULL),
(414, 59, 38, 139, NULL, NULL),
(415, 61, 21, 71, NULL, NULL),
(416, 58, 39, 144, NULL, NULL),
(417, 60, 12, 37, NULL, NULL),
(418, 58, 40, 150, NULL, NULL),
(419, 64, 11, 33, NULL, NULL),
(420, 62, 9, 26, NULL, NULL),
(421, 59, 39, 144, NULL, NULL),
(422, 60, 13, 39, NULL, NULL),
(423, 62, 10, 28, NULL, NULL),
(424, 60, 14, 46, NULL, NULL),
(425, 59, 40, 150, NULL, NULL),
(426, 63, 22, 77, NULL, NULL),
(427, 61, 22, 77, NULL, NULL),
(428, 58, 41, 151, NULL, NULL),
(429, 62, 11, 33, NULL, NULL),
(430, 59, 41, 151, NULL, NULL),
(431, 63, 23, 81, NULL, NULL),
(432, 64, 12, 36, NULL, NULL),
(433, 59, 42, 158, NULL, NULL),
(434, 60, 15, 50, NULL, NULL),
(435, 58, 42, 158, NULL, NULL),
(436, 60, 16, 53, NULL, NULL),
(437, 60, 17, 55, NULL, NULL),
(438, 61, 23, 81, NULL, NULL),
(439, 59, 43, 162, NULL, NULL),
(440, 62, 12, 37, NULL, NULL),
(441, 58, 43, 162, NULL, NULL),
(442, 63, 24, 84, NULL, NULL),
(443, 64, 13, 42, NULL, NULL),
(444, 63, 25, 90, NULL, NULL),
(445, 61, 24, 85, NULL, NULL),
(446, 64, 14, 46, NULL, NULL),
(447, 61, 25, 90, NULL, NULL),
(448, 65, 19, 64, NULL, NULL),
(449, 65, 20, 68, NULL, NULL),
(450, 65, 21, 71, NULL, NULL),
(451, 65, 22, 77, NULL, NULL),
(452, 65, 23, 81, NULL, NULL),
(453, 65, 24, 84, NULL, NULL),
(454, 61, 26, 93, NULL, NULL),
(455, 61, 27, 95, NULL, NULL),
(456, 61, 28, 99, NULL, NULL),
(457, 65, 25, 90, NULL, NULL),
(458, 65, 26, 94, NULL, NULL),
(459, 65, 27, 98, NULL, NULL),
(460, 64, 15, 50, NULL, NULL),
(461, 64, 16, 53, NULL, NULL),
(462, 64, 17, 55, NULL, NULL),
(463, 66, 9, 26, NULL, NULL),
(464, 66, 10, 28, NULL, NULL),
(465, 66, 11, 33, NULL, NULL),
(466, 66, 12, 38, NULL, NULL),
(467, 66, 13, 40, NULL, NULL),
(468, 66, 14, 46, NULL, NULL),
(469, 66, 15, 50, NULL, NULL),
(470, 66, 16, 53, NULL, NULL),
(471, 66, 17, 55, NULL, NULL),
(472, 67, 19, 63, NULL, NULL),
(473, 68, 9, 26, NULL, NULL),
(474, 68, 10, 28, NULL, NULL),
(475, 68, 11, 33, NULL, NULL),
(476, 67, 20, 68, NULL, NULL),
(477, 68, 12, 38, NULL, NULL),
(478, 67, 21, 71, NULL, NULL),
(479, 67, 22, 77, NULL, NULL),
(480, 68, 13, 41, NULL, NULL),
(481, 67, 23, 81, NULL, NULL),
(482, 68, 14, 46, NULL, NULL),
(483, 68, 15, 50, NULL, NULL),
(484, 68, 16, 53, NULL, NULL),
(485, 68, 17, 55, NULL, NULL),
(486, 67, 24, 84, NULL, NULL),
(487, 67, 25, 90, NULL, NULL),
(488, 67, 26, 94, NULL, NULL),
(489, 68, 18, 60, NULL, NULL),
(490, 67, 27, 95, NULL, NULL),
(491, 67, 28, 100, NULL, NULL),
(492, 70, 9, 26, NULL, NULL),
(493, 70, 10, 28, NULL, NULL),
(494, 69, 24, 83, NULL, NULL),
(495, 70, 11, 33, NULL, NULL),
(496, 70, 12, 38, NULL, NULL),
(497, 70, 13, 40, NULL, NULL),
(498, 70, 14, 46, NULL, NULL),
(499, 69, 25, 87, NULL, NULL),
(500, 69, 26, 94, NULL, NULL),
(501, 69, 27, 95, NULL, NULL),
(502, 70, 15, 50, NULL, NULL),
(503, 70, 16, 53, NULL, NULL),
(504, 70, 17, 55, NULL, NULL),
(505, 70, 18, 60, NULL, NULL),
(506, 69, 28, 100, NULL, NULL),
(507, 69, 29, 103, NULL, NULL),
(508, 69, 30, 108, NULL, NULL),
(509, 69, 31, 113, NULL, NULL),
(510, 69, 32, 116, NULL, NULL),
(511, 69, 33, 122, NULL, NULL),
(512, 71, 24, 83, NULL, NULL),
(513, 71, 25, 90, NULL, NULL),
(514, 71, 26, 94, NULL, NULL),
(515, 71, 27, 95, NULL, NULL),
(516, 71, 28, 100, NULL, NULL),
(517, 71, 29, 103, NULL, NULL),
(518, 71, 30, 108, NULL, NULL),
(519, 71, 31, 113, NULL, NULL),
(520, 71, 32, 116, NULL, NULL),
(521, 71, 33, 122, NULL, NULL),
(522, 73, 34, 124, NULL, NULL),
(523, 72, 34, 124, NULL, NULL),
(524, 72, 36, 134, NULL, NULL),
(525, 77, 34, 124, NULL, NULL),
(526, 75, 34, 124, NULL, NULL),
(527, 76, 34, 124, NULL, NULL),
(528, 77, 35, 129, NULL, NULL),
(529, 72, 37, 138, NULL, NULL),
(530, 77, 36, 134, NULL, NULL),
(531, 77, 37, 138, NULL, NULL),
(532, 78, 36, 134, NULL, NULL),
(533, 78, 37, 138, NULL, NULL),
(534, 74, 26, 94, NULL, NULL),
(535, 78, 38, 139, NULL, NULL),
(536, 72, 38, 139, NULL, NULL),
(537, 73, 38, 141, NULL, NULL),
(538, 73, 39, 145, NULL, NULL),
(539, 77, 40, 150, NULL, NULL),
(540, 77, 39, 146, NULL, NULL),
(541, 77, 38, 139, NULL, NULL),
(542, 76, 35, 129, NULL, NULL),
(543, 75, 35, 129, NULL, NULL),
(544, 77, 41, 151, NULL, NULL),
(545, 75, 37, 138, NULL, NULL),
(546, 76, 37, 138, NULL, NULL),
(547, 77, 42, 158, NULL, NULL),
(548, 74, 29, 103, NULL, NULL),
(549, 74, 30, 108, NULL, NULL),
(550, 82, 34, 123, NULL, NULL),
(551, 73, 41, 154, NULL, NULL),
(552, 82, 35, 130, NULL, NULL),
(553, 73, 42, 158, NULL, NULL),
(554, 74, 31, 113, NULL, NULL),
(555, 81, 34, 125, NULL, NULL),
(556, 72, 41, 153, NULL, NULL),
(557, 79, 34, 126, NULL, NULL),
(558, 82, 36, 134, NULL, NULL),
(559, 72, 42, 158, NULL, NULL),
(560, 77, 43, 162, NULL, NULL),
(561, 78, 40, 150, NULL, NULL),
(562, 81, 35, 129, NULL, NULL),
(563, 78, 41, 151, NULL, NULL),
(564, 79, 35, 129, NULL, NULL),
(565, 78, 42, 158, NULL, NULL),
(566, 73, 43, 162, NULL, NULL),
(567, 76, 39, 144, NULL, NULL),
(568, 75, 39, 144, NULL, NULL),
(569, 78, 43, 159, NULL, NULL),
(570, 74, 24, 83, NULL, NULL),
(571, 74, 25, 89, NULL, NULL),
(572, 79, 36, 134, NULL, NULL),
(573, 81, 38, 140, NULL, NULL),
(574, 74, 28, 100, NULL, NULL),
(575, 79, 37, 138, NULL, NULL),
(576, 84, 19, 64, NULL, NULL),
(577, 87, 34, 124, NULL, NULL),
(578, 81, 41, 153, NULL, NULL),
(579, 86, 14, 44, NULL, NULL),
(580, 76, 42, 158, NULL, NULL),
(581, 87, 35, 129, NULL, NULL),
(582, 82, 38, 139, NULL, NULL),
(583, 83, 35, 129, NULL, NULL),
(584, 81, 42, 158, NULL, NULL),
(585, 84, 24, 86, NULL, NULL),
(586, 85, 36, 134, NULL, NULL),
(587, 74, 27, 95, NULL, NULL),
(588, 87, 36, 134, NULL, NULL),
(589, 87, 37, 138, NULL, NULL),
(590, 87, 38, 139, NULL, NULL),
(591, 87, 39, 144, NULL, NULL),
(592, 87, 40, 150, NULL, NULL),
(593, 84, 27, 98, NULL, NULL),
(594, 79, 38, 139, NULL, NULL),
(595, 81, 43, 162, NULL, NULL),
(596, 88, 19, 64, NULL, NULL),
(597, 87, 41, 151, NULL, NULL),
(598, 84, 28, 100, NULL, NULL),
(599, 87, 42, 158, NULL, NULL),
(600, 83, 37, 138, NULL, NULL),
(601, 86, 17, 55, NULL, NULL),
(602, 87, 43, 162, NULL, NULL),
(603, 79, 39, 144, NULL, NULL),
(604, 74, 32, 117, NULL, NULL),
(605, 79, 40, 150, NULL, NULL),
(606, 74, 33, 122, NULL, NULL),
(607, 79, 41, 152, NULL, NULL),
(608, 79, 42, 158, NULL, NULL),
(609, 89, 31, 114, NULL, NULL),
(610, 79, 43, 162, NULL, NULL),
(611, 89, 32, 118, NULL, NULL),
(612, 83, 40, 150, NULL, NULL),
(613, 90, 36, 131, NULL, NULL),
(614, 88, 26, 94, NULL, NULL),
(615, 90, 37, 137, NULL, NULL),
(616, 90, 38, 139, NULL, NULL),
(617, 93, 39, 143, NULL, NULL),
(618, 88, 27, 95, NULL, NULL),
(619, 90, 39, 145, NULL, NULL),
(620, 92, 34, 124, NULL, NULL),
(621, 90, 40, 149, NULL, NULL),
(622, 93, 40, 150, NULL, NULL),
(623, 92, 35, 129, NULL, NULL),
(624, 90, 41, 153, NULL, NULL),
(625, 93, 41, 151, NULL, NULL),
(626, 92, 36, 134, NULL, NULL),
(627, 92, 37, 138, NULL, NULL),
(628, 90, 42, 155, NULL, NULL),
(629, 92, 38, 139, NULL, NULL),
(630, 93, 43, 160, NULL, NULL),
(631, 90, 43, 162, NULL, NULL),
(632, 83, 42, 158, NULL, NULL),
(633, 93, 44, 166, NULL, NULL),
(634, 93, 45, 170, NULL, NULL),
(635, 92, 39, 144, NULL, NULL),
(636, 93, 46, 171, NULL, NULL),
(637, 94, 34, 124, NULL, NULL),
(638, 93, 47, 177, NULL, NULL),
(639, 92, 40, 150, NULL, NULL),
(640, 93, 48, 182, NULL, NULL),
(641, 91, 34, 126, NULL, NULL),
(642, 92, 41, 152, NULL, NULL),
(643, 94, 35, 130, NULL, NULL),
(644, 92, 42, 158, NULL, NULL),
(645, 91, 35, 130, NULL, NULL),
(646, 92, 43, 162, NULL, NULL),
(647, 94, 36, 134, NULL, NULL),
(648, 91, 36, 134, NULL, NULL),
(649, 94, 37, 138, NULL, NULL),
(650, 94, 38, 139, NULL, NULL),
(651, 91, 37, 138, NULL, NULL),
(652, 83, 43, 162, NULL, NULL),
(653, 94, 39, 144, NULL, NULL),
(654, 94, 40, 150, NULL, NULL),
(655, 97, 19, 64, NULL, NULL),
(656, 91, 39, 144, NULL, NULL),
(657, 91, 40, 150, NULL, NULL),
(658, 95, 9, 26, NULL, NULL),
(659, 94, 41, 151, NULL, NULL),
(660, 96, 41, 152, NULL, NULL),
(661, 96, 42, 158, NULL, NULL),
(662, 96, 43, 162, NULL, NULL),
(663, 94, 42, 158, NULL, NULL),
(664, 97, 20, 70, NULL, NULL),
(665, 94, 43, 162, NULL, NULL),
(666, 97, 21, 71, NULL, NULL),
(667, 96, 48, 182, NULL, NULL),
(668, 99, 39, 145, NULL, NULL),
(669, 97, 22, 77, NULL, NULL),
(670, 95, 12, 38, NULL, NULL),
(671, 95, 13, 41, NULL, NULL),
(672, 97, 23, 81, NULL, NULL),
(673, 99, 40, 150, NULL, NULL),
(674, 99, 41, 151, NULL, NULL),
(675, 99, 42, 158, NULL, NULL),
(676, 98, 35, 129, NULL, NULL),
(677, 95, 15, 50, NULL, NULL),
(678, 99, 43, 162, NULL, NULL),
(679, 97, 24, 83, NULL, NULL),
(680, 95, 16, 53, NULL, NULL),
(681, 98, 36, 132, NULL, NULL),
(682, 97, 25, 90, NULL, NULL),
(683, 100, 24, 83, NULL, NULL),
(684, 99, 44, 166, NULL, NULL),
(685, 99, 45, 170, NULL, NULL),
(686, 97, 26, 93, NULL, NULL),
(687, 98, 37, 138, NULL, NULL),
(688, 95, 17, 57, NULL, NULL),
(689, 97, 27, 98, NULL, NULL),
(690, 99, 46, 171, NULL, NULL),
(691, 98, 39, 145, NULL, NULL),
(692, 100, 25, 89, NULL, NULL),
(693, 97, 28, 100, NULL, NULL),
(694, 100, 26, 93, NULL, NULL),
(695, 95, 18, 59, NULL, NULL),
(696, 99, 47, 175, NULL, NULL),
(697, 99, 48, 182, NULL, NULL),
(698, 100, 27, 97, NULL, NULL),
(699, 98, 40, 148, NULL, NULL),
(700, 100, 28, 102, NULL, NULL),
(701, 98, 41, 153, NULL, NULL),
(702, 98, 42, 155, NULL, NULL),
(703, 100, 29, 103, NULL, NULL),
(704, 98, 43, 161, NULL, NULL),
(705, 100, 30, 108, NULL, NULL),
(706, 100, 31, 113, NULL, NULL),
(707, 100, 32, 117, NULL, NULL),
(708, 101, 24, 84, NULL, NULL),
(709, 101, 25, 89, NULL, NULL),
(710, 102, 34, 126, NULL, NULL),
(711, 103, 49, 186, NULL, NULL),
(712, 101, 26, 93, NULL, NULL),
(713, 101, 27, 95, NULL, NULL),
(714, 100, 33, 119, NULL, NULL),
(715, 101, 28, 100, NULL, NULL),
(716, 102, 35, 127, NULL, NULL),
(717, 103, 50, 188, NULL, NULL),
(718, 102, 36, 134, NULL, NULL),
(719, 103, 51, 194, NULL, NULL),
(720, 101, 29, 103, NULL, NULL),
(721, 103, 52, 198, NULL, NULL),
(722, 102, 37, 138, NULL, NULL),
(723, 104, 24, 83, NULL, NULL),
(724, 104, 25, 89, NULL, NULL),
(725, 104, 26, 93, NULL, NULL),
(726, 103, 53, 199, NULL, NULL),
(727, 101, 30, 108, NULL, NULL),
(728, 102, 38, 139, NULL, NULL),
(729, 101, 31, 113, NULL, NULL),
(730, 101, 32, 115, NULL, NULL),
(731, 101, 33, 121, NULL, NULL),
(732, 102, 39, 145, NULL, NULL),
(733, 102, 40, 150, NULL, NULL),
(734, 103, 54, 203, NULL, NULL),
(735, 102, 41, 151, NULL, NULL),
(736, 104, 27, 95, NULL, NULL),
(737, 102, 42, 158, NULL, NULL),
(738, 102, 43, 162, NULL, NULL),
(739, 106, 24, 83, NULL, NULL),
(740, 104, 28, 99, NULL, NULL),
(741, 106, 25, 90, NULL, NULL),
(742, 104, 29, 103, NULL, NULL),
(743, 103, 55, 210, NULL, NULL),
(744, 107, 24, 86, NULL, NULL),
(745, 106, 26, 94, NULL, NULL),
(746, 107, 25, 90, NULL, NULL),
(747, 107, 26, 93, NULL, NULL),
(748, 107, 27, 96, NULL, NULL),
(749, 103, 56, 213, NULL, NULL),
(750, 106, 27, 95, NULL, NULL),
(751, 106, 28, 100, NULL, NULL),
(752, 107, 28, 100, NULL, NULL),
(753, 104, 30, 108, NULL, NULL),
(754, 107, 29, 103, NULL, NULL),
(755, 107, 30, 108, NULL, NULL),
(756, 103, 57, 216, NULL, NULL),
(757, 106, 29, 103, NULL, NULL),
(758, 107, 31, 112, NULL, NULL),
(759, 107, 32, 116, NULL, NULL),
(760, 104, 31, 113, NULL, NULL),
(761, 106, 30, 108, NULL, NULL),
(762, 104, 32, 116, NULL, NULL),
(763, 107, 33, 121, NULL, NULL),
(764, 104, 33, 122, NULL, NULL),
(765, 106, 31, 113, NULL, NULL),
(766, 103, 58, 219, NULL, NULL),
(767, 106, 32, 116, NULL, NULL),
(768, 109, 24, 83, NULL, NULL),
(769, 109, 25, 87, NULL, NULL),
(770, 108, 24, 83, NULL, NULL),
(771, 106, 33, 122, NULL, NULL),
(772, 109, 26, 91, NULL, NULL),
(773, 108, 25, 89, NULL, NULL),
(774, 109, 27, 95, NULL, NULL),
(775, 109, 28, 100, NULL, NULL),
(776, 109, 29, 103, NULL, NULL),
(777, 109, 30, 108, NULL, NULL),
(778, 109, 31, 111, NULL, NULL),
(779, 110, 24, 86, NULL, NULL),
(780, 109, 32, 115, NULL, NULL),
(781, 110, 25, 89, NULL, NULL),
(782, 110, 26, 94, NULL, NULL),
(783, 109, 33, 119, NULL, NULL),
(784, 110, 27, 95, NULL, NULL),
(785, 108, 27, 95, NULL, NULL),
(786, 110, 28, 100, NULL, NULL),
(787, 108, 28, 100, NULL, NULL),
(788, 110, 29, 103, NULL, NULL),
(789, 108, 29, 103, NULL, NULL),
(790, 110, 30, 108, NULL, NULL),
(791, 112, 39, 145, NULL, NULL),
(792, 112, 40, 149, NULL, NULL),
(793, 112, 41, 152, NULL, NULL),
(794, 108, 30, 108, NULL, NULL),
(795, 112, 42, 155, NULL, NULL),
(796, 112, 43, 162, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `or_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `or_status` int(11) NOT NULL DEFAULT 0,
  `or_created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `or_modified_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pertanyaan`
--

CREATE TABLE `tbl_pertanyaan` (
  `pertanyaan_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `kategori` varchar(200) DEFAULT NULL,
  `teks_pertanyaan` text NOT NULL,
  `tipe_pertanyaan` enum('pilihan_ganda','isian') NOT NULL,
  `maks_nilai` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_pertanyaan`
--

INSERT INTO `tbl_pertanyaan` (`pertanyaan_id`, `course_id`, `kategori`, `teks_pertanyaan`, `tipe_pertanyaan`, `maks_nilai`) VALUES
(1, 1, 'Pretest', 'Pengolahan otomatis oleh mesin mempelajari pola berdasarkan data, disebut', 'pilihan_ganda', 0),
(2, 1, 'Pretest', 'Pengolahan otomatis oleh mesin mempelajari pola berdasarkan data, disebut', 'pilihan_ganda', 0),
(3, 1, 'Pretest', 'Pengolahan otomatis oleh mesin mempelajari pola berdasarkan data, disebut', 'pilihan_ganda', 0),
(4, 8, 'Modul 1', 'Pentingnya pengumpulan data', 'pilihan_ganda', 10),
(5, 8, 'Modul 1', 'Pengumpulan data dalam bisnis apa saja yang dikumpulkan', 'pilihan_ganda', 10),
(6, 8, 'Modul 1', 'Survei dan wawancara termasuk jenis data apa', 'pilihan_ganda', 10),
(7, 8, 'Modul 1', 'Tujuan pengumpulan data dalam bidang bisnis', 'pilihan_ganda', 10),
(8, 8, 'Modul 1', 'Pada bagian perencanaan data, mana yang termasuk pada bagian tersebut?', 'pilihan_ganda', 10),
(9, 8, 'Modul 1', 'Pemilihan metode yang tidak sesuai dapat berpengaruh terhadap, kecuali?', 'pilihan_ganda', 10),
(10, 8, 'Modul 1', 'Berikut ini jenis pengumpulan data kualitatif , kecuali?', 'pilihan_ganda', 10),
(11, 8, 'Modul 1', 'Kerangka PICOS terdiri dari apa saja, kecuali?', 'pilihan_ganda', 10),
(12, 8, 'Modul 1', 'Berikut contoh yang kurang tepat penggunaan PICOS', 'pilihan_ganda', 10),
(13, 8, 'Modul 1', 'Manfaat penyaringan data', 'pilihan_ganda', 10),
(14, 8, 'Modul 1', 'Mengidentifikasi dan menghapus data disebut?', 'pilihan_ganda', 10),
(15, 8, 'Modul 1', 'Definisi dari penyaringan kategori tertentu (Categorical Filtering)', 'pilihan_ganda', 10),
(16, 8, 'Modul 1', 'Menyaring data berdasarkan rentang waktu tertentu untuk melihat tren spesifik Pattern Filtering', 'pilihan_ganda', 10),
(17, 8, 'Modul 1', 'Yang tidak termasuk jenis metode triangulasi', 'pilihan_ganda', 10),
(18, 8, 'Modul 1', 'Dalam membuat penelitan perlu memperhatikan apa saja?', 'pilihan_ganda', 10),
(19, 8, 'Modul 2', 'Pengumpulan data dengan cara mengukur data dan menghitung statistik disebut?', 'pilihan_ganda', 10),
(20, 8, 'Modul 2', 'Mana yang tidak termasuk tujuan pengumpulan data', 'pilihan_ganda', 10),
(21, 8, 'Modul 2', 'Wawancara yang menggunkaan pertanyaan telah disiapkan disebut', 'pilihan_ganda', 10),
(22, 8, 'Modul 2', 'Berikut ini yang merupakan pemilihan pengorganisasi sesi grup disebut', 'pilihan_ganda', 10),
(23, 8, 'Modul 2', 'Dalam kontek sosial, observasi yang melibatkan peneliti disebut', 'pilihan_ganda', 10),
(24, 8, 'Modul 2', 'Salah satu instrumen penting dalam kuisioner adalah', 'pilihan_ganda', 10),
(25, 8, 'Modul 2', 'Manakah yang merupakan metode pengumpulan data kualitatif?', 'pilihan_ganda', 10),
(26, 8, 'Modul 2', 'Manakah yang merupakan metode pengumpulan data kuantitatif?', 'pilihan_ganda', 10),
(27, 8, 'Modul 2', 'Jika ingin mengukur atau menguji hipotesis dilakukan metode apa', 'pilihan_ganda', 10),
(28, 8, 'Modul 2', 'Fokus pada pemahaman subjektif dimasukan dalam jenis penelitian apa?', 'pilihan_ganda', 10),
(29, 8, 'Modul 2', 'Berikut yang termasuk tahapan awal dalam pengumpulan data', 'pilihan_ganda', 10),
(30, 8, 'Modul 2', 'Bagian dalam pengumpulan data yang berisikan rangkuman hasil analisis data disebut', 'pilihan_ganda', 10),
(31, 8, 'Modul 2', 'Contoh pengembangan produk lebih tepat menggunakan pendekatan apa', 'pilihan_ganda', 10),
(32, 8, 'Modul 2', 'Contoh penjualan dan tren pasar lebih tepat menggunakan pendekatan apa', 'pilihan_ganda', 10),
(33, 8, 'Modul 2', 'Apa sajakah variabel yang diukur dalam contoh penelitian survei kepuasan pelangganTingkat kepuasan', 'pilihan_ganda', 10),
(34, 8, 'Modul 3', 'Yang bukan termasuk pengertian literature review', 'pilihan_ganda', 10),
(35, 8, 'Modul 3', 'Termasuk jenis-jenis literature review', 'pilihan_ganda', 10),
(36, 8, 'Modul 3', 'Apa saja manfaat literature review', 'pilihan_ganda', 10),
(37, 8, 'Modul 3', 'Apa saja yang harus disiapkan dalam penulisan literature review', 'pilihan_ganda', 10),
(38, 8, 'Modul 3', 'Untuk menghindari tsunami literartur diperlukan pemilihan jurnal terindeks, kecuali?', 'pilihan_ganda', 10),
(39, 8, 'Modul 3', 'Hasil literature review berupa rangkuman, analisis,  dan sintesis disebut', 'pilihan_ganda', 10),
(40, 8, 'Modul 3', 'Pada bagian pendahuluan berisi tentang', 'pilihan_ganda', 10),
(41, 8, 'Modul 3', 'Kesenjangan Penelitian masuk dalam bagian apa', 'pilihan_ganda', 10),
(42, 8, 'Modul 3', 'Teknik penulisan yang efektif', 'pilihan_ganda', 10),
(43, 8, 'Modul 3', 'Apa saja yang diperhatikan dalam penyajian dan visualisasi data, kecuali', 'pilihan_ganda', 10),
(44, 8, 'Modul 3', 'Pada tahapan penilaian hasil, terdapat metrik evaluasi yang berisi', 'pilihan_ganda', 10),
(45, 8, 'Modul 3', 'Jenis2 daftar pustaka yang sering digunakan', 'pilihan_ganda', 10),
(46, 8, 'Modul 3', 'Gap penelitian adalah', 'pilihan_ganda', 10),
(47, 8, 'Modul 3', 'Peer Review diperlukan untuk', 'pilihan_ganda', 10),
(48, 8, 'Modul 3', 'Apa yang dilakukan setelah peer review', 'pilihan_ganda', 10),
(49, 8, 'Modul 4', 'Mengapa SWOT diperlukan', 'pilihan_ganda', 10),
(50, 8, 'Modul 4', 'Faktor internal yang dapat menghambat organisasi karena keterbatasan adalah', 'pilihan_ganda', 10),
(51, 8, 'Modul 4', 'Aplikasi yang diterapkan SWOT antara lain', 'pilihan_ganda', 10),
(52, 8, 'Modul 4', 'Teknik yang diterapkan dalam pengumpulan data', 'pilihan_ganda', 10),
(53, 8, 'Modul 4', 'Teknik yang mengandalkan individu sebagai kunci dalam memberikan informasi secara detail disebut', 'pilihan_ganda', 10),
(54, 8, 'Modul 4', 'Tahapan dalam pembuatan SWOT aoa saja', 'pilihan_ganda', 10),
(55, 8, 'Modul 4', 'Tabel EFAS terdiri dari', 'pilihan_ganda', 10),
(56, 8, 'Modul 4', 'Yang tidak perlu dimasukan dalam tabel IFAS dan EFAS', 'pilihan_ganda', 10),
(57, 8, 'Modul 4', 'Dalam Diagram Kartesisus, terdiri dari IV kuadran, kecuali', 'pilihan_ganda', 10),
(58, 8, 'Modul 4', 'Mendapatkan nilai diagram kartisisus rumusnya', 'pilihan_ganda', 10),
(59, 8, 'Modul 4', 'Bagaimana mengatasi pengembangan kekuatan', 'pilihan_ganda', 10),
(60, 8, 'Modul 4', 'Pelatihan karwayan salah satu cara aopa', 'pilihan_ganda', 10),
(61, 8, 'Modul 4', 'Penciptaan Kemitraan Strategis termasuk apa', 'pilihan_ganda', 10),
(62, 8, 'Modul 4', 'Subjektivitas analis', 'pilihan_ganda', 10),
(63, 8, 'Modul 4', 'Perubahan lingkungan bisnis, kecuali', 'pilihan_ganda', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_phases`
--

CREATE TABLE `tbl_phases` (
  `phase_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `phase_name` varchar(255) NOT NULL,
  `phase_desc` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_phases`
--

INSERT INTO `tbl_phases` (`phase_id`, `project_id`, `phase_name`, `phase_desc`, `status`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Phase prep', 'init github repo and init regular meeting', 'complete', '2025-02-04', '2025-02-06', '2025-02-09 10:39:18', '2025-03-01 14:00:14'),
(3, 3, 'fase a', 'baal1', NULL, '2025-02-09', '2025-02-15', '2025-02-09 11:45:13', '2025-02-09 13:11:37'),
(6, 6, 'fase prep', 'balala', 'in_progress', '2025-02-09', '2025-02-15', '2025-02-09 11:51:33', '2025-02-18 17:56:19'),
(7, 6, 'fase development', 'blalala', 'created', '2025-02-10', '2025-02-16', '2025-02-09 12:20:05', '2025-02-18 17:56:19'),
(8, 6, 'fase testing', 'balalala', 'created', '2025-02-24', '2025-02-28', '2025-02-13 15:14:26', '2025-02-18 17:56:19'),
(9, 7, 'phase 1', 'versi 1', 'created', '2025-02-16', '2025-02-17', '2025-02-16 12:29:33', '2025-02-18 17:56:42'),
(10, 8, 'persiapan material', 'melakukan list dan pembelian material yg dibutuhkan', 'created', '2025-02-23', '2025-02-24', '2025-02-16 12:34:49', '2025-03-08 07:23:32'),
(11, 9, 'preparation repo', 'init repo, add collaborator, init template', 'created', '2025-02-19', '2025-02-21', '2025-02-18 17:55:19', '2025-02-18 17:55:55'),
(12, 10, 'fase nunggu', 'menunggu antrian app kai access', 'created', '2025-02-19', '2025-02-20', '2025-02-18 18:06:11', '2025-03-08 07:24:59'),
(13, 11, 'preparation', 'prep phase', 'created', '2025-03-08', '2025-03-08', '2025-03-08 07:19:49', '2025-03-08 07:20:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pilihan_jawaban`
--

CREATE TABLE `tbl_pilihan_jawaban` (
  `pilihan_id` int(11) NOT NULL,
  `pertanyaan_id` int(11) DEFAULT NULL,
  `teks_pilihan` text NOT NULL,
  `is_jawaban_benar` tinyint(1) NOT NULL,
  `maks_nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_pilihan_jawaban`
--

INSERT INTO `tbl_pilihan_jawaban` (`pilihan_id`, `pertanyaan_id`, `teks_pilihan`, `is_jawaban_benar`, `maks_nilai`) VALUES
(1, 1, 'Machine Learning', 1, 10),
(2, 1, 'Text Mining', 0, 0),
(3, 4, 'Dasar pengambilan keputusan strategis', 1, 10),
(4, 4, 'Membuat planning menjadi lebih mudah', 0, 0),
(5, 4, 'Agar lebih berhati-hati', 0, 0),
(6, 4, 'Mempermudah penyusunan anggaran', 0, 0),
(7, 5, 'Reabilitas studi penelitian terbaru terkait bisnis', 0, 0),
(8, 5, 'untung dan rugi dalam setiap bisnis', 0, 0),
(9, 5, 'Mengidentifikasi perilaku, konsumen, pasar', 1, 10),
(10, 5, 'jenis-jenis kesukaan pasar', 0, 0),
(11, 6, 'Primer', 1, 10),
(12, 6, 'Sekunder', 0, 0),
(13, 6, 'Kualitatif', 0, 0),
(14, 6, 'Kuantitatif', 0, 0),
(15, 7, 'Melihat fenomena', 0, 0),
(16, 7, 'Menguji hipotesis', 0, 0),
(17, 7, 'Melihat hal strategis', 0, 0),
(18, 7, 'Pengambilan keputusan dan analisis pasar', 1, 10),
(19, 8, 'Menetapkan keterbatasan penelitian', 0, 0),
(20, 8, 'Menjelaskan masalah yang dipilih', 0, 0),
(21, 8, 'Menentukan tujuan', 1, 10),
(22, 8, 'Membuat list pertanyaan', 0, 0),
(23, 9, 'Kualitas hasil penelitian', 0, 0),
(24, 9, 'Akurasi data yang diperoleh', 0, 0),
(25, 9, 'Efektivitas pengumpulan', 0, 0),
(26, 9, 'Waktu pengumpulan', 1, 10),
(27, 10, 'Survei', 0, 0),
(28, 10, 'Statistik', 1, 10),
(29, 10, 'Wawancara', 0, 0),
(30, 10, 'Kuisioner', 0, 0),
(31, 11, 'Population', 0, 0),
(32, 11, 'Intervention', 0, 0),
(33, 11, 'Comparative', 1, 10),
(34, 11, 'Comparison', 0, 0),
(35, 12, 'Apakah strategi digital marketing lebih efektif dibandingkan iklan konvesional dalam meningkatkan penjualan perusaan ritel?', 1, 10),
(36, 12, 'Apakah pengaruh kebijakan work from home menimbulkan produktivitas menurun bagi karyawan perusahaan?', 0, 0),
(37, 12, 'Apakah program loyalitas pelanggan dapat berpengaruh terhadap pelanggan e-commerce?', 0, 0),
(38, 12, 'Seberapa besar tingkatan faktor ESG (Enviroment, Social, Government) terhadap kondisi pasar saham?', 0, 0),
(39, 13, 'Memberikan insight dalam tahapan berikutnya yaitu pengolahan data', 0, 0),
(40, 13, 'Memahami pola dari data', 0, 0),
(41, 13, 'Memastiikan hanya informasi relevan dan berkualitas', 1, 10),
(42, 13, 'menetukan teknik dan alat yang digunakan', 0, 0),
(43, 14, 'Correlation Filtering', 0, 0),
(44, 14, 'Sampling-Based Filtering', 0, 0),
(45, 14, 'Pattern Filtering', 0, 0),
(46, 14, 'Outlier Detection & Removal', 1, 10),
(47, 15, 'Aturan tertentu untuk memilih data dengan syarat tertentu', 0, 0),
(48, 15, 'menetapkan nilai minimum dan maksimum', 0, 0),
(49, 15, 'Menandai data duplikat tidak mempengaruhi hasil', 0, 0),
(50, 15, 'Memilih data berdasarkan kategori ternteu', 1, 10),
(51, 16, 'Content-Based Filtering', 0, 0),
(52, 16, 'Sampling-Based Filtering', 0, 0),
(53, 16, 'Time-Based Filtering', 1, 10),
(54, 16, 'Outlier Detection & Removal', 0, 0),
(55, 17, 'Pola Kasus', 1, 10),
(56, 17, 'Teori', 0, 0),
(57, 17, 'Peneliti', 0, 0),
(58, 17, 'Waktu', 0, 0),
(59, 18, 'Data Bias', 0, 0),
(60, 18, 'Privasi Responden', 1, 10),
(61, 18, 'Keterbatasan Penelitian', 0, 0),
(62, 18, 'Waktu Penelitian', 0, 0),
(63, 19, 'Kualitatif', 0, 0),
(64, 19, 'Kuantitatif', 1, 10),
(65, 19, 'Primer', 0, 0),
(66, 19, 'Sekunder', 0, 0),
(67, 20, 'Mengidentifikasi kebutuhan dan harapan', 0, 0),
(68, 20, 'Memahami dinamika lingkungan', 0, 0),
(69, 20, 'Evaluasi kinerja', 0, 0),
(70, 20, 'Evaluasi efektivitas strategi', 1, 10),
(71, 21, 'Terstruktur', 1, 10),
(72, 21, 'Tidak Terstruktur', 0, 0),
(73, 21, 'Semi Terstruktur', 0, 0),
(74, 21, 'Campuran', 0, 0),
(75, 22, 'Wawancara', 0, 0),
(76, 22, 'Survey', 0, 0),
(77, 22, 'Focus Group Discussion', 1, 10),
(78, 22, 'Survey', 0, 0),
(79, 23, 'Observasi Non-Partisipatif', 0, 0),
(80, 23, 'Observasi Peneliti Terlibat', 0, 0),
(81, 23, 'Observasi Partisipatif', 1, 10),
(82, 23, 'Observasi Peneliti Tidak Terlibat', 0, 0),
(83, 24, 'Pedoman wawancara', 1, 10),
(84, 24, 'Menghitung sampel', 0, 0),
(85, 24, 'Mengetahui populasi', 0, 0),
(86, 24, 'Penentuan alat sampel', 0, 0),
(87, 25, 'Wawancara mendalam', 0, 0),
(88, 25, 'Kuisioner', 0, 0),
(89, 25, 'Observasi Partisipatif', 0, 0),
(90, 25, 'Semua Benar', 1, 10),
(91, 26, 'Angket', 0, 0),
(92, 26, 'Tes', 0, 0),
(93, 26, 'Statistik', 1, 10),
(94, 26, 'Semua Benar', 0, 0),
(95, 27, 'Kuantitatif', 1, 10),
(96, 27, 'Kualitatif', 0, 0),
(97, 27, 'Campuran', 0, 0),
(98, 27, 'Semua Benar', 0, 0),
(99, 28, 'Campuran', 0, 0),
(100, 28, 'Kualitatif', 1, 10),
(101, 28, 'Kuantitatif', 0, 0),
(102, 28, 'Semua Benar', 0, 0),
(103, 29, 'Identifikasi sumber data', 1, 10),
(104, 29, 'Analisis Data Tepat', 0, 0),
(105, 29, 'Penyajian Data yang menarik', 0, 0),
(106, 29, 'penetapan validitas data', 0, 0),
(107, 30, 'Rekomendasi', 0, 0),
(108, 30, 'Kesimpulan', 1, 10),
(109, 30, 'Background', 0, 0),
(110, 30, 'Abstract', 0, 0),
(111, 31, 'Kualitatif', 1, 10),
(112, 31, 'Kuantitatif', 0, 0),
(113, 31, 'Campuran', 0, 0),
(114, 31, 'Semua Benar', 0, 0),
(115, 32, 'Kualitatif', 0, 0),
(116, 32, 'Kuantitatif', 1, 10),
(117, 32, 'Campuran', 0, 0),
(118, 32, 'Semua Benar', 0, 0),
(119, 33, 'Tingkat Kepuasan Pelanggan', 0, 0),
(120, 33, 'Loyalitas pelanggan', 0, 0),
(121, 33, 'Produk atau layanan yang ditawarkan', 0, 0),
(122, 33, 'Semua Benar', 1, 10),
(123, 34, 'Menyusun infomrasi dan mengidentifikasi gap penelitian', 0, 0),
(124, 34, 'Mengikuti tren penelitian terbaru', 0, 0),
(125, 34, 'pemahaman state of the art dari topik yang diplih', 0, 0),
(126, 34, 'Publikasi relevan', 1, 10),
(127, 35, 'eksploratif', 0, 0),
(128, 35, 'analitis', 0, 0),
(129, 35, 'sistematif literature review', 1, 10),
(130, 35, 'obervatif', 0, 0),
(131, 36, 'memperdalam pengetahuan', 0, 0),
(132, 36, 'mengetahui perkembangan ilmu yang dipilih', 0, 0),
(133, 36, 'Memperjelas masalah penelitian', 0, 0),
(134, 36, 'Semua Benar', 1, 10),
(135, 37, 'Menetukan fokus penelitian', 0, 0),
(136, 37, 'Merumuskan pertanyaan penelitian', 0, 0),
(137, 37, 'Pengumpulan sumber dan referensi', 0, 0),
(138, 37, 'Semua Benar', 1, 10),
(139, 38, 'Jurnal Predator', 1, 10),
(140, 38, 'Scopus', 0, 0),
(141, 38, 'Sinta', 0, 0),
(142, 38, 'ISI', 0, 0),
(143, 39, 'Techinal Paper', 0, 0),
(144, 39, 'Survey Paper', 1, 10),
(145, 39, 'Systematic Review', 0, 0),
(146, 39, 'Salah Semua', 0, 0),
(147, 40, 'Tujuan', 0, 0),
(148, 40, 'Ruang Lingkup', 0, 0),
(149, 40, 'Latar Belakang Penelitian', 0, 0),
(150, 40, 'Semua Benar', 1, 10),
(151, 41, 'Pendahuluan', 0, 0),
(152, 41, 'Main Body', 1, 10),
(153, 41, 'Analisis', 0, 0),
(154, 41, 'Kesimpulan', 0, 0),
(155, 42, 'Parafrase', 0, 0),
(156, 42, 'Sitasi', 0, 0),
(157, 42, 'Cantumkan sumber penelusi', 0, 0),
(158, 42, 'Semua Benar', 1, 10),
(159, 43, 'Pemilihan tipe grafik yang tepat', 0, 0),
(160, 43, 'Penyusunan Tabel secara logis', 0, 0),
(161, 43, 'Informasi harus mudah dipahami', 0, 0),
(162, 43, 'Ringkasan harus komprehensif', 1, 10),
(163, 44, 'Relevansi penelitian', 0, 0),
(164, 44, 'Kredibilits penelitian', 0, 0),
(165, 44, 'Kontribusi penelitina', 0, 0),
(166, 44, 'Semua Benar', 1, 10),
(167, 45, 'APA', 0, 0),
(168, 45, 'Chicago', 0, 0),
(169, 45, 'Vancouvher', 0, 0),
(170, 45, 'Semua Benar', 1, 10),
(171, 46, 'kondisi kontradiktif antara hasil dan juga yang belum diteliti', 1, 10),
(172, 46, 'topik yang perlu diteliti secara mendalam', 0, 0),
(173, 46, 'usaha untuk mengeksplorasi lebih lanjut', 0, 0),
(174, 46, 'Hasil sejalan dengan tujuan', 0, 0),
(175, 47, 'Peningkatan kualitas', 0, 0),
(176, 47, 'Perspektif baru melalui perbaikan', 1, 10),
(177, 47, 'evaluasi dari mentor', 0, 0),
(178, 47, 'Lebih bervariasi', 0, 0),
(179, 48, 'Perbaikan struiktur', 0, 0),
(180, 48, 'Pengaturan ulang bagian penting', 0, 0),
(181, 48, 'Perbaharui sumber dan referensi', 0, 0),
(182, 48, 'Semua Benar', 1, 10),
(183, 49, 'menilai kekuatan, kelemahan, peluang dan tantangan dalam usaha atau penelitian', 1, 10),
(184, 49, 'agar dapat merancang rencana strategis yang efektif dan adaptif', 0, 0),
(185, 49, 'alat manajemen untuk menganalisis faktor internal dan eksternal', 0, 0),
(186, 49, 'Semua benar', 0, 0),
(187, 50, 'Strenght', 0, 0),
(188, 50, 'Weakness', 1, 10),
(189, 50, 'Opporunity', 0, 0),
(190, 50, 'Threat', 0, 0),
(191, 51, 'Bisnis Kecil', 0, 0),
(192, 51, 'Startup', 0, 0),
(193, 51, 'Perusahaan Besar', 0, 0),
(194, 51, 'Semua Benar', 1, 10),
(195, 52, 'Kuisioner', 0, 0),
(196, 52, 'Wawancara', 0, 0),
(197, 52, 'Literature Review', 0, 0),
(198, 52, 'Semua Benar', 1, 10),
(199, 53, 'Kuisioner', 0, 0),
(200, 53, 'Wawancara', 1, 10),
(201, 53, 'Literature Review', 0, 0),
(202, 53, 'Statistik', 0, 0),
(203, 54, 'Siapkan tabel SWOT, Buat Tabel IFAS dan EFAS, Siapkan Diagram Analisis SWOT, Matriks SWOT', 1, 10),
(204, 54, 'Siapkan tabel SWOT, Buat Tabel IFAS dan EFAS,, Matriks SWOT,  Siapkan Diagram Analisis SWOT', 0, 0),
(205, 54, 'Siapkan tabel SWOT,  Matriks SWOT, Buat Tabel IFAS dan EFAS,, Siapkan Diagram Analisis SWOT', 0, 0),
(206, 54, 'Matriks SWOT, Siapkan tabel SWOT,Buat Tabel IFAS dan EFAS,, Siapkan Diagram Analisis SWOT', 0, 0),
(207, 55, 'Strenght, Weakness', 0, 0),
(208, 55, 'Strength, Opportunities', 0, 0),
(209, 55, 'Weakness, Threat', 0, 0),
(210, 55, 'Threat, Opportunities', 1, 10),
(211, 56, 'Bobot', 0, 0),
(212, 56, 'Rating', 0, 0),
(213, 56, 'Tingkat Signifikasi', 1, 10),
(214, 56, 'Skor', 0, 0),
(215, 57, 'Kuadran I Progresif', 0, 0),
(216, 57, 'Kuadra II: Ubah Strategi', 1, 10),
(217, 57, 'Kuadran III: Ubah Strategi', 0, 0),
(218, 57, 'Kuadran IV: Strategi Bertahan', 0, 0),
(219, 58, 'Y:Opportunites-Threat', 1, 10),
(220, 58, 'Y= Opportunites-Weakness', 0, 0),
(221, 58, 'X: Strenght-Threat', 0, 0),
(222, 58, 'X: Weakness-Opportunities', 0, 0),
(223, 59, 'Memanfaatkan sumber daya', 0, 0),
(224, 59, 'Meningkatkan Keunggulan Kompetitif', 0, 0),
(225, 59, 'Mengidentifikasi dna mengembankan aspek-aspek unik', 0, 0),
(226, 59, 'Semua benar', 1, 10),
(227, 60, 'Pengembangan Kekuatan', 0, 0),
(228, 60, 'Mengatasi Kelemahan', 1, 10),
(229, 60, 'Menangkap Peluang', 0, 0),
(230, 60, 'Menghadapi Ancaman', 0, 0),
(231, 61, 'Pengembangan Kekuatan', 0, 0),
(232, 61, 'Mengatasi Kelemahan', 0, 0),
(233, 61, 'Menangkap Peluang', 0, 0),
(234, 61, 'Menghadapi Ancaman', 1, 10),
(235, 62, 'Kesalahan penilaian', 0, 0),
(236, 62, 'Akibat keterbatasan informasi', 0, 0),
(237, 62, 'Bias dalma data', 0, 0),
(238, 62, 'Benar Semua', 1, 10),
(239, 63, 'Adaptsi tren pasar', 0, 0),
(240, 63, 'Lingkungan bisnis terus berubah', 0, 0),
(241, 63, 'Pasar yang menciptakan peluang', 1, 10),
(242, 63, 'Dampak Ekonomi Global', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `p_id` int(11) NOT NULL,
  `p_jenis` varchar(50) NOT NULL,
  `p_judul` text NOT NULL,
  `p_deskripsi` text DEFAULT NULL,
  `p_img` varchar(200) DEFAULT NULL,
  `p_id_lms` text NOT NULL,
  `p_url_lms` text NOT NULL,
  `p_harga` int(11) DEFAULT NULL,
  `p_status` int(11) NOT NULL DEFAULT 0,
  `p_created_date` timestamp NULL DEFAULT NULL,
  `p_modified_date` timestamp NULL DEFAULT NULL,
  `p_start_date` timestamp NULL DEFAULT NULL,
  `p_end_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`p_id`, `p_jenis`, `p_judul`, `p_deskripsi`, `p_img`, `p_id_lms`, `p_url_lms`, `p_harga`, `p_status`, `p_created_date`, `p_modified_date`, `p_start_date`, `p_end_date`) VALUES
(1, 'course', 'Natural Language Processing (NLP) Basics', 'Learn the basics of NLP, including text processing, sentiment analysis, and language generation.', 'uploads/course/course1_1711803657.jpg', '4', 'https://ems.ai4talent.my.id/course/natural-language-processing-nlp-basics', 10000, 0, '2025-01-22 13:29:57', '2025-03-16 06:36:34', '2024-01-21 08:55:00', '2024-01-22 09:15:00'),
(2, 'course', 'AI and Robotics Integration', 'Explore the integration of AI and robotics, including robot control and perception.', 'uploads/course/course13_1711803683.jpg', '9', 'https://ems.ai4talent.my.id/course/ai-and-robotics-integration', 30000, 0, '2025-01-20 07:34:23', '2025-03-16 06:36:26', '2024-01-21 08:55:00', '2024-01-22 09:15:00'),
(3, 'course', 'AI for Finance', 'Analyze the application of AI in financial markets, risk assessment, and investment strategies.', 'uploads/course/course14_1711803699.jpg', '11', 'https://ems.ai4talent.my.id/course/ai-for-finance', 10000, 0, '2025-01-20 07:34:29', '2025-03-16 06:36:18', '2024-03-29 02:54:00', '2024-04-01 02:54:00'),
(4, 'course', 'AI for Marketing', 'Explore AI-driven marketing strategies, including customer segmentation and personalized campaigns.', 'uploads/course/course15_1711803710.jpg', '12', 'https://ems.ai4talent.my.id/course/ai-for-marketing', 20000, 0, '2025-01-20 07:34:38', '2025-03-16 06:36:11', '2024-03-30 02:55:00', '2024-04-06 02:55:00'),
(5, 'course', 'Computer Vision Fundamentals', 'An in-depth look at computer vision techniques, object detection, and image recognition.', 'uploads/course/course16_1711803721.jpg', '5', 'https://ems.ai4talent.my.id/course/computer-vision-fundamentals', 5000, 0, '2025-01-20 07:34:45', '2025-03-16 06:36:02', '2024-03-30 02:56:00', '2024-04-04 02:56:00'),
(6, 'course', 'AI Ethics and Responsible AI', 'Examine the ethical considerations and responsible practices in the field of AI.', 'uploads/course/course17_1711803733.jpg', '7', 'https://ems.ai4talent.my.id/course/ai-ethics-and-responsible-ai', 20000, 0, '2025-01-20 07:35:00', '2025-03-16 06:35:49', '2024-03-30 02:56:00', '2024-04-02 02:56:00'),
(7, 'course', 'tes', 'tes', 'uploads/course/1737352661_online-learning.png', '1', 'https://', 50000, 0, '2025-01-20 05:57:41', '2025-03-16 06:35:38', '2025-01-21 05:55:00', '2025-01-23 05:55:00'),
(8, 'course', 'Meningkatkan penggunaan metode pengumpulan data dan analisis', 'Meningkatkan penggunaan metode pengumpulan data dan analisis', 'uploads/course/1742132935_pelatihan_analisis_data (1).png', '1', 'https://procat.ai4big.com/member/course/topic/8', 0, 1, NULL, '2025-03-16 07:33:28', '2025-03-16 17:00:00', '2025-03-18 15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_projects`
--

CREATE TABLE `tbl_projects` (
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_desc` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_projects`
--

INSERT INTO `tbl_projects` (`project_id`, `project_name`, `user_id`, `project_desc`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Project A', 2, 'Ini adalah sebuah project', '2025-02-02', '2025-03-01', 'active', '2025-02-09 10:39:18', '2025-02-09 10:39:18'),
(2, 'coba', 2, 'coba', '2025-02-09', '2025-02-12', 'active', '2025-02-09 11:33:23', '2025-02-09 11:33:23'),
(3, 'project abc', 2, 'balala', '2025-02-09', '2025-02-23', 'active', '2025-02-09 11:45:13', '2025-02-09 11:45:13'),
(6, 'project wacana', 2, 'balala oioioi', '2025-02-09', '2025-02-23', 'deleted', '2025-02-09 11:51:33', '2025-02-18 17:56:19'),
(7, 'project coba', 3, 'yaayaya', '2025-02-16', '2025-02-23', 'inactive', '2025-02-16 12:29:33', '2025-02-18 17:56:42'),
(8, 'pembangunan gedung', 3, 'pembangunan gedung mainan', '2025-02-23', '2025-03-08', 'active', '2025-02-16 12:34:49', '2025-02-16 12:34:49'),
(9, 'Project cde', 2, 'Project mengenai digitalisasi sebuah perusahaan', '2025-02-19', '2025-03-03', 'active', '2025-02-18 17:55:19', '2025-02-18 17:55:19'),
(10, 'War Ticket', 2, 'war ticket kereta api di dini hari', '2025-02-19', '2025-02-20', 'active', '2025-02-18 18:06:11', '2025-02-18 18:06:11'),
(11, 'Project qq', 3, 'project for test the mark done activity', '2025-03-08', '2025-03-10', 'active', '2025-03-08 07:19:49', '2025-03-08 07:19:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role_projects`
--

CREATE TABLE `tbl_role_projects` (
  `rolep_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `rolep_name` varchar(255) NOT NULL,
  `rolep_desc` text DEFAULT NULL,
  `mark_done_activity` int(11) DEFAULT NULL,
  `add_activity_ability` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_role_projects`
--

INSERT INTO `tbl_role_projects` (`rolep_id`, `project_id`, `rolep_name`, `rolep_desc`, `mark_done_activity`, `add_activity_ability`, `created_at`, `updated_at`) VALUES
(1, 1, 'Project Manager', 'manage project', NULL, 1, '2025-02-09 10:39:18', '2025-03-01 14:00:14'),
(6, 6, 'pm', 'ppm', NULL, 0, '2025-02-09 11:51:33', '2025-02-18 17:56:19'),
(7, 2, 'pm', 'pmpmpm', NULL, NULL, '2025-02-09 13:10:57', '2025-02-09 13:11:09'),
(8, 6, 'Fullstack engineer', 'yaa', NULL, 0, '2025-02-13 14:45:05', '2025-02-18 17:56:19'),
(9, 7, 'PM', 'project manager', NULL, 1, '2025-02-16 12:29:33', '2025-02-18 17:56:42'),
(10, 8, 'PM', 'project manager', 1, 1, '2025-02-16 12:34:49', '2025-03-08 07:23:32'),
(11, 8, 'developer', 'buat kerangka', 0, 0, '2025-02-16 13:07:06', '2025-03-08 07:23:32'),
(13, 9, 'Project Manager 111', 'Always check the timeline', NULL, 1, '2025-02-18 17:55:19', '2025-02-18 17:55:55'),
(14, 10, 'Customer', 'pelanggan kai access', 0, 0, '2025-02-18 18:06:11', '2025-03-08 07:24:59'),
(15, 11, 'PM', 'Project Manager', 1, 1, '2025-03-08 07:19:49', '2025-03-08 07:20:26'),
(16, 11, 'QA', 'Quality Assurance', 1, 0, '2025-03-08 07:19:49', '2025-03-08 07:20:26'),
(17, 10, 'Pemilik Project', 'Pemilik Project War Ticket', 1, 1, '2025-03-08 07:24:59', '2025-03-08 07:24:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_submission`
--

CREATE TABLE `tbl_submission` (
  `sm_id` int(11) NOT NULL,
  `sm_st_id` int(11) NOT NULL,
  `sm_user_id` int(11) NOT NULL,
  `sm_file` varchar(255) NOT NULL,
  `sm_comment` varchar(255) DEFAULT NULL,
  `sm_status` int(11) NOT NULL,
  `sm_grade` int(11) DEFAULT NULL,
  `sm_feedback_comment` text DEFAULT NULL,
  `sm_creadate` timestamp NULL DEFAULT NULL,
  `sm_modidate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_submission`
--

INSERT INTO `tbl_submission` (`sm_id`, `sm_st_id`, `sm_user_id`, `sm_file`, `sm_comment`, `sm_status`, `sm_grade`, `sm_feedback_comment`, `sm_creadate`, `sm_modidate`) VALUES
(2, 8, 2, 'uploads/submission/1739529447_P2_Intro OpenCV_Indrajani.pptx.pdf', NULL, 0, 90, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia quam ut dui congue, eu vehicula elit laoreet. Proin a lacinia metus, in fringilla elit. Integer feugiat erat magna, a dictum purus pretium a. Vivamus id tortor nec magna egestas gravida. Sed laoreet gravida enim, non malesuada arcu tincidunt a.', '2025-02-14 03:37:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subtopic`
--

CREATE TABLE `tbl_subtopic` (
  `st_id` int(11) NOT NULL,
  `st_t_id` int(11) NOT NULL,
  `st_jenis` varchar(20) NOT NULL,
  `st_name` varchar(100) NOT NULL,
  `st_file` varchar(255) DEFAULT NULL,
  `st_start_date` timestamp NULL DEFAULT NULL,
  `st_due_date` timestamp NULL DEFAULT NULL,
  `st_duration` int(11) DEFAULT NULL,
  `st_attemp_allowed` int(11) DEFAULT NULL,
  `st_is_shuffle` tinyint(1) DEFAULT NULL,
  `st_jumlah_shuffle` int(11) DEFAULT NULL,
  `st_creadate` timestamp NULL DEFAULT NULL,
  `st_modidate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_subtopic`
--

INSERT INTO `tbl_subtopic` (`st_id`, `st_t_id`, `st_jenis`, `st_name`, `st_file`, `st_start_date`, `st_due_date`, `st_duration`, `st_attemp_allowed`, `st_is_shuffle`, `st_jumlah_shuffle`, `st_creadate`, `st_modidate`) VALUES
(1, 2, 'Test', 'Pretest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, NULL, NULL, '2025-01-19 17:00:00', NULL),
(2, 2, 'Modul', 'P2a Pengenalan Toolss', 'uploads/Modul/1737372674_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', NULL, NULL, NULL, NULL, NULL, '2025-01-20 11:31:14', NULL),
(3, 1, 'Test', 'Pretest', NULL, '2025-01-27 13:42:57', '2025-02-28 10:17:00', 30, 2, NULL, NULL, '2025-01-20 16:36:16', NULL),
(4, 1, 'Modul', 'P1a Modul Instalasi', 'uploads/Modul/1737391029_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', NULL, NULL, NULL, NULL, NULL, '2025-01-20 16:37:09', NULL),
(5, 1, 'Test', 'Posttest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, NULL, NULL, '2025-01-20 16:38:04', NULL),
(6, 2, 'Task', 'P2b Task : Review Tools', 'uploads/Task/1737391514_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', '2025-01-24 17:00:00', NULL, NULL, NULL, NULL, '2025-01-20 16:45:14', NULL),
(8, 2, 'Task Collection', 'Hasil Review Tools', NULL, '2025-01-22 13:42:57', '2025-02-21 16:59:00', NULL, NULL, NULL, NULL, '2025-01-20 16:59:54', NULL),
(9, 4, 'Test', 'Pretest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, NULL, NULL, '2025-01-20 17:05:53', NULL),
(10, 4, 'Modul', 'Modul Introduction to AI', 'uploads/Modul/1737392778_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', NULL, NULL, NULL, NULL, NULL, '2025-01-20 17:06:18', NULL),
(11, 5, 'Test', 'Pretest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, NULL, NULL, '2025-01-20 17:08:16', NULL),
(12, 5, 'Modul', 'Modul', 'uploads/Modul/1737392927_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', NULL, NULL, NULL, NULL, NULL, '2025-01-20 17:08:47', NULL),
(14, 6, 'Test', 'Pretest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, NULL, NULL, '2025-01-20 17:09:11', NULL),
(15, 6, 'Task', 'Review Pengenalan Tools', 'uploads/Task/1737392984_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', '2025-01-29 17:09:00', NULL, NULL, NULL, NULL, '2025-01-20 17:09:44', NULL),
(16, 6, 'Task Collection', 'Hasil Reviw', NULL, '2025-01-22 13:42:57', '2025-01-29 17:09:00', NULL, NULL, NULL, NULL, '2025-01-20 17:10:00', NULL),
(17, 1, 'Feedback', 'Feedback P1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-23 17:45:06', NULL),
(18, 2, 'Feedback', 'Feedback p2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-24 07:27:01', NULL),
(19, 2, 'Certificate', 'Certificate of Completion', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-10 15:11:55', NULL),
(20, 7, 'Modul', 'Konsep Pengumpulan Data:  Definisi, jenis, tujuan, proses/tahapan', 'uploads/modul/1742133405_Pertemuan 1_Konsep Pengumpulan Data_ Definisi, Jenis, Tujuan, dan Proses.pdf', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-16 06:56:44', NULL),
(21, 8, 'Modul', 'Memahami proses  pengumpulan data baik secara kualitatif dan kuantitatif', 'uploads/modul/1742133438_Pertemuan 2_Metode Pengumpulan Data Kualitatif dan Kuantitatif dalam Bisnis.pdf', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-16 06:57:17', NULL),
(22, 9, 'Modul', 'Mengerjakan proyek sederhana dengan studi kasus sebuah paper/artikel', 'uploads/modul/1742133467_Pertemuan 3_Mengerjakan Proyek Berdasarkan Tahapan Literature Review dalam Topik Bisnis.pdf', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-16 06:57:43', NULL),
(23, 10, 'Modul', 'Menganalisis Data Kualitatif', 'uploads/modul/1742133499_Pertemuan 4_Analisis Kualitatif SWOT Bisnis_ Memahami Kekuatan dan Kelemahan.pdf', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-16 06:58:17', NULL),
(24, 7, 'Test', 'Pretest Modul 1', NULL, '2025-03-18 15:00:00', '2025-03-17 01:00:00', 10, 1, NULL, NULL, '2025-03-16 14:59:11', NULL),
(25, 7, 'Test', 'Posttest Modul 1', NULL, '2025-03-18 15:00:00', '2025-03-17 01:00:00', 10, 3, NULL, NULL, '2025-03-16 14:59:57', NULL),
(26, 8, 'Test', 'Pretest Modul 2', NULL, '2025-03-18 15:00:00', '2025-03-17 01:00:00', 10, 1, NULL, NULL, '2025-03-16 15:03:39', NULL),
(27, 8, 'Test', 'Posttest Modul 2', NULL, '2025-03-18 15:00:00', '2025-03-17 01:00:00', 10, 3, NULL, NULL, '2025-03-16 15:04:16', NULL),
(28, 9, 'Test', 'Pretest Modul 3', NULL, '2025-03-18 15:00:00', '2025-03-17 01:00:00', 10, 1, NULL, NULL, '2025-03-16 15:06:30', NULL),
(29, 9, 'Test', 'Posttest Modul 3', NULL, '2025-03-18 15:00:00', '2025-03-17 01:00:00', 10, 3, NULL, NULL, '2025-03-16 15:07:03', NULL),
(30, 10, 'Test', 'Pretest Modul 4', NULL, '2025-03-18 15:00:00', '2025-03-17 01:00:00', 10, 1, NULL, NULL, '2025-03-16 15:09:05', NULL),
(31, 10, 'Test', 'Posttest Modul 4', NULL, '2025-03-18 15:00:00', '2025-03-17 01:00:00', 10, 3, NULL, NULL, '2025-03-16 15:09:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subtopic_test`
--

CREATE TABLE `tbl_subtopic_test` (
  `test_st_id` int(11) NOT NULL,
  `test_pertanyaan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_subtopic_test`
--

INSERT INTO `tbl_subtopic_test` (`test_st_id`, `test_pertanyaan_id`) VALUES
(3, 1),
(3, 2),
(3, 3),
(1, 1),
(1, 2),
(1, 3),
(24, 4),
(24, 5),
(24, 6),
(24, 7),
(24, 8),
(24, 9),
(24, 10),
(24, 11),
(24, 12),
(24, 13),
(25, 9),
(25, 10),
(25, 11),
(25, 12),
(25, 13),
(25, 14),
(25, 15),
(25, 16),
(25, 17),
(25, 18),
(26, 19),
(26, 20),
(26, 21),
(26, 22),
(26, 23),
(26, 24),
(26, 25),
(26, 26),
(26, 27),
(26, 28),
(27, 24),
(27, 25),
(27, 26),
(27, 27),
(27, 28),
(27, 29),
(27, 30),
(27, 31),
(27, 32),
(27, 33),
(28, 34),
(28, 35),
(28, 36),
(28, 37),
(28, 38),
(28, 39),
(28, 40),
(28, 41),
(28, 42),
(28, 43),
(29, 39),
(29, 40),
(29, 41),
(29, 42),
(29, 43),
(29, 44),
(29, 45),
(29, 46),
(29, 47),
(29, 48),
(30, 49),
(30, 50),
(30, 51),
(30, 52),
(30, 53),
(30, 54),
(30, 55),
(30, 56),
(30, 57),
(30, 58),
(31, 54),
(31, 55),
(31, 56),
(31, 57),
(31, 58),
(31, 59),
(31, 60),
(31, 61),
(31, 62),
(31, 63);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tasks`
--

CREATE TABLE `tbl_tasks` (
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `phase_id` bigint(20) UNSIGNED NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_desc` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `priority` varchar(255) NOT NULL DEFAULT 'medium',
  `deadline` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_task_assignments`
--

CREATE TABLE `tbl_task_assignments` (
  `assignment_id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_team_members`
--

CREATE TABLE `tbl_team_members` (
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `rolep_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_team_members`
--

INSERT INTO `tbl_team_members` (`member_id`, `user_id`, `project_id`, `rolep_id`, `assigned_date`, `created_at`, `updated_at`) VALUES
(3, 2, 6, 6, '2025-02-02 17:00:00', '2025-02-09 12:44:46', '2025-02-18 17:56:19'),
(4, 2, 2, 7, '2025-02-07 17:00:00', '2025-02-09 13:10:57', '2025-02-09 13:11:09'),
(5, 3, 6, 8, '2025-02-08 17:00:00', '2025-02-13 14:45:05', '2025-02-18 17:56:19'),
(6, 2, 7, 9, '2025-02-14 17:00:00', '2025-02-16 12:29:33', '2025-02-18 17:56:42'),
(7, 2, 8, 10, '2025-02-09 17:00:00', '2025-02-16 12:34:49', '2025-03-08 07:23:32'),
(8, 3, 8, 11, '2025-02-09 17:00:00', '2025-02-16 13:07:06', '2025-03-08 07:23:32'),
(10, 2, 9, 13, '2025-02-17 17:00:00', '2025-02-18 17:55:19', '2025-02-18 17:55:55'),
(11, 3, 10, 14, '2025-02-17 17:00:00', '2025-02-18 18:06:11', '2025-03-08 07:24:59'),
(12, 2, 1, 1, '2025-02-28 17:00:00', '2025-03-01 13:52:13', '2025-03-01 14:00:14'),
(13, 3, 11, 15, '2025-03-06 17:00:00', '2025-03-08 07:19:49', '2025-03-08 07:20:26'),
(14, 2, 11, 16, '2025-03-06 17:00:00', '2025-03-08 07:19:49', '2025-03-08 07:20:26'),
(15, 2, 10, 17, '2025-03-07 17:00:00', '2025-03-08 07:24:59', '2025-03-08 07:24:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_topic`
--

CREATE TABLE `tbl_topic` (
  `t_id` int(11) NOT NULL,
  `t_p_id` int(11) NOT NULL,
  `t_name` varchar(100) NOT NULL,
  `t_creadate` timestamp NULL DEFAULT NULL,
  `t_modidate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_topic`
--

INSERT INTO `tbl_topic` (`t_id`, `t_p_id`, `t_name`, `t_creadate`, `t_modidate`) VALUES
(1, 1, 'P1 Instalasi', '2025-01-20 07:54:02', '2025-02-14 03:52:24'),
(2, 1, 'P2 Pengenalan Tools', '2025-01-20 10:38:55', NULL),
(4, 2, 'Introduction to AI', '2025-01-20 17:02:15', NULL),
(5, 2, 'Introduction to Robotics', '2025-01-20 17:04:05', NULL),
(6, 2, 'Instalation Tools', '2025-01-20 17:05:00', NULL),
(7, 8, 'Pertemuan 1', '2025-03-16 06:50:04', '2025-03-16 07:00:06'),
(8, 8, 'Pertemuan 2', '2025-03-16 06:50:16', '2025-03-16 07:01:07'),
(9, 8, 'Pertemuan 3', '2025-03-16 06:50:29', '2025-03-16 07:01:31'),
(10, 8, 'Pertemuan 4', '2025-03-16 06:50:40', '2025-03-16 07:01:54');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `t_id` int(11) NOT NULL,
  `t_transaction_id` varchar(255) DEFAULT NULL,
  `t_code` varchar(255) DEFAULT NULL,
  `t_user_id` int(11) NOT NULL,
  `t_p_id` int(11) DEFAULT NULL,
  `t_type` enum('inflow','outflow') NOT NULL,
  `t_amount` int(11) NOT NULL,
  `t_status` enum('unpaid','waiting confirmation','paid') NOT NULL,
  `t_user_proof` text DEFAULT NULL,
  `t_admin_proof` text DEFAULT NULL,
  `t_created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `t_modified_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_transaction`
--

INSERT INTO `tbl_transaction` (`t_id`, `t_transaction_id`, `t_code`, `t_user_id`, `t_p_id`, `t_type`, `t_amount`, `t_status`, `t_user_proof`, `t_admin_proof`, `t_created_date`, `t_modified_date`) VALUES
(1, '101', '101', 2, NULL, 'inflow', 50000, 'paid', 'User-Transaction-Topup1.jpg', 'Admin-Transaction-Topup1.jpg', '2024-03-27 21:58:38', '2024-03-27 21:58:37'),
(2, '101', '101', 2, NULL, 'inflow', 20000, 'paid', 'User-Transaction-Topup2.jpg', 'Admin-Transaction-Topup2.jpg', '2024-03-28 02:12:01', '2024-03-28 02:16:01'),
(3, '101', '101', 2, NULL, 'inflow', 50000, 'paid', 'User-Transaction-Topup3.jpg', 'Admin-Transaction-Topup3.jpg', '2024-03-28 02:15:06', '2024-03-28 02:20:32'),
(7, '101', '101', 2, NULL, 'inflow', 50000, 'paid', 'User-Transaction-Topup7.jpg', 'Admin-Transaction-Topup7.jpg', '2024-03-28 06:41:13', '2024-03-28 07:45:44'),
(8, '102', '102', 2, 6, 'outflow', 30000, 'paid', NULL, NULL, '2024-03-30 01:44:12', NULL),
(9, '102', '102', 2, 1, 'outflow', 10000, 'paid', NULL, NULL, '2024-03-30 01:46:58', NULL),
(11, '102', '102', 2, 2, 'outflow', 30000, 'paid', NULL, NULL, '2025-01-19 15:48:07', NULL),
(12, '102', '101', 2, NULL, 'inflow', 100000, 'waiting confirmation', 'User-Transaction-Topup12.png', NULL, '2025-01-19 15:49:10', '2025-01-19 15:49:26'),
(13, NULL, NULL, 2, 3, 'outflow', 10000, 'paid', NULL, NULL, '2025-03-13 18:10:21', NULL),
(14, NULL, NULL, 2, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-16 14:34:26', NULL),
(15, NULL, NULL, 4, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-16 22:16:15', NULL),
(16, NULL, NULL, 11, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 01:24:21', NULL),
(17, NULL, NULL, 14, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 01:24:33', NULL),
(18, NULL, NULL, 15, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 01:24:42', NULL),
(19, NULL, NULL, 13, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 01:24:50', NULL),
(20, NULL, NULL, 16, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 01:26:00', NULL),
(21, NULL, NULL, 12, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 01:26:13', NULL),
(22, NULL, NULL, 17, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 01:26:22', NULL),
(23, NULL, NULL, 18, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 01:28:41', NULL),
(24, NULL, NULL, 19, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 02:05:22', NULL),
(25, NULL, NULL, 20, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 02:17:28', NULL),
(26, NULL, NULL, 23, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 02:25:13', NULL),
(27, NULL, NULL, 8, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 02:27:11', NULL),
(28, NULL, NULL, 6, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 02:27:13', NULL),
(29, NULL, NULL, 7, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 02:34:40', NULL),
(30, NULL, NULL, 24, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 02:34:43', NULL),
(31, NULL, NULL, 26, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 02:34:43', NULL),
(32, NULL, NULL, 25, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 02:34:49', NULL),
(33, NULL, NULL, 27, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 02:34:52', NULL),
(34, NULL, NULL, 33, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 03:38:00', NULL),
(35, NULL, NULL, 29, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 04:04:26', NULL),
(36, NULL, NULL, 28, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 04:05:02', NULL),
(37, NULL, NULL, 39, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 04:12:02', NULL),
(38, NULL, NULL, 39, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 04:12:02', NULL),
(39, NULL, NULL, 39, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 04:12:02', NULL),
(40, NULL, NULL, 35, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 04:13:03', NULL),
(41, NULL, NULL, 35, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 04:13:03', NULL),
(42, NULL, NULL, 30, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 06:12:36', NULL),
(43, NULL, NULL, 43, 8, 'outflow', 0, 'paid', NULL, NULL, '2025-03-17 06:22:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trans_activities`
--

CREATE TABLE `tbl_trans_activities` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_trans_activities`
--

INSERT INTO `tbl_trans_activities` (`id`, `code`, `name`) VALUES
(1, '101', 'Top Up'),
(2, '102', 'Buying Course');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `nik` varchar(100) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(23) NOT NULL DEFAULT '',
  `jk` varchar(10) NOT NULL,
  `tgl_lhr` date NOT NULL,
  `role` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `api_token` text DEFAULT NULL,
  `token_type` varchar(50) NOT NULL DEFAULT 'Bearer',
  `email` varchar(50) NOT NULL,
  `provinsi` varchar(200) DEFAULT NULL,
  `kelurahan` varchar(200) DEFAULT NULL,
  `kecamatan` varchar(200) DEFAULT NULL,
  `kota_kab` varchar(200) DEFAULT NULL,
  `pendidikan` varchar(200) DEFAULT NULL,
  `pekerjaan` varchar(200) DEFAULT NULL,
  `agama` varchar(200) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `saldo` float DEFAULT NULL,
  `level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `nik`, `username`, `password`, `nama`, `alamat`, `no_hp`, `jk`, `tgl_lhr`, `role`, `created_at`, `updated_at`, `api_token`, `token_type`, `email`, `provinsi`, `kelurahan`, `kecamatan`, `kota_kab`, `pendidikan`, `pekerjaan`, `agama`, `group_id`, `saldo`, `level`) VALUES
(1, NULL, 'admin', 'Procat@2025', 'Administrator', 'SUkabumi', '0856224425', 'Perempuan', '1996-05-19', 'Admin', '2024-01-02 09:18:29', '2025-03-23 05:57:22', 'a8e6f4037919ebf9b081e37bf4153419d8d452bf1d30d7fc7ade02709683d3ac', 'Bearer', 'ekoabdulgoffar129@gmail.com', '32', '3202070002', '3202070', '3202', NULL, NULL, NULL, 0, 0, NULL),
(2, NULL, 'fatwa', 'fatwa', 'Fatwa Paramadhani', 'SUkabumi', '08562244255', 'Perempuan', '1996-05-19', 'Peserta', '2024-01-02 09:18:29', '2025-03-17 05:07:00', '6ac49573d5488a32132b217ef2bb039a1f03b0cf066bbbd54981f110dbf3b53b', 'Bearer', '', '32', '3202070002', '3202070', '3202', NULL, NULL, NULL, 0, 0, NULL),
(3, NULL, 'qq', 'qq123', 'qq', 'Ponorogo', '08562244255', 'Perempuan', '1996-05-19', 'Peserta', '2025-02-13 14:42:57', '2025-03-10 21:43:21', 'e16dd03d47b5e178fe9632586cb6001999672019e60902ca7ea3cb96a6408393', 'Bearer', 'qq@mail.com', '32', '3202070002', '3202070', '3202', NULL, NULL, NULL, 0, 0, NULL),
(4, NULL, 'ekoabdulgoffar', '123', 'Eko Abdul Goffar', '123', '123', 'Laki-laki', '2025-03-14', 'Peserta', '2025-03-13 18:23:15', '2025-03-16 22:29:30', '54089bd1c383db6f68b500bdb3a5e852d9f7707222df59145df8d1cf703a0e9e', 'Bearer', 'abc@gmail.com', '12', '1213140001', '1213140', '1213', NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, 'hendy', '123', 'hendy', '123', '123', 'Laki-laki', '2025-03-14', 'Peserta', '2025-03-13 18:28:54', '2025-03-16 22:27:26', '51477ee48d912a0badffc6eefa816173207472fd916b87aa6f25a1900804fb2c', 'Bearer', 'abc@gmail.com', '11', '1112031001', '1112031', '1112', NULL, NULL, NULL, NULL, NULL, NULL),
(6, NULL, 'Vincent Kurniawan', 'Vk091204', 'Vincent Kurniawan', 'Jl. Ratna Raya\r\nRT/RW 001/001', '081222266616', 'Laki-laki', '2004-12-09', 'Peserta', '2025-03-14 08:46:46', '2025-03-17 04:20:34', '52f9d8f91f9d0d14ac20d611057882792a568aa096f4592e4656511d41a7ff34', 'Bearer', 'vincentkurniawan.id@gmail.com', '19', '1971021004', '1971021', '1971', NULL, NULL, NULL, NULL, NULL, NULL),
(7, NULL, 'Elvis', 'Never280804', 'Elvis Daniel Pratama', 'Jl. Imam Bonjol Gg. Tanjung Harapan No 12', '087811273924', 'Laki-laki', '2004-08-28', 'Peserta', '2025-03-14 14:06:22', '2025-03-17 02:24:03', '5f90fd86c0ab47bb7c8e3f59b236599a818fa228fffa0760491f953e63ee2e45', 'Bearer', 'elvis.pratama@binus.ac.id', '61', '6171011003', '6171011', '6171', NULL, NULL, NULL, NULL, NULL, NULL),
(8, NULL, 'Richard', 'ubibakar11', 'Richard Ma', 'Jalan paus no.29', '08972125043', 'Laki-laki', '2004-10-01', 'Peserta', '2025-03-15 11:54:29', '2025-03-17 04:25:02', 'de0a447b921f6653b590d67b61292901df062dd2961c00eceb4e70e3255231a5', 'Bearer', 'richard.ma@binus.ac.id', '14', '1471021005', '1471021', '1471', NULL, NULL, NULL, NULL, NULL, NULL),
(9, NULL, 'agustina.setyaningsih', 'Procat@2025', 'Agustina Setyaningsih', 'Jakarta', '123', 'Perempuan', '1995-03-16', 'Admin', '2025-03-16 13:40:57', NULL, NULL, 'Bearer', 'abc@gmail.com', '31', '3173020002', '3173020', '3173', NULL, NULL, NULL, NULL, NULL, NULL),
(10, NULL, 'proin', 'Procat@2025', 'Admin Procat 1', '123', '123', 'Laki-laki', '2025-03-17', 'Admin', '2025-03-16 22:51:49', NULL, NULL, 'Bearer', 'abc@gmail.com', '31', '3173030001', '3173030', '3173', NULL, NULL, NULL, NULL, NULL, NULL),
(11, NULL, 'Fulranto', 'KanohAgito2003', 'Fulranto', 'Dusun Pelawan', '082282276724', 'Laki-laki', '2025-03-17', 'Peserta', '2025-03-17 01:23:02', '2025-03-17 06:23:25', '36ee49f2350f079277e5e4b2ed7bbad69d8322aa81c7832595d73dc52330802f', 'Bearer', 'ful.ranto@binus.ac.id', '19', '1903051010', '1903051', '1903', NULL, NULL, NULL, NULL, NULL, NULL),
(12, NULL, 'jili', 'Ayamgoreng0123', 'Jili Jonathan', 'palmerah utara 2 nomor 17', '089635852552', 'Laki-laki', '2004-01-12', 'Peserta', '2025-03-17 01:23:27', '2025-03-17 06:36:40', '11cc31f6339323da0019dcf47f8f48bf6c1ef04c36b2ec78e438bfd5764576c9', 'Bearer', 'jili.jonathan@binus.ac.id', '31', '3174030001', '3174030', '3174', NULL, NULL, NULL, NULL, NULL, NULL),
(13, NULL, 'Benny', 'b!Nu$26042000', 'Bennu', 'Jalan soekarno hatta gang nila 1', '08116922216', 'Laki-laki', '2000-04-26', 'Peserta', '2025-03-17 01:23:29', '2025-03-17 06:23:03', 'd4c9454fd560337f461248c04a1b6b0fb560a0236324003fbc2cc23efba52571', 'Bearer', 'benny005@binus.ac.id', '21', '2172040001', '2172040', '2172', NULL, NULL, NULL, NULL, NULL, NULL),
(14, NULL, 'alberta30', 'yangbener', 'Albert', 'Jalan b no 19 telukgong jakarta utara 14450', '081277989803', 'Laki-laki', '2003-11-03', 'Peserta', '2025-03-17 01:23:31', '2025-03-17 06:24:01', '411b140815904b46223251580b4b9a4375c803749a35e61c656c8f38be0ffba1', 'Bearer', 'kamutaukanharusnya@gmail.com', '31', NULL, '3175010', '3175', NULL, NULL, NULL, NULL, NULL, NULL),
(15, NULL, 'ditoadrn', 'sagitarius13', 'Nandito Adrian Reswara', 'JL. Teguh V No. 1', '081299415613', 'Laki-laki', '2003-12-13', 'Peserta', '2025-03-17 01:23:50', '2025-03-17 01:24:01', '63547a3cef3e2ea032e7eb1062e1f4d2f9d5ab40f170d0398430b58de719bec3', 'Bearer', 'nandito.reswara@binus.ac.id', '31', '3175050001', '3175050', '3175', NULL, NULL, NULL, NULL, NULL, NULL),
(16, NULL, 'Piyo', 'Piyomoon195', 'Muhammad Priantoro', 'Jln palmerah utara II no.07', '082111736564', 'Laki-laki', '2003-10-24', 'Peserta', '2025-03-17 01:25:39', '2025-03-17 04:22:06', '2fdcee5083ad41897c78065695711284999bdec5170c252669a78f00fe7ff10e', 'Bearer', 'muhammad.priantoro@binus.ac.id', '31', '3174030001', '3174030', '3174', NULL, NULL, NULL, NULL, NULL, NULL),
(17, NULL, 'fakhrizaldi', 'Aduhayy12123~', 'Fakhrizaldi', 'Banyuanyar Rt4 Rw6', '081215250471', 'Laki-laki', '1999-10-05', 'Peserta', '2025-03-17 01:25:56', '2025-03-17 06:23:48', '480a4bac37ec08ad4a20d5f59d3db8644c67cdcdb62a4c380128d8e1013d70bd', 'Bearer', 'nurrahman.fakhrizaldi@gmail.com', '33', '3372050013', '3372050', '3372', NULL, NULL, NULL, NULL, NULL, NULL),
(18, NULL, 'Jenifer', 'H4rdcor3', 'Jenifer', 'Jl. KH. AHMAD DAHLAN NO.108', '08116224480', 'Perempuan', '2003-12-17', 'Peserta', '2025-03-17 01:27:54', '2025-03-17 06:28:13', '69a29c5c38b49e9bf9c7cff504a9342f47f14494e366fa9efa9997e58f34a3e9', 'Bearer', 'akabane.laura079@gmail.com', '12', '1207220004', '1207220', '1207', NULL, NULL, NULL, NULL, NULL, NULL),
(19, NULL, 'Jeremy christian', 'dogy452031**', 'Jeremy christian Budhihartono', 'Jalan Permata Merah E67, semarang', '081238277800', 'Laki-laki', '2003-12-10', 'Peserta', '2025-03-17 02:03:29', '2025-03-17 06:46:49', 'd82af07ea20e4d435092473c9377ecd5622b87436acab76855c3b86e5afa6b38', 'Bearer', 'jeremy.budhihartono@binus.ac.id', '33', '3374120005', '3374120', '3374', NULL, NULL, NULL, NULL, NULL, NULL),
(20, NULL, 'Samuel Vincent', 'miamia123', 'Samuel Vincent', 'Jl. Pasar Beringin Sungai Pinyuh', '081254541902', 'Laki-laki', '2005-07-03', 'Peserta', '2025-03-17 02:16:31', '2025-03-17 06:13:05', '9db195f420caac3dc8f650af60a25a8d8b6594024c4bf7b946fc057d12a218ef', 'Bearer', 'samuel.vincent@binus.ac.id', '61', '6104090009', '6104090', '6104', NULL, NULL, NULL, NULL, NULL, NULL),
(21, NULL, 'adminRTT', 'Procat@2025', 'adminRTT', '123', '123', 'Laki-laki', '2025-03-17', 'Admin', '2025-03-17 02:18:50', '2025-03-17 04:13:45', 'c559e06bba0f7e270e6ddd21819ac75d8efae4d33e6633342079ce5851aae571', 'Bearer', 'abc@gmail.com', '31', '3171020001', '3171020', '3171', NULL, NULL, NULL, NULL, NULL, NULL),
(22, NULL, 'Theodorus Billy', 'b!Nu$28042004', 'Theodorus Billy Sakti Aryanto', 'MEGA KEBON JERUK BLOK D 11 NO 9', '085814629959', 'Laki-laki', '2004-04-28', 'Peserta', '2025-03-17 02:23:50', '2025-03-17 02:24:32', 'da11ec33438f5e3eb85a2175e112e9dbef9357f31ea887ee4a9428e03bf4b686', 'Bearer', 'theodorus.aryanto@binus.ac.id', '31', '3174020004', '3174020', '3174', NULL, NULL, NULL, NULL, NULL, NULL),
(23, NULL, 'blassio', 'Blassio123', 'Blassio Adriautarya', 'Jalan Raden Mattaher no 9', '081326691688', 'Laki-laki', '0003-09-15', 'Peserta', '2025-03-17 02:24:49', '2025-03-17 04:18:40', '8fd4a26d0014b276b7caf9aaa0f88e126f07178e42eea3187256f721033efb2a', 'Bearer', 'blassio688@gmail.com', '15', '1571080007', '1571080', '1571', NULL, NULL, NULL, NULL, NULL, NULL),
(24, NULL, 'Artanti', 'Artanti_2108', 'Artanti magnolia Chow', 'Taman Dadap Indah Blok C9 No.3', '085156924453', 'Perempuan', '2004-08-21', 'Peserta', '2025-03-17 02:27:19', '2025-03-17 06:18:17', '7a4ce4990df7a4ad3cbd35f6d2ea07cbceb71600b0c517a0415facf529b4af7f', 'Bearer', 'artanti.chow@binus.ac.id', '36', '3603210006', '3603210', '3603', NULL, NULL, NULL, NULL, NULL, NULL),
(25, NULL, 'NicholasT', 'Vanguard1311', 'Nicholas Thenoch', 'TIKALA ARES NO 32 LINGKUNGAN 1', '0851-7152-1754', 'Laki-laki', '2003-11-13', 'Peserta', '2025-03-17 02:28:34', '2025-03-17 06:17:20', '331ba3739de32a7ae43797dd28280e5ef480fc630c50085ceae55f2af97131da', 'Bearer', 'Nicholas.thenoch@binus.ac.id', '71', '7171031009', '7171031', '7171', NULL, NULL, NULL, NULL, NULL, NULL),
(26, NULL, 'Vaniatandri', 'Vaniaaa23', 'Vania Tandri', 'Greenwich Park Cluster Imajihaus Blok E17 No 28', '085250200075', 'Perempuan', '2003-12-15', 'Peserta', '2025-03-17 02:33:09', '2025-03-17 06:17:16', '852349c6d5cf2ee7359105b8d74d7e78d37f01848491a8e11f1446d81210a407', 'Bearer', 'vania.tandri@binus.ac', '36', '3603070008', '3603070', '3603', NULL, NULL, NULL, NULL, NULL, NULL),
(27, NULL, 'stphnclay', 'Excel168,', 'stephen cornelius', 'alam sutera', '087827052302', 'Laki-laki', '2004-08-16', 'Peserta', '2025-03-17 02:34:18', '2025-03-17 06:18:05', 'cfbbdacdd15bb7dced25feeabce33e8ad28a388f01912180bdeb75b3b999b630', 'Bearer', 'stphnclayy@gmail.com', '36', '3671030005', '3671030', '3671', NULL, NULL, NULL, NULL, NULL, NULL),
(28, NULL, 'Emily Abrina', 'Brill2005', 'Emily Abrina Wisnumurti', 'Gading Serpong Sektor 7B DD 9 No.20', '082319122003', 'Perempuan', '2003-12-19', 'Peserta', '2025-03-17 02:45:23', '2025-03-17 04:03:27', 'f260fac5b418960e02149db64bef160c3e64e7c0af1d955272d3d9c9000f744b', 'Bearer', 'emily.wisnumurti@binus.ac.id', '36', '3603051002', '3603051', '3603', NULL, NULL, NULL, NULL, NULL, NULL),
(29, NULL, 'Jeryann', 'Garuda2002', 'Jeryan Gintir', 'Jln benda barat 10 blok b6 no 7c, Pamulang, Tangerang Selatan, Banten', '081283377458', 'Laki-laki', '2002-04-30', 'Peserta', '2025-03-17 02:53:33', '2025-03-17 04:02:56', '8a6eeeb9f8685d7f2b8934a3bfa0525b84aead8b7016a3f8f933dd4d3ae2b7ca', 'Bearer', 'jeryangintirr@gmail.com', '36', '3674030008', '3674030', '3674', NULL, NULL, NULL, NULL, NULL, NULL),
(30, NULL, 'lauraamarcel', 'Owaf010921', 'Laura Marcelline Nastiti', 'Villa Gading Indah blok O/2', '89513052448', 'Perempuan', '2004-03-01', 'Peserta', '2025-03-17 03:04:51', NULL, NULL, 'Bearer', 'laura.nastiti@binus.ac.id', '31', '3175050001', '3175050', '3175', NULL, NULL, NULL, NULL, NULL, NULL),
(31, NULL, 'Lucianputra', 'lucian.eka23', 'Lucian Eka Putra', 'Villa daya blok d9 no 12', '082114941155', 'Laki-laki', '2004-09-30', 'Peserta', '2025-03-17 03:10:08', '2025-03-17 03:10:12', 'c18305abb3f6033673564709f9b3b44979f66dc29f7ad78cdaf62e9798f92a27', 'Bearer', 'lucian.eka14@gmail.com', '32', '3271040004', '3271040', '3271', NULL, NULL, NULL, NULL, NULL, NULL),
(32, NULL, 'Delyschia', 'Delys1802', 'Delyshcia Kyleen', 'JL. Pondok Jaya VIII/I A', '087885751006', 'Perempuan', '2004-02-11', 'Peserta', '2025-03-17 03:13:04', '2025-03-17 03:13:08', 'c19444671067ca2fb13fb81f200ce9a53ff2de08b0f5a391a5af8a84e9692e4e', 'Bearer', 'delyschia11.kyleen@gmail.com', '31', '3171070002', '3171070', '3171', NULL, NULL, NULL, NULL, NULL, NULL),
(33, NULL, 'layaliajasmine', 'i<3Jeongwoo', 'Layalia Jasmine Soraya', 'Jl.Anggrek Cendrawasih I J/26', '08111888283', 'Perempuan', '2004-01-29', 'Peserta', '2025-03-17 03:16:06', '2025-03-17 06:25:40', 'b35b7d0ccd4a073a77e7146209292a97c32dbfba9e3930137b94a877d3f06fbc', 'Bearer', 'layaliajasmine@gmail.com', '31', '3174030002', '3174030', '3174', NULL, NULL, NULL, NULL, NULL, NULL),
(34, NULL, 'layaliajasmine', 'i<3Jeongwoo', 'Layalia Jasmine Soraya', 'Jl.Anggrek Cendrawasih I J/26', '08111888283', 'Perempuan', '2004-01-29', 'Peserta', '2025-03-17 03:16:07', '2025-03-17 06:25:40', 'b35b7d0ccd4a073a77e7146209292a97c32dbfba9e3930137b94a877d3f06fbc', 'Bearer', 'layaliajasmine@gmail.com', '31', '3174030002', '3174030', '3174', NULL, NULL, NULL, NULL, NULL, NULL),
(35, NULL, 'muhamadzidan', 'mamazidan@04', 'Muhamad Zidan', 'Kp. Suka Karya Rt 07 RW 03 Desa Pangkalan Kecamatan Teluknaga Kabupaten Tangerang', '085782842655', 'Laki-laki', '2004-03-01', 'Peserta', '2025-03-17 03:56:49', '2025-03-17 06:48:31', '4ea441ab6da62273ef29ca489fff2d36192823f23183131eb1577335cc025855', 'Bearer', 'muhamad.zidan001@binus.ac.id', '36', '3603200010', '3603200', '3603', NULL, NULL, NULL, NULL, NULL, NULL),
(36, NULL, 'lauraamarcel', 'Owaf01032004', 'Laura Marcelline Nastiti', 'Villa Gading Indah', '89513052448', 'Perempuan', '2004-03-01', 'Peserta', '2025-03-17 04:02:24', '2025-03-17 06:10:20', 'a2d0023b94f423227c40fc6ff052e9840135ccf02d203be3c9903b09e31eb3d0', 'Bearer', 'laura.marcelline01@gmail.com', '31', '3175050001', '3175050', '3175', NULL, NULL, NULL, NULL, NULL, NULL),
(37, '3173042108040002', 'Marthin', 'Marthin21', 'Marthin', 'Krendang selatan', '085975323733', 'Laki-laki', '2004-08-21', 'Peserta', '2025-03-17 04:03:26', '2025-03-17 04:21:53', 'a243c944e20a838c87064949cbdb7854f24a639b2adeaeca6d72528067653d17', 'Bearer', 'Cin.marthin@binus.ac.id', '31', '3174050005', '3174050', '3174', 'Tidak Sekolah', 'Tidak Bekerja', 'Budha', NULL, NULL, NULL),
(38, NULL, 'Geraldo', 'Cheetah19', 'Fridolin Geraldo Sunfilio', 'Jl. Arjuna', '081350039699', 'Laki-laki', '2003-10-17', 'Peserta', '2025-03-17 04:05:36', '2025-03-17 04:05:41', '45237cc051bc1226104bb6684e3ee6a9f1c19f2bf34b4e52199ad98a6715bff6', 'Bearer', 'fridolin.sunfilio@binus.ac.id', '64', '6472050002', '6472050', '6472', NULL, NULL, NULL, NULL, NULL, NULL),
(39, NULL, 'Zaqi Nata', 'MYbinusmaya260206', 'Zaqi Natanegara', 'Jl. Anggrek Nelimurni', '628119976578', 'Laki-laki', '2004-05-21', 'Peserta', '2025-03-17 04:07:14', '2025-03-17 04:26:06', 'e75ad526c8c516e8a7d135661847606cb07e3b3430ab7364f63af3d352b7de97', 'Bearer', 'muhammad.natanegara001@binus.ac.id', '31', '3174030003', '3174030', '3174', NULL, NULL, NULL, NULL, NULL, NULL),
(40, NULL, 'kitopuransil', 'kitop2704', 'KITO PURANSIL', 'JL.KH.MOH MANSYUR 15 E-11', '08119692704', 'Laki-laki', '2004-01-27', 'Peserta', '2025-03-17 04:22:34', NULL, NULL, 'Bearer', 'kitopuransil@gmail.com', '31', '3173080006', '3173080', '3173', NULL, NULL, NULL, NULL, NULL, NULL),
(41, NULL, 'kitopuransil', 'kitop2704', 'KITO PURANSIL', 'JL.KH MOH MANSYUR 15 E-11', '08119692704', 'Laki-laki', '2004-01-27', 'Peserta', '2025-03-17 04:26:56', NULL, NULL, 'Bearer', 'learnkito@gmail.com', '31', '3173080006', '3173080', '3173', NULL, NULL, NULL, NULL, NULL, NULL),
(42, NULL, 'William s', '123123Will', 'William senangsa', 'Sunter hijau 9 blok k 4 no 12', '082211305612', 'Laki-laki', '2004-01-05', 'Peserta', '2025-03-17 05:05:20', '2025-03-17 05:05:41', '90caa349025478c40df5a1f8c428e471154e966a7108d151894019429d201e28', 'Bearer', 'William.senangsa@binus.ac.id', '36', '3671030004', '3671030', '3671', NULL, NULL, NULL, NULL, NULL, NULL),
(43, NULL, 'chen.654', 'Iamccp08022003', 'ZHANG CHENG YI', 'Golden Vienna 2 Blok C7 No 17, Jl. Garuda Kencana No.2, Ciater, Kec. Serpong, Kota Tangerang Selatan, Banten 15310', '0818695970', 'Laki-laki', '2003-02-08', 'Peserta', '2025-03-17 06:20:26', '2025-03-17 06:20:38', 'cb7d4bd352a6297ea39b1af6abadca53566d1dc329e0dece950a01362f3a2ddf', 'Bearer', 'zhang.cheng@binus.ac.id', '36', NULL, NULL, '3601', NULL, NULL, NULL, NULL, NULL, NULL);

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(191)) USING BTREE;

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`) USING BTREE,
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`(191),`tokenable_id`) USING BTREE;

--
-- Indexes for table `tbl_activities`
--
ALTER TABLE `tbl_activities`
  ADD PRIMARY KEY (`activity_id`) USING BTREE,
  ADD KEY `tbl_activities_phase_id_foreign` (`phase_id`) USING BTREE,
  ADD KEY `tbl_activities_user_id_foreign` (`user_id`) USING BTREE;

--
-- Indexes for table `tbl_detail_profile`
--
ALTER TABLE `tbl_detail_profile`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  ADD PRIMARY KEY (`feedback_id`) USING BTREE,
  ADD KEY `course_id` (`course_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `tbl_group`
--
ALTER TABLE `tbl_group`
  ADD PRIMARY KEY (`group_id`) USING BTREE;

--
-- Indexes for table `tbl_hasil_test`
--
ALTER TABLE `tbl_hasil_test`
  ADD PRIMARY KEY (`hasil_id`) USING BTREE;

--
-- Indexes for table `tbl_hasil_test_detail`
--
ALTER TABLE `tbl_hasil_test_detail`
  ADD PRIMARY KEY (`hasil_id_detail`) USING BTREE,
  ADD KEY `hasil_id` (`hasil_id`) USING BTREE,
  ADD KEY `jawaban_id` (`jawaban_id`) USING BTREE,
  ADD KEY `pertanyaan_id` (`pertanyaan_id`) USING BTREE;

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`or_id`) USING BTREE;

--
-- Indexes for table `tbl_pertanyaan`
--
ALTER TABLE `tbl_pertanyaan`
  ADD PRIMARY KEY (`pertanyaan_id`) USING BTREE,
  ADD KEY `course_id` (`course_id`) USING BTREE;

--
-- Indexes for table `tbl_phases`
--
ALTER TABLE `tbl_phases`
  ADD PRIMARY KEY (`phase_id`) USING BTREE,
  ADD KEY `tbl_phases_project_id_foreign` (`project_id`) USING BTREE;

--
-- Indexes for table `tbl_pilihan_jawaban`
--
ALTER TABLE `tbl_pilihan_jawaban`
  ADD PRIMARY KEY (`pilihan_id`) USING BTREE,
  ADD KEY `pertanyaan_id` (`pertanyaan_id`) USING BTREE;

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`p_id`) USING BTREE;

--
-- Indexes for table `tbl_projects`
--
ALTER TABLE `tbl_projects`
  ADD PRIMARY KEY (`project_id`) USING BTREE,
  ADD KEY `user_project` (`user_id`) USING BTREE;

--
-- Indexes for table `tbl_role_projects`
--
ALTER TABLE `tbl_role_projects`
  ADD PRIMARY KEY (`rolep_id`) USING BTREE,
  ADD KEY `tbl_role_projects_project_id_foreign` (`project_id`) USING BTREE;

--
-- Indexes for table `tbl_submission`
--
ALTER TABLE `tbl_submission`
  ADD PRIMARY KEY (`sm_id`) USING BTREE;

--
-- Indexes for table `tbl_subtopic`
--
ALTER TABLE `tbl_subtopic`
  ADD PRIMARY KEY (`st_id`) USING BTREE;

--
-- Indexes for table `tbl_tasks`
--
ALTER TABLE `tbl_tasks`
  ADD PRIMARY KEY (`task_id`) USING BTREE,
  ADD KEY `tbl_tasks_project_id_foreign` (`project_id`) USING BTREE,
  ADD KEY `tbl_tasks_phase_id_foreign` (`phase_id`) USING BTREE;

--
-- Indexes for table `tbl_task_assignments`
--
ALTER TABLE `tbl_task_assignments`
  ADD PRIMARY KEY (`assignment_id`) USING BTREE,
  ADD UNIQUE KEY `tbl_task_assignments_task_id_member_id_unique` (`task_id`,`member_id`) USING BTREE,
  ADD KEY `tbl_task_assignments_member_id_foreign` (`member_id`) USING BTREE;

--
-- Indexes for table `tbl_team_members`
--
ALTER TABLE `tbl_team_members`
  ADD PRIMARY KEY (`member_id`) USING BTREE,
  ADD UNIQUE KEY `tbl_team_members_user_id_project_id_rolep_id_unique` (`user_id`,`project_id`,`rolep_id`) USING BTREE,
  ADD KEY `tbl_team_members_project_id_foreign` (`project_id`) USING BTREE,
  ADD KEY `tbl_team_members_rolep_id_foreign` (`rolep_id`) USING BTREE;

--
-- Indexes for table `tbl_topic`
--
ALTER TABLE `tbl_topic`
  ADD PRIMARY KEY (`t_id`) USING BTREE;

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`t_id`) USING BTREE,
  ADD KEY `t_user_id` (`t_user_id`) USING BTREE;

--
-- Indexes for table `tbl_trans_activities`
--
ALTER TABLE `tbl_trans_activities`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_activities`
--
ALTER TABLE `tbl_activities`
  MODIFY `activity_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_detail_profile`
--
ALTER TABLE `tbl_detail_profile`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_group`
--
ALTER TABLE `tbl_group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_hasil_test`
--
ALTER TABLE `tbl_hasil_test`
  MODIFY `hasil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `tbl_hasil_test_detail`
--
ALTER TABLE `tbl_hasil_test_detail`
  MODIFY `hasil_id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=797;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `or_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pertanyaan`
--
ALTER TABLE `tbl_pertanyaan`
  MODIFY `pertanyaan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `tbl_phases`
--
ALTER TABLE `tbl_phases`
  MODIFY `phase_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_pilihan_jawaban`
--
ALTER TABLE `tbl_pilihan_jawaban`
  MODIFY `pilihan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_projects`
--
ALTER TABLE `tbl_projects`
  MODIFY `project_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_role_projects`
--
ALTER TABLE `tbl_role_projects`
  MODIFY `rolep_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_submission`
--
ALTER TABLE `tbl_submission`
  MODIFY `sm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_subtopic`
--
ALTER TABLE `tbl_subtopic`
  MODIFY `st_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_tasks`
--
ALTER TABLE `tbl_tasks`
  MODIFY `task_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_task_assignments`
--
ALTER TABLE `tbl_task_assignments`
  MODIFY `assignment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_team_members`
--
ALTER TABLE `tbl_team_members`
  MODIFY `member_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_topic`
--
ALTER TABLE `tbl_topic`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tbl_trans_activities`
--
ALTER TABLE `tbl_trans_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_detail_profile`
--
ALTER TABLE `tbl_detail_profile`
  ADD CONSTRAINT `tbl_detail_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
