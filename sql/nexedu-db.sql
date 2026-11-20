-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 20, 2026 lúc 02:22 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `jobs`
--

INSERT INTO `jobs` (`job_ref`, `job_title`, `department`, `location`, `reports_to`, `salary`, `overview`, `responsibilities`, `essential_reqs`, `preferable_reqs`) VALUES
('ED101', 'Senior Learning Platform Engineer', 'Engineering • Cloud Platform', 'Can Tho Campus / Hybrid', 'Principal Cloud Architect', '$145,000 – $168,000 AUD (~2.3B – 2.7B VND/yr) + 11.5% Superannuation / Benefits', 'As a Senior Learning Platform Engineer, you will build and maintain core services for our learning system, ensuring high performance and reliability for students and teachers.', '1. Develop backend web services using Golang, TypeScript, and Docker.\n2. Optimize database performance using PostgreSQL and Redis.\n3. Work with Frontend Developers to create REST and GraphQL APIs.\n4. Set up automated testing and continuous deployment pipelines.\n5. Monitor system health and troubleshoot operational issues.', '- Bachelor\'s degree in Computer Science, Software Engineering, or equivalent industry experience (5+ years).\n- Experience with backend development in Go, Node.js, or Java.\n- Good knowledge of SQL databases and REST APIs.\n- Familiarity with Git and basic Linux operational commands.', '- Previous experience working with EdTech applications or LMS.\n- Basic knowledge of cloud platforms like AWS or Google Cloud.\n- Familiarity with ISO 27001 compliance standards, GDPR, and Vietnamese personal data protection regulations (Decree 13/2023/ND-CP).'),
('UX204', 'Accessibility UX Designer', 'Design & Product', 'Can Tho / Ho Chi Minh City', 'Design Team Lead', '$120,000 – $138,000 AUD (~1.9B – 2.2B VND/yr) + 11.5% Superannuation / Benefits', 'We are looking for a UX Designer to help us build user-friendly and accessible interfaces for everyone, including users with disabilities.', '1. Conduct user testing and interviews with various user groups.\n2. Design wireframes, prototypes, and UI components in Figma.\n3. Ensure web designs follow web accessibility guidelines (WCAG).\n4. Collaborate closely with developers during implementation.\n5. Share UX and accessibility best practices with the team.', '- 3+ years of experience in UI/UX design for web applications.\n- Proficiency in Figma and wireframing tools.\n- Basic understanding of web accessibility standards (WCAG).\n- Strong communication and teamwork skills.', '- IAAP Certification (such as CPACC or WAS credential).\n- Fundamental working knowledge of semantic HTML5, modern CSS3 layout techniques, and browser rendering engines.\n- Experience conducting cognitive load and readability assessments for educational materials.');

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
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
