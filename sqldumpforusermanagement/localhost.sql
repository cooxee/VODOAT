-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2013 at 08:33 PM
-- Server version: 5.5.28
-- PHP Version: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vodoat`
--
CREATE DATABASE `vodoat` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `vodoat`;

-- --------------------------------------------------------

--
-- Table structure for table `vodoat_authorized`
--

DROP TABLE IF EXISTS `vodoat_authorized`;
CREATE TABLE IF NOT EXISTS `vodoat_authorized` (
  `tag_id` int(20) NOT NULL,
  `fname` varchar(25) NOT NULL,
  `lname` varchar(25) NOT NULL,
  `car_model` varchar(75) NOT NULL,
  `wnumber` varchar(8) NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `status` varchar(1) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vodoat_authorized`
--

INSERT INTO `vodoat_authorized` (`tag_id`, `fname`, `lname`, `car_model`, `wnumber`, `start_time`, `end_time`, `status`) VALUES
(823, 'Pao', 'Yang1', 'Ferrari f550', 'w0437128', '2012-11-28', '2012-11-30', 'y'),
(847, 'Diwas', 'Bhattarai', 'ferrari F550', 'w0437128', '2012-11-29', '2030-12-11', 'y'),
(861, 'Test', 'Test', 'gjfj', 'w0432473', '2012-11-29', '2030-12-11', 'y');

-- --------------------------------------------------------

--
-- Table structure for table `vodoat_rfid`
--

DROP TABLE IF EXISTS `vodoat_rfid`;
CREATE TABLE IF NOT EXISTS `vodoat_rfid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` int(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=423 ;

--
-- Dumping data for table `vodoat_rfid`
--

INSERT INTO `vodoat_rfid` (`id`, `tag`, `date`) VALUES
(383, 861, '2012-12-06 18:35:25'),
(384, 823, '2012-12-06 18:35:55'),
(385, 861, '2012-12-06 18:36:33'),
(386, 823, '2012-12-06 18:36:59'),
(387, 861, '2012-12-06 18:37:12'),
(388, 999, '2012-12-06 18:38:11'),
(389, 861, '2012-12-06 18:38:33'),
(390, 823, '2012-12-06 18:39:09'),
(391, 861, '2012-12-06 18:41:47'),
(392, 823, '2012-12-06 18:41:50'),
(393, 861, '2012-12-06 18:41:54'),
(394, 999, '2012-12-06 18:42:08'),
(395, 861, '2012-12-06 18:42:09'),
(396, 823, '2012-12-06 18:44:27'),
(397, 861, '2012-12-06 18:46:59'),
(398, 823, '2012-12-06 19:07:33'),
(399, 861, '2012-12-06 19:07:37'),
(400, 823, '2012-12-06 19:08:00'),
(401, 861, '2012-12-06 19:08:53'),
(402, 823, '2012-12-06 19:09:06'),
(403, 861, '2012-12-06 19:09:11'),
(404, 823, '2012-12-06 19:09:28'),
(405, 861, '2012-12-06 19:09:37'),
(406, 823, '2012-12-06 19:09:44'),
(407, 861, '2012-12-06 19:09:46'),
(408, 823, '2012-12-06 19:10:04'),
(409, 861, '2012-12-06 19:10:14'),
(410, 823, '2012-12-06 19:11:23'),
(411, 861, '2012-12-06 19:12:05'),
(412, 845, '2012-12-06 19:12:26'),
(413, 861, '2012-12-06 19:12:29'),
(414, 1689, '2012-12-06 19:12:50'),
(415, 845, '2012-12-06 19:12:53'),
(416, 861, '2012-12-06 19:13:38'),
(417, 1689, '2012-12-06 19:13:45'),
(418, 861, '2012-12-06 19:16:44'),
(419, 1689, '2012-12-06 19:16:48'),
(420, 861, '2012-12-06 19:17:05'),
(421, 1689, '2012-12-06 19:17:54'),
(422, 861, '2012-12-06 19:18:05');

-- --------------------------------------------------------

--
-- Table structure for table `vodoat_user`
--

DROP TABLE IF EXISTS `vodoat_user`;
CREATE TABLE IF NOT EXISTS `vodoat_user` (
  `user_id` int(9) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_password` varchar(89) NOT NULL,
  `user_status` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vodoat_user`
--

INSERT INTO `vodoat_user` (`user_id`, `user_name`, `user_password`, `user_status`) VALUES
(1, 'w0437128', '4233137d1c510f2e55ba5cb220b864b11033f156', 'y');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
