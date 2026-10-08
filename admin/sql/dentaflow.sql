-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2026 at 07:53 AM
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
-- Database: `dentaflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(10) UNSIGNED NOT NULL,
  `date_of_entry` date NOT NULL,
  `appointment_id` varchar(20) NOT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `patient_name` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `is_vip` tinyint(1) NOT NULL DEFAULT 0,
  `priority` enum('Low','Normal','High','Urgent') DEFAULT 'Normal',
  `purpose_of_visit` varchar(255) DEFAULT NULL,
  `appointment_notes` text DEFAULT NULL,
  `dentist` varchar(150) DEFAULT NULL,
  `appointment_datetime` datetime NOT NULL,
  `status` enum('Pending','Confirmed','Complete','Cancelled','No Show','Rescheduled') NOT NULL DEFAULT 'Pending',
  `cancel_reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `date_of_entry`, `appointment_id`, `patient_id`, `patient_name`, `phone`, `is_vip`, `priority`, `purpose_of_visit`, `appointment_notes`, `dentist`, `appointment_datetime`, `status`, `cancel_reason`, `created_at`, `updated_at`) VALUES
(2, '2026-03-25', 'e094f660', 'PT-7AB5F857', 'Thomas  Shelbs', '90909090', 1, 'High', 'CheckUp', 'asa', 'Mr D', '2026-03-26 18:55:00', 'Pending', '', '2026-03-25 10:55:49', '2026-03-25 10:55:49'),
(3, '2026-03-25', '1116b9d3', 'PT-A845812E', 'Von Anonat Vergara', '09268857364', 1, 'High', 'CheckUp', '', 'Mr D', '2026-03-26 22:44:00', 'Confirmed', '', '2026-03-25 14:44:04', '2026-03-25 14:44:04'),
(4, '2026-03-26', '1fa79e22', 'PT-7AB5F857', 'Thomas  Shelbs', '90909090', 1, 'Normal', 'General Cleaning of teeth', '', 'Mr D', '2026-03-27 14:37:00', 'Pending', '', '2026-03-26 06:37:43', '2026-03-26 06:37:43'),
(5, '2026-03-28', 'bcb03c9c', 'PT-7AB5F857', 'Thomas  Shelbs', '90909090', 1, 'Low', 'General Cleaning of teeth', '', 'Mr D', '2026-03-29 14:30:00', 'Pending', '', '2026-03-28 06:30:21', '2026-03-28 06:30:21'),
(6, '2026-03-28', 'c4744bea', 'PT-7AB5F857', 'Thomas  Shelbs', '90909090', 1, 'Normal', 'CheckUp', '', 'Mr D', '2026-03-28 14:32:00', 'Pending', '', '2026-03-28 06:32:13', '2026-03-28 06:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_reminder_logs`
--

CREATE TABLE `appointment_reminder_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `appointment_id` varchar(20) NOT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `patient_email` varchar(255) NOT NULL,
  `reminder_type` varchar(50) NOT NULL DEFAULT 'day_before',
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` varchar(50) NOT NULL,
  `date_registered` date DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `sex` varchar(20) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `occupation` varchar(150) DEFAULT NULL,
  `home_address` text DEFAULT NULL,
  `office_address` text DEFAULT NULL,
  `home_phone` varchar(50) DEFAULT NULL,
  `mobile_no` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `photo` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `date_registered`, `title`, `first_name`, `middle_name`, `last_name`, `nickname`, `birthday`, `age`, `sex`, `nationality`, `occupation`, `home_address`, `office_address`, `home_phone`, `mobile_no`, `email`, `photo`, `created_at`, `updated_at`) VALUES
('PT-7AB5F857', '0000-00-00', 'Mr', 'Thomas', '', 'Shelbs', '', '2019-02-28', 7, '', '', '', 'Isulan, Sultan Kudarat', 'Isulan, Sultan Kudarat', '9009120910', '90909090', 'admin@gmail.com', 'uploads/patients/PT-7AB5F857-1774435327.png', '2026-03-25 10:42:07', '2026-03-25 10:42:07'),
('PT-A845812E', '2026-03-22', 'Mr', 'Von', 'Anonat', 'Vergara', 'Von', '2005-06-29', 20, 'Male', 'Filipino', 'Student', 'South Cot.', 'South Cot.', '09268857364', '09268857364', 'von.vergara.399@gmail.com', 'uploads/patients/PT-A845812E-1774157631.png', '2026-03-22 05:33:51', '2026-03-22 05:33:51');

