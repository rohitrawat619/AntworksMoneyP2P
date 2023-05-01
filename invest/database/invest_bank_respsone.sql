-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2023 at 03:10 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `investmentmodule`
--

-- --------------------------------------------------------

--
-- Table structure for table `invest_bank_respsone`
--

CREATE TABLE `invest_bank_respsone` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `account_no` varchar(50) NOT NULL,
  `ifsc_code` varchar(15) NOT NULL,
  `response` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invest_bank_respsone`
--

INSERT INTO `invest_bank_respsone` (`id`, `name`, `account_no`, `ifsc_code`, `response`) VALUES
(10, 'Mr Rohit Dalal', '20382561541', 'SBIN0016669', '{\"status\":1,\"bank_response\":{\"id\":\"fav_LaqtSn04qUlQb5\",\"entity\":\"fund_account.validation\",\"fund_account\":{\"id\":\"fa_LaqtSkJOkhlDTb\",\"entity\":\"fund_account\",\"account_type\":\"bank_account\",\"bank_account\":{\"ifsc\":\"SBIN0016669\",\"bank_name\":\"State Bank of India\",\"name\":\"Mr Rohit Dalal\",\"notes\":[],\"account_number\":\"20382561541\"},\"batch_id\":null,\"active\":true,\"created_at\":1680859735,\"details\":{\"ifsc\":\"SBIN0016669\",\"bank_name\":\"State Bank of India\",\"name\":\"Mr Rohit Dalal\",\"notes\":[],\"account_number\":\"20382561541\"}},\"status\":\"completed\",\"amount\":100,\"currency\":\"INR\",\"notes\":{\"random_key_1\":\"\",\"random_key_2\":\"\"},\"results\":{\"account_status\":\"active\",\"registered_name\":\"Mr  ROHIT  DALAL\"},\"created_at\":1680859735,\"utr\":null},\"msg\":\"Bank verified successfully\"}'),
(11, 'Mr Rohit Dalal', '6696786916', 'IDIB000S208', '{\"status\":1,\"bank_response\":{\"id\":\"fav_Lar118OzubRizl\",\"entity\":\"fund_account.validation\",\"fund_account\":{\"id\":\"fa_Lar115FFpRnqjH\",\"entity\":\"fund_account\",\"account_type\":\"bank_account\",\"bank_account\":{\"ifsc\":\"IDIB000S208\",\"bank_name\":\"Indian Bank\",\"name\":\"Rohit Dalal\",\"notes\":[],\"account_number\":\"6696786916\"},\"batch_id\":null,\"active\":true,\"created_at\":1680860164,\"details\":{\"ifsc\":\"IDIB000S208\",\"bank_name\":\"Indian Bank\",\"name\":\"Rohit Dalal\",\"notes\":[],\"account_number\":\"6696786916\"}},\"status\":\"completed\",\"amount\":100,\"currency\":\"INR\",\"notes\":{\"random_key_1\":\"\",\"random_key_2\":\"\"},\"results\":{\"account_status\":\"active\",\"registered_name\":\"ROHIT  DALAL\"},\"created_at\":1680860164,\"utr\":\"309715696140\"},\"msg\":\"Bank verified successfully\"}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invest_bank_respsone`
--
ALTER TABLE `invest_bank_respsone`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invest_bank_respsone`
--
ALTER TABLE `invest_bank_respsone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
