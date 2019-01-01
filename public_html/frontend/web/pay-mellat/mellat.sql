-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 01, 2014 at 01:43 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `env_sys`
--

CREATE TABLE IF NOT EXISTS `env_sys` (
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `info` int(50) NOT NULL,
  PRIMARY KEY (`name`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `env_sys`
--

INSERT INTO `env_sys` (`name`, `value`, `info`) VALUES
('admin_username', '21232f297a57a5a743894a0e4a801fc3', 0),
('admin_password', 'aba1a55910444a23dbcad68d17658d63', 0),
('admin_SID', '4e41596ed41a1bd994e5260e2e198ec2', 0),
('admin_lastlogin', '13930310225846', 0),
('admin_ips', '127.0.0.1,127.0.0.1,89.165.97.210,188.158.88.139', 0);

-- --------------------------------------------------------

--
-- Table structure for table `epay_info`
--

CREATE TABLE IF NOT EXISTS `epay_info` (
  `payid` bigint(20) NOT NULL AUTO_INCREMENT,
  `bank` enum('mellat','parsian','sepah','melli','saman','tejarat','maskan','enbank','saderat','pasargad','sina','day','ansar','post','sarmayeh','city') CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `cost` bigint(20) NOT NULL,
  `date` bigint(14) NOT NULL,
  `orderid` varchar(50) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `refid` varchar(50) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `data_names` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `data_values` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `paystatus` enum('payed','done','started') CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`payid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `logs_mellat`
--

CREATE TABLE IF NOT EXISTS `logs_mellat` (
  `orderid` bigint(20) NOT NULL AUTO_INCREMENT,
  `amount` bigint(20) NOT NULL,
  `date` int(8) NOT NULL,
  `time` int(6) NOT NULL,
  `sorderid` bigint(20) NOT NULL,
  `refid` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `err` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `function` enum('Pay','Verify','Settle','Inquiry','Reversal','Refund','RefundVerify','RefundInquiry','DynamicPay') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`orderid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
