-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 06, 2012 at 04:57 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

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
-- Table structure for table `gateways`
--

CREATE TABLE IF NOT EXISTS `gateways` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `auth1` varchar(100) NOT NULL,
  `auth2` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `active` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'clients', 'Clients');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(30) NOT NULL,
  `client_id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `items` longtext NOT NULL,
  `amount_paid` varchar(30) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invoice_description` varchar(150) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Unpaid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `meta`
--

CREATE TABLE IF NOT EXISTS `meta` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `timezone` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `meta`
--

INSERT INTO `meta` (`id`, `user_id`, `first_name`, `last_name`, `company`, `phone`, `address`, `timezone`) VALUES
(1, 1, 'Admin', 'istrator', 'ADMIN', '', '', 'America/Phoenix');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `gateway` varchar(60) NOT NULL,
  `amount` varchar(60) NOT NULL,
  `invoice` varchar(60) NOT NULL,
  `transaction_id` varchar(60) NOT NULL,
  `misc` varchar(100) NOT NULL,
  `client` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(150) NOT NULL,
  `client` int(50) NOT NULL,
  `quote` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `project_group` int(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `client`, `quote`, `created`, `last_update`, `project_group`, `status`) VALUES
(5, 'Website', 'A simple basic wordpress website', 2, '300.00', '2012-06-01 06:34:26', '2012-05-31 23:34:26', 1, 'Active'),
(6, 'test1', 'test1', 2, '500.00', '2012-06-23 08:03:31', '2012-06-23 01:03:31', 1, 'Active'),
(7, 'sucka', 'sucka', 2, '999.99', '2012-06-23 08:03:45', '2012-06-23 01:03:45', 1, 'Active'),
(8, 'future', 'future', 2, '20.00', '2012-06-23 08:04:01', '2012-06-23 01:04:01', 1, 'Active'),
(9, 'bless', 'bless', 2, '200.00', '2012-06-23 08:04:14', '2012-06-23 01:04:14', 1, 'Active'),
(10, 'thousand', '1000', 2, '1000.00', '2012-06-23 08:04:39', '2012-06-23 01:04:39', 1, 'Active'),
(11, 'test5', 'test5', 2, '200.00', '2012-06-23 08:05:46', '2012-06-23 01:05:46', 1, 'Active'),
(12, 'test6', 'test6', 2, '99.99', '2012-06-23 08:07:11', '2012-06-23 01:07:11', 1, 'Active'),
(13, 'blue', 'blue', 2, '30.00', '2012-06-23 08:07:28', '2012-06-23 01:07:28', 1, 'Active'),
(14, 'red', 'red', 2, '999.99', '2012-06-23 08:07:40', '2012-06-23 01:07:40', 1, 'Active'),
(15, 'green', 'green', 2, '2229.90', '2012-06-23 08:07:57', '2012-06-23 01:07:57', 1, 'Active'),
(16, 'reddir', 'reddir', 2, '90050.00', '2012-06-23 08:08:13', '2012-06-23 01:08:13', 1, 'Active'),
(17, 'fb clone', 'fb clone', 2, '600.00', '2012-06-23 08:08:47', '2012-06-23 01:08:47', 1, 'Active'),
(18, 'builder', 'builder', 2, '230.00', '2012-06-23 08:09:03', '2012-06-23 01:09:03', 1, 'Active'),
(19, 'gogogo', 'go', 2, '99.99', '2012-06-23 08:09:19', '2012-06-23 01:09:19', 1, 'Active'),
(20, 'forty', 'forty', 2, '40.00', '2012-06-23 08:09:37', '2012-06-23 01:09:37', 1, 'Active'),
(21, 'shade web', 'shade web awesome project', 10, '200.00', '2012-07-06 04:59:34', '2012-07-05 21:59:34', 1, 'Active'),
(22, 'test', 'test5', 12, '300.00', '2012-07-06 11:33:23', '2012-07-06 04:33:23', 1, 'Active'),
(23, 'testDNIDOFNIOGFDS', '1000', 12, '99.99', '2012-07-06 11:38:53', '2012-07-06 04:38:53', 1, 'Active'),
(24, '50MILLION', 'dollars', 12, '0.00', '2012-07-06 11:40:25', '2012-07-06 04:40:25', 1, 'Active'),
(25, 'HEXEDECIMAL', 'NORT', 12, '0.00', '2012-07-06 11:44:05', '2012-07-06 04:44:05', 1, 'Active'),
(26, 'IONIO', 'JIOJIO', 12, '0.00', '2012-07-06 11:45:33', '2012-07-06 04:45:33', 1, 'Active'),
(27, 'REDGREENBLUE', 'ndiosnfdiofdsniosdf', 12, '98.00', '2012-07-06 11:46:35', '2012-07-06 04:46:35', 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `project_groups`
--

CREATE TABLE IF NOT EXISTS `project_groups` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `description` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_updates`
--

CREATE TABLE IF NOT EXISTS `project_updates` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `project_id` int(150) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `option_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` mediumtext NOT NULL,
  `option_group` varchar(55) NOT NULL DEFAULT 'site',
  `auto_load` enum('no','yes') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`,`option_name`),
  KEY `option_name` (`option_name`),
  KEY `auto_load` (`auto_load`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`option_id`, `option_name`, `option_value`, `option_group`, `auto_load`) VALUES
(1, 'site_name', 'Clients Manager', 'site', 'yes'),
(2, 'company_name', 'Test Company', 'addon', 'yes'),
(3, 'company_address1', '120 Fake Company rd.', 'addon', 'yes'),
(4, 'company_address2', 'Suite 291', 'addon', 'yes'),
(5, 'company_city', 'Tempe', 'addon', 'yes'),
(6, 'company_state', 'Arizona', 'addon', 'yes'),
(7, 'company_country', 'United States', 'addon', 'yes'),
(8, 'company_phone', '480-621-2748', 'addon', 'yes'),
(9, 'invoice_terms', 'NET 30 Days Finance charge of 1.5% will be made on unpaid balances after 30 days', 'addon', 'yes'),
(10, 'company_email', 'ron@vuurr.com', 'addon', 'yes'),
(11, 'company_logo', 'public/img/sample_logo.jpg', 'addon', 'yes'),
(12, 'tax_percent', '7.3', 'addon', 'yes'),
(16, 'timezone', 'America/Phoenix', 'addon', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `issue` text NOT NULL,
  `client` int(30) NOT NULL,
  `project` int(30) NOT NULL,
  `date_opened` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(30) NOT NULL,
  `reply` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint(8) unsigned NOT NULL,
  `ip_address` char(16) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `group_id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `remember_code`, `created_on`, `last_login`, `active`) VALUES
(1, 1, '127.0.0.1', 'administrator', '5ec7e430394b57eff9a94e962e6cbeb728eed865', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, 1268889823, 1341546516, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
