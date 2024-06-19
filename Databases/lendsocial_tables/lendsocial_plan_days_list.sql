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
-- Table structure for table `lendsocial_plan_days_list`
--

CREATE TABLE `lendsocial_plan_days_list` (
  `id` int(11) NOT NULL,
  `lender_days` int(11) NOT NULL,
  `borrower_days` int(11) NOT NULL,
  `updated_time` datetime DEFAULT current_timestamp(),
  `created_time` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='table is using for mapping of investment days vs borrower da';

--
-- Dumping data for table `lendsocial_plan_days_list`
--

INSERT INTO `lendsocial_plan_days_list` (`id`, `lender_days`, `borrower_days`, `updated_time`, `created_time`, `status`) VALUES
(1, 40, 30, '2024-06-19 15:09:24', '2024-06-19 00:00:00', 1),
(2, 70, 60, '2024-06-19 15:10:19', '2024-06-19 00:00:00', 1),
(3, 100, 90, '2024-06-19 15:10:19', '2024-06-19 00:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lendsocial_plan_days_list`
--
ALTER TABLE `lendsocial_plan_days_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lendsocial_plan_days_list`
--
ALTER TABLE `lendsocial_plan_days_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
