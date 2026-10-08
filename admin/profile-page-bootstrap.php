<?php
include '../config/sessions.php';
include '../config/conn.php';

$patientId = trim($_GET['id'] ?? '');
$patient = null;
$profileTab = $profileTab ?? 'medical_history';
$profileSuccessMessage = '';
$profileErrorMessage = '';
$uploadedFiles = [];
$patientForms = [];
$patientAppointments = [];
$patientMedicalHistory = [
    'answers' => [],
    'checks' => [
        'allergies' => [],
        'conditions' => [],
    ],
];

function patientFilesTableSql(): string
{
    return "CREATE TABLE IF NOT EXISTS patient_files (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        patient_id VARCHAR(50) NOT NULL,
        file_name VARCHAR(255) NOT NULL,
        original_name VARCHAR(255) DEFAULT NULL,
        file_label VARCHAR(255) DEFAULT NULL,
        file_path TEXT NOT NULL,
        file_type VARCHAR(50) DEFAULT NULL,
        file_size INT UNSIGNED DEFAULT NULL,
        uploaded_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_patient_files_patient_id (patient_id),
        CONSTRAINT fk_patient_files_patient FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
}

function ensurePatientFilesTable(mysqli $conn): bool
{
    if (mysqli_query($conn, patientFilesTableSql()) === false) {
        return false;
    }

    $columnResult = mysqli_query($conn, "SHOW COLUMNS FROM patient_files LIKE 'file_label'");
    if ($columnResult === false) {
        return false;
    }

    $hasLabelColumn = mysqli_num_rows($columnResult) > 0;
    mysqli_free_result($columnResult);

    if (!$hasLabelColumn) {
        if (mysqli_query($conn, "ALTER TABLE patient_files ADD COLUMN file_label VARCHAR(255) DEFAULT NULL AFTER original_name") === false) {
            return false;
        }
    }

    return true;
}

function patientFormsTableSql(): string
{
    return "CREATE TABLE IF NOT EXISTS patient_forms (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        patient_id VARCHAR(50) NOT NULL,
        form_type VARCHAR(100) NOT NULL,
        form_date DATE NOT NULL,
        title VARCHAR(255) DEFAULT NULL,
        content LONGTEXT NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_patient_forms_patient_id (patient_id),
        CONSTRAINT fk_patient_forms_patient FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
}

function ensurePatientFormsTable(mysqli $conn): bool
{
    return mysqli_query($conn, patientFormsTableSql()) !== false;
}

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

function buildAppointmentRef(): string
{
    try {
        return substr(strtolower(bin2hex(random_bytes(4))), 0, 8);
    } catch (Exception $e) {
        return substr(strtolower(md5(uniqid('', true))), 0, 8);
    }
}

function loadPatientAppointments(mysqli $conn, string $patientId): array
{
    if ($patientId === '' || !ensureAppointmentsTable($conn)) {
        return [];
    }

    $items = [];
    $stmt = mysqli_prepare($conn, 'SELECT id, date_of_entry, appointment_id, patient_id, patient_name, phone, is_vip, priority, purpose_of_visit, appointment_notes, dentist, appointment_datetime, status, cancel_reason, created_at, updated_at FROM appointments WHERE patient_id = ? ORDER BY appointment_datetime DESC, id DESC');
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, 's', $patientId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = $result ? mysqli_fetch_assoc($result) : null) {
        $items[] = $row;
    }

    mysqli_stmt_close($stmt);
    return $items;
}

