-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2023 at 10:16 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invest_authorised_users`
--

INSERT INTO `invest_authorised_users` (`RID`, `Vendor_ID`, `RepName`, `RepDesignation`, `Repphone`, `Repemail`, `Password`) VALUES
(1, 3, 'Startest', 'Tester', '1234567', 'Star@test.com', '12345'),
(2, 22, 'testingop', 'Star OP', '222', 'Startestop@g.com', '123456'),
(3, 22, 'rax', 'CEO Test', '3333333', 'tesdf@th.com', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `invest_bank_respsone`
--

CREATE TABLE `invest_bank_respsone` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `account_no` varchar(50) NOT NULL,
  `ifsc_code` varchar(15) NOT NULL,
  `response` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invest_bank_respsone`
--

INSERT INTO `invest_bank_respsone` (`id`, `name`, `account_no`, `ifsc_code`, `response`) VALUES
(1, 'ankit kumar', '014199500002361', 'YESB0000141', '{\"status\":1,\"bank_response\":{\"id\":\"fav_LarKhAbmd9NIaf\",\"entity\":\"fund_account.validation\",\"fund_account\":{\"id\":\"fa_LarKh7b9Q5DVnf\",\"entity\":\"fund_account\",\"account_type\":\"bank_account\",\"bank_account\":{\"ifsc\":\"YESB0000141\",\"bank_name\":\"Yes Bank\",\"name\":\"ankit kumar\",\"notes\":[],\"account_number\":\"014199500002361\"},\"batch_id\":null,\"active\":true,\"created_at\":1680861282,\"details\":{\"ifsc\":\"YESB0000141\",\"bank_name\":\"Yes Bank\",\"name\":\"ankit kumar\",\"notes\":[],\"account_number\":\"014199500002361\"}},\"status\":\"completed\",\"amount\":100,\"currency\":\"INR\",\"notes\":{\"random_key_1\":\"\",\"random_key_2\":\"\"},\"results\":{\"account_status\":\"active\",\"registered_name\":\"ANKIT  KUMAR\"},\"created_at\":1680861282,\"utr\":null},\"msg\":\"Bank verified successfully\"}'),
(2, 'Shantanu Tewary', '025301575551', 'ICIC0000253', '{\"status\":1,\"bank_response\":{\"id\":\"fav_LcUEcA8bxSP2vJ\",\"entity\":\"fund_account.validation\",\"fund_account\":{\"id\":\"fa_LcUEc7hoS1mLoB\",\"entity\":\"fund_account\",\"account_type\":\"bank_account\",\"bank_account\":{\"ifsc\":\"ICIC0000253\",\"bank_name\":\"ICICI Bank\",\"name\":\"Shantanu Tewary\",\"notes\":[],\"account_number\":\"025301575551\"},\"batch_id\":null,\"active\":true,\"created_at\":1681216620,\"details\":{\"ifsc\":\"ICIC0000253\",\"bank_name\":\"ICICI Bank\",\"name\":\"Shantanu Tewary\",\"notes\":[],\"account_number\":\"025301575551\"}},\"status\":\"completed\",\"amount\":100,\"currency\":\"INR\",\"notes\":{\"random_key_1\":\"\",\"random_key_2\":\"\"},\"results\":{\"account_status\":\"active\",\"registered_name\":\"SHANTANU TEWARY\"},\"created_at\":1681216620,\"utr\":null},\"msg\":\"Bank verified successfully\"}');

-- --------------------------------------------------------

--
-- Table structure for table `invest_scheme1`
--

CREATE TABLE `invest_scheme1` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invest_scheme1`
--

INSERT INTO `invest_scheme1` (`IID`, `User_ID`, `SID`, `Vendor_ID`, `Folio`, `Investment_ID`, `Reinvestment`, `Investment_Amt`, `Investment_type`, `Investment_date`, `Redeem_date`, `Status`, `PAN`) VALUES
(1, 1, 0, 3, '76669654127', '1-3-0-070423', 0, 1, '', '2023-04-07 04:42:45', '0000-00-00 00:00:00', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `invest_scheme2`
--

CREATE TABLE `invest_scheme2` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invest_scheme_details`
--

INSERT INTO `invest_scheme_details` (`SID`, `Vendor_ID`, `Scheme_Name`, `Min_Inv_Amount`, `Max_Inv_Amount`, `Aggregate_Amount`, `Lockin`, `Cooling_Period`, `Interest_Rate`, `Interest_Type`, `Withrawl_Anytime`, `Pre_Mat_Rate`, `Lockin_Period`, `Tenure`, `Auto_Redeem`) VALUES
(0, 3, 'SCHEME1', 100000, 1000000, 12300, 0, 10, '10', 'simple', 1, '3', 60, 180, 1),
(2, 3, 'SCHEME2', 100000, 1000000, 12300, 0, 10, '10', 'simple', 1, '3', 60, 180, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `invest_users1`
--

CREATE TABLE `invest_users1` (
  `UID` int(11) NOT NULL,
  `Lender_ID` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `Vendor_ID` int(11) NOT NULL,
  `fullname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DOB` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `PAN` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `VPAN` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `account_no` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ifsc_code` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
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
(1, '', 3, 'ankit kumar', 'Male', 'ankitkumar9627@gmail.com', '', '39389881805', '15/08/2001', 'JNPPK0744C', '3JNPPK0744C', '014199500002361', 'YESB0000141', '2023-04-07 04:38:32', '0000-00-00 00:00:00', 0, '', 1, 1, 1),
(2, '', 3, 'Ankit Kumar', 'Male', 'ankitsingh4004@gmail.com', '', '38447929447', '15/02/1994', 'EQUPK9179N', '3EQUPK9179N', '', '', '2023-04-11 04:50:54', '0000-00-00 00:00:00', 0, '', 1, 1, 0),
(3, '', 3, 'Shantanu Tewary', 'Male', 'shantanu.tewary@gmail.com', '', '39717544770', '18/02/1982', 'AFJPT8374A', '3AFJPT8374A', '025301575551', 'ICIC0000253', '2023-04-11 06:05:57', '0000-00-00 00:00:00', 0, '', 1, 1, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invest_authorised_users`
--
ALTER TABLE `invest_authorised_users`
  ADD PRIMARY KEY (`RID`);

--
-- Indexes for table `invest_bank_respsone`
--
ALTER TABLE `invest_bank_respsone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invest_scheme1`
--
ALTER TABLE `invest_scheme1`
  ADD PRIMARY KEY (`IID`);

--
-- Indexes for table `invest_scheme2`
--
ALTER TABLE `invest_scheme2`
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
-- AUTO_INCREMENT for table `invest_bank_respsone`
--
ALTER TABLE `invest_bank_respsone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invest_scheme1`
--
ALTER TABLE `invest_scheme1`
  MODIFY `IID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invest_scheme2`
--
ALTER TABLE `invest_scheme2`
  MODIFY `IID` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invest_scheme_details`
--
ALTER TABLE `invest_scheme_details`
  MODIFY `SID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invest_vendors`
--
ALTER TABLE `invest_vendors`
  MODIFY `VID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
