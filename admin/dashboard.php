<?php
include '../config/sessions.php';
include '../config/conn.php';

$activeNav = 'dashboard.php';
$pageTitle = 'DentaFlow | Dashboard';

// Live statistics from MySQL with defaults
$totalPatientsCount = 0;
$newTodayCount = 0;
$todayAppointmentsCount = 0;
$totalRevenueAmount = 0;
$todayAppointmentsList = [];

try {
    $res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM patients");
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $totalPatientsCount = (int)$row['cnt'];
    }
} catch (Throwable $e) {}

try {
    $res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM patients WHERE DATE(created_at) = CURDATE() OR DATE(date_registered) = CURDATE()");
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $newTodayCount = (int)$row['cnt'];
    }
} catch (Throwable $e) {}

try {
    $res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM appointments WHERE DATE(appointment_datetime) = CURDATE()");
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $todayAppointmentsCount = (int)$row['cnt'];
    }
} catch (Throwable $e) {}

try {
    $res = mysqli_query($conn, "SELECT SUM(paid) as rev FROM treatments");
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $totalRevenueAmount = (float)($row['rev'] ?? 0);
    }
} catch (Throwable $e) {}

try {
    $res = mysqli_query($conn, "SELECT patient_name, purpose_of_visit, status, TIME_FORMAT(appointment_datetime, '%h:%i %p') AS appt_time FROM appointments WHERE DATE(appointment_datetime) = CURDATE() ORDER BY appointment_datetime ASC LIMIT 6");
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $todayAppointmentsList[] = $row;
        }
    }
} catch (Throwable $e) {}

$pageContentFile = __DIR__ . '/partials/dashboard-cards.php';

include '../includes/adminsb.php';