-- --------------------------------------------------------

--
-- Table structure for table `patient_files`
--

CREATE TABLE `patient_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `file_label` varchar(255) DEFAULT NULL,
  `file_path` text NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_size` int(10) UNSIGNED DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_files`
--

INSERT INTO `patient_files` (`id`, `patient_id`, `file_name`, `original_name`, `file_label`, `file_path`, `file_type`, `file_size`, `uploaded_at`) VALUES
(8, 'PT-A845812E', '71418b7c-17c6-45fd-8983-6488672c2678-1774197417-0.png', '71418b7c-17c6-45fd-8983-6488672c2678.png', NULL, 'uploads/patient-files/PT-A845812E/71418b7c-17c6-45fd-8983-6488672c2678-1774197417-0.png', 'image/png', 605585, '2026-03-22 16:36:57'),
(9, 'PT-A845812E', 'image-Photoroom-1774335577-0.png', 'image-Photoroom.png', NULL, 'uploads/patient-files/PT-A845812E/image-Photoroom-1774335577-0.png', 'image/png', 343868, '2026-03-24 06:59:37'),
(10, 'PT-7AB5F857', '71418b7c-17c6-45fd-8983-6488672c2678-1774496631-0.png', '71418b7c-17c6-45fd-8983-6488672c2678.png', NULL, 'uploads/patient-files/PT-7AB5F857/71418b7c-17c6-45fd-8983-6488672c2678-1774496631-0.png', 'image/png', 605585, '2026-03-26 03:43:51'),
(11, 'PT-7AB5F857', 'AteNixxx-1774496935-0.png', 'AteNixxx.png', 'Dental', 'uploads/patient-files/PT-7AB5F857/AteNixxx-1774496935-0.png', 'image/png', 20555, '2026-03-26 03:48:55'),
(12, 'PT-7AB5F857', '71418b7c-17c6-45fd-8983-6488672c2678-1774507160-0.png', '71418b7c-17c6-45fd-8983-6488672c2678.png', 'Dental', 'uploads/patient-files/PT-7AB5F857/71418b7c-17c6-45fd-8983-6488672c2678-1774507160-0.png', 'image/png', 605585, '2026-03-26 06:39:20');

-- --------------------------------------------------------

--
-- Table structure for table `patient_forms`
--

CREATE TABLE `patient_forms` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  `form_type` varchar(100) NOT NULL,
  `form_date` date NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_forms`
--

