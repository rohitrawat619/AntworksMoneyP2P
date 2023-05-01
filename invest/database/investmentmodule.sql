-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2023 at 03:33 PM
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
-- Table structure for table `invest_authorised_users`
--

CREATE TABLE `invest_authorised_users` (
  `RID` int(20) NOT NULL,
  `Vendor_ID` int(20) NOT NULL,
  `RepName` varchar(120) NOT NULL,
  `RepDesignation` varchar(100) NOT NULL,
  `Repphone` varchar(13) NOT NULL,
  `Repemail` varchar(200) NOT NULL,
  `Password` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invest_authorised_users`
--

INSERT INTO `invest_authorised_users` (`RID`, `Vendor_ID`, `RepName`, `RepDesignation`, `Repphone`, `Repemail`, `Password`) VALUES
(1, 3, 'Startest', 'Tester', '1234567', 'Star@test.com', '12345'),
(2, 22, 'testingop', 'Star OP', '222', 'Startestop@g.com', '123456'),
(3, 22, 'rax', 'CEO Test', '3333333', 'tesdf@th.com', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `invest_changed`
--

CREATE TABLE `invest_changed` (
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
-- Dumping data for table `invest_changed`
--

INSERT INTO `invest_changed` (`IID`, `User_ID`, `SID`, `Vendor_ID`, `Folio`, `Investment_ID`, `Reinvestment`, `Investment_Amt`, `Investment_type`, `Investment_date`, `Redeem_date`, `Status`, `PAN`) VALUES
(1, 5, 4, 3, '84280044334', '1-3-4-170323', 0, 10000, 'auto', '2023-03-17 04:54:02', '0000-00-00 00:00:00', '1', ''),
(2, 5, 4, 3, '59027283680', '2-3-4-170323', 0, 10000, 'auto', '2023-03-17 04:54:06', '0000-00-00 00:00:00', '1', ''),
(3, 24, 4, 3, '14159759845', '3-3-4-170323', 1, 6000, 'Auto', '2023-03-17 04:54:57', '0000-00-00 00:00:00', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `invest_scheme_details`
--

CREATE TABLE `invest_scheme_details` (
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
-- Dumping data for table `invest_scheme_details`
--

INSERT INTO `invest_scheme_details` (`SID`, `Vendor_ID`, `Scheme_Name`, `Min_Inv_Amount`, `Max_Inv_Amount`, `Aggregate_Amount`, `Lockin`, `Cooling_Period`, `Interest_Rate`, `Interest_Type`, `Withrawl_Anytime`, `Pre_Mat_Rate`, `Lockin_Period`, `Tenure`, `Auto_Redeem`) VALUES
(4, 3, 'changed', 100, 10000, 0, 0, 2, '4', 'Simple', 0, '2', 0, 0, 0),
(5, 1, 'TRUETESTING', 10, 10000, 25000, 0, 2, '4', 'Simple', 0, '2', 0, 0, 0),
(8, 3, 'TESTTST', 1000, 111111, 160000, 0, 0, '2', 'Simple', 0, '1', 0, 0, 0),
(10, 3, 'TEST SPACE ', 1000, 10000, 1200000, 0, 2, '4', 'Simple', 0, '2', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invest_testtst`
--

CREATE TABLE `invest_testtst` (
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

-- --------------------------------------------------------

--
-- Table structure for table `invest_truetesting`
--

CREATE TABLE `invest_truetesting` (
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

-- --------------------------------------------------------

--
-- Table structure for table `invest_users1`
--

CREATE TABLE `invest_users1` (
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
  `account_no` varchar(100) NOT NULL,
  `ifsc_code` varchar(11) NOT NULL,
  `Reg_Date` datetime NOT NULL,
  `Investment_Date` datetime NOT NULL,
  `Total_Invest` int(15) NOT NULL COMMENT 'Total investment from all vendors',
  `Net_Worth_Cert` blob NOT NULL,
  `status` int(1) NOT NULL COMMENT '1 = Active 0= Inactive',
  `basickyc` tinyint(1) NOT NULL COMMENT '1 = Done 0 = Not Done',
  `fullkyc` tinyint(1) NOT NULL COMMENT '1 = Done 0 = Not Done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invest_users1`
--

INSERT INTO `invest_users1` (`UID`, `Lender_ID`, `Vendor_ID`, `fullname`, `gender`, `email`, `password`, `phone`, `DOB`, `PAN`, `VPAN`, `account_no`, `ifsc_code`, `Reg_Date`, `Investment_Date`, `Total_Invest`, `Net_Worth_Cert`, `status`, `basickyc`, `fullkyc`) VALUES
(1, '', 1, 'hshhsssssss2sjjash', '', 'stasssrksk2sssddjkshsxsskk@gmail.com', '98edccc33e4bce171d2175022ffd9712', '1', '1999-07-01', 'CXFPY2397Y', '1', '', '', '2023-02-13 12:41:22', '0000-00-00 00:00:00', 0, '', 1, 0, 0),
(5, '', 1, 'star', '', 'star@test.com', 'e10adc3949ba59abbe56e057f20f883e', '12', '1999-07-01', 'CXFPY2097Y', '2', '', '', '2023-02-13 01:03:16', '0000-00-00 00:00:00', 0, '', 1, 0, 0),
(12, '', 1, 'star', '', 'star@test.com', 'e10adc3949ba59abbe56e057f20f883e', '2', '1990-07-01', 'CXFPY2007Y', '3', '', '', '2023-02-14 07:06:56', '0000-00-00 00:00:00', 0, '', 1, 0, 0),
(13, '', 1, 'star', '', 'star@test.com', 'e10adc3949ba59abbe56e057f20f883e', '1232245673', '1990-07-01', 'CXFPY2067Y', '4', '', '', '2023-02-14 07:08:49', '0000-00-00 00:00:00', 0, '', 1, 0, 0),
(14, '', 1, 'star', '', 'star@test.com', 'e10adc3949ba59abbe56e057f20f883e', '1232245674', '1990-07-01', 'CXFPY2907Y', '5', '', '', '2023-02-14 07:09:33', '0000-00-00 00:00:00', 0, '', 1, 0, 0),
(15, '', 1, 'star', '', 'star@test.com', 'e10adc3949ba59abbe56e057f20f883e', '1232245675', '1990-07-01', 'CXFPY1907Y', '6', '', '', '2023-02-14 07:13:12', '0000-00-00 00:00:00', 0, '', 1, 0, 0),
(16, '', 1, 'star', '', 'star@test.com', 'e10adc3949ba59abbe56e057f20f883e', '1232245676', '1990-07-01', 'CXFPY9907Y', '7', '', '', '2023-02-14 07:40:42', '0000-00-00 00:00:00', 0, '', 1, 0, 0),
(17, '', 3, 'starrax', '', 'star@atest.com', 'f8a8d7997e870968f92748f3cc41cf90', '12322', '1999-07-01', 'CWWPY3907Y', '8', '', '', '2023-02-14 10:45:04', '0000-00-00 00:00:00', 0, '', 1, 0, 0),
(24, '', 3, 'Star Rax', 'Male', 'star@test.com', '1f32aa4c9a1d2ea010adcf2348166a04', '123459', '24/01/1997', 'testPAN77', '3testPAN77', '234543232345543', 'SBIN0016669', '2023-03-02 15:20:41', '0000-00-00 00:00:00', 0, '', 1, 0, 0),
(73, '', 3, 'Rohit Dalal', 'Male', 'startest11@test.com', '', '31234567890', '24/01/1999', 'CXFPD3663J', '3CXFPD3663J', '', '', '2023-03-21 02:49:56', '0000-00-00 00:00:00', 0, '', 1, 1, 0),
(75, '', 2, 'Rohit Dalal', 'Male', 'startest111@test.com', '', '27988890221', '24/01/1999', 'CXFPD3663J', '2CXFPD3663J', '', '', '2023-03-21 03:10:46', '0000-00-00 00:00:00', 0, '', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invest_vendors`
--

CREATE TABLE `invest_vendors` (
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
-- Dumping data for table `invest_vendors`
--

INSERT INTO `invest_vendors` (`VID`, `Company_Name`, `Address`, `Phone`, `Email`, `Password`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 'Startest22', 'change latest', '12343', 'test1@startest.com', '', 0, 'starapitest', 0, 0, 0, NULL, '2023-03-17 08:28:11'),
(2, 'Antpay', 'test', '', 'ant@test.com', 'ant124', 12456, 'ant123', 0, 0, 0, NULL, '2023-03-14 06:02:49'),
(3, 'RAXTEST22', 'testing addressss', '12345', 'star@test.com', 'ddfd', 12454, 'startest', 0, 0, 0, NULL, '2023-03-14 08:58:57'),
(22, 'Startest company', 'address abc', '12345689', 'Test@testcom.com', '', 0, '570822b830dd63a3065d76ba1803b83b4c23f38a5c50e2029b77d3a06d359c71', 0, 0, 0, NULL, '2023-02-24 04:06:35'),
(23, 'Phone Pay', 'atrioo', '12345778', 'test@gmail.com', '', 0, 'b95c3ee102676f632e66713c4cb03e8a1bf62fb43916050168ca8bd9fd249864', 0, 0, 0, NULL, '2023-03-14 06:04:36'),
(24, 'RAXTEST', 'RAXTESTING Corp abccc', '1234567876543', 'test@gmail.com', '', 0, 'a0bd11ec71ad6a613a8f31f14e63ce5c8c4233ae6ccc5e597f41f100931bdea7', 0, 0, 0, NULL, '2023-03-01 20:54:20'),
(26, 'Startestop5', 'Startestop5 Address', '12345432123', 'Startestop5@test.com', '', 0, '896ca1177eabb614fc7f51ecbdc3f792f75dfc474df74e369fe90e4eb321a50f', 0, 0, 0, NULL, '2023-03-03 00:42:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invest_authorised_users`
--
ALTER TABLE `invest_authorised_users`
  ADD PRIMARY KEY (`RID`);

--
-- Indexes for table `invest_changed`
--
ALTER TABLE `invest_changed`
  ADD PRIMARY KEY (`IID`);

--
-- Indexes for table `invest_scheme_details`
--
ALTER TABLE `invest_scheme_details`
  ADD PRIMARY KEY (`SID`);

--
-- Indexes for table `invest_testtst`
--
ALTER TABLE `invest_testtst`
  ADD PRIMARY KEY (`IID`);

--
-- Indexes for table `invest_truetesting`
--
ALTER TABLE `invest_truetesting`
  ADD PRIMARY KEY (`IID`);

--
-- Indexes for table `invest_users1`
--
ALTER TABLE `invest_users1`
  ADD PRIMARY KEY (`UID`),
  ADD UNIQUE KEY `VPAN` (`VPAN`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `invest_vendors`
--
ALTER TABLE `invest_vendors`
  ADD PRIMARY KEY (`VID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invest_authorised_users`
--
ALTER TABLE `invest_authorised_users`
  MODIFY `RID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invest_changed`
--
ALTER TABLE `invest_changed`
  MODIFY `IID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invest_scheme_details`
--
ALTER TABLE `invest_scheme_details`
  MODIFY `SID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `invest_testtst`
--
ALTER TABLE `invest_testtst`
  MODIFY `IID` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invest_truetesting`
--
ALTER TABLE `invest_truetesting`
  MODIFY `IID` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invest_users1`
--
ALTER TABLE `invest_users1`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `invest_vendors`
--
ALTER TABLE `invest_vendors`
  MODIFY `VID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
