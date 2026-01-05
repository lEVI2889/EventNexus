-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 04, 2026 at 05:55 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Event_Management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`) VALUES
(5),
(10),
(13),
(18);

-- --------------------------------------------------------

--
-- Table structure for table `available_at`
--

CREATE TABLE `available_at` (
  `event_id` int(11) NOT NULL,
  `stall_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `available_at`
--

INSERT INTO `available_at` (`event_id`, `stall_id`) VALUES
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(5, 5),
(5, 8),
(9, 6),
(11, 7);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`booking_id`, `user_id`, `ticket_id`, `event_id`) VALUES
(2, 9, 2, 4),
(3, 14, 3, 4),
(4, 14, 4, 4),
(5, 14, 5, 4),
(6, 9, 6, 4),
(7, 9, 7, 5),
(9, 9, 9, 4);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`user_id`) VALUES
(8),
(9),
(14);

-- --------------------------------------------------------

--
-- Table structure for table `eventshow`
--

CREATE TABLE `eventshow` (
  `event_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `status` enum('Pending','Approved','Cancelled') DEFAULT 'Pending',
  `description` text DEFAULT NULL,
  `event_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `host_id` int(11) NOT NULL,
  `venue_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eventshow`
--

INSERT INTO `eventshow` (`event_id`, `title`, `status`, `description`, `event_date`, `start_time`, `end_time`, `host_id`, `venue_id`) VALUES
(4, 'Atif Aslaam Concert', 'Approved', 'Atif Aslaam ashbe', '2025-12-24', '06:51:00', '07:51:00', 12, 4),
(5, 'WrestleMania', 'Approved', 'wow', '2026-01-01', '12:00:00', '17:30:00', 15, 4),
(6, 'party', 'Approved', 'dance', '2026-01-22', '03:03:00', '15:03:00', 15, 8),
(9, 'hello', 'Approved', 'hello', '2026-01-04', '10:00:00', '13:00:00', 15, 9),
(10, 'how', 'Cancelled', 'why', '2026-01-04', '10:01:00', '12:04:00', 15, 9),
(11, 'RS65', 'Approved', 'gala', '2026-01-01', '20:36:00', '20:40:00', 15, 8),
(19, 'Final', 'Approved', '...', '2026-01-31', '01:21:00', '04:21:00', 6, 4),
(20, 'Final2', 'Approved', '..', '2026-01-21', '05:35:00', '08:32:00', 6, 8);

-- --------------------------------------------------------

--
-- Table structure for table `host`
--

CREATE TABLE `host` (
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `host`
--

INSERT INTO `host` (`user_id`) VALUES
(6),
(12),
(15);

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`user_id`) VALUES
(7),
(11),
(16);

-- --------------------------------------------------------

--
-- Table structure for table `merch_stall`
--

CREATE TABLE `merch_stall` (
  `stall_id` int(11) NOT NULL,
  `stall_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merch_stall`
--

INSERT INTO `merch_stall` (`stall_id`, `stall_name`, `description`, `merchant_id`) VALUES
(1, 'burger', 'buns, cheese, meat, lettuce, sauce.', 16),
(2, 'pasta', 'khabo', 16),
(3, 'tshirt', 'pore', 16),
(4, 'boi', 'pore', 16),
(5, 'khabar', 'khay', 16),
(6, 'khabar', 'khao', 16),
(7, 'khabar', 'khao', 16),
(8, 'Stall120', '...', 7),
(9, 'hehehe', 'hehehe', 7);

-- --------------------------------------------------------

--
-- Table structure for table `PayToSecure`
--

CREATE TABLE `PayToSecure` (
  `payment_id` int(11) NOT NULL,
  `host_id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `payment_status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending',
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `PayToSecure`
--

INSERT INTO `PayToSecure` (`payment_id`, `host_id`, `venue_id`, `event_id`, `payment_status`, `amount`, `payment_date`) VALUES
(4, 6, 4, 19, 'Confirmed', 100.00, '2026-01-03 20:22:24'),
(5, 6, 8, 20, 'Confirmed', 100.00, '2026-01-03 20:33:18');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `event_id` int(11) NOT NULL,
  `booking_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_id`, `price`, `event_id`, `booking_time`) VALUES
(2, 50.00, 4, '2025-12-23 19:52:52'),
(3, 50.00, 4, '2025-12-25 15:14:31'),
(4, 50.00, 4, '2025-12-26 14:40:08'),
(5, 50.00, 4, '2025-12-31 16:18:11'),
(6, 50.00, 4, '2026-01-03 10:58:04'),
(7, 50.00, 5, '2026-01-03 11:00:41'),
(9, 50.00, 4, '2026-01-03 17:08:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `passcode` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `type` enum('Admin','Host','Customer','Merchant') NOT NULL,
  `is_verified` enum('verified','blocked') DEFAULT 'verified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `passcode`, `full_name`, `email`, `type`, `is_verified`) VALUES
(5, 'system_admin', 'admin123', 'Super Admin', 'admin@event.com', 'Admin', 'verified'),
(6, 'concert_king', 'hostpass', 'Royal Events Ltd', 'host@events.com', 'Host', 'verified'),
(7, 'food_vendor_01', 'merch789', 'Gourmet Catering', 'vendor@food.com', 'Merchant', 'blocked'),
(8, 'john_doe', 'customer321', 'John Doe', 'john.doe@email.com', 'Customer', 'verified'),
(9, 'Levi', '1234', 'Levi Ackerman', 'leviackerman@gmail.com', 'Customer', 'verified'),
(10, 'ADmiN01', 'ADmiN01', 'Admin Uddin', 'adminUddin@gmail.com', 'Admin', 'verified'),
(11, 'MerChant01', 'MerChant01', 'Mir Merchant', 'mirmerchant@gmail.com', 'Merchant', 'verified'),
(12, 'Host011', 'Host011', 'Host Ibn Host', 'hostibn@gmail.com', 'Host', 'verified'),
(13, 'oi', '1234', 'oishowrjyo', 'oishowrjyo.das.gupta@g.bracu.ac.bd', 'Admin', 'verified'),
(14, 'oiCust', '1234', 'oishowrjyo', 'oishowrjyo.das.gupta@g.bracu.ac.bd', 'Customer', 'verified'),
(15, 'oiHost', '1234', 'oishowrjyo', 'oishowrjyo.das.gupta@g.bracu.ac.bd', 'Host', 'verified'),
(16, 'oiMer', '1234', 'oishowrjyo', 'oishowrjyo.das.gupta@g.bracu.ac.bd', 'Merchant', 'verified'),
(18, 'admin00', 'admin00', 'admin', 'admin00@gmail.com', 'Admin', 'verified');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `sync_user_roles` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.type = 'Customer' THEN
        INSERT INTO Customer (user_id) VALUES (NEW.user_id);
    ELSEIF NEW.type = 'Host' THEN
        INSERT INTO Host (user_id) VALUES (NEW.user_id);
    ELSEIF NEW.type = 'Admin' THEN
        INSERT INTO Admin (user_id) VALUES (NEW.user_id);
    ELSEIF NEW.type = 'Merchant' THEN
        INSERT INTO Merchant (user_id) VALUES (NEW.user_id);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE `venue` (
  `venue_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`venue_id`, `name`, `address`, `admin_id`) VALUES
(4, 'BRAC University', 'Merul Badda', NULL),
(8, 'tarc', 'savar', NULL),
(9, 'UB2', 'mohakhali', NULL),
(10, 'hall', 'birulia', NULL),
(11, 'Hatirjheel Ampitheatre', 'Rampura, Dhaka', NULL),
(13, '..', '..', NULL),
(15, '.', '.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `verifies`
--

CREATE TABLE `verifies` (
  `admin_id` int(11) NOT NULL,
  `host_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `verification_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `available_at`
--
ALTER TABLE `available_at`
  ADD PRIMARY KEY (`event_id`,`stall_id`),
  ADD KEY `stall_id` (`stall_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `eventshow`
--
ALTER TABLE `eventshow`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `host_id` (`host_id`),
  ADD KEY `fk_event_venue` (`venue_id`);

--
-- Indexes for table `host`
--
ALTER TABLE `host`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `merch_stall`
--
ALTER TABLE `merch_stall`
  ADD PRIMARY KEY (`stall_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `PayToSecure`
--
ALTER TABLE `PayToSecure`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `host_id` (`host_id`),
  ADD KEY `venue_id` (`venue_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`venue_id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `venue_id` (`venue_id`) USING BTREE,
  ADD KEY `fk_admin_venue` (`admin_id`);

--
-- Indexes for table `verifies`
--
ALTER TABLE `verifies`
  ADD PRIMARY KEY (`admin_id`,`host_id`,`merchant_id`),
  ADD KEY `host_id` (`host_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `eventshow`
--
ALTER TABLE `eventshow`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `merch_stall`
--
ALTER TABLE `merch_stall`
  MODIFY `stall_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `PayToSecure`
--
ALTER TABLE `PayToSecure`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
  MODIFY `venue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `available_at`
--
ALTER TABLE `available_at`
  ADD CONSTRAINT `available_at_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `eventshow` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `available_at_ibfk_2` FOREIGN KEY (`stall_id`) REFERENCES `merch_stall` (`stall_id`) ON DELETE CASCADE;

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customer` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `eventshow` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_ibfk_3` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`ticket_id`) ON DELETE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `eventshow`
--
ALTER TABLE `eventshow`
  ADD CONSTRAINT `eventshow_ibfk_1` FOREIGN KEY (`host_id`) REFERENCES `host` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_event_venue` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`venue_id`);

--
-- Constraints for table `host`
--
ALTER TABLE `host`
  ADD CONSTRAINT `host_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `merchant`
--
ALTER TABLE `merchant`
  ADD CONSTRAINT `merchant_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `merch_stall`
--
ALTER TABLE `merch_stall`
  ADD CONSTRAINT `merch_stall_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `PayToSecure`
--
ALTER TABLE `PayToSecure`
  ADD CONSTRAINT `paytosecure_ibfk_1` FOREIGN KEY (`host_id`) REFERENCES `Host` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `paytosecure_ibfk_2` FOREIGN KEY (`venue_id`) REFERENCES `Venue` (`venue_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `paytosecure_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `EventShow` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `eventshow` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `venue`
--
ALTER TABLE `venue`
  ADD CONSTRAINT `fk_admin_venue` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `verifies`
--
ALTER TABLE `verifies`
  ADD CONSTRAINT `verifies_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `verifies_ibfk_2` FOREIGN KEY (`host_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `verifies_ibfk_3` FOREIGN KEY (`merchant_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