function savePatientAppointment(mysqli $conn, string $patientId, array $input, string &$errorMessage): ?int
{
    if ($patientId === '' || !ensureAppointmentsTable($conn)) {
        $errorMessage = 'Unable to prepare appointments table.';
        return null;
    }

    $dateOfEntry = trim($input['date_of_entry'] ?? date('Y-m-d'));
    $patientName = trim($input['patient_name'] ?? '');
    $phone = trim($input['phone'] ?? '');
    $isVip = isset($input['is_vip']) ? 1 : 0;
    $priority = trim($input['priority'] ?? 'Normal');
    $purpose = trim($input['purpose_of_visit'] ?? '');
    $notes = trim($input['appointment_notes'] ?? '');
    $dentist = trim($input['dentist'] ?? '');
    $appointmentDateTimeRaw = trim($input['appointment_datetime'] ?? '');
    $status = trim($input['status'] ?? 'Pending');
    $cancelReason = trim($input['cancel_reason'] ?? '');

    if ($patientName === '' || $purpose === '' || $dentist === '' || $appointmentDateTimeRaw === '') {
        $errorMessage = 'Patient name, purpose, dentist, and date/time are required.';
        return null;
    }

    $validPriorities = ['Low', 'Normal', 'High', 'Urgent'];
    if (!in_array($priority, $validPriorities, true)) {
        $priority = 'Normal';
    }

    $validStatuses = ['Pending', 'Confirmed', 'Complete', 'Cancelled', 'No Show', 'Rescheduled'];
    if (!in_array($status, $validStatuses, true)) {
        $status = 'Pending';
    }

    try {
        $appointmentDateTime = (new DateTime($appointmentDateTimeRaw))->format('Y-m-d H:i:s');
    } catch (Exception $e) {
        $errorMessage = 'Invalid appointment date and time.';
        return null;
    }

    $appointmentRef = buildAppointmentRef();
    $stmt = mysqli_prepare($conn, 'INSERT INTO appointments (date_of_entry, appointment_id, patient_id, patient_name, phone, is_vip, priority, purpose_of_visit, appointment_notes, dentist, appointment_datetime, status, cancel_reason) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    if (!$stmt) {
        $errorMessage = 'Unable to prepare appointment save.';
        return null;
    }

    mysqli_stmt_bind_param(
        $stmt,
        'sssssisssssss',
        $dateOfEntry,
        $appointmentRef,
        $patientId,
        $patientName,
        $phone,
        $isVip,
        $priority,
        $purpose,
        $notes,
        $dentist,
        $appointmentDateTime,
        $status,
        $cancelReason
    );

    $ok = mysqli_stmt_execute($stmt);
    $newId = $ok ? (int) mysqli_insert_id($conn) : null;
    mysqli_stmt_close($stmt);

    if (!$ok) {
        $errorMessage = 'Unable to save appointment.';
        return null;
    }

    return $newId;
}

function deletePatientAppointment(mysqli $conn, string $patientId, int $appointmentPk, string &$errorMessage): bool
{
    if ($appointmentPk <= 0 || $patientId === '' || !ensureAppointmentsTable($conn)) {
        $errorMessage = 'Unable to prepare appointment delete.';
        return false;
    }

    $stmt = mysqli_prepare($conn, 'DELETE FROM appointments WHERE id = ? AND patient_id = ?');
    if (!$stmt) {
        $errorMessage = 'Unable to prepare appointment delete.';
        return false;
    }

    mysqli_stmt_bind_param($stmt, 'is', $appointmentPk, $patientId);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if (!$ok) {
        $errorMessage = 'Unable to delete appointment.';
        return false;
    }

    return true;
}

function patientMedicalHistoryTableSql(): string
{
    return "CREATE TABLE IF NOT EXISTS patient_medical_history (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        patient_id VARCHAR(50) NOT NULL,
        good_health VARCHAR(3) DEFAULT NULL,
        under_treatment VARCHAR(3) DEFAULT NULL,
        treatment_condition TEXT DEFAULT NULL,
        serious_illness VARCHAR(3) DEFAULT NULL,
        serious_illness_details TEXT DEFAULT NULL,
        hospitalized VARCHAR(3) DEFAULT NULL,
        hospitalized_reason TEXT DEFAULT NULL,
        medication VARCHAR(3) DEFAULT NULL,
        medication_details TEXT DEFAULT NULL,
        tobacco VARCHAR(3) DEFAULT NULL,
        alcohol_drugs VARCHAR(3) DEFAULT NULL,
        allergic VARCHAR(3) DEFAULT NULL,
        bleeding_time VARCHAR(100) DEFAULT NULL,
        pregnant VARCHAR(3) DEFAULT NULL,
        nursing VARCHAR(3) DEFAULT NULL,
        birth_control VARCHAR(3) DEFAULT NULL,
        blood_type VARCHAR(20) DEFAULT NULL,
        blood_pressure VARCHAR(50) DEFAULT NULL,
        allergies_json LONGTEXT DEFAULT NULL,
        conditions_json LONGTEXT DEFAULT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY uniq_patient_medical_history_patient_id (patient_id),
        CONSTRAINT fk_patient_medical_history_patient FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
}

