CREATE TABLE IF NOT EXISTS `patient_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(50) NOT NULL,
  `form_type` varchar(100) NOT NULL,
  `form_date` date NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_patient_forms_patient_id` (`patient_id`),
  CONSTRAINT `fk_patient_forms_patient`
    FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
