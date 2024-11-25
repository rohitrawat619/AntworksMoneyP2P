-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 05:08 PM
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
-- Table structure for table `lendsocial_lender_interest_statement`
--

CREATE TABLE `lendsocial_lender_interest_statement` (
  `id` int(11) NOT NULL,
  `lender_id` varchar(40) DEFAULT NULL,
  `investment_id` varchar(80) DEFAULT NULL,
  `plan_duration` enum('40','70','100') NOT NULL,
  `investment_duration_days` int(11) NOT NULL COMMENT 'For example, if an investment started on January 1st and today''s date is June 17th, then investment_duration_days would be 168 days.',
  `interest_rate_per_day` decimal(10,4) NOT NULL,
  `interest_accrued` decimal(10,2) NOT NULL DEFAULT 0.00,
  `current_investment_value` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `updated_time` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `data_entry_time` datetime DEFAULT NULL,
  `debit` varchar(10) NOT NULL,
  `credit` varchar(10) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `balance` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Table used for recording lender interest statements';

--
-- Dumping data for table `lendsocial_lender_interest_statement`
--

INSERT INTO `lendsocial_lender_interest_statement` (`id`, `lender_id`, `investment_id`, `plan_duration`, `investment_duration_days`, `interest_rate_per_day`, `interest_accrued`, `current_investment_value`, `payment_status`, `updated_time`, `data_entry_time`, `debit`, `credit`, `amount`, `balance`) VALUES
(1, 'LR10001751', 'INVM10000138', '40', 0, '0.0000', '0.00', '0.00', 'pending', '2024-06-17 14:37:49', NULL, '4.68', '0.00', '0.00', '0.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lendsocial_lender_interest_statement`
--
ALTER TABLE `lendsocial_lender_interest_statement`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lendsocial_lender_interest_statement`
--
ALTER TABLE `lendsocial_lender_interest_statement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
