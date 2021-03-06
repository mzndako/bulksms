-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 11, 2020 at 11:02 PM
-- Server version: 5.7.31-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mkalisms_bulksms`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill_gateway`
--

CREATE TABLE `bill_gateway` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL,
  `param1` varchar(50) NOT NULL,
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bill_history`
--

CREATE TABLE `bill_history` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `transaction_id` varchar(15) NOT NULL DEFAULT '',
  `bill_type` varchar(15) DEFAULT NULL,
  `network` varchar(10) NOT NULL DEFAULT '',
  `type` varchar(100) NOT NULL DEFAULT '',
  `recipient` varchar(200) NOT NULL DEFAULT '',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `profit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `commission` decimal(10,2) NOT NULL DEFAULT '0.00',
  `transaction_fee` decimal(6,2) NOT NULL DEFAULT '0.00',
  `amount_credited` decimal(10,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` varchar(20) NOT NULL DEFAULT '',
  `status_code` int(11) NOT NULL DEFAULT '0',
  `is_success` tinyint(4) NOT NULL DEFAULT '0',
  `remark` varchar(300) DEFAULT NULL,
  `payment_method` varchar(10) DEFAULT '',
  `gateway` varchar(20) NOT NULL DEFAULT '',
  `order_id` varchar(50) NOT NULL DEFAULT '',
  `updated_user_id` int(11) NOT NULL DEFAULT '0',
  `updated_time` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bill_rate`
--

CREATE TABLE `bill_rate` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `bill` longtext,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill_rate`
--

INSERT INTO `bill_rate` (`id`, `owner`, `name`, `bill`, `active`, `date`) VALUES
(1, 1, 'Members', '{\"airtime\":{\"mtn\":\"1%\",\"9mobile\":\"1%\",\"airtel\":\"1%\",\"glo\":\"1%\"},\"dataplan\":{\"mtn\":{\"500\":\"-1\",\"1000\":\"-1\",\"1500.01\":\"-1\",\"2000\":\"-1\",\"3500.01\":\"-1\",\"5000\":\"-1\",\"10000.01\":\"0\",\"22000.01\":\"0\"},\"glo\":{\"1600.01\":\"-1\",\"3750.01\":\"-1\",\"5000.01\":\"-1\",\"6000.01\":\"-1\",\"8000.01\":\"-1\",\"12000.01\":\"-1\",\"16000.01\":\"-1\",\"30000.01\":\"-1\",\"45000.01\":\"-1\"},\"9mobile\":{\"250\":\"-1\",\"500\":\"-1\",\"500.01\":\"-1\",\"1000\":\"-1\",\"1000.01\":\"-1\",\"2000\":\"-1\",\"1500.01\":\"-1\",\"2500.01\":\"-1\",\"3000\":\"-1\",\"3500.01\":\"-1\",\"4000\":\"-1\",\"5000\":\"-1\",\"5000.01\":\"-1\",\"6000\":\"-1\",\"7000\":\"-1\",\"8000\":\"-1\",\"9000\":\"-1\",\"10000\":\"-1\",\"11500.01\":\"-1\",\"15000.01\":\"-1\",\"27000.01\":\"-1\"},\"airtel\":{\"1500.01\":\"-1\",\"3500.01\":\"-1\",\"7000.01\":\"-1\",\"10000.01\":\"-1\",\"16000.01\":\"-1\",\"22000.01\":\"-1\"}},\"bill\":{\"dstv\":{\"01\":\"0\",\"02\":\"0\",\"03\":\"0\",\"04\":\"0\",\"05\":\"0\",\"06\":\"0\"},\"gotv\":{\"02\":\"0\",\"03\":\"0\"},\"startimes\":{\"01\":\"0\",\"02\":\"0\",\"03\":\"0\",\"04\":\"0\",\"05\":\"0\"}}}', 1, 1512254361),
(2, 4, 'DATA PLAN SUBSCRIPTION', '{\"airtime\":{\"mtn\":\"2%\",\"9mobile\":\"4%\",\"airtel\":\"3%\",\"glo\":\"4%\"},\"dataplan\":{\"mtn\":{\"500\":\"350\",\"1000\":\"600\",\"1500.01\":\"1000\",\"2000\":\"1200\",\"3500.01\":\"2000\",\"5000\":\"3000\",\"10000.01\":\"5000\",\"22000.01\":\"10000\"},\"glo\":{\"1600.01\":\"1000\",\"3750.01\":\"2000\",\"5000.01\":\"2500\",\"6000.01\":\"3000\",\"8000.01\":\"4000\",\"12000.01\":\"5000\",\"16000.01\":\"8000\",\"30000.01\":\"14000\",\"45000.01\":\"16500\"},\"9mobile\":{\"250\":\"300\",\"500\":\"400\",\"500.01\":\"500\",\"1000\":\"700\",\"1000.01\":\"1000\",\"2000\":\"1500\",\"1500.01\":\"1200\",\"2500.01\":\"2000\",\"3000\":\"2000\",\"3500.01\":\"2500\",\"4000\":\"2700\",\"5000\":\"3500\",\"5000.01\":\"3500\",\"6000\":\"4000\",\"7000\":\"5000\",\"8000\":\"5500\",\"9000\":\"5900\",\"10000\":\"6700\",\"11500.01\":\"8000\",\"15000.01\":\"10000\",\"27000.01\":\"17500\"},\"airtel\":{\"1500.01\":\"1000\",\"3500.01\":\"2000\",\"7000.01\":\"3500\",\"10000.01\":\"4900\",\"16000.01\":\"7900\",\"22000.01\":\"10000\"}},\"bill\":{\"dstv\":{\"01\":\"2000\",\"02\":\"4000\",\"03\":\"6500\",\"04\":\"10000\",\"05\":\"14800\",\"06\":\"17000\"},\"gotv\":{\"02\":\"1300\",\"03\":\"1950\"},\"startimes\":{\"01\":\"1000\",\"02\":\"1400\",\"03\":\"2000\",\"04\":\"2700\",\"05\":\"3900\"}}}', 1, 1513421232),
(3, 5, 'Airtime, data and other subscriptions', '{\"airtime\":{\"mtn\":\"2%\",\"9mobile\":\"2%\",\"airtel\":\"2%\",\"glo\":\"2%\"},\"dataplan\":{\"mtn\":{\"500\":\"400\",\"1000\":\"650\",\"1500.01\":\"1100\",\"2000\":\"1300\",\"3500.01\":\"2100\",\"5000\":\"2850\",\"10000.01\":\"5000\",\"22000.01\":\"10000\"},\"glo\":{\"1600.01\":\"1100\",\"3750.01\":\"1850\",\"5000.01\":\"2250\",\"6000.01\":\"2700\",\"8000.01\":\"3600\",\"12000.01\":\"4500\",\"16000.01\":\"7200\",\"30000.01\":\"13500\",\"45000.01\":\"16200\"},\"9mobile\":{\"250\":\"350\",\"500\":\"450\",\"500.01\":\"500\",\"1000\":\"750\",\"1000.01\":\"950\",\"2000\":\"1300\",\"1500.01\":\"1140\",\"2500.01\":\"1900\",\"3000\":\"1950\",\"3500.01\":\"2375\",\"4000\":\"2600\",\"5000\":\"3250\",\"5000.01\":\"3325\",\"6000\":\"3900\",\"7000\":\"4550\",\"8000\":\"5200\",\"9000\":\"5850\",\"10000\":\"6500\",\"11500.01\":\"7600\",\"15000.01\":\"9500\",\"27000.01\":\"17100\"},\"airtel\":{\"1500.01\":\"1050\",\"3500.01\":\"2000\",\"7000.01\":\"3500\",\"10000.01\":\"5000\",\"16000.01\":\"8000\",\"22000.01\":\"10000\"}},\"bill\":{\"dstv\":{\"01\":\"1900\",\"02\":\"3800\",\"03\":\"6300\",\"04\":\"9900\",\"05\":\"14700\",\"06\":\"16900\"},\"gotv\":{\"02\":\"1250\",\"03\":\"1900\"},\"startimes\":{\"01\":\"900\",\"02\":\"1300\",\"03\":\"1900\",\"04\":\"2600\",\"05\":\"3800\"}}}', 1, 1515147761),
(4, 3, 'Airtime and Tv', '{\"airtime\":{\"mtn\":\"1%\",\"9mobile\":\"1%\",\"airtel\":\"1%\",\"glo\":\"1%\"},\"dataplan\":{\"mtn\":{\"500\":\"450\",\"1000\":\"700\",\"1500.01\":\"\",\"2000\":\"1280\",\"3500.01\":\"0\",\"5000\":\"3000\",\"10000.01\":\"0\",\"22000.01\":\"9800\"},\"glo\":{\"1600.01\":\"1000\",\"3750.01\":\"2000\",\"5000.01\":\"2400\",\"6000.01\":\"2850\",\"8000.01\":\"3750\",\"12000.01\":\"4700\",\"16000.01\":\"7500\",\"30000.01\":\"13900\",\"45000.01\":\"16700\"},\"9mobile\":{\"250\":\"350\",\"500\":\"450\",\"500.01\":\"550\",\"1000\":\"750\",\"1000.01\":\"1050\",\"2000\":\"1500\",\"1500.01\":\"1300\",\"2500.01\":\"2200\",\"3000\":\"2250\",\"3500.01\":\"2550\",\"4000\":\"2750\",\"5000\":\"3500\",\"5000.01\":\"3550\",\"6000\":\"4150\",\"7000\":\"4800\",\"8000\":\"5400\",\"9000\":\"6100\",\"10000\":\"6500\",\"11500.01\":\"8000\",\"15000.01\":\"9850\",\"27000.01\":\"18000\"},\"airtel\":{\"1500.01\":\"1050\",\"3500.01\":\"2100\",\"7000.01\":\"3600\",\"10000.01\":\"4950\",\"16000.01\":\"7900\",\"22000.01\":\"9900\"}},\"bill\":{\"dstv\":{\"01\":\"1950\",\"02\":\"3850\",\"03\":\"6380\",\"04\":\"10050\",\"05\":\"0\",\"06\":\"0\"},\"gotv\":{\"02\":\"1300\",\"03\":\"1950\"},\"startimes\":{\"01\":\"980\",\"02\":\"1350\",\"03\":\"1950\",\"04\":\"2650\",\"05\":\"3950\"}}}', 1, 1516016615),
(5, 7, 'All Rate', '{\"airtime\":{\"mtn\":\"3%\",\"9mobile\":\"3%\",\"airtel\":\"3%\",\"glo\":\"3%\"},\"dataplan\":{\"mtn\":{\"500\":\"350\",\"1000\":\"600\",\"1500.01\":\"0\",\"2000\":\"0\",\"3500.01\":\"0\",\"5000\":\"0\",\"10000.01\":\"0\",\"22000.01\":\"0\"},\"glo\":{\"1600.01\":\"0\",\"3750.01\":\"0\",\"5000.01\":\"0\",\"6000.01\":\"0\",\"8000.01\":\"0\",\"12000.01\":\"0\",\"16000.01\":\"0\",\"30000.01\":\"0\",\"45000.01\":\"0\"},\"9mobile\":{\"250\":\"0\",\"500\":\"0\",\"500.01\":\"0\",\"1000\":\"0\",\"1000.01\":\"0\",\"2000\":\"0\",\"1500.01\":\"1140\",\"2500.01\":\"1900\",\"3000\":\"1950\",\"3500.01\":\"2375\",\"4000\":\"2600\",\"5000\":\"3250\",\"5000.01\":\"3325\",\"6000\":\"3900\",\"7000\":\"4550\",\"8000\":\"5200\",\"9000\":\"5850\",\"10000\":\"6500\",\"11500.01\":\"7600\",\"15000.01\":\"9500\",\"27000.01\":\"17100\"},\"airtel\":{\"1500.01\":\"950\",\"3500.01\":\"1900\",\"7000.01\":\"3325\",\"10000.01\":\"4750\",\"16000.01\":\"7600\",\"22000.01\":\"9500\"}},\"bill\":{\"dstv\":{\"01\":\"1900\",\"02\":\"3800\",\"03\":\"6300\",\"04\":\"9900\",\"05\":\"14700\",\"06\":\"16900\"},\"gotv\":{\"02\":\"1250\",\"03\":\"1900\"},\"startimes\":{\"01\":\"900\",\"02\":\"1300\",\"03\":\"1900\",\"04\":\"2600\",\"05\":\"3800\"}}}', 1, 1517050148),
(6, 8, 'All rate', '{\"airtime\":{\"mtn\":\"0%\",\"9mobile\":\"0%\",\"airtel\":\"0%\",\"glo\":\"0%\"},\"dataplan\":{\"mtn\":{\"500\":\"350\",\"1000\":\"600\",\"1500.01\":\"\",\"2000\":\"1150\",\"3500.01\":\"1950\",\"5000\":\"2800\",\"10000.01\":\"4800\",\"22000.01\":\"9550\"},\"glo\":{\"1600.01\":\"980\",\"3750.01\":\"1880\",\"5000.01\":\"2280\",\"6000.01\":\"2730\",\"8000.01\":\"3630\",\"12000.01\":\"4530\",\"16000.01\":\"7200\",\"30000.01\":\"13500\",\"45000.01\":\"16200\"},\"9mobile\":{\"250\":\"250\",\"500\":\"380\",\"500.01\":\"475\",\"1000\":\"680\",\"1000.01\":\"970\",\"2000\":\"1350\",\"1500.01\":\"1160\",\"2500.01\":\"1920\",\"3000\":\"1970\",\"3500.01\":\"2400\",\"4000\":\"2650\",\"5000\":\"3270\",\"5000.01\":\"3350\",\"6000\":\"3920\",\"7000\":\"4570\",\"8000\":\"5230\",\"9000\":\"5870\",\"10000\":\"6570\",\"11500.01\":\"7620\",\"15000.01\":\"9570\",\"27000.01\":\"17100\"},\"airtel\":{\"1500.01\":\"970\",\"3500.01\":\"1950\",\"7000.01\":\"3350\",\"10000.01\":\"4770\",\"16000.01\":\"7650\",\"22000.01\":\"9550\"}},\"bill\":{\"dstv\":{\"01\":\"1980\",\"02\":\"3880\",\"03\":\"6380\",\"04\":\"9980\",\"05\":\"14780\",\"06\":\"16980\"},\"gotv\":{\"02\":\"1300\",\"03\":\"1980\"},\"startimes\":{\"01\":\"980\",\"02\":\"1380\",\"03\":\"1980\",\"04\":\"2680\",\"05\":\"3880\"}}}', 1, 1517058878),
(7, 10, 'All Rate', '{\"airtime\":{\"mtn\":\"3%\",\"9mobile\":\"3%\",\"airtel\":\"3%\",\"glo\":\"3%\"},\"dataplan\":{\"mtn\":{\"500\":\"300\",\"1000\":\"550\",\"1500.01\":\"950\",\"2000\":\"1100\",\"3500.01\":\"1900\",\"5000\":\"2750\",\"10000.01\":\"4750\",\"22000.01\":\"9500\"},\"glo\":{\"1600.01\":\"950\",\"3750.01\":\"1850\",\"5000.01\":\"2250\",\"6000.01\":\"2700\",\"8000.01\":\"3600\",\"12000.01\":\"4500\",\"16000.01\":\"7200\",\"30000.01\":\"13500\",\"45000.01\":\"16200\"},\"9mobile\":{\"250\":\"250\",\"500\":\"350\",\"500.01\":\"475\",\"1000\":\"650\",\"1000.01\":\"950\",\"2000\":\"1300\",\"1500.01\":\"1140\",\"2500.01\":\"1900\",\"3000\":\"1950\",\"3500.01\":\"2375\",\"4000\":\"2600\",\"5000\":\"3250\",\"5000.01\":\"3325\",\"6000\":\"3900\",\"7000\":\"4550\",\"8000\":\"5200\",\"9000\":\"5850\",\"10000\":\"6500\",\"11500.01\":\"7600\",\"15000.01\":\"9500\",\"27000.01\":\"17100\"},\"airtel\":{\"1500.01\":\"950\",\"3500.01\":\"1900\",\"7000.01\":\"3325\",\"10000.01\":\"4750\",\"16000.01\":\"7600\",\"22000.01\":\"9500\"}},\"bill\":{\"dstv\":{\"01\":\"1900\",\"02\":\"3800\",\"03\":\"6300\",\"04\":\"9900\",\"05\":\"14700\",\"06\":\"16900\"},\"gotv\":{\"02\":\"1250\",\"03\":\"1900\"},\"startimes\":{\"01\":\"900\",\"02\":\"1300\",\"03\":\"1900\",\"04\":\"2600\",\"05\":\"3800\"}}}', 1, 1517075839),
(8, 11, 'All Rate', '{\"airtime\":{\"mtn\":\"3%\",\"9mobile\":\"4%\",\"airtel\":\"4%\",\"glo\":\"5%\"},\"dataplan\":{\"mtn\":{\"500\":\"300\",\"1000\":\"550\",\"1500.01\":\"950\",\"2000\":\"1100\",\"3500.01\":\"1900\",\"5000\":\"2750\",\"10000.01\":\"4750\",\"22000.01\":\"9500\"},\"glo\":{\"1600.01\":\"950\",\"3750.01\":\"1850\",\"5000.01\":\"2250\",\"6000.01\":\"2700\",\"8000.01\":\"3600\",\"12000.01\":\"4500\",\"16000.01\":\"7200\",\"30000.01\":\"13500\",\"45000.01\":\"16200\"},\"9mobile\":{\"250\":\"250\",\"500\":\"350\",\"500.01\":\"475\",\"1000\":\"650\",\"1000.01\":\"950\",\"2000\":\"1300\",\"1500.01\":\"1140\",\"2500.01\":\"1900\",\"3000\":\"1950\",\"3500.01\":\"2375\",\"4000\":\"2600\",\"5000\":\"3250\",\"5000.01\":\"3325\",\"6000\":\"3900\",\"7000\":\"4550\",\"8000\":\"5200\",\"9000\":\"5850\",\"10000\":\"6500\",\"11500.01\":\"7600\",\"15000.01\":\"9500\",\"27000.01\":\"17100\"},\"airtel\":{\"1500.01\":\"950\",\"3500.01\":\"1900\",\"7000.01\":\"3325\",\"10000.01\":\"4750\",\"16000.01\":\"7600\",\"22000.01\":\"9500\"}},\"bill\":{\"dstv\":{\"01\":\"1900\",\"02\":\"3800\",\"03\":\"6300\",\"04\":\"9900\",\"05\":\"14700\",\"06\":\"16900\"},\"gotv\":{\"02\":\"1250\",\"03\":\"1900\"},\"startimes\":{\"01\":\"900\",\"02\":\"1300\",\"03\":\"1900\",\"04\":\"2600\",\"05\":\"3800\"}}}', 1, 1517431228),
(10, 1, 'ClubKonnect Cost', '{\"airtime\":{\"mtn\":\"2%\",\"9mobile\":\"5%\",\"airtel\":\"2%\",\"glo\":\"5%\"},\"dataplan\":{\"mtn\":{\"500\":\"300\",\"1000\":\"550\",\"1500.01\":\"950\",\"2000\":\"1100\",\"3500.01\":\"1900\",\"5000\":\"2750\",\"10000.01\":\"4750\",\"22000.01\":\"9500\"},\"glo\":{\"1600.01\":\"950\",\"3750.01\":\"1850\",\"5000.01\":\"2250\",\"6000.01\":\"2700\",\"8000.01\":\"3600\",\"12000.01\":\"4500\",\"16000.01\":\"7200\",\"30000.01\":\"13500\",\"45000.01\":\"16200\"},\"9mobile\":{\"250\":\"250\",\"500\":\"350\",\"500.01\":\"475\",\"1000\":\"650\",\"1000.01\":\"950\",\"2000\":\"1300\",\"1500.01\":\"1140\",\"2500.01\":\"1900\",\"3000\":\"1950\",\"3500.01\":\"2375\",\"4000\":\"2600\",\"5000\":\"3250\",\"5000.01\":\"3325\",\"6000\":\"3900\",\"7000\":\"4550\",\"8000\":\"5200\",\"9000\":\"5850\",\"10000\":\"6500\",\"11500.01\":\"7600\",\"15000.01\":\"9500\",\"27000.01\":\"17100\"},\"airtel\":{\"1500.01\":\"950\",\"3500.01\":\"1900\",\"7000.01\":\"3325\",\"10000.01\":\"4750\",\"16000.01\":\"7600\",\"22000.01\":\"9500\"}},\"bill\":{\"dstv\":{\"01\":\"1900\",\"02\":\"3800\",\"03\":\"6300\",\"04\":\"9900\",\"05\":\"14700\",\"06\":\"16900\"},\"gotv\":{\"02\":\"1250\",\"03\":\"1900\"},\"startimes\":{\"01\":\"900\",\"02\":\"1300\",\"03\":\"1900\",\"04\":\"2600\",\"05\":\"3800\"}}}', 1, 1517793468);

-- --------------------------------------------------------

--
-- Table structure for table `cryptocurrency`
--

CREATE TABLE `cryptocurrency` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '',
  `transaction_hash` varchar(500) DEFAULT NULL,
  `price_in_usd` double NOT NULL DEFAULT '0',
  `price_in_btc` double NOT NULL DEFAULT '0',
  `current_balance_in_btc` double NOT NULL DEFAULT '0',
  `paid_in_btc` double NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_report`
--

CREATE TABLE `delivery_report` (
  `id` int(11) NOT NULL,
  `msg_id` varchar(100) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '0',
  `done_date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `document_id` int(11) NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `document_type` varchar(50) DEFAULT NULL,
  `document_type_id` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `ext` varchar(20) DEFAULT 'jpg'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `domain`
--

CREATE TABLE `domain` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `domain` varchar(100) NOT NULL DEFAULT '',
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `domain`
--

INSERT INTO `domain` (`id`, `owner`, `domain`, `date`) VALUES
(1, 1, 'mkalisms.com.ng', 0),
(2, 1, 'new.quicksms1.com', 0),
(3, 2, 'smswise.quicksms1.com', 1512352402),
(4, 3, 'smsakjolus.quicksms1.com', 1512566560),
(5, 4, 'linkingsms.com', 1512604421),
(6, 5, 'kandy.quickmx.com', 1514818827),
(7, 3, 'smsakjolus.com', 1515849104),
(8, 6, 'smsnow.quickmx.com', 1515853967),
(9, 7, 'demo.quickmx.com', 1517049724),
(10, 8, 'usssyy.quickmx.com', 1517049808),
(12, 10, 'rockbulksms.com', 1517075531),
(13, 11, 'ceesms.com.ng', 1517429936),
(14, 2, 'smswise.com', 1517565968),
(15, 12, 'akndako.quickmx.com', 1517590336),
(16, 13, 'hardware.quickmx.com', 1520851473),
(17, 4, 'data.linkingsms.com', 1546677001);

-- --------------------------------------------------------

--
-- Table structure for table `draft`
--

CREATE TABLE `draft` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `sender` varchar(15) NOT NULL DEFAULT '',
  `message` longtext NOT NULL,
  `recipient` longtext NOT NULL,
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `epins`
--

CREATE TABLE `epins` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `category` int(11) NOT NULL DEFAULT '0',
  `pin` varchar(50) NOT NULL,
  `serial` varchar(50) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `date_used` int(11) NOT NULL DEFAULT '0',
  `uploaded_by` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `bill_history_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `epins_category`
--

CREATE TABLE `epins_category` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(300) NOT NULL DEFAULT '',
  `parent_id` int(11) DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT '0.00',
  `cost_price` decimal(8,2) DEFAULT '0.00',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `epins_category`
--

INSERT INTO `epins_category` (`id`, `owner`, `name`, `description`, `parent_id`, `amount`, `cost_price`, `active`, `date`) VALUES
(1, 11, 'Waec result cards', '', 0, 0.00, 0.00, 1, 1543495415),
(2, 11, 'Neco result cards', '', 0, 0.00, 0.00, 1, 1543495436);

-- --------------------------------------------------------

--
-- Table structure for table `gateway`
--

CREATE TABLE `gateway` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `send_api` varchar(500) NOT NULL DEFAULT '',
  `success_word` varchar(50) NOT NULL DEFAULT '',
  `balance_api` varchar(500) NOT NULL DEFAULT '',
  `method` varchar(10) NOT NULL DEFAULT 'GET',
  `unicode_api` varchar(500) NOT NULL DEFAULT '',
  `flash_api` varchar(500) NOT NULL DEFAULT '',
  `delivery_api` varchar(500) NOT NULL DEFAULT '',
  `batch` int(11) NOT NULL DEFAULT '0',
  `rate` varchar(500) DEFAULT NULL,
  `route` varchar(800) NOT NULL DEFAULT '',
  `tag` varchar(20) NOT NULL DEFAULT '',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gateway`
--

INSERT INTO `gateway` (`id`, `owner`, `name`, `send_api`, `success_word`, `balance_api`, `method`, `unicode_api`, `flash_api`, `delivery_api`, `batch`, `rate`, `route`, `tag`, `active`, `date`) VALUES
(1, 1, 'Route SMS (Direct)', 'http://ngn.rmlconnect.net/bulksms/bulksms?username=mzndakong&password=L5kkGq31&type=0&dlr=1&destination=@@recipient@@&source=@@sender@@&message=@@message@@', '1701', 'https://ngn.rmlconnect.net/CreditCheck/checkcredits?username=mzndakong&password=L5kkGq31', 'GET', '', 'http://ngn.rmlconnect.net/bulksms/bulksms?username=mzndakong&password=L5kkGq31&type=1&dlr=1&destination=@@recipient@@&source=@@sender@@&message=@@message@@', '', 0, '', '', 'routesms', 1, 1512253367),
(2, 1, 'Route SMS (DND)', 'http://smsplus4.routesms.com/bulksms/bulksms?username=MzndakoBR&password=nmk9fdc7&type=0&dlr=1&destination=@@recipient@@&source=@@sender@@&message=@@message@@', '1701', '', 'GET', '', 'http://smsplus4.routesms.com/bulksms/bulksms?username=MzndakoBR&password=nmk9fdc7&type=1&dlr=1&destination=@@recipient@@&source=@@sender@@&message=@@message@@', '', 0, '', '', 'routesms', 1, 1512253878),
(5, 11, 'peaksms', 'Normal Route  http://www.peaksms.org/com_sms/smsapi.php?username=cyberwisdom&password=noblewisdom&sender=@@sender@@&recipient=@@recipient@@&message=@@message@@& ', 'Success', 'http://www.peaksms.org/com_sms/smsapi.php?username=cyberwisdom&password=noblewisdom&balance=true& ', 'POST', '', '', '', 0, '', '', '', 1, 1518001994),
(6, 11, 'peaksms2', 'http://www.peaksms.org/com_sms/smsapi.php?username=examfinest&password=noblewisdom&sender=@@sender@@&recipient=@@recipient@@&message=@@message@@& ', 'OK', 'http://www.peaksms.org/com_sms/smsapi.php?username=examfinest&password=noblewisdom&balance=true& ', 'GET', '', '', '', 0, '', '', '', 1, 1518002150),
(8, 11, 'Wisdom', 'http://www.quicksms1.com/api/sendsms.php?username=cyberwisdom&password=ceesms &sender=quicsms1&message=testing&recipient=2348030000000,23480xxxxxxxx&report=1&convert=1&route=1', 'OK', 'http://www.quicksms1.com/api/sendsms.php?username=user&password=1234&balance=1', 'GET', '', '', 'http://www.quicksms1.com/api/getdelivery.php?username=cyberwisdom&password=ceesms&msgid=4564', 0, '1.00', '', '', 1, 1522133824),
(9, 1, 'Route SMS International', 'http://rslr.connectbind.com:8080/bulksms/bulksms?username=qss-mzndako&password=mzee7015&destination=@@recipient@@&source=@@sender@@&message=@@message@@&dlr=1&type=0', '1701', '', 'GET', '', 'http://rslr.connectbind.com:8080/bulksms/bulksms?username=qss-mzndako&password=mzee7015&destination=@@recipient@@&source=@@sender@@&message=@@message@@&dlr=1&type=1', '', 0, '29', '93,213,244,374,61,43,994,973,880,375,32,501,229,387,267,673,359,226,257,855,237,235,385,357,420,45,20,372,358,879,241,220,995,49,233,30,852,36,354,62,98,964,353,972,39,962,254,965,961,231,218,423,370,352,389,261,265,60,960,223,356,596,222,230,373,377,976,212,258,264,977,31,599,64,505,227,47,968,92,680,507,63,48,351,974,262,40,250,378,966,221,248,232,65,421,386,252,27,34,94,249,597,46,41,963,886,992,255,66,216,90,256,380,971,44,598,998,678,58,84,967,260,263,1246,371,1242,1441,7,268,1664,91', 'routesms', 1, 1522321074),
(10, 3, 'CampusGuide DND SMS', 'http://www.campusguidesms.com.ng/components/com_spc/smsapi.php?username=akjolus&password=bishop&sender=@@sender@@&recipient=@@recipient@@&message=@@message@@', 'OK', '', 'GET', '', '', '', 0, '234803=3.2\n234805=3.2\n234802=3.2\n234807=3.5\n234809=3.5\n234816=3.5\n23481=4.5\n234702=4.5\n234703=4.5\n234705=3.5\n234706=4.5\n23490=3.5\n234=3.2', '', '', 1, 1523000463),
(11, 3, 'CampusGuide SMS', 'http://www.campusguidesms.com.ng/components/com_spc/smsapi.php?username=akjolus1&password=bishop&sender=@@sender@@&recipient=@@recipient@@&message=@@message@@', 'OK', 'http://campusguidesms.com.ng/components/com_spc/smsapi.php?username=akjolus1&password=bishop&balance=true&', 'GET', '', '', '', 0, '234803=2.8\n234805=2.8\n234802=2.8\n234807=3.5\n234809=3.5\n234816=3.5\n23481=3.5\n234702=3.5\n234703=3.5\n234705=3.5\n234706=3.5\n23490=3.5\n234=2.8', '', '', 1, 1523042488),
(13, 3, 'Smartsmssolutions', 'http://api.smartsmssolutions.com/smsapi.php?username=akjolus&password=bishop&sender=@@sender@@&recipient=@@recipient@@&message=@@message@@', 'OK', 'http://api.smartsmssolutions.com/smsapi.php?username=akjolus&password=bishop&balance=true&', 'GET', '', '', '', 0, '234803=2.8\n234805=2.8\n234802=2.8\n234807=3.5\n234809=3.5\n234816=3.5\n23481=3.5\n234702=3.5\n234703=3.5\n234705=3.5\n234706=3.5\n23490=3.5\n234=2.8', '', '', 1, 1545398800),
(14, 3, 'Smartsmssolutions DND', 'https://smartsmssolutions.com/api/?username=akjolus&password=bishop&sender=@@sender@@&recipient=@@recipient@@&message=@@message@@&type=0&routing=3&token=5SfG5V1PxfNl1dwFqkgRqJB6YBFooStpyRlk4U0gT4FKmlobhxVEVkHhpTXucmdbMxzUB8N0VH7wQ5ZyKJXArTrRKzFM44s0hx83', '1000', 'https://smartsmssolutions.com/api/?checkbalance=1&token=@@token@@&', 'POST', '', '', '', 0, '234=5', '3', '', 1, 1546952564),
(15, 2, 'Kaduna', 'https://smartsmssolutions.com/api/?sender=@@sender@@&to=@@recipient@@&message=@@message@@&type=0&routing=3&token={sEu4CnhUTzYUHMfKfMPlSwAwFoQBDeY3HRWZZw3nGrrpDNlvTbbeQAnrjJeycmEu0Kt8BKMfn5HiYGjnTvy7W5q5iw0XZ6kzWq47}', '1000', 'https://smartsmssolutions.com/api/?checkbalance=1&token={sEu4CnhUTzYUHMfKfMPlSwAwFoQBDeY3HRWZZw3nGrrpDNlvTbbeQAnrjJeycmEu0Kt8BKMfn5HiYGjnTvy7W5q5iw0XZ6kzWq47}', 'GET', '', '', '', 0, '', '', '', 1, 1547158127);

-- --------------------------------------------------------

--
-- Table structure for table `income_expense`
--

CREATE TABLE `income_expense` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `category_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `name` varchar(50) NOT NULL DEFAULT '',
  `date` int(11) NOT NULL,
  `updated_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `income_expense`
--

INSERT INTO `income_expense` (`id`, `owner`, `type`, `category_id`, `amount`, `name`, `date`, `updated_time`) VALUES
(1, 1, 2, 2, 7400.00, 'Route Payment', 1521910980, 1521911639),
(2, 1, 2, 2, 10000.00, 'Route SMS', 1522018980, 1522073345),
(3, 1, 2, 2, 5700.00, 'Route SMS', 1522072980, 1522073381),
(4, 1, 2, 2, 5500.00, 'Route SMS', 1522148580, 1522150942),
(5, 1, 2, 2, 11000.00, 'OD clearance', 1522321380, 1522410993),
(6, 1, 2, 2, 20000.00, 'New Payment', 1522346580, 1522410975),
(7, 1, 2, 2, 15000.00, 'New Payment', 1522749840, 1522751589),
(8, 1, 2, 2, 13000.00, 'New Payment', 1522926240, 1523099689),
(9, 1, 2, 2, 8000.00, 'New Payment', 1523142240, 1523143291),
(10, 1, 2, 2, 7000.00, 'Clear OD mzndakong', 1523426640, 1523426780),
(11, 1, 2, 2, 4900.00, 'Clear OD mzndakong', 1523426640, 1523426809),
(12, 1, 2, 2, 5500.00, 'Clearing OD', 1523534640, 1523942222),
(13, 1, 2, 2, 17000.00, 'Clearing All OD', 1523613840, 1523942282),
(14, 1, 2, 3, 4000.00, 'Airtime for mtn databundle', 1523606640, 1523942388),
(15, 1, 2, 3, 4000.00, 'Airtime for mtn data share n sell', 1523613840, 1523942510),
(16, 1, 2, 2, 15000.00, 'Clearing all OD', 1523941320, 1523942562),
(17, 1, 2, 2, 15000.00, 'Clear all OD', 1524549840, 1524556765),
(18, 1, 2, 2, 15000.00, 'Clear all OD', 1525082700, 1525169967);

-- --------------------------------------------------------

--
-- Table structure for table `income_expense_categories`
--

CREATE TABLE `income_expense_categories` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `updated_time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `income_expense_categories`
--

INSERT INTO `income_expense_categories` (`id`, `owner`, `name`, `description`, `type`, `updated_time`) VALUES
(1, 1, 'Salary', 'Monthly Stipends', 2, 1521801060),
(2, 1, 'Route SMS', 'Bulk SMS Payment', 2, 1521801093),
(3, 1, 'Topup Africa', 'Airtime purchase', 2, 1523942331);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE `menu_item` (
  `id` int(11) NOT NULL,
  `title` varchar(75) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `position` int(11) DEFAULT NULL,
  `access` varchar(200) NOT NULL DEFAULT '',
  `link` varchar(100) DEFAULT '',
  `fa-icon` varchar(50) DEFAULT '',
  `is_menu` tinyint(4) NOT NULL DEFAULT '1',
  `for_members` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `title` varchar(50) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `location` varchar(200) NOT NULL DEFAULT '',
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `store` tinyint(4) NOT NULL DEFAULT '1',
  `new_user_can_see` tinyint(4) NOT NULL DEFAULT '1',
  `show_once` tinyint(4) NOT NULL DEFAULT '1',
  `disappear_on_read` tinyint(4) NOT NULL DEFAULT '1',
  `date` int(11) NOT NULL DEFAULT '0',
  `expires` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification_read`
--

CREATE TABLE `notification_read` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `view_date` int(11) NOT NULL DEFAULT '0',
  `read_date` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `disabled` tinyint(4) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phonebook`
--

CREATE TABLE `phonebook` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `numbers` text NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `rate` varchar(800) NOT NULL DEFAULT '',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`id`, `owner`, `name`, `rate`, `active`, `date`) VALUES
(1, 1, 'All Users (Direct)', '234=2\n10', 1, 1512253936),
(2, 1, 'All Users (DND)', '234=3.2', 1, 1512254007),
(3, 1, 'Resellers', '234=1.6\n2347025=1.8\n2347026=1.8\n2347028=1.8\n2347029=1.8\n2347029=1.8\n234704=1.8\n234819=1.8\n234707=1.8\n234709=1.8', 0, 1512254101),
(4, 2, 'Basic plan (sms below 5000unit)', '234=2.80\n', 1, 1512518257),
(5, 4, 'All fees', '234=1.6', 1, 1512605534),
(6, 3, 'All network', '234803=3.5\n234805=3.5\n234802=3.5\n234807=3.5\n234809=3.5\n234816=3.5\n23481=4.5\n234702=4.5\n234703=4.5\n234705=3.5\n234706=4.5\n23490=3.5\n234=3.3', 1, 1512660978),
(7, 3, 'DND', '234803=3.5\n234805=3.5\n234802=3.5\n234807=3.5\n234809=3.5\n234816=3.5\n23481=4.5\n234702=4.5\n234703=4.5\n234705=3.5\n234706=4.5\n23490=3.5\n234=3.3', 1, 1512661278),
(11, 4, 'DND', '234=3.20', 1, 1513370428),
(13, 5, 'my price', '234=1.9', 1, 1515003222),
(9, 1, 'Biggest Reseller', '234=1.85\n2347025=2\n2347026=2\n2347028=2\n2347029=2\n2347029=2\n234704=2\n234819=2\n234707=2\n234709=2', 1, 1513188363),
(14, 5, 'my price dnd', '234=3.5', 1, 1515003256),
(15, 2, 'Standard plan (sms unit between 5000 - 10000)', ' 10000=1.95', 0, 1516917002),
(16, 7, 'Direct Rate', '234=1.80', 1, 1517050051),
(17, 7, 'DND Rate', '234=3.2', 1, 1517050074),
(18, 8, 'Direct Rate', '234=1.9', 1, 1517052013),
(19, 8, 'DND Rate', '234=3.5', 1, 1517052037),
(20, 10, 'Direct Route', '234=2.0', 1, 1517075797),
(21, 10, 'DND Rate', '234=4', 1, 1517075811),
(22, 11, 'Direct Rate', '234=1.00', 1, 1517431179),
(23, 11, 'DND rate', '234=3.2', 1, 1517431196),
(24, 2, 'DND', '234=5.2', 1, 1517593064),
(25, 1, 'Route SMS', '234=1.80', 1, 1517793396),
(26, 1, 'Route SMS DND', '234=2.8', 1, 1517793413),
(27, 6, 'Central', '234=1.95', 1, 1519367561),
(28, 6, 'All DND', '234=3.0', 1, 1519384495),
(29, 1, 'Route SMS International Gateway', '93=29.2\n213=30.845\n244=13.22\n374=30.61\n61=12.421\n43=19.8\n994=38.365\n973=4.525\n880=27.085\n375=5.277\n32=32.96\n501=7.11\n229=17.685\n387=16.51\n267=9.131\n673=6.17\n359=18.39\n226=17.356\n257=17.92\n855=46.073\n237=8.285\n235=22.432\n385=32.96\n357=6.17\n420=15.1\n45=12.75\n20=8.99\n372=34.37\n358=19.565\n879=18.86\n241=22.432\n220=7.345\n995=5.7\n49=7.956\n233=18.155\n30=15.476\n852=30.469\n36=23.795\n354=9.695\n62=9.93\n98=16.275\n964=23.56\n353=18.155\n972=7.345\n39=17.92\n962=36.485\n254=22.432\n965=14.16\n961=7.439\n231=18.86\n218=12.75\n423=8.99\n370=7.016\n352=4.76\n389=9.46\n261=22.667\n265=22.432\n60=5.23\n960=7.815\n223=31.08\n356=11.81\n596=3.585\n222=14.395\n230=41.326\n373=4.525\n377=24.03\n976=23.325\n212=27.79\n258=15.1\n264=16.51\n977=26.38\n31=32.02\n599=20.27\n64=29.67\n505=11.81\n227=22.244\n47=19.565\n968=44.569\n92=12.75\n680=7.11\n507=19.', 1, 1522430786);

-- --------------------------------------------------------

--
-- Table structure for table `read_notification`
--

CREATE TABLE `read_notification` (
  `id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `recipient`
--

CREATE TABLE `recipient` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `sent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `msg_id` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(4) DEFAULT '0',
  `cost` decimal(10,2) DEFAULT NULL,
  `route` tinyint(4) NOT NULL DEFAULT '0',
  `gid` varchar(20) NOT NULL DEFAULT '',
  `operatorid` int(11) NOT NULL,
  `donedate` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reseller`
--

CREATE TABLE `reseller` (
  `owner` int(11) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `access` varchar(500) NOT NULL DEFAULT '',
  `disabled` tinyint(4) DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reseller`
--

INSERT INTO `reseller` (`owner`, `parent`, `user_id`, `access`, `disabled`, `date`) VALUES
(1, 0, 1, '', 0, 0),
(2, 1, 6090, '', 0, 1512352378),
(3, 1, 435, '', 0, 1512566535),
(4, 1, 8004, '', 0, 1512604166),
(5, 1, 4307, '', 0, 1514818811),
(6, 1, 2133, '', 0, 1515853952),
(7, 1, 5559, '', 0, 1517049706),
(8, 1, 8297, '', 0, 1517049782),
(10, 1, 7662, '', 0, 1517075514),
(11, 1, 1755, '', 0, 1517429902),
(12, 1, 5636, '', 0, 1517503837),
(13, 1, 3429, '', 0, 1520851062),
(14, 11, 9249, '', 0, 1525902884),
(15, 2, 12039, '', 0, 1548019482),
(16, 3, 12462, '', 1, 1558604059),
(17, 3, 12737, '', 1, 1559038389);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `name` varchar(75) DEFAULT NULL,
  `access` varchar(800) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `owner`, `name`, `access`) VALUES
(1, 4, 'Superadmin', 'send_bulk_sms,send_free_sms,message_history,delete_message_history,draft,schedule,manage_phonebook,buy_airtime,buy_epins,buy_dataplan,dstv_bill,gotv_bill,startimes_bill,fund_wallet,transfer_fund,transfer_to_bank,view_user,credit_user,manage_admin_credit,debit_user,allow_on_credit,change_staff_privilege,change_user_price,change_user_gateway,delete_user,message_user,sms_user,manage_sender_id,manage_vip,payment_history,manage_notifications,manage_alerts,manage_role,general_setting,manage_gateway,payment_gateway,manage_rate,manage_reseller,manage_theme,manage_page,view_bill_history,update_profile'),
(2, 1, 'Creditors', 'send_bulk_sms,message_history,draft,schedule,manage_phonebook,buy_airtime,buy_dataplan,dstv_bill,gotv_bill,startimes_bill,fund_wallet,transfer_fund,transfer_to_bank,view_user,credit_user,debit_user,payment_history,manage_notifications,view_bill_history,update_profile'),
(3, 1, 'Reseller Manager', 'change_user_price,change_user_gateway,message_user,sms_user,manage_reseller,manage_theme,manage_page'),
(4, 11, 'Cyberwisdom', 'send_bulk_sms,send_free_sms,message_history,delete_message_history,draft,schedule,manage_phonebook,buy_airtime,buy_dataplan,dstv_bill,gotv_bill,startimes_bill,fund_wallet,transfer_fund,transfer_to_bank,view_user,credit_user,debit_user,change_staff_privilege,change_user_price,change_user_gateway,delete_user,message_user,sms_user,manage_sender_id,payment_history,manage_notification,manage_role,general_setting,manage_gateway,payment_gateway,manage_rate,manage_reseller,manage_theme,manage_page,view_bill_history'),
(5, 1, 'DJ Dakman', 'send_bulk_sms,send_free_sms,message_history,draft,schedule,manage_phonebook,buy_airtime,buy_dataplan,fund_wallet,transfer_fund,transfer_to_bank,view_user,credit_user,debit_user,sms_user,manage_sender_id,manage_notifications,general_setting,manage_gateway,manage_rate,manage_reseller,manage_theme,manage_page,view_bill_history,update_profile'),
(6, 2, 'Staff', 'send_bulk_sms,send_free_sms,message_history,delete_message_history,draft,schedule,manage_phonebook,fund_wallet,transfer_fund,debit_user,delete_user,sms_user,payment_gateway,manage_rate,update_profile'),
(7, 3, 'akinola', 'view_user'),
(8, 3, 'adebiyimide', 'send_bulk_sms,message_history,draft,schedule,manage_phonebook,transfer_fund,view_user,debit_user,sms_user,manage_notifications,manage_alerts,manage_theme,manage_page,update_profile');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL,
  `class` longblob,
  `options` longtext NOT NULL,
  `next_run` int(11) NOT NULL DEFAULT '0',
  `remark` varchar(200) NOT NULL DEFAULT '',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sent`
--

CREATE TABLE `sent` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `sender_id` varchar(15) NOT NULL,
  `sender_id_dnd` varchar(15) NOT NULL,
  `message` longtext NOT NULL,
  `date` int(11) NOT NULL DEFAULT '0',
  `method` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sent_mail`
--

CREATE TABLE `sent_mail` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `subject` varchar(500) NOT NULL DEFAULT '',
  `message` longtext NOT NULL,
  `recipient` varchar(300) NOT NULL,
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `owner` int(11) DEFAULT NULL,
  `type` longtext NOT NULL,
  `description` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`owner`, `type`, `description`) VALUES
(1, 'cname', 'Quick SMS'),
(1, 'caddress', ''),
(1, 'cemail', 'info@quicksms1.com'),
(1, 'cphone', '2349038781252'),
(1, 'website', 'quicksms1.com'),
(1, 'site_name', 'QUICK SMS'),
(1, 'currency', 'N'),
(1, 'currency_suffix', ''),
(1, 'is_mz', '1'),
(1, 'current_frontend_theme', 'corlate'),
(1, 'theme_corlate_site_name', 'QUICK SMS'),
(1, 'theme_corlate_phone', '090 387 81252'),
(1, 'theme_corlate_description1', ''),
(1, 'theme_corlate_site_address', ''),
(1, 'theme_corlate_welcome_title', 'QUICK SMS'),
(1, 'theme_corlate_welcome_content', '<p><span style=\"color: rgb(55, 62, 74); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 21px; letter-spacing: 0.1px;\">We Provide Corporate and Individual Short Messaging Services which enables our clients to send text messages to many phone numbers through our Gateway.</span><br></p><h3 style=\"padding: 0px; border: 0px; margin: 0px;\"><br>We also allow our client to buy airtime, dataplan and bill payment from their wallet.</h3>'),
(1, 'theme_corlate_logo', ''),
(1, 'skin_color', 'yellow'),
(1, 'default_gateway', '1'),
(1, 'default_dnd_gateway', '1'),
(1, 'default_rate', '1'),
(1, 'default_dnd_rate', '2'),
(1, 'default_bill_rate', '1'),
(1, 'member_permission', 'send_bulk_sms,message_history,draft,schedule,manage_phonebook,buy_airtime,buy_dataplan,fund_wallet,transfer_fund,transfer_to_bank,view_bill_history,update_profile'),
(1, 'theme_login_header_text_color', '#ffffff'),
(1, 'theme_login_bg_color1', '#000000'),
(1, 'theme_login_bg_color2', '#804040'),
(1, 'bill_gateway', '{\"airtime\":{\"mtn\":\"3\",\"9mobile\":\"3\",\"airtel\":\"3\",\"glo\":\"3\"},\"dataplan\":{\"mtn\":{\"500\":\"1\",\"1000\":\"1\",\"1500.01\":\"1\",\"2000\":\"1\",\"3500.01\":\"1\",\"5000\":\"1\",\"10000.01\":\"1\",\"22000.01\":\"1\"},\"glo\":{\"1600.01\":\"1\",\"3750.01\":\"1\",\"5000.01\":\"1\",\"6000.01\":\"1\",\"8000.01\":\"1\",\"12000.01\":\"1\",\"16000.01\":\"1\",\"30000.01\":\"1\",\"45000.01\":\"1\"},\"9mobile\":{\"250\":\"1\",\"500\":\"1\",\"500.01\":\"1\",\"1000\":\"1\",\"1000.01\":\"1\",\"2000\":\"1\",\"1500.01\":\"1\",\"2500.01\":\"1\",\"3000\":\"1\",\"3500.01\":\"1\",\"4000\":\"1\",\"5000\":\"1\",\"5000.01\":\"1\",\"6000\":\"1\",\"7000\":\"1\",\"8000\":\"1\",\"9000\":\"1\",\"10000\":\"1\",\"11500.01\":\"1\",\"15000.01\":\"1\",\"27000.01\":\"1\"},\"airtel\":{\"1500.01\":\"1\",\"3500.01\":\"1\",\"7000.01\":\"1\",\"10000.01\":\"1\",\"16000.01\":\"1\",\"22000.01\":\"1\"}},\"bill\":{\"dstv\":{\"01\":\"2\",\"02\":\"2\",\"03\":\"2\",\"04\":\"2\",\"05\":\"2\",\"06\":\"2\"},\"gotv\":{\"02\":\"2\",\"03\":\"2\"},\"startimes\":{\"01\":\"2\",\"02\":\"2\",\"03\":\"2\",\"04\":\"2\",\"05\":\"2\"}}}'),
(1, 'bill_gateway_1_email', 'Quicksmsone@gmail.com'),
(1, 'bill_gateway_2_client_id', 'CK10032610'),
(1, 'bill_gateway_2_apikey', '0F8MA31S4898J4N2KUNA0O82HP2DG1EM28SEM11Z541L0S56VYVF80OQ7HG724O1'),
(1, 'payment_method_status', '{\"atm\":0,\"bank\":0,\"bitcoin\":0,\"internet\":0,\"mobile\":0,\"airtime\":0,\"atm_reseller\":0}'),
(1, 'payment_gateway_settings_atm_paystack_secret_key', 'sk_live_3ef4288212f8defa4e692dd0aeb4b2a2dc8ff4da'),
(1, 'payment_gateway_settings_atm_paystack_public_key', 'pk_live_fa1975a687421fd87bdfa76b3a76c1c170735da5'),
(1, 'payment_gateway_settings_atm_paystack_transaction_fee', '1.5%,2500=100'),
(1, 'payment_gateway_settings_atm_paystack_enabled', ''),
(1, 'payment_gateway_settings_atm_voguepay_merchant_id', '12267-3709'),
(1, 'payment_gateway_settings_atm_voguepay_secret_key', ''),
(1, 'payment_gateway_settings_atm_voguepay_enabled', '1'),
(1, 'payment_gateway_settings_bitcoin_bitcoin_key', 'c1bdfd4a-4fe5-4acc-8c80-bc6f27986da4'),
(1, 'payment_gateway_settings_bitcoin_bitcoin_xpub', 'xpub6CJUfm8fAK58r6omVDGyHHuaXJfw4QZHi5AgDRb1Ry1JzamGG6KDD2hGHVRM2S7BAKW3wc26CEiuWHCNBZEb2mAyHaASu11FNVDEdFjKuN8'),
(1, 'payment_gateway_settings_bitcoin_bitcoin_conversion', '350'),
(1, 'payment_gateway_settings_bitcoin_bitcoin_confirmation', '3'),
(1, 'payment_gateway_settings_bank_accounts', 'GT BANK=0124001986=NDAKO MUHAMMAD Z.\nFIRST BANK (Corporate Account)=2030322404=QUICKTEL SOLUTION\nDIAMOND BANK=0009317777=NDAKO MUHAMMAD Z.\nDIAMOND BANK (Corporate Account)=0077014569=QUICKTEL SOLUTION'),
(1, 'payment_gateway_settings_internet_accounts', 'GT BANK=0124001986=NDAKO MUHAMMAD Z.\nFIRST BANK (Corporate Account)=2030322404=QUICKTEL SOLUTION\nDIAMOND BANK=0009317777=NDAKO MUHAMMAD Z.\nDIAMOND BANK (Corporate Account)=0077014569=QUICKTEL SOLUTION'),
(1, 'payment_gateway_settings_atm_voguepay_transaction_fee', '2.5%,2500=50'),
(1, 'payment_gateway_settings_mobile_accounts', 'GT BANK=0124001986=NDAKO MUHAMMAD Z.\nFIRST BANK (Corporate Account)=2030322404=QUICKTEL SOLUTION\nDIAMOND BANK=0009317777=NDAKO MUHAMMAD Z.\nDIAMOND BANK (Corporate Account)=0077014569=QUICKTEL SOLUTION'),
(1, 'frontend_menu', '[{\"item_id\":\"menu_menu_menu_menu_menu_43632592.697428174\",\"parent_id\":\"0\",\"label\":\"Home Page\",\"link\":\"home\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_36557777.97467774\",\"parent_id\":\"0\",\"label\":\"Bulk SMS\",\"link\":\"message\\/bulksms\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_58406123.56725645\",\"parent_id\":\"0\",\"label\":\"Airtime\\/Dataplan \\u02c7\",\"link\":\"#\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_23072439.62076443\",\"parent_id\":\"menu_menu_menu_menu_58406123.56725645\",\"label\":\"Buy Airtime\",\"link\":\"bill\\/buy_airtime\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_25110256.237952325\",\"parent_id\":\"0\",\"label\":\"Price List\",\"link\":\"price\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_42679379.826105565\",\"parent_id\":\"0\",\"label\":\"Services \\u02c7\",\"link\":\"#\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_43264154.75672077\",\"parent_id\":\"menu_menu_menu_menu_42679379.826105565\",\"label\":\"Download\",\"link\":\"page\\/2\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_50657286.75470426\",\"parent_id\":\"menu_menu_menu_menu_42679379.826105565\",\"label\":\"Reseller\",\"link\":\"page\\/4\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_59251902.03351475\",\"parent_id\":\"menu_menu_menu_menu_42679379.826105565\",\"label\":\"API\",\"link\":\"page\\/3\",\"show\":\"all\"},{\"item_id\":\"menu_75397645.13192345\",\"parent_id\":\"menu_menu_menu_menu_42679379.826105565\",\"label\":\"APPLICATION FOR CORPORATE ROUTE\",\"link\":\"page\\/20\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_67909204.8166079\",\"parent_id\":\"0\",\"label\":\"Dashboard\",\"link\":\"admin\",\"show\":\"login\"},{\"item_id\":\"menu_menu_menu_79928573.78829049\",\"parent_id\":\"0\",\"label\":\"Login\",\"link\":\"login\",\"show\":\"logout\"},{\"item_id\":\"menu_menu_menu_menu_menu_63982905.951358974\",\"parent_id\":\"0\",\"label\":\"Register\",\"link\":\"login\\/register\",\"show\":\"logout\"},{\"item_id\":\"menu_menu_menu_menu_menu_32791320.616783485\",\"parent_id\":\"0\",\"label\":\"Contact Us\",\"link\":\"contact\",\"show\":\"all\"}]'),
(1, 'theme_corlate_faq_content', '<h2 style=\"color: rgb(51, 51, 51); font-size: 26px; margin: 0px 0px 25px; padding: 5px 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">FAQs</h2><h3 style=\"color: rgb(51, 51, 51); font-weight: bold; font-size: 15px; margin: 30px 0px 5px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">How do I register?</h3><p style=\"margin-bottom: 10px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">Registration is free, to register, click on&nbsp;<a href=\"https://sms.quickhostme.com/index.php?do=signup\" style=\"color: rgb(8, 174, 227);\"><a href=\"http://quicksms1.com/login/register\">sign up&nbsp;</a></a>and complete the form. Upon successful registration, your login password would be sent to your mobile phone and/or email address.</p><h3 style=\"color: rgb(51, 51, 51); font-weight: bold; font-size: 15px; margin: 30px 0px 5px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">How do I send bulk sms online?<br></h3><p style=\"margin-bottom: 10px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">Your most be a registered member to send bulk sms. click&nbsp;<a href=\"http://quicksms1.com/login/register\" style=\"color: rgb(8, 174, 227);\">sign up</a>&nbsp;to do that. Login with your registered username and password sent to your mobile phone/email. You most change your password first before you can send sms. simply click on compose sms and type in your details, then click send</p><h3 style=\"color: rgb(51, 51, 51); font-weight: bold; font-size: 15px; margin: 30px 0px 5px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">How can I buy more sms?</h3><p style=\"margin-bottom: 10px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">You can buy sms Online using debit card, bank deposite, mtn recharge card or visiting our office (if you are close). For more details on how to buy more sms, click&nbsp;<a href=\"http://quicksms1.com/price\" style=\"color: rgb(8, 174, 227);\">here</a></p><h3 style=\"color: rgb(51, 51, 51); font-weight: bold; font-size: 15px; margin: 30px 0px 5px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">How do I know if online ordering is secure?</h3><p style=\"margin-bottom: 10px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">Protecting your information is a priority for Quick SMS. We use Secure Sockets Layer (SSL) to encrypt your credit card number, name and address so only Interswitch is able to decode your information. SSL is the industry standard method for computers to communicate securely without risk of data interception, manipulation or recipient impersonation. To be sure your connection is secure; when you are in the Payment Page, look at the lower corner of your browser window. If you see an unbroken key or closed lock, the SSL is active and your information is secure.</p><h3 style=\"color: rgb(51, 51, 51); font-weight: bold; font-size: 15px; margin: 30px 0px 5px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">How do i send message directly from my Mobile Phone?</h3><p style=\"margin-bottom: 10px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">Download our Mobile Application&nbsp;<a href=\"http://download\" style=\"color: rgb(8, 174, 227);\">here</a>&nbsp;(Java or Blackberry) and enjoy sending sms at ease, ability to import all contacts from phonebook and sim easily and many more.</p><p style=\"margin-bottom: 10px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\"><br></p><h3 style=\"color: rgb(51, 51, 51); font-weight: bold; font-size: 15px; margin: 30px 0px 5px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">What am looking for is not here?</h3><p style=\"margin-bottom: 10px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">Quick SMS provide highly efficient and friendly costumer service, which is available from Monday to Saturday, to answer to any complains, suggestion, opinions or worries. Click&nbsp;<a href=\"http://quicksms1.com/contact\" style=\"color: rgb(8, 174, 227);\">here</a>&nbsp;for details</p>'),
(1, 'theme_corlate_about_us_content', ''),
(1, 'theme_corlate_company_email', ''),
(1, 'theme_corlate_domain_name', ''),
(1, 'theme_corlate_facebook_link', 'https://facebook.com/quicksms1'),
(1, 'theme_corlate_twitter_link', ''),
(1, 'theme_corlate_linkedin_link', ''),
(1, 'theme_corlate_skype_link', 'quicksms_info'),
(1, 'theme_corlate_top_header1', '#303030'),
(1, 'theme_corlate_top_header2', '#000000'),
(1, 'theme_corlate_image1', ''),
(1, 'theme_corlate_slide1', '<h1 class=\"animation animated-item-1\">Welcome</h1>\r\n<h2 class=\"animation animated-item-2\">Send Bulk SMS at ease</h2>\r\n                                <a class=\"btn-slide animation animated-item-3\" href=\"#\" onclick=\'show_login()\'>Login</a>'),
(1, 'theme_corlate_image2', ''),
(1, 'theme_corlate_slide2', ''),
(1, 'theme_corlate_image3', ''),
(1, 'theme_corlate_slide3', ''),
(1, 'theme_corlate_footer', '	 <div class=\"col-md-3 col-sm-6\">\r\n                <div class=\"widget\">\r\n                    <h3>About US</h3>\r\n                    <ul>\r\n                        <li><a href=\"#\">About us</a></li>\r\n                        <li><a href=\"#\">Terms of use</a></li>\r\n                        <li><a href=\"#\">Privacy policy</a></li>\r\n                        <li><a href=\"#\">Contact us</a></li>\r\n                    </ul>\r\n                </div>\r\n            </div><!--/.col-md-3-->\r\n\r\n            <div class=\"col-md-3 col-sm-6\">\r\n                <div class=\"widget\">\r\n                    <h3>Support</h3>\r\n                    <ul>\r\n                        <li><a href=\"#\">Faq</a></li>\r\n                        <li><a href=\"#\">Documentation</a></li>\r\n                        <li><a href=\"#\">Refund policy</a></li>\r\n                    </ul>\r\n                </div>\r\n            </div><!--/.col-md-3-->\r\n\r\n            <div class=\"col-md-3 col-sm-6\">\r\n                <div class=\"widget\">\r\n                    <h3>Our Resources</h3>\r\n                    <ul>\r\n                        <li><a href=\"#\">Our FB</a></li>\r\n                        <li><a href=\"#\">On Youtube</a></li>\r\n                        <li><a href=\"#\">Our Blog</a></li>\r\n                    </ul>\r\n                </div>\r\n            </div><!--/.col-md-3-->\r\n\r\n            <div class=\"col-md-3 col-sm-6\">\r\n                <div class=\"widget\">\r\n                    <h3>Hot Links</h3>\r\n                    <ul>\r\n                        <li><a href=\"#\">Seller Page</a></li>\r\n                    </ul>\r\n                </div>\r\n            </div><!--/.col-md-3-->\r\n <script type=\"text/javascript\">\r\n        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n        (function(){\r\n            var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n            s1.async=true;\r\n            s1.src=\'https://embed.tawk.to/57ebbcec81b5df649ae7c22d/default\';\r\n            s1.charset=\'UTF-8\';\r\n            s1.setAttribute(\'crossorigin\',\'*\');\r\n            s0.parentNode.insertBefore(s1,s0);\r\n        })();\r\n    </script>'),
(1, 'theme_corlate_submit', '\r\n													   Save\r\n												'),
(1, 'payment_gateway_settings_bitcoin_bitcoin_my_secret_key', 'cngsfaKOjY'),
(1, 'payment_gateway_settings_airtime_accounts', 'GT BANK=0124001986=NDAKO MUHAMMAD Z.\nFIRST BANK (Corporate Account)=2030322404=QUICKTEL SOLUTION\nDIAMOND BANK=0009317777=NDAKO MUHAMMAD Z.\nDIAMOND BANK (Corporate Account)=0077014569=QUICKTEL SOLUTION'),
(1, 'payment_gateway_settings_bank_detail', 'PLEASE MAKE PAYMENT TO THE BANK ACCOUNT DETAILS BELOW.\nPlease note: Due to CBN stamp duty, Any payment made to our Corporate Account for N1,000 or above will attracts N50.<br>\nNo extra charges for paying into our saving account'),
(1, 'payment_gateway_settings_internet_detail', 'PLEASE TRANSFER THE AMOUNT ABOVE TO OUR BANK ACCOUNT<BR>\nPlease note: Due to CBN stamp duty, Any payment made to our Corporate Account for N1,000 or above will attracts N50.<br>\nNo extra charges for paying into our saving account'),
(1, 'payment_gateway_settings_mobile_detail', 'PLEASE TRANSFER THE AMOUNT ABOVE TO OUR BANK ACCOUNT<BR>\nPlease note: Due to CBN stamp duty, Any payment made to our Corporate Account for N1,000 or above will attracts N50.<br>\nNo extra charges for paying into our saving account'),
(1, 'payment_gateway_settings_airtime_network', 'MTN'),
(1, 'payment_gateway_settings_airtime_detail', 'We charge 20% when using this payment method<br>\nYour account will be credited between <b>1 - 2 <b style=\'color: red\'>working hours</b></b>'),
(1, 'payment_gateway_settings_airtime_transaction_fee', '20%'),
(1, 'payment_gateway_settings_airtime_email', 'quicksmsone@gmail.com'),
(2, 'cname', 'Lightway Technology'),
(2, 'caddress', ''),
(2, 'cemail', 'info@smswise.com'),
(2, 'cphone', '08136522878'),
(2, 'website', 'www.smswise.com'),
(2, 'site_name', 'BULKSMS'),
(2, 'currency', 'N'),
(2, 'currency_suffix', ''),
(2, 'default_rate', '4'),
(2, 'payment_method_status', '{\"atm\":0,\"bank\":1,\"bitcoin\":1,\"internet\":1,\"atm_reseller\":0,\"mobile\":1}'),
(2, 'payment_gateway_settings_atm_paystack_secret_key', ''),
(2, 'payment_gateway_settings_atm_paystack_public_key', ''),
(2, 'payment_gateway_settings_atm_paystack_transaction_fee', ''),
(2, 'payment_gateway_settings_atm_paystack_enabled', '1'),
(2, 'payment_gateway_settings_atm_voguepay_merchant_id', ''),
(2, 'payment_gateway_settings_atm_voguepay_transaction_fee', ''),
(2, 'payment_gateway_settings_atm_voguepay_enabled', '1'),
(2, 'payment_gateway_settings_bitcoin_bitcoin_key', '1HMdpCMGv6qdPv4JBn3MRRbCSVvR7z11Kf'),
(2, 'payment_gateway_settings_bitcoin_bitcoin_xpub', ''),
(2, 'payment_gateway_settings_bitcoin_bitcoin_conversion', '370'),
(2, 'payment_gateway_settings_bitcoin_bitcoin_confirmation', ''),
(2, 'payment_gateway_settings_bank_accounts', 'FirstBank=3091212716=Emmanuel Omale Raphael \nFCMB=4670368014=Lightway Technology '),
(2, 'payment_gateway_settings_internet_accounts', 'FirstBank=3091212716=Emmanuel Omale Raphael \nFCMB=4670368014=Lightway Technology '),
(2, 'payment_gateway_settings_mobile_accounts', 'FirstBank=3091212716=Emmanuel Omale Raphael \nFCMB=4670368014=Lightway Technology '),
(2, 'payment_gateway_settings_airtime_accounts', 'FirstBank=3091212716=Emmanuel Omale Raphael \nFCMB=4670368014=Lightway Technology '),
(2, 'payment_gateway_settings_bank_detail', 'After making your deposit please SMS the following to 08136522878\n    Bank Name, Bank Branch, Amount Deposited, Teller Number, Name of Depositor (ie smswise Login Username)\nYour smswise Account will be credited immediately your payment reflects, which almost instantaneous depending on the bank.'),
(2, 'payment_gateway_settings_internet_detail', ' '),
(2, 'payment_gateway_settings_mobile_detail', ''),
(2, 'payment_gateway_settings_airtime_network', 'MTN'),
(2, 'payment_gateway_settings_airtime_detail', 'Fo'),
(2, 'payment_gateway_settings_airtime_transaction_fee', ''),
(2, 'payment_gateway_settings_airtime_email', 'msgomale@gmail.com'),
(4, 'current_frontend_theme', 'default'),
(4, 'frontend_menu', '[{\"item_id\":\"menu_10902370.537072646\",\"parent_id\":\"0\",\"label\":\"Home Page\",\"link\":\"linkingsms.com\",\"show\":\"all\"},{\"item_id\":\"menu_7628623.984788483\",\"parent_id\":\"0\",\"label\":\"Dashboard\",\"link\":\"admin\\/dashboard\",\"show\":\"login\"},{\"item_id\":\"menu_64762304.143897735\",\"parent_id\":\"0\",\"label\":\"Reseller\",\"link\":\"page\\/reseller\"},{\"item_id\":\"menu_12240992.696266506\",\"parent_id\":\"0\",\"label\":\"Login\",\"link\":\"login\",\"show\":\"logout\"},{\"item_id\":\"menu_10122319.428287359\",\"parent_id\":\"0\",\"label\":\"Logout\",\"link\":\"login\\/logout\",\"show\":\"login\"}]'),
(4, 'payment_method_status', '{\"atm\":1,\"internet\":1,\"bank\":1,\"mobile\":1}'),
(4, 'default_gateway', 'reseller'),
(4, 'default_dnd_gateway', 'reseller'),
(4, 'default_rate', '5'),
(3, 'default_rate', '6'),
(3, 'default_dnd_rate', '7'),
(3, 'skin_color', 'darkgreen'),
(1, 'sync_structure_version', '25'),
(4, 'member_permission', 'send_bulk_sms,send_free_sms,message_history,draft,schedule,manage_phonebook,buy_airtime,buy_dataplan,dstv_bill,gotv_bill,startimes_bill,transfer_to_bank,view_bill_history,update_profile'),
(4, 'theme_corlate_site_name', 'LinkingSMS'),
(4, 'theme_corlate_phone', '07033366964'),
(4, 'theme_corlate_description1', 'Educational School managemet Software platform and Bulk SMS integration.'),
(4, 'theme_corlate_site_address', 'linkingsms.com'),
(4, 'theme_corlate_welcome_title', 'LINKING SMS'),
(4, 'theme_corlate_welcome_content', '<p><span style=\"color: rgb(55, 62, 74); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 21px; letter-spacing: 0.1px;\">We\r\n Provide Corporate and Individual Short Messaging Services which enables\r\n our clients to send text messages to many phone numbers through our \r\nGateway.</span><br></p><p><br></p><h3 style=\"padding: 0px; border: 0px; margin: 0px;\"><br>We also allow our client to buy airtime, dataplan and bill payment from their wallet.</h3><p><br></p>'),
(4, 'theme_corlate_faq_content', ''),
(4, 'theme_corlate_about_us_content', '<p><br></p><p class=\"lead\">We provide the following services</p><p>\r\n            \r\n\r\n           <br></p><div class=\"row\">\r\n               <div class=\"features\">\r\n                   <div class=\"col-md-4 col-sm-6 wow fadeInDown animated\" style=\"cursor: pointer; visibility: visible; animation-duration: 1000ms; animation-delay: 600ms; animation-name: fadeInDown;\" data-wow-duration=\"1000ms\" data-wow-delay=\"600ms\">\r\n                       <div class=\"feature-wrap\">\r\n                           \r\n                           <h2>Bulk SMS</h2>\r\n                           <h3>Send Bulk SMS easily at very low price</h3>\r\n                       </div>\r\n                   </div>\r\n\r\n                   <div class=\"col-md-4 col-sm-6 wow fadeInDown animated\" style=\"cursor: pointer; visibility: visible; animation-duration: 1000ms; animation-delay: 600ms; animation-name: fadeInDown;\" data-wow-duration=\"1000ms\" data-wow-delay=\"600ms\">\r\n                       <div class=\"feature-wrap\">\r\n                           \r\n                           <h2>Buy Airtime</h2>\r\n                           <h3>Buy MTN, Glo, Etisalat and 9mobile airtime</h3>\r\n                       </div>\r\n                   </div>\r\n\r\n                   <div class=\"col-md-4 col-sm-6 wow fadeInDown animated\" style=\"cursor: pointer; visibility: visible; animation-duration: 1000ms; animation-delay: 600ms; animation-name: fadeInDown;\" data-wow-duration=\"1000ms\" data-wow-delay=\"600ms\">\r\n                       <div class=\"feature-wrap\">\r\n                           \r\n                           <h2>Buy DataPlan</h2>\r\n                           <h3>Buy Dataplan for MTN, Glo, Etisalat and 9mobile</h3>\r\n                       </div>\r\n                   </div>\r\n\r\n                   <div style=\"visibility: visible; animation-duration: 1000ms; animation-delay: 600ms; animation-name: fadeInDown;\" class=\"col-md-4 col-sm-6 wow fadeInDown animated\" data-wow-duration=\"1000ms\" data-wow-delay=\"600ms\">\r\n                       <div class=\"feature-wrap\">\r\n                           \r\n                           <h2>Pay Bill</h2>\r\n                           <h3>Pay for DSTV, GoTV and Startimes Subscription</h3>\r\n                       </div>\r\n                   </div>\r\n\r\n                   <div style=\"visibility: visible; animation-duration: 1000ms; animation-delay: 600ms; animation-name: fadeInDown;\" class=\"col-md-4 col-sm-6 wow fadeInDown animated\" data-wow-duration=\"1000ms\" data-wow-delay=\"600ms\">\r\n                       <div class=\"feature-wrap\">\r\n                           \r\n                           <h2>Developer/API</h2>\r\n                           <h3>Use our robost api to use our services</h3>\r\n                       </div>\r\n                   </div>\r\n\r\n                   <div style=\"visibility: visible; animation-duration: 1000ms; animation-delay: 600ms; animation-name: fadeInDown;\" class=\"col-md-4 col-sm-6 wow fadeInDown animated\" data-wow-duration=\"1000ms\" data-wow-delay=\"600ms\">\r\n                       <div class=\"feature-wrap\">\r\n                           \r\n                           <h2>Reseller</h2>\r\n                           <h3>Set up your own website to reseller our service FREE</h3>\r\n                       </div>\r\n                   </div>\r\n               </div>\r\n           </div><p><br></p>'),
(4, 'theme_corlate_company_email', ''),
(4, 'theme_corlate_domain_name', ''),
(4, 'theme_corlate_facebook_link', ''),
(4, 'theme_corlate_twitter_link', ''),
(4, 'theme_corlate_linkedin_link', ''),
(4, 'theme_corlate_skype_link', ''),
(4, 'theme_corlate_top_header1', '#000000'),
(4, 'theme_corlate_top_header2', '#000000'),
(4, 'theme_corlate_logo', ''),
(4, 'theme_corlate_image1', ''),
(4, 'theme_corlate_slide1', '<h1 class=\"animation animated-item-1\">Welcome</h1>\r\n<h2 class=\"animation animated-item-2\">Send Bulk SMS at ease</h2>\r\n                                <a class=\"btn-slide animation animated-item-3\" href=\"#\" onclick=\'show_login()\'>Login</a>'),
(4, 'theme_corlate_image2', ''),
(4, 'theme_corlate_slide2', ''),
(4, 'theme_corlate_image3', ''),
(4, 'theme_corlate_slide3', ''),
(4, 'theme_corlate_footer', '	 <div class=\"col-md-3 col-sm-6\">\r\n                <div class=\"widget\">\r\n                    <h3>About US</h3>\r\n                    <ul>\r\n                        <li><a href=\"#\">About us</a></li>\r\n                        <li><a href=\"#\">Terms of use</a></li>\r\n                        <li><a href=\"#\">Privacy policy</a></li>\r\n                        <li><a href=\"#\">Contact us</a></li>\r\n                    </ul>\r\n                </div>\r\n            </div><!--/.col-md-3-->\r\n\r\n            <div class=\"col-md-3 col-sm-6\">\r\n                <div class=\"widget\">\r\n                    <h3>Support</h3>\r\n                    <ul>\r\n                        <li><a href=\"#\">Faq</a></li>\r\n                        <li><a href=\"#\">Documentation</a></li>\r\n                        <li><a href=\"#\">Refund policy</a></li>\r\n                    </ul>\r\n                </div>\r\n            </div><!--/.col-md-3-->\r\n\r\n            <div class=\"col-md-3 col-sm-6\">\r\n                <div class=\"widget\">\r\n                    <h3>Our Resources</h3>\r\n                    <ul>\r\n                        <li><a href=\"#\">Our FB</a></li>\r\n                        <li><a href=\"#\">On Youtube</a></li>\r\n                        <li><a href=\"#\">Our Blog</a></li>\r\n                    </ul>\r\n                </div>\r\n            </div><!--/.col-md-3-->\r\n\r\n            <div class=\"col-md-3 col-sm-6\">\r\n                <div class=\"widget\">\r\n                    <h3>Hot Links</h3>\r\n                    <ul>\r\n                        <li><a href=\"#\">Seller Page</a></li>\r\n                    </ul>\r\n                </div>\r\n            </div><!--/.col-md-3-->'),
(4, 'theme_corlate_submit', '\r\n													   Save\r\n												'),
(11, 'payment_gateway_settings_atm_paystack_allow_reseller', ''),
(11, 'payment_gateway_settings_atm_voguepay_allow_reseller', '1'),
(6, 'skin_color', 'red'),
(13, 'cname', 'TALLYCONNECTIONS'),
(13, 'caddress', '6A, BEGONIA CLOSE, TRINITY GARDENS ESTATE. PORTHARCOURT'),
(4, 'theme_default_site_name', 'LinkingSMS'),
(4, 'theme_default_description1', 'Bulk SMS integration, Purchase of Airtime, DataBundle Plan and also Pay Dstv, Gotv, Startime Subscriptions'),
(4, 'theme_default_site_address', 'linkingsms.com'),
(4, 'theme_default_welcome_title', 'LINKING SMS'),
(4, 'theme_default_welcome_content', '               <p align=\"center\"><span style=\"color: rgb(55, 62, 74); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 21px; letter-spacing: 0.1px;\">We\n Provide Corporate and Individual Short Messaging Services which enables\n our clients to send text messages to many phone numbers through our \nGateway.</span><br></p><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"center\">Bulk SMS integration, Purchase of Airtime, DataBundle Plan and also Pay&nbsp; </h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"center\"><br></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"center\">Dstv, Gotv, Startime Subscriptions </h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"center\"><br>We also allow our client to buy airtime, dataplan and bill payment from their wallet.</h3><p align=\"center\"></p>'),
(4, 'theme_default_faq_content', '<h3>How do I register?</h3><p>Registration is free, to register, click on <a target=\"_blank\" href=\"http://www.linkingsms.com/login/register\">sign up                </a> and complete the form. Upon successful registration, your login password would be sent to\n            your mobile phone and/or email address.</p><h3>What Happen when I finish the registration?</h3><p>Your account will be automatically credited with <a href=\"http://www.linkingsms.com/login/register\">10</a> (Ten) sms units for free</p><h3>How do I send bulk sms online?</h3><p>Your most be a registered member to send bulk sms. click <a target=\"_blank\" href=\"http://www.linkingsms.com/login/register\">sign up</a>\n             to do that. Login with your registered username and password sent to your mobile phone/email. \n            You most change your password first before you can send sms. simply click on compose sms and type in\n             your details, then click send</p><h3>How can I buy more sms?</h3><p>You can buy sms Online using debit card, bank deposite, mtn recharge card or visiting our office (if you are close).\n            For more details on how to buy more sms, click <a target=\"_blank\" href=\"http://linkingsms.com/page/9\">here</a></p><h3>How do I know if online ordering is secure?</h3><p>\n            Protecting your information is a  priority for Quick SMS. We\n use Secure Sockets Layer (SSL) to encrypt your  credit card number, \nname and address so only Interswitch is able to decode  your \ninformation. SSL is the industry standard method for computers to  \ncommunicate securely without risk of data interception, manipulation or \n recipient impersonation. To be sure your connection is secure; when you\n are in  the Payment Page, look at the lower corner of your browser \nwindow. If you see  an unbroken key or closed lock, the SSL is active \nand your information is  secure. </p><h3>How do i send message directly from my Mobile Phone?</h3><p>Download our Mobile Application <a href=\"https://sms.quickhostme.com/download.php\">here</a> (Java or Blackberry) and enjoy \n            sending sms at ease, ability to import all contacts from phonebook and sim easily and many more.</p><p>Also access our highly compress <a target=\"_blank\" href=\"http://linkingsms.com\">mobile website</a> from your mobile phone \n            which has low data (bandwidth) consumption</p>');
INSERT INTO `settings` (`owner`, `type`, `description`) VALUES
(4, 'theme_default_about_us_content', '<h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"center\"><font face=\"Arial\">We also allow our client to Buy Bulk SMS integration, Purchase of Airtime, </font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"center\"><font face=\"Arial\"><br></font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"center\"><font face=\"Arial\">DataBundle Plan and also Pay Dstv, Gotv, Startime Subscriptions</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\"><font face=\"Arial\"><br></font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">&nbsp;</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h1 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><u><font face=\"Arial\">TO TRANSFER CREDIT ON ETISALAT</font></u></h1><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\"><br></font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Dial*223*Pin*Amount*Phone Number#\ntake note that the default pin is 0000. E.g*223*0000*500*phone no#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">&nbsp;</font></h3><br><h1 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><u><font face=\"Arial\">TO TRANSFER CREDIT ON MTN</font></u></h1><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Your PIN. Dial*600*0000*1234*1234#</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">If you don\'t have a PIN, use 1234 as PIN</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Dial: *600*07037542228*amount*PIN#</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">&nbsp;</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">TO CHECK DATA BALANCE <br></font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">AIRTEL: *140#</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">GLO: *127*0#</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">ETISALAT: *229*9#</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">MTN: *461*6#</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\"><br></font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">&nbsp;45 GB N16,450</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">30 GB N13,750</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">16 GB N7,450</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">12 GB N4,750</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">8 GB N3,850</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">6 GB N2,950</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">5 GB N2,500</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">3.75 GB N2,050</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">1.6 GB N1,050</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\"><br></font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\"><u>GLOBAL COM </u><br></font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">&nbsp;</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">7 GB N3,575</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">3.5 GB N2100</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">1.5 GB N1,050</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">AIRTEL</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">&nbsp;</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">10 GB N6,750</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">9 GB N6,100</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">8 GB N5,450</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">7 GB N4,800</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">6 GB N4,150</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">5 GB N3,500</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">4 GB N2,850</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">3 GB N2,150</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">2 GB N1,450</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">1 GB N750</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">500 MB N400</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">250 MB N300</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\"><u>ETISALAT</u> </font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">&nbsp;5 GB N2,900.&nbsp;&nbsp;&nbsp;&nbsp; 3 months</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">2 GB N1200</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">1 GB N650.&nbsp; </font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">500 MB N350</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><u><font face=\"Arial\">MTN DATA</font></u></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">You can request for data bundle here\nand you get it to ur line instantly with 3 Months validity period to all.</font></h3><h3 align=\"left\"><!--[if gte mso 9]><xml>\n <w:WordDocument>\n  <w:View>Normal</w:View>\n  <w:Zoom>0</w:Zoom>\n  <w:TrackMoves></w:TrackMoves>\n  <w:TrackFormatting></w:TrackFormatting>\n  <w:PunctuationKerning></w:PunctuationKerning>\n  <w:ValidateAgainstSchemas></w:ValidateAgainstSchemas>\n  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>\n  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>\n  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>\n  <w:DoNotPromoteQF></w:DoNotPromoteQF>\n  <w:LidThemeOther>EN-US</w:LidThemeOther>\n  <w:LidThemeAsian>X-NONE</w:LidThemeAsian>\n  <w:LidThemeComplexScript>X-NONE</w:LidThemeComplexScript>\n  <w:Compatibility>\n   <w:BreakWrappedTables></w:BreakWrappedTables>\n   <w:SnapToGridInCell></w:SnapToGridInCell>\n   <w:WrapTextWithPunct></w:WrapTextWithPunct>\n   <w:UseAsianBreakRules></w:UseAsianBreakRules>\n   <w:DontGrowAutofit></w:DontGrowAutofit>\n   <w:SplitPgBreakAndParaMark></w:SplitPgBreakAndParaMark>\n   <w:DontVertAlignCellWithSp></w:DontVertAlignCellWithSp>\n   <w:DontBreakConstrainedForcedTables></w:DontBreakConstrainedForcedTables>\n   <w:DontVertAlignInTxbx></w:DontVertAlignInTxbx>\n   <w:Word11KerningPairs></w:Word11KerningPairs>\n   <w:CachedColBalance></w:CachedColBalance>\n  </w:Compatibility>\n  <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>\n  <m:mathPr>\n   <m:mathFont m:val=\"Cambria Math\"></m:mathFont>\n   <m:brkBin m:val=\"before\"></m:brkBin>\n   <m:brkBinSub m:val=\"--\"></m:brkBinSub>\n   <m:smallFrac m:val=\"off\"></m:smallFrac>\n   <m:dispDef></m:dispDef>\n   <m:lMargin m:val=\"0\"></m:lMargin>\n   <m:rMargin m:val=\"0\"></m:rMargin>\n   <m:defJc m:val=\"centerGroup\"></m:defJc>\n   <m:wrapIndent m:val=\"1440\"></m:wrapIndent>\n   <m:intLim m:val=\"subSup\"></m:intLim>\n   <m:naryLim m:val=\"undOvr\"></m:naryLim>\n  </m:mathPr></w:WordDocument>\n</xml><![endif]--><!--[if gte mso 9]><xml>\n <w:LatentStyles DefLockedState=\"false\" DefUnhideWhenUsed=\"true\"\n  DefSemiHidden=\"true\" DefQFormat=\"false\" DefPriority=\"99\"\n  LatentStyleCount=\"267\">\n  <w:LsdException Locked=\"false\" Priority=\"0\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Normal\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"heading 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 7\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 8\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 9\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 7\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 8\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 9\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"35\" QFormat=\"true\" Name=\"caption\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"10\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Title\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"1\" Name=\"Default Paragraph Font\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"11\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Subtitle\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"22\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Strong\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"20\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Emphasis\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"59\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Table Grid\"></w:LsdException>\n  <w:LsdException Locked=\"false\" UnhideWhenUsed=\"false\" Name=\"Placeholder Text\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"1\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"No Spacing\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"60\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Shading\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"61\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light List\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"62\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Grid\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"63\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"64\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"65\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"66\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"67\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"68\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"69\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"70\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Dark List\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"71\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Shading\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"72\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful List\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"73\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Grid\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"60\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Shading Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"61\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light List Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"62\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Grid Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"63\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 1 Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"64\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 2 Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"65\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 1 Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" UnhideWhenUsed=\"false\" Name=\"Revision\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"34\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"List Paragraph\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"29\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Quote\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"30\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Intense Quote\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"66\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 2 Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"67\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 1 Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"68\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 2 Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"69\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 3 Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"70\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Dark List Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"71\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Shading Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"72\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful List Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"73\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Grid Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"60\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Shading Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"61\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light List Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"62\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Grid Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"63\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 1 Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"64\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 2 Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"65\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 1 Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"66\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 2 Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"67\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 1 Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"68\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 2 Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"69\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 3 Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"70\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Dark List Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"71\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Shading Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"72\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful List Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"73\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Grid Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"60\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Shading Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"61\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light List Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"62\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Grid Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"63\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 1 Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"64\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 2 Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"65\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 1 Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"66\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 2 Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"67\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 1 Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"68\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 2 Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"69\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 3 Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"70\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Dark List Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"71\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Shading Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"72\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful List Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"73\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Grid Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"60\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Shading Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"61\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light List Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"62\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Grid Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"63\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 1 Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"64\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 2 Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"65\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 1 Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"66\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 2 Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"67\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 1 Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"68\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 2 Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"69\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 3 Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"70\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Dark List Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"71\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Shading Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"72\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful List Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"73\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Grid Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"60\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Shading Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"61\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light List Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"62\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Grid Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"63\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 1 Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"64\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 2 Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"65\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 1 Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"66\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 2 Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"67\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 1 Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"68\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 2 Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"69\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 3 Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"70\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Dark List Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"71\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Shading Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"72\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful List Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"73\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Grid Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"60\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Shading Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"61\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light List Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"62\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Grid Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"63\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 1 Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"64\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 2 Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"65\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 1 Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"66\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 2 Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"67\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 1 Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"68\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 2 Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"69\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 3 Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"70\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Dark List Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"71\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Shading Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"72\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful List Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"73\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Grid Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"19\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Subtle Emphasis\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"21\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Intense Emphasis\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"31\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Subtle Reference\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"32\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Intense Reference\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"33\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Book Title\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"37\" Name=\"Bibliography\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" QFormat=\"true\" Name=\"TOC Heading\"></w:LsdException>\n </w:LatentStyles>\n</xml><![endif]--><!--[if gte mso 10]>\n<style>\n /* Style Definitions */\n table.MsoNormalTable\n	{mso-style-name:\"Table Normal\";\n	mso-tstyle-rowband-size:0;\n	mso-tstyle-colband-size:0;\n	mso-style-noshow:yes;\n	mso-style-priority:99;\n	mso-style-qformat:yes;\n	mso-style-parent:\"\";\n	mso-padding-alt:0in 5.4pt 0in 5.4pt;\n	mso-para-margin-top:0in;\n	mso-para-margin-right:0in;\n	mso-para-margin-bottom:8.0pt;\n	mso-para-margin-left:0in;\n	line-height:107%;\n	mso-pagination:widow-orphan;\n	font-size:11.0pt;\n	font-family:\"Calibri\",\"sans-serif\";\n	mso-ascii-font-family:Calibri;\n	mso-ascii-theme-font:minor-latin;\n	mso-fareast-font-family:\"Times New Roman\";\n	mso-fareast-theme-font:minor-fareast;\n	mso-hansi-font-family:Calibri;\n	mso-hansi-theme-font:minor-latin;}\n</style>\n<![endif]--><font face=\"Arial\">TRANSFER CODE FOR ALL BANKS </font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Access bank:*901#&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Eco bank:*326#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Fidelity:*770#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Fcmb:*389*214#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">First bank:*894#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">GTb:*737#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Heritage:*322*030#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Keystone:*322*082#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Sky bank:*389 *076#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Stanbic: *909#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Sterling:*822#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Uba :*389*033#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Unity:*322*215#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Wema:*945#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Zenith:*966# or*302#</font></h3><h3 align=\"left\">\n\n<font face=\"Arial\"><br></font></h3>'),
(4, 'theme_default_company_email', 'support@linkingsms.com'),
(4, 'theme_default_domain_name', 'www.linkingsms.com'),
(4, 'theme_default_facebook_link', ''),
(4, 'theme_default_image1', ''),
(4, 'theme_default_image2', ''),
(4, 'theme_default_image3', ''),
(4, 'theme_default_submit', '\n													   Save\n												'),
(4, 'skin_color', 'yellow'),
(4, 'theme_login_header_text_color', '#ff00ff'),
(4, 'theme_login_bg_color1', '#7238c7'),
(4, 'theme_login_bg_color2', '#ff8000'),
(4, 'default_dnd_rate', '11'),
(3, 'theme_login_bg_color1', '#00ff00'),
(3, 'theme_login_bg_color2', '#000000'),
(3, 'theme_login_header_text_color', '#c0c0c0'),
(3, 'cname', 'SMS Akjolus'),
(3, 'caddress', '29 Church Street Oworonahoki Lagos.'),
(3, 'cemail', 'smsakjolus@gmail.com'),
(3, 'cphone', '08162634844'),
(3, 'website', 'www.smsakjolus.com'),
(3, 'site_name', ''),
(3, 'currency', 'N'),
(3, 'currency_suffix', ''),
(3, 'theme_default_site_name', 'SMS AKJOLUS'),
(3, 'theme_default_description1', ''),
(3, 'theme_default_site_address', 'www.smsakjolus.com'),
(3, 'theme_default_welcome_title', 'WELCOME TO SMSAKJOLUS'),
(3, 'theme_default_welcome_content', '<h2><strong style=\"box-sizing: border-box; font-weight: 700;\"><span style=\"box-sizing: border-box; color: rgb(255, 0, 0);\">SMS\n AKjolus is a Bulk SMS gateway that can be used to send Short Messages \n(SMS) for Invitation to marriage ceremonies, conferences, fellowships, \ngeneral meeting, workshops, seminar, personal messages, rallies &amp; as\n reminders for association and professional bodies e.g schools, banks \nand churches. It is also very effective for marketing &amp; campaigns.</span></strong><strong style=\"box-sizing: border-box; font-weight: 700;\"><span style=\"box-sizing: border-box; color: rgb(255, 0, 0);\"><br></span></strong></h2><h2><strong style=\"box-sizing: border-box; font-weight: 700;\"><span style=\"box-sizing: border-box; color: rgb(255, 0, 0);\"><br></span></strong><strong style=\"box-sizing: border-box; font-weight: 700;\"><span style=\"box-sizing: border-box;\"><font color=\"#424242\">Download our APP on Java Phones and Androids.<br></font></span></strong></h2><h2><font color=\"#424242\"><strong style=\"box-sizing: border-box; font-weight: 700;\"><span style=\"box-sizing: border-box;\"><br></span></strong><b>Click&nbsp; Here To Download</b>:</font></h2><h2><a href=\"http://www.smsakjolus.com/download/smsakjolus.apk\"><font class=\"Apple-style-span\" color=\"#0000ff\">Android</font></a></h2><h2><span style=\"line-height: 1.1; letter-spacing: 0.1px;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><a href=\"http://www.smsakjolus.com/download/smsakjolus.jar\" style=\"line-height: 1.1; background-color: rgb(255, 255, 255); letter-spacing: 0.1px;\"><font color=\"#0000ff\">Java Phones</font></a></h2><h2>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <font color=\"#0000ff\">Jad</font></h2><p><a href=\"http://[11:26, 1/24/2018] Quick sms: www.smsakjolus.com/download/smsakjolus.jar  www.smsakjolus.com/download/smsakjolus.jad\"></a></p>'),
(3, 'default_bill_rate', '4'),
(3, 'notifications_registration_mail', '<b>WELCOME @@fname@@</b> TO @@site_name@@<br>\nYour account registration was successful.<br>\nUsername: @@username@@<br>\nPassword: @@password@@\nThank you for your registration'),
(3, 'notifications_registration_mail_enabled', '1'),
(3, 'notifications_registration_sms_title', 'WELCOME'),
(3, 'notifications_registration_sms', 'WELCOME @@fname@@ TO @@site_name@@\n\nYour account registration was successful.\n\nUsername: @@username@@\n\nPassword: @@password@@\nThank you for your registration'),
(3, 'theme_default_faq_content', '<h1>What can we help you with?</h1><p><br></p><h1>You can contact us <font color=\"#9c0000\">08162634844</font></h1>'),
(3, 'theme_default_about_us_content', '<h1 style=\"margin-bottom: 10px; color: rgb(51, 51, 51); font-family: Merriweather, serif; font-size: 14px; letter-spacing: normal; text-align: justify;\"><br></h1><h3><span style=\"font-weight: 700;\">SMS Akjolus is</span>&nbsp;a fast growing Information Technology company operating in Nigeria and has a clientele base in almost all industries. We are an established on-line business company specializing in Online Advertising, SMS Marketing, BULK SMS Solutions, Computer Supplies, Value Transfer services, Search Engine Optimization (SEO) and Systems Development.<br>We provide our users with a large number of businesses listed on our website from which they can benefit. Our users can see the business\' location on the map, get their contact details and see their products and services. All this information is also accessible on the go through our mobile website and mobile apps platforms.<br>We link local businesses with their potential customers. Businesses benefit from our efficient and cost effective marketing tools to reach out to even wider audience.<br>&nbsp;</h3><h3><span style=\"color: rgb(0, 0, 255);\"><span style=\"font-weight: 700;\">Note</span>: always endeavour to check our PRICING page for latest pricing prior to paying for your sms units.&nbsp;</span><br></h3>'),
(3, 'theme_default_company_email', 'akjolus@gmail.com'),
(3, 'theme_default_domain_name', 'smsakjolus'),
(3, 'theme_default_facebook_link', 'https://www.facebook.com/akjolus'),
(3, 'theme_default_image3', ''),
(3, 'theme_default_submit', '\n													   Save\n												'),
(3, 'theme_default_image1', ''),
(3, 'theme_default_image2', ''),
(3, 'frontend_menu', '[{\"item_id\":\"menu_menu_menu_menu_menu_menu_menu_menu_menu_menu_47554998.510135494\",\"parent_id\":\"0\",\"label\":\"Bill Payment\",\"link\":\"#\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_55994567.74934517\",\"parent_id\":\"0\",\"label\":\"Home Page\",\"link\":\"home\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_menu_menu_menu_menu_menu_menu_menu_menu_menu_44184060.04321172\",\"parent_id\":\"0\",\"label\":\"Bulk SMS\",\"link\":\"message\\/bulksms\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_21125719.659977183\",\"parent_id\":\"0\",\"label\":\"Price List\",\"link\":\"page\\/price\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_47270648.967289045\",\"parent_id\":\"0\",\"label\":\"API\",\"link\":\"page\\/api\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_40605729.91174891\",\"parent_id\":\"0\",\"label\":\"Logout\",\"link\":\"login\\/logout\",\"show\":\"login\"},{\"item_id\":\"menu_menu_13587581.645697355\",\"parent_id\":\"0\",\"label\":\"Download\",\"link\":\"page\\/7\",\"show\":\"all\"},{\"item_id\":\"menu_40862087.06957851\",\"parent_id\":\"0\",\"label\":\"APPLICATION FOR CORPORATE\",\"link\":\"http:\\/\\/smsakjolus.com\\/page\\/20\",\"show\":\"all\"}]'),
(3, 'member_permission', 'send_bulk_sms,message_history,draft,schedule,manage_phonebook,buy_airtime,buy_dataplan,dstv_bill,gotv_bill,startimes_bill,fund_wallet,transfer_fund,transfer_to_bank,view_bill_history,update_profile'),
(3, 'payment_method_status', '{\"atm\":1,\"bank\":1,\"internet\":1,\"mobile\":1,\"airtime\":1,\"atm_reseller\":1}'),
(3, 'payment_gateway_settings_atm_paystack_secret_key', ''),
(3, 'payment_gateway_settings_atm_paystack_public_key', ''),
(3, 'payment_gateway_settings_atm_paystack_transaction_fee', ''),
(3, 'payment_gateway_settings_atm_paystack_enabled', '1'),
(3, 'payment_gateway_settings_atm_voguepay_merchant_id', ''),
(3, 'payment_gateway_settings_atm_voguepay_transaction_fee', ''),
(3, 'payment_gateway_settings_atm_voguepay_enabled', ''),
(3, 'payment_gateway_settings_bitcoin_bitcoin_key', ''),
(3, 'payment_gateway_settings_bitcoin_bitcoin_xpub', ''),
(3, 'payment_gateway_settings_bitcoin_bitcoin_conversion', ''),
(3, 'payment_gateway_settings_bitcoin_bitcoin_confirmation', ''),
(3, 'payment_gateway_settings_bank_accounts', 'GTBank=0036673260=JOLUGBA AKINOLA\n \nWEMA BANK=0234173215=JOLUGBA AKINOLA'),
(3, 'payment_gateway_settings_internet_accounts', 'GTBank=0036673260=JOLUGBA AKINOLA\n \nWEMA BANK=0234173215=JOLUGBA AKINOLA'),
(3, 'payment_gateway_settings_mobile_accounts', 'GTBank=0036673260=JOLUGBA AKINOLA\n \nWEMA BANK=0234173215=JOLUGBA AKINOLA'),
(3, 'payment_gateway_settings_airtime_accounts', 'GTBank=0036673260=JOLUGBA AKINOLA\n \nWEMA BANK=0234173215=JOLUGBA AKINOLA'),
(3, 'payment_gateway_settings_bank_detail', 'Please put your username as the Depositor\'s Name'),
(3, 'payment_gateway_settings_internet_detail', 'Please send your username and the amount to 08162634844 after transaction.'),
(3, 'payment_gateway_settings_mobile_detail', 'Please send your username and the amount to 08162634844 after transaction.'),
(3, 'payment_gateway_settings_airtime_network', 'GLO, AIRTEL'),
(3, 'payment_gateway_settings_airtime_detail', 'Unit is sold at N4 per SMS'),
(3, 'payment_gateway_settings_airtime_transaction_fee', ''),
(3, 'payment_gateway_settings_airtime_email', ''),
(4, 'payment_gateway_settings_atm_paystack_secret_key', ''),
(4, 'payment_gateway_settings_atm_paystack_public_key', ''),
(4, 'payment_gateway_settings_atm_paystack_transaction_fee', ''),
(4, 'payment_gateway_settings_atm_paystack_enabled', '1'),
(4, 'payment_gateway_settings_atm_voguepay_merchant_id', '5317-0058066'),
(4, 'payment_gateway_settings_atm_voguepay_transaction_fee', '1.5%'),
(4, 'payment_gateway_settings_atm_voguepay_enabled', ''),
(4, 'payment_gateway_settings_bitcoin_bitcoin_key', ''),
(4, 'payment_gateway_settings_bitcoin_bitcoin_xpub', ''),
(4, 'payment_gateway_settings_bitcoin_bitcoin_conversion', ''),
(4, 'payment_gateway_settings_bitcoin_bitcoin_confirmation', ''),
(4, 'payment_gateway_settings_bank_accounts', 'GTBank=0109980361=Israel Odubayo'),
(4, 'payment_gateway_settings_internet_accounts', 'GTBank=0109980361=Israel Odubayo'),
(4, 'payment_gateway_settings_mobile_accounts', 'GTBank=0109980361=Israel Odubayo'),
(4, 'payment_gateway_settings_airtime_accounts', 'GTBank=0109980361=Israel Odubayo'),
(4, 'payment_gateway_settings_bank_detail', ''),
(4, 'payment_gateway_settings_internet_detail', ''),
(4, 'payment_gateway_settings_mobile_detail', ''),
(4, 'payment_gateway_settings_airtime_network', ''),
(4, 'payment_gateway_settings_airtime_detail', ''),
(4, 'payment_gateway_settings_airtime_transaction_fee', ''),
(4, 'payment_gateway_settings_airtime_email', ''),
(4, 'cname', ''),
(4, 'caddress', ''),
(4, 'cemail', ''),
(4, 'cphone', ''),
(4, 'website', ''),
(4, 'site_name', ''),
(4, 'currency', 'N'),
(4, 'currency_suffix', ''),
(3, 'default_gateway', '10'),
(3, 'default_dnd_gateway', '10'),
(3, 'current_frontend_theme', 'default'),
(4, 'notifications_registration_mail_title', 'WELCOME'),
(4, 'notifications_registration_mail', '<p><b>WELCOME @@fname@@</b> TO @@site_name@@ <br>\nYour account registration was successful.<br>\nUsername: @@username@@<br>\nPassword: @@password@@\n</p><p>Thank you for your registration</p><p>www.linkingsms.com</p>'),
(4, 'notifications_registration_sms_title', 'WELCOME'),
(4, 'notifications_registration_sms', 'WELCOME @@fname@@ TO @@site_name@@\n\nYour account registration was successful.\n\nUsername: @@username@@\n\nPassword: @@password@@\nThank you for your registration\nwww.linkingsms.com'),
(4, 'notifications_fund_wallet_mail_title', 'ACCOUNT CREDITED'),
(4, 'notifications_fund_wallet_mail', 'Dear @@fname@@,<br>Your account has been credited:<br><br>\nPrevious Balance: @@p_balance@@<br>\nAmount Paid: @@amount@@<br>\nTransaction Fee: @@transaction_fee@@<br>\n<b>Amount Credited: @@amount_credited@@</b><br>\nAccount Balance @@balance@@<br><br>\nThank You'),
(4, 'notifications_fund_wallet_sms_title', 'ACCOUNT CREDITED'),
(4, 'notifications_fund_wallet_sms', 'Dear @@fname@@,\nYour account has been credited with @@amount@@. Your new Account Balance is @@balance@@\n\nThank You'),
(4, 'notifications_transfer_mail_title', 'ACCOUNT CREDITED'),
(4, 'notifications_transfer_mail', '<p>Dear @@fname@@,<br>Your account has been credited with </p><p>www.linkingsms.com<br></p>'),
(4, 'notifications_transfer_sms_title', 'A/C CREDITED'),
(4, 'notifications_transfer_sms', 'Dear @@fname@@,\nYour account has been credited with \nwww.linkingsms.com'),
(4, 'default_bill_rate', '2'),
(1, 'notifications_registration_mail_title', 'WELCOME'),
(1, 'notifications_registration_mail', '<b>WELCOME @@fname@@</b> TO @@site_name@@<br>\nYour account registration was successful.<br>\nUsername: @@username@@<br>\nPassword: @@password@@\nThank you for your registration'),
(1, 'notifications_registration_mail_enabled', '1'),
(1, 'notifications_registration_sms_title', 'WELCOME'),
(1, 'notifications_registration_sms', 'WELCOME @@fname@@ TO @@site_name@@\n\nYour account registration was successful.\n\nUsername: @@username@@\n\nPassword: @@password@@\nThank you for your registration'),
(1, 'notifications_registration_sms_enabled', '0'),
(1, 'notifications_fund_wallet_mail_title', 'ACCOUNT CREDITED'),
(1, 'notifications_fund_wallet_mail', '<p>Dear @@fname@@,<br>Your account has been credited:<br><br>\nPrevious Balance: @@p_balance@@<br>\nAmount Paid: @@amount@@</p><p>{if $payment_method == airtime}Surchages{elseif $payment_method==bank}Stamp Duty{else}Transaction Fee{/if}: @@transaction_fee@@</p><p><br>\n<b>Amount Credited: @@amount_credited@@</b><br><b>New Account Balance <font color=\"#FF0000\">@@balance@@</font></b><br><br>\nThank You</p>'),
(1, 'notifications_fund_wallet_mail_enabled', '1'),
(1, 'notifications_fund_wallet_sms_title', 'QUICK SMS'),
(1, 'notifications_fund_wallet_sms', 'ACCOUNT CREDITED\nUsername: @@username@@\nAmount Paid: @@amount@@\n{if $payment_method == airtime}Airtime Surcharges: @@transaction_fee@@{elseif $payment_method==bank}Bank Stamp Duty: @@transaction_fee@@{else}Transaction Fee:  @@transaction_fee@@{/if}\nAmount Credited: @@amount_credited@@\nAcct Balance: @@balance@@\n\nThank U\nquicksms1.com'),
(1, 'notifications_fund_wallet_sms_enabled', '1'),
(1, 'notifications_password_reset_mail_title', 'PASSWORD RESET'),
(1, 'notifications_password_reset_mail', 'Dear @@fname@@,<br>Your have requested for a password reset:<br><br>Your reset number is @@code@@<br><br>\nOr simply click on this link below<br>@@link@@'),
(1, 'notifications_password_reset_mail_enabled', '1'),
(1, 'notifications_password_reset_sms_title', 'PASSWORD'),
(1, 'notifications_password_reset_sms', 'You have requested for a password reset:\nYour reset number is @@code@@\nOr visit this link\n@@link@@'),
(4, 'notifications_registration_mail_enabled', '1'),
(1, 'notifications_password_reset_sms_enabled', '1'),
(1, 'notifications_missed_you_mail_title', 'ITS BEEN A WHILE'),
(1, 'notifications_missed_you_mail', 'Dear @@fname@@,<br>Long Time, Its been a while. We have really missed you. We have added more features, why dont you visit us again to see for yourself. <br>Thank You'),
(1, 'notifications_missed_you_mail_day', '7'),
(1, 'notifications_missed_you_mail_enabled', '0'),
(1, 'notifications_missed_you_sms_title', 'ITS BEEN A WHILE'),
(1, 'notifications_missed_you_sms', 'Dear @@fname@@,\nLong Time, Its been a while. We have really missed you. We have added more features, why dont you visit us again to see for yourself. \nThank You'),
(1, 'notifications_missed_you_sms_day', '7'),
(1, 'notifications_missed_you_sms_enabled', '0');
INSERT INTO `settings` (`owner`, `type`, `description`) VALUES
(1, 'login_using_username', '1'),
(1, 'login_using_email', '1'),
(1, 'login_using_phone', '1'),
(1, 'register_using_username', '1'),
(1, 'register_using_email', '1'),
(1, 'register_using_phone', '1'),
(4, 'notifications_registration_sms_enabled', '1'),
(4, 'notifications_fund_wallet_mail_enabled', '1'),
(4, 'notifications_fund_wallet_sms_enabled', '1'),
(4, 'notifications_password_reset_mail_title', 'PASSWORD RESET'),
(4, 'notifications_password_reset_mail', 'Dear @@fname@@,<br>Your have requested for a password reset:<br><br>Your reset code is @@code@@<br><BR>\nOr simply click on this link below<br>@@link@@'),
(4, 'notifications_password_reset_mail_enabled', '1'),
(4, 'notifications_password_reset_sms_title', 'PASSWORD RESET'),
(4, 'notifications_password_reset_sms', 'Dear @@fname@@,\nYour have requested for a password reset:\n\nYour reset code is @@code@@\n\nOr simply click on this link below\n@@link@@'),
(4, 'notifications_password_reset_sms_enabled', '1'),
(4, 'notifications_missed_you_mail_title', 'ITS BEEN A WHILE'),
(4, 'notifications_missed_you_mail', 'Dear @@fname@@,<br>Long Time, Its been a while. We have really missed you. We have added more features, why dont you visit us again to see for yourself. <br>Thank You'),
(4, 'notifications_missed_you_mail_day', '7'),
(4, 'notifications_missed_you_mail_enabled', '1'),
(4, 'notifications_missed_you_sms_title', 'ITS BEEN A WHILE'),
(4, 'notifications_missed_you_sms', 'Dear @@fname@@,\nLong Time, Its been a while. We have really missed you. We have added more features, why dont you visit us again to see for yourself. \nThank You'),
(4, 'notifications_missed_you_sms_day', '7'),
(4, 'notifications_missed_you_sms_enabled', '0'),
(5, 'cname', 'Kandy shop'),
(5, 'caddress', ''),
(5, 'cemail', 'kandyreal63@gmail.com '),
(5, 'cphone', '07053260347'),
(5, 'website', 'www.kandy.quickmx.com'),
(5, 'site_name', 'Kandy quick '),
(5, 'currency', 'N'),
(5, 'currency_suffix', ''),
(5, 'member_permission', 'send_bulk_sms,send_free_sms,message_history,draft,schedule,manage_phonebook,buy_airtime,buy_dataplan,dstv_bill,gotv_bill,startimes_bill,fund_wallet,transfer_fund,transfer_to_bank,view_bill_history'),
(5, 'skin_color', 'green'),
(5, 'current_frontend_theme', 'default'),
(5, 'frontend_menu', '[{\"item_id\":\"menu_menu_78494636.19103606\",\"parent_id\":\"0\",\"label\":\"Home Page\",\"link\":\"home\",\"show\":\"all\"},{\"item_id\":\"menu_menu_6400434.871782537\",\"parent_id\":\"0\",\"label\":\"Welcome\",\"link\":\"#\",\"show\":\"all\"},{\"item_id\":\"menu_menu_73483403.17115963\",\"parent_id\":\"0\",\"label\":\"Frequent Ask Question\",\"link\":\"#\",\"show\":\"all\"},{\"item_id\":\"menu_menu_69714633.40649122\",\"parent_id\":\"0\",\"label\":\"About Us\",\"link\":\"#\",\"show\":\"all\"},{\"item_id\":\"menu_64494658.16515835\",\"parent_id\":\"0\",\"label\":\"Buy Ebooks\",\"link\":\"page\\/14\",\"show\":\"all\"},{\"item_id\":\"menu_menu_35080012.22971311\",\"parent_id\":\"0\",\"label\":\"Logout\",\"link\":\"login\\/logout\",\"show\":\"all\"},{\"item_id\":\"menu_menu_13764755.98480189\",\"parent_id\":\"0\",\"label\":\"Contact Us\",\"link\":\"#\",\"show\":\"all\"}]'),
(5, 'login_using_username', '1'),
(5, 'login_using_email', '1'),
(5, 'login_using_phone', '1'),
(5, 'register_using_username', '1'),
(5, 'register_using_email', '1'),
(5, 'register_using_phone', '1'),
(5, 'payment_method_status', '{\"atm\":0,\"bank\":1,\"mobile\":0,\"internet\":1,\"airtime\":1,\"bitcoin\":0}'),
(5, 'payment_gateway_settings_atm_paystack_secret_key', ''),
(5, 'payment_gateway_settings_atm_paystack_public_key', ''),
(5, 'payment_gateway_settings_atm_paystack_transaction_fee', ''),
(5, 'payment_gateway_settings_atm_paystack_enabled', ''),
(5, 'payment_gateway_settings_atm_voguepay_merchant_id', ''),
(5, 'payment_gateway_settings_atm_voguepay_transaction_fee', ''),
(5, 'payment_gateway_settings_atm_voguepay_enabled', ''),
(5, 'payment_gateway_settings_bitcoin_bitcoin_key', ''),
(5, 'payment_gateway_settings_bitcoin_bitcoin_xpub', ''),
(5, 'payment_gateway_settings_bitcoin_bitcoin_conversion', ''),
(5, 'payment_gateway_settings_bitcoin_bitcoin_confirmation', ''),
(5, 'payment_gateway_settings_bank_accounts', 'GT-BANK=0159715878=Abdulmalik Idris '),
(5, 'payment_gateway_settings_internet_accounts', 'GT-BANK=0159715878=Abdulmalik Idris '),
(5, 'payment_gateway_settings_mobile_accounts', 'GT-BANK=0159715878=Abdulmalik Idris '),
(5, 'payment_gateway_settings_airtime_accounts', 'GT-BANK=0159715878=Abdulmalik Idris '),
(5, 'payment_gateway_settings_bank_detail', ''),
(5, 'payment_gateway_settings_internet_detail', ''),
(5, 'payment_gateway_settings_mobile_detail', ''),
(5, 'payment_gateway_settings_airtime_network', ''),
(5, 'payment_gateway_settings_airtime_detail', ''),
(5, 'payment_gateway_settings_airtime_transaction_fee', ''),
(5, 'payment_gateway_settings_airtime_email', ''),
(5, 'theme_login_header_text_color', '#ff00ff'),
(5, 'default_rate', '13'),
(5, 'default_dnd_rate', '14'),
(1, 'payment_gateway_settings_atm_paystack_method', '1'),
(5, 'default_bill_rate', '3'),
(5, 'payment_gateway_settings_atm_paystack_method', ''),
(10, 'theme_corlate_site_name', 'Rockbulksms'),
(4, 'theme_price_site_name', 'LinkingSMS'),
(4, 'theme_price_description1', 'Bulk SMS integration, Purchase of Airtime, DataBundle Plan and also Pay Dstv, Gotv, Startime Subscriptions'),
(4, 'theme_price_site_address', 'linkingsms.com'),
(4, 'theme_price_welcome_title', 'LINKING SMS'),
(4, 'theme_price_welcome_content', '\n               <p align=\"center\"><span style=\"color: rgb(55, 62, 74); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 21px; letter-spacing: 0.1px;\">We\n Provide Corporate and Individual Short Messaging Services which enables\n our clients to send text messages to many phone numbers through our \nGateway.</span><br></p><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"center\">Bulk SMS integration, Purchase of Airtime, DataBundle Plan and also Pay&nbsp; </h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"center\"><br></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"center\">Dstv, Gotv, Startime Subscriptions </h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"center\"><br>We also allow our client to buy airtime, dataplan and bill payment from their wallet.</h3><p align=\"center\"></p>'),
(4, 'theme_price_faq_content', '<h3>How do I register?</h3><p>Registration is free, to register, click on <a target=\"_blank\" href=\"http://www.linkingsms.com/login/register\">sign up                </a> and complete the form. Upon successful registration, your login password would be sent to\n            your mobile phone and/or email address.</p><h3>What Happen when I finish the registration?</h3><p>Your account will be automatically credited with <a href=\"http://www.linkingsms.com/login/register\">10</a> (Ten) sms units for free</p><h3>How do I send bulk sms online?</h3><p>Your most be a registered member to send bulk sms. click <a target=\"_blank\" href=\"http://www.linkingsms.com/login/register\">sign up</a>\n             to do that. Login with your registered username and password sent to your mobile phone/email. \n            You most change your password first before you can send sms. simply click on compose sms and type in\n             your details, then click send</p><h3>How can I buy more sms?</h3><p>You can buy sms Online using debit card, bank deposite, mtn recharge card or visiting our office (if you are close).\n            For more details on how to buy more sms, click <a target=\"_blank\" href=\"http://linkingsms.com/page/9\">here</a></p><h3>How do I know if online ordering is secure?</h3><p>\n            Protecting your information is a  priority for Quick SMS. We\n use Secure Sockets Layer (SSL) to encrypt your  credit card number, \nname and address so only Interswitch is able to decode  your \ninformation. SSL is the industry standard method for computers to  \ncommunicate securely without risk of data interception, manipulation or \n recipient impersonation. To be sure your connection is secure; when you\n are in  the Payment Page, look at the lower corner of your browser \nwindow. If you see  an unbroken key or closed lock, the SSL is active \nand your information is  secure. </p><h3>How do i send message directly from my Mobile Phone?</h3><p>Download our Mobile Application <a href=\"https://sms.quickhostme.com/download.php\">here</a> (Java or Blackberry) and enjoy \n            sending sms at ease, ability to import all contacts from phonebook and sim easily and many more.</p><p>Also access our highly compress <a target=\"_blank\" href=\"http://linkingsms.com\">mobile website</a> from your mobile phone \n            which has low data (bandwidth) consumption</p>'),
(4, 'theme_price_about_us_content', '<h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"center\"><font face=\"Arial\">We also allow our client to Buy Bulk SMS integration, Purchase of Airtime, </font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"center\"><font face=\"Arial\"><br></font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"center\"><font face=\"Arial\">DataBundle Plan and also Pay Dstv, Gotv, Startime Subscriptions</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\"><font face=\"Arial\"><br></font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">&nbsp;</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h1 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><u><font face=\"Arial\">TO TRANSFER CREDIT ON ETISALAT</font></u></h1><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\"><br></font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Dial*223*Pin*Amount*Phone Number#\ntake note that the default pin is 0000. E.g*223*0000*500*phone no#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">&nbsp;</font></h3><br><h1 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><u><font face=\"Arial\">TO TRANSFER CREDIT ON MTN</font></u></h1><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Your PIN. Dial*600*0000*1234*1234#</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">If you don\'t have a PIN, use 1234 as PIN</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Dial: *600*07037542228*amount*PIN#</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">&nbsp;</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">TO CHECK DATA BALANCE <br></font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">AIRTEL: *140#</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">GLO: *127*0#</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">ETISALAT: *229*9#</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">MTN: *461*6#</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\"><br></font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">&nbsp;45 GB N16,450</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">30 GB N13,750</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">16 GB N7,450</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">12 GB N4,750</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">8 GB N3,850</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">6 GB N3,550</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">5 GB N3,000</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">3.75 GB N2,050</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">1.6 GB N1,050</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\"><br></font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\"><u>GLOBAL COM </u><br></font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">&nbsp;</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">7 GB N3,575</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">3.5 GB N2100</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">1.5 GB N1,050</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">AIRTEL</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">&nbsp;</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">10 GB N6,750</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">9 GB N6,100</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">8 GB N5,450</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">7 GB N4,800</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">6 GB N4,150</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">5 GB N3,500</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">4 GB N2,850</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">3 GB N2,150</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">2 GB N1,450</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">1 GB N750</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">500 MB N400</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">250 MB N300</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\"><u>ETISALAT</u> </font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">&nbsp;5 GB N2,900.&nbsp;&nbsp;&nbsp;&nbsp; 3 months</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">2 GB N1200</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">1 GB N650.&nbsp; </font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">500 MB N350</font></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><u><font face=\"Arial\">MTN DATA</font></u></h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 style=\"padding: 0px; border: 0px; margin: 0px;\" align=\"left\">\n\n</h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">You can request for data bundle here\nand you get it to ur line instantly with 3 Months validity period to all.</font></h3><h3 align=\"left\"><!--[if gte mso 9]><xml>\n <w:WordDocument>\n  <w:View>Normal</w:View>\n  <w:Zoom>0</w:Zoom>\n  <w:TrackMoves></w:TrackMoves>\n  <w:TrackFormatting></w:TrackFormatting>\n  <w:PunctuationKerning></w:PunctuationKerning>\n  <w:ValidateAgainstSchemas></w:ValidateAgainstSchemas>\n  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>\n  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>\n  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>\n  <w:DoNotPromoteQF></w:DoNotPromoteQF>\n  <w:LidThemeOther>EN-US</w:LidThemeOther>\n  <w:LidThemeAsian>X-NONE</w:LidThemeAsian>\n  <w:LidThemeComplexScript>X-NONE</w:LidThemeComplexScript>\n  <w:Compatibility>\n   <w:BreakWrappedTables></w:BreakWrappedTables>\n   <w:SnapToGridInCell></w:SnapToGridInCell>\n   <w:WrapTextWithPunct></w:WrapTextWithPunct>\n   <w:UseAsianBreakRules></w:UseAsianBreakRules>\n   <w:DontGrowAutofit></w:DontGrowAutofit>\n   <w:SplitPgBreakAndParaMark></w:SplitPgBreakAndParaMark>\n   <w:DontVertAlignCellWithSp></w:DontVertAlignCellWithSp>\n   <w:DontBreakConstrainedForcedTables></w:DontBreakConstrainedForcedTables>\n   <w:DontVertAlignInTxbx></w:DontVertAlignInTxbx>\n   <w:Word11KerningPairs></w:Word11KerningPairs>\n   <w:CachedColBalance></w:CachedColBalance>\n  </w:Compatibility>\n  <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>\n  <m:mathPr>\n   <m:mathFont m:val=\"Cambria Math\"></m:mathFont>\n   <m:brkBin m:val=\"before\"></m:brkBin>\n   <m:brkBinSub m:val=\"--\"></m:brkBinSub>\n   <m:smallFrac m:val=\"off\"></m:smallFrac>\n   <m:dispDef></m:dispDef>\n   <m:lMargin m:val=\"0\"></m:lMargin>\n   <m:rMargin m:val=\"0\"></m:rMargin>\n   <m:defJc m:val=\"centerGroup\"></m:defJc>\n   <m:wrapIndent m:val=\"1440\"></m:wrapIndent>\n   <m:intLim m:val=\"subSup\"></m:intLim>\n   <m:naryLim m:val=\"undOvr\"></m:naryLim>\n  </m:mathPr></w:WordDocument>\n</xml><![endif]--><!--[if gte mso 9]><xml>\n <w:LatentStyles DefLockedState=\"false\" DefUnhideWhenUsed=\"true\"\n  DefSemiHidden=\"true\" DefQFormat=\"false\" DefPriority=\"99\"\n  LatentStyleCount=\"267\">\n  <w:LsdException Locked=\"false\" Priority=\"0\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Normal\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"heading 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 7\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 8\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"9\" QFormat=\"true\" Name=\"heading 9\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 7\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 8\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" Name=\"toc 9\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"35\" QFormat=\"true\" Name=\"caption\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"10\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Title\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"1\" Name=\"Default Paragraph Font\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"11\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Subtitle\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"22\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Strong\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"20\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Emphasis\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"59\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Table Grid\"></w:LsdException>\n  <w:LsdException Locked=\"false\" UnhideWhenUsed=\"false\" Name=\"Placeholder Text\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"1\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"No Spacing\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"60\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Shading\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"61\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light List\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"62\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Grid\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"63\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"64\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"65\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"66\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"67\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"68\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"69\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"70\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Dark List\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"71\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Shading\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"72\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful List\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"73\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Grid\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"60\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Shading Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"61\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light List Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"62\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Grid Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"63\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 1 Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"64\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 2 Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"65\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 1 Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" UnhideWhenUsed=\"false\" Name=\"Revision\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"34\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"List Paragraph\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"29\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Quote\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"30\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Intense Quote\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"66\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 2 Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"67\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 1 Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"68\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 2 Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"69\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 3 Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"70\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Dark List Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"71\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Shading Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"72\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful List Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"73\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Grid Accent 1\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"60\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Shading Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"61\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light List Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"62\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Grid Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"63\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 1 Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"64\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 2 Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"65\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 1 Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"66\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 2 Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"67\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 1 Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"68\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 2 Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"69\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 3 Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"70\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Dark List Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"71\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Shading Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"72\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful List Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"73\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Grid Accent 2\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"60\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Shading Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"61\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light List Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"62\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Grid Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"63\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 1 Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"64\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 2 Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"65\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 1 Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"66\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 2 Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"67\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 1 Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"68\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 2 Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"69\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 3 Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"70\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Dark List Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"71\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Shading Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"72\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful List Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"73\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Grid Accent 3\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"60\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Shading Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"61\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light List Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"62\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Grid Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"63\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 1 Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"64\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 2 Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"65\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 1 Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"66\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 2 Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"67\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 1 Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"68\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 2 Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"69\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 3 Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"70\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Dark List Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"71\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Shading Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"72\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful List Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"73\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Grid Accent 4\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"60\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Shading Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"61\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light List Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"62\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Grid Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"63\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 1 Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"64\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 2 Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"65\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 1 Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"66\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 2 Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"67\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 1 Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"68\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 2 Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"69\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 3 Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"70\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Dark List Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"71\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Shading Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"72\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful List Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"73\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Grid Accent 5\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"60\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Shading Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"61\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light List Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"62\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Light Grid Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"63\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 1 Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"64\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Shading 2 Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"65\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 1 Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"66\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium List 2 Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"67\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 1 Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"68\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 2 Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"69\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Medium Grid 3 Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"70\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Dark List Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"71\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Shading Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"72\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful List Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"73\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" Name=\"Colorful Grid Accent 6\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"19\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Subtle Emphasis\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"21\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Intense Emphasis\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"31\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Subtle Reference\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"32\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Intense Reference\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"33\" SemiHidden=\"false\"\n   UnhideWhenUsed=\"false\" QFormat=\"true\" Name=\"Book Title\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"37\" Name=\"Bibliography\"></w:LsdException>\n  <w:LsdException Locked=\"false\" Priority=\"39\" QFormat=\"true\" Name=\"TOC Heading\"></w:LsdException>\n </w:LatentStyles>\n</xml><![endif]--><!--[if gte mso 10]>\n<style>\n /* Style Definitions */\n table.MsoNormalTable\n	{mso-style-name:\"Table Normal\";\n	mso-tstyle-rowband-size:0;\n	mso-tstyle-colband-size:0;\n	mso-style-noshow:yes;\n	mso-style-priority:99;\n	mso-style-qformat:yes;\n	mso-style-parent:\"\";\n	mso-padding-alt:0in 5.4pt 0in 5.4pt;\n	mso-para-margin-top:0in;\n	mso-para-margin-right:0in;\n	mso-para-margin-bottom:8.0pt;\n	mso-para-margin-left:0in;\n	line-height:107%;\n	mso-pagination:widow-orphan;\n	font-size:11.0pt;\n	font-family:\"Calibri\",\"sans-serif\";\n	mso-ascii-font-family:Calibri;\n	mso-ascii-theme-font:minor-latin;\n	mso-fareast-font-family:\"Times New Roman\";\n	mso-fareast-theme-font:minor-fareast;\n	mso-hansi-font-family:Calibri;\n	mso-hansi-theme-font:minor-latin;}\n</style>\n<![endif]--><font face=\"Arial\">TRANSFER CODE FOR ALL BANKS </font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Access bank:*901#&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Eco bank:*326#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Fidelity:*770#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Fcmb:*389*214#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">First bank:*894#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">GTb:*737#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Heritage:*322*030#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Keystone:*322*082#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Sky bank:*389 *076#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Stanbic: *909#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Sterling:*822#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Uba :*389*033#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Unity:*322*215#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Wema:*945#</font></h3><h3 class=\"MsoNormal\" style=\"text-align:justify\" align=\"left\"><font face=\"Arial\">Zenith:*966# or*302#</font></h3><h3 align=\"left\">\n\n<font face=\"Arial\"><br></font></h3>'),
(4, 'theme_price_company_email', 'support@linkingsms.com'),
(4, 'theme_price_domain_name', 'www.linkingsms.com'),
(4, 'theme_price_facebook_link', ''),
(4, 'theme_price_image1', ''),
(4, 'theme_price_image2', ''),
(4, 'theme_price_image3', ''),
(4, 'theme_price_submit', '\n													   Save\n												');
INSERT INTO `settings` (`owner`, `type`, `description`) VALUES
(3, 'theme_default_api', '<section id=\"error\" class=\"container\"><h2 style=\"color: red; font-size: 26px; margin: 0px 0px 25px; padding: 5px 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\" align=\"center\">\n		API</h2>\n\n	<p style=\"margin-bottom: 10px; padding: 0px;  Geneva, sans-serif; letter-spacing: normal;\">You\n		can interface an application, website or system with our messaging gateway by using our very flexible HTTP API\n		connection. Once you\'re connected, you\'ll be able send sms, check account balance, get deliver reports and sent\n		messages or check your balance.</p>\n\n	<h3 style=\"color: red; font-weight: bold; font-size: 15px; margin: 30px 0px 5px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\" align=\"\">\n		CONNECTION METHOD</h3>\n\n	<div class=\"payment\" style=\"display: inline; size: 60px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\" align=\"left\">\n		\n		<br><b>SPC API</b>&nbsp;http://smsakjolus.com/api/sendsms.php?username=yourUsername&amp;password=yourPassword&amp;sender=@@sender@@&amp;message=@@message@@&amp;recipient=@@recipient@@\n		<hr>\n		<p style=\"margin-bottom: 10px; padding: 0px;\"><a href=\"https://sms.quickhostme.com/api/#atm\" style=\"color: rgb(8, 174, 227); display: block; size: 24px;\">GET\n				METHOD</a><a href=\"https://sms.quickhostme.com/api/#get\" style=\"color: rgb(8, 174, 227); display: block; size: 24px;\">POST METHOD</a></p></div>\n	<p><span style=\"font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\"></span></p>\n	<blockquote style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">\n		<span class=\"h_api\" style=\"font-size: 18px;\">GET METHOD</span>\n\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Connect to send single or multiple sms messages through the\n			following api url:<span style=\"color: rgb(0, 85, 128);\">http://smsakjolus.com				/api/sendsms.php?username=user&amp;password=1234&amp;sender=quicsms1&amp;message=testing&amp;recipient=2348030000000,23480xxxxxxxx&amp;report=1&amp;convert=1&amp;route=1</span>\n		</p><span class=\"h_api\" style=\"font-size: 18px;\">POST METHOD</span>\n\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Use this method to send sms messages where the length of \"GET\n			METHOD\" is a limitation,<br>url:&nbsp;<span style=\"color: rgb(0, 85, 128);\">http://smsakjolus.com/api/sendsms.php</span>&nbsp;<br>Data\n			to post: username=user&amp;password=1234&amp;sender=quicsms1&amp;message=testing &amp;recipient=2348030000000,23480xxxxxxxx&amp;report=1&amp;convert=1&amp;route=1\n		</p>\n\n		<hr>\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. recipient : The destination phone numbers. Separate multiple\n			numbers with comma(,)<br>3. username: Your  account username<br>4. password: Your  account\n			password<br>5. sender: The sender ID to show on the receiver\'s phone<br>6. message: The text message to be\n			sent<br>7. balance: Set to \'true\' only when you want to check your credit balance<br>6. schedule: Specify\n			this parameter only when you are scheduling an sms for later delivery. It should contain the date the\n			message should be delivered. Supported format is \"2010-10-01 12:30:00\" i.e \"YYYY-MM-DD HH:mm:ss\"<br>7.\n			convert: Specify and set this parameter to 1 only when you want to get the return code in string readable\n			format instead of the raw numbers below;<br>8. report: Set this parameter to 1 to retrieve the message id\n			which can later be used to retrieve the delivery report or else remove it or set it to 0<br>9. route: Set\n			this parameter to&nbsp;<b>0</b>&nbsp;to send message using the normal route (Will not deliver to DND\n			numbers). Set to&nbsp;<b>1</b>&nbsp;to send through normal route for numbers not on DND and send through\n			banking route for numbers on DND. Set to&nbsp;<b>2</b>&nbsp;to send all messages through the banking route.\n		</div>\n		<div class=\"t_api\"><br>The return values are:<br>OK = Successful<br>1 = Invalid Recipient(s) Number<br>2 = Cant\n			send Empty Message<br>3 = Invalid Sender ID<br>4 = Insufficient Balance<br>5 = Incorrect Username or\n			Password Specified<br>6 = Incorrect schedule date format<br>7 = Error sending message (Gateway not\n			available), Please try again later<br><br>Example:<br>On success, the following code will be returned<br>OK\n			21 = 4564<br><br>i.e \'OK\' \'No of sms credits used\' = \'Unique Message ID\'&nbsp;<br>where OK = The message was\n			sent successfully<br>21 = No of sms credits used<br>and 4564 = The unique message id of the sent message\n			which can be used to retrieve the delivery status of the sent message.\n		</div>\n		<span style=\"color: red;\">Note: When using GET METHOD to send message, the values should be properly encoded before sending it to our server</span>\n		<hr>\n		<br><span class=\"h_api\" style=\"font-size: 18px;\">CHECK ACCOUNT BALANCE</span>\n\n		<p style=\"margin-bottom: 10px; padding: 0px;\">You can use GET or POST METHOD to query your  account\n			balance.<span style=\"color: rgb(0, 85, 128);\">http://smsakjolus.quicksms1.com/api/sendsms.php?username=user&amp;password=1234&amp;balance=1</span>\n		</p>\n\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. username: Your  account username<br>2. password:\n			Your  account password<br>3. balance: This most be included to inform our server that you want to\n			only check your account balance<br></div>\n		<br>\n\n		<div class=\"t_api\"><i>On successful, Your account balance would be returned e.g&nbsp;<b>5024</b></i></div>\n		<br>\n		<hr>\n		<span class=\"h_api\" style=\"font-size: 18px;\">DELIVERY REPORT</span>\n\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Use Get Method to query the delivery report/status of the sent\n			message using the message id.<span style=\"color: rgb(0, 85, 128);\">http://smsakjolus.com/api/getdelivery.php?username=user&amp;password=1234&amp;msgid=4564</span>\n		</p>\n\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. username: Your  account username<br>2. password:\n			Your  account password<br>3. msgid: The message id of the sent message you want to retrieve the\n			delivery status<br>3. html: Only Set this parameter to 1, to return the report in colourful html table\n			format. e.g html=1<br></div>\n		<br>\n\n		<div class=\"t_api\">On success, the following code will be returned.<br><i>2349038781252=DELIVERED=2015/10/25\n				23:11:34, 2349055552635=SENT=----/--/-- --:--:--</i><br>i.e \'Number\' = \'Delivery Status\' = \'Date and\n			Time of delivery\'&nbsp;<br>where 2349038781252 = Phone number<br>DELIVERED = The message had delivered<br>2015/10/25\n			23:11:34 = The date and time the message was delivered.\n		</div>\n	</blockquote>\n</section>'),
(3, 'theme_price_site_name', 'SMS AKJOLUS'),
(3, 'theme_price_description1', ''),
(3, 'theme_price_site_address', 'www.smsakjolus.com'),
(3, 'theme_price_welcome_title', 'WELCOME TO SMSAKJOLUS'),
(3, 'theme_price_welcome_content', '<div style=\"will-change: transform;\"><p style=\"box-sizing: border-box; margin: 0px 0px 10px;\"><strong style=\"box-sizing: border-box; font-weight: 700;\"><span style=\"box-sizing: border-box; color: rgb(255, 0, 0);\">sms AKjolus is a Bulk SMS gateway that can be used to send Short Messages (SMS) for Invitation to marriage ceremonies, conferences, fellowships, general meeting, workshops, seminar, personal messages, rallies &amp; as reminders for association and professional bodies e.g schools, banks and churches. It is also very effective for marketing &amp; campaigns.</span></strong></p></div><p><marquee class=\"mymarquee\" style=\"text-align: start; width: 1337px; position: absolute; top: 175px; color: rgb(51, 51, 51); font-family: Merriweather, serif; font-size: 14px; letter-spacing: normal;\"></marquee></p><ul class=\"rslides rslides1\" style=\"margin: 200px 0px 0px; padding: 0px; list-style: none; position: relative; overflow: hidden; width: 1337px; border-radius: 5px; border: 5px solid black; display: inline-block; color: rgb(51, 51, 51); font-family%3'),
(3, 'theme_price_faq_content', '<h1>What can we help you with?</h1><h1><br>You can contact us<font color=\"#ffffff\" style=\"background-color: rgb(0, 0, 255);\"> 08162634844</font></h1>'),
(3, 'theme_price_about_us_content', '<p><br></p><p style=\"margin-bottom: 10px; color: rgb(51, 51, 51); font-family: Merriweather, serif; font-size: 14px; letter-spacing: normal; text-align: justify;\"><span style=\"font-weight: 700;\">sms Akjolus is</span>&nbsp;a fast growing Information Technology company operating in Nigeria and has a clientele base in almost all industries. We are an established on-line business company specializing in Online Advertising, SMS Marketing, BULK SMS Solutions, Computer Supplies, Value Transfer services, Search Engine Optimization (SEO) and Systems Development.</p><p style=\"margin-bottom: 10px; color: rgb(51, 51, 51); font-family: Merriweather, serif; font-size: 14px; letter-spacing: normal; text-align: justify;\">We provide our users with a large number of businesses listed on our website from which they can benefit. Our users can see the business\' location on the map, get their contact details and see their products and services. All this information is also accessible on the go through our mobile website and mobile apps platforms.</p><p style=\"margin-bottom: 10px; color: rgb(51, 51, 51); font-family: Merriweather, serif; font-size: 14px; letter-spacing: normal; text-align: justify;\">We link local businesses with their potential customers. Businesses benefit from our efficient and cost effective marketing tools to reach out to even wider audience.</p><p style=\"margin-bottom: 10px; color: rgb(51, 51, 51); font-family: Merriweather, serif; font-size: 14px; letter-spacing: normal; text-align: justify;\">&nbsp;</p><p style=\"margin-bottom: 10px; color: rgb(51, 51, 51); font-family: Merriweather, serif; font-size: 14px; letter-spacing: normal; text-align: justify;\"><span style=\"color: rgb(0, 0, 255);\"><span style=\"font-weight: 700;\">Note</span>: always endeavour to check our PRICING page for latest pricing prior to paying for your sms units.&nbsp;</span></p><p style=\"margin-bottom: 10px; color: rgb(51, 51, 51); font-family: Merriweather, serif; font-size: 14px; letter-spacing: normal; text-align: justify;\"><span style=\"color: rgb(0, 0, 255);\">However we still maintain a flat charge of 1 unit to all Nigerian GSM networks.</span></p><p style=\"margin-bottom: 10px; color: rgb(51, 51, 51); font-family: Merriweather, serif; font-size: 14px; letter-spacing: normal; text-align: justify;\"><span style=\"color: rgb(0, 0, 255);\">Thank you.</span></p>'),
(3, 'theme_price_company_email', 'akjolus@gmail.com'),
(3, 'theme_price_domain_name', 'smsakjolus'),
(3, 'theme_price_facebook_link', ''),
(3, 'theme_price_image1', ''),
(3, 'theme_price_image2', ''),
(3, 'theme_price_image3', ''),
(3, 'theme_price_submit', '\r\n													   Save\r\n												'),
(3, 'notifications_registration_mail_title', 'WELCOME'),
(3, 'theme_default_price', '<div style=\"width: 100%;\" align=\"center\">\n<h2><center>SMS PRICE</center></h2>\n<br>\n<table class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Volume</th>\n        <th><font color=\"#ffffff\">Price per SMS (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">All Network</td>\n        <td style=\"padding: 3px;\" align=\"center\">N2.80</td>\n    </tr>\n    </tbody>\n</table>\n\n<br>\n<h2><center>AIRTIME</center></h2>\n<br>\n<table class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Bundle</th>\n        <th><font color=\"#ffffff\">Price (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">MTN</td>\n        <td style=\"padding: 3px;\" align=\"center\">1% commission</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Airtel</td>\n        <td style=\"padding: 3px;\" align=\"center\">1% commission</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Glo</td>\n        <td style=\"padding: 3px;\" align=\"center\">1% commission</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Etisalat</td>\n        <td style=\"padding: 3px;\" align=\"center\">1% commission</td>\n    </tr>\n    </tbody>\n</table><br>\n\n<h2><center>DATA PLAN</center></h2>\n<center style=\"color: red;\">Please login to check our current price</center>\n<table class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Network</th>\n        <th><font color=\"#ffffff\">Bundle &amp; Price (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">MTN</td>\n        <td style=\"padding: 3px;\" align=\"center\">\n            1GB for N650<br>\n            2GB for N1,230\n        </td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Airtel</td>\n        <td style=\"padding: 3px;\" align=\"center\">1.5GB for N1050</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Glo</td>\n        <td style=\"padding: 3px;\" align=\"center\">1.6GB for N1050</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Etisalat</td>\n        <td style=\"padding: 3px;\" align=\"center\">2GB for N1500</td>\n    </tr>\n    </tbody>\n</table><br>\n<h2><center>BILL PAYMENT</center></h2>\n<br>\n<table class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Bill</th>\n        <th><font color=\"#ffffff\">Bundle &amp; Price (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">DSTV</td>\n        <td style=\"padding: 3px;\" align=\"center\">\n            DSTV Access = N1,950<br>\n            DSTV Family= N4,000<br>\n        </td>\n    </tr>\n\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">GoTv</td>\n        <td style=\"padding: 3px;\" align=\"center\">GoTv pack = N1,300</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Startimes</td>\n        <td style=\"padding: 3px;\" align=\"center\">Nova = N980</td>\n    </tr>\n    </tbody>\n</table>\n</div>\n\n'),
(3, 'theme_default_reseller', '<h2 align=\"left\" style=\"color: red; font-size: 26px; margin: 0px 0px 25px; padding: 5px 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">RESELLER SERVICES:</h2><div style=\"font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"><blockquote style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px;\"><strong>Features that your members will enjoy:</strong><br>- Robust registration form (different from joomla)<br>- Compose SMS with dynamic sender ID<br>- Type multiple sms recipients, select recipient group from phonebook or upload recipients from text and csv(excel) file<br>- SMS character counter for composing SMS i.e Page: 1, Characters left: 157, Total Typed Characters: 3<br>- SMS scheduling for future delivery with date picker.<br>- Duplicate number remover.<br>- Numbers can be in the format of&nbsp;<strong>+2348080000000 or 2348080000000 or 08080000000</strong>.<br>- Separate multiple numbers and uploaded numbers with comma, colon, semicolon or put each number on a separate line.<br>- Automatic removal of&nbsp;<strong>invalid characters from numbers</strong>&nbsp;e.g space,;,:,.,\',`,(,),,{,},#,-,_ and ?<br>- Displays member&nbsp;<strong>SMS units left and SMS Units used</strong><br>- Phone book to store phone groups and numbers<br>- Add multiple numbers to phone book group at once<br>- Upload numbers to phone group from file<br>- Delete a phone book group and all its records<br>- View to all sent sms messages with&nbsp;<strong>recipients, message,status, credit used, date scheduled, date delivered</strong><br>- Search and forward sent sms messages with page numbers and page size<br>- Order/Request/purchase sms credits with&nbsp;<strong>automatic cost calculator</strong><br>- Transaction/purchase history with&nbsp;<strong>Transaction date, amount, credit requested, status and date approved</strong><br>- Search and sort transaction history with page numbers and page size<br>- View personal details<br>- Change password on settings page<br>- Set default sender ID<br>- Members can&nbsp;<strong>transfer SMS units</strong>&nbsp;to another member</blockquote></div><div class=\"cleaner\" style=\"clear: both; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"></div><blockquote style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"><strong>Admin Features:</strong><br>- Send sms to all members<br>- Specify No of free SMS units for new members e.g new members get 3 free sms<br>- Specify how many sms units is regarded as low sms<br>- Alert member by sms and email when credit is below your specified level<br>- Specify captcha type(local captcha or google recaptcha)<br>- Create/edit Welcome SMS message for new members<br>- Create/edit SMS to send to members when their SMS orders have been approved<br>- Create/edit SMS to send to members when their credit is below your specified level<br>- Create/edit Welcome Email<br>- Create/edit Email to send to members when orders have been approved<br>- Create/edit Email to send to members when their credit is below ur specified level<br>- Set/change SMS API Gateway URL to any provider<br>- Create/edit Selling price per sms unit for different quantity of sms purchases<br>- Specify county codes that use more that 1 sms unit per text message<br>- Set/edit No of records to display per page on member and admin pages<br>- You\'ll get your own SMS Api to Give to your own customers and resellers.<br>- You\'ll get SMS Cron Url for scheduled sms (If you want to add your own cron job for scheduled sms)- Export all phone numbers that have ever recieved sms from you portal and your resellers in one click<br>- Export all phone numbers of all members in one click<br>- Export all phone numbers in member phone books in one click<br>- Admin view of all address book records and groups<br>- Admin view of all sms messages sent by members, resellers or through api<br>- Admin view of all transactions for viewing, approval, cancelliung or deletion<br>- Automatically credits member sms account upon approval of sms request transaction<br>- View, edit and delete any member account<br>- Manually reduce/increase any member account SMS units<br>- Registration cannot be repeated for registered phone number/email address<br>- Free GSM Phone Number generator<br>- Contact us form<br>- User Management&nbsp;<br>-&nbsp;<strong>And many more</strong></blockquote><div class=\"cleaner\" style=\"clear: both; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"></div><p style=\"margin-bottom: 10px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\"></p><div id=\"pay\" style=\"font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">To become a&nbsp;<strong>Reseller</strong>&nbsp;and start making profit online immediately, Please register as a normal member</div>'),
(3, 'notifications_registration_sms_enabled', '1'),
(3, 'notifications_fund_wallet_mail_title', 'ACCOUNT CREDITED'),
(3, 'notifications_fund_wallet_mail', 'Dear @@fname@@,<br>Your account has been credited:<br><br>\nPrevious Balance: @@p_balance@@<br>\nAmount Paid: @@amount@@<br>\nTransaction Fee: @@transaction_fee@@<br>\n<b>Amount Credited: @@amount_credited@@</b><br>\nAccount Balance @@balance@@<br><br>\nThank You'),
(3, 'notifications_fund_wallet_mail_enabled', '0'),
(3, 'notifications_fund_wallet_sms_title', 'ACCOUNT CREDITED'),
(3, 'notifications_fund_wallet_sms', 'Dear @@fname@@,\nYour account has been credited with @@amount@@. Your new Account Balance is @@balance@@\n\nThank You'),
(3, 'notifications_fund_wallet_sms_enabled', '0'),
(3, 'notifications_password_reset_mail_title', 'PASSWORD RESET'),
(3, 'notifications_password_reset_mail', 'Dear @@fname@@,<br>Your have requested for a password reset:<br><br>Your reset code is @@code@@<br><BR>\nOr simply click on this link below<br>@@link@@'),
(3, 'notifications_password_reset_mail_enabled', '0'),
(3, 'notifications_password_reset_sms_title', 'PASSWORD RESET'),
(3, 'notifications_password_reset_sms', 'Dear @@fname@@,\nYour have requested for a password reset:\n\nYour reset code is @@code@@\n\nOr simply click on this link below\n@@link@@'),
(3, 'notifications_password_reset_sms_enabled', '0'),
(3, 'notifications_missed_you_mail_title', 'ITS BEEN A WHILE'),
(3, 'notifications_missed_you_mail', 'Dear @@fname@@,<br>Long Time, Its been a while. We have really missed you. We have added more features, why dont you visit us again to see for yourself. <br>Thank You'),
(3, 'notifications_missed_you_mail_day', '7'),
(3, 'notifications_missed_you_mail_enabled', '0'),
(3, 'notifications_missed_you_sms_title', 'ITS BEEN A WHILE'),
(3, 'notifications_missed_you_sms', 'Dear @@fname@@,\nLong Time, Its been a while. We have really missed you. We have added more features, why dont you visit us again to see for yourself. \nThank You'),
(3, 'notifications_missed_you_sms_day', '7'),
(3, 'notifications_missed_you_sms_enabled', '1'),
(2, 'default_dnd_gateway', '15'),
(2, 'default_gateway', '15'),
(2, 'payment_gateway_settings_atm_paystack_method', ''),
(2, 'notifications_fund_wallet_sms', 'Dear @@fname@@,\nYour account has been credited with @@amount@@. Your new Account Balance is @@balance@@\n\nThank You'),
(2, 'notifications_fund_wallet_sms_enabled', '0'),
(2, 'notifications_password_reset_mail_title', 'PASSWORD RESET'),
(2, 'notifications_fund_wallet_mail_enabled', '0'),
(2, 'notifications_fund_wallet_sms_title', 'ACCOUNT CREDITED'),
(2, 'notifications_fund_wallet_mail_title', 'ACCOUNT CREDITED'),
(2, 'notifications_fund_wallet_mail', 'Dear @@fname@@,<br>Your account has been credited:<br><br>\nPrevious Balance: @@p_balance@@<br>\nAmount Paid: @@amount@@<br>\nTransaction Fee: @@transaction_fee@@<br>\n<b>Amount Credited: @@amount_credited@@</b><br>\nAccount Balance @@balance@@<br><br>\nThank You'),
(2, 'notifications_registration_sms_enabled', '0'),
(2, 'payment_gateway_settings_bitcoin_bitcoin_my_secret_key', 'HER5vXo2u8'),
(2, 'notifications_registration_mail_title', 'WELCOME'),
(2, 'notifications_registration_mail', '<b>WELCOME @@fname@@</b> TO @@site_name@@<br>\nYour account registration was successful.<br>\nUsername: @@username@@<br>\nPassword: @@password@@\nThank you for your registration'),
(2, 'notifications_registration_mail_enabled', '1'),
(2, 'notifications_registration_sms_title', 'WELCOME'),
(2, 'notifications_registration_sms', 'WELCOME @@fname@@ TO @@site_name@@\n\nYour account registration was successful.\n\nUsername: @@username@@\n\nPassword: @@password@@\nThank you for your registration'),
(2, 'default_dnd_rate', '24'),
(2, 'frontend_menu', '[{\"item_id\":\"menu_menu_menu_menu_menu_4110301.2725659395\",\"parent_id\":\"0\",\"label\":\"Welcome\",\"link\":\"home#welcome\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_33623254.792428516\",\"parent_id\":\"0\",\"label\":\"FAQ\",\"link\":\"home#faq\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_14356114.888448834\",\"parent_id\":\"0\",\"label\":\"Dashboard\",\"link\":\"admin\\/dashboard\",\"show\":\"login\"},{\"item_id\":\"menu_menu_menu_menu_menu_29324517.29696356\",\"parent_id\":\"0\",\"label\":\"Reseller\",\"link\":\"page\\/reseller\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_51035539.52870905\",\"parent_id\":\"0\",\"label\":\"Contact Us\",\"link\":\"home#contact\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_29096322.505061112\",\"parent_id\":\"0\",\"label\":\"Price List\",\"link\":\"page\\/price\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_34209151.55479311\",\"parent_id\":\"0\",\"label\":\"Home Page\",\"link\":\"home\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_57185285.682134636\",\"parent_id\":\"0\",\"label\":\"About Us\",\"link\":\"home#about\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_menu_77850078.44537276\",\"parent_id\":\"0\",\"label\":\"Logout\",\"link\":\"login\\/logout\",\"show\":\"login\"},{\"item_id\":\"menu_menu_menu_menu_menu_3197921.6095243148\",\"parent_id\":\"0\",\"label\":\"Register\",\"link\":\"login\\/register\",\"show\":\"logout\"},{\"item_id\":\"menu_menu_menu_menu_menu_25926266.92391743\",\"parent_id\":\"0\",\"label\":\"Login\",\"link\":\"login\",\"show\":\"logout\"},{\"item_id\":\"menu_menu_menu_72458288.92517023\",\"parent_id\":\"0\",\"label\":\"API\",\"link\":\"page\\/api\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_33788405.96519032\",\"parent_id\":\"0\",\"label\":\"Price List\",\"link\":\"page\\/price\",\"show\":\"all\"},{\"item_id\":\"menu_menu_46677838.973205894\",\"parent_id\":\"0\",\"label\":\"Affiliate\",\"link\":\"page\\/22\",\"show\":\"all\"}]'),
(2, 'current_frontend_theme', 'default'),
(2, 'theme_default_site_name', ''),
(2, 'theme_default_description1', ''),
(2, 'theme_default_site_address', ''),
(2, 'theme_default_welcome_title', 'WELCOME'),
(2, 'theme_default_welcome_content', '<p><br></p><h2>BULK SMS</h2><p>\n      <br></p><p>\n       We offer bulk SMS at the cheapest price to all Nigerians on this \nbulk SMS website. We assure you that you SMS will be sent though the \nmost reliable and fastest bulk SMS gateway which has been serving our \nnumerous bulk SMS clients across Nigeria. We sell the cheapest bulk SMS \nin Nigeria without compromising the quality of our bulk SMS delivery \nwith our focus been on delivery speed. We don\'t just offer cheap bulk \nSMS in Nigeria but we offer fast, reliable and cheapest bulk SMS in \nNigeria which all our satisfied bulk SMS users can attest to.\n\nOur system is simple to navigate and we render effective, affordable and\n reliable bulk SMS services. Try us TODAY and you will definitely not \nregret it.\n\nWe offer you the cheapest bulk sms in Nigeria.   \n          \n      </p><p><br></p>'),
(2, 'theme_default_faq_content', '<p><a class=\"ewd-ufaq-post-margin\" href=\"https://loftysms.com/blog/ufaqs/i-input-number-twice-will-sms-get-delivered-contact-twice/\"></a></p><div class=\"ufaq-faq-title-text\"><h4 itemprop=\"name\">IF I INPUT A NUMBER TWICE, WILL SMS GET DELIVERED TO SUCH CONTACT TWICE?</h4></div><p></p><div class=\"ufaq-faq-body ufaq-body-449\" id=\"ufaq-body-1zp-449-0\" itemprop=\"suggestedAnswer acceptedAnswer\" itemscope=\"\" itemtype=\"http://schema.org/Answer\"><div class=\"ewd-ufaq-post-margin ufaq-faq-post\" id=\"ufaq-post-449\" itemprop=\"text\"><p>No, the system automatically removes one of the number once sms is sent.</p>\n</div><div class=\"ufaq-faq-categories\" id=\"ufaq-categories-449\"><br></div></div><div class=\"ufaq-faq-div ufaq-faq-display-style-Default ewd-ufaq-post-active\" id=\"ufaq-post-1zp-446-3\" data-postid=\"1zp-446-3\" itemscope=\"\" itemtype=\"http://schema.org/Question\"><div class=\"ufaq-faq-title ufaq-faq-toggle\" id=\"ufaq-title-446\" data-postid=\"1zp-446-3\"><div class=\"ufaq-faq-title-text\"><h4 itemprop=\"name\">CAN I SEND PERSONALIZE MESSAGE ON YOUR PLATFORM?</h4></div></div><div class=\"ufaq-faq-body ufaq-body-446\" id=\"ufaq-body-1zp-446-3\" itemprop=\"suggestedAnswer acceptedAnswer\" itemscope=\"\" itemtype=\"http://schema.org/Answer\"><div class=\"ewd-ufaq-post-margin ufaq-faq-post\" id=\"ufaq-post-446\" itemprop=\"text\"><p>Yes, you can send personalize SMS on our platform. Please visit <a href=\"http://www.smswise.com\">www.smswise.com</a> &nbsp;for more detail</p>\n</div><div class=\"ufaq-faq-categories\" id=\"ufaq-categories-446\"><br></div></div></div><div class=\"ufaq-faq-div ufaq-faq-display-style-Default ewd-ufaq-post-active\" id=\"ufaq-post-1zp-444-5\" data-postid=\"1zp-444-5\" itemscope=\"\" itemtype=\"http://schema.org/Question\"><div class=\"ufaq-faq-title ufaq-faq-toggle\" id=\"ufaq-title-444\" data-postid=\"1zp-444-5\"><div class=\"ufaq-faq-title-text\"><h4 itemprop=\"name\">HOW CAN I SAVE NUMBERS ON YOUR PLATFORM?</h4></div></div><div class=\"ufaq-faq-body ufaq-body-444\" id=\"ufaq-body-1zp-444-5\" itemprop=\"suggestedAnswer acceptedAnswer\" itemscope=\"\" itemtype=\"http://schema.org/Answer\"><div class=\"ewd-ufaq-post-margin ufaq-faq-post\" id=\"ufaq-post-444\" itemprop=\"text\"><p>Yes,\n you can save as many numbers on our platform. You can do this by saving\n your contact on Phonebook. Click “Phonebook” on your dashboard and \nclick on <strong>Create Phonebook</strong>.</p>\n<p><br></p></div></div></div><div class=\"ufaq-faq-div ufaq-faq-display-style-Default ewd-ufaq-post-active\" id=\"ufaq-post-1zp-443-6\" data-postid=\"1zp-443-6\" itemscope=\"\" itemtype=\"http://schema.org/Question\"><div class=\"ufaq-faq-title ufaq-faq-toggle\" id=\"ufaq-title-443\" data-postid=\"1zp-443-6\"><div class=\"ufaq-faq-title-text\"><h4 itemprop=\"name\">DO YOU PROVIDE DELIVERY REPORTS FOR THE MESSAGES?</h4></div></div><div class=\"ufaq-faq-body ufaq-body-443\" id=\"ufaq-body-1zp-443-6\" itemprop=\"suggestedAnswer acceptedAnswer\" itemscope=\"\" itemtype=\"http://schema.org/Answer\"><div class=\"ewd-ufaq-post-margin ufaq-faq-post\" id=\"ufaq-post-443\" itemprop=\"text\"><p>All messages will show a status report whether successfully delivered or not. click to see detailed report&nbsp;</p><p><br></p></div></div></div><div class=\"ufaq-faq-div ufaq-faq-display-style-Default\" id=\"ufaq-post-1zp-442-7\" data-postid=\"1zp-442-7\" itemscope=\"\" itemtype=\"http://schema.org/Question\"><div class=\"ufaq-faq-title ufaq-faq-toggle\" id=\"ufaq-title-442\" data-postid=\"1zp-442-7\"><div class=\"ufaq-faq-title-text\"><h4 itemprop=\"name\">DOES YOU PLATFORM SUPPORT MESSAGE SCHEDULING?</h4></div></div></div><p>Yes before the send button you can schedule your message for future delivery&nbsp;</p><div class=\"ufaq-faq-div ufaq-faq-display-style-Default ewd-ufaq-post-active\" id=\"ufaq-post-1zp-441-8\" data-postid=\"1zp-441-8\" itemscope=\"\" itemtype=\"http://schema.org/Question\"><div class=\"ufaq-faq-title ufaq-faq-toggle\" id=\"ufaq-title-441\" data-postid=\"1zp-441-8\"><div class=\"ufaq-faq-title-text\"><h4 itemprop=\"name\">HOW MANY SMS’S CAN I SEND AT A TIME?</h4></div></div><div class=\"ufaq-faq-body ufaq-body-441\" id=\"ufaq-body-1zp-441-8\" itemprop=\"suggestedAnswer acceptedAnswer\" itemscope=\"\" itemtype=\"http://schema.org/Answer\"><div class=\"ewd-ufaq-post-margin ufaq-faq-post\" id=\"ufaq-post-441\" itemprop=\"text\"><p>There is no limit to the number of SMS that can be sent by users on our platform at a time. Users are able to send SMS to thousands&nbsp;of numbers at a time.</p>\n</div><div class=\"ufaq-faq-categories\" id=\"ufaq-categories-441\"><br></div></div></div><div class=\"ufaq-faq-div ufaq-faq-display-style-Default ewd-ufaq-post-active\" id=\"ufaq-post-1zp-439-9\" data-postid=\"1zp-439-9\" itemscope=\"\" itemtype=\"http://schema.org/Question\"><div class=\"ufaq-faq-title ufaq-faq-toggle\" id=\"ufaq-title-439\" data-postid=\"1zp-439-9\"><div class=\"ufaq-faq-title-text\"><h4 itemprop=\"name\">HOW MANY CHARACTERS ARE THERE IN ONE SMS?</h4></div></div><div class=\"ufaq-faq-body ufaq-body-439\" id=\"ufaq-body-1zp-439-9\" itemprop=\"suggestedAnswer acceptedAnswer\" itemscope=\"\" itemtype=\"http://schema.org/Answer\"><div class=\"ewd-ufaq-post-margin ufaq-faq-post\" id=\"ufaq-post-439\" itemprop=\"text\"><p>There\n are 160 characters in one SMS/Page, which translates into 1 Unit. You \ncan send up to 1600 characters but this will translate into 10 \nSMS’s/Pages/Units.</p>\n</div><div class=\"ufaq-faq-categories\" id=\"ufaq-categories-439\"><br></div></div></div><div class=\"ufaq-faq-div ufaq-faq-display-style-Default ewd-ufaq-post-active\" id=\"ufaq-post-1zp-440-10\" data-postid=\"1zp-440-10\" itemscope=\"\" itemtype=\"http://schema.org/Question\"><div class=\"ufaq-faq-title ufaq-faq-toggle\" id=\"ufaq-title-440\" data-postid=\"1zp-440-10\"><div class=\"ufaq-faq-title-text\"><h4 itemprop=\"name\">AFTER BANK PAYMENT, WHAT DO I DO TO GET MY ACCOUNT CREDITED?</h4></div></div><div class=\"ufaq-faq-title ufaq-faq-toggle\" id=\"ufaq-title-434\" data-postid=\"1zp-434-11\"><div class=\"ewd-ufaq-post-margin ufaq-faq-post\" id=\"ufaq-post-440\" itemprop=\"text\"><div class=\"chat-body custom-scroll scrollable-view\">\n<div class=\"chat-table-wrapper\">\n<div class=\"chat-row-wrapper\">\n<div class=\"chat-wrapper\">\n<div class=\"chat-content padding-10\">\n<div class=\"conversation-block\">\n<div class=\"conversation-content\">\n<p>You fill your payment details on the <strong>M</strong><strong>ake Payment</strong> menu on the dashboard immediately after bank payment and confirm your order, after this your account get credited immediately.</p>\n</div>\n</div>\n\n</div>\n</div>\n</div>\n</div>\n</div>\n\n</div><span class=\"ewd-ufaq-post-margin\"><div class=\"ufaq-faq-title-text\"><h4 itemprop=\"name\">HOW DO I BUY UNITS?</h4></div></span></div></div><div class=\"ufaq-faq-div ufaq-faq-display-style-Default ewd-ufaq-post-active\" id=\"ufaq-post-1zp-434-11\" data-postid=\"1zp-434-11\" itemscope=\"\" itemtype=\"http://schema.org/Question\"><div class=\"ufaq-faq-title ufaq-faq-toggle\" id=\"ufaq-title-433\" data-postid=\"1zp-433-12\"><div class=\"ewd-ufaq-post-margin ufaq-faq-post\" id=\"ufaq-post-434\" itemprop=\"text\"><p>You can purchase Units online via Mobile Transfer, ATM card or Direct Bank Deposit. Click <a href=\"http://smswise.com/price.php\"><strong>HERE</strong></a>&nbsp;for more details on Unit purchase.</p>\n</div><span class=\"ewd-ufaq-post-margin\"><div class=\"ufaq-faq-title-text\"><h4 itemprop=\"name\">HOW MUCH DOES SMS UNIT COST?</h4></div></span></div></div><div class=\"ufaq-faq-div ufaq-faq-display-style-Default ewd-ufaq-post-active\" id=\"ufaq-post-1zp-433-12\" data-postid=\"1zp-433-12\" itemscope=\"\" itemtype=\"http://schema.org/Question\"><div class=\"ufaq-faq-title ufaq-faq-toggle\" id=\"ufaq-title-430\" data-postid=\"1zp-430-13\"><div class=\"ewd-ufaq-post-margin ufaq-faq-post\" id=\"ufaq-post-433\" itemprop=\"text\"><p>Please view our <a href=\"http://smswise.com/price.php\"><strong>Pricing page</strong></a>\n for accurate costs. If you buy more you pay less! There are no setup \nfees, monthly fees or any other additional fees. We operate on a prepaid\n basis. The Units that you buy does not expire.</p>\n</div><span class=\"ewd-ufaq-post-margin\"><div class=\"ufaq-faq-title-text\"><h4 itemprop=\"name\">HOW DO I LOGIN?</h4></div></span></div></div><div class=\"ufaq-faq-div ufaq-faq-display-style-Default ewd-ufaq-post-active\" id=\"ufaq-post-1zp-430-13\" data-postid=\"1zp-430-13\" itemscope=\"\" itemtype=\"http://schema.org/Question\"><div class=\"ufaq-faq-body ufaq-body-430\" id=\"ufaq-body-1zp-430-13\" itemprop=\"suggestedAnswer acceptedAnswer\" itemscope=\"\" itemtype=\"http://schema.org/Answer\"><div class=\"ewd-ufaq-post-margin ufaq-faq-post\" id=\"ufaq-post-430\" itemprop=\"text\"><p>Enter your ‘Username or Email’ and ‘Password’. These are both&nbsp;<strong>case sensitive</strong>. Click “Login” to access your home page.</p>\n\n</div><br></div></div><div class=\"ufaq-faq-div ufaq-faq-display-style-Default ewd-ufaq-post-active\" id=\"ufaq-post-1zp-428-14\" data-postid=\"1zp-428-14\" itemscope=\"\" itemtype=\"http://schema.org/Question\"><div class=\"ufaq-faq-title ufaq-faq-toggle\" id=\"ufaq-title-428\" data-postid=\"1zp-428-14\"><span class=\"ewd-ufaq-post-margin\"><div class=\"ufaq-faq-title-text\"><h4 itemprop=\"name\">HOW CAN I REGISTER?</h4></div></span></div><div class=\"ufaq-faq-title ufaq-faq-toggle\" id=\"ufaq-title-421\" data-postid=\"1zp-421-15\"><div class=\"ewd-ufaq-post-margin ufaq-faq-post\" id=\"ufaq-post-428\" itemprop=\"text\"><p>Registering your Bulk SMS account with <a href=\"http://smswise.com/\">smswise.com</a> is free and takes only a few minutes. You will also gain 03 FREE SMS Unit. Click <strong><a href=\"http://smswise.com/?do=signup\">HERE</a></strong> or click the <a href=\"http://smswise.com/?do=signup\"><strong>SIGN UP FREE</strong></a>\n button on the homepage. Please note that all fields must be completed \nin order to register successfully and that the Username and Password \nfields are Case Sensitive.</p>\n<p>Once you have entered the information correctly, click <strong>“Register”</strong>\n and you will be able to logon into smswise. <br></p>\n</div><span class=\"ewd-ufaq-post-margin\"><div class=\"ufaq-faq-title-text\"><h4 itemprop=\"name\">HOW LONG HAVE YOU BEEN OPERATING?</h4></div></span></div></div><div class=\"ufaq-faq-div ufaq-faq-display-style-Default ewd-ufaq-post-active\" id=\"ufaq-post-1zp-421-15\" data-postid=\"1zp-421-15\" itemscope=\"\" itemtype=\"http://schema.org/Question\"><div class=\"ufaq-faq-body ufaq-body-421\" id=\"ufaq-body-1zp-421-15\" itemprop=\"suggestedAnswer acceptedAnswer\" itemscope=\"\" itemtype=\"http://schema.org/Answer\"><div class=\"ewd-ufaq-post-margin ufaq-faq-post\" id=\"ufaq-post-421\" itemprop=\"text\"><p style=\"background: white; margin: 0in 0in 15.0pt 0in;\"><span style=\"color: #333333;\">Established in 2014, we have been operating and growing for 4 years with thousands of users all over the world.</span></p>\n</div></div></div><p><br></p>'),
(10, 'member_permission', 'send_bulk_sms,send_free_sms,message_history,draft,schedule,manage_phonebook,buy_airtime,buy_dataplan,dstv_bill,gotv_bill,startimes_bill,fund_wallet,transfer_fund,transfer_to_bank,view_bill_history'),
(8, 'member_permission', 'send_bulk_sms,send_free_sms,message_history,draft,schedule,manage_phonebook,buy_airtime,buy_dataplan,dstv_bill,gotv_bill,startimes_bill,fund_wallet,transfer_fund,transfer_to_bank,view_bill_history'),
(2, 'theme_default_about_us_content', 'smswise is a subsidiary of LIGHTWAY TECHNOLOGY (BN 2489921). This facet of the network deals with Mobile Solutions and Bulk\n Messaging.<p>\n<br></p><p>Our key differentiator is our customer satisfaction and&nbsp;intimacy \npositioning. We strongly believe that you DO NOT need our services just \nto send SMS but <strong>to convey urgent and life-impacting messages</strong>. We take our work seriously and not ourselves because <strong>we are not the message but just a medium</strong>.</p><p>\n<br></p><p>To fulfill our role, we work to make the accessibility, usability and\n renewability of our service as simple as ABC. This we do by constantly \nlistening to you and developing creative solutions to meet your needs.</p><p><br></p>'),
(2, 'theme_default_company_email', ''),
(2, 'theme_default_domain_name', ''),
(2, 'theme_default_facebook_link', ''),
(2, 'theme_default_image1', ''),
(2, 'theme_default_image2', ''),
(2, 'theme_default_image3', '');
INSERT INTO `settings` (`owner`, `type`, `description`) VALUES
(2, 'theme_default_api', '<section id=\'error\' class=\'container\'><h2 align=\"center\"\n                                          style=\"color: red; font-size: 26px; margin: 0px 0px 25px; padding: 5px 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">\n		API</h2>\n\n	<p style=\"margin-bottom: 10px; padding: 0px;  Geneva, sans-serif; letter-spacing: normal;\">You\n		can interface an application, website or system with our messaging gateway by using our very flexible HTTP API\n		connection. Once you\'re connected, you\'ll be able send sms, check account balance, get deliver reports and sent\n		messages or check your balance.</p>\n\n	<h3 align=\"\"\n	    style=\"color: red; font-weight: bold; font-size: 15px; margin: 30px 0px 5px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">\n		CONNECTION METHOD</h3>\n\n	<div align=\"left\" class=\"payment\"\n	     style=\"display: inline; size: 60px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">\n		\n		<br><b>SPC API</b>&nbsp;http://smswise.com/api/sendsms.php?username=yourUsername&amp;password=yourPassword&amp;sender=@@sender@@&amp;message=@@message@@&amp;recipient=@@recipient@@\n		<hr>\n		<p style=\"margin-bottom: 10px; padding: 0px;\"><a href=\"https://sms.quickhostme.com/api/#atm\"\n		                                                 style=\"color: rgb(8, 174, 227); display: block; size: 24px;\">GET\n				METHOD</a><a href=\"https://sms.quickhostme.com/api/#get\"\n		                     style=\"color: rgb(8, 174, 227); display: block; size: 24px;\">POST METHOD</a></p></div>\n	<p><span style=\"font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\"></span></p>\n	<blockquote\n		style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">\n		<span class=\"h_api\" style=\"font-size: 18px;\">GET METHOD</span>\n\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Connect to send single or multiple sms messages through the\n			following api url:<span style=\"color: rgb(0, 85, 128);\">http://smswise.com				/api/sendsms.php?username=user&amp;password=1234&amp;sender=quicsms1&amp;message=testing&amp;recipient=2348030000000,23480xxxxxxxx&amp;report=1&amp;convert=1&amp;route=1</span>\n		</p><span class=\"h_api\" style=\"font-size: 18px;\">POST METHOD</span>\n\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Use this method to send sms messages where the length of \"GET\n			METHOD\" is a limitation,<br>url:&nbsp;<span style=\"color: rgb(0, 85, 128);\">http://smswise.com/api/sendsms.php</span>&nbsp;<br>Data\n			to post: username=user&amp;password=1234&amp;sender=quicsms1&amp;message=testing &amp;recipient=2348030000000,23480xxxxxxxx&amp;report=1&amp;convert=1&amp;route=1\n		</p>\n\n		<hr>\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. recipient : The destination phone numbers. Separate multiple\n			numbers with comma(,)<br>3. username: Your BULKSMS account username<br>4. password: Your BULKSMS account\n			password<br>5. sender: The sender ID to show on the receiver\'s phone<br>6. message: The text message to be\n			sent<br>7. balance: Set to \'true\' only when you want to check your credit balance<br>6. schedule: Specify\n			this parameter only when you are scheduling an sms for later delivery. It should contain the date the\n			message should be delivered. Supported format is \"2010-10-01 12:30:00\" i.e \"YYYY-MM-DD HH:mm:ss\"<br>7.\n			convert: Specify and set this parameter to 1 only when you want to get the return code in string readable\n			format instead of the raw numbers below;<br>8. report: Set this parameter to 1 to retrieve the message id\n			which can later be used to retrieve the delivery report or else remove it or set it to 0<br>9. route: Set\n			this parameter to&nbsp;<b>0</b>&nbsp;to send message using the normal route (Will not deliver to DND\n			numbers). Set to&nbsp;<b>1</b>&nbsp;to send through normal route for numbers not on DND and send through\n			banking route for numbers on DND. Set to&nbsp;<b>2</b>&nbsp;to send all messages through the banking route.\n		</div>\n		<div class=\"t_api\"><br>The return values are:<br>OK = Successful<br>1 = Invalid Recipient(s) Number<br>2 = Cant\n			send Empty Message<br>3 = Invalid Sender ID<br>4 = Insufficient Balance<br>5 = Incorrect Username or\n			Password Specified<br>6 = Incorrect schedule date format<br>7 = Error sending message (Gateway not\n			available), Please try again later<br><br>Example:<br>On success, the following code will be returned<br>OK\n			21 = 4564<br><br>i.e \'OK\' \'No of sms credits used\' = \'Unique Message ID\'&nbsp;<br>where OK = The message was\n			sent successfully<br>21 = No of sms credits used<br>and 4564 = The unique message id of the sent message\n			which can be used to retrieve the delivery status of the sent message.\n		</div>\n		<span style=\"color: red;\">Note: When using GET METHOD to send message, the values should be properly encoded before sending it to our server</span>\n		<hr>\n		<br><span class=\"h_api\" style=\"font-size: 18px;\">CHECK ACCOUNT BALANCE</span>\n\n		<p style=\"margin-bottom: 10px; padding: 0px;\">You can use GET or POST METHOD to query your BULKSMS account\n			balance.<span style=\"color: rgb(0, 85, 128);\">http://smswise.com/api/sendsms.php?username=user&amp;password=1234&amp;balance=1</span>\n		</p>\n\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. username: Your BULKSMS account username<br>2. password:\n			Your BULKSMS account password<br>3. balance: This most be included to inform our server that you want to\n			only check your account balance<br></div>\n		<br>\n\n		<div class=\"t_api\"><i>On successful, Your account balance would be returned e.g&nbsp;<b>5024</b></i></div>\n		<br>\n		<hr>\n		<span class=\"h_api\" style=\"font-size: 18px;\">DELIVERY REPORT</span>\n\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Use Get Method to query the delivery report/status of the sent\n			message using the message id.<span style=\"color: rgb(0, 85, 128);\">http://smswise.com/api/getdelivery.php?username=user&amp;password=1234&amp;msgid=4564</span>\n		</p>\n\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. username: Your BULKSMS account username<br>2. password:\n			Your BULKSMS account password<br>3. msgid: The message id of the sent message you want to retrieve the\n			delivery status<br>3. html: Only Set this parameter to 1, to return the report in colourful html table\n			format. e.g html=1<br></div>\n		<br>\n\n		<div class=\"t_api\">On success, the following code will be returned.<br><i>2349038781252=DELIVERED=2015/10/25\n				23:11:34, 2349055552635=SENT=----/--/-- --:--:--</i><br>i.e \'Number\' = \'Delivery Status\' = \'Date and\n			Time of delivery\'&nbsp;<br>where 2349038781252 = Phone number<br>DELIVERED = The message had delivered<br>2015/10/25\n			23:11:34 = The date and time the message was delivered.\n		</div>\n	</blockquote>\n</section>'),
(2, 'default_bill_rate', '9'),
(2, 'member_permission', 'send_bulk_sms,send_free_sms,message_history,draft,schedule,manage_phonebook,fund_wallet,transfer_fund,transfer_to_bank,view_bill_history,update_profile'),
(6, 'caddress', 'Office No. 2, White House ICT Complex, Tunga, Minna, Niger State'),
(2, 'theme_default_price', '<div style=\"width: 100%;\" align=\"center\">\n<h2><center>SMS PRICE</center></h2>\n<br>\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Volume</th>\n        <th><font color=\"#ffffff\">Price per SMS (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">All Network</td>\n        <td align=\"center\" style=\"padding: 3px;\">N2.00</td>\n    </tr>\n    </tbody>\n</table>\n\n<br>\n<h2><center>AIRTIME</center></h2>\n<br>\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Bundle</th>\n        <th><font color=\"#ffffff\">Price (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">MTN</td>\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Airtel</td>\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Glo</td>\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Etisalat</td>\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\n    </tr>\n    </tbody>\n</table><br>\n\n<h2><center>DATA PLAN</center></h2>\n<center style=\"color: red;\">Please login to check our current price</center>\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Network</th>\n        <th><font color=\"#ffffff\">Bundle &amp; Price (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">MTN</td>\n        <td align=\"center\" style=\"padding: 3px;\">\n            1GB for N650<br>\n            2GB for N1,300\n        </td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Airtel</td>\n        <td align=\"center\" style=\"padding: 3px;\">1.5GB for N1,100</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Glo</td>\n        <td align=\"center\" style=\"padding: 3px;\">1.6GB for N1,100</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Etisalat</td>\n        <td align=\"center\" style=\"padding: 3px;\">1GB for N1,100</td>\n    </tr>\n    </tbody>\n</table><br>\n<h2><center>BILL PAYMENT</center></h2>\n<br>\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Bill</th>\n        <th><font color=\"#ffffff\">Bundle &amp; Price (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">DSTV</td>\n        <td align=\"center\" style=\"padding: 3px;\">\n            DSTV Access = N19,500<br>\n            DSTV Family= N4,000<br>\n        </td>\n    </tr>\n\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">GoTv</td>\n        <td align=\"center\" style=\"padding: 3px;\">GoTv pack = N1,000</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Startimes</td>\n        <td align=\"center\" style=\"padding: 3px;\">Nova = N950</td>\n    </tr>\n    </tbody>\n</table>\n</div>\n\n'),
(2, 'theme_default_reseller', '<h2 align=\"left\" style=\"color: red; font-size: 26px; margin: 0px 0px 25px; padding: 5px 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">RESELLER SERVICES:</h2><div style=\"font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"><blockquote style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px;\"><strong>Features that your members will enjoy:</strong><br>- Robust registration form (different from joomla)<br>- Compose SMS with dynamic sender ID<br>- Type multiple sms recipients, select recipient group from phonebook or upload recipients from text and csv(excel) file<br>- SMS character counter for composing SMS i.e Page: 1, Characters left: 157, Total Typed Characters: 3<br>- SMS scheduling for future delivery with date picker.<br>- Duplicate number remover.<br>- Numbers can be in the format of&nbsp;<strong>+2348080000000 or 2348080000000 or 08080000000</strong>.<br>- Separate multiple numbers and uploaded numbers with comma, colon, semicolon or put each number on a separate line.<br>- Automatic removal of&nbsp;<strong>invalid characters from numbers</strong>&nbsp;e.g space,;,:,.,\',`,(,),,{,},#,-,_ and ?<br>- Displays member&nbsp;<strong>SMS units left and SMS Units used</strong><br>- Phone book to store phone groups and numbers<br>- Add multiple numbers to phone book group at once<br>- Upload numbers to phone group from file<br>- Delete a phone book group and all its records<br>- View to all sent sms messages with&nbsp;<strong>recipients, message,status, credit used, date scheduled, date delivered</strong><br>- Search and forward sent sms messages with page numbers and page size<br>- Order/Request/purchase sms credits with&nbsp;<strong>automatic cost calculator</strong><br>- Transaction/purchase history with&nbsp;<strong>Transaction date, amount, credit requested, status and date approved</strong><br>- Search and sort transaction history with page numbers and page size<br>- View personal details<br>- Change password on settings page<br>- Set default sender ID<br>- Members can&nbsp;<strong>transfer SMS units</strong>&nbsp;to another member</blockquote></div><div class=\"cleaner\" style=\"clear: both; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"></div><blockquote style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"><strong>Admin Features:</strong><br>- Send sms to all members<br>- Specify No of free SMS units for new members e.g new members get 3 free sms<br>- Specify how many sms units is regarded as low sms<br>- Alert member by sms and email when credit is below your specified level<br>- Specify captcha type(local captcha or google recaptcha)<br>- Create/edit Welcome SMS message for new members<br>- Create/edit SMS to send to members when their SMS orders have been approved<br>- Create/edit SMS to send to members when their credit is below your specified level<br>- Create/edit Welcome Email<br>- Create/edit Email to send to members when orders have been approved<br>- Create/edit Email to send to members when their credit is below ur specified level<br>- Set/change SMS API Gateway URL to any provider<br>- Create/edit Selling price per sms unit for different quantity of sms purchases<br>- Specify county codes that use more that 1 sms unit per text message<br>- Set/edit No of records to display per page on member and admin pages<br>- You\'ll get your own SMS Api to Give to your own customers and resellers.<br>- You\'ll get SMS Cron Url for scheduled sms (If you want to add your own cron job for scheduled sms)- Export all phone numbers that have ever recieved sms from you portal and your resellers in one click<br>- Export all phone numbers of all members in one click<br>- Export all phone numbers in member phone books in one click<br>- Admin view of all address book records and groups<br>- Admin view of all sms messages sent by members, resellers or through api<br>- Admin view of all transactions for viewing, approval, cancelliung or deletion<br>- Automatically credits member sms account upon approval of sms request transaction<br>- View, edit and delete any member account<br>- Manually reduce/increase any member account SMS units<br>- Registration cannot be repeated for registered phone number/email address<br>- Free GSM Phone Number generator<br>- Contact us form<br>- User Management&nbsp;<br>-&nbsp;<strong>And many more</strong></blockquote><div class=\"cleaner\" style=\"clear: both; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"></div><p style=\"margin-bottom: 10px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\"></p><div id=\"pay\" style=\"font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">To become a&nbsp;<strong>Reseller</strong>&nbsp;and start making profit online immediately, Please register as a normal member</div>'),
(2, 'theme_default_submit', '\n													   Save\n												'),
(7, 'cname', ''),
(7, 'caddress', 'Demo'),
(7, 'cemail', 'demo@demo.com'),
(7, 'cphone', ''),
(7, 'website', 'demo.quickmx.com'),
(7, 'site_name', 'Demo Site'),
(7, 'currency', 'N'),
(7, 'currency_suffix', ''),
(7, 'default_gateway', 'reseller'),
(7, 'default_dnd_gateway', 'reseller'),
(7, 'payment_method_status', '{\"bank\":1,\"internet\":1,\"atm\":1,\"mobile\":1}'),
(7, 'payment_gateway_settings_atm_paystack_secret_key', ''),
(7, 'payment_gateway_settings_atm_paystack_public_key', ''),
(7, 'payment_gateway_settings_atm_paystack_transaction_fee', ''),
(7, 'payment_gateway_settings_atm_paystack_method', ''),
(7, 'payment_gateway_settings_atm_paystack_enabled', ''),
(7, 'payment_gateway_settings_atm_voguepay_merchant_id', ''),
(7, 'payment_gateway_settings_atm_voguepay_transaction_fee', ''),
(7, 'payment_gateway_settings_atm_voguepay_enabled', ''),
(7, 'payment_gateway_settings_bitcoin_bitcoin_key', ''),
(7, 'payment_gateway_settings_bitcoin_bitcoin_xpub', ''),
(7, 'payment_gateway_settings_bitcoin_bitcoin_conversion', ''),
(7, 'payment_gateway_settings_bitcoin_bitcoin_confirmation', ''),
(7, 'payment_gateway_settings_bank_accounts', 'FIRST BANK=2030322404=QUICKTEL SOLUTION'),
(7, 'payment_gateway_settings_internet_accounts', 'FIRST BANK=2030322404=QUICKTEL SOLUTION'),
(7, 'payment_gateway_settings_mobile_accounts', 'FIRST BANK=2030322404=QUICKTEL SOLUTION'),
(7, 'payment_gateway_settings_airtime_accounts', 'FIRST BANK=2030322404=QUICKTEL SOLUTION'),
(7, 'payment_gateway_settings_bank_detail', ''),
(7, 'payment_gateway_settings_internet_detail', ''),
(7, 'payment_gateway_settings_mobile_detail', ''),
(7, 'payment_gateway_settings_airtime_network', ''),
(7, 'payment_gateway_settings_airtime_detail', ''),
(7, 'payment_gateway_settings_airtime_transaction_fee', ''),
(7, 'payment_gateway_settings_airtime_email', ''),
(7, 'default_rate', '16'),
(7, 'default_dnd_rate', '17'),
(7, 'default_bill_rate', '5'),
(7, 'theme_login_bg_color1', '#00ffff'),
(7, 'theme_login_bg_color2', '#800040'),
(7, 'theme_login_header_text_color', '#ffffff'),
(7, 'current_frontend_theme', 'default'),
(7, 'frontend_menu', '[{\"item_id\":\"menu_46660524.56709623\",\"parent_id\":\"0\",\"label\":\"Home Page\",\"link\":\"home\"},{\"item_id\":\"menu_6315376.767687812\",\"parent_id\":\"0\",\"label\":\"Price List\",\"link\":\"page\\/price\"},{\"item_id\":\"menu_56930514.83944469\",\"parent_id\":\"0\",\"label\":\"Reseller\",\"link\":\"page\\/reseller\"},{\"item_id\":\"menu_7319082.540199649\",\"parent_id\":\"0\",\"label\":\"Login\",\"link\":\"login\",\"show\":\"logout\"},{\"item_id\":\"menu_32290449.303907424\",\"parent_id\":\"0\",\"label\":\"Register\",\"link\":\"login\\/register\",\"show\":\"logout\"},{\"item_id\":\"menu_17016905.830056127\",\"parent_id\":\"0\",\"label\":\"Logout\",\"link\":\"login\\/logout\",\"show\":\"login\"},{\"item_id\":\"menu_60312003.40549461\",\"parent_id\":\"0\",\"label\":\"Dashboard\",\"link\":\"admin\\/dashboard\",\"show\":\"login\"}]'),
(7, 'theme_default_site_name', 'Demo'),
(7, 'theme_default_description1', 'demo'),
(7, 'theme_default_site_address', 'demo'),
(7, 'theme_default_welcome_title', 'Welcome To Our Demo Site'),
(7, 'theme_default_welcome_content', '<p>This is demo content that can be edited by admin</p>'),
(7, 'theme_default_faq_content', '<p><span style=\"letter-spacing: 0.1px;\">This is demo content that can be edited by admin</span><br></p>'),
(7, 'theme_default_about_us_content', '<p><span style=\"letter-spacing: 0.1px;\">This is demo content that can be edited by admin</span><br></p>'),
(7, 'theme_default_company_email', ''),
(7, 'theme_default_domain_name', ''),
(7, 'theme_default_facebook_link', ''),
(7, 'theme_default_image2', ''),
(7, 'theme_default_image3', ''),
(7, 'theme_default_api', '<section id=\'error\' class=\'container\'><h2 align=\"center\"\r\n                                          style=\"color: red; font-size: 26px; margin: 0px 0px 25px; padding: 5px 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">\r\n		API</h2>\r\n\r\n	<p style=\"margin-bottom: 10px; padding: 0px;  Geneva, sans-serif; letter-spacing: normal;\">You\r\n		can interface an application, website or system with our messaging gateway by using our very flexible HTTP API\r\n		connection. Once you\'re connected, you\'ll be able send sms, check account balance, get deliver reports and sent\r\n		messages or check your balance.</p>\r\n\r\n	<h3 align=\"\"\r\n	    style=\"color: red; font-weight: bold; font-size: 15px; margin: 30px 0px 5px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">\r\n		CONNECTION METHOD</h3>\r\n\r\n	<div align=\"left\" class=\"payment\"\r\n	     style=\"display: inline; size: 60px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">\r\n		\r\n		<br><b>SPC API</b>&nbsp;http://demo.quickmx.com/api/sendsms.php?username=yourUsername&amp;password=yourPassword&amp;sender=@@sender@@&amp;message=@@message@@&amp;recipient=@@recipient@@\r\n		<hr>\r\n		<p style=\"margin-bottom: 10px; padding: 0px;\"><a href=\"https://sms.quickhostme.com/api/#atm\"\r\n		                                                 style=\"color: rgb(8, 174, 227); display: block; size: 24px;\">GET\r\n				METHOD</a><a href=\"https://sms.quickhostme.com/api/#get\"\r\n		                     style=\"color: rgb(8, 174, 227); display: block; size: 24px;\">POST METHOD</a></p></div>\r\n	<p><span style=\"font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\"></span></p>\r\n	<blockquote\r\n		style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">\r\n		<span class=\"h_api\" style=\"font-size: 18px;\">GET METHOD</span>\r\n\r\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Connect to send single or multiple sms messages through the\r\n			following api url:<span style=\"color: rgb(0, 85, 128);\">http://demo.quickmx.com				/api/sendsms.php?username=user&amp;password=1234&amp;sender=quicsms1&amp;message=testing&amp;recipient=2348030000000,23480xxxxxxxx&amp;report=1&amp;convert=1&amp;route=1</span>\r\n		</p><span class=\"h_api\" style=\"font-size: 18px;\">POST METHOD</span>\r\n\r\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Use this method to send sms messages where the length of \"GET\r\n			METHOD\" is a limitation,<br>url:&nbsp;<span style=\"color: rgb(0, 85, 128);\">http://demo.quickmx.com/api/sendsms.php</span>&nbsp;<br>Data\r\n			to post: username=user&amp;password=1234&amp;sender=quicsms1&amp;message=testing &amp;recipient=2348030000000,23480xxxxxxxx&amp;report=1&amp;convert=1&amp;route=1\r\n		</p>\r\n\r\n		<hr>\r\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. recipient : The destination phone numbers. Separate multiple\r\n			numbers with comma(,)<br>3. username: Your Demo Site account username<br>4. password: Your Demo Site account\r\n			password<br>5. sender: The sender ID to show on the receiver\'s phone<br>6. message: The text message to be\r\n			sent<br>7. balance: Set to \'true\' only when you want to check your credit balance<br>6. schedule: Specify\r\n			this parameter only when you are scheduling an sms for later delivery. It should contain the date the\r\n			message should be delivered. Supported format is \"2010-10-01 12:30:00\" i.e \"YYYY-MM-DD HH:mm:ss\"<br>7.\r\n			convert: Specify and set this parameter to 1 only when you want to get the return code in string readable\r\n			format instead of the raw numbers below;<br>8. report: Set this parameter to 1 to retrieve the message id\r\n			which can later be used to retrieve the delivery report or else remove it or set it to 0<br>9. route: Set\r\n			this parameter to&nbsp;<b>0</b>&nbsp;to send message using the normal route (Will not deliver to DND\r\n			numbers). Set to&nbsp;<b>1</b>&nbsp;to send through normal route for numbers not on DND and send through\r\n			banking route for numbers on DND. Set to&nbsp;<b>2</b>&nbsp;to send all messages through the banking route.\r\n		</div>\r\n		<div class=\"t_api\"><br>The return values are:<br>OK = Successful<br>1 = Invalid Recipient(s) Number<br>2 = Cant\r\n			send Empty Message<br>3 = Invalid Sender ID<br>4 = Insufficient Balance<br>5 = Incorrect Username or\r\n			Password Specified<br>6 = Incorrect schedule date format<br>7 = Error sending message (Gateway not\r\n			available), Please try again later<br><br>Example:<br>On success, the following code will be returned<br>OK\r\n			21 = 4564<br><br>i.e \'OK\' \'No of sms credits used\' = \'Unique Message ID\'&nbsp;<br>where OK = The message was\r\n			sent successfully<br>21 = No of sms credits used<br>and 4564 = The unique message id of the sent message\r\n			which can be used to retrieve the delivery status of the sent message.\r\n		</div>\r\n		<span style=\"color: red;\">Note: When using GET METHOD to send message, the values should be properly encoded before sending it to our server</span>\r\n		<hr>\r\n		<br><span class=\"h_api\" style=\"font-size: 18px;\">CHECK ACCOUNT BALANCE</span>\r\n\r\n		<p style=\"margin-bottom: 10px; padding: 0px;\">You can use GET or POST METHOD to query your Demo Site account\r\n			balance.<span style=\"color: rgb(0, 85, 128);\">http://demo.quickmx.com/api/sendsms.php?username=user&amp;password=1234&amp;balance=1</span>\r\n		</p>\r\n\r\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. username: Your Demo Site account username<br>2. password:\r\n			Your Demo Site account password<br>3. balance: This most be included to inform our server that you want to\r\n			only check your account balance<br></div>\r\n		<br>\r\n\r\n		<div class=\"t_api\"><i>On successful, Your account balance would be returned e.g&nbsp;<b>5024</b></i></div>\r\n		<br>\r\n		<hr>\r\n		<span class=\"h_api\" style=\"font-size: 18px;\">DELIVERY REPORT</span>\r\n\r\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Use Get Method to query the delivery report/status of the sent\r\n			message using the message id.<span style=\"color: rgb(0, 85, 128);\">http://demo.quickmx.com/api/getdelivery.php?username=user&amp;password=1234&amp;msgid=4564</span>\r\n		</p>\r\n\r\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. username: Your Demo Site account username<br>2. password:\r\n			Your Demo Site account password<br>3. msgid: The message id of the sent message you want to retrieve the\r\n			delivery status<br>3. html: Only Set this parameter to 1, to return the report in colourful html table\r\n			format. e.g html=1<br></div>\r\n		<br>\r\n\r\n		<div class=\"t_api\">On success, the following code will be returned.<br><i>2349038781252=DELIVERED=2015/10/25\r\n				23:11:34, 2349055552635=SENT=----/--/-- --:--:--</i><br>i.e \'Number\' = \'Delivery Status\' = \'Date and\r\n			Time of delivery\'&nbsp;<br>where 2349038781252 = Phone number<br>DELIVERED = The message had delivered<br>2015/10/25\r\n			23:11:34 = The date and time the message was delivered.\r\n		</div>\r\n	</blockquote>\r\n</section>'),
(7, 'theme_default_price', '<div style=\"width: 100%;\" align=\"center\">\r\n<h2><center>SMS PRICE</center></h2>\r\n<br>\r\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\r\n    <tbody>\r\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\r\n        <th>Volume</font></th>\r\n        <th><font color=\"#ffffff\">Price per SMS (Naira)</font></th>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">All Network</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">N2.00</td>\r\n    </tr>\r\n    </tbody>\r\n</table>\r\n\r\n<br>\r\n<h2><center>AIRTIME</center></h2>\r\n<br>\r\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\r\n    <tbody>\r\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\r\n        <th>Bundle</font></th>\r\n        <th><font color=\"#ffffff\">Price (Naira)</font></th>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">MTN</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">Airtel</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">Glo</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">Etisalat</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\r\n    </tr>\r\n    </tbody>\r\n</table><br>\r\n\r\n<h2><center>DATA PLAN</center></h2>\r\n<center style=\"color: red;\">Please login to check our current price</center>\r\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\r\n    <tbody>\r\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\r\n        <th>Network</font></th>\r\n        <th><font color=\"#ffffff\">Bundle & Price (Naira)</font></th>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">MTN</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">\r\n            1GB for N650<br>\r\n            2GB for N1,300\r\n        </td>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">Airtel</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">300MB for N500</td>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">Glo</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">1GB for N400</td>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">Etisalat</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">2GB for N500</td>\r\n    </tr>\r\n    </tbody>\r\n</table><br>\r\n<h2><center>BILL PAYMENT</center></h2>\r\n<br>\r\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\r\n    <tbody>\r\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\r\n        <th>Bill</font></th>\r\n        <th><font color=\"#ffffff\">Bundle & Price (Naira)</font></th>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">DSTV</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">\r\n            DSTV Access = N19,500<br>\r\n            DSTV Family= N4,000<br>\r\n        </td>\r\n    </tr>\r\n\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">GoTv</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">GoTv pack = N1,000</td>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">Startimes</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">Nova = N950</td>\r\n    </tr>\r\n    </tbody>\r\n</table>\r\n</div>\r\n\r\n'),
(7, 'theme_default_reseller', '<h2 align=\"left\" style=\"color: red; font-size: 26px; margin: 0px 0px 25px; padding: 5px 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">RESELLER SERVICES:</h2><div style=\"font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"><blockquote style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px;\"><strong>Features that your members will enjoy:</strong><br>- Robust registration form (different from joomla)<br>- Compose SMS with dynamic sender ID<br>- Type multiple sms recipients, select recipient group from phonebook or upload recipients from text and csv(excel) file<br>- SMS character counter for composing SMS i.e Page: 1, Characters left: 157, Total Typed Characters: 3<br>- SMS scheduling for future delivery with date picker.<br>- Duplicate number remover.<br>- Numbers can be in the format of&nbsp;<strong>+2348080000000 or 2348080000000 or 08080000000</strong>.<br>- Separate multiple numbers and uploaded numbers with comma, colon, semicolon or put each number on a separate line.<br>- Automatic removal of&nbsp;<strong>invalid characters from numbers</strong>&nbsp;e.g space,;,:,.,\',`,(,),,{,},#,-,_ and ?<br>- Displays member&nbsp;<strong>SMS units left and SMS Units used</strong><br>- Phone book to store phone groups and numbers<br>- Add multiple numbers to phone book group at once<br>- Upload numbers to phone group from file<br>- Delete a phone book group and all its records<br>- View to all sent sms messages with&nbsp;<strong>recipients, message,status, credit used, date scheduled, date delivered</strong><br>- Search and forward sent sms messages with page numbers and page size<br>- Order/Request/purchase sms credits with&nbsp;<strong>automatic cost calculator</strong><br>- Transaction/purchase history with&nbsp;<strong>Transaction date, amount, credit requested, status and date approved</strong><br>- Search and sort transaction history with page numbers and page size<br>- View personal details<br>- Change password on settings page<br>- Set default sender ID<br>- Members can&nbsp;<strong>transfer SMS units</strong>&nbsp;to another member</blockquote></div><div class=\"cleaner\" style=\"clear: both; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"></div><blockquote style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"><strong>Admin Features:</strong><br>- Send sms to all members<br>- Specify No of free SMS units for new members e.g new members get 3 free sms<br>- Specify how many sms units is regarded as low sms<br>- Alert member by sms and email when credit is below your specified level<br>- Specify captcha type(local captcha or google recaptcha)<br>- Create/edit Welcome SMS message for new members<br>- Create/edit SMS to send to members when their SMS orders have been approved<br>- Create/edit SMS to send to members when their credit is below your specified level<br>- Create/edit Welcome Email<br>- Create/edit Email to send to members when orders have been approved<br>- Create/edit Email to send to members when their credit is below ur specified level<br>- Set/change SMS API Gateway URL to any provider<br>- Create/edit Selling price per sms unit for different quantity of sms purchases<br>- Specify county codes that use more that 1 sms unit per text message<br>- Set/edit No of records to display per page on member and admin pages<br>- You\'ll get your own SMS Api to Give to your own customers and resellers.<br>- You\'ll get SMS Cron Url for scheduled sms (If you want to add your own cron job for scheduled sms)- Export all phone numbers that have ever recieved sms from you portal and your resellers in one click<br>- Export all phone numbers of all members in one click<br>- Export all phone numbers in member phone books in one click<br>- Admin view of all address book records and groups<br>- Admin view of all sms messages sent by members, resellers or through api<br>- Admin view of all transactions for viewing, approval, cancelliung or deletion<br>- Automatically credits member sms account upon approval of sms request transaction<br>- View, edit and delete any member account<br>- Manually reduce/increase any member account SMS units<br>- Registration cannot be repeated for registered phone number/email address<br>- Free GSM Phone Number generator<br>- Contact us form<br>- User Management&nbsp;<br>-&nbsp;<strong>And many more</strong></blockquote><div class=\"cleaner\" style=\"clear: both; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"></div><p style=\"margin-bottom: 10px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\"></p><div id=\"pay\" style=\"font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">To become a&nbsp;<strong>Reseller</strong>&nbsp;and start making profit online immediately, Please register as a normal member</div>'),
(7, 'theme_default_submit', '\r\n													   Save\r\n												'),
(8, 'cname', ''),
(8, 'caddress', ''),
(8, 'cemail', ''),
(8, 'cphone', ''),
(8, 'website', ''),
(8, 'site_name', 'Usssyy'),
(8, 'currency', 'N'),
(8, 'currency_suffix', ''),
(8, 'default_gateway', 'reseller'),
(8, 'default_dnd_gateway', 'reseller'),
(8, 'payment_method_status', '{\"bank\":1,\"internet\":1}'),
(8, 'payment_gateway_settings_atm_paystack_secret_key', ''),
(8, 'payment_gateway_settings_atm_paystack_public_key', ''),
(8, 'payment_gateway_settings_atm_paystack_transaction_fee', ''),
(8, 'payment_gateway_settings_atm_paystack_method', ''),
(8, 'payment_gateway_settings_atm_paystack_enabled', ''),
(8, 'payment_gateway_settings_atm_voguepay_merchant_id', ''),
(8, 'payment_gateway_settings_atm_voguepay_transaction_fee', ''),
(8, 'payment_gateway_settings_atm_voguepay_enabled', ''),
(8, 'payment_gateway_settings_bitcoin_bitcoin_key', ''),
(8, 'payment_gateway_settings_bitcoin_bitcoin_xpub', ''),
(8, 'payment_gateway_settings_bitcoin_bitcoin_conversion', ''),
(8, 'payment_gateway_settings_bitcoin_bitcoin_confirmation', ''),
(8, 'payment_gateway_settings_bank_accounts', 'FIRST BANK=012222222=USMAN MUSTAPHA\nDIAMOND BANK=011111111=USMAN MUSTAPHA'),
(8, 'payment_gateway_settings_internet_accounts', 'FIRST BANK=012222222=USMAN MUSTAPHA\nDIAMOND BANK=011111111=USMAN MUSTAPHA'),
(8, 'payment_gateway_settings_mobile_accounts', 'FIRST BANK=012222222=USMAN MUSTAPHA\nDIAMOND BANK=011111111=USMAN MUSTAPHA'),
(8, 'payment_gateway_settings_airtime_accounts', 'FIRST BANK=012222222=USMAN MUSTAPHA\nDIAMOND BANK=011111111=USMAN MUSTAPHA'),
(8, 'payment_gateway_settings_bank_detail', 'Please make payment and contact us'),
(8, 'payment_gateway_settings_internet_detail', ''),
(8, 'payment_gateway_settings_mobile_detail', ''),
(8, 'payment_gateway_settings_airtime_network', ''),
(8, 'payment_gateway_settings_airtime_detail', ''),
(8, 'payment_gateway_settings_airtime_transaction_fee', ''),
(8, 'payment_gateway_settings_airtime_email', ''),
(8, 'default_rate', '18'),
(8, 'default_dnd_rate', '19'),
(7, 'skin_color', 'green'),
(8, 'default_bill_rate', '6'),
(8, 'current_frontend_theme', 'default'),
(8, 'frontend_menu', '[{\"item_id\":\"menu_77168738.08790201\",\"parent_id\":\"0\",\"label\":\"Home Page\",\"link\":\"home\"},{\"item_id\":\"menu_77363590.53360781\",\"parent_id\":\"0\",\"label\":\"Welcome\",\"link\":\"home#welcome\"},{\"item_id\":\"menu_27074399.760487236\",\"parent_id\":\"0\",\"label\":\"Login\",\"link\":\"login\",\"show\":\"logout\"},{\"item_id\":\"menu_40308734.173986435\",\"parent_id\":\"0\",\"label\":\"Logout\",\"link\":\"login\\/logout\",\"show\":\"login\"},{\"item_id\":\"menu_57022876.28811442\",\"parent_id\":\"0\",\"label\":\"Register\",\"link\":\"login\\/register\",\"show\":\"logout\"},{\"item_id\":\"menu_23441551.886230893\",\"parent_id\":\"0\",\"label\":\"Dashboard\",\"link\":\"admin\\/dashboard\",\"show\":\"login\"},{\"item_id\":\"menu_24297289.02178809\",\"parent_id\":\"0\",\"label\":\"API\",\"link\":\"page\\/api\"},{\"item_id\":\"menu_78471831.3456525\",\"parent_id\":\"0\",\"label\":\"Contact Us\",\"link\":\"home#contact\"}]'),
(8, 'theme_login_bg_color1', '#311542'),
(8, 'theme_login_bg_color2', '#252742'),
(8, 'theme_login_header_text_color', '#ffffff'),
(10, 'cname', 'Rockbulksms'),
(10, 'caddress', 'Nigeria'),
(10, 'cemail', 'rockbulksms@gmail.com'),
(10, 'cphone', '07066471119'),
(10, 'website', 'rockbulksms.com'),
(10, 'site_name', 'rockbulksms.com'),
(10, 'currency', 'N'),
(10, 'currency_suffix', ''),
(10, 'default_gateway', 'reseller'),
(10, 'default_dnd_gateway', 'reseller'),
(10, 'payment_method_status', '{\"bank\":1,\"atm\":1,\"mobile\":0,\"internet\":0,\"airtime\":1,\"bitcoin\":0}'),
(10, 'payment_gateway_settings_atm_paystack_secret_key', ''),
(10, 'payment_gateway_settings_atm_paystack_public_key', ''),
(10, 'payment_gateway_settings_atm_paystack_transaction_fee', ''),
(10, 'payment_gateway_settings_atm_paystack_method', ''),
(10, 'payment_gateway_settings_atm_paystack_enabled', ''),
(10, 'payment_gateway_settings_atm_voguepay_merchant_id', ''),
(10, 'payment_gateway_settings_atm_voguepay_transaction_fee', ''),
(10, 'payment_gateway_settings_atm_voguepay_enabled', ''),
(10, 'payment_gateway_settings_bitcoin_bitcoin_key', ''),
(10, 'payment_gateway_settings_bitcoin_bitcoin_xpub', '3Hwi8uPJjb1yZGo6RU1ybJpsEBuMWtwYd1'),
(10, 'payment_gateway_settings_bitcoin_bitcoin_conversion', ''),
(10, 'payment_gateway_settings_bitcoin_bitcoin_confirmation', 'Send your harsh code or transaction ID to our contact,  07066471149, you will be credited after your payment is confirmed '),
(10, 'payment_gateway_settings_bank_accounts', 'ACCOUNT NAME : UGAMASTANLEY CHINEDU\nFIDELITY BANK: 6232767192'),
(10, 'payment_gateway_settings_internet_accounts', 'ACCOUNT NAME : UGAMASTANLEY CHINEDU\nFIDELITY BANK: 6232767192'),
(10, 'payment_gateway_settings_mobile_accounts', 'ACCOUNT NAME : UGAMASTANLEY CHINEDU\nFIDELITY BANK: 6232767192'),
(10, 'payment_gateway_settings_airtime_accounts', 'ACCOUNT NAME : UGAMASTANLEY CHINEDU\nFIDELITY BANK: 6232767192'),
(10, 'payment_gateway_settings_bank_detail', 'PLEASE MAKE PAYMENT TO THE BANK ACCOUNT DETAILS BELOW. Please note: Due to CBN stamp duty, Any payment made to our Corporate Account for N1,000 or above will attracts N50.\nNo extra charges for paying into our saving account\n\n\nACCOUNT NAME : UGAMASTANLEY CHINEDU\nFIDELITY BANK: 6232767192\n\n\nN/B: after you might have paid for your bulk SMS unit \n\n\n\nSend the following  to 07066471119\n\n1.depositors name \n\n2.amount paid\n\n3. Bank paid to 07066471119\n\nAfter which you will be credited with your SMS unit\n'),
(10, 'payment_gateway_settings_internet_detail', ''),
(10, 'payment_gateway_settings_mobile_detail', ''),
(10, 'payment_gateway_settings_airtime_network', ''),
(10, 'payment_gateway_settings_airtime_detail', 'Send the mtn airtime pin to 07066471119\nOr transfer to  07066471119\nAfter send your username, amount transferred or sent to our contact,  07066471119\nYou will be credited as soon as your payment is confirmed '),
(10, 'payment_gateway_settings_airtime_transaction_fee', ''),
(10, 'payment_gateway_settings_airtime_email', 'Ugamastanley@gmail.com'),
(10, 'default_rate', '20'),
(10, 'default_dnd_rate', '21'),
(10, 'current_frontend_theme', 'default');
INSERT INTO `settings` (`owner`, `type`, `description`) VALUES
(10, 'frontend_menu', '[{\"item_id\":\"menu_menu_menu_menu_2871557.063695063\",\"parent_id\":\"0\",\"label\":\"Logout\",\"link\":\"login\\/logout\",\"show\":\"login\"},{\"item_id\":\"menu_menu_menu_8489573.174161898\",\"parent_id\":\"menu_menu_menu_menu_2871557.063695063\",\"label\":\"Login\",\"link\":\"login\",\"show\":\"logout\"},{\"item_id\":\"menu_menu_menu_67152223.1499411\",\"parent_id\":\"0\",\"label\":\"Home Page\",\"link\":\"home\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_77048796.90912496\",\"parent_id\":\"0\",\"label\":\"Price List\",\"link\":\"page\\/price\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_58736307.711301275\",\"parent_id\":\"0\",\"label\":\"Register\",\"link\":\"login\\/register\",\"show\":\"logout\"}]'),
(10, 'theme_default_site_name', 'rockbulksms.com'),
(10, 'theme_default_description1', 'BUY  YOUR BULK  SMS UNITS AND SEND MESSAGE TO YOUR LOVED ONES AND FAMILY RELATIVES ETC.'),
(10, 'theme_default_site_address', 'www.rockbulksms.com'),
(10, 'theme_default_welcome_title', ''),
(10, 'theme_default_welcome_content', '<p>&nbsp; &nbsp; &nbsp; &nbsp; ROCK BULKSMS</p><p><br></p><p><span style=\"color: rgb(55, 62, 74); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 21px; letter-spacing: 0.1px; text-align: center; background-color: rgb(242, 242, 242);\">YOU ARE WELCOME</span></p><p><span style=\"color: rgb(55, 62, 74); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 21px; letter-spacing: 0.1px; text-align: center; background-color: rgb(242, 242, 242);\">We Provide Corporate and Individual Short Messaging Services which enables our clients to send text messages to many phone numbers through our Gateway.</span></p><p><span style=\"color: rgb(55, 62, 74); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 21px; letter-spacing: 0.1px; text-align: center; background-color: rgb(242, 242, 242);\"><br></span></p><p><span style=\"color: rgb(55, 62, 74); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 21px; letter-spacing: 0.1px; text-align: center; background-color: rgb(242, 242, 242);\">To advertise your product or businesses on our site call&nbsp; or what\'s app </span><span style=\"color: rgb(55, 62, 74); text-align: center; letter-spacing: normal; background-color: rgb(255, 228, 225);\"><font face=\"Times New Roman\" size=\"3\"><b>0706471119</b></font></span><span style=\"color: rgb(55, 62, 74); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 21px; letter-spacing: 0.1px; text-align: center; background-color: rgb(242, 242, 242);\"><br></span><br></p>'),
(10, 'theme_default_faq_content', '<p>rockbulksms@gmail.com<br><br></p>\n-3GhF\nContent-Disposition: form-data; name=\"about_us_content\"\n\n<p><br></p><p style=\"margin-bottom: 10px; color: rgb(78, 78, 78); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; letter-spacing: normal; text-align: center; background-color: rgb(242, 242, 242);\"><span style=\"color: rgb(55, 62, 74); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 21px; letter-spacing: 0.1px;\">We Provide Corporate and Individual Short Messaging Ser</span><span style=\"color: rgb(55, 62, 74); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 21px; letter-spacing: 0.1px;\">vices which enables our clients to send text messages to many phone numbers through our Gateway.</span></p><h3 style=\"font-family: &quot;Open Sans&quot;, sans-serif; line-height: 24px; color: rgb(120, 120, 120); margin: 0px; font-size: 16px; letter-spacing: normal; text-align: center; background-color: rgb(242, 242, 242); padding: 0px; border: 0px;\"><br>We also allow our client to buy airtime, dataplan and bill payment from their wallet</h3><p>you can contact us @ rockbulksms@gmail.com</p><p>08157831573</p><p>N/B: after you might have paid for your bulk SMS unit&nbsp;</p><p>Send the following&nbsp; to 07066471119</p><p>1.depositors name&nbsp;</p><p>2.amount paid</p><p>3. Bank paid to&nbsp;</p><p>After which you will be credited with your SMS unit</p><p>&nbsp; &nbsp; &nbsp; &nbsp;OUR BANK DETAILS</p><p>ACCOUNT NAME: UGAMA STANLEY C.</p><p>BANK NAME: FIDELITY BANK PLC</p><p>ACCOUNT NUMBER: 6232767192</p><p><br></p><p><br></p><p><br></p><p></p>'),
(10, 'theme_default_about_us_content', '<p><br></p><p style=\"margin-bottom: 10px; color: rgb(78, 78, 78); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; letter-spacing: normal; text-align: center; background-color: rgb(242, 242, 242);\"><span style=\"color: rgb(55, 62, 74); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 21px; letter-spacing: 0.1px;\">We Provide Corporate and Individual Short Messaging Ser</span><span style=\"color: rgb(55, 62, 74); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 21px; letter-spacing: 0.1px;\">vices which enables our clients to send text messages to many phone numbers through our Gateway.</span></p><h3 style=\"font-family: &quot;Open Sans&quot;, sans-serif; line-height: 24px; color: rgb(120, 120, 120); margin: 0px; font-size: 16px; letter-spacing: normal; text-align: center; background-color: rgb(242, 242, 242); padding: 0px; border: 0px;\"><br>We also allow our client to buy airtime, dataplan and bill payment from their wallet</h3><p>you can contact us at&nbsp; rockbulksms@gmail.com</p><p>07066471119</p><p>N/B: after you might have paid for your bulk SMS unit&nbsp;</p><p>Send the following&nbsp; to 07066471119</p><p>1.depositors name&nbsp;</p><p>2.amount paid</p><p>3. Bank paid to&nbsp;</p><p>After which you will be credited with your SMS unit</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;OUR BANK DETAILS</p><p>ACCOUNT NAME: UGAMA STANLEY C.</p><p>BANK NAME: FIDELITY BANK</p><p><span style=\"letter-spacing: 0.1px;\">ACCOUNT NUMBER: 6232767192</span></p>'),
(10, 'theme_default_company_email', 'rockbulksms@gmail.com'),
(10, 'theme_default_domain_name', ''),
(10, 'theme_default_facebook_link', ''),
(10, 'theme_default_image1', ''),
(10, 'theme_default_image2', ''),
(10, 'theme_default_image3', ''),
(10, 'theme_default_api', '<section id=\"error\" class=\"container\"><h2 align=\"center\" style=\"color: red; font-size: 26px; margin: 0px 0px 25px; padding: 5px 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\"><br></h2><blockquote style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">\n	</blockquote>\n</section>'),
(10, 'theme_default_price', '<div style=\"width: 100%;\" align=\"center\">\n<h2><center>SMS PRICE</center></h2>\n<br>\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Volume</th>\n        <th><font color=\"#ffffff\">Price per SMS (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">All Network</td>\n        <td align=\"center\" style=\"padding: 3px;\">N3.00</td>\n    </tr>\n    </tbody>\n</table>\n\n<br>\n<h2><center>AIRTIME</center></h2>\n<br>\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Bundle</th>\n        <th><font color=\"#ffffff\">Price (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">MTN</td>\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Airtel</td>\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Glo</td>\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Etisalat</td>\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\n    </tr>\n    </tbody>\n</table><br>\n\n<h2><center>DATA PLAN</center></h2>\n<center style=\"color: red;\">Please login to check our current price</center>\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Network</th>\n        <th><font color=\"#ffffff\">Bundle &amp; Price (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">MTN</td>\n        <td align=\"center\" style=\"padding: 3px;\">\n            1GB for N650<br>\n            2GB for N1,300\n        </td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Airtel</td>\n        <td align=\"center\" style=\"padding: 3px;\">300MB for N500</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Glo</td>\n        <td align=\"center\" style=\"padding: 3px;\">1GB for N400</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Etisalat</td>\n        <td align=\"center\" style=\"padding: 3px;\">2GB for N500</td>\n    </tr>\n    </tbody>\n</table><br>\n<h2><center>BILL PAYMENT</center></h2>\n<br>\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Bill</th>\n        <th><font color=\"#ffffff\">Bundle &amp; Price (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">DSTV</td>\n        <td align=\"center\" style=\"padding: 3px;\">\n            DSTV Access = N19,500<br>\n            DSTV Family= N4,000<br>\n        </td>\n    </tr>\n\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">GoTv</td>\n        <td align=\"center\" style=\"padding: 3px;\">GoTv pack = N1,000</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Startimes</td>\n        <td align=\"center\" style=\"padding: 3px;\">Nova = N950</td>\n    </tr>\n    </tbody>\n</table>\n</div>\n\n'),
(10, 'theme_default_reseller', '<h2 align=\"left\" style=\"color: red; font-size: 26px; margin: 0px 0px 25px; padding: 5px 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">RESELLER SERVICES:</h2><div style=\"font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"><blockquote style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px;\"><strong>Features that your members will enjoy:</strong><br>- Robust registration form (different from joomla)<br>- Compose SMS with dynamic sender ID<br>- Type multiple sms recipients, select recipient group from phonebook or upload recipients from text and csv(excel) file<br>- SMS character counter for composing SMS i.e Page: 1, Characters left: 157, Total Typed Characters: 3<br>- SMS scheduling for future delivery with date picker.<br>- Duplicate number remover.<br>- Numbers can be in the format of&nbsp;<strong>+2348080000000 or 2348080000000 or 08080000000</strong>.<br>- Separate multiple numbers and uploaded numbers with comma, colon, semicolon or put each number on a separate line.<br>- Automatic removal of&nbsp;<strong>invalid characters from numbers</strong>&nbsp;e.g space,;,:,.,\',`,(,),,{,},#,-,_ and ?<br>- Displays member&nbsp;<strong>SMS units left and SMS Units used</strong><br>- Phone book to store phone groups and numbers<br>- Add multiple numbers to phone book group at once<br>- Upload numbers to phone group from file<br>- Delete a phone book group and all its records<br>- View to all sent sms messages with&nbsp;<strong>recipients, message,status, credit used, date scheduled, date delivered</strong><br>- Search and forward sent sms messages with page numbers and page size<br>- Order/Request/purchase sms credits with&nbsp;<strong>automatic cost calculator</strong><br>- Transaction/purchase history with&nbsp;<strong>Transaction date, amount, credit requested, status and date approved</strong><br>- Search and sort transaction history with page numbers and page size<br>- View personal details<br>- Change password on settings page<br>- Set default sender ID<br>- Members can&nbsp;<strong>transfer SMS units</strong>&nbsp;to another member</blockquote></div><div class=\"cleaner\" style=\"clear: both; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"></div><blockquote style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"><strong>Admin Features:</strong><br>- Send sms to all members<br>- Specify No of free SMS units for new members e.g new members get 3 free sms<br>- Specify how many sms units is regarded as low sms<br>- Alert member by sms and email when credit is below your specified level<br>- Specify captcha type(local captcha or google recaptcha)<br>- Create/edit Welcome SMS message for new members<br>- Create/edit SMS to send to members when their SMS orders have been approved<br>- Create/edit SMS to send to members when their credit is below your specified level<br>- Create/edit Welcome Email<br>- Create/edit Email to send to members when orders have been approved<br>- Create/edit Email to send to members when their credit is below ur specified level<br>- Set/change SMS API Gateway URL to any provider<br>- Create/edit Selling price per sms unit for different quantity of sms purchases<br>- Specify county codes that use more that 1 sms unit per text message<br>- Set/edit No of records to display per page on member and admin pages<br>- You\'ll get your own SMS Api to Give to your own customers and resellers.<br>- You\'ll get SMS Cron Url for scheduled sms (If you want to add your own cron job for scheduled sms)- Export all phone numbers that have ever recieved sms from you portal and your resellers in one click<br>- Export all phone numbers of all members in one click<br>- Export all phone numbers in member phone books in one click<br>- Admin view of all address book records and groups<br>- Admin view of all sms messages sent by members, resellers or through api<br>- Admin view of all transactions for viewing, approval, cancelliung or deletion<br>- Automatically credits member sms account upon approval of sms request transaction<br>- View, edit and delete any member account<br>- Manually reduce/increase any member account SMS units<br>- Registration cannot be repeated for registered phone number/email address<br>- Free GSM Phone Number generator<br>- Contact us form<br>- User Management&nbsp;<br>-&nbsp;<strong>And many more</strong></blockquote><div class=\"cleaner\" style=\"clear: both; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"></div><p style=\"margin-bottom: 10px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\"></p><div id=\"pay\" style=\"font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">To become a&nbsp;<strong>Reseller</strong>&nbsp;and start making profit online immediately, Please register as a normal member</div>'),
(10, 'theme_default_submit', '\n													   Save\n												'),
(10, 'skin_color', 'red'),
(10, 'theme_login_bg_color1', '#ff0000'),
(10, 'theme_login_bg_color2', '#0000ff'),
(10, 'theme_login_header_text_color', '#ff00ff'),
(2, 'skin_color', 'blue'),
(11, 'notifications_registration_mail_title', 'WELCOME'),
(11, 'notifications_registration_mail', '<b>WELCOME @@fname@@</b> TO @@<b>site-name</b>@@<br>\nYour account registration was successful.<br>\nUsername: @@username@@<br>\nPassword: @@password@@\nThank you for your registration'),
(11, 'notifications_registration_mail_enabled', '1'),
(11, 'notifications_registration_sms_title', 'WELCOME'),
(11, 'notifications_registration_sms', 'WELCOME @@fname@@ TO @@site-name@@\n\nYour account registration was successful.\n\nUsername: @@username@@\n\nPassword: @@password@@\nThank you for your registration'),
(11, 'notifications_registration_sms_enabled', '1'),
(11, 'notifications_fund_wallet_mail_title', 'Ceesms'),
(11, 'notifications_fund_wallet_mail', '<p>ACCOUNT CREDITED!!!</p><p>Dear @@fname@@,<br>Your account has been credited:<br><br>\nPrevious Balance: @@p_balance@@<br>\nAmount Paid: @@amount@@<br>\nTransaction Fee: @@transaction_fee@@<br>\n<b>Amount Credited: @@amount_credited@@</b><br>\nAccount Balance @@balance@@<br><br>\nThank You</p><p><b>Admin Cyberwisdom</b></p>'),
(11, 'notifications_fund_wallet_mail_enabled', '1'),
(11, 'notifications_fund_wallet_sms_title', 'Ceesms'),
(11, 'notifications_fund_wallet_sms', 'Credit Alert!!!\nDear @@fname@@,\nYour account has been credited with @@amount@@. Your new Account Balance is @@balance@@\n\nThank You\nAdmin Cyberwisdom\n07086243145'),
(11, 'notifications_fund_wallet_sms_enabled', '1'),
(11, 'notifications_password_reset_mail_title', 'PASSWORD RESET'),
(11, 'notifications_password_reset_mail', 'Dear @@fname@@,<br>Your have requested for a password reset:<br><br>Your reset code is @@code@@<br><BR>\nOr simply click on this link below<br>@@link@@'),
(11, 'notifications_password_reset_mail_enabled', '1'),
(11, 'notifications_password_reset_sms_title', 'PASSWORD RESET'),
(11, 'notifications_password_reset_sms', 'Dear @@fname@@,\nYour have requested for a password reset:\n\nYour reset code is @@code@@\n\nOr simply click on this link below\n@@link@@'),
(11, 'notifications_password_reset_sms_enabled', '0'),
(11, 'notifications_missed_you_mail_title', 'ITS BEEN A WHILE'),
(11, 'notifications_missed_you_mail', 'Dear @@fname@@,<br>Long Time, Its been a while. We have really missed you. We have added more features, why dont you visit us again to see for yourself. <br>Thank You'),
(11, 'notifications_missed_you_mail_day', '14'),
(11, 'notifications_missed_you_mail_enabled', '1'),
(11, 'notifications_missed_you_sms_title', 'ITS BEEN A WHILE'),
(11, 'notifications_missed_you_sms', 'Dear @@fname@@,\nLong Time, Its been a while. We have really missed you. We have added more features, why dont you visit us again to see for yourself. \nThank You'),
(11, 'notifications_missed_you_sms_day', '14'),
(11, 'notifications_missed_you_sms_enabled', '1'),
(11, 'cname', 'ceesms.com.ng'),
(11, 'caddress', ''),
(11, 'cemail', 'Cyberwisdomanthony@gmail.com'),
(11, 'cphone', '+2347086243145'),
(11, 'website', 'ceesms.com.ng'),
(11, 'site_name', 'ceesms.com.ng'),
(11, 'currency', 'N'),
(11, 'currency_suffix', ''),
(11, 'default_gateway', 'reseller'),
(11, 'default_dnd_gateway', 'reseller'),
(11, 'payment_method_status', '{\"bank\":1,\"atm\":1,\"internet\":1,\"mobile\":1,\"airtime\":0}'),
(11, 'payment_gateway_settings_atm_paystack_secret_key', ''),
(11, 'payment_gateway_settings_atm_paystack_public_key', ''),
(11, 'payment_gateway_settings_atm_paystack_transaction_fee', ''),
(11, 'payment_gateway_settings_atm_paystack_method', ''),
(11, 'payment_gateway_settings_atm_paystack_enabled', ''),
(11, 'payment_gateway_settings_atm_voguepay_merchant_id', '9928-0059501'),
(11, 'payment_gateway_settings_atm_voguepay_transaction_fee', '150'),
(11, 'payment_gateway_settings_atm_voguepay_enabled', ''),
(11, 'payment_gateway_settings_bitcoin_bitcoin_key', ''),
(11, 'payment_gateway_settings_bitcoin_bitcoin_xpub', ''),
(11, 'payment_gateway_settings_bitcoin_bitcoin_conversion', ''),
(11, 'payment_gateway_settings_bitcoin_bitcoin_confirmation', ''),
(11, 'payment_gateway_settings_bank_accounts', 'UBA=2097215877=ONU OGBONNA ANTHONY\n'),
(11, 'payment_gateway_settings_internet_accounts', 'UBA=2097215877=ONU OGBONNA ANTHONY\n'),
(11, 'payment_gateway_settings_mobile_accounts', 'UBA=2097215877=ONU OGBONNA ANTHONY\n'),
(11, 'payment_gateway_settings_airtime_accounts', 'UBA=2097215877=ONU OGBONNA ANTHONY\n'),
(11, 'payment_gateway_settings_bank_detail', 'Firstbank=3103651995=ONU OGBONNA ANTHONY'),
(11, 'payment_gateway_settings_internet_detail', ''),
(11, 'payment_gateway_settings_mobile_detail', 'ONU OGBONNA ANTHONY \n3103651995 FIRSTBANK\nFIRSTBANK PLC.'),
(11, 'payment_gateway_settings_airtime_network', 'MTN, AIRTEL'),
(11, 'payment_gateway_settings_airtime_detail', ''),
(11, 'payment_gateway_settings_airtime_transaction_fee', '5'),
(11, 'payment_gateway_settings_airtime_email', 'CYBERWISDOMANTHONY@GMAIL.COM'),
(11, 'default_rate', '22'),
(11, 'default_dnd_rate', '22'),
(11, 'default_bill_rate', '8'),
(11, 'theme_login_bg_color1', '#00ff00'),
(11, 'theme_login_bg_color2', '#00ff00'),
(11, 'theme_login_header_text_color', '#ffffff'),
(11, 'frontend_menu', '[{\"item_id\":\"menu_menu_menu_menu_367536.98165599146\",\"parent_id\":\"0\",\"label\":\"Home Page\",\"link\":\"home\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_15424040.682176923\",\"parent_id\":\"0\",\"label\":\"Login\",\"link\":\"login\",\"show\":\"logout\"},{\"item_id\":\"menu_menu_menu_menu_21832111.220621783\",\"parent_id\":\"0\",\"label\":\"Register\",\"link\":\"login\\/register\",\"show\":\"logout\"},{\"item_id\":\"menu_menu_menu_menu_57829706.54458968\",\"parent_id\":\"0\",\"label\":\"Dashboard\",\"link\":\"admin\\/dashboard\",\"show\":\"login\"},{\"item_id\":\"menu_menu_menu_menu_18092459.436494723\",\"parent_id\":\"0\",\"label\":\"Price List\",\"link\":\"page\\/price\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_56822725.06518557\",\"parent_id\":\"0\",\"label\":\"API\",\"link\":\"page\\/api\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_8082042.747535976\",\"parent_id\":\"0\",\"label\":\"Reseller\",\"link\":\"page\\/reseller\",\"show\":\"all\"},{\"item_id\":\"menu_menu_menu_menu_76605248.34154698\",\"parent_id\":\"0\",\"label\":\"Contact Us\",\"link\":\"home#contact\",\"show\":\"all\"},{\"item_id\":\"menu_11553390.960158741\",\"parent_id\":\"0\",\"label\":\"Meet Site Admin\",\"link\":\"page\\/19\",\"show\":\"all\"},{\"item_id\":\"menu_67346812.05968489\",\"parent_id\":\"0\",\"label\":\"About Us\",\"link\":\"home#about\",\"show\":\"all\"},{\"item_id\":\"menu_63626089.003056966\",\"parent_id\":\"0\",\"label\":\"Logout\",\"link\":\"login\\/logout\",\"show\":\"login\"},{\"item_id\":\"menu_78671725.42791499\",\"parent_id\":\"0\",\"label\":\"FAQ\",\"link\":\"home#faq\",\"show\":\"all\"}]'),
(11, 'current_frontend_theme', 'default'),
(11, 'theme_default_site_name', 'Ceesms.com.ng'),
(11, 'theme_default_description1', 'Welcome to Ceesms, Nigeria leading bulksms portal'),
(11, 'theme_default_site_address', 'No. 24 Surulere Ikeja Lagos Nigeria'),
(11, 'theme_default_welcome_title', 'Ceesms.com.ng'),
(11, 'theme_default_welcome_content', '<p><span style=\"font-family: &quot;Open Sans&quot;, sans-serif; font-size: 24px; letter-spacing: normal; text-align: justify;\"><font color=\"#00ff00\"><b>Ceesms.com.ng</b></font>&nbsp;is Nigeria\'s most<b> reliable</b> web based Bulk sms service that can deliver BULK SMS messages to any Mobile network globally. Our bulk SMS gateway is filtered to deliver the fastest and most credible text messaging compared with other Bulk SMS Providers. </span></p><p><span style=\"font-family: &quot;Open Sans&quot;, sans-serif; font-size: 24px; letter-spacing: normal; text-align: justify;\">Contact us and we will get you started with specialist advice and great SMS marketing ideas for you and your clients. There is a wide variety of qualities when it comes to Bulk SMS Service and SMS providers. When sending messages with our web sms service you can be confident that your messages will be delivered instantly. Our sms portal is advanced one with interesting features to get you going on the GO.</span></p><p><span style=\"font-family: &quot;Open Sans&quot;, sans-serif; font-size: 24px; letter-spacing: normal; text-align: justify;\"><br></span></p><p><span style=\"font-family: &quot;Open Sans&quot;, sans-serif; font-size: 24px; letter-spacing: normal; text-align: justify;\"><font color=\"#00ff00\"><b style=\"\">Ceesms&nbsp; </b></font></span><span style=\"font-family: Arial, sans-serif; font-size: 18.5pt; letter-spacing: 0.1px;\">has automatic sms delivery\r\nstatus checker which enables you to know when your messages are delivered to your recipients.\r\nIsn’t this amazing?</span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 18.5pt; line-height: 115%; font-family: Arial, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">It is not yet finished, with\r\nour online payment gateway your account will be credited instantly upon\r\nsuccessful transaction when you buy units with your ATM Card i.e. You don’t\r\nhave to contact any Admin to credit your <b style=\"\"><font color=\"#0000ff\">Ceesms account</font></b> when you pay with your\r\nATM Card. Wow!!!<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 18.5pt; line-height: 115%; font-family: Arial, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 18.5pt; line-height: 115%; font-family: Arial, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">That’s not all, Our delivery\r\nspeed is as fast as electric current, just a click and your text is delivered\r\nto thousands of numbers in your phonebook!!! We deliver 1unit per sms to all Nigeria Networks.\r\nWith our banking route, you get your text messages delivered to all numbers\r\nboth the ones on DND(Do not disturb)<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 18.5pt; line-height: 115%; font-family: Arial, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><font color=\"#00ff00\"><b>Ceesms</b></font> offers you free units\r\nupon registration to test our service as some believe in seeing.<o:p></o:p></span></p>\r\n\r\n<p><span style=\"font-family: Arial, sans-serif; font-size: 18.5pt; letter-spacing: 0.1px;\">Our reseller package is the\r\nbest any Bulksms platform can offer. So what are you still waiting for? Click&nbsp;</span><a href=\"http://www.ceesms.com.ng/login\">HERE</a><span style=\"font-family: Arial, sans-serif; font-size: 18.5pt; letter-spacing: 0.1px;\"> to login or create&nbsp;</span><a href=\"http://www.ceesms.com.ng/login/register\">CREATE ACCOUNT</a><span style=\"font-family: Arial, sans-serif; font-size: 18.5pt; letter-spacing: 0.1px;\"> if you are not yet a member.</span><span style=\"font-family: &quot;Open Sans&quot;, sans-serif; font-size: 24px; letter-spacing: normal; text-align: justify;\">&nbsp;</span></p><p><span style=\"font-family: &quot;Open Sans&quot;, sans-serif; font-size: 24px; letter-spacing: normal; text-align: justify;\"><br></span></p><p><span style=\"font-family: &quot;Open Sans&quot;, sans-serif; font-size: 24px; letter-spacing: normal; text-align: justify;\"><br></span></p><p><span style=\"font-family: &quot;Open Sans&quot;, sans-serif; font-size: 24px; letter-spacing: normal; text-align: justify;\"><br></span><br></p>'),
(11, 'theme_default_faq_content', ''),
(11, 'theme_default_about_us_content', ''),
(11, 'theme_default_company_email', 'Cyberwisdomanthony@gmail.com'),
(11, 'theme_default_domain_name', 'Creams.com.ng'),
(11, 'theme_default_facebook_link', 'https://www.Facebook.com/ceesms.com.ng'),
(11, 'theme_default_image1', ''),
(11, 'theme_default_image2', ''),
(11, 'theme_default_image3', ''),
(11, 'theme_default_api', '<section id=\"error\" class=\"container\"><h2 align=\"center\" style=\"color: red; font-size: 26px; margin: 0px 0px 25px; padding: 5px 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">\r\n		\r\n<br class=\"Apple-interchange-newline\">API</h2>\r\n\r\n	<p style=\"margin-bottom: 10px; padding: 0px;  Geneva, sans-serif; letter-spacing: normal;\">You\r\n		can interface an application, website or system with our messaging gateway by using our very flexible HTTP API\r\n		connection. Once you\'re connected, you\'ll be able send sms, check account balance, get deliver reports and sent\r\n		messages or check your balance.</p>\r\n\r\n	<h3 align=\"\" style=\"color: red; font-weight: bold; font-size: 15px; margin: 30px 0px 5px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">\r\n		CONNECTION METHOD</h3>\r\n\r\n	<div align=\"left\" class=\"payment\" style=\"display: inline; size: 60px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">\r\n		\r\n		<br><b>SPC API</b>&nbsp;http://ceesms.com.ng/api/sendsms.php?username=yourUsername&amp;password=yourPassword&amp;sender=@@sender@@&amp;message=@@message@@&amp;recipient=@@recipient@@\r\n		<hr>\r\n		<p style=\"margin-bottom: 10px; padding: 0px;\"><a href=\"https://sms.quickhostme.com/api/#atm\" style=\"color: rgb(8, 174, 227); display: block; size: 24px;\">GET\r\n				METHOD</a><a href=\"https://sms.quickhostme.com/api/#get\" style=\"color: rgb(8, 174, 227); display: block; size: 24px;\">POST METHOD</a></p></div>\r\n	<p><span style=\"font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\"></span></p>\r\n	<blockquote style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">\r\n		<span class=\"h_api\" style=\"font-size: 18px;\">GET METHOD</span>\r\n\r\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Connect to send single or multiple sms messages through the\r\n			following api url:<span style=\"color: rgb(0, 85, 128);\">http://ceesms.com.ng/api/sendsms.php?username=user&amp;password=1234&amp;sender=quicksms1&amp;message=testing&amp;recipient=2348030000000,23480xxxxxxxx&amp;report=1&amp;convert=1&amp;route=1</span>\r\n		</p><span class=\"h_api\" style=\"font-size: 18px;\">POST METHOD</span>\r\n\r\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Use this method to send sms messages where the length of \"GET\r\n			METHOD\" is a limitation,<br>url:&nbsp;<span style=\"color: rgb(0, 85, 128);\">http://ceesms.com.ng/api/sendsms.php</span>&nbsp;<br>Data\r\n			to post: username=user&amp;password=1234&amp;sender=quicsms1&amp;message=testing &amp;recipient=2348030000000,23480xxxxxxxx&amp;report=1&amp;convert=1&amp;route=1\r\n		</p>\r\n\r\n		<hr>\r\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. recipient : The destination phone numbers. Separate multiple\r\n			numbers with comma(,)<br>3. username: Your ceesms.com.ng account username<br>4. password: Your ceesms.com.ng account\r\n			password<br>5. sender: The sender ID to show on the receiver\'s phone<br>6. message: The text message to be\r\n			sent<br>7. balance: Set to \'true\' only when you want to check your credit balance<br>6. schedule: Specify\r\n			this parameter only when you are scheduling an sms for later delivery. It should contain the date the\r\n			message should be delivered. Supported format is \"2010-10-01 12:30:00\" i.e \"YYYY-MM-DD HH:mm:ss\"<br>7.\r\n			convert: Specify and set this parameter to 1 only when you want to get the return code in string readable\r\n			format instead of the raw numbers below;<br>8. report: Set this parameter to 1 to retrieve the message id\r\n			which can later be used to retrieve the delivery report or else remove it or set it to 0<br>9. route: Set\r\n			this parameter to&nbsp;<b>0</b>&nbsp;to send message using the normal route (Will not deliver to DND\r\n			numbers). Set to&nbsp;<b>1</b>&nbsp;to send through normal route for numbers not on DND and send through\r\n			banking route for numbers on DND. Set to&nbsp;<b>2</b>&nbsp;to send all messages through the banking route.\r\n		</div>\r\n		<div class=\"t_api\"><br>The return values are:<br>OK = Successful<br>1 = Invalid Recipient(s) Number<br>2 = Cant\r\n			send Empty Message<br>3 = Invalid Sender ID<br>4 = Insufficient Balance<br>5 = Incorrect Username or\r\n			Password Specified<br>6 = Incorrect schedule date format<br>7 = Error sending message (Gateway not\r\n			available), Please try again later<br><br>Example:<br>On success, the following code will be returned<br>OK\r\n			21 = 4564<br><br>i.e \'OK\' \'No of sms credits used\' = \'Unique Message ID\'&nbsp;<br>where OK = The message was\r\n			sent successfully<br>21 = No of sms credits used<br>and 4564 = The unique message id of the sent message\r\n			which can be used to retrieve the delivery status of the sent message.\r\n		</div>\r\n		<span style=\"color: red;\">Note: When using GET METHOD to send message, the values should be properly encoded before sending it to our server</span>\r\n		<hr>\r\n		<br><span class=\"h_api\" style=\"font-size: 18px;\">CHECK ACCOUNT BALANCE</span>\r\n\r\n		<p style=\"margin-bottom: 10px; padding: 0px;\">You can use GET or POST METHOD to query your ceesms.com.ng account\r\n			balance.<span style=\"color: rgb(0, 85, 128);\">http://ceesms.com.ng/api/sendsms.php?username=user&amp;password=1234&amp;balance=1</span>\r\n		</p>\r\n\r\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. username: Your ceesms.com.ng account username<br>2. password:\r\n			Your ceesms.com.ng account password<br>3. balance: This most be included to inform our server that you want to\r\n			only check your account balance<br></div>\r\n		<br>\r\n\r\n		<div class=\"t_api\"><i>On successful, Your account balance would be returned e.g&nbsp;<b>5024</b></i></div>\r\n		<br>\r\n		<hr>\r\n		<span class=\"h_api\" style=\"font-size: 18px;\">DELIVERY REPORT</span>\r\n\r\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Use Get Method to query the delivery report/status of the sent\r\n			message using the message id.<span style=\"color: rgb(0, 85, 128);\">http://ceesms.com.ng/api/getdelivery.php?username=user&amp;password=1234&amp;msgid=4564</span>\r\n		</p>\r\n\r\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. username: Your ceesms.com.ng account username<br>2. password:\r\n			Your ceesms.com.ng account password<br>3. msgid: The message id of the sent message you want to retrieve the\r\n			delivery status<br>3. html: Only Set this parameter to 1, to return the report in colourful html table\r\n			format. e.g html=1<br></div>\r\n		<br>\r\n\r\n		<div class=\"t_api\">On success, the following code will be returned.<br><i>2349038781252=DELIVERED=2015/10/25\r\n				23:11:34, 2349055552635=SENT=----/--/-- --:--:--</i><br>i.e \'Number\' = \'Delivery Status\' = \'Date and\r\n			Time of delivery\'&nbsp;<br>where 2349038781252 = Phone number<br>DELIVERED = The message had delivered<br>2015/10/25\r\n			23:11:34 = The date and time the message was delivered.\r\n		</div>\r\n	</blockquote>\r\n</section>'),
(11, 'theme_default_price', '<div style=\"width: 100%;\" align=\"center\">\r\n<h2><center>SMS PRICE</center></h2>\r\n<br>\r\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\r\n    <tbody>\r\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\r\n        <th>Volume</th>\r\n        <th><font color=\"#ffffff\">Price per SMS (Naira)</font></th>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">All Network</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">N1.00</td>\r\n    </tr>\r\n    </tbody>\r\n</table>\r\n\r\n<br>\r\n<h2><center>AIRTIME</center></h2>\r\n<br>\r\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\r\n    <tbody>\r\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\r\n        <th>Bundle</th>\r\n        <th><font color=\"#ffffff\">Price (Naira)</font></th>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">MTN</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">Airtel</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">Glo</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">Etisalat</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\r\n    </tr>\r\n    </tbody>\r\n</table><br>\r\n\r\n<h2><center>DATA PLAN</center></h2>\r\n<center style=\"color: red;\">Please login to check our current price</center>\r\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\r\n    <tbody>\r\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\r\n        <th>Network</th>\r\n        <th><font color=\"#ffffff\">Bundle &amp; Price (Naira)</font></th>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">MTN</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">\r\n            1GB for N650<br>\r\n            2GB for N1,300\r\n        </td>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">Airtel</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">300MB for N500</td>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">Glo</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">1GB for N400</td>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">Etisalat</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">2GB for N500</td>\r\n    </tr>\r\n    </tbody>\r\n</table><br>\r\n<h2><center>BILL PAYMENT</center></h2>\r\n<br>\r\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\r\n    <tbody>\r\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\r\n        <th>Bill</th>\r\n        <th><font color=\"#ffffff\">Bundle &amp; Price (Naira)</font></th>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">DSTV</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">\r\n            DSTV Access = N19,500<br>\r\n            DSTV Family= N4,000<br>\r\n        </td>\r\n    </tr>\r\n\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">GoTv</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">GoTv pack = N1,000</td>\r\n    </tr>\r\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\r\n        <td style=\"padding: 3px;\">Startimes</td>\r\n        <td align=\"center\" style=\"padding: 3px;\">Nova = N950</td>\r\n    </tr>\r\n    </tbody>\r\n</table>\r\n</div>\r\n\r\n');
INSERT INTO `settings` (`owner`, `type`, `description`) VALUES
(11, 'theme_default_reseller', '<h2 align=\"left\" style=\"color: red; font-size: 26px; margin: 0px 0px 25px; padding: 5px 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">RESELLER SERVICES:</h2><div style=\"font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"><blockquote style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px;\"><strong>Features that your members will enjoy:</strong><br>- Robust registration form (different from joomla)<br>- Compose SMS with dynamic sender ID<br>- Type multiple sms recipients, select recipient group from phonebook or upload recipients from text and csv(excel) file<br>- SMS character counter for composing SMS i.e Page: 1, Characters left: 157, Total Typed Characters: 3<br>- SMS scheduling for future delivery with date picker.<br>- Duplicate number remover.<br>- Numbers can be in the format of&nbsp;<strong>+2348080000000 or 2348080000000 or 08080000000</strong>.<br>- Separate multiple numbers and uploaded numbers with comma, colon, semicolon or put each number on a separate line.<br>- Automatic removal of&nbsp;<strong>invalid characters from numbers</strong>&nbsp;e.g space,;,:,.,\',`,(,),,{,},#,-,_ and ?<br>- Displays member&nbsp;<strong>SMS units left and SMS Units used</strong><br>- Phone book to store phone groups and numbers<br>- Add multiple numbers to phone book group at once<br>- Upload numbers to phone group from file<br>- Delete a phone book group and all its records<br>- View to all sent sms messages with&nbsp;<strong>recipients, message,status, credit used, date scheduled, date delivered</strong><br>- Search and forward sent sms messages with page numbers and page size<br>- Order/Request/purchase sms credits with&nbsp;<strong>automatic cost calculator</strong><br>- Transaction/purchase history with&nbsp;<strong>Transaction date, amount, credit requested, status and date approved</strong><br>- Search and sort transaction history with page numbers and page size<br>- View personal details<br>- Change password on settings page<br>- Set default sender ID<br>- Members can&nbsp;<strong>transfer SMS units</strong>&nbsp;to another member</blockquote></div><div class=\"cleaner\" style=\"clear: both; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"></div><blockquote style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"><strong>Admin Features:</strong><br>- Send sms to all members<br>- Specify No of free SMS units for new members e.g new members get 3 free sms<br>- Specify how many sms units is regarded as low sms<br>- Alert member by sms and email when credit is below your specified level<br>- Specify captcha type(local captcha or google recaptcha)<br>- Create/edit Welcome SMS message for new members<br>- Create/edit SMS to send to members when their SMS orders have been approved<br>- Create/edit SMS to send to members when their credit is below your specified level<br>- Create/edit Welcome Email<br>- Create/edit Email to send to members when orders have been approved<br>- Create/edit Email to send to members when their credit is below ur specified level<br>- Set/change SMS API Gateway URL to any provider<br>- Create/edit Selling price per sms unit for different quantity of sms purchases<br>- Specify county codes that use more that 1 sms unit per text message<br>- Set/edit No of records to display per page on member and admin pages<br>- You\'ll get your own SMS Api to Give to your own customers and resellers.<br>- You\'ll get SMS Cron Url for scheduled sms (If you want to add your own cron job for scheduled sms)- Export all phone numbers that have ever recieved sms from you portal and your resellers in one click<br>- Export all phone numbers of all members in one click<br>- Export all phone numbers in member phone books in one click<br>- Admin view of all address book records and groups<br>- Admin view of all sms messages sent by members, resellers or through api<br>- Admin view of all transactions for viewing, approval, cancelliung or deletion<br>- Automatically credits member sms account upon approval of sms request transaction<br>- View, edit and delete any member account<br>- Manually reduce/increase any member account SMS units<br>- Registration cannot be repeated for registered phone number/email address<br>- Free GSM Phone Number generator<br>- Contact us form<br>- User Management&nbsp;<br>-&nbsp;<strong>And many more</strong></blockquote><div class=\"cleaner\" style=\"clear: both; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"></div><p style=\"margin-bottom: 10px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\"></p><div id=\"pay\" style=\"font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">To become a&nbsp;<strong>Reseller</strong>&nbsp;and start making profit online immediately, Please register as a normal member <br> Then contact us on<br><b> Email:</b> Cyberwisdomanthony@gmail.com <br><b> Mobile Phone:</b> 07086243145, 08126569620</div>'),
(11, 'theme_default_submit', '\r\n													   Save\r\n												'),
(11, 'skin_color', 'green'),
(11, 'login_using_username', '1'),
(11, 'login_using_email', '1'),
(11, 'login_using_phone', '1'),
(11, 'register_using_username', '1'),
(11, 'register_using_email', '1'),
(11, 'register_using_phone', '1'),
(11, 'member_permission', 'send_bulk_sms,message_history,draft,schedule,manage_phonebook,buy_airtime,buy_dataplan,dstv_bill,gotv_bill,startimes_bill,fund_wallet,transfer_fund,transfer_to_bank,view_bill_history'),
(6, 'cname', 'Next Generation Technologies'),
(6, 'cemail', 'usmanndako@gmail.com'),
(6, 'cphone', '08070840001'),
(6, 'website', 'smsnow.quickmx.com'),
(6, 'site_name', 'SMS NOW'),
(6, 'currency', 'N'),
(6, 'currency_suffix', 'N'),
(6, 'login_using_username', '1'),
(6, 'login_using_email', '1'),
(6, 'login_using_phone', '1'),
(6, 'register_using_username', '1'),
(6, 'register_using_email', '1'),
(6, 'register_using_phone', '1'),
(6, 'payment_method_status', '{\"atm\":1,\"bank\":1}'),
(1, 'cost_sms_rate', '25'),
(1, 'cost_dnd_rate', '26'),
(1, 'cost_bill_rate', '10'),
(2, 'notifications_password_reset_mail', 'Dear @@fname@@,<br>Your have requested for a password reset:<br><br>Your reset code is @@code@@<br><BR>\nOr simply click on this link below<br>@@link@@'),
(2, 'notifications_password_reset_mail_enabled', '0'),
(2, 'notifications_password_reset_sms_title', 'PASSWORD RESET'),
(2, 'notifications_password_reset_sms', 'Dear @@fname@@,\nYour have requested for a password reset:\n\nYour reset code is @@code@@\n\nOr simply click on this link below\n@@link@@'),
(2, 'notifications_password_reset_sms_enabled', '0'),
(2, 'notifications_missed_you_mail_title', 'ITS BEEN A WHILE'),
(2, 'notifications_missed_you_mail', 'Dear @@fname@@,<br>Long Time, Its been a while. We have really missed you. We have added more features, why dont you visit us again to see for yourself. <br>Thank You'),
(2, 'notifications_missed_you_mail_day', '7'),
(2, 'notifications_missed_you_mail_enabled', '1'),
(2, 'notifications_missed_you_sms_title', 'ITS BEEN A WHILE'),
(2, 'notifications_missed_you_sms', 'Dear @@fname@@,\nLong Time, Its been a while. We have really missed you. We have added more features, why dont you visit us again to see for yourself. \nThank You'),
(2, 'notifications_missed_you_sms_day', '7'),
(2, 'notifications_missed_you_sms_enabled', '0'),
(3, 'payment_gateway_settings_atm_paystack_method', ''),
(1, 'bill_gateway_3_username', 'mzndako'),
(13, 'skin_color', 'purple'),
(13, 'current_frontend_theme', 'default'),
(1, 'payment_gateway_settings_atm_paystack_allow_reseller', ''),
(1, 'payment_gateway_settings_atm_voguepay_allow_reseller', '1'),
(3, 'payment_gateway_settings_atm_paystack_allow_reseller', ''),
(3, 'payment_gateway_settings_atm_voguepay_allow_reseller', ''),
(1, 'force_https', '1'),
(4, 'theme_default_api', '<section id=\'error\' class=\'container\'><h2 align=\"center\"\n                                          style=\"color: red; font-size: 26px; margin: 0px 0px 25px; padding: 5px 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">\n		API</h2>\n\n	<p style=\"margin-bottom: 10px; padding: 0px;  Geneva, sans-serif; letter-spacing: normal;\">You\n		can interface an application, website or system with our messaging gateway by using our very flexible HTTP API\n		connection. Once you\'re connected, you\'ll be able send sms, check account balance, get deliver reports and sent\n		messages or check your balance.</p>\n\n	<h3 align=\"\"\n	    style=\"color: red; font-weight: bold; font-size: 15px; margin: 30px 0px 5px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">\n		CONNECTION METHOD</h3>\n\n	<div align=\"left\" class=\"payment\"\n	     style=\"display: inline; size: 60px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">\n		\n		<br><b>SPC API</b>&nbsp;http://linkingsms.com/api/sendsms.php?username=yourUsername&amp;password=yourPassword&amp;sender=@@sender@@&amp;message=@@message@@&amp;recipient=@@recipient@@\n		<hr>\n		<p style=\"margin-bottom: 10px; padding: 0px;\"><a href=\"https://sms.quickhostme.com/api/#atm\"\n		                                                 style=\"color: rgb(8, 174, 227); display: block; size: 24px;\">GET\n				METHOD</a><a href=\"https://sms.quickhostme.com/api/#get\"\n		                     style=\"color: rgb(8, 174, 227); display: block; size: 24px;\">POST METHOD</a></p></div>\n	<p><span style=\"font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\"></span></p>\n	<blockquote\n		style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">\n		<span class=\"h_api\" style=\"font-size: 18px;\">GET METHOD</span>\n\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Connect to send single or multiple sms messages through the\n			following api url:<span style=\"color: rgb(0, 85, 128);\">http://linkingsms.com				/api/sendsms.php?username=user&amp;password=1234&amp;sender=quicsms1&amp;message=testing&amp;recipient=2348030000000,23480xxxxxxxx&amp;report=1&amp;convert=1&amp;route=1</span>\n		</p><span class=\"h_api\" style=\"font-size: 18px;\">POST METHOD</span>\n\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Use this method to send sms messages where the length of \"GET\n			METHOD\" is a limitation,<br>url:&nbsp;<span style=\"color: rgb(0, 85, 128);\">http://linkingsms.com/api/sendsms.php</span>&nbsp;<br>Data\n			to post: username=user&amp;password=1234&amp;sender=quicsms1&amp;message=testing &amp;recipient=2348030000000,23480xxxxxxxx&amp;report=1&amp;convert=1&amp;route=1\n		</p>\n\n		<hr>\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. recipient : The destination phone numbers. Separate multiple\n			numbers with comma(,)<br>3. username: Your  account username<br>4. password: Your  account\n			password<br>5. sender: The sender ID to show on the receiver\'s phone<br>6. message: The text message to be\n			sent<br>7. balance: Set to \'true\' only when you want to check your credit balance<br>6. schedule: Specify\n			this parameter only when you are scheduling an sms for later delivery. It should contain the date the\n			message should be delivered. Supported format is \"2010-10-01 12:30:00\" i.e \"YYYY-MM-DD HH:mm:ss\"<br>7.\n			convert: Specify and set this parameter to 1 only when you want to get the return code in string readable\n			format instead of the raw numbers below;<br>8. report: Set this parameter to 1 to retrieve the message id\n			which can later be used to retrieve the delivery report or else remove it or set it to 0<br>9. route: Set\n			this parameter to&nbsp;<b>0</b>&nbsp;to send message using the normal route (Will not deliver to DND\n			numbers). Set to&nbsp;<b>1</b>&nbsp;to send through normal route for numbers not on DND and send through\n			banking route for numbers on DND. Set to&nbsp;<b>2</b>&nbsp;to send all messages through the banking route.\n		</div>\n		<div class=\"t_api\"><br>The return values are:<br>OK = Successful<br>1 = Invalid Recipient(s) Number<br>2 = Cant\n			send Empty Message<br>3 = Invalid Sender ID<br>4 = Insufficient Balance<br>5 = Incorrect Username or\n			Password Specified<br>6 = Incorrect schedule date format<br>7 = Error sending message (Gateway not\n			available), Please try again later<br><br>Example:<br>On success, the following code will be returned<br>OK\n			21 = 4564<br><br>i.e \'OK\' \'No of sms credits used\' = \'Unique Message ID\'&nbsp;<br>where OK = The message was\n			sent successfully<br>21 = No of sms credits used<br>and 4564 = The unique message id of the sent message\n			which can be used to retrieve the delivery status of the sent message.\n		</div>\n		<span style=\"color: red;\">Note: When using GET METHOD to send message, the values should be properly encoded before sending it to our server</span>\n		<hr>\n		<br><span class=\"h_api\" style=\"font-size: 18px;\">CHECK ACCOUNT BALANCE</span>\n\n		<p style=\"margin-bottom: 10px; padding: 0px;\">You can use GET or POST METHOD to query your  account\n			balance.<span style=\"color: rgb(0, 85, 128);\">http://linkingsms.com/api/sendsms.php?username=user&amp;password=1234&amp;balance=1</span>\n		</p>\n\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. username: Your  account username<br>2. password:\n			Your  account password<br>3. balance: This most be included to inform our server that you want to\n			only check your account balance<br></div>\n		<br>\n\n		<div class=\"t_api\"><i>On successful, Your account balance would be returned e.g&nbsp;<b>5024</b></i></div>\n		<br>\n		<hr>\n		<span class=\"h_api\" style=\"font-size: 18px;\">DELIVERY REPORT</span>\n\n		<p style=\"margin-bottom: 10px; padding: 0px;\">Use Get Method to query the delivery report/status of the sent\n			message using the message id.<span style=\"color: rgb(0, 85, 128);\">http://linkingsms.com/api/getdelivery.php?username=user&amp;password=1234&amp;msgid=4564</span>\n		</p>\n\n		<div class=\"t_api\">The parameters are:&nbsp;<br>1. username: Your  account username<br>2. password:\n			Your  account password<br>3. msgid: The message id of the sent message you want to retrieve the\n			delivery status<br>3. html: Only Set this parameter to 1, to return the report in colourful html table\n			format. e.g html=1<br></div>\n		<br>\n\n		<div class=\"t_api\">On success, the following code will be returned.<br><i>2349038781252=DELIVERED=2015/10/25\n				23:11:34, 2349055552635=SENT=----/--/-- --:--:--</i><br>i.e \'Number\' = \'Delivery Status\' = \'Date and\n			Time of delivery\'&nbsp;<br>where 2349038781252 = Phone number<br>DELIVERED = The message had delivered<br>2015/10/25\n			23:11:34 = The date and time the message was delivered.\n		</div>\n	</blockquote>\n</section>'),
(4, 'theme_default_price', '<div style=\"width: 100%;\" align=\"center\">\n<h2><center>SMS PRICE</center></h2>\n<br>\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Volume</font></th>\n        <th><font color=\"#ffffff\">Price per SMS (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">All Network</td>\n        <td align=\"center\" style=\"padding: 3px;\">N2.00</td>\n    </tr>\n    </tbody>\n</table>\n\n<br>\n<h2><center>AIRTIME</center></h2>\n<br>\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Bundle</font></th>\n        <th><font color=\"#ffffff\">Price (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">MTN</td>\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Airtel</td>\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Glo</td>\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Etisalat</td>\n        <td align=\"center\" style=\"padding: 3px;\">2% commission</td>\n    </tr>\n    </tbody>\n</table><br>\n\n<h2><center>DATA PLAN</center></h2>\n<center style=\"color: red;\">Please login to check our current price</center>\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Network</font></th>\n        <th><font color=\"#ffffff\">Bundle & Price (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">MTN</td>\n        <td align=\"center\" style=\"padding: 3px;\">\n            1GB for N650<br>\n            2GB for N1,300\n        </td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Airtel</td>\n        <td align=\"center\" style=\"padding: 3px;\">300MB for N500</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Glo</td>\n        <td align=\"center\" style=\"padding: 3px;\">1GB for N400</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Etisalat</td>\n        <td align=\"center\" style=\"padding: 3px;\">2GB for N500</td>\n    </tr>\n    </tbody>\n</table><br>\n<h2><center>BILL PAYMENT</center></h2>\n<br>\n<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"fintable\" id=\"prizes\" style=\"border: 1px solid blue; box-shadow: rgb(255, 255, 153) 2px 0px 5px; max-width: 640px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal; width: 100%;\">\n    <tbody>\n    <tr class=\"head\" style=\"text-align: center; height: 44px; font-size: 18px; background-color: rgb(48, 51, 60); font-family: &quot;Time New Roman&quot;, cursive, monospace; color: rgb(222, 222, 222);\">\n        <th>Bill</font></th>\n        <th><font color=\"#ffffff\">Bundle & Price (Naira)</font></th>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">DSTV</td>\n        <td align=\"center\" style=\"padding: 3px;\">\n            DSTV Access = N19,500<br>\n            DSTV Family= N4,000<br>\n        </td>\n    </tr>\n\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: white; font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">GoTv</td>\n        <td align=\"center\" style=\"padding: 3px;\">GoTv pack = N1,000</td>\n    </tr>\n    <tr class=\"ash gn\" style=\"height: 23px; background-color: rgb(222, 222, 222); font-size: 20px; font-weight: bold; font-family: &quot;Courier New&quot;, Courier, monospace; color: green;\">\n        <td style=\"padding: 3px;\">Startimes</td>\n        <td align=\"center\" style=\"padding: 3px;\">Nova = N950</td>\n    </tr>\n    </tbody>\n</table>\n</div>\n\n'),
(4, 'theme_default_reseller', '<h2 align=\"left\"\n    style=\"color: red; font-size: 26px; margin: 0px 0px 25px; padding: 5px 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\">\n    RESELLER SERVICES:</h2>\n<div style=\"font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">\n    <blockquote\n        style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px;\">\n        <strong>Features that your members will enjoy:</strong><br>- Robust registration form (different from\n        joomla)<br>- Compose SMS with dynamic sender ID<br>- Type multiple sms recipients, select recipient group from\n        phonebook or upload recipients from text and csv(excel) file<br>- SMS character counter for composing SMS i.e\n        Page: 1, Characters left: 157, Total Typed Characters: 3<br>- SMS scheduling for future delivery with date\n        picker.<br>- Duplicate number remover.<br>- Numbers can be in the format of&nbsp;<strong>+2348080000000 or\n            2348080000000 or 08080000000</strong>.<br>- Separate multiple numbers and uploaded numbers with comma,\n        colon, semicolon or put each number on a separate line.<br>- Automatic removal of&nbsp;<strong>invalid\n            characters from numbers</strong>&nbsp;e.g space,;,:,.,\',`,(,),,{,},#,-,_ and ?<br>- Displays\n        member&nbsp;<strong>SMS units left and SMS Units used</strong><br>- Phone book to store phone groups and numbers<br>-\n        Add multiple numbers to phone book group at once<br>- Upload numbers to phone group from file<br>- Delete a\n        phone book group and all its records<br>- View to all sent sms messages with&nbsp;<strong>recipients,\n            message,status, credit used, date scheduled, date delivered</strong><br>- Search and forward sent sms\n        messages with page numbers and page size<br>- Order/Request/purchase sms credits with&nbsp;<strong>automatic\n            cost calculator</strong><br>- Transaction/purchase history with&nbsp;<strong>Transaction date, amount,\n            credit requested, status and date approved</strong><br>- Search and sort transaction history with page\n        numbers and page size<br>- View personal details<br>- Change password on settings page<br>- Set default sender\n        ID<br>- Members can&nbsp;<strong>transfer SMS units</strong>&nbsp;to another member\n    </blockquote>\n</div>\n<div class=\"cleaner\"\n     style=\"clear: both; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"></div>\n<blockquote\n    style=\"border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">\n    <strong>Admin Features:</strong><br>- Send sms to all members<br>- Specify No of free SMS units for new members e.g\n    new members get 3 free sms<br>- Specify how many sms units is regarded as low sms<br>- Alert member by sms and email\n    when credit is below your specified level<br>- Specify captcha type(local captcha or google recaptcha)<br>-\n    Create/edit Welcome SMS message for new members<br>- Create/edit SMS to send to members when their SMS orders have\n    been approved<br>- Create/edit SMS to send to members when their credit is below your specified level<br>-\n    Create/edit Welcome Email<br>- Create/edit Email to send to members when orders have been approved<br>- Create/edit\n    Email to send to members when their credit is below ur specified level<br>- Set/change SMS API Gateway URL to any\n    provider<br>- Create/edit Selling price per sms unit for different quantity of sms purchases<br>- Specify county\n    codes that use more that 1 sms unit per text message<br>- Set/edit No of records to display per page on member and\n    admin pages<br>- You\'ll get your own SMS Api to Give to your own customers and resellers.<br>- You\'ll get SMS Cron\n    Url for scheduled sms (If you want to add your own cron job for scheduled sms)- Export all phone numbers that have\n    ever recieved sms from you portal and your resellers in one click<br>- Export all phone numbers of all members in\n    one click<br>- Export all phone numbers in member phone books in one click<br>- Admin view of all address book\n    records and groups<br>- Admin view of all sms messages sent by members, resellers or through api<br>- Admin view of\n    all transactions for viewing, approval, cancelliung or deletion<br>- Automatically credits member sms account upon\n    approval of sms request transaction<br>- View, edit and delete any member account<br>- Manually reduce/increase any\n    member account SMS units<br>- Registration cannot be repeated for registered phone number/email address<br>- Free\n    GSM Phone Number generator<br>- Contact us form<br>- User Management&nbsp;<br>-&nbsp;<strong>And many more</strong>\n</blockquote>\n<div class=\"cleaner\"\n     style=\"clear: both; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\"></div><p\n    style=\"margin-bottom: 10px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;\"></p>\n<div id=\"pay\" style=\"font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;\">To become a&nbsp;<strong>Reseller</strong>&nbsp;and\n    start making profit online immediately, Please register as a normal member\n</div>'),
(10, 'notifications_registration_mail_title', 'WELCOME'),
(10, 'notifications_registration_mail', '<b>WELCOME @@fname@@</b> TO @@site_name@@<br>\nYour account registration was successful.<br>\nUsername: @@username@@<br>\nPassword: @@password@@\nThank you for your registration'),
(10, 'notifications_registration_mail_enabled', '1'),
(10, 'notifications_registration_sms_title', 'WELCOME'),
(10, 'notifications_registration_sms', 'WELCOME @@fname@@ TO @@site_name@@\n\nYour account registration was successful.\n\nUsername: @@username@@\n\nPassword: @@password@@\nThank you for your registration'),
(10, 'notifications_registration_sms_enabled', '1'),
(10, 'notifications_fund_wallet_mail_title', 'ACCOUNT CREDITED'),
(10, 'notifications_fund_wallet_mail', 'Dear @@fname@@,<br>Your account has been credited:<br><br>\nPrevious Balance: @@p_balance@@<br>\nAmount Paid: @@amount@@<br>\nTransaction Fee: @@transaction_fee@@<br>\n<b>Amount Credited: @@amount_credited@@</b><br>\nAccount Balance @@balance@@<br><br>\nThank You'),
(10, 'notifications_fund_wallet_mail_enabled', '1'),
(10, 'notifications_fund_wallet_sms_title', 'ACCOUNT CREDITED'),
(10, 'notifications_fund_wallet_sms', 'Dear @@fname@@,\nYour account has been credited with @@amount@@. Your new Account Balance is @@balance@@\n\nThank You'),
(10, 'notifications_fund_wallet_sms_enabled', '1'),
(10, 'notifications_password_reset_mail_title', 'PASSWORD RESET'),
(10, 'notifications_password_reset_mail', 'Dear @@fname@@,<br>Your have requested for a password reset:<br><br>Your reset code is @@code@@<br><BR>\nOr simply click on this link below<br>@@link@@'),
(10, 'notifications_password_reset_mail_enabled', '1'),
(10, 'notifications_password_reset_sms_title', 'PASSWORD RESET'),
(10, 'notifications_password_reset_sms', 'Dear @@fname@@,\nYour have requested for a password reset:\n\nYour reset code is @@code@@\n\nOr simply click on this link below\n@@link@@'),
(10, 'notifications_password_reset_sms_enabled', '1'),
(10, 'notifications_missed_you_mail_title', 'ITS BEEN A WHILE'),
(10, 'notifications_missed_you_mail', 'Dear @@fname@@,<br>Long Time, Its been a while. We have really missed you. We have added more features, why dont you visit us again to see for yourself. <br>Thank You'),
(10, 'notifications_missed_you_mail_day', '7'),
(10, 'notifications_missed_you_mail_enabled', '0'),
(10, 'notifications_missed_you_sms_title', 'ITS BEEN A WHILE'),
(10, 'notifications_missed_you_sms', 'Dear @@fname@@,\nLong Time, Its been a while. We have really missed you. We have added more features, why dont you visit us again to see for yourself. \nThank You'),
(10, 'notifications_missed_you_sms_day', '7'),
(10, 'notifications_missed_you_sms_enabled', '0'),
(10, 'payment_gateway_settings_atm_paystack_allow_reseller', ''),
(10, 'payment_gateway_settings_atm_voguepay_allow_reseller', ''),
(10, 'payment_gateway_settings_bitcoin_bitcoin_my_secret_key', 'tzLu7n4lsY'),
(10, 'theme_corlate_phone', '07066471119'),
(10, 'theme_corlate_description1', ''),
(10, 'theme_corlate_site_address', 'rockbulksms.com'),
(10, 'theme_corlate_welcome_title', ''),
(10, 'theme_corlate_welcome_content', '<p style=\"margin-bottom: 10px; color: rgb(78, 78, 78); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; letter-spacing: normal; text-align: center; background-color: rgb(242, 242, 242);\"><span style=\"color: rgb(55, 62, 74); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 21px; letter-spacing: 0.1px;\">We Provide Corporate and Individual Short Messaging Services which enables our clients to send text messages to many phone numbers through our Gateway.</span><br></p><h3 style=\"font-family: &quot;Open Sans&quot;, sans-serif; line-height: 24px; color: rgb(120, 120, 120); margin: 0px; font-size: 16px; letter-spacing: normal; text-align: center; background-color: rgb(242, 242, 242); padding: 0px; border: 0px;\"><br>We also allow our client to buy airtime, dataplan and bill payment from their wallet</h3>'),
(10, 'theme_corlate_faq_content', ''),
(10, 'theme_corlate_about_us_content', ''),
(10, 'theme_corlate_company_email', ''),
(10, 'theme_corlate_domain_name', ''),
(10, 'theme_corlate_facebook_link', ''),
(10, 'theme_corlate_twitter_link', ''),
(10, 'theme_corlate_linkedin_link', ''),
(10, 'theme_corlate_skype_link', ''),
(10, 'theme_corlate_top_header1', '#000000'),
(10, 'theme_corlate_top_header2', '#000000'),
(10, 'theme_corlate_logo', ''),
(10, 'theme_corlate_image1', ''),
(10, 'theme_corlate_slide1', '<h1 class=\"animation animated-item-1\">Welcome</h1>\n<h2 class=\"animation animated-item-2\">Send Bulk SMS at ease</h2>\n                                <a class=\"btn-slide animation animated-item-3\" href=\"#\" onclick=\'show_login()\'>Login</a>'),
(10, 'theme_corlate_image2', ''),
(10, 'theme_corlate_slide2', 'Register with us and ensure quick delivery if your messages'),
(10, 'theme_corlate_image3', ''),
(10, 'theme_corlate_slide3', 'Register with us and enjoy our services'),
(10, 'theme_corlate_footer', '	 <div class=\"col-md-3 col-sm-6\">\n                <div class=\"widget\">\n                    <h3>About US</h3>\n                    <ul>\n                        <li><a href=\"#\">About us</a></li>\n                        <li><a href=\"#\">Terms of use</a></li>\n                        <li><a href=\"#\">Privacy policy</a></li>\n                        <li><a href=\"#\">Contact us</a></li>\n                    </ul>\n                </div>\n            </div><!--/.col-md-3-->\n\n            <div class=\"col-md-3 col-sm-6\">\n                <div class=\"widget\">\n                    <h3>Support</h3>\n                    <ul>\n                        <li><a href=\"#\">Faq</a></li>\n                        <li><a href=\"#\">Documentation</a></li>\n                        <li><a href=\"#\">Refund policy</a></li>\n                    </ul>\n                </div>\n            </div><!--/.col-md-3-->\n\n            <div class=\"col-md-3 col-sm-6\">\n                <div class=\"widget\">\n                    <h3>Our Resources</h3>\n                    <ul>\n                        <li><a href=\"#\">Our FB</a></li>\n                        <li><a href=\"#\">On Youtube</a></li>\n                        <li><a href=\"#\">Our Blog</a></li>\n                    </ul>\n                </div>\n            </div><!--/.col-md-3-->\n\n            <div class=\"col-md-3 col-sm-6\">\n                <div class=\"widget\">\n                    <h3>Hot Links</h3>\n                    <ul>\n                        <li><a href=\"#\">Seller Page</a></li>\n                    </ul>\n                </div>\n            </div><!--/.col-md-3-->'),
(10, 'theme_corlate_submit', '\n													   Save\n												'),
(1, 'bill_gateway_3_apikey', 'c5a48cc2707849c89e0446769b61b9f42ad75adb8c6ff932038519905a8ea01c'),
(1, 'phase1_amount', 'N0'),
(1, 'phase1_period', '3'),
(1, 'phase1_cost_sms_rate', ''),
(1, 'phase1_cost_dnd_rate', ''),
(1, 'phase1_cost_bill_rate', ''),
(1, 'phase2_amount', 'N0'),
(1, 'phase2_period', '3'),
(1, 'phase2_cost_sms_rate', ''),
(1, 'phase2_cost_dnd_rate', ''),
(1, 'phase2_cost_bill_rate', ''),
(1, 'phase_advantages', ''),
(2, 'payment_gateway_settings_atm_voguepay_allow_reseller', ''),
(3, 'hp_notification_title', 'SMS AKJOLUS SHUTDOWN'),
(3, 'hp_notification_message', '<p><br></p><p><span style=\"font-size: 12px;\">We&nbsp; regret to inform you that SMS AKJOLUS&nbsp; will be shut down on 23TH May, 2019.</span></p><p><span style=\"font-size: 12px;\"><br></span></p><p><span style=\"font-size: 12px;\">This is due to accumulated reasons ranging from inability to deliver sms to DND numbers, low sms delivery guarantee, platform sustainability and high maintenance cost, and many more.&nbsp;</span></p><p><span style=\"font-size: 12px;\"><br></span></p><p><span style=\"font-size: 12px;\">You can still be able to buy and send sms with your remaining units before the shutdown date but our customer service line will be unavailable starting from 22ND MAY 2019.&nbsp;</span></p><p><span style=\"font-size: 12px;\"><br></span></p><p><span style=\"font-size: 12px;\">We greatly apologize for any inconveniences caused.&nbsp;</span></p><p><span style=\"font-size: 12px;\"><br></span></p><p><span style=\"font-size: 12px;\">We appreciate your consistent patronage over the years.&nbsp;</span></p><p><span style=\"font-size: 12px;\"><br></span></p><p><span style=\"font-size: 12px;\">Alternative site you could use is https://smartsmssolutions.com/rf.php?ref=10a221</span></p><p><span style=\"font-size: 12px;\"><br></span></p><p><span style=\"font-size: 12px;\">Just open this link directly and register</span></p><p><span style=\"font-size: 12px;\"><br></span></p><p><span style=\"font-size: 12px;\">Thank you</span></p><p><br></p>'),
(3, 'hp_notification_show_once', '0'),
(3, 'hp_notification_enabled', '1'),
(6, 'default_dnd_rate', '28'),
(6, 'default_rate', '27'),
(13, 'cemail', 'tallyconnections@yahoo.com'),
(13, 'cphone', '07062235837'),
(13, 'website', ''),
(13, 'site_name', ''),
(13, 'currency', 'N'),
(13, 'currency_suffix', ''),
(6, 'theme_login_bg_color1', '#940094'),
(6, 'current_frontend_theme', 'default'),
(2, 'payment_gateway_settings_atm_paystack_allow_reseller', '');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id` int(11) NOT NULL,
  `owner` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `purpose` varchar(30) NOT NULL DEFAULT '',
  `token` varchar(100) NOT NULL DEFAULT '',
  `expires` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `owner` int(11) DEFAULT NULL,
  `username` varchar(100) NOT NULL DEFAULT '',
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `birthday` int(11) DEFAULT '0',
  `sex` varchar(10) DEFAULT NULL,
  `balance` decimal(8,2) NOT NULL DEFAULT '0.00',
  `previous_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `commission` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_units` decimal(8,2) NOT NULL DEFAULT '0.00',
  `debt` decimal(8,2) NOT NULL DEFAULT '0.00',
  `country` int(11) DEFAULT '0',
  `state` varchar(50) DEFAULT NULL,
  `lga` varchar(50) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `last_password` varchar(100) NOT NULL DEFAULT '',
  `rate` varchar(500) NOT NULL DEFAULT '',
  `dnd_rate` varchar(500) NOT NULL DEFAULT '',
  `bill_rate` int(11) DEFAULT '0',
  `gateway` int(11) NOT NULL DEFAULT '0',
  `route` int(11) NOT NULL DEFAULT '0',
  `access` int(11) DEFAULT '0',
  `is_admin` tinyint(4) DEFAULT '0',
  `properties` longtext,
  `sender_id` varchar(15) NOT NULL,
  `disabled` int(11) NOT NULL DEFAULT '0',
  `disabled_text` varchar(200) DEFAULT NULL,
  `last_login` int(11) DEFAULT '0',
  `last_login2` int(11) NOT NULL DEFAULT '0',
  `last_activity` int(11) DEFAULT '0',
  `last_device` varchar(200) DEFAULT '',
  `last_ip` varchar(20) NOT NULL DEFAULT '',
  `last_ip2` varchar(20) NOT NULL DEFAULT '',
  `vip_package` tinyint(4) DEFAULT '0',
  `vip_expires` int(11) DEFAULT '0',
  `registration_date` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `owner`, `username`, `fname`, `mname`, `surname`, `birthday`, `sex`, `balance`, `previous_balance`, `commission`, `total_units`, `debt`, `country`, `state`, `lga`, `phone`, `email`, `password`, `last_password`, `rate`, `dnd_rate`, `bill_rate`, `gateway`, `route`, `access`, `is_admin`, `properties`, `sender_id`, `disabled`, `disabled_text`, `last_login`, `last_login2`, `last_activity`, `last_device`, `last_ip`, `last_ip2`, `vip_package`, `vip_expires`, `registration_date`) VALUES
(1, 1, 'admin', 'Admin', NULL, 'Admin', 0, 'male', 2131.97, 0.00, 0.00, 116901.67, 0.00, 0, NULL, NULL, '07000000000', 'admin@gmail.com', '$2y$10$R72HoV/4Bei0lzqla3i7SOqd5FB4/5Cgrh7Qpm/yLaLOXuAJVdCT2', '', '', '', 0, 0, 0, -1, 1, NULL, '', 0, NULL, 1597186741, 1561889944, 1597186867, 'Desktop/Mobile', '197.210.71.190', '154.118.57.123', 0, 0, 1512247651);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill_gateway`
--
ALTER TABLE `bill_gateway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_history`
--
ALTER TABLE `bill_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id_index` (`owner`,`transaction_id`);

--
-- Indexes for table `bill_rate`
--
ALTER TABLE `bill_rate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cryptocurrency`
--
ALTER TABLE `cryptocurrency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_report`
--
ALTER TABLE `delivery_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `domain`
--
ALTER TABLE `domain`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_domain` (`domain`);

--
-- Indexes for table `draft`
--
ALTER TABLE `draft`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `epins`
--
ALTER TABLE `epins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `owner` (`owner`,`pin`);

--
-- Indexes for table `epins_category`
--
ALTER TABLE `epins_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateway`
--
ALTER TABLE `gateway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income_expense`
--
ALTER TABLE `income_expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income_expense_categories`
--
ALTER TABLE `income_expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_read`
--
ALTER TABLE `notification_read`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `notification_user` (`notification_id`,`user_id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phonebook`
--
ALTER TABLE `phonebook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `read_notification`
--
ALTER TABLE `read_notification`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `notification_id` (`notification_id`,`user_id`);

--
-- Indexes for table `recipient`
--
ALTER TABLE `recipient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sent_id` (`sent_id`,`user_id`,`phone`),
  ADD KEY `msg_id` (`msg_id`);

--
-- Indexes for table `reseller`
--
ALTER TABLE `reseller`
  ADD PRIMARY KEY (`owner`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sent`
--
ALTER TABLE `sent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sent_mail`
--
ALTER TABLE `sent_mail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill_gateway`
--
ALTER TABLE `bill_gateway`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_history`
--
ALTER TABLE `bill_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_rate`
--
ALTER TABLE `bill_rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cryptocurrency`
--
ALTER TABLE `cryptocurrency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_report`
--
ALTER TABLE `delivery_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003719;

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `domain`
--
ALTER TABLE `domain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `draft`
--
ALTER TABLE `draft`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `epins`
--
ALTER TABLE `epins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `epins_category`
--
ALTER TABLE `epins_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gateway`
--
ALTER TABLE `gateway`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `income_expense`
--
ALTER TABLE `income_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `income_expense_categories`
--
ALTER TABLE `income_expense_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_read`
--
ALTER TABLE `notification_read`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phonebook`
--
ALTER TABLE `phonebook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rate`
--
ALTER TABLE `rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `read_notification`
--
ALTER TABLE `read_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipient`
--
ALTER TABLE `recipient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reseller`
--
ALTER TABLE `reseller`
  MODIFY `owner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sent`
--
ALTER TABLE `sent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sent_mail`
--
ALTER TABLE `sent_mail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12818;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
