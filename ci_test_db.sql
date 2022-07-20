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

 Date: 20/07/2022 21:33:13
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
  `timestamps` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 'product 1', 'product 1 desc', 'product1.svg', 1, 1000.00, '2022-07-20 15:39:39');
INSERT INTO `products` VALUES (2, 'product 2', 'product 2 desc', 'product2.svg', 0, 1100.00, '2022-07-05 15:40:38');
INSERT INTO `products` VALUES (3, 'product 3', 'product 3 desc', 'product2.svg', 0, 895.00, '2022-07-05 15:40:38');
INSERT INTO `products` VALUES (4, 'product 4', 'product 4 desc', 'product2.svg', 1, 1000.00, '2022-07-05 15:40:38');
INSERT INTO `products` VALUES (5, 'product 5', 'product 5 desc', 'product2.svg', 1, 158.66, '2022-07-05 15:40:38');
INSERT INTO `products` VALUES (6, 'product 6', 'product 6 desc', 'product2.svg', 0, 200.00, '2022-07-05 15:40:38');
INSERT INTO `products` VALUES (7, 'product 7', 'product 7 desc', 'product2.svg', 0, 955.20, '2022-07-05 15:40:38');
INSERT INTO `products` VALUES (8, 'product 8', 'product 8 desc', 'product2.svg', 1, 1000.00, '2022-07-05 15:40:38');
INSERT INTO `products` VALUES (9, 'product 9', 'product 9 desc', 'product2.svg', 1, 1000.00, '2022-07-05 15:40:38');
INSERT INTO `products` VALUES (10, 'product 10', 'product 10 desc', 'product3.svg', 0, 1000.00, '2022-07-05 15:40:38');

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
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sellers
-- ----------------------------
INSERT INTO `sellers` VALUES (1, 1, 1, 10, 20.00, '2022-07-20 16:38:31');
INSERT INTO `sellers` VALUES (2, 1, 2, 4, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (3, 1, 4, 5, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (4, 5, 3, 3, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (5, 2, 5, 2, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (6, 2, 1, 1, 30.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (7, 10, 7, 20, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (8, 3, 1, 0, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (9, 4, 1, 10, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (10, 10, 1, 100, 1000.55, '2022-07-20 16:49:45');
INSERT INTO `sellers` VALUES (11, 9, 9, 7, 5.00, '2022-07-20 17:03:36');
INSERT INTO `sellers` VALUES (13, 6, 1, 8, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (14, 9, 10, 1, 10.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (15, 4, 4, 88, 60.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (16, 10, 5, 6, 99.00, '2022-07-20 18:23:46');
INSERT INTO `sellers` VALUES (17, 1, 8, 2, 30.00, '2022-07-20 18:23:46');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` tinyint NULL DEFAULT 0,
  `verified` enum('yes','no','') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'no',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Tigran', 'tigrann@10web.io', 1, 'yes');
INSERT INTO `users` VALUES (2, 'Aram', 'aram@mail.ru', 1, 'yes');
INSERT INTO `users` VALUES (3, 'Hayk', 'hayk@gmail.com', 0, 'no');
INSERT INTO `users` VALUES (4, 'Alla', 'alla@bk.ru', 1, 'yes');
INSERT INTO `users` VALUES (5, 'Anna', 'anna@anna.ru', 1, 'no');
INSERT INTO `users` VALUES (6, 'Karen', 'karen@karen.be', 0, 'yes');
INSERT INTO `users` VALUES (7, 'Hakob', 'hakob@10web.io', 0, 'no');
INSERT INTO `users` VALUES (8, 'Smbat', 'smbat@10web.io', 0, 'no');
INSERT INTO `users` VALUES (9, 'Lilit', 'lilit@10web.io', 1, 'yes');
INSERT INTO `users` VALUES (10, 'Gevorg', 'gevorg@10web.io', 1, 'yes');

SET FOREIGN_KEY_CHECKS = 1;
