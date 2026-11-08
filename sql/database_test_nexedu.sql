-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th10 08, 2026 lúc 10:02 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `nexedu-db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `about`
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
-- Đang đổ dữ liệu cho bảng `about`
--

INSERT INTO `about` (`member_id`, `student_id`, `full_name`, `part1_role`, `part1_work`, `part2_role`, `part2_work`, `quote`) VALUES
(1, '106217835', 'Phạm Anh Vũ', 'Backend Developer', 'Implemented database connectivity, settings.php, and security guards.', 'Team Lead', 'Coordinated project architecture and sprint tracking on Jira.', 'Code is like humor. When you have to explain it, it’s bad.'),
(2, '106217836', 'Nguyen Van A', 'Frontend Developer', 'Designed layout structure, HTML5/CSS3 templates, and responsive navigation.', 'UI/UX Designer', 'Wireframed user journeys and styling components.', 'Design is not just what it looks like and feels like. Design is how it works.'),
(3, '106217837', 'Tran Thi B', 'QA Engineer', 'Conducted validation testing and bug tracking for forms.', 'Documentation Lead', 'Prepared user manuals and technical reports for submission.', 'Quality must be caused, not controlled.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `eoi`
--

CREATE TABLE `eoi` (
  `EOInumber` int(11) NOT NULL,
  `job_ref` varchar(5) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(20) NOT NULL,
  `address` varchar(40) NOT NULL,
  `suburb` varchar(40) NOT NULL,
  `state` varchar(3) NOT NULL,
  `postcode` varchar(4) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `skills` varchar(255) NOT NULL,
  `other_skills` text DEFAULT NULL,
  `status` enum('New','Current','Final') DEFAULT 'New',
  `eoi_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `eoi`
--

INSERT INTO `eoi` (`EOInumber`, `job_ref`, `first_name`, `last_name`, `dob`, `gender`, `address`, `suburb`, `state`, `postcode`, `email`, `phone`, `skills`, `other_skills`, `status`, `eoi_date`) VALUES
(1, 'J001', 'John', 'Doe', '2000-05-15', 'Male', '123 Nguyen Van Cu', 'Ninh Kieu', 'CT', '9000', 'john.doe@example.com', '0912345678', 'PHP, MySQL, HTML', 'Quick learner and team player.', 'New', '2026-11-08 09:01:54'),
(2, 'J002', 'Jane', 'Smith', '1998-11-20', 'Female', '456 Le Loi', 'Binh Thuy', 'CT', '9001', 'jane.smith@example.com', '0987654321', 'Figma, UI/UX, CSS', 'Certified graphic designer.', 'Current', '2026-11-08 09:01:54'),
(3, 'J003', 'Alex', 'Johnson', '1995-03-10', 'Other', '789 Tran Hung Dao', 'Cai Rang', 'CT', '9002', 'alex.j@example.com', '0901122334', 'Linux, Networking, AWS', 'Experienced in server troubleshooting.', 'Final', '2026-11-08 09:01:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `job_ref` varchar(5) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `reports_to` varchar(100) NOT NULL,
  `salary` varchar(100) NOT NULL,
  `overview` text NOT NULL,
  `responsibilities` text NOT NULL,
  `essential_reqs` text NOT NULL,
  `preferable_reqs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `jobs`
--

INSERT INTO `jobs` (`job_ref`, `job_title`, `department`, `location`, `reports_to`, `salary`, `overview`, `responsibilities`, `essential_reqs`, `preferable_reqs`) VALUES
('J001', 'Junior Web Developer', 'Engineering', 'Can Tho, Vietnam', 'Lead Developer', '$600 - $800', 'Build and maintain responsive web applications using PHP and MySQL.', 'Develop backend logic, manage MySQL schemas, fix bugs.', 'Proficiency in PHP, MySQL, HTML/CSS.', 'Experience with Git and MVC frameworks.'),
('J002', 'UI/UX Designer', 'Design', 'Ho Chi Minh, Vietnam', 'Product Manager', '$700 - $950', 'Design intuitive user experiences and interfaces for enterprise software.', 'Create wireframes, user flows, and high-fidelity mockups.', 'Strong portfolio in Figma and Adobe XD.', 'Basic frontend coding skills (HTML/CSS).'),
('J003', 'Systems Administrator', 'IT Operations', 'Remote', 'CTO', '$900 - $1200', 'Manage server infrastructure, deployment pipelines, and database security.', 'Configure Apache/Nginx, manage backups, monitor server health.', 'Experience with Linux administration and networking.', 'AWS Certified SysOps Administrator.'),
('TEST1', 'TEST TITLE', 'CT', 'Cantho', 'Vu', '250000', 'This is for test purpose.', 'No reponsibilities.', 'No', 'No');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'manager',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`member_id`);

--
-- Chỉ mục cho bảng `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_ref`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `about`
--
ALTER TABLE `about`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
