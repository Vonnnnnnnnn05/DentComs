<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/conn.php';

$mailConfig = require __DIR__ . '/../../config/mail.php';

date_default_timezone_set((string) ($mailConfig['timezone'] ?? 'Asia/Manila'));

if (!($conn instanceof mysqli)) {
    fwrite(STDERR, "Database connection is not available.\n");
    exit(1);
}

function ensureReminderLogTable(mysqli $conn): bool
{
    $sql = "CREATE TABLE IF NOT EXISTS appointment_reminder_logs (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        appointment_id VARCHAR(20) NOT NULL,
        patient_id VARCHAR(50) DEFAULT NULL,
        patient_email VARCHAR(255) NOT NULL,
        reminder_type VARCHAR(50) NOT NULL DEFAULT 'day_before',
        sent_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY uniq_appointment_reminder_type (appointment_id, reminder_type),
        KEY idx_reminder_patient_id (patient_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    return mysqli_query($conn, $sql) !== false;
}

function resolveTargetDate(array $argv): DateTimeImmutable
{
    foreach ($argv as $arg) {
        if (strpos($arg, '--target-date=') === 0) {
            $dateString = substr($arg, strlen('--target-date='));
            $target = DateTimeImmutable::createFromFormat('Y-m-d', $dateString);
            if ($target instanceof DateTimeImmutable) {
                return $target;
            }

            fwrite(STDERR, "Invalid --target-date value. Use YYYY-MM-DD.\n");
            exit(1);
        }
    }

    return (new DateTimeImmutable('tomorrow'));
}

function shouldDryRun(array $argv): bool
{
    return in_array('--dry-run', $argv, true);
}

function shouldIncludeToday(array $argv): bool
{
    return in_array('--include-today', $argv, true);
}

function resolveSampleRecipient(array $argv): string
{
    foreach ($argv as $arg) {
        if (strpos($arg, '--sample-to=') === 0) {
            return trim((string) substr($arg, strlen('--sample-to=')));
        }
    }

    return '';
}

function resolveSampleSubject(array $argv): string
{
    foreach ($argv as $arg) {
        if (strpos($arg, '--sample-subject=') === 0) {
            return trim((string) substr($arg, strlen('--sample-subject=')));
        }
    }

    return '';
}

function resolveSampleMessage(array $argv): string
{
    foreach ($argv as $arg) {
        if (strpos($arg, '--sample-message=') === 0) {
            return trim((string) substr($arg, strlen('--sample-message=')));
        }
    }

    return '';
}

function buildSampleAppointment(string $sampleEmail): array
{
    $tomorrowAtNine = (new DateTimeImmutable('tomorrow 09:00'))->format('Y-m-d H:i:s');

    return [
        'appointment_id' => 'SAMPLE-' . date('YmdHis'),
        'patient_id' => '',
        'patient_name' => 'Sample Patient',
        'purpose_of_visit' => 'Teeth Cleaning',
        'dentist' => 'Dr. Demo',
        'appointment_datetime' => $tomorrowAtNine,
        'status' => 'Confirmed',
        'patient_email' => $sampleEmail,
    ];
}

function loadAppointmentsForDate(mysqli $conn, DateTimeImmutable $targetDate, string $reminderType): array
{
    $start = $targetDate->setTime(0, 0, 0)->format('Y-m-d H:i:s');
    $end = $targetDate->modify('+1 day')->setTime(0, 0, 0)->format('Y-m-d H:i:s');

    $sql = "SELECT
                a.appointment_id,
                a.patient_id,
                a.patient_name,
                a.purpose_of_visit,
                a.dentist,
                a.appointment_datetime,
                a.status,
                p.email AS patient_email
            FROM appointments a
            INNER JOIN patients p ON p.id = a.patient_id
            LEFT JOIN appointment_reminder_logs l
              ON l.appointment_id = a.appointment_id
                         AND l.reminder_type = ?
            WHERE a.appointment_datetime >= ?
              AND a.appointment_datetime < ?
              AND a.status IN ('Pending', 'Confirmed', 'Rescheduled')
              AND p.email IS NOT NULL
              AND p.email <> ''
              AND l.id IS NULL
            ORDER BY a.appointment_datetime ASC";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, 'sss', $reminderType, $start, $end);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    while ($row = $result ? mysqli_fetch_assoc($result) : null) {
        $row['reminder_type'] = $reminderType;
        $rows[] = $row;
    }

    mysqli_stmt_close($stmt);
    return $rows;
}

