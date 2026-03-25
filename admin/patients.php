<?php
include '../config/sessions.php';
include '../config/conn.php';

$errorMessage = '';
$successMessage = '';
$activeModal = '';
$formMode = 'create';
$formValues = [];

function buildPatientId(): string
{
    try {
        return 'PT-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
    } catch (Exception $e) {
        return 'PT-' . strtoupper(substr(uniqid('', true), -8));
    }
}

function calculatePatientAge(?string $birthday): ?int
{
    if (!$birthday) {
        return null;
    }

    try {
        $birthDate = new DateTime($birthday);
        return $birthDate->diff(new DateTime('today'))->y;
    } catch (Exception $e) {
        return null;
    }
}

function normalizePatientInput(array $input): array
{
    return [
        'date_registered' => trim($input['date_registered'] ?? ''),
        'title' => trim($input['title'] ?? ''),
        'first_name' => trim($input['first_name'] ?? ''),
        'middle_name' => trim($input['middle_name'] ?? ''),
        'last_name' => trim($input['last_name'] ?? ''),
        'nickname' => trim($input['nickname'] ?? ''),
        'birthday' => trim($input['birthday'] ?? ''),
        'sex' => trim($input['sex'] ?? ''),
        'nationality' => trim($input['nationality'] ?? ''),
        'occupation' => trim($input['occupation'] ?? ''),
        'home_address' => trim($input['home_address'] ?? ''),
        'office_address' => trim($input['office_address'] ?? ''),
        'home_phone' => trim($input['home_phone'] ?? ''),
        'mobile_no' => trim($input['mobile_no'] ?? ''),
        'email' => trim($input['email'] ?? ''),
    ];
}

function patientPhotoUpload(array $file, string $patientId, string &$errorMessage, ?string $existingPhoto = null): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $existingPhoto;
    }

    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        $errorMessage = 'Unable to upload patient photo.';
        return $existingPhoto;
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $originalName = $file['name'] ?? '';
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedExtensions, true)) {
        $errorMessage = 'Patient photo must be a JPG, PNG, GIF, or WEBP file.';
        return $existingPhoto;
    }

    $uploadDirectory = dirname(__DIR__) . '/uploads/patients';
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $fileName = $patientId . '-' . time() . '.' . $extension;
    $targetFile = $uploadDirectory . '/' . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
        $errorMessage = 'Unable to move uploaded patient photo.';
        return $existingPhoto;
    }

    if ($existingPhoto) {
        $existingFile = dirname(__DIR__) . '/' . ltrim($existingPhoto, '/');
        if (is_file($existingFile)) {
            unlink($existingFile);
        }
    }

    return 'uploads/patients/' . $fileName;
}

