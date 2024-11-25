-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 05:07 PM
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
-- Table structure for table `lendsocial_lender_loan_priority_allocation_queue`
--

CREATE TABLE `lendsocial_lender_loan_priority_allocation_queue` (
  `id` int(11) NOT NULL,
  `partner_id` varchar(20) NOT NULL,
  `lender_id` varchar(20) NOT NULL,
  `invest_id` varchar(20) NOT NULL,
  `amount` varchar(20) NOT NULL COMMENT 'actual invested amount',
  `remaining_amount` varchar(20) NOT NULL COMMENT 'the amount which is remaining to be utilise',
  `status` varchar(20) NOT NULL COMMENT '0:Inactive,1:Active',
  `source` varchar(4000) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_id` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='table is using for allocation of  the lender invested amount based on FIFO rule';

--
-- Dumping data for table `lendsocial_lender_loan_priority_allocation_queue`
--

INSERT INTO `lendsocial_lender_loan_priority_allocation_queue` (`id`, `partner_id`, `lender_id`, `invest_id`, `amount`, `remaining_amount`, `status`, `source`, `created_date`, `created_id`) VALUES
(1, '1', 'LR10001751', 'INVM10000122', '2400', '0', '1', 'lensocial', '2024-05-07 00:00:00', 'lendsocial_test'),
(2, '', 'LR10002410', 'INVM10000142', '2', '2', '1', 'Surge', '0000-00-00 00:00:00', ''),
(3, '', 'LR10002410', 'INVM10000143', '1', '1', '1', '{\"phone\":\"9213855703\",\"lender_id\":\"LR10002410\",\"amount\":\"1\",\"scheme_id\":\"10\",\"ant_txn_id\":\"ANT240507153206\",\"source\":\"Surge\",\"product\":\"Lend Social\"}', '2024-05-07 14:20:49', ''),
(4, '1', 'LR10002410', 'INVM10000144', '4', '0', '1', 'Surge', '2024-05-07 14:43:55', ''),
(5, '1', 'LR10002410', 'INVM10000148', '200', '104', '1', 'Surge', '2024-05-07 15:16:42', ''),
(6, '1', 'LR10002434', 'INVM10000149', '1000', '1000', '1', 'Surge', '2024-05-14 14:03:21', ''),
(7, '1', 'LR10002434', 'INVM10000150', '1000', '1000', '1', 'Surge', '2024-05-14 15:32:49', ''),
(8, '1', 'LR10002454', 'INVM10000151', '2', '2', '1', 'Surge', '2024-05-30 12:09:58', ''),
(9, '1', 'LR10002410', 'INVM10000152', '2', '2', '1', 'Surge', '2024-06-03 16:07:52', ''),
(10, '1', 'LR10002410', 'INVM10000153', '3.13', '3.13', '1', 'Surge', '2024-06-11 17:43:50', ''),
(11, '1', 'LR10002410', 'INVM10000154', '3.13', '3.13', '1', 'Surge', '2024-06-11 17:50:24', ''),
(12, '1', 'LR10002410', 'INVM10000155', '2', '2', '1', 'Surge', '2024-06-12 12:29:04', ''),
(13, '1', 'LR10002410', 'INVM10000156', '1', '1', '1', 'Surge', '2024-06-19 14:51:20', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lendsocial_lender_loan_priority_allocation_queue`
--
ALTER TABLE `lendsocial_lender_loan_priority_allocation_queue`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lendsocial_lender_loan_priority_allocation_queue`
--
ALTER TABLE `lendsocial_lender_loan_priority_allocation_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
