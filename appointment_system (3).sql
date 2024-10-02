-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2024 at 09:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appointment_system`
--
CREATE DATABASE IF NOT EXISTS `appointment_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `appointment_system`;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `appointment_date` datetime NOT NULL,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `appointment_date`, `doctor_id`) VALUES
(2, 1, '2024-10-23 21:17:00', 2),
(4, 3, '2024-10-14 14:38:00', 2),
(5, 4, '2024-10-21 14:39:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`) VALUES
(1, 'How to Measure Your Blood Pressure at Home', 'Measuring your blood pressure at home can help you keep track of your health...'),
(2, '5 Common Health Tests You Can Do at Home', 'Here are some simple tests you can do at home to monitor your health...'),
(3, 'Understanding Your Cholesterol Levels', 'Cholesterol levels can be measured at home with a simple kit...'),
(4, '5 Essential Health Tests You Can Do at Home', 'Learn about simple health tests you can perform at home to monitor your health.'),
(5, 'How to Track Your Daily Calorie Intake', 'This guide will help you track your daily calorie intake for a healthier lifestyle.'),
(6, 'Benefits of Regular Exercise', 'Exercise is essential for good health. Learn more about its benefits.'),
(7, 'Understanding Your Blood Pressure', 'High blood pressure can cause issues. Monitor your blood pressure regularly.');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `specialization` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialization`) VALUES
(1, 'Dr. Alice Smith', 'Pediatrician'),
(2, 'Dr. Bob Johnson', 'Dermatologist'),
(3, 'Dr. Carol Williams', 'Cardiologist'),
(4, 'Dr. David Brown', 'Orthopedic'),
(5, 'Dr. Emma Davis', 'Neurologist');

-- --------------------------------------------------------

--
-- Table structure for table `medical_details`
--

CREATE TABLE `medical_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `medical_history` text DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `current_medications` text DEFAULT NULL,
  `chronic_conditions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_details`
--

INSERT INTO `medical_details` (`id`, `user_id`, `medical_history`, `allergies`, `current_medications`, `chronic_conditions`) VALUES
(1, 4, 'none', 'peanuts', 'vitamin d', 'd deficiency'),
(2, 1, 'Vitamin D deficiency', 'none', 'vitamin d supplements', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'abcdef@gmail.com', '$2y$10$5weNq64dnxHNCyzdEOeLde5umI5295G.X.skMliOEzWX6l05ZOl7S'),
(2, 'abcdef@gmail.com', '$2y$10$atK5QxS1SaX0891YCVzT4O0EeTwOY3t5J/6OH705jvIxjdpLXLXBa'),
(3, 'gnandikaa08@gmail.com', '$2y$10$E6mGPQ.6QxcLK6oJUFfXaemXLgIxezO2wpaterFBVGOD5P96477z6'),
(4, '1234@abc.com', '$2y$10$qBYmXZckaQRo90Ej9NL6M.Nqo5i647EdCv5ouyDwxUfxLNw4Jz3uW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_details`
--
ALTER TABLE `medical_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `medical_details`
--
ALTER TABLE `medical_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);

--
-- Constraints for table `medical_details`
--
ALTER TABLE `medical_details`
  ADD CONSTRAINT `medical_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