INSERT INTO `patient_forms` (`id`, `patient_id`, `form_type`, `form_date`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'PT-A845812E', 'Consent Form', '2026-03-23', 'Consent Form', '<h3 class=\"ql-align-center\" style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; font-size: 1.17em; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; text-align: center; color: rgb(0, 0, 0); white-space-collapse: preserve;\"><strong style=\"margin: 0px; padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-style: inherit; font-variant: inherit; font-weight: bold; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">INFORMED CONSENT</strong></h3><h2 style=\"text-align:center; font-weight:700;\"><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><br></p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><strong style=\"margin: 0px; padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-style: inherit; font-variant: inherit; font-weight: bold; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">TREATMENT TO BE DONE</strong>.&nbsp;I understand and consent to have any treatment done by the dentist after the procedure, the risks &amp; benefits &amp; cost have been fully explained. These treatments include, but are not limited to, x-rays, cleanings, periodontal treatments, fillings, crowns, bridges, all types of extraction, root canals, &amp;/or dentures, local anesthetics &amp; surgical cases.</p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><br></p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><strong style=\"margin: 0px; padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-style: inherit; font-variant: inherit; font-weight: bold; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">DRUGS &amp; MEDICATIONS</strong>.&nbsp;I understand that antibiotics, analgesics &amp; other medications can cause allergic reactions like redness &amp; swelling of tissues, pain, itching, vomiting, &amp;/or anaphylactic shock.</p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><br></p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><strong style=\"margin: 0px; padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-style: inherit; font-variant: inherit; font-weight: bold; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">CHANGES IN TREATMENT PLAN</strong>. I understand that during treatment it may be necessary to change/add procedures because of conditions found while working on the teeth that was not discovered during examination.&nbsp;For example, root canal therapy may be needed following routine restorative procedures.&nbsp;I give my permission to the dentist to make any/all changes and additions as necessary with my responsibility to pay all the costs agreed.</p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><br></p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><strong style=\"margin: 0px; padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-style: inherit; font-variant: inherit; font-weight: bold; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">RADIOGRAPH</strong>.&nbsp;I understand that an x-ray shot or a radiograph maybe necessary as part of diagnostic aid to come up with tentative diagnosis of my dental problem and to make a good treatment plan, but, this will not give me a 100% assurance for the accuracy of the treatment since all dental treatments are subject to unpredictable complications that later on may lead to sudden change of treatment plan and subject to new charges. </p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><br></p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><strong style=\"margin: 0px; padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-style: inherit; font-variant: inherit; font-weight: bold; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">REMOVAL OF TEETH</strong>.&nbsp;I understand that alternatives to tooth removal (root canal therapy, crowns &amp; periodontal surgery, etc.) &amp; I completely understand these alternatives, including their risk &amp; benefits prior to authorizing the dentist to remove teeth &amp; any other structures necessary for reasons above.&nbsp;I understand that removing teeth does not always remove all the infections, if present, &amp; it may be necessary to have further treatment.&nbsp;I understand the risk involved in having teeth removed, such as pain, swelling, spread of infection, dry socket, fractured jaw, loss of feeling on the teeth, lips, tongue&amp; surrounding tissue that can last for an indefinite period of time.&nbsp;I understand that I may need further treatment under a specialist if complications arise during or following treatment. </p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><br></p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><strong style=\"margin: 0px; padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-style: inherit; font-variant: inherit; font-weight: bold; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">VENEERS, CROWNS &amp; BRIDGES</strong>.&nbsp;Preparing a tooth may irritate the nerve tissue in the center of the tooth, leaving the tooth extra sensitive to heat, cold &amp; pressure.&nbsp;Treating such irritation may involve using special toothpastes, mouth rinses or root canal therapy.&nbsp;I understand that sometimes it is not possible to match the color of natural teeth exactly with artificial teeth.&nbsp;I further understand that I may be wearing temporary crowns, which may come off easily &amp; that I must be careful to ensure that they are kept on until the permanent crowns are delivered.&nbsp;It is my responsibility to return for permanent cementation within 20 days from tooth preparation, as excessive delay may allow for tooth movement, which may necessitate a remake of the crown, bridge/cap.&nbsp;I understand there will be additional charges for remakes due to my delaying of permanent cementation, &amp; I realize that final opportunity to make changes in my new crown, bridges or cap (including shape, fit, size, &amp; color) will be before permanent cementation. </p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><br></p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><strong style=\"margin: 0px; padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-style: inherit; font-variant: inherit; font-weight: bold; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">ENDODONTICS (ROOT CANAL)</strong>.&nbsp;I understand there is no guarantee that a root canal treatment will save a tooth &amp; that complication can occur from the treatment &amp; that occasionally root canal filling materials may extend through the tooth which does not necessarily effect the success of the treatment.&nbsp;I understand that endodontic files &amp; drills are very fine instruments &amp; stresses vented in their manufacture &amp; calcifications present in teeth can cause them to break during use.&nbsp;I understand that referral to the endodontist for additional treatments may be necessary following any root canal treatment &amp; I agree that I am responsible for any additional cost for treatment performed by the endodontist.&nbsp;I understand that a tooth may require removal in spite of all efforts to save it. </p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><br></p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><strong style=\"margin: 0px; padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-style: inherit; font-variant: inherit; font-weight: bold; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">PERIODONTAL DISEASE</strong>.&nbsp;I understand that periodontal disease is a serious condition causing gum &amp; bone inflammation &amp;/or loss &amp; that can lead eventually to the loss of my teeth.&nbsp;I understand the alternative treatment plans to correct periodontal disease, including gum surgery tooth extractions with or without replacement.&nbsp;I understand that undertaking any dental procedures may have future adverse effect on my periodontal conditions. </p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><br></p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><strong style=\"margin: 0px; padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-style: inherit; font-variant: inherit; font-weight: bold; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">FILLINGS</strong>.&nbsp;I understand that care must be exercised in chewing on fillings, especially during the first 24 hours to avoid breakage.&nbsp;I understand that a more extensive filling or a crown may be required as additional decay or fracture may become evident after initial excavation.&nbsp;I understand that significant sensitivity is common, but usually temporary, after-effect of a newly placed filling.&nbsp;I further understand that filling a tooth may irritate the nerve tissue creating sensitivity &amp; treating such sensitivity could require root canal therapy or extractions. </p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><br></p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><strong style=\"margin: 0px; padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-style: inherit; font-variant: inherit; font-weight: bold; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">DENTURES</strong>.&nbsp;I understand that wearing of dentures can be difficult.&nbsp;Sore spots, altered speech &amp; difficulty in eating are common problems.&nbsp;Immediate dentures (placement of denture immediately after extractions) may be painful.&nbsp;Immediate dentures may require considerable adjusting &amp; several relines.&nbsp;I understand that it is my responsibility to return for delivery of dentures.&nbsp;I understand that failure to keep my delivery appointment may result in poorly fitted dentures.&nbsp;If a remake is required due to my delays of more than 30 days, there will be additional charges.&nbsp;A permanent reline will be needed later, which is not included in the initial fee.&nbsp;I understand that all adjustment or alterations of any kind after this initial period is subject to charges.&nbsp;</p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><br></p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><strong style=\"margin: 0px; padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-style: inherit; font-variant: inherit; font-weight: bold; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">I understand that dentistry is not an exact science and that no dentist can properly guarantee accurate results all the time.</strong></p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\"><br></p><p style=\"padding: 0px; border-style: initial; border-color: initial; border-image: initial; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-weight: 400; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Helvetica, Arial, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: text; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(0, 0, 0); text-align: left; white-space-collapse: preserve;\">I hereby authorize any of the doctors/dental auxiliaries to proceed with &amp; perform the dental restorations &amp; treatments as explained to me.&nbsp;I understand that these are subject to modification depending on un-diagnosable circumstances that may arise during the course of treatment.&nbsp;I understand that regardless of any dental insurance coverage I may have, I am responsible for payment of dental fees, I agree to pay attorney’s fees, collection fee, or court costs that may be incurred to satisfy any obligation to this office.&nbsp;All treatment was properly explained to me &amp; any untoward circumstances that may arise during the procedure, the attending dentist will not be held liable since it is my free will, with full trust &amp; confidence in him/her, to undergo dental treatment under his/her care.</p></h2>', '2026-03-23 15:23:52', '2026-03-23 15:23:52'),
(2, 'PT-7AB5F857', 'Consent Form', '2026-03-26', 'Consent Form', '<div style=\"max-width:820px; margin:0 auto; color:#111827;\"><h2 style=\"text-align:center; font-weight:700; letter-spacing:0.08em; margin-bottom:28px;\">CONSENT FORM</h2><p style=\"text-align:justify; margin-bottom:18px;\"><strong>TREATMENT TO BE DONE.</strong> I understand and consent to have any treatment done by the dentist after the procedure, the risks &amp; benefits &amp; cost have been fully explained. These treatments include, but are not limited to, x-rays, cleanings, periodontal treatments, fillings, crowns, bridges, all types of extraction, root canals, &amp;/or dentures, local anesthetics &amp; surgical cases.</p><p style=\"text-align:justify; margin-bottom:18px;\"><strong>DRUGS &amp; MEDICATIONS.</strong> I understand that antibiotics, analgesics &amp; other medications can cause allergic reactions like redness &amp; swelling of tissues, pain, itching, vomiting, &amp;/or anaphylactic shock.</p><p style=\"text-align:justify; margin-bottom:18px;\"><strong>CHANGES IN TREATMENT PLAN.</strong> I understand that during treatment it may be necessary to change/add procedures because of conditions found while working on the teeth that was not discovered during examination. For example, root canal therapy may be needed following routine restorative procedures. I give my permission to the dentist to make any/all changes and additions as necessary with my responsibility to pay all the costs agreed.</p><p style=\"text-align:justify; margin-bottom:18px;\"><strong>RADIOGRAPH.</strong> I understand that an x-ray shot or a radiograph maybe necessary as part of diagnostic aid to come up with tentative diagnosis of my dental problem and to make a good treatment plan, but, this will not give me a 100% assurance for the accuracy of the treatment since all dental treatments are subject to unpredictable complications that later on may lead to sudden change of treatment plan and subject to new charges.</p><p style=\"text-align:justify; margin-bottom:18px;\"><strong>REMOVAL OF TEETH.</strong> I understand that alternatives to tooth removal (root canal therapy, crowns &amp; periodontal surgery, etc.) &amp; I completely understand these alternatives, including their risk &amp; benefits prior to authorizing the dentist to remove teeth &amp; any other structures necessary for reasons above. I understand that removing teeth does not always remove all the infections, if present, &amp; it may be necessary to have further treatment. I understand the risk involved in having teeth removed, such as pain, swelling, spread of infection, dry socket, fractured jaw, loss of feeling on the teeth, lips, tongue &amp; surrounding tissue that can last for an indefinite period of time. I understand that I may need further treatment under a specialist if complications arise during or following treatment.</p><p style=\"text-align:justify; margin-bottom:18px;\"><strong>VENEERS, CROWNS &amp; BRIDGES.</strong> Preparing a tooth may irritate the nerve tissue in the center of the tooth, leaving the tooth extra sensitive to heat, cold &amp; pressure. Treating such irritation may involve using special toothpastes, mouth rinses or root canal therapy. I understand that sometimes it is not possible to match the color of natural teeth exactly with artificial teeth. I further understand that I may be wearing temporary crowns, which may come off easily &amp; that I must be careful to ensure that they are kept on until the permanent crowns are delivered. It is my responsibility to return for permanent cementation within 20 days from tooth preparation, as excessive delay may allow for tooth movement, which may necessitate a remake of the crown, bridge/cap. I understand there will be additional charges for remakes due to my delaying of permanent cementation, &amp; I realize that final opportunity to make changes in my new crown, bridges or cap (including shape, fit, size, &amp; color) will be before permanent cementation.</p><p style=\"text-align:justify; margin-bottom:18px;\"><strong>ENDODONTICS (ROOT CANAL).</strong> I understand there is no guarantee that a root canal treatment will save a tooth &amp; that complication can occur from the treatment &amp; that occasionally root canal filling materials may extend through the tooth which does not necessarily effect the success of the treatment. I understand that endodontic files &amp; drills are very fine instruments &amp; stresses vented in their manufacture &amp; calcifications present in teeth can cause them to break during use. I understand that referral to the endodontist for additional treatments may be necessary following any root canal treatment &amp; I agree that I am responsible for any additional cost for treatment performed by the endodontist. I understand that a tooth may require removal in spite of all efforts to save it.</p><p style=\"text-align:justify; margin-bottom:18px;\"><strong>PERIODONTAL DISEASE.</strong> I understand that periodontal disease is a serious condition causing gum &amp; bone inflammation &amp;/or loss &amp; that can lead eventually to the loss of my teeth. I understand the alternative treatment plans to correct periodontal disease, including gum surgery tooth extractions with or without replacement. I understand that undertaking any dental procedures may have future adverse effect on my periodontal conditions.</p><p style=\"text-align:justify; margin-bottom:18px;\"><strong>FILLINGS.</strong> I understand that care must be exercised in chewing on fillings, especially during the first 24 hours to avoid breakage. I understand that a more extensive filling or a crown may be required as additional decay or fracture may become evident after initial excavation. I understand that significant sensitivity is common, but usually temporary, after-effect of a newly placed filling. I further understand that filling a tooth may irritate the nerve tissue creating sensitivity &amp; treating such sensitivity could require root canal therapy or extractions.</p><p style=\"text-align:justify; margin-bottom:18px;\"><strong>DENTURES.</strong> I understand that wearing of dentures can be difficult. Sore spots, altered speech &amp; difficulty in eating are common problems. Immediate dentures (placement of denture immediately after extractions) may be painful. Immediate dentures may require considerable adjusting &amp; several relines. I understand that it is my responsibility to return for delivery of dentures. I understand that failure to keep my delivery appointment may result in poorly fitted dentures. If a remake is required due to my delays of more than 30 days, there will be additional charges. A permanent reline will be needed later, which is not included in the initial fee. I understand that all adjustment or alterations of any kind after this initial period is subject to charges.</p><p style=\"text-align:justify; margin-bottom:18px;\">I understand that dentistry is not an exact science and that no dentist can properly guarantee accurate results all the time.</p><p style=\"text-align:justify; margin-bottom:28px;\">I hereby authorize any of the doctors/dental auxiliaries to proceed with &amp; perform the dental restorations &amp; treatments as explained to me. I understand that these are subject to modification depending on un-diagnosable circumstances that may arise during the course of treatment. I understand that regardless of any dental insurance coverage I may have, I am responsible for payment of dental fees, I agree to pay attorney’s fees, collection fee, or court costs that may be incurred to satisfy any obligation to this office. All treatment was properly explained to me &amp; any untoward circumstances that may arise during the procedure, the attending dentist will not be held liable since it is my free will, with full trust &amp; confidence in him/her, to undergo dental treatment under his/her care.</p><div style=\"display:flex; justify-content:space-between; gap:32px; margin-top:48px;\"><div style=\"flex:1; border-top:1px solid #111827; padding-top:8px; text-align:center;\">Patient Signature</div><div style=\"flex:1; border-top:1px solid #111827; padding-top:8px; text-align:center;\">Date</div></div></div>', '2026-03-26 06:39:40', '2026-03-26 06:39:40');

