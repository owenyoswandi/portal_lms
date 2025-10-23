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

 Date: 22/01/2025 22:52:19
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_feedback
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_group
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_order
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_product
-- ----------------------------
INSERT INTO `tbl_product` VALUES (1, 'course', 'Natural Language Processing (NLP) Basics', 'Learn the basics of NLP, including text processing, sentiment analysis, and language generation.', 'uploads/course/course1_1711803657.jpg', '4', 'https://ems.ai4talent.my.id/course/natural-language-processing-nlp-basics', 10000, 1, '2025-01-22 13:29:57', NULL, '2024-01-21 08:55:00', '2024-01-22 09:15:00');
INSERT INTO `tbl_product` VALUES (2, 'course', 'AI and Robotics Integration', 'Explore the integration of AI and robotics, including robot control and perception.', 'uploads/course/course13_1711803683.jpg', '9', 'https://ems.ai4talent.my.id/course/ai-and-robotics-integration', 30000, 1, '2025-01-20 07:34:23', NULL, '2024-01-21 08:55:00', '2024-01-22 09:15:00');
INSERT INTO `tbl_product` VALUES (3, 'course', 'AI for Finance', 'Analyze the application of AI in financial markets, risk assessment, and investment strategies.', 'uploads/course/course14_1711803699.jpg', '11', 'https://ems.ai4talent.my.id/course/ai-for-finance', 10000, 1, '2025-01-20 07:34:29', NULL, '2024-03-29 02:54:00', '2024-04-01 02:54:00');
INSERT INTO `tbl_product` VALUES (4, 'course', 'AI for Marketing', 'Explore AI-driven marketing strategies, including customer segmentation and personalized campaigns.', 'uploads/course/course15_1711803710.jpg', '12', 'https://ems.ai4talent.my.id/course/ai-for-marketing', 20000, 1, '2025-01-20 07:34:38', NULL, '2024-03-30 02:55:00', '2024-04-06 02:55:00');
INSERT INTO `tbl_product` VALUES (5, 'course', 'Computer Vision Fundamentals', 'An in-depth look at computer vision techniques, object detection, and image recognition.', 'uploads/course/course16_1711803721.jpg', '5', 'https://ems.ai4talent.my.id/course/computer-vision-fundamentals', 5000, 1, '2025-01-20 07:34:45', NULL, '2024-03-30 02:56:00', '2024-04-04 02:56:00');
INSERT INTO `tbl_product` VALUES (6, 'course', 'AI Ethics and Responsible AI', 'Examine the ethical considerations and responsible practices in the field of AI.', 'uploads/course/course17_1711803733.jpg', '7', 'https://ems.ai4talent.my.id/course/ai-ethics-and-responsible-ai', 20000, 1, '2025-01-20 07:35:00', NULL, '2024-03-30 02:56:00', '2024-04-02 02:56:00');
INSERT INTO `tbl_product` VALUES (7, 'course', 'tes', 'tes', 'uploads/course/1737352661_online-learning.png', '1', 'https://', 50000, 1, '2025-01-20 05:57:41', NULL, '2025-01-21 05:55:00', '2025-01-23 05:55:00');

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_subtopic
-- ----------------------------
INSERT INTO `tbl_subtopic` VALUES (1, 2, 'Test', 'Pretest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-19 17:00:00', NULL);
INSERT INTO `tbl_subtopic` VALUES (2, 2, 'Modul', 'P2a Pengenalan Toolss', 'uploads/Modul/1737372674_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 11:31:14', NULL);
INSERT INTO `tbl_subtopic` VALUES (3, 1, 'Test', 'Pretest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 16:36:16', NULL);
INSERT INTO `tbl_subtopic` VALUES (4, 1, 'Modul', 'P1a Modul Instalasi', 'uploads/Modul/1737391029_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 16:37:09', NULL);
INSERT INTO `tbl_subtopic` VALUES (5, 1, 'Test', 'Posttest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 16:38:04', NULL);
INSERT INTO `tbl_subtopic` VALUES (6, 2, 'Task', 'P2b Task : Review Tools', 'uploads/Task/1737391514_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', '2025-01-24 17:00:00', NULL, NULL, '2025-01-20 16:45:14', NULL);
INSERT INTO `tbl_subtopic` VALUES (8, 2, 'Task Collection', 'Hasil Review Tools', NULL, '2025-01-22 13:42:57', '2025-01-25 16:59:00', NULL, NULL, '2025-01-20 16:59:54', NULL);
INSERT INTO `tbl_subtopic` VALUES (9, 4, 'Test', 'Pretest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 17:05:53', NULL);
INSERT INTO `tbl_subtopic` VALUES (10, 4, 'Modul', 'Modul Introduction to AI', 'uploads/Modul/1737392778_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 17:06:18', NULL);
INSERT INTO `tbl_subtopic` VALUES (11, 5, 'Test', 'Pretest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 17:08:16', NULL);
INSERT INTO `tbl_subtopic` VALUES (12, 5, 'Modul', 'Modul', 'uploads/Modul/1737392927_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 17:08:47', NULL);
INSERT INTO `tbl_subtopic` VALUES (14, 6, 'Test', 'Pretest', NULL, '2025-01-22 13:42:57', NULL, NULL, NULL, '2025-01-20 17:09:11', NULL);
INSERT INTO `tbl_subtopic` VALUES (15, 6, 'Task', 'Review Pengenalan Tools', 'uploads/Task/1737392984_1_5_Energi dan daya Listrik-1.pdf', '2025-01-22 13:42:57', '2025-01-29 17:09:00', NULL, NULL, '2025-01-20 17:09:44', NULL);
INSERT INTO `tbl_subtopic` VALUES (16, 6, 'Task Collection', 'Hasil Reviw', NULL, '2025-01-22 13:42:57', '2025-01-29 17:09:00', NULL, NULL, '2025-01-20 17:10:00', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_topic
-- ----------------------------
INSERT INTO `tbl_topic` VALUES (1, 1, 'P1 Instalasi', '2025-01-20 07:54:02', NULL);
INSERT INTO `tbl_topic` VALUES (2, 1, 'P2 Pengenalan Tools', '2025-01-20 10:38:55', NULL);
INSERT INTO `tbl_topic` VALUES (4, 2, 'Introduction to AI', '2025-01-20 17:02:15', NULL);
INSERT INTO `tbl_topic` VALUES (5, 2, 'Introduction to Robotics', '2025-01-20 17:04:05', NULL);
INSERT INTO `tbl_topic` VALUES (6, 2, 'Instalation Tools', '2025-01-20 17:05:00', NULL);

-- ----------------------------
-- Table structure for tbl_trans_activities
-- ----------------------------
DROP TABLE IF EXISTS `tbl_trans_activities`;
CREATE TABLE `tbl_trans_activities`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_transaction
-- ----------------------------
INSERT INTO `tbl_transaction` VALUES (1, '101', '101', 2, NULL, 'inflow', 50000, 'paid', 'User-Transaction-Topup1.jpg', 'Admin-Transaction-Topup1.jpg', '2024-03-27 21:58:38', '2024-03-27 21:58:37');
INSERT INTO `tbl_transaction` VALUES (2, '101', '101', 2, NULL, 'inflow', 20000, 'paid', 'User-Transaction-Topup2.jpg', 'Admin-Transaction-Topup2.jpg', '2024-03-28 02:12:01', '2024-03-28 02:16:01');
INSERT INTO `tbl_transaction` VALUES (3, '101', '101', 2, NULL, 'inflow', 50000, 'paid', 'User-Transaction-Topup3.jpg', 'Admin-Transaction-Topup3.jpg', '2024-03-28 02:15:06', '2024-03-28 02:20:32');
INSERT INTO `tbl_transaction` VALUES (7, '101', '101', 2, NULL, 'inflow', 50000, 'paid', 'User-Transaction-Topup7.jpg', 'Admin-Transaction-Topup7.jpg', '2024-03-28 06:41:13', '2024-03-28 07:45:44');
INSERT INTO `tbl_transaction` VALUES (8, '102', '102', 2, 6, 'outflow', 30000, 'paid', NULL, NULL, '2024-03-30 01:44:12', NULL);
INSERT INTO `tbl_transaction` VALUES (9, '102', '102', 2, 1, 'outflow', 10000, 'paid', NULL, NULL, '2024-03-30 01:46:58', NULL);
INSERT INTO `tbl_transaction` VALUES (11, '102', '102', 2, 2, 'outflow', 30000, 'paid', NULL, NULL, '2025-01-19 15:48:07', NULL);
INSERT INTO `tbl_transaction` VALUES (12, '102', '101', 2, NULL, 'inflow', 100000, 'waiting confirmation', 'User-Transaction-Topup12.png', NULL, '2025-01-19 15:49:10', '2025-01-19 15:49:26');

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES (1, NULL, 'admin', 'admin', 'Administrator', 'SUkabumi', '0856224425', 'Perempuan', '1996-05-19', 'Admin', '2024-01-02 09:18:29', '2025-01-22 13:28:57', 'b604a46155d5cdd547307a0f4f28ce6798528971b784f713aaf8ac61d9a60fb0', 'Bearer', 'ekoabdulgoffar129@gmail.com', '32', '3202070002', '3202070', '3202', NULL, NULL, NULL, 0, 0, NULL);
INSERT INTO `tbl_user` VALUES (2, NULL, 'fatwa', 'fatwa', 'Fatwa Paramadhani', 'SUkabumi', '08562244255', 'Perempuan', '1996-05-19', 'Peserta', '2024-01-02 09:18:29', '2025-01-22 11:40:28', '77031cfb18b2c4d676e32047306fe7f37a5d81856b2a6020dbc2dd0098a98147', 'Bearer', '', '32', '3202070002', '3202070', '3202', NULL, NULL, NULL, 0, 0, NULL);

SET FOREIGN_KEY_CHECKS = 1;
