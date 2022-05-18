-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2022 at 12:30 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_broadcasting`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_log`
--

CREATE TABLE `attendance_log` (
  `emp_id` int(11) NOT NULL,
  `auth_date_time` datetime NOT NULL,
  `auth_date` date NOT NULL,
  `auth_time` time NOT NULL,
  `direction` varchar(15) NOT NULL,
  `device_name` varchar(150) NOT NULL,
  `device_sl_no` varchar(150) NOT NULL,
  `emp_name` varchar(50) NOT NULL,
  `card_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance_log`
--

INSERT INTO `attendance_log` (`emp_id`, `auth_date_time`, `auth_date`, `auth_time`, `direction`, `device_name`, `device_sl_no`, `emp_name`, `card_no`) VALUES
(1, '2022-03-10 20:07:40', '2022-03-10', '20:07:40', 'IN', 'Attendance', 'DS-K1A8503EF-B20190629V010201END55553370', '', ''),
(1, '2022-03-12 10:56:06', '2022-03-12', '10:56:06', 'IN', 'Attendance', 'DS-K1A8503EF-B20190629V010201END55553370', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `remarks`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'IT', 'IT department description', 1, '1', '2022-03-10 00:48:17', '2022-03-10 00:48:17'),
(13, 'Test Department', 'test', 1, '1', '2022-05-18 04:14:36', '2022-05-18 04:14:36'),
(14, 'Business', NULL, 1, '1', '2022-05-18 04:29:03', '2022-05-18 04:29:03');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `shift_timetable_id` bigint(20) UNSIGNED NOT NULL,
  `device_emp_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hire_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` double(12,2) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `department_id`, `shift_timetable_id`, `device_emp_id`, `name`, `email`, `mobile`, `image`, `dob`, `gender`, `position`, `hire_date`, `address`, `salary`, `status`, `remarks`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Md. Shakil Hossain', 'mdshakil@gmail.com', '01738620241', '368481646895033.jpg', '2022-02-25', 'Male', 'Web Developer', '2022-02-26', 'State guest house, Padma, Meghna, Ramna, Dhaka-1000', 20000.00, 1, 'test', '1', '2022-02-23 03:21:23', '2022-03-10 00:50:33'),
(2, 1, 1, 6, 'Tajul Islam', 'rahman@gmail.com', '01815458555', NULL, '2022-02-01', 'Male', 'Web Developer', '2022-02-26', 'State guest house, Padma, Meghna, Ramna, Dhaka-1000', 25000.00, 1, 'Test', '1', '2022-02-23 04:11:32', '2022-02-23 04:11:32'),
(3, 1, 1, 9, 'Md. Sanaullah', 'sanaullah@gmail.com', '01725652552', NULL, '1984-02-07', 'Male', 'CEO', '2022-02-01', 'Test', 50000.00, 1, 'Test re', '1', '2022-02-26 02:25:55', '2022-02-26 02:25:55'),
(4, 1, 1, 7, 'Robin Nil', 'robinnil@gmail.com', '01815455255', NULL, '2004-02-01', 'Male', 'Web Designer', '2022-02-01', 'Dhaka', 30000.00, 1, NULL, '1', '2022-02-27 02:03:50', '2022-02-27 02:03:50'),
(5, 1, 1, 2, 'Sujit Sarkar', 'sujit@gmail.com', '01725652585', NULL, '1997-02-01', 'Male', 'Mobile Apps Developer', '2022-02-01', NULL, 50000.00, 1, NULL, '1', '2022-02-27 23:39:46', '2022-02-27 23:39:46'),
(6, 1, 1, 3, 'Nazmul Hossain', 'nazmul@gmail.com', '01725652541', NULL, '1996-02-29', 'Male', 'Web Developer', '2022-02-01', NULL, 30000.00, 1, NULL, '1', '2022-02-28 03:24:01', '2022-02-28 03:24:01'),
(7, 1, 1, 4, 'Neamat Ullah', 'neamat@gmail.com', '01725152021', NULL, '1995-02-06', 'Male', 'Web Developer', '2022-02-01', NULL, 25000.00, 1, NULL, '1', '2022-02-28 03:24:55', '2022-02-28 03:24:55'),
(8, 1, 1, 5, 'Shahinur Rahman', 'shahinur@gmail.com', '01815452565', NULL, '1997-02-05', 'Male', 'Web Developer', '2022-02-01', NULL, 25000.00, 1, NULL, '1', '2022-02-28 03:25:50', '2022-02-28 03:25:50'),
(9, 1, 1, 8, 'Arifuzzaman Milon', 'milon@gmail.com', '01725452021', NULL, '19985-02-05', 'Female', 'COO', '2022-02-01', 'Dhaka', 30000.00, 1, NULL, '1', '2022-02-28 03:28:02', '2022-02-28 03:28:02');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_02_17_163418_create_permission_tables', 1),
(6, '2022_02_21_175747_create_departments_table', 1),
(8, '2022_02_22_065511_create_employees_table', 1),
(10, '2022_02_27_053827_create_timetables_table', 2),
(11, '2022_02_22_065021_create_shift_timetables_table', 3),
(12, '2022_02_28_062720_create_jobs_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard.View', 'web', 'Dashboard', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(2, 'Role.Create', 'web', 'Role', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(3, 'Role.View', 'web', 'Role', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(4, 'Role.Edit', 'web', 'Role', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(5, 'Role.Delete', 'web', 'Role', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(6, 'User.Create', 'web', 'User', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(7, 'User.View', 'web', 'User', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(8, 'User.Edit', 'web', 'User', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(9, 'User.Delete', 'web', 'User', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(10, 'Department.Create', 'web', 'Department', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(11, 'Department.View', 'web', 'Department', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(12, 'Department.Edit', 'web', 'Department', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(13, 'Department.Delete', 'web', 'Department', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(14, 'TimeTable.Create', 'web', 'TimeTable', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(15, 'TimeTable.View', 'web', 'TimeTable', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(16, 'TimeTable.Edit', 'web', 'TimeTable', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(17, 'TimeTable.Delete', 'web', 'TimeTable', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(18, 'Shift.Create', 'web', 'Shift', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(19, 'Shift.View', 'web', 'Shift', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(20, 'Shift.Edit', 'web', 'Shift', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(21, 'Shift.Delete', 'web', 'Shift', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(22, 'Employee.Create', 'web', 'Employee', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(23, 'Employee.View', 'web', 'Employee', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(24, 'Employee.Edit', 'web', 'Employee', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(25, 'Employee.Delete', 'web', 'Employee', '2022-03-10 00:47:10', '2022-03-10 00:47:10'),
(26, 'AttendanceReport.View', 'web', 'AttendanceReport', '2022-03-10 00:47:11', '2022-03-10 00:47:11');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2022-03-10 00:47:11', '2022-03-10 00:47:11');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shift_timetables`
--

CREATE TABLE `shift_timetables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shift_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timetable_id` int(11) DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shift_timetables`
--

INSERT INTO `shift_timetables` (`id`, `shift_name`, `timetable_id`, `remarks`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Regular Shift', 2, 'Test', 1, '1', '2022-02-27 01:28:09', '2022-03-10 02:04:45');

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `timetable_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_work_time` time DEFAULT NULL,
  `valid_check_in_time` time DEFAULT NULL,
  `valid_check_in_time_to` time DEFAULT NULL,
  `end_work_time` time DEFAULT NULL,
  `valid_check_out_time` time DEFAULT NULL,
  `valid_check_out_time_to` time DEFAULT NULL,
  `overtime_start` time DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`id`, `timetable_name`, `start_work_time`, `valid_check_in_time`, `valid_check_in_time_to`, `end_work_time`, `valid_check_out_time`, `valid_check_out_time_to`, `overtime_start`, `remarks`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(2, '11AM-8PM', '11:00:00', '09:30:00', '11:15:00', '20:00:00', '19:45:00', '22:30:00', '20:00:00', NULL, 1, '1', '2022-02-27 00:55:00', '2022-03-10 03:46:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `address`, `email_verified_at`, `password`, `status`, `image`, `remarks`, `created_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin@gmail.com', '01738620241', NULL, NULL, '$2y$10$cqRqQ3leWLdMlrKb.niER.T63kCdv8P640nnqceyouCcFv11DXSRq', 1, NULL, NULL, NULL, NULL, '2022-03-10 00:47:11', '2022-03-10 00:47:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_department_name_unique` (`department_name`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `shift_timetables`
--
ALTER TABLE `shift_timetables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shift_timetables`
--
ALTER TABLE `shift_timetables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
