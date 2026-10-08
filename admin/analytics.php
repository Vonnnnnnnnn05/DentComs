<?php
include '../config/sessions.php';
include '../config/conn.php';

$activeNav = 'analytics.php';
$pageTitle = 'DentaFlow | Reporting & Analytics';

// 1. Fetch real treatment figures from DB
$dbTotalBilled = 0;
$dbTotalPaid = 0;
$dbTotalBalance = 0;
$dbTreatmentCount = 0;

try {
    $res = mysqli_query($conn, "SELECT SUM(amount_charge) as billed, SUM(paid) as paid, SUM(balance) as balance, COUNT(*) as cnt FROM treatments");
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $dbTotalBilled = (float)($row['billed'] ?? 0);
        $dbTotalPaid = (float)($row['paid'] ?? 0);
        $dbTotalBalance = (float)($row['balance'] ?? 0);
        $dbTreatmentCount = (int)($row['cnt'] ?? 0);
    }
} catch (Throwable $e) {
    // Graceful fallback if query fails
}

// 2. Fetch real appointment status counts
$appointmentStats = [
    'Completed' => 0,
    'Confirmed' => 0,
    'Pending' => 0,
    'Cancelled' => 0,
    'No Show' => 0,
    'Rescheduled' => 0,
];
$totalAppointments = 0;

try {
    $res = mysqli_query($conn, "SELECT status, COUNT(*) as cnt FROM appointments GROUP BY status");
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $statusKey = $row['status'] ?? '';
            $cnt = (int)$row['cnt'];
            $totalAppointments += $cnt;
            if (isset($appointmentStats[$statusKey])) {
                $appointmentStats[$statusKey] = $cnt;
            } elseif ($statusKey === 'Complete') {
                $appointmentStats['Completed'] = $cnt;
            }
        }
    }
} catch (Throwable $e) {
    // Graceful fallback
}

// 3. Fetch patient counts
$totalPatients = 0;
try {
    $res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM patients");
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $totalPatients = (int)$row['cnt'];
    }
} catch (Throwable $e) {
    // Graceful fallback
}

// 4. Fetch recent treatments with service category joined
$recentTransactions = [];
try {
    $res = mysqli_query($conn, "SELECT t.treatment_id, t.treatment_date, t.patient_name, t.description, COALESCE(s.category, 'General Dental') AS category, t.amount_charge, t.paid, t.balance, t.payment_status, t.dentist FROM treatments t LEFT JOIN treatment_services s ON t.service_id = s.service_id ORDER BY t.treatment_date DESC, t.id DESC LIMIT 15");
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $recentTransactions[] = $row;
        }
    }
} catch (Throwable $e) {
    // Graceful fallback
}

$pageContentFile = __DIR__ . '/partials/analytics-content.php';

include '../includes/adminsb.php';