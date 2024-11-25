-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2024 at 12:10 PM
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
-- Database: `antworks_p2pdevelopment`
--

-- --------------------------------------------------------

--
-- Table structure for table `invest_scheme_details`
--

CREATE TABLE `invest_scheme_details` (
  `id` int(11) NOT NULL,
  `Vendor_ID` int(11) NOT NULL,
  `Scheme_Name` varchar(40) NOT NULL,
  `Min_Inv_Amount` int(10) NOT NULL,
  `Max_Inv_Amount` int(20) NOT NULL,
  `Aggregate_Amount` int(10) NOT NULL,
  `Lockin` tinyint(1) NOT NULL COMMENT '1=Yes| 0=No',
  `Cooling_Period` int(10) NOT NULL,
  `Interest_Rate` decimal(5,0) NOT NULL,
  `hike_rate` decimal(10,0) NOT NULL,
  `Interest_Type` varchar(40) NOT NULL,
  `Withrawl_Anytime` tinyint(1) NOT NULL COMMENT '1=Yes| 0=No',
  `Pre_Mat_Rate` decimal(5,0) NOT NULL,
  `Lockin_Period` int(10) NOT NULL,
  `Tenure` int(10) NOT NULL,
  `Auto_Redeem` tinyint(1) NOT NULL COMMENT '1=Yes| 0=No',
  `status` int(11) NOT NULL COMMENT '1=Active, 0=In-Active',
  `updated_on` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `payout_type` enum('monthly','maturity') DEFAULT NULL,
  `scheme_descripiton` varchar(800) DEFAULT NULL,
  `lender_management_fee_percentage` int(12) DEFAULT NULL COMMENT 'added this field on 2024-september-05',
  `lender_management_fee_rupee` int(12) DEFAULT NULL COMMENT 'added this field on 2024-september-05',
  `type_of_lender_management_fee` varchar(60) DEFAULT NULL COMMENT 'added this field on 2024-september-05',
  `step_up_value` varchar(5) DEFAULT NULL,
  `diversification_factor_value` varchar(5) DEFAULT NULL,
  `minimum_loan_amount` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invest_scheme_details`
--

INSERT INTO `invest_scheme_details` (`id`, `Vendor_ID`, `Scheme_Name`, `Min_Inv_Amount`, `Max_Inv_Amount`, `Aggregate_Amount`, `Lockin`, `Cooling_Period`, `Interest_Rate`, `hike_rate`, `Interest_Type`, `Withrawl_Anytime`, `Pre_Mat_Rate`, `Lockin_Period`, `Tenure`, `Auto_Redeem`, `status`, `updated_on`, `created_date`, `payout_type`, `scheme_descripiton`, `lender_management_fee_percentage`, `lender_management_fee_rupee`, `type_of_lender_management_fee`, `step_up_value`, `diversification_factor_value`, `minimum_loan_amount`) VALUES
(26, 29, 'Mashrah', 10000, 5000000, 5000, 0, 1, '12', '12', 'Simple', 0, '0', 375, 360, 0, 0, '2024-09-17 14:08:16', '2024-09-17 14:08:16', 'maturity', 'Mashrah films private limited', NULL, NULL, 'None', '1250', '8', '5000'),
(27, 30, 'Zylo Micro', 10000, 5000000, 5000, 0, 1, '12', '12', 'Simple', 0, '0', 375, 360, 0, 1, '2024-09-17 15:20:47', '2024-09-17 15:20:47', 'maturity', 'Zylo Micro Foundation ', NULL, NULL, 'None', '1250', '8', '5000'),
(10, 21, 'Surge Max', 5000, 1000000, 1000000, 0, 3, '12', '12', 'Simple', 0, '0', 40, 30, 0, 0, '2024-09-10 17:20:14', '2024-09-06 13:56:40', 'maturity', 'description aa', 0, 5, 'InRupee', '1250', '4', '5000'),
(11, 1, 'Surge Max 180', 1000, 1000000, 1000000, 0, 3, '12', '12', 'Simple', 0, '10', 180, 0, 1, 0, '2024-09-05 10:26:08', '2024-06-03 12:23:06', NULL, NULL, 0, 1, 'InRupee', NULL, NULL, NULL),
(17, 10, 'Ram Co Invest Plan', 1000, 1000000, 1000000, 1, 3, '12', '12', 'Simple', 0, '0', 40, 40, 1, 0, '2024-09-05 10:26:08', '2024-06-05 15:18:06', NULL, NULL, 0, 1, 'InRupee', NULL, NULL, NULL),
(18, 22, 'Test17ap', 10, 50000, 50000, 0, 0, '12', '0', 'Simple', 1, '0', 0, 180, 0, 0, '2024-09-05 10:26:08', '2024-06-03 12:23:39', NULL, NULL, 0, 1, 'InRupee', NULL, NULL, NULL),
(19, 24, 'Scheme_!', 2, 500000, 1000, 1, 1, '12', '12', 'Simple', 0, '12', 3, 12, 0, 0, '2024-09-05 10:26:08', '2024-06-03 12:23:55', NULL, NULL, 0, 1, 'InRupee', NULL, NULL, NULL),
(20, 21, 'a', 11, 13224234, 4334, 0, 10, '12', '12', 'Simple', 0, '0', 40, 40, 0, 0, '2024-09-05 10:26:08', '2024-06-03 12:59:35', NULL, NULL, 0, 1, 'InRupee', NULL, NULL, NULL),
(21, 1, 'Surge 40', 1000, 1000000, 1000000, 1, 3, '12', '12', 'Simple', 0, '0', 40, 40, 0, 1, '2024-09-05 10:26:08', '2024-06-03 15:53:01', 'monthly', NULL, 0, 1, 'InRupee', NULL, NULL, NULL),
(22, 1, 'Surge 70', 1000, 1000000, 1000000, 1, 3, '13', '13', 'Simple', 0, '0', 70, 70, 0, 1, '2024-09-05 10:26:08', '2024-06-03 15:53:56', NULL, NULL, 0, 1, 'InRupee', NULL, NULL, NULL),
(23, 1, 'Surge 100', 1000, 1000000, 1000000, 1, 3, '14', '14', 'Simple', 0, '0', 100, 100, 0, 1, '2024-09-05 10:26:08', '2024-06-03 15:55:33', NULL, NULL, 0, 1, 'InRupee', NULL, NULL, NULL),
(24, 28, 'Inway 12', 5000, 5000000, 5000000, 1, 3, '12', '12', 'Simple', 0, '0', 375, 375, 0, 1, '2024-09-05 10:26:08', '2024-07-29 14:55:22', NULL, NULL, 0, 1, 'InRupee', NULL, NULL, NULL),
(25, 28, 'Inway 30', 1000, 5000000, 5000000, 1, 3, '12', '12', 'Simple', 0, '0', 40, 40, 0, 1, '2024-09-05 10:26:08', '2024-07-19 12:34:48', NULL, NULL, 0, 1, 'InRupee', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invest_scheme_details`
--
ALTER TABLE `invest_scheme_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invest_scheme_details`
--
ALTER TABLE `invest_scheme_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
