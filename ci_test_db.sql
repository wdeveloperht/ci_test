/*
 Navicat Premium Data Transfer

 Source Server         : xampp
 Source Server Type    : MySQL
 Source Server Version : 100424
 Source Host           : localhost:3306
 Source Schema         : ci_test_db

 Target Server Type    : MySQL
 Target Server Version : 100424
 File Encoding         : 65001

 Date: 02/08/2022 20:19:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `image` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` tinyint NULL DEFAULT NULL,
  `price` decimal(10, 2) NULL DEFAULT NULL,
  `timestamps` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 'product 1', 'product 1 desc', '678767294.png', 0, 1000.00, '2022-08-02 17:47:40');
INSERT INTO `products` VALUES (2, 'product 2', 'product 2 desc', '740129276.png', 0, 1100.00, '2022-08-02 17:47:30');
INSERT INTO `products` VALUES (3, 'product 3', 'product 3 desc', '655338403.png', 1, 895.00, '2022-08-02 17:47:16');
INSERT INTO `products` VALUES (4, 'product 4', 'product 4 desc', '452964379.jpg', 1, 1000.00, '2022-08-02 17:47:02');
INSERT INTO `products` VALUES (5, 'product 5', 'product 5 desc', '765047130.jpg', 0, 158.66, '2022-08-02 17:46:54');
INSERT INTO `products` VALUES (6, 'product 6', 'product 6 desc', '686785314.jpg', 1, 200.00, '2022-08-02 17:46:38');
INSERT INTO `products` VALUES (7, 'product 7', 'product 7 desc', '757145306.jpg', 0, 955.20, '2022-08-02 17:46:29');
INSERT INTO `products` VALUES (8, 'product 8', 'dasd', '416526484.jpg', 1, 100.00, '2022-08-01 23:16:27');

-- ----------------------------
-- Table structure for sellers
-- ----------------------------
DROP TABLE IF EXISTS `sellers`;
CREATE TABLE `sellers`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` int UNSIGNED NULL DEFAULT NULL,
  `id_product` int UNSIGNED NULL DEFAULT NULL,
  `qty` int NULL DEFAULT NULL,
  `per_price` decimal(10, 2) NULL DEFAULT NULL,
  `timestamps` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_user`(`id_user`, `id_product`) USING BTREE,
  INDEX `id_product`(`id_product`) USING BTREE,
  CONSTRAINT `sellers_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sellers_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sellers
-- ----------------------------
INSERT INTO `sellers` VALUES (1, 1, 1, 2, 20.00, '2022-07-20 16:38:31');
INSERT INTO `sellers` VALUES (2, 1, 4, 2, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (3, 1, 3, 2, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (4, 5, 3, 3, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (5, 2, 5, 2, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (6, 2, 1, 1, 30.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (7, 10, 7, 20, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (8, 3, 1, 0, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (9, 4, 1, 10, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (10, 10, 1, 100, 1000.55, '2022-07-20 16:49:45');
INSERT INTO `sellers` VALUES (13, 6, 1, 8, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (16, 10, 5, 6, 99.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (17, 1, 2, 2, 30.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (20, 4, 8, 100, 2000.00, '2022-08-02 18:08:48');
INSERT INTO `sellers` VALUES (23, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` tinyint NULL DEFAULT 0,
  `verified` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'no',
  `email_verification_key` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `email_verified_ex` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', 'Tigran', 'tigrann@10web.io', '$2y$10$0AUeeBn0P1iJcrTQrSH10.SSlQzA8b0cKip8eDL0G0A2.7JcFTsF.', 1, 'yes', NULL, NULL, NULL);
INSERT INTO `users` VALUES (2, 'admin', 'Aram', 'aram@mail.ru', NULL, 1, 'yes', NULL, NULL, NULL);
INSERT INTO `users` VALUES (3, 'user', 'Hayk', 'hayk@gmail.com', NULL, 0, 'no', NULL, NULL, NULL);
INSERT INTO `users` VALUES (4, 'user', 'Alla', 'user@user.com', '$2y$10$0AUeeBn0P1iJcrTQrSH10.SSlQzA8b0cKip8eDL0G0A2.7JcFTsF.', 1, 'yes', NULL, NULL, NULL);
INSERT INTO `users` VALUES (5, 'user', 'Anna', 'anna@anna.ru', NULL, 1, 'no', NULL, NULL, NULL);
INSERT INTO `users` VALUES (6, 'user', 'Karen', 'karen@karen.be', NULL, 0, 'yes', NULL, NULL, NULL);
INSERT INTO `users` VALUES (7, 'user', 'Hakob', 'hakob@10web.io', NULL, 0, 'no', NULL, NULL, NULL);
INSERT INTO `users` VALUES (8, 'user', 'Smbat', 'smbat@10web.io', NULL, 0, 'no', NULL, NULL, NULL);
INSERT INTO `users` VALUES (9, 'user', 'Lilit', 'lilit@10web.io', NULL, 1, 'yes', NULL, NULL, NULL);
INSERT INTO `users` VALUES (10, 'user', 'Gevorg', 'gevorg@10web.io', NULL, 1, 'yes', NULL, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
