-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2016 at 04:20 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbo_event management`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(30) NOT NULL AUTO_INCREMENT,
  `categoryname` varchar(250) NOT NULL,
  `categoryimage` varchar(250) NOT NULL,
  `categorydescription` varchar(250) NOT NULL,
  `status` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `categoryname` (`categoryname`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `categoryname`, `categoryimage`, `categorydescription`, `status`) VALUES
(25, 'test11111', 'Chrysanthemum.jpg', 'testq1111', 'inactive'),
(26, 'FESTIVAL', 'Tulips.jpg', 'FESTIVAL INNOVATION', 'active'),
(27, 'ART', 'Desert.jpg', 'ART', 'active'),
(28, 'TEST1', 'Hydrangeas.jpg', 'TEST', 'active'),
(37, 'ERT', 'Penguins.jpg', 'ERT', 'active'),
(38, 'REST', 'Jellyfish.jpg', 'REST', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `ID` int(30) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Venue` varchar(255) NOT NULL,
  `latitude` decimal(10,6) NOT NULL,
  `longitude` decimal(10,6) NOT NULL,
  `Event_start_date` date NOT NULL,
  `Event_end_date` date NOT NULL,
  `Eventstatus` varchar(255) DEFAULT NULL,
  `TicketAmount` decimal(10,6) NOT NULL DEFAULT '0.000000',
  `Capacity` int(250) NOT NULL,
  `Booking_start_date` date NOT NULL,
  `Booking_end_date` date NOT NULL,
  `category_id` int(30) NOT NULL,
  `Address` varchar(250) NOT NULL,
  `Status` int(12) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `event_ibfk_1` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`ID`, `Title`, `Description`, `Venue`, `latitude`, `longitude`, `Event_start_date`, `Event_end_date`, `Eventstatus`, `TicketAmount`, `Capacity`, `Booking_start_date`, `Booking_end_date`, `category_id`, `Address`, `Status`) VALUES
(11, 'TEST', 'TEST', 'ahmedabad', '0.000000', '0.000000', '2016-07-04', '2016-07-05', 'public', '0.000000', 60, '2016-07-26', '2016-07-27', 27, 'ahmedabad', 0),
(16, 'SAVAJ', 'SAVAJ', 'SAVAJ', '0.000000', '0.000000', '2016-07-19', '2016-07-20', 'public', '0.000000', 50, '2016-07-13', '2016-07-14', 27, 'Ahmedabad', 0),
(17, 'QWE', 'QWE', 'QWE', '0.000000', '0.000000', '2016-07-25', '2016-07-26', 'public', '0.000000', 500, '2016-07-25', '2016-07-26', 27, 'QWE', 0),
(20, 'QWER', 'QWER', 'QWER', '0.000000', '0.000000', '2016-07-19', '2016-07-20', 'public', '0.000000', 500, '2016-07-19', '2016-07-20', 27, 'Ahmedabad', 0);

-- --------------------------------------------------------

--
-- Table structure for table `image_master`
--

CREATE TABLE IF NOT EXISTS `image_master` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `ID` int(30) NOT NULL,
  `Main_image` varchar(255) NOT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`image_id`),
  KEY `image_master_ibfk_2` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `image_master`
--

INSERT INTO `image_master` (`image_id`, `image`, `ID`, `Main_image`, `is_main`) VALUES
(34, 'a:2:{i:0;s:17:"Chrysanthemum.jpg";i:1;s:10:"Desert.jpg";}', 11, '', 0),
(35, 'a:2:{i:0;s:13:"Jellyfish.jpg";i:1;s:9:"Koala.jpg";}', 16, '', 0),
(36, 'a:2:{i:0;s:14:"Lighthouse.jpg";i:1;s:12:"Penguins.jpg";}', 17, '', 0),
(38, 'a:2:{i:0;s:14:"Hydrangeas.jpg";i:1;s:14:"Lighthouse.jpg";}', 20, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(30) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_mail` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_profile` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_mail`, `user_pass`, `user_profile`, `is_admin`) VALUES
(4, 'Admin', 'admin@gmail.com', '$2y$10$eOCdg2YyIOVYcxSobsWNt.i6Y4aO6.6o4XqaqfRdHss9JNlEhoOuq', 'Savaj.jpg', 1),
(24, 'test', 'test@gmail.com', '$2y$10$0l3Iil.aVR7/dl0dvXyMru..jKcNqi7urjxmdbU38L3Smyh11dqwy', 'Koala.jpg', 0),
(25, 'Savaj', 'savajpatel@gmail.com', '$2y$10$frznWbiUv/KF9b2pQVS2Z.C1PyFEK3mv/VCsZvZjEBZIwz0pdJr9G', 'Hydrangeas.jpg', 0),
(26, 'savaj', 'Savajpatel@gmail.com', '$2y$10$0Lj.2B0cQ2xBe.AfolbnDe6qJdHEIkoml9s5M/z8zIsoLax/91E36', 'Desert.jpg', 0),
(27, 'samer', 'Samer@gmail.com', '$2y$10$WUm2dLB3Yg5iMNe/5cBi4ump6EHGJAW3snZN7Uhl9a8DyGM6ml3hy', 'Chrysanthemum.jpg', 0),
(28, 'test', 'test@gmail.com', '$2y$10$2Wy8weDk5M2eagDd7c/x.uYc0yDvS.R4thtH6xD.rcqBDRNa.jDfa', 'Koala.jpg', 0),
(31, 'ram', 'ram@gmail.com', '$2y$10$wtp2cPVk9VpfmKFC/TjV4u.TaOtUkOtGdLsZ.TLO5xJYFCAy9/sdy', 'Hydrangeas.jpg', 0),
(32, 'Savaj', 'Savajpatel@gmail.com', '$2y$10$gPpfw3V66ol8xseqwQkuculxbvs3.vwuVwpAvlXJ7OI5yN.DKZWvm', 'Hydrangeas.jpg', 0),
(33, 'admin', 'test@gmail.com', '$2y$10$ocAanTnTtY2e/Lznm3dDlu4LW34kUg0vTYYPEVsMY8BoclomrPTyG', 'Desert.jpg', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `image_master`
--
ALTER TABLE `image_master`
  ADD CONSTRAINT `image_master_ibfk_2` FOREIGN KEY (`ID`) REFERENCES `event` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
