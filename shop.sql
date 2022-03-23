-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2020 at 06:29 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_id` int(11) NOT NULL,
  `user` varchar(30) COLLATE utf8_bin NOT NULL,
  `balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `user`, `balance`) VALUES
(1, 'ehab', 8000),
(2, 'ahmed', 2000),
(5, 'moahmed', 5000),
(6, 'moahmed', 5000),
(7, 'mostafa', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(6) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(16, 'Hand Made', 'Hand Made Items', 0, 1, 1, 1, 1),
(17, 'Computers', 'Computers Item', 0, 2, 0, 0, 0),
(18, 'Cell Phones', 'Cell Phones Item', 0, 3, 0, 0, 0),
(22, 'Tools', 'this good', 0, 4, 0, 0, 0),
(23, 'nokia', 'this Good  mobile', 17, 5, 0, 0, 0),
(24, 'mouse', 'this good', 17, 7, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `Comment_Date` date NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `Comment`, `status`, `Comment_Date`, `Item_ID`, `User_ID`) VALUES
(1, 'very Nice', 0, '2019-04-09', 7, 2),
(2, 'very good', 0, '2019-04-03', 6, 2),
(3, 'this is bea', 1, '2019-05-28', 12, 8),
(4, 'this is mmmmm', 1, '2019-05-29', 12, 8),
(8, 'hhhh', 1, '2019-05-29', 12, 8),
(10, 'emem', 1, '2019-05-29', 7, 8),
(13, ' this is beautiful items this is beautiful items this is beautiful items', 1, '2019-05-29', 7, 8),
(22, 'ttttttttttt', 1, '2019-05-29', 12, 8),
(23, 'ttttttttttt', 0, '2019-05-29', 12, 8);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Countery_Made` varchar(255) NOT NULL,
  `Tags` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Countery_Made`, `Tags`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`) VALUES
(5, 'Mic Speaker ', 'this good', '10', '2019-04-29', 'usa', '', '', '1', 0, 1, 18, 2),
(6, 'Iphone6s', 'this Amaing mobile', '200', '2019-04-29', 'usa', '', '', '1', 0, 1, 18, 3),
(7, 'Iphone7s', 'this Amaing mobile', '300', '2019-04-29', 'usa', '', '', '1', 0, 1, 18, 8),
(8, 'mouse', 'this good', '10', '2019-04-29', 'usa', '', '', '1', 0, 1, 17, 2),
(9, 'cover', 'this good', '5', '2019-04-29', 'usa', '', '', '1', 0, 1, 16, 8),
(10, 'keyboard', 'this keyboard is good for computer', '5', '2019-05-01', 'Europe', '', '', '0', 0, 0, 17, 8),
(11, 'microphone', 'this good for speeak', '5', '2019-05-01', 'Europe', '', '', '1', 0, 1, 17, 8),
(12, 'games', 'thissssssssssss', '100', '2019-05-13', 'usa', '', '', '1', 0, 1, 18, 8),
(13, 'gtaaa', 'this Amaing and Beautiful Game  ', '20', '2019-05-30', 'Europe', '', '', '1', 0, 1, 17, 8),
(14, 'labtop', 'this is nessaery for every student', '1000', '2019-05-30', 'usa', '', '', '1', 0, 1, 17, 8),
(15, 'Electronics1', 'this good', '100', '2019-06-03', 'usa', 'ehab,ahmed,alii', '', '1', 0, 1, 22, 8),
(16, 'Diabloo |||', 'Good Palstaion 4 Game', '100', '2019-06-03', 'usa', 'RPG,Online,Game', '', '1', 0, 1, 22, 8),
(17, 'pupg', 'good battle Ground Game', '100', '2019-06-04', 'america', 'Game', '', '1', 0, 1, 22, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To Identify User',
  `Username` varchar(255) NOT NULL COMMENT 'User Name To login',
  `Password` varchar(255) NOT NULL COMMENT 'Password To login',
  `Email` varchar(255) NOT NULL,
  `Fullname` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'Identify User Group',
  `Truststaus` int(11) NOT NULL DEFAULT 0 COMMENT 'Selllar Bank',
  `Regstatus` int(11) NOT NULL DEFAULT 0 COMMENT 'User Approval',
  `Date` date NOT NULL,
  `Avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `Fullname`, `GroupID`, `Truststaus`, `Regstatus`, `Date`, `Avatar`) VALUES
(1, 'ehab', '601f1889667efaebb33b8c12572835da3f027f78', 'Ehabbsaleh@info', 'ehab saleh', 1, 0, 1, '2019-04-01', ''),
(2, 'ahmed', '601f1889667efaebb33b8c12572835da3f027f78', 'ahmed@info.com', 'ahmed mohamed', 0, 0, 0, '2019-04-27', ''),
(3, 'mohamed', '601f1889667efaebb33b8c12572835da3f027f78', 'mohamedahmed@info', 'mohamed ahmed', 0, 0, 1, '2019-04-27', ''),
(4, 'Sayed', '601f1889667efaebb33b8c12572835da3f027f78', 'sayedahmed@info.com', 'sayed ahmed', 0, 0, 1, '2019-04-27', ''),
(5, 'alii', '601f1889667efaebb33b8c12572835da3f027f78', 'aliahmed@info.com', 'aliAhmed', 0, 0, 1, '2019-04-27', ''),
(6, 'gamal', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'gamalahmed@info.com', '', 0, 0, 0, '2019-05-05', ''),
(7, 'gala', '601f1889667efaebb33b8c12572835da3f027f78', 'gala@info.com', '', 0, 0, 1, '2019-05-05', ''),
(8, 'modd', '601f1889667efaebb33b8c12572835da3f027f78', 'moahmed@gmail.com', '', 0, 0, 1, '2019-05-05', ''),
(9, 'soass', '601f1889667efaebb33b8c12572835da3f027f78', 'Ehabbsaleh@info.com', '', 0, 0, 1, '2019-05-05', ''),
(10, 'samy', '601f1889667efaebb33b8c12572835da3f027f78', 'samyahmed@yhahoo.com', 'samy ahmed', 0, 0, 1, '2019-06-06', '556061_images.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `items_comment` (`Item_ID`),
  ADD KEY `comment_User` (`User_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Usename` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To Identify User', AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_User` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`Item_ID`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
