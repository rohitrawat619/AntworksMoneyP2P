-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 05:01 PM
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
-- Table structure for table `basic_filter_rules`
--

CREATE TABLE `basic_filter_rules` (
  `id` int(11) NOT NULL,
  `min_age` int(11) NOT NULL,
  `max_age` int(11) NOT NULL,
  `qualification` text NOT NULL,
  `occupation` text NOT NULL,
  `company_category` text DEFAULT NULL,
  `salary_less_than` int(11) NOT NULL,
  `credit_score` int(11) NOT NULL,
  `pan_validate_with_filled_details` enum('Yes','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `basic_filter_rules`
--

INSERT INTO `basic_filter_rules` (`id`, `min_age`, `max_age`, `qualification`, `occupation`, `company_category`, `salary_less_than`, `credit_score`, `pan_validate_with_filled_details`) VALUES
(1, 18, 65, 'Graduate,Post Graduate,Professional', 'Salaried', NULL, 12000, 750, 'Yes'),
(2, 18, 65, 'Graduate,Post Graduate,Professional,Other', 'Salaried', NULL, 12000, 750, 'Yes'),
(3, 18, 65, 'Undergraduate,Graduate,Post Graduate,Professional,Other', 'Salaried', NULL, 12000, 750, 'Yes'),
(4, 18, 65, 'Graduate,Post Graduate,Professional', 'Salaried', NULL, 12000, 750, 'Yes'),
(5, 18, 65, 'Graduate,Post Graduate,Professional', 'Salaried', 'CATGA,CATGB', 12000, 750, 'Yes'),
(6, 18, 65, 'Graduate,Post Graduate,Professional', 'Salaried', 'CATGA,CATGB,CATGC,CATGCX,SCATA', 12000, 750, 'Yes'),
(7, 18, 65, 'Graduate,Post Graduate,Professional', 'Salaried', 'CATGA,CATGB,CATGC,CATGCX,SCATA', 12000, 650, 'Yes'),
(8, 18, 65, 'Graduate,Post Graduate,Professional', 'Salaried', 'A,B,CAT A,CAT B,CAT C,CAT GOVT,CATGA,CATGB,CATGC,CATGCX,GOVT,SCATA,Super A', 12000, 650, 'Yes'),
(9, 18, 65, 'Graduate,Post Graduate,Professional', 'Salaried', 'A,B,CAT A,CAT B,CAT C,CAT GOVT,CATGA,CATGB,CATGC,CATGCX,GOVT,SCATA,Super A', 12000, 650, 'Yes'),
(10, 18, 65, 'Graduate,Post Graduate,Professional', 'Salaried', 'A,B,CAT A,CAT B,CAT C,CAT GOVT,CATGA,CATGB,CATGC,CATGCX,GOVT,SCATA,Super A', 12000, 650, 'Yes'),
(11, 18, 65, 'Graduate,Post Graduate,Professional', 'Salaried', 'A,B,CAT A,CAT B,CAT C,CAT GOVT,CATGA,CATGB,CATGC,CATGCX,GOVT,SCATA,Super A', 12000, 700, 'Yes'),
(12, 18, 65, 'Undergraduate,Graduate,Post Graduate,Professional,Other', 'Salaried', 'A,B,CAT A,CAT B,CAT C,CAT GOVT,CATGA,CATGB,CATGC,CATGCX,GOVT,SCATA,Super A', 12000, 700, 'Yes'),
(13, 18, 65, 'Undergraduate,Graduate,Post Graduate,Professional,Other', 'Salaried', ',A,B,C,CAT A,CAT B,CAT C,CAT D,CAT EDU,CAT GOVT,CAT MED,Category,CATGA,CATGB,CATGC,CATGCX,CATGD,D,DEF,DNS,DNS-Credit/FCU,FinalCategory,GA/GB/GC,GOVT,PMF,POL,SCATA,STF,Super A', 12000, 700, 'Yes'),
(14, 18, 65, 'Undergraduate,Graduate,Post Graduate,Professional,Other', 'Salaried,Self employed Business,Self Employed Professional', ',A,B,C,CAT A,CAT B,CAT C,CAT D,CAT EDU,CAT GOVT,CAT MED,Category,CATGA,CATGB,CATGC,CATGCX,CATGD,D,DEF,DNS,DNS-Credit/FCU,FinalCategory,GA/GB/GC,GOVT,PMF,POL,SCATA,STF,Super A', 12000, 700, 'Yes'),
(15, 18, 60, 'Undergraduate,Graduate,Post Graduate,Professional,Other', 'Salaried,Self employed Business,Self Employed Professional', ',A,B,C,CAT A,CAT B,CAT C,CAT D,CAT EDU,CAT GOVT,CAT MED,Category,CATGA,CATGB,CATGC,CATGCX,CATGD,D,DEF,DNS,DNS-Credit/FCU,FinalCategory,GA/GB/GC,GOVT,PMF,POL,SCATA,STF,Super A', 12000, 700, 'Yes'),
(16, 18, 60, 'Graduate,Post Graduate,Professional,Other', 'Salaried,Self employed Business,Self Employed Professional', ',A,B,C,CAT A,CAT B,CAT C,CAT D,CAT EDU,CAT GOVT,CAT MED,Category,CATGA,CATGB,CATGC,CATGCX,CATGD,D,DEF,DNS,DNS-Credit/FCU,FinalCategory,GA/GB/GC,GOVT,PMF,POL,SCATA,STF,Super A', 12000, 700, 'Yes'),
(17, 18, 60, 'Graduate,Post Graduate,Professional,Other', 'Salaried,Self employed Business,Self Employed Professional', ',A,B,C,CAT A,CAT B,CAT C,CAT D,CAT EDU,CAT GOVT,CAT MED,Category,CATGA,CATGB,CATGC,CATGCX,CATGD,D,DEF,DNS,DNS-Credit/FCU,FinalCategory,GA/GB/GC,GOVT,PMF,POL,SCATA,STF,Super A', 12000, 700, 'Yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basic_filter_rules`
--
ALTER TABLE `basic_filter_rules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `basic_filter_rules`
--
ALTER TABLE `basic_filter_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
