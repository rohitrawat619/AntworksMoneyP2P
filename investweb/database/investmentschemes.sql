-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2023 at 12:33 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `investmentschemes`
--

-- --------------------------------------------------------

--
-- Table structure for table `startestop`
--

CREATE TABLE `startestop` (
  `IID` int(20) NOT NULL,
  `User_ID` int(20) NOT NULL,
  `SID` int(20) NOT NULL,
  `Vendor_ID` int(20) NOT NULL,
  `Folio` varchar(15) NOT NULL,
  `Investment_ID` varchar(50) NOT NULL,
  `Reinvestment` tinyint(1) NOT NULL,
  `Investment_Amt` int(20) NOT NULL,
  `Investment_type` varchar(5) NOT NULL,
  `Investment_date` datetime NOT NULL,
  `Redeem_date` datetime NOT NULL,
  `Status` varchar(15) NOT NULL,
  `PAN` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `startestop`
--

INSERT INTO `startestop` (`IID`, `User_ID`, `SID`, `Vendor_ID`, `Folio`, `Investment_ID`, `Reinvestment`, `Investment_Amt`, `Investment_type`, `Investment_date`, `Redeem_date`, `Status`, `PAN`) VALUES
(1, 24, 3, 3, '68451311545', '1-3-3-230223', 0, 2000, 'Auto', '2023-02-23 00:00:00', '0000-00-00 00:00:00', '3', ''),
(2, 24, 3, 3, '10403603939', '2-3-3-230223', 0, 1000, 'Auto', '2023-02-23 00:00:00', '0000-00-00 00:00:00', '2', ''),
(3, 24, 3, 3, '68692945754', '3-3-3-270223', 0, 12000, 'Auto', '2023-02-28 00:00:00', '0000-00-00 00:00:00', '2', ''),
(4, 24, 3, 3, '32484097896', '4-3-3-270223', 0, 2500, 'Auto', '2027-02-23 00:00:00', '0000-00-00 00:00:00', '2', ''),
(5, 24, 3, 3, '70854085340', '5-3-3-270223', 0, 1000, 'Auto', '2027-02-23 00:00:00', '0000-00-00 00:00:00', '2', ''),
(6, 24, 3, 3, '70436773014', '6-3-3-010323', 0, 100000, 'Auto', '2001-03-23 00:00:00', '0000-00-00 00:00:00', '2', ''),
(7, 24, 3, 3, '23289878758', '7-3-3-010323', 0, 1200, 'Auto', '2001-03-23 00:00:00', '0000-00-00 00:00:00', '1', ''),
(8, 24, 3, 3, '46604898466', '8-3-3-010323', 0, 10000, 'Auto', '2001-03-23 00:00:00', '0000-00-00 00:00:00', '1', ''),
(9, 24, 3, 3, '55126612235', '9-3-3-010323', 0, 1000, 'Auto', '2001-03-23 00:00:00', '0000-00-00 00:00:00', '1', ''),
(10, 24, 3, 3, '97327532007', '10-3-3-010323', 0, 12000, 'Auto', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', ''),
(11, 24, 3, 3, '56701289205', '11-3-3-010323', 0, 1000, 'Auto', '2001-03-23 00:00:00', '0000-00-00 00:00:00', '1', ''),
(12, 24, 3, 3, '31327260456', '12-3-3-010323', 0, 199, 'Auto', '2023-03-01 03:34:58', '0000-00-00 00:00:00', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `testscheme2`
--

CREATE TABLE `testscheme2` (
  `IID` int(20) NOT NULL,
  `User_ID` int(20) NOT NULL,
  `SID` int(20) NOT NULL,
  `Vendor_ID` int(20) NOT NULL,
  `Folio` varchar(15) NOT NULL,
  `Investment_ID` varchar(50) NOT NULL,
  `Reinvestment` tinyint(1) NOT NULL,
  `Investment_Amt` int(20) NOT NULL,
  `Investment_type` varchar(5) NOT NULL,
  `Investment_date` datetime NOT NULL,
  `Redeem_date` datetime NOT NULL,
  `Status` varchar(15) NOT NULL,
  `PAN` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testscheme2`
--

INSERT INTO `testscheme2` (`IID`, `User_ID`, `SID`, `Vendor_ID`, `Folio`, `Investment_ID`, `Reinvestment`, `Investment_Amt`, `Investment_type`, `Investment_date`, `Redeem_date`, `Status`, `PAN`) VALUES
(1, 123, 32123, 12323, '21323', '12323', 1, 23213, '21312', '2023-02-24 09:07:09', '2023-02-24 09:07:09', '1', '111');

-- --------------------------------------------------------

--
-- Table structure for table `usertest`
--

CREATE TABLE `usertest` (
  `IID` int(20) NOT NULL,
  `User_ID` int(20) NOT NULL,
  `SID` int(20) NOT NULL,
  `Vendor_ID` int(20) NOT NULL,
  `Folio` varchar(15) NOT NULL,
  `Investment_ID` varchar(50) NOT NULL,
  `Reinvestment` tinyint(1) NOT NULL,
  `Investment_Amt` int(20) NOT NULL,
  `Investment_type` varchar(5) NOT NULL,
  `Investment_date` datetime NOT NULL,
  `Redeem_date` datetime NOT NULL,
  `Status` varchar(15) NOT NULL,
  `PAN` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertest`
--

INSERT INTO `usertest` (`IID`, `User_ID`, `SID`, `Vendor_ID`, `Folio`, `Investment_ID`, `Reinvestment`, `Investment_Amt`, `Investment_type`, `Investment_date`, `Redeem_date`, `Status`, `PAN`) VALUES
(1, 24, 5, 3, '26595620566', '1-3-5-240223', 0, 1000, 'Auto', '2022-02-23 00:00:00', '0000-00-00 00:00:00', '2', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `startestop`
--
ALTER TABLE `startestop`
  ADD PRIMARY KEY (`IID`);

--
-- Indexes for table `testscheme2`
--
ALTER TABLE `testscheme2`
  ADD PRIMARY KEY (`IID`);

--
-- Indexes for table `usertest`
--
ALTER TABLE `usertest`
  ADD PRIMARY KEY (`IID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `startestop`
--
ALTER TABLE `startestop`
  MODIFY `IID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `testscheme2`
--
ALTER TABLE `testscheme2`
  MODIFY `IID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usertest`
--
ALTER TABLE `usertest`
  MODIFY `IID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
