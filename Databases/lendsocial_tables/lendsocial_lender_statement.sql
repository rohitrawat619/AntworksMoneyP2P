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
-- Table structure for table `lendsocial_lender_statement`
--

CREATE TABLE `lendsocial_lender_statement` (
  `id` int(11) NOT NULL,
  `partner_id` varchar(20) NOT NULL,
  `lender_id` varchar(20) NOT NULL,
  `transaction_type` enum('investment','loanRepayment','disbursedAmount') DEFAULT NULL COMMENT 'investment: payment made by lender; loanRepayment: loan amount received from the borrower; disbursedAmount: amount disbursed by the partner to its borrower',
  `loan_no` varchar(20) NOT NULL COMMENT 'filed is using for borrowing',
  `title` varchar(200) NOT NULL COMMENT 'overview of the transaction ',
  `refrence` varchar(200) NOT NULL,
  `reference_type` varchar(20) NOT NULL COMMENT 'investment_id/loan_id/borrow_id',
  `debit` varchar(11) NOT NULL COMMENT 'filed is using for borrowing',
  `credit` varchar(11) NOT NULL,
  `amount` varchar(11) NOT NULL COMMENT 'actual amount',
  `balance` varchar(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_id` varchar(30) NOT NULL,
  `source` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lendsocial_lender_statement`
--

INSERT INTO `lendsocial_lender_statement` (`id`, `partner_id`, `lender_id`, `transaction_type`, `loan_no`, `title`, `refrence`, `reference_type`, `debit`, `credit`, `amount`, `balance`, `created_date`, `created_id`, `source`) VALUES
(57124, '1', 'LR10001751', 'investment', '', '', 'INVM10000122', 'investment_id', '', '240', '240', '2400', '2024-05-22 00:00:00', '', 'lensocial'),
(57125, '', 'LR10002410', NULL, '', '', 'INVM10000142', 'investment_no', '', '2', '2', '', '0000-00-00 00:00:00', '', 'Surge'),
(57126, '', 'LR10002410', 'investment', '', '', 'INVM10000143', 'investment_no', '', '1', '1', '', '2024-05-07 14:20:49', '', 'Surge'),
(57127, '1', 'LR10002410', 'investment', '', '', 'INVM10000144', 'investment_no', '', '4', '4', '540', '2024-05-07 14:43:55', '', 'Surge'),
(57128, '1', 'LR10002410', 'investment', '', '2 Invested By Lender', 'INVM10000145', 'investment_no', '', '2', '2', '542', '2024-05-07 15:05:40', '', 'Surge'),
(57129, '1', 'LR10002410', 'investment', '', '3 Invested By Lender', 'INVM10000146', 'investment_no', '', '3', '3', '545', '2024-05-07 15:09:37', '', 'Surge'),
(57130, '1', 'LR10002410', 'investment', '', '2 Invested By Lender', 'INVM10000147', 'investment_no', '', '2', '2', '547', '2024-05-07 15:14:41', '', 'Surge'),
(57131, '1', 'LR10002410', 'investment', '', '2 Invested By Lender', 'INVM10000148', 'investment_no', '', '200', '200', '200', '2024-05-07 15:16:42', '', 'Surge'),
(57175, '1', 'LR10001751', 'disbursedAmount', 'LN10000004516', 'disbursed to the borrower', 'INVM10000122', 'investment_no', '2400', '', '2400', '0', '2024-05-09 09:35:58', '', 'lendsocialW'),
(57176, '1', 'LR10002410', 'disbursedAmount', 'LN10000004516', 'disbursed to the borrower', 'INVM10000144', 'investment_no', '4', '', '4', '196', '2024-05-09 09:35:58', '', 'lendsocialW'),
(57177, '1', 'LR10002410', 'disbursedAmount', 'LN10000004516', 'disbursed to the borrower', 'INVM10000148', 'investment_no', '96', '', '96', '100', '2024-05-09 09:35:58', '', 'lendsocialW'),
(57178, '1', 'LR10002434', 'investment', '', '1000 Invested By Lender', 'INVM10000149', 'investment_no', '', '1000', '1000', '1000', '2024-05-14 14:03:21', '', 'Surge'),
(57179, '1', 'LR10002434', 'investment', '', '1000 Invested By Lender', 'INVM10000150', 'investment_no', '', '1000', '1000', '2000', '2024-05-14 15:32:49', '', 'Surge'),
(57180, '1', 'LR10002454', 'investment', '', '2 Invested By Lender', 'INVM10000151', 'investment_no', '', '2', '2', '2', '2024-05-30 12:09:58', '', 'Surge'),
(57181, '1', 'LR10002410', 'investment', '', '2 Invested By Lender', 'INVM10000152', 'investment_no', '', '2', '2', '102', '2024-06-03 16:07:52', '', 'Surge'),
(57182, '1', 'LR10002410', 'investment', '', '3.13 Invested By Lender', 'INVM10000153', 'investment_no', '', '3.13', '3.13', '105.13', '2024-06-11 17:43:50', '', 'Surge'),
(57183, '1', 'LR10002410', 'investment', '', '3.13 Invested By Lender', 'INVM10000154', 'investment_no', '', '3.13', '3.13', '108.26', '2024-06-11 17:50:24', '', 'Surge'),
(57184, '1', 'LR10002410', 'investment', '', '2 Invested By Lender', 'INVM10000155', 'investment_no', '', '2', '2', '110.26', '2024-06-12 12:29:04', '', 'Surge'),
(57185, '1', 'LR10002410', 'investment', '', '1 Invested By Lender', 'INVM10000156', 'investment_no', '', '1', '1', '111.26', '2024-06-19 14:51:20', '', 'Surge');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lendsocial_lender_statement`
--
ALTER TABLE `lendsocial_lender_statement`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lendsocial_lender_statement`
--
ALTER TABLE `lendsocial_lender_statement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57186;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
