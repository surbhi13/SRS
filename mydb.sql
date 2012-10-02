SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Table structure for table `quizOptions`

CREATE TABLE IF NOT EXISTS `quizOptions` (
  `quizID` int(6) NOT NULL,
  `questionNo` int(4) NOT NULL,
  `optionNo` int(8) NOT NULL,
  `optionText` varchar(100) NOT NULL,
  `correctAns` varchar(100) NOT NULL,
  `id` int(8) NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  KEY `quizID` (`quizID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `quizQuestions`

CREATE TABLE IF NOT EXISTS `quizQuestions` (
  `quizID` int(6) NOT NULL,
  `id` int(8) NOT NULL auto_increment,
  `questionNo` int(8) NOT NULL,
  `questionText` varchar(200) NOT NULL,
  `minutes` int(6) NOT NULL,
  `seconds` int(6) NOT NULL,
  `startTime` timestamp NOT NULL default '0000-00-00 00:00:00',
  `endTime` timestamp NOT NULL default '0000-00-00 00:00:00',
   PRIMARY KEY  (`id`),
  KEY `quizID` (`quizID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
-- --------------------------------------------------------
--
-- Table structure for table `users`
CREATE TABLE IF NOT EXISTS `users` (
  `accessLevel` int(6) NOT NULL,
  `id` int(8) NOT NULL auto_increment,
  `userID` varchar(20) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `password` varchar(8) NOT NULL,
  `loggedIn` int(20) NOT NULL,
  `emailID` varchar(100) NOT NULL,
  `loginTime` timestamp NOT NULL default '0000-00-00 00:00:00',
  `logoutTime` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
-- --------------------------------------------------------
--
-- Table structure for table `courses`
CREATE TABLE IF NOT EXISTS `courses` (
  `courseTitle` varchar(20) NOT NULL,
  `courseDescription` varchar(200) NOT NULL,
  `courseID` int(6) NOT NULL,
  `id` int(8) NOT NULL auto_increment,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- --------------------------------------------------------
--
-- Table structure for table `quizRecordkeeper`
CREATE TABLE IF NOT EXISTS `quizRecordkeeper` (
  `quizID` int(6) NOT NULL,
  `userID` varchar(20) NOT NULL,
  `answerTime` timestamp NOT NULL default '0000-00-00 00:00:00',
  `optionNo` int(8) NOT NULL,
  `isCorrect` int(8) NOT NULL,
  `isAnswered` int(8) NOT NULL,
  `questionNo` int(8) NOT NULL,
  `id` int(8) NOT NULL auto_increment,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
-- --------------------------------------------------------
--
-- Table structure for table `courseAssignments`
CREATE TABLE IF NOT EXISTS `courseAssignments` (
	`courseID` int(6) NOT NULL,
	`id` int(8) NOT NULL auto_increment,
	`semester` varchar(10) NOT NULL,
	`year` int(4) NOT NULL,
	`section` varchar(6) NOT NULL,
	`teacherID` varchar(20) NOT NULL, 
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
-- --------------------------------------------------------
--
-- Table structure for table `quizAssignments`
CREATE TABLE IF NOT EXISTS `quizAssignments` (
  `courseID` int(6) NOT NULL,
  `quizID` int(6) NOT NULL,
  `id` int(8) NOT NULL auto_increment,
  `semester` varchar(10) NOT NULL,
  `year` int(4) NOT NULL,
  `totalQuestions` int(8) NOT NULL,
  `description` varchar(200) NOT NULL,
  `title` varchar(20) NOT NULL,
  `section` varchar(6) NOT NULL,
  `teacherID` varchar(20) NOT NULL, 

   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- --------------------------------------------------------
--
-- Table structure for table `questionTemp`
CREATE TABLE IF NOT EXISTS `questionTemp` (
  `quizID` int(6) NOT NULL,
  `id` int(8) NOT NULL auto_increment,
  `currentQNo` int(8) NOT NULL,

   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- ---------------------------------------------------------
--
-- Table structure for table `logIns`
CREATE TABLE IF NOT EXISTS `logIns` (
 `loggedIn` int(6) NOT NULL,
 `loginTime` timestamp NOT NULL default '0000-00-00 00:00:00',
 `quizID` int(6) NOT NULL,
 `id` int(8) NOT NULL auto_increment,
 `userID` varchar(20) NOT NULL,

  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `users` (`accessLevel`, `userID`, `password`) VALUES
(4, 'admin', '00001111');

INSERT INTO `users` (`accessLevel`, `userID`, `password`) VALUES
(1, 'ushma', '12345678');

INSERT INTO `users` (`accessLevel`, `userID`, `password`) VALUES
(1, 'kouji', '78956745');

INSERT INTO `users` (`accessLevel`, `userID`, `password`) VALUES
(1, 'jimmy', '34556745');
