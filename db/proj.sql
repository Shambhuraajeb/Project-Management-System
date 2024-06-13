-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2024 at 09:12 AM
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
-- Database: `proj`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `notes` text NOT NULL,
  `created at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id`, `title`, `description`, `notes`, `created at`) VALUES
(10, 'finance overview', 'Detailed financial report', 'abc', '2024-05-23 12:52:39'),
(11, 'Project Updates', 'Updates on current projects', 'note', '2024-05-23 21:53:55');

-- --------------------------------------------------------

--
-- Table structure for table `agenda_topic`
--

CREATE TABLE `agenda_topic` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agenda_topic`
--

INSERT INTO `agenda_topic` (`id`, `title`, `description`) VALUES
(7, 'Revenue Analysis', 'Analysis of quarterly revenue'),
(8, 'Expense Review', 'Analysis of quarterly expenses');

-- --------------------------------------------------------

--
-- Table structure for table `agenda_topic_key`
--

CREATE TABLE `agenda_topic_key` (
  `id` int(11) NOT NULL,
  `agenda_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agenda_topic_key`
--

INSERT INTO `agenda_topic_key` (`id`, `agenda_id`, `topic_id`) VALUES
(7, 10, 7),
(8, 10, 8),
(9, 11, 7),
(10, 11, 8);

-- --------------------------------------------------------

--
-- Table structure for table `allocation`
--

CREATE TABLE `allocation` (
  `alloc_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time(6) DEFAULT NULL,
  `end_time` time(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allocation`
--

INSERT INTO `allocation` (`alloc_id`, `res_id`, `task_id`, `emp_id`, `date`, `start_time`, `end_time`) VALUES
(3, 6, 66, 270411, '2024-05-01', '11:47:00.000000', '00:46:00.000000');

--
-- Triggers `allocation`
--
DELIMITER $$
CREATE TRIGGER `after_allocation_insert` AFTER INSERT ON `allocation` FOR EACH ROW BEGIN
    UPDATE resources
    SET availability = 'occupied'
    WHERE res_id = NEW.res_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `doc_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `location` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL,
  `proj_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`doc_id`, `name`, `location`, `datetime`, `proj_id`, `emp_id`) VALUES
(1, 'SRS', '/network/shared/MyDocuments/SRS.pdf', '2024-05-08 11:38:19', 6, 270413);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `resume` longblob DEFAULT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `name`, `role`, `email`, `resume`, `gender`) VALUES
(270400, 'shambhuraje', 'admin', 'shambhuraje@gmail.com', NULL, 'male'),
(270410, 'Jivraj', 'manager', 'jivraj@gmail.com', '', 'male'),
(270411, 'Anish', 'manager', 'anish@gmail.com', '', 'male'),
(270413, 'Jayesh', 'employee', 'jayesh@gmail.com', '', 'male'),
(270414, 'Vikas', 'employee', 'vikas@gmail.com', '', 'male'),
(270415, 'Rohan', 'employee', 'rohan@gmail.com', '', 'male'),
(270416, 'Sumit', 'employee', 'sumit@gmail.com', '', 'male'),
(270417, 'Lakhan', 'employee', 'lakhan@gmail.com', '', 'male'),
(270418, 'Riya ', 'employee', 'riya@gmail.com', '', 'female');

-- --------------------------------------------------------

--
-- Table structure for table `emp_skills`
--

CREATE TABLE `emp_skills` (
  `id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `priority` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emp_skills`
--

INSERT INTO `emp_skills` (`id`, `skill_id`, `emp_id`, `priority`) VALUES
(1, 5, 270413, 8),
(2, 3, 270415, 10),
(3, 4, 270416, 9),
(4, 1, 270414, 8),
(5, 1, 270413, 9),
(6, 2, 270415, 7),
(7, 5, 270416, 10),
(8, 3, 270414, 8),
(9, 4, 270413, 10),
(10, 5, 270414, 9),
(11, 7, 270411, 9),
(12, 8, 270413, 9),
(13, 8, 270411, 8),
(15, 7, 270413, 8),
(17, 3, 270413, 7);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `proj_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expense_date` date DEFAULT NULL,
  `submitted_by` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `man_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `department` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`man_id`, `emp_id`, `department`) VALUES
