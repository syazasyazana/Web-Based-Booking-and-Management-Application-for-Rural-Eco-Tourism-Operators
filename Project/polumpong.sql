-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 12:52 PM
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
-- Database: `polumpong`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_services`
--

CREATE TABLE `additional_services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_price` decimal(10,2) NOT NULL,
  `availability` enum('available','sold out') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `additional_services`
--

INSERT INTO `additional_services` (`service_id`, `service_name`, `service_price`, `availability`) VALUES
(1, 'Swimming', 20.00, 'available'),
(2, 'Campsite', 50.00, 'available'),
(3, 'Rafting', 30.00, 'available'),
(5, 'BBQ Parties', 40.00, 'available'),
(6, 'Fishing', 15.00, 'sold out'),
(7, 'Service A', 19.99, 'available'),
(8, 'Service B', 29.99, 'sold out'),
(9, 'Service C', 39.99, 'sold out');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'Admin', 'admin@email.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`, `created_at`) VALUES
(1, 'Do you allow pets at the campsite?', 'No, we do not.', '2025-01-24 08:10:52'),
(2, 'Do you have 24/7 customer service?', 'Yes, we do.', '2025-01-24 08:11:13');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `orderDate` date NOT NULL,
  `companyName` varchar(100) DEFAULT NULL,
  `address` text NOT NULL,
  `postalCode` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `branch` enum('Malaysian','Non-Malaysian') NOT NULL,
  `payment_proof` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalPrice` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `name`, `orderDate`, `companyName`, `address`, `postalCode`, `email`, `branch`, `payment_proof`, `created_at`, `totalPrice`) VALUES
(0, 'Test 1', '2025-01-23', 'none', 'gaya street, kota kinabalu, sabah', '0000', 'nvyril86@gmail.com', 'Malaysian', '', '2025-01-23 03:29:33', 0.00),
(0, 'Test 1', '2025-01-23', 'none', 'gaya street, kota kinabalu, sabah', '0000', 'nvyril86@gmail.com', 'Malaysian', '', '2025-01-23 03:31:57', 0.00),
(0, 'Test 1', '2025-01-23', 'none', 'gaya street, kota kinabalu, sabah', '0000', 'nvyril86@gmail.com', 'Malaysian', '', '2025-01-23 03:32:25', 0.00),
(0, 'LEENA A/P SELLAMANY', '2025-01-24', '', '7,JALAN TERAP,TAMAN PALM GROVE,', '41200', 'leena_sellamany_bi22@iluv.ums.edu.my', 'Malaysian', '', '2025-01-24 08:04:32', 180.00),
(0, 'LEENA A/P SELLAMANY', '2025-01-24', '', '7,JALAN TERAP,TAMAN PALM GROVE,', '41200', 'leena_sellamany_bi22@iluv.ums.edu.my', 'Malaysian', '', '2025-01-24 09:50:42', 20.00),
(0, 'LEENA A/P SELLAMANY', '2025-01-24', '', '7,JALAN TERAP,TAMAN PALM GROVE,', '41200', 'leena_sellamany_bi22@iluv.ums.edu.my', 'Malaysian', '', '2025-01-24 10:19:06', 40.00),
(0, 'Shwehtta Parani Kumar', '2025-01-10', 'none', '1 borneo condominium', '84000', 'shwe@email.com', 'Malaysian', '', '2025-01-24 11:46:14', 40.00),
(0, 'Shwehtta Parani Kumar', '2025-01-31', 'none', '1 borneo condominium', '84000', 'shwe@email.com', 'Malaysian', '', '2025-01-24 11:47:42', 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `review_text` text NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `username`, `review_text`, `rating`, `created_at`) VALUES
(1, 5, 'Spider', 'cool', 3, '2025-01-24 08:14:11');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `name`, `price`, `description`, `image`) VALUES
(2, 'Rafting', 99.00, 'JJ', '../images/1.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `phone`, `full_name`, `created_at`, `updated_at`) VALUES
(1, 'shwe@email.com', 'shwe@email.com', '$2y$10$7ujV5izUgihoren/NM2YTO8qwT2HcJ4UXJ6D5L8OBVsPq50eAvDh2', 'shwe@email.com', NULL, '2025-01-13 04:42:23', '2025-01-24 10:37:10'),
(3, 'nama', 'user3@email.com', '$2y$10$A1.h4.0OVKTHacO8aHvGmeTQuUHw76yHkI7xvYO6O674tKqOaU0uu', NULL, NULL, '2025-01-21 07:45:24', '2025-01-21 07:45:24'),
(4, 'cana', 'cana@gmail.com', '$2y$10$w09WAOsWgVABNwS7cDQJ9OtS0/UvxRBP9F4jK2SM98lPLK5.Q/edu', NULL, NULL, '2025-01-24 00:44:32', '2025-01-24 00:44:32'),
(5, 'Spider', 'spider@email.com', '$2y$10$I3.49Zxo5lwoDaf2qY6vw.UgO6eznYYqCFKbeSSYBpPXxZzOyTXuS', 'spider@email.co', NULL, '2025-01-24 08:05:59', '2025-01-24 10:14:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
