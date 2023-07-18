-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2023 at 10:51 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee_data`
--

CREATE TABLE `employee_data` (
  `id` int(3) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `supervisor` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_data`
--

INSERT INTO `employee_data` (`id`, `name`, `surname`, `email`, `password`, `supervisor`) VALUES
(19, 'Dejana', 'Ristić', 'dejanaristic13@gmail.com', '$2y$10$.cewusg64QYsAgDYw14MQOpuAAGMSjxL6oCEkQ8GxbSIhHv19kjNS', 1),
(20, 'Dejana', 'Ristić', 'dejanaristic99@gmail.com', '$2y$10$NOQciOQrjhx5Q8L99lNgeOWKsxT5XMsv3d/F6EOmnT5YLonCQ7C2S', 0),
(21, 'test', 'Testic', 'test@gmail.com', '$2y$10$WqLxhQNsDxEhWNzRO/f5Qe1.JiHtvLTaRgXvNnIylEB.7reY1i8L2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `workday_description_data`
--

CREATE TABLE `workday_description_data` (
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `workday_description` text NOT NULL,
  `employee_id` int(3) NOT NULL,
  `d_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee_data`
--
ALTER TABLE `employee_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workday_description_data`
--
ALTER TABLE `workday_description_data`
  ADD PRIMARY KEY (`d_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee_data`
--
ALTER TABLE `employee_data`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `workday_description_data`
--
ALTER TABLE `workday_description_data`
  MODIFY `d_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `workday_description_data`
--
ALTER TABLE `workday_description_data`
  ADD CONSTRAINT `workday_description_data_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee_data` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
