-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2024 at 01:56 PM
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
-- Table structure for table `borrower_proposed_list`
--

CREATE TABLE `borrower_proposed_list` (
  `id` int(11) NOT NULL,
  `lender_id` varchar(100) DEFAULT NULL,
  `request_date` datetime DEFAULT NULL,
  `requestor_id` varchar(60) DEFAULT NULL,
  `request_status` enum('pending','approved','rejected') DEFAULT NULL,
  `request_update_date` datetime DEFAULT NULL,
  `request_update_id` varchar(60) DEFAULT NULL,
  `borrower_id` varchar(10) DEFAULT NULL,
  `amount` varchar(10) DEFAULT NULL COMMENT 'Amount which we need from that particular lender',
  `borrower_priority_queue_id` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Lendsocial New Table For Diversification Rule';

--
-- Dumping data for table `borrower_proposed_list`
--

INSERT INTO `borrower_proposed_list` (`id`, `lender_id`, `request_date`, `requestor_id`, `request_status`, `request_update_date`, `request_update_id`, `borrower_id`, `amount`, `borrower_priority_queue_id`) VALUES
(1, 'LR10000004', NULL, NULL, 'pending', NULL, NULL, 'BR10000011', NULL, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrower_proposed_list`
--
ALTER TABLE `borrower_proposed_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lender_id` (`lender_id`),
  ADD KEY `borrower_id` (`borrower_id`),
  ADD KEY `borrower_priority_queue_id` (`borrower_priority_queue_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrower_proposed_list`
--
ALTER TABLE `borrower_proposed_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrower_proposed_list`
--
ALTER TABLE `borrower_proposed_list`
  ADD CONSTRAINT `borrower_id (borrower_proposed_list) constraint` FOREIGN KEY (`borrower_id`) REFERENCES `p2p_borrowers_list` (`borrower_id`),
  ADD CONSTRAINT `borrower_priority_queue constraint` FOREIGN KEY (`borrower_priority_queue_id`) REFERENCES `p2p_borrower_priority_queue` (`id`),
  ADD CONSTRAINT `lender_id (borrower_proposed_list) constraint` FOREIGN KEY (`lender_id`) REFERENCES `p2p_lender_list` (`lender_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
