/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:8889
 Source Schema         : covid

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 31/05/2020 03:20:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for m_ipropinsi
-- ----------------------------
DROP TABLE IF EXISTS `m_ipropinsi`;
CREATE TABLE `m_ipropinsi` (
  `id_propinsi` int(5) NOT NULL AUTO_INCREMENT,
  `nama_propinsi` varchar(50) NOT NULL,
  PRIMARY KEY (`id_propinsi`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_ipropinsi
-- ----------------------------
BEGIN;
INSERT INTO `m_ipropinsi` VALUES (1, 'BANTEN');
INSERT INTO `m_ipropinsi` VALUES (2, 'DKI JAKARTA');
INSERT INTO `m_ipropinsi` VALUES (3, 'JAWA BARAT');
INSERT INTO `m_ipropinsi` VALUES (4, 'JAWA TENGAH');
INSERT INTO `m_ipropinsi` VALUES (5, 'DI YOGYAKARTA');
INSERT INTO `m_ipropinsi` VALUES (6, 'JAWA TIMUR');
INSERT INTO `m_ipropinsi` VALUES (7, 'BALI');
INSERT INTO `m_ipropinsi` VALUES (8, 'NANGGROE ACEH DARUSSALAM (NAD)');
INSERT INTO `m_ipropinsi` VALUES (9, 'SUMATERA UTARA');
INSERT INTO `m_ipropinsi` VALUES (10, 'SUMATERA BARAT');
INSERT INTO `m_ipropinsi` VALUES (11, 'RIAU');
INSERT INTO `m_ipropinsi` VALUES (12, 'KEPULAUAN RIAU');
INSERT INTO `m_ipropinsi` VALUES (13, 'JAMBI');
INSERT INTO `m_ipropinsi` VALUES (14, 'BENGKULU');
INSERT INTO `m_ipropinsi` VALUES (15, 'SUMATERA SELATAN');
INSERT INTO `m_ipropinsi` VALUES (16, 'BANGKA BELITUNG');
INSERT INTO `m_ipropinsi` VALUES (17, 'LAMPUNG');
INSERT INTO `m_ipropinsi` VALUES (18, 'KALIMANTAN BARAT');
INSERT INTO `m_ipropinsi` VALUES (19, 'KALIMANTAN TENGAH');
INSERT INTO `m_ipropinsi` VALUES (20, 'KALIMANTAN SELATAN');
INSERT INTO `m_ipropinsi` VALUES (21, 'KALIMANTAN TIMUR');
INSERT INTO `m_ipropinsi` VALUES (22, 'KALIMANTAN UTARA');
INSERT INTO `m_ipropinsi` VALUES (23, 'SULAWESI BARAT');
INSERT INTO `m_ipropinsi` VALUES (24, 'SULAWESI SELATAN');
INSERT INTO `m_ipropinsi` VALUES (25, 'SULAWESI TENGGARA');
INSERT INTO `m_ipropinsi` VALUES (26, 'SULAWESI TENGAH');
INSERT INTO `m_ipropinsi` VALUES (27, 'GORONTALO');
INSERT INTO `m_ipropinsi` VALUES (28, 'SULAWESI UTARA');
INSERT INTO `m_ipropinsi` VALUES (29, 'MALUKU');
INSERT INTO `m_ipropinsi` VALUES (30, 'MALUKU UTARA');
INSERT INTO `m_ipropinsi` VALUES (31, 'NUSA TENGGARA BARAT (NTB)');
INSERT INTO `m_ipropinsi` VALUES (32, 'NUSA TENGGARA TIMUR (NTT)');
INSERT INTO `m_ipropinsi` VALUES (33, 'PAPUA BARAT');
INSERT INTO `m_ipropinsi` VALUES (34, 'PAPUA');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
