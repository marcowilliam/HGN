-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: sql3.freemysqlhosting.net
-- Generation Time: Jul 06, 2015 at 06:31 AM
-- Server version: 5.5.43-0ubuntu0.12.04.1
-- PHP Version: 5.3.28

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sql382663`
--

-- --------------------------------------------------------

--
-- Table structure for table `blue_square`
--

CREATE TABLE IF NOT EXISTS `blue_square` (
  `bsquare_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bsquare_date` date NOT NULL,
  PRIMARY KEY (`bsquare_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_description` text NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_description`) VALUES
(1, 'Education'),
(2, 'Everything Else'),
(3, 'Funding & Partnership Building '),
(4, 'Infrastructure & Planning'),
(5, 'Interviews & Hospitality '),
(6, 'Marketing & Promotion ');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL,
  `sub_task_id` int(11) NOT NULL,
  `comment_description` text NOT NULL,
  `sender_id` int(11) NOT NULL,
  `reference_comment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE IF NOT EXISTS `program` (
  `prog_id` int(11) NOT NULL,
  `prog_interest` decimal(10,0) DEFAULT '0',
  `prog_title` text NOT NULL,
  `prog_description` text NOT NULL,
  `prog_postedDate` date NOT NULL,
  PRIMARY KEY (`prog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sub_task`
--

CREATE TABLE IF NOT EXISTS `sub_task` (
  `sub_task_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `sub_task_name` text NOT NULL,
  `sub_task_description` text NOT NULL,
  `sub_task_type_id` int(11) NOT NULL,
  `sub_task_time` decimal(5,2) NOT NULL,
  `sub_task_date` date NOT NULL,
  PRIMARY KEY (`sub_task_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Dumping data for table `sub_task`
--

INSERT INTO `sub_task` (`sub_task_id`, `task_id`, `sub_task_name`, `sub_task_description`, `sub_task_type_id`, `sub_task_time`, `sub_task_date`) VALUES
(1, 1, 'Village 6', 'Village 6 description ', 1, '2.50', '2015-07-03'),
(29, 1, 'Village 7', 'Village 7 description', 1, '1.00', '2015-07-03');

-- --------------------------------------------------------

--
-- Table structure for table `sub_task_type`
--

CREATE TABLE IF NOT EXISTS `sub_task_type` (
  `sub_task_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_task_type_description` text NOT NULL,
  PRIMARY KEY (`sub_task_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sub_task_type`
--

INSERT INTO `sub_task_type` (`sub_task_type_id`, `sub_task_type_description`) VALUES
(1, 'Tangible'),
(2, 'Intangible');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_status_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_name` text NOT NULL,
  `task_description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `task_beginning_date` date NOT NULL,
  `task_end_date` int(11) NOT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_status_id`, `user_id`, `task_name`, `task_description`, `category_id`, `task_beginning_date`, `task_end_date`) VALUES
(1, 0, 1, 'Welcome ', 'Welcome To One Community', 1, '2015-07-03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `task_status`
--

CREATE TABLE IF NOT EXISTS `task_status` (
  `task_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_status_description` text NOT NULL,
  PRIMARY KEY (`task_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT,
  `team_description` text NOT NULL,
  PRIMARY KEY (`team_id`),
  UNIQUE KEY `team_id` (`team_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` text NOT NULL,
  `user_password` text NOT NULL,
  `user_first_name` text NOT NULL,
  `user_last_name` text NOT NULL,
  `user_DOB` date NOT NULL,
  `user_week_hrs` int(11) NOT NULL,
  `user_extra_hrs` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `user_tel` text,
  `user_mail` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_login`, `user_password`, `user_first_name`, `user_last_name`, `user_DOB`, `user_week_hrs`, `user_extra_hrs`, `user_type_id`, `user_tel`, `user_mail`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', '2015-07-09', 40, 0, 1, '0000000002', 'admin@administrador.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_team`
--

CREATE TABLE IF NOT EXISTS `user_team` (
  `user_team_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  PRIMARY KEY (`user_team_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `user_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type_description` text NOT NULL,
  PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `user_type_description`) VALUES
(1, 'Administrator'),
(2, 'Manager'),
(3, 'Team Member');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
