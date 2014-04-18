-- phpMyAdmin SQL Dump
-- version 4.0.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2014 年 04 月 18 日 04:01
-- 服务器版本: 5.5.37
-- PHP 版本: 5.5.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `tator_recharge`
--

-- --------------------------------------------------------

--
-- 表的结构 `db_recharge_error`
--

CREATE TABLE IF NOT EXISTS `db_recharge_error` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- 转存表中的数据 `db_recharge_error`
--

INSERT INTO `db_recharge_error` (`id`, `uid`, `txn_id`, `payment_date`, `mc_currency`, `payment_type`, `mc_gross`, `tax`, `txn_type`, `item_name`, `item_number`, `residence_country`, `address_country_code`, `address_zip`, `receiver_email`, `receiver_id`, `business`, `last_name`, `first_name`, `payer_id`, `payer_email`, `address_country`, `address_state`, `address_city`, `address_street`, `address_name`, `payer_status`, `payment_status`) VALUES
(0000000010, '', '5EW346626P2092642', '22:34:25+Mar+31,+2014+PDT', 'USD', 'instant', '9.95', '0.00', 'express_checkout', '', '', 'CN', '', '', '531401335-facilitator@qq.com', 'U36KPL7SXA8SE', '', 'test', 'tator', 'Q6WFCL5267M4S', 'tatortest@qq.com', '', '', '', '', '', 'unverified', 'Pending'),
(0000000020, '', '45R4713263845863G', '23:08:27+Mar+31,+2014+PDT', 'USD', 'instant', '9.95', '0.00', 'express_checkout', '', '', 'CN', '', '', '531401335-facilitator@qq.com', 'U36KPL7SXA8SE', '', 'test', 'tator', 'Q6WFCL5267M4S', 'tatortest@qq.com', '', '', '', '', '', 'unverified', 'Completed'),
(0000000052, '', '85D51806VM606542W', '02:34:04+Apr+02,+2014+PDT', 'USD', 'instant', '9.95', '0.00', 'express_checkout', '', '', 'CN', '', '', '531401335-facilitator@qq.com', 'U36KPL7SXA8SE', '', 'test', 'tator', 'Q6WFCL5267M4S', 'tatortest@qq.com', '', '', '', '', '', 'verified', 'Completed'),
(0000000036, '', '55214817GD331774P', '20:32:43+Apr+02,+2014+PDT', 'USD', 'instant', '9.95', '0.00', 'express_checkout', '', '', 'CN', '', '', '531401335-facilitator@qq.com', 'U36KPL7SXA8SE', '', 'test', 'tator', 'Q6WFCL5267M4S', 'tatortest@qq.com', '', '', '', '', '', 'unverified', 'Pending'),
(0000000051, '', '47350936K5412850U', '21:49:10+Apr+02,+2014+PDT', 'USD', 'instant', '9.95', '0.00', 'express_checkout', '', '', 'CN', '', '', '531401335-facilitator@qq.com', 'U36KPL7SXA8SE', '', 'test', 'tator', 'Q6WFCL5267M4S', 'tatortest@qq.com', '', '', '', '', '', 'verified', 'Pending');

-- --------------------------------------------------------

--
-- 表的结构 `db_recharge_log`
--

CREATE TABLE IF NOT EXISTS `db_recharge_log` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- 转存表中的数据 `db_recharge_log`
--

INSERT INTO `db_recharge_log` (`id`, `uid`, `txn_id`, `payment_date`, `mc_currency`, `payment_type`, `mc_gross`, `tax`, `txn_type`, `item_name`, `item_number`, `residence_country`, `address_country_code`, `address_zip`, `receiver_email`, `receiver_id`, `business`, `last_name`, `first_name`, `payer_id`, `payer_email`, `address_country`, `address_state`, `address_city`, `address_street`, `address_name`, `payer_status`, `payment_status`) VALUES
(0000000022, '1262', '123', '14-04-01 03:12:12', NULL, NULL, '1.00', NULL, NULL, '', '', NULL, NULL, NULL, '', '', '', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0000000023, '1262', '356', '14-03-25 12:12:11', NULL, NULL, '2.00', NULL, NULL, '', '', NULL, NULL, NULL, '', '', '', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0000000028, '1262', '7998484', '14-04-01 03:12:22', NULL, NULL, '20.00', NULL, NULL, '', '', NULL, NULL, NULL, '', '', '', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0000000027, '1262', '79949', '14-04-01 03:12:32', NULL, NULL, '10.00', NULL, NULL, '', '', NULL, NULL, NULL, '', '', '', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0000000029, '1262', '7895462', '14-04-01 04:12:22', NULL, NULL, '30.12', NULL, NULL, '', '', NULL, NULL, NULL, '', '', '', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