function ensurePatientMedicalHistoryTable(mysqli $conn): bool
{
    return mysqli_query($conn, patientMedicalHistoryTableSql()) !== false;
}

function defaultMedicalHistoryState(): array
{
    return [
        'answers' => [],
        'checks' => [
            'allergies' => [],
            'conditions' => [],
        ],
    ];
}

function loadPatientMedicalHistory(mysqli $conn, string $patientId): array
{
    if ($patientId === '' || !ensurePatientMedicalHistoryTable($conn)) {
        return defaultMedicalHistoryState();
    }

    $stmt = mysqli_prepare($conn, 'SELECT * FROM patient_medical_history WHERE patient_id = ? LIMIT 1');
    if (!$stmt) {
        return defaultMedicalHistoryState();
    }

    mysqli_stmt_bind_param($stmt, 's', $patientId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = $result ? mysqli_fetch_assoc($result) : null;
    mysqli_stmt_close($stmt);

    if (!$row) {
        return defaultMedicalHistoryState();
    }

    $answerFields = [
        'good_health',
        'under_treatment',
        'treatment_condition',
        'serious_illness',
        'serious_illness_details',
        'hospitalized',
        'hospitalized_reason',
        'medication',
        'medication_details',
        'tobacco',
        'alcohol_drugs',
        'allergic',
        'bleeding_time',
        'pregnant',
        'nursing',
        'birth_control',
        'blood_type',
        'blood_pressure',
    ];

    $answers = [];
    foreach ($answerFields as $field) {
        $value = $row[$field] ?? null;
        $answers[$field] = $value === null ? '' : (string) $value;
    }

    $allergies = json_decode((string) ($row['allergies_json'] ?? '[]'), true);
    $conditions = json_decode((string) ($row['conditions_json'] ?? '[]'), true);

    return [
        'answers' => $answers,
        'checks' => [
            'allergies' => is_array($allergies) ? array_values($allergies) : [],
            'conditions' => is_array($conditions) ? array_values($conditions) : [],
        ],
    ];
}

function savePatientMedicalHistory(mysqli $conn, string $patientId, string $payloadJson, string &$errorMessage): bool
{
    if ($patientId === '' || !ensurePatientMedicalHistoryTable($conn)) {
        $errorMessage = 'Unable to prepare the patient medical history table.';
        return false;
    }

    $payload = json_decode($payloadJson, true);
    if (!is_array($payload)) {
        $errorMessage = 'Invalid medical history payload.';
        return false;
    }

    $answers = is_array($payload['answers'] ?? null) ? $payload['answers'] : [];
    $checks = is_array($payload['checks'] ?? null) ? $payload['checks'] : [];

    $yesNoFields = [
        'good_health',
        'under_treatment',
        'serious_illness',
        'hospitalized',
        'medication',
        'tobacco',
        'alcohol_drugs',
        'allergic',
        'pregnant',
        'nursing',
        'birth_control',
    ];

    $textFields = [
        'treatment_condition',
        'serious_illness_details',
        'hospitalized_reason',
        'medication_details',
        'bleeding_time',
        'blood_type',
        'blood_pressure',
    ];

    $normalized = [];
    foreach ($yesNoFields as $field) {
        $value = strtolower(trim((string) ($answers[$field] ?? '')));
        $normalized[$field] = in_array($value, ['yes', 'no'], true) ? $value : null;
    }

    foreach ($textFields as $field) {
        $value = trim((string) ($answers[$field] ?? ''));
        $normalized[$field] = $value === '' ? null : $value;
    }

    $allergies = is_array($checks['allergies'] ?? null) ? array_values(array_filter(array_map('strval', $checks['allergies']), static fn($v) => trim($v) !== '')) : [];
    $conditions = is_array($checks['conditions'] ?? null) ? array_values(array_filter(array_map('strval', $checks['conditions']), static fn($v) => trim($v) !== '')) : [];

    $allergiesJson = json_encode($allergies, JSON_UNESCAPED_UNICODE);
    $conditionsJson = json_encode($conditions, JSON_UNESCAPED_UNICODE);

    $sql = 'INSERT INTO patient_medical_history (
                patient_id, good_health, under_treatment, treatment_condition, serious_illness, serious_illness_details,
                hospitalized, hospitalized_reason, medication, medication_details, tobacco, alcohol_drugs, allergic,
                bleeding_time, pregnant, nursing, birth_control, blood_type, blood_pressure, allergies_json, conditions_json
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                good_health = VALUES(good_health),
                under_treatment = VALUES(under_treatment),
                treatment_condition = VALUES(treatment_condition),
                serious_illness = VALUES(serious_illness),
                serious_illness_details = VALUES(serious_illness_details),
                hospitalized = VALUES(hospitalized),
                hospitalized_reason = VALUES(hospitalized_reason),
                medication = VALUES(medication),
                medication_details = VALUES(medication_details),
                tobacco = VALUES(tobacco),
                alcohol_drugs = VALUES(alcohol_drugs),
                allergic = VALUES(allergic),
                bleeding_time = VALUES(bleeding_time),
                pregnant = VALUES(pregnant),
                nursing = VALUES(nursing),
                birth_control = VALUES(birth_control),
                blood_type = VALUES(blood_type),
                blood_pressure = VALUES(blood_pressure),
                allergies_json = VALUES(allergies_json),
                conditions_json = VALUES(conditions_json)';

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        $errorMessage = 'Unable to prepare medical history save.';
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        'sssssssssssssssssssss',
        $patientId,
        $normalized['good_health'],
        $normalized['under_treatment'],
        $normalized['treatment_condition'],
        $normalized['serious_illness'],
        $normalized['serious_illness_details'],
        $normalized['hospitalized'],
        $normalized['hospitalized_reason'],
        $normalized['medication'],
        $normalized['medication_details'],
        $normalized['tobacco'],
        $normalized['alcohol_drugs'],
        $normalized['allergic'],
        $normalized['bleeding_time'],
        $normalized['pregnant'],
        $normalized['nursing'],
        $normalized['birth_control'],
        $normalized['blood_type'],
        $normalized['blood_pressure'],
        $allergiesJson,
        $conditionsJson
    );

    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if (!$ok) {
        $errorMessage = 'Unable to save medical history.';
        return false;
    }

    return true;
}

