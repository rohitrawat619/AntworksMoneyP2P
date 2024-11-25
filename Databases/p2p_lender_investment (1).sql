-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2024 at 03:49 PM
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
-- Table structure for table `p2p_lender_investment`
--

CREATE TABLE `p2p_lender_investment` (
  `reinvestment_id` int(11) NOT NULL,
  `investment_No` varchar(50) DEFAULT NULL,
  `lender_id` varchar(20) NOT NULL,
  `ant_txn_id` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `scheme_id` int(11) NOT NULL,
  `client_code` varchar(20) NOT NULL,
  `amount` float NOT NULL,
  `debit_account_no` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `sr_information` varchar(30) NOT NULL,
  `sender_name` varchar(50) NOT NULL,
  `basic_rate` decimal(10,0) DEFAULT NULL,
  `hike_rate` decimal(10,0) DEFAULT NULL,
  `pre_mat_rate` decimal(10,0) DEFAULT NULL,
  `lockin_period` varchar(5) DEFAULT NULL COMMENT 'get from "invest_scheme_details"',
  `tenure` varchar(5) DEFAULT NULL COMMENT 'get from "invest_scheme_details"',
  `source` varchar(50) DEFAULT NULL,
  `product` varchar(100) DEFAULT NULL,
  `total_interest` float NOT NULL,
  `total_current_value` float NOT NULL,
  `total_no_of_days` int(11) NOT NULL,
  `redemption_status` int(11) NOT NULL COMMENT '4->"Redeemed";  2->"Under Process";  5->"Generate Bank File Pending";  1->"Approval Pending"; ',
  `add_by` enum('AntPay','Backend') NOT NULL COMMENT 'AntPay'', ''Backend''',
  `redemption_date` datetime NOT NULL,
  `updated_on` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_by` varchar(60) NOT NULL,
  `approved_by_data_entry_time` datetime NOT NULL,
  `generated_bank_file_by` varchar(60) NOT NULL,
  `generated_bank_file_by_data_entry_time` datetime NOT NULL,
  `processed_by` varchar(60) NOT NULL,
  `processed_by_data_entry_time` datetime NOT NULL,
  `processed_by_remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `p2p_lender_investment`
--

INSERT INTO `p2p_lender_investment` (`reinvestment_id`, `investment_No`, `lender_id`, `ant_txn_id`, `mobile`, `scheme_id`, `client_code`, `amount`, `debit_account_no`, `location`, `sr_information`, `sender_name`, `basic_rate`, `hike_rate`, `pre_mat_rate`, `lockin_period`, `tenure`, `source`, `product`, `total_interest`, `total_current_value`, `total_no_of_days`, `redemption_status`, `add_by`, `redemption_date`, `updated_on`, `created_date`, `approved_by`, `approved_by_data_entry_time`, `generated_bank_file_by`, `generated_bank_file_by_data_entry_time`, `processed_by`, `processed_by_data_entry_time`, `processed_by_remarks`) VALUES
(238, 'INVM10000156', 'LR10002410', 'ANT240619252255', '9213855703', 21, '', 1, '', '', '', '', '12', '12', '0', NULL, '40', 'Surge', 'Lend Social', 0.01, 1.01, 26, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-06-19 09:21:20', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(237, 'INVM10000155', 'LR10002410', 'ANT240612236557', '9213855703', 21, '', 2, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0.02, 2.02, 33, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-06-12 06:59:04', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(236, 'INVM10000154', 'LR10002410', 'ANT240611235067', '9213855703', 21, '', 3.13, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0.03, 3.16, 34, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-06-11 12:20:24', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(235, 'INVM10000153', 'LR10002410', 'ANT240611235050', '9213855703', 21, '', 3.13, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0.03, 3.16, 34, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-06-11 12:13:50', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(234, 'INVM10000152', 'LR10002410', 'ANT240603214202', '9213855703', 21, '', 2, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0.04, 2.04, 68, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-05-07 18:30:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(233, 'INVM10000151', 'LR10002454', 'ANT240530203772', '9015439079', 11, '', 2, '', '', '', '', '12', '12', '10', NULL, NULL, 'Surge', 'Lend Social', 0.03, 2.03, 46, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-05-30 06:39:58', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(232, 'INVM10000150', 'LR10002434', 'ANT240514164210', '9717544770', 10, '', 1000, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 20.38, 1020.38, 62, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-05-14 10:02:49', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(231, 'INVM10000149', 'LR10002434', 'ANT240514164000', '9717544770', 11, '', 1000, '', '', '', '', '12', '12', '10', NULL, NULL, 'Surge', 'Lend Social', 0, 1000, 0, 1, 'AntPay', '2024-05-14 03:33:37', '2024-05-14 15:33:37', '2024-05-14 08:33:21', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(230, 'INVM10000148', 'LR10002410', 'ANT240507153312', '9213855703', 10, '', 2, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0.05, 2.05, 69, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-05-07 09:46:42', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(228, 'INVM10000147', 'LR10002410', 'ANT240507153304', '9213855703', 10, '', 2, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0.05, 2.05, 69, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-05-07 09:44:41', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(227, 'INVM10000146', 'LR10002410', 'ANT240507153288', '9213855703', 10, '', 3, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0, 3, 0, 1, 'AntPay', '2024-05-07 03:16:56', '2024-05-07 15:16:56', '2024-05-07 09:39:37', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(226, 'INVM10000145', 'LR10002410', 'ANT240507153281', '9213855703', 10, '', 2, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0.05, 2.05, 69, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-05-07 09:35:40', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(225, 'INVM10000144', 'LR10002410', 'ANT240507153243', '9213855703', 10, '', 4, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0.09, 4.09, 69, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-05-07 09:13:55', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(224, 'INVM10000143', 'LR10002410', 'ANT240507153206', '9213855703', 10, '', 1, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0.02, 1.02, 69, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-05-07 08:50:49', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(223, 'INVM10000142', 'LR10002410', 'ANT240507153194', '9213855703', 10, '', 2, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0.05, 2.05, 69, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-05-07 08:42:02', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(222, 'INVM10000141', 'LR10002419', 'ANT240503148519', '9650678816', 19, '', 2, '', '', '', '', '12', '12', '12', NULL, NULL, 'Surge', 'Lend Social', 0.05, 2.05, 73, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-05-03 11:52:12', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(220, 'INVM10000140', 'LR10002398', 'ANT240417129644', '8447776253', 18, '', 1, '', '', '', '', '12', '0', '0', NULL, NULL, 'Surge', 'Lend Social', 0, 1, 0, 5, 'AntPay', '2024-04-17 05:25:52', '2024-04-17 18:10:16', '2024-04-17 11:55:15', '21', '2024-04-17 18:10:16', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(219, 'INVM10000139', 'LR10002272', 'ANT240409121363', '9015439079', 10, '', 1, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0.03, 1.03, 97, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-04-09 09:57:52', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(218, 'INVM10000138', 'LR10002294', 'ANT240322101255', '9213855703', 10, '', 1, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0.04, 1.04, 115, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-03-22 10:47:06', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(217, 'INVM10000137', 'LR10002272', 'ANT240322101168', '9015439079', 10, '', 1, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0.04, 1.04, 115, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-03-22 10:09:35', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(216, 'INVM10000136', 'LR10002272', 'ANT240322101135', '9015439079', 10, '', 2.2, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0, 2.2, 0, 1, 'AntPay', '2024-03-22 03:23:33', '2024-03-22 15:23:33', '2024-03-22 09:53:12', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(214, 'INVM10000135', 'LR10002272', 'ANT240322101128', '9015439079', 10, '', 1, '', '', '', '', '12', '12', '0', NULL, NULL, 'Surge', 'Lend Social', 0.04, 1.04, 115, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-03-22 09:50:08', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(213, 'INVM10000134', 'LR10002306', 'ANT240301075438', '8882689392', 17, '', 1, '', '', '', '', '12', '12', '10', NULL, NULL, 'Surge', 'Lend Social', 0.04, 1.04, 136, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-03-01 12:07:16', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(212, 'INVM10000133', 'LR10002295', 'ANT240227070920', '9717544770', 17, '', 1, '', '', '', '', '12', '12', '10', NULL, NULL, 'Surge', 'Lend Social', 0, 1, 0, 4, 'AntPay', '2024-02-27 06:14:20', '2024-02-27 18:16:07', '2024-02-27 12:41:35', '19', '2024-02-27 18:14:37', '19', '2024-02-27 18:15:29', '19', '2024-02-27 18:16:07', ' 1234567891'),
(211, 'INVM10000132', 'LR10002293', 'ANT240227070835', '8882689392', 17, '', 3, '', '', '', '', '12', '12', '10', NULL, NULL, 'Surge', 'Lend Social', 0.14, 3.14, 139, 0, 'AntPay', '0000-00-00 00:00:00', '2024-07-15 01:00:40', '2024-02-27 11:32:25', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `p2p_lender_investment`
--
ALTER TABLE `p2p_lender_investment`
  ADD PRIMARY KEY (`reinvestment_id`),
  ADD UNIQUE KEY `investment_No` (`investment_No`),
  ADD UNIQUE KEY `ant_txn_id` (`ant_txn_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `p2p_lender_investment`
--
ALTER TABLE `p2p_lender_investment`
  MODIFY `reinvestment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
