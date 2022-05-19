-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 19, 2022 at 05:35 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tonote`
--
CREATE DATABASE IF NOT EXISTS `tonote` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tonote`;

-- --------------------------------------------------------

--
-- Table structure for table `allowancetype`
--

DROP TABLE IF EXISTS `allowancetype`;
CREATE TABLE `allowancetype` (
  `id` int(11) NOT NULL,
  `name` varchar(36) NOT NULL,
  `description` text NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `deductiontype`
--

DROP TABLE IF EXISTS `deductiontype`;
CREATE TABLE `deductiontype` (
  `id` int(11) NOT NULL,
  `name` varchar(36) NOT NULL,
  `description` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employeedetail`
--

DROP TABLE IF EXISTS `employeedetail`;
CREATE TABLE `employeedetail` (
  `employeeid` varchar(15) NOT NULL,
  `first_name` varchar(36) NOT NULL,
  `last_name` varchar(36) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `age` int(11) NOT NULL,
  `contact_address` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `salary_groupid` int(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employee_allowance`
--

DROP TABLE IF EXISTS `employee_allowance`;
CREATE TABLE `employee_allowance` (
  `id` int(11) NOT NULL,
  `employeeid` varchar(10) NOT NULL,
  `allowancetypeid` int(11) NOT NULL,
  `amount` decimal(19,2) NOT NULL,
  `effective_date` date NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employee_deduction`
--

DROP TABLE IF EXISTS `employee_deduction`;
CREATE TABLE `employee_deduction` (
  `id` int(11) NOT NULL,
  `employeeid` varchar(20) NOT NULL,
  `deductiontypeid` int(11) NOT NULL,
  `amount` decimal(19,2) NOT NULL,
  `effective_date` date NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `leavedetail`
--

DROP TABLE IF EXISTS `leavedetail`;
CREATE TABLE `leavedetail` (
  `leave_id` int(11) NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `leave_startdate` date NOT NULL,
  `leave_enddate` date NOT NULL,
  `reason` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `approveddate` datetime DEFAULT NULL,
  `declined_reason` text DEFAULT NULL,
  `applied_date` datetime NOT NULL DEFAULT current_timestamp(),
  `declined_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

DROP TABLE IF EXISTS `payroll`;
CREATE TABLE `payroll` (
  `id` int(11) NOT NULL,
  `payrollid` varchar(20) NOT NULL,
  `totaldeduction` decimal(19,2) NOT NULL,
  `employeeid` varchar(20) NOT NULL,
  `totalallowance` decimal(19,2) NOT NULL,
  `netpay` decimal(19,2) NOT NULL,
  `effective_date` date NOT NULL,
  `prepareddate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

DROP TABLE IF EXISTS `salary`;
CREATE TABLE `salary` (
  `salary_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `monthly_gross` decimal(19,2) NOT NULL,
  `annual_gross` decimal(19,2) NOT NULL,
  `daily_pay` decimal(19,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(36) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `employeeid` varchar(10) NOT NULL,
  `usertype` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowancetype`
--
ALTER TABLE `allowancetype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductiontype`
--
ALTER TABLE `deductiontype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employeedetail`
--
ALTER TABLE `employeedetail`
  ADD PRIMARY KEY (`employeeid`);

--
-- Indexes for table `employee_allowance`
--
ALTER TABLE `employee_allowance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_deduction`
--
ALTER TABLE `employee_deduction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leavedetail`
--
ALTER TABLE `leavedetail`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`salary_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowancetype`
--
ALTER TABLE `allowancetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deductiontype`
--
ALTER TABLE `deductiontype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_allowance`
--
ALTER TABLE `employee_allowance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_deduction`
--
ALTER TABLE `employee_deduction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leavedetail`
--
ALTER TABLE `leavedetail`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
