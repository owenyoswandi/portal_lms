/*
 Navicat Premium Data Transfer

 Source Server         : qq
 Source Server Type    : MySQL
 Source Server Version : 100427 (10.4.27-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : portal-iais

 Target Server Type    : MySQL
 Target Server Version : 100427 (10.4.27-MariaDB)
 File Encoding         : 65001

 Date: 13/02/2025 23:50:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (4, '2025_02_02_170716_create_projects_table', 1);
INSERT INTO `migrations` VALUES (5, '2025_02_02_170814_create_phases_table', 1);
INSERT INTO `migrations` VALUES (6, '2025_02_02_170846_create_project_roles_table', 1);
INSERT INTO `migrations` VALUES (39, '2014_10_12_000000_create_users_table', 2);
INSERT INTO `migrations` VALUES (40, '2014_10_12_100000_create_password_resets_table', 2);
INSERT INTO `migrations` VALUES (41, '2019_12_14_000001_create_personal_access_tokens_table', 2);
INSERT INTO `migrations` VALUES (42, '2025_02_02_171452_create_tbl_projects_table', 2);
INSERT INTO `migrations` VALUES (45, '2025_02_02_171551_create_tbl_phases_table', 3);
INSERT INTO `migrations` VALUES (46, '2025_02_02_171709_create_tbl_role_projects_table', 3);
INSERT INTO `migrations` VALUES (47, '2025_02_09_133058_tbl_team_members', 3);
INSERT INTO `migrations` VALUES (48, '2025_02_09_133132_tbl_tasks', 3);
INSERT INTO `migrations` VALUES (49, '2025_02_09_133149_tbl_task_assigments', 3);
INSERT INTO `migrations` VALUES (50, '2025_02_13_220651_create_tbl_activities', 4);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_activities
-- ----------------------------
DROP TABLE IF EXISTS `tbl_activities`;
CREATE TABLE `tbl_activities`  (
  `activity_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `phase_id` bigint UNSIGNED NOT NULL,
  `activity_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `complexity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` time NOT NULL,
  `completion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`activity_id`) USING BTREE,
  INDEX `tbl_activities_phase_id_foreign`(`phase_id` ASC) USING BTREE,
  INDEX `tbl_activities_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `tbl_activities_phase_id_foreign` FOREIGN KEY (`phase_id`) REFERENCES `tbl_phases` (`phase_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `tbl_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE NO ACTION ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_activities
-- ----------------------------
INSERT INTO `tbl_activities` VALUES (1, 1, 'Updated Database Design', 'Updated database schema design', '2024-02-13', '2024-02-20', 'High', 'Completed', '03:30:00', '100%', 1, '2025-02-13 23:45:23', '2025-02-13 23:48:14');

-- ----------------------------
-- Table structure for tbl_feedback
-- ----------------------------
DROP TABLE IF EXISTS `tbl_feedback`;
CREATE TABLE `tbl_feedback`  (
  `feedback_id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `user_id` int NOT NULL,
  `feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `rating` int NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `modified_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`feedback_id`) USING BTREE,
  INDEX `course_id`(`course_id` ASC) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  CONSTRAINT `tbl_feedback_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `tbl_product` (`p_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tbl_feedback_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_feedback
-- ----------------------------
INSERT INTO `tbl_feedback` VALUES (1, 1, 2, 'couse bagus', 4, '2025-01-30 20:23:11', '2025-01-30 20:23:11');

-- ----------------------------
-- Table structure for tbl_group
-- ----------------------------
DROP TABLE IF EXISTS `tbl_group`;
CREATE TABLE `tbl_group`  (
  `group_id` int NOT NULL AUTO_INCREMENT,
  `group_name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `group_logo` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `group_email` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `group_phone` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `group_alamat` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `group_creaby` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `group_modiby` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `group_creadate` datetime NOT NULL,
  `group_modidate` datetime NOT NULL,
  PRIMARY KEY (`group_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_group
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_hasil_test
-- ----------------------------
DROP TABLE IF EXISTS `tbl_hasil_test`;
CREATE TABLE `tbl_hasil_test`  (
  `hasil_id` int NOT NULL AUTO_INCREMENT,
  `peserta_id` int NOT NULL,
  `waktu_respon` datetime NOT NULL,
  PRIMARY KEY (`hasil_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_hasil_test
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_hasil_test_detail
-- ----------------------------
DROP TABLE IF EXISTS `tbl_hasil_test_detail`;
CREATE TABLE `tbl_hasil_test_detail`  (
  `hasil_id_detail` int NOT NULL AUTO_INCREMENT,
  `hasil_id` int NULL DEFAULT NULL,
  `pertanyaan_id` int NULL DEFAULT NULL,
  `jawaban_id` int NULL DEFAULT NULL,
  `jawaban_isian` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`hasil_id_detail`) USING BTREE,
  INDEX `hasil_id`(`hasil_id` ASC) USING BTREE,
  INDEX `jawaban_id`(`jawaban_id` ASC) USING BTREE,
  INDEX `pertanyaan_id`(`pertanyaan_id` ASC) USING BTREE,
  CONSTRAINT `tbl_hasil_test_detail_ibfk_1` FOREIGN KEY (`hasil_id`) REFERENCES `tbl_hasil_test` (`hasil_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tbl_hasil_test_detail_ibfk_2` FOREIGN KEY (`jawaban_id`) REFERENCES `tbl_pilihan_jawaban` (`pilihan_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tbl_hasil_test_detail_ibfk_3` FOREIGN KEY (`pertanyaan_id`) REFERENCES `tbl_pertanyaan` (`pertanyaan_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_hasil_test_detail
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_order
-- ----------------------------
DROP TABLE IF EXISTS `tbl_order`;
CREATE TABLE `tbl_order`  (
  `or_id` int NOT NULL AUTO_INCREMENT,
  `p_id` int NOT NULL,
  `user_id` int NOT NULL,
  `or_status` int NOT NULL DEFAULT 0,
  `or_created_date` timestamp NOT NULL DEFAULT current_timestamp,
  `or_modified_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`or_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_order
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_pertanyaan
-- ----------------------------
DROP TABLE IF EXISTS `tbl_pertanyaan`;
CREATE TABLE `tbl_pertanyaan`  (
  `pertanyaan_id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `kategori` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `teks_pertanyaan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tipe_pertanyaan` enum('pilihan_ganda','isian') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`pertanyaan_id`) USING BTREE,
  INDEX `course_id`(`course_id` ASC) USING BTREE,
  CONSTRAINT `tbl_pertanyaan_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `tbl_product` (`p_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_pertanyaan
-- ----------------------------
INSERT INTO `tbl_pertanyaan` VALUES (1, 1, 'Pretest', 'Pengolahan otomatis oleh mesin mempelajari pola berdasarkan data, disebut', 'pilihan_ganda');

-- ----------------------------
-- Table structure for tbl_phases
-- ----------------------------
DROP TABLE IF EXISTS `tbl_phases`;
CREATE TABLE `tbl_phases`  (
  `phase_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` bigint UNSIGNED NOT NULL,
  `phase_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phase_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`phase_id`) USING BTREE,
  INDEX `tbl_phases_project_id_foreign`(`project_id` ASC) USING BTREE,
  CONSTRAINT `tbl_phases_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `tbl_projects` (`project_id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_phases
-- ----------------------------
INSERT INTO `tbl_phases` VALUES (1, 1, 'Phase prep', 'init github repo and init regular meeting', NULL, '2025-02-04', '2025-02-06', '2025-02-09 17:39:18', '2025-02-09 20:12:26');
INSERT INTO `tbl_phases` VALUES (3, 3, 'fase a', 'baal1', NULL, '2025-02-09', '2025-02-15', '2025-02-09 18:45:13', '2025-02-09 20:11:37');
INSERT INTO `tbl_phases` VALUES (6, 6, 'fase prep', 'balala', 'in_progress', '2025-02-09', '2025-02-15', '2025-02-09 18:51:33', '2025-02-13 22:38:12');
INSERT INTO `tbl_phases` VALUES (7, 6, 'fase development', 'blalala', 'created', '2025-02-10', '2025-02-16', '2025-02-09 19:20:05', '2025-02-13 22:38:12');
INSERT INTO `tbl_phases` VALUES (8, 6, 'fase testing', 'balalala', 'created', '2025-02-24', '2025-02-28', '2025-02-13 22:14:26', '2025-02-13 22:38:12');

-- ----------------------------
-- Table structure for tbl_pilihan_jawaban
-- ----------------------------
DROP TABLE IF EXISTS `tbl_pilihan_jawaban`;
CREATE TABLE `tbl_pilihan_jawaban`  (
  `pilihan_id` int NOT NULL AUTO_INCREMENT,
  `pertanyaan_id` int NULL DEFAULT NULL,
  `teks_pilihan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_jawaban_benar` tinyint(1) NOT NULL,
  PRIMARY KEY (`pilihan_id`) USING BTREE,
  INDEX `pertanyaan_id`(`pertanyaan_id` ASC) USING BTREE,
  CONSTRAINT `tbl_pilihan_jawaban_ibfk_1` FOREIGN KEY (`pertanyaan_id`) REFERENCES `tbl_pertanyaan` (`pertanyaan_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_pilihan_jawaban
-- ----------------------------
INSERT INTO `tbl_pilihan_jawaban` VALUES (1, 1, 'Machine Learning', 1);

-- ----------------------------
-- Table structure for tbl_product
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product`;
CREATE TABLE `tbl_product`  (
  `p_id` int NOT NULL AUTO_INCREMENT,
  `p_jenis` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `p_judul` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `p_deskripsi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `p_img` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p_id_lms` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `p_url_lms` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `p_harga` int NULL DEFAULT NULL,
  `p_status` int NOT NULL DEFAULT 0,
  `p_created_date` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `p_modified_date` timestamp NULL DEFAULT NULL,
  `p_start_date` timestamp NULL DEFAULT NULL,
  `p_end_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`p_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_product
-- ----------------------------
INSERT INTO `tbl_product` VALUES (1, 'course', 'Natural Language Processing (NLP) Basics', 'Learn the basics of NLP, including text processing, sentiment analysis, and language generation.', 'uploads/course/course1_1711803657.jpg', '4', 'https://ems.ai4talent.my.id/course/natural-language-processing-nlp-basics', 10000, 1, '2025-01-22 20:29:57', NULL, '2024-01-21 15:55:00', '2024-01-22 16:15:00');
INSERT INTO `tbl_product` VALUES (2, 'course', 'AI and Robotics Integration', 'Explore the integration of AI and robotics, including robot control and perception.', 'uploads/course/course13_1711803683.jpg', '9', 'https://ems.ai4talent.my.id/course/ai-and-robotics-integration', 30000, 1, '2025-01-20 14:34:23', NULL, '2024-01-21 15:55:00', '2024-01-22 16:15:00');
INSERT INTO `tbl_product` VALUES (3, 'course', 'AI for Finance', 'Analyze the application of AI in financial markets, risk assessment, and investment strategies.', 'uploads/course/course14_1711803699.jpg', '11', 'https://ems.ai4talent.my.id/course/ai-for-finance', 10000, 1, '2025-01-20 14:34:29', NULL, '2024-03-29 09:54:00', '2024-04-01 09:54:00');
INSERT INTO `tbl_product` VALUES (4, 'course', 'AI for Marketing', 'Explore AI-driven marketing strategies, including customer segmentation and personalized campaigns.', 'uploads/course/course15_1711803710.jpg', '12', 'https://ems.ai4talent.my.id/course/ai-for-marketing', 20000, 1, '2025-01-20 14:34:38', NULL, '2024-03-30 09:55:00', '2024-04-06 09:55:00');
INSERT INTO `tbl_product` VALUES (5, 'course', 'Computer Vision Fundamentals', 'An in-depth look at computer vision techniques, object detection, and image recognition.', 'uploads/course/course16_1711803721.jpg', '5', 'https://ems.ai4talent.my.id/course/computer-vision-fundamentals', 5000, 1, '2025-01-20 14:34:45', NULL, '2024-03-30 09:56:00', '2024-04-04 09:56:00');
INSERT INTO `tbl_product` VALUES (6, 'course', 'AI Ethics and Responsible AI', 'Examine the ethical considerations and responsible practices in the field of AI.', 'uploads/course/course17_1711803733.jpg', '7', 'https://ems.ai4talent.my.id/course/ai-ethics-and-responsible-ai', 20000, 1, '2025-01-20 14:35:00', NULL, '2024-03-30 09:56:00', '2024-04-02 09:56:00');
INSERT INTO `tbl_product` VALUES (7, 'course', 'tes', 'tes', 'uploads/course/1737352661_online-learning.png', '1', 'https://', 50000, 1, '2025-01-20 12:57:41', NULL, '2025-01-21 12:55:00', '2025-01-23 12:55:00');

-- ----------------------------
-- Table structure for tbl_projects
-- ----------------------------
DROP TABLE IF EXISTS `tbl_projects`;
CREATE TABLE `tbl_projects`  (
  `project_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `project_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`project_id`) USING BTREE,
  INDEX `user_project`(`user_id` ASC) USING BTREE,
  CONSTRAINT `tbl_projects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_projects
-- ----------------------------
INSERT INTO `tbl_projects` VALUES (1, 'Project A', 2, 'Ini adalah sebuah project', '2025-02-02', '2025-03-01', 'active', '2025-02-09 17:39:18', '2025-02-09 17:39:18');
INSERT INTO `tbl_projects` VALUES (2, 'coba', 2, 'coba', '2025-02-09', '2025-02-12', 'active', '2025-02-09 18:33:23', '2025-02-09 18:33:23');
INSERT INTO `tbl_projects` VALUES (3, 'project abc', 2, 'balala', '2025-02-09', '2025-02-23', 'active', '2025-02-09 18:45:13', '2025-02-09 18:45:13');
INSERT INTO `tbl_projects` VALUES (6, 'project wacana', 2, 'balala oioioi', '2025-02-09', '2025-02-23', '', '2025-02-09 18:51:33', '2025-02-13 22:38:12');

-- ----------------------------
-- Table structure for tbl_role_projects
-- ----------------------------
DROP TABLE IF EXISTS `tbl_role_projects`;
CREATE TABLE `tbl_role_projects`  (
  `rolep_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` bigint UNSIGNED NOT NULL,
  `rolep_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rolep_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`rolep_id`) USING BTREE,
  INDEX `tbl_role_projects_project_id_foreign`(`project_id` ASC) USING BTREE,
  CONSTRAINT `tbl_role_projects_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `tbl_projects` (`project_id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_role_projects
-- ----------------------------
INSERT INTO `tbl_role_projects` VALUES (1, 1, 'Project Manager', 'manage project', '2025-02-09 17:39:18', '2025-02-09 20:12:26');
INSERT INTO `tbl_role_projects` VALUES (6, 6, 'pm', 'ppm', '2025-02-09 18:51:33', '2025-02-13 22:38:12');
INSERT INTO `tbl_role_projects` VALUES (7, 2, 'pm', 'pmpmpm', '2025-02-09 20:10:57', '2025-02-09 20:11:09');
INSERT INTO `tbl_role_projects` VALUES (8, 6, 'Fullstack engineer', 'yaa', '2025-02-13 21:45:05', '2025-02-13 22:38:12');

-- ----------------------------
-- Table structure for tbl_submission
-- ----------------------------
DROP TABLE IF EXISTS `tbl_submission`;
CREATE TABLE `tbl_submission`  (
  `sm_id` int NOT NULL AUTO_INCREMENT,
  `sm_st_id` int NOT NULL,
  `sm_user_id` int NOT NULL,
  `sm_file` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `sm_comment` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sm_status` int NOT NULL,
  `sm_creadate` timestamp NULL DEFAULT NULL,
  `sm_modidate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`sm_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_submission
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_subtopic
-- ----------------------------
DROP TABLE IF EXISTS `tbl_subtopic`;
CREATE TABLE `tbl_subtopic`  (
  `st_id` int NOT NULL AUTO_INCREMENT,
  `st_t_id` int NOT NULL,
  `st_jenis` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `st_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `st_file` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `st_start_date` timestamp NULL DEFAULT NULL,
  `st_due_date` timestamp NULL DEFAULT NULL,
  `st_duration` int NULL DEFAULT NULL,
  `st_attemp_allowed` int NULL DEFAULT NULL,
  `st_creadate` timestamp NULL DEFAULT NULL,
  `st_modidate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`st_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_subtopic
-- ----------------------------
INSERT INTO `tbl_subtopic` VALUES (1, 2, 'Test', 'Pretest', NULL, '2025-01-22 20:42:57', NULL, NULL, NULL, '2025-01-20 00:00:00', NULL);
INSERT INTO `tbl_subtopic` VALUES (2, 2, 'Modul', 'P2a Pengenalan Toolss', 'uploads/Modul/1737372674_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 20:42:57', NULL, NULL, NULL, '2025-01-20 18:31:14', NULL);
INSERT INTO `tbl_subtopic` VALUES (3, 1, 'Test', 'Pretest', NULL, '2025-01-22 20:42:57', NULL, NULL, NULL, '2025-01-20 23:36:16', NULL);
INSERT INTO `tbl_subtopic` VALUES (4, 1, 'Modul', 'P1a Modul Instalasi', 'uploads/Modul/1737391029_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 20:42:57', NULL, NULL, NULL, '2025-01-20 23:37:09', NULL);
INSERT INTO `tbl_subtopic` VALUES (5, 1, 'Test', 'Posttest', NULL, '2025-01-22 20:42:57', NULL, NULL, NULL, '2025-01-20 23:38:04', NULL);
INSERT INTO `tbl_subtopic` VALUES (6, 2, 'Task', 'P2b Task : Review Tools', 'uploads/Task/1737391514_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 20:42:57', '2025-01-25 00:00:00', NULL, NULL, '2025-01-20 23:45:14', NULL);
INSERT INTO `tbl_subtopic` VALUES (8, 2, 'Task Collection', 'Hasil Review Tools', NULL, '2025-01-22 20:42:57', '2025-01-25 23:59:00', NULL, NULL, '2025-01-20 23:59:54', NULL);
INSERT INTO `tbl_subtopic` VALUES (9, 4, 'Test', 'Pretest', NULL, '2025-01-22 20:42:57', NULL, NULL, NULL, '2025-01-21 00:05:53', NULL);
INSERT INTO `tbl_subtopic` VALUES (10, 4, 'Modul', 'Modul Introduction to AI', 'uploads/Modul/1737392778_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 20:42:57', NULL, NULL, NULL, '2025-01-21 00:06:18', NULL);
INSERT INTO `tbl_subtopic` VALUES (11, 5, 'Test', 'Pretest', NULL, '2025-01-22 20:42:57', NULL, NULL, NULL, '2025-01-21 00:08:16', NULL);
INSERT INTO `tbl_subtopic` VALUES (12, 5, 'Modul', 'Modul', 'uploads/Modul/1737392927_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 20:42:57', NULL, NULL, NULL, '2025-01-21 00:08:47', NULL);
INSERT INTO `tbl_subtopic` VALUES (14, 6, 'Test', 'Pretest', NULL, '2025-01-22 20:42:57', NULL, NULL, NULL, '2025-01-21 00:09:11', NULL);
INSERT INTO `tbl_subtopic` VALUES (15, 6, 'Task', 'Review Pengenalan Tools', 'uploads/Task/1737392984_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 20:42:57', '2025-01-30 00:09:00', NULL, NULL, '2025-01-21 00:09:44', NULL);
INSERT INTO `tbl_subtopic` VALUES (16, 6, 'Task Collection', 'Hasil Reviw', NULL, '2025-01-22 20:42:57', '2025-01-30 00:09:00', NULL, NULL, '2025-01-21 00:10:00', NULL);

-- ----------------------------
-- Table structure for tbl_task_assignments
-- ----------------------------
DROP TABLE IF EXISTS `tbl_task_assignments`;
CREATE TABLE `tbl_task_assignments`  (
  `assignment_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` bigint UNSIGNED NOT NULL,
  `member_id` bigint UNSIGNED NOT NULL,
  `assigned_date` timestamp NOT NULL DEFAULT current_timestamp,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`assignment_id`) USING BTREE,
  UNIQUE INDEX `tbl_task_assignments_task_id_member_id_unique`(`task_id` ASC, `member_id` ASC) USING BTREE,
  INDEX `tbl_task_assignments_member_id_foreign`(`member_id` ASC) USING BTREE,
  CONSTRAINT `tbl_task_assignments_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `tbl_team_members` (`member_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `tbl_task_assignments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tbl_tasks` (`task_id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_task_assignments
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_tasks
-- ----------------------------
DROP TABLE IF EXISTS `tbl_tasks`;
CREATE TABLE `tbl_tasks`  (
  `task_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` bigint UNSIGNED NOT NULL,
  `phase_id` bigint UNSIGNED NOT NULL,
  `task_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `priority` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `deadline` datetime NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`task_id`) USING BTREE,
  INDEX `tbl_tasks_project_id_foreign`(`project_id` ASC) USING BTREE,
  INDEX `tbl_tasks_phase_id_foreign`(`phase_id` ASC) USING BTREE,
  CONSTRAINT `tbl_tasks_phase_id_foreign` FOREIGN KEY (`phase_id`) REFERENCES `tbl_phases` (`phase_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `tbl_tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `tbl_projects` (`project_id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_tasks
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_team_members
-- ----------------------------
DROP TABLE IF EXISTS `tbl_team_members`;
CREATE TABLE `tbl_team_members`  (
  `member_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `project_id` bigint UNSIGNED NOT NULL,
  `rolep_id` bigint UNSIGNED NOT NULL,
  `assigned_date` timestamp NOT NULL DEFAULT current_timestamp,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`member_id`) USING BTREE,
  UNIQUE INDEX `tbl_team_members_user_id_project_id_rolep_id_unique`(`user_id` ASC, `project_id` ASC, `rolep_id` ASC) USING BTREE,
  INDEX `tbl_team_members_project_id_foreign`(`project_id` ASC) USING BTREE,
  INDEX `tbl_team_members_rolep_id_foreign`(`rolep_id` ASC) USING BTREE,
  CONSTRAINT `tbl_team_members_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `tbl_projects` (`project_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `tbl_team_members_rolep_id_foreign` FOREIGN KEY (`rolep_id`) REFERENCES `tbl_role_projects` (`rolep_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `tbl_team_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_team_members
-- ----------------------------
INSERT INTO `tbl_team_members` VALUES (3, 2, 6, 6, '2025-02-05 00:00:00', '2025-02-09 19:44:46', '2025-02-13 22:38:12');
INSERT INTO `tbl_team_members` VALUES (4, 2, 2, 7, '2025-02-08 00:00:00', '2025-02-09 20:10:57', '2025-02-09 20:11:09');
INSERT INTO `tbl_team_members` VALUES (5, 3, 6, 8, '2025-02-11 00:00:00', '2025-02-13 21:45:05', '2025-02-13 22:38:12');

-- ----------------------------
-- Table structure for tbl_topic
-- ----------------------------
DROP TABLE IF EXISTS `tbl_topic`;
CREATE TABLE `tbl_topic`  (
  `t_id` int NOT NULL AUTO_INCREMENT,
  `t_p_id` int NOT NULL,
  `t_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `t_creadate` timestamp NULL DEFAULT NULL,
  `t_modidate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`t_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_topic
-- ----------------------------
INSERT INTO `tbl_topic` VALUES (1, 1, 'P1 Instalasi', '2025-01-20 14:54:02', NULL);
INSERT INTO `tbl_topic` VALUES (2, 1, 'P2 Pengenalan Tools', '2025-01-20 17:38:55', NULL);
INSERT INTO `tbl_topic` VALUES (4, 2, 'Introduction to AI', '2025-01-21 00:02:15', NULL);
INSERT INTO `tbl_topic` VALUES (5, 2, 'Introduction to Robotics', '2025-01-21 00:04:05', NULL);
INSERT INTO `tbl_topic` VALUES (6, 2, 'Instalation Tools', '2025-01-21 00:05:00', NULL);

-- ----------------------------
-- Table structure for tbl_trans_activities
-- ----------------------------
DROP TABLE IF EXISTS `tbl_trans_activities`;
CREATE TABLE `tbl_trans_activities`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_trans_activities
-- ----------------------------
INSERT INTO `tbl_trans_activities` VALUES (1, '101', 'Top Up');
INSERT INTO `tbl_trans_activities` VALUES (2, '102', 'Buying Course');

-- ----------------------------
-- Table structure for tbl_transaction
-- ----------------------------
DROP TABLE IF EXISTS `tbl_transaction`;
CREATE TABLE `tbl_transaction`  (
  `t_id` int NOT NULL AUTO_INCREMENT,
  `t_transaction_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `t_code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `t_user_id` int NOT NULL,
  `t_p_id` int NULL DEFAULT NULL,
  `t_type` enum('inflow','outflow') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `t_amount` int NOT NULL,
  `t_status` enum('unpaid','waiting confirmation','paid') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `t_user_proof` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `t_admin_proof` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `t_created_date` timestamp NOT NULL DEFAULT current_timestamp,
  `t_modified_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`t_id`) USING BTREE,
  INDEX `t_user_id`(`t_user_id` ASC) USING BTREE,
  CONSTRAINT `tbl_transaction_ibfk_1` FOREIGN KEY (`t_user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_transaction
-- ----------------------------
INSERT INTO `tbl_transaction` VALUES (1, '101', '101', 2, NULL, 'inflow', 50000, 'paid', 'User-Transaction-Topup1.jpg', 'Admin-Transaction-Topup1.jpg', '2024-03-28 04:58:38', '2024-03-28 04:58:37');
INSERT INTO `tbl_transaction` VALUES (2, '101', '101', 2, NULL, 'inflow', 20000, 'paid', 'User-Transaction-Topup2.jpg', 'Admin-Transaction-Topup2.jpg', '2024-03-28 09:12:01', '2024-03-28 09:16:01');
INSERT INTO `tbl_transaction` VALUES (3, '101', '101', 2, NULL, 'inflow', 50000, 'paid', 'User-Transaction-Topup3.jpg', 'Admin-Transaction-Topup3.jpg', '2024-03-28 09:15:06', '2024-03-28 09:20:32');
INSERT INTO `tbl_transaction` VALUES (7, '101', '101', 2, NULL, 'inflow', 50000, 'paid', 'User-Transaction-Topup7.jpg', 'Admin-Transaction-Topup7.jpg', '2024-03-28 13:41:13', '2024-03-28 14:45:44');
INSERT INTO `tbl_transaction` VALUES (8, '102', '102', 2, 6, 'outflow', 30000, 'paid', NULL, NULL, '2024-03-30 08:44:12', NULL);
INSERT INTO `tbl_transaction` VALUES (9, '102', '102', 2, 1, 'outflow', 10000, 'paid', NULL, NULL, '2024-03-30 08:46:58', NULL);
INSERT INTO `tbl_transaction` VALUES (11, '102', '102', 2, 2, 'outflow', 30000, 'paid', NULL, NULL, '2025-01-19 22:48:07', NULL);
INSERT INTO `tbl_transaction` VALUES (12, '102', '101', 2, NULL, 'inflow', 100000, 'waiting confirmation', 'User-Transaction-Topup12.png', NULL, '2025-01-19 22:49:10', '2025-01-19 22:49:26');

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user`  (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `username` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `no_hp` varchar(23) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `jk` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tgl_lhr` date NOT NULL,
  `role` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL,
  `api_token` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `token_type` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Bearer',
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `provinsi` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kelurahan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kecamatan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kota_kab` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pendidikan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pekerjaan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `agama` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `group_id` int NULL DEFAULT NULL,
  `saldo` float NULL DEFAULT NULL,
  `level` int NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES (1, NULL, 'admin', 'admin', 'Administrator', 'SUkabumi', '0856224425', 'Perempuan', '1996-05-19', 'Admin', '2024-01-02 16:18:29', '2025-02-13 23:40:17', 'c0841e1b0fe714915a35f55a4fe9d1225df0b2d2d02c4cc4e26ece28f8b41e4e', 'Bearer', 'ekoabdulgoffar129@gmail.com', '32', '3202070002', '3202070', '3202', NULL, NULL, NULL, 0, 0, NULL);
INSERT INTO `tbl_user` VALUES (2, NULL, 'fatwa', 'fatwa', 'Fatwa Paramadhani', 'SUkabumi', '08562244255', 'Perempuan', '1996-05-19', 'Peserta', '2024-01-02 16:18:29', '2025-02-13 22:05:57', '6004ae132d92fccc0e3a0262edf8d425c298aefce086f5dd947565499539b896', 'Bearer', '', '32', '3202070002', '3202070', '3202', NULL, NULL, NULL, 0, 0, NULL);
INSERT INTO `tbl_user` VALUES (3, NULL, 'qq', 'qq123', 'qq', 'Ponorogo', '08562244255', 'Perempuan', '1996-05-19', 'Peserta', '2025-02-13 21:42:57', '2025-02-13 21:45:52', '12d202ba01132d52ad1d52352544bad8bb7ebf5b4b5cc0952facfe17145288fd', 'Bearer', 'qq@mail.com', '32', '3202070002', '3202070', '3202', NULL, NULL, NULL, 0, 0, NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
