/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50157
Source Host           : localhost:3306
Source Database       : tator_recharge

Target Server Type    : MYSQL
Target Server Version : 50157
File Encoding         : 65001

Date: 2014-04-08 15:10:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for recharge_error
-- ----------------------------
DROP TABLE IF EXISTS `recharge_error`;
CREATE TABLE `recharge_error` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL COMMENT '用户id',
  `txn_id` varchar(50) NOT NULL COMMENT 'paypal的订单号',
  `payment_date` varchar(30) NOT NULL COMMENT '付款日期',
  `mc_currency` varchar(20) DEFAULT NULL COMMENT '币种',
  `payment_type` varchar(20) DEFAULT NULL COMMENT '支付方式',
  `mc_gross` varchar(20) DEFAULT NULL COMMENT '付款金额',
  `tax` varchar(30) DEFAULT NULL COMMENT '税费金额',
  `txn_type` varchar(20) DEFAULT NULL COMMENT '购买方式',
  `item_name` varchar(20) NOT NULL COMMENT '商品名称',
  `item_number` varchar(20) NOT NULL COMMENT '商品编号',
  `residence_country` varchar(20) DEFAULT NULL COMMENT '国家地区代码',
  `address_country_code` varchar(20) DEFAULT NULL COMMENT '国家地址代码',
  `address_zip` varchar(20) DEFAULT NULL COMMENT '邮政编码',
  `receiver_email` varchar(50) NOT NULL COMMENT '收款人账户',
  `receiver_id` varchar(50) NOT NULL COMMENT '收款人账户',
  `business` varchar(50) NOT NULL COMMENT '收款人账户',
  `last_name` varchar(30) DEFAULT NULL COMMENT '付款人姓',
  `first_name` varchar(30) DEFAULT NULL COMMENT '付款人名',
  `payer_id` varchar(50) NOT NULL COMMENT '付款人账户',
  `payer_email` varchar(50) NOT NULL COMMENT '付款人邮箱',
  `address_country` varchar(50) DEFAULT NULL COMMENT '付款人国家',
  `address_state` varchar(50) DEFAULT NULL COMMENT '付款人 省/直辖市/自治区。',
  `address_city` varchar(50) DEFAULT NULL COMMENT '客户的地址县区或者市区',
  `address_street` varchar(50) DEFAULT NULL COMMENT '客户的街道地址',
  `address_name` varchar(50) DEFAULT NULL COMMENT '客户的地址名称',
  `payer_status` varchar(20) DEFAULT NULL COMMENT '客户的账户认证状态   unverified:未认证  verified:已认证',
  `payment_status` varchar(10) DEFAULT NULL COMMENT '支付状态',
  PRIMARY KEY (`id`,`txn_id`),
  UNIQUE KEY `txn_id` (`txn_id`) USING BTREE,
  KEY `index` (`uid`,`payment_date`,`item_number`,`payer_id`,`payer_email`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of recharge_error
-- ----------------------------
INSERT INTO `recharge_error` VALUES ('0000000010', '', '5EW346626P2092642', '22:34:25+Mar+31,+2014+PDT', 'USD', 'instant', '9.95', '0.00', 'express_checkout', '', '', 'CN', '', '', '531401335-facilitator@qq.com', 'U36KPL7SXA8SE', '', 'test', 'tator', 'Q6WFCL5267M4S', 'tatortest@qq.com', '', '', '', '', '', 'unverified', 'Pending');
INSERT INTO `recharge_error` VALUES ('0000000020', '', '45R4713263845863G', '23:08:27+Mar+31,+2014+PDT', 'USD', 'instant', '9.95', '0.00', 'express_checkout', '', '', 'CN', '', '', '531401335-facilitator@qq.com', 'U36KPL7SXA8SE', '', 'test', 'tator', 'Q6WFCL5267M4S', 'tatortest@qq.com', '', '', '', '', '', 'unverified', 'Completed');
INSERT INTO `recharge_error` VALUES ('0000000052', '', '85D51806VM606542W', '02:34:04+Apr+02,+2014+PDT', 'USD', 'instant', '9.95', '0.00', 'express_checkout', '', '', 'CN', '', '', '531401335-facilitator@qq.com', 'U36KPL7SXA8SE', '', 'test', 'tator', 'Q6WFCL5267M4S', 'tatortest@qq.com', '', '', '', '', '', 'verified', 'Completed');
INSERT INTO `recharge_error` VALUES ('0000000036', '', '55214817GD331774P', '20:32:43+Apr+02,+2014+PDT', 'USD', 'instant', '9.95', '0.00', 'express_checkout', '', '', 'CN', '', '', '531401335-facilitator@qq.com', 'U36KPL7SXA8SE', '', 'test', 'tator', 'Q6WFCL5267M4S', 'tatortest@qq.com', '', '', '', '', '', 'unverified', 'Pending');
INSERT INTO `recharge_error` VALUES ('0000000051', '', '47350936K5412850U', '21:49:10+Apr+02,+2014+PDT', 'USD', 'instant', '9.95', '0.00', 'express_checkout', '', '', 'CN', '', '', '531401335-facilitator@qq.com', 'U36KPL7SXA8SE', '', 'test', 'tator', 'Q6WFCL5267M4S', 'tatortest@qq.com', '', '', '', '', '', 'verified', 'Pending');

-- ----------------------------
-- Table structure for recharge_log
-- ----------------------------
DROP TABLE IF EXISTS `recharge_log`;
CREATE TABLE `recharge_log` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL COMMENT '用户id',
  `txn_id` varchar(50) NOT NULL COMMENT 'paypal的订单号',
  `payment_date` varchar(30) NOT NULL COMMENT '付款日期',
  `mc_currency` varchar(20) DEFAULT NULL COMMENT '币种',
  `payment_type` varchar(20) DEFAULT NULL COMMENT '支付方式',
  `mc_gross` varchar(20) DEFAULT NULL COMMENT '付款金额',
  `tax` varchar(30) DEFAULT NULL COMMENT '税费金额',
  `txn_type` varchar(20) DEFAULT NULL COMMENT '购买方式',
  `item_name` varchar(20) NOT NULL COMMENT '商品名称',
  `item_number` varchar(20) NOT NULL COMMENT '商品编号',
  `residence_country` varchar(20) DEFAULT NULL COMMENT '国家地区代码',
  `address_country_code` varchar(20) DEFAULT NULL COMMENT '国家地址代码',
  `address_zip` varchar(20) DEFAULT NULL COMMENT '邮政编码',
  `receiver_email` varchar(50) NOT NULL COMMENT '收款人账户',
  `receiver_id` varchar(50) NOT NULL COMMENT '收款人账户',
  `business` varchar(50) NOT NULL COMMENT '收款人账户',
  `last_name` varchar(30) DEFAULT NULL COMMENT '付款人姓',
  `first_name` varchar(30) DEFAULT NULL COMMENT '付款人名',
  `payer_id` varchar(50) NOT NULL COMMENT '付款人账户',
  `payer_email` varchar(50) NOT NULL COMMENT '付款人邮箱',
  `address_country` varchar(50) DEFAULT NULL COMMENT '付款人国家',
  `address_state` varchar(50) DEFAULT NULL COMMENT '付款人 省/直辖市/自治区。',
  `address_city` varchar(50) DEFAULT NULL COMMENT '客户的地址县区或者市区',
  `address_street` varchar(50) DEFAULT NULL COMMENT '客户的街道地址',
  `address_name` varchar(50) DEFAULT NULL COMMENT '客户的地址名称',
  `payer_status` varchar(20) DEFAULT NULL COMMENT '客户的账户认证状态   unverified:未认证  verified:已认证',
  `payment_status` varchar(10) DEFAULT NULL COMMENT '支付状态',
  PRIMARY KEY (`id`,`txn_id`),
  UNIQUE KEY `txn_id` (`txn_id`) USING HASH,
  KEY `index` (`uid`,`payment_date`,`item_number`,`payer_id`,`payer_email`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of recharge_log
-- ----------------------------
