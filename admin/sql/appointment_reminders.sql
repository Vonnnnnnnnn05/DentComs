CREATE TABLE IF NOT EXISTS `appointment_reminder_logs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `appointment_id` varchar(20) NOT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `patient_email` varchar(255) NOT NULL,
  `reminder_type` varchar(50) NOT NULL DEFAULT 'day_before',
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_appointment_reminder_type` (`appointment_id`, `reminder_type`),
  KEY `idx_reminder_patient_id` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
