-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2024 at 02:35 PM
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
-- Table structure for table `lendsocial_lender_payout_schedule`
--

CREATE TABLE `lendsocial_lender_payout_schedule` (
  `id` int(12) NOT NULL,
  `investment_No` varchar(600) DEFAULT NULL,
  `basic_rate` varchar(600) DEFAULT NULL,
  `hike_rate` varchar(600) DEFAULT NULL,
  `tenure` varchar(600) DEFAULT NULL,
  `amount` varchar(11) NOT NULL COMMENT 'this is an investment amount',
  `scheme_id` varchar(600) DEFAULT NULL,
  `created_date` varchar(600) DEFAULT NULL,
  `created_id` varchar(600) DEFAULT NULL,
  `redemption_status` int(11) NOT NULL COMMENT '4->"Redeemed"; 2->"Under Process"; 5->"Generate Bank File Pending"; 1->"Approval Pending";	',
  `payout_type` enum('monthly','maturity') DEFAULT NULL COMMENT 'this is a Payout Type',
  `payout_date` datetime DEFAULT NULL COMMENT 'this is a Payout Due Date',
  `payout_status` int(2) DEFAULT NULL COMMENT '1: payout completed: 0: payout pending',
  `payment_type` enum('Interest','InterestAndPrinciple') DEFAULT NULL COMMENT 'for type of payment like, first 30days would be the "Interest" then we''ll calculate, Interest + Principle amount based on days',
  `interest_days` varchar(11) DEFAULT NULL COMMENT 'this is the number days interest have to pay',
  `interval_days` varchar(11) DEFAULT NULL COMMENT 'this is an interval payout period',
  `mobile` varchar(11) DEFAULT NULL,
  `interest_per_day` varchar(10) DEFAULT NULL COMMENT 'interest_per_day amount is given',
  `final_interest` varchar(10) DEFAULT NULL COMMENT 'this is a total interest',
  `payout_amount` varchar(11) DEFAULT NULL COMMENT 'total amount have to pay on that particular days',
  `batchProcessingId` varchar(400) NOT NULL,
  `error_msg` varchar(600) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_by_data_entry_time` datetime DEFAULT NULL,
  `generated_bank_file_by` int(11) DEFAULT NULL,
  `generated_bank_file_by_data_entry_time` datetime DEFAULT NULL,
  `processed_by` int(11) DEFAULT NULL,
  `processed_by_remarks` text DEFAULT NULL,
  `processed_by_data_entry_time` datetime DEFAULT NULL,
  `api_response` text DEFAULT NULL,
  `batch_id` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lendsocial_lender_payout_schedule`
--

INSERT INTO `lendsocial_lender_payout_schedule` (`id`, `investment_No`, `basic_rate`, `hike_rate`, `tenure`, `amount`, `scheme_id`, `created_date`, `created_id`, `redemption_status`, `payout_type`, `payout_date`, `payout_status`, `payment_type`, `interest_days`, `interval_days`, `mobile`, `interest_per_day`, `final_interest`, `payout_amount`, `batchProcessingId`, `error_msg`, `approved_by`, `approved_by_data_entry_time`, `generated_bank_file_by`, `generated_bank_file_by_data_entry_time`, `processed_by`, `processed_by_remarks`, `processed_by_data_entry_time`, `api_response`, `batch_id`) VALUES
(45, 'INVM10000159', '12', NULL, '40', '1', '21', '2024-07-26 12:03:18', NULL, 2, 'monthly', '2024-06-04 00:00:00', 0, 'Interest', '30', '40', '2147483647', '0', '0.01', '1', '166a3432eb6967', NULL, 14, '2024-08-08 12:30:19', 14, '2024-08-08 12:30:32', 14, NULL, '2024-08-07 17:50:31', '{\"code\":\"OAUTH_BAD_TOKEN\",\"message\":\"Bad token; invalid JSON\"}', 'Y21WeFgySmhkR05vWHpZMllqUTJaREEzTmpRMllXTXdMamd4TVRneU1UVTQ='),
(46, 'INVM10000159', '12', NULL, '40', '1', '21', '2024-07-26 12:03:18', NULL, 0, 'monthly', '2024-07-02 00:00:00', 0, 'InterestAndPrinciple', '40', '70', '2147483647', '0', '0.01', '1', '166a3432eb6967', NULL, 14, '2024-08-08 11:44:41', 14, '2024-08-08 11:44:57', 14, NULL, '2024-08-07 11:47:30', '{\"error\":{\"code\":\"BAD_REQUEST_ERROR\",\"description\":\"Different request body sent for the same Idempotency Header\",\"source\":null,\"step\":null,\"reason\":null,\"metadata\":[]}}', 'Y21WeFgySmhkR05vWHpZMllqUTJNalU0WldRM1l6ZzFMalExTVRnNU1ETTQ=');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lendsocial_lender_payout_schedule`
--
ALTER TABLE `lendsocial_lender_payout_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `constraintPayout` (`investment_No`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lendsocial_lender_payout_schedule`
--
ALTER TABLE `lendsocial_lender_payout_schedule`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lendsocial_lender_payout_schedule`
--
ALTER TABLE `lendsocial_lender_payout_schedule`
  ADD CONSTRAINT `constraintPayout` FOREIGN KEY (`investment_No`) REFERENCES `p2p_lender_investment` (`investment_No`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
