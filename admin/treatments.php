<?php
include '../config/sessions.php';
include '../config/conn.php';

function tableExists(mysqli $conn, string $tableName): bool
{
    $safeTable = mysqli_real_escape_string($conn, $tableName);
    $result = mysqli_query($conn, "SHOW TABLES LIKE '{$safeTable}'");
    return $result instanceof mysqli_result && mysqli_num_rows($result) > 0;
}

function formatPatientName(array $patient): string
{
    $fullName = trim(
        (string) ($patient['first_name'] ?? '') . ' ' .
             (string) ($patient['middle_name'] ?? '') . ' ' .
        (string) ($patient['last_name'] ?? '')
    );

    return $fullName !== '' ? $fullName : (string) ($patient['id'] ?? 'Unknown Patient');
}

function buildTreatmentId(): string
{
    try {
        return substr(bin2hex(random_bytes(4)), 0, 8);
    } catch (Exception $e) {
        return substr(md5((string) microtime(true)), 0, 8);
    }
}

function normalizeTreatmentInput(array $input): array
{
    return [
        'treatment_date' => trim((string) ($input['treatment_date'] ?? '')),
        'patient_id' => trim((string) ($input['patient_id'] ?? '')),
        'tooth_number' => trim((string) ($input['tooth_number'] ?? '')),
        'category' => trim((string) ($input['category'] ?? '')),
        'service_id' => trim((string) ($input['service_id'] ?? '')),
        'description' => trim((string) ($input['description'] ?? '')),
        'amount_charge' => trim((string) ($input['amount_charge'] ?? '')),
        'payment_status' => trim((string) ($input['payment_status'] ?? 'Unpaid')),
        'dentist' => trim((string) ($input['dentist'] ?? '')),
        'status' => trim((string) ($input['status'] ?? 'Scheduled')),
        'treatment_note' => trim((string) ($input['treatment_note'] ?? '')),
    ];
}

$hasTreatmentServicesTable = tableExists($conn, 'treatment_services');
$hasTreatmentsTable = tableExists($conn, 'treatments');

$schemaWarning = '';
if (!$hasTreatmentsTable || !$hasTreatmentServicesTable) {
    $schemaWarning = 'Treatments tables are not available yet. Run admin/sql/treatments.sql first to load the Treatments Plans data.';
}

$successMessage = '';
$errorMessage = '';
$openTreatmentModal = false;
$isViewTreatmentsPage = (string) ($_GET['view'] ?? '') === 'treatments';
$treatmentFormValues = normalizeTreatmentInput($_POST);

$patientDirectory = [];
$patientDirectoryResult = mysqli_query(
    $conn,
    'SELECT id, first_name, middle_name, last_name
     FROM patients
     ORDER BY first_name ASC, last_name ASC, id ASC'
);

while ($row = $patientDirectoryResult ? mysqli_fetch_assoc($patientDirectoryResult) : null) {
    $fullName = trim(
        (string) ($row['first_name'] ?? '') . ' ' .
        (string) ($row['middle_name'] ?? '') . ' ' .
        (string) ($row['last_name'] ?? '')
    );

    if ($fullName === '') {
        $fullName = (string) ($row['id'] ?? '');
    }

    $row['display_name'] = $fullName;
    $patientDirectory[] = $row;
}

$serviceCatalog = [];
$categoryOptions = [];
$dentistOptions = [];

if ($hasTreatmentServicesTable) {
    $servicesResult = mysqli_query(
        $conn,
        'SELECT service_id, service_name, category, requires_tooth
         FROM treatment_services
         WHERE is_active = 1
         ORDER BY category ASC, service_name ASC'
    );

    while ($row = $servicesResult ? mysqli_fetch_assoc($servicesResult) : null) {
        $serviceCatalog[] = $row;
        $categoryOptions[(string) ($row['category'] ?? '')] = true;
    }
}

if ($hasTreatmentsTable) {
    $dentistResult = mysqli_query(
        $conn,
        'SELECT DISTINCT dentist
         FROM treatments
         WHERE dentist IS NOT NULL AND dentist <> ""
         ORDER BY dentist ASC'
    );

    while ($row = $dentistResult ? mysqli_fetch_assoc($dentistResult) : null) {
        $value = trim((string) ($row['dentist'] ?? ''));
        if ($value !== '') {
            $dentistOptions[$value] = true;
        }
    }
}