function patientGalleryDirectory(string $patientId): string
{
    return dirname(__DIR__) . '/uploads/patient-files/' . preg_replace('/[^A-Za-z0-9_-]/', '', $patientId);
}

function patientGalleryWebPath(string $patientId, string $fileName): string
{
    $safePatientId = preg_replace('/[^A-Za-z0-9_-]/', '', $patientId);
    return 'uploads/patient-files/' . $safePatientId . '/' . $fileName;
}

function loadPatientFiles(mysqli $conn, string $patientId): array
{
    if ($patientId === '') {
        return [];
    }

    if (!ensurePatientFilesTable($conn)) {
        return [];
    }

    $files = [];
    $stmt = mysqli_prepare($conn, 'SELECT id, file_name, original_name, file_label, file_path, file_type, file_size, uploaded_at FROM patient_files WHERE patient_id = ? ORDER BY uploaded_at DESC, id DESC');
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, 's', $patientId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = $result ? mysqli_fetch_assoc($result) : null) {
        $displayName = $row['original_name'] ?: $row['file_name'];
        $extension = strtolower(pathinfo($displayName, PATHINFO_EXTENSION));
        $files[] = [
            'id' => (int) ($row['id'] ?? 0),
            'name' => $displayName,
            'label' => trim((string) ($row['file_label'] ?? '')),
            'stored_name' => $row['file_name'],
            'path' => $row['file_path'],
            'extension' => $extension,
            'is_image' => in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true),
            'uploaded_at' => !empty($row['uploaded_at']) ? date('M d, Y h:i a', strtotime((string) $row['uploaded_at'])) : 'Not available',
            'size_kb' => (int) ceil(((int) ($row['file_size'] ?? 0)) / 1024),
        ];
    }

    mysqli_stmt_close($stmt);

    return $files;
}

