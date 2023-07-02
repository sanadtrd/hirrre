-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 06, 2020 at 05:15 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hirrre`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `field` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `mcheck` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `email`, `password`, `field`, `description`, `website`, `location`, `mcheck`) VALUES
(1, 'Swvl', 'swvl@hr.com', 'swvl', 'Transportation', 'Swvl is a revolutionary idea that was born from passion, loyalty and persistence to face all challenges on the table. ', 'www.swvl.io', 'Egypt, Cairo', 2),
(2, 'Salsh', 'hr@slash.com', '123', '', '', '', '', 2),
(4, 'Disney', 'hr@disney.com', '12345', 'Entertainment', '', '', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `individuals`
--

DROP TABLE IF EXISTS `individuals`;
CREATE TABLE IF NOT EXISTS `individuals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `current_position` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `mcheck` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `individuals`
--

INSERT INTO `individuals` (`id`, `username`, `name`, `email`, `password`, `current_position`, `description`, `mcheck`) VALUES
(1, 'sallysam2', 'Sally Sam', 'saly@sam.com', 'saly', 'd', 'hello this is me', 1),
(3, '', 'Asli Burak', 'asli@burak.com', '123', 'Senior Developer', 'Hey, I\'m Sandy I love to work!!!', 1),
(5, 'asmsanad', 'Ahmed Sanad', 'asm@sanad.xyz', '123', 'Web Developer', '', 1),
(8, 'test', 'tets', 'test@gg.com', 'password', '$cp', '$des', 1),
(9, 'asd', 'Ahmed', 'asd@asd.com', '123', 'sad', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `individuals_accomp`
--

DROP TABLE IF EXISTS `individuals_accomp`;
CREATE TABLE IF NOT EXISTS `individuals_accomp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `individual_id` int(11) NOT NULL,
  `acc_title` varchar(255) NOT NULL,
  `acc_type` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `individual_id` (`individual_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `individuals_education`
--

DROP TABLE IF EXISTS `individuals_education`;
CREATE TABLE IF NOT EXISTS `individuals_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `individual_id` int(11) NOT NULL,
  `institution_name` varchar(255) NOT NULL,
  `ins_type` varchar(255) NOT NULL,
  `start_year` int(11) NOT NULL,
  `end_year` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `individual_id` (`individual_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `individuals_education`
--

INSERT INTO `individuals_education` (`id`, `individual_id`, `institution_name`, `ins_type`, `start_year`, `end_year`) VALUES
(14, 8, 'test', 'tes', 456, 456),
(15, 8, 'test', 'test', 356, 23),
(16, 8, 'test', 'testt', 234, 4);

-- --------------------------------------------------------

--
-- Table structure for table `individuals_experience`
--

DROP TABLE IF EXISTS `individuals_experience`;
CREATE TABLE IF NOT EXISTS `individuals_experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `individual_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `start_wyear` int(11) NOT NULL,
  `end_wyear` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `individual_id` (`individual_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `individuals_experience`
--

INSERT INTO `individuals_experience` (`id`, `individual_id`, `company_name`, `position`, `start_wyear`, `end_wyear`) VALUES
(13, 8, 'google', 'security', 2015, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `offered_jobs`
--

DROP TABLE IF EXISTS `offered_jobs`;
CREATE TABLE IF NOT EXISTS `offered_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `job_type` varchar(255) NOT NULL,
  `experience` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `o_description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offered_jobs`
--

INSERT INTO `offered_jobs` (`id`, `company_id`, `job_title`, `job_type`, `experience`, `salary`, `o_description`) VALUES
(5, 4, 'WEB designer', 'full time', 3, 2500, 'Talk Spanish'),
(6, 1, 'Customer Service', 'Part Time', 10, 1500, '  test\r\n  ');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `indivdual_id` int(11) NOT NULL,
  `skill` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indivdual_id` (`indivdual_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `indivdual_id`, `skill`) VALUES
(1, 1, 'Photoshop');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `individuals_accomp`
--
ALTER TABLE `individuals_accomp`
  ADD CONSTRAINT `individuals_accomp_ibfk_1` FOREIGN KEY (`individual_id`) REFERENCES `individuals` (`id`);

--
-- Constraints for table `individuals_education`
--
ALTER TABLE `individuals_education`
  ADD CONSTRAINT `individuals_education_ibfk_1` FOREIGN KEY (`individual_id`) REFERENCES `individuals` (`id`);

--
-- Constraints for table `individuals_experience`
--
ALTER TABLE `individuals_experience`
  ADD CONSTRAINT `individuals_experience_ibfk_1` FOREIGN KEY (`individual_id`) REFERENCES `individuals` (`id`);

--
-- Constraints for table `offered_jobs`
--
ALTER TABLE `offered_jobs`
  ADD CONSTRAINT `offered_jobs_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`indivdual_id`) REFERENCES `individuals` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
