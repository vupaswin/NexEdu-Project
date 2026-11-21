-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2026 at 09:25 AM
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
-- Database: `nexedu-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `member_id` int(11) NOT NULL,
  `student_id` varchar(15) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `part1_role` varchar(100) NOT NULL,
  `part1_work` text NOT NULL,
  `part2_role` varchar(100) NOT NULL,
  `part2_work` text NOT NULL,
  `quote` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`member_id`, `student_id`, `full_name`, `part1_role`, `part1_work`, `part2_role`, `part2_work`, `quote`) VALUES
(1, '106217835', 'Phạm Anh Vũ', 'Backend Developer', 'Implemented database connectivity, settings.php, and security guards.', 'Team Lead', 'Coordinated project architecture and sprint tracking on Jira.', 'Code is like humor. When you have to explain it, it’s bad.'),
(4, '10691366', 'Nguyen Cao Minh Tat', 'Team Visuals & Jira Scrum Master', 'Developed about.html with nested lists, a team portrait under 300KB, and a table with hover effects.', 'Dynamic about & Contribution DB', 'Seed the about table with member information and load member profile dynamically into about.php', 'Do not compare the first chapter of your life to the tenth chapter of someone else'),
(5, '106638368', 'Ho Kim Hoan Nguyen', 'Information Architecture & Semantic Expert', 'Developed jobs.html using semantic HTML5, headings, ordered and unordered lists, sections, and a right-aligned aside box. Reviewed HTML and CSS syntax', 'Dynamic Job Catalog Rendering', 'Assigned NEX-203: Load job information from MySQL into jobs.php, display job cards dynamically, and preserve the existing page layout', 'Bad days build better days'),
(6, '106913272', 'Anh Quan Nguyen', 'Form Logic & Accessibility Lead', 'Developed apply.html using Flexbox, HTML5 form validation, required fields, fieldsets, legends, input labels, and keyboard accessibility', 'EOI Processing & Server-Side Validation', 'Assigned NEX-201 and NEX-202: Create the eoi table when needed, block direct GET access to process_eoi.php, validate submitted form data, and save valid applications', 'You can cry, can swear, can do whatever you want if you fail. But if you give up, you are a failure');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
