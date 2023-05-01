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
-- Database: `investmentmodule`
--

-- --------------------------------------------------------

--
-- Table structure for table `authorised_users`
--

CREATE TABLE `authorised_users` (
  `RID` int(20) NOT NULL,
  `Vendor_ID` int(20) NOT NULL,
  `RepName` varchar(120) NOT NULL,
  `RepDesignation` varchar(100) NOT NULL,
  `Repphone` varchar(13) NOT NULL,
  `Repemail` varchar(200) NOT NULL,
  `Password` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authorised_users`
--

INSERT INTO `authorised_users` (`RID`, `Vendor_ID`, `RepName`, `RepDesignation`, `Repphone`, `Repemail`, `Password`) VALUES
(1, 3, 'Startest', 'Tester', '1234567', 'Star@test.com', '12345'),
(2, 22, 'Revan', 'tester', '123456', 'test@testrep.com', '123456'),
(3, 22, 'rax', 'CEO', '1234565432', 'tesdf@th.com', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `scheme_details`
--

CREATE TABLE `scheme_details` (
  `SID` int(11) NOT NULL,
  `Vendor_ID` int(11) NOT NULL,
  `Scheme_Name` varchar(40) NOT NULL,
  `Min_Inv_Amount` int(10) NOT NULL,
  `Max_Inv_Amount` int(20) NOT NULL,
  `Aggregate_Amount` int(10) NOT NULL,
  `Lockin` tinyint(1) NOT NULL COMMENT '1=Yes| 0=No',
  `Cooling_Period` int(10) NOT NULL,
  `Interest_Rate` decimal(5,0) NOT NULL,
  `Interest_Type` varchar(40) NOT NULL,
  `Withrawl_Anytime` tinyint(1) NOT NULL COMMENT '1=Yes| 0=No',
  `Pre_Mat_Rate` decimal(5,0) NOT NULL,
  `Lockin_Period` int(10) NOT NULL,
  `Tenure` int(10) NOT NULL,
  `Auto_Redeem` tinyint(1) NOT NULL COMMENT '1=Yes| 0=No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scheme_details`
--

INSERT INTO `scheme_details` (`SID`, `Vendor_ID`, `Scheme_Name`, `Min_Inv_Amount`, `Max_Inv_Amount`, `Aggregate_Amount`, `Lockin`, `Cooling_Period`, `Interest_Rate`, `Interest_Type`, `Withrawl_Anytime`, `Pre_Mat_Rate`, `Lockin_Period`, `Tenure`, `Auto_Redeem`) VALUES
(3, 3, 'startestop', 200, 5000, 99999, 0, 0, '5', 'Simple', 1, '2', 0, 0, 1),
(4, 2, 'TESTSCHEME2', 100, 500000, 100000, 0, 0, '5', 'Simple', 0, '2', 0, 0, 0),
(5, 3, 'USERTEST', 1000, 100000, 1200000, 0, 0, '7', 'Simple', 0, '2', 0, 0, 0),
(6, 2, 'TEST SCHEME1', 10000, 10000000, 1234577, 1, 7, '6', 'Simple', 1, '2', 180, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users1`
--

CREATE TABLE `users1` (
  `UID` int(11) NOT NULL,
  `Lender_ID` varchar(40) NOT NULL,
  `Vendor_ID` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `DOB` varchar(30) NOT NULL,
  `PAN` varchar(10) NOT NULL,
  `VPAN` varchar(15) NOT NULL,
  `Account_No` varchar(100) NOT NULL,
  `ifsc` varchar(11) NOT NULL,
  `Reg_Date` datetime NOT NULL,
  `Investment_Date` datetime NOT NULL,
  `Total_Invest` int(15) NOT NULL COMMENT 'Total investment from all vendors',
  `Net_Worth_Cert` blob NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active | 0=Inactive '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users1`
--

INSERT INTO `users1` (`UID`, `Lender_ID`, `Vendor_ID`, `fullname`, `gender`, `email`, `password`, `phone`, `DOB`, `PAN`, `VPAN`, `Account_No`, `ifsc`, `Reg_Date`, `Investment_Date`, `Total_Invest`, `Net_Worth_Cert`, `status`) VALUES
(1, '', 1, 'hshhsssssss2sjjash', '', 'stasssrksk2sssddjkshsxsskk@gmail.com', '98edccc33e4bce171d2175022ffd9712', '1', '1999-07-01', 'CXFPY2397Y', '1', '', '', '2023-02-13 12:41:22', '0000-00-00 00:00:00', 0, '', 1),
(5, '', 1, 'star', '', 'star@test.com', 'e10adc3949ba59abbe56e057f20f883e', '12', '1999-07-01', 'CXFPY2097Y', '2', '', '', '2023-02-13 01:03:16', '0000-00-00 00:00:00', 0, '', 1),
(12, '', 1, 'star', '', 'star@test.com', 'e10adc3949ba59abbe56e057f20f883e', '2', '1990-07-01', 'CXFPY2007Y', '3', '', '', '2023-02-14 07:06:56', '0000-00-00 00:00:00', 0, '', 1),
(13, '', 1, 'star', '', 'star@test.com', 'e10adc3949ba59abbe56e057f20f883e', '1232245673', '1990-07-01', 'CXFPY2067Y', '4', '', '', '2023-02-14 07:08:49', '0000-00-00 00:00:00', 0, '', 1),
(14, '', 1, 'star', '', 'star@test.com', 'e10adc3949ba59abbe56e057f20f883e', '1232245674', '1990-07-01', 'CXFPY2907Y', '5', '', '', '2023-02-14 07:09:33', '0000-00-00 00:00:00', 0, '', 1),
(15, '', 1, 'star', '', 'star@test.com', 'e10adc3949ba59abbe56e057f20f883e', '1232245675', '1990-07-01', 'CXFPY1907Y', '6', '', '', '2023-02-14 07:13:12', '0000-00-00 00:00:00', 0, '', 1),
(16, '', 1, 'star', '', 'star@test.com', 'e10adc3949ba59abbe56e057f20f883e', '1232245676', '1990-07-01', 'CXFPY9907Y', '7', '', '', '2023-02-14 07:40:42', '0000-00-00 00:00:00', 0, '', 1),
(17, '', 3, 'starrax', '', 'star@atest.com', 'f8a8d7997e870968f92748f3cc41cf90', '12322', '1999-07-01', 'CWWPY3907Y', '8', '', '', '2023-02-14 10:45:04', '0000-00-00 00:00:00', 0, '', 1),
(24, '', 3, 'Star Rax', 'Male', 'star@test.com', '1f32aa4c9a1d2ea010adcf2348166a04', '123459', '24/01/1997', 'testPAN77', '3testPAN77', '234543232345543', 'SBIN0016669', '2023-03-02 15:20:41', '0000-00-00 00:00:00', 0, '', 1),
(57, '', 3, 'Rohit Dalal', 'Male', 'startest111@test.com', 'c0cd737b0cbee687f2dfae66c7ed360b', '798880221', '24/01/1999', 'CXFPD3663J', '3CXFPD3663J', '123457834545', 'SBIN0011845', '2023-03-03 12:42:28', '0000-00-00 00:00:00', 0, '', 1),
(64, '', 2, 'Rohit Dalal', 'Male', 'startest111@test.com', '2c0cd737b0cbee687f2dfae66c7ed360b', '27988890221', '24/01/1999', 'CXFPD3663J', '2CXFPD3663J', '123457834545', 'SBIN0011845', '2023-03-03 02:26:31', '0000-00-00 00:00:00', 0, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `VID` int(11) NOT NULL,
  `Company_Name` varchar(200) NOT NULL,
  `Address` varchar(300) NOT NULL,
  `Phone` varchar(13) NOT NULL,
  `Email` varchar(80) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`VID`, `Company_Name`, `Address`, `Phone`, `Email`, `Password`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 'Paytm', 'Testing Address', '11111111', 'test@paytm.com', '', 0, 'starapitest', 0, 0, 0, NULL, '2023-03-02 12:04:52'),
(2, 'Antpay', '', '', 'ant@test.com', 'ant124', 12456, 'ant123', 0, 0, 0, NULL, '2023-02-01 09:25:07'),
(3, 'RAXTEST', '', '', 'star@test.com', 'ddfd', 12454, 'startest', 0, 0, 0, NULL, '2023-02-01 10:38:14'),
(22, 'Startest company', 'address abc', '12345689', 'Test@testcom.com', '', 0, '570822b830dd63a3065d76ba1803b83b4c23f38a5c50e2029b77d3a06d359c71', 0, 0, 0, NULL, '2023-02-24 04:06:35'),
(23, 'Phone Pay', 'atrioonnnn', '12345778', 'test@gmail.com', '', 0, 'b95c3ee102676f632e66713c4cb03e8a1bf62fb43916050168ca8bd9fd249864', 0, 0, 0, NULL, '2023-02-28 04:43:23'),
(24, 'RAXTEST', 'RAXTESTING Corp abccc', '1234567876543', 'test@gmail.com', '', 0, 'a0bd11ec71ad6a613a8f31f14e63ce5c8c4233ae6ccc5e597f41f100931bdea7', 0, 0, 0, NULL, '2023-03-01 20:54:20'),
(25, 'Paytm', '', '', '', '', 0, '69106f7aea3d764e0a9f514e6bd0f3b481a1179842f4ed0d3ed24d96ad58db5c', 0, 0, 0, NULL, '2023-03-02 00:11:19'),
(26, 'Startestop5', 'Startestop5 Address', '12345432123', 'Startestop5@test.com', '', 0, '896ca1177eabb614fc7f51ecbdc3f792f75dfc474df74e369fe90e4eb321a50f', 0, 0, 0, NULL, '2023-03-03 00:42:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authorised_users`
--
ALTER TABLE `authorised_users`
  ADD PRIMARY KEY (`RID`);

--
-- Indexes for table `scheme_details`
--
ALTER TABLE `scheme_details`
  ADD PRIMARY KEY (`SID`);

--
-- Indexes for table `users1`
--
ALTER TABLE `users1`
  ADD PRIMARY KEY (`UID`),
  ADD UNIQUE KEY `VPAN` (`VPAN`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`VID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authorised_users`
--
ALTER TABLE `authorised_users`
  MODIFY `RID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `scheme_details`
--
ALTER TABLE `scheme_details`
  MODIFY `SID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users1`
--
ALTER TABLE `users1`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `VID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