$dentistOptions['Dr. Ariel Go'] = true;
$dentistOptions['Dr. Kannah Okamoto'] = true;
ksort($dentistOptions);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (string) ($_POST['action'] ?? '') === 'create_treatment') {
    $openTreatmentModal = true;

    if (!$hasTreatmentsTable || !$hasTreatmentServicesTable) {
        $errorMessage = 'Unable to save treatment because treatment tables are missing.';
    } elseif ($treatmentFormValues['treatment_date'] === '' || $treatmentFormValues['service_id'] === '' || $treatmentFormValues['patient_id'] === '') {
        $errorMessage = 'Treatment date, patient, and treatment name are required.';
    } else {
        $allowedPaymentStatus = ['Paid', 'Partial', 'Unpaid'];
        $allowedStatus = ['Scheduled', 'In Progress', 'Complete', 'Cancelled'];

        if (!in_array($treatmentFormValues['payment_status'], $allowedPaymentStatus, true)) {
            $treatmentFormValues['payment_status'] = 'Unpaid';
        }

        if (!in_array($treatmentFormValues['status'], $allowedStatus, true)) {
            $treatmentFormValues['status'] = 'Scheduled';
        }

        $amountCharge = is_numeric($treatmentFormValues['amount_charge'])
            ? max(0, (float) $treatmentFormValues['amount_charge'])
            : -1;

        if ($amountCharge < 0) {
            $errorMessage = 'Amount charged must be a valid positive number.';
        }

        $patientName = '';
        if ($errorMessage === '') {
            $patientStmt = mysqli_prepare(
                $conn,
                'SELECT first_name, middle_name, last_name FROM patients WHERE id = ? LIMIT 1'
            );

            if ($patientStmt) {
                mysqli_stmt_bind_param($patientStmt, 's', $treatmentFormValues['patient_id']);
                mysqli_stmt_execute($patientStmt);
                $patientResult = mysqli_stmt_get_result($patientStmt);
                $patientRow = $patientResult ? mysqli_fetch_assoc($patientResult) : null;
                mysqli_stmt_close($patientStmt);

                if ($patientRow) {
                    $patientName = trim(
                        (string) ($patientRow['first_name'] ?? '') . ' ' .
                        (string) ($patientRow['middle_name'] ?? '') . ' ' .
                        (string) ($patientRow['last_name'] ?? '')
                    );
                }
            }

            if ($patientName === '') {
                $errorMessage = 'Selected patient was not found.';
            }
        }

        $selectedService = null;
        if ($errorMessage === '') {
            foreach ($serviceCatalog as $service) {
                if ((string) ($service['service_id'] ?? '') === $treatmentFormValues['service_id']) {
                    $selectedService = $service;
                    break;
                }
            }

            if (!$selectedService) {
                $errorMessage = 'Selected treatment name is invalid.';
            }
        }

        if ($errorMessage === '' && (int) ($selectedService['requires_tooth'] ?? 0) === 1 && $treatmentFormValues['tooth_number'] === '') {
            $errorMessage = 'Tooth number is required for this treatment.';
        }

        if ($errorMessage === '') {
            $paid = 0.00;
            $balance = $amountCharge;

            if ($treatmentFormValues['payment_status'] === 'Paid') {
                $paid = $amountCharge;
                $balance = 0.00;
            }

            $serviceName = (string) ($selectedService['service_name'] ?? '');
            $category = (string) ($selectedService['category'] ?? '');
            if ($treatmentFormValues['category'] !== '' && $treatmentFormValues['category'] !== $category) {
                $category = $treatmentFormValues['category'];
            }

            $insertStmt = mysqli_prepare(
                $conn,
                'INSERT INTO treatments (
                    treatment_id,
                    patient_id,
                    patient_name,
                    service_id,
                    treatment_date,
                    tooth_number,
                    description,
                 
                    item_quantity,
                    appliances,
                    amount,
                    amount_charge,
                    paid,
                    payment_status,
                    balance,
                    dentist,
                    treatment_note,
                    status,
                    other_treatments
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );

            if (!$insertStmt) {
                $errorMessage = 'Unable to prepare treatment save query.';
            } else {
                $treatmentId = buildTreatmentId();
                $toothNumber = $treatmentFormValues['tooth_number'];
                $description = $treatmentFormValues['description'];
                $item = '';
                $itemQty = 1;
                $appliances = '';
                $amount = $amountCharge;
                $amountChargeValue = $amountCharge;
                $paidValue = $paid;
                $paymentStatus = $treatmentFormValues['payment_status'];
                $balanceValue = $balance;
                $dentist = $treatmentFormValues['dentist'];
                $treatmentNote = $treatmentFormValues['treatment_note'];
                $status = $treatmentFormValues['status'];
                $otherTreatments = $category . ($serviceName !== '' ? ' - ' . $serviceName : '');

                mysqli_stmt_bind_param(
                    $insertStmt,
                    'ssssssssisdddssdsss',
                    $treatmentId,
                    $treatmentFormValues['patient_id'],
                    $patientName,
                    $treatmentFormValues['service_id'],
                    $treatmentFormValues['treatment_date'],
                    $toothNumber,
                    $description,
                    $item,
                    $itemQty,
                    $appliances,
                    $amount,
                    $amountChargeValue,
                    $paidValue,
                    $paymentStatus,
                    $balanceValue,
                    $dentist,
                    $treatmentNote,
                    $status,
                    $otherTreatments
                );

                if (mysqli_stmt_execute($insertStmt)) {
                    mysqli_stmt_close($insertStmt);
                    $redirect = 'treatments.php?patient_id=' . rawurlencode($treatmentFormValues['patient_id']) . '&saved=1';
                    header('Location: ' . $redirect);
                    exit();
                }

                $errorMessage = 'Unable to save treatment. ' . mysqli_error($conn);
                mysqli_stmt_close($insertStmt);
            }
        }
    }
}

