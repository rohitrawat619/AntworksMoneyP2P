-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2024 at 08:55 AM
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
-- Indexes for table `trans_nach_subsequent_payment_order`
--
ALTER TABLE `trans_nach_subsequent_payment_order`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `trans_nach_subsequent_payment_order`
--
ALTER TABLE `trans_nach_subsequent_payment_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
