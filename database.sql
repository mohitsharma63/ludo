-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2024 at 07:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `backup`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email_id` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  `permissions` text NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email_id`, `password`, `full_name`, `status`, `permissions`, `updated_at`, `created_at`) VALUES
(1, 'admin@codegully.in', 'TG9rUnZ4VWg0Q20rQkFEb0F6QStZQT09', 'Dev Ninja', 1, 'p_mu#p_snsu#p_bu#p_at#p_mkr#p_mwr#p_mcr#p_mc#p_mpmr#p_mhd', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL,
  `activity` text NOT NULL,
  `created_at` int(11) NOT NULL,
  `ipaddress` varchar(250) NOT NULL,
  `device` text NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `ifsc_code` varchar(100) NOT NULL,
  `account_no` varchar(150) NOT NULL,
  `bank` text NOT NULL,
  `upi` varchar(250) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cancel_reqs`
--

CREATE TABLE `cancel_reqs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `reason` varchar(250) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=rejected,1=pending,2=accepted',
  `remarks` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `min_withdraw` decimal(10,2) NOT NULL,
  `withdraw_charge` decimal(5,2) NOT NULL,
  `reward` decimal(5,2) NOT NULL,
  `referral_bonus` decimal(5,2) NOT NULL,
  `whatsapp` text NOT NULL,
  `instagram` text NOT NULL,
  `youtube` text NOT NULL,
  `email` text NOT NULL,
  `otp_api` text NOT NULL,
  `pb_mid` text NOT NULL,
  `pb_vpa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `min_withdraw`, `withdraw_charge`, `reward`, `referral_bonus`, `whatsapp`, `instagram`, `youtube`, `email`, `otp_api`, `pb_mid`, `pb_vpa`) VALUES
(1, 100.00, 1.80, 95.00, 2.00, '917669006847', 'https://www.instagram.com/codegully.in/', 'https://www.youtube.com/devninja', 'workwithdevninja@gmail.com', 'pr6WDbeQLm1LmFKZCh13opnohNsEmyuMeTcNfNMfTbAUMgIzPyDlNs4b7Pjx', 'NiwbQS22357882452767', 'paytmqrvitpxu45a1@paytm');

-- --------------------------------------------------------

--
-- Table structure for table `conflicts`
--

CREATE TABLE `conflicts` (
  `id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `conflicted_user` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '2=resolved,1=pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `game_logo` text NOT NULL,
  `min_amount` int(11) NOT NULL,
  `max_amount` int(11) NOT NULL,
  `game_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id`, `game_logo`, `min_amount`, `max_amount`, `game_name`) VALUES
(1, 'ludo-type-1.png', 5, 50, 'Gareeb Ludo'),
(2, 'ludo-type-1.png', 50, 500, 'Aam Ludo'),
(3, 'ludo-type-1.png', 500, 2500, 'Ameer Ludo'),
(4, 'ludo-type-1.png', 2500, 10000, 'Badshah Ludo');

-- --------------------------------------------------------

--
-- Table structure for table `join_reqs`
--

CREATE TABLE `join_reqs` (
  `id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `joiner_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kyc`
--

CREATE TABLE `kyc` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `aadhar_no` varchar(50) NOT NULL,
  `aadhar_front` text NOT NULL,
  `aadhar_back` text NOT NULL,
  `created_at` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=submitted,\r\n0=rejected,\r\n2=approved',
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `id` int(11) NOT NULL,
  `host_id` int(11) NOT NULL,
  `joiner_id` int(11) NOT NULL,
  `joiner_time` int(11) NOT NULL,
  `room_code` varchar(20) NOT NULL,
  `created_at` int(11) NOT NULL,
  `winner_id` int(11) NOT NULL,
  `looser_id` int(11) NOT NULL,
  `screenshot` text NOT NULL,
  `conflict_screenshot` text NOT NULL,
  `host_result` int(11) NOT NULL COMMENT '1=win,2=lost',
  `joiner_result` int(11) NOT NULL COMMENT '1=won,2=lost',
  `host_result_time` int(11) NOT NULL,
  `joiner_result_time` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `prize` decimal(6,2) NOT NULL,
  `remarks` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=open,2=active,3=canceled,4=finished'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `message` text NOT NULL,
  `seen_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `txns`
--

CREATE TABLE `txns` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `txnid` varchar(100) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `tag` varchar(100) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=created,2=success,0=failed,3=cancelled',
  `data` text NOT NULL,
  `remarks` varchar(250) NOT NULL,
  `match_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `profile` int(10) NOT NULL DEFAULT 16,
  `username` varchar(50) NOT NULL,
  `mobile_no` varchar(10) NOT NULL,
  `referral_code` varchar(100) NOT NULL,
  `refer_by` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  `notifications` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL,
  `device_id` text NOT NULL,
  `online` int(11) NOT NULL,
  `online_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraws`
--

CREATE TABLE `withdraws` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transfer_amount` decimal(6,2) NOT NULL,
  `transfer_fee` decimal(6,2) NOT NULL,
  `total_amount` decimal(6,2) NOT NULL,
  `txnid` varchar(250) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=failed,1=pending,2=success',
  `data` text NOT NULL,
  `screenshot` text NOT NULL,
  `name` text NOT NULL,
  `bank` text NOT NULL,
  `ifsc_code` text NOT NULL,
  `account_no` text NOT NULL,
  `method` varchar(50) NOT NULL DEFAULT 'bank',
  `upi` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `cancel_reqs`
--
ALTER TABLE `cancel_reqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conflicts`
--
ALTER TABLE `conflicts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `join_reqs`
--
ALTER TABLE `join_reqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kyc`
--
ALTER TABLE `kyc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aadhar_no` (`aadhar_no`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txns`
--
ALTER TABLE `txns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `txnid` (`txnid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraws`
--
ALTER TABLE `withdraws`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cancel_reqs`
--
ALTER TABLE `cancel_reqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conflicts`
--
ALTER TABLE `conflicts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `join_reqs`
--
ALTER TABLE `join_reqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kyc`
--
ALTER TABLE `kyc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `txns`
--
ALTER TABLE `txns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraws`
--
ALTER TABLE `withdraws`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
