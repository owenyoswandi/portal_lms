-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2025 at 08:34 PM
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
(1, 1, 'Updated Database Design', 'Updated database schema design', '2024-02-13', '2024-02-20', 'High', NULL, NULL, 'Completed', '03:30:00', '100%', 1, '2025-02-13 16:45:23', '2025-02-13 16:48:14'),
(3, 6, 'repo init oioi', 'repo init in github and add collaborators', '2025-02-16', '2025-02-17', 'Easy', NULL, NULL, 'Review', '00:00:00', '100%', 3, '2025-02-16 07:17:21', '2025-02-16 10:06:17'),
(8, 10, 'persiapan', 'persiapan', '2025-02-10', '2025-02-11', 'Easy', NULL, NULL, 'Review', '00:00:00', '0%', 3, '2025-02-18 13:07:43', '2025-02-18 13:09:40'),
(9, 12, 'menunggu', 'menunggu antrian app kai access', '2025-02-19', '2025-02-19', 'Easy', '2025-02-20', '2025-02-20', 'In Progress', '01:00:00', '10%', 3, '2025-02-18 18:07:32', '2025-02-18 20:18:12');

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
(1, 1, 1, 2, 'couse bagus', 4, '2025-01-30 20:23:11', '2025-01-30 20:23:11'),
(3, 2, 9, 2, 'biasa aja sih', 4, '2025-02-19 00:20:30', '2025-02-19 00:20:30'),
(4, 2, 16, 2, 'nice', 5, '2025-02-19 00:22:55', '2025-02-19 00:22:55'),
(5, 2, 12, 2, 'oke', 3, '2025-02-19 00:24:07', '2025-02-19 00:24:07');

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
  `waktu_respon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

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
  `tipe_pertanyaan` enum('pilihan_ganda','isian') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_pertanyaan`
--

