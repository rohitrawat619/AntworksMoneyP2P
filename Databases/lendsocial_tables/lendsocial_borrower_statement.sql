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
-- Table structure for table `lendsocial_borrower_statement`
--

CREATE TABLE `lendsocial_borrower_statement` (
  `id` int(11) NOT NULL,
  `partner_id` varchar(20) NOT NULL,
  `borrower_id` varchar(20) NOT NULL,
  `transaction_type` varchar(100) NOT NULL COMMENT 'which type of transaction is related to :''loanBorrow'',''loanRepayment'',',
  `loan_no` varchar(20) NOT NULL,
  `investment_no` varchar(400) NOT NULL,
  `title` varchar(100) NOT NULL COMMENT 'title of transaction is related to ',
  `reference` varchar(100) NOT NULL,
  `reference_type` varchar(100) NOT NULL COMMENT 'investment_id/loan_id/borrow_id',
  `debit` varchar(20) NOT NULL,
  `credit` varchar(20) NOT NULL,
  `amount` varchar(20) NOT NULL COMMENT 'actual amount',
  `balance` varchar(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_id` varchar(40) NOT NULL,
  `source` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='borrower_statement';

--
-- Dumping data for table `lendsocial_borrower_statement`
--

INSERT INTO `lendsocial_borrower_statement` (`id`, `partner_id`, `borrower_id`, `transaction_type`, `loan_no`, `investment_no`, `title`, `reference`, `reference_type`, `debit`, `credit`, `amount`, `balance`, `created_date`, `created_id`, `source`) VALUES
(14, '1', '98796', 'loanBorrow', 'LN10000004516', 'INVM10000122,INVM10000144,INVM10000148', 'loan_received_by_the_lender', '\'INVM10000122\',\'INVM10000144\',\'INVM10000148\'', 'investment_no', '', '2500', '2500', '2500', '2024-05-09 09:35:58', '', 'lendsocialWebApp');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lendsocial_borrower_statement`
--
ALTER TABLE `lendsocial_borrower_statement`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lendsocial_borrower_statement`
--
ALTER TABLE `lendsocial_borrower_statement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
