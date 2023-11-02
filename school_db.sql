-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2023 at 09:23 AM
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
-- Database: `school_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE `tbl_students` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `student_img` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`student_id`, `first_name`, `last_name`, `dob`, `phone_number`, `email_address`, `address`, `student_img`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Alen', 'Shaju', '2000-01-24', '8845697213', 'alenshaju59@gmail.com', 'Kottayam', 'chris-liverani-YBR-AWm1HQ4-unsplash.jpg', 1, '2023-11-02 13:50:23', '2023-11-02 13:50:23'),
(2, 'Alex', 'Reji', '1999-10-31', '9854763210', 'alxrji@gmail.com', 'Idukki', 'lucas-santos-XIIsv6AshJY-unsplash.jpg', 1, '2023-11-02 13:51:03', '2023-11-02 13:51:03'),
(3, 'George', 'Benny', '1998-12-02', '6534878921', 'georgebenny@gmail.com', 'Erattupetta', 'annie-spratt-fbAnIjhrOL4-unsplash.jpg', 1, '2023-11-02 13:51:44', '2023-11-02 13:51:44'),
(4, 'Anton', 'S', '2000-06-03', '9587426589', 'antons@gmail.com', 'Kattappana', 'finn-hackshaw-FQgI8AD-BSg-unsplash.jpg', 1, '2023-11-02 13:52:48', '2023-11-02 13:52:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `username`, `password`, `created_at`) VALUES
(1, 'alanshijo00', '$2y$10$GHrUxpFHoWWupiQ1MWGx1uWT5Xce2xgbRGqGvTBzO0ppRIQkQVOFa', '2023-11-02 13:49:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
