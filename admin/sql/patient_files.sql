CREATE TABLE IF NOT EXISTS `patient_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(50) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `file_label` varchar(255) DEFAULT NULL,
  `file_path` text NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_size` int(10) unsigned DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_patient_files_patient_id` (`patient_id`),
  CONSTRAINT `fk_patient_files_patient`
    FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