function uploadPatientFiles(mysqli $conn, array $files, string $patientId, string $fileLabel, string &$errorMessage): int
{
    $fileLabel = trim($fileLabel);

    if ($patientId === '' || empty($files['name']) || !is_array($files['name'])) {
        $errorMessage = 'Select at least one file to upload.';
        return 0;
    }

    if ($fileLabel === '') {
        $errorMessage = 'Please add a label before uploading files.';
        return 0;
    }

    if (!ensurePatientFilesTable($conn)) {
        $errorMessage = 'Unable to prepare the patient files table.';
        return 0;
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'];
    $directory = patientGalleryDirectory($patientId);
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    $uploadedCount = 0;
    $fileCount = count($files['name']);

    for ($index = 0; $index < $fileCount; $index++) {
        $errorCode = $files['error'][$index] ?? UPLOAD_ERR_NO_FILE;
        if ($errorCode === UPLOAD_ERR_NO_FILE) {
            continue;
        }

        if ($errorCode !== UPLOAD_ERR_OK) {
            $errorMessage = 'One of the files could not be uploaded.';
            continue;
        }

        $originalName = $files['name'][$index] ?? '';
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        if (!in_array($extension, $allowedExtensions, true)) {
            $errorMessage = 'Only JPG, PNG, GIF, WEBP, and PDF files are allowed.';
            continue;
        }

        $tmpName = $files['tmp_name'][$index] ?? '';
        if ($tmpName === '') {
            continue;
        }

        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        $safeBaseName = preg_replace('/[^A-Za-z0-9_-]/', '-', $baseName);
        $targetName = $safeBaseName . '-' . time() . '-' . $index . '.' . $extension;
        $targetPath = $directory . '/' . $targetName;
        $filePath = patientGalleryWebPath($patientId, $targetName);
        $fileType = $files['type'][$index] ?? '';
        $fileSize = (int) ($files['size'][$index] ?? 0);

        if (!move_uploaded_file($tmpName, $targetPath)) {
            $errorMessage = 'Unable to move one of the uploaded files.';
            continue;
        }

        $stmt = mysqli_prepare($conn, 'INSERT INTO patient_files (patient_id, file_name, original_name, file_label, file_path, file_type, file_size) VALUES (?, ?, ?, ?, ?, ?, ?)');
        if (!$stmt) {
            @unlink($targetPath);
            $errorMessage = 'Unable to save uploaded file metadata.';
            continue;
        }

        mysqli_stmt_bind_param($stmt, 'ssssssi', $patientId, $targetName, $originalName, $fileLabel, $filePath, $fileType, $fileSize);
        if (mysqli_stmt_execute($stmt)) {
            $uploadedCount++;
        } else {
            @unlink($targetPath);
            $errorMessage = 'Unable to save uploaded file metadata.';
        }
        mysqli_stmt_close($stmt);
    }

    return $uploadedCount;
}

function loadPatientForms(mysqli $conn, string $patientId): array
{
    if ($patientId === '' || !ensurePatientFormsTable($conn)) {
        return [];
    }

    $forms = [];
    $stmt = mysqli_prepare($conn, 'SELECT id, patient_id, form_type, form_date, title, content, created_at, updated_at FROM patient_forms WHERE patient_id = ? ORDER BY form_date DESC, id DESC');
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, 's', $patientId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = $result ? mysqli_fetch_assoc($result) : null) {
        $forms[] = $row;
    }

    mysqli_stmt_close($stmt);
    return $forms;
}

