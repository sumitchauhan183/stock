-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2022 at 05:30 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'admin',
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `login_token` varchar(255) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`, `type`, `status`, `login_token`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'sumit.chauhan183@gmail.com', '$2y$10$vBZPefsyp9N1m4j/KunIYeiGqEn8j2C27nABK5Cy016D88v7KDtru', 'admin', 'active', '07dc41dc8550053bfdf12a3d16debde5', '2022-02-11 18:30:00', '2022-02-12 09:18:05', '2022-02-20 05:28:13');

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `payment_id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `transaction_status` varchar(20) NOT NULL,
  `transaction_amount` int(11) NOT NULL,
  `transaction_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`transaction_data`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`payment_id`, `order_id`, `user_id`, `transaction_id`, `transaction_status`, `transaction_amount`, `transaction_data`, `created_at`, `updated_at`) VALUES
(1, '1', '1', 'txn_1KQSN8DXqcYqIgKQFoLT7KG4', 'success', 145, '{\"id\":\"ch_1KQSN7DXqcYqIgKQPGGtX9bk\",\"object\":\"charge\",\"amount\":14500,\"amount_captured\":true,\"balance_transaction\":\"txn_1KQSN8DXqcYqIgKQFoLT7KG4\",\"calculated_statement_descriptor\":\"APPSCIOTO.COM\",\"captured\":true,\"created\":1644221693,\"currency\":\"inr\",\"description\":\"Find Value Stocks\",\"livemode\":false,\"paid\":true,\"payment_method\":\"card_1KQSN5DXqcYqIgKQ19rK1UFr\",\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/acct_1F5stQDXqcYqIgKQ\\/ch_1KQSN7DXqcYqIgKQPGGtX9bk\\/rcpt_L6fif2ZyJ4b0kWz9D2jEgrhmUwHgTJR\",\"status\":\"succeeded\"}', '2022-02-07 02:44:55', '2022-02-07 02:44:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `zipcode` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `otp_added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL,
  `email_verified` varchar(20) NOT NULL,
  `login_token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `country`, `city`, `state`, `zipcode`, `email`, `username`, `password`, `otp`, `otp_added_at`, `status`, `email_verified`, `login_token`, `created_at`, `updated_at`) VALUES
(1, 'sumit', 'singh', 'UAE', 'Farrukhabad', 'UP', '209601', 'sumit.chauhan183@gmail.com', 'sumit183', '$2y$10$wAFs4msj.OLx3qdfpQ0a3OJ3GU3Xz3g1956Ygyk4qDPbHQwVelNS.', '830638', '2022-02-12 00:10:39', 'unpaid', 'YES', 'aba72e13da830784d68461d4371c4a7e', '2022-02-07 02:44:17', '2022-07-01 09:51:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_cards`
--

CREATE TABLE `user_cards` (
  `card_id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `card_expiry` varchar(20) NOT NULL,
  `card_type` varchar(20) NOT NULL,
  `owner_name` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_cards`
--

INSERT INTO `user_cards` (`card_id`, `user_id`, `card_number`, `card_expiry`, `card_type`, `owner_name`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', '4242424242424242', '01/2023', 'VISA', 'Sumit', 'active', '2022-02-07 02:44:55', '2022-02-07 02:44:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_tools`
--

CREATE TABLE `user_tools` (
  `tool_id` int(11) NOT NULL,
  `tool` varchar(50) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `purchase_date` timestamp NULL DEFAULT NULL,
  `expiry_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_tools`
--

INSERT INTO `user_tools` (`tool_id`, `tool`, `user_id`, `purchase_date`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, '3', '1', '2022-02-06 18:30:00', '2023-02-06 18:30:00', '2022-02-07 02:44:27', '2022-02-07 02:44:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_cards`
--
ALTER TABLE `user_cards`
  ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `user_tools`
--
ALTER TABLE `user_tools`
  ADD PRIMARY KEY (`tool_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_cards`
--
ALTER TABLE `user_cards`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_tools`
--
ALTER TABLE `user_tools`
  MODIFY `tool_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