function buildReminderHtml(array $appointment, string $reminderType = 'day_before'): string
{
    $patientName = htmlspecialchars((string) ($appointment['patient_name'] ?? 'Patient'), ENT_QUOTES, 'UTF-8');
    $dentist = htmlspecialchars((string) ($appointment['dentist'] ?? 'Dentist'), ENT_QUOTES, 'UTF-8');
    $purpose = htmlspecialchars((string) ($appointment['purpose_of_visit'] ?? 'Dental appointment'), ENT_QUOTES, 'UTF-8');

    $dateTimeRaw = (string) ($appointment['appointment_datetime'] ?? '');
    $formattedDateTime = $dateTimeRaw !== '' ? date('F j, Y g:i A', strtotime($dateTimeRaw)) : 'Scheduled soon';
    $formattedDateTime = htmlspecialchars($formattedDateTime, ENT_QUOTES, 'UTF-8');
    $relativeLabel = $reminderType === 'same_day' ? 'today' : 'tomorrow';

    return "
        <p>Hello {$patientName},</p>
        <p>This is a friendly reminder that you have a dental appointment {$relativeLabel}.</p>
        <p><strong>Date and Time:</strong> {$formattedDateTime}<br>
        <strong>Dentist:</strong> {$dentist}<br>
        <strong>Purpose:</strong> {$purpose}</p>
        <p>If you need to reschedule, please contact the clinic as soon as possible.</p>
        <p>Thank you,<br>Dentcoms Clinic</p>
    ";
}

function sendReminderEmail(
    array $mailConfig,
    array $appointment,
    ?string $subjectOverride = null,
    ?string $htmlBodyOverride = null,
    ?string $altBodyOverride = null
): bool
{
    $toEmail = trim((string) ($appointment['patient_email'] ?? ''));
    if ($toEmail === '') {
        return false;
    }

    $dateTimeRaw = (string) ($appointment['appointment_datetime'] ?? '');
    $subjectDate = $dateTimeRaw !== '' ? date('M j, Y g:i A', strtotime($dateTimeRaw)) : 'your upcoming appointment';
    $reminderType = (string) ($appointment['reminder_type'] ?? 'day_before');
    $subjectPrefix = $reminderType === 'same_day' ? 'Dentcoms Reminder (Today)' : 'Dentcoms Reminder (Tomorrow)';
    $subject = $subjectOverride !== null && $subjectOverride !== ''
        ? $subjectOverride
        : ($subjectPrefix . ': Appointment on ' . $subjectDate);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = (string) ($mailConfig['smtp_host'] ?? '');
        $mail->Port = (int) ($mailConfig['smtp_port'] ?? 587);
        $mail->SMTPAuth = (bool) ($mailConfig['smtp_auth'] ?? true);
        $mail->Username = (string) ($mailConfig['smtp_username'] ?? '');
        $mail->Password = (string) ($mailConfig['smtp_password'] ?? '');

        $encryption = (string) ($mailConfig['smtp_encryption'] ?? 'tls');
        if ($encryption === 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } elseif ($encryption === 'tls') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }

        $mail->setFrom(
            (string) ($mailConfig['from_email'] ?? 'no-reply@dentcoms.local'),
            (string) ($mailConfig['from_name'] ?? 'Dentcoms Clinic')
        );
        $mail->addAddress($toEmail, (string) ($appointment['patient_name'] ?? 'Patient'));

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlBodyOverride !== null && $htmlBodyOverride !== ''
            ? $htmlBodyOverride
            : buildReminderHtml($appointment, $reminderType);
        $mail->AltBody = $altBodyOverride !== null && $altBodyOverride !== ''
            ? $altBodyOverride
            : ($reminderType === 'same_day'
                ? 'This is a reminder that you have an appointment today at Dentcoms Clinic.'
                : 'This is a reminder that you have an appointment tomorrow at Dentcoms Clinic.');

        return $mail->send();
    } catch (Exception $e) {
        fwrite(STDERR, 'Email send failed for ' . $toEmail . ': ' . $e->getMessage() . "\n");
        return false;
    }
}