(1, 270410, 'Development '),
(2, 270411, 'Testing');

-- --------------------------------------------------------

--
-- Table structure for table `meeting`
--

CREATE TABLE `meeting` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `meeting_link` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meeting`
--

INSERT INTO `meeting` (`id`, `title`, `description`, `meeting_link`, `date`, `start_time`, `location`) VALUES
(4, 'Board Meeting ', 'Meeting to decide budget for current year', '2024-05-25', '2024-05-25', '0000-00-00 00:00:00', 'Meeting Hall');

-- --------------------------------------------------------

--
-- Table structure for table `meeting_agenda`
--

CREATE TABLE `meeting_agenda` (
  `id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `agenda_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meeting_agenda`
--

INSERT INTO `meeting_agenda` (`id`, `meeting_id`, `agenda_id`) VALUES
(7, 4, 10);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `style` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `meeting_id`, `timestamp`, `style`, `type`) VALUES
(4, 4, '2024-05-23 07:53:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notify_user`
--

CREATE TABLE `notify_user` (
  `id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `isread` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notify_user`
--

INSERT INTO `notify_user` (`id`, `notification_id`, `user_id`, `isread`) VALUES
(6, 4, 270413, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `proj_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `man_id` int(11) NOT NULL,
  `client` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`proj_id`, `name`, `description`, `status`, `man_id`, `client`) VALUES
(5, 'Social Media Application', 'Create social media application where users can post daily routines like photos videos and add friend', 'In development ', 1, 'Meta'),
(6, 'Movie Ticket Booking', 'Verify forms and pages', 'In Testing', 2, 'BookMyShow');

-- --------------------------------------------------------

--
-- Table structure for table `req_skill`
--

CREATE TABLE `req_skill` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `skill` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `req_skill`
--

INSERT INTO `req_skill` (`id`, `task_id`, `skill`) VALUES
(1, 66, 'HTML'),
(2, 67, 'DSA'),
(3, 68, 'DSA'),
(4, 72, 'Java'),
(5, 73, 'Java'),
(6, 74, 'CSS'),
(9, 97, 'Java, Python'),
(10, 98, 'python');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `res_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `availability` varchar(20) DEFAULT 'free'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`res_id`, `name`, `description`, `status`, `availability`) VALUES
(6, 'Meeting room', 'Room for meetings and group discussion ', 'Good', 'occupied'),
(7, 'Memory', 'To store valuable information', 'Better', 'free'),
(8, 'CPU', 'Central Processing Unit for computers', 'Best', 'free');

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE `skill` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skill`
--

INSERT INTO `skill` (`id`, `name`) VALUES
(1, 'Java'),
(2, 'Python'),
(3, 'DSA'),
(4, 'HTML'),
(5, 'CSS'),
(6, 'Javascript '),
(7, 'react'),
(8, 'nodejs'),
(9, 'php');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `name`, `start_time`, `end_time`, `description`) VALUES
(66, 'Homepage', '2024-05-02 10:42:34', '2024-05-12 00:00:00', 'Create Homepage for website'),
(67, 'Logorithum to fetch ', '2024-05-02 10:44:28', '2024-05-12 00:00:00', 'Craete Logorithum to fetch post on homepage'),
(68, 'Dtabase', '2024-05-02 10:46:50', '2024-05-12 00:00:00', 'Create database for save application data'),
(72, 'Jsp page', '2024-05-02 11:05:52', '2024-05-12 00:00:00', 'create jsp page for Comment'),
(73, 'Diagram', '2024-05-02 11:16:49', '2024-05-12 00:00:00', 'Create Diagram for project'),
(74, 'Design Loding Page', '2024-05-02 11:17:45', '2024-05-12 00:00:00', 'Design new loading page attractive '),
(97, 'Tables', '2024-05-03 09:11:51', '2024-05-12 00:00:00', 'Create tables'),
(98, 'Abc', '2024-05-18 16:27:33', '2024-05-24 00:00:00', 'abc');

-- --------------------------------------------------------

--
-- Table structure for table `task_assign`
--

CREATE TABLE `task_assign` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'to do',
  `actual_start` datetime DEFAULT NULL,
  `actual_end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_assign`
--

INSERT INTO `task_assign` (`id`, `task_id`, `emp_id`, `status`, `actual_start`, `actual_end`) VALUES
(19, 66, 270413, 'hold', '2024-05-03 12:25:05', '2024-05-03 12:25:29'),
(20, 67, 270414, 'hold', NULL, NULL),
(21, 68, 270415, 'block', NULL, NULL),
(22, 72, 270413, 'cancel', NULL, '2024-05-03 12:43:02'),
(23, 73, 270413, 'ongoing', '2024-05-03 13:01:06', '2024-05-03 12:43:11'),
(24, 74, 270416, 'to do', NULL, NULL),
(25, 97, 270413, 'complete', '2024-05-03 12:46:18', '2024-05-03 12:46:40');

-- --------------------------------------------------------

--
-- Table structure for table `task_status`
--

CREATE TABLE `task_status` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `assigned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_status`
--

INSERT INTO `task_status` (`id`, `task_id`, `assigned`) VALUES
(34, 66, 1),
(35, 67, 1),
(36, 68, 1),
(40, 72, 1),
(41, 73, 1),
(42, 74, 1),
(65, 97, 1),
(66, 98, 0);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `team_id` int(11) NOT NULL,
  `team_name` varchar(20) NOT NULL,
  `team_leader` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`team_id`, `team_name`, `team_leader`) VALUES
(10, 'Developement', 270410),
(12, 'Testing', 270411);

-- --------------------------------------------------------

--
-- Table structure for table `team_member`
--

CREATE TABLE `team_member` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_member`
--

INSERT INTO `team_member` (`id`, `team_id`, `emp_id`) VALUES
(6, 10, 270413),
(7, 10, 270414),
(9, 12, 270415),
(10, 12, 270416);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `pass` varchar(10) NOT NULL,
  `emp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `pass`, `emp_id`) VALUES
(1, 'shambhuraje@gmail.com', 'admin@123', 270400),
(10, 'anish@gmail.com', 'bykOqG{n', 270411),
(11, 'jayesh@gmail.com', 'jayesh@123', 270413),
(12, 'vikas@gmail.com', '46:SSji.', 270414),
(13, 'rohan@gmail.com', 'bV{2AE@O', 270415),
(14, 'sumit@gmail.com', 'dfz,VcD0', 270416),
(16, 'jivraj@gmail.com', 'jivraj@123', 270410);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agenda_topic`
--
ALTER TABLE `agenda_topic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agenda_topic_key`
--
ALTER TABLE `agenda_topic_key`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agenda_id` (`agenda_id`) USING BTREE,
  ADD KEY `topic_id` (`topic_id`) USING BTREE;

--
-- Indexes for table `allocation`
--
ALTER TABLE `allocation`
  ADD PRIMARY KEY (`alloc_id`),
  ADD KEY `res_id` (`res_id`),
  ADD KEY `proj_id` (`task_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`doc_id`),
  ADD KEY `proj_id` (`proj_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `emp_skills`
--
ALTER TABLE `emp_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skill_id` (`skill_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proj_id` (`proj_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`man_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meeting_agenda`
--
ALTER TABLE `meeting_agenda`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meeting_id` (`meeting_id`),
  ADD UNIQUE KEY `agenda_id` (`agenda_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meeting_id` (`meeting_id`);

--
-- Indexes for table `notify_user`
--
ALTER TABLE `notify_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notification_id` (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`proj_id`),
  ADD KEY `man_id` (`man_id`);

--
-- Indexes for table `req_skill`
--
ALTER TABLE `req_skill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`res_id`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `task_assign`
--
ALTER TABLE `task_assign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `task_status`
--
ALTER TABLE `task_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`team_id`),
  ADD KEY `team_leader` (`team_leader`);

--
-- Indexes for table `team_member`
--
ALTER TABLE `team_member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `agenda_topic`
--
ALTER TABLE `agenda_topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `agenda_topic_key`
--
ALTER TABLE `agenda_topic_key`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `allocation`
--
ALTER TABLE `allocation`
  MODIFY `alloc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270419;

--
-- AUTO_INCREMENT for table `emp_skills`
--
ALTER TABLE `emp_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `man_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `meeting`
--
ALTER TABLE `meeting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `meeting_agenda`
--
ALTER TABLE `meeting_agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notify_user`
--
ALTER TABLE `notify_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `proj_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `req_skill`
--
ALTER TABLE `req_skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `skill`
--
ALTER TABLE `skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `task_assign`
--
ALTER TABLE `task_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `task_status`
--
ALTER TABLE `task_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `team_member`
--
ALTER TABLE `team_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agenda_topic_key`
--
ALTER TABLE `agenda_topic_key`
  ADD CONSTRAINT `agenda_topic_key_ibfk_1` FOREIGN KEY (`agenda_id`) REFERENCES `agenda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agenda_topic_key_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `agenda_topic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `allocation`
--
ALTER TABLE `allocation`
  ADD CONSTRAINT `allocation_ibfk_1` FOREIGN KEY (`res_id`) REFERENCES `resources` (`res_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `allocation_ibfk_3` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `allocation_ibfk_4` FOREIGN KEY (`task_id`) REFERENCES `task` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_ibfk_1` FOREIGN KEY (`proj_id`) REFERENCES `project` (`proj_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `document_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `emp_skills`
--
ALTER TABLE `emp_skills`
  ADD CONSTRAINT `emp_skills_ibfk_1` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `emp_skills_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`proj_id`) REFERENCES `project` (`proj_id`),
  ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `expense_categories` (`id`);

--
-- Constraints for table `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `manager_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `meeting_agenda`
--
ALTER TABLE `meeting_agenda`
  ADD CONSTRAINT `meeting_agenda_ibfk_1` FOREIGN KEY (`agenda_id`) REFERENCES `agenda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `meeting_agenda_ibfk_3` FOREIGN KEY (`meeting_id`) REFERENCES `meeting` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`meeting_id`) REFERENCES `meeting` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notify_user`
--
ALTER TABLE `notify_user`
  ADD CONSTRAINT `notify_user_ibfk_2` FOREIGN KEY (`notification_id`) REFERENCES `notification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notify_user_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`man_id`) REFERENCES `manager` (`man_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `req_skill`
--
ALTER TABLE `req_skill`
  ADD CONSTRAINT `req_skill_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_assign`
--
ALTER TABLE `task_assign`
  ADD CONSTRAINT `task_assign_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_assign_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_status`
--
ALTER TABLE `task_status`
  ADD CONSTRAINT `task_status_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_ibfk_1` FOREIGN KEY (`team_leader`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `team_member`
--
ALTER TABLE `team_member`
  ADD CONSTRAINT `team_member_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `team_member_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `team` (`team_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `update_task_status_event` ON SCHEDULE EVERY 1 SECOND STARTS '2024-05-02 14:17:01' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DECLARE task_id_ongoing INT;
    DECLARE task_id_to_do INT;

    -- Get the task ID transitioning from 'To Do' to 'Ongoing'
    SELECT task_id INTO task_id_ongoing
    FROM task_assign
    WHERE status = 'Ongoing' AND actual_start IS NULL
    ORDER BY task_id ASC
    LIMIT 1;

    -- Get the task ID transitioning from 'Ongoing' to 'Complete' or 'Cancel'
    SELECT task_id INTO task_id_to_do
    FROM task_assign
    WHERE (status = 'Complete' OR status = 'Cancel') AND actual_end IS NULL
    ORDER BY task_id ASC
    LIMIT 1;

    -- Update actual_start timestamp for the specified task ID when status changes from 'To Do' to 'Ongoing'
    UPDATE task_assign
    SET actual_start = CURRENT_TIMESTAMP
    WHERE task_id = task_id_ongoing;

    -- Update actual_end timestamp for the specified task ID when status changes from 'Ongoing' to 'Complete' or 'Cancel'
    UPDATE task_assign
    SET actual_end = CURRENT_TIMESTAMP
    WHERE task_id = task_id_to_do;
End$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