function savePatientForm(mysqli $conn, string $patientId, array $input, string &$errorMessage): ?int
{
    if ($patientId === '' || !ensurePatientFormsTable($conn)) {
        $errorMessage = 'Unable to prepare the patient forms table.';
        return null;
    }

    $formId = (int) ($input['form_id'] ?? 0);
    $formType = trim($input['form_type'] ?? '');
    $formDate = trim($input['form_date'] ?? '');
    $title = trim($input['title'] ?? '');
    $content = trim($input['content'] ?? '');

    if ($formType === '' || $formDate === '' || $content === '') {
        $errorMessage = 'Form type, date, and content are required.';
        return null;
    }

    if ($title === '') {
        $title = $formType;
    }

    if ($formId > 0) {
        $stmt = mysqli_prepare($conn, 'UPDATE patient_forms SET form_type = ?, form_date = ?, title = ?, content = ? WHERE id = ? AND patient_id = ?');
        if (!$stmt) {
            $errorMessage = 'Unable to prepare form update.';
            return null;
        }

        mysqli_stmt_bind_param($stmt, 'ssssis', $formType, $formDate, $title, $content, $formId, $patientId);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if (!$ok) {
            $errorMessage = 'Unable to update the form.';
            return null;
        }

        return $formId;
    }

    $stmt = mysqli_prepare($conn, 'INSERT INTO patient_forms (patient_id, form_type, form_date, title, content) VALUES (?, ?, ?, ?, ?)');
    if (!$stmt) {
        $errorMessage = 'Unable to prepare form save.';
        return null;
    }

    mysqli_stmt_bind_param($stmt, 'sssss', $patientId, $formType, $formDate, $title, $content);
    $ok = mysqli_stmt_execute($stmt);
    $newId = $ok ? (int) mysqli_insert_id($conn) : null;
    mysqli_stmt_close($stmt);

    if (!$ok) {
        $errorMessage = 'Unable to save the form.';
        return null;
    }

    return $newId;
}