if (isset($_GET['saved']) && $_GET['saved'] === '1') {
    $successMessage = 'Treatment has been added successfully.';
}

$patients = [];
$selectedPatientId = trim((string) ($_GET['patient_id'] ?? $_GET['id'] ?? ''));
$selectedPatientName = trim((string) ($_GET['patient_name'] ?? ''));
$isPatientFiltered = (string) ($_GET['filtered'] ?? '') === '1';
$allowedPerPage = [10, 20];
$treatmentPerPage = (int) ($_GET['per_page'] ?? 10);
if (!in_array($treatmentPerPage, $allowedPerPage, true)) {
    $treatmentPerPage = 10;
}
$treatmentCurrentPage = max(1, (int) ($_GET['page'] ?? 1));
$totalPatientTreatments = 0;
$totalTreatmentPages = 1;
$selectedPatient = null;
$patientTreatments = [];

if ($hasTreatmentsTable) {
    $patientListSql = "
        SELECT
            p.id AS patient_id,
            '' AS patient_name,
            MAX(t.treatment_date) AS latest_treatment_date,
            COUNT(t.id) AS treatment_count,
            p.first_name,
            p.middle_name,
            p.last_name,
            p.mobile_no,
            p.email,
            p.home_address,
            p.photo,
            p.date_registered,
            p.created_at
        FROM patients p
        LEFT JOIN treatments t ON t.patient_id = p.id
        GROUP BY
            p.id,
            p.first_name,
            p.middle_name,
            p.last_name,
            p.mobile_no,
            p.email,
            p.home_address,
            p.photo,
            p.date_registered,
            p.created_at
        ORDER BY COALESCE(MAX(t.treatment_date), p.date_registered, DATE(p.created_at)) DESC, p.created_at DESC
        LIMIT 300
    ";

    $patientListResult = mysqli_query($conn, $patientListSql);
    while ($row = $patientListResult ? mysqli_fetch_assoc($patientListResult) : null) {
        $row['patient_id'] = (string) ($row['patient_id'] ?? '');
        $row['patient_name'] = '';
        $row['display_name'] = formatPatientName($row);

        if ($row['display_name'] === '') {
            $row['display_name'] = 'Unknown Patient';
        }

        $patients[] = $row;
    }
}

if (empty($patients)) {
    $fallbackSql = "
        SELECT
            p.id AS patient_id,
            '' AS patient_name,
            NULL AS latest_treatment_date,
            0 AS treatment_count,
            p.first_name,
            p.middle_name,
            p.last_name,
            p.mobile_no,
            p.email,
            p.home_address,
            p.photo,
            p.date_registered,
            p.created_at
        FROM patients p
        ORDER BY p.created_at DESC
        LIMIT 300
    ";

    $fallbackResult = mysqli_query($conn, $fallbackSql);
    while ($row = $fallbackResult ? mysqli_fetch_assoc($fallbackResult) : null) {
        $row['patient_id'] = (string) ($row['patient_id'] ?? '');
        $row['patient_name'] = '';
        $row['display_name'] = formatPatientName($row);
        $patients[] = $row;
    }
}

if ($selectedPatientId === '' && $selectedPatientName === '' && !empty($patients)) {
    $selectedPatientId = (string) ($patients[0]['patient_id'] ?? '');
    $selectedPatientName = (string) ($patients[0]['patient_name'] ?? '');
}

