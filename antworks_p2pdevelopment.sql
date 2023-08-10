-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2023 at 03:20 PM
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
-- Table structure for table `ant_borrower_rating`
--

CREATE TABLE `ant_borrower_rating` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `experian_score` float NOT NULL,
  `antworksp2p_rating` float NOT NULL,
  `experian_response` varchar(255) DEFAULT NULL,
  `overall_leveraging_ratio` float NOT NULL,
  `leverage_ratio_maximum_available_credit` float NOT NULL,
  `limit_utilization_revolving_credit` float NOT NULL,
  `outstanding_to_limit_term_credit` float NOT NULL,
  `outstanding_to_limit_term_credit_including_past_facilities` float NOT NULL,
  `short_term_leveraging` float NOT NULL,
  `revolving_credit_line_to_total_credit` float NOT NULL,
  `short_term_credit_to_total_credit` float NOT NULL,
  `secured_facilities_to_total_credit` float NOT NULL,
  `fixed_obligation_to_income` float NOT NULL,
  `no_of_active_accounts` float NOT NULL,
  `variety_of_loans_active` float NOT NULL,
  `no_of_credit_enquiry_in_last_3_months` float NOT NULL,
  `no_of_loans_availed_to_credit_enquiry_in_last_12_months` float NOT NULL,
  `history_of_credit_oldest_credit_account` float NOT NULL,
  `limit_breach` float NOT NULL,
  `overdue_to_obligation` float NOT NULL,
  `overdue_to_monthly_income` float NOT NULL,
  `number_of_instances_of_delay_in_past_6_months` float NOT NULL,
  `number_of_instances_of_delay_in_past_12_months` float NOT NULL,
  `number_of_instances_of_delay_in_past_36_months` float NOT NULL,
  `cheque_bouncing` float NOT NULL,
  `credit_summation_to_annual_income` float NOT NULL,
  `digital_banking` float NOT NULL,
  `savings_as_percentage_of_annual_income` float NOT NULL,
  `present_residence` float NOT NULL,
  `city_of_residence` float NOT NULL,
  `highest_qualification` float NOT NULL,
  `age` float NOT NULL,
  `occupation` float NOT NULL,
  `experience` float NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `borrower_error_mail_report`
--

CREATE TABLE `borrower_error_mail_report` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `error_response` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ce_account_type`
--

CREATE TABLE `ce_account_type` (
  `id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `tenor` int(11) NOT NULL,
  `percentage` varchar(3) NOT NULL,
  `is_secured` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ce_shadow_interest`
--

CREATE TABLE `ce_shadow_interest` (
  `id` int(11) NOT NULL,
  `min_credit_score` int(11) NOT NULL,
  `max_credit_score` int(11) NOT NULL,
  `shadow_interest_collection` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `credit_score_query`
--

CREATE TABLE `credit_score_query` (
  `id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `firstName` varchar(200) NOT NULL,
  `surName` varchar(200) NOT NULL,
  `dateOfBirth` varchar(200) NOT NULL,
  `gender` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `flatno` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `pincode` varchar(200) NOT NULL,
  `pan` varchar(200) NOT NULL,
  `mobileNo` varchar(200) NOT NULL,
  `monthly_income` varchar(20) NOT NULL,
  `errorString` text NOT NULL,
  `stageOneId_` varchar(200) NOT NULL,
  `stageTwoId_` varchar(200) NOT NULL,
  `user_file_name` varchar(200) NOT NULL,
  `experian_xml` longtext NOT NULL,
  `user_ip` varchar(200) NOT NULL,
  `ip_address` int(10) NOT NULL,
  `source_of_lead` int(11) NOT NULL,
  `source_of_lead_campaign` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '3->phn_not_pick,4->Language_Barrier,5->duplicate,6->reminder,7->NI',
  `cancel_reason` varchar(20) NOT NULL,
  `reminder_date` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fund_offers`
--

CREATE TABLE `fund_offers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `mobile` text NOT NULL,
  `occupation` int(11) NOT NULL COMMENT '1=>Salaried,\r\n2=>Self Employed Professional,\r\n3=>Self employed Business,\r\n4=>Retired,\r\n5=>Student,\r\n6=>Home Maker,\r\n7=>Others',
  `investment_amount` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lender_loan_preferences`
--

CREATE TABLE `lender_loan_preferences` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `auto_investment` int(11) NOT NULL COMMENT '0->No, 1->Yes',
  `preferences` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lender_offline_payment_details`
--

CREATE TABLE `lender_offline_payment_details` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `transactionId` varchar(100) NOT NULL,
  `transaction_type` varchar(10) NOT NULL,
  `amount` float NOT NULL,
  `approved_or_not` int(11) NOT NULL COMMENT '0->Unapproved, 1->Approved, 2->Mismatch/wrong Information',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offer_bank`
--

CREATE TABLE `offer_bank` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `offer_categories`
--

CREATE TABLE `offer_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_status` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `offer_coupon_code_list`
--

CREATE TABLE `offer_coupon_code_list` (
  `id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `coupon_code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `offer_list`
--

CREATE TABLE `offer_list` (
  `id` int(11) NOT NULL,
  `offer_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `offer_type` varchar(255) NOT NULL,
  `coupon_code_type` varchar(10) NOT NULL,
  `discount_reward_type` varchar(100) NOT NULL COMMENT 'Flat (INR)/ Percentage',
  `min_transaction_amount` float NOT NULL,
  `max_transaction_amount` float NOT NULL,
  `discount_worth` float NOT NULL,
  `max_reward` float NOT NULL,
  `payment_method` varchar(200) NOT NULL,
  `bank` varchar(200) NOT NULL,
  `offer_short_description` varchar(255) NOT NULL,
  `offer_long_description` text NOT NULL,
  `term_condition` text NOT NULL,
  `about_company` varchar(255) NOT NULL,
  `offer_icon_img` varchar(100) NOT NULL,
  `offer_banner_img` varchar(100) NOT NULL,
  `company_icon_img` varchar(255) NOT NULL,
  `offer_url` varchar(255) NOT NULL,
  `offer_priority` int(11) NOT NULL,
  `display_banner` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `offer_payment_method`
--