function deletePatientForm(mysqli $conn, string $patientId, int $formId, string &$errorMessage): bool
{
    if ($formId <= 0 || $patientId === '' || !ensurePatientFormsTable($conn)) {
        $errorMessage = 'Unable to prepare form delete.';
        return false;
    }

    $stmt = mysqli_prepare($conn, 'DELETE FROM patient_forms WHERE id = ? AND patient_id = ?');
    if (!$stmt) {
        $errorMessage = 'Unable to prepare form delete.';
        return false;
    }

    mysqli_stmt_bind_param($stmt, 'is', $formId, $patientId);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if (!$ok) {
        $errorMessage = 'Unable to delete the form.';
        return false;
    }

    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $profileTab === 'appointments' && ($_GET['action'] ?? '') === 'appointments_calendar_json') {
    header('Content-Type: application/json; charset=UTF-8');

    if ($patientId === '') {
        http_response_code(400);
        echo json_encode(['ok' => false, 'message' => 'Missing patient id.']);
        exit();
    }

    $appointments = loadPatientAppointments($conn, $patientId);
    $events = array_map(static function (array $row): array {
        $status = (string) ($row['status'] ?? 'Pending');
        $statusColors = [
            'Pending' => '#f59e0b',
            'Confirmed' => '#3b82f6',
            'Complete' => '#10b981',
            'Cancelled' => '#ef4444',
            'No Show' => '#6b7280',
            'Rescheduled' => '#8b5cf6',
        ];

        return [
            'id' => (int) ($row['id'] ?? 0),
            'title' => trim((string) ($row['purpose_of_visit'] ?? 'Appointment')),
            'start' => !empty($row['appointment_datetime'])
                ? date('Y-m-d\\TH:i:s', strtotime((string) $row['appointment_datetime']))
                : null,
            'backgroundColor' => $statusColors[$status] ?? '#3b82f6',
            'borderColor' => $statusColors[$status] ?? '#3b82f6',
            'extendedProps' => [
                'status' => $status,
                'dentist' => (string) ($row['dentist'] ?? ''),
            ],
        ];
    }, $appointments);

    echo json_encode(['ok' => true, 'events' => $events]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $profileTab === 'photos') {
    $action = $_POST['action'] ?? '';
    if ($action === 'upload_gallery_files') {
        $uploadedCount = uploadPatientFiles($conn, $_FILES['gallery_files'] ?? [], $patientId, (string) ($_POST['file_label'] ?? ''), $profileErrorMessage);
        if ($uploadedCount > 0) {
            header('Location: photos.php?id=' . urlencode($patientId) . '&upload_status=success&upload_count=' . $uploadedCount);
            exit();
        } elseif ($profileErrorMessage === '') {
            $profileErrorMessage = 'No files were uploaded.';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $profileTab === 'forms') {
    $action = $_POST['action'] ?? '';
    if ($action === 'save_patient_form') {
        $savedId = savePatientForm($conn, $patientId, $_POST, $profileErrorMessage);
        if ($savedId !== null) {
            header('Location: forms_profile.php?id=' . urlencode($patientId) . '&form_status=success&form_id=' . $savedId);
            exit();
        }
    } elseif ($action === 'delete_patient_form') {
        $formId = (int) ($_POST['form_id'] ?? 0);
        if (deletePatientForm($conn, $patientId, $formId, $profileErrorMessage)) {
            header('Location: forms_profile.php?id=' . urlencode($patientId) . '&form_status=deleted');
            exit();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $profileTab === 'medical_history') {
    $action = $_POST['action'] ?? '';
    if ($action === 'save_patient_medical_history') {
        $isAjax = strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';
        $payload = (string) ($_POST['medical_history_payload'] ?? '');

        if (savePatientMedicalHistory($conn, $patientId, $payload, $profileErrorMessage)) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['ok' => true]);
                exit();
            }

            header('Location: medical_history.php?id=' . urlencode($patientId) . '&medical_status=success');
            exit();
        }

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['ok' => false, 'message' => $profileErrorMessage !== '' ? $profileErrorMessage : 'Unable to save medical history.']);
            exit();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $profileTab === 'appointments') {
    $action = $_POST['action'] ?? '';
    if ($action === 'save_patient_appointment') {
        $savedId = savePatientAppointment($conn, $patientId, $_POST, $profileErrorMessage);
        if ($savedId !== null) {
            header('Location: appointments_profile.php?id=' . urlencode($patientId) . '&appointment_status=success&appointment_ref=' . $savedId);
            exit();
        }
    } elseif ($action === 'delete_patient_appointment') {
        $appointmentPk = (int) ($_POST['appointment_pk'] ?? 0);
        if (deletePatientAppointment($conn, $patientId, $appointmentPk, $profileErrorMessage)) {
            header('Location: appointments_profile.php?id=' . urlencode($patientId) . '&appointment_status=deleted');
            exit();
        }
    }
}

if ($patientId !== '') {
    $stmt = mysqli_prepare($conn, 'SELECT * FROM patients WHERE id = ? LIMIT 1');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $patientId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $patient = $result ? mysqli_fetch_assoc($result) : null;
        mysqli_stmt_close($stmt);
    }
}

$uploadedFiles = loadPatientFiles($conn, $patientId);
$patientForms = loadPatientForms($conn, $patientId);
$patientAppointments = loadPatientAppointments($conn, $patientId);
$patientMedicalHistory = loadPatientMedicalHistory($conn, $patientId);

$uploadStatus = $_GET['upload_status'] ?? '';
$uploadCount = (int) ($_GET['upload_count'] ?? 0);
if ($uploadStatus === 'success' && $uploadCount > 0) {
    $profileSuccessMessage = $uploadCount . ' file(s) uploaded successfully.';
}

$formStatus = $_GET['form_status'] ?? '';
$formSavedId = (int) ($_GET['form_id'] ?? 0);
if ($formStatus === 'success' && $formSavedId > 0) {
    $profileSuccessMessage = 'Form saved successfully.';
} elseif ($formStatus === 'deleted') {
    $profileSuccessMessage = 'Form deleted successfully.';
}

$medicalStatus = $_GET['medical_status'] ?? '';
if ($medicalStatus === 'success') {
    $profileSuccessMessage = 'Medical history saved successfully.';
}

$appointmentStatus = $_GET['appointment_status'] ?? '';
if ($appointmentStatus === 'success') {
    $profileSuccessMessage = 'Appointment saved successfully.';
} elseif ($appointmentStatus === 'deleted') {
    $profileSuccessMessage = 'Appointment deleted successfully.';
}

$pageTitle = $pageTitle ?? 'DentaFlow | View Profile';
$activeNav = 'patients.php';
$pageContentFile = __DIR__ . '/partials/view-profile-content.php';

include '../includes/adminsb.php';