function markReminderSent(mysqli $conn, array $appointment): void
{
    $appointmentId = (string) ($appointment['appointment_id'] ?? '');
    $patientId = (string) ($appointment['patient_id'] ?? '');
    $patientEmail = (string) ($appointment['patient_email'] ?? '');
    $type = (string) ($appointment['reminder_type'] ?? 'day_before');

    $stmt = mysqli_prepare(
        $conn,
        'INSERT INTO appointment_reminder_logs (appointment_id, patient_id, patient_email, reminder_type) VALUES (?, ?, ?, ?)'
    );

    if (!$stmt) {
        return;
    }

    mysqli_stmt_bind_param($stmt, 'ssss', $appointmentId, $patientId, $patientEmail, $type);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function buildReminderRuns(array $argv, DateTimeImmutable $targetDate): array
{
    $runs = [];
    $includeToday = shouldIncludeToday($argv);
    $today = new DateTimeImmutable('today');
    $todayKey = $today->format('Y-m-d');
    $targetKey = $targetDate->format('Y-m-d');

    if ($includeToday) {
        $runs[] = [
            'date' => $today,
            'reminder_type' => 'same_day',
        ];
    }

    if (!$includeToday || $targetKey !== $todayKey) {
        $runs[] = [
            'date' => $targetDate,
            'reminder_type' => 'day_before',
        ];
    }

    return $runs;
}

if (!ensureReminderLogTable($conn)) {
    fwrite(STDERR, "Could not create reminder log table.\n");
    exit(1);
}

$sampleRecipient = resolveSampleRecipient($argv ?? []);
$sampleSubject = resolveSampleSubject($argv ?? []);
$sampleMessage = resolveSampleMessage($argv ?? []);
$dryRun = shouldDryRun($argv ?? []);

if ($sampleRecipient !== '') {
    if (!filter_var($sampleRecipient, FILTER_VALIDATE_EMAIL)) {
        fwrite(STDERR, "Invalid --sample-to email address.\n");
        exit(1);
    }

    $sampleAppointment = buildSampleAppointment($sampleRecipient);

    if ($dryRun) {
        fwrite(STDOUT, '[DRY RUN] Would send sample reminder to ' . $sampleRecipient . "\n");
        exit(0);
    }

    $sampleMessageSafe = htmlspecialchars($sampleMessage !== '' ? $sampleMessage : 'Your appointment is Up', ENT_QUOTES, 'UTF-8');
    $sampleHtmlBody = '<p>' . nl2br($sampleMessageSafe) . '</p>';
    $subjectToUse = $sampleSubject !== '' ? $sampleSubject : 'Dentcoms Notification';

    if (sendReminderEmail($mailConfig, $sampleAppointment, $subjectToUse, $sampleHtmlBody, $sampleMessageSafe)) {
        fwrite(STDOUT, 'Sample reminder sent to ' . $sampleRecipient . "\n");
        exit(0);
    }

    fwrite(STDERR, 'Failed to send sample reminder to ' . $sampleRecipient . "\n");
    exit(1);
}

$targetDate = resolveTargetDate($argv ?? []);
$runs = buildReminderRuns($argv ?? [], $targetDate);
$appointments = [];

foreach ($runs as $run) {
    $runDate = $run['date'];
    $runType = (string) ($run['reminder_type'] ?? 'day_before');
    if (!($runDate instanceof DateTimeImmutable)) {
        continue;
    }

    $appointments = array_merge($appointments, loadAppointmentsForDate($conn, $runDate, $runType));
}

if (count($appointments) === 0) {
    fwrite(STDOUT, 'No reminders to send for the current run window.\n');
    exit(0);
}

$sentCount = 0;
$failedCount = 0;

foreach ($appointments as $appointment) {
    $email = (string) ($appointment['patient_email'] ?? '');
    $appointmentId = (string) ($appointment['appointment_id'] ?? '');
    $reminderType = (string) ($appointment['reminder_type'] ?? 'day_before');

    if ($dryRun) {
        fwrite(STDOUT, '[DRY RUN] Would send ' . $reminderType . ' reminder for appointment ' . $appointmentId . ' to ' . $email . "\n");
        continue;
    }

    if (sendReminderEmail($mailConfig, $appointment)) {
        markReminderSent($conn, $appointment);
        $sentCount++;
        fwrite(STDOUT, 'Sent reminder for appointment ' . $appointmentId . ' to ' . $email . "\n");
    } else {
        $failedCount++;
    }
}

fwrite(STDOUT, 'Done. Sent: ' . $sentCount . ', Failed: ' . $failedCount . ".\n");