if ($isPatientFiltered && !empty($patients)) {
    $patients = array_values(array_filter(
        $patients,
        static function (array $row) use ($selectedPatientId, $selectedPatientName): bool {
            $rowId = (string) ($row['patient_id'] ?? '');
            $rowName = trim((string) ($row['display_name'] ?? ''));

            if ($selectedPatientId !== '') {
                return $rowId === $selectedPatientId;
            }

            if ($selectedPatientName !== '') {
                return strcasecmp($rowName, $selectedPatientName) === 0;
            }

            return false;
        }
    ));
}

if ($selectedPatientId !== '') {
    $stmt = mysqli_prepare(
        $conn,
        'SELECT id, first_name, middle_name, last_name, mobile_no, email, home_address, photo, date_registered, created_at
         FROM patients
            WHERE id = ?
         LIMIT 1'
    );

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $selectedPatientId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $selectedPatient = $result ? mysqli_fetch_assoc($result) : null;
        mysqli_stmt_close($stmt);

        if ($selectedPatient && $selectedPatientName === '') {
            $selectedPatientName = trim(
                (string) ($selectedPatient['first_name'] ?? '') . ' ' .
                (string) ($selectedPatient['middle_name'] ?? '') . ' ' .
                (string) ($selectedPatient['last_name'] ?? '')
            );
        }
    }
}

if (!$selectedPatient && $selectedPatientName !== '') {
    $selectedPatient = [
        'id' => '',
        'first_name' => '',
        'middle_name' => '',
        'last_name' => '',
        'mobile_no' => '',
        'email' => '',
        'home_address' => '',
        'photo' => '',
        'date_registered' => '',
        'created_at' => '',
        'display_name' => $selectedPatientName,
    ];
}

if ($hasTreatmentsTable && ($selectedPatientId !== '' || $selectedPatientName !== '')) {
    $countTreatmentsStmt = mysqli_prepare(
        $conn,
        'SELECT COUNT(*) AS total
         FROM treatments t
         WHERE (t.patient_id = ?)
            OR (? <> "" AND (t.patient_id IS NULL OR t.patient_id = "") AND t.patient_name = ?)'
    );

    if ($countTreatmentsStmt) {
        mysqli_stmt_bind_param($countTreatmentsStmt, 'sss', $selectedPatientId, $selectedPatientName, $selectedPatientName);
        mysqli_stmt_execute($countTreatmentsStmt);
        $countResult = mysqli_stmt_get_result($countTreatmentsStmt);
        $countRow = $countResult ? mysqli_fetch_assoc($countResult) : null;
        $totalPatientTreatments = (int) ($countRow['total'] ?? 0);
        mysqli_stmt_close($countTreatmentsStmt);
    }

    if ($totalPatientTreatments > 0) {
        $totalTreatmentPages = (int) ceil($totalPatientTreatments / $treatmentPerPage);
        $treatmentCurrentPage = min($treatmentCurrentPage, $totalTreatmentPages);
    }

    $treatmentOffset = ($treatmentCurrentPage - 1) * $treatmentPerPage;

    $treatmentsStmt = mysqli_prepare(
        $conn,
        'SELECT
            t.id,
            t.treatment_id,
            t.treatment_date,
            t.tooth_number,
            t.description,
            t.patient_name,
            t.amount_charge,
            t.dentist,
            t.treatment_note,
            t.payment_status,
            t.other_treatments,
            t.status,
            ts.category,
            ts.service_name
         FROM treatments t
         LEFT JOIN treatment_services ts ON ts.service_id = t.service_id
         WHERE (t.patient_id = ?)
            OR (? <> "" AND (t.patient_id IS NULL OR t.patient_id = "") AND t.patient_name = ?)
         ORDER BY t.treatment_date DESC, t.id DESC
            LIMIT ? OFFSET ?'
    );

    if ($treatmentsStmt) {
          mysqli_stmt_bind_param($treatmentsStmt, 'sssii', $selectedPatientId, $selectedPatientName, $selectedPatientName, $treatmentPerPage, $treatmentOffset);
        mysqli_stmt_execute($treatmentsStmt);
        $result = mysqli_stmt_get_result($treatmentsStmt);

        while ($row = $result ? mysqli_fetch_assoc($result) : null) {
            $patientTreatments[] = $row;
        }

        mysqli_stmt_close($treatmentsStmt);
    }
}

$activeNav = 'treatments.php';
$pageTitle = $isViewTreatmentsPage
    ? 'Dentcoms | View Treatments'
    : 'Dentcoms | Treatments Plans';
$pageContentFile = __DIR__ . '/partials/treatments-content.php';

include '../includes/adminsb.php';