INSERT INTO `tbl_pertanyaan` (`pertanyaan_id`, `course_id`, `kategori`, `teks_pertanyaan`, `tipe_pertanyaan`) VALUES
(1, 1, 'Pretest', 'Pengolahan otomatis oleh mesin mempelajari pola berdasarkan data, disebut', 'pilihan_ganda'),
(2, 1, 'Pretest', 'Pengolahan otomatis oleh mesin mempelajari pola berdasarkan data, disebut', 'pilihan_ganda'),
(3, 1, 'Pretest', 'Pengolahan otomatis oleh mesin mempelajari pola berdasarkan data, disebut', 'pilihan_ganda');

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
(1, 1, 'Phase prep', 'init github repo and init regular meeting', NULL, '2025-02-04', '2025-02-06', '2025-02-09 10:39:18', '2025-02-09 13:12:26'),
(3, 3, 'fase a', 'baal1', NULL, '2025-02-09', '2025-02-15', '2025-02-09 11:45:13', '2025-02-09 13:11:37'),
(6, 6, 'fase prep', 'balala', 'in_progress', '2025-02-09', '2025-02-15', '2025-02-09 11:51:33', '2025-02-18 17:56:19'),
(7, 6, 'fase development', 'blalala', 'created', '2025-02-10', '2025-02-16', '2025-02-09 12:20:05', '2025-02-18 17:56:19'),
(8, 6, 'fase testing', 'balalala', 'created', '2025-02-24', '2025-02-28', '2025-02-13 15:14:26', '2025-02-18 17:56:19'),
(9, 7, 'phase 1', 'versi 1', 'created', '2025-02-16', '2025-02-17', '2025-02-16 12:29:33', '2025-02-18 17:56:42'),
(10, 8, 'persiapan material', 'melakukan list dan pembelian material yg dibutuhkan', 'created', '2025-02-23', '2025-02-24', '2025-02-16 12:34:49', '2025-02-18 17:53:06'),
(11, 9, 'preparation repo', 'init repo, add collaborator, init template', 'created', '2025-02-19', '2025-02-21', '2025-02-18 17:55:19', '2025-02-18 17:55:55'),
(12, 10, 'fase nunggu', 'menunggu antrian app kai access', 'created', '2025-02-19', '2025-02-20', '2025-02-18 18:06:11', '2025-02-18 18:06:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pilihan_jawaban`
--

CREATE TABLE `tbl_pilihan_jawaban` (
  `pilihan_id` int(11) NOT NULL,
  `pertanyaan_id` int(11) DEFAULT NULL,
  `teks_pilihan` text NOT NULL,
  `is_jawaban_benar` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_pilihan_jawaban`
--

INSERT INTO `tbl_pilihan_jawaban` (`pilihan_id`, `pertanyaan_id`, `teks_pilihan`, `is_jawaban_benar`) VALUES
(1, 1, 'Machine Learning', 1);

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
(1, 'course', 'Natural Language Processing (NLP) Basics', 'Learn the basics of NLP, including text processing, sentiment analysis, and language generation.', 'uploads/course/course1_1711803657.jpg', '4', 'https://ems.ai4talent.my.id/course/natural-language-processing-nlp-basics', 10000, 1, '2025-01-22 13:29:57', '2025-02-14 03:46:31', '2024-01-21 08:55:00', '2024-01-22 09:15:00'),
(2, 'course', 'AI and Robotics Integration', 'Explore the integration of AI and robotics, including robot control and perception.', 'uploads/course/course13_1711803683.jpg', '9', 'https://ems.ai4talent.my.id/course/ai-and-robotics-integration', 30000, 1, '2025-01-20 07:34:23', NULL, '2024-01-21 08:55:00', '2024-01-22 09:15:00'),
(3, 'course', 'AI for Finance', 'Analyze the application of AI in financial markets, risk assessment, and investment strategies.', 'uploads/course/course14_1711803699.jpg', '11', 'https://ems.ai4talent.my.id/course/ai-for-finance', 10000, 1, '2025-01-20 07:34:29', NULL, '2024-03-29 02:54:00', '2024-04-01 02:54:00'),
(4, 'course', 'AI for Marketing', 'Explore AI-driven marketing strategies, including customer segmentation and personalized campaigns.', 'uploads/course/course15_1711803710.jpg', '12', 'https://ems.ai4talent.my.id/course/ai-for-marketing', 20000, 1, '2025-01-20 07:34:38', NULL, '2024-03-30 02:55:00', '2024-04-06 02:55:00'),
(5, 'course', 'Computer Vision Fundamentals', 'An in-depth look at computer vision techniques, object detection, and image recognition.', 'uploads/course/course16_1711803721.jpg', '5', 'https://ems.ai4talent.my.id/course/computer-vision-fundamentals', 5000, 1, '2025-01-20 07:34:45', NULL, '2024-03-30 02:56:00', '2024-04-04 02:56:00'),
(6, 'course', 'AI Ethics and Responsible AI', 'Examine the ethical considerations and responsible practices in the field of AI.', 'uploads/course/course17_1711803733.jpg', '7', 'https://ems.ai4talent.my.id/course/ai-ethics-and-responsible-ai', 20000, 1, '2025-01-20 07:35:00', NULL, '2024-03-30 02:56:00', '2024-04-02 02:56:00'),
(7, 'course', 'tes', 'tes', 'uploads/course/1737352661_online-learning.png', '1', 'https://', 50000, 1, '2025-01-20 05:57:41', NULL, '2025-01-21 05:55:00', '2025-01-23 05:55:00');

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
(10, 'War Ticket', 2, 'war ticket kereta api di dini hari', '2025-02-19', '2025-02-20', 'active', '2025-02-18 18:06:11', '2025-02-18 18:06:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role_projects`
--

CREATE TABLE `tbl_role_projects` (
  `rolep_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `rolep_name` varchar(255) NOT NULL,
  `rolep_desc` text DEFAULT NULL,
  `add_activity_ability` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_role_projects`
--

INSERT INTO `tbl_role_projects` (`rolep_id`, `project_id`, `rolep_name`, `rolep_desc`, `add_activity_ability`, `created_at`, `updated_at`) VALUES
(1, 1, 'Project Manager', 'manage project', NULL, '2025-02-09 10:39:18', '2025-02-09 13:12:26'),
(6, 6, 'pm', 'ppm', 0, '2025-02-09 11:51:33', '2025-02-18 17:56:19'),
(7, 2, 'pm', 'pmpmpm', NULL, '2025-02-09 13:10:57', '2025-02-09 13:11:09'),
(8, 6, 'Fullstack engineer', 'yaa', 0, '2025-02-13 14:45:05', '2025-02-18 17:56:19'),
(9, 7, 'PM', 'project manager', 1, '2025-02-16 12:29:33', '2025-02-18 17:56:42'),
(10, 8, 'PM', 'project manager', 1, '2025-02-16 12:34:49', '2025-02-18 17:53:06'),
(11, 8, 'developer', 'buat kerangka', 0, '2025-02-16 13:07:06', '2025-02-18 17:53:06'),
(13, 9, 'Project Manager 111', 'Always check the timeline', 1, '2025-02-18 17:55:19', '2025-02-18 17:55:55'),
(14, 10, 'Customer', 'pelanggan kai access', 1, '2025-02-18 18:06:11', '2025-02-18 18:06:11');

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
  `st_creadate` timestamp NULL DEFAULT NULL,
  `st_modidate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_subtopic`
--

INSERT INTO `tbl_subtopic` (`st_id`, `st_t_id`, `st_jenis`, `st_name`, `st_file`, `st_start_date`, `st_due_date`, `st_duration`, `st_attemp_allowed`, `st_creadate`, `st_modidate`) VALUES
(1, 2, 'Test', 'Pretest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-19 17:00:00', NULL),
(2, 2, 'Modul', 'P2a Pengenalan Toolss', 'uploads/Modul/1737372674_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 11:31:14', NULL),
(3, 1, 'Test', 'Pretest', NULL, '2025-01-27 13:42:57', '2025-02-28 10:17:00', 30, 2, '2025-01-20 16:36:16', NULL),
(4, 1, 'Modul', 'P1a Modul Instalasi', 'uploads/Modul/1737391029_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 16:37:09', NULL),
(5, 1, 'Test', 'Posttest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 16:38:04', NULL),
(6, 2, 'Task', 'P2b Task : Review Tools', 'uploads/Task/1737391514_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', '2025-01-24 17:00:00', NULL, NULL, '2025-01-20 16:45:14', NULL),
(8, 2, 'Task Collection', 'Hasil Review Tools', NULL, '2025-01-22 13:42:57', '2025-02-21 16:59:00', NULL, NULL, '2025-01-20 16:59:54', NULL),
(9, 4, 'Test', 'Pretest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 17:05:53', NULL),
(10, 4, 'Modul', 'Modul Introduction to AI', 'uploads/Modul/1737392778_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 17:06:18', NULL),
(11, 5, 'Test', 'Pretest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 17:08:16', NULL),
(12, 5, 'Modul', 'Modul', 'uploads/Modul/1737392927_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 17:08:47', NULL),
(14, 6, 'Test', 'Pretest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 17:09:11', NULL),
(15, 6, 'Task', 'Review Pengenalan Tools', 'uploads/Task/1737392984_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', '2025-01-29 17:09:00', NULL, NULL, '2025-01-20 17:09:44', NULL),
(16, 6, 'Task Collection', 'Hasil Reviw', NULL, '2025-01-22 13:42:57', '2025-01-29 17:09:00', NULL, NULL, '2025-01-20 17:10:00', NULL);

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
(3, 3);

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
(7, 2, 8, 10, '2025-02-10 17:00:00', '2025-02-16 12:34:49', '2025-02-18 17:53:06'),
(8, 3, 8, 11, '2025-02-10 17:00:00', '2025-02-16 13:07:06', '2025-02-18 17:53:06'),
(10, 2, 9, 13, '2025-02-17 17:00:00', '2025-02-18 17:55:19', '2025-02-18 17:55:55'),
(11, 3, 10, 14, '2025-02-18 18:06:11', '2025-02-18 18:06:11', '2025-02-18 18:06:11');

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
(6, 2, 'Instalation Tools', '2025-01-20 17:05:00', NULL);

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
(12, '102', '101', 2, NULL, 'inflow', 100000, 'waiting confirmation', 'User-Transaction-Topup12.png', NULL, '2025-01-19 15:49:10', '2025-01-19 15:49:26');

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
(1, NULL, 'admin', 'admin', 'Administrator', 'SUkabumi', '0856224425', 'Perempuan', '1996-05-19', 'Admin', '2024-01-02 09:18:29', '2025-02-21 19:30:53', 'b17c041aa81864a604b305e8114c8c6acd3fb332a8a63a90479685e646243d6e', 'Bearer', 'ekoabdulgoffar129@gmail.com', '32', '3202070002', '3202070', '3202', NULL, NULL, NULL, 0, 0, NULL),
(2, NULL, 'fatwa', 'fatwa', 'Fatwa Paramadhani', 'SUkabumi', '08562244255', 'Perempuan', '1996-05-19', 'Peserta', '2024-01-02 09:18:29', '2025-02-21 19:33:27', '82c90f8be58e4fa598d5c1b55862f1050d7ff4fed171c725f10dcd990a891b5c', 'Bearer', '', '32', '3202070002', '3202070', '3202', NULL, NULL, NULL, 0, 0, NULL),
(3, NULL, 'qq', 'qq123', 'qq', 'Ponorogo', '08562244255', 'Perempuan', '1996-05-19', 'Peserta', '2025-02-13 14:42:57', '2025-02-18 13:05:06', 'f9df69c9d84f6ba389aed9821799ba824cac926a39b1ff93cde4c774936e2e1f', 'Bearer', 'qq@mail.com', '32', '3202070002', '3202070', '3202', NULL, NULL, NULL, 0, 0, NULL);

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
  ADD KEY `password_resets_email_index` (`email`) USING BTREE;

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`) USING BTREE,
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`) USING BTREE;

--
-- Indexes for table `tbl_activities`
--
ALTER TABLE `tbl_activities`
  ADD PRIMARY KEY (`activity_id`) USING BTREE,
  ADD KEY `tbl_activities_phase_id_foreign` (`phase_id`) USING BTREE,
  ADD KEY `tbl_activities_user_id_foreign` (`user_id`) USING BTREE;

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `users_email_unique` (`email`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_activities`
--
ALTER TABLE `tbl_activities`
  MODIFY `activity_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_group`
--
ALTER TABLE `tbl_group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_hasil_test`
--
ALTER TABLE `tbl_hasil_test`
  MODIFY `hasil_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_hasil_test_detail`
--
ALTER TABLE `tbl_hasil_test_detail`
  MODIFY `hasil_id_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `or_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pertanyaan`
--
ALTER TABLE `tbl_pertanyaan`
  MODIFY `pertanyaan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_phases`
--
ALTER TABLE `tbl_phases`
  MODIFY `phase_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_pilihan_jawaban`
--
ALTER TABLE `tbl_pilihan_jawaban`
  MODIFY `pilihan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_projects`
--
ALTER TABLE `tbl_projects`
  MODIFY `project_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_role_projects`
--
ALTER TABLE `tbl_role_projects`
  MODIFY `rolep_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_submission`
--
ALTER TABLE `tbl_submission`
  MODIFY `sm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_subtopic`
--
ALTER TABLE `tbl_subtopic`
  MODIFY `st_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `member_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_topic`
--
ALTER TABLE `tbl_topic`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_trans_activities`
--
ALTER TABLE `tbl_trans_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_activities`
--
ALTER TABLE `tbl_activities`
  ADD CONSTRAINT `tbl_activities_phase_id_foreign` FOREIGN KEY (`phase_id`) REFERENCES `tbl_phases` (`phase_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE NO ACTION;

--
-- Constraints for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  ADD CONSTRAINT `tbl_feedback_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `tbl_product` (`p_id`),
  ADD CONSTRAINT `tbl_feedback_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`);

--
-- Constraints for table `tbl_hasil_test_detail`
--
ALTER TABLE `tbl_hasil_test_detail`
  ADD CONSTRAINT `tbl_hasil_test_detail_ibfk_1` FOREIGN KEY (`hasil_id`) REFERENCES `tbl_hasil_test` (`hasil_id`),
  ADD CONSTRAINT `tbl_hasil_test_detail_ibfk_2` FOREIGN KEY (`jawaban_id`) REFERENCES `tbl_pilihan_jawaban` (`pilihan_id`),
  ADD CONSTRAINT `tbl_hasil_test_detail_ibfk_3` FOREIGN KEY (`pertanyaan_id`) REFERENCES `tbl_pertanyaan` (`pertanyaan_id`);

--
-- Constraints for table `tbl_pertanyaan`
--
ALTER TABLE `tbl_pertanyaan`
  ADD CONSTRAINT `tbl_pertanyaan_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `tbl_product` (`p_id`);

--
-- Constraints for table `tbl_phases`
--
ALTER TABLE `tbl_phases`
  ADD CONSTRAINT `tbl_phases_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `tbl_projects` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_pilihan_jawaban`
--
ALTER TABLE `tbl_pilihan_jawaban`
  ADD CONSTRAINT `tbl_pilihan_jawaban_ibfk_1` FOREIGN KEY (`pertanyaan_id`) REFERENCES `tbl_pertanyaan` (`pertanyaan_id`);

--
-- Constraints for table `tbl_projects`
--
ALTER TABLE `tbl_projects`
  ADD CONSTRAINT `tbl_projects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`);

--
-- Constraints for table `tbl_role_projects`
--
ALTER TABLE `tbl_role_projects`
  ADD CONSTRAINT `tbl_role_projects_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `tbl_projects` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_tasks`
--
ALTER TABLE `tbl_tasks`
  ADD CONSTRAINT `tbl_tasks_phase_id_foreign` FOREIGN KEY (`phase_id`) REFERENCES `tbl_phases` (`phase_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `tbl_projects` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_task_assignments`
--
ALTER TABLE `tbl_task_assignments`
  ADD CONSTRAINT `tbl_task_assignments_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `tbl_team_members` (`member_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_task_assignments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tbl_tasks` (`task_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_team_members`
--
ALTER TABLE `tbl_team_members`
  ADD CONSTRAINT `tbl_team_members_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `tbl_projects` (`project_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_team_members_rolep_id_foreign` FOREIGN KEY (`rolep_id`) REFERENCES `tbl_role_projects` (`rolep_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_team_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD CONSTRAINT `tbl_transaction_ibfk_1` FOREIGN KEY (`t_user_id`) REFERENCES `tbl_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
