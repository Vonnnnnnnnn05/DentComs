<?php
include '../config/sessions.php';
include '../config/conn.php';

function appointmentsTableSql(): string
{
    return "CREATE TABLE IF NOT EXISTS appointments (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        date_of_entry DATE NOT NULL,
        appointment_id VARCHAR(20) NOT NULL,
        patient_id VARCHAR(50) DEFAULT NULL,
        patient_name VARCHAR(255) NOT NULL,
        phone VARCHAR(50) DEFAULT NULL,
        is_vip TINYINT(1) NOT NULL DEFAULT 0,
        priority ENUM('Low','Normal','High','Urgent') DEFAULT 'Normal',
        purpose_of_visit VARCHAR(255) DEFAULT NULL,
        appointment_notes TEXT DEFAULT NULL,
        dentist VARCHAR(150) DEFAULT NULL,
        appointment_datetime DATETIME NOT NULL,
        status ENUM('Pending','Confirmed','Complete','Cancelled','No Show','Rescheduled') NOT NULL DEFAULT 'Pending',
        cancel_reason TEXT DEFAULT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY uniq_appointments_appointment_id (appointment_id),
        KEY idx_appointments_patient_id (patient_id),
        KEY idx_appointments_datetime (appointment_datetime),
        KEY idx_appointments_status (status),
        CONSTRAINT fk_appointments_patient FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
}

function ensureAppointmentsTable(mysqli $conn): bool
{
    return mysqli_query($conn, appointmentsTableSql()) !== false;
}

$monthParam = trim($_GET['month'] ?? date('Y-m'));
if (!preg_match('/^\d{4}-\d{2}$/', $monthParam)) {
    $monthParam = date('Y-m');
}

$monthStart = DateTime::createFromFormat('Y-m-d H:i:s', $monthParam . '-01 00:00:00');
if (!$monthStart) {
    $monthStart = new DateTime(date('Y-m-01 00:00:00'));
}

$monthEnd = clone $monthStart;
$monthEnd->modify('first day of next month');

$appointmentsByDay = [];
$calendarError = '';
if (ensureAppointmentsTable($conn)) {
    $startString = $monthStart->format('Y-m-d H:i:s');
    $endString = $monthEnd->format('Y-m-d H:i:s');

    $stmt = mysqli_prepare(
        $conn,
        'SELECT id, date_of_entry, appointment_id, patient_id, patient_name, phone, purpose_of_visit, appointment_notes, dentist, appointment_datetime, status, priority, is_vip, cancel_reason
         FROM appointments
         WHERE appointment_datetime >= ? AND appointment_datetime < ?
         ORDER BY appointment_datetime ASC, id ASC'
    );

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ss', $startString, $endString);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = $result ? mysqli_fetch_assoc($result) : null) {
            $day = (int) date('j', strtotime((string) $row['appointment_datetime']));
            $appointmentsByDay[$day][] = $row;
        }

        mysqli_stmt_close($stmt);
    } else {
        $calendarError = 'Unable to load appointments for calendar.';
    }
} else {
    $calendarError = 'Unable to prepare appointments table.';
}

$calendarMonthLabel = $monthStart->format('F Y');
$firstWeekday = (int) $monthStart->format('w');
$totalDays = (int) $monthStart->format('t');

$prevMonth = (clone $monthStart)->modify('-1 month')->format('Y-m');
$nextMonth = (clone $monthStart)->modify('+1 month')->format('Y-m');

$activeNav = 'appointments.php';
$pageTitle = 'Dentcoms | Appointment Calendar';
$pageContentFile = __DIR__ . '/partials/appointments-calendar-content.php';

include '../includes/adminsb.php';