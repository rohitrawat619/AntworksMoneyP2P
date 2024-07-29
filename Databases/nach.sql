-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2024 at 02:01 PM
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
-- Table structure for table `master_nach_customer`
--

CREATE TABLE `master_nach_customer` (
  `id` int(11) NOT NULL,
  `borrower_id` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `notes_key_1` varchar(200) DEFAULT NULL,
  `notes_key_2` varchar(200) DEFAULT NULL,
  `cust_id` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_id` varchar(100) DEFAULT NULL,
  `updated_id` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_nach_customer_order`
--

CREATE TABLE `master_nach_customer_order` (
  `id` int(11) NOT NULL,
  `amount` varchar(10) DEFAULT '0',
  `currency` varchar(10) DEFAULT 'INR',
  `payment_capture` tinyint(1) DEFAULT 1,
  `method` varchar(20) DEFAULT 'emandate',
  `customer_id` varchar(100) DEFAULT NULL,
  `receipt_no` varchar(100) DEFAULT NULL,
  `notes_key_1` varchar(200) DEFAULT NULL,
  `notes_key_2` varchar(200) DEFAULT NULL,
  `auth_type` varchar(100) DEFAULT NULL,
  `max_amount` varchar(100) DEFAULT NULL,
  `expire_at` varchar(100) DEFAULT NULL,
  `token_notes_key_1` varchar(200) DEFAULT NULL,
  `token_notes_key_2` varchar(200) DEFAULT NULL,
  `beneficiary_name` varchar(100) DEFAULT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `account_type` varchar(100) DEFAULT NULL,
  `ifsc_code` varchar(100) DEFAULT NULL,
  `order_id` varchar(100) DEFAULT NULL,
  `resp_payment_id` varchar(500) DEFAULT NULL COMMENT 'webhook returns the payment_id',
  `resp_token_id` varchar(200) DEFAULT NULL COMMENT 'v1/payments/{razorpay_payment_id} : it returns token id',
  `nach_balance` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_id` varchar(100) DEFAULT NULL,
  `updated_id` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trans_nach_subsequent_payment_order`
--

CREATE TABLE `trans_nach_subsequent_payment_order` (
  `id` int(11) NOT NULL,
  `amount` varchar(50) DEFAULT NULL,
  `currency` varchar(20) DEFAULT 'INR',
  `payment_capture` tinyint(1) DEFAULT 1,
  `receipt` varchar(50) DEFAULT NULL,
  `notes_key_1` varchar(200) DEFAULT NULL,
  `notes_key_2` varchar(200) DEFAULT NULL,
  `resp_order_id` varchar(200) DEFAULT NULL,
  `customer_id` varchar(100) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `description` varchar(400) DEFAULT NULL,
  `recurring_notes_key_1` varchar(400) DEFAULT NULL,
  `recurring_notes_key_2` varchar(400) DEFAULT NULL,
  `resp_payment_id` varchar(400) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_id` varchar(100) DEFAULT NULL,
  `updated_id` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_nach_customer`
--
ALTER TABLE `master_nach_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_nach_customer_order`
--
ALTER TABLE `master_nach_customer_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_nach_subsequent_payment_order`
--
ALTER TABLE `trans_nach_subsequent_payment_order`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_nach_customer`
--
ALTER TABLE `master_nach_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_nach_customer_order`
--
ALTER TABLE `master_nach_customer_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_nach_subsequent_payment_order`
--
ALTER TABLE `trans_nach_subsequent_payment_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
