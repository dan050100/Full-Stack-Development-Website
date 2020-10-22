-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 28, 2020 at 11:21 PM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.3.17-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `filo`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Category` varchar(10) NOT NULL,
  `Colour` varchar(10) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Photo` varchar(500) NOT NULL,
  `Place` varchar(250) NOT NULL,
  `Description` varchar(250) NOT NULL,
  `ID` int(7) NOT NULL,
  `UserID` int(7) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Lost Items';

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Category`, `Colour`, `Date`, `Time`, `Photo`, `Place`, `Description`, `ID`, `UserID`, `Status`) VALUES
('Pet', 'Red', '2020-04-06', '04:54:00', 'MONOP1.BMP¬?blackScreen.bmp¬?newplot.png¬?', 'Car', 'Soft', 187, 6, 0),
('Phone', 'White', '2020-04-14', '23:25:00', 'graphicsSchape.jpg¬?', 'Outside Club', 'Scratched', 188, 6, 0),
('Jewellery', 'Pink', '2020-04-07', '03:44:00', 'woodenDoorTexture.bmp¬?snowRoofTexture.bmp¬?', 'At Home', 'Shiny', 189, 6, 0),
('Phone', 'Blue', '2020-04-01', '04:34:00', 'TexturesCom_WindowsBacklit0051_1_S.jpg¬?woodenPosts.bmp¬?icebergTexture.bmp¬?', 'Behind Shop', 'Cracked', 190, 6, 0),
('Phone', 'Red', '2020-04-13', '04:34:00', 'graphicsSchape.jpg¬?windowTexture.bmp¬?TexturesCom_WindowsBacklit0051_1_S.jpg¬?', 'Down A Drain', 'Waterlogged', 191, 6, 0),
('Pet', 'Grey', '2020-04-07', '03:36:00', 'scifi_platformTiles_32x32.png¬?preview_7.jpg¬?', 'In The Park', 'Small', 192, 6, 1),
('Phone', 'Gold', '2020-04-01', '23:02:00', 'windowTexture.bmp¬?TexturesCom_WindowsBacklit0051_1_S.jpg¬?', 'In Shop', 'Iphone 8', 193, 6, 0),
('Phone', 'White', '2020-04-14', '07:09:00', 'graphicsSchape.jpg¬?windowTexture.bmp¬?TexturesCom_WindowsBacklit0051_1_S.jpg¬?woodenPosts.bmp¬?', 'In Play Area', 'Nokia', 194, 6, 0),
('Phone', 'Gold', '2020-04-01', '23:43:00', 'woodenPosts.bmp¬?icebergTexture.bmp¬?BattleScene.PNG¬?', 'Home', 'Broken Button', 195, 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `RequestID` int(7) NOT NULL,
  `ItemID` int(7) NOT NULL,
  `Reason` varchar(250) NOT NULL,
  `RequesterID` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`RequestID`, `ItemID`, `Reason`, `RequesterID`) VALUES
(116, 192, 'Test this', '6');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(7) NOT NULL,
  `Username` varchar(16) NOT NULL,
  `Password` varchar(150) NOT NULL,
  `FirstName` varchar(16) NOT NULL,
  `LastName` varchar(16) NOT NULL,
  `Email` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `FirstName`, `LastName`, `Email`) VALUES
(4, 'Dan050100', '$2y$10$P0UkbnO41LNEsMERAUkZZONu6VRQ/momFrMbSHdn30o/LIirjjI96', 'Dan', 'Taylor', 'dan.taylor.5100@gmail.com'),
(6, '1', '$2y$10$NTGz.554w8C5TTFL6DC/FetlEAsGzQ/T7RTJu5RbP3qXOQxikqBvm', '2', '3', 'test@homail.com'),
(7, 'Joe27', '$2y$10$ZCeJUxFOr2vAgBjoytbQNOhgfqbRqiWVag9exYNFp/ymTErLvY7Pq', 'Joseph', 'Hawks', 'J.hawks@hotmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `LostID` (`UserID`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`RequestID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `RequestID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
