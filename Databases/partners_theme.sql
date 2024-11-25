-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2024 at 12:36 PM
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
-- Table structure for table `partners_theme`
--

CREATE TABLE `partners_theme` (
  `theme_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `partner_id` int(10) NOT NULL COMMENT 'invest_vender->VID; this is a vendor ID ',
  `color` varchar(20) NOT NULL,
  `background_color` varchar(20) NOT NULL,
  `logo_path` varchar(400) NOT NULL,
  `lender_logo_path` varchar(400) DEFAULT NULL,
  `borrower_logo_path` varchar(400) DEFAULT NULL,
  `font_family` varchar(400) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user_id` varchar(40) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_user_id` varchar(40) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0; Inactive; 1:active',
  `borrower_product_name` varchar(200) NOT NULL,
  `lender_product_name` varchar(200) NOT NULL,
  `partner_type` varchar(20) DEFAULT NULL COMMENT 'lender/borrower/both',
  `system_generated_id` varchar(600) DEFAULT NULL,
  `disbursment_method` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='this table is using for add the mapping of particular theme ';

--
-- Dumping data for table `partners_theme`
--

INSERT INTO `partners_theme` (`theme_id`, `name`, `partner_id`, `color`, `background_color`, `logo_path`, `lender_logo_path`, `borrower_logo_path`, `font_family`, `created_date`, `created_user_id`, `updated_date`, `updated_user_id`, `status`, `borrower_product_name`, `lender_product_name`, `partner_type`, `system_generated_id`, `disbursment_method`) VALUES
(34, 'Test Comany SeptDac', 35, '#000000', '#000000', '<', '<', '<', 'Arial, sans-serif', '2024-09-20 12:21:40', '14', '0000-00-00 00:00:00', '', 1, '', '', 'lender', 'MzQ=', 'Select Disbursment M'),
(31, 'Zylo Micro ', 30, '#000000', '#000000', '<', '<', '<', 'Arial, sans-serif', '2024-09-17 15:38:28', '14', '0000-00-00 00:00:00', '', 1, 'Zylo Micro', 'a', 'borrower', NULL, 'Select Disbursment M'),
(30, 'Mashrah Films Private Limited', 29, '#000000', '#000000', '', '', '<', 'Arial, sans-serif', '2024-09-17 11:56:48', '14', '0000-00-00 00:00:00', '', 1, '', 'Mashrah', 'lender', NULL, 'Select Disbursment M'),
(29, 'Bizpulse Business Consulting Pvt Ltd', 28, '#000000', '#000000', 'D:/public_html/antworksp2p.com/document/surge/upload/vendor/mainLogo/28/inway-logo.png', 'D:/public_html/antworksp2p.com/document/surge/upload/vendor/mainLogo/28/inway-logo2.png', '<', 'Arial, sans-serif', '2024-08-06 18:12:55', '14', '0000-00-00 00:00:00', '', 1, '', 'Inway 12', 'lender', NULL, 'Select Disbursment M'),
(28, 'Antworks Money One', 27, '#000000', '#000000', '<', '<', '<', 'Arial, sans-serif', '2024-08-16 14:24:19', '14', '0000-00-00 00:00:00', '', 1, 'test new borrower', 'test new lender', 'both', NULL, 'Select Disbursment M'),
(27, 'People-Banking', 25, '#2f97f9', '#ec2222', 'D:/public_html/antworksp2p.com/document/surge/upload/vendor/mainLogo/25/Untitled4.png', '<', '<', 'Arial, sans-serif', '2024-05-21 18:50:48', '24', '0000-00-00 00:00:00', '', 1, 'paritosh jha', 'Paritosh Jha', 'both', NULL, 'Select Disbursment M'),
(26, 'LendingHub', 24, '#ef2525', '#e81717', '<', '<', '<', 'Arial, sans-serif', '2024-05-03 17:18:00', '14', '0000-00-00 00:00:00', '', 1, 'LendingHub_Borrower', 'LendingHub_Invest', 'both', NULL, 'Select Disbursment M'),
(25, 'Antworks Money Auto', 23, '#000000', '#000000', '<', 'D:/public_html/antworksp2p.com/document/surge/upload/vendor/mainLogo/23/low-fees.png', NULL, 'Times New Roman, serif', '2024-05-03 12:13:49', '14', '0000-00-00 00:00:00', '', 1, 'Borrower', 'Lender', 'both', NULL, 'automatic'),
(24, 'Antworks Money', 22, '#1f71f4', '#5b3583', '<', NULL, NULL, 'Arial, sans-serif', '2024-04-25 15:22:59', '14', '0000-00-00 00:00:00', '', 1, 'Borrow', 'Invest', 'both', NULL, 'manual'),
(23, 'testww', 21, '#d7e39d', '#511ebb', 'D:/public_html/antworksp2p.com/document/surge/upload/vendor/21/securing-loan.png', NULL, NULL, 'Arial, sans-serif', '2024-04-16 18:23:56', '14', '0000-00-00 00:00:00', '', 1, '', '', 'both', NULL, 'Select Disbursment M'),
(21, 'coco cola', 17, '#000000', '#000000', '<', NULL, NULL, 'Courier New, monospace', '2024-03-14 15:06:46', '14', '0000-00-00 00:00:00', '', 1, '', '', 'both', NULL, 'both'),
(20, 'Shantanu Tewary', 16, '#7a3838', '#211212', '<', NULL, NULL, 'Courier New, monospace', '2024-05-29 17:09:54', '14', '0000-00-00 00:00:00', '', 1, 'credit-line', 'surge', 'both', NULL, 'manual'),
(19, 'shantanu_tewary', 15, '#46e2a6', '#db0f0f', '<', NULL, NULL, 'Arial, sans-serif', '2024-02-20 18:04:59', '14', '0000-00-00 00:00:00', '', 1, '', '', 'both', NULL, 'both'),
(18, 'anttestone', 14, '#de1b1b', '#10e013', '<', NULL, NULL, 'Times New Roman, serif', '2024-02-09 13:05:23', '15', '0000-00-00 00:00:00', '', 1, '', '', NULL, NULL, 'Select Disbursment M'),
(17, 'MFL', 13, '#29b71f', '#da1010', '<', NULL, NULL, 'Times New Roman, serif', '2024-02-04 12:00:44', '15', '0000-00-00 00:00:00', '', 1, '', '', NULL, NULL, 'Select Disbursment M'),
(16, 'ersrtftyu', 12, '#da1616', '#4be713', '<', NULL, NULL, 'Times New Roman, serif', '2024-02-03 15:34:33', '15', '0000-00-00 00:00:00', '', 1, '', '', NULL, NULL, 'Select Disbursment M'),
(15, 'DPLSK', 11, 'BLUE', 'RED', '<', NULL, NULL, 'ARIAL', '2024-02-01 10:22:50', '15', '0000-00-00 00:00:00', '', 1, '', '', NULL, NULL, 'Select Disbursment M'),
(14, 'Ram Pvt', 10, '#a0fdf7', '#211eb8', 'D:/public_html/antworksp2p.com/document/surge/upload/vendor/10/logo1.png', NULL, NULL, 'Courier New, monospace', '2024-05-30 15:17:58', '14', '0000-00-00 00:00:00', '', 1, 'Borrower', 'abc', 'both', NULL, 'manual'),
(13, 'Ashish_test', 7, '#000000', '#000000', '', NULL, NULL, '', '2024-02-20 17:59:24', '14', '0000-00-00 00:00:00', '', 1, 'AntPay_buddy', 'SURGE', 'both', NULL, 'Select Disbursment M'),
(6, 'abc', 9, 'red', '123', '', NULL, NULL, '123', '2024-01-24 16:56:32', '13', '0000-00-00 00:00:00', '', 1, 'lender', '', 'both', NULL, 'both'),
(3, 'antbizzhub', 4, '#ffffff', '#000000', '', NULL, NULL, '', '2024-05-30 14:20:48', '14', '0000-00-00 00:00:00', '', 1, '', '', 'both', NULL, 'Select Disbursment M'),
(2, 'antworks bizzhub', 3, '#ffffff', '#000000', '', NULL, 'D:/public_html/antworksp2p.com/document/surge/upload/vendor/mainLogo/3/antpaybizhub-logo.png', 'Arial, sans-serif', '2024-05-30 14:18:09', '14', '0000-00-00 00:00:00', '', 1, 'Credit-line', 'Surge', 'both', NULL, 'automatic'),
(1, 'Antworks Financial Buddy Technologies Pvt Ltd', 1, '#ffffff', '#5b3583', 'D:/public_html/antworksp2p.com/document/surge/upload/vendor/1/lend-social-logo-300x77(1).png', 'D:/public_html/antworksp2p.com/document/surge/upload/vendor/mainLogo/1/lend-social-logo-300x77(1).png', 'D:/public_html/antworksp2p.com/document/surge/upload/vendor/mainLogo/1/securing-loan2.png', 'Courier New, monospace', '2024-08-22 16:28:41', '14', '0000-00-00 00:00:00', '', 1, 'Lending Product', 'Investment Product', 'both', NULL, 'automatic');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `partners_theme`
--
ALTER TABLE `partners_theme`
  ADD UNIQUE KEY `theme_id` (`theme_id`),
  ADD KEY `constraint_partners_themePartnerId` (`partner_id`),
  ADD KEY `constraint_partners_themePartnerType` (`partner_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `partners_theme`
--
ALTER TABLE `partners_theme`
  MODIFY `theme_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