function fetchPatientById(mysqli $conn, string $patientId): ?array
{
    $stmt = mysqli_prepare($conn, 'SELECT * FROM patients WHERE id = ? LIMIT 1');
    if (!$stmt) {
        return null;
    }

    mysqli_stmt_bind_param($stmt, 's', $patientId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $patient = $result ? mysqli_fetch_assoc($result) : null;
    mysqli_stmt_close($stmt);

    return $patient ?: null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'create';

    if ($action === 'delete') {
        $patientId = trim($_POST['patient_id'] ?? '');
        $existingPatient = fetchPatientById($conn, $patientId);

        if (!$existingPatient) {
            $errorMessage = 'Patient record not found.';
        } else {
            $deleteStmt = mysqli_prepare($conn, 'DELETE FROM patients WHERE id = ?');
            if ($deleteStmt) {
                mysqli_stmt_bind_param($deleteStmt, 's', $patientId);
                if (mysqli_stmt_execute($deleteStmt)) {
                    if (!empty($existingPatient['photo'])) {
                        $photoFile = dirname(__DIR__) . '/' . ltrim($existingPatient['photo'], '/');
                        if (is_file($photoFile)) {
                            unlink($photoFile);
                        }
                    }
                    mysqli_stmt_close($deleteStmt);
                    header('Location: patients.php?status=deleted');
                    exit();
                }
                $errorMessage = 'Unable to delete patient. ' . mysqli_error($conn);
                mysqli_stmt_close($deleteStmt);
            } else {
                $errorMessage = 'Unable to prepare delete query.';
            }
        }
    } else {
        $formMode = $action === 'update' ? 'edit' : 'create';
        $formValues = normalizePatientInput($_POST);
        if ($formMode === 'edit') {
            $formValues['patient_id'] = trim($_POST['patient_id'] ?? '');
        }

        if ($formValues['first_name'] === '' || $formValues['last_name'] === '') {
            $errorMessage = 'First name and last name are required.';
            $activeModal = 'form';
        } else {
            $patientId = $formMode === 'edit' ? trim($_POST['patient_id'] ?? '') : buildPatientId();
            $existingPatient = $formMode === 'edit' ? fetchPatientById($conn, $patientId) : null;

            if ($formMode === 'edit' && !$existingPatient) {
                $errorMessage = 'Patient record not found.';
            } else {
                $age = calculatePatientAge($formValues['birthday']);
                $photoPath = $existingPatient['photo'] ?? null;
                $photoPath = patientPhotoUpload($_FILES['photo'] ?? [], $patientId, $errorMessage, $photoPath);

                if ($errorMessage === '') {
                    if ($formMode === 'create') {
                        $sql = 'INSERT INTO patients (
                            id, date_registered, title, first_name, middle_name, last_name, nickname,
                            birthday, age, sex, nationality, occupation, home_address, office_address,
                            home_phone, mobile_no, email, photo
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                    } else {
                        $sql = 'UPDATE patients SET
                            date_registered = ?, title = ?, first_name = ?, middle_name = ?, last_name = ?, nickname = ?,
                            birthday = ?, age = ?, sex = ?, nationality = ?, occupation = ?, home_address = ?, office_address = ?,
                            home_phone = ?, mobile_no = ?, email = ?, photo = ?
                            WHERE id = ?';
                    }

                    $stmt = mysqli_prepare($conn, $sql);

                    if ($stmt) {
                        if ($formMode === 'create') {
                            mysqli_stmt_bind_param(
                                $stmt,
                                'ssssssssisssssssss',
                                $patientId,
                                $formValues['date_registered'],
                                $formValues['title'],
                                $formValues['first_name'],
                                $formValues['middle_name'],
                                $formValues['last_name'],
                                $formValues['nickname'],
                                $formValues['birthday'],
                                $age,
                                $formValues['sex'],
                                $formValues['nationality'],
                                $formValues['occupation'],
                                $formValues['home_address'],
                                $formValues['office_address'],
                                $formValues['home_phone'],
                                $formValues['mobile_no'],
                                $formValues['email'],
                                $photoPath
                            );
                        } else {
                            mysqli_stmt_bind_param(
                                $stmt,
                                'sssssssissssssssss',
                                $formValues['date_registered'],
                                $formValues['title'],
                                $formValues['first_name'],
                                $formValues['middle_name'],
                                $formValues['last_name'],
                                $formValues['nickname'],
                                $formValues['birthday'],
                                $age,
                                $formValues['sex'],
                                $formValues['nationality'],
                                $formValues['occupation'],
                                $formValues['home_address'],
                                $formValues['office_address'],
                                $formValues['home_phone'],
                                $formValues['mobile_no'],
                                $formValues['email'],
                                $photoPath,
                                $patientId
                            );
                        }

                        if (mysqli_stmt_execute($stmt)) {
                            mysqli_stmt_close($stmt);
                            header('Location: patients.php?status=' . ($formMode === 'create' ? 'created' : 'updated'));
                            exit();
                        }

                        $errorMessage = 'Unable to save patient. ' . mysqli_error($conn);
                        mysqli_stmt_close($stmt);
                    } else {
                        $errorMessage = 'Unable to prepare patient query.';
                    }
                }
            }

            if ($errorMessage !== '') {
                $activeModal = 'form';
            }
        }
    }
}

$patients = [];
$patientsSql = 'SELECT id, date_registered, title, first_name, middle_name, last_name, nickname, birthday, age, sex, nationality, occupation, home_address, office_address, home_phone, mobile_no, email, photo, created_at FROM patients ORDER BY created_at DESC';
$patientsResult = mysqli_query($conn, $patientsSql);

if ($patientsResult) {
    while ($row = mysqli_fetch_assoc($patientsResult)) {
        $patients[] = $row;
    }
}

$status = $_GET['status'] ?? '';
if ($status === 'created') {
    $successMessage = 'Patient record added successfully.';
} elseif ($status === 'updated') {
    $successMessage = 'Patient record updated successfully.';
} elseif ($status === 'deleted') {
    $successMessage = 'Patient record deleted successfully.';
}

$pageTitle = 'Dentcoms | Patients';
$pageContentFile = __DIR__ . '/partials/patients-content.php';

include '../includes/adminsb.php';