-- --------------------------------------------------------

--
-- Table structure for table `patient_medical_history`
--

CREATE TABLE `patient_medical_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  `good_health` varchar(3) DEFAULT NULL,
  `under_treatment` varchar(3) DEFAULT NULL,
  `treatment_condition` text DEFAULT NULL,
  `serious_illness` varchar(3) DEFAULT NULL,
  `serious_illness_details` text DEFAULT NULL,
  `hospitalized` varchar(3) DEFAULT NULL,
  `hospitalized_reason` text DEFAULT NULL,
  `medication` varchar(3) DEFAULT NULL,
  `medication_details` text DEFAULT NULL,
  `tobacco` varchar(3) DEFAULT NULL,
  `alcohol_drugs` varchar(3) DEFAULT NULL,
  `allergic` varchar(3) DEFAULT NULL,
  `bleeding_time` varchar(100) DEFAULT NULL,
  `pregnant` varchar(3) DEFAULT NULL,
  `nursing` varchar(3) DEFAULT NULL,
  `birth_control` varchar(3) DEFAULT NULL,
  `blood_type` varchar(20) DEFAULT NULL,
  `blood_pressure` varchar(50) DEFAULT NULL,
  `allergies_json` longtext DEFAULT NULL,
  `conditions_json` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_medical_history`
