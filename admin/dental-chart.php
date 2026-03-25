<?php
include '../config/sessions.php';
include '../config/conn.php';

$patientId = trim((string) ($_GET['id'] ?? ''));
$selectedPatient = null;
$patientList = [];

$listResult = mysqli_query(
	$conn,
	"SELECT id, first_name, middle_name, last_name FROM patients ORDER BY created_at DESC, id DESC LIMIT 200"
);

while ($row = $listResult ? mysqli_fetch_assoc($listResult) : null) {
	$patientList[] = $row;
}

if ($patientId !== '') {
	$stmt = mysqli_prepare($conn, 'SELECT * FROM patients WHERE id = ? LIMIT 1');
	if ($stmt) {
		mysqli_stmt_bind_param($stmt, 's', $patientId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$selectedPatient = $result ? mysqli_fetch_assoc($result) : null;
		mysqli_stmt_close($stmt);
	}
}

if (!$selectedPatient) {
	$result = mysqli_query($conn, 'SELECT * FROM patients ORDER BY created_at DESC, id DESC LIMIT 1');
	$selectedPatient = $result ? mysqli_fetch_assoc($result) : null;
	if ($selectedPatient) {
		$patientId = (string) ($selectedPatient['id'] ?? '');
	}
}

$activeNav = 'dental-chart.php';
$pageTitle = 'Dentcoms | Dental Chart';
$pageContentFile = __DIR__ . '/partials/dental-chart-content.php';

include '../includes/adminsb.php';