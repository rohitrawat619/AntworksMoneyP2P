-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2024 at 08:23 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antworks_p2pdevo`
--

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_priority_queue`
--

CREATE TABLE `p2p_borrower_priority_queue` (
  `id` int(11) NOT NULL,
  `borrower_id` varchar(100) NOT NULL,
  `batch_id` varchar(100) DEFAULT NULL,
  `loan_id` varchar(100) DEFAULT NULL,
  `borrowing_amount` varchar(100) NOT NULL DEFAULT '0',
  `remaining_amount_needed` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_nach_enabled` tinyint(1) NOT NULL,
  `is_payout_enabled` tinyint(1) NOT NULL,
  `amount_paid_through_escrow` tinyint(1) NOT NULL,
  `payout_date` datetime DEFAULT NULL,
  `payout_status` varchar(100) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_priority_queue`
--

CREATE TABLE `p2p_lender_priority_queue` (
  `id` int(11) NOT NULL,
  `lender_id` varchar(100) NOT NULL,
  `scheme_id` varchar(100) NOT NULL,
  `batch_id` varchar(100) NOT NULL,
  `invest_id` varchar(100) NOT NULL,
  `inv_amont` varchar(100) NOT NULL,
  `rem_amount` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_nach_enabled` tinyint(1) NOT NULL,
  `is_payout_enabled` tinyint(1) NOT NULL,
  `inv_amount_is_in_escrow` tinyint(1) NOT NULL,
  `payout_status` tinytext DEFAULT NULL,
  `payout_date` date NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `p2p_borrower_priority_queue`
--
ALTER TABLE `p2p_borrower_priority_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_priority_queue`
--
ALTER TABLE `p2p_lender_priority_queue`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `p2p_borrower_priority_queue`
--
ALTER TABLE `p2p_borrower_priority_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_priority_queue`
--
ALTER TABLE `p2p_lender_priority_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
