-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2015 at 04:20 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `smartspo_master1`
--

-- --------------------------------------------------------

--
-- Table structure for table `acos`
--

CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `foreign_key` int(10) unsigned DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_acos_lft_rght` (`lft`,`rght`),
  KEY `idx_acos_alias` (`alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, '', NULL, 'controllers', 1, 6),
(2, 1, '', NULL, 'Test', 2, 5),
(3, 2, '', NULL, 'index', 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `alliances`
--

CREATE TABLE IF NOT EXISTS `alliances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `alliances`
--

INSERT INTO `alliances` (`id`, `created`, `modified`, `name`) VALUES
(1, '2015-09-19 12:16:40', '2015-09-19 12:17:15', 'Hrvatski testni savez');

-- --------------------------------------------------------

--
-- Table structure for table `aros`
--

CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `foreign_key` int(10) unsigned DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_aros_lft_rght` (`lft`,`rght`),
  KEY `idx_aros_alias` (`alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Group', 1, 'Admins', 1, 6),
(2, NULL, 'Group', 2, '', 7, 8),
(7, NULL, 'User', 7, '', 11, 12),
(4, 1, 'User', 4, '', 2, 3),
(5, 1, 'User', 5, '', 4, 5),
(6, NULL, 'User', 6, '', 9, 10),
(8, NULL, 'User', 8, '', 13, 14),
(9, NULL, 'User', 0, '', 15, 16),
(10, NULL, 'User', 0, '', 17, 18),
(11, NULL, 'User', 0, '', 19, 20),
(12, NULL, 'User', 0, '', 21, 22);

-- --------------------------------------------------------

--
-- Table structure for table `aros_acos`
--

CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) unsigned NOT NULL,
  `aco_id` int(10) unsigned NOT NULL,
  `_create` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `_read` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `_update` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `_delete` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_aco_id` (`aco_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 1, 1, '1', '1', '1', '1'),
(2, 1, 3, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE IF NOT EXISTS `clubs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `clubs`
--

INSERT INTO `clubs` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Testni klub 2', '2015-09-01 00:00:00', '2015-09-12 21:17:55'),
(2, 'miro', '2015-09-12 21:18:48', '2015-09-12 21:18:48');

-- --------------------------------------------------------

--
-- Table structure for table `competitions`
--

CREATE TABLE IF NOT EXISTS `competitions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `type_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `competitions`
--

INSERT INTO `competitions` (`id`, `title`, `created`, `modified`, `type_id`, `start_date`, `end_date`) VALUES
(1, 'Testno natjecanje 2014', '2015-09-01 00:00:00', '2015-09-19 10:31:07', 2, '2015-09-13', '2015-09-13'),
(4, 'Miro', '2015-09-13 18:27:52', '2015-09-13 20:21:50', 2, '2015-09-13', '2015-09-13'),
(5, 'tzest', '2015-09-13 20:23:54', '2015-09-13 20:23:54', 1, '2015-09-29', '2015-09-30');

-- --------------------------------------------------------

--
-- Table structure for table `competition_types`
--

CREATE TABLE IF NOT EXISTS `competition_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `competition_types`
--

INSERT INTO `competition_types` (`id`, `name`) VALUES
(1, 'Team'),
(2, 'Individual');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `competition_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `created`, `modified`, `title`, `competition_id`, `start_time`, `end_time`) VALUES
(1, '2015-09-19 10:57:53', '2015-09-19 11:01:38', 'dsada', 1, '2015-09-19 00:00:00', '2015-09-19 00:00:00'),
(2, '2015-09-19 11:42:51', '2015-09-19 11:42:51', 'miro', 5, '2015-09-19 00:00:00', '2015-09-19 00:00:00'),
(3, '2015-09-19 11:43:06', '2015-09-19 11:43:06', 'dsadasaaaaaaaa', 4, '2015-09-19 00:00:00', '2015-09-19 00:00:00'),
(4, '2015-09-19 11:43:16', '2015-09-19 11:43:16', 'sdaaaaaaa', 5, '2015-09-19 00:00:00', '2015-09-19 00:00:00'),
(5, '2015-09-19 11:43:33', '2015-09-19 11:43:33', 'aaaaa', 1, '2015-09-29 00:00:00', '2015-09-22 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Administrators', '2015-09-01 03:33:21', '2015-09-01 03:33:21'),
(2, 'Users', '2015-09-01 03:34:10', '2015-09-01 03:34:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `group_id` int(11) NOT NULL,
  `oib` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created`, `modified`, `username`, `password`, `mail`, `name`, `surname`, `role`, `group_id`, `oib`) VALUES
(4, '2015-09-01 03:38:12', '2015-09-13 12:05:55', 'admin2', '$2a$10$FM/hh6JHUmPltQX3DxagWOZVxbKgiduSNsDDbuoOO4h2UqfnGG9IC', 'mail', 'Ime', 'prezime', '', 1, ''),
(5, '2015-09-01 05:11:52', '2015-09-12 13:20:04', 'miro', '$2a$10$3RWNl6b.QzHnoTpmYAYgEu08uvCCLDLRMMtl6.XBn3UckTG/ihRHW', 'miro@maidea.hr', 'Miro2', 'Ćosić', '', 1, ''),
(6, '2015-09-12 13:16:19', '2015-09-12 13:23:20', 'username', '', 'mail2', 'Miro', 'Cosic', '', 0, ''),
(7, '2015-09-12 19:48:41', '2015-09-12 19:49:37', 'peroperic', '', 'pero@peric.hr', 'Pero', 'Perić', '', 0, ''),
(8, '2015-09-12 19:50:10', '2015-09-13 12:09:14', 'mirek1', '', 'miro@miro.com', 'Miro', 'Mirić', '', 0, ''),
(11, '2015-09-13 12:05:34', '2015-09-13 12:05:34', '', '', '', '', '', '', 0, ''),
(12, '2015-09-13 12:07:07', '2015-09-13 12:07:07', '', '', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `users_clubs`
--

CREATE TABLE IF NOT EXISTS `users_clubs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `admin` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `users_clubs`
--

INSERT INTO `users_clubs` (`id`, `user_id`, `club_id`, `admin`) VALUES
(1, 5, 1, 1),
(10, 4, 1, 0),
(17, 8, 2, 0),
(18, 8, 2, 0),
(21, 5, 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
