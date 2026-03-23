<?php
include '../config/sessions.php';
include '../config/conn.php';

$patientId = trim($_GET['id'] ?? '');
$patient = null;
$profileTab = $profileTab ?? 'medical_history';
$profileSuccessMessage = '';
$profileErrorMessage = '';
$uploadedFiles = [];

function patientFilesTableSql(): string
{
    return "CREATE TABLE IF NOT EXISTS patient_files (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        patient_id VARCHAR(50) NOT NULL,
        file_name VARCHAR(255) NOT NULL,
        original_name VARCHAR(255) DEFAULT NULL,
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
    return mysqli_query($conn, patientFilesTableSql()) !== false;
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
    $stmt = mysqli_prepare($conn, 'SELECT id, file_name, original_name, file_path, file_type, file_size, uploaded_at FROM patient_files WHERE patient_id = ? ORDER BY uploaded_at DESC, id DESC');
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

function uploadPatientFiles(mysqli $conn, array $files, string $patientId, string &$errorMessage): int
{
    if ($patientId === '' || empty($files['name']) || !is_array($files['name'])) {
        $errorMessage = 'Select at least one file to upload.';
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

        $stmt = mysqli_prepare($conn, 'INSERT INTO patient_files (patient_id, file_name, original_name, file_path, file_type, file_size) VALUES (?, ?, ?, ?, ?, ?)');
        if (!$stmt) {
            @unlink($targetPath);
            $errorMessage = 'Unable to save uploaded file metadata.';
            continue;
        }

        mysqli_stmt_bind_param($stmt, 'sssssi', $patientId, $targetName, $originalName, $filePath, $fileType, $fileSize);
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $profileTab === 'photos') {
    $action = $_POST['action'] ?? '';
    if ($action === 'upload_gallery_files') {
        $uploadedCount = uploadPatientFiles($conn, $_FILES['gallery_files'] ?? [], $patientId, $profileErrorMessage);
        if ($uploadedCount > 0) {
            header('Location: photos.php?id=' . urlencode($patientId) . '&upload_status=success&upload_count=' . $uploadedCount);
            exit();
        } elseif ($profileErrorMessage === '') {
            $profileErrorMessage = 'No files were uploaded.';
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

$uploadStatus = $_GET['upload_status'] ?? '';
$uploadCount = (int) ($_GET['upload_count'] ?? 0);
if ($uploadStatus === 'success' && $uploadCount > 0) {
    $profileSuccessMessage = $uploadCount . ' file(s) uploaded successfully.';
}

$pageTitle = $pageTitle ?? 'Dentcoms | View Profile';
$activeNav = 'patients.php';
$pageContentFile = __DIR__ . '/partials/view-profile-content.php';

include '../includes/adminsb.php';