CREATE TABLE `offer_payment_method` (
  `id` int(11) NOT NULL,
  `payment_method` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_admin_charges`
--

CREATE TABLE `p2p_admin_charges` (
  `id` int(11) NOT NULL,
  `option_name` varchar(200) NOT NULL,
  `option_value` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_admin_email_setting`
--

CREATE TABLE `p2p_admin_email_setting` (
  `id` int(11) NOT NULL,
  `protocol` varchar(20) NOT NULL,
  `smtp_host` varchar(20) NOT NULL,
  `smtp_port` int(11) NOT NULL,
  `smtp_user` varchar(50) NOT NULL,
  `smtp_pass` varchar(20) NOT NULL,
  `mailtype` varchar(20) NOT NULL,
  `charset` varchar(20) NOT NULL,
  `wordwrap` varchar(10) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_admin_history`
--

CREATE TABLE `p2p_admin_history` (
  `id` int(11) NOT NULL,
  `adminId` int(11) NOT NULL,
  `history_data` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_admin_list`
--

CREATE TABLE `p2p_admin_list` (
  `admin_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `password` text NOT NULL,
  `status` int(11) NOT NULL,
  `last_change_password_date` date NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_admin_options`
--

CREATE TABLE `p2p_admin_options` (
  `id` int(11) NOT NULL,
  `option_name` varchar(200) NOT NULL,
  `option_value` text NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '0->Inactive, 1->Active',
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_admin_role`
--

CREATE TABLE `p2p_admin_role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `admin_access` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_admin_sms_setting`
--

CREATE TABLE `p2p_admin_sms_setting` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `hash_api` text NOT NULL,
  `sender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_app_borrower_details`
--

CREATE TABLE `p2p_app_borrower_details` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `imei_no` varchar(50) NOT NULL,
  `mobile_token` varchar(255) NOT NULL,
  `model_no` varchar(255) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_app_lender_details`
--

CREATE TABLE `p2p_app_lender_details` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `imei_no` int(255) NOT NULL,
  `mobile_token` varchar(255) NOT NULL,
  `model_no` varchar(255) NOT NULL,
  `latitude` decimal(10,0) NOT NULL,
  `longitude` decimal(10,0) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_bidding_proposal_details`
--

CREATE TABLE `p2p_bidding_proposal_details` (
  `bid_registration_id` int(11) NOT NULL,
  `p2p_sub_product_id` int(11) NOT NULL,
  `loan_no` varchar(100) NOT NULL,
  `proposal_id` int(11) NOT NULL,
  `borrowers_id` varchar(10) NOT NULL,
  `lenders_id` int(11) NOT NULL,
  `bid_loan_amount` int(11) NOT NULL,
  `loan_amount` int(11) NOT NULL COMMENT 'in %',
  `interest_rate` varchar(10) NOT NULL COMMENT 'in %',
  `accepted_tenor` float NOT NULL,
  `processing_fee` varchar(11) NOT NULL COMMENT 'If Blank then processing fee by system else Gross Amount',
  `proposal_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=bid in progress,2=bid successfully closed,3=bid unsuccessfull, 4=proposal closed, 5->disburse, 6->confirm disbursed',
  `send_to_escrow` int(11) NOT NULL COMMENT '0->Not Send, 1->Send',
  `proposal_added_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_bid_status`
--

CREATE TABLE `p2p_bid_status` (
  `id` int(11) NOT NULL,
  `bid_id` int(11) NOT NULL,
  `bid_status_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrowers_co_applicant`
--

CREATE TABLE `p2p_borrowers_co_applicant` (
  `id` int(11) NOT NULL,
  `borrower_id` int(111) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `dob` varchar(200) NOT NULL,
  `mobile` varchar(200) NOT NULL,
  `relation` varchar(200) NOT NULL,
  `pan` varchar(200) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrowers_details_table`
--

CREATE TABLE `p2p_borrowers_details_table` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `co_applicant_flag` varchar(3) NOT NULL,
  `aadhaar` varchar(12) NOT NULL,
  `passport` varchar(8) NOT NULL,
  `occupation` int(11) NOT NULL,
  `antworks_rating` float NOT NULL,
  `verify_code` varchar(255) NOT NULL,
  `verify_hash` varchar(255) NOT NULL,
  `date_modified` datetime NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrowers_docs_table`
--

CREATE TABLE `p2p_borrowers_docs_table` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `docs_type` varchar(50) NOT NULL,
  `docs_no` varchar(100) NOT NULL,
  `docs_name` varchar(200) NOT NULL,
  `name_as_per_document` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1=active,0=inactive',
  `bank_statement_password` varchar(50) NOT NULL,
  `whatsloan_response` longtext NOT NULL,
  `verify` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrowers_list`
--

CREATE TABLE `p2p_borrowers_list` (
  `id` int(11) NOT NULL,
  `borrower_id` varchar(10) NOT NULL,
  `borrower_escrow_account` varchar(16) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `gender` int(11) NOT NULL DEFAULT 1 COMMENT '1->Male, 2->Female, 3->Others',
  `dob` date NOT NULL,
  `highest_qualification` int(1) NOT NULL,
  `occuption_id` int(11) NOT NULL,
  `marital_status` int(11) NOT NULL DEFAULT 1 COMMENT '1->unmarried, 2->married',
  `pan` varchar(10) NOT NULL,
  `verify_code` varchar(256) NOT NULL,
  `verify_hash` varchar(256) NOT NULL,
  `status` int(11) NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_address_details`
--

CREATE TABLE `p2p_borrower_address_details` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `r_address` text NOT NULL,
  `r_address1` text NOT NULL,
  `r_city` varchar(50) NOT NULL,
  `r_state` varchar(50) NOT NULL,
  `r_pincode` varchar(6) NOT NULL,
  `present_residence` varchar(100) NOT NULL,
  `residence_type` varchar(50) NOT NULL,
  `living_yrs_current_residence` int(11) NOT NULL,
  `permanent_residence_flag` int(11) NOT NULL,
  `p_address` text NOT NULL,
  `p_city` varchar(50) NOT NULL,
  `p_state` varchar(50) NOT NULL,
  `p_pincode` varchar(6) NOT NULL,
  `r_tel_no` varchar(20) NOT NULL,
  `o_address` text NOT NULL,
  `o_city` varchar(50) NOT NULL,
  `o_state` varchar(50) NOT NULL,
  `o_pincode` varchar(6) NOT NULL,
  `o_tel_no` varchar(20) NOT NULL,
  `date_modified` datetime NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_api_response`
--

CREATE TABLE `p2p_borrower_api_response` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `api_name` varchar(100) NOT NULL,
  `response` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_bank_details`
--

CREATE TABLE `p2p_borrower_bank_details` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `ifsc_code` varchar(11) NOT NULL,
  `bank_registered_name` varchar(50) NOT NULL,
  `is_verified` int(11) NOT NULL COMMENT '0->Not Done, 1->Done',
  `bank_account_response` text NOT NULL,
  `accId` varchar(50) NOT NULL COMMENT 'Account Id from Yodli',
  `analysis_json` longtext NOT NULL,
  `account_type` varchar(10) NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_bank_res`
--

CREATE TABLE `p2p_borrower_bank_res` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `fav_id` varchar(50) NOT NULL,
  `razorpay_response_bank_ac` text NOT NULL,
  `razorpay_response_fav` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_bounce_details`
--

CREATE TABLE `p2p_borrower_bounce_details` (
  `id` int(11) NOT NULL,
  `emi_id` int(11) NOT NULL,
  `chrages_type` varchar(50) NOT NULL,
  `charges_amount` float NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_current_step_app`
--

CREATE TABLE `p2p_borrower_current_step_app` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `current_step` text NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_ekyc`
--

CREATE TABLE `p2p_borrower_ekyc` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `aadhar_no` varchar(20) NOT NULL,
  `response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_emi_details`
--

CREATE TABLE `p2p_borrower_emi_details` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL COMMENT 'bid_registration_id',
  `disburse_loan_id` int(11) NOT NULL,
  `borrower_id` varchar(100) NOT NULL,
  `lender_id` int(11) NOT NULL COMMENT 'user_id',
  `emi_date` date NOT NULL,
  `emi_amount` varchar(100) NOT NULL,
  `emi_interest` varchar(100) NOT NULL,
  `emi_principal` varchar(100) NOT NULL,
  `emi_balance` varchar(100) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0->Unpaid,1->.Paid, 2->EMI Bounce Not Chargeable,3->EMI Bounce Chargeable',
  `is_overdue` int(11) NOT NULL COMMENT '0->No,1->YES',
  `emi_sql_date` date NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_experian_response`
--

CREATE TABLE `p2p_borrower_experian_response` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `borrower_request` text NOT NULL,
  `experian_response` text NOT NULL,
  `experian_response_file` varchar(255) NOT NULL,
  `flag` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_homemaker`
--

CREATE TABLE `p2p_borrower_homemaker` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `net_monthly_income` int(11) NOT NULL,
  `current_emis` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_invoice`
--

CREATE TABLE `p2p_borrower_invoice` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `date_of_invoice` date NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `amount` float NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_loan_aggrement`
--

CREATE TABLE `p2p_borrower_loan_aggrement` (
  `id` int(11) NOT NULL,
  `bid_registration_id` int(11) NOT NULL,
  `borrower_id` varchar(100) NOT NULL,
  `doc_name` varchar(255) NOT NULL,
  `accept_or_not` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_notification`
--

CREATE TABLE `p2p_borrower_notification` (
  `id` int(20) NOT NULL,
  `borrower_id` int(11) DEFAULT NULL,
  `notification_type` varchar(10) NOT NULL,
  `instance` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `action_url` varchar(100) NOT NULL,
  `created_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_occuption_details`
--

CREATE TABLE `p2p_borrower_occuption_details` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `occuption_type` int(11) NOT NULL,
  `company_type` varchar(255) NOT NULL COMMENT 'Company Type/Industry Type/ Profession Type/Pursuing course',
  `company_name` varchar(255) NOT NULL,
  `total_experience` int(11) NOT NULL,
  `current_emis` float NOT NULL,
  `net_monthly_income` int(20) NOT NULL,
  `turnover_last_year` int(20) NOT NULL,
  `turnover_last2_year` int(20) NOT NULL,
  `ever_defaulted` varchar(3) NOT NULL,
  `source_of_income` varchar(10) NOT NULL,
  `source_of_income_other` varchar(15) NOT NULL,
  `salary_process` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_others`
--

CREATE TABLE `p2p_borrower_others` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `net_monthly_income` varchar(30) NOT NULL,
  `current_emis` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_otp_signature`
--

CREATE TABLE `p2p_borrower_otp_signature` (
  `id` int(11) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `bid_registration_id` int(11) NOT NULL,
  `otp` int(11) NOT NULL,
  `is_verified` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_password_history`
--

CREATE TABLE `p2p_borrower_password_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `previous_password` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_profile_rating`
--

CREATE TABLE `p2p_borrower_profile_rating` (
  `id` int(10) NOT NULL,
  `borrower_id` varchar(20) NOT NULL,
  `credit_score_rate` float NOT NULL,
  `education_rate` float NOT NULL,
  `age_rate` float NOT NULL,
  `employment_rate` float NOT NULL,
  `experience_rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_rating_parameter`
--

CREATE TABLE `p2p_borrower_rating_parameter` (
  `id` int(11) NOT NULL,
  `parameter_name` varchar(255) NOT NULL,
  `parameter_value` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_rating_tags`
--

CREATE TABLE `p2p_borrower_rating_tags` (
  `id` int(11) NOT NULL,
  `parameter_id` int(11) NOT NULL,
  `parameter_tag_name` varchar(255) NOT NULL,
  `parameter_tag_value` float NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_registration_payment`
--

CREATE TABLE `p2p_borrower_registration_payment` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `razorpay_payment_id` varchar(100) NOT NULL,
  `channel` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_requests`
--

CREATE TABLE `p2p_borrower_requests` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL,
  `request_data` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_retired_details`
--

CREATE TABLE `p2p_borrower_retired_details` (
  `id` int(11) NOT NULL,
  `borrower_id` varchar(10) NOT NULL,
  `company_type` varchar(50) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `net_monthly_income` varchar(50) NOT NULL,
  `current_emis` varchar(50) NOT NULL,
  `defaulted` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_salaried_details`
--

CREATE TABLE `p2p_borrower_salaried_details` (
  `id` int(11) NOT NULL,
  `borrower_id` varchar(10) NOT NULL,
  `employed_company` varchar(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `years_count` varchar(20) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `total_experience` varchar(10) NOT NULL,
  `net_monthly_income` varchar(50) NOT NULL,
  `current_emis` varchar(50) NOT NULL,
  `defaulted` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_self_business_details`
--

CREATE TABLE `p2p_borrower_self_business_details` (
  `id` int(11) NOT NULL,
  `borrower_id` varchar(10) NOT NULL,
  `industry_type` varchar(50) NOT NULL,
  `total_experience` int(11) NOT NULL,
  `net_worth` varchar(50) NOT NULL,
  `turnover_last_year` varchar(50) NOT NULL,
  `turnover_last2_year` varchar(50) NOT NULL,
  `audit_status` varchar(50) NOT NULL,
  `office_phone_no` bigint(20) NOT NULL,
  `office_ownership` varchar(50) NOT NULL,
  `current_emis` varchar(50) NOT NULL,
  `defaulted` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_self_professional_details`
--

CREATE TABLE `p2p_borrower_self_professional_details` (
  `id` int(11) NOT NULL,
  `borrower_id` varchar(10) NOT NULL,
  `professional_type` varchar(50) NOT NULL,
  `total_experience` varchar(50) NOT NULL,
  `net_worth` varchar(50) NOT NULL,
  `turnover_last_year` varchar(50) NOT NULL,
  `turnover_last2_year` varchar(50) NOT NULL,
  `audit_status` varchar(50) NOT NULL,
  `office_phone_no` bigint(20) NOT NULL,
  `office_ownership` varchar(50) NOT NULL,
  `current_emis` varchar(50) NOT NULL,
  `defaulted` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_steps`
--

CREATE TABLE `p2p_borrower_steps` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `step_1` int(11) NOT NULL COMMENT 'registration',
  `step_2` int(11) NOT NULL COMMENT 'Payment',
  `step_3` int(11) NOT NULL COMMENT 'KYC 0->Incomplete Step, 1->Complete, 2-Invalid Response, 3-No Record Found, 4->PAN FOUND, SKIP Documents,5-.API Error',
  `step_5` int(11) NOT NULL COMMENT 'Credit_Bureau',
  `step_6` int(11) NOT NULL COMMENT '0->Not Done, 1->BankAccountBerify, 2->Bank_statement Done, Banking Check,3->skip',
  `step_7` int(11) NOT NULL COMMENT 'Profile Confirmation',
  `step_8` int(11) NOT NULL COMMENT 'Live Listing',
  `modified_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_steps_action_url`
--

CREATE TABLE `p2p_borrower_steps_action_url` (
  `id` int(11) NOT NULL,
  `step` varchar(20) NOT NULL,
  `action_url` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_borrower_student_details`
--

CREATE TABLE `p2p_borrower_student_details` (
  `id` int(11) NOT NULL,
  `borrower_id` varchar(10) NOT NULL,
  `pursuing` varchar(50) NOT NULL,
  `institute_name` varchar(100) NOT NULL,
  `net_monthly_income` varchar(50) NOT NULL,
  `current_emis` varchar(50) NOT NULL,
  `defaulted` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_change_password`
--

CREATE TABLE `p2p_change_password` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hash` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_city_master`
--

CREATE TABLE `p2p_city_master` (
  `id` int(11) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `state_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_ci_sessions`
--

CREATE TABLE `p2p_ci_sessions` (
  `session_id` int(11) NOT NULL,
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `email` varchar(50) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_consumer_loan_details`
--

CREATE TABLE `p2p_consumer_loan_details` (
  `id` int(11) NOT NULL,
  `proposal_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `invoice_value` float NOT NULL,
  `mode_of_purchase` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_disburse_loan_details`
--

CREATE TABLE `p2p_disburse_loan_details` (
  `id` int(11) NOT NULL,
  `bid_registration_id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `approved_loan_amount` float NOT NULL,
  `loan_processing_charges` float NOT NULL,
  `loan_tieup_fee` float NOT NULL,
  `disburse_amount` float NOT NULL,
  `reference` varchar(50) NOT NULL,
  `loan_status` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_email_history_table`
--

CREATE TABLE `p2p_email_history_table` (
  `id` int(11) NOT NULL,
  `receiver_type` varchar(1) NOT NULL COMMENT 'B=Borrower,L=Lender,F=FC',
  `receiver_id` varchar(10) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_email_notification`
--

CREATE TABLE `p2p_email_notification` (
  `id` int(11) NOT NULL,
  `user_type` varchar(10) NOT NULL,
  `communication_type` varchar(20) NOT NULL,
  `instance` varchar(100) NOT NULL,
  `sms_content` text NOT NULL,
  `notification_content` text NOT NULL,
  `email_content` longtext NOT NULL,
  `status` int(11) NOT NULL COMMENT '0->inactive, 1->Active',
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_email_verify_keys`
--

CREATE TABLE `p2p_email_verify_keys` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `email_verify_key` varchar(6) NOT NULL,
  `status` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_emi_payment_details`
--

CREATE TABLE `p2p_emi_payment_details` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL COMMENT 'p2p_disbursed_loan_id',
  `emi_id` int(11) NOT NULL,
  `referece` varchar(100) NOT NULL,
  `emi_payment_amount` float NOT NULL,
  `emi_payment_date` datetime NOT NULL,
  `emi_payment_mode` varchar(50) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `is_verified` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_escrow_ac`
--

CREATE TABLE `p2p_escrow_ac` (
  `id` int(11) NOT NULL,
  `escrow_account` varchar(100) NOT NULL COMMENT 'escrow account for lender and borrower',
  `debit` varchar(20) NOT NULL,
  `credit` varchar(10) NOT NULL,
  `amount` float NOT NULL,
  `balance` float NOT NULL,
  `date_added_escrow` datetime NOT NULL,
  `reference_1` text NOT NULL,
  `reference_2` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Escrow account for lender and borrower';

-- --------------------------------------------------------

--
-- Table structure for table `p2p_escrow_file_name`
--

CREATE TABLE `p2p_escrow_file_name` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_escrow_response`
--

CREATE TABLE `p2p_escrow_response` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `escrow_response` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_failed_logins`
--

CREATE TABLE `p2p_failed_logins` (
  `id` bigint(20) NOT NULL,
  `user_login` varchar(150) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `failed_login_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `login_attempt_ip` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `browser_type` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_account_info`
--

CREATE TABLE `p2p_lender_account_info` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `ifsc_code` varchar(11) NOT NULL,
  `account_type` varchar(20) NOT NULL,
  `is_verified` int(11) NOT NULL,
  `accId` varchar(10) NOT NULL,
  `analysis_json` text NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_address`
--

CREATE TABLE `p2p_lender_address` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `address1` varchar(256) NOT NULL,
  `address2` varchar(256) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(10) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_api_response`
--

CREATE TABLE `p2p_lender_api_response` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `api_name` varchar(100) NOT NULL,
  `response` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_app_screen`
--

CREATE TABLE `p2p_lender_app_screen` (
  `id` int(11) NOT NULL,
  `icon_name` varchar(50) NOT NULL,
  `icon_url` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_bank_res`
--

CREATE TABLE `p2p_lender_bank_res` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `fav_id` varchar(50) NOT NULL,
  `razorpay_response_bank_ac` text NOT NULL,
  `razorpay_response_fav` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_campaign_record`
--

CREATE TABLE `p2p_lender_campaign_record` (
  `id` int(11) NOT NULL,
  `loantype` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `investment_amount` varchar(100) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `occupation` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_club`
--

CREATE TABLE `p2p_lender_club` (
  `id` int(11) NOT NULL,
  `club_name` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_consumer_product_details`
--

CREATE TABLE `p2p_lender_consumer_product_details` (
  `id` int(11) NOT NULL,
  `bid_registration_id` int(11) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `amount` float NOT NULL,
  `date_of_invoice` date NOT NULL,
  `invoice_image` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_details_table`
--

CREATE TABLE `p2p_lender_details_table` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `aadhaar` varchar(12) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `occupation` int(11) NOT NULL,
  `investments` varchar(100) NOT NULL,
  `min_loan_preference` bigint(20) NOT NULL,
  `max_loan_preference` bigint(20) NOT NULL,
  `min_interest_rate` float NOT NULL,
  `max_interest_rate` float NOT NULL,
  `min_tenor` int(11) NOT NULL,
  `max_tenor` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_docs_table`
--

CREATE TABLE `p2p_lender_docs_table` (
  `id` int(11) NOT NULL,
  `lender_id` varchar(10) NOT NULL,
  `docs_type` varchar(50) NOT NULL,
  `docs_no` varchar(100) NOT NULL,
  `docs_name` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1=active,0=inactive',
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_fees_charged`
--

CREATE TABLE `p2p_lender_fees_charged` (
  `fees_charged_id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_ledger_information`
--

CREATE TABLE `p2p_lender_ledger_information` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `reference_1` varchar(255) NOT NULL,
  `reference_2` varchar(255) NOT NULL,
  `debit` float NOT NULL,
  `credit` float NOT NULL,
  `amount` float NOT NULL,
  `balance` float NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_list`
--

CREATE TABLE `p2p_lender_list` (
  `user_id` int(11) NOT NULL,
  `lender_id` varchar(11) NOT NULL,
  `lender_escrow_account_number` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` bigint(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `amount` float NOT NULL,
  `referral_code` varchar(20) DEFAULT NULL,
  `password` varchar(256) NOT NULL,
  `dob` date NOT NULL,
  `pan` varchar(10) NOT NULL,
  `gender` int(11) NOT NULL,
  `qualification` int(11) NOT NULL,
  `occupation` int(11) NOT NULL,
  `source_of_lead` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=nonverified,1=verified 	',
  `verify_code` varchar(256) NOT NULL,
  `verify_hash` varchar(256) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_lock_amount`
--

CREATE TABLE `p2p_lender_lock_amount` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `bid_registration_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `lock_amount` float NOT NULL,
  `is_release` int(11) NOT NULL COMMENT 'That means amount is released or not 0->Locked Amount, 1->Released',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_main_balance`
--

CREATE TABLE `p2p_lender_main_balance` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `account_balance` float NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_nominee`
--

CREATE TABLE `p2p_lender_nominee` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `pan` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_notification`
--

CREATE TABLE `p2p_lender_notification` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `notification_type` varchar(12) NOT NULL,
  `instance` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `action_url` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_occuption_details`
--

CREATE TABLE `p2p_lender_occuption_details` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `company_type` varchar(255) NOT NULL COMMENT 'Company Type/Industry Type/ Profession Type/Pursuing course',
  `company_name` varchar(255) NOT NULL,
  `total_experience` int(11) NOT NULL,
  `net_monthly_income` int(20) NOT NULL,
  `turnover_last_year` int(20) NOT NULL,
  `turnover_last2_year` int(20) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_occ_homemaker`
--

CREATE TABLE `p2p_lender_occ_homemaker` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `net_monthly_income` int(11) NOT NULL,
  `current_emis` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_occ_others`
--

CREATE TABLE `p2p_lender_occ_others` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `net_monthly_income` varchar(30) NOT NULL,
  `current_emis` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_occ_retired_details`
--

CREATE TABLE `p2p_lender_occ_retired_details` (
  `id` int(11) NOT NULL,
  `lender_id` varchar(10) NOT NULL,
  `company_type` varchar(50) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `net_monthly_income` varchar(50) NOT NULL,
  `current_emis` varchar(50) NOT NULL,
  `defaulted` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_occ_salaried_details`
--

CREATE TABLE `p2p_lender_occ_salaried_details` (
  `id` int(11) NOT NULL,
  `lender_id` varchar(10) NOT NULL,
  `employed_company` varchar(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `years_count` varchar(20) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `total_yrs_emp` varchar(10) NOT NULL,
  `net_monthly_income` varchar(50) NOT NULL,
  `current_emis` varchar(50) NOT NULL,
  `defaulted` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_occ_self_business_details`
--

CREATE TABLE `p2p_lender_occ_self_business_details` (
  `id` int(11) NOT NULL,
  `lender_id` varchar(10) NOT NULL,
  `industry_type` varchar(50) NOT NULL,
  `total_experience` int(11) NOT NULL,
  `net_worth` varchar(50) NOT NULL,
  `turnover_last_year` varchar(50) NOT NULL,
  `turnover_last2_year` varchar(50) NOT NULL,
  `audit_status` varchar(50) NOT NULL,
  `office_phone_no` bigint(20) NOT NULL,
  `office_ownership` varchar(50) NOT NULL,
  `current_emis` varchar(50) NOT NULL,
  `defaulted` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_occ_self_professional_details`
--

CREATE TABLE `p2p_lender_occ_self_professional_details` (
  `id` int(11) NOT NULL,
  `lender_id` varchar(10) NOT NULL,
  `professional_type` varchar(50) NOT NULL,
  `total_experience` varchar(50) NOT NULL,
  `net_worth` varchar(50) NOT NULL,
  `turnover_last_year` varchar(50) NOT NULL,
  `turnover_last2_year` varchar(50) NOT NULL,
  `audit_status` varchar(50) NOT NULL,
  `office_phone_no` bigint(20) NOT NULL,
  `office_ownership` varchar(50) NOT NULL,
  `current_emis` varchar(50) NOT NULL,
  `defaulted` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_occ_student_details`
--

CREATE TABLE `p2p_lender_occ_student_details` (
  `id` int(11) NOT NULL,
  `lender_id` varchar(10) NOT NULL,
  `pursuing` varchar(50) NOT NULL,
  `institute_name` varchar(100) NOT NULL,
  `net_monthly_income` varchar(50) NOT NULL,
  `current_emis` varchar(50) NOT NULL,
  `defaulted` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_otp_signature`
--

CREATE TABLE `p2p_lender_otp_signature` (
  `id` int(11) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `bid_registration_id` int(11) NOT NULL,
  `otp` int(11) NOT NULL,
  `is_verified` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_pay_in`
--

CREATE TABLE `p2p_lender_pay_in` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `amount` float NOT NULL,
  `reference` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_pay_out`
--

CREATE TABLE `p2p_lender_pay_out` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `amount` float NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_processing_fee`
--

CREATE TABLE `p2p_lender_processing_fee` (
  `id` int(11) NOT NULL,
  `bid_registration_id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `processing_fee` float NOT NULL,
  `status` int(11) NOT NULL COMMENT '0->unpaid, 1->paid',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_registration_payment`
--

CREATE TABLE `p2p_lender_registration_payment` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `razorpay_payment_id` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_reinvestment`
--

CREATE TABLE `p2p_lender_reinvestment` (
  `reinvestment_id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_requests`
--

CREATE TABLE `p2p_lender_requests` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL,
  `request_data` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_statement_entry`
--

CREATE TABLE `p2p_lender_statement_entry` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `loan_no` varchar(20) NOT NULL,
  `emi_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `reference_1` varchar(255) NOT NULL,
  `reference_2` varchar(255) NOT NULL,
  `debit` float NOT NULL,
  `credit` float NOT NULL,
  `amount` float NOT NULL,
  `balance` float NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_steps`
--

CREATE TABLE `p2p_lender_steps` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `step_1` int(11) NOT NULL COMMENT '0->registration not done, 1->registration done',
  `step_2` int(11) NOT NULL COMMENT '0->payment not done, 1->payment done',
  `step_3` int(11) NOT NULL COMMENT '0->kyc not done, 1->kyc done, 2->Pan vaidate kyc doc skip',
  `step_4` int(11) NOT NULL COMMENT '0->ac not varify, 1->account verify',
  `step_5` int(11) NOT NULL COMMENT '0->lender preferance not activate, 1->activate',
  `modified_date` datetime NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lender_steps_action`
--

CREATE TABLE `p2p_lender_steps_action` (
  `id` int(11) NOT NULL,
  `step` varchar(50) NOT NULL,
  `action_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_lending_campaign_record`
--

CREATE TABLE `p2p_lending_campaign_record` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `transaction_id` varchar(20) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_list_company`
--

CREATE TABLE `p2p_list_company` (
  `id` int(11) NOT NULL,
  `company_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_loan_aggrement`
--

CREATE TABLE `p2p_loan_aggrement` (
  `id` int(11) NOT NULL,
  `bid_registration_id` int(11) NOT NULL,
  `borrower_id` varchar(100) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL COMMENT 'disburse_loan_id',
  `loan_no` varchar(20) NOT NULL,
  `doc_name` varchar(255) NOT NULL,
  `accept_or_not` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_loan_aggrement_signature`
--

CREATE TABLE `p2p_loan_aggrement_signature` (
  `id` int(11) NOT NULL,
  `bid_registration_id` int(11) NOT NULL,
  `borrower_acceptance` int(11) NOT NULL,
  `borrower_signature` int(11) NOT NULL,
  `lender_signature` int(11) NOT NULL,
  `credit_ops_signature` int(11) NOT NULL,
  `credit_ops_manager_signature` int(11) NOT NULL,
  `admin_signature` int(11) NOT NULL,
  `borrower_signature_date` datetime NOT NULL,
  `lender_signature_date` datetime NOT NULL,
  `credit_ops_signature_date` datetime NOT NULL,
  `credit_ops_manager_signature_date` datetime NOT NULL,
  `admin_signature_date` datetime NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_loan_agreement_pdf`
--

CREATE TABLE `p2p_loan_agreement_pdf` (
  `id` int(11) NOT NULL,
  `bid_registration_id` int(11) NOT NULL,
  `agreement_loan_file_name` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_loan_restructuring`
--

CREATE TABLE `p2p_loan_restructuring` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL COMMENT 'Disburse Loan ID',
  `extension_time` int(11) NOT NULL COMMENT 'in months',
  `status` int(11) NOT NULL COMMENT '0->pending, 1->Approved, 2->Decline',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_loan_soft_approvel_amount`
--

CREATE TABLE `p2p_loan_soft_approvel_amount` (
  `id` int(11) NOT NULL,
  `proposal_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_loan_subproduct_type`
--

CREATE TABLE `p2p_loan_subproduct_type` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(3) NOT NULL,
  `sub_procuct_name` varchar(20) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_loan_type`
--

CREATE TABLE `p2p_loan_type` (
  `p2p_product_id` int(11) NOT NULL,
  `loan_name` varchar(200) NOT NULL,
  `loan_purpose` varchar(200) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0->Inactive, 1->Active',
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_login_activity`
--

CREATE TABLE `p2p_login_activity` (
  `id` bigint(20) NOT NULL,
  `user_login` varchar(150) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `login_type` int(11) NOT NULL COMMENT '1->borrower, 2->lender',
  `login_date` datetime DEFAULT NULL,
  `logout_date` datetime DEFAULT NULL,
  `login_ip` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `login_country` varchar(150) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `browser_type` varchar(150) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_logs`
--

CREATE TABLE `p2p_logs` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text DEFAULT NULL,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_occupation_details_table`
--

CREATE TABLE `p2p_occupation_details_table` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_occuption_inputparams`
--

CREATE TABLE `p2p_occuption_inputparams` (
  `id` int(11) NOT NULL,
  `occuption_id` varchar(50) NOT NULL,
  `paramName` varchar(100) NOT NULL,
  `paramType` varchar(100) NOT NULL,
  `dataType` varchar(100) NOT NULL,
  `optional_value` text NOT NULL,
  `place_holder_name` varchar(100) NOT NULL,
  `isOptional` varchar(50) NOT NULL,
  `minLength` int(11) NOT NULL,
  `maxLength` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_otp_details_table`
--

CREATE TABLE `p2p_otp_details_table` (
  `id` bigint(20) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `otp` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_otp_forgot_password_table`
--

CREATE TABLE `p2p_otp_forgot_password_table` (
  `id` int(11) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `otp` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `is_password_update` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_otp_password_table`
--

CREATE TABLE `p2p_otp_password_table` (
  `id` bigint(20) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `otp` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `is_password_update` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_present_residence_type`
--

CREATE TABLE `p2p_present_residence_type` (
  `id` int(11) NOT NULL,
  `residence_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_proposal_details`
--

CREATE TABLE `p2p_proposal_details` (
  `proposal_id` int(11) NOT NULL,
  `PLRN` varchar(10) NOT NULL,
  `borrower_id` varchar(10) NOT NULL,
  `p2p_product_id` int(11) NOT NULL,
  `loan_amount` bigint(20) NOT NULL COMMENT 'in lacs',
  `loan_purpose` bigint(20) NOT NULL,
  `prefered_interest_min` float NOT NULL,
  `prefered_interest_max` float NOT NULL,
  `min_interest_rate` int(11) NOT NULL,
  `max_interest_rate` int(11) NOT NULL,
  `tenor_months` int(11) NOT NULL,
  `loan_description` text NOT NULL,
  `bidding_mode` int(11) NOT NULL DEFAULT 1 COMMENT '0=hidden,1=open',
  `bidding_status` int(11) NOT NULL DEFAULT 0 COMMENT '0=proposal listed,1=bidding open,2=loan approved,3=application closed,4->PartiallyApproved, 5->Application_closebyadmin',
  `date_added` datetime NOT NULL,
  `created_date` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_proposal_shortlist_details`
--

CREATE TABLE `p2p_proposal_shortlist_details` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `proposal_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_proposal_status_name`
--

CREATE TABLE `p2p_proposal_status_name` (
  `id` int(11) NOT NULL,
  `proposal_status_id` varchar(2) NOT NULL,
  `proposal_status_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_proposal_total_views`
--

CREATE TABLE `p2p_proposal_total_views` (
  `id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `proposal_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_qualification`
--

CREATE TABLE `p2p_qualification` (
  `id` int(11) NOT NULL,
  `qualification` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_query_logs`
--

CREATE TABLE `p2p_query_logs` (
  `id` int(11) NOT NULL,
  `query` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_rating_model`
--

CREATE TABLE `p2p_rating_model` (
  `id` int(11) NOT NULL,
  `rating_id` int(11) NOT NULL,
  `rating_key` varchar(255) NOT NULL,
  `rating_name` varchar(255) NOT NULL,
  `preferred_value` varchar(100) NOT NULL,
  `maximum_weightage` varchar(10) NOT NULL,
  `max_rating_value` float NOT NULL,
  `calculation_type` int(11) NOT NULL COMMENT '1->Value, 2->Percentage',
  `status` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_rating_parameter_values`
--

CREATE TABLE `p2p_rating_parameter_values` (
  `id` int(11) NOT NULL,
  `credit_engine_key` int(255) NOT NULL,
  `parameter_key` varchar(255) NOT NULL,
  `min` float NOT NULL,
  `max` float NOT NULL,
  `value` float NOT NULL,
  `last_modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_razorpay_emi_order_details`
--

CREATE TABLE `p2p_razorpay_emi_order_details` (
  `id` int(11) NOT NULL,
  `purpose` varchar(20) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `emi_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `invoice_id` varchar(50) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `razorpay_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_repayment_file_name`
--

CREATE TABLE `p2p_repayment_file_name` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_request_change_address`
--

CREATE TABLE `p2p_request_change_address` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `address_data` text NOT NULL,
  `accepted_or_not` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_resgistration_coupon_code`
--

CREATE TABLE `p2p_resgistration_coupon_code` (
  `id` int(11) NOT NULL,
  `coupon_code` varchar(100) NOT NULL,
  `count_uses` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_residence_type`
--

CREATE TABLE `p2p_residence_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_reypayment_escrow_response`
--

CREATE TABLE `p2p_reypayment_escrow_response` (
  `id` int(11) NOT NULL,
  `loan_number` varchar(100) NOT NULL,
  `emi_no` int(11) NOT NULL,
  `lender_account_no` float NOT NULL,
  `ifsc` varchar(100) NOT NULL,
  `lender_debit` varchar(10) NOT NULL,
  `lender_credit` varchar(10) NOT NULL,
  `amount` float NOT NULL,
  `lender_escrow_ac` varchar(50) NOT NULL,
  `lender_escrow_balance` float NOT NULL,
  `borrower_escrow_ac` int(11) NOT NULL,
  `debit` varchar(20) NOT NULL,
  `credit` varchar(20) NOT NULL,
  `borrower_balance_escrow_ac` float NOT NULL,
  `date_added_escrow` datetime NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_state_experien`
--

CREATE TABLE `p2p_state_experien` (
  `id` int(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `code` varchar(200) NOT NULL,
  `api_state` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_state_master`
--

CREATE TABLE `p2p_state_master` (
  `id` int(11) NOT NULL,
  `state_name` varchar(100) NOT NULL,
  `state_code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_subscribed_emails`
--

CREATE TABLE `p2p_subscribed_emails` (
  `id` int(11) NOT NULL,
  `email` varchar(110) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_upi_response`
--

CREATE TABLE `p2p_upi_response` (
  `id` int(11) NOT NULL,
  `response` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_user_otp_process`
--

CREATE TABLE `p2p_user_otp_process` (
  `id` int(11) NOT NULL,
  `customer_mobile_no` varchar(10) NOT NULL,
  `otp` varchar(4) NOT NULL,
  `verified` enum('0','1') NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_whatsloan_info`
--

CREATE TABLE `p2p_whatsloan_info` (
  `id` int(11) NOT NULL,
  `loginName` varchar(200) NOT NULL,
  `password` varchar(15) NOT NULL,
  `is_register` int(11) NOT NULL COMMENT '0->Not Done, 1->Done',
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_whats_banks`
--

CREATE TABLE `p2p_whats_banks` (
  `id` int(11) NOT NULL,
  `value` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `bank_code` varchar(20) NOT NULL,
  `netbanking` int(11) NOT NULL,
  `debit_card` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_yes_notify_request`
--

CREATE TABLE `p2p_yes_notify_request` (
  `id` int(11) NOT NULL,
  `request` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_yes_transactions`
--

CREATE TABLE `p2p_yes_transactions` (
  `id` int(11) NOT NULL,
  `customer_code` varchar(15) NOT NULL,
  `bene_account_no` varchar(64) NOT NULL,
  `bene_account_ifsc` varchar(20) NOT NULL,
  `bene_full_name` varchar(255) NOT NULL,
  `transfer_type` varchar(4) NOT NULL,
  `transfer_unique_no` varchar(64) NOT NULL,
  `transfer_timestamp` timestamp NULL DEFAULT NULL,
  `transfer_ccy` varchar(5) NOT NULL,
  `transfer_amt` float NOT NULL,
  `rmtr_account_no` varchar(64) NOT NULL,
  `rmtr_account_ifsc` varchar(20) NOT NULL,
  `rmtr_account_type` varchar(10) NOT NULL,
  `rmtr_full_name` varchar(255) NOT NULL,
  `rmtr_address` varchar(255) NOT NULL,
  `rmtr_to_bene_note` varchar(255) NOT NULL,
  `attempt_no` varchar(38) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `credit_acct_no` int(25) NOT NULL,
  `credited_at` datetime DEFAULT NULL,
  `returned_at` datetime DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p2p_yes_validation_request`
--

CREATE TABLE `p2p_yes_validation_request` (
  `id` int(11) NOT NULL,
  `request` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tvs_comment_record`
--

CREATE TABLE `tvs_comment_record` (
  `id` int(11) NOT NULL,
  `tvs_id` int(11) NOT NULL,
  `comment_data` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tvs_user_calling_data`
--

CREATE TABLE `tvs_user_calling_data` (
  `id` int(11) NOT NULL,
  `tvs_id` int(11) NOT NULL,
  `Disposition_Code` varchar(10) NOT NULL,
  `PTP_Dt` varchar(100) NOT NULL,
  `PTP_AMOUNT` varchar(100) NOT NULL,
  `PTP_MODE` varchar(100) NOT NULL,
  `Next_action` varchar(255) NOT NULL,
  `Payment_Mode` varchar(255) NOT NULL,
  `Paid_Amount` varchar(100) NOT NULL,
  `Paid_Dt` date NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tvs_user_records`
--

CREATE TABLE `tvs_user_records` (
  `id` int(11) NOT NULL,
  `SL_NO` int(11) NOT NULL,
  `Agency_Allocation` varchar(255) NOT NULL,
  `Area` varchar(255) NOT NULL,
  `Region` varchar(255) NOT NULL,
  `AGMTNO` varchar(255) NOT NULL,
  `CUSTOMER_NAME` varchar(255) NOT NULL,
  `Cat` varchar(255) NOT NULL,
  `Legal Calling` varchar(255) NOT NULL,
  `Cat_` varchar(255) NOT NULL,
  `Arbitration_Status` varchar(255) NOT NULL,
  `Arbitration_Stage` varchar(255) NOT NULL,
  `LRN` varchar(255) NOT NULL,
  `Mapped` varchar(255) NOT NULL,
  `Product` varchar(255) NOT NULL,
  `Product_Group` varchar(255) NOT NULL,
  `BKT` varchar(255) NOT NULL,
  `Total_OD_Value` varchar(255) NOT NULL,
  `Total_Charges` varchar(255) NOT NULL,
  `Future_Principal` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Mobile_No` varchar(255) NOT NULL,
  `Alternate_nos` varchar(255) NOT NULL,
  `Vehicle_Model` varchar(255) NOT NULL,
  `Reg_No` varchar(255) NOT NULL,
  `DATE_OF_CALLING` varchar(255) NOT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `webhook`
--

CREATE TABLE `webhook` (
  `id` int(11) NOT NULL,
  `response` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `webhook_repayment`
--

CREATE TABLE `webhook_repayment` (
  `id` int(11) NOT NULL,
  `response` longtext NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ant_borrower_rating`
--
ALTER TABLE `ant_borrower_rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrower_id` (`borrower_id`),
  ADD KEY `antworks_rating` (`antworksp2p_rating`),
  ADD KEY `experain_score` (`experian_score`);

--
-- Indexes for table `borrower_error_mail_report`
--
ALTER TABLE `borrower_error_mail_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_account_type`
--
ALTER TABLE `ce_account_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_shadow_interest`
--
ALTER TABLE `ce_shadow_interest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_score_query`
--
ALTER TABLE `credit_score_query`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fund_offers`
--
ALTER TABLE `fund_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lender_loan_preferences`
--
ALTER TABLE `lender_loan_preferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lender_offline_payment_details`
--
ALTER TABLE `lender_offline_payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_bank`
--
ALTER TABLE `offer_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_categories`
--
ALTER TABLE `offer_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_coupon_code_list`
--
ALTER TABLE `offer_coupon_code_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_list`
--
ALTER TABLE `offer_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_payment_method`
--
ALTER TABLE `offer_payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_admin_charges`
--
ALTER TABLE `p2p_admin_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_admin_email_setting`
--
ALTER TABLE `p2p_admin_email_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_admin_history`
--
ALTER TABLE `p2p_admin_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_admin_list`
--
ALTER TABLE `p2p_admin_list`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `p2p_admin_options`
--
ALTER TABLE `p2p_admin_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_admin_role`
--
ALTER TABLE `p2p_admin_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_admin_sms_setting`
--
ALTER TABLE `p2p_admin_sms_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_app_borrower_details`
--
ALTER TABLE `p2p_app_borrower_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_app_lender_details`
--
ALTER TABLE `p2p_app_lender_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_bidding_proposal_details`
--
ALTER TABLE `p2p_bidding_proposal_details`
  ADD PRIMARY KEY (`bid_registration_id`),
  ADD UNIQUE KEY `loan_no` (`loan_no`);

--
-- Indexes for table `p2p_bid_status`
--
ALTER TABLE `p2p_bid_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrowers_co_applicant`
--
ALTER TABLE `p2p_borrowers_co_applicant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrowers_details_table`
--
ALTER TABLE `p2p_borrowers_details_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `borrower_id` (`borrower_id`);

--
-- Indexes for table `p2p_borrowers_docs_table`
--
ALTER TABLE `p2p_borrowers_docs_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrowers_list`
--
ALTER TABLE `p2p_borrowers_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `borrower_id` (`borrower_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `pan` (`pan`);

--
-- Indexes for table `p2p_borrower_address_details`
--
ALTER TABLE `p2p_borrower_address_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `borrower_id` (`borrower_id`);

--
-- Indexes for table `p2p_borrower_api_response`
--
ALTER TABLE `p2p_borrower_api_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_bank_details`
--
ALTER TABLE `p2p_borrower_bank_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_bank_res`
--
ALTER TABLE `p2p_borrower_bank_res`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_bounce_details`
--
ALTER TABLE `p2p_borrower_bounce_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_current_step_app`
--
ALTER TABLE `p2p_borrower_current_step_app`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `BORROWER ID` (`borrower_id`);

--
-- Indexes for table `p2p_borrower_ekyc`
--
ALTER TABLE `p2p_borrower_ekyc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_emi_details`
--
ALTER TABLE `p2p_borrower_emi_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_experian_response`
--
ALTER TABLE `p2p_borrower_experian_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_homemaker`
--
ALTER TABLE `p2p_borrower_homemaker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_invoice`
--
ALTER TABLE `p2p_borrower_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_loan_aggrement`
--
ALTER TABLE `p2p_borrower_loan_aggrement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_notification`
--
ALTER TABLE `p2p_borrower_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_occuption_details`
--
ALTER TABLE `p2p_borrower_occuption_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_others`
--
ALTER TABLE `p2p_borrower_others`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_otp_signature`
--
ALTER TABLE `p2p_borrower_otp_signature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_password_history`
--
ALTER TABLE `p2p_borrower_password_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_profile_rating`
--
ALTER TABLE `p2p_borrower_profile_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_rating_parameter`
--
ALTER TABLE `p2p_borrower_rating_parameter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_rating_tags`
--
ALTER TABLE `p2p_borrower_rating_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_registration_payment`
--
ALTER TABLE `p2p_borrower_registration_payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`razorpay_payment_id`);

--
-- Indexes for table `p2p_borrower_requests`
--
ALTER TABLE `p2p_borrower_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_retired_details`
--
ALTER TABLE `p2p_borrower_retired_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `borrower_id` (`borrower_id`);

--
-- Indexes for table `p2p_borrower_salaried_details`
--
ALTER TABLE `p2p_borrower_salaried_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `borrower_id` (`borrower_id`);

--
-- Indexes for table `p2p_borrower_self_business_details`
--
ALTER TABLE `p2p_borrower_self_business_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `borrower_id` (`borrower_id`);

--
-- Indexes for table `p2p_borrower_self_professional_details`
--
ALTER TABLE `p2p_borrower_self_professional_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `borrower_id` (`borrower_id`);

--
-- Indexes for table `p2p_borrower_steps`
--
ALTER TABLE `p2p_borrower_steps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Borrower ID` (`borrower_id`);

--
-- Indexes for table `p2p_borrower_steps_action_url`
--
ALTER TABLE `p2p_borrower_steps_action_url`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_borrower_student_details`
--
ALTER TABLE `p2p_borrower_student_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `borrower_id` (`borrower_id`);

--
-- Indexes for table `p2p_change_password`
--
ALTER TABLE `p2p_change_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_city_master`
--
ALTER TABLE `p2p_city_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_ci_sessions`
--
ALTER TABLE `p2p_ci_sessions`
  ADD PRIMARY KEY (`id`,`ip_address`),
  ADD UNIQUE KEY `session_id` (`session_id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `p2p_consumer_loan_details`
--
ALTER TABLE `p2p_consumer_loan_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_disburse_loan_details`
--
ALTER TABLE `p2p_disburse_loan_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_email_history_table`
--
ALTER TABLE `p2p_email_history_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_email_notification`
--
ALTER TABLE `p2p_email_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_email_verify_keys`
--
ALTER TABLE `p2p_email_verify_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_emi_payment_details`
--
ALTER TABLE `p2p_emi_payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_escrow_ac`
--
ALTER TABLE `p2p_escrow_ac`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_escrow_file_name`
--
ALTER TABLE `p2p_escrow_file_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_escrow_response`
--
ALTER TABLE `p2p_escrow_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_failed_logins`
--
ALTER TABLE `p2p_failed_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_account_info`
--
ALTER TABLE `p2p_lender_account_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_address`
--
ALTER TABLE `p2p_lender_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_api_response`
--
ALTER TABLE `p2p_lender_api_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_app_screen`
--
ALTER TABLE `p2p_lender_app_screen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_bank_res`
--
ALTER TABLE `p2p_lender_bank_res`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_campaign_record`
--
ALTER TABLE `p2p_lender_campaign_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_club`
--
ALTER TABLE `p2p_lender_club`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_consumer_product_details`
--
ALTER TABLE `p2p_lender_consumer_product_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_no` (`invoice_no`);

--
-- Indexes for table `p2p_lender_details_table`
--
ALTER TABLE `p2p_lender_details_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_docs_table`
--
ALTER TABLE `p2p_lender_docs_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_fees_charged`
--
ALTER TABLE `p2p_lender_fees_charged`
  ADD PRIMARY KEY (`fees_charged_id`);

--
-- Indexes for table `p2p_lender_ledger_information`
--
ALTER TABLE `p2p_lender_ledger_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_list`
--
ALTER TABLE `p2p_lender_list`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `lender_id` (`lender_id`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `pan` (`pan`);

--
-- Indexes for table `p2p_lender_lock_amount`
--
ALTER TABLE `p2p_lender_lock_amount`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bid_registration_id` (`bid_registration_id`);

--
-- Indexes for table `p2p_lender_main_balance`
--
ALTER TABLE `p2p_lender_main_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_nominee`
--
ALTER TABLE `p2p_lender_nominee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_notification`
--
ALTER TABLE `p2p_lender_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_occuption_details`
--
ALTER TABLE `p2p_lender_occuption_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_occ_homemaker`
--
ALTER TABLE `p2p_lender_occ_homemaker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_occ_others`
--
ALTER TABLE `p2p_lender_occ_others`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_occ_retired_details`
--
ALTER TABLE `p2p_lender_occ_retired_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lender_id` (`lender_id`);

--
-- Indexes for table `p2p_lender_occ_salaried_details`
--
ALTER TABLE `p2p_lender_occ_salaried_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lender_id` (`lender_id`);

--
-- Indexes for table `p2p_lender_occ_self_business_details`
--
ALTER TABLE `p2p_lender_occ_self_business_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lender_id` (`lender_id`);

--
-- Indexes for table `p2p_lender_occ_self_professional_details`
--
ALTER TABLE `p2p_lender_occ_self_professional_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lender_id` (`lender_id`);

--
-- Indexes for table `p2p_lender_occ_student_details`
--
ALTER TABLE `p2p_lender_occ_student_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lender_id` (`lender_id`);

--
-- Indexes for table `p2p_lender_otp_signature`
--
ALTER TABLE `p2p_lender_otp_signature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_pay_in`
--
ALTER TABLE `p2p_lender_pay_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_pay_out`
--
ALTER TABLE `p2p_lender_pay_out`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_processing_fee`
--
ALTER TABLE `p2p_lender_processing_fee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bid` (`bid_registration_id`);

--
-- Indexes for table `p2p_lender_registration_payment`
--
ALTER TABLE `p2p_lender_registration_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_reinvestment`
--
ALTER TABLE `p2p_lender_reinvestment`
  ADD PRIMARY KEY (`reinvestment_id`);

--
-- Indexes for table `p2p_lender_requests`
--
ALTER TABLE `p2p_lender_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_statement_entry`
--
ALTER TABLE `p2p_lender_statement_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_steps`
--
ALTER TABLE `p2p_lender_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lender_steps_action`
--
ALTER TABLE `p2p_lender_steps_action`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_lending_campaign_record`
--
ALTER TABLE `p2p_lending_campaign_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_list_company`
--
ALTER TABLE `p2p_list_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_loan_aggrement`
--
ALTER TABLE `p2p_loan_aggrement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_loan_aggrement_signature`
--
ALTER TABLE `p2p_loan_aggrement_signature`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bid_registration_id` (`bid_registration_id`);

--
-- Indexes for table `p2p_loan_agreement_pdf`
--
ALTER TABLE `p2p_loan_agreement_pdf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_loan_restructuring`
--
ALTER TABLE `p2p_loan_restructuring`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_loan_soft_approvel_amount`
--
ALTER TABLE `p2p_loan_soft_approvel_amount`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ProposalId` (`proposal_id`);

--
-- Indexes for table `p2p_loan_subproduct_type`
--
ALTER TABLE `p2p_loan_subproduct_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_loan_type`
--
ALTER TABLE `p2p_loan_type`
  ADD PRIMARY KEY (`p2p_product_id`);

--
-- Indexes for table `p2p_login_activity`
--
ALTER TABLE `p2p_login_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_occupation_details_table`
--
ALTER TABLE `p2p_occupation_details_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_occuption_inputparams`
--
ALTER TABLE `p2p_occuption_inputparams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_otp_details_table`
--
ALTER TABLE `p2p_otp_details_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_otp_forgot_password_table`
--
ALTER TABLE `p2p_otp_forgot_password_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_otp_password_table`
--
ALTER TABLE `p2p_otp_password_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_present_residence_type`
--
ALTER TABLE `p2p_present_residence_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_proposal_details`
--
ALTER TABLE `p2p_proposal_details`
  ADD PRIMARY KEY (`proposal_id`),
  ADD UNIQUE KEY `PLRN` (`PLRN`);

--
-- Indexes for table `p2p_proposal_shortlist_details`
--
ALTER TABLE `p2p_proposal_shortlist_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_proposal_status_name`
--
ALTER TABLE `p2p_proposal_status_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_proposal_total_views`
--
ALTER TABLE `p2p_proposal_total_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_qualification`
--
ALTER TABLE `p2p_qualification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_query_logs`
--
ALTER TABLE `p2p_query_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_rating_model`
--
ALTER TABLE `p2p_rating_model`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_rating_parameter_values`
--
ALTER TABLE `p2p_rating_parameter_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_razorpay_emi_order_details`
--
ALTER TABLE `p2p_razorpay_emi_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_repayment_file_name`
--
ALTER TABLE `p2p_repayment_file_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_request_change_address`
--
ALTER TABLE `p2p_request_change_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_resgistration_coupon_code`
--
ALTER TABLE `p2p_resgistration_coupon_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_residence_type`
--
ALTER TABLE `p2p_residence_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_reypayment_escrow_response`
--
ALTER TABLE `p2p_reypayment_escrow_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_state_experien`
--
ALTER TABLE `p2p_state_experien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_state_master`
--
ALTER TABLE `p2p_state_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_subscribed_emails`
--
ALTER TABLE `p2p_subscribed_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_upi_response`
--
ALTER TABLE `p2p_upi_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_user_otp_process`
--
ALTER TABLE `p2p_user_otp_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_whatsloan_info`
--
ALTER TABLE `p2p_whatsloan_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_whats_banks`
--
ALTER TABLE `p2p_whats_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_yes_notify_request`
--
ALTER TABLE `p2p_yes_notify_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_yes_transactions`
--
ALTER TABLE `p2p_yes_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p2p_yes_validation_request`
--
ALTER TABLE `p2p_yes_validation_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tvs_comment_record`
--
ALTER TABLE `tvs_comment_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tvs_user_calling_data`
--
ALTER TABLE `tvs_user_calling_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tvs_user_records`
--
ALTER TABLE `tvs_user_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webhook`
--
ALTER TABLE `webhook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webhook_repayment`
--
ALTER TABLE `webhook_repayment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ant_borrower_rating`
--
ALTER TABLE `ant_borrower_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `borrower_error_mail_report`
--
ALTER TABLE `borrower_error_mail_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_account_type`
--
ALTER TABLE `ce_account_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_shadow_interest`
--
ALTER TABLE `ce_shadow_interest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `credit_score_query`
--
ALTER TABLE `credit_score_query`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fund_offers`
--
ALTER TABLE `fund_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lender_loan_preferences`
--
ALTER TABLE `lender_loan_preferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lender_offline_payment_details`
--
ALTER TABLE `lender_offline_payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_bank`
--
ALTER TABLE `offer_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_categories`
--
ALTER TABLE `offer_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_coupon_code_list`
--
ALTER TABLE `offer_coupon_code_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_list`
--
ALTER TABLE `offer_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_payment_method`
--
ALTER TABLE `offer_payment_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_admin_charges`
--
ALTER TABLE `p2p_admin_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_admin_email_setting`
--
ALTER TABLE `p2p_admin_email_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_admin_history`
--
ALTER TABLE `p2p_admin_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_admin_list`
--
ALTER TABLE `p2p_admin_list`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_admin_options`
--
ALTER TABLE `p2p_admin_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_admin_role`
--
ALTER TABLE `p2p_admin_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_admin_sms_setting`
--
ALTER TABLE `p2p_admin_sms_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_app_borrower_details`
--
ALTER TABLE `p2p_app_borrower_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_app_lender_details`
--
ALTER TABLE `p2p_app_lender_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_bidding_proposal_details`
--
ALTER TABLE `p2p_bidding_proposal_details`
  MODIFY `bid_registration_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_bid_status`
--
ALTER TABLE `p2p_bid_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrowers_co_applicant`
--
ALTER TABLE `p2p_borrowers_co_applicant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrowers_details_table`
--
ALTER TABLE `p2p_borrowers_details_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrowers_docs_table`
--
ALTER TABLE `p2p_borrowers_docs_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrowers_list`
--
ALTER TABLE `p2p_borrowers_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_address_details`
--
ALTER TABLE `p2p_borrower_address_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_api_response`
--
ALTER TABLE `p2p_borrower_api_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_bank_details`
--
ALTER TABLE `p2p_borrower_bank_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_bank_res`
--
ALTER TABLE `p2p_borrower_bank_res`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_bounce_details`
--
ALTER TABLE `p2p_borrower_bounce_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_current_step_app`
--
ALTER TABLE `p2p_borrower_current_step_app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_ekyc`
--
ALTER TABLE `p2p_borrower_ekyc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_emi_details`
--
ALTER TABLE `p2p_borrower_emi_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_experian_response`
--
ALTER TABLE `p2p_borrower_experian_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_homemaker`
--
ALTER TABLE `p2p_borrower_homemaker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_invoice`
--
ALTER TABLE `p2p_borrower_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_loan_aggrement`
--
ALTER TABLE `p2p_borrower_loan_aggrement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_notification`
--
ALTER TABLE `p2p_borrower_notification`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_occuption_details`
--
ALTER TABLE `p2p_borrower_occuption_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_others`
--
ALTER TABLE `p2p_borrower_others`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_otp_signature`
--
ALTER TABLE `p2p_borrower_otp_signature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_password_history`
--
ALTER TABLE `p2p_borrower_password_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_profile_rating`
--
ALTER TABLE `p2p_borrower_profile_rating`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_rating_parameter`
--
ALTER TABLE `p2p_borrower_rating_parameter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_rating_tags`
--
ALTER TABLE `p2p_borrower_rating_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_registration_payment`
--
ALTER TABLE `p2p_borrower_registration_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_requests`
--
ALTER TABLE `p2p_borrower_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_retired_details`
--
ALTER TABLE `p2p_borrower_retired_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_salaried_details`
--
ALTER TABLE `p2p_borrower_salaried_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_self_business_details`
--
ALTER TABLE `p2p_borrower_self_business_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_self_professional_details`
--
ALTER TABLE `p2p_borrower_self_professional_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_steps`
--
ALTER TABLE `p2p_borrower_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_steps_action_url`
--
ALTER TABLE `p2p_borrower_steps_action_url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_borrower_student_details`
--
ALTER TABLE `p2p_borrower_student_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_change_password`
--
ALTER TABLE `p2p_change_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_city_master`
--
ALTER TABLE `p2p_city_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_ci_sessions`
--
ALTER TABLE `p2p_ci_sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_consumer_loan_details`
--
ALTER TABLE `p2p_consumer_loan_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_disburse_loan_details`
--
ALTER TABLE `p2p_disburse_loan_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_email_history_table`
--
ALTER TABLE `p2p_email_history_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_email_notification`
--
ALTER TABLE `p2p_email_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_email_verify_keys`
--
ALTER TABLE `p2p_email_verify_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_emi_payment_details`
--
ALTER TABLE `p2p_emi_payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_escrow_ac`
--
ALTER TABLE `p2p_escrow_ac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_escrow_file_name`
--
ALTER TABLE `p2p_escrow_file_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_escrow_response`
--
ALTER TABLE `p2p_escrow_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_failed_logins`
--
ALTER TABLE `p2p_failed_logins`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_account_info`
--
ALTER TABLE `p2p_lender_account_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_address`
--
ALTER TABLE `p2p_lender_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_api_response`
--
ALTER TABLE `p2p_lender_api_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_app_screen`
--
ALTER TABLE `p2p_lender_app_screen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_bank_res`
--
ALTER TABLE `p2p_lender_bank_res`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_campaign_record`
--
ALTER TABLE `p2p_lender_campaign_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_club`
--
ALTER TABLE `p2p_lender_club`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_consumer_product_details`
--
ALTER TABLE `p2p_lender_consumer_product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_details_table`
--
ALTER TABLE `p2p_lender_details_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_docs_table`
--
ALTER TABLE `p2p_lender_docs_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_fees_charged`
--
ALTER TABLE `p2p_lender_fees_charged`
  MODIFY `fees_charged_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_ledger_information`
--
ALTER TABLE `p2p_lender_ledger_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_list`
--
ALTER TABLE `p2p_lender_list`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_lock_amount`
--
ALTER TABLE `p2p_lender_lock_amount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_main_balance`
--
ALTER TABLE `p2p_lender_main_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_nominee`
--
ALTER TABLE `p2p_lender_nominee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_notification`
--
ALTER TABLE `p2p_lender_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_occuption_details`
--
ALTER TABLE `p2p_lender_occuption_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_occ_homemaker`
--
ALTER TABLE `p2p_lender_occ_homemaker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_occ_others`
--
ALTER TABLE `p2p_lender_occ_others`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_occ_retired_details`
--
ALTER TABLE `p2p_lender_occ_retired_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_occ_salaried_details`
--
ALTER TABLE `p2p_lender_occ_salaried_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_occ_self_business_details`
--
ALTER TABLE `p2p_lender_occ_self_business_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_occ_self_professional_details`
--
ALTER TABLE `p2p_lender_occ_self_professional_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_occ_student_details`
--
ALTER TABLE `p2p_lender_occ_student_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_otp_signature`
--
ALTER TABLE `p2p_lender_otp_signature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_pay_in`
--
ALTER TABLE `p2p_lender_pay_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_pay_out`
--
ALTER TABLE `p2p_lender_pay_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_processing_fee`
--
ALTER TABLE `p2p_lender_processing_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_registration_payment`
--
ALTER TABLE `p2p_lender_registration_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_reinvestment`
--
ALTER TABLE `p2p_lender_reinvestment`
  MODIFY `reinvestment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_requests`
--
ALTER TABLE `p2p_lender_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_statement_entry`
--
ALTER TABLE `p2p_lender_statement_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_steps`
--
ALTER TABLE `p2p_lender_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lender_steps_action`
--
ALTER TABLE `p2p_lender_steps_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_lending_campaign_record`
--
ALTER TABLE `p2p_lending_campaign_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_list_company`
--
ALTER TABLE `p2p_list_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_loan_aggrement`
--
ALTER TABLE `p2p_loan_aggrement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_loan_aggrement_signature`
--
ALTER TABLE `p2p_loan_aggrement_signature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_loan_agreement_pdf`
--
ALTER TABLE `p2p_loan_agreement_pdf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_loan_restructuring`
--
ALTER TABLE `p2p_loan_restructuring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_loan_soft_approvel_amount`
--
ALTER TABLE `p2p_loan_soft_approvel_amount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_loan_subproduct_type`
--
ALTER TABLE `p2p_loan_subproduct_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_loan_type`
--
ALTER TABLE `p2p_loan_type`
  MODIFY `p2p_product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_login_activity`
--
ALTER TABLE `p2p_login_activity`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_occupation_details_table`
--
ALTER TABLE `p2p_occupation_details_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_occuption_inputparams`
--
ALTER TABLE `p2p_occuption_inputparams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_otp_details_table`
--
ALTER TABLE `p2p_otp_details_table`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_otp_forgot_password_table`
--
ALTER TABLE `p2p_otp_forgot_password_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_otp_password_table`
--
ALTER TABLE `p2p_otp_password_table`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_present_residence_type`
--
ALTER TABLE `p2p_present_residence_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_proposal_details`
--
ALTER TABLE `p2p_proposal_details`
  MODIFY `proposal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_proposal_shortlist_details`
--
ALTER TABLE `p2p_proposal_shortlist_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_proposal_status_name`
--
ALTER TABLE `p2p_proposal_status_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_proposal_total_views`
--
ALTER TABLE `p2p_proposal_total_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_qualification`
--
ALTER TABLE `p2p_qualification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_query_logs`
--
ALTER TABLE `p2p_query_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_rating_model`
--
ALTER TABLE `p2p_rating_model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_rating_parameter_values`
--
ALTER TABLE `p2p_rating_parameter_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_razorpay_emi_order_details`
--
ALTER TABLE `p2p_razorpay_emi_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_repayment_file_name`
--
ALTER TABLE `p2p_repayment_file_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_request_change_address`
--
ALTER TABLE `p2p_request_change_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_resgistration_coupon_code`
--
ALTER TABLE `p2p_resgistration_coupon_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_residence_type`
--
ALTER TABLE `p2p_residence_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_reypayment_escrow_response`
--
ALTER TABLE `p2p_reypayment_escrow_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_state_experien`
--
ALTER TABLE `p2p_state_experien`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_state_master`
--
ALTER TABLE `p2p_state_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_subscribed_emails`
--
ALTER TABLE `p2p_subscribed_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_upi_response`
--
ALTER TABLE `p2p_upi_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_user_otp_process`
--
ALTER TABLE `p2p_user_otp_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_whatsloan_info`
--
ALTER TABLE `p2p_whatsloan_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_whats_banks`
--
ALTER TABLE `p2p_whats_banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_yes_notify_request`
--
ALTER TABLE `p2p_yes_notify_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_yes_transactions`
--
ALTER TABLE `p2p_yes_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p2p_yes_validation_request`
--
ALTER TABLE `p2p_yes_validation_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tvs_comment_record`
--
ALTER TABLE `tvs_comment_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tvs_user_calling_data`
--
ALTER TABLE `tvs_user_calling_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tvs_user_records`
--
ALTER TABLE `tvs_user_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webhook`
--
ALTER TABLE `webhook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webhook_repayment`
--
ALTER TABLE `webhook_repayment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