--

INSERT INTO `patient_medical_history` (`id`, `patient_id`, `good_health`, `under_treatment`, `treatment_condition`, `serious_illness`, `serious_illness_details`, `hospitalized`, `hospitalized_reason`, `medication`, `medication_details`, `tobacco`, `alcohol_drugs`, `allergic`, `bleeding_time`, `pregnant`, `nursing`, `birth_control`, `blood_type`, `blood_pressure`, `allergies_json`, `conditions_json`, `created_at`, `updated_at`) VALUES
(1, 'PT-A845812E', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"Penicillin, Antibiotics\",\"Aspirin\"]', '[\"High Blood Pressure\",\"Heart Attack\",\"Stomach Troubles \\/ Ulcers\"]', '2026-03-25 10:33:37', '2026-03-25 10:33:37'),
(2, 'PT-7AB5F857', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', '[]', '2026-03-26 06:36:27', '2026-03-26 06:36:27');

-- --------------------------------------------------------

--
-- Table structure for table `patient_photos`
--

CREATE TABLE `patient_photos` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  `file_path` text NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'dentist');

-- --------------------------------------------------------

--
-- Table structure for table `treatments`
--

CREATE TABLE `treatments` (
  `id` int(10) UNSIGNED NOT NULL,
  `treatment_id` varchar(8) NOT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `service_id` varchar(8) NOT NULL,
  `treatment_date` date NOT NULL,
  `tooth_number` varchar(100) DEFAULT NULL,
  `other_treatments` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `item_quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `appliances` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `amount_charge` decimal(12,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_status` enum('Paid','Partial','Unpaid') NOT NULL DEFAULT 'Unpaid',
  `balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `dentist` varchar(150) DEFAULT NULL,
  `treatment_note` text DEFAULT NULL,
  `status` enum('Scheduled','In Progress','Complete','Cancelled') NOT NULL DEFAULT 'Scheduled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatments`
--

INSERT INTO `treatments` (`id`, `treatment_id`, `patient_id`, `patient_name`, `service_id`, `treatment_date`, `tooth_number`, `other_treatments`, `description`, `item`, `item_quantity`, `appliances`, `amount`, `amount_charge`, `paid`, `payment_status`, `balance`, `dentist`, `treatment_note`, `status`, `created_at`, `updated_at`) VALUES
(1, 'f4584855', 'PT-7AB5F857', 'Thomas  Shelbs', '28569d15', '2026-03-26', '12', 'Endodontic Treatment - Root Canal Therapy - 2nd Visit', '', '', 1, '', 1000.00, 1000.00, 0.00, 'Unpaid', 1000.00, '0', '', 'Scheduled', '2026-03-26 06:40:46', '2026-03-26 06:40:46');

-- --------------------------------------------------------

--
-- Table structure for table `treatment_services`
--

CREATE TABLE `treatment_services` (
  `service_id` varchar(8) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `item_id` varchar(50) DEFAULT NULL,
  `item_used` varchar(255) DEFAULT NULL,
  `appliance` varchar(255) DEFAULT NULL,
  `base_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `requires_tooth` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment_services`
--

INSERT INTO `treatment_services` (`service_id`, `service_name`, `category`, `item_id`, `item_used`, `appliance`, `base_price`, `requires_tooth`, `is_active`, `created_at`, `updated_at`) VALUES
('210a906f', 'Composite Filling - Class 5', 'Restorative Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('228ce7c7', 'Composite Filling - Class 1', 'Restorative Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('28569d15', 'Root Canal Therapy - 2nd Visit', 'Endodontic Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('292f4ed8', 'Root Canal Therapy - 4th Visit', 'Endodontic Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('2db6435d', 'Moderate Tooth Extraction', 'Oral Surgery', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('2e33c6e8', 'Root Canal Therapy - 3rd Visit', 'Endodontic Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('32b36c5f', 'Fixed Bridge - PFM (Porcelain Fused to Metal)', 'Prosthodontic Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('3993cafd', 'Root Canal Therapy - 1st Visit', 'Endodontic Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('4541406b', 'Fixed Bridge - Emax', 'Prosthodontic Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('59df6277', 'Composite Filling - Class 4', 'Restorative Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('5bc5b7d4', 'Fixed Bridge - Plastic / Temporary Crown', 'Prosthodontic Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('5dd78589', 'CROWNS - PFM (Porcelain Fused to metal)', 'Prosthodontic Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('61457bc8', 'Root Canal Therapy - 5th Visit', 'Endodontic Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('707df6a0', 'Indirect Filling - Onlays', 'Restorative Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('747ae024', 'Indirect Filling - Inlays', 'Restorative Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('7c97f0ba', 'Simple Tooth Extraction', 'Oral Surgery', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('88f175a8', 'Composite Filling - Class 6', 'Restorative Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('8b1c4192', 'Severe Tooth Extraction', 'Oral Surgery', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('94342997', 'Pulpotomy', 'Endodontic Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('9b7b1fae', 'Root Canal Therapy - Obturation', 'Endodontic Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('a63d5b57', 'Composite Veneers', 'Cosmetic Dental Procedure', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('b4b19483', 'Scaling & Polishing', 'Periodontal Treatment', NULL, NULL, NULL, 0.00, 0, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('c42eb30d', 'Teeth Whitening', 'Cosmetic Dental Procedure', NULL, NULL, NULL, 0.00, 0, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('cc13be4c', 'Pulpectomy', 'Endodontic Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('dcb1faef', 'Composite Filling - Class 3', 'Restorative Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('e2927e88', 'Composite Filling - Class 2', 'Restorative Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47'),
('ec2f23a3', 'Fixed Bridge - Zirconia', 'Prosthodontic Treatment', NULL, NULL, NULL, 0.00, 1, 1, '2026-03-26 04:05:47', '2026-03-26 04:05:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `first_name`, `last_name`, `email`, `password_hash`, `created_at`, `updated_at`) VALUES
(1, 1, 'System', 'Admin', 'admin@gmail.com', '$2y$10$SX1cR8oNaEc27MNlfIfWxOoyEpJkciPzU7thtZ5fdtpyVcA8iKMKO', '2026-03-22 02:43:20', '2026-03-22 03:41:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_appointments_appointment_id` (`appointment_id`),
  ADD KEY `idx_appointments_patient_id` (`patient_id`),
  ADD KEY `idx_appointments_datetime` (`appointment_datetime`),
  ADD KEY `idx_appointments_status` (`status`);

--
-- Indexes for table `appointment_reminder_logs`
--
ALTER TABLE `appointment_reminder_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_appointment_reminder_type` (`appointment_id`,`reminder_type`),
  ADD KEY `idx_reminder_patient_id` (`patient_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_patients_name` (`last_name`,`first_name`),
  ADD KEY `idx_patients_email` (`email`),
  ADD KEY `idx_patients_mobile` (`mobile_no`);

--
-- Indexes for table `patient_files`
--
ALTER TABLE `patient_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_patient_files_patient_id` (`patient_id`);

--
-- Indexes for table `patient_forms`
--
ALTER TABLE `patient_forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_patient_forms_patient_id` (`patient_id`);

--
-- Indexes for table `patient_medical_history`
--
ALTER TABLE `patient_medical_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_patient_medical_history_patient_id` (`patient_id`);

--
-- Indexes for table `patient_photos`
--
ALTER TABLE `patient_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_patient_photos_patient_id` (`patient_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_treatments_treatment_id` (`treatment_id`),
  ADD KEY `idx_treatments_patient_id` (`patient_id`),
  ADD KEY `idx_treatments_service_id` (`service_id`),
  ADD KEY `idx_treatments_date` (`treatment_date`),
  ADD KEY `idx_treatments_status` (`status`),
  ADD KEY `idx_treatments_payment_status` (`payment_status`);

--
-- Indexes for table `treatment_services`
--
ALTER TABLE `treatment_services`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `idx_treatment_services_category` (`category`),
  ADD KEY `idx_treatment_services_active` (`is_active`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `appointment_reminder_logs`
--
ALTER TABLE `appointment_reminder_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_files`
--
ALTER TABLE `patient_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `patient_forms`
--
ALTER TABLE `patient_forms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patient_medical_history`
--
ALTER TABLE `patient_medical_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patient_photos`
--
ALTER TABLE `patient_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `treatments`
--
ALTER TABLE `treatments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_appointments_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `patient_files`
--
ALTER TABLE `patient_files`
  ADD CONSTRAINT `fk_patient_files_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_forms`
--
ALTER TABLE `patient_forms`
  ADD CONSTRAINT `fk_patient_forms_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_medical_history`
--
ALTER TABLE `patient_medical_history`
  ADD CONSTRAINT `fk_patient_medical_history_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_photos`
--
ALTER TABLE `patient_photos`
  ADD CONSTRAINT `patient_photos_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `treatments`
--
ALTER TABLE `treatments`
  ADD CONSTRAINT `fk_treatments_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_treatments_service` FOREIGN KEY (`service_id`) REFERENCES `treatment_services` (`service_id`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
