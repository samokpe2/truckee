-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2021 at 09:27 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `truck_call`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `postal_address` text DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `time` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `phone_number`, `email`, `password`, `postal_address`, `role`, `time`, `date`) VALUES
(1, 'Mubarak Balogun', '08121236597', 'mubarak@truckee.com', '$2y$10$UIBnPyNMnC8o0AROLP3.bO8n70APukTrPXc.bsI3fde.AFIoSCOJm', '1/3 OLurunfunmi Street,  Ekore Bustop, Oworoshoki, Lagos', 'admin', '11:57 AM', 'Saturday 2nd of October 2021');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `postal_address` text DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `blacklisted` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `name`, `phone_number`, `email`, `password`, `postal_address`, `time`, `date`, `blacklisted`) VALUES
(1, 'Ajayi Fred', '09014698387', 'ajayifred@gmail.com', '$2y$10$6JodLuBg7kMgZZAzEE3SJel1FBIv85SZU8rfpS6oy9kUWf2umzjWu', '1/3 OLurunfunmi Street,  Ekore Bustop, Oworoshoki, Lagos', '11:57 AM', 'Saturday 2nd of October 2021', '0'),
(2, 'Ituen Alfred', '08063354981', 'Ituenalfred@me.com', '$2y$10$J9bT/L.5WymsvCkvCQI7yud2otBfnCum5ba.DTwdfbkmIFEarMS0e', 'No 8 Ondo Street', '12:02 PM', 'Saturday 2nd of October 2021', '0');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_table`
--

CREATE TABLE `ticket_table` (
  `id` int(11) NOT NULL,
  `ticket_id` varchar(100) DEFAULT NULL,
  `truck_driver_id` varchar(255) NOT NULL,
  `client_id` int(100) DEFAULT NULL,
  `container_id` varchar(255) DEFAULT NULL,
  `container_contents` varchar(255) DEFAULT NULL,
  `date_for_entry` varchar(255) NOT NULL,
  `time_entry` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `date_created` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket_table`
--

INSERT INTO `ticket_table` (`id`, `ticket_id`, `truck_driver_id`, `client_id`, `container_id`, `container_contents`, `date_for_entry`, `time_entry`, `status`, `date_created`) VALUES
(1, 'TNO91362', '1', 1, 'NO0001', 'Palmoil, Groundnut Oil, Olive Oil.', 'Monday 4th of October 2021', '10:00 AM', 'Pending', 'Saturday 2nd of October 2021'),
(2, 'TNO85350', '2', 2, 'NO0002', 'Beans,Rice,Palm Oil', 'Monday 4th of October 2021', '12:00 PM', 'Pending', 'Saturday 2nd of October 2021');

-- --------------------------------------------------------

--
-- Table structure for table `truck_driver`
--

CREATE TABLE `truck_driver` (
  `id` int(5) NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `client_id` int(100) DEFAULT NULL,
  `transit_id` varchar(255) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `truck_driver`
--

INSERT INTO `truck_driver` (`id`, `name`, `phone_number`, `email`, `address`, `client_id`, `transit_id`, `date`, `time`) VALUES
(1, 'Damilola Daniel', '08098463359', 'damiloladaniel@yahoo.com', '1/3 OLurunfunmi Street,  Ekore Bustop, Oworoshoki, Lagos', 1, 'DRA29995', 'Saturday 2nd of October 2021', '11:58 AM'),
(2, 'Emmanuel Okoye', '09012235288', 'emmanuelokoye@yahoo.com', '1/3 OLurunfunmi Street,  Ekore Bustop, Oworoshoki, Lagos', 2, 'DRA29885', 'Saturday 2nd of October 2021', '12:04 PM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_table`
--
ALTER TABLE `ticket_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `truck_driver`
--
ALTER TABLE `truck_driver`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ticket_table`
--
ALTER TABLE `ticket_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `truck_driver`
--
ALTER TABLE `truck_driver`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
